<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: db_install.php,v 1.8 2008/07/05 22:22:04 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

define( 'IN_PORTAL', true );
if ( !defined( 'IN_ADMIN' ) )
{
	$mx_root_path = './../../';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include( $mx_root_path . 'common.' . $phpEx );
	// Start session management
	$mx_user->init($user_ip, PAGE_INDEX);

	if ( !$userdata['session_logged_in'] )
	{
		die( "Hacking attempt(1)" );
	}

	if ( $userdata['user_level'] != ADMIN )
	{
		die( "Hacking attempt(2)" );
	}
	// End session management
}

$mx_module_version = '1.0.3';
$mx_module_copy = 'Designed for MX-Publisher by [Jon Ohlsson] <a href="http://mxpcms.sourceforge.net/" target="_blank">The MX-Publisher Development Team</a>.';

// For compatibility with core 2.7.+
define( 'MXBB_27x', file_exists( $mx_root_path . 'mx_login.php' ) );

// If fresh install
if ( !$result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "simplenews_config" ) )
{
	$message = "<b>This is a fresh install!</b><br/><br/>";

	$tmp = $userdata['user_id'];
	$sql = array(
		"DROP TABLE IF EXISTS " . $mx_table_prefix . "simplenews_config ",

		"CREATE TABLE " . $mx_table_prefix . "simplenews_config (
			  config_name varchar(255) NOT NULL default '',
			  config_value varchar(255) NOT NULL default '',
			  PRIMARY KEY  (config_name)
		)",

		// --------------------------------------------------------
		// Table structure for table `phpbb_pa_comments`
		"CREATE TABLE " . $mx_table_prefix . "simplenews_comments (
			  comments_id int(10) NOT NULL auto_increment,
			  block_id int(10) NOT NULL default '0',
			  comments_text text NOT NULL,
			  comments_title text NOT NULL,
			  comments_time int(50) NOT NULL default '0',
			  comment_bbcode_uid varchar(10) default NULL,
			  poster_id mediumint(8) NOT NULL default '0',
			  PRIMARY KEY  (comments_id),
			  KEY comments_id (comments_id),
			  FULLTEXT KEY comment_bbcode_uid (comment_bbcode_uid)
		)",

		// General
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('enable_module', '1')",
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('module_name', 'News Manager')", // settings_dbname
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('wysiwyg_path', 'modules/mx_shared/')",

		// New --------------------
		// Comments
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('internal_comments', '1')", // NEW
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('formatting_comment_wordwrap', '1')", // formatting_comment_fixup
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('formatting_comment_image_resize', '300')", // NEW
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('formatting_comment_truncate_links', '1')", // NEW
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('max_comment_subject_chars', '50')", // NEW
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('max_comment_chars', '5000')",
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('allow_comment_wysiwyg', '0')", // allow_wysiwyg_comments & allow_wysiwyg
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('allow_comment_html', '1')",
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('allow_comment_bbcode', '1')",
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('allow_comment_smilies', '1')",
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('allow_comment_links', '1')",
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('allow_comment_images', '1')",
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('no_comment_image_message', '[No image please]')",
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('no_comment_link_message', '[No links please]')",
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('allowed_comment_html_tags', 'b,i,u,a')", // NEW
		//"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('del_topic', '1')", // NEW
		//"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('autogenerate_comments', '1')",	// NEW
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('comments_pagination', '5')",
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('comments_forum_id', '0')", // New

		// Notifications
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('notify', '0')", // pm_notify
		"INSERT INTO " . $mx_table_prefix . "simplenews_config VALUES ('notify_group', '0')",	// NEW
	);

	$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
				    SET module_version  = '" . $mx_module_version . "',
				      module_copy  = '" . $mx_module_copy . "'
				    WHERE module_id = '" . $mx_module_id . "'";

	$message .= mx_do_install_upgrade( $sql );
}
else
{
	// If already installed
	$message = "<b>Module is already installed...consider upgrading ;)</b><br/><br/>";
}

echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstalling Information - module specific db tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . $message . "</span></td></tr>";
echo "</table><br />";

?>