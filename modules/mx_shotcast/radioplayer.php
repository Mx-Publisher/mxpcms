<?php
/**
*
* @package StandAllone - Radiplayer.
* @version $Id: radioplayer.php,v 1.13 2013/05/29 05:00:43 orynider Exp $
* @copyright (c) 2006-2013 Little Frog, FlorinCB [aka OryNider], drknas 
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
// History:
// Little Frog (v 1.x - 2.x)
// OryNider (v 1.x - 3.x)
// DrKnas (v 4.0 - 4.2.x)
// OryNider (Current maintainer: 3.5.x & 4.9.x & mxpcms versions)
$module_root_path = "./";
$phpEx = substr(strrchr(__FILE__, '.'), 1); 
define('IN_SHOTCAST', true);
require($module_root_path ."includes/common." . $phpEx);

$html = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\">
<head>
<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />
<meta name=\"description\" content=\"Radio Player\" />
<meta name=\"keywords\" content=\"Radio Player\" />
<meta name=\"author\" content=\"Radio Player originaly made by: Niklas Pull - http://pull.zapto.org\" />";
$html .= css($module_root_path, $phpEx, $radio_skin);
$html .= java_script($module_root_path, $phpEx, $mimetype, $clean_config, $radio_skin, $autoplay, $state, $lang, $java_debug, $update_title);
$html .= "
<script type=\"text/javascript\"><!--
loadimg = new Image(27,27); 
loadimg.src = '".$module_root_path ."skins/".SKIN."/play_h.png';
loadimg2 = new Image(19,19); 
loadimg2.src = '".$module_root_path ."skins/".SKIN."/stop_h.png';
loadimg3 = new Image(18,18); 
loadimg3.src = '".$module_root_path ."skins/".SKIN."/close_h.png';
window.onunload = function()
{
	stopWinampx();
}
window.onload = function()
{
	embedInfo(detectEmbed());	
	";
	if(basename($_SERVER['PHP_SELF']) !== "play.php")
	{
		$html .= "
	updateInfo();
	//checkSong();
	//checkCover();	
	//checkcover_url();	
	";
		if($autoplay)
		{
			//if($state == "Up")
			//{
				$html .= "
	playR();";
			//}
		}
	}
	$html .= "
}	
//--></script>";
$html .= "
<title>" . $title_tag . "</title>
</head>
<body>
<!-- // Create ActiveX objects for later checks for WMP versions. -->
<OBJECT CLASSID=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\"  HEIGHT=\"0\" ID=\"WMP64\" WIDTH=\"0\" STYLE=\"visibility: hidden;\"></OBJECT>
<OBJECT CLASSID=\"CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6\"  HEIGHT=\"0\" ID=\"WMP7\" WIDTH=\"0\" STYLE=\"visibility: hidden;\"></OBJECT>
<div id=\"shell\">
<div style=\"font-weight: bold; font-size: 12px; font-family: Calibri, Helvetica, sans-serif;\" id=\"station\">" . $title_bar . "</div>
<span style=\"font-weight : bold;\">";
if($state == "Down")
{
	$html .= "<div id=\"display\">" . $lang['Off_Air'] . "</div>";
} 
else
{
	$html .= "<div class=\"dmarquee\" style=\"font-weight: bold; font-size: 12px; font-family: Calibri, Helvetica, sans-serif;\"><div><div>" . $lang['stop'] . "</div></div></div>";
}

$html .= "
</span>

<div id=\"iframe \" class=\"controls\">
<IFRAME src=\"".$module_root_path."includes/cur_song.".$phpEx.(isset($_GET['embed']) ? $_GET['embed'] : '')."#\" name=\"embedFrame\" ID=\"embedFrame\" width=\"100\" height=\"0\" scrolling=\"no\" style=\"width:100%;height:0px;border:0px dotted #BEBEBE;\">Sorry, your browser doesn't seem to support IFrames!</iframe>
</div>

<div id=\"firstinfo\"></div> 
<div id=\"secondinfo\"></div>
<div id=\"thirdinfo\"></div>
<div id=\"forthinfo\"></div>

<div id=\"infoPlayer\"></div>
<div id=\"infoPlugin\"></div>

<div id=\"equalizer\"><a id=\"cover_url\" target=\"_blank\" href=\"" . $no_cover_url . "\"><img id=\"eq\" src=\"" . $module_root_path . "skins/" . SKIN . "/equalizer_stop.gif\" /></a></div>
<div id=\"closeButton\"><img id=\"closeB\" src=\"" . $module_root_path . "skins/" . SKIN . "/close.png\" onclick=\"javascript:window.close()\"   
	onmouseover=\"javascript:document.getElementById('closeB').src = '" . $module_root_path . "skins/" . SKIN . "/close_h.png';\"  
	onmouseout=\"javascript:document.getElementById('closeB').src = '" . $module_root_path . "skins/" . SKIN . "/close.png';\" />
</div>

<div id=\"play\"><img id=\"playB\" src=\"" . $module_root_path . "skins/" . SKIN . "/play.png\" onclick=\"javascript:playR()\"    
	onmouseover=\"javascript:document.getElementById('playB').src = '" . $module_root_path . "skins/" . SKIN . "/play_h.png';\" 
	onmouseout=\"javascript:document.getElementById('playB').src = '" . $module_root_path . "skins/" . SKIN . "/play.png';\" /> 
</div>
<div id=\"stop\"><img id=\"stopB\" src=\"" . $module_root_path . "skins/" . SKIN . "/stop.png\" onclick=\"javascript:stopR()\"  
	onmouseover=\"document.getElementById('stopB').src = '" . $module_root_path . "skins/" . SKIN . "/stop_h.png';\"    
	onmouseout=\"document.getElementById('stopB').src = '" . $module_root_path . "skins/" . SKIN . "/stop.png';\" />
</div>

<div id=\"select\">
" . $lang['media_player'] . "
<select id=\"embedchoise\" onchange=\"javascript:changeEmbed()\">
 <option value=\"auto\">" . $lang['auto_detect'] . "</option>
 <option value=\"wmp\">WMP</option>";

	if ($mimetype !== 'audio/aacp')
	{
		$html .= "<option value=\"real\">RealPlayer</option>";
		$html .= "<option value=\"quicktime\">QuickTime</option>";
	}
	$html .= "
<script type=\"text/javascript\"><!--//
if(AXcompatible())
{
	document.write('<option value=\"winampX\">WinampX</option>');
} 
// --></script>
</select>
</div>
<br />

</div>

</div>
</body>
</html>";

print $html;

?>