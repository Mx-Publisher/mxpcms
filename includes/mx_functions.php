<?php
/**
*
* @package Functions
* @version $Id: mx_functions.php,v 1.92 2008/08/28 05:05:20 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if (!defined('IN_PORTAL'))
{
	die("Hacking attempt");
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

	$default_lang = ($mx_user->lang['default_lang']) ? $mx_user->encode_lang($mx_user->lang['default_lang']) : $board_config['default_lang'];

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

	if ($phpbb_lang_error)
	{
		$msg_text = $msg_text . '<br /><br /><b><u>ALLSO</u></b> ' . $phpbb_lang_error;
	}

	if ($mx_lang_error)
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
	global $_SID, $_EXTRA_URL, $portal_config, $mx_mod_rewrite;

	// Assign sid if session id is not specified
	if ($session_id === false)
	{
		$session_id = $_SID;
	}

	if ( is_array($session_id) )
	{
		$session_id = $mx_user->session_id;
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
/**
 * Redirect.
 *
 * MX-Publisher version of phpBB redirect().
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

/**
 * Get userdata
 *
 * Get Userdata, $user can be username or user_id. If force_str is true, the username will be forced.
 * Cached sql, since this function is used for every block.
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
		$user = phpBB2::phpbb_clean_username($user);
	}
	else
	{
		$user = intval($user);
	}

	$sql = "SELECT *
		FROM " . USERS_TABLE . "
		WHERE ";
	$sql .= ( ( is_integer($user) ) ? "user_id = $user" : "username = '" .  str_replace("\'", "''", $user) . "'" ) . " AND user_id <> " . ANONYMOUS;
	if ( !($result = $db->sql_query($sql, 120)) )
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
	global $phpEx, $mx_root_path;

	$dir = opendir($mx_root_path . $dirname);

	$lang = array();
	while ( $file = readdir($dir) )
	{
		if (preg_match('#^lang_#i', $file) && !is_file(@phpBB2::phpbb_realpath($mx_root_path . $dirname . '/' . $file)) && !is_link(@phpBB2::phpbb_realpath($mx_root_path . $dirname . '/' . $file)))
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
	global $db, $lang, $mx_root_path;

	$sql = "SELECT themes_id, style_name
		FROM " . MX_THEMES_TABLE . "
		WHERE portal_backend = '" . PORTAL_BACKEND . "'
		ORDER BY template_name, themes_id";

	if ( !($result = $db->sql_query($sql, 300)) )
	{
		message_die(GENERAL_ERROR, "Couldn't query themes table", "", __LINE__, __FILE__, $sql);
	}

	$style_select = '<select name="' . $select_name . '">';
	if ($show_instruction)
	{
		$selected1 = ( $default_style == -1 ) ? ' selected="selected"' : '';
		$style_select .= '<option value="-1"' . $selected1 . '>' . $lang['Select_page_style'] . '</option>';
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$id = $row['themes_id'];
		$selected = ( $id == $default_style && !$selected1) ? ' selected="selected"' : '';
			$style_select .= '<option value="' . $id . '"' . $selected . '>' . $row['style_name'] . '</option>';
	}
	$db->sql_freeresult($result);

	$style_select .= "</select>";

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
 	global $db, $lang, $mx_backend;

 	if (empty($group_rowset))
 	{
 		$sql = $mx_backend->generate_group_select_sql();

		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Couldn't get list of groups", '', __LINE__, __FILE__, $sql);
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

/**
 * ViewOnline.
 *
 * ViewOnline extension for MX-Publisher Pages...
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
* For display of custom parsed text on user-facing pages
* Expects $text to be the value directly from the database (stored value)
*/
function mx_generate_text_for_display($text, $uid, $bitfield, $flags)
{
	global $bbcode, $mx_bbcode;

	if (!$text)
	{
		return '';
	}

	$text = phpbb3::censor_text($text);

	// Parse bbcode if bbcode uid stored and bbcode enabled
	if ($uid && ($flags & OPTION_FLAG_BBCODE))
	{
		if (!class_exists('bbcode'))
		{
			global $phpbb_root_path, $phpEx;
			mx_cache::load_file('bbcode', 'phpbb3');
		}

		if (empty($bbcode))
		{
			$bbcode = new bbcode($bitfield);
		}
		else
		{
			$bbcode->bbcode($bitfield);
		}

		$bbcode->bbcode_second_pass($text, $uid);
	}

	$text = str_replace("\n", '<br />', $text);

	$text = $mx_bbcode->smilies_pass($text, !($flags & OPTION_FLAG_SMILIES));

	return $text;
}

/**
 * Return data from table.
 *
 * This function returns data from table, where field value matches id (and field2 value matches id2).
 *
 * @access public
 * @param string $table target
 * @param string $idfield  field
 * @param string $id needle
 * @param string $idfield2 additional field (optional)
 * @param string $id2 needle
 * @return array results
 */
function mx_get_info($table, $idfield = '', $id = 0, $idfield2 = '', $id2 = 0)
{
	global $db;

	$sql = "SELECT * FROM $table WHERE $idfield = '$id'";
	$sql .= ( $idfield2 != '' && $id2 != '' ) ? " AND $idfield2 = '$id2'" : '';
	$sql .= ' LIMIT 1';
	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get $table information", '', __LINE__, __FILE__, $sql);
	}
	$return = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	return $return;
}

/**
 * Return number of results, if exists.
 *
 * This function returns the number of results, where field value matches id.
 *
 * @access public
 * @param string $table target
 * @param string $idfield field
 * @param string $id needle
 * @return array array('number', num_of_results)
 */
function mx_get_exists($table, $idfield = '', $id = 0)
{
	global $db;

	$sql = "SELECT COUNT(*) AS total FROM $table WHERE $idfield = '$id'";
	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get block/Column information", '', __LINE__, __FILE__, $sql);
	}
	$count = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	$count = $count['total'];
	return array('number' => $count);
}

/**
 * Get html select list - from array().
 *
 * This function generates and returns a html select list (name = $nameselect).
 *
 * @access public
 * @param string $name_select select name
 * @param array $row source data
 * @param string $id needle
 * @param boolean $full_list expanded or dropdown list
 * @return unknown
 */
function get_list_static($name_select, $row, $id, $full_list = true)
{
	$rows_count = ( count($row) < '25' ) ? count($row) : '25';
	$full_list_true = $full_list ? ' size="' . $rows_count . '"' : '';

	$column_list = '<select name="' . $name_select .'" ' . $full_list_true . '>';
	foreach( $row as $idfield => $namefield )
	{
		$selected = ( $idfield == $id ) ? ' selected="selected"' : '';
		$column_list .= '<option value="' . $idfield . '"' . $selected . '>' . $namefield . "</option>\n";
	}
	$column_list .= '</select>';

	unset($row);
	return $column_list;
}

/**
 * Get html select list - from db query.
 *
 * This function generates and returns a html select list (name = $nameselect) with option labels $namefield,
 * with data from $table, (where $idfield2 matches $id2).
 * Use $select=true to select where $idfield value matches $id.
 * <code>
 * 	<select name=$nameselect>
 * 		// $idfield = $id
 * 		<option value=$idfield selected="selected">$namefield</option>
 * 		// $idfield != $id
 * 		<option value=$idfield >$namefield</option>
 * 		<option value=$idfield >$namefield</option>
 * 		<option value=$idfield >$namefield</option>
 * 	</select>
 * </code>
 *
 * @access public
 * @param string $name_select select name
 * @param string $table target
 * @param string $idfield field
 * @param string $namefield option labels
 * @param string $id needle
 * @param boolean $select select idfiled = id
 * @param string $idfield2 field
 * @param string $id2 needle
 * @return string (html)
 */
function mx_get_list($name_select, $table, $idfield, $namefield, $id, $select = false, $idfield2 = '' , $id2 = '')
{
	global $db;

	$sql = "SELECT * FROM $table";
	if( !$select )
	{
		$sql .= " WHERE $idfield <> $id";
	}
	if( !$select && !empty($id2) )
	{
		$sql .= " AND $idfield2 = $id2";
	}
	if( $select && !empty($id2) )
	{
		$sql .= " WHERE $idfield2 = $id2";
	}
	$sql .= " ORDER BY $namefield";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get list of Column/blocks", '', __LINE__, __FILE__, $sql);
	}

	$column_list = '<select name="' . $name_select . '">';
	while( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row[$idfield] == $id ) ? ' selected="selected"' : '';
		$column_list .= '<option value="' . $row[$idfield] . '"' . $selected . '>' . $row[$namefield] . "</option>\n";
	}
	$column_list .= '</select>';

	unset($row);
	$db->sql_freeresult($result);

	return $column_list;
}

/**
 * Get html mutiple select list - from db query.
 *
 * This function generates and returns a html multiple select list (name = $nameselect) with option labels $namefield ($namefield2),
 * with data from $table. Use $select=true to select where $idfield value matches list($id).
 * <code>
 * 	<select name=$nameselect multiple="multiple">
 * 		// $idfield in list($id)
 * 		<option value=$idfield selected="selected">$namefield ($namefield2)</option>
 * 		// $idfield in list($id)
 * 		<option value=$idfield selected="selected">$namefield ($namefield2)</option>
 * 		// $idfield not in list($id)
 * 		<option value=$idfield >$namefield ($namefield2) ($namefield2)</option>
 * 		<option value=$idfield >$namefield ($namefield2) ($namefield2)</option>
 * 	</select>
 * </code>
 *
 * @access public
 * @param string $name_select select name
 * @param string $table target
 * @param string $idfield field
 * @param string $namefield option labels
 * @param array $id_list needle array
 * @param boolean $select select select idfiled = list(id)
 * @param string $namefield2 option labels desc
 * @return string (html)
 */
function get_list_multiple($name_select, $table, $idfield, $namefield, $id_list, $select, $namefield2 = '')
{
	global $db;

	$sql = "SELECT * FROM $table";
	if( !$select )
	{
		$sql .= " WHERE $idfield NOT IN ( $id_list )";
	}
	$sql .= " ORDER BY $namefield";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get list of Column/blocks", '', __LINE__, __FILE__, $sql);
	}

	$id_list = explode(',', $id_list);
	$rows_count = $db->sql_numrows($result);
	$rows_count = ( $rows_count < '25' ) ? $rows_count : '25';

	$column_list = '<select name="' . $name_select . '" size="' . $rows_count . '" multiple="multiple">';
	while( $row = $db->sql_fetchrow($result) )
	{
		$namefield_desc = !empty($row[$namefield2]) ? ' (' . $row[$namefield2] . ')' : '';
		$selected = ( in_array($row[$idfield], $id_list) ) ? ' selected="selected"' : '';
		$column_list .= '<option value="' . $row[$idfield] . '"' . $selected . '>' . $row[$namefield] . $namefield_desc . "</option>\n";
	}
	$column_list .= '</select>';

	unset($row);
	$db->sql_freeresult($result);
	return $column_list;
}

/**
 * Get html select list - from db query - with formatted output.
 *
 * This function generates and returns a html select list (name = $nameselect). Supported $type options are:
 * - page_list
 * - function_list
 * - block_list
 * - dyn_block_list
 * Or the function generates a block_list for given $function_file.
 *
 * @access public
 * @param string $type list types
 * @param string $id needle
 * @param string $name_select select name
 * @param string $function_file get block_list for $function_file
 * @param boolean $multiple_select
 * @param string $function_file2 get block_list also for $function_file2
 * @return string (html)
 */
function get_list_formatted($type, $id, $name_select = '', $function_file = '', $multiple_select = false, $function_file2 = '')
{
	global $db, $lang;

	if( $type == 'page_list' )
	{
		//
		// get pages dropdown
		//
		$name_select = empty($name_select) ? 'page_id' : $name_select;
		$idfield = 'page_id';
		$namefield = 'page_name';
		$descfield = 'page_desc';

		$sql = "SELECT *
			FROM " . PAGE_TABLE . "
			ORDER BY page_name ASC, page_desc ASC";
	}
	elseif( $type == 'function_list' )
	{
		//
		// get functions dropdown
		//
		$name_select = 'function_id';
		$idfield = 'function_id';
		$namefield = 'function_name';

		$sql = "SELECT function_admin, fnc.function_name, fnc.function_id, fnc.function_desc, fnc.module_id, mdl.module_name, mdl.module_id, mdl.module_desc
			FROM " . FUNCTION_TABLE . " fnc,
				" . MODULE_TABLE . " mdl
			WHERE mdl.module_id = fnc.module_id
			ORDER BY mdl.module_name ASC, fnc.function_name ASC";
	}
	elseif( $type == 'block_list' )
	{
		//
		// get all blocks dropdown (optionally filtering by function_file)
		//
		$idfield = 'block_id';
		$namefield = 'block_title';
		$descfield = 'block_desc';

		$function_file_filter_temp = ( !empty($function_file2) ? " OR fnc.function_file = '$function_file2'" : '' );
		$function_file_filter = ( !empty($function_file) ? " AND ( fnc.function_file = '$function_file' ".$function_file_filter_temp.")" : '' );

		$sql = "SELECT blk.*, function_admin, fnc.function_name, fnc.function_id, fnc.function_desc, fnc.module_id, mdl.module_name, mdl.module_id, mdl.module_desc
			FROM " . BLOCK_TABLE . " blk,
				" . FUNCTION_TABLE . " fnc,
				" . MODULE_TABLE . " mdl
			WHERE blk.function_id = fnc.function_id
				AND mdl.module_id = fnc.module_id
				$function_file_filter
			ORDER BY mdl.module_name ASC, fnc.function_name ASC";
	}
	elseif( $type == 'dyn_block_list' )
	{
		//
		// get all dynamic blocks dropdown (2.8)
		//
		$idfield = 'block_id';
		$namefield = 'block_title';
		$descfield = 'block_desc';

		$sql = "SELECT blk.*, function_admin, fnc.function_name, fnc.function_id, fnc.function_desc, fnc.module_id, mdl.module_name, mdl.module_id, mdl.module_desc
			FROM " . BLOCK_TABLE . " blk,
				" . FUNCTION_TABLE . " fnc,
				" . MODULE_TABLE . " mdl
			WHERE blk.function_id = fnc.function_id
				AND mdl.module_id = fnc.module_id
				AND fnc.function_file = 'mx_dynamic.php'
			ORDER BY mdl.module_name ASC, fnc.function_name ASC";
	}

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get list of Column/blocks", '', __LINE__, __FILE__, $sql);
	}

	if ($multiple_select)
	{
		$multiple_select_option = 'multiple="multiple"';
	}

	$column_list = '<select name="' . $name_select . '" '.$multiple_select_option.'>';
	if( $type == 'page_list' )
	{
		$column_list .= '<option value="0">' . "- not selected</option>\n";
	}

	if( $total_blocks = $db->sql_numrows($result) )
	{
		$row = $db->sql_fetchrowset($result);
	}

	for( $j = 0; $j < $total_blocks; $j++ )
	{
		if( $row[$j]['module_name'] != $row[$j-1]['module_name'] )
		{
			$column_list .= '<option value="">' . 'Module: ' . $row[$j]['module_name'] . '----------' . "</option>\n";
		}

		if( $type == 'block_list' )
		{
			if( $row[$j]['function_name'] != $row[$j-1]['function_name'] )
			{
				$block_type = $row[$j]['function_name'] . ': ';
			}
		}
		else
		{
			$block_type = '';
		}

		if( !empty($descfield) )
		{
			$block_description_str = !empty($row[$j][$descfield]) ? ' (' . $row[$j][$descfield] . ')' : ' (no desc)';
		}
		else
		{
			$block_description_str = '';
		}

		$selected = ( $row[$j][$idfield] == $id ) ? ' selected="selected"' : '';
		$column_list .= '<option value="' . $row[$j][$idfield] . '"' . $selected . '>&nbsp;&nbsp;- ' . $block_type . $row[$j][$namefield] . $block_description_str . "</option>\n";
	}
	$column_list .= '</select>';

	unset($row);
	$db->sql_freeresult($result);
	return $column_list;
}

/**
 * Get simple html select list - from db query.
 *
 * This function generates and returns a html select list (name = $nameselect) with option labels $namefield,
 * with data from $table. Use $select=true to select where $idfield value matches $id.
 * <code>
 * 	<select name=$nameselect>
 * 		// $idfield = $id
 * 		<option value=$idfield selected="selected">$namefield</option>
 * 		// $idfield != $id
 * 		<option value=$idfield >$namefield</option>
 * 		<option value=$idfield >$namefield</option>
 * 		<option value=$idfield >$namefield</option>
 * 	</select>
 * </code>
 * Note: This function auto inserts a top option 'not selected'.
 *
 * @access public
 * @param string $name_select select name
 * @param string $table target
 * @param string $idfield field
 * @param string $namefield option labels
 * @param string $id needle
 * @param boolean $select select idfield = id
 * @return string (html)
 */
function get_list_opt($name_select, $table, $idfield, $namefield, $id, $select)
{
	global $db, $lang;

	$sql = "SELECT * FROM $table";
	if( ! $select )
	{
		$sql .= " WHERE $idfield <> $id";
	}
	$sql .= " ORDER BY $namefield";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get list of Column/blocks", '', __LINE__, __FILE__, $sql);
	}

	$column_list = '<select name="'. $name_select . '">';
	$selected = ( $id == 0 ) ? ' selected="selected"' : '';
	$column_list .= '<option value="0"' . $selected . '>' . $lang['Not_Specified'] . "</option>\n";
	while( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row[$idfield] == $id ) ? ' selected="selected"' : '';
		$column_list .= "<option value=\"$row[$idfield]\"$selected>" . $row[$namefield] . "</option>\n";
	}
	$column_list .= '</select>';

	unset($row);
	$db->sql_freeresult($result);
	return $column_list;
}

/**
 * Jump menu function.
 *
 * @access public
 * @param unknown_type $page_id to handle parent page_id
 * @param unknown_type $depth related to function to generate tree
 * @param unknown_type $default the page you wanted to be selected
 * @return unknown
 */
function generate_page_jumpbox( $name_select, $page_id = 0, $depth = 0, $default = '' )
{
	global $db, $userdata, $portal_config, $lang;

	$sql = 'SELECT *
		FROM ' . PAGE_TABLE . '
		ORDER BY page_parent, page_order ASC';

	if ( !( $result = $db->sql_query( $sql ) ) )
	{
		mx_message_die( GENERAL_ERROR, 'Couldnt Query pages info', '', __LINE__, __FILE__, $sql );
	}

	$page_rowset = $db->sql_fetchrowset( $result );
	$db->sql_freeresult( $result );

	$pagesArray = array();
	for( $i = 0; $i < count( $page_rowset ); $i++ )
	{
		$pagesArray[$page_rowset[$i]['page_id']] = $page_rowset[$i];
	}

	$page_list .= '';
	$pre = str_repeat( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $depth );

	if ( !empty( $pagesArray ) )
	{
		foreach ( $pagesArray as $temp_page_id => $page )
		{
			if ( $page['page_parent'] == $page_id )
			{
					if ( $default == $page['page_id'] )
					{
						$sel = ' selected="selected"';
					}
					else
					{
						$sel = '';
					}

				$page_pre = '+ ';
				$sub_page_id = $page['page_id'];
				$page_class = '';
				$page_list .= '<option value="' . $sub_page_id . '"' . $sel . ' ' . $page_class . ' />' . $pre . $page_pre . $page['page_name'] . (!empty($page['page_desc']) ? ' (' .  $page['page_desc'] . ')'  : '') . '</option>';
				$page_list .= generate_page_jumpbox( $name_select, $page['page_id'], $depth + 1, $default );
			}
		}

		if ($page_id == 0)
		{
			// Format Select
			$pageList = '<select name="'. $name_select . '">';
			if ( !$pagesArray[$default]['page_parent'] )
			{
				$pageList .= '<option value="0" selected>' . $lang['None'] . '</option>\n';
			}
			else
			{
				$pageList .= '<option value="0">' . $lang['None'] . '</option>\n';
			}
			$pageList .= $page_list;
			$pageList .= '</select>';

			return $pageList;
		}
		else
		{
			return $page_list;
		}
	}
	else
	{
		return;
	}
}

/**
 * Generate MX-Publisher URL, with arguments.
 *
 * This function returns a MX-Publisher URL with GET vars, and accepts any number of parwise arguments.
 *
 * @access public
 * @return string (url)
 */
function mx_url()
{
	global $SID;

	$numargs = func_num_args();
	$url = $PHP_SELF . '?' . $_SERVER['QUERY_STRING'];
	$url = parse_url($url);

	$url_array = array();
	if( ! empty($url['query']) )
	{
		$url_array = explode('&', $url['query']);
	}

	$arg_list = func_get_args();

	// Check for each option if exists in the parameter list
	for( $i = 0; $i < $numargs; $i++ )
	{
		$option = $arg_list[$i];
		$i++;
		$value = $arg_list[$i];
		// If not exists in the parameter list then add the parameter
		$opt_fund = false;
		for( $j = 0; $j < count($url_array); $j++ )
		{
			$tmp = explode('=', $url_array[$j]);
			if( $option == $tmp[0] )
			{
				$url_array[$j] = $option . '=' . $value ;
				$opt_fund = true;
			}
		}
		if( !$opt_fund )
		{
			$next = count($url_array);
			$url_array[$next] = $option . '=' . $value ;
		}
	}

	$url = $url['path'];

	// Build the parameter list
	if( !strpos($url, '?') )
	{
		$url .= '?';
	}

	$url .= implode('&', $url_array);
	/*
	for ($j = 0; $j < count($url_array); $j++)
	{
		if( $j < count($url_array) -1 )
		{
		$url .= $url_array[$j] . "&"  ;
		}
		else
		{
		$url .= $url_array[$j];
		}
	}
	*/
	$url = str_replace('?&', '?', $url);
	$url = str_replace('.php&', ".php?", $url);
	return $url;
}

/**
 * Generate MX-Publisher URL, with arguments.
 *
 * This function returns a MX-Publisher URL with GET vars, and accepts arguments in the $args array().
 *
 * @access public
 * @param array $args source arguments
 * @param boolean $force_standalone_mode nonstandard file
 * @param string $file optional nonstandard file
 * @return string (url)
 */
function mx_this_url($args = '', $force_standalone_mode = false, $file = '')
{
	global $mx_root_path, $module_root_path, $page_id, $phpEx, $is_block;

	if( $force_standalone_mode )
	{
		$mxurl = ( $file == '' ? "./" : $file . '/' ) . ( $args == '' ? '' : '?' . $args );
	}
	else
	{
		$mxurl = $mx_root_path . 'index.' . $phpEx;
		if( is_numeric($page_id) )
		{
			$mxurl .= '?page=' . $page_id . ( $args == '' ? '' : '&amp;' . $args );
		}
		else
		{
			$mxurl = "./" . ( $args == '' ? '' : '?' . $args );
		}
	}
	return $mxurl;
}

/**
 * PHP Sessions Management.
 *
 * If necessary, GZIP initialization should be done before session_start().
 *
 * @access public
 */
function mx_session_start()
{
	global $board_config, $do_gzip_compress;

	//
	// Prevent from doing the job more than once.
	//
	static $_been_here_before = false;

	if ( $_been_here_before )
	{
		return;
	}
	$_been_here_before = true;

	//
	// gzip_compression
	//

	//
	// declared in common.php, just before calling mx_session_start. ;-)
	//
	//	$do_gzip_compress = FALSE;

	if ( $board_config['gzip_compress'] && !defined('MX_GZIP_DISABLED') )
	{
		$phpver = phpversion();

		$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

		if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
		{
			if ( extension_loaded('zlib') )
			{
				ob_end_clean();
				ob_start('ob_gzhandler');
			}
		}
		else if ( $phpver > '4.0' )
		{
			if ( strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') )
			{
				if ( extension_loaded('zlib') )
				{
					$do_gzip_compress = TRUE;
					ob_start();
					ob_implicit_flush(0);

					header('Content-Encoding: gzip');
				}
			}
		}
	}

	//
	// Initialize PHP session
	//
	@session_start();
}

/**
 * Get page_id for block or function.
 *
 * This function returns the page_id for the page on which a block (or a function block) is located.
 * First instance found is returned. Results are cached for later reuse. Examples:
 * - get_page_id('dload.php', true) - to find a pafileDB block
 * - get_page_id($block_id)
 *
 * @access public
 * @param string $search_item block_id (or function_file)
 * @param boolean $use_function_file $search_item is a function_file
 * @param boolean $get_page_data_array return page data results (not only id)
 * @return integer (array)
 */
function get_page_id($search_item, $use_function_file = false, $get_page_data_array = false)
{
	global $db, $userdata, $mx_cache;

	//
	// Try to reuse results.
	//
	$cache_key = '_pagemap_block' . $search_item;

	$page_id_array = array();
	if ( $mx_cache->_exists( $cache_key ) )
	{
		$page_id_array = unserialize( $mx_cache->get( $cache_key ) );
	}
	else
	{
		if( $use_function_file )
		{
			$sql = "SELECT * FROM " . FUNCTION_TABLE . " WHERE function_file = '$search_item' LIMIT 1";
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Could not query Activity Mod module information", '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$function_id = $row['function_id'];

			$sql = "SELECT * FROM " . BLOCK_TABLE . " WHERE function_id = '$function_id' LIMIT 1";
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Could not query " . $search_item . " module information", '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			$search_item = $row['block_id'];
		}

		//
		// First, see if we can get the page_id from ordinary blocks
		//
		$sql = "SELECT pag.page_id, pag.page_name, pag.page_desc
			FROM " . COLUMN_BLOCK_TABLE . " bct,
				" . PAGE_TABLE . " pag,
				" . COLUMN_TABLE . " col
			WHERE pag.page_id = col.page_id
				AND bct.column_id = col.column_id
				AND bct.block_id = '" . $search_item . "'
			ORDER BY pag.page_id
			LIMIT 1";

		if( !($p_result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Could not query column list", '', __LINE__, __FILE__, $sql);
		}
		$p_row = $db->sql_fetchrow($p_result);
		$db->sql_freeresult($result);

		if( empty($p_row['page_id']) )
		{
			//
			// Find all dynamic block Page_ids, if not present as ordinary block
			//
			$sql = "SELECT pag.page_id, pag.page_name, pag.page_desc, nav.block_id
				FROM " . PAGE_TABLE . " pag,
					" . BLOCK_TABLE . " blk,
					" . MENU_NAV_TABLE . " nav,
					" . MENU_CAT_TABLE . " nac
				WHERE pag.page_id = nav.page_id AND nav.page_id > 0
					AND nac.cat_id = nav.cat_id
					AND nav.block_id = blk.block_id
					AND nav.block_id = '" . $search_item . "'
				ORDER BY blk.block_id
				LIMIT 1";

			if( !($p_result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Could not query column list", '', __LINE__, __FILE__, $sql);
			}
			$db->sql_freeresult($result);
			$p_row = $db->sql_fetchrow($p_result);
		}


		if( empty($p_row['page_id']) )
		{
			//
			// Find all subblock page_ids
			//
			$sql = "SELECT pag.page_id, pag.page_name, pag.page_desc, sys.parameter_value
				FROM " . COLUMN_BLOCK_TABLE . " bct,
					" . PAGE_TABLE . " pag,
					" . COLUMN_TABLE . " col,
					" . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
					" . PARAMETER_TABLE . " par,
					" . FUNCTION_TABLE . " fcn
				WHERE pag.page_id = col.page_id
					AND bct.column_id = col.column_id
					AND bct.block_id = sys.block_id
					AND sys.parameter_id = par.parameter_id
					AND par.parameter_name = 'block_ids'
					AND par.function_id = fcn.function_id
					AND fcn.function_file = 'mx_multiple_blocks.php'
					ORDER BY sys.block_id";

			if( !($p_result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Could not query column list", '', __LINE__, __FILE__, $sql);
			}

			while( $temp_row = $db->sql_fetchrow($p_result) )
			{
				$block_ids_array = explode(',' , $temp_row['parameter_value']);

				foreach($block_ids_array as $key => $block_id)
				{
					if ($block_id == $search_item)
					{
						$p_row = $temp_row;
						continue;
					}
				}

				if (!empty($p_row['page_id']))
				{
					continue;
				}
			}
			$db->sql_freeresult($result);
		}

		if( empty($p_row['page_id']) )
		{
			//
			// Find if block is a default dynamic block (desperate try)
			//
			$sql = "SELECT pag.page_id, pag.page_name, pag.page_desc, sys.parameter_value
				FROM " . COLUMN_BLOCK_TABLE . " bct,
			       	" . PAGE_TABLE . " pag,
					" . COLUMN_TABLE . " col,
					" . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
					" . PARAMETER_TABLE . " par,
					" . FUNCTION_TABLE . " fcn
				WHERE pag.page_id = col.page_id
					AND bct.column_id = col.column_id
					AND bct.block_id = sys.block_id
					AND sys.parameter_id = par.parameter_id
					AND par.parameter_name = 'default_block_id'
					AND par.function_id = fcn.function_id
					AND fcn.function_file = 'mx_dynamic.php'
		   		ORDER BY sys.block_id";

			if( !($p_result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Could not query column list", '', __LINE__, __FILE__, $sql);
			}

			while( $temp_row = $db->sql_fetchrow($p_result) )
			{
				$block_ids_array = explode(',' , $temp_row['parameter_value']);

				foreach($block_ids_array as $key => $block_id)
				{
					if ($block_id == $search_item)
					{
						$p_row = $temp_row;
						continue;
					}
				}

				if (!empty($p_row['page_id']))
				{
					continue;
				}
			}
			$db->sql_freeresult($result);
		}

		$page_id_array = array();
		if (!empty($p_row['page_id']))
		{
			$page_id_array['page_id'] = $p_row['page_id'];
			$page_id_array['page_name'] = $p_row['page_name'];
			$page_id_array['page_desc'] = $p_row['page_desc'];
			$page_id_array['block_id'] = $p_row['block_id'];
		}
		unset($p_row);
		$mx_cache->put( $cache_key, serialize($page_id_array) );
	}

	if ( $get_page_data_array && !empty($page_id_array['page_id']) )
	{
		return $page_id_array;
	}
	else if(!empty($page_id_array['page_id']))
	{
		return $page_id_array['page_id'];
	}
	else
	{
		return '';
	}
}

/**
 * Generate icon select list.
 *
 * Handy function to generate icon select lists.
 *
 * @access public
 * @param string $icon_dir target
 * @param string $file_posticon selection
 * @param string $modules_path module path (optional)
 * @return string (html)
 */
function post_icons( $icon_dir = '', $file_posticon = '', $modules_path = '')
{
	global $lang, $phpbb_root_path, $module_root_path, $mx_root_path, $is_block, $phpEx, $images;

	$curicons = 1;
	if ( $file_posticon == 'none' || $file_posticon == 'none.gif' or empty( $file_posticon ) )
	{
		$posticons .= '<input type="radio" name="menuicons" value="none" checked><a class="gensmall">' . $lang['None'] . '</a>&nbsp;';
	}
	else
	{
		$posticons .= '<input type="radio" name="menuicons" value="none"><a class="gensmall">' . $lang['None'] . '</a>&nbsp;';
	}
	if ( $file_posticon == 'icon_spacer' || $file_posticon == 'icon_spacer.gif' )
	{
		$posticons .= '<input type="radio" name="menuicons" value="icon_spacer" checked><a class="gensmall">' . $lang['mx_spacer'] . '</a>&nbsp;';
	}
	else
	{
		$posticons .= '<input type="radio" name="menuicons" value="icon_spacer"><a class="gensmall">' . $lang['mx_spacer'] . '</a>&nbsp;';
	}

	switch ($icon_dir)
	{
		case 'menu_icons/':
			$current_template_path = $images['mx_graphics']['menu_icons'] . '/';
			break;

		case 'page_icons/':
			$current_template_path = $images['mx_graphics']['menu_icons'] . '/';
			break;

		default:
			$current_template_path = file_exists($mx_root_path . $modules_path . TEMPLATE_ROOT_PATH . 'images/' . $icon_dir) ? TEMPLATE_ROOT_PATH . 'images/' . $icon_dir : 'templates/_core/images' . $icon_dir ;
	}

	$handle = @opendir( $mx_root_path . $modules_path . $current_template_path );
	while ( $icon = @readdir( $handle ) )
	{
		if ( $icon !== '.' && $icon !== '..' && $icon !== 'CVS' && $icon !== 'index.htm' && !substr_count($icon, 'icon_bg') && !substr_count($icon, 'spacer') && !substr_count($icon, '_hot'))
		{
			if ( $file_posticon == $icon )
			{
				$posticons .= '<input type="radio" name="menuicons" value="' . $icon . '" checked><img src="' . PORTAL_URL . $modules_path . $current_template_path . $icon . '">&nbsp;';
			}
			else
			{
				$posticons .= '<input type="radio" name="menuicons" value="' . $icon . '"><img src="' . PORTAL_URL . $modules_path . $current_template_path . $icon . '">&nbsp;';
			}

			$curicons++;

			if ( $curicons == 8 )
			{
				$posticons .= '<br>';
				$curicons = 0;
			}
		}
	}
	@closedir( $handle );
	return $posticons;
}

/**
 * Get block parent data.
 *
 * Provided block_id, the function returns the parent function_id and module_id. Else false.
 *
 * @access public
 * @param integer $block_id
 * @param string $key return keyd array
 * @return array
 */
function mx_parent_data($block_id, $key = '')
{
	global $db;

	if (empty($block_id))
	{
		return false;
	}

	$sql = "SELECT mdl.module_id, fnc.function_id, blk.block_id
		FROM " . MODULE_TABLE . " mdl,
			" . FUNCTION_TABLE . " fnc,
			" . BLOCK_TABLE . " blk
		WHERE mdl.module_id = fnc.module_id
			AND fnc.function_id = blk.function_id
			AND blk.block_id = '" . $block_id . "'
			LIMIT 1";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain parents data", '', __LINE__, __FILE__, $sql);
	}

	$parent_array = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if (!empty($parent_array['module_id']))
	{
		if (!empty($key))
		{
			return $parent_array[$key];
		}
		return $parent_array;
	}
	return false;
}

/**
 * Compose MX-Publisher copyrights and credits page.
 * @access public
 */
function compose_mx_copy()
{
	global $table_prefix, $mx_table_prefix, $userdata, $phpEx, $template, $lang, $theme, $db, $board_config, $mx_page;

	$mx_page->page_title = $lang['mx_about_title'];

	$sql = "SELECT * FROM " . MODULE_TABLE . " ORDER BY module_name";
	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain modules from database", '', __LINE__, __FILE__, $sql);
	}
	$module = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$mx_module_copy = '<h1>' . $lang['mx_copy_title'] . '</h1><hr /><br />';
	$mx_module_copy .= '<br />' . '<span class="maintitle">' . $lang['mx_copy_modules_title'] . '</span>';

	for( $i = 0; $i < count($module); $i++ )
	{
		if( !empty($module[$i]['module_copy']) )
		{
			$mx_module_copy .= '<br />' . '<h3>' . $module[$i]['module_name'] . '</h3>' . $module[$i]['module_desc'] . (!empty($module[$i]['module_version']) ? ($module[$i]['module_version'] != 'mxBB Core Module' ? ' v. ' : ' - ' ) . $module[$i]['module_version'] : '') . '<br />' . $module[$i]['module_copy'];
		}
	}

	$translation_copy = (isset($lang['TRANSLATION_INFO'])) ? $lang['TRANSLATION_INFO'] : ((isset($lang['TRANSLATION'])) ? $lang['TRANSLATION'] : '');
	$translation_copy_mxbb = (isset($lang['TRANSLATION_INFO_MXBB'])) ? $lang['TRANSLATION_INFO_MXBB'] : ((isset($lang['TRANSLATION'])) ? $lang['TRANSLATION'] : '');

	$mx_module_copy .=  !empty($translation_copy) || !empty($translation_copy_mxbb) ? '<br /><br />' . '<span class="maintitle">' . $lang['mx_copy_translation_title'] . '</span><hr />' . (!empty($translation_copy) ? ('<br />phpBB: ' . $translation_copy) : '') . (!empty($translation_copy_mxbb) ? ('<br />mxBB: ' . $translation_copy_mxbb) : '') : '';

	$theme_copy = (isset($theme['template_copy'])) ? $theme['template_copy'] : '';
	$mx_module_copy .= '<br /><br />' . '<span class="maintitle">' . $lang['mx_copy_template_title'] . '</span><br />' . $theme_copy;

	$mx_module_copy = $mx_module_copy . '<br />';

	unset($module);
	mx_message_die(GENERAL_MESSAGE, $mx_module_copy, $lang['mx_about_title']);
}

/**
 * Read block data.
 *
 * For compatibility with old block calls.
 * NOTE: This usage is NOT preferred, and should only be used on rare occasions when the $mx_block object is unavailable.
 * This wrapper function calls the cache (if enabled) or db directly to get parameter data.
 *
 * @access public
 * @param integer $block_id target
 * @param boolean $force_query do not use cache
 * @return array block data
 */
function read_block_config( $block_id, $force_query = false )
{
	global $mx_cache, $mx_block;

	if ( empty( $mx_block->block_config[$block_id] ) )
	{
		$block_config_temp = $mx_cache->read( $block_id, MX_CACHE_BLOCK_TYPE, $force_query );
		$block_config_temp[$block_id] = array_merge($block_config_temp[$block_id]['block_info'], $block_config_temp[$block_id]['block_parameters']);
		return $block_config_temp;
	}
	$block_config_temp[$block_id] = array_merge($mx_block->block_info, $mx_block->block_parameters);
	return $block_config_temp;
}

/**
 * get_auth_blocks
 *
 * Temporary function for getting all block_ids vith auth_edit
 *
 * @access public
 * @return unknown
 */
function get_auth_blocks()
{
	global $userdata, $mx_root_path, $phpEx, $db;

	//
	// Try to reuse auth_view query result.
	//
	$userdata_key = 'mx_get_auth_block' . $userdata['user_id'];
	if( !empty($userdata[$userdata_key]) )
	{
		$auth_data_sql = $userdata[$userdata_key];
		return $auth_data_sql;
	}

	//
	// Get block data
	//

	// Generate dynamic block select
	$sql = "SELECT * FROM " . BLOCK_TABLE . " ORDER BY block_id";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't get blocks", '', __LINE__, __FILE__, $sql);
	}

	//
	// Loop through the list of forums to retrieve the ids for
	// those with AUTH_VIEW allowed.
	//
	$auth_data_sql = '';
	while ( $row = $db->sql_fetchrow($result) )
	{
		$mx_block_temp = new mx_block();
		$mx_block_temp->init($row['block_id']);

		if( $mx_block_temp->auth_edit )
		{
			$auth_data_sql .= ( $auth_data_sql != '' ) ? ', ' . $row['block_id'] : $row['block_id'];
		}
	}

	$db->sql_freeresult($result);

	if( empty($auth_data_sql) )
	{
		$auth_data_sql = -1;
	}

	$userdata[$userdata_key] = $auth_data_sql;
	return $auth_data_sql;
}

if( !function_exists('memory_get_usage') )
{
	/**
	 * Get php memory usage, if function is not declared by php
	 *
	 * Tested on Win XP Pro SP2. Should work on Win 2003 Server too.
	 * Doesn't work for 2000. If you need it to work for 2000 look at http://us2.php.net/manual/en/function.memory-get-usage.php#54642
	 *
	 * If its Windows
	 *
	 * @return integer
	 */
	function memory_get_usage()
	{
		if ( substr(PHP_OS,0,3) == 'WIN')
		{
			$output = array();
			exec( 'tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output );

			return preg_replace( '/[\D]/', '', $output[5] ) * 1024;
		}
		else
		{
			//We now assume the OS is UNIX
			//Tested on Mac OS X 10.4.6 and Linux Red Hat Enterprise 4
			//This should work on most UNIX systems
			$pid = getmypid();
			exec("ps -eo%mem,rss,pid | grep $pid", $output);
			$output = explode("  ", $output[0]);
			//rss is given in 1024 byte units
			return $output[1] * 1024;
		}
	}
}

if( !function_exists('get_backtrace') )
{
	/**
	 * Get backtrace.
	 *
	 * Return a nicely formatted backtrace (parts from the php manual by diz at ysagoon dot com)
	 *
	 * @return string (html)
	 */
	function get_backtrace()
	{
		global $mx_root_path;

		$output = '<div style="font-family: monospace;">';
		$backtrace = debug_backtrace();
		$path = realpath($mx_root_path);

		foreach ($backtrace as $number => $trace)
		{
			// We skip the first one, because it only shows this file/function
			if ($number == 0)
			{
				continue;
			}

			// Strip the current directory from path
			$trace['file'] = str_replace(array($path, '\\'), array('', '/'), $trace['file']);
			$trace['file'] = substr($trace['file'], 1);

			$args = array();
			foreach ($trace['args'] as $argument)
			{
				switch (gettype($argument))
				{
					case 'integer':
					case 'double':
						$args[] = $argument;
					break;

					case 'string':
						$argument = htmlspecialchars(substr($argument, 0, 64)) . ((strlen($argument) > 64) ? '...' : '');
						$args[] = "'{$argument}'";
					break;

					case 'array':
						$args[] = 'Array(' . sizeof($argument) . ')';
					break;

					case 'object':
						$args[] = 'Object(' . get_class($argument) . ')';
					break;

					case 'resource':
						$args[] = 'Resource(' . strstr($argument, '#') . ')';
					break;

					case 'boolean':
						$args[] = ($argument) ? 'true' : 'false';
					break;

					case 'NULL':
						$args[] = 'NULL';
					break;

					default:
						$args[] = 'Unknown';
				}
			}

			$trace['class'] = (!isset($trace['class'])) ? '' : $trace['class'];
			$trace['type'] = (!isset($trace['type'])) ? '' : $trace['type'];

			$output .= '<br />';
			$output .= '<b>FILE:</b> ' . htmlspecialchars($trace['file']) . '<br />';
			$output .= '<b>LINE:</b> ' . $trace['line'] . '<br />';
			$output .= '<b>CALL:</b> ' . htmlspecialchars($trace['class'] . $trace['type'] . $trace['function']) . '(' . ((sizeof($args)) ? implode(', ', $args) : '') . ')<br />';
		}
		$output .= '</div>';
		return $output;
	}

	/**
	 * Set config value.
	 *
	 * Creates missing config entry if needed.
	 *
	 * @param unknown_type $config_name
	 * @param unknown_type $config_value
	 * @param unknown_type $is_dynamic
	 */
	function mx_set_config($config_name, $config_value)
	{
		global $db, $mx_cache, $portal_config;

		$sql = 'UPDATE ' . PORTAL_TABLE . "
			SET config_value = '" . $db->sql_escape($config_value) . "'
			WHERE config_name = '" . $db->sql_escape($config_name) . "'";
		$db->sql_query($sql);

		if (!$db->sql_affectedrows() && !isset($config[$config_name]))
		{
			$sql = 'INSERT INTO ' . PORTAL_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				'config_name'	=> $config_name,
				'config_value'	=> $config_value));
			$db->sql_query($sql);
		}

		$portal_config[$config_name] = $config_value;
		$mx_cache->put( 'mxbb_config', $portal_config );
	}
}

/**
 * Get langcode.
 *
 * This function loops all meta langcodes, to convert internal MX-Publisher lang to standard langcode
 *
 */
function mx_get_langcode()
{
	global $userdata, $mx_root_path, $board_config, $phpEx;

	//
	// Load language file.
	//
	if( @file_exists($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_meta.' . $phpEx) )
	{
		include($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_meta.' . $phpEx);
	}
	else
	{
		include($mx_root_path . 'language/lang_english/lang_meta.' . $phpEx);
	}

	foreach ($lang['mx_meta']['langcode'] as $langcode => $mxbbLang)
	{
		if ( strtolower($mxbbLang) == $userdata['user_lang'] )
		{
			return $langcode;
		}
	}
}

/**
 * update config.php values.
 *
 */
function update_portal_backend($new_backend = PORTAL_BACKEND)
{
	global $mx_root_path, $lang, $phpEx, $portal_config;
	
	if( @file_exists($mx_root_path . "config.$phpEx") )
	{
		require($mx_root_path . "config.$phpEx");
	}	
	
	$mx_portal_name = 'MX-Publisher Modular System';
	
	/*
	$config = array(
		'dbms'		=> $dbms,
		'dbhost'		=> $dbhost,
		'dbname'		=> $dbname,
		'dbuser'		=> $dbuser,
		'dbpasswd'		=> $dbpasswd,
		'mx_table_prefix'		=> $mx_table_prefix,
		'portal_backend'		=> (!empty($portal_backend) ? $portal_backend : 'internal'),
	);
	*/	
	
	$new_backend = ($new_backend) ? $new_backend  : 'internal';	
	
	$process_msgs[] = 'Writing config ...<br />';

	$config_data = "<"."?php\n\n";
	$config_data .= "// $mx_portal_name auto-generated config file\n// Do not change anything in this file!\n\n";
	$config_data .= "// This file must be put into the $mx_portal_name directory, not into the phpBB directory.\n\n";
	$config_data .= '$'."dbms = '$dbms';\n\n";
	$config_data .= '$'."dbhost = '$dbhost';\n";
	$config_data .= '$'."dbname = '$dbname';\n";
	$config_data .= '$'."dbuser = '$dbuser';\n";
	$config_data .= '$'."dbpasswd = '$dbpasswd';\n\n";
	$config_data .= '$'."mx_table_prefix = '$mx_table_prefix';\n\n";
	$config_data .= "define('UTF_STATUS', '$new_backend');\n\n";	
	$config_data .= "define('MX_INSTALLED', true);\n\n";
	$config_data .= '?' . '>';	// Done this to prevent highlighting editors getting confused!

	@umask(0111);
	@chmod($mx_root_path . "config.$phpEx", 0644);

	if ( !($fp = @fopen($mx_root_path . 'config.' . $phpEx, 'w')) )
	{
		$process_msgs[] = "Unable to write config file " . $mx_root_path . "config.$phpEx" . "<br />\n";
	}
	$result = @fputs($fp, $config_data, strlen($config_data));
	@fclose($fp);

	$process_msgs[] = '<span style="color:pink;">'.str_replace("\n", "<br />\n", htmlspecialchars($config_data)).'</span>';
	
	$message = '<hr />';
	for( $i=0; $i < count($process_msgs); $i++ )
	{
		$message .= $process_msgs[$i] . ( $process_msgs[$i] == '<hr />' ? '' : '<br />' ) . "\n";
	}
	$message .= '<hr />';

	return $message;
}
?>