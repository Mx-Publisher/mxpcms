<?php
/**
*
* @package MX-Publisher Module - mx_translator
* @version $Id: db_uninstall.php,v 1.6 2018/12/12 20:07:27 orynider Exp $
* @copyright (c) 2002-2006 [FlorinCB] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sf.net/
*
*/


//
// Security Check...
//
if( !defined('IN_PORTAL') )
{
	die("Hacking attempt(1)");
}
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

//
// SQL statements to drop module tables...
//
$sql = array("DROP TABLE `" . $mx_table_prefix . "translator_config`");

$n = 0;
$message = "<b>This list is a result of the SQL queries needed to uninstall Translator Module Addon</b><br/><br/>";

while($sql[$n])
{
	$message .= ($mods[$n - 1] != $mods[$n]) ? '<p><b><font size=3>'.$mods[$n].'</font></b><br/>' : '';
	if( !$result = $db->sql_query($sql[$n]) )
	{
		$message .= '<b><font color=#FF0000>[Error or Already removed]</font></b> line: '.($n+1).' , '.$sql[$n].'<br />';
	}
	else
	{
		$message .='<b><font color=#0000fF>[Removed]</font></b> line: '.($n+1).' , '.$sql[$n].'<br />';
	}
	$n++;
}
$message .= '&nbsp;<br />If you get some Error, relax, this is normal when updating modules';
echo '<br />&nbsp;<br />';
echo '<table  cellpadding="4" cellspacing="1" border="0" class="forumline">';
echo '<tr><th class="thHead" align="center">Module Installation Information</th></tr>';
echo '<tr><td class="row1"  align="center"><span class="gen">' . $message . '</span></td></tr>';
echo '</table>&nbsp;<br />';

?>