<?php
/**
*
* @package mxBB Portal Module - mx_shotcast
* @version $Id: db_upgrade.php,v 1.12 2013/07/02 12:56:43 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] mxBB Project Team
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

$mx_module_version = '3.5.2';
$mx_module_copy = 'MXP-CMS <i> - SteamCaster</i> module by OryNider & <a href="http://www.mxpcms.sf.net" target="_blank">Mx Team</a>';

$message = "<b>Upgrading!</b><br/><br/>";

$sql = array();

//
// Precheck
//
if ($result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "shotcast_config" ))
{
	// Upgrade checks
	$upgrade_100 = 0;
	$upgrade_108 = 0;
	$upgrade_300 = 1;
	$upgrade_350 = 1;
	$upgrade_352 = 1;
	
	// validate before 1.0 Gold
	if (!$result = $db->sql_query("SELECT config_value from " . $mx_table_prefix . "shotcast_config WHERE config_name = 'force_online'"))
	{
		$upgrade_100 = 1;
	}
	
	// validate before 1.08 - user sessions from mx_radio
	if (!$result = $db->sql_query("SELECT bot_id from " . $mx_table_prefix . "shotcast_session"))
	{
		$upgrade_108 = 1;
	}
	
	// validate before 3.0 Gold - backported support for - Custom Skins
	if (!$result = $db->sql_query("SELECT config_value from " . $mx_table_prefix . "shotcast_config WHERE config_name = 'skin'"))
	{
		$upgrade_300 = 1;
	}
	
	// validate before 3.5.0 - backported support for - Caster type: shout or ice
	if (!$result = $db->sql_query("SELECT config_value from " . $mx_table_prefix . "shotcast_config WHERE config_name = 'caster'"))
	{
		$upgrade_350 = 1;
	}
	
	// validate before 3.5.2
	if (!$result = $db->sql_query("SELECT config_value from " . $mx_table_prefix . "shotcast_config WHERE config_name = 'stream_type'"))
	{
		$upgrade_352 = 1;
	}	
	
	$message = "<b>Upgrading!</b><br/><br/>";

	if ($upgrade_100 == 1)
	{
		$message .= "<b>Upgrading to v. 1.0 (Gold)...</b><br/><br/>";

		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('force_online', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('stream_type', 'mp3')";
	}
	
	if ($upgrade_108 == 1)
	{
		$message .= "<b>Upgrading to v. 1.08...</b><br/><br/>";

		$sql[] = "DROP TABLE IF EXISTS " . $mx_table_prefix . "shotcast_session";
	
		$sql[] = "CREATE TABLE " . $mx_table_prefix . "shotcast_session (
			id int(11) unsigned NOT NULL auto_increment,
			user_id mediumint(8) DEFAULT '0' NOT NULL,
			username varchar(99) NOT NULL,
			time int(11) DEFAULT '0' NOT NULL,
			session_ip char(8) DEFAULT '0' NOT NULL,
			bot_id mediumint(8) DEFAULT '0' NOT NULL,
			PRIMARY KEY (id),
			KEY user_id (user_id)
		) TYPE=MyISAM";
	}

	if ($upgrade_300 == 1)
	{
		$message .= "<b>Upgrading to v. 3.0.0...</b><br/><br/>";

		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('allow_guests', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('guestname', 'Guest')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('skin', 'aero')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('user_state_button', 'd1d2d2')";		
	}
	
	if ($upgrade_350 == 1)
	{
		$message .= "<b>Upgrading to v. 3.5.0...</b><br/><br/>";	
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('caster', 'shout')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('allow_autoplay', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('allow_curl', '1')";			
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('play_asx', 'livemp3')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('play_host', '')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('play_port', '')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('play_mount', '/livemp3')";
		
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('picture_type', 'cover')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('fallback', 'eq')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('logo', 'logo.gif')";
		
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('cast_ip', '')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('cast_port', '')";			
	}	
	
	if ($upgrade_352 == 1)
	{
		$message .= "<b>Upgrading to v. 3.5.2..</b><br/><br/>";	
		
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('stream_type', 'icy')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config VALUES ('show_debug', 'true')";
	}		
	else
	{	
		$message .= "<b>Nothing to upgrade...</b><br/><br/>";
	}

	$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
				    SET module_version  = '" . $mx_module_version . "',
				      module_copy  = '" . $mx_module_copy . "'
				    WHERE module_id = '" . $mx_module_id . "'";

	$message .= mx_do_install_upgrade($sql);
}
else
{
	// If not installed
	$message = "<b>Module is not installed...and thus cannot be upgraded ;)</b><br/><br/>";
}

echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstalling Information - module specific db tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . $message . "</span></td></tr>";
echo "</table><br />";

?>