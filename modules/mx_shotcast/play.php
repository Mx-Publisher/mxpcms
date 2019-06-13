<?php
//
// Radiplayer.
// Copyright (C) 2008 name of drknas
//
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
//

// History:
// Little Frog (v 1.x - 2.x)
// OryNider (v 1.x - 3.x)
// DrKnas (v 4.0 - 4.2.x)
// OryNider (Current maintainer: 3.5.x & 4.9.x & mxpcms versions)

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache'); 
$module_root_path = "./";
$phpEx = substr(strrchr(__FILE__, '.'), 1); 
define('IN_SHOTCAST', true);
require($module_root_path .'includes/common.'.$phpEx);
//* MX-CMS Code Start
if(defined('IN_PORTAL'))
{
	user_listensc($nick);	//Update web listen users
}
//* MX-CMS Code End
if(isset($_GET["config"]))
{
	$config_get = $_GET["config"];
}
else
{
	$config_get = "config";
}

// this is a user input some cleaning should be done.
$clean_config = preg_replace("/[^a-zA-Z0-9_.-@]/", "", $config_get);
$config = $module_root_path  . "config/" . $clean_config . "." . $phpEx;
if($clean_config == "display_config")
{
	die("Faulty config file.");
}
if(!file_exists($config))
{
	// this is a user input some cleaning should be done.
	$config = $module_root_path  . "config/config." . $phpEx;	
	if(!file_exists($config))
	{
		die("U have to suply in the url what config file to use!");
	}
}

$html = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html>
<head>";
$html .= css($module_root_path, $phpEx, $radio_skin);
$html .= "<title>" . $lang['Radio_Player'] . "  &bull; " . $station_name . "</title>";
$html .= java_script($module_root_path, $phpEx, $mimetype, $clean_config, $radio_skin, $autoplay, $state, $lang, $java_debug, $update_title);
$html .= "<SCRIPT LANGUAGE=\"JavaScript\"> 
			var videoElements = document.getElementsByTagName('video');			
		    for (var i=0; i<videoElements.length; i++)
		    {
		        videoElement = videoElements[i];
				
			    var control = document.createElement('object');
			    control.type = 'application/x-ms-wmp';
				control.width = 212;
				control.width = 32;
				
				// following standard attributes need to be assigned only when they are present in the video tag
			    if (videoElement.id != \"\") { control.id = videoElement.id; }
			    if (videoElement.dir != \"\") { control.dir = videoElement.dir; }
			    //if (videoElement.class != \"\") { control.class = videoElement.class; }
			    if (videoElement.title != \"\") { control.title = videoElement.title; }
			    if (videoElement.draggable) { control.draggable = true; }
			    if (videoElement.lang != \"\") { control.lang = videoElement.lang; }
			    if (videoElement.spellcheck) { control.spellcheck = true; }
			    if (videoElement.style.cssText != \"\") { control.style.cssText = videoElement.style.cssText; }
			    
				// controls attribute - boolean for video tag. 
			    // for WMP, uiMode => \"full\" shows controls, \"none\" shows only video window
			    var controls = (videoElement.controls == true) ? \"full\" : \"none\";
			    control.setAttribute(\"uiMode\", controls);
				
				var autostart = videoElement.autoplay;  // boolean - maps to object.autostart property
			    var paramAutoStart = document.createElement(\"param\");
			    paramAutoStart.name = \"autostart\";
			    paramAutoStart.value = autostart;
			    control.appendChild(paramAutoStart);
				
				//OPEN: Should we always set autostart when \"controls\" are hidden ?
				
				var paramUrl = document.createElement(\"param\");
			    paramUrl.name = \"url\";
			    paramUrl.value = supportedMediaSource;
			    control.appendChild(paramUrl);				
		    }		
</SCRIPT>";
$html .= "
</head>
<body>
<!--// Create ActiveX objects for later checks for WMP versions. -->
<!--// OBJECT CLASSID=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\" ID=\"WMP64\" STYLE=\"visibility: visible;\" type=\"application/x-mplayer2\" type=\"application/x-oleobject\"></OBJECT -->
<!--// OBJECT CLASSID=\"CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6\" ID=\"WMP7\" STYLE=\"visibility: visible;\" type=\"application/x-oleobject\" type=\"application/x-mplayer2\"></OBJECT-->";

if(!isset($_GET['embed']))
{
	$html .= "
<script type=\"text/javascript\">
	var embed = detectEmbed();
	self.location = 'play.php?config=" . $clean_config . "&embed='+embed;
</script>";
}
else
{
	if($_GET['embed'] == "real")
	{
		$html .= "
		<OBJECT id=\"RVOCX\"  width=\"90\" height=\"12\" classid=\"CLSID:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\">
			<PARAM name=\"SRC\" value=\"".$protocol_type."://".$full_real_and_quick_playlist_url . "\">
			<PARAM NAME=\"CONTROLS\" VALUE=\"VolumeSlider\">
			<PARAM NAME=\"NOJAVA\" VALUE=\"true\">			
			<PARAM name=\"autostart\" value=\"true\">
		  <EMBED autostart=\"true\" src=\"".$protocol_type."://".$full_real_and_quick_playlist_url . "\" width=\"90\" height=\"12\" NOJAVA=\"true\" CONTROLS=\"VolumeSlider\" type=\"audio/x-pn-realaudio-plugin\">
		  </EMBED>
		</OBJECT>";
	} 
	else if($_GET['embed'] == "quicktime")
	{
			$html .= "
			<OBJECT width=\"90\" height=\"12\" id=\"QuickTime\" classid=\"CLSID:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\"
			 codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\">
			 <PARAM name=\"SRC\" value=\"http://".$full_real_and_quick_playlist_url . "\">
			 <PARAM name=\"AUTOPLAY\" value=\"true\">
			  <EMBED id=\"QuickTime\" src=\"http://".$full_real_and_quick_playlist_url . "\" width=\"90\" height=\"12\" type=\"audio/mpegurl\" autoplay=\"true\"    
			   pluginspace=\"http://www.apple.com/quicktime/download/\">
			  </EMBED>
			</OBJECT>"; 		
	} 
	else if($_GET['embed'] == "winampX")
	{
		$html .= " 
			<SCRIPT LANGUAGE=\"JavaScript\"> 
			//IE Code http://radio.hostinglotus.com/~jaranai/ampx_en_dl.cab
			var otobasla = 1; //Sayfa yuklendiginde calsin 1 / Ziyaretci baslatsin 0
			var leaktest = 1;
			var winampx;
			var gecko =  !(navigator.appName == 'Internet Explorer');
			var initted = 0;
			
            function mozIAmpXEvents() { }
            mozIAmpXEvents.prototype = {
              WinampMsgEvent: function ( msgID ) {},
              WinampStatus: function( msgID, comp ) {},
              WinampMetaData: function( data, size ) {},
              QueryInterface: function(iid) 
			  {
                if (!iid.equals(Components.interfaces.Unagi2MozEvents)&&
                !iid.equals(Components.interfaces.nsISupports)) 
				{
                  throw Components.results.NS_ERROR_NO_INTERFACE;
				}
                return this;
              },
              val: \"<devault value>\"
            }
            WINAMPX_EVENT_FILE_END                   =   1;
            WINAMPX_EVENT_TRACK_CHANGED              =   2;
            WINAMPX_EVENT_LAUNCH_URL                 =   3;
            WINAMPX_EVENT_TRACK_INFO_CHANGED         =   4;
            WINAMPX_EVENT_VIDEO_WND_REQUESTED        =   5;
            WINAMPX_EVENT_VIDEO_WND_SIZE_CHANGED     =   6;
            WINAMPX_EVENT_VIDEO_WND_DONE             =   7;
            WINAMPX_EVENT_HWND_READY                 =   8;
            WINAMPX_EVENT_NO_SOUNDCARD_AVL           = 100;
            WINAMPX_EVENT_NO_PLUGINS_AVL             = 101;
            WINAMPX_EVENT_CANT_PLAY_FILE             = 102;
            WINAMPX_EVENT_WMA_FILE_EXPIRED           = 103;
            WINAMPX_EVENT_FILE_NOT_FOUND             = 104;
            WINAMPX_EVENT_PLAYLIST_NO_FILES_PRESENT  = 105;
            WINAMPX_EVENT_PLAYLIST_EMPTY             = 106;
            WINAMPX_EVENT_REAL_ENGINE_MISSING        = 107;
            WINAMPX_EVENT_CORRUPT_FILE               = 108,
            WINAMPX_EVENT_UNSUPPORTED_FORMAT         = 109;
            WINAMPX_EVENT_QUICKTIME_ENGINE_MISSING   = 110,
            WINAMPX_EVENT_REAL_ENGINE_ERROR          = 111,
            WINAMPX_EVENT_FILE_SYSTEM_CHANGE         = 112
            WINAMPX_STATUS_INIT_WININET              = 200;
            WINAMPX_STATUS_OPENING_URL               = 201;
            WINAMPX_STATUS_HTTP_ERROR                = 202;
            WINAMPX_STATUS_DOWNLOADING_URL           = 203;
            WINAMPX_STATUS_URL_DOWNLOADED            = 204;
            WINAMPX_STATUS_CANNOT_CREATE_TEMP_FILE   = 205;
            WINAMPX_STATUS_CANNOT_OPEN_URL           = 206;
            WINAMPX_STATUS_CONNECTION_LOST           = 207;
            WINAMPX_STATUS_PREBUFFERING              = 208;
            WINAMPX_STATUS_RESYNC                    = 209;
            WINAMPX_STATUS_BROADCAST_INTERRUPT       = 210;
            WINAMPX_STATUS_BROADCAST_TERMINATE       = 211;
            WINAMPX_STATUS_DOLBY_ERROR               = 212;
            WINAMPX_STATUS_TRANSFER_RATE             = 213;
            WINAMPX_STATUS_STREAM_BEGIN              = 214;
            WINAMPX_STATUS_LENGTH_CHANGE             = 215;
            WINAMPX_STATUS_VIDEO_KEYPRESS            = 216;
            WINAMPX_STATUS_VIDEO_SYSKEYPRESS         = 217;
            WINAMPX_STATUS_SERVER_RESTART            = 218;
            WINAMPX_STATUS_SERVER_CRASH              = 219;
            WINAMPX_STATUS_ERROR_KILLING_THREAD      = 220;
            WINAMPX_STATUS_ADVANCED_PARSE_ERROR      = 221;
            WINAMPX_STATUS_SERVER_SWAPPED            = 222;
            STATUS_STOPED                            = 0;
            STATUS_PLAYING                           = 1;
            STATUS_PAUSED                            = 2;
            STATUS_BUFFERING                         = 3;
            var clockPrebuffer;
			
            function onWinampMSGEvent(a) 
			{
              switch(a) 
			  {
				case WINAMPX_EVENT_HWND_READY:
					var hwnd = winampx.hwnd;
					winampx.SetVideoHWND(hwnd);
					if ( leaktest ) winampx.Play();
				break;
				case WINAMPX_EVENT_VIDEO_WND_DONE:
					winampx.RemoveFullScreen();
                case WINAMPX_EVENT_FILE_SYSTEM_CHANGE:
					RefreshTitle();
					RefreshPlaylist();
				break;
                default:
                  break;
              }
			}			
			vpstatus=0;
			if (document.images)
			{
					zap=new Array(15);
					zap[0]=new Image;  zap[0].src=\"". $module_root_path . "skins/" . SKIN . "/voldis_on.gif\";
					zap[1]=new Image;  zap[1].src=\"". $module_root_path . "skins/" . SKIN . "/voldis_off.gif\";
					zap[2]=new Image;  zap[2].src=\"". $module_root_path . "skins/" . SKIN . "/voldis_mute.gif\";
			        zap[3]=new Image;  zap[3].src=\"". $module_root_path . "skins/" . SKIN . "/stop_on.gif\";
			        zap[4]=new Image;  zap[4].src=\"". $module_root_path . "skins/" . SKIN . "/stop_off.gif\";
			        zap[5]=new Image;  zap[5].src=\"". $module_root_path . "skins/" . SKIN . "/play_on.gif\";
			        zap[6]=new Image;  zap[6].src=\"". $module_root_path . "skins/" . SKIN . "/play_off.gif\";
			        zap[7]=new Image;  zap[7].src=\"". $module_root_path . "skins/" . SKIN . "/pause_on.gif\";
			        zap[8]=new Image;  zap[8].src=\"". $module_root_path . "skins/" . SKIN . "/pause_off.gif\";
			        zap[9]=new Image;  zap[9].src=\"". $module_root_path . "skins/" . SKIN . "/mute_on.gif\";
			        zap[10]=new Image; zap[10].src=\"". $module_root_path . "skins/" . SKIN . "/mute_off.gif\";
			        zap[11]=new Image; zap[11].src=\"". $module_root_path . "skins/" . SKIN . "/volup_up.gif\";
			        zap[12]=new Image; zap[12].src=\"". $module_root_path . "skins/" . SKIN . "/volup_dwn.gif\";
			        zap[13]=new Image; zap[13].src=\"". $module_root_path . "skins/" . SKIN . "/voldwn_up.gif\";
			        zap[14]=new Image; zap[14].src=\"". $module_root_path . "skins/" . SKIN . "/voldwn_dwn.gif\";
			}			   
				
				function onClickPlay(a) 
				{
					winampx.Play();
					RefreshTitle();
					afmObj_play(1);
					RefreshPlaylist();
				}
				function onClickStop()
				{
					winampx.Stop();
					afmObj_play(0);
					RefreshPlaylist();
				}
				function onClickPause()
				{
					winampx.Pause();
					afmObj_play(0);
				}
				function onClickPrevious()
				{
					winampx.PreviousTrack();
					RefreshTitle();
					RefreshPlaylist();
				}
				function onClickNext()
				{
					winampx.NextTrack();
					RefreshTitle();
					RefreshPlaylist();
				}
				function onClicPlaylist(no)
				{
					winampx.Stop();
					winampx.PlaylistPos = no;
					winampx.Play();
				}
				function onClickgeri() {
					var val = winampx.Position - 10;
					winampx.Position = val;
				}
				
				function onClickileri() {
					var val = winampx.Position + 10;
					winampx.Position = val;
				}
				function Mute()
				{
				    suanses = winampx.Volume;
					if ( suanses >= 1 ) {
						img_mute_on.style.display = \"block\";
						img_mute_off.style.display = \"none\";
						volumerate.innerHTML = \"Ses düzeyi - 0\";
						suanses = 0;
						winampx.Volume = 0;
					} else {
						img_mute_on.style.display = \"none\";
						img_mute_off.style.display = \"block\";
						winampx.Volume = 255;
						suanses = winampx.Volume;
						volumerate.innerHTML = \"Ses düzeyi - 255\";
					}
				}
				function setVolume(act) {
					currentVol = winampx.Volume;
					if(act == \"up\") {
						targetVol = currentVol + 5;
						if(targetVol >= 255) targetVol = 255;
					} else if(act == \"down\") {
						targetVol = currentVol - 5;
						if(targetVol <= 0) targetVol = 0;
					} else if(act <= 255) {
						targetVol = act;
					}
					volumerate.innerHTML = \"Ses düzeyi - \"+targetVol;
					winampx.Volume = targetVol;
				}
				function about() {
					var res = 'IWinAmpActiveX E-mail: aquamp@bystyx.com, Homepage : theaqua.com : Skin tasarýmý : sdasd@sas.com';
					alert(res);
				}
				function imgchange(imgnum) 
				{
					if (imgnum == \"play\")  { vpstatus=1; document.vpstop.src=zap[4].src; document.vpplay.src=zap[5].src; document.vppaus.src=zap[8].src; }
					if (imgnum == \"paus\")  { vpstatus=2; document.vpstop.src=zap[4].src; document.vpplay.src=zap[6].src; document.vppaus.src=zap[7].src; }
					if (imgnum == \"stop\")  { vpstatus=3; document.vpstop.src=zap[3].src; document.vpplay.src=zap[6].src; document.vppaus.src=zap[8].src; }
					if (imgnum == \"muta\")  { vpstatus=4; document.vpmute.src=zap[10].src; }
					if (imgnum == \"mutb\")  { vpstatus=5; document.vpmute.src=zap[9].src;  }
					if (imgnum == \"vola\")  { vpstatus=3; document.vpvolup.src=zap[11].src; }
					if (imgnum == \"volb\")  { vpstatus=3; document.vpvolup.src=zap[12].src; }
					if (imgnum == \"volc\")  { vpstatus=3; document.vpvoldwn.src=zap[13].src; }
					if (imgnum == \"vold\")  { vpstatus=3; document.vpvoldwn.src=zap[14].src; }
				}
				function playitnow() { if (vpstatus == 1) {  } else { winampx.Play();  imgchange('play'); } }
				function pausitnow() { if (vpstatus == 2) { playitnow() } else { winampx.Pause(); imgchange('paus'); } }
				function stopitnow() { if (vpstatus == 3) {  } else { winampx.Stop();  imgchange('stop'); } }
				
				document.writeln('<table width=\"238\" height=\"38\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" background=\"". $module_root_path . "skins/" . SKIN . "/controller_bg.png\"  style=\"margin: 0; padding: 0\">');
				document.writeln('  <tbody style=\"margin: 0; padding: 0\">');
				document.writeln('');
				document.writeln('');
				document.writeln('	 <tr style=\"margin: 0; padding: 0\">');
				document.writeln('		<td style=\"margin: 0; padding: 0\" width=\"45\"><img src=\"". $module_root_path . "skins/" . SKIN . "/spacer.gif\" width=\"0\" height=\"0\"></td>');
				document.writeln('		<td style=\"margin: 0; padding: 0\" width=\"30\"><a title=\"Stop Video Stream\" style=\"text-decoration: none; color: #8a99f4; border: 0px none; margin: 0; padding: 0\" onmousedown=\"stopitnow();\"><img name=\"vpstop\" src=\"". $module_root_path . "skins/" . SKIN . "/stop_off.gif\" width=\"25\" height=\"21\" border=\"0\"></a></td>');
				document.writeln('		<td style=\"margin: 0; padding: 0\" width=\"4\"><img src=\"". $module_root_path . "skins/" . SKIN . "/spacer.gif\" width=\"0\" height=\"0\"></td>');
				document.writeln('	');
			    document.writeln('');
			    document.writeln('');
			    document.writeln('');
			    document.writeln('	');
			    document.writeln('		<td style=\"margin: 0; padding: 0\" width=\"20\"><img src=\"". $module_root_path . "skins/" . SKIN . "/spacer.gif\" width=\"0\" height=\"0\"></dd>');
			    document.writeln('		<td style=\"margin: 0; padding: 0\" width=\"40\"><a title=\"Play Video Stream\" style=\"text-decoration: none; color: #8a99f4; border: 0px none; margin: 0; padding: 0\" onmousedown=\"playitnow();\"><img name=\"vpplay\" src=\"". $module_root_path . "skins/" . SKIN . "/play_off.gif\" width=\"41\" height=\"26\" border=\"0\"></a></td>');
			    document.writeln('		<td style=\"margin: 0; padding: 0\" width=\"20\"><img src=\"". $module_root_path . "skins/" . SKIN . "/spacer.gif\" width=\"0\" height=\"0\"></dd>');
			    document.writeln('	');
			    document.writeln('');
			    document.writeln('');
			    document.writeln('');
			    document.writeln('	');
			    document.writeln('		<td style=\"margin: 0; padding: 0\" width=\"4\"><img src=\"". $module_root_path . "skins/" . SKIN . "/spacer.gif\" width=\"4\" height=\"4\"></td>');
			    document.writeln('		<td style=\"margin: 0; padding: 0\" width=\"30\"><a title=\"Pause Video Stream\" style=\"text-decoration: none; color: #8a99f4; border: 0px none; margin: 0; padding: 0\" onmousedown=\"pausitnow();\"><img name=\"vppaus\" src=\"". $module_root_path . "skins/" . SKIN . "/pause_off.gif\" width=\"25\" height=\"21\" border=\"0\"></a></td>');
			    document.writeln('		<td style=\"margin: 0; padding: 0\" width=\"45\"><img src=\"". $module_root_path . "skins/" . SKIN . "/spacer.gif\" width=\"4\" height=\"4\"></td>');
			    document.writeln('	</tr>');
			    document.writeln('');
			    document.writeln('');
				document.writeln('</tbody>');
				document.writeln('</table>');			
							
			if (gecko) 
			{
				navigator.plugins.refresh(false);
			   
			   document.writeln('<div id=\"embedframe\" width=\"0\" height=\"0\" style=\"visibility: hidden; display: none;\">');
			   document.writeln('<OBJECT width=\"0\" height=\"0\" ID=\"IWinAmpActiveXG\" border=\"0\" CLASSID=\"CLSID:FE0BD779-44EE-4A4B-AA2E-743C63F2E5E6\"');
			   document.writeln('codebase=\"".ADDON_URL."addonsx/ampx_en_dl.cab\" version=\"-1,-1,-1,-1\" STYLE=\"visibility: hidden; display: none;\">');
			   document.writeln('</OBJECT>');
			   document.writeln('</div>');
			   
				winampx = document.getElementById('IWinAmpActiveXG');
				winampx.AppendFileToPlaylist('".$protocol_type."://".$caster_ip.":".$caster_port.$icecast_mount_point."');
				playitnow();			   
			} 
			else 
			{
				//FF Code			
				document.writeln('<OBJECT width=\"100\" height=\"12\" ID=\"IWinAmpActiveX\" border=\"0\" CLASSID=\"CLSID:FE0BD779-44EE-4A4B-AA2E-743C63F2E5E6\"');
				document.writeln('codebase=\"".ADDON_URL."addonsx/ampx_en_dl.cab\" version=\"-1,-1,-1,-1\">');
				document.writeln('</OBJECT>');
				
				events = new mozIAmpXEvents();
				events.WinampMsgEvent = onWinampMSGEvent;
				events.WinampStatus = onWinampStatus;
				events.WinampMetaData = onWinampMetaData;
				
				winampx = document.getElementById('IWinAmpActiveX');
				winampx.AppendFileToPlaylist('".$protocol_type."://".$caster_ip.":".$caster_port.$icecast_mount_point."');
				playitnow();				
				winampx.Play();			
			}			
			</SCRIPT>
			";
	} 
	else if($_GET['embed'] == "wmp6")
	{
		$html .= "		
			<OBJECT width=\"100\" height=\"70\" id=\"MediaPlayer\" TYPE=\"application/x-oleobject\" classid=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\"
			 codebase=\"http://activex.microsoft.com/activex/controls/mplayer/sv/nsmp2inf.cab#Version=6,4,5,715\"
			 type=\"application/x-oleobject\">
			 <PARAM name=\"FileName\" value=\"".$protocol_type."://".$full_wmp_playlist_url."\">
			 <PARAM name=\"AutoStart\" value=\"true\">
			 <PARAM NAME=\"ShowDisplay\" VALUE=\"0\">		 
			 <PARAM NAME=\"ShowControls\" VALUE=\"1\">
			 <param name=\"ShowStatusBar\" value=\"0\">			 
			 <EMBED type=\"application/x-mplayer2\"  
			   pluginspage=\"http://www.microsoft.com/windows/windowsmedia/\" 
			   SRC=\"".$protocol_type."://".$full_wmp_playlist_url."\"
			   FileName=\"".$protocol_type."://".$full_wmp_playlist_url."\"			   
			   animationatStart=0 
			   volume=90 
			   autostart=1 
			   loop=1
			   Name=\"MediaPlayer\"
			   ShowControls=\"1\"
			   ShowDisplay=\"0\"
			   ShowStatusBar=\"0\"
			   width=\"100\" height=\"70\" autostart=\"1\">
			</EMBED>		 
			</OBJECT>";
	} 
	else if($_GET['embed'] == "wmp7")
	{
		if(($protocol_type != "http") || ($mimetype === 'audio/aacp'))
		{
			$html .= "
			<OBJECT width=\"100\" height=\"62\" ID=\"MediaPlayer\" TYPE=\"application/x-oleobject\" CLASSID=\"CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95\" STANDBY=\"Loading Windows Media Player components...\">
				<PARAM NAME=\"FileName\" VALUE=\"".$protocol_type."://".$full_wmp_playlist_url."\" valuetype=\"ref\" ref><param name=\"AudioStream\" value=\"1\">
				<param name=\"AutoSize\" value=\"0\">
				<param name=\"AutoStart\" value=\"1\">
				<param name=\"AnimationAtStart\" value=\"0\">
				<param name=\"AllowScan\" value=\"-1\">
				<param name=\"AllowChangeDisplaySize\" value=\"-1\">
				<param name=\"AutoRewind\" value=\"0\">
				<param name=\"Balance\" value=\"0\">
				<param name=\"BaseURL\" value>
				<param name=\"BufferingTime\" value=\"5\">
				<param name=\"CaptioningID\" value>
				<param name=\"ClickToPlay\" value=\"-1\">
				<param name=\"CursorType\" value=\"0\">
				<param name=\"CurrentPosition\" value=\"-1\">
				<param name=\"CurrentMarker\" value=\"0\">
				<param name=\"DefaultFrame\" value>
				<param name=\"DisplayBackColor\" value=\"0\">
				<param name=\"DisplayForeColor\" value=\"16777215\">
				<param name=\"DisplayMode\" value=\"1\">
				<param name=\"DisplaySize\" value=\"1\">
				<param name=\"Enabled\" value=\"-1\">
				<param name=\"EnableContextMenu\" value=\"-1\">
				<param name=\"EnablePositionControls\" value=\"-1\">
				<param name=\"EnableFullScreenControls\" value=\"-1\">
				<param name=\"EnableTracker\" value=\"-1\">
				<param name=\"InvokeURLs\" value=\"-1\">
				<param name=\"Language\" value=\"-1\">
				<param name=\"Mute\" value=\"0\">
				<param name=\"PlayCount\" value=\"0\">
				<param name=\"PreviewMode\" value=\"0\">
				<param name=\"Rate\" value=\"1\">
				<param name=\"SAMILang\" value>
				<param name=\"SAMIStyle\" value>
				<param name=\"SAMIFileName\" value>
				<param name=\"SelectionStart\" value=\"-1\">
				<param name=\"SelectionEnd\" value=\"-1\">
				<param name=\"SendOpenStateChangeEvents\" value=\"-1\">
				<param name=\"SendWarningEvents\" value=\"-1\">
				<param name=\"SendErrorEvents\" value=\"-1\">
				<param name=\"SendKeyboardEvents\" value=\"0\">
				<param name=\"SendMouseClickEvents\" value=\"0\">
				<param name=\"SendMouseMoveEvents\" value=\"0\">
				<param name=\"SendPlayStateChangeEvents\" value=\"-1\">
				<param name=\"ShowCaptioning\" value=\"1\">
				<param name=\"ShowControls\" value=\"1\">
				<param name=\"ShowVolume\" value=\"1\">				
				<param name=\"ShowAudioControls\" value=\"1\">
				<param name=\"ShowDisplay\" value=\"0\">
				<param name=\"ShowGotoBar\" value=\"0\">
				<param name=\"ShowPositionControls\" value=\"0\">
				<param name=\"ShowStatusBar\" value=\"1\">
				<param name=\"ShowTracker\" value=\"0\">
				<param name=\"TransparentAtStart\" value=\"1\">
				<param name=\"VideoBorderWidth\" value=\"0\">
				<param name=\"VideoBorderColor\" value=\"333333\">
				<param name=\"VideoBorder3D\" value=\"-1\">
				<param name=\"Volume\" value=\"98\">
				<param name=\"WindowlessVideo\" value=\"-1\">
			 <EMBED type=\"application/x-mplayer2\" 
			   pluginspage=\"http://www.microsoft.com/windows/windowsmedia/\" 
				SRC=\"".$protocol_type."://".$full_wmp_playlist_url."\" 
				   Name=\"MediaPlayer\" 
				   ShowControls=\"1\" 
				   ShowDisplay=\"0\" 
				   ShowStatusBar=\"0\" 
				   width=\"100\" height=\"62\" autostart=\"1\">
				</EMBED>				
			</OBJECT>
		";			
		}
		else
		{			
			$html .= "			
			<OBJECT width=\"100\" height=\"62\" id=\"MediaPlayer\" codebase=\"http://www.microsoft.com/isapi/redir.dll?prd=windows&sbp=mediaplayer&ar=Media&sba=Plugin&\" STANDBY=\"Loading Windows Media Player components...\" 
			 type=application/x-oleobject height=75 width=250 align=absmiddle
			 classid=\"clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6\">
			 <param name=\"url\" value=\"http://" . $full_wmp_playlist_url . "\">			 
			 <param name=\"FileName\" value=\"http://" . $full_wmp_playlist_url . "\">
			 <param name='animationatStart' value='false'>
			 <param name=\"ShowControls\" value=\"1\">
			 <param name=\"ShowVolume\" value=\"1\">
			 <param name=\"ShowStatusBar\" value=\"0\">
			 <param name=\"ShowDisplay\" value=\"0\">
			 <param name=\"DefaultFrame\" value=\"slide\">
			 <param name=\"Autostart\" value=\"1\">
			 <PARAM NAME=\"volume\" VALUE=\"90\"> 
			 <embed src=\"http://" . $full_wmp_playlist_url . "\" animationatStart=0 volume=90 autostart=1 loop=1
			 align=\"absmiddle\" type=\"application/x-mplayer2\" 
			 pluginspage=\"http://www.microsoft.com/Windows/MediaPlayer/download/default.asp\"
			  showcontrols=1 ShowVolume=1 showdisplay=0 showstatusbar=0 width=\"100\" height=\"62\">
			</embed></OBJECT>		
			";			
		}
	} 
	else if($_GET['embed'] == "aac_wmp")
	{
		$html .= "
		<SCRIPT LANGUAGE=\"JavaScript\"> 
		/* IE Code */
		document.write ('<OBJECT width=\"100\" height=\"32\" ID=\"MediaPlayer\"'); 
		document.write (' CLASSID=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\"');
		document.write (' CODEBASE=\"http://retro-radio.net/plugin/setup_AAC_aacPlus_plugin_1_0_36.exe\"'); 
		document.write (' standby=\"Loading Microsoft Windows Media Player components...\"'); 
		document.write (' TYPE=\"application/x-oleobject\" width=\"100\" height=\"32\">');
		document.write (' <PARAM NAME=\"FileName\" VALUE=\"icyx://" . $caster_ip . ":" . $caster_port . $icecast_mount_point . "\" valuetype=\"ref\">'); 
		document.write ('<PARAM NAME=\"url\" VALUE=\"icyx://" . $caster_ip . ":" . $caster_port . $icecast_mount_point . "\"> '); 
		document.write ('<PARAM NAME=\"AutoStart\" VALUE=\"true\">'); 
		document.write ('<PARAM NAME=\"ShowControls\" VALUE=\"1\">');
		
		/* Firefox code */	
		document.write ('    <Embed type=\"application/x-ms-wmp\"');
		document.write ('        pluginspage=\"" . $ff2pluginspace . "\"');
		document.write ('        filename=\"icyx://" . $caster_ip . ":" . $caster_port . $icecast_mount_point . "\"');
		document.write ('        src=\"icyx://" . $caster_ip . ":" . $caster_port . $icecast_mount_point . "\"');
		document.write ('        Name=\"MediaPlayer\"');
		document.write ('        ShowControls=\"1\"');
		document.write ('        ShowDisplay=\"0\"');
		document.write ('        ShowStatusBar=\"0\"');
		document.write ('        AUTOSTART=\"1\"');
		document.write ('        width=\"100\"');
		document.write ('        height=\"32\">');
		document.write ('    </embed>');
		
		document.write ('    <Embed type=\"application/x-mplayer2\"');
		document.write ('        pluginspage=\"" . $ff2pluginspace . "\"');
		document.write ('        filename=\"icyx://" . $caster_ip . ":" . $caster_port . $icecast_mount_point . "\"');
		document.write ('        src=\"icyx://" . $caster_ip . ":" . $caster_port . $icecast_mount_point . "\"');
		document.write ('        Name=\"MediaPlayer\"');
		document.write ('        ShowControls=\"1\"');
		document.write ('        ShowDisplay=\"0\"');
		document.write ('        ShowStatusBar=\"0\"');
		document.write ('        AUTOSTART=\"1\"');
		document.write ('        width=\"100\"');
		document.write ('        height=\"32\">');
		document.write ('    </embed>');
		document.write ('</OBJECT>');
		</SCRIPT>";
	}
}
$html .= "</body></html>";

print $html;
?>