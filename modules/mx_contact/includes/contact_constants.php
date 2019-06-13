<?php
/**
*
* @package mxBB Portal Module - mx_contact
* @version $Id: contact_constants.php,v 1.6 2011/04/17 08:37:07 orynider Exp $
* @copyright (c) 2003 [orynider@rdslink.ro, OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined('IN_PORTAL') )
{
	die('Hacking attempt');
}

// -------------------------------------------------------------------------
// Extend User Style with module lang and images
// Usage:  $mx_user->extend(LANG, IMAGES)
// Switches:
// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
// -------------------------------------------------------------------------
$mx_user->extend(MX_LANG_MAIN, MX_IMAGES_NONE);

// **********************************************************************
//  Read language definition
// **********************************************************************

if ( !file_exists($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx) )
{
  	include($module_root_path . 'language/lang_english/lang_main.' . $phpEx );
}	
else
{
  	include($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
}

define('CONTACT_TABLE', $mx_table_prefix . 'contact');
define('CONTACT_CONFIG_TABLE', $mx_table_prefix . 'contact_config');
define('CONTACT_MSGS_TABLE', $mx_table_prefix . 'contact_msgs');
define('CONTACT_EMAILS_TABLE', $mx_table_prefix . 'contact_emails');
define('CONTACT_MASS_TABLE', $mx_table_prefix . 'contact_mass_news');

// Email Priority Settings
@define('MAIL_LOW_PRIORITY', 4);
@define('MAIL_NORMAL_PRIORITY', 3);
@define('MAIL_HIGH_PRIORITY', 2);

//
// Pull all config data
//
$sql = "SELECT *
	FROM " . CONTACT_CONFIG_TABLE;

if(!$result = $db->sql_query($sql))
{
	mx_message_die(CRITICAL_ERROR, 'Could not query contact config information', '', __LINE__, __FILE__, $sql);
}
else
{
	while($row = $db->sql_fetchrow($result))
	{
		$contact_config[$row['config_name']] = $row['config_value'];
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];

		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;

		$new[$config_name] = (isset($HTTP_POST_VARS[$config_name])) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if ($mx_request_vars->is_post('submit'))
		{
			$sql = "UPDATE " . CONTACT_CONFIG_TABLE . "
				SET config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";

			if(!$db->sql_query($sql))
			{
				mx_message_die(GENERAL_ERROR, 'Failed to update general configuration for $config_name', '', __LINE__, __FILE__, $sql);
			}
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

	if ($mx_request_vars->is_post('submit'))
	{
		$message = $lang['Contact_updated'] . "<br /><br />" . sprintf($lang['Click_return_contact'], "<a href=\"" . mx_append_sid(this_contact_mxurl()) . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		//mx_message_die(GENERAL_MESSAGE, $message);
	}
}
?>