<?php
/**
*
* @package MX-Publisher Module - mx_phpbb2blocks
* @version $Id: mx_functions_display.php,v 1.11 2013/06/28 15:37:22 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if (!defined('IN_PORTAL'))
{
	exit;
}

//
// Fixes for MX-Publisher:
// all funtions mx_ prefixed
// $config -> $board_config
// $cache -> $mx_cache
// $user -> $mx_user
// $auth -> $phpbb_auth
// $request -> $mx_request_vars
// append_sid -> mx3_append_sid
// get_username_string -> mx_get_username_string
//

/**
* Display Forums
   function display_forums($root_data = '', $display_moderators = true, $return_moderators = false)
*/
function mx_display_forums($root_data = '', $display_moderators = true, $return_moderators = false)
{
	global $db, $phpbb_auth, $mx_user, $template;
	global $phpbb_root_path, $phpEx, $board_config;
	global $mx_request_vars, $mx_bbcode;

	$forum_rows = $subforums = $forum_ids = $forum_ids_moderator = $forum_moderators = $active_forum_ary = array();
	$parent_id = $visible_forums = 0;
	$sql_from = '';

	// Mark forums read?
	$mark_read = $mx_request_vars->request('mark', MX_TYPE_NO_TAGS, '');

	if ($mark_read == 'all')
	{
		$mark_read = '';
	}

	if (!$root_data)
	{
		if ($mark_read == 'forums')
		{
			$mark_read = 'all';
		}

		$root_data = array('forum_id' => 0);
		$sql_where = '';
	}
	else
	{
		$sql_where = 'left_id > ' . $root_data['left_id'] . ' AND left_id < ' . $root_data['right_id'];
	}

	// Handle marking everything read
	if ($mark_read == 'all')
	{
		$redirect = phpBB3::build_url(array('mark', 'hash', 'mark_time'));
		meta_refresh(3, $redirect);

		if (phpBB3::check_link_hash($mx_request_vars->variable('hash', ''), 'global'))
		{
			phpBB3::markread('all', false, false, $mx_request_vars->variable('mark_time', 0));
			/* * /
			if ($mx_request_vars->is_ajax())
			{
				// Tell the ajax script what language vars and URL need to be replaced
				$data = array(
					'NO_UNREAD_POSTS'	=> $mx_user->lang['NO_UNREAD_POSTS'],
					'UNREAD_POSTS'		=> $mx_user->lang['UNREAD_POSTS'],
					'U_MARK_FORUMS'		=> ($mx_user->data['is_registered'] || $board_config['load_anon_lastread']) ? append_sid("{$phpbb_root_path}index.$phpEx", 'hash=' . generate_link_hash('global') . '&mark=forums&mark_time=' . time()) : '',
					'MESSAGE_TITLE'		=> $mx_user->lang['INFORMATION'],
					'MESSAGE_TEXT'		=> $mx_user->lang['FORUMS_MARKED']
				);
				$json_response = new \phpbb\json_response();
				$json_response->send($data);
			}
			/* */
			trigger_error(
				$mx_user->lang['FORUMS_MARKED'] . '<br /><br />' .
				sprintf($mx_user->lang['RETURN_INDEX'], '<a href="' . $redirect . '">', '</a>')
			);
		}
		else
		{
			trigger_error(sprintf($mx_user->lang['RETURN_PAGE'], '<a href="' . $redirect . '">', '</a>'));
		}
	}
	
	// Display list of active topics for this category?
	$show_active = (isset($root_data['forum_flags']) && ($root_data['forum_flags'] & FORUM_FLAG_ACTIVE_TOPICS)) ? true : false;

	$sql_array = array(
		'SELECT'	=> 'f.*',
		'FROM'		=> array(
			FORUMS_TABLE		=> 'f'
		),
		'LEFT_JOIN'	=> array(),
	);

	if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
	{
		$sql_array['LEFT_JOIN'][] = array('FROM' => array(FORUMS_TRACK_TABLE => 'ft'), 'ON' => 'ft.user_id = ' . $mx_user->data['user_id'] . ' AND ft.forum_id = f.forum_id');
		$sql_array['SELECT'] .= ', ft.mark_time';
	}
	else if ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])
	{
		$tracking_topics = $mx_request_vars->variable($board_config['cookie_name'] . '_track', '', true, mx_request_vars::COOKIE);
		$tracking_topics = ($tracking_topics) ? phpBB3::tracking_unserialize($tracking_topics) : array();

		if (!$mx_user->data['is_registered'])
		{
			$mx_user->data['user_lastmark'] = (isset($tracking_topics['l'])) ? (int) (base_convert($tracking_topics['l'], 36, 10) + $board_config['board_startdate']) : 0;
		}
	}

	if ($show_active)
	{
		$sql_array['LEFT_JOIN'][] = array(
			'FROM'	=> array(FORUMS_ACCESS_TABLE => 'fa'),
			'ON'	=> "fa.forum_id = f.forum_id AND fa.session_id = '" . $db->sql_escape($mx_user->session_id) . "'"
		);

		$sql_array['SELECT'] .= ', fa.user_id';
	}

	$sql_ary = array(
		'SELECT'	=> $sql_array['SELECT'],
		'FROM'		=> $sql_array['FROM'],
		'LEFT_JOIN'	=> $sql_array['LEFT_JOIN'],

		'WHERE'		=> $sql_where,

		'ORDER_BY'	=> 'f.left_id',
	);

	$sql = $db->sql_build_query('SELECT', $sql_ary);
	if ( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
	}

	$forum_tracking_info = $valid_categories = array();
	$branch_root_id = $root_data['forum_id'];

	/* @var $phpbb_content_visibility \phpbb\content_visibility */
	//$phpbb_content_visibility = $phpbb_container->get('content.visibility');

	while ($row = $db->sql_fetchrow($result))
	{

		$forum_id = $row['forum_id'];

		// Mark forums read?
		if ($mark_read == 'forums' || $mark_read == 'all')
		{
			if ($phpbb_auth->acl_get('f_list', $forum_id))
			{
				$forum_ids[] = $forum_id;
				continue;
			}
		}
		
		// Category with no members
		if ($row['forum_type'] == FORUM_CAT && ($row['left_id'] + 1 == $row['right_id']))
		{
			continue;
		}

		// Skip branch
		if (isset($right_id))
		{
			if ($row['left_id'] < $right_id)
			{
				continue;
			}
			unset($right_id);
		}

		if (!$phpbb_auth->acl_get('f_list', $forum_id))
		{
			// if the user does not have permissions to list this forum, skip everything until next branch
			$right_id = $row['right_id'];
			continue;
		}

		$forum_ids[] = $forum_id;

		if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
		{
			$forum_tracking_info[$forum_id] = (!empty($row['mark_time'])) ? $row['mark_time'] : $mx_user->data['user_lastmark'];
		}
		else if ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])
		{
			if (!$mx_user->data['is_registered'])
			{
				$mx_user->data['user_lastmark'] = (isset($tracking_topics['l'])) ? (int) (base_convert($tracking_topics['l'], 36, 10) + $board_config['board_startdate']) : 0;
			}
			$forum_tracking_info[$forum_id] = (isset($tracking_topics['f'][$forum_id])) ? (int) (base_convert($tracking_topics['f'][$forum_id], 36, 10) + $board_config['board_startdate']) : $mx_user->data['user_lastmark'];
		}

		// Lets check whether there are unapproved topics/posts, so we can display an information to moderators
		$row['forum_id_unapproved_topics'] = ($phpbb_auth->acl_get('m_approve', $forum_id) && $row['forum_topics_unapproved']) ? $forum_id : 0;
		$row['forum_id_unapproved_posts'] = ($phpbb_auth->acl_get('m_approve', $forum_id) && $row['forum_posts_unapproved']) ? $forum_id : 0;
		//$row['forum_posts'] = $phpbb_content_visibility->get_count('forum_posts', $row, $forum_id);
		//$row['forum_topics'] = $phpbb_content_visibility->get_count('forum_topics', $row, $forum_id);
		$row['forum_topics'] = ($phpbb_auth->acl_get('m_approve', $forum_id)) ? $row['forum_topics_real'] : $row['forum_topics'];

		// Display active topics from this forum?
		if ($show_active && $row['forum_type'] == FORUM_POST && $phpbb_auth->acl_get('f_read', $forum_id) && ($row['forum_flags'] & FORUM_FLAG_ACTIVE_TOPICS))
		{
			if (!isset($active_forum_ary['forum_topics']))
			{
				$active_forum_ary['forum_topics'] = 0;
			}

			if (!isset($active_forum_ary['forum_posts']))
			{
				$active_forum_ary['forum_posts'] = 0;
			}

			$active_forum_ary['forum_id'][]		= $forum_id;
			$active_forum_ary['enable_icons'][]	= $row['enable_icons'];
			$active_forum_ary['forum_topics']	+= $row['forum_topics'];
			$active_forum_ary['forum_posts']	+= $row['forum_posts'];

			// If this is a passworded forum we do not show active topics from it if the user is not authorised to view it...
			if ($row['forum_password'] && $row['user_id'] != $mx_user->data['user_id'])
			{
				$active_forum_ary['exclude_forum_id'][] = $forum_id;
			}
		}

		// Fill list of categories with forums
		if (isset($forum_rows[$row['parent_id']]))
		{
			$valid_categories[$row['parent_id']] = true;
		}

		//
		if ($row['parent_id'] == $root_data['forum_id'] || $row['parent_id'] == $branch_root_id)
		{
			if ($row['forum_type'] != FORUM_CAT)
			{
				$forum_ids_moderator[] = (int) $forum_id;
			}

			// Direct child of current branch
			$parent_id = $forum_id;
			$forum_rows[$forum_id] = $row;

			if ($row['forum_type'] == FORUM_CAT && $row['parent_id'] == $root_data['forum_id'])
			{
				$branch_root_id = $forum_id;
			}
			$forum_rows[$parent_id]['forum_id_last_post'] = $row['forum_id'];
			$forum_rows[$parent_id]['forum_password_last_post'] = $row['forum_password'];
			$forum_rows[$parent_id]['orig_forum_last_post_time'] = $row['forum_last_post_time'];
		}
		else if ($row['forum_type'] != FORUM_CAT)
		{
			$subforums[$parent_id][$forum_id]['display'] = ($row['display_on_index']) ? true : false;
			$subforums[$parent_id][$forum_id]['name'] = $row['forum_name'];
			$subforums[$parent_id][$forum_id]['orig_forum_last_post_time'] = $row['forum_last_post_time'];
			$subforums[$parent_id][$forum_id]['children'] = array();
			$subforums[$parent_id][$forum_id]['type'] = $row['forum_type'];

			if (isset($subforums[$parent_id][$row['parent_id']]) && !$row['display_on_index'])
			{
				$subforums[$parent_id][$row['parent_id']]['children'][] = $forum_id;
			}

			if (!$forum_rows[$parent_id]['forum_id_unapproved_topics'] && $row['forum_id_unapproved_topics'])
			{
				$forum_rows[$parent_id]['forum_id_unapproved_topics'] = $forum_id;
			}

			if (!$forum_rows[$parent_id]['forum_id_unapproved_posts'] && $row['forum_id_unapproved_posts'])
			{
				$forum_rows[$parent_id]['forum_id_unapproved_posts'] = $forum_id;
			}

			$forum_rows[$parent_id]['forum_topics'] += $row['forum_topics'];

			// Do not list redirects in LINK Forums as Posts.
			if ($row['forum_type'] != FORUM_LINK)
			{
				$forum_rows[$parent_id]['forum_posts'] += $row['forum_posts'];
			}

			if ($row['forum_last_post_time'] > $forum_rows[$parent_id]['forum_last_post_time'])
			{
				$forum_rows[$parent_id]['forum_last_post_id'] = $row['forum_last_post_id'];
				$forum_rows[$parent_id]['forum_last_post_subject'] = $row['forum_last_post_subject'];
				$forum_rows[$parent_id]['forum_last_post_time'] = $row['forum_last_post_time'];
				$forum_rows[$parent_id]['forum_last_poster_id'] = $row['forum_last_poster_id'];
				$forum_rows[$parent_id]['forum_last_poster_name'] = $row['forum_last_poster_name'];
				$forum_rows[$parent_id]['forum_last_poster_colour'] = $row['forum_last_poster_colour'];
				$forum_rows[$parent_id]['forum_id_last_post'] = $forum_id;
				$forum_rows[$parent_id]['forum_password_last_post'] = $row['forum_password'];
			}
		}

	}
	$db->sql_freeresult($result);

	// Handle marking posts
	if ($mark_read == 'forums' || $mark_read == 'all')
	{
		$redirect = phpBB3::build_url('mark');

		if ($mark_read == 'all')
		{
			phpBB3::markread('all');

			$message = sprintf($mx_user->lang['RETURN_INDEX'], '<a href="' . $redirect . '">', '</a>');
		}
		else
		{
			phpBB3::markread('topics', $forum_ids);

			$message = sprintf($mx_user->lang['RETURN_FORUM'], '<a href="' . $redirect . '">', '</a>');
		}

		meta_refresh(3, $redirect);
		trigger_error($mx_user->lang['FORUMS_MARKED'] . '<br /><br />' . $message);
	}

	// Grab moderators ... if necessary
	if ($display_moderators)
	{
		if ($return_moderators)
		{
			$forum_ids_moderator[] = $root_data['forum_id'];
		}
		mx_get_moderators($forum_moderators, $forum_ids_moderator);
	}

	// Used to tell whatever we have to create a dummy category or not.
	$last_catless = true;
	foreach ($forum_rows as $row)
	{
		// Category
		if ($row['parent_id'] == $root_data['forum_id'] && $row['forum_type'] == FORUM_CAT)
		{
			// Do not display categories without any forums to display
			if (!isset($valid_categories[$row['forum_id']]))
			{
				continue;
			}

			$cat_row = array(
				'S_IS_CAT'				=> true,
				'FORUM_ID'				=> $row['forum_id'],
				'FORUM_NAME'			=> $row['forum_name'],
				'FORUM_DESC'			=> mx_generate_text_for_display($row['forum_desc'], $row['forum_desc_uid'], $row['forum_desc_bitfield'], $row['forum_desc_options']),
				//Replacement for phpBB3::generate_text_for_display()
				//'FORUM_DESC'			=> $mx_bbcode->decode($row['forum_desc'], $row['forum_desc_uid'], true, $row['forum_desc_bitfield']),
				'FORUM_FOLDER_IMG'		=> '',
				'FORUM_FOLDER_IMG_SRC'	=> '',
				'FORUM_IMAGE'			=> ($row['forum_image']) ? '<img src="' . $phpbb_root_path . $row['forum_image'] . '" alt="' . $mx_user->lang['FORUM_CAT'] . '" />' : '',
				'FORUM_IMAGE_SRC'		=> ($row['forum_image']) ? $phpbb_root_path . $row['forum_image'] : '',
				'U_VIEWFORUM'			=> mx3_append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $row['forum_id']),
			);

			$template->assign_block_vars('forumrow', $cat_row);

			continue;
		}

		$visible_forums++;
		$forum_id = $row['forum_id'];

		$forum_unread = (isset($forum_tracking_info[$forum_id]) && $row['orig_forum_last_post_time'] > $forum_tracking_info[$forum_id]) ? true : false;

		$folder_image = $folder_alt = $l_subforums = '';
		$subforums_list = array();

		// Generate list of subforums if we need to
		if (isset($subforums[$forum_id]))
		{
			foreach ($subforums[$forum_id] as $subforum_id => $subforum_row)
			{
				$subforum_unread = (isset($forum_tracking_info[$subforum_id]) && $subforum_row['orig_forum_last_post_time'] > $forum_tracking_info[$subforum_id]) ? true : false;

				if (!$subforum_unread && !empty($subforum_row['children']))
				{
					foreach ($subforum_row['children'] as $child_id)
					{
						if (isset($forum_tracking_info[$child_id]) && $subforums[$forum_id][$child_id]['orig_forum_last_post_time'] > $forum_tracking_info[$child_id])
						{
							// Once we found an unread child forum, we can drop out of this loop
							$subforum_unread = true;
							break;
						}
					}
				}

				if ($subforum_row['display'] && $subforum_row['name'])
				{
					$subforums_list[] = array(
						'link'		=> mx3_append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $subforum_id),
						'name'		=> $subforum_row['name'],
						'unread'	=> $subforum_unread,
						'type'		=> $subforum_row['type'],
					);
				}
				else
				{
					unset($subforums[$forum_id][$subforum_id]);
				}

				// If one subforum is unread the forum gets unread too...
				if ($subforum_unread)
				{
					$forum_unread = true;
				}
			}

			$l_subforums = (count($subforums[$forum_id]) == 1) ? $mx_user->lang['SUBFORUM'] : $mx_user->lang['SUBFORUMS'];
			$folder_image = ($forum_unread) ? 'forum_unread_subforum' : 'forum_read_subforum';
		}
		else
		{
			switch ($row['forum_type'])
			{
				case FORUM_POST:
					$folder_image = ($forum_unread) ? 'forum_unread' : 'forum_read';
				break;

				case FORUM_LINK:
					$folder_image = 'forum_link';
				break;
			}
		}

		// Which folder should we display?
		if ($row['forum_status'] == ITEM_LOCKED)
		{
			$folder_image = ($forum_unread) ? 'forum_unread_locked' : 'forum_read_locked';
			$folder_alt = 'FORUM_LOCKED';
		}
		else
		{
			$folder_alt = ($forum_unread) ? 'NEW_POSTS' : 'NO_NEW_POSTS';
		}

		// Create last post link information, if appropriate
		if ($row['forum_last_post_id'])
		{
			if ($row['forum_password_last_post'] === '' && $phpbb_auth->acl_gets('f_read', 'f_list_topics', $row['forum_id_last_post']))
			{
				$last_post_subject = phpBB3::censor_text($row['forum_last_post_subject']);
				$last_post_subject_truncated = phpBB3::truncate_string($last_post_subject, 30, 255, false, $mx_user->lang['ELLIPSIS']);
			}
			else
			{
				$last_post_subject = $last_post_subject_truncated = '';
			}
			$last_post_time = $mx_user->format_date($row['forum_last_post_time']);
			$last_post_url = mx3_append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . $row['forum_id_last_post'] . '&amp;p=' . $row['forum_last_post_id']) . '#p' . $row['forum_last_post_id'];
		}
		else
		{
			$last_post_subject = $last_post_time = $last_post_url = $last_post_subject_truncated = '';
		}

		// Output moderator listing ... if applicable
		$l_moderator = $moderators_list = '';
		if ($display_moderators && !empty($forum_moderators[$forum_id]))
		{
			$l_moderator = (count($forum_moderators[$forum_id]) == 1) ? $mx_user->lang['MODERATOR'] : $mx_user->lang['MODERATORS'];
			$moderators_list = implode($mx_user->lang['COMMA_SEPARATOR'], $forum_moderators[$forum_id]);
		}

		$l_post_click_count = ($row['forum_type'] == FORUM_LINK) ? 'CLICKS' : 'POSTS';
		$post_click_count = ($row['forum_type'] != FORUM_LINK || $row['forum_flags'] & FORUM_FLAG_LINK_TRACK) ? $row['forum_posts'] : '';

		$s_subforums_list = $subforums_row = array();
		foreach ($subforums_list as $subforum)
		{
			$s_subforums_list[] = '<a href="' . $subforum['link'] . '" class="subforum ' . (($subforum['unread']) ? 'unread' : 'read') . '" title="' . (($subforum['unread']) ? $mx_user->lang['UNREAD_POSTS'] : $mx_user->lang['NO_UNREAD_POSTS']) . '">' . $subforum['name'] . '</a>';
			$subforums_row[] = array(
				'U_SUBFORUM'	=> $subforum['link'],
				'SUBFORUM_NAME'	=> $subforum['name'],
				'S_UNREAD'		=> $subforum['unread'],
				'IS_LINK'		=> $subforum['type'] == FORUM_LINK,
			);
		}
		$s_subforums_list = (string) implode($mx_user->lang['COMMA_SEPARATOR'], $s_subforums_list);
		$catless = ($row['parent_id'] == $root_data['forum_id']) ? true : false;

		if ($row['forum_type'] != FORUM_LINK)
		{
			$u_viewforum = mx3_append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $row['forum_id']);
		}
		else
		{
			// If the forum is a link and we count redirects we need to visit it
			// If the forum is having a password or no read access we do not expose the link, but instead handle it in viewforum
			if (($row['forum_flags'] & FORUM_FLAG_LINK_TRACK) || $row['forum_password'] || !$phpbb_auth->acl_get('f_read', $forum_id))
			{
				$u_viewforum = mx3_append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $row['forum_id']);
			}
			else
			{
				$u_viewforum = $row['forum_link'];
			}
		}
		
		//
		//This was someting that MX-Publisher template system didn't supported so S_LAST_CAT was introduced fom S_NO_CAT
		//The template shold be changed allso ;)
		//
		$forum_row = array(
			'S_IS_CAT'			=> false,
			'S_LAST_CAT'		=> $last_catless,
			'S_NO_CAT'			=> $catless && !$last_catless,
			'S_IS_LINK'			=> ($row['forum_type'] == FORUM_LINK) ? true : false,
			'S_UNREAD_FORUM'	=> $forum_unread,
			'S_AUTH_READ'		=> $phpbb_auth->acl_get('f_read', $row['forum_id']),
			'S_LOCKED_FORUM'	=> ($row['forum_status'] == ITEM_LOCKED) ? true : false,
			'S_LIST_SUBFORUMS'	=> ($row['display_subforum_list']) ? true : false,
			'S_SUBFORUMS'		=> (count($subforums_list)) ? true : false,
			'S_DISPLAY_SUBJECT'	=>	($last_post_subject !== '' && $board_config['display_last_subject']) ? true : false,
			//'S_FEED_ENABLED'	=> ($board_config['feed_forum'] && !phpbb_optionget(FORUM_OPTION_FEED_EXCLUDE, $row['forum_options']) && $row['forum_type'] == FORUM_POST) ? true : false,

			'FORUM_ID'				=> $row['forum_id'],
			'FORUM_NAME'			=> $row['forum_name'],
			'FORUM_DESC'			=> mx_generate_text_for_display($row['forum_desc'], $row['forum_desc_uid'], $row['forum_desc_bitfield'], $row['forum_desc_options']),
			'TOPICS'				=> $row['forum_topics'],
			$l_post_click_count		=> $post_click_count,
			'FORUM_IMG_STYLE'		=> $folder_image,
			'FORUM_FOLDER_IMG'		=> $mx_user->img($folder_image, $folder_alt),
			'FORUM_FOLDER_IMG_ALT'	=> isset($mx_user->lang[$folder_alt]) ? $mx_user->lang[$folder_alt] : '',
			'FORUM_IMAGE'			=> ($row['forum_image']) ? '<img src="' . $phpbb_root_path . $row['forum_image'] . '" alt="' . $mx_user->lang[$folder_alt] . '" />' : '',
			'FORUM_IMAGE_SRC'		=> ($row['forum_image']) ? $phpbb_root_path . $row['forum_image'] : '',
			'LAST_POST_SUBJECT'		=> $last_post_subject,
			'LAST_POST_SUBJECT_TRUNCATED'	=> $last_post_subject_truncated,
			'LAST_POST_TIME'		=> $last_post_time,
			'LAST_POSTER'			=> mx_get_username_string('username', $row['forum_last_poster_id'], $row['forum_last_poster_name'], $row['forum_last_poster_colour']),
			'LAST_POSTER_COLOUR'	=> mx_get_username_string('colour', $row['forum_last_poster_id'], $row['forum_last_poster_name'], $row['forum_last_poster_colour']),
			'LAST_POSTER_FULL'		=> mx_get_username_string('full', $row['forum_last_poster_id'], $row['forum_last_poster_name'], $row['forum_last_poster_colour']),
			'MODERATORS'			=> $moderators_list,
			'SUBFORUMS'				=> $s_subforums_list,

			'L_SUBFORUM_STR'		=> $l_subforums,
			'L_FORUM_FOLDER_ALT'	=> $folder_alt,
			'L_MODERATOR_STR'		=> $l_moderator,

			'U_UNAPPROVED_TOPICS'	=> ($row['forum_id_unapproved_topics']) ? mx3_append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=queue&amp;mode=unapproved_topics&amp;f=' . $row['forum_id_unapproved_topics']) : '',
			'U_UNAPPROVED_POSTS'	=> ($row['forum_id_unapproved_posts']) ? mx3_append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=queue&amp;mode=unapproved_posts&amp;f=' . $row['forum_id_unapproved_posts']) : '',
			'U_VIEWFORUM'		=> $u_viewforum,
			'U_LAST_POSTER'		=> mx_get_username_string('profile', $row['forum_last_poster_id'], $row['forum_last_poster_name'], $row['forum_last_poster_colour']),
			'U_LAST_POST'		=> $last_post_url,
		);

		$template->assign_block_vars('forumrow', $forum_row);

		// Assign subforums loop for style authors
		$template->assign_block_vars_array('forumrow.subforum', $subforums_row);

		$last_catless = $catless;
	}

	$template->assign_vars(array(
		'U_MARK_FORUMS'		=> ($mx_user->data['is_registered'] || $board_config['load_anon_lastread']) ? mx3_append_sid("{$phpbb_root_path}viewforum.$phpEx", 'hash=' . mx_generate_link_hash('global') . '&amp;f=' . $root_data['forum_id'] . '&amp;mark=forums&amp;mark_time=' . time()) : '',
		'S_HAS_SUBFORUM'	=> ($visible_forums) ? true : false,
		'L_SUBFORUM'		=> ($visible_forums == 1) ? $mx_user->lang['SUBFORUM'] : $mx_user->lang['SUBFORUMS'],
		'LAST_POST_IMG'		=> $mx_user->img('icon_topic_latest', 'VIEW_LATEST_POST'),
		'UNAPPROVED_IMG'	=> $mx_user->img('icon_topic_unapproved', 'TOPICS_UNAPPROVED'),
		'UNAPPROVED_POST_IMG'	=> $mx_user->img('icon_topic_unapproved', 'POSTS_UNAPPROVED_FORUM'),
	));

	if ($return_moderators)
	{
		return array($active_forum_ary, $forum_moderators);
	}

	return array($active_forum_ary, array());
}


/**
* Create forum rules for given forum
*/
function mx_generate_forum_rules(&$forum_data)
{
	if (!$forum_data['forum_rules'] && !$forum_data['forum_rules_link'])
	{
		return;
	}

	global $template, $phpbb_root_path, $mx_root_path, $phpEx;

	if ($forum_data['forum_rules'])
	{
		$forum_data['forum_rules'] = mx_generate_text_for_display($forum_data['forum_rules'], $forum_data['forum_rules_uid'], $forum_data['forum_rules_bitfield'], $forum_data['forum_rules_options']);
	}

	$template->assign_vars(array(
		'S_FORUM_RULES'	=> true,
		'U_FORUM_RULES'	=> $forum_data['forum_rules_link'],
		'FORUM_RULES'	=> $forum_data['forum_rules'])
	);
}

/**
* Create forum navigation links for given forum, create parent
* list if currently null, assign basic forum info to template
*/
function mx_generate_forum_nav(&$forum_data)
{
	global $db, $mx_user, $template, $phpbb_auth;
	global $phpEx, $phpbb_root_path, $mx_root_path;

	if (!$phpbb_auth->acl_get('f_list', $forum_data['forum_id']))
	{
		return;
	}

	// Get forum parents
	$forum_parents = mx_get_forum_parents($forum_data);

	// Build navigation links
	if (!empty($forum_parents))
	{
		foreach ($forum_parents as $parent_forum_id => $parent_data)
		{
			list($parent_name, $parent_type) = array_values($parent_data);

			// Skip this parent if the user does not have the permission to view it
			if (!$phpbb_auth->acl_get('f_list', $parent_forum_id))
			{
				continue;
			}

			$template->assign_block_vars('navlinks', array(
				'S_IS_CAT'		=> ($parent_type == FORUM_CAT) ? true : false,
				'S_IS_LINK'		=> ($parent_type == FORUM_LINK) ? true : false,
				'S_IS_POST'		=> ($parent_type == FORUM_POST) ? true : false,
				'FORUM_NAME'	=> $parent_name,
				'FORUM_ID'		=> $parent_forum_id,
				'U_VIEW_FORUM'	=> mx3_append_sid(PHPBB_URL . "viewforum.$phpEx", 'f=' . $parent_forum_id))
			);
		}
	}

	$template->assign_block_vars('navlinks', array(
		'S_IS_CAT'		=> ($forum_data['forum_type'] == FORUM_CAT) ? true : false,
		'S_IS_LINK'		=> ($forum_data['forum_type'] == FORUM_LINK) ? true : false,
		'S_IS_POST'		=> ($forum_data['forum_type'] == FORUM_POST) ? true : false,
		'FORUM_NAME'	=> $forum_data['forum_name'],
		'FORUM_ID'		=> $forum_data['forum_id'],
		'U_VIEW_FORUM'	=> mx3_append_sid(PHPBB_URL . "viewforum.$phpEx", 'f=' . $forum_data['forum_id']))
	);

	$template->assign_vars(array(
		'FORUM_ID' 		=> $forum_data['forum_id'],
		'FORUM_NAME'	=> $forum_data['forum_name'],
		'FORUM_DESC'	=> mx_generate_text_for_display($forum_data['forum_desc'], $forum_data['forum_desc_uid'], $forum_data['forum_desc_bitfield'], $forum_data['forum_desc_options']))
	);

	return;
}

/**
* Returns forum parents as an array. Get them from forum_data if available, or update the database otherwise
*/
function mx_get_forum_parents(&$forum_data)
{
	global $db;

	$forum_parents = array();

	if ($forum_data['parent_id'] > 0)
	{
		if ($forum_data['forum_parents'] == '')
		{
			$sql = 'SELECT forum_id, forum_name, forum_type
				FROM ' . FORUMS_TABLE . '
				WHERE left_id < ' . $forum_data['left_id'] . '
					AND right_id > ' . $forum_data['right_id'] . '
				ORDER BY left_id ASC';
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
			}
			
			while ($row = $db->sql_fetchrow($result))
			{
				$forum_parents[$row['forum_id']] = array($row['forum_name'], (int) $row['forum_type']);
			}
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
			}

			$forum_data['forum_parents'] = serialize($forum_parents);

			$sql = 'UPDATE ' . FORUMS_TABLE . "
				SET forum_parents = '" . $db->sql_escape($forum_data['forum_parents']) . "'
				WHERE parent_id = " . $forum_data['parent_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not update forums information', '', __LINE__, __FILE__, $sql);
				}
		}
		else
		{
			$forum_parents = unserialize($forum_data['forum_parents']);
		}
	}

	return $forum_parents;
}

/**
* Generate topic pagination
*/
function mx_topic_generate_pagination($replies, $url)
{
	global $board_config, $mx_user;

	// Make sure $per_page is a valid value
	$per_page = ($board_config['posts_per_page'] <= 0) ? 1 : $board_config['posts_per_page'];

	if (($replies + 1) > $per_page)
	{
		$total_pages = ceil(($replies + 1) / $per_page);
		$pagination = '';

		$times = 1;
		for ($j = 0; $j < $replies + 1; $j += $per_page)
		{
			$pagination .= '<a href="' . $url . '&amp;start=' . $j . '">' . $times . '</a>';
			if ($times == 1 && $total_pages > 5)
			{
				$pagination .= ' ... ';

				// Display the last three pages
				$times = $total_pages - 3;
				$j += ($total_pages - 4) * $per_page;
			}
			else if ($times < $total_pages)
			{
				$pagination .= '<span class="page-sep">' . $mx_user->lang['COMMA_SEPARATOR'] . '</span>';
			}
			$times++;
		}
	}
	else
	{
		$pagination = '';
	}

	return $pagination;
}

/**
* Obtain list of moderators of each forum
*/
function mx_get_moderators(&$forum_moderators, $forum_id = false)
{
	global $board_config, $template, $db, $phpbb_root_path, $phpEx;

	// Have we disabled the display of moderators? If so, then return
	// from whence we came ...
	if (!$board_config['load_moderators'])
	{
		return;
	}

	$forum_sql = '';

	if ($forum_id !== false)
	{
		if (!is_array($forum_id))
		{
			$forum_id = array($forum_id);
		}

		// If we don't have a forum then we can't have a moderator
		if (!sizeof($forum_id))
		{
			return;
		}

		$forum_sql = 'AND m.' . $db->sql_in_set('forum_id', $forum_id);
	}

	$sql_array = array(
		'SELECT'	=> 'm.*, u.user_colour, g.group_colour, g.group_type',

		'FROM'		=> array(
			MODERATOR_CACHE_TABLE	=> 'm',
		),

		'LEFT_JOIN'	=> array(
			array(
				'FROM'	=> array(USERS_TABLE => 'u'),
				'ON'	=> 'm.user_id = u.user_id',
			),
			array(
				'FROM'	=> array(GROUPS_TABLE => 'g'),
				'ON'	=> 'm.group_id = g.group_id',
			),
		),

		'WHERE'		=> "m.display_on_index = 1 $forum_sql",
	);

	$sql = $db->sql_build_query('SELECT', $sql_array);
	$result = $db->sql_query($sql, 3600);

	while ($row = $db->sql_fetchrow($result))
	{
		if (!empty($row['user_id']))
		{
			$forum_moderators[$row['forum_id']][] = mx_get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
		}
		else
		{
			$forum_moderators[$row['forum_id']][] = '<a' . (($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . ';"' : '') . ' href="' . mx3_append_sid(PHPBB_URL . "memberlist.$phpEx", 'mode=group&amp;g=' . $row['group_id']) . '">' . (($row['group_type'] == GROUP_SPECIAL) ? $mx_user->lang['G_' . $row['group_name']] : $row['group_name']) . '</a>';
		}
	}
	$db->sql_freeresult($result);

	return;
}

/**
* User authorisation levels output
*
* @param	string	$mode			Can be forum or topic. Not in use at the moment.
* @param	int		$forum_id		The current forum the user is in.
* @param	int		$forum_status	The forums status bit.
*/
function mx_gen_forum_auth_level($mode, $forum_id, $forum_status)
{
	global $template, $phpbb_auth, $mx_user, $board_config;

	$locked = ($forum_status == ITEM_LOCKED && !$phpbb_auth->acl_get('m_edit', $forum_id)) ? true : false;

	$rules = array(
		($phpbb_auth->acl_get('f_post', $forum_id) && !$locked) ? $mx_user->lang['RULES_POST_CAN'] : $mx_user->lang['RULES_POST_CANNOT'],
		($phpbb_auth->acl_get('f_reply', $forum_id) && !$locked) ? $mx_user->lang['RULES_REPLY_CAN'] : $mx_user->lang['RULES_REPLY_CANNOT'],
		($mx_user->data['is_registered'] && $phpbb_auth->acl_gets('f_edit', 'm_edit', $forum_id) && !$locked) ? $mx_user->lang['RULES_EDIT_CAN'] : $mx_user->lang['RULES_EDIT_CANNOT'],
		($mx_user->data['is_registered'] && $phpbb_auth->acl_gets('f_delete', 'm_delete', $forum_id) && !$locked) ? $mx_user->lang['RULES_DELETE_CAN'] : $mx_user->lang['RULES_DELETE_CANNOT'],
	);

	if ($board_config['allow_attachments'])
	{
		$rules[] = ($phpbb_auth->acl_get('f_attach', $forum_id) && $phpbb_auth->acl_get('u_attach') && !$locked) ? $mx_user->lang['RULES_ATTACH_CAN'] : $mx_user->lang['RULES_ATTACH_CANNOT'];
	}

	foreach ($rules as $rule)
	{
		$template->assign_block_vars('rules', array('RULE' => $rule));
	}

	return;
}

/**
* Generate topic status
*/
function mx_topic_status(&$topic_row, $replies, $unread_topic, &$folder_img, &$folder_alt, &$topic_type)
{
	global $mx_user, $board_config;

	$folder = $folder_new = '';

	if ($topic_row['topic_status'] == ITEM_MOVED)
	{
		$topic_type = $mx_user->lang['VIEW_TOPIC_MOVED'];
		$folder_img = 'topic_moved';
		$folder_alt = 'TOPIC_MOVED';
	}
	else
	{
		switch ($topic_row['topic_type'])
		{
			case POST_GLOBAL:
				$topic_type = $mx_user->lang['VIEW_TOPIC_GLOBAL'];
				$folder = 'global_read';
				$folder_new = 'global_unread';
			break;

			case POST_ANNOUNCE:
				$topic_type = $mx_user->lang['VIEW_TOPIC_ANNOUNCEMENT'];
				$folder = 'announce_read';
				$folder_new = 'announce_unread';
			break;

			case POST_STICKY:
				$topic_type = $mx_user->lang['VIEW_TOPIC_STICKY'];
				$folder = 'sticky_read';
				$folder_new = 'sticky_unread';
			break;

			default:
				$topic_type = '';
				$folder = 'topic_read';
				$folder_new = 'topic_unread';

				if ($board_config['hot_threshold'] && $replies >= $board_config['hot_threshold'] && $topic_row['topic_status'] != ITEM_LOCKED)
				{
					$folder .= '_hot';
					$folder_new .= '_hot';
				}
			break;
		}

		if ($topic_row['topic_status'] == ITEM_LOCKED)
		{
			$topic_type = $mx_user->lang['VIEW_TOPIC_LOCKED'];
			$folder .= '_locked';
			$folder_new .= '_locked';
		}


		$folder_img = ($unread_topic) ? $folder_new : $folder;
		$folder_alt = ($unread_topic) ? 'NEW_POSTS' : (($topic_row['topic_status'] == ITEM_LOCKED) ? 'TOPIC_LOCKED' : 'NO_NEW_POSTS');

		// Posted image?
		if (!empty($topic_row['topic_posted']) && $topic_row['topic_posted'])
		{
			$folder_img .= '_mine';
		}
	}

	if ($topic_row['poll_start'] && $topic_row['topic_status'] != ITEM_MOVED)
	{
		$topic_type = $mx_user->lang['VIEW_TOPIC_POLL'];
	}
}

/**
* Assign/Build custom bbcodes for display in screens supporting using of bbcodes
* The custom bbcodes buttons will be placed within the template block 'custom_codes'
*/
function mx_display_custom_bbcodes()
{
	global $db, $template;

	// Start counting from 22 for the bbcode ids (every bbcode takes two ids - opening/closing)
	$num_predefined_bbcodes = 22;

	$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
		FROM ' . BBCODES_TABLE . '
		WHERE display_on_posting = 1
		ORDER BY bbcode_tag';
	if ( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not query bbcode information', '', __LINE__, __FILE__, $sql);
	}

	$i = 0;
	while ($row = $db->sql_fetchrow($result))
	{
		$template->assign_block_vars('custom_tags', array(
			'BBCODE_NAME'		=> "'[{$row['bbcode_tag']}]', '[/" . str_replace('=', '', $row['bbcode_tag']) . "]'",
			'BBCODE_ID'			=> $num_predefined_bbcodes + ($i * 2),
			'BBCODE_TAG'		=> $row['bbcode_tag'],
			'BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('\&', '\"', '\\\'', '<', '>'), $row['bbcode_helpline']))
		);

		$i++;
	}
	$db->sql_freeresult($result);
}

/**
* Display reasons
*/
function mx_display_reasons($reason_id = 0)
{
	global $db, $mx_user, $template;

	$sql = 'SELECT *
		FROM ' . REPORTS_REASONS_TABLE . '
		ORDER BY reason_order ASC';
	if ( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not query forum reasort information', '', __LINE__, __FILE__, $sql);
	}
	
	while ($row = $db->sql_fetchrow($result))
	{
		// If the reason is defined within the language file, we will use the localized version, else just use the database entry...
		if (isset($mx_user->lang['report_reasons']['TITLE'][strtoupper($row['reason_title'])]) && isset($mx_user->lang['report_reasons']['DESCRIPTION'][strtoupper($row['reason_title'])]))
		{
			$row['reason_description'] = $mx_user->lang['report_reasons']['DESCRIPTION'][strtoupper($row['reason_title'])];
			$row['reason_title'] = $mx_user->lang['report_reasons']['TITLE'][strtoupper($row['reason_title'])];
		}

		$template->assign_block_vars('reason', array(
			'ID'			=> $row['reason_id'],
			'TITLE'			=> $row['reason_title'],
			'DESCRIPTION'	=> $row['reason_description'],
			'S_SELECTED'	=> ($row['reason_id'] == $reason_id) ? true : false)
		);
	}
	$db->sql_freeresult($result);
}

/**
* Display user activity (action forum/topic)
*/
function mx_display_user_activity(&$mx_userdata)
{
	global $phpbb_auth, $template, $db, $mx_user;
	global $phpbb_root_path, $phpEx;

	// Do not display user activity for users having more than 5000 posts...
	if ($mx_userdata['user_posts'] > 5000)
	{
		return;
	}

	$forum_ary = array();

	// Do not include those forums the user is not having read access to...
	$forum_read_ary = $phpbb_auth->acl_getf('!f_read');

	foreach ($forum_read_ary as $forum_id => $not_allowed)
	{
		if ($not_allowed['f_read'])
		{
			$forum_ary[] = (int) $forum_id;
		}
	}

	$forum_ary = array_unique($forum_ary);
	$forum_sql = (sizeof($forum_ary)) ? 'AND ' . $db->sql_in_set('forum_id', $forum_ary, true) : '';

	// Obtain active forum
	$sql = 'SELECT forum_id, COUNT(post_id) AS num_posts
		FROM ' . POSTS_TABLE . '
		WHERE poster_id = ' . $mx_userdata['user_id'] . "
			AND post_postcount = 1
			$forum_sql
		GROUP BY forum_id
		ORDER BY num_posts DESC";
	$result = $db->sql_query_limit($sql, 1);
	$active_f_row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if (!empty($active_f_row))
	{
		$sql = 'SELECT forum_name
			FROM ' . FORUMS_TABLE . '
			WHERE forum_id = ' . $active_f_row['forum_id'];
		$result = $db->sql_query($sql, 3600);
		$active_f_row['forum_name'] = (string) $db->sql_fetchfield('forum_name');
		$db->sql_freeresult($result);
	}

	// Obtain active topic
	$sql = 'SELECT topic_id, COUNT(post_id) AS num_posts
		FROM ' . POSTS_TABLE . '
		WHERE poster_id = ' . $mx_userdata['user_id'] . "
			AND post_postcount = 1
			$forum_sql
		GROUP BY topic_id
		ORDER BY num_posts DESC";
	$result = $db->sql_query_limit($sql, 1);
	$active_t_row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if (!empty($active_t_row))
	{
		$sql = 'SELECT topic_title
			FROM ' . TOPICS_TABLE . '
			WHERE topic_id = ' . $active_t_row['topic_id'];
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, 'Could not query topic information', '', __LINE__, __FILE__, $sql);
		}
		$active_t_row['topic_title'] = (string) $db->sql_fetchfield('topic_title');
		$db->sql_freeresult($result);
	}

	$mx_userdata['active_t_row'] = $active_t_row;
	$mx_userdata['active_f_row'] = $active_f_row;

	$active_f_name = $active_f_id = $active_f_count = $active_f_pct = '';
	if (!empty($active_f_row['num_posts']))
	{
		$active_f_name = $active_f_row['forum_name'];
		$active_f_id = $active_f_row['forum_id'];
		$active_f_count = $active_f_row['num_posts'];
		$active_f_pct = ($mx_userdata['user_posts']) ? ($active_f_count / $mx_userdata['user_posts']) * 100 : 0;
	}

	$active_t_name = $active_t_id = $active_t_count = $active_t_pct = '';
	if (!empty($active_t_row['num_posts']))
	{
		$active_t_name = $active_t_row['topic_title'];
		$active_t_id = $active_t_row['topic_id'];
		$active_t_count = $active_t_row['num_posts'];
		$active_t_pct = ($mx_userdata['user_posts']) ? ($active_t_count / $mx_userdata['user_posts']) * 100 : 0;
	}

	$l_active_pct = ($mx_userdata['user_id'] != ANONYMOUS && $mx_userdata['user_id'] == $mx_user->data['user_id']) ? $mx_user->lang['POST_PCT_ACTIVE_OWN'] : $mx_user->lang['POST_PCT_ACTIVE'];

	$template->assign_vars(array(
		'ACTIVE_FORUM'			=> $active_f_name,
		'ACTIVE_FORUM_POSTS'	=> ($active_f_count == 1) ? sprintf($mx_user->lang['USER_POST'], 1) : sprintf($mx_user->lang['USER_POSTS'], $active_f_count),
		'ACTIVE_FORUM_PCT'		=> sprintf($l_active_pct, $active_f_pct),
		'ACTIVE_TOPIC'			=> phpBB3::censor_text($active_t_name),
		'ACTIVE_TOPIC_POSTS'	=> ($active_t_count == 1) ? sprintf($mx_user->lang['USER_POST'], 1) : sprintf($mx_user->lang['USER_POSTS'], $active_t_count),
		'ACTIVE_TOPIC_PCT'		=> sprintf($l_active_pct, $active_t_pct),
		'U_ACTIVE_FORUM'		=> mx3_append_sid(PHPBB_URL . "viewforum.$phpEx", 'f=' . $active_f_id),
		'U_ACTIVE_TOPIC'		=> mx3_append_sid(PHPBB_URL . "viewtopic.$phpEx", 't=' . $active_t_id),
		'S_SHOW_ACTIVITY'		=> true)
	);
}

/**
* Topic and forum watching common code
*/
function mx_watch_topic_forum_old($mode, &$s_watching, &$s_watching_img, $mx_user_id, $forum_id, $topic_id, $notify_status = 'unset', $start = 0)
{
	global $template, $db, $mx_user, $phpEx, $start, $phpbb_root_path;

	$table_sql = ($mode == 'forum') ? FORUMS_WATCH_TABLE : TOPICS_WATCH_TABLE;
	$where_sql = ($mode == 'forum') ? 'forum_id' : 'topic_id';
	$match_id = ($mode == 'forum') ? $forum_id : $topic_id;

	$u_url = ($mode == 'forum') ? 'f' : 'f=' . $forum_id . '&amp;t';

	// Is user watching this thread?
	if ($mx_user_id != ANONYMOUS)
	{
		$can_watch = true;

		if ($notify_status == 'unset')
		{
			$sql = "SELECT notify_status
				FROM $table_sql
				WHERE $where_sql = $match_id
					AND user_id = $mx_user_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not query user notify status', '', __LINE__, __FILE__, $sql);
			}

			$notify_status = ($row = $db->sql_fetchrow($result)) ? $row['notify_status'] : NULL;
			$db->sql_freeresult($result);
		}

		if (!is_null($notify_status))
		{
			if (isset($_GET['unwatch']))
			{
				if ($_GET['unwatch'] == $mode)
				{
					$is_watching = 0;

					$sql = 'DELETE FROM ' . $table_sql . "
						WHERE $where_sql = $match_id
							AND user_id = $mx_user_id";

					if ( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not update unwatch notify status', '', __LINE__, __FILE__, $sql);
					}
				}

				$redirect_url = mx3_append_sid(PHPBB_URL . "view$mode.$phpEx", "$u_url=$match_id&amp;start=$start");

				meta_refresh(3, $redirect_url);

				$message = $mx_user->lang['NOT_WATCHING_' . strtoupper($mode)] . '<br /><br />' . sprintf($mx_user->lang['RETURN_' . strtoupper($mode)], '<a href="' . $redirect_url . '">', '</a>');
				trigger_error($message);
			}
			else
			{
				$is_watching = true;

				if ($notify_status)
				{
					$sql = 'UPDATE ' . $table_sql . "
						SET notify_status = 0
						WHERE $where_sql = $match_id
							AND user_id = $mx_user_id";
					if ( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not update watching notify status', '', __LINE__, __FILE__, $sql);
					}
				}
			}
		}
		else
		{
			if (isset($_GET['watch']))
			{
				if ($_GET['watch'] == $mode)
				{
					$is_watching = true;

					$sql = 'INSERT INTO ' . $table_sql . " (user_id, $where_sql, notify_status)
						VALUES ($mx_user_id, $match_id, 0)";
					if ( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not innsert user watching status', '', __LINE__, __FILE__, $sql);
					}
				}

				$redirect_url = mx3_append_sid(PHPBB_URL . "view$mode.$phpEx", "$u_url=$match_id&amp;start=$start");
				meta_refresh(3, $redirect_url);

				$message = $mx_user->lang['ARE_WATCHING_' . strtoupper($mode)] . '<br /><br />' . sprintf($mx_user->lang['RETURN_' . strtoupper($mode)], '<a href="' . $redirect_url . '">', '</a>');
				trigger_error($message);
			}
			else
			{
				$is_watching = 0;
			}
		}
	}
	else
	{
		if (isset($_GET['unwatch']) && $_GET['unwatch'] == $mode)
		{
			login_box();
		}
		else
		{
			$can_watch = 0;
			$is_watching = 0;
		}
	}

	if ($can_watch)
	{
		$s_watching['link'] = mx3_append_sid(PHPBB_URL . "view$mode.$phpEx", "$u_url=$match_id&amp;" . (($is_watching) ? 'unwatch' : 'watch') . "=$mode&amp;start=$start");
		$s_watching['title'] = $mx_user->lang[(($is_watching) ? 'STOP' : 'START') . '_WATCHING_' . strtoupper($mode)];
		$s_watching['is_watching'] = $is_watching;
	}

	return;
}

/**
* Topic and forum watching common code
*/
function mx_watch_topic_forum($mode, &$s_watching, $user_id, $forum_id, $topic_id, $notify_status = 'unset', $start = 0)
{
	global $template, $db, $mx_user, $phpEx, $start, $phpbb_root_path;

	$table_sql = ($mode == 'forum') ? FORUMS_WATCH_TABLE : TOPICS_WATCH_TABLE;
	$where_sql = ($mode == 'forum') ? 'forum_id' : 'topic_id';
	$match_id = ($mode == 'forum') ? $forum_id : $topic_id;

	$u_url = ($mode == 'forum') ? 'f' : 'f=' . $forum_id . '&amp;t';

	// Is user watching this thread?
	if ($user_id != ANONYMOUS)
	{
		$can_watch = true;

		if ($notify_status == 'unset')
		{
			$sql = "SELECT notify_status
				FROM $table_sql
				WHERE $where_sql = $match_id
					AND user_id = $user_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not query user notify status', '', __LINE__, __FILE__, $sql);
			}

			$notify_status = ($row = $db->sql_fetchrow($result)) ? $row['notify_status'] : NULL;
			$db->sql_freeresult($result);
		}

		if (!is_null($notify_status) && $notify_status !== '')
		{
			if (isset($_GET['unwatch']))
			{
				if ($_GET['unwatch'] == $mode)
				{
					$is_watching = 0;

					$sql = 'DELETE FROM ' . $table_sql . "
						WHERE $where_sql = $match_id
							AND user_id = $user_id";
					if ( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not query unwatch status', '', __LINE__, __FILE__, $sql);
					}
				}

				$redirect_url = mx3_append_sid(PHPBB_URL . "view$mode.$phpEx", "$u_url=$match_id&amp;start=$start");

				meta_refresh(3, $redirect_url);

				$message = $mx_user->lang['NOT_WATCHING_' . strtoupper($mode)] . '<br /><br />' . sprintf($mx_user->lang['RETURN_' . strtoupper($mode)], '<a href="' . $redirect_url . '">', '</a>');
				trigger_error($message);
			}
			else
			{
				$is_watching = true;

				if ($notify_status)
				{
					$sql = 'UPDATE ' . $table_sql . "
						SET notify_status = 0
						WHERE $where_sql = $match_id
							AND user_id = $user_id";
					if ( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not query user notify status', '', __LINE__, __FILE__, $sql);
					}
				}
			}
		}
		else
		{
			if (isset($_GET['watch']))
			{
				if ($_GET['watch'] == $mode)
				{
					$is_watching = true;

					$sql = 'INSERT INTO ' . $table_sql . " (user_id, $where_sql, notify_status)
						VALUES ($user_id, $match_id, 0)";
					if ( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not query user notify status', '', __LINE__, __FILE__, $sql);
					}
				}

				$redirect_url = mx3_append_sid(PHPBB_URL . "view$mode.$phpEx", "$u_url=$match_id&amp;start=$start");
				meta_refresh(3, $redirect_url);

				$message = $mx_user->lang['ARE_WATCHING_' . strtoupper($mode)] . '<br /><br />' . sprintf($mx_user->lang['RETURN_' . strtoupper($mode)], '<a href="' . $redirect_url . '">', '</a>');
				trigger_error($message);
			}
			else
			{
				$is_watching = 0;
			}
		}
	}
	else
	{
		if (isset($_GET['unwatch']) && $_GET['unwatch'] == $mode)
		{
			login_box();
		}
		else
		{
			$can_watch = 0;
			$is_watching = 0;
		}
	}

	if ($can_watch)
	{
		$s_watching['link'] = mx3_append_sid(PHPBB_URL . "view$mode.$phpEx", "$u_url=$match_id&amp;" . (($is_watching) ? 'unwatch' : 'watch') . "=$mode&amp;start=$start");
		$s_watching['title'] = $mx_user->lang[(($is_watching) ? 'STOP' : 'START') . '_WATCHING_' . strtoupper($mode)];
		$s_watching['is_watching'] = $is_watching;
	}

	return;
}

/**
* Get user rank title and image
*
* @param int $user_rank the current stored users rank id
* @param int $mx_user_posts the users number of posts
* @param string &$rank_title the rank title will be stored here after execution
* @param string &$rank_img the rank image as full img tag is stored here after execution
* @param string &$rank_img_src the rank image source is stored here after execution
*
*/
function mx3_get_user_rank($user_rank, $user_posts, &$rank_title, &$rank_img, &$rank_img_src)
{
	global $ranks, $board_config;

	if (empty($ranks))
	{
		global $mx_backend;
		$ranks = $mx_backend->obtain_ranks();
	}

	if (!empty($user_rank))
	{
		$rank_title = (isset($ranks['special'][$user_rank]['rank_title'])) ? $ranks['special'][$user_rank]['rank_title'] : '';
		$rank_img = (!empty($ranks['special'][$user_rank]['rank_image'])) ? '<img src="' . $board_config['ranks_path'] . '/' . $ranks['special'][$user_rank]['rank_image'] . '" alt="' . $ranks['special'][$user_rank]['rank_title'] . '" title="' . $ranks['special'][$user_rank]['rank_title'] . '" />' : '';
		$rank_img_src = (!empty($ranks['special'][$user_rank]['rank_image'])) ? $board_config['ranks_path'] . '/' . $ranks['special'][$user_rank]['rank_image'] : '';
	}
	else
	{
		if (!empty($ranks['normal']))
		{
			foreach ($ranks['normal'] as $rank)
			{
				if ($user_posts >= $rank['rank_min'])
				{
					$rank_title = $rank['rank_title'];
					$rank_img = (!empty($rank['rank_image'])) ? '<img src="' . $board_config['ranks_path'] . '/' . $rank['rank_image'] . '" alt="' . $rank['rank_title'] . '" title="' . $rank['rank_title'] . '" />' : '';
					$rank_img_src = (!empty($rank['rank_image'])) ? $board_config['ranks_path'] . '/' . $rank['rank_image'] : '';
					break;
				}
			}
		}
	}
}

/**
* Get user avatar
*
* @param string $avatar Users assigned avatar name
* @param int $avatar_type Type of avatar
* @param string $avatar_width Width of users avatar
* @param string $avatar_height Height of users avatar
* @param string $alt Optional language string for alt tag within image, can be a language key or text
*
* @return string Avatar image
*/
function mx3_get_user_avatar($avatar, $avatar_type, $avatar_width, $avatar_height, $alt = 'USER_AVATAR')
{
	global $mx_user, $board_config, $phpbb_root_path, $phpEx;

	if (empty($avatar) || !$avatar_type)
	{
		return '';
	}

	$avatar_img = '';

	switch ($avatar_type)
	{
		case AVATAR_UPLOAD:
			$avatar_img = $phpbb_root_path . "download.$phpEx?avatar=";
		break;

		case AVATAR_GALLERY:
			$avatar_img = $phpbb_root_path . $board_config['avatar_gallery_path'] . '/';
		break;
	}

	$avatar_img .= $avatar;
	return '<img src="' . $avatar_img . '" width="' . $avatar_width . '" height="' . $avatar_height . '" alt="' . ((!empty($mx_user->lang[$alt])) ? $mx_user->lang[$alt] : $alt) . '" />';
}

?>