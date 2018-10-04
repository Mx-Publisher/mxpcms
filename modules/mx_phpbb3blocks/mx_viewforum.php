<?php
/**
*
* @package MX-Publisher Module - mx_phpbb3blocks
* @version $Id: mx_viewforum.php,v 1.6 2008/10/04 07:04:38 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

/**
* @ignore
*/
// ===================================================
// Include the constants file
// ===================================================
include_once( $module_root_path . 'includes/phpbb3blocks_constants.' . $phpEx );
include_once( $module_root_path . 'includes/mx_functions_display.' . $phpEx );

// ================================================================================
// The following code is based on includes/page_header.php (phpBB 2.0.14)
// ================================================================================

$l_timezone = explode('.', $board_config['board_timezone']);
$l_timezone = (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0) ? $lang[sprintf('%.1f', $board_config['board_timezone'])] : $lang[number_format($board_config['board_timezone'])];

// Start initial var setup
$forum_id 	= $mx_request_vars->request('f', MX_TYPE_NO_TAGS, '0');

$mark_read	= $mx_request_vars->request('mark', MX_TYPE_NO_TAGS, '');
$start		= $mx_request_vars->request('start', MX_TYPE_NO_TAGS, '0');

$sort_days	= $mx_request_vars->request('st', MX_TYPE_NO_TAGS, ((!empty($mx_user->data['user_topic_show_days'])) ? $mx_user->data['user_topic_show_days'] : 0));
$sort_key	= $mx_request_vars->request('sk', MX_TYPE_NO_TAGS, ((!empty($mx_user->data['user_topic_sortby_type'])) ? $mx_user->data['user_topic_sortby_type'] : 't'));
$sort_dir	= $mx_request_vars->request('sd', MX_TYPE_NO_TAGS, ((!empty($mx_user->data['user_topic_sortby_dir'])) ? $mx_user->data['user_topic_sortby_dir'] : 'd'));

// Check if the user has actually sent a forum ID with his/her request
// If not give them a nice error page.
if (!$forum_id)
{
	trigger_error('NO_FORUM');
}

$sql_from = FORUMS_TABLE . ' f';
$lastread_select = '';

// Grab appropriate forum data
if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
{
	$sql_from .= ' LEFT JOIN ' . FORUMS_TRACK_TABLE . ' ft ON (ft.user_id = ' . $mx_user->data['user_id'] . '
		AND ft.forum_id = f.forum_id)';
	$lastread_select .= ', ft.mark_time';
}

if ($mx_user->data['is_registered'])
{
	$sql_from .= ' LEFT JOIN ' . FORUMS_WATCH_TABLE . ' fw ON (fw.forum_id = f.forum_id AND fw.user_id = ' . $mx_user->data['user_id'] . ')';
	$lastread_select .= ', fw.notify_status';
}

$sql = "SELECT f.* $lastread_select
	FROM $sql_from
	WHERE f.forum_id = $forum_id";
$result = $db->sql_query($sql);
$forum_data = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if (!$forum_data)
{
	trigger_error('NO_FORUM');
}


// Configure style, language, etc.
$mx_user->setup('viewforum', $forum_data['forum_style']);


// Permissions check
if (!$phpbb_auth->acl_gets('f_list', 'f_read', $forum_id) || ($forum_data['forum_type'] == FORUM_LINK && $forum_data['forum_link'] && !$phpbb_auth->acl_get('f_read', $forum_id)))
{
	if ($mx_user->data['user_id'] != ANONYMOUS)
	{
		trigger_error('SORRY_AUTH_READ');
	}

	// mx_redirect() login.php
}

// Forum is passworded ... check whether access has been granted to this
// user this session, if not show login box
if ($forum_data['forum_password'])
{
	//login_forum_box($forum_data);
}

// Is this forum a link? ... User got here either because the
// number of clicks is being tracked or they guessed the id
if ($forum_data['forum_type'] == FORUM_LINK && $forum_data['forum_link'])
{
	// Does it have click tracking enabled?
	if ($forum_data['forum_flags'] & FORUM_FLAG_LINK_TRACK)
	{
		$sql = 'UPDATE ' . FORUMS_TABLE . '
			SET forum_posts = forum_posts + 1
			WHERE forum_id = ' . $forum_id;
		$db->sql_query($sql);
	}

	mx_redirect($forum_data['forum_link']);
}

// Build navigation links
mx_generate_forum_nav($forum_data);

// Forum Rules
if ($phpbb_auth->acl_get('f_read', $forum_id))
{
	generate_forum_rules($forum_data);
}

// Do we have subforums?
$active_forum_ary = $moderators = array();

if ($forum_data['left_id'] != $forum_data['right_id'] - 1)
{
	list($active_forum_ary, $moderators) = mx_display_forums($forum_data, $board_config['load_moderators'], $board_config['load_moderators']);
}
else
{
	$template->assign_var('S_HAS_SUBFORUM', false);
	get_moderators($moderators, $forum_id);
}

$template->set_filenames(array(
	'block_topic' => 'mx_topic.html')
);

$mx_backend->make_jumpbox(mx3_append_sid("{$phpbb_root_path}viewforum.$phpEx"), $forum_id);

$template->assign_vars(array(
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'U_PHPBB_ROOT_PATH' => PHPBB_URL,
	'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,
	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),

	'U_VIEW_FORUM'			=> mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=' . $page_id . 'f=' . $forum_id . '&amp;start=' . $start),
));


// Ok, if someone has only list-access, we only display the forum list.
// We also make this circumstance available to the template in case we want to display a notice. ;)
if (!$phpbb_auth->acl_get('f_read', $forum_id))
{
	$template->assign_vars(array(
		'S_NO_READ_ACCESS'		=> true,
		'S_AUTOLOGIN_ENABLED'	=> ($board_config['allow_autologin']) ? true : false,
		'S_LOGIN_ACTION'		=> mx3_append_sid("{$mx_root_path}login.$phpEx", 'mode=login') . '&amp;redirect=' . urlencode(str_replace('&amp;', '&', mx_url(array('_f_')))),
	));

}

// Handle marking posts
if ($mark_read == 'topics')
{
	markread('topics', $forum_id);

	$redirect_url = mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=' . $page_id . 'f=' . $forum_id);
	meta_refresh(3, $redirect_url);

	trigger_error($mx_user->_lang['TOPICS_MARKED'] . '<br /><br />' . sprintf($mx_user->_lang['RETURN_FORUM'], '<a href="' . $redirect_url . '">', '</a>'));
}

// Is a forum specific topic count required?
if ($forum_data['forum_topics_per_page'])
{
	$board_config['topics_per_page'] = $forum_data['forum_topics_per_page'];
}

// Do the forum Prune thang - cron type job ...
if ($forum_data['prune_next'] < time() && $forum_data['enable_prune'])
{
	$template->assign_var('RUN_CRON_TASK', '<img src="' . mx3_append_sid($phpbb_root_path . 'cron.' . $phpEx, 'cron_type=prune_forum&amp;f=' . $forum_id) . '" alt="cron" width="1" height="1" />');
}

// Forum rules and subscription info
$s_watching_forum = $s_watching_forum_img = array();
$s_watching_forum['link'] = $s_watching_forum['title'] = '';
$s_watching_forum['is_watching'] = false;

if (($board_config['email_enable'] || $board_config['jab_enable']) && $board_config['allow_forum_notify'] && $phpbb_auth->acl_get('f_subscribe', $forum_id))
{
	$notify_status = (isset($forum_data['notify_status'])) ? $forum_data['notify_status'] : NULL;
	watch_topic_forum('forum', $s_watching_forum, $s_watching_forum_img, $mx_user->data['user_id'], $forum_id, 0, $notify_status);
}

$s_forum_rules = '';
mx_gen_forum_auth_level('forum', $forum_id, $forum_data['forum_status']);

// Topic ordering options
$limit_days = array(0 => $mx_user->_lang['ALL_TOPICS'], 1 => $mx_user->_lang['1_DAY'], 7 => $mx_user->_lang['7_DAYS'], 14 => $mx_user->_lang['2_WEEKS'], 30 => $mx_user->_lang['1_MONTH'], 90 => $mx_user->_lang['3_MONTHS'], 180 => $mx_user->_lang['6_MONTHS'], 365 => $mx_user->_lang['1_YEAR']);

$sort_by_text = array('a' => $mx_user->_lang['AUTHOR'], 't' => $mx_user->_lang['POST_TIME'], 'r' => $mx_user->_lang['REPLIES'], 's' => $mx_user->_lang['SUBJECT'], 'v' => $mx_user->_lang['VIEWS']);
$sort_by_sql = array('a' => 't.topic_first_poster_name', 't' => 't.topic_last_post_time', 'r' => 't.topic_replies', 's' => 't.topic_title', 'v' => 't.topic_views');

$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
mx_gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

// Limit topics to certain time frame, obtain correct topic count
if ($sort_days)
{
	$min_post_time = time() - ($sort_days * 86400);

	$sql = 'SELECT COUNT(topic_id) AS num_topics
		FROM ' . TOPICS_TABLE . "
		WHERE forum_id = $forum_id
			AND topic_type NOT IN (" . POST_ANNOUNCE . ', ' . POST_GLOBAL . ")
			AND topic_last_post_time >= $min_post_time
		" . (($phpbb_auth->acl_get('m_approve', $forum_id)) ? '' : 'AND topic_approved = 1');
	$result = $db->sql_query($sql);
	$topics_count = (int) $db->sql_fetchfield('num_topics');
	$db->sql_freeresult($result);

	if ($mx_request_vars->is_post('sort'))
	{
		$start = 0;
	}
	$sql_limit_time = "AND t.topic_last_post_time >= $min_post_time";

	// Make sure we have information about day selection ready
	$template->assign_var('S_SORT_DAYS', true);
}
else
{
	$topics_count = ($phpbb_auth->acl_get('m_approve', $forum_id)) ? $forum_data['forum_topics_real'] : $forum_data['forum_topics'];
	$sql_limit_time = '';
}

// Make sure $start is set to the last page if it exceeds the amount
if ($start < 0 || $start > $topics_count)
{
	$start = ($start < 0) ? 0 : floor(($topics_count - 1) / $board_config['topics_per_page']) * $board_config['topics_per_page'];
}

// Basic pagewide vars
$post_alt = ($forum_data['forum_status'] == ITEM_LOCKED) ? $mx_user->_lang['FORUM_LOCKED'] : $mx_user->_lang['POST_NEW_TOPIC'];

// Display active topics?
$s_display_active = ($forum_data['forum_type'] == FORUM_CAT && ($forum_data['forum_flags'] & FORUM_FLAG_ACTIVE_TOPICS)) ? true : false;

$template->assign_vars(array(
	'MODERATORS'	=> (!empty($moderators[$forum_id])) ? implode(', ', $moderators[$forum_id]) : '',

	'POST_IMG'					=> ($forum_data['forum_status'] == ITEM_LOCKED) ? $mx_user->img('button_topic_locked', $post_alt) : $mx_user->img('button_topic_new', $post_alt),
	'NEWEST_POST_IMG'			=> $mx_user->img('icon_topic_newest', 'VIEW_NEWEST_POST'),
	'LAST_POST_IMG'				=> $mx_user->img('icon_topic_latest', 'VIEW_LATEST_POST'),
	'FOLDER_IMG'				=> $mx_user->img('topic_read', 'NO_NEW_POSTS'),
	'FOLDER_NEW_IMG'			=> $mx_user->img('topic_unread', 'NEW_POSTS'),
	'FOLDER_HOT_IMG'			=> $mx_user->img('topic_read_hot', 'NO_NEW_POSTS_HOT'),
	'FOLDER_HOT_NEW_IMG'		=> $mx_user->img('topic_unread_hot', 'NEW_POSTS_HOT'),
	'FOLDER_LOCKED_IMG'			=> $mx_user->img('topic_read_locked', 'NO_NEW_POSTS_LOCKED'),
	'FOLDER_LOCKED_NEW_IMG'		=> $mx_user->img('topic_unread_locked', 'NEW_POSTS_LOCKED'),
	'FOLDER_STICKY_IMG'			=> $mx_user->img('sticky_read', 'POST_STICKY'),
	'FOLDER_STICKY_NEW_IMG'		=> $mx_user->img('sticky_unread', 'POST_STICKY'),
	'FOLDER_ANNOUNCE_IMG'		=> $mx_user->img('announce_read', 'POST_ANNOUNCEMENT'),
	'FOLDER_ANNOUNCE_NEW_IMG'	=> $mx_user->img('announce_unread', 'POST_ANNOUNCEMENT'),
	'FOLDER_MOVED_IMG'			=> $mx_user->img('topic_moved', 'TOPIC_MOVED'),
	'REPORTED_IMG'				=> $mx_user->img('icon_topic_reported', 'TOPIC_REPORTED'),
	'UNAPPROVED_IMG'			=> $mx_user->img('icon_topic_unapproved', 'TOPIC_UNAPPROVED'),
	'GOTO_PAGE_IMG'				=> $mx_user->img('icon_post_target', 'GOTO_PAGE'),

	'L_NO_TOPICS' 			=> ($forum_data['forum_status'] == ITEM_LOCKED) ? $mx_user->_lang['POST_FORUM_LOCKED'] : $mx_user->_lang['NO_TOPICS'],

	'S_DISPLAY_POST_INFO'	=> ($forum_data['forum_type'] == FORUM_POST && ($phpbb_auth->acl_get('f_post', $forum_id) || $mx_user->data['user_id'] == ANONYMOUS)) ? true : false,

	'S_IS_POSTABLE'			=> ($forum_data['forum_type'] == FORUM_POST) ? true : false,
	'S_USER_CAN_POST'		=> ($phpbb_auth->acl_get('f_post', $forum_id)) ? true : false,
	'S_DISPLAY_ACTIVE'		=> $s_display_active,
	'S_SELECT_SORT_DIR'		=> $s_sort_dir,
	'S_SELECT_SORT_KEY'		=> $s_sort_key,
	'S_SELECT_SORT_DAYS'	=> $s_limit_days,
	'S_TOPIC_ICONS'			=> ($s_display_active && sizeof($active_forum_ary)) ? max($active_forum_ary['enable_icons']) : (($forum_data['enable_icons']) ? true : false),
	'S_WATCH_FORUM_LINK'	=> $s_watching_forum['link'],
	'S_WATCH_FORUM_TITLE'	=> $s_watching_forum['title'],
	'S_WATCHING_FORUM'		=> $s_watching_forum['is_watching'],
	'S_FORUM_ACTION'		=> mx3_append_sid("{$phpbb_root_path}viewforum.$phpEx", "f=$forum_id&amp;start=$start"),
	'S_DISPLAY_SEARCHBOX'	=> ($phpbb_auth->acl_get('u_search') && $phpbb_auth->acl_get('f_search', $forum_id) && $board_config['load_search']) ? true : false,
	'S_SEARCHBOX_ACTION'	=> mx3_append_sid("{$phpbb_root_path}search.$phpEx", 'fid[]=' . $forum_id),
	'S_SINGLE_MODERATOR'	=> (!empty($moderators[$forum_id]) && sizeof($moderators[$forum_id]) > 1) ? false : true,

	'U_MCP'				=> ($phpbb_auth->acl_get('m_', $forum_id)) ? mx3_append_sid("{$phpbb_root_path}mcp.$phpEx", "f=$forum_id&amp;i=main&amp;mode=forum_view", true, $mx_user->session_id) : '',
	'U_POST_NEW_TOPIC'	=> ($phpbb_auth->acl_get('f_post', $forum_id) || $mx_user->data['user_id'] == ANONYMOUS) ? mx_append_sid("{$phpbb_root_path}posting.$phpEx", 'mode=post&amp;f=' . $forum_id) : '',
	'U_VIEW_FORUM'		=> mx_append_sid("{$phpbb_root_path}viewforum.$phpEx", "f=$forum_id&amp;$u_sort_param&amp;start=$start"),
	'U_MARK_TOPICS'		=> ($mx_user->data['is_registered'] || $board_config['load_anon_lastread']) ? mx3_append_sid("{$phpbb_root_path}viewforum.$phpEx", "f=$forum_id&amp;mark=topics") : '',
));

// Grab icons
$icons = $mx_cache->obtain_icons();

// Grab all topic data
$rowset = $announcement_list = $topic_list = $global_announce_list = array();

$sql_array = array(
	'SELECT'	=> 't.*',
	'FROM'		=> array(
		TOPICS_TABLE		=> 't'
	),
	'LEFT_JOIN'	=> array(),
);

$sql_approved = ($phpbb_auth->acl_get('m_approve', $forum_id)) ? '' : 'AND t.topic_approved = 1';

if ($mx_user->data['is_registered'])
{
	if ($board_config['load_db_track'])
	{
		$sql_array['LEFT_JOIN'][] = array('FROM' => array(TOPICS_POSTED_TABLE => 'tp'), 'ON' => 'tp.topic_id = t.topic_id AND tp.user_id = ' . $mx_user->data['user_id']);
		$sql_array['SELECT'] .= ', tp.topic_posted';
	}

	if ($board_config['load_db_lastread'])
	{
		$sql_array['LEFT_JOIN'][] = array('FROM' => array(TOPICS_TRACK_TABLE => 'tt'), 'ON' => 'tt.topic_id = t.topic_id AND tt.user_id = ' . $mx_user->data['user_id']);
		$sql_array['SELECT'] .= ', tt.mark_time';

		if ($s_display_active && sizeof($active_forum_ary))
		{
			$sql_array['LEFT_JOIN'][] = array('FROM' => array(FORUMS_TRACK_TABLE => 'ft'), 'ON' => 'ft.forum_id = t.forum_id AND ft.user_id = ' . $mx_user->data['user_id']);
			$sql_array['SELECT'] .= ', ft.mark_time AS forum_mark_time';
		}
	}
}

if ($forum_data['forum_type'] == FORUM_POST)
{
	// Obtain announcements ... removed sort ordering, sort by time in all cases
	$sql = $db->sql_build_query('SELECT', array(
		'SELECT'	=> $sql_array['SELECT'],
		'FROM'		=> $sql_array['FROM'],
		'LEFT_JOIN'	=> $sql_array['LEFT_JOIN'],

		'WHERE'		=> 't.forum_id IN (' . $forum_id . ', 0)
			AND t.topic_type IN (' . POST_ANNOUNCE . ', ' . POST_GLOBAL . ')',

		'ORDER_BY'	=> 't.topic_time DESC',
	));
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$rowset[$row['topic_id']] = $row;
		$announcement_list[] = $row['topic_id'];

		if ($row['topic_type'] == POST_GLOBAL)
		{
			$global_announce_list[$row['topic_id']] = true;
		}
		else
		{
			$topics_count--;
		}
	}
	$db->sql_freeresult($result);
}

// If the user is trying to reach late pages, start searching from the end
$store_reverse = false;
$sql_limit = $board_config['topics_per_page'];
if ($start > $topics_count / 2)
{
	$store_reverse = true;

	if ($start + $board_config['topics_per_page'] > $topics_count)
	{
		$sql_limit = min($board_config['topics_per_page'], max(1, $topics_count - $start));
	}

	// Select the sort order
	$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'ASC' : 'DESC');
	$sql_start = max(0, $topics_count - $sql_limit - $start);
}
else
{
	// Select the sort order
	$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
	$sql_start = $start;
}

if ($forum_data['forum_type'] == FORUM_POST || !sizeof($active_forum_ary))
{
	$sql_where = 't.forum_id = ' . $forum_id;
}
else if (empty($active_forum_ary['exclude_forum_id']))
{
	$sql_where = $db->sql_in_set('t.forum_id', $active_forum_ary['forum_id']);
}
else
{
	$get_forum_ids = array_diff($active_forum_ary['forum_id'], $active_forum_ary['exclude_forum_id']);
	$sql_where = (sizeof($get_forum_ids)) ? $db->sql_in_set('t.forum_id', $get_forum_ids) : 't.forum_id = ' . $forum_id;
}

// SQL array for obtaining topics/stickies
$sql_array = array(
	'SELECT'		=> $sql_array['SELECT'],
	'FROM'			=> $sql_array['FROM'],
	'LEFT_JOIN'		=> $sql_array['LEFT_JOIN'],

	'WHERE'			=> $sql_where . '
		AND t.topic_type IN (' . POST_NORMAL . ', ' . POST_STICKY . ")
		$sql_approved
		$sql_limit_time",

	'ORDER_BY'		=> 't.topic_type ' . ((!$store_reverse) ? 'DESC' : 'ASC') . ', ' . $sql_sort_order,
);

// If store_reverse, then first obtain topics, then stickies, else the other way around...
// Funnily enough you typically save one query if going from the last page to the middle (store_reverse) because
// the number of stickies are not known
$sql = $db->sql_build_query('SELECT', $sql_array);
if ( !($result = $db->sql_query_limit($sql, $sql_limit, $sql_start)) )
{
	mx_message_die(GENERAL_ERROR, 'Could not query new topic information', '', __LINE__, __FILE__, $sql);
}

$shadow_topic_list = array();
while ($row = $db->sql_fetchrow($result))
{
	if ($row['topic_status'] == ITEM_MOVED)
	{
		$shadow_topic_list[$row['topic_moved_id']] = $row['topic_id'];
	}

	$rowset[$row['topic_id']] = $row;
	$topic_list[] = $row['topic_id'];
}
$db->sql_freeresult($result);

//print_r($shadow_topic_list);

// If we have some shadow topics, update the rowset to reflect their topic information
if (sizeof($shadow_topic_list))
{
	$sql = 'SELECT *
		FROM ' . TOPICS_TABLE . '
		WHERE ' . $db->sql_in_set('topic_id', array_keys($shadow_topic_list));
	if ( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not query new topic information', '', __LINE__, __FILE__, $sql);
	}


	while ($row = $db->sql_fetchrow($result))
	{
		$orig_topic_id = $shadow_topic_list[$row['topic_id']];

		// If the shadow topic is already listed within the rowset (happens for active topics for example), then do not include it...
		if (isset($rowset[$row['topic_id']]))
		{
			// We need to remove any trace regarding this topic. :)
			unset($rowset[$orig_topic_id]);
			unset($topic_list[array_search($orig_topic_id, $topic_list)]);
			$topics_count--;

			continue;
		}

		// Do not include those topics the user has no permission to access
		if (!$phpbb_auth->acl_get('f_read', $row['forum_id']))
		{
			// We need to remove any trace regarding this topic. :)
			unset($rowset[$orig_topic_id]);
			unset($topic_list[array_search($orig_topic_id, $topic_list)]);
			$topics_count--;

			continue;
		}

		// We want to retain some values
		$row = array_merge($row, array(
			'topic_moved_id'	=> $rowset[$orig_topic_id]['topic_moved_id'],
			'topic_status'		=> $rowset[$orig_topic_id]['topic_status'])
		);

		$rowset[$orig_topic_id] = $row;
	}
	$db->sql_freeresult($result);
}
unset($shadow_topic_list);

// Ok, adjust topics count for active topics list
if ($s_display_active)
{
	$topics_count = 1;
}

$template->assign_vars(array(
	'PAGINATION' => mx_generate_pagination($base_url, $topics_count, $board_config['topics_per_page'], $start, true, true, true, false, 'l_start'),
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor($start / $board_config['topics_per_page']) + 1 ), ceil($topics_count / $board_config['topics_per_page'])),
	'TOTAL_TOPICS'	=> ($s_display_active) ? false : (($topics_count == 1) ? $mx_user->_lang['VIEW_FORUM_TOPIC'] : sprintf($mx_user->_lang['VIEW_FORUM_TOPICS'], $topics_count)))
);

$topic_list = ($store_reverse) ? array_merge($announcement_list, array_reverse($topic_list)) : array_merge($announcement_list, $topic_list);
$topic_tracking_info = $tracking_topics = array();

//print_r($topic_list);

// Okay, lets dump out the page ...
if (sizeof($topic_list))
{
	$mark_forum_read = true;
	$mark_time_forum = 0;

	// Active topics?
	if ($s_display_active && sizeof($active_forum_ary))
	{
		// Generate topic forum list...
		$topic_forum_list = array();
		foreach ($rowset as $t_id => $row)
		{
			$topic_forum_list[$row['forum_id']]['forum_mark_time'] = ($board_config['load_db_lastread'] && $mx_user->data['is_registered'] && isset($row['forum_mark_time'])) ? $row['forum_mark_time'] : 0;
			$topic_forum_list[$row['forum_id']]['topics'][] = $t_id;
		}

		if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
		{
			foreach ($topic_forum_list as $f_id => $topic_row)
			{
				$topic_tracking_info += get_topic_tracking($f_id, $topic_row['topics'], $rowset, array($f_id => $topic_row['forum_mark_time']), false);
			}
		}
		else if ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])
		{
			foreach ($topic_forum_list as $f_id => $topic_row)
			{
				$topic_tracking_info += get_complete_topic_tracking($f_id, $topic_row['topics'], false);
			}
		}

		unset($topic_forum_list);
	}
	else
	{
		if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
		{
			$topic_tracking_info = get_topic_tracking($forum_id, $topic_list, $rowset, array($forum_id => $forum_data['mark_time']), $global_announce_list);
			$mark_time_forum = (!empty($forum_data['mark_time'])) ? $forum_data['mark_time'] : $mx_user->data['user_lastmark'];
		}
		else if ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])
		{
			$topic_tracking_info = get_complete_topic_tracking($forum_id, $topic_list, $global_announce_list);

			if (!$mx_user->data['is_registered'])
			{
				$mx_user->data['user_lastmark'] = (isset($tracking_topics['l'])) ? (int) (base_convert($tracking_topics['l'], 36, 10) + $board_config['board_startdate']) : 0;
			}
			$mark_time_forum = (isset($tracking_topics['f'][$forum_id])) ? (int) (base_convert($tracking_topics['f'][$forum_id], 36, 10) + $board_config['board_startdate']) : $mx_user->data['user_lastmark'];
		}
	}


	$s_type_switch = 0;
	foreach ($topic_list as $topic_id)
	{
		$row = &$rowset[$topic_id];

		// This will allow the style designer to output a different header
		// or even separate the list of announcements from sticky and normal topics
		$s_type_switch_test = ($row['topic_type'] == POST_ANNOUNCE || $row['topic_type'] == POST_GLOBAL) ? 1 : 0;


		// Replies
		$replies = ($phpbb_auth->acl_get('m_approve', $forum_id)) ? $row['topic_replies_real'] : $row['topic_replies'];

		if ($row['topic_status'] == ITEM_MOVED)
		{
			$topic_id = $row['topic_moved_id'];
			$unread_topic = false;
		}
		else
		{
			$unread_topic = (isset($topic_tracking_info[$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$topic_id]) ? true : false;
		}

		// Get folder img, topic status/type related information
		$folder_img = $folder_alt = $topic_type = '';
		topic_status($row, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);

		// Generate all the URIs ...
		$view_topic_url = mx3_append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . (($row['forum_id']) ? $row['forum_id'] : $forum_id) . '&amp;t=' . $topic_id);

		$topic_unapproved = (!$row['topic_approved'] && $phpbb_auth->acl_get('m_approve', $forum_id)) ? true : false;
		$posts_unapproved = ($row['topic_approved'] && $row['topic_replies'] < $row['topic_replies_real'] && $phpbb_auth->acl_get('m_approve', $forum_id)) ? true : false;
		$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? mx3_append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=queue&amp;mode=' . (($topic_unapproved) ? 'approve_details' : 'unapproved_posts') . "&amp;t=$topic_id", true, $mx_user->session_id) : '';

		$i = count($row['forum_id']);

		// Send vars to template
		$template->assign_block_vars('topicrow', array(
			'FORUM_ID'					=> $forum_id,
			'TOPIC_ID'					=> $topic_id,
			'TOPIC_AUTHOR'				=> get_username_string('username', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
			'TOPIC_AUTHOR_COLOUR'		=> get_username_string('colour', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
			'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
			'FIRST_POST_TIME'			=> $mx_user->format_date($row['topic_time']),
			'LAST_POST_SUBJECT'			=> $phpBB3->censor_text($row['topic_last_post_subject']),
			'LAST_POST_TIME'			=> $mx_user->format_date($row['topic_last_post_time']),
			'LAST_VIEW_TIME'			=> $mx_user->format_date($row['topic_last_view_time']),
			'LAST_POST_AUTHOR'			=> get_username_string('username', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
			'LAST_POST_AUTHOR_COLOUR'	=> get_username_string('colour', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
			'LAST_POST_AUTHOR_FULL'		=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),

			'PAGINATION'		=> topic_generate_pagination($replies, $view_topic_url),
			'REPLIES'			=> $replies,
			'VIEWS'				=> $row['topic_views'],
			'TOPIC_TITLE'		=> $phpBB3->censor_text($row['topic_title']),
			'TOPIC_TYPE'		=> $topic_type,

			'TOPIC_FOLDER_IMG'		=> $mx_user->img($folder_img, $folder_alt),
			'TOPIC_FOLDER_IMG_SRC'	=> $mx_user->img($folder_img, $folder_alt, false, '', 'src'),
			'TOPIC_FOLDER_IMG_ALT'	=> $mx_user->_lang[$folder_alt],
			'TOPIC_ICON_IMG'		=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['img'] : '',
			'TOPIC_ICON_IMG_WIDTH'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['width'] : '',
			'TOPIC_ICON_IMG_HEIGHT'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['height'] : '',
			'ATTACH_ICON_IMG'		=> ($phpbb_auth->acl_get('u_download') && $phpbb_auth->acl_get('f_download', $forum_id) && $row['topic_attachment']) ? $mx_user->img('icon_topic_attach', $mx_user->_lang['TOTAL_ATTACHMENTS']) : '',
			'UNAPPROVED_IMG'		=> ($topic_unapproved || $posts_unapproved) ? $mx_user->img('icon_topic_unapproved', ($topic_unapproved) ? 'TOPIC_UNAPPROVED' : 'POSTS_UNAPPROVED') : '',

			'S_TOPIC_TYPE'			=> $row['topic_type'],
			'S_USER_POSTED'			=> (isset($row['topic_posted']) && $row['topic_posted']) ? true : false,
			'S_UNREAD_TOPIC'		=> $unread_topic,
			'S_TOPIC_REPORTED'		=> (!empty($row['topic_reported']) && $phpbb_auth->acl_get('m_report', $forum_id)) ? true : false,
			'S_TOPIC_UNAPPROVED'	=> $topic_unapproved,
			'S_POSTS_UNAPPROVED'	=> $posts_unapproved,
			'S_HAS_POLL'			=> ($row['poll_start']) ? true : false,
			'S_POST_ANNOUNCE'		=> ($row['topic_type'] == POST_ANNOUNCE) ? true : false,
			'S_POST_GLOBAL'			=> ($row['topic_type'] == POST_GLOBAL) ? true : false,
			'S_POST_STICKY'			=> ($row['topic_type'] == POST_STICKY) ? true : false,
			'S_TOPIC_LOCKED'		=> ($row['topic_status'] == ITEM_LOCKED) ? true : false,
			'S_TOPIC_MOVED'			=> ($row['topic_status'] == ITEM_MOVED) ? true : false,

			'U_NEWEST_POST'			=> $view_topic_url . '&amp;view=unread#unread',
			'U_LAST_POST'			=> $view_topic_url . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id'],
			'U_LAST_POST_AUTHOR'	=> get_username_string('profile', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
			'U_TOPIC_AUTHOR'		=> get_username_string('profile', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
			'U_VIEW_TOPIC'			=> $view_topic_url,
			'U_MCP_REPORT'			=> mx3_append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=reports&amp;mode=reports&amp;f=' . $forum_id . '&amp;t=' . $topic_id, true, $mx_user->session_id),
			'U_MCP_QUEUE'			=> $u_mcp_queue,

			'S_TOPIC_TYPE_SWITCH'	=> ($s_type_switch == $s_type_switch_test) ? -1 : $s_type_switch_test,
	         	'S_ROW_COUNT'	=> $i)
		);

		$s_type_switch = ($row['topic_type'] == POST_ANNOUNCE || $row['topic_type'] == POST_GLOBAL) ? 1 : 0;

		if ($unread_topic)
		{
			$mark_forum_read = false;
		}

		unset($rowset[$topic_id]);
	}
}

// This is rather a fudge but it's the best I can think of without requiring information
// on all topics (as we do in 2.0.x). It looks for unread or new topics, if it doesn't find
// any it updates the forum last read cookie. This requires that the user visit the forum
// after reading a topic
if ($forum_data['forum_type'] == FORUM_POST && sizeof($topic_list) && $mark_forum_read)
{
	update_forum_tracking_info($forum_id, $forum_data['forum_last_post_time'], false, $mark_time_forum);
}

$template->pparse('block_topic');

?>