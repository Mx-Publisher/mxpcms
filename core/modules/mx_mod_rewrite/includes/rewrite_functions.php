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
 *    $Id: rewrite_functions.php,v 1.3 2010/10/16 04:07:12 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

//
// Module functions class
// Do not define module functions outside this class!!
//
class mx_mod_rewrite
{
 	function encode($url)
 	{
 		global $mx_root_path;
 		
 		//
 		// First redirect to *.htm
 		//
		$input = array( 
			"'(?)index.php'",
		); 
		$output = array(
			"index.htm",
		);		
		$url = preg_replace($input, $output, $url); 

		//
		// Load Custom Defs (if any)
		//
		if ( file_exists( $mx_root_path . 'modules/mx_mod_rewrite/includes/rewrite_custom_defs.php' ) )
		{
			include_once( $mx_root_path . 'modules/mx_mod_rewrite/includes/rewrite_custom_defs.php' );
			
			if (class_exists('mx_mod_rewrite_custom'))
			{
				$mx_mod_rewrite_custom = new mx_mod_rewrite_custom();
				
				if ( method_exists( $mx_mod_rewrite_custom,  'encode' ) )
				{
					$url = $mx_mod_rewrite_custom->encode($url);
				}
			}
		}
			
		//
		// Now do a standard mxBB mapping
		// - the keys are defined in the lang files
		//		
 		$input = array( 
			//
			// General
			//
			"'(?)index.htm\?page=([0-9]*)'",
			"'(?)index.htm\?block_id=([0-9]*)'",
			"'(&amp;|\&)dynamic_block=([0-9]*)'",
			"'(&amp;|\&)cat_link=([0-9]*)'",
		);		
		$output = array(
			//
			// General
			// 
			"page\\1", 
			"block\\1", 
			"/sub\\2", 
			"/catlink\\2", 
		); 		
		$url = preg_replace($input, $output, $url); 
		
		return $url; 
 	}	
}
?>