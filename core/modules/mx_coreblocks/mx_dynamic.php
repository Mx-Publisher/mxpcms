<?php
/** ------------------------------------------------------------------------
 *		subject				: mx-portal, CMS & portal
 *		begin            	: june, 2002
 *		copyright          	: (C) 2002-2005 MX-System
 *		email             	: jonohlsson@hotmail.com
 *		project site		: www.mx-system.com
 * 
 *		description			:
 * -------------------------------------------------------------------------
 * 
 *    $Id: mx_dynamic.php,v 1.6 2005/03/06 01:10:13 jonohlsson Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */
 
if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

//
// Read Block Settings
$block_size = (isset( $block_size ) && !empty( $block_size ) ? $block_size : '100%');

$dynamic_block_config = read_block_config($block_id);

if ( isset( $_POST['dynamic_block'] ) || isset($_GET['dynamic_block']))
{
	$dynamic_block_id = (isset($_POST['dynamic_block'] ) ) ? intval( $_POST['dynamic_block'] ) : intval($_GET['dynamic_block'] );
}
else
{
	$dynamic_block_id = $dynamic_block_config[$block_id]['default_block_id']['parameter_value'];
}

if ( $dynamic_block_id == '0' )
{
	return;
}

$block_id = intval($dynamic_block_id) ? $dynamic_block_id : $block_id; //29
$dynamic_block_id = intval($dynamic_block_id) ? $dynamic_block_id : 29; //29
$sql = "SELECT *
    		FROM " . COLUMN_BLOCK_TABLE . " bct,
         	" . BLOCK_TABLE . " blk,
         	" . FUNCTION_TABLE . " fnc,
         	" . MODULE_TABLE . " mdl
    		WHERE blk.function_id = fnc.function_id
      		AND fnc.module_id   = mdl.module_id
			AND blk.block_id    = " . $dynamic_block_id . "
      		ORDER BY column_id, block_order";

if ( !$q_modules = $db->sql_query( $sql ) )
{
	mx_message_die( GENERAL_ERROR, "Could not query modules information", "", __LINE__, __FILE__, $sql );
}

if ( $total_block = $db->sql_numrows( $q_modules ) )
{
	$block_rows_dynamic = $db->sql_fetchrow($q_modules); 
}

$block_config_dynamic = read_block_config($dynamic_block_id);

// check visibility (code from index.php)
$is_auth_ary = array();
$is_auth_ary = $mx_block->auth( AUTH_VIEW, $dynamic_block_id, $userdata, $block_config_dynamic[$dynamic_block_id]['auth_view'], $block_config_dynamic[$dynamic_block_id]['auth_view_group'] );

$module_root_path = $block_rows_dynamic['module_path'];
$dynamic_admin_file = !empty( $block_rows_dynamic['function_admin'] ) ? $block_rows_dynamic['function_admin'] : 'admin/admin_mx_block.php';
$block_file = $block_rows_dynamic['function_file'];

// Overwrite with block info
$dynamic_main_block_id = $mx_block_id; // Main block id
$mx_block_id = $dynamic_block_id; // Dynamic block id
$block_rows[$block] = $block_rows_dynamic;

$mx_block_config = $block_config = $block_config_dynamic;

if ($is_auth_ary[auth_view] && $block_rows_dynamic['show_block'] == 1 || $is_auth_ary[auth_mod] )
{
	include($module_root_path . $block_file);
}

?>