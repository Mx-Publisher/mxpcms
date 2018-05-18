<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: xs_uninstall.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
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

$template->assign_block_vars('nav_left',array('ITEM' => '&raquo; <a href="' . mx_append_sid('xs_uninstall.'.$phpEx) . '">' . $lang['xs_uninstall_styles'] . '</a>'));

$lang['xs_uninstall_back'] = str_replace('{URL}', mx_append_sid('xs_uninstall.'.$phpEx), $lang['xs_uninstall_back']);
$lang['xs_goto_default'] = str_replace('{URL}', mx_append_sid('xs_styles.'.$phpEx), $lang['xs_goto_default']);

//
// uninstall style
//
if(isset($HTTP_GET_VARS['remove']) && !defined('DEMO_MODE'))
{
	$remove_id = intval($HTTP_GET_VARS['remove']);
	if($board_config['default_style'] == $remove_id)
	{
		xs_error(str_replace('{URL}', mx_append_sid('xs_styles.'.$phpEx), $lang['xs_uninstall_default']) . '<br /><br />' . $lang['xs_uninstall_back']);
	}
	$sql = "SELECT themes_id, template_name, style_name FROM " . THEMES_TABLE . " WHERE themes_id='{$remove_id}'";
	if(!$result = $db->sql_query($sql))
	{
		xs_error($lang['xs_no_style_info'] . '<br /><br />' . $lang['xs_uninstall_back'], __LINE__, __FILE__);
	}
	$row = $db->sql_fetchrow($result);
	if(empty($row['themes_id']))
	{
		xs_error($lang['xs_no_style_info'] . '<br /><br />' . $lang['xs_uninstall_back'], __LINE__, __FILE__);
	}
	$sql = "UPDATE " . USERS_TABLE . " SET user_style=NULL WHERE user_style='{$remove_id}'";
	$db->sql_query($sql);
	$sql = "DELETE FROM " . THEMES_TABLE . " WHERE themes_id='{$remove_id}'";
	$db->sql_query($sql);
	$template->assign_block_vars('removed', array());
	// remove files
	if(!empty($HTTP_GET_VARS['dir']))
	{
		$HTTP_POST_VARS['remove'] = addslashes($row['template_name']);
	}
	// remove config
	if(empty($HTTP_GET_VARS['nocfg']) && isset($board_config['xs_style_'.$row['template_name']]))
	{
		$sql = "DELETE FROM " . CONFIG_TABLE . " WHERE config_name='" . addslashes("xs_style_{$row['template_name']}") . "'";
		$db->sql_query($sql);
		$template->assign_block_vars('left_refresh', array(
				'ACTION'	=> mx_append_sid('index.' . $phpEx . '?pane=left')
			));
		// recache config table for cat_hierarchy 2.1.0
		if(isset($GLOBALS['config']) && is_object($GLOBALS['config']))
		{
			global $config;
			$config->read(true);
		}
	}
	// recache themes table
	if(defined('XS_MODS_CATEGORY_HIERARCHY210'))
	{
		if ( empty($themes) )
		{
			$themes = new themes();
		}
		if ( !empty($themes) )
		{
			$themes->read(true);
		}
	}
}

function remove_all($dir)
{
	$res = opendir($dir);
	if(!$res)
	{
		return false;
	}
	while(($file = readdir($res)) !== false)
	{
		if($file !== '.' && $file !== '..')
		{
			$str = $dir . '/' . $file;
			if(is_dir($str))
			{
				remove_all($str);
				@rmdir($str);
			}
			else
			{
				@unlink($str);
			}
		}
	}
	closedir($res);
}

//
// remove files
//
if(isset($HTTP_POST_VARS['remove']) && !defined('DEMO_MODE'))
{
	$remove = stripslashes($HTTP_POST_VARS['remove']);
	$params = array('remove' => $remove);
	if(!get_ftp_config(mx_append_sid('xs_uninstall.'.$phpEx), $params, true))
	{
		xs_exit();
	}
	xs_ftp_connect(mx_append_sid('xs_uninstall.'.$phpEx), $params, true);
	$write_local = false;
	if($ftp === XS_FTP_LOCAL)
	{
		$write_local = true;
		$write_local_dir = $mx_root_path . 'templates/';
	}
	if(!$write_local)
	{
		//
		// Generate actions list
		//
		$actions = array();
		// chdir to templates directory
		$actions[] = array(
				'command'	=> 'chdir',
				'dir'		=> 'templates'
			);
		// chdir to template
		$actions[] = array(
				'command'	=> 'chdir',
				'dir'		=> $remove
			);
		// remove all files
		$actions[] = array(
				'command'	=> 'removeall',
				'ignore'	=> true
			);
		$actions[] = array(
				'command'	=> 'cdup'
			);
		$actions[] = array(
				'command'	=> 'rmdir',
				'dir'		=> $remove
			);
		$ftp_log = array();
		$ftp_error = '';
		$res = ftp_myexec($actions);
/*		echo "<!--\n\n";
		echo "\$actions dump:\n\n";
		print_r($actions);
		echo "\n\n\$ftp_log dump:\n\n";
		print_r($ftp_log);
		echo "\n\n -->"; */
	}
	else
	{
		remove_all($mx_root_path . 'templates/'.$remove);
		@rmdir($mx_root_path . 'templates/'.$remove);
	}
	$template->assign_block_vars('removed', array());
}



//
// get list of installed styles
//
$sql = 'SELECT themes_id, template_name, style_name FROM ' . THEMES_TABLE . ' ORDER BY template_name, style_name';
if(!$result = $db->sql_query($sql))
{
	xs_error($lang['xs_no_style_info'], __LINE__, __FILE__);
}
$style_rowset = $db->sql_fetchrowset($result);

$tpl = array();
for($i=0; $i<count($style_rowset); $i++)
{
	$item = $style_rowset[$i];
	$tpl[$item['template_name']][] = $item;
}

$j = 0;
foreach($tpl as $tpl => $styles)
{
	$row_class = $xs_row_class[$j % 2];
	$j++;
	$template->assign_block_vars('styles', array(
			'ROW_CLASS'	=> $row_class,
			'TPL'		=> htmlspecialchars($tpl),
			'ROWS'		=> count($styles),
		)
	);
	if(count($styles) > 1)
	{
		for($i=0; $i<count($styles); $i++)
		{
			$template->assign_block_vars('styles.item', array(
					'ID'		=> $styles[$i]['themes_id'],
					'THEME'		=> htmlspecialchars($styles[$i]['style_name']),
					'U_DELETE'	=> mx_append_sid('xs_uninstall.'.$phpEx.'?remove='.$styles[$i]['themes_id'].'&nocfg=1'),
				)
			);
			$template->assign_block_vars('styles.item.nodelete', array());
		}
	}
	else
	{
		$i = 0;
		$template->assign_block_vars('styles.item', array(
				'ID'		=> $styles[$i]['themes_id'],
				'THEME'		=> htmlspecialchars($styles[$i]['style_name']),
				'U_DELETE'	=> mx_append_sid('xs_uninstall.'.$phpEx.'?remove='.$styles[$i]['themes_id']),
			)
		);
		$template->assign_block_vars('styles.item.delete', array(
				'U_DELETE'	=> mx_append_sid('xs_uninstall.'.$phpEx.'?dir=1&remove='.$styles[$i]['themes_id']),
			)
		);
	}
}

$template->set_filenames(array('body' => XS_TPL_PATH . 'uninstall.'.$tplEx));
$template->pparse('body');
xs_exit();

?>