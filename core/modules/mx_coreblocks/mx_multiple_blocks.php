<?php
/***************************************************************************
 *                       mx_multiple_blocks.php
 *                            -------------------
 *   email                : bananeweizen@gmx.de
 *
 *
 ***************************************************************************/

$block_config = read_block_config( $block_id );

// check parameter for block count
$block_ids = $block_config[$block_id][block_ids]['parameter_value'];
$block_ids=explode(',',$block_ids);
$nested_block_count = sizeof($block_ids);
// settype($nested_block_count,'integer');
if ($nested_block_count<2)
	mx_message_die(GENERAL_ERROR, "Nested block count must be >=2.", "", __LINE__, __FILE__, '');

// check parameter block ids & check parameter for block count	
// if (sizeof($block_ids)!=$nested_block_count)
//	mx_message_die(GENERAL_ERROR, "Number of block ids must be equal to block count.", "", __LINE__, __FILE__, '');

// check parameter block sizes
$block_sizes = $block_config[$block_id][block_sizes]['parameter_value'];
$block_sizes=explode(',',$block_sizes);
if (sizeof($block_sizes)!=$nested_block_count)
	mx_message_die(GENERAL_ERROR, "Number of block sizes must be equal to block count.", "", __LINE__, __FILE__, '');

// check parameter space
$block_space = $block_config[$block_id][space_between]['parameter_value'];
if ($block_space=='')
	mx_message_die(GENERAL_ERROR, "Space between nested blocks not set.", "", __LINE__, __FILE__, '');

// start the placement table
echo '<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>';

for ($cell=0;$cell<$nested_block_count;$cell++) {
	$inner_block_id=$block_ids[$cell];
	$inner_block_size=$block_sizes[$cell];
	settype($inner_block_id,'integer');
		
	// output a placement table for each single block and the optional space
	echo '<td width="'.$inner_block_size.'" valign="top"><table cellspacing="0" cellpadding="0" border="0" width="100%"><tr><td>';

	// get the necessary info about this block
	$sql = "SELECT blk.block_id, module_path, function_file, auth_view
		FROM " . BLOCK_TABLE    . " blk,
		" . FUNCTION_TABLE . " fnc,
		" . MODULE_TABLE   . " mod
		WHERE blk.function_id = fnc.function_id
		AND fnc.module_id   = mod.module_id
		AND blk.block_id = ".$inner_block_id;
	if(!$block_result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, "Could not query modules information", "", __LINE__, __FILE__, $sql);
	}
	$block_row = $db->sql_fetchrow($block_result);
	$module_root_path=$block_row['module_path'];
	$block_file=$block_row['function_file'];
	$auth_view=$row['auth_view'];
	
	// check visibility (code from index.php)
	$is_auth_ary = array();
	$is_auth_ary = block_auth(AUTH_VIEW, $inner_block_id , $userdata, $block_row, $block_row[auth_view] );
	
	// output the block
	if ( $is_auth_ary[auth_view] ) {
	
		// set block id and block size as this must be correctly set for the inclusion to work
		$block_id=$inner_block_id;
		$block_size='100%';
//		echo $module_root_path.$block_file;

		$template = new Template( $template->root, $board_config, $db);
		include($module_root_path . $block_file );
		
		// output additional space between blocks if it is not the last block
		if ($cell<$nested_block_count-1) {
			echo '</td><td width="'.$block_space.'">';
			echo '<img src="templates/spacer.gif" width="'.$block_space.'">';
		}
	}
	// finish the inner placement table for a single block
	echo '</td></tr></table></td>';
}

// finish the outer placement table
echo '</tr></table>';
?>
