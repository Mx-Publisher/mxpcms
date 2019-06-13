<?php
/**
*
* @package Constants
* @version $Id: mx_constants.php,v 1.36 2014/07/07 20:36:52 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
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

// Page numbers for session handling <- this values by MJ, Fully Modded phpBBFM , and OryNider, MXP CMS 
!defined('PAGE_INDEX') ? define('PAGE_INDEX', 0) : false;
!defined('PAGE_LOGIN') ? define('PAGE_LOGIN', -1) : false;

@define('PAGE_HOME', 0);

!defined('PAGE_SEARCH') ? define('PAGE_SEARCH', -2) : false;
!defined('PAGE_REGISTER') ? define('PAGE_REGISTER', -3) : false;
!defined('PAGE_PROFILE') ? define('PAGE_PROFILE', -4) : false;

@define('PAGE_UCP', -4);

!defined('PAGE_VIEWONLINE') ? define('PAGE_VIEWONLINE', -6) : false;
!defined('PAGE_VIEWMEMBERS') ? define('PAGE_VIEWMEMBERS', -7) : false;

@define('PAGE_VIEWFORUM', 0);
@define('PAGE_VIEWFORUMLIST', 0);
@define('PAGE_VIEWTOPIC', 0);
@define('PAGE_PROFILE_MAIN', -4);

@define('PAGE_VIEWPROFILE', -5);
@define('PAGE_MEMBERLIST', -7);

!defined('PAGE_FAQ') ? define('PAGE_FAQ', -8) : false;

@define('PAGE_RULES', -8);

!defined('PAGE_POSTING') ? define('PAGE_POSTING', -9) : false;
!defined('PAGE_PRIVMSGS') ? define('PAGE_PRIVMSGS', -10) : false;
!defined('PAGE_GROUPCP') ? define('PAGE_GROUPCP', -11) : false;

@define('PAGE_GROUP_CP', -11); 

!defined('PAGE_TOPIC_OFFSET') ? define('PAGE_TOPIC_OFFSET', 5000) : false;

define('PAGE_PRIVMSG', -10);

define('PAGE_SMILES', -12);
define('PAGE_TELLFRIEND', -13);
// 14 defined in linksdb_constants.php
// 15 defined in pafiledb_constants.php
define('PAGE_TOPIC_VIEW', -16);
define('PAGE_DIGEST', -17);
define('PAGE_STAFF', -18);
// 19 - 22 defined in music/music_constants.php
define('PAGE_ATTACHMENTS', -23);
define('PAGE_BOOKIES', -24);
define('PAGE_BOOKIE_ALLSTATS', -25);
define('PAGE_BOOKIE_YOURSTATS', -26);
define('PAGE_CALENDAR', -27);
define('PAGE_BANK', -28);
define('PAGE_SHOP', -29);
define('PAGE_STATISTICS', -30);
define('PAGE_CARD', -31);
define('PAGE_RATINGS', -32);
define('PAGE_PORTAL', -33);
define('PAGE_CHATROOM', -34);
define('PAGE_IMLIST', -35);
define('PAGE_TOPLIST', -36);
define('PAGE_LOTTERY', -37);
define('PAGE_ACTIVITY', -38);
define('PAGE_PLAYING_GAMES', -39);
define('PAGE_CHARTS', -40);
define('PAGE_RSS', -41);
define('PAGE_BANLIST', -43);
define('PAGE_TOPICS_STARTED', -44);
define('PAGE_MEETING', -45);
define('PAGE_FORUM_TOUR', -46);
define('PAGE_HELPDESK', -47);
define('PAGE_THREAD_KICKER', -48);
define('PAGE_SHOUTBOX', -49); 
define('PAGE_SHOUTBOX_MAX', -49);
// 50 - 53 defined in album/album_constants.php
// 53 - 54 defined in attachments/constants.php change them if have conflict with album constants
define('PAGE_AUCTIONS', -55);
define('PAGE_MEDALS', -56);
define('PAGE_JOBS', -57);
define('PAGE_AVATAR_TOPLIST', -58);
define('PAGE_AVATAR_LIST', -59);
define('PAGE_GUESTBOOK', -60);
define('PAGE_SITEMAP', -61);
define('PAGE_REDIRECT', -62);
define('PAGE_LEXICON', -63);
define('PAGE_DRAFTS', -64);
define('PAGE_ERRORS', -65);

// Portal modules page numbers for session handling
define('PAGE_LINKS', -14);
define('PAGE_LINKDB', -14); // If this id generates a conflict with other mods, change it ;);

define('PAGE_DL_DEFAULT', -15);
define('PAGE_DLOAD', -15);
define('PAGE_DOWNLOAD', -15); // If this id generates a conflict with other mods, change it ;);

define('PAGE_MUSIC_DEFAULT', -19);
define('PAGE_MUSIC', -19);	// for Session Handling
define('PAGE_MUSIC_PERSONAL', -20);
define('PAGE_MUSIC_PICTURE', -21);
define('PAGE_MUSIC_SEARCH', -22);

define('PAGE_KB_DEFAULT', -42);
define('PAGE_KB', -42); // If this id generates a conflict with other mods, change it ;);

define('PAGE_ALBUM_DEFAULT', -50);
define('PAGE_ALBUM', -50);	// for Session Handling
define('PAGE_ALBUM_PERSONAL', -51);
define('PAGE_IMAGES', -52);
define('PAGE_ALBUM_PICTURE', -52);
define('PAGE_IMAGE_THUMBNAIL', -52);
define('PAGE_IMAGE_THUMBNAIL_S', -52);
define('PAGE_ALBUM_SEARCH', -53);
define('PAGE_ALBUM_RSS', -54);

define('PAGE_NEWS', -77);
define('PAGE_NEWSSUITE', -77);

define('PAGE_MODULE_ADMIN', -78);
define('PAGE_PORTAL_ADMIN', -79);
define('PAGE_META_ADMIN', -80);
define('PAGE_ADS', -81);
define('PAGE_ADS_POST'  , -82);
define('PAGE_ADS_ADMIN'   , -83);

define('PAGE_WELCOME'   , -84);
define('PAGE_WELCOME_ADMIN', -85);

define('PAGE_WEATHER', -86);
define('PAGE_WEATHER_EDIT', -87);

define('PAGE_URL', -88);

//define('PAGE_CALENDAR', -91);

define('PAGE_RECENT', -92);
define('PAGE_REFERERS', -93);

define('PAGE_AJAX_CHAT', -94); // for Session Handling
define('PAGE_AJAX_SHOUTBOX', -95);

define('PAGE_ANNOUNCEMENT', -75);
define('PAGE_ANNOUNCEMENT_ADMIN'   , -76);

define('PAGE_CONTACT_US', -98);

// Portal page numbers for session handling
define('PAGE_FORUM', -70);
define('PAGE_MENU_NAV', -71);
define('PAGE_MENU_ADMIN', -72);
define('PAGE_POLL', -73);
define('PAGE_LAST_MSG', -74);
//define('PAGE_STATISTICS', -90);
define('PAGE_CREDITS', -99);
define('PAGE_TAGS', -100);

//define('PAGE_TOPIC_OFFSET', 5000);

// You can customize this page

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

/**
 * Sick and tired of these variables getting lost...
 */
$html_entities_match = array('#&(?!(\#[0-9]+;))#', '#<#', '#>#', '#"#');
$html_entities_replace = array('&amp;', '&lt;', '&gt;', '&quot;');

$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
$unhtml_specialchars_replace = array('>', '<', '"', '&');
?>