<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: rewrite_constants.php,v 1.3 2010/10/16 04:07:12 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */
 
// **********************************************************************
// Read language definition
// **********************************************************************
if ( !file_exists( $mx_root_path . $mx_block->module_root_path  . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx ) )
{
	include( $mx_root_path . $mx_block->module_root_path . 'language/lang_english/lang_main.' . $phpEx );
	$link_language = 'lang_english';
}
else
{
	include( $mx_root_path . $mx_block->module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx );
	$link_language = 'lang_' . $board_config['default_lang'];
} 

//
// Module Copyrights
//
$mxbb_footer_addup[] = 'mxBB mod_rewrite';

// ----------
$phpbb_module_version = "1.0";
$phpbb_module_author = "mxBB Team";
?>