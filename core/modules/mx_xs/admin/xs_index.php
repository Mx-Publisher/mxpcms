<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: xs_index.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
* @copyright (c) 2002-2007 [Vjacheslav Trushkin, OryNider] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mxbb.net
*
*/

@define('IN_PORTAL', 1);
$module_root_path = '../';
$mx_root_path = '../../../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = true;
require( $mx_root_path . 'admin/pagestart.' . $phpEx );

// check if mod is installed
if(empty($template->xs_version) || $template->xs_version !== 8)
{
	mx_message_die(GENERAL_ERROR, isset($lang['xs_error_not_installed']) ? $lang['xs_error_not_installed'] : 'eXtreme Styles module is not installed. You forgot to upload includes/template.php');
}

define('IN_XS', true);
include_once('xs_include.' . $phpEx);

if(isset($HTTP_GET_VARS['showwarning']))
{
	$msg = str_replace('{URL}', mx_append_sid('xs_index.'.$phpEx), $lang['xs_main_comment3']);
	xs_message($lang['Information'], $msg);
}

$template->assign_vars(array(
	'U_CONFIG'				=> mx_append_sid('xs_config.'.$phpEx),
	'U_DEFAULT_STYLE'		=> mx_append_sid('xs_styles.'.$phpEx),
	'U_MANAGE_CACHE'		=> mx_append_sid('xs_cache.'.$phpEx),
	'U_IMPORT_STYLES'		=> mx_append_sid('xs_import.'.$phpEx),
	'U_EXPORT_STYLES'		=> mx_append_sid('xs_export.'.$phpEx),
	'U_CLONE_STYLE'			=> mx_append_sid('xs_clone.'.$phpEx),
	'U_DOWNLOAD_STYLES'		=> mx_append_sid('xs_download.'.$phpEx),
	'U_INSTALL_STYLES'		=> mx_append_sid('xs_install.'.$phpEx),
	'U_UNINSTALL_STYLES'	=> mx_append_sid('xs_uninstall.'.$phpEx),
	'U_EDIT_STYLES'			=> mx_append_sid('xs_edit.'.$phpEx),
	'U_EDIT_STYLES_DATA'	=> mx_append_sid('xs_edit_data.'.$phpEx),
	'U_EXPORT_DATA'			=> mx_append_sid('xs_export_data.'.$phpEx),
	'U_UPDATES'				=> mx_append_sid('xs_update.'.$phpEx),
	'S_SHOW_UPDATES'		=> defined('XS_ENABLE_UPDATES') ? 1 : 0,
	));

$template->set_filenames(array('body' => XS_TPL_PATH . 'index.'.$tplEx));
$template->pparse('body');
xs_exit();

?>