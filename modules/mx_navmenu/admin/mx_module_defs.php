<?php
/**
*
* @package MX-Publisher Module - mx_navmenu
* @version $Id: mx_module_defs.php,v 1.39 2008/09/30 07:04:50 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/********************************************************************************\
| Class: mx_module_defs
| The mx_module_defs object provides additional module block parameters...
\********************************************************************************/

//
// The following flags are class specific options
//

// Flow control
define('MX_PANEL_DEBUG'					, false);

// Types (Mode)
define('MX_MENU_CAT_TYPE'					, 1);
define('MX_MENU_TYPE'						, 2);
define('MX_MENU_PAGE_TYPE'					, 3);

class mx_module_defs
{
	var $is_panel = true;
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

		$type_row['nav_menu'] = !empty($lang['ParType_nav_menu']) ? $lang['ParType_nav_menu'] : "Navigation Menu";
		$type_row['site_menu'] = !empty($lang['ParType_site_menu']) ? $lang['ParType_site_menu'] : "Site Nav Menu";

		return $type_row;
	}

	// ===================================================
	// Display cuztom parameter field and data in the Block Control Panel
	// ===================================================
	function display_module_parameters( $parameter_data, $block_id )
	{
		global $template, $mx_blockcp, $mx_root_path, $theme, $lang;

		switch ( $parameter_data['parameter_type'] )
		{
			case 'nav_menu':
				$this->display_panel_nav_menu( $parameter_data, $block_id );
				break;

			case 'site_menu':
				$this->display_panel_site_menu( $parameter_data, $block_id );
				break;
		}
	}

	// ===================================================
	// Display cuztom Panel - Nav Menu
	// ===================================================
	function display_panel_nav_menu( $parameter_data, $block_id )
	{
		global $template, $tplEx, $board_config, $db, $theme, $lang, $images, $mx_blockcp, $mx_root_path, $userdata, $mx_request_vars, $dynamic_block_id, $portalpage, $mx_cache, $phpEx;

		//
		// Includes
		//
		include_once( $mx_root_path . 'modules/mx_navmenu/includes/navmenu_functions.' . $phpEx );

		$parameter_id = $parameter_data['parameter_id'];

		//
		// Load states
		//
		$cookie_tmp = $board_config['cookie_name'].'_admincp_menustates';
		$cookie_states = !empty($_COOKIE[$cookie_tmp]) ? explode(",", $_COOKIE[$cookie_tmp]) : array();

		//
		// Define some graphics
		//
		$admin_icon_url = PORTAL_URL . $images['mx_graphics']['admin_icons'] . '/';
		$admin_icon['contract'] = $admin_icon_url . 'contract.gif';
		$admin_icon['expand'] = $admin_icon_url . 'expand.gif';
		$admin_icon['page'] = $admin_icon_url . 'icon_page.gif';
		$admin_icon['page_column'] = $admin_icon_url . 'icon_page_column.gif';
		$admin_icon['function'] = $admin_icon_url . 'icon_function.gif';
		$admin_icon['parameter'] = $admin_icon_url . 'icon_parameter.gif';
		$admin_icon['block'] = $admin_icon_url . 'icon_block.gif';
		$admin_icon['edit_block'] = $admin_icon_url . 'icon_edit.gif';

		$module_auth_ary = array('auth_view' => AUTH_ALL);
		$module_auth_fields = array('auth_view');
		$module_auth_levels = array('ALL', 'REG', 'PRIVATE', 'MOD', 'ADMIN', 'ANONYMOUS');
		$module_auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN, AUTH_ANONYMOUS);
		$field_names = array('auth_view' => $lang['View']);

		$link_target_options = array();
		$link_target_options = array("Default", "New browser", "IncludeX Block");

		//
		// Mode setting
		//
		$mode = $mx_request_vars->request('panel_mode', MX_TYPE_NO_TAGS, '');
		$action = $mx_request_vars->request('panel_action', MX_TYPE_NO_TAGS, '');

		//
		// Parameters
		//
		$submit = $mx_request_vars->is_post('submit');
		$cancel = $mx_request_vars->is_post('cancel');
		$preview = $mx_request_vars->is_post('preview');
		$refresh = $preview || $submit_search;

		//
		// SUBMIT?
		//
		if( !empty($mode) && !empty($action) )
		{
			//
			// Get vars
			//
			$portalpage = $mx_request_vars->request('portalpage', MX_TYPE_INT, 1);
			$id = $mx_request_vars->request('id', MX_TYPE_INT, '');

			//
			// Send to db functions
			//
			$result_message = $this->do_it($mode, $action, $id);

			//
			// If new
			//
			if (is_array($result_message))
			{
				//$nav_page_id = $result_message['new_page_id'];
				$result_message = $result_message['text'];
			}

			//
			// Refresh mx_block object with new settings
			//
			$mx_blockcp->init($block_id, true);

			//
			// Refresh Nav cache
			//
			$mx_nav_data = mx_get_nav_menu($block_id);
			$mx_cache->put( '_menu_' . $block_id, $mx_nav_data );

		} // if .. !empty($mode)

		//
		// Begin program proper
		//

		$bbcode_on = $board_config['allow_bbcode'] ? true : false;
		$html_on = $board_config['allow_html'] ? true : false;
		$smilies_on = $board_config['allow_smilies'] ? true : false;

		//
		// HTML, BBCode & Smilies toggle selection
		//
		$html_status = ( $html_on ) ? $lang['HTML_is_ON'] : $lang['HTML_is_OFF'];
		$bbcode_status = ( $bbcode_on ) ? $lang['BBCode_is_ON'] : $lang['BBCode_is_OFF'];
		$smilies_status = ( $smilies_on ) ? $lang['Smilies_are_ON'] : $lang['Smilies_are_OFF'];

		// DO IT DO IT

		$template->set_filenames(array(
			'parameter' => 'admin/mx_module_parameters.'.$tplEx)
		);

		$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $block_id . '" />';

		$show_cat_sel = '<select name="cat_show_sel"><option value="0">' . ( !empty($lang['Folded']) ? $lang['Folded'] : 'Folded' ) . '</option><option value="1" selected="selected">' . ( !empty($lang['Unfolded']) ? $lang['Unfolded'] : 'Unfolded' ) . '</option></select>';

		//
		// Generate generic form selects
		//
		$functionlist = get_list_opt('functions', FUNCTION_TABLE, 'function_id', 'function_name', '', true);
		$blocklist = get_list_formatted('block_list', '', 'blocks');
		$pagelist = get_list_formatted('page_list', '', 'pages');

		//
		// Get group data
		//
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'phpbb2':
			$sql = "SELECT group_id, group_name
				FROM " . GROUPS_TABLE . "
				WHERE group_single_user <> " . TRUE . "
				ORDER BY group_name ASC";
				break;
			case 'phpbb3':
			$sql = "SELECT group_id, group_name
				FROM " . GROUPS_TABLE . "
				WHERE group_name NOT IN ('BOTS', 'GUESTS')
				ORDER BY group_name ASC";
				break;
		}

		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't get list of groups", '', __LINE__, __FILE__, $sql);
		}

		$group_rowset = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		//
		// Get blockcp mode -> to set action file
		//
		$s_action_file = $mx_blockcp->blockcp_mode == 'mx_blockcp' ? 'modules/mx_coreblocks/mx_blockcp.' . $phpEx : 'admin/admin_mx_block_cp.' . $phpEx;

		//
		// Main parameters
		//
		$template->assign_vars(array(
			'L_YES' 				=> $lang['Yes'],
			'L_NO' 					=> $lang['No'],

			'SID'						=> $userdata['session_id'],
			'RESULT_MESSAGE'			=> !empty($result_message) ? '<div style="overflow:auto; height:50px;"><span class="gensmall">' . $result_message  . '<br/> -::-</span></div>': '',

			//
			// Generic form selects
			//
			'S_GEN_FUNCTION_LIST' 		=> $functionlist,
			'S_GEN_BLOCK_LIST' 			=> $blocklist,
			'S_GEN_PAGE_LIST' 			=> $pagelist,

			//
			// Graphics
			//
			'IMG_URL_CONTRACT' 		=> $admin_icon['contract'],
			'IMG_URL_EXPAND' 		=> $admin_icon['expand'],

			'IMG_ICON_PAGE' 		=> $admin_icon['page'],
			'IMG_ICON_PAGE_COLUMN' 	=> $admin_icon['page_column'],
			'IMG_ICON_FUNCTION' 	=> $admin_icon['function'],
			'IMG_ICON_PARAMETER' 	=> $admin_icon['parameter'],
			'IMG_ICON_BLOCK' 		=> $admin_icon['block'],
			'IMG_ICON_EDIT_BLOCK' 	=> $admin_icon['edit_block'],
			//
			// Cookies
			//
			'COOKIE_NAME'		=> $board_config['cookie_name'],
			'COOKIE_PATH'		=> $board_config['cookie_path'],
			'COOKIE_DOMAIN'		=> $board_config['cookie_domain'],
			'COOKIE_SECURE'		=> $board_config['cookie_secure'],

			'L_SUBJECT' 		=> $lang['Subject'],
			'L_SUBMIT' 			=> $lang['Submit'],
			'L_CANCEL' 			=> $lang['Cancel'],
			'L_CONFIRM_DELETE' 	=> $lang['Confirm_delete'],
			'L_DELETE_POST' 	=> $lang['Delete_post'],

			'L_SUBMIT' 			=> $lang['Update'],
			'L_RESET' 			=> $lang['Reset'],
			'L_MENU_PAR_TITLE' 	=> $lang['Menu_par_title'],

			'L_MENU_TITLE' 		=> $lang['Menu_admin'],
			'L_MENU_EXPLAIN' 	=> $lang['Menu_admin_explain'],

			'S_SHOW_CAT' 			=> $show_cat_sel,
			'U_PHPBB_ROOT_PATH' 	=> PHPBB_URL,
			'TEMPLATE_ROOT_PATH' 	=> TEMPLATE_ROOT_PATH,
			'U_PORTAL_ROOT_PATH'	=> PORTAL_URL, // DIV Templates. Images from root template folder. $phpBB3->prosilver template

			'L_CREATE_MENU' 		=> $lang['Create_menu'],
			'L_CREATE_CATEGORY' 	=> $lang['Create_category'],

			'L_EDIT' 		=> $lang['Edit'],
			'L_DELETE' 		=> $lang['Delete'],
			'L_MOVE_UP' 	=> $lang['Move_up'],
			'L_MOVE_DOWN' 	=> $lang['Move_down'],
			'L_RESYNC' 		=> $lang['Resync'],
			'L_CHANGE_NOW' 	=> $lang['Change'],

			'L_BLOCK' 		=> $lang['Block'],

			'S_ACTION'		=> mx_append_sid(PORTAL_URL . $s_action_file),
		));

		if( !empty($portalpage) )
		{
			$template->assign_block_vars('block_mode', array(
				'U_RETURN' => mx_append_sid(PORTAL_URL . "index.$phpEx?page=$portalpage")
			));
		}

		//
		// ---------------------------------------------------------------------------------- Cats
		//

		// Display list of Categories ---------------------------------------------------------------
		// ---------------------------------------------------------------------------------------

		$sql = "SELECT *
			FROM " . MENU_CAT_TABLE . "
			WHERE block_id = '" . $block_id . "'
			ORDER BY cat_order";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt query Navigation Categories', '', __LINE__, __FILE__, $sql );
		}

		$cat_rows = array();
		if( $total_cats = $db->sql_numrows($result) )
		{
			$cat_rows = $db->sql_fetchrowset($result);
		}

		$db->sql_freeresult($result);

		if ( $total_cats == 0 )
		{
			$template->assign_block_vars('nocat', array(
				'NONE' => $lang['No_pages']
			));
		}

		for( $cat_count = 0; $cat_count < $total_cats + 1; $cat_count++ )
		{
			$new_cat = $cat_count == $total_cats;
			$cat_id = $new_cat ? 'new_cat' : $cat_rows[$cat_count]['cat_id'];

			$mode = MX_MENU_CAT_TYPE;
			$action = $new_cat ? MX_DO_INSERT : MX_DO_UPDATE;
			$deletemode = '?panel_mode=' . $mode . '&amp;panel_action=' . MX_DO_DELETE . '&amp;id=' . $cat_id . '&amp;block_id=' . $block_id . '&amp;portalpage=' . $portalpage. '&amp;dynamic_block=' . $dynamic_block_id;

			$upmode = '?panel_mode=' . $mode . '&amp;panel_action=' . MX_DO_MOVE . '&amp;id=' . $cat_id . '&amp;block_id=' . $block_id . '&amp;block_order=' . $block_order . '&amp;move=-15' . '&amp;portalpage=' . $portalpage. '&amp;dynamic_block=' . $dynamic_block_id;
			$downmode = '?panel_mode=' . $mode . '&amp;panel_action=' . MX_DO_MOVE . '&amp;id=' . $cat_id . '&amp;block_id=' . $block_id . '&amp;block_order=' . $block_order . '&amp;move=15' . '&amp;portalpage=' . $portalpage. '&amp;dynamic_block=' . $dynamic_block_id;

			//
			// Hidden fields
			//
			$s_hidden_cat_fields = 	'<input type="hidden" name="panel_mode" value="' . $mode . '" />
											<input type="hidden" name="panel_action" value="' . $action . '" />
											<input type="hidden" name="id" value="' . $cat_id . '" />
											<input type="hidden" name="block_id" value="' . $block_id . '" />
											<input type="hidden" name="dynamic_block" value="' . $dynamic_block_id . '" />
											<input type="hidden" name="portalpage" value="' . $portalpage . '" />
											<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

			$s_hidden_cat_delete_fields = 	'<input type="hidden" name="panel_mode" value="' . $mode . '" />
											<input type="hidden" name="panel_action" value="' . MX_DO_DELETE . '" />
											<input type="hidden" name="id" value="' . $cat_id . '" />
											<input type="hidden" name="block_id" value="' . $block_id . '" />
											<input type="hidden" name="from_id" value="' . $cat_id . '" />
											<input type="hidden" name="dynamic_block" value="' . $dynamic_block_id . '" />
											<input type="hidden" name="portalpage" value="' . $portalpage . '" />
											<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

			$cat_title = !$new_cat ? $cat_rows[$cat_count]['cat_title'] : '';
			$cat_desc = !$new_cat ? $cat_rows[$cat_count]['cat_desc'] : '';

			//
			// Page subpanel - edit
			//
			if (!$new_cat)
			{
				$bbcode_uid = $cat_rows[$cat_count]['bbcode_uid'];

				$cat_desc = preg_replace("/\:(([a-z0-9]:)?)$bbcode_uid/si", '', $cat_desc);
				$cat_desc = str_replace('<br />', "\n", $cat_desc);
				$cat_desc = preg_replace('#</textarea>#si', '&lt;/textarea&gt;', $cat_desc);
			}

			$show_cat = $cat_rows[$cat_count]['cat_show'];

			if( $show_cat == 0 )
			{
				$show_cat_select = '<select name="cat_show_sel"><option value="0" selected="selected">' . ( !empty($lang['Folded']) ? $lang['Folded'] : 'Folded' ) . '</option><option value="1">' . ( !empty($lang['Unfolded']) ? $lang['Unfolded'] : 'Unfolded' ) . '</option></select>';
			}
			else
			{
				$show_cat_select = '<select name="cat_show_sel"><option value="0">' . ( !empty($lang['Folded']) ? $lang['Folded'] : 'Folded' ) . '</option><option value="1" selected="selected">' . ( !empty($lang['Unfolded']) ? $lang['Unfolded'] : 'Unfolded' ) . '</option></select>';
			}

			$cat_url = $cat_rows[$cat_count]['cat_url'];
			$cat_target = $link_target_options[$cat_rows[$cat_count]['cat_target']];

			$link_target_list = '<select name="cat_target_sel">';
			for( $j = 0; $j < count($link_target_options); $j++ )
			{
				$selected = ( $cat_target == $link_target_options[$j] ) ? ' selected="selected"' : '';
				$link_target_list .= '<option value="' . $j . '" ' . $selected . '>' . $link_target_options[$j] . "</option>\n";
			}
			$link_target_list .= '</select>';

			//
			// Delete Cat
			//
			if (!$new_cat)
			{
				$buttonvalue = $lang['Move_and_or_Delete'];
				$name = $cat_rows[$cat_count]['cat_title'];

				if( $total_cats == 1 )
				{
					$select_to = $lang['Nowhere_to_move'];
				}
				else
				{
					$select_to = mx_get_list('to_id', MENU_CAT_TABLE, 'cat_id', 'cat_title', $cat_id, false, 'block_id', $block_id);
				}
			}

			$visible_cat = in_array('adminCat_' . $cat_id, $cookie_states);
			$visible_cat_edit = in_array('adminCatEdit_' . $cat_id, $cookie_states);
			$visible_cat_delete = in_array('adminCatDelete_' . $cat_id, $cookie_states);

			$template->assign_block_vars('catrow', array(
				'CAT_ID' 					=> $cat_id,

				'VISIBLE' 					=> $visible_cat ? 'block' : 'none',
				'VISIBLE_EDIT' 				=> $visible_cat_edit || $new_page ? 'block' : 'none',
				'VISIBLE_DELETE' 			=> $visible_cat_delete && !$new_page ? 'block' : 'none',

				'IMG_URL' 					=> $visible_cat ? $admin_icon['contract'] : $admin_icon['expand'],
				'IMG_URL_EDIT' 				=> $visible_cat_edit ? $admin_icon['contract'] : $admin_icon['expand'],
				'IMG_URL_DELETE' 			=> $visible_cat_delete ? $admin_icon['contract'] : $admin_icon['expand'],

				'CAT_TITLE' 				=> $new_cat ? $lang['Create_category'] : $cat_title,
				'CAT_DESC' 					=> ( $cat_desc != '' ) ? ' - ' . $cat_desc : '',

				'U_CAT_MOVE_UP' 			=> mx_append_sid($mx_root_path . $s_action_file . $upmode . '&amp;sid=' . $userdata['session_id']),
				'U_CAT_MOVE_DOWN' 			=> mx_append_sid($mx_root_path . $s_action_file . $downmode . '&amp;sid=' . $userdata['session_id'] ),

				//
				// EDIT CAT
				//
				'PAGE_NAV' 					=> $cat_url,

				'L_TITLE_DELETE' 			=> $lang['Delete'],
				'L_TITLE_EDIT' 				=> $new_cat ? $lang['Create_category'] : $lang['Edit_Category'],

				'L_CAT_TITLE' 				=> $lang['Category'],
				'L_CAT_DESC' 				=> $lang['Category_desc'],
				'L_CAT_SHOW_CAT' 			=> $lang['Show_cat'],
				'L_CAT_MENU_PAGE' 			=> $lang['Menu_page'],
				'L_CAT_MENU_LINKS' 			=> $lang['Menu_links'],
				'L_CAT_LINK_TARGET' 		=> $lang['Link_target'],

				'E_CAT_TITLE' 				=> $cat_title,
				'E_CAT_DESC' 				=> $cat_desc,
				'S_CAT_SHOW_CAT' 			=> $show_cat_select,
				'S_CAT_LINK_TARGET_LIST' 	=> $link_target_list,

				'HTML_STATUS' 				=> $html_status,
				'BBCODE_STATUS' 			=> sprintf($bbcode_status, '<a href="' . mx_append_sid(PHPBB_URL . "faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'),
				'SMILIES_STATUS' 			=> $smilies_status,

				//
				// Delete CAT
				//
				'NAME' => $name,
				'L_MOVE_CONTENTS' => $lang['Move_contents'],
				'L_MENU_NAME' => $lang['Menu_name'],
				'S_HIDDEN_DELETE_FIELDS' => $s_hidden_cat_delete_fields,
				'S_SELECT_TO' => $select_to,
				'S_SUBMIT_DELETE' => $buttonvalue,


				'S_HIDDEN_FIELDS' 			=> $s_hidden_cat_fields,
				'S_SUBMIT' 					=> $new_cat ? $lang['Create_category'] : $lang['Update']

			));

			if ($new_cat)
			{
				$template->assign_block_vars('catrow.is_new', array());
				continue;
			}
			else
			{
				$template->assign_block_vars('catrow.is_cat', array());
			}

			/*
			$num_of_menus = count($catData);
			*/

			$sql = "SELECT *
				FROM " . MENU_NAV_TABLE . "
				WHERE cat_id = '" . $cat_id . "'
				ORDER BY menu_order";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt query Navigation menus', '', __LINE__, __FILE__, $sql );
			}

			$menu_rows = array();
			if( $total_menus = $db->sql_numrows($result) )
			{
				$menu_rows = $db->sql_fetchrowset($result);
			}

			$db->sql_freeresult($result);

			if ( $total_menus == 0 )
			{
				$template->assign_block_vars('catrow.nocat', array(
					'NONE' => $lang['No_pages']
				));
			}

			for( $menu_count = 0; $menu_count < $total_menus + 1; $menu_count++ )
			{
				$new_menu = $menu_count == $total_menus;
				$menu_id = $new_menu ? $cat_id . '_0' : $menu_rows[$menu_count]['menu_id'];

				$mode = MX_MENU_TYPE;
				$action = $new_menu ? MX_DO_INSERT : MX_DO_UPDATE;
				$deletemode = '?panel_mode=' . $mode . '&amp;panel_action=' . MX_DO_DELETE . '&amp;id=' . $menu_id . '&amp;block_id=' . $block_id;

				$upmode = '?panel_mode=' . $mode . '&amp;panel_action=' . MX_DO_MOVE . '&amp;id=' . $menu_id . '&amp;cat_id=' . $cat_id . '&amp;block_id=' . $block_id . '&amp;block_order=' . $block_order . '&amp;move=-15';
				$downmode = '?panel_mode=' . $mode . '&amp;panel_action=' . MX_DO_MOVE . '&amp;id=' . $menu_id . '&amp;cat_id=' . $cat_id . '&amp;block_id=' . $block_id . '&amp;block_order=' . $block_order . '&amp;move=15';

				//
				// Hidden fields
				//
				$s_hidden_menu_fields = 	'<input type="hidden" name="panel_mode" value="' . $mode . '" />
												<input type="hidden" name="panel_action" value="' . $action . '" />
												<input type="hidden" name="id" value="' . $menu_id . '" />
												<input type="hidden" name="block_id" value="' . $block_id . '" />
												<input type="hidden" name="portalpage" value="' . $portalpage . '" />
												<input type="hidden" name="cat_id" value="' . $cat_id . '" />
												<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';


				$menuname = !$new_menu ? $menu_rows[$menu_count]['menu_name'] : '';
				$menudesc = !$new_menu ? $menu_rows[$menu_count]['menu_desc'] : '';

				$message_delete = $lang['Delete_nav_menu'] . ' - ' . $menuname
							. '<br /><br />' . $lang['Delete_nav_menu_explain']
							. '<br /><br />' . sprintf($lang['Click_nav_menu_delete_yes'], '<a href="' . mx_append_sid($mx_root_path . $s_action_file . $deletemode . '&amp;sid=' . $userdata['session_id']) . '">', '</a>')
							. '<br /><br />';

				$menuicons = $new_menu ? post_icons('menu_icons/') : post_icons('menu_icons/', $menu_rows[$menu_count]['menu_icon']);
				$menu_alt_icon = !$new_menu ? $menu_rows[$menu_count]['menu_alt_icon'] : '';
				$menu_alt_icon_hot = !$new_menu ? $menu_rows[$menu_count]['menu_alt_icon_hot'] : '';
				$menulinks = !$new_menu ? $menu_rows[$menu_count]['menu_links'] : '';
				$block_nav = !$new_menu ? $menu_rows[$menu_count]['block_id'] : '';
				$function_nav = !$new_menu ? $menu_rows[$menu_count]['function_id'] : '';
				$page_nav = !$new_menu ? $menu_rows[$menu_count]['page_id'] : '';
				$auth_view = !$new_menu ? $menu_rows[$menu_count]['auth_view'] : '';
				$auth_view_group_id = !$new_menu ? $menu_rows[$menu_count]['auth_view_group'] : '';
				$link_target = !$new_menu ? $link_target_options[$menu_rows[$menu_count]['link_target']] : '';

				$link_target_list = '<select name="link_target">';
				for( $j = 0; $j < count( $link_target_options ); $j++ )
				{
					$selected = ( $link_target == $link_target_options[$j] ) ? ' selected="selected"' : '';
					$link_target_list .= '<option value="' . $j . '" ' . $selected . '>' . $link_target_options[$j] . "</option>\n";
				}
				$link_target_list .= '</select>';

				// Replace htmlentites for < and > with actual character.
				$row_class = ( !( $menu_count % 2 ) ) ? 'row1' : 'row2';

				$visible_menu_edit = in_array('adminMenuEdit_' . $menu_id, $cookie_states);
				$visible_menu_delete = in_array('adminMenuDelete_' . $menu_id, $cookie_states);

				$template->assign_block_vars('catrow.menurow', array(
					'MENU_ID' 			=> $menu_id,

					"ROW_CLASS" 		=> $row_class,

					'VISIBLE_EDIT' 		=> $visible_menu_edit ? 'block' : 'none',
					'VISIBLE_DELETE' 	=> $visible_menu_delete || $new_page ? 'block' : 'none',

					'IMG_URL_EDIT' 		=> $visible_menu_edit ? $admin_icon['contract'] : $admin_icon['expand'],
					'IMG_URL_DELETE' 	=> $visible_menu_delete ? $admin_icon['contract'] : $admin_icon['expand'],

					'MENU_TITLE' 		=> $new_menu ? '<b>' . $lang['Create_menu'] . '</b>': $menuname,
					'MENU_DESC' 		=> $menudesc,
					'ROW_COLOR' 		=> $row_color,

					'U_MENU_MOVE_UP' 	=> mx_append_sid($mx_root_path . $s_action_file . $upmode . '&amp;sid=' . $userdata['session_id']),
					'U_MENU_MOVE_DOWN' 	=> mx_append_sid($mx_root_path . $s_action_file . $downmode . '&amp;sid=' . $userdata['session_id']),

					//
					// Menu EDIT
					//
					'PAGE_NAV' 			=> 	$page_nav,
					'BLOCK_NAV' 		=> 	$block_nav,
					'FUNCTION_NAV' 		=>	$function_nav,

					'L_TITLE_DELETE' 		=> $lang['Delete'],
					'L_TITLE_EDIT' 			=> $new_menu ? $lang['Create_menu'] : $lang['Edit'],

					'L_MENU_TITLE' 				=> $l_title,
					'L_MENU_ACTION_TITLE' 		=> $lang['Menu_action_title'],
					'L_MENU_ACTION_ADV' 		=> $lang['Menu_action_adv'],
					'L_MENU_PERMISSIONS_TITLE' 	=> $lang['Menu_permissions_title'],

					'L_MENU_TITLE' 			=> $lang['Menu_name'],
					'L_MENU_DESC' 			=> $lang['Menu_desc'],
					'L_MENU_ICON' 			=> $lang['Menu_icon'],
					'L_MENU_ALT_ICON' 		=> $lang['Menu_alt_icon'],
					'L_MENU_ALT_ICON_HOT' 	=> $lang['Menu_alt_icon_hot'],
					'L_MENU_CATEGORY' 		=> $lang['Category'],
					'L_MENU_FUNCTION' 		=> $lang['Menu_function'],
					'L_MENU_BLOCK' 			=> $lang['Menu_block'],
					'L_MENU_PAGE' 			=> $lang['Menu_page'],
					'L_MENU_LINKS' 			=> $lang['Menu_links'],
					'L_MENU_LINK_TARGET' 	=> $lang['Link_target'],

					'E_MENU_TITLE'		 	=> htmlspecialchars($menuname),
					'E_MENU_DESC' 			=> $menudesc,
					'E_MENU_ICON' 			=> $menuicon,
					'E_MENU_ALT_ICON' 		=> $menu_alt_icon,
					'E_MENU_ALT_ICON_HOT' 	=> $menu_alt_icon_hot,
					'E_MENU_LINKS' 			=> $menulinks,
					'S_POSTICONS' 			=> $menuicons,
					'S_FUNCTION_LIST' 		=> $functionlist,
					'S_BLOCK_LIST' 			=> $blocklist,
					'S_PAGE_LIST' 			=> $pagelist,
					'S_LINK_TARGET_LIST' 	=> $link_target_list,

					'L_DAYS' 				=> $lang['Days'],
					'L_AUTH_TITLE' 			=> $lang['Auth_Module'],

					'MESSAGE_DELETE' 		=> $message_delete,

					'S_HIDDEN_FIELDS' 		=> $s_hidden_menu_fields,
					'S_SUBMIT' 				=> $new_menu ? $lang['Create_menu'] : $lang['Update'],
				));

				//
				// Output values of individual fields
				//
				for( $j = 0; $j < count($module_auth_fields); $j++ )
				{
					$custom_auth[$j] = '&nbsp;<select name="' . $module_auth_fields[$j] . '">';

					for( $k = 0; $k < count($module_auth_levels); $k++ )
					{
						$selected = ( $menu_rows[$menu_count][$module_auth_fields[$j]] == $module_auth_const[$k] ) ? ' selected="selected"' : '';
						$custom_auth[$j] .= '<option value="' . $module_auth_const[$k] . '"' . $selected . '>' . $lang['AUTH_' . $module_auth_levels[$k]] . "</option>\n";
					}
					$custom_auth[$j] .= '</select>&nbsp;';

					$custom_group_auth = mx_get_groups($auth_view_group_id, 'auth_view_group', $group_rowset);

					$cell_title = $field_names[$module_auth_fields[$j]];

					$template->assign_block_vars('catrow.menurow.module_auth_titles', array(
						'CELL_TITLE' => $cell_title)
					);
					$template->assign_block_vars('catrow.menurow.module_auth_data', array(
						'S_AUTH_GROUP_LEVELS_SELECT' => $custom_group_auth,
						'L_AUTH_GROUP_LEVELS_SELECT' => $lang['Auth_Page_group'],
						'S_AUTH_LEVELS_SELECT' => $custom_auth[$j])
					);

					$s_column_span++;
				}

				if (!$new_menu)
				{
					$template->assign_block_vars('catrow.menurow.is_menu', array());
					continue;
				}

			} // for ... menus
		} // for ... categories

		$template->pparse('parameter');
	}

	// ===================================================
	// Display cuztom Panel - Nav Menu
	// ===================================================
	function display_panel_site_menu( $parameter_data, $block_id )
	{
		global $template, $tplEx, $board_config, $db, $theme, $lang, $images, $mx_blockcp, $mx_root_path, $userdata, $mx_request_vars, $dynamic_block_id, $portalpage, $mx_cache, $phpEx;

		$mx_page = new mx_page();
		$mx_page->init('1');

		$mx_block = new mx_block();
		$mx_block->init($block_id);

		$parent_page = is_numeric($mx_block->get_parameters('menu_page_parent')) ? $mx_block->get_parameters('menu_page_parent') : '0';

		//
		// Includes
		//
		include_once( $mx_root_path . 'modules/mx_navmenu/includes/navmenu_functions.' . $phpEx );

		$parameter_id = $parameter_data['parameter_id'];

		//
		// Load states
		//
		$cookie_tmp = $board_config['cookie_name'].'_admincp_sitestates';
		$cookie_states = !empty($_COOKIE[$cookie_tmp]) ? explode(",", $_COOKIE[$cookie_tmp]) : array();

		//
		// Define some graphics
		//
		$admin_icon_url = PORTAL_URL . $images['mx_graphics']['admin_icons'] . '/';
		$admin_icon['contract'] = $admin_icon_url . 'contract.gif';
		$admin_icon['expand'] = $admin_icon_url . 'expand.gif';
		$admin_icon['page'] = $admin_icon_url . 'icon_page.gif';
		$admin_icon['page_column'] = $admin_icon_url . 'icon_page_column.gif';
		$admin_icon['function'] = $admin_icon_url . 'icon_function.gif';
		$admin_icon['parameter'] = $admin_icon_url . 'icon_parameter.gif';
		$admin_icon['block'] = $admin_icon_url . 'icon_block.gif';
		$admin_icon['edit_block'] = $admin_icon_url . 'icon_edit.gif';

		$link_target_options = array();
		$link_target_options = array("Default", "New browser", "IncludeX Block");

		//
		// Mode setting
		//
		$mode = $mx_request_vars->request('panel_mode', MX_TYPE_NO_TAGS, '');
		$action = $mx_request_vars->request('panel_action', MX_TYPE_NO_TAGS, '');

		//
		// Parameters
		//
		$submit = $mx_request_vars->is_post('submit');
		$cancel = $mx_request_vars->is_post('cancel');
		$preview = $mx_request_vars->is_post('preview');
		$refresh = $preview || $submit_search;

		//
		// SUBMIT?
		//
		if( !empty($mode) && !empty($action) )
		{
			//
			// Get vars
			//
			$portalpage = $mx_request_vars->request('portalpage', MX_TYPE_INT, 1);
			$id = $mx_request_vars->request('id', MX_TYPE_INT, '');

			//
			// Send to db functions
			//
			$result_message = $this->do_it($mode, $action, $id);

			//
			// If new
			//
			if (is_array($result_message))
			{
				//$nav_page_id = $result_message['new_page_id'];
				$result_message = $result_message['text'];
			}

			//
			// Refresh mx_block object with new settings
			//
			$mx_blockcp->init($block_id, true);
			$mx_page->init('1');

		} // if .. !empty($mode)

		// DO IT DO IT

		$template->set_filenames(array(
			'parameter' => 'admin/mx_module_parameters_site.'.$tplEx)
		);

		$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $block_id . '" />';

		$show_cat_sel = '<select name="cat_show_sel"><option value="0">' . ( !empty($lang['Folded']) ? $lang['Folded'] : 'Folded' ) . '</option><option value="1" selected="selected">' . ( !empty($lang['Unfolded']) ? $lang['Unfolded'] : 'Unfolded' ) . '</option></select>';

		//
		// Get blockcp mode -> to set action file
		//
		$s_action_file = $mx_blockcp->blockcp_mode == 'mx_blockcp' ? 'modules/mx_coreblocks/mx_blockcp.' . $phpEx : 'admin/admin_mx_block_cp.' . $phpEx;

		//
		// Main parameters
		//
		$template->assign_vars(array(
			'L_YES' 				=> $lang['Yes'],
			'L_NO' 					=> $lang['No'],

			'SID'						=> $userdata['session_id'],
			'RESULT_MESSAGE'			=> !empty($result_message) ? '<div style="overflow:auto; height:50px;"><span class="gensmall">' . $result_message  . '<br/> -::-</span></div>': '',

			//
			// Graphics
			//
			'IMG_URL_CONTRACT' 		=> $admin_icon['contract'],
			'IMG_URL_EXPAND' 		=> $admin_icon['expand'],

			'IMG_ICON_PAGE' 		=> $admin_icon['page'],
			'IMG_ICON_PAGE_COLUMN' 	=> $admin_icon['page_column'],
			'IMG_ICON_FUNCTION' 	=> $admin_icon['function'],
			'IMG_ICON_PARAMETER' 	=> $admin_icon['parameter'],
			'IMG_ICON_BLOCK' 		=> $admin_icon['block'],
			'IMG_ICON_EDIT_BLOCK' 	=> $admin_icon['edit_block'],

			//
			// Cookies
			//
			'COOKIE_NAME'		=> $board_config['cookie_name'],
			'COOKIE_PATH'		=> $board_config['cookie_path'],
			'COOKIE_DOMAIN'		=> $board_config['cookie_domain'],
			'COOKIE_SECURE'		=> $board_config['cookie_secure'],

			'L_SUBJECT' 		=> $lang['Subject'],
			'L_SUBMIT' 			=> $lang['Submit'],
			'L_CANCEL' 			=> $lang['Cancel'],

			'L_SUBMIT' 			=> $lang['Update'],
			'L_RESET' 			=> $lang['Reset'],
			'L_MENU_PAR_TITLE' 	=> $lang['Menu_par_title'],

			'L_MENU_TITLE' 		=> $lang['Menu_admin'],
			'L_MENU_EXPLAIN' 	=> $lang['Menu_admin_explain'],

			'S_SHOW_CAT' 			=> $show_cat_sel,
			'U_PHPBB_ROOT_PATH' 	=> PHPBB_URL,
			'TEMPLATE_ROOT_PATH' 	=> TEMPLATE_ROOT_PATH,

			'L_EDIT' 		=> $lang['Edit'],
			'L_MOVE_UP' 	=> $lang['Move_up'],
			'L_MOVE_DOWN' 	=> $lang['Move_down'],
			'L_RESYNC' 		=> $lang['Resync'],
			'L_CHANGE_NOW' 	=> $lang['Change'],

			'L_BLOCK' 		=> $lang['Block'],

			'S_ACTION'		=> mx_append_sid(PORTAL_URL . $s_action_file),
		));

		if( !empty($portalpage) )
		{
			$template->assign_block_vars('block_mode', array(
				'U_RETURN' => mx_append_sid(PORTAL_URL . "index.$phpEx?page=$portalpage")
			));
		}

		//
		// ---------------------------------------------------------------------------------- Cats
		//

		// Display list of Categories ---------------------------------------------------------------
		// ---------------------------------------------------------------------------------------

		/*
		$sql = "SELECT *
			FROM " . MENU_CAT_TABLE . "
			WHERE block_id = '" . $block_id . "'
			ORDER BY cat_order";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt query Navigation Categories', '', __LINE__, __FILE__, $sql );
		}

		$cat_rows = array();
		if( $total_cats = $db->sql_numrows($result) )
		{
			$cat_rows = $db->sql_fetchrowset($result);
		}

		$db->sql_freeresult($result);
		*/

		$cat_rows = array();
		if (isset($mx_page->subpage_rowset[$parent_page]))
		{
			foreach ($mx_page->subpage_rowset[$parent_page] as $temp_page_id => $cat_row)
			{
					$cat_rows[] = $cat_row;
			}
		}
		$total_cats = count($cat_rows);

		if ( $total_cats == 0 )
		{
			$template->assign_block_vars('nocat', array(
				'NONE' => $lang['No_pages']
			));
		}

		for( $cat_count = 0; $cat_count < $total_cats; $cat_count++ )
		{
			$cat_id = $cat_rows[$cat_count]['page_id'];

			$mode = MX_MENU_PAGE_TYPE;
			$action = MX_DO_UPDATE;

			$upmode = '?panel_mode=' . $mode . '&amp;panel_action=' . MX_DO_MOVE . '&amp;id=' . $cat_id . '&amp;block_id=' . $block_id . '&amp;block_order=' . $block_order . '&amp;move=-15' . '&amp;portalpage=' . $portalpage. '&amp;dynamic_block=' . $dynamic_block_id;
			$downmode = '?panel_mode=' . $mode . '&amp;panel_action=' . MX_DO_MOVE . '&amp;id=' . $cat_id . '&amp;block_id=' . $block_id . '&amp;block_order=' . $block_order . '&amp;move=15' . '&amp;portalpage=' . $portalpage. '&amp;dynamic_block=' . $dynamic_block_id;

			//
			// Hidden fields
			//
			$s_hidden_cat_fields = 	'<input type="hidden" name="panel_mode" value="' . $mode . '" />
											<input type="hidden" name="panel_action" value="' . $action . '" />
											<input type="hidden" name="id" value="' . $cat_id . '" />
											<input type="hidden" name="block_id" value="' . $block_id . '" />
											<input type="hidden" name="dynamic_block" value="' . $dynamic_block_id . '" />
											<input type="hidden" name="portalpage" value="' . $portalpage . '" />
											<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

			$cat_title = $cat_rows[$cat_count]['page_name'];

			//
			// Page subpanel - edit
			//
			$menu_active = $cat_rows[$cat_count]['menu_active'];

			if( $menu_active == 1 )
			{
				$menu_active_select = '<select name="menu_active"><option value="1" selected="selected">' . ( !empty($lang['Menu_active']) ? $lang['Menu_active'] : 'Menu_active' ) . '</option><option value="0">' . ( !empty($lang['Menu_not_active']) ? $lang['Menu_not_active'] : 'Menu_not_active' ) . '</option></select>';
			}
			else
			{
				$menu_active_select = '<select name="menu_active"><option value="1">' . ( !empty($lang['Menu_active']) ? $lang['Menu_active'] : 'Menu_active' ) . '</option><option value="0" selected="selected">' . ( !empty($lang['Menu_not_active']) ? $lang['Menu_not_active'] : 'Menu_not_active' ) . '</option></select>';
			}

			$menuicons = post_icons('menu_icons/', $cat_rows[$cat_count]['menu_icon']);
			$menu_alt_icon = $cat_rows[$cat_count]['menu_alt_icon'];
			$menu_alt_icon_hot = $cat_rows[$cat_count]['menu_alt_icon_hot'];

			$visible_cat = in_array('adminCat_' . $cat_id, $cookie_states);
			$visible_cat_edit = in_array('adminCatEdit_' . $cat_id, $cookie_states);

			$template->assign_block_vars('catrow', array(
				'CAT_ID' 					=> $cat_id,

				'VISIBLE' 					=> $visible_cat ? 'block' : 'none',
				'VISIBLE_EDIT' 				=> $visible_cat_edit || $new_page ? 'block' : 'none',

				'IMG_URL' 					=> $visible_cat ? $admin_icon['contract'] : $admin_icon['expand'],
				'IMG_URL_EDIT' 				=> $visible_cat_edit ? $admin_icon['contract'] : $admin_icon['expand'],

				'CAT_TITLE' 				=> $cat_title,

				'U_CAT_MOVE_UP' 			=> mx_append_sid($mx_root_path . $s_action_file . $upmode . '&amp;sid=' . $userdata['session_id']),
				'U_CAT_MOVE_DOWN' 			=> mx_append_sid($mx_root_path . $s_action_file . $downmode . '&amp;sid=' . $userdata['session_id'] ),

				//
				// EDIT CAT
				//
				'L_TITLE_EDIT' 				=> $lang['Edit_Category'],

				'L_CAT_TITLE' 				=> $lang['Category'],
				'L_MENU_ICON' 				=> $lang['Menu_icon'],
				'L_MENU_ALT_ICON' 			=> $lang['Menu_alt_icon'],
				'L_MENU_ALT_ICON_HOT' 		=> $lang['Menu_alt_icon_hot'],
				'L_MENU_ACTIVE' 			=> $lang['Menu_active_select'],

				'E_CAT_TITLE' 				=> $cat_title,
				'E_MENU_ICON' 				=> $menuicon,
				'E_MENU_ALT_ICON' 			=> $menu_alt_icon,
				'E_MENU_ALT_ICON_HOT' 		=> $menu_alt_icon_hot,
				'S_POSTICONS' 				=> $menuicons,
				'S_MENU_ACTIVE' 			=> $menu_active_select,

				'S_HIDDEN_FIELDS' 			=> $s_hidden_cat_fields,
				'S_SUBMIT' 					=> $lang['Update']

			));

			/*
			$num_of_menus = count($catData);
			*/

			/*
			$sql = "SELECT *
				FROM " . MENU_NAV_TABLE . "
				WHERE cat_id = '" . $cat_id . "'
				ORDER BY menu_order";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt query Navigation menus', '', __LINE__, __FILE__, $sql );
			}

			$menu_rows = array();
			if( $total_menus = $db->sql_numrows($result) )
			{
				$menu_rows = $db->sql_fetchrowset($result);
			}

			$db->sql_freeresult($result);
			*/

			$menu_rows = array();
			if (isset($mx_page->subpage_rowset[$cat_id]))
			{
				foreach ($mx_page->subpage_rowset[$cat_id] as $temp_subpage_id => $menu_row)
				{
						$menu_rows[] = $menu_row;
				}
			}
			$total_menus = count($menu_rows);

			if ( $total_menus == 0 )
			{
				$template->assign_block_vars('catrow.nocat', array(
					'NONE' => $lang['No_pages']
				));
			}

			for( $menu_count = 0; $menu_count < $total_menus; $menu_count++ )
			{
				$menu_id = $menu_rows[$menu_count]['page_id'];

				$mode = MX_MENU_PAGE_TYPE;
				$action = MX_DO_UPDATE;

				$upmode = '?panel_mode=' . $mode . '&amp;panel_action=' . MX_DO_MOVE . '&amp;id=' . $menu_id . '&amp;cat_id=' . $cat_id . '&amp;block_id=' . $block_id . '&amp;block_order=' . $block_order . '&amp;move=-15';
				$downmode = '?panel_mode=' . $mode . '&amp;panel_action=' . MX_DO_MOVE . '&amp;id=' . $menu_id . '&amp;cat_id=' . $cat_id . '&amp;block_id=' . $block_id . '&amp;block_order=' . $block_order . '&amp;move=15';

				//
				// Hidden fields
				//
				$s_hidden_menu_fields = 	'<input type="hidden" name="panel_mode" value="' . $mode . '" />
												<input type="hidden" name="panel_action" value="' . $action . '" />
												<input type="hidden" name="id" value="' . $menu_id . '" />
												<input type="hidden" name="block_id" value="' . $block_id . '" />
												<input type="hidden" name="portalpage" value="' . $portalpage . '" />
												<input type="hidden" name="cat_id" value="' . $cat_id . '" />
												<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';


				$menuname = $menu_rows[$menu_count]['page_name'];

				$menu_active = $menu_rows[$menu_count]['menu_active'];

				if( $menu_active == 1 )
				{
					$menu_active_select = '<select name="menu_active"><option value="1" selected="selected">' . ( !empty($lang['Menu_active']) ? $lang['Menu_active'] : 'Menu_active' ) . '</option><option value="0">' . ( !empty($lang['Menu_not_active']) ? $lang['Menu_not_active'] : 'Menu_not_active' ) . '</option></select>';
				}
				else
				{
					$menu_active_select = '<select name="menu_active"><option value="1">' . ( !empty($lang['Menu_active']) ? $lang['Menu_active'] : 'Menu_active' ) . '</option><option value="0" selected="selected">' . ( !empty($lang['Menu_not_active']) ? $lang['Menu_not_active'] : 'Menu_not_active' ) . '</option></select>';
				}

				$menuicons = post_icons('menu_icons/', $menu_rows[$menu_count]['menu_icon']);
				$menu_alt_icon = $menu_rows[$menu_count]['menu_alt_icon'];
				$menu_alt_icon_hot = $menu_rows[$menu_count]['menu_alt_icon_hot'];

				// Replace htmlentites for < and > with actual character.
				$row_class = ( !( $menu_count % 2 ) ) ? 'row1' : 'row2';

				$visible_menu_edit = in_array('adminMenuEdit_' . $menu_id, $cookie_states);

				$template->assign_block_vars('catrow.menurow', array(
					'MENU_ID' 			=> $menu_id,

					"ROW_CLASS" 		=> $row_class,

					'VISIBLE_EDIT' 		=> $visible_menu_edit ? 'block' : 'none',

					'IMG_URL_EDIT' 		=> $visible_menu_edit ? $admin_icon['contract'] : $admin_icon['expand'],

					'MENU_TITLE' 		=> $menuname,
					'ROW_COLOR' 		=> $row_color,

					'U_MENU_MOVE_UP' 	=> mx_append_sid($mx_root_path . $s_action_file . $upmode . '&amp;sid=' . $userdata['session_id']),
					'U_MENU_MOVE_DOWN' 	=> mx_append_sid($mx_root_path . $s_action_file . $downmode . '&amp;sid=' . $userdata['session_id']),

					//
					// Menu EDIT
					//
					'L_TITLE_EDIT' 			=> $lang['Edit'],

					'L_MENU_TITLE' 				=> $l_title,
					'L_MENU_ACTION_TITLE' 		=> $lang['Menu_action_title'],
					'L_MENU_ACTION_ADV' 		=> $lang['Menu_action_adv'],
					'L_MENU_PERMISSIONS_TITLE' 	=> $lang['Menu_permissions_title'],

					'L_MENU_TITLE' 			=> $lang['Menu_name'],
					'L_MENU_ICON' 			=> $lang['Menu_icon'],
					'L_MENU_ALT_ICON' 		=> $lang['Menu_alt_icon'],
					'L_MENU_ALT_ICON_HOT' 	=> $lang['Menu_alt_icon_hot'],
					'L_MENU_CATEGORY' 		=> $lang['Category'],
					'L_MENU_ACTIVE' 			=> $lang['Menu_active_select'],

					'E_MENU_TITLE'		 	=> htmlspecialchars($menuname),
					'E_MENU_ICON' 			=> $menuicon,
					'E_MENU_ALT_ICON' 		=> $menu_alt_icon,
					'E_MENU_ALT_ICON_HOT' 	=> $menu_alt_icon_hot,
					'S_POSTICONS' 			=> $menuicons,
					'S_MENU_ACTIVE' 			=> $menu_active_select,

					'S_HIDDEN_FIELDS' 		=> $s_hidden_menu_fields,
					'S_SUBMIT' 				=> $lang['Update'],
				));

			} // for ... menus
		} // for ... categories

		$template->pparse('parameter');
	}

	function do_it( $mode = '', $action = '', $id = '', $parent = false, $recache = true )
	{
		switch ( $action )
		{
			case MX_DO_INSERT:
				$message = $this->_do_insert($mode, $id, $parent, $recache);
			break;

			case MX_DO_UPDATE:
				$message = $this->_do_update($mode, $id, $parent, $recache);
			break;

			case MX_DO_DELETE:
				$message = $this->_do_delete($mode, $id, $parent, $recache);
			break;

			case MX_DO_MOVE: // GET VARS
				$message = $this->_do_move($mode, $id);
			break;
		}

		if (!empty($message))
		{
			return $message;
		}
	}


	/********************************************************************************\
	| Used by admin_mx_module.php, for the pak_import
	\********************************************************************************/
	function _do_insert($type, $id )
	{
		global $mx_root_path, $phpbb_root_path, $template, $lang, $db, $board_config, $theme, $phpEx, $userdata, $mx_request_vars;

		switch ( $type )
		{
			case MX_MENU_CAT_TYPE:

				if ( !MX_PANEL_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('cat_title'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$block_id = $mx_request_vars->post('block_id', MX_TYPE_INT, '');

					$sql = "SELECT MAX(cat_order) AS max_order FROM " . MENU_CAT_TABLE . " WHERE block_id = " . $block_id;

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get order number from categories table", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					$max_order = $row['max_order'];
					$next_order = $max_order + 10;

					//
					// Get toggles
					//
					$bbcode_on = $board_config['allow_bbcode'] ? true : false;
					$html_on = $board_config['allow_html'] ? true : false;
					$smilies_on = $board_config['allow_smilies'] ? true : false;

					//
					// Instantiate the mx_text class
					//
					include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
					$mx_text = new mx_text();
					$mx_text->init($html_on, $bbcode_on, $smilies_on);

					//
					// Encode for db storage
					//
					$cat_title = $mx_text->encode_simple($mx_request_vars->post('cat_title', MX_TYPE_NO_STRIP | MX_TYPE_SQL_QUOTED, ''));
					$cat_desc = $mx_text->encode($mx_request_vars->post('cat_desc', MX_TYPE_NO_STRIP | MX_TYPE_SQL_QUOTED, ''));
					$bbcode_uid = $mx_text->bbcode_uid;

					$sql = "INSERT INTO " . MENU_CAT_TABLE . " (block_id, cat_title, cat_order, cat_desc, bbcode_uid, cat_show, cat_url, cat_target)
				            VALUES( '" . $block_id . "',
				                    '" . $cat_title . "',
				                    '" . $next_order . "',
				                    '" . $cat_desc . "',
				                    '" . $bbcode_uid . "',
				                    '" . $mx_request_vars->post('cat_show_sel', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
				                    '" . $mx_request_vars->post('cat_url_sel', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
				                    '" . $mx_request_vars->post('cat_target_sel', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "' )";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert row in categories table", "", __LINE__, __FILE__, $sql);
					}

					$sql = "SELECT MAX(cat_id) AS next_id FROM " . MENU_CAT_TABLE;
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't find max module_id", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					$cat_id_new = $row[next_id];
				}

				$message['text'] = $lang['AdminCP_action'] . ": " . $lang['Nav_menu_cat'] . ' (' . $mx_request_vars->post('cat_title', MX_TYPE_NO_TAGS, 'error - no name given') . ') ' . $lang['was_inserted'];
				$message['new_cat_menu_id'] = $cat_id_new;

			break;

			case MX_MENU_TYPE:

				if ( !MX_PANEL_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('menuname'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$cat_id = $mx_request_vars->request('cat_id', MX_TYPE_INT, '');

					$sql = "SELECT MAX(menu_order) AS max_order FROM " . MENU_NAV_TABLE . " WHERE cat_id = " . $cat_id;
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get order number from menus table", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					$max_order = $row['max_order'];
					$next_order = $max_order + 10;

					$sql = "SELECT MAX(menu_id) AS max_id FROM " . MENU_NAV_TABLE;
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get order number from menus table", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					$max_id = $row['max_id'];
					$next_id = $max_id + 1;

					//
					// Get toggles
					//
					$bbcode_on = $board_config['allow_bbcode'] ? true : false;
					$html_on = $board_config['allow_html'] ? true : false;
					$smilies_on = $board_config['allow_smilies'] ? true : false;

					//
					// Instantiate the mx_text class
					//
					include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
					$mx_text = new mx_text();
					$mx_text->init($html_on, $bbcode_on, $smilies_on);

					//
					// Encode for db storage
					//
					$menu_title = $mx_text->encode_simple($mx_request_vars->post('menuname', MX_TYPE_NO_STRIP | MX_TYPE_SQL_QUOTED, ''));
					$menu_desc = $mx_text->encode($mx_request_vars->post('message', MX_TYPE_NO_STRIP | MX_TYPE_SQL_QUOTED, ''));
					$bbcode_uid = $mx_text->bbcode_uid;

					$sql = "INSERT INTO " . MENU_NAV_TABLE . " (menu_id, menu_name, cat_id, function_id, block_id, page_id, menu_desc, menu_links, bbcode_uid, menu_order, menu_icon, menu_alt_icon, menu_alt_icon_hot, auth_view, auth_view_group, link_target)
						VALUES ('" . $next_id . "',
						'" . $menu_title . "',
						'" . $cat_id . "',
						'" . $mx_request_vars->post('function_id', MX_TYPE_INT, '') . "',
						'" . $mx_request_vars->post('block_nav', MX_TYPE_INT, '') . "',
						'" . $mx_request_vars->post('page_nav', MX_TYPE_INT, '') . "',
						'" . $menu_desc . "' ,
						'" . $mx_request_vars->post('menulinks', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
						'" . $bbcode_uid . "' ,
						'" . $next_order . "',
						'" . $mx_request_vars->post('menuicons', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
						'" . $mx_request_vars->post('menu_alt_icon', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
						'" . $mx_request_vars->post('menu_alt_icon_hot', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
						'" . $mx_request_vars->post('auth_view', MX_TYPE_INT, '') . "',
						'" . $mx_request_vars->post('auth_view_group', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
						'" . $mx_request_vars->post('link_target', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "' )";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert row in menus table", "", __LINE__, __FILE__, $sql);
					}
				}

				$message['text'] = $lang['AdminCP_action'] . ": " . $lang['Nav_menu'] . ' (' . $mx_request_vars->post('menuname', MX_TYPE_NO_TAGS, 'error - no name given') . ') ' . $lang['was_inserted'];
				$message['new_menu_id'] = $next_id;

			break;

			default:
				$message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];
			break;
		}

		return $message;
	}

	/********************************************************************************\
	| Used by admin_mx_module.php, for the pak_import
	\********************************************************************************/
	function _do_update($type, $id )
	{
		global $mx_root_path, $phpbb_root_path, $template, $lang, $db, $board_config, $theme, $phpEx, $userdata, $mx_request_vars, $mx_cache;

		switch ( $type )
		{
			case MX_MENU_CAT_TYPE:

				if ( !MX_PANEL_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('cat_title'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$block_id = $mx_request_vars->post('block_id', MX_TYPE_INT, '');

					//
					// Get toggles
					//
					$bbcode_on = $board_config['allow_bbcode'] ? true : false;
					$html_on = $board_config['allow_html'] ? true : false;
					$smilies_on = $board_config['allow_smilies'] ? true : false;

					//
					// Instantiate the mx_text class
					//
					include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
					$mx_text = new mx_text();
					$mx_text->init($html_on, $bbcode_on, $smilies_on);

					//
					// Encode for db storage
					//
					$cat_title = $mx_text->encode_simple($mx_request_vars->post('cat_title', MX_TYPE_NO_STRIP | MX_TYPE_SQL_QUOTED, ''));
					$cat_desc = $mx_text->encode($mx_request_vars->post('cat_desc', MX_TYPE_NO_STRIP | MX_TYPE_SQL_QUOTED, ''));
					$bbcode_uid = $mx_text->bbcode_uid;

					$sql = "UPDATE " . MENU_CAT_TABLE . "
				         SET block_id = '" . $block_id . "',
				             cat_title = '" . $cat_title . "',
				             cat_desc = '" . $cat_desc . "',
				             bbcode_uid = '" . $bbcode_uid . "',
				             cat_show = '" . $mx_request_vars->post('cat_show_sel', MX_TYPE_INT, '') . "',
				             cat_url = '" . $mx_request_vars->post('cat_url_sel', MX_TYPE_INT, '') . "',
				             cat_target = '" . $mx_request_vars->post('cat_target_sel', MX_TYPE_INT, '') . "'
				    	 WHERE cat_id = " . intval($id);

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update menu information", "", __LINE__, __FILE__, $sql);
					}

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Nav_menu_cat'] . ' (' . $mx_request_vars->post('cat_title', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'];

			break;

			case MX_MENU_TYPE:

				if ( !MX_PANEL_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('menuname'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					//
					// Get toggles
					//
					$bbcode_on = $board_config['allow_bbcode'] ? true : false;
					$html_on = $board_config['allow_html'] ? true : false;
					$smilies_on = $board_config['allow_smilies'] ? true : false;

					//
					// Instantiate the mx_text class
					//
					include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
					$mx_text = new mx_text();
					$mx_text->init($html_on, $bbcode_on, $smilies_on);

					//
					// Encode for db storage
					//
					$menu_title = $mx_text->encode_simple($mx_request_vars->post('menuname', MX_TYPE_NO_STRIP | MX_TYPE_SQL_QUOTED, ''));
					$menu_desc = $mx_text->encode($mx_request_vars->post('message', MX_TYPE_NO_STRIP | MX_TYPE_SQL_QUOTED, ''));
					$bbcode_uid = $mx_text->bbcode_uid;

					$sql = "UPDATE " . MENU_NAV_TABLE . "
				         SET menu_name = '" . $menu_title . "',
				             menu_icon = '" . $mx_request_vars->post('menuicons', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
				             menu_alt_icon = '" . $mx_request_vars->post('menu_alt_icon', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
				             menu_alt_icon_hot = '" . $mx_request_vars->post('menu_alt_icon_hot', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
				             cat_id = '" . $mx_request_vars->post('cat_id', MX_TYPE_INT, '') . "',
				             block_id = '" . $mx_request_vars->post('block_nav', MX_TYPE_INT, '') . "',
				             page_id = '" . $mx_request_vars->post('page_nav', MX_TYPE_INT, '') . "',
				             function_id = '" . $mx_request_vars->post('function_id', MX_TYPE_INT, '') . "',
				             menu_desc = '" . $menu_desc . "',
				             menu_links = '" . $mx_request_vars->post('menulinks', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
				             auth_view = '" . $mx_request_vars->post('auth_view', MX_TYPE_INT, '') . "',
				             auth_view_group = '" . $mx_request_vars->post('auth_view_group', MX_TYPE_INT, '') . "',
				             link_target = '" . $mx_request_vars->post('link_target', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
				             bbcode_uid = '" . $bbcode_uid . "'
				    	 WHERE menu_id = " . intval($id);

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update menu information", "", __LINE__, __FILE__, $sql);
					}

				}

			break;

			case MX_MENU_PAGE_TYPE:

				if ( !MX_PANEL_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('menuname') && $mx_request_vars->is_empty_post('cat_title'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					//
					// Get toggles
					//
					$bbcode_on = $board_config['allow_bbcode'] ? true : false;
					$html_on = $board_config['allow_html'] ? true : false;
					$smilies_on = $board_config['allow_smilies'] ? true : false;

					//
					// Instantiate the mx_text class
					//
					include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
					$mx_text = new mx_text();
					$mx_text->init($html_on, $bbcode_on, $smilies_on);

					//
					// Encode for db storage
					//
					if ($mx_request_vars->is_empty_post('cat_title'))
					{
						$menu_title = $mx_text->encode_simple($mx_request_vars->post('menuname', MX_TYPE_NO_STRIP | MX_TYPE_SQL_QUOTED, ''));
					}
					else
					{
						$menu_title = $mx_text->encode_simple($mx_request_vars->post('cat_title', MX_TYPE_NO_STRIP | MX_TYPE_SQL_QUOTED, ''));
					}

					$sql = "UPDATE " . PAGE_TABLE . "
				         SET page_name = '" . $menu_title . "',
				             menu_icon = '" . $mx_request_vars->post('menuicons', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
				             menu_alt_icon = '" . $mx_request_vars->post('menu_alt_icon', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
				             menu_alt_icon_hot = '" . $mx_request_vars->post('menu_alt_icon_hot', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
				             menu_active = '" . $mx_request_vars->post('menu_active', MX_TYPE_INT, '') . "'
				    	 WHERE page_id = " . intval($id);

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update page information", "", __LINE__, __FILE__, $sql);
					}

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_PAGE_TYPE, $id);

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Nav_menu'] . ' (' . $mx_request_vars->post('menuname', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'];

			break;

			default:
				$message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];

			break;
		}

		return $message;
	}

	/********************************************************************************\
	| Used by admin_mx_module.php, for the pak_import
	\********************************************************************************/
	function _do_delete($type, $id, $parent, $recache )
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $mx_request_vars;

		switch ( $type )
		{
			case MX_MENU_CAT_TYPE: // ????????

				//
				// Move or delete a category in the DB
				//
				$from_id = $mx_request_vars->post('from_id', MX_TYPE_INT, '');
				$to_id = $mx_request_vars->post('to_id', MX_TYPE_INT, '');
				$move_contents = $mx_request_vars->post('move_contents', MX_TYPE_INT, '') == '1';

				if( !empty($to_id) && $move_contents && !MX_PANEL_DEBUG)
				{
					$sql = "SELECT *
						FROM " . MENU_CAT_TABLE . "
						WHERE cat_id IN ($from_id, $to_id)";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't verify existence of categories", "", __LINE__, __FILE__, $sql);
					}
					if( $db->sql_numrows($result) != 2 )
					{
						mx_message_die(GENERAL_ERROR, "Ambiguous category ID's", "", __LINE__, __FILE__);
					}
					$db->sql_freeresult($result);

					$sql = "UPDATE " . MENU_NAV_TABLE . "
						SET cat_id = $to_id
						WHERE cat_id = $from_id";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't move menus to other category", "", __LINE__, __FILE__, $sql);
					}
				}

				$sql = "DELETE FROM " . MENU_CAT_TABLE . "
					WHERE cat_id = $from_id";

				if ( !MX_PANEL_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete category information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();
				}

				$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . $lang['Nav_menu_cat'] . ' (ID: ' . $from_id . ') ' . $lang['was_deleted'] . '<br />' . $message_child;

			break;

			case MX_MENU_TYPE: // ????????

				//
				// Move or delete a menu in the DB
				//

				$sql = "DELETE FROM " . MENU_NAV_TABLE . "
					WHERE menu_id = " . intval($id);

				if ( !MX_PANEL_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete category information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();
				}

				$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . $lang['Nav_menu'] . ' (ID: ' . intval($id) . ') ' . $lang['was_deleted'] . '<br />' . $message_child;

			break;

			default:
				$message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];

			break;
		}

		return $message;
	}

	/********************************************************************************\
	| Used by admin_mx_module.php, for the pak_import
	\********************************************************************************/
	function _do_move($type, $id)
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $mx_request_vars;

		switch ( $type )
		{
			case MX_MENU_CAT_TYPE:

				if ( !MX_PANEL_DEBUG )
				{
					//
					// Change order of categories in the DB
					//
					$cat_id = intval($id);
					$block_id = $mx_request_vars->request('block_id', MX_TYPE_INT, 0);
					$move = $mx_request_vars->request('move', MX_TYPE_INT, 0);

					$sql = "UPDATE " . MENU_CAT_TABLE . "
						SET cat_order = cat_order + $move
						WHERE cat_id = $cat_id
							AND block_id = $block_id";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't change category order", "", __LINE__, __FILE__, $sql);
					}

					$this->move_menu('category', $block_id);
					$show_index = true;
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Nav_menu_cat'] . ' ' . $lang['was_moved'];

			break;

			case MX_MENU_TYPE:

				if ( !MX_PANEL_DEBUG )
				{
					//
					// Change order of menus in the DB
					//
					$menu_id = intval($id);
					$block_id = $mx_request_vars->request('block_id', MX_TYPE_INT, 0);
					$cat_id = $mx_request_vars->request('cat_id', MX_TYPE_INT, 0);
					$move = $mx_request_vars->request('move', MX_TYPE_INT, 0);

					$sql = "UPDATE " . MENU_NAV_TABLE . "
						SET menu_order = menu_order + $move
						WHERE menu_id = $menu_id
							AND cat_id = $cat_id";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't change category order", "", __LINE__, __FILE__, $sql);
					}

					$this->move_menu('menu', $cat_id);
					$show_index = true;
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Nav_menu'] . ' ' . $lang['was_moved'];

			break;

			case MX_MENU_PAGE_TYPE:

				if ( !MX_PANEL_DEBUG )
				{
					//
					// Change order of menus in the DB
					//
					$page_id = intval($id);
					$block_id = $mx_request_vars->request('block_id', MX_TYPE_INT, 0);
					$parent_id = $mx_request_vars->request('cat_id', MX_TYPE_INT, 0);
					$move = $mx_request_vars->request('move', MX_TYPE_INT, 0);

					$sql = "UPDATE " . PAGE_TABLE . "
						SET page_order = page_order + $move
						WHERE page_id = $page_id
							AND page_parent = $parent_id";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't change page order", "", __LINE__, __FILE__, $sql);
					}

					$this->move_menu('page', $parent_id);
					$show_index = true;
				}

				$message = $lang['AdminCP_action'] . ": " . $lang['Nav_menu'] . ' ' . $lang['was_moved'];

			break;

			default:
				$message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];
			break;
		}

		return $message;
	}

	function move_menu($mode, $id = 0)
	{
		global $db, $portalpage;

		switch( $mode )
		{
			case 'category':
				$table = MENU_CAT_TABLE;
				$idfield = 'cat_id';
				$orderfield = 'cat_order';
				$blockidfield = 'block_id';
				$block_id = $id;
				break;

			case 'menu':
				$table = MENU_NAV_TABLE;
				$idfield = 'menu_id';
				$orderfield = 'menu_order';
				$catfield = 'cat_id';
				$cat_id = $id;
				break;

			case 'page':
				$table = PAGE_TABLE;
				$idfield = 'page_id';
				$orderfield = 'page_order';
				$catfield = 'page_parent';
				$cat_id = $id;
				break;

			default:
				mx_message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
				break;
		}

		$sql = "SELECT * FROM $table";
		switch( $mode )
		{
			case 'category':
				$sql .= " WHERE $blockidfield = $block_id";
				break;

			case 'menu':
				$sql .= " WHERE $catfield = $cat_id";
				break;

			case 'page':
				$sql .= " WHERE $catfield = $cat_id";
				break;

			default:
				mx_message_die(GENERAL_ERROR, "Wrong mode", "", __LINE__, __FILE__);
				break;
		}
		$sql .= " ORDER BY $orderfield ASC";

		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't get list of Categories", "", __LINE__, __FILE__, $sql);
		}

		$i = 10;
		$inc = 10;

		while( $row = $db->sql_fetchrow($result) )
		{
			$sql = "UPDATE $table
				SET $orderfield = $i
				WHERE $idfield = " . $row[$idfield];
			if( !($db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't update order fields", "", __LINE__, __FILE__, $sql);
			}
			$i += 10;
		}
	}
}
?>