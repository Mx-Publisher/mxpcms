<?php
/**
*
* @package mxBB Portal Module - mx_shotcast
* @version $Id: shotcast_front.php,v 1.13 2013/07/02 23:12:38 orynider Exp $
* @copyright (c) 2002-2006 [OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

/***************************************************************************
 * mx_chatbox module written by markus_petrux at phpmix dot com
 ***************************************************************************
 * History:
 * 2006/09/10
 * -modified by OryNider to shotcast_front
 ***************************************************************************/
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
}

// --------------------------------------------------------------------------------
// Initialization
//
define('IN_SHOTCAST', true);

//
// Common Includes and Read Module Settings
//
if( !file_exists($module_root_path . 'includes/common.'.$phpEx) )
{
	mx_message_die(GENERAL_ERROR, "Could not find mx_shotcast includes folder.", "", __LINE__, __FILE__);
}

require($module_root_path .'includes/common.'.$phpEx);

if (empty($shotcast_config['shotcast_host']))
{
	$shotcast_config['shotcast_host'] = '127.0.0.1';
}

//
// Read block Configuration
//
$block_title = (isset($server_name) && !empty($server_name) ? $server_name : $mx_block->block_info['block_title']);
$b_description = $mx_block->block_info['block_desc'];
$block_size = (isset($column) ? $mx_page->columns[$column]['column_size'] : 176);
$shotcast_icon = 'cast_front.gif';
$wmp_icon = 'wmp_front.gif';
$real_icon = 'real_front.gif';

if ($userdata['user_level'] == ADMIN) 
{ 
	$user_color = $theme['fontcolor3'];
	$user_style = 'style="color:#' . $user_color . '; font-weight : bold;"';  
} 
else if ($album_userdata['user_level'] == MOD) 
{ 
	$user_color = $theme['fontcolor2'];
	$user_style = 'style="color:#' . $user_color . '; font-weight : bold;"';  
}
else 
{ 
	$user_colour = $theme['fontcolor1'];
	$user_style = 'style="font-weight : bold;"'; 
}

// --------------------------------------------------------------------------------
// Get ChatBox Session information
//

// Get all remain sessions
$sql = "SELECT * FROM " . SHOTCAST_SESSION_TABLE;
if (!$sol = $db->sql_query($sql))
{
	mx_message_die(GENERAL_ERROR, "Could not query radio Session information", "", __LINE__, __FILE__, $sql);
}

if(empty($currentlisteners))
{ 
	$howmanypeak = $currentlisteners = $shotcast_config['currentlisteners']; 
}
else
{ 
	$howmanypeak = $currentlisteners; 
}

$howmanylisten = $db->sql_numrows($sol);	// Return this

//Get registreg users sessions
$sql = "SELECT * FROM " . SHOTCAST_SESSION_TABLE . " WHERE user_id <> '" . ANONYMOUS . "'";
if (!$sol = $db->sql_query($sql))
{
	mx_message_die(GENERAL_ERROR, "Could not query radio Session information", "", __LINE__, __FILE__, $sql);
}
$isimler[0] = $db->sql_numrows($sol);

$i = 1;
while ($record = $db->sql_fetchrow($sol))
{
	$isimler[$i++] = $record['username'];

	// Checks if guests are allowed 
	if($shotcast_config['allow_guests']) 
	{                           
      	if (!$userdata['session_logged_in']) 
		{  
			if ($record['username'] == $userdata['username'])
			{
				$can_listen = "yes";
			}
			else
			{
				$can_listen = "yes";
			}
		}
		else
		{  
			if ($shotcast_config['show_listen_select'])
			{
				$can_listen = "yes";
			}
			elseif ($record['username'] == $userdata['username'])
			{
				$can_listen = "no";
			}
        	else
			{
				$can_listen = "yes";
			}
		}                    
	}           
	else 
	{
		if ($shotcast_config['show_listen_select'])
		{
			$can_listen = "yes";
		}
		elseif ($record['username'] == $userdata['username'])
		{
			$can_listen = "no";
		}
		else
		{
			$can_listen = "yes";
		}
	}
}
$profile = !(PORTAL_BACKEND === 'phpbb3') ? 'profile' : 'memberlist';
if ($userdata['user_id'] != ANONYMOUS)
{
	$profile_url = '';
}
else
{
	$profile_url = mx3_append_sid("{$phpbb_root_path}$profile.$phpEx", 'mode=viewprofile');
	$profile_url .= '&amp;u=' . (int) $userdata['user_id'];
}
$listeners = (empty($isimler[1]) ? '' : "<a href=\"". mx_append_sid("{$phpbb_root_path}.$profile.$phpEx?mode=viewprofile&amp;u=".$isimler[1]) ."\" >". $isimler[1] ."</a>");
for($s = 2; $s <= $isimler[0]; $s++)
{
	$listeners .= ", <a href=\"". mx_append_sid("{$phpbb_root_path}.$profile.$phpEx?mode=viewprofile&amp;u=".$isimler[$s]) ."\" >". $isimler[$s] ."</a><br />";
}
//Get bots sessions
$sql = "SELECT * FROM " . SHOTCAST_SESSION_TABLE . "
		WHERE user_id = '" . ANONYMOUS . "'
		AND bot_id <> '" . ANONYMOUS . "'";
if (!$sol = $db->sql_query($sql))
{
	mx_message_die(GENERAL_ERROR, "Could not query radio Session information", "", __LINE__, __FILE__, $sql);
}
$isimlerb[0] = $db->sql_numrows($sol);

$i = 1;
while ($record = $db->sql_fetchrow($sol))
{
	$isimlerb[$i++] = $record['username'];
}

$radio_bots = empty($isimlerb[1]) ? '' : $isimlerb[1];
for($s = 2; $s <= $isimlerb[0]; $s++)
{
	$radio_bots .= ', ' . $isimlerb[$s];
}

$msn_color = 'style="font-weight: bold; color:#' . $theme['fontcolor1'] . '"';
$yahoo_color = 'style="font-weight: bold; color: #DD2222;"';
$lycos_color = 'style="font-weight: bold;"';

$radio_bots = str_replace('google','<span style="font-weight: bold; color: #2244BB;">G</span><span style="font-weight: bold; color: #DD2222;">o</span><span style="font-weight: bold; color: #EEBB00;">o</span><span style="font-weight: bold; color: #2244BB;">g</span><span style="font-weight: bold; color: #339933;">l</span><span style="font-weight: bold; color: #DD2222;">e</span>',$radio_bots);  
$radio_bots = str_replace('adsense','<span ' . $yahoo_color . '>adsense</span>',$radio_bots);
$radio_bots = str_replace('msn','<span ' . $msn_color . '>msn</span>',$radio_bots);
$radio_bots = str_replace('lycos','<span ' . $lycos_color . '>lycos</span>',$radio_bots);
$radio_bots = str_replace('yahoo','<span ' . $yahoo_color . '>Yahoo!</span>',$radio_bots);
$radio_bots = str_replace('slurp','<span ' . $yahoo_color . '>Yahoo! Slurp</span>',$radio_bots);

if ($isimlerb[0])
{
	$listeners .= ', ' . $radio_bots;
}

// --------------------------------------------------------------------------------
// Generate block output (using templates)
// Generate HTML for the block...
//
$template->set_filenames(array(
	'front_body' => 'shotcast_front.tpl')
);

if ($userdata['user_id'] != ANONYMOUS)
{
	if ($can_listen == "no")
	{
		$template->assign_block_vars('switch_user_logged_out', array());
	}
	else
	{
		$template->assign_block_vars('switch_user_logged_in', array());
	}
	
}
else
{
	if ($can_listen == "no")
	{
		$template->assign_block_vars('switch_user_listening', array());
	}
	else
	{
		$template->assign_block_vars('switch_user_logged_in', array());
	}
}

if(empty($listeners))
{
	$template->assign_block_vars('switch_listeners_list_off', array());
	$listeners_list = '';
}
else
{
	$template->assign_block_vars('switch_listeners_list_on', array());
	$listeners_list = sprintf($lang['Who_Are_Listening'], $listeners);
}

$template->assign_vars(array(
	'SHOTCAST_IMG'				=> $module_root_path ."skins/".SKIN."/".$shotcast_icon,
	'WMP_IMG'				=> $module_root_path ."skins/".SKIN."/".$wmp_icon,
	'REAL_IMG'				=> $module_root_path ."skins/".SKIN."/".$real_icon,
	'TOTAL_LISTENERS_ONLINE'	=> sprintf($lang['How_Many_Listeners'], $howmanylisten),
	'TOTAL_LISTENERS_PEAK'		=> sprintf($lang['How_Many_Peak'], $howmanypeak),
	'LISTENERS_LIST'			=> $listeners_list,
	'L_CLICK_TO_LISTEN_STATION'	=> $lang['Click_to_listen_station'],
	'L_CLICK_TO_LISTEN_WMP'		=> $lang['Click_to_listen_wmp'],
	'L_CLICK_TO_LISTEN_REAL'	=> $lang['Click_to_listen_real'],
	'S_LISTEN_STATION'			=> mx_append_sid($module_root_path.'radioplayer.'.$phpEx),
	'S_LISTEN_WMP'				=> mx_append_sid($module_root_path.'radioplayer.php?embed=wmp7'),
	'S_LISTEN_REAL'				=> mx_append_sid($module_root_path.'radioplayer.php?embed=real'),
	'S_MOREINFO'				=> mx_append_sid($module_root_path.'moreinfo.'.$phpEx),
	'L_LOGIN_TO_LISTEN_STATION'	=> $lang['Login_to_listen_station'],
	'L_ALREADY_LISTENING'		=> $lang['Already_listening'],
	'BLOCK_SIZE'				=> $block_size,
	'L_TITLE' 					=> $block_title,
	'L_DESC'					=> $b_description,	
// 	'U_URL'					=> mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?block_id=' . $block_id),
	'BLOCK_ID' 					=> $block_id,
	'L_VERSION'					=> _SHOTCAST_VERSION)
);

$template->pparse('front_body');


// REMOVE OLD SESSIONS
//drop_shotcast_users($period);

//unset($liteners, $sql, $howmanylisten, $listeners_list, $block_size, $module_root_path, $isimler, $can_listen);

?>