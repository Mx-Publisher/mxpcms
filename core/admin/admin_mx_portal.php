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
 *    $Id: admin_mx_portal.php,v 1.3 2010/10/16 04:05:59 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

if( !empty($setmodules) )
{
	$module['1_General_admin']['1_1_Management'] = 'admin/' . basename(__FILE__);
	return;
}

//
// Security and Page header
//
define('IN_PORTAL', 1);
$mx_root_path = './../';
require($mx_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Begin program proper
//
$mode = '';

if( isset($HTTP_POST_VARS['submit']) )
{
	$mode = 'submit';
}

if( !empty($mode) )
{
	$new['portal_name'] = $mx_request_vars->post('portal_name', MX_TYPE_NO_TAGS, 'mxBB Portal and CMS');
	$new['portal_url'] = $mx_request_vars->post('portal_url', MX_TYPE_NO_TAGS, '');
	$new['portal_phpbb_url'] = $mx_request_vars->post('portal_phpbb_url', MX_TYPE_NO_TAGS, '');
	$new['top_phpbb_links'] = $mx_request_vars->post('top_phpbb_links', MX_TYPE_INT, '0');
	$new['mx_use_cache'] = $mx_request_vars->post('mx_use_cache', MX_TYPE_INT, '1');
	$new['mod_rewrite'] = $mx_request_vars->post('mod_rewrite', MX_TYPE_INT, '0');

	$sql = "UPDATE " . PORTAL_TABLE . "
		SET portal_name		= '" . str_replace("\'", "''", $new['portal_name']) . "',
			portal_url		= '" . str_replace("\'", "''", $new['portal_url']) . "',
			portal_phpbb_url= '" . str_replace("\'", "''", $new['portal_phpbb_url']) . "',
			top_phpbb_links	= '" . str_replace("\'", "''", $new['top_phpbb_links']) . "',
			mx_use_cache	= '" . str_replace("\'", "''", $new['mx_use_cache']) . "',
			mod_rewrite	= '" . str_replace("\'", "''", $new['mod_rewrite']) . "'";

	if( !($db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Failed to update portal configuration ", "", __LINE__, __FILE__, $sql);
	}
	
	$mx_config_cache->put( 'config', $new );	
	$mx_config_cache->unload();
	
	$message = $lang['Portal_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_portal_config'], "<a href=\"" . mx_append_sid("admin_mx_portal.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");
	mx_message_die(GENERAL_MESSAGE, $message);
}

$template->set_filenames(array(
	'admin_portal' => 'admin/admin_mx_portal.tpl')
);

$top_phpbb_links_yes = ( $portal_config['top_phpbb_links'] == 1 ) ? 'checked="checked"' : '';
$top_phpbb_links_no = ( $portal_config['top_phpbb_links'] == 0 ) ? 'checked="checked"' : '';

$mx_use_cache_yes = ( $portal_config['mx_use_cache'] == 1 ) ? 'checked="checked"' : '';
$mx_use_cache_no = ( $portal_config['mx_use_cache'] == 0 ) ? 'checked="checked"' : '';

$mx_mod_rewrite_yes = ( $portal_config['mod_rewrite'] == 1 ) ? 'checked="checked"' : '';
$mx_mod_rewrite_no = ( $portal_config['mod_rewrite'] == 0 ) ? 'checked="checked"' : '';

$phpbb_rel_path = substr( "$phpbb_root_path", 3 );

$portal_version = $portal_config['portal_version'];

$phpbb_version = '2' . $board_config['version'];
$phpbb_script_path = $board_config['script_path'];
$phpbb_server_name = $board_config['server_name'];

$template->assign_vars(array(
	"S_CONFIG_ACTION" => mx_append_sid("admin_mx_portal.$phpEx"),

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],

	"L_CONFIGURATION_TITLE" => $lang['Portal_General_Config'],
	"L_CONFIGURATION_EXPLAIN" => $lang['Portal_Config_explain'],
	"L_GENERAL_SETTINGS" => $lang['Portal_General_settings'],
	"L_GENERAL_CONFIG_INFO" => $lang['Portal_General_config_info'] . "<br />" . $lang['Portal_General_config_info_explain'],

	"L_PORTAL_NAME" => $lang['Portal_Name'],
	"L_PORTAL_URL" => $lang['Portal_Url'] . "<br />" . $lang['Portal_url_explain'],
	"L_PORTAL_PHPBB_URL" => $lang['Portal_PHPBB_Url'] . "<br />" . $lang['Phpbb_url_explain'],
	"L_SUBMIT" => $lang['Submit'],
	"L_RESET" => $lang['Reset'],

	"PORTAL_NAME" => $portal_config['portal_name'],
	"PORTAL_URL" => $portal_config['portal_url'],
	"PORTAL_PHPBB_URL" => $portal_config['portal_phpbb_url'],
	
	// Added in v 2.706
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

	"L_TOP_PHPBB_LINKS" => $lang['Top_phpbb_links'],
	"S_TOP_PHPBB_LINKS_YES" => $top_phpbb_links_yes,
	"S_TOP_PHPBB_LINKS_NO" => $top_phpbb_links_no,
	"TOP_PHPBB_LINKS" => $portal_config['top_phpbb_links'],

	"L_MX_USE_CACHE" => $lang['Mx_use_cache'],
	"L_MX_USE_CACHE_EXPLAIN" => $lang['Mx_use_cache_explain'],
	"S_MX_USE_CACHE_YES" => $mx_use_cache_yes,
	"S_MX_USE_CACHE_NO" => $mx_use_cache_no,
	"MX_USE_CACHE" => $portal_config['mx_use_cache'],
	
	"L_MX_MOD_REWRITE" => $lang['Mx_mod_rewrite'],
	"L_MX_MOD_REWRITE_EXPLAIN" => $lang['Mx_mod_rewrite_explain'],
	"S_MX_MOD_REWRITE_YES" => $mx_mod_rewrite_yes,
	"S_MX_MOD_REWRITE_NO" => $mx_mod_rewrite_no,
	"MX_MOD_REWRITE" => $portal_config['mod_rewrite']	
));

$template->pparse('admin_portal');

include_once('page_footer_admin.' . $phpEx);

?>