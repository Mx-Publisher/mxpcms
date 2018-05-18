<?php
/**
*
* @package MX-Publisher Module - mx_errordocs
* @version $Id: errordocs.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

// --------------------------------------------------------------------------------
// Block Initialization
// --------------------------------------------------------------------------------

if( function_exists('read_block_config') )
{
	if( !defined('IN_PORTAL') || !is_object($mx_block))
	{
		die("Hacking attempt");
	}

	//
	// Running as a Block...
	//
	$generate_headers = FALSE;
}
else
{
	//
	// Running Standalone...
	//
	define('IN_PORTAL', 1);
	$mx_root_path = '../../';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include_once($mx_root_path . 'common.'.$phpEx);
	$mx_user->init($user_ip, PAGE_INDEX);

	$block_id = ( !empty($HTTP_GET_VARS['block_id']) ) ? $HTTP_GET_VARS['block_id'] : $HTTP_POST_VARS['id'];
	if( empty($block_id) )
	{
		$sql = "SELECT * FROM " . BLOCK_TABLE . "  WHERE block_title = 'ErrorDocs' LIMIT 1";
		if( !$result = $db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, "Could not query ErrorDocs module information", "", __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$block_id = $row['block_id'];
	}
	$generate_headers = TRUE;
}

//
// Include common module stuff...
//
include_once($module_root_path . 'includes/common.' . $phpEx);

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$block_size = ( isset($block_size) && !empty($block_size) ? $block_size : '100%' );

$block_enable_log = $mx_block->get_parameters( 'ErrorDocs_Enable_Log' );
$block_include_codes = $mx_block->get_parameters( 'ErrorDocs_Include_Codes' );
$block_exclude_fiext = $mx_block->get_parameters( 'ErrorDocs_Exclude_Extensions' );
$block_max_records = $mx_block->get_parameters( 'ErrorDocs_Max_Records' );
if( $block_enable_log == '' || $block_enable_log == 'TRUE' )
{
	$block_enable_log = TRUE;
}


// --------------------------------------------------------------------------------
// Block Procedure
// --------------------------------------------------------------------------------

//
// Get arguments...
//
global $HTTP_GET_VARS;
$errdoc_code = ( isset($HTTP_GET_VARS['errno']) ) ? intval($HTTP_GET_VARS['errno']) : 0;
$errdoc_log = ( isset($HTTP_GET_VARS['errlog']) && $HTTP_GET_VARS['errlog'] == 'yes' && $block_enable_log ) ? TRUE : FALSE;

//
// ErrorDocs procedure (behind the class)...
//
$errdoc = new clsErrorDocs($block_max_records);
$errdoc->set_include_codes($block_include_codes);
$errdoc->set_exclude_fiext($block_exclude_fiext);
$errdoc->capture_error_info($errdoc_code);

//
// Generate header if running standalone...
//
if( $generate_headers )
{
	$page_title = $block_title;
	include($mx_root_path . 'includes/page_header.'.$phpEx);
}

//
// This is the template used to render this block.
//
$template->set_filenames(array(
	'body' => 'errordocs_body.tpl')
);

//
// Setup common template vars and display the block.
//
if( $errdoc_log && $errdoc->is_write_log_allowed() )
{
	//
	// Ok, try to log the HTTP Error record...
	//
	if( $errdoc->write_log() )
	{
		$template->assign_vars(array('L_ERROR_LOGGED' => $lang['ErrorDocs_Logged'].' IP: '. decode_ip($errdoc->user_ip)));
	}
}
$template->assign_vars(array(
	'L_ERROR_CODE'		=> $errdoc->code,
	'L_ERROR_SHORT'		=> $errdoc->short_info,
	'L_ERROR_LONG'		=> $errdoc->long_info,
	'U_REQUEST_URI'		=> $errdoc->request_uri,
	'L_REFERER_INFO'	=> $errdoc->referer_info,
	'L_MORE_INFO'		=> $lang['ErrorDocs_MoreInfo'],
	'L_SERVER_NAME'		=> $errdoc->server_name,
	'U_MODULE_IMAGES'	=> PORTAL_URL . $module_root_path . 'templates/images/',
	'BLOCK_SIZE'		=> $block_size,
	'L_TITLE'			=> $errdoc->title)
);

$template->pparse('body');

//
// Generate footer if running standalone...
//
if( $generate_headers )
{
	include_once($mx_root_path . 'includes/page_tail.'.$phpEx);
}

?>