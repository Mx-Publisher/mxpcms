<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: xs_style_config.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
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

@define('IN_XS', true);
include_once('xs_include.' . $phpEx);

$tpl = isset($HTTP_POST_VARS['tpl']) ? $HTTP_POST_VARS['tpl'] : (isset($HTTP_GET_VARS['tpl']) ? $HTTP_GET_VARS['tpl'] : '');
$filename = $mx_root_path . 'templates/' . $tpl . '/xs_config.cfg';

if(empty($tpl))
{
	xs_error($lang['xs_invalid_style_name']);
}
if(!@file_exists($filename))
{
	// remove from config
	$config_name = 'xs_style_' . $tpl;
	$sql = "DELETE FROM " . CONFIG_TABLE . " WHERE config_name='" . addslashes($config_name) . "'";
	$db->sql_query($sql);
	// recache config table for cat_hierarchy 2.1.0
	if(isset($GLOBALS['config']) && is_object($GLOBALS['config']))
	{
		global $config;
		$config->read(true);
	}
	$template->assign_block_vars('left_refresh', array(
			'ACTION'	=> mx_append_sid('index.' . $phpEx . '?pane=left')
		));
	xs_error($lang['xs_invalid_style_name']);
}

// get configuration
$style_config = array();
include($filename);
$data = $template->get_config($tpl, false);
for($i=0; $i<count($style_config); $i++)
{
	if(!isset($data[$style_config[$i]['var']]))
	{
		$data[$style_config[$i]['var']] = $style_config[$i]['default'];
	}
}


// check submitted form
if(isset($HTTP_POST_VARS['tpl']) && !defined('DEMO_MODE'))
{
	for($i=0; $i<count($style_config); $i++)
	{
		$item = &$style_config[$i];
		$var = $style_config[$i]['var'];
		if($item['type'] === 'list')
		{
			$value = isset($HTTP_POST_VARS['cfg_' . $var]) && is_array($HTTP_POST_VARS['cfg_' . $var]) ? $HTTP_POST_VARS['cfg_' . $var] : array();
			$list = array();
			foreach($value as $var1 => $value1)
			{
				$list[] = $var1;
			}
			$value = implode(',', $list);
		}
		else
		{
			$value = isset($HTTP_POST_VARS['cfg_' . $var]) ? stripslashes($HTTP_POST_VARS['cfg_' . $var]) : 0;
		}
		$data[$var] = $value;
	}
	// update config
	$str = $template->_serialize($data);
	$config_name = 'xs_style_' . $tpl;
	if(isset($board_config[$config_name]))
	{
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value='" . addslashes($str) . "' WHERE config_name='" . addslashes($config_name) . "'";
	}
	else
	{
		$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('" . addslashes($config_name) . "', '" . addslashes($str) . "')";
	}
	$db->sql_query($sql);
	$board_config[$config_name] = $str;
	// recache config table for cat_hierarchy 2.1.0
	if(isset($config) && is_object($config))
	{
		$config->read(true);
	}
}


// show form
$last_cat = '';
for($i=0; $i<count($style_config); $i++)
{
	$item = &$style_config[$i];
	$var = $style_config[$i]['var'];
	$template->assign_block_vars('item', array(
		'VAR'		=> 'cfg_' . $var,
		'VALUE'		=> htmlspecialchars($data[$var]),
		'DEF'		=> $item['default'],
		'TYPE'		=> $item['type'],
		'TEXT'		=> htmlspecialchars($item['text']),
		'EXPLAIN'	=> isset($item['explain']) ? $item['explain'] : '',
		));
	if($item['type'] === 'select')
	{
		foreach($item['selection'] as $var1 => $value1)
		{
			$template->assign_block_vars('item.select', array(
				'VALUE'		=> htmlspecialchars($var1),
				'TEXT'		=> htmlspecialchars($value1),
				'SELECTED'	=> $data[$var] === $var1 ? 1 : 0,
				));
		}
	}
	if($item['type'] === 'list')
	{
		$values = explode(',', $data[$var]);
		foreach($item['selection'] as $var => $value)
		{
			$selected = false;
			for($j=0; $j<count($values); $j++)
			{
				if($values[$j] === $var)
				{
					$selected = true;
				}
			}
			$template->assign_block_vars('item.list', array(
				'VALUE'		=> htmlspecialchars($var),
				'TEXT'		=> htmlspecialchars($value),
				'SELECTED'	=> $selected,
				));
			$num++;
		}
	}
	if(!empty($item['cat']) && $item['cat'] !== $last_cat)
	{
		$template->assign_block_vars('item.cat', array(
			'TEXT'	=> htmlspecialchars($item['cat'])
			));
		$last_cat = $item['cat'];
	}
}

$template->assign_vars(array(
	'TPL'		=> htmlspecialchars($tpl),
	'U_FORM'	=> 'xs_style_config.'.$phpEx.'?sid='.$userdata['session_id'],
	));

$template->assign_block_vars('nav_left',array('ITEM' => '&raquo; <a href="' . mx_append_sid('xs_style_config.'.$phpEx.'?tpl='.urlencode($tpl)) . '">' . $lang['xs_style_configuration'] . ': ' . $tpl . '</a>'));

$template->set_filenames(array('body' => XS_TPL_PATH . 'style_config.'.$tplEx));
$template->pparse('body');
xs_exit();

?>