<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: xs_download.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
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

$template->assign_block_vars('nav_left',array('ITEM' => '&raquo; <a href="' . mx_append_sid('xs_import.'.$phpEx) . '">' . $lang['xs_import_styles'] . '</a>'));
$template->assign_block_vars('nav_left',array('ITEM' => '&raquo; <a href="' . mx_append_sid('xs_download.'.$phpEx) . '">' . $lang['xs_download_styles'] . '</a>'));

// submit url
if(isset($HTTP_GET_VARS['url']) && !defined('DEMO_MODE'))
{
	$id = intval($HTTP_GET_VARS['url']);
	$var = 'xs_downloads_' . $id;
	$import_data = array(
		'host'		=> $HTTP_SERVER_VARS['HTTP_HOST'],
		'port'		=> $HTTP_SERVER_VARS['SERVER_PORT'],
		'url'		=> str_replace('xs_download.', 'xs_frameset.', $HTTP_SERVER_VARS['PHP_SELF']),
		'session'	=> $userdata['session_id'],
		'xs'		=> $template->xs_versiontxt,
		'style'		=> STYLE_HEADER_VERSION,
	);
	$str = '<form action="' . $board_config[$var] . '" method="post" style="display: inline;" target="main"><input type="hidden" name="data" value="' . htmlspecialchars(serialize($import_data)) . '" /><input type="submit" value="' . $lang['xs_continue'] . '" class="post" /></form>';
	$message = $lang['xs_import_download_warning'] . '<br /><br />' . $str . '<br /><br />' . str_replace('{URL}', mx_append_sid('xs_download.'.$phpEx), $lang['xs_download_back']);
	xs_message($lang['Information'], $message);
}


if(isset($HTTP_GET_VARS['edit']))
{
	$id = intval($HTTP_GET_VARS['edit']);
	$template->assign_block_vars('edit', array(
		'ID'		=> $id,
		'TITLE'		=> $board_config['xs_downloads_title_'.$id],
		'URL'		=> $board_config['xs_downloads_'.$id]
		));
}

if(isset($HTTP_POST_VARS['edit']) && !defined('DEMO_MODE'))
{
	$id = intval($HTTP_POST_VARS['edit']);
	$update = array();
	if(!empty($HTTP_POST_VARS['edit_delete']))
	{
		// delete link
		$total = $board_config['xs_downloads_count'];
		$update['xs_downloads_count'] = $total - 1;
		for($i=$id; $i<($total-1); $i++)
		{
			$update['xs_downloads_'.$i] = $update['xs_downloads_'.($i+1)];
			$update['xs_downloads_title_'.$i] = $update['xs_downloads_title_'.($i+1)];
		}
		$update['xs_downloads_'.($total-1)] = '';
		$update['xs_downloads_title_'.($total-1)] = '';
	}
	else
	{
		$update['xs_downloads_'.$id] = stripslashes($HTTP_POST_VARS['edit_url']);
		$update['xs_downloads_title_'.$id] = stripslashes($HTTP_POST_VARS['edit_title']);
	}
	foreach($update as $var => $value)
	{
		if(isset($board_config[$var]))
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET config_value='" . xs_sql($value) . "' WHERE config_name='" . $var . "'";
		}
		else
		{
			$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('" . $var . "', '" . xs_sql($value) . "')";
		}
		$db->sql_query($sql);
		$board_config[$var] = $value;
	}
	// update config cache
	if(defined('XS_MODS_CATEGORY_HIERARCHY210'))
	{
		if(!empty($config))
		{
			$config->read(true);
		}
	}
}

if(!empty($HTTP_POST_VARS['add_url']) && !defined('DEMO_MODE'))
{
	$id = $board_config['xs_downloads_count'];
	$update = array();
	$update['xs_downloads_'.$id] = stripslashes($HTTP_POST_VARS['add_url']);
	$update['xs_downloads_title_'.$id] = stripslashes($HTTP_POST_VARS['add_title']);
	$update['xs_downloads_count'] = $board_config['xs_downloads_count'] + 1;
	foreach($update as $var => $value)
	{
		if(isset($board_config[$var]))
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET config_value='" . xs_sql($value) . "' WHERE config_name='" . $var . "'";
		}
		else
		{
			$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('" . $var . "', '" . xs_sql($value) . "')";
		}
		$db->sql_query($sql);
		$board_config[$var] = $value;
	}
	// update config cache
	if( defined('XS_MODS_CATEGORY_HIERARCHY210') && !empty($config) )
	{
		$config->read(true);
	}
}

for($i=0; $i<$board_config['xs_downloads_count']; $i++)
{
	$row_class = $xs_row_class[$i % 2];
	$template->assign_block_vars('url', array(
		'ROW_CLASS'		=> $row_class,
		'NUM'			=> $i,
		'NUM1'			=> $i + 1,
		'URL'			=> htmlspecialchars($board_config['xs_downloads_'.$i]),
		'TITLE'			=> htmlspecialchars($board_config['xs_downloads_title_'.$i]),
		'U_DOWNLOAD'	=> mx_append_sid('xs_download.'.$phpEx.'?url='.$i),
		'U_EDIT'		=> mx_append_sid('xs_download.'.$phpEx.'?edit='.$i),
		));
}

$template->assign_vars(array(
	'U_POST'		=> mx_append_sid('xs_download.'.$phpEx)
	));

$template->set_filenames(array('body' => XS_TPL_PATH . 'downloads.'.$tplEx));
$template->pparse('body');
xs_exit();

?>