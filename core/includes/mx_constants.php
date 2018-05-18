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
 *    $Id: mx_constants.php,v 1.1 2010/10/10 14:59:40 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

//
// ViewOnline extension for mxBB Portal Pages
//
define('MX_PORTAL_PAGES_OFFSET', -1000);

//
// mxBB Core table names
//
define('PORTAL_TABLE', $mx_table_prefix . 'portal');
define('MENU_NAV_TABLE', $mx_table_prefix . 'menu_nav');
define('MENU_CAT_TABLE', $mx_table_prefix . 'menu_categories');

define('MODULE_TABLE', $mx_table_prefix . 'module');
define('FUNCTION_TABLE', $mx_table_prefix . 'function');
define('PARAMETER_TABLE', $mx_table_prefix . 'parameter');
define('PARAMETER_OPTION_TABLE', $mx_table_prefix . 'parameter_option');

define('PAGE_TABLE' , $mx_table_prefix . 'page');
define('COLUMN_TABLE' , $mx_table_prefix . 'column');
define('COLUMN_BLOCK_TABLE', $mx_table_prefix . 'column_block');

define('BLOCK_TABLE', $mx_table_prefix . 'block');
define('BLOCK_SYSTEM_PARAMETER_TABLE', $mx_table_prefix . 'block_system_parameter');
define('BLOCK_USER_PARAMETER_TABLE', $mx_table_prefix . 'block_user_parameter');

define('COLUMN_TEMPLATES' , $mx_table_prefix . 'column_templates');
define('PAGE_TEMPLATES' , $mx_table_prefix . 'page_templates');

define('MX_MATCH_TABLE' , $mx_table_prefix . 'wordmatch');
define('MX_WORD_TABLE' , $mx_table_prefix . 'wordlist');
define('MX_SEARCH_TABLE' , $mx_table_prefix . 'search_results');

//
// Other common constants and definitions.
//
define('AUTH_ANONYMOUS', 9);

$current_template_images = $current_template_path . "/images";

?>