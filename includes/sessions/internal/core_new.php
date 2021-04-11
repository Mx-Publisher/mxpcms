<?php
/**
*
* @package Auth
* @version $Id: core.php,v 2.3.3 2014/05/16 18:02:23 orynider Exp $
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
include_once($mx_root_path . 'includes/sessions/internal/functions.' . $phpEx);

//
// Load here Backend Permissions if this is required
//
include_once($mx_root_path . 'includes/sessions/internal/auth.' . $phpEx);

/**
* Permission/Auth class
*
* @package MX-Publisher
*
*/
class phpbb_auth extends mx_auth_base
{
	var $acl = array();
	var $mx_cache = array();
	var $acl_options = array();
	var $acl_forum_ids = false;
	
	/**
	* Init permissions
	*/
	function acl(&$mx_userdata)
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
		
		if (!isset($mx_userdata['user_permissions']) || !trim($mx_userdata['user_permissions']))
		{
			$this->acl_cache($mx_userdata);
		}

		// Fill ACL array
		$this->_fill_acl($mx_userdata['user_permissions']);
		
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
			$this->acl_cache($mx_userdata);
			$this->_fill_acl($mx_userdata['user_permissions']);
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
	function acl_cache(&$mx_userdata)
	{
		global $db;
		
		// Empty user_permissions
		$mx_userdata['user_permissions'] = '';

		$hold_ary = $this->acl_raw_data_single_user($mx_userdata['user_id']);

		// Key 0 in $hold_ary are global options, all others are forum_ids

		// If this user is founder we're going to force fill the admin options ...
		if ($mx_userdata['user_level'] == ADMIN)
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
			$mx_userdata['user_permissions'] = $hold_str;
			
			$sql = 'UPDATE ' . USERS_TABLE . "
				SET user_permissions = '" . $db->sql_escape($mx_userdata['user_permissions']) . "',
					user_perm_from = 0
				WHERE user_id = " . $mx_userdata['user_id'];
			if (!($db->sql_query($sql)))
			{
				// If the column exists we change it, else we add it ;)
				$table = USERS_TABLE;
				
				$column_data = $mx_userdata;
				
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
		global $mx_userdata, $mx_root_path, $phpEx;
		static $auth_data_sql;
		//
		// Try to reuse auth_view query result.
		//
		$mx_userdata_key = 'mx_get_auth_' . $mode . $mx_userdata['user_id'];
		if( !empty($mx_userdata[$mx_userdata_key]) )
		{
			$auth_data_sql = $mx_userdata[$mx_userdata_key];
			return $auth_data_sql;
		}
		//
		// Now, this tries to optimize DB access involved in auth(),
		// passing AUTH_LIST_ALL will load info for all forums at once.
		// Start auth check
		if (!$is_auth_ary = $this->acl_getf('f_read', false))
		{
			if ($mx_user->data['user_id'] != ANONYMOUS)
			{
				//trigger_error('SORRY_AUTH_READ');
				$auth_data_sql = false;
			}
			//login_box('', $mx_user->lang['LOGIN_VIEWFORUM']);
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
		$mx_userdata[$mx_userdata_key] = $auth_data_sql;
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
	* @param int $mx_user_id User ID
	* @return array User attributes
	*/
	public function obtain_user_data($mx_user_id)
	{
		global $db;

		$sql = 'SELECT u.user_id, u.username, u.user_permissions, u.user_type, u.user_id as user_colour, u.user_level as user_type, u.user_avatar as avatar, u.user_avatar_type as avatar_type
			FROM ' . USERS_TABLE . ' u
			WHERE user_id = ' . $mx_user_id;
		if (!($result = $db->sql_query($sql)))
		{
			mx_message_die(CRITICAL_ERROR, 'Could not query user info');
		}		
		$mx_user_data = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		return $mx_user_data;
	}

	/**
	* Fill ACL array with relevant bitstrings from user_permissions column
	* @access private
	*/
	function _fill_acl($mx_user_permissions)
	{
		$seq_cache = array();
		$this->acl = array();
		$mx_user_permissions = explode("\n", $mx_user_permissions);

		foreach ($mx_user_permissions as $f => $seq)
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
				$result = $db->sql_query($sql);

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
	function acl_get_list($mx_user_id = false, $opts = false, $forum_id = false)
	{
		if ($mx_user_id !== false && !is_array($mx_user_id) && $opts === false && $forum_id === false)
		{
			$hold_ary = array($mx_user_id => $this->acl_raw_data_single_user($mx_user_id));
		}
		else
		{
			$hold_ary = $this->acl_raw_data($mx_user_id, $opts, $forum_id);
		}

		$auth_ary = array();
		foreach ($hold_ary as $mx_user_id => $forum_ary)
		{
			foreach ($forum_ary as $forum_id => $auth_option_ary)
			{
				foreach ($auth_option_ary as $auth_option => $auth_setting)
				{
					if ($auth_setting)
					{
						$auth_ary[$forum_id][$auth_option][] = $mx_user_id;
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
	function acl_raw_data_single_user($mx_user_id)
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
			$result = $db->sql_query($sql);

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
			WHERE user_id = ' . $mx_user_id;
		$result = $db->sql_query($sql);

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
				AND ug.user_id = ' . $mx_user_id;
		$result = $db->sql_query($sql);

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

//
// Init the auth class if this is required
//
$mx_auth = $phpbb_auth = new mx_auth_base();

//
// Instantiate Dummy Forum Specific Shared Classes
// Moved in common.php


/**
* Backend specific tasks
*
* @package MX-Publisher
*/
class mx_backend
{
	//
	// XS Template - use backend db settings
	//
	var $edit_db = true;
	var $page_id = 1;
	var $mx_user_ip = '::1';
	var $user_ip = '127.0.0.1';
	var $client_ip = '127.0.0.1';
	
	/***/
	function __construct()
	{	
		// Obtain and encode users IP
		// from MXP 2.7.x common
		global $mx_request_vars;
		// I'm removing HTTP_X_FORWARDED_FOR ... this may well cause other problems such as
		// private range IP's appearing instead of the guilty routable IP, tough, don't
		// even bother complaining ... go scream and shout at the idiots out there who feel
		// "clever" is doing harm rather than good ... karma is a great thing ... :)
		// Why no forwarded_for et al? Well, too easily spoofed. With the results of my recent requests
		// it's pretty clear that in the majority of cases you'll at least be left with a proxy/cache ip.
		$client_ip = htmlspecialchars_decode($mx_request_vars->server('REMOTE_ADDR'));
		$client_ip = preg_replace('# {2,}#', ' ', str_replace(',', ' ', $client_ip));

		// split the list of IPs
		$ips = explode(' ', trim($client_ip));

		// Default IP if REMOTE_ADDR is invalid
		$this->ip = '127.0.0.1';
		$user_ip = $this->encode_ip($client_ip);
		
		if (substr_count($client_ip, '::1') === 1)
		{
			$user_ip = '127.0.0.1';
			$ip_sep = explode('.', $this->ip);
			$this->user_ip = sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
		}
		
		foreach ($ips as $ip)
		{
			// Normalise IP address
			$ip = $this->ip_normalise($ip);

			if ($ip === false)
			{
				// IP address is invalid.
				break;
			}
			
			// IP address is valid.
			$this->ip = $ip;
		} 
		
		$user_ip = $this->ip_normalise($client_ip);
		$domain = gethostbyaddr($user_ip);		
			
	}	
	/***/
	 
	/**
	 * Validate backend
	 *
	 * Define Users/Group/Sessions backend, and validate
	 * Set i.e. $phpbb_root_path, $tplEx, $table_prefix
	 *
	 */
	function validate_backend($cache_config = array())
	{
		global $db, $phpbb_root_path, $mx_root_path;
		global $phpEx, $tplEx, $portal_config;
		global $mx_dbms, $mx_dbhost, $mx_dbname, $mx_dbuser, $mx_dbpasswd, $mx_table_prefix;
		global $dbms, $dbhost, $dbname, $dbuser, $dbpasswd, $table_prefix;
		
		$backend_table_prefix = '';
		
		//
		// Define backend template extension
		//
		$tplEx = 'tpl';
		
		//
		// Define relative path to phpBB, and validate
		//
		$phpbb_root_path = $mx_root_path . 'includes/shared/phpbb2/';
		str_replace("//", "/", $phpbb_root_path);
		$portal_backend_valid_file = @file_exists($phpbb_root_path . "includes/functions.$phpEx");
		
		return $portal_backend_valid_file;
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
		global $mx_cache, $portal_config, $board_config, $mx_root_path, $phpbb_root_path, $phpEx, $db;
			
		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($portal_config['script_path']));
		$server_name = trim($portal_config['server_name']);
		$server_protocol = ( $portal_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = (($portal_config['server_port']) && ($portal_config['server_port'] <> 80)) ? ':' . trim($portal_config['server_port']) . '/' : '/';
		$portal_config['portal_phpbb_url'] = str_replace("//", "/", $server_name . $server_port . $script_name . '/');
		$server_url = $server_protocol . str_replace("//", "/", $server_name . $server_port . $script_name . '/'); //On some server the slash is not added and this trick will fix it

		//
		// Grab phpBB global variables, re-cache if necessary
		// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the MX-Publisher cache whenever updating phpBB config settings
		// - true: enable cache, false: disable cache
		if (empty($board_config['script_path']))
		{
			$board_config = $mx_cache->obtain_mxbb_config(false);
		}
		
		if (empty($portal_config['portal_version']))
		{
			$portal_config = $mx_cache->obtain_mxbb_config(false);
		}
		/**		
		$this->data = !empty($this->data['user_id']) ? $this->data : $mx_user->session_pagestart($user_ip, $page_id);
		
		$this->cache = is_object($mx_cache) ? $mx_cache : new base();
		*/		
		if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) 
		{
		    $this->data['is_bot'] = true;
		}
		else
		{
		    $this->data['is_bot'] = false;
		}	
		
		//
		// Populate session_id
		//
		//$this->session_id = $this->data['session_id'];		
		$this->lang_path = $phpbb_root_path . 'language/';
			
		$script_name = !empty($board_config['server_name']) ? preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['server_name'])) : 'localhost';
		$server_protocol = ( $board_config['cookie_secure'] ) ? 'http://' : 'http://';
		$server_port = (($board_config['server_port']) && ($board_config['server_port'] <> 80)) ? ':' . trim($portal_config['server_port']) . '/' : '/';
		$script_name_phpbb = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])) . '/';		
		
		if (!empty($portal_config['portal_url']))
		{
			$corrected_url = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($portal_config['portal_url'])) . '/';
		}
		else		
		{
			$corrected_url = str_replace(array('phpBB/', $script_name_phpbb, str_replace('./../', '', $phpbb_root_path)), '', $portal_config['portal_phpbb_url'] . '/');
			$corrected_url = (empty($portal_config['portal_phpbb_url'])  || preg_match('@^(?:phpbb.com)?([^/]+)@i', $portal_config['portal_phpbb_url'])) ? $server_protocol . str_replace("//", "/", $server_name . $server_port . $script_name . '/') : str_replace(array('http://', 'http://'), $server_protocol, $server_url) ; //On some server the slash is not added and this trick will fix it	
		}		
		
		$board_url = $server_url;
		
		define('PORTAL_VERSION', $portal_config['portal_version']);
		
		$server_url_phpbb = $server_protocol . (isset($server_name) ? $server_name : $script_name) . $server_port . $script_name_phpbb;
		
		if (empty($portal_config['portal_phpbb_url'])  || preg_match('@^(?:phpbb.com)?([^/]+)@i', $portal_config['portal_phpbb_url']))
		{
			$portal_config['portal_phpbb_url'] = !empty($portal_config['portal_url']) ? $server_url . $script_name_phpbb : $server_url_phpbb;
		}		
		
		$server_url_phpbb = !empty($portal_config['portal_phpbb_url']) ? $server_url . $script_name_phpbb : $server_url_phpbb;				
		$server_url_phpbb = (empty($portal_config['portal_phpbb_url']) || preg_match('@^(?:phpbb.com)?([^/]+)@i', $portal_config['portal_phpbb_url'])) ? $server_url_phpbb : $portal_config['portal_phpbb_url'];	
		//For internal backend we ignore portal_phpbb_url a.t.m.
		define('PHPBB_URL', $server_url);
		define('PORTAL_URL', $board_url);		
		define('BOARD_URL', $server_url);	
		
		$web_path = (isset($portal_config['portal_url'])) ? $board_url : $corrected_url;		
		
		//
		// Define backend template extension
		//
		$tplEx = 'tpl';
		if (!defined('TPL_EXT')) define('TPL_EXT', $tplEx);
		
		//
		// Now sync Configs
		// In phpBB mode, we rely on native phpBB configs, thus we need to sync mxp and phpbb settings
		//
		$this->sync_configs();

		//
		// Dummy include, to make all original phpBB functions available
		// In case we need old functions...
		include_once($mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx); 
		include_once($mx_root_path . 'includes/shared/phpbb3/includes/functions.' . $phpEx);
		//
		// Is phpBB File Attachment MOD present?
		//
		if( file_exists($phpbb_root_path . 'attach_mod') )
		{
			include_once($phpbb_root_path . 'attach_mod/attachment_mod.' . $phpEx);
		}
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
			$shared = in_array($force_shared, array('internal', 'phpbb2', 'phpbb3')) ? $force_shared : PORTAL_BACKEND;

			switch ($shared)
			{
				case 'internal':
				case 'phpbb2':
					$path = $mx_root_path . 'includes/shared/phpbb2/includes/';
				break;
				case 'phpbb3':
				default:
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
	function get_mxp_info($root_path, $backend = 'internal', $phpbbversion = '2.0.24')
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
			case 'olympus':		
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
			'dbms'			=> $dbms,
			'dbhost'		=> $dbhost,
			'dbname'		=> $dbname,
			'dbuser'		=> $dbuser,
			'dbpasswd'		=> $dbpasswd,
			'mx_table_prefix'	=> $mx_table_prefix,			
			'table_prefix'	=> $table_prefix,
			'backend'		=> $backend,		
			'version'		=> $phpbbversion,
			'acm_type'		=> isset($acm_type) ? $acm_type : '',
			'phpbb_root_path'	=> $phpbb_root_path,			
			'status'		=> defined('MX_INSTALLED') ? true : false,			
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
			die('Configuration file (get_phpbb_info) ' . $config . ' couldn\'t be opened.');
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
				case (preg_match('/4./i', $phpbbversion)):
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
			
			case 'phpbb3':
			case 'olympus':		
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
			'dbms'			=> $dbms,
			'dbhost'		=> $dbhost,
			'dbname'		=> $dbname,
			'dbuser'		=> $dbuser,
			'dbpasswd'		=> $dbpasswd,
			'table_prefix'	=> isset($table_prefix) ? $table_prefix : 'phpbb_',
			'backend'		=> $backend,		
			'version'		=> $phpbbversion,
			'acm_type'		=> isset($acm_type) ? $acm_type : '',
			'status'		=> defined('PHPBB_INSTALLED') ? true : false,		
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
			'dbname'			=> $db_name, // 'smf';
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

		$val = $portal_config['rand_seed'] . microtime();
		$val = md5($val);
		$portal_config['rand_seed'] = md5($portal_config['rand_seed'] . $val . 'a');

		if($dss_seeded !== true)
		{
			$sql = "UPDATE " . PORTAL_TABLE . " SET
				rand_seed = '" . $portal_config['rand_seed'] . "'
				WHERE portal_id = '1'";

			if( !$db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Unable to reseed PRNG", "", __LINE__, __FILE__, $sql);
			}

			$dss_seeded = true;
		}

		return substr($val, 4, 16);
	}

	function make_jumpbox($action, $match_forum_id = 0)
	{
		global $template, $userdata, $lang, $db, $nav_links, $phpEx, $SID;

	//	$is_auth = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);

		$sql = "SELECT c.cat_id, c.cat_title, c.cat_order
			FROM " . CATEGORIES_TABLE . " c, " . FORUMS_TABLE . " f
			WHERE f.cat_id = c.cat_id
			GROUP BY c.cat_id, c.cat_title, c.cat_order
			ORDER BY c.cat_order";
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't obtain category list.", "", __LINE__, __FILE__, $sql);
		}

		$category_rows = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$category_rows[] = $row;
		}

		if ( $total_categories = count($category_rows) )
		{
			$sql = "SELECT *
				FROM " . FORUMS_TABLE . "
				ORDER BY cat_id, forum_order";
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
			}

			$boxstring = '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"><option value="-1">' . $lang['Select_forum'] . '</option>';

			$forum_rows = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				$forum_rows[] = $row;
			}

			if ( $total_forums = count($forum_rows) )
			{
				for($i = 0; $i < $total_categories; $i++)
				{
					$boxstring_forums = '';
					for($j = 0; $j < $total_forums; $j++)
					{
						if ( $forum_rows[$j]['cat_id'] == $category_rows[$i]['cat_id'] && $forum_rows[$j]['auth_view'] <= AUTH_REG )
						{

	//					if ( $forum_rows[$j]['cat_id'] == $category_rows[$i]['cat_id'] && $is_auth[$forum_rows[$j]['forum_id']]['auth_view'] )
	//					{
							$selected = ( $forum_rows[$j]['forum_id'] == $match_forum_id ) ? 'selected="selected"' : '';
							$boxstring_forums .=  '<option value="' . $forum_rows[$j]['forum_id'] . '"' . $selected . '>' . $forum_rows[$j]['forum_name'] . '</option>';

							//
							// Add an array to $nav_links for the Mozilla navigation bar.
							// 'chapter' and 'forum' can create multiple items, therefore we are using a nested array.
							//
							$nav_links['chapter forum'][$forum_rows[$j]['forum_id']] = array (
								'url' => mx_append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=" . $forum_rows[$j]['forum_id']),
								'title' => $forum_rows[$j]['forum_name']
							);

						}
					}

					if ( $boxstring_forums != '' )
					{
						$boxstring .= '<option value="-1">&nbsp;</option>';
						$boxstring .= '<option value="-1">' . $category_rows[$i]['cat_title'] . '</option>';
						$boxstring .= '<option value="-1">----------------</option>';
						$boxstring .= $boxstring_forums;
					}
				}
			}

			$boxstring .= '</select>';
		}
		else
		{
			$boxstring .= '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"></select>';
		}

		// Let the jumpbox work again in sites having additional session id checks.
	//	if ( !empty($SID) )
	//	{
			$boxstring .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
	//	}

		$template->set_filenames(array(
			'jumpbox' => 'jumpbox.tpl')
		);
		$template->assign_vars(array(
			'L_GO' => $lang['Go'],
			'L_JUMP_TO' => $lang['Jump_to'],
			'L_SELECT_FORUM' => $lang['Select_forum'],

			'S_JUMPBOX_SELECT' => $boxstring,
			'S_JUMPBOX_ACTION' => mx_append_sid($action))
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
		
		/**********/
		$layouttemplate = isset($layouttemplate) ? $layouttemplate : "";
		// If MX-Publisher frame template is not set, instantiate it
		if (!is_object($layouttemplate))
		{
			//
			// Initialize template
			//
			$layouttemplate = new mx_Template( $mx_root_path . 'templates/'. $theme['template_name'], $board_config, $db );
		}
		
		switch ($mode)
		{
			case 'generate_login_logout_stats':

				if ( $userdata['session_logged_in'] )
				{
					$is_logged = true;
					$u_login_logout = 'login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];
					$l_login_logout = $lang['Logout'] . ' [ ' . $userdata['username'] . ' ]';
				}
				else
				{
					$is_logged = false;
					$u_login_logout = 'login.'.$phpEx;
					$l_login_logout = $lang['Login'];
				}

				$s_last_visit = ( $userdata['session_logged_in'] ) ? $phpBB2->create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']) : '';

				//
				// Obtain number of new private messages
				// if user is logged in
				//
				if ( ($userdata['session_logged_in']) && (empty($gen_simple_header)) )
				{
					if ( $userdata['user_new_privmsg'] )
					{
						$l_message_new = ( $userdata['user_new_privmsg'] == 1 ) ? $lang['New_pm'] : $lang['New_pms'];
						$l_privmsgs_text = sprintf($l_message_new, $userdata['user_new_privmsg']);

						if ( $userdata['user_last_privmsg'] > $userdata['user_lastvisit'] )
						{
							$sql = "UPDATE " . USERS_TABLE . "
								SET user_last_privmsg = " . $userdata['user_lastvisit'] . "
								WHERE user_id = " . $userdata['user_id'];
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
						$mx_priv_msg = $lang['Private_Messages'] . ' (' . $userdata['user_new_privmsg'] . ')';
					}
					else
					{
						$l_privmsgs_text = $lang['No_new_pm'];

						$s_privmsg_new = 0;
						$icon_pm = $images['pm_no_new_msg'];
						$mx_priv_msg = $lang['Private_Messages'];
					}

					if ( $userdata['user_unread_privmsg'] )
					{
						$l_message_unread = ( $userdata['user_unread_privmsg'] == 1 ) ? $lang['Unread_pm'] : $lang['Unread_pms'];
						$l_privmsgs_text_unread = sprintf($l_message_unread, $userdata['user_unread_privmsg']);
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

				$u_register = 'profile.'.$phpEx.'?mode=register' ;
				$u_profile = 'profile.'.$phpEx.'?mode=editprofile';
				$u_privatemsgs = 'privmsg.'.$phpEx.'?folder=inbox';
				$u_privatemsgs_popup = 'privmsg.'.$phpEx.'?mode=newpm';
				$u_search = 'search.'.$phpEx;
				$u_memberlist = 'memberlist.'.$phpEx;
				$u_modcp = 'modcp.'.$phpEx;
				$u_faq = 'faq.'.$phpEx;
				$u_viewonline = 'viewonline.'.$phpEx;
				$u_group_cp = 'groupcp.'.$phpEx;
				$u_sendpassword = mx3_append_sid("{$phpbb_root_path}profile.$phpEx", 'mode=sendpassword');

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
				$current_phpbb_version = '0.0.0';

				$template->assign_vars(array(
					'PHPBB_BACKEND'				=> true,
					'PHPBB_VERSION' 			=> ($userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS) ? $current_phpbb_version : '',
					'U_PHPBB_ROOT_PATH' 		=> PHPBB_URL,
				));

				break;
		}
	}

	/**
	 * obtain_forum_config
	 *
	 * @access public
	 * @param boolean $use_cache
	 * @return unknown
	 */
	function obtain_forum_config($use_cache = true)
	{
		if ( ($config = $this->obtain_portal_config($use_cache)) )
		{
			return $config;
		}
	}
	
	/**
	* Set forum config values
	 *
	 * @param unknown_type $config_name
	 * @param unknown_type $config_value
	 */
	function set_forum_config($key, $new_value, $use_cache = false)
	{
		$this->set_portal_config($key, $new_value);
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
					die("mx_bakend::obtain_portal_config(); Couldnt query portal configuration, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
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
			
			//$after = (!empty($column_data['after'])) ? ' AFTER ' . $column_data['after'] : '';
			//$sql = 'ALTER TABLE `' . $table . '` ADD `' . $column_name . '` ' . (($column_data['column_type_sql'] = 'NULL') ? 'TEXT' :  $column_data['column_type_sql']) . ' ' . (!empty($column_data[$column_name]) ? $column_data[$column_name] : 'NULL') . ' DEFAULT NULL'  . $after;
					
			$db->sql_query($sql);
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
		
		if (!isset($mx_user->data[$key]) || ($key == 'user_style'))
		{
			mx_message_die(GENERAL_ERROR, "Wrong Backend? Adding this entry $key key to update MXP configuration  is not supported with this backend.", "", __LINE__, __FILE__, $sql);	
		}
		
		$sql = "UPDATE " . USERS_TABLE . "
		SET " . $db->sql_build_array('UPDATE', utf8_normalize_nfc($new)) . "
		WHERE user_id = '" . $mx_user->data['user_id'] . "'";		
		if (!($db->sql_query($sql)))
		{
			mx_message_die(GENERAL_ERROR, "Failed to update user data value ", "", __LINE__, __FILE__, $sql);
		}
		
		if (!$db->sql_affectedrows() && !isset($mx_user->data[$key]))
		{
			mx_message_die(GENERAL_ERROR, "Wrong Backend? Adding missing entry key to update MXP configuration  is not supported ATM.", "", __LINE__, __FILE__, $sql);	
		}
		$mx_user->data[$key] = $new_value;
	}	

	/**
	 * Enter description here...
	 *
	 * @access public
	 * @param boolean $use_cache
	 * @return unknown
	 */
	function obtain_phpbb_config($use_cache = true)
	{
		global $db, $mx_cache;

		if (($config = $mx_cache->get('phpbb_config')) && ($use_cache) )
		{
			return $config;
		}
		else
		{
			$sql = "SELECT *
				FROM " . CONFIG_TABLE;

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				if (!function_exists('mx_message_die'))
				{
					die("mx_backend::obtain_phpbb_config(); Couldnt query config information, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
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
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function generate_group_select_sql()
	{
		$sql = "SELECT group_id, group_name
			FROM " . GROUPS_TABLE . "
			WHERE group_single_user <> " . TRUE . "
			ORDER BY group_name ASC";
		return $sql;
	}

	/**
	* $new_group_id = $mx_backend->get_group_id('REGISTERED');
	* Return the group_id for a given group name
	*/
	function get_group_id($group_name = 'REGISTERED')
	{
		global $db, $group_mapping;

		//Default Groups for phpBB3
		$default_groups = array(
			'GUESTS',
			'REGISTERED',
			'REGISTERED_COPPA',
			'GLOBAL_MODERATORS',
			'ADMINISTRATORS',
			'BOTS',
		);

		// first retrieve default group id
		if (empty($group_mapping))
		{
			/* * /
			$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . "
				WHERE group_name = '" . $db->sql_escape($group_name) . "'
					AND group_type = " . GROUP_SPECIAL;
			/* */

			$sql = 'SELECT group_name, group_id
				FROM ' . GROUPS_TABLE;
			$result = $db->sql_query($sql);

			$group_mapping = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$group_mapping[strtoupper($row['group_name'])] = (int) $row['group_id'];
			}
			$db->sql_freeresult($result);
		}

		/** /
		if (!count($group_mapping))
		{
			add_default_groups();
			return get_group_id($group_name);
		}
		/**/

		if (isset($group_mapping[strtoupper($group_name)]))
		{
			return $group_mapping[strtoupper($group_name)];
		}

		// generate user account data
		return (int) $group_mapping[$group_name];
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
			$sql = "SELECT *
				FROM " . SESSIONS_TABLE . "
				WHERE session_logged_in = 0
					AND session_time >= " . ( time() - 300 ) . "
				ORDER BY session_time DESC";
		}
		else
		{
			$sql = "SELECT u.*, s.*
				FROM " . USERS_TABLE . " u, " . SESSIONS_TABLE . " s
				WHERE s.session_logged_in = " . TRUE . "
					AND u.user_id = s.session_user_id
					AND u.user_id <> " . ANONYMOUS . "
					AND s.session_time >= " . ( time() - 300 ) . "
				ORDER BY u.user_session_time DESC";
		}
		return $sql;
	}

	/**
	 * decode the IP.
	 *
	 * @param unknown_type $str_ip
	 * @return unknown
	 */
	function decode_ip($str_ip)
	{
		global $phpBB2;
		
		return $phpBB2->decode_ip($str_ip);
	}
	
	//
	// Encode the IP from decimals into hexademicals
	//
	function encode_ip($dotquad_ip)
	{
		$ip_check = 4; //If is under 4 partial IP will be returned
		$ip_sep = '';
			
		if (strpos($dotquad_ip, '::f') || strpos($dotquad_ip, '::F') || strpos($dotquad_ip, '::1'))
		{
			$dotquad_ip = '127.0.0.1';
		}
		
		if (strpos($dotquad_ip, '.'))
		{
			$ip_sep = explode('.', $dotquad_ip);
			return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
		}
		
		//Recheck IP_SEP
		if (strpos($dotquad_ip, '.'))
		{
			$ip_sep = implode('.', array_slice(explode('.', $dotquad_ip), 0, $ip_check));
			return $ip_sep[0] . '.' . $ip_sep[1] . '.' . $ip_sep[2] . '.' . $ip_sep[3];
		}	
		
		if (strpos($dotquad_ip, ':'))
		{
			$short_ipv6 = $this->short_ipv6($dotquad_ip, $ip_check);
			
		   if (preg_match('/^::(\S+\.\S+)$/', $short_ipv6, $match)) 
		   {
				$chunks = explode('.', $match[1]);
				return $chunks[0] . '.' . $chunks[1] . '.' . $chunks[2] . '.' . $chunks[3];
			} 	
		}
				
		return $dotquad_ip;		
	}	
	
	/**
	* Normalises an internet protocol address,
	* also checks whether the specified address is valid.
	*
	* IPv4 addresses are returned 'as is'.
	*
	* IPv6 addresses are normalised according to
	*	A Recommendation for IPv6 Address Text Representation
	*	http://tools.ietf.org/html/draft-ietf-6man-text-addr-representation-07
	*
	* @param string $address	IP address
	*
	* @return mixed		false if specified address is not valid,
	*					string otherwise
	*/
	function ip_normalise(string $address)
	{
		$ip_normalised = false;

		if (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
		{
			$ip_normalised = $address;
		}
		else if (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
		{
			$ip_normalised = (function_exists('inet_ntop') && function_exists('inet_pton')) ? @inet_ntop(@inet_pton($address)) : $address;

			// If is ipv4
			if (stripos($ip_normalised, '::ffff:') === 0)
			{
				$ip_normalised = substr($ip_normalised, 7);
			}
		}

		return $ip_normalised;
	}
	
	/** Borrowed from phpBB3
	* Returns the first block of the specified IPv6 address and as many additional
	* ones as specified in the length paramater.
	* If length is zero, then an empty string is returned.
	* If length is greater than 3 the complete IP will be returned
	*/
	function short_ipv6($ip, $length)
	{
		if ($length < 1)
		{
			return '';
		}

		// extend IPv6 addresses
		$blocks = substr_count($ip, ':') + 1;
		if ($blocks < 9)
		{
			$ip = str_replace('::', ':' . str_repeat('0000:', 9 - $blocks), $ip);
		}
		if ($ip[0] == ':')
		{
			$ip = '0000' . $ip;
		}
		if ($length < 4)
		{
			$ip = implode(':', @array_slice(explode(':', $ip), 0, 1 + $length));
		}

		return $ip;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function get_phpbb_version()
	{
		global $board_config;

		return '0.0.0';
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function confirm_backend()
	{
		global $portal_config;
		
		if (!defined('PORTAL_BACKEND')) 
		{
			@define('PORTAL_BACKEND', $portal_config['portal_backend']); //olympus
		}
		return $portal_config['portal_backend'];
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
	function get_username_string($mode, $user_id, $username = false, $user_color = false, $guest_username = false, $custom_profile_url = false)
	{
		global $lang, $mx_user, $userdata, $theme, $phpEx;

		$lang['Guest'] = !$guest_username ? $lang['Guest'] : $guest_username;

		$this_userdata = mx_get_userdata($user_id, false);

		$username = ($username) ? $username : $this_userdata['username'];

		if ($this_userdata['user_level'] == ADMIN)
		{
			$user_color = $theme['fontcolor3'];
			$user_style = 'style="color:#' . $user_color . '; font-weight : bold;"';
		}
		else if ($this_userdata['user_level'] == MOD)
		{
			$user_color = $theme['fontcolor2'];
			$user_style = 'style="color:#' . $user_color . '; font-weight : bold;"';
		}
		else
		{
			$user_colour = $theme['fontcolor1'];
			$user_style = 'style="font-weight : bold;"';
		}

		// Only show the link if not anonymous
		if ($user_id && $user_id != ANONYMOUS)
		{
			$profile_url = mx3_append_sid(PHPBB_URL . "profile.$phpEx", 'mode=viewprofile&amp;u=' . (int) $user_id);
			$full_url = '<a href="' . $profile_url . '"><span ' . $user_style . '>' . $username . '</span></a>';
		}
		else
		{
			$profile_url = $lang['Guest'];
			$full_url = $lang['Guest'];
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
				return $user_colour;
			break;

			case 'full':
			default:
				return $full_url;
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

	}

	/**
	 * Enter description here...
	 *
	 */
	function load_forum_stats()
	{

	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function phpbb_version_check($force_update = false, $warn_fail = false, $ttl = 86400)
	{
		return '';
	}
}

//
// Now load some bbcodes, to be extended for this backend (see below)
//
include_once($mx_root_path . 'includes/sessions/internal/bbcode.' . $phpEx); // BBCode associated functions
?>