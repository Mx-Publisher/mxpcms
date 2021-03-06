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
define('IN_LOGIN', true);

define('IN_PORTAL', true);
$mx_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($mx_root_path . 'common.'.$phpEx);

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