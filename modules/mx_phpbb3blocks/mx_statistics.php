<?php
/**
*
* @package MX-Publisher Module - mx_phpbb3blocks
* @version $Id: mx_statistics.php,v 1.3 2008/08/27 13:43:10 orynider Exp $
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
require_once( $module_root_path . 'includes/phpbb3blocks_constants.' . $phpEx );

//
// Start user modifiable variables
//
$return_limit = 10;
//
// End user modifiable variables
//

$template->assign_block_vars('switch_view', array());

//
// Vote Images based on the theme path, (i.e. templates/CURRNT_THEME/ is already inserted)
//
$vote_left = $images['mx_vote_lcap'] ;
$vote_right = $images['mx_vote_rcap'] ;
$vote_bar = $images['mx_vote_bar'];
$graph_image = $images['mx_voting_graphic'];

if( file_exists($module_root_path . 'language/lang_' . $mx_user->lang['default_lang'] . '/lang_main.' . $phpEx) )
{
	include($mx_root_path . 'includes/shared/phpbb2/language/lang_' . $mx_user->lang['default_lang'] . '/lang_admin.' . $phpEx);
	include($module_root_path . 'language/lang_' . $mx_user->lang['default_lang'] . '/lang_main.' . $phpEx);
}
else
{
	include($mx_root_path . 'includes/shared/phpbb2/language/lang_english/lang_admin.' . $phpEx);
	include($module_root_path . 'language/lang_english/lang_main.' . $phpEx);
}

//
// Do the math :) (i think this is the same method as in philip mayer's statistic's file)
// Taken from Acyd Burn.
//
function do_math($firstval, $value, $total, &$percentage, &$bar_percent)
{
	$cst = ( $firstval > 0 ) ? 90 / $firstval : 90;

	if( $value != 0 )
	{
		$percentage = ( $total ) ? round(min(100, ( $value / $total ) * 100)) : 0;
	}
	else
	{
		$percentage = 0;
	}

	$bar_percent = round($value * $cst);
}

$template->set_filenames(array(
	'body' => 'mx_statistics.tpl')
);

$template->assign_vars(array(
	"GRAPH_IMAGE" => $graph_image,

	"L_ADMIN_STATISTICS" => $lang['Admin_Stats'],
	"L_TOP_SMILIES" => $lang['Top_Smilies'],
	"L_MOST_ACTIVE" => $lang['Most_Active_Topics'],
	"L_MOST_VIEWED" => $lang['Most_Viewed_Topics'],
	"L_TOP_POSTERS" => $lang['Top_Posting_Users'],

	"L_USES" => $lang['Uses'],
	"L_RANK" => $lang['Rank'],
	"L_PERCENTAGE" => $lang['Percent'],
	"L_GRAPH" => $lang['Graph'],
	"L_REPLIES" => $lang['Replies'],
	"L_TOPIC" => $lang['Topic'],
	"L_VIEWS" => $lang['Views'],
	"L_USERNAME" => $lang['Username'],
	"L_POSTS" => $lang['Posts'],
	"L_STATISTIC" => $lang['Statistic'],
	"L_VALUE" => $lang['Value'],
	"L_IMAGE" => $lang['smiley_url'],
	"L_CODE" => $lang['smiley_code'],
	"PAGE_NAME" => $lang['Statistics'])
);

//
// Authorization SQL
//
$phpbb_auth->acl($mx_user->data); // Do only once, in user_init // Move later
$auth_data_sql_stats = $phpbb_auth->get_auth_forum();

//
// Getting voting bar info from template
//
/*
if( !$board_config['override_user_style'] )
{
	if( $userdata['user_id'] != ANONYMOUS && isset($userdata['user_style']) )
	{
		$style = $userdata['user_style'];
		if( !$theme )
		{
			$style = $board_config['default_style'];
		}
	}
	else
	{
		$style = $board_config['default_style'];
	}
}
else
{
	$style = $board_config['default_style'];
}


$sql = "SELECT * FROM " . THEMES_TABLE . " WHERE themes_id = $style";
if( !($result = $db->sql_query($sql)) )
{
	mx_message_die(CRITICAL_ERROR, "Couldn't query database for theme info.");
}
if( !($row = $db->sql_fetchrow($result)) )
{
	mx_message_die(CRITICAL_ERROR, "Couldn't get theme data for themes_id=$style.");
}
*/

$template->assign_vars(array(
	"LEFT_GRAPH_IMAGE" => $vote_left,
	"RIGHT_GRAPH_IMAGE" => $vote_right,
	"GRAPH_IMAGE" => $vote_bar)
);

//
// Top posters SQL
//
$sql = "SELECT user_id, username, user_colour, user_posts, user_birthday
	FROM " . USERS_TABLE . "
	WHERE user_id <> " . ANONYMOUS . " AND user_posts > 0
	ORDER BY user_posts DESC
	LIMIT " . $return_limit;

if( !($result = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, "Couldn't retrieve users data", "", __LINE__, __FILE__, $sql);
}

$user_count = $db->sql_numrows($result);
$user_data = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);
$percentage = 0;
$bar_percent = 0;

$firstcount = $user_data[0]['user_posts'];
$get_db_stats = phpBB2::get_db_stat( 'postcount' );

for( $i = 0; $i < $user_count; $i++ )
{
	do_math($firstcount, $user_data[$i]['user_posts'], $get_db_stats, $percentage, $bar_percent);
	
	$top_poster_profile = mx_get_username_string('full', $user_data[$i]['user_id'], $user_data[$i]['username'], $user_data[$i]['user_colour']);

	$template->assign_block_vars('users', array(
		"RANK" => $i + 1,
		"CLASS" => ( !( $i + 1 % 2 ) ) ? $theme['td_class2'] : $theme['td_class1'],
		"USERNAME" => $user_data[$i]['username'],
		"USERCOLOR" => $user_data[$i]['user_colour'],		
		"PERCENTAGE" => $percentage,
		"BAR" => $bar_percent,
		"POSTER_URL" => $top_poster_profile,
		"URL" => mx_append_sid(PHPBB_URL . "memberlist.php?mode=viewprofile&amp;u=" . $user_data[$i]['user_id']),
		"POSTS" => $user_data[$i]['user_posts'])
	);
}

//
// Most active topics SQL
//
$sql = "SELECT topic_id, topic_title, topic_replies
	FROM " . TOPICS_TABLE . "
	WHERE forum_id IN ( $auth_data_sql_stats )
		AND topic_status <> 2
		AND topic_replies > 0
	ORDER BY topic_replies DESC
	LIMIT " . $return_limit;

if( !($result = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, "Couldn't retrieve topic data", "", __LINE__, __FILE__, $sql);
}

$topic_data = $db->sql_fetchrowset($result);

for( $i = 0; $i < count($topic_data); $i++ )
{
	$template->assign_block_vars('topicreplies', array(
		"RANK" => $i + 1,
		"CLASS" => ( !( $i + 1 % 2 ) ) ? $theme['td_class2'] : $theme['td_class1'],
		"TITLE" => $topic_data[$i]['topic_title'],
		"REPLIES" => $topic_data[$i]['topic_replies'],
		"URL" => mx_append_sid(PHPBB_URL . "viewtopic.php?t=" . $topic_data[$i]['topic_id']))
	);
}

//
// Most viewed topics SQL
//
$rank = 0;
$sql = "SELECT topic_id, topic_title, topic_views
	FROM " . TOPICS_TABLE . "
	WHERE forum_id IN ( $auth_data_sql_stats )
		AND topic_status <> 2
		AND topic_views > 0
	ORDER BY topic_views DESC
	LIMIT " . $return_limit;

if( !($result = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, "Couldn't retrieve topic data", "", __LINE__, __FILE__, $sql);
}

$topic_data = $db->sql_fetchrowset($result);

for( $i = 0; $i < count($topic_data); $i++ )
{
	$template->assign_block_vars('topicviews', array(
		"RANK" => $i + 1,
		"CLASS" => ( !( $i + 1 % 2 ) ) ? $theme['td_class2'] : $theme['td_class1'],
		"TITLE" => $topic_data[$i]['topic_title'],
		"VIEWS" => $topic_data[$i]['topic_views'],
		"URL" => mx_append_sid(PHPBB_URL . "viewtopic.php?t=" . $topic_data[$i]['topic_id']))
	);
}

//
// Begin Of Administrative Statistics (based on admin/index.php)
// Also, takes into MX-Publisher tables (DB Size) and Attachment MOD
//
	//
	// Get forum statistics
	//
	$total_posts = $get_db_stats; //Already queried above
	$total_users = phpBB2::get_db_stat('usercount');
	$total_topics = phpBB2::get_db_stat('topiccount');

	$start_date = phpBB2::create_date($board_config['default_dateformat'], $board_config['board_startdate'], $board_config['board_timezone']);

	$boarddays = ( time() - $board_config['board_startdate'] ) / 86400;

	$posts_per_day = sprintf("%.2f", $total_posts / $boarddays);
	$topics_per_day = sprintf("%.2f", $total_topics / $boarddays);
	$users_per_day = sprintf("%.2f", $total_users / $boarddays);

	$avatar_dir_size = 0;

	if ($avatar_dir = @opendir($phpbb_root_path . $board_config['avatar_path']))
	{
		while( $file = @readdir($avatar_dir) )
		{
			if( $file != "." && $file != ".." )
			{
				$avatar_dir_size += @filesize($phpbb_root_path . $board_config['avatar_path'] . "/" . $file);
			}
		}
		@closedir($avatar_dir);

		//
		// This bit of code translates the avatar directory size into human readable format
		// Borrowed the code from the PHP.net annoted manual, origanally written by:
		// Jesse (jesse@jess.on.ca)
		//
		if($avatar_dir_size >= 1048576)
		{
			$avatar_dir_size = round($avatar_dir_size / 1048576 * 100) / 100 . " MB";
		}
		else if($avatar_dir_size >= 1024)
		{
			$avatar_dir_size = round($avatar_dir_size / 1024 * 100) / 100 . " KB";
		}
		else
		{
			$avatar_dir_size = $avatar_dir_size . " Bytes";
		}

	}
	else
	{
		// Couldn't open Avatar dir.
		$avatar_dir_size = $lang['Not_available'];
	}

	if($posts_per_day > $total_posts)
	{
		$posts_per_day = $total_posts;
	}

	if($topics_per_day > $total_topics)
	{
		$topics_per_day = $total_topics;
	}

	if($users_per_day > $total_users)
	{
		$users_per_day = $total_users;
	}

	//
	// DB size ... MySQL only
	//
	// This code is heavily influenced by a similar routine
	// in phpMyAdmin 2.2.0
	//
	if( preg_match("/^mysql/", SQL_LAYER) )
	{
		$sql = "SELECT VERSION() AS mysql_version";
		if($result = $db->sql_query($sql))
		{
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			$version = $row['mysql_version'];

			if( preg_match("/^(3\.23|4\.)/", $version) )
			{
				$db_name = ( preg_match("/^(3\.23\.[6-9])|(3\.23\.[1-9][1-9])|(4\.)/", $version) ) ? "`$dbname`" : $dbname;

				$sql = "SHOW TABLE STATUS
					FROM " . $db_name;
				if($result = $db->sql_query($sql))
				{
					$tabledata_ary = $db->sql_fetchrowset($result);

					$dbsize = 0;
					for($i = 0; $i < count($tabledata_ary); $i++)
					{
						if( $tabledata_ary[$i]['Type'] != "MRG_MyISAM" )
						{
							if( $table_prefix != "" && $mx_table_prefix != "" )
							{
								if( strstr($tabledata_ary[$i]['Name'], $table_prefix) || strstr($tabledata_ary[$i]['Name'], $mx_table_prefix) )
								{
									$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
								}
							}
							else
							{
								$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
							}
						}
					}
				} // Else we couldn't get the table status.
			}
			else
			{
				$dbsize = $lang['Not_available'];
			}
		}
		else
		{
			$dbsize = $lang['Not_available'];
		}
	}
	else if( preg_match("/^mssql/", SQL_LAYER) )
	{
		$sql = "SELECT ((SUM(size) * 8.0) * 1024.0) as dbsize
			FROM sysfiles";
		if( $result = $db->sql_query($sql) )
		{
			$dbsize = ( $row = $db->sql_fetchrow($result) ) ? intval($row['dbsize']) : $lang['Not_available'];
		}
		else
		{
			$dbsize = $lang['Not_available'];
		}
	}
	else
	{
		$dbsize = $lang['Not_available'];
	}

	if ( is_integer($dbsize) )
	{
		if( $dbsize >= 1048576 )
		{
			$dbsize = sprintf("%.2f MB", ( $dbsize / 1048576 ));
		}
		else if( $dbsize >= 1024 )
		{
			$dbsize = sprintf("%.2f KB", ( $dbsize / 1024 ));
		}
		else
		{
			$dbsize = sprintf("%.2f Bytes", $dbsize);
		}
	}
//
// End Of Administrative Statistics
//

//
// Newest user data
//
$newest_userdata = phpBB2::get_db_stat('newestuser');
$newest_user = $newest_userdata['username'];
$newest_uid = $newest_userdata['user_id'];
$sql = 'SELECT user_id, username, user_regdate, user_colour, user_birthday
	FROM ' . USERS_TABLE . "
	WHERE user_id = " . $newest_userdata['user_id'] . "
	LIMIT 1";
if( !($result = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, "Couldn't retrieve users data", "", __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$newest_user_date = $row['user_regdate'];

$newest_user_profile = mx_get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']); //'<a href="' . mx_append_sid(PHPBB_URL . "usercp.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$newest_uid") . '">' . $newest_user . '</a>';

//
// Most Online data
//
$sql = "SELECT *
	FROM " . CONFIG_TABLE . "
	WHERE config_name = 'record_online_users'
		OR config_name = 'record_online_date'";
if( !($result = $db->sql_query($sql)) )
{
	mx_message_die(GENERAL_ERROR, "Couldn't retrieve configuration data", "", __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$most_users_date = ( $row['config_value'] > 0 ) ? phpBB2::create_date($board_config['default_dateformat'], $row['config_value'], $board_config['board_timezone']) : $lang['Not_available'];

$most_users = ( $row['config_value'] > 0 ) ? $row['config_value'] : $lang['Not_available'];

$statistic_array = array($lang['Number_posts'], $lang['Posts_per_day'], $lang['Number_topics'], $lang['Topics_per_day'], $lang['Number_users'], $lang['Users_per_day'], $lang['Board_started'], $lang['Board_Up_Days'], $lang['Database_size'], $lang['Avatar_dir_size'], $lang['Latest_Reg_User_Date'], $lang['Latest_Reg_User'], $lang['Most_Ever_Online_Date'], $lang['Most_Ever_Online'], $lang['Gzip_compression']);
$value_array = array($total_posts, $posts_per_day, $total_topics, $topics_per_day, $total_users, $users_per_day, $start_date, sprintf('%.2f', $boarddays), $dbsize, $avatar_dir_size, phpBB2::create_date($board_config['default_dateformat'], $newest_user_date, $board_config['board_timezone']), sprintf($newest_user_profile), $most_users_date, $most_users, ( $board_config['gzip_compress'] ) ? $lang['Enabled'] : $lang['Disabled']);

//
// Disk Usage, if Attachment Mod is installed
//
if( defined('ATTACH_VERSION') )
{
	include($phpbb_root_path . 'attach_mod/includes/functions_admin.'.$phpEx);
	$disk_usage = get_formatted_dirsize();
	$statistic_array[] = $lang['Disk_usage'];
	$value_array[] = $disk_usage;
}

//
// Output Administrative Statistics
//
for( $i = 0; $i < count($statistic_array); $i += 2 )
{
	$template->assign_block_vars('adminrow', array(
		"STATISTIC" => $statistic_array[$i],
		"VALUE" => $value_array[$i],
		"STATISTIC2" => ( isset($statistic_array[$i + 1]) ) ? $statistic_array[$i + 1] : '',
		"VALUE2" => ( isset($value_array[$i + 1]) ) ? $value_array[$i + 1] : '')
	);
}

//
// Output the page
//
$template->pparse('body');
?>