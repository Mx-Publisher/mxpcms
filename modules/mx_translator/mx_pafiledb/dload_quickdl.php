<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: dload_quickdl.php,v 1.20 2008/12/08 23:58:04 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$block_size = ( isset( $block_size ) && !empty( $block_size ) ? $block_size : '100%' );

$is_block = true;
global $images;

//
// Definitions
//
define( 'MXBB_MODULE', true );
define( 'MXBB_27x', file_exists( $mx_root_path . 'mx_login.php' ) );
define( 'MXBB_28x', @file_exists( $mx_root_path . 'includes/sessions/index.htm' ) );

list( $trash, $mx_script_name_temp ) = split ( trim( $board_config['server_name'] ), PORTAL_URL );
$mx_script_name = preg_replace( '#^\/?(.*?)\/?$#', '\1', trim( $mx_script_name_temp ) );

//
// Setup config parameters
//
$config_name = array( 'pa_mapping', 'pa_quick_cat' );

for( $i = 0; $i < count( $config_name ); $i++ )
{
	$config_value = $mx_block->get_parameters( $config_name[$i] );
	$pafiledb_quickdl[$config_name[$i]] = $config_value;
}

// ===================================================
// Include the common file
// ===================================================
include_once( $module_root_path . 'pafiledb/pafiledb_common.' . $phpEx );

// ===================================================
// Get action variable other wise set it to the main
// ===================================================
$action = ( isset( $_REQUEST['actionqdl'] ) ) ? htmlspecialchars( $_REQUEST['actionqdl'] ) : 'quickdl';

// ===================================================
// if the module is disabled give them a nice message
// ===================================================
if (!($pafiledb_config['enable_module'] || $mx_user->is_admin))
{
	//mx_message_die( GENERAL_MESSAGE, $lang['pafiledb_disable'] );
}

// ===================================================
// an array of all expected actions
// ===================================================
$actions = array( 'quickdl' => 'quickdl', 'download' => 'download' );

// ===================================================
// Lets Build the page
// ===================================================
$page_title = $lang['Download'];

if ( $action != 'download' )
{
	if ( !$is_block )
	{
		include( $mx_root_path . 'includes/page_header.' . $phpEx );
	}
}

$pafiledb->module( $actions[$action] );
$pafiledb->modules[$actions[$action]]->main( $action );

if ( $action != 'download' )
{
	if ( !$is_block )
	{
		include( $mx_root_path . 'includes/page_tail.' . $phpEx );
	}
}
?>