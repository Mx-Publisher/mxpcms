<?php
/**
*
* @package Auth
* @version $Id: auth.php,v 1.4 2013/06/28 15:33:47 orynider Exp $
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
* Permission/Auth class for phpBB2 forums
* @package MX-Publisher
*/
class phpbb_auth_base
{
	function auth($type, $forum_id, $userdata, $f_access = '')
	{
		global $db, $lang;

		switch( $type )
		{
			case AUTH_ALL:
				$a_sql = 'a.auth_view, a.auth_read, a.auth_post, a.auth_reply, a.auth_edit, a.auth_delete, a.auth_sticky, a.auth_announce, a.auth_vote, a.auth_pollcreate';
				$auth_fields = array('auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_delete', 'auth_sticky', 'auth_announce', 'auth_vote', 'auth_pollcreate');
				break;

			case AUTH_VIEW:
				$a_sql = 'a.auth_view';
				$auth_fields = array('auth_view');
				break;

			case AUTH_READ:
				$a_sql = 'a.auth_read';
				$auth_fields = array('auth_read');
				break;
			case AUTH_POST:
				$a_sql = 'a.auth_post';
				$auth_fields = array('auth_post');
				break;
			case AUTH_REPLY:
				$a_sql = 'a.auth_reply';
				$auth_fields = array('auth_reply');
				break;
			case AUTH_EDIT:
				$a_sql = 'a.auth_edit';
				$auth_fields = array('auth_edit');
				break;
			case AUTH_DELETE:
				$a_sql = 'a.auth_delete';
				$auth_fields = array('auth_delete');
				break;

			case AUTH_ANNOUNCE:
				$a_sql = 'a.auth_announce';
				$auth_fields = array('auth_announce');
				break;
			case AUTH_STICKY:
				$a_sql = 'a.auth_sticky';
				$auth_fields = array('auth_sticky');
				break;

			case AUTH_POLLCREATE:
				$a_sql = 'a.auth_pollcreate';
				$auth_fields = array('auth_pollcreate');
				break;
			case AUTH_VOTE:
				$a_sql = 'a.auth_vote';
				$auth_fields = array('auth_vote');
				break;
			case AUTH_ATTACH:
				break;

			default:
				break;
		}

		//
		// If f_access has been passed, or auth is needed to return an array of forums
		// then we need to pull the auth information on the given forum (or all forums)
		//
		if ( empty($f_access) )
		{
			$forum_match_sql = ( $forum_id != AUTH_LIST_ALL ) ? "WHERE a.forum_id = $forum_id" : '';

			$sql = "SELECT a.forum_id, $a_sql
				FROM " . FORUMS_TABLE . " a
				$forum_match_sql";
			if ( !($result = $db->sql_query($sql)) )
			{
				//mx_message_die(GENERAL_ERROR, 'Failed obtaining forum access control lists', '', __LINE__, __FILE__, $sql);
			}

			$sql_fetchrow = ( $forum_id != AUTH_LIST_ALL ) ? 'sql_fetchrow' : 'sql_fetchrowset';

			if ( !($f_access = $db->$sql_fetchrow($result)) )
			{
				$db->sql_freeresult($result);
				return array();
			}
			$db->sql_freeresult($result);
		}

		//
		// If the user isn't logged on then all we need do is check if the forum
		// has the type set to ALL, if yes they are good to go, if not then they
		// are denied access
		//
		$u_access = array();
		if ( $userdata['session_logged_in'] )
		{
			$forum_match_sql = ( $forum_id != AUTH_LIST_ALL ) ? "AND a.forum_id = $forum_id" : '';

			$sql = "SELECT a.forum_id, $a_sql, a.auth_mod
				FROM " . AUTH_ACCESS_TABLE . " a, " . USER_GROUP_TABLE . " ug
				WHERE ug.user_id = ".$userdata['user_id']. "
					AND ug.user_pending = 0
					AND a.group_id = ug.group_id
					$forum_match_sql";
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Failed obtaining forum access control lists', '', __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				do
				{
					if ( $forum_id != AUTH_LIST_ALL)
					{
						$u_access[] = $row;
					}
					else
					{
						$u_access[$row['forum_id']][] = $row;
					}
				}
				while( $row = $db->sql_fetchrow($result) );
			}
			$db->sql_freeresult($result);
		}

		$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;

		$auth_user = array();
		for($i = 0; $i < count($auth_fields); $i++)
		{
			$key = $auth_fields[$i];

			//
			// If the user is logged on and the forum type is either ALL or REG then the user has access
			//
			// If the type if ACL, MOD or ADMIN then we need to see if the user has specific permissions
			// to do whatever it is they want to do ... to do this we pull relevant information for the
			// user (and any groups they belong to)
			//
			// Now we compare the users access level against the forums. We assume here that a moderator
			// and admin automatically have access to an ACL forum, similarly we assume admins meet an
			// auth requirement of MOD
			//
			if ( $forum_id != AUTH_LIST_ALL )
			{
				$value = $f_access[$key];

				switch( $value )
				{
					case AUTH_ALL:
						$auth_user[$key] = TRUE;
						$auth_user[$key . '_type'] = $lang['Auth_Anonymous_Users'];
						break;

					case AUTH_REG:
						$auth_user[$key] = ( $userdata['session_logged_in'] ) ? TRUE : 0;
						$auth_user[$key . '_type'] = $lang['Auth_Registered_Users'];
						break;

					case AUTH_ACL:
						$auth_user[$key] = ( $userdata['session_logged_in'] ) ? $this->auth_check_user(AUTH_ACL, $key, $u_access, $is_admin) : 0;
						$auth_user[$key . '_type'] = $lang['Auth_Users_granted_access'];
						break;

					case AUTH_MOD:
						$auth_user[$key] = ( $userdata['session_logged_in'] ) ? $this->auth_check_user(AUTH_MOD, 'auth_mod', $u_access, $is_admin) : 0;
						$auth_user[$key . '_type'] = $lang['Auth_Moderators'];
						break;

					case AUTH_ADMIN:
						$auth_user[$key] = $is_admin;
						$auth_user[$key . '_type'] = $lang['Auth_Administrators'];
						break;

					default:
						$auth_user[$key] = 0;
						break;
				}
			}
			else
			{
				for($k = 0; $k < count($f_access); $k++)
				{
					$value = $f_access[$k][$key];
					$f_forum_id = $f_access[$k]['forum_id'];
					$u_access[$f_forum_id] = isset($u_access[$f_forum_id]) ? $u_access[$f_forum_id] : array();

					switch( $value )
					{
						case AUTH_ALL:
							$auth_user[$f_forum_id][$key] = TRUE;
							$auth_user[$f_forum_id][$key . '_type'] = $lang['Auth_Anonymous_Users'];
							break;

						case AUTH_REG:
							$auth_user[$f_forum_id][$key] = ( $userdata['session_logged_in'] ) ? TRUE : 0;
							$auth_user[$f_forum_id][$key . '_type'] = $lang['Auth_Registered_Users'];
							break;

						case AUTH_ACL:
							$auth_user[$f_forum_id][$key] = ( $userdata['session_logged_in'] ) ? $this->auth_check_user(AUTH_ACL, $key, $u_access[$f_forum_id], $is_admin) : 0;
							$auth_user[$f_forum_id][$key . '_type'] = $lang['Auth_Users_granted_access'];
							break;

						case AUTH_MOD:
							$auth_user[$f_forum_id][$key] = ( $userdata['session_logged_in'] ) ? $this->auth_check_user(AUTH_MOD, 'auth_mod', $u_access[$f_forum_id], $is_admin) : 0;
							$auth_user[$f_forum_id][$key . '_type'] = $lang['Auth_Moderators'];
							break;

						case AUTH_ADMIN:
							$auth_user[$f_forum_id][$key] = $is_admin;
							$auth_user[$f_forum_id][$key . '_type'] = $lang['Auth_Administrators'];
							break;

						default:
							$auth_user[$f_forum_id][$key] = 0;
							break;
					}
				}
			}
		}

		//
		// Is user a moderator?
		//
		if ( $forum_id != AUTH_LIST_ALL )
		{
			$auth_user['auth_mod'] = ( $userdata['session_logged_in'] ) ? $this->auth_check_user(AUTH_MOD, 'auth_mod', $u_access, $is_admin) : 0;
		}
		else
		{
			for($k = 0; $k < count($f_access); $k++)
			{
				$f_forum_id = $f_access[$k]['forum_id'];
				$u_access[$f_forum_id] = isset($u_access[$f_forum_id]) ? $u_access[$f_forum_id] : array();

				$auth_user[$f_forum_id]['auth_mod'] = ( $userdata['session_logged_in'] ) ? $this->auth_check_user(AUTH_MOD, 'auth_mod', $u_access[$f_forum_id], $is_admin) : 0;
			}
		}

		return $auth_user;
	}

	function auth_check_user($type, $key, $u_access, $is_admin)
	{
		$auth_user = 0;

		if ( count($u_access) )
		{
			for($j = 0; $j < count($u_access); $j++)
			{
				$result = 0;
				switch($type)
				{
					case AUTH_ACL:
						$result = $u_access[$j][$key];

					case AUTH_MOD:
						$result = $result || $u_access[$j]['auth_mod'];

					case AUTH_ADMIN:
						$result = $result || $is_admin;
						break;
				}

				$auth_user = $auth_user || $result;
			}
		}
		else
		{
			$auth_user = $is_admin;
		}

		return $auth_user;
	}
}
?>