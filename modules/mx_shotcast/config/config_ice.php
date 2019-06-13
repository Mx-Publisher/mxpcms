<?php
/***************************************************************************
 *
 *********************** SET UP VARIABLES HERE ****************************/

//
// Generic config parameters
//

// Radio Station Name here
$station_name = "Radio Station Offline";

// IP address (e.g. kdshfm.com)
$caster_ip = "";

// Port for the caster (e.g. 7000) Leave blank if u don't know what your doing.
$caster_port = "";

// Caster type: shout or ice
$caster = "ice";

// What skin to use
$radio_skin = "default";

// What language to use
$language = "english";

// If Stream should start automatic when player is loaded
$autoplay = true;

//
// Icecast config parameters
//

// If icecast is used with mount points else leave blank (e.g. /livemp3)
$icecast_mount_point = "/livemp3";

// .pls type play list (e.g. listen.pls , livemp3)
$playlist_pls = "livemp3";
//$playlist_pls = "livemp3";

// .asx type play list. Looks like u need an asx type of play list for wmp if
// u run Icecast (e.g. livemp3) 
$playlist_asx = "livemp3";

// IP address of the server where the play lists are located. Leave blank if
// they are on the same server as the caster ip.
$playlist_ip = "";

// Port of the server where the play lists are located. Leave blank if they
// are on the same server as the caster ip.
$playlist_port = "";

//Secure cookies on the site were the playlist(s) is located ?
$cookie_secure = false;

//If other then port 80 where the play lists are located. Leave blank if they
$server_port = '';

// 
// Logo config parameters
//

// Logo should be put in the root of "/logos". U can use any format tha works
// on the web (jpeg, gif, png...)

// What do u want to use? CD-cover, equliazer, logo (cover, eq, logo)
$picture = "cover";

// Fallback if no cover is found (eq/logo)
$fallback = "eq";

// The filename of the logo u want to use
$logo_name = "logo.gif";

// Fallback URL to use when no cover is found. Leave blank if they
// are on the same server as the caster ip.
$caster_url = "";

	
/************************* DO NOT EDIT BELOW THIS LINE *********************/
/************************ IF U DON'T KNOW WHAT U ARE DOING *****************/

//
// Advanced config parameters
//

// Use Curl to get cd cover data (yes/no)
$curl = "no";

// If both web server and icecast are behind a router and the web server needs
// to know the internal ip of caster so it can pull the info for the player.
// This could be the case if all three got different internal ip-s. 
$caster_internal_ip = "";
$caster_internal_port = "";

//Server protocol if we use cookies
$server_protocol = ($cookie_secure) ? 'https://' : 'http://';

// Fallback URL to use when no cover is found. Edit above.
$no_cover_url = (empty($caster_url)) ? $server_protocol.$caster_ip . (($caster_port != 80) ? ":".$caster_port : "") : $caster_url;
$full_logo_url = "";

// Easier java debug messages (yes/no).
$java_debug = "no";

/************************* DO NOT EDIT BELOW THIS LINE *********************/
/***************************************************************************/
?>