<?php
/***************************************************************************
*                             admin_mass_email.php
*                              -------------------
*     begin                : Thu May 31, 2001
*     copyright            : (C) 2001 The phpBB Group
*     email                : support@phpbb.com
*
*     $Id: admin_mass_email.php,v 1.15.2.5 2002/05/20 00:52:18 psotfx Exp $
*    --------->     Modified by R. U. Serious to 'Megmail'. :D <-------------
*
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
$def_wait = 10;
$def_size = 100;

define('IN_PHPBB', 1);
define('IN_PORTAL', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['General']['Mega Mail'] = $filename;
	
	return;
}

//
// Load default header
//
$no_page_header = TRUE;
//$phpbb_root_path = './../forum/';
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require('./pagestart.' . $phpEx);

// **********************************************************************
//  Read language definition
// **********************************************************************

if ( !file_exists($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_megamail.' . $phpEx) )
{
  	include($mx_root_path . 'language/lang_english/lang_megamail.' . $phpEx );
}	
else
{
  	include($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_megamail.' . $phpEx);
}

define('MEGAMAIL_TABLE', $table_prefix.'megamail');

//
// Increase maximum execution time in case of a lot of users, but don't complain about it if it isn't
// allowed.
//
@set_time_limit(1200);

$message = '';
$subject = '';

if ( isset($HTTP_GET_VARS['mode']))
{
	$sql = "CREATE TABLE ".MEGAMAIL_TABLE ."(
			mail_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
			mailsession_id VARCHAR(32) NOT NULL, 
			group_id MEDIUMINT(8) NOT NULL, 
			email_subject VARCHAR(60) NOT NULL,	
			email_body TEXT NOT NULL, 
			batch_start MEDIUMINT(8) NOT NULL, 
			batch_size SMALLINT UNSIGNED NOT NULL, 
			batch_wait SMALLINT NOT NULL, 
			status SMALLINT NOT NULL, 
			user_id MEDIUMINT(8) NOT NULL
			)";
	if ( !($result = $db->sql_query($sql)) ) 
	{
		mx_message_die(GENERAL_ERROR, 'Could not create tables. Are you sure you are using mySQL? Are you sure the table does not already exist?', '', __LINE__, __FILE__, $sql);
	}
}

//
// Do the job ...
//
if ( isset($HTTP_POST_VARS['message']) || isset($HTTP_POST_VARS['subject']) )
{
	$batchsize = (is_numeric($HTTP_POST_VARS['batchsize'])) ? intval($HTTP_POST_VARS['batchsize']) : $def_size;
	$batchwait = (is_numeric($HTTP_POST_VARS['batchwait'])) ? intval($HTTP_POST_VARS['batchwait']) : $def_wait;
	
	$mail_session_id = md5(uniqid(''));
	$sql = "INSERT INTO ".MEGAMAIL_TABLE ." (
			mailsession_id,	group_id,
			email_subject, email_body, 
			batch_start, batch_size,batch_wait, status, user_id)
		    VALUES ('".$mail_session_id."',".intval($HTTP_POST_VARS[POST_GROUPS_URL])
		    ." ,'".str_replace("\'","''",trim($HTTP_POST_VARS['subject']))
		  	."','".str_replace("\'","''",trim($HTTP_POST_VARS['message']))
		  	."', 0, ".$batchsize.",".$batchwait.", 0,".$userdata['user_id'].")";
			
	if ( !($result = $db->sql_query($sql)) ) 
	{
		mx_message_die(GENERAL_ERROR, 'Could not insert the data into '. MEGAMAIL_TABLE, '', __LINE__, __FILE__, $sql);
	}
	$mail_id = $db->sql_nextid();
	$url= append_sid("admin_megamail.$phpEx?mail_id=".$mail_id."&amp;mail_session_id=".$mail_session_id);
	$template->assign_vars(array(
		"META" => '<meta http-equiv="refresh" content="'.$batchwait.';url=' . $url . '">')
	);
	$message =  sprintf($lang['megamail_created_message'],  '<a href="' . $url . '">', '</a>');
	mx_message_die(GENERAL_MESSAGE, $message);
}

if ( isset($HTTP_GET_VARS['mail_id']) && isset($HTTP_GET_VARS['mail_session_id']) )
{
	@ignore_user_abort(true); 
	$mail_id = intval($HTTP_GET_VARS['mail_id']);
	$mail_session_id = stripslashes(trim($HTTP_GET_VARS['mail_session_id']));
	// Let's see if that session exists
	$sql = "SELECT *
			FROM ".MEGAMAIL_TABLE."
			WHERE mail_id = $mail_id AND mailsession_id LIKE '$mail_session_id'";
	if ( !($result = $db->sql_query($sql)) ) 
	{
		mx_message_die(GENERAL_ERROR, 'Could not query '. MEGAMAIL_TABLE , '', __LINE__, __FILE__, $sql);
	}
	$mail_data = $db->sql_fetchrow($result);

	if ( !($mail_data) ) 
	{
		mx_message_die(GENERAL_MESSAGE, 'Mail ID and Mail Session ID do not match.', '', __LINE__, __FILE__, $sql);
	}
	//Ok, the session exists

	$subject = $mail_data['email_subject'];
	$message = $mail_data['email_body'];
	$group_id = $mail_data['group_id'];

	//Now, let's see if we reached the upperlimit, if yes adjust the batch_size
	$sql = ( $group_id != -1 ) ? "SELECT COUNT(u.user_email) FROM " . USERS_TABLE . " u, " . USER_GROUP_TABLE . " ug WHERE ug.group_id = $group_id AND ug.user_pending <> " . TRUE . " AND u.user_id = ug.user_id" : "SELECT COUNT(u.user_email) FROM " . USERS_TABLE. " u";

	if ( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not select group members', '', __LINE__, __FILE__, $sql);
	}
	$totalrecipients = $db->sql_fetchrow($result);
	$totalrecipients = $totalrecipients['COUNT(u.user_email)'];
	
	$is_done ='';
	if (($mail_data['batch_start']+$mail_data['batch_size']) > $totalrecipients)
	{
		$mail_data['batch_size'] = $totalrecipients-$mail_data['batch_start'];
		$is_done = ', status = 1';
	}
	
	// Create new mail session
	$mail_session_id = md5(uniqid(''));	
	$sql = "UPDATE ".MEGAMAIL_TABLE ." SET
			mailsession_id = '".$mail_session_id."', batch_start= ".($mail_data['batch_start']+$mail_data['batch_size'])
		  .$is_done." WHERE mail_id = $mail_id";
			
	if ( !($result = $db->sql_query($sql)) ) 
	{
		mx_message_die(GENERAL_ERROR, 'Could not insert the data into '. MEGAMAIL_TABLE, '', __LINE__, __FILE__, $sql);
	}

	// OK, now let's start sending

	$error = FALSE;
	$error_msg = '';

	$sql = ( $group_id != -1 ) ? "SELECT u.user_email FROM " . USERS_TABLE . " u, " . USER_GROUP_TABLE . " ug WHERE ug.group_id = $group_id AND ug.user_pending <> " . TRUE . " AND u.user_id = ug.user_id" : "SELECT user_email FROM " . USERS_TABLE;
	$sql .= " LIMIT ".$mail_data['batch_start'].", ".$mail_data['batch_size'];
	
	if ( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not select group members', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		$bcc_list = '';
		do
		{
			$bcc_list .= ( ( $bcc_list != '' ) ? ', ' : '' ) . $row['user_email'];
		}
		while ( $row = $db->sql_fetchrow($result) );
		$db->sql_freeresult($result);
	}
	else
	{
		$message = ( $group_id != -1 ) ? $lang['Group_not_exist'] : $lang['No_such_user'];

		$error = true;
		$error_msg .= ( !empty($error_msg) ) ? '<br />' . $message : $message;
	}

	if ( !$error )
	{
		include($phpbb_root_path . 'includes/emailer.'.$phpEx);

		//
		// Let's do some checking to make sure that mass mail functions
		// are working in win32 versions of php.
		//
		if ( preg_match('/[c-z]:\\\.*/i', getenv('PATH')) && !$board_config['smtp_delivery'])
		{
			$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';

			// We are running on windows, force delivery to use our smtp functions
			// since php's are broken by default
			$board_config['smtp_delivery'] = 1;
			$board_config['smtp_host'] = @$ini_val('SMTP');
		}

		
		$emailer = new emailer($board_config['smtp_delivery']);
	
		$email_headers = 'Return-Path: ' . $userdata['board_email'] . "\nFrom: " . $board_config['board_email'] . "\n";
		$email_headers .= 'X-AntiAbuse: Board servername - ' . $board_config['server_name'] . "\n";
		$email_headers .= 'X-AntiAbuse: User_id - ' . $userdata['user_id'] . "\n";
		$email_headers .= 'X-AntiAbuse: Username - ' . $userdata['username'] . "\n";
		$email_headers .= 'X-AntiAbuse: User IP - ' . decode_ip($user_ip) . "\n";
		$email_headers .= "Bcc: $bcc_list\n";
	
		$emailer->use_template('admin_send_email');
		$emailer->email_address($board_config['board_email']);
		$emailer->set_subject($subject);
		$emailer->extra_headers($email_headers);
	
		$emailer->assign_vars(array(
			'SITENAME' => $board_config['sitename'], 
			'BOARD_EMAIL' => $board_config['board_email'], 
			'MESSAGE' => $message)
		);

		$emailer->send();
		$emailer->reset();

		if ($is_done =='')
		{	
			$url= append_sid("admin_megamail.$phpEx?mail_id=".$mail_id."&amp;mail_session_id=".$mail_session_id);
			$template->assign_vars(array(
				"META" => '<meta http-equiv="refresh" content="'.$mail_data['batch_wait'].';url=' . $url . '">')
			);
			$message =  sprintf($lang['megamail_send_message'] ,$mail_data['batch_start'], ($mail_data['batch_start']+$mail_data['batch_size']), '<a href="' . $url . '">', '</a>');
		}
		else
		{
			$url= append_sid("admin_megamail.$phpEx");
			$template->assign_vars(array(
				"META" => '<meta http-equiv="refresh" content="'.$mail_data['batch_wait'].';url=' . $url . '">')
			);
			$message =  $lang['megamail_done']. '<br />' . sprintf($lang['megamail_proceed'],  '<a href="' . $url . '">', '</a>');
		}
		mx_message_die(GENERAL_MESSAGE, $message);

//		mx_message_die(GENERAL_MESSAGE, $lang['Email_sent'] . '<br /><br />' . sprintf($lang['Click_return_admin_index'],  '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>'));
	}
}	

if ( $error )
{
	$template->set_filenames(array(
		'reg_header' => 'error_body.tpl')
	);
	$template->assign_vars(array(
		'ERROR_MESSAGE' => $error_msg)
	);
	$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
}

//
// Initial selection
//

$sql = "SELECT m.*, u.username, g.group_name
	FROM ".MEGAMAIL_TABLE." m
	LEFT JOIN ". USERS_TABLE." u ON (m.user_id=u.user_id)
	LEFT JOIN ". GROUPS_TABLE." g ON (m.group_id=g.group_id)";
if ( !($result = $db->sql_query($sql)) ) 
{
	mx_message_die(GENERAL_MESSAGE, sprintf('Could not obtain list of email-sessions. If you want to create the table, click <a href=%s>here to install</a>', append_sid('admin_megamail.php?mode=install')), '', __LINE__, __FILE__, $sql);
}
$row_class=0;
if ( $mail_data = $db->sql_fetchrow($result) )
	do
	{
		$url= append_sid("admin_megamail.$phpEx?mail_id=".$mail_data['mail_id']."&amp;mail_session_id=".$mail_data['mailsession_id']);
		$template->assign_block_vars('mail_sessions',array(
			'ROW' => ($row_class % 2) ? 'row2' : 'row1',
			'ID' => $mail_data['mail_id'],
			'GROUP' => ($mail_data['group_id'] != -1) ? $mail_data['group_name'] : $lang['All_users'],
			'SUBJECT' => $mail_data['email_subject'],
			'BATCHSTART' => $mail_data['batch_start'],
			'BATCHSIZE' => $mail_data['batch_size'],
			'BATCHWAIT' => $mail_data['batch_wait'].' s.',
			'SENDER' => $mail_data['username'],
			'STATUS' => ($mail_data['status']==0) ? sprintf($lang['megamail_proceed'],  '<a href="' . $url . '">', '</a>') : 'Done',
		));
	}
	while( $mail_data = $db->sql_fetchrow($result) );
else
	$template->assign_block_vars('switch_no_sessions',array(
		'EMPTY' => $lang['megamail_none'],
	));



$sql = "SELECT group_id, group_name 
	FROM ".GROUPS_TABLE . "  
	WHERE group_single_user <> 1";
if ( !($result = $db->sql_query($sql)) ) 
{
	mx_message_die(GENERAL_ERROR, 'Could not obtain list of groups', '', __LINE__, __FILE__, $sql);
}

$select_list = '<select name = "' . POST_GROUPS_URL . '"><option value = "-1">' . $lang['All_users'] . '</option>';
if ( $row = $db->sql_fetchrow($result) )
{
	do
	{
		$select_list .= '<option value = "' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
	}
	while ( $row = $db->sql_fetchrow($result) );
}
$select_list .= '</select>';

//
// Generate page
//
include('./page_header_mod.'.$phpEx);

$template->set_filenames(array(
	'body' => 'modcp/megamail.tpl')
);

$template->assign_vars(array(
	'MESSAGE' => $message,
	'SUBJECT' => $subject, 

	'L_EMAIL_TITLE' => $lang['Email'],
	'L_EMAIL_EXPLAIN' => $lang['Megamail_Explain'],
	'L_COMPOSE' => $lang['Compose'],
	'L_RECIPIENTS' => $lang['Recipients'],
	'L_EMAIL_SUBJECT' => $lang['Subject'],
	'L_EMAIL_MSG' => $lang['Message'],
	'L_EMAIL' => $lang['Email'],
	'L_NOTICE' => $notice,

	'S_USER_ACTION' => append_sid('admin_megamail.'.$phpEx),
	'S_GROUP_SELECT' => $select_list,

	'L_MAIL_SESSION_HEADER' => $lang['megamail_header'],
	'L_ID' => 'Id',
	'L_GROUP' => $lang['group_name'],
	'L_BATCH_START' => $lang['megamail_batchstart'],
	'L_BATCH_SIZE'  => $lang['megamail_batchsize'],
	'L_BATCH_WAIT'  => $lang['megamail_batchwait'],
	'L_SENDER' => $lang['Auth_Admin'],
	'L_STATUS' => $lang['megamail_status'],
	'DEFAULT_SIZE' => $def_size,
	'DEFAULT_WAIT' => $def_wait,
));

$template->pparse('body');

include('./page_footer_mod.'.$phpEx);


?>