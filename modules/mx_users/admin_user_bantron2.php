<?php
/***************************************************************************
 *                        admin_user_bantron.php
 *                            -------------------
 *   begin                : Tuesday, Mar 17, 2003
 *   copyright            : (C) 2003 Wooly Spud
 *   email                : phpbb@xgmag.com.com
 *
 *   $Id: admin_user_bantron.php,v 1.1.0 2003/04/02 15:34:00 psotfx Exp $
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

define ('IN_PHPBB', 1);

if (!empty ($setmodules)) {
	$filename = basename (__FILE__);
	$module['Users']['Bantron'] = $filename;
	
	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
require ($phpbb_root_path . 'extension.inc');
require ('./pagestart.' . $phpEx);

//
// Set Overall Variables
//
$show = (isset ($HTTP_POST_VARS['show'])) ? $HTTP_POST_VARS['show'] : 'username';
$order = (isset ($HTTP_POST_VARS['order'])) ? $HTTP_POST_VARS['order'] : 'ASC';

$start = (isset ($HTTP_GET_VARS['start'])) ? $HTTP_GET_VARS['start'] : '0';
$show = (isset ($HTTP_GET_VARS['show'])) ? $HTTP_GET_VARS['show'] : $show;
$order = (isset ($HTTP_GET_VARS['order'])) ? $HTTP_GET_VARS['order'] : $order;

if (isset ($HTTP_POST_VARS['delete_submit'])) {
	if (isset ($HTTP_POST_VARS['ban_delete'])) {
		foreach ($HTTP_POST_VARS['ban_delete'] as $ban_id) {
			$sql = "DELETE FROM ". BANLIST_TABLE ." WHERE ban_id = $ban_id";
			if (!$db->sql_query ($sql)) {
				message_die (GENERAL_ERROR, "Couldn't delete selected bans from database", "", __LINE__, __FILE__, $sql);
			}
		}
	}
	
	$message = $lang['Ban_update_sucessful'] .'<br /><br />'. sprintf ($lang['Click_return_banadmin'], '<a href="'. append_sid ("admin_user_bantron.$phpEx") .'">', '</a>') .'<br /><br />' . sprintf ($lang['Click_return_admin_index'], '<a href="'. append_sid ("index.$phpEx?pane=right") .'">', '</a>');
	
	message_die (GENERAL_MESSAGE, $message);
} else if (isset ($HTTP_POST_VARS['submit_add']) || isset ($HTTP_POST_VARS['submit_update'])) {
	$user_bansql = '';
	$email_bansql = '';
	$ip_bansql = '';
	
	$ban_time = time ();
	$ban_by_userid = $userdata['user_id'];
	$ban_priv_reason = (!empty ($HTTP_POST_VARS['ban_priv_reason'])) ? addslashes ($HTTP_POST_VARS['ban_priv_reason']) : 'NULL';
	$ban_pub_reason_mode = $HTTP_POST_VARS['ban_pub_reason_mode'];
	$ban_pub_reason = ($ban_pub_reason_mode == '2' && !empty ($HTTP_POST_VARS['ban_pub_reason'])) ? addslashes ($HTTP_POST_VARS['ban_pub_reason']) : 'NULL';
	
	if ($HTTP_POST_VARS['ban_expire_time_mode'] == 'never') {
		$ban_expire_time = 'NULL';
	} else if ($HTTP_POST_VARS['ban_expire_time_mode'] == 'relative') {
		$ban_expire_time = strtotime ('+'. $HTTP_POST_VARS['ban_expire_time_relative'] .' '. $HTTP_POST_VARS['ban_expire_time_relative_units']);
	} else if ($HTTP_POST_VARS['ban_expire_time_mode'] == 'absolute') {
		$ban_expire_time = strtotime ($HTTP_POST_VARS['ban_expire_time_absolute_hour'] .':'. $HTTP_POST_VARS['ban_expire_time_absolute_minute'] .' '. $HTTP_POST_VARS['ban_expire_time_absolute_ampm'] .' '. $HTTP_POST_VARS['ban_expire_time_absolute_month'] .'/'. $HTTP_POST_VARS['ban_expire_time_absolute_mday'] .'/'. $HTTP_POST_VARS['ban_expire_time_absolute_year']);
	}
	
	$user_list = array ();
	if (!empty ($HTTP_POST_VARS['username'])) {
		$this_userdata = get_userdata ($HTTP_POST_VARS['username']);
		if (!$this_userdata ) {
			message_die (GENERAL_MESSAGE, $lang['No_user_id_specified'] );
		}
		
		$user_list[] = $this_userdata['user_id'];
	}
	
	$ip_list = array ();
	if (isset ($HTTP_POST_VARS['ban_ip'])) {
		$ip_list_temp = explode (',', $HTTP_POST_VARS['ban_ip']);
		
		for ($i = 0; $i < count ($ip_list_temp); $i++) {
			if (preg_match ('/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})[ ]*\-[ ]*([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$/', trim ($ip_list_temp[$i]), $ip_range_explode)) {
				//
				// Don't ask about all this, just don't ask ... !
				//
				$ip_1_counter = $ip_range_explode[1];
				$ip_1_end = $ip_range_explode[5];
				
				while ($ip_1_counter <= $ip_1_end ) {
					$ip_2_counter = ($ip_1_counter == $ip_range_explode[1] ) ? $ip_range_explode[2] : 0;
					$ip_2_end = ($ip_1_counter < $ip_1_end ) ? 254 : $ip_range_explode[6];
					
					if ($ip_2_counter == 0 && $ip_2_end == 254 ) {
						$ip_2_counter = 255;
						$ip_2_fragment = 255;
						
						$ip_list[] = encode_ip ("$ip_1_counter.255.255.255");
					}
					
					while ($ip_2_counter <= $ip_2_end ) {
						$ip_3_counter = ($ip_2_counter == $ip_range_explode[2] && $ip_1_counter == $ip_range_explode[1] ) ? $ip_range_explode[3] : 0;
						$ip_3_end = ($ip_2_counter < $ip_2_end || $ip_1_counter < $ip_1_end ) ? 254 : $ip_range_explode[7];
						
						if ($ip_3_counter == 0 && $ip_3_end == 254 ) {
							$ip_3_counter = 255;
							$ip_3_fragment = 255;
							
							$ip_list[] = encode_ip ("$ip_1_counter.$ip_2_counter.255.255");
						}
						
						while ($ip_3_counter <= $ip_3_end ) {
							$ip_4_counter = ($ip_3_counter == $ip_range_explode[3] && $ip_2_counter == $ip_range_explode[2] && $ip_1_counter == $ip_range_explode[1] ) ? $ip_range_explode[4] : 0;
							$ip_4_end = ($ip_3_counter < $ip_3_end || $ip_2_counter < $ip_2_end ) ? 254 : $ip_range_explode[8];
							
							if ($ip_4_counter == 0 && $ip_4_end == 254 ) {
								$ip_4_counter = 255;
								$ip_4_fragment = 255;
								
								$ip_list[] = encode_ip ("$ip_1_counter.$ip_2_counter.$ip_3_counter.255");
							}
							
							while ($ip_4_counter <= $ip_4_end ) {
								$ip_list[] = encode_ip ("$ip_1_counter.$ip_2_counter.$ip_3_counter.$ip_4_counter");
								$ip_4_counter++;
							}
							$ip_3_counter++;
						}
						$ip_2_counter++;
					}
					$ip_1_counter++;
				}
			} else if (preg_match ('/^([\w\-_]\.?){2,}$/is', trim ($ip_list_temp[$i]))) {
				$ip = gethostbynamel (trim ($ip_list_temp[$i]));
				
				for ($j = 0; $j < count ($ip); $j++) {
					if (!empty ($ip[$j])) {
						$ip_list[] = encode_ip ($ip[$j]);
					}
				}
			} else if (preg_match ('/^([0-9]{1,3})\.([0-9\*]{1,3})\.([0-9\*]{1,3})\.([0-9\*]{1,3})$/', trim ($ip_list_temp[$i]))) {
				$ip_list[] = encode_ip (str_replace ('*', '255', trim ($ip_list_temp[$i])));
			}
		}
	}
	
	$email_list = array ();
	if (isset ($HTTP_POST_VARS['ban_email'])) {
		$email_list_temp = explode (',', $HTTP_POST_VARS['ban_email']);
		
		for ($i = 0; $i < count ($email_list_temp); $i++) {
			//
			// This ereg match is based on one by php@unreelpro.com
			// contained in the annotated php manual at php.com (ereg
			// section)
			//
			if (eregi ('^(([[:alnum:]\*]+([-_.][[:alnum:]\*]+)*\.?)|(\*))@([[:alnum:]]+([-_]?[[:alnum:]]+)*\.){1,3}([[:alnum:]]{2,6})$', trim ($email_list_temp[$i]))) {
				$email_list[] = trim ($email_list_temp[$i]);
			}
		}
	}
	
	if (isset ($HTTP_POST_VARS['submit_update'])) {
		$sql = "UPDATE ". BANLIST_TABLE ."
			SET ban_expire_time = $ban_expire_time, ban_priv_reason = '$ban_priv_reason', ban_pub_reason_mode = '$ban_pub_reason_mode', ban_pub_reason = '$ban_pub_reason'
			WHERE ban_id = '". $HTTP_POST_VARS['ban_id'] ."'";
		if (!$db->sql_query ($sql)) {
			message_die (GENERAL_ERROR, "Couldn't update ban information", "", __LINE__, __FILE__, $sql);
		}
	} else {
		$sql = "SELECT *
			FROM ". BANLIST_TABLE;
		if (!($result = $db->sql_query ($sql))) {
			message_die (GENERAL_ERROR, "Couldn't obtain banlist information", "", __LINE__, __FILE__, $sql);
		}
		
		$current_banlist = $db->sql_fetchrowset ($result);
		$db->sql_freeresult ($result);
		
		$kill_session_sql = '';
		for ($i = 0; $i < count ($user_list); $i++) {
			$in_banlist = false;
			for ($j = 0; $j < count ($current_banlist); $j++) {
				if ($user_list[$i] == $current_banlist[$j]['ban_userid'] ) {
					$in_banlist = true;
				}
			}
			
			if (!$in_banlist ) {
				$kill_session_sql .= (($kill_session_sql != '' ) ? ' OR ' : '' ) ."session_user_id = ". $user_list[$i];
				
				$sql = "INSERT INTO ". BANLIST_TABLE ." (ban_userid, ban_time, ban_expire_time, ban_by_userid, ban_priv_reason, ban_pub_reason_mode, ban_pub_reason)
					VALUES (". $user_list[$i] .", $ban_time, $ban_expire_time, $ban_by_userid, '$ban_priv_reason', $ban_pub_reason_mode, '$ban_pub_reason')";
				if (!$db->sql_query ($sql)) {
					message_die (GENERAL_ERROR, "Couldn't insert ban_userid info into database", "", __LINE__, __FILE__, $sql);
				}
			}
		}
		
		for ($i = 0; $i < count ($ip_list); $i++) {
			$in_banlist = false;
			for ($j = 0; $j < count ($current_banlist); $j++) {
				if ($ip_list[$i] == $current_banlist[$j]['ban_ip'] ) {
					$in_banlist = true;
				}
			}
			
			if (!$in_banlist ) {
				if (preg_match ('/(ff\.)|(\.ff)/is', chunk_split ($ip_list[$i], 2, '.'))) {
					$kill_ip_sql = "session_ip LIKE '". str_replace ('.', '', preg_replace ('/(ff\.)|(\.ff)/is', '%', chunk_split ($ip_list[$i], 2, "."))) ."'";
				} else {
					$kill_ip_sql = "session_ip = '". $ip_list[$i] ."'";
				}
				
				$kill_session_sql .= (($kill_session_sql != '' ) ? ' OR ' : '' ) . $kill_ip_sql;
				
				$sql = "INSERT INTO ". BANLIST_TABLE ." (ban_ip, ban_time, ban_expire_time, ban_by_userid, ban_priv_reason, ban_pub_reason_mode, ban_pub_reason)
					VALUES ('". $ip_list[$i] ."', $ban_time, $ban_expire_time, $ban_by_userid, '$ban_priv_reason', $ban_pub_reason_mode, '$ban_pub_reason')";
				if (!$db->sql_query ($sql)) {
					message_die (GENERAL_ERROR, "Couldn't insert ban_ip info into database", "", __LINE__, __FILE__, $sql);
				}
			}
		}
		
		//
		// Now we'll delete all entries from the session table with any of the banned
		// user or IP info just entered into the ban table ... this will force a session
		// initialisation resulting in an instant ban
		//
		if ($kill_session_sql != '' ) {
			$sql = "DELETE FROM ". SESSIONS_TABLE ."
				WHERE $kill_session_sql";
			if (!$db->sql_query ($sql)) {
				message_die (GENERAL_ERROR, "Couldn't delete banned sessions from database", "", __LINE__, __FILE__, $sql);
			}
		}
		
		for ($i = 0; $i < count ($email_list); $i++) {
			$in_banlist = false;
			for ($j = 0; $j < count ($current_banlist); $j++) {
				if ($email_list[$i] == $current_banlist[$j]['ban_email'] ) {
					$in_banlist = true;
				}
			}
			
			if (!$in_banlist ) {
				$sql = "INSERT INTO ". BANLIST_TABLE ." (ban_email, ban_time, ban_expire_time, ban_by_userid, ban_priv_reason, ban_pub_reason_mode, ban_pub_reason)
					VALUES ('". str_replace ("\'", "''", $email_list[$i]) ."', $ban_time, $ban_expire_time, $ban_by_userid, '$ban_priv_reason', $ban_pub_reason_mode, '$ban_pub_reason')";
				if (!$db->sql_query ($sql)) {
					message_die (GENERAL_ERROR, "Couldn't insert ban_email info into database", "", __LINE__, __FILE__, $sql);
				}
			}
		}
	}
	
	$message = $lang['Ban_update_sucessful'] . '<br /><br />' . sprintf ($lang['Click_return_banadmin'], '<a href="' . append_sid ("admin_user_bantron.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf ($lang['Click_return_admin_index'], '<a href="' . append_sid ("index.$phpEx?pane=right") . '">', '</a>');
	
	message_die (GENERAL_MESSAGE, $message);
} else if ($HTTP_GET_VARS['mode'] == 'view_reasons') {
	$template->set_filenames (array (
		'body' => 'admin/user_bantron_reasons.tpl')
	);
	
	$sql = "SELECT b.*, u.username
		FROM ". BANLIST_TABLE ." AS b LEFT JOIN ". USERS_TABLE ." AS u
		ON b.ban_userid = u.user_id
		WHERE ban_id = ". $HTTP_GET_VARS['ban_id'];
		
	// Get results to be used to return ban information
	if (!($result = $db->sql_query ($sql))) {
		message_die (GENERAL_ERROR, 'Could not select ban reason', '', __LINE__, __FILE__, $sql);
	}
	
	$row = $db->sql_fetchrow ($result);
	
	if ($row['ban_userid'] != 0) {
		$template->assign_block_vars ('ban_username', array (
			'L_USERNAME' => $lang['Username'],
			'USERNAME' => $row['username'])
		);
	} else if (!empty ($row['ban_ip'])) {
		$template->assign_block_vars ('ban_ip', array (
			'L_IP' => $lang['BM_IP'],
			'IP' => str_replace ('255', '*', decode_ip ($row['ban_ip'])))
		);
	} else if (isset ($row['ban_email'])) {
		$template->assign_block_vars ('ban_email', array (
			'L_EMAIL' => $lang['Email'],
			'EMAIL' => $row['ban_email'])
		);
	}
	
	if ($row['ban_pub_reason_mode'] == '0') {
		$ban_pub_reason = $lang['You_been_banned'];
	} else if ($row['ban_pub_reason_mode'] == '1') {
		$ban_pub_reason = str_replace ("\n", '<br />', stripslashes ($row['ban_priv_reason']));
	} else if ($row['ban_pub_reason_mode'] == '2') {
		$ban_pub_reason = str_replace ("\n", '<br />', stripslashes ($row['ban_pub_reason']));
	}
	
	$template->assign_vars (array (
		'L_BAN_REASONS' => $lang['BM_Ban_reasons'],
		'L_PRIVATE_REASON' => $lang['BM_Private_reason'],
		'L_PUBLIC_REASON' => $lang['BM_Public_reason'],
		
		'PRIVATE_REASON' => str_replace ("\n", '<br />', stripslashes ($row['ban_priv_reason'])),
		'PUBLIC_REASON' => $ban_pub_reason)
	);
		
	for ($i = 0; $row = $db->sql_fetchrow ($data_results); $i++) {
		$reason = $row['ban_reason'];
		$reason = str_replace ("\n","<br>",$reason);
		
	}
} else if (isset ($HTTP_POST_VARS['add']) || $HTTP_GET_VARS['mode'] == 'edit') {
	$template->set_filenames (array (
		'body' => 'admin/user_bantron_edit.tpl')
	);
	
	$template->assign_vars (array (
		'L_BM_TITLE' => $lang['BM_Title'],
		'L_BM_EXPLAIN' => $lang['BM_Explain'],
		
		'L_ADD_A_NEW_BAN' => $lang['BM_Add_a_new_ban'],
		
		'L_PRIVATE_REASON' => $lang['BM_Private_reason'],
		'L_PRIVATE_REASON_EXPLAIN' => $lang['BM_Private_reason_explain'],
		'L_PUBLIC_REASON' => $lang['BM_Public_reason'],
		'L_PUBLIC_REASON_EXPLAIN' => $lang['BM_Public_reason_explain'],
		'L_GENERIC_REASON' => $lang['BM_Generic_reason'],
		'L_MIRROR_PRIVATE_REASON' => $lang['BM_Mirror_private_reason'],
		'L_OTHER' => $lang['BM_Other'],
		'L_EXPIRE_TIME' => $lang['BM_Expire_time'],
		'L_EXPIRE_TIME_EXPLAIN' => $lang['BM_Expire_time_explain'],
		'L_NEVER' => $lang['BM_Never'],
		'L_AFTER_SPECIFIED_LENGTH_OF_TIME' => $lang['BM_After_specified_length_of_time'],
		'L_MINUTES' => $lang['BM_Minutes'],
		'L_HOURS' => $lang['BM_Hours'],
		'L_DAYS' => $lang['BM_Days'],
		'L_WEEKS' => $lang['BM_Weeks'],
		'L_MONTHS' => $lang['BM_Months'],
		'L_YEARS' => $lang['BM_Years'],
		'L_AFTER_SPECIFIED_DATE' => $lang['BM_After_specified_date'],
		'L_AM' => $lang['BM_AM'],
		'L_PM' => $lang['BM_PM'],
		'L_24_HOUR' => $lang['BM_24_hour'],
		'L_SUBMIT' => $lang['Submit'],
		
		'SUBMIT' => (isset ($HTTP_POST_VARS['add'])) ? 'submit_add' : 'submit_update',
		
		'S_BANLIST_ACTION' => append_sid("admin_user_bantron.$phpEx"))
	);
	
	if ($HTTP_GET_VARS['mode'] == 'edit') {
		$sql = "SELECT b.*, u.username
		        FROM ". BANLIST_TABLE ." b, ". USERS_TABLE ." u
		        WHERE b.ban_id = '". $HTTP_GET_VARS['ban_id'] ."'
		        	AND u.user_id = b.ban_userid";
		if (!($result = $db->sql_query ($sql))) {
			message_die (GENERAL_ERROR, "Couldn't obtain banlist information for specified record", "", __LINE__, __FILE__, $sql);
		}
		
		$row = $db->sql_fetchrow ($result);
		$db->sql_freeresult ($result);
		
		if ($row['ban_userid'] != 0) {
			$template->assign_block_vars ('username_row', array (
				'L_USERNAME' => $lang['Username'],
				'L_FIND_USERNAME' => $lang['Find_username'],
				
				'U_SEARCH_USER' => append_sid("./../search.$phpEx?mode=searchuser"),
				
				'USERNAME' => $row['username'])
			);
		} else if (!empty ($row['ban_ip'])) {
			$template->assign_block_vars ('ip_row', array (
				'L_IP_OR_HOSTNAME' => $lang['IP_hostname'],
				'L_BAN_IP_EXPLAIN' => $lang['Ban_IP_explain'],
				
				'BAN_IP' => (!empty ($row['ban_ip'])) ? str_replace ('255', '*', decode_ip ($row['ban_ip'])) : '')
			);
		} else if (isset ($row['ban_email'])) {
			$template->assign_block_vars ('email_row', array (
				'L_EMAIL_ADDRESS' => $lang['Email_address'],
				'L_BAN_EMAIL_EXPLAIN' => $lang['Ban_email_explain'],
				
				'BAN_EMAIL' => $row['ban_email'])
			);
		}
		
		if (isset ($row['ban_expire_time'])) {
			$ban_expire_time = getdate ($row['ban_expire_time']);
			
			if ($ban_expire_time['hours'] < 13) {
				$ban_expire_time_ampm = 'am';
			} else {
				$ban_expire_time['hours'] = $ban_expire_time['hours'] - 12;
				$ban_expire_time_ampm = 'pm';
			}
			
			$template->assign_vars (array (
				'BAN_EXPIRE_TIME_MODE_ABSOLUTE' => ($row['ban_expire_time'] != '-1') ? ' checked' : '',
				'BAN_EXPIRE_TIME_ABSOLUTE_HOUR' => str_pad ($ban_expire_time['hours'], '2', '0', STR_PAD_LEFT),
				'BAN_EXPIRE_TIME_ABSOLUTE_MINUTE' => str_pad ($ban_expire_time['minutes'], '2', '0', STR_PAD_LEFT),
				'BAN_EXPIRE_TIME_ABSOLUTE_AM' => ($ban_expire_time_ampm == 'am') ? ' checked' : '',
				'BAN_EXPIRE_TIME_ABSOLUTE_PM' => ($ban_expire_time_ampm == 'pm') ? ' checked' : '',
				'BAN_EXPIRE_TIME_ABSOLUTE_MONTH' => str_pad ($ban_expire_time['mon'], '2', '0', STR_PAD_LEFT),
				'BAN_EXPIRE_TIME_ABSOLUTE_MDAY' => str_pad ($ban_expire_time['mday'], '2', '0', STR_PAD_LEFT),
				'BAN_EXPIRE_TIME_ABSOLUTE_YEAR' => $ban_expire_time['year'])
			);
		} else {
			$template->assign_vars (array (
				'BAN_EXPIRE_TIME_MODE_NEVER' => ' checked')
			);
		}
		
		$template->assign_vars (array (
			'BAN_PRIV_REASON' => stripslashes ($row['ban_priv_reason']),
			'BAN_PUB_REASON_MODE_0' => (!isset ($row['ban_pub_reason_mode']) || $row['ban_pub_reason_mode'] == '0') ? ' checked' : '',
			'BAN_PUB_REASON_MODE_1' => ($row['ban_pub_reason_mode'] == '1') ? ' checked' : '',
			'BAN_PUB_REASON_MODE_2' => ($row['ban_pub_reason_mode'] == '2') ? ' checked' : '',
			'BAN_PUB_REASON' => ($row['ban_pub_reason_mode'] == '2') ? stripslashes ($row['ban_pub_reason']) : '')
		);
		
		$template->assign_block_vars ('ban_id', array (
			'BAN_ID' => $HTTP_GET_VARS['ban_id'])
		);
	} else {
		$template->assign_vars (array (
			'BAN_PUB_REASON_MODE_0' => ' checked',
			'BAN_EXPIRE_TIME_MODE_NEVER' => ' checked')
		);
		
		$template->assign_block_vars ('username_row', array (
			'L_USERNAME' => $lang['Username'],
			'L_FIND_USERNAME' => $lang['Find_username'],
			
			'U_SEARCH_USER' => append_sid("./../search.$phpEx?mode=searchuser"))
		);
		
		$template->assign_block_vars ('ip_row', array (
			'L_IP_OR_HOSTNAME' => $lang['IP_hostname'],
			'L_BAN_IP_EXPLAIN' => $lang['Ban_IP_explain'])
		);
		
		$template->assign_block_vars ('email_row', array (
			'L_EMAIL_ADDRESS' => $lang['Email_address'],
			'L_BAN_EMAIL_EXPLAIN' => $lang['Ban_email_explain'])
		);
	}
} else {
	$template->set_filenames (array (
		'body' => 'admin/user_bantron_body.tpl')
	);
	
	$template->assign_vars (array (
		'L_BM_TITLE' => $lang['BM_Title'],
		'L_BM_EXPLAIN' => $lang['BM_Explain'],
		
		'L_SHOW_BANS_BY' => $lang['BM_Show_bans_by'],
		'L_USERNAME' => $lang['Username'],
		'L_IP' => $lang['BM_IP'],
		'L_EMAIL' => $lang['Email'],
		'L_ALL' => $lang['BM_All'],
		'L_SHOW' => $lang['BM_Show'],
		
		'L_ORDER' => $lang['Order'],
		'L_ASCENDING' => $lang['Sort_Ascending'],
		'L_DESCENDING' => $lang['Sort_Descending'],
		'L_SORT' => $lang['Sort'],
		
		'L_BANNED' => $lang['BM_Banned'],
		'L_EXPIRES' => $lang['BM_Expires'],
		'L_BY' => $lang['BM_By'],
		'L_REASONS' => $lang['BM_Reasons'],
		'L_EDIT' => $lang['Edit'],
		'L_DELETE' => $lang['Delete'],
		
		'L_ADD_A_NEW_BAN' => $lang['BM_Add_a_new_ban'],
		'L_DELETE_SELECTED_BANS' => $lang['BM_Delete_selected_bans'],
		
		'USERNAME_SELECTED' => ($show == 'username') ? ' selected="selected"' : '',
		'IP_SELECTED' => ($show == 'ip') ? ' selected="selected"' : '',
		'EMAIL_SELECTED' => ($show == 'email') ? ' selected="selected"' : '',
		'ALL_SELECTED' => ($show == 'all') ? ' selected="selected"' : '',
		
		'ASC_SELECTED' => ($order == 'ASC') ? ' selected="selected"' : '',
		'DESC_SELECTED' => ($order == 'DESC') ? ' selected="selected"' : '',
		
		'SHOW' => $show,
		'ORDER' => $order,
		
		'S_BANTRON_ACTION' => append_sid ("admin_user_bantron.$phpEx"))
	);
	
	switch ($show) {
		case 'username':
			$template->assign_block_vars ('username_header', array (
				'L_USERNAME' => $lang['Username'])
			);
			
			$count_sql = "SELECT COUNT(*) AS total
				FROM ". BANLIST_TABLE ." b, ". USERS_TABLE ." u
				WHERE u.user_id = b.ban_userid
					AND b.ban_userid != 0
					AND u.user_id != ". ANONYMOUS;
			$sql = "SELECT b.*, u.username
				FROM ". BANLIST_TABLE ." b, ". USERS_TABLE ." u
				WHERE u.user_id = b.ban_userid
					AND b.ban_userid != 0
					AND u.user_id != ". ANONYMOUS ."
				ORDER BY u.username $order LIMIT $start, ". $board_config['topics_per_page'];
			
			break;
		case 'ip':
			$template->assign_block_vars ('ip_header', array (
				'L_IP' => $lang['BM_IP'])
			);
			
			$count_sql = "SELECT COUNT(*) AS total
				FROM ". BANLIST_TABLE ."
				WHERE ban_ip != ''";
			$sql = "SELECT *
				FROM ". BANLIST_TABLE ."
				WHERE ban_ip != ''
				ORDER BY ban_email $order LIMIT $start, ". $board_config['topics_per_page'];
			
			break;
		case 'email':
			$template->assign_block_vars ('email_header', array (
				'L_EMAIL' => $lang['Email'])
			);
			
			$count_sql = "SELECT COUNT(*) AS total
				FROM ". BANLIST_TABLE ."
				WHERE ban_email IS NOT NULL";
			$sql = "SELECT *
				FROM ". BANLIST_TABLE ."
				WHERE ban_email IS NOT NULL
				ORDER BY ban_email $order LIMIT $start, ". $board_config['topics_per_page'];
			
			break;
		case 'all':
			$template->assign_block_vars ('username_header', array (
				'L_USERNAME' => $lang['Username'])
			);
			
			$template->assign_block_vars ('ip_header', array (
				'L_IP' => $lang['BM_IP'])
			);
			
			$template->assign_block_vars ('email_header', array (
				'L_EMAIL' => $lang['Email'])
			);
			
			$count_sql = "SELECT COUNT(*) AS total
				FROM ". BANLIST_TABLE;
			$sql = "SELECT b.*, u.username
				FROM ". BANLIST_TABLE ." b LEFT JOIN ". USERS_TABLE ." u
				ON b.ban_userid = u.user_id
				ORDER BY ban_id $order LIMIT $start, ". $board_config['topics_per_page'];
			
			break;
	}
	
	// Get results to be used to return ban information
	if (!($result = $db->sql_query ($sql))) {
		message_die (GENERAL_ERROR, 'Could not select ban data', '', __LINE__, __FILE__, $sql);
	}
	
	// Fill the Rows
	for ($i = 0; $row = $db->sql_fetchrow ($result); $i++) {
		$ban_id = $row['ban_id'];
		
		if (isset ($row['ban_by_userid'])) {
			$sql = "SELECT username FROM ". USERS_TABLE ." WHERE user_id = '". $row['ban_by_userid'] ."'";
			
			if (!($sub_result = $db->sql_query ($sql))) {
				message_die (GENERAL_ERROR, 'Could not select username', '', __LINE__, __FILE__, $sql);	
			}
			
			$username_row = $db->sql_fetchrow ($sub_result);
			
			$ban_by = $username_row['username'];
		} else {
			$ban_by = '-';
		}
				
		$ban_time = (isset ($row['ban_time'])) ? create_date ($lang['DATE_FORMAT'], $row['ban_time'], $board_config['board_timezone']) : '-';
		$ban_expire_time = (isset ($row['ban_expire_time'])) ? create_date ($lang['DATE_FORMAT'], $row['ban_expire_time'], $board_config['board_timezone']) : '-';
		$ban_reason = (isset ($row['ban_priv_reason']) || isset ($row['ban_pub_reason'])) ? "<a href=\"javascript:void (0);\" onClick=\"window.open ('". append_sid ("admin_user_bantron.php?mode=view_reasons&ban_id=$ban_id") ."','ban_reason','scrollbars=yes,width=540,height=450')\">". $lang['View'] ."</a>" : '-';
		
		$template->assign_block_vars ('rowlist', array (
			'ROW_CLASS' => (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'],
			'BAN_ID' => $ban_id,
			'BAN_TIME' => $ban_time,
			'BAN_EXPIRE_TIME' => $ban_expire_time,
			'U_BAN_EDIT' => append_sid ("admin_user_bantron.php?mode=edit&ban_id=$ban_id"),
			'BAN_REASON' => $ban_reason,
			'BAN_BY' => $ban_by)
		);
		
		switch ($show) {
			case 'username':
				$template->assign_block_vars ('rowlist.username_content', array (
					'USERNAME' => $row['username'])
				);
				
				break;
			case 'ip':
				$template->assign_block_vars ('rowlist.ip_content', array (
					'IP' => str_replace ('255', '*', decode_ip ($row['ban_ip'])))
				);
				
				break;
			case 'email':
				$template->assign_block_vars ('rowlist.email_content', array (
					'EMAIL' => $row['ban_email'])
				);
				
				break;
			case 'all':				
				$template->assign_block_vars ('rowlist.username_content', array (
					'USERNAME' => ($row['ban_userid'] != '0') ? $row['username'] : '-')
				);
				
				$template->assign_block_vars ('rowlist.ip_content', array (
					'IP' => (empty ($row['ban_ip'])) ? '-' : str_replace ('255', '*', decode_ip ($row['ban_ip'])))
				);
				
				$template->assign_block_vars ('rowlist.email_content', array (
					'EMAIL' => (isset ($row['ban_email'])) ? $row['ban_email'] : '-')
				);
				
				break;
		}
	}
	
	if (!($result = $db->sql_query ($count_sql))) {
		message_die (GENERAL_ERROR, 'Could not count ban data', '', __LINE__, __FILE__, $count_sql);
	}
	
	$num_bans = $db->sql_fetchrow ($result);
	
	$pagination = generate_pagination ("admin_user_bantron.$phpEx?show=$show&order=$order", $num_bans['total'], $board_config['topics_per_page'], $start). '&nbsp;';
	
	$template->assign_vars (array (
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf ($lang['Page_of'], (floor ($start / $board_config['topics_per_page']) + 1), ceil ($num_bans['total'] / $board_config['topics_per_page'])), 
		
		'L_GOTO_PAGE' => $lang['Goto_page'])
	);
}

$template->pparse ('body');

include ('./page_footer_admin.'.$phpEx);

?>