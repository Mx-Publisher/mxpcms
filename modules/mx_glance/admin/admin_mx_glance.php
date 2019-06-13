<?php
/*
* @package mxBB Portal Module - mx_glance
* @version $Id: admin_mx_glance.php,v 1.5 2013/06/17 16:02:48 orynider Exp $
* @copyright (c) 2001-2007 blulegend, Jack Kan, OryNider
*/

$mx_root_path = '../' ;
global $db;
	$block_id = (!empty($_REQUEST['block_id']) ) ? $_REQUEST['block_id'] : '';
if (empty($block_id))
{
	// 0: module, 1: module_id, 2: module_name, 3: module_path,
	// 4: module_desc, 5: module_include_admin
	//mx_get_info($table, $idfield = '', $id = 0, $idfield2 = '', $id2 = 0) ... ( $idfield2 != '' && $id2 != '' ) ? " AND $idfield2 = '$id2'" : '';
	$block_info = mx_get_info(BLOCK_TABLE, 'block_title', 'Last News and Topics');
	$block_id = (isset($block_id) && !empty($block_id) ? $block_id : $block_info['block_id'] );
	$title = $block_info['block_title'];
	$block_size = ( isset($block_size) && !empty($block_size) ? $block_size : '100%' );
	$description = $block_info['block_desc'];
}  

if(!empty($setmodules))
{
  $module['Last_News_and_Topics']['General_Module_Settings'] = "admin/admin_mx_block_cp.php?mode=setting&amp;block_id=$block_id";
  return;
}
?>