<?php 

include "shotcast_config.php";

$ficdest = "http://" . $scip . ":" . $scport . "/7.html";

// $ficdest = "7.html";

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

echo $text[0] . "," . $state . "," . $currentlisteners . "," . $maxlisteners . "," . $uniq . "," . $bitrate . "," . $song[0];
 
?>