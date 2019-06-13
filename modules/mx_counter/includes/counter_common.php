<?php
/**
*
* @package mxBB Portal Module - mx_counter
* @version $Id: counter_common.php,v 1.5 2011/03/29 02:39:29 orynider Exp $
* @copyright (c) 2004-2006 OryNider
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// Security check
//
if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

//
// Load language files.
//

if( file_exists($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx) )
{
	include($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
}
else
{
	include($module_root_path . 'language/lang_english/lang_main.' . $phpEx);
}

//
// Define table names.
//

include_once($module_root_path . 'includes/counter_constants.'.$phpEx);

// ================================================================================
//			[ COMMON CONFIG ]
// ================================================================================

//
// Get Counter Settings from config table
//

	$counter_config = array();

	$sql = "SELECT * FROM ".COUNTER_CONFIG_TABLE;

	$result = $db->sql_query($sql);

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't query counter config table", "", __LINE__, __FILE__, $sql);
	}
	else
	{
		while( $row = $db->sql_fetchrow($result) )
		{
			$counter_config[$row['config_name']] = $row['config_value'];
		}
	}


// ================================================================================
//			[ COMMON FUNCTIONS ]
// ================================================================================


//Update counter statue
function update_count($newcount)
{
	global $counter_config, $board_config, $db, $lang;

	$sql = "UPDATE ". COUNTER_SESSION_TABLE ."
			SET currentcount = '$newcount'
			WHERE count_id = 1";

	if( !$result = $db->sql_query($sql) )
	{
		mx_message_die(GENERAL_ERROR, "SQL Error in function update_count()", "", __LINE__, __FILE__, $sql);
	}

}

function counter_data($newcount)
{
	global $counter_config;
	$numdigits = strlen($newcount);
	$digitpath = $counter_config['digitpath'];
	$digits = $counter_config['digits'];

	if (empty($digitpath))
	{
		$digitpath = 'set1';
	}

	if (empty($digits))
	{
		$digits = '5';
	}

	//read old counter data
	$imagedirectory = IMAGEDIRECTORY . $digitpath . '/';	

	$digits = ($digits < $numdigits) ? $numdigits : $digits;

	//set each digit to default 0
	for ($a=0; $a<$digits; $a++)
	{
		$img[$a] = "$imagedirectory";
		$img[$a] .= "0.gif";
	}

	//change each digit
	$actdigits = strlen($newcount);
	for ($a=0;$a<$actdigits;$a++)
	{
		$showdig = substr($newcount, $a, 1);
		$img[$digits - $actdigits + $a] = "$imagedirectory";
		$img[$digits - $actdigits + $a] .= "$showdig.gif";
	}

	//check if we have an overflow
	if($numdigits > $digits)
	{
		$bOver=true;
		for ($a=0;$a<$digits;$a++)
		{
			$img[$a] = "$imagedirectory";
			$img[$a] .= "9.gif";
		}
	}

	//this is what we are ouputing
	$displayblock = "";
	for ($a=0;$a<$digits;$a++)
	{
		$displayblock .= "<img src=$img[$a]>";
	}

	//$counter_data is the variable that holds the stuff to output
	$counter_data.=$displayblock;
	if($bOver == true)$counter_data.='+';
	
	return $counter_data;
}

?>