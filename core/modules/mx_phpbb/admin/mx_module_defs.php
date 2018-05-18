<?php
/**
*
* @package Mx-Publisher Module - mx_phpbb
* @version $Id: mx_module_defs.php,v 1.2 2010/10/16 04:07:43 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] Mx-Publisher Project Team
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

		$type_row['phpbb_type_select'] = !empty($lang['ParType_phpbb_type_select']) ? $lang['ParType_phpbb_type_select'] : "phpBB Source";

		return $type_row;
	}

	// ===================================================
	// Submit custom parameter field and data
	// ===================================================
	function submit_module_parameters( $parameter_data, $block_id )
	{
		global $HTTP_POST_VARS, $db, $board_config, $mx_blockcp, $mx_root_path, $phpEx;
		global $html_entities_match, $html_entities_replace;

		$parameter_value = $HTTP_POST_VARS[$parameter_data['parameter_id']];
		$parameter_opt = '';

		switch ( $parameter_data['parameter_type'] )
		{
			case 'phpbb_type_select':
				$parameter_value = addslashes( serialize( $parameter_value ) );
				break;
		}
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
			case 'phpbb_type_select':
				$this->display_edit_Phpbb_type_select( $block_id, $parameter_data['parameter_id'], $parameter_data );
				break;
		}
	}

	function display_edit_Phpbb_type_select( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang, $images, $mx_blockcp, $mx_root_path, $phpEx, $mx_table_prefix, $table_prefix;
		global $mx_user, $module_root_path;

		$module_root_path = $mx_root_path . $mx_blockcp->module_root_path;
		include_once( $module_root_path . "includes/phpbb_constants.$phpEx" );
		include_once( $module_root_path . "includes/phpbb_defs.$phpEx" );

		$template->set_filenames(array(
			'parameter' => 'admin/mx_module_parameters.tpl')
		);

		// Get number of forums in db
		$sql = "SELECT *
			FROM " . NEWS_CAT_TABLE . "
			ORDER BY $cat_extract_order";
		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Couldn't obtain forums information.", "", __LINE__, __FILE__, $sql );
		}

		$forums = $db->sql_fetchrowset( $result );
		$db->sql_freeresult($result);

		// Get array of categories from the database

		$sql = "SELECT cat_id, cat_title
						FROM " . CATEGORIES_TABLE . "
						ORDER BY cat_order";
		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Couldn't obtain category list.", "", __LINE__, __FILE__, $sql );
		}

		$categories = $db->sql_fetchrowset( $result );
		$db->sql_freeresult($result);

		$phpbb_type_select_data = ( !empty( $mx_blockcp->block_parameters['Source_phpBB_Forums']['parameter_value'] ) ) ? unserialize($mx_blockcp->block_parameters['Source_phpBB_Forums']['parameter_value']) : array();

		//
		// Check that some categories exist
		//
		if ( $total_categories = count( $categories ) )
		{
			//
			// Check that some forums exist (these were queried earlier)
			//
			if ( $total_forums = count( $forums ) )
			{
				$template->assign_block_vars( 'switch_forums_phpbb', array( 'COLSPAN' => count( $item_types_array ) + 2
						) );

				for( $i = 0; $i < $total_categories; $i++ )
				{
					$template->assign_block_vars( 'catrow', array( 'CAT_ID' => $categories[$i]['cat_id'],
							'COLSPAN' => count( $item_types_array ) + 1,
							'CAT_NAME' => $categories[$i]['cat_title']
							) );

					for( $j = 0; $j < $total_forums; $j++ )
					{
						if ( $forums[$j]['cat_id'] == $categories[$i]['cat_id'] || $forums[$j]['cat_id'] == '' )
						{
							$template->assign_block_vars( 'catrow.forumrow_phpbb', array( 'FORUM_ID' => $forums[$j][$catt_id],
									'FORUM_NAME' => $forums[$j][$catt_name],
									'FORUM_DESC' => $forums[$j][$catt_desc],

									'CHECKED' => ( $phpbb_type_select_data[$forums[$j]['forum_id']] ? 'CHECKED' : '' ),
								));
						}
					}
				}
			}
		}

		$template->assign_vars(array(
			'SCRIPT_PATH' => $module_root_path,
			'MX_IMAGES_ROOT' =>  $mx_root_path . 'templates/subSilver/images/admin_icons/',
			'MX_ROOT_PATH' =>  $mx_root_path,
			'NAME' =>  $lang[$parameter_data['parameter_name']],
			'SELECT_NAME' =>  $parameter_data['parameter_id'],
			'PARAMETER_TITLE' => ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TYPE' => ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_EXPLAIN' => ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? '<br />' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"]  : '',

			'SCRIPT_PATH' => $module_root_path,
			'I_ANNOUNCE' => $images['phpbb_folder_announce'],
			'I_STICKY' => $images['phpbb_folder_sticky'],
			'I_NORMAL' => $images['phpbb_folder'],

			'L_ANNOUNCEMENT' => $lang['Post_Announcement'],
			'L_STICKY' => $lang['Post_Sticky'],
			'L_NORMAL' => $lang['Posted'],
		));

		$template->pparse('parameter');

	}
}
?>