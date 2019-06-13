<?php
/**
*
* @package mxBB Portal Module - mx_shotcast
* @version $Id: admin_shotcast.php,v 1.9 2013/07/02 05:50:07 orynider Exp $
* @copyright (c) 2003 [orynider@rdslink.ro, OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/


/***************************************************************************
 * History:
 *
 *	2006/09/21
 *	- Modified from admin_chatbox.php by OryNider for mx_shotcast module
 *
 ***************************************************************************/

// ======================================================
//			[ ADMINCP COMMON INITIALIZATION ]
// ======================================================

//
// Add our entry to the Administration Control Panel...
//
if( !empty($setmodules) )
{
	$module['SteamCaster']['Settings'] = 'modules/mx_shotcast/admin/' . @basename(__FILE__);
	return;
}
define('IN_SHOTCAST', true);
//
// Setup basic portal stuff...
//
@define('IN_PORTAL', true);
$mx_root_path = '../../../';
$module_root_path = "../";

//
// Security and page header...
//
// require($mx_root_path . 'extension.inc');
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require($mx_root_path . '/admin/pagestart.'.$phpEx);

//
// Include common module stuff...
//
require($module_root_path . 'includes/common.'.$phpEx);

//
// Send page header...
//
include_once($mx_root_path . 'admin/page_header_admin.'.$phpEx);


// ======================================================
//			[ MAIN PROCESS ]
// ======================================================

//
// Read the module settings...
//
$sql = "SELECT * FROM ".SHOTCAST_CONFIG_TABLE;

if(!$result = $db->sql_query($sql))
{
	mx_message_die(GENERAL_ERROR, "Couldn't query shotcast config table", "", __LINE__, __FILE__, $sql);
}

while( $row = $db->sql_fetchrow($result) )
{
	$config_name = $row['config_name'];
	$config_value = $row['config_value'];
	$default_config[$config_name] = $config_value;

	$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];
	
	if( isset($HTTP_POST_VARS['submit']))
	{
		$sql = "UPDATE ".SHOTCAST_CONFIG_TABLE.
			" SET config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'" .
			" WHERE config_name = '$config_name'";
		if( !$db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, "Failed to update shotcast configuration for $config_name", "", __LINE__, __FILE__, $sql);
		}
		$default_config[$config_name] = $new[$config_name];
		$mx_cache->put('shotcast_config', $default_config);

		// Behave as per HTTP/1.1 spec for others
		echo '"<meta http-equiv="refresh" content="1;url="$file">"';
	}		
}

// CD-cover, equliazer, logo (cover, eq, logo)
if ($new['picture_type'] == 'cover')
{
	$picture_type = "
	<select name=\"picture_type\" size=\"1\">
	<option value=\"cover\" selected>
	cover
	</option>	
	<option value=\"eq\">
	eq
	</option>
	<option value=\"logo\">
	logo
	</option>	
	</select>";
}
elseif ($new['picture_type'] == 'eq')
{
	$picture_type = "
	<select name=\"picture_type\" size=\"1\">
	<option value=\"cover\">
	cover
	</option>	
	<option value=\"eq\" selected>
	eq
	</option>
	<option value=\"logo\">
	logo
	</option>	
	</select>";
}
elseif ($new['picture_type'] == 'logo')
{
	$picture_type = "
	<select name=\"picture_type\" size=\"1\">
	<option value=\"cover\">
	cover
	</option>	
	<option value=\"eq\">
	eq
	</option>
	<option value=\"logo\" selected>
	logo	
	</option>	
	</select>";
}
else
{
	$picture_type = "
	<select name=\"picture_type\" size=\"1\">
	<option value=\"cover\">
	cover
	</option>	
	<option value=\"eq\">
	eq
	</option>
	<option value=\"logo\">
	logo	
	</option>	
	</select>";
}

// Fallback if no cover is found (eq/logo)
if ($new['fallback'] == 'eq')
{
	$fallback_to = "
	<select name=\"fallback\" size=1>
	<option value=\"eq\" selected>
	eq
	</option>	
	<option value=\"logo\">
	logo
	</option>	
	</select>";
}
else
{
	$fallback_to = "
	<select name=\"fallback\" size=1>
	<option value=\"eq\">
	eq
	</option>	
	<option value=\"logo\" selected>	
	logo
	</option>	
	</select>";
}

//stream_type
if ($new['stream_type'] == 'mp3')
{
	$stream_type = "
	<select name=\"stream_type\" size=1>
	<option value=\"mp3\" selected>
	mp3
	</option>	
	<option value=\"icy\">
	icy
	</option>	
	</select>";
}
else
{
	$stream_type = "
	<select name=\"stream_type\" size=1>
	<option value=\"mp3\">
	mp3
	</option>	
	<option value=\"icy\" selected>
	icy
	</option>	
	</select>";
}

//Show status?
if ($new['show_status'] == true)
{
	$show_status = "
	<select name=\"show_status\" size=1>
	<option value=\"true\" selected>
	on
	</option>	
	<option value=\"false\">
	off
	</option>	
	</select>";
}
else
{
	$show_status = "
	<select name=\"show_status\" size=1>
	<option value=\"true\">
	on
	</option>	
	<option value=\"false\" selected>
	off
	</option>	
	</select>";
}

// ALLOW STREAM START AUTOMATIC WHEN PLAYER IS LOADED ?
$allow_autoplay_yes = ($new['allow_autoplay'] == 1) ? 'checked="checked"' : '';
$allow_autoplay_no = ($new['allow_autoplay'] == 0) ? 'checked="checked"' : '';

// ALLOW CURL?
$allow_curl_yes = ($new['allow_curl'] == 1) ? 'checked="checked"' : '';
$allow_curl_no = ($new['allow_curl'] == 0) ? 'checked="checked"' : '';

// ALLOW GUESTS?
$allow_guests_yes = ($new['allow_guests'] == 1) ? 'checked="checked"' : '';
$allow_guests_no = ($new['allow_guests'] == 0) ? 'checked="checked"' : '';

$show_listen_select_yes = ( $new['show_listen_select'] ) ? ' selected' : '';
$show_listen_select_no = ( !$new['show_listen_select'] ) ? ' selected' : '';

$template->set_filenames(array(
	"body" => "admin/shotcast_config_body.tpl")
);

$dir = $module_root_path . 'skins/';
$direct = opendir($dir);
$file = readdir($direct);
$skin = $file;
$stylelist_path = "\n";
while ($file = readdir($direct))
{
	$filetype = filetype($dir . $file);

    if ($file == ".." OR $file == "." OR $file == "")
    {
		$stylelist_path .= "\n";
    }
    elseif ($filetype == "dir")
    {
		if ($new['skin'] == $file)
		{
			$stylelist_path = "<option value=\"$file\" selected>$file</option>\n";
		}
		else
		{		
			$stylelist_path = "<option value=\"$file\">$file</option>\n";
		}
		$template->assign_block_vars('stylelist', array('SKINPATH' => $stylelist_path));		
    }
}

if ($new['skin'] == $skin)
{
	$stylelist_row1 = "<option value=\"$skin\" selected>$skin</option>\n";
}
else
{		
	$stylelist_row1 = "<option value=\"$skin\">$skin</option>\n";
}

$template->assign_vars(array(
	'S_ACTION'				=> mx_append_sid("admin_shotcast.$phpEx"),
	'L_SHOTCAST_SETTINGS'	=> $lang['shotcast_Settings'],
	'L_SHOTCAST_SETTINGS_EXPLAIN'	=> $lang['shotcast_Settings_explain'],
	'L_SHOTCAST'				=> $lang['Radio_name'], //L_STATION_NAME
	
	'L_STREAM'					=> $lang['shotcast_host'],
	'L_PORT'					=> $lang['shotcast_port'],
	'L_PASS'					=> $lang['shotcast_pass'],
	'L_PLAY_LIST'				=> $lang['play_list'],
	'L_SHOW_STATUS'				=> $lang['Show_status'],
	'L_STREAM_TYPE'				=> $lang['Stream_type'],	
	
	'L_CASTER'					=> $lang['caster'],
	
	'L_ALLOW_AUTOPLAY'			=> $lang['allow_autoplay'],
	'L_ALLOW_AUTOPLAY_EXPMAIN'	=> $lang['allow_autoplay_explain'],
	
	'L_PLAY_ASX'				=> $lang['play_asx'],
	'L_PLAY_HOST'				=> $lang['play_host'],
	'L_PLAY_PORT'				=> $lang['play_port'],
	'L_PLAY_MOUNT'				=> $lang['play_mount'],

	'L_PICTURE_TYPE'			=> $lang['picture_type'],
	'L_FALLBACK_TO'				=> $lang['fallback_to'],
	'L_CAST_LOGO'				=> $lang['cast_logo'],
	
	'L_ALLOW_CURL'				=> $lang['allow_curl'],
	'L_ALLOW_CURL_EXPLAIN'		=> $lang['allow_curl_explain'],	
	
	'L_SUBMIT'					=> $lang['Submit'],
	'L_RESET'					=> $lang['Reset'],
	'L_CHECK_PERIOD'			=> $lang['Check_period'],
	'L_CHECK_PERIOD_EXPLAIN'	=> $lang['Check_period_explain'],
	'L_SHOW_LISTEN'				=> $lang['show_listen'],
	'L_SHOW_LISTEN_INFO' 		=> $lang['show_listen_info'],

	'L_FORCE_ONLINE'			=> !empty($lang['Force_Online']) ? $lang['Force_Online'] : 'Force Online',
	
	'L_ALLOW_GUESTS' 			=> $lang['Allow_guests'],
	'L_GUESTNAME' 				=> $lang['guestname'],
    'L_GUESTNAME_EXPLAIN' 		=> $lang['guestname_explain'],	
	
	"L_NO" 					=> $lang['No'],
	"L_YES" 				=> $lang['Yes'],

	'STATION_NAME'				=> $new['shotcast_name'],	
	'STATION_HOST'				=> $new['shotcast_host'],
	'STATION_PORT'				=> $new['shotcast_port'],
	'STATION_PASS'				=> $new['shotcast_pass'],
	'PLAY_LIST'					=> $new['play_list'],
	'PLAY_ASX'					=> $new['play_asx'],
	'PLAY_HOST'					=> $new['play_host'],
	'PLAY_PORT'					=> $new['play_port'],
	'PLAY_MOUNT'				=> $new['play_mount'],	
	
	'S_CASTER'					=> $new['caster'],
	
	'ALLOW_AUTOPLAY_YES'		=> $allow_autoplay_yes,
	'ALLOW_AUTOPLAY_NO'			=> $allow_autoplay_no,

	'PICTURE_TYPE'				=> $picture_type,
	'FALLBACK_TO'				=> $fallback_to,
	'DISPLAY_LOGO'				=> $new['logo'],
	
	'ALLOW_CURL_YES'		=> $allow_curl_yes,
	'ALLOW_CURL_NO'			=> $allow_curl_no,	
	
	'CHECK_PERIOD'				=> $new['check_period'],


	//GUI_SETTING
	'USER_STATE_BUTTON'			=> $user_state_button,
	'S_LISTEN_YES' 				=> $show_listen_select_yes,
	'S_LISTEN_NO'				=> $show_listen_select_no,

	'ALLOW_GUESTS_YES' 			=> $allow_guests_yes,
	'ALLOW_GUESTS_NO' 			=> $allow_guests_no,
	'GUESTNAME' 				=> $new['guestname'],

	'L_SKINPATH'				=> $lang['skinpath'],
	'FIRST_ROW'					=> $stylelist_row1,	
	'SKINPATH'					=> $stylelist_path,
	'SKIN'						=> $new['skin'],	
	
	'FORCE_ON_ENABLED' 			=> ($new['force_online'] == 1) ? 'checked="checked"' : '',
	'FORCE_ON_DISABLED' 		=> ($new['force_online'] == 0) ? 'checked="checked"' : '',
	'STREAM_TYPE'				=> $stream_type,
	'SHOW_STATUS'				=> $show_status)
);

$template->pparse("body");
unset($colors, $colors_options);
include_once($mx_root_path . 'admin/page_footer_admin.' . $phpEx);

?>
