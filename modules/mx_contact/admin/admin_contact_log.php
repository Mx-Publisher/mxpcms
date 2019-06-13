<?php
/***************************************************************************
 *                               admin_contact_log.php
 *                               ---------------------
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *   	Copyright:	(C) 2006-07, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		17:46 03/07/2007
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
	$file = basename( __FILE__ );
	$module['Contact_Form']['Contact_Messages'] = 'modules/mx_contact/admin/' . $file;
	return;
}
@define('IN_PORTAL', true);
$mx_root_path = './../../../';
$module_root_path = "./../";
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require($mx_root_path . 'admin/pagestart.' . $phpEx);

include_once($module_root_path . 'includes/contact_constants.' . $phpEx);
include_once($module_root_path . 'includes/functions_newsletter.' . $phpEx);

// **********************************************************************
//  Read language definition
// **********************************************************************
if ( !file_exists( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx ) )
{
  	include_once($module_root_path . 'language/lang_english/lang_main.'.$phpEx);
	$link_language = 'lang_english';
}
else
{
  	include_once($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.'.$phpEx);
	$link_language = 'lang_' . $board_config['default_lang'];
}

$start = (isset($_GET['start']) || isset($_POST['start'])) ? intval($_GET['start']) : 0;
$pagination = '';
$total_pag_items = 1;

$confirm = (isset($_POST['confirm'])) ? true : false;
$delete = (isset($_POST['delete'])) ? true : false;

if(isset($_POST['mode']) || isset($_GET['mode']))
{
	$mode = (isset($_POST['mode'])) ? $_POST['mode'] : $_GET['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	if($delete)
	{
		$mode = 'delete';
	}
	else
	{
		$mode = '';
	}
}

if(isset($_POST['cancel']))
{
	$mode = '';
}

if($mode == 'delete')
{
	if($cancel)
	{
		$redirect = 'admin/admin_contact_log.'.$phpEx;
		redirect(mx_append_sid($redirect, true));
	}

	if(!$confirm)
	{
		$msg_ids = $_POST['msgid'];

		if(empty($_POST['msgid']))
		{
			$redirect = 'admin/admin_contact_log.'.$phpEx;
			redirect(mx_append_sid($redirect, true));
		}

		$hidden_fields = '';
		for($i = 0, $msgs = count($msg_ids); $i < $msgs; $i++)
		{
			$hidden_fields .= '<input type="hidden" name="msgid[]" value="' . intval($msg_ids[$i]) . '" />';
		}

		$template->set_filenames(array(
			'body' => 'admin/confirm_body.'.$tplEx)
		);

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Confirm'],
			'MESSAGE_TEXT' => $lang['Confirm_delete_msg'],

			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],

			'S_CONFIRM_ACTION' => mx_append_sid('admin_contact_log.'.$phpEx.'?mode=delete'),
			'S_HIDDEN_FIELDS' => $hidden_fields)
		);

		$template->pparse('body');
	}
	else
	{
		$msg_ids = (isset($_POST['msgid'])) ? $_POST['msgid'] : array($msgid);

		$del_msg_sql = '';
		for($i = 0, $msgs = count($msg_ids); $i < $msgs; $i++)
		{
			$del_msg_sql .= (($del_msg_sql != '') ? ', ' : '') . intval($msg_ids[$i]);
		}

		$sql = "DELETE FROM " . CONTACT_MSGS_TABLE . "
			WHERE msg_id IN ($del_msg_sql)";

		if(!$result = $db->sql_query($sql))
		{
			mx_message_die(GENERAL_ERROR, 'Could not delete message(s)', '', __LINE__, __FILE__, $sql);
		}

		if($del_msg_sql == '')
		{
			$redirect = 'admin/admin_contact_log.'.$phpEx;
			redirect(mx_append_sid($redirect, true));
		}

		$message = $lang['Msg_del_success'] . "<br /><br />" . sprintf($lang['Click_return_msglog'], "<a href=\"" . mx_append_sid("admin_contact_log.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		mx_message_die(GENERAL_MESSAGE, $message);
	}
}

if($mode == 'remove')
{
	$contact_config = array();

	$sql = "SELECT *
		FROM " . CONTACT_CONFIG_TABLE;

	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(CRITICAL_ERROR, 'Could not query config information', '', __LINE__, __FILE__, $sql);
	}
	while ($row = $db->sql_fetchrow($result))
	{
		$contact_config[$row['config_name']] = $row['config_value'];
	}

	$file_id = (!empty($_POST['file'])) ? $_POST['file'] : $_GET['file'];

	$msg_id = (!empty($_POST['id'])) ? $_POST['id'] : $_GET['id'];
	$msg_id = intval($msg_id);

	$confirm = isset($_POST['confirm']);

	if($confirm)
	{
		$filename = $_POST['file'];

		if(file_exists($filename))
		{
			@unlink($filename);
			clearstatcache();

			$sql = "UPDATE " . CONTACT_MSGS_TABLE . "
				SET upfile = ''
				WHERE msg_id = " . $msg_id;

			if(!$result = $db->sql_query($sql))
			{
				mx_message_die(GENERAL_ERROR, 'Could not update Contact table', '', __LINE__, __FILE__, $sql);
			}

			$message = $lang['File_del_success'] . "<br /><br />" . sprintf($lang['Click_return_msglog'], "<a href=\"" . mx_append_sid("admin_contact_log.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			mx_message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			clearstatcache();

			$sql = "UPDATE " . CONTACT_MSGS_TABLE . "
				SET upfile = ''
				WHERE msg_id = " . $msg_id;

			if(!$result = $db->sql_query($sql))
			{
				mx_message_die(GENERAL_ERROR, 'Could not update Contact table', '', __LINE__, __FILE__, $sql);
			}

			$message = $lang['File_Not_Here'] . "<br /><br />" . sprintf($lang['Click_return_msglog'], "<a href=\"" . mx_append_sid("admin_contact_log.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			mx_message_die(GENERAL_ERROR, $message);
		}
	}
	else
	{
		$template->set_filenames(array(
			'body' => 'admin/confirm_body.'.$tplEx)
		);

		$hidden_fields = '<input type="hidden" name="mode" value="remove" /><input type="hidden" name="id" value="' . $msg_id . '" /><input type="hidden" name="file" value="' . $file_id . '" />';

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Confirm'],
			'MESSAGE_TEXT'=> $lang['Confirm_delete_file'],

			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],

			'S_CONFIRM_ACTION' => mx_mx_append_sid("admin_contact_log.$phpEx"),
			'S_HIDDEN_FIELDS'=> $hidden_fields)
		);

		$template->pparse('body');
	}
}

if($mode == 'full')
{
	$msg_id = (!empty($_POST['id'])) ? $_POST['id'] : $_GET['id'];
	$msg_id = intval($msg_id);

	$template->set_filenames(array(
		'body' => 'admin/contact_fullmsg.'.$tplEx)
	);

	$sql = "SELECT *
		FROM " . CONTACT_MSGS_TABLE . "
		WHERE msg_id = " . $msg_id;

	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, 'Could not obtain message from database', '', __LINE__, __FILE__, $sql);
	}

	$message = $db->sql_fetchrow($result);

	$template->assign_vars(array(
		'MESSAGE' => $message['message'] . "<hr />")
	);

	$template->pparse('body');
}

if($mode == '')
{
	$sql = "SELECT *
		FROM " . CONTACT_MSGS_TABLE . "
		ORDER BY sendtime DESC
		LIMIT " . $start . ", " . (isset($board_config['topics_per_page']) ? $board_config['topics_per_page'] : 15);

	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, 'Couldnt obtain messages from database', '', __LINE__, __FILE__, $sql);
	}

	$messages = $db->sql_fetchrowset($result);

	$template->set_filenames(array(
		'body' => 'admin/contact_msgs.'.$tplEx)
	);

	$template->assign_vars(array(
		'L_MSGS_TITLE'	=> $lang['Contact_msgs_title'],
		'L_MSGS_TEXT'	=> $lang['Contact_msgs_text'],

		'L_DATE'	=> $lang['Contact_date'],
		'L_USER'	=> $lang['Username'],
		'L_NAME'	=> $lang['Real_name'],
		'L_NEWS'	=> $lang['Newsletter_intro'] ? $lang['Newsletter_intro'] : 'News',
		'L_EMAIL'	=> $lang['E-mail'],
		'L_MESSAGE'	=> $lang['Comments'],
		'L_IP'		=> $lang['Contact_ip'],
		'L_FILE'	=> $lang['Attachment'],
		'L_MSG_DELETE'	=> $lang['Msg_delete'],

		'COPYRIGHT'	=> $lang['Copyright'],

		'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
		'S_MSG_ACTION'		=> mx_append_sid("admin_contact_log.$phpEx"))
	);

	for($i=0, $msg_row = count($messages); $i < $msg_row; $i++)
	{
		$row_color = (!($i % 2)) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];

		//
		// Prevent Stretching of the Message Log screen
		// Based on "50 characters in message" mod by "Underhill"
		//
		if(preg_match("/([^[:blank:]]{30})/", $messages[$i]['message']))
		{
			$message_array = preg_split("/\n/", $messages[$i]['message']);
			for($j=0, $msgs = count($message_array); $j < $msgs; $j++)
			{
				$message_array[$j] = preg_replace("/([^[:blank:]]{30})/", "\\1 ", $message_array[$j]);
				$messages[$i]['message'] = implode("\n", $message_array);
			}
		}

		$preview = (strlen($messages[$i]['message']) > 100) ? true : false;

		if($preview)
		{
			$id		= $messages[$i]['msg_id'];
			$full_msg	= "...&nbsp;[<a href=" . mx_append_sid("admin_contact_log.$phpEx?mode=full&amp;id=$id") . " onclick=\"window.open('" . mx_append_sid("admin_contact_log.$phpEx?mode=full&amp;id=$id") . "', 'Message', 'left=100,top=100,height=300,width=300,resizable=yes,scrollbars=yes'); return false;\">" . $lang['more'] . "</a>]";
			$preview	= substr($messages[$i]['message'], 0, 100);
			$from		= strlen($lang['more'])+6;
			$preview	= substr_replace($preview, $full_msg, (100-$from), 100);
		}

		$template->assign_block_vars('messages', array(
			'ROW_COLOR'	=> "#" . $row_color,
			'ROW_CLASS'	=> $row_class,

			'DATE'		=> date("d-m-y", $messages[$i]['sendtime']),
			'TIME'		=> date("H:i", $messages[$i]['sendtime']),
			'MSG_ID'	=> $messages[$i]['msg_id'],
			'USER'		=> $messages[$i]['username'],
			'NAME'		=> $messages[$i]['realname'],
			'NEWS'		=> $messages[$i]['newsletter'] ? $lang['Yes'] : $lang['No'],			
			'EMAIL'		=> $messages[$i]['email'],
			'MESSAGE'	=> ($preview) ? $preview : $messages[$i]['message'],
			'IP'		=> contact_decode_ip($messages[$i]['ip']),
			'FILE'		=> $messages[$i]['upfile'],

			'L_DELETE'	=> $lang['Delete'],

			'S_THIS_ID'	=> 'msgid',
			'MSG_ID'	=> $messages[$i]['msg_id'],

			'U_GET_FILE'	=> (empty($messages[$i]['upfile'])) ? '' : sprintf($lang['Contact_get'], "<a href=\"" . $phpbb_root_path . $messages[$i]['upfile'] . "\">", "</a>"),
			'U_REMOVE_FILE'	=> (empty($messages[$i]['upfile'])) ? '' : sprintf($lang['Contact_remove'], "<a href=\"" . mx_append_sid("admin_contact_log.$phpEx?mode=remove&amp;id=" . $messages[$i]['msg_id'] . "&amp;file=" . $phpbb_root_path . $messages[$i]['upfile']) . "\">", "</a>"),
			'U_MSG_DELETE'	=> mx_append_sid("admin_contact_log.$phpEx?mode=delete"))
		);
	}

	$sql = "SELECT count(*) AS total
		FROM " . CONTACT_MSGS_TABLE;

	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, 'Error getting total', '', __LINE__, __FILE__, $sql);
	}

	if($total = $db->sql_fetchrow($result))
	{
		if($total['total'] > 0)
		{
			$total_pag_items = $total['total'];
			$pagination = phpBB2::generate_pagination("admin_contact_log.$phpEx?mode=$mode", $total_pag_items, (isset($board_config['topics_per_page']) ? $board_config['topics_per_page'] : 15), $start);
		}
	}

	$template->assign_vars(array(
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], (floor($start / (isset($board_config['topics_per_page']) ? $board_config['topics_per_page'] : 15)) +1), ceil($total_pag_items / (isset($board_config['topics_per_page']) ? $board_config['topics_per_page'] : 15))))
	);

	$template->pparse('body');
}

include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );

?>