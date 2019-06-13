<?php 
/**
*
* @package mxBB Portal Module - mx_shotcast
* @version $Id: shotcast_last10.php,v 1.9 2013/05/29 04:34:03 orynider Exp $
* @copyright (c) 2002-2006 [OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// ERROR HANDLING
//
//error_reporting( E_ALL );
@ini_set( 'display_errors', '1' );

// --------------------------------------------------------------------------------
// Security check
//

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	//die("Hacking attempt");
	$module_root_path = "./";
	$phpEx = substr(strrchr(__FILE__, '.'), 1); 
}

//
// Common Includes and Read Module Settings
//
if( !file_exists($module_root_path . 'includes/common.'.$phpEx) )
{
	mx_message_die(GENERAL_ERROR, "Could not find mx_shotcast includes folder.", "", __LINE__, __FILE__);
}
define('IN_SHOTCAST', true);
include_once($module_root_path . 'includes/common.'.$phpEx);

$bgcolor = '#ffffff'; // Page background color 
$tablew = '100%'; // Table width 
$tableh = '1'; 
$toprow = '#c0c0c0'; // Top background color 
$bottom = '#ffffff'; // Bottom background color 
$border = '#000000'; // Border color 
$thickness = '2'; // Border thickness 
$padding = '4'; // Cell padding 
$font = 'Verdana'; // Font 
$fontsize = '2'; // Font size 
$block_size    = ( isset($block_size) && !empty($block_size) ? $block_size : '100%' );

$refresh = '30'; // How often should it refresh? (seconds) 

// Return JavaScript or HTML 
$jsOutput=FALSE; // TRUE=js | FALSE=HTML 


// try to get the target from the url... 
/*
$caster_ip = $_REQUEST[host]; 
if (!$caster_ip) $caster_ip = $yourIP; 
$caster_port = $_REQUEST[port]; 
if (!$caster_port) $caster_port = $yourPORT; 
*/

//$caster_ip = $shotcast_config['shotcast_host'];	// IP adress or domain 
//$caster_port = $shotcast_config['shotcast_port'];	// Port

if( empty($lang['Before_that_you_heard']) && empty($lang['Now_Playing']) )
{ 
	$lang['Before_that_you_heard'] = "Before that you heard";
	$lang['Now_Playing'] = "Now Playing"; 
	$lang['Off_Air'] = "The server is <b>Off-Air</b>, try again later."; 
}

$lf = chr(10); // 0x0A [\n] 

// The lastN is configurable at the DNAS with, ShowLastSongs= it defaults to 10 and has a maximum of 20 
$n = 10;
$t_max = $n; 
if (!$t_max || $t_max < 1 || $t_max > 19) $t_max = 10; 
//19 is the max here because 20=current_track+19 

// Let's get /index.html first... to keep this short, there is no code to handle the dnas being down 
// or not running, so the script will display nothing in those cases. 

$connect_timeout=5; 
$success=0; 

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

if (@phpversion() >= '5.0.0') { $state = "Up"; } else { $state = "Down"; }
if (@phpversion() < '5.0.0') { $state = "Up"; }
$song00 = $currentsong;
//$fp1 = @fsockopen($shout_caster_ip, $shout_caster_port, $errno, $errstr, 5); //open connection 
$fp = @fsockopen($shout_caster_ip, $shout_caster_port, $errno, $errstr, 5); //open connection  
if(!$fp) 
{ 
	//if connection could not be made 
	@fclose($fp); 
	//$success++; 
} 
else
{
	@fputs($fp, "GET /played.html HTTP/1.0\r\nUser-Agent: SHOUTcast DNAS Status Getter (Mozilla Compatible)\r\n\r\n"); 
	$page = "";
	while(!feof($fp))
	{
		$page .= fgets($fp, 1000);
	}
	$page = preg_replace("~.*Server Status:~", "", $page); //extract data
	$page = preg_replace("~</b></td></tr></table><br>.*~", "", $page); //extract data
	$page_array = preg_split('~(</?[^>]+>)~' , $page, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
	$played_html = $page; 
	if ($played_html) 
	{ 
		$played_html = preg_replace('~<x>~','|-|', preg_replace('~</tr>~','', preg_replace('~</td><td>~','<x>', preg_replace('~<tr><td>~','', preg_replace('~</tr>~', '</tr>' . $lf, preg_replace('~-->~','--]', preg_replace('~<!--~','[!--', preg_replace('~</table><br><br>.*~','', preg_replace('~.*<b>Current Song</b></td></tr>~','',$played_html))))))))); 
		$xxn = strlen($played_html); 
		$r = 2; 
		$t_count = 0; 
		$reading = 0; 
		$track[0] = $song00; 
		while ($r < $xxn & $t_count <= $t_max)
		{ 
			$cur = substr($played_html, $r, 1); 
			if ($cur == $lf) { $reading = 0; } 
			if ($reading == 1) { @$track[$t_count] .= $cur; } 
			if ($cur == "|" & substr($played_html,$r-1,1) == "-" & substr($played_html,$r-2,1) == "|") 
			{ 
				$reading = 1; 
				$t_count++; 
			} 
			$r++; 
		} 
	}
}
@fclose($fp); //close connection 		

// I now have $track[0-N] containg the current plus last N tracks... 
// Output time... 
if (!empty($er))
{
	// I couldn't connect to the DNAS  
	$r = 0; 
	$output_string = '';
	$output_string .= '<table width="' . $tablew . '" height="' . $tableh . '" class="forumline" border="' . $thickness . '" bordercolor="' . $border . '"><tr bgcolor="' . $toprow . '"><td vAlign=top> 
	<table width="100%" border="0" cellpadding="' . $padding . '"><tr><td> 
	<font face=' . $font . ' size=' . $fontsize . '>' . $er; //Now playing... 
	if ($success != 0) 
	{
		$output_string .= '<td><tr>'; 
	}

	if ($success == 0) 
	{
		while ($r <= $t_max)
		{ 
			if ($r==0) 
			{
				$output_string .= '<tr><td vAlign=top> ' . $lang['Before_that_you_heard'] . ' :</i><br><br>'; 
			}
			else
			{
				$output_string .= str_replace("'", "'",str_replace('"', '"',$track[$r])) . '<br>'; 
			}
			$r++; 
		}
	}
	// I also want to close the table code now.... 
	$output_string .= '</td></tr></font></td></tr></table></td></tr></table>'; 
 
	echo $output_string . ''; 
}
else if ($success == 0 && $state == "Up") 
{ 
	echo " <table width=\" . $block_size . \" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"forumline\">\n";
	$r = 0; 
	$output_string=''; 

	//tweak the output string (the table init) here.... 
	$output_string .= '<table width="' . $tablew . '" height="' . $tableh . '" class="forumline" border="' . $thickness . '" bordercolor="' . $border . '"><tr bgcolor="' . $toprow . '"><td vAlign=top> 
	<table width="100%" border="0" cellpadding="' . $padding . '"><tr><td vAlign=top> 
	<font face=' . $font . ' size=' . $fontsize . '>'; //Now playing... 

	while ($r <= $t_max)
	{ 
		if ($r == 0) 
		{
			$output_string .= $lang['Now_Playing'] . ': <A><b>'.str_replace("'", "'",str_replace('"', '"',$track[$r])).'</b></A></td></tr></table></td></tr><tr><td><table bgcolor=' . $bottom . ' width="100%" border="0" cellpadding="' . $padding . '"><tr><td><br><font face=' . $font . ' size=' . $fontsize . '> ' . $lang['Before_that_you_heard'] . ' :<b><br><br>'; 
		}
		else 
		{
			$output_string .= str_replace("'", "'",str_replace('"', '"', @$track[$r])) . '<br>'; 
		}
		$r++; 
	}
	// I also want to close the table code now.... 
	$output_string .= '</b></font></td></tr></table></td></tr></table>'; 
 
	echo $output_string . '';  

} 
else 
{ 
	// I couldn't connect to the DNAS  
	$r = 0; 
	$output_string = '';
	$output_string .= '<table width="' . $tablew . '" height="' . $tableh . '" class="forumline" border="' . $thickness . '" bordercolor="' . $border . '"><tr bgcolor="' . $toprow . '"><td vAlign=top> 
	<table width="100%" border="0" cellpadding="' . $padding . '"><tr><td> 
	<font face=' . $font . ' size=' . $fontsize . '>' . $lang['Off_Air']; //Now playing... 
	if ($success != 0) 
	{
		$output_string .= '<td><tr>'; 
	}

	if ($success == 0) 
	{
		while ($r <= $t_max)
		{ 
			if ($r == 0) 
			{
				$output_string .= '<tr><td vAlign=top> ' . $lang['Before_that_you_heard'] . ' :</i><br><br>'; 
			}
			else
			{
				$output_string .= str_replace("'", "'",str_replace('"', '"',$track[$r])) . '<br>'; 
			}
			$r++; 
		}
	}
	// I also want to close the table code now.... 
	$output_string .= '</td></tr></font></td></tr></table></td></tr></table>'; 
 
	echo $output_string . '';  
} 
?> 
