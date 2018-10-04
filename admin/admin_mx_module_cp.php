<?php
/**
*
* @package MX-Publisher Core
* @version $Id: admin_mx_module_cp.php,v 1.23 2008/02/11 11:13:16 joasch Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !empty($setmodules) )
{
	$module['2_CP']['2_2_ModuleCP'] = 'admin/' . basename(__FILE__);
	return;
}

//
// Security and Page header
//
define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = TRUE;
require('./pagestart.' . $phpEx);

//
// Instatiate the mx_admin class
//
$mx_admin = new mx_admin();

//
// Mode & Action setting
//
$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS, '');
$action = $mx_request_vars->request('action', MX_TYPE_NO_TAGS, '');

//
// Main module id, to load the adminCP blocks and parameter data
//
$nav_module_id = $mx_request_vars->request('module_id', MX_TYPE_INT, '');

if ( empty($nav_module_id) )
{
	$cookie_tmp = $board_config['cookie_name'].'_adminModule_module_id';
	$nav_module_id = !empty($_COOKIE[$cookie_tmp]) ? $_COOKIE[$cookie_tmp] : '';
}

//
// Update
//
if( !empty($mode) && !empty($action) )
{
	//
	// Get vars
	//
	$portalpage = $mx_request_vars->request('portalpage', MX_TYPE_INT, 1);
	$id = $mx_request_vars->request('id', MX_TYPE_INT, '');

	//
	// Send to adminCP
	//
	$result_message = $mx_admin->do_it($mode, $action, $id);

	//
	// If new page, load new page settings panel
	//
	if (is_array($result_message))
	{
		$new_id = $result_message['new_id'];
		$result_message = $result_message['text'];
	}
	$result_message = $lang['AdminCP_status'] . '<hr>' . $result_message;

} // if .. !empty($mode)

//
// Load states
//
$cookie_tmp = $board_config['cookie_name'].'_admincp_blockstates';
$cookie_states = !empty($_COOKIE[$cookie_tmp]) ? explode(",", $_COOKIE[$cookie_tmp]) : array();

$sort_cookie = !empty($_COOKIE[$board_config['cookie_name'] . '_pagesort']) ? explode(",", $_COOKIE[$board_config['cookie_name'] . '_pagesort']) : array();

if ($mx_request_vars->is_post('include_block_quickedit'))
{
	switch ($mx_request_vars->post('include_block_quickedit', MX_TYPE_NO_TAGS))
	{
		case '0':
			$mx_modulecp_include_block_quickedit = false;
			break;
		case '1':
			$mx_modulecp_include_block_quickedit = true;
			break;
		default:
			$mx_modulecp_include_block_quickedit = !empty($sort_cookie[3]) ? $sort_cookie[3] == '1' : false;
	}
}
else
{
	$mx_modulecp_include_block_quickedit = !empty($sort_cookie[3]) ? $sort_cookie[3] == '1' : false;
}

if ($mx_request_vars->is_post('include_block_private'))
{
	switch ($mx_request_vars->post('include_block_private', MX_TYPE_NO_TAGS) )
	{
		case '0':
			$mx_modulecp_include_block_private = false;
			break;
		case '1':
			$mx_modulecp_include_block_private = true;
			break;
		default:
			$mx_modulecp_include_block_private = !empty($sort_cookie[4]) ? $sort_cookie[4] == '1' : false;
	}
}
else
{
	$mx_modulecp_include_block_private = !empty($sort_cookie[4]) ? $sort_cookie[4] == '1' : false;
}

/*
if ($mx_request_vars->is_post('include_all'))
{
	switch ( $mx_request_vars->post('include_all', MX_TYPE_NO_TAGS))
	{
		case '0':
			$include_all = '0';
			break;
		case '1':
			$include_all = '1';
			break;
		default:
			$include_all = isset($sort_cookie[5]) ? $sort_cookie[5] : '0';
	}
}
else
{
	$include_all = isset($sort_cookie[5]) ? $sort_cookie[5] : '0';

}
*/
$include_all = 0;

$sort_cookie = array(isset($sort_cookie[0]) ? $sort_cookie[0] : '', isset($sort_cookie[1]) ? $sort_cookie[1] : '', isset($sort_cookie[2]) ? $sort_cookie[2] : intval($include_all), intval($mx_modulecp_include_block_quickedit), intval($mx_modulecp_include_block_private), intval($include_all));
setcookie($board_config['cookie_name'] . '_pagesort', implode(',', $sort_cookie), time() + 10000000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);

// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
//
// Start page proper
//
$block_auth_fields = array('auth_view', 'auth_edit');

$block_auth_ary = array(
	'auth_view'		=> AUTH_ALL,
	'auth_edit'		=> AUTH_MOD,
);

$block_auth_levels = array('ALL', 'REG', 'PRIVATE', 'MOD', 'ADMIN', 'ANONYMOUS');
$block_auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN, AUTH_ANONYMOUS);

$field_names = array(
	'auth_view'		=> $lang['View'],
	'auth_edit'		=> $lang['Edit'],
);

$template->set_filenames(array( 'admin_block' => 'admin/mx_modulecp_admin_body.tpl') );

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
// Send to template
//
$template->assign_vars(array(
	'L_TITLE' => $lang['Modulecp_admin'],
	'L_EXPLAIN' => $lang['Modulecp_admin_explain'],

	'NAV_MODULE_ID' => $nav_module_id,
	'U_PORTAL_ROOT_PATH' => PORTAL_URL,
	'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,

	'SID'						=> $userdata['session_id'],
	'RESULT_MESSAGE'			=> !empty($result_message) ? '<div style="overflow:auto; height:50px;"><span class="gensmall">' . $result_message  . '<br/> -::-</span></div>': '',

	//
	// General
	//
	"L_ACTION" => $lang['Action'],
	"L_DELETE" => $lang['Delete'],
	'L_SETTING' => $lang['Settings'],
	'L_VIEW' => $lang['View'],
	"L_EDIT" => $lang['Edit'],
	"L_ADD" => $lang['Create_parameter'],
	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],

	'L_CREATE_BLOCK' => ( !empty($lang['Create_block']) ) ? $lang['Create_block'] : 'Create new block',
	'L_MOVE_UP' => $lang['Move_up'],
	'L_MOVE_DOWN' => $lang['Move_down'],
	'L_RESYNC' => $lang['Resync'],

	'L_QUICK_NAV' => $lang['Quick_nav'],
	'L_INCLUDE_ALL' => $lang['Include_all_modules'],
	'L_INCLUDE_BLOCK_QUICKEDIT' => $lang['Include_block_quickedit'],
	'L_INCLUDE_BLOCK_PRIVATE' => $lang['Include_block_private'],

	'S_SUBMIT' => $lang['Update'],

	//
	// Parameter
	//
	'L_PARAMETER_NAME' => $lang['Parameter_name'],
	'L_PARAMETER_DESC' => $lang['Parameter_desc'],
	'L_PARAMETER_TYPE' => $lang['Parameter_type'],
	'L_PARAMETER_DEFAULT' => $lang['Parameter_default'],
	'L_PARAMETER_FUNCTION' => $lang['Parameter_function'],
	"L_PARAMETER_TITLE" => $lang['Parameter_admin'],
	"L_PARAMETER_TEXT" => $lang['Parameter_admin_explain'],
	'L_PARAMETER_ID' => $lang['Parameter_id'],

	//
	// Function
	//
	'L_FUNCTION' => $lang['Function'],
	'L_FUNCTION_TITLE' => $lang['Function_name'],
	'L_FUNCTION_DESC' => $lang['Function_desc'],
	'L_FUNCTION_FILE' => $lang['Function_file'],
	'L_FUNCTION_ADMIN_FILE' => $lang['Function_admin_file'],
	'L_ADD_FUNCTION' => $lang['Create_function'],

	//
	// Module
	//
	'L_MODULE' => $lang['Module'],
	'L_MODULE_NAME' => $lang['Module_name'],
	'L_MODULE_DESC' => $lang['Module_desc'],
	'L_MODULE_PATH' => $lang['Module_path'],
	'L_MODULE_INCLUDE_ADMIN' => $lang['Module_include_admin'],

	//
	// Block
	//
	'L_AUTH_TITLE' => $lang['Auth_Block'],
	'L_AUTH_TITLE_EXPLAIN' => $lang['Auth_Block_explain'],
	'L_BLOCK_TITLE' => $lang['Block_title'],
	'L_BLOCK_DESC' => $lang['Block_desc'],
	'L_SHOW_BLOCK' 		=> $lang['Show_block'],
	'L_SHOW_BLOCK_EXPLAIN' => $lang['Show_block_explain'],
	'L_SHOW_TITLE' 		=> $lang['Show_title'],
	'L_SHOW_TITLE_EXPLAIN' => $lang['Show_title_explain'],
	'L_SHOW_STATS' 		=> $lang['Show_stats'],
	'L_SHOW_STATS_EXPLAIN' => $lang['Show_stats_explain'],
	'L_GROUPS' 					=> $lang['Usergroups'],
	'L_IS_MODERATOR' 			=> $lang['Is_Moderator'],

	//
	// Graphics
	//
	'IMG_URL_CONTRACT' => $admin_icon['contract'],
	'IMG_URL_EXPAND' => $admin_icon['expand'],

	'IMG_ICON_MODULE' => $admin_icon['module'],
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

	'S_ACTION' => mx_append_sid("admin_mx_module_cp.$phpEx"),
	'S_ACTION_DEFAULT' => mx_append_sid("admin_mx_module_cp.$phpEx"),

	//
	// Sorting Options
	//
	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],

	'S_INCLUDE_ALL_YES' => ( $include_all == '1' ) ? 'checked="checked"' : '',
	'S_INCLUDE_ALL_NO' => ( $include_all == '0' ) ? 'checked="checked"' : '',

	'S_INCLUDE_BLOCK_QUICKEDIT_YES' => ( $mx_modulecp_include_block_quickedit == '1' ) ? 'checked="checked"' : '',
	'S_INCLUDE_BLOCK_QUICKEDIT_NO' => ( $mx_modulecp_include_block_quickedit == '0' ) ? 'checked="checked"' : '',

	'S_INCLUDE_BLOCK_PRIVATE_YES' => ( $mx_modulecp_include_block_private == '1' ) ? 'checked="checked"' : '',
	'S_INCLUDE_BLOCK_PRIVATE_NO' => ( $mx_modulecp_include_block_private == '0' ) ? 'checked="checked"' : ''
));

//
// ---------------------------------------------------------------------------------- Modules
//

if ($mx_modulecp_include_block_private)
{
	//
	// Get the list of phpBB usergroups
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
		mx_message_die(GENERAL_ERROR, 'Could not get group list', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$groupdata[] = $row;
	}
	$db->sql_freeresult($result);
}

//
// Get current/active module
//
$sql = "SELECT *
	FROM " . MODULE_TABLE . "
	WHERE module_id = '" . $nav_module_id . "'
	ORDER BY module_name ASC";

if( !($q_modules_current = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, "Could not query modules information", "", __LINE__, __FILE__, $sql);
}

$module_rows_current = array();
if( $total_modules_current = $db->sql_numrows($q_modules_current) )
{
	$module_rows_current = $db->sql_fetchrowset($q_modules_current);
}
$db->sql_freeresult($result);

//
// Get the rest modules
//
$sql = "SELECT *
	FROM " . MODULE_TABLE . "
	WHERE module_id <> '" . $nav_module_id . "'
	ORDER BY module_name ASC";

if( !($q_modules = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, "Could not query modules information", "", __LINE__, __FILE__, $sql);
}

$module_rows = array();
if( $total_modules = $db->sql_numrows($q_modules) )
{
	$module_rows = $db->sql_fetchrowset($q_modules);
}

$db->sql_freeresult($result);

if ( $total_modules + $total_modules_current == 0 )
{
	$template->assign_block_vars('nomodule', array(
		'NONE' => $lang['No_modules']
	));
}

$module_rows = array_merge($module_rows_current, $module_rows);
$total_modules = $total_modules + $total_modules_current;

//
// Setup an additional var for the quick nav dropdown
//
$module_rows_select = array();

//
// Module loop
//
for( $module_count = 0; $module_count < $total_modules + 1; $module_count++ )
{
	//
	// Give main vars specific names
	//
	$module_id = $module_rows[$module_count]['module_id'];
	$is_current_module = ($module_id == $nav_module_id);

	if ($module_count != $total_modules)
	{
		$module_rows_select[$module_id] = $module_rows[$module_count]['module_name'];
	}

	if (!$include_all && $module_count > 0)
	{
		continue;
	}

	$mode = MX_MODULE_TYPE;
	$action = MX_DO_UPDATE;

	//
	// Hidden fields
	//
	$s_hidden_module_fields = 	'<input type="hidden" name="mode" value="' . $mode . '" />
								<input type="hidden" name="action" value="' . $action . '" />
								<input type="hidden" name="id" value="' . $module_id . '" />
								<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

	$check_opt = '';

	if( $module_rows[$module_count]['module_include_admin'] == 1 )
	{
		$check_opt = 'checked="checked"';
	}

	// **********************************************************************
	// Read language definition
	// **********************************************************************
	if( file_exists($mx_root_path . $module_rows[$module_count]['module_path'] . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) )
	{
		include($mx_root_path . $module_rows[$module_count]['module_path'] . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
	}
	else if( file_exists($mx_root_path . $module_rows[$module_count]['module_path'] . 'language/lang_english/lang_admin.' . $phpEx) )
	{
		include($mx_root_path . $module_rows[$module_count]['module_path'] . 'language/lang_english/lang_admin.' . $phpEx);
	}

	//
	// Load module specidic block parameters - add to standard
	//
	$type_row = array();

	if ( file_exists( $mx_root_path . $module_rows[$module_count]['module_path'] . 'admin/mx_module_defs.' . $phpEx ) )
	{
		include_once( $mx_root_path . $module_rows[$module_count]['module_path'] . 'admin/mx_module_defs.' . $phpEx );

		if (class_exists('mx_module_defs'))
		{
			$mx_module_defs = new mx_module_defs();

			if ( method_exists( $mx_module_defs,  'get_parameters' ) )
			{
				$type_row = $mx_module_defs->get_parameters($type_row);
			}
		}
	}

	$type_row['Text'] = !empty($lang['ParType_Text']) ? $lang['ParType_Text'] : "Text";
	$type_row['TextArea'] = !empty($lang['ParType_TextArea']) ? $lang['ParType_TextArea'] : "TextArea";
	$type_row['BBText'] = !empty($lang['ParType_BBText']) ? $lang['ParType_BBText'] : "BBText";
	$type_row['Html'] = !empty($lang['ParType_Html']) ? $lang['ParType_Html'] : "Html" ;
	$type_row['Boolean'] = !empty($lang['ParType_Boolean']) ? $lang['ParType_Boolean'] : "Boolean";
	$type_row['Number'] = !empty($lang['ParType_Number']) ? $lang['ParType_Number'] : "Number" ;

	$type_row['Radio_single_select'] = !empty($lang['ParType_Radio_single_select']) ? $lang['ParType_Radio_single_select'] : "Radio_single_select";
	$type_row['Menu_single_select'] = !empty($lang['ParType_Menu_single_select']) ? $lang['ParType_Menu_single_select'] : "Menu_single_select";
	$type_row['Menu_multiple_select'] = !empty($lang['ParType_Menu_multiple_select']) ? $lang['ParType_Menu_multiple_select'] : "Menu_multiple_select";
	$type_row['Checkbox_multiple_select'] = !empty($lang['ParType_Checkbox_multiple_select']) ? $lang['ParType_Checkbox_multiple_select'] : "Checkbox_multiple_select";

	$type_row['Function'] = !empty($lang['ParType_Function']) ? $lang['ParType_Function'] : "Function";
	$type_row['Separator'] = !empty($lang['ParType_Separator']) ? $lang['ParType_Separator'] : "-Separator-";

	//
	// Module subpanel - edit
	//
	$visible = in_array('adminModule_' . $module_id, $cookie_states);

	$template->assign_block_vars('module', array(
		'L_TITLE' => $lang['Module_admin'],
		'L_MODULE' => $lang['Module'],
		'VISIBLE' => $visible ? 'block' : 'none',

		'IMG_URL' => $visible ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',

		'MODULE_ID' => $module_id,
		'MODULE_TITLE' => $module_rows[$module_count]['module_name'],
		'MODULE_DESC' => ( $module_rows[$module_count]['module_desc'] != '' ) ? ' - ' . $module_rows[$module_count]['module_desc'] : '',

		'U_MODULE_EDIT' => mx_append_sid(PORTAL_URL . "admin/admin_mx_module.$phpEx?module_id=" . $module_rows[$module_count]['module_id']),

		//
		// Module subpanel - edit
		//
		'E_MODULE_NAME' => $module_rows[$module_count]['module_name'],
		'E_MODULE_DESC' => $module_rows[$module_count]['module_desc'],
		'E_MODULE_PATH' => $module_rows[$module_count]['module_path'],
		'E_MODULE_INCLUDE_CHECK_OPT' => $check_opt,

		'S_HIDDEN_FIELDS' => $s_hidden_module_fields,

		'S_SUBMIT' => $lang['Update']

		));

	if ( $module_count == 1 )
	{
		$template->assign_block_vars('module.allmodules', array());
	}

	if ( $is_current_module )
	{
		$template->assign_block_vars('module.is_current', array());
	}
	else
	{
		$template->assign_block_vars('module.reload', array(
			'U_MODULE_EDIT' => mx_append_sid(PORTAL_URL . "admin/admin_mx_module_cp.$phpEx?module_id=" . $module_id),
		));

		//
		// Only load all parameters for current module
		//
		continue;
	}

	// ----------------------------------------------------------------------------------Functions
	// Now continue with the module functions
	//
	$sql = "SELECT *
		FROM " . FUNCTION_TABLE . "
		WHERE module_id = '" . $module_rows[$module_count]['module_id'] . "'
		ORDER BY  function_name ASC";

	if( !($q_functions = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Could not query functions information", "", __LINE__, __FILE__, $sql);
	}

	$function_rows = array();
	if( $total_functions = $db->sql_numrows($q_functions) )
	{
		$function_rows = $db->sql_fetchrowset($q_functions);
	}

	$db->sql_freeresult($result);

	if ( $total_functions == 0 )
	{
		$template->assign_block_vars('module.nofunction', array(
			'NONE' => $lang['No_functions']
		));
	}

	//
	// Function loop
	//
	for( $function_count = 0; $function_count < $total_functions + 1; $function_count++ )
	{
		$new_function = $function_count == $total_functions;
		$function_id = $new_function ? $module_id . '_0' : $function_rows[$function_count]['function_id'];
		$id = $new_function ? $module_id : $function_id;

		$mode = MX_FUNCTION_TYPE;
		$action = $new_function ? MX_DO_INSERT : MX_DO_UPDATE;
		$deletemode = '?mode=' . $mode . '&amp;action=' . MX_DO_DELETE . '&amp;id=' . $function_id;

		//
		// Hidden fields
		//
		$s_hidden_function_fields = '<input type="hidden" name="mode" value="' . $mode . '" />
									<input type="hidden" name="action" value="' . $action . '" />
									<input type="hidden" name="id" value="' . $id . '" />
									<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		$function_title = !$new_function ? $function_rows[$function_count]['function_name'] : '';
		$function_desc = !$new_function ? $function_rows[$function_count]['function_desc'] : '';
		$function_file = !$new_function ? $function_rows[$function_count]['function_file'] : '';
		$function_admin_file = !$new_function ? $function_rows[$function_count]['function_admin'] : '';

		$message_delete = $lang['Delete_function'] . ' - ' . $function_title
					. '<br /><br />' . $lang['Delete_function_explain']
					. '<br /><br />' . sprintf($lang['Click_function_delete_yes'], '<a href="' . mx_append_sid("admin_mx_module_cp.$phpEx" . $deletemode) . '">', '</a>')
					. '<br /><br />';

		$module_path = '../' . $module_rows[$module_count]['module_path'];

		//
		// Function subpanel - edit
		//
		$visible_func_tag = in_array('adminFunction_' . $function_id, $cookie_states);
		$visible_func_delete_tag = in_array('adminFunctionDelete_' . $function_id, $cookie_states);
		$visible_par_tag = in_array('adminParameter_' . $function_id, $cookie_states);
		$visible_block_tag = in_array('adminBlock_' . $function_id, $cookie_states);

		$template->assign_block_vars('module.function', array(
			'L_TITLE' => $lang['Function_admin'],
			'L_TITLE_PAR' => $lang['Parameter_admin'],

			'L_EDIT' => $new_function ? '' : $lang['Edit'],
			'L_EDIT_PAR' => $new_function ? '' : $lang['Parameters'],
			'L_SHOW_BLOCKS' => $new_function ? '' : $lang['Show_blocks'],
			'L_DELETE' => $new_function ? '' : $lang['Delete'],

			'COOKIE_TAG' => $new_function ? 'adminFunction_' : 'adminBlock_',

			'VISIBLE_FUNC' => $visible_func_tag ? 'block' : 'none',
			'VISIBLE_DELETE' => $visible_func_delete_tag ? 'block' : 'none',
			'VISIBLE_PAR' => $visible_par_tag ? 'block' : 'none',
			'VISIBLE_BLOCK' => $visible_block_tag ? 'block' : 'none',

			'IMG_URL_FUNC' => $visible_func_tag ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',
			'IMG_URL_DELETE' => $visible_func_delete_tag ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',
			'IMG_URL_PAR' => $visible_par_tag ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',
			'IMG_URL_BLOCK' => $visible_block_tag ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',

			'FUNCTION_ID' => $function_id,
			'FUNCTION_TITLE' => $new_function ? '<span class="cattitle">'. $lang['Create_function'] . '</span>' : '<span class="topictitle">'.$lang['Function'].': </span>'.$function_title,
			'FUNCTION_DESC' => ( $function_desc != '' ) ? ' - ' . $function_desc : '',

			'U_FUNCTION_DELETE' => mx_append_sid(PORTAL_URL . "admin/admin_mx_module_cp.$phpEx" . $deletemode),

			//
			// Function subpanel - edit
			//
			'L_MODULE' => $lang['Module'],
			'L_FUNCTION' => $lang['Function'],
			'L_FUNCTION_TITLE' => $lang['Function_name'],
			'L_FUNCTION_DESC' => $lang['Function_desc'],
			'L_FUNCTION_FILE' => $lang['Function_file'],
			'L_FUNCTION_ADMIN_FILE' => $lang['Function_admin_file'],

			//'E_MODULE_SELECT' => $modulelist,
			'E_FUNCTION_TITLE' => $function_title,
			'E_FUNCTION_DESC' => $function_desc,
			'E_FUNCTION_FILE' => $function_file,
			'E_FUNCTION_ADMIN_FILE' => $function_admin_file,

			//
			// Quick Panels
			//
			'MESSAGE_DELETE' => $message_delete,

			'S_HIDDEN_FIELDS' => $s_hidden_function_fields,

			'S_SUBMIT' => $new_function ? $lang['Create_function'] : $lang['Update']
		));

		if ($new_function)
		{
			continue;
		}
		else
		{
			$template->assign_block_vars('module.function.is_function', array());
		}

		// ----------------------------------------------------------------------------------Parameters
		// Now continue with the function parameters
		//
		$sql = "SELECT *
			FROM " . PARAMETER_TABLE . " par
			WHERE par.function_id = $function_id
			ORDER BY par.parameter_order";

		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't obtain the parameters from database", "", __LINE__, __FILE__, $sql);
		}
		$parameter_rows = $db->sql_fetchrowset($result);
		$total_parameters = count($parameter_rows);

		$db->sql_freeresult($result);

		if ( $total_parameters == 0 )
		{
			$template->assign_block_vars('module.function.noparameter', array(
				'NONE' => $lang['No_parameters']
			));
		}

		//
		// Parameter loop
		//
		for( $parameter_count = 0; $parameter_count < $total_parameters + 1; $parameter_count++ )
		{
			$new_parameter = $parameter_count == $total_parameters;
			$parameter_id = $new_parameter ? $function_id . '_0': $parameter_rows[$parameter_count]['parameter_id'];
			$id = $new_parameter ? $function_id : $parameter_id;

			$mode = MX_PARAMETER_TYPE;
			$action = $new_parameter ? MX_DO_INSERT : MX_DO_UPDATE;
			$deletemode = '?mode=' . $mode . '&amp;action=' . MX_DO_DELETE . '&amp;id=' . $parameter_id;

			$upmode = '?mode=' . $mode . '&amp;action=' . MX_DO_MOVE . '&amp;id=' . $parameter_id . '&amp;function_id=' . $function_id . '&amp;block_order=' . $block_order . '&amp;move=-15';
			$downmode = '?mode=' . $mode . '&amp;action=' . MX_DO_MOVE . '&amp;id=' . $parameter_id . '&amp;function_id=' . $function_id . '&amp;block_order=' . $block_order . '&amp;move=15';

			//
			// Hidden fields
			//
			$s_hidden_parameter_fields = 	'<input type="hidden" name="mode" value="' . $mode . '" />
										<input type="hidden" name="action" value="' . $action . '" />
										<input type="hidden" name="id" value="' . $id . '" />
										<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

			$parameter_title = !$new_parameter ? $parameter_rows[$parameter_count]['parameter_name'] : '';
			$parameter_type_key = $parameter_rows[$parameter_count]['parameter_type'];
			$parameter_type = !$new_parameter ? get_list_static('parameter_type', $type_row, $parameter_type_key) : get_list_static('parameter_type', $type_row, 'BBText');

			$parameter_function = $parameter_rows[$parameter_count]['parameter_function'];
			$parameter_function = !$new_parameter && !empty($parameter_function) ? ( $parameter_rows[$parameter_count]['parameter_type'] != 'Function' ? implode( "\n", unserialize( stripslashes( $parameter_function ) ) ) : $parameter_function ) : '';

			$parameter_auth = !$new_parameter ? $parameter_rows[$parameter_count]['parameter_auth'] : 0;
			$parameter_auth_yes = ( $parameter_auth == 1 ) ? 'checked="checked"' : '';
			$parameter_auth_no = ( $parameter_auth == 0 ) ? 'checked="checked"' : '';

			$parameter_default = !$new_parameter ? $parameter_rows[$parameter_count]['parameter_default'] : '';

			$message_delete = $lang['Delete_parameter'] . ' - ' . $parameter_title
						. '<br /><br />' . $lang['Delete_parameter_explain']
						. '<br /><br />' . sprintf($lang['Click_parameter_delete_yes'], '<a href="' . mx_append_sid("admin_mx_module_cp.$phpEx" . $deletemode) . '">', '</a>')
						. '<br /><br />';

			//$row_color = ( !( $i % 2 ) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !( $parameter_count % 2 ) ) ? 'row1' : 'row1';

			//
			// Parameter subpanel - edit
			//
			$visible = in_array('adminParEdit_' . $parameter_id, $cookie_states);
			$visible_delete = in_array('adminParDelete_' . $parameter_id, $cookie_states);
			$template->assign_block_vars('module.function.parameter', array(
				'L_TITLE' => $lang['Parameter_admin'],
				'L_EXPLAIN' => $lang['Parameter_admin_explain'],

				'VISIBLE' => $visible ? 'block' : 'none',
				'VISIBLE_DELETE' => $visible_delete ? 'block' : 'none',
				'IMG_URL' => $visible ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',
				'IMG_URL_DELETE' => $visible_delete ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',

				//"ROW_COLOR" => '#' . $row_color,
				"ROW_CLASS" => $parameter_type_key == 'Separator' ? 'row3' :  $row_class,

				'L_EDIT' => $new_parameter ? '' : $lang['Edit'],
				'L_DELETE' => $new_parameter ? '' : $lang['Delete'],

				"PARAMETER_ID" => $parameter_id,
				"PARAMETER_TITLE" => $new_parameter ? '<span class="cattitle">'. $lang['Create_parameter'] . '</span>' : ( ! empty ( $lang[$parameter_title] ) ? $lang[$parameter_title] : $parameter_title ),
				"PARAMETER_DESC" => $new_parameter ? '' : ' - ' . $parameter_desc,
				"PARAMETER_TYPE" => $new_parameter ? '' : (!empty($lang['ParType_'.$parameter_type_key]) ? $lang['ParType_'.$parameter_type_key] : $parameter_type_key),

				"U_DELETE" => mx_append_sid("admin_mx_module_cp.php" . $deletemode),
				"U_MOVE_UP" => mx_append_sid("admin_mx_module_cp.php" . $upmode),
				"U_MOVE_DOWN" => mx_append_sid("admin_mx_module_cp.php" . $downmode),

				//
				// Parameter subpanel - edit
				//
				'L_FUNCTION' => $lang['Function'],
				'L_PARAMETER_TITLE' => $lang['Parameter_name'],
				'L_PARAMETER_TYPE' => $lang['Parameter_type'],
				'L_PARAMETER_DEFAULT' => $lang['Parameter_default'],
				'L_PARAMETER_FUNCTION' => $lang['Parameter_function'],
				'L_PARAMETER_FUNCTION_EXPLAIN' => $lang['Parameter_function_explain'],
				'L_PARAMETER_AUTH' => $lang['Parameter_auth'],
				"L_PARAMETER_TEXT" => $lang['Parameter_admin_explain'],
				'L_PARAMETER_ID' => $lang['Parameter_id'],

				//'E_FUNCTION_SELECT' => $functionlist,
				'E_PARAMETER_TITLE' => $parameter_title,
				'E_PARAMETER_TYPE' => $parameter_type,
				'E_PARAMETER_FUNCTION' => $parameter_function,
				'E_PARAMETER_AUTH_YES' => $parameter_auth_yes,
				'E_PARAMETER_AUTH_NO' => $parameter_auth_no,
				'E_PARAMETER_DEFAULT' => $parameter_default,

				//
				// Quick Panels
				//
				'MESSAGE_DELETE' => $message_delete,

				'S_HIDDEN_FIELDS' => $s_hidden_parameter_fields,
				'S_SUBMIT' => $new_parameter ? $lang['Create_parameter'] : $lang['Update']
			));

			if (!$new_parameter)
			{
				$template->assign_block_vars('module.function.parameter.is_parameter', array());
			}
		}

		// ----------------------------------------------------------------------------------Blocks
		// Now continue with the function blocks
		//
		$sql = "SELECT blk.*, function_admin, fnc.function_name, fnc.function_id, fnc.function_desc, fnc.module_id
			FROM " . BLOCK_TABLE . " blk,
				" . FUNCTION_TABLE . " fnc
			WHERE blk.function_id = fnc.function_id
				AND fnc.function_id = '" . $function_rows[$function_count]['function_id'] . "'
			ORDER BY  fnc.function_name ASC";

		if( !($q_blocks = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Could not query blocks information", "", __LINE__, __FILE__, $sql);
		}

		$block_rows = array();
		if( $total_blocks = $db->sql_numrows($q_blocks) )
		{
			$block_rows = $db->sql_fetchrowset($q_blocks);
		}
		$db->sql_freeresult($result);

		if ( $total_blocks == 0 )
		{
			$template->assign_block_vars('module.function.noblock', array(
				'NONE' => $lang['No_blocks']
			));
		}

		//
		// Block loop
		//
		for( $block_count = 0; $block_count < $total_blocks + 1; $block_count++ )
		{
			$new_block = $block_count == $total_blocks;
			$block_id = $new_block ? $function_id . '_0' : $block_rows[$block_count]['block_id'];
			$id = $new_block ? $function_id : $block_id;

			$mode = MX_BLOCK_TYPE;
			$mode_private = MX_BLOCK_PRIVATE_TYPE;
			$action = $new_block ? MX_DO_INSERT : MX_DO_UPDATE;
			$deletemode = '?mode=' . $mode . '&amp;action=' . MX_DO_DELETE . '&amp;id=' . $block_id;

			//
			// Hidden fields
			//
			$s_hidden_block_fields = 	'<input type="hidden" name="mode" value="' . $mode . '" />
										<input type="hidden" name="action" value="' . $action . '" />
										<input type="hidden" name="id" value="' . $id . '" />
										<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

			//
			// Hidden fields
			//
			$s_hidden_block_private_fields = 	'<input type="hidden" name="mode" value="' . $mode_private . '" />
										<input type="hidden" name="action" value="' . MX_DO_UPDATE . '" />
										<input type="hidden" name="id" value="' . $id . '" />
										<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

			$block_title = !$new_block ? $block_rows[$block_count]['block_title'] : '';
			$block_desc = !$new_block ? $block_rows[$block_count]['block_desc']: '';

			$message_delete = $lang['Delete_block'] . ' - ' . $block_title
						. '<br /><br />' . $lang['Delete_block_explain']
						. '<br /><br />' . sprintf($lang['Click_block_delete_yes'], '<a href="' . mx_append_sid("admin_mx_module_cp.$phpEx" . $deletemode) . '">', '</a>')
						. '<br /><br />';

			$show_block = !$new_block ? $block_rows[$block_count]['show_block'] : '1';
			$show_title = !$new_block ? $block_rows[$block_count]['show_title'] : '1';
			$show_stats = !$new_block ? $block_rows[$block_count]['show_stats'] : '0';

			$show_title_yes = ( $show_title == 1 ) ? 'checked="checked"' : '';
			$show_title_no = ( $show_title == 0 ) ? 'checked="checked"' : '';

			$show_block_yes = ( $show_block == 1 ) ? 'checked="checked"' : '';
			$show_block_no = ( $show_block == 0 ) ? 'checked="checked"' : '';

			$show_stats_yes = ( $show_stats == 1 ) ? 'checked="checked"' : '';
			$show_stats_no = ( $show_stats == 0 ) ? 'checked="checked"' : '';

			$block_editor_id = !$new_block ? $block_rows[$block_count]['block_editor_id'] : $userdata['user_id'];
			$editor_name_tmp = mx_get_userdata($block_editor_id);
			$editor_name = $editor_name_tmp['username'];

			$block_time = !$new_block ? $block_rows[$block_count]['block_time'] : time();
			$edit_time = phpBB2::create_date( $board_config['default_dateformat'], $block_time, $board_config['board_timezone'] );

			if ($new_block)
			{
				$block_rows[$block_count][$block_auth_fields[0]] = AUTH_ALL;
				$block_rows[$block_count][$block_auth_fields[1]] = AUTH_ADMIN;
			}

			//
			// Block subpanel - edit
			//
			$visible_tag_edit = in_array('adminEdit_' . $block_id, $cookie_states);
			$visible_tag_private = in_array('adminPrivate_' . $block_id, $cookie_states);
			$visible_tag_delete = in_array('adminBlockDelete_' . $block_id, $cookie_states);
			$visible_tag_settings = in_array('adminSettings_' . $block_id, $cookie_states);

			$template->assign_block_vars('module.function.block', array(
				'L_TITLE' => $lang['Block_admin'],

				'VISIBLE_EDIT' => $visible_tag_edit ? 'block' : 'none',
				'VISIBLE_PRIVATE' => $visible_tag_private ? 'block' : 'none',
				'VISIBLE_DELETE' => $visible_tag_delete ? 'block' : 'none',
				'VISIBLE_SETTINGS' => $visible_tag_settings ? 'block' : 'none',
				'IMG_URL_EDIT' => $visible_tag_edit ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',
				'IMG_URL_PRIVATE' => $visible_tag_private ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',
				'IMG_URL_DELETE' => $visible_tag_delete ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',
				'IMG_URL_SETTINGS' => $visible_tag_settings ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',

				'L_SETTINGS' => $new_block ? '' : $lang['Block_cp'],
				'L_PERMISSIONS_ADV' => $new_block ? '' : $lang['Permissions_adv'],
				'L_DELETE' => $new_block ? '' : $lang['Delete'],
				'L_EDIT' => $new_block ? '' : $lang['Block_quick_edit'],
				'L_QUICK_STATS' => $new_block ? '' : $lang['Block_quick_stats'],

				'BLOCK_ID' => $block_id,
				'BLOCK_TITLE' => $new_block ? '<span class="cattitle">'. $lang['Create_block'] . '</span>' : $block_title,
				'BLOCK_DESC' => ( $block_desc != '' ) ? '<br />&nbsp;&nbsp;&nbsp;&nbsp;' . $block_desc : '',
				'BLOCK_LAST_EDITED' => ( $editor_name != '' && !$new_block) ? ' (' . $lang['Block_updated_by'] . $editor_name . ', ' . $edit_time . ')' : '',

				'U_BLOCK_SETTINGS' => mx_append_sid(PORTAL_URL . "admin/admin_mx_block_cp.$phpEx?block_id=$block_id"),
				'U_BLOCK_DELETE' => mx_append_sid(PORTAL_URL . "admin/admin_mx_module_cp.$phpEx" . $deletemode),
				'U_BLOCK_PERMISSIONS' => mx_append_sid(PORTAL_URL . "admin/admin_mx_block_auth.$phpEx?cat_id=$block_id"),

				//
				// Block subpanel - edit
				//
				'L_FUNCTION' => $lang['Function'],

				'L_AUTH_TITLE' => $lang['Auth_Block'],
				'L_AUTH_TITLE_EXPLAIN' => $lang['Auth_Block_explain'],
				'L_BLOCK_TITLE' => $lang['Block_title'],
				'L_BLOCK_DESC' => $lang['Block_desc'],
				'L_SHOW_BLOCK' 		=> $lang['Show_block'],
				'L_SHOW_BLOCK_EXPLAIN' => $lang['Show_block_explain'],
				'L_SHOW_TITLE' 		=> $lang['Show_title'],
				'L_SHOW_TITLE_EXPLAIN' => $lang['Show_title_explain'],
				'L_SHOW_STATS' 		=> $lang['Show_stats'],
				'L_SHOW_STATS_EXPLAIN' => $lang['Show_stats_explain'],

				'E_BLOCK_TITLE' => $block_title,
				'E_BLOCK_DESC' => $block_desc,

				'S_SHOW_BLOCK_YES' => $show_block_yes,
				'S_SHOW_BLOCK_NO' => $show_block_no,

				'S_SHOW_TITLE_YES' => $show_title_yes,
				'S_SHOW_TITLE_NO' => $show_title_no,

				'S_SHOW_STATS_YES' => $show_stats_yes,
				'S_SHOW_STATS_NO' => $show_stats_no,

				//
				// Quick Panels
				//
				'MESSAGE_DELETE' => $message_delete,

				'S_HIDDEN_FIELDS' => $s_hidden_block_fields,
				'S_HIDDEN_PRIVATE_FIELDS' => $s_hidden_block_private_fields,

				'S_SUBMIT' => $new_block ? $lang['Create_block'] : $lang['Update']
			));

			if ($mx_modulecp_include_block_quickedit)
			{
				//
				// Auth
				//
				for( $l = 0; $l < count($block_auth_fields); $l++ )
				{
					$custom_auth[$l] = '&nbsp;<select name="' . $block_auth_fields[$l] . '">';

					for( $k = 0; $k < count($block_auth_levels); $k++ )
					{
						$selected = ( $block_rows[$block_count][$block_auth_fields[$l]] == $block_auth_const[$k] ) ? ' selected="selected"' : '';
						$custom_auth[$l] .= '<option value="' . $block_auth_const[$k] . '"' . $selected . '>' . $lang['AUTH_' . $block_auth_levels[$k]] . "</option>\n";
					}
					$custom_auth[$l] .= '</select>&nbsp;';

					$cell_title = $field_names[$block_auth_fields[$l]];

					$template->assign_block_vars('module.function.block.block_auth_titles', array(
						'CELL_TITLE' => $cell_title
					));
					$template->assign_block_vars('module.function.block.block_auth_data', array(
						'S_AUTH_LEVELS_SELECT' => $custom_auth[$l]
					));

					$s_column_span++;
				}
			}

			if ($mx_modulecp_include_block_private)
			{
				//
				// PRIVATE auth
				//
				$view_groups = @explode(',', $block_rows[$block_count]['auth_view_group']);
				$edit_groups = @explode(',', $block_rows[$block_count]['auth_edit_group']);
				$moderator_groups = @explode(',', $block_rows[$block_count]['auth_moderator_group']);

				$row_private = '';
				for( $i = 0; $i < count($groupdata); $i++ )
				{
					$row_color = ( !( $i % 2 ) ) ? 'row1' : 'row2';
					$row_private .= '<tr>' . "\n";
					$row_private .= '<td width="40%" class="'.$row_color.'" align="center"><span class="gen">'.$groupdata[$i]['group_name'].'</span></td>';
					$row_private .= '<td width="20%" class="'.$row_color.'" align="center">';

					if ( $block_rows[$block_count]['auth_view'] == AUTH_ACL )
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

					if ( $block_rows[$block_count]['auth_edit'] == AUTH_ACL )
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
					$row_private .= '<input name="moderator[]" type="checkbox" '. (( in_array($groupdata[$i]['group_id'], $moderator_groups) ) ? 'checked="checked"' : '') . ' value="'.$groupdata[$i]['group_id'].'" />';
					$row_private .= '</td>';
					$row_private .= '</tr>'. "\n";
				}

				$template->assign_block_vars('module.function.block.grouprows', array(
					'GROUP_ROWS' => $row_private
				));
			}

			if (!$new_block)
			{
				$template->assign_block_vars('module.function.block.is_block', array());
			
				if ( $mx_modulecp_include_block_private )
				{
					$template->assign_block_vars('module.function.block.is_block.include_block_private', array());
				}
	
				if ( $mx_modulecp_include_block_quickedit )
				{
					$template->assign_block_vars('module.function.block.is_block.include_block_edit', array());
				}
			} // if ... !$new_block
		} // for ... blocks
	} // for ... functions
} // for .... modules

//
// Create quick nav box
//
$module_select_box = get_list_static('module_id', $module_rows_select, $nav_module_id, false);

$template->assign_vars(array( 'MODULE_SELECT_BOX' => $module_select_box ));

include_once('./page_header_admin.' . $phpEx);
$template->pparse('admin_block');
include_once('./page_footer_admin.' . $phpEx);
?>