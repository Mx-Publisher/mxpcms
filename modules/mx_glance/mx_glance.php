<?php 
/**
*
* @package mxBB Portal Module - mx_glance
* @version $Id: mx_glance.php,v 1.23 2013/06/17 16:02:48 orynider Exp $
* @copyright (c) 2001-2007 blulegend, Jack Kan, OryNider
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

//
// ERROR HANDLING
//
//error_reporting( E_ALL );

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

define('IN_RECENT', true);

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];

// Read configuration definition
$recent_use_large = $mx_block->get_parameters( 'Glance_use_large' );

// NEWS FORUM ID
$recent_news_forum_id = $mx_block->get_parameters( 'Glance_news_forum_id' );

// NUMBER OF NEWS ARTICLES YOU WISH TO DISPLAY
$recent_num_news = $mx_block->get_parameters( 'Glance_num_news' );
	
// NUMBER OF RECENT ARTICLES YOU WISH TO DISPLAY
$recent_num_topics = $mx_block->get_parameters( 'Glance_num_recent' );

// FORUMS YOU WISH TO IGNORE IN YOUR RECENT ARTICLES
$recent_forums_ignore = $mx_block->get_parameters( 'Glance_recent_ignore' );
		
// TABLE WIDTH
$block_size = $mx_block->get_parameters( 'Glance_table_width' );
	
// CHANGE THE BULLET IF A TOPIC IS NEW? (true / false)
$recent_show_new_bullets = $mx_block->get_parameters( 'Glance_show_new_bullets' );

// SHOW ADMIN AND MOD WITH COLORS? (true / false)
$recent_show_user_color = $mx_block->get_parameters( 'Glance_show_user_color' );

// SHOW USERS WITH BOLD IF PREVIOUS OPTION IS FALSE? (true / false)
$recent_show_user_bold = $mx_block->get_parameters( 'Glance_show_user_bold' );
	
// MESSAGE TRACKING WILL TRACK TO SEE IF A USER HAS READ THE TOPIC DURING THEIR SESSION (true / false)
$recent_track = $mx_block->get_parameters( 'Glance_track' );
	 
// SHOW TOPICS THE USER CAN VIEW, BUT NOT READ? (true / false)
$recent_auth_read = $mx_block->get_parameters( 'Glance_auth_read' );

// LIMIT THE NUMBER OF CHARACTERS DISPLAYED FOR TOPIC TITLES
$recent_topic_length = $mx_block->get_parameters( 'Glance_title_length' ); 

// Read language definition
$mx_user->extend(MX_LANG_MAIN, MX_IMAGES_NONE); //$mx_user->add_lang('modules/mx_glance');

$mx_user->set_module_default_style('_core'); // For compatibility with core 2.8.x

if (!(PORTAL_BACKEND == 'phpbb3'))
{
	//Images

	$recent_news_bullet_old_src = $images['folder_announce']; //$mx_user->img('announce_read', 'POST_ANNOUNCEMENT'); 
	
	$recent_posts_bullet_old_src = $images['folder']; //$mx_user->img('topic_read', 'NEW_POSTS'); 
	
	$recent_news_bullet_new_src = $images['folder_announce_new']; //$mx_user->img('announce_unread', 'POST_ANNOUNCEMENT'); 
	
	$recent_posts_bullet_new_src = $images['folder_new']; //$mx_user->img('topic_unread', 'NEW_POSTS'); 

	//Images SRC

	$recent_news_bullet_old = '<img src="' . $recent_news_bullet_old_src . '" border="0" width="19" height="18" alt="" title="" />'; //$mx_user->img('announce_read', 'POST_ANNOUNCEMENT', false, '', 'src'); 
	
	$recent_posts_bullet_old = '<img src="' . $recent_posts_bullet_old_src . '" border="0" width="19" height="18" alt="" title="" />'; //$mx_user->img('topic_read', 'NEW_POSTS', false, '', 'src'); 
	
	$recent_news_bullet_new = '<img src="' . $recent_news_bullet_new_src . '" border="0" width="19" height="18" alt="" title="" />'; //$mx_user->img('announce_unread', 'POST_ANNOUNCEMENT', false, '', 'src'); 
	
	$recent_posts_bullet_new = '<img src="' . $recent_posts_bullet_new_src . '" border="0" width="19" height="18" alt="" title="" />'; //$mx_user->img('topic_unread', 'NEW_POSTS', false, '', 'src'); 
}
else
{
	//Images

	$recent_news_bullet_old = $mx_user->img('announce_read', 'POST_ANNOUNCEMENT'); 
	
	$recent_posts_bullet_old = $mx_user->img('topic_read', 'NEW_POSTS'); 
	
	$recent_news_bullet_new = $mx_user->img('announce_unread', 'POST_ANNOUNCEMENT'); 
	
	$recent_posts_bullet_new = $mx_user->img('topic_unread', 'NEW_POSTS'); 

	//Images SRC

	$recent_news_bullet_old_src = $mx_user->img('announce_read', 'POST_ANNOUNCEMENT', false, '', 'src'); 
	
	$recent_posts_bullet_old_src = $mx_user->img('topic_read', 'NEW_POSTS', false, '', 'src'); 
	
	$recent_news_bullet_new_src = $mx_user->img('announce_unread', 'POST_ANNOUNCEMENT', false, '', 'src'); 
	
	$recent_posts_bullet_new_src = $mx_user->img('topic_unread', 'NEW_POSTS', false, '', 'src'); 
}

if ( !defined('PHPBB_URL') )
{
	if (!isset($script_path) || empty($script_path))
	{
		$script_path = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
	}
	if (!isset($server_name) || empty($server_name))
	{
		$server_name = trim($board_config['server_name']);
	}
	if (!isset($server_protocol) || empty($server_protocol))
	{
		$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
	}
	if (!isset($server_port) || empty($server_port))
	{
		$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
	}
	define('PHPBB_URL', $server_protocol . $server_name . $server_port . $script_path . '/');
}

if (!function_exists('this_recent_url'))
{
	function this_recent_url($args = '')
	{
		global $page_id, $phpEx;

		$url = PORTAL_URL . "index.$phpEx";

		if( is_numeric($page_id) && !empty($page_id) )
		{
			$url .= '?page=' . $page_id . ($args == '' ? '' : '&amp;' . $args);
		}
		else
		{
			$url .= '' . ($args == '' ? '' : '?' . $args);
		}

		return $url;
	}
}

/*
if (!function_exists('glance_userdata'))
{
	function glance_userdata($user_id)
	{
		global $db;

		$sql = "SELECT username, user_id, user_level
			FROM ".USERS_TABLE."
			WHERE user_id = ".$user_id."
			ORDER BY username ASC";
		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, 'Could not obtain glance user information', '', __LINE__, __FILE__, $sql);
		}

		while($row = $db->sql_fetchrow($result))
		{
			return $row; 
		}
		$db->sql_freeresult($result);
	}			
}
*/

// GET USER LAST VISIT
$recent_last_visit = $userdata['user_lastvisit']; //$recent_last_visit = $mx_user->data['user_lastvisit'];

$recent_forums_offset = $mx_request_vars->request('recent_posts_offset', MX_TYPE_NO_TAGS, '');
$recent_news_offset = $mx_request_vars->request('recent_news_offset', MX_TYPE_NO_TAGS, '');
	
// MESSAGE TRACKING
// if ( !isset($tracking_topics) && $recent_track ) $tracking_topics = $mx_request_vars->request($board_config['cookie_name'] . '_t', '', false, true);
if ( !isset($tracking_topics) && $recent_track )
{
	$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) : array();
}
else
{
	$tracking_topics = array();
}
	
// CHECK FOR BAD WORDS
// Define censored word matches
if (!(PORTAL_BACKEND == 'phpbb3'))
{
	if ( !function_exists('obtain_word_list') )
	{
		function glance_obtain_word_list(&$orig_word, &$replacement_word)
		{
			global $db;

			// Define censored word matches
			$sql = "SELECT word, replacement
				FROM  " . WORDS_TABLE;
			$result = $db->sql_query($sql);

			if ( $row = $db->sql_fetchrow($result) )
			{
				do 
				{
					$orig_word[] = '#\b(' . str_replace('\*', '\w*?', preg_quote($row['word'], '#')) . ')\b#i';
					$replacement_word[] = $row['replacement'];
				}
				while ($row = $db->sql_fetchrow($result));
			}

			return true;
		}
		$orig_word = array();
		$replacement_word = array();
		glance_obtain_word_list($orig_word, $replacement_word);
	}
	else
	{
		$orig_word = array();
		$replacement_word = array();
		obtain_word_list($orig_word, $replacement_word);
	}
}
else 
{
	$orig_word = array();
	$replacement_word = array();
	$mx_cache->obtain_word_list($orig_word, $replacement_word);
	//censor_text($orig_word);
}

//
// BEGIN OUTPUT
//
$template_tmp = $recent_use_large == 'horizontal' ? array('glance_output' => 'glance_body_big.tpl') : array('glance_output' => 'glance_body.tpl');

$template->set_filenames($template_tmp);
	
// set the topic title sql depending on the character limit
$sql_title = ($recent_topic_length) ? ", LEFT(t.topic_title, " . $recent_topic_length . ") as topic_title" : ", t.topic_title";

// GET THE LATEST NEWS TOPIC
if ($recent_num_news)
{
	$sql_news_limit = $recent_num_news; 

	$sql_news_start = ($recent_news_offset) ? $recent_news_offset : 0;

	$recent_news_forum_id = ($recent_news_forum_id) ? $recent_news_forum_id : 0;

	/*
	$sql = $db->sql_build_query('SELECT', array(
			'SELECT'	=> 'f.forum_id, f.forum_name' . $sql_title . ', t.*, p.post_time, p.poster_id, u.username as last_username, u.username as author_username',

			'FROM'		=> array(
				FORUMS_TABLE	=> 'f',
				POSTS_TABLE	=> 'p',
				TOPICS_TABLE	=> 't',
				USERS_TABLE	=> 'u',
			),

			'WHERE'		=> 'f.forum_id IN (' . $recent_news_forum_id . ')
				AND t.forum_id = f.forum_id
				AND p.post_id = t.topic_first_post_id
				AND t.topic_moved_id = 0
				AND p.poster_id = u.user_id
				AND t.topic_poster = u.user_id',

			'ORDER_BY'	=> 't.topic_last_post_id DESC',

			));
	*/

	$sql = "
		SELECT 
			f.forum_id, f.forum_name" . $sql_title . ", t.*, 
			p2.post_time, p2.poster_id, p2.icon_id, 
			u.username as last_username, 
			u2.username as author_username
		FROM " 
			. FORUMS_TABLE . " f, "
			. POSTS_TABLE . " p, " 
			. TOPICS_TABLE . " t, " 
			. POSTS_TABLE . " p2, " 
			. USERS_TABLE . " u, "
			. USERS_TABLE . " u2				
		WHERE 
			f.forum_id IN (" . $recent_news_forum_id . ") 
			AND t.forum_id = f.forum_id
			AND p.post_id = t.topic_first_post_id
			AND p2.post_id = t.topic_last_post_id
			AND t.topic_moved_id = 0
			AND p2.poster_id = u.user_id
			AND t.topic_poster = u2.user_id
		ORDER BY t.topic_last_post_id DESC";

	if( !($result = $db->sql_query_limit($sql, $sql_news_limit, $sql_news_start)) )
	{
		mx_message_die(GENERAL_ERROR, "Could not query new news information", "", __LINE__, __FILE__, $sql);
	}

	$latest_news = array();

	while ( $topic_row = $db->sql_fetchrow($result) )
	{
		$topic_row['topic_title'] = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_row['topic_title']) : $topic_row['topic_title'];
		$latest_news[] = $topic_row;
	}
	$db->sql_freeresult($result);


       // obtain the total number of topic for our news topic navigation bit
	$sql = "SELECT SUM(forum_topics) as topic_total FROM " . FORUMS_TABLE . " f WHERE f.forum_id IN (" . $recent_news_forum_id . ")";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$overall_news_topics = $row['topic_total'];
	$db->sql_freeresult($result);
}

// GET THE LAST 5 TOPICS

if ($recent_num_topics)
{

	//$sql = "SELECT * FROM " . FORUMS_TABLE . " WHERE forum_id NOT IN (" . $recent_news_forum_id . ")";
	//$result = $db->sql_query($sql);
	
	switch (PORTAL_BACKEND)
	{
		case 'internal':
		case 'phpbb2':
			$recent_auth_level = ($recent_auth_read) ? AUTH_VIEW : AUTH_ALL;
		break;
		case 'phpbb3':
			$recent_auth_level = ($recent_auth_read) ? array('f_read', 'f_list') : true;
		break;
	}
	
	//$recent_auth_level = false; //fix this after class is working
	
	$recentforumsignore = $phpbb_auth->acl_getfignore($recent_auth_level, $recent_news_forum_id);
	$recentforumsignore .= ($recentforumsignore && $recent_forums_ignore) ? ',' : '';

	$sql_forums_limit = $recent_num_topics; 

	$sql_forums_start = ($recent_forums_offset) ? $recent_forums_offset : 0; 

	/*
	$sql = $db->sql_build_query('SELECT', array(
			'SELECT'	=> 'f.forum_id, f.forum_name' . $sql_title . ', t.*, p.post_time, p.poster_id, u.username as last_username, u.username as author_username',

			'FROM'		=> array(
				FORUMS_TABLE	=> 'f',
				POSTS_TABLE	=> 'p',
				TOPICS_TABLE	=> 't',
				USERS_TABLE	=> 'u',
			),

			'WHERE'		=> 'f.forum_id NOT IN (' . $recentforumsignore . $recent_forums_ignore . ') 
				AND t.forum_id = f.forum_id
				AND p.post_id = t.topic_first_post_id
				AND t.topic_moved_id = 0
				AND p.poster_id = u.user_id
				AND t.topic_poster = u.user_id',

			'ORDER_BY'	=> 't.topic_last_post_id DESC',

			));
	*/

	$sql = "
		SELECT 	
			f.forum_id, f.forum_name" . $sql_title . ", t.*,
			p2.post_time, p2.poster_id, 
			u.username as last_username, 
			u2.username as author_username
		FROM " 
			. FORUMS_TABLE . " f, "
			. POSTS_TABLE . " p, " 
			. TOPICS_TABLE . " t, " 
			. POSTS_TABLE . " p2, " 
			. USERS_TABLE . " u, "
			. USERS_TABLE . " u2				
		WHERE 
			f.forum_id NOT IN (" . $recentforumsignore . $recent_forums_ignore . ") 
			AND t.forum_id = f.forum_id
			AND p.post_id = t.topic_first_post_id
			AND p2.post_id = t.topic_last_post_id
			AND t.topic_moved_id = 0
			AND p2.poster_id = u.user_id
			AND t.topic_poster = u2.user_id
		ORDER BY t.topic_last_post_id DESC";

	if( !($result = $db->sql_query_limit($sql, $sql_forums_limit, $sql_forums_start)) )
	{
		mx_message_die(GENERAL_ERROR, "Could not query new news information", "", __LINE__, __FILE__, $sql);
	}

	$latest_topics = array();
	$latest_anns = array();
	$latest_stickys = array();

	while ( $topic_row = $db->sql_fetchrow($result) )
	{
		$topic_row['topic_title'] = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_row['topic_title']) : $topic_row['topic_title'];

		switch ($topic_row['topic_type'])
		{
			case POST_ANNOUNCE:
				$latest_anns[] = $topic_row;
				break;
			case POST_STICKY:
				$latest_stickys[] = $topic_row;
				break;	
			default:
				$latest_topics[] = $topic_row;
				break;
		}
	}
	$latest_topics = array_merge($latest_anns, $latest_stickys, $latest_topics);
	$db->sql_freeresult($result);

	// obtain the total number of topic for our recent topic navigation bit
	$sql = "SELECT SUM(forum_topics) as topic_total FROM " . FORUMS_TABLE . " f WHERE f.forum_id NOT IN (" . $recentforumsignore . $recent_forums_ignore . $recent_news_forum_id . ")";
	$result = $db->sql_query($sql);

	$row = $db->sql_fetchrow($result);
	$overall_total_topics = $row['topic_total'];
	$db->sql_freeresult($result);
}

if ($recent_num_news)
{
	if ( !empty($latest_news) )
	{
		$bullet_pre = 'recent_news_bullet';
			
		for ( $i = 0; $i < count($latest_news); $i++ )
		{
			if ( $userdata['user_id'] != 1 )
			{
				$unread_topics = false;
				$topic_id = $latest_news[$i]['topic_id'];
				if ( $latest_news[$i]['post_time'] > $recent_last_visit )
				{
					$unread_topics = true;
					if( !empty($tracking_topics[$topic_id]) && $recent_track )
					{
						if( $tracking_topics[$topic_id] >= $latest_news[$i]['post_time'] )
						{
							$unread_topics = false;
						}
					}
				}
				$shownew = $unread_topics;
			}
			else
			{
				$unread_topics = false;
				$shownew = true;
			}

			$bullet_full = $bullet_pre . ( ( $shownew && $recent_show_new_bullets ) ? '_new' : '_old' );

			$bullet_src = $bullet_pre . ( ( $shownew && $recent_show_new_bullets ) ? '_new_src' : '_old_src' );

			$newest_code = ( $unread_topics && $recent_show_new_bullets ) ? '&amp;view=newest' : '';

			if ( function_exists( 'create_date' ) )
			{
				$message_date = create_date($board_config['default_dateformat'], $latest_news[$i]['topic_time'], $board_config['board_timezone']);
			}
			else if (PORTAL_BACKEND == 'phpbb3')
			{
				$message_date = $mx_user->format_date($latest_news[$i]['topic_time']);
			}
			else
			{
				$message_date = phpBB2::create_date($board_config['default_dateformat'], $latest_news[$i]['topic_time'], $board_config['board_timezone']);
			}

			if ( function_exists('mx_get_username_string') && (PORTAL_BACKEND == 'phpbb3') )
			{
				$last_poster = mx_get_username_string('username', $latest_news[$i]['topic_last_poster_id'], $latest_news[$i]['topic_last_poster_name'], $latest_news[$i]['topic_last_poster_colour']);
				$last_poster_color = mx_get_username_string('colour', $latest_news[$i]['topic_last_poster_id'], $latest_news[$i]['topic_last_poster_name'], $latest_news[$i]['topic_last_poster_colour']);
				$last_poster_full = mx_get_username_string('full', $latest_news[$i]['topic_last_poster_id'], $latest_news[$i]['topic_last_poster_name'], $latest_news[$i]['topic_last_poster_colour']);

				$topic_poster = mx_get_username_string('username', $latest_news[$i]['topic_poster'], $latest_news[$i]['topic_first_poster_name'], $latest_news[$i]['topic_first_poster_colour']);
				$topic_poster_color = mx_get_username_string('colour', $latest_news[$i]['topic_poster'], $latest_news[$i]['topic_first_poster_name'], $latest_news[$i]['topic_first_poster_colour']);
				$topic_poster_full = mx_get_username_string('full', $latest_news[$i]['topic_poster'], $latest_news[$i]['topic_first_poster_name'], $latest_news[$i]['topic_first_poster_colour']);
				$last_poster_full .= '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?"  . POST_POST_URL . '=' . $latest_news[$i]['topic_last_post_id']) . '#' . $latest_news[$i]['topic_last_post_id'] . '"><img src="' . $mx_user->img('icon_topic_latest', 'VIEW_LATEST_POST', false, '', 'src') . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
			}
			else
			{
				if ($recent_show_user_color)
				{
					$news_last_posterdata = mx_get_userdata($latest_news[$i]['poster_id'], false);

					if ($news_last_posterdata['user_level'] == ADMIN) 
					{ 
						$last_poster_color = $theme['fontcolor3'];
						$last_poster_style = 'style="color:#' . $last_poster_color . '; font-weight : bold;"';  
					} 
					else if ($news_last_posterdata['user_level'] == MOD) 
					{ 
						$last_poster_color = $theme['fontcolor2'];
						$last_poster_style = 'style="color:#' . $last_poster_color . '; font-weight : bold;"';  
					}
					else 
					{ 
						$last_poster_color = '';
						$last_poster_style = 'style="font-weight : bold;"'; 
					}
				}
				else if ($recent_show_user_bold) 
				{ 
					$last_poster_color = '';
					$last_poster_style = 'style="font-weight : bold;"'; 
				}
				else 
				{ 
					$last_poster_color = '';
					$last_poster_style = ''; 
				}

				$last_poster = ($latest_news[$i]['poster_id'] == ANONYMOUS ) ? '<span ' . $last_poster_style . '>' . $lang['Guest'] . '</span>' : '<a href="' . mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $latest_news[$i]['poster_id']) . '"><span ' . $last_poster_style . '>' . $latest_news[$i]['last_username'] . '</span></a> ';
				$last_poster_full = $last_poster . '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?"  . POST_POST_URL . '=' . $latest_news[$i]['topic_last_post_id']) . '#' . $latest_news[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';

				if ($recent_show_user_color)
				{
					$news_topic_posterdata = mx_get_userdata($latest_news[$i]['topic_poster'], false);
					
					if ($news_topic_posterdata['user_level'] == ADMIN) 
					{ 
						$topic_poster_color = $theme['fontcolor3'];
						$topic_poster_style = 'style="color:#' . $topic_poster_color . '; font-weight : bold;"';  
					} 
					else if ($news_topic_posterdata['user_level'] == MOD) 
					{ 
						$topic_poster_color = $theme['fontcolor2'];
						$topic_poster_style = 'style="color:#' . $topic_poster_color . '; font-weight : bold;"';  
					}
					else 
					{ 
						$topic_poster_color = '';
						$topic_poster_style = 'style="font-weight : bold;"'; 
					}
				}
				else if ($recent_show_user_bold) 
				{ 
					$topic_poster_color = '';
					$topic_poster_style = 'style="font-weight : bold;"'; 
				}
				else 
				{ 
					$topic_poster_color = '';
					$topic_poster_style = ''; 
				}

				$topic_autor_id = mx_append_sid(PHPBB_URL . 'profile.php?mode=viewprofile&u=' . $latest_news[$i]['user_id']);
				$topic_autor = $latest_news[$i]['username'];

				$topic_poster = ($latest_news[$i]['topic_poster'] == ANONYMOUS ) ? '<span ' . $topic_poster_style . '>' . $lang['Guest'] . '</span>' : '<a href="' . mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $latest_news[$i]['topic_poster']) . '"><span ' . $topic_poster_style . '>' . $latest_news[$i]['author_username'] . '</span></a> ';
				$topic_poster_full = $topic_poster;
			}

			$topic_replies = $latest_news[$i]['topic_replies'];

			if ( function_exists( 'create_date' ) )
			{
				$last_post_time = create_date($board_config['default_dateformat'], $latest_news[$i]['post_time'], $board_config['board_timezone']);
			}
			else if (PORTAL_BACKEND == 'phpbb3')
			{
				$last_post_time = $mx_user->format_date($latest_news[$i]['topic_last_post_time']);
			}
			else
			{
				$last_post_time = phpBB2::create_date($board_config['default_dateformat'], $latest_news[$i]['topic_time'], $board_config['board_timezone']);
			}

			$recent_news_total_info = count($i);

			if (($recent_news_offset > 0) or ($recent_news_offset+$recent_num_news < $overall_news_topics))
			{
				$new_url = '<a href="' . mx_append_sid(this_recent_url('recent_news_offset='));
				if ($recent_news_offset > 0) 
				{ 
					$prev_news_url = ($recent_forums_offset > 0) ? $new_url . ($recent_news_offset-$recent_num_news) . '&recent_posts_offset=' . $recent_forums_offset . '" class="th">&lt;&lt; Prev ' . $recent_num_news . '</a>' : $new_url . ($recent_news_offset-$recent_num_news).'" class="th">&lt;&lt; Prev ' . $recent_num_news . '</a>';
				}
				else 
				{ 
					$prev_news_url = '';
				}
				if ( ($recent_news_offset+$recent_num_news < $overall_total_topics) && ($recent_news_offset < $recent_num_news+recent_news_total_info) )
				{
					$next_news_url = ($recent_forums_offset > 0) ? $new_url . ($recent_news_offset+$recent_num_news) . '&recent_posts_offset=' . $recent_forums_offset . '" class="th">Next ' . $recent_num_news . ' &gt;&gt;</a>' : $new_url . ($recent_news_offset+$recent_num_news).'" class="th">Next ' . $recent_num_news . ' &gt;&gt;</a>';
				}
				else 
				{ 
					$next_news_url = '';
				}
			}
			else 
			{
				$prev_news_url = ''; 
				$next_news_url = '';
			}
			$template->assign_block_vars('latest_news', array(
					'NEWEST_POST_IMG' => $$bullet_full,
					'TOPIC_FOLDER_IMG_SRC' => $$bullet_src,					
					'TOPIC_TITLE' => $latest_news[$i]['topic_title'],
					'U_LAST_POST' => mx_append_sid(PHPBB_URL . 'viewtopic.' . $phpEx . '?' . 'f=' . $latest_news[$i]['forum_id'] . '&amp;t=' . $latest_news[$i]['topic_id'] . '&amp;p=' . $latest_news[$i]['topic_last_post_id'] . '#p' . $latest_news[$i]['topic_last_post_id']),		
					'TOPIC_TIME' => $message_date,
					'TOPIC_ICON_IMG' => (!empty($mx_user->img[$latest_news[$i]['icon_id']])) ? $mx_user->img[$latest_news[$i]['icon_id']]['img'] : '',
					'TOPIC_ICON_IMG_WIDTH' => (!empty($mx_user->img[$latest_news[$i]['icon_id']])) ? $mx_user->img[$latest_news[$i]['icon_id']]['width'] : '',
					'TOPIC_ICON_IMG_HEIGHT' => (!empty($mx_user->img[$latest_news[$i]['icon_id']])) ? $mx_user->img[$latest_news[$i]['icon_id']]['height'] : '',					
					'LAST_POST_TIME' => $last_post_time,
					'TOPIC_POSTER' => $topic_poster,
					'TOPIC_VIEWS' => $latest_news[$i]['topic_views'],
					'TOPIC_REPLIES' => $topic_replies,
					'LAST_POSTER' => $last_poster,
					'LAST_POSTER_COLOUR' => $last_poster_color,
					'LAST_POSTER_FULL' => $last_poster_full,
					'TOPIC_AUTOR_ID' => $topic_autor_id,
					'TOPIC_AUTHOR' => $topic_autor,
					'TOPIC_AUTHOR_COLOUR' => $topic_poster_color,
					'TOPIC_AUTHOR_FULL' => $topic_poster_full,
					'FORUM_TITLE' => $latest_news[$i]['forum_name'],
					'U_VIEW_TOPIC' => mx_append_sid(PHPBB_URL . 'viewtopic.' . $phpEx . '?' . 'f=' . $latest_news[$i]['forum_id'] . '&amp;t=' . $latest_news[$i]['topic_id'] . $newest_code),
					'U_VIEW_FORUM' => mx_append_sid(PHPBB_URL . 'viewforum.' . $phpEx . '?' . 'f=' . $latest_news[$i]['forum_id']),
					'NEXT_URL'	=> $next_news_url,
					'PREV_URL' 	=> $prev_news_url,
					'S_TOPIC_GLOBAL'	=> (!$latest_news[$i]['forum_id']) ? true : false,
					'S_TOPIC_TYPE'	=> $latest_news[$i]['topic_type'],
					'S_USER_POSTED'	=> (!empty($latest_news[$i]['mark_type'])) ? true : false,
					'SWITCH_RECENT_NEWS' => (!empty($recent_num_news)) ? 1 : false,
					'S_ROW_COUNT'	=> $i)
				);
		}
	}
	else
	{
		$recent_news_total_info = 'None';

		if (($recent_news_offset > 0) or ($recent_news_offset+$recent_num_news < $overall_news_topics))
		{
			$new_url = '<a href="' . mx_append_sid(this_recent_url('recent_news_offset='));
			if ($recent_news_offset > 0) 
			{ 
				$prev_news_url = ($recent_forums_offset > 0) ? $new_url . ($recent_news_offset-$recent_num_news) . '&recent_posts_offset=' . $recent_forums_offset . '" class="th">&lt;&lt; Prev ' . $recent_num_news . '</a>' : $new_url . ($recent_news_offset-$recent_num_news).'" class="th">&lt;&lt; Prev ' . $recent_num_news . '</a>';
			}
			else 
			{ 
				$prev_news_url = '';
			}

			$next_news_url = '';
		}
		else 
		{
			$prev_news_url = ''; 
			$next_news_url = '';
		}

		$template->assign_block_vars('latest_news', array(
			'TOPIC_FOLDER_IMG_SRC' => $recent_forums_bullet_old,
			'LAST_POSTER' => 'None',
			'TOPIC_POSTER' => 'None',
			'TOPIC_AUTHOR' => 'None',
			'TOPIC_REPLIES' => '0',	
			'TOPIC_TITLE' => 'None'
		));
	}
}
	
if ($recent_num_topics)
{
	$recent_info = 'counted recent';
	$bullet_pre = 'recent_posts_bullet';
	if ( !empty($latest_topics) )
	{
		for ( $i = 0; $i < count($latest_topics); $i++ )
		{
			if ( $userdata['user_id'] != 1 )
			{
				$unread_topics = false;
				$topic_id = $latest_topics[$i]['topic_id'];
				if ( $latest_topics[$i]['post_time'] > $recent_last_visit )
				{
					$unread_topics = true;
					if( !empty($tracking_topics[$topic_id]) && $recent_track )
					{
						if( $tracking_topics[$topic_id] >= $latest_topics[$i]['post_time'] )
						{
							$unread_topics = false;
						}
					}
				}
				$shownew = $unread_topics;
			}
			else
			{
				$unread_topics = false;
				$shownew = true;
			}

			//$topic_date_time = $mx_user->format_date($latest_topics[$i]['topic_time']);

			if ( function_exists( 'create_date' ) )
			{
				$topic_date_time = create_date($board_config['default_dateformat'], $latest_topics[$i]['topic_time'], $board_config['board_timezone']);
			}
			else if (PORTAL_BACKEND == 'phpbb3')
			{
				$topic_date_time = $mx_user->format_date($latest_topics[$i]['topic_time']);
			}
			else
			{
				$topic_date_time = phpBB2::create_date($board_config['default_dateformat'], $latest_topics[$i]['topic_time'], $board_config['board_timezone']);
			}

			$bullet_full = $bullet_pre . ( ( $shownew && $recent_show_new_bullets ) ? '_new' : '_old' );

			$bullet_src = $bullet_pre . ( ( $shownew && $recent_show_new_bullets ) ? '_new_src' : '_old_src' );

			$newest_code = ( $unread_topics && $recent_show_new_bullets ) ? '&amp;view=newest' : '';

			if ( function_exists( 'create_date' ) )
			{
				$last_post_time = create_date($board_config['default_dateformat'], $latest_topics[$i]['post_time'], $board_config['board_timezone']);
			}
			else if (PORTAL_BACKEND == 'phpbb3')
			{
				$last_post_time = $mx_user->format_date($latest_topics[$i]['post_time']);
			}
			else if (PORTAL_BACKEND == 'phpbb3')
			{
				$last_post_time = $mx_user->format_date($latest_topics[$i]['post_time']);
			}
			else
			{
				$last_post_time = phpBB2::create_date($board_config['default_dateformat'], $latest_topics[$i]['post_time'], $board_config['board_timezone']);
			}

			if ( function_exists('mx_get_username_string') && (PORTAL_BACKEND == 'phpbb3') )
			{
				$topic_poster = mx_get_username_string('username', $latest_topics[$i]['topic_poster'], $latest_topics[$i]['topic_first_poster_name'], $latest_topics[$i]['topic_first_poster_colour']);
				$topic_poster_color = mx_get_username_string('colour', $latest_topics[$i]['topic_poster'], $latest_topics[$i]['topic_first_poster_name'], $latest_topics[$i]['topic_first_poster_colour']);
				$topic_poster_full = mx_get_username_string('full', $latest_topics[$i]['topic_poster'], $latest_topics[$i]['topic_first_poster_name'], $latest_topics[$i]['topic_first_poster_colour']);

				$last_poster = mx_get_username_string('username', $latest_topics[$i]['topic_last_poster_id'], $latest_topics[$i]['topic_last_poster_name'], $latest_topics[$i]['topic_last_poster_colour']);
				$last_poster_color = mx_get_username_string('colour', $latest_topics[$i]['topic_last_poster_id'], $latest_topics[$i]['topic_last_poster_name'], $latest_topics[$i]['topic_last_poster_colour']);
				$last_poster_full = mx_get_username_string('full', $latest_topics[$i]['topic_last_poster_id'], $latest_topics[$i]['topic_last_poster_name'], $latest_topics[$i]['topic_last_poster_colour']);
				$last_poster_full .= '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?"  . POST_POST_URL . '=' . $latest_topics[$i]['topic_last_post_id']) . '#' . $latest_topics[$i]['topic_last_post_id'] . '"><img src="' . $mx_user->img('icon_topic_latest', 'VIEW_LATEST_POST', false, '', 'src') . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
			}
			else
			{
				if ($recent_show_user_color)
				{
					$recent_last_posterdata = mx_get_userdata($latest_topics[$i]['poster_id'], false);
				
					if ($recent_last_posterdata['user_level'] == ADMIN) 
					{ 
						$last_poster_color = $theme['fontcolor3'];
						$last_poster_style = 'style="color:#' . $last_poster_color . '; font-weight : bold;"';  
					} 
					else if ($recent_last_posterdata['user_level'] == MOD) 
					{ 
						$last_poster_color = $theme['fontcolor2'];
						$last_poster_style = 'style="color:#' . $last_poster_color . '; font-weight : bold;"';  
					}
					else 
					{ 
						$last_poster_color = '';
						$last_poster_style = 'style="font-weight : bold;"'; 
					}
				}
				else if ($recent_show_user_bold) 
				{ 
					$last_poster_color = '';
					$last_poster_style = 'style="font-weight : bold;"'; 
				}
				else 
				{ 
					$last_poster_color = '';
					$last_poster_style = ''; 
				}

				$last_poster = ($latest_topics[$i]['poster_id'] == ANONYMOUS ) ? '<span ' . $last_poster_style . '>' . $lang['Guest'] . '</span>' : '<a alt="' . $last_post_time . '" title="' . $last_post_time . '" href="' . mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $latest_topics[$i]['poster_id']) . '"><span ' . $last_poster_style . '>' . $latest_topics[$i]['last_username'] . '</span></a> ';
				$last_poster_full = $last_poster . '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?"  . POST_POST_URL . '=' . $latest_topics[$i]['topic_last_post_id']) . '#' . $latest_topics[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';

				if ($recent_show_user_color)
				{
					$recent_topic_posterdata = mx_get_userdata($latest_topics[$i]['topic_poster'], false);

					if ($recent_topic_posterdata['user_level'] == ADMIN) 
					{ 
						$topic_poster_color = $theme['fontcolor3'];
						$topic_poster_style = 'style="color:#' . $topic_poster_color . '; font-weight : bold;"';  
					} 
					else if ($recent_topic_posterdata['user_level'] == MOD) 
					{ 
						$topic_poster_color = $theme['fontcolor2'];
						$topic_poster_style = 'style="color:#' . $topic_poster_color . '; font-weight : bold;"';  
					}
					else 
					{ 
						$topic_poster_color = $theme['fontcolor1'];
						$topic_poster_style = 'style="font-weight : bold;"'; 
					}
				}
				else if ($recent_show_user_bold) 
				{ 
					$topic_poster_color = '';
					$topic_poster_style = 'style="font-weight : bold;"'; 
				}
				else 
				{ 
					$topic_poster_color = '';
					$topic_poster_style = ''; 
				}
				$topic_autor_id = mx_append_sid(PHPBB_URL . 'profile.php?mode=viewprofile&u=' . $latest_topics[$i]['user_id']);
				$topic_autor = $latest_topics[$i]['username'];
				
				$topic_poster = ($latest_topics[$i]['topic_poster'] == ANONYMOUS ) ? '<span ' . $topic_poster_style . '>' . $lang['Guest'] . '</span>' : '<a href="' . mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $latest_topics[$i]['topic_poster']) . '"><span ' . $topic_poster_style . '>' . $latest_topics[$i]['author_username'] . '</span></a> ';
				$topic_poster_full = $topic_poster;
			}

			$topic_replies = $latest_topics[$i]['topic_replies'];
			$recent_forums_total_info = count($i);

			if (($recent_forums_offset > 0) or ($recent_forums_offset+$recent_num_topics < $overall_total_topics))
			{
				$new_url = '<a href="' . mx_append_sid(this_recent_url('recent_posts_offset='));
				if ($recent_forums_offset > 0) 
				{ 
					$prev_recent_url = ($recent_news_offset > 0) ? $new_url . ($recent_forums_offset-$recent_num_topics) . '&recent_news_offset=' . $recent_news_offset . '" class="th">&lt;&lt; Prev ' . $recent_num_topics . '</a>' : $new_url . ($recent_forums_offset-$recent_num_topics).'" class="th">&lt;&lt; Prev ' . $recent_num_topics . '</a>';
				}
				else 
				{ 
					$prev_recent_url = '';
				}
				if ( ($recent_forums_offset+$recent_num_topics < $overall_total_topics) && ($recent_forums_offset < $recent_num_topics+$recent_forums_total_info) )
				{
					$next_recent_url = ($recent_news_offset > 0) ? $new_url . ($recent_forums_offset+$recent_num_topics) . '&recent_news_offset=' . $recent_news_offset . '" class="th">Next ' . $recent_num_topics . ' &gt;&gt;</a>' : $new_url . ($recent_forums_offset+$recent_num_topics).'" class="th">Next ' . $recent_num_topics . ' &gt;&gt;</a>';
				}
				else 
				{ 
					$next_recent_url = '';
				}
			}
			else 
			{
				$prev_recent_url = ''; 
				$next_recent_url = '';
			}

			$template->assign_block_vars('latest_topics', array(
				'NEWEST_POST_IMG' => $$bullet_full,
				'TOPIC_FOLDER_IMG_SRC' => $$bullet_src,
				'TOPIC_ICON_IMG' => (!empty($mx_user->img[$latest_topics[$i]['icon_id']])) ? $mx_user->img[$latest_topics[$i]['icon_id']]['img'] : '',
				'TOPIC_ICON_IMG_WIDTH' => (!empty($mx_user->img[$latest_topics[$i]['icon_id']])) ? $mx_user->img[$latest_topics[$i]['icon_id']]['width'] : '',
				'TOPIC_ICON_IMG_HEIGHT' => (!empty($mx_user->img[$latest_topics[$i]['icon_id']])) ? $mx_user->img[$latest_topics[$i]['icon_id']]['height'] : '',				
				'U_LAST_POST' => mx_append_sid( PHPBB_URL . 'viewtopic.' . $phpEx . '?' . 'f=' . $latest_topics[$i]['forum_id'] . '&amp;t=' . $latest_topics[$i]['topic_id'] . '&amp;p=' . $latest_topics[$i]['topic_last_post_id'] . '#p' . $latest_topics[$i]['topic_last_post_id']),
				'TOPIC_POSTS' => $latest_topics[$i]['topic_replies'],
				'TOPIC_TIME' => $topic_date_time,
				'TOPIC_TITLE' => $latest_topics[$i]['topic_title'],
				'TOPIC_VIEWS' => $latest_topics[$i]['topic_views'],
				'TOPIC_REPLIES' => $topic_replies,
				'LAST_POST_TIME' => $last_post_time,
				'LAST_POSTER' => $last_poster,
				'LAST_POSTER_COLOUR' => $last_poster_color,
				'LAST_POSTER_FULL' => $last_poster_full,
				'TOPIC_AUTOR_ID' => $topic_autor_id,
				'TOPIC_AUTHOR' => $topic_autor,
				'TOPIC_AUTHOR_COLOUR' => $topic_poster_color,
				'TOPIC_AUTHOR_FULL' => $topic_poster_full,
				'FORUM_TITLE'	=> $latest_topics[$i]['forum_name'],
				'U_VIEW_TOPIC'	=> mx_append_sid( PHPBB_URL . 'viewtopic.' . $phpEx . '?' . 'f=' . $latest_topics[$i]['forum_id'] . '&amp;t=' . $latest_topics[$i]['topic_id'] . $newest_code),
				'U_VIEW_FORUM'	=> mx_append_sid( PHPBB_URL . 'viewforum.' . $phpEx . '?' . 'f=' . $latest_topics[$i]['forum_id']),
				'NEXT_URL' 	=> $next_recent_url,
				'PREV_URL'	=> $prev_recent_url,
				'S_TOPIC_GLOBAL'	=> (!$latest_topics[$i]['forum_id']) ? true : false,
				'S_TOPIC_TYPE'	=> $latest_topics[$i]['topic_type'],
				'S_USER_POSTED'	=> (!empty($latest_topics[$i]['mark_type'])) ? true : false,
				'SWITCH_RECENT_POSTS'	=> (!empty($recent_num_topics)) ? 1 : false,
				'S_ROW_COUNT'	=> $i)
			);
		}
	}
	else
	{
		$recent_forums_total_info = 'None';

		if (($recent_forums_offset > 0) or ($recent_forums_offset+$recent_num_topics < $overall_total_topics))
		{
			$new_url = '<a href="' . mx_append_sid(this_recent_url('recent_posts_offset='));
			if ($recent_forums_offset > 0) 
			{ 
				$prev_recent_url = ($recent_news_offset > 0) ? $new_url . ($recent_forums_offset-$recent_num_topics) . '&recent_news_offset=' . $recent_news_offset . '" class="th">&lt;&lt; Prev ' . $recent_num_topics . '</a>' : $new_url . ($recent_forums_offset-$recent_num_topics).'" class="th">&lt;&lt; Prev ' . $recent_num_topics . '</a>';
			}
			else 
			{ 
				$prev_recent_url = '';
			}

			$next_recent_url = '';
		}
		else 
		{
			$prev_recent_url = ''; 
			$next_recent_url = '';
		}

		$template->assign_block_vars('latest_topics', array(
		'BULLET' => $recent_forums_bullet_old,
		'LAST_POSTER' => 'None',
		'TOPIC_POSTER' => 'None',
		'TOPIC_AUTHOR' => 'None',
		'TOPIC_REPLIES' => '0',	
		'TOPIC_TITLE' => 'None'
		));
	}
}

if ($recent_num_news)
{
	$template->assign_block_vars('switch_glance_news', array(
			'NEXT_URL' => $next_news_url,
			'PREV_URL' => $prev_news_url
	));
}

if ($recent_num_topics)
{
	$template->assign_block_vars('switch_glance_recent', array(
			'NEXT_URL' => $next_recent_url,
			'PREV_URL' => $prev_recent_url
	));
}

if ($recent_news_total_info == 'None' && $recent_forums_total_info == 'None')
{
	$template->assign_block_vars("no_glance_news_and_recent", array(
		'L_NO_ITEMS' => $lang['No_items_found']
	));
}

$template->assign_vars(array(
		'L_TITLE' => ( !empty($title) ? $title : 'Last Message' ),
		'NEWS_HEADING' => ( !empty($lang['glance_news_heading']) ? $lang['glance_news_heading'] : 'Latest Site News' ),
		'RECENT_HEADING' => ( !empty($lang['glance_recent_heading']) ? $lang['glance_recent_heading'] : 'Recent Discussions' ),
		'U_PHPBB_ROOT_PATH' => PHPBB_URL,
		'U_PORTAL_ROOT_PATH' => PORTAL_URL,
		'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,
		'L_COMMENTS' => $lang['comments'],
		'L_TOPICS' => $lang['Topics'],
		'L_REPLIES' => $lang['Replies'],
		'L_VIEWS' => $lang['Views'],
		'L_LASTPOST' => $lang['Last_Post'],
		'L_AUTHOR' => $lang['Author'], 
		'L_WRITEN_BY' => $lang['writen_by'],
		'L_LAST_BY' => $lang['last_by'],
		'L_LAST_REPLY' => $lang['last_reply'],
		'L_FORUM' => $lang['Forum'],
		'L_POSTS' => $lang['Posts'],
		'L_NO_NEW_POSTS' => $lang['No_new_posts'],
		'L_NEW_POSTS' => $lang['New_posts'],
		'L_NO_NEW_POSTS_LOCKED' => $lang['No_new_posts_locked'],
		'L_NEW_POSTS_LOCKED' => $lang['New_posts_locked'],  
		'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
		'L_BACK_TO_TOP' => ( !empty($lang['Back_to_top']) ? $lang['Back_to_top'] : 'Back to Top' )
));

$template->pparse('glance_output');
	
// THE END
?>
