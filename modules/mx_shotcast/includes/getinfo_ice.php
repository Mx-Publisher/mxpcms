<?php
/**
*
* @package StandAllone - Radiplayer.
* @version $Id: getinfo_ice.php,v 1.1 2013/05/28 07:14:34 orynider Exp $
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

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

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
	$ice_caster_ip = $caster_ip;
	$ice_caster_port = $caster_port;
}
else
{
	$ice_caster_ip = $caster_internal_ip;
	$ice_caster_port = $caster_internal_port;
}
$stream_url = $server_url = "http://".$ice_caster_ip.":".$ice_caster_port;
//error_reporting(0); 
define('SERVER', "http://".$ice_caster_ip.":".$ice_caster_port); //your icecast server address, without the ending "/"  
define('MOUNT', $icecast_mount_point); //your radio\'s mount point, with the leading "/"  

#error_reporting(0);
$stream = getStreamInfo($ice_caster_ip, $ice_caster_port, $icecast_mount_point);
if($icecast_status = icecast_status($ice_caster_ip, $ice_caster_port, $icecast_mount_point))
{
	$state = "Up";
	foreach ($icecast_status as $value)
	{
		if(isset($value['server_name']))
		{
			if($value['mount'] === $icecast_mount_point)
			{
				$currentsong = $value['title'];
				$stream_title = strip_tags($value['title']);
				$currentlisteners = $value['listeners'];
				$peaklisteners = $value['listener_peak'];
				$max_listeners = $value['max_listeners'];
				$mimetype = $value['server_type'];
				$stream_genre = $value['genre'];
				$server_name = $value['server_name'];
				$server_description = $value['server_description'];
				$bitrate = $value['bitrate'];
				
				$quality = $value['quality'];
				$video_quality = $value['video_quality'];
				$frame_size = $value['frame_size'];
				$frame_rate = $value['frame_rate'];
				$server_url = $value['server_url'];
				$title = strip_tags($value['title']);				
				$artist = $value['artist'];
				
				if(empty($bitrate))
				{
					$bitrate = "VBR";
				}
				else
				{
					$bitrate = $value['bitrate'];
				}
				$state = $value['status'];				
			}
		}
	}	
}
elseif($stream['']['status'] == 'Down')
{
	$state = "Down";
	$peaklisteners = 1;
	$bitrate = "56";		
	$stream_title = "Stream";
	$currentsong = "Track";
	//$mimetype = "audio/mpeg";
}
elseif($stream['']['status'] == 'Socket')
{
	$state = "Down";
	$peaklisteners = 1;
	$bitrate = "56";		
	$stream_title = "Stream";
	$currentsong = "Track";
	//$mimetype = "audio/mpeg";	
	$lang['Off_Air'] = $lang['Socket_functions_disabled'];	
}

if($stream['']['status'] == 'Up')
{
	$state = "Up";

	$currentsong = $stream['']['artist_song'];
	$maxlisteners = $stream['']['max_listeners'];
	$currentlisteners = $stream['']['listeners'];
	$peaklisteners = $stream['']['listener_peak'];
	$mimetype = $stream['']['type'];
	$stream_genre = $stream['']['genre'];
	$server_name = $stream['']['title'];
	$stream_title = strip_tags($stream['']['title']); //Station Name
	$server_description = $stream['']['description'];
	$bitrate = $stream['']['bitrate'];
	
	$quality = !empty($quality) ? $quality : ""; //$stream['']['quality'];
	$video_quality = !empty($video_quality) ? $video_quality : ""; //$stream['']['video_quality'];
	$frame_size = !empty($frame_size) ? $frame_size : ""; //$stream['']['frame_size'];
	$frame_rate = !empty($frame_rate) ? $frame_rate : ""; //$stream['']['frame_rate'];
	$server_url = !empty($server_url) ? $server_url : ""; //$stream['']['server_url'];
	
	$start = $stream['']['start'];  
	$stream_url = $stream['']['stream_url'];
	$title = $artist_song = $stream['']['artist_song']; 	
	$artist = $stream['']['artist'];	  
	$song = $stream['']['song'];	

}
#error_reporting(E_ALL ^ E_NOTICE);
function icecast_status($caster_ip, $caster_port, $icecast_mount_point)
{
	static $streamdata;
	$errno = 0;
	$errstr = '';
	$connect_timeout = 5;
	$page = "";
#	error_reporting(0);
	$fp = @fsockopen($caster_ip, $caster_port, $errno, $errstr, 5);
	if($fp)
	{ 
		fputs($fp,"GET /short_status.xsl HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n");		
		while(!feof($fp))
		{
			$page .= fgets($fp, 1000);
		}
		//$mount_points = explode("_END_", $page);
		//$page_array = preg_split('/<td\s[^>]*class=\"streamdata\">(.*)<\/td>/isU' , $page, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
		////die("$page");		
		//for( $i = 0; $i < $n = count($page_array); $i++ )
		//{
		//	$state = "Up";
		//}
		$mount_points = explode("_END_",$page);
		if(count($mount_points) < 2)
		{
			return FALSE;
		}
		foreach ($mount_points as $value)
		{
			if ( ( $value !== '_END_' ) && !empty( $value ) )
			{
				$info = explode("|",$value);
				if(isset($info[0]))
				{
					$mountpoint = explode("_START_", $info[0]);
					if(count($mountpoint) > 1)
					{
						$status[$info[0]]['mount'] = preg_replace("/[\n\r]/","",$mountpoint[1]) ;
					}
					else
					{
						$status[$info[0]]['mount'] = preg_replace("/[\n\r]/","",$mountpoint[0]) ;
					}
				}
				if(isset($info[1]))
				{
					$status[$info[0]]['server_name'] = preg_replace("/[\n\r]/","",$info[1]) ;
				}
				if(isset($info[2]))
				{
					$status[$info[0]]['server_description'] = preg_replace("/[\n\r]/","",$info[2]) ;
				}
				if(isset($info[3]))
				{
					$status[$info[0]]['server_type'] = preg_replace("/[\n\r]/","",$info[3]) ;
				}
				if(isset($info[4]))
				{
					$status[$info[0]]['bitrate'] = preg_replace("/[\n\r]/","",$info[4]) ;
				}
				if(isset($info[5]))
				{
					$status[$info[0]]['quality'] = preg_replace("/[\n\r]/","",$info[5]) ;
				}
				if(isset($info[6]))
				{
					$status[$info[0]]['video_quality'] = preg_replace("/[\n\r]/","",$info[6]) ;
				}
				if(isset($info[7]))
				{
					$status[$info[0]]['frame_size'] = preg_replace("/[\n\r]/","",$info[7]) ;
				}
				if(isset($info[8]))
				{
					$status[$info[0]]['frame_rate'] = preg_replace("/[\n\r]/","",$info[8]) ;
				}
				if(isset($info[9]))
				{
					$status[$info[0]]['listeners'] = preg_replace("/[\n\r]/","",$info[9]) ;
				}
				if(isset($info[10]))
				{
					$status[$info[0]]['listener_peak'] = preg_replace("/[\n\r]/","",$info[10]) ;
				}
				if(isset($info[11]))
				{
					$status[$info[0]]['genre'] = preg_replace("/[\n\r]/","",$info[11]) ;
				}
				if(isset($info[12]))
				{
					$status[$info[0]]['server_url'] = preg_replace("/[\n\r]/","",$info[12]) ;
				}
				if(isset($info[13]))
				{
					$status[$info[0]]['artist'] = preg_replace("/[\n\r]/","",$info[13]) ;
				}
				if(isset($info[14]))
				{
					$status[$info[0]]['title'] = preg_replace("/[\n\r]/","",$info[14]) ;
				}
				$status[$streamdata]['status'] = 'Up';
			}
		}
		if(isset($status))
		{
			return $status;
		}
		else
		{		
			return FALSE;				
		}
	}
	else
	{	
		$status[$streamdata]['status'] = 'Socket';
		return $status;				
	}
	@fclose($fp);
#	error_reporting(E_ALL ^ E_NOTICE);
}

/*
	based on function by Jude <surftheair@gmail.com>
	http://jude.im/	
	FlorinCB <orynider@gmail.com>
	works with Icecast 2.3.2
*/
function getStreamInfo($ice_caster_ip, $ice_caster_port, $icecast_mount_point)
{
	static $streamdata;
	$status = array();
	$str = @file_get_contents('http://'.$ice_caster_ip.":".$ice_caster_port.'/status.xsl?mount='.$icecast_mount_point);	
	if(!$str)
	{
		$fp = @fsockopen($ice_caster_ip, $ice_caster_port, $errno, $errstr, 5);
		if($fp)
		{ 		
			@fputs($fp,"GET /status.xsl?mount=".$icecast_mount_point." HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n");
			while(!@feof($fp))
			{
				$str .= @fgets($fp, 1000);
			}
		}
		else
		{
			$status[$streamdata]['status'] = 'Down';		
		}		
	}
	if(preg_match_all('/<td\s[^>]*class=\"streamdata\">(.*)<\/td>/isU', $str, $match))
	{
		//Stream Title: title 1,0
		//Stream Description: description 1.1
		//Content Type: audio/mpeg  type 1,2
		//Mount started: Thu, 16 May 2013 09:39:02 -0500 start 1.3
		//Bitrate: 56 bitrate 1,4
		//Current Listeners: 3 listeners 1,5
		//Peak Listeners: 3 max_listeners 1,6
		//Stream Genre: Various genre 1,7
		//Stream URL: http://www.scweb.tld/ stream_url 1,8 
		//Current Song: Artist - Song - Album 
	
		$status[$streamdata]['status'] = 'Up';
		$status[$streamdata]['title'] = $match[1][0]; 
		$status[$streamdata]['description'] = $match[1][1]; 
		$status[$streamdata]['type'] = $match[1][2]; 
		$status[$streamdata]['start'] = $match[1][3]; 
		$status[$streamdata]['bitrate'] = $match[1][4]; 
		$status[$streamdata]['listeners'] = $match[1][5]; 
		$status[$streamdata]['max_listeners'] = $match[1][6];
		$status[$streamdata]['listener_peak'] = $match[1][6]; 		
		$status[$streamdata]['genre'] = $match[1][7]; 
		$status[$streamdata]['stream_url'] = $match[1][8];
		$status[$streamdata]['artist_song'] = $match[1][9];
		$x = explode(" - ", $match[1][9]); 
		$status[$streamdata]['artist'] = !empty($x[0]) ? $x[0] : $match[1][9];  
		$status[$streamdata]['song'] = !empty($x[1]) ? $x[1] : $match[1][9];			
	}
	else
	{
		$status[$streamdata]['status'] = 'Down';		
	}
	
	if(!$str)	
	{
		$status[$streamdata]['status'] = 'Socket';			
	}			
	return $status;
}
?>