<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: functions.php,v 1.8 2008/07/15 22:06:18 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

/**
 * mx_news_functions.
 *
 * This class is used for general mx_news handling
 *
 * @access public
 * @author Jon Ohlsson
 *
 */
class mx_news_functions
{
	/**
	 * This class is used for general mx_news handling
	 *
	 * @param unknown_type $config_name
	 * @param unknown_type $config_value
	 */
	function set_config( $config_name, $config_value )
	{
		global $mx_news_cache, $db, $mx_news_config;

		$sql = "UPDATE " . MX_NEWS_CONFIG_TABLE . " SET
			config_value = '" . str_replace( "\'", "''", $config_value ) . "'
			WHERE config_name = '$config_name'";
		if ( !$db->sql_query( $sql ) )
		{
			mx_message_die( GENERAL_ERROR, "Failed to update mx_news configuration for $config_name", "", __LINE__, __FILE__, $sql );
		}

		if ( !$db->sql_affectedrows() && !isset( $mx_news_config[$config_name] ) )
		{
			$sql = 'INSERT INTO ' . MX_NEWS_CONFIG_TABLE . " (config_name, config_value)
				VALUES ('$config_name', '" . str_replace( "\'", "''", $config_value ) . "')";

			if ( !$db->sql_query( $sql ) )
			{
				mx_message_die( GENERAL_ERROR, "Failed to update mx_news configuration for $config_name", "", __LINE__, __FILE__, $sql );
			}
		}

		$mx_news_config[$config_name] = $config_value;
		$mx_news_cache->put( 'config', $mx_news_config );
	}

	function mx_news_config()
	{
		global $db;

		$sql = "SELECT *
			FROM " . MX_NEWS_CONFIG_TABLE;

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt query mx_news configuration', '', __LINE__, __FILE__, $sql );
		}

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$mx_news_config[$row['config_name']] = trim( $row['config_value'] );
		}

		$db->sql_freeresult( $result );

		return ( $mx_news_config );
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $mode
	 * @param unknown_type $page_id
	 */
	/*
	function generate_smilies( $mode, $page_id )
	{
		global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
		global $user_ip, $session_length, $starttime;
		global $userdata, $mx_user;
		global $mx_root_path, $module_root_path, $is_block, $phpEx;

		$inline_columns = 4;
		$inline_rows = 5;
		$window_columns = 8;

		if ( $mode == 'window' )
		{
			if ( !MXBB_MODULE )
			{
				$userdata = session_pagestart( $user_ip, $page_id );
				init_userprefs( $userdata );
			}
			else
			{
				$mx_user->init($user_ip, PAGE_INDEX);
			}

			$gen_simple_header = true;

			$page_title = $lang['Review_topic'] . " - $topic_title";

			include( $mx_root_path . 'includes/page_header.' . $phpEx );

			$template->set_filenames( array( 'smiliesbody' => 'posting_smilies.tpl' ) );
		}

		$sql = "SELECT emoticon, code, smile_url
			FROM " . SMILIES_TABLE . "
			ORDER BY smilies_id";
		if ( $result = $db->sql_query( $sql ) )
		{
			$num_smilies = 0;
			$rowset = array();
			while ( $row = $db->sql_fetchrow( $result ) )
			{
				if ( empty( $rowset[$row['smile_url']] ) )
				{
					$rowset[$row['smile_url']]['code'] = str_replace( "'", "\\'", str_replace( '\\', '\\\\', $row['code'] ) );
					$rowset[$row['smile_url']]['emoticon'] = $row['emoticon'];
					$num_smilies++;
				}
			}

			if ( $num_smilies )
			{
				$smilies_count = ( $mode == 'inline' ) ? min( 19, $num_smilies ) : $num_smilies;
				$smilies_split_row = ( $mode == 'inline' ) ? $inline_columns - 1 : $window_columns - 1;

				$s_colspan = 0;
				$row = 0;
				$col = 0;

				while ( list( $smile_url, $data ) = @each( $rowset ) )
				{
					if ( !$col )
					{
						$template->assign_block_vars( 'smilies_row', array() );
					}

					$template->assign_block_vars( 'smilies_row.smilies_col', array(
						'SMILEY_CODE' => $data['code'],
						'SMILEY_IMG' => $phpbb_root_path . $board_config['smilies_path'] . '/' . $smile_url,
						'SMILEY_DESC' => $data['emoticon'] )
					);

					$s_colspan = max( $s_colspan, $col + 1 );

					if ( $col == $smilies_split_row )
					{
						if ( $mode == 'inline' && $row == $inline_rows - 1 )
						{
							break;
						}
						$col = 0;
						$row++;
					}
					else
					{
						$col++;
					}
				}

				if ( $mode == 'inline' && $num_smilies > $inline_rows * $inline_columns )
				{
					$template->assign_block_vars( 'switch_smilies_extra', array() );

					$template->assign_vars( array(
						'L_MORE_SMILIES' => $lang['More_emoticons'],
						'U_MORE_SMILIES' => mx_append_sid( $phpbb_root_path . "posting.$phpEx?mode=smilies" ) )
					);
				}

				$template->assign_vars( array(
					'L_EMOTICONS' => $lang['Emoticons'],
					'L_CLOSE_WINDOW' => $lang['Close_window'],
					'S_SMILIES_COLSPAN' => $s_colspan )
				);
			}
		}

		if ( $mode == 'window' )
		{
			$template->pparse( 'smiliesbody' );
			include( $mx_root_path . 'includes/page_tail.' . $phpEx );
		}
	}
	*/

	// since that I can't use the original function with new template system
	// I just copy it and chagne it

	function sql_query_limit( $query, $total, $offset = 0 )
	{
		global $db;

		$query .= ' LIMIT ' . ( ( !empty( $offset ) ) ? $offset . ', ' . $total : $total );
		return $db->sql_query( $query );
	}

	/**
	 * page header.
	 *
	 */
	function page_header()
	{
		global $lang, $mx_user, $images, $template;

		//overwrite some phpBB3 vars
		$images['mx_news_icon_minipost'] = $mx_user->img('icon_post_reply', 'REPLY_POST', false, '', 'src');		
		$images['mx_news_icon_edit'] = $mx_user->img('icon_post_edit', 'EDIT_POST', false, '', 'src');
		$images['mx_news_icon_delpost'] = $mx_user->img('icon_post_delete', 'DELETE_POST', false, '', 'src');
		
		$template->assign_vars( array(
			'L_NEWS_TITLE' => $lang['mx_news_title'],
			'L_NEWS_DISABLE' => $lang['mx_news_disable'],		
			'L_CLICK_HERE' => $lang['Read_full_link'],
			'L_AUTHOR' => $lang['Submiter'],
			'L_EDIT' => $lang['Comment_edit'],
			'L_DELETE' => $lang['Comment_delete'],
			'L_REPLY' => $lang['Comment_add'],
			
			'DELETE_IMG' => $images['mx_news_icon_delpost'],
			'EDIT_IMG' => $images['mx_news_icon_edit'],
			'REPLY_IMG' => $images['mx_news_icon_minipost'],

			// Buttons
			//'B_REPLY_IMG' => $mx_user->create_button('mx_news_icon_minipost', $lang['Comment_add'], $this->this_mxurl()),
			//'B_DELETE_IMG' => $mx_user->create_button('mx_news_icon_delpost', $lang['Comment_delete'], "javascript:delete_item('". mx_append_sid( $this->this_mxurl()) . "')"),
			//'B_EDIT_IMG' => $mx_user->create_button('mx_news_icon_edit', $lang['Comment_edit'], mx_append_sid($this->this_mxurl()))
		));
	}

	/**
	 * page footer.
	 *
	 */
	function page_footer()
	{
		global $mx_news_cache;
		$mx_news_cache->unload();
	}

	/**
	 * Since we must a have scalar identity, with both block_id and virtual_id be create a composite.
	 * The first 4 digits are the block_id, the rest are the virtual id
	 *
	 * @param unknown_type $block_id
	 */
	function generate_virtualId($block_id)
	{
		global $mx_request_vars;

		if ($mx_request_vars->is_request('virtual') && $mx_request_vars->request('virtual', MX_TYPE_INT, '0') > 0)
		{
			$key = -1000 - $block_id; // We support 8999 virtual blocks and unlimited virtual ids
			return $key . $mx_request_vars->request('virtual', MX_TYPE_INT, '0');
		}
		return $block_id;
	}
}

/**
 * mx_news_notification.
 *
 * This class extends general mx_notification class
 *
 * // MODE: MX_PM_MODE/MX_MAIL_MODE, $id: get all file/article data for this id
 * $mx_notification->init($mode, $id); // MODE: MX_PM_MODE/MX_MAIL_MODE
 *
 * // MODE: MX_PM_MODE/MX_MAIL_MODE, ACTION: MX_NEW_NOTIFICATION/MX_EDITED_NOTIFICATION/MX_APPROVED_NOTIFICATION/MX_UNAPPROVED_NOTIFICATION
 * $mx_notification->notify( $mode = MX_PM_MODE, $action = MX_NEW_NOTIFICATION, $to_id, $from_id, $subject, $message, $html_on, $bbcode_on, $smilies_on )
 *
 * @access public
 * @author Jon Ohlsson
 */
class mx_news_notification extends mx_notification
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $item_id
	 */
	function init( $item_id = 0, $allow_comment_wysiwyg = 0)
	{
		global $db, $lang, $module_root_path, $phpbb_root_path, $mx_root_path, $phpEx, $userdata, $mx_news;

			// =======================================================
			// item id is not set, give him/her a nice error message
			// =======================================================
			if (empty($item_id))
			{
				mx_message_die(GENERAL_ERROR, 'Bad Init pars');
			}

			unset($this->langs);

			//
			// Build up generic lang keys
			//
			$this->langs['item_not_exist'] = $lang['Link_not_exist'];
			$this->langs['module_title'] = $lang['mx_news_prefix'];

			$this->langs['notify_subject_new'] = $lang['mx_news_notify_subject_new'];
			$this->langs['notify_subject_edited'] = $lang['mx_news_notify_subject_edited'];
			$this->langs['notify_subject_approved'] = $lang['mx_news_notify_subject_approved'];
			$this->langs['notify_subject_unapproved'] = $lang['mx_news_notify_subject_unapproved'];
			$this->langs['notify_subject_deleted'] = $lang['mx_news_notify_subject_deleted'];

			$this->langs['notify_new_body'] = $lang['mx_news_notify_new_body'];
			$this->langs['notify_edited_body'] = $lang['mx_news_notify_edited_body'];
			$this->langs['notify_approved_body'] = $lang['mx_news_notify_approved_body'];
			$this->langs['notify_unapproved_body'] = $lang['mx_news_notify_unapproved_body'];
			$this->langs['notify_deleted_body'] = $lang['mx_news_notify_deleted_body'];

			$this->langs['item_title'] = $lang['Link'];
			$this->langs['author'] = $lang['Submiter'];
			$this->langs['item_description'] = $lang['Desc'];
			$this->langs['item_type'] = '';
			$this->langs['category'] = $lang['Sitecat'];
			$this->langs['read_full_item'] = $lang['Read_full_link'];
			$this->langs['edited_item_info'] = $lang['Edited_Link_info'];

			unset($this->data);

			//
			// File data
			//
			$this->data['item_id'] = $item_id;
			$this->data['item_title'] = $item_data['link_name'];
			$this->data['item_desc'] = $item_data['link_longdesc'];


			//
			// Category data
			//
			$this->data['item_category_id'] = $item_data['cat_id'];
			$this->data['item_category_name'] = $item_data['cat_name'];

			//
			// File author
			//
			$this->data['item_author_id'] = $item_data['user_id'];
			$this->data['item_author'] = ( $item_data['user_id'] != ANONYMOUS ) ? $item_data['username'] : $lang['Guest'];

			//
			// File editor
			//
			$this->data['item_editor_id'] = $userdata['user_id'];
			$this->data['item_editor'] = ( $userdata['user_id'] != '-1' ) ? $userdata['username'] : $lang['Guest'];

			$mx_root_path_tmp = $mx_root_path; // Stupid workaround, since phpbb posts need full paths.
			$mx_root_path = '';
			$this->temp_url = PORTAL_URL . $mx_news->this_mxurl("action=" . "main&link_id=" . $this->data['item_id'], false, true);
			$mx_root_path = $mx_root_path_tmp;

			//
			// Toggles
			//
			$this->allow_comment_wysiwyg = $allow_comment_wysiwyg;
	}
}
?>