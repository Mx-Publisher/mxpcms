<?php
/***************************************************************************
 *                               pagestart.php
 *                            -------------------
 *   begin                : Thursday, Aug 2, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: pagestart.php,v 1.1.2.7 2004/03/24 14:43:31 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if (!defined('IN_PORTAL'))
{
	die("Hacking attempt");
}

define('IN_ADMIN', true);
// Include files
//
// Let's include some stuff...
//
$phpEx = substr(strrchr(__FILE__, '.'), 1);
@include_once($mx_root_path . 'common.' . $phpEx);
@include_once($mx_root_path . 'includes/mx_functions_admincp.' . $phpEx);
@include_once($mx_root_path . 'includes/mx_functions_blockcp.' . $phpEx);
@include_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);
@include_once($mx_root_path . 'includes/functions_post_phpbb2.' . $phpEx);

//
// Start session, user and style (template + theme) management
// - populate $userdata, $lang, $theme, $images and initiate $template.
//
$mx_user->init($user_ip, PAGE_INDEX);
//
//
//

if ( !$userdata['session_logged_in'] )
{
	mx_redirect(append_sid("login.php?redirect=modcp/", true));
}

if ( $userdata['user_level'] != MOD && $userdata['user_level'] != ADMIN )
{
	mx_message_die(GENERAL_MESSAGE, $lang['Not_admin']);
}

if( $HTTP_GET_VARS['sid'] != $userdata['session_id'] )
{
	$url = str_replace(preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name'])), '', $HTTP_SERVER_VARS['REQUEST_URI']);
	$url = str_replace(preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path'])), '', $url);
	$url = str_replace('//', '/', $url);
	$url = preg_replace('/sid=([^&]*)(&?)/i', '', $url);
	$url = preg_replace('/\?$/', '', $url);
	$url .= ((strpos($url, '?')) ? '&' : '?') . 'sid=' . $userdata['session_id'];

	mx_redirect("modcp/?sid=" . $userdata['session_id']);
}


if (empty($no_page_header))
{
	// Not including the pageheader can be neccesarry if META tags are
	// needed in the calling script.
	include('./page_header_mod.'.$phpEx);
}

?>