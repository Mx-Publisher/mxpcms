<?php
/***************************************************************************
 *                              admin_users.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: admin_users.php,v 1.12 2013/06/25 18:24:07 orynider Exp $
 *
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

if ( !empty( $setmodules ) )
{
	$filename = basename( __FILE__ );
	return;
}
@define('IN_PORTAL', 1);
$mx_root_path = './../../../';
$module_root_path = "./../";
$phpEx = substr(strrchr(__FILE__, '.'), 1);

// **********************************************************************
// Includes
// **********************************************************************
require( $mx_root_path . '/admin/pagestart.' . $phpEx );

include_once( $mx_root_path . 'admin/page_header_admin.' . $phpEx );

// Read language definition
include($module_root_path . 'includes/users_constants.' . $phpEx);

$mx_cache->load_file('bbcode', 'phpbb2');
$mx_cache->load_file('functions_post', 'phpbb2');
$mx_cache->load_file('functions_selects', 'phpbb2');
$mx_cache->load_file('functions_validate', 'phpbb2');

$html_entities_match = array('#<#', '#>#');
$html_entities_replace = array('&lt;', '&gt;');

//
// Set mode
//
if ($mx_request_vars->is_request('mode'))
{
	$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS);
}
else
{
	$mode = '';
}

$action = !$mx_request_vars->is_empty_post('id') ? 'do_update' : 'do_add';

//
// Begin program
//
if ( $mode == 'edit' || $mode == 'add' || $mode == 'save' && $mx_request_vars->is_request('username'))
{
	//
	// Ok, the profile has been modified and submitted, let's update
	//
	if ($mode == 'save' && $mx_request_vars->is_post('submit') )
	{
		$user_id = $mx_request_vars->post('id', MX_TYPE_INT);

		$this_userdata = mx_get_userdata($user_id);

		if ($mode == 'edit' && !$this_userdata)
		{
			mx_message_die(GENERAL_MESSAGE, $lang['No_user_id_specified'] );
		}

		if ($mx_request_vars->is_post('deleteuser') && $userdata['user_id'] != $user_id)
		{
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'smf2':
				case 'mybb':
				case 'phpbb2':
					$sql = "SELECT g.group_id
						FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g
						WHERE ug.user_id = $user_id
							AND g.group_id = ug.group_id
							AND g.group_single_user = 1";
				break;
				
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
				default:
					$sql = "SELECT g.group_id
						FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g
						WHERE ug.user_id = $user_id
							AND g.group_id = ug.group_id
							AND g.group_name IN ('BOTS', 'GUESTS')";
				break;
			}
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not obtain group information for this user', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			if (PORTAL_BACKEND != 'internal')
			{
				$sql = "UPDATE " . POSTS_TABLE . "
					SET poster_id = " . DELETED . ", post_username = '" . str_replace("\\'", "''", addslashes($this_userdata['username'])) . "'
					WHERE poster_id = $user_id";
				if( !$db->sql_query($sql) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not update posts for this user', '', __LINE__, __FILE__, $sql);
				}

				$sql = "UPDATE " . TOPICS_TABLE . "
					SET topic_poster = " . DELETED . "
					WHERE topic_poster = $user_id";
				if( !$db->sql_query($sql) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not update topics for this user', '', __LINE__, __FILE__, $sql);
				}

				$sql = "UPDATE " . VOTE_USERS_TABLE . "
					SET vote_user_id = " . DELETED . "
					WHERE vote_user_id = $user_id";
				if( !$db->sql_query($sql) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not update votes for this user', '', __LINE__, __FILE__, $sql);
				}
			}

			$sql = "SELECT group_id
				FROM " . GROUPS_TABLE . "
				WHERE group_moderator = $user_id";
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not select groups where user was moderator', '', __LINE__, __FILE__, $sql);
			}

			while ( $row_group = $db->sql_fetchrow($result) )
			{
				$group_moderator[] = $row_group['group_id'];
			}

			if ( count($group_moderator) )
			{
				$update_moderator_id = implode(', ', $group_moderator);

				$sql = "UPDATE " . GROUPS_TABLE . "
					SET group_moderator = " . $userdata['user_id'] . "
					WHERE group_moderator IN ($update_moderator_id)";
				if( !$db->sql_query($sql) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not update group moderators', '', __LINE__, __FILE__, $sql);
				}
			}

			$sql = "DELETE FROM " . USERS_TABLE . "
				WHERE user_id = $user_id";
			if( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not delete user', '', __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . USER_GROUP_TABLE . "
				WHERE user_id = $user_id";
			if( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not delete user from user_group table', '', __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . GROUPS_TABLE . "
				WHERE group_id = " . $row['group_id'];
			if( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not delete group for this user', '', __LINE__, __FILE__, $sql);
			}

			if (PORTAL_BACKEND != 'internal')
			{
				$sql = "DELETE FROM " . AUTH_ACCESS_TABLE . "
					WHERE group_id = " . $row['group_id'];
				if( !$db->sql_query($sql) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not delete group for this user', '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
					WHERE user_id = $user_id";
				if ( !$db->sql_query($sql) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not delete user from topic watch table', '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE FROM " . BANLIST_TABLE . "
					WHERE ban_userid = $user_id";
				if ( !$db->sql_query($sql) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not delete user from banlist table', '', __LINE__, __FILE__, $sql);
				}
			}

			$sql = "DELETE FROM " . SESSIONS_TABLE . "
				WHERE session_user_id = $user_id";
			if ( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not delete sessions for this user', '', __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . SESSIONS_KEYS_TABLE . "
				WHERE user_id = $user_id";
			if ( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not delete auto-login keys for this user', '', __LINE__, __FILE__, $sql);
			}

			if (PORTAL_BACKEND != 'internal')
			{
				$sql = "SELECT privmsgs_id
					FROM " . PRIVMSGS_TABLE . "
					WHERE privmsgs_from_userid = $user_id
						OR privmsgs_to_userid = $user_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not select all users private messages', '', __LINE__, __FILE__, $sql);
				}

				// This little bit of code directly from the private messaging section.
				while ( $row_privmsgs = $db->sql_fetchrow($result) )
				{
					$mark_list[] = $row_privmsgs['privmsgs_id'];
				}

				if ( count($mark_list) )
				{
					$delete_sql_id = implode(', ', $mark_list);

					$delete_text_sql = "DELETE FROM " . PRIVMSGS_TEXT_TABLE . "
						WHERE privmsgs_text_id IN ($delete_sql_id)";
					$delete_sql = "DELETE FROM " . PRIVMSGS_TABLE . "
						WHERE privmsgs_id IN ($delete_sql_id)";

					if ( !$db->sql_query($delete_sql) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not delete private message info', '', __LINE__, __FILE__, $delete_sql);
					}

					if ( !$db->sql_query($delete_text_sql) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not delete private message text', '', __LINE__, __FILE__, $delete_text_sql);
					}
				}
			}

			$message = $lang['User_deleted'] . '<br /><br />' . sprintf($lang['Click_return_useradmin'], '<a href="' . mx_append_sid("admin_userlist.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . mx_append_sid("index.$phpEx?pane=right") . '">', '</a>');

			mx_message_die(GENERAL_MESSAGE, $message);
		}

		$username = mx_clean_username($mx_request_vars->post('username', MX_TYPE_NO_TAGS));
		$email = $mx_request_vars->post('email', MX_TYPE_NO_TAGS);

		$password = $mx_request_vars->post('password', MX_TYPE_NO_TAGS);
		$password_confirm = $mx_request_vars->post('password_confirm', MX_TYPE_NO_TAGS);
		
		// in phpBB2 passwords are used exactly as they were sent, with addslashes applied
		$password_old_format = addslashes($password);
		$password_new_format = $mx_request_vars->variable('password', '', true);
		
		$user_status = $mx_request_vars->post('user_status', MX_TYPE_INT, 0);
		$user_admin = $mx_request_vars->post('user_admin', MX_TYPE_INT, 0);

	}

	if ($mx_request_vars->is_post('submit'))
	{
		$error = FALSE;

		if (stripslashes($username) != $this_userdata['username'])
		{
			unset($rename_user);

			if ( stripslashes(strtolower($username)) != strtolower($this_userdata['username']) )
			{
				$result = validate_username($username);
				if ( $result['error'] )
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $result['error_msg'];
				}
				/*
				else if ( strtolower(str_replace("\\'", "''", $username)) == strtolower($userdata['username']))
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Username_taken'];
				}
				*/
			}

			if (!$error)
			{
				$username_sql = "username = '" . str_replace("\\'", "''", $username) . "', ";
				$username_sql_add = "'" . str_replace("\\'", "''", $username) . "'";
				$rename_user = $username; // Used for renaming usergroup
			}
		}

		$passwd_sql = '';
		if( !empty($password) && !empty($password_confirm) )
		{
			//
			// Awww, the user wants to change their password, isn't that cute..
			//
			if($password != $password_confirm)
			{
				$error = true;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
			}
			else
			{
				/**/
				switch ($portal_config['portal_backend'])
				{
					case 'internal':
					case 'smf2': 
					case 'mybb': 
						// These are the additional vars able to be specified
						$password = md5($password);
						$passwd_sql = "user_password = '$password', ";
						$passwd_sql_add = $password;
					break;

					case 'phpbb2':
						// These are the additional vars able to be specified
						$password = htmlspecialchars(stripslashes($password));
						$password = md5($password);
						$passwd_sql = "user_password = '$password', ";
						$passwd_sql_add = md5($password_old_format);
					break;

					case 'phpbb3': 
					case 'olympus': 
					case 'ascraeus':
					case 'rhea':
					case 'proteus':
					case 'phpbb4':
						// These are the additional vars able to be specified
						$password = md5($password);
						$passwd_sql = "user_password = '$password', ";
						$passwd_sql_add = $password;
					break;

				}
				/**/
			}
		}
		else if( $password && !$password_confirm )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
		}
		else if( !$password && $password_confirm )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
		}
		else if ( strlen($password) > 32 )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_long'];
		}
		else if( $action == 'do_add' ) // New user must have password
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
		}
		
		//
		// Update entry in DB
		//
		if( !$error )
		{
			$email_sql = "'" . str_replace("\'", "''", $email) . "'";

			if ($action == 'do_add')
			{
				$sql = "SELECT MAX(user_id) AS total
					FROM " . USERS_TABLE;
				if ( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not obtain next user_id information', '', __LINE__, __FILE__, $sql);
				}

				if ( !($row = $db->sql_fetchrow($result)) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not obtain next user_id information', '', __LINE__, __FILE__, $sql);
				}

				$user_id = $row['total'] + 1;

				/*
				$sql = "INSERT INTO " . USERS_TABLE . " (user_id, username, user_password, user_email, user_active, user_regdate, user_level)
					VALUES ($user_id, $username_sql_add, $passwd_sql_add, $email_sql, $user_status, '".time()."', $user_admin)";
				*/
				$username_sql_add = stripslashes($username);
				$email_sql = stripslashes($email);
				$sql_ary = array(
					'user_id'				=> $user_id,
					'username'			=> $username_sql_add,
					'user_active'			=> $user_status,
					'user_newpasswd'	=> '',
					'user_password'	=> (isset($passwd_sql_add)) ? $passwd_sql_add : '',
					'user_email'			=> strtolower($email_sql),
					'user_regdate'		=> time(),
				);

				if (isset($mx_user->data['username_clean']))
				{
					//print('<p><span style="color: red;"></span></p><i><p>Refreshing the users table!</p></i>');
					//$db_tools->sql_column_add(USERS_TABLE, 'username_clean', array('column_type_sql' => 'varchar(255)', 'null' => 'NOT NULL', 'default' => '', 'after' => 'username'), false);
					$sql_ary['username_clean']	= utf8_clean_string($username_sql_add);
				}

				if (isset($mx_user->data['user_level']))
				{
					//print('<p><span style="color: red;"></span></p><i><p>Refreshing the users table!</p></i>');
					//$db_tools->sql_column_add(USERS_TABLE, 'user_level', array('column_type_sql' => 'tinyint(2)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'user_level'), false);
					$sql_ary['user_level']	= $user_admin;
				}

				if (isset($mx_user->data['group_id']))
				{
					//print('<p><span style="color: red;"></span></p><i><p>Refreshing the users table!</p></i>');
					//$db_tools->sql_column_add(USERS_TABLE, 'group_id', array('column_type_sql' => 'tinyint(2)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'group_id'), false);
					if (($user_admin = 1) && ($user_status= 1))
					{
						$sql_ary['group_id'] = $mx_backend->get_group_id('ADMINISTRATORS');
					}
					
					if (($user_admin= 0) && ($user_status = 1))
					{
						$sql_ary['group_id'] = $mx_backend->get_group_id('REGISTERED');
					}
					
					if (($user_admin = 0) && ($user_status = 0))
					{
						$sql_ary['group_id'] = $mx_backend->get_group_id('REGISTERED_COPPA');
					}
				}

				if (isset($mx_user->data['user_type']))
				{
					//print('<p><span style="color: red;"></span></p><i><p>Refreshing the users table!</p></i>');
					//$db_tools->sql_column_add(USERS_TABLE, 'user_type', array('column_type_sql' => 'tinyint(2)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'user_id'), false);
					if (($user_admin = 1) && ($user_status= 1))
					{
						$sql_ary['user_type'] = 3;
					}
					
					if (($user_admin= 0) && ($user_status = 1))
					{
						$sql_ary['user_type'] = 0;
					}
					
					if (($user_admin = 0) && ($user_status = 0))
					{
						$sql_ary['user_type'] = 1; //or 2
					}
				}
				
				if (isset($mx_user->data['user_type']))
				{
					//print('<p><span style="color: red;"></span></p><i><p>Refreshing the users table!</p></i>'
					$sql_ary['user_email_hash']	= mx_email_hash($email_sql);
				}
				
				if (isset($mx_user->data['user_permissions']))
				{
					$sql_ary['user_permissions']	= '';
				}
				
				//Gost permisions
				if (isset($mx_user->data['user_perm_from']))
				{
					$sql_ary['user_perm_from'] = $mx_user->data['user_id'];
				}
				
				if (isset($mx_user->data['user_passchg']))
				{
					$sql_ary['user_passchg'] = time();
				}
				
				if (isset($mx_user->data['user_lastmark']))
				{
					$sql_ary['user_lastmark']	= time();
				}
				
				if (isset($mx_user->data['is_bot']))
				{
					$sql_ary['is_bot']	= 0;
				}
				
				if (isset($mx_user->data['is_mobile']))
				{
					$sql_ary['is_mobile']	= $mx_user->data['is_mobile'];
				}
				
				if (isset($mx_user->data['device_name']))
				{
					$sql_ary['device_name']	= $mx_user->data['device_name'];
				}
				
				if (isset($mx_user->data['user_inactive_reason']))
				{
					$sql_ary['user_inactive_reason']	= $mx_user->data['user_inactive_reason'];
				}
				
				if (isset($mx_user->data['user_inactive_time']))
				{
					$sql_ary['user_inactive_time']	= 0;
				}
				
				/* */
				switch ($portal_config['portal_backend'])
				{
					case 'internal':
					case 'smf2': 
					case 'mybb': 
						// These are the additional vars able to be specified
						$additional_vars = array(
							//phpbb2/'user_permissions'	=> '',
							//phpbb2/'user_timezone'		=> $board_config['board_timezone'],
							//phpbb2/'user_dateformat'	=> $board_config['default_dateformat'],
							//phpbb2/'user_lang'			=> $board_config['default_lang'],
							//phpbb2/'user_style'		=> (int) $board_config['default_style'],
							//phpbb2/'user_actkey'		=> '',
							//'user_ip'			=> $user_row['user_ip'],
							//'user_regdate'		=> time(),
							//'user_passchg'		=> time(),
							//'user_options'		=> 230271,
							// We do not set the new flag here - registration scripts need to specify it
							//'user_new'			=> 0,

							//'user_inactive_reason'	=> 0,
							//'user_inactive_time'	=> 0,
							//'user_lastmark'			=> time(),
							//'user_lastvisit'		=> 0,
							//phpbb3/'user_lastpost_time'	=> 0,
							//'user_lastpage'			=> '',
							//phpbb2/'user_posts'			=> 0,
							//'user_colour'			=> '',
							//phpbb2/'user_avatar'			=> '',
							//phpbb2/'user_avatar_type'		=> AVATAR_UPLOAD,
							//'user_avatar_width'		=> 0,
							//'user_avatar_height'	=> 0,
							//phpbb2/'user_new_privmsg'		=> 0,
							//phpbb2/'user_unread_privmsg'	=> 0,
							//phpbb2/'user_last_privmsg'		=> 0,
							//phpbb3/'user_message_rules'	=> 0,
							//phpbb3/'user_full_folder'		=> PRIVMSGS_NO_BOX,
							//phpbb2/'user_emailtime'		=> 0,

							//phpbb2/'user_notify'			=> 0,
							//phpbb2/'user_notify_pm'		=> 1,
							//phpbb3/'user_notify_type'		=> NOTIFY_EMAIL,
							//phpbb2/'user_allow_pm'			=> 1,
							//'user_allow_viewonline'	=> 1,
							//phpbb2/'user_allow_viewemail'	=> 1,
							//'user_allow_massemail'	=> 1,

							//'user_sig'					=> '',
							//'user_sig_bbcode_uid'		=> '',
							//'user_sig_bbcode_bitfield'	=> '1111111111111',

							//'user_form_salt'			=> mx_unique_id(),
						);
					break;

					case 'phpbb2':
						// These are the additional vars able to be specified
						$additional_vars = array(
							//phpbb2/'user_permissions'	=> '',
							//phpbb2/'user_timezone'		=> $board_config['board_timezone'],
							//phpbb2/'user_dateformat'	=> $board_config['default_dateformat'],
							//phpbb2/'user_lang'			=> $board_config['default_lang'],
							//phpbb2/'user_style'		=> (int) $board_config['default_style'],
							//phpbb2/'user_actkey'		=> '',
							//'user_ip'			=> $user_row['user_ip'],
							//'user_regdate'		=> time(),
							//'user_passchg'		=> time(),
							//'user_options'		=> 230271,
							// We do not set the new flag here - registration scripts need to specify it
							//'user_new'			=> 0,

							//'user_inactive_reason'	=> 0,
							//'user_inactive_time'	=> 0,
							//'user_lastmark'			=> time(),
							//'user_lastvisit'		=> 0,
							//phpbb3/'user_lastpost_time'	=> 0,
							//'user_lastpage'			=> '',
							//phpbb2/'user_posts'			=> 0,
							//'user_colour'			=> '',
							//phpbb2/'user_avatar'			=> '',
							//phpbb2/'user_avatar_type'		=> AVATAR_UPLOAD,
							//'user_avatar_width'		=> 0,
							//'user_avatar_height'	=> 0,
							//phpbb2/'user_new_privmsg'		=> 0,
							//phpbb2/'user_unread_privmsg'	=> 0,
							//phpbb2/'user_last_privmsg'		=> 0,
							//phpbb3/'user_message_rules'	=> 0,
							//phpbb3/'user_full_folder'		=> PRIVMSGS_NO_BOX,
							//phpbb2/'user_emailtime'		=> 0,

							//phpbb2/'user_notify'			=> 0,
							//phpbb2/'user_notify_pm'		=> 1,
							//phpbb3/'user_notify_type'		=> NOTIFY_EMAIL,
							//phpbb2/'user_allow_pm'			=> 1,
							//'user_allow_viewonline'	=> 1,
							//phpbb2/'user_allow_viewemail'	=> 1,
							//'user_allow_massemail'	=> 1,

							//'user_sig'					=> '',
							//'user_sig_bbcode_uid'		=> '',
							//'user_sig_bbcode_bitfield'	=> '1111111111111',

							//'user_form_salt'			=> mx_unique_id(),
						);
					break;

					case 'phpbb3': 
					case 'olympus': 
					case 'ascraeus':
					case 'rhea':
					case 'proteus':
					case 'phpbb4':
						// These are the additional vars able to be specified
						$additional_vars = array(
							//phpbb2/'user_permissions'	=> '',
							//phpbb2/'user_timezone'		=> $board_config['board_timezone'],
							//phpbb2/'user_dateformat'	=> $board_config['default_dateformat'],
							//phpbb2/'user_lang'			=> $board_config['default_lang'],
							//phpbb2/'user_style'		=> (int) $board_config['default_style'],
							//phpbb2/'user_actkey'		=> '',
							'user_ip'			=> $user_row['user_ip'],
							'user_regdate'		=> time(),
							'user_passchg'		=> time(),
							'user_options'		=> 230271,
							// We do not set the new flag here - registration scripts need to specify it
							'user_new'			=> 0,

							'user_inactive_reason'	=> 0,
							'user_inactive_time'	=> 0,
							'user_lastmark'			=> time(),
							'user_lastvisit'		=> 0,
							//phpbb3/'user_lastpost_time'	=> 0,
							'user_lastpage'			=> '',
							//phpbb2/'user_posts'			=> 0,
							'user_colour'			=> '',
							//phpbb2/'user_avatar'			=> '',
							//phpbb2/'user_avatar_type'		=> AVATAR_UPLOAD,
							'user_avatar_width'		=> 0,
							'user_avatar_height'	=> 0,
							//phpbb2/'user_new_privmsg'		=> 0,
							//phpbb2/'user_unread_privmsg'	=> 0,
							//phpbb2/'user_last_privmsg'		=> 0,
							//phpbb3/'user_message_rules'	=> 0,
							//phpbb3/'user_full_folder'		=> PRIVMSGS_NO_BOX,
							//phpbb2/'user_emailtime'		=> 0,

							//phpbb2/'user_notify'			=> 0,
							//phpbb2/'user_notify_pm'		=> 1,
							//phpbb3/'user_notify_type'		=> NOTIFY_EMAIL,
							//phpbb2/'user_allow_pm'			=> 1,
							'user_allow_viewonline'	=> 1,
							//phpbb2/'user_allow_viewemail'	=> 1,
							'user_allow_massemail'	=> 1,

							'user_sig'					=> '',
							'user_sig_bbcode_uid'		=> '',
							'user_sig_bbcode_bitfield'	=> '1111111111111',

							'user_form_salt'			=> mx_unique_id(),
						);
					break;

				}
				/**/

				// Now fill the sql array with not required variables
				foreach ($additional_vars as $key => $default_value)
				{
					$sql_ary[$key] = (isset($user_row[$key])) ? $user_row[$key] : $default_value;
				}

				// Any additional variables in $user_row not covered above?
				$remaining_vars = array_diff(array_keys($user_row), array_keys($sql_ary));

				// Now fill our sql array with the remaining vars
				if (count($remaining_vars))
				{
					foreach ($remaining_vars as $key)
					{
						$sql_ary[$key] = $user_row[$key];
					}
				}

				$sql = 'INSERT INTO ' . USERS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				if ( !($result = $db->sql_query($sql)) )
				{
					$sql_error = $db->sql_error('');
					mx_message_die(CRITICAL_ERROR, 'Could not update user info', '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'] . ' <br />' . $sql, __LINE__, __FILE__, $sql);
				}

//user_type
			}
			else
			{
				
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'smf2':
					case 'mybb':
					case 'phpbb2':
							@define('DELETED', -1);
							@define('ANONYMOUS', -1);

							@define('USER', 0);
							@define('ADMIN', 1);
							@define('MOD', 2);

							// User related
							@define('USER_ACTIVATION_NONE', 0);
							@define('USER_ACTIVATION_SELF', 1);
							@define('USER_ACTIVATION_ADMIN', 2);
						
						/* * /
						$sql = "UPDATE " . USERS_TABLE . "
							SET " . $username_sql . $passwd_sql . "user_email = $email_sql, user_active = $user_status, user_level = $user_admin" . "
							WHERE user_id = $user_id";
						/* */
						
						$sql_ary = array(
							'username' 				=> str_replace("\\'", "''", $username),
							'user_password'		=> $password, //'user_newpasswd'	=> $user_row['user_newpasswd'],
							'user_email' 			=> $email_sql,
							'user_active' 			=> $user_status,
							'user_level' 				=> ($user_admin == 1) ? ADMIN : USER,
							'user_login_tries' 		=> 0,
						);
						
					break;
					
					case 'phpbb3':
					case 'olympus':
					case 'ascraeus':
					case 'rhea':
						
						@define('USER_ACTIVATION_NONE', 0);
						@define('USER_ACTIVATION_SELF', 1);
						@define('USER_ACTIVATION_ADMIN', 2);
						@define('USER_ACTIVATION_DISABLE', 3);

						@define('USER_NORMAL', 0);
						@define('USER_INACTIVE', 1);
						@define('USER_IGNORE', 2);
						@define('USER_FOUNDER', 3);

						@define('INACTIVE_REGISTER', 1);
						@define('INACTIVE_PROFILE', 2);
						@define('INACTIVE_MANUAL', 3);
						@define('INACTIVE_REMIND', 4);
						
						$user_type = ($user_admin == 1) ? USER_FOUNDER : ( ($user_status = 1) ? USER_NORMAL : USER_INACTIVE);
						
						$sql_ary = array(
							'username' 				=> str_replace("\\'", "''", $username),
							'user_password'		=> $db->sql_escape(phpBB3::phpbb_hash($password)),
							'user_newpasswd'		=> '',
							'user_type' 				=> $user_type,
							'user_email' 			=> $email_sql,
							'user_login_attempts'	=> 0,
						);
					break;
				}

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE user_id = ' . $user_id;
				$db->sql_query($sql);
				/* * /
				$phpbb_log->add('user', $mx_user->data['user_id'], $user->ip, 'LOG_USER_NEW_PASSWORD', false, array(
					'reportee_id' => $user_row['user_id'],
					$user_row['username']
				));
				/* */
			}

			if( $result = $db->sql_query($sql) )
			{
				if ($action == 'do_update')
				{
					if( isset($rename_user) )
					{
						$sql = "UPDATE " . GROUPS_TABLE . "
							SET group_name = '".str_replace("\'", "''", $rename_user)."'
							WHERE group_name = '".str_replace("'", "''", $this_userdata['username'] )."'";
						if( !$result = $db->sql_query($sql) )
						{
							mx_message_die(GENERAL_ERROR, 'Could not rename users group', '', __LINE__, __FILE__, $sql);
						}
					}

					// Delete user session, to prevent the user navigating the forum (if logged in) when disabled
					if (!$user_status)
					{
						$sql = "DELETE FROM " . SESSIONS_TABLE . "
							WHERE session_user_id = " . $user_id;

						if ( !$db->sql_query($sql) )
						{
							mx_message_die(GENERAL_ERROR, 'Error removing user session', '', __LINE__, __FILE__, $sql);
						}
					}

					// We remove all stored login keys since the password has been updated
					// and change the current one (if applicable)
					if ( !empty($passwd_sql) )
					{
						//$mx_user->session_reset_keys($user_id, $user_ip);
					}
				}

				$message .= $action == 'do_update'? $lang['Admin_user_updated'] : $lang['Admin_user_added'];
			}
			else
			{
				mx_message_die(GENERAL_ERROR, 'Admin_user_fail', '', __LINE__, __FILE__, $sql);
			}

			$message .= '<br /><br />' . sprintf($lang['Click_return_useradmin'], '<a href="' . mx_append_sid("admin_userlist.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . mx_append_sid("index.$phpEx?pane=right") . '">', '</a>');

			mx_message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$template->set_filenames(array(
				'reg_header' => 'error_body.tpl')
			);

			$template->assign_vars(array(
				'ERROR_MESSAGE' => $error_msg)
			);

			$template->assign_var_from_handle('ERROR_BOX', 'reg_header');

			$username = htmlspecialchars(stripslashes($username));
			$email = stripslashes($email);
			$password = '';
			$password_confirm = '';
		}
	}
	//
	// SHOW USER / NEW USER
	//
	else if ( !$mx_request_vars->post('submit') && $mode != 'save' )
	{
		if ($mode == 'edit')
		{
			if ($mx_request_vars->is_request(POST_USERS_URL))
			{
				$user_id = $mx_request_vars->request(POST_USERS_URL, MX_TYPE_INT);
				$this_userdata = mx_get_userdata($user_id);
				if( !$this_userdata )
				{
					mx_message_die(GENERAL_MESSAGE, $lang['No_user_id_specified'] );
				}
			}
			else
			{
				$this_userdata = mx_get_userdata($mx_request_vars->get('username', MX_TYPE_NO_TAGS), true);
				if( !$this_userdata )
				{
					mx_message_die(GENERAL_MESSAGE, $lang['No_user_id_specified'] );
				}
			}
		}
		else
		{
			$this_userdata['user_id'] = '' ;
			$this_userdata['username'] = '' ;
			$this_userdata['user_email'] = 'me@' . $board_config['server_name'];
			$this_userdata['user_active'] = '1' ;
		}

		//
		// Now parse and display it as a template
		//
		$user_id = $this_userdata['user_id'];
		$username = $this_userdata['username'];
		$email = $this_userdata['user_email'];
		$password = '';
		$password_confirm = '';
		$user_status = isset($this_userdata['user_active']) ? $this_userdata['user_active'] : $this_userdata['user_type'];
		$user_admin = isset($this_userdata['user_level']) ? $this_userdata['user_level'] : (isset($this_userdata['user_type']) ? $this_userdata['user_type'] : false);
		$user_type = isset($this_userdata['user_type']) ? $this_userdata['user_type'] : (($user_admin == 1) ? USER_FOUNDER : ( ($user_status = 1) ? USER_NORMAL : USER_INACTIVE));
	}

	$coppa = ( ( !isset($_POST['coppa']) && !isset($_GET['coppa']) ) || $mode == "register") ? 0 : TRUE;

	$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="agreed" value="true" /><input type="hidden" name="coppa" value="' . $coppa . '" />';
	$s_hidden_fields .= '<input type="hidden" name="id" value="' . $user_id . '" />';

	$template->set_filenames(array(
		"body" => "admin/user_edit_body.tpl")
	);

	$template->assign_vars(array(
		'USERNAME' => $username,
		'EMAIL' => $email,
		'USER_ACTIVE_YES' => ($user_status) ? 'checked="checked"' : '',
		'USER_ACTIVE_NO' => (!$user_status) ? 'checked="checked"' : '',
		'USER_ADMIN_YES' => ($user_admin) ? 'checked="checked"' : '',
		'USER_ADMIN_NO' => (!$user_admin) ? 'checked="checked"' : '',

		'L_USERNAME' => $lang['Username'],
		'L_USER_TITLE' => $lang['User_admin'],
		'L_USER_EXPLAIN' => $lang['User_admin_explain'],
		'L_NEW_PASSWORD' => $lang['New_password'],
		'L_PASSWORD_IF_CHANGED' => $lang['password_if_changed'],
		'L_CONFIRM_PASSWORD' => $lang['Confirm_password'],
		'L_PASSWORD_CONFIRM_IF_CHANGED' => $lang['password_confirm_if_changed'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],
		'L_YES' => $lang['Yes'],
		'L_NO' => $lang['No'],

		'L_SPECIAL' => $lang['User_special'],
		'L_SPECIAL_EXPLAIN' => $lang['User_special_explain'],
		'L_USER_ACTIVE' => $lang['User_status'],
		'L_USER_ADMIN' => $lang['MX_user_is_admin'],

		'L_EMAIL_ADDRESS' => $lang['Email_address'],

		'L_DELETE_USER' => $lang['User_delete'],
		'L_DELETE_USER_EXPLAIN' => $lang['User_delete_explain'],
		'L_SELECT_RANK' => $lang['Rank_title'],

		'S_HIDDEN_FIELDS' => $s_hidden_fields,
		'S_PROFILE_ACTION' => mx_append_sid("admin_users.$phpEx"))
	);

	$template->pparse('body');
}
else
{
	//
	// Default user selection box
	//
	$template->set_filenames(array(
		'body' => 'admin/user_select_body.tpl')
	);

	$template->assign_vars(array(
		'L_USER_TITLE' => $lang['User_admin'],
		'L_USER_EXPLAIN' => $lang['User_admin_explain'],
		'L_USER_SELECT' => $lang['Select_a_User'],
		'L_LOOK_UP' => $lang['Look_up_user'],
		'L_FIND_USERNAME' => $lang['Find_username'],

		'U_SEARCH_USER' => mx_append_sid("./../search.$phpEx?mode=searchuser"),

		'S_USER_ACTION' => mx_append_sid("admin_users.$phpEx"),
		'S_USER_SELECT' => $select_list)
	);
	$template->pparse('body');

}

include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );

?>