<?php
/**
 * @package		Facebook 2011
 * @author      Damien Keitel <keitzy@damienkeitel.com>
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link        http://forums.damienkeitel.com
 * @copyright (c) 2011 Damien Keitel
 *
 * THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN
 * NO EVENT SHALL CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS
 * OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
 * TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE
 * USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH
 * DAMAGE.
 *
 */
/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}
  /**
  * ucp_fbregister
  * Facebook Board registration
   * @package		Facebook 2011
  */
class ucp_fblight_register
{
	var $u_action;

    function return_ajax($value = '')
    {
        echo($value);
        die;
    }
         
	function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template, $phpbb_root_path, $phpEx;

		if ($config['require_activation'] == USER_ACTIVATION_DISABLE)
		{
			trigger_error('UCP_REGISTER_DISABLE');
		}
        if (!function_exists('custom_profile')) 
        {
            include($phpbb_root_path . 'includes/functions_profile_fields.' . $phpEx);  
        }

		$user->add_lang('mods/fb4phpbb_light');
		$user->add_lang('mods/info_ucp_fb4phpbb_light');
    
		$coppa				= (isset($_REQUEST['coppa'])) ? ((!empty($_REQUEST['coppa'])) ? 1 : 0) : false;
		$agreed				= (!empty($_POST['agreed'])) ? 1 : 0;
		$submit			= (isset($_POST['submit'])) ? true : false;
		$change_lang		= request_var('change_lang', '');
		$user_lang			= request_var('lang', $user->lang_name);
		$fb4phpbb_light_uid 		= request_var('fb4phpbb_light_uid', '');
		$fb4phpbb_light_username 	= request_var('fb4phpbb_light_username', '');
		$fb4phpbb_light_email 	= request_var('fb4phpbb_light_email', '');
		$fb4phpbb_light_avatar 	= request_var('fb4phpbb_light_avatar', ''); 		 
    
		if ($agreed)
		{
			add_form_key('ucp_fblight_register');
		}
		else
		{
			add_form_key('ucp_register_terms');
		}

    
		if ($change_lang || $user_lang != $config['default_lang'])
		{
			$use_lang = ($change_lang) ? basename($change_lang) : basename($user_lang);

			if (!validate_language_iso_name($use_lang))
			{
				if ($change_lang)
				{
					$submit = false;

					// Setting back agreed to let the user view the agreement in his/her language
					$agreed = (empty($_GET['change_lang'])) ? 0 : $agreed;
				}

				$user->lang_name = $user_lang = $use_lang;
				$user->lang = array();
				$user->data['user_lang'] = $user->lang_name;
				$user->add_lang(array('common', 'ucp', 'mods/fb4phpbb_light'));
			}
			else
			{
				$change_lang = '';
				$user_lang = $user->lang_name;
			}
		}


		$cp = new custom_profile();

		$error = $cp_data = $cp_error = array();

		if (!$agreed || ($coppa === false && $config['coppa_enable']) || ($coppa && !$config['coppa_enable']))
		{
			$add_lang = ($change_lang) ? '&amp;change_lang=' . urlencode($change_lang) : '';
			$add_coppa = ($coppa !== false) ? '&amp;coppa=' . $coppa : '';

			$s_hidden_fields = array(
				'change_lang'	=> $change_lang,
                'fb4phpbb_light_username'   => request_var('fb4phpbb_light_username', ''),
                'fb4phpbb_light_email'   => request_var('fb4phpbb_light_email', ''),
                'fb4phpbb_light_uid'   => request_var('fb4phpbb_light_uid', ''),			
			);

			// If we change the language, we want to pass on some more possible parameter.
			if ($change_lang)
			{
				// We do not include the password
				$s_hidden_fields = array_merge($s_hidden_fields, array(					
					'lang'				=> $user->lang_name,
					'tz'				=> request_var('tz', (float) $config['board_timezone']),
                    ));

			}

			// Checking amount of available languages
			$sql = 'SELECT lang_id
				FROM ' . LANG_TABLE;
			$result = $db->sql_query($sql);

			$lang_row = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$lang_row[] = $row;
			}
			$db->sql_freeresult($result);

			if ($coppa === false && $config['coppa_enable'])
			{
				$now = getdate();
				$coppa_birthday = $user->format_date(mktime($now['hours'] + $user->data['user_dst'], $now['minutes'], $now['seconds'], $now['mon'], $now['mday'] - 1, $now['year'] - 13), $user->lang['DATE_FORMAT']);
				unset($now);

				$template->assign_vars(array(
					'S_LANG_OPTIONS'	=> (sizeof($lang_row) > 1) ? language_select($user_lang) : '',
					'L_COPPA_NO'		=> sprintf($user->lang['UCP_COPPA_BEFORE'], $coppa_birthday),
					'L_COPPA_YES'		=> sprintf($user->lang['UCP_COPPA_ON_AFTER'], $coppa_birthday),

					'U_COPPA_NO'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=fblight_register&amp;coppa=0' . $add_lang),
					'U_COPPA_YES'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=fblight_register&amp;coppa=1' . $add_lang),

					'S_SHOW_COPPA'		=> true,
					'S_HIDDEN_FIELDS'	=> build_hidden_fields($s_hidden_fields),
					'S_UCP_ACTION'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=fblight_register' . $add_lang),
				));
			}
			else
			{
				$template->assign_vars(array(
					'S_LANG_OPTIONS'	=> (sizeof($lang_row) > 1) ? language_select($user_lang) : '',
					'L_TERMS_OF_USE'	=> sprintf($user->lang['TERMS_OF_USE_CONTENT'], $config['sitename'], generate_board_url()),

					'S_SHOW_COPPA'		=> false,
					'S_REGISTRATION'	=> true,
					'S_HIDDEN_FIELDS'	=> build_hidden_fields($s_hidden_fields),
					'S_UCP_ACTION'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=fblight_register' . $add_lang . $add_coppa),
					)
				);
			}
			unset($lang_row);

			$this->tpl_name = 'ucp_fblight_agreement';
			return;
		}
    
		if ($config['enable_confirm'])
		{
            if (!function_exists('phpbb_captcha_factory')) 
            {
                include($phpbb_root_path . 'includes/captcha/captcha_factory.' . $phpEx);
            }
			$captcha =& phpbb_captcha_factory::get_instance($config['captcha_plugin']);
			$captcha->init(CONFIRM_REG);
		}

		$timezone = date('Z') / 3600;
		$is_dst = date('I');
   
		if ($config['board_timezone'] == $timezone || $config['board_timezone'] == ($timezone - 1))
		{
			$timezone = ($is_dst) ? $timezone - 1 : $timezone;
			
			if (!isset($user->lang['tz_zones'][(string) $timezone]))
			{
				$timezone = $config['board_timezone'];
			}
		}
		else
		{
			$is_dst = $config['board_dst'];
			$timezone = $config['board_timezone'];
		}

		$server_url = generate_board_url();  
		$key_len = 54 - strlen($server_url);
		$key_len = max(6, $key_len); // we want at least 6
		$key_len = ($config['max_pass_chars']) ? min($key_len, $config['max_pass_chars']) : $key_len; // we want at most $config['max_pass_chars']
		$user_actkey = substr(gen_rand_string(10), 0, $key_len);
		$new_user_password = gen_rand_string(8);
		$data = array(
			'username'				=> utf8_normalize_nfc(request_var('fb4phpbb_light_username', '', true)), 			
			'new_password' 			=> $new_user_password,
			'password_confirm' 		=> $new_user_password,			
			'email'					=> strtolower(request_var('fb4phpbb_light_email', '')),
			'lang'					=> basename(request_var('lang', $user->lang_name)),
			'tz'					=> request_var('tz', (float) $timezone));          
  
		if($submit)
		{      
			if ($config['check_dnsbl'])
			{
				if (($dnsbl = $user->check_dnsbl('register')) !== false)
				{
					$error[] = sprintf($user->lang['IP_BLACKLISTED'], $user->ip, $dnsbl[1]);
				}
			}

			$cp->submit_cp_field('register', $user->get_iso_lang_id(), $cp_data, $error);
      
			if (!sizeof($error))
			{
				$server_url = generate_board_url();

				$group_name = ($coppa) ? 'REGISTERED_COPPA' : 'REGISTERED';
        
				$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . "
				WHERE group_name = '" . $db->sql_escape($group_name) . "'
				AND group_type = " . GROUP_SPECIAL;
        
				$result = $db->sql_query($sql);
        
				$row = $db->sql_fetchrow($result);
        
				$db->sql_freeresult($result);
        
				if (!$row)
				{
					trigger_error('NO_GROUP');
				}
        
				$group_id = $row['group_id'];
       
				if (($coppa || $config['require_activation'] == USER_ACTIVATION_SELF || $config['require_activation'] == USER_ACTIVATION_ADMIN) && $config['email_enable'])
				{
					$user_actkey 			= gen_rand_string(mt_rand(6, 10));
					$user_type 				= USER_INACTIVE;
					$user_inactive_reason 	= INACTIVE_REGISTER;
					$user_inactive_time 	= time();
				}
				else
				{
					$user_type 				= USER_NORMAL;
					$user_actkey 			= '';
					$user_inactive_reason 	= 0;
					$user_inactive_time 	= 0;
				}
        
				$user_row = array(
					'username'				=> $data['username'],
					'user_password'			=> phpbb_hash($data['new_password']),
					'user_email'			=> $data['email'],
					'group_id'				=> (int) $group_id,
					'user_timezone'			=> (float) $data['tz'],
					'user_dst'				=> $is_dst,
					'user_lang'				=> $data['lang'],
					'user_type'				=> $user_type,
					'user_actkey'			=> $user_actkey,
					'user_ip'				=> $user->ip,
					'user_regdate'			=> time(),
					'user_inactive_reason'	=> $user_inactive_reason,
					'user_inactive_time'	=> $user_inactive_time);
        
				if ($config['new_member_post_limit'])
				{
					$user_row['user_new'] 	= 1;
				}

				$user_id = user_add($user_row, $cp_data);
        
				if ($user_id === false)
				{
					trigger_error('NO_USER', E_USER_ERROR);
				}
                
                $sql =  'UPDATE ' . USERS_TABLE . "
                SET user_fb4phpbb_light_fb_uid = '" . $db->sql_escape($fb4phpbb_light_uid) . "'
                WHERE user_id = '" . $db->sql_escape($user_id) . "'";              
                
				$result 					= $db->sql_query($sql);
				if(!$result)
				{
					trigger_error('Unable to connect with phpBB database.');
				}
				
				if (($config['allow_avatar_remote_fb'] == 'yes') && ($fb4phpbb_light_avatar == 'true'))
				{
                    $picsql =  'UPDATE ' . USERS_TABLE . "
                    SET user_avatar='https://graph.facebook.com/" . $fb4phpbb_light_uid . "/picture?type=normal', user_avatar_type=4, user_avatar_width='', user_avatar_height='' 
                    WHERE user_id = '" . $db->sql_escape($user_id) . "'";  
                    $picresult = $db->sql_query($picsql);
                    
                    if(!$picresult)
                    {
                        trigger_error('Unable to connect with phpBB database.');
                    }
				}
                


				$fb4phpbb_light_email_lang		= $user->lang['FB4PHPBB_LIGHT'];       
        
				if ($coppa && $config['email_enable'])
				{
					$message 				= $user->lang['ACCOUNT_COPPA'];
					$email_template 		= 'coppa_welcome_inactive_fb4phpbb_light';
				}
				else if ($config['require_activation'] == USER_ACTIVATION_SELF && $config['email_enable'])
				{
					$message 				= $user->lang['ACCOUNT_INACTIVE'];
					$email_template 		= 'user_welcome_inactive_fb4phpbb_light';
				}
				else if ($config['require_activation'] == USER_ACTIVATION_ADMIN && $config['email_enable'])
				{
					$message 				= $user->lang['ACCOUNT_INACTIVE_ADMIN'];
					$email_template 		= 'admin_welcome_inactive_fb4phpbb_light';
				}
				else
				{
					$message				= $user->lang['ACCOUNT_ADDED'];
					$email_template 		= 'user_welcome_fb4phpbb_light';
				}
				if ($config['email_enable'])
				{
                    if (!function_exists('messenger')) 
                    {
                        include($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);
					}
					$messenger 				= new messenger(false);
					$messenger->template($email_template, $data['lang']);
					$messenger->to($data['email'], $data['username']);
					$messenger->headers('X-AntiAbuse: Board servername - ' . $config['server_name']);
					$messenger->headers('X-AntiAbuse: User_id - ' . $user->data['user_id']);
					$messenger->headers('X-AntiAbuse: Username - ' . $user->data['username']);
					$messenger->headers('X-AntiAbuse: User IP - ' . $user->ip);
					$messenger->assign_vars(array(
						'WELCOME_MSG'		=> htmlspecialchars_decode(sprintf($user->lang['WELCOME_SUBJECT'], $config['sitename'])),
						'USERNAME'			=> htmlspecialchars_decode($data['username']),
						'U_ACTIVATE'		=> "$server_url/ucp.$phpEx?mode=activate&u=$user_id&k=$user_actkey"));
					
					if ($coppa)
					{
						$messenger->assign_vars(array(
							'FAX_INFO'			=> $config['coppa_fax'],
							'MAIL_INFO'			=> $config['coppa_mail'],
							'EMAIL_ADDRESS'		=> $data['email']));
					}
					
					$messenger->send(NOTIFY_EMAIL);
          
					if ($config['require_activation'] == USER_ACTIVATION_ADMIN)
					{
            
						$admin_ary = $auth->acl_get_list(false, 'a_user', false);
						$admin_ary = (!empty($admin_ary[0]['a_user'])) ? $admin_ary[0]['a_user'] : array();
						$where_sql = ' WHERE user_type = ' . USER_FOUNDER;
				
						if (sizeof($admin_ary))
						{
							$where_sql .= ' OR ' . $db->sql_in_set('user_id', $admin_ary);
						}
				
						$sql = 'SELECT user_id, username, user_email, user_lang, user_jabber, user_notify_type
						FROM ' . USERS_TABLE . ' ' .
						$where_sql;
				
						$result = $db->sql_query($sql);
						
						while ($row = $db->sql_fetchrow($result))
						{
							$messenger->template('admin_activate', $row['user_lang']);
							$messenger->to($row['user_email'], $row['username']);
							$messenger->im($row['user_jabber'], $row['username']);
							$messenger->assign_vars(array(
								'USERNAME'			=> htmlspecialchars_decode($data['username']),
								'U_USER_DETAILS'	=> "$server_url/memberlist.$phpEx?mode=viewprofile&u=$user_id",
								'U_ACTIVATE'		=> "$server_url/ucp.$phpEx?mode=activate&u=$user_id&k=$user_actkey"));
							$messenger->send($row['user_notify_type']);
						}
				
						$db->sql_freeresult($result);
					}
				}
			
				$message = $message . '<br /><br />' . sprintf($user->lang['RETURN_TIME_FB4PHPBB_LIGHT'] . ' ' . $user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');
				$response = $message . '<script>setTimeout(function() { window.location.href = "' . append_sid("{$phpbb_root_path}index.$phpEx") . '";}, 10000)</script>';
                return_ajax($response);
			}
		}      
    
		$s_hidden_fields = array(
			'agreed'					=> 'true',
			'change_lang'				=> 0,
			'fb4phpbb_light_uid' 			=> $fb4phpbb_light_uid,
		);
		if ($config['coppa_enable'])
		{
			$s_hidden_fields['coppa'] 	= $coppa;
		}
		if ($config['enable_confirm'])
		{
			$s_hidden_fields			= array_merge($s_hidden_fields, $captcha->get_hidden_fields());
		}
		$s_hidden_fields 				= build_hidden_fields($s_hidden_fields);

		$l_reg_cond 					= '';
		
		switch ($config['require_activation'])
		{
			case USER_ACTIVATION_SELF:
				$l_reg_cond 			= $user->lang['UCP_EMAIL_ACTIVATE'];
			break;
		  
			case USER_ACTIVATION_ADMIN:
				$l_reg_cond 			= $user->lang['UCP_ADMIN_ACTIVATE'];
			break;
		}
		
		$template->assign_vars(array(
			'FB4PHPBB_LIGHT_USERNAME' 		=> $fb4phpbb_light_username,
			'FB4PHPBB_LIGHT_EMAIL' 			=> $fb4phpbb_light_email,
			'FB4PHPBB_LIGHT_UID' 				=> $fb4phpbb_light_uid,			     
			'ERROR'						=> (sizeof($error)) ? implode('<br />', $error) : '',
			'S_FB4PHPBB_LIGHT_REGO' 			=> true,
			'L_USERNAME_EXPLAIN'		=> sprintf($user->lang[$config['allow_name_chars'] . '_EXPLAIN'], $config['min_name_chars'], $config['max_name_chars']),
			'L_LINK_REMOTE_AVATAR_FB'  	=> $user->lang['LINK_REMOTE_AVATAR_FB'],
			'L_REG_COND'				=> $l_reg_cond,
			'L_FB_REG_COND'				=> $user->lang['FB_REG_COND'],
			'S_LANG_OPTIONS'			=> language_select($data['lang']),
			'S_TZ_OPTIONS'				=> tz_select($data['tz']),
			'S_CONFIRM_REFRESH'			=> ($config['enable_confirm'] && $config['confirm_refresh']) ? true : false,
			'S_REGISTRATION'			=> true,
			'S_COPPA'					=> $coppa,
			'S_HIDDEN_FIELDS'			=> $s_hidden_fields,
			'S_UCP_ACTION'				=> append_sid("ucp.$phpEx", 'mode=fblight_register')));

		$user->profile_fields = array();

		$cp->generate_profile_fields('register', $user->get_iso_lang_id());

		$this->tpl_name 				= 'ucp_fblight_register';
		$this->page_title 				= 'UCP_REGISTRATION';
	}
}
?>