<?php
/**
*
* @package mxBB Portal Module - mx_shotcast
* @version $Id: radio_update.php,v 1.6 2008/04/29 02:39:48 orynider Exp $
* @copyright (c) 2002-2006 [OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

/***************************************************************************
 * mx_shotcast
 ***************************************************************************
 * History:
 *OryNider (16/09/2006) : 1st try
 ***************************************************************************/

// error_reporting( E_ALL );
// ini_set( 'display_errors', '1' );

if( !defined('IN_PORTAL') || !is_object($mx_block))
{

	define('IN_PORTAL', true);

	$mx_root_path = "../../";
	$module_root_path = "./";

	$phpEx = substr(strrchr(__FILE__, '.'), 1); 
	include_once($mx_root_path . 'common.'.$phpEx);

	//
	// Start session management
	//
	$mx_user->init($user_ip, PAGE_INDEX);
	//
	// End session management
	//

	$title = 'Media Player Radio';
	$block_size = ( isset($block_size) && !empty($block_size) ? $block_size : '315' );
	$is_block = FALSE;
}
else
{
	//
	// Read block Configuration
	//

	$title = $mx_block->block_info['block_title'];
	$block_size = ( isset($block_size) && !empty($block_size) ? $block_size : '100%' );

	if( is_object($mx_block))
	{
		$is_block = TRUE;
	}
}

define('IN_SHOTCAST', true);
require($module_root_path .'includes/common.'.$phpEx);


if (isset($_POST['update']))
{
	update_shotcast_users($nick);
}
else
{
	update_shotcast_users($nick);
}

$currentlisteners = $currentlisteners;

function update_total_users($currentlisteners)
{
	global $shotcast_config, $board_config, $db, $lang;


	$sql = "UPDATE ". SHOTCAST_CONFIG_TABLE ." SET `config_name` = 'currentlisteners' WHERE `config_value` = '". $currentlisteners ."'";

	if( !$result = $db->sql_query($sql) )
	{
		die("SQL Error in function update_total_users(): UPDATE<br />" . $sql);
	}
}

if( !empty($currentlisteners))
{
	update_total_users($currentlisteners);
}

//radio_update.php (send to the db the user statue "listening" every $period seconds)
echo "<html>";
echo "<head>";
echo "<script language=\"javascript\">";
echo "setInterval(\"document.forms['update'].submit();\",".$period.");";
echo "</script>";
echo "<script>\n";
echo "<!--\n";
echo "\n";
echo "//enter refresh time in \"minutes:seconds\" Minutes should range from 0 to inifinity. Seconds should range from 0 to 59\n";
echo "var limit=\"0:30\"\n";
echo "\n";
echo "if (document.images){\n";
echo "var parselimit=limit.split(\":\")\n";
echo "parselimit=parselimit[0]*60+parselimit[1]*1\n";
echo "}\n";
echo "function beginrefresh(){\n";
echo "if (!document.images)\n";
echo "return\n";
echo "if (parselimit==1)\n";
echo "window.location.reload()\n";
echo "else{\n";
echo "parselimit-=1\n";
echo "curmin=Math.floor(parselimit/60)\n";
echo "cursec=parselimit%60\n";
echo "if (curmin!=0)\n";
echo "curtime=curmin+\" minutes and \"+cursec+\" seconds left until page refresh!\"\n";
echo "else\n";
echo "curtime=cursec+\" seconds left until page refresh!\"\n";
echo "window.status=curtime\n";
echo "setTimeout(\"beginrefresh()\",1000)\n";
echo "}\n";
echo "}\n";
echo "\n";
echo "window.onload=beginrefresh\n";
echo "//-->\n";
echo "</script>\n";
echo "</head>";
echo "<body background=\"images/iframe_bg.png\">";
echo "<form name=\"update\" action=\"radio_update.php\" method=\"POST\">";
echo "<input type=\"hidden\" name=\"update\" value=\"true\">";
echo "</form>";
echo " Loged in as: $nick\n";
echo "</body>";
echo "</html>";
?>