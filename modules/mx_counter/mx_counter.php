<?php
/**
*
* @package mxBB Portal Module - mx_counter
* @version $Id: mx_counter.php,v 1.6 2011/03/29 02:39:29 orynider Exp $
* @copyright (c) 2002-2006 [Florin Bodin] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/



if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// ERROR HANDLING
//
//error_reporting( E_ALL );

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$block_size = ( isset($block_size) && !empty($block_size) ? $block_size : '100%' );

//
// Get general counter information
//
include($module_root_path . 'includes/' . 'counter_common.'.$phpEx);

//Set a cookie for the counter so we know we have been here before
setcookie($board_config['cookie_name'] . '_pubOry_counter', "set", time() + 31536000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);

//check cookie
global $HTTP_COOKIE_VARS;
if($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_pubOry_counter'])
{
	$bInc=false;
}
else 
{
	$bInc=true;
}

$digitpath = $counter_config['digitpath'];
$digits = $counter_config['digits'];

if (empty($digitpath))
{
	$digitpath = 'set1';
}

if (empty($digits))
{
	$digits = '5';
}

//read old counter data
$imagedirectory = IMAGEDIRECTORY . $digitpath . '/';

$sql2 = "SELECT * 
		FROM ".COUNTER_SESSION_TABLE."
		WHERE count_id = 1";

$result2 = $db->sql_query($sql2);

if( !($result2 = $db->sql_query($sql2)) )
{
	mx_message_die(GENERAL_ERROR, "Couldn't query counter session table", "", __LINE__, __FILE__, $sql2);
}
else
{
	while( $currentcount = $db->sql_fetchrow($result2) )
	{

		$currentcount = $currentcount['currentcount'];

		//check if we are incrementing counter
		if($bInc)
		{
			$newcount = $currentcount + 1;
		}
		else
		{
			$newcount = $currentcount;
		}

		//if we incremented, write this value
		if($bInc)
		{
			update_count($newcount);
		}

		//
		// Start output of page
		//
		$template->set_filenames(array(
			'body_block' => 'mx_counter.tpl')
		);

		$template->assign_vars(array(
			'BLOCK_SIZE' => (!empty($block_size) ? $block_size : '100%'),
			'L_TITLE' => (!empty($lang[$title]) ? $lang[$title] : $title),
			'L_PORTAL_COUNTER' => (!empty($lang['portal_counter']) ? $lang['portal_counter'] : ''),
			'COUNTER_DATA' => counter_data($newcount),
			'U_URL' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?block_id=' . $block_id),
			'BLOCK_ID' => $block_id,
			'S_HIDDEN_FORM_FIELDS' => $s_hidden_fields)
		);

		$template->pparse('body_block');
	}
}

?>