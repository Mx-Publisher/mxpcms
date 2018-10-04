<?php
/**
*
* @package MX-Publisher Core
* @version $Id: admin_mx_preview.php,v 1.5 2013/06/28 15:32:37 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/


if( !empty($setmodules) )
{
	return;
	$module['Administration']['Preview_portal'] = 'admin/' . basename(__FILE__) . '?mode=portal';
	$module['Administration']['Preview_forum'] = 'admin/' . basename(__FILE__) . '?mode=forum';
	return;
}


//
// Security and Page header
//
@define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require('./pagestart.' . $phpEx);

//
// Set mode
//
if ($mx_request_vars->is_request('mode'))
{
	$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS);
}
else
{
	$mode = '';
}

$preview_action = ($mode == 'portal') ? mx_append_sid(PORTAL_URL . "index.$phpEx") : mx_append_sid(PHPBB_URL . "index.$phpEx");

$template->set_filenames(array( 'admin_preview' => 'admin/admin_mx_preview.tpl') );

	$template->assign_vars(array(
		'U_PHPBB_ROOT_PATH' => PHPBB_URL,
		'U_PORTAL_ROOT_PATH' => PORTAL_URL,
		"U_PHPBB_INDEX" => mx_append_sid(PHPBB_URL . "index.$phpEx"),
		"U_PORTAL_INDEX" => mx_append_sid(PORTAL_URL . "index.$phpEx"),
		"L_PORTAL_INDEX" => $lang['Portal_index'],
		"L_PREVIEW_PORTAL" => $lang['Preview_portal'],
		"S_PREVIEW_ACTION" => $preview_action,
		"L_PREVIEW_FORUM" => $lang['Preview_forum'])
	);

$template->pparse('admin_preview');
include_once('page_footer_admin.' . $phpEx);
?>