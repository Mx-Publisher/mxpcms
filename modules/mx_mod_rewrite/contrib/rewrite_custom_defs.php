<?php
/**
*
* @package MX-Publisher Module - mx_mod_rewrite
* @version $Id: rewrite_custom_defs.php,v 1.6 2013/06/28 15:35:15 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

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