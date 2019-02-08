<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: mx_module_defs.php,v 1.14 2008/07/15 22:06:42 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

define( 'MXBB_MODULE', true );
define( 'MXBB_27x', @file_exists( $mx_root_path . 'mx_login.'.$phpEx ) );

/********************************************************************************\
| Class: mx_module_defs
| The mx_module_defs object provides additional module block parameters...
\********************************************************************************/

//
// The following flags are class specific options
//

// Flow control
define('MX_PANEL_DEBUG', false);

/**
 * Enter description here...
 *
 */
class mx_module_defs
{
	var $is_panel = false;
	// ------------------------------
	// Private Methods
	//
	//

	// ===================================================
	// define module specific block parameters
	// ===================================================
	function get_parameters($type_row = '')
	{
		global $lang;

		if (empty($type_row))
		{
			$type_row = array();
		}

		$type_row['pa_mapping'] = !empty($lang['ParType_pa_mapping']) ? $lang['ParType_pa_mapping'] : "pafileDB category mapping";
		$type_row['pa_quick_cat'] = !empty($lang['ParType_pa_quick_cat']) ? $lang['ParType_pa_quick_cat'] : "pafileDB default category";

		return $type_row;
	}

	// ===================================================
	// Submit custom parameter field and data
	// ===================================================
	function submit_module_parameters( $parameter_data, $block_id )
	{
		global $db, $board_config, $mx_blockcp, $mx_root_path, $phpEx;

		$parameter_value = $_POST[$parameter_data['parameter_id']];
		$parameter_opt = '';

		return array('parameter_value' => $parameter_value, 'parameter_opt' => $parameter_opt);
	}

	// ===================================================
	// display parameter field and data in the add/edit page
	// ===================================================
	function display_module_parameters( $parameter_data, $block_id )
	{
		global $template, $mx_blockcp, $mx_root_path, $theme, $lang;

		switch ( $parameter_data['parameter_type'] )
		{
			case 'pa_mapping':
				$this->display_edit_pa_mapping( $block_id, $parameter_data['parameter_id'], $parameter_data );
				break;

			case 'pa_quick_cat':
				$this->display_edit_pa_quick_cat( $block_id, $parameter_data['parameter_id'], $parameter_data );
				break;
		}
	}

	function display_edit_pa_quick_cat( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang, $images, $mx_blockcp, $mx_root_path, $phpEx, $mx_table_prefix, $table_prefix;
		global $mx_user, $module_root_path;

		//
		// Includes
		//
		$module_root_path = $mx_root_path . $mx_blockcp->module_root_path;
		include_once( $module_root_path . 'pafiledb/includes/pafiledb_constants.' . $phpEx );

		//
		// Get varaibles
		//
		$data = ( !empty( $parameter_data['parameter_value'] ) ) ? $parameter_data['parameter_value'] : '';
		$parameter_datas = $this->generate_jumpbox( 0, 0, array( $data => 1 ), false );

		//
		// Start page proper
		//
		$template->set_filenames(array(
			'parameter' => 'admin/mx_module_parameters.tpl')
		);

		$template->assign_block_vars( 'select', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',
			'L_NONE' 					=> $lang['None'],

			'SELECT_LIST'				=> $parameter_datas,

				'FIELD_NAME' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
				'FIELD_ID' 				=> $parameter_data['parameter_id'],
				'FIELD_DESCRIPTION' 	=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : ''
			));

		$template->pparse('parameter');
	}

	// ===================================================
	// Display cuztom Panel
	// ===================================================
	function display_edit_pa_mapping( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang, $images, $mx_blockcp, $mx_root_path, $phpEx, $mx_table_prefix, $table_prefix;
		global $userdata, $mx_request_vars;
		global $mx_user, $module_root_path;

		//
		// This is a PANEL - with it's own submit and reload interface
		//
		//$this->is_panel = true;

		//
		// Includes
		//
		$module_root_path = $mx_root_path . $mx_blockcp->module_root_path;
		include_once( $module_root_path . 'pafiledb/includes/pafiledb_constants.' . $phpEx );

		//
		// Mode setting
		//
		//$mode = $mx_request_vars->request('panel_mode', MX_TYPE_NO_TAGS, '');
		$action = $mx_request_vars->request('panel_action', MX_TYPE_NO_TAGS, '');

		//
		// SUBMIT?
		//
		if( !empty($action) )
		{
			//
			// Get vars
			//
			$portalpage = $mx_request_vars->request('portalpage', MX_TYPE_INT, 1);
			$id = $mx_request_vars->request('id', MX_TYPE_INT, '');

			//
			// Send to db functions
			//
			$result_message = $this->do_it($action, $id);

			//
			// If new
			//
			if (is_array($result_message))
			{
				$result_message = $result_message['text'];
			}

			//
			// Refresh mx_block object with new settings
			//
			$mx_blockcp->init($block_id, true);

		} // if .. !empty($mode)

		//
		// Start page proper
		//
		$template->set_filenames(array(
			'parameter' => 'admin/mx_module_panel.tpl')
		);

		$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $block_id . '" />';

		//
		// Get blockcp mode -> to set action file
		//
		$s_action_file = $mx_blockcp->blockcp_mode == 'mx_blockcp' ? 'modules/mx_coreblocks/mx_blockcp.php' : 'admin/admin_mx_block_cp.php';


		//
		// Define all actions
		//
		$deletemode = '?panel_action=' . MX_DO_DELETE . '&amp;id=' . $parameter_id . '&amp;block_id=' . $block_id;

		//
		// Hidden fields
		//
		$s_hidden_add_fields = 	'<input type="hidden" name="panel_action" value="' . MX_DO_INSERT . '" />
										<input type="hidden" name="id" value="' . $parameter_id . '" />
										<input type="hidden" name="block_id" value="' . $block_id . '" />
										<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		$s_hidden_update_fields = 	'<input type="hidden" name="panel_action" value="' . MX_DO_UPDATE . '" />
										<input type="hidden" name="id" value="' . $parameter_id . '" />
										<input type="hidden" name="block_id" value="' . $block_id . '" />
										<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		//
		// Get varaibles
		//
		$pa_map_cat = $this->generate_jumpbox( 0, 0, '', true );
		$pa_map_dynid = get_list_formatted( 'block_list', 0, 'map_dyn_id' );

		//
		// Main parameters
		//
		$template->assign_vars(array(
			//
			// Standards
			//
			'SID'						=> $userdata['session_id'],
			'RESULT_MESSAGE'			=> !empty($result_message) ? '<div style="overflow:auto; height:50px;"><span class="gensmall">' . $result_message  . '<br/> -::-</span></div>': '',

			'U_PHPBB_ROOT_PATH' 		=> PHPBB_URL,
			'TEMPLATE_ROOT_PATH' 		=> TEMPLATE_ROOT_PATH,

			'L_MAP_PAFILEDB' 			=> $lang['Map_pafiledb'],
			'L_MAP_MXBB' 				=> $lang['Map_mxbb'],

			'L_PANEL_TITLE' 			=> $lang['Panel_title'],
			'L_PANEL_TITLE_EXPLAIN' 	=> $lang['Panel_title_explain'],

			'L_ADD' 					=> $lang['Add_new'],
			'L_EDIT' 					=> $lang['Edit'],
			'L_DELETE' 					=> $lang['Delete'],
			'L_MOVE_UP' 				=> $lang['Move_up'],
			'L_MOVE_DOWN' 				=> $lang['Move_down'],
			'L_RESYNC' 					=> $lang['Resync'],
			'L_CHANGE_NOW' 				=> $lang['Change'],

			'S_MAP_CAT_LIST' 			=> $pa_map_cat,
			'S_MAP_DYN_LIST' 			=> $pa_map_dynid,

			'L_BLOCK' 					=> $lang['Block'],
			'S_HIDDEN_ADD_FIELDS' 		=> $s_hidden_add_fields,
			'S_HIDDEN_UPDATE_FIELDS' 	=> $s_hidden_update_fields,
			'S_ACTION'					=> mx_append_sid(PORTAL_URL . $s_action_file),
		));

		if( !empty($portalpage) )
		{
			$template->assign_block_vars('block_mode', array(
				'U_RETURN' => mx_append_sid(PORTAL_URL . "index.$phpEx?page=$portalpage")
			));
		}

		$pa_mapping_data = !empty($mx_blockcp->block_parameters['pa_mapping']['parameter_value']) ? unserialize( stripslashes( $mx_blockcp->block_parameters['pa_mapping']['parameter_value'] )) : array();

		//
		// Check that some categories exist
		//
		if ( $total_maps = count( $pa_mapping_data ) )
		{
			for( $i = 0; $i < $total_maps; $i++ )
			{
				$pa_map_cat_tmp = $this->generate_jumpbox( 0, 0, array( $pa_mapping_data[$i]['map_cat_id'] => 1 ), false );
				$pa_map_dynid_id = 'map_dyn_id_'.$i;
				$pa_map_dynid_tmp = get_list_formatted( 'block_list', $pa_mapping_data[$i]['map_dyn_id'], $pa_map_dynid_id );

				$pa_delete_url = mx_append_sid($mx_root_path . $s_action_file . $deletemode . '&amp;delete_id=' . $i . '&amp;sid=' . $userdata['session_id']);

				$template->assign_block_vars( 'map_row', array(
						'CAT_ID' => $i,
						'CAT_LIST' => $pa_map_cat_tmp,
						'DYN_ID' => $i,
						'DYN_LIST' => $pa_map_dynid_tmp,
						'DELETE' => $pa_delete_url,
						'L_DELETE' => $lang['Delete']
						) );
			}

		}

		$template->pparse('parameter');
	}

	function do_it( $action = '', $id = '' )
	{
		global $block_id, $mx_cache;

		switch ( $action )
		{
			case MX_DO_INSERT:
				$message = $this->_do_insert($id);
			break;

			case MX_DO_UPDATE:
				$message = $this->_do_update($id);
			break;

			case MX_DO_DELETE:
				$message = $this->_do_delete($id);
			break;

		}

		//
		// Update cache
		//
		$mx_cache->update(MX_CACHE_BLOCK_TYPE, $block_id);

		if (!empty($message))
		{
			return $message;
		}
	}

	/********************************************************************************\
	| Used by admin_mx_module.php, for the pak_import
	\********************************************************************************/
	function _do_insert( $id )
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $userdata, $mx_request_vars, $block_id, $mx_blockcp;

		if ( !MX_PANEL_DEBUG )
		{
			//
			// Get mapping
			//
			$pa_mapping_list = !empty($mx_blockcp->block_parameters['pa_mapping']['parameter_value']) ? unserialize( stripslashes( $mx_blockcp->block_parameters['pa_mapping']['parameter_value'] )) : array();

			//
			// Append mapping
			//
			$pa_mapping_list[] = array( 'map_cat_id' => intval( $_POST['map_cat_id'] ), 'map_dyn_id' => intval( $_POST['map_dyn_id'] ) );

			$pa_mapping_data = addslashes( serialize( $pa_mapping_list ));

			$sql1 = "UPDATE " . BLOCK_SYSTEM_PARAMETER_TABLE . "
			  		SET parameter_value = '" . $pa_mapping_data . "'
			  		WHERE block_id     = $block_id
			  	  		AND parameter_id = '".$mx_blockcp->block_parameters['pa_mapping']['parameter_id']."'";

			if ( !( $result = $db->sql_query( $sql1 ) ) )
			{
				mx_message_die( GENERAL_ERROR, $lang['News_update_error'], "", __LINE__, __FILE__, $sql[$i] );
			}

		}

		$message['text'] = $lang['AdminCP_action'] . ": " . $lang['Nav_menu_cat'] . ' (' . $mx_request_vars->post('cat_title', MX_TYPE_NO_TAGS, 'error - no name given') . ') ' . $lang['was_inserted'];
		$message['new_cat_menu_id'] = $cat_id_new;

		return $message;
	}

	/********************************************************************************\
	| Used by admin_mx_module.php, for the pak_import
	\********************************************************************************/
	function _do_update( $id )
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $userdata, $mx_request_vars, $block_id, $mx_blockcp;

		if ( !MX_PANEL_DEBUG )
		{
			$pa_mapping_list = !empty($mx_blockcp->block_parameters['pa_mapping']['parameter_value']) ? unserialize( stripslashes( $mx_blockcp->block_parameters['pa_mapping']['parameter_value'] )) : array();

			for ( $i = 0; $i < count($pa_mapping_list); $i++ )
			{
				$pa_cat_key = 'map_cat_id_' . $i;
				$pa_dyn_key = 'map_dyn_id_' . $i;

				$pa_mapping_list[$i] = array( 'map_cat_id' => intval( $_POST[$pa_cat_key] ), 'map_dyn_id' => intval( $_POST[$pa_dyn_key] ) );
			}

			$pa_mapping_data = addslashes( serialize( $pa_mapping_list ));

			$sql = "UPDATE " . BLOCK_SYSTEM_PARAMETER_TABLE . "
			  		SET parameter_value = '" . $pa_mapping_data . "'
			  		WHERE block_id     = $block_id
			  	  		AND parameter_id = '".$mx_blockcp->block_parameters['pa_mapping']['parameter_id']."'";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, $lang['News_update_error'], "", __LINE__, __FILE__, $sql[$i] );
			}

		}
		$message = $lang['AdminCP_action'] . ": " . $lang['Nav_menu_cat'] . ' (' . $mx_request_vars->post('cat_title', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'];

		return $message;
	}

	/********************************************************************************\
	| Used by admin_mx_module.php, for the pak_import
	\********************************************************************************/
	function _do_delete( $id )
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $mx_request_vars, $block_id, $mx_blockcp;

		if ( !MX_PANEL_DEBUG )
		{
			$pa_mapping_list = !empty($mx_blockcp->block_parameters['pa_mapping']['parameter_value']) ? unserialize( stripslashes( $mx_blockcp->block_parameters['pa_mapping']['parameter_value'] )) : array();

			$pa_mapping_list_tmp = array();

			for ( $i = 0; $i < count($pa_mapping_list); $i++ )
			{
				if ( $i != intval( $_GET['delete_id'] ) )
				{
					$pa_mapping_list_tmp[] = $pa_mapping_list[$i];
				}
			}

			$pa_mapping_data = addslashes( serialize( $pa_mapping_list_tmp ));

			$sql1 = "UPDATE " . BLOCK_SYSTEM_PARAMETER_TABLE . "
			  		SET parameter_value = '" . $pa_mapping_data . "'
			  		WHERE block_id     = $block_id
			  	  		AND parameter_id = '".$mx_blockcp->block_parameters['pa_mapping']['parameter_id']."'";

			if ( !( $result = $db->sql_query( $sql1 ) ) )
			{
				mx_message_die( GENERAL_ERROR, $lang['News_update_error'], "", __LINE__, __FILE__, $sql[$i] );
			}
		}

		$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . $lang['Nav_menu_cat'] . ' (ID: ' . $from_id . ') ' . $lang['was_deleted'] . '<br />' . $message_child;

		return $message;
	}

	// ===================================================
	// Jump menu function
	// $cat_id : to handle parent cat_id
	// $depth : related to function to generate tree
	// $default : the cat you wanted to be selected
	// $for_file: TRUE high category ids will be -1
	// $check_upload: if true permission for upload will be checked
	// ===================================================
	function generate_jumpbox( $cat_id = 0, $depth = 0, $default = '', $for_file = false, $check_upload = false )
	{
		global $db;

		static $cat_rowset = false;

		$sql = 'SELECT *
			FROM ' . PA_CATEGORY_TABLE . '
			ORDER BY cat_order ASC';

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query categories info', '', __LINE__, __FILE__, $sql );
		}
		$cat_rowset_temp = $db->sql_fetchrowset( $result );

		$db->sql_freeresult( $result );

		$cat_rowset = array();
		foreach( $cat_rowset_temp as $row )
		{
			$cat_rowset[$row['cat_id']] = $row;
		}

		//
		// Generate list
		//

		$cat_list .= '';

		$pre = str_repeat( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $depth );

		$temp_cat_rowset = $cat_rowset;

		if ( !empty( $temp_cat_rowset ) )
		{
			foreach ( $temp_cat_rowset as $temp_cat_id => $cat )
			{
				if ( $cat['cat_parent'] == $cat_id )
				{
					if ( is_array( $default ) )
					{
						if ( isset( $default[$cat['cat_id']] ) )
						{
							$sel = ' selected="selected"';
						}
						else
						{
							$sel = '';
						}
					}
					$cat_pre = ( !$cat['cat_allow_file'] ) ? '+ ' : '- ';
					$sub_cat_id = ( $for_file ) ? ( ( !$cat['cat_allow_file'] ) ? -1 : $cat['cat_id'] ) : $cat['cat_id'];
					$cat_class = ( !$cat['cat_allow_file'] ) ? 'class="greyed"' : '';
					$cat_list .= '<option value="' . $sub_cat_id . '"' . $sel . ' ' . $cat_class . ' />' . $pre . $cat_pre . $cat['cat_name'] . '</option>';
					$cat_list .= $this->generate_jumpbox( $cat['cat_id'], $depth + 1, $default, $for_file, $check_upload );
				}
			}
			return $cat_list;
		}
		else
		{
			return;
		}
	}
}
?>