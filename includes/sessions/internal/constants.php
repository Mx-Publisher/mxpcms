<?php
/**
*
* @package Style
* @version $Id: constants.php,v 1.5 2014/05/09 07:52:03 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

// Debug Level
//@define('DEBUG', 1); // Debugging on
@define('DEBUG', 0); // Debugging off

// User Levels <- Do not change the values of USER or ADMIN
@define('DELETED', -1);
@define('ANONYMOUS', -1);

@define('USER', 0);
@define('ADMIN', 1);
@define('MOD', 2);

@define('USER_NORMAL', 0);
@define('USER_INACTIVE', 1);
@define('USER_IGNORE', 2);
@define('USER_FOUNDER', 3);

// User related
@define('USER_ACTIVATION_NONE', 0);
@define('USER_ACTIVATION_SELF', 1);
@define('USER_ACTIVATION_ADMIN', 2);

@define('USER_AVATAR_NONE', 0);
@define('USER_AVATAR_UPLOAD', 1);
@define('USER_AVATAR_REMOTE', 2);
@define('USER_AVATAR_GALLERY', 3);

// Group settings
@define('GROUP_OPEN', 0);
@define('GROUP_CLOSED', 1);
@define('GROUP_HIDDEN', 2);

// Forum state
@define('FORUM_UNLOCKED', 0);
@define('FORUM_LOCKED', 1);

// Topic status
@define('TOPIC_UNLOCKED', 0);
@define('TOPIC_LOCKED', 1);
@define('TOPIC_MOVED', 2);
@define('TOPIC_WATCH_NOTIFIED', 1);
@define('TOPIC_WATCH_UN_NOTIFIED', 0);

// Topic types
@define('POST_NORMAL', 0);
@define('POST_STICKY', 1);
@define('POST_ANNOUNCE', 2);
@define('POST_GLOBAL_ANNOUNCE', 3);

// SQL codes
@define('BEGIN_TRANSACTION', 1);
@define('END_TRANSACTION', 2);

// Error codes
@define('GENERAL_MESSAGE', 200);
@define('GENERAL_ERROR', 202);
@define('CRITICAL_MESSAGE', 203);
@define('CRITICAL_ERROR', 204);

// Private messaging
@define('PRIVMSGS_READ_MAIL', 0);
@define('PRIVMSGS_NEW_MAIL', 1);
@define('PRIVMSGS_SENT_MAIL', 2);
@define('PRIVMSGS_SAVED_IN_MAIL', 3);
@define('PRIVMSGS_SAVED_OUT_MAIL', 4);
@define('PRIVMSGS_UNREAD_MAIL', 5);

// URL PARAMETERS
@define('POST_TOPIC_URL', 't');
@define('POST_CAT_URL', 'c');
@define('POST_FORUM_URL', 'f');
@define('POST_USERS_URL', 'u');
@define('POST_POST_URL', 'p');
@define('POST_GROUPS_URL', 'g');

// Session parameters
@define('SESSION_METHOD_COOKIE', 100);
@define('SESSION_METHOD_GET', 101);

// Page numbers for session handling
@define('PAGE_INDEX', 0);
@define('PAGE_LOGIN', -1);
@define('PAGE_SEARCH', -2);
@define('PAGE_REGISTER', -3);
@define('PAGE_PROFILE', -4);
@define('PAGE_VIEWONLINE', -6);
@define('PAGE_VIEWMEMBERS', -7);
@define('PAGE_FAQ', -8);
@define('PAGE_POSTING', -9);
@define('PAGE_PRIVMSGS', -10);
@define('PAGE_GROUPCP', -11);
@define('PAGE_TOPIC_OFFSET', 5000);

// Auth settings
@define('AUTH_LIST_ALL', 0);
@define('AUTH_ALL', 0);

@define('AUTH_REG', 1);
@define('AUTH_ACL', 2);
@define('AUTH_MOD', 3);
@define('AUTH_ADMIN', 5);

@define('AUTH_VIEW', 1);
@define('AUTH_READ', 2);
@define('AUTH_POST', 3);
@define('AUTH_REPLY', 4);
@define('AUTH_EDIT', 5);
@define('AUTH_DELETE', 6);
@define('AUTH_ANNOUNCE', 7);
@define('AUTH_STICKY', 8);
@define('AUTH_POLLCREATE', 9);
@define('AUTH_VOTE', 10);
@define('AUTH_ATTACH', 11);

// Table names
//@define('CONFIRM_TABLE', $table_prefix.'confirm');
//@define('AUTH_ACCESS_TABLE', $table_prefix.'auth_access');
//@define('BANLIST_TABLE', $table_prefix.'banlist');
@define('BBCODES_TABLE', $mx_table_prefix . 'bbcodes');
//define('BOOKMARK_TABLE', $table_prefix . 'bookmarks');
@define('BOTS_TABLE', $mx_table_prefix . 'bots');
//@define('CATEGORIES_TABLE', $table_prefix.'categories');
//@define('CONFIG_TABLE', $table_prefix.'config');
//@define('CONFIRM_TABLE', $table_prefix . 'confirm');
//@define('DIGEST_SUBSCRIPTIONS_TABLE', $table_prefix . 'digest_subscriptions');
//@define('DIGEST_SUBSCRIBED_FORUMS_TABLE', $table_prefix . 'digest_subscribed_forums');
//@define('DISALLOW_TABLE', $table_prefix . 'disallow');
//@define('DRAFTS_TABLE', $table_prefix . 'drafts');
@define('FLAG_TABLE', $mx_table_prefix . 'flags');
//@define('FORUMS_TABLE', $table_prefix.'forums');
@define('GROUPS_TABLE', $mx_table_prefix.'groups');
//@define('POSTS_TABLE', $table_prefix.'posts');
//@define('POSTS_TEXT_TABLE', $table_prefix.'posts_text');
//@define('PRIVMSGS_TABLE', $table_prefix.'privmsgs');
//@define('PRIVMSGS_TEXT_TABLE', $table_prefix.'privmsgs_text');
//@define('PRIVMSGS_IGNORE_TABLE', $table_prefix.'privmsgs_ignore');
//@define('PRUNE_TABLE', $table_prefix.'forum_prune');
//@define('RANKS_TABLE', $table_prefix.'ranks');
//@define('SEARCH_TABLE', $table_prefix.'search_results');
//@define('SEARCH_WORD_TABLE', $table_prefix.'search_wordlist');
//@define('SEARCH_MATCH_TABLE', $table_prefix.'search_wordmatch');
@define('SESSIONS_TABLE', $mx_table_prefix.'sessions');
@define('SESSIONS_KEYS_TABLE', $mx_table_prefix.'sessions_keys');
@define('SMILIES_TABLE', $mx_table_prefix.'smilies');
//@define('THEMES_TABLE', $table_prefix.'themes');
//@define('THEMES_NAME_TABLE', $table_prefix.'themes_name');
//@define('TOPICS_TABLE', $table_prefix.'topics');
//@define('TOPICS_WATCH_TABLE', $table_prefix.'topics_watch');
@define('USER_GROUP_TABLE', $mx_table_prefix.'user_group');
@define('USERS_TABLE', $mx_table_prefix.'users');
@define('WORDS_TABLE', $mx_table_prefix.'words');
//@define('VOTE_DESC_TABLE', $table_prefix.'vote_desc');
//@define('VOTE_RESULTS_TABLE', $table_prefix.'vote_results');
//@define('VOTE_USERS_TABLE', $table_prefix.'vote_voters');
?>