<?php
/**
*
* @package Auth
* @version $Id: core.php,v 1.10 2008/08/29 03:53:50 orynider Exp $
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

/**
* Backend specific tasks
*
* @package MX-Publisher
*/
class mx_backend
{
	//
	// XS Template - use backend db settings
	//
	var $edit_db = false;

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

		//
		// Define relative path to "phpBB", and validate
		//
		$phpbb_root_path = $mx_root_path . 'includes/shared/phpbb2/';
		str_replace("//", "/", $phpbb_root_path);
		$portal_backend_valid_file = @file_exists($phpbb_root_path . "includes/functions.$phpEx");

		//
		// Define backend template extension
		//
		$tplEx = 'tpl';

		return $portal_backend_valid_file;
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

		$board_config = array();
		$script_name_phpbb = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim('includes/shared/phpbb2/')) . '/';

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

				//
				// Keep phpBB stats
				//
				case 'record_online_users':
				case 'record_online_date':

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

		$val = $portal_config['rand_seed'] . microtime();
		$val = md5($val);
		$portal_config['rand_seed'] = md5($portal_config['rand_seed'] . $val . 'a');

		if($dss_seeded !== true)
		{
			$sql = "UPDATE " . PORTAL_TABLE . " SET
				rand_seed = '" . $portal_config['rand_seed'] . "'
				WHERE portal_id = '1'";

			if( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Unable to reseed PRNG", "", __LINE__, __FILE__, $sql);
			}

			$dss_seeded = true;
		}

		return substr($val, 4, 16);
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

				$s_last_visit = ( $userdata['session_logged_in'] ) ? phpBB2::create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']) : '';

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
					'PHPBB' => false,

					// Show phpbb stats?
					'PHPBB_STATS' => false,

					// Allow autologin?
					'ALLOW_AUTOLOGIN' => false,

					// phpBB PM
					'ENABLE_PM_POPUP' => false,
				));

				break;

			case 'generate_nav_links':

				/*
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
				*/

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

				$template->assign_vars(array(
					'PHPBB_BACKEND'				=> false,
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
}

/**
 * MXP BBcodes
 * @package MX-Publisher
 */
class mx_bbcode extends bbcode_base
{
	var $smiley_path_url = '';
	var $smiley_root_path =	'';

	var $smiley_url = 'smile_url';
	var $smiley_id = 'smilies_id';
	var $emotion = 'emoticon';

	function mx_bbcode()
	{
		global $phpbb_root_path;

		$this->smiley_path_url = PHPBB_URL; //change this to PORTAL_URL when shared folder will be removed
		$this->smiley_root_path =	$phpbb_root_path; //same here
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

			include($mx_root_path . 'includes/page_header.'.$phpEx);

			$template->set_filenames(array(
				'smiliesbody' => 'posting_smilies.tpl')
			);
		}

		$sql = "SELECT emoticon, code, smile_url
			FROM " . SMILIES_TABLE . "
			ORDER BY smilies_id";
		if ($result = $db->sql_query($sql))
		{
			$num_smilies = 0;
			$rowset = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if (empty($rowset[$row['smile_url']]))
				{
					$rowset[$row['smile_url']]['code'] = str_replace("'", "\\'", str_replace('\\', '\\\\', $row['code']));
					$rowset[$row['smile_url']]['emoticon'] = $row['emoticon'];
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

		if ($mode == 'window')
		{
			$template->pparse('smiliesbody');
			include($mx_root_path . 'includes/page_tail.'.$phpEx);
		}
	}
}
?>