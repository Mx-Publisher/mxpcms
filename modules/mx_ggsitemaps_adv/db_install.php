<?php
/**
*
* @package phpBB SEO GYM sitemaps
* @version $Id: db_install.php,v 1.4 2011/05/01 22:43:31 orynider Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/
$phpEx = substr(strrchr(__FILE__, '.'), 1);
if ( file_exists( 'viewtopic.' . $phpEx ) ) 
{
	define('IN_PHPBB', true);
	$phpbb_root_path = $mx_root_path_int = $lang_path = './';
} 
else 
{
	define('IN_PORTAL', true);
	$mx_root_path_int = './../../';
	$lang_path = './../modules/mx_ggsitemaps_adv/';
	if (file_exists( $mx_root_path_int . "mx_login.$phpEx" )) 
	{
		define( 'MXBB27x', true );
	}
}
if ( !defined('IN_ADMIN') ) 
{
	include($mx_root_path_int . 'common.'.$phpEx);
	// Start session management
	if (defined('IN_PORTAL')) 
	{
		if ( defined('MXBB27x') ) 
		{
			$userdata = session_pagestart($user_ip, PAGE_INDEX);
			mx_init_userprefs($userdata);
		} 
		else 
		{
			$mx_user->init($user_ip, PAGE_INDEX);
		}
	} 
	else 
	{
		include($phpbb_root_path . 'extension.inc');
		$userdata = session_pagestart($user_ip, PAGE_INDEX);
		$mx_table_prefix = $table_prefix;
		init_userprefs($userdata);
	}
	if( !$userdata['session_logged_in'] )  
	{
   		die("Hacking attempt(3)");
	}
	if( $userdata['user_level'] != ADMIN ) 
	{
   		die("Hacking attempt(4)");
	}
	// End session management
}
// Define lang file
if ( !file_exists($lang_path . 'language/lang_' . $board_config['default_lang'] . '/lang_ggs_admin.' . $phpEx)) 
{
	include_once($lang_path . 'language/lang_english/lang_ggs_admin.' . $phpEx);
} 
else 
{
	include_once($lang_path . 'language/lang_' . $board_config['default_lang'] . '/lang_ggs_admin.' . $phpEx);
}
$mx_module_version = '2.0.2';
//$mx_module_copy = 'mx Sitemaps by <a href="http://www.phpbb-seo.com/" target="_phpbbseo" title="Search Engine optimisation">phpBB SEO</a>';
$mx_module_copy = 'Original <i>mx Sitemaps</i> by [dcz] <a href="http://www.phpbb-seo.com/" target="_phpbbseo" title="Search Engine optimisation">phpBB SEO</a> :: Adapted for MX-Publisher by dcz & <a href="http://www.mx-publisher.com">The MXP Development Team</a>';


// Define table names.
if (defined('IN_PORTAL')) {
	$table_prefix =  $mx_table_prefix;
}
define('GGSITEMAP_TABLE', $table_prefix.'ggs_config');

// available char-set for utf-8 conversion
// The list is not exautive, more char-set actually handled
// Please visit ACP for more options
$rss_char_set = array(
	'iso-8859-1',
	'utf-8',
	'iso-8859-2',
	'iso-8859-4',
	'iso-8859-7',
	'iso-8859-9',
	'iso-8859-15',
	'windows-932',
	'windows-1250',
	'windows-1251',
	'windows-1254',
	'windows-1255',
	'windows-1256',
	'windows-1257',
	'windows-874',
	'tis-620',
	'x-sjis',
	'euc-kr',
	'big5',
	'gb2312',
);
$charset = 'iso-8859-1'; // Still the most used
$auto_charset = '';
if ( @extension_loaded('mbstring') ) {
	$auto_charset = trim(@mb_strtolower(@mb_internal_encoding()));
}
if ( !($auto_charset == '') && in_array($auto_charset, $rss_char_set) ) {
	$charset = $auto_charset;
}
// phpBB Config synchro
$update_phpbb_config = array();

switch (PORTAL_BACKEND)
{
	case 'internal':
	break;

	case 'phpbb2':
		if ( !isset($board_config['ggs_gzip']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('ggs_gzip', 'FALSE')";
		}
		if ( !isset($board_config['ggs_gzip_ext']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('ggs_gzip_ext', 'FALSE')";
		}
		if ( !isset($board_config['rss_gzip_ext']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('rss_gzip_ext', 'FALSE')";
		}
		if ( !isset($board_config['ggs_exclude_forums']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('ggs_exclude_forums', '')";
		}
		if ( !isset($board_config['rss_exclude_forum']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('rss_exclude_forum', '')";
		}
		if ( !isset($board_config['rss_allow_auth']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('rss_allow_auth', 'FALSE')";
		}
	break;

	case 'phpbb3':
		if ( !isset($board_config['ggs_gzip']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('ggs_gzip', 'FALSE', 0)";
		}
		if ( !isset($board_config['ggs_gzip_ext']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('ggs_gzip_ext', 'FALSE', 0)";
		}
		if ( !isset($board_config['rss_gzip_ext']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('rss_gzip_ext', 'FALSE', 0)";
		}
		if ( !isset($board_config['ggs_exclude_forums']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('ggs_exclude_forums', '', 0)";
		}
		if ( !isset($board_config['rss_exclude_forum']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('rss_exclude_forum', '', 0)";
		}
		if ( !isset($board_config['rss_allow_auth']) ) {
			$update_phpbb_config[] = "INSERT INTO ".CONFIG_TABLE." VALUES ('rss_allow_auth', 'FALSE', 0)";
		}
	break;
}

$message = $lang['Google_install'];
$rss_desc = str_replace("\'", "''", htmlspecialchars($board_config['site_desc']));
$rss_title = (defined('IN_PORTAL')) ? str_replace("\'", "''", htmlspecialchars($portal_config['portal_name'])) : str_replace("\'", "''", htmlspecialchars($board_config['sitename']));

$sql_pre = $sql_insert = array();

$sql_pre = array(
		"DROP TABLE IF EXISTS ".$mx_table_prefix."ggsitemap_config",
		//"DROP TABLE IF EXISTS ".$mx_table_prefix."ggs_config", // Reuse this table, if upgrading from old module
);

$result = $db->sql_query( "SELECT config_value from " . $mx_table_prefix . "ggs_config WHERE config_name = 'ggs_mod_rewrite'" );
if ( $db->sql_numrows( $result ) == 0 )
{
	$sql_pre[] = "CREATE TABLE ".$mx_table_prefix."ggs_config(
			config_name varchar(255) NOT NULL,
			config_value varchar(255) NOT NULL,
		PRIMARY KEY (config_name)
	)";

	$sql_insert = array(
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_mod_rewrite', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_zero_dupe', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_mod_rewrite_type', '0')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_showstats', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_gzip', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_gzip_level', '6')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_cached', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_auto_regen', 'TRUE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_gzip_ext', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_mod_since', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_force_cache_gzip', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_cache_max_age', '24')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_cache_dir', 'gs_cache/')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('google_cache_born', '0')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_cache_born', '0')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_cache_born', '0')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_xslt', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_sql_limit', '200')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_url_limit', '2500')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_sort', 'DESC')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_exclude_forums', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_announce_priority', '0.5')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_default_priority', '1.0')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_sticky_priority', '0.75')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_pagination', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_limitdown', '5')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_limitup', '5')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_mx_exclude', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_kb_mx_page', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_kb_exclude', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_cache_max_age', '12')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_limit_time', '60')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_auto_regen', 'TRUE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_charset_conv', 'auto')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_charset', '$charset')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_gzip_ext', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_xslt', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_force_xslt', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_lang', 'en')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_sitename', '$rss_title')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_site_desc', '$rss_desc')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_cinfo', '$rss_title')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_image', 'rss_mxp_big.gif')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_forum_image', 'rss_forum_big.gif')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_allow_auth', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_cache_auth', 'TRUE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_url_limit_long', '500')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_url_limit', '100')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_url_limit_short', '25')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_sql_limit', '100')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_url_limit_txt_long', '200')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_url_limit_txt', '50')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_url_limit_txt_short', '25')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_sql_limit_txt', '25')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_allow_short', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_allow_long', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_sumarize', '10')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_sumarize_method', 'sentences')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_exclude_forum', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_first', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_last', 'TRUE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_msg_txt', 'TRUE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_allow_bbcode', 'TRUE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_strip_bbcode', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_allow_links', 'TRUE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_allow_smilies', 'TRUE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_exclude_kbcat', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('rss_exclude_mx', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_limit', '500')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_sql_limit', '100')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_limit_time', '60')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_exclude', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_cache_max_age', '48')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_auto_regen', 'TRUE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_pagination', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_limitdown', '5')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_limitup', '5')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_notify', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_appid', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_notify_long', 'FALSE')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_exclude_kbcat', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('yahoo_exclude_mx', '')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_c_info', '(C) 2006 dcz - http://www.phpbb-seo.com/')",
		"INSERT INTO ".$mx_table_prefix."ggs_config VALUES ('ggs_ver', 'v1.3.1')",
	);
}

//
// Merge
//
$sql = array_merge($sql_pre, $sql_insert);

// phpBB Config synchro
if ( count($update_phpbb_config) )
{
	foreach ($update_phpbb_config as $sql_add)
	{
		$sql[] = $sql_add;
	}
}

if ( defined('IN_PORTAL') && !defined('MXBB27x') )
{
	$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
			SET module_version  = '" . $mx_module_version . "',
			module_copy  = '" . $mx_module_copy . "'
			WHERE module_id = '" . $mx_module_id . "'";
}

//die(var_export($sql));

$n = 0;
$error_num = 0;
$sql_num = 0;
$message .= '<b>' . $lang['Google_install_ok'] . '</b><br /><br />';
while($sql[$n]) {
	if(!$result = $db->sql_query($sql[$n])) {
		$message .= '<b><font color=#FF0000>' . $lang['Google_error'] .($n+1).' , '.$sql[$n].'<br />';
		$error_num++;
	} else {
		$message .='<b><font color=#0000fF>' . $lang['Google_sql_ok'] .($n+1).' , '.$sql[$n].'<br />';
		$sql_num++;
	}
	$n++;
}
$message .= '<br />' . sprintf($lang['install_report'], $sql_num, $error_num);
$message .= '<br/><br />' . $lang['Google_general'];
if (!defined('IN_PORTAL')) {
	include("{$phpbb_root_path}includes/page_header.$phpEx");
}
echo "<br /><br />";
echo "<table  cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\" width=\"100%\">";
echo "<tr><th class=\"thHead\" >".$lang['Google_instal_info']."</th></tr>";
echo "<tr><td class=\"row1\"  ><span class=\"gen\">" . $message . "<br/><br/></span></td></tr>";
echo "</table><br />";
if (!defined('IN_PORTAL')) {
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? '' : $script_name . '/';
	$phpbb_url = $server_protocol . $server_name . $server_port . '/' . $script_name;
	$message = sprintf($lang['Install_success_phpbb'], "<a href=\"" . append_sid("$phpbb_url") . "\">", "</a>");
	echo "<br/><table  cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\" width=\"100%\" >";
	echo "<tr><th class=\"thHead\" >".$lang['Google_instal_info']."</th></tr>";
	echo "<tr><td class=\"row1\" align=\"center\" ><span class=\"gen\"><br/>" . $message . "<br/><br/></span></td></tr>";
	echo "</table><br/>";
	include("{$phpbb_root_path}includes/page_tail.$phpEx");
}
?>
