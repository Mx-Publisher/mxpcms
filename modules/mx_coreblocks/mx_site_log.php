<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_site_log.php,v 1.23 2014/05/18 06:24:56 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Block Info
//
// This block does 3 db queries to find latest standard, dynamic and sub block. Then it sorts the result arrays and display by offset.
// - not very efficient atm
// - to be optimized

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$message = $mx_block->get_parameters( 'Text' );

$block_size = ( !empty( $block_size ) ? $block_size : '100%' );

$template->set_filenames( array( "sitelog" => "mx_site_log.tpl" ) );

//
// Read block Configuration
//
$log_numberOfEvents = $mx_block->get_parameters( 'numOfEvents' ) > 0 ? intval( $mx_block->get_parameters( 'numOfEvents' ) ) : '5';
$log_filter_time = $mx_block->get_parameters( 'log_filter_date' ); // no limit, last day, 2 days, 3 days, week, 2 weeks, 3 weeks, month, 2 months, 3 months, 6 months, i year,

$log_start = $mx_request_vars->get('log_start', MX_TYPE_INT, 0);

$start_prev = ( $log_start == 0 ) ? 0 : $log_start - $log_numberOfEvents;
$start_next = $log_start + $log_numberOfEvents;

$url_next = mx_append_sid( mx_this_url( 'log_start=' . $start_next ) );
$url_prev = mx_append_sid( mx_this_url( 'log_start=' . $start_prev ) );

$log_today = date('mdY');

switch ( $log_filter_time )
{
	case 'no limit':
		$log_time_filter_lo = "no";
		break;
	case '1 day':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2)), intval(substr($log_today, 2, 2) - 1), intval(substr($log_today, 4, 4)) );
		break;
	case '2 days':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2)), intval(substr($log_today, 2, 2) - 1), intval(substr($log_today, 4, 4)) );
		break;
	case '3 days':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2)), intval(substr($log_today, 2, 2) - 1), intval(substr($log_today, 4, 4)) );
		break;
	case '1 week':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2)), intval(substr($log_today, 2, 2) - 7), intval(substr($log_today, 4, 4)) );
		break;
	case '2 weeks':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2)), intval(substr($log_today, 2, 2) - 14), intval(substr($log_today, 4, 4)) );
		break;
	case '3 weeks':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2)), intval(substr($log_today, 2, 2) - 21), intval(substr($log_today, 4, 4)) );
		break;
	case '1 month':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2) - 1), intval(substr($log_today, 2, 2)), intval(substr($log_today, 4, 4)) );
		break;
	case '2 months':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2) - 2), intval(substr($log_today, 2, 2)), intval(substr($log_today, 4, 4)) );
		break;
	case '3 months':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2) - 3), intval(substr($log_today, 2, 2)), intval(substr($log_today, 4, 4)) );
		break;
	case '6 months':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2) - 6), intval(substr($log_today, 2, 2)), intval(substr($log_today, 4, 4)) );
		break;
	case '1 year':
		$log_time_filter_lo = mktime ( 0, 0, 0 , intval(substr($log_today, 0, 2)), intval(substr($log_today, 2, 2)), intval(substr($log_today, 4, 4) - 1) );
		break;
	default:
		$log_time_filter_lo = "no";
		break;
}

//
// Generate page_blocks data
// Find all blocks, sorted by edited_time
//
/*
$sql = "SELECT blk.block_id
   		FROM " . BLOCK_TABLE . " blk
		WHERE blk.show_stats = '1'
			AND blk.block_time <> ''
			AND blk.block_editor_id > 0";
*/

$sql = "SELECT blk.block_id
   		FROM " . BLOCK_TABLE . " blk
		WHERE blk.block_time <> ''
			AND blk.block_editor_id > 0";

if ( $log_time_filter_lo != 'no' && !empty($log_time_filter_lo) )
{
	$sql .= " AND blk.block_time > " . $log_time_filter_lo ;
}

$sql .= " ORDER BY block_time";

if ( !$result = $db->sql_query( $sql ) )
{
	mx_message_die( GENERAL_ERROR, 'Could not obtain block results', '', __LINE__, __FILE__, $sql );
}

$block_rowset = $db->sql_fetchrowset( $result );
$db->sql_freeresult($result);

//
// Get all pages with view access
//
/*
$sql = "SELECT * FROM " . PAGE_TABLE;
if ( !( $result = $db->sql_query( $sql ) ) )
{
	mx_message_die( GENERAL_ERROR, "Couldn't get list of page", "", __LINE__, __FILE__, $sql );
}

$valid_page_ids_array = array();
while ( $page_row = $db->sql_fetchrow( $result ))
{
	//
	// Page auth
	//
	$mx_page_temp = new mx_page();
	$mx_page_temp->init($page_row['page_id']);

	if ( $mx_page_temp->auth_view )
	{
		$valid_page_ids_array[] = $page_row['page_id'];
	}

}
$db->sql_freeresult($result);
*/

$valid_page_ids_array = array();
foreach( $mx_page->page_rowset as $temp_key => $page_row )
{
	$_auth_ary = $mx_page->auth($page_row['auth_view'], $page_row['auth_view_group'], $page_row['auth_moderator_group']);
	if ($_auth_ary['auth_view'])
	{
		$valid_page_ids_array[] = $page_row['page_id'];
	}
}

//
// Now find the associated pages
//
$page_ids = array();
$block_ids = array();
$valid_page_ids = '';
foreach($block_rowset as $key => $block_row)
{
	$page_id_array = get_page_id($block_row['block_id'], false, true);

	if (in_array($page_id_array['page_id'], $valid_page_ids_array))
	{
		$page_ids[$block_row['block_id']] = $page_id_array;
		$block_ids[] = $block_row['block_id'];
	}
}

$valid_block_ids = implode( ', ', $block_ids );
$log_total_match_count = count( $block_ids );

if ( $log_total_match_count == 0 || $log_total_match_count == '')
{
	$template->assign_block_vars("no_row", array(
		'L_NO_ITEMS' => $lang['No_items_found']
	));
}
else
{
	//
	// Generate page_blocks data
	//
	$sql = "SELECT block_id, block_desc, block_title, block_time, block_editor_id
	   		FROM " . BLOCK_TABLE . "
			WHERE block_id IN (" . $valid_block_ids . ")
			ORDER BY block_time DESC
			LIMIT ".$log_start.", ".$log_numberOfEvents;

	if ( !( $result = $db->sql_query( $sql ) ) )
	{
		mx_message_die( GENERAL_ERROR, 'Could not obtain search results', '', __LINE__, __FILE__, $sql );
	}

	$folder_image = $images['mx_dot'];

	//
	// Dump out the results
	//
	$row_count = 0;
	$editor_name_tmp = array();
	while( $searchdata = $db->sql_fetchrow($result) )
	{
		$row_count++;
		$search_block_id = $searchdata['block_id'];

		if (is_array($page_ids[$search_block_id]) && !empty($page_ids[$search_block_id]['block_id']))
		{
			$dynamic_block_id = $page_ids[$search_block_id]['block_id'];
			$pageid = $page_ids[$search_block_id]['page_id'];
		}
		else if (is_array($page_ids[$search_block_id]))
		{
			$dynamic_block_id = '';
			$pageid = $page_ids[$search_block_id]['page_id'];
		}
		else
		{
			$dynamic_block_id = '';
			$pageid = $page_ids[$search_block_id];
		}

		$row_color = ( !( $row_count % 2 ) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !( $row_count % 2 ) ) ? $theme['td_class1'] : $theme['td_class2'];

		$page_title = $page_ids[$search_block_id]['page_name'];
		$page_desc = $page_ids[$search_block_id]['page_desc'];

		$temp_url = !empty($dynamic_block_id) ?  mx_append_sid( PORTAL_URL . 'index.php?page=' . $pageid . '&dynamic_block=' . $dynamic_block_id )  : mx_append_sid( PORTAL_URL . 'index.php?page=' . $pageid );

		if (empty($editor_name_tmp[$searchdata['block_editor_id']]))
		{
			$editor_name_tmp[$searchdata['block_editor_id']] = mx_get_userdata( $searchdata['block_editor_id'] );
			$editor_name = $editor_name_tmp[$searchdata['block_editor_id']]['username'];
		}

		$edit_time = !empty($searchdata['block_time']) ? phpBB2::create_date($board_config['default_dateformat'], $searchdata['block_time'], $board_config['board_timezone'] ) : '';

		$block_editor = '<a href="' . mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $searchdata['block_editor_id']) . '" class="name">';
		$block_editor .= $editor_name;
		$block_editor .= '</a>';

		$block_title = $searchdata['block_title'];
		$block_desc = $searchdata['block_desc'];

		$block_title_url = $temp_url;
		$page_title_url = $temp_url;

		$template->assign_block_vars("msg_row", array(
			'L_BLOCK_UPDATED' => $lang['Block_updated_by'],
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"EDIT_TIME" => $edit_time,
			"LAST_PAGE" => $page_title,
			"LAST_BLOCK" => $block_title,
			"U_PAGE" => $page_title_url,
			"U_BLOCK" => $block_title_url ,
			'FOLDER_IMG' => $folder_image,
			'EDITOR' => $editor_name
		));
	}

	$db->sql_freeresult($result);

	$base_url = mx_this_url('modrewrite=no');

	$template->assign_vars( array(
		'L_TITLE' => ( !empty( $title ) ? $title : 'Last Message' ),
		'BLOCK_SIZE' => $block_size,
		'U_URL_NEXT' => $url_next,
		'U_URL_PREV' => $url_prev,
		'L_MSG_PREV' => $lang['Previous'],
		'L_MSG_NEXT' => $lang['Next'],
		'PAGINATION' => mx_generate_pagination( $base_url, $log_total_match_count, $log_numberOfEvents, $log_start, true, true, true, false, 'log_start' ),
		'PAGE_NUMBER' => sprintf( $lang['Page_of'], ( floor( $log_start / $log_numberOfEvents ) + 1 ), ceil( $log_total_match_count / $log_numberOfEvents ) )
	));
}

$template->pparse( "sitelog" );
?>