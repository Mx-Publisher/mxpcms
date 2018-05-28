<?php
/**
*
* @package mxBB Portal Core
* @version $Id: common.php,v 1.5 2012/10/25 13:15:27 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

@define('IN_PHPBB', 1);

// Report all errors, except notices and deprecation messages
if (!defined('E_DEPRECATED'))
{
	define('E_DEPRECATED', 8192);
}

$mx_starttime = explode(' ', microtime());
$mx_starttime = $mx_starttime[1] + $mx_starttime[0];

//
// DEBUG AND ERROR HANDLING
//
@define('DEBUG', 1);  // [Admin Option] Show Footer debug stats - Actually set in phpBB/includes/constants.php
@define('DEBUG_EXTRA', 1);  // [Admin Option] Show memory usage. Show link to full SQL debug report in footer. Beware, this makes the page slow to load. For debugging only.
//
//error_reporting(E_ALL & ~E_NOTICE); //Default error reporting in PHP 5.2+
//error_reporting  (E_ERROR | E_WARNING | E_PARSE); // This will NOT report uninitialized variables
//include($mx_root_path . 'modules/mx_shared/ErrorHandler/prepend.php'); // For nice error output

// ================================================================================
// The following code is based on common.php from phpBB
// ================================================================================
/*
* Remove variables created by register_globals from the global scope
* Thanks to Matt Kavanagh
*/
function deregister_globals()
{
	$not_unset = array(
		'GLOBALS'	=> true,
		'_GET'		=> true,
		'_POST'		=> true,
		'_COOKIE'	=> true,
		'_REQUEST'	=> true,
		'_SERVER'	=> true,
		'_SESSION'	=> true,
		'_ENV'		=> true,
		'_FILES'	=> true,
		'phpEx'		=> true,
		'phpbb_root_path'	=> true,
		'mx_root_path'	=> true,
		'module_root_path'	=> true
	);

	// Not only will array_merge and array_keys give a warning if
	// a parameter is not an array, array_merge will actually fail.
	// So we check if _SESSION has been initialised.
	if (!isset($_SESSION) || !is_array($_SESSION))
	{
		$_SESSION = array();
	}

	// Merge all into one extremely huge array; unset this later
	$input = array_merge(
		array_keys($_GET),
		array_keys($_POST),
		array_keys($_COOKIE),
		array_keys($_SERVER),
		array_keys($_SESSION),
		array_keys($_ENV),
		array_keys($_FILES)
	);

	foreach ($input as $varname)
	{
		if (isset($not_unset[$varname]))
		{
			// Hacking attempt. No point in continuing unless it's a COOKIE
			if ($varname !== 'GLOBALS' || isset($_GET['GLOBALS']) || isset($_POST['GLOBALS']) || isset($_SERVER['GLOBALS']) || isset($_SESSION['GLOBALS']) || isset($_ENV['GLOBALS']) || isset($_FILES['GLOBALS']))
			{
				die("Hacking attempt. No point in continuing couse regiters globals can't be turned off plus you have save mode restrictions and there is no COOKIE.");
			}
			else
			{
				$cookie = &$_COOKIE;
				while (isset($cookie['GLOBALS']))
				{
					foreach ($cookie['GLOBALS'] as $registered_var => $value)
					{
						if (!isset($not_unset[$registered_var]))
						{
							unset($GLOBALS[$registered_var]);
						}
					}
					$cookie = &$cookie['GLOBALS'];
				}
			}
		}

		unset($GLOBALS[$varname]);
	}

	unset($input);
}
// If we are on PHP >= 6.0.0 we do not need some code
if (phpversion() >= '5.3.0')
{
	/**
	* @ignore
	*/
	define('STRIP', false);
}
else
{
	set_magic_quotes_runtime(0);

	// Be paranoid with passed vars
	if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'on' || !function_exists('ini_get'))
	{
		@deregister_globals();
	}

	define('STRIP', (get_magic_quotes_gpc()) ? true : false);
}

// The following code (unsetting globals)
// Thanks to Matt Kavanagh and Stefan Esser for providing feedback as well as patch files

// PHP5 with register_long_arrays off?
if (@phpversion() >= '5.3.0' && (!@ini_get('register_long_arrays') || @ini_get('register_long_arrays') == '0' || strtolower(@ini_get('register_long_arrays')) == 'off'))
{
	$HTTP_POST_VARS = $_POST;
	$HTTP_GET_VARS = $_GET;
	$HTTP_SERVER_VARS = $_SERVER;
	$HTTP_COOKIE_VARS = $_COOKIE;
	$HTTP_ENV_VARS = $_ENV;
	$HTTP_POST_VARS = $_FILES;

	//_SESSION is the only superglobal which is conditionally set
	if (isset($_SESSION))
	{
		$HTTP_SESSION_VARS = $_SESSION;
	}
}

// Protect against GLOBALS tricks
if (isset($_POST['GLOBALS']) || isset($_POST['GLOBALS']) || isset($_GET['GLOBALS']) || isset($_COOKIE['GLOBALS']))
{
	die("Hacking attempt");
}

// Protect against _SESSION tricks
if (isset($_SESSION) && !is_array($_SESSION))
{
	die("Hacking attempt");
}

if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'on')
{
	// PHP4+ path
	$not_unset = array('_GET', '_POST', '_COOKIE', '_SERVER', '_SESSION', '_ENV', '_POST', 'phpEx', 'phpbb_root_path', 'mx_root_path');

	// Not only will array_merge give a warning if a parameter
	// is not an array, it will actually fail. So we check if
	// _SESSION has been initialised.
	if (!isset($_SESSION) || !is_array($_SESSION))
	{
		$_SESSION = array();
	}

	// Merge all into one extremely huge array; unset
	// this later
	//
	// Note! Since array_merge() destroys numerical keys - if the array is numerically indexed, the keys get reindexed in a continuous way - we use the + operator instead
	//
	//$input = array_merge($_GET, $_POST, $_COOKIE, $_SERVER, $_SESSION, $_ENV, $_POST);
	$input = $_GET + $_POST + $_COOKIE + $_SERVER + $_SESSION + $_ENV + $_POST;

	unset($input['input']);
	unset($input['not_unset']);

	while (list($var,) = @each($input))
	{
		if (in_array($var, $not_unset))
		{
			die('Hacking attempt!');
		}
		unset($$var);
	}
	unset($input);
}

//
// addslashes to vars if magic_quotes_gpc is off
// this is a security precaution to prevent someone
// trying to break out of a SQL statement.
//
// If we are on PHP >= 6.0.0 we do not need some code
if ( (@phpversion() < '5.3.0') or ( @function_exists('get_magic_quotes_gpc') && !@get_magic_quotes_gpc() ) )
{
	if( is_array($_GET) )
	{
		while( list($k, $v) = each($_GET) )
		{
			if( is_array($_GET[$k]) )
			{
				while( list($k2, $v2) = each($_GET[$k]) )
				{
					$_GET[$k][$k2] = addslashes($v2);
				}
				@reset($_GET[$k]);
			}
			else
			{
				$_GET[$k] = addslashes($v);
			}
		}
		@reset($_GET);
	}

	if( is_array($_POST) )
	{
		while( list($k, $v) = each($_POST) )
		{
			if( is_array($_POST[$k]) )
			{
				while( list($k2, $v2) = each($_POST[$k]) )
				{
					$_POST[$k][$k2] = addslashes($v2);
				}
				@reset($_POST[$k]);
			}
			else
			{
				$_POST[$k] = addslashes($v);
			}
		}
		@reset($_POST);
	}

	if( is_array($_COOKIE) )
	{
		while( list($k, $v) = each($_COOKIE) )
		{
			if( is_array($_COOKIE[$k]) )
			{
				while( list($k2, $v2) = each($_COOKIE[$k]) )
				{
					$_COOKIE[$k][$k2] = addslashes($v2);
				}
				@reset($_COOKIE[$k]);
			}
			else
			{
				$_COOKIE[$k] = addslashes($v);
			}
		}
		@reset($_COOKIE);
	}
}

//Temp fix for timezone
if (@function_exists('date_default_timezone_set') && @function_exists('date_default_timezone_get'))
{
	@date_default_timezone_set(@date_default_timezone_get());
}

//
// Define some basic configuration arrays this also prevents
// malicious rewriting of language and otherarray values via
// URI params
//
$board_config = array();
$userdata = array();
$theme = array();
$images = array();
$lang = array();
$nav_links = array();
$dss_seeded = false;
$gen_simple_header = FALSE;

//
// Read main config file
//
@include_once($mx_root_path . 'config.' . $phpEx);


//
// Define backend template extension
//
$tplEx = 'tpl';

//
// Redirect for fresh mxBB install
//
if( !defined('MX_INSTALLED') )
{
	header('Location: ' . $mx_root_path . 'install/mx_install.' . $phpEx);
	exit;
}

str_replace("//", "/", $phpbb_root_path);


//
// MXP Includes
//
include_once($mx_root_path . 'includes/mx_constants.' . $phpEx); // Also includes phpBB constants
include_once($mx_root_path . 'includes/mx_functions_style.' . $phpEx); // Extends the phpBB template class

include_once($mx_root_path . 'includes/db/' . $dbms . '.' . $phpEx); // Load dbal and initiate class
include_once($mx_root_path . 'includes/utf/utf_tools.' . $phpEx); //Load UTF-8 Tools
include_once($mx_root_path . 'vendor/paragonie/random_compat/lib/random.' . $phpEx);
include_once($mx_root_path . 'includes/mx_functions.' . $phpEx); // CORE Functions
include_once($mx_root_path . 'includes/mx_functions_phpbb.' . $phpEx); // phpBB associated functions

include_once($mx_root_path . 'includes/mx_functions_core.' . $phpEx); // CORE class

// We do not need this any longer, unset for safety purposes
unset($dbpasswd);

//
// Instatiate the mx_cache class
//
$mx_cache = new mx_cache();

//
// Instantiate Dummy phpBB Classes
//
$phpBB2 = new phpBB2();

//
// Get MX-Publisher config settings
//
$portal_config = $mx_cache->obtain_mxbb_config();

if (empty($portal_config['portal_version']))
{
	$portal_config = $mx_cache->obtain_mxbb_config(false);
}

// Obtain and encode users IP
//
// I'm removing HTTP_X_FORWARDED_FOR ... this may well cause other problems such as
// private range IP's appearing instead of the guilty routable IP, tough, don't
// even bother complaining ... go scream and shout at the idiots out there who feel
// "clever" is doing harm rather than good ... karma is a great thing ... :)
//
$client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : getenv('REMOTE_ADDR') );
$user_ip = encode_ip($client_ip);

/*
* Define Users/Group/Sessions backend, and validate
* Set $portal_config, $phpbb_root_path, $tplEx, $table_prefix & PORTAL_BACKEND
*/
$mx_cache->load_backend(); //define('PORTAL_BACKEND', 'phpbb2');
//
//Include vanila phpBB2 bakend files
//
include_once($phpbb_root_path . 'includes/constants.'.$phpEx);
include_once($phpbb_root_path . 'includes/sessions.'. $phpEx);	
include_once($phpbb_root_path . 'includes/functions_selects.' . $phpEx);
include_once($mx_root_path . 'includes/mx_functions_bbcode.'.$phpEx);

//
// instatiate the mx_user class
//
$mx_user = $user = new mx_user();

	
include_once($mx_root_path . 'includes/sessions/phpbb2/core.' . $phpEx);

//
// instatiate the mx_backend class
//
$mx_backend = new mx_backend();
$mx_backend->setup_backend();
//
// Define some general Defs
//
//define('PHPBB_URL', $portal_config['portal_phpbb_url']);
//define('PORTAL_URL', $portal_config['portal_url']);
//define('PORTAL_VERSION', $portal_config['portal_version']);


//
// Instatiate the mx_bbcode class
//
$mx_bbcode = new mx_bbcode();

//
// Instantiate the mx_mod_rewrite class (if activated)
//
if ($portal_config['mod_rewrite'])
{
	if ( file_exists( $mx_root_path . 'modules/mx_mod_rewrite/includes/rewrite_functions.php' ) )
	{
		include_once( $mx_root_path . 'modules/mx_mod_rewrite/includes/rewrite_functions.php' );

		if (class_exists('mx_mod_rewrite'))
		{
			$mx_mod_rewrite = new mx_mod_rewrite();
		}
	}
}


//
// instatiate the mx_request_vars class
//
$mx_request_vars = new mx_request_vars();

//
// instatiate the mx_page (CORE) class
//
$mx_page = new mx_page();

//
// instatiate the mx_block class
//
$mx_block = new mx_block();


//
// Setup forum wide options, if this fails
// then we output a CRITICAL_ERROR since
// basic forum information is not available
//
if( @file_exists($phpbb_root_path . 'includes/class_config.' . $phpEx) && @file_exists($phpbb_root_path . 'includes/class_groups.' . $phpEx) )
{
	include($mx_root_path . 'includes/mx_functions_ch.'.$phpEx);
}
else
{
	//
	// Grab phpBB global variables, re-cache if necessary
	// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the mxBB cache whenever updating phpBB config settings
	// - true: enable cache, false: disable cache
	$board_config = $mx_cache->obtain_phpbb_config(false);
}

//
// Is phpBB File Attachment MOD present?
//
if( file_exists($phpbb_root_path . 'attach_mod') )
{
	include_once($phpbb_root_path . 'attach_mod/attachment_mod.' . $phpEx);
}

//
// Remove install and contrib folders
//
if( file_exists('install') || file_exists('contrib') )
{
	mx_message_die(GENERAL_MESSAGE, 'Please_remove_install_contrib');
}

//
// Extra admin debug footer
//
if (defined('DEBUG_EXTRA'))
{
	$base_memory_usage = 0;
	if (function_exists('memory_get_usage'))
	{
		$base_memory_usage = memory_get_usage();
	}
}

//
// Show 'Board is disabled' message if needed.
//
if( $board_config['board_disable'] && !defined("IN_ADMIN") && !defined("IN_LOGIN") )
{
	mx_message_die(GENERAL_MESSAGE, 'Board_disable', 'Information');
}

//
// Initialize GZIP handler (if necessary) and PHP sessions
// Note! This is a tweak, modding the standard page_header.php file
//
$do_gzip_compress = FALSE;
mx_session_start();			// Note: this needs $board_config populated!
?>