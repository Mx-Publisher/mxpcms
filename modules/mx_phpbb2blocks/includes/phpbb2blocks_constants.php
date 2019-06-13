<?php
/**
*
* @package MX-Publisher Module - mx_phpbb2blocks
* @version $Id: phpbb2blocks_constants.php,v 1.6 2013/06/28 15:36:42 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( PORTAL_BACKEND != 'phpbb2' )
{
	mx_message_die(GENERAL_MESSAGE, 'There are blocks on this page designed for MX-Publisher with phpBB2 backend, thus not compatible with current setup.');
}

// -------------------------------------------------------------------------
// Footer Copyrights
// -------------------------------------------------------------------------
if (is_object($mx_page))
{
	// -------------------------------------------------------------------------
	// Extend User Style with module lang and images
	// Usage:  $mx_user->extend(LANG, IMAGES)
	// Switches:
	// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
	// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
	// -------------------------------------------------------------------------
	$mx_user->extend(MX_LANG_MAIN, MX_IMAGES);
}
?>