<?php
/**
*
* @package MX-Publisher Module - mx_translator
* @version $Id: db_install.php,v 3.0 2018/12/20 06:48:36 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson],  (c) 2007-2018 [FlorinCB] MXP Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

define( 'IN_PORTAL', true );

if ( !defined( 'IN_ADMIN' ) )
{
	$mx_root_path = './../../';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include( $mx_root_path . 'common.' . $phpEx );
	// Start session management
	$mx_user->init($user_ip, PAGE_INDEX);

	if ( !$userdata['session_logged_in'] )
	{
		die( "Hacking attempt(1)" );
	}

	if ( $userdata['user_level'] != ADMIN )
	{
		die( "Hacking attempt(2)" );
	}
	// End session management
}

$mx_module_version = '1.0.0-beta';
$mx_module_copy = 'Original MX-Publisher <i>Translator</i> module by <a href="http://mxpcms.sf.net" target="_blank">culprit_cz</a>';

// For compatibility with core 2.7.+
define('MXBB_27x', file_exists($mx_root_path . 'mx_login.php'));

// BEGIN MySQL
// Structure from phpBBMyAdmin
// If the DB engine is MySQL query show a specific table:
$type = $collation = $encoding = $collate = $engine = $charset = $message = '';
if (preg_match('/mysql/i', $dbms) !== false)
{
	$sql = "SHOW TABLE STATUS LIKE '" . $db->sql_escape($mx_table_prefix . "portal") . "'";
	//$sql = "SHOW COLUMNS FROM " . $mx_table_prefix . "portal";
	$result = $db->sql_query($sql);

	$message .= "<b>Show MySQL Columns!<br/><br/>We get: COLLATE, and ENGINE, and  DEFAULT CHARSET ...</b><br/><br/>";

	if (!$result)
	{
		// Eeeeeh... no columns perhaps?
		$message .= "<b>" . $lang['SQL_Admin_Columns_Error'] . "</b><br/><br/>";
	}
	else
	{
		$message .= "<b>" . $lang['import_module_pack'] . "...</b><br/><br/>";
	}
	// Found data (obviously), let's build an output...
	$counter = 0;
	while ($row = $db->sql_fetchrow($result))
	{
		$counter++;
		$tables[$counter] = $row['Name'];
		
		if (!isset($row['Engine']) && ($counter == 1))
		{
			$message .= "<b>No Engine?</b><br/><br/>";
		}
		//Vars:
		//$row['Field'];
		//$row['Null'];
		//$row['Key'];
		//$row['Default'];
		//$row['Extra'];
		//$row['Key'];
		//$row['Default'];
		//$row['Extra'];
		$engine = $row['Engine'];

		if (is_array($row['Type'])) 
		{
			$column_spec = extractColumnSpec($row['Type']);
			$attribute = trim($column_spec[ 'attribute']);
			$type = $column_spec['type'];
			$length = $column_spec['spec_in_brackets'];
		}
		else
		{
			$type = $row['Type'];
		}

		if (isset($def['Attribute'])) 
		{
			 $attribute = $def['Attribute'];
		}

		$collation = isset($row['Collation']) ? $row['Collation'] : 'utf8_bin'; 
	}
	$db->sql_freeresult($result);
	// END structure

	$db->sql_query("SET NAMES 'utf8'");

	if (empty($engine))
	{
		$engine = $type;
	}

	if (is_array($engine))
	{
		$engine = $engine[0];
	}

	if (is_array($collation))
	{
		$collation = $collation[0];
	}

	if (empty($engine))
	{
		$sql_results = array();
		// MG forced this because in MySQL 5.5.5 
		//			the new default DB Engine is InnoDB, 
		//				not MyISAM any more
		$message .= "<b>Can not determine engine type, so we try MyISAM!</b><br/><br/>";
		$engine = "MYISAM";
	}

	$sql_engine = "SET storage_engine=".$engine."";
	$sql_foreign = "SET FOREIGN_KEY_CHECKS=1";
	$db->sql_return_on_error(true);
	$db->sql_query($sql_engine);
	$db->sql_query($sql_foreign);
	$db->sql_return_on_error(false);

	$collate = " COLLATE $collation"; 
	$engine = " ENGINE=$engine";
	$charset = preg_match('/utf8/i', $collation) ? " DEFAULT CHARSET=utf8" : "";
}
// END MySQL

// If fresh install
if (!$result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "translator_config") )
{
	$message .= "<b>This is a fresh install!</b><br/><br/>";

	$sql = array(
		"DROP TABLE IF EXISTS " . $mx_table_prefix . "translator_config ",

		// --------------------------------------------------------
		/* Table structure for table `translator_config`*/
		"CREATE TABLE `" . $mx_table_prefix . "translator_config` (
		  `config_name` varchar(100)" . $collate . " NOT NULL DEFAULT '',
		  `config_value` varchar(190)" . $collate . " NOT NULL DEFAULT '',
		  `is_dynamic` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
		) " . $engine . $charset . $collate . "",

		"ALTER TABLE `" . $mx_table_prefix . "translator_config`
		  ADD PRIMARY KEY (`config_name`),
		  ADD KEY `is_dynamic` (`is_dynamic`)",
		
		/* */
		/* Config values
		/* */
		"INSERT INTO " . $mx_table_prefix . "translator_config (`config_name`, `config_value`) VALUES ('enable_module', '1')", // settings_disable
		"INSERT INTO " . $mx_table_prefix . "translator_config (`config_name`, `config_value`) VALUES ('module_name', 'Download Database')", // settings_dbname
		"INSERT INTO " . $mx_table_prefix . "translator_config (`config_name`, `config_value`) VALUES ('translator_default_lang', 'en')", // settings_disable
		"INSERT INTO " . $mx_table_prefix . "translator_config (`config_name`, `config_value`) VALUES ('translator_choice_lang', 'fr,es,ro,it')", // settings_dbname
	);

	if (!MXBB_27x)
	{
		$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
				    SET module_version  = '" . $mx_module_version . "',
				      module_copy  = '" . $mx_module_copy . "'
				    WHERE module_id = '" . $mx_module_id . "'";
	}
	$message .= mx_do_install_upgrade($sql);
}
else
{
	// If already installed
	$message = "<b>Module is already installed...consider upgrading ;)</b><br/><br/>";
}


echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstalling Information - module specific db tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . $message . "</span></td></tr>";
echo "</table><br />";

?>