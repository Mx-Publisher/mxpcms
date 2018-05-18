<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: xs_frameset.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
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

//if(!empty ($setmodules))
//{
//	$filename = basename(__FILE__);
//	$module['eXtreme_Sytles']['Menu'] = 'modules/mx_xs/admin/' . $filename;
//	return;
//}


// check if mod is installed
if(empty($template->xs_version) || $template->xs_version !== 8)
{
	mx_message_die(GENERAL_ERROR, isset($lang['xs_error_not_installed']) ? $lang['xs_error_not_installed'] : 'eXtreme Styles module is not installed. You forgot to upload includes/template.php');
}

define('IN_XS', true);
define('NO_XS_HEADER', true);
include_once('xs_include.' . $phpEx);

$action = isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '';
$get_data = array();
foreach($HTTP_GET_VARS as $var => $value)
{
	if($var !== 'action' && $var !== 'sid')
	{
		$get_data[] = $var . '=' . urlencode(stripslashes($value));
	}
}

// check for style download command
if(isset($HTTP_POST_VARS['action']) && $HTTP_POST_VARS['action'] === 'web')
{
	$action = 'import';
	$get_data[] = 'get_remote=' . urlencode(stripslashes($HTTP_POST_VARS['source']));
	if(isset($HTTP_POST_VARS['return']))
	{
		$get_data[] = 'return=' . urlencode(stripslashes($HTTP_POST_VARS['return']));
	}
}

$get_data = count($get_data) ? $phpEx . '?' . implode('&', $get_data) : $phpEx;

$content_url = array(
	'config'		=> mx_append_sid('xs_config.'.$get_data),
	'install'		=> mx_append_sid('xs_install.'.$get_data),
	'uninstall'		=> mx_append_sid('xs_uninstall.'.$get_data),
	'default'		=> mx_append_sid('xs_styles.'.$get_data),
	'cache'			=> mx_append_sid('xs_cache.'.$get_data),
	'import'		=> mx_append_sid('xs_import.'.$get_data),
	'export'		=> mx_append_sid('xs_export.'.$get_data),
	'clone'			=> mx_append_sid('xs_clone.'.$get_data),
	'download'		=> mx_append_sid('xs_download.'.$get_data),
	'edittpl'		=> mx_append_sid('xs_edit.'.$get_data),
	'editdb'		=> mx_append_sid('xs_edit_data.'.$get_data),
	'exportdb'		=> mx_append_sid('xs_export_data.'.$get_data),
	'updates'		=> mx_append_sid('xs_update.'.$get_data),
	'portal'		=> mx_append_sid('xs_portal.'.$get_data),
	'style_config'	=> mx_append_sid('xs_style_config.'.$get_data),
	);

if(isset($content_url[$action]))
{
	$content = $content_url[$action];
}
else
{
	$content = mx_append_sid('xs_index.'.$get_data);
}

$template->set_filenames(array('body' => XS_TPL_PATH . 'frameset.tpl'));

$template->assign_vars(array(
	'FRAME_TOP'		=> mx_append_sid('xs_frame_top.'.$phpEx),
	'FRAME_MAIN'	=> $content,
	));

$template->pparse('body');
xs_exit();

?>