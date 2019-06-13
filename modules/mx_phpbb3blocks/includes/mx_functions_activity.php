<?php
/**
*
* @package MX-Publisher Module - mx_phpbb3blocks
* @author Highway of Life ( David Lewis ) http://startrekguide.com
* @version $Id: mx_functions_activity.php,v 1.1 2008/10/04 07:04:38 orynider Exp $
* @copyright (c) 2008 Star Trek Guide Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PORTAL'))
{
	exit();
}

/**
 * Display extra stats, activity over the last 24 hours for new users, posts and topics.
 *
 * @return bool
 */
function mx_activity_block()
{
	global $template, $mx_user, $lang;

	//$mx_user->add_lang('mods/activity_stats');

	// if the user is a bot, we won’t even process this function...
	if ($mx_user->data['is_bot'])
	{
		return false;
	}

	// obtain user activity data
	$active_users = mx_obtain_active_user_data();
	
	// obtain posts/topics/new users activity
	$activity = mx_obtain_activity_data();

	// 24 hour users online list, assign to the template block: lastvisit
	foreach ($active_users as $row)
	{
			$template->assign_block_vars('lastvisit', array(
				'USERNAME_FULL'	=> mx_get_username_string((($row['user_type'] == USER_IGNORE) ? 'no_profile' : 'full'), $row['user_id'], $row['username'], $row['user_colour']),
			));
	}

	// assign the stats to the template.
	$template->assign_vars(array(
		'USERS_24HOUR_TOTAL'	=> sprintf($lang['USERS_24HOUR_TOTAL'], sizeof($active_users)),
		'24HOUR_TOPICS'			=> sprintf($lang['24HOUR_TOPICS'], $activity['topics']),
		'24HOUR_POSTS'			=> sprintf($lang['24HOUR_POSTS'], $activity['posts']),
		'24HOUR_USERS'			=> sprintf($lang['24HOUR_USERS'], $activity['users']),
	));

	return true;
}

/**
 * Obtain an array of active users over the last 24 hours.
 *
 * @return array
 */
function mx_obtain_active_user_data()
{
	global $mx_cache;

	if (($active_users = $mx_cache->get('_active_users')) === false)
	{
		global $db;

		$active_users = array();

		// grab a list of users who are currently online
		// and users who have visited in the last 24 hours
		$sql_ary = array(
			'SELECT'	=> 'u.user_id, u.user_colour, u.username, u.user_type',
			'FROM'		=> array(USERS_TABLE => 'u'),
			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array(SESSIONS_TABLE => 's'),
					'ON'	=> 's.session_user_id = u.user_id',
				),
			),
			'WHERE'		=> 'u.user_lastvisit > ' . (time() - 86400) . ' OR s.session_user_id <> ' . ANONYMOUS,
			'GROUP_BY'	=> 'u.user_id',
			'ORDER_BY'	=> 'u.username',
		);

		$result = $db->sql_query($db->sql_build_query('SELECT', $sql_ary));

		while ($row = $db->sql_fetchrow($result))
		{
			$active_users[$row['user_id']] = array(
				'user_id'		=> $row['user_id'],
				'user_type'		=> $row['user_type'],
				'username'		=> $row['username'],
				'user_colour'	=> $row['user_colour'],
			);
		}
		$db->sql_freeresult($result);

		// cache this data for 1 hour, this improves performance
		$mx_cache->put('_active_users', $active_users, 3600);
	}

	return $active_users;
}

/**
 * obtained cached 24 hour activity data
 *
 * @return array
 */
function mx_obtain_activity_data()
{
	global $mx_cache;

	if (($activity = $mx_cache->get('_activity_mod')) === false)
	{
		global $db;

		// set interval to 24 hours ago
		$interval = time() - 86400;

		$activity = array();

		// total new posts in the last 24 hours
		$sql = 'SELECT COUNT(post_id) AS new_posts
				FROM ' . POSTS_TABLE . '
				WHERE post_time > ' . $interval;
		$result = $db->sql_query($sql);
		$activity['posts'] = $db->sql_fetchfield('new_posts');
		$db->sql_freeresult($result);

		// total new topics in the last 24 hours
		$sql = 'SELECT COUNT(topic_id) AS new_topics
				FROM ' . TOPICS_TABLE . '
				WHERE topic_time > ' . $interval;
		$result = $db->sql_query($sql);
		$activity['topics'] = $db->sql_fetchfield('new_topics');
		$db->sql_freeresult($result);

		// total new users in the last 24 hours, counts inactive users as well
		$sql = 'SELECT COUNT(user_id) AS new_users
				FROM ' . USERS_TABLE . '
				WHERE user_regdate > ' . $interval;
		$result = $db->sql_query($sql);
		$activity['users'] = $db->sql_fetchfield('new_users');
		$db->sql_freeresult($result);

		// cache this data for 1 hour, this improves performance
		$mx_cache->put('_activity_mod', $activity, 3600);
	}

	return $activity;
}
?>