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
 *    $Id: mx_functions.php,v 1.1 2010/10/10 14:59:41 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

/**
 * Included functions in this file:
 * - get_info
 * - get_exists
 * - get_list
 * - get_list_static
 * - get_list_multiple
 * - get_list_formatted
 * - get_list_opt
 * - poll_select
 * - mx_url
 * - mx_this_url
 * - mx_session_start
 * - post_icons
 * - get_page_id
 * - mx_add_search_words
 * - mx_remove_search_post
 * - qsort_multiarray
 * - compose_mx_copy
 */

/**
 * Included classes in this file:
 * - mx_request_vars
 * - mx_dynamic_
 */

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}
 
/********************************************************************************\
|
\********************************************************************************/
function mx_get_info($table, $idfield = '', $id = 0, $idfield2 = '', $id2 = 0)
{
	global $db;

	$sql = "SELECT * FROM $table WHERE $idfield = '$id'";
	$sql .= ( $idfield2 != '' && $id2 != '' ) ? " AND $idfield2 = '$id2'" : '';
	$sql .= ' LIMIT 1';

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get $table information", '', __LINE__, __FILE__, $sql);
	}

	$return = $db->sql_fetchrow($result);
	return $return;
}

/********************************************************************************\
|
\********************************************************************************/
function get_exists($table, $idfield = '', $id = 0)
{
	global $db;

	$sql = "SELECT COUNT(*) AS total FROM $table WHERE $idfield = $id";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get block/Column information", '', __LINE__, __FILE__, $sql);
	}

	$count = $db->sql_fetchrow($result);
	$count = $count['total'];

	$return['number'] = $count;
	return $return;
}

/********************************************************************************\
|
\********************************************************************************/
function mx_get_list($name_select, $table, $idfield, $namefield, $id, $select = false, $idfield2 = '' , $id2 = '')
{
	global $db;

	$sql = "SELECT * FROM $table";

	if( !$select )
	{
		$sql .= " WHERE $idfield <> $id";
	}
	if( !$select && !empty($id2) )
	{
		$sql .= " AND $idfield2 = $id2";
	}
	if( $select && !empty($id2) )
	{
		$sql .= " WHERE $idfield2 = $id2";
	}	
	$sql .= " ORDER BY $namefield";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get list of Column/blocks", '', __LINE__, __FILE__, $sql);
	}

	$column_list = '<select name="' . $name_select . '">';

	while( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row[$idfield] == $id ) ? ' selected="selected"' : '';
		$column_list .= '<option value="' . $row[$idfield] . '"' . $selected . '>' . $row[$namefield] . "</option>\n";
	}

	$column_list .= '</select>';
	return $column_list;
}

/********************************************************************************\
|
\********************************************************************************/
function get_list_static($name_select, $row, $id, $full_list = true)
{
	$rows_count = ( count($row) < '25' ) ? count($row) : '25';
	
	$full_list_true = $full_list ? ' size="' . $rows_count . '"' : '';

	$column_list = '<select name="' . $name_select .'" ' . $full_list_true . '>';

	foreach( $row as $idfield => $namefield )
	{
		$selected = ( $idfield == $id ) ? ' selected="selected"' : '';
		$column_list .= '<option value="' . $idfield . '"' . $selected . '>' . $namefield . "</option>\n";
	}

	$column_list .= '</select>';
	return $column_list;
}

/********************************************************************************\
|
\********************************************************************************/
function get_list_multiple($name_select, $table, $idfield, $namefield, $id_list, $select, $namefield2 = '')
{
	global $db;

	$sql = "SELECT * FROM $table";

	if( !$select )
	{
		$sql .= " WHERE $idfield NOT IN ( $id_list )";
	}
	$sql .= " ORDER BY $namefield";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get list of Column/blocks", '', __LINE__, __FILE__, $sql);
	}

	$id_list = explode(',', $id_list);

	$rows_count = $db->sql_numrows($result);
	$rows_count = ( $rows_count < '25' ) ? $rows_count : '25';

	$column_list = '<select name="' . $name_select . '" size="' . $rows_count . '" multiple="multiple">';

	while( $row = $db->sql_fetchrow($result) )
	{
		$namefield_desc = !empty($row[$namefield2]) ? ' (' . $row[$namefield2] . ')' : '';  
		$selected = ( in_array($row[$idfield], $id_list) ) ? ' selected="selected"' : '';
		$column_list .= '<option value="' . $row[$idfield] . '"' . $selected . '>' . $row[$namefield] . $namefield_desc . "</option>\n";
	}

	$column_list .= '</select>';
	return $column_list;
}

/********************************************************************************\
| function get_list_formatted()
| -------------------------------------------------------------------------------
| This function creates a drop down select menu, either for pages, functions or blocks.
| The block dropdown may also be filtered for specific functions (by passing the function file)
|
| $type: 'page_list', 'function_list', 'block_list' or 'dyn_block_list' (core 2.8)
| $id: selected id
| $name_select: the name id for the select form
| $function_file: for filtering blocklists
\********************************************************************************/
function get_list_formatted($type, $id, $name_select = '', $function_file = '', $multiple_select = false)
{
	global $db, $lang;

	if( $type == 'page_list' )
	{
		//
		// get pages dropdown
		//
		$name_select = empty($name_select) ? 'page_id' : $name_select;
		$idfield = 'page_id';
		$namefield = 'page_name';
		$descfield = 'page_desc';

		$sql = "SELECT *
			FROM " . PAGE_TABLE . "
			ORDER BY page_name ASC, page_desc ASC";
	}
	elseif( $type == 'function_list' )
	{
		//
		// get functions dropdown
		//
		$name_select = 'function_id';
		$idfield = 'function_id';
		$namefield = 'function_name';

		$sql = "SELECT function_admin, fnc.function_name, fnc.function_id, fnc.function_desc, fnc.module_id, mdl.module_name, mdl.module_id, mdl.module_desc
			FROM " . FUNCTION_TABLE . " fnc,
				" . MODULE_TABLE . " mdl
			WHERE mdl.module_id = fnc.module_id
			ORDER BY mdl.module_name ASC, fnc.function_name ASC";
	}
	elseif( $type == 'block_list' )
	{
		//
		// get all blocks dropdown (optionally filtering by function_file)
		//
		$idfield = 'block_id';
		$namefield = 'block_title';
		$descfield = 'block_desc';

		$function_file_filter = ( !empty($function_file) ? " AND fnc.function_file = '$function_file'" : '' );

		$sql = "SELECT blk.*, function_admin, fnc.function_name, fnc.function_id, fnc.function_desc, fnc.module_id, mdl.module_name, mdl.module_id, mdl.module_desc
			FROM " . BLOCK_TABLE . " blk,
				" . FUNCTION_TABLE . " fnc,
				" . MODULE_TABLE . " mdl
			WHERE blk.function_id = fnc.function_id
				AND mdl.module_id = fnc.module_id
				$function_file_filter
			ORDER BY mdl.module_name ASC, fnc.function_name ASC";
	}
	elseif( $type == 'dyn_block_list' )
	{
		//
		// get all dynamic blocks dropdown (2.8)
		//
		$idfield = 'block_id';
		$namefield = 'block_title';
		$descfield = 'block_desc';

		$sql = "SELECT blk.*, function_admin, fnc.function_name, fnc.function_id, fnc.function_desc, fnc.module_id, mdl.module_name, mdl.module_id, mdl.module_desc
			FROM " . BLOCK_TABLE . " blk,
				" . FUNCTION_TABLE . " fnc,
				" . MODULE_TABLE . " mdl
			WHERE blk.function_id = fnc.function_id
				AND mdl.module_id = fnc.module_id
				AND fnc.function_file = 'mx_dynamic.php'
			ORDER BY mdl.module_name ASC, fnc.function_name ASC";
	}

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get list of Column/blocks", '', __LINE__, __FILE__, $sql);
	}

	if ($multiple_select)
	{
		$multiple_select_option = 'multiple="multiple"';
	}
	
	$column_list = '<select name="' . $name_select . '" '.$multiple_select_option.'>';

	if( $type == 'page_list' )
	{
		$column_list .= '<option value="0">' . "- not selected</option>\n";
	}

	if( $total_blocks = $db->sql_numrows($result) )
	{
		$row = $db->sql_fetchrowset($result);
	}

	for( $j = 0; $j < $total_blocks; $j++ )
	{
		if( $row[$j]['module_name'] != $row[$j-1]['module_name'] )
		{
			$column_list .= '<option value="">' . 'Module: ' . $row[$j]['module_name'] . '----------' . "</option>\n";
		}

		if( $type == 'block_list' )
		{
			if( $row[$j]['function_name'] != $row[$j-1]['function_name'] )
			{
				$block_type = $row[$j]['function_name'] . ': ';
			}
		}
		else
		{
			$block_type = '';
		}

		if( !empty($descfield) )
		{
			$block_description_str = !empty($row[$j][$descfield]) ? ' (' . $row[$j][$descfield] . ')' : ' (no desc)';
		}
		else
		{
			$block_description_str = '';
		}

		$selected = ( $row[$j][$idfield] == $id ) ? ' selected="selected"' : '';
		$column_list .= '<option value="' . $row[$j][$idfield] . '"' . $selected . '>&nbsp;&nbsp;- ' . $block_type . $row[$j][$namefield] . $block_description_str . "</option>\n";
	}

	$column_list .= '</select>';
	return $column_list;
}

/********************************************************************************\
|
\********************************************************************************/
function get_list_opt($name_select, $table, $idfield, $namefield, $id, $select)
{
	global $db, $lang;

	$sql = "SELECT * FROM $table";

	if( ! $select )
	{
		$sql .= " WHERE $idfield <> $id";
	}
	$sql .= " ORDER BY $namefield";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get list of Column/blocks", '', __LINE__, __FILE__, $sql);
	}

	$column_list = '<select name="'. $name_select . '">';

	$selected = ( $id == 0 ) ? ' selected="selected"' : '';
	$column_list .= '<option value="0"' . $selected . '>' . $lang['Not_Specified'] . "</option>\n";

	while( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row[$idfield] == $id ) ? ' selected="selected"' : '';
		$column_list .= "<option value=\"$row[$idfield]\"$s>" . $row[$namefield] . "</option>\n";
	}

	$column_list .= '</select>';
	return $column_list;
}

/********************************************************************************\
| Pick a poll list combo
\********************************************************************************/
function poll_select($default_poll, $select_name = 'Poll_Topic_id')
{
	global $db;

	$style_select = '<select name="' . $select_name . '">';

	$selected = ( $default_poll == 0 ) ? ' selected="selected"' : '';
	$style_select .= '<option value="0"' . $selected . '>' . 'The most recent' . "</option>\n";

	$sql = "SELECT topic_id, vote_text
		FROM " . VOTE_DESC_TABLE . "
		ORDER BY vote_text, topic_id";
	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't query polls table", '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row['topic_id'] == $default_poll ) ? ' selected="selected"' : '';
		$style_select .= '<option value="' . $row['topic_id'] . '"' . $selected . '>' . $row['vote_text'] . "</option>\n";
	}

	$style_select .= '</select>';
	return $style_select;
}

/********************************************************************************\
|
\********************************************************************************/
function mx_url()
{
	global $SID, $HTTP_SERVER_VARS;

	$numargs = func_num_args();

	$url = $PHP_SELF . '?' . $HTTP_SERVER_VARS['QUERY_STRING']; 

	$url = parse_url($url);

	$url_array = array();
	if( ! empty($url['query']) )
	{
		$url_array = explode('&', $url['query']);
	}

	$arg_list = func_get_args(); 
	// Check for each option if exists in the parameter list
	for( $i = 0; $i < $numargs; $i++ )
	{
		$option = $arg_list[$i];
		$i++;
		$value = $arg_list[$i]; 
		// If not exists in the parameter list then add the parameter
		$opt_fund = false;
		for( $j = 0; $j < count($url_array); $j++ )
		{
			$tmp = explode('=', $url_array[$j]);
			if( $option == $tmp[0] )
			{
				$url_array[$j] = $option . '=' . $value ;
				$opt_fund = true;
			}
		}
		if( !$opt_fund )
		{
			$next = count($url_array);
			$url_array[$next] = $option . '=' . $value ;
		}
	}

	$url = $url['path']; 
	// Build the parameter list
	if( !strpos($url, '?') )
	{
		$url .= '?';
	}

	$url .= implode('&', $url_array);
	/*  for ($j = 0; $j < count($url_array); $j++)
	{
	if( $j < count($url_array) -1 )
	{
	$url .= $url_array[$j] . "&"  ;
	}
	else
	{
	$url .= $url_array[$j];
	}
	}
	*/
	$url = str_replace('?&', '?', $url);
	$url = str_replace('.php&', ".php?", $url);
	return $url;
}

/********************************************************************************\
| MX add-on
| Generate paths for page and standalone mode
| ...function based on original function written by Markus :-)
\********************************************************************************/
function mx_this_url($args = '', $force_standalone_mode = false, $file = '')
{
	global $mx_root_path, $module_root_path, $page_id, $phpEx, $is_block;

	if( $force_standalone_mode )
	{
		$mxurl = ( $file == '' ? "./" : $file . '/' ) . ( $args == '' ? '' : '?' . $args );
	}
	else
	{
		$mxurl = $mx_root_path . 'index.' . $phpEx;
		if( is_numeric($page_id) )
		{
			$mxurl .= '?page=' . $page_id . ( $args == '' ? '' : '&amp;' . $args );
		}
		else
		{
			$mxurl = "./" . ( $args == '' ? '' : '?' . $args );
		}
	}
	return $mxurl;
}

/********************************************************************************\
| PHP Sessions Management
| If necessary, GZIP initialization should be done before session_start().
\********************************************************************************/
function mx_session_start()
{
	global $board_config, $HTTP_SERVER_VARS, $do_gzip_compress;

	//
	// Prevent from doing the job more than once.
	//
	static $_been_here_before = false;

	if ( $_been_here_before )
	{
		return;
	}
	$_been_here_before = true;

	//
	// gzip_compression
	//

	//
	// declared in common.php, just before calling mx_session_start. ;-)
	//
	//	$do_gzip_compress = FALSE;

	if ( $board_config['gzip_compress'] && !defined('MX_GZIP_DISABLED') )
	{
		$phpver = phpversion();

		$useragent = (isset($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) ? $HTTP_SERVER_VARS['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

		if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
		{
			if ( extension_loaded('zlib') )
			{
				ob_end_clean();
				ob_start('ob_gzhandler');
			}
		}
		else if ( $phpver > '4.0' )
		{
			if ( strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') )
			{
				if ( extension_loaded('zlib') )
				{
					$do_gzip_compress = TRUE;
					ob_start();
					ob_implicit_flush(0);

					header('Content-Encoding: gzip');
				}
			}
		}
	}

	//
	// Initialize PHP session
	//
	session_start();
}
/**
 * Get userdata
 *
 * Get Userdata, $user can be username or user_id. If force_str is true, the username will be forced.
 * Cached sql, since this function is used for every block.
 *
 * @param unknown_type $user id or name
 * @param boolean $force_str force clean_username
 * @return array
 */
function mx_get_userdata($user, $force_str = false)
{
	global $db;

	if (!is_numeric($user) || $force_str)
	{
		$user = phpbb_clean_username($user);
	}
	else
	{
		$user = intval($user);
	}

	$sql = "SELECT *
		FROM " . USERS_TABLE . "
		WHERE ";
	$sql .= ((is_integer($user)) ? "user_id = $user" : "username = '" .  str_replace("\'", "''", $user) . "'" ) . " AND user_id <> " . ANONYMOUS;
	if (!($result = $db->sql_query($sql, 120)))
	{
		mx_message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
	}

	$return = ($row = $db->sql_fetchrow($result)) ? $row : false;
	$db->sql_freeresult($result);
	return $return;
}
/**
 * Style select.
 *
 * Pick a template/theme.
 *
 * @param string $default_style
 * @param string $select_name
 * @param string $dirname
 * @return string (html)
 */
function mx_style_select($default_style, $select_name = "style", $dirname = "templates", $show_instruction = false)
{
	global $db, $lang, $mx_root_path;
	
	$sql = "SELECT themes_id, style_name
		FROM " . THEMES_TABLE . "'
		ORDER BY template_name, themes_id";
	if (!($result = $db->sql_query($sql, 300)))
	{
		$sql = "SELECT themes_id, style_name
			FROM " . THEMES_TABLE . "'
			ORDER BY template_name, themes_id";
		if (!($result = $db->sql_query($sql, 300)))
		{
			mx_message_die(GENERAL_ERROR, "Couldn't query themes table", "", __LINE__, __FILE__, $sql);
		}
		$lang['Select_page_style'] = 'Bad Style-Backend';
		$show_instruction = true;		
	}
	
	$style_select = '<select name="' . $select_name . '">';
	$selected1 = ($default_style == -1) ? ' selected="selected"' : '';
	if ($show_instruction)
	{
		$style_select .= '<option value="-1"' . $selected1 . '>' . $lang['Select_page_style'] . '</option>';
	}			
	
	while (!($row = $db->sql_fetchrow($result)))
	{
		$sql = "SELECT themes_id, style_name
			FROM " . THEMES_TABLE . "'
			ORDER BY template_name, themes_id";
		if (!($result = $db->sql_query($sql, 300)))
		{
			mx_message_die(GENERAL_ERROR, "Couldn't query themes table", "", __LINE__, __FILE__, $sql);
		}
	}	
	while ($row = $db->sql_fetchrow($result))
	{
		$id = $row['themes_id'];
		$selected = ($id == $default_style && !$selected1) ? ' selected="selected"' : '';
		$style_select .= '<option value="' . $id . '"' . $selected . '>' . $row['style_name'] . '</option>';
	}
	$db->sql_freeresult($result);
	
	$style_select .= "</select>";
	return $style_select;
}
/********************************************************************************\
| function get_page_id()
| -------------------------------------------------------------------------------
| This function fill find the page on which a block is located, provided a block_id.
| First instance found is returned.
| Eg: get_page_id( $block_id )
|
| If no block_id is available you can find the page provided the function file.
| First instance found is returned.
| Eg: get_page_id('dload.php', true)
\********************************************************************************/
function get_page_id($search_item, $use_function_file = false, $get_page_data_array = false)
{
	global $db, $userdata, $mx_config_cache;

	//
	// Try to reuse group_id results.
	//
	$cache_key = 'pagemap_block' . $search_item;
	
	$page_id_array = array();
	if ( $mx_config_cache->exists( $cache_key ) )
	{
		$page_id_array = unserialize( $mx_config_cache->get( $cache_key ) );
	}
	else
	{
		if( $use_function_file )
		{
			$sql = "SELECT * FROM " . FUNCTION_TABLE . " WHERE function_file = '$search_item' LIMIT 1";
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Could not query Activity Mod module information", '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$function_id = $row['function_id'];
	
			$sql = "SELECT * FROM " . BLOCK_TABLE . " WHERE function_id = '$function_id' LIMIT 1";
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Could not query " . $search_item . " module information", '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$search_item = $row['block_id'];
		}
	
		//
		// First, see if we can get the page_id from ordinary blocks
		//
		$sql = "SELECT pag.page_id, pag.page_name, pag.page_desc
			FROM " . COLUMN_BLOCK_TABLE . " bct,
		       	" . PAGE_TABLE . " pag,
				" . COLUMN_TABLE . " col    
			WHERE pag.page_id = col.page_id
				AND bct.column_id = col.column_id
				AND bct.block_id = '" . $search_item . "'
	   		ORDER BY pag.page_id
			LIMIT 1";
	
		if( !($p_result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Could not query column list", '', __LINE__, __FILE__, $sql);
		}
		$p_row = $db->sql_fetchrow($p_result);
	
		if( empty($p_row['page_id']) )
		{
			//
			// Find all dynamic block Page_ids, if not present as ordinary block
			//
			$sql = "SELECT pag.page_id, pag.page_name, pag.page_desc, nav.block_id
				FROM " . PAGE_TABLE . " pag,
					" . BLOCK_TABLE . " blk,
					" . MENU_NAV_TABLE . " nav,
					" . MENU_CAT_TABLE . " nac
				WHERE pag.page_id = nav.page_id AND nav.page_id > 0
					AND nac.cat_id = nav.cat_id
					AND nav.block_id = blk.block_id
					AND nav.block_id = '" . $search_item . "'
				ORDER BY blk.block_id
				LIMIT 1";
		
			if( !($p_result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Could not query column list", '', __LINE__, __FILE__, $sql);
			}
			$p_row = $db->sql_fetchrow($p_result);
		}
		
		
		if( empty($p_row['page_id']) )
		{
			//
			// Find all subblock page_ids
			//
			$sql = "SELECT pag.page_id, pag.page_name, pag.page_desc, sys.parameter_value
				FROM " . COLUMN_BLOCK_TABLE . " bct,
			       	" . PAGE_TABLE . " pag,
					" . COLUMN_TABLE . " col,    
					" . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,    
					" . PARAMETER_TABLE . " par    
				WHERE pag.page_id = col.page_id
					AND bct.column_id = col.column_id
					AND bct.block_id = sys.block_id
					AND sys.parameter_id = par.parameter_id
					AND par.parameter_name = 'block_ids'
		   		ORDER BY sys.block_id";
		
			if( !($p_result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Could not query column list", '', __LINE__, __FILE__, $sql);
			}
			
			while( $temp_row = $db->sql_fetchrow($p_result) )
			{
				$block_ids_array = explode(',' , $temp_row['parameter_value']);
				
				foreach($block_ids_array as $key => $block_id)
				{
					if ($block_id = $search_item)
					{
						$p_row = $temp_row;
						continue;
					}
				}
				
				if (!empty($p_row['page_id']))
				{
					continue;
				}
			}
		}		
		
		$page_id_array = array();
		if (!empty($p_row['page_id']))
		{
			$page_id_array['page_id'] = $p_row['page_id'];	
			$page_id_array['page_name'] = $p_row['page_name'];	
			$page_id_array['page_desc'] = $p_row['page_desc'];	
			$page_id_array['block_id'] = $p_row['block_id'];	
		}
		
		$mx_config_cache->put( $cache_key, serialize($page_id_array) );
	}

	if ( $get_page_data_array && !empty($page_id_array['page_id']) )
	{
		$return = $page_id_array;
	}
	else if(!empty($page_id_array['page_id']))
	{
		$return = $page_id_array['page_id'];
	}
	else 
	{
		$return = '';
	}
			
	return $return;
}

/********************************************************************************\
| Generate icon lists
| Snatched frompafilDB
\********************************************************************************/
function post_icons( $icon_dir = '', $file_posticon = '', $modules_path = '' )
{
	global $lang, $phpbb_root_path, $module_root_path, $mx_root_path; 
	// MX
	global $mx_root_path, $module_root_path, $is_block, $phpEx;
	$curicons = 1;

	if ( $file_posticon == 'none' || $file_posticon == 'none.gif' or empty( $file_posticon ) )
	{
		$posticons .= '<input type="radio" name="menuicons" value="none" checked><a class="gensmall">' . $lang['None'] . '</a>&nbsp;';
	}
	else
	{
		$posticons .= '<input type="radio" name="menuicons" value="none"><a class="gensmall">' . $lang['None'] . '</a>&nbsp;';
	}
	/*
	$handle = @opendir($phpbb_root_path . ICONS_DIR);
	*/ 
	// MX
	// echo($mx_root_path . $modules_path . TEMPLATE_ROOT_PATH .'images/' . $icon_dir);
	$handle = @opendir( $mx_root_path . $modules_path . TEMPLATE_ROOT_PATH . 'images/' . $icon_dir );

	while ( $icon = @readdir( $handle ) )
	{
		if ( $icon !== '.' && $icon !== '..' && $icon !== 'index.htm' )
		{
			if ( $file_posticon == $icon )
			{
				/* - orig
				$posticons .= '<input type="radio" name="posticon" value="' . $icon . '" checked><img src="' . $phpbb_root_path . ICONS_DIR . $icon . '">&nbsp;';
				*/ 
				// MX
				$posticons .= '<input type="radio" name="menuicons" value="' . $icon . '" checked><img src="' . $mx_root_path . $modules_path . TEMPLATE_ROOT_PATH . 'images/' . $icon_dir . $icon . '">&nbsp;';
			}
			else
			{
				/* - orig
				$posticons .= '<input type="radio" name="posticon" value="' . $icon . '"><img src="' . $phpbb_root_path . ICONS_DIR . $icon . '">&nbsp;';
				*/ 
				// MX
				$posticons .= '<input type="radio" name="menuicons" value="' . $icon . '"><img src="' . $mx_root_path . $modules_path . TEMPLATE_ROOT_PATH . 'images/' . $icon_dir . $icon . '">&nbsp;';
			}

			$curicons++;

			if ( $curicons == 8 )
			{
				$posticons .= '<br>';
				$curicons = 0;
			}
		}
	}
	@closedir( $handle );
	return $posticons;
}

/********************************************************************************\
| Add search words for blocks
\********************************************************************************/
function mx_add_search_words($mode, $post_id, $post_text, $post_title = '', $mx_mode = 'mx')
{
	global $db, $phpbb_root_path, $board_config, $lang;

	// $search_match_table = SEARCH_MATCH_TABLE;
	// $search_word_table = SEARCH_WORD_TABLE;
	
	switch ( $mx_mode )
	{
		case 'mx':
			$search_match_table = MX_MATCH_TABLE;
			$search_word_table = MX_WORD_TABLE;
			$db_key = 'block_id';
		break;
		case 'kb':
			$search_match_table = KB_MATCH_TABLE;
			$search_word_table = KB_WORD_TABLE;
			$db_key = 'article_id';	
		break;	
	}
	
	$stopword_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . "/search_stopwords.txt"); 
	$synonym_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . "/search_synonyms.txt"); 

	$search_raw_words = array();
	$search_raw_words['text'] = split_words(clean_words('post', $post_text, $stopword_array, $synonym_array));
	$search_raw_words['title'] = split_words(clean_words('post', $post_title, $stopword_array, $synonym_array));

	@set_time_limit(0);

	$word = array();
	$word_insert_sql = array();
	while ( list($word_in, $search_matches) = @each($search_raw_words) )
	{
		$word_insert_sql[$word_in] = '';
		if ( !empty($search_matches) )
		{
			for ($i = 0; $i < count($search_matches); $i++)
			{ 
				$search_matches[$i] = trim($search_matches[$i]);

				if( $search_matches[$i] != '' ) 
				{
					$word[] = $search_matches[$i];
					if ( !strstr($word_insert_sql[$word_in], "'" . $search_matches[$i] . "'") )
					{
						$word_insert_sql[$word_in] .= ( $word_insert_sql[$word_in] != '' ) ? ", '" . $search_matches[$i] . "'" : "'" . $search_matches[$i] . "'";
					}
				} 
			}
		}
	}

	if ( count($word) )
	{
		sort($word);

		$prev_word = '';
		$word_text_sql = '';
		$temp_word = array();
		for($i = 0; $i < count($word); $i++)
		{
			if ( $word[$i] != $prev_word )
			{
				$temp_word[] = $word[$i];
				$word_text_sql .= ( ( $word_text_sql != '' ) ? ', ' : '' ) . "'" . $word[$i] . "'";
			}
			$prev_word = $word[$i];
		}
		$word = $temp_word;

		$check_words = array();
		switch( SQL_LAYER )
		{
			case 'postgresql':
			case 'msaccess':
			case 'mssql-odbc':
			case 'oracle':
			case 'db2':
				$sql = "SELECT word_id, word_text     
					FROM " . $search_word_table . " 
					WHERE word_text IN ($word_text_sql)";
				if ( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not select words', '', __LINE__, __FILE__, $sql);
				}

				while ( $row = $db->sql_fetchrow($result) )
				{
					$check_words[$row['word_text']] = $row['word_id'];
				}
				break;
		}

		$value_sql = '';
		$match_word = array();
		for ($i = 0; $i < count($word); $i++)
		{ 
			$new_match = true;
			if ( isset($check_words[$word[$i]]) )
			{
				$new_match = false;
			}

			if ( $new_match )
			{
				switch( SQL_LAYER )
				{
					case 'mysql':
					case 'mysql4':
					case 'mysqli':					
						$value_sql .= ( ( $value_sql != '' ) ? ', ' : '' ) . '(\'' . $word[$i] . '\', 0)';
					break;
					case 'mssql':
					case 'mssql-odbc':
						$value_sql .= ( ( $value_sql != '' ) ? ' UNION ALL ' : '' ) . "SELECT '" . $word[$i] . "', 0";
					break;
					default:
						$sql = "INSERT INTO " . $search_word_table . " (word_text, word_common) 
							VALUES ('" . $word[$i] . "', 0)"; 
						if( !$db->sql_query($sql) )
						{
							mx_message_die(GENERAL_ERROR, 'Could not insert new word', '', __LINE__, __FILE__, $sql);
						}
					break;
				}
			}
		}

		if ( $value_sql != '' )
		{
			switch ( SQL_LAYER )
			{
				case 'mysql':
				case 'mysql4':
				case 'mysqli':				
					$sql = "INSERT IGNORE INTO " . $search_word_table . " (word_text, word_common) 
						VALUES $value_sql"; 
					break;
				case 'mssql':
				case 'mssql-odbc':
					$sql = "INSERT INTO " . $search_word_table . " (word_text, word_common) 
						$value_sql"; 
					break;
			}

			if ( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not insert new word', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	while( list($word_in, $match_sql) = @each($word_insert_sql) )
	{
		$title_match = ( $word_in == 'title' ) ? 1 : 0;

		if ( $match_sql != '' )
		{
			$sql = "INSERT INTO " . $search_match_table . " ($db_key, word_id, title_match) 
				SELECT $post_id, word_id, $title_match  
					FROM " . $search_word_table . " 
					WHERE word_text IN ($match_sql)"; 
			if ( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not insert new word matches', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	if ($mode == 'single')
	{
		remove_common('single', 4/10, $word);
	}

	return;
}

/********************************************************************************\
|
\********************************************************************************/
function mx_remove_search_post($post_id_sql, $mx_mode = 'mx')
{
	global $db;

	// $search_match_table = SEARCH_MATCH_TABLE;
	// $search_word_table = SEARCH_WORD_TABLE;
	
	switch ( $mx_mode )
	{
		case 'mx':
			$search_match_table = MX_MATCH_TABLE;
			$search_word_table = MX_WORD_TABLE;
			$db_key = 'block_id';
		break;
		case 'kb':
			$search_match_table = KB_MATCH_TABLE;
			$search_word_table = KB_WORD_TABLE;
			$db_key = 'article_id';	
		break;	
	}
	
	$words_removed = false;

	switch ( SQL_LAYER )
	{
		case 'mysql':
		case 'mysql4':
		case 'mysqli':		
			$sql = "SELECT word_id 
				FROM " . $search_match_table . " 
				WHERE $db_key IN ($post_id_sql) 
				GROUP BY word_id";
			if ( $result = $db->sql_query($sql) )
			{
				$word_id_sql = '';
				while ( $row = $db->sql_fetchrow($result) )
				{
					$word_id_sql .= ( $word_id_sql != '' ) ? ', ' . $row['word_id'] : $row['word_id']; 
				}

				$sql = "SELECT word_id 
					FROM " . $search_match_table . " 
					WHERE word_id IN ($word_id_sql) 
					GROUP BY word_id 
					HAVING COUNT(word_id) = 1";
				if ( $result = $db->sql_query($sql) )
				{
					$word_id_sql = '';
					while ( $row = $db->sql_fetchrow($result) )
					{
						$word_id_sql .= ( $word_id_sql != '' ) ? ', ' . $row['word_id'] : $row['word_id']; 
					}

					if ( $word_id_sql != '' )
					{
						$sql = "DELETE FROM " . $search_word_table . " 
							WHERE word_id IN ($word_id_sql)";
						if ( !$db->sql_query($sql) )
						{
							mx_message_die(GENERAL_ERROR, 'Could not delete word list entry', '', __LINE__, __FILE__, $sql);
						}

						$words_removed = $db->sql_affectedrows();
					}
				}
			}
		break;

		default:
			$sql = "DELETE FROM " . $search_word_table . " 
				WHERE word_id IN ( 
					SELECT word_id 
					FROM " . $search_match_table . " 
					WHERE word_id IN ( 
						SELECT word_id 
						FROM " . $search_match_table . " 
						WHERE $db_key IN ($post_id_sql) 
						GROUP BY word_id 
					) 
					GROUP BY word_id 
					HAVING COUNT(word_id) = 1
				)"; 
			if ( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not delete old words from word table', '', __LINE__, __FILE__, $sql);
			}

			$words_removed = $db->sql_affectedrows();

		break;
	}

	$sql = "DELETE FROM " . $search_match_table . "  
		WHERE $db_key IN ($post_id_sql)";
	if ( !$db->sql_query($sql) )
	{
		mx_message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
	}

	return $words_removed;
}

/********************************************************************************\
|
\********************************************************************************/
function qsort_multiarray($array, $num = 0, $order = 'ASC', $left = 0, $right = -1)
{
	if( $right == -1 )
	{
		$right = count($array) - 1;
	}

	$links = $left;
	$rechts = $right;
	$mitte = $array[($left + $right) / 2][$num];

	if( $rechts > $links )
	{
		do {
			if( $order == 'ASC' )
			{
				while( $array[$links][$num]  < $mitte ) $links++;
				while( $array[$rechts][$num] > $mitte ) $rechts--;
			}
			else
			{
				while( $array[$links][$num]  > $mitte ) $links++;
				while( $array[$rechts][$num] < $mitte ) $rechts--;
			}
			if( $links <= $rechts )
			{
				$tmp = $array[$links];
				$array[$links++] = $array[$rechts];
				$array[$rechts--] = $tmp;
			}
       } while( $links <= $rechts );

       if( $left < $rechts ) $array = qsort_multiarray($array, $num, $order, $left,  $rechts);
       if( $links < $right ) $array = qsort_multiarray($array, $num, $order, $links, $right);
	}
	return $array;
}

/********************************************************************************\
| mx_parent_data(), will return function_id and module_id for given block_id. Else false 
\********************************************************************************/
function mx_parent_data($block_id = '', $key = '')
{
	global $db;
	
	if (empty($block_id))
	{
		return false;
	}

	$sql = "SELECT mdl.module_id, fnc.function_id, blk.block_id
		FROM " . MODULE_TABLE . " mdl,
	       	" . FUNCTION_TABLE . " fnc,
			" . BLOCK_TABLE . " blk    
		WHERE mdl.module_id = fnc.module_id
			AND fnc.function_id = blk.function_id
			AND blk.block_id = '" . $block_id . "'
		LIMIT 1";
	
	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain parents data", '', __LINE__, __FILE__, $sql);
	}	

	$parent_array = $db->sql_fetchrow($result);
	
	if (!empty($parent_array['module_id']))
	{
		if (!empty($key))
		{
			return $parent_array[$key];
		}
		return $parent_array;
	}
	
	return false;
}

/********************************************************************************\
|
\********************************************************************************/
function compose_mx_copy()
{
	global $table_prefix, $mx_table_prefix, $userdata, $phpEx, $template, $lang, $db, $board_config, $HTTP_POST_VARS, $page_title;

	$page_title = $lang['mx_copy'];

	$sql = "SELECT * FROM " . MODULE_TABLE . " ORDER BY module_id";
	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain modules from database", '', __LINE__, __FILE__, $sql);
	}

	$module = $db->sql_fetchrowset($result);

	$mx_module_copy = '<h1>' . $lang['mx_copy'] . '</h1><hr /><br />';
	$mx_module_copy .= $lang['mx_copy_text'] . '<br /><br />';
	$mx_module_copy .= $lang['mx_modules_text'] . '<br />';

	for( $i = 0; $i < count($module); $i++ )
	{ 
		if( !empty($module[$i]['module_version']) )
		{
			$mx_module_copy .= '<br />' . $module[$i]['module_version'] . ', ' . $module[$i]['module_copy'];
		}
	}

	$mx_module_copy = $mx_module_copy . '<br /><br /><hr />';

	mx_message_die(GENERAL_MESSAGE, $mx_module_copy, 'Modules info and copyrights');
}

/**
* Checks if a path ($path) is absolute or relative
*
* @param string $path Path to check absoluteness of
* @return boolean
*/
function mx_is_absolute($path)
{
	return (isset($path[0]) && $path[0] == '/' || preg_match('#^[a-z]:[/\\\]#i', $path)) ? true : false;
}

/**
 * Borrowed from phpBB
 *
* @author Chris Smith <chris@project-minerva.org>
* @copyright 2006 Project Minerva Team
* @param string $path The path which we should attempt to resolve.
* @return mixed
*/
function mx_own_realpath($path)
{
	global $request;

	// Now to perform funky shizzle

	// Switch to use UNIX slashes
	$path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
	$path_prefix = '';

	// Determine what sort of path we have
	if (mx_is_absolute($path))
	{
		$absolute = true;

		if ($path[0] == '/')
		{
			// Absolute path, *NIX style
			$path_prefix = '';
		}
		else
		{
			// Absolute path, Windows style
			// Remove the drive letter and colon
			$path_prefix = $path[0] . ':';
			$path = substr($path, 2);
		}
	}
	else
	{
		// Relative Path
		// Prepend the current working directory
		if (function_exists('getcwd'))
		{
			// This is the best method, hopefully it is enabled!
			$path = str_replace(DIRECTORY_SEPARATOR, '/', getcwd()) . '/' . $path;
			$absolute = true;
			if (preg_match('#^[a-z]:#i', $path))
			{
				$path_prefix = $path[0] . ':';
				$path = substr($path, 2);
			}
			else
			{
				$path_prefix = '';
			}
		}
		else if ($request->server('SCRIPT_FILENAME'))
		{
			// Warning: If chdir() has been used this will lie!
			// Warning: This has some problems sometime (CLI can create them easily)
			$filename = htmlspecialchars_decode($request->server('SCRIPT_FILENAME'));
			$path = str_replace(DIRECTORY_SEPARATOR, '/', dirname($filename)) . '/' . $path;
			$absolute = true;
			$path_prefix = '';
		}
		else
		{
			// We have no way of getting the absolute path, just run on using relative ones.
			$absolute = false;
			$path_prefix = '.';
		}
	}

	// Remove any repeated slashes
	$path = preg_replace('#/{2,}#', '/', $path);

	// Remove the slashes from the start and end of the path
	$path = trim($path, '/');

	// Break the string into little bits for us to nibble on
	$bits = explode('/', $path);

	// Remove any . in the path, renumber array for the loop below
	$bits = array_values(array_diff($bits, array('.')));

	// Lets get looping, run over and resolve any .. (up directory)
	for ($i = 0, $max = sizeof($bits); $i < $max; $i++)
	{
		// @todo Optimise
		if ($bits[$i] == '..' )
		{
			if (isset($bits[$i - 1]))
			{
				if ($bits[$i - 1] != '..')
				{
					// We found a .. and we are able to traverse upwards, lets do it!
					unset($bits[$i]);
					unset($bits[$i - 1]);
					$i -= 2;
					$max -= 2;
					$bits = array_values($bits);
				}
			}
			else if ($absolute) // ie. !isset($bits[$i - 1]) && $absolute
			{
				// We have an absolute path trying to descend above the root of the filesystem
				// ... Error!
				return false;
			}
		}
	}

	// Prepend the path prefix
	array_unshift($bits, $path_prefix);

	$resolved = '';

	$max = sizeof($bits) - 1;

	// Check if we are able to resolve symlinks, Windows cannot.
	$symlink_resolve = (function_exists('readlink')) ? true : false;

	foreach ($bits as $i => $bit)
	{
		if (@is_dir("$resolved/$bit") || ($i == $max && @is_file("$resolved/$bit")))
		{
			// Path Exists
			if ($symlink_resolve && is_link("$resolved/$bit") && ($link = readlink("$resolved/$bit")))
			{
				// Resolved a symlink.
				$resolved = $link . (($i == $max) ? '' : '/');
				continue;
			}
		}
		else
		{
			// Something doesn't exist here!
			// This is correct realpath() behaviour but sadly open_basedir and safe_mode make this problematic
			// return false;
		}
		$resolved .= $bit . (($i == $max) ? '' : '/');
	}

	// @todo If the file exists fine and open_basedir only has one path we should be able to prepend it
	// because we must be inside that basedir, the question is where...
	// @internal The slash in is_dir() gets around an open_basedir restriction
	if (!@file_exists($resolved) || (!@is_dir($resolved . '/') && !is_file($resolved)))
	{
		return false;
	}

	// Put the slashes back to the native operating systems slashes
	$resolved = str_replace('/', DIRECTORY_SEPARATOR, $resolved);

	// Check for DIRECTORY_SEPARATOR at the end (and remove it!)
	if (substr($resolved, -1) == DIRECTORY_SEPARATOR)
	{
		return substr($resolved, 0, -1);
	}

	return $resolved; // We got here, in the end!
}

/*
* Is this even used ?
**/
function mx_phpbb_realpath($path)
{	
	return mx_realpath($path);
}

if (!function_exists('realpath'))
{
	/**
	* A wrapper for realpath
	* @ignore
	*/
	function mx_realpath($path)
	{
		return mx_own_realpath($path);
	}
}
else
{
	/**
	* A wrapper for realpath
	*/
	function mx_realpath($path)
	{
		$realpath = realpath($path);
		
		// Strangely there are provider not disabling realpath but returning strange values. :o
		// We at least try to cope with them.
		if ($realpath === $path || $realpath === false)
		{
			return mx_own_realpath($path);
		}
		
		// Check for DIRECTORY_SEPARATOR at the end (and remove it!)
		if (substr($realpath, -1) == DIRECTORY_SEPARATOR)
		{
			$realpath = substr($realpath, 0, -1);
		}
		return $realpath;
	}
}

/**
 * Get langcode.
 *
 * This function loops all meta langcodes, to convert internal MX-Publisher lang to standard langcode
 *
 */
function mx_get_langcode()
{
	global $userdata, $mx_root_path, $board_config, $phpEx;

	//
	// Load language file.
	//
	if( @file_exists($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_meta.' . $phpEx) )
	{
		include($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_meta.' . $phpEx);
	}
	else
	{
		include($mx_root_path . 'language/lang_english/lang_meta.' . $phpEx);
	}

	foreach ($lang['mx_meta']['langcode'] as $langcode => $mxbbLang)
	{
		if ( strtolower($mxbbLang) == $userdata['user_lang'] )
		{
			return $langcode;
		}
	}
}

/**
 * update config.php values.
 *
 */
function update_portal_backend($new_backend = PORTAL_BACKEND)
{
	global $mx_root_path, $lang, $phpEx, $portal_config;

	if( @file_exists($mx_root_path . "config.$phpEx") )
	{
		@require($mx_root_path . "config.$phpEx");
	}

	$mx_portal_name = 'MX-Publisher Modular System';
	$dbcharacter_set = "uft8";

	/*
	$config = array(
		'dbms'		=> $dbms,
		'dbhost'		=> $dbhost,
		'dbname'		=> $dbname,
		'dbuser'		=> $dbuser,
		'dbpasswd'		=> $dbpasswd,
		'mx_table_prefix'		=> $mx_table_prefix,
		'portal_backend'		=> (!empty($portal_backend) ? $portal_backend : 'internal'),
	);
	*/

	$new_backend = ($new_backend) ? $new_backend  : 'internal';

	switch ($new_backend)
	{
		case 'internal':
		case 'phpbb3':
		case 'olympus':	
		case 'ascraeus':
		case 'mybb':
		default:
			$dbcharacter_set = defined('DBCHARACTER_SET') ? DBCHARACTER_SET : 'utf8';
		break;
		
		case 'phpbb2':
			$dbcharacter_set = defined('DBCHARACTER_SET') ? DBCHARACTER_SET : 'latin1';
		break;
		
		case 'smf2':
			// Load the settings...  Settings.php (to get SMF settings)
			if ((@include $smf_root_path . "Settings.$phpEx") === true)
			{
				$dbcharacter_set = (isset($db_character_set)) ? $db_character_set : "uft8";
			}			
		break;		
	}

	$process_msgs[] = 'Writing config ...<br />';

	$config_data = "<"."?php\n\n";
	$config_data .= "// $mx_portal_name auto-generated config file\n// Do not change anything in this file!\n\n";
	$config_data .= "// This file must be put into the $mx_portal_name directory, not into the phpBB directory.\n\n";
	$config_data .= '$'."dbms = '$dbms';\n\n";
	$config_data .= '$'."dbhost = '$dbhost';\n";
	$config_data .= '$'."dbname = '$dbname';\n";
	$config_data .= '$'."dbuser = '$dbuser';\n";
	$config_data .= '$'."dbpasswd = '$dbpasswd';\n\n";
	$config_data .= '$'."mx_table_prefix = '$mx_table_prefix';\n\n";
	$config_data .= "define('DBCHARACTER_SET', '$dbcharacter_set');\n\n";
	$config_data .= "define('MX_INSTALLED', true);\n\n";
	$config_data .= '?' . '>';	// Done this to prevent highlighting editors getting confused!

	@umask(0111);
	@chmod($mx_root_path . "config.$phpEx", 0644);

	if ( !($fp = @fopen($mx_root_path . 'config.' . $phpEx, 'w')) )
	{
		$process_msgs[] = "Unable to write config file " . $mx_root_path . "config.$phpEx" . "<br />\n";
	}
	$result = @fputs($fp, $config_data, strlen($config_data));
	@fclose($fp);

	$process_msgs[] = '<span style="color:pink;">'.str_replace("\n", "<br />\n", htmlspecialchars($config_data)).'</span>';

	$message = '<hr />';
	for( $i=0; $i < count($process_msgs); $i++ )
	{
		$message .= $process_msgs[$i] . ( $process_msgs[$i] == '<hr />' ? '' : '<br />' ) . "\n";
	}
	$message .= '<hr />';

	return $message;
}

function mx_clean_string($text)
{
	global $mx_root_path, $phpEx;
	
	//Unicode control characters
	static $homographs = array();
	if (empty($homographs) && ($homographs = @include($mx_root_path . 'includes/utf/data/confusables.' . $phpEx)))
	{
		$text = @utf8_case_fold_nfkc($text);
		$text = strtr($text, $homographs);
	}
	else
	{
		// ASCI control characters
		$text = preg_replace("/[^[:space:]a-zA-Z0-9åäöÅÄÖ.,-:]/", " ", $text);
		$text = preg_replace("/[^[:space:]a-zA-Z0-9îãâºþÎÃÂªÞ.,-:]/", " ", $text);
		
		// we need to reduce multiple spaces to a single one   
		$text = preg_replace('/\s+/', ' ', $text);		
	}	

	// Other control characters
	$text = preg_replace('#(?:[\x00-\x1F\x7F]+|(?:\xC2[\x80-\x9F])+)#', '', $text);

	// we need to reduce multiple spaces to a single one
	$text = preg_replace('# {2,}#', ' ', $text);

	// we can use trim here as all the other space characters should have been turned
	// into normal ASCII spaces by now
	return trim($text);
}

/**
 * function mx_t
* replacement for t()
 *
 */
function t($string, array $args = array(), array $options = array()) 
{
	global $lang, $mx_cache, $mx_user, $board_config;
	static $lang_string;
	// Merge in default.
	if (empty($options['langcode']))
	{
		$options['langcode'] = isset($lang['USER_LANG']) ? $lang['USER_LANG'] : $mx_user->encode_lang($board_config['default_lang']);
	}
	if (!empty($lang[$string]))
	{
		$lang_string = $lang[$string];
	}
	else
	{
		$lang_string = $string;
	}
	if (empty($args))
	{
		return $lang_string;
	}
	else
	{
		return $mx_cache->format_string($lang_string, $args);
	}
}

/**
* A wrapper for htmlcheck_plain($value, ENT_COMPAT, 'UTF-8')
* See also
* function utf8_htmlspecialchars($value)
* from
* @package utf
*/
function utf8_htmlcheck_plain($value)
{
	return htmlspecialchars($value, ENT_QUOTE, 'UTF-8');
}

/**
* Trying to display in a placeholder inside a message or text
*
*/
function mx_placeholder($message)
{
	// Adding placeholders to returned text
	return '<em class="placeholder">' . utf8_htmlcheck_plain($text) . '</em>';
}

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
 /*
if(!function_exists('ereg')) 
{     
	function ereg($pattern, $string, &$array)      
	{          
		return preg_match('#'.$pattern.'#', $string, $array);      
	} 
}
*/ 

/********************************************************************************\
| Class: mx_dynamic_select
| The mx_dynamic_select class generates dynamic select dropdown boxes: the javascript and form itself.
| 
| // 
| // Methods
| // 
| 
| $tpl_code = $mx_dynamic_select->generate();
| 
| //
| // Usage examples:
| //
| 
| $template->assign_block_vars('javamodule.javafunction.javablock', array(
|		'DYNAMIC_SELECT' => $tpl_code,
| 
| 	
\********************************************************************************/

//
// Flags 
//

class mx2_dynamic_select
{
	var $tpl = '';
	
	var $module_default_id = '';
	var $function_default_id = '';
	var $block_default_id = '';
	
	var $modules = array();
	var $moduleFunctions = array();
	var $functionBlocks = array();
	
	// ------------------------------
	// Private Methods
	//
	
	//
	// Get Modules - Functions - Blocks
	//
	
	function _get_data()
	{
		global $db, $template, $lang, $board_config, $userdata;
		
		$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;
		
		if (!$is_admin)
		{
			//
			// Authorization SQL
			//
			$auth_blocks = get_auth_blocks();
			$auth_sql = " AND blk.block_id in ( ". $auth_blocks. " ) ";
		}
		//
		//
		// Generate dynamic block select
		$sql = "SELECT blk.*, function_admin, fnc.function_name, fnc.function_id, fnc.function_desc, fnc.module_id, mdl.module_name, mdl.module_id, mdl.module_desc
			FROM " . BLOCK_TABLE . " blk,
				" . FUNCTION_TABLE . " fnc,
				" . MODULE_TABLE . " mdl
			WHERE blk.function_id = fnc.function_id
				AND mdl.module_id = fnc.module_id
				" . $auth_sql . "
			ORDER BY mdl.module_name ASC, fnc.function_name ASC";
		
		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't get list of Column/blocks", '', __LINE__, __FILE__, $sql);
		}
		
		if( $total_blocks = $db->sql_numrows($result) )
		{
			$row = $db->sql_fetchrowset($result);
		}
		
		$module_id = $function_id = $block_id = 0;
		
		for( $j = 0; $j < $total_blocks; $j++ )
		{
			if( $row[$j]['module_id'] != $row[$j-1]['module_id'] )
			{
				$module_desc_tmp = str_replace("\n", '', $row[$j]['module_desc']);
				$module_desc_tmp = str_replace("\r", '', $module_desc_tmp);		
				
				$module_id = $row[$j]['module_id'];
				$module_title = !empty($row[$j]['module_name']) ? addslashes(strip_tags(trim($row[$j]['module_name']))) : '';
				$module_desc = !empty($row[$j]['module_desc']) ? addslashes(strip_tags(trim($module_desc_tmp))) : '';
				
				$this->_addModule($module_id, $module_title, $module_desc);
			}
		
			if( $row[$j]['function_id'] != $row[$j-1]['function_id'] )
			{
				$function_desc_tmp = str_replace("\n", '', $row[$j]['function_desc']);
				$function_desc_tmp = str_replace("\r", '', $function_desc_tmp);	
					
				$function_id = $row[$j]['function_id'];
				$function_title = !empty($row[$j]['function_name']) ? addslashes(strip_tags(trim($row[$j]['function_name']))) : '';
				$function_desc = !empty($function_desc_tmp) ? addslashes(strip_tags(trim($function_desc_tmp))) : '';
				
				$this->_addFunction($module_id, $function_id, $function_title, $function_desc);
			}

			$block_desc_tmp = str_replace("\n", '', $row[$j]['block_desc']);
			$block_desc_tmp = str_replace("\r", '', $block_desc_tmp);
			
			$block_id = $row[$j]['block_id'];
			$block_title = !empty($row[$j]['block_title']) ? addslashes(strip_tags(trim($row[$j]['block_title']))) : '';
			$block_desc = !empty($block_desc_tmp) ? ' (' . addslashes(strip_tags(trim($block_desc_tmp))) . ')' : '';
			
			$this->_addBlock($module_id, $function_id, $block_id, $block_title, $block_desc);
		}
	}

	function _addBlock($module_id = '', $function_id = '', $block_id = '', $block_title = '', $block_desc = '')
	{
		$this->functionBlocks[$module_id][$function_id] = $this->functionBlocks[$module_id][$function_id] . (!empty($this->functionBlocks[$module_id][$function_id]) ? ',' : '') . '"' . $block_title . $block_desc . '","' . $block_id . '"';
	}

	function _addFunction($module_id = '', $function_id = '', $function_title = '', $function_desc = '')
	{
		$this->moduleFunctions[$module_id] = $this->moduleFunctions[$module_id] . (!empty($this->moduleFunctions[$module_id]) ? ',' : '') . '"' . $function_title . '","' . $function_id . '"';
	}
	
	function _addModule($module_id = '', $module_title = '', $module_desc = '')
	{
		$this->modules[$module_id] = $module_title;
	}	
		
	function _generate_tpl($block_id)
	{
		global $template, $blockcptemplate, $lang, $phpEx, $mx_request_vars, $mx_root_path, $userdata, $portalpage, $dynamic_block_id;
		
		$module_select_list = '';
		$function_list = '';
		$block_list = '';
		$default_list = '';

		$this->module_default_id = $mx_request_vars->request('module_id', MX_TYPE_INT, '');
		$this->function_default_id = $mx_request_vars->request('function_id', MX_TYPE_INT, '');
		$this->block_default_id = $mx_request_vars->request('block_id', MX_TYPE_INT, $block_id);
					
		if (!empty($this->block_default_id) && (empty($this->module_default_id) || empty($this->function_default_id)))
		{
			$this->_get_default_data($this->block_default_id);
		}
		
		foreach($this->modules as $key => $value)
		{
			$selected = ( $key == $this->module_default_id ) ? ' selected="selected"' : '';
			$module_select_list .= '<option value="' . $key . '"' . $selected . '>' . $value . "</option>\n";			
		}
		
		foreach($this->moduleFunctions as $module_id => $functions)
		{
			$function_list .= 'makeModule.forValue("'.$module_id.'").addOptionsTextValue('.$functions.')'.";\n";
		}			
			
		foreach($this->functionBlocks as $module_id => $functions)
		{
			foreach($functions as $function_id => $blocks)
			{
				$block_list .= 'makeModule.forValue("'.$module_id.'").forValue("'.$function_id. '").addOptionsTextValue('.$blocks.')'.";\n";
			}
		}
				
		$default_list = 'makeModule.forField("module_id").setValues("'.$this->module_default_id.'")'.";\n";
		$default_list .= 'makeModule.forField("function_id").setValues("'.$this->function_default_id.'")'.";\n";
		$default_list .= 'makeModule.forField("block_id").setValues("'.$this->block_default_id.'")'.";\n";

		//
		// Hidden fields
		//
		$s_hidden_dyn_fields = 	'<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />
								<input type="hidden" name="dynamic_block" value="' . $dynamic_block_id . '" />
								<input type="hidden" name="portalpage" value="' . $portalpage . '" />';
			
		$tpl = array(
			'S_HIDDEN_DYN_FILEDS' => $s_hidden_dyn_fields,
			'MX_DYN_PATH' => $mx_root_path,
			'L_MODULE' => $lang['Module'],
			'L_FUNCTION' => $lang['Function'],
			'L_BLOCK' => $lang['Block'],
			
			'S_UPDATE' => $lang['Update'],
			'S_RESET' => $lang['Reset'],
		
			'DYNAMIC_MODULE_SELECT' => $module_select_list,
			'DYNAMIC_FUNCTION_SETUP' => $function_list,
			'DYNAMIC_BLOCK_SETUP' => $block_list,
			'DYNAMIC_DEFAULT_SETUP' => $default_list,
		);
		
		if (is_object($blockcptemplate))
		{
			$blockcptemplate->assign_vars($tpl);
		}
		else 
		{
			$template->assign_vars($tpl);
		}
					
	}
	
	function _get_default_data($block_id)
	{
		global $db;
		// Generate dynamic block select
		$sql = "SELECT fnc.function_id, mdl.module_id
			FROM " . BLOCK_TABLE . " blk,
				" . FUNCTION_TABLE . " fnc,
				" . MODULE_TABLE . " mdl
			WHERE blk.function_id = fnc.function_id
				AND mdl.module_id = fnc.module_id
				AND blk.block_id = '".$block_id."' 
			ORDER BY mdl.module_name ASC, fnc.function_name ASC";
		
		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't get default module/function id", '', __LINE__, __FILE__, $sql);
		}
		
		if( $total_blocks = $db->sql_numrows($result) )
		{
			$row = $db->sql_fetchrow($result);
		}

		$this->module_default_id = $row['module_id'];
		$this->function_default_id = $row['function_id'];
	}
			
	// ------------------------------
	// Public Methods
	//
	//	
	function generate($block_id = '')
	{
		$this->_get_data();
		$this->_generate_tpl($block_id);
	}
}

/**#@+
 * Class mx_request_vars specific definitions
 *
 * Following flags are options for the $type parameter in method _read()
 *
 */
define('MX_TYPE_ANY'		, 0);		// Retrieve the get/post var as-is (only stripslashes() will be applied).
define('MX_TYPE_INT'		, 1);		// Be sure we get a request var of type INT.
define('MX_TYPE_FLOAT'		, 2);		// Be sure we get a request var of type FLOAT.
define('MX_TYPE_NO_HTML'	, 4);		// Be sure we get a request var of type STRING (htmlspecialchars).
define('MX_TYPE_NO_TAGS'	, 8);		// Be sure we get a request var of type STRING (strip_tags + htmlspecialchars).
define('MX_TYPE_NO_STRIP'	, 16);		// By default strings are slash stripped, this flag avoids this.
define('MX_TYPE_SQL_QUOTED'	, 32);		// Be sure we get a request var of type STRING, safe for SQL statements (single quotes escaped)
define('MX_TYPE_POST_VARS'	, 64);		// Read a POST variable.
define('MX_TYPE_GET_VARS'	, 128);		// Read a GET variable.
define('MX_NOT_EMPTY'		, true);	//
/**#@-*/

/**
 * Class: mx_request_vars.
 *
 * This is the CORE request vars object. Encapsulate several functions related to GET/POST variables.
 * More than one flag can specified by OR'ing the $type argument. Examples:
 * - For instance, we could use ( MX_TYPE_POST_VARS | MX_TYPE_GET_VARS ), see method request().
 * - or we could use ( MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED ).
 * - However, MX_TYPE_NO_HTML and MX_TYPE_NO_TAGS can't be specified at a time (defaults to MX_TYPE_NO_TAGS which is more restritive).
 * - Also, MX_TYPE_INT and MX_TYPE_FLOAT ignore flags MX_TYPE_NO_*
 * Usage examples:
 * - $mode = $mx_request_vars->post('mode', MX_TYPE_NO_TAGS, '');
 * - $page_id = $mx_request_vars->get('page', MX_TYPE_INT, 1);
 * This class IS instatiated in common.php ;-)
 *
 * @access public
 * @author Markus
 * @package Core
 */
class mx_request_vars
{
	//
	// Implementation Conventions:
	// Properties and methods prefixed with underscore are intented to be private. ;-)
	//

	// ------------------------------
	// Properties
	//

	// ------------------------------
	// Constructor
	//

	// ------------------------------
	// Private Methods
	//

	/**
	 * Function: _read().
	 *
	 * Get the value of the specified request var (post or get) and force the result to be
	 * of specified type. It might also transform the result (stripslashes, htmlspecialchars) for security
	 * purposes. It all depends on the $type argument.
	 * If the specified request var does not exist, then the default ($dflt) value is returned.
	 * Note the $type argument behaves as a bit array where more than one option can be specified by OR'ing
	 * the passed argument. This is tipical practice in languages like C, but it can also be done with PHP.
	 *
	 * @access private
	 * @param unknown_type $var
	 * @param unknown_type $type
	 * @param unknown_type $dflt
	 * @return unknown
	 */
	public function _read($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
	{
		if( ($type & (MX_TYPE_POST_VARS|MX_TYPE_GET_VARS)) == 0 )
		{
			$type |= (MX_TYPE_POST_VARS|MX_TYPE_GET_VARS);
		}

		if( ($type & MX_TYPE_POST_VARS) && isset($_POST[$var]) ||
			($type & MX_TYPE_GET_VARS)  && isset($_GET[$var]) )
		{
			$val = ( ($type & MX_TYPE_POST_VARS) && isset($_POST[$var]) ? $_POST[$var] : $_GET[$var] );
			if( !($type & MX_TYPE_NO_STRIP) )
			{
				if( is_array($val) )
				{
					foreach( $val as $k => $v )
					{
						$val[$k] = trim(stripslashes($v));
					}
				}
				else
				{
					$val = trim(stripslashes($val));
				}
			}
		}
		else
		{
			$val = $dflt;
		}

		if( $type & MX_TYPE_INT )		// integer
		{
			return $not_null && empty($val) ? $dflt : intval($val);
		}

		if( $type & MX_TYPE_FLOAT )		// float
		{
			return $not_null && empty($val) ? $dflt : floatval($val);
		}

		if( $type & MX_TYPE_NO_TAGS )	// ie username
		{
			if( is_array($val) )
			{
				foreach( $val as $k => $v )
				{
					$val[$k] = htmlspecialchars(strip_tags(ltrim(rtrim($v, " \t\n\r\0\x0B\\"))));
				}
			}
			else
			{
				$val = htmlspecialchars(strip_tags(ltrim(rtrim($val, " \t\n\r\0\x0B\\"))));
			}
		}
		elseif( $type & MX_TYPE_NO_HTML )	// no slashes nor html
		{
			if( is_array($val) )
			{
				foreach( $val as $k => $v )
				{
					$val[$k] = htmlspecialchars(ltrim(rtrim($v, " \t\n\r\0\x0B\\")));
				}
			}
			else
			{
				$val = htmlspecialchars(ltrim(rtrim($val, " \t\n\r\0\x0B\\")));
			}
		}

		if( $type & MX_TYPE_SQL_QUOTED )
		{
			if( is_array($val) )
			{
				foreach( $val as $k => $v )
				{
					$val[$k] = str_replace(($type & MX_TYPE_NO_STRIP ? "\'" : "'"), "''", $v);
				}
			}
			else
			{
				$val = str_replace(($type & MX_TYPE_NO_STRIP ? "\'" : "'"), "''", $val);
			}
		}

		return $not_null && empty($val) ? $dflt : $val;
	}

	// ------------------------------
	// Public Methods
	//

	/**
	 * Request POST variable.
	 *
	 * _read() wrappers to retrieve POST, GET or any REQUEST (both) variable.
	 *
	 * @access public
	 * @param string $var
	 * @param integer $type
	 * @param string $dflt
	 * @return string
	 */
	public function post($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
	{
		return $this->_read($var, ($type | MX_TYPE_POST_VARS), $dflt, $not_null);
	}

	/**
	 * Request GET variable.
	 *
	 * _read() wrappers to retrieve POST, GET or any REQUEST (both) variable.
	 *
	 * @access public
	 * @param string $var
	 * @param integer $type
	 * @param string $dflt
	 * @return string
	 */
	public function get($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
	{
		return $this->_read($var, ($type | MX_TYPE_GET_VARS), $dflt, $not_null);
	}

	/**
	 * Request GET or POST variable.
	 *
	 * _read() wrappers to retrieve POST, GET or any REQUEST (both) variable.
	 *
	 * @access public
	 * @param string $var
	 * @param integer $type
	 * @param string $dflt
	 * @return string
	 */
	public function request($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
	{
		return $this->_read($var, ($type | MX_TYPE_POST_VARS | MX_TYPE_GET_VARS), $dflt, $not_null);
	}

	/**
	 * Is POST var?
	 *
	 * Boolean method to check for existence of POST variable.
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	public function is_post($var)
	{
		// Note: _x and _y are used by (at least IE) to return the mouse position at onclick of INPUT TYPE="img" elements.
		return (isset($_POST[$var]) || ( isset($_POST[$var.'_x']) && isset($_POST[$var.'_y']))) ? 1 : 0;
	}

	/**
	 * Is GET var?
	 *
	 * Boolean method to check for existence of GET variable.
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	public function is_get($var)
	{
		return isset($_GET[$var]) ? 1 : 0 ;
	}

	/**
	 * Is REQUEST (either GET or POST) var?
	 *
	 * Boolean method to check for existence of any REQUEST (both) variable.
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	public function is_request($var)
	{
		return ($this->is_get($var) || $this->is_post($var)) ? 1 : 0;
	}
	/**
	 * Is POST var empty?
	 *
	 * Boolean method to check if POST variable is empty
	 * as it might be set but still be empty.
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	public function is_empty_post($var)
	{
		return (empty($_POST[$var]) && ( empty($_POST[$var.'_x']) || empty($_POST[$var.'_y']))) ? 1 : 0 ;
	}
	/**
	 * Is GET var empty?
	 *
	 * Boolean method to check if GET variable is empty
	 * as it might be set but still be empty
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	public function is_empty_get($var)
	{
		return empty($_GET[$var]) ? 1 : 0 ;
	}

	/**
	 * Is REQUEST empty (GET and POST) var?
	 *
	 * Boolean method to check if REQUEST (both) variable is empty.
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	public function is_empty_request($var)
	{
		return ($this->is_empty_get($var) && $this->is_empty_post($var)) ? 1 : 0;
	}

}	// class mx_request_vars
?>