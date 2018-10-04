<?php
/**
*
* @package Auth
* @version $Id: core.php,v 1.29 2014/05/16 18:02:23 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

//
// First off, include common vanilla phpBB functions, from our shared dir
// Note: These functions will later be accessible wrapped as phpBBX::orig_functionname()
//
include_once($mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx);



//
// Finally, load some backend specific functions
//
include_once($mx_root_path . 'includes/sessions/internal/functions.' . $phpEx);

//
// Load here Backend Permissions if this is required
//

//
// Init the auth class if this is required
//

//
// Instantiate Dummy Forum Specific Shared Classes
// Moved in common.php


/**
* Backend specific tasks
*
* @package MX-Publisher
*/
class mx_backend
{
	//
	// XS Template - use backend db settings
	//
	var $edit_db = false;
	var $page_id = 1;
	var $user_ip = 'ffffff';
	
	/***/
	function mx_backend()
	{	
		// Obtain and encode users IP
		// from MXP 2.7.x common
		// I'm removing HTTP_X_FORWARDED_FOR ... this may well cause other problems such as
		// private range IP's appearing instead of the guilty routable IP, tough, don't
		// even bother complaining ... go scream and shout at the idiots out there who feel
		// "clever" is doing harm rather than good ... karma is a great thing ... :)
		//
		$this->client_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : getenv('REMOTE_ADDR') );
		$ip_sep = explode('.', $this->client_ip);
		$this->user_ip = sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);	
	}	
	/***/
	 
	/**
	 * Validate backend
	 *
	 * Define Users/Group/Sessions backend, and validate
	 * Set i.e. $phpbb_root_path, $tplEx, $table_prefix
	 *
	 */
	function validate_backend()
	{
		global $db, $portal_config, $phpbb_root_path, $mx_root_path;
		global $table_prefix, $phpEx, $tplEx;

		//
		// Define backend template extension
		//
		$tplEx = 'tpl';
		
		//
		// Define relative path to phpBB, and validate
		//
		$phpbb_root_path = $mx_root_path . 'includes/shared/phpbb2/';
		str_replace("//", "/", $phpbb_root_path);
		$portal_backend_valid_file = @file_exists($phpbb_root_path . "includes/functions.$phpEx");
		
		return $portal_backend_valid_file;
	}

	/**
	 * $mx_backend->setup_backend()
	 *
	 * Define some general backend definitions
	 * PORTAL_URL, PHPBB_URL, PORTAL_VERSION & $board_config
	 *
	 */
	function setup_backend()
	{
		global $mx_cache, $portal_config, $board_config, $mx_root_path, $phpbb_root_path, $phpEx, $db;
			
		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($portal_config['script_path']));
		$server_name = trim($portal_config['server_name']);
		$server_protocol = ( $portal_config['cookie_secure'] ) ? 'http://' : 'http://';
		$server_port = (($portal_config['server_port']) && ($portal_config['server_port'] <> 80)) ? ':' . trim($portal_config['server_port']) . '/' : '/';
		$portal_config['portal_phpbb_url'] = str_replace("//", "/", $server_name . $server_port . $script_name . '/');
		$server_url = $server_protocol . str_replace("//", "/", $server_name . $server_port . $script_name . '/'); //On some server the slash is not added and this trick will fix it

		//
		// Grab phpBB global variables, re-cache if necessary
		// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the MX-Publisher cache whenever updating phpBB config settings
		// - true: enable cache, false: disable cache
		if (empty($board_config['script_path']))
		{
			$board_config = $mx_cache->obtain_mxbb_config(false);
		}
		
		if (empty($portal_config['portal_version']))
		{
			$portal_config = $mx_cache->obtain_mxbb_config(false);
		}
		/**		
		$this->data = !empty($this->data['user_id']) ? $this->data : $mx_user->session_pagestart($user_ip, $page_id);
		
		$this->cache = is_object($mx_cache) ? $mx_cache : new base();
		*/		
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
		//$this->session_id = $this->data['session_id'];		
		$this->lang_path = $phpbb_root_path . 'language/';
			
		$script_name = !empty($board_config['server_name']) ? preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['server_name'])) : 'localhost';
		$server_protocol = ( $board_config['cookie_secure'] ) ? 'http://' : 'http://';
		$server_port = (($board_config['server_port']) && ($board_config['server_port'] <> 80)) ? ':' . trim($portal_config['server_port']) . '/' : '/';
		$script_name_phpbb = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])) . '/';		
		
		if (!empty($portal_config['portal_url']))
		{
			$corrected_url = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($portal_config['portal_url'])) . '/';
		}
		else		
		{
			$corrected_url = str_replace(array('phpBB/', $script_name_phpbb, str_replace('./../', '', $phpbb_root_path)), '', $portal_config['portal_phpbb_url'] . '/');
			$corrected_url = (empty($portal_config['portal_phpbb_url'])  || preg_match('@^(?:phpbb.com)?([^/]+)@i', $portal_config['portal_phpbb_url'])) ? $server_protocol . str_replace("//", "/", $server_name . $server_port . $script_name . '/') : str_replace(array('http://', 'http://'), $server_protocol, $server_url) ; //On some server the slash is not added and this trick will fix it	
		}		
		
		$board_url = $server_url;
		
		define('PORTAL_VERSION', $portal_config['portal_version']);
		
		$server_url_phpbb = $server_protocol . (isset($server_name) ? $server_name : $script_name) . $server_port . $script_name_phpbb;
		
		if (empty($portal_config['portal_phpbb_url'])  || preg_match('@^(?:phpbb.com)?([^/]+)@i', $portal_config['portal_phpbb_url']))
		{
			$portal_config['portal_phpbb_url'] = !empty($portal_config['portal_url']) ? $server_url . $script_name_phpbb : $server_url_phpbb;
		}		
		
		$server_url_phpbb = !empty($portal_config['portal_phpbb_url']) ? $server_url . $script_name_phpbb : $server_url_phpbb;				
		$server_url_phpbb = (empty($portal_config['portal_phpbb_url']) || preg_match('@^(?:phpbb.com)?([^/]+)@i', $portal_config['portal_phpbb_url'])) ? $server_url_phpbb : $portal_config['portal_phpbb_url'];	
		
		define('PHPBB_URL', $server_url_phpbb);
		define('PORTAL_URL', $board_url);		
		define('BOARD_URL', $server_url);	
		
		$web_path = (isset($portal_config['portal_url'])) ? $board_url : $corrected_url;		
		
		//
		// Define backend template extension
		//
		$tplEx = 'tpl';
		if (!defined('TPL_EXT')) define('TPL_EXT', $tplEx);
		
		//
		// Now sync Configs
		// In phpBB mode, we rely on native phpBB configs, thus we need to sync mxp and phpbb settings
		//
		$this->sync_configs();

		//
		// Dummy include, to make all original phpBB functions available
		// In case we need old functions...
		include_once($mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx); 
		include_once($mx_root_path . 'includes/shared/phpbb3/includes/functions.' . $phpEx);
		//
		// Is phpBB File Attachment MOD present?
		//
		if( file_exists($phpbb_root_path . 'attach_mod') )
		{
			include_once($phpbb_root_path . 'attach_mod/attachment_mod.' . $phpEx);
		}
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
				//
				// Keep phpBB cookies/sessions
				//
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

				//
				// Keep phpBB stats
				//
				case 'record_online_users':
				case 'record_online_date':

					$do = false;
					break;

				//
				// Keep portal settings
				//
				case 'default_style':
				case 'override_user_style':
				case 'default_lang':

				//
				// Keep portal settings
				//
				case 'allow_html':
				case 'allow_html_tags':
				case 'allow_bbcode':
				case 'allow_smilies':
				case 'smilies_path':

				//
				// Keep portal settings
				//
				case 'board_email':
				case 'board_email_sig':
				case 'smtp_delivery':
				case 'smtp_host':
				case 'smtp_username':
				case 'smtp_password':
				case 'smtp_auth_method':

				//
				// Keep portal settings
				//
				case 'default_dateformat':
				case 'board_timezone':
				case 'gzip_compress':

				//
				// Keep portal settings
				//
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

				//
				// Rename config keys and get internal sitename/sitedesc
				//
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
	 * load_file
	 *
	 * @param unknown_type $force_shared
	 * @access private
	 */
	function load_file($force_shared)
	{
		global $mx_root_path, $phpbb_root_path, $phpEx;

		if ($force_shared)
		{
			$shared = in_array($force_shared, array('internal', 'phpbb2', 'phpbb3')) ? $force_shared : PORTAL_BACKEND;

			switch ($shared)
			{
				case 'internal':
				case 'phpbb2':
					$path = $mx_root_path . 'includes/shared/phpbb2/includes/';
				break;
				case 'phpbb3':
				default:
					$path = $mx_root_path . 'includes/shared/phpbb3/includes/';
				break;
			}
		}
		else
		{
			$path = $phpbb_root_path . 'includes/';
		}

		return $path;
	}

	/**
	 * get_phpbb_info
	 *
	 * @param unknown_type $root_path
	 * @access private
	 */
	function get_mxp_info($root_path, $backend = 'internal', $phpbbversion = '2.0.24')
	{
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		
		if (strpos($root_path, '.') !== false)
		{
			// Nested file
			$filename_ext = substr(strrchr($root_path, '.'), 1);
			$filename = basename($root_path, '.' . $filename_ext);
			$current_dir = dirname(realpath($root_path));
			$root_path = dirname($root_path);			
		}
		else		
		{
			$filename_ext = substr(strrchr(__FILE__, '.'), 1);
			$filename = "config";
			$current_dir = $root_path;
			$root_path = dirname($root_path);			
		}		
		
		$config = $root_path . "/config.$phpEx";
		
		//
		if ((@include $config) === false)
		{
			die('Configuration file ' . $config . ' couldn\'t be opened.');
		}
		//	
		
		// Check the prefix length to ensure that index names are not too long and does not contain invalid characters
		switch ($backend)
		{
			case 'internal':
			// no break;
			case 'phpbb2':
				$phpbb_adm_relative_path = 'admin';
			break;
			
			case 'phpbb3':
			case 'olympus':		
				$phpbb_adm_relative_path = 'adm';
			break;
			
			case 'ascraeus':
			case 'rhea':
			case 'proteus':		
				$phpbb_adm_relative_path = (isset($phpbb_adm_relative_path)) ? $phpbb_adm_relative_path : 'adm/';
				$dbms = get_keys_sufix($dbms);
				$acm_type = get_keys_sufix($acm_type);
			break;
		}
		
		// If we are on PHP < 5.0.0 we need to force include or we get a blank page
		if (version_compare(PHP_VERSION, '5.0.0', '<')) 
		{		
			$dbms = str_replace('mysqli', 'mysql4', $dbms); //this version of php does not have mysqli extension and my crash the installer if finds a forum using this		
		}	
		
		return array(
			'dbms'			=> $dbms,
			'dbhost'		=> $dbhost,
			'dbname'		=> $dbname,
			'dbuser'		=> $dbuser,
			'dbpasswd'		=> $dbpasswd,
			'mx_table_prefix'	=> $mx_table_prefix,			
			'table_prefix'	=> $table_prefix,
			'backend'		=> $backend,		
			'version'		=> $phpbbversion,
			'acm_type'		=> isset($acm_type) ? $acm_type : '',
			'phpbb_root_path'	=> $phpbb_root_path,			
			'status'		=> defined('MX_INSTALLED') ? true : false,			
		);
	}	
	
	/**
	 * get_phpbb_info
	 *
	 * @param unknown_type $root_path
	 * @access private
	 */
	function get_phpbb_info($root_path, $backend = 'phpbb2', $phpbbversion = '2.0.24')
	{
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		
		if (strpos($root_path, '.') !== false)
		{
			// Nested file
			$filename_ext = substr(strrchr($root_path, '.'), 1);
			$filename = basename($root_path, '.' . $filename_ext);
			$current_dir = dirname(realpath($root_path));
			$root_path = dirname($root_path);			
		}
		else		
		{
			$filename_ext = substr(strrchr(__FILE__, '.'), 1);
			$filename = "config";
			$current_dir = $root_path;
			$root_path = dirname($root_path);			
		}		
		
		$config = $root_path . "/config.$phpEx";
		
		//
		if ((@include $config) === false)
		{
			die('Configuration file ' . $config . ' couldn\'t be opened.');
		}
		//
		
		if ((@include $root_path . "language/en/install.$phpEx") !== false)
		{
			$left_piece1 = explode('. You', $lang['CONVERT_COMPLETE_EXPLAIN']);	
			$left_piece2 = explode('phpBB', $left_piece1[0]);
			$phpbbversion = strrchr($left_piece2[1], ' ');
			
			switch (true)
			{
				case (preg_match('/3.0/i', $phpbbversion)):
					$backend = 'olympus';
				break;
				case (preg_match('/3.1/i', $phpbbversion)):
					$backend = 'ascraeus';
				break;
				case (preg_match('/3.2/i', $phpbbversion)):
					$backend = 'rhea';
				break;			
				case (preg_match('/3.3/i', $phpbbversion)):
					$backend = 'proteus';
				break;
				case (preg_match('/4./i', $phpbbversion)):
					$backend = 'phpbb4';
				break;
			}
		}	
		
		// Check the prefix length to ensure that index names are not too long and does not contain invalid characters
		switch ($backend)
		{
			case 'internal':
			// no break;
			case 'phpbb2':
				$phpbb_adm_relative_path = 'admin';
			break;
			
			case 'phpbb3':
			case 'olympus':		
				$phpbb_adm_relative_path = 'adm';
			break;
			
			case 'ascraeus':
			case 'rhea':
			case 'proteus':		
				$phpbb_adm_relative_path = (isset($phpbb_adm_relative_path)) ? $phpbb_adm_relative_path : 'adm/';
				$dbms = get_keys_sufix($dbms);
				$acm_type = get_keys_sufix($acm_type);
			break;
		}
		
		// If we are on PHP < 5.0.0 we need to force include or we get a blank page
		if (version_compare(PHP_VERSION, '5.0.0', '<')) 
		{		
			$dbms = str_replace('mysqli', 'mysql4', $dbms); //this version of php does not have mysqli extension and my crash the installer if finds a forum using this		
		}	
		
		return array(
			'dbms'			=> $dbms,
			'dbhost'		=> $dbhost,
			'dbname'		=> $dbname,
			'dbuser'		=> $dbuser,
			'dbpasswd'		=> $dbpasswd,
			'table_prefix'	=> $table_prefix,
			'backend'		=> $backend,		
			'version'		=> $phpbbversion,
			'acm_type'		=> isset($acm_type) ? $acm_type : '',
			'status'		=> defined('PHPBB_INSTALLED') ? true : false,		
		);
	}
	
	/**
	 * get_smf_info
	 *
	 * @param unknown_type $settings
	 * @access private
	 * /
	function get_smf_info($settings)
	{
		if ((@include $settings) === false)
		{
			install_die(GENERAL_ERROR, 'Configuration file ' . $settings . ' couldn\'t be opened.');
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
		return array(
			'dbms'				=> $db_type, // 'mysql'
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
		);
	}
	
	/**
	 * get_mybb_info
	 *
	 * @param unknown_type $mybb_config
	 * @access private
	 * /
	function get_mybb_info($mybb_config)
	{
		$config = array();
		if ((@include $mybb_config) === false)
		{
			install_die(GENERAL_ERROR, 'Configuration file ' . $mybb_config . ' couldn\'t be opened.');
		}	
		return array(
			'dbms'				=> $config['database']['type'], // 'mysqli';
			'dbname'			=> $config['database']['database'], // 'mybb';
			'table_prefix'		=> $config['database']['table_prefix'], // 'mybb_';

			'dbhost'			=> $config['database']['hostname'], // 'localhost';
			'dbname'			=> $config['database']['username'], // 'Admin';
			'dbpasswd'			=> $config['database']['password'],
			
			'admin_dir'			=> $config['admin_dir'],
			'dbcharacter_set'	=> $config['database']['encoding'],			
		);
	}	
	
	/**
	 * dss_rand
	 *
	 * @param unknown_type $force_shared
	 * @access private
	 */
	function dss_rand()
	{
		global $db, $portal_config, $board_config, $dss_seeded;

		$val = $portal_config['rand_seed'] . microtime();
		$val = md5($val);
		$portal_config['rand_seed'] = md5($portal_config['rand_seed'] . $val . 'a');

		if($dss_seeded !== true)
		{
			$sql = "UPDATE " . PORTAL_TABLE . " SET
				rand_seed = '" . $portal_config['rand_seed'] . "'
				WHERE portal_id = '1'";

			if( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Unable to reseed PRNG", "", __LINE__, __FILE__, $sql);
			}

			$dss_seeded = true;
		}

		return substr($val, 4, 16);
	}

	function make_jumpbox($action, $match_forum_id = 0)
	{
		global $template, $userdata, $lang, $db, $nav_links, $phpEx, $SID;

	//	$is_auth = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);

		$sql = "SELECT c.cat_id, c.cat_title, c.cat_order
			FROM " . CATEGORIES_TABLE . " c, " . FORUMS_TABLE . " f
			WHERE f.cat_id = c.cat_id
			GROUP BY c.cat_id, c.cat_title, c.cat_order
			ORDER BY c.cat_order";
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't obtain category list.", "", __LINE__, __FILE__, $sql);
		}

		$category_rows = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$category_rows[] = $row;
		}

		if ( $total_categories = count($category_rows) )
		{
			$sql = "SELECT *
				FROM " . FORUMS_TABLE . "
				ORDER BY cat_id, forum_order";
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
			}

			$boxstring = '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"><option value="-1">' . $lang['Select_forum'] . '</option>';

			$forum_rows = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				$forum_rows[] = $row;
			}

			if ( $total_forums = count($forum_rows) )
			{
				for($i = 0; $i < $total_categories; $i++)
				{
					$boxstring_forums = '';
					for($j = 0; $j < $total_forums; $j++)
					{
						if ( $forum_rows[$j]['cat_id'] == $category_rows[$i]['cat_id'] && $forum_rows[$j]['auth_view'] <= AUTH_REG )
						{

	//					if ( $forum_rows[$j]['cat_id'] == $category_rows[$i]['cat_id'] && $is_auth[$forum_rows[$j]['forum_id']]['auth_view'] )
	//					{
							$selected = ( $forum_rows[$j]['forum_id'] == $match_forum_id ) ? 'selected="selected"' : '';
							$boxstring_forums .=  '<option value="' . $forum_rows[$j]['forum_id'] . '"' . $selected . '>' . $forum_rows[$j]['forum_name'] . '</option>';

							//
							// Add an array to $nav_links for the Mozilla navigation bar.
							// 'chapter' and 'forum' can create multiple items, therefore we are using a nested array.
							//
							$nav_links['chapter forum'][$forum_rows[$j]['forum_id']] = array (
								'url' => mx_append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=" . $forum_rows[$j]['forum_id']),
								'title' => $forum_rows[$j]['forum_name']
							);

						}
					}

					if ( $boxstring_forums != '' )
					{
						$boxstring .= '<option value="-1">&nbsp;</option>';
						$boxstring .= '<option value="-1">' . $category_rows[$i]['cat_title'] . '</option>';
						$boxstring .= '<option value="-1">----------------</option>';
						$boxstring .= $boxstring_forums;
					}
				}
			}

			$boxstring .= '</select>';
		}
		else
		{
			$boxstring .= '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"></select>';
		}

		// Let the jumpbox work again in sites having additional session id checks.
	//	if ( !empty($SID) )
	//	{
			$boxstring .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
	//	}

		$template->set_filenames(array(
			'jumpbox' => 'jumpbox.tpl')
		);
		$template->assign_vars(array(
			'L_GO' => $lang['Go'],
			'L_JUMP_TO' => $lang['Jump_to'],
			'L_SELECT_FORUM' => $lang['Select_forum'],

			'S_JUMPBOX_SELECT' => $boxstring,
			'S_JUMPBOX_ACTION' => mx_append_sid($action))
		);
		$template->assign_var_from_handle('JUMPBOX', 'jumpbox');

		return;
	}

	/**
	 * Backend specific Page Header data
	 *
	 * @param unknown_type $mode
	 */
	function page_header($mode = false)
	{
		global $db, $mx_root_path, $phpbb_root_path, $userdata, $mx_user, $lang, $images, $phpEx;
		global $board_config, $gen_simple_header, $layouttemplate, $mx_page, $phpBB2;
		
		/**********/
		$layouttemplate = isset($layouttemplate) ? $layouttemplate : "";
		// If MX-Publisher frame template is not set, instantiate it
		if (!is_object($layouttemplate))
		{
			//
			// Initialize template
			//
			$layouttemplate = new mx_Template( $mx_root_path . 'templates/'. $theme['template_name'], $board_config, $db );
		}
		
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

				$s_last_visit = ( $userdata['session_logged_in'] ) ? $phpBB2->create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']) : '';

				//
				// Obtain number of new private messages
				// if user is logged in
				//
				if ( ($userdata['session_logged_in']) && (empty($gen_simple_header)) )
				{
					if ( $userdata['user_new_privmsg'] )
					{
						$l_message_new = ( $userdata['user_new_privmsg'] == 1 ) ? $lang['New_pm'] : $lang['New_pms'];
						$l_privmsgs_text = sprintf($l_message_new, $userdata['user_new_privmsg']);

						if ( $userdata['user_last_privmsg'] > $userdata['user_lastvisit'] )
						{
							$sql = "UPDATE " . USERS_TABLE . "
								SET user_last_privmsg = " . $userdata['user_lastvisit'] . "
								WHERE user_id = " . $userdata['user_id'];
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
					'PHPBB' => true,

					// Show phpbb stats?
					'PHPBB_STATS' => $mx_page->phpbb_stats,

					// Allow autologin?
					'ALLOW_AUTOLOGIN' => !$userdata['session_logged_in'] && (!isset($board_config['allow_autologin']) || $board_config['allow_autologin']),

					// phpBB PM
					'ENABLE_PM_POPUP' => $userdata['session_logged_in'] && !empty($userdata['user_popup_pm']),
				));

				break;

			case 'generate_nav_links':

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
				$current_phpbb_version = '0.0.0';

				$template->assign_vars(array(
					'PHPBB_BACKEND'				=> true,
					'PHPBB_VERSION' 			=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? $current_phpbb_version : '',
					'U_PHPBB_ROOT_PATH' 		=> PHPBB_URL,
				));

				break;
		}
	}

	/**
	 * obtain_forum_config
	 *
	 * @access public
	 * @param boolean $use_cache
	 * @return unknown
	 */
	function obtain_forum_config($use_cache = true)
	{
		if ( ($config = $this->obtain_portal_config($use_cache)) )
		{
			return $config;
		}
	}
	
	/**
	* Set forum config values
	 *
	 * @param unknown_type $config_name
	 * @param unknown_type $config_value
	 */
	function set_forum_config($key, $new_value, $use_cache = false)
	{
		$this->set_portal_config($key, $new_value);
	}	
	
	/**
	 * Get MX-Publisher config data
	 *
	 * @access public
	 * @return unknown
	 */
	public function obtain_portal_config($use_cache = true)
	{
		global $db, $mx_cache;

		if ( ($portal_config = $mx_cache->get('mx_config')) && ($use_cache) )
		{
			return $portal_config;
		}
		else
		{
			$sql = "SELECT *
				FROM " . PORTAL_TABLE . "
				WHERE portal_id = '1'";

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
			$row = $db->sql_fetchrow($result);
			foreach ($row as $config_name => $config_value)
			{
				$portal_config[$config_name] = trim($config_value);
			}
			$db->sql_freeresult($result);
			$mx_cache->put('mx_config', $portal_config);

			return ($portal_config);
		}
	}
	
	/**
	* Set config value. Creates missing config entry.
	*
	*/
	function set_portal_config($key, $new_value)
	{
		global $db, $mx_cache, $portal_config;
		
		// Read out config values
		$portal_config = $this->obtain_portal_config();		
		
		$new[$key] = $new_value;

		$sql = "UPDATE  " . PORTAL_TABLE . " SET " . $db->sql_build_array('UPDATE', utf8_normalize_nfc($new));
		
		if( !($db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Failed to update portal configuration ", "", __LINE__, __FILE__, $sql);
		}
		
		if (!$db->sql_affectedrows() && !isset($portal_config[$key]))
		{
			$sql = 'INSERT INTO ' . PORTAL_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				$db->sql_escape($key) => $db->sql_escape($new_value)));
			
			//$after = (!empty($column_data['after'])) ? ' AFTER ' . $column_data['after'] : '';
			//$sql = 'ALTER TABLE `' . $table . '` ADD `' . $column_name . '` ' . (($column_data['column_type_sql'] = 'NULL') ? 'TEXT' :  $column_data['column_type_sql']) . ' ' . (!empty($column_data[$column_name]) ? $column_data[$column_name] : 'NULL') . ' DEFAULT NULL'  . $after;
					
			$db->sql_query($sql);
		}

		$portal_config[$key] = $new_value;

		$mx_cache->destroy('mx_config');
	}
	
	/**
	 * Get userdata
	 *
	 * Get Userdata, $mx_user can be username or user_id. If force_str is true, the username will be forced.
	 * Cached sql, since this function is used for every block.
	 *
	 * @param unknown_type $mx_user id or name
	 * @param boolean $force_str force clean_username
	 * @return array
	 */
	function get_userdata($mxuser, $force_str = false)
	{
		global $db, $phpBB2;

		if (!is_numeric($mxuser) || $force_str)
		{
			$mx_user = $phpBB2->phpbb_clean_username($mxuser);
		}
		else
		{
			$mx_user = intval($mxuser);
		}

		$sql = "SELECT *
			FROM " . USERS_TABLE . "
			WHERE ";
		$sql .= ((is_integer($mxuser)) ? "user_id = $mxuser" : "username = '" .  str_replace("\'", "''", $mxuser) . "'" ) . " AND user_id <> " . ANONYMOUS;
		if (!($result = $db->sql_query($sql, 120)))
		{
			if (!function_exists('mx_message_die'))
			{
				die("Tried obtaining data for a non-existent user. Function mx_backend->get_userdata()");
			}
			else
			{
				mx_message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
			}
		}
		$return = ($row = $db->sql_fetchrow($result)) ? $row : false;
		/*
		foreach ($row as $user_key => $user_value)
		{
			$userdata[$user_key] = trim($user_value);
		}
		*/
		$db->sql_freeresult($result);
		//return ($userdata);			
		return $return;
	}	
	
	/**
	* Set user data value. 
	*
	*/
	function set_userdata($key, $new_value)
	{
		global $db, $mx_user;
						
		$new[$key] = $new_value;
		
		if (!isset($mx_user->data[$key]) || ($key == 'user_style'))
		{
			mx_message_die(GENERAL_ERROR, "Wrong Backend? Adding this entry $key key to update MXP configuration  is not supported with this backend.", "", __LINE__, __FILE__, $sql);	
		}
		
		$sql = "UPDATE " . USERS_TABLE . "
		SET " . $db->sql_build_array('UPDATE', utf8_normalize_nfc($new)) . "
		WHERE user_id = '" . $mx_user->data['user_id'] . "'";		
		if (!($db->sql_query($sql)))
		{
			mx_message_die(GENERAL_ERROR, "Failed to update user data value ", "", __LINE__, __FILE__, $sql);
		}
		
		if (!$db->sql_affectedrows() && !isset($mx_user->data[$key]))
		{
			mx_message_die(GENERAL_ERROR, "Wrong Backend? Adding missing entry key to update MXP configuration  is not supported ATM.", "", __LINE__, __FILE__, $sql);	
		}
		$mx_user->data[$key] = $new_value;
	}	

	/**
	 * Enter description here...
	 *
	 * @access public
	 * @param boolean $use_cache
	 * @return unknown
	 */
	function obtain_phpbb_config($use_cache = true)
	{
		global $db, $mx_cache;

		if (($config = $mx_cache->get('phpbb_config')) && ($use_cache) )
		{
			return $config;
		}
		else
		{
			$sql = "SELECT *
				FROM " . CONFIG_TABLE;

			if ( !( $result = $db->sql_query( $sql ) ) )
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
				$config[$row['config_name']] = $row['config_value'];
			}
			$db->sql_freeresult($result);

			if ($use_cache)
			{
				$mx_cache->put('phpbb_config', $config);
			}

			return ( $config );
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
					AND u.user_id = s.session_user_id
					AND u.user_id <> " . ANONYMOUS . "
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
		global $phpBB2;
		
		return $phpBB2->decode_ip($str_ip);
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function get_phpbb_version()
	{
		global $board_config;

		return '0.0.0';
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
		global $lang, $mx_user, $userdata, $theme, $phpEx;

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
			$user_style = 'style="font-weight : bold;"';
		}

		// Only show the link if not anonymous
		if ($user_id && $user_id != ANONYMOUS)
		{
			$profile_url = mx3_append_sid(PHPBB_URL . "profile.$phpEx", 'mode=viewprofile&amp;u=' . (int) $user_id);
			$full_url = '<a href="' . $profile_url . '"><span ' . $user_style . '>' . $username . '</span></a>';
		}
		else
		{
			$profile_url = $lang['Guest'];
			$full_url = $lang['Guest'];
		}

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
	}

	//
	// ACP
	//
	/**
	 * Enter description here...
	 *
	 */
	function load_phpbb_acp_menu()
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
	function phpbb_version_check($force_update = false, $warn_fail = false, $ttl = 86400)
	{
		return '';
	}
}

//
// Now load some bbcodes, to be extended for this backend (see below)
//
include_once($mx_root_path . 'includes/sessions/internal/bbcode.' . $phpEx); // BBCode associated functions
?>