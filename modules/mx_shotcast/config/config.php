<?php
/**
*
* @package Mx-Publisher Module - mx_shotcast
* @version $Id: config.php,v 1.4 2013/07/02 23:12:38 orynider Exp $
* @copyright (c) 2002-2006 [OryNider] MXP-CMS Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/
/*
/* MX-CMS Code Starts
/* Security check
*/
if((!defined('IN_SHOTCAST') && !defined('IN_PORTAL')))
{
	die("Hacking attempt");
}
// History:
// Little Frog (v 1.x - 2.x)
// OryNider (v 1.x - 3.x)
// DrKnas (v 4.0 - 4.2.x)
// OryNider (Current maintainer: 3.5.x & 4.9.x & mxpcms versions)
/*
/* MX-CMS Code Starts
*/
if(!is_object($mx_block) && !defined('IN_ADMIN'))
{
	define('IN_PORTAL', true);
	$mx_root_path = $module_root_path . "../../";
	include_once($mx_root_path . 'common.'.$phpEx);
	// Start session management
	$mx_user->init($user_ip, PAGE_INDEX);
	// End session management
	$title = 'Radio Player';
	$is_block = FALSE;
}
if(defined('IN_PORTAL') || is_object($mx_block))
{
	// Read block Configuration
	$block_info = mx_get_info(BLOCK_TABLE, 'block_title', 'Radio Player');		
	$block_id = ((isset($block_id) && !empty($block_id)) ? $block_id : $block_info['block_id']);
	$title = $block_info['block_title'];
	$block_size = ((isset($block_size) && !empty($block_size)) ? $block_size : '100%');
	$description = $block_info['block_desc'];
	$show_block = $block_info['show_block'];
	$show_title = ($userdata['user_level'] == ADMIN) ? true : $block_info['show_title'];
	$show_stats = $block_info['show_stats'];	
	// Init the User BlockCP
	if (is_numeric($block_id))
	{
		$mx_block->init($block_id, true);
	}
	$title = $mx_block->block_info['block_title'];
	//$b_description = $mx_block->block_info['block_desc'];
	$is_block = TRUE;
}
//
// Define table names.
//
@define('SHOTCAST_CONFIG_TABLE', $mx_table_prefix.'shotcast_config');
@define('SHOTCAST_SESSION_TABLE', $mx_table_prefix.'shotcast_session');
//Check for shotcast version
if(file_exists($mx_root_path . "modules/mx_radio/includes/common.$phpEx"))
{
	!defined('SHOTCAST_SESSION_TABLE') ? define('SHOTCAST_SESSION_TABLE', $mx_table_prefix.'radio_session') : false;
}
//$mx_user->set_module_default_style('_core'); // For compatibility with core 2.8.x
// Cache settings
$use_cache = 1;
//
// mx_shotcast version...
//
$module_name = 'SteamCaster';
if (($mx_cache->get('shotcast_module')) && ($use_cache))
{
	$module = $mx_cache->get('shotcast_module');
	
	$music_module_copy = $module['module_copy'];
	$music_module_name = $module['module_name'];
	$music_module_version = $module['module_version'];
	
}
else
{
	$module = array();

	$sql = "SELECT * FROM " . MODULE_TABLE . " WHERE module_name = '$module_name'";

	if(!($result = $db->sql_query($sql)))
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain shotcast module informations from database", '', __LINE__, __FILE__, $sql);
	}

	while($module = $db->sql_fetchrow($result))
	{
		$music_module_copy = $module['module_copy'];
		$music_module_name = $module['module_name'];
		$music_module_version = $module['module_version']; 
	}

	if ($use_cache)
	{
		$mx_cache->put('shotcast_module', $module);
	}
}

if( !empty($music_module_copy) )
{
	define('_SHOTCAST_VERSION', 'mxBB <i> - ' . $music_module_name . '</i> ' . $music_module_version . '&nbsp;&copy;&nbsp;2007-2008 by OryNider');
}
else
{
	define('_SHOTCAST_VERSION', 'mxBB <i> - ShotCast Module ver. 3.x</i> &nbsp;&copy;&nbsp;2007-2008 by OryNider');
}
//
// Load language files.
//
$default_lang = ($mx_user->lang['default_lang']) ? $mx_user->encode_lang($mx_user->lang['default_lang']) : (($board_config['default_lang']) ? $board_config['default_lang'] : 'english');

if (empty($default_lang))
{
	// - populate $default_lang
	$default_lang = 'english';
}
//Main module lang
if ((@include_once $module_root_path . "language/lang_" . $default_lang . "/lang_main.$phpEx") === false)
{
	if ((@include_once $module_root_path . "language/lang_english/lang_main.$phpEx") === false)
	{
		mx_message_die(CRITICAL_ERROR, 'Language file ' . $module_root_path . "language/lang_" . $default_lang . "/lang_main.$phpEx" . ' couldn\'t be opened.');
	}
	$default_lang = 'english'; 
}
//Admin Module Lang
if(@file_exists($module_root_path . "language/lang_" . $default_lang . "/lang_admin.$phpEx") )
{
	include($module_root_path . "language/lang_" . $default_lang . "/lang_admin.$phpEx");
}
else
{
	include($module_root_path . "language/lang_english/lang_admin.$phpEx");
}
//
// Common definitions...
//
$time = date("U");
$cfg_shotcastname = $board_config['sitename'] . ' -&gt; ' . 'shotcast';
if(empty($user_ip))
{
	$client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : getenv('REMOTE_ADDR') );
	$user_ip = phpBB2::encode_ip($client_ip);
}
$user_id = $userdata['user_id'];
$nick = str_replace(" ", "_", $userdata['username']);
$radio_bot_id = ANONYMOUS;
// ================================================================================
//			[ SHOTCAST CONFIG ]
// ================================================================================
$shotcast_config = array();
// Get radio Settings from config table
if (($mx_cache->get('shotcast_config')) && ($use_cache))
{
	$shotcast_config = $mx_cache->get('shotcast_config');
}
else
{
	$sql = "SELECT * FROM " . SHOTCAST_CONFIG_TABLE;

	if (!($result = $db->sql_query($sql)))
	{
		if (!function_exists('mx_message_die'))
		{
			die("Couldnt query shotcast_config information, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
		}
		else
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt query shotcast_config information', '', __LINE__, __FILE__, $sql );
		}
	}

	while ($row = $db->sql_fetchrow($result))
	{
		$shotcast_config[$row['config_name']] = $row['config_value'];
	}
	$db->sql_freeresult($result);

	if ($use_cache)
	{
		$mx_cache->put('shotcast_config', $shotcast_config);
	}
}
//read check period
$period = $shotcast_config['check_period'] * 1000;

if ($userdata['user_id'] == ANONYMOUS)
{
	if($this_agent)
	{
		$nick = $this_agent;
	}
	else
	{
		$nick = $shotcast_config['guestname'];
	}

	if ($this_bot_id)
	{
		$radio_bot_id = $this_bot_id;
	}	
}
// ================================================================================
//			[ COMMON FUNCTIONS ]
// ================================================================================
function user_listensc($nick)
{
	global $userdata, $shotcast_config, $db, $user_ip, $radio_bot_id;

	$current_time = date("U");
	$user_id = $userdata['user_id'];

	$sql = "DELETE FROM " . SHOTCAST_SESSION_TABLE . " 
		WHERE session_ip = '" . $user_ip . "'";
	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(CRITICAL_ERROR, 'SQL Error in function user_listensc(): DELETE<br />', '', __LINE__, __FILE__, $sql);
	}
	
	$sql = "INSERT INTO " . SHOTCAST_SESSION_TABLE . "
		(user_id, username, time, session_ip, bot_id)
		VALUES ('$user_id', '" . addslashes($nick) . "', '$current_time', '$user_ip', '$radio_bot_id')";
	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(CRITICAL_ERROR, 'SQL Error in function user_listensc(): INSERT INTO<br />', '', __LINE__, __FILE__, $sql);
	}
}
//Update user statue "listening/not listening" 
//Since this is loaded in a iframe it's not need for debuging code
function update_shotcast_users($nick)
{
	global $shotcast_config, $db, $lang, $user_ip;	
	$time = date("U");
	$sql = "UPDATE " . SHOTCAST_SESSION_TABLE . "
		SET time = $time
		WHERE session_ip = '" . $user_ip . "'";
	if(!$result = $db->sql_query($sql))
	{
		$sql = "UPDATE " . SHOTCAST_SESSION_TABLE . "
			SET time = $time
			WHERE username = '" . $nick . "'";
			if(!$result = $db->sql_query($sql))
			{
				user_listensc($nick);
			}
	}
	/*
	if(defined('RADIO_SESSION_TABLE'))
	{
		$sql = "DELETE FROM " . RADIO_SESSION_TABLE . " 
			WHERE session_ip = '$user_ip'";
		$db->sql_query($sql);

		$sql = "INSERT INTO " . RADIO_SESSION_TABLE . "
				(user_id, username, time, session_ip, bot_id)
				VALUES ('$user_id', '" . addslashes($nick) . "', '$time', '$user_ip', '$radio_bot_id')";
		$db->sql_query($sql);			
	}
	*/
}
function drop_shotcast_users($period)
{
	global $shotcast_config, $db, $lang;

	$current_time = date("U");
	//prevent delay
	$period = $period + 2;
	// Calcul max_time
	$max_time = $current_time - $period;

	$sql = "DELETE FROM " . SHOTCAST_SESSION_TABLE . " WHERE time < {$max_time}";
	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(CRITICAL_ERROR, 'SQL Error in function drop_shotcast_users()', '', __LINE__, __FILE__, $sql);
	}
}
/*
/* MX-CMS Code Ends
*/

//require($module_root_path . 'includes/config.'.$phpEx);
/***************************************************************************
 *
 *********************** SET UP VARIABLES HERE ****************************/

//
// Generic config parameters
//

// Radio Station Name here
$station_name = strip_tags($shotcast_config['shotcast_name']) ; //Radio Station Offline

// IP address (e.g. kdshfm.com)
$caster_ip = $shotcast_config['shotcast_host'];

// Port for the caster (e.g. 7000) Leave blank if u don't know what your doing.
$caster_port = (int) $shotcast_config['shotcast_port'];

// SHOUTcast Password
$caster_pass = $shotcast_config['shotcast_pass'];

// Caster type: shout or ice
$caster = $shotcast_config['caster'];

// What skin to use
$radio_skin = $shotcast_config['skin'];

// What language to use
$language = $default_lang;

// If Stream should start automatic when player is loaded
$autoplay = $shotcast_config['allow_autoplay'];

//
// Icecast config parameters
//

// If icecast is used with mount points else leave blank (e.g. /livemp3)
$icecast_mount_point = $shotcast_config['play_mount'];

// .pls type play list (e.g. listen.pls , livemp3)
$playlist_pls = $shotcast_config['play_list'];
//$playlist_pls = "livemp3";

// .asx type play list. Looks like u need an asx type of play list for wmp if
// u run Icecast (e.g. livemp3) 
$playlist_asx = $shotcast_config['play_asx'];

// IP address of the server where the play lists are located. Leave blank if
// they are on the same server as the caster ip.
$playlist_ip = $shotcast_config['play_host'];

// Port of the server where the play lists are located. Leave blank if they
// are on the same server as the caster ip.
//If other then port 80 where the play lists are located. Leave blank if they
$server_port = ($portal_config['server_port'] <> 80) ? ':' . (int) trim($portal_config['server_port']) . '/' : '/';
$playlist_port = isset($radio_config['play_port']) ? (int) trim($radio_config['play_port']) : $server_port;

/* 
* Logo config parameters
*/

// Logo should be put in the root of "/logos". U can use any format tha works
// on the web (jpeg, gif, png...)

// What do u want to use? CD-cover, equliazer, logo (cover, eq, logo)
$picture = $shotcast_config['picture_type'];

// Fallback if no cover is found (eq/logo)
$fallback = $shotcast_config['fallback'];

// The filename of the logo u want to use
$logo_name = $shotcast_config['logo']; //logo.gif = $images['mx_logo']

// Fallback URL to use when no cover is found. Leave blank if they
// are on the same server as the caster ip.
$caster_url = "";	
/************************* DO NOT EDIT BELOW THIS LINE *********************/
/************************ IF U DON'T KNOW WHAT U ARE DOING *****************/

/*
* Advanced config parameters
*/

// Use Curl to get cd cover data (yes/no)
$curl = isset($shotcast_config['allow_curl']) ? $shotcast_config['allow_curl'] : false;

// If both web server and icecast are behind a router and the web server needs
// to know the internal ip of caster so it can pull the info for the player.
// This could be the case if all three got different internal ip-s. 
$caster_internal_ip = $shotcast_config['cast_ip'];
$caster_internal_port = $shotcast_config['cast_port'];

$user_state_button = $shotcast_config['user_state_button'];

// Do not rely on cookie_secure, users seem to think that it means a secured cookie instead of an encrypted connection
$cookie_secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1 : 0;

//Server protocol if we use cookies
$protocol_type = ($cookie_secure) ? 'https' : 'http';
$server_protocol = $protocol_type.'://';

// Fallback URL to use when no cover is found. Edit above.
$no_cover_url = (empty($caster_url)) ? $server_protocol.$caster_ip . (($caster_port != 80) ? ":".$caster_port : "") : $caster_url;
$full_logo_url = PORTAL_URL . 'templates/' . $theme['template_name'] . '/images/'.$logo_name;

// Easier java debug messages (yes/no).
$java_debug = $shotcast_config['show_debug'];

/************************* DO NOT EDIT BELOW THIS LINE *********************/
/***************************************************************************/
?>