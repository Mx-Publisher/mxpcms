<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_phpbb_login.php,v 1.17 2014/05/19 18:14:57 orynider Exp $
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
$s_display = false;
$err = '';
$l_explain = '';
$block_size = !empty($block_size) ? $block_size : $b_block_size;

//Is Admin (phpBB3+)
if(!isset($phpbb_auth) || !is_object($phpbb_auth))
{
	$phpbb_auth = new phpbb_auth();
}
$phpbb_auth->acl($mx_user->data);
$admin = (!$phpbb_auth->acl_get('a_') && $mx_user->data['user_id'] != ANONYMOUS) ? true : false;

// Assign credential for username/password pair
$credential = ($admin) ? md5(unique_id()) : false;

// Hidden Fields
$s_hidden_fields = array(
	'sid'		=> $mx_user->session_id,
);

// Get referer to redirect user to the appropriate page after delete action
$redirect_url = mx_append_sid(PORTAL_URL . "index.$phpEx", (isset($page_id) ? "?page={$page_id}" : "?page=" . $mx_request_vars->request('page', MX_TYPE_INT, 2)) . (isset($cat_nav) ? "&cat_nav={$cat_nav}" : ""));

if ($redirect)
{
	$s_hidden_fields['redirect'] = $redirect;
}

if ($admin)
{
	$s_hidden_fields['credential'] = $credential;
}

$template->set_filenames(array(
	'phpbb_login' => 'mx_phpbb_login.html'
	)
);

$template->assign_vars(array(
	'BLOCK_SIZE' => $block_size,
	'S_LOGIN_ACTION'		=> mx_append_sid("{$phpbb_root_path}ucp.php?mode=login&redirect=$redirect_url"),
	'U_SEND_PASSWORD' => ($board_config['email_enable']) ? mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=sendpassword") : '',

	'U_TERMS_USE'			=> mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=terms"),
	'U_PRIVACY'				=> mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=privacy"),
	'UA_PRIVACY'			=> addslashes(mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=privacy")),

	'S_DISPLAY_FULL_LOGIN'	=> ($s_display) ? true : false,
	'S_HIDDEN_FIELDS' 		=> $s_hidden_fields,

	'S_ADMIN_AUTH'			=> $admin,
	'USERNAME'				=> ($admin) ? $mx_user->data['username'] : '',

	'USERNAME_CREDENTIAL'	=> 'username',
	'PASSWORD_CREDENTIAL'	=> ($admin) ? 'password_' . $credential : 'password',
	
	'L_ENTER_PASSWORD' => $mx_request_vars->is_get('admin') ? $lang['Admin_reauthenticate'] : $lang['Enter_password'],
	'L_SEND_PASSWORD' => $lang['Forgotten_password'],
	'L_USERNAME' => $lang['Username'],
	'L_PASSWORD' => $lang['Password'],
	'L_LOGIN' => $lang['Login'],
	'L_TITLE' => $lang['Login'],
	'L_LOG_ME_IN' => $lang['Log_me_in'],
	'L_AUTO_LOGIN' => $lang['Log_me_in'],
	'L_LOGIN_LOGOUT' => $lang['Login'],
	
	'LOGIN_ERROR'		=> $err,
	'LOGIN_EXPLAIN'		=> $l_explain,
	
	'S_LOGIN_REDIRECT'		=> mx_build_hidden_fields(array('redirect' => $redirect_url)),
	'S_HIDDEN_FIELDS'		=> (isset($s_hidden_fields)) ? $s_hidden_fields : '',
));

$template->assign_block_vars('mode', array(
	//'REDIRECT_URL'	=> mx_redirect($redirect_url, true),
	//'SERVICE_NAME'	=> $mx_user->lang['PHPBB'],
	)
);

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

$template->pparse('phpbb_login');

?>