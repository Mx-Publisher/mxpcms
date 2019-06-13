<?php
/**
*
* @package MXP CMS Module - mx_shotcast
* @version $Id: lang_admin.php,v 1.1 2013/05/28 07:14:38 orynider Exp $
* @copyright (c) 2006 [orynider@rdslink.ro, OryNider] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

$lang['shotcast_Settings']			= "Setari Radio SHOUTcast & ICEcast";
$lang['shotcast_Settings_explain']		= "Use the form below to configure your shotcast Settings";
$lang['shotcast_Settings_updated']		= "Radio Settings Updated Sucessfully.";
$lang['shotcast_Settings_return']		= "Click %sHere%s to return to shotcast Settings.";

$lang['Radio_name']			= "Numele Statiei Radio";
$lang['shotcast_host']			= "HOSTul ori IPul </br>(e.g. kdshfm.com)";
$lang['shotcast_port']			= "Port Caster pt. statia inplicita </br>(e.g. 7000)";
$lang['shotcast_pass']			= "Parala Caster";

$lang['caster']			= "Tip Caster: <b>shout</b> ori <b>ice</b>";

$lang['play_list']			= "Play List for Real and QuickTime Player: .pls type (e.g. listen.pls , livemp3";
$lang['play_asx']			= "Play List .asx type for wmp if you run Icecast (e.g. livemp3)";
$lang['play_host']			= "IP address of the server where the play lists are located. Leave blank if they are on the same server as the cast ip";
$lang['play_port']			= "Port of the server where the play lists are located. Leave blank if they are on the same server as the cast ip";
$lang['play_mount']			= "If ICEcast is used with mount points, or leave blank (e.g. /livemp3)";

$lang['allow_autoplay']		= "Allow automatic play at load";
$lang['allow_autoplay_explain']	= "If Stream should start automatic when player is loaded";

$lang['logo_config']			= "Logo config parameters";
$lang['logo_config_explain']	= "Logo should be put in: \"templates/current_style/images/\" (standallone in the root of \"/logos\"). You can use any format tha works on the web (jpeg, gif, png...)";

$lang['picture_type']			= "CD-cover, equliazer, logo (cover, eq, logo)";
$lang['fallback_to']			= "Fallback URL if no cover is found (eq/logo)";
$lang['cast_logo']			= "The filename of the logo you want to use";
	
$lang['allow_curl']			= "Allow CURL to get CD cover data (yes/no)";
$lang['allow_curl_explain']			= "Use Curl PHP Class to get CD cover data from last.fm, and amazone's API";

$lang['Check_period']			= "Check period (seconds)";
$lang['Check_period_explain']		= "For example : Check who is on the radio from the web player and how many total listeners are connected";

$lang['show_listen']			= "Show Allways Listen";
$lang['show_listen_info']		= "Select Yes if you whant the listen option to be displayed allways or No if you whant to hide the listen option when allready listening.";

$lang['Allow_guests']			= "Allow guest(anonymous) users to listen?";
$lang['guestname']				= "Nume Vizitator";
$lang['guestname_explain']		= "Definition of guests names - do NOT start the name with numbers, and no use of special chars!";

$lang['Reset']				= "Resetare";
$lang['Submit']				= "Trimite";

$lang['Show_status']			= "Arata status";

$lang['Stream_type']			= "Tip Flux";

$lang['skinpath'] = "Selecteaza Fatza";

//
// That's all Folks!
// -------------------------------------------------
?>