<?php
/**
*
* @package Auth
* @version $Id: functions.php,v 2.0 2013/06/28 15:33:47 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/**
 * Get 'Poll Select' html select list.
 *
 * Quick and handy function to generate a dropdown select list for current phpbb polls
 *
 * @param string $default_poll select idfield = id
 * @param string $select_name select name
 * @return string (html)
 */
function poll_select($default_poll, $select_name = 'Poll_Topic_id')
{
	global $db;

	$style_select = '<select name="' . $select_name . '">';
	$selected = ( $default_poll == 0 ) ? ' selected="selected"' : '';
	$style_select .= '<option value="0"' . $selected . '>' . 'The most recent' . "</option>\n";

	$sql = "SELECT topic_id, vote_text
		FROM " . VOTE_DESC_TABLE . "
		ORDER BY vote_text, topic_id";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't query polls table", '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row['topic_id'] == $default_poll ) ? ' selected="selected"' : '';
		$style_select .= '<option value="' . $row['topic_id'] . '"' . $selected . '>' . $row['vote_text'] . "</option>\n";
	}
	$style_select .= '</select>';

	unset($row);
	$db->sql_freeresult($result);
	return $style_select;
}

/**
* Olympus Parse cfg file
*/
function mx_parse_cfg_file($filename, $lines = false)
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
function mx_add_log()
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
* Generate sort selection fields
*/
function mx_gen_sort_selects(&$limit_days, &$sort_by_text, &$sort_days, &$sort_key, &$sort_dir, &$s_limit_days, &$s_sort_key, &$s_sort_dir, &$u_sort_param)
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
function mx_get_username_string($mode, $user_id, $username = false, $user_colour = false, $guest_username = false, $custom_profile_url = false)
{
	static $_profile_cache;
	global $phpbb_dispatcher;

	// We cache some common variables we need within this function
	if (empty($_profile_cache))
	{
		global $phpbb_root_path, $phpEx;

		$_profile_cache['base_url'] = mx_append_sid("{$phpbb_root_path}profile.$phpEx", 'mode=viewprofile&amp;u={USER_ID}');
		$_profile_cache['tpl_noprofile'] = '<span class="username">{USERNAME}</span>';
		$_profile_cache['tpl_noprofile_colour'] = '<span style="color: {USERNAME_COLOUR};" class="username-coloured">{USERNAME}</span>';
		$_profile_cache['tpl_profile'] = '<a href="{PROFILE_URL}" class="username">{USERNAME}</a>';
		$_profile_cache['tpl_profile_colour'] = '<a href="{PROFILE_URL}" style="color: {USERNAME_COLOUR};" class="username-coloured">{USERNAME}</a>';
	}	
	
	global $mx_user, $lang, $phpEx;

	$lang['Guest'] = !$guest_username ? $lang['Guest'] : $guest_username;

	$this_userdata = mx_get_userdata($user_id, false);
	$topic_poster_style = 'style="font-weight : bold;"';

	$username = ($username) ? $username : $this_userdata['username'];
	
	if ($this_userdata['user_level'] == ADMIN)
	{
		$user_colour = ($mx_user->theme['fontcolor3']) ? $mx_user->theme['fontcolor3'] : $user_colour;		
		$user_style = 'style="color:#' . $user_colour . '; font-weight : bold;"';		
	}
	elseif ($this_userdata['user_level'] == MOD)
	{
		$user_colour = ($mx_user->theme['fontcolor2']) ? $mx_user->theme['fontcolor2'] : $user_colour;			
		$user_style = 'style="color:#' . $user_colour . '; font-weight : bold;"';
	}
	else
	{
		$user_colour = ($mx_user->theme['fontcolor1']) ? $mx_user->theme['fontcolor1'] : $user_colour;			
		$user_style = 'style="color:#' . $user_colour . '; font-weight : bold;"';		
	}
	// print_r(substr($user_colour, 0, 3) . substr($user_colour, 3, 2));
	// Only show the link if not anonymous
	if ($user_id != ANONYMOUS)
	{
		$profile_url = mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;u=" . (int) $user_id);
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
			// Build correct username colour
			$username_colour = ($user_colour) ? '#' . $user_colour : '';

			// Return colour
			if ($mode == 'colour')
			{
				$username_string = $username_colour;
			}
			$username_string = str_replace(array('{PROFILE_URL}', '{USERNAME_COLOUR}', '{USERNAME}'), array($profile_url, $username_colour, $username), (!$username_colour) ? $_profile_cache['tpl_profile'] : $_profile_cache['tpl_profile_colour']);
				
		break;
		
		case 'profile_url':
			// Return colour
			if ($mode == 'profile_url')
			{
				$username_string = $profile_url;
			}			
		break;
		
		case 'username':
			// Return colour
			if ($mode == 'colour')
			{
				$username_string = $username;
			}			
		break;
		
		case 'full':
		case 'no_profile':
		case 'colour':
			// Build correct username colour
			$username_colour = ($user_colour) ? '#' . $user_colour : '';

			// Return colour
			if ($mode == 'colour')
			{
				$username_string = $username_colour;
			}
			else
			{
				$username_string = str_replace(array('{USERNAME_COLOUR}', '{USERNAME}'), array($username_colour, $username), (!$username_colour) ? $_profile_cache['tpl_noprofile'] : $_profile_cache['tpl_noprofile_colour']);			
			}				

		break;
	}			
	return $username_string;	
}


/**
* Generate board url (example: http://www.example.com/phpBB)
*
* @param bool $without_script_path if set to true the script path gets not appended (example: http://www.example.com)
*
* @return string the generated board url
*/
function mx_generate_board_url($without_script_path = false)
{
	global $board_config, $userdata, $mx_user;
	
	$server_name = !empty($board_config['server_name']) ? preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['server_name'])) : 'localhost';
	$server_protocol = ($board_config['cookie_secure'] ) ? 'https://' : 'http://';
	$server_port = (($board_config['server_port']) && ($board_config['server_port'] <> 80)) ? ':' . trim($board_config['server_port']) . '/' : ((!empty($_SERVER['SERVER_PORT'])) ? (int) $_SERVER['SERVER_PORT'] : (int) getenv('SERVER_PORT'));
	$script_name_phpbb = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])) . '/';		
	$server_url = $server_protocol . str_replace("//", "/", $server_name . $server_port . $server_name . '/'); //On some server the slash is not added and this trick will fix it	

	// Forcing server vars is the only way to specify/override the protocol
	if (!$server_name)
	{
		$server_protocol = ($board_config['server_protocol']) ? $board_config['server_protocol'] : (($board_config['cookie_secure']) ? 'https://' : 'http://');
		$server_name = $board_config['server_name'];
		$server_port = (int) $board_config['server_port'];
		$script_path = $board_config['script_path'];

		$url = $server_protocol . $server_name;
		$cookie_secure = $board_config['cookie_secure'];
	}
	else
	{
		// Do not rely on cookie_secure, users seem to think that it means a secured cookie instead of an encrypted connection
		$cookie_secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1 : 0;
		$url = (($cookie_secure) ? 'https://' : 'http://') . $server_name;

		$script_path = $url;
	}

	if ($server_port && (($cookie_secure && $server_port <> 443) || (!$cookie_secure && $server_port <> 80)))
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

?>