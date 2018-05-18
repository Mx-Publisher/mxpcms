<?php
/**
*
* @package Mx-Publisher Module - mx_phpbb
* @version $Id: db_install.php,v 1.2 2010/10/16 04:06:36 orynider Exp $
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
	// End session management

	if ( !$userdata['session_logged_in'] )
	{
		die( "Hacking attempt(1)" );
	}

	if ( $userdata['user_level'] != ADMIN )
	{
		die( "Hacking attempt(2)" );
	}

}

$mx_module_version = '2.0.6';
$mx_module_copy = 'Original MX-Publisher <i> - phpBB integration</i> module by <a href="http://www.phpmix.com" target="_blank">Markus</a> & <a href="http://www.mx-publisher.com" target="_blank">Jon Ohlsson</a>';

// If fresh install

if ( !$result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "phpbb_plugin_config" ) )
{
	$message = "<b>This is a fresh install!</b><br/><br/>";

	$sql = array();

	$sql[] = "DROP TABLE IF EXISTS " . $mx_table_prefix . "phpbb_plugin_config";

	$sql[] = "CREATE TABLE " . $mx_table_prefix . "phpbb_plugin_config (
  			 	   	    config_name VARCHAR(255) NOT NULL default '',
						config_value varchar(255) NOT NULL default '',
						PRIMARY KEY  (config_name)
						) ";

	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('override_default_pages', '0')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('enable_module', '1')";

	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('faq', '2')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('groupcp', '2')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('index', '2')";

	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('login', '2')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('memberlist', '2')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('privmsg', '2')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('profile', '2')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('search', '2')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('viewonline', '2')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "phpbb_plugin_config VALUES ('other', '2')";

	$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
				    SET module_version  = '" . $mx_module_version . "',
				      module_copy  = '" . $mx_module_copy . "'
				    WHERE module_id = '" . $mx_module_id . "'";

	$message .= mx_do_install_upgrade( $sql );
}
else
{
	// If already installed
	$message = "<b>Module is already installed... consider upgrading ;)</b><br/><br/>";
}

echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstallation Information - Module specific DB tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . $message . "</span></td></tr>";
echo "</table><br />";

?>