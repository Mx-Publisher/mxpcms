<?php
/**
*
* @package MX-Publisher Module - mx_phpbb2blocks
* @version $Id: mx_poll.php,v 1.7 2013/06/28 15:36:42 orynider Exp $
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
include_once( $module_root_path . 'includes/phpbb2blocks_constants.' . $phpEx );

// --------------------------------------------------------------------------------
// Poll Block - based on posting.php and viewtopic.php from phpBB 2.0.13 (see below)
//
// Please, do not reformat the code nor touch indentation. It has been left as
// close to the original code as possible, intentionally. ;-)
// --------------------------------------------------------------------------------

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$message = $mx_block->get_parameters( 'Text' );

$topic_id = $mx_block->get_parameters( 'Poll_Display' );
$forum_lst_poll = $mx_block->get_parameters( 'poll_forum' );

$auth_data_sql_poll = $phpbb_auth->get_auth_forum();

if ( empty($forum_lst_poll) )
{
	$forum_lst_poll = $auth_data_sql_poll;
}

//
// store current page to generate correct url
//
$current_page = $mx_request_vars->request('page', MX_TYPE_INT, 1);

if ( $topic_id == 0 )
{
	$sql = "SELECT vote.topic_id
		FROM " . VOTE_DESC_TABLE . " vote,
			" . TOPICS_TABLE . " topic
		WHERE vote.topic_id = topic.topic_id
			AND forum_id IN ( $forum_lst_poll )
			AND forum_id IN ( $auth_data_sql_poll )
			AND (vote_start + vote_length > " . time() . "
			OR vote_length = 0)
		ORDER BY vote_start DESC ";
	if ( !( $result = $db->sql_query($sql) ) )
	{
		mx_message_die(GENERAL_ERROR, 'Could not obtain vote data', '', __LINE__, __FILE__, $sql);
	}
	if ( $poll_info = $db->sql_fetchrow($result) )
	{
		$topic_id = $poll_info['topic_id'];
	}
	$db->sql_freeresult($result);
}


// --------------------------------------------------------------------------------
// The following code is based on posting.php (around line 453) from phpBB 2.0.13
//

	$vote_id_name = 'vote_id_' . $topic_id;
	//
	// Vote in a poll
	//
	if ( !$mx_request_vars->is_empty_post($vote_id_name))
	{
		$vote_option_id = $mx_request_vars->post($vote_id_name, MX_TYPE_INT);

		$sql = "SELECT vd.vote_id
			FROM " . VOTE_DESC_TABLE . " vd, " . VOTE_RESULTS_TABLE . " vr
			WHERE vd.topic_id = $topic_id
				AND vr.vote_id = vd.vote_id
				AND vr.vote_option_id = $vote_option_id
			GROUP BY vd.vote_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, 'Could not obtain vote data for this topic', '', __LINE__, __FILE__, $sql);
		}

		if ( $vote_info = $db->sql_fetchrow($result) )
		{
			$vote_id = $vote_info['vote_id'];

			$sql = "SELECT *
				FROM " . VOTE_USERS_TABLE . "
				WHERE vote_id = $vote_id
					AND vote_user_id = " . $userdata['user_id'];
			if ( !($result2 = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not obtain user vote data for this topic', '', __LINE__, __FILE__, $sql);
			}
			$db->sql_freeresult($result);

			if ( !($row = $db->sql_fetchrow($result2)) )
			{
				$sql = "UPDATE " . VOTE_RESULTS_TABLE . "
					SET vote_result = vote_result + 1
					WHERE vote_id = $vote_id
						AND vote_option_id = $vote_option_id";
				if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not update poll result', '', __LINE__, __FILE__, $sql);
				}

				$sql = "INSERT INTO " . VOTE_USERS_TABLE . " (vote_id, vote_user_id, vote_user_ip)
					VALUES ($vote_id, " . $userdata['user_id'] . ", '$user_ip')";
				if ( !$db->sql_query($sql, END_TRANSACTION) )
				{
					mx_message_die(GENERAL_ERROR, "Could not insert user_id for poll", '', __LINE__, __FILE__, $sql);
				}

				$message = $lang['Vote_cast'];
			}
			else
			{
				$message = $lang['Already_voted'];
			}
			$db->sql_freeresult($result2);
		}
		else
		{
			$message = $lang['No_vote_option'];
		}
		$db->sql_freeresult($result);

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . mx_append_sid(PORTAL_URL . "index.$phpEx?page=$current_page&amp;vote=viewresult") . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Click_view_voted'], '<a href="' . mx_append_sid(PORTAL_URL . "index.$phpEx?page=$current_page&amp;vote=viewresult") . '">', '</a>');

		mx_block_message($lang['Surveys_Polls'], $message);
		return;
	}

// --------------------------------------------------------------------------------
// The following code is based on viewtopic.php (around line 674) from phpBB 2.0.13
//

//
// Does this topic contain a poll?
//
//if ( !empty($forum_topic_data['topic_vote']) )
{
	$s_hidden_fields = '';

	$sql = "SELECT vd.vote_id, vd.vote_text, vd.vote_start, vd.vote_length, vr.vote_option_id, vr.vote_option_text, vr.vote_result
		FROM " . VOTE_DESC_TABLE . " vd, " . VOTE_RESULTS_TABLE . " vr
		WHERE vd.topic_id = $topic_id
			AND vr.vote_id = vd.vote_id
		ORDER BY vr.vote_option_id ASC";
	if ( !($result = $db->sql_query($sql)) )
	{
		$mx_block->show_title = false;
		$mx_block->show_block = false;
		return;	//mx_message_die(GENERAL_ERROR, "Could not obtain vote data for this topic", '', __LINE__, __FILE__, $sql);
	}

	if ( $vote_info = $db->sql_fetchrowset($result) )
	{
		$db->sql_freeresult($result);
		$vote_options = count($vote_info);

		$vote_id = $vote_info[0]['vote_id'];
		$vote_title = $vote_info[0]['vote_text'];

		$sql = "SELECT vote_id
			FROM " . VOTE_USERS_TABLE . "
			WHERE vote_id = $vote_id
				AND vote_user_id = " . $userdata['user_id'];
		if ( !($result = $db->sql_query($sql)) )
		{
			$mx_block->show_title = false;
			$mx_block->show_block = false;
			return;	//mx_message_die(GENERAL_ERROR, "Could not obtain user vote data for this topic", '', __LINE__, __FILE__, $sql);
		}

		$user_voted = ( $row = $db->sql_fetchrow($result) ) ? TRUE : 0;
		$db->sql_freeresult($result);

		if ($mx_request_vars->is_request('vote') || !$userdata['session_logged_in'])
		{
			$view_result = ($mx_request_vars->request('vote') == 'viewresult' || !$userdata['session_logged_in']) ? TRUE : 0;
		}
		else
		{
			$view_result = 0;
		}

		$poll_expired = ( $vote_info[0]['vote_length'] ) ? ( ( $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] < time() ) ? TRUE : 0 ) : 0;

		if ( $user_voted || $view_result || $poll_expired )
		{
			$template->set_filenames(array(
				'pollbox' => 'mx_poll_result.tpl')
			);

			$vote_results_sum = 0;

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_results_sum += $vote_info[$i]['vote_result'];
			}

			$vote_graphic = 0;
			$vote_graphic_max = count($images['voting_graphic']);

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_percent = ( $vote_results_sum > 0 ) ? $vote_info[$i]['vote_result'] / $vote_results_sum : 0;
				$vote_graphic_length = is_numeric($block_size) ? round($vote_percent * ( $block_size - 50 )) : $vote_percent * 200;

				$vote_graphic_img = $images['mx_voting_graphic'][$vote_graphic];
				$vote_graphic = ($vote_graphic < $vote_graphic_max - 1) ? $vote_graphic + 1 : 0;

				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}

				$template->assign_block_vars('poll_option', array(
					'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'],
					'POLL_OPTION_RESULT' => $vote_info[$i]['vote_result'],
					'POLL_OPTION_PERCENT' => sprintf('%.1d%%', ( $vote_percent * 100 )),

					'POLL_OPTION_IMG' => $vote_graphic_img,
					'POLL_OPTION_IMG_WIDTH' => $vote_graphic_length)
				);
			}

			$template->assign_vars(array(
				'L_TITLE' => $lang['Surveys_Polls'],
				'U_PHPBB_ROOT_PATH' => PHPBB_URL,
				'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,
				'L_TOTAL_VOTES' => $lang['Total_votes'],
				'TOTAL_VOTES' => $vote_results_sum,
				'U_URL' => mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?t=$topic_id"))
			);

		}
		else
		{
			$template->set_filenames(array(
				'pollbox' => 'mx_poll_ballot.tpl')
			);

			for($i = 0; $i < $vote_options; $i++)
			{
				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}
				$template->assign_block_vars("poll_option", array(
					'VOTE_ID' => $vote_id_name,
					'POLL_OPTION_ID' => $vote_info[$i]['vote_option_id'],
					'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'])
				);
			}

			$template->assign_vars(array(
				'BLOCK_SIZE' => $block_size,
				'L_TITLE' => $lang['Surveys_Polls'],
				'L_SUBMIT_VOTE' => $lang['Submit_vote'],
				'L_VIEW_RESULTS' => $lang['View_results'],
				'U_VIEW_RESULTS' => mx_append_sid(PORTAL_URL . "index.$phpEx?page=$current_page&amp;vote=viewresult"),
				'U_URL' => mx_append_sid(PHPBB_URL . "viewtopic.$phpEx?t=$topic_id"))
			);

			$s_hidden_fields = '<input type="hidden" name="topic_id" value="' . $topic_id . '" /><input type="hidden" name="mode" value="vote" />';
		}

		if ( count($orig_word) )
		{
			$vote_title = preg_replace($orig_word, $replacement_word, $vote_title);
		}

		$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		$template->assign_vars(array(
			'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
			'U_PHPBB_ROOT_PATH' => PHPBB_URL,
			'POLL_QUESTION' => $vote_title,
			'VOTE_LCAP' => $images['mx_vote_lcap'],
			'VOTE_RCAP' => $images['mx_vote_rcap'],
			'S_HIDDEN_FIELDS' => ( !empty($s_hidden_fields) ? $s_hidden_fields : '' ),
			'S_POLL_ACTION' => mx_append_sid(PORTAL_URL . "index.$phpEx?page=$current_page"))
		);

		$template->pparse('pollbox');
	}
	else
	{
		$mx_block->show_title = false;
		$mx_block->show_block = false;
	}
}

?>