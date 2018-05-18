<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: xs_edit.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
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


// check filter
$filter = isset($HTTP_GET_VARS['filter']) ? stripslashes($HTTP_GET_VARS['filter']) : (isset($HTTP_POST_VARS['filter']) ? stripslashes($HTTP_POST_VARS['filter']) : '');
if(isset($HTTP_POST_VARS['filter_update']))
{
	$filter_data = array(
		'ext'	=> trim(stripslashes($HTTP_POST_VARS['filter_ext'])),
		'data'	=> trim(stripslashes($HTTP_POST_VARS['filter_data']))
		);
	 $filter = serialize($filter_data);
}
else
{
	$filter_data = @unserialize($filter);
	if(empty($filter_data['ext']))
	{
		$filter_data['ext'] = '';
	}
	if(empty($filter_data['data']))
	{
		$filter_data['data'] = '';
	}
}
$filter_str = '?filter=' . urlencode($filter);


$template->assign_block_vars('nav_left',array('ITEM' => '&raquo; <a href="' . mx_append_sid('xs_edit.'.$phpEx.$filter_str) . '">' . $lang['xs_edit_templates'] . '</a>'));

$editable = array('.htm', '.html', '.tpl', '.css', '.txt', '.cfg', '.xml', '.php', '.htaccess');

// get current directory
$current_dir = isset($HTTP_GET_VARS['dir']) ? stripslashes($HTTP_GET_VARS['dir']) : (isset($HTTP_POST_VARS['dir']) ? stripslashes($HTTP_POST_VARS['dir']) : 'templates');
$current_dir = xs_fix_dir($current_dir);
if(defined('DEMO_MODE') && substr($current_dir, 0, 9) !== 'templates')
{	// limit access to "templates" in demo mode
	$current_dir = 'templates';
}
$dirs = explode('/', $current_dir);
for($i=0; $i<count($dirs); $i++)
{
	if(!$dirs[$i] || $dirs[$i] === '.')
	{
		unset($dirs[$i]);
	}
}
$current_dir = implode('/', $dirs);
$current_dir_full = $current_dir; //'templates' . ($current_dir ? '/' . $current_dir : '');
$current_dir_root = $current_dir ? $current_dir . '/' : '';

$return_dir = str_replace('{URL}', mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir)), $lang['xs_edittpl_back_dir']);
$return_url = $return_dir;
$return_url_root = str_replace('{URL}', mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='), $lang['xs_edittpl_back_dir']);


$template->assign_vars(array(
	'FILTER_EXT'	=> htmlspecialchars($filter_data['ext']),
	'FILTER_DATA'	=> htmlspecialchars($filter_data['data']),
	'FILTER_URL'	=> mx_append_sid('xs_edit.'.$phpEx),
	'FILTER_DIR'	=> htmlspecialchars($current_dir),
	'S_FILTER'		=> '<input type="hidden" name="filter" value="' . htmlspecialchars($filter) . '" />'
	));


/*
* show edit form
*/
if(isset($HTTP_GET_VARS['edit']) && !empty($HTTP_GET_VARS['restore']))
{
	$file = stripslashes($HTTP_GET_VARS['edit']);
	$file = xs_fix_dir($file);
	$fullfile = $current_dir_root . $file;
	$localfile = '../' . $fullfile;
	$hash = md5($localfile);
	$backup_name = XS_TEMP_DIR . XS_BACKUP_PREFIX . $hash . '.' . intval($HTTP_GET_VARS['restore']) . XS_BACKUP_EXT;
	if(@file_exists($backup_name))
	{
		// restore file
		$HTTP_POST_VARS['edit'] = $HTTP_GET_VARS['edit'];
		$HTTP_POST_VARS['content'] = addslashes(implode('', @file($backup_name)));
		unset($HTTP_GET_VARS['edit']);
		$return_file = str_replace('{URL}', mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir).'&edit='.urlencode($file)), $lang['xs_edittpl_back_edit']);
		$return_url = $return_file . '<br /><br />' . $return_dir;
	}
}


/*
* save modified file
*/
if(isset($HTTP_POST_VARS['edit']) && !defined('DEMO_MODE'))
{
	$file = stripslashes($HTTP_POST_VARS['edit']);
	$content = stripslashes($HTTP_POST_VARS['content']);
	$fullfile = $current_dir_root . $file;
	$localfile = '../' . $fullfile;
	if(!empty($HTTP_POST_VARS['trim']))
	{
		$content = trim($content);
	}
	if(!empty($HTTP_POST_FILES['upload']['tmp_name']) && @file_exists($HTTP_POST_FILES['upload']['tmp_name']))
	{
		$content = @implode('', @file($HTTP_POST_FILES['upload']['tmp_name']));
	}
	$params = array(
		'edit'		=> $file,
		'dir'		=> $current_dir,
		'content'	=> $content,
		'filter'	=> $filter,
		);
	$return_file = str_replace('{URL}', mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir).'&edit='.urlencode($file)), $lang['xs_edittpl_back_edit']);
	$return_url = $return_file . '<br /><br />' . $return_dir;
	// get ftp configuration
	$write_local = false;
	if(!get_ftp_config(mx_append_sid('xs_edit.'.$phpEx), $params, true))
	{
		xs_exit();
	}
	xs_ftp_connect(mx_append_sid('xs_edit.'.$phpEx), $params, true);
	if($ftp === XS_FTP_LOCAL)
	{
		$write_local = true;
		$local_filename = $localfile;
	}
	else
	{
		$local_filename = XS_TEMP_DIR . 'edit_' . time() . '.tmp';
	}
	$f = @fopen($local_filename, 'wb');
	if(!$f)
	{
		xs_error($lang['xs_error_cannot_open'] . '<br /><br />' . $return_url);
	}
	fwrite($f, $content);
	fclose($f);
	if($write_local)
	{
		xs_message($lang['Information'], $lang['xs_edit_file_saved'] . '<br /><br />' . $return_url);
	}
	// generate ftp actions
	$actions = array();
	// chdir to template directory
	for($i=0; $i<count($dirs); $i++)
	{
		$actions[] = array(
				'command'	=> 'chdir',
				'dir'		=> $dirs[$i]
		);
	}
	$actions[] = array(
			'command'	=> 'upload',
			'local'		=> $local_filename,
			'remote'	=> $fullfile
			);
	$ftp_log = array();
	$ftp_error = '';
	$res = ftp_myexec($actions);
	echo "<!--\n\n";
	echo "\$actions dump:\n\n";
	print_r($actions);
	echo "\n\n\$ftp_log dump:\n\n";
	print_r($ftp_log);
	echo "\n\n -->";
	@unlink($local_filename);
	if($res)
	{
		xs_message($lang['Information'], $lang['xs_edit_file_saved'] . '<br /><br />' . $return_url);
	}
	xs_error($ftp_error . '<br /><br />' . $return_url);
}


/*
* show edit form
*/
if(isset($HTTP_GET_VARS['edit']))
{
	$file = stripslashes($HTTP_GET_VARS['edit']);
	$file = xs_fix_dir($file);
	$fullfile = $current_dir_root . $file;
	$localfile = '../' . $fullfile;
	$hash = md5($localfile);
	if(!@file_exists($localfile))
	{
		xs_error($lang['xs_edit_not_found'] . '<br /><br />' . $return_url);
	}
	$content = @file($localfile);
	if(!is_array($content))
	{
		xs_error($lang['xs_edit_not_found'] . '<br /><br />' . $return_url);
	}
	$content = implode('', $content);
	if(isset($HTTP_GET_VARS['download']) && !defined('DEMO_MODE'))
	{
		xs_download_file($file, $content);
		xs_exit();
	}
	if(isset($HTTP_GET_VARS['downloadbackup']) && !defined('DEMO_MODE'))
	{
		$backup_name = XS_TEMP_DIR . XS_BACKUP_PREFIX . $hash . '.' . intval($HTTP_GET_VARS['downloadbackup']) . XS_BACKUP_EXT;
		xs_download_file($file, implode('', @file($backup_name)));
		xs_exit();
	}
	$return_file = str_replace('{URL}', mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir).'&edit='.urlencode($file)), $lang['xs_edittpl_back_edit']);
	$return_url = $return_file . '<br /><br />' . $return_dir;
	$template->assign_vars(array(
		'U_ACTION'		=> mx_append_sid('xs_edit.'.$phpEx),
		'U_BROWSE'		=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir)),
		'U_EDIT'		=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir).'&edit='.urlencode($file)),
		'U_BACKUP'		=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dobackup=1&dir='.urlencode($current_dir).'&edit='.urlencode($file)),
		'U_DOWNLOAD'	=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&download=1&dir='.urlencode($current_dir).'&edit='.urlencode($file)),
		'CURRENT_DIR'	=> htmlspecialchars($current_dir_full),
		'DIR'			=> htmlspecialchars($current_dir),
		'FILE'			=> htmlspecialchars($file),
		'FULLFILE'		=> htmlspecialchars($fullfile),
		'CONTENT'		=> defined('DEMO_MODE') ? $lang['xs_error_demo_edit'] : htmlspecialchars($content),
		)
	);
	if($current_dir_full)
	{
		$template->assign_block_vars('nav_left',array('ITEM' => '&raquo; <a href="' . mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.$current_dir) . '">' . htmlspecialchars($current_dir_full) . '</a>'));
	}

	// show tree
	$arr = array();
	$template->assign_block_vars('tree', array(
		'ITEM'	=> 'phpBB',
		'URL'	=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='),
		'SEPARATOR'	=> '',
		));
	$back_dir = '';
	for($i=0; $i<count($dirs); $i++)
	{
		$arr[] = $dirs[$i];
		$str = implode('/', $arr);
		if(count($dirs) > ($i + 1))
		{
			$back_dir = $str;
		}
		$template->assign_block_vars('tree', array(
			'ITEM'	=> htmlspecialchars($dirs[$i]),
			'URL'	=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($str)),
			'SEPARATOR'	=> '/',
			));
	}

	// view backup
	if(!empty($HTTP_GET_VARS['viewbackup']) && !defined('DEMO_MODE'))
	{
		$backup_name = XS_TEMP_DIR . XS_BACKUP_PREFIX . $hash . '.' . intval($HTTP_GET_VARS['viewbackup']) . XS_BACKUP_EXT;
		$template->assign_vars(array(
			'CONTENT'	=> implode('', @file($backup_name))
			)
		);
	}

	// save backup
	if(isset($HTTP_GET_VARS['dobackup']) && !defined('DEMO_MODE'))
	{
		$backup_name = XS_TEMP_DIR . XS_BACKUP_PREFIX . $hash . '.' . time() . XS_BACKUP_EXT;
		$f = @fopen($backup_name, 'wb');
		if(!$f)
		{
			xs_error(str_replace('{FILE}', $backup_name, $lang['xs_error_cannot_create_tmp']) . '<br /><br />' . $return_url);
		}
		fwrite($f, $content);
		fclose($f);
		@chmod($backup_name, 0777);
	}

	// delete backup
	if(isset($HTTP_GET_VARS['delbackup']) && !defined('DEMO_MODE'))
	{
		$backup_name = XS_TEMP_DIR . XS_BACKUP_PREFIX . $hash . '.' . intval($HTTP_GET_VARS['delbackup']) . XS_BACKUP_EXT;
		@unlink($backup_name);
	}

	// show backups
	$backups = array();
	$res = opendir(XS_TEMP_DIR);
	$match = XS_BACKUP_PREFIX . $hash . '.';
	$match_len = strlen($match);
	while(($f = readdir($res)) !== false)
	{
		if(substr($f, 0, $match_len) === $match)
		{
			$str = substr($f, $match_len, strlen($f) - $match_len - strlen(XS_BACKUP_EXT));
			if(intval($str))
			{
				$backups[] = intval($str);
			}
		}
	}
	closedir($res);
	sort($backups);
	for($i=0; $i<count($backups); $i++)
	{
		$template->assign_block_vars('backup', array(
			'TIME'		=> create_date($board_config['default_dateformat'], $backups[$i], $board_config['board_timezone']),
			'U_RESTORE'	=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir).'&edit='.urlencode($file).'&restore='.$backups[$i]),
			'U_DELETE'	=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir).'&edit='.urlencode($file).'&delbackup='.$backups[$i]),
			'U_DOWNLOAD' => mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir).'&edit='.urlencode($file).'&downloadbackup='.$backups[$i]),
			'U_VIEW'	=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir).'&edit='.urlencode($file).'&viewbackup='.$backups[$i]),
			)
		);
	}

	// show template
	$template->set_filenames(array('body' => XS_TPL_PATH . 'edit_file.'.$tplEx));
	$template->pparse('body');
	xs_exit();
}


/*
*  show file browser
*/

// show tree
$arr = array();
$template->assign_block_vars('tree', array(
	'ITEM'	=> 'phpBB',
	'URL'	=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='),
	'SEPARATOR'	=> '',
	));
$back_dir = '';
for($i=0; $i<count($dirs); $i++)
{
	$arr[] = $dirs[$i];
	$str = implode('/', $arr);
	if(count($dirs) > ($i + 1))
	{
		$back_dir = $str;
	}
	$template->assign_block_vars('tree', array(
		'ITEM'	=> htmlspecialchars($dirs[$i]),
		'URL'	=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($str)),
		'SEPARATOR'	=> '/',
		));
}

// get list of files/directories
$list_files = array();			// non-editable files
$list_files_editable = array();	// editable files
$list_dirs = array();			// directories
$res = @opendir($mx_root_path . $current_dir_full);
if(!$res)
{
	xs_error(str_replace('{DIR}', $current_dir_full, $lang['xs_export_no_open_dir']) . '<br /><br />' . $return_url_root);
}
while(($file = readdir($res)) !== false)
{
	if($file !== '.' && $file !== '..')
	{
		$filename = $mx_root_path . ($current_dir_full ? $current_dir_full . '/' : '') . $file;
		if(is_dir($filename))
		{
			$list_dirs[] = $file;
		}
		else
		{
			$pos = strrpos($file, '.');
			if($pos !== false)
			{
				$ext = strtolower(substr($file, $pos));
				$ext1 = substr($ext, 1);
				if((!$filter_data['ext'] && xs_in_array($ext, $editable)) || $ext1 === $filter_data['ext'])
				{
					// check filter
					if($filter_data['data'])
					{
						$content = @implode('', @file($filename));
						if(strpos($content, $filter_data['data']) !== false)
						{
							$list_files_editable[] = $file;
						}
					}
					else
					{
						$list_files_editable[] = $file;
					}
				}
				else
				{
					$list_files[] = $file;
				}
			}
		}
	}
}
closedir($res);

$list_dirs_count = count($list_dirs);
$list_files_count = count($list_files) + count($list_files_editable);

if($current_dir || count($list_dirs))
{
	$template->assign_block_vars('begin_dirs', array(
		'COUNT'		=> count($list_dirs),
		'L_COUNT'	=> str_replace('{COUNT}', count($list_dirs), $lang['xs_fileman_dircount'])
		));
}
else
{
	$template->assign_block_vars('begin_nodirs', array());
}
if($current_dir)
{
	$template->assign_block_vars('begin_dirs.dir', array(
		'NAME'			=> '..',
		'FULLNAME'		=> htmlspecialchars($back_dir ? $back_dir . '/' : ''),
		'URL'			=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($back_dir)),
		)
	);
}

// show subdirectories
sort($list_dirs);
for($i=0; $i<count($list_dirs); $i++)
{
	$dir = $list_dirs[$i];
	$str = $current_dir_root . $dir;
	$template->assign_block_vars('begin_dirs.dir', array(
		'NAME'			=> htmlspecialchars($dir),
		'FULLNAME'		=> htmlspecialchars($current_dir_root . $dir),
		'URL'			=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($str)),
		)
	);
}

// show editable files
if(count($list_files_editable))
{
	$template->assign_block_vars('begin_files', array('COUNT' => count($list_files_editable)));
}
else
{
	$template->assign_block_vars('begin_nofiles', array('COUNT' => count($list_files_editable)));
}
sort($list_files_editable);
// get today start
$today = floor((time() + 3600 * $board_config['board_timezone']) / 86400) * 86400 - (3600 * $board_config['board_timezone']);
for($i=0; $i<count($list_files_editable); $i++)
{
	$file = $list_files_editable[$i];
	$fullfile = $current_dir_root . $file;
	$localfile = '../' . $fullfile;
	$row_class = $xs_row_class[$i % 2];
	$t = @filemtime($localfile);
	$filetime = $t ? create_date($board_config['default_dateformat'], $t, $board_config['board_timezone']) : '&nbsp;';
	$template->assign_block_vars('begin_files.file', array(
		'ROW_CLASS'	=> $row_class,
		'NAME'		=> htmlspecialchars($file),
		'FULLNAME'	=> htmlspecialchars($fullfile),
		'SIZE'		=> @filesize($localfile),
		'TIME'		=> $filetime,
		'URL'		=> mx_append_sid('xs_edit.'.$phpEx.$filter_str.'&dir='.urlencode($current_dir).'&edit='.urlencode($file))
		)
	);
	if($t < $today)
	{
		$template->assign_block_vars('begin_files.file.old', array());
	}
	else
	{
		$template->assign_block_vars('begin_files.file.today', array());
	}
}

$template->set_filenames(array('body' => XS_TPL_PATH . 'edit.'.$tplEx));
$template->pparse('body');
xs_exit();

?>