<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: admin_mx_news.php,v 1.1 2011/04/09 16:30:58 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

define( 'IN_PORTAL', true );

$phpEx = substr(strrchr(__FILE__, '.'), 1);

if ( @file_exists( './../viewtopic.'.$phpEx ) )
{
	define( 'IN_PHPBB', 1 );
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
	define( 'IN_PORTAL', 1 );
	define( 'MXBB_MODULE', true );

	//
	// Main paths
	//
	$mx_root_path = './../../../';
	$module_root_path = './../../../modules/mx_news/';

	//
	// Left Pane Paths
	//
	$setmodules_root_path = './../';
	$setmodules_module_path = 'modules/mx_news/';
	$setmodules_admin_path = $setmodules_module_path . 'admin/';

	define( 'MXBB_27x', file_exists( $setmodules_root_path . 'mx_login.php' ) );

	$phpEx = substr(strrchr(__FILE__, '.'), 1);
}

if ( !empty( $setmodules ) )
{
	$filename = basename( __FILE__ );
	$module['mxNews_mx_news']['0_Configuration'] = 'modules/mx_news/admin/' . $filename . "?action=setting";
	return;
}

//
// Includes
//
require( $mx_root_path . '/admin/pagestart.' . $phpEx );
include( $module_root_path . 'mx_news/mx_news_common.' . $phpEx );

// **********************************************************************
// Read language definition
// **********************************************************************
if ( !MXBB_MODULE )
{
	if ( !file_exists( $module_root_path . 'mxnews/language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx ) )
	{
		include( $module_root_path . 'mxnews/language/lang_english/lang_admin.' . $phpEx );
	}
	else
	{
		include( $module_root_path . 'mxnews/language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx );
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
// an array of all expected actions
//
$actions = array(
	'setting' => 'setting'
);

//
// Lets Build the page
//
$mx_news->adminmodule( $actions[$action] );
$mx_news->modules[$actions[$action]]->main( $action );

$mx_news->modules[$actions[$action]]->_mx_news();

include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );
?>