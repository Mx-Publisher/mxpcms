<?php
/**
*
* @package MX-Publisher Installation
* @version $Id: mx_install.php,v 2.0 2024/03/26 13:59:42 orynider Exp $
* @copyright (c) 2002-2024 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
* @link http://github.com/MX-Publisher
*/

/*
* FYI:
* I tried to add as much comments as possible within the code to help you
* follow what's going and why. Important or critical information might
* be found by searching "FYI" (without quotes) ;-)
*/

/*
* FYI: This installation script will try to find your phpBB board and then
* to get from there all the information required to install MX-Publisher.
* However, the methods we use might not work on some configurations.
* If you get into trouble when running this installation script, then
* please comment the following line. It will remove the readonly attribute
* from the installation panel, so you'll be able to enter the settings
* yourself. Please, report us any issue you may find running this script.
*/

define('INSTALL_READONLY', true);

/*
* Set MX-Publisher version here !
*/
$mx_portal_name 	= 'MX-Publisher Modular System';
$mx_portal_version 	= '3.0.0-RC';
$mx_php_version		= '5.3.0';
$mx_portal_copy 	= '<b>MX-Publisher Modular System!</b> <br /><br/> MX-Publisher is a fully modular system, portal and CMS, featuring dynamic pages, blocks, and themes, by means of a powerful yet flexible AdminCP. It is the classical phpBB portal add-on, improved and enhanced for every phpBB version released since 2001 (originally named MX-Publisher). <br /><br />Authors: The MX-Publisher Development Team. <br />Please visit <a href="http://www.mx-publisher.com/">www.mx-publisher.com</a> for further information.';

/*
* Please, update the installer version when making changes to this code.
* This is shown in the top right corner of the installation panels.
*/
define('INSTALLER_VERSION', '3.0.6');
define('INSTALLER_NAME', 'MX-Publisher-IWizard');

/*
* These URLs are used in the footer installation panels.
*/
define('U_RELEASE_NOTES', 'http://mxpcms.sourceforge.net/forum/viewtopic.php?t=10949');
//define('U_WELCOME_PACK', 'http://mxpcms.sourceforge.net/index.php?page=136');
define('U_ONLINE_MANUAL', 'http://mxpcms.sourceforge.net/docs/manual');
define('U_ONLINE_KB', 'http://mxpcms.sourceforge.net/docs/kb');
define('U_ONLINE_SUPPORT', 'http://mxpcms.sourceforge.net/forum');
define('U_TERMS_OF_USE', 'http://mxpcms.sourceforge.net/toe');

/*
* These URLs are used in the last installation/upgrade panels.
*/
define('U_MXBB_NEWS_INFO', 'http://lists.sourceforge.net/lists/listinfo/mxpcms-news');
define('U_MXBB_NEWS_NOW', 'http://lists.sourceforge.net/lists/listinfo/mxpcms-news');

/*
* Initialization
*/
define('IN_PORTAL', true);
define('IN_BACKEND', true);
define('IN_PHPBB', true);
define('INSTALLING', true);

$mx_root_path = '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$tplEx = @file_exists($mx_root_path.'install/templates/mx_install_header.html') ? 'html' : 'tpl';

/*
* FYI:
* The following code related to PHP Global Variables is based on
* common.php from phpBB 2.0.18
*/
@ini_set( 'display_errors', '1' );
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting  (E_ERROR | E_WARNING | E_PARSE); // This will NOT report uninitialized variables
//include($mx_root_path . "modules/mx_shared/ErrorHandler/prepend.$phpEx"); // For nice error output

// ================================================================================
// The following code is based on common.php from phpBB
// ================================================================================
//Temp fix for timezone by orynider
if (@function_exists('date_default_timezone_set') && @function_exists('date_default_timezone_get'))
{
	@date_default_timezone_set(@date_default_timezone_get());
}
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
		'backend_root_path'	=> true,
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
			// Hacking attempt. No point in continuing unless it's a COOKIE //removed for mx_install: $varname !== 'GLOBALS' ||
			if (isset($_GET['GLOBALS']) || isset($_POST['GLOBALS']) || isset($_SERVER['GLOBALS']) || isset($_SESSION['GLOBALS']) || isset($_ENV['GLOBALS']) || isset($_FILES['GLOBALS']))
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
if (version_compare(PHP_VERSION, '5.3.0', '>='))
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
	$not_unset = array('HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_COOKIE_VARS', 'HTTP_SERVER_VARS', 'HTTP_SESSION_VARS', 'HTTP_ENV_VARS', 'HTTP_POST_FILES', 'phpEx');

	// Not only will array_merge give a warning if a parameter
	// is not an array, it will actually fail. So we check if
	// HTTP_SESSION_VARS has been initialised.
	if (!isset($HTTP_SESSION_VARS) || !is_array($HTTP_SESSION_VARS))
	{
		$HTTP_SESSION_VARS = array();
	}

	// Merge all into one extremely huge array; unset
	// this later
	//
	// Note! Since array_merge() destroys numerical keys - if the array is numerically indexed, the keys get reindexed in a continuous way - we use the + operator instead
	//
	$input = array_merge($_GET, $_POST, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS, $HTTP_SESSION_VARS, $HTTP_ENV_VARS, $HTTP_POST_FILES);
	//$input = $_GET + $_POST + $HTTP_COOKIE_VARS + $HTTP_SERVER_VARS + $HTTP_SESSION_VARS + $HTTP_ENV_VARS + $HTTP_POST_FILES;

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
if (version_compare(phpversion(), "5.6.0", "<="))
{
	if( !get_magic_quotes_gpc() )
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

		if( is_array($HTTP_COOKIE_VARS) )
		{
			while( list($k, $v) = each($HTTP_COOKIE_VARS) )
			{
				if( is_array($HTTP_COOKIE_VARS[$k]) )
				{
					while( list($k2, $v2) = each($HTTP_COOKIE_VARS[$k]) )
					{
						$HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2);
					}
					@reset($HTTP_COOKIE_VARS[$k]);
				}
				else
				{
					$HTTP_COOKIE_VARS[$k] = addslashes($v);
				}
			}
			@reset($HTTP_COOKIE_VARS);
		}
	}
}

//
// End Of Global Vars Initialization
// ----------------------------------------

/** 
 * create_ref_function
 * Create an anonymous (lambda-style) function
 * which returns a reference
 * see http://php.net/create_function
 */
function
create_ref_function( $args, $code )
{
    static $n = 0;

    $functionName = sprintf('ref_lambda_%d',++$n);
    
    $declaration = sprintf('function &%s(%s) {%s}', $functionName, $args, $code);
    
    eval($declaration);
    
    return $functionName;
}

/**
 * Install Customization Section
 *
 *   This section can be modified to set up some basic default information
 *   used by the install script.  Specifically the default theme data
 *   and the default template.
 */

$available_dbms = array(
	/***
	'firebird'	=> array(
		'LABEL'				=> 'FireBird',
		'name'				=> 'FireBird',		
		'SCHEMA'			=> 'firebird',
		'MODULE'			=> 'interbase',
		'DELIM'				=> ';;',
		'DELIM_BASIC'		=> ';;',		
		'DRIVER'			=> 'firebird',
		'version'			=> '2.0.0',
		'version_check'		=> 'return min(ibase_server_info(), ibase_server_info());',
		'supported'			=> function_exists('ibase_connect'),		
		'AVAILABLE'			=> true,
		'2.0.x'				=> false,
		'COMMENTS'			=> 'mx_remove_remarks'		
	),
	/**/
	'mysql6' => array(
		'LABEL'			=> 'MySQL 6.x',
		'name'			=> 'MySQL',		
		'SCHEMA'		=> 'mysql_61',
		'DELIM'			=> ';',
		'DELIM_BASIC'	=> ';',
		'DRIVER'			=> 'mysqli',		
		'version'			=> '6.0.11-alpha',
		'version_check'		=> 'return min(mysqli_get_server_info(), mysqli_get_client_info());',
		'supported'			=> function_exists('mysqli_connect'),
		'default_user'		=> 'mysql.default_user',
		'default_password'	=> 'mysql.default_password',
		'default_host'		=> 'mysql.default_host',
		'default_port'		=> 'mysql.default_port',
		'utf8_support'		=> true,
		'utf8_version'		=> '4.1.0',
		'utf8_version_check'	=> 'return mysqli_get_server_info();',
		'utf8_default'		=> true,
		'utf8_required'		=> true,
		'alter_support'		=> true,
		'validate_prefix'	=> create_ref_function('&$value', '
			$value = preg_replace(\'~[^A-Za-z0-9_\$]~\', \'\', $value);
			return true;
		'),
		'AVAILABLE'			=> true,
		'2.0.x'				=> true,
		'COMMENTS'		=> 'mx_remove_remarks'
	),	
	// Note: php 5.5 alpha 2 deprecated mysql.
	// Keep mysqli before mysql in this list.
	'mysqli' => array(
		'LABEL'					=> 'MySQL with MySQLi Extension',
		'name'					=> 'MySQL',		
		'SCHEMA'				=> 'mysql_41',
		'DELIM'					=> ';',
		'DELIM_BASIC'		=> ';',
		'DRIVER'				=> 'mysqli',		
		'version'					=> '4.1.0',
		'version_check'		=> 'return min(mysqli_get_server_info(), mysqli_get_client_info());',
		'supported'				=> function_exists('mysqli_connect'),
		'default_user'		=> 'mysql.default_user',
		'default_password'	=> 'mysql.default_password',
		'default_host'			=> 'mysql.default_host',
		'default_port'			=> 'mysql.default_port',
		'utf8_support'		=> true,
		'utf8_version'			=> '4.1.0',
		'utf8_version_check'	=> 'return mysqli_get_server_info();',
		'utf8_default'			=> false,
		'utf8_required'		=> false,
		'alter_support'		=> true,
		'validate_prefix'	=> create_ref_function('&$value', '
			$value = preg_replace(\'~[^A-Za-z0-9_\$]~\', \'\', $value);
			return true;
		'),
		'AVAILABLE'			=> true,
		'2.0.x'							=> true,
		'COMMENTS'			=> 'mx_remove_remarks'
	),
	'mysql4' => array(
		'LABEL'					=> 'MySQL 4.x',
		'name'					=> 'MySQL',
		'SCHEMA'				=> 'mysql',
		'DELIM'					=> ';',
		'DELIM_BASIC'	=> ';',
		'version'					=> '4.0.18',
		'version_check'		=> 'return min(mysql_get_server_info(), mysql_get_client_info());',
		'supported'				=> function_exists('mysql_connect'),
		'default_user'		=> 'mysql.default_user',
		'default_password'	=> 'mysql.default_password',
		'default_host'			=> 'mysql.default_host',
		'default_port'			=> 'mysql.default_port',
		'utf8_support'		=> true,
		'utf8_version'			=> '4.1.0',
		'utf8_version_check'	=> 'return mysql_get_server_info();',
		'utf8_default'			=> false,
		'utf8_required'		=> false,
		'alter_support'		=> true,
		'validate_prefix'	=> create_ref_function('&$value', '
			$value = preg_replace(\'~[^A-Za-z0-9_\$]~\', \'\', $value);
			return true;
		'),
		'AVAILABLE'			=> true,
		'2.0.x'							=> true,		
		'COMMENTS'			=> 'mx_remove_remarks'
	),
	'mysql' => array(
		'LABEL'					=> 'MySQL 3.x',
		'name'					=> 'MySQL',
		'SCHEMA'				=> 'mysql',
		'DELIM'					=> ';',
		'DELIM_BASIC'	=> ';',
		'DRIVER'				=> 'mysql',
		'version'					=> '3.0.21',
		'version_check'		=> 'return min(mysql_get_server_info(), mysql_get_client_info());',
		'supported'				=> function_exists('mysql_connect'),
		'default_user'		=> 'mysql.default_user',
		'default_password'	=> 'mysql.default_password',
		'default_host'			=> 'mysql.default_host',
		'default_port'			=> 'mysql.default_port',
		'utf8_support'		=> false,
		'utf8_version'			=> '4.1.0',
		'utf8_version_check'	=> 'return mysql_get_server_info();',
		'utf8_default'			=> false,
		'utf8_required'		=> false,
		'alter_support'		=> false,
		'validate_prefix'	=> create_ref_function('&$value', '
			$value = preg_replace(\'~[^A-Za-z0-9_\$]~\', \'\', $value);
			return true;
		'),	
		'AVAILABLE'	=> true,
		'2.0.x'					=> true,		
		'COMMENTS'	=> 'mx_remove_remarks'
	),
	/**
	'mssql' => array(
		'LABEL'				=> 'MS SQL Server 7/2000',
		'SCHEMA'			=> 'mssql',
		'DELIM'				=> 'GO',
		'DELIM_BASIC'	=> ';',
		'DRIVER'			=> 'mssql',
		'AVAILABLE'	=> true,
		'2.0.x'					=> true,		
		'COMMENTS'	=> 'mx_remove_comments'
	),
	/**/
	/**
	'msaccess' => array(
		'LABEL'				=> 'MS Access [ ODBC ]',
		'SCHEMA'			=> '',
		'DELIM'				=> '',
		'DELIM_BASIC'	=> ';',
		'DRIVER'			=> 'mssql',
		'AVAILABLE'	=> true,
		'2.0.x'					=> true,		
		'COMMENTS'	=> ''
	),
	/**/
	/*
	'mssql_odbc'=>	array(
		'LABEL'			=> 'MS SQL Server [ ODBC ]',
		'SCHEMA'		=> 'mssql',
		'MODULE'		=> 'odbc',
		'DELIM'			=> 'GO',
		'DELIM_BASIC'	=> 'GO',
		'DRIVER'				=> 'mssql_odbc',		
		'AVAILABLE'		=> true,
		'2.0.x'						=> true,		
		'COMMENTS'		=> 'mx_remove_comments'			
	),
	*/
	/**
	'mssqlnative'				=> array(
		'LABEL'					=> 'MS SQL Server 2005+ [ Native ]',
		'SCHEMA'				=> 'mssql',
		'MODULE'				=> 'sqlsrv',
		'DELIM'					=> 'GO',
		'DRIVER'				=> 'mssqlnative',
		'AVAILABLE'		=> true,
		'2.0.x'						=> false,
		'COMMENTS'		=> 'mx_remove_comments'		
	),
	/**/
	/**
	'oracle'	=>	array(
		'LABEL'			=> 'Oracle',
		'SCHEMA'		=> 'oracle',
		'MODULE'		=> 'oci8',
		'DELIM'			=> '/',
		'DRIVER'		=> 'oracle',
		'supported' 	=> function_exists('ocinlogon'),		
		'AVAILABLE'		=> true,
		'2.0.x'			=> false,
		'COMMENTS'		=> 'mx_remove_comments'		
	),
	/**/
	'postgres' => array(
		'LABEL'				=> 'PostgreSQL 8.3+',
		'name'				=> 'PostgreSQL',
		'SCHEMA'			=> 'postgres',
		'MODULE'			=> 'pgsql',
		'DELIM'				=> ';',
		'DELIM_BASIC'	=> ';',
		'DRIVER'			=> 'postgres',
		'version'				=> '8.0',
		'function_check'	=> 'pg_connect',
		'version_check'		=> '$request = pg_query(\'SELECT version()\'); list ($version) = pg_fetch_row($request); list($pgl, $version) = explode(" ", $version); return $version;',
		'supported' 		=> function_exists('pg_connect'),
		'always_has_db'	=> true,
		'utf8_default'		=> true,
		'utf8_required'	=> true,
		'utf8_support'	=> true,
		'utf8_version'		=> '8.0',
		'utf8_version_check'	=> '$request = pg_query(\'SELECT version()\'); list ($version) = pg_fetch_row($request); list($pgl, $version) = explode(" ", $version); return $version;',
		'validate_prefix' => create_ref_function('&$value', '
			$value = preg_replace(\'~[^A-Za-z0-9_\$]~\', \'\', $value);

			// Is it reserved?
			if ($value == \'pg_\')
				return $txt[\'error_db_prefix_reserved\'];

			// Is the prefix numeric?
			if (preg_match(\'~^\d~\', $value))
				return $txt[\'error_db_prefix_numeric\'];

			return true;
		'),		
		'AVAILABLE'		=> true,
		'2.0.x'						=> true,
		'COMMENTS'		=> 'mx_remove_comments'		
	),
	/**/
	'sqlite'	=> array(
		'LABEL'				=> 'SQLite',
		'name'				=> 'SQLite',
		'SCHEMA'			=> 'sqlite',
		'MODULE'			=> 'sqlite',
		'DELIM'				=> ';',
		'DELIM_BASIC'		=> ';',
		'DRIVER'			=> 'sqlite',
		'version' 			=> '1',
		'function_check'	=> 'sqlite_open',
		'version_check'		=> 'return 1;',
		'supported' 		=> function_exists('sqlite_open'),
		'always_has_db' 	=> true,
		'utf8_default' 		=> true,
		'utf8_support'		=> true,
		'utf8_required'		=> true,
		'validate_prefix'	=> create_ref_function('&$value', '
			global $incontext, $txt;

			$value = preg_replace(\'~[^A-Za-z0-9_\$]~\', \'\', $value);

			// Is it reserved?
			if ($value == \'sqlite_\')
				return $txt[\'error_db_prefix_reserved\'];

			// Is the prefix numeric?
			if (preg_match(\'~^\d~\', $value))
				return $txt[\'error_db_prefix_numeric\'];

			return true;
		'),
		'AVAILABLE'	=> true,
		'2.0.x'					=> false,
		'COMMENTS'	=> 'mx_remove_comments'
	),
	
	/**/
	'sqlite3'	=> array(
		'LABEL'			=> 'SQLite3',
		'SCHEMA'		=> 'sqlite',
		'MODULE'		=> 'sqlite3',
		'DELIM'			=> ';',
		'DRIVER'		=> 'sqlite3',
		'version' 		=> '3',
		'function_check'	=> 'sqlite_open',
		'version_check'		=> 'return 3;',
		'supported' 			=> function_exists('sqlite_open'),
		'always_has_db' 	=> true,
		'utf8_default' 			=> true,
		'utf8_support'		=> true,		
		'utf8_required'		=> true,
		'validate_prefix'	=> create_ref_function('&$value', '
			global $incontext, $txt;

			$value = preg_replace(\'~[^A-Za-z0-9_\$]~\', \'\', $value);

			// Is it reserved?
			if ($value == \'sqlite_\')
				return $txt[\'error_db_prefix_reserved\'];

			// Is the prefix numeric?
			if (preg_match(\'~^\d~\', $value))
				return $txt[\'error_db_prefix_numeric\'];

			return true;
		'),			
		'AVAILABLE'		=> true,
		'2.0.x'						=> false,
		'COMMENTS'		=> 'mx_remove_comments'		
	),
	/**/	
);

// ------------------------------
// DEBUG ONLY ;-)
//
//error_reporting(E_ALL);
// ------------------------------

// ================================================================================
// HERE BEGINS THE PARTY...
// ================================================================================
include($mx_root_path . 'includes/mx_functions_core.' . $phpEx); // CORE class
include($mx_root_path . "install/includes/functions_install.$phpEx");

//
// Get the current document root for temp backend search path.
//
if (isset($_SERVER['DOCUMENT_ROOT']) )
{
	$backend_search_path = $_SERVER['DOCUMENT_ROOT'];
}
elseif(isset($DOCUMENT_ROOT) )
{
	$backend_search_path = $DOCUMENT_ROOT;
}
else
{
	$backend_search_path= './';
}

/*
* Get the absolute path to this MX-Publisher installation.
*/
$mx_absolute_path = str_replace('\\', '/', substr(__FILE__, 0, - strlen('install/' . basename(__FILE__))));

//Get the MX-Publisher base dir (computed from the phpbb search path), for example /mx/, /portal/ or /
$mx_base_path = substr($mx_absolute_path, strlen($backend_search_path));

// Get the current Server URL.
$server_url = ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'];

// Get the MX-Publisher Path in the URL (this might not be the same as the base path when using aliases).
$mx_self_path = substr($_SERVER['PHP_SELF'], 0, -strlen('install/'.basename(__FILE__)));

// Get the MX-Publisher URL.
$portal_url = $server_url . $mx_self_path;

//Define Portal URL
@define('PORTAL_URL', $portal_url);

// Get the phpBB URL and DB Charset
@define('PHPBB_URL', PORTAL_URL.'/forum/');

//Get fragmented xhtml extension
$tplEx = @install_file_exists($mx_root_path.'install/templates/mx_install_header.html') ? 'html' : 'tpl';

$userdata = array();
$lang = array();
$template = false;
$db = false;
$process_msgs = array();
$process_vars = array();
$process_errors = 0;

/*
* instatiate the mx_request_vars class
* make sure to do before it's ever used
**/
$mx_request_vars = new mx_request_vars();

/*
* Send file --------------------------------------------------
*/
if ($mx_request_vars->post('send_file', MX_TYPE_INT) == 1)
{
	header( "Content-Type: text/x-delimtext; name=\"config.$phpEx\"" );
	header( "Content-disposition: attachment; filename=config.$phpEx" );

	// We need to stripslashes no matter what the setting of magic_quotes_gpc is
	// because we add slahes at the top if its off, and they are added automaticlly
	// if it is on. $mx_request_vars->post strips slashes

	echo $mx_request_vars->post('config_data', MX_TYPE_NO_TAGS);
	exit;
}

/*
* phpInfo --------------------------------------------------
*/
if ($mx_request_vars->is_get('phpinfo') )
{
	show_phpinfo();
	exit;
}

/*
* Load the installation language
*/
if ($mx_request_vars->is_get('lang') )
{
	$language = $mx_request_vars->request('lang', MX_TYPE_NO_TAGS);
}
else
{
	$language = $mx_request_vars->request('language', MX_TYPE_NO_TAGS);
}

$language = (preg_match('#^[a-z_]+$#', $language) ? strip_tags($language) : '');

if (empty($language))
{
	$language = guess_lang();
	$lang_options = '';
	
	//
	// If there's only a language installed, we can simply bypass the
	// language selection panel ...and guess what, use that one. ;-)
	//
	if (install_language_select($lang_options, $language, 'language') > 1)
	{
		if (@install_file_exists($mx_root_path . "install/language/lang_$language/lang_admin.$phpEx") )
		{
			include($mx_root_path . "install/language/lang_$language/lang_admin.$phpEx");
		}
		else
		{
			include($mx_root_path . "install/language/lang_english/lang_admin.$phpEx");
		}
		$s_hidden_fields = '';

		include_once($mx_root_path . "install/includes/template.$phpEx");

		$template = new Template($mx_root_path . 'install/templates');
		page_header_install($lang['Welcome_install'], $lang['Choose_lang_explain']);
		
		$template->set_filenames(array('language' => 'mx_install_language.'.$tplEx));
		$template->assign_vars(array(
			'L_INITIAL_CONFIGURATION'	=> $lang['Install_settings'],
			'S_FORM_ACTION'						=> "mx_install.$phpEx",
			'L_LANGUAGE'								=> $lang['Language'],
			'S_LANG_SELECT'						=> $lang_options,
			'S_HIDDEN_FIELDS'						=> $s_hidden_fields,
			'L_SUBMIT'										=> $lang['Choose_lang'],
		));

		$template->pparse('language');
		page_footer_install();
	}
}

if (!@install_file_exists($mx_root_path . "install/language/lang_$language/lang_admin.$phpEx"))
{
	$language = guess_lang();
}

if (!@install_file_exists($mx_root_path . "install/language/lang_$language/lang_admin.$phpEx"))
{
	include($mx_root_path . "install/language/lang_english/lang_admin.$phpEx");
	$language = 'english';
}
else
{
	include($mx_root_path . "install/language/lang_$language/lang_admin.$phpEx");
}

$board_email = $mx_request_vars->post('board_email', MX_TYPE_NO_TAGS);
$script_path = !$mx_request_vars->is_empty_post('script_path') ? $mx_request_vars->post('script_path', MX_TYPE_NO_TAGS) : str_replace('install', '', dirname($_SERVER['PHP_SELF']));

if (!$mx_request_vars->is_empty_post('server_name'))
{
	$server_name = $mx_request_vars->post('server_name', MX_TYPE_NO_TAGS);
}
else
{
	// Guess at some basic info used for install..
	if (!empty($_SERVER['SERVER_NAME']) || !empty($_ENV['SERVER_NAME']))
	{
		$server_name = (!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : $_ENV['SERVER_NAME'];
	}
	else if (!empty($_SERVER['HTTP_HOST']) || !empty($_ENV['HTTP_HOST']))
	{
		$server_name = (!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : $_ENV['HTTP_HOST'];
	}
	else
	{
		$server_name = '';
	}
}

if (!$mx_request_vars->is_post('server_port'))
{
	$server_port = $mx_request_vars->post('server_port', MX_TYPE_NO_TAGS);
}
else
{
	if (!empty($_SERVER['SERVER_PORT']) || !empty($_ENV['SERVER_PORT']))
	{
		$server_port = (!empty($_SERVER['SERVER_PORT'])) ? $_SERVER['SERVER_PORT'] : $_ENV['SERVER_PORT'];
	}
	else
	{
		$server_port = '80';
	}
}

/*
* Do install --------------------------------------------------
*/
$confirm = $mx_request_vars->is_request('confirm') && !$mx_request_vars->is_post('debug');

if($confirm)
{
	$install_mode = $mx_request_vars->request('install_mode', MX_TYPE_NO_TAGS);
	$install_mode = (preg_match('#^[a-z_]+$#', $install_mode) ? strip_tags($install_mode) : '');

	$schemas = array();
	
	switch($install_mode)
	{
		case 'install':

			if ($mx_request_vars->is_post('mxbb'))
			{
				$portal_url = $mx_request_vars->post('portal_url', MX_TYPE_NO_TAGS, '');
				$backend_path = $mx_request_vars->post('backend_path', MX_TYPE_NO_TAGS, 'forum/');
				$portal_backend = $mx_request_vars->post('portal_backend', MX_TYPE_NO_TAGS, 'internal');			

				//UTF-8 require to have same database in phpBB3 and mxp and mysqli is preferable
				$dbms_type = ($portal_backend === 'internal') ? 'dbms_mxbb' : 'dbms';				
				
				$backend_url = $mx_request_vars->post('backend_url', MX_TYPE_NO_TAGS);
				$dbms = $mx_request_vars->post($dbms_type, MX_TYPE_NO_TAGS);

				$dbhost = $mx_request_vars->post('dbhost_mxbb', MX_TYPE_NO_TAGS);
				$dbname = $mx_request_vars->post('dbname_mxbb',MX_TYPE_NO_TAGS);
				$dbuser = $mx_request_vars->post('dbuser_mxbb', MX_TYPE_NO_TAGS);
				$dbpasswd = $mx_request_vars->post('dbpasswd_mxbb', MX_TYPE_NO_TAGS);
				$mx_table_prefix = $mx_request_vars->post('mx_prefix', MX_TYPE_NO_TAGS);
				$dbcharacter_set = $mx_request_vars->post('dbcharacter_set_mxbb', MX_TYPE_NO_TAGS);
				$admin_name = !$mx_request_vars->is_empty_post('admin_name_mxbb') ? $mx_request_vars->post('admin_name_mxbb', MX_TYPE_NO_TAGS, 'admin') : 'admin';
				$admin_pass1 = !$mx_request_vars->is_empty_post('admin_pass1_mxbb') ? $mx_request_vars->post('admin_pass1_mxbb', MX_TYPE_NO_TAGS, 'admin') : 'admin';
				$admin_pass2 = !$mx_request_vars->is_empty_post('admin_pass2_mxbb') ? $mx_request_vars->post('admin_pass2_mxbb', MX_TYPE_NO_TAGS, 'admin') : 'admin';

			}
			else
			{
				$portal_url = $mx_request_vars->post('portal_url', MX_TYPE_NO_TAGS);
				$backend_path = $mx_request_vars->post('backend_path', MX_TYPE_NO_TAGS);
				$dbms = $mx_request_vars->post('dbms', MX_TYPE_NO_TAGS);
				$dbhost = $mx_request_vars->post('dbhost', MX_TYPE_NO_TAGS);
				$dbname = $mx_request_vars->post('dbname', MX_TYPE_NO_TAGS);
				$dbuser = $mx_request_vars->post('dbuser', MX_TYPE_NO_TAGS);
				$dbpasswd = $mx_request_vars->post('dbpasswd', MX_TYPE_NO_TAGS);
				$table_prefix = $mx_request_vars->post('prefix', MX_TYPE_NO_TAGS);
				$dbcharacter_set = $mx_request_vars->post('dbcharacter_set', MX_TYPE_NO_TAGS);				
				$mx_table_prefix = $mx_request_vars->post('mx_prefix', MX_TYPE_NO_TAGS);
				$portal_backend = $mx_request_vars->post('portal_backend', MX_TYPE_NO_TAGS, 'internal');
				$admin_name = !$mx_request_vars->is_empty_post('admin_name') ? $mx_request_vars->post('admin_name', MX_TYPE_NO_TAGS) : 'admin';
				$admin_pass1 = !$mx_request_vars->is_empty_post('admin_pass1') ? $mx_request_vars->post('admin_pass1', MX_TYPE_NO_TAGS, 'admin') : 'admin';
				$admin_pass2 = !$mx_request_vars->is_empty_post('admin_pass2') ? $mx_request_vars->post('admin_pass2', MX_TYPE_NO_TAGS, 'admin') : 'admin';
			}			
			
			@define('PORTAL_BACKEND', $portal_backend);			
			
			switch (PORTAL_BACKEND)
			{
				case 'internal':
					$tplEx = 'tpl';
					$backendtype = 'mxbb';	
					$config_settings = 'config';
				break;
				case 'smf2':
					$tplEx = 'php';
					$backendtype = 'smf';
					$config_settings = 'Settings';
				break;
				case 'mybb':
					$tplEx = 'php';
					$backendtype = 'mybb';
					$config_settings = 'inc/config';
				break;
				case 'phpbb2':
					$tplEx = 'tpl';
					$backendtype = 'phpbb';
					$config_settings = 'config';
				break;
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
				case 'proteus':
					$tplEx = 'html';
					$backendtype = 'phpbb';
					$config_settings = 'config';
				break;
			}
			
			if ($mx_request_vars->is_post('backend'))
			{
				if ($mx_request_vars->is_post('backend'))
				
				//$portal_backend = install_file_exists($mx_root_path . $backend_path . "modcp.$phpEx") ? 'phpbb2' : 'phpbb3';
				
				switch ($backendtype)
				{
					case 'mxbb':
						$backend_info = get_mxbb_info($mx_root_path . $backend_path . "$config_settings.$phpEx");
					break;
					case 'phpbb':
						$backend_info = get_phpbb_info($mx_root_path . $backend_path . "config.$phpEx");
					break;
					case 'smf2':
						$backend_info = get_smf_info($mx_root_path . $backend_path . "Settings.$phpEx");					
					break;
					case 'mybb':
						$backend_info = array_merge(get_mybb_info($mx_root_path . $backend_path . "inc/config.$phpEx"), get_mybb_settings($mx_root_path . $backend_path . "inc/settings.$phpEx"));
					break;
				}
		
				if (!isset($backend_info['dbms']) || $backend_info['dbms'] != $dbms || $backend_info['dbhost'] != $dbhost || $backend_info['dbname'] != $dbname || $backend_info['dbuser'] != $dbuser || $backend_info['dbpasswd'] != $dbpasswd || $backend_info['table_prefix'] != $table_prefix )
				{
					install_die(sprintf($lang['phpBB_nfnd_retry'], '<a href="javascript:history.go(-1);">', '</a>'));
				}				
			}
			
			if (empty($portal_url) || empty($dbms) || empty($dbhost) || empty($dbname) || empty($dbuser) || empty($mx_table_prefix) )
			{
				install_die(sprintf($lang['MissingVariables'], '<a href="javascript:history.go(-1);">', '</a>'));
				break;
			}

			if ( $admin_pass1 != $admin_pass2 )
			{
				install_die(sprintf($lang['PasswordMissmatch'], '<a href="javascript:history.go(-1);">', '</a>'));
				break;
			}

			//
			// Trailing slashes are very important for the URLs we need to store in the mx_portal table.
			//			
			if ( substr($backend_url, -1) != '/' )
			{
				$backend_url .= '/';
			}
			
			if ( substr($portal_url, -1) != '/' )
			{
				$portal_url .= '/';
			}

			if (install_file_exists($mx_root_path . "config.$phpEx") )
			{
				include($mx_root_path . "config.$phpEx");
				$backend_root_path = (isset($phpbb_root_path) ? $phpbb_root_path : $backend_root_path);
			}

			/*
			* Create fresh config.php
			*/
			if (!defined('MX_INSTALLED') || (MX_INSTALLED === false) )
			{
				$process_msgs[] = $lang['Writing_config'] . ' ...<br />';

				$config_data = "<"."?php\n\n";
				$config_data .= "// $mx_portal_name auto-generated config file\n// Do not change anything in this file!\n\n";
				$config_data .= "// This file must be put into the $mx_portal_name directory, not into the phpBB directory.\n\n";
				$config_data .= '$'."dbms = '$dbms';\n\n";
				$config_data .= '$'."dbhost = '$dbhost';\n";
				$config_data .= '$'."dbname = '$dbname';\n";
				$config_data .= '$'."dbuser = '$dbuser';\n";
				$config_data .= '$'."dbpasswd = '$dbpasswd';\n\n";
				$config_data .= '$'."mx_table_prefix = '$mx_table_prefix';\n\n";
				$config_data .= "define('DBCHARACTER_SET', '$dbcharacter_set');\n\n";	
				$config_data .= "define('MX_INSTALLED', true);\n\n";
				$config_data .= '?' . '>';	// Done this to prevent highlighting editors getting confused!

				@umask(0111);
				@chmod($mx_root_path . "config.$phpEx", 0644);
				
				if(!install_file_exists($mx_root_path . 'config.php') && @file_exists($mx_root_path . 'config.php.contrib'))
				{
					@copy($mx_root_path . 'config.php.contrib', $mx_root_path . 'config.php');
				}
				@chmod ($mx_root_path . 'config.php', 0644); 

				if ( !($fp = @fopen($mx_root_path.'config.' . $phpEx, 'w')) )
				{
					$arg_mxbb_url = '<span style="color:blue;">' . $portal_url . '</span>';
					$arg_inst_url = '<a href="javascript:history.go(0);">';
					$instruction_text = sprintf($lang['Unwriteable_config'], $arg_mxbb_url, $arg_inst_url, '</a>');

					$s_hidden_fields = '<input type="hidden" name="send_file" value="1" />'.
						'<input type="hidden" name="config_data" value="' . htmlspecialchars($config_data) . '" />';

					include_once($mx_root_path . "install/includes/template.$phpEx");
					
					$template = new Template($mx_root_path . 'install/templates');
					
					page_header_install($lang['Welcome_install'], $instruction_text);
					
					$template->set_filenames(array('button' => 'mx_install_button.'.$tplEx));
					
					$template->assign_vars(array(
						'S_FORM_ACTION'			=> "mx_install.$phpEx",
						'S_HIDDEN_FIELDS'		=> $s_hidden_fields,
						'L_SUBMIT'				=> $lang['Send_file'],
					));
					
					$template->pparse('button');
					
					page_footer_install();
				}
				$result = @fputs($fp, $config_data, strlen($config_data));
				@fclose($fp);

				$process_msgs[] = '<span style="color:green;">'.str_replace("\n", "<br />\n", htmlspecialchars($config_data)).'</span>';
			}

			$schemas[] = 'install';
			break;
			
		case 'upgrade':
			if (install_file_exists($mx_root_path . "config.$phpEx") )
			{
				include($mx_root_path . "config.$phpEx");
			}
			
			/*
			* Update config.php (if upgrading from 2.8.x)
			*/
			if( defined('MX_INSTALLED') && defined('PHPBB_INSTALLED') )
			{
				$upgrade_mode = 'from28x';
				
				$process_msgs[] = $lang['Writing_config'] . ' ...<br />';
				
				$config_data = "<"."?php\n\n";
				$config_data .= "// $mx_portal_name auto-generated config file\n// Do not change anything in this file!\n\n";
				$config_data .= "// This file must be put into the $mx_portal_name directory, not into the phpBB directory.\n\n";
				$config_data .= '$'."dbms = '$dbms';\n\n";
				$config_data .= '$'."dbhost = '$dbhost';\n";
				$config_data .= '$'."dbname = '$dbname';\n";
				$config_data .= '$'."dbuser = '$dbuser';\n";
				$config_data .= '$'."dbpasswd = '$dbpasswd';\n\n";
				$config_data .= '$'."mx_table_prefix = '$mx_table_prefix';\n\n";
				$config_data .= "define('DBCHARACTER_SET', '$dbcharacter_set');\n\n";				
				$config_data .= "define('MX_INSTALLED', true);\n\n";
				$config_data .= '?' . '>';	// Done this to prevent highlighting editors getting confused!
				
				@umask(0111);
				@chmod($mx_root_path . "config.$phpEx", 0644);
				
				if ( !($fp = @fopen($mx_root_path.'config.' . $phpEx, 'w')) )
				{
					$arg_mxbb_url = '<span style="color:blue;">' . $portal_url . '</span>';
					$arg_inst_url = '<a href="javascript:history.go(0);">';
					$instruction_text = sprintf($lang['Unwriteable_config'], $arg_mxbb_url, $arg_inst_url, '</a>');
					
					$s_hidden_fields = '<input type="hidden" name="send_file" value="1" />'.
						'<input type="hidden" name="config_data" value="' . htmlspecialchars($config_data) . '" />';
						
					include_once($mx_root_path . "install/includes/template.$phpEx");
					
					$template = new Template($mx_root_path . 'install/templates');
					
					page_header_install($lang['Welcome_install'], $instruction_text);
					
					$template->set_filenames(array('button' => 'mx_install_button.'.$tplEx));
					
					$template->assign_vars(array(
						'S_FORM_ACTION'		=> "mx_install.$phpEx",
						'S_HIDDEN_FIELDS'		=> $s_hidden_fields,
						'L_SUBMIT'						=> $lang['Send_file'],
					));
					
					$template->pparse('button');
					
					page_footer_install();
				}
				$result = @fputs($fp, $config_data, strlen($config_data));
				@fclose($fp);
				
				$process_msgs[] = '<span style="color:green;">'.str_replace("\n", "<br />\n", htmlspecialchars($config_data)).'</span>';
			}
			$schemas[] = 'upgrade';
			break;
	}	// switch
	
	if(count($schemas) > 0)
	{
		$install_title = ($install_mode == 'install' ? $lang['Portal_intalling'] : $lang['Portal_upgrading']);
		$install_title = sprintf($install_title, $mx_portal_version);
		
		/*
		* Ok, let's load the MX-Publisher config.php
		*/
		if (install_file_exists($mx_root_path . "config.$phpEx") )
		{
			include($mx_root_path . "config.$phpEx");
			$current_template_path = $mx_root_path . 'install/templates/';
			include($mx_root_path . "includes/mx_constants.$phpEx");
		}
		
		if( !defined('MX_INSTALLED') || (MX_INSTALLED === false) )
		{
			install_die('<b>'.$lang['Critical_Error'].':</b><br /><br />'.$lang['Error_loading_config']);
		}
		
		/*
		* Connect to the database
		*/
		include($mx_root_path . "includes/sessions/internal/constants.$phpEx");
		include($mx_root_path . 'includes/db/' . $dbms . '.' . $phpEx); // Load dbal and initiate class
		
		if (!$db->db_connect_id)
		{
			install_die('<b>'.$lang['Critical_Error'].':</b><br /><br />'.$lang['Error_database_down']);
		}
		
		/*
		* If we need to upgrade, we need to guess from which point,
		* so we need the DB open, and now we do. ;-)
		*/
		if( $schemas[0] == 'upgrade' )
		{
			$schemas = get_upgrade_schemas();
		}
		
		// Process all SQL schemas
		for($i = 0; $i < count($schemas); $i++)
		{
			$schema_name = $available_dbms[$dbms]['SCHEMA'].'_schema_'.$schemas[$i].'.sql';
			$schema_file = $mx_root_path.'install/schemas/'.$schema_name;
			// Is some database support even compiled in?
			if (install_file_exists($schema_file))
			{
				$process_msgs[] = '<hr />';
				$process_msgs[] = sprintf($lang['Processing_schema'], $schema_name) . ' ...<br />';
				parse_schema($schema_file);
			}
			else
			{
				$available_dbms[$dbms]['AVAILABLE'] = false;
			}			
		}
			
		// Postprocessing, final touches...
		$process_msgs[] = '<hr />';
		$process_msgs[] = $install_title . '...<br />';
		exec_post_process($install_mode, $upgrade_mode);
		
		/* Update cache? Only if we really processed one or more schemas.
		*if( $install_mode == 'upgrade' && count($schemas) > 0 )
		**/
		if(count($schemas) > 0 && install_file_exists($mx_root_path . "includes/mx_functions." . $phpEx))
		{
			$sql = 'SELECT * FROM '.PORTAL_TABLE.' WHERE portal_id = 1';
			if( ($result = $db->sql_query($sql)) )
			{
				$portal_config = $db->sql_fetchrow($result);
				$mx_cache = new mx_cache();
				$mx_cache->trash('install');
				$mx_cache->update();
				$mx_cache->tidy(); // Not really needed
				$mx_cache->destroy('backend_config'); // Not really needed
				$mx_cache->destroy('mxbb_config'); // Not really needed
				$mx_cache->unload();
				$process_msgs[] = $lang['Cache_generate'];
			}
		}
		
		/*
		* Generate processing report and bye.
		**/
		$message = '<hr />';
		
		for( $i=0; $i < count($process_msgs); $i++ )
		{
			$message .= $process_msgs[$i] . ( $process_msgs[$i] == '<hr />' ? '' : '<br />' ) . "\n";
		}
		
		$message .= '<hr />';
		$warning = ( $process_errors == 1 ? $lang['Install_warning'] : sprintf($lang['Install_warnings'], $process_errors) );
		$message .= '<span' . ( $process_errors > 0 ? ' style="color:orange;"' : '' ) . '>' . $warning . '</span><br />';
		$message .= '<hr />';
		$message .= '<p>' . sprintf($lang['Subscribe_mxBB_News_now'], '<a href="'.U_MXBB_NEWS_INFO.'" target="_blank">', '</a>', '<a href="'.U_MXBB_NEWS_NOW.'" target="_blank">', '</a>') . '</p>';
		$message .= '<hr />';
		$message .= '<p><b>' . ( $install_mode == 'install' ? $lang['Portal_intalled'] : $lang['Portal_upgraded'] ) . '</b></p>';
		
		if ($install_mode == 'install')
		{
			$message .= '<hr />';
		
			//Creating the forum page
			switch (PORTAL_BACKEND)
			{
				case 'internal':			
				break;
				
				case 'phpbb2':
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
				case 'proteus':				
					$sql = array();
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('6', 'Poll', 'This is a Demo Block', '14', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125841942', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('16', 'Last Message Post', 'This is a Demo Block', '31', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125842159', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('18', 'Announcements', 'This is a Demo Block', '2', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125868467', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('24', 'Forum', 'This is a Demo Block', '8', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125841817', '2')";			
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('26', 'Statistics', 'This is a Demo Block', '41', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125842177', '2')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('6', '36', '', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('6', '13', '0', NULL, '0')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '17', '5', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '18', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '19', '30', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '20', '_self', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '21', 'left', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '22', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '37', '', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '38', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '39', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '40', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '95', '5', NULL, '0')";				
					

					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '1', '3', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '2', '10', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '3', 'TRUE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '4', 'TRUE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '5', 'FALSE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '7', 'thumb_news.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '8', 'thumb_globe.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '9', 'thumb_globe.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '6', 'TRUE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '10', 'thumb_globe.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '11', '', '', '0')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('8', 'Main', '50', NULL, '100%', '4')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('7', 'Left', '40', NULL, '200', '4')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('4', 'Main', '50', NULL, '100%', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('3', 'Left', '40', NULL, '200', '2')";

					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('4', '19', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('8', '19', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('4', '24', '10')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('3', '16', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('8', '26', '10')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('7', '8', '10')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('5', '7', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('3', '13', '30')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('3', '8', '10')";				

					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('8', '30', 'phpBB Index', 'phpBB Index Block', 'mx_forum." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('14', '30', 'MXP Polls', 'MXP Polls', 'mx_poll." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('2', '30', 'phpBB Announcements', 'phpBB Announcements Block', 'mx_announce." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('31', '30', 'Last Posts', 'phpBB Last Posts Function', 'mx_last_msg." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('41', '30', 'Statistics', 'Site Statistics Function', 'mx_statistics." . $phpEx . "', '')";

					$sql[] = "INSERT INTO " . $mx_table_prefix . "page VALUES('2', 'Forum', 'This is the phpBB Forum startpage', '0', '', '20', 'icon_forum.gif', '', '', '', '', '1', '0', '0', '0', '-1', '-1', 'overall_header_navigation_phpbb." . $tplEx . "', '', '', '0', 'a:1:{i:0;s:0:\"\";}', '1')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "page VALUES('4', 'Sitestats', 'Sitestats page', '0', '', '40', 'icon_stats.gif', '', '', '', '', '1', '0', '0', '0', '-1', '-1', '', '', '', '0', 'a:1:{i:0;s:0:\"\";}', '-1')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('1', '2', 'announce_nbr_display', 'Number', '1', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('2', '2', 'announce_nbr_days', 'Number', '14', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('3', '2', 'announce_display', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('4', '2', 'announce_display_sticky', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('5', '2', 'announce_display_normal', 'Boolean', 'FALSE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('7', '2', 'announce_img', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('8', '2', 'announce_img_sticky', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('9', '2', 'announce_img_normal', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('6', '2', 'announce_display_global', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('10', '2', 'announce_img_global', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('11', '2', 'announce_forum', 'Function', '', 'get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)', '0', '0')";

					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('13', '14', 'Poll_Display', 'Function', '0', 'poll_select( {parameter_value}, \"{parameter_id}\" )', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('36', '14', 'poll_forum', 'Function', '', 'get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)', '0', '0')";


					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('17', '31', 'Last_Msg_Number_Title', 'Number', '15', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('18', '31', 'Last_Msg_Display_Date', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('19', '31', 'Last_Msg_Title_Length', 'Number', '33', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('20', '31', 'Last_Msg_Target', 'Values', '_blank', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('21', '31', 'Last_Msg_Align', 'Values', 'left', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('22', '31', 'Last_Msg_Display_Forum', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('37', '31', 'Last_Msg_forum', 'Function', '', 'get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('38', '31', 'Last_Msg_Display_Last_Author', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('39', '31', 'Last_Msg_Display_Author', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('40', '31', 'Last_Msg_Display_Icon_View', 'Boolean', 'TRUE', '', '0', '0')";
				break;
				
				case 'smf2':
				
					$sql = array();
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('6', 'Poll', 'This is a Demo Block', '14', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125841942', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('16', 'Last Message Post', 'This is a Demo Block', '31', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125842159', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('18', 'Announcements', 'This is a Demo Block', '2', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125868467', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('24', 'Forum', 'This is a Demo Block', '8', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125841817', '2')";			
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('26', 'Statistics', 'This is a Demo Block', '41', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125842177', '2')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('6', '36', '', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('6', '13', '0', NULL, '0')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '17', '5', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '18', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '19', '30', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '20', '_self', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '21', 'left', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '22', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '37', '', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '38', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '39', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '40', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '95', '5', NULL, '0')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '1', '3', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '2', '10', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '3', 'TRUE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '4', 'TRUE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '5', 'FALSE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '7', 'thumb_news.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '8', 'thumb_globe.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '9', 'thumb_globe.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '6', 'TRUE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '10', 'thumb_globe.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '11', '', '', '0')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('8', 'Main', '50', NULL, '100%', '4')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('7', 'Left', '40', NULL, '200', '4')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('4', 'Main', '50', NULL, '100%', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('3', 'Left', '40', NULL, '200', '2')";

					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('4', '19', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('8', '19', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('4', '24', '10')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('3', '16', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('8', '26', '10')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('7', '8', '10')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('5', '7', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('3', '13', '30')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('3', '8', '10')";				

					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('8', '30', 'SMF Index', 'SMF Index Block', 'mx_forum." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('14', '30', 'MXP Polls', 'MXP Polls', 'mx_poll." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('2', '30', 'SMF Announcements', 'SMF Announcements Block', 'mx_announce." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('31', '30', 'Last Posts', 'SMF Last Posts Function', 'mx_last_msg." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('41', '30', 'Statistics', 'Site Statistics Function', 'mx_statistics." . $phpEx . "', '')";

					$sql[] = "INSERT INTO " . $mx_table_prefix . "page VALUES('2', 'Forum', 'This is the SMF Forum startpage', '0', '', '20', 'icon_forum.gif', '', '', '', '', '1', '0', '0', '0', '-1', '-1', 'overall_header_navigation_smf." . $tplEx . "', '', '', '0', 'a:1:{i:0;s:0:\"\";}', '1')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "page VALUES('4', 'Sitestats', 'Sitestats page', '0', '', '40', 'icon_stats.gif', '', '', '', '', '1', '0', '0', '0', '-1', '-1', '', '', '', '0', 'a:1:{i:0;s:0:\"\";}', '-1')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('1', '2', 'announce_nbr_display', 'Number', '1', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('2', '2', 'announce_nbr_days', 'Number', '14', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('3', '2', 'announce_display', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('4', '2', 'announce_display_sticky', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('5', '2', 'announce_display_normal', 'Boolean', 'FALSE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('7', '2', 'announce_img', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('8', '2', 'announce_img_sticky', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('9', '2', 'announce_img_normal', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('6', '2', 'announce_display_global', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('10', '2', 'announce_img_global', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('11', '2', 'announce_forum', 'Function', '', 'get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)', '0', '0')";

					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('13', '14', 'Poll_Display', 'Function', '0', 'poll_select( {parameter_value}, \"{parameter_id}\" )', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('36', '14', 'poll_forum', 'Function', '', 'get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)', '0', '0')";


					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('17', '31', 'Last_Msg_Number_Title', 'Number', '15', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('18', '31', 'Last_Msg_Display_Date', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('19', '31', 'Last_Msg_Title_Length', 'Number', '33', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('20', '31', 'Last_Msg_Target', 'Values', '_blank', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('21', '31', 'Last_Msg_Align', 'Values', 'left', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('22', '31', 'Last_Msg_Display_Forum', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('37', '31', 'Last_Msg_forum', 'Function', '', 'get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('38', '31', 'Last_Msg_Display_Last_Author', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('39', '31', 'Last_Msg_Display_Author', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('40', '31', 'Last_Msg_Display_Icon_View', 'Boolean', 'TRUE', '', '0', '0')";
				break;
				
				case 'mybb':
				
					$sql = array();
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('6', 'Poll', 'This is a Demo Block', '14', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125841942', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('16', 'Last Message Post', 'This is a Demo Block', '31', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125842159', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('18', 'Announcements', 'This is a Demo Block', '2', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125868467', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('24', 'Forum', 'This is a Demo Block', '8', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125841817', '2')";			
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block VALUES('26', 'Statistics', 'This is a Demo Block', '41', '0', '5', '0', '0', '0', '0', '0', '1', '1', '0', '1125842177', '2')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('6', '36', '', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('6', '13', '0', NULL, '0')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '17', '5', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '18', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '19', '30', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '20', '_self', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '21', 'left', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '22', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '37', '', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '38', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '39', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '40', 'TRUE', NULL, '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('16', '95', '5', NULL, '0')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '1', '3', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '2', '10', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '3', 'TRUE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '4', 'TRUE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '5', 'FALSE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '7', 'thumb_news.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '8', 'thumb_globe.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '9', 'thumb_globe.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '6', 'TRUE', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '10', 'thumb_globe.gif', '', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "block_system_parameter VALUES('18', '11', '', '', '0')";					
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('8', 'Main', '50', NULL, '100%', '4')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('7', 'Left', '40', NULL, '200', '4')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('4', 'Main', '50', NULL, '100%', '2')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column VALUES('3', 'Left', '40', NULL, '200', '2')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('4', '19', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('8', '19', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('4', '24', '10')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('3', '16', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('8', '26', '10')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('7', '8', '10')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('5', '7', '20')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('3', '13', '30')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "column_block VALUES('3', '8', '10')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('8', '30', 'MyBB Index', 'MyBB Index Block', 'mx_forum." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('14', '30', 'MXP Polls', 'MXP Polls', 'mx_poll." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('2', '30', 'MyBB Announcements', 'MyBB Announcements Block', 'mx_announce." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('31', '30', 'Last Posts', 'MyBB Last Posts Function', 'mx_last_msg." . $phpEx . "', '')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "function VALUES('41', '30', 'Statistics', 'Site Statistics Function', 'mx_statistics." . $phpEx . "', '')";

					$sql[] = "INSERT INTO " . $mx_table_prefix . "page VALUES('2', 'Forum', 'This is the MyBB Forum startpage', '0', '', '20', 'icon_forum.gif', '', '', '', '', '1', '0', '0', '0', '-1', '-1', 'overall_header_navigation_smf." . $tplEx . "', '', '', '0', 'a:1:{i:0;s:0:\"\";}', '1')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "page VALUES('4', 'Sitestats', 'Sitestats page', '0', '', '40', 'icon_stats.gif', '', '', '', '', '1', '0', '0', '0', '-1', '-1', '', '', '', '0', 'a:1:{i:0;s:0:\"\";}', '-1')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('1', '2', 'announce_nbr_display', 'Number', '1', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('2', '2', 'announce_nbr_days', 'Number', '14', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('3', '2', 'announce_display', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('4', '2', 'announce_display_sticky', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('5', '2', 'announce_display_normal', 'Boolean', 'FALSE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('7', '2', 'announce_img', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('8', '2', 'announce_img_sticky', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('9', '2', 'announce_img_normal', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('6', '2', 'announce_display_global', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('10', '2', 'announce_img_global', 'Text', 'thumb_globe.gif', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('11', '2', 'announce_forum', 'Function', '', 'get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)', '0', '0')";

					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('13', '14', 'Poll_Display', 'Function', '0', 'poll_select( {parameter_value}, \"{parameter_id}\" )', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('36', '14', 'poll_forum', 'Function', '', 'get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)', '0', '0')";
					
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('17', '31', 'Last_Msg_Number_Title', 'Number', '15', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('18', '31', 'Last_Msg_Display_Date', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('19', '31', 'Last_Msg_Title_Length', 'Number', '33', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('20', '31', 'Last_Msg_Target', 'Values', '_blank', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('21', '31', 'Last_Msg_Align', 'Values', 'left', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('22', '31', 'Last_Msg_Display_Forum', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('37', '31', 'Last_Msg_forum', 'Function', '', 'get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('38', '31', 'Last_Msg_Display_Last_Author', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('39', '31', 'Last_Msg_Display_Author', 'Boolean', 'TRUE', '', '0', '0')";
					$sql[] = "INSERT INTO " . $mx_table_prefix . "parameter VALUES('40', '31', 'Last_Msg_Display_Icon_View', 'Boolean', 'TRUE', '', '0', '0')";
				break;				
			}
			
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				break;
				
				case 'phpbb2':				
					$sql[] = "INSERT INTO " . $mx_table_prefix . "module VALUES('30', 'phpBB2 Blocks', 'modules/mx_phpbb2blocks/', 'MXP Portal phpBB2 blocks', '', 'MX-Publisher Core Module', 'Original MXP <i>phpBB2 Blocks</i> module by <a href=\"http://www.mx-publisher.com\" target=\"_blank\"> The MXP Project Team</a>')";
					$message .= mx_install_cmd_sql($sql) . '<br />';
				break;
				
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
				case 'proteus':				
					$sql[] = "INSERT INTO " . $mx_table_prefix . "module VALUES('30', 'phpBB3 Blocks', 'modules/mx_phpbb3blocks/', 'MXP Portal phpBB3 blocks', '', 'MX-Publisher Core Module', 'Original MXP <i>phpBB3 Blocks</i> module by <a href=\"http://mxpcms.sourceforge.net\" target=\"_blank\">The MXP Development Team</a>')";
					$message .= mx_install_cmd_sql($sql) . '<br />';
				break;
				
				case 'phpbb4':				
					$sql[] = "INSERT INTO " . $mx_table_prefix . "module VALUES('30', 'phpBB4 Blocks', 'modules/mx_phpbb4blocks/', 'MXP Portal phpBB4 blocks', '', 'MX-Publisher Core Module', 'Original MXP <i>phpBB4 Blocks</i> module by <a href=\"http://mxpcms.sourceforge.net\" target=\"_blank\">The MXP Development Team</a>')";
					$message .= mx_install_cmd_sql($sql) . '<br />';
				break;				
				
				case 'smf2':		
					$sql[] = "INSERT INTO " . $mx_table_prefix . "module VALUES('30', 'SMF2 Blocks', 'modules/mx_smf2blocks/', 'MXP Portal SMF2 blocks', '', 'MX-Publisher Core Module', 'Original MXP <i>SMF2 Blocks</i> module by <a href=\"http://mxpcms.sourceforge.net\" target=\"_blank\"> The MXP Development Team</a>')";
					$message .= mx_install_cmd_sql($sql) . '<br />';
				break;
				
				case 'mybb':		
					$sql[] = "INSERT INTO " . $mx_table_prefix . "module VALUES('30', 'MyBB Blocks', 'modules/mx_mybbblocks/', 'MXP Portal MyBB blocks', '', 'MX-Publisher Core Module', 'Original MXP <i>MyBB Blocks</i> module by <a href=\"http://mxpcms.sourceforge.net\" target=\"_blank\"> The MXP Development Team</a>')";
					$message .= mx_install_cmd_sql($sql) . '<br />';
				break;				
			}			
		}		
		
		for($i = 0; $i < count($lang['Portal_install_done']); $i++)
		{
			$message .= ($i + 1) . ') ' . $lang['Portal_install_done'][$i] . '<br />';
		}
		$message .= '&nbsp;<br />&nbsp;<br />' . $lang['Thanks_for_choosing'] . '<br />&nbsp;<br />';
		
		include_once($mx_root_path . "install/includes/template.$phpEx");
		
		$template = new Template($mx_root_path . 'install/templates');
		
		page_header_install($install_title, $message);
		
		$template->set_filenames(array('button' => 'mx_install_button.'.$tplEx));
		
		$action_label = $install_mode == 'upgrade' ? $lang['Go_to_admincp'] : $mx_portal_name;
		$action_url = $install_mode == 'upgrade' ? $mx_root_path . "admin/index.$phpEx" : $mx_root_path . "index.$phpEx";
		
		$template->assign_vars(array(
			'S_FORM_ACTION'			=> $action_url,
			'S_HIDDEN_FIELDS'		=> '',
			'L_SUBMIT'				=> $action_label,
		));
		
		$template->pparse('button');
		
		page_footer_install();
	}
}	// if( $confirm )

/* ================================================================================
* MAIN INSTALLATION PANELS...
* ================================================================================
*/

/*
* Create the template for the first installation step.
*/
include_once($mx_root_path . "install/includes/template.$phpEx");
$template = new Template($mx_root_path . 'install/templates');

/*
* Check if the Portal is already installed
*/
if (install_file_exists($mx_root_path . "config.$phpEx"))
{
	include($mx_root_path . "config.$phpEx");
}

if (defined('MX_INSTALLED') && (MX_INSTALLED === true))
{
	/*
	* Upgrade Instructions ----------------------------------------
	*/
	$install_mode = 'upgrade';
	$upgrade_mode = defined('BACKEND_INSTALLED') ? 'from28x' : '';
	page_header_install($lang['Welcome_install'], $lang['Upgrade_Instruction']);
	$template->set_filenames(array('button' => 'mx_install_button.'.$tplEx));

	$s_hidden_fields = '<input type="hidden" name="install_mode" value="' . $install_mode . '" />'.
		'<input type="hidden" name="confirm" value="1" />'.
		'<input type="hidden" name="language" value="' . $language . '" />'.
		'<input type="hidden" name="backend_root_path" value="' . $backend_root_path . '" />';

	$template->assign_block_vars('switch_are_you_sure', array());
	$template->assign_vars(array(
		'L_ARE_YOU_SURE'			=> str_replace("'", "\'", $lang['Upgrade_are_you_sure']),
		'S_FORM_ACTION'			=> "mx_install.$phpEx",
		'S_HIDDEN_FIELDS'			=> $s_hidden_fields,
		'L_SUBMIT'							=> $lang['Start_Upgrade'],
	));
	
	$template->pparse('button');
	page_footer_install();
}


//
// Install Instructions ----------------------------------------
//
$install_mode = 'install';
page_header_install($lang['Welcome_install'], $lang['Install_Instruction']);
$template->set_filenames(array('body' => 'mx_install_body.'.$tplEx));

//
// Get the current document root.
//
if( isset($_SERVER['DOCUMENT_ROOT']) )
{
	$document_root = $_SERVER['DOCUMENT_ROOT'];
}
elseif( isset($DOCUMENT_ROOT) )
{
	$document_root = $DOCUMENT_ROOT;
}
else
{
	$document_root = './';
}

$document_root = str_replace('\\', '/', mx_realpath($document_root));

/*
* Get the absolute path to this MX-Publisher installation.
*/
$mx_absolute_path = str_replace('\\', '/', substr(__FILE__, 0, - strlen('install/' . basename(__FILE__))));

// FYI:
// If document root IS part of our absolute path, chances are we can find phpBB from there.
// This is the most typical scenario. Under a shared host, the document root typically points
// to a path owned by the same user running the current domain.
// That's why we first try to guess the $backend_search_path value from $document_root.
//
if( substr($mx_absolute_path, 0, strlen($document_root)) == $document_root )
{
	$backend_search_path = $document_root;
}
else
{
	// FYI:
	// If document root is NOT part of our absolute path, then we have a problem!
	// We can't search for phpBB from the server root because we might be running under
	// a shared host with hundreds of files (it might take forever). Not to mention, we
	// could get into a directory owned by another user !!!
	// So, we might not be able to find the phpBB installation related to this portal.
	// However, we'll still try to do it from our parent directory or from our own
	// directory. That sounds safe and makes sense as well. phpBB is often one directory
	// up or down the portal directory (what we call here our absolute path).
	//
	// If all our tries fail, the only solution for the user to install the portal is by
	// commenting the line where the INSTALL_READONLY flag is defined. So, (s)he will be
	// able to enter the installation settings manually.
	//
	// TODO: Could we do anything else to improve our chances of success?
	//

	/*
	* Let's see whether we have read access to our parent directory
	*/
	$parent_path = mx_realpath($mx_absolute_path.'../');
	if(is_readable($parent_path))
	{
		/*
		* If so, we'll try to search for phpBB from here.
		*/
		$backend_search_path = $parent_path;
	}
	else
	{
		/*
		* If not, we'll try to search from our own directory.
		*/
		print_r("Warning: Access to our parent directory is restricted.");		
		$backend_search_path = $mx_absolute_path;
	}
	/*
	* BTW, we restrict the recursive search in the find_phpbb() function to a maximum of 3
	* levels of directories for performance reasons.
	*/
}

/*
* Get the MX-Publisher base dir (computed from the phpbb search path), for example /mx/, /portal/ or /
*/
$mx_base_path = substr($mx_absolute_path, strlen($backend_search_path));

// Get the current Server URL.
$server_url = ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'];

// Get the MX-Publisher Path in the URL (this might not be the same as the base path when using aliases).
$mx_self_path = substr($_SERVER['PHP_SELF'], 0, -strlen('install/'.basename(__FILE__)));

// Get the MX-Publisher URL.
$portal_url = $server_url . $mx_self_path;

// Save path information for debuging purposes
$debuginfo = array(
	array('MXP Absolute Path', $mx_absolute_path),
	array('Document Root', $document_root),
	array('Forums Search Path', $backend_search_path),
	array('MXP Root Path', $mx_base_path),
	array('Website URL', $server_url),
	array('PHP SELF', $_SERVER['PHP_SELF']),
	array('MXP URL Path', $mx_self_path),
	array('Portal URL', $portal_url),
	array('','')
);

/*
* Find a phpBB forum path
*/
$phpbb_files_ary = find_phpbb($backend_search_path);
$phpbb_files_cnt = count($phpbb_files_ary);
$phpbb_found = false;
$phpbb_failed = false;
/*
* Find a SMF Foum path
*/
$smf_files_ary = find_smf($backend_search_path);
$smf_files_cnt = count($smf_files_ary);
$smf_found = false;
$smf_failed = false;

/*
* Find a mybb forum path
**/
$mybb_files_ary = find_mybb($backend_search_path);
$mybb_files_cnt = count($mybb_files_ary);
$mybb_found = false;
$mybb_failed = false;

/* Supported Backends */
$i = 0;
$portal_backend = 'internal';
$portal_backend_array = array('internal' => 'Internal', 
										'smf2' => 'SMF2', 
										'mybb' => 'myBB', 
										'phpbb2' => 'phpBB2', 
										'phpbb3' => 'phpBB3', 
										'olympus' => 'Olympus', 
										'ascraeus' => 'Ascraeus',
										'rhea' => 'Rhea',
										'proteus' => 'Proteus',
										'phpbb4' => 'phpBB4'
										);
$portal_backend_select = install_list_static('portal_backend', $portal_backend_array, $portal_backend);	
$files_ary = array_merge($phpbb_files_ary, $smf_files_ary, $mybb_files_ary);
$files_cnt = count($files_ary);
$offset1 = $phpbb_files_cnt;
$offset2 = $phpbb_files_cnt + $smf_files_cnt;
$offset3 = $files_cnt;

//Temp charset 
$dbcharacter_set = 'utf-8';
//UTF-8 require to have same database in phpBB3 and mxp and mysqli is preferable
//$dbms_type = ($portal_backend === 'internal') ? 'dbms_mxbb' : 'dbms';
$default_dbms = 'mysqli';

/*
* ok, let's build the SELECT tag for the phpBB boards we found on this server =:-o
*/
$select_backend_path = '<select name="select_backend_path" onchange="check_backend_path();">';
$select_database_type = '<select name="dbms_mxbb" onchange="check_database_type();">';

/*
* Check if a config.php file exists and was altered to allow re-install
**/
if (install_file_exists($mx_root_path . "config.$phpEx"))
{
	$mx_info = get_mxbb_info($mx_root_path . "config.$phpEx");
	$default_dbms = !empty($mx_info['dbms']) ? $mx_info['dbms'] : $default_dbms;
	if ($mx_info['mx_table_prefix'])
	{	
		$status = $mx_info['status'] ? 'valid' : 'invalid'; 
		$lang['Install_Instruction_mxBB'] = $lang['Install_Instruction_mxBB'] . " Warning: Existing mxp configuration file was found with " . $status . " status, <br /> If you continue with same db table prefix the schema will be reinstalled!";
	}
	/*
	* First, provide the option of standalone install
	*/
	$template->assign_block_vars('datarow', array(
		'INFO'							=>	$lang['Install_Instruction_mxBB'],
		'BACKEND_PATH'			=>	$mx_root_path . 'include/shared/phpbb2/',
		'S_BACKEND_PATH'		=> 	$select_backend_path,
		'PORTAL_URL'				=>	$portal_url,
		'PORTAL_BACKEND' 		=>	'internal',
		'BACKEND_URL'			=>	$portal_url . 'include/shared/phpbb2/',
		'DBMS'							=>	$default_dbms,
		'DB_HOST'					=>	isset($mx_info['dbhost']) ? $mx_info['dbhost'] : 'localhost',
		'DB_NAME'					=>	isset($mx_info['dbname']) ? $mx_info['dbname'] : '',
		'DB_USER'						=>	isset($mx_info['dbuser']) ? $mx_info['dbuser'] : '',
		'DB_PASSWD'				=>	isset($mx_info['dbpasswd']) ? $mx_info['dbpasswd'] : '',
		'DB_PREFIX'					=>	isset($mx_info['table_prefix']) ? $mx_info['table_prefix'] : '',
		'DB_CHARACTER_SET'	=>	isset($mx_info['dbcharacter_set']) ? $mx_info['dbcharacter_set'] : $dbcharacter_set,
		'BACKEND_ROOT'	=>	'',
	));
}
else
{
	/*
	*
	* Build the array of database types required for the target system
	*/
	$mx_info = array();
	foreach ($available_dbms as $dbms => $database)
	{
		$dbms = !empty($dbms) ? $dbms : "mysqli";
		$selected = ($dbms == $default_dbms) ? ' selected="selected"' : '';
		
		if ($database['LABEL'] && defined('INSTALL_READONLY'))
		{
			if (!install_file_exists($mx_root_path . 'install/schemas/' . $database['SCHEMA'] . '_schema_install.sql'))
			{
				$available_dbms[$dbms]['AVAILABLE'] = false;
			
				$mx_info['dbms'] = $default_dbms;
				$mx_info['dbhost'] = 'localhost';
				$mx_info['dbname'] = 'mx_db_name';
				$mx_info['dbuser'] = 'mx_db_user';
				$mx_info['dbpasswd'] = 'mx_db_password';
				$mx_info['mx_table_prefix'] = 'mx_';
				$mx_info['dbcharacter_set']	= $dbcharacter_set;
				$mx_info['status'] = false;
			}
			else
			{
				$available_dbms[$dbms]['AVAILABLE'] = true;
			
				$mx_info['dbms'] = isset($dbms[0]) ? $dbms[0]: $default_dbms;
				$mx_info['dbhost'] = isset($database['default_host']) ? $database['default_host'] : 'localhost';
				$mx_info['dbname'] = $database['name'];
				$mx_info['dbuser'] = isset($database['default_user']) ? $database['default_user'] : 'root';
				$mx_info['dbpasswd']	 = isset($database['default_password']) ? $database['default_password'] : '';
				$mx_info['mx_table_prefix'] = isset($database['default_prefix']) ? $database['default_prefix'] : 'mx_';
				$mx_info['dbcharacter_set']	= ($database['utf8_support'] = true) ? 'utf-8' : 'latin1';
				$mx_info['status'] = false;
			
				$select_database_type .= '<option value="' . $dbms . '"' . $selected .'>' . $dbms . '</option>';
			}
		}
		else
		{
			$select_database_type .= '<option value="' . $dbms . '"' . $selected .'>' . $dbms . '</option>';
		}
	}
	
	$default_dbms = $mx_info['dbms'] ? $mx_info['dbms'] : $dbcharacter_set;

	/*
	* First, provide the option of standalone and read-only install
	*/
	$template->assign_block_vars('datarow', array(
		'INFO'										=>	$lang['Install_Instruction_mxBB'],
		'BACKEND_PATH'				=>	$mx_root_path . 'include/shared/phpbb2/',
		'S_BACKEND_PATH'		=> 	$select_backend_path,
		'PORTAL_URL'					=>	$portal_url,
		'PORTAL_BACKEND' 		=>	'internal',
		'BACKEND_URL'				=>	$portal_url . 'include/shared/phpbb2/',
		'DBMS'									=>	$default_dbms,
		'DB_HOST'							=>	$mx_info['dbhost'] ? $mx_info['dbhost'] : 'localhost',
		'DB_NAME'							=>	$mx_info['dbname'] ? $mx_info['dbname'] : 'root',
		'DB_USER'							=>	$mx_info['dbuser'] ? $mx_info['dbuser'] : '',
		'DB_PASSWD'						=>	$mx_info['dbpasswd'] ? $mx_info['dbpasswd'] : '',
		'DB_PREFIX'						=>	isset($mx_info['table_prefix']) ? $mx_info['table_prefix'] : 'mx_',
		'DB_CHARACTER_SET'	=>	$mx_info['dbcharacter_set'] ? $mx_info['dbcharacter_set'] : $dbcharacter_set,
		'BACKEND_ROOT'				=>	'',
	));	
}

/*
* Now, list all phpBB backend options available
**/
for($i = 0; $i < $offset1; $i++)
{
	// Get the phpBB base dir (computed from the document root), for example /phpBB/, /forum/ or /...
	$phpbb_base_path = '/' . (!$files_ary[$i] ? '' : $files_ary[$i] . '/');
	
	// Get the relative path from MX-Publisher to this forum installation
	$phpbb_relative = get_relative_path($mx_base_path, $phpbb_base_path);

	// Get the relative path from the MX-Publisher Install script to this phpBB installation
	$phpbb_root_path = $mx_root_path . $phpbb_relative;

	// Get the version related information if this forum is phpBB
	if (install_file_exists($phpbb_root_path . "modcp.$phpEx")) // phpBB2
	{
		$portal_backend = 'phpbb2';
		$phpbbversion = '2.0.24';
	}
	elseif (install_file_exists($phpbb_root_path . "style.$phpEx")) // phpBB3 Olympus
	{
			$portal_backend = 'olympus'; //'phpbb3'
			$phpbbversion = '3.0.14';
	}
	elseif (install_file_exists($phpbb_root_path . "report.$phpEx")) // phpBB3 Ascraeus
	{
		$portal_backend = 'ascraeus';
		$phpbbversion = '3.1.12';
	}
	/*
	elseif (install_file_exists($phpbb_root_path . "index.$phpEx")) // phpBB4 Rhea
	{
		$phpbbversion = $portal_backend = 'rhea';
	}
	*/	
	if (!install_file_exists($phpbb_root_path . "config.$phpEx") && !install_file_exists($phpbb_root_path . "Settings.$phpEx"))			
	{	
		echo("phpBB File: " . $phpbb_root_path . "config.$phpEx" . " not found.");
		$phpbbversion = $mx_portal_version; 
		$portal_backend = 'internal';
	}
	// Get the DB related information if this forum is phpBB
	if (install_file_exists($phpbb_root_path . "config.$phpEx"))
	{
		$phpbb_info = $backend_info = get_phpbb_info($phpbb_root_path, $portal_backend, $phpbbversion);
		if (install_file_exists($phpbb_root_path . "report.$phpEx")) // phpBB3.1+
		{
			$portal_backend = !empty($phpbb_info['backend']) ? $phpbb_info['backend'] : $portal_backend;
			$phpbbversion = !empty($phpbb_info['version']) ? $phpbb_info['version'] : $phpbbversion;
		}		
	}
	//Not phpBB
	if (install_file_exists($phpbb_root_path . "Settings.$phpEx"))			
	{	
		echo("File: " . $phpbb_root_path . "Settings.$phpEx" . " found.");
		//Redenifing phpBb compatible variables
		//$phpbb_info = $backend_info = get_phpbb_info($phpbb_root_path, $phpbbversion);
		//$phpbbversion = 'phpbb'; 
		//$portal_backend = 'internal';
	}	
	// Save forums information for debuging purposes
	$debuginfo[] = array('phpBB Info'.($phpbb_files_cnt > 1 ? " #$i" : ''),
		'base:'.$phpbb_base_path.
		'; relative:'.$phpbb_relative.'; dbms:'.$phpbb_info['dbms'].
		'; dbhost:'.$phpbb_info['dbhost'].'; dbname:'.$phpbb_info['dbname'].
		'; dbuser:'.$phpbb_info['dbuser'].'; prefix:'.$phpbb_info['table_prefix'].';'
	);	
	//If we have a old forum wtih databse deleted we should delete config.php to detect other installtions correct		
	// Check if we support the DB used for this phpBB
	if( !isset($phpbb_info['dbms']) || !array_key_exists($phpbb_info['dbms'], $available_dbms) ) 	
	{
		continue;
	}

	// Try to Connect to this phpBB Database
	if(!open_phpbb_db($db, $phpbb_info))
	{
		$phpbb_failed = true;
		continue;
	}

	// Get the phpBB URL and DB Charset
	$phpbb_url = get_phpbb_url($phpbb_info['table_prefix'], $phpbbversion);
	$default_dbms = $phpbb_info['dbms'] ? $phpbb_info['dbms'] : $dbcharacter_set;
	// Close our DB connection.
	$db->sql_close();
	$db = false;

	if(empty($phpbb_url))
	{
		$phpbb_failed = true;
		continue;
	}

	// Note: to get the phpBB URL we have read the config table, so it seems safe to assume this board is installed. :-)
	$template->assign_block_vars('datarow', array(
		'INFO'										=> $lang['Install_Instruction_phpBB'],
		'BACKEND_PATH'				=> $phpbb_relative,
		'PORTAL_URL'					=> $portal_url,
		'BACKEND_URL'				=> $phpbb_url,
		'PORTAL_BACKEND' 		=> $portal_backend,
		'DBMS'									=> $default_dbms,
		'DB_HOST'							=> $phpbb_info['dbhost'] ? $phpbb_info['dbhost'] : 'localhost',
		'DB_NAME'							=> $phpbb_info['dbname'],
		'DB_USER'							=> $phpbb_info['dbuser'],
		'DB_PASSWD'						=> $phpbb_info['dbpasswd'],
		'DB_CHARACTER_SET'	=> (isset($available_dbms[$phpbb_info['dbms']]['utf8_default'])) ? "utf-8" : "latin2",	
		'DB_PREFIX'						=> $phpbb_info['table_prefix'],
		'ACM_TYPE'						=> $phpbb_info['acm_type'] ? $phpbb_info['acm_type'] : 'file',
		'BACKEND_ROOT'				=> $phpbb_root_path,
	));
	
	$select_backend_path .= '<option value="'.$i.'">'.$phpbb_relative.'</option>';
	$phpbb_found = true;
}

/*
* Now, list all SMF backend options available
***/
for($i = $offset1; $i < $offset2; $i++)
{
	// Get the SMF base dir (computed from the document root), for example /phpBB/, /forum/ or /...
	$smf_base_path = '/' . (!$files_ary[$i] ? '' : $files_ary[$i] . '/');
	
	// Get the relative path from MX-Publisher to this forum installation
	$smf_relative = get_relative_path($mx_base_path, $smf_base_path);

	// Get the relative path from the MX-Publisher Install script to this phpBB installation
	$smf_root_path = $mx_root_path . $smf_relative;
	
	if (install_file_exists($smf_root_path . "Settings.$phpEx"))
	{
		$smf_info = $backend_info = get_smf_info($smf_root_path . "Settings.$phpEx");		
		// Get the SMF URL
		$smf_url = $smf_info['boardurl'];
		$smfversion = $portal_backend = 'smf2';		
	}
	elseif (!install_file_exists($smf_root_path . "config.$phpEx") && !install_file_exists($smf_root_path . "Settings.$phpEx") && !install_file_exists($smf_root_path . "inc/config.$phpEx") && !install_file_exists($smf_root_path . "inc/settings.$phpEx"))				
	{	
		$lang['Install_Instruction_SMF'] = $lang['Install_Instruction_SMF'] . " File: " . $smf_root_path . "Settings.$phpEx" . " not found.";
		$smfversion = $portal_backend = 'internal';		
	}
	
	$default_dbms = $smf_info['dbms'] ? $smf_info['dbms'] : "mysql4";	
	
	// Save forums information for debuging purposes
	$debuginfo[] = array('SMF Info'.($files_cnt > 1 ? " #$i" : '' ),
		'base:'.$smf_base_path.
		'; relative:'.$smf_relative.'; dbms:'.$smf_info['dbms'].
		'; dbhost:'.$smf_info['dbhost'].'; dbname:'.$smf_info['dbname'].
		'; dbuser:'.$smf_info['dbuser'].'; prefix:'.$smf_info['table_prefix'].';'
	);	
	
	// Note: to get the SMF URL we have read the Settings file so it seems safe to assume this board is installed. :-)
	$template->assign_block_vars('datarow', array(
		'INFO'										=> $lang['Install_Instruction_SMF'],
		'BACKEND_PATH'				=> $smf_relative,
		'PORTAL_URL'					=> $portal_url,
		'BACKEND_URL'				=> $smf_url,
		'PORTAL_BACKEND'		=> $smfversion,
		'DBMS'									=> $default_dbms,
		'DB_HOST'							=> $smf_info['dbhost'] ? $smf_info['dbhost'] : 'localhost',
		'DB_NAME'							=> $smf_info['dbname'],
		'DB_USER'							=> $smf_info['dbuser'],
		'DB_PASSWD'						=> $smf_info['dbpasswd'],
		'DB_PREFIX'						=> $smf_info['table_prefix'],
		'DB_CHARACTER_SET'	=> $smf_info['dbcharacter_set'],		
		'ACM_TYPE'						=> $smf_info['acm_type'] ? $smf_info['acm_type'] : 'file',		
		'BACKEND_ROOT'				=> $smf_root_path,			
	));
	$select_backend_path .= '<option value="'.$i.'">'.$smf_relative.'</option>';	
	$smf_found = true;
}
/* */
/*
* Now, list all MyBB  backend options available
***/
for($i = $offset2; $i < $files_cnt; $i++)
{
	// Get the phpBB base dir (computed from the document root), for example /phpBB/, /forum/ or /...
	$mybb_base_path = '/' . (!$files_ary[$i] ? '' : $files_ary[$i] . '/');
	
	// Get the relative path from MX-Publisher to this forum installation
	$mybb_relative = get_relative_path($mx_base_path, $mybb_base_path);

	// Get the relative path from the MX-Publisher Install script to this phpBB installation
	$mybb_root_path = $mx_root_path . $mybb_relative;
	
	if (install_file_exists($mybb_root_path . "inc/config.$phpEx") && install_file_exists($mybb_root_path . "inc/settings.$phpEx"))				
	{	
		
	}
	
	// Get myBB URL and DB Charset
	$mybbversion = $portal_backend = 'mybb';
	$mybb_info =  $backend_info = array_merge(get_mybb_info($mybb_root_path . "inc/config.$phpEx"), get_mybb_settings($mybb_root_path . "inc/settings.$phpEx"));
	// Get the MyBB URL
	$mybb_url = $mybb_info['bburl'];	

	$default_dbms = $mybb_info['dbms'] ? $mybb_info['dbms'] : $dbcharacter_set;	
	// Save forums information for debuging purposes
	$debuginfo[] = array('MyBB Info'.($files_cnt > 1 ? " #$i" : ''),
		'base:'.$mybb_base_path.
		'; relative:'.$mybb_relative.'; dbms:'.$mybb_info['dbms'].
		'; dbhost:'.$mybb_info['dbhost'].'; dbname:'.$mybb_info['dbname'].
		'; dbuser:'.$mybb_info['dbuser'].'; prefix:'.$mybb_info['table_prefix'].';'
	);
	
	// Note: to get the SMF URL we have read the Settings file so it seems safe to assume this board is installed. :-)
	$template->assign_block_vars('datarow', array(
		'INFO'	=> $lang['Install_Instruction_MyBB'],
		'BACKEND_PATH'			=> $mybb_relative,
		'PORTAL_URL'				=> $portal_url,
		'BACKEND_URL'			=> $mybb_url,
		'PORTAL_BACKEND'	=> $mybbversion,
		'DBMS'								=> $default_dbms,
		'DB_HOST'						=> $mybb_info['dbhost'] ? $mybb_info['dbhost'] : 'localhost',
		'DB_NAME'						=> $mybb_info['dbname'],
		'DB_USER'						=> $mybb_info['dbuser'],
		'DB_PASSWD'					=> $mybb_info['dbpasswd'],
		'DB_PREFIX'					=> $mybb_info['table_prefix'],
		'ACM_TYPE'					=> $mybb_info['acm_type'] ? $mybb_info['acm_type'] : 'file',
		'DBCHARACTER_SET' => (isset($available_dbms[$phpbb_info['dbms']]['utf8_default'])) ? "utf-8" : "ISO-8859-2",		
		'BACKEND_ROOT'			=> $mybb_root_path,
	));
	
	$select_backend_path .= '<option value="'.$i.'">'.$mybb_relative.'</option>';
	$mybb_found = true;
}

if ($files_cnt === 0)
{	
	
	foreach ($portal_backend_array as $portal_backend => $portal_backend_name)
	{
		// Get the phpBB base dir (computed from the document root), for example phpBB/, forum/ or /...
		if (install_file_exists($mx_root_path . "phpBB/config.$phpEx")) // phpBB
		{
			$phpbb_base_path = 'phpBB/';
		}
		elseif (install_file_exists($mx_root_path . "phpBB2/config.$phpEx")) // phpBB2
		{
			$phpbb_base_path = 'phpBB2/';
		}
		elseif (install_file_exists($mx_root_path . "phpBB3/config.$phpEx")) // phpBB3
		{
			$phpbb_base_path = 'phpBB3/';
		}
		elseif (install_file_exists($mx_root_path . "phpBB4/config.$phpEx")) // phpBB4
		{
			$phpbb_base_path = 'phpBB4/';
		}
		elseif (install_file_exists($mx_root_path . "phpbb/config.$phpEx")) // phpbb
		{
			$phpbb_base_path = 'phpbb/';
		}
		elseif (install_file_exists($mx_root_path . "phpbb2/config.$phpEx")) // phpbb2
		{
			$phpbb_base_path = 'phpbb2/';
		}
		elseif (install_file_exists($mx_root_path . "forum/config.$phpEx")) // forum
		{
			$phpbb_base_path = 'forum/';
		}
		elseif (install_file_exists($mx_root_path . "comunity/config.$phpEx")) // comunity
		{
			$phpbb_base_path = 'comunity/';
		}
		
		// Get the relative path from MX-Publisher to this forum installation
		$phpbb_relative = './' . $phpbb_base_path;

		// Get the relative path from the MX-Publisher Install script to this phpBB installation
		$phpbb_root_path = $mx_root_path . $phpbb_base_path;
		
		// Get the version related information if this forum is phpBB
		if (install_file_exists($phpbb_root_path . "modcp.$phpEx")) // phpBB2
		{
			$portal_backend = 'phpbb2';
			$phpbbversion = '2.0.24';
		}
		elseif (install_file_exists($phpbb_root_path . "style.$phpEx")) // phpBB3 Olympus
		{
				$portal_backend = 'olympus'; //'phpbb3'
				$phpbbversion = '3.0.14';
		}
		elseif (install_file_exists($phpbb_root_path . "report.$phpEx")) // phpBB3 Ascraeus
		{
			$portal_backend = 'ascraeus';
			$phpbbversion = '3.1.12';
		}
		elseif (install_file_exists($phpbb_root_path . "/assets/javascript/jquery.min.js")) // phpBB3 Rhea
		{
			$portal_backend = 'rhea';
			$phpbbversion = '3.2.11';
		}
		elseif (install_file_exists($phpbb_root_path . "config/default/routing/ucp.yml")) // added in phpBB3 Proteus with cron.yml
		{
			$portal_backend = 'proteus';
			$phpbbversion = '3.3.12';
		}
		elseif (install_file_exists($phpbb_root_path . "/assets/javascript/jquery-cropper.min.js")) // phpBB4
		{			
			$portal_backend = 'phpbb4'; //'phpbb4'
			$phpbbversion = '4.0.0';
		}
		
		if ((@include $phpbb_root_path . "language/en/install.$phpEx") !== false)
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
				case (preg_match('/4.0/i', $phpbbversion)):
					$backend = 'phpbb4';
				break;
			}
		}		
		
		if (!install_file_exists($phpbb_root_path . "config.$phpEx") && !install_file_exists($phpbb_root_path . "Settings.$phpEx"))			
		{	
			echo("phpBB File: " . $phpbb_root_path . "config.$phpEx" . " not found.");
			$phpbbversion = $mx_portal_version; 
			$portal_backend = 'internal';
		}
		
		// Get the DB related information if this forum is phpBB
		if (install_file_exists($phpbb_root_path . "config.$phpEx"))
		{
			$phpbb_info = $backend_info = get_phpbb_info($phpbb_root_path, $portal_backend, $phpbbversion);
			if (install_file_exists($phpbb_root_path . "report.$phpEx")) // phpBB3.1+
			{
				$portal_backend = !empty($phpbb_info['backend']) ? $phpbb_info['backend'] : $portal_backend;
				$phpbbversion = !empty($phpbb_info['version']) ? $phpbb_info['version'] : $phpbbversion;
			}		
		}
		//Not phpBB
		if (install_file_exists($phpbb_root_path . "Settings.$phpEx"))			
		{	
			echo("File: " . $phpbb_root_path . "Settings.$phpEx" . " found.");
			//Redenifing phpBb compatible variables
			//$phpbb_info = $backend_info = get_phpbb_info($phpbb_root_path, $phpbbversion);
			//$phpbbversion = 'phpbb'; 
			//$portal_backend = 'internal';
		}	
		
		// Save forums information for debuging purposes
		$debuginfo[] = array('phpBB Info'.($phpbb_files_cnt > 1 ? " #$i" : ''),
			'base:'.$phpbb_base_path.
			'; relative:'.$phpbb_relative.'; dbms:'.$phpbb_info['dbms'].
			'; dbhost:'.$phpbb_info['dbhost'].'; dbname:'.$phpbb_info['dbname'].
			'; dbuser:'.$phpbb_info['dbuser'].'; prefix:'.$phpbb_info['table_prefix'].';'
		);	
		
		//If we have a old forum wtih databse deleted we should delete config.php to detect other installtions correct		
		// Check if we support the DB used for this phpBB
		if( !isset($phpbb_info['dbms']) || !array_key_exists($phpbb_info['dbms'], $available_dbms) ) 	
		{
			continue;
		}

		// Try to Connect to this phpBB Database
		if(!open_phpbb_db($db, $phpbb_info))
		{
			$phpbb_failed = true;
			continue;
		}

		// Get the phpBB URL and DB Charset
		$phpbb_url = get_phpbb_url($phpbb_info['table_prefix'], $phpbbversion);
		$default_dbms = $phpbb_info['dbms'] ? $phpbb_info['dbms'] : $dbcharacter_set;
		// Close our DB connection.
		$db->sql_close();
		$db = false;

		if(empty($phpbb_url))
		{
			$phpbb_failed = true;
			continue;
		}

		// Note: to get the phpBB URL we have read the config table, so it seems safe to assume this board is installed. :-)
		$template->assign_block_vars('datarow', array(
			'INFO'										=> $lang['Install_Instruction_phpBB'],
			'BACKEND_PATH'				=> $phpbb_relative,
			'PORTAL_URL'					=> $portal_url,
			'BACKEND_URL'				=> $phpbb_url,
			'PORTAL_BACKEND' 		=> $portal_backend,
			'DBMS'									=> $default_dbms,
			'DB_HOST'							=> $phpbb_info['dbhost'] ? $phpbb_info['dbhost'] : 'localhost',
			'DB_NAME'							=> $phpbb_info['dbname'],
			'DB_USER'							=> $phpbb_info['dbuser'],
			'DB_PASSWD'						=> $phpbb_info['dbpasswd'],
			'DB_CHARACTER_SET'	=> (isset($available_dbms[$phpbb_info['dbms']]['utf8_default'])) ? "utf-8" : "latin2",	
			'DB_PREFIX'						=> $phpbb_info['table_prefix'],
			'ACM_TYPE'						=> $phpbb_info['acm_type'] ? $phpbb_info['acm_type'] : 'file',
			'BACKEND_ROOT'				=> $phpbb_root_path,
		));
		
		$select_backend_path .= '<option value="'.$i.'">'.$phpbb_relative.'</option>';
		$phpbb_found = true;
		$i++;		
	}		
}
	
/* */
$select_backend_path .= '<option value="-1">'.'internal'.'</option>';
$select_backend_path .= '</select><br />';
$select_database_type .= '<option value="-1">'.'re-select'.'</option>';
$select_database_type .= dbms_select($default_dbms);
$select_database_type .= '</select><br />';
/*--------------------
* DEBUG ONLY ;-)
/**/
if ($mx_request_vars->is_post('debug'))
{
	if($phpbb_files_cnt <= 0)
	{
		install_die($lang['Install_forums_not_found'], $debuginfo);
	}
	if($smf_files_cnt <= 0)
	{
		install_die($lang['Install_smf_not_found'], $debuginfo);
	}
	if($mybb_files_cnt <= 0)
	{
		install_die($lang['Install_mybb_not_found'], $debuginfo);
	}	
	if($files_cnt <= 0)
	{
		install_die($lang['Install_forums_not_found'], $debuginfo);
	}
	if($phpbb_failed)
	{
	install_die($lang['Install_phpbb_db_failed'], $debuginfo);
	}
	if($smf_failed)
	{
		install_die($lang['Install_smf_db_failed'], $debuginfo);
	}
	if($mybb_failed)
	{
		install_die($lang['Install_mybb_db_failed'], $debuginfo);
	}	
	if($smf_found)
	{
		install_die($lang['Install_smf_db_failed'], $debuginfo);
	}
	if($mybb_failed)
	{
		install_die($lang['Install_mybb_db_failed'], $debuginfo);
	}	
	install_die($lang['Install_forums_unsupported'], $debuginfo);
}

/* -------------------- */
$s_hidden_fields = '<input type="hidden" name="install_mode" value="' . $install_mode . '" />'.
	'<input type="hidden" name="confirm" value="1" />'.
	'<input type="hidden" name="language" value="' . $language . '" />'.
	'<input type="hidden" name="phpbb_root_path" value="' . $phpbb_root_path . '" />';
$s_hidden_fields .= isset($smf_root_path) ? '<input type="hidden" name="smf_root_path" value="' . $smf_root_path . '" />' : '';
$s_hidden_fields .= isset($mybb_root_path) ? '<input type="hidden" name="mybb_root_path" value="' . $mybb_root_path . '" />' : '';

/* -------------------- */	
$template->assign_vars(array(
	'L_NOSCRIPT_WARNING'				=> $lang['Install_noscript_warning'],
	'L_INITIAL_CONFIGURATION'		=> $lang['Install_settings'],
	'L_PORTAL_CONFIGURATION'		=> $lang['Portal_paths'],
	'L_DATABASE_CONFIGURATION'	=> $lang['Database_settings'],
	'L_DB_CHARACTER_SET'					=> $lang['DB_Character_Set'],
	'READ_ONLY'											=> $lang['ReadOnly'],
	'L_BACKEND_ONLY'							=> $lang['Phpbb_only'],
	'L_BACKEND_PATH'							=> $lang['Phpbb_path'],	
	'L_MXBB_ONLY'									=> $lang['Mxbb_only'],
	'L_BACKEND'										=> $lang['Session_backend'],
	'L_PORTAL_BACKEND'					=> $lang['Portal_backend'],	
	'L_Backend_explain'							=> ($phpbb_found || $smf_found || $mybb_found) ? $lang['Session_backend_explain'] : '',
	'L_PORTAL_URL'								=> $lang['Portal_url'],
	'L_BACKEND_URL'							=> $lang['Phpbb_url'],
	'L_DBMS'												=> $lang['dbms'],
	'L_DB_HOST'										=> $lang['DB_Host'],
	'L_DB_NAME'										=> $lang['DB_Name'],
	'L_DB_USER'										=> $lang['DB_Username'],
	'L_DB_PASSWORD'							=> $lang['DB_Password'],
	'L_MXP_ADMINNAME'						=> $lang['MXP_Adminname'],
	'L_MXP_PASSWORD'						=> $lang['MXP_Password'],
	'L_MXP_PASSWORD2'						=> $lang['MXP_Password2'],
	'L_DB_PREFIX'									=> $lang['Table_Prefix'],
	'L_ACM_TYPE'									=> (!empty($lang['acm_type']) ? $lang['acm_type'] : 'Acm Type'),
	'L_MX_DB_PREFIX'							=> $lang['MX_Table_Prefix'],
	'L_MXP_ADMIN'									=> $lang['Install_Instruction_MXP_Admin'],
	'L_SUBMIT'											=> $lang['Start_Install'],
	'MX_DB_PREFIX'								=> (!empty($mx_table_prefix) ? $mx_table_prefix : 'mx_'),
	'DBMS_SELECT'								=> dbms_select($default_dbms),
	
	'S_DBMS_TYPE'							=> $select_database_type,	
	'S_BACKEND_PATH'				=> $select_backend_path,
	
	'S_HIDDEN_FIELDS'					=> $s_hidden_fields,
	'S_FORM_ACTION'					=> "mx_install.$phpEx",
));

/* -------------------- */
if(defined('INSTALL_READONLY'))
{
	$template->assign_block_vars('switch_readonly_mode', array());
	$template->assign_vars(array('READONLY' => ' readonly="readonly"'));
}
else
{
	$template->assign_block_vars('switch_readonly_mode', '');
	$template->assign_vars(array('READONLY' => ' access="edit"'));
}

/* -------------------- */
$template->pparse('body');

/* -------------------- */
page_footer_install();
// ================================================================================
// MAIN PROCEDURE ENDS HERE.
// ================================================================================
?>
