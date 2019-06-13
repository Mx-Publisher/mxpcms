<?php
/**
*
* @package StandAllone - Radiplayer.
* @version $Id: getinfo_shout.php,v 1.1 2013/05/28 07:14:34 orynider Exp $
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

$errno = "0";
$errstr = "";
$connect_timeout = "5";

$state = "";
$currentsong = "";
$currentlisteners = "";
$maxlisteners = "";
$mimetype = "";
$stream_genre = "";
$bitrate = "";
$peaklisteners = "";
$server_name = "";
$server_description = "";
$quality = "";
$video_quality = "";
$frame_size = "";
$frame_rate = "";
$server_url = "";
$artist = "";
$stream_title = "";

if(empty($caster_internal_ip))
{
	$shout_caster_ip = $caster_ip;
	$shout_caster_port = $caster_port;
}
else
{
	$shout_caster_ip = $caster_internal_ip;
	$shout_caster_port = $caster_internal_port;
}
$stream_url = $server_url = "http://".$shout_caster_ip.":".$shout_caster_port;
#error_reporting(0);
$fp = @fsockopen($shout_caster_ip, $shout_caster_port, $errno, $errstr, 5);
if(!$fp)
{ 
	$data = @file_get_contents("http://".$shout_caster_ip.":".$shout_caster_port."/2XS/?format=csv");	
	if(!$data)
	{
		$data = @file_get_contents("http://".$shout_caster_ip.":".$shout_caster_port."/index.html");		
	}
	if(!$data)
	{
		$state = "Down";
		$peaklisteners = 1;
		$bitrate = "56";		
		$stream_title = "Stream";
		$currentsong = "Track";
		//$mimetype = "audio/mpeg";
		$lang['Off_Air'] = $lang['Socket_functions_disabled'];		
	}	
	else
	{
		$state = "Up";
		
		//Shoutcast Name 
		$regex = '/Shoutcast-Name:(.*)/'; 
		@preg_match($regex, $data, $name); 
		$nameclean = str_replace("%20", " ", $name[1]); 
		//var_dump($name); 
		//echo $name[1]; 

		//Ascoltatori 
		$regex = '/Listeners:(.*)\/(.*)/'; 
		preg_match($regex, $data, $peaklisteners); 
		//var_dump($peaklisteners); 
		//echo $peaklisteners[1]; 
		//echo $peaklisteners[2]; 

		//Bitrate 
		$regex = '/Shoutcast-Bitrate:(.*)/'; 
		preg_match($regex, $data, $bitrate); 
		//var_dump($bitrate); 
		//echo $bitrate[1]; 
		
		//mimetype 
		$regex = '/Content Type:(.*)/'; 
		preg_match($regex, $data, $mimetype); 
		
		//Genere 
		$regex = '/Shoutcast-Genre:(.*)/'; 
		preg_match($regex, $data, $stream_genre); 
		//var_dump($stream_genre); 
		//echo $stream_genre[1];

		//$server_url 
		$regex = '/Stream-URL:(.*)/'; 
		preg_match($regex, $data, $stream_url); 
		//var_dump($server_url); 
		//echo $server_url[1]; 		
		
		//currentsong 
		$regex = '/Current Song:(.*)/'; 
		preg_match($regex, $data, $currentsong); 
		
		//Stream Title NOT WORKING NOW! 
		$regex = '/Shoutcast-StreamTitle:(.*)/'; 
		preg_match($regex, $data, $stream_title); 
		//var_dump($stream_title); 
		//echo $stream_title[1]; 
		// ADD Current Song: $stream_title[1] 		
	}			
}
else
{
	fputs($fp,"GET /index.html HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n");
	$page = "";
	while(!feof($fp))
	{
		$page .= fgets($fp, 1000);
	}
	$page = preg_replace("~.*Server Status:~", "", $page); //extract data
	$page = preg_replace("~</b></td></tr></table><br>.*~", "", $page); //extract data
	$page_array = preg_split('~(</?[^>]+>)~' , $page, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
	if(count($page_array) > 10)
	{
		for( $i = 0; $i < count( $page_array ); $i++ )
		{
			$state = "Up";
			if($page_array[$i] == "Server Status: ")
			{
				$server_status = strip_tags($page_array[$i+6]);
			}
			if($page_array[$i] == "Stream Status: ")
			{
				$bitrate = preg_replace("/ kbps.*/", "", preg_replace("/.*at /", "", $page_array[$i+6]));
				$currentlisteners = preg_replace("/of.*/", "", $page_array[$i+8]);
				$maxlisteners = preg_replace("/ listeners.*/", "", preg_replace("/.*of/", "", $page_array[$i+8]));
			}
			if($page_array[$i] == "Listener Peak: ")
			{
				$peaklisteners = strip_tags($page_array[$i+6]);
			}
			if($page_array[$i] == "Stream Title: ")
			{
				$stream_title = strip_tags($page_array[$i+6]);
			}			
			if($page_array[$i] == "Content Type: ")
			{
				$mimetype = strip_tags($page_array[$i+6]);
			}
			if($page_array[$i] == "Stream Genre: ")
			{
				$stream_genre = strip_tags($page_array[$i+6]);
			}
			if($page_array[$i] == "Stream URL: ")
			{
				$stream_url = strip_tags($page_array[$i+6]);
			}			
			if($page_array[$i] == "Current Song: ")
			{
				$currentsong = strip_tags($page_array[$i+6]);
			}
		}
	}		
	else
	{
		$state = $server_status = "Down";
		$peaklisteners = 1;
		$bitrate = "56";		
		$stream_title = "Stream";
		$currentsong = "Track";
		$server_url = "http://".$shout_caster_ip.":".$shout_caster_port."/";
		//$mimetype = "audio/mpeg";
		$lang['Off_Air'] = $lang['Socket_functions_disabled'];		
	}
}
@fclose($fp);
$x = explode(" - ", $currentsong);
$artist = !empty($x[0]) ? $x[0] : $currentsong; 
$song = !empty($x[1]) ? $x[1] : $currentsong;
$server_description[1] = sprintf($lang['Description_Status'] ." kbps - ". $lang['listeners'] .": %s", $bitrate, $peaklisteners); 
$server_description[2] = !empty($server_status) ? $server_status : $stream_title; 
$server_description[3] = $stream_title;
$choice = rand(1, 3); 
$server_description = $server_description[$choice]; 
$server_url = !empty($stream_url) ? $stream_url : "http://".$shout_caster_ip.":".$shout_caster_port."/";

//  The "i" after the pattern delimiter indicates a case-insensitive search
if (preg_match("/Unauthorized/", $stream_title)) 
{
    $servertitle = $stream_title = $station_name;
}

if (preg_match("/Unauthorized/", $stream_genre)) 
{
    $servergenre = $stream_genre = "genre";
} 

if (preg_match("/Unauthorized/", $stream_url)) 
{
   $songurl = $stream_url = "";
}

if (preg_match("/Unauthorized/", $server_url)) 
{
   $serverurl = $server_url = $lang['require_password'];
}

if (@preg_match("/Unauthorized/", $currentlisteners))
{
    $currentlisteners = 'n/a';
}	

if (preg_match("/Unauthorized/", $bitrate))
{
    $bitrate = 'n/a';
}
#error_reporting(E_ALL ^ E_NOTICE); 
?>