<?php
/**
*
* @package MX-Publisher Module - mx_translator
* @version $Id: db_install.php,v 1.1 2013/02/04 06:48:36 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
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

// If fresh install
if (!$result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "translator_config") )
{
	$message = "<b>This is a fresh install!</b><br/><br/>";

	$sql = array(
		"DROP TABLE IF EXISTS " . $mx_table_prefix . "translator_config ",

		// --------------------------------------------------------
		/* Table structure for table `phpbb_pa_config`*/
		"CREATE TABLE " . $mx_table_prefix . "translator_config (
			  config_name varchar(255) NOT NULL default '',
			  config_value varchar(255) NOT NULL default '',
			  PRIMARY KEY  (config_name)
		)",
		
		/* */
		/* Config values
		/* */

		/* General */
		"INSERT INTO " . $mx_table_prefix . "translator_config VALUES ('enable_module', '1')", // settings_disable
		"INSERT INTO " . $mx_table_prefix . "translator_config VALUES ('module_name', 'Download Database')", // settings_dbname
		"INSERT INTO " . $mx_table_prefix . "translator_config VALUES ('translator_default_lang', 'en')", // settings_disable
		"INSERT INTO " . $mx_table_prefix . "translator_config VALUES ('translator_choice_lang', 'fr,es,ro,it')", // settings_dbname
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