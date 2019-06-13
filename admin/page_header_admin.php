<?php
/**
*
* @package MX-Publisher Core
* @version $Id: page_header_admin.php,v 1.36 2014/05/09 07:58:36 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

define('HEADER_INC', true);

/**********
NOTE:

The following code related to GZIP initialization has been moved to
the new mx_session_start() function, declared in mx_functions.php

//
// gzip_compression
//
$do_gzip_compress = FALSE;
if ( $board_config['gzip_compress'] )
{
	$phpver = phpversion();

	$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

	if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
	{
		if ( extension_loaded('zlib') )
		{
			@ob_end_clean();
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
**********/

// Instantiate Dummy phpBB Classes
if( class_exists('phpBB2'))
{
	$phpBB2 = new phpBB2();
}

$default_lang = ($mx_user->data['user_lang']) ? $mx_user->data['user_lang'] : $board_config['default_lang'];
$server_name = !empty($board_config['server_name']) ? preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['server_name'])) : 'localhost';
$server_protocol = ($board_config['cookie_secure'] ) ? 'https://' : 'http://';
$server_port = (($board_config['server_port']) && ($board_config['server_port'] <> 80)) ? ':' . trim($board_config['server_port']) . '/' : '/';
$script_name_phpbb = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])) . '/';		
$server_url = $server_protocol . str_replace("//", "/", $server_name . $server_port . $server_name . '/'); //On some server the slash is not added and this trick will fix it	
$corrected_url = PORTAL_URL;
$board_url = PORTAL_URL;
$web_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? $board_url : $corrected_url;

// Send a proper content-language to the output
$user_lang = !empty($mx_user->lang['USER_LANG']) ? $mx_user->lang['USER_LANG'] : $mx_user->encode_lang($user->lang_name);

if (!defined('TEMPLATE_ROOT_PATH'))
{
	define('TEMPLATE_ROOT_PATH', $phpbb_root_path.'templates/'.$theme['template_name'].'/');
}

if ( !isset($lang) )
{
	$lang = array();
}
$template->set_filenames(array('header' => 'admin/page_header.tpl'));

// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
$l_timezone = explode('.', $board_config['board_timezone']);
$l_timezone = (count($l_timezone) > 1 && isset($l_timezone[count($l_timezone)-1])) ? $lang[sprintf('%.1f', $board_config['board_timezone'])] : $lang[number_format($mx_user->timezone)];

$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');
$template_config_row = $mx_user->_load_template_config();
$template->assign_vars(array(
	'SITENAME' => $board_config['sitename'],
	'SITE_DESCRIPTION' => $board_config['site_desc'],
	'PAGE_TITLE' => isset($page_title) ? $page_title : $lang['Admin'],

	'L_ADMIN' => $lang['Admin'],
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'L_FAQ' => $lang['FAQ'],
	'U_INDEX' => mx_append_sid('../index.'.$phpEx),

	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
	'S_LOGIN_ACTION' => mx_append_sid('../login.'.$phpEx),
	'S_JUMPBOX_ACTION' => mx_append_sid('../viewforum.'.$phpEx),
	'S_CURRENT_TIME' => sprintf($lang['Current_time'], $phpBB2->create_date($board_config['default_dateformat'], time(), $board_config['board_timezone'])),
	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
	'S_USER_LANG' => $mx_user->lang['default_lang'],

	// These theme variables are not used for MX-Publisher, since MX-Publisher require a theme.css file
	'T_HEAD_STYLESHEET' => isset($mx_user->theme['head_stylesheet']) ? $mx_user->theme['head_stylesheet'] : 'stylesheet.css',
	//'T_BODY_BACKGROUND' => $mx_user->theme['body_background'],
	'T_BODY_BGCOLOR' => '#'.$mx_user->theme['body_bgcolor'],
	'T_BODY_TEXT' => '#'.$mx_user->theme['body_text'],
	'T_BODY_LINK' => '#'.$mx_user->theme['body_link'],
	'T_BODY_VLINK' => '#'.$mx_user->theme['body_vlink'],
	'T_BODY_ALINK' => '#'.$mx_user->theme['body_alink'],
	'T_BODY_HLINK' => '#'.$mx_user->theme['body_hlink'],
	'T_TR_COLOR1' => '#'.$mx_user->theme['tr_color1'],
	'T_TR_COLOR2' => '#'.$mx_user->theme['tr_color2'],
	'T_TR_COLOR3' => '#'.$mx_user->theme['tr_color3'],
	//'T_TR_CLASS1' => $mx_user->theme['tr_class1'],
	//'T_TR_CLASS2' => $mx_user->theme['tr_class2'],
	//'T_TR_CLASS3' => $mx_user->theme['tr_class3'],
	'T_TH_COLOR1' => '#'.$mx_user->theme['th_color1'],
	'T_TH_COLOR2' => '#'.$mx_user->theme['th_color2'],
	'T_TH_COLOR3' => '#'.$mx_user->theme['th_color3'],
	//'T_TH_CLASS1' => $mx_user->theme['th_class1'],
	//'T_TH_CLASS2' => $mx_user->theme['th_class2'],
	//'T_TH_CLASS3' => $mx_user->theme['th_class3'],
	'T_TD_COLOR1' => '#'.$mx_user->theme['td_color1'],
	'T_TD_COLOR2' => '#'.$mx_user->theme['td_color2'],
	//'T_TD_COLOR3' => '#'.$mx_user->theme['td_color3'],
	//'T_TD_CLASS1' => $mx_user->theme['td_class1'],
	//'T_TD_CLASS2' => $mx_user->theme['td_class2'],
	//'T_TD_CLASS3' => $mx_user->theme['td_class3'],
	//'T_FONTFACE1' => $mx_user->theme['fontface1'],
	//'T_FONTFACE2' => $mx_user->theme['fontface2'],
	//'T_FONTFACE3' => $mx_user->theme['fontface3'],
	//'T_FONTSIZE1' => $mx_user->theme['fontsize1'],
	//'T_FONTSIZE2' => $mx_user->theme['fontsize2'],
	//'T_FONTSIZE3' => $mx_user->theme['fontsize3'],
	'T_FONTCOLOR1' => '#'.$mx_user->theme['fontcolor1'],
	'T_FONTCOLOR2' => '#'.$mx_user->theme['fontcolor2'],
	//'T_FONTCOLOR3' => '#'.$mx_user->theme['fontcolor3'],
	//'T_SPAN_CLASS1' => $mx_user->theme['span_class1'],
	//'T_SPAN_CLASS2' => $mx_user->theme['span_class2'],
	//'T_SPAN_CLASS3' => $mx_user->theme['span_class3'],

	//+ MX-Publisher
	'T_STYLESHEET_LINK'		=> "{$web_path}templates/" . rawurlencode($mx_user->theme['template_name'] ? $mx_user->theme['template_name'] : str_replace('.css', '', $mx_user->theme['head_stylesheet'])) . '/theme/stylesheet.css',
	'T_STYLESHEET_LANG_LINK'=> "{$web_path}templates/" . rawurlencode($mx_user->theme['template_name'] ? $mx_user->theme['template_name'] : str_replace('.css', '', $mx_user->theme['head_stylesheet'])) . '/theme/images/lang_' . $default_lang . '/stylesheet.css',
	'T_FONT_AWESOME_LINK'	=> "{$web_path}assets/css/font-awesome.min.css",
	'T_FONT_IONIC_LINK'			=> "{$web_path}assets/css/ionicons.min.css",
	'T_JQUERY_LINK'			=> "{$web_path}assets/javascript/jquery.min.js?assets_version=2.0.24",
	'S_ALLOW_CDN'			=> true,	

	'T_THEME_NAME'				=> rawurlencode($theme['template_name']),
	'T_THEME_LANG_NAME'		=> $mx_user->data['user_lang'],
	'T_TEMPLATE_NAME'			=> $mx_user->theme['template_name'],
	'T_SUPER_TEMPLATE_NAME'	=> rawurlencode($mx_user->theme['template_name']),
	'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,
	'U_PHPBB_ROOT_PATH' => PHPBB_URL,

	'L_MX_ADMIN' => $lang['Mx-Publisher_adminCP'],
	'U_PHPBB_ROOT_PATH' => PHPBB_URL,
	'U_PORTAL_ROOT_PATH' => PORTAL_URL,
	'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,

	'T_PHPBB_STYLESHEET' => isset($mx_user->theme['head_stylesheet']) ? $mx_user->theme['head_stylesheet'] : 'stylesheet.css',
	'T_MXBB_STYLESHEET' => isset($mx_user->theme['head_stylesheet']) ? $mx_user->theme['head_stylesheet'] : $mx_user->template_name.'.css',
	'T_GECKO_STYLESHEET' => 'gecko.css',

	'MX_ICON_CSS' => $images['mx_graphics']['icon_style'],
	'LOGO' => $images['mx_logo'],
	//- MX-Publisher

	// Backend
	'PHPBB' => !(PORTAL_BACKEND === 'internal'),
	// Additional css for gecko browsers
	'GECKO' => strstr($useragent, 'Gecko'),
));

// Work around for "current" Apache 2 + PHP module which seems to not
// cope with private cache control setting
if (!empty($_SERVER['SERVER_SOFTWARE']) && strstr($_SERVER['SERVER_SOFTWARE'], 'Apache/2'))
{
	header ('Cache-Control: no-cache, pre-check=0, post-check=0');
}
else
{
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
header ('Expires: 0');
header ('Pragma: no-cache');

$template->pparse('header');
?>