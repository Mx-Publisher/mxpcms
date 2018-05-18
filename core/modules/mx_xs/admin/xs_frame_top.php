<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: xs_frame_top.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
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

define('IN_XS', true);
define('NO_XS_HEADER', true);
include_once('xs_include.' . $phpEx);

$template->set_filenames(array('body' => XS_TPL_PATH . 'frame_top.'.$tplEx));

$template->assign_block_vars('left_nav', array(
	'URL'	=> mx_append_sid('xs_index.'.$phpEx),
	'TEXT'	=> $lang['xs_menu_lc']
	));
/* $template->assign_block_vars('left_nav', array(
	'URL'	=> mx_append_sid('xs_download.'.$phpEx),
	'TEXT'	=> $lang['xs_download_styles_lc']
	)); */
$template->assign_block_vars('left_nav', array(
	'URL'	=> mx_append_sid('xs_styles.'.$phpEx),
	'TEXT'	=> $lang['xs_set_default_style_lc']
	));
$template->assign_block_vars('left_nav', array(
	'URL'	=> mx_append_sid('xs_import.'.$phpEx),
	'TEXT'	=> $lang['xs_import_styles_lc']
	));
$template->assign_block_vars('left_nav', array(
	'URL'	=> mx_append_sid('xs_install.'.$phpEx),
	'TEXT'	=> $lang['xs_install_styles_lc']
	));
$template->assign_block_vars('left_nav', array(
	'URL'	=> 'http://www.stsoftware.biz/forum',
	'TEXT'	=> $lang['xs_support_forum_lc']
	));


$template->pparse('body');
xs_exit();

?>