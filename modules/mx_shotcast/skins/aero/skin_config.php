<?php
/** Original skin by:
*
* copyright (C) 2007-2013 OryNider 
* www.pubory.uv.ro
* < orynider@rdslink.ro > (Florin C Bodin)
*
*/
$text_color = "#FFFF00";
$current_color = "#fffff4";
$normalbg = "#000000";
$selectedbg = "#808000";
$displayfont = "Arial Narrow";
$background_color = "#ffffff";
$link_color = "#8a99f4";
$vlink_color = "#006699";
$alink_color = "#006699";
$hlink_color = "#f3a625";
$selectbox_color = "#0c4596";
$selectbox_text_color = "#ffffff";
// Skin Graphics
$skininfo = array(); //Do not edit here
$current_color = (@song_siteInfo($artist, $song, $no_cover_url, 'url_info') !== $no_cover_url) ? $link_color : $current_color;
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
$skininfo['image'] = "1"; //Valid values are: 0 for small; 1 for medium; 2 for large; and 3 for eXtrem large;
$skininfo['version'] = "3";
$skininfo['subversion'] = "5";
$skininfo['name'] = "aero";
$skininfo['comment'] = "This is the skin based on original skin v2.0 made by Niklas Pull aka Little Frog.";
$skininfo['author'] = "OryNider";
$skininfo['email'] = "orynider@rdslink.ro";
$skininfo['homepage'] = "http://pubory.uv.ro/";
$skininfo['screenshot'] = "screenshot.png";
$css = "
<style type=\"text/css\">
<!--
* {
	margin: 0;
	padding: 0; 
	font-family: Trebuchet MS, Lucida Grande, Verdana, Helvetica, Arial, sans-serif;
	font-size: 10px; 
}
body {
	margin: 0;
	padding: 0; 
	font-family: Trebuchet MS, Lucida Grande, Verdana, Helvetica, Arial, sans-serif;
	font-size: 10px; 
	color: " . $background_color . ";
	BACKGROUND-IMAGE: url('" . $module_root_path . "skins/" . $radio_skin . "/playerbg.png');
}
a, a:visited, a:active{
	text-decoration: none;
	color: #8a99f4;
	border: 0px;
}
/* General markup styles
---------------------------------------- */
* {
	font-size: 100%;
}

body, div, p, th, td, li, dd {
	voice-family: \"\\\"}\\\"\";
	voice-family: inherit;
}

html {
	/* Always show a scrollbar for short pages - stops the jump when the scrollbar appears. non-ie browsers */
	height: 100%;
	margin-bottom: 1px;
}

/* General font families for common tags */
font,th,td,p { font-family: Trebuchet MS, Lucida Grande, Verdana, Helvetica, Arial, sans-serif; }

img {
	border: 0;
}
a, a:visited, a:active{
	text-decoration: none;
	color: " . $link_color . ";
	border: 0px;
}
select{
	font-family: Helvetica, Lucida Grande, Verdana, Helvetica, Arial, sans-serif;
	font-size: 10px;
	background-color: " . $selectbox_color . ";
	color: " . $selectbox_text_color . ";
	border: 0px;
}
station{
	font-weight: bold; 
	font-size: 12px;
	font-family: Calibri, Helvetica, sans-serif;
}
#shell{
	background-image: url('" . $module_root_path . "skins/" . $radio_skin . "/shell.png');
	width: 320px;
	height: 142px;
	left: 0px;
	top: 0px;
	position: absolute;
}
#station{
	left: 5px;
	top: 5px;
	position: absolute;
}
#display{
	width: 300px;
	height: 24px;
	left: 10px;
	right: 10px;
	top: 30px;
	font-weight: bold; 
	font-size: 12px; 
	font-family: Calibri, Trebuchet MS, Lucida Grande, Helvetica, Verdana, sans-serif;
	display: inline;
	position: absolute;
}
#songtitle{
	right: 8px;
	top: 30px;
	display: inline;	
	position: absolute;
	font-family: ".$displayfont.", Trebuchet MS, Calibri, Lucida Grande, Helvetica, Verdana, sans-serif;
	font-weight: bold;
	color: " . $current_color . ";	
	width: 214px;
}
#songtitle{
	width: 305px;
}
#currentlisteners{
}
#streamtitle{
	width: 211px;
	left: 10px;
	top: 37px;
	font-weight: bold; 
	font-size: 12px; 
	font-family: Calibri, Trebuchet MS, Lucida Grande, Helvetica, Verdana, sans-serif;
	position: absolute;
}
#listeners{
	left: 123px;
	top: 53px;
	position: absolute;
	width: 130px;	
}
#servergenre{
	left: 143px;
	top: 65px;
	position: absolute;
}
#contentType{
	left: 143px;
	top: 77px;
	position: absolute;
}
#bitrate{
	left: 143px;
	top: 89px;
	position: absolute;
}
#firstinfo{
	left: 137px;
	top: 56px;
	position: absolute;
	float:left;
}
#secondinfo{
	left: 133px;
	top: 67px;
	position: absolute;
}
#thirdinfo{
	left: 133px;
	top: 80px;
	position: absolute;
}
#forthinfo{
	left: 137px;
	top: 92px;
	position: absolute;
}
#play{
	left: 10px;
	top: 110px;
	position: absolute;
}
#stop{
	left: 45px;
	top: 115px;
	position: absolute;
}
#select{
	right: 10px;
	top: 117px;
	position: absolute;
}
#select{
	left: 220px;
	top: 110px;
	position: absolute;
}
#infoPlayer{
	left: 10px;
	top: 60px;
	position: absolute;
}
#infoPlayer{
	left: 8px;
	top: 60px;
	position: absolute;
}
#embedFrame{
	left: 4px;
	right: 4px;
	top: 70px;
	position: absolute;	
}
#infoPlugin{
	left: 20px;
	top: 74px;
	position: absolute;
}
#infoPlugin{
	left: 8px;
	top: 79px;
	position: absolute;
}
#equalizer{
	left: 236px;
	top: 54px;
	position: absolute;
}
#equalizer{
	left: 220px;
	top: 34px;
	position: absolute;
}
#eq{
	left: -7px;
	top: -7px;
	width: 98px;
	height: 80px;	
	display: inline;	
	position: absolute;	
}
#cover_url{
	text-decoration: underline;
	color: " . $link_color . ";
}
#closeButton{
	left: 300px;
	top: 2px;
	position: absolute;
}
-->
</style>";
?>