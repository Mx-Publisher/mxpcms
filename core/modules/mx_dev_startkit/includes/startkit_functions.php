<?php
/**
*
* @package MX-Publisher Module - mx_dev_startkit
* @version $Id: startkit_functions.php,v 1.6 2008/06/03 20:07:28 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Module functions class
// Do not define module functions outside this class!!
//
class mx_startkit
{
	//
	// Public Methods
	//

	/********************************************************************************\
	| Double
	\********************************************************************************/
	function double($number = 0)
	{
		$new_number = $number + $number;

		return $new_number;
	}
}
?>