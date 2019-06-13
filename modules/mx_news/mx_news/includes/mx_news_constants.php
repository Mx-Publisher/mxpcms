<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: mx_news_constants.php,v 1.7 2012/10/25 13:00:20 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

if ( !MXBB_MODULE )
{
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? $script_name : '/' . $script_name;

	define( 'PORTAL_URL', $server_protocol . $server_name . $server_port . $script_name . '/' );
	define( 'PHPBB_URL', PORTAL_URL );

	$mx_table_prefix = $table_prefix;
	$is_block = false;
}
define( 'PAGE_NEWS', -77 );
define( 'MX_NEWS_ROOT_CAT', 0 );

//
// Tables
//
define( 'MX_NEWS_COMMENTS_TABLE', $mx_table_prefix . 'simplenews_comments' );
define( 'MX_NEWS_CONFIG_TABLE', $mx_table_prefix . 'simplenews_config' );

//
// Field Types
//
define( 'INPUT', 0 );
define( 'TEXTAREA', 1 );
define( 'RADIO', 2 );
define( 'SELECT', 3 );
define( 'SELECT_MULTIPLE', 4 );
define( 'CHECKBOX', 5 );

$mx_user->set_module_default_style('_core'); // For compatibility with core 2.8.x

if (is_object($mx_page))
{
	// -------------------------------------------------------------------------
	// Extend User Style with module lang and images
	// Usage:  $mx_user->extend(LANG, IMAGES)
	// Switches:
	// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
	// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
	// -------------------------------------------------------------------------
	$mx_user->extend();

	$mx_page->add_copyright( 'MXP News Module' );
	$mx_page->add_css_file(  );
}
?>