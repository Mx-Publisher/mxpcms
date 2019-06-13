<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: admin_setting.php,v 1.3 2008/06/03 20:12:40 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PHPBB' ) || !defined( 'IN_ADMIN' ) )
{
	die( "Hacking attempt" );
}

class mx_news_setting extends mx_news_admin
{
	function main( $action )
	{
		global $db, $template, $lang, $phpEx, $mx_news_functions, $mx_news_cache, $portal_config;

		$submit = ( isset( $_POST['submit'] ) ) ? true : false;

		$sql = 'SELECT *
			FROM ' . MX_NEWS_CONFIG_TABLE;

		if ( !$result = $db->sql_query( $sql ) )
		{
			mx_message_die( CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql );
		}
		else
		{
			while ( $row = $db->sql_fetchrow( $result ) )
			{
				$config_name = $row['config_name'];
				$config_value = $row['config_value'];
				$default_config[$config_name] = $config_value;

				$new[$config_name] = ( isset( $_POST[$config_name] ) ) ? $_POST[$config_name] : $default_config[$config_name];

				if ( $submit )
				{
					$mx_news_functions->set_config( $config_name, $new[$config_name] );
				}
			}

			if ( $submit )
			{
				$mx_news_cache->unload();
				$message = $lang['Settings_changed'] . '<br /><br />' . sprintf( $lang['Click_return_news_config'], '<a href="' . mx_append_sid( "admin_mx_news.$phpEx?action=setting" ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_admin_index'], '<a href="' . mx_append_sid( "index.$phpEx?pane=right" ) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
		}

		$template->set_filenames( array( 'body' => 'admin/mx_news_admin_settings.tpl' ) );

		//
		// General Settings
		//
		$module_name = $new['module_name'];

		$enable_module_yes = ( $new['enable_module'] ) ? "checked=\"checked\"" : "";
		$enable_module_no = ( !$new['enable_module'] ) ? "checked=\"checked\"" : "";

		$wysiwyg_path = $new['wysiwyg_path'];

		//
		// Comments (default settings)
		//
		$use_comments_yes = ( $new['use_comments'] ) ? "checked=\"checked\"" : "";
		$use_comments_no = ( !$new['use_comments'] ) ? "checked=\"checked\"" : "";

		switch ($portal_config['portal_backend'])
		{
			case 'internal':
				$internal_comments_internal = "checked=\"checked\"";
				$internal_comments_phpbb = "";
				$comments_forum_id = 0;

				$del_topic_yes = "";
				$del_topic_no = "checked=\"checked\"";

				$autogenerate_comments_yes = "";
				$autogenerate_comments_no = "checked=\"checked\"";

				$template->assign_vars( array(
					'S_READONLY' => "disabled=\"disabled\"" )
				);
				break;

			default:
				$internal_comments_internal = ( $new['internal_comments'] ) ? "checked=\"checked\"" : "";
				$internal_comments_phpbb = ( !$new['internal_comments'] ) ? "checked=\"checked\"" : "";
				$comments_forum_id = $new['comments_forum_id'];

				$del_topic_yes = ( $new['del_topic'] ) ? "checked=\"checked\"" : "";
				$del_topic_no = ( !$new['del_topic'] ) ? "checked=\"checked\"" : "";

				$autogenerate_comments_yes = ( $new['autogenerate_comments'] ) ? "checked=\"checked\"" : "";
				$autogenerate_comments_no = ( !$new['autogenerate_comments'] ) ? "checked=\"checked\"" : "";
				$template->assign_vars( array(
					'S_READONLY' => "" )
				);
				break;
		}

		$allow_comment_wysiwyg_yes = ( $new['allow_comment_wysiwyg'] ) ? "checked=\"checked\"" : "";
		$allow_comment_wysiwyg_no = ( !$new['allow_comment_wysiwyg'] ) ? "checked=\"checked\"" : "";

		$allow_comment_html_yes = ( $new['allow_comment_html'] ) ? "checked=\"checked\"" : "";
		$allow_comment_html_no = ( !$new['allow_comment_html'] ) ? "checked=\"checked\"" : "";

		$allowed_comment_html_tags = $new['allowed_comment_html_tags'];

		$allow_comment_bbcode_yes = ( $new['allow_comment_bbcode'] ) ? "checked=\"checked\"" : "";
		$allow_comment_bbcode_no = ( !$new['allow_comment_bbcode'] ) ? "checked=\"checked\"" : "";

		$allow_comment_smilies_yes = ( $new['allow_comment_smilies'] ) ? "checked=\"checked\"" : "";
		$allow_comment_smilies_no = ( !$new['allow_comment_smilies'] ) ? "checked=\"checked\"" : "";

		$allow_comment_links_yes = ( $new['allow_comment_links'] ) ? "checked=\"checked\"" : "";
		$allow_comment_links_no = ( !$new['allow_comment_links'] ) ? "checked=\"checked\"" : "";

		$allow_comment_images_yes = ( $new['allow_comment_images'] ) ? "checked=\"checked\"" : "";
		$allow_comment_images_no = ( !$new['allow_comment_images'] ) ? "checked=\"checked\"" : "";

		$no_comment_link_message = $new['no_comment_link_message'];
		$no_comment_image_message = $new['no_comment_image_message'];

		$max_comment_chars = $new['max_comment_chars'];
		$max_comment_subject_chars = $new['max_comment_subject_chars'];

		$format_comment_truncate_links_yes = ( $new['formatting_comment_truncate_links'] ) ? "checked=\"checked\"" : "";
		$format_comment_truncate_links_no = ( !$new['formatting_comment_truncate_links'] ) ? "checked=\"checked\"" : "";

		$format_comment_image_resize = $new['formatting_comment_image_resize'];

		$format_comment_wordwrap_yes = ( $new['formatting_comment_wordwrap'] ) ? "checked=\"checked\"" : "";
		$format_comment_wordwrap_no = ( !$new['formatting_comment_wordwrap'] ) ? "checked=\"checked\"" : "";

		$comments_pag = $new['comments_pagination'];

		//
		// Notifications
		//
		$notify_none = ( $new['notify'] == 0 ) ? "checked=\"checked\"" : "";
		$notify_pm = ( $new['notify'] == 1 ) ? "checked=\"checked\"" : "";
		$notify_email = ( $new['notify'] == 2 ) ? "checked=\"checked\"" : "";

		$notify_group_list = mx_get_groups($new['notify_group'], 'notify_group');

		$template->assign_vars( array(
			'S_SETTINGS_ACTION' => mx_append_sid( "admin_mx_news.$phpEx" ),

			'L_CONFIGURATION_TITLE' => $lang['Panel_config_title'],
			'L_CONFIGURATION_EXPLAIN' => $lang['Panel_config_explain'],

			'L_RESET' => $lang['Reset'],
			'L_SUBMIT' => $lang['Submit'],
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			'L_NONE' => $lang['Acc_None'],

			//
			// General
			//
			'L_GENERAL_TITLE' => $lang['General_title'],

			'L_MODULE_NAME' => $lang['Module_name'],
			'L_MODULE_NAME_EXPLAIN' => $lang['Module_name_explain'],
			'MODULE_NAME' => $module_name,

			'L_ENABLE_MODULE' => $lang['Enable_module'],
			'L_ENABLE_MODULE_EXPLAIN' => $lang['Enable_module_explain'],
			'S_ENABLE_MODULE_YES' => $enable_module_yes,
			'S_ENABLE_MODULE_NO' => $enable_module_no,

			'L_WYSIWYG_PATH' => $lang['Wysiwyg_path'],
			'L_WYSIWYG_PATH_EXPLAIN' => $lang['Wysiwyg_path_explain'],
			'WYSIWYG_PATH' => $wysiwyg_path,

			//
			// Comments
			//
			'L_COMMENTS_TITLE' => $lang['Comments_title'],
			'L_COMMENTS_TITLE_EXPLAIN' => $lang['Comments_title_explain'],

			'L_USE_COMMENTS' => $lang['Use_comments'],
			'L_USE_COMMENTS_EXPLAIN' => $lang['Use_comments_explain'],
			'S_USE_COMMENTS_YES' => $use_comments_yes,
			'S_USE_COMMENTS_NO' => $use_comments_no,

			'L_INTERNAL_COMMENTS' => $lang['Internal_comments'],
			'L_INTERNAL_COMMENTS_EXPLAIN' => $lang['Internal_comments_explain'],
			'S_INTERNAL_COMMENTS_INTERNAL' => $internal_comments_internal,
			'S_INTERNAL_COMMENTS_PHPBB' => $internal_comments_phpbb,
			'L_INTERNAL_COMMENTS_INTERNAL' => $lang['Internal_comments_internal'],
			'L_INTERNAL_COMMENTS_PHPBB' => $lang['Internal_comments_phpBB'],

			'L_FORUM_ID' => $lang['Forum_id'],
			'L_FORUM_ID_EXPLAIN' => $lang['Forum_id_explain'],
			'FORUM_LIST' => $portal_config['portal_backend'] != 'internal' ? $this->get_forums( $comments_forum_id, false, 'comments_forum_id' ) : 'not available',

			'L_AUTOGENERATE_COMMENTS' => $lang['Autogenerate_comments'],
			'L_AUTOGENERATE_COMMENTS_EXPLAIN' => $lang['Autogenerate_comments_explain'],
			'S_AUTOGENERATE_COMMENTS_YES' => $autogenerate_comments_yes,
			'S_AUTOGENERATE_COMMENTS_NO' => $autogenerate_comments_no,

			'L_ALLOW_COMMENT_WYSIWYG' => $lang['Allow_Wysiwyg'],
			'L_ALLOW_COMMENT_WYSIWYG_EXPLAIN' => $lang['Allow_Wysiwyg_explain'],
			'S_ALLOW_COMMENT_WYSIWYG_YES' => $allow_comment_wysiwyg_yes,
			'S_ALLOW_COMMENT_WYSIWYG_NO' => $allow_comment_wysiwyg_no,

			'L_ALLOW_COMMENT_HTML' => $lang['Allow_HTML'],
			'L_ALLOW_COMMENT_HTML_EXPLAIN' => $lang['Allow_html_explain'],
			'S_ALLOW_COMMENT_HTML_YES' => $allow_comment_html_yes,
			'S_ALLOW_COMMENT_HTML_NO' => $allow_comment_html_no,

			'L_ALLOW_COMMENT_BBCODE' => $lang['Allow_BBCode'],
			'L_ALLOW_COMMENT_BBCODE_EXPLAIN' => $lang['Allow_bbcode_explain'],
			'S_ALLOW_COMMENT_BBCODE_YES' => $allow_comment_bbcode_yes,
			'S_ALLOW_COMMENT_BBCODE_NO' => $allow_comment_bbcode_no,

			'L_ALLOW_COMMENT_SMILIES' => $lang['Allow_smilies'],
			'L_ALLOW_COMMENT_SMILIES_EXPLAIN' => $lang['Allow_smilies_explain'],
			'S_ALLOW_COMMENT_SMILIES_YES' => $allow_comment_smilies_yes,
			'S_ALLOW_COMMENT_SMILIES_NO' => $allow_comment_smilies_no,

			'L_ALLOWED_COMMENT_HTML_TAGS' => $lang['Allowed_tags'],
			'L_ALLOWED_COMMENT_HTML_TAGS_EXPLAIN' => $lang['Allowed_tags_explain'],
			'ALLOWED_COMMENT_HTML_TAGS' => $allowed_comment_html_tags,

			'L_ALLOW_COMMENT_IMAGES' => $lang['Allow_images'],
			'L_ALLOW_COMMENT_IMAGES_EXPLAIN' => $lang['Allow_images_explain'],
			'S_ALLOW_COMMENT_IMAGES_YES' => $allow_comment_images_yes,
			'S_ALLOW_COMMENT_IMAGES_NO' => $allow_comment_images_no,

			'L_ALLOW_COMMENT_LINKS' => $lang['Allow_links'],
			'L_ALLOW_COMMENT_LINKS_EXPLAIN' => $lang['Allow_links_explain'],
			'S_ALLOW_COMMENT_LINKS_YES' => $allow_comment_links_yes,
			'S_ALLOW_COMMENT_LINKS_NO' => $allow_comment_links_no,

			'L_COMMENT_LINKS_MESSAGE' => $lang['Allow_links_message'],
			'L_COMMENT_LINKS_MESSAGE_EXPLAIN' => $lang['Allow_links_message_explain'],
			'COMMENT_MESSAGE_LINK' => $no_comment_link_message,

			'L_COMMENT_IMAGES_MESSAGE' => $lang['Allow_images_message'],
			'L_COMMENT_IMAGES_MESSAGE_EXPLAIN' => $lang['Allow_images_message_explain'],
			'COMMENT_MESSAGE_IMAGE' => $no_comment_image_message,

			'L_COMMENT_MAX_SUBJECT_CHAR' => $lang['Max_subject_char'],
			'L_COMMENT_MAX_SUBJECT_CHAR_EXPLAIN' => $lang['Max_subject_char_explain'],
			'COMMENT_MAX_SUBJECT_CHAR' => $max_comment_subject_chars,

			'L_COMMENT_MAX_CHAR' => $lang['Max_char'],
			'L_COMMENT_MAX_CHAR_EXPLAIN' => $lang['Max_char_explain'],
			'COMMENT_MAX_CHAR' => $max_comment_chars,

			'L_COMMENT_FORMAT_WORDWRAP' => $lang['Format_wordwrap'],
			'L_COMMENT_FORMAT_WORDWRAP_EXPLAIN' => $lang['Format_wordwrap_explain'],
			'S_COMMENT_FORMAT_WORDWRAP_YES' => $format_comment_wordwrap_yes,
			'S_COMMENT_FORMAT_WORDWRAP_NO' => $format_comment_wordwrap_no,

			'L_COMMENT_FORMAT_IMAGE_RESIZE' => $lang['Format_image_resize'],
			'L_COMMENT_FORMAT_IMAGE_RESIZE_EXPLAIN' => $lang['Format_image_resize_explain'],
			'COMMENT_FORMAT_IMAGE_RESIZE' => $format_comment_image_resize,

			'L_COMMENT_FORMAT_TRUNCATE_LINKS' => $lang['Format_truncate_links'],
			'L_COMMENT_FORMAT_TRUNCATE_LINKS_EXPLAIN' => $lang['Format_truncate_links_explain'],
			'S_COMMENT_FORMAT_TRUNCATE_LINKS_YES' => $format_comment_truncate_links_yes,
			'S_COMMENT_FORMAT_TRUNCATE_LINKS_NO' => $format_comment_truncate_links_no,

			'L_COMMENTS_PAG' => $lang['Comments_pag'],
			'L_COMMENTS_PAG_EXPLAIN' => $lang['Comments_pag_explain'],
			'COMMENTS_PAG' => $comments_pag,

			'L_DEL_TOPIC' => $lang['Del_topic'],
			'L_DEL_TOPIC_EXPLAIN' => $lang['Del_topic_explain'],
			'S_DEL_TOPIC_YES' => $del_topic_yes,
			'S_DEL_TOPIC_NO' => $del_topic_no,

			//
			// Notifications
			//
			'L_NOTIFICATIONS_TITLE' => $lang['Notifications_title'],

			'L_NOTIFY' => $lang['Notify'],
			'L_NOTIFY_EXPLAIN' => $lang['Notify_explain'],
			'L_EMAIL' => $lang['Email'],
			'L_PM' => $lang['PM'],
			'S_NOTIFY_NONE' => $notify_none,
			'S_NOTIFY_EMAIL' => $notify_email,
			'S_NOTIFY_PM' => $notify_pm,

			'L_NOTIFY_GROUP' => $lang['Notify_group'],
			'L_NOTIFY_GROUP_EXPLAIN' => $lang['Notify_group_explain'],
			'NOTIFY_GROUP' => $notify_group_list,

		));

		$template->pparse( 'body' );
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $sel_id
	 * @param unknown_type $use_default_option
	 * @param unknown_type $select_name
	 * @return unknown
	 */
	function get_forums( $sel_id = 0, $use_default_option = false, $select_name = 'forum_id' )
	{
		global $db, $lang;

		$sql = "SELECT forum_id, forum_name
			FROM " . FORUMS_TABLE;

		if ( !$result = $db->sql_query( $sql ) )
		{
			mx_message_die( GENERAL_ERROR, "Couldn't get list of forums", "", __LINE__, __FILE__, $sql );
		}

		$forumlist = '<select name="'.$select_name.'">';

		if ( $sel_id == 0 )
		{
			$forumlist .= '<option value="0" selected >'.$lang['Select_topic_id'].'</option>';
		}

		if ( $use_default_option )
		{
			$status = $sel_id == "-1" ? "selected" : "";
			$forumlist .= '<option value="-1" '.$status.' >::'.$lang['Use_default'].'::</option>';
		}

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			if ( $sel_id == $row['forum_id'] )
			{
				$status = "selected";
			}
			else
			{
				$status = '';
			}
			$forumlist .= '<option value="' . $row['forum_id'] . '" ' . $status . '>' . $row['forum_name'] . '</option>';
		}

		$forumlist .= '</select>';

		return $forumlist;
	}
}
?>