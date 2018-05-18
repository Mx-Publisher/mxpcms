<?php
/**
*
* @package Mx-Publisher Module - mx_phpbb
* @version $Id: phpbb_footer.php,v 1.2 2010/10/16 04:07:43 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] Mx-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined('IN_PORTAL') )
{
	die( "Hacking attempt" );
}

// Parse and show the overall footer.

$template->set_filenames( array( 'phpbb_footer' => 'phpbb_footer.tpl' ) );

$template->assign_vars( array( 'L_MODULE_VERSION' => $phpbb_module_version,
		'L_MODULE_ORIG_AUTHOR' => $phpbb_module_orig_author,
		'L_MODULE_AUTHOR' => $phpbb_module_author ) 
	);

$template->pparse( 'phpbb_footer' );

?>