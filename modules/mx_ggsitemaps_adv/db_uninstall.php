<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: db_uninstall.php,v 1.1 2008/06/23 20:20:08 jonohlsson Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/
$phpEx = substr(strrchr(__FILE__, '.'), 1);
if ( file_exists( 'viewtopic.' . $phpEx ) ) {
	define('IN_PHPBB', true);
	$mx_root_path_int = $phpbb_root_path = $lang_path = './';
} else {
	define('IN_PORTAL', true);
	$mx_root_path_int = './../../';
	$lang_path = './../modules/mx_ggsitemaps_adv/';
	if (file_exists( $mx_root_path_int . "mx_login.$phpEx" )) {
		define( 'MXBB27x', true );
	}
}

if ( !defined('IN_ADMIN') ) {
	include($mx_root_path_int . 'common.'.$phpEx);
	// Start session management
	if (defined('IN_PORTAL')) {
		if ( defined('MXBB27x') ) {
			$userdata = session_pagestart($user_ip, PAGE_INDEX);
			mx_init_userprefs($userdata);
		} else {
			$mx_user->init($user_ip, PAGE_INDEX);
		}
	} else {
		include($phpbb_root_path . 'extension.inc');
		$userdata = session_pagestart($user_ip, PAGE_INDEX);
		$mx_table_prefix = $table_prefix;
		init_userprefs($userdata);
	}
	if( !$userdata['session_logged_in'] )  {
   		die("Hacking attempt(3)");
	}

	if( $userdata['user_level'] != ADMIN ) {
   		die("Hacking attempt(4)");
	}
	// End session management
}
// Define lang file
if ( !file_exists($lang_path . 'language/lang_' . $board_config['default_lang'] . '/lang_ggs_admin.' . $phpEx)) {
	include_once($lang_path . 'language/lang_english/lang_ggs_admin.' . $phpEx);
} else {
	include_once($lang_path . 'language/lang_' . $board_config['default_lang'] . '/lang_ggs_admin.' . $phpEx);
}
// Define table names.
if (defined('IN_PORTAL')) {
	$table_prefix =  $mx_table_prefix;
}
define('GGSITEMAP_TABLE', $table_prefix.'ggs_config');
// phpBB Config synchro
$update_phpbb_config = array();
if ( isset($board_config['ggs_gzip']) ) {
	$update_phpbb_config[] = "DELETE FROM ".CONFIG_TABLE." WHERE config_name = 'ggs_gzip'";
}
if ( isset($board_config['ggs_gzip_ext']) ) {
	$update_phpbb_config[] = "DELETE FROM ".CONFIG_TABLE." WHERE config_name = 'ggs_gzip_ext'";
}
if ( isset($board_config['rss_gzip_ext']) ) {
	$update_phpbb_config[] = "DELETE FROM ".CONFIG_TABLE." WHERE config_name = 'rss_gzip_ext'";
}
if ( isset($board_config['ggs_exclude_forums']) ) {
	$update_phpbb_config[] = "DELETE FROM ".CONFIG_TABLE." WHERE config_name = 'ggs_exclude_forums'";
}
if ( isset($board_config['rss_exclude_forum']) ) {
	$update_phpbb_config[] = "DELETE FROM ".CONFIG_TABLE." WHERE config_name = 'rss_exclude_forum'";
}
if ( isset($board_config['rss_allow_auth']) ) {
	$update_phpbb_config[] = "DELETE FROM ".CONFIG_TABLE." WHERE config_name = 'rss_allow_auth'";
}

$message = $lang['Google_uninstall'];
$sql = array(
	"DROP TABLE IF EXISTS ".$mx_table_prefix."ggs_config",
	"DROP TABLE IF EXISTS ".$mx_table_prefix."ggsitemap_config",
	);

// phpBB Config synchro
if ( count($update_phpbb_config) ) {
	foreach ($update_phpbb_config as $sql_add) {
		$sql[] = $sql_add;
	}
}
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
echo "<tr><th class=\"thHead\">".$lang['Google_uninstal_info']."</th></tr>";
echo "<tr><td class=\"row1\"><span class=\"gen\">" . $message . "<br/><br/></span></td></tr>";
echo "</table><br />";
if (!defined('IN_PORTAL')) {
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? '' : $script_name . '/';
	$phpbb_url = $server_protocol . $server_name . $server_port . '/' . $script_name;
	$message = sprintf($lang['UnInstall_success_phpbb'], "<a href=\"" . append_sid("$phpbb_url") . "\">", "</a>");
	echo "<br/><table  cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\" width=\"100%\" >";
	echo "<tr><th class=\"thHead\" >".$lang['Google_uninstal_info']."</th></tr>";
	echo "<tr><td class=\"row1\" align=\"center\" ><span class=\"gen\"><br/>" . $message . "<br/><br/></span></td></tr>";
	echo "</table><br/>";
	include("{$phpbb_root_path}includes/page_tail.$phpEx");
}
?>
