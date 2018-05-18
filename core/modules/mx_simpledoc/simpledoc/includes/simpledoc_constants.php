<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: simpledoc_constants.php,v 1.6 2008/06/03 20:14:11 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

// -------------------------------------------------------------------------
// This file defines specific constants for the module
// -------------------------------------------------------------------------

// -------------------------------------------------------------------------
// Style
// -------------------------------------------------------------------------
$mx_user->set_module_default_style('_core'); // For compatibility with core 2.8.x

if (is_object($mx_page))
{
	// -------------------------------------------------------------------------
	// Extend User Style with module lang and images
	// Usage:  $mx_user->extend(LANG, IMAGES)
	// Switches:
	// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
	// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
	// -------------------------------------------------------------------------
	$mx_user->extend(MX_LANG_ALL, MX_IMAGES_NONE);

	$mx_page->add_copyright( 'MX-Publisher - SimpleDoc' );
}
?>