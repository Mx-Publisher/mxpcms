<?php
/**
*
* @package BlockCP
* @version $Id: mx_functions_blockcp.php,v 1.28 2008/07/13 19:30:28 jonohlsson Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/**#@+
 * Class mx_blockCP specific definitions.
 *
 */
define('MX_BLOCKCP_DEBUG', false);
/**#@-*/

/**
 * Class: mx_blockCP.
 *
 * The mx_blockcp class provides a Block Control Panel, extending the mx_block class.
 * This class will load additional module specific parameters, eg advanced textblocks (bbcode/html/mxp/wysiwyg) and serialized data types.
 * This class is instantiated in admin_mx_block_cp.php (adminCP mode) or in coreblocks/blockcp.php (user mode)
 *
 * Methods:
 * - $mx_blockcp->generate_cp($block_id);
 *
 * @package BlockCP
 * @author Jon Ohlsson
 * @access public
 */
class mx_blockcp extends mx_block
{
	/**
	 * Class var
	 *
	 * Define blockcp mode: 'mx_blockcp' or 'admin_mx_block_cp'
	 *
	 * @var string
	 */
	var $blockcp_mode = 'mx_blockcp';

	// ------------------------------
	// Private Methods
	//
	//

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $id
	 * @param unknown_type $new_block
	 * @return unknown
	 */
	function _controlpanel( $id, $new_block = false )
	{
		global $blockcptemplate, $lang, $db, $board_config, $theme, $phpEx, $mx_root_path, $s_hidden_fields, $userdata, $cookie_states, $module_nav_icon_url, $portalpage, $mx_request_vars, $images, $mx_backend;

		$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;

		$dynamic_block_id = $mx_request_vars->request('dynamic_block', MX_TYPE_INT, '');
		$virtual_id = $mx_request_vars->request('virtual', MX_TYPE_INT, 0);

		if ( empty($id) && !$new_block)
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

		$block_title = $mx_request_vars->post($block_keys['block_title'], MX_TYPE_NO_TAGS, $this->$block_keys['block_title']);
		$block_desc = $mx_request_vars->post($block_keys['block_desc'], MX_TYPE_NO_TAGS, $this->$block_keys['block_desc']);
		$show_block = $mx_request_vars->post($block_keys['show_block'], MX_TYPE_INT, $this->$block_keys['show_block']);
		$show_title = $mx_request_vars->post($block_keys['show_title'],MX_TYPE_INT, $this->$block_keys['show_title']);
		$show_stats = $mx_request_vars->post($block_keys['show_stats'], MX_TYPE_INT, $this->$block_keys['show_stats']);

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
		$module_nav_icon_url = PORTAL_URL . $images['mx_graphics']['admin_icons'] . '/';

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
		$cookie_blockCP = !empty($_COOKIE[$cookie_tmp]) ? $_COOKIE[$cookie_tmp] : 'settings';

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

			'L_SETTING' => $l_setting,
			'L_DELETE' => $lang['Delete'],
			'L_EDIT' => $lang['Edit'],

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
			'BLOCK_TITLE' => '&nbsp;&nbsp;' . $block_title,
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
									<input type="hidden" name="virtual" value="' . $virtual_id . '" />
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
		if (($this->auth_mod || $is_admin) && !$new_block)
		{
			$blockcptemplate->assign_block_vars('blockcp_general', array(
				'L_TITLE' => $lang['Edit'],
				'S_HIDDEN_FIELDS' => $s_hidden_general_fields,
				'S_SUBMIT' => $buttonvalue
			));

			//
			// Some general blockcp settings are moderator only
			//
			$blockcptemplate->assign_block_vars('blockcp_general.is_mod', array());
		}

		if ( ($is_admin ) || $new_block)
		{
			$blockcptemplate->assign_block_vars('blockcp_general_adds', array(
				'L_TITLE' => $lang['Create_block'],
				'S_HIDDEN_FIELDS' => $s_hidden_general_add_fields,
				'S_SUBMIT' => $buttonvalue_add
			));

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

				$blockcptemplate->assign_block_vars('blockcp_general_adds.block_auth_titles', array(
					'CELL_TITLE' => $cell_title
				));

				$blockcptemplate->assign_block_vars('blockcp_general_adds.block_auth_data', array(
					'S_AUTH_LEVELS_SELECT' => $custom_auth[$j]
				));
			}
		}

		if (!empty($this->block_parameters) && !$new_block)
		{
			$blockcptemplate->assign_block_vars('blockcp_settings', array(
				'L_TITLE' => $lang['Settings'],
				'S_HIDDEN_FIELDS' => $s_hidden_settings_fields,
				'S_SUBMIT' => $buttonvalue
			));
		}

		if ( ($is_admin) && !$new_block)
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
			$sql = $mx_backend->generate_group_select_sql();

			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not get group list', '', __LINE__, __FILE__, $sql);
			}

			while( $row = $db->sql_fetchrow($result) )
			{
				$groupdata[] = $row;
			}

			$db->sql_freeresult($result);

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

		if ( $is_admin && !$new_block && $this->blockcp_mode != 'mx_blockcp') // Do not allow deleting blocks in blockcp mode
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

		if ($this->blockcp_mode == 'mx_blockcp')
		{
			$blockcptemplate->assign_block_vars('mx_blockcp', array());
		}

		return $template;
	}

	// ------------------------------
	// Public Methods
	//

	/**
	 * Enter description here...
	 *
	 * $action:
	 * - MX_ADD, MX_EDIT
	 *
	 * $type:
	 * - MX_MODULE, MX_BLOCK, MX_BLOCK_SETTINGS, MX_FUNCTION, MX_PARAMETER, MX_PAGE, MX_PAGE_COLUMN, MX_PAGE_ITEM
	 *
	 * @access public
	 * @param unknown_type $id
	 */
	function generate_cp( $id = '' )
	{
		$newBlock = $id == 'noBlock' ? true : false;
		$block_id = $id == 'noBlock' ? '' : $id;

		$this->_controlpanel($block_id, $newBlock );
	}

} // class mx_blockcp
?>