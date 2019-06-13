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
	die('Hacking attempt @ file: '. basename(__FILE__));
}

@define('IN_ADMIN', true);
@define('ADMIN_START', true);
@define('NEED_SID', true);

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
$mx_user->init($user_ip, PAGE_ACP);

/*
* Initiate user style (template + theme) management
* - populate $theme, $images and initiate $template.
*/
$mx_user->init_style();

$mx_user->_load_lang($mx_root_path . 'includes/shared/phpbb3/', 'acp/common');

// Have they authenticated for this session?
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'smf2':
	case 'mybb':
	case 'phpbb2':
	case 'olympus':
		if ( !$mx_user->data['session_logged_in'] )
		{
			mx_redirect(mx_append_sid("login.php?redirect=admin/index.$phpEx", true));
		}
	break;

	case 'ascraeus':
	case 'rhea':
	case 'proteus':
	case 'phpbb3':
		
		if(!isset($phpbb_auth) || !is_object($phpbb_auth))
		{
			$phpbb_auth = new phpbb_auth();
		}
		$phpbb_auth->acl($mx_user->data);
		
		// Is user any type of admin? No, then stop here, each script needs to
		// check specific permissions but this is a catchall
		if (!$phpbb_auth->acl_get('a_'))
		{
			send_status_line(403, 'Forbidden');
			trigger_error('NO_ADMIN');
		}
		
		define('IN_LOGIN', true);
		if ( !$mx_user->data['session_logged_in'] )
		{
			// Get referer to redirect user to the appropriate page after delete action
			$redirect_url = mx_append_sid("{$phpbb_root_path}adm/index.$phpEx", "i=users&mode=overview&redirect={$mx_root_path}admin/index.$phpEx&admin=1");
			$phpbb_login_url = mx_append_sid("{$phpbb_root_path}ucp.php?mode=login&redirect=$redirect_url");
			
			//This will return: header('Location: ' . $phpbb_login_url);
			mx_redirect($phpbb_login_url, true);
			//mx_redirect(mx_append_sid("login.php?redirect=admin/index.$phpEx", true));
		}
	break;
}


if ( !($mx_user->data['user_level'] == ADMIN) )
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

	//mx_redirect(PORTAL_URL . $url);
}

// Have they authenticated (again) as an admin for this session?
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'smf2':
	case 'mybb':
	case 'phpbb2':
	case 'olympus':
		if (!$mx_user->data['session_admin'])
		{
			mx_redirect(mx_append_sid("login.php?redirect=admin/index.$phpEx&admin=1", true));
		}
	break;

	case 'ascraeus':
	case 'rhea':
	case 'proteus':
	case 'phpbb3':
		if (!isset($mx_user->data['session_admin']) || !$mx_user->data['session_admin'])
		{
			@define('IN_LOGIN', true);
			mx_redirect(mx_append_sid(PHPBB_URL ."ucp.php?mode=login&redirect=" . PORTAL_URL . "admin/index.$phpEx&admin=1", true));
			//mx_login_box('', $mx_user->lang['LOGIN_ADMIN_CONFIRM'], $mx_user->lang['LOGIN_ADMIN_SUCCESS'], true, false);
			//mx_redirect(mx_append_sid("login.php?redirect=admin/index.$phpEx&admin=1", true));
		}
	break;
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