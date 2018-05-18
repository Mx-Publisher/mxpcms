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
 *    $Id: rewrite_custom_defs.php,v 1.3 2010/10/16 04:07:11 orynider Exp $
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
class mx_mod_rewrite_custom
{
	/*
	Examples given below will define rules for the following site urls:
	
	http://domain/home
	http://domain/forum
	http://domain/something
	http://domain/something_more
	http://domain/info
	http://domain/info/p1
	http://domain/info/p2
	http://domain/info/p3
	
	*/
	
 	function encode($url)
 	{
		$input = array( 
			//
			// What to map?
			//
			
			/*
			// Examples
			"'(?)index.htm\?page=1($|&amp;|\&)'",		// Home
			"'(?)index.htm\?page=2($|&amp;|\&)'",		// Forum
			"'(?)index.htm\?page=3($|&amp;|\&)'",		// Something
			"'(?)index.htm\?page=4($|&amp;|\&)'",		// Something_more
			
			"'(?)index.htm\?page=5($|&amp;|\&)'",		// info
				"'(&amp;|\&)dynamic_block=1'",			// Sub page 1
				"'(&amp;|\&)dynamic_block=2'",			// Sub page 2
				"'(&amp;|\&)dynamic_block=3'",			// Sub page 3
			*/
		); 
		
		$output = array(
			//
			// Map to...
			//
			
			/*
			"home\\1",
			"forum\\1",
			"something\\1",
			"something_more\\1",
			
			"info\\1",	
				"/p1",		
				"/p2",		
				"/p3",		
			*/
		); 
		
		$url = preg_replace($input, $output, $url); 
		
		return $url; 
 	}	
}

?>