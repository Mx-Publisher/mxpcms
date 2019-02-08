<?php
/**
*
* @package MX-Publisher Module - mx_phpbb3blocks
* @version $Id: mx_forum.php,v 1.7 2013/06/28 15:36:44 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$show_title = $mx_block->block_info['show_title'];

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

//
// Start session management
//
//$mx_user->session_begin();
//$mx_user->init($user_ip, PAGE_INDEX);
$phpbb_auth->acl($mx_user->data); // Do only once, in user_init // Move later

$mx_user->setup('viewforum');

//
// End session management
//
//$auth_data_sql_msg = $phpbb_auth->get_auth_forum();
//die(var_export($auth_data_sql_msg));
//die('s'.var_export($phpbb_auth->acl_getf('f_list', true)));

mx_display_forums('', $board_config['load_moderators']);

// Set some stats, get posts count from forums data if we... hum... retrieve all forums data
$total_posts	= $board_config['num_posts'];
$total_topics	= $board_config['num_topics'];
$total_users	= $board_config['num_users'];

$l_total_user_s = ($total_users == 0) ? 'TOTAL_USERS_ZERO' : 'TOTAL_USERS_OTHER';
$l_total_post_s = ($total_posts == 0) ? 'TOTAL_POSTS_ZERO' : 'TOTAL_POSTS_OTHER';
$l_total_topic_s = ($total_topics == 0) ? 'TOTAL_TOPICS_ZERO' : 'TOTAL_TOPICS_OTHER';

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
if ( !($result = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, 'Could not query user groups status', '', __LINE__, __FILE__, $sql);
}

$legend = '';
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

// Generate birthday list if required ...
$birthday_list = '';
if ($board_config['load_birthdays'] && $board_config['allow_birthdays'])
{
	$now = getdate(time() + $mx_user->timezone + $mx_user->dst - date('Z'));
	$sql = 'SELECT user_id, username, user_colour, user_birthday
		FROM ' . USERS_TABLE . "
		WHERE user_birthday LIKE '" . $db->sql_escape(sprintf('%2d-%2d-', $now['mday'], $now['mon'])) . "%'
			AND user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')';
	if ( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not query user_birthdays', '', __LINE__, __FILE__, $sql);
	}

	while ($row = $db->sql_fetchrow($result))
	{
		$birthday_list .= (($birthday_list != '') ? ', ' : '') . mx_get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);

		if ($age = (int) substr($row['user_birthday'], -4))
		{
			$birthday_list .= ' (' . ($now['year'] - $age) . ')';
		}
	}
	$db->sql_freeresult($result);
}

$template->set_filenames(array(
	'block_forum' => 'forumlist_body.tpl')
);

// Assign index specific vars
$template->assign_vars(array(
	'SHOW_TITLE'	=> $show_title,
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'TOTAL_POSTS'	=> sprintf($mx_user->lang[$l_total_post_s], $total_posts),
	'TOTAL_TOPICS'	=> sprintf($mx_user->lang[$l_total_topic_s], $total_topics),
	'TOTAL_USERS'	=> sprintf($mx_user->lang[$l_total_user_s], $total_users),
	//'NEWEST_USER'	=> sprintf($mx_user->lang['NEWEST_USER'], mx_get_username_string('full', $board_config['newest_user_id'], $board_config['newest_username'], $board_config['newest_user_colour'])),
	'NEWEST_USER'	=> sprintf('Newest User', mx_get_username_string('full', $board_config['newest_user_id'], $board_config['newest_username'], $board_config['newest_user_colour'])),
	'LEGEND'		=> $legend,
	'BIRTHDAY_LIST'	=> $birthday_list,

	'FORUM_IMG'				=> $mx_user->img('forum_read', 'NO_NEW_POSTS'),
	'FORUM_NEW_IMG'			=> $mx_user->img('forum_unread', 'NEW_POSTS'),
	'FORUM_LOCKED_IMG'		=> $mx_user->img('forum_read_locked', 'NO_NEW_POSTS_LOCKED'),
	'FORUM_NEW_LOCKED_IMG'	=> $mx_user->img('forum_unread_locked', 'NO_NEW_POSTS_LOCKED'),

	'S_LOGIN_ACTION'			=> mx3_append_sid(PHPBB_URL . "ucp.$phpEx", 'mode=login'),
	'S_DISPLAY_BIRTHDAY_LIST'	=> ($board_config['load_birthdays']) ? true : false,

	'U_MARK_FORUMS'		=> ($mx_user->data['is_registered'] || $board_config['load_anon_lastread']) ? mx3_append_sid(PHPBB_URL . "index.$phpEx", 'mark=forums') : '',
	'U_MCP'				=> ($phpbb_auth->acl_get('m_') || $phpbb_auth->acl_getf_global('m_')) ? mx3_append_sid(PHPBB_URL . "mcp.$phpEx", 'i=main&amp;mode=front', true, $mx_user->session_id) : '')
);


$template->pparse('block_forum');

?>