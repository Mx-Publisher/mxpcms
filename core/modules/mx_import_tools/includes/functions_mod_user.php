<?php
/**
*
* @package mxBB Portal Module - mx_import_tools
* @version $Id: functions_mod_user.php,v 1.11 2008/07/15 22:05:21 jonohlsson Exp $
* @copyright (c) 2002-2006 [Graham Eames, Jon Ohlsson] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mxbb.net
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

if( !function_exists('validate_username') )
{
	mx_cache::load_file('functions_validate', 'phpbb2');
}

if( !function_exists('prepare_message') )
{
	mx_cache::load_file('functions_post', 'phpbb2');
}

class user
{
	// These are the 3 critical values for any user
	var $username;
	var $user_password;
	var $user_email;

	var $user_id;
	// The remaining userdata fields are stored in an array
	var $user_fields;
	// This stores details of any usergroups that the user should be in
	var $groups;
	// The constructor for this class

	// The password must be in MD5 format, but we'll handle escaping any special
	// characters in any field within the function
	function user( $name, $password, $email )
	{
		global $board_config, $mx_bbcode;

		$this->username = $this->sql_escape( $name );
		$this->user_password = $this->sql_escape( $password );
		$this->user_email = $this->sql_escape( $email );

		$this->user_id = '';
		// Now we need to set the remaining fields to some default values
		// If you wish to integrate with another MOD, you should add any initilization
		// it requires after this
		$this->user_fields['user_regdate'] = time();
		$this->user_fields['user_from'] = '';
		$this->user_fields['user_occ'] = '';
		$this->user_fields['user_interests'] = '';
		$this->user_fields['user_website'] = '';
		$this->user_fields['user_icq'] = '';
		$this->user_fields['user_aim'] = '';
		$this->user_fields['user_yim'] = '';
		$user_fields['user_msnm'] = '';
		$this->user_fields['user_sig'] = '';
		$this->user_fields['user_sig_bbcode_uid'] = ( $board_config['allow_bbcode'] ) ? $mx_bbcode->make_bbcode_uid() : '';
		$this->user_fields['user_avatar'] = '';
		$this->user_fields['user_avatar_type'] = USER_AVATAR_NONE;
		$this->user_fields['user_viewemail'] = 1;
		$this->user_fields['user_attachsig'] = 1;
		$this->user_fields['user_allowsmile'] = $board_config['allow_smilies'];
		$this->user_fields['user_allowhtml'] = $board_config['allow_html'];
		$this->user_fields['user_allowbbcode'] = $board_config['allow_bbcode'];
		$this->user_fields['user_allow_viewonline'] = 1;
		$this->user_fields['user_notify'] = 0;
		$this->user_fields['user_notify_pm'] = 1;
		$this->user_fields['user_popup_pm'] = 1;
		$this->user_fields['user_timezone'] = $board_config['board_timezone'];
		$this->user_fields['user_dateformat'] = $board_config['default_dateformat'];
		$this->user_fields['user_lang'] = $board_config['default_lang'];
		$this->user_fields['user_style'] = $board_config['default_style'];
		$this->user_fields['user_level'] = USER;
		$this->user_fields['user_posts'] = 0;
		// addon entries
		$this->user_fields['user_realname'] = $name;
		$this->user_fields['user_list_option'] = '0110000000100000000000000000101';
	}
	// This function escapes any special characters in a string to allow for safe
	// use in the SQL query. It is used in the constructor and should be used on
	// any data passed to set_field()
	function sql_escape( $data )
	{
		return str_replace( "\'", "''", addslashes( $data ) );
	}
	// This function is used to set any of the user fields if you do not want to
	// use the default values. Any field listed in the array in this function
	// will have special characters escaped
	function set_field( $field_name, $data )
	{
		// It's not the most efficient, but we escape everything just to be safe
		$this->user_fields[$field_name] = $this->sql_escape( $data );
	}
	// This function allows you to set a specific user_id for this user
	// You should only call this if you know that the user_id you are specifying
	// is not already in use.
	// This is provided mainly for convertor use and not for normal use
	function set_user_id( $id )
	{
		$this->user_id = intval( $id );
	}
	// This function returns the user_id of the user.
	// It is only really useful after the call to insert_user()
	function get_user_id()
	{
		return $this->user_id;
	}
	// This function is used to set any usergroups the user should be added to
	// upon registration.
	// It can be called as many times as required
	function add_to_group( $group_id )
	{
		$this->groups[] = $group_id;
	}
	// This function validates the userdata to ensure that the user can be inserted
	// into the database. It checks for duplicate usernames, disallowed usernames,
	// invalid email addresses and disallowed email addresses

	// Returns true if the user can be inserted, false otherwise
	function validate_user()
	{
		$return_msg = array();
		$return_msg['is_ok'] = true;
		$return_msg['username_ok'] = true;
		$return_msg['mail_ok'] = true;

		$name_check = validate_username( stripslashes( str_replace( "''", "\'", $this->username ) ) );
		if ( $name_check['error'] )
		{
			echo('<br><b>username validation failed</b>: ' . $this->username );
			$return_msg['username_ok'] = false;
			$return_msg['is_ok'] =  false;
		}

		$email_check = validate_email( stripslashes( str_replace( "''", "\'", $this->user_email ) ) );
		if ( $email_check['error'] )
		{
			echo('<br><b>mail validation failed</b>: ' . $this->username );
			$return_msg['mail_ok'] = false;
			$return_msg['is_ok'] =   false;
		}
		return $return_msg;
	}
	// This is the function which actually inserts the user into the database

	// NB. This function does not validate the user allowing you to register names
	// and email addresses which might otherwise be disallowed, if you want to
	// validate the data you should call validate_user() first

	// Returns true on success, false otherwise
	function insert_user()
	{
		global $db;
		// Get the user_id if one has not already been set
		if ( $this->user_id == '' )
		{
			$sql = "SELECT MAX(user_id) AS total
				FROM " . USERS_TABLE;
			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not obtain next user_id information', '', __LINE__, __FILE__, $sql );
			}

			if ( !( $row = $db->sql_fetchrow( $result ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not obtain next user_id information', '', __LINE__, __FILE__, $sql );
			}
			$this->user_id = $row['total'] + 1;
		}
		// Build the main SQL query
		$sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate, user_password, user_email, user_icq, user_website, user_occ, user_from, user_interests, user_sig, user_sig_bbcode_uid, user_avatar, user_avatar_type, user_viewemail, user_aim, user_yim, user_msnm, user_attachsig, user_allowsmile, user_allowhtml, user_allowbbcode, user_allow_viewonline, user_notify, user_notify_pm, user_popup_pm, user_timezone, user_dateformat, user_lang, user_style, user_level, user_allow_pm, user_active, user_actkey, user_posts, user_realname) ";
		$sql .= "VALUES (" . $this->user_id . ", '" . $this->username . "', '" . $this->user_fields['user_regdate'] . "', '" . $this->user_password . "', '" . $this->user_email . "', '" . $this->user_fields['user_icq'] . "', '" . $this->user_fields['user_website'] . "', '" . $this->user_fields['user_occ'] . "', '" . $this->user_fields['user_from'] . "', '" . $this->user_fields['user_interests'] . "', '" . $this->user_fields['user_sig'] . "', '" . $this->user_fields['user_sig_bbcode_uid'] . "', '" . $this->user_fields['user_avatar'] . "', '" . $this->user_fields['user_avatar_type'] . "', " . $this->user_fields['user_viewemail'] . ", '" . str_replace( ' ', '+', $this->user_fields['user_aim'] ) . "', '" . $this->user_fields['user_yim'] . "', '" . $this->user_fields['user_msnm'] . "', " . $this->user_fields['user_attachsig'] . ", " . $this->user_fields['user_allowsmile'] . ", " . $this->user_fields['user_allowhtml'] . ", " . $this->user_fields['user_allowbbcode'] . ", " . $this->user_fields['user_allow_viewonline'] . ", " . $this->user_fields['user_notify'] . ", " . $this->user_fields['user_notify_pm'] . ", " . $this->user_fields['user_popup_pm'] . ", " . $this->user_fields['user_timezone'] . ", '" . $this->user_fields['user_dateformat'] . "', '" . $this->user_fields['user_lang'] . "', " . $this->user_fields['user_style'] . ", " . $this->user_fields['user_level'] . ", 1, 1, '', '" . $this->user_fields['user_posts'] . "', '" . $this->user_fields['user_realname'] . "')";

		// Insert the user

		if ( !( $result = $db->sql_query( $sql, BEGIN_TRANSACTION ) ) )
		{
			$error = true;
		}

		// Insert the personal group
		$sql = "INSERT INTO " . GROUPS_TABLE . " (group_name, group_description, group_single_user, group_moderator)
			VALUES ('', 'Personal User', 1, 0)";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			echo('error - couldn\'t insert user: ' . $this->username );
			$error = true;
		}


		$group_id = $db->sql_nextid();

		// Insert the user_group entry
		$sql = "INSERT INTO " . USER_GROUP_TABLE . " (user_id, group_id, user_pending)
			VALUES (" . $this->user_id . ", $group_id, 0)";
		if ( !( $result = $db->sql_query( $sql, END_TRANSACTION ) ) )
		{
			echo('error - couldn\'t insert user group: ' . $this->username );
			$error = true;
		}

		// Add the user to any applicable groups
		for ( $i = 0; $i < count( $this->groups ); $i++ )
		{
			$sql = "INSERT INTO " . USER_GROUP_TABLE . " (user_id, group_id, user_pending)
				VALUES (" . $this->user_id . ", " . $this->groups[$i] . ", 0)";
			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				echo('error - couldn\'t insert user speciell group: ' . $this->username );
				$error = true;
			}
		}

		return ( $error == true ) ? false : true;
	}

	// Returns true on success, false otherwise
	function move_user()
	{
		global $db;
		// Get the user_id if one has not already been set
		if ( $this->user_id == '' )
		{
			$sql = "SELECT user_id
				FROM " . USERS_TABLE . "
				WHERE username = '" . $this->username . "'" ;

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not obtain user_id information', '', __LINE__, __FILE__, $sql );
			}

			if ( !( $row = $db->sql_fetchrow( $result ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not obtain user_id information', '', __LINE__, __FILE__, $sql );
			}
			$this->user_id = $row['user_id'];
		}

		// Add the user to any applicable groups
		for ( $i = 0; $i < count( $this->groups ); $i++ )
		{

			//
			// First check if user is already in group
			//
				$sql = "SELECT *
				FROM " . USER_GROUP_TABLE . "
				WHERE user_id = '" . $this->user_id . "'
				AND group_id = '" . $this->groups[$i] . "'" ;

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not obtain user_id information', '', __LINE__, __FILE__, $sql );
			}

			if ( ( $row = $db->sql_fetchrow( $result ) ) )
			{
				echo('warning: user is already in this group');
				continue;
			}

			//
			// Move user to new group
			//
			$sql = "INSERT INTO " . USER_GROUP_TABLE . " (user_id, group_id, user_pending)
				VALUES (" . $this->user_id . ", " . $this->groups[$i] . ", 0)";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				echo('error - couldn\'t insert user speciell group: ' . $this->username );
				$error = true;
			}
		}

		return ( $error == true ) ? false : true;
	}

	// Returns true on success, false otherwise
	function update_user()
	{
		global $db;
		// Get the user_id if one has not already been set
		if ( $this->user_id == '' )
		{
			$sql = "SELECT user_id
				FROM " . USERS_TABLE . "
				WHERE username = '" . $this->username . "'" ;

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not obtain user_id information', '', __LINE__, __FILE__, $sql );
			}

			if ( !( $row = $db->sql_fetchrow( $result ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not obtain user_id information', '', __LINE__, __FILE__, $sql );
			}
			$this->user_id = $row['user_id'];
		}

		$sql = "UPDATE " . USERS_TABLE . "
				    SET user_password = '" . $this->user_password . "'
				    WHERE user_id = '" . $this->user_id . "'";

		$error = false;

		//
		// Update the user
		//
		if ( !( $result = $db->sql_query( $sql, BEGIN_TRANSACTION ) ) )
		{
			$error = true;
		}

		return ( $error == true ) ? false : true;
	}


}
// Now we have a few wrapper functions for those who don't need the full power
// of the class and just want to call a simple function
function insert_user( $username, $user_password, $user_email, $group_id = '' )
{
	$user = new user( $username, $user_password, $user_email );

	if ( $group_id != '' )
	{
		$user->add_to_group( $group_id );
	}

	$result = $user->validate_user();
	if ( $result )
	{
		$result = $user->insert_user();
	}
	return $result;
}
// ----------------------------------------------------------------
function search_csv( $dir_module = '../import/' )
{
	global $phpEx, $template;
	$csv_row = array();
	$dir_mod = @opendir( '../import/' );

	while ( $dir_module = @readdir( $dir_mod ) )
	{
		if ( $dir_module <> ".." )
		{
			$dir = @opendir( '../import/' . $dir_module );
			while ( $file = @readdir( $dir ) )
			{
				if ( preg_match( "/^.*?\.csv$/", $file ) )
				{
					$ret = $file;
					$csv_row[$ret] = $file;
				}
			}
			@closedir( $dir );
		}
	}
	return $csv_row;
}

function get_groups( $sel_id = -1 )
{
	global $db;

	$sql = "SELECT group_id, group_name, group_description
		FROM " . GROUPS_TABLE;

	if ( !$result = $db->sql_query( $sql ) )
	{
		mx_message_die( GENERAL_ERROR, "Couldn't get list of groups", "", __LINE__, __FILE__, $sql );
	}

	$grouplist = '<select name="add_to_group_id">';

	while ( $row = $db->sql_fetchrow( $result ) )
	{
		if ( $row['group_name'] != '' )
		{
			if ( $sel_id == $row['group_id'] )
			{
				$status = "selected";
			}
			else
			{
				$status = '';
			}
			$grouplist .= '<option value="' . $row['group_id'] . '" ' . $status . '>' . $row['group_name'] . ' (' . $row['group_description'] . ')' . '</option>';
		}
	}

	$grouplist .= '</select>';

	return $grouplist;
}

?>