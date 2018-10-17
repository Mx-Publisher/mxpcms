<?php
/**
*
* @package MX-Publisher Module - mx_users
* @version $Id: users_constants.php,v 1.31 2013/06/17 15:44:18 orynider Exp $
* @copyright (c) 2002-2006 [FlorinCB, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

if (!isset($mx_table_prefix))
{
	$mx_table_prefix = $table_prefix;
}

//
// Field Types
//
@define( 'INPUT', 0 );
@define( 'TEXTAREA', 1 );
@define( 'RADIO', 2 );
@define( 'SELECT', 3 );
@define( 'SELECT_MULTIPLE', 4 );
@define( 'CHECKBOX', 5 );

@define( 'RANKS_PATH', 'images/ranks' );

//$mx_user->set_module_default_style('_core'); // For compatibility with core 2.8.x

if (is_object($mx_page))
{
	// -------------------------------------------------------------------------
	// Extend User Style with module lang and images
	// Usage:  $mx_user->extend(LANG, IMAGES)
	// Switches:
	// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
	// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
	// -------------------------------------------------------------------------
		
	// **********************************************************************
	// First include shared phpBB2 language file 
	// **********************************************************************
	$mx_user->set_lang($mx_user->lang, $mx_user->help, 'lang_main');
		
	if (defined('IN_ADMIN'))
	{
		$mx_user->set_lang($mx_user->lang, $mx_user->help, 'lang_admin');
	}
		
	if (defined('IN_ADMIN'))
	{
		$mx_user->extend(MX_LANG_ALL, MX_IMAGES_NONE, $module_root_path, true);
	}
	else
	{
		$mx_user->extend(MX_LANG_MAIN, MX_IMAGES, $module_root_path, true);
	}

	$mx_page->add_copyright( 'MXP pafileDB Module' );
}

?>