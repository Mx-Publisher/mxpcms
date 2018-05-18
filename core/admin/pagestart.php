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
 *    $Id: pagestart.php,v 1.4 2010/10/16 04:05:59 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

/**
 * mxBB Notes:
 * 	  The BLOCK_EDIT switch makes this file accessible when editing blocks in portal mode.
 */

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

define('IN_ADMIN', true);

$phpEx = substr(strrchr(__FILE__, '.'), 1);

//include_once($mx_root_path . 'extension.inc');
include_once($mx_root_path . 'common.' . $phpEx);
include_once($mx_root_path . 'includes/mx_functions_admincp.' . $phpEx);
include_once($mx_root_path . 'includes/mx_functions_blockcp.' . $phpEx);

include_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);
include_once($phpbb_root_path . 'includes/functions_post.' . $phpEx);

//
// Start session, user and style (template + theme) management
// - populate $userdata, $lang, $theme, $images and initiate $template.
//
$mx_user->init($user_ip, PAGE_INDEX);

//
// Start session management
//
//$userdata = session_pagestart($user_ip, PAGE_INDEX);
//mx_init_userprefs($userdata);

//
// End session management
//
if ( !$userdata['session_logged_in'] )
{
	mx_redirect(mx_append_sid($mx_root_path."login.php?redirect=admin/index.$phpEx", true));
	print_r($userdata);
}

if ( !($userdata['user_level'] == ADMIN) )
{
	mx_message_die(GENERAL_MESSAGE, $lang['Not_admin']);
}

// Ensure $mx_user->session_id is populated...
if ($mx_request_vars->get('sid', MX_TYPE_NO_TAGS) != $mx_user->session_id)
{
	$url = str_replace(preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name'])), '', $_SERVER['REQUEST_URI']);
	$url = str_replace(preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path'])), '', $url);
	$url = str_replace('//', '/', $url);
	$url = preg_replace('/sid=([^&]*)(&?)/i', '', $url);
	$url = preg_replace('/\?$/', '', $url);
	$url .= ((strpos($url, '?')) ? '&' : '?') . 'sid=' . $mx_user->session_id;

	mx_redirect($url);
}

if (!$userdata['session_admin'])
{
	mx_redirect(mx_append_sid($mx_root_path."login.php?redirect=admin/index.$phpEx&admin=1", true));
	print_r($userdata);
}

if( empty($no_page_header) )
{
	//
	// Not including the pageheader can be neccesarry if META tags are
	// needed in the calling script.
	//
	include($mx_root_path . 'admin/page_header_admin.' . $phpEx);
}
?>