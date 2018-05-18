<?php
/**
*
* @package MX-Publisher Module - mx_dev_startkit
* @version $Id: startkit_constants.php,v 1.6 2008/06/03 20:07:27 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

// ---------------------------------------------------------------------START
// This file defines specific constants for the module
// -------------------------------------------------------------------------
define( 'STARTKIT_CONFIG_TABLE', $mx_table_prefix . 'dev_startkit_config' );

//
// Module Copyrights
//
if (is_object($mx_page))
{
	// -------------------------------------------------------------------------
	// Extend User Style with module lang and images
	// Usage:  $mx_user->extend(LANG, IMAGES)
	// Switches:
	// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
	// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
	// -------------------------------------------------------------------------
	$mx_user->extend();

	$mx_page->add_copyright( 'MXP Dev Startkit Module' );
}

// ----------
$phpbb_module_version = "1.0";
$phpbb_module_author = "MXP Team";
?>