<?php
/**
*
* @package MX-Publisher Core
* @version $Id: page_header.php,v 3.78 2024/04/02 23:15:17 orynider Exp $
* @copyright (c) 2002-2024 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
* @link http://github.com/Mx-Publisher/mxpcms
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

define('HEADER_INC', true);

/**********
NOTE:
The following code related to GZIP initialization has been moved to
the new mx_session_start() function, declared in mx_functions.php

//
// gzip_compression
//
$do_gzip_compress = FALSE;
if ( $board_config['gzip_compress'] )
{
	$phpver = phpversion();

	$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

	if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
	{
		if ( extension_loaded('zlib') )
		{
			ob_end_clean();
			ob_start('ob_gzhandler');
		}
	}
	else if ( $phpver > '4.0' )
	{
		if ( strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') )
		{
			if ( extension_loaded('zlib') )
			{
				$do_gzip_compress = TRUE;
				ob_start();
				ob_implicit_flush(0);

				header('Content-Encoding: gzip');
			}
		}
	}
}
**********/

// Redefine some MXP stylish userdata
//$mx_user->data['session_logged_in'] = $mx_user->data['user_id'] != ANONYMOUS ? 1 : 0;

$layouttemplate = isset($layouttemplate) ? $layouttemplate : "";
// If MX-Publisher frame template is not set, instantiate it
if (!is_object($layouttemplate))
{
	// Initialize template
	//
	$layouttemplate = new mx_Template( $mx_root_path . 'templates/'. $theme['template_name'], $board_config, $db );
}

//
// Obtain number of new private messages
// if user is logged in
if(!isset($mx_user) || !is_object($mx_user))
{
	$mx_user = new mx_user();
}

//
// Obtain number of new private messages
// if cache is logged in
if(!isset($mx_cache) || !is_object($mx_cache))
{
	$cache = new mx_cache();
}

if(!isset($phpbb_auth) || !is_object($phpbb_auth))
{
	$phpbb_auth = new phpbb_auth();
}
$phpbb_auth->acl($mx_user->data);

//
// Load common language file from phpBB3
//$mx_user->set_lang($mx_user->lang, $mx_user->help, 'common');
$lang = &$mx_user->lang;

// If MX-Publisher page is not set, instantiate it
if (!isset($mx_page->page_navigation_block))
{
	/*
	* Load and instatiate page and block classes
	* - temp fix to instatiate mx_page for the login page
	*/
	$mx_page->init('1');
}

// Parse and show the overall header.
$start = $mx_request_vars->get('start', MX_TYPE_INT, 0);
$view = $mx_request_vars->variable('view', '');

$print_version = $mx_request_vars->is_request('print') ? true : false; 
$no_page_header = (isset($_REQUEST['view']) || $mx_request_vars->variable('view', '') == 'print') ? true : $print_version; 

$page_ov_header2 = substr_count($mx_page->page_ov_header, 'html') ? str_replace(".html", ".tpl", $mx_page->page_ov_header) : str_replace(".tpl", ".html", $mx_page->page_ov_header);
$page_ov_header1 = ($no_page_header !== false) ? 'overall_header_print.' . $tplEx : $mx_page->page_ov_header;

// Output the page
$layouttemplate->set_filenames(array(
	'overall_header' => empty($page_ov_header1) || ( !file_exists($mx_root_path . TEMPLATE_ROOT_PATH . $page_ov_header1) && !file_exists($mx_root_path . TEMPLATE_ROOT_PATH . $page_ov_header2) ) ? ( empty($gen_simple_header) ? 'overall_header.' . $tplEx : 'simple_header.' . $tplEx ) : $page_ov_header1
));

// In case $phpbb_adm_relative_path is not set (in case of an update), use the default.
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'mybb':
		//To do:
	case 'smf2':
		//To do:
	break;
	
	case 'phpbb2':
		$phpbb_adm_relative_path = 'admin/';
		$phpbb_admin_path = (defined('PHPBB_ADMIN_PATH')) ? PHPBB_ADMIN_PATH : $phpbb_root_path . $phpbb_adm_relative_path;
	break;
	
	default:
		$phpbb_adm_relative_path = 'adm/';
		$phpbb_admin_path = (defined('PHPBB_ADMIN_PATH')) ? PHPBB_ADMIN_PATH : $phpbb_root_path . $phpbb_adm_relative_path;
	break;
}

//
// Generate logged in/logged out status
//
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'mybb':
		//To do: Profile oe UCP Links for each backend.
	case 'smf2':
		$admin = ($mx_user->data['user_level'] == ADMIN) ? true : false;			
		$u_register = mx_append_sid('login.'.$phpEx.'?mode=register');
		$u_profile = mx_append_sid('profile.'.$phpEx.'?mode=editprofile');
		
		//To do:
		$u_modcp 	=  ((($mx_user->data['user_level'] = 2) && ($mx_user->data['user_active'] = 1)) || ($mx_user->data['user_level'] == ADMIN)) ? mx_append_sid("{$mx_root_path}modcp/index.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '';
		$u_mcp	= ((($mx_user->data['user_level'] = 2) && ($mx_user->data['user_active'] = 1)) || ($mx_user->data['user_level'] == ADMIN)) ? mx_append_sid("{$mx_root_path}modcp/index.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '';
	
		$u_terms_use	= mx_append_sid("login.$phpEx?mode=terms");
		$u_privacy	= mx_append_sid("login.$phpEx?mode=privacy");
	break;

	case 'phpbb2':
		
		//To do: Check this in sessions/phpbb2 comparing to sessions/internal		
		$admin = ($mx_user->data['user_level'] == ADMIN) ? true : false;	
		
		$u_login = mx_append_sid("login.".$phpEx);
		if (  $mx_user->data['user_id'] != ANONYMOUS )
		{
			$u_login_logout = mx_append_sid('login.'.$phpEx.'?logout=true&sid=' . $mx_user->data['session_id']);
			$l_login_logout = $lang['Logout'] . ' [ ' . $mx_user->data['username'] . ' ]';
		}
		else
		{
			$u_login_logout = mx_append_sid("login.".$phpEx);
			$l_login_logout = $lang['Login'];
		}
		
		$u_register = mx_append_sid("{$phpbb_root_path}profile.".$phpEx."?mode=register");
		$u_profile = mx_append_sid("{$phpbb_root_path}profile.".$phpEx."?mode=editprofile");
		
		$u_modcp = (($mx_user->data['user_level'] == MOD) || ($mx_user->data['user_level'] == ADMIN)) ? mx_append_sid('modcp/index.'.$phpEx) : '';
		$u_mcp = (($mx_user->data['user_level'] == MOD) || ($mx_user->data['user_level'] == ADMIN)) ? mx_append_sid("{$phpbb_root_path}mcp.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : ( ((($mx_user->data['user_level'] = 2) && ($mx_user->data['user_active'] = 1)) || ($mx_user->data['user_level'] == ADMIN)) ? mx_append_sid("{$phpbb_root_path}modcp.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '');
	
		$u_terms_use = mx_append_sid("{$phpbb_root_path}profile.$phpEx?mode=terms");
		$u_privacy = mx_append_sid("{$phpbb_root_path}profile.$phpEx?mode=privacy");
	break;
	
	case 'olympus':
	//To do: Check this in sessions/phpbb2 comparing to sessions/internal
		$u_login = mx_append_sid("login.".$phpEx);
		$admin = ($mx_user->data['user_level'] == ADMIN) ? true : false;	
		if ($mx_user->data['user_id'] != ANONYMOUS)
		{
			$u_login_logout = mx_append_sid('login.'.$phpEx.'?logout=true&sid=' . $mx_user->data['session_id']);
			$l_login_logout = $lang['Logout'] . ' [ ' . $mx_user->data['username'] . ' ]';
		}
		else
		{
			$u_login_logout = mx_append_sid("login.".$phpEx);
			$l_login_logout = $lang['Login'];
		}
		
		$u_register = mx_append_sid("{$phpbb_root_path}ucp.php?mode=register&redirect=$redirect_url");
		$u_profile = mx_append_sid("{$phpbb_root_path}ucp.php?mode=editprofile");
		
		$u_modcp 	= (($phpbb_auth->acl_get('m_') || $phpbb_auth->acl_getf_global('m_'))) ? mx_append_sid('modcp/index.'.$phpEx) : '';
		$u_mcp	= (($phpbb_auth->acl_get('m_') || $phpbb_auth->acl_getf_global('m_'))) ? mx_append_sid("{$phpbb_root_path}mcp.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : ( ((($mx_user->data['user_level'] = 2) && ($mx_user->data['user_active'] = 1)) || ($mx_user->data['user_level'] == ADMIN)) ? mx_append_sid("{$phpbb_root_path}modcp.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '');
	
		$u_terms_use	= mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=terms");
		$u_privacy	= mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=privacy");
	break;

	default:
		
		// Get referer to redirect user to the appropriate page after delete action
		$redirect_url = mx_append_sid(PORTAL_URL . "index.$phpEx" . (isset($page_id) ? "?page={$page_id}" : "") . (isset($cat_nav) ? "&cat_nav={$cat_nav}" : ""));
		$u_login = mx_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=login');
		$u_register = mx_append_sid("{$phpbb_root_path}ucp.php?mode=register&redirect=$redirect_url");
		$u_profile = mx_append_sid("{$phpbb_root_path}ucp.php?mode=editprofile");
		
		$admin = ($mx_user->data['user_type'] == USER_FOUNDER) ? true : false;		
		
		if ($mx_user->data['user_id'] != ANONYMOUS)
		{
			//$u_login_logout = mx_append_sid("{$phpbb_root_path}ucp.$phpEx", "mode=logout&redirect=$redirect_url", true, $mx_user->session_id);
			$u_login_logout = mx_append_sid('login.'.$phpEx.'?logout=true&sid=' . $mx_user->data['session_id']);
			$l_login_logout = $mx_user->lang['LOGOUT'] . ' [ ' . $mx_user->data['username'] . ' ]';
		}
		else
		{
			$u_login_logout = mx_append_sid("{$phpbb_root_path}ucp.php?mode=login&redirect=$redirect_url");
			$l_login_logout = $mx_user->lang['LOGIN'];
		}
		$u_modcp 	= ($phpbb_auth->acl_get('m_') || $phpbb_auth->acl_getf_global('m_') || ($mx_user->data['session_logged_in'] && $mx_user->data['user_level'] == ADMIN))  ? mx_append_sid("{$mx_root_path}modcp/index.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '';
		$u_mcp	= ($phpbb_auth->acl_get('m_') || $phpbb_auth->acl_getf_global('m_') || ($mx_user->data['session_logged_in'] && $mx_user->data['user_level'] == ADMIN)) ? mx_append_sid("{$phpbb_root_path}mcp.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '';
	
		$u_terms_use	= mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=terms");
		$u_privacy	= mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=privacy");
	break;
}

$s_last_visit = ( $mx_user->data['session_logged_in'] ) ? mx_create_date($board_config['default_dateformat'], $mx_user->data['user_lastvisit'], $board_config['board_timezone']) : '';

// Generate logged in/logged out status
if( !is_object($mx_backend))
{
	$mx_backend = new mx_backend();
}

$mx_backend->page_header('generate_login_logout_stats');


// ================================================================================
// The following code is backported from includes/page_header.php (phpBB 2.0.13)
// ================================================================================

//
// Get basic (usernames + totals) online
// situation
//
$logged_visible_online = 0;
$logged_hidden_online = 0;
$guests_online = 0;

// Get users online list ... if required
$l_online_users = $online_userlist = $l_online_record = $l_online_time = '';

$l_online_record = $mx_user->lang('RECORD_ONLINE_USERS', (int) $board_config['record_online_users'], $mx_user->format_date($board_config['record_online_date'], false, true));

/**
* Load online data:
*/
if (defined('SHOW_ONLINE'))
{
	switch (PORTAL_BACKEND)
	{
		case 'internal':
			$sql = "SELECT u.username, u.user_id, u.user_level, s.session_logged_in, s.session_ip
				FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
				WHERE u.user_id = s.session_user_id
					AND s.session_time >= ".(time() - 300) . "
				ORDER BY u.username ASC, s.session_ip ASC";
		break;		
		case 'smf2':
			//To do:
			/** a query or we can use a session method		
			$sql = "SELECT u.id_member as u.user_id, u.member_name as u.username, u.id_group as u.user_level, s.session_id, s.data,
				FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
				WHERE u.id_member > -1
					AND s.last_update >= ".(time() - 300) . "
				ORDER BY u.member_name ASC, s.session_id ASC";
			**/
		break;
		case 'phpbb2':
			$sql = "SELECT u.username, u.user_id, u.user_allow_viewonline, u.user_level, s.session_logged_in, s.session_ip
				FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
				WHERE u.user_id = s.session_user_id
					AND s.session_time >= ".(time() - 300) . "
				ORDER BY u.username ASC, s.session_ip ASC";
		break;
		case 'phpbb3':
		default:
			$sql = "SELECT u.user_id, u.username, u.user_regdate, u.user_birthday, u.user_allow_viewonline, u.user_type, u.user_colour, s.session_autologin, s.session_ip
				FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
				WHERE u.user_id = s.session_user_id
					AND s.session_time >= ".(time() - 300) . "
				ORDER BY u.username ASC, s.session_ip ASC";
		break;
	}

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not obtain user/online information', '', __LINE__, __FILE__, $sql);
	}

	$mx_userlist_ary = array();
	$mx_userlist_visible = array();

	$prev_user_id = 0;
	$prev_user_ip = $prev_session_ip = '';

	while($row = $db->sql_fetchrow($result))
	{
		// User is logged in and therefor not a guest
		if ($mx_user->data['user_id'] != ANONYMOUS)
		{
			// Skip multiple sessions for one user
			if ( $row['user_id'] != $prev_user_id )
			{
				$style_color = '';
				//switch only supported  phpBB backends here
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'smf2':
					case 'phpbb2':
						if ( $row['user_level'] == ADMIN )
						{
							$row['username'] = '<b>' . $row['username'] . '</b>';
							$style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
						}
						else if ( $row['user_level'] == MOD )
						{
							$row['username'] = '<b>' . $row['username'] . '</b>';
							$style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
						}
					break;
					
					case 'phpbb3':
					case 'olympus':
					default:
						$style_color = ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '" class="username-coloured"' : '';
					break;
				}
				
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'smf2':
						$mx_user_online_link = '<a href="' . PORTAL_URL . '"' . $style_color .'><i>' . $row['username'] . '</i></a>';
						$logged_hidden_online++;
					break;
					case 'phpbb2':
						$mx_user_online_link = '<a href="' . mx_append_sid(PHPBB_URL."profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'><i>' . $row['username'] . '</i></a>';
						$logged_hidden_online++;
					break;
					
					case 'phpbb3':
					case 'olympus':
					default:
						if ($row['user_allow_viewonline'])
						{
							$mx_user_online_link = $mx_backend->get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
							$logged_visible_online++;
						}
						else
						{
							$mx_user_online_link = ($row['user_type'] != USER_IGNORE) ? mx_get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : '<span' . $style_color . '>' . $row['username'] . '</span>';
							$logged_hidden_online++;
						}
					break;
				}
				
				if ( $row['user_allow_viewonline'] || $mx_user->data['user_level'] == ADMIN )
				{
					$online_userlist .= ( $online_userlist != '' ) ? ', ' . $mx_user_online_link : $mx_user_online_link;
				}
			}
			$prev_user_id = $row['user_id'];
		}
		else
		{
			// Skip multiple sessions for one user
			if ( $row['session_ip'] != $prev_session_ip )
			{
				$guests_online++;
			}
		}
		$prev_session_ip = $row['session_ip'];
	}
	$db->sql_freeresult($result);

	if ( empty($online_userlist) )
	{
		$online_userlist = $lang['None'];
	}
	
	$online_userlist = ((isset($forum_id)) ? $lang['Browsing_forum'] : $lang['Registered_users']) . ' ' . $online_userlist;
	$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;

	if ($total_online_users > $board_config['record_online_users'])
	{
		$board_config['record_online_users'] = $total_online_users;
		$board_config['record_online_date'] = time();
		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
				$sql = "UPDATE " . PORTAL_TABLE . "
					SET record_online_users = '$total_online_users',
				        record_online_date = '" . $board_config['record_online_date'] . "'
				     WHERE portal_id = 1";
				if (!$db->sql_query($sql))
				{
					mx_message_die(GENERAL_ERROR, 'Could not update online user record (nr of users)', '', __LINE__, __FILE__, $sql);
				}
				
				$portal_config['record_online_users'] = $total_online_users;
				$portal_config['record_online_date'] = $board_config['record_online_date'];
				$mx_cache->put('mxbb_config', $portal_config);
			break;
			
			case 'phpbb2':
			case 'phpbb3':
			default:
				$sql = "UPDATE " . CONFIG_TABLE . "
					SET config_value = '$total_online_users'
					WHERE config_name = 'record_online_users'";			
				if (!$db->sql_query($sql))
				{
					mx_message_die(GENERAL_ERROR, 'Could not update online user record (nr of users)', '', __LINE__, __FILE__, $sql);
				}			
				$sql = "UPDATE " . CONFIG_TABLE . "
					SET config_value = '" . $board_config['record_online_date'] . "'
					WHERE config_name = 'record_online_date'";
					
				if (!$db->sql_query($sql, 300))
				{
					mx_message_die(GENERAL_ERROR, 'Could not update online user record (date)', '', __LINE__, __FILE__, $sql);
				}
				$board_config['record_online_users'] = $total_online_users;
				$board_config['record_online_date'] = $board_config['record_online_date'];
				$mx_cache->put('phpbb_config', $board_config);
			break;
		}
	}

	if ( $total_online_users == 0 )
	{
		$l_t_user_s = $lang['Online_users_zero_total'];
	}
	else if ( $total_online_users == 1 )
	{
		$l_t_user_s = $lang['Online_user_total'];
	}
	else
	{
		$l_t_user_s = $lang['Online_users_total'];
	}

	if ( $logged_visible_online == 0 )
	{
		$l_r_user_s = $lang['Reg_users_zero_total'];
	}
	else if ( $logged_visible_online == 1 )
	{
		$l_r_user_s = $lang['Reg_user_total'];
	}
	else
	{
		$l_r_user_s = $lang['Reg_users_total'];
	}

	if ( $logged_hidden_online == 0 )
	{
		$l_h_user_s = $lang['Hidden_users_zero_total'];
	}
	else if ( $logged_hidden_online == 1 )
	{
		$l_h_user_s = $lang['Hidden_user_total'];
	}
	else
	{
		$l_h_user_s = $lang['Hidden_users_total'];
	}

	if ( $guests_online == 0 )
	{
		$l_g_user_s = $lang['Guest_users_zero_total'];
	}
	else if ( $guests_online == 1 )
	{
		$l_g_user_s = $lang['Guest_user_total'];
	}
	else
	{
		$l_g_user_s = $lang['Guest_users_total'];
	}

	$l_online_users = sprintf($l_t_user_s, $total_online_users);
	$l_online_users .= sprintf($l_r_user_s, $logged_visible_online);
	$l_online_users .= sprintf($l_h_user_s, $logged_hidden_online);
	$l_online_users .= sprintf($l_g_user_s, $guests_online);	
}

//
// Obtain number of new private messages
// if user is logged in
//
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'smf2':
	case 'mybb':
	
		break;
	
	case 'phpbb2':
	case 'phpbb3':
	case 'olympus':
	case 'ascraeus':
	case 'rhea':
		
		global $phpbb_auth;
		
		if(!isset($phpbb_auth) || !is_object($phpbb_auth))
		{
			$phpbb_auth = new phpbb_auth();
		}
		$phpbb_auth->acl($mx_user->data);
		$portal_config = $mx_cache->obtain_mxbb_config();
		
		break;
}

if( class_exists('phpBB2'))
{
	$phpBB2 = new phpBB2();
}

// Output the notifications
$total_msgs = $notifications = false;
$mx_priv_msg = $lang['Private_Messages'];
if ( ($mx_user->data['session_logged_in']) && (PORTAL_BACKEND !== 'internal') && (empty($gen_simple_header)) )
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
			$icon_pm = isset($images['pm_no_new_msg']) ? $images['pm_no_new_msg'] : 'no_new_msg';
		}
		$mx_priv_msg = $lang['Private_Messages'] . ' (' . $mx_user->data['user_new_privmsg'] . ')';
	}
	else
	{
		$l_privmsgs_text = $lang['No_new_pm'];

		$s_privmsg_new = 0;
		$icon_pm = isset($images['pm_no_new_msg']) ? $images['pm_no_new_msg'] : 'no_new_msg';
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
	
	//
	// SQL to pull appropriate message, prevents nosey people
	// reading other peoples messages ... hopefully!
	//
	$privmsgs_id = $mx_request_vars->variable(POST_POST_URL, $s_privmsg_new);
	$l_box_name = $lang['Inbox'];
	
	//
	// Did the query return any data?
	//
	$notifications = array();
	
	switch (PORTAL_BACKEND)
	{
		case 'internal':
		case 'smf2':
		case 'mybb':
		
		
		break;
		
		case 'phpbb2':
			$pm_sql_user = "AND pm.privmsgs_to_userid = " . $mx_user->data['user_id'] . " 
				AND ( pm.privmsgs_type = " . PRIVMSGS_READ_MAIL . " 
					OR pm.privmsgs_type = " . PRIVMSGS_NEW_MAIL . " 
					OR pm.privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )";
			//
			// Major query obtains the message ...
			//	
			$sql = "SELECT u.username AS username_1, u.user_id AS user_id_1, u2.username AS username_2, u2.user_id AS user_id_2, u.user_sig_bbcode_uid, u.user_regdate AS user_regdate1,u.user_posts AS user_posts1, u.user_from AS user_from1, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_msnm, u.user_viewemail, u.user_rank AS user_rank1, u.user_sig, u.user_avatar AS user_avatar1,u.user_avatar_type AS user_avatar_type1, pm.*, pmt.privmsgs_bbcode_uid, pmt.privmsgs_text
				FROM " . PRIVMSGS_TABLE . " pm, " . PRIVMSGS_TEXT_TABLE . " pmt, " . USERS_TABLE . " u, " . USERS_TABLE . " u2 
				WHERE pm.privmsgs_id = pmt.privmsgs_text_id 
					$pm_sql_user 
					AND u.user_id = pm.privmsgs_from_userid 
					AND u2.user_id = pm.privmsgs_to_userid";
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not query private message post information', '', __LINE__, __FILE__, $sql);
			}
			if ( $privmsg = $db->sql_fetchrow($result) )
			{
				$notifications[] = $privmsg;
				$privmsg_id = $privmsg['privmsgs_id'];
			}
			else
			{
				$privmsg_id = $mx_request_vars->post(POST_POST_URL, MX_TYPE_NO_TAGS, $s_privmsg_new);
			}
			$db->sql_freeresult($result);
		break;
		
		case 'phpbb3':
		case 'olympus':
		case 'ascraeus':
		case 'rhea':
			
			//
			// Major query obtains the message ...
			//
			$sql = 'SELECT p.*, u.*
				FROM ' . PRIVMSGS_TABLE . ' p, ' . USERS_TABLE . ' u
				WHERE p.author_id <> u.user_id
					AND u.user_id = ' . $mx_user->data['user_id'];
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not query private message post information', '', __LINE__, __FILE__, $sql);
			}
			if ( $privmsg = $db->sql_fetchrow($result) )
			{
				$notifications[] = $privmsg;
				$privmsg_id = $privmsg['privmsgs_id'];
			}
			else
			{
				$privmsg_id = $mx_request_vars->post(POST_POST_URL, MX_TYPE_NO_TAGS, $s_privmsg_new);
			}
			$db->sql_freeresult($result);
		break;
	}
	
	if ( !($total_msgs = count($notifications)) )
	{
		$total_msgs = 0;
		
		// Merge default options
		$notifications = array_merge(array(
			'notification_id'		=> 0,
			'notification_time'	=> time(),
			'user_id'				=> $mx_user->data['user_id'],
			'order_by'				=> 'notification_time',
			'older_unread'		=> 1,
			'order_dir'			=> 'DESC',
			'all_unread'			=> 0,
			'unread_count'		=> 0,
			'limit'					=> 5,
			'start'					=> 0,
			'REASON'			=> 'Could not query private message post information',
			'count_unread'		=> 0,
			'count_total'			=> $total_msgs,
		), $notifications);	
	}
	
	// Merge default options
	$notifications = array_merge(array(
		'notification_id'		=> $privmsg_id,
		'notification_time'	=> !empty($privmsg['privmsgs_date']) ? $privmsg['privmsgs_date'] : time(),
		'user_id'				=> $mx_user->data['user_id'],
		'order_by'				=> 'notification_time',
		'older_unread'		=> $s_privmsg_new,
		'order_dir'			=> 'DESC',
		'all_unread'			=> $s_privmsg_new,		
		'unread_count'		=> $s_privmsg_new,	
		'limit'					=> 5,
		'start'					=> 0,
		'REASON'			=> $privmsg['privmsgs_text'],
		'count_unread'		=> $s_privmsg_new,
		'count_total'			=> $total_msgs,
	), $notifications);
}
else
{
	$icon_pm = isset($images['pm_no_new_msg']) ? $images['pm_no_new_msg'] : 'no_new_msg';
	$l_privmsgs_text = $lang['Login_check_pm'];
	$l_privmsgs_text_unread = '';
	$s_privmsg_new = 0;
	$privmsg_id = 0;
	
	$notifications = array(
		'all_unread'		=> $s_privmsg_new,
		'unread_count'	=> $s_privmsg_new,	
		'limit'				=> 5,
	);
	// Merge default options
	$notifications = array_merge(array(
		'notification_id'			=> false,
		'notification_time'		=> time(),
		'user_id'					=> $mx_user->data['user_id'],
		'order_by'					=> 'notification_time',
		'order_dir'					=> 'DESC',
		'limit'						=> 5,
		'start'						=> 0,
		'all_unread'				=> $s_privmsg_new,
		'count_unread'			=> $s_privmsg_new,
		'count_total'				=> false,
		'S_ROW_COUNT'		=> 0,
		'S_NUM_ROWS'		=> 0,
		'UNREAD'					=> 0,
		'STYLING'					=> 0,
		'URL'						=> 0,
		'U_MARK_READ'		=> 0,
		'AVATAR'					=> 0,
		'T_THEME_PATH'		=> 0,
		'FORMATTED_TITLE'	=> 0,
		'REFERENCE'				=> 0,
		'FORUM'					=> 0,
		'REASON'					=> 0,
		'TIME'						=> 0,
		'U_MARK_READ'		=> 0,
	), $notifications);
}
$notification_mark_hash = mx_generate_link_hash('mark_all_notifications_read');
$mark_hash = mx_generate_link_hash('mark_notification_read');
$u_mark_read = mx_append_sid($phpbb_root_path . 'privmsg.' . $phpEx . '?mark_notification=' . $notifications['notification_id'] . '&amp;folder=inbox&amp;hash=' . $mark_hash);

// Login box?
//
if ( !$mx_user->data['session_logged_in'] )
{
	$template->assign_block_vars('switch_user_logged_out', array());
	//
	// Allow autologin?
	//
	if (!isset($board_config['allow_autologin']) || $board_config['allow_autologin'] )
	{
		$template->assign_block_vars('switch_allow_autologin', array());
		$template->assign_block_vars('switch_user_logged_out.switch_allow_autologin', array());
	}
	$template->assign_block_vars('notifications', array());	
}
else
{
	$template->assign_block_vars('switch_user_logged_in', array());
	
	//if ( !empty($mx_userdata['user_popup_pm']) )
	//{
		$template->assign_block_vars('switch_enable_pm_popup', array());
		
		$template->assign_block_vars('notifications', array(
			'NOTIFICATION_ID'	=> $notifications['notification_id'],

			'USER_ID' 					=>  $notifications['user_id'], 
			'ORDER_BY' 				=>  $notifications['order_by'], 
			'ORDER_DIR' 			=>  $notifications['order_dir'], 
			'ALL_UNREAD'	 		=>  $notifications['all_unread'],
			'UNREAD_COUNT' 	=>  $notifications['unread_count'],
			'LIMIT' 						=>  $notifications['limit'], 
			'START' 					=>  $notifications['start'], 
			'COUNT_UNREAD' 	=>  $notifications['count_unread'], 
			'COUNT_TOTAL' 		=>  $notifications['count_total'], 
			
			'STYLING'					=> 'notification-reported',
			'AVATAR'					=> mx_get_user_avatar($mx_user->data),
			'FORMATTED_TITLE'	=> $mx_user->lang('NOTIFICATION', $mx_user->data['username'], false),
			
			'REFERENCE'				=> $mx_user->lang('NOTIFICATION_REFERENCE', mx_censor_text($l_privmsgs_text)),
			'FORUM'					=> mx_append_sid('privmsg.'.$phpEx.'?folder=inbox'), //$this->get_forum(),
			'REASON'					=> $notifications['REASON'], //$this->get_reason(),
			'URL'						=> mx_append_sid('privmsg.'.$phpEx.'?folder=inbox'), //$this->get_url(),
			
			'TIME'	   					=> $mx_user->format_date($notifications['notification_time']),
			
			'UNREAD'					=> $l_privmsgs_text_unread,
			'U_MARK_READ'		=> (!$mx_user->data['user_unread_privmsg']) ? $u_mark_read : '',
		));	
	//}
}

switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'smf2':
	case 'mybb':
		
		if ( !defined('PHPBB_VERSION') )
		{
			define('PHPBB_VERSION', $board_config['portal_version']);
		}	
	
	break;
	
	case 'phpbb2':
		
		if ( !defined('PHPBB_VERSION') )
		{
			define('PHPBB_VERSION', '2'.$board_config['version']);
		}	
	
	break;
	
	case 'phpbb3':
	case 'olympus':
	case 'ascraeus':
	case 'rhea':
	case 'proteus':
	default:
		if ( !defined('PHPBB_VERSION') )
		{
			define('PHPBB_VERSION', $board_config['version']);
		}
		
	break;
}

//
// Generate HTML required for Mozilla Navigation bar
//
if ( !isset( $nav_links ) )
{
	$nav_links = array();
}

$nav_links_html = '';
$nav_link_proto = '<link rel="%s" href="%s" title="%s" />' . "\n";
/*
* Import phpBB Graphics, prefix with PHPBB_URL, and apply LANG info
/* start Migrating from php5 to php7+ replace
	foreach ($images as $default_key => $default_value) {
with
	while(list($nav_item, $nav_array) = each($nav_links))
ends Migrating
*/
foreach ($nav_links as $nav_item => $nav_array) 
{
	if ( !empty($nav_array['url']) )
	{
		$nav_links_html .= sprintf($nav_link_proto, $nav_item, mx_append_sid($nav_array['url']), $nav_array['title']);
	}
	else
	{
		// We have a nested array, used for items like <link rel='chapter'> that can occur more than once.
		// while( list(,$nested_array) = each($nav_array) )
		foreach ($nav_array as $nested_array) 
		{
			$nav_links_html .= sprintf($nav_link_proto, $nav_item, $nested_array['url'], $nested_array['title']);
		}
	}
}

$forum_id = $mx_request_vars->variable('f', (isset($forum_id) ? $forum_id : 0));
$topic_id = $mx_request_vars->variable('t', (isset($topic_id) ? $topic_id : 0));

$s_feed_news = isset($s_feed_news) ? $s_feed_news : false;

//
// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
//
$l_timezone = explode( '.', $board_config['board_timezone'] );
$l_timezone = ( count( $l_timezone ) > 1 && $l_timezone[count( $l_timezone )-1] != 0 ) ? $lang[sprintf( '%.1f', $board_config['board_timezone'] )] : $board_config['board_timezone'];

if (empty($mx_page->page_alt_icon))
{
	$page_icon_img = ( !empty($mx_page->page_icon) && $mx_page->page_icon != 'none' && file_exists($mx_root_path . $images['mx_graphics']['page_icons'] . '/' . $mx_page->page_icon) ) ? '<img valign="middle" src="' . PORTAL_URL . $images['mx_graphics']['page_icons'] . '/' . $mx_page->page_icon . '" alt="" />&nbsp;&nbsp;' : '';
}
else
{
	$page_icon_img = '<img valign="middle" src="' . $mx_page->page_alt_icon . '" alt="" />&nbsp;&nbsp;';
}

// Search box
$search_page_id_site = get_page_id('mx_search.' . $phpEx, true);
$option_search_site = !empty($search_page_id_site) ? '<option value="site">' . $lang['Mx_search_site'] . '</option>' : '';

$option_search_forum = '<option value="forum">' . $lang['Mx_search_forum'] . '</option>';
$option_search_google = '<option value="google">' . $lang['Mx_search_google'] . '</option>';

// Search box official modules
$search_page_id_kb = get_page_id('kb.' . $phpEx, true);
$option_search_kb = !empty($search_page_id_kb) ? '<option value="kb">' . $lang['Mx_search_kb'] . '</option>' : '';

$search_page_id_pub = get_page_id('app.' . $phpEx, true);
$option_search_pub = !empty($search_page_id_pub) ? '<option value="pub">' . $lang['Mx_search_pub'] . '</option>' : '';

$search_page_id_pafiledb = get_page_id('dload.' . $phpEx, true);
$option_search_pafiledb = !empty($search_page_id_pafiledb) ? '<option value="pafiledb">' . $lang['Mx_search_pafiledb'] . '</option>' : '';

//
// Generate list of additional css files to include (defined by modules)
//
$mx_addional_css_files = '';
if (isset($mx_page->mxbb_css_addup) && (count($mx_page->mxbb_css_addup) > 0))
{
	foreach($mx_page->mxbb_css_addup as $key => $mx_css_path)
	{
		$mx_addional_css_files .= "\n".'<link rel="stylesheet" href="'. PORTAL_URL . $mx_css_path . '" type="text/css" >';
	}
}

//
// Generate list of additional js files to include (defined by modules)
//
$mx_addional_js_files = '';
if (isset($mx_page->mxbb_js_addup) && (count($mx_page->mxbb_js_addup) > 0))
{
	foreach($mx_page->mxbb_js_addup as $key => $mx_js_path)
	{
		$mx_addional_js_files .= "\n".'<script language="javascript" type="text/javascript" src="'. PORTAL_URL . $mx_js_path . '"></script>';
	}
}

//
// Generate additional header code (defined by modules)
//
$mx_addional_header_text = '';
if (isset($mx_page->mxbb_header_addup) && (count($mx_page->mxbb_header_addup) > 0))
{
	foreach($mx_page->mxbb_header_addup as $key => $mx_header_text)
	{
		$mx_addional_header_text .= "\n"."\n".$mx_header_text;
	}
}

// Send a proper content-language to the output
$user_lang = isset($mx_user->lang['USER_LANG']) ? $mx_user->lang['USER_LANG'] : $mx_user->encode_lang($mx_user->lang_name);
if (strpos($user_lang, '-x-') !== false)
{
	$user_lang = substr($user_lang, 0, strpos($user_lang, '-x-'));
}

$phpbb_version_parts = explode('.', PHPBB_VERSION, 3);
$phpbb_major = $phpbb_version_parts[0] . '.' . $phpbb_version_parts[1];

if ((!defined('USER_ACTIVATION_NONE') || !defined('USER_ACTIVATION_SELF')))
{
	@define('USER_ACTIVATION_NONE', 0);
	@define('USER_ACTIVATION_SELF', 1);
}

if ((!defined('USER_ACTIVATION_ADMIN') || !defined('USER_ACTIVATION_DISABLE')))
{
	@define('USER_ACTIVATION_ADMIN', 2);
	@define('USER_ACTIVATION_DISABLE', 3);
}

//
// Show the overall footer.
//
$admin_link = ($mx_user->data['user_level'] == ADMIN) ? '<a href="admin/index.' . $phpEx . '?sid=' . $mx_user->data['session_id'] . '">' . $lang['Admin_panel'] . '</a><br /><br />' : '';

// Forum rules and subscription info
$s_watching_forum = array(
	'link'				=> '',
	'link_toggle'	=> '',
	'title'				=> '',
	'title_toggle'	=> '',
	'is_watching'	=> false,
);

$default_lang = ($mx_user->data['user_lang']) ? $mx_user->data['user_lang'] : $portal_config['default_lang'];
if (empty($default_lang))
{
	// - populate $default_lang
	$default_lang= 'english';
}

$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'smf2':
	case 'mybb':
	case 'phpbb2':
		$admin = ($mx_user->data['session_logged_in'] && $mx_user->data['user_level'] == ADMIN) ? true : false;
		$mod = ($mx_user->data['session_logged_in'] && $mx_user->data['user_level'] == MOD) ? true : 0;
	break;

	case 'phpbb3':
	case 'olympus':
	case 'ascraeus':
	case 'rhea':
		global $phpbb_auth;
		$admin = (!$phpbb_auth->acl_get('a_') && $mx_user->data['user_id'] != ANONYMOUS) ? true : false;
		$mod = (!$phpbb_auth->acl_get('m_') && $mx_user->data['user_id'] != ANONYMOUS) ? true : 0;
	break;
}

//
// Grab MXP global variables, re-cache if necessary
// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the MX-Publisher cache whenever updating MXP config settings
// - true: enable cache, false: disable cache
if (empty($portal_config['portal_status']))
{
	$portal_config = $mx_cache->obtain_mxbb_config(false);
}

/**
* Instantiate the mx_language class
* $language->_load_lang($mx_root_path, 'lang_main');
*/
if (empty($language))
{
	$language = new mx_language();
}

$web_path = (empty($portal_config['portal_url'])) ? PORTAL_URL : $portal_config['portal_url'];
$https_path = str_replace("http://", "https://", $web_path);
$web_path = str_replace("https://", "http://", $web_path);

$page_title = isset($lang[str_replace(' ', '_', $mx_page->page_title)]) ? $lang[str_replace(' ', '_', $mx_page->page_title)] : $language->lang($mx_page->page_title);
$page_desc = isset($lang[str_replace(' ', '_', $mx_page->page_desc)]) ? $lang[str_replace(' ', '_', $mx_page->page_desc)] : $language->lang($mx_page->page_desc);
$sitename = isset($lang[str_replace(' ', '_', $board_config['sitename'])]) ? $lang[str_replace(' ', '_', $board_config['sitename'])] : $language->lang($board_config['sitename']); 
$site_desc = isset($lang[str_replace(' ', '_', $board_config['site_desc'])]) ? $lang[str_replace(' ', '_', $board_config['site_desc'])] : $language->lang($board_config['site_desc']); 

//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//
$layouttemplate->assign_vars(array(
	'SITENAME' 						=> $sitename,
	'SITE_DESCRIPTION' 		=> $site_desc,
	'PAGE_TITLE' 					=> $page_title,
	'PAGE_DESC' 					=> $page_desc,
	'LANG' 								=> $mx_user->img_lang,
	'SCRIPT_NAME' 				=> str_replace('.' . $phpEx, '', basename(__FILE__)),	
	'LAST_VISIT_DATE' 			=> sprintf($lang['You_last_visit'], $s_last_visit),
	'LAST_VISIT_YOU' 				=> $s_last_visit,
	'CURRENT_TIME' 				=> sprintf($lang['Current_time'], mx_create_date($board_config['default_dateformat'], time(), $board_config['board_timezone'])),
	'TOTAL_USERS_ONLINE' 	=> $l_online_users,
	'RECORD_USERS' 				=> $l_online_record,
	'LOGGED_IN_USER_LIST' 	=> $online_userlist,
	'RECORD_USERS' 				=> sprintf($lang['Record_online_users'], $board_config['record_online_users'], mx_create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),
	
	'CURRENT_USER_AVATAR'				=> mx_get_user_avatar($mx_user->data),
	'CURRENT_USERNAME_SIMPLE'		=> mx_get_username_string('no_profile', $mx_user->data['user_id'], $mx_user->data['username'], $mx_user->data['user_colour']),
	'CURRENT_USERNAME_FULL'			=> mx_get_username_string('full', $mx_user->data['user_id'], $mx_user->data['username'], $mx_user->data['user_colour']),				
	
	'S_NOTIFICATIONS_DISPLAY'	=> true,	
	'S_SHOW_COPPA'						=> false,
	'S_REGISTRATION'					=> true,	
	
	'UNREAD_NOTIFICATIONS_COUNT'	=> ($notifications !== false) ? $notifications['unread_count'] : '',
	'NOTIFICATIONS_COUNT'				=> ($notifications !== false) ? $notifications['unread_count'] : '',
	'U_VIEW_ALL_NOTIFICATIONS'		=> mx_append_sid("{$phpbb_root_path}profile.$phpEx?i=ucp_notifications"),
	'U_MARK_ALL_NOTIFICATIONS'	=> mx_append_sid("{$phpbb_root_path}profile.$phpEx?i=ucp_notifications&amp;mode=notification_list&amp;mark=all&amp;token=" . $notification_mark_hash),
	'U_NOTIFICATION_SETTINGS'		=> mx_append_sid("{$phpbb_root_path}profile.$phpEx?i=ucp_notifications&amp;mode=notification_options"),
	'S_NOTIFICATIONS_DISPLAY'		=> $mx_user->data['user_active'],	
	
	'loops'											=> '', // To get loops
	
	'L_CHANGE_FONT_SIZE'				=> $lang['CHANGE_FONT_SIZE'], 
	'FONT_SIZE_CHANGE'					=> '- -- -', 
	
	'S_PLUPLOAD'							=> false,
	'S_IN_SEARCH'							=> false,
	'S_DISPLAY_QUICK_LINKS'			=> true,
	
	'S_USER_NEW_PRIVMSG'				=> $mx_user->data['user_new_privmsg'],
	'S_USER_UNREAD_PRIVMSG'			=> $mx_user->data['user_unread_privmsg'],
	'S_USER_NEW'								=> ($mx_user->data['user_active'] == 0) ? true : false,

	'RECORD_USERS' => sprintf($lang['Record_online_users'], $board_config['record_online_users'], mx_create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),
	
	'PRIVATE_MESSAGE_COUNT'				=> (!empty($mx_user->data['user_unread_privmsg'])) ? $mx_user->data['user_unread_privmsg'] : 0,
	'PRIVATE_MESSAGE_INFO' 					=> $l_privmsgs_text,
	'PRIVATE_MESSAGE_INFO_UNREAD' 	=> $l_privmsgs_text_unread,
	'PRIVATE_MESSAGE_NEW_FLAG' 			=> $s_privmsg_new,

	'PRIVMSG_IMG' => $icon_pm,

	'L_USERNAME' => $lang['Username'],
	'L_PASSWORD' => $lang['Password'],
	'L_LOGIN_LOGOUT' => $l_login_logout,
	'L_LOGIN' => $lang['Login'],
	'L_LOG_ME_IN' => $lang['Log_me_in'],
	'L_AUTO_LOGIN' => $lang['Log_me_in'],
	'L_HOME' => $lang['MX_home'],
	'L_FORUM' => $lang['MX_forum'],
	'L_INDEX' => $board_config['sitename'],
	'L_SITE_HOME' => ($board_config['sitename'] !== '') ? $board_config['sitename'] : $mx_user->lang['HOME'],
	'L_REGISTER' => $lang['Register'],
	'L_PROFILE' => $lang['Profile'],
	'L_SEARCH' => $lang['Search'],
	'L_PRIVATEMSGS' => $mx_priv_msg,
	'L_WHO_IS_ONLINE' => $lang['Who_is_Online'],
	'L_MEMBERLIST' => $lang['Memberlist'],
	'L_FAQ' => $lang['FAQ'],
	'L_USERGROUPS' => $lang['Usergroups'],
	'L_SEARCH_NEW' => $lang['Search_new'],
	'L_SEARCH_UNANSWERED' => $lang['Search_unanswered'],
	'L_SEARCH_SELF' => $lang['Search_your_posts'],
	'L_WHOSONLINE_ADMIN' => isset($mx_user->theme['fontcolor3']) ? sprintf($lang['Admin_online_color'], '<span style="color:#' . $mx_user->theme['fontcolor3'] . '">', '</span>') : '',
	'L_WHOSONLINE_MOD' => isset($mx_user->theme['fontcolor2']) ? sprintf($lang['Mod_online_color'], '<span style="color:#' . $mx_user->theme['fontcolor2'] . '">', '</span>') : '',
	'L_BACK_TO_TOP' => $lang['Back_to_top'],

	'U_SEARCH_UNANSWERED' => mx_append_sid(PHPBB_URL . 'search.'.$phpEx.'?search_id=unanswered'),
	'U_SEARCH_SELF' => mx_append_sid(PHPBB_URL .'search.'.$phpEx.'?search_id=egosearch'),
	'U_SEARCH_NEW' => mx_append_sid(PHPBB_URL .'search.'.$phpEx.'?search_id=newposts'),

	'LOGO' => isset($images['mx_logo']) ? $images['mx_logo'] : '',
	'THEME_GRAPHICS' => isset($images['theme_graphics']) ? $images['theme_graphics'] : '',

	'NAV_IMAGES_HOME' 					=> $images['mx_nav_home'],
	'NAV_IMAGES_FORUM' 				=> $images['mx_nav_forum'],
	'NAV_IMAGES_PROFILE' 				=> $images['mx_nav_profile'],
	'NAV_IMAGES_FAQ' 						=> $images['mx_nav_faq'],
	'NAV_IMAGES_SEARCH' 				=> $images['mx_nav_search'],
	'NAV_IMAGES_MEMBERS' 			=> $images['mx_nav_members'],
	'NAV_IMAGES_GROUPS' 				=> $images['mx_nav_groups'],
	'NAV_IMAGES_PRIVMSG' 				=> $images['mx_nav_mail'],
	'NAV_IMAGES_LOGIN_LOGOUT' 	=> $images['mx_nav_login'],
	'NAV_IMAGES_REGISTER' 				=> $images['mx_nav_register'],

	'L_POST_BY_AUTHOR' 			=> $lang['Post_by_author'],
	'L_POSTED_ON_DATE' 			=> $lang['Posted_on_date'],
	'L_IN' 									=> $lang['In'],	
	
	//navbar_footer
	'U_WATCH_FORUM_LINK'			=> $s_watching_forum['link'],
	'U_WATCH_FORUM_TOGGLE'	=> $s_watching_forum['link_toggle'],
	'S_WATCH_FORUM_TITLE'			=> $s_watching_forum['title'],
	'S_WATCH_FORUM_TOGGLE'	=> $s_watching_forum['title_toggle'],
	'S_WATCHING_FORUM'			=> $s_watching_forum['is_watching'],
	
	'U_SEARCH_SELF'						=> mx_append_sid("{$phpbb_root_path}search.$phpEx?search_id=egosearch"),
	'U_SEARCH_NEW'						=> mx_append_sid("{$phpbb_root_path}search.$phpEx?search_id=newposts"),
	'U_SEARCH_UNANSWERED'		=> mx_append_sid("{$phpbb_root_path}search.$phpEx?search_id=unanswered"),
	'U_SEARCH_UNREAD'				=> mx_append_sid("{$phpbb_root_path}search.$phpEx?search_id=unreadposts"),
	'U_SEARCH_ACTIVE_TOPICS'		=> mx_append_sid("{$phpbb_root_path}search.$phpEx?search_id=active_topics"),
	
	'U_INDEX' 							=> mx_append_sid("{$phpbb_root_path}index.$phpEx"),
	'U_CANONICAL' 					=> mx_append_sid(PORTAL_URL . "index.$phpEx"),		
	'U_SITE_HOME'					=> (!empty($board_config['site_home_url'])) ? $board_config['site_home_url'] : mx_append_sid('./../index.'.$phpEx),	
	'U_REGISTER' 					=> $u_register,
	'U_PROFILE' 						=> $u_profile,
	'U_RESTORE_PERMISSIONS'	=> mx_append_sid("{$phpbb_root_path}memberlist.$phpEx?mode=restore_perm"),
	'U_USER_PROFILE'				=> mx_get_username_string('profile_url', $mx_user->data['user_id'], $mx_user->data['username'], false),	
	'U_PRIVATEMSGS' 				=> mx_append_sid('privmsg.'.$phpEx.'?folder=inbox'),
	'U_PRIVATEMSGS_POPUP' 	=> mx_append_sid('privmsg.'.$phpEx.'?mode=newpm'),
	'U_SEARCH' 						=> mx_append_sid('search.'.$phpEx),
	'U_MEMBERLIST' 				=> mx_append_sid("{$phpbb_root_path}memberlist.".$phpEx),
	'U_MXMCP' 						=> $u_modcp, //MXP ModCP
	'U_MCP'							=> $u_mcp, //Forum MCP
	'U_FAQ' 							=> mx_append_sid("{$phpbb_root_path}faq.".$phpEx),
	'U_VIEWONLINE' 				=> mx_append_sid("{$phpbb_root_path}viewonline.".$phpEx),
	'U_LOGIN_LOGOUT' 			=> $u_login_logout,
	'U_GROUP_CP' 					=> mx_append_sid("{$phpbb_root_path}groupcp.".$phpEx),
	
	'U_SEND_PASSWORD' 			=> ($mx_user->data['user_email']) ? mx_append_sid("{$phpbb_root_path}profile.$phpEx?mode=sendpassword") : '',
	
	'S_VIEWTOPIC' 						=> mx_append_sid("{$phpbb_root_path}viewtopic.$phpEx?" . "f=" . $forum_id . "&amp;t=" . $topic_id), 
	'S_VIEWFORUM' 					=> mx_append_sid("{$phpbb_root_path}viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"),
	'S_IN_MCP' 							=> defined('IN_MCP') ? true : false,
	'L_ACP_SHORT'						=> $mx_user->lang('ACP_SHORT'),
	'L_MCP_SHORT'						=> $mx_user->lang('MCP'),
	'L_UCP'									=> $mx_user->lang('UCP'),
	'S_IN_PROFILE' 						=> defined('IN_PROFILE') ? true : false,
	'S_IN_UCP' 							=> defined('IN_UCP') ? true : false,	
	
	'U_CONTACT_US'				=> ($mx_user->data['user_last_privmsg']) ? mx_append_sid("{$phpbb_root_path}memberlist.$phpEx?mode=contactadmin") : '',
	'U_TEAM'							=> ($mx_user->data['user_id'] != ANONYMOUS && (PORTAL_BACKEND !== 'internal') && $phpbb_auth->acl_get('u_viewprofile')) ?  mx_append_sid("{$phpbb_root_path}memberlist.$phpEx?mode=team") : '',
	
	'U_TERMS_USE'					=> $u_terms_use,
	'U_PRIVACY'						=> $u_privacy,
	
	'U_RESTORE_PERMISSIONS'	=> ($mx_user->data['user_perm_from'] && (PORTAL_BACKEND !== 'internal') && $phpbb_auth->acl_get('a_switchperm')) ? mx_append_sid("{$phpbb_root_path}profile.$phpEx?mode=restore_perm") : '',
	'U_FEED'				=> '',	
		
	'S_CONTENT_DIRECTION'			=> $lang['DIRECTION'] ? $lang['DIRECTION'] : $mx_user->lang['DIRECTION'],
	'S_CONTENT_FLOW_BEGIN'		=> ($lang['DIRECTION'] == 'ltr') ? 'left' : 'right',
	'S_CONTENT_FLOW_END'			=> ($lang['DIRECTION'] == 'ltr') ? 'right' : 'left',
	'S_CONTENT_ENCODING'			=> $lang['ENCODING'] ? $lang['ENCODING'] : 'UTF-8',	
	'S_CONTENT_DIR_LEFT'			=> $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT'			=> $lang['RIGHT'],

	'S_LOGIN_ACTION'		=> ((!defined('ADMIN_START')) ? $u_login : mx_append_sid("{$phpbb_admin_path}index.$phpEx", false, true, $mx_user->session_id)),
	'S_LOGIN_REDIRECT'		=> mx_build_hidden_fields(array('redirect' => PORTAL_URL)),
	'S_ADMIN_AUTH' 			=> $admin,
	
	//Login page or box constants
	'S_USER_LOGGED_IN' 		=> ($mx_user->data['user_id'] != ANONYMOUS) ? true : false,
	'S_AUTOLOGIN_ENABLED'	=> ($board_config['allow_autologin']) ? true : false,
	'S_BOARD_DISABLED'			=> ($portal_config['portal_status']) ? false : true,
	'S_USERNAME'					=> !empty($mx_user->data['username']) ? $mx_user->data['username'] : 'Anonymous',
	'S_REGISTERED_USER'		=> (!empty($mx_user->data['user_active'])) ? true : false,
	'S_IS_BOT'						=> (!empty($mx_user->data['is_bot'])) ? true : false,
	'S_USER_LANG'					=> $user_lang,
	'S_USER_BROWSER'			=> (isset($mx_user->data['session_browser'])) ? $mx_user->data['session_browser'] : $mx_user->lang('UNKNOWN_BROWSER'),

	'S_LOAD_UNREADS'		=> ($mx_user->data['user_id'] != ANONYMOUS) ? true : false,	
	
	'S_TIMEZONE'					=> sprintf($lang['All_times'], $l_timezone),
	'S_DISPLAY_ONLINE_LIST'	=> ($l_online_time) ? 1 : 0,
	'S_DISPLAY_SEARCH'			=> (isset($auth) ? ($mx_user->data['user_id'] != ANONYMOUS) : 1),
	'S_DISPLAY_PM'				=> ($mx_user->data['user_id'] != ANONYMOUS) ? true : false,
	'S_DISPLAY_MEMBERLIST'	=> (isset($auth)) ? ($mx_user->data['user_id'] != ANONYMOUS) : 0,
	'S_NEW_PM'						=> ($s_privmsg_new) ? 1 : 0,
	'S_REGISTER_ENABLED'		=> ($board_config['require_activation'] != USER_ACTIVATION_DISABLE) ? true : false,
	'S_FORUM_ID'					=> $forum_id,
	'S_TOPIC_ID	'					=> $topic_id,

	'S_SIMPLE_MESSAGE'		=> false,

	//+ MX-Publisher
	'U_PORTAL_ROOT_PATH'	=> PORTAL_URL,
	'U_PHPBB_ROOT_PATH'		=> PHPBB_URL,
	'TEMPLATE_ROOT_PATH'	=> TEMPLATE_ROOT_PATH,
	
	'SID'							=> !empty($SID) ? $SID : $mx_user->session_id,
	'_SID'						=> !empty($_GET['sid']) ? $_GET['sid'] : $mx_user->session_id,
	'SESSION_ID'				=> !empty($mx_user->data['session_id']) ? $mx_user->data['session_id'] : (isset($_COOKIE[$board_config['cookie_name'] . '_sid'] ) ? $_COOKIE[$board_config['cookie_name'] . '_sid'] : ''),
	'ROOT_PATH'			=> $web_path,
	'FULL_SITE_PATH'		=> $web_path,
	'CMS_PAGE_HOME'		=> PORTAL_URL,
	'BOARD_URL'				=> PORTAL_URL,
	'PHPBB_VERSION'		=> PHPBB_VERSION,
	'PHPBB_MAJOR'			=> $phpbb_major,
	'S_COOKIE_NOTICE'	=> !empty($board_config['cookie_name']),
	
	'T_ASSETS_VERSION'		=> $phpbb_major,
	'T_ASSETS_PATH'			=> "{$web_path}assets",	
	'T_THEME_PATH'			=> "{$web_path}templates/" . rawurlencode($theme['template_name'] ? $theme['template_name'] : str_replace('.css', '', $theme['head_stylesheet'])) . '/theme',
	'T_TEMPLATE_PATH'		=> "{$web_path}templates/" . rawurlencode($theme['template_name']) . '',
	'T_SUPER_TEMPLATE_PATH'	=> "{$web_path}templates/" . rawurlencode($theme['template_name']) . '/template',
		
	'T_IMAGES_PATH'			=> "{$web_path}images/",
	'T_SMILIES_PATH'		=> "{$web_path}{$board_config['smilies_path']}/",
	'T_AVATAR_GALLERY_PATH'	=> "{$web_path}{$board_config['avatar_gallery_path']}/",
	
	'T_ICONS_PATH'				=> !empty($board_config['icons_path']) ? "{$web_path}{$board_config['icons_path']}/" : $web_path.'/images/icons/',
	'T_RANKS_PATH'			=> !empty($board_config['ranks_path']) ? "{$web_path}{$board_config['ranks_path']}/" : $web_path.'/images/ranks/',
	'T_UPLOAD_PATH'			=> !empty($board_config['upload_path']) ? "{$web_path}{$board_config['upload_path']}/" : $web_path.'/cache/',	
	
	'T_STYLESHEET_LINK'		=> "{$web_path}templates/" . rawurlencode($theme['template_name'] ? $theme['template_name'] : str_replace('.css', '', $theme['head_stylesheet'])) . '/theme/stylesheet.css',
	'T_STYLESHEET_LANG_LINK'=> "{$web_path}templates/" . rawurlencode($theme['template_name'] ? $theme['template_name'] : str_replace('.css', '', $theme['head_stylesheet'])) . '/theme/images/lang_' . $default_lang . '/stylesheet.css',
	'T_FONT_AWESOME_LINK'	=> "{$web_path}assets/css/font-awesome.min.css",
	'T_FONT_IONIC_LINK'			=> "{$web_path}assets/css/ionicons.min.css",

	'T_JQUERY_LINK'			=> !empty($board_config['allow_cdn']) && !empty($board_config['load_jquery_url']) ? $board_config['load_jquery_url'] : "{$web_path}assets/javascript/jquery.min.js?assets_version=" . $phpbb_major,
	'S_ALLOW_CDN'				=> !empty($board_config['allow_cdn']),
	

	'T_THEME_NAME'			=> rawurlencode($theme['template_name']),
	'T_THEME_LANG_NAME'		=> $mx_user->data['user_lang'],
	'T_TEMPLATE_NAME'		=> $theme['template_name'],
	'T_SUPER_TEMPLATE_NAME'	=> rawurlencode($theme['template_name']),
	'T_IMAGES'				=> 'images',
	'T_SMILIES'				=> $board_config['smilies_path'],
	'T_AVATAR_GALLERY'		=> $board_config['avatar_gallery_path'],
	
	'T_ICONS_PATH'		=> !empty($board_config['icons_path']) ? $board_config['icons_path'] : '/images/icons/',
	'T_RANKS_PATH'		=> !empty($board_config['ranks_path']) ? $board_config['ranks_path'] : '/images/ranks/',
	'T_UPLOAD_PATH'		=> !empty($board_config['upload_path']) ? $board_config['upload_path'] : '/cache/',

	'SITE_LOGO_IMG'		=> ($theme['template_name'] == 'subSilver') ? 'logo_phpBB.gif' : 'site_logo.gif',	
		
	//To Do - configurable in AdminCP
	//Display full login box with autologin option
	'S_DISPLAY_FULL_LOGIN' => true,
	'S_IS_MOBILE' => (isset($mx_user->data['is_mobile']) && ($mx_user->data['is_mobile'] == 1)) ? true : false,
	//Old phpBB2 Backend Contant 
	'IS_ADMIN' => $admin,
	
 	//phpBB3 Backend Contant 	
	'S_ADMIN_AUTH' => $admin,
	
	// These theme variables are not used for MX-Publisher, since MX-Publisher require a theme.css file
	'T_HEAD_STYLESHEET' => isset($mx_user->theme['head_stylesheet']) ? $mx_user->theme['head_stylesheet'] : 'stylesheet.css',
	'T_BODY_BACKGROUND' => isset($mx_user->theme['body_background']) ? $mx_user->theme['body_background'] : '',
	'T_BODY_BGCOLOR' => isset($mx_user->theme['body_bgcolor']) ? '#' . $mx_user->theme['body_bgcolor'] : '',
	'T_BODY_TEXT' => isset($mx_user->theme['body_text']) ? '#' . $mx_user->theme['body_text'] : '',
	'T_BODY_LINK' => isset($mx_user->theme['body_link']) ? '#' . $mx_user->theme['body_link'] : '',
	'T_BODY_VLINK' => isset($mx_user->theme['body_vlink']) ? '#' . $mx_user->theme['body_vlink'] : '',
	'T_BODY_ALINK' => isset($mx_user->theme['body_alink']) ? '#' . $mx_user->theme['body_alink'] : '',
	'T_BODY_HLINK' => isset($mx_user->theme['body_hlink']) ? '#' . $mx_user->theme['body_hlink'] : '',
	'T_TR_COLOR1' => isset($mx_user->theme['tr_color1']) ? '#' . $mx_user->theme['tr_color1'] : '',
	'T_TR_COLOR2' => isset($mx_user->theme['tr_color2']) ? '#' . $mx_user->theme['tr_color2'] : '',
	'T_TR_COLOR3' => isset($mx_user->theme['tr_color3']) ? '#' . $mx_user->theme['tr_color3'] : '',
	'T_TR_CLASS1' => isset($mx_user->theme['tr_class1']) ? '#' . $mx_user->theme['tr_class1'] : '',
	'T_TR_CLASS2' => isset($mx_user->theme['tr_class2']) ? '#' . $mx_user->theme['tr_class2'] : '',
	'T_TR_CLASS3' => isset($mx_user->theme['tr_class3']) ? '#' . $mx_user->theme['tr_class3'] : '',
	'T_TH_COLOR1' => isset($mx_user->theme['th_color1']) ? '#' . $mx_user->theme['th_color1'] : '',
	'T_TH_COLOR2' => isset($mx_user->theme['th_color2']) ? '#' . $mx_user->theme['th_color2'] : '',
	'T_TH_COLOR3' => isset($mx_user->theme['th_color3']) ? '#' . $mx_user->theme['th_color3'] : '',
	'T_TH_CLASS1' => isset($mx_user->theme['th_class1']) ? '#' . $mx_user->theme['th_class1'] : '',
	'T_TH_CLASS2' => isset($mx_user->theme['th_class2']) ? '#' . $mx_user->theme['th_class2'] : '',
	'T_TH_CLASS3' => isset($mx_user->theme['th_class3']) ? '#' . $mx_user->theme['th_class3'] : '',
	'T_TD_COLOR1' => isset($mx_user->theme['td_color1']) ? '#' . $mx_user->theme['td_color1'] : '',
	'T_TD_COLOR2' => isset($mx_user->theme['td_color2']) ? '#' . $mx_user->theme['td_color2'] : '',
	'T_TD_COLOR3' => isset($mx_user->theme['td_color3']) ? '#' . $mx_user->theme['td_color3'] : '',
	'T_TD_CLASS1' => isset($mx_user->theme['td_class1']) ? '#' . $mx_user->theme['td_class1'] : '',
	'T_TD_CLASS2' => isset($mx_user->theme['td_class2']) ? '#' . $mx_user->theme['td_class2'] : '',
	'T_TD_CLASS3' => isset($mx_user->theme['td_class3']) ? '#' . $mx_user->theme['td_class3'] : '',
	'T_FONTFACE1' => isset($mx_user->theme['fontface1']) ? '#' . $mx_user->theme['fontface1'] : '',
	'T_FONTFACE2' => isset($mx_user->theme['fontface2']) ? '#' . $mx_user->theme['fontface2'] : '',
	'T_FONTFACE3' => isset($mx_user->theme['fontface3']) ? '#' . $mx_user->theme['fontface3'] : '',
	'T_FONTSIZE1' => isset($mx_user->theme['fontsize1']) ? '#' . $mx_user->theme['fontsize1'] : '',
	'T_FONTSIZE2' => isset($mx_user->theme['fontsize2']) ? '#' . $mx_user->theme['fontsize2'] : '',
	'T_FONTSIZE3' => isset($mx_user->theme['fontsize3']) ? '#' . $mx_user->theme['fontsize3'] : '',
	'T_FONTCOLOR1' => isset($mx_user->theme['fontcolor1']) ? '#' . $mx_user->theme['fontcolor1'] : '',
	'T_FONTCOLOR2' => isset($mx_user->theme['fontcolor2']) ? '#' . $mx_user->theme['fontcolor2'] : '',
	'T_FONTCOLOR3' => isset($mx_user->theme['fontcolor3']) ? '#' . $mx_user->theme['fontcolor3'] : '',
	'T_SPAN_CLASS1' => isset($mx_user->theme['span_class1']) ? '#' . $mx_user->theme['span_class1'] : '',
	'T_SPAN_CLASS2' => isset($mx_user->theme['span_class2']) ? '#' . $mx_user->theme['span_class2'] : '',
	'T_SPAN_CLASS3' => isset($mx_user->theme['span_class3']) ? '#' . $mx_user->theme['span_class3'] : '',

	'L_HOME' => $lang['MX_home'],
	//'L_HOME' => $lang['Home Page'],
	//'L_FORUM' => $lang['Forum'],
	'L_FORUM' => $lang['MX_forum'],

	'U_INDEX_FORUM' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=2'),
	'U_INDEX' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx),
	'U_SEARCH_SITE' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=' . $search_page_id_site . '&mode=results&search_terms=all'),
	
	'U_SEARCH_KB' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=' . $search_page_id_kb . '&mode=search&search_terms=all'),
	'U_SEARCH_PAFILEDB' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=' . $search_page_id_pafiledb . '&action=search&search_terms=all'),

	'PAGE_ICON' => $page_icon_img,
	'L_SEARCH_SITE' => $option_search_site,
	'L_SEARCH_FORUM' => $option_search_forum,
	'L_SEARCH_KB' => $option_search_kb,
	'L_SEARCH_PAFILEDB' => $option_search_pafiledb,
	'L_SEARCH_GOOGLE' => $option_search_google,

	'T_PHPBB_STYLESHEET' => (isset($mx_user->theme['head_stylesheet']) ? $mx_user->theme['head_stylesheet'] : $mx_user->template_name . ".css"),
	'T_STYLESHEET_LINK'	=> (!file_exists($mx_root_path . "templates/" . $mx_user->template_name . "/theme/stylesheet.css") ? "{$web_path}templates/" . $mx_user->template_name . '/'.$mx_user->template_name.'.css' : "{$web_path}templates/" . $mx_user->template_name . '/theme/stylesheet.css'), //: "{$phpbb_root_path}style.$phpEx?sid=$mx_user->session_id&amp;id=" . $mx_user->theme['style_id'] . '&amp;lang=' . $mx_user->encode_lang($board_config['default_lang']),
	'T_MXBB_STYLESHEET' => isset($mx_user->theme['head_stylesheet']) ? (strpos($mx_user->theme['head_stylesheet'], '.') ? $mx_user->theme['head_stylesheet'] : $mx_user->theme['head_stylesheet'].'.css') : $mx_user->template_name.'.css',
	'T_GECKO_STYLESHEET' => 'gecko.css',
	
	//+ MX-Publisher	
	'MX_ADDITIONAL_CSS_FILES' => $mx_addional_css_files,
	'MX_ADDITIONAL_JS_FILES' => $mx_addional_js_files,
	'MX_ADDITIONAL_HEADER_TEXT' => $mx_addional_header_text,
	'MX_ICON_CSS' => isset($images['mx_graphics']['icon_style']) ? $images['mx_graphics']['icon_style'] : '',
	//- MX-Publisher
	
	'U_MX_SHARED_FILES_PATH' => "{$web_path}modules/mx_shared/",
	
	'T_STYLESWITCHER_JS' => (!file_exists($mx_root_path . "modules/mx_shared/phpbb/styleswitcher.js") ? "{$web_path}templates/" . $mx_user->template_name . '/styleswitcher.js' : "{$web_path}modules/mx_shared/phpbb/styleswitcher.js"),
	'T_FORUM_FN_JS'	=> (!file_exists($mx_root_path . "modules/mx_shared/phpbb/forum_fn.js") ? "{$web_path}templates/" . $mx_user->template_name . '/forum_fn.js' : "{$web_path}modules/mx_shared/phpbb/forum_fn.js"), 
	'T_EDITOR_JS' => (!file_exists($mx_root_path . "modules/mx_shared/phpbb/editor.js") ? "{$web_path}templates/" . $mx_user->template_name . '/editor.js' : "{$web_path}modules/mx_shared/phpbb/editor.js"), 
	'T_AJAX_JS'	=> (!file_exists($mx_root_path . "modules/mx_shared/phpbb/ajax.js") ? "{$web_path}templates/" . $mx_user->template_name . '/ajax.js' : "{$web_path}modules/mx_shared/phpbb/ajax.js"),
	'T_TIMEZONE_JS'	=> (!file_exists($mx_root_path . "modules/mx_shared/phpbb/timezone.js") ? "{$web_path}templates/" . $mx_user->template_name . '/timezone.js' : "{$web_path}modules/mx_shared/phpbb/timezone.js"), 	
		
	'NAV_LINKS' => $nav_links_html,

	// swithes for logged in users?
	'USERNAME'			=> ($admin) ? $mx_user->data['username'] : '',
	'USER_LOGGED_IN' 	=> $mx_user->data['session_logged_in'], //$mx_user->data['user_id'] != ANONYMOUS
	'USER_LOGGED_OUT' 	=> !$mx_user->data['session_logged_in'], //$mx_user->data['user_id'] == ANONYMOUS
	
	//This phpBB3 features are disbled for Admins in MXP3 for now and default vaues used
	//To make use of this features Admins can login direct in forums
	'USERNAME_CREDENTIAL'	=> 'username',
	'PASSWORD_CREDENTIAL'	=> 'password',	

	// Do NOT set basedir when in EDIT mode
	'SET_BASE' => !$mx_request_vars->is_request('portalpage'),

	//Enable CSS Files to be loaded direct from phpBB?
	'PHPBB' => !(PORTAL_BACKEND === 'internal'),

	// Additional css for gecko browsers
	'GECKO' => strstr($useragent, 'Gecko'),
	
	'S_ENABLE_FEEDS'									=> false,
	'S_ENABLE_FEFILES_OVERALL'			=> false,
	'S_ENABLE_FEFILES_FORUMS'			=> false,
	'S_ENABLE_FEFILES_TOPICS'				=> false,
	'S_ENABLE_FEFILES_TOPICS_ACTIVE'	=> false,
	'S_ENABLE_FEFILES_NEWS'				=> false,
			
	'L_ACP' => $lang['Admin_panel'],
	'U_ACP' => ($mx_user->data['user_level'] == ADMIN) ? "{$mx_root_path}admin/index.$phpEx?sid=" . $mx_user->session_id : $admin_link

));

// Definitions of main navigation links
$mx_backend->page_header('generate_nav_links');

//
// Navigation Menu in overall_header
//
if ($mx_page->auth_view || $mx_page->auth_mod)
{
	if (!is_object($mx_block))
	{
		$mx_block = new mx_block();
	}

	$block_id = $mx_page->page_navigation_block;

	if(!empty($block_id) )
	{
		define('MX_OVERALL_NAVIGATION', true);

		$mx_block->init($block_id);

		//
		// Define $module_root_path, to be used within blocks
		$mx_module_path = $module_root_path;
		$module_root_path = $mx_root_path . $mx_block->module_root_path;

		$template = new mx_Template($mx_root_path . 'templates/'. $theme['template_name']);

		//
		// Include block file and cache output
		//
		ob_start();
		@include_once($module_root_path . $mx_block->block_file);
		$overall_navigation_menu = ob_get_contents();
		ob_end_clean();

		//
		// Output Block contents
		//
		$layouttemplate->assign_vars(array(
			'OVERALL_NAVIGATION' => $overall_navigation_menu)
		);
		
		if ((($mx_block->auth_view && $mx_block->auth_edit && $mx_block->show_block) || $mx_block->auth_mod))
		{
			$mx_block->output_cp_button(true);
		}
		$module_root_path = $mx_module_path;
	}
}

// Add no-cache control for cookies if they are set
//$c_no_cache = (isset($_COOKIE[$board_config['cookie_name'] . '_sid']) || isset($_COOKIE[$board_config['cookie_name'] . '_data'])) ? 'no-cache="set-cookie", ' : '';

// Work around for "current" Apache 2 + PHP module which seems to not
// cope with private cache control setting
if (!empty($_SERVER['SERVER_SOFTWARE']) && strstr($_SERVER['SERVER_SOFTWARE'], 'Apache/2'))
{
	header ('Cache-Control: no-cache, pre-check=0, post-check=0');
}
else
{
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
header ('Expires: 0');
header ('Pragma: no-cache');

$icongif = 'favicon.gif';

include_once($mx_root_path . 'mx_meta.inc');
$meta_str  = '<meta name="title"       content="' . $title     .'" />' . "\n";
$meta_str .= '<meta name="author"      content="' . $author    .'" />' . "\n";
$meta_str .= '<meta name="copyright"   content="' . $copyright .'" />' . "\n";
$meta_str .= '<meta name="keywords"    content="' . $keywords  .'" />' . "\n";
$meta_str .= '<meta name="description" lang="' . $langcode .'" content="'. $description .'" />' . "\n";
$meta_str .= '<link rel="shortcut icon" href="' . $icon .'" />' . "\n";

if (file_exists($mx_root_path . $icongif))
{
	$meta_str .= '<link rel="icon" href="' . $icongif .'" type="image/gif" />' . "\n";
}

$meta_str .= '<meta name="category"    content="' . $rating .'" />' . "\n";
$meta_str .= '<meta name="robots"      content="' . $index  . ',' . $follow .'" />' . "\n";
$meta_str .= $header . "\n";

$layouttemplate->assign_vars(array( 'META' => $meta_str) );
$layouttemplate->pparse('overall_header');
?>
