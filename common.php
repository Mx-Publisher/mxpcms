<?php
/**
*
* @package MX-Publisher Core
* @version $Id: common.php,v 1.121 2014/05/09 07:51:42 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}
if (!defined('E_DEPRECATED'))
{
	define('E_DEPRECATED', 8192);
}
if (!defined('E_STRICT'))
{
	define('E_STRICT', 2048);
}

if (!defined('MX_ENVIRONMENT'))
{
	@define('MX_ENVIRONMENT', 'production');
	//@define('MX_ENVIRONMENT', 'development');
}

/*
* To be able to include phpBB functions/methods
*/
@define('IN_PHPBB', 1);
@define('PHPBB_INSTALLED', true);

// Reset stats
$mx_starttime = explode(' ', microtime());
$mx_starttime = $mx_starttime[1] + $mx_starttime[0];

/*
* DEBUG AND ERROR HANDLING
*/
define('DEBUG', true); // [Admin Option] Show Footer debug stats - Actually set in phpBB/includes/constants.php
define('DEBUG_EXTRA', true); // [Admin Option] Show memory usage. Show link to full SQL debug report in footer. Beware, this makes the page slow to load. For debugging only.
define('INCLUDES', 'includes/'); //Main Includes folder
@ini_set('display_errors', '1');
//@error_reporting(E_ERROR | E_WARNING | E_PARSE); // This will NOT report uninitialized variables
//@error_reporting(E_ALL | E_NOTICE | E_STRICT);
@error_reporting(E_ALL & ~E_NOTICE); //Default error reporting in PHP 5.2+
@session_cache_expire (1440);
@set_time_limit (1500);

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
/**
* Minimum Requirement: PHP 7.3.0
* const PHP_VERSION (PHP 4 >= 4.1.0, PHP 5, PHP 7)
*/
@define('PHP_VERSION_MX', PHP_VERSION); 

// If we are on PHP >= 6.0.0 we do not need some code
if (version_compare(PHP_VERSION, '5.3.0', '>='))
{
	/**
	* @ignore
	*/
	define('STRIP', false);
}
else
{
	@set_magic_quotes_runtime(0);

	// Be paranoid with passed vars
	if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'on' || !function_exists('ini_get'))
	{
		@deregister_globals();
	}

	define('STRIP', (@get_magic_quotes_gpc()) ? true : false);
}

// The following code (unsetting globals)
// Thanks to Matt Kavanagh and Stefan Esser for providing feedback as well as patch files

// PHP5 with register_long_arrays off? This is requested in class mx_request_vars, do not change!
if (@phpversion() >= '5.0.0' && (!@ini_get('register_long_arrays') || @ini_get('register_long_arrays') == '0' || strtolower(@ini_get('register_long_arrays')) == 'off'))
{
	$HTTP_POST_VARS = $_POST;
	$HTTP_GET_VARS = $_GET;
	$HTTP_SERVER_VARS = $_SERVER;
	$HTTP_COOKIE_VARS = $_COOKIE;
	$HTTP_ENV_VARS = $_ENV;
	$HTTP_POST_FILES = $_FILES;

	// _SESSION is the only superglobal which is conditionally set
	if (isset($_SESSION))
	{
		$HTTP_SESSION_VARS = $_SESSION;
	}
}


// Protect against GLOBALS tricks
if (isset($_POST['GLOBALS']) || isset($HTTP_POST_FILES['GLOBALS']) || isset($_GET['GLOBALS']) || isset($HTTP_COOKIE_VARS['GLOBALS']))
{
	die("Hacking attempt");
}

// Protect against HTTP_SESSION_VARS tricks
if (isset($HTTP_SESSION_VARS) && !is_array($HTTP_SESSION_VARS))
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

//
// Temp fix for timezone
//
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
$portal_config = array();
$userdata = array();
$theme = array();
$images = array();
$lang = array();
$nav_links = array();
$dss_seeded = false;
$gen_simple_header = FALSE;

/*
* Read main config file
*/
@include_once($mx_root_path . 'config.' . $phpEx);

/*
* Redirect for fresh MX-Publisher install
*/
if( !defined('MX_INSTALLED') || (MX_INSTALLED === false) )
{
	header('Location: ' . $mx_root_path . 'install/mx_install.' . $phpEx);
	exit;
}

// In case $mx_adm_relative_path is not set (in case of an update), use the default.
$mx_adm_relative_path = 'admin/';
$mx_admin_path = $mx_root_path . $mx_adm_relative_path;

/*
* MX-Publisher CORE Includes
*/
require($mx_root_path . INCLUDES . 'mx_class_loader.' . $phpEx);
require($mx_root_path . INCLUDES . 'mx_constants.' . $phpEx); // Also includes phpBB constants
require($mx_root_path . INCLUDES . 'db/' . $dbms . '.' . $phpEx); // Load dbal and initiate class
require($mx_root_path . INCLUDES . 'utf/utf_tools.' . $phpEx); //Load UTF-8 Tools

if (MX_ENVIRONMENT === 'development')
{

	//Report all errors, except notices and deprecation messages.  For nice error output.
	include($mx_root_path . 'modules/mx_shared/ErrorHandler/prepend.' . $phpEx);

}
else
{
	set_error_handler(defined('MX_MSG_HANDLER') ? MX_MSG_HANDLER : 'mx_msg_handler');
}

/**
* Minimum Requirement: PHP 5.3.0
*/
if (version_compare(PHP_VERSION, '5.3') < 0)
{
	die('You are running an unsupported PHP version. You can ask Support Team for an downgraded version of mx_functions_core.php file. The class deactivated_super_global() require PHP 5.3.0 or higher before trying to install or update to MXP 3.0-RC2+');
	require($mx_root_path . INCLUDES . 'mx_functions_core_beta.' . $phpEx); // CORE class
}
else
{
	require($mx_root_path . INCLUDES . 'mx_functions_core.' . $phpEx); // CORE class
}

require($mx_root_path . 'vendor/paragonie/random_compat/lib/random.' . $phpEx);

// Setup class loader first
if (@phpversion() >= '5.1.2')
{
	$mx_class_loader = new mx_class_loader('mx_', "{$mx_root_path}includes/", $phpEx);
	$mx_class_loader->register();
	$mx_class_loader_ext = new mx_class_loader('mx_ext_', "{$mx_root_path}ext/", $phpEx);
	$mx_class_loader_ext->register();
}

/*
* Instantiate the mx_request_vars class
* make sure to do before it's ever used
*/
$mx_request_vars = new mx_request_vars('', false);

/*
* Instantiate the mx_cache class
*/
$mx_cache = new mx_cache();

// this is needed to prevent unicode normalization
$super_globals_disabled = $mx_request_vars->super_globals_disabled();
// enable super globals to get literal value
if (!$super_globals_disabled)
{
	//$request->disable_super_globals();
}

/*
* Define Users/Group/Sessions backend, and validate
* Set $portal_config, $phpbb_root_path, $tplEx, $table_prefix & PORTAL_BACKEND
*/
$mx_cache->load_backend();


//Temp fix for timezone
if (@function_exists('date_default_timezone_set') && @function_exists('date_default_timezone_get'))
{
	@date_default_timezone_set(@date_default_timezone_get());
}

//
// instatiate the mx_backend class
//
$mx_backend = new mx_backend();

//
// Define some general backend definitions
// PORTAL_URL, PHPBB_URL, PORTAL_VERSION & $board_config
//
$mx_backend->setup_backend();

//
// Instantiate Dummy phpBB Classes
//
if( class_exists('phpBB2'))
{
	$phpBB2 = new phpBB2();
}
$phpBB3 = new phpBB3();

//
// MX-Publisher Includes - doing the rest
//
include_once($mx_root_path . INCLUDES . 'mx_functions.' . $phpEx); // CORE Functions

/**
* Minimum Requirement: PHP 5.3.0
*/
if (version_compare(PHP_VERSION, '5.3') < 0)
{
	die('You are running an unsupported PHP version. You can ask Support Team for an downgraded version of mx_functions_style_beta.php file. The class deactivated_super_global() require PHP 5.3.0 or higher before trying to install or update to MXP 3.0-RC2+');
	include_once($mx_root_path . INCLUDES . 'mx_functions_style_beta.' . $phpEx); // Styling and sessions
}
else
{
	include_once($mx_root_path . INCLUDES . 'mx_functions_style.' . $phpEx); // Styling and sessions
}

// We do not need this any longer, unset for safety purposes
unset($dbpasswd);

//
// Instantiate the mx_mod_rewrite class (if activated)
//
$mx_cache->init_mod_rewrite();

//
// Instantiate the mx_auth class
$mx_auth = $phpbb_auth =new phpbb_auth();

//
// Instantiate the mx_user class
//
$mx_user = new mx_user();

/**
* Instantiate the mx_language class
* $language->_load_lang($mx_root_path, 'lang_main');
*/
$language = new mx_language();

//
// Instantiate the mx_page (CORE) class
//
$mx_page = new mx_page();

//
// Instantiate the mx_block class
//
$mx_block = new mx_block();

//
// Obtain and encode users IP
// Why no forwarded_for et al? Well, too easily spoofed. With the results of my recent requests
// it's pretty clear that in the majority of cases you'll at least be left with a proxy/cache ip.
$client_ip = (!empty($_SERVER['REMOTE_ADDR'])) ? (string) $_SERVER['REMOTE_ADDR'] : ((!empty($_ENV['REMOTE_ADDR'])) ? $_ENV['REMOTE_ADDR'] : getenv('REMOTE_ADDR'));
//$client_ip = htmlspecialchars_decode($mx_request_vars->server('REMOTE_ADDR'));
$client_ip = preg_replace('# {2,}#', ' ', str_replace(',', ' ', $client_ip));
$user_ip = $phpBB2->encode_ip($client_ip);

//
// Instantiate the mx_bbcode class
//
$mx_bbcode = new mx_bbcode();

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
if(!empty($portal_config['board_disable']) && !defined("IN_ADMIN") && !defined("IN_LOGIN"))
{
	mx_message_die(GENERAL_MESSAGE, 'Board_disable', 'Information');
}

//
// Initialize GZIP handler (if necessary) and PHP sessions
// Note! This is a tweak, modding the standard page_header.php file
//
$do_gzip_compress = FALSE;

mx_session_start();			// Note: this needs $board_config populated

?>