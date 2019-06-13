<?php
/**
*
* @package mxBB Portal Module - mx_contact
* @version $Id: db_install.php,v 1.9 2011/04/17 08:37:07 orynider Exp $
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

$mx_module_version = '2.9.1';
$mx_module_copy = 'MX-Publisher <i> - Contact</i> module by Florin C Bodin, <a title="author" alt="Marcus Smith" href="http://www.phobbia.net/mods/">Marcus Smith</a>';

// If fresh install

if ( !$result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "contact_config" ) )
{
	$message = "<b>This is a fresh install!</b><br/><br/>";

	//
	// Build Array of SQL Statements.
	//
	$sql = array();


	$sql[] = 'DROP TABLE IF EXISTS ' . $mx_table_prefix . 'contact_config';
	$sql[] = 'DROP TABLE IF EXISTS ' . $mx_table_prefix . 'contact_emails';
	$sql[] = 'DROP TABLE IF EXISTS ' . $mx_table_prefix . 'contact_msgs';	
	$sql[] = 'DROP TABLE IF EXISTS ' . $mx_table_prefix . 'contact_mass_news';	
	$sql[] = 'DROP TABLE IF EXISTS ' . $mx_table_prefix . 'contact';

	$sql[] = 'CREATE TABLE ' . $mx_table_prefix . 'contact (
		ip_address CHAR(8) NOT NULL DEFAULT \'\',
		send_time INTEGER(11) NOT NULL DEFAULT \'0\',
		KEY ip_address (ip_address) )';

	$sql[] = 'CREATE TABLE ' . $mx_table_prefix . 'contact_config (
		config_name VARCHAR(255) NOT NULL DEFAULT \'\',
		config_value VARCHAR(255) NOT NULL DEFAULT \'\',
		PRIMARY KEY (config_name) )';

	$sql[] = 'CREATE TABLE ' . $mx_table_prefix . 'contact_emails (
		email VARCHAR(50) NOT NULL DEFAULT\'\',
		sent INT(1) NOT NULL DEFAULT \'0\',
		lasttime INTEGER(11) NOT NULL DEFAULT \'0\',
		PRIMARY KEY (email) )';

	$sql[] = 'CREATE TABLE ' . $mx_table_prefix . 'contact_msgs (
		msg_id INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
		sendtime INT(11) NOT NULL DEFAULT \'0\',
		username VARCHAR(25) NOT NULL DEFAULT \'\',
		realname VARCHAR(30) NOT NULL DEFAULT \'\',
		institution VARCHAR(50) NOT NULL DEFAULT \'\',
		phone VARCHAR(50) NOT NULL DEFAULT \'\',
		fax VARCHAR(50) NOT NULL DEFAULT \'\',		
		email VARCHAR(50) NOT NULL DEFAULT \'\',
		ip CHAR(8) NOT NULL DEFAULT \'\',
		message TEXT NOT NULL,
		newsletter int(3) NOT NULL default \'0\',		
		upfile VARCHAR(255) NOT NULL DEFAULT \'\',
		PRIMARY KEY (msg_id) )';
		
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
		
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'newsletter_version\',\'1.0.0\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'domainkey_signature\',\'\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'smtp_port\',\'25\')';	
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_version\',\'9.0.0\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_admin_email\',\'admin@localhost.com\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_form_enable\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_require_rname\',\'0\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_require_email\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_require_comments\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_permit_attachments\',\'0\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_max_file_size\',\'128\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_file_root\',\'efiles\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_flood_limit\',\'8\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_char_limit\',\'255\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_prune\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_hash\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_auth_guest\',\'0\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_auth_user\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_auth_mod\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_auth_admin\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_captcha\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_captcha_type\',\'0\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_delete\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_storage\',\'1\')';
	$sql[] = 'INSERT INTO ' . $mx_table_prefix . 'contact_config VALUES(\'contact_thankyou\',\'1\')';

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