<?php
/**
 *
 * Lnaguage Tools Extension for the phpBB Forum Software package
 * @author culprit_cz
* @copyright (c) orynider <http://mxpcms.sourceforge.net>
* @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
//namespace orynider\mx_translator\controller;
if (!defined('IN_PHPBB'))
{
	exit;
}
//use Symfony\Component\DependencyInjection\ContainerInterface;
//use orynider\mx_translator\google_translater;
define('MXP_LANG_TOOLS_COOKIE_NAME', 'lT_');
/**
 * mxp_translator
 * 
 * @package Translator
 * @author culprit_cz
 * @copyright Copyright (c) 2008
 * @version $Id: mxp_translator.php,v 1.5 2008/02/29 15:36:48 orynider Exp $
 * @access public
 */
class mxp_translator
{
	var $page_title;
	var $tpl_name;
	var $u_action;
	var $parent_id = 0;	
	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;
	/** @var \phpbb\config\config */
	protected $config;
	/** @var ContainerInterface */
	protected $container;
	/** @var \phpbb\controller\helper */
	protected $helper;
	/** @var \phpbb\db\driver\driver_interface */
	protected $db; 
	/** @var \phpbb\log\log */
	protected $log;
	/** @var \phpbb\request\request 
	        $_GET = $this->request->query->all();
	        $_POST = $this->request->request->all();
	        $_SERVER = $this->request->server->all();
	        $_COOKIE = $this->request->cookies->all();
	**/	
	protected $request;
	/** @var \phpbb\template\template */
	protected $template;
	/** @var \phpbb\user */
	protected $user;
	/** @var string phpBB root path */
	protected $root_path;
	protected $phpbb_admin_path;
	/** @var string forum root path */
	protected $forum_root_path;
	/** @var string portal_backend */	
	var $backend;
	/** @var string */
	protected $table_prefix;	
	/** @var string phpEx */
	protected $php_ext;
    /**
	* Server and execution environment parameters ($_SERVER).
	*
	* @var \Symfony\Component\HttpFoundation\ServerBag
	*/
	public $get;
	public $post;	
	public $server;	
	public $cookie;
	
	var $language_list = array();
	var $forum_language_list = array();	
	var $module_list = array();
	var $language_file_list = array();
	/** @var \phpbb\language\language */
	var $lang = array();

	var $orig_ary = array();
	var $tran_ary = array();
	var $g_ary = array();
	var $language_from = '';
	var $langauge_into = '';
	var $module_select = '';
	var $module_file   = '';
	
	var $file_encoding = 'UTF-8';
	
	var $file_save_path = '';
	var $file_save_content = '';
	/**
	 * Constructor
	 *
	 * @param \phpbb\cache\driver\driver_interface  $cache
	 * @param \phpbb\config\config                  $config
	 * @param ContainerInterface                    $container
	 * @param \phpbb\controller\helper              $helper
	 * @param \phpbb\db\driver\driver_interface     $db
	 * @param \phpbb\language\language              $lang
	 * @param \phpbb\log\log                        $log
	 * @param \phpbb\request\request                $request
	 * @param \phpbb\template\template              $template
	 * @param \phpbb\user                           $user
	 * @param string                                $root_path
	 * @param string                                $php_ext
	 */
	public function __construct_(\phpbb\cache\driver\driver_interface $cache, \phpbb\config\config $config, ContainerInterface $container, \phpbb\controller\helper $helper, \phpbb\db\driver\driver_interface $db, \phpbb\language\language $lang, \phpbb\log\log $log, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $table_prefix, $php_ext, $server = array())
	{
		$this->cache = $cache;
		$this->config = $config;
		$this->container = $container;
		$this->helper = $helper;
		$this->db = $db;
		$this->lang = array();
		$this->log = $log;
		$this->request = $request;
		$this->s = $request->variable('mode', 'generate');
		$this->l = $request->variable('l', array('ENCODING' => 'UTF-8'));
		/** POST 64 & GET 128 **/
		//$this->l = $this->phpbb_read('l', ($type | 64 | 128), '', false);
		
		/* set language_from to translator_default_lang */
		$this->language_from = (isset($this->config['translator_default_lang'])) ? $this->config['translator_default_lang'] : 'en'; 
		$this->translator_choice_lang = (isset($this->config['translator_choice_lang'])) ? $this->config['translator_choice_lang'] : '';
		
		// Requests
		$this->action = $request->variable('action', '');
		$this->page_id = $request->variable('page_id', 0);
		$this->currency_id = $request->variable('currency_id', 0);		
		
		/* general vars */
		$this->mode = $request->variable('mode', 'generate');
		$this->start = $request->variable('start', 0); 
		
		$this->set_file = $request->variable('set_file', '');
		$this->into = $request->variable('into', '');
		$this->ajax = $request->variable('ajax', 0);
		
		/** **/
		$this->cookies	= array();		
		$this->template = $template;
		$this->user = $user;
		$this->language	= $language;		
		$this->root_path = $root_path;
		$this->forum_root_path = $root_path;
		$this->table_prefix = $table_prefix;
		$this->phpbb_admin_path = $root_path . 'adm/';	
		$this->php_ext = $php_ext;
		$this->mx_root_path = file_exists('./../../mx_meta.inc') ? './../../' : $root_path;
		/*
		* Read main mxp config file
		*/
		include_once($this->mx_root_path . 'config.' . $php_ext);
		$this->mx_table_prefix = !empty($mx_table_prefix) ? $mx_table_prefix : 'mx_';
		define('MXP_MODULE_TABLE', $mx_table_prefix . 'module');
		
		$this->module_root_path = $root_path . 'ext/orynider/mx_translator/';
		//print_r($this->forum_root_path);
		if (!empty($config['version'])) 
		{
			if ($config['version']  >= '4.0.0')
			{			
				$this->backend = 'phpbb4';
			}		
			if (($config['version']  >= '3.3.0') && ($config['version'] < '4.0.0'))
			{			
				$this->backend = 'proteus';
			}
			if (($config['version']  >= '3.2.0') && ($config['version'] < '3.3.0'))
			{			
				$this->backend = 'rhea';
			}
			if (($config['version']  >= '3.1.0') && ($config['version'] < '3.2.0'))
			{			
				$this->backend = 'ascraeus';
			}
			if (($config['version']  >= '3.0.0') && ($config['version'] < '3.1.0'))
			{			
				$this->backend = 'olympus';
			}
			if (($config['version']  >= '2.0.0') && ($config['version'] < '3.0.0'))
			{			
				$this->backend = 'phpbb2';
			}
			if (($config['version']  >= '1.0.0') && ($config['version'] < '2.0.0'))
			{			
				$this->backend = 'phpbb';
			}			
		}
		else if (!empty($config['portal_backend']))
		{			
			$this->backend = $config['portal_backend'];
		}
		else
		{			
			$this->backend = 'internal';
		}
		
		$this->portal_block = isset($config['portal_backend']) ? true : false;
		
		if ($config['version'] < '3.1.0')
		{			
			define('EXT_TABLE',	$table_prefix . 'ext');
		}
		
		$this->trans = $this->container->get('orynider.mx_translator.googletranslater');
		
		$language = $this->request->variable('language', array('into' => 'en'));
		$translate = $this->request->variable('translate', array('module' => 'modules/mx_translator/', 'file' => 'common.php'));
		$this->language_into = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'language_into', $language['into']);
		$this->dir_select_from = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_from', $translate['dir']);
		$this->dir_select_into = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_into', $translate['dir']);
		$this->dir_select = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select', $translate['dir']);
		$this->module_select = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'module_select', $translate['module']);
		$this->module_file = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'module_file', $translate['file']);
		
		$this->phpbb_get_lang_list();
		$this->get_module_list();
		$this->get_dir_list();
		$this->get_file_list();
		
		/**
		 * SELECT encoding of language file
		 */
		if ($config['version'] < '3.0.0')
		{			
			$lang_enc = $this->_load_file_to_translate($root_path . 'language/' . $this->language_from . '/lang_main.' . $phpEx);
			$lang_enc = $this->_load_file_to_translate($root_path . 'language/' . $this->language_into . '/lang_main.' . $phpEx);
		}
		else		
		{
			$lang_enc['ENCODING'] = 'UTF-8';
		}
		//$lang_enc['ENCODING'] = 'Windows-1250';
		if (isset($lang_enc['ENCODING']) && $lang_enc != '')
		{
			$this->file_encoding = $lang_enc['ENCODING'];
		}			
		$this->file_save_path = $mx_root_path . ($this->request->variable('s', '') == 'MODS' ? $this->module_select : '') . 'language/' . $this->language_into . '/' . $this->module_file;
	}
	
	public function mxp_translator()
	{
		global $mx_cache, $board_config, $db, $table_prefix; 
		global $phpbb_root_path, $smf_root_path, $mx_root_path, $module_root_path; 
		global $php_ext, $phpEx, $lang, $mx_request_vars, $template, $mx_user;
		$this->cache = $mx_cache;
		$this->config = $board_config;
		$this->container = $mx_cache;
		$this->helper = $mx_cache;
		$this->db = $db;
		$this->lang = $lang;
		$this->log = $mx_cache;
		$this->request = $mx_request_vars;
		$this->s = $this->request->request('s', '');
		//$this->l = $this->request->request('l', '');
		/** POST 64 & GET 128 **/
		$this->l = $this->mx_read('l', ($type | 64 | 128), '', false);
		
		/* set language_from to translator_default_lang */
		$this->language_from = (isset($this->config['translator_default_lang'])) ? $this->config['translator_default_lang'] : 'lang_english'; 
		$this->translator_choice_lang = (isset($this->config['translator_choice_lang'])) ? $this->config['translator_choice_lang'] : '';
				
		// Requests
		$this->action = $this->request->request('action', '');
		$this->page_id = $this->request->request('page_id', 0);
		$this->currency_id = $this->request->request('currency_id', 0);		
		
		/* general vars */
		$this->mode = $this->request->request('mode', 'generate');
		$this->start = $this->request->request('start', 0);
		
		$this->ajax = $this->request->request('ajax', 0);		
		$this->set_file = $this->request->request('set_file', '');
		$this->into = $this->request->request('into', '');		
		$this->cookies	= array();		
        $this->server = $_SERVER; //new ServerBag($server);		
		$this->template = $template;
		$this->user = $mx_user;
		$this->language	= $mx_user->lang;		
		$this->root_path = !empty($root_path) ? $root_path : $mx_root_path;
		$this->phpbb_admin_path = $root_path . 'adm/';
		$this->forum_root_path = !empty($phpbb_root_path) ? str_replace('olympus', 'rhea', $phpbb_root_path) : (!empty($smf_root_path) ? $smf_root_path : $root_path);
		$this->table_prefix = $table_prefix;
		$this->mx_table_prefix = $mx_table_prefix;
		$this->php_ext = !empty($php_ext) ? $php_ext : (!empty($phpEx) ? $phpEx : ".php");
		$this->mx_root_path = !empty($mx_root_path) ? $mx_root_path : '../' . $root_path;		
		define('MXP_MODULE_TABLE', MODULE_TABLE);
		$this->module_root_path = !empty($module_root_path) ?  $module_root_path : $mx_root_path . 'mx_translator/';
		//print_r($this->forum_root_path);
		if (!empty($board_config['version'])) 
		{
			if ($board_config['version']  >= '4.0.0')
			{			
				$this->backend = 'phpbb4';
			}		
			if (($board_config['version']  >= '3.3.0') && ($board_config['version'] < '4.0.0'))
			{			
				$this->backend = 'proteus';
			}
			if (($board_config['version']  >= '3.2.0') && ($board_config['version'] < '3.3.0'))
			{			
				$this->backend = 'rhea';
			}
			if (($board_config['version']  >= '3.1.0') && ($board_config['version'] < '3.2.0'))
			{			
				$this->backend = 'ascraeus';
			}
			if (($board_config['version']  >= '3.0.0') && ($board_config['version'] < '3.1.0'))
			{			
				$this->backend = 'olympus';
			}
			if (($board_config['version']  >= '2.0.0') && ($board_config['version'] < '3.0.0'))
			{			
				$this->backend = 'phpbb2';
			}
			if (($board_config['version']  >= '1.0.0') && ($board_config['version'] < '2.0.0'))
			{			
				$this->backend = 'phpbb';
			}			
		}
		else if (!empty($board_config['portal_backend']))
		{			
			$this->backend = $board_config['portal_backend'];
		}
		else
		{			
			$this->backend = 'internal';
		}
		
		$this->portal_block = !empty($board_config['portal_backend']) ? $board_config['portal_backend'] : false;
		
		if ($board_config['version'] < '3.1.0')
		{			
			define('EXT_TABLE',	$table_prefix . 'ext');
		}
		
		/* Get an instance of the admin controller */
		if (!include_once($module_root_path . 'google_translater/google_translater.' . $phpEx))
		{
			die('Cant find ' . $module_root_path . 'google_translater/google_translater.' . $phpEx);
		}
		$this->trans = new google_translater();			
		//$this->trans = $this->container->get('orynider.mx_translator.googletranslater');
			
		$this->language_into = $this->mxp_cookie( MXP_LANG_TOOLS_COOKIE_NAME . 'language_into', @$_POST['language']['into'] );
		$this->dir_select_from = $this->mxp_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_from', @$_POST['translate']['dir']);
		$this->dir_select_into = $this->mxp_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_into', @$_POST['translate']['dir']);
		$this->dir_select = $this->mxp_cookie( MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select', @$_POST['translate']['dir']);		
		$this->module_select = $this->mxp_cookie( MXP_LANG_TOOLS_COOKIE_NAME . 'module_select', @$_POST['translate']['module']);
		$this->module_file = $this->mxp_cookie( MXP_LANG_TOOLS_COOKIE_NAME . 'module_file'  , @$_POST['translate']['file']);
		
		$this->mxp_get_lang_list();
		$this->get_module_list();
		//print_r($this->ext_root_path);
		$this->get_dir_list();
		$this->get_file_list();
		
		/**
		 * SELECT encoding of language file
		 */
		$lang_enc = $this->_load_file_to_translate($mx_root_path . 'includes/shared/phpbb2/language/' . $this->language_from . '/lang_main.' . $phpEx);
		$lang_enc = $this->_load_file_to_translate($mx_root_path . 'includes/shared/phpbb2/language/' . $this->language_into . '/lang_main.' . $phpEx);
		
		if (isset( $lang_enc['ENCODING']) && $lang_enc != '')
		{
			$this->file_encoding = $lang_enc['ENCODING'];
		}
		else		
		{
			$this->file_encoding = 'UTF-8';
		}				
		$this->file_save_path = $mx_root_path . ( $_GET['s']=='MODS'? $this->module_select:'') . 'language/' . $this->language_into . '/' . $this->module_file;
	}
	
	/**
	 * Set and get value from posted or cookie
	 * @return mixed value generated from posted, geted or cookie
	 * @param $name string cookie name of the value
	 * @param $value mixed value which should be setted for cookie
	 */
	function phpbb_cookie($name, $value = '')
	{
		$board_config = $this->config; /* cookie_name', 'phpbb3_li1e6', 0 */
		$cookie_board_name = $name;
		$return = '';
		if ($value != '')
		{
			$return = $value;
			// Currently not working under linux machines [Ubuntu GG]
			//setcookie( $cookie_board_name, $value, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			setcookie( $cookie_board_name, $value, (time() + 21600), $board_config['cookie_path']);
			
			$this->cookie[$cookie_board_name] = $value;
			
		}
		else if(isset($_COOKIE[$cookie_board_name]))
		{
			$value = $this->cookie[$cookie_board_name] = $this->request->variable($cookie_board_name, 0, false, \phpbb\request\request_interface::COOKIE);
			// Currently not working under linux machines [Ubuntu GG]
			//setcookie( $cookie_board_name, $_COOKIE[ $cookie_board_name], (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			setcookie($cookie_board_name, $value, (time() + 21600), $board_config['cookie_path']);
			
		}
		$this->cookie['test' . $name] = $value;		
		return $value;
	}
	
	/**
	 * Set and get value from posted or cookie
	 * @return mixed value generated from posted, geted or cookie
	 * @param $name string cookie name of the value
	 * @param $value mixed value which should be setted for cookie
	 */
	function mxp_cookie($name, $value = '')
	{
		$board_config = $this->config; /* cookie_name', 'phpbb3_li1e6', 0 */
		$cookie_board_name = $name;
		$return = '';
		if ($value != '')
		{
			$return = $value;
			// Currently not working under linux machines [Ubuntu GG]
			//setcookie( $cookie_board_name, $value, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			setcookie($cookie_board_name, $value, (time() + 21600), $board_config['cookie_path']);
			
			$this->cookie[$cookie_board_name] = $value;
			
		}
		else if(isset($_COOKIE[$cookie_board_name]))
		{
			$value = $this->cookie[$cookie_board_name] = $_COOKIE[$cookie_board_name];
			// Currently not working under linux machines [Ubuntu GG]
			//setcookie( $cookie_board_name, $_COOKIE[ $cookie_board_name], (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			setcookie($cookie_board_name, $value, (time() + 21600), $board_config['cookie_path']);
			
		}	
		switch ($this->portal_block)
		{
				/* MX-Publisher Module */		
				case 'phpbb2':
				case 'internal':					
				case 'phpbb3':			
				case 'olympus':			
				case 'ascraeus':
				case 'rhea':			
				case 'proteus':
				default:			
					$this->cookie['test' . $name] = $_COOKIE['test' . $name] = $value;					
				break;
				/* phpBB Extension */
				case false:
					$this->cookie['test' . $name] = $value;					
				break;
		}		
		return $value;
	}
	/**
	 * Function: _read() from class mx_request_vars
	 * autor John Olson 
	 * Get the value of the specified request var (post or get) and force the result to be
	 * of specified type. It might also transform the result (stripslashes, htmlspecialchars) for security
	 * purposes. It all depends on the $type argument.
	 * If the specified request var does not exist, then the default ($dflt) value is returned.
	 * Note the $type argument behaves as a bit array where more than one option can be specified by OR'ing
	 * the passed argument. This is tipical practice in languages like C, but it can also be done with PHP.
	 *
	 * @access private
	 * @param unknown_type $var
	 * @param unknown_type $type
	 * @param unknown_type $dflt
	 * @return unknown
	 */
	public function mx_read($var, $type = 0, $dflt = '', $not_null = false)
	{
		if(($type & (64|128)) == 0)
		{
			$type |= (64|128);
		}

		if(($type & 64) && isset($_POST[$var]) || ($type & 128) && isset($_GET[$var]))
		{
			$val = ( ($type & 64) && isset($_POST[$var]) ? $_REQUEST[$var] : $_GET[$var]);
			if(!($type & 16))
			{
				if(is_array($val))
				{
					foreach($val as $k => $v)
					{
						$val[$k] = trim(stripslashes($v));
					}
				}
				else
				{
					$val = trim(stripslashes($val));
				}
			}
		}
		else
		{
			$val = $dflt;
		}

		if($type & 1)		// integer
		{
			return $not_null && empty($val) ? $dflt : intval($val);
		}

		if($type & 2)		// float
		{
			return $not_null && empty($val) ? $dflt : floatval($val);
		}

		if($type & 8)	// ie username
		{
			if( is_array($val) )
			{
				foreach( $val as $k => $v )
				{
					$val[$k] = htmlspecialchars(strip_tags(ltrim(rtrim($v, " \t\n\r\0\x0B\\"))));
				}
			}
			else
			{
				$val = htmlspecialchars(strip_tags(ltrim(rtrim($val, " \t\n\r\0\x0B\\"))));
			}
		}
		elseif($type & 4)	// no slashes nor html
		{
			if(is_array($val))
			{
				foreach( $val as $k => $v )
				{
					$val[$k] = htmlspecialchars(ltrim(rtrim($v, " \t\n\r\0\x0B\\")));
				}
			}
			else
			{
				$val = htmlspecialchars(ltrim(rtrim($val, " \t\n\r\0\x0B\\")));
			}
		}

		if($type & 32)
		{
			if(is_array($val))
			{
				foreach($val as $k => $v)
				{
					$val[$k] = str_replace(($type & 16 ? "\'" : "'"), "''", $v);
				}
			}
			else
			{
				$val = str_replace(($type & 16 ? "\'" : "'"), "''", $val);
			}
		}
		return $not_null && empty($val) ? $dflt : $val;
	}
	/**
	 * Function: _read() from class request_vars
	 * Get the value of the specified request var (post or get) and force the result to be
	 * of specified type. It might also transform the result (stripslashes, htmlspecialchars) for security
	 * purposes. It all depends on the $type argument.
	 * If the specified request var does not exist, then the default ($dflt) value is returned.
	 * Note the $type argument behaves as a bit array where more than one option can be specified by OR'ing
	 * the passed argument. This is tipical practice in languages like C, but it can also be done with PHP.
	 *
	 * @access private
	 * @param unknown_type $var
	 * @param unknown_type $type
	 * @param unknown_type $dflt
	 * @return unknown
	 */
	public function phpbb_read($var, $type = 0, $default = '', $not_null = false)
	{
		$super_global = \phpbb\request\request_interface::REQUEST; 
		$trim = true;
		$var = $this->request->raw_variable($var_name, $default, $super_global);
		
		// Return prematurely if raw variable is empty array or the same as
		// the default. Using strict comparison to ensure that one can't
		// prevent proper type checking on any input variable
		if ($var === array() || $var === $default)
		{
			return $var;
		}
		$this->request->type_cast_helper->recursive_set_var($var, $default, $multibyte, $trim);
		
		return $not_null && empty($var) ? $default : $var;
	}	
	/**
	 * Load available languages list
	 *
	 * @return array available languages list: KEY = folder name
	 */
	function phpbb_get_lang_list()
	{
		if (count($this->language_list))
		{
			return $this->language_list;
		}
		/* c:\Wamp\www\Rhea\language\ */
		$dir = opendir($this->forum_root_path . 'language/');			
		while($f = readdir($dir))
		{
			if (($f == '.' || $f == '..') || !is_dir($this->forum_root_path . 'language/' . $f) || $f == $this->language_from)
			{
				continue;
			}
			if ($this->language_from == '')
			{
				$this->language_from = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'language_from', $f);
			}
			$this->forum_language_list[$f] =  $this->ucstrreplace('lang_', '', $f);	
		}
		closedir($dir);
		if ($this->root_path != $this->forum_root_path)
		{	
			$dir = opendir($this->root_path . 'language/');			
			while($f = readdir($dir))
			{
				if (($f == '.' || $f == '..') || !is_dir($this->root_path . 'language/' . $f) || $f == $this->language_from)
				{
					continue;
				}
				if ($this->language_from == '')
				{
					$this->language_from = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'language_from', $f);
				}
				$this->language_list[$f] =  $this->ucstrreplace('lang_', '', $f);	
			}
			closedir($dir);
		}			
		return $this->language_list = array_merge($this->forum_language_list, $this->language_list);
	}
	
	/**
	 * Load available languages list
	 *
	 * @return array available languages list: KEY = folder name
	 */
	function mxp_get_lang_list()
	{
		if (count($this->language_list))
		{
			return $this->language_list;
		}	
		switch ($this->s)
		{
			case 'MXP':
			case 'MODS':			
				$lang_dir = $this->mx_root_path . 'language/';
				$lang_dir_ext = $this->module_root_path . 'language/';					
			break;			
			case 'PHPBB':
			case 'phpbb_ext':			
				$lang_dir_ext = $this->forum_root_path . 'language/';
				/* c:\Wamp\www\Rhea\language\ */
				$lang_dir = $this->root_path . 'language/';									
			break;
		}
		$dir = @opendir($lang_dir);		
		while($f = @readdir($dir))
		{
			if (($f == '.' || $f == '..') || !is_dir($lang_dir . $f) || $f == $this->language_from)
			{
				continue;
			}
			if ($this->language_from == '')
			{
				$this->language_from = $this->mxp_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'language_from', $f);
			}
			$this->language_list[$f] =  $this->ucstrreplace('lang_', '', $f);	
		}
		@closedir($dir);
		$this->language_list_ext = array();
		if ($lang_dir != $lang_dir_ext)
		{	
			$dir = opendir($lang_dir_ext);			
			while($f = readdir($dir))
			{
				if (($f == '.' || $f == '..') || !is_dir($lang_dir_ext . $f) || $f == $this->language_from)
				{
					continue;
				}
				if ($this->language_from == '')
				{
					$this->language_from = $this->mxp_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'language_from', $f);
				}
				$this->language_list_ext[$f] =  $this->ucstrreplace('lang_', '', $f);	
			}
			closedir($dir);
		}	
		return $this->language_list = array_merge($this->language_list, $this->language_list_ext);
	}
	
	function get_file_list($module = '')
	{
		$file_list = array();
		switch ($this->s)
		{
			case 'MXP':
				$file_list = $this->__load_lang_files('', $this->language_from);
				$this->language_file_list['MXP'] = $file_list;
			break;
			case 'MODS':
				if ($this->module_select == '')
				{
					return array();
				}
				$file_list = $this->__load_lang_files($module, $this->language_from);
				$this->language_file_list[$module] = $file_list;				
			break;			
			case 'PHPBB':
				$file_list = $this->__load_lang_files('', $this->language_from);
				$this->language_file_list['PHPBB'] = $file_list;
			break;			
			case 'phpbb_ext':
				if ($this->module_select == '')
				{
					return array();
				}
				$file_list = $this->__load_lang_files($module, $this->language_from);
				$this->language_file_list[$module] = $file_list;
			break;			
			default:
			break;
		}
		return $file_list;
	}
	
	function get_dir_list($module = '')
	{
		$dir_list = array();
		switch ($this->s)
		{
			case 'MXP':
				$dir_list = $this->__load_lang_dirs('', $this->language_from, '', $this->language_into);
				$this->language_dir_list['MXP'] = $dir_list;
			break;
			case 'MODS':
				if ($this->module_select == '')
				{
					return array();
				}
				$dir_list = $this->__load_lang_dirs($module, $this->language_from, '', $this->language_into);
				$this->language_dir_list[$module] = $dir_list;				
			break;			
			case 'PHPBB':
				$dir_list = $this->__load_lang_dirs('', $this->language_from, '', $this->language_into);
				$this->language_dir_list['PHPBB'] = $dir_list;
			break;			
			case 'phpbb_ext':
				if ($this->module_select == '')
				{
					return array();
				}
				$dir_list = $this->__load_lang_dirs($module, $this->language_from, '', $this->language_into);
				$this->language_dir_list[$module] = $dir_list;
			break;			
			default:
			break;
		}
		//print_r($dir_list);		
		return $dir_list;
	}
	
	function __load_lang_dirs($path, $lang_from = '', $add_path = '', $lang_into = '')
	{ 
		if ($this->language_from == '')
		{
			$this->language_from = $lang_from;
		}
		if ($this->language_into == '')
		{
			$this->language_into = $lang_into;
		}	
		/* root path at witch we add ie. extension path */  
		switch ($this->s)
		{
			case 'MXP':
				$root_path = $this->mx_root_path;
			break;
			case 'MODS':
				$root_path = $this->root_path;			
			break;			
			case 'PHPBB':
				$root_path = $this->forum_root_path;
			break;			
			case 'phpbb_ext':
				$root_path = $this->forum_root_path;			
			break;			
			default:
			break;
		}	
		$php_ext = $this->php_ext;
		if (!file_exists($root_path . 'mx_meta.inc') && !file_exists($root_path . 'modcp'.$php_ext))
		{
			$lang_from = $this->encode_lang($lang_from);
			if ($this->language_from == '')
			{
				$this->language_from = 'en';
			}
			if ($this->language_into == '')
			{
				$this->language_into = 'ro';
			}			
		}	
		if ($this->language_from == '')
		{
			return null;
		}	
		$lang_dirs = array();
		$folder_path = $root_path . $path . 'language/' . $lang_from;
		$folder_into = $root_path . $path . 'language/' . $lang_into;
		if ($this->dir_select_from == '')
		{
			$this->dir_select_from = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_from', $folder_path);
		}
		if ($this->dir_select_into == '')
		{
			$this->dir_select_into = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_into', $folder_into);
		}		
		$lang_dirs[$add_path . $folder_into] = $add_path . $folder_into . '/';
		$subdirs = glob($folder_path . '/*' , GLOB_ONLYDIR);
		/* * /
		for($subdir_id = 0, $count = count($subdirs); $subdir_id < $count; $subdir_id++)		
		{		
			$subdir_path = $subdirs[$subdir_id];
			if ($subdir_path == '.' || $subdir_path == '..' || $subdir_path == 'CVS')
			{
				continue;
			}			
			$lang_dirs[$add_path . $subdir_path] = $add_path . $subdir_path;
		}
		/* */
		//print_r($lang_dirs);
		/* */
		foreach($subdirs as $subdir_id => $subdir_path)
		{		

			$subdir_path = $subdirs[$subdir_id];
			if ($subdir_path == '.' || $subdir_path == '..' || $subdir_path == 'CVS')
			{
				continue;
			}
			if ($this->dir_select_from == '')
			{
				$this->dir_select_from = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_from', $folder_path .'/'. basename($subdir_path));
			}
			if ($this->dir_select_into == '')
			{
				$this->dir_select_into = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_into', $folder_into .'/'. basename($subdir_path));
			}			
			$lang_dirs[$add_path . $folder_into .'/'. basename($subdir_path)] = $add_path . $folder_into .'/'. basename($subdir_path) . '/';
			//$sub_dirs = $this->__load_lang_dirs($path, $lang_from, $add_path . '/'. $subdir);
			//$lang_dirs = array_merge($lang_dirs, $sub_dirs);				
		}
		/* */
		//print_r($lang_dirs);		
		return $lang_dirs;
	}
	
	function __load_lang_dir($path, $lang_from = '', $add_path = '', $lang_into = '', $dir_select = 'language_from')
	{ 
		if ($this->language_from == '')
		{
			$this->language_from = $lang_from;
		}
		if ($this->language_into == '')
		{
			$this->language_into = $lang_into;
		}	
		/* root path at witch we add ie. extension path */  
		switch ($this->s)
		{
			case 'MXP':
				$root_path = $this->mx_root_path;
			break;
			case 'MODS':
				$root_path = $this->root_path;			
			break;			
			case 'PHPBB':
				$root_path = $this->forum_root_path;
				$this->language_from = (isset($this->config['translator_default_lang'])) ? $this->config['translator_default_lang'] : 'en';
			break;			
			case 'phpbb_ext':
				$root_path = $this->forum_root_path;
				$this->language_from = (isset($this->config['translator_default_lang'])) ? $this->config['translator_default_lang'] : 'en';				
			break;			
			default:
			break;
		}	
		$php_ext = $this->php_ext;
		if (!file_exists($root_path . 'mx_meta.inc') && !file_exists($root_path . 'modcp'.$php_ext))
		{
			$lang_from = $this->encode_lang($lang_from);
			if ($this->language_into == '')
			{
				$this->language_into = 'ro';
			}			
		}	
		if ($this->language_from == '')
		{
			return null;
		}	
		$lang_dirs = array();
		$folder_from = $root_path . $path . 'language/' . $lang_from;
		$folder_into = $root_path . $path . 'language/' . $lang_into;
		$this->dir_select_from = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_from', $folder_from);
		$this->dir_select_into = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_into', $folder_into);
		$subdirs = glob($folder_from . '/*' , GLOB_ONLYDIR);
		/* */
		foreach($subdirs as $subdir_id => $subdir_from)
		{		

			$subdir_from = $subdirs[$subdir_id];
			if ($subdir_from == '.' || $subdir_from == '..' || $subdir_from == 'CVS')
			{
				continue;
			}
			$this->dir_select_from = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_from', $folder_from .'/'. basename($subdir_from));
			$this->dir_select_into = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_into', $folder_into .'/'. basename($subdir_from));
			//$sub_dirs = $this->__load_lang_dirs($path, $lang_from, $add_path . '/'. $subdir);
			//$lang_dirs = array_merge($lang_dirs, $sub_dirs);				
		}
		/* */
		//print_r($this->dir_select_from);		
		return ($dir_select == 'language_from') ? $this->dir_select_from : $this->dir_select_into;
	}
	
	function __load_lang_files($path, $language, $add_path = '', $dir_select = '')
	{ 
		if (($this->dir_select_from == $this->dir_select_into) && ($this->language_from !== $this->language_into))
		{
			$this->dir_select_from = str_replace($this->language_into, $this->language_from, $this->dir_select_from);
			$this->dir_select_from = ($this->trisstr('\.' . $php_ext . '$', $this->dir_select_from) == false) ? $this->dir_select_from : dirname($this->dir_select_from);
			$this->dir_select_into = ($this->trisstr('\.' . $php_ext . '$', $this->dir_select_into) == false) ? $this->dir_select_into : dirname($this->dir_select_into);
		}
		/* root path at witch we add ie. extension path */  
		switch ($this->s)
		{
			case 'MXP':
				$root_path = $this->mx_root_path;
			break;
			case 'MODS':
				$root_path = $this->root_path;			
			break;			
			case 'PHPBB':
				$root_path = $this->forum_root_path;
			break;			
			case 'phpbb_ext':
				$root_path = $this->forum_root_path;			
			break;			
			default:
			break;
		}		
		$php_ext = $this->php_ext;
		if (!file_exists($root_path . 'mx_meta.inc') && !file_exists($root_path . 'modcp'.$php_ext))
		{
			$language = $this->encode_lang($language);
			if ($this->language_from == '')
			{
				$this->language_from = 'en';
			}			
		}	
		if ($this->language_from == '')
		{
			return null;
		}
		
		$lang_files = array();
		$folder_path = $root_path . $path . 'language/' . $language . '/' . $add_path;	
		$folder_from = $root_path . $path . 'language/' . $this->language_from;
		$folder_into = $root_path . $path . 'language/' . $this->language_into;
		$subdir_select_from = $this->dir_select_from;
		$subdir_select_into = $this->dir_select_into;
		$subdirs = glob($folder_from . '/*' , GLOB_ONLYDIR);		
		/* */
		foreach($subdirs as $subdir_id => $subdir_from)
		{		

			$subdir_from = $subdirs[$subdir_id];
			if ($subdir_from == '.' || $subdir_from == '..' || $subdir_from == 'CVS')
			{
				continue;
			}
			$subdir_select_from = $this->dir_select_from = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_from', $folder_from .'/'. basename($subdir_from));
			$subdir_select_into = $this->dir_select_into = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select_into', $folder_into .'/'. basename($subdir_from));
			//$sub_dirs = $this->__load_lang_dirs($path, $lang_from, $add_path . '/'. $subdir);
			//$lang_dirs = array_merge($lang_dirs, $sub_dirs);				
		}
		/* */		
		if (!is_dir($folder_path . '/'))
		{
			$dir = 'Resource id #53'.'Resource id #54'.'Resource id #55'.'Resource id #56'.'Resource id #57'.'Resource id #58';
			return array_merge(array('common.php' => 'common.php', 'info_acp_translator.php' => 'info_acp_translator.php', 'lang_admin.php' => 'lang_admin.php'),  array ('lang_admin.php' => 'lang_admin.php', 'lang_main.php' => 'lang_main.php', 'lang_meta.php' => 'lang_meta.php'));
		}
		else
		{
			$dir = opendir($folder_path);
		}
		while($file = @readdir($dir))
		{
			if ( $file == '.' || $file == '..' || $file == 'CVS')
			{
				continue;
			}
			
			if (is_dir($folder_path . '/' . $file))
			{
			
				$sub_files = $this->__load_lang_files($path, $language, $add_path . '/'. $file);
				$lang_files = array_merge($lang_files, $sub_files);
			}
			else if( is_file($folder_path . '/' . $file))
			{
				$lang_files[$add_path . (!empty($add_path) ? '/' : '') . $file] = $add_path . (!empty($add_path) ? '/' : '') . $file;
			}
		}
		@closedir($dir);
		if (is_dir($subdir_select_from . '/') && is_array($subdirs))
		{
			$subdir = opendir($subdir_select_from);
		}
		while($file = @readdir($subdir))
		{
			//if ( $file == '.' || $file == '..' || $file == 'CVS' || ($this->trisstr('\.' . $php_ext . '$', $file) == false) )
			if ($file == '.' || $file == '..' || $file == 'CVS')
			{
				continue;
			}
			if(is_file($subdir_select_from . '/' . $file))
			{
				$sub_files[$add_path . (!empty($add_path) ? '/' : '') . $file] = $add_path . (!empty($add_path) ? '/' : '') . $file;
				$lang_files = array_merge($lang_files, $sub_files);
			}
		}
		@closedir($subdir);		
		return $lang_files;
	}
	
	function get_module_list()
	{ 
		global $db;
		$file_list = array();
		$module_list = array();
		
		switch ($this->s)
		{
			case 'MXP':
			case 'MODS':				
				$sql = "SELECT module_path, module_name FROM " . MXP_MODULE_TABLE . " ORDER BY module_name";
				if (($rs = $this->db->sql_query($sql)))
				{
					while($row = $this->db->sql_fetchrow($rs))
					{
						$dir_list = $this->__load_lang_dirs($row['module_path'], $this->language_from, '', $this->language_into);
						$file_list = $this->__load_lang_files($row['module_path'], $this->language_from);
						//print_r($dir_list);
						if (count( $file_list) == 0)
						{
							continue;
						}
						if ($this->dir_select == '')
						{
							$this->dir_select = $this->mxp_cookie( MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select', $row['module_path']);
							
						}
						if ($this->module_select == '')
						{
							$this->module_select = $this->mxp_cookie( MXP_LANG_TOOLS_COOKIE_NAME . 'module_select', $row['module_path']);
							
						}						
						$this->ext_root_path = $this->mx_root_path . $row['module_path'];						
						$this->module_list[$row['module_path']] = $row['module_name'];
						$this->module_name = print_r($row['module_name'], true);
						$this->language_dir_list[$row['module_path']] = $dir_list;
						$this->language_file_list[$row['module_path']] = $file_list;
					}	
				}
				else
				{				
					$this->ext_root_path = $this->mx_root_path;
				}				
			break;			
			case 'PHPBB':
			case 'phpbb_ext':
				/* c:\Wamp\www\Rhea\language\ */
				$lang_dir = $this->forum_root_path . 'language/';

				// Now only pull the data of the requested topics
				$sql_array = array(
					'SELECT'    => 'e.*',
					'FROM'      => array(EXT_TABLE => 'e'),
				); 			
				$sql = $this->db->sql_build_query('SELECT', $sql_array);
				$rs = $this->db->sql_query_limit($sql, 10);
				$file_list = array();
				$row = $this->db->sql_fetchrow($rs);
				$row['module_path'] = 'ext/' . $row['ext_name'] . '/';
				$this->ext_root_path = $this->forum_root_path . $row['module_path'];
				$dir_list = $this->__load_lang_dirs($row['module_path'], $this->language_from, '', $this->language_into);
				$file_list = $this->__load_lang_files($row['module_path'], $this->language_from);
				if (count($file_list) == 0)
				{
					continue;
				}
				if ($this->dir_select == '')
				{
					$this->dir_select = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'dir_select', $row['module_path']);
				}				
				if ($this->module_select == '')
				{
					$this->module_select = $this->phpbb_cookie(MXP_LANG_TOOLS_COOKIE_NAME . 'module_select', $row['module_path']);
						
				}
				$module_name = explode('/', $row['ext_name']);
				$row['module_name'] = $module_name[1];
				$module_name = explode('/', $row['ext_name']);
				$vendor = $module_name[0];
				$counthost = count($module_name) - 1;
				$docid2 = $module_name[$counthost];
				$this->module_list[$row['module_path']] = $row['module_name'];
				$this->module_name = print_r($row['module_name'], true);
				$this->language_dir_list[$row['module_path']] = $dir_list;
				$this->language_file_list[$row['module_path']] = $file_list;
				$this->db->sql_freeresult($rs);
			break;			
		}
				
		return $this->module_list;
	}
	
	/**
	 * Generate option list
	 * @return HMTML option list
	 * @param $html string generate option list in HTML or JS format /now available only HTML/
	 * @param $which_list string which option list should be generated /'
	 * @param $selected string key of selected item
	 * @param $disabled mixed list of disabed key items
	 * @param $from_select boolean is the list initial?
	 */
	function gen_select_list($html, $which_list, $selected = '', $disabled = '')
	{
		switch ($which_list)
		{
			case 'language':
				$list_ary = $this->language_list;
			break;
			case 'modules':
				$list_ary = $this->module_list;
			break;
			case 'phpbb_ext':
				$list_ary = $this->module_list;
			break;			
			case 'phpbb':
				$list_ary = $this->language_file_list['PHPBB'];
			break;
			case 'core':
				$list_ary = $this->language_file_list['MXP'];
			break;			
			case 'files':
				switch($this->s)
				{
					case 'MXP':
						$list_ary = $this->language_file_list['MXP'];
					break;
					case 'PHPBB':
						$list_ary = $this->language_file_list['PHPBB'];
					break;					
					case 'MODS':
						$list_ary = $this->language_file_list[$this->module_select];
					break;
					case 'phpbb_ext':
						$list_ary = $this->language_file_list[$this->module_select];
					break;					
				}
			break;
			case 'dirs':
				switch($this->s)
				{
					case 'MXP':
						$list_ary = $this->language_dir_list['MXP'];
					break;
					case 'PHPBB':
						$list_ary = $this->language_dir_list['PHPBB'];
					break;					
					case 'MODS':
						$list_ary = $this->language_dir_list[$this->dir_select];
					break;
					case 'phpbb_ext':
						$list_ary = $this->language_dir_list[$this->dir_select];
					break;
					default:
						$list_ary = $this->language_dir_list[$this->dir_select];
					break;						
				}			
			break;			
			default:
				return '';
			break;
		}	
		if (count($list_ary) < 1)
		{
			return '';
		}
		asort($list_ary);
		reset($list_ary);
		$option_list = '';
		$num_args = func_num_args();
		
		switch ($html)
		{
			case 'html':
				foreach($list_ary as $key => $value)
				{
					if ((is_array( $disabled) && in_array( $key, $disabled)) || (!is_array( $disabled) && $key == $disabled))
					{
						continue;
					}
					$option_list .= '<option value="' . $key . '"';
					if ( $selected == $key )
					{
						$option_list .= ' selected';
					}				
					$option_list .= '>' . $value . '</option>';
				}
			break;
			case 'in_array':			
			default:
				foreach($list_ary as $key => $value)
				{
					if ((is_array( $disabled) && in_array( $key, $disabled)) || (!is_array( $disabled) && $key == $disabled))
					{
						continue;
					}
					if (empty($key) || empty($value))
					{
						return '';
					}					
					$option_list .= '<option value="' . $key . '"';
					if ( $selected == $key )
					{
						$option_list .= ' selected';
					}				
					$option_list .= '>' . $value . '</option>';
				}
			break;			
		}
		return $option_list;
	}
	
	function _load_lang($path, $filename, $require = true)
	{
		$board_config = $this->config;
		$mx_user = $this->user;
		$root_path = $this->root_path;		
		$php_ext = $this->php_ext;

		// Now only the root for mxp blocks
		$user_path = $path . 'language/lang_' . $mx_user->data['user_lang'] . '/' . $filename . '.' . $php_ext;
		$board_path = $path . 'language/lang_' . $board_config['default_lang'] . '/' . $filename . '.' . $php_ext;
		$default_path = $path . 'language/lang_english/' . $filename . '.' . $php_ext;
				
		$phpbb_user_path = $path . 'language/' . $mx_user->data['user_lang'] . '/' . $filename . '.' . $php_ext;
		$phpbb_board_path = $path . 'language/' . $board_config['default_lang'] . '/' . $filename . '.' . $php_ext;
		$phpbb_default_path = $path . 'language/en/' . $filename . '.' . $php_ext;		
		
		$lang = array();
		if (file_exists($user_path))
		{
			include_once($user_path);
		}
		else if ($require)
		{
			if (file_exists($board_path))
			{
				include_once($board_path);
			}
			else if (file_exists($default_path))
			{
				include_once($default_path);
			}
		}
		else if (file_exists($phpbb_user_path))
		{
			include_once($phpbb_user_path);
		}
		else if ($require)
		{
			if (file_exists($phpbb_board_path))
			{
				include_once($phpbb_board_path);
			}
			else if (file_exists($phpbb_default_path))
			{
				include_once($phpbb_default_path);
			}
		}		
		$this->lang = array_merge($this->lang, $lang);
	}
	
	/**
	 * Loads common language files
	 */
	protected function load_common_language_files()
	{
		if (!$this->common_language_files_loaded)
		{
			switch ($this->portal_block)
			{
				/* MX-Publisher Module */		
				case 'phpbb2':
				case 'internal':					
				case 'phpbb3':			
				case 'olympus':			
				case 'ascraeus':
				case 'rhea':			
				case 'proteus':
				default:			
					$this->_load_lang($this->module_root_path, 'lang_admin');					
				break;
				/* phpBB Extension */
				case false:
					$this->_load_lang($this->module_root_path, 'acp/common');
					$this->_load_lang($this->module_root_path, 'info_acp_translator');					
				break;
			}
			$this->common_language_files_loaded = true;
		}
	}	
	
	function assign_template_vars(&$template, $xs_compat = true)
	{
		/* Load common language files if they not loaded yet */
		if (!$this->common_language_files_loaded)
		{
			$this->load_common_language_files();							
		}
		/* */
		/* We keep this decapritated variable for use outside 
		/* the mxp_translator() class. 
		/* */
		if(!is_object($template))
		{
			$template = $this->template;
		}		
		reset($this->lang);
		foreach($this->lang as $key => $value)
		{		
			// Check compat
			if($xs_compat == false)
			{
				$template->assign_var('L_' . strtoupper($key), $value);
			}
			else			
			{
				$template->assign_var('L_' . strtoupper($key), $value);
			}
		}
	}
	
	function file_translate()
	{
		$lang = $this->lang;

		switch ($this->s)
		{
			case 'MXP':
				$root_path = $this->mx_root_path;
			break;			
			case 'MODS':				
				$root_path = $this->mx_root_path; //. $this->ext_root_path;
			break;			
			case 'PHPBB':
				$root_path = $this->forum_root_path;
			break;			
			case 'phpbb_ext':
				$root_path = $this->forum_root_path; //. $this->ext_root_path;
			break;			
		} 
		$template = $this->template;
		
		if (!isset($_POST['set_file']))
		{
			return;
		}
		
		$original_file_path1 = (($this->s == 'MODS') ? $this->module_select : ($this->s == 'phpbb_ext' ? $this->module_select : '')) . (!empty($this->gen_select_list('in_array', 'dirs')) ? $this->dir_select_from : 'language/' . $this->language_from) . '/' . $this->module_file;
		$translate_file_path1 = (($this->s == 'MODS') ? $this->module_select : ($this->s == 'phpbb_ext' ? $this->module_select : '')) . (!empty($this->gen_select_list('in_array', 'dirs')) ? $this->dir_select_into : 'language/' . $this->language_into) . '/' . $this->module_file;		
		$original_file_path = (($this->s == 'MODS') ? $this->module_select : ($this->s == 'phpbb_ext' ? $this->module_select : '')) . 'language/' . $this->language_from . '/' . $this->module_file;
		$translate_file_path = (($this->s == 'MODS') ? $this->module_select : ($this->s == 'phpbb_ext' ? $this->module_select : '')) . 'language/' . $this->language_into . '/' . $this->module_file;
		//$original_file_content = file_get_contents($this->file_save_path);
		//$original_file_content = file_get_contents($original_file_path);
		//print($this->_get_file_perms($mx_root_path . $original_file_path));
		
		$this->template->assign_vars(array( //#
			'FILE_FULL_ROOT_PATH_ORIGINAL' => '/' . (count($this->_load_file_to_translate($original_file_path1)) == 0) ? ((count($this->_load_file_to_translate($root_path . $original_file_path1)) == 0) ? $root_path . $original_file_path : $root_path . $original_file_path1) : $original_file_path1,
			'FILE_FULL_ROOT_PATH_TRANSLATE' => '/' . (count($this->_load_file_to_translate($translate_file_path1)) == 0) ? ((count($this->_load_file_to_translate($root_path . $translate_file_path1)) == 0) ? $root_path . $translate_file_path : $root_path . $translate_file_path1) : $translate_file_path1,
			'FILE_IS_WRITABLE' => $this->__is_writable($root_path . $translate_file_path) ? '1' : '0',
			'ENCODING' => $this->file_encoding,			
		));
		$this->orig_ary = (count($this->_load_file_to_translate($original_file_path1)) == 0) ? ((count($this->_load_file_to_translate($root_path . $original_file_path1)) == 0) ? $this->_load_file_to_translate($root_path . $original_file_path) : $this->_load_file_to_translate($root_path . $original_file_path1)) : $this->_load_file_to_translate($original_file_path1);
		$this->tran_ary = (count($this->_load_file_to_translate($translate_file_path1)) == 0) ? ((count($this->_load_file_to_translate($root_path . $translate_file_path1)) == 0) ? $this->_load_file_to_translate($root_path . $translate_file_path) : $this->_load_file_to_translate($root_path . $translate_file_path1)) : $this->_load_file_to_translate($translate_file_path1);
		//dprint_r($this->orig_ary);
		//dprint_r(' ');
		//dprint_r($this->tran_ary);
		if (count($this->orig_ary) == 0)
		{				
			/* nic neni v souboru */ 
			die('v souboryu nic neni');
			return;
		}
		else
		{
			$cache_key = $this->module_name . '_' . $this->language_into . '_' . $this->module_file; 
			$this->g_ary = !empty($this->cache->get($cache_key)) ? $this->cache->get($cache_key) : $this->trans->translate($this->orig_ary, $this->encode_lang($this->language_from), $this->encode_lang($this->language_into));
			//$this->g_ary = $this->trans->translate($this->orig_ary, $this->encode_lang($this->language_from), $this->encode_lang($this->language_into));
			if (!empty($this->g_ary)) 
			{			
				$this->cache->put($cache_key, $this->g_ary, 86400); // 24 hours						
			}
			//print_r($this->g_ary);			
			$counter = 0;
			$counter_a = 0;
			//foreach($this->g_ary as $g_key => $g_value)	{  }			
			foreach($this->orig_ary as $l_key => $l_value)
			{				
				/*
				if (count(is_null($this->g_ary[$l_key])) == count($this->g_ary[$l_key]))
				{
					$this->g_ary = $this->trans->translate($this->orig_ary, $this->language_from, $this->language_into);
					if (!empty($this->g_ary)) 
					{			
						$this->cache->put($cache_key, $this->g_ary, 86400); // 24 hours						
					}					
				}
				*/
				if (is_array($l_value))
				{
				    /*Convert the array to a string */
				    $orig_ary_string = print_r($l_value, true);				
				}
				if (isset($_POST['copy_selected']))
				{
				    /* Copy the google arrays */				
					$this->tran_ary[$l_key] = $this->g_ary[$l_key];
				}					
				if (is_array($this->tran_ary[$l_key]))
				{
				    /* Convert the array to a string */
				    $tran_ary_string = print_r($this->tran_ary[$l_key], true);					
				}
				if (is_array($this->g_ary[$l_key]))
				{
				    /*Convert the array to a string */
				    $g_ary_string = print_r($this->g_ary[$l_key], true);				
				}			
				if (empty($this->tran_ary[$l_key]))
				{
				    /*Convert the array to a string */
				    $this->tran_ary[$l_key] = $this->data_decode($this->g_ary[$l_key]);				
				}				
				$this->template->assign_block_vars('language_item', array( //#
					'U_KEY'				=> strtoupper($l_key),
					'KEY'				=> $l_key,					
					'ORIGINAL_VALUE'	=> (is_array($l_value)) ? $orig_ary_string : preg_replace( '#<br[^>]*>#i', '\0'. "\n", $l_value),
					'GOOGLE_VALUE'		=> (is_array($this->g_ary[$l_key])) ? $g_ary_string : preg_replace('#<br[^>]*>#i', '\0'. "\n", $this->data_decode($this->g_ary[$l_key])),					
					'TRANSLATE_VALUE'	=> (is_array($this->tran_ary[$l_key])) ? $tran_ary_string : preg_replace('#<br[^>]*>#i', '\0'. "\n", $this->tran_ary[$l_key]),
					'COUNTER'			=> $counter,
				));				
				$counter++;
			}
		}		
	}
	
	/**
	*/
	function data_decode($data, $entities = null)
	{		
		$data = str_replace('% ', '%', $data);	
		$data = str_replace('&', '&amp;', $data);
		$data = str_replace('>', '&gt;', $data);
		$data = str_replace('<', '&lt;', $data);

		$data = str_replace("\n", '&#10;', $data);
		$data = str_replace("\r", '&#13;', $data);
		$data = str_replace("\t", '&#9;', $data);
		
		$data = urldecode($data);
		
		return $data;
	} 	
	function _get_file_perms($file) 
	{
		$length = strlen(decoct(@fileperms($file)))-3;
		return substr(decoct(fileperms($file)), $length);
	}
	
	function __is_writable($file)
	{
		if (file_exists($file))
		{
			return is_writable($file);
		}
		else if (file_exists(dirname($file)))
		{
			return is_writable(dirname($file));
		}
		else
		{
			return is_writable(dirname(dirname($file)));
		}
	}
	
	function _load_file_to_translate($filename)
	{
		if (!file_exists($filename))
		{
			return array();
		}
		include($filename);
		return $lang;
	}
	
	function file_preparesave()
	{
		$mx_user = $this->user;	
		if (@file_exists($this->file_save_path) && !isset($_POST['resetheader']))
		{
			$file_content = file_get_contents($this->file_save_path);
			$file_content = substr($file_content, 0, strpos( $file_content, '*/'));
			$file_content = substr($file_content, strpos( $file_content, '/*'));
		}
		else
		{
			switch ($this->s)
			{
				case 'MXP':
					$file_content = "/**
									 * Language file [" . $this->module_file . "]
									 * 
									 * @package language
									 * @author " . $mx_user->data['username'] . "
									 * @" ."version $I" . "d: " . $this->module_file . ",v 1.-1 " . date( 'Y/m/d H:i:s') ." " . $userdata['username'] . " Exp $
									 * @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
									 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
									 * @link http://mxpcms.sourceforge.net/
									 ";
				break;			
				case 'MODS':				
					$file_content = "/**
									 * Language file [" . $this->module_file . "]
									 * 
									 * @package language
									 * @author " . $mx_user->data['username'] . "
									 * @" ."version $I" . "d: " . $this->module_file . ",v 1.-1 " . date( 'Y/m/d H:i:s') ." " . $userdata['username'] . " Exp $
									 * @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
									 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
									 * @link http://mxpcms.sourceforge.net/
									 ";
				break;			
				case 'PHPBB':
					$file_content = "/**
									 * Language file [" . $this->module_file . "]
									 * 
									 * @package language
									 * @author " . $mx_user->data['username'] . "
									 * @" ."version $I" . "d: " . $this->module_file . ",v 1.-1 " . date( 'Y/m/d H:i:s') ." " . $mx_user->data['username'] . " Exp $
									 * @copyright (c) phpBB Limited <https://www.phpbb.com>
									 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
									 * @link http://www.phpbb.com
									 ";
				break;			
				case 'phpbb_ext':
					$file_content = "/**
									 * Language file [" . $this->module_file . "]
									 * 
									 * @package language
									 * @author " . $mx_user->data['username'] . "
									 * @" ."version $I" . "d: " . $this->module_file . ",v 1.-1 " . date( 'Y/m/d H:i:s') ." " . $mx_user->data['username'] . " Exp $
									 * @copyright (c) phpBB Limited <https://www.phpbb.com>
									 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
									 * @link http://www.phpbb.com
									 ";
				break;			
			} 		
		}
		$file_content = preg_replace('#\* (Encoding|1 tab).*'. "\n" . '#', '', $file_content);
		$file_content .= '* Encoding: ' . $this->file_encoding . "\n* 1 tab = 4 spaces\n */";
 		$file_content = preg_replace( "#\n[^*]*\*#i", "\n *", $file_content);
		$v_cnt = preg_match_all('#(@version[^,]*,v [0-9]*\.)([^ ]*)#', $file_content, $version);
		$version[2][0]++;
		$file_content = preg_replace('#(@version[^,]*,v [0-9]*)\.([^ ]*)#', '\1.'. $version[2][0], $file_content);
		
		$file_key = array_keys($this->l);
		$key_m_len = 0;
		foreach($file_key as $key => $value)
		{
			$key_m_len = (strlen($value)>$key_m_len) ? strlen($value) : $key_m_len;
		}
		$file_content_values = '';	
		foreach($this->l as $key => $value)
		{
			if ( !empty($value) )
			{
				$value = preg_replace("#(<br[^>]*>)\r?\n#si", '\1', stripslashes(str_replace( "'", "\\\'", $value)));
				$value = preg_replace('#\\\\"#si', '"', $value);
				$file_content_values .= "\t'" . $key . "'" . str_repeat( " ", $key_m_len - strlen($key) + 2) . "=> '" . $value . "',\n";
			}
		}
		if ( $file_content_values != '' )
		{
			$file_content .= "\n\nif ( !isset(\$lang) )\n{\n\t\$lang = array();\n}\n\n\$lang = array_merge( \$lang, array( // #\n";
			$file_content .= str_replace( ' =>', '=>', preg_replace( '# [ ]{1,3}#', "\t", $file_content_values));
			$file_content .= '));';
		}
		else
		{
			$file_content .= "\n\n// Nothing translated\n\n";
		}
		$this->file_save_content = "<" . "?php\n" . $file_content . "\n\n//\n// That's all Folks!\n// -------------------------------------------------\n?" . ">";
	}
	
	function file_save()
	{
		// Control path id exists
		function __control_folder($folder)
		{
			if (!file_exists($folder))
			{
				__control_folder( dirname( $folder));
				mkdir($folder);
				@chmod($folder, 0755);
				$fp = fopen( $folder . '/index.htm', 'w');
				fwrite($fp, "<html>\n<head>\n<title></title>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n</head>\n\n<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n\n</body>\n</html>");
				fclose($fp); 
				@chmod($folder. '/index.htm', 0644);
			}
		}
		__control_folder(dirname($this->file_save_path));
		
		$fp = fopen( $this->file_save_path, 'w');
		fwrite($fp, $this->file_save_content);
		fclose($fp);
		@chmod($this->file_save_path, 0644);	
	}
	
	function file_download()
	{
		ob_end_clean();
		header("Cache-Control: public"); 
		header('Content-Description: File Transfer');		
		header('Content-Type: application/x-download; name="' . $this->module_file . '"');
		header("Content-Type: text/csv; charset=".$this->file_encoding);
		header('Content-Disposition: inline; filename="' . $this->module_file . '"');
		header('Content-length: ' . strlen($this->file_save_content));
		header('Content-encoding: ' . $this->file_encoding);
		header('Content-Transfer-Encoding: text');
		header('Pragma: public');
		print (($this->file_encoding == 'UTF-8') ? "\xEF\xBB\xBF" : '') . $this->file_save_content;
		die();
	}
	
	/**
	 * encode_lang
	 *
	 * $default_lang = $mxp_translator->encode_lang($config['default_lang']);
	 *
	 * @param unknown_type $lang
	 * @return unknown
	 */
	function encode_lang($lang)
	{
			if ($this->backend == 'phpbb2')
			{
				return $lang;
			}
			else
			{
				$lang = str_replace('lang_', '', $lang);
			}			
			switch($lang)
			{
				case 'afar':
					$lang_name = 'aa';
				break;
				case 'abkhazian':
					$lang_name = 'ab';
				break;
				case 'avestan':
					$lang_name = 'ae';
				break;
				case 'afrikaans':
					$lang_name = 'af';
				break;
				case 'akan':
					$lang_name = 'ak';
				break;
				case 'amharic':
					$lang_name = 'am';
				break;
				case 'aragonese':
					$lang_name = 'an';
				break;
				case 'arabic':
					$lang_name = 'ar';
				break;
				case 'assamese':
					$lang_name = 'as';
				break;
				case 'avaric':
					$lang_name = 'av';
				break;
				case 'aymara':
					$lang_name = 'ay';
				break;
				case 'azerbaijani':
					$lang_name = 'az';
				break;
				case 'bashkir':
					$lang_name = 'ba';
				break;
				case 'belarusian':
					$lang_name = 'be';
				break;
				case 'bulgarian':
					$lang_name = 'bg';
				break;
				case 'bihari':
					$lang_name = 'bh';
				break;
				case 'bislama':
					$lang_name = 'bi';
				break;
				case 'bambara':
					$lang_name = 'bm';
				break;
				case 'bengali':
					$lang_name = 'bn';
				break;
				case 'tibetan':
					$lang_name = 'bo';
				break;
				case 'breton':
					$lang_name = 'br';
				break;
				case 'bosnian':
					$lang_name = 'bs';
				break;
				case 'catalan':
					$lang_name = 'ca';
				break;
				case 'chechen':
					$lang_name = 'ce';
				break;
				case 'chamorro':
					$lang_name = 'ch';
				break;
				case 'corsican':
					$lang_name = 'co';
				break;
				case 'cree':
					$lang_name = 'cr';
				break;
				case 'czech':
					$lang_name = 'cs';
				break;
				case 'slavonic':
					$lang_name = 'cu';
				break;
				case 'chuvash':
					$lang_name = 'cv';
				break;
				case 'welsh_cymraeg':
					$lang_name = 'cy';
				break;
				case 'danish':
					$lang_name = 'da';
				break;
				case 'german':
					$lang_name = 'de';
				break;
				case 'divehi':
					$lang_name = 'dv';
				break;
				case 'dzongkha':
					$lang_name = 'dz';
				break;
				case 'ewe':
					$lang_name = 'ee';
				break;
				case 'greek':
					$lang_name = 'el';
				break;
				case 'hebrew':
					$lang_name = 'he';
				break;
				case 'english':
					$lang_name = 'en';
				break;
				case 'english_us':
					$lang_name = 'en_us';
				break;
				case 'esperanto':
					$lang_name = 'eo';
				break;
				case 'spanish':
					$lang_name = 'es';
				break;
				case 'estonian':
					$lang_name = 'et';
				break;
				case 'basque':
					$lang_name = 'eu';
				break;
				case 'persian':
					$lang_name = 'fa';
				break;
				case 'fulah':
					$lang_name = 'ff';
				break;
				case 'finnish':
					$lang_name = 'fi';
				break;
				case 'fijian':
					$lang_name = 'fj';
				break;
				case 'faroese':
					$lang_name = 'fo';
				break;
				case 'french':
					$lang_name = 'fr';
				break;
				case 'frisian':
					$lang_name = 'fy';
				break;
				case 'irish':
					$lang_name = 'ga';
				break;
				case 'scottish':
					$lang_name = 'gd';
				break;
				case 'galician':
					$lang_name = 'gl';
				break;
				case 'guaraní':
					$lang_name = 'gn';
				break;
				case 'gujarati':
					$lang_name = 'gu';
				break;
				case 'manx':
					$lang_name = 'gv';
				break;
				case 'hausa':
					$lang_name = 'ha';
				break;
				case 'hebrew':
					$lang_name = 'he';
				break;
				case 'hindi':
					$lang_name = 'hi';
				break;
				case 'hiri_motu':
					$lang_name = 'ho';
				break;
				case 'croatian':
					$lang_name = 'hr';
				break;
				case 'haitian':
					$lang_name = 'ht';
				break;
				case 'hungarian':
					$lang_name = 'hu';
				break;
				case 'armenian':
					$lang_name = 'hy';
				break;
				case 'herero':
					$lang_name = 'hz';
				break;
				case 'interlingua':
					$lang_name = 'ia';
				break;
				case 'indonesian':
					$lang_name = 'id';
				break;
				case 'interlingue':
					$lang_name = 'ie';
				break;
				case 'igbo':
					$lang_name = 'ig';
				break;
				case 'sichuan_yi':
					$lang_name = 'ii';
				break;
				case 'inupiaq':
					$lang_name = 'ik';
				break;
				case 'ido':
					$lang_name = 'io';
				break;
				case 'icelandic':
					$lang_name = 'is';
				break;
				case 'italian':
					$lang_name = 'it';
				break;
				case 'inuktitut':
					$lang_name = 'iu';
				break;
				case 'japanese':
					$lang_name = 'ja';
				break;
				case 'javanese':
					$lang_name = 'jv';
				break;
				case 'georgian':
					$lang_name = 'ka';
				break;
				case 'kongo':
					$lang_name = 'kg';
				break;
				case 'kikuyu':
					$lang_name = 'ki';
				break;
				case 'kwanyama':
					$lang_name = 'kj';
				break;
				case 'kazakh':
					$lang_name = 'kk';
				break;
				case 'kalaallisut':
					$lang_name = 'kl';
				break;
				case 'khmer':
					$lang_name = 'km';
				break;
				case 'kannada':
					$lang_name = 'kn';
				break;
				case 'korean':
					$lang_name = 'ko';
				break;
				case 'kanuri':
					$lang_name = 'kr';
				break;
				case 'kashmiri':
					$lang_name = 'ks';
				break;
				case 'kurdish':
					$lang_name = 'ku';
				break;
				case 'kv':
					$lang_name = 'komi';
				break;
				case 'cornish_kernewek':
					$lang_name = 'kw';
				break;
				case 'kirghiz':
					$lang_name = 'ky';
				break;
				case 'latin':
					$lang_name = 'la';
				break;
				case 'luxembourgish':
					$lang_name = 'lb';
				break;
				case 'ganda':
					$lang_name = 'lg';
				break;
				case 'limburgish':
					$lang_name = 'li';
				break;
				case 'lingala':
					$lang_name = 'ln';
				break;
				case 'lao':
					$lang_name = 'lo';
				break;
				case 'lithuanian':
					$lang_name = 'lt';
				break;
				case 'luba-katanga':
					$lang_name = 'lu';
				break;
				case 'latvian':
					$lang_name = 'lv';
				break;
				case 'malagasy':
					$lang_name = 'mg';
				break;
				case 'marshallese':
					$lang_name = 'mh';
				break;
				case 'maori':
					$lang_name = 'mi';
				break;
				case 'macedonian':
					$lang_name = 'mk';
				break;
				case 'malayalam':
					$lang_name = 'ml';
				break;
				case 'mongolian':
					$lang_name = 'mn';
				break;
				case 'moldavian':
					$lang_name = 'mo';
				break;
				case 'marathi':
					$lang_name = 'mr';
				break;
				case 'malay':
					$lang_name = 'ms';
				break;
				case 'maltese':
					$lang_name = 'mt';
				break;
				case 'burmese':
					$lang_name = 'my';
				break;
				case 'nauruan':
					$lang_name = 'na';
				break;
				case 'norwegian':
					$lang_name = 'nb';
				break;
				case 'ndebele':
					$lang_name = 'nd';
				break;
				case 'nepali':
					$lang_name = 'ne';
				break;
				case 'ndonga':
					$lang_name = 'ng';
				break;
				case 'dutch':
					$lang_name = 'nl';
				break;
				case 'norwegian_nynorsk':
					$lang_name = 'nn';
				break;
				case 'norwegian':
					$lang_name = 'no';
				break;
				case 'southern_ndebele':
					$lang_name = 'nr';
				break;
				case 'navajo':
					$lang_name = 'nv';
				break;
				case 'chichewa':
					$lang_name = 'ny';
				break;
				case 'occitan':
					$lang_name = 'oc';
				break;
				case 'ojibwa':
					$lang_name = 'oj';
				break;
				case 'oromo':
					$lang_name = 'om';
				break;
				case 'oriya':
					$lang_name = 'or';
				break;
				case 'ossetian':
					$lang_name = 'os';
				break;
				case 'panjabi':
					$lang_name = 'pa';
				break;
				case 'pali':
					$lang_name = 'pi';
				break;
				case 'polish':
					$lang_name = 'pl';
				break;
				case 'pashto':
					$lang_name = 'ps';
				break;
				case 'portuguese':
					$lang_name = 'pt';
				break;
				case 'portuguese_brasil':
					$lang_name = 'pt_br';
				break;
				case 'quechua':
					$lang_name = 'qu';
				break;
				case 'romansh':
					$lang_name = 'rm';
				break;
				case 'kirundi':
					$lang_name = 'rn';
				break;
				case 'romanian':
					$lang_name = 'ro';
				break;
				case 'russian':
					$lang_name = 'ru';
				break;
				case 'kinyarwanda':
					$lang_name = 'rw';
				break;
				case 'sanskrit':
					$lang_name = 'sa';
				break;
				case 'sardinian':
					$lang_name = 'sc';
				break;
				case 'sindhi':
					$lang_name = 'sd';
				break;
				case 'northern_sami':
					$lang_name = 'se';
				break;
				case 'sango':
					$lang_name = 'sg';
				break;
				case 'serbo-croatian':
					$lang_name = 'sh';
				break;
				case 'sinhala':
					$lang_name = 'si';
				break;
				case 'slovak':
					$lang_name = 'sk';
				break;
				case 'slovenian':
					$lang_name = 'sl';
				break;
				case 'samoan':
					$lang_name = 'sm';
				break;
				case 'shona':
					$lang_name = 'sn';
				break;
				case 'somali':
					$lang_name = 'so';
				break;
				case 'albanian':
					$lang_name = 'sq';
				break;
				case 'serbian':
					$lang_name = 'sr';
				break;
				case 'swati':
					$lang_name = 'ss';
				break;
				case 'sotho':
					$lang_name = 'st';
				break;
				case 'sundanese':
					$lang_name = 'su';
				break;
				case 'swedish':
					$lang_name = 'sv';
				break;
				case 'swahili':
					$lang_name = 'sw';
				break;
				case 'tamil':
					$lang_name = 'ta';
				break;
				case 'telugu':
					$lang_name = 'te';
				break;
				case 'tajik':
					$lang_name = 'tg';
				break;
				case 'thai':
					$lang_name = 'th';
				break;
				case 'tigrinya':
					$lang_name = 'ti';
				break;
				case 'turkmen':
					$lang_name = 'tk';
				break;
				case 'tagalog':
					$lang_name = 'tl';
				break;
				case 'tswana':
					$lang_name = 'tn';
				break;
				case 'tonga':
					$lang_name = 'to';
				break;
				case 'turkish':
					$lang_name = 'tr';
				break;
				case 'tsonga':
					$lang_name = 'ts';
				break;
				case 'tatar':
					$lang_name = 'tt';
				break;
				case 'twi':
					$lang_name = 'tw';
				break;
				case 'tahitian':
					$lang_name = 'ty';
				break;
				case 'uighur':
					$lang_name = 'ug';
				break;
				case 'ukrainian':
					$lang_name = 'uk';
				break;
				case 'urdu':
					$lang_name = 'ur';
				break;
				case 'uzbek':
					$lang_name = 'uz';
				break;
				case 'venda':
					$lang_name = 've';
				break;
				case 'vietnamese':
					$lang_name = 'vi';
				break;
				case 'volapuk':
					$lang_name = 'vo';
				break;
				case 'walloon':
					$lang_name = 'wa';
				break;
				case 'wolof':
					$lang_name = 'wo';
				break;
				case 'xhosa':
					$lang_name = 'xh';
				break;
				case 'yiddish':
					$lang_name = 'yi';
				break;
				case 'yoruba':
					$lang_name = 'yo';
				break;
				case 'zhuang':
					$lang_name = 'za';
				break;
				case 'chinese':
					$lang_name = 'zh';
				break;
				case 'chinese_simplified':
					$lang_name = 'zh_cmn_hans';
				break;
				case 'chinese_traditional':
					$lang_name = 'zh_cmn_hant';
				break;
				case 'zulu':
					$lang_name = 'zu';
				break;
				default:
					$lang_name = (strlen($lang) > 2) ? substr($lang, 0, 2) : $lang;
				break;
			}
		return $lang_name;
	}
	
	function ucstrreplace($pattern = '%{$regex}%i', $matches = '', $string) 
	{
		/* return with no uppercase if patern not in string */
		if (strpos($string, $pattern) === false)
		{
			/* known languages */
			switch($string)
			{
				case 'aa':
					$lang_name = 'afar';
				break;
				case 'ab':
					$lang_name = 'abkhazian';
				break;
				case 'ae':
					$lang_name = 'avestan';
				break;
				case 'af':
					$lang_name = 'afrikaans';
				break;
				case 'ak':
					$lang_name = 'akan';
				break;
				case 'am':
					$lang_name = 'amharic';
				break;
				case 'an':
					$lang_name = 'aragonese';
				break;
				case 'ar':
					$lang_name = 'arabic';
				break;
				case 'as':
					$lang_name = 'assamese';
				break;
				case 'av':
					$lang_name = 'avaric';
				break;
				case 'ay':
					$lang_name = 'aymara';
				break;
				case 'az':
					$lang_name = 'azerbaijani';
				break;
				case 'ba':
					$lang_name = 'bashkir';
				break;
				case 'be':
					$lang_name = 'belarusian';
				break;
				case 'bg':
					$lang_name = 'bulgarian';
				break;
				case 'bh':
					$lang_name = 'bihari';
				break;
				case 'bi':
					$lang_name = 'bislama';
				break;
				case 'bm':
					$lang_name = 'bambara';
				break;
				case 'bn':
					$lang_name = 'bengali';
				break;
				case 'bo':
					$lang_name = 'tibetan';
				break;
				case 'br':
					$lang_name = 'breton';
				break;
				case 'bs':
					$lang_name = 'bosnian';
				break;
				case 'ca':
					$lang_name = 'catalan';
				break;
				case 'ce':
					$lang_name = 'chechen';
				break;
				case 'ch':
					$lang_name = 'chamorro';
				break;
				case 'co':
					$lang_name = 'corsican';
				break;
				case 'cr':
					$lang_name = 'cree';
				break;
				case 'cs':
					$lang_name = 'czech';
				break;
				case 'cu':
					$lang_name = 'slavonic';
				break;
				case 'cv':
					$lang_name = 'chuvash';
				break;
				case 'cy':
					$lang_name = 'welsh_cymraeg';
				break;
				case 'da':
					$lang_name = 'danish';
				break;
				case 'de':
					$lang_name = 'german';
				break;
				case 'dv':
					$lang_name = 'divehi';
				break;
				case 'dz':
					$lang_name = 'dzongkha';
				break;
				case 'ee':
					$lang_name = 'ewe';
				break;
				case 'el':
					$lang_name = 'greek';
				break;
				case 'he':
					$lang_name = 'hebrew';
				break;
				case 'en':
					$lang_name = 'english';
				break;
				case 'en_us':
					$lang_name = 'english';
				break;
				case 'eo':
					$lang_name = 'esperanto';
				break;
				case 'es':
					$lang_name = 'spanish';
				break;
				case 'et':
					$lang_name = 'estonian';
				break;
				case 'eu':
					$lang_name = 'basque';
				break;
				case 'fa':
					$lang_name = 'persian';
				break;
				case 'ff':
					$lang_name = 'fulah';
				break;
				case 'fi':
					$lang_name = 'finnish';
				break;
				case 'fj':
					$lang_name = 'fijian';
				break;
				case 'fo':
					$lang_name = 'faroese';
				break;
				case 'fr':
					$lang_name = 'french';
				break;
				case 'fy':
					$lang_name = 'frisian';
				break;
				case 'ga':
					$lang_name = 'irish';
				break;
				case 'gd':
					$lang_name = 'scottish';
				break;
				case 'gl':
					$lang_name = 'galician';
				break;
				case 'gn':
					$lang_name = 'guaraní';
				break;
				case 'gu':
					$lang_name = 'gujarati';
				break;
				case 'gv':
					$lang_name = 'manx';
				break;
				case 'ha':
					$lang_name = 'hausa';
				break;
				case 'he':
					$lang_name = 'hebrew';
				break;
				case 'hi':
					$lang_name = 'hindi';
				break;
				case 'ho':
					$lang_name = 'hiri_motu';
				break;
				case 'hr':
					$lang_name = 'croatian';
				break;
				case 'ht':
					$lang_name = 'haitian';
				break;
				case 'hu':
					$lang_name = 'hungarian';
				break;
				case 'hy':
					$lang_name = 'armenian';
				break;
				case 'hz':
					$lang_name = 'herero';
				break;
				case 'ia':
					$lang_name = 'interlingua';
				break;
				case 'id':
					$lang_name = 'indonesian';
				break;
				case 'ie':
					$lang_name = 'interlingue';
				break;
				case 'ig':
					$lang_name = 'igbo';
				break;
				case 'ii':
					$lang_name = 'sichuan_yi';
				break;
				case 'ik':
					$lang_name = 'inupiaq';
				break;
				case 'io':
					$lang_name = 'ido';
				break;
				case 'is':
					$lang_name = 'icelandic';
				break;
				case 'it':
					$lang_name = 'italian';
				break;
				case 'iu':
					$lang_name = 'inuktitut';
				break;
				case 'ja':
					$lang_name = 'japanese';
				break;
				case 'jv':
					$lang_name = 'javanese';
				break;
				case 'ka':
					$lang_name = 'georgian';
				break;
				case 'kg':
					$lang_name = 'kongo';
				break;
				case 'ki':
					$lang_name = 'kikuyu';
				break;
				case 'kj':
					$lang_name = 'kwanyama';
				break;
				case 'kk':
					$lang_name = 'kazakh';
				break;
				case 'kl':
					$lang_name = 'kalaallisut';
				break;
				case 'km':
					$lang_name = 'khmer';
				break;
				case 'kn':
					$lang_name = 'kannada';
				break;
				case 'ko':
					$lang_name = 'korean';
				break;
				case 'kr':
					$lang_name = 'kanuri';
				break;
				case 'ks':
					$lang_name = 'kashmiri';
				break;
				case 'ku':
					$lang_name = 'kurdish';
				break;
				case 'kv':
					$lang_name = 'komi';
				break;
				case 'kw':
					$lang_name = 'cornish_kernewek';
				break;
				case 'ky':
					$lang_name = 'kirghiz';
				break;
				case 'la':
					$lang_name = 'latin';
				break;
				case 'lb':
					$lang_name = 'luxembourgish';
				break;
				case 'lg':
					$lang_name = 'ganda';
				break;
				case 'li':
					$lang_name = 'limburgish';
				break;
				case 'ln':
					$lang_name = 'lingala';
				break;
				case 'lo':
					$lang_name = 'lao';
				break;
				case 'lt':
					$lang_name = 'lithuanian';
				break;
				case 'lu':
					$lang_name = 'luba-katanga';
				break;
				case 'lv':
					$lang_name = 'latvian';
				break;
				case 'mg':
					$lang_name = 'malagasy';
				break;
				case 'mh':
					$lang_name = 'marshallese';
				break;
				case 'mi':
					$lang_name = 'maori';
				break;
				case 'mk':
					$lang_name = 'macedonian';
				break;
				case 'ml':
					$lang_name = 'malayalam';
				break;
				case 'mn':
					$lang_name = 'mongolian';
				break;
				case 'mo':
					$lang_name = 'moldavian';
				break;
				case 'mr':
					$lang_name = 'marathi';
				break;
				case 'ms':
					$lang_name = 'malay';
				break;
				case 'mt':
					$lang_name = 'maltese';
				break;
				case 'my':
					$lang_name = 'burmese';
				break;
				case 'na':
					$lang_name = 'nauruan';
				break;
				case 'nb':
					$lang_name = 'norwegian';
				break;
				case 'nd':
					$lang_name = 'ndebele';
				break;
				case 'ne':
					$lang_name = 'nepali';
				break;
				case 'ng':
					$lang_name = 'ndonga';
				break;
				case 'nl':
					$lang_name = 'dutch';
				break;
				case 'nn':
					$lang_name = 'norwegian_nynorsk';
				break;
				case 'no':
					$lang_name = 'norwegian';
				break;
				case 'nr':
					$lang_name = 'southern_ndebele';
				break;
				case 'nv':
					$lang_name = 'navajo';
				break;
				case 'ny':
					$lang_name = 'chichewa';
				break;
				case 'oc':
					$lang_name = 'occitan';
				break;
				case 'oj':
					$lang_name = 'ojibwa';
				break;
				case 'om':
					$lang_name = 'oromo';
				break;
				case 'or':
					$lang_name = 'oriya';
				break;
				case 'os':
					$lang_name = 'ossetian';
				break;
				case 'pa':
					$lang_name = 'panjabi';
				break;
				case 'pi':
					$lang_name = 'pali';
				break;
				case 'pl':
					$lang_name = 'polish';
				break;
				case 'ps':
					$lang_name = 'pashto';
				break;
				case 'pt':
					$lang_name = 'portuguese';
				break;
				case 'pt_br':
					$lang_name = 'portuguese_brasil';
				break;
				case 'qu':
					$lang_name = 'quechua';
				break;
				case 'rm':
					$lang_name = 'romansh';
				break;
				case 'rn':
					$lang_name = 'kirundi';
				break;
				case 'ro':
					$lang_name = 'romanian';
				break;
				case 'ru':
					$lang_name = 'russian';
				break;
				case 'rw':
					$lang_name = 'kinyarwanda';
				break;
				case 'sa':
					$lang_name = 'sanskrit';
				break;
				case 'sc':
					$lang_name = 'sardinian';
				break;
				case 'sd':
					$lang_name = 'sindhi';
				break;
				case 'se':
					$lang_name = 'northern_sami';
				break;
				case 'sg':
					$lang_name = 'sango';
				break;
				case 'sh':
					$lang_name = 'serbo-croatian';
				break;
				case 'si':
					$lang_name = 'sinhala';
				break;
				case 'sk':
					$lang_name = 'slovak';
				break;
				case 'sl':
					$lang_name = 'slovenian';
				break;
				case 'sm':
					$lang_name = 'samoan';
				break;
				case 'sn':
					$lang_name = 'shona';
				break;
				case 'so':
					$lang_name = 'somali';
				break;
				case 'sq':
					$lang_name = 'albanian';
				break;
				case 'sr':
					$lang_name = 'serbian';
				break;
				case 'ss':
					$lang_name = 'swati';
				break;
				case 'st':
					$lang_name = 'sotho';
				break;
				case 'su':
					$lang_name = 'sundanese';
				break;
				case 'sv':
					$lang_name = 'swedish';
				break;
				case 'sw':
					$lang_name = 'swahili';
				break;
				case 'ta':
					$lang_name = 'tamil';
				break;
				case 'te':
					$lang_name = 'telugu';
				break;
				case 'tg':
					$lang_name = 'tajik';
				break;
				case 'th':
					$lang_name = 'thai';
				break;
				case 'ti':
					$lang_name = 'tigrinya';
				break;
				case 'tk':
					$lang_name = 'turkmen';
				break;
				case 'tl':
					$lang_name = 'tagalog';
				break;
				case 'tn':
					$lang_name = 'tswana';
				break;
				case 'to':
					$lang_name = 'tonga';
				break;
				case 'tr':
					$lang_name = 'turkish';
				break;
				case 'ts':
					$lang_name = 'tsonga';
				break;
				case 'tt':
					$lang_name = 'tatar';
				break;
				case 'tw':
					$lang_name = 'twi';
				break;
				case 'ty':
					$lang_name = 'tahitian';
				break;
				case 'ug':
					$lang_name = 'uighur';
				break;
				case 'uk':
					$lang_name = 'ukrainian';
				break;
				case 'ur':
					$lang_name = 'urdu';
				break;
				case 'uz':
					$lang_name = 'uzbek';
				break;
				case 've':
					$lang_name = 'venda';
				break;
				case 'vi':
					$lang_name = 'vietnamese';
				break;
				case 'vo':
					$lang_name = 'volapuk';
				break;
				case 'wa':
					$lang_name = 'walloon';
				break;
				case 'wo':
					$lang_name = 'wolof';
				break;
				case 'xh':
					$lang_name = 'xhosa';
				break;
				case 'yi':
					$lang_name = 'yiddish';
				break;
				case 'yo':
					$lang_name = 'yoruba';
				break;
				case 'za':
					$lang_name = 'zhuang';
				break;
				case 'zh':
					$lang_name = 'chinese';
				break;
				case 'zh_cmn_hans':
					$lang_name = 'chinese_simplified';
				break;
				case 'zh_cmn_hant':
					$lang_name = 'chinese_traditional';
				break;
				case 'zu':
					$lang_name = 'zulu';
				break;
				default:
					$lang_name = (strlen($string) > 2) ? ucfirst(str_replace($pattern, '', $string)) : $string;
				break;
			}		
			return ucwords(str_replace(array(" ","-","_"), ' ', $lang_name));	
		}
		return ucwords(str_replace(array(" ","-","_"), ' ', str_replace($pattern, '', $string)));
	}		
	/* replacement for eregi($pattern, $string); outputs 0 or 1*/
	function trisstr($pattern = '%{$regex}%i', $string, $matches = '') 
	{         
		return preg_match('/' . $pattern . '/i', $string, $matches);	
	}
	/**
	 * Returns the raw value associated to a language key or the language key no translation is available.
	 * No parameter substitution is performed, can be a string or an array.
	 *
	 * @param string|array	$key	Language key
	 *
	 * @return array|string
	 */
	public function lang_raw($key)
	{
		// Load common language files if they not loaded yet
		if (!$this->common_language_files_loaded)
		{
			$this->load_common_language_files();							
		}
		if (is_array($key))
		{
			$lang = &$this->lang[array_shift($key)];
			foreach ($key as $_key)
			{
				$lang = &$lang[$_key];
			}
		}
		else
		{
			$lang = &$this->lang[$key];
		}
		// Return if language string does not exist
		if (!isset($lang) || (!is_string($lang) && !is_array($lang)))
		{
			return $key;
		}
		return $lang;
	}

	/**
	 * Act like lang() but takes a key and an array of parameters instead of using variadic
	 *
	 * @param string|array	$key	Language key
	 * @param array			$args	Parameters
	 *
	 * @return string
	 */
	public function lang_array($key, $args = array())
	{
		$lang = $this->lang_raw($key);
		
		if ($lang === $key)
		{
			return $key;
		}
		// If the language entry is a string, we simply mimic sprintf() behaviour
		if (is_string($lang))
		{
			if (count($args) === 0)
			{
				return $lang;
			}
			// Replace key with language entry and simply pass along...
			return vsprintf($lang, $args);
		}
		else if (count($lang) == 0)
		{
			// If the language entry is an empty array, we just return the language key
			return $key;
		}
		// It is an array... now handle different nullar/singular/plural forms
		$key_found = false;

		// We now get the first number passed and will select the key based upon this number
		for ($i = 0, $num_args = count($args); $i < $num_args; $i++)
		{
			if (is_int($args[$i]) || is_float($args[$i]))
			{
				if ($args[$i] == 0 && isset($lang[0]))
				{
					// We allow each translation using plural forms to specify a version for the case of 0 things,
					// so that "0 users" may be displayed as "No users".
					$key_found = 0;
					break;
				}
				else
				{
					$use_plural_form = $this->get_plural_form($args[$i]);
					if (isset($lang[$use_plural_form]))
					{
						// The key we should use exists, so we use it.
						$key_found = $use_plural_form;
					}
					else
					{
						// If the key we need to use does not exist, we fall back to the previous one.
						$numbers = array_keys($lang);

						foreach ($numbers as $num)
						{
							if ($num > $use_plural_form)
							{
								break;
							}
							$key_found = $num;
						}
					}
					break;
				}
			}
		}
		
		// Ok, let's check if the key was found, else use the last entry (because it is mostly the plural form)
		if ($key_found === false)
		{
			$numbers = array_keys($lang);
			$key_found = end($numbers);
		}
		// Use the language string we determined and pass it to sprintf()
		return vsprintf($lang[$key_found], $args);
	}
	/**
	 * Determine which plural form we should use.
	 *
	 * For some languages this is not as simple as for English.
	 *
	 * @param int|float		$number		The number we want to get the plural case for. Float numbers are floored.
	 * @param int|bool		$force_rule	False to use the plural rule of the language package
	 *									or an integer to force a certain plural rule
	 *
	 * @return int	The plural-case we need to use for the number plural-rule combination
	 *
	 * @throws \phpbb\language\exception\invalid_plural_rule_exception	When $force_rule has an invalid value
	 */
	public function get_plural_form($number, $force_rule = false)
	{
		$number			= (int) $number;
		$plural_rule	= ($force_rule !== false) ? $force_rule : ((isset($this->lang['PLURAL_RULE'])) ? $this->lang['PLURAL_RULE'] : 1);

		if ($plural_rule > 15 || $plural_rule < 0)
		{
			throw new invalid_plural_rule_exception('INVALID_PLURAL_RULE', array(
				'plural_rule' => $plural_rule,
			));
		}

		/**
		 * The following plural rules are based on a list published by the Mozilla Developer Network
		 * https://developer.mozilla.org/en/Localization_and_Plurals
		 */
		switch ($plural_rule)
		{
			case 0:
				/**
				 * Families: Asian (Chinese, Japanese, Korean, Vietnamese), Persian, Turkic/Altaic (Turkish), Thai, Lao
				 * 1 - everything: 0, 1, 2, ...
				 */
			return 1;
			case 1:
				/**
				 * Families: Germanic (Danish, Dutch, English, Faroese, Frisian, German, Norwegian, Swedish), Finno-Ugric (Estonian, Finnish, Hungarian), Language isolate (Basque), Latin/Greek (Greek), Semitic (Hebrew), Romanic (Italian, Portuguese, Spanish, Catalan)
				 * 1 - 1
				 * 2 - everything else: 0, 2, 3, ...
				 */
			return ($number === 1) ? 1 : 2;
			case 2:
				/**
				 * Families: Romanic (French, Brazilian Portuguese)
				 * 1 - 0, 1
				 * 2 - everything else: 2, 3, ...
				 */
			return (($number === 0) || ($number === 1)) ? 1 : 2;
			case 3:
				/**
				 * Families: Baltic (Latvian)
				 * 1 - 0
				 * 2 - ends in 1, not 11: 1, 21, ... 101, 121, ...
				 * 3 - everything else: 2, 3, ... 10, 11, 12, ... 20, 22, ...
				 */
			return ($number === 0) ? 1 : ((($number % 10 === 1) && ($number % 100 != 11)) ? 2 : 3);
			case 4:
				/**
				 * Families: Celtic (Scottish Gaelic)
				 * 1 - is 1 or 11: 1, 11
				 * 2 - is 2 or 12: 2, 12
				 * 3 - others between 3 and 19: 3, 4, ... 10, 13, ... 18, 19
				 * 4 - everything else: 0, 20, 21, ...
				 */
			return ($number === 1 || $number === 11) ? 1 : (($number === 2 || $number === 12) ? 2 : (($number >= 3 && $number <= 19) ? 3 : 4));
			case 5:
				/**
				 * Families: Romanic (Romanian)
				 * 1 - 1
				 * 2 - is 0 or ends in 01-19: 0, 2, 3, ... 19, 101, 102, ... 119, 201, ...
				 * 3 - everything else: 20, 21, ...
				 */
			return ($number === 1) ? 1 : ((($number === 0) || (($number % 100 > 0) && ($number % 100 < 20))) ? 2 : 3);
			case 6:
				/**
				 * Families: Baltic (Lithuanian)
				 * 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, ...
				 * 2 - ends in 0 or ends in 10-20: 0, 10, 11, 12, ... 19, 20, 30, 40, ...
				 * 3 - everything else: 2, 3, ... 8, 9, 22, 23, ... 29, 32, 33, ...
				 */
			return (($number % 10 === 1) && ($number % 100 != 11)) ? 1 : ((($number % 10 < 2) || (($number % 100 >= 10) && ($number % 100 < 20))) ? 2 : 3);
			case 7:
				/**
				 * Families: Slavic (Croatian, Serbian, Russian, Ukrainian)
				 * 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, ...
				 * 2 - ends in 2-4, not 12-14: 2, 3, 4, 22, 23, 24, 32, ...
				 * 3 - everything else: 0, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 25, 26, ...
				 */
			return (($number % 10 === 1) && ($number % 100 != 11)) ? 1 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 2 : 3);
			case 8:
				/**
				 * Families: Slavic (Slovak, Czech)
				 * 1 - 1
				 * 2 - 2, 3, 4
				 * 3 - everything else: 0, 5, 6, 7, ...
				 */
			return ($number === 1) ? 1 : ((($number >= 2) && ($number <= 4)) ? 2 : 3);
			case 9:
				/**
				 * Families: Slavic (Polish)
				 * 1 - 1
				 * 2 - ends in 2-4, not 12-14: 2, 3, 4, 22, 23, 24, 32, ... 104, 122, ...
				 * 3 - everything else: 0, 5, 6, ... 11, 12, 13, 14, 15, ... 20, 21, 25, ...
				 */
			return ($number === 1) ? 1 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 12) || ($number % 100 > 14))) ? 2 : 3);
			case 10:
				/**
				 * Families: Slavic (Slovenian, Sorbian)
				 * 1 - ends in 01: 1, 101, 201, ...
				 * 2 - ends in 02: 2, 102, 202, ...
				 * 3 - ends in 03-04: 3, 4, 103, 104, 203, 204, ...
				 * 4 - everything else: 0, 5, 6, 7, 8, 9, 10, 11, ...
				 */
			return ($number % 100 === 1) ? 1 : (($number % 100 === 2) ? 2 : ((($number % 100 === 3) || ($number % 100 === 4)) ? 3 : 4));
			case 11:
				/**
				 * Families: Celtic (Irish Gaeilge)
				 * 1 - 1
				 * 2 - 2
				 * 3 - is 3-6: 3, 4, 5, 6
				 * 4 - is 7-10: 7, 8, 9, 10
				 * 5 - everything else: 0, 11, 12, ...
				 */
			return ($number === 1) ? 1 : (($number === 2) ? 2 : (($number >= 3 && $number <= 6) ? 3 : (($number >= 7 && $number <= 10) ? 4 : 5)));
			case 12:
				/**
				 * Families: Semitic (Arabic)
				 * 1 - 1
				 * 2 - 2
				 * 3 - ends in 03-10: 3, 4, ... 10, 103, 104, ... 110, 203, 204, ...
				 * 4 - ends in 11-99: 11, ... 99, 111, 112, ...
				 * 5 - everything else: 100, 101, 102, 200, 201, 202, ...
				 * 6 - 0
				 */
			return ($number === 1) ? 1 : (($number === 2) ? 2 : ((($number % 100 >= 3) && ($number % 100 <= 10)) ? 3 : ((($number % 100 >= 11) && ($number % 100 <= 99)) ? 4 : (($number != 0) ? 5 : 6))));
			case 13:
				/**
				 * Families: Semitic (Maltese)
				 * 1 - 1
				 * 2 - is 0 or ends in 01-10: 0, 2, 3, ... 9, 10, 101, 102, ...
				 * 3 - ends in 11-19: 11, 12, ... 18, 19, 111, 112, ...
				 * 4 - everything else: 20, 21, ...
				 */
			return ($number === 1) ? 1 : ((($number === 0) || (($number % 100 > 1) && ($number % 100 < 11))) ? 2 : ((($number % 100 > 10) && ($number % 100 < 20)) ? 3 : 4));
			case 14:
				/**
				 * Families: Slavic (Macedonian)
				 * 1 - ends in 1: 1, 11, 21, ...
				 * 2 - ends in 2: 2, 12, 22, ...
				 * 3 - everything else: 0, 3, 4, ... 10, 13, 14, ... 20, 23, ...
				 */
			return ($number % 10 === 1) ? 1 : (($number % 10 === 2) ? 2 : 3);
			case 15:
				/**
				 * Families: Icelandic
				 * 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, 131, ...
				 * 2 - everything else: 0, 2, 3, ... 10, 11, 12, ... 20, 22, ...
				 */
			return (($number % 10 === 1) && ($number % 100 != 11)) ? 1 : 2;
		}
	}
	/**
	 * Advanced language substitution
	 *
	 * Function to mimic sprintf() with the possibility of using phpBB's language system to substitute nullar/singular/plural forms.
	 * Params are the language key and the parameters to be substituted.
	 * This function/functionality is inspired by SHS` and Ashe.
	 *
	 * Example call: <samp>$user->lang('NUM_POSTS_IN_QUEUE', 1);</samp>
	 *
	 * If the first parameter is an array, the elements are used as keys and subkeys to get the language entry:
	 * Example: <samp>$user->lang(array('datetime', 'AGO'), 1)</samp> uses $user->lang['datetime']['AGO'] as language entry.
	 *
	 * @return string	Return localized string or the language key if the translation is not available
	 */
	public function lang()
	{
		$args = func_get_args();
		$key = array_shift($args);
		return $this->lang_array($key, $args);
	}
	/**
	 * Returns data filtered to only include specified keys.
	 *
	 * This effectively discards any keys added to data by hooks.
	 */
	public function get_data_filtered($keys)
	{
		return array_intersect_key($this->data, array_flip($keys));
	}	
	/**
	* Add a secret token to the form (requires the S_FORM_TOKEN template variable)
	* @param string  $form_name The name of the form; has to match the name used in check_form_key, otherwise no restrictions apply
	* @param string  $template_variable_suffix A string that is appended to the name of the template variable to which the form elements are assigned
	*/
	function add_form_key($form_name, $template_variable_suffix = '')
	{
		global $phpbb_dispatcher;

		$now = time();
		$token_sid = ($this->user->data['user_id'] == ANONYMOUS && !empty($this->config['form_token_sid_guests'])) ? $this->user->session_id : '';
		$token = sha1($now . $this->user->data['user_form_salt'] . $form_name . $token_sid);

		$s_fields = build_hidden_fields(array(
			'creation_time' => $now,
			'form_token'	=> $token,
		));

		/**
		* Perform additional actions on creation of the form token
		*
		* @event core.add_form_key
		* @var	string	form_name					The form name
		* @var	int		now							Current time timestamp
		* @var	string	s_fields					Generated hidden fields
		* @var	string	token						Form token
		* @var	string	token_sid					User session ID
		* @var	string	template_variable_suffix	The string that is appended to template variable name
		*
		* @since 3.1.0-RC3
		* @changed 3.1.11-RC1 Added template_variable_suffix
		*/
		$vars = array(
			'form_name',
			'now',
			's_fields',
			'token',
			'token_sid',
			'template_variable_suffix',
		);
		extract($this->get_data_filtered(array_keys($vars)));
		
		$this->template->assign_var('S_FORM_TOKEN' . $template_variable_suffix, $s_fields);
	}	
	/**
	 * Extend.
	 *
	 * Extend User Style with module lang and images.
	 *
	 * Usage:
	 * Usage:  $user->extend(LANG, IMAGES, '_core', 'img_file_in_dir', 'img_file_ext')
	 *
	 * Switches:
	 * - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL
	 * - IMAGES: MX_IMAGES (default), MX_NO_IMAGES
	 *
	 * @access public
	 * @param unknown_type $lang_mode
	 * @param unknown_type $image_mode
	 */
	function extend($lang_mode = false, $image_mode = false, $default_module_style = '', $image_file = 'icon_info', $image_ext = '.gif')
	{		
		/** modifyed for phpBB  ext/orynider/mx_langtools/ */
		global $user;
		$module_root_path = $this->module_root_path;
		
		/** From MXP 2.8.x vs 3.0.x vs 3.2.x "_core" vs "all" */
		$this->default_template_name = !empty($default_module_style) ? $default_module_style : 'all';
		
		/* Check for all installed styles first */
		$sql = 'SELECT style_path
			FROM ' . STYLES_TABLE;
		$result = $this->db->sql_query($sql);
		while ($rows = $this->db->sql_fetchrow($result))
		{
			$styles_installed[] = $rows['style_path'];
		}
		/* If query fails need to define this for foreach */
		if (!is_array($styles_installed))
		{
			$rows['style_path'] = 'prosilver';
			$styles_installed[] = $rows['style_path'];
		}		
		$this->db->sql_freeresult($result);
		/** 
		 * Now check for the correct existance of all of the $user->style['style_path'] images into
		 * each of the effectively installed styles. see $user->style['style_id'], $user->style['style_parent_id']
		 */
		foreach ($styles_installed as $style_installed)
		{
			$style_installed = !empty($style_installed) ? $style_installed : $this->default_template_name;
			$ext_path_img = $module_root_path . 'styles/' . $style_installed . '/images/menu_icons/' . $image_file;
			if (!(@file_exists($ext_path_img . $image_ext) && @file_exists($ext_path_img . '_medium'. $image_ext) && @file_exists($ext_path_img . '_full' . $image_ext)) )
			{
				/**$errors[] = $user->lang('IMG_INVALID', $style_installed);
				$phpbb_log->add('critical', $user->data['user_id'], $user->ip, 'IMG_INVALID');
				$img_info = MODULE_URL . 'styles/all/images/menu_icons/icon_info.gif';
				*/
				$this->default_current_template_path = $module_root_path . 'styles/' . $this->default_template_name . '/theme/';				
				$this->default_current_style_path = $module_root_path . 'styles/' . $this->default_template_name . '/';				
			}
			else
			{
				/**$img_info = $module_root_path . 'styles/' . rawurlencode($style_installed) . '/theme/images/menu_icons/icon_info.gif';*/
				$this->default_current_template_path = $module_root_path . 'styles/' . rawurlencode($style_installed) . '/theme/';
				$this->default_current_style_path = $module_root_path . 'styles/' . rawurlencode($style_installed) . '/';				
			}
					
			/**
			* Reset custom module default style, once used.
			*/
			$this->default_module_style = $style_installed;			
		}
		
		if ($lang_mode != false)
		{
			$user->add_lang(array('common', 'acp/common', 'acp/board', 'install', 'posting'));
		}
		if ($image_mode != false)
		{
			$user->action_install();
		}
		
		$this->user_template_name = $user->style['style_path'];
		
		$ext_path_img_user = $module_root_path . 'styles/' .  rawurlencode($user->style['style_path']) . '/images/menu_icons/' . $image_file;
				
		if (!(@file_exists($ext_path_img_user . $image_ext) && @file_exists($ext_path_img_user . '_medium' . $image_ext) && @file_exists($ext_path_img_user . '_full' . $image_ext)) )
		{
			/**$errors[] = $user->lang('IMG_INVALID', $user->style['style_path']);
			$phpbb_log->add('critical', $user->data['user_id'], $user->ip, 'IMG_INVALID');
			$img_info = MODULE_URL . 'styles/all/images/menu_icons/icon_info.gif';
			*/
			$this->user_current_template_path = $module_root_path . 'styles/' . $this->default_template_name . '/theme/';				
			$this->user_current_style_path = $module_root_path . 'styles/' . $this->default_template_name . '/';
			$this->user_module_style = $this->default_template_name;			
		}
		else
		{
			/**$img_info = $module_root_path . 'styles/' . rawurlencode($style_installed) . '/theme/images/menu_icons/icon_info.gif';*/
			$this->user_current_template_path = $module_root_path . 'styles/' . rawurlencode($user->style['style_path']) . '/theme/';
			$this->user_current_style_path = $module_root_path . 'styles/' . rawurlencode($user->style['style_path']) . '/';			
			$this->user_module_style = $user->style['style_path'];
		}				
	}	
	/**
	 * Display the options a user can configure for this extension
	 *
	 * @return void
	 * @access public
	 */
	public function display_settings($tpl_name, $page_title)
	{
		$this->tpl_name = $tpl_name;
		$this->page_title = $page_title;
		
		// Create a form key for preventing CSRF attacks
		add_form_key($tpl_name);
		// Create an array to collect errors that will be output to the user
		$errors = array();		
		// Is the form being submitted to us?
		if ($submit = $this->request->is_set_post('submit'))
		{
			// Test if the submitted form is valid
			if (!check_form_key($tpl_name))
			{
				$errors[] = $this->lang->lang('FORM_INVALID');
				//trigger_error('FORM_INVALID');
			}
			
			$s_errors = (bool) count($errors);
			
			$this->config->set('translator_default_lang', ($this->request->variable('translator_default_lang', 'en')));
			$this->config->set('translator_choice_lang', ($this->request->variable('translator_choice_lang', 'de,fr,es,ro')));
		
			// If no errors, process the form data
			if (empty($errors))
			{
				// Add option settings change action to the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_TRANSLATOR_SETTINGS_LOG');
				// Option settings have been updated and logged
				// Confirm this to the user and provide link back to previous page
				trigger_error($this->lang('ACP_TRANSLATOR_SETTINGS_CHANGED') . adm_back_link($this->u_action));
			}		
			trigger_error($this->lang('TRANSLATOR_CONFIG_SAVED') . adm_back_link($this->u_action));
		}
		$this->assign_template_vars($this->template);
		$this->template->assign_vars(array(
			'TRANSLATOR_DEFAULT_LANG'	=> (isset($this->config['translator_default_lang'])) ? $this->config['translator_default_lang'] : 'error',
			'TRANSLATOR_CHOICE_LANG'	=> (isset($this->config['translator_choice_lang'])) ? $this->config['translator_choice_lang'] : 'error',
			'U_ACTION'					=> $this->u_action,
		));
	}
	
	/**
	 * Display the options a user can configure for this extension
	 *
	 * @return void
	 * @access public
	 */
	public function display_translate($tpl_name, $page_title)
	{
		if (!defined('IN_AJAX'))
		{
			define('IN_AJAX', (isset($_GET['ajax']) && ($this->ajax == 1) && ($server['HTTP_SEREFER'] = $server['PHP_SELF'])) ? 1 : 0);
		}
		$phpEx = $this->php_ext;
		// Requests
		$action = $this->request->variable('action', '');
		$page_id = $this->request->variable('page_id', 0);
		$currency_id = $this->request->variable('currency_id', 0);		
		$this->parent_id = $this->request->variable('parent_id', 0);		
		/* general vars */
		$mode = $this->request->variable('mode', 'generate');
		$start = $this->request->variable('start', 0);  
		$s = $this->request->variable('mode', 'generate');	
		/* */	
		if (IN_AJAX == 0)
		{
			$lang['ENCODING'] = $this->file_encoding;
			if (isset($_POST['save']) || isset($_POST['download']))
			{
				$this->file_preparesave();
			}
			if (isset( $_POST['save']))
			{
				$this->file_save();
			}
			else if (isset( $_POST['download']))
			{
				$this->file_download();
			}			
			$this->user->add_lang_ext('orynider/mx_translator', 'info_acp_translator');
			$this->user->add_lang('acp/board');			
			//$tpl_name = 'lang_translate';
			//$page_title = $this->lang('ACP_MX_LANGTOOLS_TITLE');			
			/** Only allow founders to view/manage these settings
			if ($this->user->data['user_type'] != USER_FOUNDER)
			{
				trigger_error($user->lang('ACP_FOUNDER_MANAGE_ONLY'), E_USER_WARNING);
			}
			else
			{
				$this->is_admin = USER_FOUNDER;
			}
			*/						
			// Create a form key for preventing CSRF attacks
			add_form_key($tpl_name);
			// Create an array to collect errors that will be output to the user
			$errors = array();		
			// Is the form being submitted to us?
			if ($submit = $this->request->is_set_post('submit'))
			{
				// Test if the submitted form is valid
				if (!check_form_key($tpl_name))
				{
					$errors[] = $this->lang->lang('FORM_INVALID');
					//trigger_error('FORM_INVALID');
				}
				
				$s_errors = (bool) count($errors);			
				// If no errors, process the form data
				if (empty($errors))
				{
					// Add option settings change action to the admin log
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_TRANSLATOR_SETTINGS_LOG');
					// Option settings have been updated and logged
					// Confirm this to the user and provide link back to previous page
					trigger_error($this->lang('ACP_TRANSLATOR_SETTINGS_CHANGED') . adm_back_link($this->u_action));
				}		
				trigger_error($this->lang('TRANSLATOR_CONFIG_SAVED') . adm_back_link($this->u_action));
			}		
			//$submit = $this->request->is_set('submit');			
			$this->cache->destroy('_translator');
			$this->cache->destroy('_translator_module');			
			$this->template->assign_block_vars('file_to_translate_select', array());
			
			$basename = basename( __FILE__);
			$mx_root_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $phpbb_root_path;
			$module_root_path = $this->root_path . 'ext/orynider/mx_translator/';
			$admin_module_root_path = $this->root_path . 'adm/';		

			$s_action = $admin_module_root_path . $basename;
			$params = $this->request->server('QUERY_STRING');
			//$params = $this->server['QUERY_STRING'];			
			if ($this->request->is_set_post('submit'))
			{
				if (!check_form_key('orynider/mx_translator'))
				{
					trigger_error('FORM_INVALID', E_USER_WARNING);
				}
			}			
			/** -------------------------------------------------------------------------
			* Extend User Style with module lang and images
			* Usage:  $user->extend(LANG, IMAGES, '_core', 'img_file_in_dir', 'img_file_ext')
			* Switches:
			* - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
			* - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
			** ------------------------------------------------------------------------- */
			$this->extend(false, false, 'all', 'icon_info', false);				
			/**
			* Reset custom module default style, once used.
			*/
			if (@file_exists($this->user_current_style_path . 'images/menu_icons/icon_info.gif'))
			{
				$img_info = $this->user_current_style_path . 'images/menu_icons/icon_info.gif';
			}
			else
			{
				$img_info = $this->default_current_style_path . 'images/menu_icons/icon_info.gif';
			}
			if (@file_exists( $this->user_current_style_path . 'images/menu_icons/icon_google.gif'))
			{
				$img_google = $this->user_current_style_path . 'images/menu_icons/icon_google.gif';
			}
			else
			{
				$img_google = $this->default_current_style_path . 'images/menu_icons/icon_google.gif';
			}			
			$params = !empty($params) ? $params : "&i=-orynider-mx_translator-acp-translator_module&mode=".$mode;
			$this->u_action = !empty($this->u_action) ? $this->u_action : '';
			/* * /	
			print_r($this->gen_select_list( 'html', 'dirs', $this->dir_select)); 
			/* */					
			$this->template->assign_vars(array( // #
				'TH_COLOR2' => $theme['th_color2'],
				
				'S_LANGUAGE_INTO' => $this->gen_select_list( 'html', 'language', $this->language_into, $this->language_from),
				'S_MODULE_LIST' => $this->gen_select_list( 'html', 'modules', $this->module_select),
				'S_DIR_LIST' => $this->gen_select_list( 'html', 'dirs', $this->dir_select),
				'S_FILE_LIST' => $this->gen_select_list( 'html', 'files', $this->module_file),				
				'S_ACTION' => $this->u_action . '?' . str_replace('&amp;', '&', $params),
				'S_ACTION_AJAX' => $this->u_action . '?' . str_replace('&amp;', '&', $params) . '&ajax=1',
				
				'L_RESET' => $lang['Reset'],
				'IMG_INFO' => $img_info,
				'IMG_GOOGLE' => $img_google,				
				'I_LANGUAGE' => $this->language_into,
				'I_MODULE' => $this->module_select,
				'I_DIR' => $this->dir_select,
				'I_FILE' => $this->module_file,			
			));		
			/* */
			$this->assign_template_vars($this->template);
			$this->template->assign_vars( array( // #
				'L_MX_MODULES' => $lang['MX_Modules'],
			));
			if (($this->s == 'MODS') || ($this->s == 'phpbb_ext'))
			{
				$this->template->assign_block_vars('file_to_translate_select.modules', array());
				$this->template->assign_block_vars('modules', array());
			}
			/*
			if(!empty($this->gen_select_list('in_array', 'dirs')))
			{
				$this->template->assign_block_vars('file_to_translate_select.dirs', array());
				$this->template->assign_block_vars('dirs', array());
			}
			*/
			$this->file_translate();			
			//page_footer();
		}
		else
		{ // AJAX
			$tpl_name = 'selects';
			//$this->template->set_filenames( array('body' => 'selects.html'));
			add_form_key($tpl_name);			
			$style = "width:100%;"; 
			if ($this->into == 'language')
			{
				$option_list = $this->gen_select_list('html', 'language', $this->language_into, $this->language_from);
				$name = 'language[into]';
				$id = 'f_lang_into';
			}
			/* */
			if ($this->into == 'modules')
			{		
				$option_list = $this->gen_select_list('html', 'modules', $this->module_select);
				$name = 'translate[module]';
				$id = 'f_select_file';
			}			
			/* */
			if ($this->into == 'dirs')
			{		
				$option_list = $this->gen_select_list('html', 'dirs', $this->dir_select);
				$name = 'translate[dir]';
				$id = 'f_select_file';
			}
			/* */			
			if ($this->into == 'files')
			{		
				$option_list = $this->gen_select_list('html', 'files', $this->module_file);
				$name = 'translate[file]';
				$id = 'f_select_file';
			}			
			$this->template->assign_block_vars('ajax_select', array(
				'NAME'		=> $name,
				'ID'		=> $id,
				'STYLE'		=> $style,
				'OPTIONS'	=> $option_list,
			));
			//$this->template->pparse('body');
		}
	}	
}	// class mx_user
// THE END
?>