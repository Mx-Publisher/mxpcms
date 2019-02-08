<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: admin_pafiledb.php,v 1.9 2013/06/17 15:44:06 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

$phpEx = substr(strrchr(__FILE__, '.'), 1);

if ( @file_exists( './../viewtopic.'.$phpEx ) )
{
	define( 'IN_PHPBB', 1 );
	define( 'IN_PORTAL', 1 );	
	define( 'MXBB_MODULE', false );

	//
	// Main paths
	//
	$phpbb_root_path = $module_root_path = $mx_root_path = "./../";
	$mx_mod_path = $phpbb_root_path . 'mx_mod/';

	//
	// Left Pane Paths
	//
	$setmodules_admin_path = '';
	$setmodules_module_path = "./../";

	require_once( $phpbb_root_path . 'extension.inc' );
	require_once( $mx_mod_path . 'includes/functions_required.' . $phpEx );
}
else
{
	@define( 'MXBB_MODULE', true );

	//
	// Main paths
	//
	$mx_root_path = './../../../';
	$module_root_path = './../../../modules/mx_pafiledb/';

	//
	// Left Pane Paths (Ported as Mx-Addon)
	//
	$setmodules_root_path = './../';
	$setmodules_module_path = 'modules/mx_pafiledb/';
	$setmodules_admin_path = $setmodules_module_path . 'admin/';

	@define( 'MXBB_27x', file_exists( $setmodules_root_path . 'mx_login.php' ) );

	$phpEx = substr(strrchr(__FILE__, '.'), 1);
}
if ( !empty( $setmodules ) )
{
	$filename = basename( __FILE__ );
	$module['pafileDB_Download']['0_Configuration'] 	= $setmodules_admin_path . $filename . "?action=settings";
	$module['pafileDB_Download']['1_Cat_manage'] 		= $setmodules_admin_path . $filename . "?action=cat_manage";
	$module['pafileDB_Download']['2_File_manage'] 		= $setmodules_admin_path . $filename . "?action=file_manage";
	//$module['pafileDB_Download']['2_File_manage'] = mx_append_sid( $admin_module_root_path . 'admin_pa_file.' . $phpEx . '?action=file_manage');
	//$module['pafileDB_Download']['2_File_manage'] 		= $setmodules_admin_path . $filename . "?action=file_manage";
	$module['pafileDB_Download']['3_Permissions'] 		= $setmodules_admin_path . $filename . "?action=catauth_manage";
	$module['pafileDB_Download']['4_License'] 			= $setmodules_admin_path . $filename . "?action=license_manage";
	$module['pafileDB_Download']['5_Custom_manage'] 	= $setmodules_admin_path . $filename . "?action=custom_manage";
	$module['pafileDB_Download']['6_Fchecker'] 			= $setmodules_admin_path . $filename . "?action=fchecker_manage";
	return;
}
@define('IN_PORTAL', 1);
//
// Includes
//
include( $mx_root_path . '/admin/pagestart.' . $phpEx );
include( $module_root_path . 'pafiledb/includes/pafiledb_constants.' . $phpEx );
include( $module_root_path . 'pafiledb/pafiledb_common.' . $phpEx );

// **********************************************************************
// Read language definition
// **********************************************************************
if ( !MXBB_MODULE )
{
	if ( !file_exists( $module_root_path . 'pafiledb/language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx ) )
	{
		include( $module_root_path . 'pafiledb/language/lang_english/lang_admin.' . $phpEx );
	}
	else
	{
		include( $module_root_path . 'pafiledb/language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx );
	}
}
else
{
	if ( !file_exists( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx ) )
	{
		include( $module_root_path . 'language/lang_english/lang_admin.' . $phpEx );
	}
	else
	{
		include( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx );
	}
}

//
// Get action variable other wise set it to the main
//
$action = ( isset( $_REQUEST['action'] ) ) ? htmlspecialchars( $_REQUEST['action'] ) : 'setting';

//
// expected actions
//
@define( 'settings', 'settings' );
@define( 'cat_manage', 'cat_manage' );
@define( 'file_manage', 'file_manage' );
@define( 'catauth_manage', 'catauth_manage' );
@define( 'ug_auth_manage', 'ug_auth_manage' );
@define( 'license_manage', 'license_manage' );
@define( 'custom_manage', 'custom_manage' );
@define( 'fchecker_manage', 'fchecker_manage' );

//
// an array of all expected actions
//
$actions = array(
	'settings' => 'settings',
	'cat_manage' => 'cat_manage',
	'file_manage' => 'file_manage',
	'catauth_manage' => 'catauth_manage',
	'ug_auth_manage' => 'ug_auth_manage',
	'license_manage' => 'license_manage',
	'custom_manage' => 'custom_manage',
	'fchecker_manage' => 'fchecker_manage'
	);

//
// Lets Build the page
//
$pafiledb->adminmodule( $actions[$action] );
$pafiledb->modules[$actions[$action]]->main( $action );

$pafiledb->modules[$actions[$action]]->_pafiledb();

include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );
?>