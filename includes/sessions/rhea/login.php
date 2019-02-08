<?php
/**
*
* @package MX-Publisher Core
* @version $Id: login.php,v 1.1 2014/07/07 20:38:12 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

if($mx_request_vars->is_request('login') && ($userdata['user_id'] == ANONYMOUS || $mx_request_vars->is_post('admin')) )
{
	$username = utf8_clean_string($mx_request_vars->post('username', MX_TYPE_NO_TAGS, ''));
	$password = $mx_request_vars->post('password', MX_TYPE_NO_TAGS);
	$viewonline = $mx_request_vars->post('viewonline', MX_TYPE_INT, 0);

	$sql = "SELECT *
		FROM " . USERS_TABLE . "
		WHERE username = '" . str_replace("\\'", "''", $username) . "'
		OR username_clean = '" . str_replace("\\'", "''", $username) . "'";

	if ( !($result = $db->sql_query($sql) ) )
	{
		mx_message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
	}

	if( $row = $db->sql_fetchrow($result) )
	{
		//$user_type = $row['user_level']; // phpBB2
		$user_type = $row['user_type']; // phpBB3

		if( $user_type != ADMIN && $board_config['board_disable'] )
		{
			mx_redirect(mx3_append_sid("index.$phpEx", false));
		}
		else
		{
			$user_login_attempts = $row['user_login_attempts'];

			if ( $user_login_attempts && $board_config['login_reset_time'] )
			{
				$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_login_attempts = 0 WHERE user_id = ' . $row['user_id']);
				$row['user_last_login_try'] = $row['user_login_tries'] = 0;
			}

			// Check to see if user is allowed to login again... if his tries are exceeded
			if ($user_login_attempts && $board_config['login_reset_time'] && $board_config['max_login_attempts'] && $user_login_attempts >= $board_config['max_login_attempts'] && $userdata['user_level'] != ADMIN)
			{
				mx_message_die(GENERAL_MESSAGE, sprintf($lang['Login_attempts_exceeded'], $board_config['max_login_attempts'], $board_config['login_reset_time']));
			}

			// If the password convert flag is set we need to convert it
			if ($row['user_pass_convert'])
			{
				// in phpBB2 passwords were used exactly as they were sent, with addslashes applied
				$password_old_format = isset($_REQUEST['password']) ? $_REQUEST['password'] : $password;
				$password_old_format = (!STRIP) ? addslashes($password_old_format) : $password_old_format;
				$password_new_format = '';

				phpBB3::set_var($password_new_format, stripslashes($password_old_format), 'string');

				//mx_message_die(CRITICAL_ERROR, "Couldn't start session : login", $password_new_format, '');

				if ($password == $password_new_format)
				{
					if (!function_exists('utf8_to_cp1252'))
					{
						global $mx_root_path, $phpEx;
						include_once($mx_root_path . 'includes/utf/data/recode_basic.' . $phpEx);
					}

					// cp1252 is phpBB2's default encoding, characters outside ASCII range might work when converted into that encoding
					if (md5($password_old_format) == $row['user_password'] || md5(utf8_to_cp1252($password_old_format)) == $row['user_password'])
					{
						$hash = phpBB3::phpbb_hash($password_new_format);

						// Update the password in the users table to the new format and remove user_pass_convert flag
						$sql = 'UPDATE ' . USERS_TABLE . '
							SET user_password = \'' . $db->sql_escape($hash) . '\',
								user_pass_convert = 0
							WHERE user_id = ' . $row['user_id'];
						$db->sql_query($sql);

						$row['user_pass_convert'] = 0;
						$row['user_password'] = $hash;
					}
					else
					{
						// Although we weren't able to convert this password we have to
						// increase login attempt count to make sure this cannot be exploited
						$sql = 'UPDATE ' . USERS_TABLE . '
							SET user_login_attempts = user_login_attempts + 1
							WHERE user_id = ' . $row['user_id'];
						$db->sql_query($sql);
						mx_message_die(GENERAL_MESSAGE, 'We are sorry but password convertion failed, please login direct in forums or rewuest a new activation link.');
						return array(
							'status'		=> LOGIN_ERROR_PASSWORD_CONVERT,
							'error_msg'		=> 'LOGIN_ERROR_PASSWORD_CONVERT',
							'user_row'		=> $row,
						);
					}
				}
			}
			else
			{
				// in phpBB2 passwords were used exactly as they were sent, with addslashes applied
				$password_old_format = isset($_REQUEST['password']) ? $_REQUEST['password'] : $password;
				$password_old_format = (!STRIP) ? addslashes($password_old_format) : $password_old_format;
				$password_new_format = '';
				phpBB3::set_var($password_new_format, stripslashes($password_old_format), 'string');
				//mx_message_die(CRITICAL_ERROR, "Couldn't start session : login", $password_new_format, '');

				if ($password_new_format == $password_old_format)
				{
					if (!function_exists('utf8_to_cp1252'))
					{
							global $mx_root_path, $phpEx;
							include_once($mx_root_path . 'includes/utf/data/recode_basic.' . $phpEx);
					}

					// cp1252 is phpBB2's default encoding, characters outside ASCII range might work when converted into that encoding
					if (md5($password_old_format) == $row['user_password'] || md5($password) == $row['user_password'] || phpBB3::phpbb_check_hash($password, $row['user_password']))
					{
						$autologin = $mx_request_vars->is_post('autologin');
						$admin = $mx_request_vars->is_post('admin');
						$mx_user->session_create($row['user_id'], $admin, $autologin, $viewonline = true);
						$session_id = $mx_user->session_id;


						// Reset login tries
						//$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_login_tries = 0, user_last_login_try = 0 WHERE user_id = ' . $row['user_id']); // phpBB2
						$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_login_attempts = 0 WHERE user_id = ' . $row['user_id']); // phpBB3

						if( $session_id )
						{
							$fromurl = ( !empty($HTTP_REFERER) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_REFERER)) : "index.$phpEx";
							$url = !$mx_request_vars->is_empty_post('redirect') ? str_replace('&amp;', '&', $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS)) : $fromurl;
							mx_redirect(mx3_append_sid($url, false, false, $session_id));
						}
						else
						{
							mx_message_die(CRITICAL_ERROR, "Couldn't start session : login", "", __LINE__, __FILE__);
						}
					}
					else
					{
						// Although we weren't able to convert this password we have to
						// increase login attempt count to make sure this cannot be exploited
						$sql = '	UPDATE ' . USERS_TABLE . '
							SET user_login_attempts = user_login_attempts + 1
							WHERE user_id = ' . $row['user_id'];
						$db->sql_query($sql);

						$redirect = !$mx_request_vars->is_empty_post('redirect') ? str_replace('&amp;', '&', $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS)) : '';
						$redirect = str_replace('?', '&', $redirect);

						if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
						{
							mx_message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
						}

						$template->assign_vars(array(
							'META' => "<meta http-equiv=\"refresh\" content=\"3;url=login.$phpEx?redirect=$redirect\">")
						);

						$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.$phpEx?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . mx3_append_sid("index.$phpEx") . '">', '</a>');

						mx_message_die(GENERAL_MESSAGE, $message);
					}
				}
				// Check password ...
				if (!$row['user_pass_convert'] && phpBB3::phpbb_check_hash($password, $row['user_password']))
				{
					if ($row['user_login_attempts'] != 0)
					{
						// Successful, reset login attempts (the user passed all stages)
						$sql = 'UPDATE ' . USERS_TABLE . '
							SET user_login_attempts = 0
							WHERE user_id = ' . $row['user_id'];
						$db->sql_query($sql);
					}

					// User inactive...
					if ($row['user_type'] == USER_INACTIVE || $row['user_type'] == USER_IGNORE)
					{
						mx_message_die(GENERAL_MESSAGE, 'Inactive User');
					}

					// Successful login... set user_login_attempts to zero...
					if( $session_id )
					{
						$url = !$mx_request_vars->is_empty_post('redirect') ? str_replace('&amp;', '&', $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS)) : "index.$phpEx";
						mx_redirect(mx3_append_sid($url, false));
					}
					else
					{
						mx_message_die(CRITICAL_ERROR, "Couldn't start session : login", "", __LINE__, __FILE__);
					}
				}
			}
		}
	}
	else
	{
		$redirect = !$mx_request_vars->is_empty_post('redirect') ? str_replace('&amp;', '&', $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS)) : '';
		$redirect = str_replace("?", "&", $redirect);

		if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
		{
			mx_message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
		}

		$template->assign_vars(array(
			'META' => "<meta http-equiv=\"refresh\" content=\"3;url=login.$phpEx?redirect=$redirect\">")
		);

		$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.$phpEx?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . mx3_append_sid("index.$phpEx") . '">', '</a>');
		mx_message_die(GENERAL_MESSAGE, $message);
	}
}
else if ($mx_request_vars->is_request('logout') && $userdata['session_logged_in'] )
{
	// session id check
	if ($sid == '' || $sid != $userdata['session_id'])
	{
		mx_message_die(GENERAL_ERROR, 'Invalid_session' . $userdata['session_id']);
	}

	if( $userdata['session_logged_in'] )
	{
		$mx_user->session_kill();
	}

	if (!$mx_request_vars->is_empty_request('redirect'))
	{
		$url = $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS);
		$url = str_replace('&amp;', '&', $url);
		mx_redirect(mx3_append_sid($url, false));
	}
	else
	{
		mx_redirect(mx3_append_sid("index.$phpEx", false));
	}
}
else
{
	$url = !$mx_request_vars->is_empty_post('redirect') ? str_replace('&amp;', '&', $mx_request_vars->post('redirect', MX_TYPE_NO_TAGS)) : "index.$phpEx";
	mx_redirect(mx3_append_sid($url, false));
}
?>