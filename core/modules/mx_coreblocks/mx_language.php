<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_language.php,v 1.2 2009/01/24 16:47:53 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Updating language and theme - mx_laguage.php and mx_theme.php coreblocks
//
if ($mx_request_vars->is_post('default_lang') && preg_match('#^[a-z_]+$#', $mx_request_vars->post('default_lang', MX_TYPE_NO_TAGS)) && $userdata['user_level'] == ADMIN )
{
	$mx_language = $mx_request_vars->post('default_lang', MX_TYPE_NO_TAGS);
	$board_config['default_lang'] = $mx_language;

	$sql = "UPDATE " . CONFIG_TABLE . " SET
		config_value = '$mx_language'
		WHERE config_name = 'default_lang'";
	if ( !$db->sql_query($sql) )
	{
		mx_message_die(GENERAL_ERROR, "Failed to update default language configuration", '', __LINE__, __FILE__, $sql);
	}
	setcookie('default_lang', $mx_language, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
}

if ($mx_request_vars->is_post('user_lang') && preg_match('#^[a-z_]+$#', $mx_request_vars->post('user_lang', MX_TYPE_NO_TAGS)) && $userdata['session_logged_in'] )
{
	$mx_language = $mx_request_vars->post('user_lang', MX_TYPE_NO_TAGS);
	$userdata['user_lang'] = $mx_language;

	$sql = "UPDATE " . USERS_TABLE . " SET
		user_lang = '$mx_language'
		WHERE user_id = '" . $userdata['user_id'] . "'";
	if ( !$db->sql_query($sql) )
	{
		mx_message_die(GENERAL_ERROR, "Failed to update user lang configuration", '', __LINE__, __FILE__, $sql);
	}
}

$template->set_filenames(array(
	'body_language' => 'mx_language.tpl')
);

if ( $userdata['user_level'] == ADMIN )
{
	$template->assign_block_vars('switch_is_admin', array(
		'L_CHANGE_NOW' => $lang['Change_default_lang'],
		'LANG_SELECT' => mx_language_select($board_config['default_lang'], 'default_lang')
	));
}
if ( $userdata['session_logged_in'] )
{
	$template->assign_block_vars('switch_is_user', array(
		'L_CHANGE_NOW' => $lang['Change_user_lang'],
		'LANG_SELECT' => mx_language_select($userdata['user_lang'], 'user_lang')
	));
}

$template->assign_vars(array(
	'ACTION_URL' => mx_append_sid(PORTAL_URL . "index.$phpEx?page=$page_id"),
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'L_SELECT_LANG' => $lang['Board_lang'],
	'L_CHANGE_NOW' => $lang['Change'],
	'L_TITLE' => $lang['Portal_lang'],
	'L_SUBTITLE' => $lang['Select_lang']
));

//
// Display only when the user is logged in
//
if ( $userdata['session_logged_in'] )
{
	$template->pparse('body_language');
}
else
{
	$mx_block->show_title = false;
	$mx_block->show_block = false;
}
?>