<?php
/**
*
* @package Mx-Publisher Module - mx_phpbb
* @version $Id: admin_forums_ext.php,v 1.2 2010/10/16 04:07:43 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] Mx-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

define( 'IN_PORTAL', 1 );

if ( !empty( $setmodules ) )
{
	$file = basename( __FILE__ );
	$module['phpBB2 plugin']['Management'] = 'modules/mx_phpbb/admin/' . $file;
	return;
}

$mx_root_path = './../../../';
$module_root_path = "./../";
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require( $mx_root_path . '/admin/pagestart.' . $phpEx );

include_once( $mx_root_path . 'admin/page_header_admin.' . $phpEx );
include_once( $module_root_path . 'includes/phpbb_constants.' . $phpEx );

// **********************************************************************
// Read language definition
// **********************************************************************
if ( !file_exists( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx ) )
{
	include( $module_root_path . 'language/lang_english/lang_admin.' . $phpEx );
}
else
{
	include( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx );
}

//
// Mode setting
//
$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS, '');

//
// Main db settings
// Pull all config data
//
$sql = "SELECT *
	 FROM " . PHPBB_CONFIG_TABLE;
if ( !$result = $db->sql_query( $sql ) )
{
	mx_message_die( CRITICAL_ERROR, "Could not query phpbb plugin base configuration information", "", __LINE__, __FILE__, $sql );
}
else
{
	while ( $row = $db->sql_fetchrow( $result ) )
	{
		$phpbb_config_name = $row['config_name'];
		$phpbb_config_value = $row['config_value'];
		$phpbb_default_config[$phpbb_config_name] = $phpbb_config_value;

		$phpbb_new[$phpbb_config_name] = ( isset( $HTTP_POST_VARS[$phpbb_config_name] ) ) ? $HTTP_POST_VARS[$phpbb_config_name] : $phpbb_default_config[$phpbb_config_name];
		if ( isset( $HTTP_POST_VARS['submit'] ) )
		{
			$sql = "UPDATE " . PHPBB_CONFIG_TABLE . " SET
			   		config_value = '" . str_replace( "\'", "''", $phpbb_new[$phpbb_config_name] ) . "'
					WHERE config_name = '$phpbb_config_name'";
			if ( !$db->sql_query( $sql ) )
			{
				mx_message_die( GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql );
			}
		}
	}
	$db->sql_freeresult($result);

	if ( isset( $HTTP_POST_VARS['submit'] ) )
	{
		$message = $lang['phpbb_config_updated'] . "<br /><br />" . sprintf( $lang['Click_return_phpbb_config'], "<a href=\"" . mx_append_sid( "admin_forums_ext.$phpEx" ) . "\">", "</a>" ) . "<br /><br />" . sprintf( $lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid( $mx_root_path . "admin/index.$phpEx?pane=right" ) . "\">", "</a>" );
		mx_message_die( GENERAL_MESSAGE, $message );
	}
}

//
// Populate parameter variables
//
$phpbb_index = $phpbb_new['index'];
$phpbb_viewforum = $phpbb_new['viewforum'];
$phpbb_viewtopic = $phpbb_new['viewtopic'];

$phpbb_faq = $phpbb_new['faq'];
$phpbb_groupcp = $phpbb_new['groupcp'];
$phpbb_login = $phpbb_new['login'];
$phpbb_memberlist = $phpbb_new['memberlist'];
$phpbb_modcp = $phpbb_new['modcp'];
$phpbb_posting = $phpbb_new['posting'];
$phpbb_privmsg = $phpbb_new['privmsg'];
$phpbb_profile = $phpbb_new['profile'];
$phpbb_search = $phpbb_new['search'];
$phpbb_viewonline = $phpbb_new['viewonline'];
$phpbb_other = $phpbb_new['other'];


$phpbb_override_default_pages = $phpbb_new['override_default_pages'];
$phpbb_integration_enabled = $phpbb_new['enable_module'];

//
// Get page_list selects
//
$pagelist_index = get_list_formatted('page_list', $phpbb_new['index'], 'index');
//$pagelist_viewforum = get_list_formatted('page_list', $phpbb_new['viewforum'], 'viewforum');
//$pagelist_viewtopic = get_list_formatted('page_list', $phpbb_new['viewtopic'], 'viewtopic');

$pagelist_faq = get_list_formatted('page_list', $phpbb_new['faq'], 'faq');
$pagelist_groupcp = get_list_formatted('page_list', $phpbb_new['groupcp'], 'groupcp');
$pagelist_login = get_list_formatted('page_list', $phpbb_new['login'], 'login');
$pagelist_memberlist = get_list_formatted('page_list', $phpbb_new['memberlist'], 'memberlist');
//$pagelist_modcp = get_list_formatted('page_list', $phpbb_new['modcp'], 'modcp');
//$pagelist_posting = get_list_formatted('page_list', $phpbb_new['posting'], 'posting');
$pagelist_privmsg = get_list_formatted('page_list', $phpbb_new['privmsg'], 'privmsg');
$pagelist_profile = get_list_formatted('page_list', $phpbb_new['profile'], 'profile');
$pagelist_search = get_list_formatted('page_list', $phpbb_new['search'], 'search');
$pagelist_viewonline = get_list_formatted('page_list', $phpbb_new['viewonline'], 'viewonline');
$pagelist_other = get_list_formatted('page_list', $phpbb_new['other'], 'other');

//
// Start page proper
//
$template->set_filenames( array( "body" => "admin/forum_admin_body_ext.tpl" ));

$template->assign_vars( array(
		'S_FORUM_ACTION' => mx_append_sid( "admin_forums_ext.$phpEx" ),

		'L_FORUM_TITLE' => $lang['mx_forum_admin'],
		'L_FORUM_EXPLAIN' => $lang['mx_forum_admin_explain'],

		'L_SUBMIT' => $lang['submit'],
		'L_RESET' => $lang['reset'],

		'L_DEFAULT_PAGES_TITLE' => $lang['default_pages_title'],
		'L_DEFAULT_PAGES_TITLE_EXPLAIN' => $lang['default_pages_title_explain'],

		'L_DEFAULT_PAGES_MORE_TITLE' => $lang['default_pages_more_title'],
		'L_DEFAULT_PAGES_MORE_TITLE_EXPLAIN' => $lang['default_pages_more_title_explain'],

		//
		// Enable/Disable phpBB integration
		//
		'L_PHPBB_INTEGRATION_ENABLED' => $lang['phpbb_integration_enabled'],
		'L_PHPBB_INTEGRATION_ENABLED_EXPLAIN' => $lang['phpbb_integration_enabled_explain'],

		'L_PHPBB_INTEGRATION_ENABLED_YES' => $lang['phpbb_integration_enabled_yes'],
		'L_PHPBB_INTEGRATION_ENABLED_NO' => $lang['phpbb_integration_enabled_no'],

		'PHPBB_INTEGRATION_ENABLED_YES' => ( $phpbb_integration_enabled == '1' ) ? ' checked="checked"' : '',
		'PHPBB_INTEGRATION_ENABLED_NO' => ( $phpbb_integration_enabled == '0' ) ? ' checked="checked"' : '',

		//
		// Default static settings or block settings
		//
		'L_PHPBB_OVERRIDE_DEFAULT_PAGES' => $lang['phpbb_override'],
		'L_PHPBB_OVERRIDE_DEFAULT_PAGES_EXPLAIN' => $lang['phpbb_override_explain'],

		'L_PHPBB_OVERRIDE_DEFAULT_PAGES_YES' => $lang['phpbb_override_yes'],
		'L_PHPBB_OVERRIDE_DEFAULT_PAGES_NO' => $lang['phpbb_override_no'],

		'OVERRIDE_DEFAULT_PAGES_CHECKBOX_YES' => ( $phpbb_override_default_pages == '1' ) ? ' checked="checked"' : '',
		'OVERRIDE_DEFAULT_PAGES_CHECKBOX_NO' => ( $phpbb_override_default_pages == '0' ) ? ' checked="checked"' : '',

		//
		// ProfileCP compatitility och info
		//
		'L_DEFAULT_PAGES_PROFILECP' => $lang['default_pages_profilecp'],
		'L_PHPBB_EXPLAIN' => $lang['phpbb_explain'],

		'L_PHPBB_FAQ' => $lang['phpbb_faq'],
		'PHPBB_FAQ' => $pagelist_faq,

		'L_PHPBB_GROUPCP' => $lang['phpbb_groupcp'],
		'PHPBB_GROUPCP' => $pagelist_groupcp,

		'L_PHPBB_INDEX' => $lang['phpbb_index'] . ', ' . $lang['phpbb_viewforum'] . ', ' . $lang['phpbb_viewtopic'] . ', ' . $lang['phpbb_posting'] . ', ' . $lang['phpbb_modcp'],
		'PHPBB_INDEX' => $pagelist_index,

		'L_PHPBB_LOGIN' => $lang['phpbb_login'],
		'PHPBB_LOGIN' => $pagelist_login,

		'L_PHPBB_MEMBERLIST' => $lang['phpbb_memberlist'],
		'PHPBB_MEMBERLIST' => $pagelist_memberlist,

		//'L_PHPBB_MODCP' => $lang['phpbb_modcp'],
		//'PHPBB_MODCP' => $pagelist_modcp,

		//'L_PHPBB_POSTING' => $lang['phpbb_posting'],
		//'PHPBB_POSTING' => $pagelist_posting,

		'L_PHPBB_PRIVMSG' => $lang['phpbb_privmsg'],
		'PHPBB_PRIVMSG' => $pagelist_privmsg,

		'L_PHPBB_PROFILE' => $lang['phpbb_profile'],
		'PHPBB_PROFILE' => $pagelist_profile,

		'L_PHPBB_SEARCH' => $lang['phpbb_search'],
		'PHPBB_SEARCH' => $pagelist_search,

		//'L_PHPBB_VIEWFORUM' => $lang['phpbb_viewforum'],
		//'PHPBB_VIEWFORUM' => $pagelist_viewforum,

		'L_PHPBB_VIEWONLINE' => $lang['phpbb_viewonline'],
		'PHPBB_VIEWONLINE' => $pagelist_viewonline,

		'L_PHPBB_OTHER' => $lang['phpbb_other'],
		'PHPBB_OTHER' => $pagelist_other,

		//'L_PHPBB_VIEWTOPIC' => $lang['phpbb_viewtopic'],
		//'PHPBB_VIEWTOPIC' => $pagelist_viewtopic
	));

$template->pparse( "body" );
include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );

?>