<?php
/**
*
* @package Functions_phpBB
* @version $Id: bbcode.php,v 1.1 2014/05/18 06:26:59 orynider Exp $
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
// Now load some bbcodes, to be extended for this backend (see below)
//
include_once($mx_root_path . 'includes/mx_functions_bbcode.' . $phpEx); // BBCode associated functions

/**
 * MXP BBcodes
 * @package MX-Publisher
 */
class mx_bbcode extends bbcode_base
{
	var $smiley_path_url = '';
	var $smiley_root_path =	'';
	var $smilies_path = '';

	var $smiley_url = 'smile_url';
	var $smiley_id = 'smilies_id';
	var $emotion = 'emoticon';

	var $bbcode_uid = '';
	var $bbcode_bitfield = '';
	var $bbcode_cache = array();
	var $bbcode_template = array();

	var $bbcodes = array();

	var $template_bitfield;
	var $template_filename = '';

	function mx_bbcode($bitfield = '')
	{
		global $board_config, $phpbb_root_path;

		if ($bitfield)
		{
			$this->bbcode_bitfield = $bitfield;
			$this->bbcode_cache_init();
		}

		$this->smiley_path_url = PHPBB_URL; //change this to PORTAL_URL when shared folder will be removed
		$this->smiley_root_path =	$phpbb_root_path; //same here

		$this->smilies_path = str_replace("//", "/", $board_config['smilies_path']);
	}

	/**
	 * bbcode to html.
	 *
	 * Convert the bbcode to html
	 *
	 * @param string $bbtext
	 * @param string $bbcode_uid
	 * @param boolean $smilies_on
	 * @return string
	 */
	function decode($bbtext, $bbcode_uid, $smilies_on = true)
	{
		global $mx_root_path, $phpbb_root_path, $phpEx, $mx_page;

		$mytext = stripslashes($bbtext);
		if (!empty($bbcode_uid))
		{
			$mytext = $this->bbencode_second_pass($mytext, $bbcode_uid);
		}
		if ($smilies_on)
		{
			$mytext = $this->smilies_pass($mytext);
		}
		$mytext = str_replace("\n", "\n<br />\n", $mytext);
		return $this->make_clickable($mytext);
	}

	//
	// This function will prepare a posted message for
	// entry into the database.
	//
	function prepare_message($message, $html_on, $bbcode_on, $smile_on, $bbcode_uid = 0)
	{
		global $board_config, $html_entities_match, $html_entities_replace;

		//
		// Clean up the message
		//
		$message = trim($message);

		if ($html_on)
		{
			// If HTML is on, we try to make it safe
			// This approach is quite agressive and anything that does not look like a valid tag
			// is going to get converted to HTML entities
			$message = stripslashes($message);
			$html_match = '#<[^\w<]*(\w+)((?:"[^"]*"|\'[^\']*\'|[^<>\'"])+)?>#';
			$matches = array();

			$message_split = preg_split($html_match, $message);
			preg_match_all($html_match, $message, $matches);

			$message = '';

			foreach ($message_split as $part)
			{
				$tag = array(array_shift($matches[0]), array_shift($matches[1]), array_shift($matches[2]));
				$message .= preg_replace($html_entities_match, $html_entities_replace, $part) . clean_html($tag);
			}

			$message = addslashes($message);
			$message = str_replace('&quot;', '\&quot;', $message);
		}
		else
		{
			$message = preg_replace($html_entities_match, $html_entities_replace, $message);
		}

		if($bbcode_on && $bbcode_uid != '')
		{
			$message = $this->bbencode_first_pass($message, $bbcode_uid);
		}

		return $message;
	}

	/**
	 * phpBB Smilies pass.
	 *
	 * Hacking smilies_pass from phpbb/includes/bbcode.php
	 *
	 * @param string $message
	 * @return string
	 *
	*/
	function smilies_pass($message)
	{
		static $orig, $repl;
		global $board_config, $mx_root_path, $phpbb_root_path, $phpEx;

		if (!isset($orig))
		{
			global $db;
			$orig = $repl = array();

			$sql = 'SELECT * FROM ' . SMILIES_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't obtain smilies data", "", __LINE__, __FILE__, $sql);
			}

			$smilies = $db->sql_fetchrowset($result);

			if (count($smilies))
			{
				@usort($smilies, 'smiley_sort');
			}

			for ($i = 0; $i < count($smilies); $i++)
			{
				$orig[] = "/(?<=.\W|\W.|^\W)" . preg_quote($smilies[$i]['code'], "/") . "(?=.\W|\W.|\W$)/";
				$repl[] = '<img src="' . $this->smiley_path_url . $board_config['smilies_path'] . '/' . $smilies[$i][$this->smiley_url] . '" alt="' . $smilies[$i][$this->emotion] . '" border="0" />';
			}
		}

		if (count($orig))
		{
			$message = preg_replace($orig, $repl, ' ' . $message . ' ');
			$message = substr($message, 1, -1);
		}

		return $message;
	}

	/**
	 * Generate smilies.
	 *
	 * Hacking generate_smilies from phpbb/includes/functions_post(ing).php
	 *
	 * @param string $mode
	 * @param integer $page_id
	*
	* Fill smiley templates (or just the variables) with smilies, either in a window or inline
	*/
	function generate_smilies($mode, $forum_id)
	{
		global $mx_page, $board_config, $template, $mx_root_path, $phpbb_root_path, $phpEx;
		global $db, $lang, $images, $theme;
		global $user_ip, $session_length, $starttime;
		global $userdata, $phpbb_auth, $mx_user;

		$inline_columns = 4;
		$inline_rows = 5;
		$window_columns = 8;

		if ($mode == 'window')
		{
			$mx_user->init($user_ip, PAGE_INDEX);

			$gen_simple_header = TRUE;
			$page_title = $lang['Emoticons'];

			include($mx_root_path . 'includes/page_header.'.$phpEx);

			$template->set_filenames(array(
				'smiliesbody' => 'posting_smilies.tpl')
			);
		}

		$sql = "SELECT emoticon, code, smile_url
			FROM " . SMILIES_TABLE . "
			ORDER BY smilies_id";
		if ($result = $db->sql_query($sql))
		{
			$num_smilies = 0;
			$rowset = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if (empty($rowset[$row['smile_url']]))
				{
					$rowset[$row['smile_url']]['code'] = str_replace("'", "\\'", str_replace('\\', '\\\\', $row['code']));
					$rowset[$row['smile_url']]['emoticon'] = $row['emoticon'];
					$num_smilies++;
				}
			}

			if ($num_smilies)
			{
				$smilies_count = ($mode == 'inline') ? min(19, $num_smilies) : $num_smilies;
				$smilies_split_row = ($mode == 'inline') ? $inline_columns - 1 : $window_columns - 1;

				$s_colspan = 0;
				$row = 0;
				$col = 0;

				while (list($smile_url, $data) = @each($rowset))
				{
					if (!$col)
					{
						$template->assign_block_vars('smilies_row', array());
					}

					$template->assign_block_vars('smilies_row.smilies_col', array(
						'SMILEY_CODE' => $data['code'],
						'SMILEY_IMG' => $this->smiley_path_url  . $board_config['smilies_path'] . '/' . $smile_url,
						'SMILEY_DESC' => $data['emoticon'])
					);

					$s_colspan = max($s_colspan, $col + 1);

					if ($col == $smilies_split_row)
					{
						if ($mode == 'inline' && $row == $inline_rows - 1)
						{
							break;
						}
						$col = 0;
						$row++;
					}
					else
					{
						$col++;
					}
				}

				if ($mode == 'inline' && $num_smilies > $inline_rows * $inline_columns)
				{
					$template->assign_block_vars('switch_smilies_extra', array());

					$template->assign_vars(array(
						'L_MORE_SMILIES' => $lang['More_emoticons'],
						'U_MORE_SMILIES' => mx3_append_sid(PHPBB_URL . "posting.$phpEx", "mode=smilies"))
					);
				}

				$template->assign_vars(array(
					'L_EMOTICONS' => $lang['Emoticons'],
					'L_CLOSE_WINDOW' => $lang['Close_window'],
					'S_SMILIES_COLSPAN' => $s_colspan)
				);
			}
		}

		if ($mode == 'window')
		{
			$template->pparse('smiliesbody');
			include($mx_root_path . 'includes/page_tail.'.$phpEx);
		}
	}
}
?>