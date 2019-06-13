<?php
/**
*
* @package StandAllone - Radiplayer.
* @version $Id: common.php,v 1.10 2013/05/28 07:14:34 orynider Exp $
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
if (!defined('PORTAL_BACKEND'))
{
	define('MXBB_MODULE', false);
}
else
{
	define('MXBB_MODULE', true);
}

if (!function_exists('file_exists'))
{
    die("file_exists function are not available. The function is probably disabled by the server administrator.");
}
if (!function_exists('preg_replace'))
{
    die("preg_replace function are not available. The function is probably disabled by the server administrator.");
}
if (!function_exists('preg_replace'))
{
    die("preg_replace function are not available. The function is probably disabled by the server administrator.");
}
if (!function_exists('fsockopen'))
{
    die("fsockopen function are not available. The function is probably disabled by the server administrator.");
}
if (!function_exists('fputs'))
{
    die("fputs function are not available. The function is probably disabled by the server administrator.");
}
if (!function_exists('preg_split'))
{
    die("preg_split function are not available. The function is probably disabled by the server administrator.");
}
if (!function_exists('strip_tags'))
{
    die("strip_tags function are not available. The function is probably disabled by the server administrator.");
}

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
	die("Config file: " . $config . " dont exist. Maybe u put a file ending on it (.php). If so try to remove it.");
}
require($config);

if(!defined('PORTAL_URL'))
{

	// Guess at some basic info used for install..
	//like 192.168.0.16
	if (!empty($_SERVER['SERVER_NAME']) || !empty($_ENV['SERVER_NAME']))
	{
		$server_name = (!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : $_ENV['SERVER_NAME'];
	}
	else if (!empty($_SERVER['HTTP_HOST']) || !empty($_ENV['HTTP_HOST']))
	{
		$server_name = (!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : $_ENV['HTTP_HOST'];
	}
	else
	{
		$server_name = $playlist_ip;
	}
	// Get the current server port for player
	if (!empty($_SERVER['SERVER_PORT']) || !empty($_ENV['SERVER_PORT']))
	{
		$server_port = (!empty($_SERVER['SERVER_PORT'])) ? $_SERVER['SERVER_PORT'] : $_ENV['SERVER_PORT'];
	}
	else
	{
		$server_port = ($server_port <> 80) ? ':' . trim($server_port) : '';
	}
	//
	// Get the current document root.
	// like /wamp/www/
	if( isset($_SERVER['DOCUMENT_ROOT']) )
	{
		$document_root = $_SERVER['DOCUMENT_ROOT'];
	}
	elseif( isset($DOCUMENT_ROOT) )
	{
		$document_root = $DOCUMENT_ROOT;
	}
	else
	{
		$document_root = './';
	}
	//Remove drive leter in windows
	$document_root = substr(strrchr($document_root, ':'), 1); 
	$document_root = str_replace('\\', '/', $document_root);
	// Get the lasr path to this  installation.  like /wamp/www/
	$document_bang = explode('/', $document_root);
	$bangs = sizeof($document_bang) - 2;
	$document_bang = $document_bang[$bangs]; 	
	// Get the absolute path to this  installation. like /wamp/www/pub/radioplayer/v4/
	$mx_absolute_path = str_replace('\\', '/', substr(__FILE__, 0, -strlen('includes/'.basename(__FILE__))));
	$script_path = substr(strrchr($mx_absolute_path, $document_bang), 1);
	$server_protocol = ($cookie_secure != false) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($server_name));
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($script_path));
	$script_name = ($script_name == '') ? $script_name : '/' . $script_name;
	define('ADDON_URL', $server_protocol . $server_name . (($server_port != 80) ? ":".$server_port : "") . $script_name . '/' );
	$is_block = false;
}
else
{
	define('ADDON_URL', PORTAL_URL . $module_root_path);
}

if(isset($_GET["language"]))
{
	$language = $_GET["language"];
}
elseif(isset($_GET["lang"]))
{
	$language = $_GET["lang"];
}
else
{
	if(empty($language))
	{
		$language = "english";
	}
}

$clean_language = preg_replace("/[^a-zA-Z0-9_.-@]/", "", $language);
if ((@include_once $module_root_path . "language/lang_" . $clean_language . "/lang_main.$phpEx") === false)
{
	if ((@include_once $module_root_path . "language/lang_english/lang_main.$phpEx") === false)
	{
			die('Language file ' . $module_root_path. "lang_" . $clean_language . "/lang_main.$phpEx" . ' couldn\'t be opened.');
	}
	$default_lang = 'english'; 
}

if(empty($caster_ip))
{
	$caster_ip = "localhost";
	$lang['Off_Air'] = $lang['Edit_Config'];
	@define('SHOTCAST_INSTALLED', false);
}
else
{
	@define('SHOTCAST_INSTALLED', true);
}

if(empty($caster_port))
{
	$caster_port = "8000";
}

if(empty($caster_internal_port))
{
	$caster_internal_port = "8000";
}

if(empty($caster))
{
	$caster = "shout";
}

if(empty($playlist_pls))
{
	$playlist_pls = "listen.pls";
}

if(empty($playlist_ip))
{
	$playlist_ip = $caster_ip;
	$playlist_port = $caster_port;
}

//Setup defualt skin, then overwrite it with your configuration skin
$default_skin = "default";
if(!empty($radio_skin))
{
	$default_skin = $radio_skin;
}
if(isset($_GET["skin"]))
{
	$radio_skin = $_GET["skin"];
}
elseif(isset($_GET["style"]))
{
	$radio_skin = $_GET["style"];
}
else
{
	if(empty($radio_skin))
	{
		$radio_skin = "default";
	}
}

$radio_skin = preg_replace("/[^a-zA-Z0-9_.-@]/", "", $radio_skin);
if (@file_exists($module_root_path . "skins/" . $radio_skin . "/skin_config.$phpEx") === false)
{
	$radio_skin = $default_skin;
	die('Requested skin and default skin configuration file couldn\'t be found.');
}
@define('SKIN', $radio_skin);

if(empty($disable_clean_string))
{
	$disable_clean_string = "no";
}

require($module_root_path ."includes/cast_functions." . $phpEx);
if($caster === "shout")
{
	$icecast_mount_point = "";
	$getinfo = $module_root_path . "includes/getinfo_shout." . $phpEx;
}
else
{
	$getinfo = $module_root_path . "includes/getinfo_ice." . $phpEx;
}
require($getinfo);

//Setup some vars
if(!empty($stream_title))
{
	$station_name = $stream_title;
}
elseif(empty($station_name))
{
	$station_name = "Radio Station";
}

if(!empty($server_name))
{
	$h = $server_name = $station_name;
}
elseif(empty($station_name))
{
	$h = $server_name = "Radio Station";
}

$a = $currentsong;
$b = $currentlisteners;
$c = $maxlisteners;
$d = $mimetype;
$e = $stream_genre;
$f = $bitrate;
$g = $peaklisteners;
$h = $server_name;
$i = $server_description;
$j = $quality;
$k = $video_quality;
$l = $frame_size;
$m = $frame_rate;
$n = $server_url;
$o = $artist;
$p = "";
$q = "";
$r = "";
$s = "";
$t = "";
$u = "";
$v = "";
$w = "";
$x = "";
$y = "";
$z = "";
$update_title = "5000";
$accplugin = 'http://retro-radio.net/plugin/setup_AAC_aacPlus_plugin_1_0_36.exe';
$ff2pluginspace = ($mimetype !== 'audio/aacp') ? 'http://port25.technet.com/videos/downloads/wmpfirefoxplugin.exe' : $accplugin;
$wmp7pluginspace = ($mimetype !== 'audio/aacp') ? 'http://www.microsoft.com/isapi/redir.dll?prd=windows&sbp=mediaplayer&ar=Media&sba=Plugin&' : $accplugin;
$wmp6pluginspace = ($mimetype !== 'audio/aacp') ? 'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715' : 'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715';

if(!empty($stream_title))
{
	$station_name = $stream_title;
}
elseif(empty($station_name))
{
	$station_name = "Radio Station";
}

require($module_root_path ."config/display_config." . $phpEx);
require($module_root_path . "skins/" . $radio_skin . "/skin_config." . $phpEx);
require($module_root_path ."includes/css." . $phpEx);
require($module_root_path ."includes/java_script." . $phpEx);
//require($module_root_path ."includes/cd_cover_getter." . $phpEx); //Removed by DrKnas in v. 4.21 - To do!!!!
$full_wmp_playlist_url = $playlist_ip . ":" . $playlist_port . (!empty($playlist_asx) ? "/" . $playlist_asx : "");
$full_real_and_quick_playlist_url = $playlist_ip . ":" . $playlist_port . (!empty($playlist_pls) ? "/" . $playlist_pls : "");
?>