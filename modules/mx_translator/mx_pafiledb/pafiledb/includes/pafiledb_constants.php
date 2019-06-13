<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: pafiledb_constants.php,v 1.31 2013/06/17 15:44:18 orynider Exp $
* @copyright (c) 2002-2006 [Mohd Basri, PHP Arena, pafileDB, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

if (!MXBB_MODULE)
{
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? $script_name : '/' . $script_name;

	define( 'PORTAL_URL', $server_protocol . $server_name . $server_port . $script_name . '/' );
	define( 'PHPBB_URL', PORTAL_URL );

	$mx_table_prefix = $table_prefix;
	$is_block = false; // This also makes the script work for phpBB ;)
}
if (!isset($mx_table_prefix))
{
	$mx_table_prefix = $table_prefix;
}

//$module_root_path = PORTAL_URL . $module_root_path;
//die("$module_root_path");

@define('PAGE_DLOAD', -501);
@define('PAGE_DOWNLOAD', -501); // If this id generates a conflict with other mods, change it ;);
@define('PAGE_DL_DEFAULT', -501);
//@define('PAGE_DL_DEFAULT', PAGE_DOWNLOADS);
@define('ICONS_DIR', 'pafiledb/images/icons/');

// Tables
define( 'PA_CAT_TABLE', $mx_table_prefix . 'pa_cat' );
define( 'PA_CATEGORY_TABLE', $mx_table_prefix . 'pa_cat' );
define( 'PA_COMMENTS_TABLE', $mx_table_prefix . 'pa_comments' );
define( 'PA_CUSTOM_TABLE', $mx_table_prefix . 'pa_custom' );
define( 'PA_CUSTOM_DATA_TABLE', $mx_table_prefix . 'pa_customdata' );
define( 'PA_DOWNLOAD_INFO_TABLE', $mx_table_prefix . 'pa_download_info' );
define( 'PA_FILES_TABLE', $mx_table_prefix . 'pa_files' );
define( 'PA_LICENSE_TABLE', $mx_table_prefix . 'pa_license' );
define( 'PA_CONFIG_TABLE', $mx_table_prefix . 'pa_config' );
define( 'PA_VOTES_TABLE', $mx_table_prefix . 'pa_votes' );
define( 'PA_AUTH_ACCESS_TABLE', $mx_table_prefix . 'pa_auth' );
define( 'PA_MIRRORS_TABLE', $mx_table_prefix . 'pa_mirrors' );

// Switches
define( 'PAFILEDB_DEBUG', 1 ); // Pafiledb Mod Debugging on
define( 'PAFILEDB_QUERY_DEBUG', 1 );
define( 'PA_ROOT_CAT', 0 );
define( 'PA_CAT_ALLOW_FILE', 1 );
define( 'PA_AUTH_LIST_ALL', 0 );
define( 'PA_AUTH_ALL', 0 );
define( 'FILE_PINNED', 1 );
define( 'PA_AUTH_VIEW', 1 );
define( 'PA_AUTH_READ', 2 );
define( 'PA_AUTH_VIEW_FILE', 3 );
define( 'PA_AUTH_UPLOAD', 4 );
define( 'PA_AUTH_DOWNLOAD', 5 );
define( 'PA_AUTH_RATE', 6 );
define( 'PA_AUTH_EMAIL', 7 );
define( 'PA_AUTH_COMMENT_VIEW', 8 );
define( 'PA_AUTH_COMMENT_POST', 9 );
define( 'PA_AUTH_COMMENT_EDIT', 10 );
define( 'PA_AUTH_COMMENT_DELETE', 11 );

//
// Field Types
//
@define( 'INPUT', 0 );
@define( 'TEXTAREA', 1 );
@define( 'RADIO', 2 );
@define( 'SELECT', 3 );
@define( 'SELECT_MULTIPLE', 4 );
@define( 'CHECKBOX', 5 );

@define( 'RANKS_PATH', 'images/ranks' );

if ( !MXBB_MODULE || MXBB_27x )
{
	$pa_module_version = "pafileDB Download Manager v. 0.9.0";
	$pa_module_author = "Jon Ohlsson";
	$pa_module_orig_author = "Mohd";
}
else
{
	//$mx_user->set_module_default_style('_core'); // For compatibility with core 2.8.x
	
	if (is_object($mx_page))
	{
		// -------------------------------------------------------------------------
		// Extend User Style with module lang and images
		// Usage:  $mx_user->extend(LANG, IMAGES)
		// Switches:
		// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
		// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
		// -------------------------------------------------------------------------
		
		// **********************************************************************
		// First include shared phpBB2 language file 
		// **********************************************************************
		$mx_user->set_lang($mx_user->lang, $mx_user->help, 'lang_main');
		
		if (defined('IN_ADMIN'))
		{
			$mx_user->set_lang($mx_user->lang, $mx_user->help, 'lang_admin');
		}
		
		if (defined('IN_ADMIN'))
		{
			$mx_user->extend(MX_LANG_ALL, MX_IMAGES_NONE, $module_root_path, true);
		}
		else
		{
			$mx_user->extend(MX_LANG_MAIN, MX_IMAGES, $module_root_path, true);
		}

		$mx_page->add_copyright( 'MXP pafileDB Module' );
	}
}

// **********************************************************************
// If phpBB mod read language definition
// **********************************************************************
if ( !MXBB_MODULE )
{
	if ( !file_exists( $module_root_path . 'pafiledb/language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx ) )
	{
		include( $module_root_path . 'pafiledb/language/lang_english/lang_main.' . $phpEx );
	}
	else
	{
		include( $module_root_path . 'pafiledb/language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx );
	}
}
?>