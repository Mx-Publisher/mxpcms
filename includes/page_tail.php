<?php
/**
*
* @package page_tail
* @version $Id: page_tail.php,v 1.46 2013/06/28 15:32:38 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
* @internal
*
*/

if ( !defined('IN_PORTAL') )
{
	die('Hacking attempt');
}

global $do_gzip_compress;

//
// Show the overall footer.
//
$u_acp = PORTAL_URL . 'admin/index.' . $phpEx;
$l_acp = $lang['Admin_panel'];

$template->set_filenames(array(
	'overall_footer' => empty($mx_page->page_ov_footer) || !file_exists($mx_root_path . TEMPLATE_ROOT_PATH . $mx_page->page_ov_footer) ? ( empty($gen_simple_header) ? 'overall_footer.tpl' : 'simple_footer.tpl' ) : $mx_page->page_ov_footer
));

//
// Any blocks to edit?
//
if ($mx_page->editcp_exists)
{
	$template->assign_block_vars('editcp_exists', array(
		'EDITCP_CONTRACT_IMG' 		=> $images['mx_contract'],
		'EDITCP_EXPAND_IMG' 		=> $images['mx_expand'],
		'EDITCP_DYNAMIC_IMG' 		=> $mx_page->editcp_show ? $images['mx_contract'] : $images['mx_expand'],
		'ADMIN_OPTIONS' 			=> $lang['Show_admin_options']
	));
}

if( !is_object($phpBB2))
{
	$phpBB2 = new phpBB2();
}

//
// Page last updated (by)
//
if (!empty($mx_page->last_updated))
{
	$editor_name_tmp = mx_get_userdata($mx_page->last_updated_by);
	$editor_name = $editor_name_tmp['username'];
	$edit_time = $phpBB2->create_date( $board_config['default_dateformat'], $mx_page->last_updated, $board_config['board_timezone'] );

	$template->assign_block_vars('page_last_updated', array(
		'L_PAGE_UPDATED'	=> isset($lang['Page_updated_date']) ? $lang['Page_updated_date'] : 'Page Updated',
		'NAME' 		=> $mx_user->data['user_level'] == ADMIN ? $lang['Page_updated_by'] . ' ' . $editor_name : '',
		'TIME' 		=> $edit_time,
	));
}

$mxbb_footer_text = $lang['mx_about_title'];
$mxbb_footer_text_url = PORTAL_URL . 'index.' . $phpEx . '?sid=' . $userdata['session_id'] . '&mx_copy=true';

// Generate debug stats
// - from Olympus
$debug_output = '<div align="center"><span class="copyright">';
if (defined('DEBUG') && $userdata['user_level'] == ADMIN)
{
	$mtime = explode(' ', microtime());
	$totaltime = $mtime[0] + $mtime[1] - $mx_starttime;

	if (!empty($_REQUEST['explain']) && method_exists($db, 'sql_report'))
	{
		$db->sql_report('display');
	}

	$debug_output .= sprintf('Time : %.3fs | ' . @$db->sql_num_queries() . ' Queries | GZIP : ' .  (($board_config['gzip_compress']) ? 'On' : 'Off' ) . ' | Load : '  . (($mx_user->load) ? $mx_user->load : 'N/A'), $totaltime);

	if (defined('DEBUG_EXTRA'))
	{
		if (function_exists('memory_get_usage'))
		{
			if ($memory_usage = memory_get_usage())
			{
				global $base_memory_usage;
				$memory_usage -= $base_memory_usage;
				$memory_usage = ($memory_usage >= 1048576) ? round((round($memory_usage / 1048576 * 100) / 100), 2) . ' ' . 'MB' : (($memory_usage >= 1024) ? round((round($memory_usage / 1024 * 100) / 100), 2) . ' ' . 'kB' : $memory_usage . ' ' . 'bytes');
					$debug_output .= ' | Memory Usage: ' . $memory_usage;
			}
		}
		$debug_output .= ' | <a href="' . (($_SERVER['REQUEST_URI']) ? htmlspecialchars($_SERVER['REQUEST_URI']) : "index.$phpEx$SID") . ((strpos($_SERVER['REQUEST_URI'], '?') !== false) ? '&amp;' : '?') . 'explain=1">Explain</a>';
	}
}
$debug_output .= '</span></div>';
//
// Generate additional footer code (defined by modules)
//
$mx_addional_footer_text = '';
if (isset($mx_page->mxbb_footer_addup) && (count($mx_page->mxbb_footer_addup) > 0))
{
	foreach($mx_page->mxbb_footer_addup as $key => $mx_footer_text)
	{
		$mx_addional_footer_text .= "\n"."\n".$mx_footer_text;
	}
}

if( !is_object($mx_backend))
{
	$mx_backend = new mx_backend();
}

$mx_backend->page_tail('generate_backend_version');

$template->assign_vars(array(
	'U_PORTAL_ROOT_PATH' 		=> PORTAL_URL,
	'U_PHPBB_ROOT_PATH' 		=> PHPBB_URL,
	'TEMPLATE_ROOT_PATH' 		=> TEMPLATE_ROOT_PATH,
	'MXBB_EXTRA' 				=> $mxbb_footer_text,
	'MXBB_EXTRA_URL' 			=> $mxbb_footer_text_url,
	'SITENAME'					=> $board_config['sitename'],
	'POWERED_BY' 				=> $lang['Powered_by'],
	'MX_VERSION' 				=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? PORTAL_VERSION : '',
	'ADMIN_LINK' 				=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? '<a href="' . $u_acp . '?sid=' . $userdata['session_id'] . '">' . $l_acp . '</a><br />' : '',
	'L_ACP' 					=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? $l_acp : '',
	'U_ACP' 					=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? $u_acp : '',
	'U_CONTACT_US'			=> ($mx_user->data['user_last_privmsg']) ? mx_append_sid("{$phpbb_root_path}memberlist.$phpEx?mode=contactadmin") : '',
	
	'U_TEAM'				=> ($mx_user->data['user_id'] != ANONYMOUS && (PORTAL_BACKEND !== 'internal') && $phpbb_auth->acl_get('u_viewprofile')) ?  mx_append_sid("{$phpbb_root_path}memberlist.$phpEx?mode=team") : '',
	'U_TERMS_USE'			=> mx_append_sid("{$phpbb_root_path}profile.$phpEx?mode=terms"),
	'U_PRIVACY'				=> mx_append_sid("{$phpbb_root_path}profile.$phpEx?mode=privacy"),
		
	'MX_ADDITIONAL_FOOTER_TEXT' => $mx_addional_footer_text,
	'EXECUTION_STATS'			=> (defined('DEBUG')) ? $debug_output : ''
));

$template->pparse('overall_footer');

//
// Close the mx_page class
//
$mx_page->_core();

//
// Unload cache, must be done before the DB connection is closed
//
if (!empty($mx_cache))
{
	$mx_cache->unload();
}

//
// Close our DB connection.
//
$db->sql_close();

//
// Compress buffered output if required and send to browser
//
if ( $do_gzip_compress )
{
	//
	// Borrowed from php.net!
	//
	$gzip_contents = ob_get_contents();
	ob_end_clean();

	$gzip_size = strlen($gzip_contents);
	$gzip_crc = crc32($gzip_contents);

	$gzip_contents = gzcompress($gzip_contents, 9);
	$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	echo $gzip_contents;
	echo pack('V', $gzip_crc);
	echo pack('V', $gzip_size);
}

exit;
?>