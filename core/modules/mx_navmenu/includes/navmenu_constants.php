<?php
/**
*
* @package MX-Publisher Module - mx_navmenu
* @version $Id: navmenu_constants.php,v 1.1 2010/10/16 04:07:19 orynider Exp $
* @copyright (c) 2002-2008 [Martin, Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

// -------------------------------------------------------------------------
// Extend User Style with module lang and images
// Usage:  $mx_user->extend(LANG, IMAGES)
// Switches:
// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
//
// Extend page with additional header or footer data
// Examples:
//	$mx_page->add_css_file(); // Include style dependent *.css file, eg module_path/template_path/template/theme.css
//	$mx_page->add_js_file( 'includes/js.js' ); // Relative to module_root
//	$mx_page->add_header_text( 'header text' );
//	$mx_page->add_footer_text( 'includes/test.txt', true ); // Relative to module_root
//  Note: Included text from file (last example), will evaluate $theme and $mx_block->info variables.
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
		$mx_user->_load_mxbb_images(false);

		// -------------------------------------------------------------------------
		// Do some checks
		// -------------------------------------------------------------------------
		$current_template_path = file_exists( $mx_root_path . $mx_user->current_template_path . "/images" ) ? $mx_user->current_template_path : ( file_exists( $mx_root_path . $mx_user->cloned_template_path . "/images" ) ? $mx_user->cloned_template_path : $mx_user->default_template_path );

		// -------------------------------------------------------------------------
		// Prefix with PORTAL_URL
		// -------------------------------------------------------------------------
		$current_template_images = PORTAL_URL . $current_template_path . "/images";

		// -------------------------------------------------------------------------
		// Define images path
		// -------------------------------------------------------------------------
		$mx_images['mx_menu_images'] = $current_template_images;		
}
?>