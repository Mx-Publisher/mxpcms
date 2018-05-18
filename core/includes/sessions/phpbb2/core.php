<?php
/**
*
* @package Auth
* @version $Id: core.php,v 1.7 2013/09/04 04:32:35 orynider Exp $
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

//
// Finally, load some backend specific functions
//
include_once($phpbb_root_path . 'includes/functions.' . $phpEx);

//
// phpBB Permissions
//
include_once($phpbb_root_path . 'includes/auth.' . $phpEx);


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
		$phpbb_root_path = $phpbb_root_path ? $phpbb_root_path : $mx_root_path . $portal_config['portal_backend_path'];
		str_replace("//", "/", $phpbb_root_path);
		$portal_backend_valid_file = @file_exists($phpbb_root_path . "modcp.$phpEx");

		//
		// Load phpbb config.php (to get table prefix)
		//
		if ((include $phpbb_root_path . "config.$phpEx") === false)
		{
			die('Configuration file (config) ' . $phpbb_root_path . "/config.$phpEx" . ' couldn\'t be opened.');
		}

		//
		// Define backend template extension
		//
		$tplEx = 'tpl';

		//
		// Validate db connection for backend
		//
		$_result = $db->sql_query( "SELECT config_value from " . $table_prefix . "config WHERE config_name = 'cookie_domain'" );
		$portal_backend_valid_db = $db->sql_numrows( $_result ) != 0;

		return $portal_backend_valid_file && !empty($table_prefix) && $portal_backend_valid_db;
	}

	/**
	 * $mx_backend->setup_backend()
	 *
	 * Define some general backend definitions
	 * PORTAL_URL, PHPBB_URL, PORTAL_VERSION & $board_config
	 *
	 */
	function setup_backend()
	{
		global $portal_config, $board_config, $phpbb_root_path, $mx_root_path, $phpEx;
		//
		// Grab phpBB global variables, re-cache if necessary
		// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the MX-Publisher cache whenever updating phpBB config settings
		// - true: enable cache, false: disable cache
		$board_config = $this->obtain_phpbb_config(false);
		
		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($portal_config['script_path']));
		$server_name = trim($portal_config['server_name']);
		$server_protocol = ( $portal_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = (($portal_config['server_port']) && ($portal_config['server_port'] <> 80)) ? ':' . trim($portal_config['server_port']) . '/' : '/';
		$script_name_phpbb = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])) . '/';		
		$server_url = str_replace(array('phpBB/', $script_name_phpbb, str_replace('./../', '', $phpbb_root_path)), '', $portal_config['portal_phpbb_url']);
		$server_url = !empty($portal_config['portal_phpbb_url']) ? str_replace(array('https://', 'http://'), $server_protocol, $server_url) : $server_protocol . str_replace("//", "/", $server_name . $server_port . $script_name . '/'); //On some server the slash is not added and this trick will fix it
		
		define('PORTAL_URL', $server_url);
		define('PORTAL_VERSION', $portal_config['portal_version']);
		
		$server_url_phpbb = $server_protocol . $server_name . $server_port . $script_name_phpbb;
		$server_url_phpbb = !empty($portal_config['portal_phpbb_url']) ? $server_url . $script_name_phpbb : $server_url_phpbb;
		define('PHPBB_URL', $server_url_phpbb);

		//
		// Now sync Configs
		// In phpBB mode, we rely on native phpBB configs, thus we need to sync mxp and phpbb settings
		//
		$this->sync_configs();

		//
		// Dummy include, to make all original phpBB functions available
		//
		include_once($phpbb_root_path . 'includes/functions.' . $phpEx); // In case we need old functions...

		//
		// Is phpBB File Attachment MOD present?
		//
		if( file_exists($phpbb_root_path . 'attach_mod') )
		{
			include_once($phpbb_root_path . 'attach_mod/attachment_mod.' . $phpEx);
		}
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

				//
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
			$shared = in_array($force_shared, array('internal', 'phpbb2', 'phpbb3')) ? $force_shared : PORTAL_BACKEND;

			switch ($shared)
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

	//	$is_auth = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);

		$sql = "SELECT c.cat_id, c.cat_title, c.cat_order
			FROM " . CATEGORIES_TABLE . " c, " . FORUMS_TABLE . " f
			WHERE f.cat_id = c.cat_id
			GROUP BY c.cat_id, c.cat_title, c.cat_order
			ORDER BY c.cat_order";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Couldn't obtain category list.", "", __LINE__, __FILE__, $sql);
		}

		$category_rows = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$category_rows[] = $row;
		}

		if ( $total_categories = count($category_rows) )
		{
			$sql = "SELECT *
				FROM " . FORUMS_TABLE . "
				ORDER BY cat_id, forum_order";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
			}

			$boxstring = '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"><option value="-1">' . $lang['Select_forum'] . '</option>';

			$forum_rows = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				$forum_rows[] = $row;
			}

			if ( $total_forums = count($forum_rows) )
			{
				for($i = 0; $i < $total_categories; $i++)
				{
					$boxstring_forums = '';
					for($j = 0; $j < $total_forums; $j++)
					{
						if ( $forum_rows[$j]['cat_id'] == $category_rows[$i]['cat_id'] && $forum_rows[$j]['auth_view'] <= AUTH_REG )
						{

	//					if ( $forum_rows[$j]['cat_id'] == $category_rows[$i]['cat_id'] && $is_auth[$forum_rows[$j]['forum_id']]['auth_view'] )
	//					{
							$selected = ( $forum_rows[$j]['forum_id'] == $match_forum_id ) ? 'selected="selected"' : '';
							$boxstring_forums .=  '<option value="' . $forum_rows[$j]['forum_id'] . '"' . $selected . '>' . $forum_rows[$j]['forum_name'] . '</option>';

							//
							// Add an array to $nav_links for the Mozilla navigation bar.
							// 'chapter' and 'forum' can create multiple items, therefore we are using a nested array.
							//
							$nav_links['chapter forum'][$forum_rows[$j]['forum_id']] = array (
								'url' => mx_append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=" . $forum_rows[$j]['forum_id']),
								'title' => $forum_rows[$j]['forum_name']
							);

						}
					}

					if ( $boxstring_forums != '' )
					{
						$boxstring .= '<option value="-1">&nbsp;</option>';
						$boxstring .= '<option value="-1">' . $category_rows[$i]['cat_title'] . '</option>';
						$boxstring .= '<option value="-1">----------------</option>';
						$boxstring .= $boxstring_forums;
					}
				}
			}

			$boxstring .= '</select>';
		}
		else
		{
			$boxstring .= '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"></select>';
		}

		// Let the jumpbox work again in sites having additional session id checks.
	//	if ( !empty($SID) )
	//	{
			$boxstring .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
	//	}

		$template->set_filenames(array(
			'jumpbox' => 'jumpbox.tpl')
		);
		$template->assign_vars(array(
			'L_GO' => $lang['Go'],
			'L_JUMP_TO' => $lang['Jump_to'],
			'L_SELECT_FORUM' => $lang['Select_forum'],

			'S_JUMPBOX_SELECT' => $boxstring,
			'S_JUMPBOX_ACTION' => mx_append_sid($action))
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
		global $db, $mx_root_path, $phpbb_root_path, $userdata, $mx_user, $lang, $images, $phpEx;
		global $board_config, $gen_simple_header, $layouttemplate, $mx_page;

		switch ($mode)
		{
			case 'generate_login_logout_stats':

				if ( $userdata['session_logged_in'] )
				{
					$is_logged = true;
					$u_login_logout = 'login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];
					$l_login_logout = $lang['Logout'] . ' [ ' . $userdata['username'] . ' ]';
				}
				else
				{
					$is_logged = false;
					$u_login_logout = 'login.'.$phpEx;
					$l_login_logout = $lang['Login'];
				}

				$s_last_visit = ( $userdata['session_logged_in'] ) ? create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']) : '';

				//
				// Obtain number of new private messages
				// if user is logged in
				//
				if ( ($userdata['session_logged_in']) && (empty($gen_simple_header)) )
				{
					if ( $userdata['user_new_privmsg'] )
					{
						$l_message_new = ( $userdata['user_new_privmsg'] == 1 ) ? $lang['New_pm'] : $lang['New_pms'];
						$l_privmsgs_text = sprintf($l_message_new, $userdata['user_new_privmsg']);

						if ( $userdata['user_last_privmsg'] > $userdata['user_lastvisit'] )
						{
							$sql = "UPDATE " . USERS_TABLE . "
								SET user_last_privmsg = " . $userdata['user_lastvisit'] . "
								WHERE user_id = " . $userdata['user_id'];
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
						$mx_priv_msg = $lang['Private_Messages'] . ' (' . $userdata['user_new_privmsg'] . ')';
					}
					else
					{
						$l_privmsgs_text = $lang['No_new_pm'];

						$s_privmsg_new = 0;
						$icon_pm = $images['pm_no_new_msg'];
						$mx_priv_msg = $lang['Private_Messages'];
					}

					if ( $userdata['user_unread_privmsg'] )
					{
						$l_message_unread = ( $userdata['user_unread_privmsg'] == 1 ) ? $lang['Unread_pm'] : $lang['Unread_pms'];
						$l_privmsgs_text_unread = sprintf($l_message_unread, $userdata['user_unread_privmsg']);
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

				$u_register = 'profile.'.$phpEx.'?mode=register' ;
				$u_profile = 'profile.'.$phpEx.'?mode=editprofile';
				$u_privatemsgs = 'privmsg.'.$phpEx.'?folder=inbox';
				$u_privatemsgs_popup = 'privmsg.'.$phpEx.'?mode=newpm';
				$u_search = 'search.'.$phpEx;
				$u_memberlist = 'memberlist.'.$phpEx;
				$u_modcp = 'modcp.'.$phpEx;
				$u_faq = 'faq.'.$phpEx;
				$u_viewonline = 'viewonline.'.$phpEx;
				$u_group_cp = 'groupcp.'.$phpEx;
				$u_sendpassword = mx3_append_sid("{$phpbb_root_path}profile.$phpEx", 'mode=sendpassword');

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
				$current_phpbb_version = '2' . $board_config['version'];

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
	function obtain_phpbb_config($use_cache = true)
	{
		global $db, $mx_cache, $phpEx;

		if (($config = $mx_cache->get('phpbb_config')) && ($use_cache) )
		{
			return $config;
		}
		else
		{		
			if (!defined('CONFIG_TABLE'))
			{
				global $table_prefix, $mx_root_path;
				
				require $mx_root_path. "includes/sessions/phpbb2/constants.$phpEx";
			}		
		
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
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function generate_group_select_sql()
	{
		$sql = "SELECT group_id, group_name
			FROM " . GROUPS_TABLE . "
			WHERE group_single_user <> " . TRUE . "
			ORDER BY group_name ASC";
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
			$sql = "SELECT *
				FROM " . SESSIONS_TABLE . "
				WHERE session_logged_in = 0
					AND session_time >= " . ( time() - 300 ) . "
				ORDER BY session_time DESC";
		}
		else
		{
			$sql = "SELECT u.*, s.*
				FROM " . USERS_TABLE . " u, " . SESSIONS_TABLE . " s
				WHERE s.session_logged_in = " . TRUE . "
					AND u.user_id = s.session_user_id
					AND u.user_id <> " . ANONYMOUS . "
					AND s.session_time >= " . ( time() - 300 ) . "
				ORDER BY u.user_session_time DESC";
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
		return decode_ip($str_ip);
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function get_phpbb_version()
	{
		global $board_config;

		return '2' . $board_config['version'];
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
	function get_username_string($mode, $user_id, $username = false, $user_color = false, $guest_username = false, $custom_profile_url = false)
	{
		global $lang, $userdata, $phpEx;

		$lang['Guest'] = !$guest_username ? $lang['Guest'] : $guest_username;

		$this_userdata = mx_get_userdata($user_id, false);

		$username = ($username) ? $username : $this_userdata['username'];

		if ($this_userdata['user_level'] == ADMIN)
		{
			$user_color = $theme['fontcolor3'];
			$user_style = 'style="color:#' . $user_color . '; font-weight : bold;"';
		}
		else if ($this_userdata['user_level'] == MOD)
		{
			$user_color = $theme['fontcolor2'];
			$user_style = 'style="color:#' . $user_color . '; font-weight : bold;"';
		}
		else
		{
			$user_colour = $theme['fontcolor1'];
			$topic_poster_style = 'style="font-weight : bold;"';
		}

		// Only show the link if not anonymous
		if ($user_id && $user_id != ANONYMOUS)
		{
			$profile_url = mx3_append_sid(PHPBB_URL . "profile.$phpEx", 'mode=viewprofile&amp;u=' . (int) $user_id);
			$full_url = '<a href="' . $profile_url . '"><span ' . $topic_poster_style . '>' . $username . '</span></a>';
		}
		else
		{
			$profile_url = $lang['Guest'];
			$full_url = $lang['Guest'];
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
				return $user_colour;
			break;

			case 'full':
			default:
				return $full_url;
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
		global $phpbb_root_path, $template, $lang, $phpEx, $theme, $userdata, $mx_user;

		$module_phpbb = read_admin($phpbb_root_path . 'admin/');
		$template->assign_block_vars('module_phpbb', array(
			'L_PHPBB' => $lang['Phpbb'],
			"L_FORUM_INDEX" => $lang['Main_index'],
			"L_PREVIEW_FORUM" => $lang['Preview_forum'],
			"U_FORUM_INDEX" => mx_append_sid(PHPBB_URL . "index.$phpEx"),
		));

		ksort($module_phpbb);

		//+MOD: DHTML Menu for ACP
		$menu_cat_id = 0;
		//-MOD: DHTML Menu for ACP

		while( list($cat, $action_array) = each($module_phpbb) )
		{
			$cat = ( !empty($lang[$cat]) ) ? $lang[$cat] : preg_replace("/_/", " ", $cat);

			$template->assign_block_vars('module_phpbb.catrow', array(
				//+MOD: DHTML Menu for ACP
				'MENU_CAT_ID' => $menu_cat_id,
				'MENU_CAT_ROWS' => count($action_array),
				//-MOD: DHTML Menu for ACP
				'ADMIN_CATEGORY' => $cat)
			);

			ksort($action_array);

			$row_count = 0;
			while( list($action, $file) = each($action_array) )
			{
				$row_color = ( !($row_count%2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($row_count%2) ) ? $theme['td_class1'] : $theme['td_class2'];

				$action = ( !empty($lang[$action]) ) ? $lang[$action] : preg_replace("/_/", " ", $action);

				$template->assign_block_vars('module_phpbb.catrow.modulerow', array(
					"ROW_COLOR" => "#" . $row_color,
					"ROW_CLASS" => $row_class,
					//+MOD: DHTML Menu for ACP
					'ROW_COUNT' => $row_count,
					//-MOD: DHTML Menu for ACP
					"ADMIN_MODULE" => $action,
					"U_ADMIN_MODULE" => mx_append_sid(PHPBB_URL . 'admin/' . $file . ( ( strpos($file, '?') !== false ) ? '&sid=' : '?sid=' ) . $userdata['session_id']))
				);
				$row_count++;
			}
			//+MOD: DHTML Menu for ACP
			$menu_cat_id++;
			//-MOD: DHTML Menu for ACP
		}
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
		$total_posts = get_db_stat('postcount');
		$total_users = get_db_stat('usercount');
		$total_topics = get_db_stat('topiccount');

		$start_date = create_date($board_config['default_dateformat'], $board_config['board_startdate'], $board_config['board_timezone']);

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

				$phpbb_version_info = mx_get_remote_file('version.phpbb.com/20x.txt', '/phpbb',
						((defined('PHPBB_QA')) ? '20x_qa.txt' : '20x.txt'), $errstr, $errno);
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
			$version2 = strtolower('2'.$board_config['version']);
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
include_once($mx_root_path . 'includes/sessions/phpbb2/bbcode.' . $phpEx); // BBCode associated functions
?>