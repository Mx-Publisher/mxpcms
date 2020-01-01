<?php
/**
*
* @package Auth
* @version $Id: core.php,v 1.29 2014/07/07 20:36:53 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

//
// First off, include common vanilla phpBB functions, from our shared dir
// Note: These functions will later be accessible wrapped as phpBBX::orig_functionname()
//
include_once($mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx);
include_once($mx_root_path . 'includes/shared/phpbb3/includes/functions.' . $phpEx);

/*
* Instantiate Dummy phpBB Classes
$phpBB2 = new phpBB2();
$phpBB3 = new phpBB3();
*/

//
// Finally, load some backend specific functions
//
include_once($mx_root_path . 'includes/sessions/rhea/functions.' . $phpEx);

//
// phpBB Permissions
//
include_once($mx_root_path . 'includes/sessions/rhea/auth.' . $phpEx);

/**
* Permission/Auth class
*
* @package MX-Publisher
*
*/
class phpbb_auth extends phpbb_auth_base
{
	var $acl = array();
	var $mx_cache = array();
	var $acl_options = array();
	var $acl_forum_ids = false;
	
	/**
	* Init permissions
	*/
	function acl(&$userdata)
	{
		global $db, $mx_cache;

		$this->acl = $this->cache = $this->acl_options = array();
		$this->acl_forum_ids = false;

		if (($this->acl_options = $mx_cache->get('_acl_options')) === false)
		{
			$this->acl_options = array ( 
				'local' => array ( 
					'f_' => 0, 
					'f_announce' => 1, 
					'f_announce_global' => 2, 
					'f_attach' => 3, 
					'f_bbcode' => 4, 
					'f_bump' => 5, 
					'f_delete' => 6, 
					'f_download' => 7, 
					'f_edit' => 8, 
					'f_email' => 9, 
					'f_flash' => 10, 
					'f_icons' => 11, 
					'f_ignoreflood' => 12, 
					'f_img' => 13, 
					'f_list' => 14, 
					'f_list_topics' => 15, 
					'f_noapprove' => 16, 
					'f_poll' => 17, 
					'f_post' => 18, 
					'f_postcount' => 19, 
					'f_print' => 20, 
					'f_read' => 21, 
					'f_reply' => 22, 
					'f_report' => 23, 
					'f_search' => 24, 
					'f_sigs' => 25, 
					'f_smilies' => 26, 
					'f_sticky' => 27, 
					'f_subscribe' => 28, 
					'f_user_lock' => 29, 
					'f_vote' => 30, 
					'f_votechg' => 31, 
					'f_softdelete' => 32, 
					'm_' => 33, 
					'm_approve' => 34, 
					'm_chgposter' => 35, 
					'm_delete' => 36, 
					'm_edit' => 37, 
					'm_info' => 38, 
					'm_lock' => 39, 
					'm_merge' => 40, 
					'm_move' => 41, 
					'm_report' => 42, 
					'm_split' => 43, 
					'm_softdelete' => 44 
				), 
				'id' => array ( 
					'f_' => 1, 
					'f_announce' => 2, 
					'f_announce_global' => 3, 
					'f_attach' => 4, 
					'f_bbcode' => 5, 
					'f_bump' => 6, 
					'f_delete' => 7, 
					'f_download' => 8, 
					'f_edit' => 9, 
					'f_email' => 10, 
					'f_flash' => 11, 
					'f_icons' => 12, 
					'f_ignoreflood' => 13, 
					'f_img' => 14, 
					'f_list' => 15, 
					'f_list_topics' => 16, 
					'f_noapprove' => 17, 
					'f_poll' => 18, 
					'f_post' => 19, 
					'f_postcount' => 20, 
					'f_print' => 21, 
					'f_read' => 22, 
					'f_reply' => 23, 
					'f_report' => 24, 
					'f_search' => 25, 
					'f_sigs' => 26, 
					'f_smilies' => 27, 
					'f_sticky' => 28, 
					'f_subscribe' => 29, 
					'f_user_lock' => 30, 
					'f_vote' => 31, 
					'f_votechg' => 32, 
					'f_softdelete' => 33, 
					'm_' => 34, 
					'm_approve' => 35, 
					'm_chgposter' => 36, 
					'm_delete' => 37, 
					'm_edit' => 38, 
					'm_info' => 39, 
					'm_lock' => 40, 
					'm_merge' => 41, 
					'm_move' => 42, 
					'm_report' => 43, 
					'm_split' => 44, 
					'm_softdelete' => 45, 
					'm_ban' => 46, 
					'm_pm_report' => 47, 
					'm_warn' => 48, 
					'a_' => 49, 
					'a_aauth' => 50, 
					'a_attach' => 51, 
					'a_authgroups' => 52, 
					'a_authusers' => 53, 
					'a_backup' => 54, 
					'a_ban' => 55, 
					'a_bbcode' => 56, 
					'a_board' => 57, 
					'a_bots' => 58, 
					'a_clearlogs' => 59, 
					'a_email' => 60, 
					'a_extensions' => 61, 
					'a_fauth' => 62, 
					'a_forum' => 63, 
					'a_forumadd' => 64, 
					'a_forumdel' => 65, 
					'a_group' => 66, 
					'a_groupadd' => 67, 
					'a_groupdel' => 68, 
					'a_icons' => 69, 
					'a_jabber' => 70, 
					'a_language' => 71, 
					'a_mauth' => 72, 
					'a_modules' => 73, 
					'a_names' => 74, 
					'a_phpinfo' => 75, 
					'a_profile' => 76, 
					'a_prune' => 77, 
					'a_ranks' => 78, 
					'a_reasons' => 79, 
					'a_roles' => 80, 
					'a_search' => 81, 
					'a_server' => 82, 
					'a_storage' => 83, 
					'a_styles' => 84, 
					'a_switchperm' => 85, 
					'a_uauth' => 86, 
					'a_user' => 87, 
					'a_userdel' => 88, 
					'a_viewauth' => 89, 
					'a_viewlogs' => 90, 
					'a_words' => 91,
					'u_' => 92,
					'u_attach' => 93,
					'u_chgavatar' => 94,
					'u_chgcensors' => 95,
					'u_chgemail' => 96,
					'u_chggrp' => 97,
					'u_chgname' => 98,
					'u_chgpasswd' => 99,
					'u_chgprofileinfo' => 100,
					'u_download' => 101,
					'u_hideonline' => 102,
					'u_ignoreflood' => 103,
					'u_masspm' => 104,
					'u_masspm_group' => 105,
					'u_pm_attach' => 106,
					'u_pm_bbcode' => 107,
					'u_pm_delete' => 108,
					'u_pm_download' => 109,
					'u_pm_edit' => 110,
					'u_pm_emailpm' => 111,
					'u_pm_flash' => 112,
					'u_pm_forward' => 113,
					'u_pm_img' => 114,
					'u_pm_printpm' => 115,
					'u_pm_smilies' => 116,
					'u_readpm' => 117,
					'u_savedrafts' => 118,
					'u_search' => 119,
					'u_sendemail' => 120,
					'u_sendim' => 121,
					'u_sendpm' => 122,
					'u_sig' => 123,
					'u_viewonline' => 124,
					'u_viewprofile' => 125,
					'u_dae_user' => 142, 
					'a_dae_admin' => 143 
				), 
				'option' => array ( 
					'1' => 'f_', 
					'2' => 'f_announce', 
					'3' => 'f_announce_global', 
					'4' => 'f_attach', 
					'5' => 'f_bbcode', 
					'6' => 'f_bump', 
					'7' => 'f_delete', 
					'8' => 'f_download', 
					'9' => 'f_edit', 
					'10' => 'f_email', 
					'11' => 'f_flash', 
					'12' => 'f_icons', 
					'13' => 'f_ignoreflood', 
					'14' => 'f_img', 
					'15' => 'f_list',
					'16' => 'f_list_topics', 
					'17' => 'f_noapprove', 
					'18' => 'f_poll', 
					'19' => 'f_post', 
					'20' => 'f_postcount', 
					'21' => 'f_print', 
					'22' => 'f_read', 
					'23' => 'f_reply', 
					'24' => 'f_report', 
					'25' => 'f_search', 
					'26' => 'f_sigs', 
					'27' => 'f_smilies', 
					'28' => 'f_sticky', 
					'29' => 'f_subscribe', 
					'30' => 'f_user_lock', 
					'31' => 'f_vote', 
					'32' => 'f_votechg', 
					'33' => 'f_softdelete', 
					'34' => 'm_', 
					'35' => 'm_approve', 
					'36' => 'm_chgposter', 
					'37' => 'm_delete', 
					'38' => 'm_edit', 
					'39' => 'm_info', 
					'40' => 'm_lock', 
					'41' => 'm_merge', 
					'42' => 'm_move', 
					'43' => 'm_report', 
					'44' => 'm_split', 
					'45' => 'm_softdelete', 
					'46' => 'm_ban', 
					'47' => 'm_pm_report', 
					'48' => 'm_warn', 
					'49' => 'a_', 
					'50' => 'a_aauth', 
					'51' => 'a_attach', 
					'52' => 'a_authgroups', 
					'53' => 'a_authusers', 
					'54' => 'a_backup', 
					'55' => 'a_ban', 
					'56' => 'a_bbcode', 
					'57' => 'a_board', 
					'58' => 'a_bots', 
					'59' => 'a_clearlogs', 
					'60' => 'a_email', 
					'61' => 'a_extensions', 
					'62' => 'a_fauth', 
					'63' => 'a_forum', 
					'64' => 'a_forumadd', 
					'65' => 'a_forumdel', 
					'66' => 'a_group', 
					'67' => 'a_groupadd', 
					'68' => 'a_groupdel', 
					'69' => 'a_icons', 
					'70' => 'a_jabber', 
					'71' => 'a_language', 
					'72' => 'a_mauth', 
					'73' => 'a_modules', 
					'74' => 'a_names', 
					'75' => 'a_phpinfo', 
					'76' => 'a_profile', 
					'77' => 'a_prune', 
					'78' => 'a_ranks', 
					'79' => 'a_reasons', 
					'80' => 'a_roles', 
					'81' => 'a_search', 
					'82' => 'a_server', 
					'83' => 'a_storage', 
					'84' => 'a_styles', 
					'85' => 'a_switchperm', 
					'86' => 'a_uauth', 
					'87' => 'a_user', 
					'88' => 'a_userdel', 
					'89' => 'a_viewauth', 
					'90' => 'a_viewlogs', 
					'91' => 'a_words', 
					'92' => 'u_', 
					'93' => 'u_attach', 
					'94' => 'u_chgavatar', 
					'95' => 'u_chgcensors', 
					'96' => 'u_chgemail', 
					'97' => 'u_chggrp', 
					'98' => 'u_chgname', 
					'99' => 'u_chgpasswd', 
					'100' => 'u_chgprofileinfo', 
					'101' => 'u_download', 
					'102' => 'u_hideonline', 
					'103' => 'u_ignoreflood', 
					'104' => 'u_masspm', 
					'105' => 'u_masspm_group', 
					'106' => 'u_pm_attach', 
					'107' => 'u_pm_bbcode', 
					'108' => 'u_pm_delete', 
					'109' => 'u_pm_download', 
					'110' => 'u_pm_edit', 
					'111' => 'u_pm_emailpm',
					'112' => 'u_pm_flash', 
					'113' => 'u_pm_forward', 
					'114' => 'u_pm_img', 
					'115' => 'u_pm_printpm', 
					'116' => 'u_pm_smilies', 
					'117' => 'u_readpm',
					'118' => 'u_savedrafts', 
					'119' => 'u_search', 
					'120' => 'u_sendemail', 
					'121' => 'u_sendim', 
					'122' => 'u_sendpm', 
					'123' => 'u_sig', 
					'124' => 'u_viewonline', 
					'125' => 'u_viewprofile', 
					'142' => 'u_dae_user', 
					'143' => 'a_dae_admin' 
				), 
				'global' => array ( 
					'm_' => 0, 
					'm_approve' => 1,  
					'm_chgposter' => 2,  
					'm_delete' => 3,  
					'm_edit' => 4,  
					'm_info' => 5,  
					'm_lock' => 6,  
					'm_merge' => 7,  
					'm_move' => 8,  
					'm_report' => 9,  
					'm_split' => 10,  
					'm_softdelete' => 11,  
					'm_ban' => 12,  
					'm_pm_report' => 13,  
					'm_warn' => 14,  
					'a_' => 15,  
					'a_aauth' => 16,  
					'a_attach' => 17,  
					'a_authgroups' => 18,  
					'a_authusers' => 19,  
					'a_backup' => 20,  
					'a_ban' => 21,  
					'a_bbcode' => 22,  
					'a_board' => 23,  
					'a_bots' => 24, 
					'a_clearlogs' => 25, 
					'a_email' => 26, 
					'a_extensions' => 27, 
					'a_fauth' => 28, 
					'a_forum' => 29, 
					'a_forumadd' => 30, 
					'a_forumdel' => 31, 
					'a_group' => 32, 
					'a_groupadd' => 33, 
					'a_groupdel' => 34, 
					'a_icons' => 35, 
					'a_jabber' => 36, 
					'a_language' => 37, 
					'a_mauth' => 38, 
					'a_modules' => 39, 
					'a_names' => 40, 
					'a_phpinfo' => 41, 
					'a_profile' => 42, 
					'a_prune' => 43, 
					'a_ranks' => 44, 
					'a_reasons' => 45, 
					'a_roles' => 46, 
					'a_search' => 47, 
					'a_server' => 48, 
					'a_storage' => 49, 
					'a_styles' => 50, 
					'a_switchperm' => 51, 
					'a_uauth' => 52, 
					'a_user' => 53, 
					'a_userdel' => 54, 
					'a_viewauth' => 55, 
					'a_viewlogs' => 56, 
					'a_words' => 57, 
					'u_' => 58, 
					'u_attach' => 59, 
					'u_chgavatar' => 60, 
					'u_chgcensors' => 61, 
					'u_chgemail' => 62, 
					'u_chggrp' => 63, 
					'u_chgname' => 64, 
					'u_chgpasswd' => 65, 
					'u_chgprofileinfo' => 66, 
					'u_download' => 67, 
					'u_hideonline' => 68, 
					'u_ignoreflood' => 69, 
					'u_masspm' => 70, 
					'u_masspm_group' => 71, 
					'u_pm_attach' => 72, 
					'u_pm_bbcode' => 73, 
					'u_pm_delete' => 74, 
					'u_pm_download' => 75, 
					'u_pm_edit' => 76, 
					'u_pm_emailpm' => 77, 
					'u_pm_flash' => 78, 
					'u_pm_forward' => 79, 
					'u_pm_img' => 80, 
					'u_pm_printpm' => 81, 
					'u_pm_smilies' => 82, 
					'u_readpm' => 83, 
					'u_savedrafts' => 84, 
					'u_search' => 85, 
					'u_sendemail' => 86, 
					'u_sendim' => 87, 
					'u_sendpm' => 88, 
					'u_sig' => 89, 
					'u_viewonline' => 90, 
					'u_viewprofile' => 91, 
					'u_dae_user' => 92, 
					'a_dae_admin' => 93 
				) 
			);
			
			$mx_cache->put('_acl_options', $this->acl_options);
		}
		
		if (!isset($userdata['user_permissions']) || !trim($userdata['user_permissions']))
		{
			$this->acl_cache($userdata);
		}

		// Fill ACL array
		$this->_fill_acl($userdata['user_permissions']);
		
		// Verify bitstring length with options provided...
		$renew = false;
		$global_length = count($this->acl_options['global']);
		$local_length = count($this->acl_options['local']);

		// Specify comparing length (bitstring is padded to 31 bits)
		$global_length = ($global_length % 31) ? ($global_length - ($global_length % 31) + 31) : $global_length;
		$local_length = ($local_length % 31) ? ($local_length - ($local_length % 31) + 31) : $local_length;

		// You thought we are finished now? Noooo... now compare them.
		foreach ($this->acl as $forum_id => $bitstring)
		{
			if (($forum_id && strlen($bitstring) != $local_length) || (!$forum_id && strlen($bitstring) != $global_length))
			{
				$renew = true;
				break;
			}
		}

		// If a bitstring within the list does not match the options, we have a user with incorrect permissions set and need to renew them
		if ($renew)
		{
			$this->acl_cache($userdata);
			$this->_fill_acl($userdata['user_permissions']);
		}

		return;
	}
	
	/**
	* Build bitstring from permission set
	*/
	function build_bitstring(&$hold_ary)
	{
		$hold_str = '';

		if (count($hold_ary))
		{
			ksort($hold_ary);

			$last_f = 0;

			foreach ($hold_ary as $f => $auth_ary)
			{
				$ary_key = (!$f) ? 'global' : 'local';

				$bitstring = array();
				foreach ($this->acl_options[$ary_key] as $opt => $id)
				{
					if (isset($auth_ary[$this->acl_options['id'][$opt]]))
					{
						$bitstring[$id] = $auth_ary[$this->acl_options['id'][$opt]];

						$option_key = substr($opt, 0, strpos($opt, '_') + 1);

						// If one option is allowed, the global permission for this option has to be allowed too
						// example: if the user has the a_ permission this means he has one or more a_* permissions
						if ($auth_ary[$this->acl_options['id'][$opt]] == ACL_YES && (!isset($bitstring[$this->acl_options[$ary_key][$option_key]]) || $bitstring[$this->acl_options[$ary_key][$option_key]] == ACL_NEVER))
						{
							$bitstring[$this->acl_options[$ary_key][$option_key]] = ACL_YES;
						}
					}
					else
					{
						$bitstring[$id] = ACL_NEVER;
					}
				}

				// Now this bitstring defines the permission setting for the current forum $f (or global setting)
				$bitstring = implode('', $bitstring);

				// The line number indicates the id, therefore we have to add empty lines for those ids not present
				$hold_str .= str_repeat("\n", $f - $last_f);

				// Convert bitstring for storage - we do not use binary/bytes because PHP's string functions are not fully binary safe
				for ($i = 0, $bit_length = strlen($bitstring); $i < $bit_length; $i += 31)
				{
					$hold_str .= str_pad(base_convert(str_pad(substr($bitstring, $i, 31), 31, 0, STR_PAD_RIGHT), 2, 36), 6, 0, STR_PAD_LEFT);
				}

				$last_f = $f;
			}
			unset($bitstring);

			$hold_str = rtrim($hold_str);
		}

		return $hold_str;
	}
	
	/**
	* Cache data to user_permissions row
	*/
	function acl_cache(&$userdata)
	{
		global $db;
		
		// Empty user_permissions
		$userdata['user_permissions'] = '';

		$hold_ary = $this->acl_raw_data_single_user($userdata['user_id']);

		// Key 0 in $hold_ary are global options, all others are forum_ids

		// If this user is founder we're going to force fill the admin options ...
		if ($userdata['user_level'] == ADMIN)
		{
			foreach ($this->acl_options['global'] as $opt => $id)
			{
				if (strpos($opt, 'a_') === 0)
				{
					$hold_ary[0][$this->acl_options['id'][$opt]] = ACL_YES;
				}
			}
		}
		
		$hold_str = $this->build_bitstring($hold_ary);

		if ($hold_str)
		{			
			$userdata['user_permissions'] = $hold_str;
			
			$sql = 'UPDATE ' . USERS_TABLE . "
				SET user_permissions = '" . $db->sql_escape($userdata['user_permissions']) . "',
					user_perm_from = 0
				WHERE user_id = " . $userdata['user_id'];
			if (!($db->sql_query($sql)))
			{
				// If the column exists we change it, else we add it ;)
				$table = USERS_TABLE;
				
				$column_data = $userdata;
				
				if (!class_exists('phpbb_db_tools') && !class_exists('tools'))
				{
					global $phpbb_root_path, $phpEx;
					require($phpbb_root_path . 'includes/db/tools.' . $phpEx);
				}
				
				if (class_exists('phpbb_db_tools'))
				{
					$db_tools = new phpbb_db_tools($db);
				}
				elseif (class_exists('tools'))
				{
					$db_tools = new tools($db);
				}
				
				if (is_object($db_tools))
				{
					if ($db_tools->sql_column_exists($table, 'user_perm_from'))
					{
						$result = true;
					}
					else
					{
						$column_name = 'user_perm_from';
						
						$column_data['column_type_sql'] = 'TEXT';
						$column_data['user_perm_from'] = '0';
						
						$result = $db_tools->sql_column_add($table, $column_name, $column_data, true);				
					
						if (!$result)
						{
							$after = (!empty($column_data['after'])) ? ' AFTER ' . $column_data['after'] : '';
							$sql = 'ALTER TABLE `' . $table . '` ADD `' . $column_name . '` ' . (($column_data['column_type_sql'] = 'NULL') ? 'TEXT' :  $column_data['column_type_sql']) . ' ' . (!empty($column_data[$column_name]) ? $column_data[$column_name] : 'NULL') . ' DEFAULT NULL'  . $after;					
						
							// We could add error handling here...
							$result = $db->sql_query($sql);
							if (!($result))
							{		
								mx_message_die(CRITICAL_ERROR, "Could not info", '', __LINE__, __FILE__, $sql);
							}
						}
					}
					
					if ($db_tools->sql_column_exists($table, 'user_permissions'))
					{
						$result = true;
					}
					else					
					{
						$column_name = 'user_permissions';
						
						$column_data['column_type_sql'] = 'TEXT';
						$column_data['user_permissions'] = 'NULL';
						
						$result = $db_tools->sql_column_add($table, $column_name, $column_data, true);				
					
						if (!$result)
						{
							$after = (!empty($column_data['after'])) ? ' AFTER ' . $column_data['after'] : '';
							$sql = 'ALTER TABLE `' . $table . '` ADD `' . $column_name . '` ' . (($column_data['column_type_sql'] = 'NULL') ? 'TEXT' :  $column_data['column_type_sql']) . ' ' . (!empty($column_data[$column_name]) ? $column_data[$column_name] : 'NULL') . ' DEFAULT NULL'  . $after;
							
							// We could add error handling here...
							$result = $db->sql_query($sql);
							if (!($result))
							{
								mx_message_die(CRITICAL_ERROR, "Could not info", '', __LINE__, __FILE__, $sql);
							}
						}
					}
					
					if ($db_tools->sql_column_exists($table, 'user_birthday'))
					{
						$result = true;
					}
					else
					{
						$column_name = 'user_birthday';
						
						$column_data['column_type_sql'] = 'TEXT';
						$column_data['user_birthday'] = 'NULL';
						
						$result = $db_tools->sql_column_add($table, $column_name, $column_data, true);
						
						if (!$result)
						{
							$after = (!empty($column_data['after'])) ? ' AFTER ' . $column_data['after'] : '';
							$statements[] = 'ALTER TABLE `' . $table . '` ADD `' . $column_name . '` ' . (($column_data['column_type_sql'] = 'NULL') ? 'TEXT' :  $column_data['column_type_sql']) . ' ' . (!empty($column_data[$column_name]) ? $column_data[$column_name] : 'NULL') . ' DEFAULT NULL'  . $after;					
							
							// We could add error handling here...
							$result = $db->sql_query($sql);
							if (!($result))
							{
								mx_message_die(CRITICAL_ERROR, "Could not info", '', __LINE__, __FILE__, $sql);
							}
						}
					}
				}
			}
		}

		return;
	}
	
	/**
 	* get_auth_forum
 	*
 	* @param unknown_type $mode
 	* @return unknown
 	*/
	function get_auth_forum($mode = 'phpbb')
	{
		global $userdata, $mx_root_path, $phpEx;
		static $auth_data_sql;
		//
		// Try to reuse auth_view query result.
		//
		$userdata_key = 'mx_get_auth_' . $mode . $userdata['user_id'];
		if( !empty($userdata[$userdata_key]) )
		{
			$auth_data_sql = $userdata[$userdata_key];
			return $auth_data_sql;
		}
		//
		// Now, this tries to optimize DB access involved in auth(),
		// passing AUTH_LIST_ALL will load info for all forums at once.
		// Start auth check
		if (!$is_auth_ary = $this->acl_getf('f_read', false))
		{
			if ($user->data['user_id'] != ANONYMOUS)
			{
				//trigger_error('SORRY_AUTH_READ');
				$auth_data_sql = false;
			}
			//login_box('', $user->lang['LOGIN_VIEWFORUM']);
			$auth_data_sql = $this->acl_getf_global('m_');			
		}
		//
		// Loop through the list of forums to retrieve the ids for
		// those with AUTH_VIEW allowed.
		//
		foreach( $is_auth_ary as $fid => $is_auth_row )
		{
			if( ($is_auth_row['f_read']) )
			{
				$auth_data_sql .= ( $auth_data_sql != '' ) ? ', ' . $fid : $fid;
			}
		}
		if( empty($auth_data_sql) )
		{
			$auth_data_sql = 0;			
		}
		$userdata[$userdata_key] = $auth_data_sql;
		return $auth_data_sql;
	}

	/**
	* function acl_getfignore()
	* $auth_level_read can be a value or array;
	* $ignore_forum_ids can have this sintax: forum_id(1), forum_id(2), ..., forum_is(n);
	* 1st test 25.06.2008 by FlorinCB
	 */
	function acl_getfignore($auth_level_read, $ignore_forum_ids)
	{
		global $phpbb_root_path, $mx_user;

		$ignore_forum_ids = ($ignore_forum_ids) ? $ignore_forum_ids : '';

		$auth_user = array();

		if (is_array($auth_level_read))
		{
			foreach ($auth_level_read as $auth_level)
			{
				$auth_user = $this->acl_getf('!' . $auth_level, true);

				if ($num_forums = count($auth_user))
				{
					while ( list($forum_id, $auth_mod) = each($auth_user) )
					{
						$unauthed = false;

						if (!$auth_mod[$auth_level] && ( strstr($ignore_forum_ids,$auth_mod['forum_id']) === FALSE))
						{
							$unauthed = true;
						}

						if ($unauthed)
						{
							$ignore_forum_ids .= ($ignore_forum_ids) ? ',' . $forum_id : $forum_id;
						}
					}
				}
				unset($auth_level_read);
			}
		}
		elseif ($auth_level_read)
		{
			$auth_user = $this->acl_getf('!' . $auth_level_read, true);

			if ($num_forums = count($auth_user))
			{
				while ( list($forum_id, $auth_mod) = each($auth_user) )
				{
					$unauthed = false;

					if (!$auth_mod[$auth_level] && ( strstr($ignore_forum_ids,$auth_mod['forum_id']) === FALSE))
					{
						$unauthed = true;
					}

					if ($unauthed)
					{
						$ignore_forum_ids .= ($ignore_forum_ids) ? ',' . $forum_id : $forum_id;
					}
				}
			}

		}
		$ignore_forum_ids = ($ignore_forum_ids) ? $ignore_forum_ids : 0;
		return $ignore_forum_ids;
	}
	
	/**
	* Retrieves data wanted by acl function from the database for the
	* specified user.
	*
	* @param int $user_id User ID
	* @return array User attributes
	*/
	public function obtain_user_data($user_id)
	{
		global $db;

		$sql = 'SELECT u.user_id, u.username, u.user_permissions, u.user_type, u.user_id as user_colour, u.user_level as user_type, u.user_avatar as avatar, u.user_avatar_type as avatar_type
			FROM ' . USERS_TABLE . ' u
			WHERE user_id = ' . $user_id;
		if (!($result = $db->sql_query($sql)))
		{
			mx_message_die(CRITICAL_ERROR, 'Could not query user info');
		}		
		$user_data = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		return $user_data;
	}

	/**
	* Fill ACL array with relevant bitstrings from user_permissions column
	* @access private
	*/
	function _fill_acl($user_permissions)
	{
		$seq_cache = array();
		$this->acl = array();
		$user_permissions = explode("\n", $user_permissions);

		foreach ($user_permissions as $f => $seq)
		{
			if ($seq)
			{
				$i = 0;

				if (!isset($this->acl[$f]))
				{
					$this->acl[$f] = '';
				}

				while ($subseq = substr($seq, $i, 6))
				{
					if (isset($seq_cache[$subseq]))
					{
						$converted = $seq_cache[$subseq];
					}
					else
					{
						$converted = $seq_cache[$subseq] = str_pad(base_convert($subseq, 36, 2), 31, 0, STR_PAD_LEFT);
					}

					// We put the original bitstring into the acl array
					$this->acl[$f] .= $converted;
					$i += 6;
				}
			}
		}
	}
 
	/**
	* Look up an option
	* if the option is prefixed with !, then the result becomes negated
	*
	* If a forum id is specified the local option will be combined with a global option if one exist.
	* If a forum id is not specified, only the global option will be checked.
	*/
	function acl_get($opt, $f = 0)
	{
		global $mx_user;
		
		$negate = false;

		if (strpos($opt, '!') === 0)
		{
			$negate = true;
			$opt = substr($opt, 1);
		}

		if (!isset($this->cache[$f][$opt]))
		{
			// We combine the global/local option with an OR because some options are global and local.
			// If the user has the global permission the local one is true too and vice versa
			$this->cache[$f][$opt] = false;

			// Is this option a global permission setting?
			if (isset($this->acl_options['global'][$opt]))
			{
				if (isset($this->acl[0]))
				{
					$this->cache[$f][$opt] = $this->acl[0][$this->acl_options['global'][$opt]];
				}
			}

			// Is this option a local permission setting?
			// But if we check for a global option only, we won't combine the options...
			if (($f != 0) && isset($this->acl_options['local'][$opt]))
			{
				if (isset($this->acl[$f]) && isset($this->acl[$f][$this->acl_options['local'][$opt]]))
				{
					$this->cache[$f][$opt] |= $this->acl[$f][$this->acl_options['local'][$opt]];
				}
			}
		}
		
		//'124' => 'u_viewonline', 
		//'125' => 'u_viewprofile', 		
		if (strpos($opt, 'u_view') === 0)
		{
			$this->cache[$f][$opt] = ($mx_user->data['user_id'] != ANONYMOUS) ? true : false;
		}
		
		//'89' => 'a_viewauth', 
		//'90' => 'a_viewlogs', 
		if (strpos($opt, 'a_view') === 0)
		{
			$this->cache[$f][$opt] = ($mx_user->data['user_level'] == ADMIN) ? true : false;
		}
		
		// Founder always has all global options set to true...
		return ($negate) ? !$this->cache[$f][$opt] : $this->cache[$f][$opt];
	}

	/**
	* Get forums with the specified permission setting
	* if the option is prefixed with !, then the result becomes nagated
	*
	* @param bool $clean set to true if only values needs to be returned which are set/unset
	*/
	function acl_getf($opt, $clean = false)
	{
		$acl_f = array();
		$negate = false;

		if (strpos($opt, '!') === 0)
		{
			$negate = true;
			$opt = substr($opt, 1);
		}

		// If we retrieve a list of forums not having permissions in, we need to get every forum_id
		if ($negate)
		{
			if ($this->acl_forum_ids === false)
			{
				global $db;

				$sql = 'SELECT forum_id
					FROM ' . FORUMS_TABLE;

				if (sizeof($this->acl))
				{
					$sql .= ' WHERE ' . $db->sql_in_set('forum_id', array_keys($this->acl), true);
				}
				if (!$result = $db->sql_query($sql))
				{
					mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
				}

				$this->acl_forum_ids = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$this->acl_forum_ids[] = $row['forum_id'];
				}
				$db->sql_freeresult($result);
			}
		}

		if (isset($this->acl_options['local'][$opt]))
		{
			foreach ($this->acl as $f => $bitstring)
			{
				// Skip global settings
				if (!$f)
				{
					continue;
				}

				$allowed = (!isset($this->cache[$f][$opt])) ? $this->acl_get($opt, $f) : $this->cache[$f][$opt];

				if (!$clean)
				{
					$acl_f[$f][$opt] = ($negate) ? !$allowed : $allowed;
				}
				else
				{
					if (($negate && !$allowed) || (!$negate && $allowed))
					{
						$acl_f[$f][$opt] = 1;
					}
				}
			}
		}

		// If we get forum_ids not having this permission, we need to fill the remaining parts
		if ($negate && sizeof($this->acl_forum_ids))
		{
			foreach ($this->acl_forum_ids as $f)
			{
				$acl_f[$f][$opt] = 1;
			}
		}

		return $acl_f;
	}

	/**
	* Get local permission state for any forum.
	*
	* Returns true if user has the permission in one or more forums, false if in no forum.
	* If global option is checked it returns the global state (same as acl_get($opt))
	* Local option has precedence...
	*/
	function acl_getf_global($opt)
	{
		if (is_array($opt))
		{
			// evaluates to true as soon as acl_getf_global is true for one option
			foreach ($opt as $check_option)
			{
				if ($this->acl_getf_global($check_option))
				{
					return true;
				}
			}

			return false;
		}

		if (isset($this->acl_options['local'][$opt]))
		{
			foreach ($this->acl as $f => $bitstring)
			{
				// Skip global settings
				if (!$f)
				{
					continue;
				}

				// as soon as the user has any permission we're done so return true
				if ((!isset($this->cache[$f][$opt])) ? $this->acl_get($opt, $f) : $this->cache[$f][$opt])
				{
					return true;
				}
			}
		}
		else if (isset($this->acl_options['global'][$opt]))
		{
			return $this->acl_get($opt);
		}

		return false;
	}

	/**
	* Get permission settings (more than one)
	*/
	function acl_gets()
	{
		$args = func_get_args();
		$f = array_pop($args);

		if (!is_numeric($f))
		{
			$args[] = $f;
			$f = 0;
		}

		// alternate syntax: acl_gets(array('m_', 'a_'), $forum_id)
		if (is_array($args[0]))
		{
			$args = $args[0];
		}

		$acl = 0;
		foreach ($args as $opt)
		{
			$acl |= $this->acl_get($opt, $f);
		}

		return $acl;
	}

	/**
	* Get permission listing based on user_id/options/forum_ids
	*/
	function acl_get_list($user_id = false, $opts = false, $forum_id = false)
	{
		if ($user_id !== false && !is_array($user_id) && $opts === false && $forum_id === false)
		{
			$hold_ary = array($user_id => $this->acl_raw_data_single_user($user_id));
		}
		else
		{
			$hold_ary = $this->acl_raw_data($user_id, $opts, $forum_id);
		}

		$auth_ary = array();
		foreach ($hold_ary as $user_id => $forum_ary)
		{
			foreach ($forum_ary as $forum_id => $auth_option_ary)
			{
				foreach ($auth_option_ary as $auth_option => $auth_setting)
				{
					if ($auth_setting)
					{
						$auth_ary[$forum_id][$auth_option][] = $user_id;
					}
				}
			}
		}

		return $auth_ary;
	}
	
	/**
	* Get raw acl data based on user for caching user_permissions
	* This function returns the same data as acl_raw_data(), but without the user id as the first key within the array.
	*/
	function acl_raw_data_single_user($user_id)
	{
		global $db, $mx_cache;

		// Check if the role-cache is there
		if (($this->role_cache = $mx_cache->get('_role_cache')) === false)
		{
			$this->role_cache = array();

			// We pre-fetch roles
			$sql = 'SELECT *
				FROM ' . ACL_ROLES_DATA_TABLE . '
				ORDER BY role_id ASC';
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				$this->role_cache[$row['role_id']][$row['auth_option_id']] = (int) $row['auth_setting'];
			}
			$db->sql_freeresult($result);

			foreach ($this->role_cache as $role_id => $role_options)
			{
				$this->role_cache[$role_id] = serialize($role_options);
			}

			$mx_cache->put('_role_cache', $this->role_cache);
		}

		$hold_ary = array();

		// Grab user-specific permission settings
		$sql = 'SELECT forum_id, auth_option_id, auth_role_id, auth_setting
			FROM ' . ACL_USERS_TABLE . '
			WHERE user_id = ' . $user_id;
		if (!$result = $db->sql_query($sql))
		{
			mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
		}

		while ($row = $db->sql_fetchrow($result))
		{
			// If a role is assigned, assign all options included within this role. Else, only set this one option.
			if ($row['auth_role_id'])
			{
				$hold_ary[$row['forum_id']] = (empty($hold_ary[$row['forum_id']])) ? unserialize($this->role_cache[$row['auth_role_id']]) : $hold_ary[$row['forum_id']] + unserialize($this->role_cache[$row['auth_role_id']]);
			}
			else
			{
				$hold_ary[$row['forum_id']][$row['auth_option_id']] = $row['auth_setting'];
			}
		}
		$db->sql_freeresult($result);

		// Now grab group-specific permission settings
		$sql = 'SELECT a.forum_id, a.auth_option_id, a.auth_role_id, a.auth_setting
			FROM ' . ACL_GROUPS_TABLE . ' a, ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
			WHERE a.group_id = ug.group_id
				AND g.group_id = ug.group_id
				AND ug.user_pending = 0
				AND NOT (ug.group_leader = 1 AND g.group_skip_auth = 1)
				AND ug.user_id = ' . $user_id;
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

		while ($row = $db->sql_fetchrow($result))
		{
			if (!$row['auth_role_id'])
			{
				$this->_set_group_hold_ary($hold_ary[$row['forum_id']], $row['auth_option_id'], $row['auth_setting']);
			}
			else if (!empty($this->role_cache[$row['auth_role_id']]))
			{
				foreach (unserialize($this->role_cache[$row['auth_role_id']]) as $option_id => $setting)
				{
					$this->_set_group_hold_ary($hold_ary[$row['forum_id']], $option_id, $setting);
				}
			}
		}
		$db->sql_freeresult($result);

		return $hold_ary;
	}

}

/**
* Backend specific tasks
* @package MX-Publisher
*/
class mx_backend
{
	//
	// XS Template - use backend db settings
	//
	var $edit_db = true;
	var $page_id = 1;
	var $user_ip = 'ffffff';
	
	/***/
	function mx_backend()
	{	
		// Obtain and encode users IP
		// from MXP 2.7.x common
		// I'm removing HTTP_X_FORWARDED_FOR ... this may well cause other problems such as
		// private range IP's appearing instead of the guilty routable IP, tough, don't
		// even bother complaining ... go scream and shout at the idiots out there who feel
		// "clever" is doing harm rather than good ... karma is a great thing ... :)
		//
		$this->client_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : getenv('REMOTE_ADDR') );
		$ip_sep = explode('.', $this->client_ip);
		$this->user_ip = sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);	
	}	
	/***/
	 
	/**
	 * Validate backend
	 *
	 * Define Users/Group/Sessions backend, and validate
	 * Set $phpbb_root_path, $tplEx, $table_prefix
	 *
	 */
	function validate_backend($cache_config = array())
	{
		global $db, $phpbb_root_path, $mx_root_path;
		global $phpEx, $tplEx, $portal_config;
		global $dbms, $dbhost, $dbname, $dbuser, $dbpasswd, $table_prefix;
		
		$backend_table_prefix = '';
		
		//
		// Define backend template extension
		//
		$tplEx = 'html';
		
		$portal_config = is_array($cache_config) ? $cache_config : $portal_config;
		
		//
		// Define relative path to phpBB, and validate
		//
		$phpbb_root_path = $phpbb_root_path ? $phpbb_root_path : $mx_root_path . $portal_config['portal_backend_path'];
		str_replace("//", "/", $phpbb_root_path);
		$portal_backend_valid_file = @file_exists($phpbb_root_path . "mcp.$phpEx");
		
		//
		// Load phpbb config.php (to get table prefix)
		// If this fails MXP2 will not work
		//
		if ((is_file($phpbb_root_path . "config.$phpEx") == true))
		{
			$backend_info = $this->get_phpbb_info($phpbb_root_path . "config.$phpEx");
			
			// phpBB x.x auto-generated config file
			// Do not change anything in this file!
			$mx_dbms 			= $dbms;
			$mx_dbhost 		= $dbhost; 
			$mx_dbname 		= $dbname; 
			$mx_dbuser 		= $dbuser; 
			$mx_dbpasswd 	= $dbpasswd; 
			$mx_table_prefix	= $table_prefix;
			
			$dbms 			= $backend_info['dbms'];
			$dbhost 			= $backend_info['dbhost'];
			
			$dbms = $this->get_keys_sufix($dbms);
			$acm_type = $this->get_keys_sufix($acm_type);
			
			$dbname 		= $backend_info['dbname'];
			$dbuser 			= $backend_info['dbuser'];
			$dbpasswd 		= $backend_info['dbpasswd'];
			$table_prefix 	= $backend_info['table_prefix'];
			
			if( !isset($backend_info['dbms']) || empty($backend_info['dbms']) || $backend_info['dbhost'] != $dbhost || $backend_info['dbname'] != $dbname || $backend_info['dbuser'] != $dbuser || $backend_info['dbpasswd'] != $dbpasswd || $backend_info['table_prefix'] != $table_prefix )
			{
				if ((include $phpbb_root_path . "config.$phpEx") === false)
				{
					print('mx_backend::validate_backend(); Configuration file (config) for  '. basename( __DIR__  ) . ' ' . $phpbb_root_path . "/config.$phpEx" . ' couldn\'t be opened.');
				}
			}
			
			//
			// Validate db connection for backend
			//
			if ($mx_dbms !== $dbms)
			{
				require($mx_root_path . INCLUDES . 'db/' . $dbms . '.' . $phpEx); // Load dbal and initiate class
			}
		
			if (($mx_dbhost !== $dbhost) || ($mx_dbname !== $dbname))
			{
				if(!$db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, false))
				{
					mx_message_die(CRITICAL_ERROR, "Could not connect to the backend database");
				}
			}
			
			$sql = "SELECT config_value from " . $table_prefix . "config WHERE config_name = 'cookie_domain'";
			if(!$_result = $db->sql_query($sql))
			{
				print('Configuration file opened but backend check query failed for backend: SELECT config_value');
			}
			$portal_backend_valid_db = $db->sql_numrows($_result) != 0;
		}
		else
		{			
			print('Configuration file for this backend (config) ' . $phpbb_root_path . "config.$phpEx" . ' couldn\'t be opened.');

			if ((include $phpbb_root_path . "config.$phpEx") === false)
			{
				print('Configuration file (config) ' . $phpbb_root_path . "/config.$phpEx" . ' couldn\'t be opened.');
			}
			//
			// Validate db connection for backend
			//
			$_result = $db->sql_query( "SELECT config_value from " . $table_prefix . "config WHERE config_name = 'cookie_domain'" );
			$portal_backend_valid_db = $db->sql_numrows($_result) != 0;
		}
		
		return $portal_backend_valid_file && !empty($table_prefix) && $portal_backend_valid_db;
	}

	/**
	 * $mx_backend->setup_backend()
	 *
	 * Define some general backend definitions
	 * PORTAL_URL, PHPBB_URL, PORTAL_VERSION & $board_config
	 *
	 */
	function setup_backend()
	{
		global $portal_config, $board_config, $phpbb_root_path, $phpEx;
		
		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($portal_config['script_path']));
		$server_name = trim($portal_config['server_name']);
		$server_protocol = ( $portal_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = (($portal_config['server_port']) && ($portal_config['server_port'] <> 80)) ? ':' . trim($portal_config['server_port']) . '/' : '/';

		$server_url = $server_protocol . str_replace("//", "/", $server_name . $server_port . $script_name . '/'); //On some server the slash is not added and this trick will fix it

		define('PORTAL_URL', $server_url);
		define('PORTAL_VERSION', $portal_config['portal_version']);

		//
		// Grab phpBB global variables, re-cache if necessary
		// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the MX-Publisher cache whenever updating phpBB config settings
		// - true: enable cache, false: disable cache
		$board_config = $this->obtain_phpbb_config(false);
		$script_name_phpbb = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])) . '/';

		$server_url_phpbb = $server_protocol . $server_name . $server_port . $script_name_phpbb;
		define('PHPBB_URL', $server_url_phpbb);
		
		// Check whether the session is still valid if we have one
		$method = basename(trim($board_config['auth_method']));
		
		//
		// Instantiate the mx_auth class
		//$mx_auth = $phpbb_auth = new phpbb_auth();
		
		// Define backend template extension
		$tplEx = 'html';
		if (!defined('TPL_EXT')) define('TPL_EXT', $tplEx);
		//
		// Now sync Configs
		// In phpBB mode, we rely on native phpBB configs, thus we need to sync mxp and phpbb settings
		//
		$this->sync_configs();
	}

	/**
	 * Sync Configs
	 * @access private
	 */
	function sync_configs()
	{
		global $portal_config, $board_config;

		foreach ($portal_config as $key => $value)
		{
			$do = true;
			switch ($key)
			{
				//
				// Keep phpBB cookies/sessions
				//
				case 'cookie_domain':
				case 'cookie_name':
				case 'cookie_path':
				case 'cookie_secure':
				case 'session_length':
				case 'allow_autologin':
				case 'max_autologin_time':
				case 'max_login_attempts':
				case 'login_reset_time':

					$do = false;
					break;

				//
				// Keep phpBB stats
				//
				case 'record_online_users':
				case 'record_online_date':

					$do = false;
					break;

				//
				// Keep portal settings
				//
				case 'default_style':
				case 'override_user_style':
				case 'default_lang':

				//
				// Keep portal settings
				//
				case 'allow_html':
				case 'allow_html_tags':
				case 'allow_bbcode':
				case 'allow_smilies':
				case 'smilies_path':

				//
				// Keep portal settings
				//
				case 'board_email':
				case 'board_email_sig':
				case 'smtp_delivery':
				case 'smtp_host':
				case 'smtp_username':
				case 'smtp_password':
				case 'smtp_auth_method':

				//
				// Keep portal settings
				//
				case 'default_dateformat':
				case 'board_timezone':
				case 'gzip_compress':

				//
				// Keep portal settings
				//
				case 'portal_id':
				case 'portal_status':
				case 'disabled_message':
				case 'script_path':
				case 'mx_use_cache':
				case 'mod_rewrite':
				case 'default_admin_style':
				case 'overall_header':
				case 'overall_footer':
				case 'main_layout':
				case 'navigation_block':
				case 'top_phpbb_links':
				case 'portal_version':
				case 'portal_recached':
				case 'portal_backend':
				case 'portal_startdate':
				case 'rand_seed':

					break;

				//
				// Rename config keys and get internal sitename/sitedesc
				//
				case 'portal_name':

					$key = 'sitename';
					break;

				case 'portal_desc':

					$key = 'site_desc';
					break;
			}

			if ($do)
			{
				$board_config[$key] = $value;
			}
		}
	}

	/**
	 * load_file
	 *
	 * @param unknown_type $force_shared
	 * @access private
	 */
	function load_file($force_shared)
	{
		global $mx_root_path, $phpbb_root_path, $phpEx;

		if ($force_shared)
		{
			$backend = in_array($force_shared, array('internal', 'phpbb2', 'smf2', 'mybb', 'phpbb3', 'olympus', 'rhea', 'ascraeus', 'proteus')) ? $force_shared : PORTAL_BACKEND;
			switch ($backend)
			{
				case 'internal':
				case 'phpbb2':
				case 'smf2':
				case 'mybb':
					$mx_root_path . 'includes/shared/'.$force_shared.'/includes/';
				break;
					
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
				case 'proteus':
				case 'phpbb3':
					$path = $mx_root_path . 'includes/shared/phpbb3/includes/';
				break;
			}
		}
		else
		{
			$path = $phpbb_root_path . 'includes/';
		}
		return $path;
	}

	/**
	 * get_phpbb_info
	 *
	 * @param unknown_type $root_path
	 * @access private
	 */
	function get_mxp_info($root_path, $backend = 'phpbb2', $phpbbversion = '2.0.24')
	{
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		
		if (strpos($root_path, '.') !== false)
		{
			// Nested file
			$filename_ext = substr(strrchr($root_path, '.'), 1);
			$filename = basename($root_path, '.' . $filename_ext);
			$current_dir = dirname(realpath($root_path));
			$root_path = dirname($root_path);			
		}
		else
		{
			$filename_ext = substr(strrchr(__FILE__, '.'), 1);
			$filename = "config";
			$current_dir = $root_path;
			$root_path = dirname($root_path);			
		}		
		
		$config = $root_path . "/config.$phpEx";
		
		//
		if ((@include $config) === false)
		{
			die('Configuration file ' . $config . ' couldn\'t be opened.');
		}
		
		//
		// Check the prefix length to ensure that index names are not too long and does not contain invalid characters
		switch ($backend)
		{
			case 'internal':
			// no break;
			case 'phpbb2':
				$phpbb_adm_relative_path = 'admin';
			break;
			
			case 'phpbb3':
			case 'rhea':
				$phpbb_adm_relative_path = 'adm';
			break;
			
			case 'ascraeus':
			case 'rhea':
			case 'proteus':
				$phpbb_adm_relative_path = (isset($phpbb_adm_relative_path)) ? $phpbb_adm_relative_path : 'adm/';
				$dbms = get_keys_sufix($dbms);
				$acm_type = get_keys_sufix($acm_type);
			break;
		}
		
		// If we are on PHP < 5.0.0 we need to force include or we get a blank page
		if (version_compare(PHP_VERSION, '5.0.0', '<')) 
		{
			$dbms = str_replace('mysqli', 'mysql4', $dbms); //this version of php does not have mysqli extension and my crash the installer if finds a forum using this		
		}
		
		return array(
			'dbms'					=> $dbms,
			'dbhost'					=> $dbhost,
			'dbname'				=> $dbname,
			'dbuser'					=> $dbuser,
			'dbpasswd'				=> $dbpasswd,
			'mx_table_prefix'		=> $mx_table_prefix,	
			//'table_prefix'	=> $table_prefix,
			'backend'				=> $backend,
			'version'					=> $phpbbversion,
			'acm_type'				=> isset($acm_type) ? $acm_type : '',
			//'phpbb_root_path'		=> $phpbb_root_path,
			'status'					=> defined('MX_INSTALLED') ? true : false,
		);
	}	
	
	/**
	 * get_phpbb_info
	 *
	 * @param unknown_type $root_path
	 * @access private
	 */
	function get_phpbb_info($root_path, $backend = 'phpbb2', $phpbbversion = '2.0.24')
	{
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		
		if (strpos($root_path, '.') !== false)
		{
			// Nested file
			$filename_ext = substr(strrchr($root_path, '.'), 1);
			$filename = basename($root_path, '.' . $filename_ext);
			$current_dir = dirname(realpath($root_path));
			$root_path = dirname($root_path);			
		}
		else		
		{
			$filename_ext = substr(strrchr(__FILE__, '.'), 1);
			$filename = "config";
			$current_dir = $root_path;
			$root_path = dirname($root_path);			
		}		
		
		$config = $root_path . "/config.$phpEx";
		
		//
		if ((@include $config) === false)
		{
			die('Configuration file ' . $config . ' couldn\'t be opened.');
		}
		//
		
		if ((@include $root_path . "language/en/install.$phpEx") !== false)
		{
			$left_piece1 = explode('. You', $lang['CONVERT_COMPLETE_EXPLAIN']);	
			$left_piece2 = explode('phpBB', $left_piece1[0]);
			$phpbbversion = strrchr($left_piece2[1], ' ');
			
			switch (true)
			{
				case (preg_match('/3.0/i', $phpbbversion)):
					$backend = 'olympus';
				break;
				case (preg_match('/3.1/i', $phpbbversion)):
					$backend = 'ascraeus';
				break;
				case (preg_match('/3.2/i', $phpbbversion)):
					$backend = 'rhea';
				break;
				case (preg_match('/3.3/i', $phpbbversion)):
					$backend = 'proteus';
				break;
				case (preg_match('/4.0/i', $phpbbversion)):
					$backend = 'phpbb4';
				break;
			}
		}	
		
		// Check the prefix length to ensure that index names are not too long and does not contain invalid characters
		switch ($backend)
		{
			case 'internal':
			// no break;
			case 'phpbb2':
				$phpbb_adm_relative_path = 'admin';
			break;
			
			case 'olympus':
				$phpbb_adm_relative_path = 'adm';
			break;
			
			case 'phpbb3':
			case 'ascraeus':
			case 'rhea':
			case 'proteus':	
				$phpbb_adm_relative_path = (isset($phpbb_adm_relative_path)) ? $phpbb_adm_relative_path : 'adm/';
				$dbms = get_keys_sufix($dbms);
				$acm_type = get_keys_sufix($acm_type);
			break;
		}
		
		// If we are on PHP < 5.0.0 we need to force include or we get a blank page
		if (version_compare(PHP_VERSION, '5.0.0', '<')) 
		{
			$dbms = str_replace('mysqli', 'mysql4', $dbms); //this version of php does not have mysqli extension and my crash the installer if finds a forum using this		
		}
		
		return array(
			'dbms'			=> $dbms,
			'dbhost'			=> $dbhost,
			'dbname'		=> $dbname,
			'dbuser'			=> $dbuser,
			'dbpasswd'		=> $dbpasswd,
			'table_prefix'	=> $table_prefix,
			'backend'		=> $backend,
			'version'			=> $phpbbversion,
			'acm_type'		=> isset($acm_type) ? $acm_type : '',
			'status'			=> defined('PHPBB_INSTALLED') ? true : false,
		);
	}
	
	/**
	 * get_smf_info
	 *
	 * @param unknown_type $settings
	 * @access private
	 * /
	function get_smf_info($settings)
	{
		if ((@include $settings) === false)
		{
			install_die(GENERAL_ERROR, 'Configuration file ' . $settings . ' couldn\'t be opened.');
		}	
		// If we are on PHP < 5.0.0 we need to force include or we get a blank page
		if (version_compare(PHP_VERSION, '5.0.0', '<')) 
		{		
			$db_type = str_replace('mysqli', 'mysql4', $db_type); //this version of php does not have mysqli extension and my crash the installer if finds a forum using this		
		}
		// If the UTF-8 setting was enabled, add it to the table definitions.
		if ($db_character_set == 'utf8') 
		{		
			$db_type = str_replace('mysql', 'mysql4', $db_type);		
		}	
		return array(
			'dbms'				=> $db_type, // 'mysql'
			'dbhost'			=> $db_server, // 'localhost';
			'dbname'			=> $dbname, // 'smf';
			'dbuser'			=> $db_user, // 'root';
			'dbpasswd'			=> $db_passwd, // '';
			'ssi_dbuser'		=> $ssi_db_user, // '';
			'ssi_dbpasswd'		=> $ssi_db_passwd, // '';
			'table_prefix'		=> $db_prefix, // 'smf_';
			'dbpersist'			=> $db_persist, // 0;
			'dberror_send'		=> $db_error_send, // 1;
			'dbcharacter_set'	=> $db_character_set,		
			'acm_type'			=> '',
			'mtitle'			=> $mtitle, //# Title for the Maintenance Mode message.
			'status'			=> ($maintenance != 2) ? true : false, # Set to 1 to enable Maintenance Mode, 2 to make the forum untouchable. (you'll have to make it 0 again manually!)
			'mbname'			=> $mbname, # The name of your forum.
			'language'			=> $language, // 'english';		# The default language file set for the forum.
			'boardurl'			=> $boardurl, // 'http://127.0.0.1/smf';		# URL to your forum's folder. (without the trailing /!)
			'webmaster_email'	=> $webmaster_email, // 'noreply@myserver.com';		# Email address to send emails from. (like noreply@yourdomain.com.)
			'cookiename'		=> $cookiename,	
		);
	}
	
	/**
	 * get_mybb_info
	 *
	 * @param unknown_type $mybb_config
	 * @access private
	 * /
	function get_mybb_info($mybb_config)
	{
		$config = array();
		if ((@include $mybb_config) === false)
		{
			install_die(GENERAL_ERROR, 'Configuration file ' . $mybb_config . ' couldn\'t be opened.');
		}	
		return array(
			'dbms'				=> $config['database']['type'], // 'mysqli';
			'dbname'			=> $config['database']['database'], // 'mybb';
			'table_prefix'		=> $config['database']['table_prefix'], // 'mybb_';

			'dbhost'			=> $config['database']['hostname'], // 'localhost';
			'dbname'			=> $config['database']['username'], // 'Admin';
			'dbpasswd'			=> $config['database']['password'],
			
			'admin_dir'			=> $config['admin_dir'],
			'dbcharacter_set'	=> $config['database']['encoding'],			
		);
	}	
	
	/**
	 * dss_rand
	 *
	 * @param unknown_type $force_shared
	 * @access private
	 */
	function dss_rand()
	{
		global $db, $portal_config, $board_config, $dss_seeded;
		
		$val = $board_config['rand_seed'] . microtime();
		$val = md5($val);
		$board_config['rand_seed'] = md5($board_config['rand_seed'] . $val . 'a');
		
		if($dss_seeded !== true)
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . $board_config['rand_seed'] . "'
				WHERE config_name = 'rand_seed'";
			//display an error debuging message only if the portal is installed/upgraded 
			if(!@$db->sql_query($sql) && @!file_exists('install'))
			{
				mx_message_die(GENERAL_ERROR, "Unable to reseed PRNG", "", __LINE__, __FILE__, $sql);
			}
			elseif(!@$db->sql_query($sql) && @file_exists('install'))
			{
				mx_message_die(GENERAL_ERROR, "Unable to reseed PRNG"."<br />Please finish upgrading and <br />". t(isset($lang['Please_remove_install_contrib'])), "", __LINE__, __FILE__, $sql);
			}
			$dss_seeded = true;
		}
		return substr($val, 4, 16);
	}

	function make_jumpbox($action, $match_forum_id = 0)
	{
		global $template, $userdata, $lang, $db, $nav_links, $phpEx, $SID;

		$sql = 'SELECT forum_id, forum_name, parent_id, forum_type, left_id, right_id
			FROM ' . FORUMS_TABLE . '
			ORDER BY left_id ASC';
		$result = $db->sql_query($sql, 600);

		$right = $padding = 0;
		$padding_store = array('0' => 0);
		$display_jumpbox = false;
		$iteration = 0;

		// Sometimes it could happen that forums will be displayed here not be displayed within the index page
		// This is the result of forums not displayed at index, having list permissions and a parent of a forum with no permissions.
		// If this happens, the padding could be "broken"

		$forum_rows = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$forum_rows[] = $row;

			if ($forum_rows['left_id'] < $right)
			{
				$padding++;
				$padding_store[$row['parent_id']] = $padding;
			}
			else if ($row['left_id'] > $right + 1)
			{
				// Ok, if the $padding_store for this parent is empty there is something wrong. For now we will skip over it.
				// @todo digging deep to find out "how" this can happen.
				$padding = (isset($padding_store[$row['parent_id']])) ? $padding_store[$row['parent_id']] : $padding;
			}

			$right = $forum_rows['right_id'];

			if ($forum_rows['forum_type'] == FORUM_CAT && ($forum_rows['left_id'] + 1 == $forum_rows['right_id']))
			{
				// Non-postable forum with no subforums, don't display
				continue;
			}

			if ( $total_forums = count($forum_rows) )
			{
				for($i = 0; $i < $total_categories; $i++)
				{
					$boxstring_forums = '';
					for($j = 0; $j < $total_forums; $j++)
					{
					 	$selected = ( $forum_rows[$j]['forum_id'] == $match_forum_id ) ? 'selected="selected"' : '';
						$boxstring_forums .=  '<option value="' . $forum_rows[$j]['forum_id'] . '"' . $selected . '>' . $forum_rows[$j]['forum_name'] . '</option>';

						//
						// Add an array to $nav_links for the Mozilla navigation bar.
						// 'chapter' and 'forum' can create multiple items, therefore we are using a nested array.
						//
						$nav_links['chapter forum'][$forum_rows[$j]['forum_id']] = array (
							'url' => mx_append_sid(PHPBB_URL . "viewforum.$phpEx?" . POST_FORUM_URL . "=" . $forum_rows[$j]['forum_id']),
							'title' => $forum_rows[$j]['forum_name']
						);

					}

					if ( $boxstring_forums != '' )
					{
						$boxstring .= '<option value="-1">&nbsp;</option>';
						$boxstring .= '<option value="-1">' . $forum_rows[$i]['forum_type'] == FORUM_CAT . '</option>';
						$boxstring .= '<option value="-1">----------------</option>';
						$boxstring .= $boxstring_forums;
					}
				}
			}

			$boxstring .= '</select>';
		}

		// Let the jumpbox work again in sites having additional session id checks.
		// if ( !empty($SID) )
		// {
				$boxstring .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
		// }

		$template->set_filenames(array(
			'jumpbox' => 'jumpbox.tpl')
		);

		$template->assign_vars(array(
			'L_GO' => $lang['Go'],
			'L_JUMP_TO' => $lang['Jump_to'],
			'L_SELECT_FORUM' => $lang['Select_forum'],

			'S_JUMPBOX_SELECT' => $boxstring,
			'S_JUMPBOX_ACTION' => mx_append_sid($action),
			'S_FORUM_COUNT'	=> $j)
		);

		$template->assign_var_from_handle('JUMPBOX', 'jumpbox');

		return;
	}

	/**
	 * Backend specific Page Header data
	 *
	 * @param unknown_type $mode
	 */
	function page_header($mode = false)
	{
		global $db, $mx_root_path, $phpbb_root_path, $userdata, $mx_user, $lang, $images, $phpEx;
		global $board_config, $gen_simple_header, $layouttemplate, $mx_page, $phpBB2;

		switch ($mode)
		{
			case 'generate_login_logout_stats':

				if ( $mx_user->data['user_id'] != 1 )
				{
					$is_logged = true;
					$u_login_logout = 'login.'.$phpEx.'?logout=true&amp;sid=' . $mx_user->data['session_id'];
					$l_login_logout = $lang['Logout'] . ' [ ' . $mx_user->data['username'] . ' ]';
				}
				else
				{
					$is_logged = false;
					$u_login_logout = 'login.'.$phpEx;
					$l_login_logout = $lang['Login'];
				}
				$s_last_visit = ( $mx_user->data['session_logged_in'] ) ? $phpBB2->create_date($board_config['default_dateformat'], $mx_user->data['user_lastvisit'], $board_config['board_timezone']) : '';

				//
				// Obtain number of new private messages
				// if user is logged in
				//
				if ( ($mx_user->data['session_logged_in']) && (empty($gen_simple_header)) )
				{
					if ( $mx_user->data['user_new_privmsg'] )
					{
						$l_message_new = ( $mx_user->data['user_new_privmsg'] == 1 ) ? $lang['New_pm'] : $lang['New_pms'];
						$l_privmsgs_text = sprintf($l_message_new, $mx_user->data['user_new_privmsg']);

						if ( $mx_user->data['user_last_privmsg'] > $mx_user->data['user_lastvisit'] )
						{
							$sql = "UPDATE " . USERS_TABLE . "
								SET user_last_privmsg = " . $mx_user->data['user_lastvisit'] . "
								WHERE user_id = " . $mx_user->data['user_id'];
							if ( !$db->sql_query($sql) )
							{
								mx_message_die(GENERAL_ERROR, 'Could not update private message new/read time for user', '', __LINE__, __FILE__, $sql);
							}

							$s_privmsg_new = 1;
							$icon_pm = $images['pm_new_msg'];
						}
						else
						{
							$s_privmsg_new = 0;
							$icon_pm = $images['pm_no_new_msg'];
						}
						$mx_priv_msg = $lang['Private_Messages'] . ' (' . $mx_user->data['user_new_privmsg'] . ')';
					}
					else
					{
						$l_privmsgs_text = $lang['No_new_pm'];

						$s_privmsg_new = 0;
						$icon_pm = $images['pm_no_new_msg'];
						$mx_priv_msg = $lang['Private_Messages'];
					}

					if ( $mx_user->data['user_unread_privmsg'] )
					{
						$l_message_unread = ( $mx_user->data['user_unread_privmsg'] == 1 ) ? $lang['Unread_pm'] : $lang['Unread_pms'];
						$l_privmsgs_text_unread = sprintf($l_message_unread, $mx_user->data['user_unread_privmsg']);
					}
					else
					{
						$l_privmsgs_text_unread = $lang['No_unread_pm'];
					}
				}
				else
				{
					$icon_pm = $images['pm_no_new_msg'];
					$l_privmsgs_text = $lang['Login_check_pm'];
					$l_privmsgs_text_unread = '';
					$s_privmsg_new = 0;
					$mx_priv_msg = $lang['Private_Messages'];
				}

				$layouttemplate->assign_vars(array(
					'U_LOGIN_LOGOUT' => mx_append_sid(PORTAL_URL . $u_login_logout),
					'L_LOGIN_LOGOUT' => $l_login_logout,
					'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], $s_last_visit),
					'PRIVATE_MESSAGE_INFO' => $l_privmsgs_text,
					'PRIVATE_MESSAGE_INFO_UNREAD' => $l_privmsgs_text_unread,
					'PRIVATE_MESSAGE_NEW_FLAG' => $s_privmsg_new,
					'PRIVMSG_IMG' => $icon_pm,
					'L_PRIVATEMSGS' => $mx_priv_msg,

					// Backend
					'PHPBB' => true,

					// Show phpbb stats?
					'PHPBB_STATS' => $mx_page->phpbb_stats,

					// Allow autologin?
					'ALLOW_AUTOLOGIN' => !$userdata['session_logged_in'] && (!isset($board_config['allow_autologin']) || $board_config['allow_autologin']),

					// phpBB PM
					'ENABLE_PM_POPUP' => $userdata['session_logged_in'] && !empty($userdata['user_popup_pm']),
				));

				break;

			case 'generate_nav_links':

				$u_register = 'ucp.'.$phpEx.'?mode=register';
				$u_profile = 'ucp.'.$phpEx;
				$u_privatemsgs = 'ucp.'.$phpEx.'?i=pm&folder=inbox';
				$u_privatemsgs_popup ='ucp.'.$phpEx.'?i=pm&mode=popup';
				$u_search = 'search.'.$phpEx;
				$u_memberlist = 'memberlist.'.$phpEx;
				$u_modcp = 'mcp.'.$phpEx;
				$u_faq = 'faq.'.$phpEx;
				$u_viewonline = 'viewonline.'.$phpEx;
				$u_group_cp = 'ucp.'.$phpEx.'?i=167';
				$u_sendpassword = ($board_config['email_enable']) ? mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=sendpassword') : '';

				$layouttemplate->assign_vars(array(
					'U_REGISTER' => mx_append_sid(PHPBB_URL . $u_register),
					'U_PROFILE' => mx_append_sid(PHPBB_URL . $u_profile),
					'U_PRIVATEMSGS' => mx_append_sid(PHPBB_URL . $u_privatemsgs),
					'U_PRIVATEMSGS_POPUP' => mx_append_sid(PHPBB_URL . $u_privatemsgs_popup),
					'U_SEARCH' => mx_append_sid(PHPBB_URL . $u_search),
					'U_MEMBERLIST' =>mx_append_sid(PHPBB_URL . $u_memberlist),
					'U_MODCP' => mx_append_sid(PHPBB_URL . $u_modcp),
					'U_FAQ' => mx_append_sid(PHPBB_URL . $u_faq),
					'U_VIEWONLINE' => mx_append_sid(PHPBB_URL . $u_viewonline),
					'U_GROUP_CP' => mx_append_sid(PHPBB_URL . $u_group_cp),
					'U_SEND_PASSWORD' => $u_sendpassword,
				));

				break;
		}
	}

	/**
	 * Backend specific Page Tail data
	 *
	 * @param unknown_type $mode
	 */
	function page_tail($mode = false)
	{
		global $board_config, $userdata, $template;

		switch ($mode)
		{
			case 'generate_backend_version':
				$current_phpbb_version = $board_config['version'];

				$template->assign_vars(array(
					'PHPBB_BACKEND'				=> true,
					'PHPBB_VERSION' 			=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? $current_phpbb_version : '',
					'U_PHPBB_ROOT_PATH' 		=> PHPBB_URL,
				));

				break;
		}
	}


	/**
	 * obtain_phpbb_config
	 *
	 * @access public
	 * @param boolean $use_cache
	 * @return unknown
	 */
	public function obtain_forum_config()
	{
		global $db, $phpbb_root_path, $table_prefix, $mx_cache, $phpEx;
		
		if (!defined('CONFIG_TABLE'))
		{
			global $table_prefix, $mx_root_path;
				
			require $mx_root_path. "includes/sessions/phpbb2/constants.$phpEx";
		}		
		
		if (($mx_cache->get('phpbb_config')) === false)
		{
			$config = $cached_config = array();
								
			$sql = 'SELECT config_name, config_value, is_dynamic
				FROM ' . CONFIG_TABLE;
			if (!($result = $db->sql_query($sql)))
			{
				if (!function_exists('mx_message_die'))
				{
					die("Couldnt query config information, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
				}
				else
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt query config information', '', __LINE__, __FILE__, $sql );
				}
			}
			
			while ($row = $db->sql_fetchrow($result))
			{
				if (!$row['is_dynamic'])
				{
					$cached_config[$row['config_name']] = $row['config_value'];
				}

				$config[$row['config_name']] = $row['config_value'];
			}
			$db->sql_freeresult($result);

			$mx_cache->put('phpbb_config', $cached_config);
		}
		else
		{
			$sql = 'SELECT config_name, config_value
				FROM ' . CONFIG_TABLE . '
				WHERE is_dynamic = 1';
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				$config[$row['config_name']] = $row['config_value'];
			}
			$db->sql_freeresult($result);
		}		
		
		return $config;
	}

	/**
	* Get key_sufix() from MX Installer
	* we have so far in beta 3
	* $dbms = 'phpbb\\db\\driver\\mysqli';
	* $acm_type = 'phpbb\\cache\\driver\\file';
	* We only need the sufix in this installer
	*/
	function get_keys_sufix($key)
	{
		$keys = explode("\\", $key);

		$i = count($keys) - 1;
		$rkey = $keys[$i];
		$rkey = str_replace("\\", "", $rkey);	

		return (isset($rkey)) ? $rkey : $key;
	}

	/**
	* Set phpbb config values
	 *
	 * @param unknown_type $config_name
	 * @param unknown_type $config_value
	 */
	public function set_forum_config($key, $new_value, $use_cache = false)
	{
		global $db, $mx_cache, $phpEx;
		
		if (!defined('CONFIG_TABLE'))
		{
			global $table_prefix, $mx_root_path;
				
			require $mx_root_path. "includes/sessions/phpbb2/constants.$phpEx";
		}		
		
		// Read out config values
		$config = $this->obtain_phpbb_config();
		$old_value = !isset($config[$key]) ? $config[$key] : false;		
		$use_cache = (($key == 'comments_pagination') || ($key == 'pagination')) ? true : false;
			
		$sql = 'UPDATE ' . CONFIG_TABLE . "
			SET config_value = '" . $db->sql_escape($new_value) . "'
			WHERE config_name = '" . $db->sql_escape($key) . "'";

		if ($old_value !== false)
		{
			$sql .= " AND config_value = '" . $db->sql_escape($old_value) . "'";
		}

		if (!$result = $db->sql_query($sql))
		{
			mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
		}

		if (!$db->sql_affectedrows() && isset($config[$key]))
		{
			return false;
		}

		if (!isset($config[$key]))
		{
			$sql = 'INSERT INTO ' . CONFIG_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				'config_name'	=> $key,
				'config_value'	=> $new_value,
				'is_dynamic'	=> ($use_cache) ? 0 : 1));
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
		}
		
		$config[$key] = $new_value;

		
		if ($use_cache)
		{
			$mx_cache->destroy('config');
			$mx_cache->put('config', $config);			
		}
		
		return true;		
	}	
	
	/**
	 * Get MX-Publisher config data
	 *
	 * @access public
	 * @return unknown
	 */
	public function obtain_portal_config($use_cache = true)
	{
		global $db, $mx_cache;

		if ( ($portal_config = $mx_cache->get('mx_config')) && ($use_cache) )
		{
			return $portal_config;
		}
		else
		{
			$sql = "SELECT *
				FROM " . PORTAL_TABLE . "
				WHERE portal_id = '1'";

			if ( !($result = $db->sql_query($sql)) )
			{
				if (!function_exists('mx_message_die'))
				{
					die("Couldnt query portal configuration, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
				}
				else
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt query portal configuration', '', __LINE__, __FILE__, $sql );
				}
			}
			$row = $db->sql_fetchrow($result);
			foreach ($row as $config_name => $config_value)
			{
				$portal_config[$config_name] = trim($config_value);
			}
			$db->sql_freeresult($result);
			$mx_cache->put('mx_config', $portal_config);

			return ($portal_config);
		}
	}

	/**
	 * obtain_phpbb_config
	 *
	 * @access public
	 * @param boolean $use_cache
	 * @return unknown
	 */
	public function obtain_phpbb_config($use_cache = true)
	{
		global $db, $phpbb_root_path, $table_prefix, $mx_cache, $phpEx;

		if (($config = $mx_cache->get('phpbb_config')) && ($use_cache) )
		{
			return $config;
		}
		else
		{		
			if (!defined('CONFIG_TABLE'))
			{
				global $table_prefix, $mx_root_path;
				
				require $mx_root_path. "includes/sessions/phpbb3/constants.$phpEx";
			}

			$sql = "SELECT *
				FROM " . CONFIG_TABLE;

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				if (!function_exists('mx_message_die'))
				{
					die("Couldnt query config information, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
				}
				else
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt query config information', '', __LINE__, __FILE__, $sql );
				}
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				$config[$row['config_name']] = $row['config_value'];
			}
			$db->sql_freeresult($result);

			if ($use_cache)
			{
				$mx_cache->put('phpbb_config', $config);
			}

			return ( $config );
		}
	}


	/**
	* Set config value. Creates missing config entry.
	*
	*/
	function set_portal_config($key, $new_value)
	{
		global $db, $mx_cache, $portal_config;
		
		// Read out config values
		$portal_config = $this->obtain_portal_config();		
		
		$new[$key] = $new_value;

		$sql = "UPDATE  " . PORTAL_TABLE . " SET " . $db->sql_build_array('UPDATE', utf8_normalize_nfc($new));
		
		if( !($db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Failed to update portal configuration ", "", __LINE__, __FILE__, $sql);
		}
		
		if (!$db->sql_affectedrows() && !isset($portal_config[$key]))
		{
			$sql = 'INSERT INTO ' . PORTAL_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				$db->sql_escape($key) => $db->sql_escape($new_value)));
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}
		}

		$portal_config[$key] = $new_value;

		$mx_cache->destroy('mx_config');
	}	
	
	/**
	 * Get userdata
	 *
	 * Get Userdata, $mx_user can be username or user_id. If force_str is true, the username will be forced.
	 * Cached sql, since this function is used for every block.
	 *
	 * @param unknown_type $mx_user id or name
	 * @param boolean $force_str force clean_username
	 * @return array
	 */
	function get_userdata($mxuser, $force_str = false)
	{
		global $db, $phpBB2;

		if (!is_numeric($mxuser) || $force_str)
		{
			$mx_user = $phpBB2->phpbb_clean_username($mxuser);
		}
		else
		{
			$mx_user = intval($mxuser);
		}

		$sql = "SELECT *
			FROM " . USERS_TABLE . "
			WHERE ";
		$sql .= ((is_integer($mxuser)) ? "user_id = $mxuser" : "username = '" .  str_replace("\'", "''", $mxuser) . "'" ) . " AND user_id <> " . ANONYMOUS;
		if (!($result = $db->sql_query($sql, 120)))
		{
			if (!function_exists('mx_message_die'))
			{
				die("Tried obtaining data for a non-existent user. Function mx_backend->get_userdata()");
			}
			else
			{
				mx_message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
			}
		}
		$return = ($row = $db->sql_fetchrow($result)) ? $row : false;
		/*
		foreach ($row as $user_key => $user_value)
		{
			$userdata[$user_key] = trim($user_value);
		}
		*/
		$db->sql_freeresult($result);
		//return ($userdata);			
		return $return;
	}	
	
	/**
	* Set user data value. 
	*
	*/
	function set_userdata($key, $new_value)
	{
		global $db, $mx_user;
						
		$new[$key] = $new_value;

		$sql = "UPDATE " . USERS_TABLE . "
		SET " . $db->sql_build_array('UPDATE', utf8_normalize_nfc($new)) . "
		WHERE user_id = '" . $mx_user->data['user_id'] . "'";		
		if (!($db->sql_query($sql)))
		{
			mx_message_die(GENERAL_ERROR, "Failed to update portal configuration ", "", __LINE__, __FILE__, $sql);
		}
		
		if (!$db->sql_affectedrows() && !isset($mx_user->data[$key]))
		{
			mx_message_die(GENERAL_ERROR, "Wrong Backend? Adding missing entry key to update MXP configuration  is not supported ATM.", "", __LINE__, __FILE__, $sql);	
		}

		$mx_user->data[$key] = $new_value;
	}	
	/**
	* Obtain ranks
	*/
	public function obtain_ranks()
	{
		global $mx_cache;

		if (($ranks = $mx_cache->get('_ranks')) === false)
		{
			global $db;

			$sql = 'SELECT *
				FROM ' . RANKS_TABLE . '
				ORDER BY rank_min DESC';
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

			$ranks = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if ($row['rank_special'])
				{
					$ranks['special'][$row['rank_id']] = array(
						'rank_title'	=>	$row['rank_title'],
						'rank_image'	=>	$row['rank_image']
					);
				}
				else
				{
					$ranks['normal'][] = array(
						'rank_title'	=>	$row['rank_title'],
						'rank_min'		=>	$row['rank_min'],
						'rank_image'	=>	$row['rank_image']
					);
				}
			}
			$db->sql_freeresult($result);

			$mx_cache->put('_ranks', $ranks);
		}

		return $ranks;
	}

	/**
	* Obtain allowed extensions
	*
	* @param mixed $forum_id If false then check for private messaging, if int then check for forum id. If true, then only return extension informations.
	*
	* @return array allowed extensions array.
	*/
	function obtain_attach_extensions($forum_id)
	{
		global $mx_cache;

		if (($extensions = $mx_cache->get('_extensions')) === false)
		{
			global $db;

			$extensions = array(
				'_allowed_post'	=> array(),
				'_allowed_pm'	=> array(),
			);

			// The rule is to only allow those extensions defined. ;)
			$sql = 'SELECT e.extension, g.*
				FROM ' . EXTENSIONS_TABLE . ' e, ' . EXTENSION_GROUPS_TABLE . ' g
				WHERE e.group_id = g.group_id
					AND (g.allow_group = 1 OR g.allow_in_pm = 1)';
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				$extension = strtolower(trim($row['extension']));

				$extensions[$extension] = array(
					'display_cat'	=> (int) $row['cat_id'],
					'download_mode'	=> (int) $row['download_mode'],
					'upload_icon'	=> trim($row['upload_icon']),
					'max_filesize'	=> (int) $row['max_filesize'],
					'allow_group'	=> $row['allow_group'],
					'allow_in_pm'	=> $row['allow_in_pm'],
				);

				$allowed_forums = ($row['allowed_forums']) ? unserialize(trim($row['allowed_forums'])) : array();

				// Store allowed extensions forum wise
				if ($row['allow_group'])
				{
					$extensions['_allowed_post'][$extension] = (!sizeof($allowed_forums)) ? 0 : $allowed_forums;
				}

				if ($row['allow_in_pm'])
				{
					$extensions['_allowed_pm'][$extension] = 0;
				}
			}
			$db->sql_freeresult($result);

			$mx_cache->put('_extensions', $extensions);
		}

		// Forum post
		if ($forum_id === false)
		{
			// We are checking for private messages, therefore we only need to get the pm extensions...
			$return = array('_allowed_' => array());

			foreach ($extensions['_allowed_pm'] as $extension => $check)
			{
				$return['_allowed_'][$extension] = 0;
				$return[$extension] = $extensions[$extension];
			}

			$extensions = $return;
		}
		else if ($forum_id === true)
		{
			return $extensions;
		}
		else
		{
			$forum_id = (int) $forum_id;
			$return = array('_allowed_' => array());

			foreach ($extensions['_allowed_post'] as $extension => $check)
			{
				// Check for allowed forums
				if (is_array($check))
				{
					$allowed = (!in_array($forum_id, $check)) ? false : true;
				}
				else
				{
					$allowed = true;
				}

				if ($allowed)
				{
					$return['_allowed_'][$extension] = 0;
					$return[$extension] = $extensions[$extension];
				}
			}

			$extensions = $return;
		}

		if (!isset($extensions['_allowed_']))
		{
			$extensions['_allowed_'] = array();
		}

		return $extensions;
	}

	/**
	* Obtain active bots
	*/
	function obtain_bots()
	{
		global $mx_cache;

		if (($bots = $mx_cache->get('_bots')) === false)
		{
			global $db;

			switch ($db->sql_layer)
			{
				case 'mssql':
				case 'mssql_odbc':
					$sql = 'SELECT user_id, bot_agent, bot_ip
						FROM ' . BOTS_TABLE . '
						WHERE bot_active = 1
					ORDER BY LEN(bot_agent) DESC';
				break;

				case 'firebird':
					$sql = 'SELECT user_id, bot_agent, bot_ip
						FROM ' . BOTS_TABLE . '
						WHERE bot_active = 1
					ORDER BY CHAR_LENGTH(bot_agent) DESC';
				break;

				// LENGTH supported by MySQL, IBM DB2 and Oracle for sure...
				default:
					$sql = 'SELECT user_id, bot_agent, bot_ip
						FROM ' . BOTS_TABLE . '
						WHERE bot_active = 1
					ORDER BY LENGTH(bot_agent) DESC';
				break;
			}
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

			$bots = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$bots[] = $row;
			}
			$db->sql_freeresult($result);

			$mx_cache->put('_bots', $bots);
		}

		return $bots;
	}

	/**
	 * Obtain cfg file data
	 *
	 * @param unknown_type $theme
	 * @return unknown
	 */
	function obtain_cfg_items($theme)
	{
		global $board_config, $phpbb_root_path, $mx_cache;

		$parsed_items = array(
			'theme'		=> array(),
			'template'	=> array(),
			'imageset'	=> array()
		);

		foreach ($parsed_items as $key => $parsed_array)
		{
			$parsed_array = $mx_cache->get('_cfg_' . $key . '_' . $theme[$key . '_path']);

			if ($parsed_array === false)
			{
				$parsed_array = array();
			}

			$reparse = false;
			$filename = $phpbb_root_path . 'styles/' . $theme[$key . '_path'] . '/' . $key . '/' . $key . '.cfg';

			if (!file_exists($filename))
			{
				continue;
			}

			if (!isset($parsed_array['filetime']) || (($board_config['load_tplcompile'] && @filemtime($filename) > $parsed_array['filetime'])))
			{
				$reparse = true;
			}

			// Re-parse cfg file
			if ($reparse)
			{
				$parsed_array = mx_parse_cfg_file($filename);
				$parsed_array['filetime'] = @filemtime($filename);

				$mx_cache->put('_cfg_' . $key . '_' . $theme[$key . '_path'], $parsed_array);
			}
			$parsed_items[$key] = $parsed_array;
		}

		return $parsed_items;
	}

	/**
	* Obtain disallowed usernames
	*/
	function obtain_disallowed_usernames()
	{
		global $mx_cache;

		if (($usernames = $mx_cache->get('_disallowed_usernames')) === false)
		{
			global $db;

			$sql = 'SELECT disallow_username
				FROM ' . DISALLOW_TABLE;
			if (!$result = $db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
			}

			$usernames = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$usernames[] = str_replace('%', '.*?', preg_quote(utf8_clean_string($row['disallow_username']), '#'));
			}
			$db->sql_freeresult($result);

			$mx_cache->put('_disallowed_usernames', $usernames);
		}

		return $usernames;
	}

	/**
	* Obtain hooks...
	*/
	function obtain_hooks()
	{
		global $phpbb_root_path, $phpEx, $mx_cache;

		if (($hook_files = $mx_cache->get('_hooks')) === false)
		{
			$hook_files = array();

			// Now search for hooks...
			$dh = @opendir($phpbb_root_path . 'includes/hooks/');

			if ($dh)
			{
				while (($file = readdir($dh)) !== false)
				{
					if (strpos($file, 'hook_') === 0 && substr($file, -(strlen($phpEx) + 1)) === '.' . $phpEx)
					{
						$hook_files[] = substr($file, 0, -(strlen($phpEx) + 1));
					}
				}
				closedir($dh);
			}

			$mx_cache->put('_hooks', $hook_files);
		}

		return $hook_files;
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function generate_group_select_sql()
	{
		// Get us all the groups exept bots and guests
		$sql = "SELECT g.group_id, g.group_name, g.group_type
			FROM " . GROUPS_TABLE . " g
			WHERE g.group_name NOT IN ('BOTS', 'GUESTS')
			ORDER BY g.group_type ASC, g.group_name";
		return $sql;
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function generate_session_online_sql($guest = false)
	{
		if ($guest)
		{
			$sql = "SELECT u.*, s.*, s.session_page AS user_session_page
				FROM " . USERS_TABLE . " u, " . SESSIONS_TABLE . " s
				WHERE u.user_id = " . ANONYMOUS . "
					AND u.user_id = s.session_user_id
					AND s.session_time >= " . ( time() - 300 ) . "
				ORDER BY s.session_time DESC";
		}
		else
		{
			$sql = "SELECT u.*, s.*, s.session_time AS user_session_time, s.session_page AS user_session_page
				FROM " . USERS_TABLE . " u, " . SESSIONS_TABLE . " s
				WHERE u.user_id <> " . ANONYMOUS . "
					AND u.user_id = s.session_user_id
					AND s.session_time >= " . ( time() - 300 ) . "
				ORDER BY s.session_time DESC";
		}
		return $sql;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $str_ip
	 * @return unknown
	 */
	function decode_ip($str_ip)
	{
		return $str_ip;
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function get_phpbb_version()
	{
		global $board_config;

		return $board_config['version'];
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function confirm_backend()
	{
		global $portal_config;

		return PORTAL_BACKEND == $portal_config['portal_backend'];
	}

	/**
	* Get username details for placing into templates.
	*
	* @param string $mode Can be profile (for getting an url to the profile), username (for obtaining the username), colour (for obtaining the user colour) or full (for obtaining a html string representing a coloured link to the users profile).
	* @param int $user_id The users id
	* @param string $username The users name
	* @param string $username_colour The users colour
	* @param string $guest_username optional parameter to specify the guest username. It will be used in favor of the GUEST language variable then.
	* @param string $custom_profile_url optional parameter to specify a profile url. The user id get appended to this url as &amp;u={user_id}
	*
	* @return string A string consisting of what is wanted based on $mode.
	*/
	function get_username_string($mode, $user_id, $username = false, $username_colour = '', $guest_username = false, $custom_profile_url = false)
	{
		global $phpbb_root_path, $mx_root_path, $phpEx, $mx_user, $phpbb_auth;

		$profile_url = '';

		//Added by OryNider
		if (($username == false) || ($username_colour == false))
		{
			$this_userdata = mx_get_userdata($user_id, false);
			$user_id = $this_userdata['user_id'];
			$username = $this_userdata['username'];
			$username_colour = $this_userdata['user_colour'];
		}
		//Added Ends

		$username_colour = ($username_colour) ? '#' . $username_colour : '';

		if ($guest_username === false)
		{
			$username = ($username) ? $username : $mx_user->lang['GUEST'];
		}
		else
		{
			$username = ($user_id && $user_id != ANONYMOUS) ? $username : ((!empty($guest_username)) ? $guest_username : $mx_user->lang['GUEST']);
		}

		// Only show the link if not anonymous
		if ($user_id && $user_id != ANONYMOUS)
		{
			// Do not show the link if the user is already logged in but do not have u_viewprofile permissions (relevant for bots mostly).
			// For all others the link leads to a login page or the profile.
			if ($mx_user->data['user_id'] != ANONYMOUS && !$phpbb_auth->acl_get('u_viewprofile'))
			{
				$profile_url = '';
			}
			else
			{
				$profile_url = ($custom_profile_url !== false) ? $custom_profile_url : mx3_append_sid(PHPBB_URL . "memberlist.$phpEx", 'mode=viewprofile');
				$profile_url .= '&amp;u=' . (int) $user_id;
			}
		}
		else
		{
			$profile_url = '';
		}

		switch ($mode)
		{
			case 'profile':
				return $profile_url;
			break;

			case 'username':
				return $username;
			break;

			case 'colour':
				return $username_colour;
			break;

			case 'full':
			default:

				$tpl = '';
				if (!$profile_url && !$username_colour)
				{
					$tpl = '{USERNAME}';
				}
				else if (!$profile_url && $username_colour)
				{
					$tpl = '<span style="color: {USERNAME_COLOUR};" class="username-coloured">{USERNAME}</span>';
				}
				else if ($profile_url && !$username_colour)
				{
					$tpl = '<a href="{PROFILE_URL}">{USERNAME}</a>';
				}
				else if ($profile_url && $username_colour)
				{
					$tpl = '<a href="{PROFILE_URL}" style="color: {USERNAME_COLOUR};" class="username-coloured">{USERNAME}</a>';
				}

				return str_replace(array('{PROFILE_URL}', '{USERNAME_COLOUR}', '{USERNAME}'), array($profile_url, $username_colour, $username), $tpl);
			break;
		}
	}

	//
	// ACP
	//
	/**
	 * Enter description here...
	 *
	 */
	function load_phpbb_acp_menu()
	{
		global $phpbb_root_path, $template, $lang, $phpEx, $userdata, $mx_user;

		$template->assign_block_vars('module_phpbb', array(
			'L_PHPBB' => $lang['Phpbb'],
			"L_FORUM_INDEX" => $lang['Main_index'],
			"L_PREVIEW_FORUM" => $lang['Preview_forum'],
			"U_FORUM_INDEX" => mx_append_sid(PHPBB_URL . "index.$phpEx"),
		));

		$menu_cat_id = 0;

		$template->assign_block_vars('module_phpbb.catrow', array(
			//+MOD: DHTML Menu for ACP
			'MENU_CAT_ID' => $menu_cat_id,
			'MENU_CAT_ROWS' => 1,
			//-MOD: DHTML Menu for ACP
			'ADMIN_CATEGORY' => 'rhea adminCP')
		);

		$template->assign_block_vars('module_phpbb.catrow.modulerow', array(
			"ROW_COLOR" => "#" . $mx_user->theme['td_color1'],
			"ROW_CLASS" => $mx_user->theme['td_class1'],
			//+MOD: DHTML Menu for ACP
			'ROW_COUNT' => 0,
			//-MOD: DHTML Menu for ACP
			"ADMIN_MODULE" => 'Go!',
			"U_ADMIN_MODULE" => mx_append_sid($phpbb_root_path . 'adm/index.php?sid='.$mx_user->session_id))
		);
	}

	/**
	 * Enter description here...
	 *
	 */
	function load_forum_stats()
	{
		global $db, $dbms, $mx_dbms, $dbname, $mx_dbname, $table_prefix, $mx_table_prefix, $phpBB2, $template; 
		global $phpEx, $board_config, $portal_config, $phpbb_root_path, $mx_root_path, $lang, $theme, $mx_user, $userdata;
		
		$mx_info = $this->get_mxp_info($mx_root_path . "config.$phpEx");
		// MXP x.x auto-generated config file
		// Do not change anything in this file!
		$mx_dbms 			= $mx_info['dbms'];
		$mx_dbhost 		= $mx_info['dbhost'];
		$mx_dbname 		= $mx_info['dbname'];
		$mx_dbuser 		= $mx_info['dbuser'];
		$mx_dbpasswd 	= $mx_info['dbpasswd'];
		$mx_table_prefix 	= $mx_info['mx_table_prefix'];
		
		$backend_info = $this->get_phpbb_info($phpbb_root_path . "config.$phpEx");
		// phpBB x.x auto-generated config file
		// Do not change anything in this file!
		$phpbb_dbms 			= $backend_info['dbms'];
		$phpbb_dbhost 		= $backend_info['dbhost'];
		$phpbb_dbname 		= $backend_info['dbname'];
		$phpbb_dbuser 		= $backend_info['dbuser'];
		$phpbb_dbpasswd 	= $backend_info['dbpasswd'];
		$phpbb_table_prefix 	= $backend_info['table_prefix'];
		
		$template->assign_block_vars("forum_stats", array());
		
		//
		// Get forum statistics
		//
		$total_posts = mx_get_db_stat('postcount', $dbname);
		$total_users = mx_get_db_stat('usercount', $dbname);
		$total_topics = mx_get_db_stat('topiccount', $dbname);
		
		$mx_total_posts = mx_get_db_stat('postcount', $mx_dbname);
		$mx_total_users = mx_get_db_stat('usercount', $mx_dbname);
		$mx_total_topics = mx_get_db_stat('topiccount', $mx_dbname);
		
		$start_date = mx_create_date($board_config['default_dateformat'], $board_config['board_startdate'], $board_config['board_timezone']);
		$mx_start_date = mx_create_date($portal_config['default_dateformat'], $portal_config['portal_startdate'], $portal_config['board_timezone']);
		
		$boarddays = ( time() - $board_config['board_startdate'] ) / 86400;
		$mx_boarddays = ( time() - $portal_config['portal_startdate'] ) / 86400;
		
		$posts_per_day = sprintf("%.2f", $total_posts / $boarddays);
		$mx_posts_per_day = sprintf("%.2f", $total_posts / $mx_boarddays);
		$topics_per_day = sprintf("%.2f", $total_topics / $boarddays);
		$mx_topics_per_day = sprintf("%.2f", $total_topics / $mx_boarddays);
		$users_per_day = sprintf("%.2f", $total_users / $boarddays);
		$mx_users_per_day = sprintf("%.2f", $total_users / $mx_boarddays);
		
		$avatar_dir_size = 0;
		
		if ($avatar_dir = @opendir($phpbb_root_path . $board_config['avatar_path']) )
		{
			while( $file = @readdir($avatar_dir) )
			{
				if( $file != "." && $file != ".." )
				{
					$avatar_dir_size += @filesize($phpbb_root_path . $board_config['avatar_path'] . "/" . $file);
				}
			}
			@closedir($avatar_dir);
			
			//
			// This bit of code translates the avatar directory size into human readable format
			// Borrowed the code from the PHP.net annoted manual, origanally written by:
			// Jesse (jesse@jess.on.ca)
			//
			if($avatar_dir_size >= 1048576)
			{
				$avatar_dir_size = round($avatar_dir_size / 1048576 * 100) / 100 . " MB";
			}
			else if($avatar_dir_size >= 1024)
			{
				$avatar_dir_size = round($avatar_dir_size / 1024 * 100) / 100 . " KB";
			}
			else
			{
				$avatar_dir_size = $avatar_dir_size . " Bytes";
			}
		}
		else
		{
			// Couldn't open Avatar dir.
			$avatar_dir_size = $lang['Not_available'];
		}
		
		$mx_avatar_dir_size = 0;
		$portal_config['avatar_path'] = '/images/avatars';
		if ($mx_avatar_dir = @opendir($mx_root_path . $portal_config['avatar_path']) )
		{
			while( $file = @readdir($mx_avatar_dir) )
			{
				if( $file != "." && $file != ".." )
				{
					$mx_avatar_dir_size += @filesize($mx_root_path . $portal_config['avatar_path'] . "/" . $file);
				}
			}
			@closedir($mx_avatar_dir);
			
			//
			// This bit of code translates the avatar directory size into human readable format
			// Borrowed the code from the PHP.net annoted manual, origanally written by:
			// Jesse (jesse@jess.on.ca)
			//
			if($mx_avatar_dir_size >= 1048576)
			{
				$mx_avatar_dir_size = round($mx_avatar_dir_size / 1048576 * 100) / 100 . " MB";
			}
			else if($mx_avatar_dir_size >= 1024)
			{
				$mx_avatar_dir_size = round($mx_avatar_dir_size / 1024 * 100) / 100 . " KB";
			}
			else
			{
				$mx_avatar_dir_size = $mx_avatar_dir_size . " Bytes";
			}
		}
		else
		{
			// Couldn't open Avatar dir.
			$mx_avatar_dir_size = $lang['Not_available'];
		}

		if($posts_per_day > $total_posts)
		{
			$posts_per_day = $total_posts;
		}

		if($topics_per_day > $total_topics)
		{
			$topics_per_day = $total_topics;
		}

		if($users_per_day > $total_users)
		{
			$users_per_day = $total_users;
		}
		
		//
		// DB size ... MySQL only
		//
		// This code is heavily influenced by a similar routine
		// in phpMyAdmin 2.2.0
		//
		switch ($dbms)
		{
			case 'mysql':
			case 'mysql4':
			case 'mysqli':
				$sql = "SELECT version() AS version";
				if($result = $db->sql_query($sql))
				{
					$row = $db->sql_fetchrow($result);
					$version = $row['version'];

					if( preg_match("/^(3\.23|4\.|5\.)/", $version) )
					{
						$dbname = ( preg_match("/^(3\.23\.[6-9])|(3\.23\.[1-9][1-9])|(4\.)|(5\.)/", $version) ) ? "`$dbname`" : $dbname;
						$mx_dbname = ( preg_match("/^(3\.23\.[6-9])|(3\.23\.[1-9][1-9])|(4\.)|(5\.)/", $version) ) ? "`$dbname`" : $mx_dbname;

						$sql = "SHOW TABLE STATUS
							FROM " . $dbname;
						if($result = $db->sql_query($sql))
						{
							$tabledata_ary = $db->sql_fetchrowset($result);
							
							$dbsize = $phpb_dbsize = $mx_dbsize = 0;
							for ($i = 0; $i < count($tabledata_ary); $i++)
							{
								if( isset($tabledata_ary[$i]['Engine']))
								{
									if( $table_prefix != "" )
									{
										if( strstr($tabledata_ary[$i]['Name'], $table_prefix) )
										{
											$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];											
											$phpb_dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
										}
									}
									else
									{
										$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
									}
									
									if( $mx_table_prefix != "" )
									{
										if( strstr($tabledata_ary[$i]['Name'], $mx_table_prefix) )
										{
											$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];											
											$mx_dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
										}
									}
									else
									{
										$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
									}
								}
							}
						} // Else we couldn't get the table status.
						$sql = "SELECT table_schema 'database',
						concat( round( sum( data_length + index_length ) / ( 1024 *1024 ) , 2 ) , 'M' ) size
						FROM information_schema.TABLES
						WHERE ENGINE=('MyISAM' || 'InnoDB' )
						GROUP BY table_schema";						
						if($result = $db->sql_query($sql))
						{
							$tabledata_ary = $db->sql_fetchrowset($result);						
							$dbsize = isset($dbsize) ? $dbsize : 0;					
							for ($i = 0; $i < count($tabledata_ary); $i++)
							{
								if(isset($tabledata_ary[$i]['database']))
								{
									if( strstr($tabledata_ary[$i]['database'], $dbname) )
									{
										$dbsize = $tabledata_ary[$i]['size'];
									}
																	
								}							
							}
						} // Else we couldn't get the table status.					
					}
					else
					{
						$dbsize = $lang['Not_available'];
					}
				}
				else
				{
					$dbsize = $lang['Not_available'];
				}
				$db->sql_freeresult($result);

			break;

			case 'sqlite3':
				global $dbhost;

				if (file_exists($dbhost))
				{
					$dbsize = filesize($dbhost);
				}

			break;

			case 'mssql_odbc':
			case 'mssqlnative':
				$sql = 'SELECT @@VERSION AS mssql_version';
				if (!$result = $db->sql_query($sql))
				{
					mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$sql = 'SELECT ((SUM(size) * 8.0) * 1024.0) as dbsize
					FROM sysfiles';

				if ($row)
				{
					// Azure stats are stored elsewhere
					if (strpos($row['mssql_version'], 'SQL Azure') !== false)
					{
						$sql = 'SELECT ((SUM(reserved_page_count) * 8.0) * 1024.0) as dbsize
						FROM sys.dm_db_partition_stats';
					}
				}

				$result = $db->sql_query($sql, 7200);
				$dbsize = ($row = $db->sql_fetchrow($result)) ? $row['dbsize'] : false;
				$db->sql_freeresult($result);
			break;

			case 'postgres':
				$sql = "SELECT proname
					FROM pg_proc
					WHERE proname = 'pg_database_size'";
				if (!$result = $db->sql_query($sql))
				{
					mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if ($row['proname'] == 'pg_database_size')
				{
					$database = $db->get_db_name();
					if (strpos($database, '.') !== false)
					{
						list($database, ) = explode('.', $database);
					}

					$sql = "SELECT oid
						FROM pg_database
						WHERE datname = '$database'";
					if (!$result = $db->sql_query($sql))
					{
						mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					$oid = $row['oid'];

					$sql = 'SELECT pg_database_size(' . $oid . ') as size';
					if (!$result = $db->sql_query($sql))
					{
						mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					$dbsize = $row['size'];
				}
			break;

			case 'oracle':
				$sql = 'SELECT SUM(bytes) as dbsize
					FROM user_segments';
				$result = $db->sql_query($sql, 7200);
				$dbsize = ($row = $db->sql_fetchrow($result)) ? $row['dbsize'] : false;
				$db->sql_freeresult($result);
			break;
		}
		
		$dbsize = ($dbsize !== 0) ? $dbsize : $lang['Not_available'];	
		
		if ( is_integer($dbsize) )
		{
			if( $dbsize >= 1048576 )
			{
				$dbsize = sprintf("%.2f MB", ( $dbsize / 1048576 ));
			}
			else if( $dbsize >= 1024 )
			{
				$dbsize = sprintf("%.2f KB", ( $dbsize / 1024 ));
			}
			else
			{
				$dbsize = sprintf("%.2f Bytes", $dbsize);
			}
		}

		if ($mx_dbname !== $dbname)
		{
			//
			// DB size ... MySQL only
			//
			// This code is heavily influenced by a similar routine
			// in phpMyAdmin 2.2.0
			//
			switch ($mx_dbms)
			{
				case 'mysql':
				case 'mysql4':
				case 'mysqli':
					$sql = "SELECT version() AS version";
					if($result = $db->sql_query($sql))
					{
						$row = $db->sql_fetchrow($result);
						$mx_version = $row['version'];

						if( preg_match("/^(3\.23|4\.|5\.)/", $mx_version) )
						{
							$mx_dbname = ( preg_match("/^(3\.23\.[6-9])|(3\.23\.[1-9][1-9])|(4\.)|(5\.)/", $mx_version) ) ? "`$mx_dbname`" : $mx_dbname;

							$sql = "SHOW TABLE STATUS
								FROM " . $mx_dbname;						
							if($result = $db->sql_query($sql))
							{
								$mx_tabledata_ary = $db->sql_fetchrowset($result);
								
								$mx_dbsize = 0;
								for ($i = 0; $i < count($mx_tabledata_ary); $i++)
								{
									if( isset($mx_tabledata_ary[$i]['Engine']))
									{
										if( $mx_table_prefix != "" )
										{
											if( strstr($mx_tabledata_ary[$i]['Name'], $mx_table_prefix) )
											{										
												$mx_dbsize += $mx_tabledata_ary[$i]['Data_length'] + $mx_tabledata_ary[$i]['Index_length'];
											}
										}
										else
										{
											$mx_dbsize += $mx_tabledata_ary[$i]['Data_length'] + $mx_tabledata_ary[$i]['Index_length'];
										}
									}
								}
							} // Else we couldn't get the table status.
							$sql = "SELECT table_schema 'database',
							concat( round( sum( data_length + index_length ) / ( 1024 *1024 ) , 2 ) , 'M' ) size
							FROM information_schema.TABLES
							WHERE ENGINE=('MyISAM' || 'InnoDB' )
							GROUP BY table_schema";						
							if($result = $db->sql_query($sql))
							{
								$mx_tabledata_ary = $db->sql_fetchrowset($result);						
								$mx_dbsize = isset($mx_dbsize) ? $mx_dbsize : 0;					
								for ($i = 0; $i < count($mx_tabledata_ary); $i++)
								{
									if(isset($mx_tabledata_ary[$i]['database']))
									{
										if( strstr($mx_tabledata_ary[$i]['database'], $mx_dbname) )
										{
											$mx_dbsize = $mx_tabledata_ary[$i]['size'];
										}
																		
									}							
								}
							} // Else we couldn't get the table status.					
						}
						else
						{
							$mx_dbsize = $lang['Not_available'];
						}
					}
					else
					{
						$mx_dbsize = $lang['Not_available'];
					}
					$db->sql_freeresult($result);

				break;

				case 'sqlite3':
					global $mx_dbhost;

					if (file_exists($mx_dbhost))
					{
						$dbsize = filesize($mx_dbhost);
					}

				break;

				case 'mssql_odbc':
				case 'mssqlnative':
					$sql = 'SELECT @@VERSION AS mssql_version';
					if (!$result = $db->sql_query($sql))
					{
						mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					$sql = 'SELECT ((SUM(size) * 8.0) * 1024.0) as dbsize
						FROM sysfiles';

					if ($row)
					{
						// Azure stats are stored elsewhere
						if (strpos($row['mssql_version'], 'SQL Azure') !== false)
						{
							$sql = 'SELECT ((SUM(reserved_page_count) * 8.0) * 1024.0) as dbsize
							FROM sys.dm_db_partition_stats';
						}
					}

					$result = $db->sql_query($sql, 7200);
					$mx_dbsize = ($row = $db->sql_fetchrow($result)) ? $row['dbsize'] : false;
					$db->sql_freeresult($result);
				break;

				case 'postgres':
					$sql = "SELECT proname
						FROM pg_proc
						WHERE proname = 'pg_database_size'";
					if (!$result = $db->sql_query($sql))
					{
						mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if ($row['proname'] == 'pg_database_size')
					{
						$mx_database = $db->get_db_name();
						if (strpos($mx_database, '.') !== false)
						{
							list($mx_database, ) = explode('.', $mx_database);
						}

						$sql = "SELECT oid
							FROM pg_database
							WHERE datname = '$mx_database'";
						if (!$result = $db->sql_query($sql))
						{
							mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
						}
						$row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);

						$oid = $row['oid'];

						$sql = 'SELECT pg_database_size(' . $oid . ') as size';
						if (!$result = $db->sql_query($sql))
						{
							mx_message_die(CRITICAL_ERROR, "Could not update/query database", "", __LINE__, __FILE__, $sql);
						}
						$row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);

						$mx_dbsize = $row['size'];
					}
				break;

				case 'oracle':
					$sql = 'SELECT SUM(bytes) as dbsize
						FROM user_segments';
					$result = $db->sql_query($sql, 7200);
					$mx_dbsize = ($row = $db->sql_fetchrow($result)) ? $row['dbsize'] : false;
					$db->sql_freeresult($result);
				break;
			}
			
			$template->assign_block_vars('mx_stats', array(
				"NUMBER_OF_POSTS" 	=> $mx_total_posts,
				"NUMBER_OF_TOPICS" 	=> $mx_total_topics,
				"NUMBER_OF_USERS" 	=> $mx_total_users,
				"START_DATE" 				=> $mx_start_date,
				"POSTS_PER_DAY" 			=> $mx_posts_per_day,
				"TOPICS_PER_DAY" 		=> $mx_topics_per_day,
				"USERS_PER_DAY" 			=> $mx_users_per_day,
				"AVATAR_DIR_SIZE" 		=> $mx_avatar_dir_size,
				"DB_SIZE" 						=> $mx_dbsize,
				"GZIP_COMPRESSION" 	=> ( $board_config['gzip_compress'] ) ? $lang['ON'] : $lang['OFF']
				)
			);
		}
		$template->assign_vars(array(
			"NUMBER_OF_POSTS" => $total_posts,
			"NUMBER_OF_TOPICS" => $total_topics,
			"NUMBER_OF_USERS" => $total_users,
			"START_DATE" => $start_date,
			"POSTS_PER_DAY" => $posts_per_day,
			"TOPICS_PER_DAY" => $topics_per_day,
			"USERS_PER_DAY" => $users_per_day,
			"AVATAR_DIR_SIZE" => $avatar_dir_size,
			"DB_SIZE" => $dbsize,
			"GZIP_COMPRESSION" => ( $board_config['gzip_compress'] ) ? $lang['ON'] : $lang['OFF'])
		);
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function phpbb_version_check($force_update = false, $warn_fail = false, $ttl = 86400)
	{
		global $mx_cache, $mx_request_vars, $board_config, $lang, $phpbb_version_info;
		
		$errno = 0;
		$errstr = $phpbb_version_info = '';
		
		$phpbb_version_info = $mx_cache->get('versioncheck');
		
		$current_phpbb_version = explode(".", $board_config['version']);
		$head_phpbb_revision = $current_phpbb_version[0];
		$major_phpbb_revision = $current_phpbb_version[1];
		$minor_phpbb_revision = $current_phpbb_version[2];
		
		//Load class version helper
		$mx_cache->load_file('version_helper', 'phpbb3');
		$version_helper = new version_helper();
		
		try
		{
			$recheck = $mx_request_vars->variable('versioncheck_force', false);
			$updates_available = $version_helper->get_update_on_branch($recheck);
			$upgrades_available = $version_helper->get_suggested_updates();
				
			if (!empty($upgrades_available))
			{
				$upgrades_available = array_pop($upgrades_available);
			}
			$version_up_to_date		= empty($updates_available);
			$version_upgradeable		= !empty($upgrades_available);
			$upgrade_instructions		= !empty($upgrades_available) ? $mx_user->lang('UPGRADE_INSTRUCTIONS', $upgrades_available['current'], $upgrades_available['announcement']) : false;
		}
		catch (\RuntimeException $e)
		{
			$message = call_user_func_array(array($mx_user, 'lang'), array_merge(array($e->getMessage()), $e->get_parameters()));

			$versioncheck_fail		= true;
			$versioncheck_fail_reason	= ($e->getMessage() !== 'VERSIONCHECK_FAIL') ? $message : '';
		}
		
		if ((($head_phpbb_revision == 3) && ($major_phpbb_revision == 0)) || ($head_phpbb_revision < 3))
		{
			if ($fsock = @fsockopen('www.phpbb.com', 80, $errno, $errstr, 10))
			{
				$phpbb_version_info = mx_get_remote_file('www.phpbb.com', '/updatecheck', ((defined('PHPBB_QA')) ? $head_phpbb_revision . $major_phpbb_revision . 'x_qa.txt' : $head_phpbb_revision . $major_phpbb_revision . 'x.txt'), $errstr, $errno);
				
				
				if ($phpbb_version_info === false || $force_update)
				{
					$errstr = '';
					$errno = 0;

					$phpbb_version_info = mx_get_remote_file('version.phpbb.com', '/phpbb',
							((defined('PHPBB_QA')) ? $head_phpbb_revision . $major_phpbb_revision . 'x_qa.txt' : $head_phpbb_revision . $major_phpbb_revision . 'x.txt'), $errstr, $errno);
				}
				
				
				if (empty($phpbb_version_info))
				{
					$mx_cache->destroy('versioncheck');
					if ($warn_fail)
					{
						trigger_error($errstr, E_USER_WARNING);
					}
					return false;
				}

				$mx_cache->put('versioncheck', $phpbb_version_info, $ttl);

				$phpbb_version_info = explode("\n", $phpbb_version_info);
				//$latest_version = trim($phpbb_version_info[0]); 
				//$update_link = append_sid($phpbb_root_path . 'install/index.' . $phpEx, 'mode=update');
				$latest_phpbb_head_revision = $version1 = strtolower(trim($phpbb_version_info[0]));
				$latest_phpbb_minor_revision = trim($phpbb_version_info[2]);
				$latest_phpbb_version = trim($phpbb_version_info[1]) . ', <a href=' . trim($phpbb_version_info[2]) . '>' . trim($phpbb_version_info[2]) . '</a> ';
				$version2 = strtolower($board_config['version']);
				$current_phpbb_version = explode(".", $board_config['version']);
				$minor_phpbb_revision = $current_phpbb_version[2];
				$operator = '<=';
				if (version_compare($version1, $version2, $operator))
				{
					$phpbb_version_info = '<p style="color:green">' . $lang['Version_up_to_date'] . '</p>';
				}
				else
				{
					$phpbb_version_info = '<p style="color:red">' . $lang['Version_not_up_to_date'];
					$phpbb_version_info .= '<br />' . sprintf($lang['Latest_version_info'], $latest_phpbb_version) . '<br />' . sprintf($lang['Current_version_info'], $board_config['version']) . '</p>';
				}
			}
			else
			{
				if ($errstr)
				{
					$phpbb_version_info = '<p style="color:red">' . sprintf($lang['Connect_socket_error'], $errstr) . '</p>';
				}
				else
				{
					$phpbb_version_info = '<p>' . $lang['Socket_functions_disabled'] . '</p>';
				}
			}
		}
		else
		{
				if (empty($updates_available))
				{
					$phpbb_version_info = '<p style="color:green">' . $lang['Version_up_to_date'] . '</p>';
				}
				elseif (!empty($updates_available))
				{
					$phpbb_version_info = '<p style="color:green">' . $lang['Version_not_up_to_date'];
					$phpbb_version_info .= '<br />' . $upgrade_instructions . '<br />' . sprintf($lang['Current_version_info'], $board_config['version']) . '</p>';
				}
				else
				{
					$phpbb_version_info = '<p style="color:red">' . $lang['Version_not_up_to_date'];
					$phpbb_version_info .= '<br />' . $upgrade_instructions . '<br />' . sprintf($lang['Current_version_info'], $board_config['version']) . '</p>';
				}
		}
		$phpbb_version_info .= '<p>' . $lang['Mailing_list_subscribe_reminder'] . '</p>';

		return $phpbb_version_info;
	}
}

//
// Now load some bbcodes, to be extended for this backend (see below)
//
include_once($mx_root_path . 'includes/sessions/rhea/bbcode.' . $phpEx); // BBCode associated functions

?>
