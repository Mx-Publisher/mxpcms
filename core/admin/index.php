<?php
/**
*
* @package mxBB Portal Core
* @version $Id: index.php,v 1.2 2009/01/24 16:45:47 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

/**
 * mxBB Notes:
 *    This file is borrowed from phpBB, with some modifications
 */

//
// Security and Page header
//
@define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = TRUE;
require('./pagestart.' . $phpEx);

// ------------------------------
// DEBUG ONLY ;-)
//
//error_reporting(E_ALL);
// ------------------------------

// ---------------
// Begin functions
//

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
if( isset($HTTP_GET_VARS['pane']) && $HTTP_GET_VARS['pane'] == 'left' )
{
	include('./page_header_admin.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'admin/index_navigate.tpl')
	);

	$admincp_nav_icon_url = PORTAL_URL . $images['mx_graphics']['admin_icons'];

	$template->assign_vars(array(
		'U_PHPBB_ROOT_PATH' => PHPBB_URL,
		'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,
		"U_PORTAL_INDEX" => mx_append_sid(PORTAL_URL . "index.$phpEx"),
		"L_PORTAL_INDEX" => $lang['Portal_index'],
		"L_PREVIEW_PORTAL" => $lang['Preview_portal'],

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
		"L_PREVIEW_FORUM" => $lang['Preview_forum'])
	);

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

	// MX ADDON
	// Include PHPBB Administration
	// -------------------------------------------------------------------------------
	$module_phpbb = read_admin($phpbb_root_path . 'admin/');
	$template->assign_block_vars('module_phpbb', array(
		'L_PHPBB' => $lang['Phpbb']
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
	$db->sql_freeresult($q_modules);

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
elseif( isset($HTTP_GET_VARS['pane']) && $HTTP_GET_VARS['pane'] == 'right' )
{

	include('./page_header_admin.'.$phpEx);

	$template->set_filenames(array(
		"body" => "admin/index_body.tpl")
	);

	$template->assign_vars(array(
		// MX Addon
		'U_PHPBB_ROOT_PATH' => PHPBB_URL,
		'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,
		// END
				
		'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
		'S_CONTENT_ENCODING' => $lang['ENCODING'],
		'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
		'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],		
		'S_USER_LANG' => $board_config['default_lang'],
		
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
						if( $tabledata_ary[$i]['Engine'] != "MRG_MyISAM" )
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
	//
	// End forum statistics
	//

	//
	// Get users online information.
	//
	$sql = "SELECT u.user_id, u.user_active, u.username, u.user_lastvisit, u.user_regdate, u.user_level, u.user_posts, u.user_timezone, u.user_session_time, u.user_session_page, u.user_style, u.user_lang, u.user_dateformat, u.user_allow_viewonline, u.user_notify, u.user_notify_pm, u.user_popup_pm, u.user_rank, u.user_avatar, u.user_avatar_type, u.user_email, u.user_icq, u.user_website, u.user_from, u.user_sig, u.user_sig_bbcode_uid, u.user_interests, u.user_actkey, u.user_permissions, u.user_level as user_type, s.session_logged_in, s.session_ip, s.session_start 
		FROM " . USERS_TABLE . " u, " . SESSIONS_TABLE . " s
		WHERE s.session_logged_in = " . true . " 
			AND u.user_id = s.session_user_id 
			AND u.user_id <> " . ANONYMOUS . " 
			AND s.session_time >= " . ( time() - 300 ) . " 
		ORDER BY u.user_session_time DESC";
	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain regd user/online information.", "", __LINE__, __FILE__, $sql);
	}
	$onlinerow_reg = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$sql = "SELECT session_page, session_logged_in, session_time, session_ip, session_start
		FROM " . SESSIONS_TABLE . "
		WHERE session_logged_in = 0
			AND session_time >= " . ( time() - 300 ) . "
		ORDER BY session_time DESC";
	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain guest user/online information.", "", __LINE__, __FILE__, $sql);
	}
	$onlinerow_guest = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$sql = "SELECT forum_name, forum_id
		FROM " . FORUMS_TABLE;

	if($forums_result = $db->sql_query($sql))
	{
		while($forumsrow = $db->sql_fetchrow($forums_result))
		{
			$forum_data[$forumsrow['forum_id']] = $forumsrow['forum_name'];
		}
	}
	else
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain user/online forums information.", "", __LINE__, __FILE__, $sql);
	}

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
						case PAGE_PROFILE:
							$location = $lang['Viewing_profile'];
							$location_url = "index.$phpEx?pane=right";
						break;
						case PAGE_VIEWONLINE:
							$location = $lang['Viewing_online'];
							$location_url = "index.$phpEx?pane=right";
						break;
						case PAGE_VIEWMEMBERS:
							$location = $lang['Viewing_member_list'];
							$location_url = "index.$phpEx?pane=right";
						break;
						case PAGE_PRIVMSGS:
							$location = $lang['Viewing_priv_msgs'];
							$location_url = "index.$phpEx?pane=right";
						break;
						case PAGE_FAQ:
							$location = $lang['Viewing_FAQ'];
							$location_url = "index.$phpEx?pane=right";
						break;
						default:
							//+MOD: ViewOnline extension for mxBB Portal Pages
							$mx_viewonline_info = mx_get_viewonline_info($onlinerow_reg[$i]['user_session_page']);
							if( $mx_viewonline_info !== false )
							{
								list($location, $location_url) = $mx_viewonline_info;
						break;
							}
							//-MOD: ViewOnline extension for mxBB Portal Pages
							$location = $lang['Forum_index'];
							$location_url = "index.$phpEx?pane=right";
					}
				}
				else
				{
					//+MOD: ViewOnline extension for mxBB Portal Pages
					$mx_viewonline_info = mx_get_viewonline_info($onlinerow_reg[$i]['user_session_page']);
					if( $mx_viewonline_info !== false )
					{
						list($location, $location_url) = $mx_viewonline_info;
						break;
					}
					//-MOD: ViewOnline extension for mxBB Portal Pages
					$location_url = mx_append_sid(PHPBB_URL . "admin_forums.$phpEx?mode=editforum&amp;" . POST_FORUM_URL . "=" . $onlinerow_reg[$i]['user_session_page']);
					$location = $forum_data[$onlinerow_reg[$i]['user_session_page']];
				}

				$row_color = ( $registered_users % 2 ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( $registered_users % 2 ) ? $theme['td_class1'] : $theme['td_class2'];

				$reg_ip = decode_ip($onlinerow_reg[$i]['session_ip']);

				$template->assign_block_vars("reg_user_row", array(
					"ROW_COLOR" => "#" . $row_color,
					"ROW_CLASS" => $row_class,
									
					"USERNAME" => $username,
					"STARTED" => create_date($board_config['default_dateformat'], $onlinerow_reg[$i]['session_start'], $board_config['board_timezone']),
					"LASTUPDATE" => create_date($board_config['default_dateformat'], $onlinerow_reg[$i]['user_session_time'], $board_config['board_timezone']),
					"FORUM_LOCATION" => $location,
					"IP_ADDRESS" => $reg_ip,

					"U_WHOIS_IP" => "http://network-tools.com/default.asp?host=$reg_ip",
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
					case PAGE_PROFILE:
						$location = $lang['Viewing_profile'];
						$location_url = "index.$phpEx?pane=right";
					break;
					case PAGE_VIEWONLINE:
						$location = $lang['Viewing_online'];
						$location_url = "index.$phpEx?pane=right";
					break;
					case PAGE_VIEWMEMBERS:
						$location = $lang['Viewing_member_list'];
						$location_url = "index.$phpEx?pane=right";
					break;
					case PAGE_PRIVMSGS:
						$location = $lang['Viewing_priv_msgs'];
						$location_url = "index.$phpEx?pane=right";
					break;
					case PAGE_FAQ:
						$location = $lang['Viewing_FAQ'];
						$location_url = "index.$phpEx?pane=right";
					break;
					default:
						//+MOD: ViewOnline extension for mxBB Portal Pages
						$mx_viewonline_info = mx_get_viewonline_info($onlinerow_guest[$i]['session_page']);
						if( $mx_viewonline_info !== false )
						{
							list($location, $location_url) = $mx_viewonline_info;
					break;
						}
						//-MOD: ViewOnline extension for mxBB Portal Pages
						$location = $lang['Forum_index'];
						$location_url = "index.$phpEx?pane=right";
				}
			}
			else
			{
				$location_url = mx_append_sid(PHPBB_URL . "admin_forums.$phpEx?mode=editforum&amp;" . POST_FORUM_URL . "=" . $onlinerow_guest[$i]['session_page']);
				$location = $forum_data[$onlinerow_guest[$i]['session_page']];
			}

			$row_color = ( $guest_users % 2 ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( $guest_users % 2 ) ? $theme['td_class1'] : $theme['td_class2'];

			$guest_ip = decode_ip($onlinerow_guest[$i]['session_ip']);

			$template->assign_block_vars("guest_user_row", array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,
				"USERNAME" => $lang['Guest'],
				"STARTED" => create_date($board_config['default_dateformat'], $onlinerow_guest[$i]['session_start'], $board_config['board_timezone']),
				"LASTUPDATE" => create_date($board_config['default_dateformat'], $onlinerow_guest[$i]['session_time'], $board_config['board_timezone']),
				"FORUM_LOCATION" => $location,
				"IP_ADDRESS" => $guest_ip,

				"U_WHOIS_IP" => "http://network-tools.com/default.asp?host=$guest_ip",
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
	$current_phpbb_version = explode('.', '2' . $board_config['version']);
	$minor_phpbb_revision = (int) $current_phpbb_version[2];

	$errno = 0;
	$errstr = $phpbb_version_info = '';
	
	/* Begin phpBB version check code block */
	$phpbb_version_info = $mx_backend->phpbb_version_check();	
	/* End phpBB version check code block */

	/* Begin mxBB version check code block */
	$current_mxbb_version = explode('.', $portal_config['portal_version']);
	$minor_mx_revision = (int) $current_mxbb_version[2];

	$errno = 0;
	$errstr = $mx_version_info = '';
	
	$mx_version_check = false;
	
	if ($fsock = @fsockopen('mxpcms.sourceforge.net', 80, $errno, $errstr))	
	{
		$mx_version_check = true;	
	}
	$mxbb_version_info = $mx_cache->get('versioncheck');	
	if ($mx_version_check == true)
	{
		@fputs($fsock, "GET /updatecheck/28x.txt HTTP/1.1\r\n");
		@fputs($fsock, "HOST: mxpcms.sourceforge.net\r\n");
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
		$latest_mx_head_revision = (int) $mxbb_version_info[0];
		$latest_mx_minor_revision = (int) $mxbb_version_info[2];
		$latest_mx_version = (int) $mxbb_version_info[0] . '.' . (int) $mxbb_version_info[1] . '.' . (int) $mxbb_version_info[2];

		if ($latest_mx_head_revision == 3)
		{
			$mxbb_version_info = '<p style="color:green"> Your database is version 3 but the files are version 2. Upgrade the files! ' . $lang['mxBB_Version_up_to_date'] . '</p>';
		}
		elseif ($latest_mx_head_revision == 2 && $minor_mx_revision > $latest_mx_minor_revision)
		{
			$mxbb_version_info = '<p style="color:green"> Your have a development revision. ' . $lang['mxBB_Version_up_to_date'] . '</p>';
		}
		elseif ($latest_mx_head_revision == 2 && $minor_mx_revision == $latest_mx_minor_revision)
		{
			$mxbb_version_info = '<p style="color:green">' . $lang['mxBB_Version_up_to_date'] . '</p>';
		}		
		else
		{
			$mxbb_version_info = '<p style="color:red">' . $lang['mxBB_Version_outdated'] . ' minor revision: ' . $minor_mx_revision . 'latest minor revision: ' . $latest_mx_minor_revision;
			$mxbb_version_info .= '<br />' . sprintf($lang['mxBB_Latest_version_info'], $latest_mx_version) . sprintf($lang['mxBB_Current_version_info'], $portal_config['portal_version']) . '</p>';
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

/* End mxBB version check code block */

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
		"body" => "admin/index_frameset.tpl")
	);

	$template->assign_vars(array(
		'L_ADMIN_TITLE' => isset($lang['mxBB_adminCP']) ? $lang['mxBB_adminCP'] : $lang['Mx-Publisher_adminCP'],
		"S_FRAME_NAV" => mx_append_sid("index.$phpEx?pane=left"),
		"S_FRAME_MAIN" => mx_append_sid("index.$phpEx?pane=right"))
	);

	header ("Expires: " . gmdate("D, d M Y H:i:s", time()) . " GMT");
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

	$template->pparse("body");

	$db->sql_close();
	exit;
}
?>