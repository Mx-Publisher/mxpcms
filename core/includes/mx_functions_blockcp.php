<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: mx_functions_blockcp.php,v 1.1 2010/10/10 14:59:41 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */
 
if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/********************************************************************************\
| Class: mx_blockcp
| The mx_blockcp class provides a Block Control Panel, extending the mx_block class. 
| This class will load additional module specific parameters, eg advanced textblocks (bbcode/html/mxBB/wysiwyg) and serialized data types
| 
| This class is instantiated in admin_mx_block_cp.php (adminCP mode) or in coreblocks/blockcp.php (user mode)
| 
| // 
| // Methods
| // 
| $mx_blockcp->generate_cp($block_id);
|
| //
| // Usage examples:
| //
| 
| 	
\********************************************************************************/
define('MX_BLOCKCP_DEBUG'				, false);	

class mx_blockcp extends mx_block
{
	//
	// Define blockcp mode: 'mx_blockcp' or 'admin_mx_block_cp'
	//
	var $blockcp_mode = 'mx_blockcp';
	 
	// ------------------------------
	// Private Methods
	//
	//
	
	// ******************************************************************
	// DIALOG
	// ******************************************************************
	function _controlpanel( $id, $new_block )
	{
		global $blockcptemplate, $lang, $db, $board_config, $theme, $HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $phpEx, $mx_root_path, $s_hidden_fields, $userdata, $portalpage, $cookie_states, $module_nav_icon_url, $portalpage, $mx_request_vars;
		
		$dynamic_block_id = $mx_request_vars->request('dynamic_block', MX_TYPE_INT, '');
		
		if (empty($id))
		{
			die('Invalid block panel call - no id');
		}

		//
		// Main parameters
		//
		$block_keys = array( 'block_title' => 'block_title', 'block_desc' => 'block_desc', 'show_block' => 'show_block', 'show_title' => 'show_title', 'show_stats' => 'show_stats');
		
		//
		// General
		//
		$mode_general = MX_BLOCK_TYPE;
		$mode_permissions = MX_BLOCK_PRIVATE_TYPE;
		$mode_settings = MX_BLOCK_SETTINGS_TYPE;
			
		$block_id = $id;
		$module_id = $mx_request_vars->is_request('module_id') ? $mx_request_vars->request('module_id', MX_TYPE_INT, '') : mx_parent_data($block_id, 'module_id');
		$function_id = $mx_request_vars->is_request('function_id') ? $mx_request_vars->request('function_id', MX_TYPE_INT, '') : mx_parent_data($block_id, 'function_id');

		//
		// Define auth constants
		//
		$block_auth_fields = array('auth_view', 'auth_edit');	// , 'auth_delete'
			
		$block_auth_ary = array(
			'auth_view'		=> AUTH_ALL,
			'auth_edit'		=> AUTH_ADMIN,
		);
			
		$block_auth_levels = array('ALL', 'REG', 'PRIVATE', 'MOD', 'ADMIN', 'ANONYMOUS');
		$block_auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN, AUTH_ANONYMOUS);
		$field_names = array(
			'auth_view'		=> $lang['View'],
			'auth_edit'		=> $lang['Edit'],
		);
				
		//
		// Update block
		//
		$action = MX_DO_UPDATE;
		$buttonvalue = $lang['Update'];
			
		$block_title = ( isset($HTTP_POST_VARS[$block_keys['block_title']]) ) ? stripslashes(htmlspecialchars($HTTP_POST_VARS[$block_keys['block_title']])) : $this->$block_keys['block_title'];
		$block_desc = ( isset($HTTP_POST_VARS[$block_keys['block_desc']]) ) ? stripslashes(htmlspecialchars($HTTP_POST_VARS[$block_keys['block_desc']])) : $this->$block_keys['block_desc'];
		$show_block = ( isset($HTTP_POST_VARS[$block_keys['show_block']]) ) ? intval($HTTP_POST_VARS[$block_keys['show_block']]) : intval($this->$block_keys['show_block']);
		$show_title = ( isset($HTTP_POST_VARS[$block_keys['show_title']]) ) ? intval($HTTP_POST_VARS[$block_keys['show_title']]) : intval($this->$block_keys['show_title']);
		$show_stats = ( isset($HTTP_POST_VARS[$block_keys['show_stats']]) ) ? intval($HTTP_POST_VARS[$block_keys['show_stats']]) : intval($this->$block_keys['show_stats']);

		//
		// Add block
		//		
		$action_add = MX_DO_INSERT;
		$buttonvalue_add = $lang['Create_block'];
			
		$show_title_yes_add = 'checked="checked"';
		$show_title_no_add = '';
		
		$show_block_yes_add = 'checked="checked"';
		$show_block_no_add = '';
			
		$show_stats_yes_add = '';
		$show_stats_no_add = 'checked="checked"';
			
		//
		// Now get started
		//	
		$functionlist = get_list_formatted('function_list', $function_id);

		/*
		//
		// Populate missing parameters (if any)
		//
		$sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . " (block_id, parameter_id, parameter_value)
			SELECT " . $block_id . ", parameter_id,   parameter_default
				FROM " . PARAMETER_TABLE . " par " . " WHERE function_id = " . $block_row['function_id'];
		
		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't insert parameter information", "", __LINE__, __FILE__, $sql);
		}
		*/
		
		//
		// Hidden fields
		//
		$s_hidden_fields .= 	'<input type="hidden" name="mode" value="' . $mode . '" />
								<input type="hidden" name="action" value="' . $action . '" />';
			
			
		$show_title_yes = ( $show_title == 1 ) ? 'checked="checked"' : '';
		$show_title_no = ( $show_title == 0 ) ? 'checked="checked"' : '';
		
		$show_block_yes = ( $show_block == 1 ) ? 'checked="checked"' : '';
		$show_block_no = ( $show_block == 0 ) ? 'checked="checked"' : '';
			
		$show_stats_yes = ( $show_stats == 1 ) ? 'checked="checked"' : '';
		$show_stats_no = ( $show_stats == 0 ) ? 'checked="checked"' : '';

		//
		// Define some graphics
		//
		$module_nav_icon_url = PORTAL_URL . TEMPLATE_ROOT_PATH . 'images/admin_icons/';
		
		$admin_icon['contract'] = $module_nav_icon_url . 'contract.gif';
		$admin_icon['expand'] = $module_nav_icon_url . 'expand.gif';
		
		$admin_icon['module'] = $module_nav_icon_url . 'icon_module.gif';
		$admin_icon['function'] = $module_nav_icon_url . 'icon_function.gif';
		$admin_icon['parameter'] = $module_nav_icon_url . 'icon_parameter.gif';
		$admin_icon['block'] = $module_nav_icon_url . 'icon_block.gif';
		$admin_icon['edit_block'] = $module_nav_icon_url . 'icon_edit.gif';
		
		//
		// JS
		//
		
		$cookie_tmp = $board_config['cookie_name'].'_adminBlockCP_mode';
		$cookie_blockCP = !empty($HTTP_COOKIE_VARS[$cookie_tmp]) ? $HTTP_COOKIE_VARS[$cookie_tmp] : 'settings';

		//
		// Send General Vars to template
		//
		$visible_general_add = $cookie_blockCP == 'general_add';
		$visible_general = $cookie_blockCP == 'general';
		$visible_settings = $cookie_blockCP == 'settings';
		$visible_private = $cookie_blockCP == 'private';
		$visible_delete = $cookie_blockCP == 'delete';
		
		$blockcptemplate->assign_vars(array(
			'VISIBLE_GENERAL_ADD' 				=> $visible_general_add ? 'block' : 'none',
			'VISIBLE_GENERAL' 					=> $visible_general ? 'block' : 'none',
			'VISIBLE_SETTINGS' 					=> $visible_settings ? 'block' : 'none',
			'VISIBLE_PRIVATE' 					=> $visible_private ? 'block' : 'none',
			'VISIBLE_DELETE' 					=> $visible_delete ? 'block' : 'none',
			'IMG_URL_GENERAL_ADD' 				=> $visible_general_add ? $admin_icon['contract'] : $admin_icon['expand'],
			'IMG_URL_GENERAL' 					=> $visible_general ? $admin_icon['contract'] : $admin_icon['expand'],
			'IMG_URL_SETTINGS' 					=> $visible_settings ? $admin_icon['contract'] : $admin_icon['expand'],
			'IMG_URL_PRIVATE' 					=> $visible_private ? $admin_icon['contract'] : $admin_icon['expand'],
			'IMG_URL_DELETE' 					=> $visible_delete ? $admin_icon['contract'] : $admin_icon['expand'],
			
			'L_TITLE' => $lang['Block_admin'],
			'L_EXPLAIN' => $lang['Block_admin_explain'],	
			
			'SID'				=> $userdata['session_id'],
		
			//
			// General
			//
			"L_ACTION" => $lang['Action'],
			"L_DELETE" => $lang['Delete'],
			"L_UPDATE" => $lang['Update'],
			'L_SETTING' => $lang['Settings'],
			'L_VIEW' => $lang['View'],
			"L_EDIT" => $lang['Edit'],
			"L_ADD" => $lang['Create_parameter'],
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],	
			
			'L_SETTING' => $new_block ? '' : $l_setting,
			'L_DELETE' => $new_block ? '' : $lang['Delete'],
			'L_EDIT' => $new_block ? '' : $lang['Edit'],
									
			'L_AUTH_TITLE' => $lang['Auth_Block'],
			'L_AUTH_TITLE_EXPLAIN' => $lang['Auth_Block_explain'],
			'L_FUNCTION' => $lang['Function'],
						
			'L_BLOCK_TITLE' 	=> $lang['Block_title'],
			'L_BLOCK_DESC' 		=> $lang['Block_desc'],
			'L_SHOW_BLOCK' 		=> $lang['Show_block'],
			'L_SHOW_BLOCK_EXPLAIN' => $lang['Show_block_explain'],
			'L_SHOW_TITLE' 		=> $lang['Show_title'],
			'L_SHOW_TITLE_EXPLAIN' => $lang['Show_title_explain'],
			'L_SHOW_STATS' 		=> $lang['Show_stats'],
			'L_SHOW_STATS_EXPLAIN' => $lang['Show_stats_explain'],
				
			'BLOCK_ID' => $block_id,
			'BLOCK_TITLE' => $new_block ? '<span class="cattitle">'. $lang['Create_block'] . '</span>' : '&nbsp;&nbsp;' . $block_title,
			'BLOCK_DESC' => ( $block_desc != '' ) ? ' - ' . $block_desc : '',

			'U_BLOCK_SETTINGS' => mx_append_sid(PORTAL_URL . "admin/admin_mx_blockcp.$phpEx?block_id=$block_id"),
			'U_BLOCK_DELETE' => mx_append_sid(PORTAL_URL . "admin/admin_mx_block.$phpEx?mode=delete_block&amp;block_id=$block_id"),
			'U_BLOCK_PERMISSIONS' => mx_append_sid(PORTAL_URL . "admin/admin_mx_block_auth.$phpEx?cat_id=$block_id"),
		
			'E_BLOCK_TITLE' => $block_title,
			'E_BLOCK_DESC' => $block_desc,
				
			'S_FUNCTION_LIST' => $functionlist,
			
			//
			// Update
			//
			'S_SHOW_BLOCK_YES' => $show_block_yes,
			'S_SHOW_BLOCK_NO' => $show_block_no,
			
			'S_SHOW_TITLE_YES' => $show_title_yes,
			'S_SHOW_TITLE_NO' => $show_title_no,
			
			'S_SHOW_STATS_YES' => $show_stats_yes,
			'S_SHOW_STATS_NO' => $show_stats_no,
			
			//
			// Add
			//
			'S_SHOW_BLOCK_YES_ADD' => $show_block_yes_add,
			'S_SHOW_BLOCK_NO_ADD' => $show_block_no_add,
			
			'S_SHOW_TITLE_YES_ADD' => $show_title_yes_add,
			'S_SHOW_TITLE_NO_ADD' => $show_title_no_add,
			
			'S_SHOW_STATS_YES_ADD' => $show_stats_yes_add,
			'S_SHOW_STATS_NO_ADD' => $show_stats_no_add,			
			
			'S_HIDDEN_FIELDS' => $s_hidden_fields,
			'S_SUBMIT_UPDATE' => $buttonvalue,
			'S_SUBMIT' => $lang['Update'],
			
			'L_GROUPS' 					=> $lang['Usergroups'],
			'L_IS_MODERATOR' 			=> $lang['Is_Moderator'],			
			
			//
			// Graphics
			//
			'IMG_URL_CONTRACT' => $admin_icon['contract'],
			'IMG_URL_EXPAND' => $admin_icon['expand'],	
			
			'IMG_ICON_PAGE' => $admin_icon['page'],	
			'IMG_ICON_PAGE_COLUMN' => $admin_icon['page_column'],	
			'IMG_ICON_FUNCTION' => $admin_icon['function'],	
			'IMG_ICON_PARAMETER' => $admin_icon['parameter'],	
			'IMG_ICON_BLOCK' => $admin_icon['block'],	
			'IMG_ICON_EDIT_BLOCK' => $admin_icon['edit_block'],		
			//
			// Cookies
			//
			'COOKIE_NAME'	=> $board_config['cookie_name'],
			'COOKIE_PATH'	=> $board_config['cookie_path'],
			'COOKIE_DOMAIN'	=> $board_config['cookie_domain'],
			'COOKIE_SECURE'	=> $board_config['cookie_secure'],				

		));

		//
		// Hidden fields
		//
		$s_hidden_general_fields = 	'<input type="hidden" name="mode" value="' . $mode_general . '" />
									<input type="hidden" name="action" value="' . $action . '" />
									<input type="hidden" name="id" value="' . $block_id . '" />
									<input type="hidden" name="function_id" value="' . $function_id . '" />
									<input type="hidden" name="module_id" value="' . $module_id . '" />		
									<input type="hidden" name="dynamic_block" value="' . $dynamic_block_id . '" />
									<input type="hidden" name="portalpage" value="' . $portalpage . '" />
									<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
		
		$s_hidden_general_add_fields = 	'<input type="hidden" name="mode" value="' . $mode_general . '" />
									<input type="hidden" name="action" value="' . MX_DO_INSERT . '" />
									<input type="hidden" name="id" value="' . $function_id . '" />
									<input type="hidden" name="function_id" value="' . $function_id . '" />
									<input type="hidden" name="module_id" value="' . $module_id . '" />
									<input type="hidden" name="dynamic_block" value="' . $dynamic_block_id . '" />
									<input type="hidden" name="portalpage" value="' . $portalpage . '" />
									<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';		
		
		$s_hidden_permissions_fields = 	'<input type="hidden" name="mode" value="' . $mode_permissions . '" />
									<input type="hidden" name="action" value="' . $action . '" />
									<input type="hidden" name="id" value="' . $block_id . '" />
									<input type="hidden" name="dynamic_block" value="' . $dynamic_block_id . '" />
									<input type="hidden" name="portalpage" value="' . $portalpage . '" />
									<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		$s_hidden_settings_fields = 	'<input type="hidden" name="mode" value="' . $mode_settings . '" />
									<input type="hidden" name="action" value="' . $action . '" />
									<input type="hidden" name="id" value="' . $block_id . '" />
									<input type="hidden" name="dynamic_block" value="' . $dynamic_block_id . '" />
									<input type="hidden" name="portalpage" value="' . $portalpage . '" />
									<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';	

		//
		// Get blockcp mode -> to set action file
		//
		$s_action_file = $this->blockcp_mode == 'mx_blockcp' ? $mx_root_path . 'modules/mx_coreblocks/mx_blockcp.' . $phpEx : $mx_root_path . 'admin/admin_mx_block_cp.' . $phpEx;
		
		$deletemode = '?mode=' . $mode_general . '&amp;action=' . MX_DO_DELETE . '&amp;id=' . $block_id . '&amp;module_id=' . $module_id . '&amp;function_id=' . $function_id . '&amp;portalpage=' . $portalpage. '&amp;sid=' . $userdata['session_id'];	

		$message_delete = $lang['Delete_block'] . ' - ' . $block_title
					. '<br /><br />' . $lang['Delete_block_explain']
					. '<br /><br />' . sprintf($lang['Click_block_delete_yes'], '<a href="' . mx_append_sid($s_action_file . $deletemode) . '">', '</a>')
					. '<br /><br />';			

						
		//
		// Activate BlockCP SubPanels, based on auth
		//	
		$blockcptemplate->assign_block_vars('blockcp_general', array(
			'L_TITLE' => $lang['Edit'],
			'S_HIDDEN_FIELDS' => $s_hidden_general_fields,
			'S_SUBMIT' => $buttonvalue		
		)); 
		
		if ($this->auth_mod)
		{
			$blockcptemplate->assign_block_vars('blockcp_general_add', array(
				'L_TITLE' => $lang['Create_block'],
				'S_HIDDEN_FIELDS' => $s_hidden_general_add_fields,
				'S_SUBMIT' => $buttonvalue_add		
			));		
		}
		
		if (!empty($this->block_parameters))
		{
			$blockcptemplate->assign_block_vars('blockcp_settings', array(
				'L_TITLE' => $lang['Settings'],
				'S_HIDDEN_FIELDS' => $s_hidden_settings_fields,
				'S_SUBMIT' => $buttonvalue		
			)); 
		}
			
		if ($this->auth_mod)
		{
			$blockcptemplate->assign_block_vars('blockcp_permissions', array(
				'L_TITLE' => $lang['Permissions_adv'],
				'S_HIDDEN_FIELDS' => $s_hidden_permissions_fields,
				'S_SUBMIT' => $buttonvalue			
			));
			
			//
			// Some general blockcp settings are moderator only 
			//
			$blockcptemplate->assign_block_vars('blockcp_general.is_auth', array());
			
			//
			// Now query all permissions data (not needed if not authorized ;)
			//
			
			//
			// Output values of individual auth fields - add
			//
			for( $j = 0; $j < count($block_auth_fields); $j++ )
			{
				$custom_auth[$j] = '&nbsp;<select name="' . $block_auth_fields[$j] . '">';
				
				for( $k = 0; $k < count($block_auth_levels); $k++ )
				{
					$selected = ( $block_auth_ary[$block_auth_fields[$j]] == $block_auth_const[$k] ) ? ' selected="selected"' : '';
					$custom_auth[$j] .= '<option value="' . $block_auth_const[$k] . '"' . $selected . '>' . $lang['AUTH_' . $block_auth_levels[$k]] . "</option>\n";
				}
				
				$custom_auth[$j] .= '</select>&nbsp;';
				
				$cell_title = $field_names[$block_auth_fields[$j]];
				
				$blockcptemplate->assign_block_vars('blockcp_general_add.block_auth_titles', array(
					'CELL_TITLE' => $cell_title
				));
				
				$blockcptemplate->assign_block_vars('blockcp_general_add.block_auth_data', array(
					'S_AUTH_LEVELS_SELECT' => $custom_auth[$j]
				));
			}			
			
			//
			// Output values of individual auth fields - edit
			//
			for( $j = 0; $j < count($block_auth_fields); $j++ )
			{
				$custom_auth[$j] = '&nbsp;<select name="' . $block_auth_fields[$j] . '">';
				
				for( $k = 0; $k < count($block_auth_levels); $k++ )
				{
					$selected = ( $this->block_info[$block_auth_fields[$j]] == $block_auth_const[$k] ) ? ' selected="selected"' : '';
					$custom_auth[$j] .= '<option value="' . $block_auth_const[$k] . '"' . $selected . '>' . $lang['AUTH_' . $block_auth_levels[$k]] . "</option>\n";
				}
				
				$custom_auth[$j] .= '</select>&nbsp;';
				
				$cell_title = $field_names[$block_auth_fields[$j]];
				
				$blockcptemplate->assign_block_vars('blockcp_general.block_auth_titles', array(
					'CELL_TITLE' => $cell_title
				));
				
				$blockcptemplate->assign_block_vars('blockcp_general.block_auth_data', array(
					'S_AUTH_LEVELS_SELECT' => $custom_auth[$j]
				));
			}						
		

			//
			// PRIVATE auth
			//
			
			//
			// Get the list of phpBB usergroups
			//
			$sql = "SELECT group_id, group_name
				FROM " . GROUPS_TABLE . "
				WHERE group_single_user <> " . TRUE . "
				ORDER BY group_name ASC";
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not get group list', '', __LINE__, __FILE__, $sql);
			}
			
			while( $row = $db->sql_fetchrow($result) )
			{
				$groupdata[] = $row;
			}
			
			$view_groups = @explode(',', $this->block_info['auth_view_group']);
			$edit_groups = @explode(',', $this->block_info['auth_edit_group']);
			$delete_groups = @explode(',', $this->block_info['auth_delete_group']);
			$moderator_groups = @explode(',', $this->block_info['auth_moderator_group']);
		
			$row_private = '';
			for( $i = 0; $i < count($groupdata); $i++ )
			{
				$row_color = ( !( $i % 2 ) ) ? 'row1' : 'row2';
				$row_private .= '<tr>';
				$row_private .= '<td width="40%" class="'.$row_color.'" align="center"><span class="gen">'.$groupdata[$i]['group_name'].'</span></td>';
				$row_private .= '<td width="20%" class="'.$row_color.'" align="center">';
				
				if ( $this->block_info['auth_view'] == AUTH_ACL )
				{
					$view_checked = in_array($groupdata[$i]['group_id'], $view_groups) ? 'checked="checked"' : '';
					$row_private .= '<input name="view[]" type="checkbox" ' . $view_checked . 'value="'.$groupdata[$i]['group_id'].'" />';
				}
				else 
				{
					$row_private .= '-';
				}
		
				$row_private .= '</td>';
				$row_private .= '<td width="20%" class="'.$row_color.'" align="center">';
					
				if ( $this->block_info['auth_edit'] == AUTH_ACL )
				{
					$edit_checked = in_array($groupdata[$i]['group_id'], $edit_groups) ? 'checked="checked"' : '';
					$row_private .= '<input name="edit[]" type="checkbox" ' . $edit_checked . 'value="'.$groupdata[$i]['group_id'].'" />';
				}
				else 
				{
					$row_private .= '-';
				}
										
				$row_private .= '</td>';
	
				$row_private .= '<td width="20%" class="'.$row_color.'" align="center">';
				$row_private .= '<input name="moderator[]" type="checkbox" '. (( in_array($groupdata[$i]['group_id'], $moderator_groups) ) ? 'checked="checked"' : '') . '" value="'.$groupdata[$i]['group_id'].'" />';
				$row_private .= '</td>';	
				$row_private .= '</tr>';			
			}
			
			$blockcptemplate->assign_block_vars('blockcp_permissions.grouprows', array(
				'GROUP_ROWS' => $row_private
			));
		}
		
		if ($this->auth_mod)
		{
			$blockcptemplate->assign_block_vars('blockcp_delete', array(
				'L_TITLE' => $lang['Delete'],
				'MESSAGE_DELETE' => $message_delete
			));
		}		

		//
		// Load and display additional blockcp parameters or panels (if any)
		//
		if (!empty($this->block_parameters))
		{
			$this->load_block_parameters($block_id);
		}
		
		return $template;		
	}	
	
	// ------------------------------
	// Public Methods
	//

	//
	// $action: MX_ADD, MX_EDIT
	// $type: MX_MODULE, MX_BLOCK, MX_BLOCK_SETTINGS, MX_FUNCTION, MX_PARAMETER, MX_PAGE, MX_PAGE_COLUMN, MX_PAGE_ITEM
	//
	function generate_cp( $id = '', $new_block = false )
	{
		$action = $new_block ? MX_ADD : MX_EDIT;
		switch ( $action )
		{
			case MX_ADD:	
				$function_id = $id;	
				$this->_controlpanel($function_id, $new_block );
			break;
			
			case MX_EDIT:
				$block_id = $id;
				$this->_controlpanel($block_id, $new_block );
			break;
		}
	}
	
} // class mx_blockcp	


?>