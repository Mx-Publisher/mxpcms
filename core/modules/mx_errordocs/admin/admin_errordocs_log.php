<?php
/**
*
* @package MX-Publisher Module - mx_errordocs
* @version $Id: admin_errordocs_log.php,v 1.3 2010/10/16 04:06:46 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

// ======================================================
//			[ ADMINCP COMMON INITIALIZATION ]
// ======================================================

//
// This is how we add an entry to the phpBB Administration Control Panel...
//
if( !empty($setmodules) )
{
	$module['ErrorDocs']['Log_Management'] = 'modules/mx_errordocs/admin/' . @basename(__FILE__);
	return;
}

//
// Setup basic portal stuff...
//
define('IN_PORTAL', 1);
$mx_root_path = '../../../';
$module_root_path = '../';

//
// Security and page header...
//
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = TRUE;
require($mx_root_path . 'admin/pagestart.' . $phpEx);

//
// Include common module stuff...
//
require($module_root_path . 'includes/common.' . $phpEx);

// ======================================================
//			[ MAIN PROCESS ]
// ======================================================

//
// Check to see if we need to ask for a module pack.
//
$mode  = $_GET['mode'];
$id    = $_GET['id'];
switch($mode)
{
	case 'delete':
		$sql = "DELETE FROM ".ERRORDOCS_LOG_TABLE." WHERE id = $id";
		if( !$result = $db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't DELETE ErrorDocs LOG record", "", __LINE__, __FILE__, $sql);
		}
		break;
	case 'delall':
		$sql = "DELETE FROM ".ERRORDOCS_LOG_TABLE;
		if( !$result = $db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't DELETE ErrorDocs LOG records", "", __LINE__, __FILE__, $sql);
		}
		break;
	default:
		break;
}

//
// Setup basic arguments...
//
$rec_days = ( isset($_GET['recdays']) ? intval($_GET['recdays']) : 7 );
$rec_sort = ( isset($_GET['recsort']) ? $_GET['recsort'] : 'tstamp' );

$this_href = basename(__FILE__).'?recdays='.$rec_days.'&recsort='.$rec_sort;

//
// Send Page Header...
//
include_once($mx_root_path . 'admin/page_header_admin.'.$phpEx);

//
// Report Log...
//
$template->set_filenames(array(
	'body' => "admin/errordocs_log_admin.tpl")
);

$sql = 'SELECT t01.id, t01.tstamp, t01.errno, t01.user_id, t01.user_ip, t01.request_uri, t01.http_referer, t02.username'.
		' FROM '.ERRORDOCS_LOG_TABLE.' t01, '.USERS_TABLE.' t02'.
		' WHERE t01.user_id = t02.user_id'.
		( empty($rec_days) ? '' : ' AND t01.tstamp > '.(time() - ($rec_days * 86400)) ).
		' ORDER BY '.( $rec_sort == 'username' ? 't02.' : 't01.' ).$rec_sort.', t01.id';
if( !$result = $db->sql_query($sql) )
{
	mx_message_die(GENERAL_ERROR, "Couldn't retrieve ErrorDocs LOG data", "", __LINE__, __FILE__, $sql);
}
$log_count = $db->sql_numrows($result);
$log_data = $db->sql_fetchrowset($result);

for( $i = 0; $i < $log_count; $i++ )
{
	$template->assign_block_vars('datarow', array(
		'ID'			=> $log_data[$i]['id'],
		'TSTAMP'		=> create_date('Y-m-d H:i:s', $log_data[$i]['tstamp'], $board_config['board_timezone']),
		'ERRNO'			=> $log_data[$i]['errno'],
		'USERNAME'		=> $log_data[$i]['username'],
		'USER_IP'		=> decode_ip($log_data[$i]['user_ip']),
		'REQUEST_URI'   => htmlspecialchars($log_data[$i]['request_uri']),
		'HTTP_REFERER'  => htmlspecialchars($log_data[$i]['http_referer']),
		'U_DELETE'		=> mx_append_sid($this_href.'&mode=delete&id='.$log_data[$i]['id']))
	);
}

$log_days = array(0, 1, 7, 14, 30, 90, 180, 364);
$log_days_text = array($lang['All_Records'], $lang['1_Day'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);
$select_rec_days = "\n";
for( $i = 0; $i < count($log_days); $i++ )
{
	$selected = ( $rec_days == $log_days[$i] ) ? ' selected="selected"' : '';
	$select_rec_days .= '<option value="' . $log_days[$i] . '"' . $selected . '>' . $log_days_text[$i] . '</option>'."\n";
}
$log_sort = array('tstamp', 'errno', 'username', 'user_ip', 'request_uri', 'http_referer');
$log_sort_text = array($lang['Date'], 'errno', 'User Name', 'User IP', 'Request URI', 'HTTP Referer');
$select_rec_sort = "\n";
for( $i = 0; $i < count($log_sort); $i++ )
{
	$selected = ( $rec_sort == $log_sort[$i] ) ? ' selected="selected"' : '';
	$select_rec_sort .= '<option value="' . $log_sort[$i] . '"' . $selected . '>' . $log_sort_text[$i] . '</option>'."\n";
}

$template->assign_vars(array(
	'L_ID'				=> 'Id.',
	'L_TSTAMP'			=> $lang['Date'],
	'L_ERRNO'			=> 'errno',
	'L_USERNAME'		=> 'User Name',
	'L_USER_IP'			=> 'User IP',
	'L_REQUEST_URI'		=> 'Request URI',
	'L_HTTP_REFERER'	=> 'HTTP Referer',

	'L_SELECT_REC_DAYS'	=> $lang['Display_Records'],
	'S_SELECT_REC_DAYS'	=> $select_rec_days,
	'L_SORT'			=> $lang['Select_sort_method'],
	'S_SELECT_REC_SORT'	=> $select_rec_sort,
	'U_THIS'			=> mx_append_sid($this_href),

	'L_ACTION'			=> $lang['Action'],
	'L_DELETE'			=> $lang['Delete'],
	'L_DELETE_ALL'		=> $lang['Delete_all'],
	'U_DELETE_ALL'		=> mx_append_sid($this_href.'&mode=delall'),
	'L_ARE_YOU_SURE'	=> $lang['Are_you_sure'],
	'L_TITLE_EXPLAIN'	=> $lang['Log_Management_Explain'],
	'L_TITLE'			=> $lang['ErrorDocs'].': '.$lang['Log_Management'])
);
$template->pparse('body');

//
// Send Page Footer...
//
include_once($mx_root_path . 'admin/page_footer_admin.'.$phpEx);
exit;
?>