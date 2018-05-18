<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: mx_simpledoc.php,v 1.7 2008/06/22 19:04:31 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Read Block Settings (default mode)
//
$title = !empty( $mx_block->block_info['block_title'] ) ? $mx_block->block_info['block_title'] : $lang['KB_title'];
$desc = $mx_block->block_info['block_desc'];
$block_size = ( isset( $block_size ) && !empty( $block_size ) ? $block_size : '100%' );

// -------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------

// ===================================================
// Get action variable other wise set it to the main
// ===================================================
$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS, 'view');

//
// Get more variables
//
$is_admin = ( ( $userdata['user_level'] == ADMIN  ) && $userdata['session_logged_in'] ) ? true : 0;

//
// Auth
//
//
// Page Auth and IP filter
//
if ( !( ( $mx_block->auth_view && $mx_block->show_block ) || $mx_block->auth_mod || $mode == 'index' ) )
{
	echo('Not authorized - to view');
	return;
}

if ( !( ( $mx_block->auth_view && $mx_block->auth_edit && $mx_block->show_block ) || $mx_block->auth_mod || $mode == 'view' || $mode == 'view_plain') )
{
	echo('Not authorized - to edit');
	return;
}

// ===================================================
// Include the common file
// ===================================================
include_once( $module_root_path . 'simpledoc/simpledoc_common.' . $phpEx );

// ===================================================
// if the module is disabled give them a nice message
// ===================================================
/*
if (!($simpledoc_config['enable_module'] || $mx_user->is_admin))
{
	mx_message_die( GENERAL_MESSAGE, $lang['simpledoc_disable'] );
}
*/

// ===================================================
// an array of all expected actions
// ===================================================
$actions = array(
	'view' => 'view',
	'view_plain' => 'view_plain',
	'index' => 'index',
	'import' => 'import',
	'export' => 'export',
	'export_single' => 'export_single',
	'publish' => 'publish',
	'publish_export' => 'publish_export',
	'settings' => 'settings');

// ===================================================
// Lets Build the page
// ===================================================
$mx_simpledoc->module( $actions[$mode] );
$mx_simpledoc->modules[$actions[$mode]]->main( $mode );

//
// load module header
//
//simpledoc_page_header( $page_title );

$template->pparse( 'body' );

//
// load module footer
//
//simpledoc_page_footer();

//
// Update cache
//
$mx_simpledoc_cache->unload();
?>