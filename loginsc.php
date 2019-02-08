<?php
/**
*
* @package MX-Publisher Core
* @version $Id: login.php,v 1.35 2014/05/16 18:02:06 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

//
// Allow people to reach login page if
// board is shut down
//
define("IN_LOGIN", true);
define('IN_PHPBB', true);
define('IN_SOCIAL_CONNECT', true);

$mx_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
if (!defined('PHP_EXT')) define('PHP_EXT', $phpEx);
define('CMS_PAGE_HOME', 'index.' . PHP_EXT);

//phpBB Stuff
define('PHPBB_PAGE_ERRORS', $mx_root_path . 'errors.' . $phpEx);
define('PHPBB_PAGE_FORUM', $phpbb_root_path . 'viewforum.' . $phpEx);
define('PHPBB_PAGE_LOGIN', ((PORTAL_BACKEND !== 'internal') ? $phpbb_root_path : $mx_root_path) . 'login.' . $phpEx);
define('PHPBB_PAGE_PROFILE', $phpbb_root_path . 'profile.' . $phpEx);
define('LOGIN_REDIRECT_PAGE', $mx_root_path . 'index.' . $phpEx);

//Common
include($mx_root_path . 'common.'.$phpEx);

//Temporary Social Connect Code
//This has to be added in the database
$board_config['enable_social_connect'] = IN_SOCIAL_CONNECT;

$board_config['enable_facebook_login'] = IN_SOCIAL_CONNECT;
$board_config['facebook_app_id'] = '1923638584362290';
$board_config['facebook_app_secret'] = '93613186a2da77f4e2fec0a1b527f4c70';

$board_config['enable_google_login'] = IN_SOCIAL_CONNECT;
$board_config['google_app_id'] = '0000000000000000000000';
$board_config['google_app_secret'] = '000000000000000000000';

$board_config['enable_twitter_login'] = IN_SOCIAL_CONNECT;
$board_config['twitter_app_id'] = '0000000000000000000000';
$board_config['twitter_app_secret'] = '000000000000000000000';
//Temporary Social Connect Code

//
// Page selector
//
$page_id = $mx_request_vars->request('page', MX_TYPE_INT, 1);

//
// Start session, user and style (template + theme) management
// - populate $userdata, $lang, $theme, $images and initiate $template.
//
$mx_user->init($user_ip, PAGE_LOGIN);

//
// Load and instatiate CORE (page) and block classes
//
$mx_page->init( $page_id );

//
// Initiate user style (template + theme) management
// - populate $theme, $images and initiate $template.
//
$mx_user->init_style();

// session id check
if (!$mx_request_vars->is_empty_request('sid'))
{
	$sid = $mx_request_vars->request('sid', MX_TYPE_NO_TAGS);
}
else
{
	$sid = '';
}

$redirect = $mx_request_vars->request('redirect', MX_TYPE_NO_TAGS);
$redirect_url = (!empty($redirect) ? urldecode(str_replace(array('&amp;', '?', PHP_EXT . '&'), array('&', '&', PHP_EXT . '?'), $redirect)) : CMS_PAGE_HOME);

if (strstr($redirect_url, "\n") || strstr($redirect_url, "\r") || strstr($redirect_url, ';url'))
{
	mx_message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
}

if($mx_request_vars->is_request('login') || $mx_request_vars->is_request('logout'))
{
	include($mx_root_path . 'includes/sessions/'.PORTAL_BACKEND.'/login.'.$phpEx);
}
else
{
	//
	// Do a full login page dohickey if
	// user not already logged in
	//
	if( !$userdata['session_logged_in'] || ($mx_request_vars->is_get('admin') && $userdata['session_logged_in'] && $userdata['user_level'] == ADMIN))
	{
		$mx_page->page_title = $lang['Login'];
		include($mx_root_path . 'includes/page_header.'.$phpEx);

		$layouttemplate->set_filenames(array(
			"login_body" => "login_body.$tplEx")
		);

		$forward_page = '';

		if ($mx_request_vars->is_request('redirect'))
		{
			$forward_to = $_SERVER['QUERY_STRING'];

			if( preg_match("/^redirect=([a-z0-9\.#\/\?&=\+\-_]+)/si", $forward_to, $forward_matches) )
			{
				$forward_to = ( !empty($forward_matches[3]) ) ? $forward_matches[3] : $forward_matches[1];
				$forward_match = explode('&', $forward_to);

				if(count($forward_match) > 1)
				{
					for($i = 1; $i < count($forward_match); $i++)
					{
						if(!preg_match('#sid=#', $forward_match[$i]))
						{
							if( $forward_page != '' )
							{
								$forward_page .= '&';
							}
							$forward_page .= $forward_match[$i];
						}
					}
					$forward_page = $forward_match[0] . '?' . $forward_page;
				}
				else
				{
					$forward_page = $forward_match[0];
				}
			}
		}

		$username = ( $userdata['user_id'] != ANONYMOUS ) ? $userdata['username'] : '';

		$s_hidden_fields = '<input type="hidden" name="redirect" value="' . $forward_page . '" />';
		$s_hidden_fields .= $mx_request_vars->is_get('admin') ? '<input type="hidden" name="admin" value="1" />' : '';

		//mx_make_jumpbox($phpbb_root_path . 'viewforum.'.$phpEx);

		$layouttemplate->assign_vars(array(
			'USERNAME' => $username,

			'L_ENTER_PASSWORD' => $mx_request_vars->is_get('admin') ? $lang['Admin_reauthenticate'] : $lang['Enter_password'],
			'L_SEND_PASSWORD' => PORTAL_BACKEND != 'internal' ? $lang['Forgotten_password'] : '',

			//'U_SEND_PASSWORD' => mx3_append_sid($phpbb_root_path . "profile.$phpEx", "mode=sendpassword"),

			'S_HIDDEN_FIELDS' => $s_hidden_fields)
		);

		ob_start();
		$layouttemplate->pparse('login_body');		
		$phpbb_output = ob_get_contents();
		ob_end_clean();
		$phpbb_output = str_replace('"templates/'.$theme['template_name'], '"' . $phpbb_root_path . 'templates/'.$theme['template_name'], $phpbb_output);
		echo($phpbb_output);
		unset($phpbb_output);

		include($mx_root_path . 'includes/page_tail.'.$phpEx);	
	}
	else
	{
		mx_redirect(mx_append_sid("index.$phpEx", false));
	}
}

?>