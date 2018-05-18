<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: xs_install.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
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

$template->assign_block_vars('nav_left',array('ITEM' => '&raquo; <a href="' . mx_append_sid('xs_install.'.$phpEx) . '">' . $lang['xs_install_styles'] . '</a>'));

$lang['xs_install_back'] = str_replace('{URL}', mx_append_sid('xs_install.'.$phpEx), $lang['xs_install_back']);
$lang['xs_goto_default'] = str_replace('{URL}', mx_append_sid('xs_styles.'.$phpEx), $lang['xs_goto_default']);

// remove timeout. useful for forum with 100+ styles
@set_time_limit(XS_MAX_TIMEOUT);

// install style
if(!empty($HTTP_GET_VARS['style']) && !defined('DEMO_MODE'))
{
	$style = stripslashes($HTTP_GET_VARS['style']);
	$num = intval($HTTP_GET_VARS['num']);
	$res = xs_install_style($style, $num);
	if(defined('REFRESH_NAVBAR'))
	{
		$template->assign_block_vars('left_refresh', array(
				'ACTION'	=> mx_append_sid('index.' . $phpEx . '?pane=left')
			));
	}
	if($res)
	{
		if(defined('XS_MODS_CATEGORY_HIERARCHY'))
		{
			cache_themes();
		}
		xs_message($lang['Information'], $lang['xs_install_installed'] . '<br /><br />' . $lang['xs_install_back'] . '<br /><br />' . $lang['xs_goto_default']);
	}
	xs_error($lang['xs_install_error'] . '<br /><br />' . $lang['xs_install_back']);
}

// install styles
if(!empty($HTTP_POST_VARS['total']) && !defined('DEMO_MODE'))
{
	$tpl = array();
	$num = array();
	$total = intval($HTTP_POST_VARS['total']);
	for($i=0; $i<$total; $i++)
	{
		if(!empty($HTTP_POST_VARS['install_'.$i]))
		{
			$tpl[] = stripslashes($HTTP_POST_VARS['install_'.$i.'_style']);
			$num[] = intval($HTTP_POST_VARS['install_'.$i.'_num']);
		}
	}
	if(count($tpl))
	{
		for($i=0; $i<count($tpl); $i++)
		{
			xs_install_style($tpl[$i], $num[$i]);
		}
		if(defined('REFRESH_NAVBAR'))
		{
			$template->assign_block_vars('left_refresh', array(
					'ACTION'	=> mx_append_sid('index.' . $phpEx . '?pane=left')
				));
		}
		if(defined('XS_MODS_CATEGORY_HIERARCHY'))
		{
			cache_themes();
		}
		xs_message($lang['Information'], $lang['xs_install_installed'] . '<br /><br />' . $lang['xs_install_back'] . '<br /><br />' . $lang['xs_goto_default']);
	}
}


// get all installed styles
$sql = 'SELECT themes_id, template_name, style_name FROM ' . THEMES_TABLE . ' ORDER BY template_name';
if(!$result = $db->sql_query($sql))
{
	xs_error($lang['xs_no_style_info'], __LINE__, __FILE__);
}
$style_rowset = $db->sql_fetchrowset($result);

// find all styles to install
$res = @opendir($mx_root_path . 'templates/');
$styles = array();
while(($file = readdir($res)) !== false)
{
	if($file !== '.' && $file !== '..' && @file_exists($mx_root_path . 'templates/'.$file.'/theme_info.cfg') && @file_exists($mx_root_path . 'templates/'.$file.'/'.$file.'.cfg'))
	{
		$arr = xs_get_themeinfo($file);
		for($i=0; $i<count($arr); $i++)
		{
			if(isset($arr[$i]['template_name']) && $arr[$i]['template_name'] === $file)
			{
				$arr[$i]['num'] = $i;
				$style = $arr[$i]['style_name'];
				$found = false;
				for($j=0; $j<count($style_rowset); $j++)
				{
					if($style_rowset[$j]['style_name'] == $style)
					{
						$found = true;
					}
				}
				if(!$found)
				{
					$styles[$arr[$i]['style_name']] = $arr[$i];
				}
			}
		}
	}
}
closedir($res);

if(!count($styles))
{
	xs_message($lang['Information'], $lang['xs_install_none'] . '<br /><br />' . $lang['xs_goto_default']);
}

ksort($styles);

$j = 0;
foreach($styles as $var => $value)
{
	$row_class = $xs_row_class[$j % 2];
	$template->assign_block_vars('styles', array(
			'ROW_CLASS'	=> $row_class,
			'STYLE'		=> htmlspecialchars($value['template_name']),
			'THEME'		=> htmlspecialchars($value['style_name']),
			'U_INSTALL'	=> mx_append_sid('xs_install.'.$phpEx.'?style='.urlencode($value['template_name']).'&num='.$value['num']),
			'CB_NAME'	=> 'install_'.$j,
			'NUM'		=> $value['num'],
		)
	);
	$j++;
}

$template->assign_vars(array(
	'U_INSTALL'		=> mx_append_sid('xs_install.'.$phpEx),
	'TOTAL'			=> count($styles)
	));

$template->set_filenames(array('body' => XS_TPL_PATH . 'install.'.$tplEx));
$template->pparse('body');
xs_exit();

?>