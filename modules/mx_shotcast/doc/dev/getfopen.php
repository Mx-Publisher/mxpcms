<?php
 
ini_set("display_errors", "0");

include "shotcast_config.php";

$ficdest = "http://" . $scip . ":" . $scport . "/7.html";

function ServerLive($ficdest)
{
 return fopen($ficdest, 'r');
}

function fgetdata($compteur)
{
  global $compteur, $old_text;

  while (!feof($compteur)) {
  $old_text .= strip_tags(fgets($compteur, 1024));
  }
}

// if(file_exists($ficdest)) {		// use this for localhost

if(ServerLive($ficdest)) {
     $compteur = fopen("$ficdest", "r");
     fgetdata($compteur);
     fclose($compteur);
     list($text[0], $state, $currentlisteners, $maxlisteners, $uniq, $bitrate, $song[0]) = split('[,.-]', $old_text); 
} 
else {  
     $text[0] ="1";
     $state = "1";
     $currentlisteners = "11";
     $uniq = "1"; 
     $bitrate = "56";  
     $song[0] = "Unknon Artist";
     $maxlisteners = "32";
     } 

// $shoutcastserver = $shotcast_config['shotcast_name'];
// $servertitle = $shotcast_config['shotcast_name'];
 
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