<?php
/**
*
* @package mxBB Portal Core
* @version $Id: admin_mx_portal.php,v 1.2 2009/01/24 16:45:47 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !empty($setmodules) )
{
	$module['1_General_admin']['1_1_Management'] = 'admin/' . basename(__FILE__);
	return;
}

//
// Security and Page header
//
@define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require('./pagestart.' . $phpEx);

//
// Begin program proper
//
$mode = '';

if( isset($_POST['submit']) )
{
	$mode = 'submit';
}

if( !empty($mode) )
{
	if ($mx_request_vars->is_empty_post('portal_phpbb_url'))
	{
		mx_message_die(GENERAL_ERROR, "Failed to update portal configuration, you didn't specified valid values or your admin templates are incompatible with this version of MXP.");
	}

	$new['portal_name'] 			= $mx_request_vars->post('portal_name', MX_TYPE_NO_TAGS, 'mxBB Portal and CMS');
	$new['portal_url'] 				= $mx_request_vars->post('portal_url', MX_TYPE_NO_TAGS, '');
	$new['portal_phpbb_url'] 		= $mx_request_vars->post('portal_phpbb_url', MX_TYPE_NO_TAGS, '');	
	$new['default_admin_style'] 	= $mx_request_vars->post('mx_default_admin_style', MX_TYPE_NO_TAGS, '-1');
	
	$new['portal_backend'] 			= $mx_request_vars->post('portal_backend', MX_TYPE_NO_TAGS, 'phpbb2');
	
	$new['default_style'] 			= $mx_request_vars->post('mx_default_style', MX_TYPE_NO_TAGS, '-1');
	$new['override_user_style'] 	= $mx_request_vars->post('mx_override_user_style', MX_TYPE_NO_TAGS, '1');
	$new['overall_header'] 			= $mx_request_vars->post('overall_header', MX_TYPE_NO_TAGS, 'overall_header.tpl');
	$new['overall_footer'] 			= $mx_request_vars->post('overall_footer', MX_TYPE_NO_TAGS, 'overall_footer.tpl');
	$new['main_layout'] 			= $mx_request_vars->post('main_layout', MX_TYPE_NO_TAGS, 'mx_main_layout.tpl');
	$new['navigation_block'] 		= $mx_request_vars->post('navigation_block', MX_TYPE_INT, '0');
	$new['top_phpbb_links'] 		= $mx_request_vars->post('top_phpbb_links', MX_TYPE_INT, '0');
	$new['mx_use_cache'] 			= $mx_request_vars->post('mx_use_cache', MX_TYPE_INT, '1');
	$new['mod_rewrite'] 			= $mx_request_vars->post('mod_rewrite', MX_TYPE_INT, '0');
	$new['portal_status'] 			= $mx_request_vars->post('portal_status', MX_TYPE_INT, '0');
	$new['disabled_message'] 		= $mx_request_vars->post('disabled_message', MX_TYPE_NO_TAGS, 'Site disabled.');

	$sql = "UPDATE  " . PORTAL_TABLE . " SET " . $db->sql_build_array('UPDATE', utf8_normalize_nfc($new));

	if( !($db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Failed to update portal configuration ", "", __LINE__, __FILE__, $sql);
	}

	$message = update_portal_backend($new['portal_backend']) ? "The CMS configuration file was upgraded ...<br /><br />" : update_portal_backend($new['portal_backend']);

	$mx_cache->put('mxbb_config', $new);

	$message .= $lang['Portal_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_portal_config'], "<a href=\"" . mx_append_sid("admin_mx_portal.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	mx_message_die(GENERAL_MESSAGE, $message);
}

$template->set_filenames(array( 'admin_portal' => 'admin/admin_mx_portal.tpl') );

$top_phpbb_links_yes = ( $portal_config['top_phpbb_links'] == 1 ) ? 'checked="checked"' : '';
$top_phpbb_links_no = ( $portal_config['top_phpbb_links'] == 0 ) ? 'checked="checked"' : '';

$mx_use_cache_yes = ( $portal_config['mx_use_cache'] == 1 ) ? 'checked="checked"' : '';
$mx_use_cache_no = ( $portal_config['mx_use_cache'] == 0 ) ? 'checked="checked"' : '';

$mx_mod_rewrite_yes = ( $portal_config['mod_rewrite'] == 1 ) ? 'checked="checked"' : '';
$mx_mod_rewrite_no = ( $portal_config['mod_rewrite'] == 0 ) ? 'checked="checked"' : '';

$mx_portal_status_yes = ( $portal_config['portal_status'] == 1 ) ? 'checked="checked"' : '';
$mx_portal_status_no = ( $portal_config['portal_status'] == 0 ) ? 'checked="checked"' : '';

$disabled_message = $portal_config['disabled_message'];

$phpbb_rel_path = substr( "$phpbb_root_path", 3 );

$navigation_block_list = get_list_formatted('block_list', $portal_config['navigation_block'], 'navigation_block', 'mx_menu_nav.php', false, 'mx_site_nav.php');

$portal_version = $portal_config['portal_version'];
$phpbb_version = '2' . $board_config['version'];
$phpbb_script_path = $board_config['script_path'];
$phpbb_server_name = $board_config['server_name'];

// Default to phpBB default
$portal_config['default_admin_style'] = $portal_config['default_admin_style'] == -1 ? $board_config['default_style'] : $portal_config['default_admin_style'];
$portal_config['default_style'] = $portal_config['default_style'] == -1 ? $board_config['default_style'] : $portal_config['default_style'];
$portal_config['override_user_style'] = $portal_config['override_user_style'] == -1 ? $board_config['override_user_style'] : $portal_config['override_user_style'];

$style_select = mx_style_select($portal_config['default_style'], 'mx_default_style');
$style_admin_select = mx_style_select($portal_config['default_admin_style'], 'mx_default_admin_style');

if ( isset($mx_user->data['user_timezone']) )
{
	$portal_config['board_timezone'] = $board_config['board_timezone'] = $mx_user->data['user_timezone'];
}
else
{
	$portal_config['board_timezone'] = $board_config['board_timezone'];
}

$lang_select = mx_language_select($mx_user->lang_name, 'default_lang', "language");
$timezone_select = mx_tz_select($portal_config['board_timezone'], 'board_timezone');

$override_user_style_yes = ( $portal_config['override_user_style'] ) ? "checked=\"checked\"" : "";
$override_user_style_no = ( !$portal_config['override_user_style'] ) ? "checked=\"checked\"" : "";

$template->assign_vars(array(
	"S_CONFIG_ACTION" => mx_append_sid("admin_mx_portal.$phpEx"),

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],

	"L_CONFIGURATION_TITLE" => $lang['Portal_General_Config'],
	"L_CONFIGURATION_EXPLAIN" => $lang['Portal_General_Config_explain'],
	"L_GENERAL_SETTINGS" => $lang['Portal_General_settings'],
	"L_GENERAL_CONFIG_INFO" => $lang['Portal_General_config_info'] . "<br />" . $lang['Portal_General_config_info_explain'],
	"L_STYLE_SETTINGS" => $lang['Portal_Style_settings'],

	"L_PORTAL_NAME" => $lang['Portal_Name'],
	"L_PORTAL_URL" => $lang['Portal_Url'] . "<br />" . !empty($lang['Portal_url_explain']) ? $lang['Portal_url_explain'] : $mx_user->lang('Portal_url_explain'),
	"L_PORTAL_PHPBB_URL" => $lang['Portal_PHPBB_Url'] . "<br />" . $lang['Phpbb_url_explain'],
	"L_OVERALL_HEADER" => $lang['Portal_Overall_header'] . "<br />" . $lang['Portal_Overall_header_explain'],
	"L_OVERALL_FOOTER" => $lang['Portal_Overall_footer'] . "<br />" . $lang['Portal_Overall_footer_explain'],
	"L_MAIN_LAYOUT" => $lang['Portal_Main_layout'] . "<br />" . $lang['Portal_Main_layout_explain'],
	"L_NAVIGATION_BLOCK" => $lang['Portal_Navigation_block'] . "<br />" . $lang['Portal_Navigation_block_explain'],
	"L_SUBMIT" => $lang['Submit'],
	"L_RESET" => $lang['Reset'],

	"PORTAL_NAME" => $portal_config['portal_name'],
	"PORTAL_URL" => $portal_config['portal_url'],
	
	"L_PORTAL_DESC" => !empty($lang['Portal_Desc']) ? $mx_user->lang('Portal_Desc') : 'Portal_Desc_not_Implemented', // Will override phpBB 'site_desc'
	"PORTAL_DESC" => str_replace('"', '&quot;', $mx_user->lang('Portal_Desc')),

	"L_PORTAL_STATUS" => !empty($lang['Portal_status']) ? $mx_user->lang('Portal_status') : 'Portal_status_not_Implemented', // Will  override phpBB 'board_disable'
	"L_PORTAL_STATUS_EXPLAIN" => !empty($lang['Portal_status_explain']) ? $mx_user->lang('Portal_status_explain') : 'Portal_status_explain_not_Implemented',
	"S_PORTAL_STATUS_YES" => ( $portal_config['portal_status'] == 1 ) ? 'checked="checked"' : '',
	"S_PORTAL_STATUS_NO" => ( $portal_config['portal_status'] == 0 ) ? 'checked="checked"' : '',

	"L_DISABLED_MESSAGE" => $lang['Disabled_message'], // Will  override phpBB3 'board_disable_msg'
	"DISABLED_MESSAGE" => $portal_config['disabled_message'],

	"L_SERVER_NAME" => !empty($lang['Server_name']) ? $mx_user->lang('Server_name') : 'Server_name_not_Implemented',
	"L_SERVER_NAME_EXPLAIN" => !empty($lang['Server_name_explain']) ? $mx_user->lang('Server_name_explain') : 'Server_name_explain_not_Implemented',
	"SERVER_NAME" => $board_config['server_name'],

	"L_SERVER_PORT" => $lang['Server_port'],
	"L_SERVER_PORT_EXPLAIN" => $lang['Server_port_explain'],
	"SCRIPT_PATH" => $board_config['script_path'],

	"L_SCRIPT_PATH" => $lang['Script_path'],
	"L_SCRIPT_PATH_EXPLAIN" => $lang['Script_path_explain'],
	"SERVER_PORT" => $board_config['server_port'],

	"L_DATE_FORMAT" => 'phpBB2 ' . $lang['Date_format'],
	"L_DATE_FORMAT_EXPLAIN" => $lang['Date_format_explain'],
	"DEFAULT_DATEFORMAT" => $board_config['default_dateformat'],

	"L_SYSTEM_TIMEZONE" => 'phpBB2 ' . $lang['System_timezone'],
	"TIMEZONE_SELECT" => $timezone_select, // board_timezone	

	"L_ENABLE_GZIP" => 'phpBB2 ' . $lang['Enable_gzip'],
	"GZIP_YES" => ( $board_config['gzip_compress'] ) ? "checked=\"checked\"" : "",
	"GZIP_NO" => ( !$board_config['gzip_compress'] ) ? "checked=\"checked\"" : "",
	
	"PORTAL_PHPBB_URL" => $portal_config['portal_phpbb_url'],
	"OVERALL_HEADER" => $portal_config['overall_header'],
	
	"OVERALL_FOOTER" => $portal_config['overall_footer'],
	"MAIN_LAYOUT" => $portal_config['main_layout'],
	"NAVIGATION_BLOCK" => $navigation_block_list,

	"L_PHPBB_RELATIVE_PATH" => $lang['Phpbb_path'],
	"L_PHPBB_RELATIVE_PATH_EXPLAIN" => $lang['Phpbb_path_explain'],
	"PHPBB_RELATIVE_PATH" => $phpbb_rel_path,
	
	"L_PORTAL_VERSION" => $lang['Portal_version'],
	"PORTAL_VERSION" => $portal_version,

	"L_PHPBB_INFO" => $lang['PHPBB_info'],

	"L_PHPBB_SERVER_NAME" => $lang['PHPBB_server_name'],
	"PHPBB_SERVER_NAME" => $phpbb_server_name,
	
	"L_PHPBB_SCRIPT_PATH" => $lang['PHPBB_script_path'],
	"PHPBB_SCRIPT_PATH" => $phpbb_script_path,
	
	"L_PHPBB_VERSION" => $lang['PHPBB_version'],
	"PHPBB_VERSION" => $phpbb_version,

	"L_TOP_PHPBB_LINKS" => $lang['Top_phpbb_links'] . "<br />" . $lang['Top_phpbb_links_explain'],
	"S_TOP_PHPBB_LINKS_YES" => $top_phpbb_links_yes,
	"S_TOP_PHPBB_LINKS_NO" => $top_phpbb_links_no,
	"TOP_PHPBB_LINKS" => $portal_config['top_phpbb_links'],

	"L_MX_USE_CACHE" => $lang['Mx_use_cache'],
	"L_MX_USE_CACHE_EXPLAIN" => $lang['Mx_use_cache_explain'],
	"S_MX_USE_CACHE_YES" => $mx_use_cache_yes,
	"S_MX_USE_CACHE_NO" => $mx_use_cache_no,
	"MX_USE_CACHE" => $portal_config['mx_use_cache'],

	//
	// User & Styling
	//
	"L_DEFAULT_LANG" => $lang['Default_language'],
	"L_DEFAULT_LANGUAGE" => $lang['Default_language'],
	"LANG_SELECT" => $lang_select,	
	
	"L_DEFAULT_STYLE" => $lang['Default_style'],
	"L_DEFAULT_ADMIN_STYLE" => $lang['Default_admin_style'],
	
	"L_OVERRIDE_STYLE" => $lang['Override_style'],
	"L_OVERRIDE_STYLE_EXPLAIN" => $lang['Override_style_explain'],

	"STYLE_SELECT" => $style_select,
	"ADMIN_STYLE_SELECT" => $style_admin_select,
	"OVERRIDE_STYLE_YES" => $override_user_style_yes,
	"OVERRIDE_STYLE_NO" => $override_user_style_no,

	"L_MX_MOD_REWRITE" => $lang['Mx_mod_rewrite'],
	"L_MX_MOD_REWRITE_EXPLAIN" => $lang['Mx_mod_rewrite_explain'],
	"S_MX_MOD_REWRITE_YES" => $mx_mod_rewrite_yes,
	"S_MX_MOD_REWRITE_NO" => $mx_mod_rewrite_no,
	"MX_MOD_REWRITE" => $portal_config['mod_rewrite'],
	
	//
	// Backend info
	//
	"L_PHPBB_INFO" => $lang['PHPBB_info'],

	"L_PHPBB_RELATIVE_PATH" => $lang['Phpbb_path'] ? $mx_user->lang('Phpbb_path') : 'phpBB path',
	"L_PHPBB_RELATIVE_PATH_EXPLAIN" => $mx_user->lang('Phpbb_path_explain'),
	"PHPBB_RELATIVE_PATH" => substr( "$phpbb_root_path", 3 ),
	
	"L_PORTAL_STATUS" => $lang['Portal_status'],
	"L_PORTAL_STATUS_EXPLAIN" => $lang['Portal_status_explain'],
	"S_PORTAL_STATUS_YES" => $mx_portal_status_yes,
	"S_PORTAL_STATUS_NO" => $mx_portal_status_no,

	"L_DISABLED_MESSAGE" => $lang['Disabled_message'],
	"DISABLED_MESSAGE" => $disabled_message,
));

$template->pparse('admin_portal');
include_once('page_footer_admin.' . $phpEx);
?>