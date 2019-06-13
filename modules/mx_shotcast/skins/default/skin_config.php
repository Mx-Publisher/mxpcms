<?php
/** Original skin by:
*
 copyright (C) 2007-2010 DrKnas
* http://forums.winamp.com/member.php?u=271283
* 
*
*/
$text_color = "#fFFFFf";
$current_color = "#8s89f4";
$normalbg = "#000000";
$selectedbg = "#808000";
$displayfont = "Arial Narrow";
$background_color = "#ffffff";
$link_color = "#aa66ff";
$vlink_color = "#006699";
$alink_color = "#006699";
$hlink_color = "#f3a625";
$selectbox_color = "#0c4596";
$selectbox_text_color = "#ffffff";
// Skin Graphics
$current_color = (@song_siteInfo($artist, $song, $no_cover_url, 'url_info') !== $no_cover_url) ? $link_color : $current_color;
$skininfo = array(); //Do not edit here
$skininfo['body_bgcolor'] = $background_color;
$skininfo['body_text'] = $text_color;
$skininfo['body_link'] = $link_color;
$skininfo['body_vlink'] = $vlink_color;
$skininfo['body_alink'] = $alink_color;
$skininfo['body_hlink'] = $hlink_color;
$skininfo['display_text'] = $current_color;
$skininfo['display_font'] = $displayfont;
$skininfo['display_fontSize'] = "12";
$skininfo['display_width'] = "211";
$skininfo['display_height'] = "24";
$skininfo['display_left'] = "10";
$skininfo['display_right'] = "10";
$skininfo['display_top'] = "30";
$skininfo['display_style'] = "white-space:nowrap;color:".$current_color." !important;background-color:transparent;text-align:center;blabla:5;";
$skininfo['image'] = "0"; //Valid values are: 0 for small; 1 for medium; 2 for large; and 3 for eXtrem large;
$skininfo['version'] = "4";
$skininfo['subversion'] = "9";
$skininfo['name'] = "system";
$skininfo['comment'] = "This is the skin based on original skin v2.0 made by Niklas Pull aka Little Frog.";
$skininfo['author'] = "DrKnas";
$skininfo['email'] = "";
$skininfo['homepage'] = "";
$skininfo['screenshot'] = "screenshot.png";
	
?>