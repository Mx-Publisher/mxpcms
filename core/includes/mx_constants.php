<?php
/**
*
* @package Constants
* @version $Id: mx_constants.php,v 1.2 2009/01/24 16:47:51 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

//
// Include phpBB constants
//
include_once($phpbb_root_path . 'includes/constants.' . $phpEx);

/**
 * ViewOnline extension for mxBB Portal Pages
 * @access private
 */
define('MX_PORTAL_PAGES_OFFSET', 1000);

/**
 * Other common constants and definitions.
 * @access private
 */
define('AUTH_ANONYMOUS', 9);

/**#@+
 * MX-Publisher Core table names
 * @access public
 */
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

define('MX_THEMES_TABLE', $mx_table_prefix.'themes');

define('MX_MATCH_TABLE' , $mx_table_prefix . 'wordmatch');
define('MX_WORD_TABLE' , $mx_table_prefix . 'wordlist');
define('MX_SEARCH_TABLE' , $mx_table_prefix . 'search_results');
/**#@-*/

/**
 * Sick and tired of these variables getting lost...
 */
$html_entities_match = array('#&(?!(\#[0-9]+;))#', '#<#', '#>#', '#"#');
$html_entities_replace = array('&amp;', '&lt;', '&gt;', '&quot;');

$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
$unhtml_specialchars_replace = array('>', '<', '"', '&');
?>