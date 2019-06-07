<?php
/**
*
* @package Style
* @version $Id: session.php,v 1.18 2014/05/09 07:52:03 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team & (C) 2001 The phpBB Group
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
	
	//var  $phpbb_root_path;	
	/**#@-*/
	
	/**
	 * Load sessions
	 * @access public
	 *
	 */
	function session()
	{
		global $mx_cache, $board_config, $db, $phpbb_root_path, $mx_root_path, $phpEx;
		global $mx_request_vars, $template, $language;
		
		$this->cache				= $mx_cache;
		$this->config				= $board_config;
		$this->db                 	= $db;
		$this->user               	= $this;
		$this->service_providers = array('user_id' => 1, 'session_id' => 0, 'provider'	=> '', 'oauth_token' => '');
		$this->phpbb_root_path = $phpbb_root_path;
		$this->mx_root_path	= $mx_root_path;
		$this->php_ext			= $phpEx;
		$this->lang_path			= $mx_root_path . 'language/';
		$this->request				= $mx_request_vars;
		$this->template			= $template;
		$this->language			= $language;

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
	
        $this->crawlers = new Crawlers();
        $this->exclusions = new Exclusions();
        $this->uaHttpHeaders = new Headers();

        $this->compiledRegex = $this->compileRegex($this->crawlers->getAll());
        $this->compiledExclusions = $this->compileRegex($this->exclusions->getAll());

        $this->setHttpHeaders($headers);
        $this->userAgent = $this->setUserAgent($userAgent);
		
		$this->lang_path = $phpbb_root_path . 'language/';
		$this->load();
		$this->setup();
	}
	// ------------------------------
	// Private Methods
	//
	
	/**
	 * Load sessions
	 * @access public
	 *
	 */
	function load()
	{
		global $mx_cache, $board_config, $db, $phpbb_root_path, $mx_root_path, $phpEx;
		global $mx_request_vars, $template, $language;
		
		$this->cache				= $mx_cache;
		$this->config				= $board_config;
		$this->db                 	= $db;
		$this->user               	= $this;
		$this->service_providers = array('user_id' => 1, 'session_id' => 0, 'provider'	=> '', 'oauth_token' => '');
		$this->phpbb_root_path = $phpbb_root_path;
		$this->mx_root_path	= $mx_root_path;
		$this->php_ext			= $phpEx;
		$this->lang_path			= $mx_root_path . 'language/';
		$this->request				= $mx_request_vars;
		$this->template			= $template;
		$this->language			= $language;
		
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
		$this->data = $this->session_pagestart($this->user_ip, - ( MX_PORTAL_PAGES_OFFSET + $this->page_id ));
		

		//
		// Populate session_id
		$this->session_id = $this->data['session_id'];
			
		if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) 
		{
		    $this->data['is_bot'] = true;
		}
		else
		{
		    $this->data['is_bot'] = false;
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
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_agent', array('column_type_sql_default'	=> 'varchar(255)', 'column_type_sql' => 'varchar(99)', 'null' => 'NOT NULL', 'default' => '"Mozilla/5.0 (Windows NT 10.0; rv:63.0) Gecko/20100101 Firefox/63.0.68"', 'after' => 'user_sig'), false);
		}
		
		if (!$this->db->sql_field_exists('user_form_salt', USERS_TABLE))
		{
			print('<p><span style="color: red;">user_form_salt</span></p><i><p>Refreshing the users table!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'user_form_salt', array('column_type_sql' => 'varchar(32)', 'null' => 'NOT NULL', 'default' => '""'), false);
		}
		
		//
		// Check USERS_TABLE schema for is_bot
		//
		if (!$this->db->sql_field_exists('is_bot', USERS_TABLE))
		{
			print('<p><span style="color: red;">is_bot</span></p><i><p>Cheching for is_bot column in USERS_TABLE schema!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'is_bot', array('column_type_sql'	=> 'int(2)', 'null' => 'NOT NULL', 'default' => '0'), false);
		}
		
		//
		// Check USERS_TABLE schema for is_mobile
		//
		if (!$this->db->sql_field_exists('is_mobile', USERS_TABLE))
		{
			print('<p><span style="color: red;">is_mobile</span></p><i><p>Cheching for is_mobile column in USERS_TABLE schema!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'is_mobile', array('column_type_sql'	=> 'int(2)', 'null' => 'NOT NULL', 'default' => '0', 'after' => 'is_bot'), false);
		}
		
		//
		// Check USERS_TABLE schema for device_name
		//
		if (!$this->db->sql_field_exists('device_name', USERS_TABLE))
		{
			print('<p><span style="color: red;">device_name</span></p><i><p>Cheching for device_name column in USERS_TABLE schema!</p></i>');
			$this->db_tools->sql_column_add(USERS_TABLE, 'device_name', array('column_type_sql' => 'varchar(99)', 'null' => 'NOT NULL', 'default' => $status[1],  'after' => 'user_agent'), false);
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
		
		$this->data['is_mobile'] = $status;
		$this->data['device_name'] = $this->cookie_data['mobile_name'] = $status[1];
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
				'GUESTS'						=> array('', 0, 0, 0, 'Default Group'),
				'REGISTERED'					=> array('', 0, 0, 0, 'Default Group'),
				'REGISTERED_COPPA'		=> array('', 0, 0, 0, 'Default Group'),
				'GLOBAL_MODERATORS'	=> array('00AA00', 2, 0, 0, 'Default Group'),
				'ADMINISTRATORS'			=> array('AA0000', 1, 1, 0, 'Default Group'),
				'BOTS'							=> array('9E8DA7', 0, 0, 0, 'Default Group'),
				'NEWLY_REGISTERED'		=> array('', 0, 0, 0, 'Default Group'),
			);
			
			/*
			-- Refreshing Groups
			*/
			$sql = 'SELECT *
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
					'group_type'					=> GROUP_CLOSED,
					'group_name'					=> (string) $name,
					'group_description'			=> (string) $data[4],
					//'group_desc_uid'		=> '',
					//'group_desc_bitfield'	=> '',
					'group_colour'					=> (string) $data[0],
					//'group_legend'			=> (int) $data[1],
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
					'bot_id'				=> array('UINT', NULL, 'auto_increment'),
					'bot_active'			=> array('BOOL', 1),
					'bot_name'			=> array('STEXT_UNI', ''),
					'bot_color'			=> array('VCHAR', ''),
					'user_id'				=> array('UINT', 0),
					'bot_agent'			=> array('VCHAR', ''),
					'bot_ip'				=> array('VCHAR', ''),
					'bot_last_visit'		=> array('VCHAR:11', ''),
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
		    $this->data['is_bot'] = 1;
			
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
				'Baidu [Spider]'						=> array('Baiduspider+(', 'ir@baidu.com'),
				'Bing [Bot]'							=> array('bingbot/', 'bingbot@microsoft.com'), //bingbot-feedback@microsoft.com
				'Exabot [Bot]'						=> array('Exabot/', 'crawler@exabot.com'),
				'FAST Enterprise [Crawler]'		=> array('FAST Enterprise Crawler', 'scirus-crawler@fast.no'),
				'FAST WebCrawler [Crawler]'	=> array('FAST-WebCrawler/', 'atw-crawler@fast.no'),
				'Francis [Bot]'						=> array('http://www.neomo.de/', 'francis@neomo.de'),
				'Gigabot [Bot]'						=> array('Gigabot/', 'gigabot-support@google.com'),
				'Google Adsense [Bot]'			=> array('Mediapartners-Google', 'adsense-support@google.com'),
				'Google Desktop'					=> array('Google Desktop', 'desktop-support@google.com'),
				'Google Feedfetcher'				=> array('Feedfetcher-Google', 'feedfetcher-support@google.com'),
				'Google [Bot]'						=> array('Googlebot', 'googlebot@googlebot.com'),
				'Heise IT-Markt [Crawler]'		=> array('heise-IT-Markt-Crawler', 'info-hg@heise.de'),
				'Heritrix [Crawler]'					=> array('heritrix/1.', 'info@archive.org'),
				'IBM Research [Bot]'				=> array('ibm.com/cs/crawler', 'crawler@almaden.ibm.com'),
				'ICCrawler - ICjobs'				=> array('ICCrawler - ICjobs', 'bot@icjobs.de'),
				'ichiro [Crawler]'					=> array('ichiro/2', 'ichiro@mail.goo.ne.jp'), //ichiro@abc.ne.jp
				'Majestic-12 [Bot]'				=> array('MJ12bot/', 'help@majestic.com'),
				'Metager [Bot]'						=> array('MetagerBot/', ' office@suma-ev.de'),
				'MSN NewsBlogs'					=> array('msnbot-NewsBlogs/', 'msnbot-newsblogs@microsoft.com'),
				'MSN [Bot]'							=> array('msnbot/', 'msnbot@microsoft.com'),
				'MSNbot Media'					=> array('msnbot-media/', 'msnbot-media@microsoft.com'),
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
				'SEOSearch [Crawler]'			=> array('SEOsearch/', 'e-search@seosearch.biz'),
				'Snappy [Bot]'						=> array('Snappy/1.1 ( http://www.urltrends.com/ )', ''),
				'Steeler [Crawler]'					=> array('http://www.tkl.iis.u-tokyo.ac.jp/~crawler/', ''),
				'Synoo [Bot]'						=> array('SynooBot/', 'synoobot'),
				'Telekom [Bot]'					=> array('crawleradmin.t-info@telekom.de', 'crawleradmin.t-info@telekom.de'),
				'TurnitinBot [Bot]'					=> array('TurnitinBot/', 'tiisupport@turnitin.com'),
				'Voyager [Bot]'						=> array('voyager/1.0', ''),
				'W3 [Sitesearch]'					=> array('W3 SiteSearch Crawler', 'sitesearch@w3.org'), //MIT/LCS (Massachusetts Institute of Technology, Laboratory for Computer Science)
				'W3C [Linkcheck]'				=> array('W3C-checklink/', 'site-comments@w3.org'),
				'W3C [Validator]'					=> array('W3C_*Validator', 'www-validator@w3.org'),
				'WiseNut [Bot]'						=> array('http://www.WISEnutbot.com', 'ZyBorg@WISEnutbot.com'),
				'YaCy [Bot]'							=> array('yacybot', '(mc@yacy.net'),
				'Yahoo MMCrawler [Bot]'		=> array('Yahoo-MMCrawler/', 'vertical-crawl-support@yahoo-inc.com'),
				'Yahoo Slurp [Bot]'				=> array('Yahoo! DE Slurp', 'slurp@inktomi.com'),
				'Yahoo [Bot]'						=> array('Yahoo! Slurp', 'crawl-support@yahoo-inc.com'),
				'YahooSeeker [Bot]'				=> array('YahooSeeker/', 'seeker-support@yahoo-inc.com'),
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
					'user_password'	=> '',
					'user_colour'		=> '9E8DA7',
					'user_email'			=> $bot_ary[1],
					//phpbb2/'user_timezone'	=> $this->config['board_timezone'],
					//phpbb2/'user_dateformat'	=> $this->config['default_dateformat'],
					//phpbb2/'user_lang'			=> $this->config['default_lang'],
					//phpbb2/'user_style'			=> (int) $this->config['default_style'],
					'is_bot'				=> (int) 1,
					'is_mobile'			=> (int) $this->data['is_mobile'] ,
					'user_agent'  		=> (string) $bot_ary[0],
					'user_ip'				=> (string) $this->user_ip,
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
					'bot_active'			=> 1,
					'bot_name'			=> $bot_name,
					'user_id'				=> $user_id,
					'bot_agent'			=> $bot_ary[0],
					'bot_ip'				=> $this->user_ip,
					//'bot_style'		=> (int) $board_config['default_style'],
					'bot_color'			=> '9E8DA7',
					'bot_last_visit'		=> time(),
					'bot_visit_counter'	=> 1,
				);
				
				/*
				* Update bots table
				*/
				//$this->db->sql_return_on_error(true);
				if ( !($result = $this->db->sql_query('INSERT INTO ' . BOTS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $ary))) )
				{
					mx_message_die(GENERAL_ERROR, 'Couldn\'t insert data into bots table.', '', __LINE__, __FILE__,  '<br /><br />SQL Error : ' . $this->db->sql_error('')['code'] . ' ' . $this->db->sql_error('')['message']);
				}
				//$this->db->sql_return_on_error(false);
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
						mx_message_die(CRITICAL_ERROR, 'Could not update bot info', '', __LINE__, __FILE__, $sql);
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
						'bot_active'			=> 1,
						'bot_name'			=> $bot_name,
						'user_id'				=> $user_id,
						'bot_agent'			=> $bot_ary[0],
						'bot_ip'				=> $user_ip,
						//'bot_style'		=> (int) $board_config['default_style'],
						'bot_color'			=> '9E8DA7',
						'bot_last_visit'		=> time(),
						'bot_visit_counter'	=> 1,
					);
					
					/*
					* Update bots table
					*/
					//$this->db->sql_return_on_error(true);
					if ( !($result = $this->db->sql_query('INSERT INTO ' . BOTS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $ary))) )
					{
						mx_message_die(GENERAL_ERROR, 'Couldn\'t insert data into bots table.', '', __LINE__, __FILE__,  '<br /><br />SQL Error : ' . $this->db->sql_error('')['code'] . ' ' . $this->db->sql_error('')['message']);
					}
					//$this->db->sql_return_on_error(false);
					/*
					*/
				}
			}
		}
		else
		{
		    $this->data['is_bot'] = false;
		}
		
		
		
		
		if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) 
		{
		    $this->data['is_bot'] = true;
		}
		
		$this->data['user_perm_from'] = '';
		
		$this->data['user_topic_sortby_type'] = 't';
		$this->data['user_topic_sortby_dir'] = 'd';
		$this->data['user_topic_show_days'] = 0;
		
		$this->data['user_last_privmsg'] = 0;
		
		$this->data['user_post_sortby_type'] = 't';
		$this->data['user_post_sortby_dir'] = 'a';
		$this->data['user_post_show_days'] = 0;
		
		$this->data['user_new_privmsg'] = 0;
		$this->data['user_unread_privmsg'] = 0;
		$this->data['user_form_salt'] = bin2hex(random_bytes(8));
		$this->data['user_avatar'] = 'includes/shared/phpbb2/images/user_avatar.png';		
		$this->data['user_avatar_type'] = 2;
		
		
		$this->data['user_form_salt'] = bin2hex(random_bytes(8));
		
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

		$page_array += array(
			'page_name'			=> $page_name,
			'page_dir'				=> $page_dir,

			'query_string'			=> $query_string,
			'script_path'				=> str_replace(' ', '%20', htmlspecialchars($script_path)),
			'root_script_path'		=> str_replace(' ', '%20', htmlspecialchars($root_script_path)),

			'page'					=> $page
		);

		return $page_array;
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
	
	// ------------------------------
	// Init user class.
	//
	
	//
	// Adds/updates a new session to the database for the given userid.
	// Returns the new session ID on success.
	//
	function session_begin($user_id = 1, $user_ip = false, $page_id = 1, $auto_create = 0, $enable_autologin = 0, $admin = 0)
	{
		global $db, $board_config, $mx_backend, $mx_root_path;
		global $mx_request_vars, $SID;

		$cookiename = $board_config['cookie_name'];
		$cookiepath = $board_config['cookie_path'];
		$cookiedomain = $board_config['cookie_domain'];
		$cookiesecure = $board_config['cookie_secure'];

		// Give us some basic information
		$this->time_now					= time();
		$this->cookie_data				= array('u' => 0, 'k' => '');
		$this->update_session_page	= true;
		$this->browser					= (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : '';
		$this->referer						= (!empty($_SERVER['HTTP_REFERER'])) ? htmlspecialchars((string) $_SERVER['HTTP_REFERER']) : '';		
		$this->forwarded_for				= (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? (string) $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
		$this->host							= (!empty($_SERVER['HTTP_HOST'])) ? (string) $_SERVER['HTTP_HOST'] : 'localhost';
		$this->page						= $this->extract_current_page($mx_root_path);

		if ( isset($_COOKIE[$cookiename . '_sid']) || isset($_COOKIE[$cookiename . '_data']) )
		{
			$session_id = isset($_COOKIE[$cookiename . '_sid']) ? $_COOKIE[$cookiename . '_sid'] : '';
			$sessiondata = isset($_COOKIE[$cookiename . '_data']) ? unserialize(stripslashes($_COOKIE[$cookiename . '_data'])) : array();
			$sessionmethod = SESSION_METHOD_COOKIE;
		}
		else
		{
			$sessiondata = array();
			$session_id = $mx_request_vars->is_get('sid',MX_TYPE_NO_TAGS);
			$sessionmethod = SESSION_METHOD_GET;
		}

		//
		if (!preg_match('/^[A-Za-z0-9]*$/', $session_id))
		{
			$session_id = '';
		}

		$page_id = (int) $page_id;

		$last_visit = 0;
		$current_time = time();
		
		//
		// Are auto-logins allowed?
		// If allow_autologin is not set or is true then they are
		// (same behaviour as old 2.0.x session code)
		//
		if (isset($board_config['allow_autologin']) && !$board_config['allow_autologin'])
		{
			$enable_autologin = $sessiondata['autologinid'] = false;
		}
		
		//
		// First off attempt to join with the autologin value if we have one
		// If not, just use the user_id value
		//
		$userdata = array();
		
		if ($user_id != ANONYMOUS)
		{
			if (isset($sessiondata['autologinid']) && (string) $sessiondata['autologinid'] != '' && $user_id)
			{
				$sql = 'SELECT u.*, u.user_id as user_colour, u.user_level as user_type, p.default_lang as user_lang, p.board_timezone as user_timezone 
					FROM ' . USERS_TABLE . ' u, ' . SESSIONS_KEYS_TABLE . ' k, ' . PORTAL_TABLE . ' p
					WHERE u.user_id = ' . (int) $user_id . "
						AND u.user_active = 1
						AND k.user_id = u.user_id
						AND k.key_id = '" . md5($sessiondata['autologinid']) . "'
						AND p.portal_id = '1'";
				
				if (!($result = $db->sql_query($sql)))
				{
					mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
				}

				$userdata = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$enable_autologin = $login = 1;
			}
			else if (!$auto_create)
			{
				$sessiondata['autologinid'] = '';
				$sessiondata['userid'] = $user_id;
				
				$sql = 'SELECT u.*, u.user_id as user_colour, u.user_level as user_type, p.default_lang as user_lang, p.board_timezone as user_timezone 
					FROM ' . USERS_TABLE . ' u, ' . PORTAL_TABLE . ' p
					WHERE u.user_id = ' . (int) $user_id . '
						AND u.user_active = 1
						AND p.portal_id = 1';
						
				if (!($result = $db->sql_query($sql)))
				{
					mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
				}

				$userdata = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$login = 1;
			}
		}
		elseif ($mx_request_vars->is_request('login'))
		{
			die('Invalid user_id to login: '.ANONYMOUS);
		}	
		else
		{
			// Bot user, if they have a SID in the Request URI we need to get rid of it otherwise they'll index this page with the SID, duplicate content oh my!
			if (isset($_GET['sid']) && !empty($this->data['is_bot']))
			{
				send_status_line(301, 'Moved Permanently');
				redirect(build_url(array('sid')));
			}
			$this->data['session_last_visit'] = $this->time_now;
		}
		
		//
		// At this point either $userdata should be populated or
		// one of the below is true
		// * Key didn't match one in the DB
		// * User does not exist
		// * User is inactive
		//
		if (!sizeof($userdata) || !is_array($userdata) || !$userdata)
		{
			$sessiondata['autologinid'] = '';
			$sessiondata['userid'] = $user_id = ANONYMOUS;
			$enable_autologin = $login = 0;
			
			$sql = 'SELECT u.*, u.user_id as user_colour, u.user_level as user_type, p.default_lang as user_lang, p.board_timezone as user_timezone 
					FROM ' . USERS_TABLE . ' u, ' . SESSIONS_KEYS_TABLE . ' k, ' . PORTAL_TABLE . ' p
					WHERE u.user_id = ' . (int) $user_id . '
						AND p.portal_id = 1';	
			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
			}

			$userdata = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		}

		/*
		* Initial ban check against user id, IP and email address
		* Is user banned? Are they excluded? Won't return on ban, exists within method
		* /
		$this->check_ban_for_current_session($board_config);
		* -------------------------------------------------------- * /
		# Added to table structure for 'phpbb3_banlist'
		  +`ban_start` int(11) UNSIGNED NOT NULL DEFAULT '0',
		  +`ban_end` int(11) UNSIGNED NOT NULL DEFAULT '0',
		  +`ban_exclude` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
		  +`ban_reason` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
		  +`ban_give_reason` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
		/**/	
		$schema = array(
			'COLUMNS'	=> array(
				'ban_id'				=> array('UINT', NULL, 'auto_increment'),
				'ban_userid'			=> array('UINT', 0),
				'ban_ip'				=> array('VCHAR', ''),
				'ban_email'			=> array('VCHAR:100', ''),
				'bot_start'			=> array('UINT:11', 0),
				'bot_end'			=> array('UINT:11', 0),
				'ban_exclude'		=> array('UINT:2', ''),
				'ban_reason'		=> array('VCHAR', ''),
				'ban_give_reason'	=> array('VCHAR', ''),
			),
			'PRIMARY_KEY'	=> 'bot_id',
				'KEYS'	=> array(
				'KEY' => array('ban_end', 'ban_end'),
				'KEY' => array('ban_user', 'ban_userid', 'ban_exclude'),
				'KEY' => array('ban_email', 'ban_email', 'ban_exclude'),
				'KEY' => array('ban_ip', 'ban_ip', 'ban_exclude')
			),
		);
		if (!$this->db->sql_table_exists(BANLIST_TABLE))
		{
			$this->db_tools->sql_create_table(BANLIST_TABLE, $schema);
		}
		
		//
		// Create or update the session
		//
		$sql = "UPDATE " . SESSIONS_TABLE . "
			SET session_user_id = $user_id, session_start = $current_time, session_time = $current_time, session_page = $page_id, session_logged_in = $login, session_admin = $admin
			WHERE session_id = '" . $session_id . "'
				AND session_ip = '$user_ip'";
		if ( !$db->sql_query($sql) || !$db->sql_affectedrows() )
		{
			$session_id = md5($mx_backend->dss_rand());

			$sql = "INSERT INTO " . SESSIONS_TABLE . "
				(session_id, session_user_id, session_start, session_time, session_ip, session_page, session_logged_in, session_admin)
				VALUES ('$session_id', $user_id, $current_time, $current_time, '$user_ip', $page_id, $login, $admin)";
			if ( !$db->sql_query($sql) )
			{
				mx_message_die(CRITICAL_ERROR, 'Error creating new session', '', __LINE__, __FILE__, $sql);
			}
		}
		
		if ( $user_id != ANONYMOUS )
		{
			$last_visit = ( $userdata['user_session_time'] > 0 ) ? $userdata['user_session_time'] : $current_time;

			if (!$admin)
			{
				$sql = "UPDATE " . USERS_TABLE . "
					SET user_session_time = $current_time, user_session_page = $page_id, user_lastvisit = $last_visit
					WHERE user_id = $user_id";
				if ( !$db->sql_query($sql) )
				{
					mx_message_die(CRITICAL_ERROR, 'Error updating last visit time', '', __LINE__, __FILE__, $sql);
				}
			}

			$userdata['user_lastvisit'] = $last_visit;

			//
			// Regenerate the auto-login key
			//
			if ($enable_autologin)
			{
				$auto_login_key = $mx_backend->dss_rand() . $mx_backend->dss_rand();

				if (isset($sessiondata['autologinid']) && (string) $sessiondata['autologinid'] != '')
				{
					$sql = 'UPDATE ' . SESSIONS_KEYS_TABLE . "
						SET last_ip = '$user_ip', key_id = '" . md5($auto_login_key) . "', last_login = $current_time
						WHERE key_id = '" . md5($sessiondata['autologinid']) . "'";
				}
				else
				{
					$sql = 'INSERT INTO ' . SESSIONS_KEYS_TABLE . "(key_id, user_id, last_ip, last_login)
						VALUES ('" . md5($auto_login_key) . "', $user_id, '$user_ip', $current_time)";
				}

				if ( !$db->sql_query($sql) )
				{
					$sql2 = 'UPDATE ' . SESSIONS_KEYS_TABLE . "
						SET last_login = $current_time
						WHERE key_id = '" . md5($sessiondata['autologinid']) . "'";
					if ( !$db->sql_query($sql2) )
					{
						mx_message_die(CRITICAL_ERROR, 'Error updating session key', '', __LINE__, __FILE__, $sql);
					}
				}
				$sessiondata['autologinid'] = $auto_login_key;
				unset($auto_login_key);
			}
			else
			{
				$sessiondata['autologinid'] = '';
			}

	//		$sessiondata['autologinid'] = (!$admin) ? (( $enable_autologin && $sessionmethod == SESSION_METHOD_COOKIE ) ? $auto_login_key : '') : $sessiondata['autologinid'];
			$sessiondata['userid'] = $user_id;
		}
		
		if ( $userdata['user_id'] == ANONYMOUS )
		{
			$userdata['user_type'] = -1;
		}
		
		if (($userdata['user_level'] = 1) && ($userdata['user_active'] = 1))
		{
			$userdata['user_type'] = 3;
		}
		
		if (($userdata['user_level'] = 0) && ($userdata['user_active'] = 1))
		{
			$userdata['user_type'] = 0;
		}
		
		if (($userdata['user_level'] = 0) && ($userdata['user_active'] = 0))
		{
			$userdata['user_type'] = 1; //or 2
		}
		
		//Moderator
		if (($userdata['user_level'] = 2) && ($userdata['user_active'] = 1))
		{
			$userdata['user_type'] = 2; //or 1
		}
		
		$userdata['session_id'] = $session_id;
		$userdata['session_ip'] = $user_ip;
		$userdata['session_user_id'] = $user_id;
		$userdata['session_logged_in'] = $login;
		$userdata['session_page'] = $page_id;
		$userdata['session_start'] = $current_time;
		$userdata['session_time'] = $current_time;
		$userdata['session_admin'] = $admin;
		$userdata['session_key'] = $sessiondata['autologinid'];

		setcookie($cookiename . '_data', serialize($sessiondata), $current_time + 31536000, $cookiepath, $cookiedomain, $cookiesecure);
		setcookie($cookiename . '_sid', $session_id, 0, $cookiepath, $cookiedomain, $cookiesecure);

		$SID = 'sid=' . $session_id;

		return $userdata;
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
				mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
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
	* Reset all login keys for the specified user
	* Called on password changes
	*/
	function session_reset_keys($user_id, $user_ip)
	{
		global $db, $userdata, $board_config, $mx_backend;

		$key_sql = ($user_id == $userdata['user_id'] && !empty($userdata['session_key'])) ? "AND key_id != '" . md5($userdata['session_key']) . "'" : '';

		$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
			WHERE user_id = ' . (int) $user_id . "
				$key_sql";

		if ( !$db->sql_query($sql) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error removing auto-login keys', '', __LINE__, __FILE__, $sql);
		}

		$where_sql = 'session_user_id = ' . (int) $user_id;
		$where_sql .= ($user_id == $userdata['user_id']) ? " AND session_id <> '" . $userdata['session_id'] . "'" : '';
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . "
			WHERE $where_sql";
		if ( !$db->sql_query($sql) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error removing user session(s)', '', __LINE__, __FILE__, $sql);
		}

		if ( !empty($key_sql) )
		{
			$auto_login_key = $mx_backend->dss_rand() . $mx_backend->dss_rand();

			$current_time = time();

			$sql = 'UPDATE ' . SESSIONS_KEYS_TABLE . "
				SET last_ip = '$user_ip', key_id = '" . md5($auto_login_key) . "', last_login = $current_time
				WHERE key_id = '" . md5($userdata['session_key']) . "'";

			if ( !$db->sql_query($sql) )
			{
				mx_message_die(CRITICAL_ERROR, 'Error updating session key', '', __LINE__, __FILE__, $sql);
			}

			// And now rebuild the cookie
			$sessiondata['userid'] = $user_id;
			$sessiondata['autologinid'] = $auto_login_key;
			$cookiename = $board_config['cookie_name'];
			$cookiepath = $board_config['cookie_path'];
			$cookiedomain = $board_config['cookie_domain'];
			$cookiesecure = $board_config['cookie_secure'];

			setcookie($cookiename . '_data', serialize($sessiondata), $current_time + 31536000, $cookiepath, $cookiedomain, $cookiesecure);

			$userdata['session_key'] = $auto_login_key;
			unset($sessiondata);
			unset($auto_login_key);
		}
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

		preg_match('/(..)(..)(..)(..)/', $user_ips, $user_ip_parts);
		/*
		$sql = "SELECT ban_ip, ban_userid, ban_email
			FROM " . BANLIST_TABLE . "
			WHERE ban_ip IN ('" . $user_ip_parts[1] . $user_ip_parts[2] . $user_ip_parts[3] . $user_ip_parts[4] . "', '" . $user_ip_parts[1] . $user_ip_parts[2] . $user_ip_parts[3] . "ff', '" . $user_ip_parts[1] . $user_ip_parts[2] . "ffff', '" . $user_ip_parts[1] . "ffffff')
				OR ban_userid = $user_id";
		if ( $user_id != ANONYMOUS )
		{
			$sql .= " OR ban_email LIKE '" . str_replace("\'", "''", $userdata['user_email']) . "'
				OR ban_email LIKE '" . substr(str_replace("\'", "''", $userdata['user_email']), strpos(str_replace("\'", "''", $userdata['user_email']), "@")) . "'";
		}

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

		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(CRITICAL_ERROR, 'Could not obtain ban information', '', __LINE__, __FILE__, $sql);
		}
		
		$ban_triggered_by = 'user';
		if ( $ban_info = $db->sql_fetchrow($result) )
		{
			if ( $ban_info['ban_ip'] || $ban_info['ban_userid'] || $ban_info['ban_email'] )
			{
				$banned = true;
				$return = true;
			}
		}
		$db->sql_freeresult($result);
		*/
		if ($banned && !$return)
		{
			mx_message_die(CRITICAL_MESSAGE, 'You_been_banned');
		}

		return ($banned) ? true : false;
	}
	
	/**
	 * Check the current session for bans
	 *
	 * @return true if session user is banned.
	 */
	protected function check_ban_for_current_session($config)
	{
		if (!defined('SKIP_CHECK_BAN') && $this->data['user_type'] != USER_FOUNDER)
		{
			if (!isset($config['forwarded_for_check']))
			{
				$this->check_ban($this->data['user_id'], $this->ip);
			}
			else
			{
				$ips = explode(' ', $this->forwarded_for);
				$ips[] = $this->ip;
				$this->check_ban($this->data['user_id'], $ips);
			}
		}
	}

	/**
	* Check if ip is blacklisted
	* This should be called only where absolutely necessary
	*
	* Only IPv4 (rbldns does not support AAAA records/IPv6 lookups)
	*
	* @author satmd (from the php manual)
	* @param string 		$mode	register/post - spamcop for example is omitted for posting
	* @param string|false	$ip		the IPv4 address to check
	*
	* @return false if ip is not blacklisted, else an array([checked server], [lookup])
	*/
	function check_dnsbl($mode, $ip = false)
	{
		if ($ip === false)
		{
			$ip = $this->ip;
		}

		// Neither Spamhaus nor Spamcop supports IPv6 addresses.
		if (strpos($ip, ':') !== false)
		{
			return false;
		}

		$dnsbl_check = array(
			'sbl.spamhaus.org'	=> 'http://www.spamhaus.org/query/bl?ip=',
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
	
	/** *******************************************************************************************************
	 * Include the User class
	 ******************************************************************************************************* */

	/**
	* Define backend specific lang defs
	*/
	function setup($lang_set = false, $style = false)
	{
		global $mx_cache, $template, $phpbb_auth, $phpEx, $phpbb_root_path, $mx_root_path;
		global $mx_request_vars, $portal_config, $shared_lang_path, $phpBB2; //added for mxp


		global $board_config, $theme, $images;
		global $db, $board_config, $userdata, $phpbb_root_path;		
		global $template, $lang, $phpEx, $nav_links;
		
		$this->data = !empty($this->data['user_id']) ? $this->data : $this->session_pagestart($this->user_ip, $this->page_id);
		
		$this->cache = is_object($mx_cache) ? $mx_cache : new base();
		
		if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) 
		{
		    $this->data['is_bot'] = true;
		}
		else
		{
		    $this->data['is_bot'] = false;
		}

		//
		// Populate session_id
		//
		$this->session_id = $this->data['session_id'];

		$this->lang_path = $shared_lang_path;
		$this->lang_name = isset($this->data['user_lang']) ? $this->data['user_lang'] : $board_config['default_lang'];
		
		//$this->lang_path = $phpbb_root_path . 'language/';
		
		$lang_set = !$lang_set ? (defined('IN_ADMIN') ? 'lang_admin' : 'lang_main') : $lang_set;
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

		$board_config['avatar_gallery_path'] = isset($board_config['avatar_gallery_path']) ? $board_config['avatar_gallery_path'] : 'images/avatars/gallery'; 
		$board_config['user_timezone'] = !empty($board_config['user_timezone']) ? $board_config['user_timezone'] : $board_config['board_timezone'];
		$this->data['user_dst'] = !empty($this->data['user_dst']) ? $this->data['user_dst'] : $this->data['user_timezone'];
		$board_config['require_activation'] = 0;
		$this->date_format = $board_config['default_dateformat'];
		$this->timezone = $board_config['user_timezone'] * 3600;
		$this->dst = $this->data['user_timezone'] * 3600;
		
		$sign = ($board_config['board_timezone'] < 0) ? '-' : '+';
		$time_offset = abs($board_config['board_timezone']);

		$offset_seconds	= $time_offset % 3600;
		$offset_minutes	= $offset_seconds / 60;
		$offset_hours	= ($time_offset - $offset_seconds) / 3600;		
		
		// Zone offset
		$zone_offset = $this->timezone + $this->dst;
		
		$offset_string = sprintf($board_config['default_dateformat'], $sign, $offset_hours, $offset_minutes);
				
		$s_date = gmdate("Y-m-d\TH:i:s", time() + $zone_offset) . $offset_string;
		
		// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
		$l_timezone = explode('.', $board_config['board_timezone']);
		$l_timezone = (count($l_timezone) > 1) ? $this->lang(sprintf('%.1f', $board_config['board_timezone'])) : $offset_string;

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
		$img_lang = $default_lang = ($this->data['user_lang']) ? $this->data['user_lang'] : $board_config['default_lang'];
		
		if ($this->data['user_id'] != ANONYMOUS)
		{
			if (!empty($this->data['user_lang']))
			{
				$default_lang = $phpBB2->phpbb_ltrim(basename($phpBB2->phpbb_rtrim($this->data['user_lang'])), "'");
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
			$default_lang = $phpBB2->phpbb_ltrim(basename($phpBB2->phpbb_rtrim($board_config['default_lang'])), "'");
		}
		
		// Shared phpBB2 lang files dir		
		// Load vanilla phpBB2 lang files if is possible
		$shared_phpbb2_path 	= $mx_root_path . 'includes/shared/phpbb2/';
		$shared_phpbb3_path 	= $mx_root_path . 'includes/shared/phpbb3/';
		$shared_lang_path 		= $mx_root_path . 'includes/shared/phpbb2/language/';		
		$lang_path 				= $mx_root_path . 'includes/shared/phpbb2/language/';				
		
		if (!file_exists(@phpbb_realpath($shared_phpbb2_path . 'lang_' . $default_lang . '/lang_main.'.$phpEx)) && !file_exists(@phpbb_realpath($shared_lang_path . 'lang_' . $default_lang . '/lang_main.'.$phpEx)))
		{
			if ($userdata['user_id'] !== ANONYMOUS)
			{
				// For logged in users, try the board default language next
				// Just in case we do fallback on $board_config['phpbb_lang']  
				// Since $board_config['default_lang'] has been overwiten in function $mx_user->_init_userprefs()				
				$default_lang = ltrim(basename(rtrim($board_config['phpbb_lang'])), "'");
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

		$board_config['default_lang'] = $default_lang;
		$portal_config['default_lang'] = $default_lang;
		$this->lang_name = $this->lang['default_lang'] = $default_lang;
		$this->lang_path = $shared_phpbb2_path . 'language/lang_' . $board_config['default_lang'] . '/';
		
		//
		// We include common language file here to not load it every time a custom language file is included
		//
		$lang = &$this->lang;

		/** Sort of pointless here, since we have already included all main lang files **/
		if ((@include $this->lang_path . "lang_main.$phpEx") === false)
		{
			//this will fix the path for anonymouse users
			if ((@include $phpbb_root_path . $this->lang_path . "lang_main.$phpEx") === false)
			{
				die('Language file (setup) ' . $this->lang_path . "lang_main.$phpEx" . ' couldn\'t be opened.');
			}
		}
		//  include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
		
		$this->add_lang($lang_set);

		// We include common language file here to not load it every time a custom language file is included
		$this->set_lang($this->lang, $this->help, 'common');
		//  $lang = &$this->lang;
		
		unset($lang_set);
			
		if (defined('IN_ADMIN'))
		{
			if(!file_exists(@phpbb_realpath($shared_phpbb2_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.'.$phpEx)))
			{
				$board_config['default_lang'] = 'english';
			}
			include($shared_phpbb2_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
		}
		
		//
		// We setup common user language variables
		//
		$this->lang = &$lang;
		//print_r($this->lang);		
		$this->user_lang = !empty($this->lang['USER_LANG']) ? $this->lang['USER_LANG'] : $this->encode_lang($this->lang_name);
		$user_lang = $this->user_lang;
		
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
		
		//
		// Finishing setting language variables to ouput
		//
		$this->lang_iso = $lang_iso = $lang_entries['lang_iso'];		
		$this->lang_dir = $lang_dir = $lang_entries['lang_dir'];
		$this->lang_english_name = $lang_english_name = $lang_entries['lang_english_name'];		
		$this->lang_local_name = $lang_local_name = $lang_entries['lang_local_name'];
		
		//
		// Set up style to output
		//
		if ($this->data['user_id'] == ANONYMOUS && empty($this->data['user_style']))
		{
			$this->data['user_style'] = $board_config['default_style'];
		}
		
		/*
		* This code was or is used for phpBB3 backend
		* now commented here
		*  * * /
		if (!empty($_GET['style']) || isset($_COOKIE['style']))
		{
			global $SID, $_EXTRA_URL;

			$style_request = phpBB3::request_var('style', 0);
			$SID .= '&amp;style=' . $style_request;
			$_EXTRA_URL = array('style=' . $style_request);
			
			if ( $theme = $this->_setup_style($style_request) )
			{
				setcookie('style', $style_request, (time() + 21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
				return;
			}			
		}
		/**  
		*
		* */
		

		
		/*
		* Setup demo style code
		* Start
		* * /
		if ( isset($_GET['demo_theme']) || isset($_COOKIE['demo_theme']))
		{
				$style_request = isset($_GET['demo_theme']) ? intval($_GET['demo_theme']) : intval($_COOKIE['demo_theme']);
				if ( $theme = $this->_setup_style($style_request) )
				{
					setcookie('demo_theme', $style_request, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
					return;
				}
		}			
		/*
		* Setup demo style code
		* Ends
		*/		
		
		$style_request = $mx_request_vars->request('style', MX_TYPE_INT, 1);	
		
		if ($mx_request_vars->is_get('style') && (!$board_config['override_user_style'] || !defined('IN_ADMIN')))
		{
			global $SID, $_EXTRA_URL;

			$style = $style_request;
			$SID .= '&amp;style=' . $style;
			$_EXTRA_URL = array('style=' . $style);
		}
		else
		{
			// Set up style
			$style = ($style) ? $style : ((!$board_config['override_user_style']) ? $this->data['user_style'] : $board_config['default_style']);
		}
		/*
		* Setup style code
		* Start
		* * /		
		//If user have other style in mxp then the one from phpBB not to have forum page and modules graphics will be messaed up
		//Anonymouse users should see all block graphic corect
		//Query phpBB style_id corepondent to mxp themes_id
		$sql = "SELECT s.*
			FROM " . MX_THEMES_TABLE . " AS m, " . THEMES_TABLE . " AS s
			WHERE s.themes_id = " . (int) $style_id . "
				AND s.template_name = m.template_name";			
		$result = $db->sql_query($sql);
		$this->style = $this->theme = $theme = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		
		// Fallback to user's standard style
		if (!$this->style && $style_id != $this->data['user_style'])
		{
			$style_id = $this->data['user_style'];

			$sql = "SELECT s.*
				FROM " . MX_THEMES_TABLE . " AS m, " . THEMES_TABLE . " AS s
				WHERE s.themes_id = " . (int) $style_id . "
					AND s.template_name = m.template_name";	
			$result = $db->sql_query($sql);
			$this->style = $this->theme = $theme = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		}
		// Fallback to user's standard style 
		if (!$this->style)
		{
			$this->style = $this->theme = $theme = setup_style($style_id);
			
			mx_message_die(CRITICAL_ERROR, "Could not query database for phpbb_styles info style_id [$style_id]", "", __LINE__, __FILE__, $sql);
		}
		
		$this->template_name = $theme['template_name'];
			
		// We are trying to setup a style which does not exist in the database
		// Try to fallback to the board default (if the user had a custom style)
		// and then any users using this style to the default if it succeeds
		if ($theme['themes_id'] != $board_config['default_style'])
		{					
			$sql = 'SELECT template_name
					FROM ' . THEMES_TABLE . '
					WHERE themes_id = ' . (int) $board_config['default_style'];
			
			if ($row = $db->sql_fetchrow($result = $db->sql_query($sql)))
			{
				$db->sql_freeresult($result);
				$this->default_current_template_name = !empty($row['template_name']) ? $row['template_name'] : $this->default_current_template_name;
			}				
		}
		
		//Setup cloned template	as prosilver based for phpBB3 styles		
		if( @file_exists(@phpbb_realpath($phpbb_root_path . $this->template_path . $this->template_name . '/style.cfg')) )
		{
			$cfg = parse_cfg_file($phpbb_root_path . $this->template_path . $this->template_name . '/style.cfg');
			$this->cloned_template_name = !empty($cfg['parent']) ? $cfg['parent'] : 'prosilver';
			$this->cloned_template_path = $this->template_path . $this->cloned_template_name;			
			$this->default_template_name = !empty($cfg['parent']) ? $cfg['parent'] : 'prosilver';
		}
		
		//Setup current_template_path	
		$this->default_current_template_path = $this->template_path . $this->default_current_template_name;
		$this->current_template_path = $this->template_path . $this->template_name;
		$this->theme['theme_path'] = $this->template_name;			
		
		$parsed_array = $this->cache->get('_cfg_' . $this->template_path);

		if ($parsed_array === false)
		{
			$parsed_array = array();
		}	
		
		if( @file_exists(@phpbb_realpath($phpbb_root_path . $this->current_template_path . '/style.cfg')) )
		{
			//parse phpBB3 style cfg file
			$cfg_file_name = 'style.cfg';			
			$cfg_file = $phpbb_root_path . $this->current_template_path . '/style.cfg';
					
			if (!isset($parsed_array['filetime']) || (@filemtime($cfg_file) > $parsed_array['filetime']))
			{
				// Re-parse cfg file
				$parsed_array = parse_cfg_file($cfg_file);		
				$parsed_array['filetime'] = @filemtime($cfg_file);				
				$this->cache->put('_cfg_' . $this->template_path, $parsed_array);
			}							
		}
		else
		{	
			//parse phpBB2 style cfg file	
			$cfg_file_name = $this->template_name . '.cfg';
			$cfg_file = $phpbb_root_path . $this->current_template_path . '/' . $cfg_file_name;
			
			if (file_exists($phpbb_root_path .  $this->current_template_path . '/' . $cfg_file_name))
			{
				if (!isset($parsed_array['filetime']) || (@filemtime($cfg_file) > $parsed_array['filetime']))
				{				
					$parsed_array = parse_cfg_file($cfg_file);		
					$parsed_array['filetime'] = @filemtime($cfg_file);
					$this->cache->put('_cfg_' . $this->template_path, $parsed_array);				
				}
			}		
		}
		
		$check_for = array(
			'pagination_sep'    => (string) ', '
		);

		foreach ($check_for as $key => $default_value)
		{
			$this->style[$key] = (isset($parsed_array[$key])) ? $parsed_array[$key] : $default_value;
			$this->theme[$key] = (isset($parsed_array[$key])) ? $parsed_array[$key] : $default_value;
			settype($this->style[$key], gettype($default_value));
			settype($this->theme[$key], gettype($default_value));
			if (is_string($default_value))
			{
				$this->style[$key] = htmlspecialchars($this->style[$key]);
				$this->theme[$key] = htmlspecialchars($this->theme[$key]);
			}
		}
		
 		// If the style author specified the theme needs to be cached
		// (because of the used paths and variables) than make sure it is the case.
		// For example, if the theme uses language-specific images it needs to be stored in db.
		if (file_exists($phpbb_root_path . $this->template_path . $this->template_name . '/theme/stylesheet.css'))
		{
			//phpBB3 Style Sheet
			$theme_file = 'stylesheet.css'; 
			$css_file_path = $this->template_path . $this->template_name . '/theme/';
			$stylesheet = file_get_contents("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/stylesheet.css");
		}
		else
		{	
			//phpBB2 Style Sheet	
			$theme_file = !empty($this->theme['head_stylesheet']) ?  $this->theme['head_stylesheet'] : $this->template_name . '.css'; 
			$css_file_path = $this->template_path . $this->template_name . '/';
			if (file_exists($phpbb_root_path . $this->template_path . $this->template_name . '/' . $theme_file))
			{
				$stylesheet = file_get_contents("{$phpbb_root_path}{$this->template_path}{$this->template_name}/{$theme_file}");
			}		
		}		
		
		if (!empty($stylesheet))
		{			
			// Match CSS imports
			$matches = array();
			preg_match_all('/@import url\(["\'](.*)["\']\);/i', $stylesheet, $matches);
			
			if (sizeof($matches))
			{
				$content = '';
				foreach ($matches[0] as $idx => $match)
				{
					if ($content = @file_get_contents("{$phpbb_root_path}{$css_file_path}" . $matches[1][$idx]))
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

			$stylesheet = str_replace('./', $css_file_path, $stylesheet);

			$theme_info = array(
				'theme_data'	=> $stylesheet,
				'theme_mtime'	=> time(),
				'theme_storedb'	=> 0
			);
			$theme_data = &$theme_info['theme_data'];
		}			
		
		//		
		// - First try old Olympus image sets then phpBB2  and phpBB3 Proteus template lang images 	
		//		
		if (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/imageset/"))
		{
			$this->imageset_path = '/imageset/'; //Olympus ImageSet
			$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . $this->imageset_path . $this->lang_iso)) ? $this->lang_iso : $this->default_language;
			$this->img_lang_dir = $this->img_lang;
			$this->imageset_backend = 'olympus';		
		}
		elseif (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/"))
		{
			$this->imageset_path = '/theme/images/';  //phpBB3 Images
			if ((@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/lang_{$this->user_language_name}")) || (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/lang_{$this->default_language_name}")))
			{
				$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . $this->imageset_path . 'lang_' . $this->user_language_name)) ? $this->user_language_name : $this->default_language_name;
				$this->img_lang_dir = 'lang_' . $this->img_lang;
				$this->imageset_backend = 'phpbb2';	
			}
			if ((@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/{$this->user_language}")) || (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/{$this->default_language}")))
			{
				$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . $this->imageset_path . $this->user_language_name)) ? $this->user_language : $this->default_language;
				$this->img_lang_dir = $this->img_lang;
				$this->imageset_backend = 'phpbb3';	
			}			
		}		
		elseif (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/images/"))
		{
			$this->imageset_path = '/images/';  //phpBB2 Images
			$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . $this->imageset_path . '/images/lang_' . $this->user_language_name)) ? $this->user_language_name : $this->default_language_name;
			$this->img_lang_dir = 'lang_' . $this->img_lang;
			$this->imageset_backend = 'phpbb2';	
		}
		
		//		
		// Olympus image sets main images
		//		
		if (@file_exists("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}/imageset.cfg"))
		{		
			$cfg_data_imageset = parse_cfg_file("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}/imageset.cfg");
			
			foreach ($cfg_data_imageset as $image_name => $value)
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
				
				if (strpos($image_name, 'img_') === 0 && $image_filename)
				{
					$image_name = substr($image_name, 4);				
					$row[] = array(
						'image_name'		=> (string) $image_name,
						'image_filename'	=> (string) $image_filename,
						'image_height'		=> (int) $image_height,
						'image_width'		=> (int) $image_width,
						'imageset_id'		=> (int) $style_id,
						'image_lang'		=> '',
					);
					
					if (!empty($row['image_lang']))
					{
						$localised_images = true;
					}					
					$row['image_filename'] = !empty($row['image_filename']) ? rawurlencode($row['image_filename']) : '';
					$row['image_name'] = !empty($row['image_name']) ? rawurlencode($row['image_name']) : '';
					$this->img_array[$row['image_name']] = $row;									
				}
			}		
		}
		
		//		
		// - Olympus image sets lolalised images	
		//		
		if (@file_exists("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}{$this->img_lang}/imageset.cfg"))
		{
			$cfg_data_imageset_data = parse_cfg_file("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}{$this->img_lang}/imageset.cfg");
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

				if (strpos($image_name, 'img_') === 0 && $image_filename)
				{
					$image_name = substr($image_name, 4);
					$row[] = array(
						'image_name'		=> (string) $image_name,
						'image_filename'	=> (string) $image_filename,
						'image_height'		=> (int) $image_height,
						'image_width'		=> (int) $image_width,
						'imageset_id'		=> !empty($this->theme['imageset_id']) ? (int) $this->theme['imageset_id'] : 0,
						'image_lang'		=> (string) $this->img_lang,
					);
					
					if (!empty($row['image_lang']))
					{
						$localised_images = true;
					}					
					$row['image_filename'] = !empty($row['image_filename']) ? rawurlencode($row['image_filename']) : '';
					$row['image_name'] = !empty($row['image_name']) ? rawurlencode($row['image_name']) : '';
					$this->img_array[$row['image_name']] = $row;									
				}
			}
		}
		
		//		
		// - phpBB3 Rhea and Proteus lang images 	
		//
			
		
		//		
		// - Try redefining phpBB2 images 	
		//
		if (empty($this->img_array))
		{
			// * Now check for the correct existance of all of the images into
			// 	* each image of a prosilver based style. 			
			 
			
			//  Here we overwrite phpBB images from the template db or configuration file 		
			$rows = array( 
			array(	'image_id' => 1, 
					'image_name' => 'site_logo', 
					'image_filename' => 'site_logo.gif', 
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
					'image_name' => 'forum_read', 
					'image_filename' => 'forum_read.gif', 
					'image_lang' => '', 
					'image_height' => 27, 
					'image_width' => 27, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 4, 
					'image_name' => 'forum_read_locked', 
					'image_filename' => 'forum_read_locked.gif', 
					'image_lang' => '',
					'image_height' => 27, 
					'image_width' => 27, 
					'imageset_id' => 1 
					),
			array( 'image_id' => 5, 
					'image_name' => 'forum_read_subforum', 
					'image_filename' => 'forum_read_subforum.gif', 
					'image_lang' => '',
					'image_height' => 27, 
					'image_width' => 27, 
					'imageset_id' => 1 
					), 
			array( 
					'image_id' => 6, 
					'image_name' => 'forum_unread', 
					'image_filename' => 'forum_unread.gif', 
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
					'image_name' => 'forum_unread_subforum', 
					'image_filename' => 'forum_unread_subforum.gif', 
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
					'image_name' => 'topic_read', 
					'image_filename' => 'topic_read.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 11, 
					'image_name' => 'topic_read_mine', 
					'image_filename' => 'topic_read_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 12, 
					'image_name' => 'topic_read_hot', 
					'image_filename' => 'topic_read_hot.gif', 
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
					'image_name' => 'topic_read_locked', 
					'image_filename' => 'topic_read_locked.gif', 
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
					'image_name' => 'topic_unread', 
					'image_filename' => 'topic_unread.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 17, 
					'image_name' => 'topic_unread_mine', 
					'image_filename' => 'topic_unread_mine.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 18, 
					'image_name' => 'topic_unread_hot', 
					'image_filename' => 'topic_unread_hot.gif', 
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
					'image_name' => 'topic_unread_locked', 
					'image_filename' => 'topic_unread_locked.gif', 
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
					'image_name' => 'announce_read', 
					'image_filename' => 'announce_read.gif', 
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
					'image_name' => 'announce_unread', 
					'image_filename' => 'announce_unread.gif', 
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
					'image_filename' => 'announce_read.gif', 
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
					'image_filename' => 'announce_unread.gif', 
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
					'image_filename' => 'topic_read.gif', 
					'image_lang' => '',  
					'image_height' => 27, 
					'image_width' => 27 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 47, 
					'image_name' => 'pm_unread', 
					'image_filename' => 'topic_unread.gif', 
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
					'image_name' => 'icon_contact_aim', 
					'image_filename' => 'icon_contact_aim.gif', 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 50, 
					'image_name' => 'icon_contact_email', 
					'image_filename' => 'icon_contact_email.gif', 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 51, 
					'image_name' => 'icon_contact_icq', 
					'image_filename' => 'icon_contact_icq.gif', 
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
					'image_name' => 'icon_contact_msnm', 
					'image_filename' => 'icon_contact_msnm.gif', 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 54, 
					'image_name' => 'icon_contact_www', 
					'image_filename' => 'icon_contact_www.gif', 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 55, 
					'image_name' => 'icon_contact_yahoo', 
					'image_filename' => 'icon_contact_yahoo.gif', 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 56, 
					'image_name' => 'icon_post_delete', 
					'image_filename' => 'icon_post_delete.gif', 
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
					'image_filename' => 
					'icon_post_report.gif', 
					'image_lang' => '',  
					'image_height' => 20, 
					'image_width' => 20, 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 59, 
					'image_name' => 'icon_post_target', 
					'image_filename' => 'icon_post_target.gif', 
					'image_lang' => '',  
					'image_height' => 9, 
					'image_width' => 11 , 
					'imageset_id' => 1 
					), 
			array( 'image_id' => 60, 
					 'image_name' => 'icon_post_target_unread', 
					 'image_filename' => 'icon_post_target_unread.gif', 
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
					 'image_name' => 'icon_contact_pm', 
					 'image_filename' => 'icon_contact_pm.gif', 
					 'image_lang' => '{LANG}',   
					 'image_height' => 20, 
					 'image_width' => 28 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 70, 
					 'image_name' => 'icon_post_edit', 
					 'image_filename' => 'icon_post_edit.gif', 
					 'image_lang' => '{LANG}', 
					 'image_height' => 20, 
					 'image_width' => 42 , 
					 'imageset_id' => 1 
					 ), 
			array( 'image_id' => 71, 
					 'image_name' => 'icon_post_quote', 
					 'image_filename' => 'icon_post_quote.gif', 
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
					 'image_name' => 'button_topic_locked', 
					 'image_filename' => 'button_topic_locked.gif', 
					 'image_lang' => '{LANG}', 
					 'image_height' => 25, 
					 'image_width' => 88 , 
					 'imageset_id' => 1 
					), 
			array( 'image_id' => 77, 
					 'image_name' => 'button_topic_new', 
					 'image_filename' => 'button_topic_new.gif', 
					 'image_lang' => '{LANG}', 
					 'image_height' => 25, 
					 'image_width' => 96 , 
					 'imageset_id' => 1 
					), 
			array( 'image_id' => 78, 
					 'image_name' => 'button_topic_reply', 
					 'image_filename' => 'button_topic_reply.gif', 
					 'image_lang' => '{LANG}', 
					 'image_height' => 25, 
					 'image_width' => 96 , 
					 'imageset_id' => 1
				)	
			);			
			
			foreach ($rows as $row)
			{
				$row['image_filename'] = rawurlencode($row['image_filename']);
				
				if(empty($row['image_name']))
				{
					//print_r('Your style configuration file has a typo! ');
					//print_r($row);
					$row['image_name'] = 'spacer.gif';
				}
							
				$this->img_array[$row['image_name']] = $row;				
			}	
		}		

		/** 
		* Now check for the correct existance of all images of the $user->style['style_path'] 
		* $template->set_template();
		* print_r($this->images['forum']);
		*/
		//$this->setup_style();

		
		//
		// Mozilla navigation bar
		// Default items that should be valid on all pages.
		// Defined here to correctly assign the Language Variables
		// and be able to change the variables within code.
		//
		$nav_links['top'] = array (
			'url' => mx_append_sid($phpbb_root_path . 'index.' . $phpEx),
			'title' => sprintf($lang['Forum_Index'], $board_config['sitename'])
		);
		$nav_links['search'] = array (
			'url' => mx_append_sid($phpbb_root_path . 'search.' . $phpEx),
			'title' => $lang['Search']
		);
		$nav_links['help'] = array (
			'url' => mx_append_sid($phpbb_root_path . 'faq.' . $phpEx),
			'title' => $lang['FAQ']
		);
		$nav_links['author'] = array (
			'url' => mx_append_sid($phpbb_root_path . 'memberlist.' . $phpEx),
			'title' => $lang['Memberlist']
		);

		//
		// Dummy include, to make all original phpBB functions available
		//
		include_once($mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx); // In case we need old functions...

		//
		// Is phpBB File Attachment MOD present?
		//
		if( file_exists($phpbb_root_path . 'attach_mod') )
		{
			include_once($phpbb_root_path . 'attach_mod/attachment_mod.' . $phpEx);
		}
		
		return;
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
	 * Setup style
	 *
	 * Define backend specific style defs
	 *
	 */
	function setup_style()
	{		
		$template = new mx_Template($this->mx_root_path . $this->template_path . $this->template_name);
		@define('IP_ROOT_PATH', $this->mx_root_path); //for ICY-PHOENIX Styles
		
		if (is_object($template))
		{
			if(is_dir($this->mx_root_path . $this->current_template_path . '/theme/images/'))
			{
				$current_template_images = $this->current_template_images = $this->current_template_path . "/theme/images";						
			}
			elseif(is_dir($this->mx_root_path . $this->current_template_path . '/images/'))
			{
				$current_template_images = $this->current_template_images = $this->current_template_path . "/images";					
			}			
			
			global $phpBB2;
			
			$phpbb_root_path = $this->mx_root_path;			
			
			$current_template_path = $this->template_path . $this->template_name;
			
			$cfg = array();
			//$row = $this->theme;
			
			/**
			/* session->setup_style( )
			**/
			unset($GLOBALS['TEMPLATE_CONFIG']);		
			$mx_template_config = false;			
			if(@file_exists(@$phpBB2->phpbb_realpath($mx_root_path . $this->template_path . $this->template_name . '/' . $this->template_name . '.cfg')) )
			{
				@include($mx_root_path . $this->template_path . $this->template_name . '/' . $this->template_name . '.cfg');
								
				if (!defined('TEMPLATE_CONFIG'))
				{
					//
					// Do not alter this line!
					//
					@define(TEMPLATE_CONFIG, TRUE);					
				}				
			}			
			elseif( @file_exists(@phpbb_realpath($mx_root_path . $this->template_path . $this->template_name . "/style.cfg")) )
			{
				//
				// Do not alter this line!
				//
				@define(TEMPLATE_CONFIG, TRUE);
				$cfg = parse_cfg_file($mx_root_path. $this->template_path . basename($this->template_name) . '/style.cfg');
				
				//		
				// - First try phpBB2 then phpBB3 template lang images then old Olympus image sets
				//		
				if ( file_exists($mx_root_path . $this->current_template_path . '/images/') )
				{
					$this->current_template_images = $this->current_template_path . '/images';
				}		
				else if ( file_exists($mx_root_path . $this->current_template_path  . '/theme/images/') )
				{		
					$this->current_template_images = $this->current_template_path  . '/theme/images';
				}		
				if ( file_exists($mx_root_path . $this->current_template_path  . '/imageset/') )
				{		
					$this->current_template_images = $this->current_template_path  . '/imageset';
				}
				
				$current_template_images = $this->current_template_images;
				
				$images['icon_quote'] = "$current_template_images/{LANG}/" . $this->img('icon_post_quote.gif', '', '', '', 'filename');
				$images['icon_edit'] = "$current_template_images/{LANG}/" . $this->img('icon_post_edit.gif', '', '', '', 'filename');			
				$images['icon_search'] = "$current_template_images/{LANG}/" . $this->img('icon_user_search.gif', '', '', '', 'filename');
				$images['icon_profile'] = "$current_template_images/{LANG}/" . $this->img('icon_user_profile.gif', '', '', '', 'filename');
				$images['icon_pm'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_pm.gif', '', '', '', 'filename');
				$images['icon_email'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_email.gif', '', '', '', 'filename');
				$images['icon_delpost'] = "$current_template_images/{LANG}/" . $this->img('icon_post_delete.gif', '', '', '', 'filename');
				$images['icon_ip'] = "$current_template_images/{LANG}/" . $this->img('icon_user_ip.gif', '', '', '', 'filename');
				$images['icon_www'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_www.gif', '', '', '', 'filename');
				$images['icon_icq'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_icq_add.gif', '', '', '', 'filename');
				$images['icon_aim'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_aim.gif', '', '', '', 'filename');
				$images['icon_yim'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_yim.gif', '', '', '', 'filename');
				$images['icon_msnm'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_msnm.gif', '', '', '', 'filename');
				$images['icon_minipost'] = "$current_template_images/" . $this->img('icon_post_target.gif', '', '', '', 'filename');
				$images['icon_gotopost'] = "$current_template_images/" . $this->img('icon_gotopost.gif', '', '', '', 'filename');
				$images['icon_minipost_new'] = "$current_template_images/" . $this->img('icon_post_target_unread.gif', '', '', '', 'filename');
				$images['icon_latest_reply'] = "$current_template_images/" . $this->img('icon_latest_reply.gif', '', '', '', 'filename');
				$images['icon_newest_reply'] = "$current_template_images/" . $this->img('icon_newest_reply.gif', '', '', '', 'filename');

				$images['forum'] = "$current_template_images/" . $this->img('forum_read.gif', '', '27', '', 'filename');
				$images['forum_new'] = "$current_template_images/" . $this->img('forum_unread.gif', '', '', '', 'filename');
				$images['forum_locked'] = "$current_template_images/" . $this->img('forum_read_locked.gif', '', '', '', 'filename');

				// Begin Simple Subforums MOD
				$images['forums'] = "$current_template_images/" . $this->img('forum_read_subforum.gif', '', '', '', 'filename');
				$images['forums_new'] = "$current_template_images/" . $this->img('forum_unread_subforum.gif', '', '', '', 'filename');
				// End Simple Subforums MOD

				$images['folder'] = "$current_template_images/" . $this->img('topic_read.gif', '', '', '', 'filename');
				$images['folder_new'] = "$current_template_images/" . $this->img('topic_unread.gif', '', '', '', 'filename');
				$images['folder_hot'] = "$current_template_images/" . $this->img('topic_read_hot.gif', '', '', '', 'filename');
				$images['folder_hot_new'] = "$current_template_images/" . $this->img('topic_unread_hot.gif', '', '', '', 'filename');
				$images['folder_locked'] = "$current_template_images/" . $this->img('topic_read_locked.gif', '', '', '', 'filename');
				$images['folder_locked_new'] = "$current_template_images/" . $this->img('topic_unread_locked.gif', '', '', '', 'filename');
				$images['folder_sticky'] = "$current_template_images/" . $this->img('topic_read_mine.gif', '', '', '', 'filename');
				$images['folder_sticky_new'] = "$current_template_images/" . $this->img('topic_unread_mine.gif', '', '', '', 'filename');
				$images['folder_announce'] = "$current_template_images/" . $this->img('announce_read.gif', '', '', '', 'filename');
				$images['folder_announce_new'] = "$current_template_images/" . $this->img('announce_unread.gif', '', '', '', 'filename');

				$images['post_new'] = "$current_template_images/{LANG}/" . $this->img('button_topic_new.gif', '', '', '', 'filename');
				$images['post_locked'] = "$current_template_images/{LANG}/" . $this->img('button_topic_locked.gif', '', '', '', 'filename');
				$images['reply_new'] = "$current_template_images/{LANG}/" . $this->img('button_topic_reply.gif', '', '', '', 'filename');
				$images['reply_locked'] = "$current_template_images/{LANG}/" . $this->img('icon_post_target_unread.gif', '', '', '', 'filename');

				$images['pm_inbox'] = "$current_template_images/" . $this->img('msg_inbox.gif', '', '', '', 'filename');
				$images['pm_outbox'] = "$current_template_images/" . $this->img('msg_outbox.gif', '', '', '', 'filename');
				$images['pm_savebox'] = "$current_template_images/" . $this->img('msg_savebox.gif', '', '', '', 'filename');
				$images['pm_sentbox'] = "$current_template_images/" . $this->img('msg_sentbox.gif', '', '', '', 'filename');
				$images['pm_readmsg'] = "$current_template_images/" . $this->img('topic_read.gif', '', '', '', 'filename');
				$images['pm_unreadmsg'] = "$current_template_images/" . $this->img('topic_unread.gif', '', '', '', 'filename');
				$images['pm_replymsg'] = "$current_template_images/{LANG}/" . $this->img('reply.gif', '', '', '', 'filename');
				$images['pm_postmsg'] = "$current_template_images/{LANG}/" . $this->img('msg_newpost.gif', '', '', '', 'filename');
				$images['pm_quotemsg'] = "$current_template_images/{LANG}/" . $this->img('icon_quote.gif', '', '', '', 'filename');
				$images['pm_editmsg'] = "$current_template_images/{LANG}/" . $this->img('icon_edit.gif', '', '', '', 'filename');
				$images['pm_new_msg'] = "";
				$images['pm_no_new_msg'] = "";

				$images['Topic_watch'] = "";
				$images['topic_un_watch'] = "";
				$images['topic_mod_lock'] = "$current_template_images/" . $this->img('topic_lock.gif', '', '', '', 'filename');
				$images['topic_mod_unlock'] = "$current_template_images/" . $this->img('topic_unlock.gif', '', '', '', 'filename');
				$images['topic_mod_split'] = "$current_template_images/" . $this->img('topic_split.gif', '', '', '', 'filename');
				$images['topic_mod_move'] = "$current_template_images/" . $this->img('topic_move.gif', '', '', '', 'filename');
				$images['topic_mod_delete'] = "$current_template_images/" . $this->img('topic_delete.gif', '', '', '', 'filename');

				$images['voting_graphic'][0] = "$current_template_images/voting_bar.gif";
				$images['voting_graphic'][1] = "$current_template_images/voting_bar.gif";
				$images['voting_graphic'][2] = "$current_template_images/voting_bar.gif";
				$images['voting_graphic'][3] = "$current_template_images/voting_bar.gif";
				$images['voting_graphic'][4] = "$current_template_images/voting_bar.gif";

				//
				// Vote graphic length defines the maximum length of a vote result
				// graphic, ie. 100% = this length
				//
				$board_config['vote_graphic_length'] = 205;
				$board_config['privmsg_graphic_length'] = 175;			
			}
		
			if (!defined('TEMPLATE_CONFIG'))
			{
				mx_message_die(CRITICAL_ERROR, "Could not open $this->template_name template config file", '', __LINE__, __FILE__, $sql);
			}
			
			$img_lang = (file_exists(@$phpBB2->phpbb_realpath($mx_root_path . $this->current_template_path . '/images/lang_' . $board_config['default_lang']))) ? $board_config['default_lang'] : 'english';
		
			while(list($key, $value) = @each($images))
			{
				if (!is_array($value))
				{
					$this->images[$key] = $images[$key] = str_replace('{LANG}', $this->img_lang_dir, $value);
				}
			}
		}
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

			//fix for mxp internal backend
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
				elseif ((@include $module_root_path . $language_filename) !== false)
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
		$args[0] = isset($lang[$key_found]) ? $lang[$key_found] : $key_found;
		return call_user_func_array('sprintf', $args);
		//return $this->lang_array($key, $args);
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
	*/
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
		$result = $db->sql_query($sql);
		$this->lang_id = (int) $db->sql_fetchfield('lang_id');
		$db->sql_freeresult($result);

		return $this->lang_id;
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
	function img_name_ext($img, $prefix = 'img_', $new_prefix = '', $type = 'filename')
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
		global $phpbb_root_path, $root_path, $theme;
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
				'img_'.$img => $img . '.' . $img_ext,
			);			
			unset($img_name, $image_filename);
		}
		
		if ($width !== false)
		{
			$this->img_array['image_width'] = array(
				'img_'.$img => $width,
			);	
		}		
				
		// print_r($this->img_array['image_filename']);
		// array ( [img_forum_read] => forum_read.gif )
		// Load phpBB Template configuration data
		$current_template_path = $this->current_template_path;
		$template_name = $this->template_name;
		
		//		
		// - First try phpBB2 then phpBB3 template
		//		
		if ( file_exists($phpbb_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg') )
		{
			@include($phpbb_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg'); 
			@define('TEMPLATE_CONFIG', true);
			
			//$img_keys = array_keys($images);
			//$img_values = array_values($images);
			
			$rows = $this->image_rows($images);
					
			foreach ($rows as $row)
			{
				$row['image_filename'] = rawurlencode($row['image_filename']);
				
				if(empty($row['image_name']))
				{
					//print_r('Your style configuration file has a typo! ');
					//print_r($phpbb_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg ');			
					//print_r($row);
					$row['image_name'] = 'spacer.gif';
				}
				/** 
				* Now check for the correct existance of all of the images into
				* each image of a prosilver based style. 
				*/
				$this->img_array[$row['image_name']] = $row;				
			}	
		}		
		else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/stylesheet.css') )
		{		
			@define('TEMPLATE_CONFIG', true);
			$current_template_images = $current_template_path . "/theme/images";
		}
		
		//
		// Since we have no current Template Config file, try the cloned template instead
		//
		if ( file_exists($phpbb_root_path . $this->cloned_current_template_path . '/' . $this->cloned_template_name . '.cfg') && !defined('TEMPLATE_CONFIG') )
		{
			$current_template_path = $this->cloned_current_template_path;
			$template_name = $this->cloned_template_name;

			@include($phpbb_root_path . $this->cloned_current_template_path . '/' . $this->cloned_template_name . '.cfg');
			
			$rows = $this->image_rows($images);
					
			foreach ($rows as $row)
			{
				$row['image_filename'] = rawurlencode($row['image_filename']);
				
				if(empty($row['image_name']))
				{
					print_r('Your style configuration file has a typo! ');
					print_r($phpbb_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg ');			
					print_r($row);
				}
				/** 
				* Now check for the correct existance of all of the images into
				* each image of a prosilver based style. 
				*/
				$this->img_array[$row['image_name']] = $row;				
			}	
		}
		
		//
		// Last attempt, use default template intead
		//
		if ( file_exists($phpbb_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg') && !defined('TEMPLATE_CONFIG') )
		{
			$current_template_path = $this->default_current_template_path;
			$template_name = $this->default_template_name;

			@include($phpbb_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg');
			
			$rows = $this->image_rows($images);
					
			foreach ($rows as $row)
			{
				$row['image_filename'] = rawurlencode($row['image_filename']);
				
				if(empty($row['image_name']))
				{
					print_r('Your style configuration file has a typo! ');
					print_r($phpbb_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg ');			
					print_r($row);
				}
				/** 
				* Now check for the correct existance of all of the images into
				* each image of a prosilver based style. 
				*/
				$this->img_array[$row['image_name']] = $row;				
			}			
		}		
		
		//		
		// - First try phpBB2 then phpBB3 template lang images then old Olympus image sets
		// default language		
		if ( file_exists($phpbb_root_path . $current_template_path . '/images/lang_' . $this->default_language_name . '/') )
		{
			$this->img_lang = $this->default_language_name;
		}		
		else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/images/lang_' . $this->default_language_name . '/') )
		{		
			$this->img_lang = $this->default_language_name;
		}		
		else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/images/' . $this->default_language . '/') )
		{		
			$this->img_lang = $this->default_language;
		}
		else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/imageset/' . $this->default_language . '/') )
		{		
			$this->img_lang = $this->default_language;
		}		
		
		//		
		// - First try phpBB2 then phpBB3 template lang images then old Olympus image sets
		// user language		
		if ( file_exists($phpbb_root_path . $current_template_path . '/images/lang_' . $this->user_language_name . '/') )
		{
			$this->img_lang = $this->user_language_name;
		}		
		else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/images/lang_' . $this->user_language_name . '/') )
		{		
			$this->img_lang = $this->user_language_name;
		}		
		else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/images/' . $this->user_language . '/') )
		{		
			$this->img_lang = $this->user_language;
		}
		else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/imageset/' . $this->user_language . '/') )
		{		
			$this->img_lang = $this->user_language;
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
			if (!isset($this->img_array['image_filename']['img_'.$img]) && !isset($this->img_array['image_filename'][$img]))
			{
				// Do not fill the image to let designers decide what to do if the image is empty
				$img_data = '';
				return $img_data;
			}
			
			if (isset($this->img_array['image_lang']['img_'.$img]) && isset($this->img_array['image_lang'][$img]))
			{
				//		
				// - First try phpBB2 then phpBB3 template lang images
				//		
				if ( file_exists($phpbb_root_path . $current_template_path . '/images/' . $this->img_array['image_lang']['img_'.$img] . '/') )
				{
					$current_template_images = $current_template_path . '/images/' . $this->img_array['image_lang']['img_'.$img];
				}		
				else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/images/' . $this->img_array['image_lang']['img_'.$img] . '/') )
				{		
					$current_template_images = $current_template_path . '/theme/images/' . $this->img_array['image_lang']['img_'.$img];
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
			
			$img_data['src'] = PHPBB_URL . $current_template_images  . '/' . (!empty($this->img_array['image_filename']['img_'.$img]) ? $this->img_array['image_filename']['img_'.$img] : $this->img_array['image_filename'][$img]);
			$img_data['width'] = !empty($height) ? $height : (!empty($this->img_array['image_width']) ? (!empty($this->img_array['image_width']['img_'.$img]) ? $this->img_array['image_width']['img_'.$img] : (!empty($this->img_array['image_width'][$img]) ? $this->img_array['image_width'][$img] : 47)) : 47);
			$img_data['height'] = !empty($height) ? $height : (!empty($this->img_array['image_height']) ? (!empty($this->img_array['image_width']['img_'.$img]) ? $this->img_array['image_height']['img_'.$img] : (!empty($this->img_array['image_height'][$img]) ? $this->img_array['image_height'][$img] : 47)) : 47);
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
		global $phpbb_root_path, $mx_root_path, $mx_images;
		
		//
		// Load phpBB Template configuration data
		// - First try current template
		//
		if ( file_exists( $phpbb_root_path . $this->current_template_path . "/images" ) )
		{
			$current_template_path = $this->current_template_path;
			$template_name = $this->template_name;

			@include($phpbb_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg');
		}

		//
		// Since we have no current Template Config file, try the cloned template instead
		//
		if ( file_exists( $phpbb_root_path . $this->cloned_current_template_path . "/images" ) && !defined('TEMPLATE_CONFIG') )
		{
			$current_template_path = $this->cloned_current_template_path;
			$template_name = $this->cloned_template_name;

			@include($phpbb_root_path . $this->cloned_current_template_path . '/' . $this->cloned_template_name . '.cfg');
		}

		//
		// Last attempt, use default template intead
		//
		if ( file_exists( $phpbb_root_path . $this->default_current_template_path . "/images" ) && !defined('TEMPLATE_CONFIG') )
		{
			$current_template_path = $this->default_current_template_path;
			$template_name = $this->default_template_name;

			@include($phpbb_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg');
		}

		$this->img_lang = (file_exists($phpbb_root_path . $current_template_path . $this->lang_name)) ? $this->lang_name : $board_config['default_lang'];		

		/* Here we overwrite phpBB images from the template configuration file with images from database  */
		
		$this->img_array['image_filename'] = array(
			'img_site_logo' => "logo.gif",
			'img_upload_bar' => "upload_bar.gif",
			'img_icon_contact_aim' => "icon_aim.gif",
			'img_icon_contact_email' => "icon_email.gif",
			'img_icon_contact_icq' => "icon_icq_add.gif",
			'img_icon_contact_jabber' => "icon_jabber.gif",
			'img_icon_contact_msnm' => "icon_msnm.gif",
			'img_icon_contact_pm' => "icon_pm.gif",
			'img_icon_contact_yahoo' => "icon_yim.gif",
			'img_icon_contact_www' => "icon_www.gif",
			'img_icon_post_delete' => "icon_delete.gif",
			'img_icon_post_edit' => "icon_edit.gif",
			'img_icon_post_info' => "icon_info.gif",
			'img_icon_post_quote' => "icon_quote.gif",
			'img_icon_post_report' => "icon_report.gif",
			'img_icon_user_online' => "icon_online.gif",
			'img_icon_user_offline' => "icon_offline.gif",
			'img_icon_user_profile' => "icon_profile.gif",
			'img_icon_user_search' => "icon_search.gif",
			'img_icon_user_warn' => "icon_warn.gif",
			'img_button_pm_forward' => "reply.gif",
			'img_button_pm_new' => "msg_newpost.gif",
			'img_button_pm_reply' => "reply.gif",
			'img_button_topic_locked' => "msg_newpost.gif",
			'img_button_topic_new' => "post.gif",
			'img_button_topic_reply' => "reply.gif",
			'img_forum_link' => "forum_link.gif",
			'img_forum_read' => "forum_read.gif",
			'img_forum_read_locked' => "forum_read_locked.gif",
			'img_forum_read_subforum' => "forum_read_subforum.gif",
			'img_forum_unread' => "forum_unread.gif",
			'img_forum_unread_locked' => "forum_unread_locked.gif",
			'img_forum_unread_subforum' => "forum_unread_subforum.gif",
			'img_topic_moved' => "topic_moved.gif",
			'img_topic_read' => "topic_read.gif",
			'img_topic_read_mine' => "topic_read_mine.gif",
			'img_topic_read_hot' => "topic_read_hot.gif",
			'img_topic_read_hot_mine' => "topic_read_hot_mine.gif",
			'img_topic_read_locked' => "topic_read_locked.gif",
			'img_topic_read_locked_mine' => "topic_read_locked_mine.gif",
			'img_topic_unread' => "topic_unread.gif",
			'img_topic_unread_mine' => "topic_unread_mine.gif",
			'img_topic_unread_hot' => "topic_unread_hot.gif",
			'img_topic_unread_hot_mine' => "topic_unread_hot_mine.gif",
			'img_topic_unread_locked' => "topic_unread_locked.gif",
			'img_topic_unread_locked_mine' => "topic_unread_locked_mine.gif",
			'img_sticky_read' => "sticky_read.gif",
			'img_sticky_read_mine' => "sticky_read_mine.gif",
			'img_sticky_read_locked' => "sticky_read_locked.gif",
			'img_sticky_read_locked_mine' => "ticky_read_locked_mine.gif",
			'img_sticky_unread' => "sticky_unread.gif",
			'img_sticky_unread_mine' => "sticky_unread_mine.gif",
			'img_sticky_unread_locked' => "sticky_unread_locked.gif",
			'img_sticky_unread_locked_mine' => "sticky_unread_locked_mine.gif",
			'img_announce_read' => "announce_read.gif",
			'img_announce_read_mine' => "announce_read_mine.gif",
			'img_announce_read_locked' => "announce_read_locked.gif",
			'img_announce_read_locked_mine' => "announce_read_locked_mine.gif",
			'img_announce_unread' => "announce_unread.gif",
			'img_announce_unread_mine' => "announce_unread_mine.gif",
			'img_announce_unread_locked' => "announce_unread_locked.gif",
			'img_announce_unread_locked_mine' => "announce_unread_locked_mine.gif",
			'img_global_read' => "announce_read.gif",
			'img_global_read_mine' => "announce_read_mine.gif",
			'img_global_read_locked' => "announce_read_locked.gif",
			'img_global_read_locked_mine' => "announce_read_locked_mine.gif",
			'img_global_unread' => "announce_unread.gif",
			'img_global_unread_mine' => "announce_unread_mine.gif",
			'img_global_unread_locked' => "announce_unread_locked.gif",
			'img_global_unread_locked_mine' => "announce_unread_locked_mine.gif",
			'img_subforum_read' => "", 
			'img_subforum_unread' => "",
			'img_pm_read' => "topic_read.gif",
			'img_pm_unread' => "topic_unread.gif",
			'img_icon_back_top' => "",
			'img_icon_post_target' => "icon_post_target.gif",
			'img_icon_post_target_unread' => "icon_post_target_unread.gif",
			'img_icon_topic_attach' => "icon_topic_attach.gif",
			'img_icon_topic_latest' => "icon_topic_latest.gif",
			'img_icon_topic_newest' => "icon_topic_newest.gif",
			'img_icon_topic_reported' => "icon_topic_reported.gif",
			'img_icon_topic_unapproved' => "icon_topic_unapproved.gif"			
		);
		
		$this->img_array['image_lang'] = array(
			'img_icon_post_edit' => $this->img_lang,
			'img_icon_post_quote' => $this->img_lang,
			'img_button_pm_forward' => $this->img_lang,
			'img_button_pm_new' => $this->img_lang,
			'img_button_pm_reply' => $this->img_lang,
			'img_button_topic_new' => $this->img_lang,
			'img_button_topic_reply' => $this->img_lang		
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

			$img_data['src'] = PHPBB_URL . $current_template_path . ($this->img_array[$img]['image_lang'] ? $this->img_array[$img]['image_lang'] .'/' : '') . $this->img_array[$img]['image_filename'];
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
			$var = ($data) ? $data : '230271'; //$this->data['user_options'];
			$this->keyvalues[$key] = ($var & 1 << $this->keyoptions[$key]) ? true : false;
		}

		return $this->keyvalues[$key];
	}

	/**
	* Set option bit field for user options
	*/
	function optionset($key, $value, $data = false)
	{
		$var = ($data) ? $data : '230271'; //$this->data['user_options'];

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
	 * Load available languages list
	 * author: Jan Kalah aka culprit_cz
	 * @return array available languages list: KEY = folder name
	 */
	function get_lang_list($ext_root_path = '')
	{
		if (count($this->language_list))
		{
			return $this->language_list;
		}
		/* c:\Wamp\www\Rhea\language\ */
		$dir = opendir($this->phpbb_root_path . 'language/');			
		while($f = readdir($dir))
		{
			if (($f == '.' || $f == '..') || !is_dir($this->phpbb_root_path . 'language/' . $f))
			{
				continue;
			}
			$this->language_list[$f] =  $this->ucstrreplace('lang_', '', $f);	
		}
		closedir($dir);
		if (!empty($ext_root_path))
		{	
			$dir = opendir($this->phpbb_root_path . 'ext/' . $ext_root_path . '/language/');			
			while($f = readdir($dir))
			{
				if (($f == '.' || $f == '..') || !is_dir($this->phpbb_root_path . 'ext/' . $ext_root_path . '/language/' . $f))
				{
					continue;
				}
				$this->ext_language_list[$f] =  $this->ucstrreplace('lang_', '', $f);	
			}
			closedir($dir);
			return $this->language_list = array_merge($this->ext_language_list, $this->language_list);
		}			
		return $this->language_list;
	}	
	
	/**
	 * encode_lang
	 *
	 * This function is used with phpBB2 backend to specify xml:lang  in overall headers (only two chars are allowed)
	 * Do not change!
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
}	

//
//Moved to functions.php
//This file is sometime included for this function 
//and so we keep it here for phpBB2 backend
//
if (!function_exists('append_sid'))
{
	//
	// Append $SID to a url. Borrowed from phplib and modified. This is an
	// extra routine utilised by the session code above and acts as a wrapper
	// around every single URL and form action. If you replace the session
	// code you must include this routine, even if it's empty.
	//
	function phpbb_append_sid($url, $non_html_amp = false)
	{
		global $SID;

		if ( !empty($SID) && !preg_match('#sid=#', $url) )
		{
			$url .= ((strpos($url, '?') !== false) ?  (($non_html_amp) ? '&' : '&amp;') : '?') . $SID;
		}

		return $url;
	}
}
?>