<?php
/***************************************************************************
*                             admin_contact_newsletter.php
*                              -------------------
*     begin                : Thu May 31, 2001
*     copyright            : (C) 2001 The phpBB Group
*     email                : support@phpbb.com
*
*     $Id: admin_mass_newsletter.php,v 1.15 2013/06/17 15:25:31 orynider Exp $
*    --------->     Modified by R. U. Serious to 'Megmail'. :D <-------------
*    --------->     Modified by OryNider to 'Newsletter'. :D <-------------
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
$def_wait = 2;
$def_size = 1;

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Contact_Form']['Mass_Newsletters'] = 'modules/mx_contact/admin/' . $file;	
	return;
}
@define('IN_PORTAL', true);
//
// Load default header
//
$no_page_header = TRUE;
$mx_root_path = './../../../';
$module_root_path = "./../";
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require($mx_root_path . 'admin/pagestart.' . $phpEx);

include_once($module_root_path . 'includes/contact_constants.' . $phpEx);
include_once($module_root_path . 'includes/functions_newsletter.' . $phpEx);

// **********************************************************************
//  Read language definition
// **********************************************************************
/*
if ( !file_exists($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx) )
{
  	include($module_root_path . 'language/lang_english/lang_main.' . $phpEx );
}	
else
{
  	include($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
}
*/

//
// Increase maximum execution time in case of a lot of users, but don't complain about it if it isn't
// allowed.
//
@set_time_limit(1200);

$message = '';
$subject = '';

if ($mx_request_vars->is_get('mode'))
{
	$sql = "CREATE TABLE ".CONTACT_MASS_TABLE ."(
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
if ( $mx_request_vars->is_post('message') || $mx_request_vars->is_post('subject') )
{
	$batchsize = (is_numeric($HTTP_POST_VARS['batchsize'])) ? intval($HTTP_POST_VARS['batchsize']) : $def_size;
	$batchwait = (is_numeric($HTTP_POST_VARS['batchwait'])) ? intval($HTTP_POST_VARS['batchwait']) : $def_wait;
	
	$mail_session_id = md5(uniqid(''));
	
	$sql_array = array(					
		'mailsession_id' => $mail_session_id,
		'group_id'		=> '-1',		
		'email_subject'	=> str_replace("\'","''",trim($HTTP_POST_VARS['subject'])),
		'email_body'	=> str_replace("\'","''",trim($HTTP_POST_VARS['message'])),
		'batch_start'	=> '0',
		'batch_size'	=> $batchsize,
		'batch_wait'	=> $batchwait,
		'status'		=> '0',
		'user_id'		=> $userdata['user_id'],		
	);
		
	$sql = "INSERT INTO " . CONTACT_MASS_TABLE . $db->sql_build_array('INSERT', $sql_array);
			
	if (!($result = $db->sql_query($sql))) 
	{
		mx_message_die(GENERAL_ERROR, 'Could not insert the data into '. CONTACT_MASS_TABLE, '', __LINE__, __FILE__, $sql);
	}
	$mail_id = $db->sql_nextid();
	$url= mx_append_sid("admin_mass_newsletter.$phpEx?mail_id=".$mail_id."&amp;mail_session_id=".$mail_session_id);
	$template->assign_vars(array(
		"META" => '<meta http-equiv="refresh" content="'.$batchwait.';url=' . $url . '">')
	);
	$message =  sprintf($lang['newsletter_mass_created_message'],  '<a href="' . $url . '">', '</a>');
	mx_message_die(GENERAL_MESSAGE, $message);
}

if ( isset($HTTP_GET_VARS['mail_id']) && isset($HTTP_GET_VARS['mail_session_id']) )
{
	@ignore_user_abort(true); 
	$mail_id = intval($HTTP_GET_VARS['mail_id']);
	$mail_session_id = stripslashes(trim($HTTP_GET_VARS['mail_session_id']));
	// Let's see if that session exists
	$sql = "SELECT *
			FROM ".CONTACT_MASS_TABLE."
			WHERE mail_id = $mail_id AND mailsession_id LIKE '$mail_session_id'";
	if ( !($result = $db->sql_query($sql)) ) 
	{
		mx_message_die(GENERAL_ERROR, 'Could not query '. CONTACT_MASS_TABLE , '', __LINE__, __FILE__, $sql);
	}
	$mail_data = $db->sql_fetchrow($result);

	if ( !($mail_data) ) 
	{
		mx_message_die(GENERAL_MESSAGE, 'Mail ID and Mail Session ID do not match.', '', __LINE__, __FILE__, $sql);
	}
	//Ok, the session exists

	$subject = $mail_data['email_subject'];
	$message = $mail_data['email_body'];
	$group_id = '-1'; //$mail_data['group_id'];

	//Now, let's see if we reached the upperlimit, if yes adjust the batch_size
	$sql = "SELECT COUNT(email) FROM " . CONTACT_MSGS_TABLE . " WHERE newsletter = 1";

	if ( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not select count subscribers', '', __LINE__, __FILE__, $sql);
	}
	$totalrecipients = $db->sql_fetchrow($result);
	$totalrecipients = $totalrecipients['COUNT(email)'];
	
	$is_done = '';
	if (($mail_data['batch_start'] + $mail_data['batch_size']) > $totalrecipients)
	{
		$mail_data['batch_size'] = $totalrecipients - $mail_data['batch_start'];
		$is_done = ', status = 1';
	}
	
	// Create new mail session
	$mail_session_id = md5(uniqid(''));	
	$sql = "UPDATE ".CONTACT_MASS_TABLE ." SET
			mailsession_id = '".$mail_session_id."', batch_start= ".($mail_data['batch_start'] + $mail_data['batch_size'])
		  .$is_done." WHERE mail_id = $mail_id";
			
	if ( !($result = $db->sql_query($sql)) ) 
	{
		mx_message_die(GENERAL_ERROR, 'Could not insert the data into '. CONTACT_MASS_TABLE, '', __LINE__, __FILE__, $sql);
	}

	// OK, now let's start sending

	$error = FALSE;
	$error_msg = '';

	$sql = "SELECT email FROM " . CONTACT_MSGS_TABLE . " WHERE newsletter = 1";
	//$sql .= " LIMIT ".$mail_data['batch_start'].", ".$mail_data['batch_size'];
	
	if ( !($result = $db->sql_query_limit($sql, $mail_data['batch_start'], $mail_data['batch_size'])) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not select subscribers', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		//$j = 0;
		// Send with BCC, no more than 50 recipients for one mail (to not exceed the limit)
		$max_chunk_size = 50;
		$bcc_list = array();
		$old_lang = $row['user_lang'];
		$old_notify_type = $row['user_notify_type'];

		do
		{
			if (($row['user_notify_type'] == NOTIFY_EMAIL && $row['user_email']) ||
				($row['user_notify_type'] == NOTIFY_IM && $row['user_jabber']) ||
				($row['user_notify_type'] == NOTIFY_BOTH && $row['user_email'] && $row['user_jabber']))
			{
				$bcc_list['user_lang']			= $row['user_lang'];
				$bcc_list['user_notify_type']	= $row['user_notify_type'];
				$bcc_list['user_email']			= $row['user_email'];
				$bcc_list['username']			= $row['username'];
				$bcc_list['user_jabber']		= $row['user_jabber'];
			}
			$bcc_list .= ( ( $bcc_list != '' ) ? ', ' : '' ) . $row['user_email'];
		}
		while ($row = $db->sql_fetchrow($result));		
		$db->sql_freeresult($result);
	}
	else
	{
		$message = "Users: " . count($row); //$lang['No_such_user'];

		$error = true;
		$error_msg .= ( !empty($error_msg) ) ? '<br />' . $message : $message;
	}

	if (!@function_exists('generate_portal_url'))
	{
		function generate_portal_url($without_script_path = false)
		{
			$url = PORTAL_URL;
			if (!$without_script_path)
			{
				$url .= $script_path;
			}

			// Strip / from the end
			if (substr($url, -1, 1) == '/')
			{
				$url = substr($url, 0, -1);
			}

			return $url;			
		}			
	}	

	if (!$error)
	{
		include_once($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);
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

		$emailer = new messenger(false);
		
		$used_lang = $bcc_list['user_lang'];
		$used_method = $bcc_list['user_notify_type'] ? $bcc_list['user_notify_type'] : NOTIFY_EMAIL;
		
		$email_row = $bcc_list['user_email'] ? $bcc_list : $userdata['user_email'];
		
		$messenger->{'to'}($email_row['user_email'], $email_row['username']);
		//$messenger->im($email_row['jabber'], $email_row['name']);		
		$messenger_from = $contact_config['contact_admin_email'];
		$messenger_to = $userdata['user_email'];
		$messenger->{'to'}($email_row['email'], $email_row['name']);		
		
		$messenger->headers =  ("From: " . $userdata['username'] . " <" . $contact_config['contact_admin_email'] . ">");
		$messenger->headers =  ("To: " . $board_config['board_email']);
		$messenger->headers =  ("Bcc: " . ($def_size == 1) ? '' : $bcc_list);		
		$messenger->headers =  ("Return-Path: ". $board_config['board_email'] ."\n");
		$messenger->headers =  ("MIME-Version: 1.0"); //$messenger->headers =  $dkim_signature;					 
		$messenger->headers =  ("Message-ID: " . md5(phpBB3::unique_id(time())) . "@" . $board_config['server_name']);
		$messenger->headers =  ("Date: " . date("r", time()));
		$messenger->headers =  ("Content-Type: text/html; charset=UTF-8"); // format=flowed
		$messenger->headers =  ("Content-Transfer-Encoding: 8bit"); // 7bit
		
		$messenger->headers =  ("DomainKey-Signature: a=rsa-sha1; c=nofws; d=" . $portal_config['server_name'] . "; s=gamma; h=message-id:date:from:to:subject:cc:bcc:in-reply-to:return-path:mime-version:message-id:date:content-type:content-transfer-encoding:references; b=" . $contact_config['domainkey_signature']);

		$messenger->headers =  ("X-Priority: 3");
		$messenger->headers =  ("X-MSMail-Priority: Normal");
		$messenger->headers =  ("X-Mailer: MXP3");
		$messenger->headers =  ("X-MimeOLE: Produced By Mx-Publisher CMS" . PORTAL_VERSION);
		$messenger->headers =  ("X-MXP-Origin: mxp://" . str_replace(array('http://', 'https://'), array('', ''), generate_contact_url()));
 
		$messenger->headers =  ("X-AntiAbuse: Board ServerName - " . $board_config['server_name']);
		$messenger->headers =  ("X-AntiAbuse: User_id - " . $userdata['user_id']);
		$messenger->headers =  ("X-AntiAbuse: UserName - " . $userdata['username']);
		$messenger->headers =  ("X-AntiAbuse: User_IP - " . contact_decode_ip($user_ip)); //$messenger->headers =  "X-AntiAbuse: User_Level - " . ($userdata['user_level'] == ADMIN) ? "Portal Admin" : "User Level: " . $userdata['user_level'];
		
		$messenger->set_mail_html(true);	
		$messenger->template('contact_send_email');
		
		$messenger->subject(htmlspecialchars_decode(str_replace("{USERNAME}", $email_row['name'], $subject)));
		$messenger->set_mail_priority($priority);	
	
		$emailer->assign_vars(array(
			'SITENAME' => $board_config['sitename'], 
			'BOARD_EMAIL' => $board_config['board_email'], 
			'MESSAGE' => $message)
		);

		if (!($messenger->send($used_method)))
		{
			$errored = true;
		}		
		$messenger->reset();

		if ($is_done =='')
		{	
			$url= mx_append_sid("admin_mass_newsletter.$phpEx?mail_id=".$mail_id."&amp;mail_session_id=".$mail_session_id);
			$template->assign_vars(array(
				"META" => '<meta http-equiv="refresh" content="'.$mail_data['batch_wait'].';url=' . $url . '">')
			);
			$message =  sprintf($lang['newsletter_mass_send_message'] ,$mail_data['batch_start'], ($mail_data['batch_start']+$mail_data['batch_size']), '<a href="' . $url . '">', '</a>');
		}
		else
		{
			$url= mx_append_sid("admin_mass_newsletter.$phpEx");
			$template->assign_vars(array(
				"META" => '<meta http-equiv="refresh" content="'.$mail_data['batch_wait'].';url=' . $url . '">')
			);
			$message =  $lang['newsletter_mass_done']. '<br />' . sprintf($lang['newsletter_mass_proceed'],  '<a href="' . $url . '">', '</a>');
		}
		mx_message_die(GENERAL_MESSAGE, $message);

//		mx_message_die(GENERAL_MESSAGE, $lang['Email_sent'] . '<br /><br />' . sprintf($lang['Click_return_admin_index'],  '<a href="' . mx_append_sid("index.$phpEx?pane=right") . '">', '</a>'));
	}
}	

if ( $error )
{
	$template->set_filenames(array(
		'reg_header' => 'error_body.'.$tplEx)
	);
	$template->assign_vars(array(
		'ERROR_MESSAGE' => $error_msg)
	);
	$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
}

//
// Initial selection
//
$sql = "SELECT * FROM " . CONTACT_MASS_TABLE;

if ( !($result = $db->sql_query($sql)) ) 
{
	mx_message_die(GENERAL_MESSAGE, sprintf('Could not obtain list of email-sessions. If you want to create the table, click <a href=%s>here to install</a>', mx_append_sid('admin_mass_newsletter.php?mode=install')), '', __LINE__, __FILE__, $sql);
}
$row_class = 0;
if ( $mail_data = $db->sql_fetchrow($result) )
	do
	{
		$url= mx_append_sid("admin_mass_newsletter.$phpEx?mail_id=".$mail_data['mail_id']."&amp;mail_session_id=".$mail_data['mailsession_id']);
		$template->assign_block_vars('mail_sessions',array(
			'ROW' => ($row_class % 2) ? 'row2' : 'row1',
			'ID' => $mail_data['mail_id'],
			'GROUP' => $lang['All_subcribers'],
			'SUBJECT' => $mail_data['email_subject'],
			'BATCHSTART' => $mail_data['batch_start'],
			'BATCHSIZE' => $mail_data['batch_size'],
			'BATCHWAIT' => $mail_data['batch_wait'].' s.',
			'SENDER' => $mail_data['username'],
			'STATUS' => ($mail_data['status'] == 0) ? sprintf($lang['newsletter_mass_proceed'],  '<a href="' . $url . '">', '</a>') : 'Done',
		));
	}
	while( $mail_data = $db->sql_fetchrow($result) );
else
	$template->assign_block_vars('switch_no_sessions', array(
		'EMPTY' => $lang['newsletter_mass_none'],
	));



$select_list = '<select name = "' . POST_GROUPS_URL . '"><option value = "-1">' . $lang['All_subcribers'] . '</option>';
$select_list .= '</select>';

//
// Generate page
//
if (file_exists($mx_root_path . '/modules/mx_shared/tinymce/jscripts/tiny_mce/tiny_mce.js'))
{
	$module_root_path_tmp = $module_root_path;
	$module_root_path = $mx_root_path . '/modules/mx_shared/';
	$mx_page->add_js_file('tinymce/jscripts/tiny_mce/tiny_mce.js'); // Relative to module_root
	$module_root_path = $module_root_path_tmp;	
}

$gen_simple_header = true;
require($mx_root_path . 'admin/page_header_admin.'.$phpEx);
	
$template->set_filenames(array(
	'body' => 'admin/contact_newsletters.'.$tplEx)
);

$template->assign_vars(array(
	"S_CONTACT_ACTION" => mx_append_sid("admin_mass_newsletter.$phpEx"),
	'S_GROUP_SELECT' => $select_list,
	
	'L_VERSION' => sprintf($contact_config['newsletter_version']),	
	
	'MESSAGE' => $message,
	'SUBJECT' => $subject, 

	'L_EMAIL_TITLE' => $lang['Email'],
	'L_EMAIL_EXPLAIN' => $lang['newsletter_mass_Explain'],
	'L_COMPOSE' => $lang['Compose'],
	'L_RECIPIENTS' => $lang['Recipients'],
	'L_EMAIL_SUBJECT' => $lang['Subject'],
	'L_EMAIL_MSG' => $lang['Message'],
	'L_EMAIL' => $lang['Email'],
	'L_NOTICE' => $notice,
	
	'L_TINY_MCE_LANGUAGE' => $board_config['default_lang'] ? $mx_user->encode_lang($board_config['default_lang']) : 'en',
	
	'L_MAIL_SESSION_HEADER' => $lang['newsletter_mass_header'],
	
	'L_ID' => 'Id',
	'L_GROUP' => $lang['group_name'],
	'L_BATCH_START' => $lang['newsletter_mass_batchstart'],
	'L_BATCH_SIZE'  => $lang['newsletter_mass_batchsize'],
	'L_BATCH_WAIT'  => $lang['newsletter_mass_batchwait'],
	'L_SENDER' => $lang['Auth_Admin'],
	'L_STATUS' => $lang['newsletter_mass_status'],
	'DEFAULT_SIZE' => $def_size,
	'DEFAULT_WAIT' => $def_wait,
));

$template->pparse('body');

require_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );


?>