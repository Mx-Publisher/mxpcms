<?php
/**
*
* @package page_tail
* @version $Id: page_tail.php,v 1.46 2013/04/10 6:32:38 orynider Exp $
* @copyright (c) 2002-2024 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
* @internal
*
*/

if ( !defined('IN_PORTAL') )
{
	die('Hacking attempt');
}

global $do_gzip_compress;
// In case $phpbb_adm_relative_path is not set (in case of an update), use the default.
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'mybb':
		//To do:
	case 'smf2':
		//To do:
	break;
	
	case 'phpbb2':
		$phpbb_adm_relative_path = 'admin/';
		$phpbb_admin_path = (defined('PHPBB_ADMIN_PATH')) ? PHPBB_ADMIN_PATH : $phpbb_root_path . $phpbb_adm_relative_path;
	break;
	
	default:
		$phpbb_adm_relative_path = 'adm/';
		$phpbb_admin_path = (defined('PHPBB_ADMIN_PATH')) ? PHPBB_ADMIN_PATH : $phpbb_root_path . $phpbb_adm_relative_path;
	break;
}

//
// Generate logged in/logged out status
//
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'mybb':
		//To do: Profile oe UCP Links for each backend.
	case 'smf2':
		
		$u_register = mx_append_sid('login.'.$phpEx.'?mode=register');
		$u_profile = mx_append_sid('profile.'.$phpEx.'?mode=editprofile');
		
		//To do:
		$u_modcp 	=  ((($mx_user->data['user_level'] = 2) && ($mx_user->data['user_active'] = 1)) || ($mx_user->data['user_level'] == ADMIN)) ? mx_append_sid("{$mx_root_path}modcp/index.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '';
		$u_mcp	= ((($mx_user->data['user_level'] = 2) && ($mx_user->data['user_active'] = 1)) || ($mx_user->data['user_level'] == ADMIN)) ? mx_append_sid("{$mx_root_path}modcp/index.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '';
	
		$u_terms_use	= mx_append_sid("login.$phpEx?mode=terms");
		$u_privacy	= mx_append_sid("login.$phpEx?mode=privacy");
	break;

	case 'phpbb2':
	case 'olympus':
		if(!isset($phpbb_auth) || !is_object($phpbb_auth))
		{
			$phpbb_auth = new phpbb_auth();
		}
		$phpbb_auth->acl($mx_user->data);
		//To do: Check this in sessions/phpbb2 comparing to sessions/internal
		$u_login = mx_append_sid("login.".$phpEx);
		// Get referer to redirect user to the appropriate page after delete action
		$redirect_url = mx_append_sid(PORTAL_URL . "index.$phpEx" . (isset($page_id) ? "?page={$page_id}" : "") . (isset($cat_nav) ? "&cat_nav={$cat_nav}" : ""));
		$u_login = mx_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=login');
		if (  $mx_user->data['user_id'] != ANONYMOUS )
		{
			$u_login_logout = mx_append_sid('login.'.$phpEx.'?logout=true&sid=' . $mx_user->data['session_id']);
			$l_login_logout = $lang['Logout'] . ' [ ' . $mx_user->data['username'] . ' ]';
		}
		else
		{
			$u_login_logout = mx_append_sid("login.".$phpEx);
			$l_login_logout = $lang['Login'];
		}
		
		$u_register = (PORTAL_BACKEND !== 'phpbb2') ? mx_append_sid("{$phpbb_root_path}ucp.php?mode=register&redirect=$redirect_url") : mx_append_sid("{$phpbb_root_path}profile.".$phpEx."?mode=register");
		$u_profile = (PORTAL_BACKEND !== 'phpbb2') ? mx_append_sid("{$phpbb_root_path}ucp.php?mode=editprofile") : mx_append_sid("{$phpbb_root_path}profile.".$phpEx."?mode=editprofile");
		
		$u_modcp 	= ((PORTAL_BACKEND !== 'phpbb2') && ($phpbb_auth->acl_get('m_') || $phpbb_auth->acl_getf_global('m_'))) ? mx_append_sid('modcp/index.'.$phpEx) : '';
		$u_mcp	= ((PORTAL_BACKEND !== 'phpbb2') && ($phpbb_auth->acl_get('m_') || $phpbb_auth->acl_getf_global('m_'))) ? mx_append_sid("{$phpbb_root_path}mcp.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : ( ((($mx_user->data['user_level'] = 2) && ($mx_user->data['user_active'] = 1)) || ($mx_user->data['user_level'] == ADMIN)) ? mx_append_sid("{$phpbb_root_path}modcp.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '');
	
		$u_terms_use	= (PORTAL_BACKEND !== 'phpbb2') ? mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=terms") : mx_append_sid("{$phpbb_root_path}profile.$phpEx?mode=terms");
		$u_privacy	= (PORTAL_BACKEND !== 'phpbb2') ? mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=privacy") : mx_append_sid("{$phpbb_root_path}profile.$phpEx?mode=privacy");
	break;

	default:
	
		if(!isset($phpbb_auth) || !is_object($phpbb_auth))
		{
			$phpbb_auth = new phpbb_auth();
		}
		$phpbb_auth->acl($mx_user->data);
		
		// Get referer to redirect user to the appropriate page after delete action
		$redirect_url = mx_append_sid(PORTAL_URL . "index.$phpEx" . (isset($page_id) ? "?page={$page_id}" : "") . (isset($cat_nav) ? "&cat_nav={$cat_nav}" : ""));
		$u_login = mx_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=login');
	
		if ($mx_user->data['user_id'] != ANONYMOUS)
		{
			//$u_login_logout = mx_append_sid("{$phpbb_root_path}ucp.$phpEx", "mode=logout&redirect=$redirect_url", true, $mx_user->session_id);
			$u_login_logout = mx_append_sid('login.'.$phpEx.'?logout=true&sid=' . $mx_user->data['session_id']);
			$l_login_logout = $mx_user->lang['LOGOUT'] . ' [ ' . $mx_user->data['username'] . ' ]';
		}
		else
		{
		
			$u_register = mx_append_sid("{$phpbb_root_path}ucp.php?mode=register&redirect=$redirect_url");
			$u_profile = mx_append_sid("{$phpbb_root_path}ucp.php?mode=editprofile");
		
			$u_login_logout = mx_append_sid("{$phpbb_root_path}ucp.php?mode=login&redirect=$redirect_url");
			$l_login_logout = $mx_user->lang['LOGIN'];
		}
		$u_modcp 	= ($phpbb_auth->acl_get('m_') || $phpbb_auth->acl_getf_global('m_') || ($mx_user->data['session_logged_in'] && $mx_user->data['user_level'] == ADMIN))  ? mx_append_sid("{$mx_root_path}modcp/index.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '';
		$u_mcp	= ($phpbb_auth->acl_get('m_') || $phpbb_auth->acl_getf_global('m_') || ($mx_user->data['session_logged_in'] && $mx_user->data['user_level'] == ADMIN)) ? mx_append_sid("{$phpbb_root_path}mcp.$phpEx?i=main&mode=front&sid=" . $mx_user->session_id) : '';
	
		$u_terms_use	= mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=terms");
		$u_privacy	= mx_append_sid("{$phpbb_root_path}ucp.$phpEx?mode=privacy");
	break;
}
//
// Show the overall footer.
//
$u_acp = PORTAL_URL . 'admin/index.' . $phpEx;
$l_acp = $lang['Admin_panel'];

$template->set_filenames(array(
	'overall_footer' => empty($mx_page->page_ov_footer) || !file_exists($mx_root_path . TEMPLATE_ROOT_PATH . $mx_page->page_ov_footer) ? ( empty($gen_simple_header) ? 'overall_footer.tpl' : 'simple_footer.tpl' ) : $mx_page->page_ov_footer
));

//
// Any blocks to edit?
//
if ($mx_page->editcp_exists)
{
	$template->assign_block_vars('editcp_exists', array(
		'EDITCP_CONTRACT_IMG' 		=> $images['mx_contract'],
		'EDITCP_EXPAND_IMG' 		=> $images['mx_expand'],
		'EDITCP_DYNAMIC_IMG' 		=> $mx_page->editcp_show ? $images['mx_contract'] : $images['mx_expand'],
		'ADMIN_OPTIONS' 			=> $lang['Show_admin_options']
	));
}

if (!isset($phpBB2))
{
	$phpBB2 = new phpBB2();
}

if (!isset($phpbb_auth) && class_exists('phpbb_auth'))
{
	$phpbb_auth = new phpbb_auth();
}

//
// Page last updated (by)
//
if (!empty($mx_page->last_updated))
{
	$editor_name_tmp = mx_get_userdata($mx_page->last_updated_by);
	$editor_name = $editor_name_tmp['username'];
	$edit_time = $phpBB2->create_date( $board_config['default_dateformat'], $mx_page->last_updated, $board_config['board_timezone'] );

	$template->assign_block_vars('page_last_updated', array(
		'L_PAGE_UPDATED'	=> isset($lang['Page_updated_date']) ? $lang['Page_updated_date'] : 'Page Updated',
		'NAME' 		=> $mx_user->data['user_level'] == ADMIN ? $lang['Page_updated_by'] . ' ' . $editor_name : '',
		'TIME' 		=> $edit_time,
	));
}

$mxbb_footer_text = $lang['mx_about_title'];
$mxbb_footer_text_url = PORTAL_URL . 'index.' . $phpEx . '?sid=' . $userdata['session_id'] . '&mx_copy=true';

// Generate debug stats
// - from Olympus
$debug_output = '<div align="center"><span class="copyright">';
if (defined('DEBUG') && $userdata['user_level'] == ADMIN)
{
	$mtime = explode(' ', microtime());
	$totaltime = $mtime[0] + $mtime[1] - $mx_starttime;

	if (!empty($_REQUEST['explain']) && method_exists($db, 'sql_report'))
	{
		$db->sql_report('display');
	}

	$debug_output .= sprintf('Time : %.3fs | ' . @$db->sql_num_queries() . ' Queries | GZIP : ' .  (($board_config['gzip_compress']) ? 'On' : 'Off' ) . ' | Load : '  . (($mx_user->load) ? $mx_user->load : 'N/A'), $totaltime);

	if (defined('DEBUG_EXTRA'))
	{
		if (function_exists('memory_get_usage'))
		{
			if ($memory_usage = memory_get_usage())
			{
				global $base_memory_usage;
				$memory_usage -= $base_memory_usage;
				$memory_usage = ($memory_usage >= 1048576) ? round((round($memory_usage / 1048576 * 100) / 100), 2) . ' ' . 'MB' : (($memory_usage >= 1024) ? round((round($memory_usage / 1024 * 100) / 100), 2) . ' ' . 'kB' : $memory_usage . ' ' . 'bytes');
					$debug_output .= ' | Memory Usage: ' . $memory_usage;
			}
		}
		$debug_output .= ' | <a href="' . (($_SERVER['REQUEST_URI']) ? htmlspecialchars($_SERVER['REQUEST_URI']) : "index.$phpEx$SID") . ((strpos($_SERVER['REQUEST_URI'], '?') !== false) ? '&amp;' : '?') . 'explain=1">Explain</a>';
	}
}
$debug_output .= '</span></div>';
//
// Generate additional footer code (defined by modules)
//
$mx_addional_footer_text = '';
if (isset($mx_page->mxbb_footer_addup) && (count($mx_page->mxbb_footer_addup) > 0))
{
	foreach($mx_page->mxbb_footer_addup as $key => $mx_footer_text)
	{
		$mx_addional_footer_text .= "\n"."\n".$mx_footer_text;
	}
}

if( !is_object($mx_backend))
{
	$mx_backend = new mx_backend();
}

$web_path = (empty($portal_config['portal_url'])) ? PORTAL_URL : $portal_config['portal_url'];
$https_path = str_replace("http://", "https://", $web_path);
$web_path = str_replace("https://", "http://", $web_path);

switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'smf2':
	case 'mybb':
		
		if ( !defined('PHPBB_VERSION') )
		{
			define('PHPBB_VERSION', $board_config['portal_version']);
		}	
	
	break;
	
	case 'phpbb2':
		
		if ( !defined('PHPBB_VERSION') )
		{
			define('PHPBB_VERSION', '2'.$board_config['version']);
		}	
	
	break;
	
	case 'phpbb3':
	case 'olympus':
	case 'ascraeus':
	case 'rhea':
	case 'proteus':
	default:
		if ( !defined('PHPBB_VERSION') )
		{
			define('PHPBB_VERSION', $board_config['version']);
		}
		
	break;
}

$phpbb_version_parts = explode('.', PHPBB_VERSION, 3);
$phpbb_major = $phpbb_version_parts[0] . '.' . $phpbb_version_parts[1];

$mx_backend->page_tail('generate_backend_version');

$template->assign_vars(array(
	'L_AJAX_ERROR_TITLE' 				=> $mx_user->lang['AJAX_ERROR_TITLE'],
	'L_AJAX_ERROR_TEXT_ABORT' 			=> $mx_user->lang['AJAX_ERROR_TEXT_ABORT'],
	'L_AJAX_ERROR_TEXT_TIMEOUT' 		=> $mx_user->lang['AJAX_ERROR_TEXT_TIMEOUT'],
	'L_AJAX_ERROR_TEXT_PARSERERROR' 	=> $mx_user->lang['AJAX_ERROR_TEXT_PARSERERROR'],
	'L_TIMEOUT_PROCESSING_REQ' 			=> $mx_user->lang['TIMEOUT_PROCESSING_REQ'],
	'L_PRIVACY'					=> $mx_user->lang['PRIVACY'],
	'L_PRIVACY_LINK'			=> !empty($mx_user->lang['PRIVACY_LINK']) ? $mx_user->lang['PRIVACY_LINK'] : 'Privacy ',
	'L_TERMS_LINK'				=> isset($mx_user->lang['TERMS_OF_USE_CONTENT']) ? $mx_user->lang['TERMS_OF_USE_CONTENT'] : 'Terms of use ',
	'L_TERMS_USE'				=> $mx_user->lang['TERMS_USE'],
	'L_TEST_CONNECTION'			=> $mx_user->lang['TEST_CONNECTION'],
	'L_THE_TEAM'				=> $mx_user->lang['THE_TEAM'],
	'ROOT_PATH'					=> $web_path,
	'FULL_SITE_PATH'			=> $web_path,	
	
	'U_PORTAL_ROOT_PATH' 		=> PORTAL_URL,
	'U_PHPBB_ROOT_PATH' 		=> PHPBB_URL,
	'TEMPLATE_ROOT_PATH' 		=> TEMPLATE_ROOT_PATH,
	'CMS_PAGE_HOME'				=> PORTAL_URL,
	'BOARD_URL'					=> PORTAL_URL,
	'PHPBB_VERSION'				=> PHPBB_VERSION,
	'PHPBB_MAJOR'				=> $phpbb_major,
	'S_COOKIE_NOTICE'			=> !empty($board_config['cookie_name']),
	
	'T_ASSETS_VERSION'			=> $phpbb_major,
	'T_ASSETS_PATH'				=> "{$web_path}assets",	
	'T_THEME_PATH'				=> "{$web_path}templates/" . rawurlencode($theme['template_name'] ? $theme['template_name'] : str_replace('.css', '', $theme['head_stylesheet'])) . '/theme',
	'T_TEMPLATE_PATH'			=> "{$web_path}templates/" . rawurlencode($theme['template_name']) . '',
	'T_SUPER_TEMPLATE_PATH'		=> "{$web_path}templates/" . rawurlencode($theme['template_name']) . '/template',
		
	'T_IMAGES_PATH'				=> "{$web_path}images/",
	'T_SMILIES_PATH'			=> "{$web_path}{$board_config['smilies_path']}/",
	'T_AVATAR_GALLERY_PATH'		=> "{$web_path}{$board_config['avatar_gallery_path']}/",
	
	'T_ICONS_PATH'				=> !empty($board_config['icons_path']) ? "{$web_path}{$board_config['icons_path']}/" : $web_path.'/images/icons/',
	'T_RANKS_PATH'				=> !empty($board_config['ranks_path']) ? "{$web_path}{$board_config['ranks_path']}/" : $web_path.'/images/ranks/',
	'T_UPLOAD_PATH'				=> !empty($board_config['upload_path']) ? "{$web_path}{$board_config['upload_path']}/" : $web_path.'/cache/',	
	
	'T_STYLESHEET_LINK'				=> "{$web_path}templates/" . rawurlencode($theme['template_name'] ? $theme['template_name'] : str_replace('.css', '', $theme['head_stylesheet'])) . '/theme/stylesheet.css',
	'T_STYLESHEET_LANG_LINK'	=> "{$web_path}templates/" . rawurlencode($theme['template_name'] ? $theme['template_name'] : str_replace('.css', '', $theme['head_stylesheet'])) . '/theme/images/lang_' . $default_lang . '/stylesheet.css',
	'T_FONT_AWESOME_LINK'		=> "{$web_path}assets/css/font-awesome.min.css",
		
	'T_JQUERY_LINK'			=> !empty($board_config['allow_cdn']) && !empty($board_config['load_jquery_url']) ? $board_config['load_jquery_url'] : "{$web_path}assets/javascript/jquery.min.js?assets_version=" . $phpbb_major,
	'S_ALLOW_CDN'				=> !empty($board_config['allow_cdn']),		
	

	'T_THEME_NAME'					=> rawurlencode($theme['template_name']),
	'T_THEME_LANG_NAME'			=> $mx_user->data['user_lang'],
	'T_TEMPLATE_NAME'				=> $theme['template_name'],
	'T_SUPER_TEMPLATE_NAME'	=> rawurlencode($theme['template_name']),	
	
	'MXBB_EXTRA' 				=> $mxbb_footer_text,
	'MXBB_EXTRA_URL' 		=> $mxbb_footer_text_url,
	'SITENAME'					=> $board_config['sitename'],
	'POWERED_BY' 				=> $lang['Powered_by'],
	'MX_VERSION' 				=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? PORTAL_VERSION : '',
	'ADMIN_LINK' 				=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? '<a href="' . $u_acp . '?sid=' . $userdata['session_id'] . '">' . $l_acp . '</a><br />' : '',
	'L_ACP' 						=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? $l_acp : '',
	'U_ACP' 						=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? $u_acp : '',
	'U_CONTACT_US'			=> ($mx_user->data['user_last_privmsg']) ? mx_append_sid("{$phpbb_root_path}memberlist.$phpEx?mode=contactadmin") : '',
	
	'U_TEAM'					=> ($mx_user->data['user_id'] != ANONYMOUS && (PORTAL_BACKEND !== 'internal') && $phpbb_auth->acl_get('u_viewprofile')) ?  mx_append_sid("{$phpbb_root_path}memberlist.$phpEx?mode=team") : '',
	'U_TERMS_USE'			=> $u_terms_use,
	'U_PRIVACY'				=> $u_privacy,
		
	'MX_ADDITIONAL_FOOTER_TEXT' => $mx_addional_footer_text,
	'EXECUTION_STATS'			=> (defined('DEBUG')) ? $debug_output : ''
));

$template->pparse('overall_footer');

//
// Close the mx_page class
//
$mx_page->_core();

//
// Unload cache, must be done before the DB connection is closed
//
if (!empty($mx_cache))
{
	$mx_cache->unload();
}

//
// Close our DB connection.
//
$db->sql_close();

//
// Compress buffered output if required and send to browser
//
if ( $do_gzip_compress )
{
	//
	// Borrowed from php.net!
	//
	$gzip_contents = ob_get_contents();
	ob_end_clean();

	$gzip_size = strlen($gzip_contents);
	$gzip_crc = crc32($gzip_contents);

	$gzip_contents = gzcompress($gzip_contents, 9);
	$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	echo $gzip_contents;
	echo pack('V', $gzip_crc);
	echo pack('V', $gzip_size);
}

exit;
?>
