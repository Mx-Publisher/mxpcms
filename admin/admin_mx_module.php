<?php
/**
*
* @package MX-Publisher Core
* @version $Id: admin_mx_module.php,v 1.51 2008/02/11 11:13:16 joasch Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !empty($setmodules) )
{
	$module['2_CP']['2_1_Modules'] = 'admin/' . basename(__FILE__);
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
// Pak file delimiter
//
$delimeter = '=+:';

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

$this_module_path = $mx_request_vars->request('this_module_path', MX_TYPE_NO_TAGS, '');

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
	$is_pak = false;
	if (is_array($result_message))
	{
		$nav_module_id = $result_message['new_module_id'];
		$is_pak = !empty($result_message['is_pak']);
		$result_message = $result_message['text'];
	}

	$result_message = $lang['AdminCP_status'] . '<hr>' . $result_message;

} // if .. !empty($mode)

//
// Load states
//
$cookie_tmp = $board_config['cookie_name'].'_admincp_blockstates';
$cookie_states = !empty($_COOKIE[$cookie_tmp]) ? explode(",", $_COOKIE[$cookie_tmp]) : array();

// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
//
// Start page proper
//
$template->set_filenames(array( 'body' => 'admin/mx_module_admin_body.tpl') );

//
// Define some graphics
//
$module_nav_icon_url = PORTAL_URL . $images['mx_graphics']['admin_icons'] . '/';
$admin_icon['contract'] = $module_nav_icon_url . 'contract.gif';
$admin_icon['expand'] = $module_nav_icon_url . 'expand.gif';
$admin_icon['module'] = $module_nav_icon_url . 'icon_module.gif';

//
// Install module
//
$modules_list = $mx_admin->get_new_module_pak_files();
$modules_select_list = get_list_static('module_path', $modules_list, '', false);

//
// Hidden fields
//
$s_hidden_module_install_fields = '<input type="hidden" name="mode" value="' . MX_MODULE_TYPE . '" />
							<input type="hidden" name="action" value="' . MX_DO_INSTALL . '" />
							<input type="hidden" name="id" value="' . $module_id . '" />
							<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

$result_message_height = $is_pak ? '300px' : '50px';

//
// Hidden vars
//
$s_hidden_fields_module = '<input type="hidden" name="mode" value="add" /><input type="hidden" name="id" value="' . $module_id . '" />';

//
// Send to template
//
$template->assign_vars(array(
	'L_TITLE' => $lang['Module_admin'],
	'L_EXPLAIN' => $lang['Module_admin_explain'],

	'NAV_MODULE_ID' => $nav_module_id,
	'RESULT_MESSAGE'			=> !empty($result_message) ? '<div style="overflow:auto; height:'.$result_message_height.'"><span class="gensmall">' . $result_message  . '<br/> -::-</span></div>': '',

	//
	// General
	//
	'L_ACTION' => $lang['Action'],
	'L_DELETE' => $lang['Delete'],
	'L_UNINSTALL' => $lang['Uninstall_module'],
	'L_EDIT' => $lang['Edit'],
	'L_SETTING' => $lang['Settings'],
	'L_ADD' => $lang['Create_module'],

	//
	// Module
	//
	'L_CODE' => $lang['Code'],
	'L_MODULE_NAME' => $lang['Module_name'],
	'L_MODULE_DESC' => $lang['Module_desc'],
	'L_MODULE_PATH' => $lang['Module_path'],
	'L_MODULE_INCLUDE_ADMIN' => $lang['Module_include_admin'],
	'L_IMPORT_PACK' => $lang['import_module_pack'],
	'L_UPGRADE_PACK' => $lang['upgrade_module_pack'],
	'L_EXPORT_PACK' => $lang['export_module_pack'],
	'L_QUICK_NAV' => $lang['Quick_nav'],

	'IMG_URL_CONTRACT' => $admin_icon['contract'],
	'IMG_URL_EXPAND' => $admin_icon['expand'],
	'IMG_ICON_MODULE' => $admin_icon['module'],

	'S_HIDDEN_FIELDS_MODULE' => $s_hidden_fields_module,
	'S_SUBMIT' => $lang['Update'],

	//
	// Module Install
	//
	'S_MODULE_INSTALL_LIST' => $modules_select_list,
	'S_HIDDEN_MODULE_INSTALL_FIELDS' => $s_hidden_module_install_fields,

	//
	// Cookies
	//
	'COOKIE_NAME'	=> $board_config['cookie_name'],
	'COOKIE_PATH'	=> $board_config['cookie_path'],
	'COOKIE_DOMAIN'	=> $board_config['cookie_domain'],
	'COOKIE_SECURE'	=> $board_config['cookie_secure'],

	'S_ACTION' => mx_append_sid("admin_mx_module.$phpEx")
));

//
// ---------------------------------------------------------------------------------- Modules
//

// Display list of Modules ---------------------------------------------------------------
// ---------------------------------------------------------------------------------------
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
// Loop through the rows of modules setting block vars for the template.
//
for( $module_count = -1; $module_count < $total_modules; $module_count++ )
{
	//
	// Give main vars specific names
	//
	$new_module = $module_count == -1;

	$newmode = $new_module ? 'add' : 'modify';
	$module_id = $new_module ? '0'  : $module_rows[$module_count]['module_id'];

	$mode = MX_MODULE_TYPE;
	$action = $new_module ? MX_DO_INSERT : MX_DO_UPDATE;

	$deletemode = '?mode=' . $mode . '&amp;action=' . MX_DO_DELETE . '&amp;id=' . $module_id . '&amp;module_path=' . $module_rows[$module_count]['module_path'];
	$upgrademode = '?mode=' . $mode . '&amp;action=' . MX_DO_UPGRADE . '&amp;id=' . $module_id . '&amp;module_path=' . $module_rows[$module_count]['module_path'];
	$exportmode = '?mode=' . $mode . '&amp;action=' . MX_DO_EXPORT . '&amp;id=' . $module_id;

	$settingmode = '?module_id=' . $module_id;

	//
	// Hidden fields
	//
	$s_hidden_module_fields = '<input type="hidden" name="mode" value="' . $mode . '" />
								<input type="hidden" name="action" value="' . $action . '" />
								<input type="hidden" name="id" value="' . $module_id . '" />
								<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

	$is_current_module = $module_id == $nav_module_id;

	if ($module_count > -1)
	{
		$module_rows_select[$module_id] = $module_rows[$module_count]['module_name'];
	}

	$check_opt = '';

	if( $module_rows[$module_count]['module_include_admin'] == 1 )
	{
		$check_opt = 'checked="checked"';
	}

	$message_uninstall = $lang['Module_delete']
				. '<br /><br />' . sprintf($lang['Click_module_delete_yes'], '<a href="' . mx_append_sid("admin_mx_module.$phpEx" . $deletemode) . '">', '</a>')
				. '<br /><br />';

	$message_upgrade = $lang['upgrade_module_pack_explain']
				. '<br /><br />' . sprintf($lang['Click_module_upgrade_yes'], '<a href="' . mx_append_sid("admin_mx_module.$phpEx" . $upgrademode) . '">', '</a>')
				. '<br /><br />';

	$message_export = $lang['export_module_pack_explain']
				. '<br /><br />' . sprintf($lang['Click_module_export_yes'], '<a href="' . mx_append_sid("admin_mx_module.$phpEx" . $exportmode) . '">', '</a>')
				. '<br /><br />';

	//
	// Module subpanel - edit
	//
	$visible = in_array('adminModule_' . $module_id, $cookie_states);
	$visible_upgrade = in_array('adminModuleUpgrade_' . $module_id, $cookie_states);
	$visible_export = in_array('adminModuleExport_' . $module_id, $cookie_states);
	$visible_uninstall = in_array('adminModuleDelete_' . $module_id, $cookie_states);

	$template->assign_block_vars('module', array(
		'L_TITLE' => $new_module ? $lang['Create_module'] : $lang['Edit_module'],
		'L_MODULE' => $lang['Module'],
		'VISIBLE' => $visible ? 'block' : 'none',
		'VISIBLE_UPGRADE' => $visible_upgrade ? 'block' : 'none',
		'VISIBLE_EXPORT' => $visible_export ? 'block' : 'none',
		'VISIBLE_DELETE' => $visible_uninstall ? 'block' : 'none',

		'IMG_URL' => $visible ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',
		'IMG_URL_UPGRADE' => $visible_upgrade ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',
		'IMG_URL_EXPORT' => $visible_export ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',
		'IMG_URL_DELETE' => $visible_uninstall ? $module_nav_icon_url . 'contract.gif' : $module_nav_icon_url . 'expand.gif',

		'U_MODULE' => mx_append_sid("admin_mx_module_cp.$phpEx" . $settingmode),

		'MODULE_ID' => $module_id,
		'MODULE_TITLE' => $new_module ? $lang['Create_module'] : $module_rows[$module_count]['module_name'],
		'MODULE_DESCRIPTION' => ( $module_rows[$module_count]['module_desc'] != '' ) ? ' - ' . $module_rows[$module_count]['module_desc'] : '',
		'MODULE_VERSION' => ( $module_rows[$module_count]['module_version'] != '' ) ? '- ' . $module_rows[$module_count]['module_version'] : '',

		//
		// Module subpanel - edit
		//
		'E_MODULE_NAME' => $module_rows[$module_count]['module_name'],
		'E_MODULE_DESC' => $module_rows[$module_count]['module_desc'],
		'E_MODULE_PATH' => $module_rows[$module_count]['module_path'],
		'E_MODULE_INCLUDE_CHECK_OPT' => $check_opt,

		//
		// Quick Panels
		//
		'MESSAGE_UPGRADE' => $message_upgrade,
		'MESSAGE_EXPORT' => $message_export,
		'MESSAGE_DELETE' => $message_uninstall,

		'S_SUBMIT' => $new_module ? $lang['Create_module'] : $lang['Update'],

		'S_HIDDEN_FIELDS' => $s_hidden_module_fields
	));

	if (!$new_module)
	{
		$template->assign_block_vars('module.settings', array());
	}
}

//
// Create quick nav box
//
$module_select_box = get_list_static('module_id', $module_rows_select, $nav_module_id, false);

$template->assign_vars(array( 'MODULE_SELECT_BOX' => $module_select_box ));

//
// Generate Module and Function Page
//
include_once('./page_header_admin.' . $phpEx);
$template->pparse('body');
include('./page_footer_admin.' . $phpEx);
?>