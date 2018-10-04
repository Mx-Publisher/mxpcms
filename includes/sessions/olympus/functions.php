<?php
/**
*
* @package Auth
* @version $Id: functions.php,v 1.1 2014/07/07 20:38:12 orynider Exp $
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
function mx_get_username_string($mode, $user_id, $username, $username_colour = '', $guest_username = false, $custom_profile_url = false)
{
	global $phpbb_root_path, $phpEx, $mx_user, $phpbb_auth;

	$profile_url = '';
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
			$profile_url = ($custom_profile_url !== false) ? $custom_profile_url : mx3_append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile');
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
?>