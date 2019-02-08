<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: admin_custom_manage.php,v 1.9 2008/07/15 22:07:04 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) || !defined( 'IN_ADMIN' ) )
{
	die( "Hacking attempt" );
}

class pafiledb_custom_manage extends pafiledb_admin
{
	function main( $module_id = false )
	{
		$action = $module_id;
		global $db, $images, $template, $template, $lang, $phpEx, $pafiledb_functions, $pafiledb_cache, $pafiledb_config, $phpbb_root_path, $module_root_path, $mx_root_path, $mx_request_vars;

		//
		// Init
		//
		$custom_field = new custom_field();
		$custom_field->init();

		$mode = ( isset( $_REQUEST['mode'] ) ) ? htmlspecialchars( $_REQUEST['mode'] ) : 'select';
		$field_id = ( isset( $_REQUEST['field_id'] ) ) ? intval( $_REQUEST['field_id'] ) : 0;
		$field_type = ( isset( $_REQUEST['field_type'] ) ) ? intval( $_REQUEST['field_type'] ) : $custom_field->field_rowset[$field_id]['field_type'];
		$field_ids = ( isset( $_REQUEST['field_ids'] ) ) ? $_REQUEST['field_ids'] : '';
		$submit = ( isset( $_POST['submit'] ) ) ? true : false;

		switch ( $mode )
		{
			case 'addfield':
				$template_file = 'admin/pa_admin_field_add.tpl';
				break;
			case 'editfield':
				$template_file = 'admin/pa_admin_field_add.tpl';
				break;
			case 'edit':
				$template_file = 'admin/pa_admin_select_field.tpl';
				break;
			case 'add':
				$template_file = 'admin/pa_admin_select_field_type.tpl';
				break;
			case 'delete':
				$template_file = 'admin/pa_admin_field_delete.tpl';
				break;
			case 'select':
				$template_file = 'admin/pa_admin_field.tpl';
				break;
		}

		if ( $submit )
		{
			if ( $mode == 'do_add' && !$field_id )
			{
				$custom_field->update_add_field( $field_type );

				$message = $lang['Fieldadded'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( 'admin_pafiledb.' . $phpEx . '?action=custom_manage' ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_admin_index'], '<a href="' . mx_append_sid( 'index.' . $phpEx . '?pane=right' ) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
			elseif ( $mode == 'do_add' && $field_id )
			{
				$custom_field->update_add_field( $field_type, $field_id );

				$message = $lang['Fieldedited'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( 'admin_pafiledb.' . $phpEx . '?action=custom_manage' ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_admin_index'], '<a href="' . mx_append_sid( 'index.' . $phpEx . '?pane=right' ) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
			elseif ( $mode == 'do_delete' )
			{
				foreach( $field_ids as $key => $value )
				{
					$custom_field->delete_field( $key );
				}

				$message = $lang['Fieldsdel'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( 'admin_pafiledb.' . $phpEx . '?action=custom_manage' ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_admin_index'], '<a href="' . mx_append_sid( 'index.' . $phpEx . '?pane=right' ) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
		}

		$template->set_filenames( array( 'admin' => $template_file ) );

		switch ( $mode )
		{
			case 'add':
			case 'addfield':
				$l_title = $lang['Afieldtitle'];
				break;
			case 'edit':
				$l_title = $lang['Efieldtitle'];
				break;
			case 'editfield':
				$l_title = $lang['Efieldtitle'];
				break;
			case 'delete':
				$l_title = $lang['Dfieldtitle'];
				break;
			case 'select':
				$l_title = $lang['Mfieldtitle'];
				break;
		}

		if ( $mode == 'add' )
		{
			$s_hidden_fields = '<input type="hidden" name="mode" value="addfield">';
		}
		elseif ( $mode == 'addfield' || $mode == 'editfield')
		{
			$s_hidden_fields = '<input type="hidden" name="field_type" value="' . $field_type . '">';
			$s_hidden_fields .= '<input type="hidden" name="field_id" value="' . $field_id . '">';
			$s_hidden_fields .= '<input type="hidden" name="mode" value="do_add">';
		}
		elseif ( $mode == 'edit' )
		{
			$s_hidden_fields = '<input type="hidden" name="mode" value="editfield">';
		}
		elseif ( $mode == 'delete' )
		{
			$s_hidden_fields = '<input type="hidden" name="mode" value="do_delete">';
		}

		$template->assign_vars( array(
			'L_FIELD_TITLE' => $l_title,
			'L_FIELD_EXPLAIN' => $lang['Fieldexplain'],
			'L_SELECT_TITLE' => $lang['Fieldselecttitle'],

			'S_HIDDEN_FIELDS' => $s_hidden_fields,
			'S_FIELD_ACTION' => mx_append_sid( "admin_pafiledb.$phpEx?action=custom_manage" )
		));

		if ( $mode == 'addfield' || $mode == 'editfield')
		{
			if ( $field_id )
			{
				$data = $custom_field->get_field_data( $field_id );
			}

			$template->assign_vars( array(
				'L_FIELD_NAME' => $lang['Fieldname'],
				'L_FIELD_NAME_INFO' => $lang['Fieldnameinfo'],
				'L_FIELD_DESC' => $lang['Fielddesc'],
				'L_FIELD_DESC_INFO' => $lang['Fielddescinfo'],
				'L_FIELD_DATA' => $lang['Field_data'],
				'L_FIELD_DATA_INFO' => $lang['Field_data_info'],
				'L_FIELD_REGEX' => $lang['Field_regex'],
				'L_FIELD_REGEX_INFO' => sprintf( $lang['Field_regex_info'], '<a href="http://www.php.net/manual/en/function.preg-match.php" target="_blank">', '</a>' ),
				'L_FIELD_ORDER' => $lang['Field_order'],

				'DATA' => ( $field_type != INPUT && $field_type != TEXTAREA ) ? true : false,
				'REGEX' => ( $field_type == INPUT || $field_type == TEXTAREA ) ? true : false,
				'ORDER' => ( $field_id ) ? true : false,

				'FIELD_NAME' => $data['custom_name'],
				'FIELD_DESC' => $data['custom_description'],
				'FIELD_DATA' => $data['data'],
				'FIELD_REGEX' => $data['regex'],
				'FIELD_ORDER' => $data['field_order']
			));
		}
		elseif ( $mode == 'add' )
		{
			$field_types = array( INPUT => $lang['Field_Input'], TEXTAREA => $lang['Field_Textarea'], RADIO => $lang['Field_Radio'], SELECT => $lang['Field_Select'], SELECT_MULTIPLE => $lang['Field_Select_multiple'], CHECKBOX => $lang['Field_Checkbox'] );

			$field_type_list = '<select name="field_type">';
			foreach( $field_types as $key => $value )
			{
				$field_type_list .= '<option value="' . $key . '">' . $value . '</option>';
			}
			$field_type_list .= '</select>';

			$template->assign_vars( array( 'S_SELECT_FIELD_TYPE' => $field_type_list ) );
		}
		elseif ( $mode == 'edit' || $mode == 'delete' || $mode == 'select' )
		{
			foreach( $custom_field->field_rowset as $field_id => $field_data )
			{
				$template->assign_block_vars( 'field_row', array(
					'FIELD_ID' => $field_id,
					'FIELD_NAME' => $field_data['custom_name'],
					'FIELD_DESC' => $field_data['custom_description']
				));
			}
		}

		// Output
		$template->pparse( 'admin' );
		$this->_pafiledb();
		$pafiledb_cache->unload();
	}
}
?>