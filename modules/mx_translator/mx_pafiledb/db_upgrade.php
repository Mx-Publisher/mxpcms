<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: db_upgrade.php,v 1.37 2011/12/07 18:08:01 orynider Exp $
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

$mx_module_version = '2.3.0-rc';
$mx_module_copy = 'Original phpBB <i>pafileDB</i> MOD by Mohd/Jon Ohlsson/Orynider</a> based on <a href="http://www.phparena.net/" target="_blank">PHP Arena, pafileDB</a> :: Adapted for MX-Publisher by [Jon Ohlsson] <a href="http://www.mx-publisher.com" target="_blank">The MX-Publisher Development Team</a>';

// For compatibility with core 2.7.+
define( 'MXBB_27x', file_exists( $mx_root_path . 'mx_login.php' ) );

if ( MXBB_27x )
{
	include_once($mx_root_path . 'modules/mx_pafiledb/pafiledb/includes/functions_mx.' . $phpEx );
}

$sql = array();
// Precheck
if ( $result = $db->sql_query( "SELECT config_name from " . $mx_table_prefix . "pa_config" ) )
{
	// Upgrade checks
	$upgrade_103 = 0;
	$upgrade_201 = 0;
	$upgrade_280 = 0; // mxp 2.8 branch ->
	$upgrade_225 = 0;
	$upgrade_226 = 0;
	$upgrade_230 = 0;
	
	$message = "<b>Upgrading!</b><br/><br/>";
	// validate before 1.0.3
	if ( !$result = $db->sql_query( "SELECT auth_edit_file from " . $mx_table_prefix . "pa_cat" ) )
	{
		$upgrade_103 = 1;
		$message .= "<b>Upgrading to v. 1.0.3...</b><br/><br/>";
	}
	else
	{
		$message .= "<b>Validating v. 1.0.3...ok</b><br/><br/>";
	}

	// validate before 2.0.1
	if ( !$result = $db->sql_query( "SELECT auth_approval from " . $mx_table_prefix . "pa_cat" ) )
	{
		$upgrade_201 = 1;
		$message .= "<b>Upgrading v. 2.0.1...ok</b><br/><br/>";
	}
	else
	{
		$message .= "<b>Validating v. 2.0.1...ok</b><br/><br/>";
	}

	// validate before 2.0.2
	$result = $db->sql_query( "SELECT config_value from " . $mx_table_prefix . "pa_config WHERE config_name = 'internal_comments'" );
	if ( $db->sql_numrows( $result ) == 0 )
	{
		$upgrade_202 = 1;
		$message .= "<b>Upgrading to v. 2.0.2...ok</b><br/><br/>";
	}
	else
	{
		$message .= "<b>Validating v. 2.0.2...ok</b><br/><br/>";
	}

	// validate before 2.8.0
	$result = $db->sql_query( "SELECT config_value from " . $mx_table_prefix . "pa_config WHERE config_name = 'comments_forum_id'" );
	if ( $db->sql_numrows( $result ) == 0 )
	{
		$upgrade_280 = 1;
		$message .= "<b>Upgrading to v. 2.8.0...ok</b><br/><br/>";
	}
	else
	{
		$message .= "<b>Validating v. 2.8.0...ok</b><br/><br/>";
	}

	// validate before 2.2.5
	if ( !$result = $db->sql_query( "SELECT file_disable from " . $mx_table_prefix . "pa_files" ) )
	{
		$upgrade_225 = 1;
		$message .= "<b>Upgrading v. 2.2.5...ok</b><br/><br/>";
	}
	else
	{
		$message .= "<b>Validating v. 2.2.5...ok</b><br/><br/>";
	}
	
	// validate before 2.2.6
	if ( !$result = $db->sql_query( "SELECT config_value from " . $mx_table_prefix . "pa_config WHERE config_name = 'resize_ss'" ))
	{
		$upgrade_226 = 1;
		$message .= "<b>Upgrading v. 2.2.6...ok</b><br/><br/>";
	}
	else
	{
		$message .= "<b>Validating v. 2.2.6...ok</b><br/><br/>";
	}	
	
	// validate before 2.3.0
	if ( !$result = $db->sql_query( "SELECT is_dynamic from " . $mx_table_prefix . "pa_config" ) )
	{
		$upgrade_230= 1;
		$message .= "<b>Upgrading v. 2.3.0...ok</b><br/><br/>";
	}
	else
	{
		$message .= "<b>Validating v. 2.3.0...ok</b><br/><br/>";
	}
	
	// ------------------------------------------------------------------------------------------------------
	if ( $upgrade_103 == 1 )
	{

		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD auth_edit_file tinyint(2) NOT NULL default '0' AFTER auth_view_file ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD auth_delete_file tinyint(2) NOT NULL default '0' AFTER auth_edit_file ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD cat_allow_ratings tinyint(2) NOT NULL default '-1' AFTER cat_allow_file ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD cat_allow_comments tinyint(2) NOT NULL default '-1' AFTER cat_allow_ratings ";

		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_auth ADD auth_edit_file tinyint(1) DEFAULT '0' NOT NULL AFTER auth_view_file ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_auth ADD auth_delete_file tinyint(1) DEFAULT '0' NOT NULL AFTER auth_edit_file ";

		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('pm_notify', '0')";
	}

	if ( $upgrade_201 == 1 )
	{

		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD auth_approval tinyint(2) NOT NULL default '0' AFTER auth_delete_comment ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_auth ADD auth_approval tinyint(1) DEFAULT '0' NOT NULL AFTER auth_delete_comment ";

		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat MODIFY auth_edit_file tinyint(2) NOT NULL default '0' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat MODIFY auth_delete_file tinyint(2) NOT NULL default '0' ";

		// Upgrade the config table to avoid duplicate entries
		/*
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_config MODIFY config_name VARCHAR(255) NOT NULL default '' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_config MODIFY config_value VARCHAR(255) NOT NULL default '' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_config DROP PRIMARY KEY, ADD PRIMARY KEY (config_name) ";
		*/

	}

	if ( $upgrade_202 == 1 )
	{
		// Upgrade the config table to avoid duplicate entries
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_config MODIFY config_name VARCHAR(255) NOT NULL default '' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_config MODIFY config_value VARCHAR(255) NOT NULL default '' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_config DROP PRIMARY KEY, ADD PRIMARY KEY (config_name) ";

		// Configs
		$sql[] = "UPDATE " . $mx_table_prefix . "pa_config" . " SET config_name = 'enable_module' WHERE config_name = 'settings_disable'";
		$sql[] = "UPDATE " . $mx_table_prefix . "pa_config" . " SET config_name = 'module_name' WHERE config_name = 'settings_dbname'";
		$sql[] = "UPDATE " . $mx_table_prefix . "pa_config" . " SET config_name = 'pagination' WHERE config_name = 'settings_file_page'";

		$sql[] = "DELETE FROM " . $mx_table_prefix . "pa_config" . " WHERE config_name = 'art_pagination'";
		$sql[] = "DELETE FROM " . $mx_table_prefix . "pa_config" . " WHERE config_name = 'comments_show'";
		$sql[] = "DELETE FROM " . $mx_table_prefix . "pa_config" . " WHERE config_name = 'pm_notify'";
		$sql[] = "DELETE FROM " . $mx_table_prefix . "pa_config" . " WHERE config_name = 'allow_wysiwyg_comments'";
		$sql[] = "DELETE FROM " . $mx_table_prefix . "pa_config" . " WHERE config_name = 'allow_wysiwyg'";
		$sql[] = "DELETE FROM " . $mx_table_prefix . "pa_config" . " WHERE config_name = 'formatting_fixup'";
		$sql[] = "DELETE FROM " . $mx_table_prefix . "pa_config" . " WHERE config_name = 'formatting_comment_fixup'";
		$sql[] = "DELETE FROM " . $mx_table_prefix . "pa_config" . " WHERE config_name = 'need_validation'";
		$sql[] = "DELETE FROM " . $mx_table_prefix . "pa_config" . " WHERE config_name = 'validator'";

		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('wysiwyg_path', 'modules/mx_shared/')";

		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('use_comments', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('internal_comments', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('formatting_comment_wordwrap', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('formatting_comment_image_resize', '300')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('formatting_comment_truncate_links', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('max_comment_subject_chars', '50')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('max_comment_chars', '5000')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('allow_comment_wysiwyg', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('allow_comment_html', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('allow_comment_bbcode', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('allow_comment_smilies', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('allow_comment_links', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('allow_comment_images', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('no_comment_image_message', '[No image please]')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('no_comment_link_message', '[No links please]')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('allowed_comment_html_tags', 'b,i,u,a')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('del_topic', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('autogenerate_comments', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('comments_pagination', '5')";

		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('use_ratings', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('votes_check_userid', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('votes_check_ip', '1')";

		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('notify', '0')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('notify_group', '0')";

		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('show_pretext', '1')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('pt_header', 'File Submission Instructions')";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('pt_body', 'Please check your references and include as much information as you can.')";


		// add fields to pa_category table
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD internal_comments tinyint(2) NOT NULL default '-1' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD autogenerate_comments tinyint(2) NOT NULL default '-1' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD comments_forum_id mediumint(8) NOT NULL default '-1' ";

		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD show_pretext tinyint(2) NOT NULL default '-1' ";

		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD notify tinyint(2) NOT NULL DEFAULT '-1' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD notify_group mediumint(8) NOT NULL DEFAULT '-1' ";

		// auth
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat ADD auth_approval_groups tinyint(2) NOT NULL default '0' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_auth ADD auth_approval_groups tinyint(1) NOT NULL default '0' ";

		// add fields to pa_files table
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_files ADD topic_id mediumint(8) unsigned NOT NULL default '0'";

	}

	if ( $upgrade_280 == 1 )
	{
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('comments_forum_id', '0')";

		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat MODIFY cat_allow_ratings tinyint(2) NOT NULL default '-1' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat MODIFY cat_allow_comments tinyint(2) NOT NULL default '-1' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat MODIFY notify_group mediumint(8) NOT NULL default '-1' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat MODIFY auth_delete_file tinyint(2) NOT NULL default '2' ";

		// Appearance
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('use_simple_navigation', '1') ";
		$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('cat_col', '2') ";

		// Auth
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat CHANGE auth_approval_groups auth_approval_edit tinyint(2) NOT NULL default '0' ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_auth CHANGE auth_approval_groups auth_approval_edit tinyint(2) NOT NULL default '0' ";
	}

	if ( $upgrade_225 == 1 )
	{
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_files ADD file_disable int(2) default '0' AFTER file_pin ";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_files ADD disable_msg text AFTER file_disable ";
	}
	
	if ( $upgrade_226 == 1 )
	{
			$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_cat CHANGE cat_last_file_name cat_last_file_name varchar(255) DEFAULT '' NOT NULL ";	
			$sql[] = "INSERT INTO " . $mx_table_prefix . "pa_config VALUES ('resize_ss', '0')"; //To do (for security reasons to filter uploaded files using php GD extension)
	}	
	else
	{
		$message .= "<b>Nothing to upgrade...</b><br/><br/>";
	}
	
	if ( $upgrade_230 == 1 )
	{
		// Upgrade the config table to avoid duplicate entries
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_config ADD `is_dynamic` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'";
		$sql[] = "ALTER TABLE " . $mx_table_prefix . "pa_config ADD KEY `is_dynamic` (`is_dynamic`)";
	}
	else
	{
		$message .= "<b>Nothing to upgrade...</b><br/><br/>";
	}
	
	if ( !MXBB_27x )
	{
		$sql[] = "UPDATE " . $mx_table_prefix . "module" . "
				    SET module_version  = '" . $mx_module_version . "',
				      module_copy  = '" . $mx_module_copy . "'
				    WHERE module_id = '" . $mx_module_id . "'";
	}

	$message .= mx_do_install_upgrade( $sql );
	$message .= "<b>...Now upgraded to v. $mx_module_version :-)</b><br/><br/>";

	//
	// Empty module cache
	//
	include_once( $mx_root_path . 'includes/mx_functions_tools.' . $phpEx );
	$module_cache = new module_cache($mx_root_path . 'modules/mx_pafiledb/pafiledb/');
	$module_cache->tidy();
	$module_cache->save();
}
else
{
	// If not installed
	$message = "<b>Module not installed...and thus cannot be upgraded ;)</b><br/><br/>";
}

echo "<br /><br />";
echo "<table  width=\"90%\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" class=\"forumline\">";
echo "<tr><th class=\"thHead\" align=\"center\">Module Installation/Upgrading/Uninstalling Information - module specific db tables</th></tr>";
echo "<tr><td class=\"row1\"  align=\"left\"><span class=\"gen\">" . $message . "</span></td></tr>";
echo "</table><br />";

?>