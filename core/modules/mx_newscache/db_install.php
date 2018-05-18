<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: db_install.php,v 1.8 2008/07/05 22:22:04 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
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

$mx_module_version = '1.0.0';
$mx_module_copy = 'NewsCache designed for MX-Publisher by [FlorinCB aka orynider] <a href="http://mxpcms.sf.net" target="_blank">The MX-Publisher Development Team</a>.';

// For compatibility with core 2.7.+
define( 'MXBB_27x', file_exists( $mx_root_path . 'mx_login.php' ) );

// If fresh install
if ( !$result = $db->sql_query( "SELECT news_title from " . $mx_table_prefix . "config_news" ) )
{
	$message = "<b>This is a fresh install!</b><br/><br/>";

	$tmp = $userdata['user_id'];
	$sql = array(
		"DROP TABLE IF EXISTS " . $mx_table_prefix . "config_news ",
		
		#
		# Structure de la table `mx_config_news`
		#
		
		"CREATE TABLE " . $mx_table_prefix . "config_news (
		  news_title varchar(255) default 'Canada News',
		  news_xml_file varchar(255) default 'https://www.huffingtonpost.com/topic/canada/feed?o=xml',
		  news_folder varchar(255) default 'newscache/'
		)",
		
		#
		# Contenu de la table `mx_config_news`
		#
		
		"INSERT INTO " . $mx_table_prefix . "config_news VALUES ('Canada News','https://www.huffingtonpost.com/topic/canada/feed?o=xml','cache/')",	// NEWS
		# --------------------------------------------------------
	);

	$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
				    SET module_version  = '" . $mx_module_version . "',
				      module_copy  = '" . $mx_module_copy . "'
				    WHERE module_id = '" . $mx_module_id . "'";

	$message .= mx_do_install_upgrade( $sql );
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