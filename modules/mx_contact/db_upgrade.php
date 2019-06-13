<?php
/**
*
* @package mxBB Portal Module - mx_contact
* @version $Id: db_upgrade.php,v 1.7 2011/04/17 08:37:07 orynider Exp $
* @copyright (c) 2003 [orynider@rdslink.ro, OryNider] mxBB Development Team
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

$mx_module_version = '2.9.1';
$mx_module_copy = 'MX-Publisher <i> - Contact</i> module by Florin C Bodin, <a title="author" alt="Marcus Smith" href="http://www.phobbia.net/mods/">Marcus Smith</a>';


$sql = array();

//
// Precheck
//
if ( $result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "contact_config" ) )
{
	//
	// Upgrade checks
	//
	$upgrade_200 = 0;
	$upgrade_291 = 1;
		
	//
	// validate before 2.00
	//
	$result = $db->sql_query( "SELECT config_value from " . $mx_table_prefix . "contact_config WHERE config_name = 'newsletter_version'" );
	if ( $db->sql_numrows( $result ) == 0 )
	{
		$upgrade_200 = 1;		
	}
	
	//
	// validate before 2.91
	//
	$result = $db->sql_query( "SELECT config_value from " . $mx_table_prefix . "contact_config WHERE config_name = 'domainkey_signature'" );
	if ( $db->sql_numrows( $result ) == 0 )
	{
		$upgrade_291 = 1;		
	}	

	$message = "<b>Upgrading!</b><br/><br/>";

	if ( $upgrade_200 == 1 )
	{
		$message .= "<b>Upgrading to v. 2.00...</b><br/><br/>";
		
		$sql[] = 'CREATE TABLE ' . $mx_table_prefix . 'contact_mass_news (
			mail_id smallint(5) unsigned NOT NULL auto_increment,
			mailsession_id varchar(32) NOT NULL default \'\',
			group_id mediumint(8) NOT NULL default \'0\',
			email_subject varchar(60) NOT NULL default \'\',
			email_body mediumtext NOT NULL,
			batch_start mediumint(8) NOT NULL default \'0\',
			batch_size smallint(5) unsigned NOT NULL default \'0\',
			batch_wait smallint(6) NOT NULL default \'0\',
			status smallint(6) NOT NULL default \'0\',
			user_id mediumint(8) NOT NULL default \'0\',
			PRIMARY KEY  (mail_id) ) ';

		$sql[] = "ALTER TABLE " . $mx_table_prefix . "contact_msgs ADD institution VARCHAR(50) NOT NULL DEFAULT '' AFTER realname";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "contact_msgs ADD phone VARCHAR(50) NOT NULL DEFAULT '' AFTER institution";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "contact_msgs ADD fax VARCHAR(50) NOT NULL DEFAULT '' AFTER phone";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "contact_msgs ADD newsletter int(3) NOT NULL default '0' AFTER message";	
		$sql[] = "INSERT INTO " . $mx_table_prefix . "contact_config VALUES ('newsletter_version', '1.0.0')";
	}
	else if ($upgrade_291 == 1)
	{
		$message .= "<b>Upgrading to v. 2.91...</b><br/><br/>";
		
		$sql[] = "INSERT INTO " . $mx_table_prefix . "contact_config VALUES('domainkey_signature','')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "contact_config VALUES('smtp_port','25')";
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
