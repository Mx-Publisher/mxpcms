<?php
/**
*
* @package MX-Publisher Module - mx_rebuild_search_tables
* @version $Id: admin_rebuild_search.php,v 1.2 2009/01/24 16:48:08 orynider Exp $
* @copyright (c) 2002-2008 [phpBB, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if(!empty ($setmodules))
{
	$filename = basename(__FILE__);
	$module['Rebuild Search']['Optimize tables'] = 'modules/mx_rebuild_search_tables/admin/' . $filename;
	return;
}

//
// Security and Page header
//
define('IN_PORTAL', 1);
$module_root_path = '../';
$mx_root_path = '../../../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include_once($mx_root_path . 'common.' . $phpEx);

global $mx_request_vars;
$start_time = time ();
$time_limit = $mx_request_vars->get('time_limit', MX_TYPE_INT);

$no_page_header = true;
require_once($mx_root_path . 'admin/pagestart.' . $phpEx);

switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'phpbb3':
		mx_message_die(GENERAL_MESSAGE, 'This feature is designed for MX-Publisher with phpBB2 backend, thus not compatible with current setup.');
	
	break;

	case 'phpbb2':

	break;
}



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

if ($mx_request_vars->is_get('start'))
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

	$start = $mx_request_vars->get('start', MX_TYPE_INT);

	if ($start == 0)
	{
		$sql = "DELETE FROM ". SEARCH_TABLE;
		$result = $db->sql_query ($sql);

		$sql = "DELETE FROM ". SEARCH_WORD_TABLE;
		$result = $db->sql_query ($sql);

		$sql = "DELETE FROM ". SEARCH_MATCH_TABLE;
		$result = $db->sql_query ($sql);

		$sql = "SELECT post_id FROM ". POSTS_TEXT_TABLE;

		if ( !$result = $db->sql_query ($sql) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not obtain post ids', '', __LINE__, __FILE__, $sql );
		}

		$total_num_rows = $db->sql_numrows ($result);
	}

	$total_num_rows = $mx_request_vars->get('total_num_rows', MX_TYPE_INT, $total_num_rows);

	$sql = "SELECT post_id, post_subject, post_text FROM ". POSTS_TEXT_TABLE ." LIMIT $start, ". $mx_request_vars->get('post_limit', MX_TYPE_INT);

	if ( !$result = $db->sql_query ($sql) )
	{
		mx_message_die( GENERAL_ERROR, 'Could not obtain post ids data', '', __LINE__, __FILE__, $sql );
	}

	$num_rows = 0;

	while (($row = $db->sql_fetchrow ($result)) )
	{
		add_search_words('single', $row['post_id'], stripslashes($row['post_text']), stripslashes($row['post_subject']));
		$num_rows++;
	}

	$template->set_filenames(array(
		"body" => "admin/admin_message_body.tpl")
	);

	if (($start + $num_rows) != $total_num_rows)
	{
		$form_action = mx_append_sid("admin_rebuild_search.$phpEx?start=". ($start + $num_rows) ."&total_num_rows=$total_num_rows&post_limit=". $mx_request_vars->get('post_limit',MX_TYPE_INT) ."&time_limit=$time_limit&refresh_rate=". $mx_request_vars->get('refresh_rate', MX_TYPE_INT));
		$next = $lang['Next'];
		$template->assign_vars(array(
			"META" => '<meta http-equiv="refresh" content="'. $mx_request_vars->get('refresh_rate', MX_TYPE_INT) .';url='. $form_action .'">')
		);
	}
	else
	{
		$next = $lang['Finished'];
		$form_action = mx_append_sid("admin_rebuild_search.$phpEx");
	}

	include_once($mx_root_path . 'admin/page_header_admin.' . $phpEx);

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
		'L_REBUILD_SEARCH' => $lang['Rebuild_search'],
		'L_REBUILD_SEARCH_DESC' => $lang['Rebuild_search_desc'],
		'L_POST_LIMIT' => $lang['Post_limit'],
		'L_TIME_LIMIT' => $lang['Time_limit'],
		'L_REFRESH_RATE' => $lang['Refresh_rate'],
		'SESSION_ID' => $userdata['session_id'],

		'S_REBUILD_SEARCH_ACTION' => mx_append_sid ("admin_rebuild_search.$phpEx"))
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