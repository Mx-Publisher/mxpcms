<?php
/**
*
* @package Mx-Publisher StandAllone - radioplayer
* @version $Id: moreinfo.php,v 1.7 2013/05/28 07:14:33 orynider Exp $
* @copyright (c) 2002-2006 [OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/
// History:
// Little Frog (v 1.x - 2.x)
// OryNider (v 1.x - 3.x)
// DrKnas (v 4.0 - 4.2.x)
// OryNider (Current maintainer: 3.5.x & 4.9.x & mxpcms versions)
$module_root_path = "./";
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$is_block = FALSE;
define('IN_SHOTCAST', true);
require($module_root_path .'includes/common.'.$phpEx);
 
print '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>' . 'Radio Player :: '.$station_name.'</title>
<style type="text/css">
<!--
body {margin:0; padding: 0; BACKGROUND-IMAGE: url(\''. $module_root_path . "images/" . SKIN . '/iframe_bg.png\'); font-family: Verdana; font-size: 10px}
a{text-decoration:none; background-color:inherit; color:#26c;}
a:hover{text-decoration:underline;}
.main {position: relative; left: 0px; top: 0px; margin:0; padding:0; background-image: url(\''. $module_root_path . "images/" . SKIN . '/player.png\'); background-repeat: no-repeat; background-attachment: fixed; background-color: #eeeeee}
.display_low {position: relative; left: 3px; top: 3px;}
.table {font-family: Verdana; font-size: 10px;}
td.nav { background: #cccddd; border-top: 1px solid #FFFFFF; border-bottom: 1px solid #859288; padding: 1px 0 1px 5px; color: #000333; font-weight: bold; font-size: 12px}
td.stat { background: #ccccde; border-top: 1px solid #FFFFFF; border-bottom: 1px solid #859288; padding: 1px 0 1px 5px;}
-->
</style>
</head>
<body>
<div id="main">
   </div>
  </div>
  <div id="display_low">
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
    </tr>
    <tr class="table">
     <td class="nav" align="left" valign="bottom">
      <h8><b>Stats for <i>'.$servertitle.'</i></b></h8>
      </td>
    </tr>
    <tr class="table">
     <td class="stat" align="left" valign="bottom">
      <b>Server State: <i>'.$state.'</i></b>
      </td>
    </tr>
    <tr class="table">
     <td class="stat" align="left" valign="bottom">
      <i>Stream Title: <b>'.$stream_title.'</b></i>
      </td>
    </tr>
    <tr class="table">
     <td class="stat" align="left" valign="bottom">
      <i>Content Type: <b>'.$mimetype.'</b></i>
      </td>
    </tr>
    <tr class="table">
     <td class="stat" align="left" valign="bottom">
      <i>Stream Genre: <b>'.$stream_genre.'</b></i>
      </td>
    </tr>
    </tr>
    <tr class="table">
     <td class="stat" align="left" valign="bottom">
      <i>Current Song: <b>'.$currentsong.'</b></i>
      </td>
    </tr>
    </tr>
    <tr class="table">
     <td class="stat" align="left" valign="bottom">
      <i>BitRate: <b>'.$bitrate.' kbps</b></i>
      </td>
    </tr>
    <tr class="table">
     <td class="stat" align="left" valign="bottom">
       <i>Listeners Peak: <b>'.$currentlisteners.'</b></i>
      </td>
    </tr>
    <tr class="table">
     <td class="stat" align="left" valign="bottom">
     <i>Max Listeners: <b>'.$maxlisteners.'</b></i></td>
    </tr>
   </table>
     </div>
 </div>
</body>
</html>';
?>