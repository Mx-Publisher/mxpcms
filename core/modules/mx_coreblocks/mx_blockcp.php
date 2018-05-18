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
 *    $Id: mx_blockcp.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

define( 'IN_PORTAL', 1 );
$mx_root_path = "./../../";
include($mx_root_path . 'extension.inc');
include($mx_root_path . 'common.' . $phpEx);

include($mx_root_path . 'includes/mx_functions_blockcp.' . $phpEx);
include($mx_root_path . 'includes/mx_functions_admincp.' . $phpEx);

include_once($phpbb_root_path . 'includes/functions_search.'.$phpEx);	// required for search tables
include_once($phpbb_root_path . "includes/functions_post.$phpEx");		// required by mx_generate_smilies

//
// Start session management
//
$userdata = session_pagestart($user_ip, '-999');
mx_init_userprefs($userdata);
//
// End session management
//

// **********************************************************************
// Read language definition
// **********************************************************************
// phpBB
if( file_exists($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) )
{
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
}
else if( file_exists($phpbb_root_path . 'language/lang_english/lang_admin.' . $phpEx) )
{
	include($phpbb_root_path . 'language/lang_english/lang_admin.' . $phpEx);
}
// mxBB
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
$block_id = $mx_request_vars->request('block_id', MX_TYPE_INT, '');
$portalpage = $mx_request_vars->request('portalpage', MX_TYPE_INT, '');
$sub_id = $mx_request_vars->request('sub_id', MX_TYPE_INT, 0);
$blog_u = $mx_request_vars->request('u', MX_TYPE_INT, $userdata['user_id']);

//
// Parameters
//
$submit = ( isset($HTTP_POST_VARS['submit']) ) ? true : false;
$submit_pars = ( isset($HTTP_POST_VARS['submit_pars']) ) ? true : false;
$cancel = ( isset($HTTP_POST_VARS['cancel']) ) ? true : false;
$preview = ( isset($HTTP_POST_VARS['preview']) ) ? true : false;
$refresh = $preview || $submit_search;

//
// Cancel
//
if( $cancel )
{
	$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header($header_location . mx_append_sid(PORTAL_URL . "index.$phpEx?page=" . $portalpage, true));
	exit;
}

if ( empty($block_id) )
{
	$cookie_tmp = $board_config['cookie_name'].'_adminBlockCP_block_id';
	$block_id = !empty($HTTP_COOKIE_VARS[$cookie_tmp]) ? $HTTP_COOKIE_VARS[$cookie_tmp] : 1;
}

setcookie($board_config['cookie_name'] . '_adminBlockCP_block_id', $block_id, time() + 10000000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);

$mx_blockcp->init($block_id, true);

//
// Define blockcp mode: 'mx_blockcp' or 'admin_mx_block_cp'
//
$mx_blockcp->blockcp_mode = 'mx_blockcp';

//
// Auth
//
if ( !($mx_blockcp->auth_edit || $mx_blockcp->auth_mod) || $sid != $userdata['session_id'])
{
	die('You are not authorized to edit this block :(');
}

//
// SUBMIT?
//
if( !empty($mode) && !empty($action) && !$preview)
{
	//
	// Get vars
	//
	$id = $mx_request_vars->request('id', MX_TYPE_INT, '');
	$dynamic_block_id = $mx_request_vars->request('dynamic_block', MX_TYPE_INT, '');
	
	if( !$submit_pars )
	{
		$module_id = $mx_request_vars->request('module_id', MX_TYPE_INT, '');
		$function_id = $mx_request_vars->request('function_id', MX_TYPE_INT, '');
					
		//
		// Send to adminCP
		//
		$result_message = $mx_admin->do_it($mode, $action, $id);
		
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
		$result_message = $mx_blockcp->submit_parameters($id);
	}
	
	$has_dyn_block_id = $dynamic_block_id > 0 ? '&amp;dynamic_block='.$dynamic_block_id : '';
	$message = $lang['BlockCP_Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_blockCP_admin'], '<a href="' . mx_append_sid( PORTAL_URL ."modules/mx_coreblocks/mx_blockcp.$phpEx?block_id=$block_id&amp;module_id=$module_id&amp;function_id=$function_id&amp;portalpage=$portalpage$has_dyn_block_id&amp;sid=$sid") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_portalpage_admin'], '<a href="' . mx_append_sid(PORTAL_URL . "index.$phpEx?page=$portalpage$has_dyn_block_id") . '">', '</a>');
	mx_message_die(GENERAL_MESSAGE, $message);	
	
} // if .. !empty($mode)

$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $block_id . '" />';
$s_hidden_fields .= '<input type="hidden" name="portalpage" value="' . $portalpage . '" />';
$s_hidden_fields .= '<input type="hidden" name="sub_id" value="' . $sub_id . '" />';
$s_hidden_fields .= '<input type="hidden" name="u" value="' . $blog_u . '" />';
$s_hidden_fields .= '<input type="hidden" name="blog_mode" value="' . $blog_mode . '" />';

// **********************************************************************
// Read language definition
// **********************************************************************
// Module specific
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
$mx_dynamic_select->generate($block_id);

//
// Setup config parameters
//
//$block_config = $mode == 'editblog' ? read_block_config($block_id, false, $sub_id) : read_block_config($block_id, false);

//
// Blog mode:
//
//$blog_validate = ( $blog_mode == 'group' ) ? mx_auth_group($sub_id, true) : $sub_id == $userdata['user_id'];

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

$mx_blockcp->blockcp_mode = 'mx_blockcp';
$mx_blockcp->generate_cp($block_id, $new_block);

$mx_page->page_title = $lang['Block_admin'];
include( $mx_root_path . 'includes/page_header.' . $phpEx );

$blockcptemplate->pparse('body');

include($mx_root_path . 'includes/page_tail.' . $phpEx);

?>