<?php
/**
*
* @package MX-Publisher Core
* @version $Id: pagestart.php,v 1.46 2014/09/16 06:25:30 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !defined('IN_PORTAL') )
{
	die('Hacking attempt @ line: ' . __LINE__ .' & file: '. basename(__FILE__));
}

@define('IN_ADMIN', true);

$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($mx_root_path . 'common.' . $phpEx);
include_once($mx_root_path . 'includes/mx_functions_admincp.' . $phpEx);
include_once($mx_root_path . 'includes/mx_functions_blockcp.' . $phpEx);

if( !function_exists('prepare_message') )
{
	$mx_cache->load_file('functions_post', 'phpbb2');
}

if( !function_exists('add_search_words') )
{
	$mx_cache->load_file('functions_search', 'phpbb2');
}

/*
* Start session, user and style (template + theme) management
* - populate $userdata, $lang, $theme, $images and initiate $template.
*/
$mx_user->init($user_ip, PAGE_INDEX);

if ( !$userdata['session_logged_in'] )
{
	mx_redirect(mx_append_sid("login.php?redirect=admin/index.$phpEx", true));
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