<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: functions_comment.php,v 1.7 2008/07/10 22:54:28 jonohlsson Exp $
* @copyright (c) 2002-2006 [Mohd Basri, PHP Arena, linkdb, Jon Ohlsson] MX-Publisher Project Team
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
class mx_news_comments extends mx_comments
{
	/**
	 * Init Comment vars.
	 *
	 * @param unknown_type $item_data
	 * @param unknown_type $comments_type
	 */
	function init( $item_data, $comments_type = 'internal' )
	{
		global $mx_news, $mx_news_config, $toplist_config, $db, $images, $mx_block, $board_config, $toplist_page_id;

		if ( !is_object($mx_news) || empty($mx_news_config) )
		{
			mx_message_die(GENERAL_ERROR, 'Bad global arguments');
		}

		$item_data['link_catid'] = $mx_news->modules[$mx_news->module_name]->block_id;
		$item_data['link_id'] = $mx_news->modules[$mx_news->module_name]->block_id;
		$item_data['topic_id'] = $mx_news->modules[$mx_news->module_name]->block_id;

		$this->comments_type = $comments_type == 'internal' ? 'internal' : 'phpbb';
		$this->cat_id = $item_data['link_catid'];
		$this->item_id = $item_data['link_id'];

		$this->topic_id = $item_data['topic_id'];

		$this->item_table = LINKS_TABLE;
		$this->comments_table = MX_NEWS_COMMENTS_TABLE;
		$this->table_field_id = 'block_id';

		//
		// Auth
		//
		$this->forum_id = $mx_news->modules[$mx_news->module_name]->comments[$this->block_id]['comments_forum_id'];

		$this->auth['auth_view'] = $mx_block->auth_view;
		$this->auth['auth_post'] = $mx_block->auth_edit;
		$this->auth['auth_edit'] = $mx_block->auth_edit;
		$this->auth['auth_delete'] = $mx_block->auth_mod;
		$this->auth['auth_mod'] = $mx_block->auth_mod;

		//
		// Pagination
		//
		$this->pagination_action = 'action=news';
		$this->pagination_target = 'block_id=';

		$this->pagination_num = empty($show_num_comments) ? $this->pagination_num : $show_num_comments;
		$this->u_pagination = $mx_news->this_mxurl( $this->pagination_action . "&" . $this->pagination_target . $this->item_id . '&modrewrite=no' );

		//
		// Configs
		//
		$this->allow_wysiwyg = $mx_news_config['allow_wysiwyg'];

		$this->allow_comment_wysiwyg = $mx_news_config['allow_comment_wysiwyg'];
		$this->allow_comment_bbcode = $mx_news_config['allow_comment_bbcode'];
		$this->allow_comment_html = $mx_news_config['allow_comment_html'];
	 	$this->allow_comment_smilies = $mx_news_config['allow_comment_smilies'];
	 	$this->allow_comment_links = $mx_news_config['allow_comment_links'];
	 	$this->allow_comment_images = $mx_news_config['allow_comment_images'];

	 	$this->no_comment_image_message = $mx_news_config['no_comment_image_message'];
	 	$this->no_comment_link_message = $mx_news_config['no_comment_link_message'];

		$this->max_comment_subject_chars = $mx_news_config['max_comment_subject_chars'];
		$this->max_comment_chars = $mx_news_config['max_comment_chars'];
		$this->split_key = !empty($toplist_config['split_key']) ? $toplist_config['split_key'] : '<!-- split -->';

		$this->formatting_comment_truncate_links = $mx_news_config['formatting_comment_truncate_links'];
		$this->formatting_comment_image_resize = $mx_news_config['formatting_comment_image_resize'];
		$this->formatting_comment_wordwrap = $mx_news_config['formatting_comment_wordwrap'];
		
		//overwrite some phpBB3 vars
		//$images['mx_news_icon_minipost'] = $mx_user->img('icon_post_reply', 'REPLY_POST', false, '', 'src');		
		//$images['mx_news_icon_edit'] = $mx_user->img('icon_post_edit', 'EDIT_POST', false, '', 'src');
		//$images['mx_news_icon_delpost'] = $mx_user->img('icon_post_delete', 'DELETE_POST', false, '', 'src');			

		//
		// Define comments images
		//
		$this->images = array(
			'icon_minipost' => $images['mx_news_icon_minipost'],
			'comment_post' => $images['mx_news_comment_post'],
			//'comment_post' => 'mx_news_comment_post',
			'icon_edit' => $images['mx_news_icon_edit'],
			//'icon_edit' => 'mx_news_icon_edit',
			'icon_delpost' => $images['mx_news_icon_delpost']);
			//'icon_delpost' => 'mx_news_icon_delpost');

		$this->u_post = $mx_news->this_mxurl( 'action=post_news&item_id=' . $this->item_id  . '&modrewrite=no');
		$this->u_edit = $mx_news->this_mxurl( 'action=post_news&item_id=' . $this->item_id  . '&modrewrite=no');
		$this->u_delete = $mx_news->this_mxurl( "action=post_news&delete=do&item_id=".$this->item_id  . '&modrewrite=no');
		$this->u_more = 'index.php?page=' . $toplist_page_id . "&action=news";
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $ranks
	 */
	function obtain_ranks( &$ranks )
	{
		global $db, $mx_news_cache;

		if (PORTAL_BACKEND != 'internal')
		{
			if ( $mx_news_cache->exists( 'ranks' ) )
			{
				$ranks = $mx_news_cache->get( 'ranks' );
			}
			else
			{
				$sql = "SELECT *
					FROM " . RANKS_TABLE . "
					ORDER BY rank_special, rank_min";

				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql );
				}

				$ranks = array();
				while ( $row = $db->sql_fetchrow( $result ) )
				{
					$ranks[] = $row;
				}

				$db->sql_freeresult( $result );
				$mx_news_cache->put( 'ranks', $ranks );
			}
		}
	}
}
?>