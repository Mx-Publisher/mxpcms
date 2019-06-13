<?php
/**
*
* @package Mx-Publisher StandAllone - radioplayer
* @version $Id: cur_song.php,v 1.3 2013/05/28 07:14:34 orynider Exp $
* @copyright (c) 2002-2006 [OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/
$module_root_path = "./../";
$phpEx = substr(strrchr(__FILE__, '.'), 1); 

define('IN_SHOTCAST', true);
define('STRIP_URL', (@ini_get('allow_url_fopen')) ? false : true); //fopen_url not allowed
$module_root_path = "./../";
$phpEx = substr(strrchr(__FILE__, '.'), 1); 

require($module_root_path ."includes/common." . $phpEx);

if(isset($_GET["skin"]))
{
	$radio_skin = $_GET["skin"];
	$module_root_bang = "./"; //Hardcoded for Security	
}
elseif(isset($_GET["style"]))
{
	$radio_skin = $_GET["style"];
	$module_root_bang = "./"; //Hardcoded for Security
}
else
{
	if(empty($radio_skin))
	{
		$radio_skin = "default";
	}
	$module_root_bang = STRIP_URL ? "./" : $module_root_path;
}
@define('SKIN', $radio_skin);

$url_picture = "nochange";
$url_info = $no_cover_url;

$currentsong = (!empty($song) ? trim($song) : trim($title)) . " - " . (!empty($artist) ? trim($artist) : trim($title));
$title = !empty($title) ? $currentsong : $no_cover_url;
die("$title"); //Remove this line if your hosting supports frames
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
print '
<HTML>
<HEAD>
  <META http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />
  <META http-equiv="pragma" content="no-cache">
  <META HTTP-EQUIV="refresh" CONTENT="159">
  <META name="robots" content="noindex">
<script>
<!--

/*
Auto Refresh Page with Time script
By JavaScript Kit (javascriptkit.com)
Over 200+ free scripts here!
*/

//enter refresh time in "minutes:seconds" Minutes should range from 0 to inifinity. Seconds should range from 0 to 59
var limit="1:59"

if (document.images){
var parselimit=limit.split(":")
parselimit=parselimit[0]*60+parselimit[1]*1
}
function beginrefresh(){
if (!document.images)
return
if (parselimit==1)
window.location.reload()
else{ 
parselimit-=1
curmin=Math.floor(parselimit/60)
cursec=parselimit%60
if (curmin!=0)
curtime=curmin+" minutes and "+cursec+" seconds left until page refresh!"
else
curtime=cursec+" seconds left until page refresh!"
window.status=curtime
setTimeout("beginrefresh()",15900)
}
}

window.onload=beginrefresh
//-->
</script>  
</HEAD>
<body>
<span style="font-weight: bold;">' . $title . '&nbsp;&nbsp;</span>
</body>
</HTML>';
?>