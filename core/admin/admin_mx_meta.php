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
 *    $Id: admin_mx_meta.php,v 1.4 2011/03/30 13:34:09 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

if( !empty($setmodules) )
{
	$module['4_Panel_system']['4_1_Meta'] = 'admin/' . basename(__FILE__);
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
// Load language file.
//
if( @file_exists($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_meta.' . $phpEx) )
{
	include($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_meta.' . $phpEx);
}
else
{
	include($mx_root_path . 'language/lang_english/lang_meta.' . $phpEx);
}

//
// Main procedure
//
if( $mx_request_vars->is_post('submit') )
{
	//
	// MX_TYPE_NO_TAGS : Because this information is to be part of the HTML output (overall_header).
	// MX_TYPE_NO_STRIP: Because we need quoted slashes to dynamically build the mx_meta.inc as valid PHP code.
	//
	$title			= $mx_request_vars->post('title', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');
	$author			= $mx_request_vars->post('author', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');
	$copyright		= $mx_request_vars->post('copyright', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');
	$keywords		= $mx_request_vars->post('keywords', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');
	$description	= $mx_request_vars->post('description', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');
	$langcode		= $mx_request_vars->post('langcode', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');
	$rating			= $mx_request_vars->post('rating', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');
	$index			= $mx_request_vars->post('index', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');
	$follow			= $mx_request_vars->post('follow', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');
	$pragma			= $mx_request_vars->post('pragma', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');
	$icon			= $mx_request_vars->post('icon', (MX_TYPE_NO_TAGS | MX_TYPE_NO_STRIP), '');

	//
	// Note we need to allow HTML Tags for the Extra Meta Settings!!!
	//
	$header			= $mx_request_vars->post('header', (MX_TYPE_NO_STRIP), '');

	$config_data = '<?php';
	$config_data .= "\n" . ' $title       = "' . $title . '";';
	$config_data .= "\n" . ' $author      = "' . $author . '";';
	$config_data .= "\n" . ' $copyright   = "' . $copyright . '";';
	$config_data .= "\n" . ' $keywords    = "' . $keywords . '";';
	$config_data .= "\n" . ' $description = "' . $description . '";';
	$config_data .= "\n" . ' $langcode    = "' . $langcode . '";';
	$config_data .= "\n" . ' $rating      = "' . $rating . '";';
	$config_data .= "\n" . ' $index       = "' . $index . '";';
	$config_data .= "\n" . ' $follow      = "' . $follow . '";';
	$config_data .= "\n" . ' $pragma      = "' . $pragma . '";';
	$config_data .= "\n" . ' $icon        = "' . $icon . '";';
	$config_data .= "\n" . ' $header      = "' . str_replace("\"", "\\\"", $header) . '";';
	$config_data .= "\n" . '?>';	// Done this to prevent highlighting editors getting confused!	

	//
	// Write out the config file.
	//
	@umask(0111);
	$fp = @fopen($mx_root_path . 'mx_meta.inc', 'w');

	//
	// check if the file was writable
	//
	if( !$fp )
	{
		mx_message_die(GENERAL_ERROR, $lang['Meta_data_ioerror']);
	}
	$result = @fputs($fp, $config_data, strlen($config_data));
	@fclose($fp);

	//
	// display a message that the meta file has been updated
	//
	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid(PORTAL_URL . "admin/admin_mx_meta.$phpEx") . '">'
	));

	$message = sprintf($lang['Meta_data_updated'], '<a href="' . append_sid(PORTAL_URL . "admin/admin_mx_meta.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid(PORTAL_URL . "admin/index.$phpEx?pane=right") . '">', '</a>');
	mx_message_die(GENERAL_MESSAGE, $message);
}

//
// Read current settings and send result to browser
//
include($mx_root_path . 'mx_meta.inc');

$template->set_filenames(array( 'meta' => 'admin/admin_mx_meta.tpl') );

$template->assign_vars(array(
	'S_CONFIG_ACTION'			=> mx_append_sid("admin_mx_meta.$phpEx"),
	'L_CONFIGURATION_TITLE'		=> $lang['Meta_admin'],
	'L_CONFIGURATION_EXPLAIN'	=> $lang['Mega_admin_explain'],
	'L_SUBMIT'					=> $lang['Submit'],
	'L_RESET'					=> $lang['Reset'],
	'L_TITLE'					=> $lang['Meta_Title'],
	'L_AUTHOR'					=> $lang['Meta_Author'],
	'L_COPYRIGHT'				=> $lang['Meta_Copyright'],
	'L_KEYWORDS'				=> $lang['Meta_Keywords'],
	'L_KEYWORDS_EXPLAIN'		=> $lang['Meta_Keywords_explain'],
	'L_DESCRIPTION'				=> $lang['Meta_Description'],
	'L_LANGUAGE'				=> $lang['Meta_Language'],
	'L_RATING'					=> $lang['Meta_Rating'],
	'L_ROBOTS'					=> $lang['Meta_Robots'],
	'L_PRAGMA'					=> $lang['Meta_Pragma'],
	'L_BOOKMARK'				=> $lang['Meta_Bookmark_icon'],
	'L_BOOKMARK_EXPLAIN'		=> $lang['Meta_Bookmark_explain'],
	'L_HTITLE'					=> $lang['Meta_HTITLE'],

	'TITLE'						=> $title,
	'AUTHOR'					=> $author,
	'COPYRIGHT'					=> $copyright,
	'KEYWORDS'					=> $keywords,
	'DESCRIPTION'				=> $description,
	'LANGUAGE'					=> mx_generate_meta_select($langcode, 'langcode'),
	'RATING'					=> mx_generate_meta_select($rating, 'rating'),
	'ROBOTS_INDEX'				=> mx_generate_meta_select($index, 'index'),
	'ROBOTS_FOLLOW'				=> mx_generate_meta_select($follow, 'follow'),
	'ICON'						=> $icon,
	'HEADER'					=> htmlspecialchars($header),
	'PRAGMA'					=> ( $pragma == 1 ) ? ' checked="checked"' : '',
));

include("./page_header_admin.$phpEx");
$template->pparse('meta');
include("./page_footer_admin.$phpEx");

// ========================================
// FUNCTIONS
// ========================================

function generate_meta_select($default, $select_name)
{
	global $lang;

	$select = '<select name="' . $select_name . '">';
	foreach( $lang['mx_meta'][$select_name] as $key => $value )
	{
		$selected = ( $key == $default ) ? ' selected="selected"' : '';
		$select .= '<option value="' . $key . '"' . $selected . '>' . $value . "</option>\n";
	}
	$select .= '</select>';

	return $select;
}

?>