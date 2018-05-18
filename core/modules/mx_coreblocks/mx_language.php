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
 *    $Id: mx_language.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
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

//
// Updating language and theme - mx_laguage.php and mx_theme.php coreblocks
//
if ( isset($HTTP_POST_VARS['default_lang']) && preg_match('#^[a-z_]+$#', $HTTP_POST_VARS['default_lang']) && $userdata['user_level'] == ADMIN )
{
	$mx_language = strip_tags($HTTP_POST_VARS['default_lang']);
	$board_config['default_lang'] = $mx_language;

	$sql = "UPDATE " . CONFIG_TABLE . " SET
		config_value = '$mx_language'
		WHERE config_name = 'default_lang'";
	if ( !$db->sql_query($sql) )
	{
		mx_message_die(GENERAL_ERROR, "Failed to update default language configuration", '', __LINE__, __FILE__, $sql);
	}
	setcookie('default_lang', $mx_language, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
}

if ( isset($HTTP_POST_VARS['user_lang']) && preg_match('#^[a-z_]+$#', $HTTP_POST_VARS['user_lang']) && $userdata['session_logged_in'] )
{
	$mx_language = strip_tags($HTTP_POST_VARS['user_lang']);
	$userdata['user_lang'] = $mx_language;

	$sql = "UPDATE " . USERS_TABLE . " SET
		user_lang = '$mx_language'
		WHERE user_id = '" . $userdata['user_id'] . "'";
	if ( !$db->sql_query($sql) )
	{
		mx_message_die(GENERAL_ERROR, "Failed to update user lang configuration", '', __LINE__, __FILE__, $sql);
	}
}

$template->set_filenames(array(
	'body_language' => 'mx_language.tpl')
);

if ( $userdata['user_level'] == ADMIN )
{
	$template->assign_block_vars('switch_is_admin', array(
		'L_CHANGE_NOW' => $lang['Change_default_lang'],
		'LANG_SELECT' => language_select($board_config['default_lang'], 'default_lang')
	));
}
if ( $userdata['session_logged_in'] )
{
	$template->assign_block_vars('switch_is_user', array(
		'L_CHANGE_NOW' => $lang['Change_user_lang'],
		'LANG_SELECT' => language_select($userdata['user_lang'], 'user_lang')
	));
}

$template->assign_vars(array(
	'ACTION_URL' => mx_append_sid(PORTAL_URL . "index.$phpEx?page=$page_id"),
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'L_SELECT_LANG' => $lang['Board_lang'],
	'L_CHANGE_NOW' => $lang['Change'],
	'L_TITLE' => $lang['Portal_lang'],
	'L_SUBTITLE' => $lang['SELECTGUILANG'] 
));

//
// Display only when the user is logged in
//
if ( $userdata['session_logged_in'] )
{
	$template->pparse('body_language');
}
else 
{
	$mx_block->show_title = false;
	$mx_block->show_block = false;	
}

?>