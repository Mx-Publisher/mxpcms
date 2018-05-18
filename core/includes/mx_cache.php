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
 *    $Id: mx_cache.php,v 1.3 2005/12/05 22:25:12 jonohlsson Exp $
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

// --------------------------------------------------------------------------------
// Class: mx_cache
//

//
// Following flags are options for the $type parameter in method _read()
//
define('MX_ALL_DATA'		, -1);		// Flag - write all data
define('MX_BLOCK'			, 0);		// Block read mode
define('MX_PAGE'			, 1);		// Page read mode

define('MX_QUERY_DB'		, true);	// Flag - to force db query
define('MX_CACHE_DEBUG'		, false);	// echo lots of debug info

//
// Additional notes:
//

//
// This class IS instatiated in common.php ;-)
//

// Usage examples:
//

// The block and pages config data is either retrieved from its cache file od db queried (adminCP switch), or db query is forced using flag 'MX_QUERY_DB' 

// $block_config = $mx_cache->read( MX_BLOCK, $block_id, [MX_QUERY_DB] ); 	// Optional flag 'MX_QUERY_DB' to force db query
// $page_config = $mx_cache->read( MX_PAGE, $page_id, [MX_QUERY_DB] ); 		// Optional flag 'MX_QUERY_DB' to force db query

// $mx_cache->update( MX_ALL_DATA ); 			// Updates all cache
// $mx_cache->update( MX_BLOCK, [$block_id] ); 	// Optional parameter $block_id to update only specific cache fle
// $mx_cache->update( MX_PAGE, [$page_id] ); 	// Optional parameter $page_id to update only specific cache file

class mx_cache
{
	// ------------------------------
	// Private Methods
	//
	//

	// Read cache
	function _read_config( $id, $sub_id, $type, $cache )
	{
		global $portal_config, $mx_root_path;
		
		$cache_dir = $mx_root_path . 'cache/';
		
		switch ( $type )
		{
			case MX_BLOCK:
			
				$cache_file = $cache_dir . "block_" . $id . ".xml";

				$block_config = '';
				if ( file_exists( $cache_file ) && !empty($id) && $cache == true && $sub_id == 0 && $portal_config['mx_use_cache'] == 1 )
				{	
					if ( MX_CACHE_DEBUG ) { echo('using block cache'); }
					$block_config = $this->_cache2data( $id, $cache_file );
				}
				else 
				{
					if ( MX_CACHE_DEBUG ) { echo('using block db'); }
					$block_config = $this->_get_block_config( $id, $sub_id );
				}
				return $block_config;
			
			break;
			
			case MX_PAGE:
			
				$cache_file = $cache_dir . "page_" . $id . ".xml";

				$pages_config = '';
				if ( file_exists( $cache_file ) && !empty($id) && $cache == true && $portal_config['mx_use_cache'] == 1 )
				{	
					if ( MX_CACHE_DEBUG ) { echo('using page cache'); }
					$pages_config = $this->_cache2data( $id, $cache_file );
				}
				else 
				{
					if ( MX_CACHE_DEBUG ) { echo('using page db'); }
					$pages_config = $this->_get_page_config( $id );
				}
				return $pages_config;
					
			break;
		}
	}

	// Write cache
	function _write_config( $type, $id, $action )
	{
		global $portal_config, $mx_root_path, $lang;
		
		$cache_dir = $mx_root_path . 'cache/';
		
		@mkdir($cache_dir, 0777);
		@chmod($cache_dir, 0777);
		
		$cache_file = $cache_dir . ( $type == MX_BLOCK ? "block_" : "page_" ) . ( $action == 'single' ? $id . ".xml" : '' );
		
		if ( !is_writable($cache_dir) )
		{
			mx_message_die(GENERAL_MESSAGE, $lang['Cache_dir_write_protect'], '');
			exit;
		}		
		
		switch ( $type )
		{
			case MX_BLOCK:
				
				switch ( $action )
				{
					case 'all':
						
						if ( MX_CACHE_DEBUG ) { echo('writing all block cache'); }
						$block_config = $this->_get_block_config( '', 0 );
						$this->_data2cache( $block_config, $cache_file, $action, $type );
											
					break;
					
					case 'single':
					
						if ( MX_CACHE_DEBUG ) { echo('writing id block cache'); }
						$block_config = $this->_get_block_config( $id, 0 );
						$this->_data2cache( $block_config[$id], $cache_file, $action, $type );
					
					break;
				}
			
			break;
			
			case MX_PAGE:
			
				switch ( $action )
				{
					case 'all':
						
						if ( MX_CACHE_DEBUG ) { echo('writing all page cache'); }
						$pages_config = $this->_get_page_config( );
						$this->_data2cache( $pages_config, $cache_file, $action, $type );
					
					break;
					
					case 'single':
					
						if ( MX_CACHE_DEBUG ) { echo('writing id page cache'); }
						$pages_config = $this->_get_page_config( $id );
						$this->_data2cache( $pages_config, $cache_file, $action, $type );
						
					break;
				}			
			
			break;
		}		
	}
		
	// -------------------------------------------------------------------WRITE CACHE
	// write cache from db query (or data)
	function _data2cache($data, $xml_file, $action, $type )
	{
		global $db;
	
		switch ( $action )
		{
			case 'all':
					
				if ( empty($data) || empty($xml_file) )
				{
					return;
				}

				foreach ($data as $key => $value)
				{
					$OUTPUT = serialize($value);
					
					if ( $type == MX_PAGE )
					{
						$fp = fopen($xml_file . $value['page_info']['page_id'] . $xml_file_type . ".xml","w"); // open file with Write permission
					}
					else 
					{
						$fp = fopen($xml_file . $value['block_id'] . $xml_file_type . ".xml","w"); // open file with Write permission
						
					}
					
					fputs($fp, $OUTPUT); 
					fclose($fp);
				}
					
			break;
					
			case 'single':
					
				if ( empty($data) || empty($xml_file) )
				{
					return;
				}
					
				$OUTPUT = serialize($data);
				$fp = fopen($xml_file,"w"); // open file with Write permission
				fputs($fp, $OUTPUT); 
				fclose($fp);
						
			break;
		}			
	} 


	// -------------------------------------------------------------------READ CACHE
	// read xml file to array
	function _cache2data( $id = '', $cache_file = '' )
	{
		if ( empty($cache_file) )
		{
			return;
		}

		$data = array();
		if ( (@phpversion() < '4.3.0' ) )
		{
			$data[$id] = unserialize(implode('',file($cache_file)));
		}
		else 
		{
			$data[$id] = unserialize(file_get_contents($cache_file));
		}
		return $data;
	}	


	// -------------------------------------------------------------------GET DATA	
	// Read the variable block configuration
	function _get_block_config( $id = '', $sub_id = 0 )
	{
		global $db;

		$block_config = array();

		// If this block doesn't have any parameters, we need this additional query :(
		$sql_block =  !empty($id) ? " AND block_id = " . $id : '';

		// Generate block parameter data
		$sql = "SELECT 	blk.*,
						mdl.module_path,
						fnc.function_file, fnc.function_id, fnc.function_admin

			FROM " . BLOCK_TABLE . " blk,
					" . FUNCTION_TABLE . " fnc,
			        " . MODULE_TABLE . " mdl 		
			WHERE   blk.function_id = fnc.function_id
					AND fnc.module_id   = mdl.module_id";
		
		$sql .= $sql_block;
		
		$sql .= " ORDER BY block_id";
	  	   			
		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not obtain block data information', '', __LINE__, __FILE__, $sql );
		}

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$block_id = $row['block_id'];
			
			$block_row = array( 
					"block_id" => $row['block_id'],
					"block_title" => $row['block_title'],
					"block_desc" => $row['block_desc'],
					"auth_view" => $row['auth_view'],
					"auth_view_group" => $row['auth_view_group'],
					"auth_edit" => $row['auth_edit'],
					"auth_edit_group" => $row['auth_edit_group'],
//					"auth_moderator_group" => $row['auth_moderator_group'],
//					"show_block" => $row['show_block'],
//					"show_title" => $row['show_title'],
//					"show_stats" => $row['show_stats'],
//					"block_time" => $row['block_time'],
//					"block_editor_id" => $row['block_editor_id'],
					"module_root_path" => $row['module_path'],
					"block_file" => $row['function_file'],
					"block_edit_file" => $row['function_admin'],
					"function_id" => $row['function_id']
			);		
						
			$block_config[$row['block_id']] = $block_row;
		}

		$sql_block =  !empty( $block_id ) ? " AND sys.block_id = " . $id : '';	
		
		// Generate block parameter data
		$sql = "SELECT 	blk.*,
						sys.parameter_id, sys.parameter_value, sys.bbcode_uid,
						par.parameter_name, par.parameter_type, par.parameter_function, par.parameter_default, 
						mdl.module_path,
						fnc.function_file, fnc.function_admin

			FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
					" . PARAMETER_TABLE . " par,
					" . BLOCK_TABLE . " blk,
			        " . FUNCTION_TABLE . " fnc,
			        " . MODULE_TABLE . " mdl		
			WHERE sys.parameter_id = par.parameter_id
					AND sys.block_id = blk.block_id 
					AND blk.function_id = fnc.function_id
					AND fnc.module_id   = mdl.module_id";
		
		$sql .= $sql_block;
		
		$sql .= " ORDER BY sys.block_id, sys.parameter_id";
	  	   			
		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not obtain block data information', '', __LINE__, __FILE__, $sql );
		}

		$block_id = 0;
		
		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$next_block = ( $block_id != $row['block_id'] ) ? true : false;
			$block_id = $row['block_id'];
			
			$block_row = array( 
					"block_id" => $row['block_id'],
					"block_title" => $row['block_title'],
					"block_desc" => $row['block_desc'],
					"column_id" => $row['column_id'],
					"auth_view" => $row['auth_view'],
					"auth_view_group" => $row['auth_view_group'],
					"auth_edit" => $row['auth_edit'],
					"auth_edit_group" => $row['auth_edit_group'],
//					"auth_moderator_group" => $row['auth_moderator_group'],
//					"show_block" => $row['show_block'],
//					"show_title" => $row['show_title'],
//					"show_stats" => $row['show_stats'],
//					"block_time" => $row['block_time'],
//					"block_editor_id" => $row['block_editor_id'],
					"module_root_path" => $row['module_path'],
					"block_file" => $row['function_file'],
					"block_edit_file" => $row['function_admin']
			);		
			
			$param_row = array( 
					"parameter_id" => $row['parameter_id'],
					"function_id" => $row['function_id'],
					"parameter_name" => $row['parameter_name'],
					"parameter_type" => $row['parameter_type'],
					"parameter_value" => $row['parameter_value'],
					"parameter_default" => $row['parameter_default'],
					"parameter_function" => $row['parameter_function'], 
					"bbcode_uid" => $row['bbcode_uid'] 
			);				
			
			if ( $next_block )
			{
				$block_config[$block_id] = $block_row;
			}
						
			$block_config[$block_id][$param_row['parameter_name']] = $param_row;
		}

		return $block_config;
	}	

	function _get_page_config( $id = '' )
	{
		global $db, $HTTP_SESSION_VARS;
	
		$sql_page = !empty($id) ? " AND col.page_id = '" . $id . "'" : "";
		
		// Get page_blocks data
		$sql = "SELECT 	col.page_id, 
						pag.page_name, 
						pag.page_icon, 
						pag.page_header, 
						pag.auth_view AS pag_auth_view, 
						pag.auth_view_group AS pag_auth_view_group, 
						bct.column_id, 
						col.column_title, 
						col.column_order, 
						col.column_size, 
						blk.block_id,
						mdl.module_path,
						fnc.function_file,
						fnc.function_admin 
	    		FROM " . COLUMN_BLOCK_TABLE . " bct,
			         	" . BLOCK_TABLE . " blk,
			         	" . FUNCTION_TABLE . " fnc,
			         	" . MODULE_TABLE . " mdl,
			         	" . PAGE_TABLE . " pag,
						" . COLUMN_TABLE . " col
				WHERE blk.function_id = fnc.function_id
			      		AND pag.page_id    	= col.page_id
			      		AND blk.block_id    = bct.block_id
			      		AND fnc.module_id   = mdl.module_id
						AND bct.column_id 	= col.column_id ";
				$sql .= $sql_page;
	      		$sql .= " ORDER BY col.page_id, column_id, column_order, block_order";

	    if ( !$result = $db->sql_query( $sql ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not query page information", "", __LINE__, __FILE__, $sql );
		}

		$pages_config = array();
		$page_id = 0;
		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$next_page = ( $page_id != $row['page_id'] ) ? true : false;
			$next_column = ( $column_id != $row['column_id'] ) ? true : false;
			$page_id = $row['page_id'];
			$column_id = $row['column_id'];
			
			$page_row = array( 
				"page_id" => $row['page_id'],
				"page_name" => $row['page_name'],
				"page_icon" => $row['page_icon'],
				"page_header" => $row['page_header'],
				"page_auth_view" => $row['pag_auth_view'],
				"page_auth_view_group" => $row['pag_auth_view_group']
				);
	
			$column_row = array( 
				"column_id" => $row['column_id'],
				"column_title" => $row['column_title'],
				"column_order" => $row['column_order'],
				"column_size" => $row['column_size'] 
				);
	
			$block_row = array( 
				"block_id" => $row['block_id'],
				"column_id" => $row['column_id'],
				"module_root_path" => $row['module_path'],
				"function_file" => $row['function_file'],
				"function_admin" => $row['function_admin'] 
				);
	
			if ( $next_page )
			{
				$temp_row = array();
	
				$temp_row = array( 'page_info' => $page_row );
			}
	
			if ( $next_column )
			{
				$temp_row['columns'][] = $column_row;
			}
	
			$temp_row['blocks'][] = $block_row; 
			
			// Compose the pages config array
			 $pages_config[$page_id] = $temp_row;
		};
		return $pages_config;
	}
			
	function _update_cache( )
	{
		global $db, $HTTP_SESSION_VARS, $mx_root_path, $phpbb_root_path, $phpEx, $mx_use_cache, $portal_config;
	
//		$portal_cache_time = time();
	
//		$sql = "UPDATE ".PORTAL_TABLE."
//			SET portal_recached = '$portal_cache_time'
//			WHERE portal_id = 1";
	
//		if ( !( $result = $db->sql_query( $sql, BEGIN_TRANSACTION ) ) )
//		{
//			mx_message_die( GENERAL_ERROR, "Could not update portal cache time.", "", __LINE__, __FILE__, $sql );
//		}	
	}	
	
	// ------------------------------
	// Public Methods
	//
	
	// $block_config = $mx_cache->read( MX_BLOCK, $block_id, [MX_QUERY_DB] ); 	// Optional flag 'MX_QUERY_DB' to force db query
	// $page_config = $mx_cache->read( MX_PAGE, $page_id, [MX_QUERY_DB] ); 		// Optional flag 'MX_QUERY_DB' to force db query
	
	// $mx_cache->update( MX_ALL_DATA ); 			// Updates all cache
	// $mx_cache->update( MX_BLOCK, [$block_id] ); 	// Optional parameter $block_id to update only specific cache fle
	// $mx_cache->update( MX_PAGE, [$page_id] ); 	// Optional parameter $page_id to update only specific cache file
	
	function read( $id = '', $type = MX_BLOCK, $force_query = false )
	{
		if ( is_array( $id ) )
		{
			$id = $id['id'];
			$sub_id =  $id['sub_id'];
		}
		else 
		{
			$sub_id = 0;
		}
		
		if ( $id > 0 )
		{
			return $this->_read_config( $id, $sub_id, $type, !$force_query );
		}
		else 
		{
			die('invalid cache read call - no id');
		}
	
	}
	
	// TYPE: MX_ALL_DATA, MX_PAGE, MX_BLOCK
	function update( $type = MX_ALL_DATA, $id = '' )
	{
		if ( $type == MX_ALL_DATA || empty($id) )
		{
			$this->_write_config( MX_BLOCK, '', 'all' );
			$this->_write_config( MX_PAGE, '', 'all' );
		}
		else if ( $id > 0 )
		{
			$this->_write_config( $type, $id, 'single' );
		}
		else 
		{
			die('invalid cache write call - no id');
		}	
		$this->_update_cache( );
	}
	
	
	
	
}	// class mx_cache

// --------------------------------------------------------------------------------
// Class: mx_block
//

//
// Usage examples:
//

class mx_block
{
	//
	// Implementation Conventions:
	// Properties and methods prefixed with underscore are intented to be private. ;-)
	//

	// ------------------------------
	// Vars
	//
	
	var $block_config = array();
	
	var $block_id = '';
	var $block_title = '';
	var $block_desc = '';
	
//	var $show_block = true;
	var $show_title = true;
//	var $show_stats = true;
	
	var $auth_view = false;
	var $auth_edit = false;
	var $auth_mod = false;
	
	var $module_root_path = '';
	var $block_file = '';
	var $block_edit_file = '';
	var $function_id = '';
	
//	var $dynamic_block_id = '';
//	var $is_dynamic = false;
	
//	var $total_subs = '';
//	var $sub_block_ids = '';
//	var $sub_block_sizes = '';
//	var $sub_inner_space = '';
//	var $is_sub = false;
			
	// ------------------------------
	// Properties
	//

	// none in this class.

	// ------------------------------
	// Constructor
	//

	// ------------------------------
	// Private Methods
	//

	function _set_all( $block_id, $unset = false )
	{
		global $userdata;
		
//		$this->block_info = $this->block_config[$block_id]['block_info'];		
//		$this->block_parameters = $this->block_config[$block_id]['block_parameters'];

		$this->block_id = $this->block_config[$block_id]['block_id'];		
		$this->block_title = $this->block_config[$block_id]['block_title'];		
		$this->block_desc = $this->block_config[$block_id]['block_desc'];
		
//		$this->show_block = $this->block_config[$block_id]['show_block'] == '1';
//		$this->show_title = $this->block_config[$block_id]['show_title'] == '1';
//		$this->show_stats = $this->block_config[$block_id]['show_stats'] == '1';
		
		$mx_is_auth_ary = array();
		$mx_is_auth_ary = block_auth( AUTH_VIEW, $block_id, $userdata, $this->block_config[$block_id]['auth_view'], $this->block_config[$block_id]['auth_view_group'] );
		$this->auth_view = $unset ? false : $mx_is_auth_ary['auth_view'];
		
		$mx_is_auth_ary = array();
		$mx_is_auth_ary = block_auth( AUTH_EDIT, $block_id, $userdata, $this->block_config[$block_id]['auth_edit'], $this->block_config[$block_id]['auth_edit_group'] );
		$this->auth_edit = $unset ? false : $mx_is_auth_ary['auth_edit'];
		$this->auth_mod = $unset ? false : $mx_is_auth_ary['auth_mod'];
			
//		$this->block_time = $this->block_config[$block_id]['block_time'];		
//		$this->editor_id = $this->block_config[$block_id]['block_editor_id'];
		
		$this->module_root_path = $this->block_config[$block_id]['module_root_path'];
		$this->block_file = $this->block_config[$block_id]['block_file'];
		$this->block_edit_file = $this->block_config[$block_id]['block_edit_file'];
		$this->function_id = $this->block_info['function_id'];
		
//		$this->is_dynamic = $unset ? false : $this->_is_dynamic( $block_id );
//		$this->is_sub = $unset ? false : $this->_is_sub( $block_id );
		
	}

	// ------------------------------
	// Public Methods
	//

	function init( $block_id )
	{
		global $mx_cache;
		
	 	$this->block_config = $mx_cache->read( $block_id, MX_BLOCK );
	 	$this->_set_all( $block_id );
	}	

}	// class mx_block


// --------------------------------------------------------------------------------
// Class: mx_block
//

//
// Usage examples:
//

class mx_page
{
	//
	// Implementation Conventions:
	// Properties and methods prefixed with underscore are intented to be private. ;-)
	//

	// ------------------------------
	// Vars
	//
	
	var $page_config = array();
	
	var $info = array();
	var $columns = array();
	var $blocks = array();
	
	var $total_column = '';
	var $total_block = '';
	
	var $auth_view = false;

	// ------------------------------
	// Properties
	//

	// none in this class.

	// ------------------------------
	// Constructor
	//

	// ------------------------------
	// Private Methods
	//

	function _set_all( $page_id )
	{
		global $userdata, $mx_root_path, $HTTP_GET_VARS;
		
		$this->info = $this->page_config[$page_id]['page_info'];
		
		$mx_is_auth_ary = array();
		$mx_is_auth_ary = page_auth( AUTH_VIEW, $userdata, $this->info['page_auth_view'], $this->info['page_auth_view_group'] );
		$this->auth_view = $mx_is_auth_ary['auth_view'];
				
		$this->columns = $this->page_config[$page_id]['columns'];
		$this->total_column = count($this->columns);
		
		$this->blocks = $this->page_config[$page_id]['blocks'];
		$this->total_block = count($this->blocks);	
		
	}
		
	// ------------------------------
	// Public Methods
	//

	function init( $page_id )
	{
		global $mx_cache;
		
	 	$this->page_config = $mx_cache->read( $page_id, MX_PAGE );
	 	$this->_set_all( $page_id );
	}	

	function kill_me( $page_id )
	{
		global $mx_cache;
		
	 	$this->page_config = '';
	}		
	
}	// class mx_page

//
// -------------------------------------------------------------------------------------------------------------
// For compatibility with old block calls
//

function read_block_config( $block_id, $cache = true )
{
	global $mx_cache, $mx_block, $mx_split_block, $block_config;
	
	if ( !empty( $mx_block->block_config[$block_id] ))
	{
		return $mx_block->block_config;
	}
	
	if ( !empty( $mx_split_block->block_config[$block_id] ) )
	{
		return $mx_split_block->block_config;
	}	
	
	return $mx_cache->read( $block_id, MX_BLOCK, !$cache );
		
}

function update_session_cache( $block_id = '' )
{
	global $mx_cache;
	
	$mx_cache->update( MX_BLOCK, $block_id );
}
?>