<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: functions_mx.php,v 1.3 2008/06/03 20:12:40 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

if ( !function_exists( mx_smilies_pass ) )
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $message
	 * @return unknown
	 */
	function mx_smilies_pass($message)
	{
		global $board_config;
		$smilies_path = $board_config['smilies_path'];
		$board_config['smilies_path'] = PHPBB_URL . $board_config['smilies_path'];
		$message = smilies_pass($message);
		$board_config['smilies_path'] = $smilies_path;
		return $message;
	}
}

if ( !function_exists( mx_generate_smilies ) )
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $mode
	 * @param unknown_type $page_id
	 */
	function mx_generate_smilies($mode, $page_id)
	{
		global $board_config, $template, $phpEx;
		$smilies_path = $board_config['smilies_path'];
		$board_config['smilies_path'] = PHPBB_URL . $board_config['smilies_path'];
		generate_smilies($mode, $page_id);
		$board_config['smilies_path'] = $smilies_path;
		$template->assign_vars(array(
			'U_MORE_SMILIES' => mx_append_sid(PHPBB_URL . "posting.$phpEx?mode=smilies"))
		);
	}
}

if ( !function_exists( mx_message_die ) )
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $msg_code
	 * @param unknown_type $msg_text
	 * @param unknown_type $msg_title
	 * @param unknown_type $err_line
	 * @param unknown_type $err_file
	 * @param unknown_type $sql
	 */
	function mx_message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
	{
		global $db, $template, $board_config, $theme, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header, $images;
		global $userdata, $user_ip, $session_length;
		global $starttime;

		message_die($msg_code, $msg_text, $msg_title, $err_line, $err_file, $sql);
	}
}

if ( !function_exists( mx_is_group_member ) )
{
	/**
	 * Validates if user belongs to group included in group_ids list
	 * Also, adds all usergroups to userdata array
	 *
	 * @param unknown_type $group_ids
	 * @param unknown_type $group_mod_mode
	 * @return unknown
	 */
	function mx_is_group_member( $group_ids = '', $group_mod_mode = false )
	{
		global $userdata, $db;

		if ( $group_ids == '' )
		{
			return false;
		}

		$group_ids_array = explode(",", $group_ids);

		// Try to reuse usergroups result.
		if ( $group_mod_mode )
		{
			$userdata_key = 'mx_usergroups_mod' . $userdata['user_id'];

			if ( empty( $userdata[$userdata_key] )  )
			{
				// Check if user is group moderator..
				$sql = "SELECT gr.group_id
			  		FROM " . GROUPS_TABLE . " gr,
			      		" . USER_GROUP_TABLE . " ugr
		  			WHERE gr.group_id = ugr.group_id
		  			AND gr.group_moderator = '" . $userdata['user_id'] . "'
					AND ugr.user_pending = '0' ";

				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, "Could not query group rights information", '', '', '', '' );
				}

				$group_row = $db->sql_fetchrowset( $result );

				$userdata[$userdata_key_mod] = $group_row;
			}
		}
		else
		{
			$userdata_key = 'mx_usergroups' . $userdata['user_id'];

			if ( empty( $userdata[$userdata_key] ) )
			{
				// Check if user is member of the proper group..
				$sql = "SELECT group_id FROM " . USER_GROUP_TABLE . " WHERE user_id='" . $userdata['user_id'] . "' AND user_pending = 0";

				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, "Could not query group rights information", '', '', '', '' );
				}

				$group_row = $db->sql_fetchrowset( $result );

				$userdata[$userdata_key] = $group_row;
			}
		}

		for ( $i = 0; $i < count( $userdata[$userdata_key] ); $i++ )
		{
			if ( in_array( $userdata[$userdata_key][$i]['group_id'], $group_ids_array ) )
			{
				$is_member = true;
				return $is_member;
			}
		}

		return false;
	}
}

if ( !function_exists(mx_do_install_upgrade) )
{
	/**
	 * Generating output.
	 *
	 * @param unknown_type $sql
	 * @param unknown_type $main_install
	 * @return unknown
	 */
	function mx_do_install_upgrade( $sql = '', $main_install = false )
	{
		global $table_prefix, $mx_table_prefix, $userdata, $phpEx, $template, $lang, $db, $board_config;

		$inst_error = false;
		$n = 0;
		$message = "<b>This is the result list of the SQL queries needed for the install/upgrade</b><br /><br />";

		while ( $sql[$n] )
		{
			if ( !$result = $db->sql_query( $sql[$n] ) )
			{
				$message .= '<b><font color=#FF0000>[Error or Already added]</font></b> line: ' . ( $n + 1 ) . ' , ' . $sql[$n] . '<br />';
				$inst_error = true;
			}
			else
			{
				$message .= '<b><font color=#0000fF>[Added/Updated]</font></b> line: ' . ( $n + 1 ) . ' , ' . $sql[$n] . '<br />';
			}
			$n++;
		}
		$message .= '<br /> If you get some Errors, Already Added or Updated messages, relax, this is normal when updating modules';

		if ( $main_install )
		{
			if ( !$inst_error )
			{
				$message .= '-> no db errors :-)<br /><br /><b>Portal installed successfully! </b><hr><br /><br />';
				$message .= '1) Now, delete the /install and /contrib folders!!!<br /><br />';
				$message .= '2) If you haven\'t already done a db backup, now is the time ;)<br /><br />';
				$message .= '3) Then (after step 1), you HAVE to configure MX core and its modules from within the adminCP, simply \'upgrade\' MX portal Core and all modules in use!!!<br /><br />';
				$message .= 'Click <a href=../admin/admin_mx_module.php>Here</a> to administer/upgrade the portal/modules. You will be promted for an admin username and pass. The upgrade process provide informative output...';
			}
			else
			{
				$message .= '<br /><br /><b>Portal installed successfully (with some warnings)! </b><hr><br /><br />';
				$message .= '1) Now, delete the /install and /contrib folders!!!<br /><br />';
				$message .= '2) If you haven\'t already done a db backup, now is the time ;)<br /><br />';
				$message .= '3) Now (after step 1), you HAVE to configure MX core and its modules from within the adminCP, simply \'upgrade\' MX portal Core and all modules in use!!!<br /><br />';
				$message .= 'Click <a href=../admin/admin_mx_module.php>Here</a> to administer/upgrade the portal/modules. You will be promted for an admin username and pass. The upgrade process provide informative output...';
			}
		}
		return $message;
	}
}
?>