<?php
/**
*
* @package MX-Publisher Core
* @version $Id: page_header_admin.php,v 1.27 2008/09/08 01:32:53 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
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

$template->set_filenames(array( 'header' => 'admin/page_header.tpl') );

//
// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
//
$l_timezone = explode('.', $board_config['board_timezone']);
$l_timezone = (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0) ? $lang[sprintf('%.1f', $board_config['board_timezone'])] : $lang[number_format($board_config['board_timezone'])];

$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

$template->assign_vars(array(
	'SITENAME' => $board_config['sitename'],
	//	'PAGE_TITLE' => $page_title,

	'L_ADMIN' => $lang['Admin'],
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'L_FAQ' => $lang['FAQ'],
	'U_INDEX' => mx_append_sid('../index.'.$phpEx),

	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
	'S_LOGIN_ACTION' => mx_append_sid('../login.'.$phpEx),
	'S_JUMPBOX_ACTION' => mx_append_sid('../viewforum.'.$phpEx),
	'S_CURRENT_TIME' => sprintf($lang['Current_time'], phpBB2::create_date($board_config['default_dateformat'], time(), $board_config['board_timezone'])),
	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
	'S_USER_LANG' => $mx_user->lang['default_lang'],
	//
	// These theme variables are not used for MX-Publisher, since MX-Publisher require a theme.css file
	//
	/*
	'T_HEAD_STYLESHEET' => $theme['head_stylesheet'],
	'T_BODY_BACKGROUND' => $theme['body_background'],
	'T_BODY_BGCOLOR' => '#'.$theme['body_bgcolor'],
	'T_BODY_TEXT' => '#'.$theme['body_text'],
	'T_BODY_LINK' => '#'.$theme['body_link'],
	'T_BODY_VLINK' => '#'.$theme['body_vlink'],
	'T_BODY_ALINK' => '#'.$theme['body_alink'],
	'T_BODY_HLINK' => '#'.$theme['body_hlink'],
	'T_TR_COLOR1' => '#'.$theme['tr_color1'],
	'T_TR_COLOR2' => '#'.$theme['tr_color2'],
	'T_TR_COLOR3' => '#'.$theme['tr_color3'],
	'T_TR_CLASS1' => $theme['tr_class1'],
	'T_TR_CLASS2' => $theme['tr_class2'],
	'T_TR_CLASS3' => $theme['tr_class3'],
	'T_TH_COLOR1' => '#'.$theme['th_color1'],
	'T_TH_COLOR2' => '#'.$theme['th_color2'],
	'T_TH_COLOR3' => '#'.$theme['th_color3'],
	'T_TH_CLASS1' => $theme['th_class1'],
	'T_TH_CLASS2' => $theme['th_class2'],
	'T_TH_CLASS3' => $theme['th_class3'],
	'T_TD_COLOR1' => '#'.$theme['td_color1'],
	'T_TD_COLOR2' => '#'.$theme['td_color2'],
	'T_TD_COLOR3' => '#'.$theme['td_color3'],
	'T_TD_CLASS1' => $theme['td_class1'],
	'T_TD_CLASS2' => $theme['td_class2'],
	'T_TD_CLASS3' => $theme['td_class3'],
	'T_FONTFACE1' => $theme['fontface1'],
	'T_FONTFACE2' => $theme['fontface2'],
	'T_FONTFACE3' => $theme['fontface3'],
	'T_FONTSIZE1' => $theme['fontsize1'],
	'T_FONTSIZE2' => $theme['fontsize2'],
	'T_FONTSIZE3' => $theme['fontsize3'],
	'T_FONTCOLOR1' => '#'.$theme['fontcolor1'],
	'T_FONTCOLOR2' => '#'.$theme['fontcolor2'],
	'T_FONTCOLOR3' => '#'.$theme['fontcolor3'],
	'T_SPAN_CLASS1' => $theme['span_class1'],
	'T_SPAN_CLASS2' => $theme['span_class2'],
	'T_SPAN_CLASS3' => $theme['span_class3'],
	*/

	//+ MX-Publisher
	'L_MX_ADMIN' => $lang['mxBB_adminCP'],
	'U_PHPBB_ROOT_PATH' => PHPBB_URL,
	'U_PORTAL_ROOT_PATH' => PORTAL_URL,
	'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,

	'T_PHPBB_STYLESHEET' => $theme['head_stylesheet'],
	'T_MXBB_STYLESHEET' => $theme['head_stylesheet'],
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