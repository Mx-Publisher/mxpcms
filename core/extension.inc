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
 *    $Id: extension.inc,v 1.5 2011/03/06 05:48:20 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */
 
if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

//
// Change this if your extension is not .php!
//
$phpEx = 'php';

/**
 * function eregi
 *
 * temp replacement for eregi()
 *
 *
 */
if (!@function_exists('eregi')) 
{     
	function eregi($find, $str) 
	{         
		return stristr($str, $find);     
	} 
}

/**
 * function ereg
 *
 * temp replacement for ereg()
 *
 *
 */
if(!function_exists('ereg')) 
{     
	function ereg($pattern, $string, &$array)      
	{          
		return preg_match('#'.$pattern.'#', $string, $array);      
	} 
}

$mx_starttime = explode(' ', microtime());
$mx_starttime = $mx_starttime[1] + $mx_starttime[0];

?>