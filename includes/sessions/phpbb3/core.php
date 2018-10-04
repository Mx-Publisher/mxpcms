<?php
/**
*
* @package Auth
* @version $Id: core.php,v 1.12 2008/08/27 07:32:56 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
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

//
// Now load some bbcodes, to be extended for this backend (see below)
//
include_once($mx_root_path . 'includes/mx_functions_bbcode.' . $phpEx); // BBCode associated functions

//
// Finally, load some backend specific functions
//
include_once($mx_root_path . 'includes/sessions/phpbb3/functions.' . $phpEx);

//
// phpBB Permissions
//
include_once($mx_root_path . 'includes/sessions/phpbb3/auth.' . $phpEx);

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
		//
		$is_auth_ary = $this->acl_getf('f_read', false);

		//
		// Loop through the list of forums to retrieve the ids for
		// those with AUTH_VIEW allowed.
		//
		$auth_data_sql = '';
		foreach( $is_auth_ary as $fid => $is_auth_row )
		{
			if( ($is_auth_row['f_read']) )
			{
				$auth_data_sql .= ( $auth_data_sql != '' ) ? ', ' . $fid : $fid;
			}
		}

		if( empty($auth_data_sql) )
		{
			$auth_data_sql = -1;
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

		$table_prefix = '';

		//
		// Define relative path to phpBB, and validate
		//
		$phpbb_root_path = $mx_root_path . $portal_config['portal_backend_path'];
		str_replace("//", "/", $phpbb_root_path);
		$portal_backend_valid_file = @file_exists($phpbb_root_path . "mcp.$phpEx");

		//
		// Load phpbb config.php (to get table prefix)
		//
		@include_once($phpbb_root_path . 'config.' . $phpEx);

		//
		// Define backend template extension
		//
		$tplEx = 'html';

		//
		// Validate db connection for backend
		//
		$_result = $db->sql_query( "SELECT config_value from " . $table_prefix . "config WHERE config_name = 'cookie_domain'" );
		$portal_backend_valid_db = $db->sql_numrows( $_result ) != 0;

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
				//
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
					$path = $mx_root_path . 'includes/shared/phpbb2/includes/';
					break;
				case 'phpbb3':
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

			if( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Unable to reseed PRNG", "", __LINE__, __FILE__, $sql);
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
	 * Enter description here...
	 *
	 * @access public
	 * @param boolean $use_cache
	 * @return unknown
	 */
	function obtain_phpbb_config($use_cache = true)
	{
		global $db, $mx_cache;

		if (($config = $mx_cache->get('phpbb_config')) && ($use_cache) )
		{
			return $config;
		}
		else
		{
			$sql = "SELECT *
				FROM " . CONFIG_TABLE;

			if ( !( $result = $db->sql_query( $sql ) ) )
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

			while ( $row = $db->sql_fetchrow($result) )
			{
				$config[$row['config_name']] = $row['config_value'];
			}
			$db->sql_freeresult($result);

			if ($use_cache)
			{
				$mx_cache->put('phpbb_config', $config);
			}

			return ( $config );
		}
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
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function generate_group_select_sql()
	{
		$sql = "SELECT group_id, group_name
			FROM " . GROUPS_TABLE . "
			WHERE group_name NOT IN ('BOTS', 'GUESTS')
			ORDER BY group_name ASC";
		return $sql;
	}
}

/**
 * MXP BBcodes
 * @package MX-Publisher
 */
class mx_bbcode extends bbcode_base
{
	var $smiley_path_url = '';
	var $smiley_root_path =	'';

	var $smiley_url = 'smiley_url';
	var $smiley_id = 'smiley_id';
	var $emotion = 'emotion';

	function mx_bbcode()
	{
		global $board_config, $phpbb_root_path;

		$this->smiley_path_url = PHPBB_URL; //change this to PORTAL_URL when shared folder will be removed
		$this->smiley_root_path =	$phpbb_root_path; //same here
		$board_config['smilies_path'] = str_replace("smiles", "smilies", $board_config['smilies_path']);
	}

	/**
	 * Generate smilies.
	 *
	 * Hacking generate_smilies from phpbb/includes/functions_post(ing).php
	 *
	 * @param string $mode
	 * @param integer $page_id
	*
	* Fill smiley templates (or just the variables) with smilies, either in a window or inline
	*/
	function generate_smilies($mode, $forum_id)
	{
		global $mx_page, $board_config, $template, $mx_root_path, $phpbb_root_path, $phpEx;
		global $db, $lang, $images, $theme;
		global $user_ip, $session_length, $starttime;
		global $userdata, $phpbb_auth, $mx_user;

		$inline_columns = 4;
		$inline_rows = 5;
		$window_columns = 8;

		if ($mode == 'window')
		{
			$mx_user->init($user_ip, PAGE_INDEX);

			$gen_simple_header = TRUE;
			$page_title = $lang['Emoticons'];

			if ($forum_id)
			{
				$sql = 'SELECT forum_style
					FROM ' . FORUMS_TABLE . "
					WHERE forum_id = $forum_id";
				$result = $db->sql_query_limit($sql, 1);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$mx_user->setup('posting', (int) $row['forum_style']);
			}
			else
			{
				$mx_user->setup('posting');
			}

			include($mx_root_path . 'includes/page_header.'.$phpEx);

			$template->set_filenames(array(
				'smiliesbody' => 'posting_smilies.html')
			);
		}

		$display_link = false;
		if ($mode == 'inline')
		{
			$sql = 'SELECT smiley_id
				FROM ' . SMILIES_TABLE . '
				WHERE display_on_posting = 0';
			$result = $db->sql_query_limit($sql, 1, 0, 3600);

			if ($row = $db->sql_fetchrow($result))
			{
				$display_link = true;
			}
			$db->sql_freeresult($result);
		}

		$last_url = '';

		$sql = 'SELECT *
			FROM ' . SMILIES_TABLE .
			(($mode == 'inline') ? ' WHERE display_on_posting = 1 ' : '') . '
			ORDER BY smiley_order';

		//phpBB2 code start
		if ($result = $db->sql_query($sql))
		{
			$num_smilies = 0;
			$rowset = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if (empty($rowset[$row['smiley_url']]))
				{
					$rowset[$row['smiley_url']]['code'] = str_replace("'", "\\'", str_replace('\\', '\\\\', $row['code']));
					$rowset[$row['smiley_url']]['emoticon'] = $row['emoticon'];
					$num_smilies++;
				}
			}

			if ($num_smilies)
			{
				$smilies_count = ($mode == 'inline') ? min(19, $num_smilies) : $num_smilies;
				$smilies_split_row = ($mode == 'inline') ? $inline_columns - 1 : $window_columns - 1;

				$s_colspan = 0;
				$row = 0;
				$col = 0;

				while (list($smile_url, $data) = @each($rowset))
				{
					if (!$col)
					{
						$template->assign_block_vars('smilies_row', array());
					}

					$template->assign_block_vars('smilies_row.smilies_col', array(
						'SMILEY_CODE' => $data['code'],
						'SMILEY_IMG' => $this->smiley_path_url  . $board_config['smilies_path'] . '/' . $smile_url,
						'SMILEY_DESC' => $data['emoticon'])
					);

					$s_colspan = max($s_colspan, $col + 1);

					if ($col == $smilies_split_row)
					{
						if ($mode == 'inline' && $row == $inline_rows - 1)
						{
							break;
						}
						$col = 0;
						$row++;
					}
					else
					{
						$col++;
					}
				}

				if ($mode == 'inline' && $num_smilies > $inline_rows * $inline_columns)
				{
					$template->assign_block_vars('switch_smilies_extra', array());

					$template->assign_vars(array(
						'L_MORE_SMILIES' => $lang['More_emoticons'],
						'U_MORE_SMILIES' => mx3_append_sid(PHPBB_URL . "posting.$phpEx", "mode=smilies"))
					);
				}

				$template->assign_vars(array(
					'L_EMOTICONS' => $lang['Emoticons'],
					'L_CLOSE_WINDOW' => $lang['Close_window'],
					'S_SMILIES_COLSPAN' => $s_colspan)
				);
			}
		}

		/*
		$result = $db->sql_query($sql, 3600);

		$smilies = array();
		while ($row = $db->sql_fetchrow($result))
		{
			if (empty($smilies[$row['smiley_url']]))
			{
				$smilies[$row['smiley_url']] = $row;
			}
		}
		$db->sql_freeresult($result);

		if (sizeof($smilies))
		{
			foreach ($smilies as $row)
			{
				$template->assign_block_vars('smiley', array(
					'SMILEY_CODE'	=> $row['code'],
					'A_SMILEY_CODE'	=> addslashes($row['code']),
					'SMILEY_IMG'	=> $this->smiley_root_path  . $board_config['smilies_path'] . '/' . $row['smiley_url'],
					'SMILEY_WIDTH'	=> $row['smiley_width'],
					'SMILEY_HEIGHT'	=> $row['smiley_height'],
					'SMILEY_DESC'	=> $row['emotion'])
				);
			}
		}

		//What we do here with forum_id versus page_id ?
		if ($mode == 'inline' && $display_link)
		{
			$template->assign_vars(array(
				'S_SHOW_SMILEY_LINK' 	=> true,
				'U_MORE_SMILIES' 		=> mx3_append_sid(PHPBB_URL . "posting.$phpEx", 'mode=smilies&amp;f=' . $forum_id))
			);
		}
		*/

		if ($mode == 'window')
		{
			$template->pparse('smiliesbody');
			include($mx_root_path . 'includes/page_tail.'.$phpEx);
		}
	}
}
?>