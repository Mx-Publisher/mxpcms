<?php
/**
*
* @package MX-Publisher Core
* @version $Id: admin_mx_gen_cache.php,v 1.31 2013/06/28 15:32:37 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !empty($setmodules) )
{
	$module['4_Panel_system']['4_1_Cache'] = 'admin/' . basename(__FILE__);
	return;
}

//
// Security and Page header
//
@define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = TRUE;
require('./pagestart.' . $phpEx);

//
// Getting mode of operation
//
$generate = ( $mx_request_vars->request('generate', MX_TYPE_INT, 0) == 1 ? true : false );

//
// Load default template for install
//
$template->set_filenames(array( 'body' => 'admin/admin_message_body.tpl' ));

//
// Main procedure
//
if( !$generate )
{
	$message = $lang['Cache_explain'] . '<br />&nbsp;<br />&nbsp;<br />';
	$message .= '<form action="' . mx_append_sid(PORTAL_URL . "admin/admin_mx_gen_cache.$phpEx") . '" method="post">';
	$message .= '<input type="hidden" name="generate" value="1"/>';
	$message .= '<input type="submit" name="submit" value="' . $lang['Cache_submit'] . ' >>" class="liteoption" />';
	$message .= '</form>';
}
else
{
	//
	// Update MX-Publisher page/block cache
	//
	$mx_cache->trash(); // Empty cache folder
	$mx_cache->update(); // Regenerate all page_ and block_ files

	//
	// Update config/custom cache
	//
	$mx_cache->tidy(); // Not really needed
	$mx_cache->destroy('phpbb_config'); // Not really needed
	$mx_cache->destroy('mxbb_config'); // Not really needed
	$mx_cache->unload(); // Regenerate data_global.php

	$message = $lang['Cache_generate'];
}

$template->assign_vars(array(
	'MESSAGE_TITLE'	=> $lang['Generate_mx_cache'],
	'MESSAGE_TEXT'	=> $message
));

include_once("./page_header_admin.$phpEx");
$template->pparse('body');
include_once("./page_footer_admin.$phpEx");
?>