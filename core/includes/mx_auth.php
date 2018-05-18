<?php
/** ------------------------------------------------------------------------
 *		subject				: mx-portal, CMS & portal
 *		begin            	: june, 2002
 *		copyright          	: (C) 2002-2005 MX-System
 *		email             	: jonohlsson@hotmail.com
 *		project site		: www.mx-system.com
 * 
 *		description			:
 * -------------------------------------------------------------------------
 * 
 *     $Id: mx_auth.php,v 1.3 2005/12/05 22:25:12 jonohlsson Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation; either version 2 of the License', or
 *     ('at your option) any later version.
 */

/**
 * Included functions in this file:
 * - block_auth
 * - page_auth
 * - menu_auth
 * - get_auth_forum
 * - mx_is_group_member (old mx_auth_group)
 * - mx_get_groups
 */

/********************************************************************************\
|	$type's accepted (pre-pend with AUTH_):
|	VIEW, READ, POST, REPLY, EDIT, DELETE, STICKY, ANNOUNCE, VOTE, POLLCREATE
|
|	Possible options ($type/module_id combinations):
|
|	* If you include a type and module_id then a specific lookup will be done and
|	the single result returned
|
|	* If you set type to AUTH_ALL and specify a module_id an array of all auth types
|	will be returned
|
|	* If you provide a module_id a specific lookup on that module will be done
|
|	* If you set module_id to AUTH_LIST_ALL and specify a type an array listing the
|	results for all modules will be returned
|
|	* If you set module_id to AUTH_LIST_ALL and type to AUTH_ALL a multidimensional
|	array containing the auth permissions for all types and all modules for that
|	user is returned
|
|	All results are returned as associative arrays, even when a single auth type is
|	specified.
|
|	If available you can send an array (either one or two dimensional) containing the
|	module auth levels, this will prevent the auth function having to do its own
|	lookup
\********************************************************************************/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

function block_auth($type, $module_id, $userdata, $f_access = '', $f_access_group = '')
{
	global $db, $lang;

	switch( $type )
	{
//		case AUTH_ALL:
//			$a_sql = 'a.auth_view, a.auth_edit, a.auth_delete';
//			$a_sql_groups = 'a.auth_view_group, a.auth_edit_group, a.auth_delete_group';
//			$auth_fields = array('auth_view', 'auth_edit', 'auth_delete');
//			$auth_fields_groups = array('auth_view_group', 'auth_edit_group', 'auth_delete_group');
//			break;

		case AUTH_VIEW:
			$a_sql = 'a.auth_view';
			$a_sql_groups = 'a.auth_view_group';
			$auth_fields = array('auth_view');
			$auth_fields_groups = array('auth_view_group');
			break;

		case AUTH_EDIT:
			$a_sql = 'a.auth_edit';
			$a_sql_groups = 'a.auth_edit_group';
			$auth_fields = array('auth_edit');
			$auth_fields_groups = array('auth_edit_group');
			break;

		case AUTH_DELETE:
			$a_sql = 'a.auth_delete';
			$a_sql_groups = 'a.auth_delete_group';
			$auth_fields = array('auth_delete');
			$auth_fields_groups = array('auth_delete_group');
			break;

		default:
			break;
	}

	if( $module_id == 0 )
	{
		if( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] )
		{
			$auth_user[$auth_fields[0]] = 1;
			$auth_user[$auth_fields[0] . '_type'] = $lang['Auth_Moderators'];
		}
		else
		{
			$auth_user[$auth_fields[0]] = 0;
			$auth_user[$auth_fields[0] . '_type'] = $lang['Auth_Moderators'];
		}
		return $auth_user;
	}

	$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;

	$auth_user = array();
	for( $i = 0; $i < count($auth_fields); $i++ )
	{
		$key = $auth_fields[$i]; 
		$key_groups = $auth_fields_groups[$i];
		//
		// If the user is logged on and the module type is either ALL or REG then the user has access
		//
		// If the type if ACL, MOD or ADMIN then we need to see if the user has specific permissions
		// to do whatever it is they want to do ... to do this we pull relevant information for the
		// user (and any groups they belong to)
		//
		// Now we compare the users access level against the modules. We assume here that a moderator
		// and admin automatically have access to an ACL module, similarly we assume admins meet an
		// auth requirement of MOD
		//
		$value = $f_access[$key];
		// $value_groups = $f_access_group[$key_groups];
		$value_groups = $f_access_group;

		switch( $value )
		{
			case AUTH_ALL:
				$auth_user[$key] = TRUE;
				$auth_user[$key . '_type'] = $lang['Auth_Anonymous_users'];
				break;

			case AUTH_REG:
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? TRUE : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Registered_Users'];
				break;

			case AUTH_ANONYMOUS:
				$auth_user[$key] = ( ! $userdata['session_logged_in'] ) ? TRUE : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Anonymous_users'];
				break;

			case AUTH_ACL: // PRIVATE
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($value_groups) || $is_admin : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Users_granted_access'];
				break;

			case AUTH_MOD:
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($f_access_group['auth_moderator_group']) || $is_admin : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Moderators'];
				break;

			case AUTH_ADMIN:
				$auth_user[$key] = $is_admin;
				$auth_user[$key . '_type'] = $lang['Auth_Administrators'];
				break;

			default:
				$auth_user[$key] = 0;
				break;
		}
	} 

	//
	// Is user a moderator?
	 $auth_user['auth_mod'] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($f_access_group['auth_moderator_group']) || $is_admin : 0;

	return $auth_user;
}

/********************************************************************************\
|
\********************************************************************************/
function page_auth($type, $userdata, $f_access = '', $f_access_group = '')
{
	global $db, $lang;

	$a_sql = 'a.auth_view';
	$a_sql_groups = 'a.auth_view_group';
	$auth_fields = array('auth_view');
	$auth_fields_groups = array('auth_view_group');

	$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;

	$auth_user = array();
	for( $i = 0; $i < count($auth_fields); $i++ )
	{
		$key = $auth_fields[$i];
		$key_groups = $auth_fields_groups[$i];

		$value = $f_access[$key];
		// $value_groups = $f_access_group[$key_groups];
		$value_groups = $f_access_group;

		switch( $value )
		{
			case AUTH_ALL:
				$auth_user[$key] = TRUE;
				$auth_user[$key . '_type'] = $lang['Auth_Anonymous_users'];
				break;

			case AUTH_REG:
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? TRUE : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Registered_Users'];
				break;

			case AUTH_ANONYMOUS:
				$auth_user[$key] = ( ! $userdata['session_logged_in'] ) ? TRUE : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Anonymous_users'];
				break;

			case AUTH_ACL: // PRIVATE
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($value_groups) || $is_admin : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Users_granted_access'];
				break;

			case AUTH_MOD:
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($f_access_group['auth_moderator_group']) || $is_admin : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Moderators'];
				break;

			case AUTH_ADMIN:
				$auth_user[$key] = $is_admin;
				$auth_user[$key . '_type'] = $lang['Auth_Administrators'];
				break;

			default:
				$auth_user[$key] = 0;
				break;
		}
	} 

	//
	// Is user a moderator?
	$auth_user['auth_mod'] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($f_access_group['auth_moderator_group']) || $is_admin : 0;

	return $auth_user;
}

/********************************************************************************\
|
\********************************************************************************/
function menu_auth($type, $menu_id, $userdata, $f_access = '', $f_access_group = '')
{
	global $db, $lang;

	switch( $type )
	{
		case AUTH_ALL:
			$a_sql = 'a.auth_view';
			$auth_fields = array('auth_view');
			break;

		case AUTH_VIEW:
			$a_sql = 'a.auth_view';
			$auth_fields = array('auth_view');
			break;

		default:
			break;
	}

	//
	// If f_access has been passed, or auth is needed to return an array of menus
	// then we need to pull the auth information on the given menu (or all menus)
	//
	$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;

	$auth_user = array();
	for( $i = 0; $i < count($auth_fields); $i++ )
	{
		$key = $auth_fields[$i]; 

		//
		// If the user is logged on and the menu type is either ALL or REG then the user has access
		//
		// If the type if ACL, MOD or ADMIN then we need to see if the user has specific permissions
		// to do whatever it is they want to do ... to do this we pull relevant information for the
		// user (and any groups they belong to)
		//
		// Now we compare the users access level against the menus. We assume here that a moderator
		// and admin automatically have access to an ACL menu, similarly we assume admins meet an
		// auth requirement of MOD
		//
		$value = $f_access[$key];

		switch( $value )
		{
			case AUTH_ALL:
				$auth_user[$key] = TRUE;
				$auth_user[$key . '_type'] = $lang['Auth_Anonymous_users'];
				break;

			case AUTH_REG:
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? TRUE : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Registered_Users'];
				break;

			case AUTH_ANONYMOUS:
				$auth_user[$key] = ( ! $userdata['session_logged_in'] ) ? TRUE : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Anonymous_users'];
				break;

			case AUTH_ACL:
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($f_access_group) || $is_admin : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Users_granted_access'];
				break;

			case AUTH_MOD:
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($f_access_group) || $is_admin : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Moderators'];
				break;

			case AUTH_ADMIN:
				$auth_user[$key] = $is_admin;
				$auth_user[$key . '_type'] = $lang['Auth_Administrators'];
				break;

			default:
				$auth_user[$key] = 0;
				break;
		}
	} 

	//
	// Is user a moderator?
	// $auth_user['auth_mod'] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($f_access_group) || $is_admin : 0;

	return $auth_user;
}

/********************************************************************************\
| New optimized get_auth_forum
| Credits to Markus_Petrux :-)
\********************************************************************************/
function get_auth_forum($mode = 'phpbb')
{
	global $userdata, $mx_root_path, $phpEx;

	//
	// Try to reuse auth_view query result.
	//
	$userdata_key = 'mx_get_auth_' . $mode . $userdata['user_id'];
	if( !empty($userdata[$userdata_key]) )
	{
		$auth_data_sql = $userdata[$userdata_key];
		return $auth_data_sql;
	}

	//
	// Now, this tries to optimize DB access involved in auth(),
	// passing AUTH_LIST_ALL will load info for all forums at once.
	//
	if( $mode == 'kb' )
	{
		include_once($mx_root_path . 'modules/mx_kb/includes/functions_kb_auth.' . $phpEx);
		$auth_func = 'kb_auth';
	}
	else
	{
		$auth_func = 'auth';
	}
	$is_auth_ary = $auth_func(AUTH_VIEW, AUTH_LIST_ALL, $userdata);

	//
	// Loop through the list of forums to retrieve the ids for
	// those with AUTH_VIEW allowed.
	//
	$auth_data_sql = '';
	foreach( $is_auth_ary as $fid => $is_auth_row )
	{
		if( $is_auth_row['auth_view'] )
		{
			$auth_data_sql .= ( $auth_data_sql != '' ) ? ', ' . $fid : $fid;
		}
	}

	if( empty($auth_data_sql) )
	{
		$auth_data_sql = -1;
	}

	$userdata[$userdata_key] = $auth_data_sql;
	return $auth_data_sql;
}

/********************************************************************************\
| Validates if user belongs to group included in group_ids list
| Also, adds all usergroups to userdata array
\********************************************************************************/
function mx_is_group_member($group_ids = '', $group_mod_mode = false)
{
	global $userdata, $db;

	if( empty($group_ids) )
	{
		return false;
	}

	//
	// Try to reuse group_id results.
	//
	$userdata_key = 'mx_usergroups' . ( $group_mod_mode ? '_mod' : '' ) . $userdata['user_id'];

	if( empty($userdata[$userdata_key]) )
	{
		if( $group_mod_mode )	// Get the groups the user is moderator of.
		{
			$sql = "SELECT group_id FROM " . GROUPS_TABLE . "
				WHERE group_moderator = '" . $userdata['user_id'] . "' AND group_single_user = 0";
		}
		else					// Get the groups the user is member of.
		{
			$sql = "SELECT group_id FROM " . USER_GROUP_TABLE . "
				WHERE user_id = '" . $userdata['user_id'] . "' AND user_pending = 0";
		}
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Could not query group rights information");
		}
		$userdata[$userdata_key] = $db->sql_fetchrowset($result);
	}

	$group_ids_array = explode(',', $group_ids);

	for( $i = 0; $i < count($userdata[$userdata_key]); $i++ )
	{
		if( in_array($userdata[$userdata_key][$i]['group_id'], $group_ids_array) )
		{
			return true;
		}
	}
	return false;
}

/********************************************************************************\
|
\********************************************************************************/
function mx_get_groups($sel_id, $field_entry = 'auth_view_group')
{
 	global $db, $lang;

	$sql = "SELECT group_id, group_name
		FROM " . GROUPS_TABLE . "
		WHERE group_single_user <> " . TRUE . "
		ORDER BY group_name";

	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't get list of groups", '', __LINE__, __FILE__, $sql);
	}

	$grouplist = '<select name="'.$field_entry.'">';
	$grouplist .= '<option value="0">' . $lang['Select_group'] . '</option>';

	while( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $sel_id == $row['group_id'] ? ' selected="selected"' : '' );
		$grouplist .= '<option value="' .$row['group_id'] . '"' . $selected . '>' . $row['group_name'] . '</option>';
	}

	$grouplist .= '</select>';
	return $grouplist;
}

?>