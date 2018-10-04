<?php
/**
*
* @package MX-Publisher Module - mx_users
* @version $Id: admin_prune_users.php,v 1.4 2008/09/30 07:04:54 orynider Exp $
* @copyright (c) 2002-2008 [Omar Ramadan, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

define( 'IN_PORTAL', true );

if ( !empty( $setmodules ) )
{
	if (PORTAL_BACKEND == 'phpbb2')
	{
		$filename = basename( __FILE__ );
		$module['phpbb2admin']['3_Prune_Inactive_Users'] = 'modules/mx_users/admin/' . $filename;
	}
	return;
}

$mx_root_path = './../../../';
$module_root_path = "./../";
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require( $mx_root_path . '/admin/pagestart.' . $phpEx );

include_once( $mx_root_path . 'admin/page_header_admin.' . $phpEx );

// **********************************************************************
// Read language definition
// **********************************************************************
if ( !file_exists( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx ) )
{
	include( $module_root_path . 'language/lang_english/lang_admin.' . $phpEx );
}
else
{
	include( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx );
}

	if ($mx_request_vars->is_post('submit'))
	{
		foreach ( $_POST['inactive_users'] as $user_id )
		{
			$user_id = str_replace("\'", "''",  $user_id );

			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'phpbb2':
					$sql = "SELECT g.group_id
							FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g
							WHERE ug.user_id = $user_id
								AND g.group_id = ug.group_id
								AND g.group_single_user = 1";
					break;
				case 'phpbb3':
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

				$sql = "UPDATE " . POSTS_TABLE . "
					SET poster_id = " . DELETED . ", post_username = '" . str_replace("\\'", "''", str_replace("\'", "''", $this_userdata['username'])) . "'
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

		$message = $lang['User_deleted'] . '<br /><br />' . sprintf($lang['Click_return_userprune'], '<a href="' . mx_append_sid("admin_prune_users.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . mx_append_sid("index.$phpEx?pane=right") . '">', '</a>');

		mx_message_die(GENERAL_MESSAGE, $message);
	}
	elseif ($mx_request_vars->is_post('fetch'))
	{
		// fetch inactive users list
		$inactive_users = mx_users_inactive();

		// set up template
		$template->set_filenames(array(
			'body' => 'admin/prune_users.tpl')
		);

		for($i = 0; $i < count ( $inactive_users ); $i++)
		{
			$user_id = $inactive_users[$i]['user_id'];
			$username = $inactive_users[$i]['username'];
			$user_lastvisit = ( !$inactive_users[$i]['user_lastvisit'] ) ? $lang['Never'] : $phpBB2->create_date($board_config['default_dateformat'], $inactive_users[$i]['user_lastvisit'], $board_config['board_timezone']);
			$user_regdate = ( !$inactive_users[$i]['user_regdate'] ) ? $lang['Never'] : $phpBB2->create_date($board_config['default_dateformat'], $inactive_users[$i]['user_regdate'], $board_config['board_timezone']);
			$user_active = ( !$inactive_users[$i]['user_active'] ) ? $lang['No'] : $lang['Yes'];
			$user_posts = $inactive_users[$i]['user_posts'];

			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			$template->assign_block_vars("inactive_users", array(
				"ROW_COLOR" 	  => "#" . $row_color,
				"ROW_CLASS"		  => $row_class,
				"USER_ID" 		  => $user_id,
				"USERNAME" 		  => $username,

				"USER_LAST_VISIT" => $user_lastvisit,
				"USER_REGDATE" 	  => $user_regdate,
				"USER_ACTIVE" 	  => $user_active,
				"USER_POSTS" 	  => $user_posts,

				"U_USER_PROFILE" => mx_append_sid($phpbb_root_path . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"),
				"U_NOTIFY_USER" => mx_append_sid("admin_prune_users.$phpEx?mode=notify&amp;" . POST_USERS_URL . "=$user_id")

				)
			);

			// build template switches
			if ($mx_request_vars->is_post('login_check'))
			{
				$template->assign_block_vars("inactive_users.user_lastvisit", array() );
			}
			if ($mx_request_vars->is_post('registered_check'))
			{
				$template->assign_block_vars("inactive_users.user_regdate", array() );
			}
			if ($mx_request_vars->is_post('active_check'))
			{
				$template->assign_block_vars("inactive_users.user_active", array() );
			}
			if ($mx_request_vars->is_post('posts_check'))
			{
				$template->assign_block_vars("inactive_users.user_posts", array() );
			}

		}

		$number_of_columns = 3;

		// build template switches
		if ($mx_request_vars->is_post('login_check'))
		{
			$template->assign_block_vars("user_lastvisit", array() );
			$number_of_columns++;
		}
		if ($mx_request_vars->is_post('registered_check'))
		{
			$template->assign_block_vars("user_regdate", array() );
			$number_of_columns++;
		}
		if ($mx_request_vars->is_post('active_check'))
		{
			$template->assign_block_vars("user_active", array() );
			$number_of_columns++;
		}
		if ($mx_request_vars->is_post('posts_check'))
		{
			$template->assign_block_vars("user_posts", array() );
			$number_of_columns++;
		}
		if ( ! count ( $inactive_users ) )
		{
			$template->assign_block_vars("no_inactive_users", array("L_NONE" => $lang['Acc_None'] ) );
		}

		$template->assign_vars(array(
			'L_PAGE_TITLE' => $lang['Prune_users_page_title'],
			'L_PAGE_EXPLAIN' => $lang['Prune_users_page_explain'],

			'L_CONFIRM_MESSAGE' => $lang['Prune_users_Confirm_message'],
			'L_USERNAME' => $lang['Username'],
			'L_SELECT_ALL_NONE' => $lang['Prune_users_Confirm_select_all_none'],
			'L_SELECTED' => $lang['Prune_users_selected'],
			'L_SUBMIT' => $lang['Submit'],
			'L_EMAIL' => $lang['Email'],
			'L_NOTIFY_USER' => $lang['Notify_user'],

			'L_USER_LAST_VISIT'	  => $lang['Prune_users_Confirm_last_visit'],
			'L_USER_REGDATE' 	  => $lang['user_regdate'],
			'L_USER_ACTIVE' 	  => $lang['user_active'],
			'L_USER_POSTS' 	 	  => $lang['user_posts'],

			'NUMBER_OF_COLUMNS'   => $number_of_columns,

			'S_FORM_ACTION' => mx_append_sid("admin_prune_users.$phpEx"))
		);

		include_once( $mx_root_path . 'admin/page_header_admin.' . $phpEx );

		$template->pparse('body');

		include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );
	}
	elseif ( $_GET['mode'] == 'notify' && !empty($_GET[POST_USERS_URL] ) )
	{
			$sql = "SELECT user_id, username, user_email, user_active, user_lang
		FROM " . USERS_TABLE . "
		WHERE user_id = '" . str_replace("\'", "''",  $_GET[POST_USERS_URL] ) . "'";

		if ( $result = $db->sql_query($sql) )
		{
			if ( $row = $db->sql_fetchrow($result) )
			{

			include($phpbb_root_path . 'includes/emailer.'.$phpEx);
			$emailer = new emailer($board_config['smtp_delivery']);

			$emailer->from($board_config['board_email']);
			$emailer->replyto($board_config['board_email']);

			$emailer->use_template('user_inactive_notify', $row['user_lang']);
			$emailer->email_address($row['user_email']);
			$emailer->set_subject($lang['Your_account_is_inactive']);

			$emailer->assign_vars(array(
				'SITENAME' => $board_config['sitename'],
				'USERNAME' => $username,
				'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : ''

			));
			if ( $emailer->send() )
			{
				mx_message_die(GENERAL_MESSAGE, 'Notification email sent <br> <a href="javascript:history.back();">Back</a>');
			}
			else
			{
				mx_message_die(GENERAL_MESSAGE, 'Notification email failed to send');
			}
			$emailer->reset();
			}
			else
			{
				mx_message_die(GENERAL_MESSAGE, 'This user does not exist');
			}
		}
		else
		{
			mx_message_die(GENERAL_ERROR, 'Could not obtain user information to notify the user', '', __LINE__, __FILE__, $sql);
		}

	}
	else
	{
		// set up template
		$template->set_filenames(array(
			'body' => 'admin/prune_users_sql.tpl')
		);

		$template->assign_vars(array(
			'L_PAGE_TITLE' => $lang['Prune_users_page_title'],
			'L_PAGE_EXPLAIN' => $lang['Prune_users_sql_explain'],

			'L_BUILD_QUERY' => $lang['Build_Query'],
			'L_BUILD_YOUR_QUERY' => $lang['Build_Your_Query'],

			'L_USER_LAST_VISIT'	  =>  $lang['Prune_users_Confirm_last_visit'],
			'L_USER_REGDATE' 	  =>  $lang['user_regdate'],
			'L_USER_ACTIVE' 	  =>  $lang['user_active'],
			'L_USER_POSTS' 	 	  =>  $lang['user_posts'],
			'L_YES' 	 	 	  =>  $lang['Yes'],
			'L_NO' 	 	 		  =>  $lang['No'],

			'L_USER_LAST_VISIT_EXPLAIN'	  =>  $lang['last_visit_explain'],
			'L_USER_REGDATE_EXPLAIN' 	  =>  $lang['user_regdate_explain'],
			'L_USER_ACTIVE_EXPLAIN' 	  =>  $lang['user_active_explain'],
			'L_USER_POSTS_EXPLAIN' 	 	  =>  $lang['user_posts_explain'],

			'SEVEN_DAYS' 	 	 		  =>  time() - ( 60 * 60 * 24 * 7 ),
			'TEN_DAYS' 	 	 			  =>  time() - ( 60 * 60 * 24 * 10 ),
			'TWO_WEEKS' 	 	 		  =>  time() - ( 60 * 60 * 24 * 14 ),
			'ONE_MONTH' 	 			  =>  time() - ( 60 * 60 * 24 * 30 ),
			'TWO_MONTHS' 	 			  =>  time() - ( 60 * 60 * 24 * 60 ),
			'THREE_MONTHS' 	 			  =>  time() - ( 60 * 60 * 24 * 90 ),

			'L_NEVER' 	 			 	  =>  $lang['Never'],
			'L_ALL_TIME' 	 			  =>  $lang['All_Time'],
			'L_SEVEN_DAYS' 	 	 		  =>  $lang['Seven_days'],
			'L_TEN_DAYS' 	 	 		  =>  $lang['Ten_days'],
			'L_TWO_WEEKS' 	 	 		  =>  $lang['Two_weeks'],
			'L_ONE_MONTH' 	 			  =>  $lang['One_month'],
			'L_TWO_MONTHS' 	 			  =>  $lang['Two_months'],
			'L_THREE_MONTHS' 	 		  =>  $lang['Three_months'],

			'S_FORM_ACTION' => mx_append_sid("admin_prune_users.$phpEx"))
		);

		include_once( $mx_root_path . 'admin/page_header_admin.' . $phpEx );

		$template->pparse('body');

		include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );
	}

//
// Function
//
// Fetch data for inactive users
function mx_users_inactive()
{
	global $db, $lang, $board_config, $mx_request_vars;
	$inactive_users = array();

	if ($mx_request_vars->is_post('registered_check'))
	{
		$sql_registered = " " . str_replace("\'", "''", $mx_request_vars->post('user_registered_condition', MX_TYPE_NO_TAGS)) . " `user_regdate` >= '" . ( int ) str_replace("\'", "''", $mx_request_vars->post('user_registered', MX_TYPE_NO_TAGS)) . "'";
	}
	if ($mx_request_vars->is_post('login_check'))
	{
		$sql_login = " " . str_replace("\'", "''", $mx_request_vars->post('user_lastvisit_condition', MX_TYPE_NO_TAGS)) . " `user_lastvisit` <= '" . ( int ) str_replace("\'", "''", $mx_request_vars->post('user_lastvisit', MX_TYPE_NO_TAGS)) . "'";
	}
	if ($mx_request_vars->is_post('active_check'))
	{
		$sql_active = " " . str_replace("\'", "''", $mx_request_vars->post('user_active_condition', MX_TYPE_NO_TAGS)) . " `user_active` = '" . ( int ) str_replace("\'", "''", $mx_request_vars->post('user_active', MX_TYPE_NO_TAGS)) . "'";
	}
	if ($mx_request_vars->is_post('posts_check'))
	{
		$sql_posts = " " . str_replace("\'", "''", $mx_request_vars->post('user_posts_condition', MX_TYPE_NO_TAGS)) . " `user_posts` " . str_replace("\'", "''", $mx_request_vars->post('user_posts_sign', MX_TYPE_NO_TAGS)) . " '" . ( int ) str_replace("\'", "''", $mx_request_vars->post('user_posts', MX_TYPE_NO_TAGS)) . "'";
	}

	// User is not Guest
	$sql_non_anonymous = " AND user_id <> " . ANONYMOUS;

	// Build conditions array
	$conditions = array(
		'user_regdate' 		=> array( 'check' => 'registered_check', 'variable' => 'sql_registered', 'condition' => str_replace("\'", "''", $mx_request_vars->post('user_registered_condition', MX_TYPE_NO_TAGS)) ),
		'user_lastvisit' 	=> array( 'check' => 'login_check', 'variable' => 'sql_login', 'condition' => str_replace("\'", "''", $mx_request_vars->post('user_lastvisit_condition', MX_TYPE_NO_TAGS))),
		'user_active' 	 	=> array( 'check' => 'active_check', 'variable' => 'sql_active', 'condition' => str_replace("\'", "''", $mx_request_vars->post('user_active_condition', MX_TYPE_NO_TAGS))),
		'user_posts' 	 	=> array( 'check' => 'posts_check', 'variable' => 'sql_posts', 'condition' => str_replace("\'", "''", $mx_request_vars->post('user_posts_condition', MX_TYPE_NO_TAGS))),
		'non_anonymous' 	=> array( 'variable' => 'sql_non_anonymous', 'condition' => 'AND' )
	);

	$sql_or = '';
	$sql_and = '';
	$sql_selects = 'user_id, username,';

	// Sort query
	while ( list ( $key, $array ) = @each ( $conditions ) )
	{
		if ( !empty($array['condition']) && $array['condition'] == 'OR' )
		{
			$sql_or .= $$array['variable'];
		}
		elseif ( !empty($array['condition']) && $array['condition'] == 'AND' )
		{
			$sql_and .= $$array['variable']	;
		}

		// Build sql selects
		if ( $key !== 'non_anonymous' && !empty($array['check']) )
		{
				$sql_selects .= " " . $key . ",";
		}
	}

	// touch up query parts
	if ( !empty( $sql_or ) )
	{
		$sql_or = '(' . $sql_or;
		$sql_or .= ' )';
	}
	else
	{
		$sql_and = substr( $sql_and, 4, strlen($sql_and) );
	}
	$sql_or = str_replace( '( OR', '( ', $sql_or );
	$sql_selects = substr( $sql_selects, 0, ( strlen($sql_selects) - 1 ) );

	// put query together
	$sql = "SELECT " . $sql_selects . " \n FROM " . USERS_TABLE . " \n WHERE " . $sql_or . " \n " . $sql_and . " \n ORDER BY user_id;";

	if (! $result = $db->sql_query($sql) )
	{
		mx_message_die(GENERAL_ERROR, $lang['sql_error'], "", __LINE__, __FILE__, $sql);
	}
	while ( $row = $db->sql_fetchrow($result) )
	{
		$inactive_users[] = $row;
	}
	$db->sql_freeresult($result);
	return $inactive_users;
}
?>