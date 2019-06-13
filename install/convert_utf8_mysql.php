<?php
/**
*
* @package MX-Publisher Installation
* @version $Id: convert_utf8_mysql.php,v 1.3 2014/05/13 17:59:42 orynider Exp $
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
if (@function_exists('mysqli_connect'))
{
	//define('SQL_LAYER', 'mysqli');
	$dbms = 'mysqli'; // Repopulated for multiple db connections	
}
else
{
	//define('SQL_LAYER', 'mysql');
	$dbms = 'mysql4'; // Repopulated for multiple db connections	
}

// Connect to the database
//
require(INCLUDES . 'db/' . $dbms . '.' . PHP_EXT); // Load dbal and initiate class	

/*
$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
if(!$db->db_connect_id)
{
	trigger_error('Database connection failed', E_USER_ERROR);
}
*/

// HTML HEADER - BEGIN
echo("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n");
echo("<html xmlns=\"http://www.w3.org/1999/xhtml\">\n");
echo("<head>\n");
echo("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n");
echo("<meta name=\"author\" content=\"Icy Phoenix Team\" />\n");
echo("<title>MXP :: UTF-8 Conversion</title>\n");
echo("</head>\n");
echo("<body>\n");
echo("<div style=\"font-family: 'Lucida Grande', 'Trebuchet MS', Verdana, Helvetica, Arial, sans-serif; font-size: 10px;\">\n");
echo("<b style=\"color: #dd2222;\">DB Conversion to UTF-8 in progress, please do not stop the browser until the whole process is finished...</b><br />\n<br />\n<br />\n");
// HTML HEADER - END
flush();

$sql = "ALTER DATABASE {$db->sql_escape($dbname)}
	CHARACTER SET utf8
	DEFAULT CHARACTER SET utf8
	COLLATE utf8_bin
	DEFAULT COLLATE utf8_bin";
$db->sql_query($sql) or die($db->sql_error());

$sql = "SHOW TABLES";
$result = $db->sql_query($sql) or die($db->sql_error());
while ($row = $db->sql_fetchrow($result))
{
	// This assignment doesn't work...
	//$table = $row[0];

	$current_item = each($row);
	$table = $current_item['value'];
	reset($row);

	$sql = "ALTER TABLE {$db->sql_escape($table)}
		DEFAULT CHARACTER SET utf8
		COLLATE utf8_bin";
	$db->sql_query($sql) or die($db->sql_error());

	echo("&bull;&nbsp;Table&nbsp;<b style=\"color: #dd2222;\">$table</b> converted to UTF-8<br />\n");

	$sql = "SHOW FIELDS FROM {$db->sql_escape($table)}";
	$result_fields = $db->sql_query($sql);

	while ($row_fields = $db->sql_fetchrow($result_fields))
	{
		// These assignments don't work...
		/*
		$field_name = $row_fields[0];
		$field_type = $row_fields[1];
		$field_null = $row_fields[2];
		$field_key = $row_fields[3];
		$field_default = $row_fields[4];
		$field_extra = $row_fields[5];
		*/

		$field_name = $row_fields['Field'];
		$field_type = $row_fields['Type'];
		$field_null = $row_fields['Null'];
		$field_key = $row_fields['Key'];
		$field_default = $row_fields['Default'];
		$field_extra = $row_fields['Extra'];

		// Let's remove BLOB and BINARY for now...
		//if ((strpos(strtolower($field_type), 'char') !== false) || (strpos(strtolower($field_type), 'text') !== false) || (strpos(strtolower($field_type), 'blob') !== false) || (strpos(strtolower($field_type), 'binary') !== false))
		if ((strpos(strtolower($field_type), 'char') !== false) || (strpos(strtolower($field_type), 'text') !== false))
		{
			//$sql_fields = "ALTER TABLE {$db->sql_escape($table)} CHANGE " . $db->sql_escape($field_name) . " " . $db->sql_escape($field_name) . " " . $db->sql_escape($field_type) . " CHARACTER SET utf8 COLLATE utf8_bin";

			$sql_fields = "ALTER TABLE {$db->sql_escape($table)} CHANGE " . $db->sql_escape($field_name) . " " . $db->sql_escape($field_name) . " " . $db->sql_escape($field_type) . " CHARACTER SET utf8 COLLATE utf8_bin " . (($field_null != 'YES') ? "NOT " : "") . "NULL DEFAULT " . (($field_default != 'None') ? ((!empty($field_default) || !is_null($field_default)) ? (is_string($field_default) ? ("'" . $db->sql_escape($field_default) . "'") : $field_default) : (($field_null != 'YES') ? "''" : "NULL")) : "''");
			$db->sql_query($sql_fields);

			echo("\t&nbsp;&nbsp;&raquo;&nbsp;Field&nbsp;<b style=\"color: #4488aa;\">$field_name</b> (in table <b style=\"color: #009900;\">$table</b>) converted to UTF-8<br />\n");
		}
	}
	echo("<br />\n");
	flush();
}

$db->sql_close();

echo("<br />\n<br />\n<br />\n<b style=\"color: #dd2222;\">Work Complete!!!</b><br />\n");

// HTML FOOTER - BEGIN
echo("</div>\n");
echo("</body>\n");
echo("</html>\n");
// HTML FOOTER - BEGIN

flush();
exit;

?>