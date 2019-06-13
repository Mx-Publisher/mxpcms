<?php
/**
*
* @package StandAllone - Radiplayer.
* @version $Id: css.php,v 1.1 2013/05/28 07:14:34 orynider Exp $
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
function css()
{
	global $module_root_path, $css, $radio_skin, $default_skin, $phpEx;

	if ((@require $module_root_path . "skins/" . SKIN . "/skin_config.$phpEx") === false)
	{
		if ((@require $module_root_path . "skins/" . SKIN . "/skin_config.$phpEx") === false)
		{
				die('Requested skin and default skin configuration file couldn\'t be found.');
		}
	}		
	$css = !empty($css) ? $css : "
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
		color: #ffffff;
		BACKGROUND-IMAGE: url(\"". $module_root_path . "skins/" . SKIN . "/playerbg.png\");
	}
	a, a:visited, a:active{
		text-decoration: none;
		color: " . $link_color . ";
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
		background-image: url('" . $module_root_path . "skins/" . SKIN . "/shell.png');
		width: 320px;
		height: 142px;
		left: 0px;
		top: 0px;
		position: absolute;
	}
	#station{
		left: 12px;
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
		color: " . $text_color . ";	
		font-family: ".$displayfont.", Trebuchet MS, Calibri, Lucida Grande, Helvetica, Verdana, sans-serif;
		display: inline;
		position: absolute;
	}
	#songtitle{
		right: 98px;
		top: 30px;
		font-family: ".$displayfont.", Trebuchet MS, Calibri, Lucida Grande, Helvetica, Verdana, sans-serif;
		font-weight: bold;
		color: " . $current_color . ";			
		display: inline;	
		position: absolute;
		font-weight: bold;	
		width: 214px;
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
	#bitrate{
		left: 138px;
		top: 53px;
		position: absolute;
	}
	#servergenre{
		left: 137px;
		top: 65px;
		position: absolute;
	}
	#contentType{
		left: 138px;
		top: 77px;
		position: absolute;
	}
	#listeners{
		left: 138px;
		top: 89px;
		position: absolute;
		width: 130px;		
	}
	#firstinfo{
		left: 137px;
		top: 53px;
		position: absolute;
		float:left;
	}
	#secondinfo{
		left: 137px;
		top: 66px;
		position: absolute;
	}
	#thirdinfo{
		left: 137px;
		top: 79px;
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
	#embedFrame{
		left: 4px;
		right: 4px;
		top: 64px;
		position: absolute;	
	}	
	#infoPlayer{
		left: 10px;
		top: 60px;
		position: absolute;
	}
	#infoPlugin{
		left: 20px;
		top: 74px;
		position: absolute;
	}
	#equalizer{
		left: 236px;
		top: 26px;
		position: absolute;
	}
	#eq{
		top: 3px;
		width: 75px;
		height: 75px;	
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

	return $css;
}
?>
