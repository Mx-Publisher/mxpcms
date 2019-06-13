<?php
/**
*
* @package MX-Publisher Core
* @version $Id: login.php,v 1.1 2014/05/18 06:26:59 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

if ($mx_request_vars->is_request('login') && (!$userdata['session_logged_in'] || $mx_request_vars->is_post('admin')) )
{
	$username = $mx_request_vars->is_post('username') ? phpBB2::phpbb_clean_username($mx_request_vars->post('username', MX_TYPE_NO_TAGS)) : '';
	$password = $mx_request_vars->post('password', MX_TYPE_NO_TAGS);
	// Set the randomly generated code.
	if (!isset($_SESSION['session_var']))
	{
		$_SESSION['session_value'] = md5(session_id() . mt_rand());
		$_SESSION['session_var'] = substr(preg_replace('~^\d+~', '', sha1(mt_rand() . session_id() . mt_rand())), 0, rand(7, 12));
	}
	$sc = isset($_SESSION['session_value']) ? $_SESSION['session_value'] : '';

	$sql = "SELECT *
		FROM " . USERS_TABLE . "
		WHERE member_name = '" . str_replace("\\'", "''", $username) . "'";

	if ( !($result = $db->sql_query($sql) ) )
	{
		mx_message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
	}

	if( $row = $db->sql_fetchrow($result) )
	{
		if( $row['id_group'] != ADMIN && $board_config['board_disable'] )
		{
			mx_redirect(mx_append_sid("index.$phpEx", false));

		}
		else
		{
			// If the last login is more than x minutes ago, then reset the login tries/time
			if (isset($_SESSION['failed_login']) && ($board_config['failed_login_threshold'] * 3 >= $_SESSION['failed_login']))
			{
				$db->sql_query('UPDATE ' . USERS_TABLE . ' SET last_login = 0 WHERE user_id = ' . $row['user_id']);
				// Reset the login threshold.					
				unset($_SESSION['failed_login']);					
			}
			
			// Check to see if user is allowed to login again... if his tries are exceeded			
			if (isset($_SESSION['failed_login']) && ($_SESSION['failed_login'] >= $board_config['failed_login_threshold'] * 3))
			{
				// Reset the login threshold.					
				mx_message_die(GENERAL_MESSAGE, sprintf($lang['Login_attempts_exceeded'], $board_config['max_login_attempts'], $board_config['login_reset_time']));				
			}

			// Figure out the password using SMF's encryption - if what they typed is right.
			/*
			if (isset($password) && strlen($password) == 40)
			{
				// Needs upgrading?
				if (strlen($user_settings['passwd']) != 40)
				{
				}			
			}
			*/
			
			// Challenge passed.
			if ($password == sha1($row['passwd'] . $sc) && $row['is_activated'])
			{			
				$sha_passwd = $row['passwd'];
				//if( md5($password) == $row['passwd'] && $row['user_active'] )
				//{
				$autologin = $mx_request_vars->is_post('autologin');
				
				$admin = $mx_request_vars->is_post('admin');
				$session_id = $mx_user->session_begin($row['user_id'], $user_ip, PAGE_INDEX, FALSE, $autologin, $admin);
				
				// Reset login tries
				$db->sql_query('UPDATE ' . USERS_TABLE . ' SET last_login = 0 WHERE user_id = ' . $row['user_id']);
				
				if($session_id)
				{
					$fromurl = ( !empty($HTTP_REFERER) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_REFERER)) : "index.$phpEx";
					$url = $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS);
					$url = ( !empty($url) ) ? str_replace('&amp;', '&', $url) : $fromurl;
					mx_redirect(mx3_append_sid($url, false, false, $session_id));
				}
				else
				{
					mx_message_die(CRITICAL_ERROR, "Couldn't start session : login", "", __LINE__, __FILE__);
				}
			}
			// Only store a failed login attempt for an active user - inactive users can't login even with a correct password
			elseif($row['is_activated'])
			{
				// Save login tries and last login
				if ($row['id_member'] != ANONYMOUS)
				{
					$sql = 'UPDATE ' . USERS_TABLE . '
						SET last_login = ' . time() . '
						WHERE id_member = ' . $row['id_member'];
					$db->sql_query($sql);
				}
				
				$redirect = $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS);
				if (!empty($redirect))
				{
					$redirect = str_replace('&amp;', '&', $redirect);
					$redirect = str_replace('?', '&', $redirect);
				}
				if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
				{
					mx_message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
				}
				
				$template->assign_vars(array(
					'META' => "<meta http-equiv=\"refresh\" content=\"3;url=login.$phpEx?redirect=$redirect\">")
				);

				$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.$phpEx?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . mx_append_sid("index.$phpEx") . '">', '</a>');
				mx_message_die(GENERAL_MESSAGE, $message);
			}
		}
	}
	else
	{
		$redirect = $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS);
		if (!empty($redirect))
		{
			$redirect = str_replace('&amp;', '&', $redirect);
			$redirect = str_replace('?', '&', $redirect);
		}

		if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
		{
			mx_message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
		}

		$template->assign_vars(array(
			'META' => "<meta http-equiv=\"refresh\" content=\"3;url=login.$phpEx?redirect=$redirect\">")
		);

		$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.$phpEx?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . mx_append_sid("index.$phpEx") . '">', '</a>');
		mx_message_die(GENERAL_MESSAGE, $message);
	}
}
else if ($mx_request_vars->is_request('logout') && $userdata['session_logged_in'] )
{
	// session id check
	if ($sid == '' || $sid != $userdata['session_id'])
	{
		mx_message_die(GENERAL_ERROR, 'Invalid_session');
	}

	if( $userdata['session_logged_in'] )
	{
		$mx_user->session_end($userdata['session_id'], $userdata['user_id']);
	}

	if (!$mx_request_vars->is_empty_request('redirect'))
	{
		$fromurl = ( !empty($HTTP_REFERER) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_REFERER)) : "index.$phpEx";
		$url = !$mx_request_vars->is_empty_post('redirect') ? str_replace('&amp;', '&', $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS)) : $fromurl;
		mx_redirect(mx3_append_sid($url, false, false, $session_id));
	}
	else
	{
		mx_redirect(mx_append_sid("index.$phpEx", false));
	}
}
else
{
	$url = !$mx_request_vars->is_empty_post('redirect') ? str_replace('&amp;', '&', $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS)) : "index.$phpEx";
	mx_redirect(mx_append_sid($url, false));
}
?>