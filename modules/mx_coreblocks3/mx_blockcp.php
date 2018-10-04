<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_blockcp.php,v 1.27 2014/05/18 06:24:56 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
*
*/

define( 'IN_PORTAL', 1 );
$mx_root_path = "./../../";
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($mx_root_path . 'common.' . $phpEx);

include($mx_root_path . 'includes/mx_functions_blockcp.' . $phpEx);
include($mx_root_path . 'includes/mx_functions_admincp.' . $phpEx);

//
// Page selector
//
$page_id = $mx_request_vars->request('portalpage', MX_TYPE_INT, 1);

//
// Start session management
//
$mx_user->init($user_ip, $page_id, false);
//
// End session management
//

//
// Load and instatiate CORE (page) and block classes
//
$mx_page->init( $page_id );

//
// Initiate user style (template + theme) management
// - populate $theme, $images and initiate $template.
//
$mx_user->init_style();

//
// Initialize page layout template
//
$layouttemplate = new mx_Template( $mx_root_path . 'templates/'. $theme['template_name'] );

//
// **********************************************************************
// Read language definition
// **********************************************************************
//
// phpBB
//
if( file_exists($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) )
{
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
}
else if( file_exists($phpbb_root_path . 'language/lang_english/lang_admin.' . $phpEx) )
{
	include($phpbb_root_path . 'language/lang_english/lang_admin.' . $phpEx);
}

//
// MX-Publisher
//
if( file_exists($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) )
{
	include($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
}
else if( file_exists($mx_root_path . 'language/lang_english/lang_admin.' . $phpEx) )
{
	include($mx_root_path . 'language/lang_english/lang_admin.' . $phpEx);
}

//
// Instatiate the mx_admin class
//
$mx_admin = new mx_admin();

//
// Initialize template
//
$blockcptemplate = new mx_Template( $mx_root_path . 'templates/'. $theme['template_name'] );

//
// Load BlockCp
//
$mx_blockcp = new mx_blockcp();

//
// Mode setting
//
$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS, '');
$action = $mx_request_vars->request('action', MX_TYPE_NO_TAGS, '');
$sid = $mx_request_vars->request('sid', MX_TYPE_NO_TAGS, '');

//
// Initial vars
//
$block_id = $mx_request_vars->is_request('block_id') ? $mx_request_vars->request('block_id', MX_TYPE_INT, '') : $mx_request_vars->request('id', MX_TYPE_INT, '');
$portalpage = $mx_request_vars->request('portalpage', MX_TYPE_INT, '');
$virtual_id = $mx_request_vars->request('virtual', MX_TYPE_INT, '');
$sub_id = $mx_request_vars->request('sub_id', MX_TYPE_INT, 0);

$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;

//
// Parameters
//
$submit = $mx_request_vars->is_post('submit');
$submit_pars = $mx_request_vars->is_post('submit_pars');
$cancel = $mx_request_vars->is_post('cancel');
$preview = $mx_request_vars->is_post('preview');
$refresh = $preview || isset($submit_search);

//
// Cancel
//
if( $cancel )
{
	$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header($header_location . mx_append_sid(PORTAL_URL . "index.$phpEx?page=" . $portalpage, true));
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
	$block_id = 'noBlock'; // blockCP, functions with no blocks // This should NEVER happen when in blockCP (not adminCP) mode
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
$mx_blockcp->blockcp_mode = 'mx_blockcp';

//
// Auth
//
if ( !($mx_blockcp->auth_edit || $mx_blockcp->auth_mod || $is_admin) || $sid != $userdata['session_id'] )
{
	mx_message_die(GENERAL_MESSAGE, 'You are not authorized to edit this block :(');
}

//
// SUBMIT?
//
if( !empty($mode) && !empty($action) && !$preview)
{
	//
	// Get vars
	//
	$dynamic_block_id = $mx_request_vars->request('dynamic_block', MX_TYPE_INT, '');

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
		}
	}

	if( $submit_pars )
	{
		//
		// Send to BlockCP
		//
		$result_message = $mx_blockcp->submit_parameters($block_id);
	}
	$block_info = mx_get_info(BLOCK_TABLE, 'block_id', $block_id);
	$module_id = !empty($module_id) ? $module_id : '';
	$function_id = !empty($function_id) ? $function_id : $block_info['function_id'];

	$has_dyn_block_id = $dynamic_block_id > 0 ? '&amp;dynamic_block='.$dynamic_block_id : '';
	$message = $lang['BlockCP_Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_blockCP_admin'], '<a href="' . mx_append_sid( PORTAL_URL ."modules/mx_coreblocks/mx_blockcp.$phpEx?block_id=$block_id&amp;module_id=$module_id&amp;function_id=$function_id&amp;portalpage=$portalpage$has_dyn_block_id&amp;sid=$sid") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_portalpage_admin'], '<a href="' . mx_append_sid(PORTAL_URL . "index.$phpEx?page=$portalpage&amp;virtual=$virtual_id$has_dyn_block_id") . '">', '</a>');
	mx_message_die(GENERAL_MESSAGE, $message);

} // if .. !empty($mode)
$blog_u = isset($blog_u) ? $blog_u : "/";
$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $block_id . '" />';
$s_hidden_fields .= '<input type="hidden" name="virtual" value="' . $virtual_id . '" />';
$s_hidden_fields .= '<input type="hidden" name="portalpage" value="' . $portalpage . '" />';
$s_hidden_fields .= '<input type="hidden" name="sub_id" value="' . $sub_id . '" />';
$s_hidden_fields .= '<input type="hidden" name="u" value="' . $blog_u . '" />';
$s_hidden_fields .= '<input type="hidden" name="blog_mode" value="' . $mode . '" />';

// **********************************************************************
// Read language definition
// **********************************************************************
//
// Module specific
//
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
if ($is_admin)
{
	//
	// Removed from here atm
	//
	$mx_dynamic_select = new mx_dynamic_select();
	$mx_dynamic_select->generate($block_id);
	$blockcptemplate->assign_block_vars('dynamic_select', array());
}

//
// Setup config parameters
//
$block_config = $mode == 'editblog' ? read_block_config($block_id, false, $sub_id) : read_block_config($block_id, false);

//
// Blog mode:
//
$blog_validate = ( $mode == 'group' ) ? mx_auth_group($sub_id, true) : $sub_id == $userdata['user_id'];

/*
if( !($blog_validate || $is_auth_ary['auth_edit']) )
{
	$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header($header_location . mx_append_sid(PORTAL_URL . "index.$phpEx", true));
	exit;
}
*/

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
	'CANCEL' => '&nbsp;<input type="submit" name="cancel" value="' . $lang['return_to_page'] . '"class="liteoption" />',
	'RESULT_MESSAGE'	=> !empty($result_message) ? '<div style="overflow:auto; height:50px;"><span class="gensmall">-::-<br/>' . $result_message  . '<br/> -::-</span></div>': '',
	'S_ACTION' => mx_append_sid($mx_root_path . "modules/mx_coreblocks/mx_blockcp.$phpEx")
));

$module_root_path = $mx_root_path . $mx_blockcp->module_root_path;
$mx_blockcp->blockcp_mode = 'mx_blockcp';
$mx_blockcp->generate_cp($block_id);

$mx_page->page_title = $lang['Block_admin'];
include( $mx_root_path . 'includes/page_header.' . $phpEx );

$blockcptemplate->pparse('body');

include($mx_root_path . 'includes/page_tail.' . $phpEx);

?>