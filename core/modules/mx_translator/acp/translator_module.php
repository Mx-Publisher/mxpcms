<?php
/**
 *
 * Lnaguage Tools Extension for the phpBB Forum Software package
 *
* @copyright (c) orynider <http://mxpcms.sourceforge.net>
* @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
namespace orynider\mx_translator\acp;

/*
if ( !empty( $setmodules))
{	
	$module['Language_tools']['ACP_TRANSLATOR_CONFIG'] = mx_append_sid( $admin_module_root_path . $basename . '?modes=config');	
	$module['Language_tools']['ACP_TRANSLATE_MX_PORTAL'] = mx_append_sid( $admin_module_root_path . $basename . '?s=MXP&modes=translate');
	$module['Language_tools']['ACP_TRANSLATE_MX_MODULES'] = mx_append_sid( $admin_module_root_path . $basename . '?s=MODS&modes=translate');
	$module['Language_tools']['ACP_TRANSLATE_PHPBB_LANG'] = mx_append_sid( $admin_module_root_path . $basename . '?s=PHPBB&modes=translate');
	$module['Language_tools']['ACP_TRANSLATE_PHPBB_EXT'] = mx_append_sid( $admin_module_root_path . $basename . '?s=phpbb_ext&modes=translate');		
	return;
}
*/

/**
* mx_langtools ACP module
 */
$basename = basename( __FILE__);
$mx_root_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $phpbb_root_path;
$module_root_path = $phpbb_root_path . 'ext/orynider/mx_translator/';
$admin_module_root_path = $module_root_path . 'acp/';		
$phpEx = substr( __FILE__, strrpos( __FILE__, '.') + 1);
define('MODULE_URL', PHPBB_URL . 'ext/orynider/mx_translator/');		
//define('IN_AJAX', (isset($_GET['ajax']) && ($_GET['ajax'] == 1) && ($_SERVER['HTTP_SEREFER'] = $_SERVER['PHP_SELF'])) ? 1 : 0);
define('IN_PORTAL', 1);
define('IN_ADMIN', 1);

$no_page_header = 'no_page_header';
//require_once($mx_root_path . 'admin/pagestart.' . $phpEx);
//include_once($module_root_path . 'includes/translator.' . $phpEx);

//@error_reporting( E_ALL || !E_NOTICE);
//$mxp_translator = new mxp_translator();
/**
* Class  mxp_translator_module extends mxp_translator
* Displays a message to the user and allows him to send an email
*/
class translator_module
{
	var	$tpl_name;
	var	$page_title;
	var	$request;
	var	$config;
	var	$lang;
	var	$log;
	var	$template;
	var	$user;
	
	var $u_action;
	var $parent_id = 0;	
	/**#@+
	 * mx_user class specific vars
	 *
	 */
	var $template_path = 'templates/';
	var $theme = array(); 
	var $template_name = '';
	var $template_names = array();
	
	var $default_template_name = 'all';
	
	var $default_current_template_path = '';
	var $default_current_style_path = '';
	
	var $user_current_template_path = '';	
	var $user_current_style_path = '';

	var $style_name = '';	
	var $style_path = 'styles/';	
	
	var $default_style_name = 'prosilver';
	var $default_style2_name = 'subsilver2';	
	
	var $default_module_style = '';
	var $module_lang_path = 'ext/orynider/mx_langtools/language/';

	var $is_admin = false;
	var $keyoptions = false;
	
	function main($id, $mode = 'generate')
	{
		global $user, $template, $request;
		global $config, $phpbb_container;
		
		/** @var \phpbb\language\language $lang */
		$this->lang = $phpbb_container->get('language');
		/** @var \phpbb\request\request $request */
		$this->request = $phpbb_container->get('request');
		/** @var \phpbb\log\log $log */		
		$this->log = $phpbb_container->get('log');

		// Requests
		$action = $request->variable('action', '');
		$page_id = $request->variable('page_id', 0);
		$currency_id = $request->variable('currency_id', 0);		
		
		/* general vars */
		$mode = $request->variable('mode', $mode);
		$start = $request->variable('start', 0);  
		$s = $request->variable('mode', 'generate');	
		/* */	
		
		/* Get an instance of the admin controller */
		$mxp_translator = $phpbb_container->get('orynider.mx_translator.admin.controller');
	
		// Make the $u_action url available in the admin controller
		//$mxp_translator->set_page_url($this->u_action);

		/** Load the "settings" or "manage" module modes **/
		switch ($mode)
		{
			case 'config':
				// Load a template from adm/style for our ACP page
				$this->tpl_name = 'acp_translator_config';
				// Set the page title for our ACP page
				$this->page_title = $this->lang->lang('ACP_TRANSLATOR');	
				// Load the display options handle in the admin controller 
				$mxp_translator->display_settings($this->tpl_name, $this->page_title);				
			break;
			case 'translate':
			default:
				switch ($s)
				{	
					case 'MXP':
						// Load a template from adm/style for our ACP page
						$this->tpl_name = 'lang_translate';
						// Set the page title for our ACP page
						$this->page_title = $this->lang->lang('ACP_TRANSLATE_MX_PORTAL');
						// Load the display options handle in the admin controller 
						$mxp_translator->display_translate($this->tpl_name, $this->page_title);
					break;			
					case 'MODS':
						// Load a template from adm/style for our ACP page
						$this->tpl_name = 'lang_translate';
						// Set the page title for our ACP page
						$this->page_title = $this->lang->lang('ACP_TRANSLATE_MX_MODULES');
						// Load the display options handle in the admin controller 
						$mxp_translator->display_translate($this->tpl_name, $this->page_title);
					break;			
					case 'PHPBB':
						// Load a template from adm/style for our ACP page
						$this->tpl_name = 'lang_translate';
						// Set the page title for our ACP page
						$this->page_title = $this->lang->lang('ACP_TRANSLATE_PHPBB_LANG');
						// Load the display options handle in the admin controller 
						$mxp_translator->display_translate($this->tpl_name, $this->page_title);
					break;			
					case 'phpbb_ext':
						// Load a template from adm/style for our ACP page
						$this->tpl_name = 'lang_translate';
						// Set the page title for our ACP page
						$this->page_title = $this->lang->lang('ACP_TRANSLATE_PHPBB_EXT');
						// Load the display options handle in the admin controller 
						$mxp_translator->display_translate($this->tpl_name, $this->page_title);
					break;
				}		
			break;	
					
		}				
	}
}	// class mx_user
// THE END
