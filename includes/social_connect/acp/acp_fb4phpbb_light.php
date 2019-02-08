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

/**
* @package fb4phpbb_light
*/
class acp_fb4phpbb_light
{
	var $u_action;

    function fb4phpbb_light_language_select($default = '')
    {
        global $config, $phpbb_root_path ;
        $get_locale =	simplexml_load_file($phpbb_root_path . '/fb4phpbb_light/FacebookLocales.xml');
        $arr = $get_locale->locale;

        $fb_lang_options = '';
        foreach($arr as $locale)
        {
            $selected = ($locale->codes->code->standard->representation == $default) ? ' selected="selected"' : '';
            $fb_lang_options .= '<option name="' . $locale->codes->code->standard->representation . '" id="' . $locale->codes->code->standard->representation . '" value="' . $locale->codes->code->standard->representation . '"' . $selected . '>' . $locale->englishName . '</option>';
        }

        return $fb_lang_options;
    }

	function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template, $cache;
		global $phpbb_root_path, $phpbb_admin_path, $phpEx, $table_prefix, $file_uploads;
		$user->add_lang('mods/fb4phpbb_light');
		
		$this->tpl_name = 'acp_fb4phpbb_light';
		$this->page_title = 'ACP_FB4PHPBB_LIGHT';
		
		$action		= request_var('action', '');
		$form_name = 'acp_fb4phpbb_light';
		add_form_key($form_name);
        
        $findsql = "SELECT module_auth
        FROM " . MODULES_TABLE
        . " WHERE module_langname='UCP_PROFILE_AVATAR'";
        $result = $db->sql_query($findsql);
        $row = $db->sql_fetchrow($result);      
        if($row['module_auth'] == 'cfg_allow_avatar && (cfg_allow_avatar_local || cfg_allow_avatar_remote || cfg_allow_avatar_upload || cfg_allow_avatar_remote_upload)')
        {
            $sql = "UPDATE " . MODULES_TABLE
            . " SET module_auth='cfg_allow_avatar && (cfg_allow_avatar_local || cfg_allow_avatar_remote || cfg_allow_avatar_remote_fb || cfg_allow_avatar_upload || cfg_allow_avatar_remote_upload)'"
            . " WHERE  module_langname='UCP_PROFILE_AVATAR'";
            $updated = $db->sql_query($sql);
        }
		if(isset($_POST['submit']))
		{
			switch($mode)
			{
				case 'fb4phpbb_light':
					$fb4phpbb_light_mod_enabled 					= request_var('fb4phpbb_light_mod_enabled', '');
					$fb4phpbb_light_app_id 						= request_var('fb4phpbb_light_app_id', '');					
					$fb4phpbb_light_secret 						= request_var('fb4phpbb_light_secret', '');					
					$fb4phpbb_light_locale 						= request_var('lang', '');
										
					set_config('fb4phpbb_light_mod_enabled', $fb4phpbb_light_mod_enabled, true);   
					set_config('fb4phpbb_light_appid', $fb4phpbb_light_app_id, true);				
					set_config('fb4phpbb_light_secret', $fb4phpbb_light_secret, true);
					set_config('fb4phpbb_light_lang', $fb4phpbb_light_locale, true);	  
					
					trigger_error($user->lang['ACP_FB4PHPBB_LIGHT_SETTINGS_UPDATED'] . adm_back_link($this->u_action));
				break;    
			}
		}
		else
		{
			switch($mode)
			{
				case 'fb4phpbb_light': 
			   
				$selected 									= ' selected="selected" ';
				$checked 									= ' checked="checked" ';
				$fb4phpbb_light_mod_enabled 						= ($config['fb4phpbb_light_mod_enabled'] === 'yes' ? $checked : '');
				$fb4phpbb_light_mod_disabled  					= ($config['fb4phpbb_light_mod_enabled'] === 'no' ? $checked : '');

				$template->assign_vars(array(
					'FB4PHPBB_LIGHT_LANG'  						=> (!isset($config['fb4phpbb_light_lang'])) ? $this->fb4phpbb_light_language_select('en_US') : $this->fb4phpbb_light_language_select($config['fb4phpbb_light_lang']),				
					'FB4PHPBB_LIGHT_MOD_ENABLED_YES'				=> $fb4phpbb_light_mod_enabled,
					'FB4PHPBB_LIGHT_MOD_ENABLED_NO'				=> $fb4phpbb_light_mod_disabled,
					'FB4PHPBB_LIGHT_APP_ID'						=> $config['fb4phpbb_light_appid'],
					'FB4PHPBB_LIGHT_SECRET'						=> $config['fb4phpbb_light_secret'],
					'S_MODE_FB4PHPBB_LIGHT'   					=> true,
					'U_ACTION'								=> $this->u_action,
				));
				
			break;
			}
		}
	}	
}

?>