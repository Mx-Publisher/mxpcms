<?php
/**
*
* @package Auth
* @version $Id: core.php,v 1.1 2014/09/15 21:14:56 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

//
// First off, include common vanilla phpBB functions, from our shared dir
// Note: These functions will later be accessible wrapped as phpBBX::orig_functionname()
//
include_once($mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx);
include_once($mx_root_path . 'includes/shared/phpbb3/includes/functions.' . $phpEx);

/*
* Instantiate Dummy phpBB Classes
*/
$phpBB2 = new phpBB2();
$phpBB3 = new phpBB3();

//
// Finally, load some backend specific functions
//
include_once($mx_root_path . 'includes/sessions/ascraeus/functions.' . $phpEx);

//
// phpBB Permissions
//
include_once($mx_root_path . 'includes/sessions/ascraeus/auth.' . $phpEx);

/**
* Permission/Auth class
*
* @package MX-Publisher
*
*/
class phpbb_auth extends phpbb_auth_base
{
	/**
 	* get_auth_forum
 	*
 	* @param unknown_type $mode
 	* @return unknown
 	*/
	function get_auth_forum($mode = 'phpbb')
	{
		global $userdata, $mx_root_path, $phpEx;
		static $auth_data_sql;
		//
		// Try to reuse auth_view query result.
		//
		$userdata_key = 'mx_get_auth_' . $mode . $userdata['user_id'];
		if( !empty($userdata[$userdata_key]) )
		{
			$auth_data_sql = $userdata[$userdata_key];
			return $auth_data_sql;
		}
		//
		// Now, this tries to optimize DB access involved in auth(),
		// passing AUTH_LIST_ALL will load info for all forums at once.
		// Start auth check
		if (!$is_auth_ary = $this->acl_getf('f_read', false))
		{
			if ($user->data['user_id'] != ANONYMOUS)
			{
				//trigger_error('SORRY_AUTH_READ');
				$auth_data_sql = false;
			}
			//login_box('', $user->lang['LOGIN_VIEWFORUM']);
			$auth_data_sql = $this->acl_getf_global('m_');			
		}
		//
		// Loop through the list of forums to retrieve the ids for
		// those with AUTH_VIEW allowed.
		//
		foreach( $is_auth_ary as $fid => $is_auth_row )
		{
			if( ($is_auth_row['f_read']) )
			{
				$auth_data_sql .= ( $auth_data_sql != '' ) ? ', ' . $fid : $fid;
			}
		}
		if( empty($auth_data_sql) )
		{
			$auth_data_sql = 0;			
		}
		$userdata[$userdata_key] = $auth_data_sql;
		return $auth_data_sql;
	}

	/**
	* function acl_getfignore()
	* $auth_level_read can be a value or array;
	* $ignore_forum_ids can have this sintax: forum_id(1), forum_id(2), ..., forum_is(n);
	* 1st test 25.06.2008 by FlorinCB
	 */
	function acl_getfignore($auth_level_read, $ignore_forum_ids)
	{
		global $phpbb_root_path, $mx_user;

		$ignore_forum_ids = ($ignore_forum_ids) ? $ignore_forum_ids : '';

		$auth_user = array();

		if (is_array($auth_level_read))
		{
			foreach ($auth_level_read as $auth_level)
			{
				$auth_user = $this->acl_getf('!' . $auth_level, true);

				if ($num_forums = count($auth_user))
				{
					while ( list($forum_id, $auth_mod) = each($auth_user) )
					{
						$unauthed = false;

						if (!$auth_mod[$auth_level] && ( strstr($ignore_forum_ids,$auth_mod['forum_id']) === FALSE))
						{
							$unauthed = true;
						}

						if ($unauthed)
						{
							$ignore_forum_ids .= ($ignore_forum_ids) ? ',' . $forum_id : $forum_id;
						}
					}
				}
				unset($auth_level_read);
			}
		}
		elseif ($auth_level_read)
		{
			$auth_user = $this->acl_getf('!' . $auth_level_read, true);

			if ($num_forums = count($auth_user))
			{
				while ( list($forum_id, $auth_mod) = each($auth_user) )
				{
					$unauthed = false;

					if (!$auth_mod[$auth_level] && ( strstr($ignore_forum_ids,$auth_mod['forum_id']) === FALSE))
					{
						$unauthed = true;
					}

					if ($unauthed)
					{
						$ignore_forum_ids .= ($ignore_forum_ids) ? ',' . $forum_id : $forum_id;
					}
				}
			}

		}
		$ignore_forum_ids = ($ignore_forum_ids) ? $ignore_forum_ids : 0;
		return $ignore_forum_ids;
	}
}

//
// Init the phpbb_auth class
//
$phpbb_auth = new phpbb_auth();

/**
* Backend specific tasks
* @package MX-Publisher
*/
class mx_backend
{
	//
	// XS Template - use backend db settings
	//
	var $edit_db = true;

	/**
	 * Validate backend
	 *
	 * Define Users/Group/Sessions backend, and validate
	 * Set $phpbb_root_path, $tplEx, $table_prefix
	 *
	 */
	function validate_backend()
	{
		global $db, $portal_config, $phpbb_root_path, $mx_root_path;
		global $table_prefix, $phpEx, $tplEx;
		
		$table_prefix = false;
		$tplEx = 'html';		
		// Define relative path to phpBB, and validate
		$phpbb_root_path = $mx_root_path . $portal_config['portal_backend_path'];
		str_replace("//", "/", $phpbb_root_path);
		$portal_backend_valid_file = @file_exists($phpbb_root_path . "mcp.$phpEx");
		
		// Load phpbb config.php (to get table prefix)
		if ((include $phpbb_root_path . "config.$phpEx") === false)
		{
			die('Configuration file (config) ' . $phpbb_root_path . "config.$phpEx" . ' couldn\'t be opened.');
		}
	
		// Validate db connection for backend
		$_result = $db->sql_query("SELECT config_value from " . $table_prefix . "config WHERE config_name = 'cookie_domain'");
		$portal_backend_valid_db = $db->sql_numrows($_result) != 0;
		
		return $portal_backend_valid_file && !empty($table_prefix) && $portal_backend_valid_db;
	}

	/**
	 * setup_backend
	 *
	 * Define some general backend definitions
	 * PORTAL_URL, PHPBB_URL, PORTAL_VERSION & $board_config
	 *
	 */
	function setup_backend()
	{
		global $portal_config, $board_config, $phpbb_root_path, $phpEx;
		
		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($portal_config['script_path']));
		$server_name = trim($portal_config['server_name']);
		$server_protocol = ( $portal_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = (($portal_config['server_port']) && ($portal_config['server_port'] <> 80)) ? ':' . trim($portal_config['server_port']) . '/' : '/';

		$server_url = $server_protocol . str_replace("//", "/", $server_name . $server_port . $script_name . '/'); //On some server the slash is not added and this trick will fix it

		define('PORTAL_URL', $server_url);
		define('PORTAL_VERSION', $portal_config['portal_version']);

		//
		// Grab phpBB global variables, re-cache if necessary
		// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the MX-Publisher cache whenever updating phpBB config settings
		// - true: enable cache, false: disable cache
		$board_config = $this->obtain_phpbb_config(false);
		$script_name_phpbb = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])) . '/';

		$server_url_phpbb = $server_protocol . $server_name . $server_port . $script_name_phpbb;
		define('PHPBB_URL', $server_url_phpbb);
		
		// Define backend template extension
		$tplEx = 'html';
		if (!defined('TPL_EXT')) define('TPL_EXT', $tplEx);	
		//
		// Now sync Configs
		// In phpBB mode, we rely on native phpBB configs, thus we need to sync mxp and phpbb settings
		//
		$this->sync_configs();
	}

	/**
	 * Sync Configs
	 * @access private
	 */
	function sync_configs()
	{
		global $portal_config, $board_config;

		foreach ($portal_config as $key => $value)
		{
			$do = true;
			switch ($key)
			{
				//
				// Keep phpBB cookies/sessions
				//
				case 'cookie_domain':
				case 'cookie_name':
				case 'cookie_path':
				case 'cookie_secure':
				case 'session_length':
				case 'allow_autologin':
				case 'max_autologin_time':
				case 'max_login_attempts':
				case 'login_reset_time':

					$do = false;
					break;

				//
				// Keep phpBB stats
				//
				case 'record_online_users':
				case 'record_online_date':

					$do = false;
					break;

				//
				// Keep portal settings
				//
				case 'default_style':
				case 'override_user_style':
				case 'default_lang':

				//
				// Keep portal settings
				//
				case 'allow_html':
				case 'allow_html_tags':
				case 'allow_bbcode':
				case 'allow_smilies':
				case 'smilies_path':

				//
				// Keep portal settings
				//
				case 'board_email':
				case 'board_email_sig':
				case 'smtp_delivery':
				case 'smtp_host':
				case 'smtp_username':
				case 'smtp_password':
				case 'smtp_auth_method':

				//
				// Keep portal settings
				//
				case 'default_dateformat':
				case 'board_timezone':
				case 'gzip_compress':

				//
				// Keep portal settings
				//
				case 'portal_id':
				case 'portal_status':
				case 'disabled_message':
				case 'script_path':
				case 'mx_use_cache':
				case 'mod_rewrite':
				case 'default_admin_style':
				case 'overall_header':
				case 'overall_footer':
				case 'main_layout':
				case 'navigation_block':
				case 'top_phpbb_links':
				case 'portal_version':
				case 'portal_recached':
				case 'portal_backend':
				case 'portal_startdate':
				case 'rand_seed':

					break;

				// Rename config keys and get internal sitename/sitedesc
				case 'portal_name':

					$key = 'sitename';
					break;

				case 'portal_desc':

					$key = 'site_desc';
					break;
			}

			if ($do)
			{
				$board_config[$key] = $value;
			}
		}
	}

	/**
	 * load_file
	 *
	 * @param unknown_type $force_shared
	 * @access private
	 */
	function load_file($force_shared)
	{
		global $mx_root_path, $phpbb_root_path, $phpEx;

		if ($force_shared)
		{
			$backend = in_array($force_shared, array('internal', 'phpbb2', 'phpbb3')) ? $force_shared : PORTAL_BACKEND;
			switch ($backend)
			{
				case 'internal':
				case 'phpbb2':
				case 'smf2':
				case 'mybb':
					$path = $mx_root_path . 'includes/shared/phpbb2/includes/';
				break;
					
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
					$path = $mx_root_path . 'includes/shared/phpbb3/includes/';
				break;
			}
		}
		else
		{
			$path = $phpbb_root_path . 'includes/';
		}
		return $path;
	}

	/**
	 * dss_rand
	 *
	 * @param unknown_type $force_shared
	 * @access private
	 */
	function dss_rand()
	{
		global $db, $portal_config, $board_config, $dss_seeded;
		
		$val = $board_config['rand_seed'] . microtime();
		$val = md5($val);
		$board_config['rand_seed'] = md5($board_config['rand_seed'] . $val . 'a');
		
		if($dss_seeded !== true)
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . $board_config['rand_seed'] . "'
				WHERE config_name = 'rand_seed'";
			//display an error debuging message only if the portal is installed/upgraded 
			if(!@$db->sql_query($sql) && @!file_exists('install'))
			{
				mx_message_die(GENERAL_ERROR, "Unable to reseed PRNG", "", __LINE__, __FILE__, $sql);
			}
			elseif(!@$db->sql_query($sql) && @file_exists('install'))
			{
				mx_message_die(GENERAL_ERROR, "Unable to reseed PRNG"."<br />Please finish upgrading and <br />". t(isset($lang['Please_remove_install_contrib'])), "", __LINE__, __FILE__, $sql);
			}
			$dss_seeded = true;
		}
		return substr($val, 4, 16);
	}

	function make_jumpbox($action, $match_forum_id = 0)
	{
		global $template, $userdata, $lang, $db, $nav_links, $phpEx, $SID;

		$sql = 'SELECT forum_id, forum_name, parent_id, forum_type, left_id, right_id
			FROM ' . FORUMS_TABLE . '
			ORDER BY left_id ASC';
		$result = $db->sql_query($sql, 600);

		$right = $padding = 0;
		$padding_store = array('0' => 0);
		$display_jumpbox = false;
		$iteration = 0;

		// Sometimes it could happen that forums will be displayed here not be displayed within the index page
		// This is the result of forums not displayed at index, having list permissions and a parent of a forum with no permissions.
		// If this happens, the padding could be "broken"

		$forum_rows = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$forum_rows[] = $row;

			if ($forum_rows['left_id'] < $right)
			{
				$padding++;
				$padding_store[$row['parent_id']] = $padding;
			}
			else if ($row['left_id'] > $right + 1)
			{
				// Ok, if the $padding_store for this parent is empty there is something wrong. For now we will skip over it.
				// @todo digging deep to find out "how" this can happen.
				$padding = (isset($padding_store[$row['parent_id']])) ? $padding_store[$row['parent_id']] : $padding;
			}

			$right = $forum_rows['right_id'];

			if ($forum_rows['forum_type'] == FORUM_CAT && ($forum_rows['left_id'] + 1 == $forum_rows['right_id']))
			{
				// Non-postable forum with no subforums, don't display
				continue;
			}

			if ( $total_forums = count($forum_rows) )
			{
				for($i = 0; $i < $total_categories; $i++)
				{
					$boxstring_forums = '';
					for($j = 0; $j < $total_forums; $j++)
					{
					 	$selected = ( $forum_rows[$j]['forum_id'] == $match_forum_id ) ? 'selected="selected"' : '';
						$boxstring_forums .=  '<option value="' . $forum_rows[$j]['forum_id'] . '"' . $selected . '>' . $forum_rows[$j]['forum_name'] . '</option>';

						//
						// Add an array to $nav_links for the Mozilla navigation bar.
						// 'chapter' and 'forum' can create multiple items, therefore we are using a nested array.
						//
						$nav_links['chapter forum'][$forum_rows[$j]['forum_id']] = array (
							'url' => mx_append_sid(PHPBB_URL . "viewforum.$phpEx?" . POST_FORUM_URL . "=" . $forum_rows[$j]['forum_id']),
							'title' => $forum_rows[$j]['forum_name']
						);

					}

					if ( $boxstring_forums != '' )
					{
						$boxstring .= '<option value="-1">&nbsp;</option>';
						$boxstring .= '<option value="-1">' . $forum_rows[$i]['forum_type'] == FORUM_CAT . '</option>';
						$boxstring .= '<option value="-1">----------------</option>';
						$boxstring .= $boxstring_forums;
					}
				}
			}

			$boxstring .= '</select>';
		}

		// Let the jumpbox work again in sites having additional session id checks.
		// if ( !empty($SID) )
		// {
				$boxstring .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
		// }

		$template->set_filenames(array(
			'jumpbox' => 'jumpbox.tpl')
		);

		$template->assign_vars(array(
			'L_GO' => $lang['Go'],
			'L_JUMP_TO' => $lang['Jump_to'],
			'L_SELECT_FORUM' => $lang['Select_forum'],

			'S_JUMPBOX_SELECT' => $boxstring,
			'S_JUMPBOX_ACTION' => mx_append_sid($action),
			'S_FORUM_COUNT'	=> $j)
		);

		$template->assign_var_from_handle('JUMPBOX', 'jumpbox');

		return;
	}

	/**
	 * Backend specific Page Header data
	 *
	 * @param unknown_type $mode
	 */
	function page_header($mode = false)
	{
		global $db, $mx_root_path, $phpbb_root_path, $userdata, $mx_user, $lang, $images, $phpEx, $board_config, $gen_simple_header, $layouttemplate, $mx_page;

		switch ($mode)
		{
			case 'generate_login_logout_stats':

				if ( $mx_user->data['user_id'] != 1 )
				{
					$is_logged = true;
					$u_login_logout = 'login.'.$phpEx.'?logout=true&amp;sid=' . $mx_user->data['session_id'];
					$l_login_logout = $lang['Logout'] . ' [ ' . $mx_user->data['username'] . ' ]';
				}
				else
				{
					$is_logged = false;
					$u_login_logout = 'login.'.$phpEx;
					$l_login_logout = $lang['Login'];
				}
				$s_last_visit = ( $mx_user->data['session_logged_in'] ) ? phpBB2::create_date($board_config['default_dateformat'], $mx_user->data['user_lastvisit'], $board_config['board_timezone']) : '';

				//
				// Obtain number of new private messages
				// if user is logged in
				//
				if ( ($mx_user->data['session_logged_in']) && (empty($gen_simple_header)) )
				{
					if ( $mx_user->data['user_new_privmsg'] )
					{
						$l_message_new = ( $mx_user->data['user_new_privmsg'] == 1 ) ? $lang['New_pm'] : $lang['New_pms'];
						$l_privmsgs_text = sprintf($l_message_new, $mx_user->data['user_new_privmsg']);

						if ( $mx_user->data['user_last_privmsg'] > $mx_user->data['user_lastvisit'] )
						{
							$sql = "UPDATE " . USERS_TABLE . "
								SET user_last_privmsg = " . $mx_user->data['user_lastvisit'] . "
								WHERE user_id = " . $mx_user->data['user_id'];
							if ( !$db->sql_query($sql) )
							{
								mx_message_die(GENERAL_ERROR, 'Could not update private message new/read time for user', '', __LINE__, __FILE__, $sql);
							}

							$s_privmsg_new = 1;
							$icon_pm = $images['pm_new_msg'];
						}
						else
						{
							$s_privmsg_new = 0;
							$icon_pm = $images['pm_no_new_msg'];
						}
						$mx_priv_msg = $lang['Private_Messages'] . ' (' . $mx_user->data['user_new_privmsg'] . ')';
					}
					else
					{
						$l_privmsgs_text = $lang['No_new_pm'];

						$s_privmsg_new = 0;
						$icon_pm = $images['pm_no_new_msg'];
						$mx_priv_msg = $lang['Private_Messages'];
					}

					if ( $mx_user->data['user_unread_privmsg'] )
					{
						$l_message_unread = ( $mx_user->data['user_unread_privmsg'] == 1 ) ? $lang['Unread_pm'] : $lang['Unread_pms'];
						$l_privmsgs_text_unread = sprintf($l_message_unread, $mx_user->data['user_unread_privmsg']);
					}
					else
					{
						$l_privmsgs_text_unread = $lang['No_unread_pm'];
					}
				}
				else
				{
					$icon_pm = $images['pm_no_new_msg'];
					$l_privmsgs_text = $lang['Login_check_pm'];
					$l_privmsgs_text_unread = '';
					$s_privmsg_new = 0;
					$mx_priv_msg = $lang['Private_Messages'];
				}

				$layouttemplate->assign_vars(array(
					'U_LOGIN_LOGOUT' => mx_append_sid(PORTAL_URL . $u_login_logout),
					'L_LOGIN_LOGOUT' => $l_login_logout,
					'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], $s_last_visit),
					'PRIVATE_MESSAGE_INFO' => $l_privmsgs_text,
					'PRIVATE_MESSAGE_INFO_UNREAD' => $l_privmsgs_text_unread,
					'PRIVATE_MESSAGE_NEW_FLAG' => $s_privmsg_new,
					'PRIVMSG_IMG' => $icon_pm,
					'L_PRIVATEMSGS' => $mx_priv_msg,

					// Backend
					'PHPBB' => true,

					// Show phpbb stats?
					'PHPBB_STATS' => $mx_page->phpbb_stats,

					// Allow autologin?
					'ALLOW_AUTOLOGIN' => !$userdata['session_logged_in'] && (!isset($board_config['allow_autologin']) || $board_config['allow_autologin']),

					// phpBB PM
					'ENABLE_PM_POPUP' => $userdata['session_logged_in'] && !empty($userdata['user_popup_pm']),
				));

				break;

			case 'generate_nav_links':

				$u_register = 'ucp.'.$phpEx.'?mode=register';
				$u_profile = 'ucp.'.$phpEx;
				$u_privatemsgs = 'ucp.'.$phpEx.'?i=pm&folder=inbox';
				$u_privatemsgs_popup ='ucp.'.$phpEx.'?i=pm&mode=popup';
				$u_search = 'search.'.$phpEx;
				$u_memberlist = 'memberlist.'.$phpEx;
				$u_modcp = 'mcp.'.$phpEx;
				$u_faq = 'faq.'.$phpEx;
				$u_viewonline = 'viewonline.'.$phpEx;
				$u_group_cp = 'ucp.'.$phpEx.'?i=167';
				$u_sendpassword = ($board_config['email_enable']) ? mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=sendpassword') : '';

				$layouttemplate->assign_vars(array(
					'U_REGISTER' => mx_append_sid(PHPBB_URL . $u_register),
					'U_PROFILE' => mx_append_sid(PHPBB_URL . $u_profile),
					'U_PRIVATEMSGS' => mx_append_sid(PHPBB_URL . $u_privatemsgs),
					'U_PRIVATEMSGS_POPUP' => mx_append_sid(PHPBB_URL . $u_privatemsgs_popup),
					'U_SEARCH' => mx_append_sid(PHPBB_URL . $u_search),
					'U_MEMBERLIST' =>mx_append_sid(PHPBB_URL . $u_memberlist),
					'U_MODCP' => mx_append_sid(PHPBB_URL . $u_modcp),
					'U_FAQ' => mx_append_sid(PHPBB_URL . $u_faq),
					'U_VIEWONLINE' => mx_append_sid(PHPBB_URL . $u_viewonline),
					'U_GROUP_CP' => mx_append_sid(PHPBB_URL . $u_group_cp),
					'U_SEND_PASSWORD' => $u_sendpassword,
				));

				break;
		}
	}

	/**
	 * Backend specific Page Tail data
	 *
	 * @param unknown_type $mode
	 */
	function page_tail($mode = false)
	{
		global $board_config, $userdata, $template;

		switch ($mode)
		{
			case 'generate_backend_version':
				$current_phpbb_version = $board_config['version'];

				$template->assign_vars(array(
					'PHPBB_BACKEND'				=> true,
					'PHPBB_VERSION' 			=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? $current_phpbb_version : '',
					'U_PHPBB_ROOT_PATH' 		=> PHPBB_URL,
				));

				break;
		}
	}

	/**
	 * obtain_phpbb_config
	 *
	 * @access public
	 * @param boolean $use_cache
	 * @return unknown
	 */
	public function obtain_forum_config()
	{
		global $db, $mx_cache, $phpEx;		
		
		if (!defined('CONFIG_TABLE'))
		{
			global $table_prefix, $mx_root_path;
				
			require $mx_root_path. "includes/sessions/phpbb2/constants.$phpEx";
		}		
		
		if (($mx_cache->get('phpbb_config')) === false)
		{
			$config = $cached_config = array();
								
			$sql = 'SELECT config_name, config_value, is_dynamic
				FROM ' . CONFIG_TABLE;
			if (!($result = $db->sql_query($sql)))
			{
				if (!function_exists('mx_message_die'))
				{
					die("Couldnt query config information, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
				}
				else
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt query config information', '', __LINE__, __FILE__, $sql );
				}
			}
			
			while ($row = $db->sql_fetchrow($result))
			{
				if (!$row['is_dynamic'])
				{
					$cached_config[$row['config_name']] = $row['config_value'];
				}				

				$config[$row['config_name']] = $row['config_value'];
			}
			$db->sql_freeresult($result);

			$mx_cache->put('phpbb_config', $cached_config);
		}
		else
		{
			$sql = 'SELECT config_name, config_value
				FROM ' . CONFIG_TABLE . '
				WHERE is_dynamic = 1';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$config[$row['config_name']] = $row['config_value'];
			}
			$db->sql_freeresult($result);
		}		
		
		return $config;
	}
	
	/**
	* Set phpbb config values
	 *
	 * @param unknown_type $config_name
	 * @param unknown_type $config_value
	 */
	public function set_forum_config($key, $new_value, $use_cache = false)
	{
		global $db, $mx_cache, $phpEx;		
		
		if (!defined('CONFIG_TABLE'))
		{
			global $table_prefix, $mx_root_path;
				
			require $mx_root_path. "includes/sessions/phpbb2/constants.$phpEx";
		}		
		
		// Read out config values
		$config = $this->obtain_phpbb_config();
		$old_value = !isset($config[$key]) ? $config[$key] : false;		
		$use_cache = (($key == 'comments_pagination') || ($key == 'pagination')) ? true : false;
			
		$sql = 'UPDATE ' . CONFIG_TABLE . "
			SET config_value = '" . $db->sql_escape($new_value) . "'
			WHERE config_name = '" . $db->sql_escape($key) . "'";

		if ($old_value !== false)
		{
			$sql .= " AND config_value = '" . $db->sql_escape($old_value) . "'";
		}

		$db->sql_query($sql);

		if (!$db->sql_affectedrows() && isset($config[$key]))
		{
			return false;
		}

		if (!isset($config[$key]))
		{
			$sql = 'INSERT INTO ' . CONFIG_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				'config_name'	=> $key,
				'config_value'	=> $new_value)),
				'is_dynamic'	=> ($use_cache) ? 0 : 1));
			$db->sql_query($sql);
		}
		
		$config[$key] = $new_value;

		
		if ($use_cache)
		{
			$mx_cache->destroy('config');
			$mx_cache->put('config', $config);			
		}
		
		return true;		
	}	
	
	/**
	 * Get MX-Publisher config data
	 *
	 * @access public
	 * @return unknown
	 */
	public function obtain_portal_config($use_cache = true)
	{
		global $db, $mx_cache;

		if ( ($portal_config = $mx_cache->get('mx_config')) && ($use_cache) )
		{
			return $portal_config;
		}
		else
		{
			$sql = "SELECT *
				FROM " . PORTAL_TABLE . "
				WHERE portal_id = '1'";

			if ( !($result = $db->sql_query($sql)) )
			{
				if (!function_exists('mx_message_die'))
				{
					die("Couldnt query portal configuration, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
				}
				else
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt query portal configuration', '', __LINE__, __FILE__, $sql );
				}
			}
			$row = $db->sql_fetchrow($result);
			foreach ($row as $config_name => $config_value)
			{
				$portal_config[$config_name] = trim($config_value);
			}
			$db->sql_freeresult($result);
			$mx_cache->put('mx_config', $portal_config);

			return ($portal_config);
		}
	}
	
	/**
	* Set config value. Creates missing config entry.
	*
	*/
	function set_portal_config($key, $new_value)
	{
		global $db, $mx_cache, $portal_config;
		
		// Read out config values
		$portal_config = $this->obtain_portal_config();		
		
		$new[$key] = $new_value;

		$sql = "UPDATE  " . PORTAL_TABLE . " SET " . $db->sql_build_array('UPDATE', utf8_normalize_nfc($new));
		
		if( !($db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Failed to update portal configuration ", "", __LINE__, __FILE__, $sql);
		}
		
		if (!$db->sql_affectedrows() && !isset($portal_config[$key]))
		{
			$sql = 'INSERT INTO ' . PORTAL_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				$db->sql_escape($key) => $db->sql_escape($new_value)));
			$db->sql_query($sql);
		}

		$portal_config[$key] = $new_value;

		$mx_cache->destroy('mx_config');
	}	
	
	/**
	 * Get userdata
	 *
	 * Get Userdata, $mx_user can be username or user_id. If force_str is true, the username will be forced.
	 * Cached sql, since this function is used for every block.
	 *
	 * @param unknown_type $mx_user id or name
	 * @param boolean $force_str force clean_username
	 * @return array
	 */
	function get_userdata($mxuser, $force_str = false)
	{
		global $db, $phpBB2;

		if (!is_numeric($mxuser) || $force_str)
		{
			$mx_user = $phpBB2->phpbb_clean_username($mxuser);
		}
		else
		{
			$mx_user = intval($mxuser);
		}

		$sql = "SELECT *
			FROM " . USERS_TABLE . "
			WHERE ";
		$sql .= ((is_integer($mxuser)) ? "user_id = $mxuser" : "username = '" .  str_replace("\'", "''", $mxuser) . "'" ) . " AND user_id <> " . ANONYMOUS;
		if (!($result = $db->sql_query($sql, 120)))
		{
			if (!function_exists('mx_message_die'))
			{
				die("Tried obtaining data for a non-existent user. Function mx_backend->get_userdata()");
			}
			else
			{
				mx_message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
			}
		}
		$return = ($row = $db->sql_fetchrow($result)) ? $row : false;
		/*
		foreach ($row as $user_key => $user_value)
		{
			$userdata[$user_key] = trim($user_value);
		}
		*/
		$db->sql_freeresult($result);
		//return ($userdata);			
		return $return;
	}	
	
	/**
	* Set user data value. 
	*
	*/
	function set_userdata($key, $new_value)
	{
		global $db, $mx_user;
						
		$new[$key] = $new_value;

		$sql = "UPDATE " . USERS_TABLE . "
		SET " . $db->sql_build_array('UPDATE', utf8_normalize_nfc($new)) . "
		WHERE user_id = '" . $mx_user->data['user_id'] . "'";		
		if (!($db->sql_query($sql)))
		{
			mx_message_die(GENERAL_ERROR, "Failed to update portal configuration ", "", __LINE__, __FILE__, $sql);
		}
		
		if (!$db->sql_affectedrows() && !isset($mx_user->data[$key]))
		{
			mx_message_die(GENERAL_ERROR, "Wrong Backend? Adding missing entry key to update MXP configuration  is not supported ATM.", "", __LINE__, __FILE__, $sql);	
		}
		$mx_user->data[$key] = $new_value;
	}	
	
	/**
	* Obtain ranks
	*/
	public function obtain_ranks()
	{
		global $mx_cache;

		if (($ranks = $mx_cache->get('_ranks')) === false)
		{
			global $db;

			$sql = 'SELECT *
				FROM ' . RANKS_TABLE . '
				ORDER BY rank_min DESC';
			$result = $db->sql_query($sql);

			$ranks = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if ($row['rank_special'])
				{
					$ranks['special'][$row['rank_id']] = array(
						'rank_title'	=>	$row['rank_title'],
						'rank_image'	=>	$row['rank_image']
					);
				}
				else
				{
					$ranks['normal'][] = array(
						'rank_title'	=>	$row['rank_title'],
						'rank_min'		=>	$row['rank_min'],
						'rank_image'	=>	$row['rank_image']
					);
				}
			}
			$db->sql_freeresult($result);

			$mx_cache->put('_ranks', $ranks);
		}

		return $ranks;
	}

	/**
	* Obtain allowed extensions
	*
	* @param mixed $forum_id If false then check for private messaging, if int then check for forum id. If true, then only return extension informations.
	*
	* @return array allowed extensions array.
	*/
	function obtain_attach_extensions($forum_id)
	{
		global $mx_cache;

		if (($extensions = $mx_cache->get('_extensions')) === false)
		{
			global $db;

			$extensions = array(
				'_allowed_post'	=> array(),
				'_allowed_pm'	=> array(),
			);

			// The rule is to only allow those extensions defined. ;)
			$sql = 'SELECT e.extension, g.*
				FROM ' . EXTENSIONS_TABLE . ' e, ' . EXTENSION_GROUPS_TABLE . ' g
				WHERE e.group_id = g.group_id
					AND (g.allow_group = 1 OR g.allow_in_pm = 1)';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$extension = strtolower(trim($row['extension']));

				$extensions[$extension] = array(
					'display_cat'	=> (int) $row['cat_id'],
					'download_mode'	=> (int) $row['download_mode'],
					'upload_icon'	=> trim($row['upload_icon']),
					'max_filesize'	=> (int) $row['max_filesize'],
					'allow_group'	=> $row['allow_group'],
					'allow_in_pm'	=> $row['allow_in_pm'],
				);

				$allowed_forums = ($row['allowed_forums']) ? unserialize(trim($row['allowed_forums'])) : array();

				// Store allowed extensions forum wise
				if ($row['allow_group'])
				{
					$extensions['_allowed_post'][$extension] = (!sizeof($allowed_forums)) ? 0 : $allowed_forums;
				}

				if ($row['allow_in_pm'])
				{
					$extensions['_allowed_pm'][$extension] = 0;
				}
			}
			$db->sql_freeresult($result);

			$mx_cache->put('_extensions', $extensions);
		}

		// Forum post
		if ($forum_id === false)
		{
			// We are checking for private messages, therefore we only need to get the pm extensions...
			$return = array('_allowed_' => array());

			foreach ($extensions['_allowed_pm'] as $extension => $check)
			{
				$return['_allowed_'][$extension] = 0;
				$return[$extension] = $extensions[$extension];
			}

			$extensions = $return;
		}
		else if ($forum_id === true)
		{
			return $extensions;
		}
		else
		{
			$forum_id = (int) $forum_id;
			$return = array('_allowed_' => array());

			foreach ($extensions['_allowed_post'] as $extension => $check)
			{
				// Check for allowed forums
				if (is_array($check))
				{
					$allowed = (!in_array($forum_id, $check)) ? false : true;
				}
				else
				{
					$allowed = true;
				}

				if ($allowed)
				{
					$return['_allowed_'][$extension] = 0;
					$return[$extension] = $extensions[$extension];
				}
			}

			$extensions = $return;
		}

		if (!isset($extensions['_allowed_']))
		{
			$extensions['_allowed_'] = array();
		}

		return $extensions;
	}

	/**
	* Obtain active bots
	*/
	function obtain_bots()
	{
		global $mx_cache;

		if (($bots = $mx_cache->get('_bots')) === false)
		{
			global $db;

			switch ($db->sql_layer)
			{
				case 'mssql':
				case 'mssql_odbc':
					$sql = 'SELECT user_id, bot_agent, bot_ip
						FROM ' . BOTS_TABLE . '
						WHERE bot_active = 1
					ORDER BY LEN(bot_agent) DESC';
				break;

				case 'firebird':
					$sql = 'SELECT user_id, bot_agent, bot_ip
						FROM ' . BOTS_TABLE . '
						WHERE bot_active = 1
					ORDER BY CHAR_LENGTH(bot_agent) DESC';
				break;

				// LENGTH supported by MySQL, IBM DB2 and Oracle for sure...
				default:
					$sql = 'SELECT user_id, bot_agent, bot_ip
						FROM ' . BOTS_TABLE . '
						WHERE bot_active = 1
					ORDER BY LENGTH(bot_agent) DESC';
				break;
			}
			$result = $db->sql_query($sql);

			$bots = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$bots[] = $row;
			}
			$db->sql_freeresult($result);

			$mx_cache->put('_bots', $bots);
		}

		return $bots;
	}

	/**
	 * Obtain cfg file data
	 *
	 * @param unknown_type $theme
	 * @return unknown
	 */
	function obtain_cfg_items($theme)
	{
		global $board_config, $phpbb_root_path, $mx_cache;

		$parsed_items = array(
			'theme'		=> array(),
			'template'	=> array(),
			'imageset'	=> array()
		);

		foreach ($parsed_items as $key => $parsed_array)
		{
			$parsed_array = $mx_cache->get('_cfg_' . $key . '_' . $theme[$key . '_path']);

			if ($parsed_array === false)
			{
				$parsed_array = array();
			}

			$reparse = false;
			$filename = $phpbb_root_path . 'styles/' . $theme[$key . '_path'] . '/' . $key . '/' . $key . '.cfg';

			if (!file_exists($filename))
			{
				continue;
			}

			if (!isset($parsed_array['filetime']) || (($board_config['load_tplcompile'] && @filemtime($filename) > $parsed_array['filetime'])))
			{
				$reparse = true;
			}

			// Re-parse cfg file
			if ($reparse)
			{
				$parsed_array = mx_parse_cfg_file($filename);
				$parsed_array['filetime'] = @filemtime($filename);

				$mx_cache->put('_cfg_' . $key . '_' . $theme[$key . '_path'], $parsed_array);
			}
			$parsed_items[$key] = $parsed_array;
		}

		return $parsed_items;
	}

	/**
	* Obtain disallowed usernames
	*/
	function obtain_disallowed_usernames()
	{
		global $mx_cache;

		if (($usernames = $mx_cache->get('_disallowed_usernames')) === false)
		{
			global $db;

			$sql = 'SELECT disallow_username
				FROM ' . DISALLOW_TABLE;
			$result = $db->sql_query($sql);

			$usernames = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$usernames[] = str_replace('%', '.*?', preg_quote(utf8_clean_string($row['disallow_username']), '#'));
			}
			$db->sql_freeresult($result);

			$mx_cache->put('_disallowed_usernames', $usernames);
		}

		return $usernames;
	}

	/**
	* Obtain hooks...
	*/
	function obtain_hooks()
	{
		global $phpbb_root_path, $phpEx, $mx_cache;

		if (($hook_files = $mx_cache->get('_hooks')) === false)
		{
			$hook_files = array();

			// Now search for hooks...
			$dh = @opendir($phpbb_root_path . 'includes/hooks/');

			if ($dh)
			{
				while (($file = readdir($dh)) !== false)
				{
					if (strpos($file, 'hook_') === 0 && substr($file, -(strlen($phpEx) + 1)) === '.' . $phpEx)
					{
						$hook_files[] = substr($file, 0, -(strlen($phpEx) + 1));
					}
				}
				closedir($dh);
			}

			$mx_cache->put('_hooks', $hook_files);
		}

		return $hook_files;
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function generate_group_select_sql()
	{
		// Get us all the groups exept bots and guests
		$sql = "SELECT g.group_id, g.group_name, g.group_type
			FROM " . GROUPS_TABLE . " g
			WHERE g.group_name NOT IN ('BOTS', 'GUESTS')
			ORDER BY g.group_type ASC, g.group_name";
		return $sql;
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function generate_session_online_sql($guest = false)
	{
		if ($guest)
		{
			$sql = "SELECT u.*, s.*, s.session_page AS user_session_page
				FROM " . USERS_TABLE . " u, " . SESSIONS_TABLE . " s
				WHERE u.user_id = " . ANONYMOUS . "
					AND u.user_id = s.session_user_id
					AND s.session_time >= " . ( time() - 300 ) . "
				ORDER BY s.session_time DESC";
		}
		else
		{
			$sql = "SELECT u.*, s.*, s.session_time AS user_session_time, s.session_page AS user_session_page
				FROM " . USERS_TABLE . " u, " . SESSIONS_TABLE . " s
				WHERE u.user_id <> " . ANONYMOUS . "
					AND u.user_id = s.session_user_id
					AND s.session_time >= " . ( time() - 300 ) . "
				ORDER BY s.session_time DESC";
		}
		return $sql;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $str_ip
	 * @return unknown
	 */
	function decode_ip($str_ip)
	{
		return $str_ip;
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function get_phpbb_version()
	{
		global $board_config;

		return $board_config['version'];
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function confirm_backend()
	{
		global $portal_config;

		return PORTAL_BACKEND == $portal_config['portal_backend'];
	}

	/**
	* Get username details for placing into templates.
	*
	* @param string $mode Can be profile (for getting an url to the profile), username (for obtaining the username), colour (for obtaining the user colour) or full (for obtaining a html string representing a coloured link to the users profile).
	* @param int $user_id The users id
	* @param string $username The users name
	* @param string $username_colour The users colour
	* @param string $guest_username optional parameter to specify the guest username. It will be used in favor of the GUEST language variable then.
	* @param string $custom_profile_url optional parameter to specify a profile url. The user id get appended to this url as &amp;u={user_id}
	*
	* @return string A string consisting of what is wanted based on $mode.
	*/
	function get_username_string($mode, $user_id, $username = false, $username_colour = '', $guest_username = false, $custom_profile_url = false)
	{
		global $phpbb_root_path, $mx_root_path, $phpEx, $mx_user, $phpbb_auth;

		$profile_url = '';

		//Added by OryNider
		if (($username == false) || ($username_colour == false))
		{
			$this_userdata = mx_get_userdata($user_id, false);
			$user_id = $this_userdata['user_id'];
			$username = $this_userdata['username'];
			$username_colour = $this_userdata['user_colour'];
		}
		//Added Ends

		$username_colour = ($username_colour) ? '#' . $username_colour : '';

		if ($guest_username === false)
		{
			$username = ($username) ? $username : $mx_user->lang['GUEST'];
		}
		else
		{
			$username = ($user_id && $user_id != ANONYMOUS) ? $username : ((!empty($guest_username)) ? $guest_username : $mx_user->lang['GUEST']);
		}

		// Only show the link if not anonymous
		if ($user_id && $user_id != ANONYMOUS)
		{
			// Do not show the link if the user is already logged in but do not have u_viewprofile permissions (relevant for bots mostly).
			// For all others the link leads to a login page or the profile.
			if ($mx_user->data['user_id'] != ANONYMOUS && !$phpbb_auth->acl_get('u_viewprofile'))
			{
				$profile_url = '';
			}
			else
			{
				$profile_url = ($custom_profile_url !== false) ? $custom_profile_url : mx3_append_sid(PHPBB_URL . "memberlist.$phpEx", 'mode=viewprofile');
				$profile_url .= '&amp;u=' . (int) $user_id;
			}
		}
		else
		{
			$profile_url = '';
		}

		switch ($mode)
		{
			case 'profile':
				return $profile_url;
			break;

			case 'username':
				return $username;
			break;

			case 'colour':
				return $username_colour;
			break;

			case 'full':
			default:

				$tpl = '';
				if (!$profile_url && !$username_colour)
				{
					$tpl = '{USERNAME}';
				}
				else if (!$profile_url && $username_colour)
				{
					$tpl = '<span style="color: {USERNAME_COLOUR};" class="username-coloured">{USERNAME}</span>';
				}
				else if ($profile_url && !$username_colour)
				{
					$tpl = '<a href="{PROFILE_URL}">{USERNAME}</a>';
				}
				else if ($profile_url && $username_colour)
				{
					$tpl = '<a href="{PROFILE_URL}" style="color: {USERNAME_COLOUR};" class="username-coloured">{USERNAME}</a>';
				}

				return str_replace(array('{PROFILE_URL}', '{USERNAME_COLOUR}', '{USERNAME}'), array($profile_url, $username_colour, $username), $tpl);
			break;
		}
	}

	//
	// ACP
	//
	/**
	 * Enter description here...
	 *
	 */
	function load_phpbb_acp_menu()
	{
		global $phpbb_root_path, $template, $lang, $phpEx, $userdata, $mx_user;

		$template->assign_block_vars('module_phpbb', array(
			'L_PHPBB' => $lang['Phpbb'],
			"L_FORUM_INDEX" => $lang['Main_index'],
			"L_PREVIEW_FORUM" => $lang['Preview_forum'],
			"U_FORUM_INDEX" => mx_append_sid(PHPBB_URL . "index.$phpEx"),
		));

		$menu_cat_id = 0;

		$template->assign_block_vars('module_phpbb.catrow', array(
			//+MOD: DHTML Menu for ACP
			'MENU_CAT_ID' => $menu_cat_id,
			'MENU_CAT_ROWS' => 1,
			//-MOD: DHTML Menu for ACP
			'ADMIN_CATEGORY' => 'Olympus adminCP')
		);

		$template->assign_block_vars('module_phpbb.catrow.modulerow', array(
			"ROW_COLOR" => "#" . $mx_user->theme['td_color1'],
			"ROW_CLASS" => $mx_user->theme['td_class1'],
			//+MOD: DHTML Menu for ACP
			'ROW_COUNT' => 0,
			//-MOD: DHTML Menu for ACP
			"ADMIN_MODULE" => 'Go!',
			"U_ADMIN_MODULE" => mx_append_sid($phpbb_root_path . 'adm/index.php?sid='.$mx_user->session_id))
		);
	}

	/**
	 * Enter description here...
	 *
	 */
	function load_forum_stats()
	{
		global $db, $template, $board_config, $portal_config, $phpbb_root_path, $mx_root_path, $lang, $theme, $mx_user, $userdata;
		
		$template->assign_block_vars("forum_stats", array());
		//
		// Get forum statistics
		//
		$total_posts = phpBB2::get_db_stat('postcount');
		$total_users = phpBB2::get_db_stat('usercount');
		$total_topics = phpBB2::get_db_stat('topiccount');

		$start_date = phpBB2::create_date($board_config['default_dateformat'], $board_config['board_startdate'], $board_config['board_timezone']);

		$boarddays = ( time() - $board_config['board_startdate'] ) / 86400;

		$posts_per_day = sprintf("%.2f", $total_posts / $boarddays);
		$topics_per_day = sprintf("%.2f", $total_topics / $boarddays);
		$users_per_day = sprintf("%.2f", $total_users / $boarddays);

		$avatar_dir_size = 0;

		if ($avatar_dir = @opendir($phpbb_root_path . $board_config['avatar_path']) )
		{
			while( $file = @readdir($avatar_dir) )
			{
				if( $file != "." && $file != ".." )
				{
					$avatar_dir_size += @filesize($phpbb_root_path . $board_config['avatar_path'] . "/" . $file);
				}
			}
			@closedir($avatar_dir);

			//
			// This bit of code translates the avatar directory size into human readable format
			// Borrowed the code from the PHP.net annoted manual, origanally written by:
			// Jesse (jesse@jess.on.ca)
			//
			if($avatar_dir_size >= 1048576)
			{
				$avatar_dir_size = round($avatar_dir_size / 1048576 * 100) / 100 . " MB";
			}
			else if($avatar_dir_size >= 1024)
			{
				$avatar_dir_size = round($avatar_dir_size / 1024 * 100) / 100 . " KB";
			}
			else
			{
				$avatar_dir_size = $avatar_dir_size . " Bytes";
			}
		}
		else
		{
			// Couldn't open Avatar dir.
			$avatar_dir_size = $lang['Not_available'];
		}

		if($posts_per_day > $total_posts)
		{
			$posts_per_day = $total_posts;
		}

		if($topics_per_day > $total_topics)
		{
			$topics_per_day = $total_topics;
		}

		if($users_per_day > $total_users)
		{
			$users_per_day = $total_users;
		}

		//
		// DB size ... MySQL only
		//
		// This code is heavily influenced by a similar routine
		// in phpMyAdmin 2.2.0
		//
		if( preg_match("/^mysql/", SQL_LAYER) )
		{
			$sql = "SELECT VERSION() AS mysql_version";
			if($result = $db->sql_query($sql))
			{
				$row = $db->sql_fetchrow($result);
				$version = $row['mysql_version'];

				if( preg_match("/^(3\.23|4\.|5\.)/", $version) )
				{
					static $dbname, $dbsize;
					$db_name = ( preg_match("/^(3\.23\.[6-9])|(3\.23\.[1-9][1-9])|(4\.)|(5\.)/", $version) ) ? "`$dbname`" : $dbname;

					$sql = "SHOW TABLE STATUS
						FROM " . $db_name;
					if($result = $db->sql_query($sql))
					{
						$tabledata_ary = $db->sql_fetchrowset($result);

						$dbsize = 0;
						for($i = 0; $i < count($tabledata_ary); $i++)
						{
							if( $tabledata_ary[$i]['Type'] != "MRG_MyISAM" )
							{
								if( $table_prefix != "" )
								{
									if( strstr($tabledata_ary[$i]['Name'], $table_prefix) )
									{
										$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
									}
								}
								else
								{
									$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
								}
							}
						}
					} // Else we couldn't get the table status.
				}
				else
				{
					$dbsize = $lang['Not_available'];
				}
			}
			else
			{
				$dbsize = $lang['Not_available'];
			}
			$db->sql_freeresult($result);
		}
		else if( preg_match("/^mssql/", SQL_LAYER) )
		{
			$sql = "SELECT ((SUM(size) * 8.0) * 1024.0) as dbsize
				FROM sysfiles";
			if( $result = $db->sql_query($sql) )
			{
				$dbsize = ( $row = $db->sql_fetchrow($result) ) ? intval($row['dbsize']) : $lang['Not_available'];
			}
			else
			{
				$dbsize = $lang['Not_available'];
			}
			$db->sql_freeresult($result);
		}
		else
		{
			$dbsize = $lang['Not_available'];
		}

		if ( is_integer($dbsize) )
		{
			if( $dbsize >= 1048576 )
			{
				$dbsize = sprintf("%.2f MB", ( $dbsize / 1048576 ));
			}
			else if( $dbsize >= 1024 )
			{
				$dbsize = sprintf("%.2f KB", ( $dbsize / 1024 ));
			}
			else
			{
				$dbsize = sprintf("%.2f Bytes", $dbsize);
			}
		}

		$template->assign_vars(array(
			"NUMBER_OF_POSTS" => $total_posts,
			"NUMBER_OF_TOPICS" => $total_topics,
			"NUMBER_OF_USERS" => $total_users,
			"START_DATE" => $start_date,
			"POSTS_PER_DAY" => $posts_per_day,
			"TOPICS_PER_DAY" => $topics_per_day,
			"USERS_PER_DAY" => $users_per_day,
			"AVATAR_DIR_SIZE" => $avatar_dir_size,
			"DB_SIZE" => $dbsize,
			"GZIP_COMPRESSION" => ( $board_config['gzip_compress'] ) ? $lang['ON'] : $lang['OFF'])
		);
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function phpbb_version_check($force_update = false, $warn_fail = false, $ttl = 86400)
	{
		global $mx_cache, $board_config, $lang, $phpbb_version_info;
		
		$errno = 0;
		$errstr = $phpbb_version_info = '';
		$phpbb_version_info = $mx_cache->get('versioncheck');

		if ($fsock = @fsockopen('www.phpbb.com', 80, $errno, $errstr, 10))
		{
			//$phpbb_version_info = mx_get_remote_file('www.phpbb.com', '/updatecheck', ((defined('PHPBB_QA')) ? '30x_qa.txt' : '30x.txt'), $errstr, $errno);
			if ($phpbb_version_info === false || $force_update)
			{
				$errstr = '';
				$errno = 0;

				$phpbb_version_info = mx_get_remote_file('version.phpbb.com', '/phpbb',
						((defined('PHPBB_QA')) ? '30x_qa.txt' : '30x.txt'), $errstr, $errno);
			}
			
			if (empty($phpbb_version_info))
			{
				$mx_cache->destroy('versioncheck');
				if ($warn_fail)
				{
					trigger_error($errstr, E_USER_WARNING);
				}
				return false;
			}

			$mx_cache->put('versioncheck', $phpbb_version_info, $ttl);			

			$phpbb_version_info = explode("\n", $phpbb_version_info);
			//$latest_version = trim($phpbb_version_info[0]); 
			//$update_link = append_sid($phpbb_root_path . 'install/index.' . $phpEx, 'mode=update');
			$latest_phpbb_head_revision = $version1 = strtolower(trim($phpbb_version_info[0]));
			$latest_phpbb_minor_revision = trim($phpbb_version_info[2]);
			$latest_phpbb_version = trim($phpbb_version_info[0]) . '.' . trim($phpbb_version_info[1]) . '.' . trim($phpbb_version_info[2]);
			$version2 = strtolower($board_config['version']);
			$current_phpbb_version = explode(".", $board_config['version']);
			$minor_phpbb_revision = $current_phpbb_version[2];
			$operator = '<=';
			if (version_compare($version1, $version2, $operator))
			{
				$phpbb_version_info = '<p style="color:green">' . $lang['Version_up_to_date'] . '</p>';
			}
			else
			{
				$phpbb_version_info = '<p style="color:red">' . $lang['Version_not_up_to_date'];
				$phpbb_version_info .= '<br />' . sprintf($lang['Latest_version_info'], $latest_phpbb_version) . sprintf($lang['Current_version_info'], $board_config['version']) . '</p>';
			}
		}
		else
		{
			if ($errstr)
			{
				$phpbb_version_info = '<p style="color:red">' . sprintf($lang['Connect_socket_error'], $errstr) . '</p>';
			}
			else
			{
				$phpbb_version_info = '<p>' . $lang['Socket_functions_disabled'] . '</p>';
			}
		}

		$phpbb_version_info .= '<p>' . $lang['Mailing_list_subscribe_reminder'] . '</p>';

		return $phpbb_version_info;
	}
}

//
// Now load some bbcodes, to be extended for this backend (see below)
//
include_once($mx_root_path . 'includes/sessions/ascraeus/bbcode.' . $phpEx); // BBCode associated functions

?>