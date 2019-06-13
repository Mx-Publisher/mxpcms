<?php
/**
*
* @package mxBB Portal Module - mx_shotcast
* @version $Id: db_install.php,v 1.13 2013/07/02 12:56:43 orynider Exp $
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

$mx_module_version = '3.5.2';
$mx_module_copy = 'MXP-CMS <i> - SteamCaster</i> module by OryNider & <a href="http://www.mxpcms.sf.net" target="_blank">Mx Team</a>';

// If fresh install

if ( !$result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "shotcast_config" ) )
{
	$message = "<b>This is a fresh install!</b><br/><br/>";

	$sql = array();

	$sql[] = "DROP TABLE IF EXISTS " . $mx_table_prefix . "shotcast_config";

	$sql[] = "DROP TABLE IF EXISTS " . $mx_table_prefix . "shotcast_session";

	$sql[] = "CREATE TABLE ".$mx_table_prefix."shotcast_session (
		id int(11) unsigned NOT NULL auto_increment,
		user_id mediumint(8) DEFAULT '0' NOT NULL,
		username varchar(99) NOT NULL,
		time int(11) DEFAULT '0' NOT NULL,
		session_ip char(8) DEFAULT '0' NOT NULL,
		bot_id mediumint(8) DEFAULT '0' NOT NULL,
		PRIMARY KEY (id),
		KEY user_id (user_id)
		) TYPE=MyISAM";


	$sql[] = "CREATE TABLE " . $mx_table_prefix . "shotcast_config (
						config_name VARCHAR(255) NOT NULL default '',
						config_value varchar(255) NOT NULL default '',
						PRIMARY KEY  (config_name)
						) TYPE=MyISAM";

	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('shotcast_name', 'Shotcast Radio')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('shotcast_host', 'tv3.stream-music.net')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('shotcast_port', '8188')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('shotcast_pass', 'changeme')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('caster', 'shout')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('skin', 'aero')";	
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('allow_autoplay', '1')";	
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('allow_curl', '1')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('play_list', 'listen.pls')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('play_asx', 'livemp3')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('play_host', '')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('play_port', '')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('play_mount', '/livemp3')";
	
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('picture_type', 'cover')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('fallback', 'eq')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('logo', 'logo.gif')";	
	
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('user_state_button', 'd1d2d2')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('check_period', '960')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('show_listen_select', '1')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('force_online', '1')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('stream_type', 'icy')";

	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('show_status', 'true')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('currentlisteners', '1')";
	
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('allow_guests', '0')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('guestname', 'Guest')";

	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('cast_ip', '')";
	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('cast_port', '')";

	$sql[] = "INSERT INTO " . $mx_table_prefix . "shotcast_config ( config_name , config_value ) VALUES ('show_debug', 'true')";	

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
