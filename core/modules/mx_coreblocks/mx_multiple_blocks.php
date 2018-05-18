<?php
/**
*
* @package Mx-Publisher Module - mx_coreblocks
* @version $Id: mx_multiple_blocks.php,v 1.2 2009/01/24 16:47:53 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] Mx-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$b_description = $mx_block->block_info['block_desc'];
$block_size = (isset( $block_size ) && !empty( $block_size ) ? $block_size : '100%');

// check parameter for block count
$block_ids = $mx_block->get_parameters('block_ids');
$block_ids = explode(',',$block_ids);
$nested_block_count = sizeof($block_ids);
// settype($nested_block_count,'integer');
if ($nested_block_count < 2)
	mx_message_die(GENERAL_ERROR, "Nested block count must be >=2.", "", __LINE__, __FILE__, '');

// check parameter block ids & check parameter for block count	
// if (sizeof($block_ids)!=$nested_block_count)
//	mx_message_die(GENERAL_ERROR, "Number of block ids must be equal to block count.", "", __LINE__, __FILE__, '');

// check parameter block sizes
$block_sizes = $mx_block->get_parameters('block_sizes');
$block_sizes = explode(',',$block_sizes);
if (sizeof($block_sizes)!= $nested_block_count)
	mx_message_die(GENERAL_ERROR, "Number of block sizes must be equal to block count.", "", __LINE__, __FILE__, '');

// check parameter space
$block_space = $mx_block->get_parameters('space_between');
if ($block_space == '')
	mx_message_die(GENERAL_ERROR, "Space between nested blocks not set.", "", __LINE__, __FILE__, '');

// start the placement table
echo '<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>';

$mx_split_block = new mx_block();

for ($cell = 0; $cell < $nested_block_count; $cell++) 
{
	$inner_block_id=$block_ids[$cell];
	$inner_block_size=$block_sizes[$cell];
	settype($inner_block_id,'integer');
		
	// output a placement table for each single block and the optional space
	echo '<td width="'.$inner_block_size.'" valign="top"><table cellspacing="0" cellpadding="0" border="0" width="100%"><tr><td>';

	/*
	// get the necessary info about this block
	$sql = "SELECT blk.block_id, module_path, function_file, auth_view
		FROM " . BLOCK_TABLE    . " blk,
		" . FUNCTION_TABLE . " fnc,
		" . MODULE_TABLE   . " modu
		WHERE blk.function_id = fnc.function_id
		AND fnc.module_id   = modu.module_id
		AND blk.block_id = ".$inner_block_id;
	if(!$block_result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, "Could not query modules information", "", __LINE__, __FILE__, $sql);
	}
	$block_row = $db->sql_fetchrow($block_result);
	*/
	// $module_root_path=$block_row['module_path'];
	// $block_file=$block_row['function_file'];
	// $auth_view=$row['auth_view'];

	$block_id = $inner_block_id;
	$mx_split_block->init( $inner_block_id );
	$block_size='100%';

	if ( $mx_split_block->auth_view )
	{
		$template = new mx_Template($template->root, $board_config, $db);

		$module_root_path 	= $mx_split_block->module_root_path;
		$block_file        	= $mx_split_block->block_file;
				
		include( $module_root_path . $block_file );
		
		// output additional space between blocks if it is not the last block
		if ($cell<$nested_block_count-1) {
			echo '</td><td width="'.$block_space.'">';
			echo '<img src="templates/spacer.gif" width="'.$block_space.'">';
		}		
	}	
	
	/*
	// check visibility (code from index.php)
	$is_auth_ary = array();
	$is_auth_ary = block_auth(AUTH_VIEW, $inner_block_id , $userdata, $block_row, $block_row[auth_view] );
	
	// output the block
	if ( $is_auth_ary[auth_view] ) {
	
		// set block id and block size as this must be correctly set for the inclusion to work
		$block_id=$inner_block_id;
		$block_size='100%';

		$template = new mx_Template( $template->root, $board_config, $db);
		include($module_root_path . $block_file );
		
		// output additional space between blocks if it is not the last block
		if ($cell<$nested_block_count-1) {
			echo '</td><td width="'.$block_space.'">';
			echo '<img src="templates/spacer.gif" width="'.$block_space.'">';
		}
	}
	*/
	// finish the inner placement table for a single block
	echo '</td></tr></table></td>';
}

// finish the outer placement table
echo '</tr></table>';
?>
