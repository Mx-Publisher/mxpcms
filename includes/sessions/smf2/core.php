<?php
/**
*
* @package Auth
* @version $Id: core.php,v 1.2 2014/07/07 20:36:53 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if (!defined('IN_PORTAL'))
{
	die("Hacking attempt");
}

// don't do anything if SMF is already loaded
if (defined('SMF'))
{
	return true;
}
// Get everything started up...
define('SMF', 'API');

/*
* First off, include common vanilla phpBB functions, from our shared dir
* Note: These functions will later be accessible wrapped as phpBBX::orig_functionname()
*/
include_once($mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx);
include_once($mx_root_path . 'includes/shared/phpbb3/includes/functions.' . $phpEx);

/*
* Instantiate Dummy phpBB Classes
**/
$phpBB2 = new phpBB2();
$phpBB3 = new phpBB3();

/**
* Backend specific tasks
*
* @package MX-Publisher
*/
class mx_backend
{
	/*
	* XS Template - use backend db settings
	*/
	var $edit_db = false;

	/**
	 * Validate backend
	 *
	 * Define Users/Group/Sessions backend, and validate
	 * Set $smf_root_path, $tplEx, $table_prefix
	 *
	 */
	function validate_backend()
	{
		global $db, $portal_config, $smf_root_path, $phpbb_root_path, $mx_root_path;
		global $board_settings, $table_prefix, $phpEx, $tplEx;
		
		/*
		* Define relative path to "SMF", and validate
		* $smf_root_path = $mx_root_path . 'forum/';
		*/
		$smf_root_path = $mx_root_path . $portal_config['portal_backend_path'];
		$phpbb_root_path = $mx_root_path . 'includes/shared/phpbb2/';
		str_replace("//", "/", $phpbb_root_path);		
		str_replace("//", "/", $smf_root_path);
		
		// SMF Is Intalled
		$portal_backend_valid_file = @file_exists($smf_root_path . "Settings.$phpEx");
		
		// Load the settings...  Settings.php (to get SMF settings)
		if ((@include $smf_root_path . "Settings.$phpEx") === false)
		{
			die('Settings file (Settings) ' . $smf_root_path . "Settings.$phpEx" . ' couldn\'t be opened.');
		}
		
		// Rename path keys and get internal mx-publisher names		
		$script_path = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($boarddir)) . '/';
		$source_path = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($sourcedir)) . '/';
		$cache_path = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($cachedir)) . '/';
		
		// Rename settings keys and get internal sitename/sitedesc		
		$board_settings = array(			
			'mtitle'			=> $mtitle, # Title for the Maintenance Mode message.
			'board_disable'		=> ($maintenance = 2) ? true : false, # Set to 1 to enable Maintenance Mode, 2 to make the forum untouchable. (you'll have to make it 0 again manually!)
			'board_disable_msg'	=> $mmessage = 'Okay faithful users...we\'re attempting to restore an older backup of the database...news will be posted once we\'re back!',		# Description of why the forum is in maintenance mode.

			'sitename'			=> $mbname, # The name of your forum. e.g. MXP-SMF Bakend Test Board
			'default_lang'		=> $language, # 'romanian-utf8, english';		# The default language file set for the forum.
			'server_url'		=> $boardurl, #'http://127.0.0.1/smf, http://mxp-smf.ro/forum';		# URL to your forum's folder. (without the trailing /!)
			'board_email'		=> $webmaster_email, #'noreply@myserver.com';		# Email address to send emails from. (like noreply@yourdomain.com.)
			'cookie_name'		=> $cookiename, #SMFCookie956
			
			'dbms_version'		=> $db_type, // 'mysql'
			#'dbhost'			=> $db_server, // 'localhost';
			#'dbname'			=> $db_name, // 'smf';
			#'dbuser'			=> $db_user, // 'root';
			#'dbpasswd'		=> $db_passwd, // '';
			#'ssi_user'			=> $ssi_db_user, // '';
			#'ssi_passwd'		=> $ssi_db_passwd, // '';
			'table_prefix'		=> $db_prefix, // 'smf_';
			'error_send'		=> $db_error_send, // 1;
			'last_error'		=> $db_last_error, // 0;				
			
			'script_path'		=> $script_path, # '\\Wamp\\www\\forum';	# The absolute path to the forum's folder. (not just '.'!)
			'source_path'		=> $source_path, # '\\Wamp\\www\\forum/Sources';	# Path to the Sources directory.
			'cache_path'		=> $cache_path, # '\\Wamp\\www\\forum/cache';	# Path to the cache directory.			
				
			'character_set'		=> $db_character_set,					
		);			
		
		// Define backend template extension
		//$tplEx = 'php';
		$tplEx = 'html';
		
		// Most database systems have not set UTF-8 as their default input charset.
		if (!empty($db_character_set))
		{		
			$db->sql_query('set_character_set', '
				SET NAMES ' . $board_settings['character_set'],
				array(
				)
			);		
		}
		// SMF Prefix table
		$table_prefix = $board_settings['table_prefix'];	
		// Validate db connection for backend
		$_result = $db->sql_query("SELECT value from " . $table_prefix . "settings WHERE variable = 'smfVersion'");
		$portal_backend_valid_db = $db->sql_numrows($_result) != 0;		
		return $board_settings && $portal_backend_valid_file && !empty($table_prefix) && $portal_backend_valid_db;
	}
	
	/**
	 * setup_backend
	 *
	 * Define some general backend definitions
	 * PORTAL_URL, PHPBB_URL, PORTAL_VERSION & $board_config
	 *
	 */
	function setup_backend()
	{
		global $portal_config, $board_config, $board_settings, $smf_root_path, $phpbb_root_path, $phpEx;
		
		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($portal_config['script_path']));
		$server_name = trim($portal_config['server_name']);
		$server_protocol = ( $portal_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = (($portal_config['server_port']) && ($portal_config['server_port'] <> 80)) ? ':' . trim($portal_config['server_port']) . '/' : '/';
		
		$server_url = $server_protocol . str_replace("//", "/", $server_name . $server_port . $script_name . '/'); //On some server the slash is not added and this trick will fix it
		
		define('PORTAL_URL', $server_url);
		define('PORTAL_VERSION', $portal_config['portal_version']);
		
		$board_config = array_merge($board_settings, $this->obtain_backend_config(false), $portal_config);
		
		// Now sync portal config mode snd board config
		$this->sync_configs();		
		
		$script_name_smf = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['server_url'])) . '/';		
		$script_name_phpbb = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim('includes/shared/phpbb2/')) . '/';
		
		$server_url_phpbb = $server_protocol . $server_name . $server_port . $script_name_phpbb;
		$server_url_smf = $server_protocol . $server_name . $server_port . $script_name_smf;
		
		define('PHPBB_URL', $server_url_phpbb);
		define('BOARD_URL', $server_url_smf);
		
		// Now sync Configs - In SMF mode, we rely on native configs, thus we need to sync mxp and smf settings	
		$this->sync_board_config_keys();
		//$this->sync_userdata();
		//global $mx_user;
		//$userdata = $mx_user->data;
		//print_r($userdata);
	}

	/**
	 * Sync Configs
	 * @access private
	 */
	function sync_configs()
	{
		global $portal_config, $board_config;

		foreach ($portal_config as $key => $value)
		{
			$do = true;
			switch ($key)
			{
				/*
				* Keep phpBB cookies/sessions
				*/
				case 'cookie_domain':
				case 'cookie_name':
				case 'cookie_path':
				case 'cookie_secure':
				case 'session_length':
				case 'allow_autologin':
				case 'max_autologin_time':
				case 'max_login_attempts':
				case 'login_reset_time':
					$do = false;
				break;
					
				/*
				* Keep phpBB stats
				*/
				case 'record_online_users':
				case 'record_online_date':
					$do = false;
				break;
					
				/*
				* Keep portal settings
				*/
				case 'default_style':
				case 'override_user_style':
				case 'default_lang':

				/*
				* Keep portal settings
				*/
				case 'allow_html':
				case 'allow_html_tags':
				case 'allow_bbcode':
				case 'allow_smilies':
				case 'smilies_path':
				
				/*
				* Keep portal settings
				*/
				case 'board_email':
				case 'board_email_sig':
				case 'smtp_delivery':
				case 'smtp_host':
				case 'smtp_username':
				case 'smtp_password':
				case 'smtp_auth_method':
				
				/*
				* Keep portal settings
				*/
				case 'default_dateformat':
				case 'board_timezone':
				case 'gzip_compress':
				
				/*
				* Keep portal settings
				*/
				case 'portal_id':
				case 'portal_status':
				case 'disabled_message':
				case 'script_path':
				case 'mx_use_cache':
				case 'mod_rewrite':
				case 'default_admin_style':
				case 'overall_header':
				case 'overall_footer':
				case 'main_layout':
				case 'navigation_block':
				case 'top_phpbb_links':
				case 'portal_version':
				case 'portal_recached':
				case 'portal_backend':
				case 'portal_startdate':
				case 'rand_seed':
				break;
					
				// Rename config keys and get internal sitename/sitedesc
				case 'portal_name':
				
					$key = 'sitename';
				break;
					
				case 'portal_desc':
				
					$key = 'site_desc';
				break;
			}
			if ($do)
			{
				$board_config[$key] = $value;
			}
		}
	}
	
	/**
	 * Sync Configs
	 * @access private
	 */
	function sync_board_config_keys()
	{
		global $board_config;	
		foreach ($board_config as $key => $value)
		{
			$do = true;
			switch ($key)
			{
				case 'smfVersion':
					$key = 'backend_version';
				break;
				
				case 'news':
					$key = 'backend_news';
				break;
				
				case 'compactTopicPagesContiguous':				
				case 'compactTopicPagesEnable':				
				case 'enableStickyTopics':				
				case 'todayMod':					
				case 'karmaMode':					
				case 'karmaTimeRestrictAdmins':					
				case 'enablePreviousNext':					
				case 'pollMode':				
				case 'enableVBStyleLogin':				
				case 'enableCompressedOutput':
				break;
				
				case 'karmaWaitTime':;					
				case 'karmaMinPosts':
				case 'karmaLabel':
				case 'karmaSmiteLabel':
				case 'karmaApplaudLabel':
				break;
				
				case 'attachmentSizeLimit':
				case 'attachmentPostLimit':
				case 'attachmentNumPerPostLimit':
				case 'attachmentDirSizeLimit':
				case 'attachmentUploadDir': //'E:\\Wamp\\www\\forum/attachments'':
				case 'attachmentExtensions': //'doc,gif,jpg,mpg,pdf,png,txt,zip'':
				case 'attachmentCheckExtensions': 
				case 'attachmentShowImages':
				
				case 'attachmentEnable':
					$key = 'allow_attachments';
				break;
				
				case 'attachmentEncryptFilenames':
				case 'attachmentThumbnails':
				case 'attachmentThumbWidth':
				case 'attachmentThumbHeight':
				
				case 'censorIgnoreCase':
				break;
				
				case 'mostOnline':
				case 'mostOnlineToday':
				case 'mostDate':
				break;
				
				case 'allow_disableAnnounce':
				case 'trackStats':
				break;
				
				case 'userLanguage':
					$key = 'default_lang';
				break;
				
				case 'titlesEnable':
				case 'topicSummaryPosts':
				case 'enableErrorLogging':
				break;
				
				case 'max_image_width':
				case 'max_image_height':
				break;
				
				case 'onlineEnable':
				break;
				
				case 'cal_enabled':
				case 'cal_maxyear':
				case 'cal_minyear':
				case 'cal_daysaslink':
				case 'cal_defaultboard':
				case 'cal_showholidays':
				case 'cal_showbdays':
				case 'cal_showevents':
				case 'cal_showweeknum':
				case 'cal_maxspan':
				break;
				
				//Keep native smtp keys
				case 'smtp_host':
				case 'smtp_port':
				case 'smtp_username':
				case 'smtp_password':
				break;
		
				case 'mail_type':
				break;
				
				case 'timeLoadPageEnable':
				break;
				
				case 'totalMembers':
				case 'totalTopics':
				case 'totalMessages':
				break;
				
				case 'simpleSearch':
				case 'censor_vulgar':
				case 'censor_proper':
				case 'enablePostHTML':
				break;
				
				case 'theme_allow':
				case 'theme_default':
				case 'theme_guests':
				break;
				
				case 'enableEmbeddedFlash':
				break;
				
				case 'xmlnews_enable':
				case 'xmlnews_maxlen':
				break;
				
				case 'hotTopicPosts':
				case 'hotTopicVeryPosts':
				break;
				
				case 'registration_method':
				break;
				
				case 'send_validation_onChange':
				case 'send_welcomeEmail':
				break;
				
				case 'allow_editDisplayName':
				case 'allow_hideOnline':
				break;
				
				case 'guest_hideContacts':
				case 'spamWaitTime':
				case 'pm_spam_settings':
				break;
				
				case 'reserveWord':
				case 'reserveCase':
				case 'reserveUser':
				case 'reserveName':
				case 'reserveNames': //'Admin\nWebmaster\nVizitator\nroot '':
				break;
				
				case 'autoLinkUrls':
				case 'banLastUpdated':
				break;
				
				case 'smileys_dir': //'E:\\Wamp\\www\\forum/Smileys'':
				case 'smileys_url': //'http://mxp-smf.ro/forum/Smileys'':
				break;
				
				case 'avatar_directory': //'E:\\Wamp\\www\\forum/avatars'':
				case 'avatar_url': //'http://mxp-smf.ro/forum/avatars'':
				case 'avatar_max_height_external':
				case 'avatar_max_width_external':
				case 'avatar_action_too_large': // option_html_resize'':
				case 'avatar_max_height_upload':
				case 'avatar_max_width_upload':
				case 'avatar_resize_upload':
				case 'avatar_download_png':
				break;
				
				case 'avatar_allow_server_stored':
					$key = 'allow_avatar_local';
				break;
				case 'avatar_allow_external_url':			
					$key = 'allow_avatar_remote';
				break;
				case 'avatar_allow_upload':			
					$key = 'allow_avatar_upload';
				break;
				
				case 'failed_login_threshold':
					//$key = 'failed_login_trys';
				//break;				
				case 'oldTopicDays':
				case 'edit_wait_time':
				case 'edit_disable_time':
				case 'autoFixDatabase':
				case 'allow_guestAccess':
				break;				
				case 'time_format': //'%B %d, %Y, %I:%M:%S %p'':
				break;				
				case 'number_format':
				break;				
				case 'enableBBC':
				break;				
				case 'max_messageLength':
				break;				
				case 'signature_settings':
				break;				
				case 'autoOptMaxOnline':
				break;				
				case 'defaultMaxMessages':
				case 'defaultMaxTopics':
				case 'defaultMaxMembers':
				break;				
				case 'enableParticipation':
				break;				
				case 'recycle_enable':
				break;				
				case 'recycle_board':
				break;				
				case 'maxMsgID':
				break;				
				case 'enableAllMessages':
				break;				
				case 'fixLongWords':
				break;				
				case 'knownThemes':
				break;				
				case 'who_enabled':
				break;				
				case 'time_offset':
					$key = 'user_timezone';	//default_timezone		
				break;				
				case 'cookieTime': //session_length				
				break;				
				case 'lastActive':
				break;
				
				case 'smiley_sets_known': //'default,aaron,akyhne'':
				case 'smiley_sets_names':
				case 'smiley_sets_default':
				break;
				
				case 'cal_days_for_index':
				case 'requireAgreement':
				case 'unapprovedMembers':
				case 'default_personal_text':
				case 'package_make_backups':
				break;
				
				case 'databaseSession_enable':
				case 'databaseSession_loose':
				case 'databaseSession_lifetime':
				break;
				
				case 'search_cache_size':
				case 'search_results_per_page':
				case 'search_weight_frequency':
				case 'search_weight_age':
				case 'search_weight_length':
				case 'search_weight_subject':
				case 'search_weight_first_message':
				case 'search_max_results':
				case 'search_floodcontrol_time':
				break;
				
				case 'permission_enable_deny':
				case 'permission_enable_postgroups':
				break;
				
				case 'mail_next_send':
				case 'mail_recent':
				break;
				
				case 'settings_updated':
				break;				
				case 'next_task_time':
				break;
				case 'warning_settings':
				case 'warning_watch':
				case 'warning_moderate':
				case 'warning_mute':
				break;
				
				case 'admin_features':
				case 'last_mod_report_action':
				case 'pruningOptions': //'30,180,180,180,30,0'':
				break;
				
				case 'cache_enable':
				break;
				
				case 'reg_verification':
				case 'visual_verification_type':
				case 'enable_buddylist':
				break;
				
				case 'birthday_email': //'happy_birthday''
				break;
				
				case 'dont_repeat_theme_core':
				case 'dont_repeat_smileys_20':
				case 'dont_repeat_buddylists':
				break;
				
				case 'attachment_image_reencode':
				case 'attachment_image_paranoid':
				case 'attachment_thumb_png':
				break;
				
				case 'avatar_reencode':
				case 'avatar_paranoid':
				break;
				
				case 'global_character_set': //'UTF-8'':
				break;
				
				case 'default_timezone': //'Etc/GMT0'':
				break;
				
				case 'memberlist_updated': //'1399819671'':
				break;
				
				case 'latestMember':
				break;
				
				case 'latestRealName': //'Admin'':
				break;
				
				case 'rand_seed': //'1838372837''
				break;
				
				case 'mostOnlineUpdated': //'2014-05-14'':
				break;
				
				/*
				* Sync 
				**/
				// Rename config keys and get internal sitename/sitedesc
				case 'mbname':			
					$key = 'sitename';
				break;			

				case 'titlesEnable':			
					$key = 'allow_namechange';
				break;				
				/*
				case 'attachmentEnable':			
					$key = 'allow_pm_attach';
				break;
				*/
				case 'attachmentEnable':				
					$key = 'allow_attachments';
				break;
				case 'allow_avatar_local':
					$key = 'avatar_allow_server_stored';
				break;
				case 'allow_avatar_remote':			
					$key = 'avatar_allow_external_url';
				break;
				case 'allow_avatar_upload':			
					$key = 'avatar_allow_upload';
				break;
				/*
				case 'enableBBC':		
					$key = 'allow_sig_bbcode';
				break;
				*/
				case 'enableBBC':				
					$key = 'allow_bbcode';
				break;				
				case 'enableEmbeddedFlash':				
					$key = 'allow_sig_flash';
				break;
				/*
				case 'enablePostHTML':
					$key = 'allow_sig_html';
				break;
				*/
				case 'enablePostHTML':				
					$key = 'allow_html';
				break;
				/*
				case 'smiley_enable':		
					$key = 'allow_sig_smilies';
				break;
				case 'smiley_enable':			
					$key = 'auth_smilies_pm';
				break;				
				*/
				case 'smiley_enable':	
					$key = 'allow_smilies';
				break;						
				case 'attachmentDirSizeLimit':
					$key = 'attachment_quota';
				break;
				case 'enableBBC':	
					$key = 'auth_bbcode_pm';
				break;
				case 'auth_flash_pm':				
					$key = 'enableEmbeddedFlash';
				break;				
				//Get this later from Settings.php or from smileys_dir or from smileys_url -  = 'Smileys/default/';
				case 'smilies_path':
				break;				
				case 'avatar_max_height_external':
					$key = 'avatar_max_height';
				break;
				case 'avatar_max_width_external':
					$key = 'avatar_max_width';
				break;						
				
				// Keep portal settings/
				case 'requireAgreement':
					$key = 'coppa_enable';
				break;
				case 'time_format':
					// = smf_convert_dateformat(time_format); // this work?
					$key = 'default_dateformat';
				break;
				case 'edit_wait_time':
					$key = 'edit_time';
				break;
				case 'disable_visual_verification':
					$key = 'enable_confirm';
				break;
				case 'spamWaitTime':
					$key = 'flood_interval';
				break;
				case 'enableCompressedOutput':
					$key = 'gzip_compress';
				break;
				case 'hotTopicPost':
					$key = 'shot_threshold';
				break;
				case 'who_enabled':
					$key = 'load_online';
				break;
				case 'onlineEnable':
					$key = 'load_onlinetrack';
				break;
				case 'failed_login_threshold':
					$key = 'max_login_attempts';
				break;
				case 'max_messageLength':
					$key = 'max_post_chars';
				break;
				case 'latestRealName':
					$key = 'newest_username';
				break;
				case 'latestMember':
					$key = 'newest_user_id';
				break;
				case 'totalMessages':
					$key = 'num_posts';
				break;
				case 'totalTopics':
					$key = 'num_topics';
				break;
				case 'memberCount':
					$key = 'num_users';
				break;
				case 'defaultMaxMessages':
					$key = 'posts_per_page';
				break;
				case 'mostDate':
					$key = 'record_online_date'; // || mostOnlineUpdated
				break;
				case 'mostOnline':
					$key = 'record_online_users';
				break;
				case 'registration_method':
					$key = 'require_activation';
				break;
				case 'databaseSession_lifetime':
					$key = 'session_length';
				break;
				case 'defaultMaxTopics':
					$key = 'topics_per_page';		
				break;				
			}
			if ($do)
			{
				$board_config[$key] = $value;
			}
		}
	}
	
	/**
	* Extract the variables defined in a configuration file
	* @todo As noted by Xore we need to look at this from a security perspective
	*/
	function get_config_var($var)
	{
		//Backend  specific vars
		global $smf_root_path;
		$backend_filename = "Settings.php";
		$backend_path = $smf_root_path;
		
		/**
		* Access a hardcoded configuration file
		*/		
		static $vars;
		if (empty($vars))
		{
			global $convert;
			if ((@include $smf_root_path . $backend_filename) === false)
			{
				install_die(GENERAL_ERROR, 'Configuration file ' . $smf_root_path . $backend_filename . ' couldn\'t be opened.');
			}
			
			// If we are on PHP < 5.0.0 we need to force include or we get a blank page
			if (version_compare(PHP_VERSION, '5.0.0', '<')) 
			{		
				$db_type = str_replace('mysqli', 'mysql4', $db_type); //this version of php does not have mysqli extension and my crash the installer if finds a forum using this		
			}
			
			// If the UTF-8 setting was enabled, add it to the table definitions.
			if ($db_character_set == 'utf8') 
			{		
				$db_type = str_replace('mysql', 'mysql4', $db_type);		
			}
		}
		$vars = get_defined_vars();
		//unset($vars['backend_filename']);
				
		return (isset($vars[$var])) ? $vars[$var]: false;
	}

	/**
	* Extract the variables defined in a configuration file
	* @todo As noted by Xore we need to look at this from a security perspective
	*/
	function get_config_vars()
	{
		//Backend  specific vars
		global $smf_root_path;
		$backend_filename = "Settings.php";
		$backend_path = $smf_root_path;
		
		/**
		* Access a hardcoded configuration file
		*/		
		static $vars;
		if (empty($vars))
		{
			global $convert;
			if ((@include $smf_root_path . $backend_filename) === false)
			{
				install_die(GENERAL_ERROR, 'Configuration file ' . $smf_root_path . $backend_filename . ' couldn\'t be opened.');
			}
			
			// If we are on PHP < 5.0.0 we need to force include or we get a blank page
			if (version_compare(PHP_VERSION, '5.0.0', '<')) 
			{		
				$db_type = str_replace('mysqli', 'mysql4', $db_type); //this version of php does not have mysqli extension and my crash the installer if finds a forum using this		
			}
			
			// If the UTF-8 setting was enabled, add it to the table definitions.
			if ($db_character_set == 'utf8') 
			{		
				$db_type = str_replace('mysql', 'mysql4', $db_type);		
			}
		}
		$vars = get_defined_vars();
		//unset($vars['backend_filename']);
				
		return $vars[$var];
		/*
		'dbms'			=> $db_type, // 'mysql'
		'dbhost'			=> $db_server, // 'localhost';
		'dbname'			=> $db_name, // 'smf';
		'dbuser'			=> $db_user, // 'root';
		'dbpasswd'			=> $db_passwd, // '';
		'ssi_dbuser'		=> $ssi_db_user, // '';
		'ssi_dbpasswd'		=> $ssi_db_passwd, // '';
		'table_prefix'		=> $db_prefix, // 'smf_';
		'dbpersist'			=> $db_persist, // 0;
		'dberror_send'		=> $db_error_send, // 1;
		'dbcharacter_set'	=> $db_character_set,		
		'acm_type'			=> '',
		'mtitle'			=> $mtitle, //# Title for the Maintenance Mode message.
		'status'			=> ($maintenance != 2) ? true : false, # Set to 1 to enable Maintenance Mode, 2 to make the forum untouchable. (you'll have to make it 0 again manually!)
		'mbname'			=> $mbname, # The name of your forum.
		'language'			=> $language, // 'english';		# The default language file set for the forum.
		'boardurl'			=> $boardurl, // 'http://127.0.0.1/smf';		# URL to your forum's folder. (without the trailing /!)
		'webmaster_email'	=> $webmaster_email, // 'noreply@myserver.com';		# Email address to send emails from. (like noreply@yourdomain.com.)
		'cookiename'		=> $cookiename,
		*/
	}	

	/**
	 * load_file
	 *
	 * @param unknown_type $force_shared
	 * @access private
	 */
	function load_file($force_shared)
	{
		global $mx_root_path, $phpbb_root_path, $phpEx;
		
		$backend = in_array($force_shared, array('internal', 'phpbb2', 'smf2', 'mybb', 'phpbb3', 'olympus', 'ascraeus', 'rhea')) ? $force_shared : PORTAL_BACKEND;
		switch ($backend)
		{
			case 'internal':
			case 'phpbb2':
			case 'smf2':
			case 'mybb':
				$path = $mx_root_path . 'includes/shared/phpbb2/includes/';
			break;
					
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
				$path = $mx_root_path . 'includes/shared/phpbb3/includes/';
			break;
		}
		return $path;
	}
	
	/**
	 * dss_rand
	 *
	 * @param unknown_type $force_shared
	 * @access private
	 */
	function dss_rand()
	{
		global $db, $portal_config, $board_config, $lang, $dss_seeded;

		$val = $portal_config['rand_seed'] . microtime();
		$val = md5($val);
		$portal_config['rand_seed'] = md5($portal_config['rand_seed'] . $val . 'a');
		
		if($dss_seeded !== true)
		{
			$sql = "UPDATE " . PORTAL_TABLE . " SET
				rand_seed = '" . $portal_config['rand_seed'] . "'
				WHERE portal_id = '1'";
				
			//display an error debuging message only if the portal is installed/upgraded 
			if(!@$db->sql_query($sql) && @!file_exists('install'))
			{
				mx_message_die(GENERAL_ERROR, "Unable to reseed PRNG", "", __LINE__, __FILE__, $sql);
			}
			elseif(!@$db->sql_query($sql) && @file_exists('install'))
			{
				mx_message_die(GENERAL_ERROR, "Unable to reseed PRNG"."<br />Please finish upgrading and <br />". t(isset($lang['Please_remove_install_contrib'])), "", __LINE__, __FILE__, $sql);
			}
			
			$dss_seeded = true;
		}

		return substr($val, 4, 16);
	}

	/**
	 * Backend specific Page Header data
	 *
	 * @param unknown_type $mode
	 */
	function page_header($mode = false)
	{
		global $db, $mx_root_path, $phpbb_root_path, $userdata, $mx_user, $lang, $images, $phpEx;
		global $board_config, $gen_simple_header, $layouttemplate, $mx_page;

		switch ($mode)
		{
			case 'generate_login_logout_stats':

				if ( $userdata['session_logged_in'] )
				{
					$is_logged = true;
					$u_login_logout = 'login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];
					$l_login_logout = $lang['Logout'] . ' [ ' . $userdata['username'] . ' ]';
				}
				else
				{
					$is_logged = false;
					$u_login_logout = 'login.'.$phpEx;
					$l_login_logout = $lang['Login'];
				}

				$s_last_visit = ( $userdata['session_logged_in'] ) ? phpBB2::create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']) : '';

				/*
				/* Obtain number of new private messages
				/* if user is logged in
				*/
				if ( ($userdata['session_logged_in']) && (empty($gen_simple_header)) )
				{
					if ( $userdata['new_pm'] )
					{
						$l_message_new = ( $userdata['new_pm'] == 1 ) ? $lang['New_pm'] : $lang['New_pms'];
						$l_privmsgs_text = sprintf($l_message_new, $userdata['new_pm']);

						if ( $userdata['id_msg_last_visit'] > $userdata['last_login'] )
						{
							$sql = "UPDATE " . USERS_TABLE . "
								SET id_msg_last_visit = " . $userdata['last_login'] . "
								WHERE id_member = " . $userdata['user_id'];
							if ( !$db->sql_query($sql) )
							{
								mx_message_die(GENERAL_ERROR, 'Could not update private message new/read time for user', '', __LINE__, __FILE__, $sql);
							}

							$s_privmsg_new = 1;
							$icon_pm = $images['pm_new_msg'];
						}
						else
						{
							$s_privmsg_new = 0;
							$icon_pm = $images['pm_no_new_msg'];
						}
						$mx_priv_msg = $lang['Private_Messages'] . ' (' . $userdata['user_new_privmsg'] . ')';
					}
					else
					{
						$l_privmsgs_text = $lang['No_new_pm'];

						$s_privmsg_new = 0;
						$icon_pm = $images['pm_no_new_msg'];
						$mx_priv_msg = $lang['Private_Messages'];
					}

					if ( $userdata['user_unread_privmsg'] )
					{
						$l_message_unread = ( $userdata['user_unread_privmsg'] == 1 ) ? $lang['Unread_pm'] : $lang['Unread_pms'];
						$l_privmsgs_text_unread = sprintf($l_message_unread, $userdata['user_unread_privmsg']);
					}
					else
					{
						$l_privmsgs_text_unread = $lang['No_unread_pm'];
					}
				}
				else
				{
					$icon_pm = $images['pm_no_new_msg'];
					$l_privmsgs_text = $lang['Login_check_pm'];
					$l_privmsgs_text_unread = '';
					$s_privmsg_new = 0;
					$mx_priv_msg = $lang['Private_Messages'];
				}

				$layouttemplate->assign_vars(array(
					'U_LOGIN_LOGOUT' => mx_append_sid(PORTAL_URL . $u_login_logout),
					'L_LOGIN_LOGOUT' => $l_login_logout,
					'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], $s_last_visit),

					'PRIVATE_MESSAGE_INFO' => $l_privmsgs_text,
					'PRIVATE_MESSAGE_INFO_UNREAD' => $l_privmsgs_text_unread,
					'PRIVATE_MESSAGE_NEW_FLAG' => $s_privmsg_new,
					'PRIVMSG_IMG' => $icon_pm,
					'L_PRIVATEMSGS' => $mx_priv_msg,

					// Backend
					'PHPBB' => false,

					// Show phpbb stats?
					'PHPBB_STATS' => false,

					// Allow autologin?
					'ALLOW_AUTOLOGIN' => false,

					// phpBB PM
					'ENABLE_PM_POPUP' => false,
				));

				break;

			case 'generate_nav_links':

				/*
				$u_register = 'profile.'.$phpEx.'?mode=register' ;
				$u_profile = 'profile.'.$phpEx.'?mode=editprofile';
				$u_privatemsgs = 'privmsg.'.$phpEx.'?folder=inbox';
				$u_privatemsgs_popup = 'privmsg.'.$phpEx.'?mode=newpm';
				$u_search = 'search.'.$phpEx;
				$u_memberlist = 'memberlist.'.$phpEx;
				$u_modcp = 'modcp.'.$phpEx;
				$u_faq = 'faq.'.$phpEx;
				$u_viewonline = 'viewonline.'.$phpEx;
				$u_group_cp = 'groupcp.'.$phpEx;
				$u_sendpassword = mx3_append_sid("{$phpbb_root_path}profile.$phpEx", 'mode=sendpassword');

				$layouttemplate->assign_vars(array(
					'U_REGISTER' => mx_append_sid(PHPBB_URL . $u_register),
					'U_PROFILE' => mx_append_sid(PHPBB_URL . $u_profile),
					'U_PRIVATEMSGS' => mx_append_sid(PHPBB_URL . $u_privatemsgs),
					'U_PRIVATEMSGS_POPUP' => mx_append_sid(PHPBB_URL . $u_privatemsgs_popup),
					'U_SEARCH' => mx_append_sid(PHPBB_URL . $u_search),
					'U_MEMBERLIST' =>mx_append_sid(PHPBB_URL . $u_memberlist),
					'U_MODCP' => mx_append_sid(PHPBB_URL . $u_modcp),
					'U_FAQ' => mx_append_sid(PHPBB_URL . $u_faq),
					'U_VIEWONLINE' => mx_append_sid(PHPBB_URL . $u_viewonline),
					'U_GROUP_CP' => mx_append_sid(PHPBB_URL . $u_group_cp),
					'U_SEND_PASSWORD' => $u_sendpassword,
				));
				*/

				break;
		}
	}

	/**
	 * Backend specific Page Tail data
	 *
	 * @param unknown_type $mode
	 */
	function page_tail($mode = false)
	{
		global $board_config, $userdata, $template;

		switch ($mode)
		{
			case 'generate_backend_version':

				$template->assign_vars(array(
					'PHPBB_BACKEND'				=> false,
					'U_PHPBB_ROOT_PATH' 		=> PHPBB_URL,
				));

				break;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @access public
	 * @param boolean $use_cache
	 * @return unknown
	 */
	function obtain_backend_config($use_cache = true)
	{
		global $db, $mx_cache;

		if (($config = $mx_cache->get('smf_config')) && ($use_cache) )
		{
			return $config;
		}
		else
		{
			$sql = "SELECT *
				FROM " . CONFIG_TABLE;
				
			if ( !($result = $db->sql_query($sql)))
			{
				if (!function_exists('mx_message_die'))
				{
					die("Couldnt query config information, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
				}
				else
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt query config information', '', __LINE__, __FILE__, $sql );
				}
			}
			while ( $row = $db->sql_fetchrow($result) )
			{
				$config[$row['variable']] = $row['value'];
			}
			$db->sql_freeresult($result);
			
			if ($use_cache)
			{
				$mx_cache->put('smf_config', $config);
			}
			return ($config);
		}
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function generate_group_select_sql()
	{
		$sql = "SELECT group_id, group_name
			FROM " . GROUPS_TABLE . "
			WHERE group_single_user <> " . TRUE . "
			ORDER BY group_name ASC";
		return $sql;
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function generate_session_online_sql($guest = false)
	{
		if ($guest)
		{
			$sql = "SELECT *
				FROM " . SESSIONS_TABLE . "
				WHERE session_logged_in = 0
					AND session_time >= " . ( time() - 300 ) . "
				ORDER BY session_time DESC";
		}
		else
		{
			$sql = "SELECT u.*, s.*
				FROM " . USERS_TABLE . " u, " . SESSIONS_TABLE . " s
				WHERE s.session_logged_in = " . TRUE . "
					AND u.id_member = s.session_user_id
					AND u.id_member <> " . ANONYMOUS . "
					AND s.session_time >= " . ( time() - 300 ) . "
				ORDER BY u.user_session_time DESC";
		}
		return $sql;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $str_ip
	 * @return unknown
	 */
	function decode_ip($str_ip)
	{
		return phpBB2::decode_ip($str_ip);
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function get_backend_version()
	{
		return '';
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function confirm_backend()
	{
		global $portal_config;

		return PORTAL_BACKEND == $portal_config['portal_backend'];
	}

	/**
	* Get username details for placing into templates.
	*
	* @param string $mode Can be profile (for getting an url to the profile), username (for obtaining the username), colour (for obtaining the user colour) or full (for obtaining a html string representing a coloured link to the users profile).
	* @param int $user_id The users id
	* @param string $username The users name
	* @param string $username_colour The users colour
	* @param string $guest_username optional parameter to specify the guest username. It will be used in favor of the GUEST language variable then.
	* @param string $custom_profile_url optional parameter to specify a profile url. The user id get appended to this url as &amp;u={user_id}
	*
	* @return string A string consisting of what is wanted based on $mode.
	*/
	function get_username_string($mode, $user_id, $username = false, $user_color = false, $guest_username = false, $custom_profile_url = false)
	{
		global $lang, $userdata;

		$lang['Guest'] = !$guest_username ? $lang['Guest'] : $guest_username;

		$this_userdata = mx_get_userdata($user_id, false);
		$username = ($username) ? $username : $this_userdata['username'];

		if ($this_userdata['user_level'] == ADMIN)
		{
			$user_color = $theme['fontcolor3'];
			$user_style = 'style="color:#' . $user_color . '; font-weight : bold;"';
		}
		else if ($this_userdata['user_level'] == MOD)
		{
			$user_color = $theme['fontcolor2'];
			$user_style = 'style="color:#' . $user_color . '; font-weight : bold;"';
		}
		else
		{
			$user_colour = $theme['fontcolor1'];
			$topic_poster_style = 'style="font-weight : bold;"';
		}

		$profile_url = $username;

		$full_url = (($user_id == ANONYMOUS) || ($user_id == MUSIC_GUEST)) ? '<span ' . $topic_poster_style . '>' . $lang['Guest'] . '</span>' : '<span ' . $topic_poster_style . '>' . $username . '</span>';

		switch ($mode)
		{
			case 'profile':
				return $profile_url;
			break;

			case 'username':
				return $username;
			break;

			case 'colour':
				return $user_colour;
			break;

			case 'full':
			default:
				return $full_url;
			break;
		}
		return $username;
	}

	//
	// ACP
	//
	/**
	 * Enter description here...
	 *
	 */
	function load_backend_acp_menu()
	{

	}

	/**
	 * Enter description here...
	 *
	 */
	function load_forum_stats()
	{

	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function backend_version_check()
	{
		return '';
	}

}

//
// Now load some bbcodes, to be extended for this backend (see below)
//
include_once($mx_root_path . 'includes/sessions/smf2/bbcode.'.$phpEx); // BBCode associated functions
?>