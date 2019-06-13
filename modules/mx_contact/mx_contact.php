<?php
/**
*
* @package mxBB Portal Module - mx_contact
* @version $Id: mx_contact.php,v 1.6 2011/04/17 08:37:07 orynider Exp $
* @copyright (c) 2006-2007 [Marcus, marcus@phobbia.net]  mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL'))
{
	die("Hacking attempt");
}

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$b_description = $mx_block->block_info['block_desc'];

$is_block = FALSE;

include_once($module_root_path . 'includes/contact_constants.' . $phpEx);
include_once($module_root_path . 'includes/functions_newsletter.' . $phpEx);

$contact_config = array();
$_br = '<br /><br />';

$sql = "SELECT *
	FROM " . CONTACT_CONFIG_TABLE;

if(!($result = $db->sql_query($sql)))
{
	mx_message_die(CRITICAL_ERROR, 'Could not query config information', '', __LINE__, __FILE__, $sql);
}
while ($row = $db->sql_fetchrow($result))
{
	$contact_config[$row['config_name']] = $row['config_value'];
}

//
// Is the Form Enabled?
//
if($contact_config['contact_form_enable'] == 0)
{
	mx_message_die(GENERAL_MESSAGE, $lang['Contact_Disabled'] . $_br . sprintf($lang['Click_return_index'], "<a href=" . mx_append_sid(this_contact_mxurl()) . ">", "</a>"));
}

//
// Assign parameters
//
$user_name		= $userdata['username'];
$real_name		= (!isset($HTTP_POST_VARS['real_name'])) ? '' : stripslashes(trim(htmlspecialchars($HTTP_POST_VARS['real_name'])));
$email			= (!isset($HTTP_POST_VARS['email'])) ? '' : stripslashes(trim(htmlspecialchars($HTTP_POST_VARS['email'])));
$comments		= (!isset($HTTP_POST_VARS['feedback'])) ? '' : stripslashes(trim(htmlspecialchars($HTTP_POST_VARS['feedback'])));
$attachment		= (!isset($HTTP_POST_FILES['attachment']['name'])) ? '' : basename($HTTP_POST_FILES['attachment']['name']);
$code			= (!isset($HTTP_POST_VARS['code'])) ? '' : htmlspecialchars(trim($HTTP_POST_VARS['code']));

$script_path		= preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
$script_name		= ($script_path != $module_root_path) ? $module_root_path . '/contact.'.$phpEx : $script_path . 'conatct.'.$phpEx;

$server_name		= trim($board_config['server_name']);
$server_protocol	= ($board_config['cookie_secure']) ? 'https://' : 'http://';
$server_port		= ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';
$server_url		= $server_protocol . $server_name . $server_port;

$timedate		= date("D M d, Y g:ia");
$CF_general_message	= 0;

//
// "Quick Delete" an Attachment
//
if(isset($HTTP_GET_VARS['delete']))
{
	if($contact_config['contact_delete'] == 0)
	{
		mx_message_die(GENERAL_ERROR, $lang['QDelete_disabled']);
	}
	else
	{
		include_once($module_root_path . 'includes/functions_contact.'.$phpEx);
		exit;
	}
}

//
// Start send script
//
if(isset($HTTP_POST_VARS['submit']))
{
	function error_check()
	{
		global $HTTP_POST_FILES, $lang, $phpEx, $module_root_path, $module_root_path, $mx_root_path;
		global $CF_general_message, $CF_code_empty, $CF_code_wrong, $CF_ini_max;
		global $CF_illegal_ext, $CF_unknown_ext, $CF_image_error, $CF_image_zip;
		global $CF_rname_empty, $CF_email_empty, $CF_email_check, $CF_comments_empty, $CF_comments_limit;
		global $CF_attach_POST_error, $CF_attach_file_exists, $CF_attach_file_dud, $CF_attach_file_big;

		//
		// Lets check for Errors
		//
		if($CF_general_message == 1)
		{
			@unlink($HTTP_POST_FILES['attachment']['tmp_name']);
			mx_message_die(GENERAL_ERROR, $lang['Contact_error'] . $CF_code_empty .
				$CF_code_wrong . $CF_attach_POST_error . $CF_illegal_ext . $CF_unknown_ext .
				$CF_rname_empty . $CF_email_empty . $CF_email_check . $CF_comments_empty .
				$CF_comments_limit . $CF_attach_file_exists . $CF_attach_file_dud .
				$CF_attach_file_big . $CF_image_error . $CF_image_zip .
				sprintf($lang['Click_return_form'], "<a href=" . this_contact_mxurl() . " onclick=\"history.back(-1); return false;\">", "</a>"));
		}
	}

	//
	// Flood Control
	//
	if($contact_config['contact_flood_limit'] != 0)
	{
		$sql = "SELECT send_time, ip_address
			FROM " . CONTACT_TABLE . "
			WHERE ip_address = '$user_ip'
		ORDER BY send_time DESC";
		$result = $db->sql_query($sql);

		if(!$db->sql_query($sql))
		{
			mx_message_die(GENERAL_ERROR, 'Failed to retrieve flood information', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);

		$time_left = round(intval($row['send_time'] - time()) / intval(60) / intval(60));

		if($row['ip_address'] == $user_ip && $row['send_time'] - time() > 0)
		{
			mx_message_die(GENERAL_ERROR, sprintf($lang['Flood_limit'], $time_left));
		}
	}

	//
	// Captcha Code
	//
	if(extension_loaded('gd'))
	{
		if($contact_config['contact_captcha'] == 1)
		{
			@session_start();

			if(@ini_get('register_globals') == '0' || strtolower(@ini_get('register_globals')) == 'off')
			{
				if(isset($HTTP_SESSION_VARS['randi']))
				{
					$randi = substr($HTTP_SESSION_VARS['randi'],0,6);
				}
			}
			else
			{
				// Required for max PHP5 compatability
				if(isset($_SESSION['randi']))
				{
					$randi = substr($_SESSION['randi'],0,6);
				}
			}

			if(empty($code))
			{
				$CF_code_empty = $_br . $lang['Code_Empty'];
				$CF_general_message = 1;
			}
			elseif($code != $randi)
			{
				$CF_code_wrong = $_br . $lang['Code_Wrong'];
				$CF_general_message = 1;
			}

			//
			// Clear session data to prevent image reuse
			//
			@session_destroy();
			unset($randi);
		}
	}

	//
	// Real Name Validator
	//
	if($contact_config['contact_require_rname'] == 1)
	{
		if(empty($real_name))
		{
			$CF_rname_empty = $_br . $lang['Rname-Empty'];
			$CF_general_message = 1;
		}
	}

	//
	// E-mail Validator
	//
	if($contact_config['contact_require_email'] == 1)
	{
		if(!empty($email))
		{
			if(!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-הצü]+\.([a-z0-9\-הצü]+\.)*?[a-z]+$/is', $email)) 
			{
				$CF_email_check = $_br . $lang['Email-Check'];
				$CF_general_message = 1;
 			}
		}
		else
		{
			$CF_email_empty = $_br . $lang['Email-Empty'];
			$CF_general_message = 1;
		}
	}

	//
	// Comments Validator
	//
	if($contact_config['contact_require_comments'] == 1)
	{
		if(empty($comments))
		{
			$CF_comments_empty = $_br . $lang['Comments-Empty'];
			$CF_general_message = 1;
		}
	}

	if($contact_config['contact_char_limit'] > 0)
	{
		if(strlen(trim($comments)) > $contact_config['contact_char_limit'])
		{
			$CF_comments_limit = $_br . $lang['Comments_exceeded'];
			$CF_general_message = 1;
		}
	}
	// Stage 1
	error_check();

	$CF_attach_success = '';
	if($contact_config['contact_permit_attachments'] == 1)
	{
		require($module_root_path . 'includes/contact_attach.'.$phpEx);
	}
	// Stage 5
	error_check();

	//
	// Indicate any fields that weren't completed
	//
	if(empty($real_name) && $contact_config['contact_require_rname'] == 0)
	{
		$real_name = $lang['Empty'];
	}

	if(empty($email) && $contact_config['contact_require_email'] == 0)
	{
		$email = $lang['Empty'];
	}

	if(empty($comments) && $contact_config['contact_require_comments'] == 0)
	{
		$comments = $lang['Empty'];
	}
	
	//Vars not used in simple contact block
	$institution = $lang['Empty'];
	$phone = $lang['Empty'];
	$fax = $lang['Empty'];	

	if($contact_config['contact_permit_attachments'] == 0)
	{
		$attach = '--';
		$delete_link = '';
	}

	//
	// Change "Anonymous" to "Guest"
	//
	$user_name = ($userdata['user_id'] == ANONYMOUS) ? $lang['Guest'] : $userdata['username'];

	//
	// Set the Subject
	// NB: not used if email/index.tpl has 'Subject:' hard-coded
	//
	$subject = trim(stripslashes($lang['Feedback']));

	$sql = "SELECT user_lang
			FROM " . USERS_TABLE . "
			WHERE user_id = 2";

	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(CRITICAL_ERROR, 'Could not query recipient information', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	//
	// Send the e-mail
	//
	include($module_root_path . 'includes/contact_emailer.'.$phpEx);

	$emailer = new emailer($board_config['smtp_delivery']);
	$emailer->from($board_config['board_email']);
	$emailer->replyto($board_config['board_email']);

	$email_headers  = 'X-AntiAbuse: Board Servername - ' . $board_config['server_name'] . "\n";
	$email_headers .= 'X-AntiAbuse: User ID - ' . $userdata['user_id'] . "\n";
	$email_headers .= 'X-AntiAbuse: Username - ' . $userdata['username'] . "\n";
	$email_headers .= 'X-AntiAbuse: User IP - ' . decode_ip($user_ip) . "\n";

	empty($contact_config['contact_admin_email']) ? $emailer->email_address($board_config['board_email']) : $emailer->email_address($contact_config['contact_admin_email']);

	$emailer->extra_headers($email_headers);
	$emailer->use_template('contact', $row['user_lang']);
	$emailer->set_subject($subject);

	$emailer->assign_vars(array(
		'REAL_NAME' => $real_name,
		'USERNAME' => $user_name,
		'EMAIL' => $email,
		'COMMENTS' => $comments,
		'ATTACHMENT' => $attach,
		'DELETE' => ($contact_config['contact_delete'] == 1) ? $delete_link : '',

		'USER_IP' => decode_ip($user_ip),
		'TIMEDATE' => $timedate,
		'SITENAME' => $board_config['sitename'])
	);

	$emailer->send();
	$emailer->reset();

	//
	// Send "Thank You" E-mail?
	//
	if($contact_config['contact_thankyou'] != 0)
	{
		include($module_root_path . 'includes/contact_extend.'.$phpEx);
	}

	//
	// SQL Time
	//
	$wait_time = time() + intval($contact_config['contact_flood_limit'] * 60) * intval(60);

	$sql = "INSERT INTO " . CONTACT_TABLE . "
		VALUES ('$user_ip', '$wait_time')";
	$result = $db->sql_query($sql);

	if(!$db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, 'Failed to insert user information', '', __LINE__, __FILE__, $sql);
	}

	//
	// No Errors
	//
	if($CF_general_message == 0)
	{
		if($contact_config['contact_storage'] == 1)
		{
			$send_time = time();
			$getfile = (!empty($attachment)) ? $contact_config['contact_file_root'] . "/" . decode_ip($user_ip) . "/" . $attachment : '';

			$sql = array(					
				'sendtime'	=> $send_time,
				'username'	=> $user_name,
				'realname'	=> str_replace("\'", "''", $real_name),
				'institution'	=> str_replace("\'", "''", $institution),
				'phone'	=> str_replace("\'", "''", $phone),
				'fax'	=> str_replace("\'", "''", $fax),
				'email'	=> str_replace("\'", "''", $email),
				'ip'	=> $user_ip,
				'message'	=> addslashes(str_replace("\'", "''", $comments)),				
				'newsletter'=> (int) $newsletter,
				'upfile'	=> str_replace("\'", "''", $getfile),				
			);	

			if(!$result = $db->sql_query("INSERT INTO " . CONTACT_MSGS_TABLE . $db->sql_build_array('INSERT', $sql)))
			{
				mx_message_die(GENERAL_ERROR, 'Could not update Message Log', '', __LINE__, __FILE__, $sql);
			}
		}

		mx_message_die(GENERAL_MESSAGE, $lang['Contact_success'] . $CF_attach_success  . $_br . sprintf($lang['Click_return_index'], "<a href=" . mx_append_sid(this_contact_mxurl()) . ">", "</a>"));
	}
}

//
// End send script
//

//
// Change "Anonymous" to "Guest"
//
$user_name = ($userdata['user_id'] == ANONYMOUS) ? $lang['Guest'] : $userdata['username'];

//
// Check if "Real Name" is required
//
$rname = ($contact_config['contact_require_rname'] == 1) ? $lang['Rname_require'] : $lang['Real_name'];

//
// Check if "E-mail" is required
//
$email = ($contact_config['contact_require_email'] == 1) ? $lang['E-mail_require'] : $lang['E-mail'];

//
// Check if "Comments" are required
//
$comments = ($contact_config['contact_require_comments'] == 1) ? $lang['Comments_require'] : $lang['Comments'];

//
// Pruning
//
if($contact_config['contact_prune'] == 1)
{
	$send_time = time();

	$sql = "DELETE FROM " . CONTACT_TABLE . "
		WHERE send_time <= '$send_time'";

	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, 'Failed to initiate pruning', '', __LINE__, __FILE__, $sql);
	}
}

//
// Generate the Page
//
//include($mx_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array( 
	'contact_body' => 'contact_body.tpl') 
);

$template->assign_vars(array(
	'L_CONTACT_FORM' => $lang['Contact_form'],
	'L_INTRODUCTION' => $lang['Contact_intro'],

	'L_REAL_NAME' => $rname,
	'L_REAL_NAME_EXPLAIN' => $lang['Real_name_explain'],

	'L_EMAIL' => $email,
	'L_EXPLAIN_EMAIL' => $lang['Explain_email'],

	'L_COMMENTS' => $comments,
	'L_COMMENTS_EXPLAIN' => $lang['Comments_explain'],
	'L_COMMENTS_LIMIT' => ($contact_config['contact_char_limit'] > 0) ? sprintf($lang['Comments_limit'], $contact_config['contact_char_limit']) : '',

	'L_ATTACHMENT' => $lang['Attachment'],
	'L_ATTACHMENT_EXPLAIN' => sprintf($lang['Attachment_explain'], $contact_config['contact_max_file_size']),

	'L_FLOOD_EXPLAIN' => ($contact_config['contact_flood_limit'] > 0) ? sprintf($lang['Flood_explain'], $contact_config['contact_flood_limit'], ($contact_config['contact_flood_limit'] <> 1) ? $lang['hours'] : $lang['hour']) : '',

	'L_FIELDS_REQUIRED' => $lang['Fields_required'],
	'L_NOTIFY_IP' => $lang['Notify_IP'],

	'L_CHARS' => $lang['Chars'],

	'L_CAPTCHA' => $lang['Captcha_code'],
	'L_CAPTCHA_EXPLAIN' => $lang['Captcha_code_explain'],

	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],

	'USERNAME' => $user_name,
	'CAPTCHA' => $module_root_path.'mx_captcha.'.$phpEx,

	'S_FORM_ENCTYPE' => 'multipart/form-data',
	'S_SUBMIT_ACTION' => mx_append_sid(this_contact_mxurl())
));

//
// Permit Attachments
//
$attach_auth = 0;
if(!$userdata['session_logged_in'])
{
	$attach_auth = ($contact_config['contact_auth_guest'] == 1) ? 1 : 0;
}
else
{
	switch ($userdata['user_level'])
	{
		case USER:
			$attach_auth = ($contact_config['contact_auth_user'] == 1) ? 1 : 0;
			break;

		case MOD:
			$attach_auth = ($contact_config['contact_auth_mod'] == 1) ? 1 : 0;
			break;

		case ADMIN:
			$attach_auth = ($contact_config['contact_auth_admin'] == 1) ? 1 : 0;
			break;

		default:
			$attach_auth = ($contact_config['contact_auth_guest'] == 1) ? 1 : 0;
	}
}

if($contact_config['contact_permit_attachments'] == 1 && $attach_auth == 1)
{
	$template->assign_block_vars('permit_attachments', array());
}

if($contact_config['contact_captcha'] == 1 && extension_loaded('gd'))
{
	$template->assign_block_vars('captcha', array());
}

$template->pparse('contact_body');
//include($mx_root_path . 'includes/page_tail.'.$phpEx);

?>