<?php
/**
*
* @package mxBB Portal Module - mx_contact
* @version $Id: db_uninstall.php,v 1.4 2011/04/17 08:37:07 orynider Exp $
* @copyright (c) 2003 [orynider@rdslink.ro, OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

define('IN_PORTAL', true);
if ( !defined('IN_ADMIN') )
{
  $mx_root_path = '../../';
  $phpEx = substr(strrchr(__FILE__, '.'), 1);
  include($mx_root_path . 'common.'.$phpEx);

  //
  // Start session management
  //
  $mx_user->init($user_ip, PAGE_INDEX);

  if( !$userdata['session_logged_in'] )
	{
   		die("Hacking attempt(3)");
	}

	if( $userdata['user_level'] != ADMIN )
	{
   		die("Hacking attempt(4)");
	}
  //
  // End session management
  //
}

$sql = array(
"DROP TABLE ".$mx_table_prefix."contact_config",
"DROP TABLE ".$mx_table_prefix."contact_msgs",
"DROP TABLE ".$mx_table_prefix."contact_emails",
"DROP TABLE ".$mx_table_prefix."contact_mass_news",
"DROP TABLE ".$mx_table_prefix."contact"
);



$n = 0;
$message = "<b>This list is a result of the SQL queries needed to uninstall radio Module Addon</b><br/><br/>";

while($sql[$n])
{
	$message .= ($mods[$n-1] != $mods[$n]) ? '<p><b><font size=3>'.$mods[$n].'</font></b><br/>' : '';
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