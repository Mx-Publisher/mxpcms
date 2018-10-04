<?php
/**
*
* @package MX-Publisher Core
* @version $Id: admin_mx_portal.php,v 1.53 2014/05/19 18:14:40 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
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

if ($mx_request_vars->is_post('submit') )
{
	$mode = 'submit';
}

if( !empty($mode) )
{
	if ($mx_request_vars->is_empty_post('server_name') || $mx_request_vars->is_empty_post('default_lang'))
	{
		mx_message_die(GENERAL_ERROR, "Failed to update portal configuration, you didn't specified valid values or your admin templates are incompatible with this version of MXP.");
	}

	$new['portal_name'] 			= utf8_normalize_nfc($mx_request_vars->post('portal_name', MX_TYPE_NO_TAGS, 'MX-Publisher'));
	$new['portal_desc'] 			= utf8_normalize_nfc($mx_request_vars->post('portal_desc', MX_TYPE_NO_TAGS, 'Modular system'));
	$new['portal_status'] 			= $mx_request_vars->post('portal_status', MX_TYPE_INT, '0');
	$new['disabled_message'] 		= $mx_request_vars->post('disabled_message', MX_TYPE_NO_TAGS, 'Site disabled.');
	$new['server_name'] 			= $mx_request_vars->post('server_name', MX_TYPE_NO_TAGS, '');
	$new['server_name'] 			= str_replace('http://', '', $new['server_name']);
	$new['script_path'] 			= $mx_request_vars->post('script_path', MX_TYPE_NO_TAGS, '');
	$new['server_port'] 			= $mx_request_vars->post('server_port', MX_TYPE_NO_TAGS, '');
	$new['default_dateformat'] 		= $mx_request_vars->post('default_dateformat', MX_TYPE_NO_TAGS, '');
	$new['board_timezone'] 			= $mx_request_vars->post('board_timezone', MX_TYPE_NO_TAGS, '');
	$new['gzip_compress'] 			= $mx_request_vars->post('gzip_compress', MX_TYPE_INT, '');
	$new['mx_use_cache'] 			= $mx_request_vars->post('mx_use_cache', MX_TYPE_INT, '1');
	$new['mod_rewrite'] 			= $mx_request_vars->post('mod_rewrite', MX_TYPE_INT, '0');

	$new['portal_backend'] 			= $mx_request_vars->post('portal_backend', MX_TYPE_NO_TAGS, 'internal');
	$new['portal_backend_path'] 	= $mx_request_vars->post('portal_backend_path', MX_TYPE_NO_TAGS, '');

	$new['cookie_domain'] 			= $mx_request_vars->post('cookie_domain', MX_TYPE_NO_TAGS, '');
	$new['cookie_name'] 			= $mx_request_vars->post('cookie_name', MX_TYPE_NO_TAGS, '');
	$new['cookie_name'] 			= str_replace('.', '_', $new['cookie_name']);
	$new['cookie_path'] 			= $mx_request_vars->post('cookie_path', MX_TYPE_NO_TAGS, '');
	$new['cookie_secure'] 			= $mx_request_vars->post('cookie_secure', MX_TYPE_INT, '');
	$new['session_length'] 			= $mx_request_vars->post('session_length', MX_TYPE_NO_TAGS, '');
	$new['allow_autologin'] 		= $mx_request_vars->post('allow_autologin', MX_TYPE_INT, '');
	$new['max_autologin_time'] 		= $mx_request_vars->post('max_autologin_time', MX_TYPE_NO_TAGS, '');
	$new['max_login_attempts'] 		= $mx_request_vars->post('max_login_attempts', MX_TYPE_NO_TAGS, '');
	$new['login_reset_time'] 		= $mx_request_vars->post('login_reset_time', MX_TYPE_NO_TAGS, '');

//	$new['portal_url'] 				= $mx_request_vars->post('portal_url', MX_TYPE_NO_TAGS, '');
//	$new['portal_phpbb_url'] 		= $mx_request_vars->post('portal_phpbb_url', MX_TYPE_NO_TAGS, '');

	$new['default_lang'] 			= $mx_request_vars->post('default_lang', MX_TYPE_NO_TAGS, '-1');
	$new['default_style'] 			= $mx_request_vars->post('mx_default_style', MX_TYPE_NO_TAGS, '-1');
	$new['override_user_style'] 	= $mx_request_vars->post('mx_override_user_style', MX_TYPE_NO_TAGS, '1');
	$new['default_admin_style'] 	= $mx_request_vars->post('mx_default_admin_style', MX_TYPE_NO_TAGS, '-1');
	$new['overall_header'] 			= $mx_request_vars->post('overall_header', MX_TYPE_NO_TAGS, 'overall_header.tpl');
	$new['overall_footer'] 			= $mx_request_vars->post('overall_footer', MX_TYPE_NO_TAGS, 'overall_footer.tpl');
	$new['main_layout'] 			= $mx_request_vars->post('main_layout', MX_TYPE_NO_TAGS, 'mx_main_layout.tpl');
	$new['navigation_block'] 		= $mx_request_vars->post('navigation_block', MX_TYPE_INT, '0');
	$new['top_phpbb_links'] 		= $mx_request_vars->post('top_phpbb_links', MX_TYPE_INT, '0');
	$new['allow_html'] 				= $mx_request_vars->post('allow_html', MX_TYPE_INT, '1');
	$new['allow_html_tags'] 		= $mx_request_vars->post('allow_html_tags', MX_TYPE_NO_TAGS, '1');
	$new['allow_bbcode'] 			= $mx_request_vars->post('allow_bbcode', MX_TYPE_INT, '1');
	$new['allow_smilies'] 			= $mx_request_vars->post('allow_smilies', MX_TYPE_INT, '1');
	$new['smilies_path'] 			= $mx_request_vars->post('smilies_path', MX_TYPE_NO_TAGS, '');

	$new['board_email'] 			= $mx_request_vars->post('board_email', MX_TYPE_NO_TAGS, '0');
	$new['board_email_sig'] 		= $mx_request_vars->post('board_email_sig', MX_TYPE_NO_TAGS, '0');
	$new['smtp_delivery'] 			= $mx_request_vars->post('smtp_delivery', MX_TYPE_INT, '0');
	$new['smtp_host'] 				= $mx_request_vars->post('smtp_host', MX_TYPE_NO_TAGS, '0');
	$new['smtp_username'] 			= $mx_request_vars->post('smtp_username', MX_TYPE_NO_TAGS, '0');
	$new['smtp_password'] 			= $mx_request_vars->post('smtp_password', MX_TYPE_NO_TAGS, '0');


	$sql = "UPDATE  " . PORTAL_TABLE . " SET " . $db->sql_build_array('UPDATE', $new);
	if( !($db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Failed to update portal configuration ", "", __LINE__, __FILE__, $sql);
	}

	$message = update_portal_backend($new['portal_backend']) ? "The CMS configuration file was upgraded ...<br /><br />" : update_portal_backend($new['portal_backend']);
	
	$mx_cache->put('mxbb_config', $new);
	
	$message .= $lang['Portal_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_portal_config'], "<a href=\"" . mx_append_sid("admin_mx_portal.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	mx_message_die(GENERAL_MESSAGE, $message);
}

$template->set_filenames(array( 'admin_portal' => 'admin/admin_mx_portal.'.$tplEx) );

$navigation_block_list = get_list_formatted('block_list', $portal_config['navigation_block'], 'navigation_block', 'mx_menu_nav.' . $phpEx, false, 'mx_site_nav.' . $phpEx);

$portal_config['default_lang'] = $portal_config['default_lang'] == -1 ? $board_config['default_lang'] : $portal_config['default_lang'];
$portal_config['default_admin_style'] = $portal_config['default_admin_style'] == -1 ? $board_config['default_style'] : $portal_config['default_admin_style'];
$portal_config['default_style'] = $portal_config['default_style'] == -1 ? $board_config['default_style'] : $portal_config['default_style'];
$portal_config['override_user_style'] = $portal_config['override_user_style'] == -1 ? $board_config['override_user_style'] : $portal_config['override_user_style'];

$portal_backend_select = get_list_static('portal_backend', array('internal' => 'Internal', 'phpbb2' => 'phpBB2', 'phpbb3' => 'phpBB3', 'olympus' => 'Olympus', 'ascraeus' => 'Ascraeus', 'smf2' => 'SMF2', 'mybb' => 'myBB'), $portal_config['portal_backend']);

$style_select = mx_style_select($portal_config['default_style'], 'mx_default_style');
$style_admin_select = mx_style_select($portal_config['default_admin_style'], 'mx_default_admin_style');

$lang_select = mx_language_select($portal_config['default_lang'], 'default_lang', "language");
$timezone_select = mx_tz_select($portal_config['board_timezone'], 'board_timezone');

$current_phpbb_version = $mx_backend->get_phpbb_version(); // Empty if mxp is used standalone

//
// Valid portal backend
//
$valid_backend_text = $mx_backend->confirm_backend() ? $lang['Portal_config_valid_true'] : $lang['Portal_config_valid_false'];

$template->assign_vars(array(
	"S_CONFIG_ACTION" => mx_append_sid("admin_mx_portal.$phpEx"),

	"L_PORTAL_BACKEND_VALID" => $lang['Portal_config_valid'],
	"L_PORTAL_BACKEND_VALID_STATUS" => $valid_backend_text,

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],

	"L_ENABLED" => $lang['Enabled'],
	"L_DISABLED" => $lang['Disabled'],

	"L_SUBMIT" => $lang['Submit'],
	"L_SUBMIT_BACKEND" => $lang['Portal_Backend_submit'],
	"L_RESET" => $lang['Reset'],

	"L_CONFIGURATION_TITLE" => $lang['Portal_General_Config'],
	"L_CONFIGURATION_EXPLAIN" => $lang['Portal_General_Config_explain'],
	"L_GENERAL_SETTINGS" => $lang['Portal_General_settings'],
	"L_GENERAL_CONFIG_INFO" => $lang['Portal_General_config_info'] . "<br />" . $lang['Portal_General_config_info_explain'],
	"L_STYLE_SETTINGS" => $lang['Portal_Style_settings'],

	//
	// General
	//
	"L_PORTAL_NAME" => $lang['Portal_Name'], // Will override phpBB 'sitename'
	"PORTAL_NAME" => str_replace('"', '&quot;', strip_tags($portal_config['portal_name'])),

	"L_PORTAL_DESC" => $lang['Portal_Desc'], // Will override phpBB 'site_desc'
	"PORTAL_DESC" => str_replace('"', '&quot;', $portal_config['portal_desc']),

	"L_PORTAL_STATUS" => $lang['Portal_status'], // Will  override phpBB 'board_disable'
	"L_PORTAL_STATUS_EXPLAIN" => $lang['Portal_status_explain'],
	"S_PORTAL_STATUS_YES" => ( $portal_config['portal_status'] == 1 ) ? 'checked="checked"' : '',
	"S_PORTAL_STATUS_NO" => ( $portal_config['portal_status'] == 0 ) ? 'checked="checked"' : '',

	"L_DISABLED_MESSAGE" => $lang['Disabled_message'], // Will  override phpBB3 'board_disable_msg'
	"DISABLED_MESSAGE" => $portal_config['disabled_message'],

	"L_SERVER_NAME" => $lang['Server_name'],
	"L_SERVER_NAME_EXPLAIN" => $lang['Server_name_explain'],
	"SERVER_NAME" => $portal_config['server_name'],

	"L_SERVER_PORT" => $lang['Server_port'],
	"L_SERVER_PORT_EXPLAIN" => $lang['Server_port_explain'],
	"SCRIPT_PATH" => $portal_config['script_path'],

	"L_SCRIPT_PATH" => $lang['Script_path'],
	"L_SCRIPT_PATH_EXPLAIN" => $lang['Script_path_explain'],
	"SERVER_PORT" => $portal_config['server_port'],

	"L_DATE_FORMAT" => $lang['Date_format'],
	"L_DATE_FORMAT_EXPLAIN" => $lang['Date_format_explain'],
	"DEFAULT_DATEFORMAT" => $portal_config['default_dateformat'],

	"L_SYSTEM_TIMEZONE" => $lang['System_timezone'],
	"TIMEZONE_SELECT" => $timezone_select, // board_timezone

	"L_ENABLE_GZIP" => $lang['Enable_gzip'],
	"GZIP_YES" => ( $portal_config['gzip_compress'] ) ? "checked=\"checked\"" : "",
	"GZIP_NO" => ( !$portal_config['gzip_compress'] ) ? "checked=\"checked\"" : "",

	"L_MX_USE_CACHE" => $lang['Mx_use_cache'],
	"L_MX_USE_CACHE_EXPLAIN" => $lang['Mx_use_cache_explain'],
	"S_MX_USE_CACHE_YES" => ( $portal_config['mx_use_cache'] == 1 ) ? 'checked="checked"' : '',
	"S_MX_USE_CACHE_NO" => ( $portal_config['mx_use_cache'] == 0 ) ? 'checked="checked"' : '',
	"MX_USE_CACHE" => $portal_config['mx_use_cache'],

	"L_MX_MOD_REWRITE" => $lang['Mx_mod_rewrite'],
	"L_MX_MOD_REWRITE_EXPLAIN" => $lang['Mx_mod_rewrite_explain'],
	"S_MX_MOD_REWRITE_YES" => ( $portal_config['mod_rewrite'] == 1 ) ? 'checked="checked"' : '',
	"S_MX_MOD_REWRITE_NO" => ( $portal_config['mod_rewrite'] == 0 ) ? 'checked="checked"' : '',
	"MX_MOD_REWRITE" => $portal_config['mod_rewrite'],


	//
	// Cookies and Sessions
	//
	"L_PORTAL_BACKEND" => $lang['Portal_Backend'],
	"L_PORTAL_BACKEND_EXPLAIN" => $lang['Portal_Backend_explain'],
	"PORTAL_BACKEND_SELECT" => $portal_backend_select,

	"L_PORTAL_BACKEND_PATH" => $lang['Portal_Backend_path'],
	"L_PORTAL_BACKEND_PATH_EXPLAIN" => $lang['Portal_Backend_path_explain'],
	"PORTAL_BACKEND_PATH" => $portal_config['portal_backend_path'],

	"L_COOKIE_SETTINGS" => $lang['Cookie_settings'],
	"L_COOKIE_SETTINGS_EXPLAIN" => $lang['Cookie_settings_explain'],
	"L_COOKIE_SETTINGS_EXPLAIN_MXP" => $lang['Cookie_settings_explain_mxp'],

	"L_COOKIE_DOMAIN" => $lang['Cookie_domain'],
	"COOKIE_DOMAIN" => $portal_config['cookie_domain'],

	"L_COOKIE_NAME" => $lang['Cookie_name'],
	"COOKIE_NAME" => $portal_config['cookie_name'],

	"L_COOKIE_PATH" => $lang['Cookie_path'],
	"COOKIE_PATH" => $portal_config['cookie_path'],

	"L_COOKIE_SECURE" => $lang['Cookie_secure'],
	"L_COOKIE_SECURE_EXPLAIN" => $lang['Cookie_secure_explain'],
	"S_COOKIE_SECURE_ENABLED" => ( $portal_config['cookie_secure'] ) ? "checked=\"checked\"" : "",
	"S_COOKIE_SECURE_DISABLED" => ( !$portal_config['cookie_secure'] ) ? "checked=\"checked\"" : "",

	"L_SESSION_LENGTH" => $lang['Session_length'],
	"SESSION_LENGTH" => $portal_config['session_length'],

	"L_ALLOW_AUTOLOGIN" => $lang['Allow_autologin'],
	"L_ALLOW_AUTOLOGIN_EXPLAIN" => $lang['Allow_autologin_explain'],
	'ALLOW_AUTOLOGIN_YES' => ($portal_config['allow_autologin']) ? 'checked="checked"' : '',
	'ALLOW_AUTOLOGIN_NO' => (!$portal_config['allow_autologin']) ? 'checked="checked"' : '',

	"L_AUTOLOGIN_TIME" => $lang['Autologin_time'],
	"L_AUTOLOGIN_TIME_EXPLAIN" => $lang['Autologin_time_explain'],
	'AUTOLOGIN_TIME' => (int) $portal_config['max_autologin_time'],

	'L_MAX_LOGIN_ATTEMPTS'			=> $lang['Max_login_attempts'],
	'L_MAX_LOGIN_ATTEMPTS_EXPLAIN'	=> $lang['Max_login_attempts_explain'],
	'MAX_LOGIN_ATTEMPTS'			=> $portal_config['max_login_attempts'],

	'L_LOGIN_RESET_TIME'			=> $lang['Login_reset_time'],
	'L_LOGIN_RESET_TIME_EXPLAIN'	=> $lang['Login_reset_time_explain'],
	'LOGIN_RESET_TIME'				=> $portal_config['login_reset_time'],

	//
	// User & Styling
	//
	"L_DEFAULT_LANGUAGE" => $lang['Default_language'],
	"LANG_SELECT" => $lang_select,

	"L_DEFAULT_STYLE" => $lang['Default_style'],
	"STYLE_SELECT" => $style_select,

	"L_DEFAULT_ADMIN_STYLE" => $lang['Default_admin_style'],
	"ADMIN_STYLE_SELECT" => $style_admin_select,

	"L_OVERRIDE_STYLE" => $lang['Override_style'],
	"L_OVERRIDE_STYLE_EXPLAIN" => $lang['Override_style_explain'],
	"OVERRIDE_STYLE_YES" => ( $portal_config['override_user_style'] ) ? "checked=\"checked\"" : "",
	"OVERRIDE_STYLE_NO" => ( !$portal_config['override_user_style'] ) ? "checked=\"checked\"" : "",

	"L_OVERALL_HEADER" => $lang['Portal_Overall_header'] . "<br />" . $lang['Portal_Overall_header_explain'],
	"OVERALL_HEADER" => $portal_config['overall_header'],

	"L_OVERALL_FOOTER" => $lang['Portal_Overall_footer'] . "<br />" . $lang['Portal_Overall_footer_explain'],
	"OVERALL_FOOTER" => $portal_config['overall_footer'],

	"L_MAIN_LAYOUT" => $lang['Portal_Main_layout'] . "<br />" . $lang['Portal_Main_layout_explain'],
	"MAIN_LAYOUT" => $portal_config['main_layout'],

	"L_NAVIGATION_BLOCK" => $lang['Portal_Navigation_block'] . "<br />" . $lang['Portal_Navigation_block_explain'],
	"NAVIGATION_BLOCK" => $navigation_block_list,

	"L_TOP_PHPBB_LINKS" => $lang['Top_phpbb_links'] . "<br />" . $lang['Top_phpbb_links_explain'],
	"S_TOP_PHPBB_LINKS_YES" => ( $portal_config['top_phpbb_links'] ) ? 'checked="checked"' : '',
	"S_TOP_PHPBB_LINKS_NO" => ( !$portal_config['top_phpbb_links'] ) ? 'checked="checked"' : '',
	"TOP_PHPBB_LINKS" => $portal_config['top_phpbb_links'],

	"L_ALLOW_HTML" => $lang['Allow_HTML'],
	"HTML_YES" => ( $portal_config['allow_html'] ) ? "checked=\"checked\"" : "",
	"HTML_NO" => ( !$portal_config['allow_html'] ) ? "checked=\"checked\"" : "",

	"L_ALLOWED_TAGS" => $lang['Allowed_tags'],
	"L_ALLOWED_TAGS_EXPLAIN" => $lang['Allowed_tags_explain'],
	"HTML_TAGS" => $portal_config['allow_html_tags'],

	"L_ALLOW_BBCODE" => $lang['Allow_BBCode'],
	"BBCODE_YES" => ( $portal_config['allow_bbcode'] ) ? "checked=\"checked\"" : "",
	"BBCODE_NO" => ( !$portal_config['allow_bbcode'] ) ? "checked=\"checked\"" : "",

	"L_ALLOW_SMILIES" => $lang['Allow_smilies'],
	"SMILE_YES" => ( $portal_config['allow_smilies'] ) ? "checked=\"checked\"" : "",
	"SMILE_NO" => ( !$portal_config['allow_smilies'] ) ? "checked=\"checked\"" : "",

	"L_SMILIES_PATH" => $lang['Smilies_path'],
	"L_SMILIES_PATH_EXPLAIN" => $lang['Smilies_path_explain'],
	"SMILIES_PATH" => $portal_config['smilies_path'],

	// Email
	//
	"L_EMAIL_SETTINGS" => $lang['Email_settings'],

	"L_ADMIN_EMAIL" => $lang['Admin_email'],
	"EMAIL_FROM" => $portal_config['board_email'],

	"L_EMAIL_SIG" => $lang['Email_sig'],
	"L_EMAIL_SIG_EXPLAIN" => $lang['Email_sig_explain'],
	"EMAIL_SIG" => $portal_config['board_email_sig'],

	"L_USE_SMTP" => $lang['Use_SMTP'],
	"L_USE_SMTP_EXPLAIN" => $lang['Use_SMTP_explain'],
	"SMTP_YES" => ( $portal_config['smtp_delivery'] ) ? "checked=\"checked\"" : "",
	"SMTP_NO" => ( !$portal_config['smtp_delivery'] ) ? "checked=\"checked\"" : "",

	"L_SMTP_SERVER" => $lang['SMTP_server'],
	"SMTP_HOST" => $portal_config['smtp_host'],

	"L_SMTP_USERNAME" => $lang['SMTP_username'],
	"L_SMTP_USERNAME_EXPLAIN" => $lang['SMTP_username_explain'],
	"SMTP_USERNAME" => $portal_config['smtp_username'],

	"L_SMTP_PASSWORD" => $lang['SMTP_password'],
	"L_SMTP_PASSWORD_EXPLAIN" => $lang['SMTP_password_explain'],
	"SMTP_PASSWORD" => $portal_config['smtp_password'],

	//
	// Backend info
	//
	"L_PHPBB_INFO" => $lang['PHPBB_info'],

	"L_PHPBB_RELATIVE_PATH" => $lang['Phpbb_path'],
	"L_PHPBB_RELATIVE_PATH_EXPLAIN" => $lang['Phpbb_path_explain'],
	"PHPBB_RELATIVE_PATH" => substr( "$phpbb_root_path", 3 ),

	"L_PHPBB_SERVER_NAME" => $lang['PHPBB_server_name'],
	"PHPBB_SERVER_NAME" => $board_config['server_name'],

	"L_PHPBB_SCRIPT_PATH" => $lang['PHPBB_script_path'],
	"PHPBB_SCRIPT_PATH" => $board_config['script_path'],

	"L_PHPBB_VERSION" => $lang['PHPBB_version'],
	"PHPBB_VERSION" => $current_phpbb_version,

	"L_PORTAL_VERSION" => $lang['Portal_version'],
	"PORTAL_VERSION" => $portal_config['portal_version'],

	'PHPBB_BACKEND'	=> !(PORTAL_BACKEND === 'internal'),

));

$template->pparse('admin_portal');
include_once('page_footer_admin.' . $phpEx);
?>