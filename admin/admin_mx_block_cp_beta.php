<?php
/**
*
* @package MX-Publisher Core
* @version $Id: admin_mx_block_cp.php,v 1.26 2009/06/18 21:38:58 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['2_CP']['2_3_BlockCP'] = 'admin/' . $file;
	return;
}

//
// Security and Page header
//
define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = TRUE;
require('./pagestart.' . $phpEx);

//
// Instatiate the mx_admin class
//
$mx_admin = new mx_admin();

//
// Initialize template
//
//$blockcptemplate = new mx_Template( $template->root, $board_config, $db );
$blockcptemplate = new mx_Template( $mx_root_path . 'templates/'. $theme['template_name'], $board_config, $db );

//
// Load BlockCp
//
$mx_blockcp = new mx_blockcp();

//
// Mode setting
//
$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS, '');
$action = $mx_request_vars->request('action', MX_TYPE_NO_TAGS, '');
$blog_mode = $mx_request_vars->request('blog_mode', MX_TYPE_NO_TAGS, '');
$sid = $mx_request_vars->request('sid', MX_TYPE_NO_TAGS, '');

//
// Initial vars
//
$block_id = $mx_request_vars->is_request('block_id') ? $mx_request_vars->request('block_id', MX_TYPE_INT, '') : $mx_request_vars->request('id', MX_TYPE_INT, '');
$portalpage = $mx_request_vars->request('portalpage', MX_TYPE_INT, 0);
$sub_id = $mx_request_vars->request('sub_id', MX_TYPE_INT, 0);
$blog_u = $mx_request_vars->request('u', MX_TYPE_INT, $userdata['user_id']);

//
// Parameters
//
$submit = $mx_request_vars->is_post('submit');
$submit_pars = $mx_request_vars->is_post('submit_pars');
$cancel = $mx_request_vars->is_post('cancel');
$preview = $mx_request_vars->is_post('preview');
$refresh = $preview || $submit_search;

//
// Cancel
//
if( $cancel )
{
	$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header($header_location . mx_append_sid(PORTAL_URL . "index.$phpEx?page=" . $portalpage));
	exit;
}

//
// Intitialize with cookie stored block id
//
if ( empty($block_id) && !$mx_request_vars->is_request('function_id') )
{
	$cookie_tmp = $board_config['cookie_name'].'_adminBlockCP_block_id';
	$block_id = !empty($_COOKIE[$cookie_tmp]) ? $_COOKIE[$cookie_tmp] : 1;
}
else if ( empty($block_id) && $mx_request_vars->is_request('function_id') )
{
	$block_id = 'noBlock'; // blockCP, functions with no blocks
}
else
{
	setcookie($board_config['cookie_name'] . '_adminBlockCP_block_id', $block_id, time() + 10000000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
}

//
// Init the User BlockCP
//
if (is_numeric($block_id))
{
	$mx_blockcp->init($block_id, true);
}

//
// Define blockcp mode: 'mx_blockcp' or 'admin_mx_block_cp'
//
$mx_blockcp->blockcp_mode = 'admin_mx_block_cp';

//
// SUBMIT?
//
if( !empty($mode) && !empty($action) && !$preview)
{
	//
	// Get vars
	//
	if( !$submit_pars )
	{
		$module_id = $mx_request_vars->request('module_id', MX_TYPE_INT, '');
		$function_id = $mx_request_vars->request('function_id', MX_TYPE_INT, '');

		//
		// Send to adminCP
		//
		$result_message = $mx_admin->do_it($mode, $action, $block_id);

		//
		// If new block, load new block settings panel
		//
		if (is_array($result_message))
		{
			$block_id = $result_message['new_id'];
			$result_message = $result_message['text'];
		}

		if ($action == MX_DO_DELETE)
		{
			$block_id = '';
			$message = $lang['BlockCP_Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_blockCP_admin'], '<a href="' . mx_append_sid(PORTAL_URL . "admin/admin_mx_block_cp.".$phpEx, "block_id=$block_id&amp;module_id=$module_id&amp;function_id=$function_id&amp;portalpage=$portalpage$has_dyn_block_id&amp;sid=".$userdata['session_id'],true) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_portalpage_admin'], '<a href="' . mx_append_sid(PORTAL_URL . "index.$phpEx?page=$portalpage$has_dyn_block_id") . '">', '</a>');
			mx_message_die(GENERAL_MESSAGE, $message );
		}
	}

	if( $submit_pars )
	{
		//
		// Send to BlockCP
		//
		$result_message = $mx_blockcp->submit_parameters($block_id);
	}

	$result_message = $lang['AdminCP_status'] . '<hr>' . $result_message;

	//
	// Refresh mx_block object with new settings
	//
	$mx_blockcp->init($block_id, true);

} // if .. !empty($mode)

//
// Hidden vars
//
$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $block_id . '" />';
$s_hidden_fields .= '<input type="hidden" name="portalpage" value="' . $portalpage . '" />';
$s_hidden_fields .= '<input type="hidden" name="sub_id" value="' . $sub_id . '" />';
$s_hidden_fields .= '<input type="hidden" name="u" value="' . $blog_u . '" />';
$s_hidden_fields .= '<input type="hidden" name="blog_mode" value="' . $blog_mode . '" />';

// **********************************************************************
// Read language definition
// **********************************************************************
if( file_exists($mx_root_path . $mx_blockcp->module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) )
{
	include($mx_root_path . $mx_blockcp->module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
}
else if( file_exists($mx_root_path . $mx_blockcp->module_root_path . 'language/lang_english/lang_admin.' . $phpEx) )
{
	include($mx_root_path . $mx_blockcp->module_root_path . 'language/lang_english/lang_admin.' . $phpEx);
}

//
// Load Dynamic Block Navigation
//
$mx_dynamic_select = new mx_dynamic_select();
$mx_dynamic_select->generate($block_id, true);
$blockcptemplate->assign_block_vars('dynamic_select', array());
//
// Start output
//
$blockcptemplate->set_filenames(array(
	'body' => 'admin/mx_blockcp_admin_body.tpl'
));

//
// Variables
//
$blockcptemplate->assign_vars(array(
	'RESULT_MESSAGE'			=> !empty($result_message) ? '<div style="overflow:auto; height:50px;"><span class="gensmall">' . $result_message  . '<br/> -::-</span></div>': '',
	'S_ACTION_SUBMIT' 			=> mx_append_sid("admin_mx_block_cp.$phpEx")
));

$module_root_path = $mx_root_path . $mx_blockcp->module_root_path;
$mx_blockcp->blockcp_mode = 'admin_mx_block_cp';
$mx_blockcp->generate_cp($block_id);

include_once($mx_root_path . 'admin/page_header_admin.' . $phpEx);
$blockcptemplate->pparse('body');
include_once($mx_root_path . 'admin/page_footer_admin.' . $phpEx);
?>