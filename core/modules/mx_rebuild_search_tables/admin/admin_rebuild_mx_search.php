<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal, phpMiX (c) 2004
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: admin_rebuild_mx_search.php,v 1.3 2010/10/16 04:07:57 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

$start_time = time ();
$time_limit = $HTTP_GET_VARS['time_limit'];

define ('IN_PORTAL', 1);

if(!empty ($setmodules))
{
	$filename = basename(__FILE__);
	$module['Rebuild Search']['Optimize mxBB tables'] = 'modules/mx_rebuild_search_tables/admin/' . $filename;
	return;
}

$no_page_header = true;
$module_root_path = '../';
$mx_root_path = '../../../';
require( $mx_root_path . 'extension.inc' );
require( $mx_root_path . 'admin/pagestart.' . $phpEx );
require ($phpbb_root_path . 'includes/functions_search.'.$phpEx);

// **********************************************************************
// Read language definition
// **********************************************************************
if ( file_exists( $module_root_path.'language/lang_' . $board_config['default_lang'] . '/lang_admin_rebuild_search.'.$phpEx ) )
{
	include ($module_root_path.'language/lang_' . $board_config['default_lang'] . '/lang_admin_rebuild_search.'.$phpEx);
}
else
{
	include ($module_root_path.'language/lang_english/lang_admin_rebuild_search.'.$phpEx);
} 

$page_title = $lang['Page_title'];

if (isset ($HTTP_GET_VARS['start'])) 
{
	function onTime () 
	{
		global $start_time, $time_limit;
		static $max_execution_time;
		
		$current_time = time ();
		
		if (empty ($max_execution_time)) {
			if (ini_get ('safe_mode') == false) {
				set_time_limit (0);
				
				$max_execution_time = $time_limit;
			} else {
				$max_execution_time = ini_get ('max_execution_time');
			}
		}
			
		return (($current_time - $start_time) < $max_execution_time) ? true : false;
	}
	
	$start = $HTTP_GET_VARS['start'];
	
	if ($start == 0) 
	{
		$sql = "DELETE FROM ". MX_SEARCH_TABLE;
		$result = $db->sql_query ($sql);
		
		$sql = "DELETE FROM ". MX_WORD_TABLE;
		$result = $db->sql_query ($sql);
		
		$sql = "DELETE FROM ". MX_MATCH_TABLE;
		$result = $db->sql_query ($sql);
		
		//
		// Now find all textblocks
		//
		$sql = "SELECT blk.block_id
			FROM  " . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,    
				" . BLOCK_TABLE . " blk,    
				" . PARAMETER_TABLE . " par    
			WHERE blk.block_id = sys.block_id
				AND sys.parameter_id = par.parameter_id
				AND ( par.parameter_type = 'phpBBTextBlock'
					OR par.parameter_type = 'CustomizedTextBlock'
					OR par.parameter_type = 'WysiwygTextBlock' )
				AND sys.sub_id = 0";

		/*
		$sql = "SELECT post_id FROM ". POSTS_TEXT_TABLE;
		*/
		
		if ( !$result = $db->sql_query ($sql) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not obtain block_ids', '', __LINE__, __FILE__, $sql );
		}
		
		$total_num_rows = $db->sql_numrows ($result);
		
	}
	
	$total_num_rows = (isset ($HTTP_GET_VARS['total_num_rows'])) ? $HTTP_GET_VARS['total_num_rows'] : $total_num_rows;
		
	//
	// Now find all textblocks
	//	
	$sql = "SELECT blk.block_id, blk.block_title, sys.parameter_value
		FROM  " . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,    
			" . BLOCK_TABLE . " blk,    
			" . PARAMETER_TABLE . " par    
		WHERE blk.block_id = sys.block_id
			AND sys.parameter_id = par.parameter_id
			AND ( par.parameter_type = 'phpBBTextBlock'
				OR par.parameter_type = 'CustomizedTextBlock'
				OR par.parameter_type = 'WysiwygTextBlock' )
			AND sys.sub_id = 0
		LIMIT ".$start.", ". $HTTP_GET_VARS['post_limit'];
			
	/*
	$sql = "SELECT post_id, post_subject, post_text FROM ". POSTS_TEXT_TABLE ." LIMIT $start, ". $HTTP_GET_VARS['post_limit'];
	*/

	if ( !$result = $db->sql_query ($sql) )
	{
		mx_message_die( GENERAL_ERROR, 'Could not obtain block_ids data', '', __LINE__, __FILE__, $sql );
	}	
	
	$num_rows = 0;
	
	while (($row = $db->sql_fetchrow ($result)) ) 
	{
		//add_search_words('single', $row['post_id'], stripslashes($row['post_text']), stripslashes($row['post_subject']));
		mx_add_search_words('single', $row['block_id'], stripslashes($row['parameter_value']), stripslashes($row['block_title']));
		$num_rows++;
	}

	$template->set_filenames(array(
		"body" => "admin/admin_message_body.tpl")
	);
		
	if (($start + $num_rows) != $total_num_rows) 
	{
		$form_action = mx_append_sid ("admin_rebuild_mx_search.$phpEx?start=". ($start + $num_rows) ."&total_num_rows=$total_num_rows&post_limit=". $HTTP_GET_VARS['post_limit'] ."&time_limit=$time_limit&refresh_rate=". $HTTP_GET_VARS['refresh_rate']);
		$next = $lang['Next'];
		$template->assign_vars(array(
			"META" => '<meta http-equiv="refresh" content="'. $HTTP_GET_VARS['refresh_rate'] .';url='. $form_action .'">')
		);
	} 
	else 
	{
		$next = $lang['Finished'];
		$form_action = mx_append_sid ("admin_rebuild_mx_search.$phpEx");
	}
	
	include( $mx_root_path . 'admin/page_header_admin.' . $phpEx );
	
	$template->assign_vars (array (
		'PERCENT' => round ((($start + $num_rows) / $total_num_rows) * 100),
		'L_NEXT' => $next,
		'START' => $start + $num_rows,
		'TOTAL_NUM_ROWS' => $total_num_rows,
		'S_REBUILD_SEARCH_ACTION' => $form_action)
	);
	
	$template->set_filenames (array (
	    "body" => "admin/rebuild_search_progress.tpl")
	);
} 
else 
{
	include( $mx_root_path . 'admin/page_header_admin.' . $phpEx );
	
	$template->assign_vars (array (
		'L_REBUILD_SEARCH' => $lang['Rebuild_mx_search'],
		'L_REBUILD_SEARCH_DESC' => $lang['Rebuild_mx_search_desc'],
		'L_POST_LIMIT' => $lang['Post_limit'],
		'L_TIME_LIMIT' => $lang['Time_limit'],
		'L_REFRESH_RATE' => $lang['Refresh_rate'],
		'SESSION_ID' => $userdata['session_id'],
		
		'S_REBUILD_SEARCH_ACTION' => mx_append_sid ("admin_rebuild_mx_search.$phpEx"))
	);
		
	$template->set_filenames (array (
	    "body" => "admin/rebuild_search.tpl")
	);
}

$template->pparse ('body');

//
// Page Footer
//
include( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );

?>