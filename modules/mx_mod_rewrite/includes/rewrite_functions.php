<?php
/**
*
* @package MX-Publisher Module - mx_mod_rewrite
* @version $Id: rewrite_functions.php,v 1.13 2013/06/28 15:35:15 orynider Exp $
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
class mx_mod_rewrite
{
 	function encode($url)
 	{
 		global $mx_root_path, $phpEx;

 		if (substr_count($url, 'modrewrite=no'))
 		{
 			return $url;
 		}

 		//
 		// First redirect to *.htm
 		//
 		/*
		$input = array(
			"'(?)index.php'",
		);
		$output = array(
			"index.htm",
		);
		$url = preg_replace($input, $output, $url);
		*/

		//
		// Load Custom Defs (if any)
		//
		if ( file_exists( $mx_root_path . 'modules/mx_mod_rewrite/includes/rewrite_custom_defs.' . $phpEx ) )
		{
			include_once( $mx_root_path . 'modules/mx_mod_rewrite/includes/rewrite_custom_defs.' . $phpEx );

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
		// Now do a standard MX-Publisher mapping
		// - the keys are defined in the lang files
		//
 		$input = array(
			//
			// General
			//
			"'(?)index.php\?page=([0-9]*)'",
			"'(?)index.php\?block_id=([0-9]*)'",
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