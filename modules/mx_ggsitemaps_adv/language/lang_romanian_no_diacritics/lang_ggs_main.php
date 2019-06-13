<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: lang_ggs_main.php,v 1.1 2008/06/23 20:22:45 jonohlsson Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/
/* Translation info : Feb 28, 2006
 Ver. 1.0.1
 copyright : (C) 2006 dcz
 This is the first version, please repport any errors.
*/ 
// 
// The format of this file is: 
// 
// ---> $lang["message"] = "text"; 
// 
// Specify your language character encoding... [optional]
// 
// setlocale(LC_ALL, "en");

// RSS Feeds
$lang['rss_short'] = ' - Short List';
$lang['rss_long'] = ' - Long List';
$lang['rss_msg'] = ' - Digest';
$lang['rss_item_stats'] = '<u>Stats :</u> ';
$lang['rss_more'] = 'More ...';
$lang['rss_chan_list'] = ' - Feeds list';
$lang['rss_answer'] = 'Post';
$lang['rss_answers'] = 'Replies';
$lang['rss_auth_some'] = "<b><u>Warning :</u></b> This feed is personalized according to <b>%s</b>'s authorizations.<br/> Some items may not be viewable when not logged in.";
$lang['rss_auth_this'] = "<b><u>Warning :</u></b> This feed is personalized according to <b>%s</b>'s authorizations.<br/> This channel will not be viewable when not logged in.";
$lang['rss_reply'] = " [Last post]";

// Yahoo Notify API - error handling
$lang['yahoo_error_503'] = "Call to Yahoo Web Services failed and returned an HTTP status of 503.<br/>That means: Service unavailable.<br/>An internal problem prevented Yahoo from returning data.";
$lang['yahoo_error_403'] = "Call to Yahoo Web Services failed and returned an HTTP status of 403.<br/>That means: Forbidden.<br/>The permission to access this resource was denied, or the rate limit was reached.";
$lang['yahoo_error_400'] = "Call to Yahoo Web Services failed and returned an HTTP status of 400.<br/>That means:  Bad request.<br/>The parameters passed to the service did not match as expected.<br/>The exact error is returned in the response.<br/> Request : %s<br/> Response : %s";
$lang['yahoo_error'] = "Your call to Yahoo Web Services returned an unexpected HTTP status of: %s<br/> Request : %s<br/> Response : %s";
$lang['yahoo_no_method'] = "The request to Yahoo notify failed with both curl and file_get_contents method.<br/>Please check your allow_url_fopen status in your php.ini file.<br/> Request : %s<br/> Response : %s";

//
// That's all Folks!
// -------------------------------------------------
?>
