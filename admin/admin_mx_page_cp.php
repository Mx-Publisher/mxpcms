<?php
/**
*
* @package MX-Publisher Core
* @version $Id: admin_mx_page_cp.php,v 1.41 2014/05/09 07:51:42 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['2_CP']['2_4_PageCP'] = 'admin/' . $file;
	return;
}

//
// Security and Page header
//
@define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = TRUE;
require('./pagestart.' . $phpEx);

//
// Instatiate the mx_admin class
//
$mx_admin = new mx_admin();

//
// Instatiate the $mx_dynamic_select class (dynamic block select javascript)
//
$mx_dynamic_select = new mx_dynamic_select();
$mx_dynamic_select->generate();

//
// Mode & Action setting
//
$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS, '');
$action = $mx_request_vars->request('action', MX_TYPE_NO_TAGS, '');

//
// Main page id, to load the adminCP
//
$nav_page_id = $mx_request_vars->request('page_id', MX_TYPE_INT, '');

if ( empty($nav_page_id) )
{
	$cookie_tmp = $board_config['cookie_name'].'_adminPage_page_id';
	$nav_page_id = !empty($_COOKIE[$cookie_tmp]) ? $_COOKIE[$cookie_tmp] : 1;
}

$page_list = ''; //mx_get_list("page_id", PAGE_TABLE, 'page_id', 'page_name', $nav_page_id, true);
$new_column = false;
$sort_method = '';
$sort_order = '';
$include_all = '';
$result = true;
 
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
		$nav_page_id = $result_message['new_page_id'];
		$result_message = $result_message['text'];
	}

	$result_message = $lang['AdminCP_status'] . '<hr>' . $result_message;

} // if .. !empty($mode)

@setcookie($board_config['cookie_name'] . '_adminPage_page_id', $nav_page_id, time() + 10000000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);

//
// Load states
//
$cookie_tmp = $board_config['cookie_name'].'_admincp_pagestates';
$cookie_states = !empty($_COOKIE[$cookie_tmp]) ? explode(",", $_COOKIE[$cookie_tmp]) : array();

// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------

//
// Start page proper
//
$auth_fields = array('auth_view');
$auth_ary = array('auth_view' => AUTH_ALL);

$auth_levels = array('ALL', 'REG', 'PRIVATE', 'MOD', 'ADMIN', 'ANONYMOUS');
$auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN, AUTH_ANONYMOUS);

$field_names = array('auth_view' => $lang['View']);

$template->set_filenames(array( 'body' => 'admin/mx_pagecp_admin_body.tpl') );

//
// Define some graphics
//
$page_nav_icon_url = PORTAL_URL . $images['mx_graphics']['admin_icons'] . '/';

$admin_icon['contract'] = $page_nav_icon_url . 'contract.gif';
$admin_icon['expand'] = $page_nav_icon_url . 'expand.gif';
$admin_icon['page'] = $page_nav_icon_url . 'icon_page.gif';
$admin_icon['page_column'] = $page_nav_icon_url . 'icon_page_column.gif';
$admin_icon['function'] = $page_nav_icon_url . 'icon_function.gif';
$admin_icon['parameter'] = $page_nav_icon_url . 'icon_parameter.gif';
$admin_icon['block'] = $page_nav_icon_url . 'icon_block.gif';
$admin_icon['edit_block'] = $page_nav_icon_url . 'icon_edit.gif';

//
// Send General Vars to template
//
$visible_template_main = in_array('adminPage_Template', $cookie_states);

$template->assign_vars(array(
	'VISIBLE' 					=> $visible_template_main ? 'block' : 'none',
	'IMG_URL' 					=> $visible_template_main ? $admin_icon['contract'] : $admin_icon['expand'],

	'L_TITLE_PAGES'				=> $lang['Page_admin'],
	'L_TITLE_NEW_PAGE'			=> $lang['Page_admin_new_page'],
	'L_TITLE_TEMPLATES'			=> $lang['Page_templates_admin'],
	'L_EXPLAIN'					=> $lang['Page_admin_explain'],

	'L_TITLE_TEMPLATE' 			=> $lang['Page_templates_admin'],
	'L_EXPLAIN_TEMPLATE' 		=> $lang['Page_templates_admin_explain'],

	'NAV_PAGE_ID' 				=> $nav_page_id,
	'PAGELIST' 					=> mx_get_list("page_id", PAGE_TABLE, 'page_id', 'page_name', $nav_page_id, true),
	'L_CHANGE_NOW' 				=> $lang['Change'],
	'S_SUBMIT' 					=> $lang['Update'],
	'RESULT_MESSAGE'			=> isset($result_message) ? '<div style="overflow:auto; height:50px;"><span class="gensmall">' . $result_message  . '<br/> -::-</span></div>': '',

	//
	// General
	//
	'S_ACTION'					=> mx_append_sid(PORTAL_URL . "admin/admin_mx_page_cp.$phpEx"),
	'BLOCK_SIZE'				=> (isset($block_size) ? $block_size : '100%'),
	'L_TITLE'					=> $lang['Page_admin'],
	'L_COLUMN'					=> $lang['Column'],
	'L_VIEW'					=> $lang['View'],
	'L_EDIT'					=> $lang['Edit'],
	'L_PREVIEW'					=> $lang['Preview'],
	'L_SETTING'					=> $lang['Settings'],
	'L_PERMISSIONS'				=> $lang['Permissions'],
	'L_DELETE'					=> $lang['Delete'],
	'L_CREATE_PAGE'				=> $lang['Add_Page'],
	'L_DEFAULT' 				=> $lang['Use_default'],

	'L_QUICK_NAV' 				=> $lang['Quick_nav'],
	'L_INCLUDE_ALL' 			=> $lang['Include_all_pages'],

	'L_CREATE_PAGE' 			=> $lang['Add_Page'],
	'L_CREATE_BLOCK' 			=> $lang['Add_Block'],
	'L_PAGE' 					=> $lang['Page'],
	'L_CREATE_COLUMN' 			=> $lang['Create_column'],
	'L_CHANGE_NOW' 				=> $lang['Change'],
	'L_RESYNC' 					=> $lang['Resync'],
	'L_RESET' 					=> $lang['Reset'],
	'L_MOVE_UP' 				=> $new_column ? 'up' : $lang['Move_up'],
	'L_MOVE_DOWN' 				=> $new_column ? 'down' : $lang['Move_down'],

	//
	// Page Edit
	//
	'L_PAGE_TITLE'				=> $lang['Page'],
	'L_PAGE_DESC'				=> $lang['Page_desc'],
	'L_PAGE_PARENT'				=> $lang['Page_parent'],
	'L_PAGE_ID'					=> t('Page_Id'),
	'L_PAGE_ICON'				=> t('Page_icon'),
	'L_PAGE_ALT_ICON'			=> t('Page_alt_icon'),
	"L_DEFAULT_STYLE" 			=> t('Default_page_style'),
	"L_OVERRIDE_STYLE" 			=> t('Override_page_style'),
	"L_OVERRIDE_STYLE_EXPLAIN" 	=> t('Override_page_style_explain'),
	'L_PAGE_HEADER'				=> !isset($lang['Page_header']) ? "Page header file" : $lang['Page_header'],
	'L_PAGE_FOOTER'				=> !isset($lang['Page_footer']) ? "Page footer file" : $lang['Page_footer'],
	'L_PAGE_MAIN_LAYOUT'		=> !isset($lang['Page_main_layout']) ? "Page main_layout file" : $lang['Page_main_layout'],
	"L_NAVIGATION_BLOCK" 		=> $lang['Page_Navigation_block'],
	"L_NAVIGATION_BLOCK_EXPLAIN" => $lang['Page_Navigation_block_explain'],

	'L_AUTH_TITLE'				=> !isset($lang['Auth_Page']) ? "Permission" : $lang['Auth_Page'],
	'L_PRIVATE_AUTH_TITLE' 		=> $lang['Mx_Page_Auth_Title'],
	'L_PRIVATE_AUTH_EXPLAIN' 	=> $lang['Mx_Page_Auth_Explain'],
	'L_GROUPS' 					=> $lang['Usergroups'],
	'L_IS_MODERATOR' 			=> $lang['Is_Moderator'],
	"L_IP_FILTER" => $lang['Mx_IP_filter'],
	"L_IP_FILTER_EXPLAIN" => $lang['Mx_IP_filter_explain'],
	"L_PHPBB_STATS" => $lang['Mx_phpBB_stats'],
	"L_PHPBB_STATS_EXPLAIN" => $lang['Mx_phpBB_stats_explain'],
	
	// Graphics
	'IMG_URL_CONTRACT' => $admin_icon['contract'],
	'IMG_URL_EXPAND' => $admin_icon['expand'],

	'IMG_ICON_PAGE' => $admin_icon['page'],
	'IMG_ICON_PAGE_COLUMN' => $admin_icon['page_column'],
	'IMG_ICON_FUNCTION' => $admin_icon['function'],
	'IMG_ICON_PARAMETER' => $admin_icon['parameter'],
	'IMG_ICON_BLOCK' => $admin_icon['block'],
	'IMG_ICON_EDIT_BLOCK' => $admin_icon['edit_block'],
	
	// Cookies
	'COOKIE_NAME'	=> $board_config['cookie_name'],
	'COOKIE_PATH'	=> $board_config['cookie_path'],
	'COOKIE_DOMAIN'	=> $board_config['cookie_domain'],
	'COOKIE_SECURE'	=> $board_config['cookie_secure'],
	
	// Sorting
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'L_ORDER' => $lang['Order'],
	'L_SORT' => $lang['Sort'],

	'L_SORT_TITLE' => $lang['Page_sort_title'],
	'L_SORT_DESC' => $lang['Page_sort_desc'],
	'L_SORT_ID' => $lang['Page_sort_created'],

	'L_ASC' => $lang['Sort_Ascending'],
	'L_DESC' => $lang['Sort_Descending'],

	'S_PAGE_TITLE' => ( $sort_method == 'page_name' ) ? 'selected="selected"' : '',
	'S_PAGE_DESC' => ( $sort_method == 'page_desc' ) ? 'selected="selected"' : '',
	'S_PAGE_ID' => ( $sort_method == 'page_id' ) ? 'selected="selected"' : '',

	'SORT_ASC' => ( $sort_order == 'ASC' ) ? 'selected="selected"' : '',
	'SORT_DESC' => ( $sort_order == 'DESC' ) ? 'selected="selected"' : '',

	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],

	'S_INCLUDE_ALL_YES' => ( $include_all == '1' ) ? 'checked="checked"' : '',
	'S_INCLUDE_ALL_NO' => ( $include_all == '0' ) ? 'checked="checked"' : '',

));

// Start Page Template
$sql = "SELECT * FROM " . PAGE_TEMPLATES . " WHERE page_template_id <> 1 ORDER BY page_template_id";

if( !($q_templates = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, "Couldn't get list of Page Templates", "", __LINE__, __FILE__, $sql);
}

$template_rows = array();
if($total_templates = $db->sql_numrows($q_templates))
{
	$template_rows = $db->sql_fetchrowset($q_templates);
}

$db->sql_freeresult($result);

if ($total_templates == 0)
{
	$template->assign_block_vars('notemplate', array(
		'NONE' => $lang['No_templates']
	));
}

// Templates loop
for( $template_count = 0; $template_count < $total_templates + 1; $template_count++ )
{
	$new_template = $template_count == $total_templates;

	$page_template_id = $new_template ? '0' : $template_rows[$template_count]['page_template_id'];

	$mode = MX_PAGE_TEMPLATE_TYPE;
	$action = $new_template ? MX_DO_INSERT : MX_DO_UPDATE;
	$deletemode = '?mode=' . $mode . '&amp;action=' . MX_DO_DELETE . '&amp;id=' . $page_template_id;
	
	// Hidden fields
	$s_hidden_template_fields = 	'<input type="hidden" name="mode" value="' . $mode . '" />
								<input type="hidden" name="action" value="' . $action . '" />
								<input type="hidden" name="id" value="' . $page_template_id . '" />
								<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

	$template_title = !$new_template ? $template_rows[$template_count]['template_name'] : '';

	$message_delete = $lang['Delete_page_template']
			. '<br /><br />' . $lang['Delete_page_template_explain']
			. '<br /><br />' . sprintf($lang['Click_page_template_delete_yes'], '<a href="' . mx_append_sid("admin_mx_page_cp.$phpEx" . $deletemode) . '">', '</a>')
			. '<br /><br />';
			
	// Templates subpanel - edit
	$visible_template = in_array('adminTemplateEdit_' . $page_template_id, $cookie_states);
	$visible_template_delete = in_array('adminTemplateDelete_' . $page_template_id, $cookie_states);
	
	$template->assign_block_vars('templates', array(
		'L_TITLE' 					=> $lang['Page_templates_admin'],
		'L_EXPLAIN' 				=> $lang['Page_templates_admin_explain'],

		'VISIBLE' 					=> $visible_template ? 'block' : 'none',
		'VISIBLE_DELETE' 			=> $visible_template_delete ? 'block' : 'none',

		'IMG_URL' 					=> $visible_template ? $admin_icon['contract'] : $admin_icon['expand'],
		'IMG_URL_DELETE' 			=> $visible_template_delete ? $admin_icon['contract'] : $admin_icon['expand'],

		'TEMPLATE_ID'				=> $page_template_id,
		'TEMPLATE_TITLE'			=> $new_template ? $lang['Add_Template'] : $template_title,

		'U_DELETE'					=> mx_append_sid("admin_mx_page_cp.$phpEx" . $deletemode),

		'L_TEMPLATE_DELETE' 		=> $lang['Page_template_delete'],
		'U_TEMPLATE_DELETE' 		=> mx_append_sid("admin_mx_page_cp_template_setting.$phpEx?mode=deletetemplate&amp;page_template_id=$page_template_id"),
		
		'L_CREATE_TEMPLATE' 		=> $lang['Add_Template'],
		'L_TEMPLATE' 				=> $lang['Template'],
		'L_TEMPLATE_NAME' 			=> $lang['Template_name'],
		
		// Page subpanel - edit
		'E_TEMPLATE_TITLE'			=> $template_title,
		
		// Main
		'U_PHPBB_ROOT_PATH' 		=> PHPBB_URL,
		'TEMPLATE_ROOT_PATH' 		=> TEMPLATE_ROOT_PATH,
		
		// Quick Panels
		'MESSAGE_DELETE' 			=> $message_delete,
		'S_HIDDEN_FIELDS'			=> $s_hidden_template_fields,
		'S_SUBMIT' 					=> $new_template ? $lang['Add_Template'] : $lang['Update']
	));

	if (!$new_template)
	{
		$template->assign_block_vars('templates.edit', array());
		$template->assign_block_vars('templates.delete', array());
	}

	if ( $new_template )
	{
		$template->assign_block_vars('templates.new_template', array());
	}
	else
	{
		$template->assign_block_vars('templates.current_template', array());
	}
	
	if ( $new_template )
	{
		continue;
	}
	
	$sql = "SELECT *
		FROM " . COLUMN_TEMPLATES . "
		WHERE page_template_id = $page_template_id
		ORDER BY page_template_id, column_order";
		
	if( !($q_column = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Could not query column list", "", __LINE__, __FILE__, $sql);
	}
	
	$q_columns = false;
	$column_rows = array();
	if( $total_column = $db->sql_numrows($q_columns) )
	{
		$column_rows = $db->sql_fetchrowset($q_columns);
	}
	
	$db->sql_freeresult($result);
	
	// Okay, let's build the index
	for( $column = 0; $column < $total_column + 1; $column++ )
	{
		$new_column = $column == $total_column;
		
		$column_template_id = $new_column ? $page_template_id . '_0'  : $column_rows[$column]['column_template_id'];
		
		$mode = MX_PAGE_TEMPLATE_COLUMN_TYPE;
		$action = $new_column ? MX_DO_INSERT : MX_DO_UPDATE;
		$deletemode = '?mode=' . $mode . '&amp;action=' . MX_DO_DELETE . '&amp;id=' . $column_template_id;
		$upmode = '?mode=' . $mode . '&amp;action=' . MX_DO_MOVE . '&amp;id=' . $column_template_id . '&amp;page_template_id=' . $page_template_id . '&amp;move=-15';
		$downmode = '?mode=' . $mode . '&amp;action=' . MX_DO_MOVE . '&amp;id=' . $column_template_id . '&amp;page_template_id=' . $page_template_id . '&amp;move=15';
		
		// Hidden fields
		$s_hidden_column_fields = 	'<input type="hidden" name="mode" value="' . $mode . '" />
									<input type="hidden" name="action" value="' . $action . '" />
									<input type="hidden" name="page_template_id" value="' . $page_template_id . '" />
									<input type="hidden" name="id" value="' . $column_template_id . '" />
									<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
									
		// Subpanel - column edit
		$column_title = $new_column ? '' : $column_rows[$column]['column_title'];
		$column_size = $new_column ? '100%' : $column_rows[$column]['column_size'];

		$message_delete = $lang['Delete_page_template_column'] . ' - ' . $column_title
				. '<br /><br />' . $lang['Delete_page_template_column_explain']
				. '<br /><br />' . sprintf($lang['Click_page_template_column_delete_yes'], '<a href="' . mx_append_sid("admin_mx_page_cp.$phpEx" . $deletemode) . '">', '</a>')
				. '<br /><br />';
				
		$visible_column_edit = in_array('adminTemplateColumnEdit_' . $page_template_id . '_' . $column_template_id, $cookie_states);
		$visible_column_delete = in_array('adminTemplateColumnDelete_' . $page_template_id . '_' . $column_template_id, $cookie_states);
		$template->assign_block_vars('templates.columnrow', array(
			'VISIBLE' 				=> $visible_column_edit ? 'block' : 'none',
			'VISIBLE_DELETE' 		=> $visible_column_delete ? 'block' : 'none',
			'IMG_URL' 				=> $visible_column_edit ? $admin_icon['contract'] : $admin_icon['expand'],
			'IMG_URL_DELETE' 		=> $visible_column_delete ? $admin_icon['contract'] : $admin_icon['expand'],
			
			'COLUMN_ID' 			=> $column_template_id,
			'COLUMN_TITLE' 			=> $new_column ? $lang['Create_column'] : $column_title,
			
			'U_COLUMN_DELETE' 		=> mx_append_sid("admin_mx_page_cp.$phpEx" . $deletemode),
			'U_COLUMN_MOVE_UP' 		=> mx_append_sid("admin_mx_page_cp.$phpEx" . $upmode),
			'U_COLUMN_MOVE_DOWN' 	=> mx_append_sid("admin_mx_page_cp.$phpEx" . $downmode),
			
			// Column Edit
			'L_DELETE'				=> $new_column ? '' : $lang['Delete'],
			'L_MOVE_UP' 			=> $new_column ? '' : $lang['Move_up'],
			'L_MOVE_DOWN' 			=> $new_column ? '' : $lang['Move_down'],
			
			'L_COLUMN' 				=> $lang['Column'],
			'L_COLUMN_NAME' 		=> $lang['Column_name'],
			'L_COLUMN_SIZE' 		=> $lang['Column_Size'],
			
			'VISIBLE' 				=> $visible_column_edit ? 'block' : 'none',
			'IMG_URL_EDIT' 			=> $visible_column_edit ? $admin_icon['contract'] : $admin_icon['expand'],
			
			'E_COLUMN_TITLE' 		=> $column_title,
			'E_COLUMN_SIZE' 		=> $column_size,
			
			'S_SUBMIT' 				=> $new_column ? $lang['Create_column'] : $lang['Update'],
			
			// Quick Panels
			'MESSAGE_DELETE' 		=> $message_delete,
			
			'S_HIDDEN_FIELDS' 		=> $s_hidden_column_fields
		));
	} // for ... column
}

/*
* Start Page Admin
*/

// Get the list of phpBB usergroups
$sql = $mx_backend->generate_group_select_sql();

if( !($result = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, 'Could not get group list', '', __LINE__, __FILE__, $sql);
}
$groupdata = array();
while($row = $db->sql_fetchrow($result))
{
	$groupdata[] = $row;
}
$db->sql_freeresult($result);

//
// ---------------------------------------------------------------------------------- Pages
//

// Display list of Pages ---------------------------------------------------------------
// ---------------------------------------------------------------------------------------
$mx_page->init($nav_page_id, true);

$page_list .= '<option value="0" selected>' . 'Home' . '</option>\n';

if ( !$mx_page->page_rowset[$nav_page_id]['page_parent'] )
{
	$page_list .= '<option value="0" selected>' . $lang['None'] . '</option>\n';
}
else
{
	$page_list .= '<option value="0">' . $lang['None'] . '</option>\n';
}
$page_list .= $mx_page->generate_jumpbox( 0, 0, array( $mx_page->page_rowset[$nav_page_id]['page_parent'] => 1 ) );

$select_page = $mx_page->generate_jumpbox( 0, 0, array( $nav_page_id => 1 ) );

//
// Get current/active module
//
$sql = "SELECT *
	FROM " . PAGE_TABLE . "
	WHERE page_id = '" . $nav_page_id . "'";

if( !($q_pages_current = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, "Could not query pages information", "", __LINE__, __FILE__, $sql);
}

$page_rows_current = array();
if( $total_pages_current = $db->sql_numrows($q_pages_current) )
{
	$page_rows_current = $db->sql_fetchrowset($q_pages_current);
}

$db->sql_freeresult($result);

//
// Get the rest modules
//
$sql = "SELECT *
	FROM " . PAGE_TABLE . "
	WHERE page_id <> '" . $nav_page_id . "'";

if( !($q_pages = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, "Could not query pages information", "", __LINE__, __FILE__, $sql);
}

$page_rows = array();
if( $total_pages = $db->sql_numrows($q_pages) )
{
	$page_rows = $db->sql_fetchrowset($q_pages);
}

$db->sql_freeresult($result);

if ( ($total_pages_current + $total_pages) == 0 )
{
	$template->assign_block_vars('nopage', array(
		'NONE' => $lang['No_pages']
	));
}

$page_rows = array_merge($page_rows_current, $page_rows);
$total_pages = $total_pages + $total_pages_current;

/*
* Pages loop
*/
for($page_count = -1; $page_count < $total_pages; $page_count++)
{
	$new_page = $page_count == -1;

	$page_id = $new_page ? 'new_page' : $page_rows[$page_count]['page_id'];
	$is_current_page = $page_id == $nav_page_id;

	if (!$include_all && $page_count > 0)
	{
		continue;
	}

	$mode = MX_PAGE_TYPE;
	$action = $new_page ? MX_DO_INSERT : MX_DO_UPDATE;
	$deletemode = '?mode=' . $mode . '&amp;action=' . MX_DO_DELETE . '&amp;id=' . $page_id;
	
	// Hidden fields
	$s_hidden_page_fields = 	'<input type="hidden" name="mode" value="' . $mode . '" />
								<input type="hidden" name="action" value="' . $action . '" />
								<input type="hidden" name="id" value="' . $page_id . '" />
								<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
								
	$s_hidden_private_fields = 	'<input type="hidden" name="mode" value="' . MX_PAGE_PRIVATE_TYPE . '" />
								<input type="hidden" name="action" value="' . MX_DO_UPDATE . '" />
								<input type="hidden" name="id" value="' . $page_id . '" />
								<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
								
	$page_title = !$new_page ? $page_rows[$page_count]['page_name'] : '';
	$page_desc = !$new_page ? $page_rows[$page_count]['page_desc'] : '';
	$page_parent = !$new_page ? $page_rows[$page_count]['page_parent'] : '';
	$page_icon = !$new_page ? $page_rows[$page_count]['page_icon'] : 'default.gif';
	$page_alt_icon = !$new_page ? $page_rows[$page_count]['page_alt_icon'] : '';
	$page_header = !$new_page ? $page_rows[$page_count]['page_header'] : 'overall_header_navigation.html';
	$page_footer = !$new_page ? $page_rows[$page_count]['page_footer'] : 'overall_footer.html';
	$page_main_layout = !$new_page ? $page_rows[$page_count]['page_main_layout'] : 'mx_main_layout.html';
	//$navigation_block_list = get_list_formatted('block_list', $page_main_layout, 'navigation_block', 'mx_menu_nav.' . $phpEx);
	$navigation_block_list = get_list_formatted('block_list', $portal_config['navigation_block'], 'navigation_block', 'mx_menu_nav.' . $phpEx, false, 'mx_site_nav.' . $phpEx);	
	$default_style = !$new_page ? $page_rows[$page_count]['default_style'] : '_core';
	$style_select = mx_style_select($default_style, 'mx_default_style', 'templates', true);

	$override_user_style_yes = !$new_page ? ( $page_rows[$page_count]['override_user_style'] == 1 ? "checked=\"checked\"" : "" ) : "";
	$override_user_style_no = !$new_page ? ( $page_rows[$page_count]['override_user_style'] == 0 ? "checked=\"checked\"" : "" ) : "";
	$override_user_style_default = !$new_page ? ( $page_rows[$page_count]['override_user_style'] == -1 ? "checked=\"checked\"" : "" ) : "checked=\"checked\"";

	$icon_tmp = ( !empty($page_icon) && $page_icon != 'none' && file_exists($mx_root_path . TEMPLATE_ROOT_PATH . "images/page_icons/" . $page_icon)) ? '<img align="absmiddle" src="' . PORTAL_URL . TEMPLATE_ROOT_PATH . "images/page_icons/" . $page_icon . '" />' : '';

	$ip_filter = !empty($page_rows[$page_count]['ip_filter']) ? implode( "\n", unserialize( stripslashes( $page_rows[$page_count]['ip_filter'] ))) : '' ;

	$phpbb_stats_yes = !$new_page ? ( $page_rows[$page_count]['phpbb_stats'] == 1 ? "checked=\"checked\"" : "" ) : "";
	$phpbb_stats_no = !$new_page ? ( $page_rows[$page_count]['phpbb_stats'] == 0 ? "checked=\"checked\"" : "" ) : "";
	$phpbb_stats_default = !$new_page ? ( $page_rows[$page_count]['phpbb_stats'] == -1 ? "checked=\"checked\"" : "" ) : "checked=\"checked\"";

	// Page subpanel - edit
	$visible_page = in_array('adminPage_' . $page_id, $cookie_states);
	$visible_page_delete = in_array('adminPageDelete_' . $page_id, $cookie_states);
	$visible_page_edit = in_array('adminPageEdit_' . $page_id, $cookie_states);
	$visible_page_settings = in_array('adminPageSettings_' . $page_id, $cookie_states);
	$visible_page_private = in_array('adminPagePrivate_' . $page_id, $cookie_states);

	$message_delete = $lang['Delete_page']
			. '<br /><br />' . $lang['Delete_page_explain']
			. '<br /><br />' . sprintf($lang['Click_page_delete_yes'], '<a href="' . mx_append_sid("admin_mx_page_cp.$phpEx" . $deletemode) . '">', '</a>')
			. '<br /><br />';
			
	// Make the settings panel default when switching pages
	if ($is_current_page && !$visible_page && !$visible_page_edit && !$visible_page_settings && !$visible_page_private)
	{
		$visible_page = $visible_page_settings = true;
	}

	$page_icon = post_icons('page_icons/', $page_icon);
	
	// Page templates dropdown
	$template_list = !$new_page ? '' : mx_get_list('use_template', PAGE_TEMPLATES, 'page_template_id', 'template_name', 1, true);
	$l_choose_page_template = !$new_page ? '' : empty($lang['Choose_page_template']) ? "Choose page template" : $lang['Choose_page_template'];

	$template->assign_block_vars('pages', array(
		'L_TITLE' 					=> $lang['Page_admin'],
		'L_EXPLAIN' 				=> $lang['Page_admin_explain'],
		'L_PAGE' 					=> $lang['Page'],

		'L_TITLE_EDIT' 				=> $lang['Page_admin_edit'],
		'L_TITLE_PRIVATE' 			=> $lang['Page_admin_private'],
		'L_TITLE_SETTINGS' 			=> $lang['Page_admin_settings'],


		'VISIBLE' 					=> $visible_page ? 'block' : 'none',
		'VISIBLE_DELETE' 			=> $visible_page_delete && !$new_page ? 'block' : 'none',
		'VISIBLE_EDIT' 				=> $visible_page_edit || $new_page ? 'block' : 'none',
		'VISIBLE_SETTINGS' 			=> $visible_page_settings && !$new_page ? 'block' : 'none',
		'VISIBLE_PRIVATE' 			=> $visible_page_private && !$new_page ? 'block' : 'none',

		'IMG_URL' 					=> $visible_page ? $admin_icon['contract'] : $admin_icon['expand'],
		'IMG_URL_DELETE' 			=> $visible_page_delete ? $admin_icon['contract'] : $admin_icon['expand'],
		'IMG_URL_EDIT' 				=> $visible_page_edit ? $admin_icon['contract'] : $admin_icon['expand'],
		'IMG_URL_SETTINGS' 			=> $visible_page_settings ? $admin_icon['contract'] : $admin_icon['expand'],
		'IMG_URL_PRIVATE' 			=> $visible_page_private ? $admin_icon['contract'] : $admin_icon['expand'],

		'PAGE_ID'					=> $page_id,
		'PAGE_TITLE'				=> $new_page ? $lang['Add_Page'] : $page_title,
		'PAGE_DESC'					=> ( $page_desc != '' ) ? ' - ' . $page_desc : '',
		'PAGE_ICON'					=> $icon_tmp,

		'U_DELETE'					=> mx_append_sid("admin_mx_page_cp.$phpEx" . $deletemode),
		'U_PREVIEW'					=> mx_append_sid($mx_root_path . "index.$phpEx" . '?page=' . $page_id),
		
		// Page subpanel - edit
		'L_CHOOSE_PAGE_TEMPLATE'	=> $l_choose_page_template,
		
		'E_PAGE_TITLE'				=> $page_title,
		'E_PAGE_DESC'				=> $page_desc,
		'E_PAGE_PARENT'				=> $page_list,
		'S_PAGE_ICON'				=> $page_icon,
		'S_PAGE_ALT_ICON'			=> $page_alt_icon,
		'E_PAGE_HEADER'				=> $page_header,
		'E_PAGE_FOOTER'				=> $page_footer,
		'E_PAGE_MAIN_LAYOUT'		=> $page_main_layout,
		"E_NAVIGATION_BLOCK" 		=> $navigation_block_list,
		'S_TEMPLATE_LIST'			=> $template_list,
		
		// Style
		"STYLE_SELECT" => $style_select,
		"OVERRIDE_STYLE_YES" => $override_user_style_yes,
		"OVERRIDE_STYLE_NO" => $override_user_style_no,
		"OVERRIDE_STYLE_DEFAULT" => $override_user_style_default,
		
		// IP filter
		"IP_FILTER" => $ip_filter,
		
		'S_PHPBB_STATS_YES' 		=> $phpbb_stats_yes,
		'S_PHPBB_STATS_NO' 			=> $phpbb_stats_no,
		'S_PHPBB_STATS_DEFAULT' 	=> $phpbb_stats_default,
		
		// Main
		'U_PHPBB_ROOT_PATH' 		=> PHPBB_URL,
		'TEMPLATE_ROOT_PATH' 		=> TEMPLATE_ROOT_PATH,
		'PAGELIST' 					=> $page_list,
		
		// Quick Panels
		'MESSAGE_DELETE' 			=> $message_delete,
		
		'S_HIDDEN_FIELDS'			=> $s_hidden_page_fields,
		'S_HIDDEN_PRIVATE_FIELDS'	=> $s_hidden_private_fields,
		
		'S_SUBMIT' 					=> $new_page ? $lang['Add_Page'] : $lang['Update']
	));

	if ($new_page)
	{
		$template->assign_block_vars('pages.template', array());
	}
	
	// Auth
	$s_column_span = 0;
	for($j = 0; $j < count($auth_fields); $j++)
	{
		$custom_auth[$j] = '&nbsp;<select name="' . $auth_fields[$j] . '">';

		for($k = 0; $k < count($auth_levels); $k++)
		{
			$auth_var = ($j > 0) ? $page_rows[$page_count][$auth_fields[$j]] : '';
			$selected = ($auth_var == $auth_const[$k]) ? ' selected="selected"' : '';
			$custom_auth[$j] .= '<option value="' . $auth_const[$k] . '"' . $selected . '>' . $lang['AUTH_' . $auth_levels[$k]] . '</option>';
		}
		$custom_auth[$j] .= '</select>&nbsp;';

		$cell_title = $field_names[$auth_fields[$j]];

		$template->assign_block_vars('pages.page_auth_titles', array(
			'CELL_TITLE'	=> $cell_title
		));
		$template->assign_block_vars('pages.page_auth_data', array(
			'S_AUTH_LEVELS_SELECT'	=> $custom_auth[$j]
		));

		$s_column_span++;
	}

	//
	// General switches
	//
	if ( !$new_page && $is_current_page)
	{
		$template->assign_block_vars('pages.is_page', array());
	}

	if ( $page_count == 1 )
	{
		$template->assign_block_vars('pages.allpages', array());
	}

	if ( $is_current_page )
	{
		$template->assign_block_vars('pages.is_current', array());
	}
	else if ( $new_page )
	{
		$template->assign_block_vars('pages.is_new', array());
	}
	else
	{
		$template->assign_block_vars('pages.reload', array(
			'U_PAGE_EDIT' => mx_append_sid(PORTAL_URL . "admin/admin_mx_page_cp.$phpEx?page_id=" . $page_id),
		));

		//
		// Only load all parameters for current page
		//
		continue;
	}

	// -----------------------------------------------------------------------------------------------------------
	// Now get the page settings
	//

	if ( $new_page )
	{
		continue;
	}

	//
	// PRIVATE Auth
	//
	$view_groups = @explode(',', $page_rows[$page_count]['auth_view_group']);

	$moderator_groups = @explode(',', $page_rows[$page_count]['auth_moderator_group']);

	for( $i = 0; $i < count($groupdata); $i++ )
	{
		$row_class = ( !( $i % 2 ) ) ? $mx_user->theme['td_class1'] : $mx_user->theme['td_class2'];				
		$row_color = ( !( $i % 2 ) ) ? $mx_user->theme['td_color1'] : $mx_user->theme['td_color2'];
		
		$group_id = $groupdata[$i]['group_id'];
		
		if ( $page_rows[$page_count]['auth_view'] == AUTH_ACL )
		{
			$view_checked = in_array($groupdata[$i]['group_id'], $view_groups) ? 'checked="checked"' : '';
			$input_private = '<input name="view[]" type="checkbox" ' . $view_checked . 'value="'.$group_id.'" />';
		}
		else
		{
			$input_private = '-';
		}
		
		$template->assign_block_vars('pages.grouprow', array(
			'GROUP_ID' 			=> $group_id,
			'GROUP_NAME' 		=> $groupdata[$i]['group_name'],
			'ROW_COLOR' 		=> $row_color,
			'VIEW_INPUT' 		=> $input_private,
			'MODERATOR_CHECKED' => ( in_array($groupdata[$i]['group_id'], $moderator_groups) ) ? 'checked="checked"' : '')
		);
	}
	
	//
	// Get blocklist for alternative add_block
	//
	$blocklist = get_list_formatted('block_list', 0, 'block_id');
	$q_columns = false;
	$sql = "SELECT *
		FROM " . COLUMN_TABLE . "
		WHERE page_id = $page_id
		ORDER BY page_id, column_order";

	if( !($q_columns = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Could not query page columns information", "", __LINE__, __FILE__, $sql);
	}

	$column_rows = array();
	if( $total_column = $db->sql_numrows($q_columns) )
	{
		$column_rows = $db->sql_fetchrowset($q_columns);
	}

	$db->sql_freeresult($result);

	if ( $total_column == 0 )
	{
		$template->assign_block_vars('nocolumns', array(
			'NONE' => $lang['No_columns']
		));
	}

	$mx_block = new mx_block();

	$radio_column_list = '';
	$radio_column_checked = 'checked="checked"';

	if ( $total_column > 0 )
	{
		$template->assign_block_vars('pages.has_columns', array());
	}

	//
	// Okay, let's build the index
	//
	for( $column = 0; $column < $total_column + 1; $column++ )
	{
		$new_column = $column == $total_column;
		$column_id = $new_column ? $page_id . '_0'  : $column_rows[$column]['column_id'];
		
		$row_class = ( !( $column % 2 ) ) ? $mx_user->theme['td_class1'] : $mx_user->theme['td_class2'];				
		$row_color = ( !( $column % 2 ) ) ? $mx_user->theme['td_color1'] : $mx_user->theme['td_color2'];
					
		$mode = MX_PAGE_COLUMN_TYPE;
		$action = $new_column ? MX_DO_INSERT : MX_DO_UPDATE;
		$deletemode = '?mode=' . $mode . '&amp;action=' . MX_DO_DELETE . '&amp;id=' . $column_id . '&amp;page_id=' . $page_id;
		$upmode = '?mode=' . $mode . '&amp;action=' . MX_DO_MOVE . '&amp;id=' . $column_id . '&amp;page_id=' . $page_id . '&amp;move=-15';
		$downmode = '?mode=' . $mode . '&amp;action=' . MX_DO_MOVE . '&amp;id=' . $column_id . '&amp;page_id=' . $page_id . '&amp;move=15';

		//
		// Hidden fields
		//
		$s_hidden_column_fields = 	'<input type="hidden" name="mode" value="' . $mode . '" />
									<input type="hidden" name="action" value="' . $action . '" />
									<input type="hidden" name="id" value="' . $column_id . '" />
									<input type="hidden" name="page_id" value="' . $page_id . '" />
									<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		$message_delete = $lang['Delete_page_column']
				. '<br /><br />' . $lang['Delete_page_column_explain']
				. '<br /><br />' . sprintf($lang['Click_page_column_delete_yes'], '<a href="' . mx_append_sid("admin_mx_page_cp.$phpEx" . $deletemode) . '">', '</a>')
				. '<br /><br />';

		//
		// Subpanel - column edit
		//
		$column_title = $new_column ? '' : $column_rows[$column]['column_title'];
		$column_size = $new_column ? '100%' : $column_rows[$column]['column_size'];

		$visible_column_edit = in_array('adminColumnEdit_' . $page_id . '_' . $column_id, $cookie_states);
		$visible_column_delete = in_array('adminColumnDelete_' . $page_id . '_' . $column_id, $cookie_states);
		$template->assign_block_vars('pages.columnrow', array(
			'L_TITLE' => $lang['Column_admin'],
			'L_TITLE_EXPLAIN' => $lang['Column_admin_explain'],
			'L_COLUMN' => $lang['Column'],

			'COLUMN_ID' => $column_id,
			'COLUMN_TITLE' => $new_column ? $lang['Create_column'] : $column_title,

			'U_COLUMN_DELETE' => mx_append_sid("admin_mx_page_cp.$phpEx" . $deletemode),
			'U_COLUMN_MOVE_UP' => mx_append_sid("admin_mx_page_cp.$phpEx" . $upmode),
			'U_COLUMN_MOVE_DOWN' => mx_append_sid("admin_mx_page_cp.$phpEx" . $downmode),

			//
			// Column Edit
			//
			'L_DELETE'	=> $new_column ? '' : $lang['Delete'],
			'L_MOVE_UP' => $new_column ? '' : $lang['Move_up'],
			'L_MOVE_DOWN' => $new_column ? '' : $lang['Move_down'],

			'L_COLUMN' => $lang['Column'],
			'L_COLUMN_SIZE' => $lang['Column_Size'],

			'VISIBLE' => $visible_column_edit ? 'block' : 'none',
			'VISIBLE_DELETE' => $visible_column_delete ? 'block' : 'none',
			'IMG_URL_EDIT' => $visible_column_edit ? $admin_icon['contract'] : $admin_icon['expand'],
			'IMG_URL_DELETE' => $visible_column_delete ? $admin_icon['contract'] : $admin_icon['expand'],

			'E_COLUMN_TITLE' => $column_title,
			'E_COLUMN_SIZE' => $column_size,

			//
			// Quick Panels
			//
			'MESSAGE_DELETE' 			=> $message_delete,

			'S_SUBMIT' => $new_column ? $lang['Create_column'] : $lang['Update'],

			'S_HIDDEN_FIELDS' => $s_hidden_column_fields
		));
		// Add up radioboxes for block to column form
		if (!$new_column)
		{
			$radio_column_list .= '<input type="radio" name="id" value="'.$column_id.'" '.$radio_column_checked.' /><span class="gensmall">'.$column_title.'&nbsp;&nbsp;</span><br />';
		}
		$column_id = isset($column_rows[$column]['column_id']) ? $column_rows[$column]['column_id'] : 0;
		$sql = "SELECT cbl.*, blk.*, fnc.function_file, function_admin
			FROM " . COLUMN_BLOCK_TABLE . " cbl,
				" . BLOCK_TABLE . " blk,
				" . FUNCTION_TABLE . " fnc
			WHERE blk.function_id = fnc.function_id
				AND blk.block_id = cbl.block_id
				AND cbl.column_id = '" . $column_id . "'
			ORDER BY column_id, block_order";

		if( !($q_blocks = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Could not query blocks information", "", __LINE__, __FILE__, $sql);
		}

		if( $total_blocks = $db->sql_numrows($q_blocks) )
		{
			$block_rows = $db->sql_fetchrowset($q_blocks);
		}

		$db->sql_freeresult($result);

		//
		// Now continue with page blocks
		//
		for( $block = 0; $block < $total_blocks; $block++ )
		{
			$block_id = $block_rows[$block]['block_id'];
			$mx_block->init( $block_id, true );

			$block_order = $block_rows[$block]['block_order'];
			$editor_name_tmp = mx_get_userdata($mx_block->editor_id);
			$editor_name = $editor_name_tmp['username'];
			$edit_time = phpBB2::create_date( $board_config['default_dateformat'], $mx_block->block_time, $board_config['board_timezone'] );

			$mode = MX_PAGE_BLOCK_TYPE;
			$deletemode = '?mode=' . $mode . '&amp;action=' . MX_DO_DELETE . '&amp;id=' . $block_id . '&amp;column_id=' . $column_id . '&amp;block_order=' . $block_order;

			$upmode = '?mode=' . $mode . '&amp;action=' . MX_DO_MOVE . '&amp;id=' . $block_id . '&amp;column_id=' . $column_id . '&amp;page_id=' . $page_id . '&amp;block_order=' . $block_order . '&amp;move=-15';
			$downmode = '?mode=' . $mode . '&amp;action=' . MX_DO_MOVE . '&amp;id=' . $block_id . '&amp;column_id=' . $column_id . '&amp;page_id=' . $page_id . '&amp;block_order=' . $block_order . '&amp;move=15';
			$syncmode = '?mode=' . $mode . '&amp;action=' . MX_DO_SYNC . '&amp;id=' . $block_id . '&amp;column_id=' . $column_id;

			if( !empty($mx_block->block_edit_file) )
			{
				$l_setting = $lang['Block_cp'];
				$u_setting = mx_append_sid(PORTAL_URL . $mx_block->block_edit_file . "?block_id=$block_id");
			}
			else
			{
				$u_setting = '';
				$l_setting = '';

				//
				// Show Block Settings even if no BLOCK_SYSTEM_PARAMETER_TABLE row exists.
				// admin_mx_block.php will populate them if necessary (see B4).
				//
				$l_setting = $lang['Block_cp'];
				$u_setting = mx_append_sid("admin_mx_block_cp.$phpEx?block_id=$block_id");
			}

			$controller_block = $block_rows[$block]['function_file'] == 'mx_multiple_blocks.php' || $block_rows[$block]['function_file'] == 'mx_dynamic.php' || $block_rows[$block]['function_file'] == 'mx_virtual.php';

			$template->assign_block_vars('pages.columnrow.blockrow', array(
				'L_SETTING' => $l_setting,
				'L_REMOVE' => $lang['Remove'],

				'BLOCK_ID' => $block_id,
				'BLOCK_TITLE' => $mx_block->block_title,
				'BLOCK_DESC' => ( $mx_block->block_desc != '' ) ? '<br />&nbsp;&nbsp;' . $mx_block->block_desc : '',
				'BLOCK_LAST_EDITED' => ( $editor_name != '' ) ? ' (' . $lang['Block_updated_by'] . $editor_name . ', ' . $edit_time . ')' : '',

				'IMG_ICON_BLOCK' => $controller_block ? $admin_icon['page'] : $admin_icon['block'],
				'ROW_COLOR' => $row_color,

				'U_BLOCK_EDIT' => $u_setting,
				'U_BLOCK_SETTING' => $u_setting,

				'U_BLOCK_DELETE' => mx_append_sid("admin_mx_page_cp.$phpEx" . $deletemode),
				'U_BLOCK_MOVE_UP' => mx_append_sid("admin_mx_page_cp.$phpEx" . $upmode),
				'U_BLOCK_MOVE_DOWN' => mx_append_sid("admin_mx_page_cp.$phpEx" . $downmode),
				'U_BLOCK_RESYNC' => mx_append_sid("admin_mx_page_cp.$phpEx" . $syncmode)
			));
		} // for ... blocks

		if (!$new_column)
		{
			$mode = MX_PAGE_BLOCK_TYPE;
			$action = MX_DO_INSERT;

			//
			// Hidden fields
			//
			$s_hidden_page_fields = 	'<input type="hidden" name="mode" value="' . $mode . '" />
										<input type="hidden" name="action" value="' . $action . '" />
										<input type="hidden" name="id" value="' . $column_id . '" />
										<input type="hidden" name="page_id" value="' . $page_id . '" />
										<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

			$template->assign_block_vars('pages.columnrow.add_block', array(
					'LIST_BLOCK' => $blocklist,
					'S_SUBMIT' => $lang['Add_Block'],
					'S_SUBMIT_SPLIT' => $lang['Add_Split_Block'],
					'S_SUBMIT_SPLIT_EXPLAIN' => $lang['Add_Split_Block_explain'],
					'S_SUBMIT_DYNAMIC' => $lang['Add_Dynamic_Block'],
					'S_SUBMIT_DYNAMIC_EXPLAIN' => $lang['Add_Dynamic_Block_explain'],
					'S_SUBMIT_VIRTUAL' => $lang['Add_Virtual_Block'],
					'S_SUBMIT_VIRTUAL_EXPLAIN' => $lang['Add_Virtual_Block_explain'],

					'S_HIDDEN_FIELDS' => $s_hidden_page_fields
			));

			$template->assign_block_vars('pages.columnrow.is_columnrow', array());
		}
	} // for ... column
}

$mode = MX_PAGE_BLOCK_TYPE;
$action = MX_DO_INSERT;

//
// Hidden fields
//
$s_hidden_dyn_fields = 	'<input type="hidden" name="mode" value="' . $mode . '" />
							<input type="hidden" name="action" value="' . $action . '" />
							<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

$template->assign_vars(array(
	'PAGE_SELECT_BOX' => $select_page,
	'RADIO_COLUMN_LIST' => $radio_column_list,
	'S_HIDDEN_DYN_FIELDS' => $s_hidden_dyn_fields
));

include_once('./page_header_admin.' . $phpEx);
$template->pparse('body');
include_once('./page_footer_admin.' . $phpEx);
?>