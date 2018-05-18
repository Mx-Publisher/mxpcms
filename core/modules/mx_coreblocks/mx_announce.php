<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: mx_announce.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}
 
//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];

$announce_nbr_display		= $mx_block->get_parameters( 'announce_nbr_display' );
$announce_nbr_days			= $mx_block->get_parameters( 'announce_nbr_days' );
$announce_display_global	= $mx_block->get_parameters( 'announce_display_global' );
$announce_display			= $mx_block->get_parameters( 'announce_display' );
$announce_display_sticky	= $mx_block->get_parameters( 'announce_display_sticky' );
$announce_display_normal	= $mx_block->get_parameters( 'announce_display_normal' );
$announce_img_global		= $mx_block->get_parameters( 'announce_img_global' );
$announce_img				= $mx_block->get_parameters( 'announce_img' );
$announce_img_sticky		= $mx_block->get_parameters( 'announce_img_sticky' );
$announce_img_normal		= $mx_block->get_parameters( 'announce_img_normal' );
$announce_forum				= $mx_block->get_parameters( 'announce_forum' );

if ( empty($announce_nbr_display) ) $announce_nbr_display = 10;
if ( empty($announce_nbr_days) ) $announce_nbr_days = 365;

//
// Start initial var setup
//
if ( isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]) )
{
	$forum_id = ( isset($HTTP_GET_VARS[POST_FORUM_URL]) ) ? intval($HTTP_GET_VARS[POST_FORUM_URL]) : intval($HTTP_POST_VARS[POST_FORUM_URL]);
}
else if ( isset($HTTP_GET_VARS['forum']) )
{
	$forum_id = intval($HTTP_GET_VARS['forum']);
}
else
{
	$forum_id = 1; //'';
}

//
// Decide how to order the post display
//
if ( !empty($HTTP_POST_VARS['postorder']) || !empty($HTTP_GET_VARS['postorder']) )
{
	$post_order = ( !empty($HTTP_POST_VARS['postorder']) ) ? $HTTP_POST_VARS['postorder'] : $HTTP_GET_VARS['postorder'];
}

$post_time_order = ( $post_order == 'asc' ) ? 'ASC' : 'DESC';
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

//
// Grab all the basic data (all topics except announcements)
// for this forum
//

//
// Authorization SQL
//
$auth_data_sql = get_auth_forum();
if ( empty($announce_forum) )
{
	$announce_forum = $auth_data_sql;
}

$min_topic_time = time() - ( $announce_nbr_days * 86400 );

$topic_type = array();
if( $announce_display_global == 'TRUE' )
{
	$topic_type[] = POST_GLOBAL_ANNOUNCE;
}
if( $announce_display == 'TRUE' )
{
	$topic_type[] = POST_ANNOUNCE;
}
if( $announce_display_sticky == 'TRUE' )
{
	$topic_type[] = POST_STICKY;
}
if( $announce_display_normal == 'TRUE' )
{
	$topic_type[] = POST_NORMAL;
}
$topic_type = ( empty($topic_type) ? 0 : implode(', ', $topic_type) );

$sql = "SELECT t.*, u.username, u.user_id, u2.username as user2, u2.user_id as id2, p.*, pt.post_text, pt.post_subject, pt.bbcode_uid, p2.post_time AS last_post_time
	FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2, " . USERS_TABLE . " u2, " . POSTS_TEXT_TABLE . " pt
	WHERE p.topic_id = t.topic_id
		AND t.topic_type IN ( " . $topic_type . " )
		AND p.post_id = t.topic_first_post_id
	  	AND pt.post_id = p.post_id
		AND u.user_id = p.poster_id
		AND p.post_time >= $min_topic_time
		AND t.forum_id IN ( $auth_data_sql )
		AND t.forum_id IN ( $announce_forum )
		AND p2.post_id = t.topic_last_post_id
		AND u2.user_id = p2.poster_id 
	ORDER BY p.post_time $post_time_order
	LIMIT $start, " . $announce_nbr_display;

if ( !($result = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, 'Could not obtain announce information', '', __LINE__, __FILE__, $sql);
}

$postrow = array();

while( $row = $db->sql_fetchrow($result) )
{
	$postrow[] = $row;
}
$total_posts = count($postrow);

if ( $total_posts == 0 )
{
	$mx_block->show_title = false;
	$mx_block->show_block = false;
	return;
}

for( $i = 0; $i < $total_posts; $i++ )
{
	$poster_id = $postrow[$i]['user_id'];
	$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : $postrow[$i]['username'];
	$post_date = create_date($board_config['default_dateformat'], $postrow[$i]['post_time'], $board_config['board_timezone']);

	$title = $postrow[$i]['topic_title'];
	$bbcode_uid = $postrow[$i]['bbcode_uid'];
	$title = mx_decode($title, $bbcode_uid);

	$message = $postrow[$i]['post_text'];
	$bbcode_uid = $postrow[$i]['bbcode_uid'];
	$message = mx_decode($message, $bbcode_uid );

	$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $postrow[$i]['topic_title']) : $postrow[$i]['topic_title'];
	$replies = $postrow[$i]['topic_replies'];
	$topic_type = $postrow[$i]['topic_type'];

	if ( $topic_type == POST_ANNOUNCE )
	{
		$topic_type = $lang['Topic_Announcement'] . ' ';
	}
	else if ( $topic_type == POST_STICKY )
	{
		$topic_type = $lang['Topic_Sticky'] . ' ';
	}
	else
	{
		$topic_type = '';
	}

	if ( $postrow[$i]['topic_vote'] )
	{
		$topic_type .= $lang['Topic_Poll'] . ' ';
	}

	$poster_id = $postrow[$i]['user_id'];
	$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : $postrow[$i]['username'];

	$annoucement_image = $announce_img_normal;

	if ( $postrow[$i]['topic_status'] == TOPIC_MOVED )
	{
		$topic_type = $lang['Topic_Moved'] . ' ';
		$topic_id = $postrow[$i]['topic_moved_id'];

		$folder_image = $images['folder'];
		$folder_alt = $lang['Topics_Moved'];
		$newest_post_img = '';
	}
	else
	{
		if ( $postrow[$i]['topic_type'] == POST_GLOBAL_ANNOUNCE )
		{
			$folder = $images['folder_announce'];
			$folder_new = $images['folder_announce_new'];
			$annoucement_image = $announce_img_global;
		}
		else if ( $postrow[$i]['topic_type'] == POST_ANNOUNCE )
		{
			$folder = $images['folder_announce'];
			$folder_new = $images['folder_announce_new'];
			$annoucement_image = $announce_img;
		}
		else if ( $postrow[$i]['topic_type'] == POST_STICKY )
		{
			$folder = $images['folder_sticky'];
			$folder_new = $images['folder_sticky_new'];
			$annoucement_image = $announce_img_sticky;
		}
		else if ( $postrow[$i]['topic_status'] == TOPIC_LOCKED )
		{
			$folder = $images['folder_locked'];
			$folder_new = $images['folder_locked_new'];
		}
		else
		{
			if ( $replies >= $board_config['hot_threshold'] )
			{
				$folder = $images['folder_hot'];
				$folder_new = $images['folder_hot_new'];
			}
			else
			{
				$folder = $images['folder'];
				$folder_new = $images['folder_new'];
			}
		}

		$newest_post_img = '';
		if ( $userdata['session_logged_in'] )
		{
			if ( $postrow[$i]['last_post_time'] > $userdata['user_lastvisit'] )
			{
				if ( !empty($tracking_topics) || !empty($tracking_forums) || isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all']) )
				{
					$unread_topics = true;

					if ( !empty($tracking_topics[$topic_id]) )
					{
						if ( $tracking_topics[$topic_id] >= $postrow[$i]['last_post_time'] )
						{
							$unread_topics = false;
						}
					}

					if ( !empty($tracking_forums[$forum_id]) )
					{
						if ( $tracking_forums[$forum_id] >= $postrow[$i]['last_post_time'] )
						{
							$unread_topics = false;
						}
					}

					if ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all']) )
					{
						if ( $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all'] >= $postrow[$i]['last_post_time'] )
						{
							$unread_topics = false;
						}
					}

					if ( $unread_topics )
					{
						$folder_image = $folder_new;
						$folder_alt = $lang['New_posts'];

						$newest_post_img = '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
					}
					else
					{
						$folder_image = $folder;
						$folder_alt = ( $postrow[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

						$newest_post_img = '';
					}
				}
				else
				{
					$folder_image = $folder_new;
					$folder_alt = ( $postrow[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['New_posts'];

					$newest_post_img = '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
				}
			}
			else
			{
				$folder_image = $folder;
				$folder_alt = ( $postrow[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

				$newest_post_img = '';
			}
		}
		else
		{
			$folder_image = $folder;
			$folder_alt = ( $postrow[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

			$newest_post_img = '';
		}
	}

	$replies = $postrow[$i]['topic_replies'];
	$views = $postrow[$i]['topic_views'];
	$first_post_time = create_date($board_config['default_dateformat'], $postrow[$i]['topic_time'], $board_config['board_timezone']);
	$last_post_time = create_date($board_config['default_dateformat'], $postrow[$i]['last_post_time'], $board_config['board_timezone']);

	$last_post_author = ( $postrow[$i]['id2'] == ANONYMOUS ) ? ( ( $postrow[$i]['post_username2'] != '' ) ? $postrow[$i]['post_username2'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $postrow[$i]['id2']) . '">' . $postrow[$i]['user2'] . '</a>';
	$last_post_img = '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?" . POST_POST_URL . '=' . $postrow[$i]['topic_last_post_id']) . '#' . $postrow[$i]['topic_last_post_id'] . '"><img src="' . PHPBB_URL . $images['icon_latest_reply'] . '" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" border="0" /></a>';

	$last_post_url = mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?" . POST_POST_URL . '=' . $postrow[$i]['topic_last_post_id'] . '#' . $postrow[$i]['topic_last_post_id']);

	$template->assign_block_vars("postrow", array(
		'TITLE' => $title,
		'MESSAGE' => $message,
		'POST_DATE' => $post_date,
		'POST_SUBJECT' => $post_subject,
		'POSTER_NAME' => $poster,
		'POSTER_ID' => $poster_id,
		'TOPIC_ID' => $postrow[$i]['topic_id'],
		'SIGNATURE' => $user_sig,
		'FOLDER_IMG' => PHPBB_URL . $folder_image,
		'IMAGE' => TEMPLATE_ROOT_PATH . 'images/' . $annoucement_image,

		'U_TOPIC_URL' => mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $postrow[$i]['topic_id']),
		'U_LAST_POST_URL' => $last_post_url,
		'U_PROFILE_POSTER' => mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;u=$poster_id"),

		'REPLIES' => $replies,
		'VIEWS' => $views,
		'FIRST_POST_TIME' => $first_post_time,
		'LAST_POST_TIME' => $last_post_time,
		'LAST_POST_AUTHOR' => $last_post_author,
		'LAST_POST_IMG' => $last_post_img,

		'L_AUTHOR' => $lang['Author'],
		'L_POSTED' => $lang['Posted'],
		'L_REPLIES' => $lang['Replies'],
		'L_VIEWS' => $lang['Views'],
		'L_POSTS' => $lang['Posts'],
		'L_LASTPOST' => $lang['Last_Post'],

		'L_TOPIC_FOLDER_ALT' => $folder_alt
	));

}

$template->set_filenames(array(
	'body_announce' => 'mx_announce.tpl')
);

$template->assign_vars(array(
	'BLOCK_SIZE' => ( !empty( $block_size ) ? $block_size : '100%' ),
	'U_PHPBB_ROOT_PATH' => PHPBB_URL,
	'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH
));

$template->pparse('body_announce');

?>