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
 *    $Id: page_tail.php,v 1.1 2010/10/10 14:59:41 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

if ( !defined('IN_PORTAL') )
{
	die('Hacking attempt');
}

global $do_gzip_compress;

//
// Show the overall footer.
//
$admin_link = ( $userdata['user_level'] == ADMIN ) ? '<a href="' . PORTAL_URL . 'admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a><br /><br />' : '';

$template->set_filenames(array(
	'overall_footer' => ( empty($gen_simple_header) ) ? 'overall_footer.tpl' : 'simple_footer.tpl' )
);

//
// Generate the fold/unfold categories switches
//
if ( $mx_page->editcp_switch_show )
{
	$template->assign_block_vars('switch_edit_' . ( $mx_page->editcp_switch_on ? 'on' : 'off' ), array());
}

//
// Compose additinal copy footer
//
if ( count($mxbb_footer_addup) > 0 )
{
	$mxbb_footer_text = $lang['Modules_copy'] . '(' . implode(', ', $mxbb_footer_addup) . ')';
	$mxbb_footer_text = '<a href="' . PORTAL_URL . 'index.' . $phpEx . '?sid=' . $userdata['session_id'] . '&mx_copy=true' . '" target="_blank">' . $mxbb_footer_text . '</a>';
}

$edit_nav_icon_url = PORTAL_URL . TEMPLATE_ROOT_PATH . 'images/';

$template->assign_vars(array(
	'U_PORTAL_ROOT_PATH' => PORTAL_URL,
	'U_PHPBB_ROOT_PATH' => PHPBB_URL,
	'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,
	'MXBB_EXTRA' => $mxbb_footer_text,
	'POWERED_BY' => $lang['Powered_by'],
	'U_EDIT_NAV' => $edit_nav_icon_url,
	'ADMIN_OPTIONS' => $lang['Show_admin_options'],
	'MX_VERSION' => ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? PORTAL_VERSION : '',
	'PHPBB_VERSION' => ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? '2' . $board_config['version'] : '',
	'TRANSLATION_INFO' => (isset($lang['TRANSLATION_INFO'])) ? $lang['TRANSLATION_INFO'] : ((isset($lang['TRANSLATION'])) ? $lang['TRANSLATION'] : ''),
	'ADMIN_LINK' => $admin_link)
);

//
// Generate stats
//
$endtime = explode(' ', microtime());
$stime = ( $endtime[1] + $endtime[0] ) - $mx_starttime;

$execution_stats = '<div align="center"><span class="copyright">' . sprintf($lang['Execution_Stats'], $db->num_queries, round($stime, 4)) . '</span></div>';

// Comment out next 3 lines and stats will be turned off
$template->assign_vars(array(
	'EXECUTION_STATS' => $execution_stats)
);

$template->pparse('overall_footer');

//
// Update config cache
//
if ($mx_config_cache->modified)
{
	$mx_config_cache->unload();	
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