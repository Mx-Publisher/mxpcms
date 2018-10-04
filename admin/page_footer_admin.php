<?php
/**
*
* @package MX-Publisher Core
* @version $Id: page_footer_admin.php,v 1.22 2013/06/28 15:32:37 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

global $do_gzip_compress;

//
// Show the overall footer.
//
$template->set_filenames(array( 'page_footer' => 'admin/page_footer.tpl' ));

//
// Generate stats
//
$endtime = explode(' ', microtime());
$stime = ( $endtime[1] + $endtime[0] ) - $mx_starttime;

$current_phpbb_version = $mx_backend->get_phpbb_version();

$execution_stats = sprintf($lang['Execution_Stats'], $db->num_queries, round($stime, 4));

$template->assign_vars(array(
	'PHPBB_VERSION' 		=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? $current_phpbb_version : '',
	'MX_VERSION' 			=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? PORTAL_VERSION : '',
	'TRANSLATION_INFO' 		=> (isset($lang['TRANSLATION_INFO'])) ? $lang['TRANSLATION_INFO'] : ((isset($lang['TRANSLATION'])) ? $lang['TRANSLATION'] : ''),
	'POWERED_BY'           	=> $lang['Powered_by'],
	'EXECUTION_STATS' 		=> $execution_stats
));

$template->pparse('page_footer');

if (!empty($mx_cache))
{
	$mx_cache->unload();
}

//
// Close our DB connection.
//
$db->sql_close();

//
// Compress buffered output if required
// and send to browser
//
if( $do_gzip_compress )
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