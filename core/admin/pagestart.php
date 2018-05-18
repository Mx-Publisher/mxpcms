<?php
/**
*
* @package mxBB Portal Core
* @version $Id: pagestart.php,v 1.2 2009/01/24 16:45:47 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

@define('IN_ADMIN', true);

$phpEx = substr(strrchr(__FILE__, '.'), 1);

include_once($mx_root_path . 'common.' . $phpEx);
include_once($mx_root_path . 'includes/mx_functions_admincp.' . $phpEx);
include_once($mx_root_path . 'includes/mx_functions_blockcp.' . $phpEx);
include_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

if( !function_exists('prepare_message') )
{
	$mx_cache->load_file('functions_post');
}

if( !function_exists('add_search_words') )
{
	$mx_cache->load_file('functions_search');
}

//
// Start session, user and style (template + theme) management
// - populate $userdata, $lang, $theme, $images and initiate $template.
//
$mx_user->init($user_ip, PAGE_INDEX);

if ( !$userdata['session_logged_in'] )
{
	mx_redirect(mx_append_sid("login.php?redirect=admin/index.$phpEx", true));
}

if ( !($userdata['user_level'] == ADMIN) )
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

	mx_redirect("admin/index.$phpEx?sid=" . $userdata['session_id']);
}

if (!$userdata['session_admin'])
{
	mx_redirect(mx_append_sid("login.php?redirect=admin/index.$phpEx&admin=1", true));
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