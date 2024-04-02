<?php
/**
*
* @package Functions
* @version $Id: mx_functions.php,v 3.130 2024/04/02 06:19:17 orynider Exp $
* @copyright (c) 2002-2024 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
* @link http://github.com/MX-Publisher
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
	
	$default_lang = (isset($mx_user->lang['default_lang'])) ? $mx_user->lang['default_lang'] : $board_config['default_lang'];

	if (!isset($msg_history))
	{
		$msg_history = array();
	}	
	
	$msg_history[] = array(
		'msg_code'		=> $msg_code,
		'msg_text'			=> $msg_text,
		'msg_title'			=> $msg_title,
		'err_line'				=> $err_line,
		'err_file'				=> $err_file,
		'sql'						=> $sql
	);
	
	//
	//This will check whaever we are installing
	//
	if (defined('HAS_DIED'))
	{
		// This message is printed at the end of the report.
		// Of course, you can change it to suit your own needs. ;-)
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
		
		for ( $i = 0; $i < count($msg_history); $i++ )
		{
			echo '<b>Error #' . ($i+1) . "</b>\n<br />\n";
			
			if ( !empty($msg_history[$i]['msg_title']) )
			{
				echo '<b>' . $msg_history[$i]['msg_title'] . "</b>\n<br />\n";
			}
			
			echo $msg_history[$i]['msg_text'] . "\n<br /><br />\n";
			
			if ( !empty($msg_history[$i]['err_line']) )
			{
				echo '<b>Line :</b> ' . $msg_history[$i]['err_line'] . '<br /><b>File :</b> ' . $msg_history[$i]['err_file'] . "</b>\n<br />\n";
			}
			
			if ( !empty($msg_history[$i]['sql']) )
			{
				echo '<b>SQL :</b> ' . $msg_history[$i]['sql'] . "\n<br />\n";
			}
			echo "&nbsp;<hr />\n";
		}
		
		if (version_compare(PHP_VERSION, '5.4') < 0)
		{
			echo('You are running an unsupported PHP version: ' . PHP_VERSION . '. Please upgrade to PHP 5.4.6 or higher before trying to install phpBB3 or install / upgrate MX-Publisher 3<br />');
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
	if ( !is_object($mx_user) && !is_object($mx_page) && !is_object($mx_request_vars))
	{
		die('Hacking attempt, or couldn\'t initalize the main classes required to call mx_message_die().');
	}

	if ( !is_object($mx_user))
	{
		$mx_user = new mx_user();
	}

	if ( !is_object($mx_page))
	{
		$mx_page = new mx_page();
	}

	if ( !is_object($mx_request_vars))
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
	if (empty($userdata) && ($msg_code == GENERAL_MESSAGE || $msg_code == GENERAL_ERROR))
	{
		$mx_user->init($user_ip, $page_id, false);
	}

	if (empty($theme))
	{
		global $user_ip;
		
		$mx_user->page_id = 1;
		$mx_user->user_ip = $user_ip;
		$mx_user->_init_userprefs();
	}

	//
	// Load and instatiate CORE (page) and block classes
	//
	$mx_page->init($page_id);

	$default_lang = (isset($mx_user->lang['default_lang'])) ? $mx_user->encode_lang($mx_user->lang['default_lang']) : $board_config['default_lang'];

	if (empty($default_lang))
	{
		// - populate $default_lang
		$default_lang = 'english';
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
			include_once($mx_root_path . 'includes/page_header.'.$phpEx);
		}
		else
		{
			include_once($mx_root_path . 'admin/page_header_admin.'.$phpEx);
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
		if ($debug_text != '')
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
			define('TEMPLATE_ROOT_PATH', "{$mx_root_path}templates/" . (isset($theme['template_name']) ?  rawurlencode($theme['template_name']) : 'all') . '/');
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
			$layouttemplate->set_filenames(array('overall_footer' => 'msgdie_footer.tpl',));
			$layouttemplate->pparse('overall_footer');			
		}		
	}
	exit;
}

/**
; User error handling and logging in PHP;
; E_USER_ERROR      		- user-generated error message
; E_USER_WARNING    	- user-generated warning message
; E_USER_NOTICE     		- user-generated notice message
; E_USER_DEPRECATED - user-generated deprecation warnings 
*/
function mx_msg_handler($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
{		
	global $db, $mx_user, $board_config, $phpbb_auth, $mx_root_path;
	
	$errno = $msg_code;
	$err_file = $msg_title;
	
	// Do not display notices if we suppress them via @
	if (error_reporting() == 0 && $errno != E_USER_ERROR && $errno != E_USER_WARNING && $errno != E_USER_NOTICE && $errno != E_USER_DEPRECATED)
	{
		return;
	}	
			
	//
	// Get SQL error if we are debugging. Do this as soon as possible to prevent
	// subsequent queries from overwriting the status of sql_error()
	//
	if (DEBUG && ($msg_code == E_USER_NOTICE || $msg_code == E_USER_ERROR))
	{	
		if ( isset($sql) )
		{
			$sql_error = $db->sql_error($sql);
			$sql_error['message'] = $sql_error['message'] ? $sql_error['message'] : '<br /><br />SQL : ' . $sql; 
			$sql_error['code'] = $sql_error['code'] ? $sql_error['code'] : 0;
		}
		else
		{
			$sql_error = $db->sql_error_returned;
			$sql_error['message'] = $db->sql_error_returned['message']; 
			$sql_error['code'] = $db->sql_error_returned['code'];
		}
				
		$debug_text = '';
				
		//Some code with harcoded language from function db::sql_error() and other from msg_handler() with some fixes here
		// If error occurs in initiating the session we need to use a pre-defined language string
		// This could happen if the connection could not be established for example (then we are not able to grab the default language)
		if ( isset($sql_error['message']) )
		{	
				$message = 'SQL  ' . $mx_user->lang('ERROR') . ' [ ' . $db->sql_layer . ' ]<br /><br />' . $sql_error['message'] . ' [' . $sql_error['code'] . ']';
					
				if (!empty($mx_user->lang['SQL_ERROR_OCCURRED']))
				{
					$message .= '<br /><br />An sql error occurred while fetching this page. Please contact an administrator if this problem persists.';
				}
				else
				{
					if (!empty($board_config['board_contact']))
					{
						$message .= '<br /><br />' . sprintf($mx_user->lang('SQL_ERROR_OCCURRED'), '<a href="mailto:' . $board_config['board_contact'] . '">', '</a>');
					}
					else
					{
						$message .= '<br /><br />' . sprintf($mx_user->lang('SQL_ERROR_OCCURRED'), '', '');
					}
				}
				$debug_text .= '<br /><br />SQL '  . $mx_user->lang('ERROR') . ' ' . $mx_user->lang('COLON') . ' ' . $sql_error['code'] . ' ' . $sql_error['message'];
		}
				
		if ( isset($sql_store) )
		{
			$debug_text .= "<br /><br />$sql_store";
		}

		if ( isset($err_line) && isset($err_file) )
		{
			$debug_text .= '</br /><br />Line : ' . $err_line . '<br />File : ' . $err_file;
		}
	}
			
	switch($msg_code)
	{
		case E_NOTICE:
		case E_WARNING:

			// Check the error reporting level and return if the error level does not match
			// If DEBUG is defined the default level is E_ALL
			if (($errno & ((defined('DEBUG')) ? E_ALL : error_reporting())) == 0)
			{
				return;
			}

			if (strpos($err_file, 'cache') === false && strpos($err_file, 'template.') === false)
			{
				$err_file = mx_filter_root_path($err_file);
				$msg_text = mx_filter_root_path($msg_text);
				$error_name = ($errno === E_WARNING) ? 'PHP Warning' : 'PHP Notice';
				echo '<b>[phpBB Debug] ' . $error_name . '</b>: in file <b>' . $err_file . '</b> on line <b>' . $err_line . '</b>: <b>' . $msg_text . '</b><br />' . "\n";
				echo '<br /><br />BACKTRACE<br />' . mx_get_backtrace() . '<br />' . "\n";
			}

			return;

		break;

		case E_USER_ERROR:

			if (!empty($mx_user) && $mx_user->is_setup())
			{
				$msg_text = (!empty($mx_user->lang[$msg_text])) ? $mx_user->lang[$msg_text] : $msg_text;
				$msg_title = (!isset($msg_title)) ? $mx_user->lang['GENERAL_ERROR'] : ((!empty($mx_user->lang[$msg_title])) ? $mx_user->lang[$msg_title] : $msg_title);

				$l_return_index = sprintf($mx_user->lang['RETURN_INDEX'], '<a href="' . $mx_root_path . '">', '</a>');
				$l_notify = '';

				if (!empty($board_config['board_contact']))
				{
					$l_notify = '<p>' . sprintf($mx_user->lang['NOTIFY_ADMIN_EMAIL'], $board_config['board_contact']) . '</p>';
				}
			}
			else
			{
				$msg_title = 'General Error';
				$l_return_index = '<a href="' . $phpbb_root_path . '">Return to index page</a>';
				$l_notify = '';

				if (!empty($board_config['board_contact']))
				{
					$l_notify = '<p>Please notify the board administrator or webmaster: <a href="mailto:' . $board_config['board_contact'] . '">' . $config['board_contact'] . '</a></p>';
				}
			}

			$log_text = $msg_text;
			$backtrace = get_backtrace();
			if ($backtrace)
			{
				$log_text .= '<br /><br />BACKTRACE<br />' . $backtrace;
			}

			if (defined('IN_INSTALL') || defined('DEBUG') || isset($phpbb_auth) && $phpbb_auth->acl_get('a_'))
			{
				$msg_text = $log_text;

				// If this is defined there already was some output
				// So let's not break it
				if (defined('IN_DB_UPDATE'))
				{
					echo '<div class="errorbox">' . $msg_text . '</div>';

					$db->sql_return_on_error(true);
					mx_end_update($mx_cache, $board_config);
				}
			}

			if ((defined('IN_CRON') || defined('IMAGE_OUTPUT')) && isset($db))
			{
				// let's avoid loops
				$db->sql_return_on_error(true);
				echo '<b>[phpBB Debug] ' . $error_name . '</b>: in file <b>' . $errfile . '</b> on line <b>' . $errline . '</b>: <b>' . $msg_text . '</b><br />' . "\n";
				echo '<br /><br />BACKTRACE<br />' . get_backtrace() . '<br />' . "\n";
				$db->sql_return_on_error(false);
			}

			// Do not send 200 OK, but service unavailable on errors
			//send_status_line(503, 'Service Unavailable');

			garbage_collection();

			// Try to not call the adm page data...

			echo '<!DOCTYPE html>';
			echo '<html dir="ltr">';
			echo '<head>';
			echo '<meta charset="utf-8">';
			echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
			echo '<title>' . $msg_title . '</title>';
			echo '<style type="text/css">' . "\n" . '/* <![CDATA[ */' . "\n";
			echo '* { margin: 0; padding: 0; } html { font-size: 100%; height: 100%; margin-bottom: 1px; background-color: #E4EDF0; } body { font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif; color: #536482; background: #E4EDF0; font-size: 62.5%; margin: 0; } ';
			echo 'a:link, a:active, a:visited { color: #006699; text-decoration: none; } a:hover { color: #DD6900; text-decoration: underline; } ';
			echo '#wrap { padding: 0 20px 15px 20px; min-width: 615px; } #page-header { text-align: right; height: 40px; } #page-footer { clear: both; font-size: 1em; text-align: center; } ';
			echo '.panel { margin: 4px 0; background-color: #FFFFFF; border: solid 1px  #A9B8C2; } ';
			echo '#errorpage #page-header a { font-weight: bold; line-height: 6em; } #errorpage #content { padding: 10px; } #errorpage #content h1 { line-height: 1.2em; margin-bottom: 0; color: #DF075C; } ';
			echo '#errorpage #content div { margin-top: 20px; margin-bottom: 5px; border-bottom: 1px solid #CCCCCC; padding-bottom: 5px; color: #333333; font: bold 1.2em "Lucida Grande", Arial, Helvetica, sans-serif; text-decoration: none; line-height: 120%; text-align: left; } ';
			echo "\n" . '/* ]]> */' . "\n";
			echo '</style>';
			echo '</head>';
			echo '<body id="errorpage">';
			echo '<div id="wrap">';
			echo '	<div id="page-header">';
			echo '		' . $l_return_index;
			echo '	</div>';
			echo '	<div id="acp">';
			echo '	<div class="panel">';
			echo '		<div id="content">';
			echo '			<h1>' . $msg_title . '</h1>';

			echo '			<div>' . $msg_text . '</div>';

			echo $l_notify;

			echo '		</div>';
			echo '	</div>';
			echo '	</div>';
			echo '	<div id="page-footer">';
			echo '		Powered by <a href="https://mxpcms.sourceforge.net/">MXP</a>&reg; CMS &amp; phpBB <a href="https://www.phpbb.com/">phpBB</a>&reg; Forum Software &copy; phpBB Limited';
			echo '	</div>';
			echo '</div>';
			echo '</body>';
			echo '</html>';

			exit_handler();

			// On a fatal error (and E_USER_ERROR *is* fatal) we never want other scripts to continue and force an exit here.
			exit;
		break;

		case E_USER_WARNING:
		case E_USER_NOTICE:

			define('IN_ERROR_HANDLER', true);

			if (empty($mx_user->data))
			{
				$mx_user->session_begin();
			}

			// We re-init the auth array to get correct results on login/logout
			$phpbb_auth->acl($mx_user->data);

			if (!$mx_user->is_setup())
			{
				$mx_user->setup();
			}

			if ($msg_text == 'ERROR_NO_ATTACHMENT' || $msg_text == 'NO_FORUM' || $msg_text == 'NO_TOPIC' || $msg_text == 'NO_USER')
			{
				//send_status_line(404, 'Not Found');
			}

			$msg_text = (!empty($mx_user->lang[$msg_text])) ? $mx_user->lang[$msg_text] : $msg_text;
			$msg_title = (!isset($msg_title)) ? $mx_user->lang['INFORMATION'] : ((!empty($mx_user->lang[$msg_title])) ? $mx_user->lang[$msg_title] : $msg_title);

			if (!defined('HEADER_INC'))
			{
				if (defined('IN_ADMIN') && isset($mx_user->data['session_admin']) && $mx_user->data['session_admin'])
				{
					mx_admin_page_header($msg_title);
				}
				else
				{
					mx_page_header($msg_title);
				}
			}

			$template->set_filenames(array(
				'body' => 'message_body.html')
			);

			$template->assign_vars(array(
				'MESSAGE_TITLE'		=> $msg_title,
				'MESSAGE_TEXT'		=> $msg_text,
				'S_USER_WARNING'	=> ($errno == E_USER_WARNING) ? true : false,
				'S_USER_NOTICE'		=> ($errno == E_USER_NOTICE) ? true : false)
			);

			// We do not want the cron script to be called on error messages
			define('IN_CRON', true);

			if (defined('IN_ADMIN') && isset($mx_user->data['session_admin']) && $mx_user->data['session_admin'])
			{
				mx_admin_page_footer();
			}
			else
			{
				mx_page_footer();
			}

			exit_handler();
		break;

		// PHP4 compatibility
		case E_DEPRECATED:
			return true;
		break;
	}
			
	//
	// Add on DEBUG info if we've enabled debug mode and this is an error. This
	// prevents debug info being output for general messages should DEBUG be
	// set TRUE by accident (preventing confusion for the end user!)
	//
	if ( DEBUG && ( $msg_code == E_USER_NOTICE || $msg_code == E_USER_ERROR ) )
	{
		if ( $debug_text != '' )
		{
			$msg_text = $msg_text . '<br /><br /><b><u>DEBUG MODE</u></b> ' . $debug_text;
		}
	}
			
	$msg_text = (!empty($mx_user->lang[$msg_text])) ? $mx_user->lang[$msg_text] : $msg_text;
	$msg_title = (!empty($mx_user->lang[$msg_title])) ? $mx_user->lang[$msg_title] : $msg_title;
			
	mx_message_die($msg_code, $msg_text, $msg_title, $err_line, $err_file, $sql);
}

/**
* Removes absolute path to mxp root directory from error messages
* and converts backslashes to forward slashes.
*
* @param string $err_file	Absolute file path
*							(e.g. /var/www/mxpcms/includes/mx_functions.php)
*							Please note that if $err_file is outside of the mx root,
*							the root path will not be found and can not be filtered.
* @return string			Relative file path
*							(e.g. /includes/mx_functions.php)
*/
function mx_filter_root_path($err_file)
{
	global $mx_root_path;

	if (empty($mx_root_path))
	{
		$mx_root_path = realpath(__DIR__ . '/../');
	}

	return str_replace(array($mx_root_path, '\\'), array('[ROOT]', '/'), $err_file);
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
	global $_SID, $_EXTRA_URL, $mx_user, $portal_config, $mx_mod_rewrite;

	// Assign sid if session id is not specified
	if ($session_id === false)
	{
		$session_id = $_SID;
	}
	
	//Fix for login page
	if ( !empty($url) && preg_match('#'.PORTAL_URL.'#', $url) && defined('IN_LOGIN') )
	{
		$url = preg_replace('#' . PORTAL_URL . '#', '', $url);
	}		

	if (is_array($session_id))
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
	
	//Fix for login page
	if ( !empty($url) && preg_match('#'.PORTAL_URL.'#', $url) && !defined('IN_ADMIN') && defined('IN_LOGIN') )
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
/**
 * Redirect.
 *
 * MX-Publisher version of phpBB redirect().
 *
 * @param string $url
 * @param string $redirect_msg
 * @param string $redirect_link
 */
function mx_redirect($url, $redirect_msg = '', $redirect_link = '', $base_url = PORTAL_URL, $permanent = false)
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
		$url = $base_url . $url;
	}

	// Behave as per HTTP/1.1 by https://stackoverflow.com/users/89771/alix-axel 
	if (headers_sent() === false)
	{
		header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
		exit;
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
// Encode the IP from decimals into hexademicals
//
function mx_encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

//
// Decode the IP from hexademicals to decimals
//
function mx_decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

//
// Create date/time from format and timezone
//
function mx_create_date($format, $gmepoch, $tz)
{
	global $mx_user, $board_config, $lang;
		
	static $translate;
	static $midnight;
	static $date_cache;

	$format = (!$format) ? $mx_user->date_format : $format;
	$now = time();
	$delta = $now - $gmepoch;

	if (!isset($date_cache[$format]))
	{
		// Is the user requesting a friendly date format (i.e. 'Today 12:42')?
		$date_cache[$format] = array(
			'is_short'		=> strpos($format, '|'),
			'format_short'	=> substr($format, 0, strpos($format, '|')) . '||' . substr(strrchr($format, '|'), 1),
			'format_long'	=> str_replace('|', '', $format),
			// Filter out values that are not strings (e.g. arrays) for strtr().
			'lang'			=> array_filter($mx_user->lang['datetime'], 'is_string'),
		);

		// Short representation of month in format? Some languages use different terms for the long and short format of May
		if ((strpos($format, '\M') === false && strpos($format, 'M') !== false) || (strpos($format, '\r') === false && strpos($format, 'r') !== false))
		{
			$date_cache[$format]['lang']['May'] = $mx_user->lang['datetime']['May_short'];
		}
	}
	
	// Zone offset
	$zone_offset = $mx_user->timezone + $mx_user->dst;
		
	// Show date <= 1 hour ago as 'xx min ago' but not greater than 60 seconds in the future
	// A small tolerence is given for times in the future but in the same minute are displayed as '< than a minute ago'
	if ($delta <= 3600 && $delta > -60 && ($delta >= -5 || (($now / 60) % 60) == (($gmepoch / 60) % 60)) && $date_cache[$format]['is_short'] !== false && !$forcedate && isset($this->lang['datetime']['AGO']))
	{
		return $this->lang(array('datetime', 'AGO'), max(0, (int) floor($delta / 60)));
	}

	if (!$midnight)
	{
		list($d, $m, $y) = explode(' ', gmdate('j n Y', time() + $zone_offset));
		$midnight = gmmktime(0, 0, 0, $m, $d, $y) - $zone_offset;
	}

	if ($date_cache[$format]['is_short'] !== false && !$forcedate && !($gmepoch < $midnight - 86400 || $gmepoch > $midnight + 172800))
	{
		$day = false;

		if ($gmepoch > $midnight + 86400)
		{
			$day = 'TOMORROW';
		}
		else if ($gmepoch > $midnight)
		{
			$day = 'TODAY';
		}
		else if ($gmepoch > $midnight - 86400)
		{
			$day = 'YESTERDAY';
		}

		if ($day !== false)
		{
			return str_replace('||', $mx_user->lang['datetime'][$day], strtr(@gmdate($date_cache[$format]['format_short'], $gmepoch + $zone_offset), $date_cache[$format]['lang']));
		}
	}	
		
	if (empty($translate) && $board_config['default_lang'] != 'english')
	{
		@reset($lang['datetime']);
		while (list($match, $replace) = @each($lang['datetime']))
		{
			$translate[$match] = $replace;
		}
	}
	
	if (empty($translate))
	{
		@reset($lang['datetime']);
		/*
		* Import phpBB Graphics, prefix with PHPBB_URL, and apply LANG info
		/* start Migrating from php5 to php7+ replace
			foreach ($lang['datetime'] as $match => $replace)
		with
			while(list($match, $replace) = each($lang['datetime']))
		ends Migrating
		*/
		foreach ($lang['datetime'] as $match => $replace)
		{
			$translate[$match] = $replace;
		}
	}
	return (!is_array($translate)) ? strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $translate) : strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $date_cache[$format]['lang']);
}

/**
* Global function for chmodding directories and files for internal use
*
* This function determines owner and group whom the file belongs to and user and group of PHP and then set safest possible file permissions.
* The function determines owner and group from common.php file and sets the same to the provided file.
* The function uses bit fields to build the permissions.
* The function sets the appropiate execute bit on directories.
*
* Supported constants representing bit fields are:
*
* CHMOD_ALL - all permissions (7)
* CHMOD_READ - read permission (4)
* CHMOD_WRITE - write permission (2)
* CHMOD_EXECUTE - execute permission (1)
*
* NOTE: The function uses POSIX extension and fileowner()/filegroup() functions. If any of them is disabled, this function tries to build proper permissions, by calling is_readable() and is_writable() functions.
*
* @param string	$filename	The file/directory to be chmodded
* @param int	$perms		Permissions to set
*
* @return bool	true on success, otherwise false
* @author faw, phpBB Group
*/
function mx3_chmod($filename, $perms = CHMOD_READ)
{
	static $_chmod_info;

	// Return if the file no longer exists.
	if (!file_exists($filename))
	{
		return false;
	}

	// Determine some common vars
	if (empty($_chmod_info))
	{
		if (!function_exists('fileowner') || !function_exists('filegroup'))
		{
			// No need to further determine owner/group - it is unknown
			$_chmod_info['process'] = false;
		}
		else
		{
			global $mx_root_path, $phpEx;

			// Determine owner/group of common.php file and the filename we want to change here
			$common_php_owner = @fileowner($mx_root_path . 'common.' . $phpEx);
			$common_php_group = @filegroup($mx_root_path . 'common.' . $phpEx);

			// And the owner and the groups PHP is running under.
			$php_uid = (function_exists('posix_getuid')) ? @posix_getuid() : false;
			$php_gids = (function_exists('posix_getgroups')) ? @posix_getgroups() : false;

			// If we are unable to get owner/group, then do not try to set them by guessing
			if (!$php_uid || empty($php_gids) || !$common_php_owner || !$common_php_group)
			{
				$_chmod_info['process'] = false;
			}
			else
			{
				$_chmod_info = array(
					'process'		=> true,
					'common_owner'	=> $common_php_owner,
					'common_group'	=> $common_php_group,
					'php_uid'		=> $php_uid,
					'php_gids'		=> $php_gids,
				);
			}
		}
	}

	if ($_chmod_info['process'])
	{
		$file_uid = @fileowner($filename);
		$file_gid = @filegroup($filename);

		// Change owner
		if (@chown($filename, $_chmod_info['common_owner']))
		{
			clearstatcache();
			$file_uid = @fileowner($filename);
		}

		// Change group
		if (@chgrp($filename, $_chmod_info['common_group']))
		{
			clearstatcache();
			$file_gid = @filegroup($filename);
		}

		// If the file_uid/gid now match the one from common.php we can process further, else we are not able to change something
		if ($file_uid != $_chmod_info['common_owner'] || $file_gid != $_chmod_info['common_group'])
		{
			$_chmod_info['process'] = false;
		}
	}

	// Still able to process?
	if ($_chmod_info['process'])
	{
		if ($file_uid == $_chmod_info['php_uid'])
		{
			$php = 'owner';
		}
		else if (in_array($file_gid, $_chmod_info['php_gids']))
		{
			$php = 'group';
		}
		else
		{
			// Since we are setting the everyone bit anyway, no need to do expensive operations
			$_chmod_info['process'] = false;
		}
	}

	// We are not able to determine or change something
	if (!$_chmod_info['process'])
	{
		$php = 'other';
	}

	// Owner always has read/write permission
	$owner = CHMOD_READ | CHMOD_WRITE;
	if (is_dir($filename))
	{
		$owner |= CHMOD_EXECUTE;

		// Only add execute bit to the permission if the dir needs to be readable
		if ($perms & CHMOD_READ)
		{
			$perms |= CHMOD_EXECUTE;
		}
	}

	switch ($php)
	{
		case 'owner':
			$result = @chmod($filename, ($owner << 6) + (0 << 3) + (0 << 0));
			clearstatcache();
			if (is_readable($filename) && mx_is_writable($filename))
			{
				break;
			}

		case 'group':
			$result = @chmod($filename, ($owner << 6) + ($perms << 3) + (0 << 0));
			clearstatcache();
			if ((!($perms & CHMOD_READ) || is_readable($filename)) && (!($perms & CHMOD_WRITE) || mx_is_writable($filename)))
			{
				break;
			}

		case 'other':
			$result = @chmod($filename, ($owner << 6) + ($perms << 3) + ($perms << 0));
			clearstatcache();
			if ((!($perms & CHMOD_READ) || is_readable($filename)) && (!($perms & CHMOD_WRITE) || mx_is_writable($filename)))
			{
				break;
			}

		default:
			return false;
		break;
	}

	return $result;
}


/** /
*
* Credit: https://stackoverflow.com/users/2456038/rafasashi
/**/
function mx_file_exists($file_path = '')
{
	// Assume failure.
	 $file_exists = true;
	 $status = "unknown";
	
	//$file_path = 'http://php.net/images/logos/php-logo.svg';
	//clear cached results
	//clearstatcache();
	
	//trim path
	$file_dir = trim(dirname($file_path));
	
	//trim file name
	$file_name = trim(basename($file_path));
	
	//rebuild path
	$file_path = $file_dir . "/{$file_name}";
	
	global $mx_root_path, $phpbb_root_path;
	
	//If you simply want to check that some file (not directory) exists, 
	//and concerned about performance, try is_file() instead.
	//It seems like is_file() is almost 2x faster when a file exists 
	//and about the same when it doesn't.
		
	$file = $file_dir . '/' . $file_name;
	
	if (function_exists('is_file') && @is_file($file)) 
	{
		$status = "is_file";
		$file_exists = true;
	}
	
	if (function_exists('curl_init') && (!ini_get('safe_mode') || !strtolower(ini_get('safe_mode')) == 'on')) 
	{
		 // Assume failure.
		 $data = -1;
		 $ch = curl_init($file);
		 // Issue a HEAD request and follow any redirects.
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win32; x86; rv:63.0) Gecko/20100101 Firefox/63.0.68');  
		$data = curl_exec($ch);
		
		curl_close($ch);
		
		 if ($data) 
		 {
		    $content_length = "unknown";
		    $status = "curl_init";
			
		    if(preg_match("/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches))
			{
				$status = (int)$matches[1];
				$file_exists = ($status == '200') ? true : (($status == '404') ? false : false);
				
			}
		}
	}
	
	if (function_exists('file_exists') && @file_exists(str_replace(array(PORTAL_URL, PHPBB_URL), array($mx_root_path, $phpbb_root_path), $file_path))) 
	{
		$status = "file_exists";
		$file_exists = true;
	}
		
	if (function_exists('filesize') && @filesize(str_replace(array(PORTAL_URL, PHPBB_URL), array($mx_root_path, $phpbb_root_path), $file_path))) 
	{
		$status = "filesize";
		$file_exists = true;
	}
	
	return $file_exists;
}

/** /
*
* Credit: https://stackoverflow.com/users/2456038/rafasashi
/**/
function mx_local_file_exists($file_path = '')
{
	// Assume failure.
	 $file_exists = true;
	 $status = "unknown";
	
	//$file_path = 'http://php.net/images/logos/php-logo.svg';
	//clear cached results
	//clearstatcache();
	
	//trim path
	$file_dir = trim(dirname($file_path));
	
	//trim file name
	$file_name = trim(basename($file_path));
	
	//rebuild path
	$file_path = $file_dir . "/{$file_name}";
	
	global $mx_root_path, $phpbb_root_path;
	
	//If you simply want to check that some file (not directory) exists, 
	//and concerned about performance, try is_file() instead.
	//It seems like is_file() is almost 2x faster when a file exists 
	//and about the same when it doesn't.
		
	$file = $file_dir . '/' . $file_name;
	
	if (function_exists('is_file') && @is_file($file)) 
	{
		$status = "is_file";
		$file_exists = true;
	}
	
	if (function_exists('file_exists') && @file_exists(str_replace(array(PORTAL_URL, PHPBB_URL), array($mx_root_path, $phpbb_root_path), $file_path))) 
	{
		$status = "file_exists";
		$file_exists = true;
	}
		
	if (function_exists('filesize') && @filesize(str_replace(array(PORTAL_URL, PHPBB_URL), array($mx_root_path, $phpbb_root_path), $file_path))) 
	{
		$status = "filesize";
		$file_exists = true;
	}
	
	return $file_exists;
}

/**
* Test if a file/directory is writable
*
* This function calls the native is_writable() when not running under
* Windows and it is not disabled.
*
* @param string $file Path to perform write test on
* @return bool True when the path is writable, otherwise false.
*/
function mx_is_writable($file)
{
	if (strtolower(substr(PHP_OS, 0, 3)) === 'win' || !function_exists('is_writable'))
	{
		if (file_exists($file))
		{
			// Canonicalise path to absolute path
			$file = mx_realpath($file);

			if (is_dir($file))
			{
				// Test directory by creating a file inside the directory
				$result = @tempnam($file, 'i_w');

				if (is_string($result) && file_exists($result))
				{
					unlink($result);

					// Ensure the file is actually in the directory (returned realpathed)
					return (strpos($result, $file) === 0) ? true : false;
				}
			}
			else
			{
				$handle = @fopen($file, 'r+');

				if (is_resource($handle))
				{
					fclose($handle);
					return true;
				}
			}
		}
		else
		{
			// file does not exist test if we can write to the directory
			$dir = dirname($file);

			if (file_exists($dir) && is_dir($dir) && mx_is_writable($dir))
			{
				return true;
			}
		}

		return false;
	}
	else
	{
		return is_writable($file);
	}
}

/**
* Generate portal url (example: http://www.example.com/)
* @param bool $without_script_path if set to true the script path gets not appended (example: http://www.example.com)
*/
function generate_portal_url($without_script_path = false)
{
	global $board_config, $portal_config, $mx_user;
	
	$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($portal_config['script_path']));
	$server_name = $mx_user->host ? $mx_user->host : trim($portal_config['server_name']);
	$server_protocol = ( $portal_config['cookie_secure'] ) ? 'https://' : 'http://';
	$server_port = (($portal_config['server_port']) && ($portal_config['server_port'] <> 80)) ? ':' . trim($portal_config['server_port']) . '/' : '/';
	$server_url = $server_protocol . str_replace("//", "/", $server_name . $server_port . $script_name . '/'); //On some server the slash is not added and this trick will fix it
	$server_port = (!empty($_SERVER['SERVER_PORT'])) ? (int) $_SERVER['SERVER_PORT'] : (int) getenv('SERVER_PORT');

	// Forcing server vars is the only way to specify/override the protocol
	if ((isset($board_config['force_server_vars']) && $board_config['force_server_vars']) || !$server_name)
	{
		$server_protocol = ($server_protocol) ? $server_protocol : (($portal_config['cookie_secure']) ? 'https://' : 'http://');
		$server_name = $portal_config['server_name'];
		$server_port = (int) $portal_config['server_port'];
		$script_path = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($portal_config['script_path']));

		$url = $server_protocol . $server_name;
		$cookie_secure = $portal_config['cookie_secure'];
	}
	else
	{
		// Do not rely on cookie_secure, users seem to think that it means a secured cookie instead of an encrypted connection
		$cookie_secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1 : 0;
		$url = (($cookie_secure) ? 'https://' : 'http://') . $server_name;

		$script_path = $mx_user->page['root_script_path'];
	}

	if ($server_port && (($cookie_secure && $server_port <> 443) || (!$cookie_secure && $server_port <> 80)))
	{
		// HTTP HOST can carry a port number (we fetch $mx_user->host, but for old versions this may be true)
		if (strpos($server_name, ':') === false)
		{
			$url .= ':' . $server_port;
		}
	}

	if (!$without_script_path)
	{
		$url .= $script_path;
	}

	// Strip / from the end
	if (substr($url, -1, 1) == '/')
	{
		$url = substr($url, 0, -1);
	}

	return $url;
}
//Form validation

/**
* Return mx_unique id
*/
function mx_unique_id()
{
	return bin2hex(random_bytes(8));
}

/**
* Add a secret hash   for use in links/GET requests
* @param string  $link_name The name of the link; has to match the name used in check_link_hash, otherwise no restrictions apply
* @return string the hash
unique_id()
*/
function mx_generate_link_hash($link_name)
{
	global $mx_user;

	if (!isset($mx_user->data["hash_$link_name"]))
	{
		$mx_user->data["hash_$link_name"] = substr(sha1($mx_user->data['user_form_salt'] . $link_name), 0, 8);
	}

	return $mx_user->data["hash_$link_name"];
}

/**
*
* @version Version 0.1 / $Id: functions.php,v 1.28 2014/05/16 18:02:39 orynider Exp $
*
	* Portable PHP password hashing framework.
	*
	* Written by Solar Designer <solar at openwall.com> in 2004-2006 and placed in
	* the public domain.
	*
	* There's absolutely no warranty.
	*
	* The homepage URL for this framework is:
	*
	*	http://www.openwall.com/phpass/
	*
	* Please be sure to update the Version line if you edit this file in any way.
	* It is suggested that you leave the main version number intact, but indicate
	* your project name (after the slash) and add your own revision information.
	*
	* Please do not change the "private" password hashing method implemented in
	* here, thereby making your hashes incompatible.  However, if you must, please
	* change the hash type identifier (the "$P$") to something different.
	*
	* Obviously, since this code is in the public domain, the above are not
	* requirements (there can be none), but merely suggestions.
	*
*
* Hash the password
*/
function mx_hash($password)
{
	global $phpBB3;

	$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

	$random_state = mx_unique_id();
	$random = '';
	$count = 6;

	if (($fh = @fopen('/dev/urandom', 'rb')))
	{
		$random = fread($fh, $count);
		fclose($fh);
	}

	if (strlen($random) < $count)
	{
		$random = '';

		for ($i = 0; $i < $count; $i += 16)
		{
			$random_state = md5(mx_unique_id() . $random_state);
			$random .= pack('H*', md5($random_state));
		}
		$random = substr($random, 0, $count);
	}

	$hash = $phpBB3->_hash_crypt_private($password, $phpBB3->_hash_gensalt_private($random, $itoa64), $itoa64);

	if (strlen($hash) == 34)
	{
		return $hash;
	}

	return md5($password);
}

/**
* checks a link hash - for GET requests
* @param string $token the submitted token
* @param string $link_name The name of the link
* @return boolean true if all is fine
*/
function mx_check_link_hash($token, $link_name)
{
	return $token === mx_generate_link_hash($link_name);
}

/**
* Hashes an email address to a big integer
*
* @param string $email	Email address
*
* @return string		Unsigned Big Integer
*/
function mx_email_hash($email)
{
	return sprintf('%u', crc32(strtolower($email))) . strlen($email);
}

/**
* Hashes an email address to a big integer
*
* @param string $email		Email address
*
* @return string			Unsigned Big Integer
*/
function phpbb_rhea_email_hash($email)
{
	return sprintf('%u', crc32(strtolower($email))) . strlen($email);
}

/**
* Wrapper for version_compare() that allows using uppercase A and B
* for alpha and beta releases.
*
* See http://www.php.net/manual/en/function.version-compare.php
*
* @param string $version1		First version number
* @param string $version2		Second version number
* @param string $operator		Comparison operator (optional)
*
* @return mixed					Boolean (true, false) if comparison operator is specified.
*								Integer (-1, 0, 1) otherwise.
*/
function mx_version_compare($version1, $version2, $operator = null)
{
	$version1 = strtolower($version1);
	$version2 = strtolower($version2);

	if (is_null($operator))
	{
		return version_compare($version1, $version2);
	}
	else
	{
		return version_compare($version1, $version2, $operator);
	}
}

/**
* Add a secret token to the form (requires the S_FORM_TOKEN template variable)
* @param string  $form_name The name of the form; has to match the name used in check_form_key, otherwise no restrictions apply
* @param string  $template_variable_suffix A string that is appended to the name of the template variable to which the form elements are assigned
*/
function mx_add_form_key($form_name, $template_variable_suffix = '')
{
	global $board_config, $template, $mx_user;

	$now = time();
	$token_sid = ($mx_user->data['user_id'] == ANONYMOUS) ? $mx_user->session_id : '';
	$token = sha1($now . $mx_user->data['user_form_salt'] . $form_name . $token_sid);

	$s_fields = mx_build_hidden_fields(array(
		'creation_time' => $now,
		'form_token'	=> $token,
	));

	$template->assign_var('S_FORM_TOKEN' . $template_variable_suffix, $s_fields);
}

/**
 * Check the form key. Required for all altering actions not secured by confirm_box
 *
 * @param	string	$form_name	The name of the form; has to match the name used
 *								in add_form_key, otherwise no restrictions apply
 * @param	int		$timespan	The maximum acceptable age for a submitted form
 *								in seconds. Defaults to the config setting.
 * @return	bool	True, if the form key was valid, false otherwise
 */
function mx_check_form_key($form_name, $timespan = false)
{
	global $board_config, $mx_request_vars, $mx_user;

	if ($timespan === false)
	{
		// we enforce a minimum value of half a minute here.
		$timespan = ($board_config['form_token_lifetime'] == -1) ? -1 : max(30, $board_config['form_token_lifetime']);
	}

	if ($mx_request_vars->is_set_post('creation_time') && $mx_request_vars->is_set_post('form_token'))
	{
		$creation_time	= abs($mx_request_vars->request('creation_time', 0));
		$token = $mx_request_vars->variable('form_token', '');

		$diff = time() - $creation_time;

		// If creation_time and the time() now is zero we can assume it was not a human doing this (the check for if ($diff)...
		if (defined('DEBUG_TEST') || $diff && ($diff <= $timespan || $timespan === -1))
		{
			$token_sid = ($mx_user->data['user_id'] == ANONYMOUS && !empty($board_config['form_token_sid_guests'])) ? $mx_user->session_id : '';
			$key = sha1($creation_time . $mx_user->data['user_form_salt'] . $form_name . $token_sid);

			if ($key === $token)
			{
				return true;
			}
		}
	}

	return false;
}

// Little helpers

/**
* Little helper for the build_hidden_fields function
*/
function mxp_build_hidden_fields($key, $value, $specialchar, $stripslashes)
{
	$hidden_fields = '';

	if (!is_array($value))
	{
		$value = ($stripslashes) ? stripslashes($value) : $value;
		$value = ($specialchar) ? htmlspecialchars($value, ENT_COMPAT, 'UTF-8') : $value;

		$hidden_fields .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
	}
	else
	{
		foreach ($value as $_key => $_value)
		{
			$_key = ($stripslashes) ? stripslashes($_key) : $_key;
			$_key = ($specialchar) ? htmlspecialchars($_key, ENT_COMPAT, 'UTF-8') : $_key;

			$hidden_fields .= mxp_build_hidden_fields($key . '[' . $_key . ']', $_value, $specialchar, $stripslashes);
		}
	}

	return $hidden_fields;
}

/**
* Build simple hidden fields from array
*
* @param array $field_ary an array of values to build the hidden field from
* @param bool $specialchar if true, keys and values get specialchared
* @param bool $stripslashes if true, keys and values get stripslashed
*
* @return string the hidden fields
*/
function mx_build_hidden_fields($field_ary, $specialchar = false, $stripslashes = false)
{
	$s_hidden_fields = '';

	foreach ($field_ary as $name => $vars)
	{
		$name = ($stripslashes) ? stripslashes($name) : $name;
		$name = ($specialchar) ? htmlspecialchars($name, ENT_COMPAT, 'UTF-8') : $name;

		$s_hidden_fields .= mxp_build_hidden_fields($name, $vars, $specialchar, $stripslashes);
	}

	return $s_hidden_fields;
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
 * This function is a wrapper for ltrim, as charlist is only supported in php >= 4.1.0
 * added in phpBB 2.0.18
 * added here for reference
*/
function mx_ltrim($str, $charlist = false)
{
	if ($charlist === false)
	{
		return ltrim($str);
	}
	
	$php_version = explode('.', PHP_VERSION);

	/**
	* If we are on PHP >= 4.1 we do not need some code
	*/
	if ((int) $php_version[0] < 4 || ((int) $php_version[0] == 4 && (int) $php_version[1] < 1))
	{
		while ($str[0] == $charlist)
		{
			$str = substr($str, 1);
		}
	}
	else
	{
		$str = ltrim($str, $charlist);
	}

	return $str;
}

/**
 * This function is a wrapper for rtrim, as charlist is only supported in php >= 4.1.0
 * added in phpBB 2.0.12 to fix a bug in PHP 4.3.10
 * added here for reference 
*/
function mx_rtrim($str, $charlist = false)
{
	if ($charlist === false)
	{
		return rtrim($str);
	}

	$php_version = explode('.', PHP_VERSION);

	/**
	* If we are on PHP >= 4.1 we do not need some code
	*/
	if ((int) $php_version[0] < 4 || ((int) $php_version[0] == 4 && (int) $php_version[1] < 1))
	{
		while ($str[strlen($str)-1] == $charlist)
		{
			$str = substr($str, 0, strlen($str)-1);
		}
	}
	else
	{
		$str = rtrim($str, $charlist);
	}

	return $str;
}

/**
 * Cleans the username
 *
 * based on phpbb_clean_username() 
 * added at phpBB 2.0.11 to properly format the username 
 *
 * @param string $username
 * @return string
 * @return string
 */
function mx_clean_username($username)
{
	$username = preg_replace('#(?<=href=")[\./]+?/(?=\w)#', PORTAL_URL . '/', $username);
	
	if (strpos($username, '---') !== false)
	{
		$username = str_replace('---', '', $username);
		mx_clean_username($username);
	}
	
	$username = substr(htmlspecialchars(str_replace("\'", "'", trim($username))), 0, 25);
	$username = rtrim($username, "\\");
	$username = str_replace("'", "\'", $username);

	return $username;
}

/**
 * Get userdata
 *
 * Get Userdata, $mx_user can be username or user_id. If force_str is true, the username will be forced.
 * Cached sql, since this function is used for every block.
 *
 * @param unknown_type $mx_user id or name
 * @param boolean $force_str force clean_username
 * @return array
 */
function mx_get_userdata($mxuser, $force_str = false)
{
	global $db;

	if (!is_numeric($mxuser) || $force_str)
	{
		$mxuser = mx_clean_username($mxuser);
	}
	else
	{
		$mxuser = intval($mxuser);
	}

	$sql = "SELECT *
		FROM " . USERS_TABLE . "
		WHERE ";
	$sql .= ((is_integer($mxuser)) ? "user_id = $mxuser" : "username = '" .  str_replace("\'", "''", $mxuser) . "'" ) . " AND user_id <> " . ANONYMOUS;
	if (!($result = $db->sql_query($sql)))
	{
		mx_message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
	}

	$return = ($row = $db->sql_fetchrow($result)) ? $row : false;
	$db->sql_freeresult($result);
	return $return;
}

/**
* Get user avatar
*
* @param array $user_row Row from the users table
* @param string $alt Optional language string for alt tag within image, can be a language key or text
* @param bool $ignore_config Ignores the config-setting, to be still able to view the avatar in the UCP
* @param bool $lazy If true, will be lazy loaded (requires JS)
*
* @return string Avatar html
*/
function mx_get_user_avatar($user_row, $alt = 'USER_AVATAR', $ignore_config = false, $lazy = false)
{
	return mx_get_avatar($user_row, $alt, $ignore_config, $lazy);
}

/**
* Get group avatar
*
* @param array $group_row Row from the groups table
* @param string $alt Optional language string for alt tag within image, can be a language key or text
* @param bool $ignore_config Ignores the config-setting, to be still able to view the avatar in the UCP
* @param bool $lazy If true, will be lazy loaded (requires JS)
*
* @return string Avatar html
*/
function mx_get_group_avatar($user_row, $alt = 'GROUP_AVATAR', $ignore_config = false, $lazy = false)
{
	return mx_get_avatar($user_row, $alt, $ignore_config, $lazy);
}

/**
* Build gravatar URL for output on page
*
* @param array $row User data or group data that has been cleaned with
*        \phpbb\avatar\manager::clean_row
* @return string Gravatar URL
*/
function mx_get_gravatar_url($row)
{
	$url = '//secure.gravatar.com/avatar/';
	
	$url .=  md5(strtolower(trim($row['avatar'])));

	if ($row['avatar_width'] || $row['avatar_height'])
	{
		$url .= '?s=' . max($row['avatar_width'], $row['avatar_height']);
	}
	
	return $url;
}

/**
* Get avatar
*
* @param array $row Row cleaned by \phpbb\avatar\manager::clean_row
* @param string $alt Optional language string for alt tag within image, can be a language key or text
* @param bool $ignore_config Ignores the config-setting, to be still able to view the avatar in the UCP
* @param bool $lazy If true, will be lazy loaded (requires JS)
*
* @return string Avatar html
*/
function mx_get_avatar($row, $alt, $ignore_config = false, $lazy = false)
{
	global $mx_user, $board_config, $mx_cache, $mx_root_path, $phpbb_root_path, $phpEx;

	//if (!$mx_user->optionget('viewavatars') && !$ignore_config)
	//{
	//	return '';
	//}
	$avatar_data = array();
	
	if ( $mx_user->data['user_id'] == ANONYMOUS )
	{
		$row['user_avatar'] 	= !empty($row['user_avatar']) ? $row['user_avatar'] :  'guest_aphrodite.gif';
	}
	elseif ($mx_user->data['user_type'] = 3)
	{
		$row['user_avatar'] 	= !empty($row['user_avatar']) ? $row['user_avatar'] :  'admin_aphrodite.gif';
	}
	elseif (($mx_user->data['user_level'] = 0) && ($mx_user->data['user_active'] = 1))
	{
		$row['user_avatar'] 	= !empty($row['user_avatar']) ? $row['user_avatar'] :  'member_aphrodite.gif';
	}
	elseif ($mx_user->data['user_type'] = 1)
	{
		$row['user_avatar'] 	= !empty($row['user_avatar']) ? $row['user_avatar'] :  'member_aphrodite.gif';
	}
	elseif ($mx_user->data['user_type'] = 2)
	{
		$row['user_avatar'] 	= !empty($row['user_avatar']) ? $row['user_avatar'] :  'mod_aphrodite.gif';
	}

	$row = array_merge(array(
		'avatar' 		=> !empty($row['avatar']) ? $row['avatar'] :  $row['user_avatar'],
		'avatar_type' 	=> isset($row['avatar_type']) ? $row['avatar_type'] : $row['user_avatar_type'],
		'avatar_width' 	=> isset($row['avatar_width']) ? $row['avatar_width'] : (isset($row['user_avatar_width']) ? $row['user_avatar_width'] : '120'),
		'avatar_height' => isset($row['avatar_height']) ? $row['avatar_height'] : (isset($row['user_avatar_height']) ? $row['user_avatar_height'] : '120'),
	), $row);

	$avatar_data = array(
		'src' => $row['avatar'],
		'width' => $row['avatar_width'],
		'height' => $row['avatar_height'],
	);

	
	$driver = $row['avatar_type'];
	$html = '';
	if (empty($driver))
	{
		$driver = 'upload';
	}
	
	if ($driver)
	{
		
		$html = '<img src="' . mx_get_gravatar_url($row) . '" ' .
			($row['avatar_width'] ? ('width="' . $row['avatar_width'] . '" ') : '') .
			($row['avatar_height'] ? ('height="' . $row['avatar_height'] . '" ') : '') .
			'alt="' . ((!empty($lang[$alt])) ? $lang[$alt] : $alt) . '" />';

		if (!empty($html))
		{
			//return $html;
		}

		$root_path = generate_portal_url();
		if (is_file($phpbb_root_path .  'images/avatars/default_avatars/' . $row['avatar']))
		{
			$avatar_path = $phpbb_root_path . 'images/avatars/default_avatars/';
		}
		elseif (is_file($phpbb_root_path .  'images/avatars/default_avatars/' . $row['user_avatar']))
		{
			$avatar_path = $phpbb_root_path . 'images/avatars/default_avatars/';
		}
		elseif (is_file($phpbb_root_path . $board_config['avatar_gallery_path'] . '/' . $row['avatar']))
		{
			$avatar_path = $phpbb_root_path . $board_config['avatar_gallery_path'] . '/';
		}
		elseif (is_file($phpbb_root_path .  'images/avatars/upload/' . $row['avatar']))
		{
			$avatar_path = $phpbb_root_path . 'images/avatars/upload/';
		}
		elseif (is_file($mx_root_path . $board_config['avatar_gallery_path'] . '/' . $row['avatar']))
		{
			$avatar_path = $mx_root_path . $board_config['avatar_gallery_path'] . '/';
		}
		elseif (is_file($mx_root_path .  'images/avatars/upload/' . $row['avatar']))
		{
			$avatar_path = $mx_root_path . 'images/avatars/upload/';
		}
		else
		{
			$avatar_path = $mx_root_path . 'images/avatars/default_avatars/';
		}
		$avatar_data = array(
			'src' => empty($row['avatar']) ? $avatar_path . $row['user_avatar'] : $avatar_path . $row['avatar'],
			'width' => $row['avatar_width'],
			'height' => $row['avatar_height'],
		);
	}
	else
	{
		$avatar_data['src'] = '';
	}
	
	if (!empty($avatar_data['src']))
	{
		if ($lazy)
		{
			// Determine board url - we may need it later
			$board_url = generate_portal_url() . '/';
			// This path is sent with the base template paths in the assign_vars()
			// call below. We need to correct it in case we are accessing from a
			// controller because the web paths will be incorrect otherwise.

			$web_path = $board_url;

			if (is_dir($phpbb_root_path . $mx_user->template_path . $mx_user->template_name . '/theme/images/'))
			{
				$theme_images = "{$web_path}{$mx_user->template_path}" . rawurlencode($mx_user->template_name) . '/theme/images';
			}
			elseif (is_dir($phpbb_root_path . $mx_user->template_path . $mx_user->template_name . '/images/'))
			{
				$theme_images = "{$web_path}{$mx_user->template_path}" . rawurlencode($mx_user->template_name . '/images');
			}
			$src = 'src="' . $theme_images . '/no_avatar.gif" data-src="' . $avatar_data['src'] . '"';
		}
		else
		{
			$src = 'src="' . $avatar_data['src'] . '"';
		}

		$html = '<img class="avatar" ' . $src . ' ' .
			($avatar_data['width'] ? ('width="' . $avatar_data['width'] . '" ') : '') .
			($avatar_data['height'] ? ('height="' . $avatar_data['height'] . '" ') : '') .
			'alt="' . ((!empty($mx_user->lang[$alt])) ? $mx_user->lang[$alt] : $alt) . '" />';
	}
	return $html;
}

/**
* Get user rank title and image
*
* @param array $userdata the current stored users data
* @param int $user_posts the users number of posts
*
* @return array An associative array containing the rank title (title), the rank image as full img tag (img) and the rank image source (img_src)
*
* Note: since we do not want to break backwards-compatibility, this function will only properly assign ranks to guests if you call it for them with user_posts == false
*/
function mx_get_user_rank($userdata, $user_posts, &$rank_title = null, &$rank_img = null, &$rank_img_src = null)
{
	global $ranks, $board_config, $phpbb_root_path;

	$user_rank_data = array(
		'title'		=> $rank_title ? $rank_title : null,
		'img'		=> $rank_img ? $rank_img : null,
		'img_src'	=> $rank_img_src ? $rank_img_src : null,
	);	
	
	if (empty($ranks))
	{
		global $mx_cache;
		$ranks = $mx_cache->obtain_ranks();
	}

	if (!empty($userdata))
	{
		$user_rank_data['title'] = (isset($ranks['special'][$userdata['user_rank']]['rank_title'])) ? $ranks['special'][$userdata['user_rank']]['rank_title'] : '';
		$user_rank_data['img'] = (!empty($ranks['special'][$userdata['user_rank']]['rank_image'])) ? '<img src="' . $user_rank_data['img_src'] . '" alt="' . $ranks['special'][$userdata['user_rank']]['rank_title'] . '" title="' . $ranks['special'][$userdata['user_rank']]['rank_title'] . '" />' : '';
		$user_rank_data['img_src'] = (!empty($ranks['special'][$userdata['user_rank']]['rank_image'])) ? $phpbb_root_path . $board_config['ranks_path'] . '/' . $ranks['special'][$userdata['user_rank']]['rank_image'] : '';	
	}
	else if ($user_posts !== false)
	{
		if (!empty($ranks['normal']))
		{
			foreach ($ranks['normal'] as $rank)
			{
				if ($user_posts >= $rank['rank_min'])
				{
					$user_rank_data['title'] = $rank['rank_title'];
					$user_rank_data['img'] = (!empty($rank['rank_image'])) ? '<img src="' . $phpbb_root_path . $board_config['ranks_path'] . '/' . $rank['rank_image'] . '" alt="' . $rank['rank_title'] . '" title="' . $rank['rank_title'] . '" />' : '';
					$user_rank_data['img_src'] = (!empty($rank['rank_image'])) ? $phpbb_root_path . $board_config['ranks_path'] . '/' . $rank['rank_image'] : '';
					break;
				}
			}
		}
	}
	
	return $user_rank_data;
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
	global $phpEx, $phpBB2, $mx_root_path, $mx_user;

	$dir = opendir($mx_root_path . $dirname);

	$lang = array();
	while ( $file = readdir($dir) )
	{
		if (preg_match('#^lang_#i', $file) && !is_file(@$phpBB2->phpbb_realpath($mx_root_path . $dirname . '/' . $file)) && !is_link(@$phpBB2->phpbb_realpath($mx_root_path . $dirname . '/' . $file)))
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
		$selected = ( strtolower($mx_user->decode_lang($default)) == strtolower($displayname) ) ? ' selected="selected"' : '';
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

	switch (PORTAL_BACKEND)
	{
		case 'internal':
		case 'smf2':
		case 'mybb':
			$sql = "SELECT  themes_id, style_name
						FROM " . MX_THEMES_TABLE . "
							WHERE portal_backend = '" . 'internal' . "'
								OR portal_backend = '" . PORTAL_BACKEND . "'
								ORDER BY template_name, themes_id";
		break;
					
		case 'phpbb2':
			$sql = "SELECT s.themes_id as style_id, mxt.themes_id, mxt.template_name as style_path
						FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " s
							WHERE mxt.template_name = s.template_name
								AND ( mxt.portal_backend = 'phpbb2' OR mxt.portal_backend = '" . PORTAL_BACKEND . "' )
								ORDER BY mxt.template_name, mxt.themes_id";
		break;
					
		case 'olympus':
			$sql = "SELECT  mxt.themes_id, bbt.style_id, bbt.style_name, bbt.style_path
						FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TEMPLATE_TABLE . " AS stt, " . STYLES_TABLE . " AS bbt
							WHERE bbt.style_active = 1 
								AND bbt.style_name = mxt.style_name
								AND ( mxt.portal_backend = 'phpbb3' OR mxt.portal_backend = '" . PORTAL_BACKEND . "' )
								AND stt.template_id = bbt.template_id
								ORDER BY mxt.template_name, mxt.themes_id";
		break;
					
		case 'rhea':
		case 'proteus':
		case 'phpbb3':
		case 'ascraeus':
			$sql = "SELECT  mxt.themes_id, bbt.style_id, bbt.style_name, bbt.style_path
						FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TABLE . " AS bbt
							WHERE bbt.style_active = 1 
								AND bbt.style_name = mxt.style_name
								AND ( mxt.portal_backend = 'phpbb3' OR mxt.portal_backend = '" . PORTAL_BACKEND . "' )
								ORDER BY mxt.template_name, mxt.themes_id";
		break;
	}
	
	if (!($result = $db->sql_query($sql)))
	{
		$sql = "SELECT themes_id, style_name
			FROM " . MX_THEMES_TABLE . "
			WHERE portal_backend <> '" . PORTAL_BACKEND . "'
			ORDER BY template_name, themes_id";
		if (!($result = $db->sql_query($sql)))
		{
			mx_message_die(GENERAL_ERROR, "Couldn't query themes table", "", __LINE__, __FILE__, $sql);
		}
		$lang['Select_page_style'] = 'Bad Style-Backend';
		$show_instruction = true;
	}
	
	$style_select = '<select name="' . $select_name . '">';
	$selected1 = ($default_style == -1) ? ' selected="selected"' : '';
	if ($show_instruction)
	{
		$style_select .= '<option value="-1"' . $selected1 . '>' . $lang['Select_page_style'] . '</option>';
	}

	while (!($row = $db->sql_fetchrow($result)))
	{
		$sql = "SELECT themes_id, style_name
			FROM " . MX_THEMES_TABLE . "
			WHERE portal_backend <> '" . PORTAL_BACKEND . "'
			ORDER BY template_name, themes_id";
		if (!($result = $db->sql_query($sql, 300)))
		{
			mx_message_die(GENERAL_ERROR, "Couldn't query themes table", "", __LINE__, __FILE__, $sql);
		}
	}

	while ($row = $db->sql_fetchrow($result))
	{
		$id = $row['themes_id'];
		$selected = ($id == $default_style && !$selected1) ? ' selected="selected"' : '';
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
			mx_message_die(GENERAL_ERROR, "Couldn't get list of groups", '', __LINE__, __FILE__, $sql);
		}
		
		$group_rowset = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);
 	}

	$grouplist = '<select name="'.$field_entry.'">';
	$grouplist .= '<option value="0">' . t('Select_group') . '</option>';

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
* Censoring
*/
function mx_censor_text($text)
{
	static $censors;
	global $mx_cache;

	if (!isset($censors) || !is_array($censors))
	{
		// obtain_word_list is taking care of the users censor option and the board-wide option
		$censors = $mx_cache->obtain_word_list();
	}

	if (sizeof($censors))
	{
		return preg_replace($censors['match'], $censors['replace'], $text);
	}

	return $text;
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

	$text = mx_censor_text($text);

	// Parse bbcode if bbcode uid stored and bbcode enabled
	if ($uid && ($flags & OPTION_FLAG_BBCODE))
	{
		if (!class_exists('mx_bbcode'))
		{
			global $phpbb_root_path, $phpEx;
			//mx_cache::load_file('bbcode', 'phpbb3');
		}

		if (empty($mx_bbcode))
		{
			$mx_bbcode = new __construct($bitfield);
		}
		else
		{
			$mx_bbcode->__construct($bitfield);
		}

		$mx_bbcode->bbcode_second_pass($text, $uid);
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
	else
	{
		$multiple_select_option = '';
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

	for($j = 0; $j < $total_blocks; $j++)
	{
		$i = ($j > 0) ? abs($j - 1) : 0;
		if(empty($row[$j]['module_name']))
		{
			$row[$j]['module_name'] = '';
		}
		if($row[$j]['module_name'] != $row[$i]['module_name'])
		{
			$column_list .= '<option value="">' . 'Module: ' . $row[$j]['module_name'] . '----------' . "</option>\n";
		}
		$block_type = '';
		if( $type == 'block_list' )
		{
			if( $row[$j]['function_name'] != $row[$i]['function_name'] )
			{
				$block_type = $row[$j]['function_name'] . ': ';
			}
		}
		$block_description_str = '';		
		if( !empty($descfield) )
		{
			$block_description_str = !empty($row[$j][$descfield]) ? ' (' . $row[$j][$descfield] . ')' : ' (no desc)';
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
	$column_list .= '<option value="0"' . $selected . '>' . (isset($lang['Not_Specified']) ? $lang['Not_Specified'] : $lang['NOT_SPECIFIED']) . "</option>\n";
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
	global $board_config, $do_gzip_compress, $mx_user, $mx_request_vars, $sid;

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

	if ($board_config['gzip_compress'] && !defined('MX_GZIP_DISABLED'))
	{
		$phpver = phpversion();

		$mx_useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

		if ($phpver >= '4.0.4pl1' && (strstr($mx_useragent,'compatible') || strstr($mx_useragent,'Gecko')))
		{
			if (extension_loaded('zlib'))
			{
				ob_end_clean();
				ob_start('ob_gzhandler');
			}
		}
		else if ($phpver > '4.0')
		{
			if (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
			{
				if (extension_loaded('zlib') )
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
	//phpinfo();
	//Security check
	if(is_object($mx_request_vars) || !empty($mx_user->session_id))
	{
		// session id check
		if (!$mx_request_vars->is_empty_request('sid'))
		{
			$sid = $mx_request_vars->request('sid', MX_TYPE_NO_TAGS, $mx_user->session_id);
		}
		session_id(strip_tags($sid));
	}
	// ok to try and start the session
	if (!empty($sid))
	{	
		if (!session_start())
		{
			mx_message_die(GENERAL_ERROR, "Failed to start the session", '', __LINE__, __FILE__, $sid);
		}
	}	
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
	$mx_cache_key = '_pagemap_block' . $search_item;

	$page_id_array = array();
	if ( $mx_cache->_exists( $mx_cache_key ) )
	{
		$page_id_array = unserialize( $mx_cache->get( $mx_cache_key ) );
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
		$db->sql_freeresult($p_result);

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
			$p_row = $db->sql_fetchrow($p_result);
			$db->sql_freeresult($p_result);
		}
		
		if( empty($p_row['page_id']) )
		{
			// Find all subblock page_ids
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
			$db->sql_freeresult($p_result);
		}

		if( empty($p_row['page_id']) )
		{
			// Find if block is a default dynamic block (desperate try)
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
			$db->sql_freeresult($p_result);
		}
		
		$page_id_array = array();
		if (!empty($p_row['page_id']))
		{
			$page_id_array['page_id'] = $p_row['page_id'];
			$page_id_array['page_name'] = $p_row['page_name'];
			$page_id_array['page_desc'] = $p_row['page_desc'];
			$page_id_array['block_id'] = isset($p_row['block_id']) ? $p_row['block_id'] : 0;
		}
		unset($p_row);
		$mx_cache->put( $mx_cache_key, serialize($page_id_array) );
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
	$posticons = '';
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
 * Get MX-Publisher modules
 *
 * @return modules array
 */
function obtain_portal_modules()
{
	global $db;

	$modules = array();

	$sql = "SELECT * FROM " . MODULE_TABLE . " ORDER BY module_name";
	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain modules from database", '', __LINE__, __FILE__, $sql);
	}
	while ($row = $db->sql_fetchrow($result))
	{
		$modules[] = $row;
	}
	$db->sql_freeresult($result);
	return $modules;
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

	for( $i = 0; $i < $count = count($module); $i++ )
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
		$block_config_temp[$block_id] = array_merge($block_config_temp[$block_id]['block_info'], (isset($block_config_temp[$block_id]['block_parameters']) ? $block_config_temp[$block_id]['block_parameters'] : array()));
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

/**
* Get backtrace.
*
* Return a nicely formatted backtrace (parts from the php manual by diz at ysagoon dot com)
*
* @return string (html)
*/
function mx_get_backtrace(): string
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
* @param unknown_type $board_config_name
* @param unknown_type $board_config_value
* @param unknown_type $is_dynamic
*/
function mx_set_config($board_config_name, $board_config_value)
{
	global $db, $mx_cache, $portal_config;
		
	//Aternative to $sql = "UPDATE  " . PORTAL_TABLE . " SET " . $db->sql_build_array('UPDATE', utf8_normalize_nfc($portal_config));
	$sql = "UPDATE " . PORTAL_TABLE . "
			SET " . $db->sql_escape($board_config_name) . " = " . $db->sql_escape($board_config_value) . "
			WHERE portal_id = 1";
	$db->sql_query($sql);

	if (!$db->sql_affectedrows() && !isset($portal_config[$board_config_name]))
	{
		$portal_config[$board_config_name] = $board_config_value;
			
		$sql = "INSERT INTO ". PORTAL_TABLE ." (".
					implode(', ', array_keys($portal_config)).
					") VALUES (".
					implode(', ', array_values($portal_config)).
					")";
		$db->sql_query($sql);
	}
	
	$mx_cache->put('mxbb_config', $portal_config);
}

/**
* Checks if a path ($path) is absolute or relative
*
* @param string $path Path to check absoluteness of
* @return boolean
*/
function mx_is_absolute($path)
{
	return (isset($path[0]) && $path[0] == '/' || preg_match('#^[a-z]:[/\\\]#i', $path)) ? true : false;
}

/**
 * Borrowed from phpBB
 *
* @author Chris Smith <chris@project-minerva.org>
* @copyright 2006 Project Minerva Team
* @param string $path The path which we should attempt to resolve.
* @return mixed
*/
function mx_own_realpath($path)
{
	global $request;

	// Now to perform funky shizzle

	// Switch to use UNIX slashes
	$path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
	$path_prefix = '';

	// Determine what sort of path we have
	if (mx_is_absolute($path))
	{
		$absolute = true;

		if ($path[0] == '/')
		{
			// Absolute path, *NIX style
			$path_prefix = '';
		}
		else
		{
			// Absolute path, Windows style
			// Remove the drive letter and colon
			$path_prefix = $path[0] . ':';
			$path = substr($path, 2);
		}
	}
	else
	{
		// Relative Path
		// Prepend the current working directory
		if (function_exists('getcwd'))
		{
			// This is the best method, hopefully it is enabled!
			$path = str_replace(DIRECTORY_SEPARATOR, '/', getcwd()) . '/' . $path;
			$absolute = true;
			if (preg_match('#^[a-z]:#i', $path))
			{
				$path_prefix = $path[0] . ':';
				$path = substr($path, 2);
			}
			else
			{
				$path_prefix = '';
			}
		}
		else if ($request->server('SCRIPT_FILENAME'))
		{
			// Warning: If chdir() has been used this will lie!
			// Warning: This has some problems sometime (CLI can create them easily)
			$filename = htmlspecialchars_decode($request->server('SCRIPT_FILENAME'));
			$path = str_replace(DIRECTORY_SEPARATOR, '/', dirname($filename)) . '/' . $path;
			$absolute = true;
			$path_prefix = '';
		}
		else
		{
			// We have no way of getting the absolute path, just run on using relative ones.
			$absolute = false;
			$path_prefix = '.';
		}
	}

	// Remove any repeated slashes
	$path = preg_replace('#/{2,}#', '/', $path);

	// Remove the slashes from the start and end of the path
	$path = trim($path, '/');

	// Break the string into little bits for us to nibble on
	$bits = explode('/', $path);

	// Remove any . in the path, renumber array for the loop below
	$bits = array_values(array_diff($bits, array('.')));

	// Lets get looping, run over and resolve any .. (up directory)
	for ($i = 0, $max = sizeof($bits); $i < $max; $i++)
	{
		// @todo Optimise
		if ($bits[$i] == '..' )
		{
			if (isset($bits[$i - 1]))
			{
				if ($bits[$i - 1] != '..')
				{
					// We found a .. and we are able to traverse upwards, lets do it!
					unset($bits[$i]);
					unset($bits[$i - 1]);
					$i -= 2;
					$max -= 2;
					$bits = array_values($bits);
				}
			}
			else if ($absolute) // ie. !isset($bits[$i - 1]) && $absolute
			{
				// We have an absolute path trying to descend above the root of the filesystem
				// ... Error!
				return false;
			}
		}
	}

	// Prepend the path prefix
	array_unshift($bits, $path_prefix);

	$resolved = '';

	$max = sizeof($bits) - 1;

	// Check if we are able to resolve symlinks, Windows cannot.
	$symlink_resolve = (function_exists('readlink')) ? true : false;

	foreach ($bits as $i => $bit)
	{
		if (@is_dir("$resolved/$bit") || ($i == $max && @is_file("$resolved/$bit")))
		{
			// Path Exists
			if ($symlink_resolve && is_link("$resolved/$bit") && ($link = readlink("$resolved/$bit")))
			{
				// Resolved a symlink.
				$resolved = $link . (($i == $max) ? '' : '/');
				continue;
			}
		}
		else
		{
			// Something doesn't exist here!
			// This is correct realpath() behaviour but sadly open_basedir and safe_mode make this problematic
			// return false;
		}
		$resolved .= $bit . (($i == $max) ? '' : '/');
	}

	// @todo If the file exists fine and open_basedir only has one path we should be able to prepend it
	// because we must be inside that basedir, the question is where...
	// @internal The slash in is_dir() gets around an open_basedir restriction
	if (!@file_exists($resolved) || (!@is_dir($resolved . '/') && !is_file($resolved)))
	{
		return false;
	}

	// Put the slashes back to the native operating systems slashes
	$resolved = str_replace('/', DIRECTORY_SEPARATOR, $resolved);

	// Check for DIRECTORY_SEPARATOR at the end (and remove it!)
	if (substr($resolved, -1) == DIRECTORY_SEPARATOR)
	{
		return substr($resolved, 0, -1);
	}

	return $resolved; // We got here, in the end!
}

/*
* Is this even used ?
**/
function mx_phpbb_realpath($path)
{	
	return mx_realpath($path);
}

if (!function_exists('realpath'))
{
	/**
	* A wrapper for realpath
	* @ignore
	*/
	function mx_realpath($path)
	{
		return mx_own_realpath($path);
	}
}
else
{
	/**
	* A wrapper for realpath
	*/
	function mx_realpath($path)
	{
		$realpath = realpath($path);
		
		// Strangely there are provider not disabling realpath but returning strange values. :o
		// We at least try to cope with them.
		if ($realpath === $path || $realpath === false)
		{
			return mx_own_realpath($path);
		}
		
		// Check for DIRECTORY_SEPARATOR at the end (and remove it!)
		if (substr($realpath, -1) == DIRECTORY_SEPARATOR)
		{
			$realpath = substr($realpath, 0, -1);
		}
		return $realpath;
	}
}

/**
 * Get langcode.
 *
 * This function loops all meta langcodes, to convert internal MX-Publisher lang to standard langcode
 *
 * Updated by FlorinCB aka orynider in 16.02.2019
 *
 */
function mx_get_langcode()
{
	global $mx_user, $mx_root_path, $portal_config, $board_config, $phpEx;
	
	$default_lang = (isset($mx_user->lang['default_lang'])) ? $mx_user->decode_lang($mx_user->lang['default_lang']) : $portal_config['default_lang'];
	$user_lang = (isset($mx_user->data['user_lang'])) ? $mx_user->decode_lang($mx_user->data['user_lang']) : $default_lang;

	//
	// Load language file.
	//
	if ((@include($mx_root_path . "language/lang_" . $user_lang . "/lang_meta.$phpEx")) === false)
	{
		if ((@include($mx_root_path . "language/" . $default_lang . "/lang_meta.$phpEx")) === false)
		{
			$lang_error = 'Language file ' . $mx_root_path . "language/lang_" . $default_lang . "[or /lang_" . $user_lang . "]/lang_meta.$phpEx" . ' couldn\'t be opened.';
		}
		else
		{
			$lang_error = false;
		}
	}

	foreach ($lang['mx_meta']['langcode'] as $langcode => $mxbbLang)
	{
		if ( strtolower($mxbbLang) == $user_lang )
		{
			return $langcode;
		}
		else
		{
			return $mx_user->encode_lang($user_lang);
		}
	}
}

/**
 * Guess langcode.
 *
 * Guess an initial language ... borrowed from phpBB 2.2 it's not perfect, 
 * really it should do a straight match first pass and then try a "fuzzy"
 * match on a second pass instead of a straight "fuzzy" match.
 *
*/
function mx_guess_lang($encode = false)
{
	global $mx_user, $mx_root_path, $_SERVER;

	// The order here _is_ important, at least for major_minor
	// matches. Don't go moving these around without checking with
	// me first - psoTFX
	$match_lang = array(
		'Afar'							=> 'aa', //Ethiopia
		'Abkhazia'					=> 'ab',
		//'Angola'					=> 'ad'
		'avestan'					=> 'ae', //Persia
		'afrikaans'					=> 'af', // speakers: 6,855,082 - 13,4%
		//'AFGHANISTAN'; // langs: pashto and dari
		'english-creole'				=> 'ag', //Antigua & Barbuda
		'anguilla'						=> 'ai',
		'aromanian'					=> 'aj', //Aromaya
		'akan'								=> 'ak',
		'albanian'						=> 'al', //ALBANIA
		'amharic'						=> 'am', //the country flag with am is Armenia
		'aragonese'					=> 'an', //Andorra, Netherland Antilles
		'angolian'						=> 'ao', //Angola
		'angika'							=> 'ap', //Anga //India
		'arabic'							=> 'ar([_-][a-z]+)?', //country: Argentina
		//'antarctica'					=> 'aq',
		'assamese'					=> 'as', //American Samoa
		'german-austrian'			=> 'at',
		'avaric'							=> 'av',
		'daghestanian'				=> 'av-da', //AVARIAN_KHANATE
		'aymara'							=> 'ay',
		'aruba'							=> 'aw', //Aruba
		'en-au'							=> 'au', //Australia
		'azerbaijani'					=> 'az', //Azerbaijan
		'finnish'							=> 'ax', //The Aland Islands or Aland (Swedish: Aland, IPA: ['o?land]; Finnish: Ahvenanmaa) is an archipelago province at the entrance to the Gulf of Bothnia in the Baltic Sea belonging to Finland.
		'bashkir'							=> 'ba', //Baskortostán (Rusia)
		//Bosnia & Herzegovina, Bosnian, Croatian, Serbian
		'barbados'						=> 'bb',
		'bangladesh'					=> 'bd',
		'belarusian'					=> 'be', //Belgium
		//'burkina-faso'				=> 'bf',
		'bulgarian'						=> 'bg', 
		'bhojpuri'						=> 'bh', // Bihar (India) 
		//'Bahrain'; // Mamlakat al-Ba?rayn (arabic)
		'belarusian'					=> 'by',
		//'Belarus';
		'catalan'							=> 'ca', 
		'czech'							=> 'cs', 
		'danish'							=> 'da', 
		'german'							=> 'de([_-][a-z]+)?',
		'english'							=> 'en([_-][a-z]+)?', 
		'estonian'						=> 'et', 
		'finnish'							=> 'fi', 
		'french'							=> 'fr([_-][a-z]+)?', 
		'greek'							=> 'el', 
		'spanish_argentina'		=> 'es[_-]ar', 
		'spanish'						=> 'es([_-][a-z]+)?', 
		'gaelic'							=> 'gd', 
		'galego'							=> 'gl', 
		'gujarati'							=> 'gu', 
		'hebrew'							=> 'he', 
		'hindi'								=> 'hi', 
		'croatian'						=> 'hr', 
		'hungarian'					=> 'hu', 
		'icelandic'						=> 'is', 
		'indonesian'					=> 'id([_-][a-z]+)?', 
		'italian'							=> 'it([_-][a-z]+)?', 
		'japanese'						=> 'ja([_-][a-z]+)?', 
		'korean'							=> 'ko([_-][a-z]+)?', 
		'latvian'							=> 'lv', 
		'lithuanian'						=> 'lt', 
		'macedonian'				=> 'mk', 
		'dutch'								=> 'nl([_-][a-z]+)?', 
		'norwegian'					=> 'no', 
		'punjabi'							=> 'pa', 
		'polish'							=> 'pl', 
		'portuguese_brazil'		=> 'pt[_-]br', 
		'portuguese'					=> 'pt([_-][a-z]+)?', 
		'romanian'						=> 'ro([_-][a-z]+)?', 
		'russian'							=> 'ru([_-][a-z]+)?', 
		'slovenian'						=> 'sl([_-][a-z]+)?', 
		'albanian'						=> 'sq', 
		'serbian'							=> 'sr([_-][a-z]+)?', 
		'slovak'							=> 'sv([_-][a-z]+)?', 
		'swedish'						=> 'sv([_-][a-z]+)?', 
		'thai'								=> 'th([_-][a-z]+)?', 
		'turkish'							=> 'tr([_-][a-z]+)?', 
		'ukranian'						=> 'uk([_-][a-z]+)?', 
		'urdu'								=> 'ur', 
		'viatnamese'					=> 'vi',
		'chinese_traditional_taiwan'=> 'zh[_-]tw',
		'chinese_simplified'		=> 'zh', 
	);

	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
	{
		$accept_lang_ary = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		for ($i = 0; $i < sizeof($accept_lang_ary); $i++)
		{
			@reset($match_lang);
			while (list($lang, $match) = each($match_lang))
			{
				if (preg_match('#' . $match . '#i', trim($accept_lang_ary[$i])))
				{
					if (file_exists(@realpath($mx_root_path . 'language/lang_' . $lang)))
					{
						return ($encode == false) ? $lang : $mx_user->encode_lang($lang);
					}
				}
			}
		}
	}
	
	$lang_iso = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'en';
	return ($encode == false) ? $mx_user->decode_lang($lang_iso) : $lang_iso;
	
}

function mx_get_db_stat($mode, $db_name = '')
{
	global $db, $dbname, $table_prefix, $mx_table_prefix;
	
	$db_name = !empty($db_name) ? $db_name : $dbname;
	
	switch($mode)
	{
		case 'usercount':
			$sql = "SELECT COUNT(`user_id`) AS total
				FROM `" . $db_name . "`.`" . str_replace($table_prefix, $mx_table_prefix, USERS_TABLE) . "`
				WHERE user_id <> " . ANONYMOUS;
		break;

		case 'newestuser':
			$sql = "SELECT `user_id`, `username`
				FROM `" . $db_name . "`.`" . str_replace($table_prefix, $mx_table_prefix, USERS_TABLE) . "`
				WHERE user_id <> " . ANONYMOUS . "
				ORDER BY user_id DESC
				LIMIT 1";
		break;

		case 'postcount':
		case 'topiccount':
			if ( ($db->sql_table_exists(($db_name . "." . FORUMS_TABLE))) )
			{
				$sql = "SELECT SUM(`forum_topics`) AS topic_total, SUM(`forum_posts`) AS post_total
					FROM `" . $db_name . "`.`" . FORUMS_TABLE . "`";
			}
			else
			{
				$sql = "SELECT pg.page_id AS topic_total, blk.block_id AS post_total 
						FROM `" . $db_name . "`.`" . PAGE_TABLE . "` pg, `" . $db_name . "`.`" . BLOCK_TABLE . "` blk 
						WHERE block_time <> ''";
			}
		break;
	}
	
	if (!($result = $db->sql_query($sql)))
	{
		return false;
	}
	
	$row = $db->sql_fetchrow($result);
	
	switch ($mode)
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
 * update config.php values.
 *
 */
function update_portal_backend($new_backend = PORTAL_BACKEND)
{
	global $mx_root_path, $lang, $phpEx, $portal_config;

	if( @file_exists($mx_root_path . "config.$phpEx") )
	{
		@require($mx_root_path . "config.$phpEx");
	}

	$mx_portal_name = 'MX-Publisher Modular System';
	$dbcharacter_set = "uft8";

	/*
	$board_config = array(
		'dbms'		=> $dbms,
		'dbhost'		=> $dbhost,
		'dbname'		=> $dbname,
		'dbuser'		=> $dbuser,
		'dbpasswd'		=> $dbpasswd,
		'mx_table_prefix' => $mx_table_prefix,
		'portal_backend'	=> (!empty($portal_backend) ? $portal_backend : 'internal'),
	);
	*/

	$new_backend = ($new_backend) ? $new_backend  : 'internal';

	switch ($new_backend)
	{
		case 'internal':
		case 'phpbb3':
		case 'olympus':	
		case 'ascraeus':
		case 'mybb':		
			$dbcharacter_set = defined('DBCHARACTER_SET') ? DBCHARACTER_SET : 'utf8';
		break;
		
		case 'phpbb2':
			$dbcharacter_set = defined('DBCHARACTER_SET') ? DBCHARACTER_SET : 'latin1';
		break;
		
		case 'smf2':
			// Load the settings...  Settings.php (to get SMF settings)
			if ((@include $smf_root_path . "Settings.$phpEx") === true)
			{
				$dbcharacter_set = (isset($db_character_set)) ? $db_character_set : "uft8";
			}			
		break;		
	}

	$process_msgs[] = 'Writing config ...<br />';

	$board_config_data = "<"."?php\n\n";
	$board_config_data .= "// $mx_portal_name auto-generated config file\n// Do not change anything in this file!\n\n";
	$board_config_data .= "// This file must be put into the $mx_portal_name directory, not into the phpBB directory.\n\n";
	$board_config_data .= '$'."dbms = '$dbms';\n\n";
	$board_config_data .= '$'."dbhost = '$dbhost';\n";
	$board_config_data .= '$'."dbname = '$dbname';\n";
	$board_config_data .= '$'."dbuser = '$dbuser';\n";
	$board_config_data .= '$'."dbpasswd = '$dbpasswd';\n\n";
	$board_config_data .= '$'."mx_table_prefix = '$mx_table_prefix';\n\n";
	$board_config_data .= "define('DBCHARACTER_SET', '$dbcharacter_set');\n\n";
	$board_config_data .= "define('MX_INSTALLED', true);\n\n";
	$board_config_data .= '?' . '>';	// Done this to prevent highlighting editors getting confused!

	@umask(0111);
	@chmod($mx_root_path . "config.$phpEx", 0644);

	if ( !($fp = @fopen($mx_root_path . 'config.' . $phpEx, 'w')) )
	{
		$process_msgs[] = "Unable to write config file " . $mx_root_path . "config.$phpEx" . "<br />\n";
	}
	$result = @fputs($fp, $board_config_data, strlen($board_config_data));
	@fclose($fp);

	$process_msgs[] = '<span style="color:pink;">'.str_replace("\n", "<br />\n", htmlspecialchars($board_config_data)).'</span>';

	$message = '<hr />';
	for ($i = 0; $i < count($process_msgs); $i++)
	{
		$message .= $process_msgs[$i] . ( $process_msgs[$i] == '<hr />' ? '' : '<br />' ) . "\n";
	}
	$message .= '<hr />';

	return $message;
}

function mx_clean_string($text)
{
	global $mx_root_path, $phpEx;
	
	//Unicode control characters
	static $homographs = array();
	if (empty($homographs) && ($homographs = @include($mx_root_path . 'includes/utf/data/confusables.' . $phpEx)))
	{
		$text = @utf8_case_fold_nfkc($text);
		$text = strtr($text, $homographs);
	}
	else
	{
		// ASCI control characters
		$text = preg_replace("/[^[:space:]a-zA-Z0-9åäöÅÄÖ.,-:]/", " ", $text);
		$text = preg_replace("/[^[:space:]a-zA-Z0-9îăâşţÎĂÂŞŢ.,-:]/", " ", $text);
		
		// we need to reduce multiple spaces to a single one   
		$text = preg_replace('/\s+/', ' ', $text);
	}

	// Other control characters
	$text = preg_replace('#(?:[\x00-\x1F\x7F]+|(?:\xC2[\x80-\x9F])+)#', '', $text);

	// we need to reduce multiple spaces to a single one
	$text = preg_replace('# {2,}#', ' ', $text);

	// we can use trim here as all the other space characters should have been turned
	// into normal ASCII spaces by now
	return trim($text);
}

/**
 * The magic methods 
 __construct(), 
 __destruct(), 
 __call(), 
 __callStatic(), 
 __get(), 
 __set(), 
 __isset(), 
 __unset(), 
 __sleep(), 
 __wakeup(), 
 __toString(), 
 __invoke(), 
 __set_state(), 
 __clone(),
 and 
 __debugInfo() ; 
 must always be public 
 and can no longer be static. 
 Method signatures are now enforced.
 *
 */
 
/**
 * function mx_t
* replacement for t()
 *
 */
function t($string, array $args = array(), array $options = array()) 
{
	global $lang, $mx_cache, $mx_user, $board_config;
	static $lang_string;
	
	// Merge in default.
	if (empty($options['langcode']))
	{
		$options['langcode'] = isset($lang['USER_LANG']) ? $lang['USER_LANG'] : $mx_user->encode_lang($board_config['default_lang']);
	}
	
	if (!empty($lang[$string]))
	{
		$lang_string = $lang[$string];
	}
	else
	{
		$lang_string = $string;
	}
	
	if (empty($args))
	{
		return $lang_string;
	}
	else
	{
		return $mx_cache->format_string($lang_string, $args);
	}
}

/**
* A wrapper for htmlcheck_plain($value, ENT_COMPAT, 'UTF-8')
* See also
* function utf8_htmlspecialchars($value)
* from
* @package utf
*/
function utf8_htmlcheck_plain($value)
{
	return htmlspecialchars($value, ENT_QUOTE, 'UTF-8');
}

/**
* Trying to display in a placeholder inside a message or text
*
*/
function mx_placeholder($message)
{
	// Adding placeholders to returned text
	return '<em class="placeholder">' . utf8_htmlcheck_plain($text) . '</em>';
}

/**
 * function eregi
 *
 * temp replacement for eregi()
 *
 *
 */
if (!@function_exists('eregi')) 
{     
	function eregi($find, $str) 
	{         
		return stristr($str, $find);     
	} 
}

/**
 * function ereg
 *
 * temp replacement for ereg()
 *
 *
 */
 /*
if(!function_exists('ereg')) 
{     
	function ereg($pattern, $string, &$array)      
	{          
		return preg_match('#'.$pattern.'#', $string, $array);      
	} 
}
*/

/*
* This is a function as explode on arrays of delimitors.
* explode() will now throw ValueError when separator parameter is given an empty string (""). Previously, explode() returned false instead. 
* A ValueError is thrown when the type of an argument is correct but the value of it is incorrect. 
*/        
function explode_on_delims($delims = null, $input = "") 
{
		$query = "";
		if($delims === null || !is_array($delims)) 
		{
			$delims = array("#", $delims);
		}		
		foreach($delims as $delimiter) 
		{
			$query .= preg_quote($delimiter) . "#";
		}
		$query = rtrim($query, "#");
		if($query != "") 
		{
			$query = "(".$query.")";
			//print $query . "\n";
			return preg_split("/(".$query.")/", $input);
			// $output = preg_split("/(@|vs)/", $input);
			// return $output;
		}
		return $input;
}
?>
