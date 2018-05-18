<?php
/**
*
* @package MX-Publisher Module - mx_dev_startkit
* @version $Id: db_install.php,v 1.10 2008/06/03 20:07:26 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
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

$mx_module_version = '2.0.0-b2';
$mx_module_copy = 'Original MX-Publisher <i>developers startkit</i> module by [Jon Ohlsson] <a href="http://www.mx-publisher.com" target="_blank">The MX-Publisher Development Team</a>';

if ( !$result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "dev_startkit_config" ) )
{
	//
	// Fresh install
	//
	$message = "<b>This is a fresh install!</b><br/><br/>";

	$sql = array();

	$sql[] = "DROP TABLE IF EXISTS " . $mx_table_prefix . "dev_startkit_config";

	$sql[] = "CREATE TABLE " . $mx_table_prefix . "dev_startkit_config (
  			 	   	    config_name VARCHAR(255) NOT NULL default '',
						config_value varchar(255) NOT NULL default '',
						PRIMARY KEY  (config_name)
						) TYPE=MyISAM";

	$sql[] = "INSERT INTO " . $mx_table_prefix . "dev_startkit_config VALUES ('startkit_config1', 'test1')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "dev_startkit_config VALUES ('startkit_config2', 'test2')";

	$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
				    SET module_version  = '" . $mx_module_version . "',
				      module_copy  = '" . $mx_module_copy . "'
				    WHERE module_id = '" . $mx_module_id . "'";

	$message .= mx_do_install_upgrade( $sql );
}
else
{
	//
	// Updating
	//
	$message = "<b>Nothing to do... ;)</b><br/><br/>";
}

echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstalling Information - module specific db tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . $message . "</span></td></tr>";
echo "</table><br />";

?>