<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_online.php,v 1.39 2014/05/19 18:14:57 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

if (PORTAL_BACKEND == 'phpbb3')
{
	$mx_user->setup();
}

// ================================================================================
// The following code is backported from includes/page_header.php (phpBB 2.0.13)
// ================================================================================

//
// Get basic (usernames + totals) online
// situation
//
$logged_visible_online = 0;
$logged_hidden_online = 0;
$guests_online = 0;
$online_userlist = '';
$l_online_users = '';

if (defined('SHOW_ONLINE'))
{
	switch (PORTAL_BACKEND)
	{
		case 'internal':
			$sql = "SELECT u.username, u.user_id, u.user_level, s.session_logged_in, s.session_ip
				FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
				WHERE u.user_id = s.session_user_id
					AND s.session_time >= ".(time() - 300) . "
				ORDER BY u.username ASC, s.session_ip ASC";
		break;		
		case 'smf2':
			//To do:
			/** a query or we can use a session method		
			$sql = "SELECT u.id_member as u.user_id, u.member_name as u.username, u.id_group as u.user_level, s.session_id, s.data,
				FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
				WHERE u.id_member > -1
					AND s.last_update >= ".(time() - 300) . "
				ORDER BY u.member_name ASC, s.session_id ASC";
			**/
		break;
		case 'phpbb2':
			$sql = "SELECT u.username, u.user_id, u.user_allow_viewonline, u.user_level, s.session_logged_in, s.session_ip
				FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
				WHERE u.user_id = s.session_user_id
					AND s.session_time >= ".(time() - 300) . "
				ORDER BY u.username ASC, s.session_ip ASC";
		break;
		case 'phpbb3':
		default:
			$sql = "SELECT u.user_id, u.username, u.user_regdate, u.user_birthday, u.user_allow_viewonline, u.user_type, u.user_colour, s.session_autologin, s.session_ip
				FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
				WHERE u.user_id = s.session_user_id
					AND s.session_time >= ".(time() - 300) . "
				ORDER BY u.username ASC, s.session_ip ASC";
		break;
	}

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not obtain user/online information', '', __LINE__, __FILE__, $sql);
	}

	$userlist_ary = array();
	$userlist_visible = array();

	$prev_user_id = 0;
	$prev_user_ip = $prev_session_ip = '';

	while($row = $db->sql_fetchrow($result))
	{
		// User is logged in and therefor not a guest
		if ($userdata['user_id'] != ANONYMOUS)
		{
			// Skip multiple sessions for one user
			if ( $row['user_id'] != $prev_user_id )
			{
				$style_color = '';
				//switch only supported  phpBB backends here
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'smf2':					
					case 'phpbb2':
						if ( $row['user_level'] == ADMIN )
						{
							$row['username'] = '<b>' . $row['username'] . '</b>';
							$style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
						}
						else if ( $row['user_level'] == MOD )
						{
							$row['username'] = '<b>' . $row['username'] . '</b>';
							$style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
						}
					break;
					
					case 'phpbb3':
					case 'olympus':
					default:					
						$style_color = ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '" class="username-coloured"' : '';
					break;
				}
				
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'smf2':					
						$user_online_link = '<a href="' . PORTAL_URL . '"' . $style_color .'><i>' . $row['username'] . '</i></a>';
						$logged_hidden_online++;
					break;						
					case 'phpbb2':
						$user_online_link = '<a href="' . mx_append_sid(PHPBB_URL."profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'><i>' . $row['username'] . '</i></a>';
						$logged_hidden_online++;
					break;
					
					case 'phpbb3':
					case 'olympus':
					default:
						if ($row['user_allow_viewonline'])
						{
							$user_online_link = $mx_backend->get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
							$logged_visible_online++;
						}
						else
						{
							$user_online_link = ($row['user_type'] != USER_IGNORE) ? mx_get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : '<span' . $style_color . '>' . $row['username'] . '</span>';
							$logged_hidden_online++;
						}
					break;
				}
				
				if ( $row['user_allow_viewonline'] || $mx_user->data['user_level'] == ADMIN )
				{
					$online_userlist .= ( $online_userlist != '' ) ? ', ' . $user_online_link : $user_online_link;
				}
			}
			$prev_user_id = $row['user_id'];
		}
		else
		{
			// Skip multiple sessions for one user
			if ( $row['session_ip'] != $prev_session_ip )
			{
				$guests_online++;
			}
		}
		$prev_session_ip = $row['session_ip'];
	}
	$db->sql_freeresult($result);

	if ( empty($online_userlist) )
	{
		$online_userlist = $lang['None'];
	}
	
	$online_userlist = ((isset($forum_id)) ? $lang['Browsing_forum'] : $lang['Registered_users']) . ' ' . $online_userlist;
	$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;

	if ($total_online_users > $board_config['record_online_users'])
	{
		$board_config['record_online_users'] = $total_online_users;
		$board_config['record_online_date'] = time();
		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
				$sql = "UPDATE " . PORTAL_TABLE . "
					SET record_online_users = '$total_online_users',
				        record_online_date = '" . $board_config['record_online_date'] . "'
				     WHERE portal_id = 1";
				if (!$db->sql_query($sql))
				{
					mx_message_die(GENERAL_ERROR, 'Could not update online user record (nr of users)', '', __LINE__, __FILE__, $sql);
				}
				
				$portal_config['record_online_users'] = $total_online_users;
				$portal_config['record_online_date'] = $board_config['record_online_date'];
				$mx_cache->put('mxbb_config', $portal_config);
			break;
			
			case 'phpbb2':
			case 'phpbb3':
			default:
				$sql = "UPDATE " . CONFIG_TABLE . "
					SET config_value = '$total_online_users'
					WHERE config_name = 'record_online_users'";			
				if (!$db->sql_query($sql))
				{
					mx_message_die(GENERAL_ERROR, 'Could not update online user record (nr of users)', '', __LINE__, __FILE__, $sql);
				}			
				$sql = "UPDATE " . CONFIG_TABLE . "
					SET config_value = '" . $board_config['record_online_date'] . "'
					WHERE config_name = 'record_online_date'";
					
				if (!$db->sql_query($sql, 300))
				{
					mx_message_die(GENERAL_ERROR, 'Could not update online user record (date)', '', __LINE__, __FILE__, $sql);
				}
				$board_config['record_online_users'] = $total_online_users;
				$board_config['record_online_date'] = $board_config['record_online_date'];
				$mx_cache->put('phpbb_config', $board_config);
			break;
		}
	}

	if ( $total_online_users == 0 )
	{
		$l_t_user_s = $lang['Online_users_zero_total'];
	}
	else if ( $total_online_users == 1 )
	{
		$l_t_user_s = $lang['Online_user_total'];
	}
	else
	{
		$l_t_user_s = $lang['Online_users_total'];
	}

	if ( $logged_visible_online == 0 )
	{
		$l_r_user_s = $lang['Reg_users_zero_total'];
	}
	else if ( $logged_visible_online == 1 )
	{
		$l_r_user_s = $lang['Reg_user_total'];
	}
	else
	{
		$l_r_user_s = $lang['Reg_users_total'];
	}

	if ( $logged_hidden_online == 0 )
	{
		$l_h_user_s = $lang['Hidden_users_zero_total'];
	}
	else if ( $logged_hidden_online == 1 )
	{
		$l_h_user_s = $lang['Hidden_user_total'];
	}
	else
	{
		$l_h_user_s = $lang['Hidden_users_total'];
	}

	if ( $guests_online == 0 )
	{
		$l_g_user_s = $lang['Guest_users_zero_total'];
	}
	else if ( $guests_online == 1 )
	{
		$l_g_user_s = $lang['Guest_user_total'];
	}
	else
	{
		$l_g_user_s = $lang['Guest_users_total'];
	}

	$l_online_users = sprintf($l_t_user_s, $total_online_users);
	$l_online_users .= sprintf($l_r_user_s, $logged_visible_online);
	$l_online_users .= sprintf($l_h_user_s, $logged_hidden_online);
	$l_online_users .= sprintf($l_g_user_s, $guests_online);
}

// ================================================================================
// The following code is backported from index.php (phpBB 2.0.13)
// ================================================================================

//
// If you don't use these stats on your index you may want to consider
// removing them
//
$total_posts = phpBB2::get_db_stat('postcount');
$total_users = phpBB2::get_db_stat('usercount');
$newest_userdata = phpBB2::get_db_stat('newestuser');
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'phpbb2':
		$newest_username = $newest_userdata['username'];
		$newest_uid = $newest_userdata['user_id'];
	break;
	
	case 'smf2':
		$newest_username = $board_config['latestRealName'];
		$newest_uid = $board_config['latestMember'];
	break;
	
	case 'phpbb3':
	case 'olympus':
	default:
		$newest_username = $board_config['newest_username'];
		$newest_uid = $board_config['newest_user_id'];
	break;
}


switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'phpbb2':	
		if ($newest_userdata['user_level'] == ADMIN)
		{
			$newest_color = $theme['fontcolor3'];
			$newest_username = '<b>' . $newest_username . '</b>';
		}
		else if ($newest_userdata['user_level'] == MOD)
		{
			$newest_color = $theme['fontcolor2'];
			$newest_username = '<b>' . $newest_username . '</b>';
		}
		$newest_style_color = 'style="color:#' . $newest_color . '"';
		//This is not used in internal mode template, but here only added
		$newest_user = "The newest registered user is " . $mx_backend->get_username_string('full', $newest_uid, $newest_username, $newest_color);
	break;
	
	case 'smf2':	
		$newest_color = $theme['fontcolor3'];
		$newest_username = '<b>' . $newest_username . '</b>';
		$newest_style_color = 'style="color:#' . $newest_color . '"';
		//This is not used in internal mode template, but here only added
		$newest_user = sprintf("tr()The newest registered user is ", $mx_backend->get_username_string('full', $newest_uid, $newest_username, $newest_color));
	break;	

	case 'phpbb3':
	case 'olympus':
	default:
		$newest_color = $board_config['newest_user_colour'];
		$newest_style_color = ($newest_color) ? ' style="color:#' . $newest_color . '" class="username-coloured"' : '';
		$newest_user = sprintf($mx_user->lang['NEWEST_USER'], $mx_backend->get_username_string('full', $newest_uid, $newest_username, $newest_color));
	break;
}

if( $total_posts == 0 )
{
	$l_total_post_s = $lang['Posted_articles_zero_total'];
}
else if( $total_posts == 1 )
{
	$l_total_post_s = $lang['Posted_article_total'];
}
else
{
	$l_total_post_s = $lang['Posted_articles_total'];
}

if( $total_users == 0 )
{
	$l_total_user_s = $lang['Registered_users_zero_total'];
}
else if( $total_users == 1 )
{
	$l_total_user_s = $lang['Registered_user_total'];
}
else
{
	$l_total_user_s = $lang['Registered_users_total'];
}

switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'phpbb2':
	case 'smf2':
	break;

	case 'phpbb3':
	default:
		// Grab group details for legend display
		if ($phpbb_auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel'))
		{
			$sql = 'SELECT group_id, group_name, group_colour, group_type
				FROM ' . GROUPS_TABLE . '
				WHERE group_legend = 1
				ORDER BY group_name ASC';
		}
		else
		{
			$sql = 'SELECT g.group_id, g.group_name, g.group_colour, g.group_type
				FROM ' . GROUPS_TABLE . ' g
				LEFT JOIN ' . USER_GROUP_TABLE . ' ug
					ON (
						g.group_id = ug.group_id
						AND ug.user_id = ' . $mx_user->data['user_id'] . '
						AND ug.user_pending = 0
				)
				WHERE g.group_legend = 1
					AND (g.group_type <> ' . GROUP_HIDDEN . ' OR ug.user_id = ' . $mx_user->data['user_id'] . ')
				ORDER BY g.group_name ASC';
		}
		$result = $db->sql_query($sql);
	break;
}

$legend = '';

switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'phpbb2':
	case 'smf2':	
		$legend .= (($legend != '') ? ', ' : '') . '[' . sprintf($lang['Admin_online_color'], '<span style="color:#' . $theme['fontcolor3'] . '">', '</span>') . ']  [' . sprintf($lang['Mod_online_color'], '<span style="color:#' . $theme['fontcolor2'] . '">', '</span>') . ']';
	break;

	case 'phpbb3':
	case 'olympus':
	default:
		while ($row = $db->sql_fetchrow($result))
		{
			$colour_text = ($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . '"' : '';

			if ($row['group_name'] == 'BOTS')
			{
				$legend .= (($legend != '') ? ', ' : '') . '<span' . $colour_text . '>' . $mx_user->lang['G_BOTS'] . '</span>';
			}
			else
			{
				$legend .= (($legend != '') ? ', ' : '') . '<a' . $colour_text . ' href="' . mx3_append_sid(PHPBB_URL . "memberlist.$phpEx", 'mode=group&amp;g=' . $row['group_id']) . '">' . (($row['group_type'] == GROUP_SPECIAL) ? $mx_user->lang['G_' . $row['group_name']] : $row['group_name']) . '</a>';
			}
		}
		$db->sql_freeresult($result);
	break;
}

// Generate birthday list if required ...
$birthday_list = '';

switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'phpbb2':
	case 'smf2':	
	break;

	case 'phpbb3':
	case 'olympus':
	default:
		if ($board_config['load_birthdays'] && $board_config['allow_birthdays'])
		{
			$now = getdate(time() + $mx_user->timezone + $mx_user->dst - date('Z'));
			$sql = 'SELECT user_id, username, user_colour, user_birthday
				FROM ' . USERS_TABLE . "
				WHERE user_birthday LIKE '" . $db->sql_escape(sprintf('%2d-%2d-', $now['mday'], $now['mon'])) . "%'
					AND user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')';
			$result = $db->sql_query($sql);
			
			while ($row = $db->sql_fetchrow($result))
			{
				$birthday_list .= (($birthday_list != '') ? ', ' : '') . $mx_backend->get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
				if ($age = (int) substr($row['user_birthday'], -4))
				{
					$birthday_list .= ' (' . ($now['year'] - $age) . ')';
				}
			}
			$db->sql_freeresult($result);
		}
	break;
}

// ================================================================================
// Send our Who's Online block to the browser
// ================================================================================

$template->set_filenames(array(
	'body_online' => 'mx_online.tpl')
);

$template->assign_vars(array(
	//
	// Template variables particular to the MX-Publisher Online Block.
	//
	'BLOCK_SIZE' => $block_size,

	//
	// Template variables part of phpBB includes/page_header.php
	//
	'TOTAL_USERS_ONLINE' => $l_online_users,
	'LOGGED_IN_USER_LIST' => $online_userlist,
	'RECORD_USERS' => sprintf($lang['Record_online_users'], $board_config['record_online_users'], phpBB2::create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),
	'L_WHO_IS_ONLINE' => $lang['Who_is_Online'],
	'ONLINE_LEGEND'		=> $legend,
	'L_ONLINE_LEGEND'		=> !empty($mx_user->lang['LEGEND']) ? $mx_user->lang['LEGEND'] : 'Legend',
	'ONLINE_BIRTHDAY_LIST'	=> $birthday_list,
	
	//For comp. with phpBB2 backend
	'L_WHOSONLINE_ADMIN' => isset($theme['fontcolor3']) ? sprintf($lang['Admin_online_color'], '<span style="color:#' . $theme['fontcolor3'] . '">', '</span>') : '',
	'L_WHOSONLINE_MOD' => isset($theme['fontcolor2']) ? sprintf($lang['Mod_online_color'], '<span style="color:#' . $theme['fontcolor2'] . '">', '</span>') : '',	
	'L_ONLINE_EXPLAIN' => $lang['Online_explain'],

	'ONLINE_IMG'  => $images['mx_who_is_online'],
	'U_VIEWONLINE' => mx_append_sid(PHPBB_URL.'viewonline.'.$phpEx),

	//
	// Template variables part of phpBB index.php
	//
	'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts),
	'TOTAL_USERS' => sprintf($l_total_user_s, $total_users),
	'NEWEST_USER' => $newest_user,

));

	switch (PORTAL_BACKEND)
	{
		case 'internal':
		case 'smf2':
		
		break;
		
		default:
			$template->assign_block_vars("switch_phpbb", array());
	}

$template->pparse('body_online');
?>