<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_login.php,v 1.17 2014/05/19 18:14:57 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
*
*/

if(!defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$description = $b_description = $mx_block->block_info['block_desc'];
$b_block_size = isset($mx_block->block_info['block_size']) ? $mx_block->block_info['block_size'] : '100%'; 
$b_block_size = '100%'; 
$block_size = !empty($block_size) ? $block_size : $b_block_size;

$template->set_filenames(array(
	'body_login' => 'mx_login.html')
);

$template->assign_vars(array(
	'BLOCK_SIZE' => $block_size,
	'S_LOGIN_ACTION' => mx_append_sid(PORTAL_URL . "login.$phpEx"),
	'L_USERNAME' => $lang['Username'],
	'L_PASSWORD' => $lang['Password'],
	'L_LOGIN' => $lang['Login'],
	'L_TITLE' => $lang['Login'],
	'L_LOG_ME_IN' => $lang['Log_me_in'],
	'L_AUTO_LOGIN' => $lang['Log_me_in'],
	'L_LOGIN_LOGOUT' => $lang['Login']
));

// Login box?
if (!$userdata['session_logged_in'])
{
	$template->assign_block_vars('switch_user_logged_out', array());
	
	// Allow autologin?
	if (!isset($board_config['allow_autologin']) || $board_config['allow_autologin'])
	{
		$template->assign_block_vars('switch_allow_autologin', array());
	}
}
else
{
	$template->assign_block_vars('switch_user_logged_in', array());
}

$template->pparse('body_login');
?>