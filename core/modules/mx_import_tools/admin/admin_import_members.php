<?php
/**
*
* @package mxBB Portal Module - mx_import_tools
* @version $Id: admin_import_members.php,v 1.9 2007/09/09 20:01:27 jonohlsson Exp $
* @copyright (c) 2002-2006 [Graham Eames, Jon Ohlsson] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mxbb.net
*
*/

define( 'IN_PORTAL', 1 );

if ( !empty( $setmodules ) )
{
	$filename = basename( __FILE__ );
	$module['Import_Tools']['Members'] = 'modules/mx_import_tools/admin/' . $filename;

	return;
}

$mx_root_path = '../../../';
$module_root_path = "../";
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require( $mx_root_path . '/admin/pagestart.' . $phpEx );
require( $module_root_path . 'includes/functions_mod_user.' . $phpEx );

/*
//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/functions_mod_user.' . $phpEx);
*/

if ( file_exists( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx ) )
{
	include( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx );
}elseif ( file_exists( $module_root_path . 'language/lang_english/lang_main.' . $phpEx ) )
{
	include( $module_root_path . 'language/lang_english/lang_main.' . $phpEx );
}
else
{
	mx_message_die( GENERAL_ERROR, 'Could not load the import tools language file.', 'File missing' );
}

if ( isset( $HTTP_POST_VARS['start'] ) || isset( $HTTP_GET_VARS['start'] ) )
{
	$template->set_filenames( array( 'body' => 'admin/import_message_body.tpl' )
		);

	$start = ( isset( $HTTP_POST_VARS['start'] ) ) ? $HTTP_POST_VARS['start'] : $HTTP_GET_VARS['start'];
	$import_rate = ( isset( $HTTP_POST_VARS['import_rate'] ) ) ? $HTTP_POST_VARS['import_rate'] : ( ( isset( $HTTP_GET_VARS['import_rate'] ) ) ? $HTTP_GET_VARS['import_rate'] : 250 );
	$file_name = $HTTP_POST_VARS['file_select'];

	$group_id = $HTTP_POST_VARS['add_to_group_id'];

	$add_to_group = ( isset( $HTTP_POST_VARS['add_to_group'] ) ) ? $HTTP_POST_VARS['add_to_group'] : '' ;

	$password_format = ( isset( $HTTP_POST_VARS['password_format'] ) ) ? $HTTP_POST_VARS['password_format'] : ( ( isset( $HTTP_GET_VARS['password_format'] ) ) ? $HTTP_GET_VARS['password_format'] : 'plain' );

	if ( !( $file_handle = fopen( '../import/' . $file_name, 'r' ) ) )
	{
		mx_message_die( GENERAL_ERROR, sprintf( $lang['import_file_missing_details'], $file_name ), $lang['import_file_missing'] );
	}
	// Loop through and read the whole file into an array using fgetcsv
	while ( !feof( $file_handle ) )
	{
		$members_file[] = fgetcsv( $file_handle, 1000, ';' );
	}
	fclose( $file_handle );
	// Now get the slice of the array we want based on the start and import_rate values
	$members_file_slice = array_slice( $members_file, $start, $import_rate );

	for( $i = 0; $i < count( $members_file_slice ); $i++ )
	{
		$member_data = $members_file_slice[$i];

		if ( $member_data != '' )
		{
			/*
			$username = $member_data[0];
			$email = $member_data[1];
			$user_password = $member_data[2];
			*/

			$username = $member_data[0];
			$user_password = $member_data[1];
			$email = $username . '@samskolan.se';

			if ( $password_format == 'plain' )
			{
				$user_password = md5( $user_password );
			}
			$user = new user( $username, $user_password, $email );

			if ( $add_to_group == 'yes' )
			{
				// Add to usergroup
				// Get group id
				$user->add_to_group( $group_id );
			}

			$user_check = $user->validate_user();

			if ( $user_check['is_ok'] )
			{
				//
				// Inserts new user (and adds to a group if $add_to_group == 'yes' )
				//
				echo('<br>username inserted: ' . $this->username );
				$user->insert_user();
			}
			else if ( !$user_check['username_ok'])
			{
				//
				// If user already exists, update the user info
				//
				echo('<br>username updated: ' . $this->username );
				$user->update_user();;
			}

			if ( !$user_check['username_ok'] && $add_to_group == 'yes' )
			{
				//
				// If user already exists, add/move the user to new group
				//
				echo('<br>username moved: ' . $this->username );
				$user->move_user();;
			}

		}
	}
	// Work out whether this is the end or we need another pass
	$next_start = $start + $import_rate;
	$members_file = array_slice( $members_file, $next_start, $import_rate );
	$user_count = count( $members_file );

	if ( $user_count > 0 )
	{
		$template->assign_vars( array( 'S_FORM_ACTION' => mx_append_sid( 'admin_import_members.' . $phpEx ),
				'MESSAGE_TITLE' => $lang['import_in_progress'],
				'MESSAGE_TEXT' => $lang['import_in_progress_members'] )
			);
		$template->assign_block_vars( 'switch_continue', array( 'CONTINUE_CAPTION' => $lang['import_continue'],
				'S_HIDDEN_FIELDS' => '<input type="hidden" name="start" value="' . $next_start . '" /><input type="hidden" name="import_rate" value="' . $import_rate . '" />' )
			);
	}
	else
	{
		$template->assign_vars( array( 'MESSAGE_TITLE' => $lang['import_complete'],
				'MESSAGE_TEXT' => $lang['import_complete_members'] )
			);
	}
}
else
{
	// Display the introduction screen and get some basic information
	$template->set_filenames( array( 'body' => 'admin/import_members_settings.tpl' )
		);

	$file_name = $HTTP_POST_VARS['file_select'];
	if ( empty( $file_name ) )
	{
		$csv_row = search_csv();
		$csv_list = get_list_static( "file_select", $csv_row, "" );
		// $s_hidden_fields = '<input type="hidden" name="mode" value="import_pack" />';
		// mx_message_die(GENERAL_MESSAGE, $lang['import_module_pack_explain'].' <br /><br /><form action="' . mx_append_sid(PORTAL_URL . 'admin/admin_mx_module.php') . '" method="post"> ' . $s_hidden_fields . $pak_list . ' <input type="submit" name="submit" value="' . $lang[Submit] . '" class="mainoption" /></form>' , $lang['import_module_pack']);
	}

	$group_list = get_groups();

	$template->assign_vars( array( 'L_IMPORT_TITLE' => $lang['Import_Tools'] . ' :: ' . $lang['Members'],
			'L_IMPORT_EXPLAIN' => $lang['import_explain_members'],
			'L_USERNAME' => $lang['Username'],
			'L_EMAIL' => $lang['Email'],
			'L_PASSWORD' => $lang['Password'],
			'L_IMPORT_SETTINGS' => $lang['import_settings'],
			'L_PASSWORD_FORMAT' => $lang['import_password_format'],
			'L_PASSWORD_FORMAT_EXPLAIN' => $lang['import_password_format_explain'],
			'L_PLAIN' => $lang['import_password_format_plain'],
			'L_MD5' => $lang['import_password_format_md5'],
			'L_IMPORT_RATE' => $lang['import_rate'],
			'L_IMPORT_RATE_EXPLAIN' => $lang['import_rate_explain'],
			'L_START_IMPORT' => $lang['import_start'],

			'L_CSV_LIST' => $lang['csv_list'],
			'L_CSV_LIST_EXPLAIN' => $lang['csv_list_explain'],

			'L_GROUP_LIST' => $lang['group_list'],
			'L_GROUP_LIST_EXPLAIN' => $lang['group_list_explain'],

			'L_YES' => $lang['group_yes'],
			'L_NO' => $lang['group_no'],

			'IMPORT_RATE_SELECT' => '<select name="import_rate"><option>2</option><option>100</option><option selected="selected">250</option><option>500</option><option>1000</option></select>',

			'CSV_LIST' => $csv_list,
			'GROUP_LIST' => $group_list,

			'S_FORM_ACTION' => mx_append_sid( 'admin_import_members.' . $phpEx ),
			'S_HIDDEN_FIELDS' => '<input type="hidden" name="start" value="0" />' )
		);
}

include_once( $mx_root_path . 'admin/page_header_admin.' . $phpEx );

$template->pparse( 'body' );

include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );

?>