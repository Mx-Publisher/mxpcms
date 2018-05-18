<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: xs_config.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
* @copyright (c) 2002-2007 [Vjacheslav Trushkin, OryNider] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mxbb.net
*
*/


@define ('IN_PORTAL', 1);
/*
if(!empty ($setmodules))
{
	$filename = basename(__FILE__);
	$module['eXtreme_Sytles']['Config'] = 'modules/mx_xs/admin/' . $filename;
	return;
}
*/

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

$lang['xs_config_updated_explain'] = str_replace('{URL}', mx_append_sid('xs_config.'.$phpEx), $lang['xs_config_updated_explain']);
$lang['xs_config_title'] = str_replace('{VERSION}', $template->xs_versiontxt, $lang['xs_config_title']);
$lang['xs_config_warning_explain'] = str_replace('{URL}', mx_append_sid('xs_chmod.'.$phpEx), $lang['xs_config_warning_explain']);
$lang['xs_config_back'] = str_replace('{URL}', mx_append_sid('xs_config.'.$phpEx), $lang['xs_config_back']);

//
// Updating configuration
//
if(isset($HTTP_POST_VARS['submit']) && !defined('DEMO_MODE'))
{
	$vars = array('xs_use_cache', 'xs_auto_compile', 'xs_auto_recompile', 'xs_php', 'xs_def_template', 'xs_check_switches', 'xs_warn_includes', 'xs_add_comments', 'xs_ftp_host', 'xs_ftp_login', 'xs_ftp_path', 'xs_shownav');
	// checking navigation config
	$shownav = 0;
	for($i=0; $i<XS_SHOWNAV_MAX; $i++)
	{
		$num = pow(2, $i);
		if($i != XS_SHOWNAV_DOWNLOAD && !empty($HTTP_POST_VARS['shownav_' . $i])) // downloads feature is disabled
		{
			$shownav += $num;
		}
	}
	if($shownav !== $board_config['xs_shownav'])
	{
		$template->assign_block_vars('left_refresh', array(
				'ACTION'	=> mx_append_sid('index.' . $phpEx . '?pane=left')
			));
	}
	$HTTP_POST_VARS['xs_shownav'] = $shownav;
	// checking submitted data
	$update_time = false;
	foreach($vars as $var)
	{
		$new[$var] = stripslashes(trim($HTTP_POST_VARS[$var]));
		if(($var == 'xs_auto_recompile') && !$new['xs_auto_compile'])
		{
			$new[$var] = 0;
		}
		if($board_config[$var] !== $new[$var])
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . xs_sql($new[$var]) . "' WHERE config_name = '{$var}'";
			if( !$db->sql_query($sql) )
			{
				xs_error(str_replace('{VAR}', $var, $lang['xs_config_sql_error']) . '<br /><br />' . $lang['xs_config_back'], __LINE__, __FILE__);
			}
			$board_config[$var] = $new[$var];
			if($var === 'xs_check_switches')
			{
				$update_time = true;
			}
		}
	}
	if($update_time)
	{
		$board_config['xs_template_time'] = time() + 10; // set time 10 seconds in future in case if some tpl file would be compiled right now with current settings
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . $board_config['xs_template_time'] . "' WHERE config_name = 'xs_template_time'";
		if( !$db->sql_query($sql) )
		{
			xs_error(str_replace('{VAR}', 'xs_template_time', $lang['xs_config_sql_error']) . '<br /><br />' . $lang['xs_config_back'], __LINE__, __FILE__);
		}
	}
	// update config cache
	if(defined('XS_MODS_CATEGORY_HIERARCHY210'))
	{
		if ( !empty($config) )
		{
			$config->read(true);
		}
	}
	$template->assign_block_vars('switch_updated', array());
	$template->load_config($template->root, false);
}

// check ftp configuration
$xs_ftp_host = $board_config['xs_ftp_host'];
if(empty($xs_ftp_host) && !empty($HTTP_SERVER_VARS['HTTP_HOST']))
{
	$str = $HTTP_SERVER_VARS['HTTP_HOST'];
	$template->assign_vars(array(
		'HOST_GUESS' => str_replace(array('{HOST}', '{CLICK}'), array($str, 'document.config.xs_ftp_host.value=\''.$str.'\''), $lang['xs_ftp_host_guess'])
		));
}
$dir = getcwd();
$xs_ftp_login = $board_config['xs_ftp_login'];
if(empty($xs_ftp_login))
{
	if(substr($dir, 0, 6) === '/home/')
	{
		$str = substr($dir, 6);
		$pos = strpos($str, '/');
		if($pos)
		{
			$str = substr($str, 0, $pos);
			$template->assign_vars(array(
				'LOGIN_GUESS' => str_replace(array('{LOGIN}', '{CLICK}'), array($str, 'document.config.xs_ftp_login.value=\''.$str.'\''), $lang['xs_ftp_login_guess'])
			));
		}
	}
}
$xs_ftp_path = $board_config['xs_ftp_path'];
if(empty($xs_ftp_path))
{
	if(substr($dir, 0, 6) === '/home/');
	$str = substr($dir, 6);
	$pos = strpos($str, '/');
	if($pos)
	{
		$str = substr($str, $pos + 1);
		$pos = strrpos($str, 'admin');
		if($pos)
		{
			$str = substr($str, 0, $pos-1);
			$template->assign_vars(array(
				'PATH_GUESS' => str_replace(array('{PATH}', '{CLICK}'), array($str, 'document.config.xs_ftp_path.value=\''.$str.'\''), $lang['xs_ftp_path_guess'])
				));
		}
	}
}

$template->assign_vars(array(
	'XS_USE_CACHE_0'			=> $board_config['xs_use_cache'] ? '' : ' checked="checked"',
	'XS_USE_CACHE_1'			=> $board_config['xs_use_cache'] ? ' checked="checked"' : '',
	'XS_AUTO_COMPILE_0'			=> $board_config['xs_auto_compile'] ? '' : ' checked="checked"',
	'XS_AUTO_COMPILE_1'			=> $board_config['xs_auto_compile'] ? ' checked="checked"' : '',
	'XS_AUTO_RECOMPILE_0'		=> $board_config['xs_auto_recompile'] ? '' : ' checked="checked"',
	'XS_AUTO_RECOMPILE_1'		=> $board_config['xs_auto_recompile'] ? ' checked="checked"' : '',
	'XS_PHP'					=> htmlspecialchars($board_config['xs_php']),
	'XS_DEF_TEMPLATE'			=> htmlspecialchars($board_config['xs_def_template']),
	'XS_CHECK_SWITCHES_0'		=> !$board_config['xs_check_switches'] ? ' checked="checked"' : '', // no check
	'XS_CHECK_SWITCHES_1'		=> $board_config['xs_check_switches'] == 1 ? ' checked="checked"' : '', // smart check
	'XS_CHECK_SWITCHES_2'		=> $board_config['xs_check_switches'] == 2 ? ' checked="checked"' : '', // simple check
	'XS_WARN_INCLUDES_0'		=> $board_config['xs_warn_includes'] ? '' : ' checked="checked"',
	'XS_WARN_INCLUDES_1'		=> $board_config['xs_warn_includes'] ? ' checked="checked"' : '',
	'XS_ADD_COMMENTS_0'			=> $board_config['xs_add_comments'] ? '' : ' checked="checked"',
	'XS_ADD_COMMENTS_1'			=> $board_config['xs_add_comments'] ? ' checked="checked"' : '',
	'XS_FTP_HOST'				=> defined('DEMO_MODE') ? '' : $xs_ftp_host,
	'XS_FTP_LOGIN'				=> defined('DEMO_MODE') ? '' : $xs_ftp_login,
	'XS_FTP_PATH'				=> defined('DEMO_MODE') ? '' : $xs_ftp_path,
	'FORM_ACTION'				=> mx_append_sid('xs_config.' . $phpEx),
	));

for($i=0; $i<XS_SHOWNAV_MAX; $i++)
{
	$num = pow(2, $i);
	if($i != XS_SHOWNAV_DOWNLOAD) // downloads feature is disabled
	{
		$template->assign_block_vars('shownav', array(
			'NUM'		=> $i,
			'LABEL'		=> $lang['xs_config_shownav'][$i],
			'CHECKED'	=> (($board_config['xs_shownav'] & $num) > 0) ? 'checked="checked"' : ''
			));
	}
}

// test cache
$tpl_filename = $template->make_filename('_xs_test.tpl');
$cache_filename = $template->make_filename_cache($tpl_filename);
$str = '';
if(!xs_check_cache($cache_filename))
{
	$template->assign_block_vars('switch_xs_warning', array());
}
@unlink($cache_filename);
$debug_data = $str;
$template->assign_vars(array(
					'XS_DEBUG_HDR1'			=> sprintf($lang['xs_check_hdr'], '_xs_test.tpl'),
					'XS_DEBUG_FILENAME1'	=> $tpl_filename,
					'XS_DEBUG_FILENAME2'	=> $cache_filename,
					'XS_DEBUG_DATA'			=> $debug_data,
					));

$template->set_filenames(array('body' => XS_TPL_PATH . 'config.tpl'));
$template->pparse('body');
xs_exit();

?>