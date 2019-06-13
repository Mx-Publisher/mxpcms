<?php
/**
*
* @package mxBB Portal Module - mx_shotcast
* @version $Id: getinfo2_faenabled.php,v 1.2 2007/10/02 04:41:40 orynider Exp $
* @copyright (c) 2002-2006 [OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

/***************************************************************************
 * mx_shotcast
 ***************************************************************************
 * History:
 *OryNider (16/09/2006) : 1st try
 * 2007/01/27
 * -modified by OryNider to work if URL file-access is not disabled in the
 * server configuration
 ***************************************************************************/

$phpEx = substr(strrchr(__FILE__, '.'), 1);
include_once($mx_root_path . 'common.'.$phpEx);

//
// Start session management
//
// $mx_user->init($user_ip, PAGE_INDEX); 

define('_SHOTCAST_CONFIG', true);
include_once($mx_module_path .'includes/common.'.$phpEx);

/*
if ( !$userdata['session_logged_in'] )
{
	redirect(append_sid(PHPBB_URL . "login.".$phpEx."?redirect=chat.".$phpEx, true));
	exit;
}
*/

  //
  // End session management
  //

// include_once($mx_module_path .'player.'.$phpEx);

$time=date("U");
$mx_user->init($user_ip, PAGE_INDEX);
$nick = str_replace(" ", "_", $userdata['username']);

if ($_POST['update']==true)
{
update_shotcast_user($nick,$time);
}

//read check period
$period=$shotcast_config['check_period']*1000;
$station = $shotcast_config['shotcast_name'];	// Station name
$scip = $shotcast_config['shotcast_host'];	// IP adress or domain
$scport = $shotcast_config['shotcast_port'];	// Port               
$scpass = $shotcast_config['shotcast_pass'];	// SHOUTcast Password

ini_set("display_errors", "0");

$ficdest = "http://" . $scip . ":" . $scport . "/7.html";

function ServerLive($ficdest)
{
 return fopen($ficdest, 'r');
}

if((ServerLive($ficdest)) && (@phpversion() >= '5.0.0')) {
  $open = fsockopen($scip,$scport); 
  if ($open) { 
  fputs($open,"GET /7.html HTTP/1.1\nUser-Agent:Mozilla\n\n"); 
  $read = fread($open,1000); 
  $text = explode("content-type:text/html",$read); 
  $text = explode(",",$text[1]);
  fclose($open); 
  } else { $er="Connection Refused!"; }
}

if(ServerLive($ficdest)) {
  //$scfp = fsockopen($scip, $scport, &$errno, &$errstr, 1);
  $scfp = fsockopen($scip, $scport);
   if(!$scfp) {
    $scsuccs=1;
   }
  if($scsuccs!=1){
   fputs($scfp,"GET /admin.cgi?pass=$scpass&mode=viewxml HTTP/1.0\r\nUser-Agent: SHOUTcast Song Status (Mozilla Compatible)\r\n\r\n");
   while(!feof($scfp)) {
    $page .= fgets($scfp, 1000);
   }


   $loop = array("STREAMSTATUS", "BITRATE", "SERVERTITLE", "CURRENTLISTENERS", "MAXLISTENERS", "BITRATE", "SERVERGENRE", "SONGURL", "SERVERURL", "REPORTEDLISTENERS");
   $y=0;
   while($loop[$y]!=''){
    $pageed = ereg_replace(".*<$loop[$y]>", "", $page);
    $scphp = strtolower($loop[$y]);
    $$scphp = ereg_replace("</$loop[$y]>.*", "", $pageed);
    if($loop[$y]==SERVERGENRE || $loop[$y]==SERVERTITLE || $loop[$y]==SONGTITLE || $loop[$y]==SERVERTITLE)
     $$scphp = urldecode($$scphp);

    $y++;
   }

   $pageed = ereg_replace(".*<SONGHISTORY>", "", $page);
   $pageed = ereg_replace("<SONGHISTORY>.*", "", $pageed);
   $songatime = explode("<SONG>", $pageed);
   $r=1;
   while($songatime[$r]!=""){
    $t=$r-1;
    $playedat[$t] = ereg_replace(".*<PLAYEDAT>", "", $songatime[$r]);
    $playedat[$t] = ereg_replace("</PLAYEDAT>.*", "", $playedat[$t]);
    $song[$t] = ereg_replace(".*<TITLE>", "", $songatime[$r]);
    $song[$t] = ereg_replace("</TITLE>.*", "", $song[$t]);
    $song[$t] = urldecode($song[$t]);
    $dj[$t] = ereg_replace(".*<SERVERTITLE>", "", $page);
    $dj[$t] = ereg_replace("</SERVERTITLE>.*", "", $pageed);
  $r++;
   }

  fclose($scfp);
  }
} 

if(isset($_GET['status'])){
  $status = $_GET['status'];
} else{
  $status = "stop";
}
if(isset($_GET['z'])){
  $z = $_GET['z'];
} else{
  $z = "wmp";
}

if ($z == 'wmp'){
  $mode = 'real';
} elseif ($z == 'real'){
  $mode = 'wmp';
}
?>