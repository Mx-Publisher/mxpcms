<?php
/***************************************************************************
 *                             admin_groups.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: admin_groups.php,v 1.2 2009/01/24 16:48:09 orynider Exp $
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

define( 'IN_PORTAL', true );

if ( !empty( $setmodules ) )
{
	$filename = basename( __FILE__ );
	$module['phpbb2admin']['2_phpbb2admin_Groups'] = 'modules/mx_users/admin/' . $filename;
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

if ($mx_request_vars->is_request(POST_GROUPS_URL))
{
	$group_id = $mx_request_vars->request(POST_GROUPS_URL, MX_TYPE_INT);
}
else
{
	$group_id = 0;
}

if ($mx_request_vars->is_request('mode'))
{
	$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS);
}
else
{
	$mode = '';
}

if ($mx_request_vars->is_post('edit') || $mx_request_vars->is_post('new'))
{
	//
	// Ok they are editing a group or creating a new group
	//
	$template->set_filenames(array(
		'body' => 'admin/group_edit_body.tpl')
	);

	if ($mx_request_vars->is_post('edit') )
	{
		//
		// They're editing. Grab the vars.
		//
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'phpbb2':
				$sql = "SELECT *
					FROM " . GROUPS_TABLE . "
					WHERE group_single_user <> " . TRUE . "
					AND group_id = $group_id";
				break;
			case 'phpbb3':
				$sql = "SELECT *
					FROM " . GROUPS_TABLE . "
					WHERE group_name NOT IN ('BOTS', 'GUESTS')
					AND group_id = $group_id";
				break;
		}

		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
		}

		if ( !($group_info = $db->sql_fetchrow($result)) )
		{
			mx_message_die(GENERAL_MESSAGE, $lang['Group_not_exist']);
		}

		$mode = 'editgroup';
		$template->assign_block_vars('group_edit', array());

	}
	else if ($mx_request_vars->is_post('new') )
	{
		$group_info = array (
			'group_name' => '',
			'group_description' => '',
			'group_moderator' => '',
			'group_type' => GROUP_OPEN);
		$group_open = ' checked="checked"';

		$mode = 'newgroup';

	}

	//
	// Ok, now we know everything about them, let's show the page.
	//
	if ($group_info['group_moderator'] != '')
	{
		$sql = "SELECT user_id, username
			FROM " . USERS_TABLE . "
			WHERE user_id = " . $group_info['group_moderator'];
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, 'Could not obtain user info for moderator list', '', __LINE__, __FILE__, $sql);
		}

		if ( !($row = $db->sql_fetchrow($result)) )
		{
			mx_message_die(GENERAL_ERROR, 'Could not obtain user info for moderator list', '', __LINE__, __FILE__, $sql);
		}

		$group_moderator = $row['username'];
	}
	else
	{
		$group_moderator = '';
	}

	$group_open = ( $group_info['group_type'] == GROUP_OPEN ) ? ' checked="checked"' : '';
	$group_closed = ( $group_info['group_type'] == GROUP_CLOSED ) ? ' checked="checked"' : '';
	$group_hidden = ( $group_info['group_type'] == GROUP_HIDDEN ) ? ' checked="checked"' : '';

	$s_hidden_fields = '<input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group_id . '" />';

	$template->assign_vars(array(
		'GROUP_NAME' => $group_info['group_name'],
		'GROUP_DESCRIPTION' => $group_info['group_description'],
		'GROUP_MODERATOR' => $group_moderator,

		'L_GROUP_TITLE' => $lang['Group_administration'],
		'L_GROUP_EDIT_DELETE' => $mx_request_vars->is_post('new') ? $lang['New_group'] : $lang['Edit_group'],
		'L_GROUP_NAME' => $lang['group_name'],
		'L_GROUP_DESCRIPTION' => $lang['group_description'],
		'L_GROUP_MODERATOR' => $lang['group_moderator'],
		'L_FIND_USERNAME' => $lang['Find_username'],
		'L_GROUP_STATUS' => $lang['group_status'],
		'L_GROUP_OPEN' => $lang['group_open'],
		'L_GROUP_CLOSED' => $lang['group_closed'],
		'L_GROUP_HIDDEN' => $lang['group_hidden'],
		'L_GROUP_DELETE' => $lang['group_delete'],
		'L_GROUP_DELETE_CHECK' => $lang['group_delete_check'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],
		'L_DELETE_MODERATOR' => $lang['delete_group_moderator'],
		'L_DELETE_MODERATOR_EXPLAIN' => $lang['delete_moderator_explain'],
		'L_YES' => $lang['Yes'],

		'U_SEARCH_USER' => mx_append_sid("../search.$phpEx?mode=searchuser"),

		'S_GROUP_OPEN_TYPE' => GROUP_OPEN,
		'S_GROUP_CLOSED_TYPE' => GROUP_CLOSED,
		'S_GROUP_HIDDEN_TYPE' => GROUP_HIDDEN,
		'S_GROUP_OPEN_CHECKED' => $group_open,
		'S_GROUP_CLOSED_CHECKED' => $group_closed,
		'S_GROUP_HIDDEN_CHECKED' => $group_hidden,
		'S_GROUP_ACTION' => mx_append_sid("admin_groups.$phpEx"),
		'S_HIDDEN_FIELDS' => $s_hidden_fields)
	);

	$template->pparse('body');

}
else if ($mx_request_vars->is_post('group_update') )
{
	//
	// Ok, they are submitting a group, let's save the data based on if it's new or editing
	//
	if ($mx_request_vars->is_post('group_delete') )
	{
		//
		// Reset User Moderator Level
		//

		// Is Group moderating a forum ?
		$sql = "SELECT auth_mod FROM " . AUTH_ACCESS_TABLE . "
			WHERE group_id = " . $group_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, 'Could not select auth_access', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
		if (intval($row['auth_mod']) == 1)
		{
			// Yes, get the assigned users and update their Permission if they are no longer moderator of one of the forums
			$sql = "SELECT user_id FROM " . USER_GROUP_TABLE . "
				WHERE group_id = " . $group_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not select user_group', '', __LINE__, __FILE__, $sql);
			}

			$rows = $db->sql_fetchrowset($result);
			for ($i = 0; $i < count($rows); $i++)
			{
				$sql = "SELECT g.group_id FROM " . AUTH_ACCESS_TABLE . " a, " . GROUPS_TABLE . " g, " . USER_GROUP_TABLE . " ug
				WHERE (a.auth_mod = 1) AND (g.group_id = a.group_id) AND (a.group_id = ug.group_id) AND (g.group_id = ug.group_id)
					AND (ug.user_id = " . intval($rows[$i]['user_id']) . ") AND (ug.group_id <> " . $group_id . ")";
				if ( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not obtain moderator permissions', '', __LINE__, __FILE__, $sql);
				}

				if ($db->sql_numrows($result) == 0)
				{
					$sql = "UPDATE " . USERS_TABLE . " SET user_level = " . USER . "
					WHERE user_level = " . MOD . " AND user_id = " . intval($rows[$i]['user_id']);

					if ( !$db->sql_query($sql) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not update moderator permissions', '', __LINE__, __FILE__, $sql);
					}
				}
			}
		}

		//
		// Delete Group
		//
		$sql = "DELETE FROM " . GROUPS_TABLE . "
			WHERE group_id = " . $group_id;
		if ( !$db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, 'Could not update group', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . USER_GROUP_TABLE . "
			WHERE group_id = " . $group_id;
		if ( !$db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, 'Could not update user_group', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . AUTH_ACCESS_TABLE . "
			WHERE group_id = " . $group_id;
		if ( !$db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, 'Could not update auth_access', '', __LINE__, __FILE__, $sql);
		}

		$message = $lang['Deleted_group'] . '<br /><br />' . sprintf($lang['Click_return_groupsadmin'], '<a href="' . mx_append_sid("admin_groups.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . mx_append_sid("index.$phpEx?pane=right") . '">', '</a>');

		mx_message_die(GENERAL_MESSAGE, $message);
	}
	else
	{
		$group_type = $mx_request_vars->post('group_type', MX_TYPE_INT, GROUP_OPEN);
		$group_name = $mx_request_vars->post('group_name', MX_TYPE_NO_TAGS);
		$group_description = $mx_request_vars->post('group_description', MX_TYPE_NO_TAGS);
		$group_moderator = $mx_request_vars->post('username', MX_TYPE_NO_TAGS);
		$delete_old_moderator = $mx_request_vars->is_post('delete_old_moderator');

		if ( $group_name == '' )
		{
			mx_message_die(GENERAL_MESSAGE, $lang['No_group_name']);
		}
		else if ( $group_moderator == '' )
		{
			mx_message_die(GENERAL_MESSAGE, $lang['No_group_moderator']);
		}

		$this_userdata = mx_get_userdata($group_moderator, true);
		$group_moderator = $this_userdata['user_id'];

		if ( !$group_moderator )
		{
			mx_message_die(GENERAL_MESSAGE, $lang['No_group_moderator']);
		}

		if( $mode == "editgroup" )
		{
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'phpbb2':
					$sql = "SELECT *
						FROM " . GROUPS_TABLE . "
						WHERE group_single_user <> " . TRUE . "
						AND group_id = $group_id";
					break;
				case 'phpbb3':
					$sql = "SELECT *
						FROM " . GROUPS_TABLE . "
						WHERE group_name NOT IN ('BOTS', 'GUESTS')
						AND group_id = $group_id";
					break;
			}

			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
			}

			if( !($group_info = $db->sql_fetchrow($result)) )
			{
				mx_message_die(GENERAL_MESSAGE, $lang['Group_not_exist']);
			}

			if ( $group_info['group_moderator'] != $group_moderator )
			{
				if ( $delete_old_moderator )
				{
					$sql = "DELETE FROM " . USER_GROUP_TABLE . "
						WHERE user_id = " . $group_info['group_moderator'] . "
							AND group_id = " . $group_id;
					if ( !$db->sql_query($sql) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not update group moderator', '', __LINE__, __FILE__, $sql);
					}
				}

				$sql = "SELECT user_id
					FROM " . USER_GROUP_TABLE . "
					WHERE user_id = $group_moderator
						AND group_id = $group_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, 'Failed to obtain current group moderator info', '', __LINE__, __FILE__, $sql);
				}

				if ( !($row = $db->sql_fetchrow($result)) )
				{
					$sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending)
						VALUES (" . $group_id . ", " . $group_moderator . ", 0)";
					if ( !$db->sql_query($sql) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not update group moderator', '', __LINE__, __FILE__, $sql);
					}
				}
			}

			$sql = "UPDATE " . GROUPS_TABLE . "
				SET group_type = $group_type, group_name = '" . str_replace("\'", "''", $group_name) . "', group_description = '" . str_replace("\'", "''", $group_description) . "', group_moderator = $group_moderator
				WHERE group_id = $group_id";
			if ( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not update group', '', __LINE__, __FILE__, $sql);
			}

			$message = $lang['Updated_group'] . '<br /><br />' . sprintf($lang['Click_return_groupsadmin'], '<a href="' . mx_append_sid("admin_groups.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . mx_append_sid("index.$phpEx?pane=right") . '">', '</a>');;

			mx_message_die(GENERAL_MESSAGE, $message);
		}
		else if( $mode == 'newgroup' )
		{
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'phpbb2':
					$sql = "INSERT INTO " . GROUPS_TABLE . " (group_type, group_name, group_description, group_moderator, group_single_user)
						VALUES ($group_type, '" . str_replace("\'", "''", $group_name) . "', '" . str_replace("\'", "''", $group_description) . "', $group_moderator,	'0')";
					break;
				case 'phpbb3':
					$sql = "INSERT INTO " . GROUPS_TABLE . " (group_type, group_name, group_description, group_moderator)
						VALUES ($group_type, '" . str_replace("\'", "''", $group_name) . "', '" . str_replace("\'", "''", $group_description) . "', $group_moderator)";
					break;
			}

			if ( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not insert new group', '', __LINE__, __FILE__, $sql);
			}
			$new_group_id = $db->sql_nextid();

			$sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending)
				VALUES ($new_group_id, $group_moderator, 0)";
			if ( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not insert new user-group info', '', __LINE__, __FILE__, $sql);
			}

			$message = $lang['Added_new_group'] . '<br /><br />' . sprintf($lang['Click_return_groupsadmin'], '<a href="' . mx_append_sid("admin_groups.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . mx_append_sid("index.$phpEx?pane=right") . '">', '</a>');;

			mx_message_die(GENERAL_MESSAGE, $message);

		}
		else
		{
			mx_message_die(GENERAL_MESSAGE, $lang['No_group_action']);
		}
	}
}
else
{
	switch (PORTAL_BACKEND)
	{
		case 'internal':
		case 'phpbb2':
			$sql = "SELECT group_id, group_name
				FROM " . GROUPS_TABLE . "
				WHERE group_single_user <> " . TRUE . "
				ORDER BY group_name ASC";
			break;
		case 'phpbb3':
			$sql = "SELECT group_id, group_name
				FROM " . GROUPS_TABLE . "
				WHERE group_name NOT IN ('BOTS', 'GUESTS')
				ORDER BY group_name ASC";
			break;
	}

	if ( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not obtain group list', '', __LINE__, __FILE__, $sql);
	}

	$select_list = '';
	if ( $row = $db->sql_fetchrow($result) )
	{
		$select_list .= '<select name="' . POST_GROUPS_URL . '">';
		do
		{
			$select_list .= '<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
		}
		while ( $row = $db->sql_fetchrow($result) );
		$select_list .= '</select>';
	}

	$template->set_filenames(array(
		'body' => 'admin/group_select_body.tpl')
	);

	$template->assign_vars(array(
		'L_GROUP_TITLE' => $lang['Group_administration'],
		'L_GROUP_EXPLAIN' => $lang['Group_admin_explain'],
		'L_GROUP_SELECT' => $lang['Select_group'],
		'L_LOOK_UP' => $lang['Look_up_group'],
		'L_CP_UP' => $lang['Look_up_groupcp'],
		'L_CREATE_NEW_GROUP' => $lang['New_group'],

		'S_GROUP_ACTION' => mx_append_sid("admin_groups.$phpEx"),
		'S_GROUPCP_ACTION' => mx_append_sid("admin_groupcp.$phpEx"),
		'S_GROUP_SELECT' => $select_list)
	);

	if ( $select_list != '' )
	{
		$template->assign_block_vars('select_box', array());
	}

	$template->pparse('body');
}

include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );

?>