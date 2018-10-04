<?php
/**
*
* @package MX-Publisher Module - mx_phpbb3blocks
* @version $Id: mx_announce.php,v 1.3 2008/10/04 07:04:38 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

// ===================================================
// Include the constants file
// ===================================================
include_once($module_root_path . 'includes/phpbb3blocks_constants.' . $phpEx);
include_once($mx_root_path . 'includes/mx_functions_tools.' . $phpEx); 
$mx_text_formatting = new mx_text_formatting();

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];

$announce_nbr_display		= $mx_block->get_parameters('announce_nbr_display');
$announce_nbr_days			= $mx_block->get_parameters('announce_nbr_days');
$announce_display_global	= $mx_block->get_parameters('announce_display_global');
$announce_display			= $mx_block->get_parameters('announce_display');
$announce_display_sticky	= $mx_block->get_parameters('announce_display_sticky');
$announce_display_normal	= $mx_block->get_parameters('announce_display_normal');
$announce_img_global		= $mx_block->get_parameters('announce_img_global');
$announce_img				= $mx_block->get_parameters('announce_img');
$announce_img_sticky		= $mx_block->get_parameters('announce_img_sticky');
$announce_img_normal		= $mx_block->get_parameters('announce_img_normal');
$announce_forum				= $mx_block->get_parameters('announce_forum');
$announce_truncate			= $mx_block->get_parameters('announce_truncate');

if ( empty($announce_nbr_display) ) $announce_nbr_display = 10;
if ( empty($announce_nbr_days) ) $announce_nbr_days = 365;
if ( empty($announce_truncate) ) $announce_truncate = 16777215;

//
// Start initial var setup
//
if ($mx_request_vars->is_request(POST_FORUM_URL))
{
	$forum_id = $mx_request_vars->request(POST_FORUM_URL, MX_TYPE_INT);
}
else if ($mx_request_vars->is_get('forum') )
{
	$forum_id = $mx_request_vars->get('forum', MX_TYPE_INT);
}
else
{
	$forum_id = 1; //'';
}

//
// Decide how to order the post display
//
if ( !$mx_request_vars->is_empty_request('postorder') )
{
	$post_order = $mx_request_vars->request('postorder');
}

$post_time_order = ( $post_order == 'asc' ) ? 'ASC' : 'DESC';
$start = $mx_request_vars->get('start', MX_TYPE_INT, 0);

//
// Grab all the basic data (all topics except announcements)
// for this forum
//

//
// Authorization SQL
//
$phpbb_auth->acl($mx_user->data); // Do only once, in user_init // Move later
$auth_data_sql = $phpbb_auth->get_auth_forum();

if ( empty($announce_forum) )
{
	$announce_forum = $auth_data_sql;
}

$min_topic_time = time() - ( $announce_nbr_days * 86400 );

$topic_type = array();
if( $announce_display_global == 'TRUE' )
{
	$topic_type[] = POST_GLOBAL;
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
	FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2, " . USERS_TABLE . " u2, " . POSTS_TABLE . " pt
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
$db->sql_freeresult($result);

if ( $total_posts == 0 )
{
	$mx_block->show_title = false;
	$mx_block->show_block = false;
	return;
}

for( $i = 0; $i < $total_posts; $i++ )
{
	$poster_id = $postrow[$i]['user_id'];
	$poster = mx_get_username_string('username', $poster_id, $postrow[$i]['username'], $postrow[$i]['topic_first_poster_colour']);
	$post_date = $mx_user->format_date($postrow[$i]['post_time']);


	$title = $postrow[$i]['topic_title'];
	$bbcode_uid = $postrow[$i]['bbcode_uid'];
	$title = $mx_bbcode->decode($title, $bbcode_uid);

	$message = $postrow[$i]['post_text'];
	$bbcode_uid = $postrow[$i]['bbcode_uid'];
	
	$bbcode_bitfield = $postrow[$i]['bbcode_bitfield'];
	
	
	$message = $mx_bbcode->decode($message, $bbcode_uid, true, $bbcode_bitfield);
	$message = $mx_text_formatting->truncate_text($message, $announce_truncate, true); 

	
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
	$poster = mx_get_username_string('username', $poster_id, $postrow[$i]['username'], $postrow[$i]['topic_first_poster_colour']);
	$poster_color = mx_get_username_string('colour', $poster_id, $postrow[$i]['username'], $postrow[$i]['topic_first_poster_colour']);
	$poster_full = mx_get_username_string('full', $poster_id, $postrow[$i]['username'], $postrow[$i]['topic_first_poster_colour']);

	$annoucement_image = $announce_img_normal;

	if ( $postrow[$i]['topic_status'] == TOPIC_MOVED )
	{
		$topic_type = $lang['Topic_Moved'] . ' ';
		$topic_id = $postrow[$i]['topic_moved_id'];

		$folder_image = $images['mx_folder'];
		$folder_alt = $lang['Topics_Moved'];
		$newest_post_img = '';
	}
	else
	{
		if ( $postrow[$i]['topic_type'] == POST_GLOBAL )
		{
			$folder = $mx_user->img('global_read', 'POST_GLOBAL', false, '', 'src');
			$folder_new = $mx_user->img('global_unread', 'POST_GLOBAL', false, '', 'src');
			$annoucement_image = $announce_img_global;
		}
		else if ( $postrow[$i]['topic_type'] == POST_ANNOUNCE )
		{
			$folder = $mx_user->img('announce_read', 'POST_ANNOUNCEMENT', false, '', 'src');
			$folder_new = $mx_user->img('announce_unread', 'POST_ANNOUNCEMENT', false, '', 'src');
			$annoucement_image = $announce_img;
		}
		else if ( $postrow[$i]['topic_type'] == POST_STICKY )
		{
			$folder = $mx_user->img('sticky_read', 'POST_STICKY', false, '', 'src');
			$folder_new = $mx_user->img('sticky_unread', 'POST_STICKY', false, '', 'src');
			$annoucement_image = $announce_img_sticky;
		}
		else if ( $postrow[$i]['topic_status'] == TOPIC_LOCKED )
		{
			$folder = $mx_user->img('topic_read_locked', 'NEW_POSTS', false, '', 'src');
			$folder_new = $mx_user->img('topic_unread_locked', 'NEW_POSTS', false, '', 'src');
		}
		else
		{
			if ( $replies >= $board_config['hot_threshold'] )
			{
				$folder = $mx_user->img('topic_read_hot', 'NEW_POSTS_HOT', false, '', 'src');
				$folder_new = $mx_user->img('topic_unread_hot', 'NEW_POSTS_HOT', false, '', 'src');
			}
			else
			{
				$folder = $mx_user->img('topic_unread', 'NEW_POSTS', false, '', 'src');
				$folder_new = $mx_user->img('topic_read', 'NEW_POSTS', false, '', 'src');
			}
		}

		$newest_post_img = '';
		if ( $userdata['session_logged_in'] )
		{
			if ( $postrow[$i]['last_post_time'] > $userdata['user_lastvisit'] )
			{
				if ( !empty($tracking_topics) || !empty($tracking_forums) || isset($_COOKIE[$board_config['cookie_name'] . '_f_all']) )
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

					if ( isset($_COOKIE[$board_config['cookie_name'] . '_f_all']) )
					{
						if ( $_COOKIE[$board_config['cookie_name'] . '_f_all'] >= $postrow[$i]['last_post_time'] )
						{
							$unread_topics = false;
						}
					}

					if ( $unread_topics )
					{
						$folder_image = $folder_new;
						$folder_alt = $lang['New_posts'];

						$newest_post_img = '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $mx_user->img('icon_topic_newest', 'VIEW_LATEST_POST', false, '', 'src') . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
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

					$newest_post_img = '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $mx_user->img('icon_topic_newest', 'VIEW_LATEST_POST', false, '', 'src') . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
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

	$first_post_time = $mx_user->format_date($postrow[$i]['topic_time']);
	$last_post_time = $mx_user->format_date($postrow[$i]['last_post_time']);

	$last_poster = mx_get_username_string('username', $postrow[$i]['id2'], $postrow[$i]['user2'], $postrow[$i]['topic_last_poster_colour']);
	$last_poster_color = mx_get_username_string('colour', $postrow[$i]['id2'], $postrow[$i]['user2'], $postrow[$i]['topic_last_poster_colour']);
	$last_poster_full = mx_get_username_string('full', $postrow[$i]['id2'], $postrow[$i]['user2'], $postrow[$i]['topic_last_poster_colour']);

	//$last_poster_full = ( $postrow[$i]['id2'] == ANONYMOUS ) ? ( ( $postrow[$i]['post_username2'] != '' ) ? $postrow[$i]['post_username2'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $postrow[$i]['id2']) . '">' . $postrow[$i]['user2'] . '</a>';
	$last_post_img = '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?f=" . $postrow[$i]['forum_id'] . '&amp;' . POST_POST_URL . '=' . $postrow[$i]['topic_last_post_id']) . '#' . $postrow[$i]['topic_last_post_id'] . '"><img src="' . $mx_user->img('icon_topic_latest', 'VIEW_LATEST_POST', false, '', 'src') . '" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" border="0" /></a>';

	$last_post_url = mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?" . POST_POST_URL . '=' . $postrow[$i]['topic_last_post_id'] . '#' . $postrow[$i]['topic_last_post_id']);

	$template->assign_block_vars("postrow", array(
		'TITLE' => $title,
		'MESSAGE' => $message,
		'POST_DATE' => $post_date,
		'POST_SUBJECT' => $post_subject,
		'POSTER_NAME' => $poster,
		'POSTER_FULL' => $poster_full,
		'POSTER_ID' => $poster_id,
		'TOPIC_ID' => $postrow[$i]['topic_id'],
		'SIGNATURE' => $user_sig,
		'FOLDER_IMG' => $folder_image,
		'IMAGE' => ($current_module_images) ? $current_module_images . '/'  . $annoucement_image : $module_root_path . TEMPLATE_ROOT_PATH . 'images/' . $annoucement_image,

		'U_TOPIC_URL' => mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?f=" . $postrow[$i]['forum_id'] . '&amp;' . POST_TOPIC_URL . '=' . $postrow[$i]['topic_id']),
		'U_LAST_POST_URL' => $last_post_url,
		'U_PROFILE_POSTER' => mx_append_sid(PHPBB_URL . "memberlist.$phpEx?mode=viewprofile&amp;u=$poster_id"),

		'REPLIES' => $replies,
		'VIEWS' => $views,
		'FIRST_POST_TIME' => $first_post_time,
		'LAST_POST_TIME' => $last_post_time,
		'LAST_POST_AUTHOR' => $last_poster_full,
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
	'body_announce' => "mx_announce.$tplEx")
);

$template->assign_vars(array(
	'BLOCK_SIZE' => (!empty($block_size) ? $block_size : '100%'),
	'U_PHPBB_ROOT_PATH' => PHPBB_URL,
	'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH
));

$template->pparse('body_announce');

?>