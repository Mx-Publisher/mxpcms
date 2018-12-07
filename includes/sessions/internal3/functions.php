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
if (!function_exists('mx_get_username_string'))
{
function mx_get_username_string($mode, $user_id, $username = false, $user_colour = false, $guest_username = false, $custom_profile_url = false)
{
	global $mx_user, $lang, $phpEx;

	$lang['Guest'] = !$guest_username ? $lang['Guest'] : $guest_username;

	$this_userdata = mx_get_userdata($user_id, false);
	$topic_poster_style = 'style="font-weight : bold;"';

	$username = ($username) ? $username : $this_userdata['username'];
	
	if ($this_userdata['user_level'] == ADMIN)
	{
		$user_colour = isset($mx_user->theme['fontcolor3']) ? $mx_user->theme['fontcolor3'] : $user_colour;		
		$user_style = 'style="color:#' . $user_colour . '; font-weight : bold;"';
	}
	else if ($this_userdata['user_level'] == MOD)
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
		case 'profile_url':		
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
		case 'no_profile':
		default:
			return $full_url;
		break;
	}
}
}
?>