<?php
/**
*
* @package MX-Publisher Core
* @version $Id: page_header.php,v 1.61 2008/09/07 20:57:33 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
* @internal
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
**********/

//
// If MX-Publisher frame template is not set, instantiate it
//
if ( is_object($layouttemplate) == FALSE )
{
	//
	// Initialize template
	//
	$layouttemplate = new mx_Template( $mx_root_path . 'templates/'. $theme['template_name'], $board_config, $db );
}

//
// If MX-Publisher page is not set, instantiate it
//
if (!isset($mx_page->page_navigation_block))
{
	//
	// Load and instatiate page and block classes
	// - temp fix to instatiate mx_page for the login page
	//
	$mx_page->init( '1' );
}

//
// Parse and show the overall header.
//
$page_ov_header2 = substr_count($mx_page->page_ov_header, 'html') ? str_replace(".html", ".tpl", $mx_page->page_ov_header) : str_replace(".tpl", ".html", $mx_page->page_ov_header);
$layouttemplate->set_filenames(array(
	'overall_header' => empty($mx_page->page_ov_header) || ( !file_exists($mx_root_path . TEMPLATE_ROOT_PATH . $mx_page->page_ov_header) && !file_exists($mx_root_path . TEMPLATE_ROOT_PATH . $page_ov_header2) ) ? ( empty($gen_simple_header) ? 'overall_header.' . $tplEx : 'simple_header.' . $tplEx ) : $mx_page->page_ov_header
));

//
// Generate logged in/logged out status
//
$mx_backend->page_header('generate_login_logout_stats');

//
// Generate HTML required for Mozilla Navigation bar
//
if ( !isset( $nav_links ) )
{
	$nav_links = array();
}

$nav_links_html = '';
$nav_link_proto = '<link rel="%s" href="%s" title="%s" />' . "\n";
while( list($nav_item, $nav_array) = @each($nav_links) )
{
	if ( !empty($nav_array['url']) )
	{
		$nav_links_html .= sprintf($nav_link_proto, $nav_item, mx_append_sid($nav_array['url']), $nav_array['title']);
	}
	else
	{
		// We have a nested array, used for items like <link rel='chapter'> that can occur more than once.
		while( list(,$nested_array) = each($nav_array) )
		{
			$nav_links_html .= sprintf($nav_link_proto, $nav_item, $nested_array['url'], $nested_array['title']);
		}
	}
}

//
// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
//
$l_timezone = explode( '.', $board_config['board_timezone'] );
$l_timezone = ( count( $l_timezone ) > 1 && $l_timezone[count( $l_timezone )-1] != 0 ) ? $lang[sprintf( '%.1f', $board_config['board_timezone'] )] : $lang[number_format( $board_config['board_timezone'] )];

if (empty($mx_page->page_alt_icon))
{
	$page_icon_img = ( !empty($mx_page->page_icon) && $mx_page->page_icon != 'none' && file_exists($mx_root_path . $images['mx_graphics']['page_icons'] . '/' . $mx_page->page_icon) ) ? '<img valign="middle" src="' . PORTAL_URL . $images['mx_graphics']['page_icons'] . '/' . $mx_page->page_icon . '" alt="" />&nbsp;&nbsp;' : '';
}
else
{
	$page_icon_img = '<img valign="middle" src="' . $mx_page->page_alt_icon . '" alt="" />&nbsp;&nbsp;';
}

//
// Search box
//
$search_page_id_pafiledb = get_page_id('dload.' . $phpEx, true);
$search_page_id_kb = get_page_id('kb.' . $phpEx, true);
$search_page_id_site = get_page_id('mx_search.' . $phpEx, true);

$option_search_site = !empty($search_page_id_site) ? '<option value="site">' . $lang['Mx_search_site'] . '</option>' : '';
$option_search_forum = '<option value="forum">' . $lang['Mx_search_forum'] . '</option>';
$option_search_kb = !empty($search_page_id_kb) ? '<option value="kb">' . $lang['Mx_search_kb'] . '</option>' : '';
$option_search_pafiledb = !empty($search_page_id_pafiledb) ? '<option value="pafiledb">' . $lang['Mx_search_pafiledb'] . '</option>' : '';
$option_search_google = '<option value="google">' . $lang['Mx_search_google'] . '</option>';

//
// Generate list of additional css files to include (defined by modules)
//
$mx_addional_css_files = '';
if ( count($mx_page->mxbb_css_addup) > 0 )
{
	foreach($mx_page->mxbb_css_addup as $key => $mx_css_path)
	{
		$mx_addional_css_files .= "\n".'<link rel="stylesheet" href="'. PORTAL_URL . $mx_css_path . '" type="text/css" >';
	}
}

//
// Generate list of additional js files to include (defined by modules)
//
$mx_addional_js_files = '';
if ( count($mx_page->mxbb_js_addup) > 0 )
{
	foreach($mx_page->mxbb_js_addup as $key => $mx_js_path)
	{
		$mx_addional_js_files .= "\n".'<script language="javascript" type="text/javascript" src="'. PORTAL_URL . $mx_js_path . '"></script>';
	}
}

//
// Generate additional header code (defined by modules)
//
$mx_addional_header_text = '';
if ( count($mx_page->mxbb_header_addup) > 0 )
{
	foreach($mx_page->mxbb_header_addup as $key => $mx_header_text)
	{
		$mx_addional_header_text .= "\n"."\n".$mx_header_text;
	}
}

$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

$layouttemplate->assign_vars(array(
	'SITENAME' => $board_config['sitename'],
	'SITE_DESCRIPTION' => $board_config['site_desc'],
	'PAGE_TITLE' => $mx_page->page_title,
	'CURRENT_TIME' => sprintf($lang['Current_time'], phpBB2::create_date($board_config['default_dateformat'], time(), $board_config['board_timezone'])),
	'RECORD_USERS' => sprintf($lang['Record_online_users'], $board_config['record_online_users'], phpBB2::create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),

	'L_USERNAME' => $lang['Username'],
	'L_PASSWORD' => $lang['Password'],
	'L_LOGIN' => $lang['Login'],
	'L_LOG_ME_IN' => $lang['Log_me_in'],
	'L_AUTO_LOGIN' => $lang['Log_me_in'],
	'L_INDEX' => $board_config['sitename'],
	'L_REGISTER' => $lang['Register'],
	'L_PROFILE' => $lang['Profile'],
	'L_SEARCH' => $lang['Search'],
	'L_WHO_IS_ONLINE' => $lang['Who_is_Online'],
	'L_MEMBERLIST' => $lang['Memberlist'],
	'L_FAQ' => $lang['FAQ'],
	'L_USERGROUPS' => $lang['Usergroups'],
	'L_SEARCH_NEW' => $lang['Search_new'],
	'L_SEARCH_UNANSWERED' => $lang['Search_unanswered'],
	'L_SEARCH_SELF' => $lang['Search_your_posts'],
	'L_WHOSONLINE_ADMIN' => sprintf($lang['Admin_online_color'], '<span style="color:#' . $theme['fontcolor3'] . '">', '</span>'),
	'L_WHOSONLINE_MOD' => sprintf($lang['Mod_online_color'], '<span style="color:#' . $theme['fontcolor2'] . '">', '</span>'),
	'L_BACK_TO_TOP' => $lang['Back_to_top'],

	'U_SEARCH_UNANSWERED' => mx_append_sid(PHPBB_URL . 'search.'.$phpEx.'?search_id=unanswered'),
	'U_SEARCH_SELF' => mx_append_sid(PHPBB_URL .'search.'.$phpEx.'?search_id=egosearch'),
	'U_SEARCH_NEW' => mx_append_sid(PHPBB_URL .'search.'.$phpEx.'?search_id=newposts'),

	'LOGO' => $images['mx_logo'],
	'THEME_GRAPHICS' => $images['theme_graphics'],

	'NAV_IMAGES_HOME' => $images['mx_nav_home'],
	'NAV_IMAGES_FORUM' => $images['mx_nav_forum'],
	'NAV_IMAGES_PROFILE' => $images['mx_nav_profile'],
	'NAV_IMAGES_FAQ' => $images['mx_nav_faq'],
	'NAV_IMAGES_SEARCH' => $images['mx_nav_search'],
	'NAV_IMAGES_MEMBERS' => $images['mx_nav_members'],
	'NAV_IMAGES_GROUPS' => $images['mx_nav_groups'],
	'NAV_IMAGES_PRIVMSG' => $images['mx_nav_mail'],
	'NAV_IMAGES_LOGIN_LOGOUT' => $images['mx_nav_login'],
	'NAV_IMAGES_REGISTER' => $images['mx_nav_register'],

	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => (UTF_STATUS === 'phpbb3') ? 'UTF-8' : $lang['ENCODING'],
	'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
	'S_USER_LANG' => (PORTAL_BACKEND === 'phpbb3') ? $lang['USER_LANG'] : $mx_user->encode_lang($board_config['default_lang']),
	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
	'S_LOGIN_ACTION' => mx_append_sid(PORTAL_URL . 'login.'.$phpEx),

	//
	// These theme variables are not used for MX-Publisher, since MX-Publisher require a theme.css file
	//
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

	//+ MX-Publisher
	'U_PORTAL_ROOT_PATH' => PORTAL_URL,
	'U_PHPBB_ROOT_PATH' => PHPBB_URL,
	'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,

	'L_HOME' => $lang['MX_home'],
	'L_FORUM' => $lang['MX_forum'],

	'U_INDEX_FORUM' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=2'),
	'U_INDEX' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx),
	'U_SEARCH_SITE' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=' . $search_page_id_site . '&mode=results&search_terms=all'),
	'U_SEARCH_KB' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=' . $search_page_id_kb . '&mode=search&search_terms=all'),
	'U_SEARCH_PAFILEDB' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=' . $search_page_id_pafiledb . '&action=search&search_terms=all'),

	'PAGE_ICON' => $page_icon_img,
	'L_SEARCH_SITE' => $option_search_site,
	'L_SEARCH_FORUM' => $option_search_forum,
	'L_SEARCH_KB' => $option_search_kb,
	'L_SEARCH_PAFILEDB' => $option_search_pafiledb,
	'L_SEARCH_GOOGLE' => $option_search_google,

	'T_PHPBB_STYLESHEET' => $theme['head_stylesheet'],
	'T_STYLESHEET_LINK'		=> (!$mx_user->theme['theme_storedb']) ? "{$phpbb_root_path}styles/" . $mx_user->theme['theme_path'] . '/theme/stylesheet.css' : "{$phpbb_root_path}style.$phpEx?sid=$mx_user->session_id&amp;id=" . $mx_user->theme['style_id'] . '&amp;lang=' . $mx_user->encode_lang($board_config['default_lang']),	
	'T_MXBB_STYLESHEET' => $theme['head_stylesheet'],
	'T_GECKO_STYLESHEET' => 'gecko.css',

	'MX_ADDITIONAL_CSS_FILES' => $mx_addional_css_files,
	'MX_ADDITIONAL_JS_FILES' => $mx_addional_js_files,
	'MX_ADDITIONAL_HEADER_TEXT' => $mx_addional_header_text,
	'MX_ICON_CSS' => $images['mx_graphics']['icon_style'],
	//- MX-Publisher

	'NAV_LINKS' => $nav_links_html,

	// swithes for logged in users?
	'USER_LOGGED_IN' => $userdata['session_logged_in'],
	'USER_LOGGED_OUT' => !$userdata['session_logged_in'],
	'IS_ADMIN' => $userdata['session_logged_in'] && $userdata['user_level'] == ADMIN,

	// Do NOT set basedir when in EDIT mode
	'SET_BASE' => !$mx_request_vars->is_request('portalpage'),
	
	//Enable CSS Files to be loaded direct from phpBB?
	'PHPBB' => !(PORTAL_BACKEND === 'internal'),

	// Additional css for gecko browsers
	'GECKO' => strstr($useragent, 'Gecko'),

));

//
// Definitions of main navigation links
//
$mx_backend->page_header('generate_nav_links');

//
// Navigation Menu in overall_header
//
if ($mx_page->auth_view || $mx_page->auth_mod)
{
	if (!is_object($mx_block))
	{
		$mx_block = new mx_block();
	}

	$block_id = $mx_page->page_navigation_block;

	if(!empty($block_id) )
	{
		define('MX_OVERALL_NAVIGATION', true);

		$mx_block->init( $block_id );

		//
		// Define $module_root_path, to be used within blocks
		//
		$mx_module_path = $module_root_path;
		$module_root_path = $mx_root_path . $mx_block->module_root_path;

		$template = new mx_Template($mx_root_path . 'templates/'. $theme['template_name']);

		//
		// Include block file and cache output
		//
		ob_start();
		include($module_root_path . $mx_block->block_file);
		$overall_navigation_menu = ob_get_contents();
		ob_end_clean();

		//
		// Output Block contents
		//
		$layouttemplate->assign_vars(array(
			'OVERALL_NAVIGATION' => $overall_navigation_menu)
		);

		if ( ( ( $mx_block->auth_view && $mx_block->auth_edit && $mx_block->show_block ) || $mx_block->auth_mod ) )
		{
			$mx_block->output_cp_button(true);
		}
		$module_root_path = $mx_module_path;
	}
}

// Add no-cache control for cookies if they are set
//$c_no_cache = (isset($_COOKIE[$board_config['cookie_name'] . '_sid']) || isset($_COOKIE[$board_config['cookie_name'] . '_data'])) ? 'no-cache="set-cookie", ' : '';

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

$icongif = 'favicon.gif';

include($mx_root_path . 'mx_meta.inc');
$meta_str  = '<meta name="title"       content="' . $title     .'" />' . "\n";
$meta_str .= '<meta name="author"      content="' . $author    .'" />' . "\n";
$meta_str .= '<meta name="copyright"   content="' . $copyright .'" />' . "\n";
$meta_str .= '<meta name="keywords"    content="' . $keywords  .'" />' . "\n";
$meta_str .= '<meta name="description" lang="' . $langcode .'" content="'. $description .'" />' . "\n";
$meta_str .= '<link rel="shortcut icon" href="' . $icon .'" />' . "\n";

if (file_exists($mx_root_path . $icongif))
{
	$meta_str .= '<link rel="icon" href="' . $icongif .'" type="image/gif" />' . "\n";
}

$meta_str .= '<meta name="category"    content="' . $rating .'" />' . "\n";
$meta_str .= '<meta name="robots"      content="' . $index  . ',' . $follow .'" />' . "\n";
$meta_str .= $header . "\n";

$layouttemplate->assign_vars(array( 'META' => $meta_str) );
$layouttemplate->pparse('overall_header');
?>