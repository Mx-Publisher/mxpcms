<?php
/**
*
* @package MX-Publisher Installation
* @version $Id: convert_utf8_nodbal.php,v 1.3 2014/05/13 17:59:42 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @link http://mxpcms.sourceforge.net/
*
*/

/*
* Thanks to:
* http://www.v-nessa.net/2007/12/06/convert-database-to-utf-8
* http://developer.loftdigital.com/blog/php-utf-8-cheatsheet
* http://www.mysqlperformanceblog.com/2007/12/18/fixing-column-encoding-mess-in-mysql/
* Mighty Gorgon, http://www.icyphoenix.com/
*/
die('Comment this line...');
//
// Initialization
//
define('IN_PORTAL', true);
define('IN_PHPBB', true);
define('INSTALLING', true);
$mx_root_path = '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$tplEx = @file_exists($mx_root_path.'install/templates/mx_install_header.html') ? 'html' : 'tpl';
define('INCLUDES', $mx_root_path  . 'includes/'); //Main Includes folder
define('DBCHARACTER_SET', 'utf8');
//
// FYI:
// The following code related to PHP Global Variables is based on
// common.php from phpBB 2.0.18
//
@ini_set( 'display_errors', '1' );
error_reporting(E_ALL ^ E_NOTICE);
//error_reporting  (E_ERROR | E_WARNING | E_PARSE); // This will NOT report uninitialized variables
//include($mx_root_path . "modules/mx_shared/ErrorHandler/prepend.$phpEx"); // For nice error output

if (php_sapi_name() === 'cli')
{
	define('MX_ROOT_PATH', dirname(dirname($argv[0])) . '/');
}

if (!defined('MX_ROOT_PATH')) define('MX_ROOT_PATH', $mx_root_path);
if (!defined('PHP_EXT')) define('PHP_EXT', substr(strrchr(__FILE__, '.'), 1));

require(MX_ROOT_PATH . 'config.' . PHP_EXT);
# Nothing needs to be set below this line...

$db = new mysqli($dbhost, $dbuser, $dbpasswd, $dbname);

if (mysqli_connect_error())
{
	trigger_error('Database connection failed', E_USER_ERROR);
}

$sql = "ALTER DATABASE {$db->real_escape_string($dbname)}
	CHARACTER SET utf8
	DEFAULT CHARACTER SET utf8
	COLLATE utf8_bin
	DEFAULT COLLATE utf8_bin";
$db->query($sql) or die(mysql_error());

$sql = "SHOW TABLES";
$result = $db->query($sql) or die(mysql_error());
while ($row = $result->fetch_row())
{
	$table = $row[0];
	$sql = "ALTER TABLE {$db->real_escape_string($table)}
		DEFAULT CHARACTER SET utf8
		COLLATE utf8_bin";
	$db->query($sql) or die(mysql_error());
	print "$table changed to UTF-8.<br />\n";

	$sql = "SHOW FIELDS FROM {$db->real_escape_string($table)}";
	$result_fields = $db->query($sql);

	while ($row_fields = $result_fields->fetch_row())
	{
		$field_name = $row_fields[0];
		$field_type = $row_fields[1];
		$field_null = $row_fields[2];
		$field_key = $row_fields[3];
		$field_default = $row_fields[4];
		$field_extra = $row_fields[5];
		if ((strpos(strtolower($field_type), 'char') !== false) || (strpos(strtolower($field_type), 'text') !== false) || (strpos(strtolower($field_type), 'blob') !== false) || (strpos(strtolower($field_type), 'binary') !== false))
		{
			//$sql_fields = "ALTER TABLE {$db->real_escape_string($table)} CHANGE " . $db->real_escape_string($field_name) . " " . $db->real_escape_string($field_name) . " " . $db->real_escape_string($field_type) . " CHARACTER SET utf8 COLLATE utf8_bin";
			$sql_fields = "ALTER TABLE {$db->real_escape_string($table)} CHANGE " . $db->real_escape_string($field_name) . " " . $db->real_escape_string($field_name) . " " . $db->real_escape_string($field_type) . " CHARACTER SET utf8 COLLATE utf8_bin " . (($field_null != 'YES') ? "NOT " : "") . "NULL DEFAULT " . (($field_default != 'None') ? ((!empty($field_default) || !is_null($field_default)) ? (is_string($field_default) ? ("'" . $db->real_escape_string($field_default) . "'") : $field_default) : (($field_null != 'YES') ? "''" : "NULL")) : "''");
			$db->query($sql_fields);
			print "\t$sql_fields<br />\n";
		}
	}
}
$result->close();

$sql = "ALTER TABLE {$table_prefix}search_wordlist CHANGE word_text varchar(50) COLLATE utf8_bin NOT NULL DEFAULT ''";
$db->query($sql) or die(mysql_error());

$db->close();

?>