<?php
/**
*
* @package Mx-Publisher Module - mx_phpbb
* @version $Id: db_upgrade.php,v 1.2 2010/10/16 04:06:36 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] Mx-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
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

$mx_module_version = '2.0.6';
$mx_module_copy = 'Original MX-Publisher <i> - phpBB integration</i> module by <a href="http://www.phpmix.com" target="_blank">Markus</a> & <a href="http://www.mx-publisher.com" target="_blank">Jon</a>';

$sql = array();

//
// Precheck
//
if ( $result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "phpbb_plugin_config" ) )
{
	//
	// Upgrade checks
	//
	$upgrade_101 = 0;
	$upgrade_102 = 0;
	$upgrade_103 = 0;
	$upgrade_104 = 0;
	$upgrade_105 = 0;
	$upgrade_106 = 0;
	$upgrade_107 = 0;

	//
	// validate before 1.01
	//
	$result = $db->sql_query( "SELECT config_value from " . $mx_table_prefix . "phpbb_plugin_config WHERE config_name = 'override_default_pages'" );
	if ( $db->sql_numrows( $result ) == 0 )
	{
		$upgrade_101 = 1;
	}

	$result = $db->sql_query( "SELECT config_value from " . $mx_table_prefix . "phpbb_plugin_config WHERE config_name = 'enable_module'" );
	if ( $db->sql_numrows( $result ) == 0 )
	{
		$upgrade_102 = 1;
	}


	$message = "<b>Upgrading!</b><br/><br/>";

	if ( $upgrade_101 == 1 )
	{
		$message .= "<b>Upgrading to v. 1.01...</b><br/><br/>";
		$sql[] = "CREATE TABLE " . $mx_table_prefix . "phpbb_plugin_config (
		  			 	   	    config_name VARCHAR(255) NOT NULL default '',
								config_value varchar(255) NOT NULL default '',
								PRIMARY KEY  (config_name)
								) TYPE=MyISAM";

		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('override_default_pages', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('faq', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('groupcp', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('index', '2')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('login', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('memberlist', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('modcp', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('posting', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('privmsg', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('profile', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('search', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('viewonline', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('other', '0')";
	}
	else if ( $upgrade_102 == 1 )
	{
		$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('enable_module', '1')";
	}
	else
	{
		$message .= "<b>Nothing to upgrade...</b><br/><br/>";
	}

	$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
				    SET module_version  = '" . $mx_module_version . "',
				      module_copy  = '" . $mx_module_copy . "'
				    WHERE module_id = '" . $mx_module_id . "'";

	$message .= mx_do_install_upgrade( $sql );
	$message .= "<b>...Now upgraded to v. $mx_module_version :-)</b><br/><br/>";
}
else
{
	//
	// If not installed
	//
	$message = "<b>Module is not installed...and thus cannot be upgraded ;)</b><br/><br/>";
}

echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstalling Information - module specific db tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . $message . "</span></td></tr>";
echo "</table><br />";

?>