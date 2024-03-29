<?php
/**
*
* @package phpBB3
* @version $Id: functions.php,v 1.29 2023/10/17 15:45:39 orynider Exp $
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
 * @ignore
 */
if (!defined('IN_PORTAL'))
{
	exit;
}

//
// MODIFICATIONS:
// Common global functions
// Fixes for MX-Publisher:
// $board_config -> $board_config
// $cache -> $mx_cache
//

//
// Class phpBB3 - function container
//
class phpBB3_top
{
	/**
	* set_var
	*
	* Set variable, used by {@link request_var the request_var function}
	*
	* @access private
	*/
	public static function set_var(&$result, $var, $type, $multibyte = false)
	{
		settype($var, $type);
		$result = $var;

		if ($type == 'string')
		{
			$result = trim(htmlspecialchars(str_replace(array("\r\n", "\r"), array("\n", "\n"), $result), ENT_COMPAT, 'UTF-8'));

			if (!empty($result))
			{
				// Make sure multibyte characters are wellformed
				if ($multibyte)
				{
					if (!preg_match('/^./u', $result))
					{
						$result = '';
					}
				}
				else
				{
					// no multibyte, allow only ASCII (0-127)
					$result = preg_replace('/[\x80-\xFF]/', '?', $result);
				}
			}

			$result = (STRIP) ? stripslashes($result) : $result;
		}
	}

	/**
	* request_var
	*
	* Used to get passed variable
	*/
	public static function request_var($var_name, $default, $multibyte = false, $cookie = false)
	{
		if (!$cookie && isset($_COOKIE[$var_name]))
		{
			if (!isset($_GET[$var_name]) && !isset($_POST[$var_name]))
			{
				return (is_array($default)) ? array() : $default;
			}
			$_REQUEST[$var_name] = isset($_POST[$var_name]) ? $_POST[$var_name] : $_GET[$var_name];
		}

		if (!isset($_REQUEST[$var_name]) || (is_array($_REQUEST[$var_name]) && !is_array($default)) || (is_array($default) && !is_array($_REQUEST[$var_name])))
		{
			return (is_array($default)) ? array() : $default;
		}

		$var = $_REQUEST[$var_name];
		if (!is_array($default))
		{
			$type = gettype($default);
		}
		else
		{
			list($key_type, $type) = each($default);
			$type = gettype($type);
			$key_type = gettype($key_type);
			if ($type == 'array')
			{
				reset($default);
				$default = current($default);
				list($sub_key_type, $sub_type) = each($default);
				$sub_type = gettype($sub_type);
				$sub_type = ($sub_type == 'array') ? 'NULL' : $sub_type;
				$sub_key_type = gettype($sub_key_type);
			}
		}

		if (is_array($var))
		{
			$_var = $var;
			$var = array();

			foreach ($_var as $k => $v)
			{
				self::set_var($k, $k, $key_type);
				if ($type == 'array' && is_array($v))
				{
					foreach ($v as $_k => $_v)
					{
						if (is_array($_v))
						{
							$_v = null;
						}
						self::set_var($_k, $_k, $sub_key_type);
						self::set_var($var[$k][$_k], $_v, $sub_type, $multibyte);
					}
				}
				else
				{
					if ($type == 'array' || is_array($v))
					{
						$v = null;
					}
					self::set_var($var[$k], $v, $type, $multibyte);
				}
			}
		}
		else
		{
			self::set_var($var, $var, $type, $multibyte);
		}

		return $var;
	}

	/**
	* Set config value. Creates missing config entry.
	*/
	public static function set_config($board_config_name, $board_config_value, $is_dynamic = false)
	{
		global $db, $mx_cache, $board_config;

		$sql = 'UPDATE ' . CONFIG_TABLE . "
			SET config_value = '" . $db->sql_escape($board_config_value) . "'
			WHERE config_name = '" . $db->sql_escape($board_config_name) . "'";
		$db->sql_query($sql);

		if (!$db->sql_affectedrows() && !isset($board_config[$board_config_name]))
		{
			$sql = 'INSERT INTO ' . CONFIG_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				'config_name'	=> $board_config_name,
				'config_value'	=> $board_config_value,
				'is_dynamic'	=> ($is_dynamic) ? 1 : 0));
			$db->sql_query($sql);
		}

		$board_config[$board_config_name] = $board_config_value;

		if (!$is_dynamic)
		{
			$mx_cache->destroy('config');
		}
	}

	/**
	* Generates an alphanumeric random string of given length
	*/
	public static function gen_rand_string($num_chars = 8)
	{
		$rand_str = self::unique_id();
		$rand_str = str_replace('0', 'Z', strtoupper(base_convert($rand_str, 16, 35)));

		return substr($rand_str, 0, $num_chars);
	}

	/**
	* Return unique id
	* @param string $extra additional entropy
	*/
	public static function unique_id($extra = 'c')
	{
		static $dss_seeded = false;
		global $board_config;

		$val = $board_config['rand_seed'] . microtime();
		$val = md5($val);
		$board_config['rand_seed'] = md5($board_config['rand_seed'] . $val . $extra);

		if ($dss_seeded !== true && ($board_config['rand_seed_last_update'] < time() - rand(1,10)))
		{
			self::set_config('rand_seed', $board_config['rand_seed'], true);
			self::set_config('rand_seed_last_update', time(), true);
			$dss_seeded = true;
		}

		return substr($val, 4, 16);
	}

	/**
	* Return formatted string for filesizes
	*/
	public static function get_formatted_filesize($bytes, $add_size_lang = true)
	{
		global $mx_user;

		if ($bytes >= pow(2, 20))
		{
			return ($add_size_lang) ? round($bytes / 1024 / 1024, 2) . ' ' . $mx_user->lang['MIB'] : round($bytes / 1024 / 1024, 2);
		}

		if ($bytes >= pow(2, 10))
		{
			return ($add_size_lang) ? round($bytes / 1024, 2) . ' ' . $mx_user->lang['KIB'] : round($bytes / 1024, 2);
		}

		return ($add_size_lang) ? ($bytes) . ' ' . $mx_user->lang['BYTES'] : ($bytes);
	}

	/**
	* Determine whether we are approaching the maximum execution time. Should be called once
	* at the beginning of the script in which it's used.
	* @return	bool	Either true if the maximum execution time is nearly reached, or false
	*					if some time is still left.
	*/
	public static function still_on_time($extra_time = 15)
	{
		static $max_execution_time, $start_time;

		$time = explode(' ', microtime());
		$current_time = $time[0] + $time[1];

		if (empty($max_execution_time))
		{
			$max_execution_time = (function_exists('ini_get')) ? (int) @ini_get('max_execution_time') : (int) @get_cfg_var('max_execution_time');

			// If zero, then set to something higher to not let the user catch the ten seconds barrier.
			if ($max_execution_time === 0)
			{
				$max_execution_time = 50 + $extra_time;
			}

			$max_execution_time = min(max(10, ($max_execution_time - $extra_time)), 50);

			// For debugging purposes
			// $max_execution_time = 10;

			global $starttime;
			$start_time = (empty($starttime)) ? $current_time : $starttime;
		}

		return (ceil($current_time - $start_time) < $max_execution_time) ? true : false;
	}

	/**
	*
	* @version Version 0.1 / $Id: functions.php,v 1.28 2014/05/16 18:02:39 orynider Exp $
	*
	* Portable PHP password hashing framework.
	*
	* Written by Solar Designer <solar at openwall.com> in 2004-2006 and placed in
	* the public domain.
	*
	* There's absolutely no warranty.
	*
	* The homepage URL for this framework is:
	*
	*	http://www.openwall.com/phpass/
	*
	* Please be sure to update the Version line if you edit this file in any way.
	* It is suggested that you leave the main version number intact, but indicate
	* your project name (after the slash) and add your own revision information.
	*
	* Please do not change the "private" password hashing method implemented in
	* here, thereby making your hashes incompatible.  However, if you must, please
	* change the hash type identifier (the "$P$") to something different.
	*
	* Obviously, since this code is in the public domain, the above are not
	* requirements (there can be none), but merely suggestions.
	*
	*
	* Hash the password
	*/
	public static function phpbb_hash($password)
	{
		$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

		$random_state = self::unique_id();
		$random = '';
		$count = 6;

		if (($fh = @fopen('/dev/urandom', 'rb')))
		{
			$random = fread($fh, $count);
			fclose($fh);
		}

		if (strlen($random) < $count)
		{
			$random = '';

			for ($i = 0; $i < $count; $i += 16)
			{
				$random_state = md5(self::unique_id() . $random_state);
				$random .= pack('H*', md5($random_state));
			}
			$random = substr($random, 0, $count);
		}

		$hash = self::_hash_crypt_private($password, self::_hash_gensalt_private($random, $itoa64), $itoa64);

		if (strlen($hash) == 34)
		{
			return $hash;
		}

		return md5($password);
	}

	/**
	* Check for correct password
	*/
	public static function phpbb_check_hash($password, $hash)
	{
		$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		if (strlen($hash) == 34)
		{
			return (self::_hash_crypt_private($password, $hash, $itoa64) === $hash) ? true : false;
		}

		return (md5($password) === $hash) ? true : false;
	}

	/**
	* Generate salt for hash generation
	*/
	public static function _hash_gensalt_private($input, &$itoa64, $iteration_count_log2 = 6)
	{
		if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31)
		{
			$iteration_count_log2 = 8;
		}

		$output = '$H$';
		$output .= $itoa64[min($iteration_count_log2 + ((PHP_VERSION >= 5) ? 5 : 3), 30)];
		$output .= self::_hash_encode64($input, 6, $itoa64);

		return $output;
	}

	/**
	* Encode hash
	*/
	public static function _hash_encode64($input, $count, &$itoa64)
	{
		$output = '';
		$i = 0;

		do
		{
			$value = ord($input[$i++]);
			$output .= $itoa64[$value & 0x3f];

			if ($i < $count)
			{
				$value |= ord($input[$i]) << 8;
			}

			$output .= $itoa64[($value >> 6) & 0x3f];

			if ($i++ >= $count)
			{
				break;
			}

			if ($i < $count)
			{
				$value |= ord($input[$i]) << 16;
			}

			$output .= $itoa64[($value >> 12) & 0x3f];

			if ($i++ >= $count)
			{
				break;
			}

			$output .= $itoa64[($value >> 18) & 0x3f];
		}
		while ($i < $count);

		return $output;
	}

	/**
	* The crypt function/replacement
	*/
	public static function _hash_crypt_private($password, $setting, &$itoa64)
	{
		$output = '*';

		// Check for correct hash
		if (substr($setting, 0, 3) != '$H$')
		{
			return $output;
		}

		$count_log2 = strpos($itoa64, $setting[3]);

		if ($count_log2 < 7 || $count_log2 > 30)
		{
			return $output;
		}

		$count = 1 << $count_log2;
		$salt = substr($setting, 4, 8);

		if (strlen($salt) != 8)
		{
			return $output;
		}

		/**
		* We're kind of forced to use MD5 here since it's the only
		* cryptographic primitive available in all versions of PHP
		* currently in use.  To implement our own low-level crypto
		* in PHP would result in much worse performance and
		* consequently in lower iteration counts and hashes that are
		* quicker to crack (by non-PHP code).
		*/
		if (PHP_VERSION >= 5)
		{
			$hash = md5($salt . $password, true);
			do
			{
				$hash = md5($hash . $password, true);
			}
			while (--$count);
		}
		else
		{
			$hash = pack('H*', md5($salt . $password));
			do
			{
				$hash = pack('H*', md5($hash . $password));
			}
			while (--$count);
		}

		$output = substr($setting, 0, 12);
		$output .= self::_hash_encode64($hash, 16, $itoa64);

		return $output;
	}

	/**
	* Generate sort selection fields
	*/
	public static function gen_sort_selects(&$limit_days, &$sort_by_text, &$sort_days, &$sort_key, &$sort_dir, &$s_limit_days, &$s_sort_key, &$s_sort_dir, &$u_sort_param)
	{
		global $mx_user;

		$sort_dir_text = array('a' => $mx_user->lang['ASCENDING'], 'd' => $mx_user->lang['DESCENDING']);

		// Check if the key is selectable. If not, we reset to the first key found.
		// This ensures the values are always valid.
		if (!isset($limit_days[$sort_days]))
		{
			@reset($limit_days);
			$sort_days = key($limit_days);
		}

		if (!isset($sort_by_text[$sort_key]))
		{
			@reset($sort_by_text);
			$sort_key = key($sort_by_text);
		}

		if (!isset($sort_dir_text[$sort_dir]))
		{
			@reset($sort_dir_text);
			$sort_dir = key($sort_dir_text);
		}

		$s_limit_days = '<select name="st">';
		foreach ($limit_days as $day => $text)
		{
			$selected = ($sort_days == $day) ? ' selected="selected"' : '';
			$s_limit_days .= '<option value="' . $day . '"' . $selected . '>' . $text . '</option>';
		}
		$s_limit_days .= '</select>';

		$s_sort_key = '<select name="sk">';
		foreach ($sort_by_text as $key => $text)
		{
			$selected = ($sort_key == $key) ? ' selected="selected"' : '';
			$s_sort_key .= '<option value="' . $key . '"' . $selected . '>' . $text . '</option>';
		}
		$s_sort_key .= '</select>';

		$s_sort_dir = '<select name="sd">';
		foreach ($sort_dir_text as $key => $value)
		{
			$selected = ($sort_dir == $key) ? ' selected="selected"' : '';
			$s_sort_dir .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
		}
		$s_sort_dir .= '</select>';

		$u_sort_param = "st=$sort_days&amp;sk=$sort_key&amp;sd=$sort_dir";

		return;
	}

	/**
	* Generate Jumpbox
	*/
	public static function make_jumpbox($action, $forum_id = false, $select_all = false, $acl_list = false)
	{
		global $board_config, $phpbb_auth, $template, $mx_user, $db;

		if (!$board_config['load_jumpbox'])
		{
			return;
		}

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

		while ($row = $db->sql_fetchrow($result))
		{
			if ($row['left_id'] < $right)
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

			$right = $row['right_id'];

			if ($row['forum_type'] == FORUM_CAT && ($row['left_id'] + 1 == $row['right_id']))
			{
				// Non-postable forum with no subforums, don't display
				continue;
			}

			if (!$phpbb_auth->acl_get('f_list', $row['forum_id']))
			{
				// if the user does not have permissions to list this forum skip
				continue;
			}

			if ($acl_list && !$phpbb_auth->acl_gets($acl_list, $row['forum_id']))
			{
				continue;
			}

			if (!$display_jumpbox)
			{
				$template->assign_block_vars('jumpbox_forums', array(
					'FORUM_ID'		=> ($select_all) ? 0 : -1,
					'FORUM_NAME'	=> ($select_all) ? $mx_user->lang['ALL_FORUMS'] : $mx_user->lang['SELECT_FORUM'],
					'S_FORUM_COUNT'	=> $iteration)
				);

				$iteration++;
				$display_jumpbox = true;
			}

			$template->assign_block_vars('jumpbox_forums', array(
				'FORUM_ID'		=> $row['forum_id'],
				'FORUM_NAME'	=> $row['forum_name'],
				'SELECTED'		=> ($row['forum_id'] == $forum_id) ? ' selected="selected"' : '',
				'S_FORUM_COUNT'	=> $iteration,
				'S_IS_CAT'		=> ($row['forum_type'] == FORUM_CAT) ? true : false,
				'S_IS_LINK'		=> ($row['forum_type'] == FORUM_LINK) ? true : false,
				'S_IS_POST'		=> ($row['forum_type'] == FORUM_POST) ? true : false)
			);

			for ($i = 0; $i < $padding; $i++)
			{
				$template->assign_block_vars('jumpbox_forums.level', array());
			}
			$iteration++;
		}
		$db->sql_freeresult($result);
		unset($padding_store);

		$template->assign_vars(array(
			'S_DISPLAY_JUMPBOX'	=> $display_jumpbox,
			'S_JUMPBOX_ACTION'	=> $action)
		);

		return;
	}

	/**
	* Add a secret token to the form (requires the S_FORM_TOKEN template variable)
	* @param string  $form_name The name of the form; has to match the name used in check_form_key, otherwise no restrictions apply
	*/
	public static function add_form_key($form_name)
	{
		global $board_config, $template, $mx_user, $mx_acp;
		$now = time();
		$token_sid = ($mx_user->data['user_id'] == ANONYMOUS && !empty($board_config['form_token_sid_guests'])) ? $mx_user->session_id : '';
		$token = sha1($now . $mx_user->data['user_form_salt'] . $form_name . $token_sid);

		$s_fields = build_hidden_fields(array(
				'creation_time' => $now,
				'form_token'	=> $token,
		));
		$template->assign_var( 'S_FORM_TOKEN', $s_fields );
	}

	/**
	 * Check the form key. Required for all altering actions not secured by confirm_box
	 *
	 * @param string $form_name The name of the form; has to match the name used in add_form_key, otherwise no restrictions apply
	 * @param int $timespan The maximum acceptable age for a submitted form in seconds. Defaults to the config setting.
	 * @param string $return_page The address for the return link
	 * @param bool $trigger If true, the function will triger an error when encountering an invalid form
	 * @param int $minimum_time The minimum acceptable age for a submitted form in seconds
	 */
	public static function check_form_key($form_name, $timespan = false, $return_page = '', $trigger = false, $minimum_time = false)
	{
		global $board_config, $mx_user;
		if ( $timespan === false )
		{
			// we enforce a minimum value of half a minute here.
			$timespan = ( $board_config['form_token_lifetime'] == -1 ) ? -1 : max( 30, $board_config['form_token_lifetime'] );
		}
		if ( $minimum_time === false )
		{
			$minimum_time = ( int ) $board_config['form_token_mintime'];
		}

		if ( isset( $_POST['creation_time'] ) && isset( $_POST['form_token'] ) )
		{
			$creation_time = abs( self::request_var( 'creation_time', 0 ) );
			$token = self::request_var( 'form_token', '' );

			$diff = ( time() - $creation_time );

			if ( ( $diff >= $minimum_time ) && ( ( $diff <= $timespan ) || $timespan == -1 ) )
			{
				$token_sid = ( $mx_user->data['user_id'] == ANONYMOUS && !empty( $board_config['form_token_sid_guests'] ) ) ? $mx_user->session_id : '';

				$key = sha1( $creation_time . $mx_user->data['user_form_salt'] . $form_name . $token_sid );
				if ( $key === $token )
				{
					return true;
				}
			}
		}
		if ( $trigger )
		{
			trigger_error( $mx_user->lang['FORM_INVALID'] . $return_page );
		}
		print '<pre>';
		print_r( $_POST );
		die( 'here' );
		return false;
	}

	/**
	 * Add or edit a group. If we're editing a group we only update user
	 * parameters such as rank, etc. if they are changed
	 */
	public static function group_create( &$group_id, $type, $name, $desc, $group_attributes, $allow_desc_bbcode = false, $allow_desc_urls = false, $allow_desc_smilies = false )
	{
		global $phpbb_root_path, $board_config, $db, $mx_user, $file_upload;

		$error = array();
		$attribute_ary = array( 'group_colour' => 'string',
			'group_rank' => 'int',
			'group_avatar' => 'string',
			'group_avatar_type' => 'int',
			'group_avatar_width' => 'int',
			'group_avatar_height' => 'int',

			'group_receive_pm' => 'int',
			'group_legend' => 'int',
			'group_message_limit' => 'int',

			'group_founder_manage' => 'int',
			);
		// Those are group-only attributes
		$group_only_ary = array( 'group_receive_pm', 'group_legend', 'group_message_limit', 'group_founder_manage' );
		// Check data. Limit group name length.
		if ( !utf8_strlen( $name ) || utf8_strlen( $name ) > 60 )
		{
			$error[] = ( !utf8_strlen( $name ) ) ? $mx_user->lang['GROUP_ERR_USERNAME'] : $mx_user->lang['GROUP_ERR_USER_LONG'];
		}

		$err = group_validate_groupname( $group_id, $name );
		if ( !empty( $err ) )
		{
			$error[] = $mx_user->lang[$err];
		}

		if ( !in_array( $type, array( GROUP_OPEN, GROUP_CLOSED, GROUP_HIDDEN, GROUP_SPECIAL, GROUP_FREE ) ) )
		{
			$error[] = $mx_user->lang['GROUP_ERR_TYPE'];
		}

		if ( !sizeof( $error ) )
		{
			$mx_user_ary = array();
			$sql_ary = array( 'group_name' => ( string ) $name,
				'group_desc' => ( string ) $desc,
				'group_desc_uid' => '',
				'group_desc_bitfield' => '',
				'group_type' => ( int ) $type,
				);
			// Parse description
			if ( $desc )
			{
				self::generate_text_for_storage( $sql_ary['group_desc'], $sql_ary['group_desc_uid'], $sql_ary['group_desc_bitfield'], $sql_ary['group_desc_options'], $allow_desc_bbcode, $allow_desc_urls, $allow_desc_smilies );
			}

			if ( sizeof( $group_attributes ) )
			{
				foreach ( $attribute_ary as $attribute => $_type )
				{
					if ( isset( $group_attributes[$attribute] ) )
					{
						settype( $group_attributes[$attribute], $_type );
						$sql_ary[$attribute] = $group_attributes[$attribute];
					}
				}
			}
			// Setting the log message before we set the group id (if group gets added)
			$log = ( $group_id ) ? 'LOG_GROUP_UPDATED' : 'LOG_GROUP_CREATED';

			$query = '';

			if ( $group_id )
			{
				$sql = 'SELECT user_id
				FROM ' . USERS_TABLE . '
				WHERE group_id = ' . $group_id;
				$result = $db->sql_query( $sql );

				while ( $row = $db->sql_fetchrow( $result ) )
				{
					$mx_user_ary[] = $row['user_id'];
				}
				$db->sql_freeresult( $result );

				if ( isset( $sql_ary['group_avatar'] ) && !$sql_ary['group_avatar'] )
				{
					remove_default_avatar( $group_id, $mx_user_ary );
				}
				if ( isset( $sql_ary['group_rank'] ) && !$sql_ary['group_rank'] )
				{
					remove_default_rank( $group_id, $mx_user_ary );
				}

				$sql = 'UPDATE ' . GROUPS_TABLE . '
				SET ' . $db->sql_build_array( 'UPDATE', $sql_ary ) . "
				WHERE group_id = $group_id";
				$db->sql_query( $sql );
				// Since we may update the name too, we need to do this on other tables too...
				$sql = 'UPDATE ' . MODERATOR_CACHE_TABLE . "
				SET group_name = '" . $db->sql_escape( $sql_ary['group_name'] ) . "'
				WHERE group_id = $group_id";
				$db->sql_query( $sql );
			}
			else
			{
				$sql = 'INSERT INTO ' . GROUPS_TABLE . ' ' . $db->sql_build_array( 'INSERT', $sql_ary );
				$db->sql_query( $sql );
			}

			if ( !$group_id )
			{
				$group_id = $db->sql_nextid();
				if ( isset( $sql_ary['group_avatar_type'] ) && $sql_ary['group_avatar_type'] == AVATAR_UPLOAD )
				{
					group_correct_avatar( $group_id, $sql_ary['group_avatar'] );
				}
			}
			// Set user attributes
			$sql_ary = array();
			if ( sizeof( $group_attributes ) )
			{
				foreach ( $attribute_ary as $attribute => $_type )
				{
					if ( isset( $group_attributes[$attribute] ) && !in_array( $attribute, $group_only_ary ) )
					{
						// If we are about to set an avatar, we will not overwrite user avatars if no group avatar is set...
						if ( strpos( $attribute, 'group_avatar' ) === 0 && !$group_attributes[$attribute] )
						{
							continue;
						}

						$sql_ary[$attribute] = $group_attributes[$attribute];
					}
				}
			}

			if ( sizeof( $sql_ary ) && sizeof( $mx_user_ary ) )
			{
				group_set_user_default( $group_id, $mx_user_ary, $sql_ary );
			}

			$name = ( $type == GROUP_SPECIAL ) ? $mx_user->lang['G_' . $name] : $name;
			//add_log( 'admin', $log, $name );

			//group_update_listings( $group_id );
		}

		return ( sizeof( $error ) ) ? $error : false;
	}

}
// Compatibility functions

if (!function_exists('array_combine'))
{
	/**
	* A wrapper for the PHP5 function array_combine()
	* @param array $keys contains keys for the resulting array
	* @param array $values contains values for the resulting array
	*
	* @return Returns an array by using the values from the keys array as keys and the
	* 	values from the values array as the corresponding values. Returns false if the
	* 	number of elements for each array isn't equal or if the arrays are empty.
	*/
	function array_combine($keys, $values)
	{
		$keys = array_values($keys);
		$values = array_values($values);

		$n = sizeof($keys);
		$m = sizeof($values);
		if (!$n || !$m || ($n != $m))
		{
			return false;
		}

		$combined = array();
		for ($i = 0; $i < $n; $i++)
		{
			$combined[$keys[$i]] = $values[$i];
		}
		return $combined;
	}
}

if (!function_exists('str_split'))
{
	/**
	* A wrapper for the PHP5 function str_split()
	* @param array $string contains the string to be converted
	* @param array $split_length contains the length of each chunk
	*
	* @return  Converts a string to an array. If the optional split_length parameter is specified,
	*  	the returned array will be broken down into chunks with each being split_length in length,
	*  	otherwise each chunk will be one character in length. FALSE is returned if split_length is
	*  	less than 1. If the split_length length exceeds the length of string, the entire string is
	*  	returned as the first (and only) array element.
	*/
	function str_split($string, $split_length = 1)
	{
		if ($split_length < 1)
		{
			return false;
		}
		else if ($split_length >= strlen($string))
		{
			return array($string);
		}
		else
		{
			preg_match_all('#.{1,' . $split_length . '}#s', $string, $matches);
			return $matches[0];
		}
	}
}

if (!function_exists('stripos'))
{
	/**
	* A wrapper for the PHP5 function stripos
	* Find position of first occurrence of a case-insensitive string
	*
	* @param string $haystack is the string to search in
	* @param string $needle is the string to search for
	*
	* @return mixed Returns the numeric position of the first occurrence of needle in the haystack string. Unlike strpos(), stripos() is case-insensitive.
	* Note that the needle may be a string of one or more characters.
	* If needle is not found, stripos() will return boolean FALSE.
	*/
	function stripos($haystack, $needle)
	{
		if (preg_match('#' . preg_quote($needle, '#') . '#i', $haystack, $m))
		{
			return strpos($haystack, $m[0]);
		}

		return false;
	}
}

/**
* Checks if a path ($path) is absolute or relative
*
* @param string $path Path to check absoluteness of
* @return boolean
*/
function phpbb_is_absolute($path)
{
	return (isset($path[0]) && $path[0] == '/' || preg_match('#^[a-z]:[/\\\]#i', $path)) ? true : false;
}

/**
* @author Chris Smith <chris@project-minerva.org>
* @copyright 2006 Project Minerva Team
* @param string $path The path which we should attempt to resolve.
* @return mixed
*/
function phpbb_own_realpath($path)
{
	global $request;

	// Now to perform funky shizzle

	// Switch to use UNIX slashes
	$path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
	$path_prefix = '';

	// Determine what sort of path we have
	if (phpbb_is_absolute($path))
	{
		$absolute = true;

		if ($path[0] == '/')
		{
			// Absolute path, *NIX style
			$path_prefix = '';
		}
		else
		{
			// Absolute path, Windows style
			// Remove the drive letter and colon
			$path_prefix = $path[0] . ':';
			$path = substr($path, 2);
		}
	}
	else
	{
		// Relative Path
		// Prepend the current working directory
		if (function_exists('getcwd'))
		{
			// This is the best method, hopefully it is enabled!
			$path = str_replace(DIRECTORY_SEPARATOR, '/', getcwd()) . '/' . $path;
			$absolute = true;
			if (preg_match('#^[a-z]:#i', $path))
			{
				$path_prefix = $path[0] . ':';
				$path = substr($path, 2);
			}
			else
			{
				$path_prefix = '';
			}
		}
		else if ($request->server('SCRIPT_FILENAME'))
		{
			// Warning: If chdir() has been used this will lie!
			// Warning: This has some problems sometime (CLI can create them easily)
			$filename = htmlspecialchars_decode($request->server('SCRIPT_FILENAME'));
			$path = str_replace(DIRECTORY_SEPARATOR, '/', dirname($filename)) . '/' . $path;
			$absolute = true;
			$path_prefix = '';
		}
		else
		{
			// We have no way of getting the absolute path, just run on using relative ones.
			$absolute = false;
			$path_prefix = '.';
		}
	}

	// Remove any repeated slashes
	$path = preg_replace('#/{2,}#', '/', $path);

	// Remove the slashes from the start and end of the path
	$path = trim($path, '/');

	// Break the string into little bits for us to nibble on
	$bits = explode('/', $path);

	// Remove any . in the path, renumber array for the loop below
	$bits = array_values(array_diff($bits, array('.')));

	// Lets get looping, run over and resolve any .. (up directory)
	for ($i = 0, $max = sizeof($bits); $i < $max; $i++)
	{
		// @todo Optimise
		if ($bits[$i] == '..' )
		{
			if (isset($bits[$i - 1]))
			{
				if ($bits[$i - 1] != '..')
				{
					// We found a .. and we are able to traverse upwards, lets do it!
					unset($bits[$i]);
					unset($bits[$i - 1]);
					$i -= 2;
					$max -= 2;
					$bits = array_values($bits);
				}
			}
			else if ($absolute) // ie. !isset($bits[$i - 1]) && $absolute
			{
				// We have an absolute path trying to descend above the root of the filesystem
				// ... Error!
				return false;
			}
		}
	}

	// Prepend the path prefix
	array_unshift($bits, $path_prefix);

	$resolved = '';

	$max = sizeof($bits) - 1;

	// Check if we are able to resolve symlinks, Windows cannot.
	$symlink_resolve = (function_exists('readlink')) ? true : false;

	foreach ($bits as $i => $bit)
	{
		if (@is_dir("$resolved/$bit") || ($i == $max && @is_file("$resolved/$bit")))
		{
			// Path Exists
			if ($symlink_resolve && is_link("$resolved/$bit") && ($link = readlink("$resolved/$bit")))
			{
				// Resolved a symlink.
				$resolved = $link . (($i == $max) ? '' : '/');
				continue;
			}
		}
		else
		{
			// Something doesn't exist here!
			// This is correct realpath() behaviour but sadly open_basedir and safe_mode make this problematic
			// return false;
		}
		$resolved .= $bit . (($i == $max) ? '' : '/');
	}

	// @todo If the file exists fine and open_basedir only has one path we should be able to prepend it
	// because we must be inside that basedir, the question is where...
	// @internal The slash in is_dir() gets around an open_basedir restriction
	if (!@file_exists($resolved) || (!@is_dir($resolved . '/') && !is_file($resolved)))
	{
		return false;
	}

	// Put the slashes back to the native operating systems slashes
	$resolved = str_replace('/', DIRECTORY_SEPARATOR, $resolved);

	// Check for DIRECTORY_SEPARATOR at the end (and remove it!)
	if (substr($resolved, -1) == DIRECTORY_SEPARATOR)
	{
		return substr($resolved, 0, -1);
	}

	return $resolved; // We got here, in the end!
}

/*
* A wrapper for realpath
*/
if (!function_exists('realpath'))
{
	/**
	* A wrapper for realpath
	* @ignore
	*/
	function phpbb_realpath($path)
	{
		return phpbb_own_realpath($path);
	}
}
elseif (!function_exists('phpbb_realpath'))
{
	/**
	* A wrapper for realpath
	*/
	function phpbb_realpath($path)
	{
		$realpath = realpath($path);

		// Strangely there are provider not disabling realpath but returning strange values. :o
		// We at least try to cope with them.
		if ($realpath === $path || $realpath === false)
		{
			return phpbb_own_realpath($path);
		}

		// Check for DIRECTORY_SEPARATOR at the end (and remove it!)
		if (substr($realpath, -1) == DIRECTORY_SEPARATOR)
		{
			$realpath = substr($realpath, 0, -1);
		}

		return $realpath;
	}
}

/**
* Renaming this for now...
* for compatibility with phpBB 3.0.x Olympus.
* @ignore
*/
function phpbb3_realpath($path)
{
	return phpbb_realpath($path);
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

class phpBB3 extends phpBB3_top
// functions used for building option fields
{

	/**
	* Pick a language, any language ...
	*/
	public static function language_select($default = '')
	{
		global $db;

		$sql = 'SELECT lang_iso, lang_local_name
			FROM ' . LANG_TABLE . '
			ORDER BY lang_english_name';
		$result = $db->sql_query($sql);

		$lang_options = '';
		while ($row = $db->sql_fetchrow($result))
		{
			$selected = ($row['lang_iso'] == $default) ? ' selected="selected"' : '';
			$lang_options .= '<option value="' . $row['lang_iso'] . '"' . $selected . '>' . $row['lang_local_name'] . '</option>';
		}
		$db->sql_freeresult($result);

		return $lang_options;
	}
	
	/**
	* Pick a language, any language for the session_lang from the dropdown box
	* Do not use this but the block that comes with mx_coreblocks
	* Keeped here for refence
	* added 2013-11-5 by Ory
	*/
	public static function session_lang_select($default = '')
	{
		global $db;

		$sql = 'SELECT lang_iso, lang_local_name
			FROM ' . LANG_TABLE . '
			ORDER BY lang_english_name';
		$result = $db->sql_query($sql);

		$lang_options = '';
		while ($row = $db->sql_fetchrow($result))
		{
			$selected = ($row['lang_iso'] == $default) ? ' selected="selected"' : '';
			$lang_options .= '<option value="' . $row['lang_iso'] . '"' . $selected . '>' . $row['lang_local_name'] . '</option>';
		}
		$db->sql_freeresult($result);

		return $lang_options;
	}

	/**
	* Pick a language, any language for the session_lang from the language flags bar
	* To do: Port this to mx_session_lang_click() i.e. for mx_coreblocks module and upload the flag imageset only to _core
	* Keeped here for refence
	* added 2013-11-5 by Ory	
	*/
	public static function session_lang_click($default = '', $query_string)
	{
		global $db, $mx_user, $phpbb_root_path;

		$sql = 'SELECT lang_iso, lang_local_name
			FROM ' . LANG_TABLE . '
			ORDER BY lang_english_name';
		$result = $db->sql_query($sql);

		$lang_options = '';

		while ($row = $db->sql_fetchrow($result))
		{
			if ($row['lang_iso'] !== $default)
			{
				$lang_options .= ' <a href="' . $mx_user->page['root_script_path'] . $mx_user->page['page_name'] . '?session_lang=' . $row['lang_iso'] . $query_string . '" onclick="document.getElementById(session_lang);submit();" title="' . $row['lang_local_name'] . '"><img src="' . $phpbb_root_path . 'styles/' . $mx_user->theme['imageset_path'] . '/imageset/' . $row['lang_iso'] . '/icon_lang_flag.gif" alt="' . $row['lang_local_name'] . '" /></a> ';
			}
		}
		$db->sql_freeresult($result);

		return $lang_options;
	}
	

	/**
	* Pick a template/theme combo,
	*/
	public static function style_select($default = '', $all = false)
	{
		global $db;

		$sql_where = (!$all) ? 'WHERE style_active = 1 ' : '';
		$sql = 'SELECT style_id, style_name
			FROM ' . STYLES_TABLE . "
			$sql_where
			ORDER BY style_name";
		$result = $db->sql_query($sql);

		$style_options = '';
		while ($row = $db->sql_fetchrow($result))
		{
			$selected = ($row['style_id'] == $default) ? ' selected="selected"' : '';
			$style_options .= '<option value="' . $row['style_id'] . '"' . $selected . '>' . $row['style_name'] . '</option>';
		}
		$db->sql_freeresult($result);

		return $style_options;
	}

	/**
	* Pick a timezone
	*/
	public static function tz_select($default = '', $truncate = false)
	{
		global $mx_user;

		$tz_select = '';

		foreach ($mx_user->lang['tz'] as $offset => $zone)
		{
			if ($truncate)
			{
				$zone_trunc = self::truncate_string($zone, 50, false, '...');
			}
			else
			{
				$zone_trunc = $zone;
			}

			if (is_numeric($offset))
			{
				$selected = ($offset == $default) ? ' selected="selected"' : '';
				$tz_select .= '<option title="'.$zone.'" value="' . $offset . '"' . $selected . '>' . $zone_trunc . '</option>';
			}
		}

		return $tz_select;
	}

	// Functions handling topic/post tracking/marking

	/**
	* Marks a topic/forum as read
	* Marks a topic as posted to
	*
	* @param int $mx_user_id can only be used with $mode == 'post'
	*/
	public static function markread($mode, $forum_id = false, $topic_id = false, $post_time = 0, $mx_user_id = 0)
	{
		global $db, $mx_user, $board_config;

		if ($mode == 'all')
		{
			if ($forum_id === false || !sizeof($forum_id))
			{
				if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
				{
					// Mark all forums read (index page)
					$db->sql_query('DELETE FROM ' . TOPICS_TRACK_TABLE . " WHERE user_id = {$mx_user->data['user_id']}");
					$db->sql_query('DELETE FROM ' . FORUMS_TRACK_TABLE . " WHERE user_id = {$mx_user->data['user_id']}");
					$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_lastmark = ' . time() . " WHERE user_id = {$mx_user->data['user_id']}");
				}
				else if ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])
				{
					$tracking_topics = (isset($_COOKIE[$board_config['cookie_name'] . '_track'])) ? ((STRIP) ? stripslashes($_COOKIE[$board_config['cookie_name'] . '_track']) : $_COOKIE[$board_config['cookie_name'] . '_track']) : '';
					$tracking_topics = ($tracking_topics) ? tracking_unserialize($tracking_topics) : array();

					unset($tracking_topics['tf']);
					unset($tracking_topics['t']);
					unset($tracking_topics['f']);
					$tracking_topics['l'] = base_convert(time() - $board_config['board_startdate'], 10, 36);

					$mx_user->set_cookie('track', tracking_serialize($tracking_topics), time() + 31536000);
					$_COOKIE[$board_config['cookie_name'] . '_track'] = (STRIP) ? addslashes(tracking_serialize($tracking_topics)) : tracking_serialize($tracking_topics);

					unset($tracking_topics);

					if ($mx_user->data['is_registered'])
					{
						$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_lastmark = ' . time() . " WHERE user_id = {$mx_user->data['user_id']}");
					}
				}
			}

			return;
		}
		else if ($mode == 'topics')
		{
			// Mark all topics in forums read
			if (!is_array($forum_id))
			{
				$forum_id = array($forum_id);
			}

			// Add 0 to forums array to mark global announcements correctly
			$forum_id[] = 0;

			if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
			{
				$sql = 'DELETE FROM ' . TOPICS_TRACK_TABLE . "
					WHERE user_id = {$mx_user->data['user_id']}
						AND " . $db->sql_in_set('forum_id', $forum_id);
				$db->sql_query($sql);

				$sql = 'SELECT forum_id
					FROM ' . FORUMS_TRACK_TABLE . "
					WHERE user_id = {$mx_user->data['user_id']}
						AND " . $db->sql_in_set('forum_id', $forum_id);
				$result = $db->sql_query($sql);

				$sql_update = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$sql_update[] = $row['forum_id'];
				}
				$db->sql_freeresult($result);

				if (sizeof($sql_update))
				{
					$sql = 'UPDATE ' . FORUMS_TRACK_TABLE . '
						SET mark_time = ' . time() . "
						WHERE user_id = {$mx_user->data['user_id']}
							AND " . $db->sql_in_set('forum_id', $sql_update);
					$db->sql_query($sql);
				}

				if ($sql_insert = array_diff($forum_id, $sql_update))
				{
					$sql_ary = array();
					foreach ($sql_insert as $f_id)
					{
						$sql_ary[] = array(
							'user_id'	=> (int) $mx_user->data['user_id'],
							'forum_id'	=> (int) $f_id,
							'mark_time'	=> time()
						);
					}

					$db->sql_multi_insert(FORUMS_TRACK_TABLE, $sql_ary);
				}
			}
			else if ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])
			{
				$tracking = (isset($_COOKIE[$board_config['cookie_name'] . '_track'])) ? ((STRIP) ? stripslashes($_COOKIE[$board_config['cookie_name'] . '_track']) : $_COOKIE[$board_config['cookie_name'] . '_track']) : '';
				$tracking = ($tracking) ? tracking_unserialize($tracking) : array();

				foreach ($forum_id as $f_id)
				{
					$topic_ids36 = (isset($tracking['tf'][$f_id])) ? $tracking['tf'][$f_id] : array();

					if (isset($tracking['tf'][$f_id]))
					{
						unset($tracking['tf'][$f_id]);
					}

					foreach ($topic_ids36 as $topic_id36)
					{
						unset($tracking['t'][$topic_id36]);
					}

					if (isset($tracking['f'][$f_id]))
					{
						unset($tracking['f'][$f_id]);
					}

					$tracking['f'][$f_id] = base_convert(time() - $board_config['board_startdate'], 10, 36);
				}

				if (isset($tracking['tf']) && empty($tracking['tf']))
				{
					unset($tracking['tf']);
				}

				$mx_user->set_cookie('track', tracking_serialize($tracking), time() + 31536000);
				$_COOKIE[$board_config['cookie_name'] . '_track'] = (STRIP) ? addslashes(tracking_serialize($tracking)) : tracking_serialize($tracking);

				unset($tracking);
			}

			return;
		}
		else if ($mode == 'topic')
		{
			if ($topic_id === false || $forum_id === false)
			{
				return;
			}

			if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
			{
				$sql = 'UPDATE ' . TOPICS_TRACK_TABLE . '
					SET mark_time = ' . (($post_time) ? $post_time : time()) . "
					WHERE user_id = {$mx_user->data['user_id']}
						AND topic_id = $topic_id";
				$db->sql_query($sql);

				// insert row
				if (!$db->sql_affectedrows())
				{
					$db->sql_return_on_error(true);

					$sql_ary = array(
						'user_id'		=> (int) $mx_user->data['user_id'],
						'topic_id'		=> (int) $topic_id,
						'forum_id'		=> (int) $forum_id,
						'mark_time'		=> ($post_time) ? (int) $post_time : time(),
					);

					$db->sql_query('INSERT INTO ' . TOPICS_TRACK_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary));

					$db->sql_return_on_error(false);
				}
			}
			else if ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])
			{
				$tracking = (isset($_COOKIE[$board_config['cookie_name'] . '_track'])) ? ((STRIP) ? stripslashes($_COOKIE[$board_config['cookie_name'] . '_track']) : $_COOKIE[$board_config['cookie_name'] . '_track']) : '';
				$tracking = ($tracking) ? tracking_unserialize($tracking) : array();

				$topic_id36 = base_convert($topic_id, 10, 36);

				if (!isset($tracking['t'][$topic_id36]))
				{
					$tracking['tf'][$forum_id][$topic_id36] = true;
				}

				$post_time = ($post_time) ? $post_time : time();
				$tracking['t'][$topic_id36] = base_convert($post_time - $board_config['board_startdate'], 10, 36);

				// If the cookie grows larger than 10000 characters we will remove the smallest value
				// This can result in old topics being unread - but most of the time it should be accurate...
				if (isset($_COOKIE[$board_config['cookie_name'] . '_track']) && strlen($_COOKIE[$board_config['cookie_name'] . '_track']) > 10000)
				{
					//echo 'Cookie grown too large' . print_r($tracking, true);

					// We get the ten most minimum stored time offsets and its associated topic ids
					$time_keys = array();
					for ($i = 0; $i < 10 && sizeof($tracking['t']); $i++)
					{
						$min_value = min($tracking['t']);
						$m_tkey = array_search($min_value, $tracking['t']);
						unset($tracking['t'][$m_tkey]);

						$time_keys[$m_tkey] = $min_value;
					}

					// Now remove the topic ids from the array...
					foreach ($tracking['tf'] as $f_id => $topic_id_ary)
					{
						foreach ($time_keys as $m_tkey => $min_value)
						{
							if (isset($topic_id_ary[$m_tkey]))
							{
								$tracking['f'][$f_id] = $min_value;
								unset($tracking['tf'][$f_id][$m_tkey]);
							}
						}
					}

					if ($mx_user->data['is_registered'])
					{
						$mx_user->data['user_lastmark'] = intval(base_convert(max($time_keys) + $board_config['board_startdate'], 36, 10));
						$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_lastmark = ' . $mx_user->data['user_lastmark'] . " WHERE user_id = {$mx_user->data['user_id']}");
					}
					else
					{
						$tracking['l'] = max($time_keys);
					}
				}

				$mx_user->set_cookie('track', tracking_serialize($tracking), time() + 31536000);
				$_COOKIE[$board_config['cookie_name'] . '_track'] = (STRIP) ? addslashes(tracking_serialize($tracking)) : tracking_serialize($tracking);
			}

			return;
		}
		else if ($mode == 'post')
		{
			if ($topic_id === false)
			{
				return;
			}

			$use_user_id = (!$mx_user_id) ? $mx_user->data['user_id'] : $mx_user_id;

			if ($board_config['load_db_track'] && $use_user_id != ANONYMOUS)
			{
				$db->sql_return_on_error(true);

				$sql_ary = array(
					'user_id'		=> (int) $use_user_id,
					'topic_id'		=> (int) $topic_id,
					'topic_posted'	=> 1
				);

				$db->sql_query('INSERT INTO ' . TOPICS_POSTED_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary));

				$db->sql_return_on_error(false);
			}

			return;
		}
	}

	/**
	* Get topic tracking info by using already fetched info
	*/
	public static function get_topic_tracking($forum_id, $topic_ids, &$rowset, $forum_mark_time, $global_announce_list = false)
	{
		global $board_config, $mx_user;

		$last_read = array();

		if (!is_array($topic_ids))
		{
			$topic_ids = array($topic_ids);
		}

		foreach ($topic_ids as $topic_id)
		{
			if (!empty($rowset[$topic_id]['mark_time']))
			{
				$last_read[$topic_id] = $rowset[$topic_id]['mark_time'];
			}
		}

		$topic_ids = array_diff($topic_ids, array_keys($last_read));

		if (sizeof($topic_ids))
		{
			$mark_time = array();

			// Get global announcement info
			if ($global_announce_list && sizeof($global_announce_list))
			{
				if (!isset($forum_mark_time[0]))
				{
					global $db;

					$sql = 'SELECT mark_time
						FROM ' . FORUMS_TRACK_TABLE . "
						WHERE user_id = {$mx_user->data['user_id']}
							AND forum_id = 0";
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if ($row)
					{
						$mark_time[0] = $row['mark_time'];
					}
				}
				else
				{
					if ($forum_mark_time[0] !== false)
					{
						$mark_time[0] = $forum_mark_time[0];
					}
				}
			}

			if (!empty($forum_mark_time[$forum_id]) && $forum_mark_time[$forum_id] !== false)
			{
				$mark_time[$forum_id] = $forum_mark_time[$forum_id];
			}

			$mx_user_lastmark = (isset($mark_time[$forum_id])) ? $mark_time[$forum_id] : $mx_user->data['user_lastmark'];

			foreach ($topic_ids as $topic_id)
			{
				if ($global_announce_list && isset($global_announce_list[$topic_id]))
				{
					$last_read[$topic_id] = (isset($mark_time[0])) ? $mark_time[0] : $mx_user_lastmark;
				}
				else
				{
					$last_read[$topic_id] = $mx_user_lastmark;
				}
			}
		}

		return $last_read;
	}

	/**
	* Get topic tracking info from db (for cookie based tracking only this function is used)
	*/
	public static function get_complete_topic_tracking($forum_id, $topic_ids, $global_announce_list = false)
	{
		global $board_config, $mx_user;

		$last_read = array();

		if (!is_array($topic_ids))
		{
			$topic_ids = array($topic_ids);
		}

		if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
		{
			global $db;

			$sql = 'SELECT topic_id, mark_time
				FROM ' . TOPICS_TRACK_TABLE . "
				WHERE user_id = {$mx_user->data['user_id']}
					AND " . $db->sql_in_set('topic_id', $topic_ids);
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$last_read[$row['topic_id']] = $row['mark_time'];
			}
			$db->sql_freeresult($result);

			$topic_ids = array_diff($topic_ids, array_keys($last_read));

			if (sizeof($topic_ids))
			{
				$sql = 'SELECT forum_id, mark_time
					FROM ' . FORUMS_TRACK_TABLE . "
					WHERE user_id = {$mx_user->data['user_id']}
						AND forum_id " .
						(($global_announce_list && sizeof($global_announce_list)) ? "IN (0, $forum_id)" : "= $forum_id");
				$result = $db->sql_query($sql);

				$mark_time = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$mark_time[$row['forum_id']] = $row['mark_time'];
				}
				$db->sql_freeresult($result);

				$mx_user_lastmark = (isset($mark_time[$forum_id])) ? $mark_time[$forum_id] : $mx_user->data['user_lastmark'];

				foreach ($topic_ids as $topic_id)
				{
					if ($global_announce_list && isset($global_announce_list[$topic_id]))
					{
						$last_read[$topic_id] = (isset($mark_time[0])) ? $mark_time[0] : $mx_user_lastmark;
					}
					else
					{
						$last_read[$topic_id] = $mx_user_lastmark;
					}
				}
			}
		}
		else if ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])
		{
			global $tracking_topics;

			if (!isset($tracking_topics) || !sizeof($tracking_topics))
			{
				$tracking_topics = (isset($_COOKIE[$board_config['cookie_name'] . '_track'])) ? ((STRIP) ? stripslashes($_COOKIE[$board_config['cookie_name'] . '_track']) : $_COOKIE[$board_config['cookie_name'] . '_track']) : '';
				$tracking_topics = ($tracking_topics) ? tracking_unserialize($tracking_topics) : array();
			}

			if (!$mx_user->data['is_registered'])
			{
				$mx_user_lastmark = (isset($tracking_topics['l'])) ? base_convert($tracking_topics['l'], 36, 10) + $board_config['board_startdate'] : 0;
			}
			else
			{
				$mx_user_lastmark = $mx_user->data['user_lastmark'];
			}

			foreach ($topic_ids as $topic_id)
			{
				$topic_id36 = base_convert($topic_id, 10, 36);

				if (isset($tracking_topics['t'][$topic_id36]))
				{
					$last_read[$topic_id] = base_convert($tracking_topics['t'][$topic_id36], 36, 10) + $board_config['board_startdate'];
				}
			}

			$topic_ids = array_diff($topic_ids, array_keys($last_read));

			if (sizeof($topic_ids))
			{
				$mark_time = array();
				if ($global_announce_list && sizeof($global_announce_list))
				{
					if (isset($tracking_topics['f'][0]))
					{
						$mark_time[0] = base_convert($tracking_topics['f'][0], 36, 10) + $board_config['board_startdate'];
					}
				}

				if (isset($tracking_topics['f'][$forum_id]))
				{
					$mark_time[$forum_id] = base_convert($tracking_topics['f'][$forum_id], 36, 10) + $board_config['board_startdate'];
				}

				$mx_user_lastmark = (isset($mark_time[$forum_id])) ? $mark_time[$forum_id] : $mx_user_lastmark;

				foreach ($topic_ids as $topic_id)
				{
					if ($global_announce_list && isset($global_announce_list[$topic_id]))
					{
						$last_read[$topic_id] = (isset($mark_time[0])) ? $mark_time[0] : $mx_user_lastmark;
					}
					else
					{
						$last_read[$topic_id] = $mx_user_lastmark;
					}
				}
			}
		}

		return $last_read;
	}

	/**
	* Check for read forums and update topic tracking info accordingly
	*
	* @param int $forum_id the forum id to check
	* @param int $forum_last_post_time the forums last post time
	* @param int $f_mark_time the forums last mark time if user is registered and load_db_lastread enabled
	* @param int $mark_time_forum false if the mark time needs to be obtained, else the last users forum mark time
	*
	* @return true if complete forum got marked read, else false.
	*/
	public static function update_forum_tracking_info($forum_id, $forum_last_post_time, $f_mark_time = false, $mark_time_forum = false)
	{
		global $db, $tracking_topics, $mx_user, $board_config;

		// Determine the users last forum mark time if not given.
		if ($mark_time_forum === false)
		{
			if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
			{
				$mark_time_forum = (!empty($f_mark_time)) ? $f_mark_time : $mx_user->data['user_lastmark'];
			}
			else if ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])
			{
				$tracking_topics = (isset($_COOKIE[$board_config['cookie_name'] . '_track'])) ? ((STRIP) ? stripslashes($_COOKIE[$board_config['cookie_name'] . '_track']) : $_COOKIE[$board_config['cookie_name'] . '_track']) : '';
				$tracking_topics = ($tracking_topics) ? tracking_unserialize($tracking_topics) : array();

				if (!$mx_user->data['is_registered'])
				{
					$mx_user->data['user_lastmark'] = (isset($tracking_topics['l'])) ? (int) (base_convert($tracking_topics['l'], 36, 10) + $board_config['board_startdate']) : 0;
				}

				$mark_time_forum = (isset($tracking_topics['f'][$forum_id])) ? (int) (base_convert($tracking_topics['f'][$forum_id], 36, 10) + $board_config['board_startdate']) : $mx_user->data['user_lastmark'];
			}
		}

		// Check the forum for any left unread topics.
		// If there are none, we mark the forum as read.
		if ($board_config['load_db_lastread'] && $mx_user->data['is_registered'])
		{
			if ($mark_time_forum >= $forum_last_post_time)
			{
				// We do not need to mark read, this happened before. Therefore setting this to true
				$row = true;
			}
			else
			{
				$sql = 'SELECT t.forum_id FROM ' . TOPICS_TABLE . ' t
					LEFT JOIN ' . TOPICS_TRACK_TABLE . ' tt ON (tt.topic_id = t.topic_id AND tt.user_id = ' . $mx_user->data['user_id'] . ')
					WHERE t.forum_id = ' . $forum_id . '
						AND t.topic_last_post_time > ' . $mark_time_forum . '
						AND t.topic_moved_id = 0
						AND (tt.topic_id IS NULL OR tt.mark_time < t.topic_last_post_time)
					GROUP BY t.forum_id';
				$result = $db->sql_query_limit($sql, 1);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
			}
		}
		else if ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])
		{
			// Get information from cookie
			$row = false;

			if (!isset($tracking_topics['tf'][$forum_id]))
			{
				// We do not need to mark read, this happened before. Therefore setting this to true
				$row = true;
			}
			else
			{
				$sql = 'SELECT topic_id
					FROM ' . TOPICS_TABLE . '
					WHERE forum_id = ' . $forum_id . '
						AND topic_last_post_time > ' . $mark_time_forum . '
						AND topic_moved_id = 0';
				$result = $db->sql_query($sql);

				$check_forum = $tracking_topics['tf'][$forum_id];
				$unread = false;

				while ($row = $db->sql_fetchrow($result))
				{
					if (!isset($check_forum[base_convert($row['topic_id'], 10, 36)]))
					{
						$unread = true;
						break;
					}
				}
				$db->sql_freeresult($result);

				$row = $unread;
			}
		}
		else
		{
			$row = true;
		}

		if (!$row)
		{
			markread('topics', $forum_id);
			return true;
		}

		return false;
	}

	/**
	* Transform an array into a serialized format
	*/
	public static function tracking_serialize($input)
	{
		$out = '';
		foreach ($input as $key => $value)
		{
			if (is_array($value))
			{
				$out .= $key . ':(' . tracking_serialize($value) . ');';
			}
			else
			{
				$out .= $key . ':' . $value . ';';
			}
		}
		return $out;
	}

	/**
	* Transform a serialized array into an actual array
	*/
	public static function tracking_unserialize($string, $max_depth = 3)
	{
		$n = strlen($string);
		if ($n > 10010)
		{
			die('Invalid data supplied');
		}
		$data = $stack = array();
		$key = '';
		$mode = 0;
		$level = &$data;
		for ($i = 0; $i < $n; ++$i)
		{
			switch ($mode)
			{
				case 0:
					switch ($string[$i])
					{
						case ':':
							$level[$key] = 0;
							$mode = 1;
						break;
						case ')':
							unset($level);
							$level = array_pop($stack);
							$mode = 3;
						break;
						default:
							$key .= $string[$i];
					}
				break;

				case 1:
					switch ($string[$i])
					{
						case '(':
							if (sizeof($stack) >= $max_depth)
							{
								die('Invalid data supplied');
							}
							$stack[] = &$level;
							$level[$key] = array();
							$level = &$level[$key];
							$key = '';
							$mode = 0;
						break;
						default:
							$level[$key] = $string[$i];
							$mode = 2;
						break;
					}
				break;

				case 2:
					switch ($string[$i])
					{
						case ')':
							unset($level);
							$level = array_pop($stack);
							$mode = 3;
						break;
						case ';':
							$key = '';
							$mode = 0;
						break;
						default:
							$level[$key] .= $string[$i];
						break;
					}
				break;

				case 3:
					switch ($string[$i])
					{
						case ')':
							unset($level);
							$level = array_pop($stack);
						break;
						case ';':
							$key = '';
							$mode = 0;
						break;
						default:
							die('Invalid data supplied');
						break;
					}
				break;
			}
		}

		if (sizeof($stack) != 0 || ($mode != 0 && $mode != 3))
		{
			die('Invalid data supplied');
		}

		return $level;
	}

	// Pagination functions

	/**
	* Pagination routine, generates page number sequence
	* tpl_prefix is for using different pagination blocks at one page
	*/
	public static function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = false, $tpl_prefix = '')
	{
		global $template, $mx_user;

		// Make sure $per_page is a valid value
		$per_page = ($per_page <= 0) ? 1 : $per_page;

		$seperator = '<span class="page-sep">' . $mx_user->lang['COMMA_SEPARATOR'] . '</span>';
		$total_pages = ceil($num_items / $per_page);

		if ($total_pages == 1 || !$num_items)
		{
			return false;
		}

		$on_page = floor($start_item / $per_page) + 1;
		$url_delim = (strpos($base_url, '?') === false) ? '?' : '&amp;';

		$page_string = ($on_page == 1) ? '<strong>1</strong>' : '<a href="' . $base_url . '">1</a>';

		if ($total_pages > 5)
		{
			$start_cnt = min(max(1, $on_page - 4), $total_pages - 5);
			$end_cnt = max(min($total_pages, $on_page + 4), 6);

			$page_string .= ($start_cnt > 1) ? ' ... ' : $seperator;

			for ($i = $start_cnt + 1; $i < $end_cnt; $i++)
			{
				$page_string .= ($i == $on_page) ? '<strong>' . $i . '</strong>' : '<a href="' . $base_url . "{$url_delim}start=" . (($i - 1) * $per_page) . '">' . $i . '</a>';
				if ($i < $end_cnt - 1)
				{
					$page_string .= $seperator;
				}
			}

			$page_string .= ($end_cnt < $total_pages) ? ' ... ' : $seperator;
		}
		else
		{
			$page_string .= $seperator;

			for ($i = 2; $i < $total_pages; $i++)
			{
				$page_string .= ($i == $on_page) ? '<strong>' . $i . '</strong>' : '<a href="' . $base_url . "{$url_delim}start=" . (($i - 1) * $per_page) . '">' . $i . '</a>';
				if ($i < $total_pages)
				{
					$page_string .= $seperator;
				}
			}
		}

		$page_string .= ($on_page == $total_pages) ? '<strong>' . $total_pages . '</strong>' : '<a href="' . $base_url . "{$url_delim}start=" . (($total_pages - 1) * $per_page) . '">' . $total_pages . '</a>';

		if ($add_prevnext_text)
		{
			if ($on_page != 1)
			{
				$page_string = '<a href="' . $base_url . "{$url_delim}start=" . (($on_page - 2) * $per_page) . '">' . $mx_user->lang['PREVIOUS'] . '</a>&nbsp;&nbsp;' . $page_string;
			}

			if ($on_page != $total_pages)
			{
				$page_string .= '&nbsp;&nbsp;<a href="' . $base_url . "{$url_delim}start=" . ($on_page * $per_page) . '">' . $mx_user->lang['NEXT'] . '</a>';
			}
		}

		$template->assign_vars(array(
			$tpl_prefix . 'BASE_URL'	=> $base_url,
			'A_' . $tpl_prefix . 'BASE_URL'	=> addslashes($base_url),
			$tpl_prefix . 'PER_PAGE'	=> $per_page,

			$tpl_prefix . 'PREVIOUS_PAGE'	=> ($on_page == 1) ? '' : $base_url . "{$url_delim}start=" . (($on_page - 2) * $per_page),
			$tpl_prefix . 'NEXT_PAGE'		=> ($on_page == $total_pages) ? '' : $base_url . "{$url_delim}start=" . ($on_page * $per_page),
			$tpl_prefix . 'TOTAL_PAGES'		=> $total_pages)
		);

		return $page_string;
	}

	/**
	* Return current page (pagination)
	*/
	public static function on_page($num_items, $per_page, $start)
	{
		global $template, $mx_user;

		// Make sure $per_page is a valid value
		$per_page = ($per_page <= 0) ? 1 : $per_page;

		$on_page = floor($start / $per_page) + 1;

		$template->assign_vars(array(
			'ON_PAGE'		=> $on_page)
		);

		return sprintf($mx_user->lang['PAGE_OF'], $on_page, max(ceil($num_items / $per_page), 1));
	}

	// Server functions (building urls, redirecting...)

	/**
	* Append session id to url
	*
	* @param string $url The url the session id needs to be appended to (can have params)
	* @param mixed $params String or array of additional url parameters
	* @param bool $is_amp Is url using &amp; (true) or & (false)
	* @param string $session_id Possibility to use a custom session id instead of the global one
	*
	* Examples:
	* <code>
	* append_sid("{$phpbb_root_path}viewtopic.$phpEx?t=1&amp;f=2");
	* append_sid("{$phpbb_root_path}viewtopic.$phpEx", 't=1&amp;f=2');
	* append_sid("{$phpbb_root_path}viewtopic.$phpEx", 't=1&f=2', false);
	* append_sid("{$phpbb_root_path}viewtopic.$phpEx", array('t' => 1, 'f' => 2));
	* </code>
	*/
	public static function append_sid($url, $params = false, $is_amp = true, $session_id = false)
	{
		global $_SID, $_EXTRA_URL;

		// Assign sid if session id is not specified
		if ($session_id === false)
		{
			$session_id = $_SID;
		}

		$amp_delim = ($is_amp) ? '&amp;' : '&';
		$url_delim = (strpos($url, '?') === false) ? '?' : $amp_delim;

		// Appending custom url parameter?
		$append_url = (!empty($_EXTRA_URL)) ? implode($amp_delim, $_EXTRA_URL) : '';

		$anchor = '';
		if (strpos($url, '#') !== false)
		{
			list($url, $anchor) = explode('#', $url, 2);
			$anchor = '#' . $anchor;
		}
		else if (!is_array($params) && strpos($params, '#') !== false)
		{
			list($params, $anchor) = explode('#', $params, 2);
			$anchor = '#' . $anchor;
		}

		// Use the short variant if possible ;)
		if ($params === false)
		{
			// Append session id
			if (!$session_id)
			{
				return $url . (($append_url) ? $url_delim . $append_url : '') . $anchor;
			}
			else
			{
				return $url . (($append_url) ? $url_delim . $append_url . $amp_delim : $url_delim) . 'sid=' . $session_id . $anchor;
			}
		}

		// Build string if parameters are specified as array
		if (is_array($params))
		{
			$output = array();

			foreach ($params as $key => $item)
			{
				if ($item === NULL)
				{
					continue;
				}

				if ($key == '#')
				{
					$anchor = '#' . $item;
					continue;
				}

				$output[] = $key . '=' . $item;
			}

			$params = implode($amp_delim, $output);
		}

		// Append session id and parameters (even if they are empty)
		// If parameters are empty, the developer can still append his/her parameters without caring about the delimiter
		return $url . (($append_url) ? $url_delim . $append_url . $amp_delim : $url_delim) . $params . ((!$session_id) ? '' : $amp_delim . 'sid=' . $session_id) . $anchor;
	}

	/**
	* Generate board url (example: http://www.foo.bar/phpBB)
	* @param bool $without_script_path if set to true the script path gets not appended (example: http://www.foo.bar)
	*/
	public static function generate_board_url($without_script_path = false)
	{
		global $board_config, $mx_user;

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
			$url .= ':' . $server_port;
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

	/**
	* Redirects the user to another page then exits the script nicely
	*/
	public static function redirect($url, $return = false)
	{
		global $db, $mx_cache, $board_config, $mx_user, $phpbb_root_path;
		global $mx_root_path;

		if (empty($mx_user->lang))
		{
			$mx_user->add_lang('common');
		}

		if (!$return)
		{
			garbage_collection();
		}

		// Make sure no &amp;'s are in, this will break the redirect
		$url = str_replace('&amp;', '&', $url);

		// Determine which type of redirect we need to handle...
		$url_parts = parse_url($url);

		if ($url_parts === false)
		{
			// Malformed url, redirect to current page...
			$url = self::generate_board_url() . '/' . $mx_user->page['page'];
		}
		else if (!empty($url_parts['scheme']) && !empty($url_parts['host']))
		{
			// Full URL
		}
		else if ($url[0] == '/')
		{
			// Absolute uri, prepend direct url...
			$url = self::generate_board_url(true) . $url;
		}
		else
		{
			// Relative uri
			$pathinfo = pathinfo($url);

			// Is the uri pointing to the current directory?
			if ($pathinfo['dirname'] == '.')
			{
				$url = str_replace('./', '', $url);

				// Strip / from the beginning
				if ($url && substr($url, 0, 1) == '/')
				{
					$url = substr($url, 1);
				}

				if ($mx_user->page['page_dir'])
				{
					$url = self::generate_board_url() . '/' . $mx_user->page['page_dir'] . '/' . $url;
				}
				else
				{
					$url = self::generate_board_url() . '/' . $url;
				}
			}
			else
			{
				// Used ./ before, but $phpbb_root_path is working better with urls within another root path
				$root_dirs = explode('/', str_replace('\\', '/', phpBB2::phpbb_realpath($phpbb_root_path)));
				$page_dirs = explode('/', str_replace('\\', '/', phpBB2::phpbb_realpath($pathinfo['dirname'])));
				$intersection = array_intersect_assoc($root_dirs, $page_dirs);

				$root_dirs = array_diff_assoc($root_dirs, $intersection);
				$page_dirs = array_diff_assoc($page_dirs, $intersection);

				$dir = str_repeat('../', sizeof($root_dirs)) . implode('/', $page_dirs);

				// Strip / from the end
				if ($dir && substr($dir, -1, 1) == '/')
				{
					$dir = substr($dir, 0, -1);
				}

				// Strip / from the beginning
				if ($dir && substr($dir, 0, 1) == '/')
				{
					$dir = substr($dir, 1);
				}

				$url = str_replace($pathinfo['dirname'] . '/', '', $url);

				// Strip / from the beginning
				if (substr($url, 0, 1) == '/')
				{
					$url = substr($url, 1);
				}

				$url = $dir . '/' . $url;
				$url = self::generate_board_url() . '/' . $url;
			}
		}

		// Make sure no linebreaks are there... to prevent http response splitting for PHP < 4.4.2
		if (strpos(urldecode($url), "\n") !== false || strpos(urldecode($url), "\r") !== false || strpos($url, ';') !== false)
		{
			trigger_error('Tried to redirect to potentially insecure url.', E_USER_ERROR);
		}

		if ($return)
		{
			return $url;
		}

		// Redirect via an HTML form for PITA webservers
		if (@preg_match('#Microsoft|WebSTAR|Xitami#', getenv('SERVER_SOFTWARE')))
		{
			header('Refresh: 0; URL=' . $url);

			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
			echo '<html xmlns="http://www.w3.org/1999/xhtml" dir="' . $mx_user->lang['DIRECTION'] . '" lang="' . $mx_user->lang['USER_LANG'] . '" xml:lang="' . $mx_user->lang['USER_LANG'] . '">';
			echo '<head>';
			echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
			echo '<meta http-equiv="refresh" content="0; url=' . str_replace('&', '&amp;', $url) . '" />';
			echo '<title>' . $mx_user->lang['REDIRECT'] . '</title>';
			echo '</head>';
			echo '<body>';
			echo '<div style="text-align: center;">' . sprintf($mx_user->lang['URL_REDIRECT'], '<a href="' . str_replace('&', '&amp;', $url) . '">', '</a>') . '</div>';
			echo '</body>';
			echo '</html>';

			exit;
		}

		// Behave as per HTTP/1.1 spec for others
		header('Location: ' . $url);
		exit;
	}

	/**
	* Re-Apply session id after page reloads
	*/
	public static function reapply_sid($url)
	{
		global $phpEx, $phpbb_root_path;

		if ($url === "index.$phpEx")
		{
			return mx3_append_sid("index.$phpEx");
		}
		else if ($url === "{$phpbb_root_path}index.$phpEx")
		{
			return mx3_append_sid("{$phpbb_root_path}index.$phpEx");
		}

		// Remove previously added sid
		if (strpos($url, '?sid=') !== false)
		{
			$url = preg_replace('/(\?)sid=[a-z0-9]+(&amp;|&)?/', '\1', $url);
		}
		else if (strpos($url, '&sid=') !== false)
		{
			$url = preg_replace('/&sid=[a-z0-9]+(&)?/', '\1', $url);
		}
		else if (strpos($url, '&amp;sid=') !== false)
		{
			$url = preg_replace('/&amp;sid=[a-z0-9]+(&amp;)?/', '\1', $url);
		}

		return mx_mx3_append_sid($url);
	}

	/**
	* Returns url from the session/current page with an re-appended SID with optionally stripping vars from the url
	*/
	public static function build_url($strip_vars = false)
	{
		global $mx_user, $phpbb_root_path;

		// Append SID
		$redirect = (($mx_user->page['page_dir']) ? $mx_user->page['page_dir'] . '/' : '') . $mx_user->page['page_name'] . (($mx_user->page['query_string']) ? "?{$mx_user->page['query_string']}" : '');
		$redirect = mx3_append_sid($redirect, false, false);

		// Add delimiter if not there...
		if (strpos($redirect, '?') === false)
		{
			$redirect .= '?';
		}

		// Strip vars...
		if ($strip_vars !== false && strpos($redirect, '?') !== false)
		{
			if (!is_array($strip_vars))
			{
				$strip_vars = array($strip_vars);
			}

			$query = $_query = array();

			$args = substr($redirect, strpos($redirect, '?') + 1);
			$args = ($args) ? explode('&', $args) : array();
			$redirect = substr($redirect, 0, strpos($redirect, '?'));

			foreach ($args as $argument)
			{
				$arguments = explode('=', $argument);
				$key = $arguments[0];
				unset($arguments[0]);

				$query[$key] = implode('=', $arguments);
			}

			// Strip the vars off
			foreach ($strip_vars as $strip)
			{
				if (isset($query[$strip]))
				{
					unset($query[$strip]);
				}
			}

			// Glue the remaining parts together... already urlencoded
			foreach ($query as $key => $value)
			{
				$_query[] = $key . '=' . $value;
			}
			$query = implode('&', $_query);

			$redirect .= ($query) ? '?' . $query : '';
		}

		return $phpbb_root_path . str_replace('&', '&amp;', $redirect);
	}

	/**
	* Meta refresh assignment
	*/
	public static function meta_refresh($time, $url)
	{
		global $template;

		$url = self::redirect($url, true);

		// For XHTML compatibility we change back & to &amp;
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="' . $time . ';url=' . str_replace('&', '&amp;', $url) . '" />')
		);
	}
			
	/**
	* Add a secret hash   for use in links/GET requests
	* @param string  $link_name The name of the link; has to match the name used in check_link_hash, otherwise no restrictions apply
	* @return string the hash

	*/
	public static function generate_link_hash($link_name)
	{
		global $mx_user;

		if (!isset($mx_user->data["hash_$link_name"]))
		{
			$mx_user->data["hash_$link_name"] = substr(sha1($mx_user->data['user_form_salt'] . $link_name), 0, 8);
		}

		return $mx_user->data["hash_$link_name"];
	}


	/**
	* checks a link hash - for GET requests
	* @param string $token the submitted token
	* @param string $link_name The name of the link
	* @return boolean true if all is fine
	*/
	public static function check_link_hash($token, $link_name)
	{
		return $token === generate_link_hash($link_name);
	}

	/**
	* Add a secret token to the form (requires the S_FORM_TOKEN template variable)
	* @param string  $form_name The name of the form; has to match the name used in check_form_key, otherwise no restrictions apply
	*/
	public static function add_form_key($form_name)
	{
		global $board_config, $template, $mx_user;

		$now = time();
		$token_sid = ($mx_user->data['user_id'] == ANONYMOUS && !empty($board_config['form_token_sid_guests'])) ? $mx_user->session_id : '';
		$token = sha1($now . $mx_user->data['user_form_salt'] . $form_name . $token_sid);

		$s_fields = build_hidden_fields(array(
			'creation_time' => $now,
			'form_token'	=> $token,
		));

		$template->assign_vars(array(
			'S_FORM_TOKEN'	=> $s_fields,
		));
	}

	/**
	* Check the form key. Required for all altering actions not secured by confirm_box
	* @param string  $form_name The name of the form; has to match the name used in add_form_key, otherwise no restrictions apply
	* @param int $timespan The maximum acceptable age for a submitted form in seconds. Defaults to the config setting.
	* @param string $return_page The address for the return link
	* @param bool $trigger If true, the function will triger an error when encountering an invalid form
	*/
	public static function check_form_key($form_name, $timespan = false, $return_page = '', $trigger = false, $minimum_time = false)
	{
		global $board_config, $mx_user, $_POST;

		if ($timespan === false)
		{
			// we enforce a minimum value of half a minute here.
			$timespan = ($board_config['form_token_lifetime'] == -1) ? -1 : max(30, $board_config['form_token_lifetime']);
		}

		if (isset($_POST['creation_time']) && isset($_POST['form_token']))
		{
			$creation_time	= abs(request_var('creation_time', 0));
			$token = request_var('form_token', '');

			$diff = time() - $creation_time;

			// If creation_time and the time() now is zero we can assume it was not a human doing this (the check for if ($diff)...
			if ($diff && ($diff <= $timespan || $timespan === -1))
			{
				$token_sid = ($mx_user->data['user_id'] == ANONYMOUS && !empty($board_config['form_token_sid_guests'])) ? $mx_user->session_id : '';
				$key = sha1($creation_time . $mx_user->data['user_form_salt'] . $form_name . $token_sid);

				if ($key === $token)
				{
					return true;
				}
			}
		}

		if ($trigger)
		{
			trigger_error($mx_user->lang['FORM_INVALID'] . $return_page);
		}

		return false;
	}

	// Message/Login boxes

	/**
	* Build Confirm box
	* @param boolean $check True for checking if confirmed (without any additional parameters) and false for displaying the confirm box
	* @param string $title Title/Message used for confirm box.
	*		message text is _CONFIRM appended to title.
	*		If title can not be found in user->lang a default one is displayed
	*		If title_CONFIRM can not be found in user->lang the text given is used.
	* @param string $hidden Hidden variables
	* @param string $html_body Template used for confirm box
	* @param string $u_action Custom form action
	function confirm_box($check, $title = '', $hidden = '', $html_body = 'confirm_body.html', $u_action = '')
	{
		global $mx_user, $template, $db;
		global $phpEx, $phpbb_root_path;

		if (isset($_POST['cancel']))
		{
			return false;
		}

		$confirm = false;
		if (isset($_POST['confirm']))
		{
			// language frontier
			if ($_POST['confirm'] == $mx_user->lang['YES'])
			{
				$confirm = true;
			}
		}

		if ($check && $confirm)
		{
			$mx_user_id = self::request_var('user_id', 0);
			$session_id = self::request_var('sess', '');
			$confirm_key = self::request_var('confirm_key', '');

			if ($mx_user_id != $mx_user->data['user_id'] || $session_id != $mx_user->session_id || !$confirm_key || !$mx_user->data['user_last_confirm_key'] || $confirm_key != $mx_user->data['user_last_confirm_key'])
			{
				return false;
			}

			// Reset user_last_confirm_key
			$sql = 'UPDATE ' . USERS_TABLE . " SET user_last_confirm_key = ''
				WHERE user_id = " . $mx_user->data['user_id'];
			$db->sql_query($sql);

			return true;
		}
		else if ($check)
		{
			return false;
		}

		$s_hidden_fields = build_hidden_fields(array(
			'user_id'	=> $mx_user->data['user_id'],
			'sess'		=> $mx_user->session_id,
			'sid'		=> $mx_user->session_id)
		);

		// generate activation key
		$confirm_key = self::gen_rand_string(10);

		if (defined('IN_ADMIN') && isset($mx_user->data['session_admin']) && $mx_user->data['session_admin'])
		{
			adm_page_header((!isset($mx_user->lang[$title])) ? $mx_user->lang['CONFIRM'] : $mx_user->lang[$title]);
		}
		else
		{
			//page_header((!isset($mx_user->lang[$title])) ? $mx_user->lang['CONFIRM'] : $mx_user->lang[$title]);
		}

		$template->set_filenames(array(
			'body' => $html_body)
		);

		// If activation key already exist, we better do not re-use the key (something very strange is going on...)
		if (self::request_var('confirm_key', ''))
		{
			// This should not occur, therefore we cancel the operation to safe the user
			return false;
		}

		// re-add sid / transform & to &amp; for user->page (user->page is always using &)
		$use_page = ($u_action) ? $phpbb_root_path . $u_action : $phpbb_root_path . str_replace('&', '&amp;', $mx_user->page['page']);
		$u_action = self::reapply_sid($use_page);
		$u_action .= ((strpos($u_action, '?') === false) ? '?' : '&amp;') . 'confirm_key=' . $confirm_key;

		$template->assign_vars(array(
			'MESSAGE_TITLE'		=> (!isset($mx_user->lang[$title])) ? $mx_user->lang['CONFIRM'] : $mx_user->lang[$title],
			'MESSAGE_TEXT'		=> (!isset($mx_user->lang[$title . '_CONFIRM'])) ? $title : $mx_user->lang[$title . '_CONFIRM'],

			'YES_VALUE'			=> $mx_user->lang['YES'],
			'S_CONFIRM_ACTION'	=> $u_action,
			'S_HIDDEN_FIELDS'	=> $hidden . $s_hidden_fields)
		);

		$sql = 'UPDATE ' . USERS_TABLE . " SET user_last_confirm_key = '" . $db->sql_escape($confirm_key) . "'
			WHERE user_id = " . $mx_user->data['user_id'];
		$db->sql_query($sql);

		if (defined('IN_ADMIN') && isset($mx_user->data['session_admin']) && $mx_user->data['session_admin'])
		{
			adm_page_footer();
		}
		else
		{
			//page_footer();
		}
	}
	*/

	/**
	* Generate login box or verify password
	function login_box($redirect = '', $l_explain = '', $l_success = '', $admin = false, $s_display = true)
	{
		global $db, $mx_user, $template, $phpbb_auth, $phpEx, $phpbb_root_path, $board_config;

		$err = '';

		// Make sure user->setup() has been called
		if (empty($mx_user->lang))
		{
			$mx_user->setup();
		}

		// Print out error if user tries to authenticate as an administrator without having the privileges...
		if ($admin && !$phpbb_auth->acl_get('a_'))
		{
			// Not authd
			// anonymous/inactive users are never able to go to the ACP even if they have the relevant permissions
			if ($mx_user->data['is_registered'])
			{
				add_log('admin', 'LOG_ADMIN_AUTH_FAIL');
			}
			trigger_error('NO_AUTH_ADMIN');
		}

		if (isset($_POST['login']))
		{
			$mx_username	= self::request_var('username', '', true);
			$password	= self::request_var('password', '', true);
			$autologin	= (!empty($_POST['autologin'])) ? true : false;
			$viewonline = (!empty($_POST['viewonline'])) ? 0 : 1;
			$admin 		= ($admin) ? 1 : 0;
			$viewonline = ($admin) ? $mx_user->data['session_viewonline'] : $viewonline;

			// Check if the supplied username is equal to the one stored within the database if re-authenticating
			if ($admin && utf8_clean_string($mx_username) != utf8_clean_string($mx_user->data['username']))
			{
				// We log the attempt to use a different username...
				add_log('admin', 'LOG_ADMIN_AUTH_FAIL');
				trigger_error('NO_AUTH_ADMIN_USER_DIFFER');
			}

			// do not allow empty password
			if (!$password)
			{
				trigger_error('NO_PASSWORD_SUPPLIED');
			}

			// If authentication is successful we redirect user to previous page
			$result = $phpbb_auth->login($mx_username, $password, $autologin, $viewonline, $admin);

			// If admin authentication and login, we will log if it was a success or not...
			// We also break the operation on the first non-success login - it could be argued that the user already knows
			if ($admin)
			{
				if ($result['status'] == LOGIN_SUCCESS)
				{
					add_log('admin', 'LOG_ADMIN_AUTH_SUCCESS');
				}
				else
				{
					// Only log the failed attempt if a real user tried to.
					// anonymous/inactive users are never able to go to the ACP even if they have the relevant permissions
					if ($mx_user->data['is_registered'])
					{
						add_log('admin', 'LOG_ADMIN_AUTH_FAIL');
					}
				}
			}

			// The result parameter is always an array, holding the relevant information...
			if ($result['status'] == LOGIN_SUCCESS)
			{
				$redirect = self::request_var('redirect', "{$phpbb_root_path}index.$phpEx");
				$message = ($l_success) ? $l_success : $mx_user->lang['LOGIN_REDIRECT'];
				$l_redirect = ($admin) ? $mx_user->lang['PROCEED_TO_ACP'] : (($redirect === "{$phpbb_root_path}index.$phpEx" || $redirect === "index.$phpEx") ? $mx_user->lang['RETURN_INDEX'] : $mx_user->lang['RETURN_PAGE']);

				// append/replace SID (may change during the session for AOL users)
				$redirect = reapply_sid($redirect);

				// Special case... the user is effectively banned, but we allow founders to login
				if (defined('IN_CHECK_BAN') && $result['user_row']['user_type'] != USER_FOUNDER)
				{
					return;
				}

				meta_refresh(3, $redirect);
				trigger_error($message . '<br /><br />' . sprintf($l_redirect, '<a href="' . $redirect . '">', '</a>'));
			}

			// Something failed, determine what...
			if ($result['status'] == LOGIN_BREAK)
			{
				trigger_error($result['error_msg'], E_USER_ERROR);
			}

			// Special cases... determine
			switch ($result['status'])
			{
				case LOGIN_ERROR_ATTEMPTS:

					// Show confirm image
					$sql = 'DELETE FROM ' . CONFIRM_TABLE . "
						WHERE session_id = '" . $db->sql_escape($mx_user->session_id) . "'
							AND confirm_type = " . CONFIRM_LOGIN;
					$db->sql_query($sql);

					// Generate code
					$code = gen_rand_string(mt_rand(5, 8));
					$confirm_id = md5(unique_id($mx_user->ip));
					$seed = hexdec(substr(unique_id(), 4, 10));

					// compute $seed % 0x7fffffff
					$seed -= 0x7fffffff * floor($seed / 0x7fffffff);

					$sql = 'INSERT INTO ' . CONFIRM_TABLE . ' ' . $db->sql_build_array('INSERT', array(
						'confirm_id'	=> (string) $confirm_id,
						'session_id'	=> (string) $mx_user->session_id,
						'confirm_type'	=> (int) CONFIRM_LOGIN,
						'code'			=> (string) $code,
						'seed'			=> (int) $seed)
					);
					$db->sql_query($sql);

					$template->assign_vars(array(
						'S_CONFIRM_CODE'			=> true,
						'CONFIRM_ID'				=> $confirm_id,
						'CONFIRM_IMAGE'				=> '<img src="' . mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=confirm&amp;id=' . $confirm_id . '&amp;type=' . CONFIRM_LOGIN) . '" alt="" title="" />',
						'L_LOGIN_CONFIRM_EXPLAIN'	=> sprintf($mx_user->lang['LOGIN_CONFIRM_EXPLAIN'], '<a href="mailto:' . htmlspecialchars($board_config['board_contact']) . '">', '</a>'),
					));

					$err = $mx_user->lang[$result['error_msg']];

				break;

				case LOGIN_ERROR_PASSWORD_CONVERT:
					$err = sprintf(
						$mx_user->lang[$result['error_msg']],
						($board_config['email_enable']) ? '<a href="' . mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=sendpassword') . '">' : '',
						($board_config['email_enable']) ? '</a>' : '',
						($board_config['board_contact']) ? '<a href="mailto:' . htmlspecialchars($board_config['board_contact']) . '">' : '',
						($board_config['board_contact']) ? '</a>' : ''
					);
				break;

				// Username, password, etc...
				default:
					$err = $mx_user->lang[$result['error_msg']];

					// Assign admin contact to some error messages
					if ($result['error_msg'] == 'LOGIN_ERROR_USERNAME' || $result['error_msg'] == 'LOGIN_ERROR_PASSWORD')
					{
						$err = (!$board_config['board_contact']) ? sprintf($mx_user->lang[$result['error_msg']], '', '') : sprintf($mx_user->lang[$result['error_msg']], '<a href="mailto:' . htmlspecialchars($board_config['board_contact']) . '">', '</a>');
					}

				break;
			}
		}

		if (!$redirect)
		{
			// We just use what the session code determined...
			// If we are not within the admin directory we use the page dir...
			$redirect = '';

			if (!$admin)
			{
				$redirect .= ($mx_user->page['page_dir']) ? $mx_user->page['page_dir'] . '/' : '';
			}

			$redirect .= $mx_user->page['page_name'] . (($mx_user->page['query_string']) ? '?' . htmlspecialchars($mx_user->page['query_string']) : '');
		}

		$s_hidden_fields = build_hidden_fields(array('redirect' => $redirect, 'sid' => $mx_user->session_id));

		$template->assign_vars(array(
			'LOGIN_ERROR'		=> $err,
			'LOGIN_EXPLAIN'		=> $l_explain,

			'U_SEND_PASSWORD' 		=> ($board_config['email_enable']) ? mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=sendpassword') : '',
			'U_RESEND_ACTIVATION'	=> ($board_config['require_activation'] != USER_ACTIVATION_NONE && $board_config['email_enable']) ? mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=resend_act') : '',
			'U_TERMS_USE'			=> mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=terms'),
			'U_PRIVACY'				=> mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=privacy'),

			'S_DISPLAY_FULL_LOGIN'	=> ($s_display) ? true : false,
			'S_LOGIN_ACTION'		=> (!$admin) ? mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=login') : mx3_append_sid("index.$phpEx", false, true, $mx_user->session_id), // Needs to stay index.$phpEx because we are within the admin directory
			'S_HIDDEN_FIELDS' 		=> $s_hidden_fields,

			'S_ADMIN_AUTH'			=> $admin,
			'USERNAME'				=> ($admin) ? $mx_user->data['username'] : '')
		);

		page_header($mx_user->lang['LOGIN']);

		$template->set_filenames(array(
			'body' => 'login_body.html')
		);
		make_jumpbox(mx3_append_sid("{$phpbb_root_path}viewforum.$phpEx"));

		page_footer();
	}
	*/

	/**
	* Generate forum login box
	function login_forum_box($forum_data)
	{
		global $db, $board_config, $mx_user, $template, $phpEx;

		$password = self::request_var('password', '', true);

		$sql = 'SELECT forum_id
			FROM ' . FORUMS_ACCESS_TABLE . '
			WHERE forum_id = ' . $forum_data['forum_id'] . '
				AND user_id = ' . $mx_user->data['user_id'] . "
				AND session_id = '" . $db->sql_escape($mx_user->session_id) . "'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ($row)
		{
			return true;
		}

		if ($password)
		{
			// Remove expired authorised sessions
			$sql = 'SELECT session_id
				FROM ' . SESSIONS_TABLE;
			$result = $db->sql_query($sql);

			if ($row = $db->sql_fetchrow($result))
			{
				$sql_in = array();
				do
				{
					$sql_in[] = (string) $row['session_id'];
				}
				while ($row = $db->sql_fetchrow($result));

				// Remove expired sessions
				$sql = 'DELETE FROM ' . FORUMS_ACCESS_TABLE . '
					WHERE ' . $db->sql_in_set('session_id', $sql_in, true);
				$db->sql_query($sql);
			}
			$db->sql_freeresult($result);

			if ($password == $forum_data['forum_password'])
			{
				$sql_ary = array(
					'forum_id'		=> (int) $forum_data['forum_id'],
					'user_id'		=> (int) $mx_user->data['user_id'],
					'session_id'	=> (string) $mx_user->session_id,
				);

				$db->sql_query('INSERT INTO ' . FORUMS_ACCESS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary));

				return true;
			}

			$template->assign_var('LOGIN_ERROR', $mx_user->lang['WRONG_PASSWORD']);
		}

		page_header($mx_user->lang['LOGIN']);

		$template->assign_vars(array(
			'S_HIDDEN_FIELDS'		=> build_hidden_fields(array('f' => $forum_data['forum_id'])))
		);

		$template->set_filenames(array(
			'body' => 'login_forum.html')
		);

		page_footer();
	}
	*/

	// Content related functions

	/**
	* Bump Topic Check - used by posting and viewtopic
	*/
	public static function bump_topic_allowed($forum_id, $topic_bumped, $last_post_time, $topic_poster, $last_topic_poster)
	{
		global $board_config, $phpbb_auth, $mx_user;

		// Check permission and make sure the last post was not already bumped
		if (!$phpbb_auth->acl_get('f_bump', $forum_id) || $topic_bumped)
		{
			return false;
		}

		// Check bump time range, is the user really allowed to bump the topic at this time?
		$bump_time = ($board_config['bump_type'] == 'm') ? $board_config['bump_interval'] * 60 : (($board_config['bump_type'] == 'h') ? $board_config['bump_interval'] * 3600 : $board_config['bump_interval'] * 86400);

		// Check bump time
		if ($last_post_time + $bump_time > time())
		{
			return false;
		}

		// Check bumper, only topic poster and last poster are allowed to bump
		if ($topic_poster != $mx_user->data['user_id'] && $last_topic_poster != $mx_user->data['user_id'])
		{
			return false;
		}

		// A bump time of 0 will completely disable the bump feature... not intended but might be useful.
		return $bump_time;
	}

	/**
	* Generates a text with approx. the specified length which contains the specified words and their context
	*
	* @param	string	$text	The full text from which context shall be extracted
	* @param	string	$words	An array of words which should be contained in the result, has to be a valid part of a PCRE pattern (escape with preg_quote!)
	* @param	int		$length	The desired length of the resulting text, however the result might be shorter or longer than this value
	*
	* @return	string			Context of the specified words separated by "..."
	*/
	public static function get_context($text, $words, $length = 400)
	{
		// first replace all whitespaces with single spaces
		$text = preg_replace('/ +/', ' ', strtr($text, "\t\n\r\x0C ", '     '), $text);

		$word_indizes = array();
		if (sizeof($words))
		{
			$match = '';
			// find the starting indizes of all words
			foreach ($words as $word)
			{
				if ($word)
				{
					if (preg_match('#(?:[^\w]|^)(' . $word . ')(?:[^\w]|$)#i', $text, $match))
					{
						$pos = utf8_strpos($text, $match[1]);
						if ($pos !== false)
						{
							$word_indizes[] = $pos;
						}
					}
				}
			}
			unset($match);

			if (sizeof($word_indizes))
			{
				$word_indizes = array_unique($word_indizes);
				sort($word_indizes);

				$wordnum = sizeof($word_indizes);
				// number of characters on the right and left side of each word
				$sequence_length = (int) ($length / (2 * $wordnum)) - 2;
				$final_text = '';
				$word = $j = 0;
				$final_text_index = -1;

				// cycle through every character in the original text
				for ($i = $word_indizes[$word], $n = utf8_strlen($text); $i < $n; $i++)
				{
					// if the current position is the start of one of the words then append $sequence_length characters to the final text
					if (isset($word_indizes[$word]) && ($i == $word_indizes[$word]))
					{
						if ($final_text_index < $i - $sequence_length - 1)
						{
							$final_text .= '... ' . preg_replace('#^([^ ]*)#', '', utf8_substr($text, $i - $sequence_length, $sequence_length));
						}
						else
						{
							// if the final text is already nearer to the current word than $sequence_length we only append the text
							// from its current index on and distribute the unused length to all other sequenes
							$sequence_length += (int) (($final_text_index - $i + $sequence_length + 1) / (2 * $wordnum));
							$final_text .= utf8_substr($text, $final_text_index + 1, $i - $final_text_index - 1);
						}
						$final_text_index = $i - 1;

						// add the following characters to the final text (see below)
						$word++;
						$j = 1;
					}

					if ($j > 0)
					{
						// add the character to the final text and increment the sequence counter
						$final_text .= utf8_substr($text, $i, 1);
						$final_text_index++;
						$j++;

						// if this is a whitespace then check whether we are done with this sequence
						if (utf8_substr($text, $i, 1) == ' ')
						{
							// only check whether we have to exit the context generation completely if we haven't already reached the end anyway
							if ($i + 4 < $n)
							{
								if (($j > $sequence_length && $word >= $wordnum) || utf8_strlen($final_text) > $length)
								{
									$final_text .= ' ...';
									break;
								}
							}
							else
							{
								// make sure the text really reaches the end
								$j -= 4;
							}

							// stop context generation and wait for the next word
							if ($j > $sequence_length)
							{
								$j = 0;
							}
						}
					}
				}
				return $final_text;
			}
		}

		if (!sizeof($words) || !sizeof($word_indizes))
		{
			return (utf8_strlen($text) >= $length + 3) ? utf8_substr($text, 0, $length) . '...' : $text;
		}
	}

	/**
	* Decode text whereby text is coming from the db and expected to be pre-parsed content
	* We are placing this outside of the message parser because we are often in need of it...
	*/
	public static function decode_message(&$message, $bbcode_uid = '')
	{
		global $board_config;

		if ($bbcode_uid)
		{
			$match = array('<br />', "[/*:m:$bbcode_uid]", ":u:$bbcode_uid", ":o:$bbcode_uid", ":$bbcode_uid");
			$replace = array("\n", '', '', '', '');
		}
		else
		{
			$match = array('<br />');
			$replace = array("\n");
		}

		$message = str_replace($match, $replace, $message);

		$match = self::get_preg_expression('bbcode_htm');
		$replace = array('\1', '\1', '\2', '\1', '', '');

		$message = preg_replace($match, $replace, $message);
	}

	/**
	* Strips all bbcode from a text and returns the plain content
	*/
	public static function strip_bbcode(&$text, $uid = '')
	{
		if (!$uid)
		{
			$uid = '[0-9a-z]{5,}';
		}

		$text = preg_replace("#\[\/?[a-z0-9\*\+\-]+(?:=.*?)?(?::[a-z])?(\:?$uid)\]#", ' ', $text);

		$match = self::get_preg_expression('bbcode_htm');
		$replace = array('\1', '\1', '\2', '\1', '', '');

		$text = preg_replace($match, $replace, $text);
	}

	/**
	* For display of custom parsed text on user-facing pages
	* Expects $text to be the value directly from the database (stored value)
	*/

	public static function generate_text_for_display($text, $uid, $bitfield, $flags)
	{
		static $bbcode;

		if (!$text)
		{
			return '';
		}

		$text = self::censor_text($text);

		// Parse bbcode if bbcode uid stored and bbcode enabled
		if ($uid && ($flags & OPTION_FLAG_BBCODE))
		{
			if (!class_exists('bbcode'))
			{
				global $phpbb_root_path, $phpEx;
				mx_cache::load_file( 'bbcode');
			}

			if (empty($bbcode))
			{
				$bbcode = new bbcode($bitfield);
			}
			else
			{
				$bbcode->bbcode($bitfield);
			}

			$bbcode->bbcode_second_pass($text, $uid);
		}

		$text = str_replace("\n", '<br />', $text);

		$text = self::smiley_text($text, !($flags & OPTION_FLAG_SMILIES));

		return $text;
	}


	/**
	* For parsing custom parsed text to be stored within the database.
	* This function additionally returns the uid and bitfield that needs to be stored.
	* Expects $text to be the value directly from request_var() and in it's non-parsed form
	*/
	public static function generate_text_for_storage(&$text, &$uid, &$bitfield, &$flags, $allow_bbcode = false, $allow_urls = false, $allow_smilies = false)
	{
		global $phpbb_root_path, $phpEx;

		$uid = $bitfield = '';

		if (!$text)
		{
			return;
		}

		if (!class_exists('parse_message'))
		{
			include($phpbb_root_path . 'includes/message_parser.' . $phpEx);
		}

		$message_parser = new parse_message($text);
		$message_parser->parse($allow_bbcode, $allow_urls, $allow_smilies);

		$text = $message_parser->message;
		$uid = $message_parser->bbcode_uid;

		// If the bbcode_bitfield is empty, there is no need for the uid to be stored.
		if (!$message_parser->bbcode_bitfield)
		{
			$uid = '';
		}

		$flags = (($allow_bbcode) ? OPTION_FLAG_BBCODE : 0) + (($allow_smilies) ? OPTION_FLAG_SMILIES : 0) + (($allow_urls) ? OPTION_FLAG_LINKS : 0);
		$bitfield = $message_parser->bbcode_bitfield;

		return;
	}

	/**
	* For decoding custom parsed text for edits as well as extracting the flags
	* Expects $text to be the value directly from the database (pre-parsed content)
	*/
	public static function generate_text_for_edit($text, $uid, $flags)
	{
		global $phpbb_root_path, $phpEx;

		self::decode_message($text, $uid);

		return array(
			'allow_bbcode'	=> ($flags & OPTION_FLAG_BBCODE) ? 1 : 0,
			'allow_smilies'	=> ($flags & OPTION_FLAG_SMILIES) ? 1 : 0,
			'allow_urls'	=> ($flags & OPTION_FLAG_LINKS) ? 1 : 0,
			'text'			=> $text
		);
	}

	/**
	* A subroutine of make_clickable used with preg_replace
	* It places correct HTML around an url, shortens the displayed text
	* and makes sure no entities are inside URLs
	*/
	public static function make_clickable_callback($type, $whitespace, $url, $relative_url, $class)
	{
		$append			= '';
		$url			= htmlspecialchars_decode($url);
		$relative_url	= htmlspecialchars_decode($relative_url);

		// make sure no HTML entities were matched
		$chars = array('<', '>', '"');
		$split = false;

		foreach ($chars as $char)
		{
			$next_split = strpos($url, $char);
			if ($next_split !== false)
			{
				$split = ($split !== false) ? min($split, $next_split) : $next_split;
			}
		}

		if ($split !== false)
		{
			// an HTML entity was found, so the URL has to end before it
			$append			= substr($url, $split) . $relative_url;
			$url			= substr($url, 0, $split);
			$relative_url	= '';
		}
		else if ($relative_url)
		{
			// same for $relative_url
			$split = false;
			foreach ($chars as $char)
			{
				$next_split = strpos($relative_url, $char);
				if ($next_split !== false)
				{
					$split = ($split !== false) ? min($split, $next_split) : $next_split;
				}
			}

			if ($split !== false)
			{
				$append			= substr($relative_url, $split);
				$relative_url	= substr($relative_url, 0, $split);
			}
		}

		// if the last character of the url is a punctuation mark, exclude it from the url
		$last_char = ($relative_url) ? $relative_url[strlen($relative_url) - 1] : $url[strlen($url) - 1];

		switch ($last_char)
		{
			case '.':
			case '?':
			case '!':
			case ':':
			case ',':
				$append = $last_char;
				if ($relative_url)
				{
					$relative_url = substr($relative_url, 0, -1);
				}
				else
				{
					$url = substr($url, 0, -1);
				}
			break;
		}

		switch ($type)
		{
			case MAGIC_URL_LOCAL:
				$tag			= 'l';
				$relative_url	= preg_replace('/[&?]sid=[0-9a-f]{32}$/', '', preg_replace('/([&?])sid=[0-9a-f]{32}&/', '$1', $relative_url));
				$url			= $url . '/' . $relative_url;
				$text			= ($relative_url) ? $relative_url : $url . '/';
			break;

			case MAGIC_URL_FULL:
				$tag	= 'm';
				$text	= (strlen($url) > 55) ? substr($url, 0, 39) . ' ... ' . substr($url, -10) : $url;
			break;

			case MAGIC_URL_WWW:
				$tag	= 'w';
				$url	= 'http://' . $url;
				$text	= (strlen($url) > 55) ? substr($url, 0, 39) . ' ... ' . substr($url, -10) : $url;
			break;

			case MAGIC_URL_EMAIL:
				$tag	= 'e';
				$text	= (strlen($url) > 55) ? substr($url, 0, 39) . ' ... ' . substr($url, -10) : $url;
				$url	= 'mailto:' . $url;
			break;
		}

		$url	= htmlspecialchars($url);
		$text	= htmlspecialchars($text);
		$append	= htmlspecialchars($append);

		$html	= "$whitespace<!-- $tag --><a$class href=\"$url\">$text</a><!-- $tag -->$append";

		return $html;
	}

	/**
	* make_clickable function
	*
	* Replace magic urls of form http://xxx.xxx., www.xxx. and xxx@xxx.xxx.
	* Cuts down displayed size of link if over 50 chars, turns absolute links
	* into relative versions when the server/script path matches the link
	*/
	public static function make_clickable($text, $server_url = false, $class = 'postlink')
	{
		if ($server_url === false)
		{
			$server_url = self::generate_board_url();
		}

		static $magic_url_match;
		static $magic_url_replace;
		static $static_class;

		if (!is_array($magic_url_match) || $static_class != $class)
		{
			$static_class = $class;
			$class = ($static_class) ? ' class="' . $static_class . '"' : '';
			$local_class = ($static_class) ? ' class="' . $static_class . '-local"' : '';

			$magic_url_match = $magic_url_replace = array();
			// Be sure to not let the matches cross over. ;)

			// relative urls for this board
			$magic_url_match[] = '#(^|[\n\t (>])(' . preg_quote($server_url, '#') . ')/(' . self::get_preg_expression('relative_url_inline') . ')#ie';
			$magic_url_replace[] = "make_clickable_callback(MAGIC_URL_LOCAL, '\$1', '\$2', '\$3', '$local_class')";

			// matches a xxxx://aaaaa.bbb.cccc. ...
			$magic_url_match[] = '#(^|[\n\t (>])(' . self::get_preg_expression('url_inline') . ')#ie';
			$magic_url_replace[] = "make_clickable_callback(MAGIC_URL_FULL, '\$1', '\$2', '', '$class')";

			// matches a "www.xxxx.yyyy[/zzzz]" kinda lazy URL thing
			$magic_url_match[] = '#(^|[\n\t (>])(' . self::get_preg_expression('www_url_inline') . ')#ie';
			$magic_url_replace[] = "make_clickable_callback(MAGIC_URL_WWW, '\$1', '\$2', '', '$class')";

			// matches an email@domain type address at the start of a line, or after a space or after what might be a BBCode.
			$magic_url_match[] = '/(^|[\n\t (>])(' . self::get_preg_expression('email') . ')/ie';
			$magic_url_replace[] = "make_clickable_callback(MAGIC_URL_EMAIL, '\$1', '\$2', '', '')";
		}

		return preg_replace($magic_url_match, $magic_url_replace, $text);
	}

	/**
	* Censoring
	*/
	public static function censor_text($text)
	{
		static $censors;
		global $mx_cache;

		if (!isset($censors) || !is_array($censors))
		{
			// obtain_word_list is taking care of the users censor option and the board-wide option
			$censors = $mx_cache->obtain_word_list();
		}

		if (sizeof($censors))
		{
			return preg_replace($censors['match'], $censors['replace'], $text);
		}

		return $text;
	}

	/**
	* Smiley processing
	*/
	public static function smiley_text($text, $force_option = false)
	{
		global $board_config, $mx_user, $phpbb_root_path;

		if ($force_option || !$board_config['allow_smilies'] || !$mx_user->optionget('viewsmilies'))
		{
			return preg_replace('#<!\-\- s(.*?) \-\-><img src="\{SMILIES_PATH\}\/.*? \/><!\-\- s\1 \-\->#', '\1', $text);
		}
		else
		{
			return preg_replace('#<!\-\- s(.*?) \-\-><img src="\{SMILIES_PATH\}\/(.*?) \/><!\-\- s\1 \-\->#', '<img src="' . $phpbb_root_path . $board_config['smilies_path'] . '/\2 />', $text);
		}
	}

	/**
	* General attachment parsing
	*
	* @param mixed $forum_id The forum id the attachments are displayed in (false if in private message)
	* @param string &$message The post/private message
	* @param array &$attachments The attachments to parse for (inline) display. The attachments array will hold templated data after parsing.
	* @param array &$update_count The attachment counts to be updated - will be filled
	* @param bool $preview If set to true the attachments are parsed for preview. Within preview mode the comments are fetched from the given $attachments array and not fetched from the database.
	*/
	public static function parse_attachments($forum_id, &$message, &$attachments, &$update_count, $preview = false)
	{
		if (!sizeof($attachments))
		{
			return;
		}

		global $template, $mx_cache, $mx_user, $mx_backend;
		global $extensions, $board_config, $phpbb_root_path, $phpEx;

		//
		$compiled_attachments = array();

		if (!isset($template->filename['attachment_tpl']))
		{
			$template->set_filenames(array(
				'attachment_tpl'	=> 'attachment.html')
			);
		}

		if (empty($extensions) || !is_array($extensions))
		{
			$extensions = $mx_backend->obtain_attach_extensions($forum_id);
		}

		// Look for missing attachment information...
		$attach_ids = array();
		foreach ($attachments as $pos => $attachment)
		{
			// If is_orphan is set, we need to retrieve the attachments again...
			if (!isset($attachment['extension']) && !isset($attachment['physical_filename']))
			{
				$attach_ids[(int) $attachment['attach_id']] = $pos;
			}
		}

		// Grab attachments (security precaution)
		if (sizeof($attach_ids))
		{
			global $db;

			$new_attachment_data = array();

			$sql = 'SELECT *
				FROM ' . ATTACHMENTS_TABLE . '
				WHERE ' . $db->sql_in_set('attach_id', array_keys($attach_ids));
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				if (!isset($attach_ids[$row['attach_id']]))
				{
					continue;
				}

				// If we preview attachments we will set some retrieved values here
				if ($preview)
				{
					$row['attach_comment'] = $attachments[$attach_ids[$row['attach_id']]]['attach_comment'];
				}

				$new_attachment_data[$attach_ids[$row['attach_id']]] = $row;
			}
			$db->sql_freeresult($result);

			$attachments = $new_attachment_data;
			unset($new_attachment_data);
		}

		// Sort correctly
		if ($board_config['display_order'])
		{
			// Ascending sort
			krsort($attachments);
		}
		else
		{
			// Descending sort
			ksort($attachments);
		}

		foreach ($attachments as $attachment)
		{
			if (!sizeof($attachment))
			{
				continue;
			}

			// We need to reset/empty the _file block var, because this function might be called more than once
			$template->destroy_block_vars('_file');

			$block_array = array();

			// Some basics...
			$attachment['extension'] = strtolower(trim($attachment['extension']));
			$filename = $phpbb_root_path . $board_config['upload_path'] . '/' . basename($attachment['physical_filename']);
			$thumbnail_filename = $phpbb_root_path . $board_config['upload_path'] . '/thumb_' . basename($attachment['physical_filename']);

			$upload_icon = '';

			if (isset($extensions[$attachment['extension']]))
			{
				if ($mx_user->img('icon_topic_attach', '') && !$extensions[$attachment['extension']]['upload_icon'])
				{
					$upload_icon = $mx_user->img('icon_topic_attach', '');
				}
				else if ($extensions[$attachment['extension']]['upload_icon'])
				{
					$upload_icon = '<img src="' . $phpbb_root_path . $board_config['upload_icons_path'] . '/' . trim($extensions[$attachment['extension']]['upload_icon']) . '" alt="" />';
				}
			}

			$filesize = $attachment['filesize'];
			$size_lang = ($filesize >= 1048576) ? $mx_user->lang['MB'] : ( ($filesize >= 1024) ? $mx_user->lang['KB'] : $mx_user->lang['BYTES'] );
			$filesize = ($filesize >= 1048576) ? round((round($filesize / 1048576 * 100) / 100), 2) : (($filesize >= 1024) ? round((round($filesize / 1024 * 100) / 100), 2) : $filesize);

			$comment = str_replace("\n", '<br />', self::censor_text($attachment['attach_comment']));

			$block_array += array(
				'UPLOAD_ICON'		=> $upload_icon,
				'FILESIZE'			=> $filesize,
				'SIZE_LANG'			=> $size_lang,
				'DOWNLOAD_NAME'		=> basename($attachment['real_filename']),
				'COMMENT'			=> $comment,
			);

			$denied = false;

			if (!extension_allowed($forum_id, $attachment['extension'], $extensions))
			{
				$denied = true;

				$block_array += array(
					'S_DENIED'			=> true,
					'DENIED_MESSAGE'	=> sprintf($mx_user->lang['EXTENSION_DISABLED_AFTER_POSTING'], $attachment['extension'])
				);
			}

			if (!$denied)
			{
				$l_downloaded_viewed = $download_link = '';
				$display_cat = $extensions[$attachment['extension']]['display_cat'];

				if ($display_cat == ATTACHMENT_CATEGORY_IMAGE)
				{
					if ($attachment['thumbnail'])
					{
						$display_cat = ATTACHMENT_CATEGORY_THUMB;
					}
					else
					{
						if ($board_config['img_display_inlined'])
						{
							if ($board_config['img_link_width'] || $board_config['img_link_height'])
							{
								$dimension = @getimagesize($filename);

								// If the dimensions could not be determined or the image being 0x0 we display it as a link for safety purposes
								if ($dimension === false || empty($dimension[0]) || empty($dimension[1]))
								{
									$display_cat = ATTACHMENT_CATEGORY_NONE;
								}
								else
								{
									$display_cat = ($dimension[0] <= $board_config['img_link_width'] && $dimension[1] <= $board_config['img_link_height']) ? ATTACHMENT_CATEGORY_IMAGE : ATTACHMENT_CATEGORY_NONE;
								}
							}
						}
						else
						{
							$display_cat = ATTACHMENT_CATEGORY_NONE;
						}
					}
				}

				// Make some descisions based on user options being set.
				if (($display_cat == ATTACHMENT_CATEGORY_IMAGE || $display_cat == ATTACHMENT_CATEGORY_THUMB) && !$mx_user->optionget('viewimg'))
				{
					$display_cat = ATTACHMENT_CATEGORY_NONE;
				}

				if ($display_cat == ATTACHMENT_CATEGORY_FLASH && !$mx_user->optionget('viewflash'))
				{
					$display_cat = ATTACHMENT_CATEGORY_NONE;
				}

				$download_link = mx3_append_sid("{$phpbb_root_path}download.$phpEx", 'id=' . $attachment['attach_id']);

				switch ($display_cat)
				{
					// Images
					case ATTACHMENT_CATEGORY_IMAGE:
						$l_downloaded_viewed = 'VIEWED_COUNT';
						$inline_link = mx3_append_sid("{$phpbb_root_path}download.$phpEx", 'id=' . $attachment['attach_id']);
						$download_link .= '&amp;mode=view';

						$block_array += array(
							'S_IMAGE'		=> true,
							'U_INLINE_LINK'		=> $inline_link,
						);

						$update_count[] = $attachment['attach_id'];
					break;

					// Images, but display Thumbnail
					case ATTACHMENT_CATEGORY_THUMB:
						$l_downloaded_viewed = 'VIEWED_COUNT';
						$thumbnail_link = mx3_append_sid("{$phpbb_root_path}download.$phpEx", 'id=' . $attachment['attach_id'] . '&amp;t=1');
						$download_link .= '&amp;mode=view';

						$block_array += array(
							'S_THUMBNAIL'		=> true,
							'THUMB_IMAGE'		=> $thumbnail_link,
						);
					break;

					// Windows Media Streams
					case ATTACHMENT_CATEGORY_WM:
						$l_downloaded_viewed = 'VIEWED_COUNT';

						// Giving the filename directly because within the wm object all variables are in local context making it impossible
						// to validate against a valid session (all params can differ)
						// $download_link = $filename;

						$block_array += array(
							'U_FORUM'		=> self::generate_board_url(),
							'ATTACH_ID'		=> $attachment['attach_id'],
							'S_WM_FILE'		=> true,
						);

						// Viewed/Heared File ... update the download count
						$update_count[] = $attachment['attach_id'];
					break;

					// Real Media Streams
					case ATTACHMENT_CATEGORY_RM:
					case ATTACHMENT_CATEGORY_QUICKTIME:
						$l_downloaded_viewed = 'VIEWED_COUNT';

						$block_array += array(
							'S_RM_FILE'			=> ($display_cat == ATTACHMENT_CATEGORY_RM) ? true : false,
							'S_QUICKTIME_FILE'	=> ($display_cat == ATTACHMENT_CATEGORY_QUICKTIME) ? true : false,
							'U_FORUM'			=> self::generate_board_url(),
							'ATTACH_ID'			=> $attachment['attach_id'],
						);

						// Viewed/Heared File ... update the download count
						$update_count[] = $attachment['attach_id'];
					break;

					// Macromedia Flash Files
					case ATTACHMENT_CATEGORY_FLASH:
						list($width, $height) = @getimagesize($filename);

						$l_downloaded_viewed = 'VIEWED_COUNT';

						$block_array += array(
							'S_FLASH_FILE'	=> true,
							'WIDTH'			=> $width,
							'HEIGHT'		=> $height,
						);

						// Viewed/Heared File ... update the download count
						$update_count[] = $attachment['attach_id'];
					break;

					default:
						$l_downloaded_viewed = 'DOWNLOAD_COUNT';

						$block_array += array(
							'S_FILE'		=> true,
						);
					break;
				}

				$l_download_count = (!isset($attachment['download_count']) || $attachment['download_count'] == 0) ? $mx_user->lang[$l_downloaded_viewed . '_NONE'] : (($attachment['download_count'] == 1) ? sprintf($mx_user->lang[$l_downloaded_viewed], $attachment['download_count']) : sprintf($mx_user->lang[$l_downloaded_viewed . 'S'], $attachment['download_count']));

				$block_array += array(
					'U_DOWNLOAD_LINK'		=> $download_link,
					'L_DOWNLOAD_COUNT'		=> $l_download_count
				);
			}

			$template->assign_block_vars('_file', $block_array);

			$compiled_attachments[] = $template->assign_display('attachment_tpl');
		}

		$attachments = $compiled_attachments;
		unset($compiled_attachments);

		$tpl_size = sizeof($attachments);

		$unset_tpl = array();

		preg_match_all('#<!\-\- ia([0-9]+) \-\->(.*?)<!\-\- ia\1 \-\->#', $message, $matches, PREG_PATTERN_ORDER);

		$replace = array();
		foreach ($matches[0] as $num => $capture)
		{
			// Flip index if we are displaying the reverse way
			$index = ($board_config['display_order']) ? ($tpl_size-($matches[1][$num] + 1)) : $matches[1][$num];

			$replace['from'][] = $matches[0][$num];
			$replace['to'][] = (isset($attachments[$index])) ? $attachments[$index] : sprintf($mx_user->lang['MISSING_INLINE_ATTACHMENT'], $matches[2][array_search($index, $matches[1])]);

			$unset_tpl[] = $index;
		}

		if (isset($replace['from']))
		{
			$message = str_replace($replace['from'], $replace['to'], $message);
		}

		$unset_tpl = array_unique($unset_tpl);

		// Needed to let not display the inlined attachments at the end of the post again
		foreach ($unset_tpl as $index)
		{
			unset($attachments[$index]);
		}
	}

	/**
	* Check if extension is allowed to be posted.
	*
	* @param mixed $forum_id The forum id to check or false if private message
	* @param string $extension The extension to check, for example zip.
	* @param array &$extensions The extension array holding the information from the cache (will be obtained if empty)
	*
	* @return bool False if the extension is not allowed to be posted, else true.
	*/
	public static function extension_allowed($forum_id, $extension, &$extensions)
	{
		if (empty($extensions))
		{
			global $mx_backend;
			$extensions = $mx_backend->obtain_attach_extensions($forum_id);
		}

		return (!isset($extensions['_allowed_'][$extension])) ? false : true;
	}

	// Little helpers

	/**
	* Little helper for the build_hidden_fields function
	*/
	public static function _build_hidden_fields($key, $value, $specialchar, $stripslashes)
	{
		$hidden_fields = '';

		if (!is_array($value))
		{
			$value = ($stripslashes) ? stripslashes($value) : $value;
			$value = ($specialchar) ? htmlspecialchars($value, ENT_COMPAT, 'UTF-8') : $value;

			$hidden_fields .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
		}
		else
		{
			foreach ($value as $_key => $_value)
			{
				$_key = ($stripslashes) ? stripslashes($_key) : $_key;
				$_key = ($specialchar) ? htmlspecialchars($_key, ENT_COMPAT, 'UTF-8') : $_key;

				$hidden_fields .= _build_hidden_fields($key . '[' . $_key . ']', $_value, $specialchar, $stripslashes);
			}
		}

		return $hidden_fields;
	}

	/**
	* Build simple hidden fields from array
	*
	* @param array $field_ary an array of values to build the hidden field from
	* @param bool $specialchar if true, keys and values get specialchared
	* @param bool $stripslashes if true, keys and values get stripslashed
	*
	* @return string the hidden fields
	*/
	public static function build_hidden_fields($field_ary, $specialchar = false, $stripslashes = false)
	{
		$s_hidden_fields = '';

		foreach ($field_ary as $name => $vars)
		{
			$name = ($stripslashes) ? stripslashes($name) : $name;
			$name = ($specialchar) ? htmlspecialchars($name, ENT_COMPAT, 'UTF-8') : $name;

			$s_hidden_fields .= _build_hidden_fields($name, $vars, $specialchar, $stripslashes);
		}

		return $s_hidden_fields;
	}

	/**
	* Parse cfg file
	*/
	public static function parse_cfg_file($filename, $lines = false)
	{
		$parsed_items = array();

		if ($lines === false)
		{
			$lines = file($filename);
		}

		foreach ($lines as $line)
		{
			$line = trim($line);

			if (!$line || $line[0] == '#' || ($delim_pos = strpos($line, '=')) === false)
			{
				continue;
			}

			// Determine first occurrence, since in values the equal sign is allowed
			$key = strtolower(trim(substr($line, 0, $delim_pos)));
			$value = trim(substr($line, $delim_pos + 1));

			if (in_array($value, array('off', 'false', '0')))
			{
				$value = false;
			}
			else if (in_array($value, array('on', 'true', '1')))
			{
				$value = true;
			}
			else if (!trim($value))
			{
				$value = '';
			}
			else if (($value[0] == "'" && $value[sizeof($value) - 1] == "'") || ($value[0] == '"' && $value[sizeof($value) - 1] == '"'))
			{
				$value = substr($value, 1, sizeof($value)-2);
			}

			$parsed_items[$key] = $value;
		}

		return $parsed_items;
	}

	/**
	* Add log event
	*/
	public static function add_log()
	{
		global $db, $mx_user;

		$args = func_get_args();

		$mode			= array_shift($args);
		$reportee_id	= ($mode == 'user') ? intval(array_shift($args)) : '';
		$forum_id		= ($mode == 'mod') ? intval(array_shift($args)) : '';
		$topic_id		= ($mode == 'mod') ? intval(array_shift($args)) : '';
		$action			= array_shift($args);
		$data			= (!sizeof($args)) ? '' : serialize($args);

		$sql_ary = array(
			'user_id'		=> (empty($mx_user->data)) ? ANONYMOUS : $mx_user->data['user_id'],
			'log_ip'		=> $mx_user->ip,
			'log_time'		=> time(),
			'log_operation'	=> $action,
			'log_data'		=> $data,
		);

		switch ($mode)
		{
			case 'admin':
				$sql_ary['log_type'] = LOG_ADMIN;
			break;

			case 'mod':
				$sql_ary += array(
					'log_type'	=> LOG_MOD,
					'forum_id'	=> $forum_id,
					'topic_id'	=> $topic_id
				);
			break;

			case 'user':
				$sql_ary += array(
					'log_type'		=> LOG_USERS,
					'reportee_id'	=> $reportee_id
				);
			break;

			case 'critical':
				$sql_ary['log_type'] = LOG_CRITICAL;
			break;

			default:
				return false;
		}

		$db->sql_query('INSERT INTO ' . LOG_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary));

		return $db->sql_nextid();
	}

	/**
	* Return a nicely formatted backtrace (parts from the php manual by diz at ysagoon dot com)
	*/
	public static function get_backtrace()
	{
		global $phpbb_root_path;

		$output = '<div style="font-family: monospace;">';
		$backtrace = debug_backtrace();
		$path = phpBB2::phpbb_realpath($phpbb_root_path);

		foreach ($backtrace as $number => $trace)
		{
			// We skip the first one, because it only shows this file/function
			if ($number == 0)
			{
				continue;
			}

			// Strip the current directory from path
			if (empty($trace['file']))
			{
				$trace['file'] = '';
			}
			else
			{
				$trace['file'] = str_replace(array($path, '\\'), array('', '/'), $trace['file']);
				$trace['file'] = substr($trace['file'], 1);
			}
			$args = array();

			// If include/require/include_once is not called, do not show arguments - they may contain sensible information
			if (!in_array($trace['function'], array('include', 'require', 'include_once')))
			{
				unset($trace['args']);
			}
			else
			{
				// Path...
				if (!empty($trace['args'][0]))
				{
					$argument = htmlspecialchars($trace['args'][0]);
					$argument = str_replace(array($path, '\\'), array('', '/'), $argument);
					$argument = substr($argument, 1);
					$args[] = "'{$argument}'";
				}
			}

			$trace['class'] = (!isset($trace['class'])) ? '' : $trace['class'];
			$trace['type'] = (!isset($trace['type'])) ? '' : $trace['type'];

			$output .= '<br />';
			$output .= '<b>FILE:</b> ' . htmlspecialchars($trace['file']) . '<br />';
			$output .= '<b>LINE:</b> ' . ((!empty($trace['line'])) ? $trace['line'] : '') . '<br />';

			$output .= '<b>CALL:</b> ' . htmlspecialchars($trace['class'] . $trace['type'] . $trace['function']) . '(' . ((sizeof($args)) ? implode(', ', $args) : '') . ')<br />';
		}
		$output .= '</div>';
		return $output;
	}

	/**
	* This function returns a regular expression pattern for commonly used expressions
	* Use with / as delimiter for email mode and # for url modes
	* mode can be: email|bbcode_htm|url|url_inline|www_url|www_url_inline|relative_url|relative_url_inline
	*/
	public static function get_preg_expression($mode)
	{
		switch ($mode)
		{
			case 'email':
				// Regex written by James Watts and Francisco Jose Martin Moreno
				// http://fightingforalostcause.net/misc/2006/compare-email-regex.php
				return '([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*(?:[\w\!\#$\%\'\*\+\-\/\=\?\^\`{\|\}\~]|&amp;)+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)';
			break;

			case 'bbcode_htm':
				return array(
					'#<!\-\- e \-\-><a href="mailto:(.*?)">.*?</a><!\-\- e \-\->#',
					'#<!\-\- l \-\-><a (?:class="[\w-]+" )?href="(.*?)(?:(&amp;|\?)sid=[0-9a-f]{32})?">.*?</a><!\-\- l \-\->#',
					'#<!\-\- ([mw]) \-\-><a (?:class="[\w-]+" )?href="(.*?)">.*?</a><!\-\- \1 \-\->#',
					'#<!\-\- s(.*?) \-\-><img src="\{SMILIES_PATH\}\/.*? \/><!\-\- s\1 \-\->#',
					'#<!\-\- .*? \-\->#s',
					'#<.*?>#s',
				);
			break;

			// Whoa these look impressive!
			// The code to generate the following two regular expressions which match valid IPv4/IPv6 addresses
			// can be found in the develop directory
			case 'ipv4':
				return '#^(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$#';
			break;

			case 'ipv6':
				return '#^(?:(?:(?:[\dA-F]{1,4}:){6}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:::(?:[\dA-F]{1,4}:){0,5}(?:[\dA-F]{1,4}(?::[\dA-F]{1,4})?|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:):(?:[\dA-F]{1,4}:){4}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,2}:(?:[\dA-F]{1,4}:){3}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,3}:(?:[\dA-F]{1,4}:){2}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,4}:(?:[\dA-F]{1,4}:)(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,5}:(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,6}:[\dA-F]{1,4})|(?:(?:[\dA-F]{1,4}:){1,7}:)|(?:::))$#i';
			break;

			case 'url':
				// generated with regex_idn.php file in the develop folder
				return "[a-z][a-z\d+\-.]*(?<!javascript):/{2}(?:(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@|]+|%[\dA-F]{2})+|[0-9.]+|\[[a-z0-9.]+:[a-z0-9.]+:[a-z0-9.:]+\])(?::\d*)?(?:/(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@/?|]+|%[\dA-F]{2})*)?";
			break;

			case 'url_http':
				// generated with regex_idn.php file in the develop folder
				return "http[s]?:/{2}(?:(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@|]+|%[\dA-F]{2})+|[0-9.]+|\[[a-z0-9.]+:[a-z0-9.]+:[a-z0-9.:]+\])(?::\d*)?(?:/(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@/?|]+|%[\dA-F]{2})*)?";
			break;

			case 'url_inline':
				$inline = ($mode == 'url') ? ')' : '';
				$scheme = ($mode == 'url') ? '[a-z\d+\-.]' : '[a-z\d+]'; // avoid automatic parsing of "word" in "last word.http://..."
				// generated with regex generation file in the develop folder
				return "[a-z]$scheme*:/{2}(?:(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})+|[0-9.]+|\[[a-z0-9.]+:[a-z0-9.]+:[a-z0-9.:]+\])(?::\d*)?(?:/(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?";
			break;

			case 'www_url':
				// generated with regex_idn.php file in the develop folder
				return "www\.(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@|]+|%[\dA-F]{2})+(?::\d*)?(?:/(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@/?|]+|%[\dA-F]{2})*)?";
			break;

			case 'www_url_inline':
				$inline = ($mode == 'www_url') ? ')' : '';
				return "www\.(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})+(?::\d*)?(?:/(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?";
			break;

			case 'relative_url':
				// generated with regex_idn.php file in the develop folder
				return "(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@|]+|%[\dA-F]{2})*(?:/(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[^\p{C}\p{Z}\p{S}\p{P}\p{Nl}\p{No}\p{Me}\x{1100}-\x{115F}\x{A960}-\x{A97C}\x{1160}-\x{11A7}\x{D7B0}-\x{D7C6}\x{20D0}-\x{20FF}\x{1D100}-\x{1D1FF}\x{1D200}-\x{1D24F}\x{0640}\x{07FA}\x{302E}\x{302F}\x{3031}-\x{3035}\x{303B}]*[\x{00B7}\x{0375}\x{05F3}\x{05F4}\x{30FB}\x{002D}\x{06FD}\x{06FE}\x{0F0B}\x{3007}\x{00DF}\x{03C2}\x{200C}\x{200D}\pL0-9\-._~!$&'()*+,;=:@/?|]+|%[\dA-F]{2})*)?";
			break;

			case 'relative_url_inline':
				$inline = ($mode == 'relative_url') ? ')' : '';
				return "(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*(?:/(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?";
			break;

			case 'table_prefix':
				return '#^[a-zA-Z][a-zA-Z0-9_]*$#';
			break;

			// Matches the predecing dot
			case 'path_remove_dot_trailing_slash':
				return '#^(?:(\.)?)+(?:(.+)?)+(?:([\\/\\\])$)#';
			break;

			case 'semantic_version':
				// Regular expression to match semantic versions by http://rgxdb.com/
				return '/(?<=^[Vv]|^)(?:(?<major>(?:0|[1-9](?:(?:0|[1-9])+)*))[.](?<minor>(?:0|[1-9](?:(?:0|[1-9])+)*))[.](?<patch>(?:0|[1-9](?:(?:0|[1-9])+)*))(?:-(?<prerelease>(?:(?:(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?|(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?)|(?:0|[1-9](?:(?:0|[1-9])+)*))(?:[.](?:(?:(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?|(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?)|(?:0|[1-9](?:(?:0|[1-9])+)*)))*))?(?:[+](?<build>(?:(?:(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?|(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?)|(?:(?:0|[1-9])+))(?:[.](?:(?:(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?|(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?)|(?:(?:0|[1-9])+)))*))?)$/';
			break;
		}

		return '';
	}

	/**
	* Returns the first block of the specified IPv6 address and as many additional
	* ones as specified in the length paramater.
	* If length is zero, then an empty string is returned.
	* If length is greater than 3 the complete IP will be returned
	*/
	public static function short_ipv6($ip, $length)
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
			$ip = implode(':', array_slice(explode(':', $ip), 0, 1 + $length));
		}

		return $ip;
	}

	/**
	* Truncates string while retaining special characters if going over the max length
	* The default max length is 60 at the moment
	*/
	public static function truncate_string($string, $max_length = 60, $allow_reply = true, $append = '')
	{
		$chars = array();

		$strip_reply = false;
		$stripped = false;
		if ($allow_reply && strpos($string, 'Re: ') === 0)
		{
			$strip_reply = true;
			$string = substr($string, 4);
		}

		$_chars = utf8_str_split(htmlspecialchars_decode($string));
		$chars = array_map('htmlspecialchars', $_chars);

		// Now check the length ;)
		if (sizeof($chars) > $max_length)
		{
			// Cut off the last elements from the array
			$string = implode('', array_slice($chars, 0, $max_length));
			$stripped = true;
		}

		if ($strip_reply)
		{
			$string = 'Re: ' . $string;
		}

		if ($append != '' && $stripped)
		{
			$string = $string . $append;
		}

		return $string;
	}

	/**
	* Get username details for placing into templates.
	*
	* @param string $mode Can be profile (for getting an url to the profile), username (for obtaining the username), colour (for obtaining the user colour) or full (for obtaining a html string representing a coloured link to the users profile).
	* @param int $mx_user_id The users id
	* @param string $mx_username The users name
	* @param string $mx_username_colour The users colour
	* @param string $guest_username optional parameter to specify the guest username. It will be used in favor of the GUEST language variable then.
	* @param string $custom_profile_url optional parameter to specify a profile url. The user id get appended to this url as &amp;u={user_id}
	*
	* @return string A string consisting of what is wanted based on $mode.
	*/
	public static function get_username_string($mode, $mx_user_id, $mx_username, $mx_username_colour = '', $guest_username = false, $custom_profile_url = false)
	{
		global $phpbb_root_path, $phpEx, $mx_user, $phpbb_auth;

		$profile_url = '';
		$mx_username_colour = ($mx_username_colour) ? '#' . $mx_username_colour : '';

		if ($guest_username === false)
		{
			$mx_username = ($mx_username) ? $mx_username : $mx_user->lang['GUEST'];
		}
		else
		{
			$mx_username = ($mx_user_id && $mx_user_id != ANONYMOUS) ? $mx_username : ((!empty($guest_username)) ? $guest_username : $mx_user->lang['GUEST']);
		}

		// Only show the link if not anonymous
		if ($mx_user_id && $mx_user_id != ANONYMOUS)
		{
			// Do not show the link if the user is already logged in but do not have u_viewprofile permissions (relevant for bots mostly).
			// For all others the link leads to a login page or the profile.
			if ($mx_user->data['user_id'] != ANONYMOUS && !$phpbb_auth->acl_get('u_viewprofile'))
			{
				$profile_url = '';
			}
			else
			{
				$profile_url = ($custom_profile_url !== false) ? $custom_profile_url : mx3_append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile');
				$profile_url .= '&amp;u=' . (int) $mx_user_id;
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
				return $mx_username;
			break;

			case 'colour':
				return $mx_username_colour;
			break;

			case 'full':
			default:

				$tpl = '';
				if (!$profile_url && !$mx_username_colour)
				{
					$tpl = '{USERNAME}';
				}
				else if (!$profile_url && $mx_username_colour)
				{
					$tpl = '<span style="color: {USERNAME_COLOUR};" class="username-coloured">{USERNAME}</span>';
				}
				else if ($profile_url && !$mx_username_colour)
				{
					$tpl = '<a href="{PROFILE_URL}">{USERNAME}</a>';
				}
				else if ($profile_url && $mx_username_colour)
				{
					$tpl = '<a href="{PROFILE_URL}" style="color: {USERNAME_COLOUR};" class="username-coloured">{USERNAME}</a>';
				}

				return str_replace(array('{PROFILE_URL}', '{USERNAME_COLOUR}', '{USERNAME}'), array($profile_url, $mx_username_colour, $mx_username), $tpl);
			break;
		}
	}

	/**
	* Wrapper for php's checkdnsrr function.
	*
	* The windows failover is from the php manual
	* Please make sure to check the return value for === true and === false, since NULL could
	* be returned too.
	*
	* @return true if entry found, false if not, NULL if this function is not supported by this environment
	*/
	public static function phpbb_checkdnsrr($host, $type = '')
	{
		$type = (!$type) ? 'MX' : $type;

		if (DIRECTORY_SEPARATOR == '\\')
		{
			if (!function_exists('exec'))
			{
				return NULL;
			}

			@exec('nslookup -type=' . escapeshellarg($type) . ' ' . escapeshellarg($host), $output);

			// If output is empty, the nslookup failed
			if (empty($output))
			{
				return NULL;
			}

			foreach ($output as $line)
			{
				if (!trim($line))
				{
					continue;
				}

				// Valid records begin with host name:
				if (strpos($line, $host) === 0)
				{
					return true;
				}
			}

			return false;
		}
		else if (function_exists('checkdnsrr'))
		{
			return (checkdnsrr($host, $type)) ? true : false;
		}

		return NULL;
	}

	// Handler, header and footer

	/**
	* Error and message handler, call with trigger_error if reqd
	*/
	public static function msg_handler($errno, $msg_text, $errfile, $errline)
	{
		global $mx_cache, $db, $phpbb_auth, $template, $board_config, $mx_user;
		global $phpEx, $phpbb_root_path, $msg_title, $msg_long_text;

		// Message handler is stripping text. In case we need it, we are possible to define long text...
		if (isset($msg_long_text) && $msg_long_text && !$msg_text)
		{
			$msg_text = $msg_long_text;
		}

		switch ($errno)
		{
			case E_NOTICE:
			case E_WARNING:

				// Check the error reporting level and return if the error level does not match
				// Additionally do not display notices if we suppress them via @
				// If DEBUG is defined the default level is E_ALL
				if (($errno & ((defined('DEBUG') && error_reporting()) ? E_ALL : error_reporting())) == 0)
				{
					return;
				}

				if (strpos($errfile, 'cache') === false && strpos($errfile, 'template.') === false)
				{
					// remove complete path to installation, with the risk of changing backslashes meant to be there
					$errfile = str_replace(array(self::phpbb_realpath($phpbb_root_path), '\\'), array('', '/'), $errfile);
					$msg_text = str_replace(array(self::phpbb_realpath($phpbb_root_path), '\\'), array('', '/'), $msg_text);

					echo '<b>[phpBB Debug] PHP Notice</b>: in file <b>' . $errfile . '</b> on line <b>' . $errline . '</b>: <b>' . $msg_text . '</b><br />' . "\n";
				}

				return;

			break;

			case E_USER_ERROR:

				if (!empty($mx_user) && !empty($mx_user->lang))
				{
					$msg_text = (!empty($mx_user->lang[$msg_text])) ? $mx_user->lang[$msg_text] : $msg_text;
					$msg_title = (!isset($msg_title)) ? $mx_user->lang['GENERAL_ERROR'] : ((!empty($mx_user->lang[$msg_title])) ? $mx_user->lang[$msg_title] : $msg_title);

					$l_return_index = sprintf($mx_user->lang['RETURN_INDEX'], '<a href="' . $phpbb_root_path . '">', '</a>');
					$l_notify = '';

					if (!empty($board_config['board_contact']))
					{
						$l_notify = '<p>' . sprintf($mx_user->lang['NOTIFY_ADMIN_EMAIL'], $board_config['board_contact']) . '</p>';
					}
				}
				else
				{
					$msg_title = 'General Error';
					$l_return_index = '<a href="' . $phpbb_root_path . '">Return to index page</a>';
					$l_notify = '';

					if (!empty($board_config['board_contact']))
					{
						$l_notify = '<p>Please notify the board administrator or webmaster: <a href="mailto:' . $board_config['board_contact'] . '">' . $board_config['board_contact'] . '</a></p>';
					}
				}

				garbage_collection();

				// Try to not call the adm page data...

				echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
				echo '<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">';
				echo '<head>';
				echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
				echo '<title>' . $msg_title . '</title>';
				echo '<style type="text/css">' . "\n" . '<!--' . "\n";
				echo '* { margin: 0; padding: 0; } html { font-size: 100%; height: 100%; margin-bottom: 1px; background-color: #E4EDF0; } body { font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif; color: #536482; background: #E4EDF0; font-size: 62.5%; margin: 0; } ';
				echo 'a:link, a:active, a:visited { color: #006699; text-decoration: none; } a:hover { color: #DD6900; text-decoration: underline; } ';
				echo '#wrap { padding: 0 20px 15px 20px; min-width: 615px; } #page-header { text-align: right; height: 40px; } #page-footer { clear: both; font-size: 1em; text-align: center; } ';
				echo '.panel { margin: 4px 0; background-color: #FFFFFF; border: solid 1px  #A9B8C2; } ';
				echo '#errorpage #page-header a { font-weight: bold; line-height: 6em; } #errorpage #content { padding: 10px; } #errorpage #content h1 { line-height: 1.2em; margin-bottom: 0; color: #DF075C; } ';
				echo '#errorpage #content div { margin-top: 20px; margin-bottom: 5px; border-bottom: 1px solid #CCCCCC; padding-bottom: 5px; color: #333333; font: bold 1.2em "Lucida Grande", Arial, Helvetica, sans-serif; text-decoration: none; line-height: 120%; text-align: left; } ';
				echo "\n" . '//-->' . "\n";
				echo '</style>';
				echo '</head>';
				echo '<body id="errorpage">';
				echo '<div id="wrap">';
				echo '	<div id="page-header">';
				echo '		' . $l_return_index;
				echo '	</div>';
				echo '	<div id="acp">';
				echo '	<div class="panel">';
				echo '		<div id="content">';
				echo '			<h1>' . $msg_title . '</h1>';

				echo '			<div>' . $msg_text . '</div>';

				echo $l_notify;

				echo '		</div>';
				echo '	</div>';
				echo '	</div>';
				echo '	<div id="page-footer">';
				echo '		Powered by phpBB &copy; 2000, 2002, 2005, 2007 <a href="http://www.phpbb.com/">phpBB Group</a>';
				echo '	</div>';
				echo '</div>';
				echo '</body>';
				echo '</html>';

				exit;
			break;

			case E_USER_WARNING:
			case E_USER_NOTICE:

				define('IN_ERROR_HANDLER', true);

				if (empty($mx_user->data))
				{
					$mx_user->session_begin();
				}

				// We re-init the auth array to get correct results on login/logout
				$phpbb_auth->acl($mx_user->data);

				if (empty($mx_user->lang))
				{
					$mx_user->setup();
				}

				$msg_text = (!empty($mx_user->lang[$msg_text])) ? $mx_user->lang[$msg_text] : $msg_text;
				$msg_title = (!isset($msg_title)) ? $mx_user->lang['INFORMATION'] : ((!empty($mx_user->lang[$msg_title])) ? $mx_user->lang[$msg_title] : $msg_title);

				if (!defined('HEADER_INC'))
				{
					if (defined('IN_ADMIN') && isset($mx_user->data['session_admin']) && $mx_user->data['session_admin'])
					{
						adm_page_header($msg_title);
					}
					else
					{
						page_header($msg_title);
					}
				}

				$template->set_filenames(array(
					'body' => 'message_body.html')
				);

				$template->assign_vars(array(
					'MESSAGE_TITLE'		=> $msg_title,
					'MESSAGE_TEXT'		=> $msg_text,
					'S_USER_WARNING'	=> ($errno == E_USER_WARNING) ? true : false,
					'S_USER_NOTICE'		=> ($errno == E_USER_NOTICE) ? true : false)
				);

				// We do not want the cron script to be called on error messages
				define('IN_CRON', true);

				if (defined('IN_ADMIN') && isset($mx_user->data['session_admin']) && $mx_user->data['session_admin'])
				{
					adm_page_footer();
				}
				else
				{
					page_footer();
				}

				exit;
			break;
		}

		// If we notice an error not handled here we pass this back to PHP by returning false
		// This may not work for all php versions
		return false;
	}

	/**
	* Generate page header
	function page_header($page_title = '', $display_online_list = true)
	{
		global $db, $board_config, $template, $SID, $_SID, $mx_user, $phpbb_auth, $phpEx, $phpbb_root_path;

		if (defined('HEADER_INC'))
		{
			return;
		}

		define('HEADER_INC', true);

		// gzip_compression
		if ($board_config['gzip_compress'])
		{
			if (@extension_loaded('zlib') && !headers_sent())
			{
				ob_start('ob_gzhandler');
			}
		}

		// Generate logged in/logged out status
		if ($mx_user->data['user_id'] != ANONYMOUS)
		{
			$u_login_logout = mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=logout', true, $mx_user->session_id);
			$l_login_logout = sprintf($mx_user->lang['LOGOUT_USER'], $mx_user->data['username']);
		}
		else
		{
			$u_login_logout = mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=login');
			$l_login_logout = $mx_user->lang['LOGIN'];
		}

		// Last visit date/time
		$s_last_visit = ($mx_user->data['user_id'] != ANONYMOUS) ? $mx_user->format_date($mx_user->data['session_last_visit']) : '';

		// Get users online list ... if required
		$l_online_users = $online_userlist = $l_online_record = '';

		if ($board_config['load_online'] && $board_config['load_online_time'] && $display_online_list)
		{
			$logged_visible_online = $logged_hidden_online = $guests_online = $prev_user_id = 0;
			$prev_session_ip = $reading_sql = '';

			if (!empty($_REQUEST['f']))
			{
				$f = self::request_var('f', 0);

				$reading_sql = ' AND s.session_page ' . $db->sql_like_expression("{$db->any_char}_f_={$f}x{$db->any_char}");
			}

			// Get number of online guests
			if (!$board_config['load_online_guests'])
			{
				if ($db->sql_layer === 'sqlite')
				{
					$sql = 'SELECT COUNT(session_ip) as num_guests
						FROM (
							SELECT DISTINCT s.session_ip
								FROM ' . SESSIONS_TABLE . ' s
								WHERE s.session_user_id = ' . ANONYMOUS . '
									AND s.session_time >= ' . (time() - ($board_config['load_online_time'] * 60)) .
									$reading_sql .
						')';
				}
				else
				{
					$sql = 'SELECT COUNT(DISTINCT s.session_ip) as num_guests
						FROM ' . SESSIONS_TABLE . ' s
						WHERE s.session_user_id = ' . ANONYMOUS . '
							AND s.session_time >= ' . (time() - ($board_config['load_online_time'] * 60)) .
						$reading_sql;
				}
				$result = $db->sql_query($sql);
				$guests_online = (int) $db->sql_fetchfield('num_guests');
				$db->sql_freeresult($result);
			}

			$sql = 'SELECT u.username, u.username_clean, u.user_id, u.user_type, u.user_allow_viewonline, u.user_colour, s.session_ip, s.session_viewonline
				FROM ' . USERS_TABLE . ' u, ' . SESSIONS_TABLE . ' s
				WHERE s.session_time >= ' . (time() - (intval($board_config['load_online_time']) * 60)) .
					$reading_sql .
					((!$board_config['load_online_guests']) ? ' AND s.session_user_id <> ' . ANONYMOUS : '') . '
					AND u.user_id = s.session_user_id
				ORDER BY u.username_clean ASC, s.session_ip ASC';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				// User is logged in and therefore not a guest
				if ($row['user_id'] != ANONYMOUS)
				{
					// Skip multiple sessions for one user
					if ($row['user_id'] != $prev_user_id)
					{
						if ($row['user_colour'])
						{
							$mx_user_colour = ' style="color:#' . $row['user_colour'] . '"';
							$row['username'] = '<strong>' . $row['username'] . '</strong>';
						}
						else
						{
							$mx_user_colour = '';
						}

						if ($row['session_viewonline'])
						{
							$mx_user_online_link = $row['username'];
							$logged_visible_online++;
						}
						else
						{
							$mx_user_online_link = '<em>' . $row['username'] . '</em>';
							$logged_hidden_online++;
						}

						if (($row['session_viewonline']) || $phpbb_auth->acl_get('u_viewonline'))
						{
							if ($row['user_type'] <> USER_IGNORE)
							{
								$mx_user_online_link = '<a href="' . mx3_append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']) . '"' . $mx_user_colour . '>' . $mx_user_online_link . '</a>';
							}
							else
							{
								$mx_user_online_link = ($mx_user_colour) ? '<span' . $mx_user_colour . '>' . $mx_user_online_link . '</span>' : $mx_user_online_link;
							}

							$online_userlist .= ($online_userlist != '') ? ', ' . $mx_user_online_link : $mx_user_online_link;
						}
					}

					$prev_user_id = $row['user_id'];
				}
				else
				{
					// Skip multiple sessions for one user
					if ($row['session_ip'] != $prev_session_ip)
					{
						$guests_online++;
					}
				}

				$prev_session_ip = $row['session_ip'];
			}
			$db->sql_freeresult($result);

			if (!$online_userlist)
			{
				$online_userlist = $mx_user->lang['NO_ONLINE_USERS'];
			}

			if (empty($_REQUEST['f']))
			{
				$online_userlist = $mx_user->lang['REGISTERED_USERS'] . ' ' . $online_userlist;
			}
			else
			{
				$l_online = ($guests_online == 1) ? $mx_user->lang['BROWSING_FORUM_GUEST'] : $mx_user->lang['BROWSING_FORUM_GUESTS'];
				$online_userlist = sprintf($l_online, $online_userlist, $guests_online);
			}

			$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;

			if ($total_online_users > $board_config['record_online_users'])
			{
				self::set_config('record_online_users', $total_online_users, true);
				self::set_config('record_online_date', time(), true);
			}

			// Build online listing
			$vars_online = array(
				'ONLINE'	=> array('total_online_users', 'l_t_user_s'),
				'REG'		=> array('logged_visible_online', 'l_r_user_s'),
				'HIDDEN'	=> array('logged_hidden_online', 'l_h_user_s'),
				'GUEST'		=> array('guests_online', 'l_g_user_s')
			);

			foreach ($vars_online as $l_prefix => $var_ary)
			{
				switch (${$var_ary[0]})
				{
					case 0:
						${$var_ary[1]} = $mx_user->lang[$l_prefix . '_USERS_ZERO_TOTAL'];
					break;

					case 1:
						${$var_ary[1]} = $mx_user->lang[$l_prefix . '_USER_TOTAL'];
					break;

					default:
						${$var_ary[1]} = $mx_user->lang[$l_prefix . '_USERS_TOTAL'];
					break;
				}
			}
			unset($vars_online);

			$l_online_users = sprintf($l_t_user_s, $total_online_users);
			$l_online_users .= sprintf($l_r_user_s, $logged_visible_online);
			$l_online_users .= sprintf($l_h_user_s, $logged_hidden_online);
			$l_online_users .= sprintf($l_g_user_s, $guests_online);

			$l_online_record = sprintf($mx_user->lang['RECORD_ONLINE_USERS'], $board_config['record_online_users'], $mx_user->format_date($board_config['record_online_date']));

			$l_online_time = ($board_config['load_online_time'] == 1) ? 'VIEW_ONLINE_TIME' : 'VIEW_ONLINE_TIMES';
			$l_online_time = sprintf($mx_user->lang[$l_online_time], $board_config['load_online_time']);
		}
		else
		{
			$l_online_time = '';
		}

		$l_privmsgs_text = $l_privmsgs_text_unread = '';
		$s_privmsg_new = false;

		// Obtain number of new private messages if user is logged in
		if (isset($mx_user->data['is_registered']) && $mx_user->data['is_registered'])
		{
			if ($mx_user->data['user_new_privmsg'])
			{
				$l_message_new = ($mx_user->data['user_new_privmsg'] == 1) ? $mx_user->lang['NEW_PM'] : $mx_user->lang['NEW_PMS'];
				$l_privmsgs_text = sprintf($l_message_new, $mx_user->data['user_new_privmsg']);

				if (!$mx_user->data['user_last_privmsg'] || $mx_user->data['user_last_privmsg'] > $mx_user->data['session_last_visit'])
				{
					$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_last_privmsg = ' . $mx_user->data['session_last_visit'] . '
						WHERE user_id = ' . $mx_user->data['user_id'];
					$db->sql_query($sql);

					$s_privmsg_new = true;
				}
				else
				{
					$s_privmsg_new = false;
				}
			}
			else
			{
				$l_privmsgs_text = $mx_user->lang['NO_NEW_PM'];
				$s_privmsg_new = false;
			}

			$l_privmsgs_text_unread = '';

			if ($mx_user->data['user_unread_privmsg'] && $mx_user->data['user_unread_privmsg'] != $mx_user->data['user_new_privmsg'])
			{
				$l_message_unread = ($mx_user->data['user_unread_privmsg'] == 1) ? $mx_user->lang['UNREAD_PM'] : $mx_user->lang['UNREAD_PMS'];
				$l_privmsgs_text_unread = sprintf($l_message_unread, $mx_user->data['user_unread_privmsg']);
			}
		}

		// Which timezone?
		$tz = ($mx_user->data['user_id'] != ANONYMOUS) ? strval(doubleval($mx_user->data['user_timezone'])) : strval(doubleval($board_config['board_timezone']));
		$s_hidden_string_fields = array();
		$query_string = '';

		if (!empty($mx_user->page['query_string']))
		{
			$query_string_array = explode('&', $mx_user->page['query_string']);
			// don't parse actions again - so just post again the main variables
			// you have to add the variables for calendar, photo gallery, newsletters, and so on
			// unsubmitted data will be lost - I think it's okay - at least it's better like e.g. double posts
			// not needed for ACP
			$keys_array = array('sid', 's', 'mode', 'i', 'folder', 'search_id', 'u', 'f', 't', 'p');
			foreach ($query_string_array as $url_param)
			{
				$url_param = explode('=', $url_param, 2);
				if (in_array($url_param[0], $keys_array))
				{
					$s_hidden_string_fields[$url_param[0]] = $url_param[1];
					$query_string .= '&amp;' . $url_param[0] . '=' . $url_param[1];
				}
			}
		}
		
		// The following assigns all _common_ variables that may be used at any point in a template.
		$template->assign_vars(array(
			'SITENAME'						=> $board_config['sitename'],
			'SITE_DESCRIPTION'				=> $board_config['site_desc'],
			'PAGE_TITLE'					=> $page_title,
			'SCRIPT_NAME'					=> str_replace('.' . $phpEx, '', $mx_user->page['page_name']),
			'LAST_VISIT_DATE'				=> sprintf($mx_user->lang['YOU_LAST_VISIT'], $s_last_visit),
			'LAST_VISIT_YOU'				=> $s_last_visit,
			'CURRENT_TIME'					=> sprintf($mx_user->lang['CURRENT_TIME'], $mx_user->format_date(time(), false, true)),
			'TOTAL_USERS_ONLINE'			=> $l_online_users,
			'LOGGED_IN_USER_LIST'			=> $online_userlist,
			'RECORD_USERS'					=> $l_online_record,
			'PRIVATE_MESSAGE_INFO'			=> $l_privmsgs_text,
			'PRIVATE_MESSAGE_INFO_UNREAD'	=> $l_privmsgs_text_unread,

			'S_USER_NEW_PRIVMSG'			=> $mx_user->data['user_new_privmsg'],
			'S_USER_UNREAD_PRIVMSG'			=> $mx_user->data['user_unread_privmsg'],
			'S_USER_NEW'					=> $mx_user->data['user_new'],

			'SID'				=> $SID,
			'_SID'				=> $_SID,
			'SESSION_ID'		=> $mx_user->session_id,
			'ROOT_PATH'			=> $phpbb_root_path,
			'BOARD_URL'			=> $board_url,

			'L_LOGIN_LOGOUT'	=> $l_login_logout,
			'L_INDEX'			=> $mx_user->lang['FORUM_INDEX'],
			'L_ONLINE_EXPLAIN'	=> $l_online_time,

			'U_PRIVATEMSGS'			=> mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=pm&amp;folder=inbox'),
			'U_RETURN_INBOX'		=> mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=pm&amp;folder=inbox'),
			'U_POPUP_PM'			=> mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=pm&amp;mode=popup'),
			'U_MEMBERLIST'			=> mx3_append_sid("{$phpbb_root_path}memberlist.$phpEx"),
			'U_VIEWONLINE'			=> ($phpbb_auth->acl_gets('u_viewprofile', 'a_user', 'a_useradd', 'a_userdel')) ? mx3_append_sid("{$phpbb_root_path}viewonline.$phpEx") : '',
			'U_LOGIN_LOGOUT'		=> $u_login_logout,
			'U_INDEX'				=> mx3_append_sid("{$phpbb_root_path}index.$phpEx"),
			'U_SEARCH'				=> mx3_append_sid("{$phpbb_root_path}search.$phpEx"),
			'U_REGISTER'			=> mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=register'),
			'U_PROFILE'				=> mx3_append_sid("{$phpbb_root_path}ucp.$phpEx"),
			'U_MODCP'				=> mx3_append_sid("{$phpbb_root_path}mcp.$phpEx", false, true, $mx_user->session_id),
			'U_FAQ'					=> mx3_append_sid("{$phpbb_root_path}faq.$phpEx"),
			'U_SEARCH_SELF'			=> mx3_append_sid("{$phpbb_root_path}search.$phpEx", 'search_id=egosearch'),
			'U_SEARCH_NEW'			=> mx3_append_sid("{$phpbb_root_path}search.$phpEx", 'search_id=newposts'),
			'U_SEARCH_UNANSWERED'	=> mx3_append_sid("{$phpbb_root_path}search.$phpEx", 'search_id=unanswered'),
			'U_SEARCH_UNREAD'		=> mx3_append_sid("{$phpbb_root_path}search.$phpEx", 'search_id=unreadposts'),
			'U_SEARCH_ACTIVE_TOPICS'=> mx3_append_sid("{$phpbb_root_path}search.$phpEx", 'search_id=active_topics'),
			'U_DELETE_COOKIES'		=> mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=delete_cookies'),
			'U_TEAM'				=> ($mx_user->data['user_id'] != ANONYMOUS && !$phpbb_auth->acl_get('u_viewprofile')) ? '' : mx3_append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=leaders'),
			'U_TERMS_USE'			=> mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=terms'),
			'U_PRIVACY'				=> mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=privacy'),
			'U_RESTORE_PERMISSIONS'	=> ($mx_user->data['user_perm_from'] && $phpbb_auth->acl_get('a_switchperm')) ? mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=restore_perm') : '',
			'U_FEED'				=> generate_board_url() . "/feed.$phpEx",

			'S_USER_LOGGED_IN'		=> ($mx_user->data['user_id'] != ANONYMOUS) ? true : false,
			'S_AUTOLOGIN_ENABLED'	=> ($board_config['allow_autologin']) ? true : false,
			'S_BOARD_DISABLED'		=> ($board_config['board_disable']) ? true : false,
			'S_REGISTERED_USER'		=> (!empty($mx_user->data['is_registered'])) ? true : false,
			'S_IS_BOT'				=> (!empty($mx_user->data['is_bot'])) ? true : false,
			'S_USER_PM_POPUP'		=> $mx_user->optionget('popuppm'),
			'S_USER_LANG'			=> $mx_user_lang,
			'S_USER_BROWSER'		=> (isset($mx_user->data['session_browser'])) ? $mx_user->data['session_browser'] : $mx_user->lang['UNKNOWN_BROWSER'],
			'S_USERNAME'			=> $mx_user->data['username'],
			'S_CONTENT_DIRECTION'	=> $mx_user->lang['DIRECTION'],
			'S_CONTENT_FLOW_BEGIN'	=> ($mx_user->lang['DIRECTION'] == 'ltr') ? 'left' : 'right',
			'S_CONTENT_FLOW_END'	=> ($mx_user->lang['DIRECTION'] == 'ltr') ? 'right' : 'left',
			'S_CONTENT_ENCODING'	=> 'UTF-8',
			'S_TIMEZONE'			=> ($mx_user->data['user_dst'] || ($mx_user->data['user_id'] == ANONYMOUS && $board_config['board_dst'])) ? sprintf($mx_user->lang['ALL_TIMES'], $mx_user->lang['tz'][$tz], $mx_user->lang['tz']['dst']) : sprintf($mx_user->lang['ALL_TIMES'], $mx_user->lang['tz'][$tz], ''),
			'S_DISPLAY_ONLINE_LIST'	=> ($l_online_time) ? 1 : 0,
			'S_DISPLAY_SEARCH'		=> (!$board_config['load_search']) ? 0 : (isset($phpbb_auth) ? ($phpbb_auth->acl_get('u_search') && $phpbb_auth->acl_getf_global('f_search')) : 1),
			'S_DISPLAY_PM'			=> ($board_config['allow_privmsg'] && !empty($mx_user->data['is_registered']) && ($phpbb_auth->acl_get('u_readpm') || $phpbb_auth->acl_get('u_sendpm'))) ? true : false,
			'S_DISPLAY_MEMBERLIST'	=> (isset($phpbb_auth)) ? $phpbb_auth->acl_get('u_viewprofile') : 0,
			'S_NEW_PM'				=> ($s_privmsg_new) ? 1 : 0,
			'S_REGISTER_ENABLED'	=> ($board_config['require_activation'] != USER_ACTIVATION_DISABLE) ? true : false,
			'S_FORUM_ID'			=> $forum_id,
			'S_TOPIC_ID'			=> $topic_id,
			
			'S_SESSION_LANG_SELECT'	=> ($board_config['lang_select_enable']) ? session_lang_select($mx_user->data['user_lang']) : false,
			'S_SESSION_LANG_CLICK'	=> ($board_config['lang_click_enable']) ? session_lang_click($mx_user->data['user_lang'], $query_string) : false,
			'S_HIDDEN_STRING_FIELDS'	=> build_hidden_fields($s_hidden_string_fields),
			
			'S_LOGIN_ACTION'		=> ((!defined('ADMIN_START')) ? mx3_append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=login') : mx3_append_sid("index.$phpEx", false, true, $mx_user->session_id)),
			'S_LOGIN_REDIRECT'		=> build_hidden_fields(array('redirect' => build_url())),

			'S_ENABLE_FEEDS'			=> ($board_config['feed_enable']) ? true : false,
			'S_ENABLE_FEEDS_OVERALL'	=> ($board_config['feed_overall']) ? true : false,
			'S_ENABLE_FEEDS_FORUMS'		=> ($board_config['feed_overall_forums']) ? true : false,
			'S_ENABLE_FEEDS_TOPICS'		=> ($board_config['feed_topics_new']) ? true : false,
			'S_ENABLE_FEEDS_TOPICS_ACTIVE'	=> ($board_config['feed_topics_active']) ? true : false,
			'S_ENABLE_FEEDS_NEWS'		=> ($s_feed_news) ? true : false,

			'S_LOAD_UNREADS'			=> ($board_config['load_unreads_search'] && ($board_config['load_anon_lastread'] || $mx_user->data['is_registered'])) ? true : false,

			'T_THEME_PATH'			=> "{$web_path}styles/" . $mx_user->theme['theme_path'] . '/theme',
			'T_TEMPLATE_PATH'		=> "{$web_path}styles/" . $mx_user->theme['template_path'] . '/template',
			'T_SUPER_TEMPLATE_PATH'	=> (isset($mx_user->theme['template_inherit_path']) && $mx_user->theme['template_inherit_path']) ? "{$web_path}styles/" . $mx_user->theme['template_inherit_path'] . '/template' : "{$web_path}styles/" . $mx_user->theme['template_path'] . '/template',
			'T_IMAGESET_PATH'		=> "{$web_path}styles/" . $mx_user->theme['imageset_path'] . '/imageset',
			'T_IMAGESET_LANG_PATH'	=> "{$web_path}styles/" . $mx_user->theme['imageset_path'] . '/imageset/' . $mx_user->data['user_lang'],
			'T_IMAGES_PATH'			=> "{$web_path}images/",
			'T_SMILIES_PATH'		=> "{$web_path}{$board_config['smilies_path']}/",
			'T_AVATAR_PATH'			=> "{$web_path}{$board_config['avatar_path']}/",
			'T_AVATAR_GALLERY_PATH'	=> "{$web_path}{$board_config['avatar_gallery_path']}/",
			'T_ICONS_PATH'			=> "{$web_path}{$board_config['icons_path']}/",
			'T_RANKS_PATH'			=> "{$web_path}{$board_config['ranks_path']}/",
			'T_UPLOAD_PATH'			=> "{$web_path}{$board_config['upload_path']}/",
			'T_STYLESHEET_LINK'		=> (!$mx_user->theme['theme_storedb']) ? "{$web_path}styles/" . $mx_user->theme['theme_path'] . '/theme/stylesheet.css' : mx3_append_sid("{$phpbb_root_path}style.$phpEx", 'id=' . $mx_user->theme['style_id'] . '&amp;lang=' . $mx_user->data['user_lang']),
			'T_STYLESHEET_NAME'		=> $mx_user->theme['theme_name'],

			'T_THEME_NAME'			=> $mx_user->theme['theme_path'],
			'T_TEMPLATE_NAME'		=> $mx_user->theme['template_path'],
			'T_SUPER_TEMPLATE_NAME'	=> (isset($mx_user->theme['template_inherit_path']) && $mx_user->theme['template_inherit_path']) ? $mx_user->theme['template_inherit_path'] : $mx_user->theme['template_path'],
			'T_IMAGESET_NAME'		=> $mx_user->theme['imageset_path'],
			'T_IMAGESET_LANG_NAME'	=> $mx_user->data['user_lang'],
			'T_IMAGES'				=> 'images',
			'T_SMILIES'				=> $board_config['smilies_path'],
			'T_AVATAR'				=> $board_config['avatar_path'],
			'T_AVATAR_GALLERY'		=> $board_config['avatar_gallery_path'],
			'T_ICONS'				=> $board_config['icons_path'],
			'T_RANKS'				=> $board_config['ranks_path'],
			'T_UPLOAD'				=> $board_config['upload_path'],

			'SITE_LOGO_IMG'			=> $mx_user->img('site_logo'),

			'A_COOKIE_SETTINGS'		=> addslashes('; path=' . $board_config['cookie_path'] . ((!$board_config['cookie_domain'] || $board_config['cookie_domain'] == 'localhost' || $board_config['cookie_domain'] == '127.0.0.1') ? '' : '; domain=' . $board_config['cookie_domain']) . ((!$board_config['cookie_secure']) ? '' : '; secure')),
		));

		// application/xhtml+xml not used because of IE
		//header('Content-type: text/html; charset=UTF-8');

		//header('Cache-Control: private, no-cache="set-cookie"');
		//header('Expires: 0');
		//header('Pragma: no-cache');

		return;
	}
	*/

	/**
	* Generate page footer
	function page_footer($run_cron = true)
	{
		global $db, $board_config, $template, $mx_user, $phpbb_auth, $mx_cache, $starttime, $phpbb_root_path, $phpEx;

		// Output page creation time
		if (defined('DEBUG'))
		{
			$mtime = explode(' ', microtime());
			$totaltime = $mtime[0] + $mtime[1] - $starttime;

			if (!empty($_REQUEST['explain']) && $phpbb_auth->acl_get('a_') && defined('DEBUG_EXTRA') && method_exists($db, 'sql_report'))
			{
				$db->sql_report('display');
			}

			$debug_output = sprintf('Time : %.3fs | ' . $db->sql_num_queries() . ' Queries | GZIP : ' . (($board_config['gzip_compress']) ? 'On' : 'Off') . (($mx_user->load) ? ' | Load : ' . $mx_user->load : ''), $totaltime);

			if ($phpbb_auth->acl_get('a_') && defined('DEBUG_EXTRA'))
			{
				if (function_exists('memory_get_usage'))
				{
					if ($memory_usage = memory_get_usage())
					{
						global $base_memory_usage;
						$memory_usage -= $base_memory_usage;
						$memory_usage = ($memory_usage >= 1048576) ? round((round($memory_usage / 1048576 * 100) / 100), 2) . ' ' . $mx_user->lang['MB'] : (($memory_usage >= 1024) ? round((round($memory_usage / 1024 * 100) / 100), 2) . ' ' . $mx_user->lang['KB'] : $memory_usage . ' ' . $mx_user->lang['BYTES']);

						$debug_output .= ' | Memory Usage: ' . $memory_usage;
					}
				}

				$debug_output .= ' | <a href="' . build_url() . '&amp;explain=1">Explain</a>';
			}
		}

		$template->assign_vars(array(
			'DEBUG_OUTPUT'			=> (defined('DEBUG')) ? $debug_output : '',
			'TRANSLATION_INFO'		=> (!empty($mx_user->lang['TRANSLATION_INFO'])) ? $mx_user->lang['TRANSLATION_INFO'] : '',

			'U_ACP' => ( $mx_user->data['is_registered']) ? mx_mx3_append_sid("{$phpbb_root_path}adm/index.$phpEx", false, true, $mx_user->session_id) : ''
			)
		);

		// Call cron-type script
		if (!defined('IN_CRON') && $run_cron && !$board_config['board_disable'])
		{
			$cron_type = '';

			if (time() - $board_config['queue_interval'] > $board_config['last_queue_run'] && !defined('IN_ADMIN') && file_exists($phpbb_root_path . 'cache/queue.' . $phpEx))
			{
				// Process email queue
				$cron_type = 'queue';
			}
			else if (method_exists($mx_cache, 'tidy') && time() - $board_config['cache_gc'] > $board_config['cache_last_gc'])
			{
				// Tidy the cache
				$cron_type = 'tidy_cache';
			}
			else if (time() - $board_config['warnings_gc'] > $board_config['warnings_last_gc'])
			{
				$cron_type = 'tidy_warnings';
			}
			else if (time() - $board_config['database_gc'] > $board_config['database_last_gc'])
			{
				// Tidy the database
				$cron_type = 'tidy_database';
			}
			else if (time() - $board_config['search_gc'] > $board_config['search_last_gc'])
			{
				// Tidy the search
				$cron_type = 'tidy_search';
			}
			else if (time() - $board_config['session_gc'] > $board_config['session_last_gc'])
			{
				$cron_type = 'tidy_sessions';
			}

			if ($cron_type)
			{
				$template->assign_var('RUN_CRON_TASK', '<img src="' . mx_mx3_append_sid($phpbb_root_path . 'cron.' . $phpEx, 'cron_type=' . $cron_type) . '" width="1" height="1" alt="cron" />');
			}
		}

		$template->display('body');

		self::garbage_collection();

		exit;
	}
	*/

	/**
	* custom version of nl2br which takes custom BBCodes into account
	*/
	public static function bbcode_nl2br($text)
	{
		// custom BBCodes might contain carriage returns so they
		// are not converted into <br /> so now revert that
		$text = str_replace(array("\n", "\r"), array('<br />', "\n"), $text);
		return $text;
	}

	/**
	* Closing the cache object and the database
	* Cool function name, eh? We might want to add operations to it later
	*/
	public static function garbage_collection($unload_cache = true, $close_db = true)
	{
		global $mx_cache, $db;

		// Unload cache, must be done before the DB connection if closed
		if (!empty($cache) && ($unload_cache))
		{
			$mx_cache->unload();
		}

		// Close our DB connection.
		if (!empty($db) && ($close_db))
		{
			$db->sql_close();
		}
	}

	/**
	* Handler for exit calls in phpBB.
	* This function supports hooks.
	*
	* Note: This function is called after the template has been outputted.
	*/
	public static function exit_handler()
	{
		global $phpbb_hook;

		if (!empty($phpbb_hook) && $phpbb_hook->call_hook(__FUNCTION__))
		{
			if ($phpbb_hook->hook_return(__FUNCTION__))
			{
				return $phpbb_hook->hook_return_result(__FUNCTION__);
			}
		}

		exit;
	}

	/**
	* Handler for init calls in phpBB. This function is called in user::setup();
	* This function supports hooks.
	*/
	public static function phpbb_user_session_handler()
	{
		global $phpbb_hook;

		if (!empty($phpbb_hook) && $phpbb_hook->call_hook(__FUNCTION__))
		{
			if ($phpbb_hook->hook_return(__FUNCTION__))
			{
				return $phpbb_hook->hook_return_result(__FUNCTION__);
			}
		}

		return;
	}
}

/**
* @package phpBB3
*/
class bitfield
{
	var $data;

	function __construct($bitfield = '')
	{
		$this->data = base64_decode($bitfield);
	}

	/**
	*/
	function get($n)
	{
		// Get the ($n / 8)th char
		$byte = $n >> 3;

		if (strlen($this->data) >= $byte + 1)
		{
			$c = $this->data[$byte];

			// Lookup the ($n % 8)th bit of the byte
			$bit = 7 - ($n & 7);
			return (bool) (ord($c) & (1 << $bit));
		}
		else
		{
			return false;
		}
	}

	function set($n)
	{
		$byte = $n >> 3;
		$bit = 7 - ($n & 7);

		if (strlen($this->data) >= $byte + 1)
		{
			$this->data[$byte] = $this->data[$byte] | chr(1 << $bit);
		}
		else
		{
			$this->data .= str_repeat("\0", $byte - strlen($this->data));
			$this->data .= chr(1 << $bit);
		}
	}

	function clear($n)
	{
		$byte = $n >> 3;

		if (strlen($this->data) >= $byte + 1)
		{
			$bit = 7 - ($n & 7);
			$this->data[$byte] = $this->data[$byte] &~ chr(1 << $bit);
		}
	}

	function get_blob()
	{
		return $this->data;
	}

	function get_base64()
	{
		return base64_encode($this->data);
	}

	function get_bin()
	{
		$bin = '';
		$len = strlen($this->data);

		for ($i = 0; $i < $len; ++$i)
		{
			$bin .= str_pad(decbin(ord($this->data[$i])), 8, '0', STR_PAD_LEFT);
		}

		return $bin;
	}

	function get_all_set()
	{
		return array_keys(array_filter(str_split($this->get_bin())));
	}

	function merge($bitfield)
	{
		$this->data = $this->data | $bitfield->get_blob();
	}
}

//
//This file is sometime included for build_hidden_fields() function 
//and so we keep it here with this check for new for phpBB2 Tablet-PC and SmartPhone Edition Backend
//
if (!function_exists('_build_hidden_fields'))
{
	/**
	* Little helper for the build_hidden_fields function
	*/
	function _build_hidden_fields3($key, $value, $specialchar, $stripslashes)
	{
		$hidden_fields = '';

		if (!is_array($value))
		{
			$value = ($stripslashes) ? stripslashes($value) : $value;
			$value = ($specialchar) ? htmlspecialchars($value, ENT_COMPAT, 'UTF-8') : $value;

			$hidden_fields .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
		}
		else
		{
			foreach ($value as $_key => $_value)
			{
				$_key = ($stripslashes) ? stripslashes($_key) : $_key;
				$_key = ($specialchar) ? htmlspecialchars($_key, ENT_COMPAT, 'UTF-8') : $_key;

				$hidden_fields .= _build_hidden_fields($key . '[' . $_key . ']', $_value, $specialchar, $stripslashes);
			}
		}

		return $hidden_fields;
	}

}

?>
