<?php
/**
*
* @package Style
* @version $Id: session.php,v 3.2.9 2021/03/25 04:13:02 orynider Exp $
* @copyright (c) 2002-2021 MX-Publisher Project Team & (C) 2005 The phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

/**
 * Modifications:
 *		- replaced $config -> $board_config - by Jon
 *		- replaced $cache = new mx_nothing(); to disable bots() - by Jon
 *		- removed '?' in the returned $SID string - by Jon
 *		- in function setup()
 *			$auth -> $phpbb_auth - by OryNider
 *			-new globals:  $mx_root_path, $mx_cache - by OryNider
 *			$this->lang_name was redefined to use in
 *			worst case the new $board_config['phpbb_lang']
 *			wich was defined in mx_functions_style.php
 *			before lang name is expanded - by OryNider
 *			$template = new mx_Template(); - by OryNider
 *			- before $this->add_lang($lang_set); the phpBB common language is included
 *			if fails with $phpbb_root_path added
 *		- in function set_lang()
 *			- if empty $this->lang_path will be redefined
 *			from $phpbb_root_path and new $board_config['phpbb_lang']
 *			wich in this case are set as globals - by OryNider
 *			(similar check has been added in the phpBB3 version too)
 *		- added function images() to help redefining $images var
 *		and indexes were is needed - by OryNider
 */

/**
 * Disable bots
 *
 * Class wrapper
 * mx_dss_rand
 */
class mx_nothing
{
	function obtain_bots()
	{
		return array();
	}
}

/*
 * This class is part of Crawler Detect - the web crawler detection library.
 *
 * (c) Mark Beech <m@rkbee.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file fixtures\LICENSE.
 */
//namespace Jaybizzle\CrawlerDetect;
abstract class AbstractProvider
{
    /**
     * The data set.
     * 
     * @var array
     */
    protected $data;
    /**
     * Return the data set.
     * 
     * @return array
     */
    public function getAll()
    {
        return $this->data;
    }
}

include_once($mx_root_path . 'includes/fixtures/headers.'.$phpEx);
include_once($mx_root_path . 'includes/fixtures/crawlers.'.$phpEx);
include_once($mx_root_path . 'includes/fixtures/exclusions.'.$phpEx);

/**
* Session class
* @package MX-Publisher
*/
class session
{
	/**#@+
	 * user class specific vars
	 *
	 */
	var $loaded_langs = array();
	var $loaded_styles = array();
	var $loaded_default_styles = array();
	
	var $lang_path = 'language/';
	var $lang = array();
	var $help = array();
	var $lang_name;
	var $lang_id = false;

	var $img_lang;
	
	/**
	 * @var string	ISO code of the default board language
	 */
	var $default_language;
	var $default_language_name;
	
	/**
	 * @var string	ISO code of the User's language
	 */
	var $user_language;
	var $user_language_name;

		
	var $lang_iso = 'en';		
	var $lang_dir = 'lang_english';
	//
	var $img_lang_dir = 'en';

	var $template_path = 'templates/';
	var $styles_path = 'templates/';

	var $template_name = '';
	var $template_names = array();
	var $current_template_path = '';

	var $cloned_template_name = 'subSilver';
	var $default_template_name = 'subsilver2';
	
	var $cloned_current_template_name = 'prosilver';
	var $default_current_template_name = '';	
	
	var $cloned_current_template_path = 'templates/subSilver';
	var $default_current_template_path = 'templates/subsilver2';
	
	var $imageset_backend = 'phpbb2';
	var $ext_imageset_backend = 'phpbb2';

	var $img_array = array();
	var $default_module_style = '';
	var $style = array();
	var $theme = array();

	var $date_format;
	var $timezone;
	var $int_timezone;
	var $dst;
	
	// Able to add new options (up to id 31)
	var $keyoptions = array('viewimg' => 0, 'viewflash' => 1, 'viewsmilies' => 2, 'viewsigs' => 3, 'viewavatars' => 4, 'viewcensors' => 5, 'attachsig' => 6, 'bbcode' => 8, 'smilies' => 9, 'sig_bbcode' => 15, 'sig_smilies' => 16, 'sig_links' => 17);
	
	var $is_admin = false;
	
	var $page_id = '';
	var $user_ip = '';

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;
	protected $language;
	protected $request;
	
	/** @var \phpbb\config\config */
	protected $config;
	
	/** @var \phpbb\db\driver\driver_interface */
	protected $db; 
	
	var $cookie_data = array();
	var $page = array();
	var $data = array();
	var $browser = '';
	var $forwarded_for = '';
	var $host = '';
	var $session_id = '';
	var $ip = '';
	var $datetime = '';

	var $load = 0;
	var $time_now = 0;
	var $update_session_page = true;
	
	var $module_lang_path = array();
	protected $phpbb_root_path;

	
    /**
     * The user agent.
     *
     * @var null
     */
    protected $userAgent = null;

    /**
     * Headers that contain a user agent.
     *
     * @var array
     */
    protected $httpHeaders = array();

    /**
     * Store regex matches.
     *
     * @var array
     */
    protected $matches = array();

    /**
     * Crawlers object.
     *
     * @var \Jaybizzle\CrawlerDetect\Fixtures\Crawlers
     */
    protected $crawlers;

    /**
     * Exclusions object.
     *
     * @var \Jaybizzle\CrawlerDetect\Fixtures\Exclusions
     */
    protected $exclusions;

    /**
     * Headers object.
     *
     * @var \Jaybizzle\CrawlerDetect\Fixtures\Headers
     */
    protected $uaHttpHeaders;

    /**
     * The compiled regex string.
     *
     * @var string
     */
    protected $compiledRegex;

    /**
     * The compiled exclusions regex string.
     *
     * @var string
     */
    protected $compiledExclusions;
	
	/** @var bool */
	protected $is_setup_flag;
	
	//var  $phpbb_root_path;	
	/**#@-*/
	
	/**
	 * Load sessions
	 * @access public
	 *
	 */
	function __construct()
	{
		global $mx_cache, $board_config, $db, $phpbb_root_path, $mx_root_path, $phpEx;
		global $mx_request_vars, $template, $language;
		
		$this->cache			= $mx_cache;
		$this->config			= $board_config;
		$this->db               = $db;
		$this->user             = $this;
		$this->service_providers = array('user_id' => 1, 'session_id' => 0, 'provider'	=> '', 'oauth_token' => '');
		$this->phpbb_root_path 	= $phpbb_root_path;
		$this->mx_root_path		= $mx_root_path;
		$this->php_ext			= $phpEx;
		$this->lang_path		= $mx_root_path . 'language/';
		$this->request			= $mx_request_vars;
		$this->template			= $template;
		$this->language			= $language;

		$this->is_setup_flag = false;

		// Setup $this->db_tools
		if (!class_exists('mx_db_tools') && !class_exists('tools'))
		{
			include_once($mx_root_path . 'includes/db/db_tools.' . $phpEx);
		}
		if (class_exists('mx_db_tools'))
		{
			$this->db_tools = new mx_db_tools($this->db);
		}
		elseif (class_exists('tools'))
		{
			$this->db_tools = new tools($this->db);
		}
		
		$this->service_providers = array('user_id' => 1, 'session_id' => 0, 'provider' => '', 'oauth_token' => '');
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $phpEx;
	
		$this->lang_path = $mx_root_path . 'language/';
		
		/**/
		$this->crawlers = new Crawlers();
		$this->exclusions = new Exclusions();
		$this->uaHttpHeaders = new Headers();

		$this->compiledRegex = $this->compileRegex($this->crawlers->getAll());
		$this->compiledExclusions = $this->compileRegex($this->exclusions->getAll());

		$this->setHttpHeaders($headers);
		$this->userAgent = $this->setUserAgent($userAgent);
		/**/
		
		$this->lang_path = $phpbb_root_path . 'language/';
		$this->load();
		$this->setup();
		$this->setup_style();
	}
	// ------------------------------
	// Private Methods
	//
	
	/**
	 * Returns whether user::setup was called
	 *
	 * @return bool
	 */
	public function is_setup()
	{
		return $this->is_setup_flag;
	}	
	
	/**
	 * Load sessions
	 * @access public
	 *
	 */
	function load()
	{
		global $mx_cache, $board_config, $db, $phpbb_root_path, $mx_root_path, $phpEx;
		global $mx_request_vars, $template, $language;

		$board_config['auth_method'] = 'db';
		$cache = new mx_nothing();
		
		$this->cache			= $mx_cache;
		$this->config			= $board_config;
		$this->db               = $db;
		$this->user             = $this;
		$this->service_providers = array('user_id' => 1, 'session_id' => 0, 'provider'	=> '', 'oauth_token' => '');
		$this->phpbb_root_path = $phpbb_root_path;
		$this->mx_root_path	= $mx_root_path;
		$this->php_ext			= $phpEx;
		$this->lang_path		= $mx_root_path . 'language/';
		$this->request			= $mx_request_vars;
		$this->template			= $template;
		$this->language			= $language;
		
		// Give us some basic information
		$this->time_now				= time();
		$this->cookie_data			= array('u' => 0, 'k' => '');
		$this->update_session_page	= true;
		$this->browser				= (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : '';
		$this->referer				= (!empty($_SERVER['HTTP_REFERER'])) ? htmlspecialchars((string) $_SERVER['HTTP_REFERER']) : '';		
		$this->forwarded_for		= (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? (string) $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
		$this->host					= (!empty($_SERVER['HTTP_HOST'])) ? (string) $_SERVER['HTTP_HOST'] : 'localhost';
		$this->page					= $this->extract_current_page($mx_root_path);
		
		if (!isset($this->user_ip)) 
		{
			global $user_ip;
		
			$this->user_ip = $user_ip;
		}		
		
		//$this->page_id = $page_id ? $page_id : $this->request->request('page', MX_TYPE_INT, PAGE_INDEX);
		
		if (!isset($this->page_id)) 
		{
			global $mx_request_vars;

			$this->page_id = $mx_request_vars->request('page', MX_TYPE_INT, 1);
		}
		
		if (!isset($this->config)) 
		{
			global $board_config;

			$this->config = $board_config;
		}		
		
		if (!isset($this->mx_root_path)) 
		{
			global $mx_root_path;
		
			$this->mx_root_path = $mx_root_path;
		}
		
		if (!isset($this->phpbb_root_path)) 
		{
			global $phpbb_root_path;
		
			$this->phpbb_root_path = $phpbb_root_path;
		}		
		
		if (!isset($this->cache)) 
		{
			global $mx_cache;

			$this->cache = $mx_cache;
			
			if (!isset($this->cache)) 
			{
				$this->cache= new mx_cache();
			}
		}
		
		// Setup $this->db_tools
		if (!class_exists('mx_db_tools') && !class_exists('tools'))
		{
			include_once($this->mx_root_path . 'includes/db/db_tools.' . $phpEx);
		}
		if (class_exists('mx_db_tools'))
		{
			$this->db_tools = new mx_db_tools($this->db);
		}
		elseif (class_exists('tools'))
		{
			$this->db_tools = new tools($this->db);
		}
		
		//
		// Populate user data
		//
		$this->data = array();
		
		$this->data = $this->session_pagestart($this->user_ip, - ( MX_PORTAL_PAGES_OFFSET + $this->page_id ));
		
		//
		// Populate session_id
		$this->session_id = $this->data['session_id'];
			
		if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) 
		{
		    substr($this->data['is_bot'], false, true);
		}
		else
		{
		    substr($this->data['is_bot'], true, false);
		}
		
		$status = $this->mobile_device_detect();
		
		if (!$this->db->sql_field_exists('user_type', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_type</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_type', array('column_type_sql' => 'tinyint(2)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'user_id'), false);
		}
		
		if (!$this->db->sql_field_exists('username_clean', USERS_TABLE))
		{
			print('<p><span style="color: red;">username_clean</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'username_clean', array('column_type_sql' => 'varchar(255)', 'null' => 'NOT NULL', 'default' => '', 'after' => 'username'), false);
		}
		
		if (!$this->db->sql_field_exists('user_email_hash', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_email_hash</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_email_hash', array('column_type_sql' => 'BIGINT(20)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'user_email'), false);
		}
		
		if (!$this->db->sql_field_exists('group_id', USERS_TABLE))
		{
			print('<p><span style="color: red;">group_id</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'group_id', array('column_type_sql' => 'mediumint(8)', 'null' => 'NOT NULL', 'default' => '3', 'after' => 'user_type'), false);
		}

		if (!$this->db->sql_field_exists('user_ip', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_ip</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_ip', array('column_type_sql' => 'varchar(40)', 'null' => 'NOT NULL', 'default' => '"'.@mx_encode_ip('127.0.0.1').'"', 'after' => 'user_active'), false);
		}
		
		if (!$this->db->sql_field_exists('user_passchg', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_passchg</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_passchg', array('column_type_sql' => 'int(11)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'user_password'), false);
		}
		
		if (!$this->db->sql_field_exists('user_options', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_options</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_options', array('column_type_sql' => 'int(11)', 'null' => 'NOT NULL', 'default' => '230271', 'after' => 'user_level '), false);
		}
		
		if (!$this->db->sql_field_exists('user_newpasswd', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_newpasswd</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_newpasswd', array('column_type_sql' => 'varchar(33)', 'null' => 'NOT NULL', 'default' => '', 'after' => 'user_active'), false);
		}
		
		if (!$this->db->sql_field_exists('user_new', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_new</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_new', array('column_type_sql' => 'tinyint(1)', 'null' => 'NOT NULL', 'default' => '1', 'after' => 'user_newpasswd'), false);
		}
		
		if (!$this->db->sql_field_exists('user_inactive_reason', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_inactive_reason</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_inactive_reason', array('column_type_sql' => 'tinyint(4)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'user_last_login_try'), false);
		}
		
		if (!$this->db->sql_field_exists('user_inactive_time', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_inactive_time</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_inactive_time', array('column_type_sql' => 'int(2)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'user_inactive_reason'), false);
		}
		
		if (!$this->db->sql_field_exists('user_lastmark', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_lastmark</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_lastmark', array('column_type_sql' => 'int(11)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'user_lastvisit'), false);
		}
		
		if (!$this->db->sql_field_exists('user_lastvisit', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_lastvisit</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_lastvisit', array('column_type_sql' => 'int(11)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'user_birthday'), false);
		}
		
		if (!$this->db->sql_field_exists('user_lastpage', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_lastpage</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_lastpage', array('column_type_sql' => 'varchar(200)', 'null' => 'NOT NULL', 'default' => '""', 'after' => 'user_lastmark'), false);
		}
		
		if (!$this->db->sql_field_exists('user_lastblock', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_lastblock</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_lastblock', array('column_type_sql' => 'varchar(200)', 'null' => 'NOT NULL', 'default' => '""', 'after' => 'user_lastpage'), false);
		}
		
		if (!$this->db->sql_field_exists('user_colour', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_colour</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_colour', array('column_type_sql' => 'varchar(50)', 'null' => 'NOT NULL', 'default' => '"9E8DA7"', 'after' => 'user_passchg'), false);
		}
		
		if (!$this->db->sql_field_exists('user_avatar_width', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_avatar_width</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_avatar_width', array('column_type_sql' => 'tinyint(6)', 'null' => 'NOT NULL', 'default' => 98, 'after' => 'user_last_login_try'), false);
		}
		
		if (!$this->db->sql_field_exists('user_avatar_height', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_avatar_height</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_avatar_height', array('column_type_sql' => 'tinyint(6)', 'null' => 'NOT NULL', 'default' => 98, 'after' => 'user_last_login_try'), false);
		}
		
		if (!$this->db->sql_field_exists('user_allow_viewonline', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_allow_viewonline</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_allow_viewonline', array('column_type_sql' => 'tinyint(1)', 'null' => 'NOT NULL', 'default' => '1', 'after' => 'user_email_hash'), false);
		}
		
		if (!$this->db->sql_field_exists('user_allow_massemail', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_allow_massemail</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_allow_massemail', array('column_type_sql' => 'tinyint(1)', 'null' => 'NOT NULL', 'default' => '1', 'after' => 'user_allow_viewonline'), false);
		}
		
		if (!$this->db->sql_field_exists('user_sig', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_sig</span></p><i><p>Cheching for user_sig column in USERS_TABLE schema!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_sig', array('column_type_sql_default'	=> 'mediumtext ', 'column_type_sql' => 'mediumtext', 'null' => 'NOT NULL', 'after' => 'user_last_login_try'), false);
		}
		
		if (!$this->db->sql_field_exists('user_sig_bbcode_uid', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_sig_bbcode_uid</span></p><i><p>Cheching for user_sig_bbcode_uid column in USERS_TABLE schema!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_sig_bbcode_uid', array('column_type_sql_default'	=> 'varchar(8)', 'column_type_sql' => 'varchar(8)', 'null' => 'NOT NULL', 'after' => 'user_sig'), false);
		}
		
		if (!$this->db->sql_field_exists('user_sig_bbcode_bitfield', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_sig_bbcode_bitfield</span></p><i><p>Cheching for user_sig_bbcode_bitfield column in USERS_TABLE schema!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_sig_bbcode_bitfield', array('column_type_sql_default'	=> 'varchar(255)', 'column_type_sql' => 'varchar(255)', 'null' => 'NOT NULL', 'default' => '"1111111111111"', 'after' => 'user_sig_bbcode_uid'), false);
		}
		
		//
		// Check USERS_TABLE schema for user_agent
		//
		if (!$this->db->sql_field_exists('user_agent', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_agent</span></p><i><p>Cheching for user_agent column in USERS_TABLE schema!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_agent', array('column_type_sql_default'	=> 'varchar(255)', 'column_type_sql' => 'varchar(99)', 'null' => 'NOT NULL', 'default' => '"Mozilla/5.0 (Windows NT 10.0; rv:100.0) Gecko/20210101 Firefox/100.0.00"', 'after' => 'user_sig'), false);
		}
		
		if (!$this->db->sql_field_exists('user_form_salt', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_form_salt</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_form_salt', array('column_type_sql' => 'varchar(32)', 'null' => 'NOT NULL', 'default' => '"+"'), false);
		}
		
		//
		// Check USERS_TABLE schema for is_bot
		//
		if (!$this->db->sql_field_exists('is_bot', USERS_TABLE))
		{
			print('<p><span style="color: red;">is_bot</span></p><i><p>Cheching for is_bot column in USERS_TABLE schema!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'is_bot', array('column_type_sql'	=> 'int(2)', 'null' => 'NOT NULL', 'default' => '"0"'), false);
		}
		
		//
		// Check USERS_TABLE schema for is_mobile
		//
		if (!$this->db->sql_field_exists('is_mobile', USERS_TABLE))
		{
			print('<p><span style="color: red;">is_mobile</span></p><i><p>Cheching for is_mobile column in USERS_TABLE schema!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'is_mobile', array('column_type_sql'	=> 'int(2)', 'null' => 'NOT NULL', 'default' => '"0"', 'after' => 'is_bot'), false);
		}
		
		//
		// Check USERS_TABLE schema for device_name
		//
		if (!$this->db->sql_field_exists('device_name', USERS_TABLE))
		{
			print('<p><span style="color: red;">device_name</span></p><i><p>Cheching for device_name column in USERS_TABLE schema!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'device_name', array('column_type_sql' => 'varchar(99)', 'null' => 'NOT NULL', 'default' => '"PC"', 'after' => 'user_agent'), false);
		}
		
		/*
		if (!isset($this->data['device_name']))
		{	
			$after = '';
			$sql_arry = array(
				"ADD COLUMN  int(2) UNSIGNED NOT NULL DEFAULT 1" . $after,
				"ADD COLUMN is_mobile int(2) UNSIGNED NOT NULL DEFAULT 1",
				"ADD COLUMN user_agent varchar(255) NOT NULL",
				"ADD COLUMN device_name varchar(99) NOT NULL",
			);
			
			foreach ($sql_arry as $alter)
			{
				$sql = "ALTER TABLE " . USERS_TABLE . " " . $alter;
				$this->db->sql_return_on_error(true);
				$result = $this->db->sql_query($sql);
				$this->db->sql_return_on_error(false);
				
				// We could add error handling here...
				if (!($result))
				{		
					print_r("Could not upgrade users table at ". ' '. __LINE__ . ': '. __FILE__ . ':<br /> ' . $sql . '<br />');
				}
			}
		}
		*/
		
		substr($this->data['is_mobile'], false, $status);
		substr($this->data['device_name'], false, $status[1]);
		//$this->data['device_name'] = $this->cookie_data['mobile_name'] = $status[1];
		$cookie_mobile_name = $this->request->variable($this->config['cookie_name'] . '_mobile_name', '', true, mx_request_vars::COOKIE);
		if (!$cookie_mobile_name)
		{
			$this->user->set_cookie('mobile_name', $status[1], time() + 5 * 24 * 60 * 60, '/', false, false);
		}
		
		if (!$this->db->sql_field_exists('group_colour', GROUPS_TABLE))
		{
			print('<p><span style="color: red;"></span></p><i><p>Refreshing the groups table!</p></i>');
			$this->db_tools->sql_column_add(GROUPS_TABLE, 'group_colour', array('column_type_sql' => 'varchar(50)', 'null' => 'NOT NULL', 'after' => ''), false);
			
			/*
			-- Refreshing Groups
			*/
			$default_groups = array(
				//'Anonymous'					=> array('', 0, 0, 1, 'Personal User'),
				'GUESTS'					=> array('', 0, 0, 0, 'Default Group'),
				'REGISTERED'				=> array('', 0, 0, 0, 'Default Group'),
				'REGISTERED_COPPA'			=> array('', 0, 0, 0, 'Default Group'),
				'GLOBAL_MODERATORS'			=> array('00AA00', 2, 0, 0, 'Default Group'),
				'ADMINISTRATORS'			=> array('AA0000', 1, 1, 0, 'Default Group'),
				'BOTS'						=> array('9E8DA7', 0, 0, 0, 'Default Group'),
				'NEWLY_REGISTERED'			=> array('', 0, 0, 0, 'Default Group'),
			);
			
			/*
			-- Refreshing Groups
			*/
			$sql = 'SELECT *, group_id as g.group_type
				FROM ' . GROUPS_TABLE . '
				WHERE ' . $this->db->sql_in_set('group_name', array_keys($default_groups));
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				unset($default_groups[strtoupper($row['group_name'])]);
			}
			$this->db->sql_freeresult($result);
			
			$sql_ary = array();
			foreach ($default_groups as $name => $data)
			{
				$sql_ary[] = array(
					'group_type'				=> GROUP_CLOSED,
					'group_name'				=> (string) $name,
					'group_description'			=> (string) $data[4],
					//'group_desc_uid'				=> '',
					//'group_desc_bitfield'				=> '',
					'group_colour'				=> (string) $data[0],
					//'group_legend'					=> (int) $data[1],
					'group_moderator'			=> (int) $data[2],
					'group_single_user'			=> (int) $data[3],
				);
			}
			if (count($sql_ary))
			{
				$this->db->sql_multi_insert(GROUPS_TABLE, $sql_ary);
			}
			
			/** /
			$sql_ary[] = array(
				'group_id'						=> (int) $db->sql_nextid(),
				'user_id'							=> '',
				'user_pending'					=>  '0',
			);
			if (count($sql_ary))
			{
				$this->db->sql_multi_insert(USER_GROUP_TABLE, $sql_ary);
			}
			/**/
			
		}
		
		//
		// Check BOTS_TABLE Schema
		//
		if (!$this->db->sql_field_exists('bot_id', BOTS_TABLE))
		{
			print('<p><span style="color: red;"></span></p><i><p>Creating the BOTS_TABLE!</p></i>');
			
			/* Updating from IP 1.2.10.37
			* Make sure we have bot_name field
			*
			* old phpbb2 colums field names: 
			* 	bot_id, bot_name, last_visit, bot_visits, bot_pages list($page_id, )
			* new phpbb colums field names: 
			* 	bot_id, bot_name, bot_last_visit, bot_visit_counter
			*/
			$schema = array(
				'COLUMNS'	=> array(
					'bot_id'			=> array('UINT', NULL, 'auto_increment'),
					'bot_active'		=> array('BOOL', 1),
					'bot_name'			=> array('STEXT_UNI', ''),
					'bot_color'			=> array('VCHAR', ''),
					'user_id'			=> array('UINT', 0),
					'bot_agent'			=> array('VCHAR', ''),
					'bot_ip'			=> array('VCHAR', ''),
					'bot_last_visit'	=> array('VCHAR:11', ''),
					'bot_visit_counter'	=> array('UINT:8', 0),
				),
				'PRIMARY_KEY'	=> 'bot_id',
				'KEYS'	=> array(
					'bot_active'	=> array('INDEX', 'bot_active'),
				),
			);
			if (!$this->db->sql_table_exists(BOTS_TABLE))
			{
				$this->db_tools->sql_create_table(BOTS_TABLE, $schema);
			}
		}
		
		if ($this->isCrawler($this->request->server('HTTP_USER_AGENT')) && ($this->data['is_bot'] !== 1)) 
		{
		    substr($this->data['is_bot'], false, true);
			
			// Register new bot...
			
			$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . "
				WHERE group_name = 'BOTS'
					AND group_type = " . GROUP_CLOSED;
			if ( !($result = $this->db->sql_query($sql)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not update user info');
			}
			$add_group_id = (int) $this->db->sql_fetchfield('group_id');
			$this->db->sql_freeresult($result);
			
			$bots = array(
				'AdsBot [Google]'					=> array('AdsBot-Google', 'adsbot-support@google.com'),
				'Alexa [Bot]'						=> array('ia_archiver', 'crawler@alexa.com'),
				'Alta Vista [Bot]'					=> array('Scooter/', 'search-support@altavista.de'),
				'Ask Jeeves [Bot]'					=> array('Ask Jeeves', 'askjeevesbot@askjeeves.com'),
				'Baidu [Spider]'					=> array('Baiduspider+(', 'ir@baidu.com'),
				'Bing [Bot]'						=> array('bingbot/', 'bingbot@microsoft.com'), //bingbot-feedback@microsoft.com
				'Exabot [Bot]'						=> array('Exabot/', 'crawler@exabot.com'),
				'FAST Enterprise [Crawler]'			=> array('FAST Enterprise Crawler', 'scirus-crawler@fast.no'),
				'FAST WebCrawler [Crawler]'			=> array('FAST-WebCrawler/', 'atw-crawler@fast.no'),
				'Francis [Bot]'						=> array('http://www.neomo.de/', 'francis@neomo.de'),
				'Gigabot [Bot]'						=> array('Gigabot/', 'gigabot-support@google.com'),
				'Google Adsense [Bot]'				=> array('Mediapartners-Google', 'adsense-support@google.com'),
				'Google Desktop'					=> array('Google Desktop', 'desktop-support@google.com'),
				'Google Feedfetcher'				=> array('Feedfetcher-Google', 'feedfetcher-support@google.com'),
				'Google [Bot]'						=> array('Googlebot', 'googlebot@googlebot.com'),
				'Heise IT-Markt [Crawler]'			=> array('heise-IT-Markt-Crawler', 'info-hg@heise.de'),
				'Heritrix [Crawler]'				=> array('heritrix/1.', 'info@archive.org'),
				'IBM Research [Bot]'				=> array('ibm.com/cs/crawler', 'crawler@almaden.ibm.com'),
				'ICCrawler - ICjobs'				=> array('ICCrawler - ICjobs', 'bot@icjobs.de'),
				'ichiro [Crawler]'					=> array('ichiro/2', 'ichiro@mail.goo.ne.jp'), //ichiro@abc.ne.jp
				'Majestic-12 [Bot]'					=> array('MJ12bot/', 'help@majestic.com'),
				'Metager [Bot]'						=> array('MetagerBot/', ' office@suma-ev.de'),
				'MSN NewsBlogs'						=> array('msnbot-NewsBlogs/', 'msnbot-newsblogs@microsoft.com'),
				'MSN [Bot]'							=> array('msnbot/', 'msnbot@microsoft.com'),
				'MSNbot Media'						=> array('msnbot-media/', 'msnbot-media@microsoft.com'),
				'NG-Search [Bot]'					=> array('NG-Search/', 'info@newvisionsystems.com'),
				'Nutch [Bot]'						=> array('http://lucene.apache.org/nutch/', 'nutch-agent@lucene.apache.org'),
				'Nutch/CVS [Bot]'					=> array('NutchCVS/', 'nutch-agent@lists.sourceforge.net'),
				'OmniExplorer [Bot]'				=> array('OmniExplorer_Bot/', 'info@etherdesk.com'),
				'Online link [Validator]'			=> array('online link validator', ''),
				'psbot [Picsearch]'					=> array('psbot/0', 'custom@passionsports.ca'),
				'Seekport [Bot]'					=> array('Seekbot/', 'info@seekbot.net'),
				'Sensis [Crawler]'					=> array('Sensis Web Crawler', 'digitalenquiries@sensis.com.au'),
				'SEO Crawler'						=> array('SEO search Crawler/', ''),
				'Seoma [Crawler]'					=> array('Seoma [SEO Crawler]', 'comp-seo@seomaconsulting.com'),
				'SEOSearch [Crawler]'				=> array('SEOsearch/', 'e-search@seosearch.biz'),
				'Snappy [Bot]'						=> array('Snappy/1.1 ( http://www.urltrends.com/ )', ''),
				'Steeler [Crawler]'					=> array('http://www.tkl.iis.u-tokyo.ac.jp/~crawler/', ''),
				'Synoo [Bot]'						=> array('SynooBot/', 'synoobot'),
				'Telekom [Bot]'						=> array('crawleradmin.t-info@telekom.de', 'crawleradmin.t-info@telekom.de'),
				'TurnitinBot [Bot]'					=> array('TurnitinBot/', 'tiisupport@turnitin.com'),
				'Voyager [Bot]'						=> array('voyager/1.0', ''),
				'W3 [Sitesearch]'					=> array('W3 SiteSearch Crawler', 'sitesearch@w3.org'), //MIT/LCS (Massachusetts Institute of Technology, Laboratory for Computer Science)
				'W3C [Linkcheck]'					=> array('W3C-checklink/', 'site-comments@w3.org'),
				'W3C [Validator]'					=> array('W3C_*Validator', 'www-validator@w3.org'),
				'WiseNut [Bot]'						=> array('http://www.WISEnutbot.com', 'ZyBorg@WISEnutbot.com'),
				'YaCy [Bot]'						=> array('yacybot', '(mc@yacy.net'),
				'Yahoo MMCrawler [Bot]'				=> array('Yahoo-MMCrawler/', 'vertical-crawl-support@yahoo-inc.com'),
				'Yahoo Slurp [Bot]'					=> array('Yahoo! DE Slurp', 'slurp@inktomi.com'),
				'Yahoo [Bot]'						=> array('Yahoo! Slurp', 'crawl-support@yahoo-inc.com'),
				'YahooSeeker [Bot]'					=> array('YahooSeeker/', 'seeker-support@yahoo-inc.com'),
			);
			
			$botmatches = $this->getMatches();
			

			//$bots[$bot_name] = $bot_ary[$user_agent][$bot_email];
			foreach ($bots as $bot_name => $bot_ary)
			{
				$user_row = array(
					'user_type'			=> USER_IGNORE,
					'group_id'			=> $add_group_id,
					'username'			=> $bot_name,
					'user_regdate'		=> time(),
					'user_password'		=> '',
					'user_colour'		=> '9E8DA7',
					'user_email'		=> $bot_ary[1],
					//phpbb2/'user_timezone'	=> $this->config['board_timezone'],
					//phpbb2/'user_dateformat'	=> $this->config['default_dateformat'],
					//phpbb2/'user_lang'		=> $this->config['default_lang'],
					//phpbb2/'user_style'		=> (int) $this->config['default_style'],
					'is_bot'			=> (int) 1,
					'is_mobile'			=> (int) $this->data['is_mobile'] ,
					'user_agent'  		=> (string) $bot_ary[0],
					'user_ip'			=> (string) $this->user_ip,
					'device_name' 		=> (string) $this->data['device_name'],
					'user_allow_massemail'	=> 0,
				);
			}
			  
			$sql = "SELECT user_id, username as bot_name
					FROM " . USERS_TABLE . "
					WHERE username = '$bot_name'";
			if ( !($result = $this->db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Couldn\'t query data from bots table.', '', __LINE__, __FILE__, $sql);
			}
				
			$sql_bot_name_check = $this->db->sql_numrows($result);
			$row = $this->db->sql_fetchrow($result);
			$current_name = $row['bot_name'];
			$this->db->sql_freeresult($result);
		
			if(($sql_bot_name_check > 0) && ($current_name != $bot_name))
			{
				$bot_errors = $lang['Error_Bot_Name_Taken'];
			}
			
			if ($current_name !== $bot_name)
			{
				// Register user...
				print('<p><span style="color: red;"></span></p><i><p>Registering Your IP to the dabadase...!</p></i>');
				if (!function_exists('user_add'))
				{
					include($this->mx_root_path . 'includes/shared/phpbb2/includes/functions_user.' . $this->php_ext);
				}
				
				$user_id = (int) user_add($user_row);
				
				/*
				* Make sure we have bot_name field
				*
				*/
				$ary = array(
					'bot_active'		=> 1,
					'bot_name'			=> $bot_name,
					'user_id'			=> $user_id,
					'bot_agent'			=> $bot_ary[0],
					'bot_ip'			=> $this->user_ip,
					//'bot_style'		=> (int) $board_config['default_style'],
					'bot_color'			=> '9E8DA7',
					'bot_last_visit'	=> time(),
					'bot_visit_counter'	=> 1,
				);
				
				/*
				* Update bots table
				*/
				if ( !($result = $this->db->sql_query('INSERT INTO ' . BOTS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $ary))) )
				{
					$sql_error = $this->db->sql_error('');
					mx_message_die(GENERAL_ERROR, 'Couldn\'t insert data into bots table.', '', __LINE__, __FILE__,  '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message']);
				}
				/*
				*/
			}
			else
			{
				$user_id = (int) $row['user_id'];
				//$bot_name = (string) $row['bot_name'];
				
				$sql = "SELECT *
					FROM " . BOTS_TABLE . "
					WHERE bot_name = '$bot_name'";
				if ( !($result = $this->db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, 'Couldn\'t delete data from bots table.', '', __LINE__, __FILE__, $sql);
				}
				
				$sql_bot_name_check = $this->db->sql_numrows($result);
				$row = $this->db->sql_fetchrow($result);
				$current_name = $row['bot_name'];
				$this->db->sql_freeresult($result);
		
				if(($sql_bot_name_check > 0) && ($current_name != $bot_name))
				{
					$bot_errors = $lang['Error_Bot_Name_Taken'];
				}
				elseif(($sql_bot_name_check > 0) && ($current_name == $bot_name))
				{
					//$user_id = (int) $this->data['user_id'];
					// Update existing bot last visit time
					$sql = "UPDATE " . BOTS_TABLE . "
									SET bot_visit_counter = (bot_visit_counter + 1),
										bot_last_visit = '" . time() . "'
									WHERE bot_id = '" . $row['bot_id'] . "'";
					if ( !($result = $this->db->sql_query($sql)) )
					{
						//mx_message_die(CRITICAL_ERROR, 'Could not update bot info', '', __LINE__, __FILE__, $sql);
					}
					$this->db->sql_freeresult($result);
				}
				else
				{
					// Register user...
					print('<p><span style="color: red;"></span></p><i><p>Registering You as bot to the dabadase...!</p></i>');
					
					/*
					* Make sure we have bot_name field
					*/
					$ary = array(
						'bot_active'		=> 1,
						'bot_name'			=> $bot_name,
						'user_id'			=> $user_id,
						'bot_agent'			=> $bot_ary[0],
						'bot_ip'			=> $user_ip,
						//'bot_style'			=> (int) $board_config['default_style'],
						'bot_color'			=> '9E8DA7',
						'bot_last_visit'	=> time(),
						'bot_visit_counter'	=> 1,
					);
					
					/*
					* Update bots table
					*/
					//$this->db->sql_return_on_error(true);
					if ( !($result = $this->db->sql_query('INSERT INTO ' . BOTS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $ary))) )
					{
						$sql_error = $this->db->sql_error('');
						mx_message_die(GENERAL_ERROR, 'Couldn\'t insert data into bots table.', '', __LINE__, __FILE__,  '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message']);
					}
					//$this->db->sql_return_on_error(false);
					/*
					*/
				}
			}
		}
		else
		{
			$user_row[] = array(
				'is_bot'					=> (int) false,
				'is_mobile'					=> (int) $status,
				'device_name'				=> (string) $status[1],			
			);
			substr($this->data['is_bot'], false, false);

		}
			
		if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) 
		{
			$user_row[] = array(
				'is_bot'					=> (int) true,
				'is_mobile'					=> (int) $status,
				'device_name'				=> (string) $status[1],
				
				'user_perm_from'			=> (string) '',
			
				'user_topic_sortby_type'	=> (string) 't',
				'user_topic_sortby_dir'		=> (string) 'd',
				'user_topic_show_days'		=> (int) 0,
			
				'user_last_privmsg'			=> (int) 0,
			
				'user_post_sortby_type'		=> (string) 't',
				'user_post_sortby_dir'		=> (string) 'a',
				'user_post_show_days'		=> (int) 0,
			
				'user_new_privmsg'			=> (int) 0,
				'user_unread_privmsg'		=> (int) 0,
				'user_form_salt'			=> bin2hex(random_bytes(8)),
				'user_avatar'				=> (string) 'includes/shared/phpbb2/images/user_avatar.png',
				'user_avatar_type'			=> (int) 2,
			
			
				'user_form_salt'			=> (string) bin2hex(random_bytes(8)),
			
			);
			substr($this->data['is_bot'], false, true);
		}
		else
		{
			$user_row[] = array(
				'is_bot'					=> (int) false,
				'is_mobile'					=> (int) $status,
				'device_name'				=> (string) $status[1],
				
				'user_perm_from'			=> (string) '',
			
				'user_topic_sortby_type'	=> (string) 't',
				'user_topic_sortby_dir'		=> (string) 'd',
				'user_topic_show_days'		=> (int) 0,
			
				'user_last_privmsg'			=> (int) 0,
			
				'user_post_sortby_type'		=> (string) 't',
				'user_post_sortby_dir'		=> (string) 'a',
				'user_post_show_days'		=> (int) 0,
			
				'user_new_privmsg'			=> (int) 0,
				'user_unread_privmsg'		=> (int) 0,
				'user_form_salt'			=> bin2hex(random_bytes(8)),
				'user_avatar'				=> (string) 'includes/shared/phpbb2/images/user_avatar.png',
				'user_avatar_type'			=> (int) 2,
			
			
				'user_form_salt'			=> (string) bin2hex(random_bytes(8)),
			
			);
			substr($this->data['is_bot'], false, true);
		}

		$board_config['auth_method'] = 'db';
		$sql = 'UPDATE ' . USERS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $user_row) . " WHERE user_id = {$this->data['user_id']}";
		$db->sql_query($sql);
		$db->sql_return_on_error(false);		
			
		//define('NEED_SID', 1);
		$this->session_begin();

		// Redefine some MXP stylish userdata
		$this->data['session_logged_in'] = $this->data['user_id'] != ANONYMOUS ? 1 : 0;

		if ( $this->data['user_id'] == ANONYMOUS )
		{
			$this->data['user_type'] = -1;
		}

		switch ($this->data['user_type'])
		{
			case 3:
				$this->data['user_level'] = 1;
				$this->data['user_active'] = 1;
			break;
			case 0:
				$this->data['user_level'] = 0;
				$this->data['user_active'] = 1;
			break;
			case 1:
			case 2:
				$this->data['user_level'] = 0;
				$this->data['user_active'] = 0;
			break;
			default:
				$this->data['user_level'] = 0;
				$this->data['user_active'] = 1;
			break;
		}

		$this->data['session_id'] = $this->session_id;
		$this->data['user_session_page'] = $this->data['session_page'];
	}

	/**
	* Extract current session page
	*
	* @param string $root_path current root path (phpbb_root_path)
	*/
	function extract_current_page($root_path)
	{
		global $phpBB2;
		
		$page_array = array();

		// First of all, get the request uri...
		$script_name = (!empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : getenv('PHP_SELF');
		$args = (!empty($_SERVER['QUERY_STRING'])) ? explode('&', $_SERVER['QUERY_STRING']) : explode('&', getenv('QUERY_STRING'));

		// If we are unable to get the script name we use REQUEST_URI as a failover and note it within the page array for easier support...
		if (!$script_name)
		{
			$script_name = (!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
			$script_name = (($pos = strpos($script_name, '?')) !== false) ? substr($script_name, 0, $pos) : $script_name;
			$page_array['failover'] = 1;
		}

		// Replace backslashes and doubled slashes (could happen on some proxy setups)
		$script_name = str_replace(array('\\', '//'), '/', $script_name);

		// Now, remove the sid and let us get a clean query string...
		foreach ($args as $key => $argument)
		{
			if (strpos($argument, 'sid=') === 0 || strpos($argument, '_f_=') === 0)
			{
				unset($args[$key]);
			}
		}

		// The following examples given are for an request uri of {path to the phpbb directory}/adm/index.php?i=10&b=2

		// The current query string
		$query_string = trim(implode('&', $args));

		// basenamed page name (for example: index.php)
		$page_name = basename($script_name);
		$page_name = urlencode(htmlspecialchars($page_name));

		// current directory within the phpBB root (for example: adm)
		$root_dirs = explode('/', str_replace('\\', '/', $phpBB2->phpbb_realpath($root_path)));
		$page_dirs = explode('/', str_replace('\\', '/', $phpBB2->phpbb_realpath('./')));
		$intersection = array_intersect_assoc($root_dirs, $page_dirs);

		$root_dirs = array_diff_assoc($root_dirs, $intersection);
		$page_dirs = array_diff_assoc($page_dirs, $intersection);

		$page_dir = str_repeat('../', sizeof($root_dirs)) . implode('/', $page_dirs);

		if ($page_dir && substr($page_dir, -1, 1) == '/')
		{
			$page_dir = substr($page_dir, 0, -1);
		}

		// Current page from phpBB root (for example: adm/index.php?i=10&b=2)
		$page = (($page_dir) ? $page_dir . '/' : '') . $page_name . (($query_string) ? "?$query_string" : '');

		// The script path from the webroot to the current directory (for example: /phpBB3/adm/) : always prefixed with / and ends in /
		$script_path = trim(str_replace('\\', '/', dirname($script_name)));

		// The script path from the webroot to the phpBB root (for example: /phpBB3/)
		$script_dirs = explode('/', $script_path);
		array_splice($script_dirs, -sizeof($page_dirs));
		$root_script_path = implode('/', $script_dirs) . (sizeof($root_dirs) ? '/' . implode('/', $root_dirs) : '');

		// We are on the base level (phpBB root == webroot), lets adjust the variables a bit...
		if (!$root_script_path)
		{
			$root_script_path = ($page_dir) ? str_replace($page_dir, '', $script_path) : $script_path;
		}

		$script_path .= (substr($script_path, -1, 1) == '/') ? '' : '/';
		$root_script_path .= (substr($root_script_path, -1, 1) == '/') ? '' : '/';

		$forum_id = (isset($_REQUEST['f']) && $_REQUEST['f'] > 0 && $_REQUEST['f'] < 16777215) ? (int) $_REQUEST['f'] : 0;

		$page_array += array(
			'page_name'			=> $page_name,
			'page_dir'			=> $page_dir,

			'query_string'		=> $query_string,
			'script_path'		=> str_replace(' ', '%20', htmlspecialchars($script_path)),
			'root_script_path'	=> str_replace(' ', '%20', htmlspecialchars($root_script_path)),

			'page'				=> $page,
			'forum'				=> $forum_id,
		);

		return $page_array;
	}

	/**
	* Get valid hostname/port. HTTP_HOST is used, SERVER_NAME if HTTP_HOST not present.
	*/
	function extract_current_hostname()
	{
		global $config;

		// Get hostname
		$host = (!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : ((!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : getenv('SERVER_NAME'));

		// Should be a string and lowered
		$host = (string) strtolower($host);

		// If host is equal the cookie domain or the server name (if config is set), then we assume it is valid
		if ((isset($config['cookie_domain']) && $host === $config['cookie_domain']) || (isset($config['server_name']) && $host === $config['server_name']))
		{
			return $host;
		}

		// Is the host actually a IP? If so, we use the IP... (IPv4)
		if (long2ip(ip2long($host)) === $host)
		{
			return $host;
		}

		// Now return the hostname (this also removes any port definition). The http:// is prepended to construct a valid URL, hosts never have a scheme assigned
		$host = @parse_url('http://' . $host);
		$host = (!empty($host['host'])) ? $host['host'] : '';

		// Remove any portions not removed by parse_url (#)
		$host = str_replace('#', '', $host);

		// If, by any means, the host is now empty, we will use a "best approach" way to guess one
		if (empty($host))
		{
			if (!empty($config['server_name']))
			{
				$host = $config['server_name'];
			}
			else if (!empty($config['cookie_domain']))
			{
				$host = (strpos($config['cookie_domain'], '.') === 0) ? substr($config['cookie_domain'], 1) : $config['cookie_domain'];
			}
			else
			{
				// Set to OS hostname or localhost
				$host = (function_exists('php_uname')) ? php_uname('n') : 'localhost';
			}
		}

		// It may be still no valid host, but for sure only a hostname (we may further expand on the cookie domain... if set)
		return $host;
	}
	
	/*
	 * This class is part of Crawler Detect - the web crawler detection library.
	 *
	 * (c) Mark Beech <m@rkbee.ch>
	 *
	 * This source file is subject to the MIT license that is bundled
	 * with this source code in the file fixtures\LICENSE.
	 */
	 
	// ------------------------------
	// Public Methods
	// 
	 
    /**
	* Compile the regex patterns into one regex string.
	*
	* @param array
	* 
	* @return string
	*/
    public function compileRegex($patterns)
    {
        return '('.implode('|', $patterns).')';
    }

    /**
	* Set HTTP headers.
	*
	* @param array|null $httpHeaders
	*/
	public function setHttpHeaders($httpHeaders)
	{
		// Use global _SERVER if $httpHeaders aren't defined.
		if (! is_array($httpHeaders) || ! count($httpHeaders))
		{
			// enable super globals to get literal value
			$super_globals_disabled = $this->request->super_globals_disabled();
			
			if ($super_globals_disabled)
			{
				$this->request->enable_super_globals();
			}
			
			$httpHeaders = $_SERVER;
			
			if ($super_globals_disabled)
			{
				$this->request->disable_super_globals();
			}
		}
		
		// Clear existing headers.
		$this->httpHeaders = array();
		// Only save HTTP headers. In PHP land, that means
		// only _SERVER vars that start with HTTP_.
		foreach ($httpHeaders as $key => $value)
		{
            if (strpos($key, 'HTTP_') === 0) 
			{
                $this->httpHeaders[$key] = $value;
            }
        }
		unset($httpHeaders);
    }

    /**
	* Return user agent headers.
	*
	* @return array
	*/
    public function getUaHttpHeaders()
    {
        return $this->uaHttpHeaders->getAll();
    }

    /**
	* Set the user agent.
	*
	* @param string $userAgent
	*/
    public function setUserAgent($userAgent)
    {
        if (is_null($userAgent)) 
		{
            foreach ($this->getUaHttpHeaders() as $altHeader) 
			{
                if (isset($this->httpHeaders[$altHeader])) 
				{
                    $userAgent .= $this->httpHeaders[$altHeader].' ';
                }
            }
        }
        return $userAgent;
	}

    /**
	* Check user agent string against the regex.
	*
	* @param string|null $userAgent
	*
	* @return bool
	*/
    public function isCrawler($userAgent = null)
    {
        $agent = $userAgent ?: $this->userAgent;

        $agent = preg_replace('/'.$this->compiledExclusions.'/i', '', $agent);

        if (strlen(trim($agent)) == 0) 
		{
            return false;
        }

        $result = preg_match('/'.$this->compiledRegex.'/i', trim($agent), $matches);
		//print_r($result);
        if ($matches)
		{
            $this->matches = $matches;
        }

        return (bool) $result;
	}
	
	/**
	* Return the matches.
	*
	* @return string|null
	*/
    public function getMatches()
    {
        return isset($this->matches[0]) ? $this->matches[0] : null;
    }

	/**
	* Start session management
	*
	* This is where all session activity begins. We gather various pieces of
	* information from the client and server. We test to see if a session already
	* exists. If it does, fine and dandy. If it doesn't we'll go on to create a
	* new one ... pretty logical heh? We also examine the system load (if we're
	* running on a system which makes such information readily available) and
	* halt if it's above an admin definable limit.
	*
	* @param bool $update_session_page if true the session page gets updated.
	*			This can be set to circumvent certain scripts to update the users last visited page.
	*/
	function session_begin($update_session_page = true)
	{
		global $phpEx, $SID, $_SID, $phpbb_auth, $phpBB3, $_EXTRA_URL, $db, $board_config, $mx_root_path, $phpbb_root_path, $page_id;

		// Give us some basic information
		$this->time_now					= time();
		$this->cookie_data				= array('u' => 0, 'k' => '');
		$this->update_session_page	= $update_session_page;
		$this->browser					= (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : '';
		$this->referer						= (!empty($_SERVER['HTTP_REFERER'])) ? htmlspecialchars((string) $_SERVER['HTTP_REFERER']) : '';		
		$this->forwarded_for				= (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? (string) $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
		$this->host							= (!empty($_SERVER['HTTP_HOST'])) ? (string) $_SERVER['HTTP_HOST'] : 'localhost';
		$this->page						= $this->extract_current_page($phpbb_root_path);

		// if the forwarded for header shall be checked we have to validate its contents
		if ($board_config['forwarded_for_check'])
		{
			$this->forwarded_for = preg_replace('#, +#', ', ', $this->forwarded_for);

			// Whoa these look impressive!
			// The code to generate the following two regular expressions which match valid IPv4/IPv6 addresses
			// can be found in the develop directory
			$ipv4 = $phpBB3->get_preg_expression('ipv4'); //'#^(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$#';
			$ipv6 = $phpBB3->get_preg_expression('ipv6'); //'#^(?:(?:(?:[\dA-F]{1,4}:){6}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:::(?:[\dA-F]{1,4}:){5}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:):(?:[\dA-F]{1,4}:){4}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,2}:(?:[\dA-F]{1,4}:){3}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,3}:(?:[\dA-F]{1,4}:){2}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,4}:(?:[\dA-F]{1,4}:)(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,5}:(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,6}:[\dA-F]{1,4})|(?:(?:[\dA-F]{1,4}:){1,7}:))$#i';
			
			// split the list of IPs
			$ips = explode(', ', $this->forwarded_for);
			foreach ($ips as $ip)
			{
				// check IPv4 first, the IPv6 is hopefully only going to be used very seldomly
				if (!empty($ip) && !preg_match($ipv4, $ip) && !preg_match($ipv6, $ip))
				{
					// contains invalid data, don't use the forwarded for header
					$this->forwarded_for = '';
					break;
				}
			}
		}
		else
		{
			$this->forwarded_for = '';
		}
		
		// Add forum to the page for tracking online users - also adding a "x" to the end to properly identify the number
		$this->page['page'] .= (isset($_REQUEST['f'])) ? ((strpos($this->page['page'], '?') !== false) ? '&' : '?') . '_f_=' . (int) $_REQUEST['f'] . 'x' : '';

		if (isset($_COOKIE[$board_config['cookie_name'] . '_sid']) || isset($_COOKIE[$board_config['cookie_name'] . '_u']))
		{
			$this->cookie_data['u'] = $phpBB3->request_var($board_config['cookie_name'] . '_u', 0, false, true);
			$this->cookie_data['k'] = $phpBB3->request_var($board_config['cookie_name'] . '_k', '', false, true);
			$this->session_id 		= $phpBB3->request_var($board_config['cookie_name'] . '_sid', '', false, true);

			// original code: $SID = (defined('NEED_SID')) ? 'sid=' . $this->session_id : 'sid=';
			$SID = (defined('NEED_SID')) ? 'sid=' . $this->session_id : '';
			$_SID = (defined('NEED_SID')) ? $this->session_id : '';

			if (empty($this->session_id))
			{
				$this->session_id = $_SID = $phpBB3->request_var('sid', '');
				$SID = 'sid=' . $this->session_id;
				$this->cookie_data = array('u' => 0, 'k' => '');
			}
		}
		else
		{
			$this->session_id = $_SID = $phpBB3->request_var('sid', '');
			$SID = 'sid=' . $this->session_id;
		}

		$_EXTRA_URL = array();

		// Why no forwarded_for et al? Well, too easily spoofed. With the results of my recent requests
		// it's pretty clear that in the majority of cases you'll at least be left with a proxy/cache ip.
		$this->ip = (!empty($_SERVER['REMOTE_ADDR'])) ? htmlspecialchars($_SERVER['REMOTE_ADDR']) : '';
		$this->ip = preg_replace('#[ ]{2,}#', ' ', str_replace(array(',', ' '), ' ', $this->ip));

		// split the list of IPs
		$ips = explode(' ', $this->ip);

		// Default IP if REMOTE_ADDR is invalid
		$this->ip = '127.0.0.1';

		foreach ($ips as $ip)
		{
			// check IPv4 first, the IPv6 is hopefully only going to be used very seldomly
			if (!empty($ip) && !preg_match($phpBB3->get_preg_expression('ipv4'), $ip) && !preg_match($phpBB3->get_preg_expression('ipv6'), $ip))
			{
				// Just break
				break;
			}

			// Quick check for IPv4-mapped address in IPv6
			if (stripos($ip, '::ffff:') === 0)
			{
				$ipv4 = substr($ip, 7);

				if (preg_match($phpBB3->get_preg_expression('ipv4'), $ipv4))
				{
					$ip = $ipv4;
				}
			}

			// Use the last in chain
			$this->ip = $ip;
		}
		
		$this->load = false;

		// Load limit check (if applicable)
		if ($board_config['limit_load'] || $board_config['limit_search_load'])
		{
			if ($load = @file_get_contents('/proc/loadavg'))
			{
				$this->load = array_slice(explode(' ', $load), 0, 1);
				$this->load = floatval($this->load[0]);
			}
			else
			{
				set_config('limit_load', '0');
				set_config('limit_search_load', '0');
			}
		}

		// Is session_id is set or session_id is set and matches the url param if required
		if (!empty($this->session_id) && (!defined('NEED_SID') || (isset($_GET['sid']) && $this->session_id === $_GET['sid'])) )
		{
			$sql = 'SELECT u.*, s.*
				FROM ' . SESSIONS_TABLE . ' s, ' . USERS_TABLE . " u
				WHERE s.session_id = '" . $db->sql_escape($this->session_id) . "'
					AND u.user_id = s.session_user_id";
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
			$this->data = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			// Did the session exist in the DB?
			if (isset($this->data['user_id']))
			{
				// Validate IP length according to admin ... enforces an IP
				// check on bots if admin requires this
				//$quadcheck = ($board_config['ip_check_bot'] && $this->data['user_type'] & USER_BOT) ? 4 : $board_config['ip_check'];

				if (strpos($this->ip, ':') !== false && strpos($this->data['session_ip'], ':') !== false)
				{
					$s_ip = short_ipv6($this->data['session_ip'], $board_config['ip_check']);
					$u_ip = short_ipv6($this->ip, $board_config['ip_check']);
				}
				else
				{
					$s_ip = implode('.', array_slice(explode('.', $this->data['session_ip']), 0, $board_config['ip_check']));
					$u_ip = implode('.', array_slice(explode('.', $this->ip), 0, $board_config['ip_check']));
				}

				$s_browser = ($board_config['browser_check']) ? strtolower(substr($this->data['session_browser'], 0, 149)) : '';
				$u_browser = ($board_config['browser_check']) ? strtolower(substr($this->browser, 0, 149)) : '';

				$s_forwarded_for = ($board_config['forwarded_for_check']) ? substr($this->data['session_forwarded_for'], 0, 254) : '';
				$u_forwarded_for = ($board_config['forwarded_for_check']) ? substr($this->forwarded_for, 0, 254) : '';
				
				// referer checks
				// The @ before $config['referer_validation'] suppresses notices present while running the updater
				$check_referer_path = (@$board_config['referer_validation'] == REFERER_VALIDATE_PATH);
				$referer_valid = true;

				// we assume HEAD and TRACE to be foul play and thus only whitelist GET
				if (@$board_config['referer_validation'] && isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) !== 'get')
				{
					$referer_valid = $this->validate_referer($check_referer_path);
				}
				
				if ($u_ip === $s_ip && $s_browser === $u_browser && $s_forwarded_for === $u_forwarded_for)
				{
					$session_expired = false;

					// Check whether the session is still valid if we have one
					$method = basename(trim($board_config['auth_method']));

					if ((@include_once $mx_root_path . "includes/sessions/rhea/provider/" . $method . ".$phpEx") === false)
					{
						mx_message_die(CRITICAL_ERROR, 'File ' . $mx_root_path . "includes/sessions/rhea/provider/" . $method . ".$phpEx" . ' couldn\'t be opened.');
					}

					if (class_exists($method))
					{
						eval( '$provider = new ' . $method . '();' );
						//if (method_exists($provider->$method))
					}
					else
					{
						mx_message_die(CRITICAL_ERROR, 'Class not found: ' . 'in file ' . $mx_root_path . "includes/sessions/rhea/provider/" . $method . ".$phpEx" . ' couldn\'t be opened.');
					}

					//phpBB Olympus login
					/* * /
					$method = 'login_' . $method;
					if (function_exists($method))
					{
						if (!$method($this->data))
						{
							$session_expired = true;
						}
					}
					else
					{
						mx_message_die(CRITICAL_ERROR, 'File ' . $mx_root_path . "includes/shared/phpbb3/auth/provider/" . $method . ".$phpEx" . ' couldn\'t be opened.');
					}
					/* */

					//phpBB Rhea Login
					$ret = $provider->validate_session($this->data);
					
					if ($ret !== null && !$ret)
					{
						$session_expired = true;
					}

					if (!$session_expired)
					{
						// Check the session length timeframe if autologin is not enabled.
						// Else check the autologin length... and also removing those having autologin enabled but no longer allowed board-wide.
						if (!$this->data['session_autologin'])
						{
							if ($this->data['session_time'] < $this->time_now - ($board_config['session_length'] + 60))
							{
								$session_expired = true;
							}
						}
						else if (!$board_config['allow_autologin'] || ($board_config['max_autologin_time'] && $this->data['session_time'] < $this->time_now - (86400 * (int) $board_config['max_autologin_time']) + 60))
						{
							$session_expired = true;
						}
					}

					if (!$session_expired)
					{
						// Only update session DB a minute or so after last update or if page changes
						if ($this->time_now - $this->data['session_time'] > 60 || ($this->update_session_page && $this->data['session_page'] != $this->page['page']))
						{
							$sql_ary = array('session_time' => $this->time_now);

							if ($this->update_session_page)
							{
								$sql_ary['session_page'] = substr($this->page['page'], 0, 199);
								$sql_ary['session_forum_id'] = !empty($this->page['forum']) ? $this->page['forum'] : $page_id; //Added for phpBB 3.0.2 by Ory								
							}

							$db->sql_return_on_error(true);

							$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
								WHERE session_id = '" . $db->sql_escape($this->session_id) . "'";
							$result = $db->sql_query($sql);

							$db->sql_return_on_error(false);

							// If the database is not yet updated, there will be an error due to the session_forum_id
							// @todo REMOVE for 3.0.2
							if ($result === false)
							{
								unset($sql_ary['session_forum_id']);

								$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
									WHERE session_id = '" . $db->sql_escape($this->session_id) . "'";
								$db->sql_query($sql);
							}

							if ($this->data['user_id'] != ANONYMOUS && !empty($board_config['new_member_post_limit']) && $this->data['user_new'] && $board_config['new_member_post_limit'] <= $this->data['user_posts'])
							{
								$this->leave_newly_registered();
							}
						}
						
						// Redefine some MXP stylish userdata
						//$this->data['session_logged_in'] = $this->data['user_id'] != ANONYMOUS ? 1 : 0;

						if ( $this->data['user_id'] == ANONYMOUS )
						{
							$this->data['user_type'] = -1;
						}

						switch ($this->data['user_type'])
						{
							case 3:
								$this->data['user_level'] = 1;
								$this->data['user_active'] = 1;
							break;
							case 0:
								$this->data['user_level'] = 0;
								$this->data['user_active'] = 1;
							break;
							case 1:
							case 2:
								$this->data['user_level'] = 0;
								$this->data['user_active'] = 0;
							break;
							default:
								global $phpbb_auth;
								if (!isset($phpbb_auth) || !is_object($phpbb_auth))
								{
									$phpbb_auth = new phpbb_auth();
								}
								$this->data['user_level'] = $phpbb_auth->acl_get('a_') ? 1 : ($phpbb_auth->acl_get('m_') ? 2 : 0);
								$this->data['user_active'] = 1;
							break;
						}

						$this->data['session_id'] = $this->session_id;
						$this->data['user_session_page'] = $this->data['session_page'];

						// Redefine some MXP stylish userdata
						$this->data['session_logged_in'] = $this->data['user_id'] != ANONYMOUS ? 1 : 0;
						$this->data['is_registered'] = ($this->data['user_id'] != ANONYMOUS && ($this->data['user_type'] == USER_NORMAL || $this->data['user_type'] == USER_FOUNDER)) ? true : false;
						$this->data['is_bot'] = (!$this->data['is_registered'] && $this->data['user_id'] != ANONYMOUS) ? true : false;
						$this->data['user_lang'] = basename($this->data['user_lang']);

						// Is user banned? Are they excluded? Won't return on ban, exists within method
						//$this->check_ban_for_current_session($board_config);

						return true;
					}
					
				}
				else
				{
					// Added logging temporarly to help debug bugs...
					if (defined('DEBUG_EXTRA') && $this->data['user_id'] != ANONYMOUS)
					{
						if ($referer_valid)
						{
							mx_add_log('critical', 'LOG_IP_BROWSER_FORWARDED_CHECK', $u_ip, $s_ip, $u_browser, $s_browser, htmlspecialchars($u_forwarded_for), htmlspecialchars($s_forwarded_for));
						}
						else
						{
							mx_add_log('critical', 'LOG_REFERER_INVALID', $this->referer);
						}
					}
				}
			}
		}

		// If we reach here then no (valid) session exists. So we'll create a new one
		return $this->session_create();
	}

	/**
	* Create a new session
	*
	* If upon trying to start a session we discover there is nothing existing we
	* jump here. Additionally this method is called directly during login to regenerate
	* the session for the specific user. In this method we carry out a number of tasks;
	* garbage collection, (search)bot checking, banned user comparison. Basically
	* though this method will result in a new session for a specific user.
	*/
	function session_create($user_id = false, $set_admin = false, $persist_login = false, $viewonline = true)
	{
		global $SID, $_SID, $phpBB2, $phpBB3, $db, $board_config, $cache, $mx_root_path, $phpbb_root_path, $phpEx, $mx_backend;

		$this->data = array();

		/* Garbage collection ... remove old sessions updating user information
		// if necessary. It means (potentially) 11 queries but only infrequently
		if ($this->time_now > $board_config['session_last_gc'] + $board_config['session_gc'])
		{
			$this->session_gc();
		}*/

		// Do we allow autologin on this board? No? Then override anything
		// that may be requested here
		if (!$board_config['allow_autologin'])
		{
			$this->cookie_data['k'] = $persist_login = false;
		}

		/**
		* Here we do a bot check, oh er saucy! No, not that kind of bot
		* check. We loop through the list of bots defined by the admin and
		* see if we have any useragent and/or IP matches. If we do, this is a
		* bot, act accordingly
		*/
		$bot = false;
		$active_bots = $mx_backend->obtain_bots();

		foreach ($active_bots as $row)
		{
			if ($row['bot_agent'] && strpos(strtolower($this->browser), strtolower($row['bot_agent'])) !== false)
			{
				$bot = $row['user_id'];
			}

			// If ip is supplied, we will make sure the ip is matching too...
			if ($row['bot_ip'] && ($bot || !$row['bot_agent']))
			{
				// Set bot to false, then we only have to set it to true if it is matching
				$bot = false;

				foreach (explode(',', $row['bot_ip']) as $bot_ip)
				{
					if (strpos($this->ip, $bot_ip) === 0)
					{
						$bot = (int) $row['user_id'];
						break;
					}
				}
			}

			if ($bot)
			{
				break;
			}
		}

		$method = basename(trim($board_config['auth_method']));

		include_once($mx_root_path . 'includes/shared/phpbb3/includes/auth/auth_' . $method . '.' . $phpEx);

		$method = 'autologin_' . $method;
		if (function_exists($method))
		{
			$this->data = $method();

			if (sizeof($this->data))
			{
				$this->cookie_data['k'] = '';
				$this->cookie_data['u'] = $this->data['user_id'];
			}
		}

		// If we're presented with an autologin key we'll join against it.
		// Else if we've been passed a user_id we'll grab data based on that
		if (isset($this->cookie_data['k']) && $this->cookie_data['k'] && $this->cookie_data['u'] && !sizeof($this->data))
		{
			$sql = 'SELECT u.*
				FROM ' . USERS_TABLE . ' u, ' . SESSIONS_KEYS_TABLE . ' k
				WHERE u.user_id = ' . (int) $this->cookie_data['u'] . '
					AND u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ")
					AND k.user_id = u.user_id
					AND k.key_id = '" . $db->sql_escape(md5($this->cookie_data['k'])) . "'";
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
			$this->data = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			$bot = false;
		}
		else if ($user_id !== false && !sizeof($this->data))
		{
			$this->cookie_data['k'] = '';
			$this->cookie_data['u'] = $user_id;

			$sql = 'SELECT *
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . (int) $this->cookie_data['u'] . '
					AND user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')';
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
			$this->data = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			$bot = false;
		}

		// If no data was returned one or more of the following occurred:
		// Key didn't match one in the DB
		// User does not exist
		// User is inactive
		// User is bot
		if (!sizeof($this->data) || !is_array($this->data))
		{
			$this->cookie_data['k'] = '';
			$this->cookie_data['u'] = ($bot) ? $bot : ANONYMOUS;

			if (!$bot)
			{
				$sql = 'SELECT u.*, s.*
					FROM ' . USERS_TABLE . ' u
					LEFT JOIN ' . SESSIONS_TABLE . ' s ON (s.session_user_id = u.user_id)
					WHERE u.user_id = ' . (int) $this->cookie_data['u'];
			}
			else
			{
				// We give bots always the same session if it is not yet expired.
				$sql = 'SELECT u.*, s.*
					FROM ' . USERS_TABLE . ' u
					LEFT JOIN ' . SESSIONS_TABLE . ' s ON (s.session_user_id = u.user_id)
					WHERE u.user_id = ' . (int) $bot;
			}
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
			
			$this->data = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		}

		if ($this->data['user_id'] != ANONYMOUS && !$bot)
		{
			$this->data['session_last_visit'] = (isset($this->data['session_time']) && $this->data['session_time']) ? $this->data['session_time'] : (($this->data['user_lastvisit']) ? $this->data['user_lastvisit'] : time());
		}
		else
		{
			$this->data['session_last_visit'] = $this->time_now;
		}

		// Force user id to be integer...
		$this->data['user_id'] = (int) $this->data['user_id'];
		$this->data['session_id'] = $this->session_id;
		$this->data['user_session_page'] = $this->data['session_page'];
		// Redefine some MXP stylish userdata
		$this->data['session_logged_in'] = $this->data['user_id'] != ANONYMOUS ? 1 : 0;
		$this->data['is_registered'] = ($this->data['user_id'] != ANONYMOUS && ($this->data['user_type'] == USER_NORMAL || $this->data['user_type'] == USER_FOUNDER)) ? true : false;
		$this->data['is_bot'] = (!$this->data['is_registered'] && $this->data['user_id'] != ANONYMOUS) ? true : false;
		$this->data['user_lang'] = basename($this->data['user_lang']);
		// At this stage we should have a filled data array, defined cookie u and k data.
		// data array should contain recent session info if we're a real user and a recent
		// session exists in which case session_id will also be set

		// Is user banned? Are they excluded? Won't return on ban, exists within method
		if ($this->data['user_type'] != USER_FOUNDER)
		{
			if (!$board_config['forwarded_for_check'])
			{
				$this->check_ban($this->data['user_id'], $this->ip);
			}
			else
			{
				$ips = explode(', ', $this->forwarded_for);
				$ips[] = $this->ip;
				$this->check_ban($this->data['user_id'], $ips);
			}
		}

		$this->data['is_registered'] = (!$bot && $this->data['user_id'] != ANONYMOUS && ($this->data['user_type'] == USER_NORMAL || $this->data['user_type'] == USER_FOUNDER)) ? true : false;
		$this->data['is_bot'] = ($bot) ? true : false;

		// If our friend is a bot, we re-assign a previously assigned session
		if ($this->data['is_bot'] && $bot == $this->data['user_id'] && $this->data['session_id'])
		{
			// Only assign the current session if the ip, browser and forwarded_for match...
			if (strpos($this->ip, ':') !== false && strpos($this->data['session_ip'], ':') !== false)
			{
				$s_ip = short_ipv6($this->data['session_ip'], $board_config['ip_check']);
				$u_ip = short_ipv6($this->ip, $board_config['ip_check']);
			}
			else
			{
				$s_ip = implode('.', array_slice(explode('.', $this->data['session_ip']), 0, $board_config['ip_check']));
				$u_ip = implode('.', array_slice(explode('.', $this->ip), 0, $board_config['ip_check']));
			}

			$s_browser = ($board_config['browser_check']) ? strtolower(substr($this->data['session_browser'], 0, 149)) : '';
			$u_browser = ($board_config['browser_check']) ? strtolower(substr($this->browser, 0, 149)) : '';

			$s_forwarded_for = ($board_config['forwarded_for_check']) ? substr($this->data['session_forwarded_for'], 0, 254) : '';
			$u_forwarded_for = ($board_config['forwarded_for_check']) ? substr($this->forwarded_for, 0, 254) : '';

			if ($u_ip === $s_ip && $s_browser === $u_browser && $s_forwarded_for === $u_forwarded_for)
			{
				$this->session_id = $this->data['session_id'];

				// Only update session DB a minute or so after last update or if page changes
				if ($this->time_now - $this->data['session_time'] > 60 || ($this->update_session_page && $this->data['session_page'] != $this->page['page']))
				{
					$this->data['session_time'] = $this->data['session_last_visit'] = $this->time_now;

					$sql_ary = array('session_time' => $this->time_now, 'session_last_visit' => $this->time_now, 'session_admin' => 0);

					if ($this->update_session_page)
					{
						$sql_ary['session_page'] = substr($this->page['page'], 0, 199);
					}

					$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
						WHERE session_id = '" . $db->sql_escape($this->session_id) . "'";
					if (!$db->sql_query($sql))
					{
						mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
					}

					// Update the last visit time
					$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_lastvisit = ' . (int) $this->data['session_time'] . '
						WHERE user_id = ' . (int) $this->data['user_id'];
					if (!$db->sql_query($sql))
					{
						mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
					}
				}

				$SID = '?sid=';
				$_SID = '';
				return true;
			}
			else
			{
				// If the ip and browser does not match make sure we only have one bot assigned to one session
				$db->sql_query('DELETE FROM ' . SESSIONS_TABLE . ' WHERE session_user_id = ' . $this->data['user_id']);
			}
		}

		$session_autologin = (($this->cookie_data['k'] || $persist_login) && $this->data['is_registered']) ? true : false;
		$set_admin = ($set_admin && $this->data['is_registered']) ? true : false;

		// Create or update the session
		$sql_ary = array(
			'session_user_id'		=> (int) $this->data['user_id'],
			'session_start'			=> (int) $this->time_now,
			'session_last_visit'	=> (int) $this->data['session_last_visit'],
			'session_time'			=> (int) $this->time_now,
			'session_browser'		=> (string) substr($this->browser, 0, 149),
			'session_forwarded_for'	=> (string) $this->forwarded_for,
			'session_ip'			=> (string) $this->ip,
			'session_autologin'		=> ($session_autologin) ? 1 : 0,
			'session_admin'			=> ($set_admin) ? 1 : 0,
			'session_viewonline'	=> ($viewonline) ? 1 : 0,
		);

		if ($this->update_session_page)
		{
			$sql_ary['session_page'] = (string) substr($this->page['page'], 0, 199);
		}

		$db->sql_return_on_error(true);

		$sql = 'DELETE
			FROM ' . SESSIONS_TABLE . '
			WHERE session_id = \'' . $db->sql_escape($this->session_id) . '\'
				AND session_user_id = ' . ANONYMOUS;

		if (!defined('IN_ERROR_HANDLER') && (!$this->session_id || !$db->sql_query($sql) || !$db->sql_affectedrows()))
		{
			// Limit new sessions in 1 minute period (if required)
			if (empty($this->data['session_time']) && $board_config['active_sessions'])
			{
				$sql = 'SELECT COUNT(session_id) AS sessions
					FROM ' . SESSIONS_TABLE . '
					WHERE session_time >= ' . ($this->time_now - 60);
				if (!$result = $db->sql_query($sql))
				{
					mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if ((int) $row['sessions'] > (int) $board_config['active_sessions'])
				{
					header('HTTP/1.1 503 Service Unavailable');
					trigger_error('BOARD_UNAVAILABLE');
				}
			}
		}

		$this->session_id = $this->data['session_id'] = md5($phpBB3->unique_id());

		$sql_ary['session_id'] = (string) $this->session_id;
		$sql_ary['session_page'] = (string) substr($this->page['page'], 0, 199);

		$sql = 'INSERT INTO ' . SESSIONS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
		if (!$db->sql_query($sql))
		{
			mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
		}

		$db->sql_return_on_error(false);

		// Regenerate autologin/persistent login key
		if ($session_autologin)
		{
			$this->set_login_key();
		}

		// refresh data
		$SID = '?sid=' . $this->session_id;
		$_SID = $this->session_id;
		$this->data = array_merge($this->data, $sql_ary);

		if (!$bot)
		{
			$cookie_expire = $this->time_now + (($board_config['max_autologin_time']) ? 86400 * (int) $board_config['max_autologin_time'] : 31536000);

			$this->set_cookie('u', $this->cookie_data['u'], $cookie_expire);
			$this->set_cookie('k', $this->cookie_data['k'], $cookie_expire);
			$this->set_cookie('sid', $this->session_id, $cookie_expire);

			unset($cookie_expire);
		}
		else
		{
			$this->data['session_time'] = $this->data['session_last_visit'] = $this->time_now;

			// Update the last visit time
			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_lastvisit = ' . (int) $this->data['session_time'] . '
				WHERE user_id = ' . (int) $this->data['user_id'];
				
				if (!$db->sql_query($sql))
				{
					mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
				}

			$SID = '?sid=';
			$_SID = '';
		}

		return true;
	}
	//
	// Checks for a given user session, tidies session table and updates user
	// sessions at each page refresh
	//
	function session_pagestart($user_ip, $thispage_id)
	{
		global $db, $lang, $board_config;
		global $mx_request_vars, $SID;

		$cookiename = $board_config['cookie_name'];
		$cookiepath = $board_config['cookie_path'];
		$cookiedomain = $board_config['cookie_domain'];
		$cookiesecure = $board_config['cookie_secure'];

		$current_time = time();
		unset($userdata);

		if ( isset($_COOKIE[$cookiename . '_sid']) || isset($_COOKIE[$cookiename . '_data']) )
		{
			$sessiondata = isset( $_COOKIE[$cookiename . '_data'] ) ? unserialize(stripslashes($_COOKIE[$cookiename . '_data'])) : array();
			$session_id = isset( $_COOKIE[$cookiename . '_sid'] ) ? $_COOKIE[$cookiename . '_sid'] : '';
			$sessionmethod = SESSION_METHOD_COOKIE;
		}
		else
		{
			$sessiondata = array();
			$session_id = $mx_request_vars->is_get('sid', MX_TYPE_NO_TAGS);
			$sessionmethod = SESSION_METHOD_GET;
		}

		//
		if (!preg_match('/^[A-Za-z0-9]*$/', $session_id))
		{
			$session_id = '';
		}

		$thispage_id = (int) $thispage_id;

		//
		// Does a session exist?
		//
		if ( !empty($session_id) )
		{
			//
			// session_id exists so go ahead and attempt to grab all
			// data in preparation
			//
			$sql = "SELECT u.*, u.user_id as user_colour, u.user_level as user_type, p.default_lang as user_lang, p.board_timezone as user_timezone, s.*
				FROM " . SESSIONS_TABLE . " s, " . USERS_TABLE . " u, " . PORTAL_TABLE . " p
				WHERE s.session_id = '$session_id'
					AND u.user_id = s.session_user_id
					AND p.portal_id = 1";					
			if ( !($result = $db->sql_query($sql)) )
			{
				//mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
			}

			$userdata = $db->sql_fetchrow($result);

			//
			// Did the session exist in the DB?
			//
			if ( isset($userdata['user_id']) )
			{
				//
				// Do not check IP assuming equivalence, if IPv4 we'll check only first 24
				// bits ... I've been told (by vHiker) this should alleviate problems with
				// load balanced et al proxies while retaining some reliance on IP security.
				//
				$ip_check_s = substr($userdata['session_ip'], 0, 6);
				$ip_check_u = substr($user_ip, 0, 6);

				if ($ip_check_s == $ip_check_u)
				{
					$SID = ($sessionmethod == SESSION_METHOD_GET || defined('IN_ADMIN')) ? 'sid=' . $session_id : '';

					//
					// Only update session DB a minute or so after last update
					//
					if ( $current_time - $userdata['session_time'] > 60 )
					{
						// A little trick to reset session_admin on session re-usage
						$update_admin = (!defined('IN_ADMIN') && $current_time - $userdata['session_time'] > ($board_config['session_length']+60)) ? ', session_admin = 0' : '';

						$sql = "UPDATE " . SESSIONS_TABLE . "
							SET session_time = $current_time, session_page = $thispage_id$update_admin
							WHERE session_id = '" . $userdata['session_id'] . "'";
						if ( !$db->sql_query($sql) )
						{
							mx_message_die(CRITICAL_ERROR, 'Error updating sessions table', '', __LINE__, __FILE__, $sql);
						}

						if ( $userdata['user_id'] != ANONYMOUS )
						{
							$sql = "UPDATE " . USERS_TABLE . "
								SET user_session_time = $current_time, user_session_page = $thispage_id
								WHERE user_id = " . $userdata['user_id'];
							if ( !$db->sql_query($sql) )
							{
								mx_message_die(CRITICAL_ERROR, 'Error updating sessions table', '', __LINE__, __FILE__, $sql);
							}
						}

						$this->session_clean($userdata['session_id']);

						setcookie($cookiename . '_data', serialize($sessiondata), $current_time + 31536000, $cookiepath, $cookiedomain, $cookiesecure);
						setcookie($cookiename . '_sid', $session_id, 0, $cookiepath, $cookiedomain, $cookiesecure);
					}

					// Add the session_key to the userdata array if it is set
					if ( isset($sessiondata['autologinid']) && $sessiondata['autologinid'] != '' )
					{
						$userdata['session_key'] = $sessiondata['autologinid'];
					}

					return $userdata;
				}
			}
		}

		//
		// If we reach here then no (valid) session exists. So we'll create a new one,
		// using the cookie user_id if available to pull basic user prefs.
		//
		$user_id = ( isset($sessiondata['userid']) ) ? intval($sessiondata['userid']) : ANONYMOUS;

		if ( !($userdata = $this->session_begin($user_id, $user_ip, $thispage_id, TRUE)) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error creating user session', '', __LINE__, __FILE__, $sql);
		}

		return $userdata;

	}
	
	/**
	* Update the session data
	*
	* @param array $session_data associative array of session keys to be updated
	* @param string $session_id optional session_id, defaults to current user's session_id
	*/
	function update_session($session_data, $session_id = null)
	{
		global $db;

		$session_id = ($session_id) ? $session_id : $this->session_id;

		$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $session_data) . "
			WHERE session_id = '" . $db->sql_escape($session_id) . "'";
		$db->sql_query($sql);
	}

	function update_session_infos()
	{
		global $board_config, $db;

		// No need to update if it's a new session. Informations are already inserted by session_create()
		if (isset($this->data['session_created']) && $this->data['session_created'])
		{
			return;
		}

		// Do not update the session page for ajax requests, so the view online still works as intended
		$page_changed = $this->update_session_page && $this->data['session_page'] != $this->page['page'] && !$this->request->is_ajax();

		// Only update session DB a minute or so after last update or if page changes
		if ($this->time_now - (isset($this->data['session_time']) ? $this->data['session_time'] : 0) > 60 || $page_changed)
		{
			$sql_ary = array('session_time' => $this->time_now);

			if ($page_changed)
			{
				$sql_ary['session_page'] = substr($this->page['page'], 0, 199);
				$sql_ary['session_forum_id'] = $this->page['forum'];
			}

			$db->sql_return_on_error(true);

			$this->update_session($sql_ary);

			$db->sql_return_on_error(false);

			$this->data = array_merge($this->data, $sql_ary);

			if ($this->data['user_id'] != ANONYMOUS && isset($board_config['new_member_post_limit']) && $this->data['user_new'] && $board_config['new_member_post_limit'] <= $this->data['user_posts'])
			{
				$this->leave_newly_registered();
			}
		}
	}
	
	/**
	* Terminates the specified session
	* It will delete the entry in the sessions table for this session,
	* remove the corresponding auto-login key and reset the cookies
	*/
	function session_end($session_id, $user_id)
	{
		global $db, $lang, $board_config, $userdata;
		global $SID;

		$cookiename = $board_config['cookie_name'];
		$cookiepath = $board_config['cookie_path'];
		$cookiedomain = $board_config['cookie_domain'];
		$cookiesecure = $board_config['cookie_secure'];

		$current_time = time();

		if (!preg_match('/^[A-Za-z0-9]*$/', $session_id))
		{
			return;
		}

		//
		// Delete existing session
		//
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . "
			WHERE session_id = '$session_id'
				AND session_user_id = $user_id";
		if ( !$db->sql_query($sql) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error removing user session', '', __LINE__, __FILE__, $sql);
		}

		//
		// Remove this auto-login entry (if applicable)
		//
		if ( isset($userdata['session_key']) && $userdata['session_key'] != '' )
		{
			$autologin_key = md5($userdata['session_key']);
			$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
				WHERE user_id = ' . (int) $user_id . "
					AND key_id = '$autologin_key'";
			if ( !$db->sql_query($sql) )
			{
				mx_message_die(CRITICAL_ERROR, 'Error removing auto-login key', '', __LINE__, __FILE__, $sql);
			}
		}

		//
		// We expect that message_die will be called after this function,
		// but just in case it isn't, reset $userdata to the details for a guest
		//
		$sql = 'SELECT u.*, u.user_id as user_colour, u.user_level as user_type, p.default_lang as user_lang, p.board_timezone as user_timezone
			FROM ' . USERS_TABLE . ' u, ' . PORTAL_TABLE . ' p
			WHERE user_id = ' . ANONYMOUS;
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error obtaining user details', '', __LINE__, __FILE__, $sql);
		}
		if ( !($userdata = $db->sql_fetchrow($result)) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error obtaining user details', '', __LINE__, __FILE__, $sql);
		}
		$db->sql_freeresult($result);


		setcookie($cookiename . '_data', '', $current_time - 31536000, $cookiepath, $cookiedomain, $cookiesecure);
		setcookie($cookiename . '_sid', '', $current_time - 31536000, $cookiepath, $cookiedomain, $cookiesecure);

		return true;
	}

	/**
	* Removes expired sessions and auto-login keys from the database
	*/
	function session_clean($session_id)
	{
		global $board_config, $db;

		//
		// Delete expired sessions
		//
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . '
			WHERE session_time < ' . (time() - (int) $board_config['session_length']) . "
				AND session_id <> '$session_id'";
		if ( !$db->sql_query($sql) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error clearing sessions table', '', __LINE__, __FILE__, $sql);
		}

		//
		// Delete expired auto-login keys
		// If max_autologin_time is not set then keys will never be deleted
		// (same behaviour as old 2.0.x session code)
		//
		if (!empty($board_config['max_autologin_time']) && $board_config['max_autologin_time'] > 0)
		{
			$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
				WHERE last_login < ' . (time() - (86400 * (int) $board_config['max_autologin_time']));
			$db->sql_query($sql);
		}

		return true;
	}

	/**
	* Kills a session
	*
	* This method does what it says on the tin. It will delete a pre-existing session.
	* It resets cookie information (destroying any autologin key within that cookie data)
	* and update the users information from the relevant session data. It will then
	* grab guest user information.
	*/
	function session_kill($new_session = true)
	{
		global $SID, $_SID, $db, $board_config, $phpbb_root_path, $phpEx;

		$sql = 'DELETE FROM ' . SESSIONS_TABLE . "
			WHERE session_id = '" . $db->sql_escape($this->session_id) . "'
				AND session_user_id = " . (int) $this->data['user_id'];
			if (!$db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

		// Allow connecting logout with external auth method logout
		$method = basename(trim($board_config['auth_method']));
		include_once($mx_root_path . 'includes/shared/phpbb3/inludes/auth/auth_' . $method . '.' . $phpEx);

		$method = 'logout_' . $method;
		if (function_exists($method))
		{
			$method($this->data, $new_session);
		}
		//else
		if ($this->data['user_id'] != ANONYMOUS)
		{
			// Delete existing session, update last visit info first!
			if (!isset($this->data['session_time']))
			{
				$this->data['session_time'] = time();
			}

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_lastvisit = ' . (int) $this->data['session_time'] . '
				WHERE user_id = ' . (int) $this->data['user_id'];
			if (!$db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

			if ($this->cookie_data['k'])
			{
				$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
					WHERE user_id = ' . (int) $this->data['user_id'] . "
						AND key_id = '" . $db->sql_escape(md5($this->cookie_data['k'])) . "'";
				if (!$db->sql_query($sql))
				{
					mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
				}
			}

			// Reset the data array
			$this->data = array();

			$sql = 'SELECT *
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . ANONYMOUS;
				if (!$db->sql_query($sql))
				{
					mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
				}
			$this->data = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		}

		$cookie_expire = $this->time_now - 31536000;
		$this->set_cookie('u', '', $cookie_expire);
		$this->set_cookie('k', '', $cookie_expire);
		$this->set_cookie('sid', '', $cookie_expire);
		unset($cookie_expire);

		$SID = '?sid=';
		$this->session_id = $_SID = '';

		// To make sure a valid session is created we create one for the anonymous user
		if ($new_session)
		{
			$this->session_create(ANONYMOUS);
		}

		return true;
	}

	/**
	* Session garbage collection
	*
	* This looks a lot more complex than it really is. Effectively we are
	* deleting any sessions older than an admin definable limit. Due to the
	* way in which we maintain session data we have to ensure we update user
	* data before those sessions are destroyed. In addition this method
	* removes autologin key information that is older than an admin defined
	* limit.
	*/
	function session_gc()
	{
		global $db, $board_config;

		if (!$this->time_now)
		{
			$this->time_now = time();
		}

		// Firstly, delete guest sessions
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . '
			WHERE session_user_id = ' . ANONYMOUS . '
				AND session_time < ' . (int) ($this->time_now - $board_config['session_length']);
			if (!$db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

		// Get expired sessions, only most recent for each user
		$sql = 'SELECT session_user_id, session_page, MAX(session_time) AS recent_time
			FROM ' . SESSIONS_TABLE . '
			WHERE session_time < ' . ($this->time_now - $board_config['session_length']) . '
			GROUP BY session_user_id, session_page';
		$result = $db->sql_query_limit($sql, 10);

		$del_user_id = array();
		$del_sessions = 0;

		while ($row = $db->sql_fetchrow($result))
		{
			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_lastvisit = ' . (int) $row['recent_time'] . ", user_lastpage = '" . $db->sql_escape($row['session_page']) . "'
				WHERE user_id = " . (int) $row['session_user_id'];
			if (!$db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

			$del_user_id[] = (int) $row['session_user_id'];
			$del_sessions++;
		}
		$db->sql_freeresult($result);

		if (sizeof($del_user_id))
		{
			// Delete expired sessions
			$sql = 'DELETE FROM ' . SESSIONS_TABLE . '
				WHERE ' . $db->sql_in_set('session_user_id', $del_user_id) . '
					AND session_time < ' . ($this->time_now - $board_config['session_length']);
			if (!$db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
		}

		if ($del_sessions < 10)
		{
			// Less than 10 sessions, update gc timer ... else we want gc
			// called again to delete other sessions
			set_config('session_last_gc', $this->time_now, true);
		}

		if ($board_config['max_autologin_time'])
		{
			$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
				WHERE last_login < ' . (time() - (86400 * (int) $board_config['max_autologin_time']));
			if (!$db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
		}

		return;
	}

	/**
	* Sets a cookie
	*
	* Sets a cookie of the given name with the specified data for the given length of time.
	*/
	function set_cookie($name, $cookiedata, $cookietime)
	{
		global $board_config;

		$name_data = rawurlencode($board_config['cookie_name'] . '_' . $name) . '=' . rawurlencode($cookiedata);
		$expire = gmdate('D, d-M-Y H:i:s \\G\\M\\T', $cookietime);
		$domain = (!$board_config['cookie_domain'] || $board_config['cookie_domain'] == 'localhost' || $board_config['cookie_domain'] == '127.0.0.1') ? '' : '; domain=' . $board_config['cookie_domain'];

		header('Set-Cookie: ' . $name_data . '; expires=' . $expire . '; path=' . $board_config['cookie_path'] . $domain . ((!$board_config['cookie_secure']) ? '' : '; secure') . '; HttpOnly', false);
		
		// Work around for "current" Apache 2 + PHP module which seems to not
		// cope with private cache control setting
		/**/
		if (!empty($this->request->server('SERVER_SOFTWARE')) && strstr($this->request->server('SERVER_SOFTWARE'), 'Apache/2') && strstr($this->request->server('SERVER_SOFTWARE'), 'Apache/4'))
		{
			@header ('Cache-Control: no-cache, pre-check=0, post-check=0');
		}
		else
		{
			@header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
		}
		/**/
	}

	/**
	* Check for banned user
	*
	* Checks whether the supplied user is banned by id, ip or email. If no parameters
	* are passed to the method pre-existing session data is used. If $return is false
	* this routine does not return on finding a banned user, it outputs a relevant
	* message and stops execution.
	*
	* @param string|array	$user_ips	Can contain a string with one IP or an array of multiple IPs
	*/
	function check_ban($user_id = false, $user_ips = false, $user_email = false, $return = false)
	{
		global $board_config, $db;

		if (defined('IN_CHECK_BAN'))
		{
			return;
		}

		$banned = false;

		$sql = 'SELECT ban_ip, ban_userid, ban_email, ban_exclude, ban_give_reason, ban_end
			FROM ' . BANLIST_TABLE . '
			WHERE (ban_end >= ' . time() . ' OR ban_end = 0)';

		// Determine which entries to check, only return those
		if ($user_email === false)
		{
			$sql .= " AND ban_email = ''";
		}

		if ($user_ips === false)
		{
			$sql .= " AND (ban_ip = '' OR ban_exclude = 1)";
		}

		if ($user_id === false)
		{
			$sql .= ' AND (ban_userid = 0 OR ban_exclude = 1)';
		}
		else
		{
			$sql .= ' AND (ban_userid = ' . $user_id;

			if ($user_email !== false)
			{
				$sql .= " OR ban_email <> ''";
			}

			if ($user_ips !== false)
			{
				$sql .= " OR ban_ip <> ''";
			}

			$sql .= ')';
		}
		if (!$result = $db->sql_query($sql))
		{
			mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
		}
		
		$ban_triggered_by = 'user';
		while ($row = $db->sql_fetchrow($result))
		{
			$ip_banned = false;
			if (!empty($row['ban_ip']))
			{
				if (!is_array($user_ips))
				{
					$ip_banned = preg_match('#^' . str_replace('\*', '.*?', preg_quote($row['ban_ip'], '#')) . '$#i', $user_ips);
				}
				else
				{
					foreach ($user_ips as $user_ip)
					{
						if (preg_match('#^' . str_replace('\*', '.*?', preg_quote($row['ban_ip'], '#')) . '$#i', $user_ip))
						{
							$ip_banned = true;
							break;
						}
					}
				}
			}

			if ((!empty($row['ban_userid']) && intval($row['ban_userid']) == $user_id) ||
				$ip_banned ||
				(!empty($row['ban_email']) && preg_match('#^' . str_replace('\*', '.*?', preg_quote($row['ban_email'], '#')) . '$#i', $user_email)))
			{
				if (!empty($row['ban_exclude']))
				{
					$banned = false;
					break;
				}
				else
				{
					$banned = true;
					$ban_row = $row;

					if (!empty($row['ban_userid']) && intval($row['ban_userid']) == $user_id)
					{
						$ban_triggered_by = 'user';
					}
					else if (!empty($row['ban_ip']) && preg_match('#^' . str_replace('\*', '.*?', preg_quote($row['ban_ip'], '#')) . '$#i', $user_ips))
					{
						$ban_triggered_by = 'ip';
					}
					else
					{
						$ban_triggered_by = 'email';
					}

					// Don't break. Check if there is an exclude rule for this user
				}
			}
		}
		$db->sql_freeresult($result);

		if ($banned && !$return)
		{
			global $template;

			// If the session is empty we need to create a valid one...
			if (empty($this->session_id))
			{
				$this->session_create(ANONYMOUS);
			}

			// Initiate environment ... since it won't be set at this stage
			$this->setup();

			// Logout the user, banned users are unable to use the normal 'logout' link
			if ($this->data['user_id'] != ANONYMOUS)
			{
				$this->session_kill();
			}

			// We show a login box here to allow founders accessing the board if banned by IP
			if (defined('IN_LOGIN') && $this->data['user_id'] == ANONYMOUS)
			{
				global $phpEx;

				$this->setup('ucp');
				$this->data['is_registered'] = $this->data['is_bot'] = false;

				// Set as a precaution to allow login_box() handling this case correctly as well as this function not being executed again.
				define('IN_CHECK_BAN', 1);

				login_box("index.$phpEx");

				// The false here is needed, else the user is able to circumvent the ban.
				$this->session_kill(false);
			}

			// Ok, we catch the case of an empty session id for the anonymous user...
			// This can happen if the user is logging in, banned by username and the login_box() being called "again".
			if (empty($this->session_id) && defined('IN_CHECK_BAN'))
			{
				$this->session_create(ANONYMOUS);
			}

			// Determine which message to output
			$till_date = ($ban_row['ban_end']) ? $this->format_date($ban_row['ban_end']) : '';
			$message = ($ban_row['ban_end']) ? 'BOARD_BAN_TIME' : 'BOARD_BAN_PERM';

			$message = sprintf($this->lang[$message], $till_date, '<a href="mailto:' . $board_config['board_contact'] . '">', '</a>');
			$message .= ($ban_row['ban_give_reason']) ? '<br /><br />' . sprintf($this->lang['BOARD_BAN_REASON'], $ban_row['ban_give_reason']) : '';
			$message .= '<br /><br /><em>' . $this->lang['BAN_TRIGGERED_BY_' . strtoupper($ban_triggered_by)] . '</em>';

			trigger_error($message);
		}

		return ($banned) ? true : false;
	}

	/**
	* Check if ip is blacklisted
	* This should be called only where absolutly necessary
	*
	* Only IPv4 (rbldns does not support AAAA records/IPv6 lookups)
	*
	* @author satmd (from the php manual)
	* @param string $mode register/post - spamcop for example is ommitted for posting
	* @return false if ip is not blacklisted, else an array([checked server], [lookup])
	*/
	function check_dnsbl($mode, $ip = false)
	{
		if ($ip === false)
		{
			$ip = $this->ip;
		}

		$dnsbl_check = array(
			'list.dsbl.org'			=> 'http://dsbl.org/listing?',
			'sbl-xbl.spamhaus.org'	=> 'http://www.spamhaus.org/query/bl?ip=',
		);

		if ($mode == 'register')
		{
			$dnsbl_check['bl.spamcop.net'] = 'http://spamcop.net/bl.shtml?';
		}

		if ($ip)
		{
			$quads = explode('.', $ip);
			$reverse_ip = $quads[3] . '.' . $quads[2] . '.' . $quads[1] . '.' . $quads[0];

			// Need to be listed on all servers...
			$listed = true;
			$info = array();

			foreach ($dnsbl_check as $dnsbl => $lookup)
			{
				if (phpbb_checkdnsrr($reverse_ip . '.' . $dnsbl . '.', 'A') === true)
				{
					$info = array($dnsbl, $lookup . $ip);
				}
				else
				{
					$listed = false;
				}
			}

			if ($listed)
			{
				return $info;
			}
		}

		return false;
	}

	/**
	* Check if URI is blacklisted
	* This should be called only where absolutly necessary, for example on the submitted website field
	* This function is not in use at the moment and is only included for testing purposes, it may not work at all!
	* This means it is untested at the moment and therefore commented out
	*
	* @param string $uri URI to check
	* @return true if uri is on blacklist, else false. Only blacklist is checked (~zero FP), no grey lists
	function check_uribl($uri)
	{
		// Normally parse_url() is not intended to parse uris
		// We need to get the top-level domain name anyway... change.
		$uri = parse_url($uri);

		if ($uri === false || empty($uri['host']))
		{
			return false;
		}

		$uri = trim($uri['host']);

		if ($uri)
		{
			// One problem here... the return parameter for the "windows" method is different from what
			// we expect... this may render this check useless...
			if (phpbb_checkdnsrr($uri . '.multi.uribl.com.', 'A') === true)
			{
				return true;
			}
		}

		return false;
	}
	*/

	/**
	* Set/Update a persistent login key
	*
	* This method creates or updates a persistent session key. When a user makes
	* use of persistent (formerly auto-) logins a key is generated and stored in the
	* DB. When they revisit with the same key it's automatically updated in both the
	* DB and cookie. Multiple keys may exist for each user representing different
	* browsers or locations. As with _any_ non-secure-socket no passphrase login this
	* remains vulnerable to exploit.
	*/
	function set_login_key($user_id = false, $key = false, $user_ip = false)
	{
		global $phpBB3, $board_config, $db;

		$user_id = ($user_id === false) ? $this->data['user_id'] : $user_id;
		$user_ip = ($user_ip === false) ? $this->ip : $user_ip;
		$key = ($key === false) ? (($this->cookie_data['k']) ? $this->cookie_data['k'] : false) : $key;

		$key_id = $phpBB3->unique_id(hexdec(substr($this->session_id, 0, 8)));

		$sql_ary = array(
			'key_id'		=> (string) md5($key_id),
			'last_ip'		=> (string) $this->ip,
			'last_login'	=> (int) time()
		);

		if (!$key)
		{
			$sql_ary += array(
				'user_id'	=> (int) $user_id
			);
		}

		if ($key)
		{
			$sql = 'UPDATE ' . SESSIONS_KEYS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE user_id = ' . (int) $user_id . "
					AND key_id = '" . $db->sql_escape(md5($key)) . "'";
		}
		else
		{
			$sql = 'INSERT INTO ' . SESSIONS_KEYS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
		}
		if (!$db->sql_query($sql))
		{
			mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
		}

		$this->cookie_data['k'] = $key_id;

		return false;
	}

	/**
	* Reset all login keys for the specified user
	*
	* This method removes all current login keys for a specified (or the current)
	* user. It will be called on password change to render old keys unusable
	*/
	function reset_login_keys($user_id = false)
	{
		global $board_config, $db;

		$user_id = ($user_id === false) ? $this->data['user_id'] : $user_id;

		$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
			WHERE user_id = ' . (int) $user_id;
		if ($result = $db->sql_query($sql))
		{
			mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
		}

		// Let's also clear any current sessions for the specified user_id
		// If it's the current user then we'll leave this session intact
		$sql_where = 'session_user_id = ' . (int) $user_id;
		$sql_where .= ($user_id === $this->data['user_id']) ? " AND session_id <> '" . $db->sql_escape($this->session_id) . "'" : '';

		$sql = 'DELETE FROM ' . SESSIONS_TABLE . "
			WHERE $sql_where";
		if (!$result = $db->sql_query($sql))
		{
			mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
		}

		// We're changing the password of the current user and they have a key
		// Lets regenerate it to be safe
		if ($user_id === $this->data['user_id'] && $this->cookie_data['k'])
		{
			$this->set_login_key($user_id);
		}
	}
	
	/**
	* Check if the request originated from the same page.
	* @param bool $check_script_path If true, the path will be checked as well
	*/
	function validate_referer($check_script_path = false)
	{
		global $board_config;

		// no referer - nothing to validate, user's fault for turning it off (we only check on POST; so meta can't be the reason)
		if (empty($this->referer) || empty($this->host))
		{
			return true;
		}

		$host = htmlspecialchars($this->host);
		$ref = substr($this->referer, strpos($this->referer, '://') + 3);

		if (!(stripos($ref, $host) === 0) && (!$board_config['force_server_vars'] || !(stripos($ref, $board_config['server_name']) === 0)))
		{
			return false;
		}
		else if ($check_script_path && rtrim($this->page['root_script_path'], '/') !== '')
		{
			$ref = substr($ref, strlen($host));
			$server_port = (!empty($_SERVER['SERVER_PORT'])) ? (int) $_SERVER['SERVER_PORT'] : (int) getenv('SERVER_PORT');

			if ($server_port !== 80 && $server_port !== 443 && stripos($ref, ":$server_port") === 0)
			{
				$ref = substr($ref, strlen(":$server_port"));
			}

			if (!(stripos(rtrim($ref, '/'), rtrim($this->page['root_script_path'], '/')) === 0))
			{
				return false;
			}
		}

		return true;
	}

	function unset_admin()
	{
		global $db;
		$sql = 'UPDATE ' . SESSIONS_TABLE . '
			SET session_admin = 0
			WHERE session_id = \'' . $db->sql_escape($this->session_id) . '\'';
			if (!$db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
	}	

	/** *******************************************************************************************************
	 * Include the User class
	 ******************************************************************************************************* */

	/**
	* Setup basic user-specific items (style, language, ...)
	* Note: We've split original phpbb3 setup() method into setup() and setup_style()
	*/
	function setup($lang_set = false, $style = false)
	{
		global $db, $mx_cache, $template, $board_config, $phpbb_auth, $phpEx, $phpbb_root_path, $mx_root_path;
		global $mx_request_vars, $portal_config, $shared_lang_path; //added for mxp
		global $lang, $userdata; //temp vars
		global $phpBB2, $phpBB3; //temp vars for comp with phpbb2 and phpbb3 session files
		
		global $theme, $images, $nav_links;
		
		if (!empty($this->data['user_id'])) 
		{
			$cache = new mx_nothing();
			$this->session_begin();  
		}
		
		$this->cache = is_object($mx_cache) ? $mx_cache : new base();
		
		if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) 
		{
		    $this->data['is_bot'] = true;
		}
		else
		{
		    $this->data['is_bot'] = false;
		}
		
		switch ($this->data['user_type'])
		{
			case 3:
				$this->data['user_level'] = 1;
				$this->data['user_active'] = 1;
			break;
			case 0:
				$this->data['user_level'] = 0;
				$this->data['user_active'] = 1;
			break;
			case 1:
			case 2:
				$this->data['user_level'] = 0;
				$this->data['user_active'] = 0;
			break;
			default:
				global $phpbb_auth;
				if (!isset($phpbb_auth) || !is_object($phpbb_auth))
				{
					$phpbb_auth = new phpbb_auth();
				}
				$this->data['user_level'] = $phpbb_auth->acl_get('a_') ? 1 : ($phpbb_auth->acl_get('m_') ? 2 : 0);
				$this->data['user_active'] = 1;
			break;
		}
		
		$session_lang = '';
		
		/*
		* Added here for reference and future implementation of a lang block in mx_coreblocks were board_config can be taken from portal_config 
		*
		if ($board_config['lang_select_enable'] || $board_config['lang_click_enable'])
		{
			$session_lang_save = $phpBB3->request_var('session_lang_save', false);
			if (isset($session_lang_save) && $session_lang_save && $this->data['session_lang'])
			{
				$sql = 'UPDATE ' . USERS_TABLE . "
					SET user_lang = '" . $this->data['session_lang'] . "'
					WHERE user_id = " . $this->data['user_id'];
				$db->sql_query($sql);
			}

			$session_lang_reset = $phpBB3->request_var('session_lang_reset', false);
			if (isset($session_lang_reset) && $session_lang_reset)
			{
				$session_lang = '';
			}
			else
			{
				$session_lang = $phpBB3->request_var('session_lang', '');
			}

			if ((isset($session_lang) && $session_lang) || $session_lang_reset)
			{
				$sql = 'UPDATE ' . SESSIONS_TABLE . "
					SET session_lang = '" . $session_lang . "'
					WHERE session_id = '" . $this->session_id . "'";
				$db->sql_query($sql);
			}
			elseif (isset($this->data['session_lang']) && $this->data['session_lang'])
			{
				$session_lang = $this->data['session_lang'];
			}
		}

		if (($board_config['lang_select_enable'] || $board_config['lang_click_enable']) && isset($session_lang) && $session_lang)
		{
			$this->data['user_lang'] = $session_lang;
			$this->lang_name = (file_exists($this->lang_path . $this->data['user_lang'] . "/common.$phpEx")) ? $this->data['user_lang'] : basename($this->encode_lang($this->lang['default_lang']));

			if ($this->data['user_id'] != ANONYMOUS)
			{
				$this->date_format = $this->data['user_dateformat'];
				$this->timezone = $this->data['user_timezone'] * 3600;
				$this->dst = $this->data['user_dst'] * 3600;
			}
			else
			{
				$this->date_format = $board_config['default_dateformat'];
				$this->timezone = $board_config['board_timezone'] * 3600;
				$this->dst = $board_config['board_dst'] * 3600;
			}
		}		
		*/
		
		//
		// Populate session_id
		//
		$this->session_id = $this->data['session_id'];

		$this->lang_path = $shared_lang_path;
		$this->lang_name = isset($this->data['user_lang']) ? $this->data['user_lang'] : $board_config['default_lang'];
		
		$lang_set = !$lang_set ? (defined('IN_ADMIN') ? 'acp/common' : 'common') : $lang_set;
		
		//
		// Grab MXP global variables, re-cache if necessary
		// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the MX-Publisher cache whenever updating MXP config settings
		// - true: enable cache, false: disable cache
		if (empty($portal_config['portal_status']))
		{
			$portal_config = $this->obtain_mxbb_config(false);
		}
		
		//
		// Grab phpBB global variables, re-cache if necessary
		// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the MX-Publisher cache whenever updating phpBB config settings
		// - true: enable cache, false: disable cache
		if (empty($board_config['script_path']))
		{
			$board_config = $mx_cache->obtain_config(false);
		}
		
		$board_config['avatar_gallery_path'] = isset($board_config['avatar_gallery_path']) ? $board_config['avatar_gallery_path'] : 'images/avatars'; 
		$board_config['user_timezone'] = !empty($board_config['user_timezone']) ? $board_config['user_timezone'] : $board_config['board_timezone'];
		
		$this->data['user_dst'] = !empty($this->data['user_dst']) ? $this->data['user_dst'] : $this->data['user_timezone'];
		$this->date_format = $board_config['default_dateformat'];
		
		$board_config['require_activation'] = 0;
		
		try
		{
			$DateTimeZone = new \DateTimeZone($board_config['user_timezone']);
		}
		catch (\Exception $e)
		{
			// If the timezone the user has selected is invalid, we fall back to UTC or server.
			$DateTimeZone = new \DateTimeZone(date_default_timezone_get());
		}
		
		foreach ($DateTimeZone as $timezone_type => $dst)
		{
			$dst = $DateTimeZone->timezone_type;
			$timezone = $DateTimeZone->timezone;
		}
		
		$timezone = $this->config['board_timezone'];
		$offset = (float) $timezone + (int) $dst;
			
		$this->date_format = $this->config['default_dateformat'];
		$this->timezone = $this->config['board_timezone'];
		$this->dst = $dst;
		
		$sign = ($this->config['board_timezone'] < 0) ? '-' : '+';
		$time_offset = abs($this->config['board_timezone']);

		$offset_seconds	= $time_offset % 3600;
		$offset_minutes	= $offset_seconds / 60;
		$offset_hours	= ($time_offset - $offset_seconds) / 3600;
		
		// Zone offset
		$zone_offset = (float) $this->timezone + (int) $this->dst;
		
		$offset_string = sprintf($board_config['default_dateformat'], $sign, $offset_hours, $offset_minutes);
		
		$s_date = gmdate("Y-m-d\TH:i:s", time() + $zone_offset) . $offset_string;
		
		// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
		$l_timezone = explode('.', $board_config['user_timezone']);
		$l_timezone = (count($timezone) > 1) ? $this->lang(sprintf('%.1f', $board_config['board_timezone'])) : $offset_string;

		$server_name = !empty($board_config['server_name']) ? preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['server_name'])) : 'localhost';
		$server_protocol = ($board_config['cookie_secure'] ) ? 'http://' : 'http://';
		$server_port = (($board_config['server_port']) && ($board_config['server_port'] <> 80)) ? ':' . trim($board_config['server_port']) . '/' : '/';
		$script_name_phpbb = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])) . '/';
		$server_url = $server_protocol . str_replace("//", "/", $server_name . $server_port . '/'); //On some server the slash is not added and this trick will fix it	
		$corrected_url = $server_protocol . $server_name . $server_port . $script_name_phpbb;
		
		$board_url = PORTAL_URL;
		$web_path = (defined('PORTAL_URL')) ? $board_url : $corrected_url;
	
		@define('PHPBB_URL', $board_url);
		
		//
		// Send a proper content-language to the output
		//
		$img_lang = $default_lang = $this->lang['default_lang'] = ($this->data['user_lang']) ? $this->data['user_lang'] : $board_config['default_lang'];

		if ($this->data['user_id'] != ANONYMOUS)
		{
			$this->lang_name = (file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->data['user_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->data['user_lang']) : ((file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->lang['default_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->lang['default_lang']) : 'en');
			$this->lang_path = $phpbb_root_path . 'language/' . $this->lang_name . '/';

			$this->date_format = $this->data['user_dateformat'];
			$this->timezone = $timezone = $this->data['user_timezone'];
			$this->dst = $this->data['user_dst'];
			$offset = (float) $timezone + (int) $dst;
		
			if (!empty($this->data['user_lang']))
			{
				$default_lang = mx_ltrim(basename(mx_rtrim($this->data['user_lang'])), "'");
			}

			if (!empty($this->data['user_dateformat']))
			{
				$board_config['default_dateformat'] = $this->data['user_dateformat'];
			}

			if (isset($userdata['user_timezone']))
			{
				$board_config['board_timezone'] = $this->data['user_timezone'];
			}
		}
		else
		{
			// In case this is somehow run twice on a row.
			// Otherwise it would just end up as UTC on the second run
			if (is_numeric($this->data['user_timezone']))
			{
				print ('PLS update blocks of users who have dst as timezone! See develop folder.');
				/*Commented code * /
				$update_blocks = array();
				$update_blocks[$this->data['user_timezone'] . ':' . $this->data['user_dst']][] = (int) $this->data['user_id'];
				// Update blocks of users who share the same timezone/dst
				foreach ($update_blocks as $timezone => $user_ids)
				{
					$timezone = explode(':', $timezone);
					$converted_timezone = $this->convert_phpbb30_timezone($timezone[0], $timezone[1]);

					$sql = 'UPDATE ' . $this->table_prefix . "users
						SET user_timezone = '" . $this->db->sql_escape($converted_timezone) . "'
						WHERE " . $this->db->sql_in_set('user_id', $user_ids);
					$this->sql_query($sql);
				}
				/**/
			}
			
			$timezone = $this->data['user_timezone'];
			$dst = $this->data['user_dst'];
			$offset = (float) $timezone + (int) $dst;
			
			$this->lang_name = (file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->lang['default_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->lang['default_lang']) : 'en';
			$this->lang_path = $phpbb_root_path . 'language/' . $this->lang_name . '/';
			$this->date_format = $board_config['default_dateformat'];
			$this->timezone = !empty($timezone) ? $timezone : $this->config['board_timezone'];
			$this->dst = is_numeric($dst) ? $dst : 0;
			
			$default_lang = mx_ltrim(basename(mx_rtrim($board_config['default_lang'])), "'");
	
			/**
			* If a guest user is surfing, we try to guess his/her language first by obtaining the browser language
			* If re-enabled we need to make sure only those languages installed are checked
			* Commented out so we do not loose the code.
			* language checking added 2008-08-15 by Martin Truckenbrodt
			**/
			if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
			{
				$lang_iso_xx_yy = array();
				$lang_iso_xx = array();
				$accept_lang_xx_yy = array();
				$accept_lang_xx = array();

				$sql = 'SELECT lang_iso FROM ' . LANG_TABLE;
				$result = $db->sql_query($sql, 3600);

				while ($row = $db->sql_fetchrow($result))
				{
					if (@is_file($phpbb_root_path . 'language/' . $row['lang_iso'] . "/common.$phpEx"))
					{
						$lang_iso_xx_yy[] = $row['lang_iso'];
						if (strlen($row['lang_iso']) > 4)
						{
							$lang_iso_xx[$row['lang_iso']] = substr($row['lang_iso'], 0, 2);
						}
					}
				}
				$accept_lang_ary = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

				foreach ($accept_lang_ary as $accept_lang)
				{
					// Set correct format ... guess full xx_yy form
					$accept_lang_xx_yy = basename(substr($accept_lang, 0, 2) . '_' . strtolower(substr($accept_lang, 3, 2)));
					// Set correct format ... guess only xx form
					$accept_lang_xx = basename(substr($accept_lang, 0, 2));

					// browser xx-YY == board xx_yy and
					// browser xx == board xx
					if (in_array($accept_lang_xx_yy, $lang_iso_xx_yy))
					{
						$this->lang_name = $board_config['default_lang'] = $accept_lang_xx_yy;
						break;
					}
					// browser xx-YY => xx == board xx
					else if (in_array($accept_lang_xx, $lang_iso_xx_yy))
					{
						$this->lang_name = $board_config['default_lang'] = $accept_lang_xx;
						break;
					}
					// browser xx == board xx_yy => xx
					else if (in_array($accept_lang_xx, $lang_iso_xx) && $lang_iso_xx != '')
					{
						$this->lang_name = $board_config['default_lang'] = array_search($accept_lang_xx, $lang_iso_xx);
						break;
					}
					// board default language
					else
					{
						$this->lang_name = (file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->lang['default_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->lang['default_lang']) : 'en';
					}
				}
				$this->data['user_lang'] = $this->lang_name;
			}
			/*	
			*/	
		}
		
		// Shared phpBB2 lang files dir
		// Load vanilla phpBB2 lang files if is possible
		$shared_phpbb2_path 	= $mx_root_path . 'includes/shared/phpbb2/';
		$shared_phpbb3_path 	= $mx_root_path . 'includes/shared/phpbb3/';
		$shared_lang_path 		= $mx_root_path . 'includes/shared/phpbb2/';
		$lang_path 				= $mx_root_path . 'includes/shared/phpbb2/';
		/** /
		if (!file_exists($phpBB2->phpbb_realpath($shared_phpbb2_path . 'language/lang_' . $default_lang . '/lang_main.'.$phpEx)) && !file_exists(@phpbb_realpath($shared_lang_path . 'language/lang_' . $default_lang . '/lang_main.'.$phpEx)))
		{
			if ($userdata['user_id'] !== ANONYMOUS)
			{
				// For logged in users, try the board default language next
				// Just in case we do fallback on $board_config['phpbb_lang']  
				// Since $board_config['default_lang'] has been overwiten in function $mx_user->_init_userprefs()				
				$default_lang = mx_ltrim(basename(mx_rtrim($board_config['phpbb_lang'])), "'");			
			}
			else
			{
				// For guests it means the default language is not present, try english
				// This is a long shot since it means serious errors in the setup to reach here,
				// but english is part of a new install so it's worth us trying
				$default_lang = 'english';
			}
			
			if (!file_exists(@phpbb_realpath($shared_phpbb2_path . 'language/lang_' . $default_lang . '/lang_main.'.$phpEx)))
			{
				mx_message_die(CRITICAL_ERROR, 'Could not locate valid phpBB2 language pack in $mx_user->setup() for: ' . $default_lang);
			}
		}
		
		/**/
		// If we've had to change the value in any way then let's write it back to the database
		// before we go any further since it means there is something wrong with it
		if ($this->data['user_id'] != ANONYMOUS && $this->data['user_lang'] !== $default_lang)
		{
			/* * /
			$sql = 'UPDATE ' . USERS_TABLE . "
				SET user_lang = '" . $this->decode_lang($this->lang['default_lang']) . "'
				WHERE user_lang = '" . $this->decode_lang($this->data['user_lang']) . "'";
			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die(CRITICAL_ERROR, 'Could not update user language info in setup');
			}
			/* */
			$this->data['user_lang'] = $default_lang;
		}
		elseif ($this->data['user_id'] == ANONYMOUS && $board_config['default_lang'] !== $default_lang)
		{
			$sql = "UPDATE " . PORTAL_TABLE . " SET
				default_lang = '" . $this->decode_lang($this->lang['default_lang']) . "'
				WHERE portal_id = '1'";

			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die(CRITICAL_ERROR, 'Could not update user language info');
			}
		}
		
		// 
		//
		// We setup common language file here to not load it every time a custom language file is included
		//
		//$lang = &$this->lang;
		$this->lang = &$lang;
		//print_r($this->lang);
		$user_lang = $this->user_lang = !empty($this->lang['USER_LANG']) ? $this->lang['USER_LANG'] : $this->encode_lang($this->lang_name);
		
		$this->user_language		= $this->encode_lang($this->lang_name);
		$this->default_language		= $this->encode_lang($board_config['default_lang']);
		
		$this->user_language_name		= $this->decode_lang($this->lang_name);
		$this->default_language_name	= $this->decode_lang($board_config['default_lang']);
		
		$counter = 0; //First language pack lang_id		
		$lang_ids = array();
		$lang_list = $this->get_lang_list();
		
		if (is_array($lang_list))
		{		
			foreach ($lang_list as $lang_english_name => $lang_local_name)
			{
				$lang_ids[$lang_english_name] = $counter;
				$counter++;
			}
		}
		
		$lang_entries = array(
			'lang_id' => !empty($lang_ids['lang_' . $this->user_language_name]) ? $lang_ids['lang_' . $this->user_language_name] : $counter,
			'lang_iso' => !empty($lang['USER_LANG']) ? $lang['USER_LANG'] : $this->encode_lang($this->lang_name),
			'lang_dir' => 'lang_' . $this->lang_name,
			'lang_english_name' => $this->user_language_name,
			'lang_local_name' => $this->ucstrreplace('lang_', '', $this->lang_name),
			'lang_author' => !empty($lang['TRANSLATION_INFO']) ? $lang['TRANSLATION_INFO'] : 'Language pack author not set in ACP.'
		);
		
		//this line is issued on backend
		// Core Main Translation after shared phpBB keys so we can overwrite some settings
		include($mx_root_path . 'language/lang_' . str_replace('lang_', '', $lang_english_name) . '/lang_main.' . $phpEx);
		
		$board_config['default_lang'] = $default_lang;
		$portal_config['default_lang'] = $default_lang;
		
		//
		// Finishing setting language variables to ouput
		//
		$this->lang_iso = $lang_iso = $lang_entries['lang_iso'];
		$this->lang_dir = $lang_dir = $lang_entries['lang_dir'];
		$this->lang_english_name = $lang_english_name = $lang_entries['lang_english_name'];
		$this->lang_local_name = $lang_local_name = $lang_entries['lang_local_name'];
		
		$this->lang_name = $this->lang['default_lang'] = $default_lang;
		$this->lang_path = $shared_phpbb2_path . 'language/lang_' . $board_config['default_lang'] . '/';
		
		/* We include common language file here to not load it every time a custom language file is included
		$lang = &$this->lang;
		*/
		$include_result = (defined('DEBUG_EXTRA')) ?  "" : "@"; // Do not suppress error if in DEBUG_EXTRA mode
		//this line is issued on backend		
		/**/
		if (("$include_result".include $shared_phpbb3_path . "language/lang_" . $lang_english_name . "/common.$phpEx") === false)
		{
			//$this->set_lang($this->lang, $this->help, 'common');
			
			//this will fix the path for anonymouse users
			if ((@include $phpbb_root_path . $this->lang_path . '/common.'.$phpEx) === false)
			{
				die('Language file (_init_userprefs) ' . $phpbb_root_path . $this->lang_path . '/common.'.$phpEx . ' couldn\'t be opened by _init_userprefs().');
			}
		}
		/**/

		//
		// We include common language file here to not load it every time a custom language file is included
		//
		$this->add_lang($lang_set);

		$this->is_setup_flag = true;
		
		unset($lang_set);
	}

	/**
	 * Enter description here...
	 * Note: We've split original phpbb3 setup() method into setup() and setup_style()
	 */
	function setup_style()
	{
		global $db, $template, $board_config, $userdata, $phpbb_auth, $phpEx, $phpbb_root_path, $mx_root_path, $mx_cache;
		global $mx_request_vars, $portal_config, $board_config, $mx_backend, $phpBB2, $phpBB3; //added for mxp
		//
		// Instantiate the mx_auth class
		$mx_auth = $phpbb_auth = new phpbb_auth();
		if (!empty($_GET['style']) && $phpbb_auth->acl_get('a_styles'))
		{
			global $SID, $_EXTRA_URL;
			$style = $phpBB3->request_var('style', 0);
			// BEGIN Styles_Demo MOD for phpBB Block
			$style_value = '';
			$SID .= '&amp;style=' . $style;
			$_EXTRA_URL = array('style=' . $style);
		}
		else
		{
			$style = $this->style; // From main style init. Should be correct and valid.
			$style_value = $this->style_name;
			// BEGIN Styles_Demo MOD for phpBB Block
			/* */
			if(!$board_config['override_user_style'] && ($this->data['user_id'] != ANONYMOUS))
			{
				// Set up style
				$user_style = $this->data['user_style'] ? $this->data['user_style'] : $this->phpbb_style['style_id'];
				//If user have other style in mxp then the one from phpBB not to have forum page and modules graphics will be messaed up
				//Anonymouse users should see all block graphic corect
				//Query phpBB3 Rhea style_id corepondent to mxp themes_id
				$sql = "SELECT s.style_id, s.style_name
					FROM " . MX_THEMES_TABLE . " AS m, " . STYLES_TABLE . " AS s
					WHERE m.themes_id = " . (int) $user_style . "
						AND s.style_path = m.template_name";
				if ($row = $db->sql_fetchrow($db->sql_query($sql)))
				{
					$style = $row['style_id']; //User style
					$style_value = $row['style_name']; //User style name
				}
				else
				{
					$style = $this->data['user_style'] ? $this->data['user_style'] : $board_config['default_style'];
				}
			}
			else
			{
				$default_style = $portal_config['default_style'];
				//If user have other style in mxp then the one from phpBB not to have forum page and modules graphics will be messaed up
				//Anonymouse users should see all block graphic corect
				//Query phpBB3 Rhea style_id corepondent to mxp themes_id
				$sql = "SELECT s.style_id, s.style_name
					FROM " . MX_THEMES_TABLE . " AS m, " . STYLES_TABLE . " AS s
					WHERE m.themes_id = " . (int) $default_style . "
						AND s.style_path = m.template_name";
				if ($row = $db->sql_fetchrow($db->sql_query($sql)))
				{
					$style = $row['style_id']; //User style
					$style_value = $row['style_name']; //User style name
				}
				else
				{
					$style = $this->data['user_style'] ? $this->data['user_style'] : $board_config['default_style'];
				}
			}
			/* */
			// Set up style Temp code should be removed after bugtraking
			//$style = ($style) ? $style : ((!$board_config['override_user_style'] && $this->data['user_id'] != ANONYMOUS) ? $this->data['user_style'] : $this->phpbb_style['style_id']);
		}
		
		if (isset($_GET['demostyle']))
		{
			$style_value = $phpBB3->request_var('demostyle', '');
			if (intval($style_value) == 0)
			{
				//Query phpBB3 Rhea style_id corepondent to mxp style_name
				//Any Demo Style here should work also for portal and forums
				//Any Demo Style Name should be supported using same guild lines for portal as for forums for e.g. with spaces etc.				
				$sql = "SELECT s.style_id, s.style_name
						FROM " . MX_THEMES_TABLE . " AS m, " . STYLES_TABLE . " AS s
					WHERE s.style_active = 1 AND s.style_name = '$style_value'
						AND s.style_name = m.template_name";
				if(!$row = $db->sql_fetchrow($db->sql_query($sql)))
				{
					die('Could not find style name '. $style_value . '!');
				}
				else
				{
					$style_value = $row['style_id'];
				}
			}
			else
			{		
				//Query phpBB style_id corepondent to mxp themes_id
				//Any Demo Style here should work also for portal and forums
				//Any Demo Style Name should be supported using same guild lines for portal as for forums for e.g. with spaces etc.				
				$sql = "SELECT s.style_id, s.style_name
					FROM " . MX_THEMES_TABLE . " AS m, " . STYLES_TABLE . " AS s
					WHERE m.themes_id = " . (int) $style_value . "
						AND s.style_name = m.template_name";
				if(!$row = $db->sql_fetchrow($db->sql_query($sql)))
				{
					die('style_id ' . $style_value . ' not found');
				}
			}
			$this->set_cookie('change_style', $style_value, time() + 31536000);
		}
		elseif (isset($_COOKIE[$board_config['cookie_name'] . '_change_style']))
		{
			$style_value = $_COOKIE[$board_config['cookie_name'] . '_change_style'];
		}
		
		//Change the value before query
		if (!empty($style_value))
		{
			$style = $style_value;
		}
		
		//We should never get this, temp fix for  GoogleBot-2.1 crawler
		//Remove this Deguging Code after solved
		if ((intval($style) == 0) && empty($style_value))
		{
			$style_value = 'prosilver';
		}
		$phpbb_style = $style;
		$phpbb_style_value = $style_value;
		
		// END Styles_Demo MOD 
		if (isset($style_value) && (intval($style_value) == 0))  
		{
			//Query phpBB3 Rhea style_name
			$sql = "SELECT s.*
				FROM " . STYLES_TABLE . " AS s
				WHERE s.style_active = 1 AND s.style_name = '$style_value'";
			if(($result = $db->sql_query($sql)) && ($row = $db->sql_fetchrow($result)))
			{
				$style = $row['style_id'];
				$style_value = $row['style_name'];
			}
			else
			{
				mx_message_die(CRITICAL_ERROR, "Could not query database for phpbb_styles info style_name [$style]", "", __LINE__, __FILE__, $sql);
			}
		}
		elseif (intval($style) !== 0)
		{
			//Query phpBB3 Rhea style_id get from main style init. Should be correct and valid.
			$sql = "SELECT s.*, m.*
				FROM " . MX_THEMES_TABLE . " AS m, " . STYLES_TABLE . " AS s
				WHERE s.style_id = " . (int) $style . "
					AND s.style_path = m.style_name";
			if(($result = $db->sql_query($sql)) && ($row = $db->sql_fetchrow($result)))
			{
				$style = $row['style_id'];
				$style_value = $row['style_name'];
				// MXP themes_id = $row['themes_id']
			}
			else
			{
				mx_message_die(CRITICAL_ERROR, "Could not query database for phpbb_styles info style_id [$style]", "", __LINE__, __FILE__, $sql);
			}
		}
		// Default phpBB3 style as parent
		$row['style_parent_tree'] = empty($row['style_parent_tree']) ? $row['style_parent_tree'] : 'prosilver';
		$this->theme = is_array($this->theme) ? array_merge($this->theme, $row) : $row;
		$db->sql_freeresult($result);
		
		// User has wrong style
		if (!$this->theme && $style == $this->data['user_style'])
		{
			$style = $this->data['user_style'] = $board_config['default_style'];
			
			$sql = 'UPDATE ' . USERS_TABLE . "
				SET user_style = $style
				WHERE user_id = {$this->data['user_id']}";
			if (!$db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
			
			//Query phpBB3 Rhea style_id get from main style init. Should be correct and valid.
			$sql = "SELECT s.*, t.*
				FROM " . MX_THEMES_TABLE . " AS t, " . STYLES_TABLE . " AS s
				WHERE s.style_id = $style
					AND t.template_name = s.style_path";
			$result = $db->sql_query($sql, 3600);
			$row = $db->sql_fetchrow($result);
			// Default phpBB3 style as parent
			$row['style_parent_tree'] =empty($row['style_parent_tree']) ? $row['style_parent_tree'] : 'prosilver';
			$this->theme = is_array($this->theme) ? array_merge($this->theme, $row) : $row;
			$db->sql_freeresult($result);
			
			$style = $this->theme['style_id'];
			$style_value = $this->theme['style_name'];	
		}

		if (!$this->theme)
		{
			trigger_error('Could not get style data', E_USER_ERROR);
		}
		
		// Now parse the cfg file and cache it
		$parsed_items = $mx_backend->obtain_cfg_items($this->theme);
		
		// We are only interested in the theme configuration for now
		$parsed_items = $parsed_items['theme'];
		
		$check_for = array(
			'parse_css_file'	=> (int) 0,
			'pagination_sep'	=> (string) ', '
		);
		
		foreach ($check_for as $key => $default_value)
		{
			$this->theme[$key] = (isset($parsed_items[$key])) ? $parsed_items[$key] : $default_value;
			settype($this->theme[$key], gettype($default_value));
			
			if (is_string($default_value))
			{
				$this->theme[$key] = htmlspecialchars($this->theme[$key]);
			}
		}
		
		// Default phpBB3 style as parent
		if (!isset($this->theme['style_parent_tree']))
		{	
			$this->theme['style_parent_tree'] = 'prosilver';
		}
		
		// If the style author specified the theme needs to be cached
		// (because of the used paths and variables) than make sure it is the case.
		// For example, if the theme uses language-specific images it needs to be stored in db.
		if (!isset($this->theme['theme_storedb']) && isset($this->theme['parse_css_file']) && isset($this->theme['theme_id']))
		{
			$this->theme['theme_storedb'] = 1;
			
			$stylesheet = file_get_contents("{$phpbb_root_path}styles/{$this->theme['theme_path']}/theme/stylesheet.css");
			// Match CSS imports
			$matches = array();
			preg_match_all('/@import url\(["\'](.*)["\']\);/i', $stylesheet, $matches);	
			if (sizeof($matches))
			{
				$content = '';
				foreach ($matches[0] as $idx => $match)
				{
					if ($content = @file_get_contents("{$phpbb_root_path}styles/{$this->theme['theme_path']}/theme/" . $matches[1][$idx]))
					{
						$content = trim($content);
					}
					else
					{
						$content = '';
					}
					$stylesheet = str_replace($match, $content, $stylesheet);
				}
				unset($content);
			}
			
			$stylesheet = str_replace('./', 'styles/' . $this->theme['theme_path'] . '/theme/', $stylesheet); 
			
			$sql_ary = array(
				'theme_data'	=> $stylesheet,
				'theme_mtime'	=> time(),
				'theme_storedb'	=> 1
			);
			
			$sql = 'UPDATE ' . STYLES_THEME_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE theme_id = ' . $this->theme['theme_id'];
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
			if (!$db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
			unset($sql_ary);
		}
		
		$template->set_template();
		
		//
		// Added here for phpbb3 backend not for rhea backend
		// - First try old Olympus image sets then phpBB2 and phpBB3 Proteus template lang images 
		//
		if (is_dir("{$phpbb_root_path}{$this->style_path}{$this->template_name}/imageset/"))
		{
			$this->imageset_path = '/imageset/'; //Olympus ImageSet
			$this->img_lang = (file_exists($phpbb_root_path . $this->style_path . $this->template_name . $this->imageset_path . $this->lang_iso)) ? $this->lang_iso : $this->default_language;
			$this->img_lang_dir = $this->img_lang;
			$this->imageset_backend = 'olympus';
			$this->theme['imageset_name'] = $this->template_name;
		}
		elseif (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/") || @is_dir("{$phpbb_root_path}{$this->style_path}{$this->template_name}/theme/images/"))
		{
			$this->imageset_path = '/theme/images/';  //phpBB3 Images
			if ((@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/lang_{$this->user_language_name}")) || (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/lang_{$this->default_language_name}")))
			{
				$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . '/theme/' . 'lang_' . $this->user_language_name)) ? $this->user_language_name : $this->default_language_name;
				$this->img_lang_dir = 'lang_' . $this->img_lang;
				$this->imageset_backend = 'phpbb2';
			}
			
			if ((@is_dir("{$phpbb_root_path}{$this->style_path}{$this->template_name}/theme/{$this->user_language}")) || (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/{$this->default_language}")))
			{
				$this->img_lang = (file_exists($phpbb_root_path . $this->style_path . $this->template_name . '/theme/' . $this->user_language_name)) ? $this->user_language : $this->default_language;
				$this->img_lang_dir = $this->img_lang;
				$this->imageset_backend = 'phpbb3';
			}
			
			$this->theme['imageset_name'] = $this->template_name;
		}
		elseif (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/images/"))
		{
			$this->imageset_path = '/images/';  //phpBB2 Images
			$this->img_lang = (is_dir($phpbb_root_path . $this->style_path . $this->template_name . $this->imageset_path . '/images/lang_' . $this->user_language_name)) ? $this->user_language_name : $this->default_language_name;
			$this->img_lang_dir = 'lang_' . $this->img_lang;
			$this->imageset_backend = 'phpbb2';
			$this->theme['imageset_name'] = $this->template_name;
		}
		
		/*
		$sql = 'SELECT image_name, image_filename, image_lang, image_height, image_width
			FROM ' . STYLES_IMAGESET_DATA_TABLE . '
			WHERE imageset_id = ' . $this->theme['imageset_id'] . "
			AND image_filename <> ''
			AND image_lang IN ('" . $db->sql_escape($this->img_lang) . "', '')";
		$result = $db->sql_query($sql, 3600);
		*/
		$localised_images = false;
		/*
		while ($row = $db->sql_fetchrow($result))
		{
			if ($row['image_lang'])
			{
				$localised_images = true;
			}

			$this->img_array[$row['image_name']] = $row;
		}
		$db->sql_freeresult($result);
		*/
		// there were no localised images, try to refresh the localised imageset for the user's language
		if (!$localised_images)
		{
			// Attention: this code ignores the image definition list from acp_styles and just takes everything
			// that the config file contains
			$sql_ary = array();
			
			$db->sql_transaction('begin');
			/*
			$sql = 'DELETE FROM ' . STYLES_IMAGESET_DATA_TABLE . '
				WHERE imageset_id = ' . $this->theme['imageset_id'] . '
					AND image_lang = \'' . $db->sql_escape($this->img_lang) . '\'';
			$result = $db->sql_query($sql);
			*/
			if (@file_exists("{$phpbb_root_path}styles/{$this->theme['imageset_path']}/imageset/{$this->img_lang}/imageset.cfg"))
			{
				$cfg_data_imageset_data = mx_parse_cfg_file("{$phpbb_root_path}styles/{$this->theme['imageset_path']}/imageset/{$this->img_lang}/imageset.cfg");
				foreach ($cfg_data_imageset_data as $image_name => $value)
				{
					if (strpos($value, '*') !== false)
					{
						if (substr($value, -1, 1) === '*')
						{
							list($image_filename, $image_height) = explode('*', $value);
							$image_width = 0;
						}
						else
						{
							list($image_filename, $image_height, $image_width) = explode('*', $value);
						}
					}
					else
					{
						$image_filename = $value;
						$image_height = $image_width = 0;
					}
					
					if (strpos($image_name, '') === 0 && $image_filename)
					{
						$image_name = substr($image_name, 4);
						$sql_ary[] = array(
							'image_name'		=> (string) $image_name,
							'image_filename'	=> (string) $image_filename,
							'image_height'		=> (int) $image_height,
							'image_width'		=> (int) $image_width,
							'imageset_id'		=> (int) $this->theme['imageset_id'],
							'image_lang'		=> (string) $this->img_lang,
						);
					}
				}
			}
			
			if (sizeof($sql_ary))
			{
				$db->sql_multi_insert(STYLES_IMAGESET_DATA_TABLE, $sql_ary);
				$db->sql_transaction('commit');
				$mx_cache->destroy('sql', STYLES_IMAGESET_DATA_TABLE);
				
				mx_add_log('admin', 'LOG_IMAGESET_LANG_REFRESHED', $this->theme['imageset_name'], $this->img_lang);
			}
			else
			{
				$db->sql_transaction('commit');
				mx_add_log('admin', 'LOG_IMAGESET_LANG_MISSING', $this->theme['imageset_name'], $this->img_lang);
			}
		}
		
		// If this function got called from the error handler we are finished here.
		if (defined('IN_ERROR_HANDLER'))
		{
			return;
		}
		
		// Disable board if the install/ directory is still present
		// For the brave development army we do not care about this, else we need to comment out this everytime we develop locally
		if (!defined('DEBUG_EXTRA') && !defined('ADMIN_START') && !defined('IN_INSTALL') && !defined('IN_LOGIN') && file_exists($phpbb_root_path . 'install'))
		{
			// Adjust the message slightly according to the permissions
			if ($phpbb_auth->acl_gets('a_', 'm_') || $phpbb_auth->acl_getf_global('m_'))
			{
				$message = 'REMOVE_INSTALL';
			}
			else
			{
				$message = (!empty($portal_config['disabled_message'])) ? $portal_config['disabled_message'] : 'BOARD_DISABLE';
			}
			trigger_error($message);
		}
		// Is portal disabled and user not an admin or moderator?
		if (($portal_config['portal_status'] == '0') && !defined('IN_LOGIN') && !$phpbb_auth->acl_gets('a_', 'm_') && !$phpbb_auth->acl_getf_global('m_'))
		{
			@header('HTTP/1.1 503 Service Unavailable');			
			// Is board disabled and user not an admin or moderator?		
			if($board_config['board_disable_mess_st'])
			{
				$message_st = $board_config['board_disable_message'];
			}
			else
			{
				$message_st = (!empty($lang['Board_disabled'])) ? $lang['Board_disabled'] : 'BOARD_DISABLE';
			}
			$message = (!empty($portal_config['disabled_message'])) ? $portal_config['disabled_message'] : $message_st;
			trigger_error($message);
		}
		
		// Is load exceeded?
		if ($board_config['limit_load'] && $this->load !== false)
		{
			if ($this->load > floatval($board_config['limit_load']) && !defined('IN_LOGIN'))
			{
				// Set board disabled to true to let the admins/mods get the proper notification
				$board_config['board_disable'] = '1';
				$portal_config['portal_status'] = '0';
				if (!$phpbb_auth->acl_gets('a_', 'm_') && !$phpbb_auth->acl_getf_global('m_'))
				{
					@header('HTTP/1.1 503 Service Unavailable');
					trigger_error('BOARD_UNAVAILABLE');
				}
			}
		}
		
		if (isset($this->data['session_viewonline']))
		{
			// Make sure the user is able to hide his session
			if (!$this->data['session_viewonline'])
			{
				// Reset online status if not allowed to hide the session...
				if (!$phpbb_auth->acl_get('u_hideonline'))
				{
					$sql = 'UPDATE ' . SESSIONS_TABLE . '
						SET session_viewonline = 1
						WHERE session_user_id = ' . $this->data['user_id'];
					if ($db->sql_query($sql))
					{
						mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
					}
					$this->data['session_viewonline'] = 1;
				}
			}
			else if (!$this->data['user_allow_viewonline'])
			{
				// the user wants to hide and is allowed to  -> cloaking device on.
				if ($phpbb_auth->acl_get('u_hideonline'))
				{
					$sql = 'UPDATE ' . SESSIONS_TABLE . '
						SET session_viewonline = 0
						WHERE session_user_id = ' . $this->data['user_id'];
					if (!$db->sql_query($sql))
					{
						mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
					}
					$this->data['session_viewonline'] = 0;
				}
			}
		}
		
		// Does the user need to change their password? If so, redirect to the
		// ucp profile reg_details page ... of course do not redirect if we're already in the ucp
		if (!defined('IN_ADMIN') && !defined('ADMIN_START') && $board_config['chg_passforce'] && $this->data['is_registered'] && $phpbb_auth->acl_get('u_chgpasswd') && $this->data['user_passchg'] < time() - ($board_config['chg_passforce'] * 86400))
		{
			if (strpos($this->page['query_string'], 'mode=reg_details') === false && $this->page['page_name'] != "ucp.$phpEx")
			{
				mx_redirect(mx_append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=profile&amp;mode=reg_details'));
			}
		}
		
		$this->is_setup_flag = true;
		
		return;
	}
	
	/**
	* Add Language Items - use_db and use_help are assigned where needed (only use them to force inclusion)
	*
	* @param mixed $lang_set specifies the language entries to include
	* @param bool $use_db internal variable for recursion, do not use
	* @param bool $use_help internal variable for recursion, do not use
	*
	* Examples:
	* <code>
	* $lang_set = array('posting', 'help' => 'faq');
	* $lang_set = array('posting', 'viewtopic', 'help' => array('bbcode', 'faq'))
	* $lang_set = array(array('posting', 'viewtopic'), 'help' => array('bbcode', 'faq'))
	* $lang_set = 'posting'
	* $lang_set = array('help' => 'faq', 'db' => array('help:faq', 'posting'))
	* </code>
	*/
	function add_lang($lang_set, $use_db = false, $use_help = false)
	{
		global $phpEx;

		if (is_array($lang_set))
		{
			foreach ($lang_set as $key => $lang_file)
			{
				// Please do not delete this line.
				// We have to force the type here, else [array] language inclusion will not work
				$key = (string) $key;

				if ($key == 'db')
				{
					$this->add_lang($lang_file, true, $use_help);
				}
				else if ($key == 'help')
				{
					$this->add_lang($lang_file, $use_db, true);
				}
				else if (!is_array($lang_file))
				{
					$this->set_lang($this->lang, $this->help, $lang_file, $use_db, $use_help);
				}
				else
				{
					$this->add_lang($lang_file, $use_db, $use_help);
				}
			}
			unset($lang_set);
		}
		elseif ($lang_set)
		{
			$this->set_lang($this->lang, $this->help, $lang_set, $use_db, $use_help);
		}
	}

	/**
	* Set language entry (called by add_lang)
	* @access private
	*/
	function set_lang(&$lang, &$help, $lang_file, $use_db = false, $use_help = false)
	{
		global $mx_root_path, $phpbb_root_path, $phpEx;

		// $lang == $this->lang
		// $help == $this->help
		// - add appropriate variables here, name them as they are used within the language file...
		if (!$use_db)
		{
			if ($use_help && strpos($lang_file, '/') !== false)
			{
				$language_filename = $this->lang_path . substr($lang_file, 0, stripos($lang_file, '/') + 1) . 'help_' . substr($lang_file, stripos($lang_file, '/') + 1) . '.' . $phpEx;
			}
			else
			{
				$language_filename = $this->lang_path . (($use_help) ? 'help_' : '') . $lang_file . '.' . $phpEx;
			}

			//fix for mxp phpbb2 backend
			if ((@include $language_filename) === false)
			{
				global $module_root_path;				
				
				//
				//this will fix the path for shared language files
				//				
				$language_phpbb2_filename = substr_count($language_filename, 'phpbb3') ? str_replace("phpbb3", "phpbb2", $language_filename) : str_replace("phpbb3", "phpbb2", $language_filename);
				$language_phpbb3_filename = substr_count($language_filename, 'phpbb2') ? str_replace("phpbb2", "phpbb3", $language_filename) : str_replace("phpb2", "phpbb3", $language_filename);				
											
				//
				//this will fix the path for anonymouse users
				//				
				$shared_phpbb2_path = substr_count($phpbb_root_path, 'phpbb3') ? str_replace("phpbb3", "phpbb2", $phpbb_root_path) : str_replace("phpbb3", "phpbb2", $phpbb_root_path);
				$shared_phpbb3_path = substr_count($phpbb_root_path, 'phpbb2') ? str_replace("phpbb2", "phpbb3", $phpbb_root_path) : str_replace("phpb2", "phpbb3", $phpbb_root_path);				
							
				if ((@include $language_phpbb3_filename) !== false)
				{
					//continue;
				}
				elseif ((@include $language_phpbb2_filename) !== false)
				{
					//continue;
				}				
				elseif ((@include $phpbb_root_path . $language_filename) !== false)
				{
					//continue;
				}
				elseif ((@include $mx_root_path . $language_filename) !== false)
				{
					//continue;
				}	
				elseif ((@include $module_root_path  . $language_filename) !== false)
				{
					//continue;
				}					
				elseif ((@include str_replace("phpbb3", "phpbb2", $language_filename)) !== false)
				{
					//continue;
				}
				elseif ((@include str_replace("phpbb2", "phpbb3", $language_filename)) === false)
				{
					$language_filename = $mx_root_path . '/language/' .$this->lang_english_name . (($use_help) ? 'help_' : '') . $lang_file . '.' . $phpEx;
					
					if ((@include str_replace("phpbb3", "phpbb2", $language_filename)) !== false)
					{
						die('Language file (set_lang) ' . str_replace("phpbb2", "phpbb3", $language_filename) . ' couldn\'t be opened by set_lang().');
					}					
				}				
			}
		}
		else
		{
			// Get Database Language Strings
			// Put them into $lang if nothing is prefixed, put them into $help if help: is prefixed
			// For example: help:faq, posting
			die("You should not use db with MX-Publisher!");
		}

		// We include common language file here to not load it every time a custom language file is included
		$this->lang = &$lang;
	}
	
	/**
	* Add Language Items from an extension - use_db and use_help are assigned where needed (only use them to force inclusion)
	*
	* @param string $ext_name The extension to load language from, or empty for core files
	* @param mixed $lang_set specifies the language entries to include
	* @param bool $use_db internal variable for recursion, do not use
	* @param bool $use_help internal variable for recursion, do not use
	*
	* Note: $use_db and $use_help should be removed. Kept for BC purposes.
	*
	* @deprecated: 3.2.0-dev (To be removed: 4.0.0)
	*/
	function add_lang_ext($ext_name, $lang_set, $use_db = false, $use_help = false)
	{
		if ($ext_name === '/')
		{
			$ext_name = '';
		}

		$this->add_lang($lang_set, $use_db, $use_help, $ext_name);
	}

	
	/**
	* More advanced language substitution
	* Function to mimic sprintf() with the possibility of using phpBB's language system to substitute nullar/singular/plural forms.
	* Params are the language key and the parameters to be substituted.
	* This function/functionality is inspired by SHS` and Ashe.
	*
	* Example call: <samp>$user->lang('NUM_POSTS_IN_QUEUE', 1);</samp>
	*/
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
		$key = $args[0];
		//$key = array_shift($args);
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
			global $lang;
		}
		
		// Return if language string does not exist
		if (!isset($lang) || (!is_string($lang) && !is_array($lang)))
		{
			return $key;
		}		
				
		// If the language entry is a string, we simply mimic sprintf() behaviour
		if (is_string($lang))
		{
			if (sizeof($args) == 1)
			{
				return $lang;
			}

			// Replace key with language entry and simply pass along...
			$args[0] = $lang;
			return call_user_func_array('sprintf', $args);
		}

		// It is an array... now handle different nullar/singular/plural forms
		$key_found = false;

		// We now get the first number passed and will select the key based upon this number
		for ($i = 1, $num_args = sizeof($args); $i < $num_args; $i++)
		{
			if (is_int($args[$i]))
			{
				$numbers = array_keys($lang);

				foreach ($numbers as $num)
				{
					if ($num > $args[$i])
					{
						break;
					}

					$key_found = $num;
				}
				break;
			}
		}

		// Ok, let's check if the key was found, else use the last entry (because it is mostly the plural form)
		if ($key_found === false)
		{
			$numbers = array_keys($lang);
			$key_found = end($numbers);
		}
				
		// Use the language string we determined and pass it to sprintf()
		//not allowed in PHP7+ 	$args[0] = $lang[$key_found];

		$args = is_array($key) ? $this->lang_array($key, $args) : array_merge($args, $lang);

		// lang key is transformed into lang(\'$1\')|, so we should not
		// need to check for it
		return call_user_func_array('sprintf', $args);		
		
	}

	/**
	* @package Sessions - Mobile Device
	* @author FlorinCB aka orynider
	* @copyright (c) 2015 Sniper_E - http://www.sniper-e.com
	* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
	* @copyright (c) 2015 martin - http://www.martins-phpbb.com
	* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
	*/
	public function mobile_device_detect($iphone = true, $ipod = true, $ipad = true, $android = true, $opera = true, $blackberry = true, $palm = true, $windows = true, $lg = true)
	{
		$mobile_browser = false;
		$user_agent = $this->request->server('HTTP_USER_AGENT');
		
		switch (true)
		{		
			case (preg_match('/x86_64|WOW64|Win64|Iceweasel/i', $user_agent) && $this->config['mobile_test_enable']);
				$status = $this->user->lang('DESKTOP');
				$mobile_browser = true;
			break;
			case (preg_match('/Bot|CFNetwork|libwww|Java|Jigsaw|SpreadTrum|httpget/i', $user_agent)) || $this->user->data['is_bot'];
				$mobile_browser = false;
			break;
			case (preg_match('/ipad/i',$user_agent));
				$status = $this->user->lang('IPAD');
				$mobile_browser = $ipad;
			break;
			case (preg_match('/ipod/i',$user_agent));
				$status = $this->user->lang('IPOD');
				$mobile_browser = $ipod;
			break;
			case (preg_match('/iphone/i', $user_agent));
				$status = $this->user->lang('IPHONE');
				$mobile_browser = $iphone;
			break;
			case (preg_match('/android/i', $user_agent));
				if (preg_match('/SM-G870A/i', $user_agent))
				{
					$status = $this->user->lang('SGS5A');
				}
				else if (preg_match('/SM-G900A|SM-G900F|SM-G900H|SM-G900M|SM-G900P|SM-G900R4|SM-G900T|SM-G900V|SM-G900W8|SM-G800F/i', $user_agent))
				{
					$status = $this->user->lang('SGS5');
				}
				else if (preg_match('/SM-G920F/i', $user_agent))
				{
					$status = $this->user->lang('SGS6');
				}
				else if (preg_match('/SGH-I497/i', $user_agent))
				{
					$status = $this->user->lang('SG2T');
				}
				else if (preg_match('/GT-P5210|SM-T110|SM-T310/i', $user_agent))
				{
					$status = $this->user->lang('SGT3');
				}
				else if (preg_match('/SM-T210/i', $user_agent))
				{
					$status = $this->user->lang('SGT3W');
				}
				else if (preg_match('/SM-T335|SM-T530/i', $user_agent))
				{
					$status = $this->user->lang('SGT4');
				}
				else if (preg_match('/SM-T520/i', $user_agent))
				{
					$status = $this->user->lang('SGTP');
				}
				else if (preg_match('/SGH-I537/i', $user_agent))
				{
					$status = $this->user->lang('SGS4A');
				}
				else if (preg_match('/GT-I9505|GT-I9500|SPH-L720T/i', $user_agent))
				{
					$status = $this->user->lang('SGS4');
				}
				else if (preg_match('/GT-I9100P/i', $user_agent))
				{
					$status = $this->user->lang('SGS2');
				}
				else if (preg_match('/SM-N9005|SM-P600/i', $user_agent))
				{
					$status = $this->user->lang('SGN3');
				}
				else if (preg_match('/SM-N7505/i', $user_agent))
				{
					$status = $this->user->lang('SGN3N');
				}
				else if (preg_match('/SM-N910C|SM-N910F/i', $user_agent))
				{
					$status = $this->user->lang('SGN4');
				}
				else if (preg_match('/SM-N920P/i', $user_agent))
				{
					$status = $this->user->lang('SGN5');
				}
				else if (preg_match('/SM-G357FZ/i', $user_agent))
				{
					$status = $this->user->lang('SGA4');
				}
				else if (preg_match('/SM-G925P/i', $user_agent))
				{
					$status = $this->user->lang('SGS6E');
				}
				else if (preg_match('/SM-G935F/i', $user_agent))
				{
					$status = $this->user->lang('SGS7E');
				}
				else if (preg_match('/SM-G950F|SM-G955F/i', $user_agent))
				{
					$status = $this->user->lang('SGS8');
				}
				else if (preg_match('/GT-S7582/i', $user_agent))
				{
					$status = $this->user->lang('SGSD2');
				}
				else if (preg_match('/GT-I9100P/i', $user_agent))
				{
					$status = $this->user->lang('SGS2');
				}
				else if (preg_match('/HONORPLK-L01/i',$user_agent))
				{
					$status = $this->user->lang('HPL01');
				}
				else if (preg_match('/EVA-L09/i', $user_agent))
				{
					$status = $this->user->lang('HPL09');
				}
				else if (preg_match('/VNS-L23/i', $user_agent))
				{
					$status = $this->user->lang('HPL23');
				}
				else if (preg_match('/IMM76B/i', $user_agent))
				{
					$status = $this->user->lang('SGN');
				}
				else if (preg_match('/TF101/i', $user_agent))
				{
					$status = $this->user->lang('ATT');
				}
				else if (preg_match('/Archos 40b/i', $user_agent))
				{
					$status = $this->user->lang('A4TS');
				}
				else if (preg_match('/A0001/i', $user_agent))
				{
					$status = $this->user->lang('OPO');
				}
				else if (preg_match('/Orange Nura/i', $user_agent))
				{
					$status = $this->user->lang('ORN');
				}
				else if (preg_match('/XT1030/i', $user_agent))
				{
					$status = $this->user->lang('MDM');
				}
				else if (preg_match('/TIANYU-KTOUCH/i', $user_agent))
				{
					$status = $this->user->lang('TKT');
				}
				else if (preg_match('/D2005|D2105/i',$user_agent))
				{
					$status = $this->user->lang('SXED');
				}
				else if (preg_match('/C2005|D2303/i', $user_agent))
				{
					$status = $this->user->lang('SXM2');
				}
				else if (preg_match('/C6906/i', $user_agent))
				{
					$status = $this->user->lang('SXZ1');
				}
				else if (preg_match('/D5803/i', $user_agent))
				{
					$status = $this->user->lang('SXZ3');
				}
				else if (preg_match('/P710/i', $user_agent))
				{
					$status = $this->user->lang('LGOL7IT');
				}
				else if (preg_match('/LG-H850/i', $user_agent))
				{
					$status = $this->user->lang('LGH850');
				}
				else if (preg_match('/LG-V500/i', $user_agent))
				{
					$status = $this->user->lang('LGV500');
				}
				else if (preg_match('/lg/i', $user_agent))
				{
					$status = $this->user->lang('LG');
				}
				else if (preg_match('/ASUS_T00J/i', $user_agent))
				{
					$status = $this->user->lang('ATOOJ');
				}
				else if (preg_match('/Aquaris E5/i', $user_agent))
				{
					$status = $this->user->lang('AE5HD');
				}
				else if (preg_match('/HTC Desire|626s/i', $user_agent))
				{
					$status = $this->user->lang('HTCD');
				}
				else if (preg_match('/Nexus One/i', $user_agent))
				{
					$status = $this->user->lang('N1');
				}
				else if (preg_match('/Nexus 4|LRX22C|LVY48F|LMY47V/i', $user_agent))
				{
					$status = $this->user->lang('N4');
				}
				else if (preg_match('/Nexus 5|LMY48S/i', $user_agent))
				{
					$status = $this->user->lang('N5');
				}
				else if (preg_match('/Nexus 7|KTU84P/i', $user_agent))
				{
					$status = $this->user->lang('N7');
				}
				else if (preg_match('/Nexus 9|LMY47X/i',$user_agent))
				{
					$status = $this->user->lang('N9');
				}
				else if (preg_match('/Lenovo_K50_T5/i', $user_agent))
				{
					$status = $this->user->lang('LK50T5');
				}
				else
				{
					$status = $this->user->lang('ANDROID');
				}
				$mobile_browser = $android;
			break;
			case (preg_match('/opera mini/i', $user_agent));
				$status = $this->user->lang('MOBILE_DEVICE');
				$mobile_browser = $opera;
			break;
			case (preg_match('/blackberry/i', $user_agent));
				if (preg_match('/BlackBerry9900|BlackBerry9930|BlackBerry9790|BlackBerry9780|BlackBerry9700|BlackBerry9650|BlackBerry9000|/i',$user_agent))
				{
					$status = 'BlackBerry Bold';
				}
				else if (preg_match('/BlackBerry9380|BlackBerry9370|BlackBerry9360|BlackBerry9350|BlackBerry9330|BlackBerry9320|BlackBerry9300|BlackBerry9220|BlackBerry8980|BlackBerry8900|BlackBerry8530|BlackBerry8520|BlackBerry8330|BlackBerry8320|BlackBerry8310|BlackBerry8300/i',$user_agent))
				{
					$status = $this->user->lang('BBCURVE');
				}
				else if (preg_match('/BlackBerry9860|BlackBerry9850|BlackBerry9810|BlackBerry9800/i', $user_agent))
				{
					$status = $this->user->lang('BBTORCH');
				}
				else if (preg_match('/BlackBerry9900/i', $user_agent))
				{
					$status = $this->user->lang('BBTOUCH');
				}
				else if (preg_match('/BlackBerry9105/i', $user_agent))
				{
					$status = $this->user->lang('BBPEARL');
				}
				else if (preg_match('/BlackBerry8220/i', $user_agent))
				{
					$status = $this->user->lang('BBPEARLF');
				}
				else if (preg_match('/BlackBerry Storm|BlackBerry Storm2/i', $user_agent))
				{
					$status = $this->user->lang('BBSTORM');
				}
				else if (preg_match('/BlackBerry Passport/i', $user_agent))
				{
					$status = $this->user->lang('BBPP');
				}
				else if (preg_match('/BlackBerry Porsche/i',$user_agent))
				{
					$status = $this->user->lang('BBP');
				}
				else if (preg_match('/BlackBerry PlayBook/i', $user_agent))
				{
					$status = $this->user->lang('BBPB');
				}
				else
				{
					$status = $this->user->lang('BLACKBERRY');
				}
				$mobile_browser = $blackberry;
			break;
			case (preg_match('/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i', $user_agent));
				$status = $this->user->lang('PALM');
				$mobile_browser = $palm;
			break;
			case (preg_match('/(iris|3g_t|windows ce|windows Phone|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i', $user_agent));
				if (preg_match('/Lumia 640 XL/i', $user_agent))
				{
					$status = $this->user->lang('L640XL');
				}
				else
				{
					$status = $this->user->lang('WSP');
				}
				$mobile_browser = $windows;
			break;
			case (preg_match('/lge vx10000/i', $user_agent));
				$status = $this->user->lang('VOYAGER');
				$mobile_browser = $windows;
			break;
			case (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320|vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i', $user_agent));
				$status = $this->user->lang('MOBILE_DEVICE');
				$mobile_browser = true;
			break;
			case (isset($post['HTTP_X_WAP_PROFILE'])||isset($post['HTTP_PROFILE']));
				$status = $this->user->lang('MOBILE_DEVICE');
				$mobile_browser = true;
			break;
			case (in_array(strtolower(substr($user_agent, 0, 4)), array('1207'=>'1207','3gso'=>'3gso','4thp'=>'4thp','501i'=>'501i','502i'=>'502i','503i'=>'503i','504i'=>'504i','505i'=>'505i','506i'=>'506i','6310'=>'6310','6590'=>'6590','770s'=>'770s','802s'=>'802s','a wa'=>'a wa','acer'=>'acer','acs-'=>'acs-','airn'=>'airn','alav'=>'alav','asus'=>'asus','attw'=>'attw','au-m'=>'au-m','aur '=>'aur ','aus '=>'aus ','abac'=>'abac','acoo'=>'acoo','aiko'=>'aiko','alco'=>'alco','alca'=>'alca','amoi'=>'amoi','anex'=>'anex','anny'=>'anny','anyw'=>'anyw','aptu'=>'aptu','arch'=>'arch','argo'=>'argo','bell'=>'bell','bird'=>'bird','bw-n'=>'bw-n','bw-u'=>'bw-u','beck'=>'beck','benq'=>'benq','bilb'=>'bilb','blac'=>'blac','c55/'=>'c55/','cdm-'=>'cdm-','chtm'=>'chtm','capi'=>'capi','cond'=>'cond','craw'=>'craw','dall'=>'dall','dbte'=>'dbte','dc-s'=>'dc-s','dica'=>'dica','ds-d'=>'ds-d','ds12'=>'ds12','dait'=>'dait','devi'=>'devi','dmob'=>'dmob','doco'=>'doco','dopo'=>'dopo','el49'=>'el49','erk0'=>'erk0','esl8'=>'esl8','ez40'=>'ez40','ez60'=>'ez60','ez70'=>'ez70','ezos'=>'ezos','ezze'=>'ezze','elai'=>'elai','emul'=>'emul','eric'=>'eric','ezwa'=>'ezwa','fake'=>'fake','fly-'=>'fly-','fly_'=>'fly_','g-mo'=>'g-mo','g1 u'=>'g1 u','g560'=>'g560','gf-5'=>'gf-5','grun'=>'grun','gene'=>'gene','go.w'=>'go.w','good'=>'good','grad'=>'grad','hcit'=>'hcit','hd-m'=>'hd-m','hd-p'=>'hd-p','hd-t'=>'hd-t','hei-'=>'hei-','hp i'=>'hp i','hpip'=>'hpip','hs-c'=>'hs-c','htc '=>'htc ','htc-'=>'htc-','htca'=>'htca','htcg'=>'htcg','htcp'=>'htcp','htcs'=>'htcs','htct'=>'htct','htc_'=>'htc_','haie'=>'haie','hita'=>'hita','huaw'=>'huaw','hutc'=>'hutc','i-20'=>'i-20','i-go'=>'i-go','i-ma'=>'i-ma','i230'=>'i230','iac'=>'iac','iac-'=>'iac-','iac/'=>'iac/','ig01'=>'ig01','im1k'=>'im1k','inno'=>'inno','iris'=>'iris','jata'=>'jata','java'=>'java','kddi'=>'kddi','kgt'=>'kgt','kgt/'=>'kgt/','kpt '=>'kpt ','kwc-'=>'kwc-','klon'=>'klon','lexi'=>'lexi','lg g'=>'lg g','lg-a'=>'lg-a','lg-b'=>'lg-b','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-f'=>'lg-f','lg-g'=>'lg-g','lg-k'=>'lg-k','lg-l'=>'lg-l','lg-m'=>'lg-m','lg-o'=>'lg-o','lg-p'=>'lg-p','lg-s'=>'lg-s','lg-t'=>'lg-t','lg-u'=>'lg-u','lg-w'=>'lg-w','lg/k'=>'lg/k','lg/l'=>'lg/l','lg/u'=>'lg/u','lg50'=>'lg50','lg54'=>'lg54','lge-'=>'lge-','lge/'=>'lge/','lynx'=>'lynx','leno'=>'leno','m1-w'=>'m1-w','m3ga'=>'m3ga','m50/'=>'m50/','maui'=>'maui','mc01'=>'mc01','mc21'=>'mc21','mcca'=>'mcca','medi'=>'medi','meri'=>'meri','mio8'=>'mio8','mioa'=>'mioa','mo01'=>'mo01','mo02'=>'mo02','mode'=>'mode','modo'=>'modo','mot '=>'mot ','mot-'=>'mot-','mt50'=>'mt50','mtp1'=>'mtp1','mtv '=>'mtv ','mate'=>'mate','maxo'=>'maxo','merc'=>'merc','mits'=>'mits','mobi'=>'mobi','motv'=>'motv','mozz'=>'mozz','n100'=>'n100','n101'=>'n101','n102'=>'n102','n202'=>'n202','n203'=>'n203','n300'=>'n300','n302'=>'n302','n500'=>'n500','n502'=>'n502','n505'=>'n505','n700'=>'n700','n701'=>'n701','n710'=>'n710','nec-'=>'nec-','nem-'=>'nem-','newg'=>'newg','neon'=>'neon','netf'=>'netf','noki'=>'noki','nzph'=>'nzph','o2 x'=>'o2 x','o2-x'=>'o2-x','opwv'=>'opwv','owg1'=>'owg1','opti'=>'opti','oran'=>'oran','p800'=>'p800','pand'=>'pand','pg-1'=>'pg-1','pg-2'=>'pg-2','pg-3'=>'pg-3','pg-6'=>'pg-6','pg-8'=>'pg-8','pg-c'=>'pg-c','pg13'=>'pg13','phil'=>'phil','pn-2'=>'pn-2','pt-g'=>'pt-g','palm'=>'palm','pana'=>'pana','pire'=>'pire','pock'=>'pock','pose'=>'pose','psio'=>'psio','qa-a'=>'qa-a','qc-2'=>'qc-2','qc-3'=>'qc-3','qc-5'=>'qc-5','qc-7'=>'qc-7','qc07'=>'qc07','qc12'=>'qc12','qc21'=>'qc21','qc32'=>'qc32','qc60'=>'qc60','qci-'=>'qci-','qwap'=>'qwap','qtek'=>'qtek','r380'=>'r380','r600'=>'r600','raks'=>'raks','rim9'=>'rim9','rove'=>'rove','s55/'=>'s55/','sage'=>'sage','sams'=>'sams','sc01'=>'sc01','sch-'=>'sch-','scp-'=>'scp-','sdk/'=>'sdk/','se47'=>'se47','sec-'=>'sec-','sec0'=>'sec0','sec1'=>'sec1','semc'=>'semc','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','sk-0'=>'sk-0','sl45'=>'sl45','slid'=>'slid','smb3'=>'smb3','smt5'=>'smt5','sp01'=>'sp01','sph-'=>'sph-','spv '=>'spv ','spv-'=>'spv-','sy01'=>'sy01','samm'=>'samm','sany'=>'sany','sava'=>'sava','scoo'=>'scoo','send'=>'send','siem'=>'siem','smar'=>'smar','smit'=>'smit','soft'=>'soft','sony'=>'sony','t-mo'=>'t-mo','t218'=>'t218','t250'=>'t250','t600'=>'t600','t610'=>'t610','t618'=>'t618','tcl-'=>'tcl-','tdg-'=>'tdg-','telm'=>'telm','tim-'=>'tim-','ts70'=>'ts70','tsm-'=>'tsm-','tsm3'=>'tsm3','tsm5'=>'tsm5','tx-9'=>'tx-9','tagt'=>'tagt','talk'=>'talk','teli'=>'teli','topl'=>'topl','hiba'=>'hiba','up.b'=>'up.b','upg1'=>'upg1','utst'=>'utst','v400'=>'v400','v750'=>'v750','veri'=>'veri','vk-v'=>'vk-v','vk40'=>'vk40','vk50'=>'vk50','vk52'=>'vk52','vk53'=>'vk53','vm40'=>'vm40','vx98'=>'vx98','virg'=>'virg','vite'=>'vite','voda'=>'voda','vulc'=>'vulc','w3c '=>'w3c ','w3c-'=>'w3c-','wapj'=>'wapj','wapp'=>'wapp','wapu'=>'wapu','wapm'=>'wapm','wig '=>'wig ','wapi'=>'wapi','wapr'=>'wapr','wapv'=>'wapv','wapy'=>'wapy','wapa'=>'wapa','waps'=>'waps','wapt'=>'wapt','winc'=>'winc','winw'=>'winw','wonu'=>'wonu','x700'=>'x700','xda2'=>'xda2','xdag'=>'xdag','yas-'=>'yas-','your'=>'your','zte-'=>'zte-','zeto'=>'zeto','acs-'=>'acs-','alav'=>'alav','alca'=>'alca','amoi'=>'amoi','aste'=>'aste','audi'=>'audi','avan'=>'avan','benq'=>'benq','bird'=>'bird','blac'=>'blac','blaz'=>'blaz','brew'=>'brew','brvw'=>'brvw','bumb'=>'bumb','ccwa'=>'ccwa','cell'=>'cell','cldc'=>'cldc','cmd-'=>'cmd-','dang'=>'dang','doco'=>'doco','eml2'=>'eml2','eric'=>'eric','fetc'=>'fetc','hipt'=>'hipt','http'=>'http','ibro'=>'ibro','idea'=>'idea','ikom'=>'ikom','inno'=>'inno','ipaq'=>'ipaq','jbro'=>'jbro','jemu'=>'jemu','java'=>'java','jigs'=>'jigs','kddi'=>'kddi','keji'=>'keji','kyoc'=>'kyoc','kyok'=>'kyok','leno'=>'leno','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-g'=>'lg-g','lge-'=>'lge-','libw'=>'libw','m-cr'=>'m-cr','maui'=>'maui','maxo'=>'maxo','midp'=>'midp','mits'=>'mits','mmef'=>'mmef','mobi'=>'mobi','mot-'=>'mot-','moto'=>'moto','mwbp'=>'mwbp','mywa'=>'mywa','nec-'=>'nec-','newt'=>'newt','nok6'=>'nok6','noki'=>'noki','o2im'=>'o2im','opwv'=>'opwv','palm'=>'palm','pana'=>'pana','pant'=>'pant','pdxg'=>'pdxg','phil'=>'phil','play'=>'play','pluc'=>'pluc','port'=>'port','prox'=>'prox','qtek'=>'qtek','qwap'=>'qwap','rozo'=>'rozo','sage'=>'sage','sama'=>'sama','sams'=>'sams','sany'=>'sany','sch-'=>'sch-','sec-'=>'sec-','send'=>'send','seri'=>'seri','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','siem'=>'siem','smal'=>'smal','smar'=>'smar','sony'=>'sony','sph-'=>'sph-','symb'=>'symb','t-mo'=>'t-mo','teli'=>'teli','tim-'=>'tim-','tosh'=>'tosh','treo'=>'treo','tsm-'=>'tsm-','upg1'=>'upg1','upsi'=>'upsi','vk-v'=>'vk-v','voda'=>'voda','vx52'=>'vx52','vx53'=>'vx53','vx60'=>'vx60','vx61'=>'vx61','vx70'=>'vx70','vx80'=>'vx80','vx81'=>'vx81','vx83'=>'vx83','vx85'=>'vx85','wap-'=>'wap-','wapa'=>'wapa','wapi'=>'wapi','wapp'=>'wapp','wapr'=>'wapr','webc'=>'webc','whit'=>'whit','winw'=>'winw','wmlb'=>'wmlb','xda-'=>'xda-',)));
				$status = $this->user->lang('MOBILE_DEVICE');
				$mobile_browser = true;
			break;
			default;
				$status = $this->user->lang('DESKTOP');
				$mobile_browser = false;
			break;
		}
		header('Cache-Control: no-transform');
		header('Vary: User-Agent');
		
		if ($mobile_browser == '')
		{
			return $mobile_browser;
		}
		else
		{
			return array($mobile_browser, $status);
		}
	}
	
	/**
	* Format user date
	*
	* @param int $gmepoch unix timestamp
	* @param string $format date format in date() notation. | used to indicate relative dates, for example |d m Y|, h:i is translated to Today, h:i.
	* @param bool $forcedate force non-relative date format.
	*
	* @return mixed translated date
	*/
	function format_date($gmepoch, $format = false, $forcedate = false)
	{
		static $midnight;
		static $date_cache;

		$format = (!$format) ? $this->date_format : $format;
		$now = time();
		$delta = $now - $gmepoch;

		if (!isset($date_cache[$format]))
		{
			// Is the user requesting a friendly date format (i.e. 'Today 12:42')?
			$date_cache[$format] = array(
				'is_short'		=> strpos($format, '|'),
				'format_short'	=> substr($format, 0, strpos($format, '|')) . '||' . substr(strrchr($format, '|'), 1),
				'format_long'	=> str_replace('|', '', $format),
				// Filter out values that are not strings (e.g. arrays) for strtr().
				'lang'			=> array_filter($this->lang['datetime'], 'is_string'),
			);

			// Short representation of month in format? Some languages use different terms for the long and short format of May
			if ((strpos($format, '\M') === false && strpos($format, 'M') !== false) || (strpos($format, '\r') === false && strpos($format, 'r') !== false))
			{
				$date_cache[$format]['lang']['May'] = $this->lang('datetime', 'May_short');
			}
		}

		// Zone offset
		$zone_offset = $this->timezone + $this->dst;

		// Show date <= 1 hour ago as 'xx min ago' but not greater than 60 seconds in the future
		// A small tolerence is given for times in the future but in the same minute are displayed as '< than a minute ago'
		if ($delta <= 3600 && $delta > -60 && ($delta >= -5 || (($now / 60) % 60) == (($gmepoch / 60) % 60)) && $date_cache[$format]['is_short'] !== false && !$forcedate && isset($this->lang['datetime']['AGO']))
		{
			return $this->lang(array('datetime', 'AGO'), max(0, (int) floor($delta / 60)));
		}

		if (!$midnight)
		{
			list($d, $m, $y) = explode(' ', gmdate('j n Y', time() + $zone_offset));
			$midnight = gmmktime(0, 0, 0, $m, $d, $y) - $zone_offset;
		}

		if ($date_cache[$format]['is_short'] !== false && !$forcedate && !($gmepoch < $midnight - 86400 || $gmepoch > $midnight + 172800))
		{
			$day = false;

			if ($gmepoch > $midnight + 86400)
			{
				$day = 'TOMORROW';
			}
			else if ($gmepoch > $midnight)
			{
				$day = 'TODAY';
			}
			else if ($gmepoch > $midnight - 86400)
			{
				$day = 'YESTERDAY';
			}

			if ($day !== false)
			{
				return str_replace('||', $this->lang['datetime'][$day], strtr(@gmdate($date_cache[$format]['format_short'], $gmepoch + $zone_offset), $date_cache[$format]['lang']));
			}
		}

		return strtr(@gmdate($date_cache[$format]['format_long'], $gmepoch + $zone_offset), $date_cache[$format]['lang']);
	}
	

	/**
	* Create a \phpbb\datetime object in the context of the current user
	*
	* @since 3.1
	* @param string $time String in a format accepted by strtotime().
	* @param DateTimeZone $timezone Time zone of the time.
	* @return \phpbb\datetime Date time object linked to the current users locale
	*/
	public function create_datetime($time = 'now', \DateTimeZone $timezone = null)
	{
		$timezone = $timezone ?: $this->timezone;
		/**
		$timezones = array('Europe/London', 'Mars/Olympus', 'Mars/Ascraeus', timezone_name_from_abbr('', $timezone, 0));
				
		foreach ($timezones as $tz) 
		{
		    try 
			{
		        $mars = new DateTimeZone($tz);
		    } 
			
			catch(Exception $e) 
			{
		        echo $e->getMessage() . '<br />';
		    }
		}
		*/		
		return new DateTime($time, new DateTimeZone(timezone_name_from_abbr('', $timezone, 0)));
	}

	/**
	* Get the UNIX timestamp for a datetime in the users timezone, so we can store it in the database.
	*
	* @param	string			$format		Format of the entered date/time
	* @param	string			$time		Date/time with the timezone applied
	* @param	DateTimeZone	$timezone	Timezone of the date/time, falls back to timezone of current user
	* @return	int			Returns the unix timestamp
	*/
	public function get_timestamp_from_format($format, $time, \DateTimeZone $timezone = null)
	{
		$timezone = $timezone ?: $this->timezone;
		$date = \DateTime::createFromFormat($format, $time, $timezone);
		return ($date !== false) ? $date->format('U') : false;
	}
	
	/**
	* Get language id currently used by the user
	**/
	function get_iso_lang_id()
	{
		global $board_config, $db;
		
		if (!empty($this->lang_id))
		{
			return $this->lang_id;
		}
		
		if (!$this->lang_name)
		{
			$this->lang_name = $board_config['default_lang'];
		}
		
		$sql = 'SELECT lang_id
			FROM ' . LANG_TABLE . "
			WHERE lang_iso = '" . $db->sql_escape($this->lang_name) . "'";
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
		
		$this->lang_id = (int) $db->sql_fetchfield('lang_id');
		$db->sql_freeresult($result);
		
		return $this->lang_id;
	}

	/**
	* Get users profile fields
	*/
	function get_profile_fields($user_id)
	{
		global $db;

		if (isset($this->profile_fields))
		{
			return;
		}

		$sql = 'SELECT *
			FROM ' . PROFILE_FIELDS_DATA_TABLE . "
			WHERE user_id = $user_id";
		$result = $db->sql_query_limit($sql, 1);
		$this->profile_fields = (!($row = $db->sql_fetchrow($result))) ? array() : $row;
		$db->sql_freeresult($result);
	}
	
	/**
	 * Gets the user's info
	 *
	 * Will take the users email, username or member id and return their data
	 *
	 * @param  int || string $username the user's email address username or member id
	 * @return array $results containing the user info || bool false
	 * @since  0.1.2
	 */
	function load_user($user, $force_str = false)
	{
		if (!is_numeric($user) || $force_str)
		{
			$user = $phpBB2->phpbb_clean_username($user);
		}
		else
		{
			$user = intval($user);
		}	
		
	    //$this->data = array();
		
	    // we'll try id || email, then username
	    if (is_numeric($user))
		{
	        // number is most likely a member id
	        $this->data = get_user_by_id($user);
	    } 
		else 
		{
	        // the email can't be purely numeric
	        $this->data = get_user_by_email($user);
	    }
		
	    if (empty($this->data))
		{
	        $this->data = get_user_by_username($user);
	    }
		/*
	    if (empty($this->data)) 
		{
	        return false;
	    } 
		else
		{
	        return $this->data;
	    }
		*/
	}

	/**
	* Load user helper
	*
	* @param array $user_ids
	*/
	function load_users(array $user_ids)
	{
		$user_ids[] = ANONYMOUS;
		
		// Make user_ids unique and convert to integer.
		$user_ids = array_map('intval', array_unique($user_ids));
		
		// Do not load users we already have in $this->users
		$user_ids = array_diff($user_ids, array_keys($this->users));
		
		if (sizeof($user_ids))
		{
			$sql = 'SELECT *
				FROM ' . USERS_TABLE . '
				WHERE ' . $db->sql_in_set('user_id', $user_ids);
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
			
			while ($row = $db->sql_fetchrow($result))
			{
				$this->users[$row['user_id']] = $row;
			}
			$db->sql_freeresult($result);
		}
	}	
	
	/**
	 * Gets the user's info from their email address
	 *
	 * Will take the users email address and return an array containing all the
	 * user's information in the db. Will return false on failure
	 *
	 * @param  string $email the user's email address
	 * @return array $results containing the user info || bool false
	 * @since  0.1.0
	 */
	function get_user_by_email($email_address = '')
	{
		global $db;
		if ('' == $email_address || !is_string($email_address) || 2 > count(explode('@', $email_address))) 
		{
			return false;
		}
		$sql = $db->sql_build_query('SELECT', '
			SELECT * FROM ' . USERS_TABLE . '
				WHERE email_address = {string:email_address}',
				array('email_address' => $email_address, ));
		$result = $db->sql_query_limit($sql, 1);
		$return = $db->sql_fetchrow($result);
		if (!$return)
		{
			$db->sql_freeresult($result);
			//trigger_error($mx_user->lang['NO_USER'] . adm_back_link($this->u_action), E_USER_WARNING);
		}
		if (empty($return)) 
		{
			return false;
		} 
		else
		{
		    // return all the results.
		    return $return;
		}
	}

	/**
	 * Gets the user's info from their member id
	 *
	 * Will take the users member id and return an array containing all the
	 * user's information in the db. Will return false on failure
	 *
	 * @param  int $id the user's member id
	 * @return array $results containing the user info || bool false
	 * @since  0.1.2
	 */
	function get_user_by_id($user_id = '')
	{
		global $db;
		if ('' == $user_id || !is_numeric($user_id))
		{
			return false;
		} 
		else
		{
			$id = intval($user_id);
			if (0 == $user_id) 
			{
				return false;
			}
		}
		$sql = $db->sql_build_query('SELECT', '
			SELECT * FROM ' . USERS_TABLE . '
				WHERE user_id = {int:user_id}',
				array('user_id' => $user_id, ));
		$result = $db->sql_query_limit($sql, 1);
		$return = $db->sql_fetchrow($result);
		if (!$return)
		{
			$db->sql_freeresult($result);
			//trigger_error($mx_user->lang['NO_USER'] . adm_back_link($this->u_action), E_USER_WARNING);
		}
		if (empty($return)) 
		{
			return false;
		} 
		else
		{
		    // return all the results.
		    return $return;
		}
	}	
	
	/**
	 * Gets the user's info from their member name (username)
	 *
	 * Will take the users member name and return an array containing all the
	 * user's information in the db. Will return false on failure
	 *
	 * @param  string $username the user's member name
	 * @return array $results containing the user info || bool false
	 * @since  0.1.0
	 */
	function get_user_by_name($user_name = '')
	{
	    global $db;
		if ('' == $user_name || !is_string($user_name))
		{
	        return false;
	    }	
		$sql = $db->sql_build_query('SELECT', '
			SELECT * FROM ' . USERS_TABLE . '
				WHERE user_name = {string:user_name}',
				array('user_name' => $user_name, ));
		$result = $db->sql_query_limit($sql, 1);
		$return = $db->sql_fetchrow($result);
		if (!$return)
		{
			$db->sql_freeresult($result);
			//trigger_error($mx_user->lang['NO_USER'] . adm_back_link($this->u_action), E_USER_WARNING);
		}
		if (empty($return)) 
		{
			return false;
		} 
		else
		{
		    // return all the results.
		    return $return;
		}
	}		

/**
	* Generates default bitfield
	*
	* This bitfield decides which bbcodes are defined in a template.
	*
	* @return string Bitfield
	*/
	public function default_bitfield()
	{
		static $value;
		if (isset($value))
		{
			return $value;
		}

		// Hardcoded template bitfield to add for new templates
		$default_bitfield = '1111111111111';

		$bitfield = new bitfield();
		for ($i = 0; $i < strlen($default_bitfield); $i++)
		{
			if ($default_bitfield[$i] == '1')
			{
				$bitfield->set($i);
			}
		}

		return $bitfield->get_base64();
	}
	
	/**
	* Read style configuration file
	*
	* @param string $dir style directory
	* @return array|bool Style data, false on error
	*/
	protected function read_style_cfg($dir)
	{
		static $required = array('name', 'phpbb_version', 'copyright');
		$cfg = parse_cfg_file($this->styles_path . $dir . '/style.cfg');

		// Check if it is a valid file
		foreach ($required as $key)
		{
			if (!isset($cfg[$key]))
			{
				return false;
			}
		}

		// Check data
		if (!isset($cfg['parent']) || !is_string($cfg['parent']) || $cfg['parent'] == $cfg['name'])
		{
			$cfg['parent'] = '';
		}
		if (!isset($cfg['template_bitfield']))
		{
			$cfg['template_bitfield'] = $this->default_bitfield();
		}

		return $cfg;
	}
	
	/**
	* Specify/Get phpBB3 images array from phpBB2 images  variable
	*/
	function image_rows($images)
	{	
			/* Here we overwrite phpBB images from the template db or configuration file  */		
			$rows = array( 
			array(	'image_id' => 1, 
					'image_name' => $this->img_name_ext('site_logo.gif', false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext('site_logo.gif', false, false, $type = 'filename'), 
					'image_lang' => '',
					'image_height' => 52, 
					'image_width' => 139, 
					'imageset_id' => 1 
				), 
			array(	'image_id' => 2, 
					'image_name' => 'forum_link', 
					'image_filename' => 'forum_link.gif', 
					'image_lang' => '', 
					'image_height' => 27, 
					'image_width' => 27, 
					'imageset_id' => 1 
				), 
			array( 'image_id' => 3, 
					'image_name' => $this->img_name_ext($images['forum'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['forum'], false, false, $type = 'filename'), 
					'image_lang' => '', 
					'image_height' => 27, 
					'image_width' => 27, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 4, 
					'image_name' => $this->img_name_ext($images['forum_locked'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['forum_locked'], false, false, $type = 'filename'), 
					'image_lang' => '',
					'image_height' => 27, 
					'image_width' => 27, 
					'imageset_id' => 1 
					),
			array( 'image_id' => 5, 
					'image_name' => $this->img_name_ext($images['forums'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['forums'], false, false, $type = 'filename'), 
					'image_lang' => '',
					'image_height' => 27, 
					'image_width' => 27, 
					'imageset_id' => 1 
					), 
			array( 
					'image_id' => 6, 
					'image_name' => $this->img_name_ext($images['forum_new'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['forum_new'], false, false, $type = 'filename'), 
					'image_lang' => '',
					'image_height' => 27, 
					'image_width' => 27, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 7, 
					'image_name' => 'forum_unread_locked', 
					'image_filename' => 'forum_unread_locked.gif', 
					'image_lang' => '', 'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 8, 
					'image_name' => $this->img_name_ext($images['forums_new'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['forums_new'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 9, 
					'image_name' => 'topic_moved', 
					'image_filename' => 'topic_moved.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 10, 
					'image_name' => $this->img_name_ext($images['folder'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['folder'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 11, 
					'image_name' => $this->img_name_ext($images['folder_sticky'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['folder_sticky'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 12, 
					'image_name' => $this->img_name_ext($images['folder_hot'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['folder_hot'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 13, 
					'image_name' => 'topic_read_hot_mine', 
					'image_filename' => 'topic_read_hot_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 14, 
					'image_name' => $this->img_name_ext($images['folder_locked'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['folder_locked'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 15, 
					'image_name' => 'topic_read_locked_mine', 
					'image_filename' => 'topic_read_locked_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 16, 
					'image_name' => $this->img_name_ext($images['folder_new'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['folder_new'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 17, 
					'image_name' => $this->img_name_ext($images['folder_sticky_new'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['folder_sticky_new'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 18, 
					'image_name' => $this->img_name_ext($images['folder_hot_new'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['folder_hot_new'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 19, 
					'image_name' => 'topic_unread_hot_mine', 
					'image_filename' => 'topic_unread_hot_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					),
			array( 'image_id' => 20, 
					'image_name' => $this->img_name_ext($images['folder_locked_new'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['folder_locked_new'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 21, 
					'image_name' => 'topic_unread_locked_mine', 
					'image_filename' => 'topic_unread_locked_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 22, 
					'image_name' => 'sticky_read', 
					'image_filename' => 'sticky_read.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 23, 
					'image_name' => 'sticky_read_mine', 
					'image_filename' => 'sticky_read_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 24, 
					'image_name' => 'sticky_read_locked', 
					'image_filename' => 'sticky_read_locked.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 25, 
					'image_name' => 'sticky_read_locked_mine', 
					'image_filename' => 'sticky_read_locked_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 26, 
					'image_name' => 'sticky_unread', 
					'image_filename' => 'sticky_unread.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 27, 
					'image_name' => 'sticky_unread_mine', 
					'image_filename' => 'sticky_unread_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 28, 
					'image_name' => 'sticky_unread_locked', 
					'image_filename' => 'sticky_unread_locked.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 29, 
					'image_name' => 'sticky_unread_locked_mine', 
					'image_filename' => 'sticky_unread_locked_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 30, 
					'image_name' => $this->img_name_ext($images['folder_announce'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['folder_announce'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 31, 
					'image_name' => 'announce_read_mine', 
					'image_filename' => 'announce_read_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 32, 
					'image_name' => 'announce_read_locked', 
					'image_filename' => 'announce_read_locked.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 33, 
					'image_name' => 'announce_read_locked_mine', 
					'image_filename' => 'announce_read_locked_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 34, 
					'image_name' => $this->img_name_ext($images['folder_announce_new'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['folder_announce_new'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 35, 
					'image_name' => 'announce_unread_mine', 
					'image_filename' => 'announce_unread_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 36, 
					'image_name' => 'announce_unread_locked', 
					'image_filename' => 'announce_unread_locked.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 37, 
					'image_name' => 'announce_unread_locked_mine', 
					'image_filename' => 'announce_unread_locked_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 38, 
					'image_name' => 'global_read', 
					'image_filename' => $this->img_name_ext($images['folder_announce'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 39, 
					'image_name' => 'global_read_mine', 
					'image_filename' => 'announce_read_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 40, 
					'image_name' => 'global_read_locked', 
					'image_filename' => 'announce_read_locked.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 41, 
					'image_name' => 'global_read_locked_mine', 
					'image_filename' => 'announce_read_locked_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1
					), 
			array( 'image_id' => 42, 
					'image_name' => 'global_unread', 
					'image_filename' => $this->img_name_ext($images['folder_announce_new'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 43, 
					'image_name' => 'global_unread_mine', 
					'image_filename' => 'announce_unread_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 44, 
					'image_name' => 'global_unread_locked', 
					'image_filename' => 'announce_unread_locked.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 45, 
					'image_name' => 'global_unread_locked_mine', 
					'image_filename' => 'announce_unread_locked_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 46, 
					'image_name' => 'pm_read', 
					'image_filename' => $this->img_name_ext($images['folder'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 47, 
					'image_name' => 'pm_unread', 
					'image_filename' => $this->img_name_ext($images['folder_new'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 48, 
					'image_name' => 'icon_back_top', 
					'image_filename' => 'icon_back_top.gif', 
					'image_lang' => '',  
					'image_height' => 11, 
					'image_width' => 11 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 49, 
					'image_name' => $this->img_name_ext($images['icon_aim'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['icon_aim'], false, false, $type = 'filename'), 
					'image_lang' => '{LANG}',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 50, 
					'image_name' => $this->img_name_ext($images['icon_email'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['icon_email'], false, false, $type = 'filename'), 
					'image_lang' => '{LANG}',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 51, 
					'image_name' => $this->img_name_ext($images['icon_icq'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['icon_icq'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 52, 
					'image_name' => 'icon_contact_jabber', 
					'image_filename' => 'icon_contact_jabber.gif', 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 53, 
					'image_name' => $this->img_name_ext($images['icon_msnm'], false, false, $type = 'name'),  
					'image_filename' => $this->img_name_ext($images['icon_msnm'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 54, 
					'image_name' => $this->img_name_ext($images['icon_www'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['icon_www'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 55, 
					'image_name' => $this->img_name_ext($images['icon_yim'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['icon_yim'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 56, 
					'image_name' => $this->img_name_ext($images['icon_delpost'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['icon_delpost'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 57, 
					'image_name' => 'icon_post_info', 
					'image_filename' => 'icon_post_info.gif', 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 58, 
					'image_name' => 'icon_post_report', 
					'image_filename' => 'icon_post_report.gif', 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 59, 
					'image_name' => $this->img_name_ext($images['icon_minipost'], false, false, $type = 'name'), 
					'image_filename' => $this->img_name_ext($images['icon_minipost'], false, false, $type = 'filename'), 
					'image_lang' => '',  
					'image_height' => 9, 
					'image_width' => 11 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 60, 
					 'image_name' => $this->img_name_ext($images['icon_minipost_new'], false, false, $type = 'name'), 
					 'image_filename' => $this->img_name_ext($images['icon_minipost_new'], false, false, $type = 'filename'), 
					 'image_lang' => '',  
					 'image_height' => 9, 
					 'image_width' => 11 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 61, 
					 'image_name' => 'icon_topic_attach', 
					 'image_filename' => 'icon_topic_attach.gif', 
					 'image_lang' => '',  
					 'image_height' => 10, 
					 'image_width' => 7 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 62, 
					 'image_name' => 'icon_topic_latest', 
					 'image_filename' => 'icon_topic_latest.gif', 
					 'image_lang' => '',  
					 'image_height' => 9, 
					 'image_width' => 11 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 63, 
					 'image_name' => 'icon_topic_newest', 
					 'image_filename' => 'icon_topic_newest.gif', 
					 'image_lang' => '',  
					 'image_height' => 9, 
					 'image_width' => 11 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 64, 
					 'image_name' => 'icon_topic_reported', 
					 'image_filename' => 'icon_topic_reported.gif', 
					 'image_lang' => '',  
					 'image_height' => 14, 
					 'image_width' => 16 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 65, 
					 'image_name' => 'icon_topic_unapproved', 
					 'image_filename' => 'icon_topic_unapproved.gif', 
					 'image_lang' => '',  
					 'image_height' => 14, 
					 'image_width' => 16 , 
					 'imageset_id' => 1
					 ), 
			array( 'image_id' => 66, 
					 'image_name' => 'icon_user_warn', 
					 'image_filename' => 'icon_user_warn.gif', 
					 'image_lang' => '',  
					 'image_height' => 20, 
					 'image_width' => 20, 
					 'imageset_id' => 1
					 ), 
			array( 'image_id' => 67, 
					 'image_name' => 'subforum_read', 
					 'image_filename' => 'subforum_read.gif', 
					 'image_lang' => '',  
					 'image_height' => 9, 
					 'image_width' => 11 , 
					 'imageset_id' => 1
					 ), 
			array( 'image_id' => 68, 
					 'image_name' => 'subforum_unread', 
					 'image_filename' => 'subforum_unread.gif', 
					 'image_lang' => '',  
					 'image_height' => 9, 
					 'image_width' => 11 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 69, 
					 'image_name' => $this->img_name_ext($images['icon_pm'], false, false, $type = 'name'), 
					 'image_filename' => $this->img_name_ext($images['icon_pm'], false, false, $type = 'filename'), 
					 'image_lang' => '{LANG}',   
					 'image_height' => 20, 
					 'image_width' => 28 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 70, 
					 'image_name' => $this->img_name_ext($images['icon_edit'], false, false, $type = 'name'), 
					 'image_filename' => $this->img_name_ext($images['icon_edit'], false, false, $type = 'filename'),  
					 'image_lang' => '{LANG}', 
					 'image_height' => 20, 
					 'image_width' => 42 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 71, 
					 'image_name' => $this->img_name_ext($images['icon_quote'], false, false, $type = 'name'), 
					 'image_filename' => $this->img_name_ext($images['icon_quote'], false, false, $type = 'filename'), 
					 'image_lang' => '{LANG}', 
					 'image_height' => 20, 
					 'image_width' => 54 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 72, 
					 'image_name' => 'icon_user_online', 
					 'image_filename' => 'icon_user_online.gif', 
					 'image_lang' => '{LANG}', 
					 'image_height' => 58, 
					 'image_width' => 58 , 
					 'imageset_id' => 1 
					 ),
			array( 'image_id' => 73, 
					 'image_name' => 'button_pm_forward', 
					 'image_filename' => 'button_pm_forward.gif', 
					 'image_lang' => '{LANG}', 
					 'image_height' => 25, 
					 'image_width' => 96 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 74, 
					 'image_name' => 'button_pm_new', 
					 'image_filename' => 'button_pm_new.gif', 
					 'image_lang' => '{LANG}', 
					 'image_height' => 25, 
					 'image_width' => 84 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 75, 
					 'image_name' => 'button_pm_reply', 
					 'image_filename' => 'button_pm_reply.gif', 
					 'image_lang' => '{LANG}', 
					 'image_height' => 25, 
					 'image_width' => 96 , 
					 'imageset_id' => 1 
					), 
			array( 'image_id' => 76, 
					 'image_name' => $this->img_name_ext($images['post_locked'], false, false, $type = 'name'), 
					 'image_filename' => $this->img_name_ext($images['post_locked'], false, false, $type = 'filename'), 
					 'image_lang' => '{LANG}', 
					 'image_height' => 25, 
					 'image_width' => 88 , 
					 'imageset_id' => 1 
					), 
			array( 'image_id' => 77, 
					 'image_name' => $this->img_name_ext($images['post_new'], false, false, $type = 'name'), 
					 'image_filename' => $this->img_name_ext($images['post_new'], false, false, $type = 'filename'), 
					 'image_lang' => '{LANG}', 
					 'image_height' => 25, 
					 'image_width' => 96 , 
					 'imageset_id' => 1 
					), 
			array( 'image_id' => 78, 
					 'image_name' => $this->img_name_ext($images['reply_new'], false, false, $type = 'name'), 
					 'image_filename' => $this->img_name_ext($images['reply_new'], false, false, $type = 'filename'), 
					 'image_lang' => '{LANG}', 
					 'image_height' => 25, 
					 'image_width' => 96 , 
					 'imageset_id' => 1
				)	
			);
		return $rows;
	}	
	
	/**
	* Specify/Get image name , extension
	*/
	function img_name_ext($img, $prefix = '', $new_prefix = '', $type = 'filename')
	{	
		if (strpos($img, '.') !== false)
		{
			// Nested img
			$image_filename = $img;
			$img_ext = substr(strrchr($image_filename, '.'), 1);
			$img = basename($image_filename, '.' . $img_ext);
			
			unset($img_name, $image_filename);
		}
		else
		{
			$img_ext = 'gif';
		}		
		
		switch ($type)
		{
			case 'filename':
				return $img . '.' . $img_ext;
			break;
			
			case 'class':
				return $prefix . '_' . $img;
			break;
			
			case 'name':		
				return $img;
			break;
			
			case 'ext':
				return $img_ext;
			break;
		}		
	}	
	
	/**
	* Specify/Get images
	*/
	function images($img, $alt = '', $width = false, $suffix = '', $type = 'src')
	{
		static $imgs;
		global $phpbb_root_path, $mx_root_path;

		$img_data = &$imgs[$img];

		if (empty($img_data))
		{
			if (!isset($this->img_array[$img]))
			{
				// Do not fill the image to let designers decide what to do if the image is empty
				$img_data = '';
				return $img_data;
			}
			
			$img_data['src'] = PHPBB_URL . 'styles/' . rawurlencode($this->theme['template_name'] ? $this->theme['template_name'] : str_replace('.css', '', $this->theme['head_stylesheet'])) . '/imageset/' . ($this->img_array[$img]['image_lang'] ? $this->img_array[$img]['image_lang'] .'/' : '') . $this->img_array[$img]['image_filename'];
			//$img_data['src'] = PHPBB_URL . 'styles/' . $this->theme['imageset_path'] . '/imageset/' . ($this->img_array[$img]['image_lang'] ? $this->img_array[$img]['image_lang'] .'/' : '') . $this->img_array[$img]['image_filename'];
			$img_data['width'] = isset($this->img_array[$img]['image_width']) ? $this->img_array[$img]['image_width'] : $width;
			$img_data['height'] = isset($this->img_array[$img]['image_height']) ? $this->img_array[$img]['image_width'] : $width;
		}

		$alt = (!empty($this->lang[$alt])) ? $this->lang[$alt] : $alt;

		switch ($type)
		{
			case 'full_tag':
				$use_width = ($width === false) ? $img_data['width'] : $width;

				return '<img src="' . $img_data['src'] . '"' . (($use_width) ? ' width="' . $use_width . '"' : '') . (($img_data['height']) ? ' height="' . $img_data['height'] . '"' : '') . ' alt="' . $alt . '" title="' . $alt . '" />';
			break;

			case 'width':
				return ($width === false) ? $img_data['width'] : $width;
			break;

			case 'height':
				return $img_data['height'];
			break;

			default:
				return $img_data['src'];
			break;

		}
	}
	
	/**
	* Specify/Get image
	//
	// phpBB2 Graphics - redefined for mxBB
	// - Uncomment and redefine phpBB graphics
	//
	// If you need to redefine some phpBB graphics, look within the phpBB/templates folder for the template_name.cfg file and
	// redefine those $image['xxx'] you want. Note: Many phpBB images are reused all over mxBB (eg see below), thus if you redefine
	// common phpBB images, this will have immedaite effect for all mxBB pages.
	//
	*/
	function img($img, $alt = '', $width = false, $suffix = '', $type = '')
	{
		static $imgs;
		global $phpbb_root_path, $mx_root_path, $theme, $board_config;
		global $mx_block;
		
		//
		// Look at MX-Publisher-Module folder.........................................................................MX-Publisher-module
		//
		if (isset($mx_block->module_root_path))
		{
			$this->module_root_path = $this->ext_path = $mx_block->module_root_path;
		}
		else
		{
			global $module_root_path; 
			
			if (isset($module_root_path))
			{
				$this->module_root_path = $this->ext_path = $module_root_path;
			}
			else
			{
				global $mx_root_path;
				$this->module_root_path = $this->ext_path = $mx_root_path . 'modules/mx_coreblocks/';
			}
		}
		
		$title = '';
		$img_ext = 'gif'; 
		if ($alt)
		{
			$alt = $this->lang($alt);
			$title = ' title="' . $alt . '"';
		}
		
		if (strpos($img, '.') !== false)
		{
			// Nested img
			$image_filename = $img;
			$img_ext = substr(strrchr($image_filename, '.'), 1);
			$img = basename($image_filename, '.' . $img_ext);
			$this->img_array['image_filename'] = array(
				''.$img => $img . '.' . $img_ext,
			);			
			unset($img_name, $image_filename);
		}
		
		if ($width !== false)
		{
			$this->img_array['image_width'] = array(
				''.$img => $width,
			);
		}
		
		// Load phpBB Template configuration data
		$current_template_path = $this->current_template_path;
		$template_name = $this->template_name;
		
		//Replace $this->template_path with $this->style_path
		$current_template_path = $this->style_path . $this->template_name;
		$default_template_path = $this->style_path . $this->default_template_name;
		$this->current_style_phpbb_path = $this->style_path . $this->template_name;	//new
		$this->default_style_phpbb_path = $this->style_path . $this->default_style_name; //new
		
		/* Here we overwrite phpBB images from the template configuration file with images from database  */
		if (!is_array($this->img_array))
		{
			$this->img_array['image_filename'] = array(
				'site_logo' => "logo.gif",
				'upload_bar' => "upload_bar.gif",
				'icon_contact_aim' => "icon_aim.gif",
				'icon_contact_email' => "icon_email.gif",
				'icon_contact_icq' => "icon_icq_add.gif",
				'icon_contact_jabber' => "icon_jabber.gif",
				'icon_contact_msnm' => "icon_msnm.gif",
				'icon_contact_pm' => "icon_pm.gif",
				'icon_contact_yahoo' => "icon_yim.gif",
				'icon_contact_www' => "icon_www.gif",
				'icon_post_delete' => "icon_delete.gif",
				'icon_post_edit' => "icon_edit.gif",
				'icon_post_info' => "icon_info.gif",
				'icon_post_quote' => "icon_quote.gif",
				'icon_post_report' => "icon_report.gif",
				'icon_user_online' => "icon_online.gif",
				'icon_user_offline' => "icon_offline.gif",
				'icon_user_profile' => "icon_profile.gif",
				'icon_user_search' => "icon_search.gif",
				'icon_user_warn' => "icon_warn.gif",
				'button_pm_forward' => "reply.gif",
				'button_pm_new' => "msg_newpost.gif",
				'button_pm_reply' => "reply.gif",
				'button_topic_locked' => "msg_newpost.gif",
				'button_topic_new' => "post.gif",
				'button_topic_reply' => "reply.gif",
				'forum_link' => "forum_link.gif",
				'forum_read' => "forum_read.gif",
				'forum_read_locked' => "forum_read_locked.gif",
				'forum_read_subforum' => "forum_read_subforum.gif",
				'forum_unread' => "forum_unread.gif",
				'forum_unread_locked' => "forum_unread_locked.gif",
				'forum_unread_subforum' => "forum_unread_subforum.gif",
				'topic_moved' => "topic_moved.gif",
				'topic_read' => "topic_read.gif",
				'topic_read_mine' => "topic_read_mine.gif",
				'topic_read_hot' => "topic_read_hot.gif",
				'topic_read_hot_mine' => "topic_read_hot_mine.gif",
				'topic_read_locked' => "topic_read_locked.gif",
				'topic_read_locked_mine' => "topic_read_locked_mine.gif",
				'topic_unread' => "topic_unread.gif",
				'topic_unread_mine' => "topic_unread_mine.gif",
				'topic_unread_hot' => "topic_unread_hot.gif",
				'topic_unread_hot_mine' => "topic_unread_hot_mine.gif",
				'topic_unread_locked' => "topic_unread_locked.gif",
				'topic_unread_locked_mine' => "topic_unread_locked_mine.gif",
				'sticky_read' => "sticky_read.gif",
				'sticky_read_mine' => "sticky_read_mine.gif",
				'sticky_read_locked' => "sticky_read_locked.gif",
				'sticky_read_locked_mine' => "ticky_read_locked_mine.gif",
				'sticky_unread' => "sticky_unread.gif",
				'sticky_unread_mine' => "sticky_unread_mine.gif",
				'sticky_unread_locked' => "sticky_unread_locked.gif",
				'sticky_unread_locked_mine' => "sticky_unread_locked_mine.gif",
				'announce_read' => "announce_read.gif",
				'announce_read_mine' => "announce_read_mine.gif",
				'announce_read_locked' => "announce_read_locked.gif",
				'announce_read_locked_mine' => "announce_read_locked_mine.gif",
				'announce_unread' => "announce_unread.gif",
				'announce_unread_mine' => "announce_unread_mine.gif",
				'announce_unread_locked' => "announce_unread_locked.gif",
				'announce_unread_locked_mine' => "announce_unread_locked_mine.gif",
				'global_read' => "announce_read.gif",
				'global_read_mine' => "announce_read_mine.gif",
				'global_read_locked' => "announce_read_locked.gif",
				'global_read_locked_mine' => "announce_read_locked_mine.gif",
				'global_unread' => "announce_unread.gif",
				'global_unread_mine' => "announce_unread_mine.gif",
				'global_unread_locked' => "announce_unread_locked.gif",
				'global_unread_locked_mine' => "announce_unread_locked_mine.gif",
				'subforum_read' => "", 
				'subforum_unread' => "",
				'pm_read' => "topic_read.gif",
				'pm_unread' => "topic_unread.gif",
				'icon_back_top' => "",
				'icon_post_target' => "icon_post_target.gif",
				'icon_post_target_unread' => "icon_post_target_unread.gif",
				'icon_topic_attach' => "icon_topic_attach.gif",
				'icon_topic_latest' => "icon_topic_latest.gif",
				'icon_topic_newest' => "icon_topic_newest.gif",
				'icon_topic_reported' => "icon_topic_reported.gif",
				'icon_topic_unapproved' => "icon_topic_unapproved.gif"
			);
		}
		
		$this->img_array['image_lang'] = array(
			'icon_post_edit' => $this->img_lang,
			'icon_post_quote' => $this->img_lang,
			'button_pm_forward' => $this->img_lang,
			'button_pm_new' => $this->img_lang,
			'button_pm_reply' => $this->img_lang,
			'button_topic_new' => $this->img_lang,
			'button_topic_reply' => $this->img_lang
		);
		
		//Setup current style path for phpBB3 styles
		$img_data = &$imgs[$img];
		$current_template_path = $this->current_template_path;
		$template_name = $this->template_name;
		
		//Setup cloned style as prosilver based for phpBB3 styles
		if ( @file_exists(@mx_realpath($phpbb_root_path . $this->style_path . $this->template_name . '/style.cfg')) )
		{
			$cfg = mx_parse_cfg_file($phpbb_root_path . $this->style_path . $this->template_name . '/style.cfg');
			$this->cloned_template_name = !empty($cfg['parent']) ? $cfg['parent'] : 'prosilver';
			$this->cloned_template_path = $this->template_path . $this->cloned_template_name;
			$this->cloned_style_phpbb_path = $cloned_template_path = $this->style_path . $this->cloned_template_name;
			//$this->default_template_name = !empty($cfg['parent']) ? $cfg['parent'] : 'prosilver';
		}
		
		//
		// - First try phpBB3 template
		//
		if ( file_exists($phpbb_root_path . $this->style_path . $this->template_name  . '/theme/stylesheet.css') )
		{
			@define('TEMPLATE_CONFIG', true);
			$current_template_images = $phpbb_root_path . $this->style_path . $this->template_name . "/theme/images";
		}
		
		
		//
		// Load phpBB Template configuration data
		// - First try current template
		//
		if ( is_dir( $phpbb_root_path . $this->current_template_path . "/" ) )
		{
			$current_template_path = $this->current_template_path;
			$template_name = $this->template_name;
		}

		//
		// Since we have no current Template Config file, try the cloned template instead
		//
		if ( is_dir( $phpbb_root_path . $this->cloned_current_template_path . "/" ) && !defined('TEMPLATE_CONFIG') )
		{
			$current_template_path = $this->cloned_current_template_path;
			$template_name = $this->cloned_template_name;
		}

		//
		// Last attempt, use default template intead
		//
		if ( is_dir( $phpbb_root_path . $this->default_current_template_path . "/" ) && !defined('TEMPLATE_CONFIG') )
		{
			$current_template_path = $this->default_current_template_path;
			$template_name = $this->default_template_name;
		}

		$this->img_lang = (file_exists($phpbb_root_path . $current_template_path . $this->lang_name)) ? $this->lang_name : $board_config['default_lang'];		
		
		$img_data = &$imgs[$img];
		
		
		//
		// - First try phpBB3 template lang images then old Olympus image sets
		// default language
		if ( file_exists($phpbb_root_path . $current_template_path . '/theme/' . $this->default_language . '/') )
		{
			$this->img_lang = $this->default_language;
		}
		else if ( file_exists($phpbb_root_path . $this->cloned_template_path  . '/theme/' . $this->default_language . '/') )
		{
			$this->img_lang = $this->default_language;
		}
		else if ( file_exists($phpbb_root_path . $this->default_template_name  . '/theme/' . $this->default_language . '/') )
		{
			$this->img_lang = $this->default_language;
		}
		
		if (empty($this->img_array))
		{
			/** 
				* Now check for the correct existance of all of the images into
				* each image of a prosilver based style. 
				foreach ($rows as $row)
				{
					$row['image_filename'] = rawurlencode($row['image_filename']);
					$this->img_array[$row['image_name']] = $row;				
				}
			*/
			trigger_error('NO_STYLE_DATA', E_USER_ERROR);
		}
		
		$img_data = &$this->img_array['image_filename'][$img];
		
		if (empty($img_data))
		{
			if (!isset($this->img_array['image_filename'][''.$img]) && !isset($this->img_array['image_filename'][$img]))
			{
				// Do not fill the image to let designers decide what to do if the image is empty
				$img_data = '';
				return $img_data;
			}
			
			//
			// - First try phpBB3 template theme images then template lang images
			//
			if (isset($this->img_array['image_lang'][''.$img]))
			{
				if ( file_exists($phpbb_root_path . $this->style_path . $this->template_name . '/theme/' . $this->img_array['image_lang'][''.$img] . '/'. (!empty($this->img_array['image_filename'][''.$img]) ? $this->img_array['image_filename'][''.$img] : $img . '.' . $img_ext)) )
				{
					$current_template_images = $this->style_path . $this->template_name . '/theme/' . $this->img_array['image_lang'][''.$img];
				}
				else if ( file_exists($phpbb_root_path . $this->style_path . $this->template_name  . '/imageset/' . $this->img_array['image_lang'][''.$img] . '/'. (!empty($this->img_array['image_filename'][''.$img]) ? $this->img_array['image_filename'][''.$img] : $img . '.' . $img_ext)) )
				{
					$current_template_images = $this->style_path . $this->template_name . '/imageset/' . $this->img_array['image_lang'][''.$img];
				}
			}
			
			if ( file_exists($phpbb_root_path . $this->style_path . $this->template_name  . '/imageset/' . (!empty($this->img_array['image_filename'][''.$img]) ? $this->img_array['image_filename'][''.$img] : $img . '.' . $img_ext)) )
			{
				$current_template_images = $this->style_path . $this->template_name  . '/imageset/';
			}
			elseif ( file_exists($phpbb_root_path . $this->style_path . $this->template_name  . '/imageset/' . $this->encode_lang($this->lang_name) . '/'. (!empty($this->img_array['image_filename'][''.$img]) ? $this->img_array['image_filename'][''.$img] : $img . '.' . $img_ext)) )
			{
				$current_template_images = $this->style_path . $this->template_name  . '/imageset/' . $this->encode_lang($this->lang_name);
			}
			else if ( file_exists($phpbb_root_path . $this->style_path . $this->template_name  . '/theme/images/' . (!empty($this->img_array['image_filename'][''.$img]) ? $this->img_array['image_filename'][''.$img] : $img . '.' . $img_ext)) )
			{
				$current_template_images = $this->style_path . $this->template_name  . '/theme/images/';
			}
			else if ( file_exists($phpbb_root_path . $this->style_path . $this->template_name  . '/theme/' . $this->encode_lang($this->lang_name) . '/'. (!empty($this->img_array['image_filename'][''.$img]) ? $this->img_array['image_filename'][''.$img] : $img . '.' . $img_ext)) )
			{
				$current_template_images = $this->style_path . $this->template_name  . '/theme/' . $this->encode_lang($this->lang_name);
			}
			
			$img_data['src'] = PHPBB_URL . $current_template_images  . '/' . (!empty($this->img_array['image_filename'][''.$img]) ? $this->img_array['image_filename'][''.$img] : $img . '.' . $img_ext);
			$img_data['width'] = !empty($width) ? $width : (!empty($this->img_array['image_width']) ? (!empty($this->img_array['image_width'][''.$img]) ? $this->img_array['image_width'][''.$img] : (!empty($this->img_array['image_width'][$img]) ? $this->img_array['image_width'][$img] : 47)) : 47);
			$img_data['height'] = !empty($width) ? $width : (!empty($this->img_array['image_height']) ? (!empty($this->img_array['image_width'][''.$img]) ? $this->img_array['image_height'][''.$img] : (!empty($this->img_array['image_height'][$img]) ? $this->img_array['image_height'][$img] : 47)) : 47);
		}
		
		$alt = (!empty($this->lang[$alt])) ? $this->lang[$alt] : $alt;
		
		$use_width = ($width === false) ? $img_data['width'] : $width;
		
		switch ($type)
		{
			case 'src':
				return $img_data['src'];
			break;

			case 'width':
				return $use_width;
			break;

			case 'height':
				return $img_data['height'];
			break;
			
			case 'filename':
				return $img . '.' . $img_ext;
			break;
			
			case 'class':
			case 'name':
				return $img;
			break;
			
			case 'alt':
				return $alt;
			break;
			
			case 'ext':
				return $img_ext;
			break;
			
			case 'full_tag':
				return '<img src="' . $img_data['src'] . '"' . (($use_width) ? ' width="' . $use_width . '"' : '') . (($img_data['height']) ? ' height="' . $img_data['height'] . '"' : '') . ' alt="' . $alt . '" title="' . $alt . '" />';
			break;
			
			case 'html':	
			default:
				return '<span class="imageset ' . $img . '"' . $title . '>' . $alt . '</span>';
			break;
		}
	}

	/**
	* Specify/Get image
	//
	// phpBB2 Graphics - redefined for mxBB
	// - Uncomment and redefine phpBB graphics
	//
	// If you need to redefine some phpBB graphics, look within the phpBB/templates folder for the template_name.cfg file and
	// redefine those $image['xxx'] you want. Note: Many phpBB images are reused all over mxBB (eg see below), thus if you redefine
	// common phpBB images, this will have immedaite effect for all mxBB pages.
	//
	*/
	function mx_img($img, $alt = '', $width = false, $suffix = '', $type = 'full_tag')
	{
		static $imgs;
		global $phpbb_root_path, $mx_root_path, $mx_images, $board_config;
		
		$template_name = $this->template_name;
		
		//Replace $this->template_path with $this->style_path
		$current_template_path = $this->style_path . $this->template_name;
		$default_template_path = $this->style_path . $this->default_template_name;
		$this->current_style_phpbb_path = $this->style_path . $this->template_name;	//new
		$this->default_style_phpbb_path = $this->style_path . $this->default_style_name; //new
		
		//
		// Load phpBB Template configuration data
		// - First try current template
		//
		if ( is_dir( $phpbb_root_path . $this->current_template_path . "/" ) )
		{
			$current_template_path = $this->current_template_path;
			$template_name = $this->template_name;

			@include($phpbb_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg');
		}

		//
		// Since we have no current Template Config file, try the cloned template instead
		//
		if ( is_dir( $phpbb_root_path . $this->cloned_current_template_path . "/" ) && !defined('TEMPLATE_CONFIG') )
		{
			$current_template_path = $this->cloned_current_template_path;
			$template_name = $this->cloned_template_name;

			@include($phpbb_root_path . $this->cloned_current_template_path . '/' . $this->cloned_template_name . '.cfg');
		}

		//
		// Last attempt, use default template intead
		//
		if ( is_dir( $phpbb_root_path . $this->default_current_template_path . "/" ) && !defined('TEMPLATE_CONFIG') )
		{
			$current_template_path = $this->default_current_template_path;
			$template_name = $this->default_template_name;

			@include($phpbb_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg');
		}

		$this->img_lang = (file_exists($phpbb_root_path . $current_template_path . $this->lang_name)) ? $this->lang_name : $board_config['default_lang'];		

		/* Here we overwrite phpBB images from the template configuration file with images from database  */
		if (!is_array($this->img_array))
		{
			$this->img_array['image_filename'] = array(
				'site_logo' => "logo.gif",
				'upload_bar' => "upload_bar.gif",
				'icon_contact_aim' => "icon_aim.gif",
				'icon_contact_email' => "icon_email.gif",
				'icon_contact_icq' => "icon_icq_add.gif",
				'icon_contact_jabber' => "icon_jabber.gif",
				'icon_contact_msnm' => "icon_msnm.gif",
				'icon_contact_pm' => "icon_pm.gif",
				'icon_contact_yahoo' => "icon_yim.gif",
				'icon_contact_www' => "icon_www.gif",
				'icon_post_delete' => "icon_delete.gif",
				'icon_post_edit' => "icon_edit.gif",
				'icon_post_info' => "icon_info.gif",
				'icon_post_quote' => "icon_quote.gif",
				'icon_post_report' => "icon_report.gif",
				'icon_user_online' => "icon_online.gif",
				'icon_user_offline' => "icon_offline.gif",
				'icon_user_profile' => "icon_profile.gif",
				'icon_user_search' => "icon_search.gif",
				'icon_user_warn' => "icon_warn.gif",
				'button_pm_forward' => "reply.gif",
				'button_pm_new' => "msg_newpost.gif",
				'button_pm_reply' => "reply.gif",
				'button_topic_locked' => "msg_newpost.gif",
				'button_topic_new' => "post.gif",
				'button_topic_reply' => "reply.gif",
				'forum_link' => "forum_link.gif",
				'forum_read' => "forum_read.gif",
				'forum_read_locked' => "forum_read_locked.gif",
				'forum_read_subforum' => "forum_read_subforum.gif",
				'forum_unread' => "forum_unread.gif",
				'forum_unread_locked' => "forum_unread_locked.gif",
				'forum_unread_subforum' => "forum_unread_subforum.gif",
				'topic_moved' => "topic_moved.gif",
				'topic_read' => "topic_read.gif",
				'topic_read_mine' => "topic_read_mine.gif",
				'topic_read_hot' => "topic_read_hot.gif",
				'topic_read_hot_mine' => "topic_read_hot_mine.gif",
				'topic_read_locked' => "topic_read_locked.gif",
				'topic_read_locked_mine' => "topic_read_locked_mine.gif",
				'topic_unread' => "topic_unread.gif",
				'topic_unread_mine' => "topic_unread_mine.gif",
				'topic_unread_hot' => "topic_unread_hot.gif",
				'topic_unread_hot_mine' => "topic_unread_hot_mine.gif",
				'topic_unread_locked' => "topic_unread_locked.gif",
				'topic_unread_locked_mine' => "topic_unread_locked_mine.gif",
				'sticky_read' => "sticky_read.gif",
				'sticky_read_mine' => "sticky_read_mine.gif",
				'sticky_read_locked' => "sticky_read_locked.gif",
				'sticky_read_locked_mine' => "ticky_read_locked_mine.gif",
				'sticky_unread' => "sticky_unread.gif",
				'sticky_unread_mine' => "sticky_unread_mine.gif",
				'sticky_unread_locked' => "sticky_unread_locked.gif",
				'sticky_unread_locked_mine' => "sticky_unread_locked_mine.gif",
				'announce_read' => "announce_read.gif",
				'announce_read_mine' => "announce_read_mine.gif",
				'announce_read_locked' => "announce_read_locked.gif",
				'announce_read_locked_mine' => "announce_read_locked_mine.gif",
				'announce_unread' => "announce_unread.gif",
				'announce_unread_mine' => "announce_unread_mine.gif",
				'announce_unread_locked' => "announce_unread_locked.gif",
				'announce_unread_locked_mine' => "announce_unread_locked_mine.gif",
				'global_read' => "announce_read.gif",
				'global_read_mine' => "announce_read_mine.gif",
				'global_read_locked' => "announce_read_locked.gif",
				'global_read_locked_mine' => "announce_read_locked_mine.gif",
				'global_unread' => "announce_unread.gif",
				'global_unread_mine' => "announce_unread_mine.gif",
				'global_unread_locked' => "announce_unread_locked.gif",
				'global_unread_locked_mine' => "announce_unread_locked_mine.gif",
				'subforum_read' => "", 
				'subforum_unread' => "",
				'pm_read' => "topic_read.gif",
				'pm_unread' => "topic_unread.gif",
				'icon_back_top' => "",
				'icon_post_target' => "icon_post_target.gif",
				'icon_post_target_unread' => "icon_post_target_unread.gif",
				'icon_topic_attach' => "icon_topic_attach.gif",
				'icon_topic_latest' => "icon_topic_latest.gif",
				'icon_topic_newest' => "icon_topic_newest.gif",
				'icon_topic_reported' => "icon_topic_reported.gif",
				'icon_topic_unapproved' => "icon_topic_unapproved.gif"
			);
		}
		$this->img_array['image_lang'] = array(
			'icon_post_edit' => $this->img_lang,
			'icon_post_quote' => $this->img_lang,
			'button_pm_forward' => $this->img_lang,
			'button_pm_new' => $this->img_lang,
			'button_pm_reply' => $this->img_lang,
			'button_topic_new' => $this->img_lang,
			'button_topic_reply' => $this->img_lang
		);
		
		$img_data = &$imgs[$img];

		if (empty($img_data))
		{
			if (!isset($this->img_array[$img]))
			{
				// Do not fill the image to let designers decide what to do if the image is empty
				$img_data = '';
				return $img_data;
			}
			if (!isset($this->img_array['image_filename'][''.$img]) && !isset($this->img_array['image_filename'][$img]))
			{
				// Do not fill the image to let designers decide what to do if the image is empty
				$img_data = '';
				return $img_data;
			}
			
			if (isset($this->img_array['image_lang'][''.$img]) && isset($this->img_array['image_lang'][$img]))
			{
				//		
				// - First try phpBB2 then phpBB3 template lang images
				//		
				if ( file_exists($phpbb_root_path . $current_template_path . '/images/' . $this->img_array['image_lang'][''.$img] . '/') )
				{
					$current_template_images = $current_template_path . '/images/' . $this->img_array['image_lang'][''.$img];
				}		
				else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/images/' . $this->img_array['image_lang'][''.$img] . '/') )
				{		
					$current_template_images = $current_template_path . '/theme/images/' . $this->img_array['image_lang'][''.$img];
				}
				else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/images/' . $this->encode_lang($this->lang_name) . '/') )
				{		
					$current_template_images = $current_template_path  . '/theme/images/' . $this->encode_lang($this->lang_name);
				}
				else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/imageset/' . $this->encode_lang($this->lang_name) . '/') )
				{		
					$current_template_images = $current_template_path  . '/theme/imageset/' . $this->encode_lang($this->lang_name);
				}				
			}
			
			$img_data['src'] = PHPBB_URL . $current_template_images  . '/' . (!empty($this->img_array['image_filename'][''.$img]) ? $this->img_array['image_filename'][''.$img] : $this->img_array['image_filename'][$img]);
			//$img_data['src'] = PHPBB_URL . $current_template_path . ($this->img_array[$img]['image_lang'] ? $this->img_array[$img]['image_lang'] .'/' : '') . $this->img_array[$img]['image_filename'];
			$img_data['width'] = (!empty($width)) ? $width : ''; //$this->img_array[$img]['image_width'];
			$img_data['height'] = (!empty($height)) ? $height : ''; //$this->img_array[$img]['image_height'];
		}

		$alt = (!empty($this->lang[$alt])) ? $this->lang[$alt] : $alt;

		switch ($type)
		{
			case 'src':
				return $img_data['src'];
			break;

			case 'width':
				return ($width === false) ? $img_data['width'] : $width;
			break;

			case 'height':
				return $img_data['height'];
			break;

			default:
				$use_width = ($width === false) ? $img_data['width'] : $width;

				return '<img src="' . $img_data['src'] . '"' . (($use_width) ? ' width="' . $use_width . '"' : '') . (($img_data['height']) ? ' height="' . $img_data['height'] . '"' : '') . ' alt="' . $alt . '" title="' . $alt . '" />';
			break;
		}
	}

	/**
	* Get option bit field from user options
	*/
	function optionget($key, $data = false)
	{
		if (!isset($this->keyvalues[$key]))
		{
			$var = ($data) ? $data : $this->data['user_options'];
			$this->keyvalues[$key] = ($var & 1 << $this->keyoptions[$key]) ? true : false;
		}

		return $this->keyvalues[$key];
	}

	/**
	* Set option bit field for user options
	*/
	function optionset($key, $value, $data = false)
	{
		$var = ($data) ? $data : $this->data['user_options'];

		if ($value && !($var & 1 << $this->keyoptions[$key]))
		{
			$var += 1 << $this->keyoptions[$key];
		}
		else if (!$value && ($var & 1 << $this->keyoptions[$key]))
		{
			$var -= 1 << $this->keyoptions[$key];
		}
		else
		{
			return ($data) ? $var : false;
		}

		if (!$data)
		{
			$this->data['user_options'] = $var;
			return true;
		}
		else
		{
			return $var;
		}
	}

	/**
	* Funtion to make the user leave the NEWLY_REGISTERED system group.
	* @access public
	*/
	function leave_newly_registered()
	{
		global $db;

		if (empty($this->data['user_new']))
		{
			return false;
		}

		if (!function_exists('remove_newly_registered'))
		{
			global $phpbb_root_path, $phpEx;

			include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
		}
		if ($group = remove_newly_registered($this->data['user_id'], $this->data))
		{
			$this->data['group_id'] = $group;

		}
		$this->data['user_permissions'] = '';
		$this->data['user_new'] = 0;

		return true;
	}

	/**
	 * encode_lang
	 *
	 * $default_lang = $mx_user->encode_lang($board_config['default_lang']);
	 *
	 * @param unknown_type $lang
	 * @return unknown
	 */
	function encode_lang($lang)
	{
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
				case 'guaranĂ­':
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
					$lang_name = $lang;
					break;
			}
		return $lang_name;
	}

	/**
	 * decode_lang
	 *
	 * $default_lang = $mx_user->decode_lang($board_config['default_lang']);
	 * @used in URL Language Detection i.e. $this->decode_lang($_GET['lang'])
	 * @param iso_type $lang
	 * @return standard_type $lang 
	 */
	function decode_lang($lang)
	{
		switch($lang)
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
					$lang_name = 'guaranĂ­';
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
					$lang_name = $lang;
				break;
		}
		return $lang_name;
	}
	
	/**
	 * ucstrreplace
	 *
	 * $lang_local_name = $user->ucstrreplace($board_config['default_lang']);
	 *
	 * @param unknown_type $lang
	 * @return unknown
	 */
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
				case '{LANG}':
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
					$lang_name = 'guaranĂ­';
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
}
?>