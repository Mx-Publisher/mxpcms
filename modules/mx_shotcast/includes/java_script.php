<?php
/**
*
* @package StandAllone - Radiplayer.
* @version $Id: java_script.php,v 1.2 2013/05/29 05:00:43 orynider Exp $
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
// DrKnas (Current maintainer v 4.0 -)
if( !defined('IN_SHOTCAST'))
{
	die("Hacking attempt");
}
function java_script($module_root_path, $phpEx, $mimetype, $clean_config, $radio_skin, $autoplay, $state, $lang, $java_debug, $update_title)
{
	static $allow_url_config, $allow_url_info, $allow_url_picture;
	global $skininfo;
	if(@ini_get('allow_url_fopen'))
	{
		$allow_url_config = "?config=".$clean_config;
		$allow_url_info = "?config=" . $clean_config . "&mode=url_info";
		$allow_url_picture = "?config=".$clean_config."&mode=url_picture&style=".$radio_skin;
	}
	//some overwrite
	$java_script = "
<SCRIPT TYPE=\"text/javascript\">
<!--//
onerror=handleErr;
";
if($java_debug == "yes")
{
	$java_script .= "
var txt=\"\";
function handleErr(msg, url, l)
{
	txt=\"There was an error on this page.\\n\\n\";
	txt+=\"Error: \" + msg + \"\\n\";
	txt+=\"URL: \" + url + \"\\n\";
	txt+=\"Line: \" + l + \"\\n\\n\";
	txt+=\"Click OK to continue.\\n\\n\";
	alert(txt);
	return true;
}
";
}
else
{
$java_script .= "
function handleErr()
{
	clearTimeout(to);
	setTimeout(\"updateInfo()\", 15900);
}
";
}
$java_script .= "
var detectableWithVB = false;
var pluginFound = false;
var cType = '" . $mimetype . "';

var gecko = !(navigator.appName == 'Internet Explorer');
if (!gecko)
{
	if(document.getElementById(\"IWinAmpActiveX\") != null)
	{
		var winampx = document.getElementById(\"IWinAmpActiveX\");
	}
}
else
{
	if (document.getElementById(\"IWinAmpActiveXG\") != null)
	{
		var winampx = document.getElementById(\"IWinAmpActiveXG\");
	}
}

";
	if(basename($_SERVER['PHP_SELF']) !== "play.php")
	{
		$java_script .= "
var oMarquees = [], oMrunning,
	oMInterv =        20,     //interval between increments
	oMStep =          1,      //number of pixels to move between increments
	oStopMAfter =     0,     //how many seconds should marquees run (0 for no limit)
	oResetMWhenStop = false,  //set to true to allow linewrapping when stopping
	oMDirection =     'left'; //'left' for LTR text, 'right' for RTL text

/***     Do not edit anything after here     ***/

function doMStop() 
{
	clearInterval(oMrunning);
	for( var i = 0; i < oMarquees.length; i++ ) 
	{
		oDiv = oMarquees[i];
		oDiv.mchild.style[oMDirection] = '0px';
		if( oResetMWhenStop ) {
			oDiv.mchild.style.cssText = oDiv.mchild.style.cssText.replace(/;white-space:nowrap;/g,'');
			oDiv.mchild.style.whiteSpace = '';
			oDiv.style.height = '';
			oDiv.style.overflow = '';
			oDiv.style.position = '';
			oDiv.mchild.style.position = '';
			oDiv.mchild.style.top = '';
		}
	}
	oMarquees = [];
}
function doDMarquee() 
{
	if( oMarquees.length || !document.getElementsByTagName ) { return; }
	var oDivs = document.getElementsByTagName('div');
	for( var i = 0, oDiv; i < oDivs.length; i++ ) {
		oDiv = oDivs[i];
		if( oDiv.className && oDiv.className.match(/\bdmarquee\b/) ) {
			if( !( oDiv = oDiv.getElementsByTagName('div')[0] ) ) { continue; }
			if( !( oDiv.mchild = oDiv.getElementsByTagName('div')[0] ) ) { continue; }
			oDiv.mchild.style.cssText += ';".$skininfo['display_style']."';		
			oDiv.mchild.style.whiteSpace = 'nowrap';
			oDiv.style.height = oDiv.offsetHeight + 'px';
			oDiv.style.overflow = 'hidden';
			oDiv.style.position = 'relative';
			oDiv.style.width = '".$skininfo['display_width']."' + 'px';
			oDiv.style.height = '".$skininfo['display_height']."' + 'px';
			oDiv.style.left = '".$skininfo['display_left']."' + 'px';
			oDiv.style.right = '".$skininfo['display_right']."' + 'px';
			oDiv.style.top = '".$skininfo['display_top']."' + 'px';
			oDiv.style.fontWeight = 'bold';
			oDiv.style.fontSize = '".$skininfo['display_fontSize']."' + 'px';
			oDiv.style.fontFamily = '".$skininfo['display_font'].",Calibri,Trebuchet MS,Lucida Grande,Helvetica,Verdana,sans-serif';			
			oDiv.mchild.style.position = 'absolute';
			oDiv.mchild.style.top = '0px';
			oDiv.mchild.style[oMDirection] = oDiv.offsetWidth + 'px';
			oMarquees[oMarquees.length] = oDiv;
			i += 2;
		}
	}
	oMrunning = setInterval('aniMarquee()',oMInterv);
	if( oStopMAfter ) { setTimeout('doMStop()',oStopMAfter*1000); }
}
function aniMarquee() 
{
	var oDiv, oPos;
	for( var i = 0; i < oMarquees.length; i++ ) {
		oDiv = oMarquees[i].mchild;
		oPos = parseInt(oDiv.style[oMDirection]);
		if( oPos <= -1 * oDiv.offsetWidth ) {
			oDiv.style[oMDirection] = oMarquees[i].offsetWidth + 'px';
		} else {
			oDiv.style[oMDirection] = ( oPos - oMStep ) + 'px';
		}
	}
}
if( window.addEventListener ) 
{
	window.addEventListener('load',doDMarquee,false);
} 
else if( document.addEventListener ) 
{
	document.addEventListener('load',doDMarquee,false);
} 
else if( window.attachEvent ) 
{
	window.attachEvent('onload',doDMarquee);
}

function playR()
{
	var oDivs = document.getElementsByTagName('div');
	for( var i = 0, oDiv; i < oDivs.length; i++ )
	{
		oDiv = oDivs[i];
		if( oDiv.className && oDiv.className.match(/\bdmarquee\b/) )
		{
			if( !( oDiv = oDiv.getElementsByTagName('div')[0] ) ) { continue; }
			if( !( oDiv.mchild = oDiv.getElementsByTagName('div')[0] ) ) { continue; }
		    oDiv.getElementsByTagName('div')[0].innerHTML = '" . $lang['checking_title'] . "';
			i += 2;
		}
	}
	intervalID = window.top.setInterval( 'updateInfo()', " . $update_title . " );
	doDMarquee();
	document.getElementById('eq').src = '" . $module_root_path . "skins/" . SKIN . "/equalizer_play.gif';
	var embed = document.getElementById('embedchoise');
	var frame = document.getElementById('embedFrame');
	if(embed.value != \"auto\" && embed.value != \"wmp\"){
		frame.src = \"" . $module_root_path . "play." . $phpEx . "?config=" . $clean_config . "&embed=\" + embed.value;
		embedInfo(embed.value);
	} else if(embed.value == \"wmp\"){
		frame.src = \"play." . $phpEx . "?config=" . $clean_config . "&embed=\" + detectWMPEmbed(embed.value);
		embedInfo(detectWMPEmbed(embed.value));
		embedFramereload();
	} else{
		frame.src = \"" . $module_root_path . "play." . $phpEx . "?config=" . $clean_config . (isset($_GET['embed']) ? $_GET['embed'] : '') . "\";
		embedInfo(detectEmbed());
	}
}

function stopR(){
	document.getElementById('eq').src = '" . $module_root_path . "skins/" . SKIN . "/equalizer_stop.gif';
	document.getElementById('embedFrame').src = \"\";
	window.top.clearInterval(intervalID); 
	doMStop();
	var oDivs = document.getElementsByTagName('div');
	for( var i = 0, oDiv; i < oDivs.length; i++ )
	{
		oDiv = oDivs[i];
		if( oDiv.className && oDiv.className.match(/\bdmarquee\b/) )
		{
			if( !( oDiv = oDiv.getElementsByTagName('div')[0] ) ) { continue; }
			if( !( oDiv.mchild = oDiv.getElementsByTagName('div')[0] ) ) { continue; }
		    oDiv.getElementsByTagName('div')[0].innerHTML = '" . $lang['stop'] . "';
			i += 2;
		}
	}
	document.getElementById('firstinfo').innerHTML = \"\";
	document.getElementById('secondinfo').innerHTML = \"\";
	document.getElementById('thirdinfo').innerHTML = \"\";
	document.getElementById('forthinfo').innerHTML = \"\";
}
";
	}
	$java_script .= "

function embedInfo(embed)
{
	var player = '';
	var plugin = '';
	if(embed == 'real')
	{
		player = '<b>Real player<\/b>';
		if(!detectReal())
		{
			plugin = '<a href=\"http://www.real.com/realplayer.html\">&#187; " . $lang['download'] . " Realplayer<\/a>';
		} 
		else
		{
			plugin = '&#187; " . $lang['no_plugins_seems_to_be_needed'] . "';
		}
				
	} 
	else if(embed == 'wmp6')
	{
		player = '<b>Windows Media<\/b>';
		if(!detectWindowsMedia()){
			plugin = '<a href=\"http://www.microsoft.com/windows/windowsmedia/\">&#187; " . $lang['download'] . " WMP<\/a>';
			if(AXcompatible()){
				plugin += '<br><a href=\"http://activex.microsoft.com/activex/controls/mplayer/sv/nsmp2inf.cab#Version=6,4,5,715\">&#187;" . $lang['download'] . " WMP ". $lang['Plugin'] . "<\/a>';
			}
		} else{
			plugin = '&#187; " . $lang['no_plugins_seems_to_be_needed'] . "';
		}
		
	} 
	else if(embed == 'wmp7')
	{
		player = '<b>Windows Media<\/b>';
		if(!detectWindowsMedia())
		{
			plugin = '<a href=\"http://www.microsoft.com/windows/windowsmedia/\">&#187; " . $lang['download'] . " WMP<\/a>';
		} 
		else
		{
			plugin = '&#187; " . $lang['no_plugins_seems_to_be_needed'] . "';
		}
		
	} 
	else if(embed == 'wmpo')
	{
		player = '<b>Windows Media<\/b>';
		if(!detectWindowsMedia())
		{
			plugin = '<a href=\"http://www.microsoft.com/windows/windowsmedia/\">&#187; " . $lang['download'] . " WMP<\/a>';
		} 
		else
		{
			plugin = '&#187; " . $lang['no_plugins_seems_to_be_needed'] . "';
		}
	} 
	else if(embed == 'quicktime')
	{
		player = '<b>QuickTime<\/b>';
		if(!detectQuickTime())
		{
			plugin = '<a href=\"http://www.apple.com/quicktime/download/\">&#187; " . $lang['download'] . " QT<\/a>';
			if(AXcompatible())
			{
				plugin += '<br><a href=\"http://www.apple.com/qtactivex/qtplugin.cab\">&#187; " . $lang['download'] . " QT " . $lang['Plugin'] . "<\/a>';
			}
		} 
		else
		{
			plugin = '&#187; " . $lang['no_plugins_seems_to_be_needed'] . "';
		}
	} 
	else if(embed == 'aac_wmp')
	{
		player = '<b>Windows Media<\/b>';
		plugin = '';
		if(!detectWindowsMedia())
		{
			plugin += '<a href=\"http://www.microsoft.com/windows/windowsmedia/\">&#187; " . $lang['download'] . " WMP<\/a><br>';
		}
		plugin += '<a href=\"http://retro-radio.net/plugin/setup_AAC_aacPlus_plugin_1_0_36.exe\">&#187; AAC plugin f. WMP<\/a>';
		
	} 
	else if(embed == 'winampX')
	{
		player = 'Winamp ActiveX';
		if(AXcompatible())
		{
			plugin = '<a href=\"".ADDON_URL."addonsx/ampx_en_dl.cab\">&#187; " . $lang['download'] . " WinampX<\/a>';
		}
	}";

	if(basename($_SERVER['PHP_SELF']) !== "play.php")
	{
		$java_script .= "
	document.getElementById('infoPlayer').innerHTML = player;
	document.getElementById('infoPlugin').innerHTML = plugin;
	";
	}
	$java_script .= "
}

function changeEmbed()
{
	var embed = document.getElementById('embedchoise');
	if(embed.value && embed.value != \"auto\" && embed.value != \"wmp\")
	{
		embedInfo(embed.value);
	} 
	else if(embed.value == \"wmp\")
	{
		embedInfo(detectWMPEmbed(embed.value));
	} 
	else
	{
		embedInfo(detectEmbed());
	}
}

function stopWinampx()
{
	if((document.getElementById(\"IWinAmpActiveXG\") != null) || (document.getElementById(\"IWinAmpActiveX\") != null))
	{
		winampx.Deinitialize(); 
	}
}

function stopWMP()
{
	if((document.getElementById(\"IWinAmpActiveXG\") != null) || (document.getElementById(\"IWinAmpActiveX\") != null))
	{
		winampx.Deinitialize(); 
	}
}

function AXcompatible()
{
	if (window.ActiveXObject) 
	{
	  // ActiveXObject is supported
	  return true;
	} 
	else if (window.GeckoActiveXObject) 
	{
	  // GeckoActiveXObject is supported
	  return true;
	} 
	else if (document.all) 
	{
	  // use ActiveXObject or write IE only OBJECT markup
	  return true;	  
	} 
	// use Netscape Plugins
	return false;
}

function canDetectPlugins() {
    if( detectableWithVB || (navigator.plugins && navigator.plugins.length > 0) ) {
		return true;
    } else {
		return false;
    }
}

function detectQuickTime() {
    pluginFound = detectPlugin('QuickTime');
    // if not found, try to detect with VisualBasic
    if(!pluginFound && detectableWithVB) {
		pluginFound = detectQuickTimeActiveXControl();
    }
    return pluginFound;
}

function detectReal() {
    pluginFound = detectPlugin('RealPlayer');
    // if not found, try to detect with VisualBasic
    if(!pluginFound && detectableWithVB) {
		pluginFound = (detectActiveXControl('rmocx.RealPlayer G2 Control') ||
			detectActiveXControl('RealPlayer.RealPlayer(tm) ActiveX Control (32-bit)') ||
			detectActiveXControl('RealVideo.RealVideo(tm) ActiveX Control (32-bit)'));
    }	
    return pluginFound;
}

function detectWindowsMedia() {
    pluginFound = detectPlugin('Windows Media Player');
    // if not found, try to detect with VisualBasic
    if(!pluginFound && detectableWithVB) {
	pluginFound = detectActiveXControl('MediaPlayer.MediaPlayer.1');
    }
    return pluginFound;
}

function detectPlugin()
{
    // allow for multiple checks in a single pass
    var daPlugins = detectPlugin.arguments;
    // consider pluginFound to be false until proven true
    var pluginFound = false;
    // if plugins array is there and not fake
    if (navigator.plugins && navigator.plugins.length > 0)
	{
		var pluginsArrayLength = navigator.plugins.length;
		// for each plugin...
		for (pluginsArrayCounter=0; pluginsArrayCounter < pluginsArrayLength; pluginsArrayCounter++ )
		{
			// loop through all desired names and check each against the current plugin name
			var numFound = 0;
			for(namesCounter=0; namesCounter < daPlugins.length; namesCounter++)
			{
				// if desired plugin name is found in either plugin name or description
				if( (navigator.plugins[pluginsArrayCounter].name.indexOf(daPlugins[namesCounter]) >= 0) || (navigator.plugins[pluginsArrayCounter].description.indexOf(daPlugins[namesCounter]) >= 0) )
				{
					// this name was found
					numFound++;
				}   
			}
		    // now that we have checked all the required names against this one plugin,
		    // if the number we found matches the total number provided then we were successful
			if(numFound == daPlugins.length)
			{
				pluginFound = true;
				// if we've found the plugin, we can stop looking through at the rest of the plugins
				break;
		    }
		}
    }
    return pluginFound;
} // detectPlugin

// Here we write out the VBScript block for MSIE Windows
if ((navigator.userAgent.indexOf('MSIE') != -1) && (navigator.userAgent.indexOf('Win') != -1)) {

    document.writeln('<script language=\"VBscript\">');
    document.writeln('\'do a one-time test for a version of VBScript that can handle this code');
    document.writeln('detectableWithVB = False');
    document.writeln('If ScriptEngineMajorVersion >= 2 then');
    document.writeln('  detectableWithVB = True');
    document.writeln('End If');
    document.writeln('\'this next function will detect most plugins');
    document.writeln('Function detectActiveXControl(activeXControlName)');
    document.writeln('  on error resume next');
    document.writeln('  detectActiveXControl = False');
    document.writeln('  If detectableWithVB Then');
    document.writeln('     detectActiveXControl = IsObject(CreateObject(activeXControlName))');
    document.writeln('  End If');
    document.writeln('End Function');
    document.writeln('\'and the following function handles QuickTime');
    document.writeln('Function detectQuickTimeActiveXControl()');
    document.writeln('  on error resume next');
    document.writeln('  detectQuickTimeActiveXControl = False');
    document.writeln('  If detectableWithVB Then');
    document.writeln('    detectQuickTimeActiveXControl = False');
    document.writeln('    hasQuickTimeChecker = false');
    document.writeln('    Set hasQuickTimeChecker = CreateObject(\"QuickTimeCheckObject.QuickTimeCheck.1\")');
    document.writeln('    If IsObject(hasQuickTimeChecker) Then');
    document.writeln('      If hasQuickTimeChecker.IsQuickTimeAvailable(0) Then ');
    document.writeln('        detectQuickTimeActiveXControl = True');
    document.writeln('      End If');
    document.writeln('    End If');
    document.writeln('  End If');
    document.writeln('End Function');
    document.writeln('<\/scr' + 'ipt>');
	
}

function detectOS(){

	var OS = \"unknown\";
	if (navigator.appVersion.indexOf(\"Win\")!=-1) OS = \"win\";
	if (navigator.appVersion.indexOf(\"Mac\")!=-1) OS = \"mac\";
	if (navigator.appVersion.indexOf(\"X11\")!=-1) OS = \"unix\";
	if (navigator.appVersion.indexOf(\"Linux\")!=-1) OS = \"linux\";
	return OS;
	
}

function detectWMPEmbed(){
	var cType = '" . $mimetype . "';
	if(cType == \"audio/aacp\"){
		return 'aac_wmp';
	}
	if(canDetectPlugins() && detectWindowsMedia() && AXcompatible()){
		fHasWMP = false;
		WMPVer = \"unknown\";
		try{
			if (document.WMP64.FileName == \"\"){
				WMPVer = \"6.4\";
			}
			fHasWMP = true;
		} catch(e){};
		try{
			if(document.WMP7.URL == \"\"){
				WMPVer = document.WMP7.versionInfo;
			}
			fHasWMP = true;
		} catch(e){};
		if(fHasWMP == true && WMPVer != 'unknown'){
			WMPVer = parseFloat(WMPVer);
			if(WMPVer == 6.4){
				return 'wmp6';
			}
		}
	}
	return 'wmp7';
	
}

function detectEmbed() {
	var cType = '" . $mimetype . "';
	if(cType == \"audio/aacp\")
	{
		if(AXcompatible())
		{
			return 'winampX';
		}
		return detectWMPEmbed();
	}
	if(canDetectPlugins())
	{
		if(cType == \"audio/mpeg\"){
			return detectWMPEmbed();
		}	
		if(detectReal())
		{
			return 'real';
		} 
		else if(detectWindowsMedia())
		{
			return detectWMPEmbed();
		} 
		else if(detectQuickTime())
		{
			return 'quicktime';
		}
	}
	if(AXcompatible()){
		return 'winampX';
	}
	var OS = detectOS();
	if(OS == \"mac\"){
		return 'quicktime';
	} else if(OS == \"unix\" || OS == \"linux\"){
		return 'real';
	}		
	return detectWMPEmbed();	
	
}";
	if(basename($_SERVER['PHP_SELF']) !== "play.php")
	{
		$java_script .= "
		
		var old_title = '73746172745f66617274';
	";
	}
		$java_script .= "

function makeHttpRequest(url, callback_function, return_xml)
{
	//Create a boolean variable to check for a valid Internet Explorer instance.
	var xmlHttp = false;
	
	//Check if we are using IE.
	try 
	{
		//If the JavaScript version is greater than 5.
		xmlHttp = new ActiveXObject(\"Msxml2.XMLHTTP\");
	} 
	catch(e) 
	{
		//If not, then use the older ActiveX object.
		try 
		{
			//If we are using Internet Explorer.
			xmlHttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
		} 
		catch(E) 
		{
			//Else we must be using a non-IE browser.
			xmlHttp = false;
		}
	}
		
	// If we are not using IE, create a JavaScript instance of the object.
	if (!xmlHttp && typeof XMLHttpRequest != 'undefined') 
	{
		xmlHttp = new XMLHttpRequest();
	}
   if (!xmlHttp) {
       alert('Browser doesn\'t support Ajax');
       return false;
   }
   xmlHttp.onreadystatechange = function() {
       if (xmlHttp.readyState == 4) {
           if (xmlHttp.status == 200) {
               if (return_xml) {
                   eval(callback_function + '(xmlHttp.responseXML)');
               } else {
                   eval(callback_function + '(xmlHttp.responseText)');
               }
           } else {
			   setTimeout(\"updateInfo()\",15900);
           }
       }
   }
   xmlHttp.open('GET', url, true);
   xmlHttp.send(null);
}

function loadXML(xml)
{
	var html_title = xml.getElementsByTagName('content').item(0).firstChild.nodeValue;
	var html_firstinfo = xml.getElementsByTagName('firstinfo').item(0).firstChild.nodeValue;
	var html_secondinfo = xml.getElementsByTagName('secondinfo').item(0).firstChild.nodeValue;
	var html_thirdinfo = xml.getElementsByTagName('thirdinfo').item(0).firstChild.nodeValue;
	var html_forthinfo = xml.getElementsByTagName('forthinfo').item(0).firstChild.nodeValue;
	var reload_after = xml.getElementsByTagName('reload').item(0).firstChild.nodeValue;
	var url_picture = xml.getElementsByTagName('url_picture').item(0).firstChild.nodeValue;
	var url_info = xml.getElementsByTagName('url_info').item(0).firstChild.nodeValue;
	old_title = xml.getElementsByTagName('old_title').item(0).firstChild.nodeValue;	
	if(url_picture != 'nochange')
	{
		document.getElementById('eq').src = url_picture;
		document.getElementById('cover_url').href = url_info;
		document.getElementById('cover_url').target = \"_blank\";
	}
	document.getElementById('firstinfo').innerHTML = html_firstinfo;
	document.getElementById('secondinfo').innerHTML = html_secondinfo;
	document.getElementById('thirdinfo').innerHTML = html_thirdinfo;
	document.getElementById('forthinfo').innerHTML = html_forthinfo;
	var oDivs = document.getElementsByTagName('div');
	for(var i = 0, oDiv; i < oDivs.length; i++)
	{
		oDiv = oDivs[i];
		if(oDiv.className && oDiv.className.match(/\bdmarquee\b/))
		{
			if(!(oDiv = oDiv.getElementsByTagName('div')[0])) { continue; }
			if(!(oDiv.mchild = oDiv.getElementsByTagName('div')[0])) { continue; }
		    oDiv.getElementsByTagName('div')[0].innerHTML = html_title;
			i += 2;
		}
	}
	//to = 
	setTimeout(\"updateInfo()\", parseInt(reload_after));
}

function checkSong()
{
	//Create a boolean variable to check for a valid Internet Explorer instance.
	var xmlHttp = false;
	
	//Check if we are using IE.
	try 
	{
		//If the JavaScript version is greater than 5.
		xmlHttp = new ActiveXObject(\"Msxml2.XMLHTTP\");
	} 
	catch(e) 
	{
		//If not, then use the older ActiveX object.
		try 
		{
			//If we are using Internet Explorer.
			xmlHttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
		} 
		catch(E) 
		{
			//Else we must be using a non-IE browser.
			xmlHttp = false;
		}
	}
		
	// If we are not using IE, create a JavaScript instance of the object.
	if (!xmlHttp && typeof XMLHttpRequest != 'undefined') 
	{
		xmlHttp = new XMLHttpRequest();
	}
	
	var songtitle = document.getElementById('songtitle');
	var url = '".$module_root_path."includes/cur_song.".$phpEx.$allow_url_config."';
	//xmlHttp.open(\"GET\", url);
	xmlHttp.onreadystatechange = function() 
	{
		if (xmlHttp.readyState == 4 && xmlHttp.status == 200) 
		{
			songtitle.innerHTML = xmlHttp.responseText;
			setTimeout('checkSong()', 25000);
		}
	}	
 	xmlHttp.open(\"GET\", url, true);
	xmlHttp.send(null); 
}

function checkSong2()
{
	var xmlHttp;
	try{	
		xmlHttp = new XMLHttpRequest();
	}
	catch (e){
		try{
			xmlHttp = new ActiveXObject(\"Msxml2.XMLHTTP\");
		}
		catch (e){
		    try{
				xmlHttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
			}
			catch (e){
				return false;
			}
		}
	}

	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			document.getElementById('songtitle').innerHTML = xmlHttp.responseText;
			setTimeout('Ajax()',25000);
		}
	}
    var url = '".$module_root_path."includes/cur_song.".$phpEx.$allow_url_config."';	
 	xmlHttp.open(\"GET\", url, true);
	xmlHttp.send(null); 
}

function checkcover_url()
{
	var xmlHttp;
	try{	
		xmlHttp = new XMLHttpRequest();
	}
	catch (e){
		try{
			xmlHttp = new ActiveXObject(\"Msxml2.XMLHTTP\");
		}
		catch (e){
		    try{
				xmlHttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
			}
			catch (e){
				return false;
			}
		}
	}

	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4)
		{
			document.getElementById('cover_url').href = xmlHttp.responseText;			
			//setTimeout('checkcover_url()', 100);
		}
	}
    var url = '".$module_root_path."includes/cur_url.".$phpEx.$allow_url_info."';	
 	xmlHttp.open(\"GET\", url, true);
	xmlHttp.send(null); 
}

function checkCover()
{
	var xmlHttp;
	try{	
		xmlHttp = new XMLHttpRequest();
	}
	catch (e){
		try{
			xmlHttp = new ActiveXObject(\"Msxml2.XMLHTTP\");
		}
		catch (e){
		    try{
				xmlHttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
			}
			catch (e){
				return false;
			}
		}
	}
	
	xmlHttp.onreadystatechange = function()
	{
		if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
		{
			document.getElementById('eq').src = xmlHttp.responseText;
			//setTimeout('checkCover()', 100);
		}
	}
	var url = '".$module_root_path."includes/cur_picture.".$phpEx.$allow_url_picture."';	
 	xmlHttp.open(\"GET\", url, true);
	xmlHttp.send(null); 
}

function checklisteners()
{
	var xmlHttp;
	try{	
		xmlHttp = new XMLHttpRequest();
	}
	catch (e){
		try{
			xmlHttp = new ActiveXObject(\"Msxml2.XMLHTTP\");
		}
		catch (e){
		    try{
				xmlHttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
			}
			catch (e){
				return false;
			}
		}
	}

	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			document.getElementById('currentlisteners').innerHTML = xmlHttp.responseText;
			setTimeout('checklisteners()',15900);
		}
	}
	xmlHttp.open(\"GET\",\"".$module_root_path."includes/cur_listeners.".$phpEx."\",true);	
	xmlHttp.send(null);
}
	
function updateInfo()
{
    var now = new Date();
	";
		if($autoplay)
		{
			//if($state == "Up")
			//{
				$java_script .= "
    var url = '" . $module_root_path . "includes/cur_display.php?old_title=' + old_title + '&config=" . $clean_config . "&skin=". SKIN ."&ts=' + now.getTime();  
	";
	//}
		}
		else
		{
			//if($state == "Up")
			//{
				$java_script .= "
	var url = '" . $module_root_path . "includes/cur_display.php?old_title=' + old_title + '&config=" . $clean_config . "&skin=". SKIN ."&ts=' + now.getTime(); 
	";
			//}
		}		
	$java_script .= "  
    makeHttpRequest(url, 'loadXML', true);
}";
	//End of functions
	$java_script2 = "";
	$java_script2 .= "

loadimg = new Image(27,27); 
loadimg.src = \"" . $module_root_path . "skins/" . SKIN . "/play_h.jpg\";
loadimg2 = new Image(19,19); 
loadimg2.src = \"" . $module_root_path . "skins/" . SKIN . "/stop_h.jpg\";
loadimg3 = new Image(18,18); 
loadimg3.src = \"" . $module_root_path . "skins/" . SKIN . "/close_h.png\";

window.onunload = function(){
	stopWinampx();
}

window.onload = function(){
	embedInfo(detectEmbed());
	";
	if(basename($_SERVER['PHP_SELF']) !== "play.php")
	{
		$java_script2 .= "
	updateInfo();	
	";
		if($autoplay)
		{
			//if($state == "Up")
			//{
				$java_script2 .= "
	playR();";
			//}
		}
	}
	$java_script2 .= "
}
";
	return $java_script . "// --></SCRIPT>";
}
?>