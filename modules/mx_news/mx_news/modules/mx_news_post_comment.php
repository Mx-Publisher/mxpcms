<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: mx_news_post_comment.php,v 1.5 2008/06/03 20:12:40 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/**
 * Enter description here...
 *
 */
class mx_news_post_comment extends mx_news_public
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $action
	 */
	function main( $action )
	{
		global $template, $mx_news_functions, $lang, $board_config, $phpEx, $mx_news_config, $db, $images, $userdata;
		global $html_entities_match, $html_entities_replace, $unhtml_specialchars_match, $unhtml_specialchars_replace;
		global $mx_root_path, $module_root_path, $phpbb_root_path, $is_block, $mx_request_vars;
		global $mx_block, $theme;

		//
		// Go full page
		//
		$mx_block->full_page = true;

		//
		// Request vars
		//
		$cid = $mx_request_vars->request('cid', MX_TYPE_INT, 0);

		$item_id = $this->block_id;
		$virtual_id = $mx_request_vars->request('virtual', MX_TYPE_INT, 0);

		$delete = $mx_request_vars->request('delete', MX_TYPE_NO_TAGS, '');
		$submit = $mx_request_vars->is_request('submit');
		$preview = $mx_request_vars->is_request('preview');

		$item_data = array();
		$item_data['link_catid'] = $item_id;
		$item_data['link_id'] = $item_id;
		$item_data['topic_id'] = $item_id;

		if ( !( ( $mx_block->auth_view && $mx_block->auth_edit ) || $mx_block->auth_mod ) )
		{
			if ( !$userdata['session_logged_in'] )
			{
				// mx_redirect(mx_append_sid($mx_root_path . "login.$phpEx?redirect=".$this->this_mxurl("action=post_news&item_id=" . $item_id), true));
			}

			$message = $lang['Sorry_auth_comment'];
			mx_message_die( GENERAL_MESSAGE, $message );
		}

		if ( $mx_request_vars->is_get('cid') )
		{
			if ( $this->comments[$item_id]['internal_comments'] )
			{
				//
				// Query internal comment to edit
				//
				$sql = 'SELECT c.*, u.*
					FROM ' . MX_NEWS_COMMENTS_TABLE . ' AS c
						LEFT JOIN ' . USERS_TABLE . " AS u ON c.poster_id = u.user_id
					WHERE c.block_id = '" . $item_id . "'
					AND c.comments_id = '" . $mx_request_vars->request('cid', MX_TYPE_INT, '') . "'";

				$comment_arg_title = 'comments_title';
				$comment_arg_message = 'comments_text';
				$comment_arg_bbcode_uid = 'comment_bbcode_uid';
			}
			else
			{
				//
				// Query internal comment to edit
				// Note: cid = post_id
				//
				$sql = "SELECT u.username, u.user_id, u.user_posts, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_regdate, u.user_msnm, u.user_viewemail, u.user_rank, u.user_sig, u.user_sig_bbcode_uid, u.user_avatar, u.user_avatar_type, u.user_allowavatar, u.user_allowsmile, p.*,  pt.post_text, pt.post_subject, pt.bbcode_uid
					FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt
					WHERE pt.post_id = p.post_id
						AND u.user_id = p.poster_id
						AND p.post_id = '" . $mx_request_vars->request('cid', MX_TYPE_INT, '') . "'";

				$comment_arg_title = 'post_subject';
				$comment_arg_message = 'post_text';
				$comment_arg_bbcode_uid = 'bbcode_uid';
			}

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt select comments', '', __LINE__, __FILE__, $sql );
			}

			$comment_row = $db->sql_fetchrow( $result );
		}

		$comment_title = $preview || isset($_POST['subject']) ? $_POST['subject'] : $comment_row[$comment_arg_title];
		$comment_body = $preview || isset($_POST['message']) ? $_POST['message'] : $comment_row[$comment_arg_message];
		$bbcode_uid = $preview ? '' : $comment_row[$comment_arg_bbcode_uid];

		//
		// wysiwyg
		//
		if ( $mx_news_config['allow_comment_wysiwyg'] && file_exists( $mx_root_path . $mx_news_config['wysiwyg_path'] . 'tinymce/jscripts/tiny_mce/blank.htm' ))
		{
			//
			// Toggles
			//
			$allow_wysiwyg = true;
			$bbcode_on = false;
			$html_on = true;
			$smilies_on = false;
			$links_on = false;
			$images_on = false;

			$langcode = mx_get_langcode();

			if ($mx_block->auth_mod)
         	{
				$template->assign_block_vars( "tinyMCE_admin", array(
					'PATH' => $mx_root_path,
					'LANG' => !empty($langcode) ? $langcode : $_SERVER['HTTP_ACCEPT_LANGUAGE'],
					'TEMPLATE' => $mx_root_path . 'templates/'. $theme['template_name'] . '/' . $theme['head_stylesheet']
				));
         	}
         	else
         	{
				$template->assign_block_vars( "tinyMCE", array(
					'PATH' => $mx_root_path,
					'LANG' => !empty($langcode) ? $langcode : $_SERVER['HTTP_ACCEPT_LANGUAGE'],
					'TEMPLATE' => $mx_root_path . 'templates/'. $theme['template_name'] . '/' . $theme['head_stylesheet']
				));
         	}
		}
		else
		{
			//
			// Toggles
			//
			$allow_wysiwyg = false;
			$html_on = ( $mx_news_config['allow_comment_html'] ) ? true : 0;
			$bbcode_on = ( $mx_news_config['allow_comment_bbcode'] ) ? true : 0;
			$smilies_on = ( $mx_news_config['allow_comment_smilies'] ) ? true : 0;
			$links_on = ( $mx_news_config['allow_comment_links'] ) ? true : 0;
			$images_on = ( $mx_news_config['allow_comment_images'] ) ? true : 0;

			$board_config['allow_html_tags'] = $mx_news_config['allowed_comment_html_tags'];

			if ($smilies_on)
			{
				$mx_news_functions->generate_smilies( 'inline', PAGE_POSTING );
			}
		}

		//
		// Instantiate the mx_text and mx_text_formatting classes
		//
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on);

		$mx_text_formatting = new mx_text_formatting();

		//
		// Allow all html tags
		// Fix: Setting 'emtpy' enables all
		//
		$mx_text->allow_all_html_tags = $allow_wysiwyg;

		// =======================================================
		// Delete
		// =======================================================
		if ( $delete == 'do' )
		{
			if ( $mx_block->auth_edit || $mx_block->auth_mod ) // Maybe too nice...
			{
				if ( $this->comments[$this->block_id]['internal_comments'] )
				{
					$sql = 'DELETE FROM ' . MX_NEWS_COMMENTS_TABLE . "
					WHERE comments_id = $cid";

					if ( !( $db->sql_query( $sql ) ) )
					{
						mx_message_die( GENERAL_ERROR, 'Couldnt delete comment', '', __LINE__, __FILE__, $sql );
					}
				}
				else
				{
					include( $module_root_path . 'mx_news/includes/functions_comment.' . $phpEx );
					$mx_news_comments = new mx_news_comments();
					$mx_news_comments->init( $mx_news_info, 'phpbb' );
					$mx_news_comments->post('delete', $cid);
				}

				$this->_mx_news();
				$message = $lang['Comment_deleted'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( $this->this_mxurl( "mode=main&k=$item_id" ) ) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
			else
			{
				$message = sprintf( $lang['Sorry_auth_delete'], $this->auth_user[$cat_id]['auth_upload_type'] );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
		}

		// =======================================================
		// Submit
		// =======================================================
		if ( $submit )
		{
			$this->update_add_comment($link_data, $item_id, $cid, '', '', $html_on, $bbcode_on, $smilies_on, $allow_wysiwyg);

			//
			// Notification
			//
			$news_post_mode = $cid ? 'edit' : 'add';
			$this->update_add_comment_notify($this->block_id, $news_post_mode);

			$message = $lang['Comment_posted'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( $this->this_mxurl( 'mode=main&k=' . $item_id . '&virtual=' . $virtual_id) ) . '">', '</a>' );
			mx_message_die( GENERAL_MESSAGE, $message );
		}

		// =======================================================
		// Main
		// =======================================================

		$html_status = ( $html_on ) ? $lang['HTML_is_ON'] : $lang['HTML_is_OFF'];
		$bbcode_status = ( $bbcode_on ) ? $lang['BBCode_is_ON'] : $lang['BBCode_is_OFF'];
		$smilies_status = ( $smilies_on ) ? $lang['Smilies_are_ON'] : $lang['Smilies_are_OFF'];
		$links_status = ( $links_on ) ? $lang['Links_are_ON'] : $lang['Links_are_OFF'];
		$images_status = ( $images_on ) ? $lang['Images_are_ON'] : $lang['Images_are_OFF'];

		if ( $preview )
		{
			//
			// Encode for preview
			//
			$preview_title = $mx_text->encode_preview_simple($comment_title);
			$preview_text = $mx_text->encode_preview($comment_body);

			if (!$mx_news_config['allow_images'] || !$mx_news_config['allow_links'])
			{
				$preview_text = $mx_text_formatting->remove_images_links( $preview_text, $mx_news_config['allow_images'], $mx_news_config['no_image_message'], $mx_news_config['allow_links'], $mx_news_config['no_link_message'] );
			}

			$template->assign_block_vars( 'preview', array() );

			$template->assign_vars( array(
				'L_PREVIEW' => $lang['Preview'],
				'PREVIEW' => true,
				'SUBJECT' => $preview_title,
				'PRE_COMMENT' => $preview_text )
			);

			//
			// Decode for form editing
			//
			$comment_title = $mx_text->decode_simple($comment_title, true);
			$comment_body = $mx_text->decode($comment_body, '', true);
		}
		else
		{
			//
			// Decode for form editing
			//
			$comment_title = $mx_text->decode_simple($comment_title);
			$comment_body = $mx_text->decode($comment_body, $bbcode_uid);

		}

		if ( $mx_request_vars->is_request('cid') )
		{
			$hidden_form_fields = '<input type="hidden" name="action" value="post_news">
						<input type="hidden" name="virtual" value="' . $virtual_id . '">
						<input type="hidden" name="item_id" value="' . $item_id . '">
						<input type="hidden" name="cid" value="' . $mx_request_vars->request('cid', MX_TYPE_INT, '') . '">
						<input type="hidden" name="comment" value="post">';
		}
		else
		{
			//
			// New comment
			//
			$comment_title = '';
			$comment_body = '';

			$hidden_form_fields = '<input type="hidden" name="action" value="post_news">
						<input type="hidden" name="virtual" value="' . $virtual_id . '">
						<input type="hidden" name="item_id" value="' . $item_id . '">
						<input type="hidden" name="comment" value="post">';
		}

		//
		// Output the data to the template
		//
		$template->assign_vars( array(
			'HTML_STATUS' => $html_status,
			'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . PHPBB_URL . mx_append_sid("faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'),
			'SMILIES_STATUS' => $smilies_status,
			'LINKS_STATUS' => $links_status,
			'IMAGES_STATUS' => $images_status,
			'FILE_NAME' => $link_data['file_name'],
			'DOWNLOAD' => $mx_news_config['module_name'],
			'MESSAGE_LENGTH' => $mx_news_config['max_comment_chars'],

			'TITLE' => $comment_title,
			'COMMENT' => $comment_body,

			'L_COMMENT_ADD' => $lang['Comment_add'],
			'L_COMMENT' => $lang['Message_body'],
			'L_COMMENT_TITLE' => $lang['Subject'],
			'L_OPTIONS' => $lang['Options'],
			'L_COMMENT_EXPLAIN' => sprintf( $lang['Comment_explain'], $mx_news_config['max_comment_chars'] ),
			'L_PREVIEW' => $lang['Preview'],
			'L_SUBMIT' => $lang['Submit'],
			'L_DOWNLOAD' => $lang['Download'],

			'L_INDEX' => "<<",
			'L_CHECK_MSG_LENGTH' => $lang['Check_message_length'],
			'L_MSG_LENGTH_1' => $lang['Msg_length_1'],
			'L_MSG_LENGTH_2' => $lang['Msg_length_2'],
			'L_MSG_LENGTH_3' => $lang['Msg_length_3'],
			'L_MSG_LENGTH_4' => $lang['Msg_length_4'],
			'L_MSG_LENGTH_5' => $lang['Msg_length_5'],
			'L_MSG_LENGTH_6' => $lang['Msg_length_6'],

			'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
			'L_BBCODE_I_HELP' => $lang['bbcode_i_help'],
			'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
			'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'],
			'L_BBCODE_C_HELP' => $lang['bbcode_c_help'],
			'L_BBCODE_L_HELP' => $lang['bbcode_l_help'],
			'L_BBCODE_O_HELP' => $lang['bbcode_o_help'],
			'L_BBCODE_P_HELP' => $lang['bbcode_p_help'],
			'L_BBCODE_W_HELP' => $lang['bbcode_w_help'],
			'L_BBCODE_A_HELP' => $lang['bbcode_a_help'],
			'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
			'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
			'L_EMPTY_MESSAGE' => $lang['Empty_message'],

			'L_FONT_COLOR' => $lang['Font_color'],
			'L_COLOR_DEFAULT' => $lang['color_default'],
			'L_COLOR_DARK_RED' => $lang['color_dark_red'],
			'L_COLOR_RED' => $lang['color_red'],
			'L_COLOR_ORANGE' => $lang['color_orange'],
			'L_COLOR_BROWN' => $lang['color_brown'],
			'L_COLOR_YELLOW' => $lang['color_yellow'],
			'L_COLOR_GREEN' => $lang['color_green'],
			'L_COLOR_OLIVE' => $lang['color_olive'],
			'L_COLOR_CYAN' => $lang['color_cyan'],
			'L_COLOR_BLUE' => $lang['color_blue'],
			'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'],
			'L_COLOR_INDIGO' => $lang['color_indigo'],
			'L_COLOR_VIOLET' => $lang['color_violet'],
			'L_COLOR_WHITE' => $lang['color_white'],
			'L_COLOR_BLACK' => $lang['color_black'],

			'L_FONT_SIZE' => $lang['Font_size'],
			'L_FONT_TINY' => $lang['font_tiny'],
			'L_FONT_SMALL' => $lang['font_small'],
			'L_FONT_NORMAL' => $lang['font_normal'],
			'L_FONT_LARGE' => $lang['font_large'],
			'L_FONT_HUGE' => $lang['font_huge'],
			'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'],
			'L_STYLES_TIP' => $lang['Styles_tip'],

			'U_INDEX' => mx_append_sid( $mx_root_path . 'index.' . $phpEx ),
			'U_DOWNLOAD_HOME' => mx_append_sid( $this->this_mxurl() ),
			'U_FILE_NAME' => mx_append_sid( $this->this_mxurl( 'mode=main&item_id=' . $item_id ) ),
			'S_POST_ACTION' => mx_append_sid( $this->this_mxurl() ),
			'S_HIDDEN_FORM_FIELDS' => $hidden_form_fields )
		);

		if ( $bbcode_on )
		{
			$template->assign_block_vars( 'switch_bbcodes', array());
		}

		// ===================================================
		// assign var for navigation
		// ===================================================
		//$this->generate_navigation( $link_data['link_catid'] );

		$this->display( $lang['Links'], 'mx_news_comment_posting.tpl' );
	}
}
?>