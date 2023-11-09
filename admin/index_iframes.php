<?php
/**
*
* @package MX-Publisher Core
* @version $Id: index_iframes.php, v 1.70 2023/11/09 21:58:36 orynider Exp $
* @copyright (c) 2002-2023 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

/**
 * MX-Publisher Notes:
 *    This file is borrowed from phpBB, with some modifications
 */

//
// Security and Page header
//
define('IN_PORTAL', 1);
define('ADMIN_START', true);
define('NEED_SID', true);

$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = TRUE;

require('./pagestart.' . $phpEx);

define( 'MAIN_CATEGORY', 'portal' );
define( 'MODULE_CATEGORY', 'modules' );
define( 'PHPBB2X_CATEGORY', 'phpbb2' );
define( 'OLYMPUS_CATEGORY', 'phpbb3' );

require('./page_header_admin.'.$phpEx);

// ------------------------------
// DEBUG ONLY ;-)
//
@error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL);
// ------------------------------

/**
 * Enter description here...
 *
 * @param unknown_type $needle
 * @param unknown_type $haystack
 * @return unknown
 */
function inarray($needle, $haystack)
{
	for( $i = 0; $i < sizeof($haystack); $i++ )
	{
		if( $haystack[$i] == $needle )
		{
			return true;
		}
	}
	return false;
}

/**
 * Enter description here...
 *
 * @param unknown_type $dir_module
 * @return unknown
 */
function read_admin($dir_module)
{
	global $phpEx, $template, $lang, $board_config, $phpbb_root_path, $mx_user;

	$module = array();
	if( $dir = @opendir($dir_module) )
	{
		$setmodules = 1;
		while( $file = @readdir($dir) )
		{
			if( preg_match("/^admin_.*?\." . $phpEx . "$/", $file) )
			{
				include($dir_module . '/' . $file);
			}
		}
		@closedir($dir);
		unset($setmodules);
	}
	return $module;
}
//
// End functions
// -------------

//
// Generate relevant output
//
if ($mx_request_vars->get('pane', MX_TYPE_NO_TAGS) == 'left')
{
	require($mx_root_path.'admin/page_header_admin.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'admin/index_navigate.'.$tplEx)
	);

	$admincp_nav_icon_url = PORTAL_URL . $images['mx_graphics']['admin_icons'];

	$template->assign_vars(array(
		'U_PHPBB_ROOT_PATH' => PHPBB_URL,
		'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,
		"U_PORTAL_INDEX" => mx_append_sid(PORTAL_URL . "index.$phpEx"),
		"L_PORTAL_INDEX" => $lang['Portal_index'],
		"L_PREVIEW_PORTAL" => $lang['Preview_portal'],

		"LOGO" => $images['mx_logo'],

		"U_FORUM_INDEX" => mx_append_sid(PHPBB_URL . "index.$phpEx"),
		"U_ADMIN_INDEX" => mx_append_sid("index.$phpEx?pane=right"),
		//+MOD: DHTML Menu for ACP
		'COOKIE_NAME'	=> $board_config['cookie_name'],
		'COOKIE_PATH'	=> $board_config['cookie_path'],
		'COOKIE_DOMAIN'	=> $board_config['cookie_domain'],
		'COOKIE_SECURE'	=> $board_config['cookie_secure'],
		'IMG_URL_CONTRACT' => $admincp_nav_icon_url . '/contract.gif',
		'IMG_URL_EXPAND' => $admincp_nav_icon_url . '/expand.gif',
		//-MOD: DHTML Menu for ACP
		"L_FORUM_INDEX" => $lang['Main_index'],
		"L_ADMIN_INDEX" => $lang['Admin_Index'],
	));

	//
	// Read Portal configuration
	//
	// MX Addon ------------------------------------
	$module_portal = read_admin('.');
	$template->assign_block_vars('module_portal', array(
		'L_MX_PORTAL' => $lang['MX_Portal']
	));
	// END ------------------------------------------

	ksort($module_portal);

	//+MOD: DHTML Menu for ACP
	$menu_cat_id = 0;
	//-MOD: DHTML Menu for ACP

	while( list($cat, $action_array) = each($module_portal) )
	{
		$cat = ( !empty($lang[$cat]) ) ? $lang[$cat] : preg_replace("/_/", " ", $cat);

		$template->assign_block_vars('module_portal.catrow', array(
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

			$template->assign_block_vars('module_portal.catrow.modulerow', array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,
				//+MOD: DHTML Menu for ACP
				'ROW_COUNT' => $row_count,
				//-MOD: DHTML Menu for ACP
				"ADMIN_MODULE" => $action,
				"U_ADMIN_MODULE" => mx_append_sid(PORTAL_URL . $file . ( ( strpos($file, '?') !== false ) ? '&sid=' : '?sid=' ) . $userdata['session_id'])
			));
			$row_count++;
		}
		//+MOD: DHTML Menu for ACP
		$menu_cat_id++;
		//-MOD: DHTML Menu for ACP
	}

	//
	// Include PHPBB Administration
	// -------------------------------------------------------------------------------
	$mx_backend->load_phpbb_acp_menu();

	//
	// Read Portal Module Configuration
	//
	$sql = "SELECT *
		FROM " . MODULE_TABLE . "
		WHERE module_include_admin = 1
		ORDER BY module_name";

	if( !($q_modules = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Could not query modules information", '', __LINE__, __FILE__, $sql);
	}

	if( $total_modules = $db->sql_numrows($q_modules) )
	{
		$module_rows = $db->sql_fetchrowset($q_modules);
	}
	$db->sql_freeresult($result);

	$module_mx = array();
	for( $module_cnt = 0; $module_cnt < $total_modules; $module_cnt++ )
	{
		$module_path_admin = $mx_root_path . $module_rows[$module_cnt]['module_path'] . "admin/";
		$module_path_root = $mx_root_path . $module_rows[$module_cnt]['module_path'];

		// **********************************************************************
		// Read language definition
		// **********************************************************************
		if ( file_exists( $module_path_root . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx ) )
		{
			include( $module_path_root . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx );
		}
		else if ( file_exists( $module_path_root . 'language/lang_english/lang_admin.' . $phpEx ) )
		{
			include( $module_path_root . 'language/lang_english/lang_admin.' . $phpEx );
		}

		$module_mx = array_merge_recursive($module_mx, read_admin($module_path_admin));
	}
	$template->assign_block_vars('module_mx', array(
		'L_MX_MODULES' => $lang['MX_Modules'])
	);

	ksort($module_mx);

	//+MOD: DHTML Menu for ACP
	$menu_cat_id = 0;
	//-MOD: DHTML Menu for ACP

	while( list($cat, $action_array) = each($module_mx) )
	{
		$cat = ( !empty($lang[$cat]) ) ? $lang[$cat] : preg_replace("/_/", " ", $cat);

		$template->assign_block_vars('module_mx.catrow', array(
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

			$template->assign_block_vars('module_mx.catrow.modulerow', array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,
				//+MOD: DHTML Menu for ACP
				'ROW_COUNT' => $row_count,
				//-MOD: DHTML Menu for ACP

				"ADMIN_MODULE" => $action,
				"U_ADMIN_MODULE" => mx_append_sid(PORTAL_URL . $file))
			);
			$row_count++;
		}
		//+MOD: DHTML Menu for ACP
		$menu_cat_id++;
		//-MOD: DHTML Menu for ACP
	}
	// -----------------------------------------------------------------------------------
	// END MX ADDON
	// -----------------------------------------------------------------------------------
	$template->pparse('body');

	include('./page_footer_admin.'.$phpEx);
}
elseif ($mx_request_vars->get('pane', MX_TYPE_NO_TAGS) == 'right')
{
	//require('./page_header_admin.'.$phpEx);

	$template->set_filenames(array(
		"body" => "admin/index_body.".$tplEx)
	);

	$template->assign_vars(array(
		// MX Addon
		'U_PHPBB_ROOT_PATH' => PHPBB_URL,
		'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,
		// END
		"L_WELCOME" => $lang['Welcome_mxBB'],
		"L_ADMIN_INTRO" => $lang['Admin_intro_mxBB'],
		"L_FORUM_STATS" => $lang['Forum_stats'],
		"L_WHO_IS_ONLINE" => $lang['Who_is_Online'],
		"L_USERNAME" => $lang['Username'],
		"L_LOCATION" => $lang['Location'],
		"L_LAST_UPDATE" => $lang['Last_updated'],
		"L_IP_ADDRESS" => $lang['IP_Address'],
		"L_STATISTIC" => $lang['Statistic'],
		"L_VALUE" => $lang['Value'],
		"L_NUMBER_POSTS" => $lang['Number_posts'],
		"L_POSTS_PER_DAY" => $lang['Posts_per_day'],
		"L_NUMBER_TOPICS" => $lang['Number_topics'],
		"L_TOPICS_PER_DAY" => $lang['Topics_per_day'],
		"L_NUMBER_USERS" => $lang['Number_users'],
		"L_USERS_PER_DAY" => $lang['Users_per_day'],
		"L_BOARD_STARTED" => $lang['Board_started'],
		"L_AVATAR_DIR_SIZE" => $lang['Avatar_dir_size'],
		"L_DB_SIZE" => $lang['Database_size'],
		"L_FORUM_LOCATION" => $lang['Forum_Location'],
		"L_STARTED" => $lang['Login'],
		"L_GZIP_COMPRESSION" => $lang['Gzip_compression'])
	);
	

	$whois_url_sufix = '/#_whois';
	$whois_url = "https://bgp.he.net/ip/";
	//$whois_url = "http://network-tools.com/default.asp?host=";
	//$whois_url = mx_append_sid(PHPBB_URL . "adm/index.php?i=users&icat=13&mode=overview&action=whois&user_ip=");

	$mx_backend->load_forum_stats();

	//
	// Get users online information.
	//
	$sql = $mx_backend->generate_session_online_sql();

	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain regd user/online information.", "", __LINE__, __FILE__, $sql);
	}

	$onlinerow_reg = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$sql = $mx_backend->generate_session_online_sql(true);

	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain guest user/online information.", "", __LINE__, __FILE__, $sql);
	}
	$onlinerow_guest = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$reg_userid_ary = array();

	if( count($onlinerow_reg) )
	{
		$registered_users = 0;

		for($i = 0; $i < count($onlinerow_reg); $i++)
		{
			if( !inarray($onlinerow_reg[$i]['user_id'], $reg_userid_ary) )
			{
				$reg_userid_ary[] = $onlinerow_reg[$i]['user_id'];

				$username = $onlinerow_reg[$i]['username'];

				if( $onlinerow_reg[$i]['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )
				{
					$registered_users++;
					$hidden = FALSE;
				}
				else
				{
					$hidden_users++;
					$hidden = TRUE;
				}

				if( $onlinerow_reg[$i]['user_session_page'] < 1 )
				{
					switch($onlinerow_reg[$i]['user_session_page'])
					{
						case PAGE_INDEX:
							$location = $lang['Forum_index'];
							$location_url = "index.$phpEx?pane=right";
							break;
						case PAGE_POSTING:
							$location = $lang['Posting_message'];
							$location_url = "index.$phpEx?pane=right";
							break;
						case PAGE_LOGIN:
							$location = $lang['Logging_on'];
							$location_url = "index.$phpEx?pane=right";
							break;
						case PAGE_SEARCH:
							$location = $lang['Searching_forums'];
							$location_url = "index.$phpEx?pane=right";
							break;
						default:
							$mx_viewonline_info = mx_get_viewonline_info($onlinerow_reg[$i]['user_session_page']);
							if( $mx_viewonline_info !== false )
							{
								list($location, $location_url) = $mx_viewonline_info;
								break;
							}
					}
				}
				else
				{
					$mx_viewonline_info = mx_get_viewonline_info($onlinerow_reg[$i]['user_session_page']);
					if( $mx_viewonline_info !== false )
					{
						list($location, $location_url) = $mx_viewonline_info;
						break;
					}
				}

				$row_color = ( $registered_users % 2 ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( $registered_users % 2 ) ? $theme['td_class1'] : $theme['td_class2'];

				$reg_ip = $mx_backend->decode_ip($onlinerow_reg[$i]['session_ip']);

				$template->assign_block_vars("reg_user_row", array(
					"ROW_COLOR" => "#" . $row_color,
					"ROW_CLASS" => $row_class,
					"USERNAME" => $username,
					"STARTED" => phpBB2::create_date($board_config['default_dateformat'], $onlinerow_reg[$i]['session_start'], $board_config['board_timezone']),
					"LASTUPDATE" => phpBB2::create_date($board_config['default_dateformat'], $onlinerow_reg[$i]['user_session_time'], $board_config['board_timezone']),
					"FORUM_LOCATION" => $location,
					"IP_ADDRESS" => $reg_ip,

					"U_WHOIS_IP" => $whois_url . $reg_ip . $whois_url_sufix,
					"U_USER_PROFILE" => mx_append_sid(PHPBB_URL . "admin_users.$phpEx?mode=edit&amp;" . POST_USERS_URL . "=" . $onlinerow_reg[$i]['user_id']),
					"U_FORUM_LOCATION" => mx_append_sid($location_url))
				);
			}
		}
	}
	else
	{
		$template->assign_vars(array(
			"L_NO_REGISTERED_USERS_BROWSING" => $lang['No_users_browsing'])
		);
	}

	//
	// Guest users
	//
	if( count($onlinerow_guest) )
	{
		$guest_users = 0;

		for($i = 0; $i < count($onlinerow_guest); $i++)
		{
			$guest_userip_ary[] = $onlinerow_guest[$i]['session_ip'];
			$guest_users++;

			if( $onlinerow_guest[$i]['session_page'] < 1 )
			{
				switch( $onlinerow_guest[$i]['session_page'] )
				{
					case PAGE_INDEX:
						$location = $lang['Forum_index'];
						$location_url = "index.$phpEx?pane=right";
						break;
					case PAGE_POSTING:
						$location = $lang['Posting_message'];
						$location_url = "index.$phpEx?pane=right";
						break;
					case PAGE_LOGIN:
						$location = $lang['Logging_on'];
						$location_url = "index.$phpEx?pane=right";
						break;
					case PAGE_SEARCH:
						$location = $lang['Searching_forums'];
						$location_url = "index.$phpEx?pane=right";
						break;
					default:
						$mx_viewonline_info = mx_get_viewonline_info($onlinerow_guest[$i]['session_page']);
						if( $mx_viewonline_info !== false )
						{
							list($location, $location_url) = $mx_viewonline_info;
							break;
						}
				}
			}
			

			$row_color = ( $guest_users % 2 ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( $guest_users % 2 ) ? $theme['td_class1'] : $theme['td_class2'];

			$guest_ip = $mx_backend->decode_ip($onlinerow_guest[$i]['session_ip']);

			$template->assign_block_vars("guest_user_row", array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,
				"USERNAME" => $lang['Guest'],
				"STARTED" => phpBB2::create_date($board_config['default_dateformat'], $onlinerow_guest[$i]['session_start'], $board_config['board_timezone']),
				"LASTUPDATE" => phpBB2::create_date($board_config['default_dateformat'], $onlinerow_guest[$i]['session_time'], $board_config['board_timezone']),
				"FORUM_LOCATION" => $location,
				"IP_ADDRESS" => $guest_ip,

				"U_WHOIS_IP" => $whois_url . $guest_ip . $whois_url_sufix,
				"U_FORUM_LOCATION" => mx_append_sid($location_url))
			);
		}
	}
	else
	{
		$template->assign_vars(array(
			"L_NO_GUESTS_BROWSING" => $lang['No_users_browsing'])
		);
	}

	/* Begin phpBB version check code block */
	$phpbb_version_info = $mx_backend->phpbb_version_check();

	/* Begin MX-Publisher version check code block */
	$current_mxbb_version = explode('.', $portal_config['portal_version']);
	$minor_mxbb_revision = (int) $current_mxbb_version[2];

	$errno = 0;
	$errstr = $mxbb_version_info = '';

	if ($fsock = @fsockopen('www.mx-publisher.com', 80, $errno, $errstr))
	{
		@fputs($fsock, "GET /updatecheck/30x.txt HTTP/1.1\r\n");
		@fputs($fsock, "HOST: www.mx-publisher.com\r\n");
		@fputs($fsock, "Connection: close\r\n\r\n");

		$get_info = false;
		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$mxbb_version_info .= @fread($fsock, 1024);
			}
			else
			{
				if (@fgets($fsock, 1024) == "\r\n")
				{
					$get_info = true;
				}
			}
		}
		@fclose($fsock);

		$mxbb_version_info = explode("\n", $mxbb_version_info);
		$latest_mxbb_head_revision = (int) $mxbb_version_info[0];
		$latest_mxbb_minor_revision = (int) $mxbb_version_info[2];
		$latest_mxbb_patch_revision = (int) $mxbb_version_info[3]; // For betas/RC

		$latest_mxbb_version = (int) $mxbb_version_info[0] . '.' . (int) $mxbb_version_info[1] . '.' . (int) $mxbb_version_info[2];

		if ($latest_mxbb_head_revision == 3 && $minor_mxbb_revision == $latest_mxbb_minor_revision)
		{
			$mxbb_version_info = '<p style="color:green">' . $lang['mxBB_Version_up_to_date'] . '</p>';
		}
		else
		{
			$mxbb_version_info = '<p style="color:red">' . $lang['mxBB_Version_outdated'];
			$mxbb_version_info .= '<br />' . sprintf($lang['mxBB_Latest_version_info'], $latest_mxbb_version) . sprintf($lang['mxBB_Current_version_info'], $portal_config['portal_version']) . '</p>';
		}
	}
	else
	{
		if ($errstr)
		{
			$mxbb_version_info = '<p style="color:red">' . sprintf($lang['Connect_socket_error'], $errstr) . '</p>';
		}
		else
		{
			$mxbb_version_info = '<p>' . $lang['Socket_functions_disabled'] . '</p>';
		}
	}

	$mxbb_version_info .= '<p>' . $lang['mxBB_Mailing_list_subscribe_reminder'] . '</p>';

	$template->assign_vars(array(
		'MXBB_VERSION_INFO'		=> $mxbb_version_info,
		'PHPBB_VERSION_INFO'	=> $phpbb_version_info,
		'L_VERSION_INFORMATION'	=> $lang['Version_information'])
	);

	$template->pparse("body");

	include('./page_footer_admin.'.$phpEx);
}
else
{
	//
	// Generate frameset
	//
	$template->set_filenames(array(
		"body" => "admin/index_iframes.".$tplEx)
	);
	$template->assign_vars(array(
		"SITENAME"			=> $board_config['sitename'],
		"SITE_DESCRIPTION"	=> $board_config['site_desc'],	
		"ADMIN_TITLE" => $lang['mxBB_adminCP'],
		"U_PHPBB_ROOT_PATH" => PHPBB_URL,
		"TEMPLATE_ROOT_PATH" => TEMPLATE_ROOT_PATH,	
		"S_FRAME_NAV" => mx_append_sid("index.$phpEx?pane=left"),
		"S_FRAME_MAIN" => mx_append_sid("index.$phpEx?pane=right"))
	);
	@header ("Expires: " . gmdate("D, d M Y H:i:s", time()) . " GMT");
	@header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

	$template->pparse("body");

	$db->sql_close();
	exit;
}
?>
