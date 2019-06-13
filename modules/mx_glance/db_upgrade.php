<?php
/**
*
* @package MX-Publisher Module - mx_glance
* @version $Id: db_upgrade.php,v 1.8 2008/06/22 14:21:29 orynider Exp $
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

$mx_module_version = '2.8.2';
$mx_module_copy = 'MX-Publisher <i> - At A Glace</i> module by blulegend, Jack Kan & <a href="http://www.mx-publisher.com" target="_blank">Mx Team</a>';

$message = "<b>Upgrading!</b><br/><br/>";

$sql = array();

$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
			SET module_version  = '" . $mx_module_version . "',
			module_copy  = '" . $mx_module_copy . "'
			WHERE module_id = '" . $mx_module_id . "'";

$message .= mx_do_install_upgrade( $sql );

echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstalling Information - module specific db tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . $message . "</span></td></tr>";
echo "</table><br />";

?>
