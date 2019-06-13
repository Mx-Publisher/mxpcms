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
// DrKnas (Current maintainer v 4.0 -)

define('IN_SHOTCAST', true);
define('STRIP_URL', (@ini_get('allow_url_fopen')) ? false : true); //fopen_url not allowed
$module_root_path = "./../";
$phpEx = substr(strrchr(__FILE__, '.'), 1); 

require($module_root_path ."includes/common." . $phpEx);

if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}
else
{
	$mode = 'url_picture';
}

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
$url_picture = $parsed_xml = "nochange";
$url_info = $no_cover_url;

if(isset($_GET["old_title"]))
{
	$old_title = $_GET["old_title"];
}
else
{
	if(empty($old_title))
	{
		$old_title = asc2hex($title);
	}
}
//Search: Music; MusicTracks; MP3Downloads; DVD; 
//$song = "O Jah";
//$artist = "Paul Wilbur";
//$title = (!empty($song) ? trim($song) : trim($title)) . " - " . (!empty($artist) ? trim($artist) : trim($title));
if($picture == "cover")
{	//Try FavIcon.Ico if a site is found in song title as temp Logo
	$url_picture = song_siteInfo($artist, $song, $url_picture, 'url_picture');	
	//Try site url inside song title
	$url_info = song_siteInfo($artist, $song, $no_cover_url, 'url_info');
	//Try Last.FM Api
	$url_picture = aws_getInfo($artist, $song, 'track', 'url_picture', $url_picture);	
	$url_info = aws_getInfo($artist, $song, 'track', 'url_info', $no_cover_url);
	//Try Amazone Commerce Service Api
	if ($url_picture !== $parsed_xml)
	{	
		$search = "DigitalMusic";			
		$parsed_xml = aws_signed_request(array("AssociateTag"=>"knas-20", "Operation"=>"ItemSearch", "SearchIndex"=>$search, "ResponseGroup"=>"Medium,Offers", "Keywords"=>clean_string_alpha_num($title)), $title, $curl);
			
		if ($parsed_xml === false)
		{
			$search = "MP3Downloads";
			$parsed_xml = aws_search_album(array("AssociateTag"=>"knas-20", "Operation"=>"ItemSearch", "SearchIndex"=>$search, "ResponseGroup"=>"Medium,Offers", "Keywords"=>clean_string_alpha_num($title)), $title, $curl);
		}
				
		$data = @is_object($parsed_xml) ? aws_get_wanted_data($parsed_xml) : "";				
		if(is_array($data))
		{
			$url_picture = ($url_picture != 'nochange') ? $url_picture : $data[0];
			$url_info = ($url_info != $no_cover_url) ? $url_info : $data[1];
		}
				
		if (isset($parsed_xml->Items->Item->SmallImage->URL))
		{
			$url_picture = ($url_picture != 'nochange') ? $url_picture : $parsed_xml->Items->Item->SmallImage->URL;
			$url_info = ($url_picture != 'nochange') ? $url_picture : $parsed_xml->Items->Item->DetailPageURL;
		}
	}
	
	if ($url_picture == "nochange")
	{
		if($fallback == "logo")
		{
			$url_picture = (empty($full_logo_url)) ? $module_root_bang . "logos/" . $logo_name : $full_logo_url;
		}
		else
		{
			$url_picture = $module_root_bang. "skins/" . SKIN . "/equalizer_play.gif";
		}			
	}
}

if($picture == "logo")
{
	$url_picture = (empty($full_logo_url)) ? $module_root_bang . "logos/" . $logo_name : $full_logo_url;
	//Try FavIcon.Ico if a site is found in song title
	$url_picture = song_siteInfo($artist, $song, $url_picture, 'url_picture');	
}

//Blank Picture check for Curenct Picture ver 3.x
if (empty($url_picture))
{
	if($fallback == "logo")
	{
		$url_picture = (empty($full_logo_url)) ? $module_root_bang . "logos/" . $logo_name : $full_logo_url;
	}
	else
	{
		$url_picture = $module_root_bang. "skins/" . SKIN . "/equalizer_play.gif";
	}			
}

$old_title = asc2hex($currentsong);

if($mode == 'url_picture')
{
	die("$url_picture");
}
else
{
	die("$$mode");
}

?>