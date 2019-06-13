<?php
/**
*
* @package MX-Publisher Module - mx_mod_rewrite
* @version $Id: rewrite_constants.php,v 1.7 2013/06/28 15:35:15 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

// -------------------------------------------------------------------------
// Extend User Style with module lang and images
// Usage:  $mx_user->extend(LANG, IMAGES)
// Switches:
// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
// -------------------------------------------------------------------------
$mx_user->extend(MX_LANG_MAIN, MX_IMAGES_NONE);

//
// Module Copyrights
//
if (is_object($mx_page))
{
	$mx_page->add_copyright( 'MX-Publisher mod_rewrite' );
}

// ----------
$phpbb_module_version = "1.0";
$phpbb_module_author = "MX-Publisher Team";
?>