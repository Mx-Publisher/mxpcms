<?php
/**
*
* @package mxBB Portal Module - mx_counter
* @version $Id: db_install.php,v 1.3 2011/03/29 01:53:45 orynider Exp $
* @copyright (c) 2003 [orynider@rdslink.ro, OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//ini_set( 'display_errors', '1' );

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

$mx_module_version = '2.0.0';
$mx_module_copy = 'MX-Publisher <i> - Counter</i> module by OryNider & <a href="http://www.mxpcms.sourceforge.net" target="_blank">Mx Team</a>';

// If fresh install

if ( !$result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "counter_config" ) )
{
	$message = "<b>This is a fresh install!</b><br/><br/>";

	$sql = array();

	$sql[] = "DROP TABLE IF EXISTS " . $mx_table_prefix . "counter_config";

	$sql[] = "DROP TABLE IF EXISTS " . $mx_table_prefix . "counter_session";

	$sql[] = "CREATE TABLE ".$mx_table_prefix."counter_session (
		count_id int(11) UNSIGNED NOT NULL auto_increment,
		currentcount varchar(255) NOT NULL,
		PRIMARY KEY (count_id)
		) TYPE=MyISAM";
		
	$sql[] = "CREATE TABLE " . $mx_table_prefix . "counter_config (
  			 	   	    config_name VARCHAR(255) NOT NULL default '',
						config_value varchar(255) NOT NULL default '',
						PRIMARY KEY  (config_name)
						) TYPE=MyISAM";

	$sql[] = "INSERT INTO " . $mx_table_prefix . "counter_session VALUES ('count_id', '1')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "counter_config ( config_name , config_value ) VALUES ('digitpath', 'set1')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "counter_config ( config_name , config_value ) VALUES ('digits', '5')";

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