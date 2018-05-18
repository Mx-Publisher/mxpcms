<?php
/**
*
* @package MX-Publisher Module - mx_errordocs
* @version $Id: db_uninstall.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] MX-Publisher Project Team
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

//
// Read module constants...
//
$module_root_path = dirname(__FILE__) . '/';
include_once($module_root_path . 'includes/common.'.$phpEx);
if( !defined('ERRORDOCS_LOG_TABLE') )
{
	mx_message_die(GENERAL_ERROR, "Couldn't load file includes/common.$phpEx", "", __LINE__, __FILE__);
}


//
// SQL statements to drop module tables...
//
$sql = array(
"DROP TABLE ".ERRORDOCS_LOG_TABLE
);


echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstalling Information - module specific db tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . mx_do_install_upgrade( $sql ) . "</span></td></tr>";
echo "</table><br />";

?>