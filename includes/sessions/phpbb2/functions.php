<?php
/**
*
* @package Auth
* @version $Id: functions.php,v 1.2 2013/06/28 15:33:47 orynider Exp $
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

		$_profile_cache['base_url'] = append_sid("{$phpbb_root_path}profile.$phpEx", 'mode=viewprofile&amp;u={USER_ID}');
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

?>