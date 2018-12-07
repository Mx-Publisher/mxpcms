<?php
/**
*
* @package MX-Publisher Module - mx_phpbb3blocks
* @version $Id: mx_last_msg.php,v 1.9 2013/06/28 15:36:44 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

// ===================================================
// Include the constants file
// ===================================================
require_once($module_root_path .'includes/phpbb3blocks_constants.'. $phpEx);
require_once($mx_root_path . 'includes/mx_functions_tools.' . $phpEx); 
$mx_text_formatting = new mx_text_formatting();

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];

$template->set_filenames(array(
	'body_last_msg'=>'mx_last_msg.'.$tplEx)
);

//
// Read block Configuration
//
$PostNumber = $mx_block->get_parameters('Last_Msg_Number_Title');
$display_date = $mx_block->get_parameters('Last_Msg_Display_Date');
$nb_characteres = $mx_block->get_parameters('Last_Msg_Title_Length');
$target = $mx_block->get_parameters('Last_Msg_Target');
$align = $mx_block->get_parameters('Last_Msg_Align');
$display_forum = $mx_block->get_parameters('Last_Msg_Display_Forum');
$forum_lst_msg = $mx_block->get_parameters('Last_Msg_forum');

if( empty($PostNumber) ) $PostNumber = 5;

$display_author = $mx_block->get_parameters('Last_Msg_Display_Author');
$display_last_author = $mx_block->get_parameters('Last_Msg_Display_Last_Author');
$display_icon_view = $mx_block->get_parameters('Last_Msg_Display_Icon_View');

$auth_read = $mx_block->get_parameters('Last_Msg_Auth_Read');

//
// no limit, last day, 2 days, 3 days, week, 2 weeks, 3 weeks, month, 2 months, 3 months, 6 months, i year,
//
$msg_filter_time = $mx_block->get_parameters('msg_filter_date');

//
// Authorization SQL
//
$phpbb_auth->acl($mx_user->data); // Do only once, in user_init // Move later
//die('s1'.var_export($phpbb_auth->acl_getf('f_view', false)));
$auth_data_sql_msg = $phpbb_auth->get_auth_forum();
//die(var_export($auth_data_sql_msg));

if ( empty($forum_lst_msg) )
{
	$forum_lst_msg = $auth_data_sql_msg;
}
if ( empty($forum_lst_msg) )
{
	$forum_lst_msg = -1;
}

//$auth_level_read = ($auth_read) ? array('f_read', 'f_list') : true;

//$forum_lst_msg_ignore = mx_acl_getfignore($auth_level_read, $forum_lst_msg_ignore);

$msg_start = $mx_request_vars->get('lmsg_start', MX_TYPE_INT, 0);
$start_prev = ( $msg_start == 0 ) ? 0 : $msg_start - $PostNumber;
$start_next = $msg_start + $PostNumber;

$url_next = mx_url('lmsg_start', $start_next);
$url_prev = mx_url('lmsg_start', $start_prev);

$msg_today = date('mdY');
switch( $msg_filter_time )
{
	case'0':
		$msg_time_filter_lo ='no';
	break;
	case'1':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2)), intval(substr($msg_today, 2, 2) - 1), intval(substr($msg_today, 4, 4)));
	break;
	case'2':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2)), intval(substr($msg_today, 2, 2) - 1), intval(substr($msg_today, 4, 4)));
	break;
	case'3':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2)), intval(substr($msg_today, 2, 2) - 1), intval(substr($msg_today, 4, 4)));
	break;
	case'4':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2)), intval(substr($msg_today, 2, 2) - 7), intval(substr($msg_today, 4, 4)));
	break;
	case'5':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2)), intval(substr($msg_today, 2, 2) - 14), intval(substr($msg_today, 4, 4)));
	break;
	case'6':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2)), intval(substr($msg_today, 2, 2) - 21), intval(substr($msg_today, 4, 4)));
	break;
	case'7':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2) - 1), intval(substr($msg_today, 2, 2)), intval(substr($msg_today, 4, 4)));
	break;
	case'8':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2) - 2), intval(substr($msg_today, 2, 2)), intval(substr($msg_today, 4, 4)));
	break;
	case'9':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2) - 3), intval(substr($msg_today, 2, 2)), intval(substr($msg_today, 4, 4)));
	break;
	case'10':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2) - 6), intval(substr($msg_today, 2, 2)), intval(substr($msg_today, 4, 4)));
	break;
	case'11':
		$msg_time_filter_lo = mktime(0, 0, 0 , intval(substr($msg_today, 0, 2)), intval(substr($msg_today, 2, 2)), intval(substr($msg_today, 4, 4) - 1));
	break;
	default:
		$msg_time_filter_lo ='no';
	break;
}

$sql = "SELECT COUNT(*) AS msg_num
	FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p
	WHERE p.post_id = t.topic_last_post_id
		AND t.forum_id in ( $forum_lst_msg )
		AND t.forum_id in ( $auth_data_sql_msg )
		AND t.topic_moved_id = 0";

if ( $msg_time_filter_lo !='no'&& !empty($msg_time_filter_lo) )
{
	$sql .= " AND p.post_time > " . $msg_time_filter_lo;
}

if ( !($result = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR,'Could not obtain limited topics count information','', __LINE__, __FILE__, $sql);
}

$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$msg_total_match_count = $row['msg_num'];

if ( ($msg_time_filter_lo != 'no') && !empty($msg_time_filter_lo) )
{
	$sql_filter_lo = " AND p.post_time > " . $msg_time_filter_lo;
}
else
{
	$sql_filter_lo = "";
}

$sql = $db->sql_build_query('SELECT', array(
	'SELECT'	=> 'f.forum_id, f.forum_name, t.*, p.*, u.*',

	'FROM'		=> array(
		FORUMS_TABLE	=> 'f',
		POSTS_TABLE	=> 'p',
		TOPICS_TABLE	=> 't',
		USERS_TABLE	=> 'u',
	),

	'WHERE'		=> "f.forum_id in ( $forum_lst_msg )
		AND f.forum_id in ( $auth_data_sql_msg )
		AND t.forum_id = f.forum_id
		AND p.post_id = t.topic_first_post_id
		AND t.topic_moved_id = 0
		AND p.poster_id = u.user_id
		AND t.topic_poster = u.user_id
		" . $sql_filter_lo . '',

	'ORDER_BY'	=> 't.topic_last_post_id DESC',
));

if( !($result = $db->sql_query_limit($sql, $PostNumber, $msg_start)) )
{
	mx_message_die(GENERAL_ERROR, "Could not query new news information", "", __LINE__, __FILE__, $sql);
}

$postrow = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);

$base_url = mx_this_url();

$template->assign_vars(array(
	'L_TITLE'=> ( !empty($title) ? $title :'Last Message'),
	'U_TARGET'=> $target,
	'U_ALIGN'=> $align,
	'BLOCK_SIZE'=> ( !empty($block_size) ? $block_size :'100%'),
	'U_URL'=> mx_append_sid(PORTAL_URL .'index.'. $phpEx .'?block_id='. $block_id),
	'U_URL_NEXT'=> $url_next,
	'U_URL_PREV'=> $url_prev,
	'U_PHPBB_ROOT_PATH'=> PHPBB_URL,
	'U_PORTAL_ROOT_PATH'=> PORTAL_URL,
	'TEMPLATE_ROOT_PATH'=> TEMPLATE_ROOT_PATH,
	'L_MSG_PREV'=> $lang['Previous'],
	'L_MSG_NEXT'=> $lang['Next'],
	'PAGINATION'=> mx_generate_pagination($base_url, $msg_total_match_count, $PostNumber, $msg_start, true, true, true, false,'lmsg_start'),
	'PAGE_NUMBER'=> sprintf($lang['Page_of'], ( floor($msg_start / $PostNumber) + 1 ), ceil($msg_total_match_count / $PostNumber))
));

if ( $msg_total_match_count == 0 || $msg_total_match_count =='')
{
	$template->assign_block_vars("no_row", array(
		'L_NO_ITEMS'=> $lang['No_items_found']
	));
}

for( $row_count = 0; $row_count < count($postrow); $row_count++ )
{
	//For old _core style based on phpBB2 subSilver, this should be automatic for phpBB3 based tpl/html files
	$row_color = ( !( $row_count % 2 ) ) ? $theme['td_color1'] : $theme['td_color2'];
	$row_class = ( !( $row_count % 2 ) ) ? $theme['td_class1'] : $theme['td_class2'];

	$message = $postrow[$row_count]['topic_title'];
	$bbcode_uid = $postrow[$row_count]['bbcode_uid'];
	$bbcode_bitfield = $postrow[$row_count]['bbcode_bitfield'] ? $postrow[$row_count]['bbcode_bitfield'] : true;
	
	$message = $mx_bbcode->decode($message, $bbcode_uid, true, $bbcode_bitfield);
	
	$url = mx_append_sid(PHPBB_URL . 'viewtopic.' . $phpEx . '?' . 'f=' . $postrow[$row_count]['forum_id'] . '&amp;lmsg_start='. $msg_start .'&amp;t='. $postrow[$row_count]['topic_id'] .'#'. $postrow[$row_count]['topic_last_post_id']);

	if ( $postrow[$row_count]['topic_status'] == TOPIC_MOVED )
	{
		$topic_type = $lang['Topic_Moved'] .'';
		$topic_id = $postrow[$row_count]['topic_moved_id'];

		$folder_image = $mx_user->img('topic_unread', 'NEW_POSTS', false, '', 'src');
		$folder_alt = $lang['Topics_Moved'];
		$newest_post_img ='';
	}
	else
	{
		if ( $postrow[$row_count]['topic_type'] == POST_ANNOUNCE )
		{
			$folder = $mx_user->img('announce_read', 'POST_ANNOUNCEMENT', false, '', 'src');
			$folder_new = $mx_user->img('announce_unread', 'POST_ANNOUNCEMENT', false, '', 'src');
		}
		else if ( $postrow[$row_count]['topic_type'] == POST_STICKY )
		{
			$folder = $mx_user->img('sticky_read', 'POST_STICKY', false, '', 'src');
			$folder_new = $mx_user->img('sticky_unread', 'POST_STICKY', false, '', 'src');
		}
		else if ( $postrow[$row_count]['topic_status'] == TOPIC_LOCKED )
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

		$newest_post_img ='';
		if ( $userdata['session_logged_in'] )
		{
			$tracking_topics = ( isset( $_COOKIE[$board_config['cookie_name'] .'_t'] ) ) ? unserialize( $_COOKIE[$board_config['cookie_name'] . "_t"] ) : array();
			$tracking_forums = ( isset( $_COOKIE[$board_config['cookie_name'] .'_f'] ) ) ? unserialize( $_COOKIE[$board_config['cookie_name'] . "_f"] ) : array();

			if ( $postrow[$row_count]['post_time'] > $userdata['user_lastvisit'] )
			{
				if ( !empty( $tracking_topics ) || !empty( $tracking_forums ) || isset( $_COOKIE[$board_config['cookie_name'] .'_f_all'] ) )
				{
					$unread_topics = true;

					if ( !empty( $tracking_topics[$postrow[$row_count]['topic_id']] ) )
					{
						if ( $tracking_topics[$postrow[$row_count]['topic_id']] >= $postrow[$row_count]['post_time'] )
						{
							$unread_topics = false;
						}
					}

					if ( !empty( $tracking_forums[$postrow[$row_count]['topic_id']] ) )
					{
						if ( $tracking_forums[$postrow[$row_count]['topic_id']] >= $postrow[$row_count]['post_time'] )
						{
							$unread_topics = false;
						}
					}

					if ( isset( $_COOKIE[$board_config['cookie_name'] .'_f_all'] ) )
					{
						if ( $_COOKIE[$board_config['cookie_name'] .'_f_all'] >= $postrow[$row_count]['post_time'] )
						{
							$unread_topics = false;
						}
					}

					if ( $unread_topics )
					{
						$folder_image = $folder_new;
						$folder_alt = $lang['New_posts'];

						$newest_post_img ='<a href="'. mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") .'"><img src="'. $mx_user->img('icon_topic_latest', 'VIEW_LATEST_POST', false, '', 'src') .'" alt="'. $lang['View_newest_post'] .'" title="'. $lang['View_newest_post'] .'" border="0" /></a>';
					}
					else
					{
						$folder_image = $folder;
						$folder_alt = ( $postrow[$row_count]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

						$newest_post_img ='';
					}
				}
				else
				{
					$folder_image = $folder_new;
					$folder_alt = ( $postrow[$row_count]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['New_posts'];

					$newest_post_img ='<a href="'. mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") .'"><img src="'. $mx_user->img('icon_topic_latest', 'VIEW_LATEST_POST', false, '', 'src') .'" alt="'. $lang['View_newest_post'] .'" title="'. $lang['View_newest_post'] .'" border="0" /></a>';
				}
			}
			else
			{
				$folder_image = $folder;
				$folder_alt = ( $postrow[$row_count]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

				$newest_post_img = '';
			}
		}
		else
		{
			$folder_image = $folder;
			$folder_alt = ( $postrow[$row_count]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

			$newest_post_img ='';
		}
	}

	if ( $display_author == "TRUE" )
	{

		$topic_author = ( $postrow[$row_count]['user_id'] != ANONYMOUS ) ?'<a href="'. mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL .'='. $postrow[$row_count]['user_id']) .'" class="gensmall">':'';
		$topic_author .= ( $postrow[$row_count]['user_id'] != ANONYMOUS ) ? $postrow[$row_count]['username'] : ( ( $postrow[$row_count]['post_username'] !='') ? $postrow[$row_count]['post_username'] : $lang['Guest'] );
		$topic_author .= ( $postrow[$row_count]['user_id'] != ANONYMOUS ) ?'</a>':'';

		$topic_poster = mx_get_username_string('username', $postrow[$row_count]['topic_poster'], $postrow[$row_count]['topic_first_poster_name'], $postrow[$row_count]['topic_first_poster_colour']);
		$topic_poster_color = mx_get_username_string('colour', $postrow[$row_count]['topic_poster'], $postrow[$row_count]['topic_first_poster_name'], $postrow[$row_count]['topic_first_poster_colour']);
		$topic_poster_full = mx_get_username_string('full', $postrow[$row_count]['topic_poster'], $postrow[$row_count]['topic_first_poster_name'], $postrow[$row_count]['topic_first_poster_colour']);
	}
	else
	{
		$topic_author = '';

		$topic_poster = '';
		$topic_poster_color = '';
		$topic_poster_full = '';
	}

	if ( $display_last_author == "TRUE" )
	{
		$last_post_author = ( $postrow[$row_count]['id2'] == ANONYMOUS ) ? ( ( $postrow[$row_count]['post_username'] !='') ? $postrow[$row_count]['post_username'] .'': $lang['Guest'] .'') :'<a href="'. mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL .'='. $postrow[$row_count]['id2']) .'" class="gensmall">'. $postrow[$row_count]['user2'] .'</a>';

		$last_poster = mx_get_username_string('username', $postrow[$row_count]['topic_last_poster_id'], $postrow[$row_count]['topic_last_poster_name'], $postrow[$row_count]['topic_last_poster_colour']);
		$last_poster_color = mx_get_username_string('colour', $postrow[$row_count]['topic_last_poster_id'], $postrow[$row_count]['topic_last_poster_name'], $postrow[$row_count]['topic_last_poster_colour']);
		$last_poster_full = mx_get_username_string('full', $postrow[$row_count]['topic_last_poster_id'], $postrow[$row_count]['topic_last_poster_name'], $postrow[$row_count]['topic_last_poster_colour']);
	}
	else
	{
		$last_post_author ='';

		$last_poster = '';
		$last_poster_color = '';
		$last_poster_full = '';
	}

	$message_alt = $message;
	if (strlen($message) > $nb_characteres)
	{
		$message = $mx_text_formatting->truncate_text($message, $nb_characteres, true);
		$message .='...';
	}

	if ($display_date == "TRUE")
	{
		//$message_date = phpBB2::create_date($board_config['default_dateformat'], $postrow[$row_count]['post_time'], $board_config['board_timezone']);
		$message_date = $mx_user->format_date($postrow[$row_count]['post_time']);
		$topic_date = $mx_user->format_date($postrow[$row_count]['topic_time']);
		$last_message_date = $mx_user->format_date($postrow[$row_count]['topic_last_post_time']);
	}
	else
	{
		$message_date = '';
		$topic_date = '';
		$last_message_date = '';
	}

	if ( $display_forum == "TRUE" )
	{
		$forum_name = $postrow[$row_count]['forum_name'];

		$forum_name_alt = $forum_name;
		if ( strlen($forum_name) > $nb_characteres )
		{
			$forum_name = $mx_text_formatting->truncate_text($forum_name, $nb_characteres, true);			
			$forum_name .='...';
		}

		$forum_url = mx_append_sid(PHPBB_URL . 'viewtopic.' . $phpEx . '?lmsg_start='. $msg_start .'&amp;f='. $postrow[$row_count]['forum_id']);
	}
	else
	{
		$forum_name ='';
		$forum_url ='';
	}

	if ( $display_icon_view == "TRUE" )
	{
		$last_post_url ='<a href="'. mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?". "lmsg_start=" . $msg_start . "&amp;" . POST_POST_URL .'='. $postrow[$row_count]['topic_last_post_id']) .'#'. $postrow[$row_count]['topic_last_post_id'] .'"><img src="'. $mx_user->img('icon_topic_latest', 'VIEW_LATEST_POST', false, '', 'src') .'" alt="'. $lang['View_latest_post'] .'" title="'. $lang['View_latest_post'] .'" border="0" /></a>';

		$last_poster_full .= '<a href="' . mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?". "lmsg_start=" . $msg_start . "&amp;" . POST_POST_URL . '=' . $postrow[$row_count]['topic_last_post_id']) . '#' . $postrow[$row_count]['topic_last_post_id'] . '"><img src="' . $mx_user->img('icon_topic_latest', 'VIEW_LATEST_POST', false, '', 'src') . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
	}
	else
	{
		$last_post_url ='';
	}

	$template->assign_block_vars('msg_row', array(
		'ROW_COLOR'=> "#" . $row_color,
		'ROW_CLASS'=> $row_class,
		'LAST_MSG'=> $message,
		'LAST_MSG_ALT'=> $message_alt,
		'LAST_MSG_DATE'=> $message_date,
		'TOPIC_TIME' => $topic_date,
		'LAST_POST_TIME' => $last_message_date,
		'FORUM_NAME'=> $forum_name,
		'FORUM_NAME_ALT'=> $forum_name_alt,
		'U_LAST_MSG'=> $url,
		'U_FORUM'=> $forum_url,
		'LAST_POST_IMG'=> $last_post_url,
		'FOLDER_IMG'=> $folder_image,
		'TOPIC_AUTHOR'=> $topic_poster,
		'TOPIC_AUTHOR_COLOUR' => $topic_poster_color,
		'TOPIC_AUTHOR_FULL' => $topic_poster_full,
		'LAST_POST_AUTHOR'=> $last_poster,
		'LAST_POSTER_COLOUR' => $last_poster_color,
		'LAST_POSTER_FULL' => $last_poster_full,

		'L_TOPIC_FOLDER_ALT' => $folder_alt,
		'S_ROW_COUNT' => $row_count
	));
}

$template->pparse('body_last_msg');

?>