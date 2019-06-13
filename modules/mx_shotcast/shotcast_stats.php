<?php
/**
*
* @package mxBB Portal Module - mx_shotcast
* @version $Id: shotcast_stats.php,v 1.10 2013/07/02 02:46:54 orynider Exp $
* @copyright (c) 2002-2006 [OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// ERROR HANDLING
//
//error_reporting( E_ALL );
//@ini_set( 'display_errors', '1' );

// --------------------------------------------------------------------------------
// Security check
//

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
	$module_root_path = "./";
	$phpEx = substr(strrchr(__FILE__, '.'), 1); 
}

//
// Common Includes and Read Module Settings
//
if( !file_exists($module_root_path . 'includes/common.'.$phpEx) )
{
	mx_message_die(GENERAL_ERROR, "Could not find mx_shotcast includes folder.", "", __LINE__, __FILE__);
}
define('IN_SHOTCAST', true);
include_once($module_root_path . 'includes/common.'.$phpEx);

$shotcast_state_icon = ($state == 'Up') ? 'online.gif' : 'offline.gif';
//
// Read block Configuration
//
// $block_config  = read_block_config($block_id);
$block_title = $mx_block->block_info['block_title'];
$b_description = $mx_block->block_info['block_desc'];
$block_size = $mx_block->block_info['block_size'];
$block_id = $mx_block->block_info['block_id'];
$block_size = ( isset($block_size) && !empty($block_size) ? $block_size : '100%' );

// Generate block output (using templates)
// Generate HTML for the block...
//
$template->set_filenames(array('statsbody' => 'shotcast_stats.tpl'));

$template->assign_vars(array(
	'SHOTCAST_STATE_IMG'	=> $module_root_path ."skins/".SKIN."/".$shotcast_state_icon,
	'L_STATION'				=> $lang['Stats_for'],
	'S_STATION'				=> $server_name,
	'L_STATE'				=> $lang['Server_state'],
	'S_STATE'				=> $state,
	'L_SERVER_TITLE'		=> $lang['Station'],
	'S_SERVER_TITLE'		=> $server_description,
	'L_SONG'				=> $lang['Current_song'],
	'S_SONG'				=> $title,
	'L_BITRATE'				=> $lang['Bitrate'],
	'S_BITRATE'				=> $bitrate,
	'L_PEAK_LISTENERS'		=> $lang['Listeners_peak'],
	'S_PEAK_LISTENERS'		=> $currentlisteners,
	'L_MAX_LISTENERS'		=> $lang['Max_listeners'],
	'S_MAX_LISTENERS'		=> $maxlisteners,
	'L_SERVERGENRE'			=> $lang['Server_genre'],
	'S_SERVERGENRE'			=> $stream_genre,
	'L_SONGURL'				=> $lang['Stream_URL'],
	'S_STREAMURL'			=> $no_cover_url,
	'S_SONGURL'				=> aws_getInfo($artist, $song, 'track', 'url_info', $no_cover_url, false),	
	'S_SERVERURL'			=> $server_url,
	'L_REPORTEDLISTENERS'	=> $lang['Unique'],
	'S_REPORTEDLISTENERS'	=> $peaklisteners,
	'BLOCK_SIZE'			=> $block_size,
	'BLOCK_ID' 				=> $block_id,
	'L_DESC'				=> $b_description,	
	'L_TITLE'     			=> $block_title,)
);

//$mimetype = "";
//$server_description = "";
//$quality = "";
//$video_quality = "";
//$frame_size = "";
//$frame_rate = "";
//$server_url = "";
//$artist = "";

$template->pparse('statsbody');

?>