<?php
/**
*
* @package MX-Publisher Core
* @version $Id: db_convert.php,v 1.5 2014/05/18 06:24:18 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @based on tutorial by http://www.sveit.com
* @link http://mxpcms.sourceforge.net/
*
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

//
// Set MX-Publisher version here !
//
$mx_portal_name 	= 'MX-Publisher Modular System';
$mx_portal_version 	= '3.0.0-RC';
$mx_php_version		= '5.1.2';
$mx_portal_copy 	= '<b>MX-Publisher Modular System!</b> <br /><br/> MX-Publisher is a fully modular system, portal and CMS, featuring dynamic pages, blocks, and themes, by means of a powerful yet flexible AdminCP. It is the classical phpBB portal add-on, improved and enhanced for every phpBB version released since 2001 (originally named MX-Publisher). <br /><br />Authors: The MX-Publisher Development Team. <br />Please visit <a href="http://mxpcms.sf.net/">mxpcms.sourceforge.net</a> for further information.';

define('INSTALLER_VERSION', '1.0.0');
define('INSTALLER_NAME', 'MX-Publisher-DB-Converter');

@ini_set( 'display_errors', '1' );
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);

if( @file_exists($mx_root_path . "config.$phpEx") )
{
	include($mx_root_path . "config.$phpEx");
}

//
// Redirect for fresh MX-Publisher install
//
if( !defined('MX_INSTALLED') || (MX_INSTALLED === false) )
{
	header('Location: ' . $mx_root_path . 'install/mx_install.' . $phpEx);
	exit;
}

include_once($mx_root_path . "includes/db/" . $dbms . ".$phpEx"); // Load dbal and initiate class
include_once($mx_root_path . 'includes/mx_functions_core.' . $phpEx); // CORE class
include_once($mx_root_path . "install/includes/functions_install.$phpEx");

//
// instatiate the mx_request_vars class
// make sure to do before it's ever used
$mx_request_vars = new mx_request_vars();

//
// phpInfo --------------------------------------------------
//
if ($mx_request_vars->is_get('phpinfo'))
{
	show_phpinfo();
	exit;
}

$db = new $sql_db();
if(!$db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, false))
{
	install_die("SQL Error: Could not connect to the database");
}
unset($dbpasswd);

include_once($mx_root_path . "install/includes/template.$phpEx");

$template = new Template($mx_root_path . 'install/templates');

page_header_install($lang['Installation_error'], INSTALLER_NAME);

switch ($db->sql_layer)
{
	case 'mysql':
	case 'mysql4':
	case 'mysqli':
		$sql = 'SHOW TABLES';
	break;

	case 'sqlite':
		$sql = 'SELECT name
			FROM sqlite_master
			WHERE type = "table"';
	break;

	case 'mssql':
	case 'mssql_odbc':
		$sql = "SELECT name
			FROM sysobjects
			WHERE type='U'";
	break;

	case 'postgres':
		$sql = 'SELECT relname
			FROM pg_stat_user_tables';
	break;

	case 'firebird':
		$sql = 'SELECT rdb$relation_name
			FROM rdb$relations
			WHERE rdb$view_source is null
				AND rdb$system_flag = 0';
	break;

	case 'oracle':
		$sql = 'SELECT table_name
			FROM USER_TABLES';
	break;
}

// Determine mapping database type
switch ($db->sql_layer)
{
	case 'mysql':
		$this_sql_layer = 'mysql_40';
	break;

	case 'mysql4':
		if (version_compare($db->mysql_version, '4.1.3', '>='))
		{
			$this_sql_layer = 'mysql_41';
		}
		else
		{
			$this_sql_layer = 'mysql_40';
		}
	break;

	case 'mysqli':
		$this_sql_layer = 'mysql_41';
	break;

	case 'mssql':
	case 'mssql_odbc':
		$this_sql_layer = 'mssql';
	break;

	default:
		$this_sql_layer = $db->sql_layer;
	break;
}

switch ($db->sql_layer)
{
	case 'mysql':
		$charset = ' CHARACTER SET latin1;';
	break;

	case 'mysql4':
		if (version_compare($db->mysql_version, '4.1.3', '>='))
		{
			$charset = ' CHARACTER SET utf8 COLLATE utf8_bin;';
		}
		else
		{
			$charset = ' CHARACTER SET latin1;';
		}
	break;

	case 'mysqli':
		$charset = ' CHARACTER SET utf8 COLLATE utf8_bin;';
	break;
	
	default:
		$charset = ' CHARACTER SET latin1;';	
}	
 

if (!($result = $db->sql_query($sql)))
{
   install_die('SQL Error: ' . 'Line: ' . __LINE__ . 'File: ' . __FILE__  . 'Query: ' . $sql);
}


// Loop through all tables in this database
while ($row = $db->sql_fetchrow($result))
{
	$tables = array();

	$tables[] = current($row);

	$db->sql_freeresult($result);

	$table = $tables[0];
	$sql2 = "ALTER TABLE $table DEFAULT CHARACTER SET utf8 COLLATE utf8_bin";
   
	if ( !($result2 = $db->sql_query($sql2)) )
	{
		install_die('SQL Error: ' . 'Line: ' . __LINE__ . ' File: ' . __FILE__  . ' Query: ' . $sql2);
      
		break;
	}
   
	print "$table changed to UTF-8 successfully.<br>\n";
	
	
	switch ($this_sql_layer)
	{
		case 'mysql_40':
		case 'mysql_41':
			$sql3 = "SHOW COLUMNS
				FROM $table";
			if ( !($result3 = $db->sql_query($sql3)) )
			{
				install_die('SQL Error: ' . 'Line: ' . __LINE__ . ' File: ' . __FILE__  . ' Query: ' . $sql3);
					      
				break;
			}			
		break;

		// PostgreSQL has a way of doing this in a much simpler way but would
		// not allow us to support all versions of PostgreSQL
		case 'postgres':
			$sql3 = "SELECT a.attname
				FROM pg_class c, pg_attribute a
				WHERE c.relname = '{$table}'
					AND a.attnum > 0
					AND a.attrelid = c.oid";
			if ( !($result3 = $db->sql_query($sql3)) )
			{
				install_die('SQL Error: ' . 'Line: ' . __LINE__ . ' File: ' . __FILE__  . ' Query: ' . $sql3);
					      
				break;
			}
		break;

		// same deal with PostgreSQL, we must perform more complex operations than
		// we technically could
		case 'mssql':
			$sql3 = "SELECT c.name
				FROM syscolumns c
				LEFT JOIN sysobjects o ON c.id = o.id
				WHERE o.name = '{$table}'";
			if ( !($result3 = $db->sql_query($sql3)) )
			{
				install_die('SQL Error: ' . 'Line: ' . __LINE__ . ' File: ' . __FILE__  . ' Query: ' . $sql3);
					      
				break;
			}
		break;

		case 'oracle':
			$sql3 = "SELECT column_name
				FROM user_tab_columns
				WHERE table_name = '{$table}'";
			if ( !($result3 = $db->sql_query($sql3)) )
			{
				install_die('SQL Error: ' . 'Line: ' . __LINE__ . ' File: ' . __FILE__  . ' Query: ' . $sql3);
					      
				break;
			}
		break;

		case 'firebird':
			$sql3 = "SELECT RDB\$FIELD_NAME as FNAME
				FROM RDB\$RELATION_FIELDS
				WHERE RDB\$RELATION_NAME = '{$table}'";
			if ( !($result3 = $db->sql_query($sql3)) )
			{
				install_die('SQL Error: ' . 'Line: ' . __LINE__ . ' File: ' . __FILE__  . ' Query: ' . $sql3);
					      
				break;
			}
		break;

		// ugh, SQLite
		case 'sqlite':
			$sql3 = "SELECT sql
				FROM sqlite_master
				WHERE type = 'table'
					AND name = '{$table}'";
			if ( !($result3 = $db->sql_query($sql3)) )
			{
				install_die('SQL Error: ' . 'Line: ' . __LINE__ . ' File: ' . __FILE__  . ' Query: ' . $sql3);
					      
				break;
			}
		break;			
	}

	while ($row3 = $db->sql_fetchrow($result3) )
	{	
		$field_types = array();

		$field_types[] = current($row3);

		$db->sql_freeresult($result3);

		$field_type = $field_types[1];
	
		switch ($this_sql_layer)
		{
			case 'mysql_40':
			case 'mysql_41':

				// lower case just in case
				$field_name = strtolower($row3['Field']);
				$field_type = strtolower($row3['Type']); 
			break;

			case 'postgres':
				// lower case just in case
				$field_name = strtolower($row3['attname']);
				$field_type = strtolower($row3['atttype']);				
			break;

			case 'mssql':
				// lower case just in case
				$field_name = strtolower($row3['name']);
				$field_type = strtolower($row3['type']);					
			break;

			case 'oracle':
				// lower case just in case
				$field_name = strtolower($row3['column_name']);
				$field_type = strtolower($row3['column_type']);				
			break;

			case 'firebird':
				// lower case just in case
				$field_name = strtolower($row3['fname']);
				$field_type = strtolower($row3['ftype']);				
			break;

			case 'sqlite':

				preg_match('#\((.*)\)#s', $row['sql'], $matches);

				$cols = trim($matches[1]);
				$col_array = preg_split('/,(?![\s\w]+\))/m', $cols);

				foreach ($col_array as $declaration)
				{
					$entities = preg_split('#\s+#', trim($declaration));
					if ($entities[0] == 'PRIMARY')
					{
						continue;
					}
					
					// lower case just in case
					$field_name = strtolower($entities[0]);
					$field_type = strtolower($entities[1]);
				}

			break;
		}	
      
		// Change text based fields
		$skipped_field_types = array('char', 'text', 'blob', 'enum', 'set');
      
		foreach ( $skipped_field_types as $type )
		{
			if ( strpos($field_type, $type) !== false )
			{
				$sql4 = "ALTER TABLE $table CHANGE `$field_name` `$field_name` $field_type " . $charset;
				if ( !($result4 = $db->sql_query($sql4)) )
				{
					install_die('SQL Error: ' . 'Line: ' . __LINE__ . ' File: ' . __FILE__  . ' Query: ' . $sql4);
               
					break 3;
				}
				print "---- $field_name changed to UTF-8 successfully.<br>\n";
			}
		}
	}
	print "<hr>\n";
}

page_footer_install();

//
// Close our DB connection.
//
$db->sql_close();
?>
