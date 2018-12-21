<?php
/**
*
* @package Language Tools Extension for the phpBB Forum Software package
* @version $Id$
* @copyright (c) orynider <http://mxpcms.sourceforge.net>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/* MG Lang DB - BEGIN */
/* MG Lang DB - END */

//namespace orynider\mx_translator\acp;
$basename = basename( __FILE__);

//
// Security and Page header
//
@define('IN_PORTAL', 1);
$mx_root_path = './../../../';
$module_root_path = $mx_root_path . 'modules/mx_translator/';
$admin_module_root_path = $module_root_path . 'admin/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
if (!defined('PHP_EXT')) define('PHP_EXT', $phpEx);
if (!defined('MX_ROOT_PATH')) define('MX_ROOT_PATH', './../');

if(!empty($setmodules))
{
	$module['Language_tools']['ACP_MX_LANGTOOLS_TITLE'] = mx_append_sid($admin_module_root_path . $basename . '');	
	return;
}

//
// Load default header
//
define('IN_ADMIN', 1); 
require($mx_root_path . 'admin/pagestart.' . $phpEx);

/**
* mx_langtools ACP module
 */
$lang = array();
$no_page_header = '';

define('MODULE_URL', PORTAL_URL . 'modules/mx_translator/');
define('IN_AJAX', (isset($_GET['ajax']) && ($_GET['ajax'] == 1) && ($_SERVER['HTTP_SEREFER'] = $_SERVER['PHP_SELF'])) ? 1 : 0);

//include_once($module_root_path . 'includes/translator.' . $phpEx);

//@error_reporting( E_ALL || !E_NOTICE);
//$mxp_translator = new mxp_translator();
/**
* Class  mxp_translator_module extends mxp_translator
* Displays a message to the user and allows him to send an email
*/

//Include shared phpBB2 language file 
$mx_user->set_lang($mx_user->lang, $mx_user->help, 'lang_main');
$mx_user->set_lang($mx_user->lang, $mx_user->help, 'lang_admin');
/* START Include language file lang_admin_extend_lang or all module language files */
$language = ($mx_user->user_language_name) ? $mx_user->user_language_name : (($board_config['default_lang']) ? $board_config['default_lang'] : 'english');
//$mx_user->extend(MX_LANG_ALL, MX_IMAGES_NONE, $module_root_path, true);
$mx_user->extend('lang_admin_extend_lang', MX_IMAGES_NONE, $module_root_path, true);
/* Get an instance of the admin controller */
if (!include_once($module_root_path . 'controller/mxp_translator.' . $phpEx))
{
	die('Cant find ' . $module_root_path . 'controller/mxp_translator.' . $phpEx);
}
include_once($mx_root_path . 'includes/mx_functions_admincp.' . $phpEx);

@set_time_limit(0);
$mem_limit = mx_check_mem_limit();
@ini_set('memory_limit', $mem_limit);

//$mxp_translator = new orynider\mx_translator\controller\mxp_translator();
$mxp_translator = new mxp_translator();

$value_maxlength = 250;

// Remove the ADMIN / NORMAL options => force $_POST options
$_POST['search_admin'] = 2;
$_POST['new_level'] = 'normal';

// get languages installed
$countries = $mxp_translator->get_countries();

// get packs installed
$packs = $mxp_translator->get_packs();

// get entries (all lang keys)
$entries = $mxp_translator->get_entries();

// get parameters
$mode = request_var('mode', '');
$mode = $mx_request_vars->check_var_value($mode, array('pack', 'key'), '');

$level = request_var('level', 'normal');
$level = $mx_request_vars->check_var_value($level, array('normal', 'admin'));

// pack file
$pack_file = request_post_var('pack_file', '');
$pack_file = empty($pack_file) ? request_get_var('pack', '') : $pack_file;
$pack_file = urldecode($pack_file);

if (!isset($packs[$pack_file]))
{
	$pack_file = '';
	$mode = '';
}

// keys
$key_main = request_post_var('key_main', '');
$key_main = empty($key_main) ? request_get_var('key', '') : $key_main;

$key_sub = request_post_var('key_sub', '');
$key_sub = empty($key_sub) ? request_get_var('sub', '') : $key_sub;

if (empty($key_main))
{
	$key_sub = '';
}
if (!isset($entries['admin'][$key_main][$key_sub]))
{
	$key_main = '';
	$key_sub = '';
}

// buttons
$submit = isset($_POST['submit']);
$delete = isset($_POST['delete']);
$cancel = isset($_POST['cancel']);
$add = isset($_POST['add']);
if ($add || $delete)
{
	$mode = 'key';
}
if (($mode == 'key') && ($pack_file == ''))
{
	$mode = '';
}

if (($mode == '') && $submit)
{
	$mode = 'search';
}

// key modification
if ($mode == 'key')
{
	if ($delete)
	{
		$new_entries = array();
		@reset($entries['admin']);
		while (list($new_main, $subs) = @each($entries['admin']))
		{
			@reset($subs);
			while (list($new_sub, $admin) = @each($subs))
			{
				if (($new_main != $key_main) || ($new_sub != $key_sub))
				{
					$new_entries['admin'][$new_main][$new_sub] = $entries['admin'][$new_main][$new_sub];
					$new_entries['pack'][$new_main][$new_sub] = $entries['pack'][$new_main][$new_sub];
					$new_entries['value'][$new_main][$new_sub] = $entries['value'][$new_main][$new_sub];
				}
			}
		}

		// write the result
		$mxp_translator->write($new_entries);

		// send message
		$pack_url = mx_append_sid('admin_lang_user_created.' . $phpEx . '?mode=pack&amp;pack=' . urlencode($pack_file) . '&amp;level=' . (($level == 'normal') ? 'normal' : 'admin'));
		mx_message_die(GENERAL_MESSAGE, sprintf($lang['Lang_extend_delete_done'], '<a href="' . $pack_url . '">', '</a>'));

		// back to the list
		$mode = 'pack';
		$delete = false;
	}
	elseif ($cancel)
	{
		// back to list
		$mode = 'pack';
		$cancel = false;
	}
	elseif ($submit)
	{
		// get formular
		$new_main = $_POST['new_main'];
		$new_sub = $_POST['new_sub'];
		$new_level = $_POST['new_level'];
		$new_values = $_POST['new_values'];
		$new_pack = $_POST['new_pack'];

		// force
		if (!in_array($new_level, array('normal', 'admin')))
		{
			$new_level = 'normal';
		}

		// check values
		$error = false;
		$error_msg = false;
		$dft_country = 'lang_' . $board_config['default_lang'];
		@reset($countries);
		while (list($country_dir, $country_name) = @each($countries))
		{
			if (empty($new_values[$country_dir]))
			{
				$new_values[$country_dir] = $new_values[$dft_country];
			}
			if (empty($new_values[$country_dir]) && ($dft_country != 'lang_english'))
			{
				$new_values[$country_dir] = $new_values['lang_english'];
			}
			if (empty($new_values[$country_dir]) && !$error)
			{
				$error = true;
				$error_msg .= (empty($error_msg) ? '' : '<br /><br />') . $lang['Lang_extend_missing_value'];
			}
		}

		// empty key
		if (empty($new_main))
		{
			$error = true;
			$error_msg .= (empty($error_msg) ? '' : '<br /><br />') . $lang['Lang_extend_key_missing'];
		}

		// we changed the key or create a new one
		if (!empty($new_main) && (($new_main != $key_main) || ($new_sub != $key_sub)))
		{
			// does the new key already exists ?
			if (isset($entries['admin'][$new_key][$new_sub]))
			{
				$error = true;
				$error_msg .= (empty($error_msg) ? '' : '<br /><br />') . sprintf($lang['Lang_extend_duplicate_entry'], $mxp_translator->get_lang($entries['pack'][$new_key][$new_sub]));
			}
		}

		// error
		if ($error)
		{
			message_die(GENERAL_MESSAGE, '<br />' . $error_msg . '<br /><br />');
			exit;
		}

		// perform the update
		$entries['pack'][$new_main][$new_sub] = $new_pack;
		$entries['admin'][$new_main][$new_sub] = ($new_level == 'admin');
		@reset($new_values);
		while (list($new_country, $new_value) = @each($new_values))
		{
			if (!empty($new_value))
			{
				$entries['value'][$new_main][$new_sub][$new_country] = $new_value;
			}
		}

		// write the result
		$mxp_translator->write($entries);

		// send message
		$key_url = mx_append_sid('admin_lang_user_created.' . $phpEx . '?mode=key&amp;pack=' . urlencode($new_pack) . '&amp;key=' . urlencode($new_main) . '&amp;sub=' . urlencode($new_sub) . '&amp;level=' . urlencode(($new_level == 'normal') ? 'normal' : 'admin'));
		$pack_url = mx_append_sid('admin_lang_user_created.' . $phpEx . '?mode=pack&amp;pack=' . urlencode($new_pack) . '&amp;level=' . (($new_level == 'normal') ? 'normal' : 'admin'));
		mx_message_die(GENERAL_MESSAGE, sprintf($lang['Lang_extend_update_done'], '<a href="' . $key_url . '">','</a>', '<a href="' . $pack_url . '">', '</a>'));
	}
	else
	{
		// template
		$template->set_filenames(array('body' => ('lang_user_created_key_body.html')));

		// header
		$template->assign_vars(array(
			'L_TITLE'					=> $lang['Lang_extend'],
			'L_TITLE_EXPLAIN'		=> $lang['Lang_extend_explain'],
			'L_KEY'						=> $lang['Lang_extend_entry'],
			'L_LANGUAGES'			=> $lang['Languages'],

			'L_SUBMIT'				=> $lang['Submit'],
			'L_DELETE'					=> $lang['Delete'],
			'L_CANCEL'				=> $lang['Cancel'],
			)
		);

		// pack list
		$s_packs = '';
		@reset($packs);
		while (list($file, $name) = @each($packs))
		{
			$selected = ($file == $pack_file) ? ' selected="selected"' : '';
			/* MG Lang DB - BEGIN */
			$s_packs .= '<option value="' . $file . '"' . $selected . '>' . $name . '</option>';
			/* MG Lang DB - END */
		}
		if (!empty($s_packs))
		{
			$s_packs = sprintf('<select name="new_pack">%s</select>', $s_packs);
		}

		// vars
		$template->assign_vars(array(
			'L_KEY_MAIN'						=> $lang['Lang_extend_key_main'],
			'L_KEY_MAIN_EXPLAIN'		=> $lang['Lang_extend_key_main_explain'],
			'KEY_MAIN'						=> $key_main,
			'L_KEY_SUB'						=> $lang['Lang_extend_key_sub'],
			'L_KEY_SUB_EXPLAIN'			=> $lang['Lang_extend_key_sub_explain'],
			'KEY_SUB'							=> $key_sub,

			'L_PACK'							=> $lang['Lang_extend_pack'],
			'L_PACK_EXPLAIN'				=> $lang['Lang_extend_pack_explain'],
			'S_PACKS'							=> $s_packs,

			'L_LEVEL'							=> $lang['Lang_extend_level'],
			'L_LEVEL_EXPLAIN'				=> $lang['Lang_extend_level_explain'],
			'LEVEL_NORMAL'				=> 'normal',
			'L_EDIT'								=> $lang['Lang_extend_level_edit'],
			'S_LEVEL_NORMAL'			=> ($level == 'normal') ? 'checked="checked"' : '',
			'L_LEVEL_NORMAL'			=> $lang['Lang_extend_level_normal'],
			'LEVEL_ADMIN'					=> 'admin',
			'S_LEVEL_ADMIN'				=> ($level != 'normal') ? 'checked="checked"' : '',
			'L_LEVEL_ADMIN'				=> $lang['Lang_extend_level_admin'],

			'L_PACKS'							=> $lang['Lang_extend_pack'],
			'L_PACKS'							=> $lang['Lang_extend_pack_explain'],
			)
		);

		// get all language values
		@reset($countries);
		while (list($country_dir, $country_name) = each($countries))
		{
			$value = $entries['value'][$key_main][$key_sub][$country_dir];
			$status = $entries['status'][$key_main][$key_sub][$country_dir];
			$l_status = '';
			switch ($status)
			{
				case 1:
					$l_status = $lang['Lang_extend_modified'];
					break;
				case 2:
					$l_status = $lang['Lang_extend_added'];
					break;
				default:
					$l_status = '';
					break;
			}
			$template->assign_block_vars('row', array(
				'L_COUNTRY'		=> $country_name,
				'COUNTRY'		=> $country_dir,
				'VALUE'				=> is_array($value) ? htmlspecialchars(print_r($value, true)) :  htmlspecialchars($value),
				'L_STATUS'		=> $l_status,
				)
			);
		}

		// footer
		$s_hidden_fields = '';
		$s_hidden_fields .= '<input type="hidden" name="mode" value="' . $mode . '" />';
		$s_hidden_fields .= '<input type="hidden" name="pack_file" value="' . urlencode($pack_file) . '" />';
		$s_hidden_fields .= '<input type="hidden" name="key_main" value="' . urlencode($key_main) . '" />';
		$s_hidden_fields .= '<input type="hidden" name="key_sub" value="' . urlencode($key_sub) . '" />';
		$s_hidden_fields .= '<input type="hidden" name="level" value="' . urlencode($level) . '" />';
		$template->assign_vars(array(
			'S_ACTION'				=> mx_append_sid('admin_lang_user_created.' . $phpEx),
			'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
			)
		);
	}
}

// pack
if ($mode == 'pack')
{
	if ($cancel)
	{
		// back to the main list
		$mode = '';
		$cancel = false;
	}
	else
	{
		// template
		$template->set_filenames(array('body' => ('lang_user_created_pack_body.html')));

		// header
		$template->assign_vars(array(
			'L_TITLE'					=> $lang['Lang_extend'],
			'L_TITLE_EXPLAIN'	=> $lang['Lang_extend_explain'],
			'LEVEL'						=> ($level == 'admin') ? $lang['Lang_extend_level_admin'] : $lang['Lang_extend_level_normal'],

			'L_PACK'					=> $lang['Lang_extend_pack'],
			'U_PACK'					=> mx_append_sid('admin_lang_user_created.' . $phpEx),
			/* MG Lang DB - BEGIN */
			//'PACK'					=> $mxp_translator->get_lang('Lang_extend_' . $packs[$pack_file]),
			'PACK'						=> $packs[$pack_file],
			/* MG Lang DB - END */

			'L_EDIT'					=> $lang['Lang_extend_level_edit'],
			'L_LEVEL_NEXT'		=> ($level == 'admin') ? $lang['Lang_extend_level_normal'] : $lang['Lang_extend_level_admin'],
			'U_LEVEL_NEXT'		=> mx_append_sid('admin_lang_user_created.' . $phpEx . '?mode=pack&amp;pack=' . urlencode($pack_file) . '&amp;level=' . (($level == 'admin') ? 'normal' : 'admin')),

			'L_KEYS'					=> $lang['Lang_extend_entries'],
			'L_NONE'					=> $lang['None'],
			'L_ADD'						=> $lang['Lang_extend_add_entry'],
			'L_CANCEL'				=> $lang['Cancel'],
			)
		);

		// dump
		$color = false;
		$i = 0;
		@reset($entries['pack']);
		while (list($key_main, $data) = @each($entries['pack']))
		{		
			@reset($data);
			while (list($key_sub, $pack) = @each($data))
			{
				if ( ($key_main == 'mx_meta') || ($key_main == 'meta'))
				{
					$lang[$key_main]['langcode'] = isset($lang['USER_LANG']) ? $lang['USER_LANG'] : '';
				}
				elseif ($key_main == 'DEMO_VAR') 
				{
					$lang[$key_main]= isset($lang['DEMO_VAR']) ? $lang['DEMO_VAR'] : 'Demo Variable';
				}									
				
				if (($pack == $pack_file) && (($entries['admin'][$key_main][$key_sub] && ($level == 'admin')) || (!$entries['admin'][$key_main][$key_sub] && ($level == 'normal'))))
				{
					$value = trim((!isset($lang[$key_main][$key_sub]) ? $lang[$key_main] : $lang[$key_main][$key_sub]));
					if (strlen($value) > $value_maxlength)
					{
						$value = substr($value, 0, $value_maxlength-3) . '...';
					}
					$value = htmlspecialchars($value);

					// get the status
					$modified_added = false;
					if ($pack != 'custom')
					{
						$found = false;
						@reset($entries['status'][$key_main][$key_sub]);
						while (list($country_dir, $status) = @each($entries['status'][$key_main][$key_sub]))
						{
							$found = ($status > 0);
							if ($found)
							{
								$modified_added = true;
								break;
							}
						}
					}

					$i++;
					$color = !$color;
					$template->assign_block_vars('row', array(
						'CLASS'			=> $color ? 'row1' : 'row2',
						'KEY_MAIN'	=> "['" . $key_main . "']",
						'KEY_SUB'		=> empty($key_sub) ? '' : "['" . $key_sub . "']",
						'U_KEY'			=> mx_append_sid('admin_lang_user_created.' . $phpEx . '?mode=key&amp;pack=' . urlencode($pack_file) . '&amp;level=' . $level . '&amp;key=' . urlencode($key_main) . '&amp;sub=' . urlencode($key_sub)),
						'VALUE'			=> $value,
						'STATUS'		=> $modified_added ? $lang['Lang_extend_added_modified'] : '',
						)
					);
				}
			}
		}
		if ($i == 0)
		{
			$template->assign_block_vars('none', array());
		}

		// footer
		$s_hidden_fields = '';
		$s_hidden_fields .= '<input type="hidden" name="mode" value="' . $mode . '" />';
		$s_hidden_fields .= '<input type="hidden" name="pack_file" value="' . urlencode($pack_file) . '" />';
		$s_hidden_fields .= '<input type="hidden" name="level" value="' . urlencode($level) . '" />';
		$template->assign_vars(array(
			'S_ACTION'				=> mx_append_sid('admin_lang_user_created.' . $phpEx),
			'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
			)
		);
	}
}

// search
if ($mode == 'search')
{
	if ($cancel)
	{
		$cancel = '';
		$mode = '';
	}
	else
	{
		// formular
		$search_words = str_replace("\'", "'", str_replace("''", "'", trim($_POST['search_words'])));
		$search_logic = intval($_POST['search_logic']);
		$search_in = intval($_POST['search_in']);
		$search_country = $_POST['search_language'];
		$search_language = isset($_POST['search_language']) ? str_replace("\'", "'", urldecode($_POST['search_language'])) : 'lang_' . $board_config['default_lang'];
		$search_admin = intval($_POST['search_admin']);
		
		// results
		$results = array();

		// get all the words to search
		if (empty($search_words))
		{
			$main_url = mx_append_sid('admin_lang_user_created.' . $phpEx);
			message_die(GENERAL_MESSAGE, sprintf($lang['Lang_extend_search_no_words'], '<a href="' . $main_url . '">', '</a>'));
			exit;
		}
		$w_words = explode(' ', strtolower(str_replace('_', ' ', str_replace("\'", "'", str_replace("''", "'", $search_words)))));
		for ($i = 0; $i < sizeof($w_words); $i++)
		{
			if (!empty($w_words[$i]))
			{
				$words[] = $w_words[$i];
			}
		}

		// check each entry
		@reset($entries['pack']);
		while (list($key_main, $subs) = @each($entries['pack']))
		{
			@reset($subs);
			while (list($key_sub, $pack_dir) = @each($subs))
			{
				$admin = $entries['admin'][$key_main][$key_sub];
				if (($admin && ($search_admin != 1)) || (!$admin && ($search_admin != 0)))
				{
					$w_key = strtolower(str_replace('_', ' ', str_replace("\'", "'", str_replace("''", "'", $key_main))));
					$w_key .= ' ' . strtolower(str_replace('_', ' ', str_replace("\'", "'", str_replace("''", "'", $key_sub))));
					$w_words = explode(' ', $w_key);

					$words_key = array();
					for ($i = 0; $i < sizeof($w_words); $i++)
					{
						if (!empty($w_words[$i]))
						{
							$words_key[] = $w_words[$i];
						}
					}

					$words_val = array();
					@reset($countries);
					while (list($country, $country_name) = @each($countries))
					{
						if (empty($search_country) || ($country == $search_country))
						{
							$w_words_val = explode(' ', strtolower(str_replace("\'", "'", str_replace("''", "'", $entries['value'][$key_main][$key_sub][$country]))));
							for ($i = 0; $i < sizeof($w_words_val); $i++)
							{
								if (!empty($w_words_val[$i]))
								{
									if (empty($words_val) || !in_array($w_words_val[$i], $words_val))
									{
										$words_val[] = $w_words_val[$i];
									}
								}
							}
						}
					}

					// is this key convenient ?
					$ok = ($search_logic == 0);
					for ($i = 0; $i < sizeof($words); $i++)
					{
						$found = ((($search_in != 1) && in_array($words[$i], $words_key)) || (($search_in != 0) && in_array($words[$i], $words_val)));
						if (($search_logic == 1) && $found)
						{
							$ok = true;
							break;
						}
						if (($search_logic == 0) && !$found)
						{
							$ok = false;
							break;
						}
					}
					if ($ok)
					{
						$results[] = array('main' => $key_main, 'sub' => $key_sub);
					}
				}
			}
		}

		// template
		$template->set_filenames(array('body' => ('lang_user_created_search_body.html')));

		// header
		$template->assign_vars(array(
			'L_TITLE'						=> $lang['Lang_extend'],
			'L_TITLE_EXPLAIN'		=> $lang['Lang_extend_explain'],
			'L_SEARCH_RESULTS'	=> $lang['Lang_extend_search_results'],
			'L_PACK'						=> $lang['Lang_extend_pack'],
			'L_KEY'							=> $lang['Lang_extend_entries'],
			'L_VALUE'						=> $lang['Lang_extend_value'],
			'L_LEVEL'						=> $lang['Lang_extend_level_leg'],
			'L_NONE'						=> $lang['None'],
			'L_CANCEL'					=> $lang['Cancel'],
			)
		);

		$color = false;
		for ($i = 0; $i < sizeof($results); $i++)
		{
			// get data
			$key_main	= $results[$i]['main'];
			$key_sub	= $results[$i]['sub'];
			$pack_file	= $entries['pack'][$key_main][$key_sub];
			$pack_name	= $packs[$pack_file];
			$admin		= $entries['admin'][$key_main][$key_sub];

			// value
			$value = trim((empty($key_sub) ? $lang[$key_main] : $lang[$key_main][$key_sub]));
			if (strlen($value) > $value_maxlength)
			{
				$value = substr($value, 0, $value_maxlength-3) . '...';
			}
			$value = htmlspecialchars($value);

			// status
			$modified_added = false;
			if ($pack_file != 'custom')
			{
				$found = false;
				@reset($entries['status'][$key_main][$key_sub]);
				while (list($country_dir, $status) = @each($entries['status'][$key_main][$key_sub]))
				{
					$found = ($status > 0);
					if ($found)
					{
						$modified_added = true;
						break;
					}
				}
			}

			$color = !$color;
			$template->assign_block_vars('row', array(
				'CLASS'			=> $color ? 'row1' : 'row2',
				/* MG Lang DB - BEGIN */
				//'PACK'		=> $mxp_translator->get_lang('Lang_extend_' . $pack_name),
				'PACK'			=> $pack_name,
				/* MG Lang DB - END */
				'KEY_MAIN'	=> "['" . $key_main . "']",
				'KEY_SUB'		=> empty($key_sub) ? '' : "['" . $key_sub . "']",
				'VALUE'			=> $value,
				'L_EDIT'		=> $lang['Lang_extend_level_edit'],
				'LEVEL'			=> $admin ? $lang['Lang_extend_level_admin'] : $lang['Lang_extend_level_normal'],
				'STATUS'		=> $modified_added ? $lang['Lang_extend_added_modified'] : '',

				'U_PACK'		=> mx_append_sid('admin_lang_user_created.' . $phpEx . '?mode=pack&amp;pack=' . urlencode($pack_file) . '&amp;level=' . ($admin ? 'admin' : 'normal')),
				'U_KEY'			=> mx_append_sid('admin_lang_user_created.' . $phpEx . '?mode=key&amp;pack=' . urlencode($pack_file) . '&amp;level=' . ($admin ? 'admin' : 'normal') . '&amp;key=' . urlencode($key_main). '&amp;sub=' . urlencode($key_sub)),
				)
			);
		}

		if (sizeof($results) == 0)
		{
			$template->assign_block_vars('none', array());
		}

		// footer
		$s_hidden_fields = '';
		$s_hidden_fields .= '<input type="hidden" name="mode" value="' . $mode . '" />';
		$s_hidden_fields .= '<input type="hidden" name="search_words" value="' . urlencode(str_replace("'", "\'", $search_words)) . '" />';
		$s_hidden_fields .= '<input type="hidden" name="search_logic" value="' . $search_logic . '" />';
		$s_hidden_fields .= '<input type="hidden" name="search_in" value="' . $search_in . '" />';
		$s_hidden_fields .= '<input type="hidden" name="search_language" value="' . urlencode($search_language) . '" />';
		$s_hidden_fields .= '<input type="hidden" name="search_admin" value="' . $search_admin . '" />';

		$template->assign_vars(array(
			'S_ACTION'				=> mx_append_sid('admin_lang_user_created.' . $phpEx),
			'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
			)
		);
	}
}

// default entry
if ($mode == '')
{
	// search
	$search_words = isset($_POST['search_words']) ? str_replace("\'", "'", urldecode($_POST['search_words'])) : '';
	$search_logic = isset($_POST['search_logic']) ? intval($_POST['search_logic']) : 0;
	$search_in = isset($_POST['search_in']) ? intval($_POST['search_in']) : 2;
	$search_language = $search_country = isset($_POST['search_language']) ? str_replace("\'", "'", urldecode($_POST['search_language'])) : 'lang_' . $board_config['default_lang'];
	$search_admin = isset($_POST['search_admin']) ? intval($_POST['search_admin']) : 2;

	// template
	$template->set_filenames(array('body' => ('lang_user_created_body.html')));

	// header
	$template->assign_vars(array(
		'L_TITLE'					=> $lang['Lang_extend'],
		'L_TITLE_EXPLAIN'	=> $lang['Lang_extend_explain'],
		'L_PACK'					=> $lang['Lang_extend_pack'],
		'L_EDIT'					=> $lang['Lang_extend_level_edit'],
		'L_ADMIN'					=> $lang['Lang_extend_level_admin'],
		'L_NORMAL'				=> $lang['Lang_extend_level_normal'],

		'L_NONE'					=> $lang['None'],
		'L_SUBMIT'				=> $lang['Submit'],
		)
	);

	// display packs
	$i = 0;
	$color = false;
	@reset($packs);
	while (list($pack_file, $pack_name) = @each($packs))
	{
		$i++;
		$color = !$color;
		/* MG Lang DB - BEGIN */
		// ALL LANG EXTEND
		//if(preg_match("/^lang_extend.*?\." . $phpEx . "$/", urlencode($pack_file)))
		// LANG USER CREATED AND LANG MAIN SETTINGS
		//if((preg_match("/^lang_user_created.*?\." . $phpEx . "$/", urlencode($pack_file))) || (preg_match("/^lang_main_settings.*?\." . $phpEx . "$/", urlencode($pack_file))))
		// ONLY LANG USER CREATED
		if(preg_match("/^lang_user_created.*?\." . $phpEx . "$/", urlencode($pack_file)))
		{
			$l_normal = $lang['Lang_extend_level_normal'];
			$u_normal = mx_append_sid('admin_lang_user_created.' . $phpEx . '?mode=pack&amp;pack=' . urlencode($pack_file) . '&amp;level=normal');
			$l_admin = $lang['Lang_extend_level_admin'];
			$u_admin = mx_append_sid('admin_lang_user_created.' . $phpEx . '?mode=pack&amp;pack=' . urlencode($pack_file) . '&amp;level=admin');
		}
		else
		{
			$l_normal = $lang['Lang_extend_level_edit'];
			$u_normal = mx_append_sid('admin_lang_user_created.' . $phpEx . '?mode=pack&amp;pack=' . urlencode($pack_file) . '&amp;level=normal');
			$l_admin = '&bull;';
			$u_admin = '#';
		}
		/* MG Lang DB - END */

		$template->assign_block_vars('row', array(
			'COLOR'					=> $color ? 'row1' : 'row2',
			/* MG Lang DB - BEGIN */
			//'PACK'				=> $mxp_translator->get_lang('Lang_extend_' . $pack_name),
			'PACK'					=> $pack_name,
			/* MG Lang DB - END */
			'L_EDIT'				=> $lang['Edit'],
			'L_PACK_ADMIN'	=> $l_admin,
			'U_PACK_ADMIN'	=> $u_admin,
			'L_PACK_NORMAL'	=> $l_normal,
			'U_PACK_NORMAL'	=> $u_normal,
			)
		);
	}
	
	if ($i == 0)
	{
		$template->assign_block_vars('none', array());
	}

	// search form
	$template->assign_vars(array(
		'L_SEARCH'								=> $lang['Lang_extend_search'],
		'L_SEARCH_WORDS'					=> $lang['Lang_extend_search_words'],
		'L_SEARCH_WORDS_EXPLAIN'		=> $lang['Lang_extend_search_words_explain'],
		'L_SEARCH_ALL'							=> $lang['Lang_extend_search_all'],
		'L_SEARCH_ONE'						=> $lang['Lang_extend_search_one'],
		'L_SEARCH_IN'							=> $lang['Lang_extend_search_in'],
		'L_SEARCH_IN_EXPLAIN'				=> $lang['Lang_extend_search_in_explain'],
		'L_SEARCH_IN_KEY'					=> $lang['Lang_extend_search_in_key'],
		'L_SEARCH_IN_VALUE'				=> $lang['Lang_extend_search_in_value'],
		'L_SEARCH_IN_BOTH'					=> $lang['Lang_extend_search_in_both'],
		'L_EDIT'										=> $lang['Lang_extend_level_edit'],
		'L_SEARCH_LEVEL_ADMIN'			=> $lang['Lang_extend_level_admin'],
		'L_SEARCH_LEVEL_NORMAL'		=> $lang['Lang_extend_level_normal'],
		'L_SEARCH_LEVEL_BOTH'			=> $lang['Lang_extend_search_in_both'],
		)
	);

	// list of lang installed
	$selected = empty($search_country) ? ' selected="selected"' : '';
	$s_languages = '<option value=""' . $selected . '>' . $lang['Lang_extend_search_all_lang'] . '</option>';
	@reset($countries);
	while (list($country_dir, $country_name) = @each($countries))
	{
		$selected = ($country_dir == $search_country) ? ' selected="selected"' : '';
		$s_languages .= '<option value="' . $country_dir . '"' . $selected . '>' . $country_name . '</option>';
	}
	$s_languages = sprintf('<select name="search_language">%s</select>', $s_languages);

	$template->assign_vars(array(
		'SEARCH_WORDS'				=> $search_words,
		'SEARCH_ALL'					=> ($search_logic == 0) ? 'checked="checked"' : '',
		'SEARCH_ONE'					=> ($search_logic == 1) ? 'checked="checked"' : '',
		'SEARCH_IN_KEY'				=> ($search_in == 0) ? 'checked="checked"' : '',
		'SEARCH_IN_VALUE'			=> ($search_in == 1) ? 'checked="checked"' : '',
		'SEARCH_IN_BOTH'			=> ($search_in == 2) ? 'checked="checked"' : '',
		'SEARCH_LEVEL_ADMIN'		=> ($search_in == 0) ? 'checked="checked"' : '',
		'SEARCH_LEVEL_NORMAL'	=> ($search_in == 1) ? 'checked="checked"' : '',
		'SEARCH_LEVEL_BOTH'		=> ($search_in == 2) ? 'checked="checked"' : '',
		'S_LANGUAGES'					=> $s_languages,
		)
	);

	// footer
	$s_hidden_fields = '';
	$template->assign_vars(array(
		'S_ACTION'				=> mx_append_sid('admin_lang_user_created.' . $phpEx),
		'S_HIDDEN_FIELDS'		=> $s_hidden_fields,
		)
	);
}

// dump
$template->pparse('body');
require($mx_root_path . 'admin/page_footer_admin.' . $phpEx);

?>