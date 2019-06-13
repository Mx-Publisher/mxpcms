<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: mx_news_common.php,v 1.4 2008/06/03 20:12:17 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/*
//
// addslashes to vars if magic_quotes_gpc is off
//
if ( !@function_exists( 'slash_input_data' ) )
{
	function slash_input_data( &$data )
	{
		if ( is_array( $data ) )
		{
			foreach ( $data as $k => $v )
			{
				$data[$k] = ( is_array( $v ) ) ? slash_input_data( $v ) : addslashes( $v );
			}
		}
		return $data;
	}
}

//
// to make it work with php version under 4.1 and other stuff
//
if ( @phpversion() < '4.1' )
{
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_ENV = &$HTTP_ENV_VARS;
	$_FILES = &$HTTP_POST_FILES;
	$_SESSION = &$HTTP_SESSION_VARS;
}

if ( !isset( $_REQUEST ) )
{
	$_REQUEST = array_merge( $_GET, $_POST, $_COOKIE );
}

if ( !get_magic_quotes_gpc() )
{
	$_GET = slash_input_data( $_GET );
	$_POST = slash_input_data( $_POST );
	$_COOKIE = slash_input_data( $_COOKIE );
	$_REQUEST = slash_input_data( $_REQUEST );
}
*/

// ===================================================
// Include Files
// ===================================================
include_once( $module_root_path . 'mx_news/includes/mx_news_constants.' . $phpEx );

//
// Load addon tools
//
// - Class module_cache
// - Class mx_custom_fields
// - Class mx_notification
// - Class mx_text
// - Class mx_text_formatting
//
include_once( $mx_root_path . 'includes/mx_functions_tools.' . $phpEx );

include_once( $module_root_path . 'mx_news/includes/functions.' . $phpEx );
include_once( $module_root_path . 'mx_news/includes/functions_auth.' . $phpEx );
include_once( $module_root_path . 'mx_news/includes/functions_mx_news.' . $phpEx );

//
// Load a wrapper for common phpBB2 functions (compatibility with core 2.8.x)
//
include_once( $mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx );

// ===================================================
// Load classes
// ===================================================
$mx_news_cache = new module_cache($module_root_path . 'mx_news/');
$mx_news_functions = new mx_news_functions();

if ( $mx_news_cache->exists( 'config' ) )
{
	$mx_news_config = $mx_news_cache->get( 'config' );
}
else
{
	$mx_news_config = $mx_news_functions->mx_news_config();
	$mx_news_cache->put( 'config', $mx_news_config );
}

if (defined( 'IN_ADMIN' ))
{
	include_once( $module_root_path . 'mx_news/includes/functions_admin.' . $phpEx );
	$mx_news = new mx_news_admin();
}
else
{
	$mx_news = new mx_news_public();
}
?>