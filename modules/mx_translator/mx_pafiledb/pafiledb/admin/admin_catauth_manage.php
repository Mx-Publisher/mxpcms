<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: admin_catauth_manage.php,v 1.9 2008/07/15 22:07:04 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) || !defined( 'IN_ADMIN' ) )
{
	die( "Hacking attempt" );
}

class pafiledb_catauth_manage extends pafiledb_admin
{
	function main( $module_id = false )
	{
		$action = $module_id;
		global $db, $images, $template, $template, $lang, $phpEx, $pafiledb_functions, $pafiledb_cache, $pafiledb_config, $phpbb_root_path, $module_root_path, $mx_root_path, $mx_request_vars;
		global $cat_auth_fields, $cat_auth_const, $cat_auth_levels, $global_auth_fields;
		global $cat_auth_approval_fields, $cat_auth_approval_const, $cat_auth_approval_levels;

		$custom_auth_approval = array();
		$custom_auth = array();

		$cat_auth_fields = array( 'auth_view', 'auth_read', 'auth_view_file', 'auth_edit_file', 'auth_delete_file', 'auth_upload', 'auth_download', 'auth_rate', 'auth_email', 'auth_view_comment', 'auth_post_comment', 'auth_edit_comment', 'auth_delete_comment' );
		$cat_auth_approval_fields = array( 'auth_approval', 'auth_approval_edit' );

		$field_names = array(
			'auth_view' => $lang['View'],
			'auth_read' => $lang['Read'],
			'auth_view_file' => $lang['View_file'],
			'auth_edit_file' => $lang['Edit_file'],
			'auth_delete_file' => $lang['Delete_file'],
			'auth_upload' => $lang['Upload'],
			'auth_approval' => $lang['Approval'],
			'auth_approval_edit' => $lang['Approval_edit'],
			'auth_download' => $lang['Download_file'],
			'auth_rate' => $lang['Rate'],
			'auth_email' => $lang['Email'],
			'auth_view_comment' => $lang['View_comment'],
			'auth_post_comment' => $lang['Post_comment'],
			'auth_edit_comment' => $lang['Edit_comment'],
			'auth_delete_comment' => $lang['Delete_comment'] );

		$cat_auth_levels = array( 'ALL', 'REG', 'PRIVATE', 'MOD', 'ADMIN' );
		$cat_auth_const = array( AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN );

		$cat_auth_approval_levels = array( 'NONE', 'MOD', 'ADMIN' );
		$cat_auth_approval_const = array( AUTH_ALL, AUTH_MOD, AUTH_ADMIN );

		$cat_parent = ( isset( $_REQUEST['cat_parent'] ) ) ? intval( $_REQUEST['cat_parent'] ) : 0;

		if ( isset( $_REQUEST['cat_id'] ) )
		{
			$cat_id = intval( $_REQUEST['cat_id'] );
			$cat_sql = "AND cat_id = $cat_id";
		}
		else
		{
			unset( $cat_id );
			$cat_sql = '';
		}

		//
		// Start program proper
		//
		if ( isset( $_POST['submit'] ) )
		{
			$temp_sql = array();

			for( $i = 0; $i < count( $cat_auth_fields ); $i++ )
			{
				foreach( $_POST[$cat_auth_fields[$i]] as $temp_cat_id => $value )
				{
					$temp_sql[$temp_cat_id] .= ( ( $temp_sql[$temp_cat_id] != '' ) ? ', ' : '' ) . $cat_auth_fields[$i] . ' = ' . $value;
				}
			}

			$sql = array();
			foreach( $temp_sql as $temp_cat_id => $update_sql )
			{
				$sql[] = "UPDATE " . PA_CATEGORY_TABLE . "
					SET $update_sql WHERE cat_id = $temp_cat_id";
			}

			unset( $temp_sql );

			if ( is_array( $sql ) && ( count( $sql ) > 0 ) )
			{
				foreach( $sql as $do_sql )
				{
					if ( !$db->sql_query( $do_sql ) )
					{
						mx_message_die( GENERAL_ERROR, 'Could not update auth table' . $do_sql, '', __LINE__, __FILE__, $sql );
					}
				}
			}

			$message = $lang['Category_auth_updated'] . '<br /><br />' . sprintf( $lang['Click_return_catauth'], '<a href="' . mx_append_sid( "admin_pafiledb.$phpEx?action=catauth_manage" ) . '">', "</a>" );
			mx_message_die( GENERAL_MESSAGE, $message );
		}

		// End of submit
		// Output the authorisation details if an id was
		// specified

		$template->set_filenames( array( 'body' => 'admin/pa_auth_cat_body.tpl' ) );

		$permissions_menu = array(
			mx_append_sid( "admin_pafiledb.$phpEx?action=catauth_manage" ) => $lang['Cat_Permissions'],
			mx_append_sid( "admin_pafiledb.$phpEx?action=ug_auth_manage&mode=user" ) => $lang['User_Permissions'],
			mx_append_sid( "admin_pafiledb.$phpEx?action=ug_auth_manage&mode=group" ) => $lang['Group_Permissions'],
			mx_append_sid( "admin_pafiledb.$phpEx?action=ug_auth_manage&mode=global_user" ) => $lang['User_Global_Permissions'],
			mx_append_sid( "admin_pafiledb.$phpEx?action=ug_auth_manage&mode=global_group" ) => $lang['Group_Global_Permissions']
		);

		foreach( $permissions_menu as $url => $l_name )
		{
			$template->assign_block_vars( 'pertype', array(
				'U_NAME' => $url,
				'L_NAME' => $l_name
			));
		}

		// Output values of individual
		// fields

		for( $j = 0; $j < count( $cat_auth_fields ); $j++ )
		{
			$cell_title = $field_names[$cat_auth_fields[$j]];

			$template->assign_block_vars( 'cat_auth_titles', array( 'CELL_TITLE' => $cell_title ) );
		}

		for( $j = 0; $j < count( $cat_auth_approval_fields ); $j++ )
		{
			$cell_title = $field_names[$cat_auth_approval_fields[$j]];

			$template->assign_block_vars( 'cat_auth_titles', array( 'CELL_TITLE' => $cell_title ) );
		}

		if ( empty( $cat_id ) )
		{
			$this->admin_display_cat_auth( $cat_parent );
			$cat_name = '';
		}
		elseif ( !empty( $cat_id ) )
		{
			$template->assign_block_vars( 'cat_row', array(
				'CATEGORY_NAME' => $this->cat_rowset[$cat_id]['cat_name'],
				'IS_HIGHER_CAT' => ( $this->cat_rowset[$cat_id] ) ? false : true,
				'U_CAT' => mx_append_sid( "admin_pafiledb.$phpEx?action=catauth_manage&cat_parent={$this->cat_rowset[$cat_id]['cat_parent']}" )
			));

			//
			// Standard auth fields
			//
			for( $j = 0; $j < count( $cat_auth_fields ); $j++ )
			{
				$custom_auth[$j] = '&nbsp;<select name="' . $cat_auth_fields[$j] . '[' . $cat_id . ']' . '">';

				for( $k = 0; $k < count( $cat_auth_levels ); $k++ )
				{
					$selected = ( $this->cat_rowset[$cat_id][$cat_auth_fields[$j]] == $cat_auth_const[$k] ) ? ' selected="selected"' : '';
					$custom_auth[$j] .= '<option value="' . $cat_auth_const[$k] . '"' . $selected . '>' . $lang['Category_' . $cat_auth_levels[$k]] . '</option>';
				}
				$custom_auth[$j] .= '</select>&nbsp;';

				$template->assign_block_vars( 'cat_row.cat_auth_data', array( 'S_AUTH_LEVELS_SELECT' => $custom_auth[$j] ) );
			}

			//
			// Standard auth fields
			//
			for( $j = 0; $j < count( $cat_auth_approval_fields ); $j++ )
			{
				$custom_auth_approval[$j] = '&nbsp;<select name="' . $cat_auth_approval_fields[$j] . '[' . $cat_id . ']' . '">';

				for( $k = 0; $k < count( $cat_auth_approval_levels ); $k++ )
				{
					$selected = ( $this->cat_rowset[$cat_id][$cat_auth_approval_fields[$j]] == $cat_auth_approval_const[$k] ) ? ' selected="selected"' : '';
					$custom_auth_approval[$j] .= '<option value="' . $cat_auth_approval_const[$k] . '"' . $selected . '>' . $lang['Category_' . $cat_auth_approval_levels[$k]] . '</option>';
				}
				$custom_auth_approval[$j] .= '</select>&nbsp;';

				$template->assign_block_vars( 'cat_row.cat_auth_data', array( 'S_AUTH_LEVELS_SELECT' => $custom_auth_approval[$j] ) );
			}

			$s_hidden_fields = '<input type="hidden" name="cat_id" value="' . $cat_id . '">';
			$cat_name = $this->cat_rowset[$cat_id]['cat_name'];
		}

		$s_column_span = count( $cat_auth_fields ) + count( $cat_auth_approval_fields ) + 2;

		$template->assign_vars( array(
			'CATEGORY_NAME' => $cat_name,

			'L_CATEGORY' => $lang['Category'],
			'L_AUTH_TITLE' => $lang['Auth_Control_Category'],
			'L_AUTH_EXPLAIN' => $lang['Category_auth_explain'],
			'L_SUBMIT' => $lang['Submit'],
			'L_RESET' => $lang['Reset'],

			'S_CATAUTH_ACTION' => mx_append_sid( "admin_pafiledb.$phpEx?action=catauth_manage" ),
			'S_COLUMN_SPAN' => $s_column_span,
			'S_HIDDEN_FIELDS' => $s_hidden_fields
		));

		// Output
		$template->pparse( 'body' );
		$this->_pafiledb();
		$pafiledb_cache->unload();
	}
}
?>