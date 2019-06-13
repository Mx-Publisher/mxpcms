<?php
/********************************* EDIT DISPLAY ******************************/

// !!!DONT TOUCH IF U DONT KNOW WHAT U ARE DOING!!!
// 
// Here u can change ure title and info to whatever u want it to be... and
// it's easy as pie. ;)
// Here U have a couple of pre defined values that u can use.
// They are:
// 1. $a - The song that is playing now.
// 2. $b - How many listeners there are online now.
// 3. $c - Maximum amount of listeners that can connect. (Only ShotCast)
// 4. $d - What type format ure sending in mpeg or acc.
// 5. $e - The genre of your server.
// 6. $f - The bitrate ure sending in.
// 7. $g - Maximum amount of listeners u ever had connected.
// And if u are running ice cast then u have some more variables.
// They are:
// 8. $h - Server name.
// 9. $i = Server description.
// 10. $j = Quality.
// 11. $k = Video quality.
// 12. $l = Frame size.
// 13. $m = Frame rate.
// 14. $n = Server URL.
// 15. $o = Artist.
//
// So how do u make ure own pretty title?
// Here are some exmples:
//
// 1. 
// $title = "Now playing: $a  ($b/$c)";
// The player title would now show e.g. 
// "Now playing: Frodo United - Gandalf song (63/120)"
//
// 2. 
// $title = "$a";
// The player title would now show e.g. 
// "Happy Hamster - Hardcore pimpin"
//
// 3. 
// $title = "U are now listening to $a in $f kbps. U are one of $b listeners.";
// The player title would now show e.g. 
// "U are now listening to 1 hour - Jet engine sound in 32 kbps. U are one of 25 listeners."
//
// Radio title
//E.g. $title = "$a";
$title = "$a";

//HTML TITLE /TITLE TAG and Status
$title_bar = $lang['Radio_Player']." &bull; ".$station_name;
$title_tag = $lang['Radio_Player']." &bull; ".$station_name;

// There are four lines of info u can change to whatever u like. Dont use text that is to long
// couse it may damage the apperence of the player.
// First info
$firstinfo = $lang['listeners'].": $b";

// Second info
$secondinfo = $lang['Server_genre']." $e";

// Third info
$thirdinfo = $lang['Bitrate']." $f";

// Forth info
$forthinfo = " $d";

// How often to update title (miliseconds). To low value is not good. U might hammer your
// server to death.
$update_title = "5000";
//************************* DO NOT EDIT BELOW THIS LINE *********************/
?>