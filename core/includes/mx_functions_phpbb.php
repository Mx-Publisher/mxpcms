<?php
/**
*
* @package Functions_phpBB
* @version $Id: mx_functions_phpbb.php,v 1.2 2009/01/24 16:47:51 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

//
// First off, include common vanilla phpBB functions, from our shared dir
// Note: These functions will later be accessible wrapped as phpBBX::orig_functionname()
//
include_once($mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx);
include_once($phpbb_root_path . 'includes/functions.' . $phpEx); // In case we need old functions...

/**
 * phpBB Smilies pass.
 *
 * Hacking smilies_pass from phpbb/includes/bbcode.php
 *
 * @param string $message
 * @return string
 */
function mx_smilies_pass($message)
{
	global $mx_page, $board_config, $phpbb_root_path, $phpEx;

	if( !function_exists('smilies_pass') && (PORTAL_BACKEND == 'phpbb2') )
	{
		include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
	}

	$smilies_path = $board_config['smilies_path'];
	$board_config['smilies_path'] = PHPBB_URL . $board_config['smilies_path'];
	$message = smilies_pass($message);
	$board_config['smilies_path'] = $smilies_path;
	return $message;
}

/**
 * Generate phpBB smilies.
 *
 * Hacking generate_smilies from phpbb/includes/functions_post.php
 *
 * @param string $mode
 * @param integer $page_id
 */
function mx_generate_smilies($mode, $page_id)
{
	global $board_config, $template, $phpbb_root_path, $phpEx;

	if( !function_exists('generate_smilies') )
	{
		include_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);
	}

	$smilies_path = $board_config['smilies_path'];
	$board_config['smilies_path'] = PHPBB_URL . $board_config['smilies_path'];
	generate_smilies($mode, $page_id);
	$board_config['smilies_path'] = $smilies_path;
	$template->assign_vars(array(
		'U_MORE_SMILIES' => append_sid(PHPBB_URL . "posting.$phpEx?mode=smilies"))
	);
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
function mx_decode($bbtext, $bbcode_uid, $smilies_on = true)
{
	global $phpbb_root_path, $mx_bbcode, $phpEx;
		
	$mytext = stripslashes($bbtext);
	if (!empty($bbcode_uid))
	{
		$mytext = $mx_bbcode->bbencode_second_pass($mytext, $bbcode_uid);
	}
	if ($smilies_on)
	{
		$mytext = $mx_bbcode->smilies_pass($mytext);
	}
	$mytext = str_replace("\n", "\n<br />\n", $mytext);
	return $mx_bbcode->make_clickable($mytext);
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
	global $db, $template, $board_config, $theme, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header, $images, $mx_root_path, $module_root_path;
	global $userdata, $user_ip, $session_length;
	global $mx_starttime, $mx_page, $mx_block, $mx_user, $mx_request_vars, $mx_cache;

	static $msg_history;

	if ( !defined('PORTAL_BACKEND') )
	{
		if ( @file_exists($phpbb_root_path . "modcp.$phpEx") )
		{
			define('PORTAL_BACKEND', 'phpbb2');
		}
		else if ( @file_exists($phpbb_root_path . "mcp.$phpEx") )
		{
			define('PORTAL_BACKEND', 'phpbb3');
		}
	}

	//$default_lang = $mx_user->get_old_lang($board_config['default_lang']);
	$default_lang = ($mx_user->lang['default_lang']) ? $mx_user->lang['default_lang'] : $board_config['default_lang'];

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
		echo "<html>\n<body>\n<b>Critical Error!</b><br />\nmx_message_die() was called multiple times.<br />&nbsp;<hr />";
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
		echo $custom_error_message . '<hr /><br clear="all">';
		die("</body>\n</html>");
	}

	define('HAS_DIED', 1);

	$sql_store = $sql;

	//
	// Get SQL error if we are debugging. Do this as soon as possible to prevent
	// subsequent queries from overwriting the status of sql_error()
	//
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
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

	//
	// Start user session
	// - populate $userdata and $lang
	//
	if( empty($userdata) && ( $msg_code == GENERAL_MESSAGE || $msg_code == GENERAL_ERROR ))
	{
		$mx_user->init($user_ip, $page_id, true);
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

	$default_lang = ($mx_user->lang['default_lang']) ? $mx_user->lang['default_lang'] : $board_config['default_lang'];

	if ( empty($default_lang) )
	{
		// - populate $default_lang
		$default_lang = 'english';
	}

	switch (PORTAL_BACKEND)
	{
		case 'internal':
		case 'phpbb3':
			$lang_path = $mx_root_path . 'includes/shared/phpbb2/language/';
			break;
		case 'phpbb2':
			$lang_path = $phpbb_root_path . 'language/';
		break;
		default:
			$lang_path = $phpbb_root_path . 'language/';
	}

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
					die('Language file ' . $lang_path . "lang_" . $default_lang . "/lang_main.$phpEx" . ' couldn\'t be opened.');
				}
			}

			if ((@include $mx_root_path . "language/lang_" . $default_lang . "/lang_main.$phpEx") === false)
			{
				if ((@include $mx_root_path . "language/lang_english/lang_main.$phpEx") === false)
				{
					die('Language file ' . $mx_root_path . "language/lang_" . $default_lang . "/lang_main.$phpEx" . ' couldn\'t be opened.');
				}
			}
		}

		$mx_page->page_title = !empty($msg_title) ? $msg_title : $lang['Information'];

		if( !is_object($template) )
		{
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'phpbb2':
					$mx_user->init_style();
					//$template = new mx_Template($mx_root_path . 'templates/' . $mx_user->template_name);
				break;
				case 'phpbb3':
					$mx_user->init_style();
				break;
			}
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
			if ((@include $lang_path . "lang_" . $default_lang . "/lang_main.$phpEx") === false)
			{
				if ((@include $lang_path . "lang_english/lang_main.$phpEx") === false)
				{
					die('Language file ' . $lang_path . "lang_" . $default_lang . "/lang_main.$phpEx" . ' couldn\'t be opened.');
				}
			}

			if ((@include $mx_root_path . "language/lang_" . $default_lang . "/lang_main.$phpEx") === false)
			{
				if ((@include $mx_root_path . "language/lang_english/lang_main.$phpEx") === false)
				{
					die('Language file ' . $mx_root_path . "language/lang_" . $default_lang . "/lang_main.$phpEx" . ' couldn\'t be opened.');
				}
			}

			if ( $msg_text == '' )
			{
				$msg_text = $lang['A_critical_error'];
			}

			if ( $msg_title == '' )
			{
				$msg_title = 'MXP : <b>' . $lang['Critical_Error'] . '</b>';
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
			$msg_text = $msg_text . '<br /><br /><b><u>DEBUG MODE</u></b>' . $debug_text;
		}
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
			$template->set_filenames(array( 'message_body' => 'admin/admin_message_body.tpl') );
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

		if( !isset($phpBB2))
		{
			$phpBB2 = new phpBB2();
		}

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
		echo "<html>\n<body>\n" . $msg_title . "\n<br /><br />\n" . $msg_text . "</body>\n</html>";
	}

	exit;
}

/**
 * Simple mx_message_die.
 *
 * mx_block_message is basically a simple version of a mx_message_die kind of function.
 * It allows to send a message without header/footer, which might break page layout.
 * Usefull to send message from blocks, etc.
 *
 * @param string $title
 * @param string $message
 */
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

	ob_start();
	$template->pparse('message_body');
	$phpbb_output = ob_get_contents();
	ob_end_clean();
	$phpbb_output = str_replace('"templates/'.$theme['template_name'], '"' . $phpbb_root_path . 'templates/'.$theme['template_name'], $phpbb_output);
	echo($phpbb_output);
	unset($phpbb_output);
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


/**
 * append_sid.
 *
 * Hook into some phpBB functions to append phpBB path to URLs...
 *
 * @param string $url
 * @param string $non_html_amp
 * @return string
 */
function mx_append_sid($url, $non_html_amp = false, $mod_rewrite_only = false)
{
	global $SID, $_SID, $mx_mod_rewrite, $userdata;

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
	if ( !empty($SID) && !preg_match('#sid=#', $url) )
	{
		$url .= ( (strpos($url, '?') === false) ?  '?' : (( $non_html_amp ) ? '&' : '&amp;' ) ) . $SID;
	}
	
	if ( !empty($_SID) && !preg_match('#sid=#', $url) )
	{
		$url .= ( (strpos($url, '?') === false) ?  '?' : (( $non_html_amp ) ? '&' : '&amp;' ) ) . 'sid=' . $_SID;
	}

	if (defined('IN_ADMIN') && !preg_match('#sid=#', $url))
	{
		$url .= ( (strpos($url, '?') === false) ?  '?' : (( $non_html_amp ) ? '&' : '&amp;' ) ) . 'sid=' . $userdata['session_id'];
	}

	return $url;
}

/**
 * Redirect.
 *
 * mxBB version of phpBB redirect().
 *
 * @param string $url
 * @param string $redirect_msg
 * @param string $redirect_link
 */
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

	// Redirect via an HTML form for PITA webservers
	if ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) )
	{
		header('Refresh: 0; URL=' . PORTAL_URL . $url);
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . PORTAL_URL . $url . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . PORTAL_URL . $url . '">HERE</a> to be redirected</div></body></html>';
		exit;
	}

	// Behave as per HTTP/1.1 spec for others
	header('Location: ' . PORTAL_URL . $url);
	exit;
}

/**
 * ViewOnline.
 *
 * ViewOnline extension for mxBB Portal Pages...
 *
 * @param integer $session_page
 * @return array
 */
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
		$db->sql_freeresult($result);
	}

	//
	// Compute Page Identifier
	//
	$page_id = - $session_page - MX_PORTAL_PAGES_OFFSET;

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
					$mx_pages_data[$i]['page_name'],
					PORTAL_URL . "index.$phpEx?page=" . $mx_pages_data[$i]['page_id']
				);
			}
		}
	}
	return false;
}

/**
 * Generate Pagination.
 *
 * Pagination routine, generates page number sequence.
 * Only difference from standard phpbb function is you can use more settings.
 *
 * @param string $base_url
 * @param integer $num_items
 * @param integer $per_page
 * @param integer $start_item
 * @param boolean $add_prevnext_text
 * @param boolean $use_next_symbol
 * @param boolean $use_previous_symbol
 * @param boolean $add_preinfo_text
 * @param integer $name_id
 * @return string (html)
 */
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
			$page_string .= ( $i == $on_page ) ? '<b class="mx_pagination_sele">' . $i . '</b>' : '<a '.$class.' href="' . append_sid($base_url . "&amp;".$name_id."=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
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
					$page_string .= ($i == $on_page) ? '<b class="mx_pagination_sele">' . $i . '</b>' : '<a '.$class.' href="' . append_sid($base_url . "&amp;".$name_id."=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
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
				$page_string .= ( $i == $on_page ) ? '<b class="mx_pagination_sele">' . $i . '</b>'  : '<a '.$class.' href="' . append_sid($base_url . "&amp;".$name_id."=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
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
			$page_string .= ( $i == $on_page ) ? '<b class="mx_pagination_sele">' . $i . '</b>' : '<a '.$class.' href="' . append_sid($base_url . "&amp;".$name_id."=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
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
			$page_string = ' <a '.$class.' href="' . append_sid($base_url . "&amp;".$name_id."=" . ( ( $on_page - 2 ) * $per_page ) ) . '">' . $previous_string . '</a>&nbsp;' . $page_string;
		}

		if ( $on_page < $total_pages )
		{
			$page_string .= '&nbsp;<a '.$class.' href="' . append_sid($base_url . "&amp;".$name_id."=" . ( $on_page * $per_page ) ) . '">' . $next_string . '</a>';
		}

	}
	$pre_text = $add_preinfo_text ? $lang['Goto_page'] : '';
	$page_string = $pre_text . ' ' . $page_string;

	return $page_string;
}

/**
 * Get DB stats.
 *
 * Common uncached phpBB function, duplicated here to be cached.
 *
 * @param string $mode
 * @return array
 */
function mx_get_db_stat($mode)
{
	global $db;

	switch( $mode )
	{
		case 'usercount':
			$sql = "SELECT COUNT(user_id) AS total
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS;
			break;

		case 'newestuser':
			$sql = "SELECT user_id, username, user_level
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS . "
				ORDER BY user_id DESC
				LIMIT 1";
			break;

		case 'postcount':
		case 'topiccount':
			$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
				FROM " . FORUMS_TABLE;
			break;
	}

	if ( !($result = $db->sql_query($sql, 120)) )
	{
		return false;
	}

	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	switch ( $mode )
	{
		case 'usercount':
			return $row['total'];
			break;
		case 'newestuser':
			return $row;
			break;
		case 'postcount':
			return $row['post_total'];
			break;
		case 'topiccount':
			return $row['topic_total'];
			break;
	}

	return false;
}

/**
 * Get userdata
 *
 * Get Userdata, $user can be username or user_id. If force_str is true, the username will be forced.
 *
 * @param unknown_type $user id or name
 * @param boolean $force_str force clean_username
 * @return array
 */
function mx_get_userdata($user, $force_str = false)
{
	global $db;

	if (!is_numeric($user) || $force_str)
	{
		$user = phpbb_clean_username($user);
	}
	else
	{
		$user = intval($user);
	}

	$sql = "SELECT *
		FROM " . USERS_TABLE . "
		WHERE ";
	$sql .= ( ( is_integer($user) ) ? "user_id = $user" : "username = '" .  str_replace("\'", "''", $user) . "'" ) . " AND user_id <> " . ANONYMOUS;
	if ( !($result = $db->sql_query($sql, 600)) )
	{
		mx_message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
	}

	$return = ( $row = $db->sql_fetchrow($result) ) ? $row : false;
	$db->sql_freeresult($result);
	return $return;
}

/**
 * Select language.
 *
 * Pick a language, any language ...
 *
 * @param string $default
 * @param string $select_name
 * @param string $dirname
 * @return string (html)
 */
function mx_language_select($default, $select_name = "language", $dirname="language")
{
	global $phpEx, $phpbb_root_path;

	$dir = opendir($phpbb_root_path . $dirname);

	$lang = array();
	while ( $file = readdir($dir) )
	{
		if (preg_match('#^lang_#i', $file) && !is_file(@phpbb_realpath($phpbb_root_path . $dirname . '/' . $file)) && !is_link(@phpbb_realpath($phpbb_root_path . $dirname . '/' . $file)))
		{
			$filename = trim(str_replace("lang_", "", $file));
			$displayname = preg_replace("/^(.*?)_(.*)$/", "\\1 [ \\2 ]", $filename);
			$displayname = preg_replace("/\[(.*?)_(.*)\]/", "[ \\1 - \\2 ]", $displayname);
			$lang[$displayname] = $filename;
		}
	}

	closedir($dir);

	@asort($lang);
	@reset($lang);

	$lang_select = '<select name="' . $select_name . '">';
	while ( list($displayname, $filename) = @each($lang) )
	{
		$selected = ( strtolower($default) == strtolower($filename) ) ? ' selected="selected"' : '';
		$lang_select .= '<option value="' . $filename . '"' . $selected . '>' . ucwords($displayname) . '</option>';
	}
	$lang_select .= '</select>';
	return $lang_select;
}

/**
 * Style select.
 *
 * Pick a template/theme.
 *
 * @param string $default_style
 * @param string $select_name
 * @param string $dirname
 * @return string (html)
 */
function mx_style_select($default_style, $select_name = "style", $dirname = "templates", $show_instruction = false)
{
	global $db, $lang;

	$sql = "SELECT themes_id, style_name
		FROM " . THEMES_TABLE . "
		ORDER BY template_name, themes_id";
	if ( !($result = $db->sql_query($sql, 300)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't query themes table", "", __LINE__, __FILE__, $sql);
	}
	$style_select = '<select name="' . $select_name . '">';
	$selected1 = '';
	if ($show_instruction)
	{
		$selected1 = ($default_style == -1) ? ' selected="selected"' : '';
		$style_select .= '<option value="-1"' . $selected1 . '>' . $lang['Select_page_style'] . '</option>';
	}
	while ( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row['themes_id'] == $default_style && !$selected1) ? ' selected="selected"' : '';

		$style_select .= '<option value="' . $row['themes_id'] . '"' . $selected . '>' . $row['style_name'] . '</option>';
	}
	$style_select .= "</select>";
	$db->sql_freeresult($result);
	return $style_select;
}

//
// Pick a timezone
//
function mx_tz_select($default, $select_name = 'timezone')
{
	global $sys_timezone, $lang;

	if ( !isset($default) )
	{
		$default == $sys_timezone;
	}
	$tz_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['tz']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$tz_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$tz_select .= '</select>';

	return $tz_select;
}

/**
 * get_auth_forum
 *
 * @param unknown_type $mode
 * @return unknown
 */
function get_auth_forum($mode = 'phpbb')
{
	global $userdata, $mx_root_path, $phpbb_root_path, $phpEx;

	//
	// Try to reuse auth_view query result.
	//
	$userdata_key = 'mx_get_auth_' . $mode . $userdata['user_id'];
	if( !empty($userdata[$userdata_key]) )
	{
		$auth_data_sql = $userdata[$userdata_key];
		return $auth_data_sql;
	}

	//
	// Now, this tries to optimize DB access involved in auth(),
	// passing AUTH_LIST_ALL will load info for all forums at once.
	//
	if( $mode == 'kb' )
	{
		if (file_exists($mx_root_path . 'modules/mx_kb/kb/includes/functions_auth.' . $phpEx))
		{
			include_once($mx_root_path . 'modules/mx_kb/kb/includes/functions_auth.' . $phpEx);
			$mx_kb_auth = new mx_kb_auth();
			$mx_kb_auth->auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);
			$is_auth_ary = $mx_kb_auth->auth_user;
		}
		else
		{
			include_once($mx_root_path . 'modules/mx_kb/includes/functions_kb_auth.' . $phpEx);
			$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);
		}
	}
	else
	{
		include_once($phpbb_root_path . 'includes/auth.' . $phpEx);
		$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);
	}

	//
	// Loop through the list of forums to retrieve the ids for
	// those with AUTH_VIEW allowed.
	//
	$auth_data_sql = '';
	foreach( $is_auth_ary as $fid => $is_auth_row )
	{
		if( $is_auth_row['auth_view'] )
		{
			$auth_data_sql .= ( $auth_data_sql != '' ) ? ', ' . $fid : $fid;
		}
	}

	if( empty($auth_data_sql) )
	{
		$auth_data_sql = -1;
	}

	$userdata[$userdata_key] = $auth_data_sql;
	return $auth_data_sql;
}

/**
 * Is group member?
 *
 * Validates if user belongs to group included in group_ids list.
 * Also, adds all usergroups to userdata array.
 *
 * @param unknown_type $group_ids
 * @param unknown_type $group_mod_mode
 * @return unknown
 */
function mx_is_group_member($group_ids = '', $group_mod_mode = false)
{
	global $userdata, $db;

	if( empty($group_ids) )
	{
		return false;
	}

	//
	// Try to reuse group_id results.
	//
	$userdata_key = 'mx_usergroups' . ( $group_mod_mode ? '_mod' : '' ) . $userdata['user_id'];

	if( empty($userdata[$userdata_key]) )
	{
		if( $group_mod_mode )	// Get the groups the user is moderator of.
		{
			$sql = "SELECT group_id FROM " . GROUPS_TABLE . "
				WHERE group_moderator = '" . $userdata['user_id'] . "' AND group_single_user = 0";
		}
		else					// Get the groups the user is member of.
		{
			$sql = "SELECT group_id FROM " . USER_GROUP_TABLE . "
				WHERE user_id = '" . $userdata['user_id'] . "' AND user_pending = 0";
		}
		if ( !($result = $db->sql_query($sql, 300)) )
		{
			mx_message_die(GENERAL_ERROR, "Could not query group rights information");
		}
		$userdata[$userdata_key] = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);
	}

	$group_ids_array = explode(',', $group_ids);

	for( $i = 0; $i < count($userdata[$userdata_key]); $i++ )
	{
		if( in_array($userdata[$userdata_key][$i]['group_id'], $group_ids_array) )
		{
			return true;
		}
	}
	return false;
}

/**
 * Get groups
 *
 * @param unknown_type $sel_id
 * @param unknown_type $field_entry
 * @param unknown_type $group_rowset
 * @return unknown
 */
function mx_get_groups($sel_id, $field_entry = 'auth_view_group', $group_rowset = array())
{
 	global $db, $lang;

 	if (empty($group_rowset))
 	{
		$sql = "SELECT group_id, group_name
			FROM " . GROUPS_TABLE . "
			WHERE group_single_user <> " . TRUE . "
			ORDER BY group_name";

		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't get list of groups", '', __LINE__, __FILE__, $sql);
		}

		$group_rowset = $db->sql_fetchrowset($result);
 	}
 	$db->sql_freeresult($result);

	$grouplist = '<select name="'.$field_entry.'">';
	$grouplist .= '<option value="0">' . $lang['Select_group'] . '</option>';

	foreach($group_rowset as $key => $row)
	{
		$selected = ( $sel_id == $row['group_id'] ? ' selected="selected"' : '' );
		$grouplist .= '<option value="' .$row['group_id'] . '"' . $selected . '>' . $row['group_name'] . '</option>';
	}

	$grouplist .= '</select>';
	return $grouplist;
}
?>