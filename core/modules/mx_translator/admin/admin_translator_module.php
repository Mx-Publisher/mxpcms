<?php
/**
 *
 * Language Tools Extension for the phpBB Forum Software package
 *
* @copyright (c) orynider <http://mxpcms.sourceforge.net>
* @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
//namespace orynider\mx_translator\acp;
/* */
$basename = basename( __FILE__);
$mx_root_path = './../../../';
$module_root_path = $mx_root_path . 'modules/mx_translator/';
$admin_module_root_path = $module_root_path . 'admin/';
/* */
$lang['ACP_TRANSLATE_MX_PORTAL']		= 'MXP Core';
$lang['ACP_TRANSLATE_MX_MODULES']		= 'MXP Modules';
$lang['ACP_TRANSLATE_PHPBB_LANG']		= 'PHPBB Core';
$lang['ACP_TRANSLATE_PHPBB_EXT']		= 'PHPBB EXT';
$lang['ACP_TRANSLATOR_CONFIG']			= 'Translator Settings';
/* */
if ( !empty( $setmodules))
{	
	$module['Language_tools']['ACP_TRANSLATOR_CONFIG'] = mx_append_sid( $admin_module_root_path . $basename . '?mode=config');	
	$module['Language_tools']['ACP_TRANSLATE_MX_PORTAL'] = mx_append_sid( $admin_module_root_path . $basename . '?s=MXP&mode=translate');
	$module['Language_tools']['ACP_TRANSLATE_MX_MODULES'] = mx_append_sid( $admin_module_root_path . $basename . '?s=MODS&mode=translate');
	$module['Language_tools']['ACP_TRANSLATE_PHPBB_LANG'] = mx_append_sid( $admin_module_root_path . $basename . '?s=PHPBB&mode=translate');
	$module['Language_tools']['ACP_TRANSLATE_PHPBB_EXT'] = mx_append_sid( $admin_module_root_path . $basename . '?s=phpbb_ext&mode=translate');		
	return;
}
/* */

/**
* mx_langtools ACP module
 */
define('IN_PORTAL', 1);
define('IN_ADMIN', 1); 
$phpEx = substr( __FILE__, strrpos( __FILE__, '.') + 1);
define('MODULE_URL', PHPBB_URL . 'ext/orynider/mx_translator/');		
define('IN_AJAX', (isset($_GET['ajax']) && ($_GET['ajax'] == 1) && ($_SERVER['HTTP_SEREFER'] = $_SERVER['PHP_SELF'])) ? 1 : 0);

$no_page_header = 'no_page_header';
require_once($mx_root_path . 'admin/pagestart.' . $phpEx);
//include_once($module_root_path . 'includes/translator.' . $phpEx);

//@error_reporting( E_ALL || !E_NOTICE);
//$mxp_translator = new mxp_translator();
/**
* Class  mxp_translator_module extends mxp_translator
* Displays a message to the user and allows him to send an email
*/
 
		
/* Get an instance of the admin controller */
if (!include_once($module_root_path . 'controller/mxp_translator.' . $phpEx))
{
	die('Cant find ' . $module_root_path . 'controller/mxp_translator.' . $phpEx);
}
		
//$mxp_translator = new orynider\mx_translator\controller\mxp_translator();
$mxp_translator = new mxp_translator();
		
/* Requests */
//$action = $request->variable('action', '');
		
/* general vars */
$mode = $mx_request_vars->request('mode', 'generate');
$start = $mx_request_vars->request('start', 0); 
$s = $mx_request_vars->request('s', '');
$ajax = $mx_request_vars->request('ajax', 0);		
$set_file = $mx_request_vars->request('set_file', '');
$into = $mx_request_vars->request('into', '');
/* */
		
// Make the $u_action url available in the admin controller
//$mxp_translator->set_page_url($this->u_action);			
/**
 * Set config value.
 *
 * Creates missing config entry if needed.
 *
 * @param unknown_type $config_name
 * @param unknown_type $config_value
* @param unknown_type $is_dynamic
 */
function acp_translator_set_config($config_name, $config_value)
{
	global $db, $mx_cache, $translator_config, $mx_table_prefix;
	$mx_table_prefix = !empty($mx_table_prefix) ? $mx_table_prefix : 'mx_';	
	define('TRANSLATOR_CONFIG_TABLE', $mx_table_prefix . "translator_config");
	$sql = 'UPDATE ' . TRANSLATOR_CONFIG_TABLE . "
		SET config_value = '" . $db->sql_escape($config_value) . "'
		WHERE config_name = '" . $db->sql_escape($config_name) . "'";
	$db->sql_query($sql);

	if (!$db->sql_affectedrows() && !isset($translator_config[$config_name]))
	{
		$sql = 'INSERT INTO ' . TRANSLATOR_CONFIG_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				'config_name'	=> $config_name,
				'config_value'	=> $config_value,
		));
		$db->sql_query($sql);
	}

	$portal_config[$config_name] = $config_value;
	$mx_cache->put('translator_config', $translator_config);
}
/**
 * Get config data
 *
 * @access public
 * @return unknown
 */
function acp_translator_get_config($use_cache = true)
{
	global $db, $mx_cache, $translator_config, $mx_table_prefix;
	global $board_config;
	
	$mx_table_prefix = !empty($mx_table_prefix) ? $mx_table_prefix : 'mx_';
	define('TRANSLATOR_CONFIG_TABLE', $mx_table_prefix . "translator_config");
	
	/* * /
	if (($translator_config = $mx_cache->get('translator_config')) && ($use_cache))
	{
		return $translator_config;
	}
	else
	{
	/* */
		$sql = "SELECT *
			FROM " . TRANSLATOR_CONFIG_TABLE . "";

		if ( !($result = $db->sql_query($sql)) )
		{
			if (!function_exists('mx_message_die'))
			{
				die("Couldnt query portal configuration, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
			}
			else
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt query portal configuration', '', __LINE__, __FILE__, $sql );
			}
		}
		while($row = $db->sql_fetchrow($result))
		{
			$config_name = $row['config_name'];
			$config_value = $row['config_value'];
			$translator_config[$config_name] = trim($config_value);
		}
		$board_config = array_merge($board_config, $translator_config);
		$db->sql_freeresult($result);
		
		$mx_cache->put('translator_config', $translator_config);
/* * /	} /**/
}
/** **/
if ($mx_request_vars->is_post('submit') )
{
	$mode = 'submit';
}
/** Load the "settings" or "manage" module modes **/
switch ($mode)
{
	case 'submit':	
		// Is the form being submitted to us?
		if ($mx_request_vars->is_empty_post('translator_default_lang') || $mx_request_vars->is_empty_post('translator_choice_lang'))
		{
			mx_message_die(GENERAL_ERROR, "Failed to update translator configuration, you didn't specified valid values or your admin templates are incompatible with this version of MXP.");
		}
		$s_errors = (bool) count($errors);	
		acp_translator_set_config('translator_default_lang', ($mx_request_vars->request('translator_default_lang', 'en')));
		acp_translator_set_config('translator_choice_lang', ($mx_request_vars->request('translator_choice_lang', 'de,fr,es,ro')));
		
		$params = $_SERVER['QUERY_STRING'];
		$params = "mode=config&i=-orynider-mx_translator-acp-translator_module";
		$u_action = mx_append_sid("{$admin_module_root_path}$basename?$params", false, true);
				
		// If no errors, process the form data
		//if (empty($errors))
		//{
			// Add option settings change action to the admin log
			//$mxp_translator->log->add('admin', $mx_user->data['user_id'], $mx_user->ip, 'ACP_TRANSLATOR_SETTINGS_LOG');
			// Option settings have been updated and logged
			// Confirm this to the user and provide link back to previous page
			//trigger_error($mxp_translator->lang('ACP_TRANSLATOR_SETTINGS_CHANGED') . adm_back_link($mxp_translator->u_action));
		//}		
		//trigger_error($mxp_translator->lang('TRANSLATOR_CONFIG_SAVED') . adm_back_link($u_action));
		$message = $mxp_translator->lang('ACP_TRANSLATOR_SETTINGS_CHANGED') . "<br /><br />" . sprintf($mxp_translator->lang('CLICK_RETURN_CONFIG_INDEX'), "<a href=\"" . $u_action . "\">", "</a>") . "<br /><br />" . sprintf($mxp_translator->lang('CLICK_RETURN_ADMIN_INDEX'), "<a href=\"" . mx_append_sid($mx_root_path . "admin/index.$phpEx?pane=right") . "\">", "</a>");
			
		mx_message_die(GENERAL_MESSAGE, $message);			
	break;
	case 'config':	
		// Load a template from adm/style for our ACP page
		$tpl_name = 'acp_translator_config';
		// Set the page title for our ACP page
		$page_title = $lang['ACP_TRANSLATOR'];	
		// Load the display options handle in the admin controller  display_settings($tpl_name, $page_title);
		display_settings($tpl_name, $page_title);			
	break;
	
	case 'translate':
	default:
		switch ($s)
		{	
			case 'MXP':
				// Load a template from adm/style for our ACP page
				$tpl_name = 'lang_translate';
				// Set the page title for our ACP page
				$page_title = $lang['ACP_TRANSLATE_MX_PORTAL'];
				// Load the display options handle in the admin controller $mxp_translator->display_translate($this->tpl_name, $this->page_title);
			break;			
			case 'MODS':
				// Load a template from adm/style for our ACP page
				$tpl_name = 'lang_translate';
				// Set the page title for our ACP page
				$page_title = $lang['ACP_TRANSLATE_MX_MODULES'];
				// Load the display options handle in the admin controller $mxp_translator->display_translate($this->tpl_name, $this->page_title);
			break;			
			case 'PHPBB':
				// Load a template from adm/style for our ACP page
				$tpl_name = 'lang_translate';
				// Set the page title for our ACP page
				$page_title = $lang['ACP_TRANSLATE_PHPBB_LANG'];
				// Load the display options handle in the admin controller $mxp_translator->display_translate($this->tpl_name, $this->page_title);
			break;			
			case 'phpbb_ext':
				// Load a template from adm/style for our ACP page
				$tpl_name = 'lang_translate';
				// Set the page title for our ACP page
				$page_title = $lang['ACP_TRANSLATE_PHPBB_EXT'];
				// Load the display options handle in the admin controller $mxp_translator->display_translate($this->tpl_name, $this->page_title);
			break;
		}
		
		if (IN_AJAX == 0)
		{
			$lang['ENCODING'] = $mxp_translator->file_encoding;
			if (isset($_POST['save']) || isset($_POST['download']))
			{
				$mxp_translator->file_preparesave();
			}
			if (isset($_POST['save']))
			{
				$mxp_translator->file_save();
			}
			else if (isset($_POST['download']))
			{
				$mxp_translator->file_download();
			}
			
			require_once($mx_root_path . 'admin/page_header_admin.' . $phpEx);
			$template->set_filenames(array('body' => $tpl_name.'.html'));
			$template->assign_block_vars('file_to_translate_select', array());
			
			$s_action = $admin_module_root_path . $basename;
			$params = $_SERVER['QUERY_STRING'];	
			
			/** -------------------------------------------------------------------------
			* Extend User Style with module lang and images
			* Usage:  $user->extend(LANG, IMAGES, '_core', 'img_file_in_dir', 'img_file_ext')
			* Switches:
			* - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
			* - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
			** ------------------------------------------------------------------------- */
			$mxp_translator->extend(false, false, 'all', 'icon_info', false);
				
			/**
			* Reset custom module default style, once used.
			*/
			if (@file_exists($mxp_translator->user_current_style_path . 'images/menu_icons/icon_info.gif'))
			{
				$img_info = $mxp_translator->user_current_style_path . 'images/menu_icons/icon_info.gif';
			}
			else
			{
				$img_info = $mxp_translator->default_current_style_path . 'images/menu_icons/icon_info.gif';
			}
			if (@file_exists($mxp_translator->user_current_style_path . 'images/menu_icons/icon_google.gif'))
			{
				$img_google = $mxp_translator->user_current_style_path . 'images/menu_icons/icon_google.gif';
			}
			else
			{
				$img_google = $mxp_translator->default_current_style_path . 'images/menu_icons/icon_google.gif';
			}		
			/* * /	
			print_r($img_google); 
			/* */				
			$template->assign_vars(array( // #
				'TH_COLOR2' => $theme['th_color2'],
				
				'S_ACTION' => $s_action . '?' . str_replace('&amp;', '&',$params),
				'S_ACTION_AJAX' => $s_action . '?' . str_replace('&amp;', '&',$params) . '&ajax=1',
				'S_LANGUAGE_INTO' => $mxp_translator->gen_select_list('html', 'language', $mxp_translator->language_into, $mxp_translator->language_from),
				'S_MODULE_LIST' => $mxp_translator->gen_select_list('html', 'modules', $mxp_translator->module_select),
				'S_FILE_LIST' => $mxp_translator->gen_select_list('html', 'files', $mxp_translator->module_file),
				'L_RESET' => $lang['Reset'],
				'IMG_INFO' => $img_info,
				'IMG_GOOGLE' => $img_google,				
				'I_LANGUAGE' => $mxp_translator->language_into,
				'I_MODULE' => $mxp_translator->module_select,
				'I_FILE' => $mxp_translator->module_file,	
			));
			
			$mxp_translator->assign_template_vars($template);	
			$template->assign_vars(array( // #
				'L_MX_MODULES' => $lang['MX_Modules'],
			));
			
			if (($s == 'MODS') || ($s == 'phpbb_ext'))
			{
				$template->assign_block_vars('file_to_translate_select.modules', array());
				$template->assign_block_vars('modules', array());
			}	
			$mxp_translator->file_translate();
			
			$template->pparse('body');
			require_once($mx_root_path . 'admin/page_footer_admin.' . $phpEx);
		}
		else
		{ // AJAX
			$template->set_filenames( array('body' => 'selects.html'));			
			$style = "width:100%;"; 
			if ($into == 'language')
			{
				$option_list = $mxp_translator->gen_select_list('html', 'language', $mxp_translator->language_into, $mxp_translator->language_from);
				$name = 'language[into]';
				$id = 'f_lang_into';
			}
			if ($into == 'files')
			{				
				$option_list = $mxp_translator->gen_select_list('html', 'files', $mxp_translator->module_file);
				$name = 'translate[file]';
				$id = 'f_select_file';
			}
			$template->assign_block_vars('ajax_select', array(
				'NAME'		=> $name,
				'ID'		=> $id,
				'STYLE'		=> $style,
				'OPTIONS'	=> $option_list,
			));
			$template->pparse('body');
		}		
	break;				
}
function display_settings($tpl_name, $page_title)	
{
		global $mxp_translator, $template, $mx_user;
		global $mx_root_path, $module_root_path, $board_config;
		$php_ext = $phpEx = substr(__FILE__, strrpos( __FILE__, '.') + 1);
		$u_action = $module_root_path . 'admin/' . $basename;
		
		/* Load common language files if they not loaded yet */
		$mxp_translator->_load_lang($module_root_path, 'lang_admin', true);
		
		// Create a form key for preventing CSRF attacks 
		require_once($mx_root_path . 'admin/page_header_admin.' . $phpEx);
		
		$errors = array();
		
		acp_translator_get_config();
			
		$tpl_name = !empty($tpl_name) ? $tpl_name : 'acp_translator_config';
		$template->set_filenames(array('body' => $tpl_name.'.html'));
		// Create an array to collect errors that will be output to the user	
		$mxp_translator->assign_template_vars($template, false);
		$template->assign_vars(array(
			'U_ACTION'							=> mx_append_sid("admin_translator_module.$phpEx"),
		
			'ACP_TRANSLATOR_CONFIG_EXPLAIN'		=> $mxp_translator->lang('ACP_TRANSLATOR_CONFIG_EXPLAIN'),
			'ACP_TRANSLATOR_CONFIG_SET'			=> $mxp_translator->lang('ACP_TRANSLATOR_CONFIG_SET'),

			'L_TRANSLATOR_DEFAULT_LANG'			=> $mxp_translator->lang('TRANSLATOR_DEFAULT_LANG'),
			'L_TRANSLATOR_DEFAULT_LANG_EXPLAIN'	=> $mxp_translator->lang('TRANSLATOR_DEFAULT_LANG_EXPLAIN'),

			'L_TRANSLATOR_CHOICE_LANG'			=> $mxp_translator->lang('TRANSLATOR_CHOICE_LANG'),
			'L_TRANSLATOR_CHOICE_LANG_EXPLAIN'	=> $mxp_translator->lang('TRANSLATOR_CHOICE_LANG_EXPLAIN'),
			
			'TRANSLATOR_DEFAULT_LANG'	=> (isset($board_config['translator_default_lang'])) ? $board_config['translator_default_lang'] : 'error',
			'TRANSLATOR_CHOICE_LANG'	=> (isset($board_config['translator_choice_lang'])) ? $board_config['translator_choice_lang'] : 'error',
		));
		$template->pparse('body');
		global $mx_backend, $db; //decapritated use if(is_object($db)){	$db->sql_close(); } in page_header_admin.php
		require_once($mx_root_path . 'admin/page_footer_admin.' . $phpEx);
}
?>