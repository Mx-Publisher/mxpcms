<?php
/**
*
* @package MX-Publisher Module - mx_errordocs
* @version $Id: db_install.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
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
// Check if install is really needed...
//
$module_root_path = dirname(__FILE__) . '/';
include_once($module_root_path . 'includes/common.'.$phpEx);
if( !defined('ERRORDOCS_LOG_TABLE') )
{
	mx_message_die(GENERAL_ERROR, "Couldn't load file includes/common.$phpEx", "", __LINE__, __FILE__);
}

$mx_module_version = '2.0.3';
$mx_module_copy = 'Original MX-Publisher <i>Errordocs</i> module by <a href="http://www.phpmix.com" target="_blank">Markus</a>';

//
// SQL statements to build required module tables...
//
$sql = array(
//
// Table: ErrorDocs Log
//
"CREATE TABLE ".ERRORDOCS_LOG_TABLE." (
	id				INT(11)			DEFAULT '0'		NOT NULL,
	tstamp			INT(11)			DEFAULT '0'		NOT NULL,
	errno			SMALLINT(5)		DEFAULT '0'		NOT NULL,
	user_id			MEDIUMINT(8)	DEFAULT '0'		NOT NULL,
	user_ip			CHAR(8)			DEFAULT '',
	request_uri		VARCHAR(255)	DEFAULT '',
	http_referer	VARCHAR(255)	DEFAULT '',
	PRIMARY KEY (tstamp)
)"
);

$n = 0;
$message = "<b>This list is a result of the SQL queries needed for this Module</b><br/><br/>";

while($sql[$n])
{
	$message .= ($mods[$n-1] != $mods[$n]) ? '<p><b><font size=3>'.$mods[$n].'</font></b><br/>' : '';
	if( !$result = $db->sql_query($sql[$n]) )
	{
		$message .= '<b><font color=#FF0000>[Error or Already added]</font></b> line: '.($n+1).' , '.$sql[$n].'<br />';
	}
	else
	{
		$message .='<b><font color=#0000fF>[Added/Updated]</font></b> line: '.($n+1).' , '.$sql[$n].'<br />';
	}
	$n++;
}
$message .= '<br />If you get some Error, Already Added or Updated, relax, this is normal when updating modules';
echo '<br />&nbsp;<br />';
echo '<table  cellpadding="4" cellspacing="1" border="0" class="forumline">';
echo '<tr><th class="thHead" align="center">Module Installation Information</th></tr>';
echo '<tr><td class="row1"  align="center"><span class="gen">' . $message . '</span></td></tr>';
echo '</table>&nbsp;<br />';

?>