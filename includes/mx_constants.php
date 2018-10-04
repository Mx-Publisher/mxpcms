<?php
/**
*
* @package Constants
* @version $Id: mx_constants.php,v 1.30 2008/09/24 17:01:11 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

// User Levels <- this values are for compatiblility with mxBB 2.8.x and phpBB2
// Revove them when MX-Publisher is fixed
!defined('DELETED') ? define('DELETED', -1) : false;
!defined('USER') ? define('USER', 0) : false;
!defined('ADMIN') ? define('ADMIN', 1) : false;
!defined('MOD') ? define('MOD', 2) : false;
// User Levels <- this values are for compatiblility with MX-Publisher 2.8.x and phpBB2

// URL PARAMETERS
!defined('POST_TOPIC_URL') ? define('POST_TOPIC_URL', 't') : false;
!defined('POST_CAT_URL') ? define('POST_CAT_URL', 'c') : false;
!defined('POST_FORUM_URL') ? define('POST_FORUM_URL', 'f') : false;
!defined('POST_USERS_URL') ? define('POST_USERS_URL', 'u') : false;
!defined('POST_POST_URL') ? define('POST_POST_URL', 'p') : false;
!defined('POST_GROUPS_URL') ? define('POST_GROUPS_URL', 'g') : false;

// Page numbers for session handling
!defined('PAGE_INDEX') ? define('PAGE_INDEX', 0) : false;
!defined('PAGE_LOGIN') ? define('PAGE_LOGIN', -1) : false;
!defined('PAGE_SEARCH') ? define('PAGE_SEARCH', -2) : false;
!defined('PAGE_REGISTER') ? define('PAGE_REGISTER', -3) : false;
!defined('PAGE_PROFILE') ? define('PAGE_PROFILE', -4) : false;
!defined('PAGE_VIEWONLINE') ? define('PAGE_VIEWONLINE', -6) : false;
!defined('PAGE_VIEWMEMBERS') ? define('PAGE_VIEWMEMBERS', -7) : false;
!defined('PAGE_FAQ') ? define('PAGE_FAQ', -8) : false;
!defined('PAGE_POSTING') ? define('PAGE_POSTING', -9) : false;
!defined('PAGE_PRIVMSGS') ? define('PAGE_PRIVMSGS', -10) : false;
!defined('PAGE_GROUPCP') ? define('PAGE_GROUPCP', -11) : false;
!defined('PAGE_TOPIC_OFFSET') ? define('PAGE_TOPIC_OFFSET', 5000) : false;

// Auth settings (blockCP)
!defined('AUTH_LIST_ALL') ? define('AUTH_LIST_ALL', 0) : false;
!defined('AUTH_ALL') ? define('AUTH_ALL', 0) : false;
!defined('AUTH_REG') ? define('AUTH_REG', 1) : false;
!defined('AUTH_ACL') ? define('AUTH_ACL', 2) : false;
!defined('AUTH_MOD') ? define('AUTH_MOD', 3) : false;
!defined('AUTH_ADMIN') ? define('AUTH_ADMIN', 5) : false;
!defined('AUTH_ANONYMOUS') ? define('AUTH_ANONYMOUS', 9) : false;

!defined('AUTH_VIEW') ? define('AUTH_VIEW', 1) : false;
!defined('AUTH_READ') ? define('AUTH_READ', 2) : false;
!defined('AUTH_POST') ? define('AUTH_POST', 3) : false;
!defined('AUTH_REPLY') ? define('AUTH_REPLY', 4) : false;
!defined('AUTH_EDIT') ? define('AUTH_EDIT', 5) : false;
!defined('AUTH_DELETE') ? define('AUTH_DELETE', 6) : false;
!defined('AUTH_ANNOUNCE') ? define('AUTH_ANNOUNCE', 7) : false;
!defined('AUTH_STICKY') ? define('AUTH_STICKY', 8) : false;
!defined('AUTH_POLLCREATE') ? define('AUTH_POLLCREATE', 9) : false;
!defined('AUTH_VOTE') ? define('AUTH_VOTE', 10) : false;
!defined('AUTH_ATTACH') ? define('AUTH_ATTACH', 11) : false;

/**
 * ViewOnline extension for MX-Publisher Pages
 * @access private
 */
define('MX_PORTAL_PAGES_OFFSET', 1000);

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

// Error codes removed in phpBB3 does we need them here
@define('GENERAL_MESSAGE', 200);
@define('GENERAL_ERROR', 202);
@define('CRITICAL_MESSAGE', 203);
@define('CRITICAL_ERROR', 204);

/**
 * Sick and tired of these variables getting lost...
 */
$html_entities_match = array('#&(?!(\#[0-9]+;))#', '#<#', '#>#', '#"#');
$html_entities_replace = array('&amp;', '&lt;', '&gt;', '&quot;');

$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
$unhtml_specialchars_replace = array('>', '<', '"', '&');
?>