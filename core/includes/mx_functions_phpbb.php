<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: mx_functions_phpbb.php,v 1.6 2012/10/25 09:49:16 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

/**
 * Included functions in this file: (validated for phpbb 2.0.10)
 * - mx_smilies_pass (from bbcode.php)
 * - mx_generate_smilies (from functions_post.php)
 * - mx_decode
 * - mx_init_userprefs (from functions.php)
 * - mx_setup_style (from functions.php)
 * - mx_message_die (from functions.php)
 * - mx_block_message (a message_die kind of function for blocks)
 * - mx_redirect (from functions.php)
 * - mx_generate_pagination (from functions.php)
 */

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}
 
//
// Hacking smilies_pass from phpbb/includes/bbcode.php
//
function mx_smilies_pass($message)
{
	static $orig, $repl;
	global $board_config, $mx_root_path, $phpbb_root_path, $phpEx;

	$smiley_path_url = PHPBB_URL;
	$smiley_root_path =	$phpbb_root_path;		
	$smiley_url = 'smile_url';
	$smiley_id = 'smilies_id';
	$emotion = 'emoticon';		

	$smilies_path = $board_config['smilies_path'];
	//$board_config['smilies_path'] = $smiley_path_url . $board_config['smilies_path'];

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
			$repl[] = '<img src="' . $smiley_path_url . $smilies_path . '/' . $smilies[$i][$smiley_url] . '" alt="' . $smilies[$i][$emotion] . '" border="0" />';
		}
	}

	if (count($orig))
	{
		$message = preg_replace($orig, $repl, ' ' . $message . ' ');
		$message = substr($message, 1, -1);
	}

	//$board_config['smilies_path'] = $smilies_path;

	return $message;
}

//
// Hacking generate_smilies from phpbb/includes/functions_post.php
//
/**
 * phpBB Smilies pass.
 *
 * Hacking smilies_pass from phpbb/includes/bbcode.php
 *
 * @param string $message
 * @return string
 */
function mx_smilies_pass_old($message)
{
	global $mx_page, $board_config, $phpbb_root_path, $phpEx;

	$smilies_path = $board_config['smilies_path'];
	$board_config['smilies_path'] = PHPBB_URL . $board_config['smilies_path'];
	$message = smilies_pass($message);
	$board_config['smilies_path'] = $smilies_path;
	return $message;
}

/**
 * Generate phpBB smilies.
 *
 * Hacking generate_smilies from phpbb/includes/functions_post(ing).php
 *
 * @param string $mode
 * @param integer $page_id
*
* Fill smiley templates (or just the variables) with smilies, either in a window or inline
*/
function mx_generate_smilies($mode, $forum_id)
{

	global $mx_page, $board_config, $template, $mx_root_path, $phpbb_root_path, $phpEx;
	global $db, $lang, $images, $theme;
	global $user_ip, $session_length, $starttime;
	global $userdata, $phpbb_auth, $mx_user;

	$inline_columns = 4;
	$inline_rows = 5;
	$window_columns = 8;

	$smiley_path_url = PHPBB_URL;
	$smiley_root_path =	$phpbb_root_path;
	$smiley_url = 'smile_url';
	
	if ($mode == 'window')
	{
		$mx_user->init($user_ip, PAGE_INDEX);

		$gen_simple_header = TRUE;
		$page_title = $lang['Emoticons'];

		include($mx_root_path . 'includes/page_header.'.$phpEx);
		
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
					'SMILEY_IMG' => $smiley_root_path . $board_config['smilies_path'] . '/' . $smile_url,
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
//
// Convert the bbcode to html
//
function mx_decode($bbtext, $bbcode_uid)
{
	$mytext = stripslashes($bbtext);
	$mytext = bbencode_second_pass($mytext, $bbcode_uid);
	$mytext = mx_smilies_pass($mytext);
	$mytext = str_replace("\n", "\n<br />\n", $mytext);
	$mytext = make_clickable($mytext);
	return $mytext;
}

//
// Initialise user settings on page load
function mx_init_userprefs($userdata)
{
	global $board_config, $theme, $images;
	global $template, $lang, $phpEx, $phpbb_root_path, $mx_root_path;
	global $nav_links;

	if ( $userdata['user_id'] != ANONYMOUS )
	{
		if ( !empty($userdata['user_lang']))
		{
			$board_config['default_lang'] = $userdata['user_lang'];
		}

		if ( !empty($userdata['user_dateformat']) )
		{
			$board_config['default_dateformat'] = $userdata['user_dateformat'];
		}

		if ( isset($userdata['user_timezone']) )
		{
			$board_config['board_timezone'] = $userdata['user_timezone'];
		}
	}

	if ( !file_exists($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx) )
	{
		$board_config['default_lang'] = 'english';
	}

	if ( file_exists($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx) )
	{
		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
	}

	if ( file_exists($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx) )
	{
		include($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
	}

	if ( defined('IN_ADMIN') )
	{
		if( !file_exists($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) || !file_exists($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) )
		{
			$board_config['default_lang'] = 'english';
		}
		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
		include($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
	} 

	//
	// Set up style
	//
	if ( !$board_config['override_user_style'] )
	{
		if ( $userdata['user_id'] != ANONYMOUS && $userdata['user_style'] > 0 )
		{
			if ( $theme = mx_setup_style($userdata['user_style']) )
			{
				return;
			}
		}
	}

	$theme = mx_setup_style($board_config['default_style']);

	//
	// Mozilla navigation bar
	// Default items that should be valid on all pages.
	// Defined here to correctly assign the Language Variables
	// and be able to change the variables within code.
	//
	$nav_links['top'] = array (
		'url' => mx_append_sid($phpbb_root_path . 'index.' . $phpEx),
		'title' => sprintf($lang['Forum_Index'], $board_config['sitename'])
	);
	$nav_links['search'] = array (
		'url' => mx_append_sid($phpbb_root_path . 'search.' . $phpEx),
		'title' => $lang['Search']
	);
	$nav_links['help'] = array (
		'url' => mx_append_sid($phpbb_root_path . 'faq.' . $phpEx),
		'title' => $lang['FAQ']
	);
	$nav_links['author'] = array (
		'url' => mx_append_sid($phpbb_root_path . 'memberlist.' . $phpEx),
		'title' => $lang['Memberlist']
	);

	return;
}

function mx_setup_style($style, $only_template = false)
{
	global $db, $board_config, $template, $images, $phpbb_root_path, $mx_root_path;

	$sql = "SELECT *
		FROM " . THEMES_TABLE . "
		WHERE themes_id = $style";
	if ( !($result = $db->sql_query($sql)) )
	{
		$style = 1;
		$sql = "SELECT *
			FROM " . THEMES_TABLE . "
			WHERE themes_id = $style";
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(CRITICAL_ERROR, 'Could not query database for theme info');
		}
	}

	if ( !($row = $db->sql_fetchrow($result)) )
	{
		mx_message_die(CRITICAL_ERROR, "Could not get theme data for themes_id [$style]");
	}

	$template_path = 'templates/' ;
	$template_name = $row['template_name'] ; 

	//
	// mxBB FIX for uninstalled themes ... use subSilver instead
	//
	if ( !file_exists($mx_root_path . $template_path . $template_name . '/mx_main_layout.tpl') )
	{
		$template_path = 'templates/';
		$template_name = 'subSilver';

		$style = 1;
		$sql = "SELECT *
			FROM " . THEMES_TABLE . "
			WHERE themes_id = $style";
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(CRITICAL_ERROR, 'Could not query database for theme info');
		}
		if ( !($row = $db->sql_fetchrow($result)) )
		{
			mx_message_die(CRITICAL_ERROR, "Could not get theme data for themes_id [$style]");
		}

		$template = new mx_Template($mx_root_path . $template_path . $template_name);
	}
	else
	{
		$template = new mx_Template($mx_root_path . $template_path . $template_name);
	}

	if ( $only_template )
	{
		return $row;
	} 

	//
	// call when only_template is false.
	//
	define('TEMPLATE_ROOT_PATH', $template_path . $template_name . '/');

	if ( $template )
	{
		$current_template_path = $template_path . $template_name;
		@include($phpbb_root_path . $template_path . $template_name . '/' . $template_name . '.cfg');

		if ( !defined('TEMPLATE_CONFIG') )
		{
			mx_message_die(CRITICAL_ERROR, "Could not open $template_name template config file", '', __LINE__, __FILE__);
		}

		$img_lang = ( file_exists($phpbb_root_path . $current_template_path . '/images/lang_' . $board_config['default_lang']) ) ? $board_config['default_lang'] : 'english';

		while( list($key, $value) = @each($images) )
		{
			if ( !is_array($value) )
			{
				$images[$key] = str_replace('{LANG}', 'lang_' . $img_lang, $value);
			}
		}
	}

	return $row;
}

/**
 * General replacement for die().
 *
 * This is general replacement for die(), allows templated
 * output in users (or default) language, etc.
 * $msg_code can be one of these constants:
 * - GENERAL_MESSAGE : Use for any simple text message, eg. results of an operation, authorisation failures, etc.
 * - GENERAL ERROR : Use for any error which occurs _AFTER_ the common.php include and session code, ie. most errors in pages/functions
 * - CRITICAL_MESSAGE : Used when basic config data is available but a session may not exist, eg. banned users
 * - CRITICAL_ERROR : Used when config data cannot be obtained, eg no database connection. Should _not_ be used in 99.5% of cases.
 *
 * @param integer $msg_code
 * @param string $msg_text
 * @param string $msg_title
 * @param string $err_line
 * @param string $err_file
 * @param string $sql
 */
function mx_message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
{
	global $db, $layouttemplate, $template, $board_config, $theme, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header, $images, $mx_root_path, $module_root_path;
	global $userdata, $user_ip, $session_length, $mx_backend;
	global $mx_starttime, $mx_page, $mx_block, $mx_user, $mx_request_vars, $mx_cache, $tplEx;

	static $msg_history;
	
	$default_lang = (isset($mx_user->lang['default_lang'])) ? $mx_user->lang['default_lang'] : $board_config['default_lang'];

	if( !isset($msg_history) )
	{
		$msg_history = array();
	}	
	
	$msg_history[] = array(
		'msg_code'	=> $msg_code,
		'msg_text'	=> $msg_text,
		'msg_title'	=> $msg_title,
		'err_line'	=> $err_line,
		'err_file'	=> $err_file,
		'sql'		=> $sql
	);
	
	//
	//This will check whaever we are installing
	//

	if(defined('HAS_DIED'))
	{
		//
		// This message is printed at the end of the report.
		// Of course, you can change it to suit your own needs. ;-)
		//
		$custom_error_message = 'Please, contact the %swebmaster%s. Thank you.';
		if ( !empty($board_config) && !empty($board_config['board_email']) )
		{
			$custom_error_message = sprintf($custom_error_message, '<a href="mailto:' . $board_config['board_email'] . '">', '</a>');
		}
		else
		{
			$custom_error_message = sprintf($custom_error_message, '', '');
		}
		echo "<html>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n<body>\n<b>Critical Error!</b><br />\nmx_message_die() was called multiple times.<br />&nbsp;<hr />";
		for( $i = 0; $i < count($msg_history); $i++ )
		{
			echo '<b>Error #' . ($i+1) . "</b>\n<br />\n";
			if( !empty($msg_history[$i]['msg_title']) )
			{
				echo '<b>' . $msg_history[$i]['msg_title'] . "</b>\n<br />\n";
			}
			echo $msg_history[$i]['msg_text'] . "\n<br /><br />\n";
			if( !empty($msg_history[$i]['err_line']) )
			{
				echo '<b>Line :</b> ' . $msg_history[$i]['err_line'] . '<br /><b>File :</b> ' . $msg_history[$i]['err_file'] . "</b>\n<br />\n";
			}
			if( !empty($msg_history[$i]['sql']) )
			{
				echo '<b>SQL :</b> ' . $msg_history[$i]['sql'] . "\n<br />\n";
			}
			echo "&nbsp;<hr />\n";
		}
		echo $custom_error_message . '<hr /><br clear="all" />';
		die("</body>\n</html>");
	}
	
	define('HAS_DIED', 1);
	$sql_store = $sql;

	//
	// Get SQL error if we are debugging. Do this as soon as possible to prevent
	// subsequent queries from overwriting the status of sql_error()
	//
	if (DEBUG && ($msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR))
	{
		$sql_error = $db->sql_error();

		$debug_text = '';

		if ( $sql_error['message'] != '' )
		{
			$debug_text .= '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
		}

		if ( $sql_store != '' )
		{
			$debug_text .= "<br /><br />$sql_store";
		}

		if ( $err_line != '' && $err_file != '' )
		{
			$debug_text .= '</br /><br />Line : ' . $err_line . '<br />File : ' . $err_file;
		}
	}

	//Security check
	if( !is_object($mx_user) && !is_object($mx_page) && !is_object($mx_request_vars))
	{
		die('Hacking attempt, or couldn\'t initalize the main classes required to call mx_message_die().');
	}

	if( !is_object($mx_user))
	{
		$mx_user = new mx_user();
	}

	if( !is_object($mx_page))
	{
		$mx_page = new mx_page();
	}

	if( !is_object($mx_request_vars))
	{
		$mx_request_vars = new mx_request_vars();
	}

	if ( empty($page_id) && $mx_request_vars->is_request('portalpage') )
	{
		$page_id = $mx_request_vars->request('portalpage', MX_TYPE_INT, 1);
	}
	else if ( empty($page_id) )
	{
		$page_id = $mx_request_vars->request('page', MX_TYPE_INT, 1);
	}

	if (!$page_id)
	{
		$page_id = 1;
	}

	//
	// Start user session
	// - populate $userdata and $lang
	//
	if( empty($userdata) && ( $msg_code == GENERAL_MESSAGE || $msg_code == GENERAL_ERROR ) )
	{
		$mx_user->init($user_ip, $page_id, false);
	}

	if(empty($theme))
	{
		global $user_ip;
		$mx_user->page_id = 1;
		$mx_user->user_ip = $user_ip;
		$mx_user->_init_userprefs();
	}

	//
	// Load and instatiate CORE (page) and block classes
	//
	$mx_page->init( $page_id );

	$default_lang = (isset($mx_user->lang['default_lang'])) ? $mx_user->encode_lang($mx_user->lang['default_lang']) : $board_config['default_lang'];

	if ( empty($default_lang) )
	{
		// - populate $default_lang
		$default_lang= 'english';
	}

	$lang_path = $mx_root_path . 'includes/shared/phpbb2/language/';

	//
	// If the header hasn't been output then do it
	//
	if ( !defined('HEADER_INC') && $msg_code != CRITICAL_ERROR )
	{
		if ( empty($lang) || empty($lang['Board_disable']) )
		{
			if ((@include $lang_path . "lang_" . $default_lang . "/lang_main.$phpEx") === false)
			{
				if ((@include $lang_path . "lang_english/lang_main.$phpEx") === false)
				{
					die('Language file (mx_message_die) ' . $lang_path . "lang_" . $default_lang . "/lang_main.$phpEx" . ' couldn\'t be opened.');
				}
			}

			if ((@include $mx_root_path . "language/lang_" . $default_lang . "/lang_main.$phpEx") === false)
			{
				if ((@include $mx_root_path . "language/lang_english/lang_main.$phpEx") === false)
				{
					die('Language file (mx_message_die) ' . $mx_root_path . "language/lang_" . $default_lang . "/lang_main.$phpEx" . ' couldn\'t be opened.');
				}
			}
		}

		$mx_page->page_title = !empty($msg_title) ? $msg_title : $lang['Information'];

		if( !is_object($template) )
		{
			$mx_user->init_style();
		}

		//
		// Load the Page Header
		//
		if ( !defined('IN_ADMIN') )
		{
			include($mx_root_path . 'includes/page_header.'.$phpEx);
		}
		else
		{
			include($mx_root_path . 'admin/page_header_admin.'.$phpEx);
		}
	}

	switch($msg_code)
	{
		case GENERAL_MESSAGE:
			if ( $msg_title == '' )
			{
				$msg_title = $lang['Information'];
			}
			break;

		case CRITICAL_MESSAGE:
			if ( $msg_title == '' )
			{
				$msg_title = $lang['Critical_Information'];
			}
			break;

		case GENERAL_ERROR:
			if ( $msg_text == '' )
			{
				$msg_text = $lang['An_error_occured'];
			}

			if ( $msg_title == '' )
			{
				$msg_title = $lang['General_Error'];
			}
			break;

		case CRITICAL_ERROR:
			//
			// Critical errors mean we cannot rely on _ANY_ DB information being
			// available so we're going to dump out a simple echo'd statement
			//
			if ((@include($lang_path . "lang_" . $default_lang . "/lang_main.$phpEx")) === false)
			{
				if ((@include($lang_path . "lang_english/lang_main.$phpEx")) === false)
				{
					$phpbb_lang_error = 'Language file ' . $lang_path . "lang_" . $default_lang . "/lang_main.$phpEx" . ' couldn\'t be opened.';
				}
				else
				{
					$phpbb_lang_error = false;
				}
			}

			if ((@include($mx_root_path . "language/lang_" . $default_lang . "/lang_main.$phpEx")) === false)
			{
				if ((@include($mx_root_path . "language/lang_english/lang_main.$phpEx")) === false)
				{
					$mx_lang_error = 'Language file ' . $mx_root_path . "language/lang_" . $default_lang . "/lang_main.$phpEx" . ' couldn\'t be opened.';
				}
				else
				{
					$mx_lang_error = false;
				}
			}

			if ($msg_text == '')
			{
				$msg_text = $lang['A_critical_error'];
			}

			if ($msg_title == '')
			{
				$msg_title = 'MX-Publisher : <b>' . $lang['Critical_Error'] . '</b>';
			}
			break;
	}


	//
	// Add on DEBUG info if we've enabled debug mode and this is an error. This
	// prevents debug info being output for general messages should DEBUG be
	// set TRUE by accident (preventing confusion for the end user!)
	//
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
	{
		if ( $debug_text != '' )
		{
			$msg_text = $msg_text . '<br /><br /><b><u>DEBUG MODE</u></b> ' . $debug_text;
		}
	}

	if (isset($phpbb_lang_error))
	{
		$msg_text = $msg_text . '<br /><br /><b><u>ALLSO</u></b> ' . $phpbb_lang_error;
	}

	if (isset($mx_lang_error))
	{
		$msg_text = $msg_text . '<br /><br /><b><u>ALLSO</u></b> ' . $mx_lang_error;
	}

	if ( $msg_code != CRITICAL_ERROR )
	{
		if ( !empty($lang[$msg_text]) )
		{
			$msg_text = $lang[$msg_text];
		}
		if ( !defined('IN_ADMIN') )
		{
			$message_file = $mx_block->full_page ? 'full_page_body.tpl' : 'message_body.tpl';
			$template->set_filenames(array(
				'message_body' => $message_file)
			);
		}
		else
		{
			$template->set_filenames(array('message_body' => 'admin/admin_message_body.tpl'));
		}
		//
		// Fix for correcting possible "bad" links to phpBB
		//
		if (!(strpos($msg_text, 'href') === false))
		{
			$msg_text = str_replace('<a href="index', '<a href="'.$phpbb_root_path.'index', $msg_text);
			$msg_text = str_replace('<a href="viewforum', '<a href="'.$phpbb_root_path.'viewforum', $msg_text);
			$msg_text = str_replace('<a href="viewtopic', '<a href="'.$phpbb_root_path.'viewtopic', $msg_text);
			$msg_text = str_replace('<a href="modcp', '<a href="'.$phpbb_root_path.'modcp', $msg_text);
			$msg_text = str_replace('<a href="groupcp', '<a href="'.$phpbb_root_path.'groupcp', $msg_text);
			$msg_text = str_replace('<a href="posting', '<a href="'.$phpbb_root_path.'posting', $msg_text);
		}
		$template->assign_vars(array(
			'MESSAGE_TITLE' => $msg_title,
			'MESSAGE_TEXT' => $msg_text)
		);
		ob_start();
		$template->pparse('message_body');
		$phpbb_output = ob_get_contents();
		ob_end_clean();
		$phpbb_output = str_replace('"templates/'.$theme['template_name'], '"' . $phpbb_root_path . 'templates/'.$theme['template_name'], $phpbb_output);
		echo($phpbb_output);
		unset($phpbb_output);
		
		if ( !defined('IN_ADMIN') )
		{
			include($mx_root_path . 'includes/page_tail.'.$phpEx);
		}
		else
		{
			include($mx_root_path . 'admin/page_footer_admin.'.$phpEx);
		}
	}
	else
	{
		if (!defined('TEMPLATE_ROOT_PATH'))
		{
			define('TEMPLATE_ROOT_PATH', $mx_root_path.'templates/'.$theme['template_name'].'/');
		}
		if (file_exists($mx_root_path . TEMPLATE_ROOT_PATH . 'msgdie_header.tpl'))
		{		
			$layouttemplate->set_filenames(array(
				'overall_header' => 'msgdie_header.tpl',
			));
			$layouttemplate->pparse('overall_header');			
		}	
		echo "<html>\n<body>\n" . $msg_title . "\n<br /><br />\n" . $msg_text . "</body>\n</html>";		
		if (file_exists($mx_root_path . TEMPLATE_ROOT_PATH . 'msgdie_footer.tpl'))
		{		
			$layouttemplate->set_filenames(array(
				'overall_footer' => 'msgdie_footer.tpl',
			));
			$layouttemplate->pparse('overall_footer');			
		}		
	}
	exit;
}

//
// mx_block_message is basically a simple version of a mx_message_die kind of function.
// It allows to send a message without header/footer, which might break page layout.
// Usefull to send message from blocks, etc.
//
function mx_block_message($title, $message)
{
	global $template;

	$template->set_filenames(array(
		'message_body' => 'message_body.tpl')
	);
	$template->assign_vars(array(
		'MESSAGE_TITLE'	=> $title,
		'MESSAGE_TEXT'	=> $message
	));
	$template->pparse('message_body');
}


/**
* Append session id to url
*
* @param string $url The url the session id needs to be appended to (can have params)
* @param mixed $params String or array of additional url parameters
* @param bool $is_amp Is url using &amp; (true) or & (false)
* @param string $session_id Possibility to use a custom session id instead of the global one
*
* Examples:
* <code>
* mx_append_sid("{$phpbb_root_path}viewtopic.$phpEx?t=1&amp;f=2", false, true);
* mx_append_sid("{$phpbb_root_path}viewtopic.$phpEx", 't=1&amp;f=2', true);
* mx_append_sid("{$phpbb_root_path}viewtopic.$phpEx", 't=1&f=2', false);
* mx_append_sid("{$phpbb_root_path}viewtopic.$phpEx", array('t' => 1, 'f' => 2));
* </code>
*/
function mx3_append_sid($url, $params = false, $is_amp = true, $session_id = false, $mod_rewrite_only = false)
{
	global $SID, $_EXTRA_URL, $portal_config, $mx_mod_rewrite;

	// Assign sid if session id is not specified
	if ($session_id === false)
	{
		$session_id = $SID;
	}

	if ( is_array($session_id) )
	{
		$session_id = $userdata['session_id'];
	}

	$amp_delim = ($is_amp) ? '&amp;' : '&';
	$url_delim = (strpos($url, '?') === false) ? '?' : $amp_delim;

	// Appending custom url parameter?
	$append_url = (!empty($_EXTRA_URL)) ? implode($amp_delim, $_EXTRA_URL) : '';

	// Is mod_rewrite enabled? If so, do some url rewrites...
	if (is_object($mx_mod_rewrite))
	{
		$url = $mx_mod_rewrite->encode($url);
	}

	// Replaces same function in mx_sessions_phpbbx.php
	if ($mod_rewrite_only)
	{
		return $url;
	}

	$anchor = '';
	if (strpos($url, '#') !== false)
	{
		list($url, $anchor) = explode('#', $url, 2);
		$anchor = '#' . $anchor;
	}
	else if (!is_array($params) && strpos($params, '#') !== false)
	{
		list($params, $anchor) = explode('#', $params, 2);
		$anchor = '#' . $anchor;
	}

	// Use the short variant if possible ;)
	if ($params === false)
	{
		// Append session id
		if (!$session_id)
		{
			return $url . (($append_url) ? $url_delim . $append_url : '') . $anchor;
		}
		else
		{
			return $url . (($append_url) ? $url_delim . $append_url . $amp_delim : $url_delim) . 'sid=' . $session_id . $anchor;
		}
	}

	// Build string if parameters are specified as array
	if (is_array($params))
	{
		$output = array();

		foreach ($params as $key => $item)
		{
			if ($item === NULL)
			{
				continue;
			}

			if ($key == '#')
			{
				$anchor = '#' . $item;
				continue;
			}

			$output[] = $key . '=' . $item;
		}

		$params = implode($amp_delim, $output);
	}

	// Append session id and parameters (even if they are empty)
	// If parameters are empty, the developer can still append his/her parameters without caring about the delimiter
	return $url . (($append_url) ? $url_delim . $append_url . $amp_delim : $url_delim) . $params . ((!$session_id) ? '' : $amp_delim . 'sid=' . $session_id) . $anchor;
}


// --------------------------------------------------------------------------------
// Hook into some phpBB functions to append phpBB path to URLs...
// Append $SID to a url. Borrowed from phplib and modified. This is an
// extra routine utilised by the session code above and acts as a wrapper
// around every single URL and form action. If you replace the session
// code you must include this routine, even if it's empty.
// --------------------------------------------------------------------------------
//	
function mx_append_sid($url, $non_html_amp = false, $mod_rewrite_only = false)
{
	global $SID, $_SID, $mx_mod_rewrite, $userdata;
	
	//Fix for login page
	if ( !empty($url) && preg_match('#'.PORTAL_URL.'#', $url) && defined('IN_LOGIN') )
	{
		$url = preg_replace('#' . PORTAL_URL . '#', '', $url);
	}		

	// Is mod_rewrite enabled? If so, do some url rewrites...
	if (is_object($mx_mod_rewrite))
	{
		$url = $mx_mod_rewrite->encode($url);
	}

	// Replaces same function in mx_sessions_phpbbx.php
	if ($mod_rewrite_only)
	{
		return $url;
	}

	/*
	if ( !empty($_SID) && !preg_match('#sid=#', $url) )
	{
		$url .= ( ( strpos($url, '?') !== false ) ?  ( ( $non_html_amp ) ? '&' : '&amp;' ) : '?' ) . $SID;
	}
	*/

	//Will this make troble if it's correct?
	if ( !empty($_SID) && !preg_match('#sid=#', $url) )
	{
		$url .= ( (strpos($url, '?') === false) ?  '?' : (( $non_html_amp ) ? '&' : '&amp;' ) ) . 'sid=' . $_SID;
	}

	if ( !empty($SID) && !preg_match('#sid=#', $url) )
	{
		$url .= ( (strpos($url, '?') === false) ?  '?' : (( $non_html_amp ) ? '&' : '&amp;' ) ) . $SID;
	}

	if (defined('IN_ADMIN') && !preg_match('#sid=#', $url))
	{
		$url .= ( (strpos($url, '?') === false) ?  '?' : (( $non_html_amp ) ? '&' : '&amp;' ) ) . 'sid=' . $userdata['session_id'];
	}

	return $url;
}

function _mx_get_all_get_vars()
{
	//
	// Does this url have GET vars? If not this is NOT a portal url. Do nothing!
	//
	if ( ( $pos = strpos( $url, '?' ) ) === false )
	{
		return array();
	}

	//
	// Reformat all unicode to plain &
	//		
	$url = substr( $url, $pos + 1 );
		
	if ( ( $pos = strpos( $url, '&amp;' ) ) !== false )
	{
		$url = str_replace( '&amp;', '&', $url );
	}
		
	//
	// Not collect all GET vars in an array
	//
	$query_array = array();
	$query_string = explode( '&', $url );

	//
	// First get page_id
	//		
	for( $i = 0; $i < count( $query_string ); $i++ )
	{
		$keyval = explode( '=', $query_string[$i] );
		$query_array[$keyval[0]] = $keyval[1];
	}
		
		return $query_array;
}
		
function mx_redirect($url, $redirect_msg = '', $redirect_link = '')
{
	global $db, $lang;

	if ( empty($redirect_msg) )
	{
		$redirect_msg = $lang['Page_Not_Authorised'];
	}
	if ( empty($redirect_link) )
	{
		$redirect_link = $lang['Redirect_login'];
	}

	$url = str_replace('&amp;', '&', $url);

	if ( defined('HEADER_INC') )
	{
		$message = $redirect_msg . '<br /><br />' . sprintf($redirect_link, '<a href="' . PORTAL_URL . $url . '">', "</a>") . '<br /><br />';
		mx_message_die(GENERAL_MESSAGE, $message);
	}

	//
	// Save any possible changes made in session variables, otherwise we will loose them.
	// See comments here:
	// http://www.php.net/session
	// http://www.php.net/session_write_close
	//
	@session_write_close();
	@session_start();

	if ( !empty($db) )
	{
		$db->sql_close();
	}

	if ( strstr(urldecode($url), "\n") || strstr(urldecode($url), "\r") )
	{
		mx_message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
	}
	
	//Fix for login page
	if (!defined('IN_LOGIN'))
	{
		$url = PORTAL_URL . $url;
	}	

	// Redirect via an HTML form for PITA webservers
	if ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) )
	{
		header('Refresh: 0; URL=' . $url);		
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . PORTAL_URL . $url . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . PORTAL_URL . $url . '">HERE</a> to be redirected</div></body></html>';
		exit;
	}

	// Behave as per HTTP/1.1 spec for others
	header('Location: ' . $url);	
	exit;
}

//
// ViewOnline extension for mxBB Portal Pages...
//
function mx_get_viewonline_info($session_page)
{
	global $db, $lang, $phpEx;

	//
	// Cache Page Information in static variables.
	//
	static $mx_pages_data = false, $mx_pages_count = 0;

	//
	// Prevent from reading pages information more than once.
	//
	if( $mx_pages_data === false )
	{
		$sql = "SELECT page_id, page_name FROM " . PAGE_TABLE . " ORDER BY page_id";
		if( !($result = $db->sql_query($sql)) )
		{
			$mx_pages_count = 0;
		}
		else
		{
			$mx_pages_count = $db->sql_numrows($result);
			$mx_pages_data = $db->sql_fetchrowset($result);
		}
	}

	//
	// Compute Page Identifier
	//
	$page_id = MX_PORTAL_PAGES_OFFSET - $session_page;

	//
	// Return array($location, $location_url) OR false when page not found.
	//
	if( $page_id > 0 && $mx_pages_count > 0 )
	{
		for( $i = 0; $i < $mx_pages_count; $i++ )
		{
			if( $mx_pages_data[$i]['page_id'] == $page_id )
			{
				return array(
					$lang['Page'] . ': ' . $mx_pages_data[$i]['page_name'],
					PORTAL_URL . "index.$phpEx?page=" . $mx_pages_data[$i]['page_id']
				);
			}
		}
	}
	return false;
}

//
// Pagination routine, generates
// page number sequence
// Only difference from standard phpbb function is you can use more settings
//
function mx_generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = TRUE, $use_next_symbol = false,$use_previous_symbol = false,$add_preinfo_text = TRUE, $name_id = 'start')
{
	global $lang;

	$total_pages = ceil($num_items/$per_page);

	if ( $total_pages == 1 )
	{
		return '';
	}

	$previous_string = $use_next_symbol ? '&laquo;' : $lang['Previous'];
	$next_string = $use_previous_symbol ? '&raquo;' : $lang['Next'];

	$class = 'class="mx_pagination" onmouseover="if(this.className){this.className=\'mx_pagination_over\';}" onmouseout="if(this.className){this.className=\'mx_pagination\';}"';

	$on_page = floor($start_item / $per_page) + 1;

	$page_string = '';
	if ( $total_pages > 10 )
	{
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;

		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<b class="mx_pagination_sele">' . $i . '</b>' : '<a '.$class.' href="' . mx_append_sid($base_url . "&amp;".$name_id."=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
			if ( $i <  $init_page_max )
			{
				$page_string .= ",";
			}
		}

		if ( $total_pages > 3 )
		{
			if ( $on_page > 1  && $on_page < $total_pages )
			{
				$page_string .= ( $on_page > 5 ) ? ' ... ' : ',';

				$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
				$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

				for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
				{
					$page_string .= ($i == $on_page) ? '<b class="mx_pagination_sele">' . $i . '</b>' : '<a '.$class.' href="' . mx_append_sid($base_url . "&amp;".$name_id."=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
					if ( $i <  $init_page_max + 1 )
					{
						$page_string .= ',';
					}
				}

				$page_string .= ( $on_page < $total_pages - 4 ) ? ' ... ' : ', ';
			}
			else
			{
				$page_string .= ' ... ';
			}

			for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
			{
				$page_string .= ( $i == $on_page ) ? '<b class="mx_pagination_sele">' . $i . '</b>'  : '<a '.$class.' href="' . mx_append_sid($base_url . "&amp;".$name_id."=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
				if( $i <  $total_pages )
				{
					$page_string .= ",";
				}
			}
		}
	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<b class="mx_pagination_sele">' . $i . '</b>' : '<a '.$class.' href="' . mx_append_sid($base_url . "&amp;".$name_id."=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
			if ( $i <  $total_pages )
			{
				$page_string .= ',';
			}
		}
	}

	if ( $add_prevnext_text )
	{
		if ( $on_page > 1 )
		{
			$page_string = ' <a '.$class.' href="' . mx_append_sid($base_url . "&amp;".$name_id."=" . ( ( $on_page - 2 ) * $per_page ) ) . '">' . $previous_string . '</a>&nbsp;' . $page_string;
		}

		if ( $on_page < $total_pages )
		{
			$page_string .= '&nbsp;<a '.$class.' href="' . mx_append_sid($base_url . "&amp;".$name_id."=" . ( $on_page * $per_page ) ) . '">' . $next_string . '</a>';
		}

	}
	$pre_text = $add_preinfo_text ? $lang['Goto_page'] : '';
	$page_string = $pre_text . ' ' . $page_string;

	return $page_string;
}

?>