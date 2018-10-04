<?php
/*
	COPYRIGHT 2012 Damien Keitel
		
	This file is part of Facebook For PhpBB Light.

    Facebook For PhpBB Light is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Facebook For PhpBB Light is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Facebook For PhpBB Light.  If not, see <http://www.gnu.org/licenses/>.*/

/**
* DO NOT CHANGE
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

class ucp_fb4phpbb_light
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template, $phpbb_root_path, $phpEx;
		
		// Include the fb4phpbb functions.
		
		// Include the fb4phpbb language files.
		$user->add_lang('mods/info_ucp_fb4phpbb_light');
		$user->add_lang('mods/fb4phpbb_light');
		$user->add_lang('ucp');
		
		$sql = 'SELECT user_fb4phpbb_light_fb_uid
		FROM ' . USERS_TABLE
		. " WHERE user_id = '{$user->data['user_id']}'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);		
		
		$template->assign_vars(array(		
			'S_MODE_FB4PHPBB_LIGHT'				=> ($mode == 'fb4phpbb_light') ? true : false,
			'S_FB4PHPBB_LIGHT_ROW' 				=> ($row['user_fb4phpbb_light_fb_uid'] > 0) ? true : false,
			'S_UCP_FB4PHPBB_LIGHT_DESCRIPTION'	=> ($row['user_fb4phpbb_light_fb_uid'] > 0) ? sprintf($user->lang['UCP_FB4PHPBB_LIGHT_ENABLE_FACEBOOK_TEXT'], $user->lang['FB4PHPBB_LIGHT']) : sprintf($user->lang['UCP_FB4PHPBB_LIGHT_DISABLE_FACEBOOK_TEXT'], $user->lang['FB4PHPBB_LIGHT']),			
			'FB4PHPBB_PATH'					=> $phpbb_root_path . $config['fb4phpbb_light_path'],		
			'S_HIDDEN_FIELDS'				=> (isset($s_hidden_fields)) ? $s_hidden_fields : '',
			'S_UCP_ACTION'					=> $this->u_action,
			'S_AJAX'          				=> (request_var('ajax', '') == 'yes') ? true : false));

		// Set desired template
		$this->tpl_name = 'ucp_fb4phpbb_light';
		$this->page_title = 'UCP_FB4PHPBB_LIGHT';
	}
}

?>