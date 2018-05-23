<?php
/**
*
* @package Functions
* @version $Id: mx_functions.php,v 1.2 2009/01/24 16:47:51 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/**
 * Return data from table.
 *
 * This function returns data from table, where field value matches id (and field2 value matches id2).
 *
 * @access public
 * @param string $table target
 * @param string $idfield  field
 * @param string $id needle
 * @param string $idfield2 additional field (optional)
 * @param string $id2 needle
 * @return array results
 */
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
	$db->sql_freeresult($result);
	return $return;
}

/**
 * Return number of results, if exists.
 *
 * This function returns the number of results, where field value matches id.
 *
 * @access public
 * @param string $table target
 * @param string $idfield field
 * @param string $id needle
 * @return array array('number', num_of_results)
 */
function mx_get_exists($table, $idfield = '', $id = 0)
{
	global $db;

	$sql = "SELECT COUNT(*) AS total FROM $table WHERE $idfield = '$id'";
	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get block/Column information", '', __LINE__, __FILE__, $sql);
	}
	$count = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	$count = $count['total'];
	return array('number' => $count);
}

/**
 * Get html select list - from array().
 *
 * This function generates and returns a html select list (name = $nameselect).
 *
 * @access public
 * @param string $name_select select name
 * @param array $row source data
 * @param string $id needle
 * @param boolean $full_list expanded or dropdown list
 * @return unknown
 */
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

	unset($row);
	return $column_list;
}

/**
 * Get html select list - from db query.
 *
 * This function generates and returns a html select list (name = $nameselect) with option labels $namefield,
 * with data from $table, (where $idfield2 matches $id2).
 * Use $select=true to select where $idfield value matches $id.
 * <code>
 * 	<select name=$nameselect>
 * 		// $idfield = $id
 * 		<option value=$idfield selected="selected">$namefield</option>
 * 		// $idfield != $id
 * 		<option value=$idfield >$namefield</option>
 * 		<option value=$idfield >$namefield</option>
 * 		<option value=$idfield >$namefield</option>
 * 	</select>
 * </code>
 *
 * @access public
 * @param string $name_select select name
 * @param string $table target
 * @param string $idfield field
 * @param string $namefield option labels
 * @param string $id needle
 * @param boolean $select select idfiled = id
 * @param string $idfield2 field
 * @param string $id2 needle
 * @return string (html)
 */
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

	unset($row);
	$db->sql_freeresult($result);

	return $column_list;
}

/**
 * Get html mutiple select list - from db query.
 *
 * This function generates and returns a html multiple select list (name = $nameselect) with option labels $namefield ($namefield2),
 * with data from $table. Use $select=true to select where $idfield value matches list($id).
 * <code>
 * 	<select name=$nameselect multiple="multiple">
 * 		// $idfield in list($id)
 * 		<option value=$idfield selected="selected">$namefield ($namefield2)</option>
 * 		// $idfield in list($id)
 * 		<option value=$idfield selected="selected">$namefield ($namefield2)</option>
 * 		// $idfield not in list($id)
 * 		<option value=$idfield >$namefield ($namefield2) ($namefield2)</option>
 * 		<option value=$idfield >$namefield ($namefield2) ($namefield2)</option>
 * 	</select>
 * </code>
 *
 * @access public
 * @param string $name_select select name
 * @param string $table target
 * @param string $idfield field
 * @param string $namefield option labels
 * @param array $id_list needle array
 * @param boolean $select select select idfiled = list(id)
 * @param string $namefield2 option labels desc
 * @return string (html)
 */
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

	unset($row);
	$db->sql_freeresult($result);
	return $column_list;
}

/**
 * Get html select list - from db query - with formatted output.
 *
 * This function generates and returns a html select list (name = $nameselect). Supported $type options are:
 * - page_list
 * - function_list
 * - block_list
 * - dyn_block_list
 * Or the function generates a block_list for given $function_file.
 *
 * @access public
 * @param string $type list types
 * @param string $id needle
 * @param string $name_select select name
 * @param string $function_file get block_list for $function_file
 * @param boolean $multiple_select
 * @param string $function_file2 get block_list also for $function_file2
 * @return string (html)
 */
function get_list_formatted($type, $id, $name_select = '', $function_file = '', $multiple_select = false, $function_file2 = '')
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

		$function_file_filter_temp = ( !empty($function_file2) ? " OR fnc.function_file = '$function_file2'" : '' );
		$function_file_filter = ( !empty($function_file) ? " AND ( fnc.function_file = '$function_file' ".$function_file_filter_temp.")" : '' );

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
	else
	{
		$multiple_select_option = '';
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
		$k = ($j < 1) ? 0 : $j - 1;
		if( $row[$j]['module_name'] != $row[$k]['module_name'] )
		{
			$column_list .= '<option value="">' . 'Module: ' . $row[$j]['module_name'] . '----------' . "</option>\n";
		}

		if( $type == 'block_list' )
		{
			if( $row[$j]['function_name'] != $row[$k]['function_name'] )
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

	unset($row);
	$db->sql_freeresult($result);
	return $column_list;
}

/**
 * Get simple html select list - from db query.
 *
 * This function generates and returns a html select list (name = $nameselect) with option labels $namefield,
 * with data from $table. Use $select=true to select where $idfield value matches $id.
 * <code>
 * 	<select name=$nameselect>
 * 		// $idfield = $id
 * 		<option value=$idfield selected="selected">$namefield</option>
 * 		// $idfield != $id
 * 		<option value=$idfield >$namefield</option>
 * 		<option value=$idfield >$namefield</option>
 * 		<option value=$idfield >$namefield</option>
 * 	</select>
 * </code>
 * Note: This function auto inserts a top option 'not selected'.
 *
 * @access public
 * @param string $name_select select name
 * @param string $table target
 * @param string $idfield field
 * @param string $namefield option labels
 * @param string $id needle
 * @param boolean $select select idfield = id
 * @return string (html)
 */
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
		$column_list .= "<option value=\"$row[$idfield]\"$selected>" . $row[$namefield] . "</option>\n";
	}
	$column_list .= '</select>';

	unset($row);
	$db->sql_freeresult($result);
	return $column_list;
}

/**
 * Jump menu function.
 *
 * @access public
 * @param unknown_type $page_id to handle parent page_id
 * @param unknown_type $depth related to function to generate tree
 * @param unknown_type $default the page you wanted to be selected
 * @return unknown
 */
function generate_page_jumpbox( $name_select, $page_id = 0, $depth = 0, $default = '' )
{
	global $db, $userdata, $portal_config, $lang;

	$sql = 'SELECT *
		FROM ' . PAGE_TABLE . '
		ORDER BY page_parent, page_order ASC';

	if ( !( $result = $db->sql_query( $sql ) ) )
	{
		mx_message_die( GENERAL_ERROR, 'Couldnt Query pages info', '', __LINE__, __FILE__, $sql );
	}

	$page_rowset = $db->sql_fetchrowset( $result );
	$db->sql_freeresult( $result );

	$pagesArray = array();
	for( $i = 0; $i < count( $page_rowset ); $i++ )
	{
		$pagesArray[$page_rowset[$i]['page_id']] = $page_rowset[$i];
	}

	$page_list .= '';
	$pre = str_repeat( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $depth );

	if ( !empty( $pagesArray ) )
	{
		foreach ( $pagesArray as $temp_page_id => $page )
		{
			if ( $page['page_parent'] == $page_id )
			{
					if ( $default == $page['page_id'] )
					{
						$sel = ' selected="selected"';
					}
					else
					{
						$sel = '';
					}

				$page_pre = '+ ';
				$sub_page_id = $page['page_id'];
				$page_class = '';
				$page_list .= '<option value="' . $sub_page_id . '"' . $sel . ' ' . $page_class . ' />' . $pre . $page_pre . $page['page_name'] . (!empty($page['page_desc']) ? ' (' .  $page['page_desc'] . ')'  : '') . '</option>';
				$page_list .= generate_page_jumpbox( $name_select, $page['page_id'], $depth + 1, $default );
			}
		}

		if ($page_id == 0)
		{
			// Format Select
			$pageList = '<select name="'. $name_select . '">';
			if ( !$pagesArray[$default]['page_parent'] )
			{
				$pageList .= '<option value="0" selected>' . $lang['None'] . '</option>\n';
			}
			else
			{
				$pageList .= '<option value="0">' . $lang['None'] . '</option>\n';
			}
			$pageList .= $page_list;
			$pageList .= '</select>';

			return $pageList;
		}
		else
		{
			return $page_list;
		}
	}
	else
	{
		return;
	}
}

/**
 * Generate mxBB URL, with arguments.
 *
 * This function returns a mxBB URL with GET vars, and accepts any number of parwise arguments.
 *
 * @access public
 * @return string (url)
 */
function mx_url()
{
	global $SID, $_SERVER;

	$numargs = func_num_args();
	//$url = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
	$url = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'];
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
	/*
	for ($j = 0; $j < count($url_array); $j++)
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

/**
 * Generate mxBB URL, with arguments.
 *
 * This function returns a mxBB URL with GET vars, and accepts arguments in the $args array().
 *
 * @access public
 * @param array $args source arguments
 * @param boolean $force_standalone_mode nonstandard file
 * @param string $file optional nonstandard file
 * @return string (url)
 */
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

/**
 * PHP Sessions Management.
 *
 * If necessary, GZIP initialization should be done before session_start().
 *
 * @access public
 */
function mx_session_start()
{
	global $board_config, $_SERVER, $do_gzip_compress;

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

		$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

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
			if ( strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') )
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
	@session_start();
}

/**
 * Get page_id for block or function.
 *
 * This function returns the page_id for the page on which a block (or a function block) is located.
 * First instance found is returned. Results are cached for later reuse. Examples:
 * - get_page_id('dload.php', true) - to find a pafileDB block
 * - get_page_id($block_id)
 *
 * @access public
 * @param string $search_item block_id (or function_file)
 * @param boolean $use_function_file $search_item is a function_file
 * @param boolean $get_page_data_array return page data results (not only id)
 * @return integer (array)
 */
function get_page_id($search_item, $use_function_file = false, $get_page_data_array = false)
{
	global $db, $mx_user, $mx_cache;

	//
	// Try to reuse results.
	//
	$cache_key = '_pagemap_block' . $search_item;

	$page_id_array = array();
	if ($mx_cache->_exists($cache_key))
	{
		$page_id_array = unserialize($mx_cache->get($cache_key));
	}
	else
	{
		if($use_function_file !== false)
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
			$db->sql_freeresult($result);
			$search_item = isset($row['block_id']) ? intval($row['block_id']) : 0;
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
		$db->sql_freeresult($result);

		if( empty($p_row['page_id']) || (($use_function_file !== false) && ($search_item > 0)) )
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
			$db->sql_freeresult($result);
			$p_row = $db->sql_fetchrow($p_result);
		}
		
		if( empty($p_row['page_id'])  || (($use_function_file !== false) && ($search_item > 0)) )
		{
			// Find all subblock page_ids
			$sql = "SELECT pag.page_id, pag.page_name, pag.page_desc, sys.parameter_value
				FROM " . COLUMN_BLOCK_TABLE . " bct,
					" . PAGE_TABLE . " pag,
					" . COLUMN_TABLE . " col,
					" . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
					" . PARAMETER_TABLE . " par,
					" . FUNCTION_TABLE . " fcn
				WHERE pag.page_id = col.page_id
					AND bct.column_id = col.column_id
					AND bct.block_id = sys.block_id
					AND sys.parameter_id = par.parameter_id
					AND par.parameter_name = 'block_ids'
					AND par.function_id = fcn.function_id
					AND fcn.function_file = 'mx_multiple_blocks.php'
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
					if ($block_id == $search_item)
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
			$db->sql_freeresult($result);
		}

		if( empty($p_row['page_id'])  || (($use_function_file !== false) && ($search_item > 0)) )
		{
			// Find if block is a default dynamic block (desperate try)
			$sql = "SELECT pag.page_id, pag.page_name, pag.page_desc, sys.parameter_value
				FROM " . COLUMN_BLOCK_TABLE . " bct,
			       	" . PAGE_TABLE . " pag,
					" . COLUMN_TABLE . " col,
					" . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
					" . PARAMETER_TABLE . " par,
					" . FUNCTION_TABLE . " fcn
				WHERE pag.page_id = col.page_id
					AND bct.column_id = col.column_id
					AND bct.block_id = sys.block_id
					AND sys.parameter_id = par.parameter_id
					AND par.parameter_name = 'default_block_id'
					AND par.function_id = fcn.function_id
					AND fcn.function_file = 'mx_dynamic.php'
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
					if ($block_id == $search_item)
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
			$db->sql_freeresult($result);
		}
		
		$page_id_array = array();
		if (!empty($p_row['page_id']))
		{		
			if(isset($p_row['page_id']))
			{
				$page_id_array['page_id'] = isset($p_row['page_id']) ? $p_row['page_id'] : $page_id;
			}	
			
			if(isset($p_row['page_name']))
			{
				$page_id_array['page_name'] = $p_row['page_name'];
			}			
			
			if(isset($p_row['page_desc']))
			{
				$page_id_array['page_desc'] = $p_row['page_desc'];
			}		
			
			if(isset($p_row['block_id']))
			{
				$page_id_array['block_id'] = isset($p_row['block_id']) ? $p_row['block_id'] : 0;
			}			
			
		}
		unset($p_row);
		$mx_cache->put($cache_key, serialize($page_id_array));
	}
	
	if ( $get_page_data_array && !empty($page_id_array['page_id']) )
	{
		return $page_id_array;
	}
	else if(isset($page_id_array['page_id']))
	{
		return $page_id_array['page_id'];
	}
	else if( (isset($page_id_array) && isset($search_item) && ($search_item > 0))  || (($use_function_file !== false) && ($search_item > 0)) )
	{
		global $mx_request_vars;
		
		//
		// Page selector
		//
		$page_id = $mx_request_vars->request('page', MX_TYPE_INT, 1);

		//
		// Find all dynamic block Page_ids, if not present as ordinary block
		//
		$sql = "SELECT pag.page_id, pag.page_name, pag.page_desc, nav.block_id
			FROM " . PAGE_TABLE . " pag,
				" . BLOCK_TABLE . " blk,
				" . MENU_NAV_TABLE . " nav,
				" . MENU_CAT_TABLE . " nac
			WHERE pag.page_id > 0
				AND nac.cat_id = nav.cat_id
				AND nav.block_id = blk.block_id
				AND nav.block_id = '" . $search_item . "'
			ORDER BY blk.block_id";
				
		if( !($p_result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Could not query column list", '', __LINE__, __FILE__, $sql);
		}		
		$p_row = $db->sql_fetchrow($p_result);		
		$db->sql_freeresult($p_result);
		
		if(isset($p_row['page_id']))
		{
			$page_id_array['page_id'] = isset($p_row['page_id']) ? $p_row['page_id'] : $page_id;
		}	
		
		if(isset($p_row['page_name']))
		{
			$page_id_array['page_name'] = $p_row['page_name'];
		}			
		
		if(isset($p_row['page_desc']))
		{
			$page_id_array['page_desc'] = $p_row['page_desc'];
		}		
		
		if(isset($p_row['block_id']))
		{
			$page_id_array['block_id'] = isset($p_row['block_id']) ? $p_row['block_id'] : $search_item;
		}		
					
		return $page_id_array;
	}	
	else
	{
		return '';
	}
}

/**
 * Generate icon select list.
 *
 * Handy function to generate icon select lists.
 *
 * @access public
 * @param string $icon_dir target
 * @param string $file_posticon selection
 * @param string $modules_path module path (optional)
 * @return string (html)
 */
function post_icons( $icon_dir = '', $file_posticon = '', $modules_path = '')
{
	global $lang, $phpbb_root_path, $module_root_path, $mx_root_path, $is_block, $phpEx;

	$curicons = 1;
	if ( $file_posticon == 'none' || $file_posticon == 'none.gif' or empty( $file_posticon ) )
	{
		$posticons .= '<input type="radio" name="menuicons" value="none" checked><a class="gensmall">' . $lang['None'] . '</a>&nbsp;';
	}
	else
	{
		$posticons .= '<input type="radio" name="menuicons" value="none"><a class="gensmall">' . $lang['None'] . '</a>&nbsp;';
	}
	if ( $file_posticon == 'icon_spacer' || $file_posticon == 'icon_spacer.gif' )
	{
		$posticons .= '<input type="radio" name="menuicons" value="icon_spacer" checked><a class="gensmall">' . $lang['mx_spacer'] . '</a>&nbsp;';
	}
	else
	{
		$posticons .= '<input type="radio" name="menuicons" value="icon_spacer"><a class="gensmall">' . $lang['mx_spacer'] . '</a>&nbsp;';
	}

	$current_template_path = file_exists($mx_root_path . $modules_path . TEMPLATE_ROOT_PATH . 'images/' . $icon_dir) ? TEMPLATE_ROOT_PATH : 'templates/subSilver/';
	$handle = @opendir( $mx_root_path . $modules_path . $current_template_path . 'images/' . $icon_dir );
	while ( $icon = @readdir( $handle ) )
	{
		if ( $icon !== '.' && $icon !== '..' && $icon !== 'CVS' && $icon !== 'index.htm' && !substr_count($icon, 'icon_bg') && !substr_count($icon, 'spacer') && !substr_count($icon, '_hot'))
		{
			if ( $file_posticon == $icon )
			{
				$posticons .= '<input type="radio" name="menuicons" value="' . $icon . '" checked><img src="' . PORTAL_URL . $modules_path . $current_template_path . 'images/' . $icon_dir . $icon . '">&nbsp;';
			}
			else
			{
				$posticons .= '<input type="radio" name="menuicons" value="' . $icon . '"><img src="' . PORTAL_URL . $modules_path . $current_template_path . 'images/' . $icon_dir . $icon . '">&nbsp;';
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

/**
 * Get block parent data.
 *
 * Provided block_id, the function returns the parent function_id and module_id. Else false.
 *
 * @access public
 * @param integer $block_id
 * @param string $key return keyd array
 * @return array
 */
function mx_parent_data($block_id, $key = '')
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
	$db->sql_freeresult($result);

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

/**
 * Compose mxBB copyrights and credits page.
 * @access public
 */
function compose_mx_copy()
{
	global $table_prefix, $mx_table_prefix, $userdata, $phpEx, $template, $lang, $theme, $db, $board_config, $HTTP_POST_VARS, $mx_page;

	$mx_page->page_title = $lang['mx_about_title'];

	$sql = "SELECT * FROM " . MODULE_TABLE . " ORDER BY module_name";
	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain modules from database", '', __LINE__, __FILE__, $sql);
	}
	$module = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$mx_module_copy = '<h1>' . $lang['mx_copy_title'] . '</h1><hr /><br />';
	$mx_module_copy .= '<br />' . '<span class="maintitle">' . $lang['mx_copy_modules_title'] . '</span>';

	for( $i = 0; $i < count($module); $i++ )
	{
		if( !empty($module[$i]['module_copy']) )
		{
			$mx_module_copy .= '<br />' . '<h3>' . $module[$i]['module_name'] . '</h3>' . $module[$i]['module_desc'] . (!empty($module[$i]['module_version']) ? ($module[$i]['module_version'] != 'mxBB Core Module' ? ' v. ' : ' - ' ) . $module[$i]['module_version'] : '') . '<br />' . $module[$i]['module_copy'];
		}
	}

	$translation_copy = (isset($lang['TRANSLATION_INFO'])) ? $lang['TRANSLATION_INFO'] : ((isset($lang['TRANSLATION'])) ? $lang['TRANSLATION'] : '');
	$translation_copy_mxbb = (isset($lang['TRANSLATION_INFO_MXBB'])) ? $lang['TRANSLATION_INFO_MXBB'] : ((isset($lang['TRANSLATION'])) ? $lang['TRANSLATION'] : '');

	$mx_module_copy .=  !empty($translation_copy) || !empty($translation_copy_mxbb) ? '<br /><br />' . '<span class="maintitle">' . $lang['mx_copy_translation_title'] . '</span><hr />' . (!empty($translation_copy) ? ('<br />phpBB: ' . $translation_copy) : '') . (!empty($translation_copy_mxbb) ? ('<br />mxBB: ' . $translation_copy_mxbb) : '') : '';

	$theme_copy = (isset($theme['template_copy'])) ? $theme['template_copy'] : '';
	$mx_module_copy .= '<br /><br />' . '<span class="maintitle">' . $lang['mx_copy_template_title'] . '</span><br />' . $theme_copy;

	$mx_module_copy = $mx_module_copy . '<br />';

	unset($module);
	mx_message_die(GENERAL_MESSAGE, $mx_module_copy, $lang['mx_about_title']);
}

/**
 * Read block data.
 *
 * For compatibility with old block calls.
 * NOTE: This usage is NOT preferred, and should only be used on rare occasions when the $mx_block object is unavailable.
 * This wrapper function calls the cache (if enabled) or db directly to get parameter data.
 *
 * @access public
 * @param integer $block_id target
 * @param boolean $force_query do not use cache
 * @return array block data
 */
function read_block_config( $block_id, $force_query = false )
{
	global $mx_cache, $mx_block;

	if ( empty( $mx_block->block_config[$block_id] ) )
	{
		$block_config_temp = $mx_cache->read( $block_id, MX_CACHE_BLOCK_TYPE, $force_query );
		$block_config_temp[$block_id] = array_merge($block_config_temp[$block_id]['block_info'], $block_config_temp[$block_id]['block_parameters']);
		return $block_config_temp;
	}
	$block_config_temp[$block_id] = array_merge($mx_block->block_info, $mx_block->block_parameters);
	return $block_config_temp;
}

/**
 * get_auth_blocks
 *
 * Temporary function for getting all block_ids vith auth_edit
 *
 * @access public
 * @return unknown
 */
function get_auth_blocks()
{
	global $userdata, $mx_root_path, $phpEx, $db;

	//
	// Try to reuse auth_view query result.
	//
	$userdata_key = 'mx_get_auth_block' . $userdata['user_id'];
	if( !empty($userdata[$userdata_key]) )
	{
		$auth_data_sql = $userdata[$userdata_key];
		return $auth_data_sql;
	}

	//
	// Get block data
	//

	// Generate dynamic block select
	$sql = "SELECT * FROM " . BLOCK_TABLE . " ORDER BY block_id";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get blocks", '', __LINE__, __FILE__, $sql);
	}

	//
	// Loop through the list of forums to retrieve the ids for
	// those with AUTH_VIEW allowed.
	//
	$auth_data_sql = '';
	while ( $row = $db->sql_fetchrow($result) )
	{
		$mx_block_temp = new mx_block();
		$mx_block_temp->init($row['block_id']);

		if( $mx_block_temp->auth_edit )
		{
			$auth_data_sql .= ( $auth_data_sql != '' ) ? ', ' . $row['block_id'] : $row['block_id'];
		}
	}

	$db->sql_freeresult($result);

	if( empty($auth_data_sql) )
	{
		$auth_data_sql = -1;
	}

	$userdata[$userdata_key] = $auth_data_sql;
	return $auth_data_sql;
}

if( !function_exists('memory_get_usage') )
{
	/**
	 * Get php memory usage, if function is not declared by php
	 *
	 * Tested on Win XP Pro SP2. Should work on Win 2003 Server too.
	 * Doesn't work for 2000. If you need it to work for 2000 look at http://us2.php.net/manual/en/function.memory-get-usage.php#54642
	 *
	 * If its Windows
	 *
	 * @return integer
	 */
   	function memory_get_usage()
   	{
       	if ( substr(PHP_OS,0,3) == 'WIN')
       	{
           	    $output = array();
           	    exec( 'tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output );

              	 return preg_replace( '/[\D]/', '', $output[5] ) * 1024;
       	}
       	else
       	{
           	//We now assume the OS is UNIX
           	//Tested on Mac OS X 10.4.6 and Linux Red Hat Enterprise 4
          	 //This should work on most UNIX systems
           	$pid = getmypid();
           	exec("ps -eo%mem,rss,pid | grep $pid", $output);
           	$output = explode("  ", $output[0]);
           	//rss is given in 1024 byte units
           	return $output[1] * 1024;
       }
   	}
}

if( !function_exists('get_backtrace') )
{
	/**
	 * Get backtrace.
	 *
	 * Return a nicely formatted backtrace (parts from the php manual by diz at ysagoon dot com)
	 *
	 * @return string (html)
	 */
	function get_backtrace()
	{
		global $mx_root_path;

		$output = '<div style="font-family: monospace;">';
		$backtrace = debug_backtrace();
		$path = realpath($mx_root_path);

		foreach ($backtrace as $number => $trace)
		{
			// We skip the first one, because it only shows this file/function
			if ($number == 0)
			{
				continue;
			}

			// Strip the current directory from path
			$trace['file'] = str_replace(array($path, '\\'), array('', '/'), $trace['file']);
			$trace['file'] = substr($trace['file'], 1);

			$args = array();
			foreach ($trace['args'] as $argument)
			{
				switch (gettype($argument))
				{
					case 'integer':
					case 'double':
						$args[] = $argument;
					break;

					case 'string':
						$argument = htmlspecialchars(substr($argument, 0, 64)) . ((strlen($argument) > 64) ? '...' : '');
						$args[] = "'{$argument}'";
					break;

					case 'array':
						$args[] = 'Array(' . sizeof($argument) . ')';
					break;

					case 'object':
						$args[] = 'Object(' . get_class($argument) . ')';
					break;

					case 'resource':
						$args[] = 'Resource(' . strstr($argument, '#') . ')';
					break;

					case 'boolean':
						$args[] = ($argument) ? 'true' : 'false';
					break;

					case 'NULL':
						$args[] = 'NULL';
					break;

					default:
						$args[] = 'Unknown';
				}
			}

			$trace['class'] = (!isset($trace['class'])) ? '' : $trace['class'];
			$trace['type'] = (!isset($trace['type'])) ? '' : $trace['type'];

			$output .= '<br />';
			$output .= '<b>FILE:</b> ' . htmlspecialchars($trace['file']) . '<br />';
			$output .= '<b>LINE:</b> ' . $trace['line'] . '<br />';
			$output .= '<b>CALL:</b> ' . htmlspecialchars($trace['class'] . $trace['type'] . $trace['function']) . '(' . ((sizeof($args)) ? implode(', ', $args) : '') . ')<br />';
		}
		$output .= '</div>';
		return $output;
	}

	/**
	 * Set config value.
	 *
	 * Creates missing config entry if needed.
	 *
	 * @param unknown_type $config_name
	 * @param unknown_type $config_value
	 * @param unknown_type $is_dynamic
	 */
	function mx_set_config($config_name, $config_value)
	{
		global $db, $mx_cache, $portal_config;

		$sql = 'UPDATE ' . PORTAL_TABLE . "
			SET config_value = '" . $db->sql_escape($config_value) . "'
			WHERE config_name = '" . $db->sql_escape($config_name) . "'";
		$db->sql_query($sql);

		if (!$db->sql_affectedrows() && !isset($config[$config_name]))
		{
			$sql = 'INSERT INTO ' . PORTAL_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				'config_name'	=> $config_name,
				'config_value'	=> $config_value));
			$db->sql_query($sql);
		}

		$portal_config[$config_name] = $config_value;
		$mx_cache->put( 'mxbb_config', $portal_config );
	}
}

/**
 * Get langcode.
 *
 * This function loops all meta langcodes, to convert internal mxBB lang to standard langcode
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
* Censoring
*/
function mx_censor_text($text)
{
	static $censors;
	global $mx_cache;

	if (!isset($censors) || !is_array($censors))
	{
		// obtain_word_list is taking care of the users censor option and the board-wide option
		$censors = $mx_cache->obtain_word_list();
	}

	if (sizeof($censors))
	{
		return preg_replace($censors['match'], $censors['replace'], $text);
	}

	return $text;
}
/**
 * update config.php values.
 *
 */
function update_portal_backend($new_backend = PORTAL_BACKEND)
{
	global $mx_backend, $mx_root_path, $lang, $phpEx, $portal_config;

	//
	// Load phpbb config.php (to get table prefix)
	// If this fails MXP2 will not work
	//		
	if ((file_exists($mx_root_path . "config.$phpEx") === true))
	{					
		$backend_info = $mx_backend->get_mxp_info($mx_root_path . "config.$phpEx");			
			
		// phpBB 2.x auto-generated config file
		// Do not change anything in this file!

		$dbms = $backend_info['dbms'];

		$dbhost = $backend_info['dbhost'];
		$dbname = $backend_info['dbname'];
		$dbuser = $backend_info['dbuser'];
		$dbpasswd = $backend_info['dbpasswd'];
		$phpbb_root_path = $backend_info['phpbb_root_path'];
		$mx_table_prefix = $backend_info['mx_table_prefix'];
		$table_prefix = $backend_info['table_prefix'];
		$mx_acm_type = $backend_info['acm_type'];
		$status = $backend_info['status'];					
		
		if( !isset($backend_info['dbms']) || $backend_info['dbms'] != $dbms || $backend_info['dbhost'] != $dbhost || $backend_info['dbname'] != $dbname || $backend_info['dbuser'] != $dbuser || $backend_info['dbpasswd'] != $dbpasswd || $backend_info['table_prefix'] != $table_prefix )
		{				
			if ((include $phpbb_root_path . "config.$phpEx") === false)
			{
				print('Configuration file (config) ' . $phpbb_root_path . "/config.$phpEx" . ' couldn\'t be opened.');
			}
		}		
	}

	$mx_portal_name = 'MX-Publisher Modular System';

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
		case 'phpbb2':

			$utf_status = defined('UTF_STATUS') ? UTF_STATUS : $new_backend;
		break;

		case 'phpbb3':

			$utf_status = $new_backend;
		break;
	}
	
	if ( !defined('IN_ADMIN') )
	{
		$phpbb_path = str_replace('./../', '', $phpbb_root_path);
	}
	else	
	{
		$phpbb_path = str_replace($mx_root_path, '', $phpbb_root_path);
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
	$config_data .= '$'."table_prefix = '$table_prefix';\n\n";
	$config_data .= '$'."acm_type = '$mx_acm_type';\n\n";
	$config_data .= '$phpbb_root_path = $mx_root_path . ' . "'$phpbb_path';\n\n";
	//$config_data .= "define('UTF_STATUS', '$portal_backend');\n\n";					
	$config_data .= "define('MX_INSTALLED', true);\n\n";
	$config_data .= "define('PHPBB_INSTALLED', true);\n\n";
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
?>