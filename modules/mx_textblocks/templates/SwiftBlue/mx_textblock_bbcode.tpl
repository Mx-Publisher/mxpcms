<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border-top:none;">
	<tr>
		<td class="row1" align="left" colspan="2">{U_TEXT}</td>
	</tr>
</table>
<!-- Check Media Player Version --> 
<SCRIPT LANGUAGE="JavaScript"> 
var WMP7; 
var Mac; 
var Win;
var Unix;
var Linux; 

Win = navigator.userAgent.indexOf("Win") > -1; 
Mac = navigator.userAgent.indexOf("Mac") > -1;
Unix = navigator.appVersion.indexOf("X11") > -1;
Linux = navigator.appVersion.indexOf("Linux") > -1; 
 

if (Mac)
{

if ( navigator.appName == "Netscape" ){ 
     //Netscape code
     document.write ('    <Embed id="wmp" name="wmp" type="audio/mpeg"');
     document.write ('        pluginspage="http://www.microsoft.com/windows/windowsmedia/"');
     document.write ('        filename="http://pubory.uv.ro/midi/intro.mp3"');
     document.write ('        src="http://pubory.uv.ro/midi/intro.mp3"');
     document.write ('        Name=MediaPlayer');
     document.write ('        ShowControls=1');
     document.write ('        ShowDisplay=1');
     document.write ('        ShowStatusBar=1');
     document.write ('        AUTOSTART=1');
     document.write ('        width=290');
     document.write ('        height=320>');
     document.write ('    </Embed>'); } 

if ( navigator.appName != "Netscape" ){ 
document.write(' <embed id="wmp" name="wmp" type="audio/mpeg" width="290" height="320" ShowTracker="0" ShowDisplay="0" ShowGotoBar="0" ShowStatusBar="1" ShowCaptioning="0" AUTOSTART="1" src="http://pubory.uv.ro/midi/intro.mp3" ></embed>'); } 
}


if (Win)
{
if ( navigator.appName != "Netscape" ){ 
WMP7 = new ActiveXObject('WMPlayer.OCX'); 
} 

// Windows Media Player 7 Code 
if ( WMP7 ) 
{ 

     document.write ('<OBJECT ID=MediaPlayer ');
     document.write (' CLASSID=CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6');
     document.write (' standby="Loading Microsoft Windows Media Player components..."');
     document.write (' TYPE="application/x-oleobject" width="1" height="1">');
     document.write ('<PARAM NAME="url" VALUE="http://pubory.uv.ro/midi/intro.mp3">');
     document.write ('<PARAM NAME="AutoStart" VALUE="true">');
     document.write ('<PARAM NAME="ShowControls" VALUE="1">');
     document.write ('<PARAM NAME="uiMode" VALUE="mini">');

     document.write ('    <Embed type="application/x-mplayer2"');
     document.write ('        pluginspage="http://www.microsoft.com/isapi/redir.dll?prd=windows&sbp=mediaplayer&ar=Media&sba=Plugin&"');
     document.write ('        filename="http://pubory.uv.ro/midi/intro.mp3"');
     document.write ('        src="http://pubory.uv.ro/midi/intro.mp3"');
     document.write ('        Name="MediaPlayer"');
     document.write ('        ShowControls="1"');
     document.write ('        ShowDisplay="1"');
     document.write ('        ShowStatusBar="1"');
     document.write ('        AUTOSTART="true"');
     document.write ('        width="1"');
     document.write ('        height="1">');
     document.write ('    </embed>');

     document.write ('</OBJECT>');


} 

// Windows Media Player 6.4 Code 
else 

{ 

//IE Code
document.write ('<OBJECT ID=MediaPlayer '); 
document.write (' CLASSID=CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95');
document.write (' CODEBASE=http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715 '); 
document.write (' standby="Loading Microsoft Windows Media Player components..."'); 
document.write (' TYPE="application/x-oleobject" width="1" height="1">');
document.write (' <PARAM NAME="FileName" VALUE="http://pubory.uv.ro/midi/intro.mp3">'); 
document.write ('<PARAM NAME="url" VALUE="http://pubory.uv.ro/midi/intro.mp3"> '); 
document.write ('<PARAM NAME="AutoStart" VALUE="1">'); 
document.write ('<PARAM NAME="ShowControls" VALUE="1">'); 

//Firefox code
document.write ('    <Embed type="application/x-mplayer2"');
document.write ('        pluginspage="http://www.microsoft.com/isapi/redir.dll?prd=windows&sbp=mediaplayer&ar=Media&sba=Plugin&"');
document.write ('        filename="http://pubory.uv.ro/midi/intro.mp3"');
document.write ('        src="http://pubory.uv.ro/midi/intro.mp3"');
document.write ('        Name="MediaPlayer"');
document.write ('        ShowControls="1"');
document.write ('        ShowDisplay="1"');
document.write ('        ShowStatusBar="1"');
document.write ('        AUTOSTART="true"');
document.write ('        width="1"');
document.write ('        height="1">');
document.write ('    </embed>');

document.write ('</OBJECT>');
 
}
} 

else 
{ 

document.write(' <embed type="application/x-mplayer2" width="1" height="1" AUTOSTART="1" filename="http://pubory.uv.ro/midi/intro.mp3" src="http://pubory.uv.ro/midi/intro.mp3" ></embed>'); 

} 

</SCRIPT>