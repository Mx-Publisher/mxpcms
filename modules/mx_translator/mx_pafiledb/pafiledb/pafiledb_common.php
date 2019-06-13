<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: pafiledb_common.php,v 1.28 2009/07/29 05:08:13 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/*
// ===================================================
// addslashes to vars if magic_quotes_gpc is off
// ===================================================
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

// ===================================================
// to make it work with php version under 4.1 and other stuff
// ===================================================
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
include_once( $module_root_path . 'pafiledb/includes/pafiledb_constants.' . $phpEx );

//
// Load addon tools
//
// - Class module_cache
// - Class mx_custom_fields (pafiledb needs its own class version in functions.php)
// - Class mx_notification
// - Class mx_text
// - Class mx_text_formatting
//
if ( !MXBB_MODULE )
{
	include_once( $mx_mod_path . 'includes/functions_tools.' . $phpEx );
}
else
{
	include_once( $mx_root_path . 'includes/mx_functions_tools.' . $phpEx );
}




// **********************************************************************
//  If phpBB mod read theme definition and language in theme definition
// **********************************************************************
if ( !MXBB_MODULE )
{
	$sql = 'SELECT *
		FROM ' . THEMES_TABLE . '
		WHERE themes_id = ' . (int) $userdata['user_style'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, 'Could not query database for theme info');
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		$db->sql_freeresult($result);
		$template_name = $row['template_name'] ;
	}
	else
	{
		// We are trying to setup a style which does not exist in the database
		// Try to fallback to the board default (if the user had a custom style)
		// and then any users using this style to the default if it succeeds
		if ( $userdata['user_style'] != $board_config['default_style'])
		{
			$sql = 'SELECT *
				FROM ' . THEMES_TABLE . '
				WHERE themes_id = ' . (int) $board_config['default_style'];
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(CRITICAL_ERROR, 'Could not query database for theme info');
			}
			if ( $row = $db->sql_fetchrow($result) )
			{
				$db->sql_freeresult($result);
				$template_name = $row['template_name'] ;
			}
			else
			{
				message_die(CRITICAL_ERROR, "Could not get theme data for themes_id [$style]");
			}
		}
		else
		{
			message_die(CRITICAL_ERROR, "Could not get theme data for themes_id [$style]");
		}
	}

	$template_path = 'templates/' ;

	if ( $template )
	{
		$current_template_path = $template_path . $template_name;
	}
	else
	{
		$current_template_path = $template_path . 'subSilver';
	}

	// -------------------------------------------------------------------------
	// Prefix with PORTAL_URL
	// -------------------------------------------------------------------------
	$current_template_images = PORTAL_URL . $current_template_path . "/images";

	@include($phpbb_root_path . $template_path . $template_name . '/' . 'pafiledb.cfg');

	$img_lang = ( file_exists($mx_root_path . $current_template_path . '/images/lang_' . $board_config['default_lang']) ) ? $board_config['default_lang'] : 'english';

	while( list($key, $value) = @each($mx_images) )
	{
		if (is_array($value))
		{
			foreach( $value as $key2 => $val2 )
			{
				$images[$key][$key2] = $val2;
				$mx_images[$key][$key2] = $val2;
			}
			}
		else
		{
			$images[$key] = str_replace('{LANG}', 'lang_' . $img_lang, $value);
			$mx_images[$key] = str_replace('{LANG}', 'lang_' . $img_lang, $value);
		}
	}
}

include_once($module_root_path . 'pafiledb/includes/functions.' . $phpEx);
include_once($module_root_path . 'pafiledb/includes/functions_auth.' . $phpEx );
include_once($module_root_path . 'pafiledb/includes/functions_cache.' . $phpEx); //Temp fix
include_once($module_root_path . 'pafiledb/includes/functions_pafiledb.' . $phpEx);

//
// Load a wrapper for common phpBB2 functions (compatibility with core 2.8.x)
//
if ( defined('MXBB_28x') )
{
	include_once( $mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx );
}

//
// We need XS templates, also when ran as a phpBB2 MOD
//
if ( !MXBB_MODULE )
{
	include_once($module_root_path . 'pafiledb/includes/template.' . $phpEx); // Include XS template
	$template = new Template($module_root_path . 'templates/'. $theme['template_name']);
}

// ===================================================
// Load classes
// ===================================================
$pafiledb_cache = new pafiledb_cache($module_root_path . 'pafiledb/');
$pafiledb_functions = new pafiledb_functions();

$pafiledb_config = $pafiledb_functions->obtain_pafiledb_config();
		
if ($pafiledb_config['allow_comment_wysiwyg'] == '')
{
	$pafiledb_config = $pafiledb_functions->obtain_pafiledb_config(false);
}

$pafiledb_user = new mx_user_info();

if (defined('IN_ADMIN'))
{
	include_once( $module_root_path . 'pafiledb/includes/functions_admin.' . $phpEx );
	$pafiledb = new pafiledb_admin();
}
else
{
	$pafiledb = new pafiledb_public();
}
?>