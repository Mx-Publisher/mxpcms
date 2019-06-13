<?php
 /**
*
* @package mxBB Portal Module - mx_newsletter
* @version $Id: functions_newsletter.php,v 1.6 2011/04/17 08:37:07 orynider Exp $
* @copyright (c) 2006-2007 [FlorinCB, florin@caleacrestina.com]  mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if(!defined('IN_PORTAL'))
{
	die('Hacking Attempt');
}


function contact_encode_ip($dotquad_ip)
{
	$ip_sep = @explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

function contact_decode_ip($int_ip)
{
	$hexipbang = @explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

//
// Create date/time from format and timezone
//
function contact_create_date($format = false, $gmepoch, $tz, $forcedate = false)
{
	global $board_config, $lang, $mx_user;
	static $translate;
	
	switch (PORTAL_BACKEND)
	{
		case 'internal':
						
		case 'phpbb2':			

			if (empty($translate) && ($mx_user->lang['default_lang'] != 'english'))
			{
				@reset($lang['datetime']);
				while ( list($match, $replace) = @each($lang['datetime']) )
				{
					$translate[$match] = $replace;
				}
			}

			return ( !empty($translate) ) ? strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $translate) : @gmdate($format, $gmepoch + (3600 * $tz));						

		break;

		case 'phpbb3':
		
			return $mx_user->format_date($gmepoch, $format, $forcedate);
			
		break;			
	}	
}

// MX add-on
// Generate paths for page and standalone mode
// ...function based on original function written by Markus :-)
// This has mod_rewrite disabled
if (!function_exists('this_contact_mxurl'))
{
	function this_contact_mxurl($args = '', $force_standalone_mode = false, $new_pageid = '')
	{
		global $mx_root_path, $phpbb_root_path, $module_root_path, $mx_request_vars, $page_id;
		global $phpEx, $integration_enabled, $mx_mod_rewrite;

		if (!$mx_request_vars->is_empty_request('dynamic_block'))
		{
			$dynamic_block = $mx_request_vars->request('dynamic_block', MX_TYPE_INT, '');
		}
		elseif (!$mx_request_vars->is_empty_get('dynamic_block'))
		{
			$dynamic_block = $mx_request_vars->get('dynamic_block', MX_TYPE_INT, 0);
		}
		{
			$dynamic_block = '';
		}
		
		$pageid = ($new_pageid) ? intval($new_pageid) : ($page_id && is_numeric($page_id)) ? intval($page_id) : $mx_request_vars->request('page', MX_TYPE_INT, 25);

		$args .= ($args == '' ? '' : '&' ) . 'modrewrite=no';
		
		$dynamicId = !empty($dynamic_block) ? ( $non_html_amp ? '&dynamic_block=' : '&amp;dynamic_block=' ) . $dynamic_block : '';


		if($force_standalone_mode)
		{
			$mxurl = ( !MXBB_MODULE ) ? $phpbb_root_path . 'album.' . $phpEx . ($args == '' ? '' : '?' . $args) : $mx_root_path . 'modules/mx_contact/' . 'contact.' . $phpEx . ($args == '' ? '' : '?' . $args);
		}
		else
		{
			$mxurl = $mx_root_path . 'index.' . $phpEx;
			if( is_numeric($pageid) && !empty($pageid) )
			{
				$mxurl .= '?page=' . $pageid . $dynamicId. ($args == '' ? '' : '&' . $args);
			}
			else
			{
				$mxurl .= '?page=' . '25' . ($args == '' ? '' : '&' . $args);
			}
		}
		
		return $mxurl;
	}
}

/**
* Generate board url (example: http://www.example.com/mxp3/)
* @param bool $without_script_path if set to true the script path gets not appended (example: http://www.example.com)
*/
function generate_contact_url($without_script_path = false)
{
	global $board_config, $mx_user, $_SERVER;

	$server_name = $mx_user->host;
	$server_port = (!empty($_SERVER['SERVER_PORT'])) ? (int) $_SERVER['SERVER_PORT'] : (int) getenv('SERVER_PORT');

	// Forcing server vars is the only way to specify/override the protocol
	if ($board_config['force_server_vars'] || !$server_name)
	{
		$server_protocol = ($board_config['server_protocol']) ? $board_config['server_protocol'] : (($board_config['cookie_secure']) ? 'https://' : 'http://');
		$server_name = $board_config['server_name'];
		$server_port = (int) $board_config['server_port'];
		$script_path = $board_config['script_path'];

		$url = $server_protocol . $server_name;
	}
	else
	{
		// Do not rely on cookie_secure, users seem to think that it means a secured cookie instead of an encrypted connection
		$cookie_secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1 : 0;
		$url = (($cookie_secure) ? 'https://' : 'http://') . $server_name;

		$script_path = $mx_user->page['root_script_path'];
	}

	if ($server_port && (($board_config['cookie_secure'] && $server_port <> 443) || (!$board_config['cookie_secure'] && $server_port <> 80)))
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

if (!function_exists('htmlspecialchars_decode'))
{
	/**
	* A wrapper for htmlspecialchars_decode
	* @ignore
	*/
	function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT)
	{
		return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
	}
}
?>