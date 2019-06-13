<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: lang_ggs_admin.php,v 1.1 2008/06/23 20:22:41 jonohlsson Exp $
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

// ACP
$lang['ggs_conf_title'] = 'Google Yahoo MSN Sitemaps and RSS';
$lang['ggs_conf_explain'] = "On this page you can set many parameters for this module.<br/>";
$lang['ggs_menu'] = "Navigation";
// Gen settings
$lang['gen_settings'] = "General Settings";
$lang['gen_settings_explain'] = "These options concern all the lists build by this mod : Google Sitemaps, Yahoo urllist.txt, and RSS 2.0 feeds.<br/> Each type of list also has it's own specific options: see below.";

$lang['gen_mod_rewrite'] = "URL Rewriting";
$lang['gen_mod_rewrite_explain'] = "This activates URL rewriting for all the lists. The Google sitemaps URLs will look like \"forum-ggsxx.xml\", the RSS feeds will look like \"forum-RSSxx.xml\".<br /><u>ATTENTION :</u> You MUST use an Apache server with the mod_rewrite module on or an IIS server running the isapi_rewrite module AND to properly set up the module's rewrite rules in your .htaccess (or httpd.ini with IIS ).<br /><u>NOTE :</u> The module will auto detect the phpBB SEO mod rewrite type ( <a href=\"http://www.phpbb-seo.com\">www.phpbb-seo.com</a> ) if installed.";

$lang['gen_mod_rewrite_type'] = "URL rewriting type";
$lang['gen_mod_rewrite_type_explain'] = "These options are overridden by the use of the phpBB SEO mod rewrite (auto detection ).<br/>Four levels of url rewriting can be set up here: None, Simple, Mixed and Advanced :<br/><ul><li><b>None</b> No URL rewriting;<br></li><li><b>Simple</b>Static URL rewriting for all links, no title injection;<br></li><li><b>Mixed</b> Forum and category titles are injected in URLs, but topic titles remain staticly rewritten;<br></li><li><b>Advanced</b> All titles are injected in URLs;</li></ul><br/>This method will be soon extended for more URL rewriting types.";

$lang['ggs_showstats'] = "Statistics";
$lang['ggs_showstats_explain'] = "Output or not the generation statistics in the source code.<br /><u>NOTE :</u> The duration is the time needed to build the page. This step is not repeated when outputing from cache.";

$lang['ggs_advanced'] = 'Advanced';
$lang['ggs_none'] = "None";
$lang['ggs_mixed'] = "Mixed";
$lang['ggs_simple'] = "Simple";
// Gen MXP
$lang['gen_mx_set'] = 'MXP specific';
$lang['gen_mx_set_explain'] = 'Here are some %sMXP%s specific settings.';

// Gen KB
$lang['gen_kb_set'] = 'KB google sitemaps';
$lang['gen_kb_set_explain'] = 'Here are some Knowledge Base (KB) specific settings.';


$lang['ggs_zero_dupe'] = "Check Duplicates";
$lang['ggs_zero_dupe_explain'] = "The module will check if the requested URL actually matches the real one, and will http 301 redirect if needed.<br /><u>NOTE :</u> This check is (for now) only performed when pages are being cached, it will be of no effect when the page is called from the cache.";

$lang['ggs_gun_zip'] = "Gun-Zip";
$lang['ggs_gun_zip_explain'] = "Activate gun-zip compression which will substantially reduce the amount of data transfered and cached. As well, it's less work for the server to output a smaller file from cache, as they are transmitted as is.<br/> The module will auto detect Gun-zip handling and eventually uncompress the cache before output if needed.";
$lang['ggs_gun_zip_lvl'] = "Gun-Zip compression level";
$lang['ggs_gun_zip_lvl_explain'] = "Must be an integer between 0 and 9, 9 being the most compression.";
$lang['ggs_gz_avail'] = "<br/><u>NOTE :</u> Gun-zip compressions is activated in phpBB config. It is thus forced in the module.";
$lang['ggs_gz_notavail'] = "<br/><u>NOTE :</u> Gun-zip compressions is not activated in phpBB config. You can select both otpions for the module.";
$lang['ggs_cache'] = "Cache";
$lang['ggs_cache_explain'] = "Activate cache for all of the lists. Pages will be cached in a specified folder, requiring CHMOD 0666 or 0777.";
$lang['ggs_mod_since'] = "Mod Since";
$lang['ggs_mod_since_explain'] = "The module will check if the browser already has an up to date version of the page in it's cache, and to use it instead of resending the file.";
$lang['ggs_force_cache_gzip'] = "Force Cache compression";
$lang['ggs_force_cache_gzip_explain'] = "In the event that gun-zip is activated, and a user is browsing the module's page without support for gun-zip, the module can either uncompress the cached file before sending it to the browser or cache an uncompressed version of the page.";
$lang['ggs_cache_dir'] = "Cache Folder";
$lang['ggs_cache_dir_explain'] = "Cache folder name. The folder must be in mx_ggsitemaps_adv/. Ex: gs_cache/";
$lang['ggs_clr_cache'] = "Cache Management";
$lang['ggs_clr_cache_explain'] = "Here you may clear cached file by type or all at once.<br/>Select a type to only clear that specified type of cached files.";
$lang['ggs_clr_all'] = "All";
$lang['ggs_clr_ggs'] = "Google";
$lang['ggs_clr_rss'] = "RSS";
$lang['ggs_clr_yahoo'] = "Yahoo";
$lang['ggs_cache_cleared_ok'] = "Clear cache success in : ";
$lang['ggs_cache_cleared_not_ok'] = "An error occured while clearing the cache, please check the folder permissions (CHMOD 0666 or 0777).<br/>The folder currently set up for caching is: ";
$lang['ggs_file_cleared_ok'] = "File(s) erased: ";
$lang['ggs_cache_accessed_ok'] = "The caching folder was opened properly, but no files were deleted: ";
$lang['ggs_cache_status'] = "The cache folder configured is : <b>%s</b>";
$lang['ggs_cache_found'] = "The cache folder was succesfully found.";
$lang['ggs_cache_not_found'] = "The cache folder was not found.";
$lang['ggs_cache_writable'] = "The cache folder is writable.";
$lang['ggs_cache_unwritable'] = "The cache folder is unwritable. You need to CHMOD it to 0777.";

$lang['gen_sort_order'] = 'Sort Order';
$lang['gen_new_first'] = 'DESC';
$lang['gen_old_first'] = 'ASC';
$lang['gen_sort_order_explain'] = 'All outputed links are sorted in the same way topics are sorted by default in phpbb (last activity DESC). <br /> You can set this to DESC for example if you wish to make it easier for Google to again find links to archived or locked threads (eg inactive for a looong time).';

// Google sitemaps General settings
$lang['ggs_settings'] = 'Google Sitemaps';
$lang['ggs_settings_explain'] = "The Google sitemap system allows GoogleBot to find pages far away from the Home Page easier. This system generates a sitemap index pointing to the different sitemaps available.<br /> You must register your sitemapIndex @ %sGoogle%s if you want to access some interesting stats.<br/>You can as well submit it to <a href=\"https://siteexplorer.search.yahoo.com/mysites\">Yahoo</a>, and MSN using the <a href=\"http://www.sitemaps.org/faq.html#faq_after_submission\">United Sitemaps Proptocol</a><br/>In all case, the only URL to submit is your sitemapIndex one : sitemap.php (or sitemaps.xml with mod rewrite)<br/>Additionaly some XSLTransform can be used to allow the browser to build up a nice html page out of our XML source.";
$lang['ggs_settings_explain2'] = "You can proceed %sanonymous%s though";

$lang['ggs_xslt'] = "Styling";
$lang['ggs_xslt_explain'] = 'The Google sitemaps can be styled using <a href="http://www.w3schools.com/xsl/xsl_transformation.asp">XSL-Transform</a> Style Sheet styling. Just make sure the ggs_style/ folder is installed where sitemap.php is before you turn this ON.';
$lang['ggs_sql_limit'] = 'SQL cycle';
$lang['ggs_sql_limit_explain'] = 'Major queries are separated into several cycles in order not to overload the SQL server. This is the maximum number of topics to fetch within a single query';

$lang['ggs_default_limit'] = 'Url Limit';
$lang['ggs_default_limit_explain'] = 'Maximum number of urls output in each sitemap.<br /> This limit is checked in every SQL cycle, the actual number of urls is this limit +- 1 SQL cycle +- number of paginated topics (limited or not) in the last cycle.<br />Limited by default to 40,000 knowing Google will go up to 50,000 per sitemap.';
$lang['ggs_auto_regen'] = "Cache auto regen";
$lang['ggs_auto_regen_explain'] = "Allow for automated cache update for Google sitemaps.";
$lang['ggs_cache_max_age'] = "Cache duration";
$lang['ggs_cache_max_age_explain'] = "Maximum amount of hours a cached file will be used before it will be updated for Google sitemaps. The cache of a specific Google sitemap will be updated everytime someone will browse it after this duration was exeeded when auto regen is on. If not, the cache will only be updated upon demand in ACP.";
$lang['ggs_gzip_ext'] = "Gun-Zip suffix";
$lang['ggs_gzip_ext_explain'] = "You can here decide to use the .gz suffix in mod rewritten Google sitemaps URLs.<br/>sitemaps.xml.gz vs sitemaps.xml<br/>Both works when using Gunzip, it's mostly a cosmetic feature.";
// Google sitemaps Forum settings
$lang['ggs_forum_settings'] = 'Forum Specific';
$lang['ggs_forum_exclude'] = 'Forum Exclusions';
$lang['ggs_forum_exclude_explain'] = 'You can exclude some public forums from the Google Sitemaps Listing.<br />Enter the excludes forum IDs list, comma separated: e.g 1,5,8.<br /><u>Note :</u> If this field is left empty, all public forums will be listed.';

$lang['ggs_announce_priority'] = 'Announcement Priority';
$lang['ggs_announce_priority_explain'] = 'Announcement Priority (must be a number between 0.0 &amp; 1.0 inclusive)';
$lang['ggs_sticky_priority'] = 'Sticky Priority';
$lang['ggs_sticky_priority_explain'] = 'Sticky Priority (must be a number between 0.0 &amp; 1.0 inclusive)';
$lang['ggs_default_priority'] = 'Default Priority';
$lang['ggs_default_priority_explain'] = 'Priority for regular topics (must be a number between 0.0 &amp; 1.0 inclusive)';
$lang['ggs_pagination'] = "Pagination";
$lang['ggs_pagination_explain'] = "Output or not paginated links for topics and forums.";
$lang['ggs_pagination_limit1'] = "Pagination: Lower Limit";
$lang['ggs_pagination_limit_explain1'] = "If pagination is on, you can set limits.<br />Enter here how many paginated pages, from the begining, are to be output.<br /> Entering 0 prevents outputing first page links.";
$lang['ggs_pagination_limit2'] = "Pagination: Upper Limit";
$lang['ggs_pagination_limit_explain2'] = "Enter here how many paginated pages, starting from the last one, are to be output.<br /> Entering 0 prevents outputing the last page links.";

// Google sitemaps MXP settings
$lang['ggs_mx_exclude'] = "MXP Page Exclusions";
$lang['ggs_mx_exclude_explain'] = "You can exclude some public MXP Pages from the Google Sitemaps Listings.<br />Enter the excluded MXP Page IDs list, comma separated : e.g 32,5,8.<br /><u>Note :</u> If this field is left empty, all public Pages will be listed.";
$lang['ggs_mx_settings'] = "Google Sitemaps Specific";

// Google sitemaps KB settings
$lang['ggs_kb_mx_page'] = "KB mx page Id";
$lang['ggs_kb_mx_page_explain'] = "This is only used if kb is installed on a %sMXP PORTAL%s . If running phpbb stand alone, do not bother with this, it's just used to know on which mx pages kb is installed.<br />CAUTION : If you don't set this to the right ID while using KB and MXP you could end up generating a 404!!";
$lang['ggs_kb_exclude'] = 'KB Category Exclusions';
$lang['ggs_kb_exclude_explain'] = 'You can exclude some public KB Categories from the Google Sitemaps Listings.<br />Enter the excluded Category IDs list, comma separated : e.g 1,5,8.<br /><u>Note:</u> If not filled, all public Categories will be listed.';
// RSS KB settings
$lang['rss_exclude_kb'] = 'KB Category Exclusions';
$lang['rss_exclude_kb_explain'] = 'You can exclude some public KB Categories from the RSS 2.0 Listings.<br />Enter the excluded Category IDs list, comma separated : e.g 1,5,8.<br /><u>Note :</u> If not filled, all public Categories will be listed.';
$lang['rss_kb_settings'] = "RSS specific";
//RSS MXP settings
$lang['rss_exclude_mx'] = 'MXP Pages Exclusions';
$lang['rss_exclude_mx_explain'] = 'You can exclude some public MXP Pages from the RSS 2.0 Listings.<br />Enter the excluded MXP Pages IDs list, comma separated : e.g 1,5,8.<br /><u>Note :</u> If not filled, all public Categories will be listed.';
$lang['rss_mx_settings'] = "Spécifique Flux RSS";

// RSS General settings
$lang['rss_settings'] = 'RSS Feed';
$lang['rss_settings_explain'] = "This module generates and caches several types of RSS 2.0 feeds.<br/> Additionaly XSLTransform is used to allow the browser to generate a nice html page out of your XML source.<br/> The different types of feeds are :<br/>- A general feed, listing forum topics (and eventually all other added links);<br/>- One feed listing the forum's topic (or each additional module content);<br/>- One feed per forum and one feed listing forum URLs;<br/>And one special feed, experimental stage, listing all available feeds at once.<br/>Each feed has three additional options: Long list, standard list and short list. The length of each of these three can be set to output or not the full post content.<br/>You can submit one of your main feeds to <a href=\"https://siteexplorer.search.yahoo.com/mysites\">Yahoo</a> as well, like rss.php (or rss.xml).<br/> The forum feeds (the one listing topics) is able to use the Yahoo! Notifications API to send notifications everytime a forum feed gets updated, see bellow.";
$lang['rss_xslt'] = "Styling";
$lang['rss_xslt_explain'] = 'The RSS feeds can be styled using <a href="http://www.w3schools.com/xsl/xsl_transformation.asp">XSL-Transform</a> Style Sheet styling. Just make sure the ggs_style/ folder is installed where rss.php is before you turn this ON.';
$lang['rss_force_xslt'] = "Force Styling";
$lang['rss_force_xslt_explain'] = "Isn't this a bit stupid, we need to trick browsers to allow xlst usage. We do it by adding some space chars at the beginning of the xml code.<br/>FF 2 and IE7 only look for the first 500 chars to decide it's rss or not and impose their private handling";
$lang['rss_sitename'] = "Site Name";
$lang['rss_sitename_explain'] = "The site name that will be displayed in the RSS feeds.";
$lang['rss_sitedesc'] = "Site Description";
$lang['rss_sitedesc_explain'] = "The site description that will be displayed in the RSS feeds.";
$lang['rss_cinfo'] = "Copyright";
$lang['rss_cinfo_explain'] = "The copyright that will be displayed in the RSS feeds.";
$lang['rss_lang'] = "Language";
$lang['rss_lang_explain'] = "The language code that will be displayed in the RSS feeds.";
$lang['rss_charset'] = "Charset";
$lang['rss_charset_explain'] = "You should here select the char-set you're using on your forum.<br/>windows char-set stands for cp char-set as well.<br/>This setting will be overridden by the phpbb_seo class settings when applicable (<a href=\"http://www.phpbb-seo.com/boards/phpbb-seo-toolkit/phpbb-seo-mod-rewrites-vt66.html\">phpBB SEO mod rewrite</a> installed).";
$lang['rss_charset_test_match'] = "<br/>If set on auto, the module will attempt to discover the used char-set according to your php settings, if any.<br/>The char-set currently set up for the mbstring extension is : <b>%s</b><br/>It is <u>still possible</u> that this setting is <i>not</i> the one actually used on your forum pages, if so, you'll have to manually set it up.<br/> In all case preferably set up a defined char-set, this will make sure it will always work despite the possible change in your server settings.";
$lang['rss_charset_conv'] = "Char-set conversion method";
$lang['rss_charset_conv_explain'] = "RSS feeds are all using UTF-8 as a final encoding to make sure our feeds will be viewable everywhere.<br/>Several conversion methods are available. You can here chose to force the use of a particular one, in case the default behaviour (auto) fails to chose the really working one.<br/>This should only append under a <u>rare occurrence</u>, selecting auto should work and be the best setting in most cases, only change this if the output is not well converted. Selecting phpbb3 will force the phpbb3 conversion method, being the one that should be able to handle the most cases, but not the lightest.";
$lang['rss_image'] = "Site Image";
$lang['rss_image_explain'] = "The site image that will be displayed in the RSS feeds. The image folder is ggs_style/. Ex : rss_site.gif.";
$lang['rss_forum_image'] = "Forum Image";
$lang['rss_forum_image_explain'] = "The forum image that will be displayed in the RSS feeds. The image folder is ggs_style/. Ex : rss_forum.gif.";
$lang['rss_cache_max_age'] = "Cache duration";
$lang['rss_cache_max_age_explain'] = "Maximum amount of hours a cached file will be used before it will be updated for the RSS feeds. The cache of a specific Google sitemap will be updated everytime someone views it after the duration was exeeded, when auto regen is on. If not, the cache will only be updated upon demand in the ACP.";
$lang['rss_auto_regen'] = "Cache auto regen";
$lang['rss_auto_regen_explain'] = "Allow for automated cache update for RSS feeds.";
$lang['rss_gzip_ext'] = "Gun-Zip suffix";
$lang['rss_gzip_ext_explain'] = "You can here decide to use the .gz suffix in mod rewritten RSS feeds URLs.<br/>rss.xml.gz vs rss.xml<br/>Both works when using Gunzip, it's mostly a cosmetic feature.";

$lang['Google_Config_updated'] = "Module's Configuration Updated Successfully";
$lang['Click_return_ggsitemap_config'] = "Click %sHere%s to return to the Module's Configuration";

// RSS Content Settings
$lang['rss_content_settings'] = "RSS content settings";
$lang['rss_msg_txt'] = "Message text";
$lang['rss_msg_txt_explain'] = "You may choose here to allow the message content to be fully or partially displayed in the RSS feeds. <br/><u>NOTE :</u> This option means more work for the server. Limits with content output should be set smaller than the one without it.";
$lang['rss_allow_bbcode'] = "Allow BBcodes";
$lang['rss_allow_bbcode_explain'] = "You may choose here to either parse and output or not the bbcodes the same way phpBB does or let them inactive.";
$lang['rss_strip_bbcode'] = "Strip BBcodes";
$lang['rss_strip_bbcode_explain'] = "You can here set up a list of bbcode to exclude from parsing.<br/>The format is simple : <br/><ul><li> <u>Comma separated list of bbcodes :</u> Delete bbcode tags, keep the content. <br/><u>Example :</u> <b>img,b,quote</b> <br/> In this example img, bold and quote bbcode won't be parsed, the bbcode tags themselves will be deleted and the content inside the bbcode tags kept.</li><li> <u>Comma separated list of bbcodes with colon option :</u> Delete bbcode tags and decide about their content. <br/><u>Example :</u> <b>img:1,b:0,quote,code:1</b> <br/> In this example, img bbcode and the img link will be deleted, bold won't be processed, but the bold-ed text will be kept, quote won't be parsed, but their content will be kept, code bbcode and their content will be deleted from the output.</ul>The filter will work even if bbcode if of. Handy to delete code tags content and img links from output for example.<br/>The filtering occurs before summarizing.<br/> The Magic parameter \"all\" (can be all:0 or all:1 to strip bbcode tags content as well) will take care of all at once.";
$lang['rss_allow_links'] = "Allow active links";
$lang['rss_allow_links_explain'] = "You may choose here to either activate or not links used in posts.<br/> If desactivated, links will be outputed as part of the content but won't be clickable.";
$lang['rss_allow_smilies'] = "Allow smilies";
$lang['rss_allow_smilies_explain'] = "You may choose here to either parse the smilies or not in content.";
$lang['rss_sumarize'] = "Digest";
$lang['rss_sumarize_explain'] = "You can limit the outputed messages content in feeds.<br/> The limit set the maximum amount of sentences, words or characters, according to the method selected below. Enter 0 to output all of it.";
$lang['rss_sumarize_method'] = "Digest method";
$lang['rss_sumarize_method_explain'] = "You can slect between three diffrent method to limit the outputed messages content in feeds.<br/> Sentences is the one most likely to keep a nice output with bbcode on, words limit will be more accurate, chars limit even more and won't breack words themselves.";
$lang['rss_digest_sentences'] = "Sentences";
$lang['rss_digest_words'] = "Words";
$lang['rss_digest_chars'] = "Characters";
$lang['rss_first'] = "First message";
$lang['rss_first_explain'] = "Display or not the first post's URL for all topics listed in the RSS feeds.<br/> By default, only the last post of each thread is listed. Displaying the first one as well means a bit more work for the server.";
$lang['rss_last'] = "Last message";
$lang['rss_last_explain'] = "Display or not the last message for all topics listed in the RSS feeds.<br/>  By default, only the last post of each thread is listed. This option is useful if you want to only list the first post URL in RSS feeds.";
$lang['rss_allow_short'] = "Allow Short Feeds";
$lang['rss_allow_short_explain'] = "Allow or not the use of Short RSS feeds.";
$lang['rss_allow_long'] = "Allow Long Feeds";
$lang['rss_allow_long_explain'] = "Allow or not the use of Long RSS feeds.";

$lang['rss_allow_auth'] = "Allow private feeds";
$lang['rss_allow_auth_explain'] = "The module is able to build personalized rss feeds according to the user's authorisations.<br/> If set to yes, users will be able to browse private forum feeds if they have enough permission to do so.";
$lang['rss_cache_auth'] = "Cache private feeds";
$lang['rss_cache_auth_explain'] = "You can disable cache for non public feeds when allowed.<br/> Caching private feeds will increase the number of file cached, it should not be a problem, but you can decide to only cache pubbilc feeds here.";
$lang['rss_exclude_forum'] = "Forum Exclusions";
$lang['rss_exclude_forum_explain'] = "You can exclude some public forums from the RSS Feeds.<br />Enter the excluded forum IDs list, comma separated : e.g 1,5,8.<br /><u>Note :</u> If not filled, all public forums will be listed.";

// RSS Limits Settings
$lang['rss_limit_settings'] = "Limits";
$lang['rss_limit_time'] = "Time Limits";
$lang['rss_limit_time_explain'] = "Limit in days, the maximum age of the posts when building RSS feeds. This only concerns the General feeds, not the forum specific ones. Can be very useful to lower the server load on busy boards. Enter 0 for no limit";
$lang['rss_url_limit_long'] = "Long Feeds limit";
$lang['rss_url_limit_long_explain'] = "Number of items displayed in a Long feed without content, if Allow Long Feeds is set to YES.";
$lang['rss_url_limit'] = "Default limit";
$lang['rss_url_limit_explain'] = "Number of items displayed by default on feeds with links only.";
$lang['rss_url_limit_short'] = "Short Feeds limit";
$lang['rss_url_limit_short_explain'] = "Number of items displayed on a Short feed without content, if Allow Short Feeds is set to YES.";
$lang['rss_sql_limit'] = "SQL cycle";
$lang['rss_sql_limit_explain'] = "Number of items queried at a time for the feeds without content.";
$lang['rss_url_limit_txt_long'] = "Long Feeds with content limit";
$lang['rss_url_limit_txt_long_explain'] = "Number of items displayed in a Long feed with content, if Allow Long Feeds and Messages text are set to YES.";
$lang['rss_url_limit_txt'] = "Default limit with content";
$lang['rss_url_limit_txt_explain'] = "Number of items displayed by default in feeds with content, if Messages text is set to YES.";
$lang['rss_url_limit_txt_short'] = "Short Feeds limit";
$lang['rss_url_limit_txt_short_explain'] = "Number of items displayed in a Short feed without content, if Allow Short Feeds and Messages text are set to YES.";
$lang['rss_sql_limit_txt'] = "content SQL cycle";
$lang['rss_sql_limit_txt_explain'] = "Number of items queried at a time for the feeds with content.";

// Yahoo Settings
$lang['yahoo_settings'] = "Yahoo! urllist.txt";
$lang['yahoo_settings_explain'] = 'The module generates and caches a Yahoo! urllist.txt file.<br/> It\'s a simple url list, one URL per line you can submmit at <a href="http://siteexplorer.search.yahoo.com/">Yahoo!</a>.<br/><u>NOTE :</u> Yahoo! accepts RSS feeds and the <a href="http://www.sitemaps.org/">sitemaps.org standard</a> (the Google xml format).';
$lang['yahoo_limit'] = "Limit";
$lang['yahoo_limit_explain'] = "You can here set the maximum amount of URLs displayed in the list.<br/><u>NOTE :</u> No need to go too high, you could end up overloading the server.";
$lang['yahoo_sql_limit'] = "SQL Cycle";
$lang['yahoo_sql_limit_explain'] = "SQL Queries are separated into several cycles.<br /> Default : 100 items per query.";
$lang['yahoo_limit_time'] = "Time Limit";
$lang['yahoo_limit_time_explain'] = "Limit in days, the maximum age of the posts taken into account when building urllist.txt lists. Can be very useful to lower the server load on large boards. Enter 0 for no limit";
$lang['yahoo_cache_max_age'] = "Cache duration";
$lang['yahoo_cache_max_age_explain'] = "Maximum amount of hours a cached file will be used before it will be updated for Yahoo! urllist.txt. The cache will be updated everytime someone will browse it after this duration was exeeded when auto regen is on. If not, the cache will only be updated upon demand in the ACP.";
$lang['yahoo_auto_regen'] = "Cache auto regen";
$lang['yahoo_auto_regen_explain'] = "Allow for automated cache update of the urllist.txt.";
$lang['yahoo_pagination'] = "Pagination";
$lang['yahoo_pagination_explain'] = "Display or not paginated links for topics and forums.";
$lang['yahoo_pagination_limit1'] = "Pagination: Lower Limit";
$lang['yahoo_pagination_limit_explain1'] = "If pagination is on, you can set limits.<br />Enter here how many paginated pages, from the begining, are to be outputed.<br /> Entering 0 prevents ouptuting first pages links.";
$lang['yahoo_pagination_limit2'] = "Pagination: Upper Limit";
$lang['yahoo_pagination_limit_explain2'] = "Enter here how many paginated pages, starting from the last one, are to be displayed.<br /> Entering 0 prevents displaying last pages links.";
$lang['yahoo_notify'] = "Yahoo! Notifications";
$lang['yahoo_notify_explain'] = "Activate or not the Yahoo! Notifications for RSS feeds.<br/> This does not concern the general feeds (RSS.xml).<br/>Each time a feed's cahce is updated, a notification will be sent to Yahoo!<br/><u>NOTE :</u>You MUST enter your Yahoo! AppID below for the notification to be sent.";
$lang['yahoo_notify_long'] = "Long Feeds";
$lang['yahoo_notify_long_explain'] = "If long feeds are allowed, you can decide here to always Notify with the long version of each feed.<br/><u>NOTE :</u>This is only possible with URL rewriting, since \"&\" are not allowed in the URLs in this case.";

$lang['yahoo_appid'] = "Yahoo! AppID ";
$lang['yahoo_appid_explain'] = "Enter here your Yahoo! AppID. if you don't not have one yet, please visit <a href=\"http://api.search.yahoo.com/webservices/register_application\">this page</a>.<br/><u>NOTE :</u>You will have to register for a Yahoo! account before you'll be able to obtain a Yahoo! AppID.";

// Yahoo forum
$lang['yahoo_exclude'] = "Forum Exclusions";
$lang['yahoo_exclude_explain'] = "You can exclude some public forums from the urllist.txt Listing.<br />Enter the excluded forum IDs list, comma separated : e.g 1,5,8.<br /><u>Note :</u> If not filled, all public forums will be listed.";
// Yahoo kb
$lang['yahoo_kb_settings'] = "Yahoo! urllist.txt specific";
$lang['yahoo_exclude_kb'] = 'KB Category Exclusions';
$lang['yahoo_exclude_kb_explain'] = 'You can exclude some public KB Categories from the urllist.txt Listings.<br />Enter the excluded Category IDs list, comma separated : e.g 1,5,8.<br /><u>Note :</u> If not filled, all public Categories will be listed.';
// Yahoo MXP settings
$lang['yahoo_exclude_mx'] = 'MXP Pages Exclusions';
$lang['yahoo_exclude_mx_explain'] = 'You can exclude some public MXP Pages from the urllist.txt Listings.<br />Enter the excluded MXP Page IDs list, comma separated : e.g 32,5,8.<br /><u>Note :</u> If not filled, all public Pages will be listed.';
$lang['yahoo_mx_settings'] = "Yahoo! urllist.txt specific";

// INSTALL
$lang['Google_install'] = "<b>Installation mx Google Sitemaps : Default Param.</b><br/><br/>";
$lang['Google_install_ok'] = "Building required dB tables";
$lang['Google_uninstall_ok'] = "Deleting required dB tables";
$lang['Google_error'] = "[Error or Already added]</font></b> line: ";
$lang['Google_sql_ok'] = "[Added/Updated]</font></b> line: ";
$lang['install_report'] = "Installation stats : %s sql(s) - %s error(s)";
$lang['Google_general'] = "If you get some Errors, Already Added or Updated messages, relax, this is normal when updating modules";
$lang['Google_uninstall'] = "<b>This list is a result of the SQL queries needed for mx Google Sitemap module</b><br /><br />";
$lang['Google_uninstall_ok'] = "Sql : Ok.";

$lang['Google_unerror'] = "[Error, Already deleted or updated]</font></b> line: ";
$lang['Google_unsql_ok'] = "[Deleted/Updated]</font></b> line: ";
$lang['Google_uninstal_info'] = "Module Uninstallation Information";
$lang['Google_instal_info'] = "Module Installation Information";
$lang['Install_success_phpbb'] = "The DB is now successfully updated.<br/><b>Do not forget to delete db_install.php</b><br/>Click %sHere%s to return to phpBB's Index";
$lang['UnInstall_success_phpbb'] = "The DB is now successfully updated.<br/><b>Do not forget to delete db_uninstall.php</b><br/>Click %sHere%s to return to phpBB's Index";

//
// That's all Folks!
// -------------------------------------------------
?>
