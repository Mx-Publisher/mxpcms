<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: xs_chmod.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
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

$template->assign_block_vars('nav_left',array('ITEM' => '&raquo; <a href="' . mx_append_sid('xs_config.'.$phpEx) . '">' . $lang['xs_configuration'] . '</a>'));
$template->assign_block_vars('nav_left',array('ITEM' => '&raquo; <a href="' . mx_append_sid('xs_chmod.'.$phpEx) . '">' . $lang['xs_chmod'] . '</a>'));

$lang['xs_chmod_return'] = str_replace('{URL}', mx_append_sid('xs_config.'.$phpEx), $lang['xs_chmod_return']);
$lang['xs_chmod_message1'] .= $lang['xs_chmod_return'];
$lang['xs_chmod_error1'] .= $lang['xs_chmod_return'];

if(defined('DEMO_MODE'))
{
	xs_error($lang['xs_permission_denied']);
}

if(!get_ftp_config(mx_append_sid('xs_chmod.'.$phpEx), array(), false))
{
	exit;
}
xs_ftp_connect(mx_append_sid('xs_chmod.'.$phpEx), array(), true);

if($ftp === XS_FTP_LOCAL)
{
	@mkdir('../../cache', 0777);
	@chmod('../../cache', 0777);
	if(xs_dir_writable('../../cache'))
	{
		xs_message($lang['Information'], $lang['xs_chmod_message1']);
	}
	xs_error($lang['xs_chmod_error1']);
}

$str = ftp_pwd($ftp);

if(strlen($str) && substr($str, strlen($str) - 1) !== '/')
{
	$str .= '/';
}
$res = @ftp_site($ftp, "CHMOD 0777 {$str}cache");
if(!$res)
{
	@ftp_mkdir($ftp, 'cache');
	$res = @ftp_site($ftp, "CHMOD 0777 {$str}cache");
}
@ftp_quit($ftp);
if($res)
{
	xs_message($lang['Information'], $lang['xs_chmod_message1']);
}
else
{
	xs_error($lang['xs_chmod_error1']);
}

?>