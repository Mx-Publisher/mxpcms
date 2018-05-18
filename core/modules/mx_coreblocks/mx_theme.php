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
 *    $Id: mx_theme.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
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

if ( isset($HTTP_POST_VARS['default_style']) && $userdata['user_level'] == ADMIN )
{
	$mx_default_style = intval($HTTP_POST_VARS['default_style']);
	$board_config['default_style'] = $mx_default_style;

	$sql = "UPDATE " . CONFIG_TABLE . " SET
		config_value = '$mx_default_style'
		WHERE config_name = 'default_style'";
	if ( !$db->sql_query($sql) )
	{
		mx_message_die(GENERAL_ERROR, "Failed to update default style configuration", '', __LINE__, __FILE__, $sql);
	}
	setcookie('default_style', $mx_default_style, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
}

if ( isset($HTTP_POST_VARS['user_style']) && $userdata['session_logged_in'] )
{
	$mx_user_style = intval($HTTP_POST_VARS['user_style']);
	$userdata['user_style'] = $mx_user_style;

	$sql = "UPDATE " . USERS_TABLE . " SET
		user_style = '$mx_user_style'
		WHERE user_id = '" . $userdata['user_id'] . "'";
	if ( !$db->sql_query( $sql ) )
	{
		mx_message_die(GENERAL_ERROR, "Failed to update user style configuration", '', __LINE__, __FILE__, $sql);
	}
}

$template->set_filenames(array(
	'body_theme' => 'mx_theme.tpl')
);

if ( $userdata['user_level'] == ADMIN )
{
	$template->assign_block_vars('switch_is_admin', array(
		'L_CHANGE_NOW' => $lang['Change_default_style'],
		'STYLE_SELECT' => style_select($board_config['default_style'], 'default_style')
	));
}
if ( $userdata['session_logged_in'] )
{
	$template->assign_block_vars('switch_is_user', array(
		'L_CHANGE_NOW' => $lang['Change_user_style'],
		'STYLE_SELECT' => style_select($userdata['user_style'], 'user_style')
	));
}

$template->assign_vars(array(
	'ACTION_URL' => mx_append_sid(PORTAL_URL . "index.$phpEx?page=$page_id"),
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'L_BOARD_STYLE' => $board_config['default_style'],
	'L_CHANGE_NOW' => $lang['Change'],
	'L_TITLE' => $lang['Theme'],
	'L_SUBTITLE' => $lang['SelectTheme']
));

//
// Display only when the user is logged in
//
if ( $userdata['session_logged_in'] )
{
	$template->pparse('body_theme');
}
else 
{
	$mx_block->show_title = false;
	$mx_block->show_block = false;
}

?>