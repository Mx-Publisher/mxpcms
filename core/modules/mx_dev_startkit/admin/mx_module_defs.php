<?php
/**
*
* @package MX-Publisher Module - mx_dev_startkit
* @version $Id: mx_module_defs.php,v 1.6 2008/06/03 20:07:27 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

if ( !empty( $setmodules ) )
{
	return;
}

/********************************************************************************\
| Class: mx_blockcp_parameter
| The mx_blockcp_parameter object provides extra module block parameters, added to the standard core parameters.
|
| Usage examples:
|
\********************************************************************************/

//
// The following flags are class specific options
//
//define('MX_ALL_DATA'		, -1);		// Flag - write all data

class mx_module_defs
{
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

		$type_row['startkit_module_select'] = !empty($lang['ParType_startkit_module_select']) ? $lang['ParType_startkit_module_select'] : "startkit_module_select";

		return $type_row;
	}

	// ===================================================
	// Submit custom parameter field and data
	// ===================================================
	function submit_module_parameters( $parameter_data, $block_id )
	{
		global $HTTP_POST_VARS, $db, $board_config, $html_entities_match, $html_entities_replace, $mx_request_vars, $mx_request_vars;

		$parameter_value = $mx_request_vars->request($parameter_data['parameter_id'], MX_TYPE_INT, 1);
		$parameter_opt = '';

		switch ( $parameter_data['parameter_type'] )
		{
			case 'startkit_module_select':
				// Nothing special to do for this simple integer
				break;
		}
		return array('parameter_value' => $parameter_value, 'parameter_opt' => $parameter_opt);
	}

	// ===================================================
	// display parameter field and data in the add/edit page
	// ===================================================
	function display_module_parameters( $parameter_data )
	{
		global $template, $mx_blockcp, $mx_root_path, $theme, $lang;

		switch ( $parameter_data['parameter_type'] )
		{
			case 'startkit_module_select':
				$this->display_edit_startkit_module_select( $block_id, $parameter_data['parameter_id'], $parameter_data );
				break;
		}
	}

	function display_edit_startkit_module_select( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang, $images, $mx_blockcp, $mx_root_path, $phpEx, $mx_table_prefix, $table_prefix;

		//
		// Includes
		//
		$module_root_path = $mx_root_path . $mx_blockcp->module_root_path;
		include_once( $module_root_path . 'includes/startkit_constants.' . $phpEx );

		//
		// Get varaibles
		//
		$parameter_datas = mx_get_list($parameter_id, MODULE_TABLE, 'module_id', 'module_name', $parameter_data['parameter_value'], true);

		//
		// Start page proper
		//
		$template->set_filenames(array(
			'parameter' => 'admin/mx_module_parameters.tpl')
		);

		$template->assign_block_vars( 'select', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',

			'SELECT_LIST'				=> $parameter_datas,

				'FIELD_NAME' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
				'FIELD_ID' 				=> $parameter_data['parameter_id'],
				'FIELD_DESCRIPTION' 	=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : ''
			));

		$template->pparse('parameter');		}
}
?>