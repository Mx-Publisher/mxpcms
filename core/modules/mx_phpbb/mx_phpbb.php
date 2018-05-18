<?php
/**
*
* @package Mx-Publisher Module - mx_phpbb
* @version $Id: mx_phpbb.php,v 1.2 2010/10/16 04:06:36 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] Mx-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

if ( PORTAL_BACKEND != 'phpbb2' )
{
	mx_message_die(GENERAL_MESSAGE, 'There are blocks on this page designed for Mx-Publisher with phpBB2 backend, thus not compatible with current setup.');
}

//
// View Permissions
// Due to BOTs and SPAM, it's preferable to hide some forum pages for anonymous users.
//
// phpBB pages to hide (uncomment to activate):
$private_phpbb_script = array('memberlist', 'privmsg');
//
//

//
// Restore POST vars after redirect
// Will look into this later
//
$HTTP_POST_VARS = $_SESSION['mxbb_post_vars'];
$HTTP_POST_FILES = $_SESSION['mxbb_post_files'];

//
// addslashes to vars if magic_quotes_gpc is off
// this is a security precaution to prevent someone
// trying to break out of a SQL statement.
// If we are on PHP >= 6.0.0 we do not need some code
if (phpversion() >= '6.0.0-dev')
{
	/**
	* @ignore
	*/
}
else if( !get_magic_quotes_gpc() )
{
	if( is_array($HTTP_POST_VARS) )
	{
		while( list($k, $v) = each($HTTP_POST_VARS) )
		{
			if( is_array($HTTP_POST_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_POST_VARS[$k]) )
				{
					$HTTP_POST_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_POST_VARS[$k]);
			}
			else
			{
				$HTTP_POST_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_POST_VARS);
	}
}

$default_lang = ($mx_user->lang['default_lang']) ? $mx_user->lang['default_lang'] : $board_config['default_lang'];

if ( empty($default_lang) )
{
	// - populate $default_lang
	$default_lang= 'english';
}

include_once($mx_root_path . "modules/mx_phpbb/includes/forum_hack.$phpEx");
include_once($mx_root_path . "modules/mx_phpbb/includes/phpbb_constants.$phpEx");

//
// For core 3.0.x+
//
if (file_exists( $mx_root_path . "includes/shared/phpbb2/language/lang_" . $default_lang . "/lang_main.$phpEx"))
{
	@include($mx_root_path . "includes/shared/phpbb2/language/lang_" . $default_lang . "/lang_main.$phpEx");
}
else if (file_exists( $mx_root_path . "includes/shared/phpbb2/language/lang_english/lang_main.$phpEx"))
{
	@include($mx_root_path . "includes/shared/phpbb2/language/lang_english/lang_main.$phpEx");
}
else
{
	// Do nothing, since langs have alrady been loaded ;)
}

//
// Auth
//
if ( isset($private_phpbb_script) )
{
	if ( in_array($mx_forum->phpbb_script, $private_phpbb_script) && !$userdata['session_logged_in'] )
	{
		mx_redirect( mx_append_sid( $mx_root_path . "login.$phpEx?redirect=" . mx_this_url(), true ) );
	}
}

ob_start();
$mx_forum->read_file($mx_forum->phpbb_script);
$phpbb_output = ob_get_contents();
ob_end_clean();

//
// Final template code fixup - these are really phpBB "bugs", hardcoded images etc.
//
$theme['default_template_name'] = !empty($theme['cloned_template_name']) ? $theme['cloned_template_name'] : $mx_user->default_template_name ;

switch ( $mx_forum->phpbb_script )
{
	case 'index':
		$phpbb_output = str_replace('"templates/'.$theme['default_template_name'].'/images/folder_new_big.gif', '"' . PHPBB_URL . 'templates/'.$theme['template_name'].'/images/folder_new_big.gif', $phpbb_output);
		$phpbb_output = str_replace('"templates/'.$theme['default_template_name'].'/images/folder_big.gif', '"' . PHPBB_URL . 'templates/'.$theme['template_name'].'/images/folder_big.gif', $phpbb_output);
		$phpbb_output = str_replace('"templates/'.$theme['default_template_name'].'/images/folder_locked_big.gif', '"' . PHPBB_URL . 'templates/'.$theme['template_name'].'/images/folder_locked_big.gif', $phpbb_output);
		$phpbb_output = str_replace('"templates/'.$theme['default_template_name'].'/images/whosonline.gif', '"' . PHPBB_URL . 'templates/'.$theme['template_name'].'/images/whosonline.gif', $phpbb_output);
		break;

	case 'viewforum':
		break;

	case 'viewtopic':
		$phpbb_output = str_replace('templates/'.$theme['default_template_name'].'/images/vote_lcap.gif', PHPBB_URL . 'templates/'.$theme['template_name'].'/images/vote_lcap.gif', $phpbb_output);
		$phpbb_output = str_replace('templates/'.$theme['default_template_name'].'/images/vote_rcap.gif', PHPBB_URL . 'templates/'.$theme['template_name'].'/images/vote_rcap.gif', $phpbb_output);
		break;

	case 'posting':
		break;

	case 'faq':
		$phpbb_output = str_replace('#top', $phpbb_root_path . 'faq.php#top', $phpbb_output);
		break;
}

$phpbb_output = str_replace('"templates/'.$theme['template_name'], '"' . PHPBB_URL . 'templates/'.$theme['template_name'], $phpbb_output);

//
// Debug output of html, before sending to mxp block
//
//die(str_replace("\n", '<br>', htmlspecialchars($phpbb_output)));

echo($phpbb_output);
unset($phpbb_output);
?>