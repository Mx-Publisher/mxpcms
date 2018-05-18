<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: mx_login.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

$template->set_filenames(array(
	'body_login' => 'mx_login.tpl')
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

//
// Login box?
//
if ( !$userdata['session_logged_in'] )
{
	$template->assign_block_vars('switch_user_logged_out', array());
	
	//
	// Allow autologin?
	//
	if (!isset($board_config['allow_autologin']) || $board_config['allow_autologin'] )
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