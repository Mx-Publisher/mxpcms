<?php
/**
*
* @package Style
* @version $Id: session.php,v 1.1 2014/05/18 06:26:59 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team & (C) 2001 The phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

/**
 * Modifications:
 *
 * Class wrapper
 * mx_dss_rand
 */

/**
* Session class
* @package MX-Publisher
*/
class session
{
	var $cookie_data = array();
	var $page = array();
	var $data = array();
	var $browser = '';
	var $forwarded_for = '';
	var $host = '';
	var $session_id = '';
	var $ip = '';
	var $load = 0;
	var $time_now = 0;
	var $update_session_page = true;

	var $lang = array();
	var $help = array();
	var $theme = array();
	var $date_format;
	var $timezone;
	var $dst;

	var $lang_name;
	var $lang_path;
	var $img_lang;
	var $img_array = array();

	/**
	 * Load sessions
	 * @access public
	 *
	 */
	function load()
	{
		global $portal_config;
		
		$this->data = $this->session_pagestart($this->user_ip, - ( MX_PORTAL_PAGES_OFFSET + $this->page_id ));
		
		// Simulate the user lang setting
		$this->data['user_lang'] = $portal_config['default_lang'];
		$this->data['user_dateformat'] = $portal_config['default_dateformat'];
		$this->data['user_timezone'] = $portal_config['board_timezone'];
		
		/*
		* Populate session_id
		*/
		$this->session_id = $this->data['session_id'];
	}

	//
	// Adds/updates a new session to the database for the given userid.
	// Returns the new session ID on success.
	//
	function session_begin($user_id, $user_ip, $page_id, $auto_create = 0, $enable_autologin = 0, $admin = 0)
	{
		global $db, $board_config, $mx_backend;
		global $mx_request_vars, $SID, $_SESSION, $_COOKIE;
		
		$cookiename = $board_config['cookie_name'];
		$cookiepath = $board_config['cookie_path'];
		$cookiedomain = $board_config['cookie_domain'];
		$cookiesecure = $board_config['cookie_secure']; //smf: secureCookies
		$session_length = $board_config['session_length'];
		
		$cookie_url = array();
		$cookie_url[1] = $cookiepath;
		$cookie_url[0] = $cookiedomain;
		
		$cookie_state = (empty($board_config['allow_autologin']) ? 0 : 1) | (empty($board_config['cookie_secure']) ? 0 : 2);
		
		if (isset($_COOKIE[$cookiename]) && preg_match('~^a:[34]:\{i:0;(i:\d{1,6}|s:[1-8]:"\d{1,8}");i:1;s:(0|40):"([a-fA-F0-9]{40})?";i:2;[id]:\d{1,14};(i:3;i:\d;)?\}$~', stripslashes($_COOKIE[$cookiename])) === 1)
		{
	        $cookieData = stripslashes($_COOKIE[$cookiename]);
			$array = @unserialize($cookieData);
			
			// out with the old, in with the new
			if (isset($array[3]) && $array[3] != $cookie_state) 
			{
				$cookie_url = $this->url_parts($array[3] & 1 > 0, $array[3] & 2 > 0);
				setcookie($cookiename, serialize(array(0, '', 0)), time() - 3600, $cookie_url[1], $cookie_url[0], !empty($cookiesecure));
			}
			$session_id = isset($_COOKIE[$cookiename . '_sid']) ? $_COOKIE[$cookiename . '_sid'] : $mx_request_vars->get('sid', MX_TYPE_NO_TAGS, session_id());
		}		
		else
		{
			$sessiondata = array();
			$session_id = $mx_request_vars->get('sid', MX_TYPE_NO_TAGS, session_id());
			$sessionmethod = SESSION_METHOD_GET;
			$sessiondata['SESSION']         = $_SESSION;
			
		    //compatible with nativesmf session parameters 
			$session_name            = session_name();
			$cookieParams            = session_get_cookie_params();
			$sessionSavePath         = session_save_path();
			$sessiondata['sessionId']       = $session_id;
			$sessiondata['sessionName']     = $session_name;
			$sessiondata['cookieParams']    = $cookieParams;
			$sessiondata['sessionSavePath'] = $sessionSavePath;
		}
		
		//from Session Write
		if (!preg_match('~^[A-Za-z0-9]{16,32}$~', $session_id)) 
		{
			$session_id = '';
		}
		
		$page_id = (int) $page_id;
		
		$last_visit = 0;
		$current_time = time();
		
		//
		// Are auto-logins allowed?
		// If allow_autologin is not set or is true then they are
		// (same behaviour as old 2.0.x session code)
		//
		if (isset($board_config['allow_autologin']) && !$board_config['allow_autologin'])
		{
			$enable_autologin = $sessiondata['autologinid'] = false;
		}
		
		//
		// First off attempt to join with the autologin value if we have one
		// If not, just use the user_id value
		//
		$userdata = array();
		if ($user_id != 0)
		{
			if (isset($sessiondata['autologinid']) && (string) $sessiondata['autologinid'] != '' && $user_id)
			{
				$sql = 'SELECT *
					FROM ' . USERS_TABLE . '
					WHERE id_member = ' . (int) $user_id;				
				if (!$result = $db->sql_query_limit($sql, 1))
				{
					mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
				}
				
				$userdata = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$enable_autologin = $login = 1;
			}
			else if (!$auto_create)
			{
				$sessiondata['autologinid'] = '';
				$sessiondata['userid'] = $user_id;
				
				$sql = 'SELECT *
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . (int) $user_id . '
						AND is_activated = 1';	
				if (!($result = $db->sql_query($sql)))
				{
					mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
				}
				$userdata = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
				$login = 1;
			}
		}
		
		/*
		* At this point either $userdata should be populated or
		* one of the below is true
		* Key didn't match one in the DB
		 * User does not exist
		 * User is inactive
		*/
		if (!sizeof($userdata) || !is_array($userdata) || !$userdata)
		{
			$sessiondata['autologinid'] = '';
			$sessiondata['userid'] = $user_id = ANONYMOUS; //ADMIN 1, ANONYMOUS 0;
			$enable_autologin = $login = 0;
			
			$sql = 'SELECT *
				FROM ' . USERS_TABLE . '
				WHERE id_member = ' . (int) $user_id;	
			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
			}
			$userdata = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);		
		}
		
		/*
		* Code here for SMF Bridge, ban check against user id, IP and email address
		*
		*code here */
		$userdata = $this->sync_userdata($userdata);
		// get the data and path to set it on
		$data = serialize(empty($userdata['user_id']) ? array(0, '', 0) : array($userdata['user_id'], $userdata['password'], time() + $board_config['session_length'], $cookie_state));		
		/*
		* Create or update the session
		* first try to update an existing row...
		*/
		$sql_ary['session_id'] = (string) $session_id;
		$sql_ary['data'] = (string) $data;
		$sql_ary['last_update'] = (int) time();	
		
		$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
			WHERE session_id = '" . $db->sql_escape($this->session_id) . "'";		
				
		if (!$db->sql_query($sql) || !$db->sql_affectedrows())
		{
			$session_id = md5($mx_backend->dss_rand());
			$sql_ary['session_id'] = (string) $session_id;
			$sql_ary['data'] = (string) $data;
			$sql_ary['last_update'] = (int) time();
			
			$sql = "INSERT INTO " . SESSIONS_TABLE . " " . $db->sql_build_array('INSERT', $sql_ary);						
			if (!$db->sql_query($sql))
			{
				mx_message_die(CRITICAL_ERROR, 'Error creating new session', '', __LINE__, __FILE__, $sql);
			}
		}
		
		if ($user_id)
		{
			$last_visit = ($userdata['user_lastvisit'] > 0 ) ? $userdata['user_lastvisit'] : $current_time;			
			if ($user_id != 1)
			{
				// Update the last visit time
				$sql = 'UPDATE ' . USERS_TABLE . '
					SET last_login = ' . (int) $last_visit . '
					WHERE id_member = ' . (int) $user_id;
					$db->sql_query($sql);					
				if (!$db->sql_query($sql))
				{
					mx_message_die(CRITICAL_ERROR, 'Error updating last visit time', '', __LINE__, __FILE__, $sql);
				}
			}
			$userdata['user_lastvisit'] = $userdata['last_login'] = $last_visit;
			
			/*
			* Regenerate the auto-login key
			* MXP session key table
			*/
			if ($enable_autologin)
			{
				$auto_login_key = $mx_backend->dss_rand() . $mx_backend->dss_rand();
				if (isset($sessiondata['autologinid']) && (string) $sessiondata['autologinid'] != '')
				{
					$sql = 'UPDATE ' . SESSIONS_KEYS_TABLE . "
						SET last_ip = '$user_ip', key_id = '" . md5($auto_login_key) . "', last_login = $current_time
						WHERE key_id = '" . md5($sessiondata['autologinid']) . "'";
				}
				else
				{
					$sql = 'INSERT INTO ' . SESSIONS_KEYS_TABLE . "(key_id, user_id, last_ip, last_login)
						VALUES ('" . md5($auto_login_key) . "', $user_id, '$user_ip', $current_time)";
				}
				if ( !$db->sql_query($sql) )
				{
					mx_message_die(CRITICAL_ERROR, 'Error updating session key', '', __LINE__, __FILE__, $sql);
				}
				$sessiondata['autologinid'] = $auto_login_key;
				unset($auto_login_key);
			}
			else
			{
				$sessiondata['autologinid'] = md5($mx_backend->dss_rand() . $mx_backend->dss_rand());
			}
			//$sessiondata['autologinid'] = (!$admin) ? (( $enable_autologin && $sessionmethod == SESSION_METHOD_COOKIE ) ? $auto_login_key : '') : $sessiondata['autologinid'];
			$sessiondata['userid'] = $user_id;
		}
		
		$userdata['session_id'] = $session_id;
		$userdata['session_ip'] = $user_ip;
		$userdata['session_user_id'] = $user_id;
		$userdata['session_logged_in'] = $login;
		$userdata['session_page'] = $page_id;
		$userdata['session_start'] = $current_time;
		$userdata['session_time'] = $current_time;
		$userdata['session_admin'] = $admin;
		$userdata['session_key'] = $sessiondata['autologinid'];
		
		// set the cookie, $_COOKIE, and session variable
		setcookie($cookiename, $data, time() + $session_length, $cookie_url[1], $cookie_url[0], !empty($cookiesecure));		
		$SID = 'sid=' . $session_id;
		
		$userdata = $this->sync_userdata($userdata);		
		return $userdata;
	}

	/*
	* Checks for a given user session, tidies session table and updates user
	* sessions at each page refresh
	*/
	function session_pagestart($user_ip, $thispage_id)
	{
		global $db, $lang, $board_config;
		global $mx_request_vars, $SID, $_COOKIE, $_SESSION, $_REQUEST, $_GET, $_POST;
		
		$cookiename = $board_config['cookie_name'];
		$cookiepath = $board_config['cookie_path'];
		$cookiedomain = $board_config['cookie_domain'];
		$cookiesecure = $board_config['cookie_secure']; //smf: secureCookies
		
		$cookie_url = array();
		$cookie_url[1] = $cookiepath;
		$cookie_url[0] = $cookiedomain;
		$user_id = 0;	
		$cookie_state = (empty($board_config['allow_autologin']) ? 0 : 1) | (empty($board_config['cookie_secure']) ? 0 : 2);
		
		$session_id = $mx_request_vars->get('sid', MX_TYPE_NO_TAGS, md5(md5('smf_sess_' . time()) . mt_rand()));
		$_REQUEST[session_name()] = $session_id;
		$_GET[session_name()] = $session_id;
		$_POST[session_name()] = $session_id;			
		$current_time = time();
		
		unset($userdata);
		if (isset($_COOKIE[$cookiename]) && preg_match('~^a:[34]:\{i:0;(i:\d{1,6}|s:[1-8]:"\d{1,8}");i:1;s:(0|40):"([a-fA-F0-9]{40})?";i:2;[id]:\d{1,14};(i:3;i:\d;)?\}$~', stripslashes($_COOKIE[$cookiename])) === 1)
		{
	        $cookieData = stripslashes($_COOKIE[$cookiename]);
			$array = @unserialize($cookieData);		
			// out with the old, in with the new
			if (isset($array[3]) && $array[3] != $cookie_state) 
			{
				$cookie_url = $this->url_parts($array[3] & 1 > 0, $array[3] & 2 > 0);
				setcookie($cookiename, serialize(array(0, '', 0)), time() - 3600, $cookie_url[1], $cookie_url[0], !empty($cookiesecure));
			}
		}
		global $_SESSION;
		$sessiondata = array();
		$sessionmethod = SESSION_METHOD_GET;
		$sessiondata['SESSION']	= $_SESSION;
		
		//compatible with nativesmf session parameters 
		$session_name            		= session_name();
		$cookieParams           	 	= session_get_cookie_params();
		$sessionSavePath        	 	= session_save_path();
		$sessiondata['sessionId']       = $session_id;
		$sessiondata['sessionName']     = $session_name;
		$sessiondata['cookieParams']    = $cookieParams;
		$sessiondata['sessionSavePath'] = $sessionSavePath;
		
		if (!preg_match('/^[A-Za-z0-9]*$/', $session_id))
		{
			$session_id = '';
		}
		$thispage_id = (int) $thispage_id;
		
		// Does a session exist?
		if (!empty($session_id))
		{
			/*
			* session_id exists so go ahead and attempt to grab all
			* data in preparation
			*/		
			$sql = "SELECT data
				FROM " . SESSIONS_TABLE . "
				WHERE session_id = '" . $db->sql_escape($session_id) . "'";				
			if ($result = $db->sql_query_limit($sql, 1))
			{
		      	// look for it in the database.
				$session_data = $db->sql_fetchrow($result);
				//serialize(array($userdata['user_id'], $userdata['password'], time() + $board_config['session_length'], $cookie_state));
				list ($user_id, $password) = @unserialize($session_data['data']);								
				$db->sql_freeresult($result);				
		    } 
			else 
			{
				mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
		    }					
			$userdata = $this->load_user($user_id, false);
			$userdata = $this->sync_userdata($userdata);
			// Did the session exist in the DB?
			if (isset($userdata['user_id']))
			{
				//
				// Do not check IP assuming equivalence, if IPv4 we'll check only first 24
				// bits ... I've been told (by vHiker) this should alleviate problems with
				// load balanced et al proxies while retaining some reliance on IP security.
				//
				$ip_check_s = substr($userdata['session_ip'], 0, 6);
				$ip_check_u = substr($user_ip, 0, 6);			
				if ($ip_check_s == $ip_check_u)
				{
					$SID = ($sessionmethod == SESSION_METHOD_GET || defined('IN_ADMIN')) ? 'sid=' . $session_id : '';
					//
					// Only update session DB a minute or so after last update
					//
					if ( $current_time - $userdata['session_time'] > 60 )
					{
						// A little trick to reset session_admin on session re-usage
						$update_admin = (!defined('IN_ADMIN') && $current_time - $userdata['session_time'] > ($board_config['session_length'] + 60)) ? ', session_admin = 0' : '';
						
						$sql = "UPDATE " . SESSIONS_TABLE . "
							SET session_time = $current_time, session_page = $thispage_id$update_admin
							WHERE session_id = '" . $userdata['session_id'] . "'";
						if ( !$db->sql_query($sql) )
						{
							mx_message_die(CRITICAL_ERROR, 'Error updating sessions table', '', __LINE__, __FILE__, $sql);
						}
						if ($userdata['user_id'])
						{
							$sql = "UPDATE " . USERS_TABLE . "
								SET user_session_time = $current_time, user_session_page = $thispage_id
								WHERE id_member = " . $userdata['user_id'];
							if ( !$db->sql_query($sql) )
							{
								mx_message_die(CRITICAL_ERROR, 'Error updating sessions table', '', __LINE__, __FILE__, $sql);
							}
						}
						mx_message_die(CRITICAL_ERROR, 'Hmm...? Error updating sessions table?', '', __LINE__, __FILE__, $sql);
						$this->session_clean($userdata['session_id']);
						//setcookie($cookiename . '_data', serialize($sessiondata), $current_time + 31536000, $cookiepath, $cookiedomain, $cookiesecure);
						//setcookie($cookiename . '_sid', $session_id, 0, $cookiepath, $cookiedomain, $cookiesecure);
					}
					// Add the session_key to the userdata array if it is set
					if (isset($sessiondata['autologinid']) && $sessiondata['autologinid'] != '')
					{
						$userdata['session_key'] = $sessiondata['autologinid'];
					}
					$userdata = $this->sync_userdata($userdata);
					return $userdata;
				}
			}
		}
		//
		// If we reach here then no (valid) session exists. So we'll create a new one,
		// using the cookie user_id if available to pull basic user prefs.
		//
		$user_id = (isset($sessiondata['userid'])) ? intval($sessiondata['userid']) : ANONYMOUS;	
		if (!($userdata = $this->session_begin($user_id, $user_ip, $thispage_id, TRUE)))
		{
			mx_message_die(CRITICAL_ERROR, 'Error creating user session', '', __LINE__, __FILE__, $sql);
		}
		return $userdata;
	}

	/**
	* Terminates the specified session
	* It will delete the entry in the sessions table for this session,
	* remove the corresponding auto-login key and reset the cookies
	*/
	function session_end($session_id, $user_id)
	{
		global $db, $lang, $board_config, $userdata;
		global $SID;
		
		$cookiename = $board_config['cookie_name'];
		$cookiepath = $board_config['cookie_path'];
		$cookiedomain = $board_config['cookie_domain'];
		$cookiesecure = $board_config['cookie_secure'];
		
		$current_time = time();
		
		if (!preg_match('/^[A-Za-z0-9]*$/', $session_id))
		{
			return;
		}
		
		//
		// Delete existing session
		//
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . "
			WHERE session_id = '$session_id'";
		if ( !$db->sql_query($sql) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error removing user session', '', __LINE__, __FILE__, $sql);
		}
		
		//
		// Remove this auto-login entry (if applicable)
		//
		if ( isset($userdata['session_key']) && $userdata['session_key'] != '' )
		{
			$autologin_key = md5($userdata['session_key']);
			$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
				WHERE id_member = ' . (int) $user_id . "
					AND key_id = '$autologin_key'";
			if ( !$db->sql_query($sql) )
			{
				mx_message_die(CRITICAL_ERROR, 'Error removing auto-login key', '', __LINE__, __FILE__, $sql);
			}
		}
		
		//
		// We expect that message_die will be called after this function,
		// but just in case it isn't, reset $userdata to the details for a guest
		//
		$sql = 'SELECT *
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . (int) ANONYMOUS;		
		if (!($result = $db->sql_query($sql)))
		{
			mx_message_die(CRITICAL_ERROR, 'Error obtaining user details', '', __LINE__, __FILE__, $sql);
		}
		
		if ( !($userdata = $db->sql_fetchrow($result)) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error obtaining user details', '', __LINE__, __FILE__, $sql);
		}
		$db->sql_freeresult($result);
		
		setcookie($cookiename, '', time() + $current_time - 31536000, $cookiepath, $cookiedomain, !empty($cookiesecure));
		
		return true;
	}

	/**
	* Removes expired sessions and auto-login keys from the database
	*/
	function session_clean($session_id)
	{
		global $board_config, $db;

		//
		// Delete expired sessions
		//
		if (preg_match('~^[A-Za-z0-9]{16,32}$~', $session_id) == 0)
		{
			return false;
	    }
		
		// just delete the row...
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . '
			WHERE last_update < ' . (time() - (int) $board_config['session_length']) . "
				AND session_id = '$session_id'";
		if ( !$db->sql_query($sql) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error clearing sessions table', '', __LINE__, __FILE__, $sql);
		}
		
		//
		// Delete expired auto-login keys
		// If max_autologin_time is not set then keys will never be deleted
		// (same behaviour as old 2.0.x session code)
		//
		if (!empty($board_config['max_autologin_time']) && $board_config['max_autologin_time'] > 0)
		{
			$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
				WHERE last_login < ' . (time() - (86400 * (int) $board_config['max_autologin_time']));
			$db->sql_query($sql);
		}		
		return true;
	}

	/**
	* Reset all login keys for the specified user
	* Called on password changes
	*/
	function session_reset_keys($user_id, $user_ip)
	{
		global $db, $userdata, $board_config, $mx_backend;

		$key_sql = ($user_id == $userdata['user_id'] && !empty($userdata['session_key'])) ? "AND key_id != '" . md5($userdata['session_key']) . "'" : '';

		$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
			WHERE user_id = ' . (int) $user_id . "
				$key_sql";

		if ( !$db->sql_query($sql) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error removing auto-login keys', '', __LINE__, __FILE__, $sql);
		}

		$where_sql = 'session_user_id = ' . (int) $user_id;
		$where_sql .= ($user_id == $userdata['user_id']) ? " AND session_id <> '" . $userdata['session_id'] . "'" : '';
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . "
			WHERE $where_sql";
		if ( !$db->sql_query($sql) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error removing user session(s)', '', __LINE__, __FILE__, $sql);
		}

		if ( !empty($key_sql) )
		{
			$auto_login_key = $mx_backend->dss_rand() . $mx_backend->dss_rand();

			$current_time = time();

			$sql = 'UPDATE ' . SESSIONS_KEYS_TABLE . "
				SET last_ip = '$user_ip', key_id = '" . md5($auto_login_key) . "', last_login = $current_time
				WHERE key_id = '" . md5($userdata['session_key']) . "'";

			if ( !$db->sql_query($sql) )
			{
				mx_message_die(CRITICAL_ERROR, 'Error updating session key', '', __LINE__, __FILE__, $sql);
			}

			// And now rebuild the cookie
			//Change this to standard SMF data
			$sessiondata['userid'] = $user_id;
			$sessiondata['autologinid'] = $auto_login_key;
			$cookiename = $board_config['cookie_name'];
			$cookiepath = $board_config['cookie_path'];
			$cookiedomain = $board_config['cookie_domain'];
			$cookiesecure = $board_config['cookie_secure'];

			setcookie($cookiename, serialize($sessiondata), $current_time + 31536000, $cookiepath, $cookiedomain, $cookiesecure);

			$userdata['session_key'] = $auto_login_key;
			unset($sessiondata);
			unset($auto_login_key);
		}
	}

	/** *******************************************************************************************************
	 * Include the User class
	 ******************************************************************************************************* */

	/**
	* Define backend specific lang defs
	*/
	function setup($lang_set = false, $style = false)
	{
		global $db, $template, $board_config, $userdata, $phpbb_auth, $phpEx, $phpbb_root_path, $mx_root_path, $mx_cache;
		global $mx_request_vars, $portal_config, $shared_lang_path; //added for mxp

		$lang_set = !$lang_set ? (defined('IN_ADMIN') ? 'lang_admin' : 'lang_main') : $lang_set;

		$this->lang_name = $this->lang['default_lang'];
		$this->lang_path = $shared_lang_path;

		$this->date_format = $board_config['default_dateformat'];
		$this->timezone = $board_config['user_timezone'] * 3600;
		$this->dst = $this->data['user_dst'] * 3600;

		//
		// We include common language file here to not load it every time a custom language file is included
		//
		$lang = &$this->lang;

		/* Sort of pointless here, since we have already included all main lang files
		if ((@include $this->lang_path . "common.$phpEx") === false)
		{
			//this will fix the path for anonymouse users
			if ((@include $phpbb_root_path . $this->lang_path . "common.$phpEx") === false)
			{
				die('Language file ' . $this->lang_path . "common.$phpEx" . ' couldn\'t be opened.');
			}
		}

		$this->add_lang($lang_set);

		// We include common language file here to not load it every time a custom language file is included
		//$lang = &$this->lang;
		unset($lang_set);
		*/

		return;
	}
	
	/**
	 * Sync UserData
	 * @access private
	 */	
	function sync_userdata($userdata = false)
	{
		if (empty($userdata))
		{
			return false;
		}	
		foreach ($userdata as $key => $value)
		{
			$do = true;
			switch ($key)
			{
				// Rename user_data keys and get internal sitename/sitedesc
				case 'id_member':
					$key = 'user_id';
				break;				
				case 'member_name':
					$key = 'user_name';
				break;				
				case 'date_registered':
					$key = 'user_regdate';
				break;				
				case 'posts':
					$key = 'user_posts';
				break;				
				case 'id_group':
					$key = 'user_level';
				break;				
				case 'lngfile':
					$key = 'user_lang';
				break;				
				case 'last_login':
					$key = 'user_lastvisit';
				break;
				// Keep SMF native real_name				
				case 'real_name':				
				break;				
				case 'instant_messages':
					$key = 'user_last_privmsg';
				break;				
				case 'unread_messages':
					$key = 'user_unread_privmsg';
				break;				
				case 'new_pm':
					$key = 'user_new_privmsg';
				break;				
				case 'buddy_list':
					$key = 'user_friends';
				break;				
				case 'pm_ignore_list':
					$key = 'user_pm_ignore_list';
				break;				
				case 'pm_prefs':
					$key = 'user_pm_prefs';
				break;				
				case 'mod_prefs':
					$key = 'user_mod_prefs';
				break;				
				case 'message_labels':
					$key = 'user_message_labels';
				break;				
				case 'passwd':
					$key = 'user_passwd';
				break;				
				case 'openid_uri':
					$key = 'user_openid_uri';
				break;				
				case 'email_address':
					$key = 'user_email';
				break;				
				case 'personal_text':
				break;				
				case 'gender':
				break;				
				case 'birthdate':
				break;				
				case 'website_title':
				break;				
				case 'website_url':
				break;				
				case 'location':
				break;				
				case 'icq':
					$key = 'icq';
				break;				
				case 'aim':
					$key = 'aim';
				break;				
				case 'yim':
					$key = 'yim';
				break;				
				case 'msn':
					$key = 'msn';
				break;				
				case 'hide_email':
				break;				
				case 'show_online':
				break;				
				case 'time_format':
					$key = 'user_dateformat';
				break;				
				case 'signature':
				break;				
				case 'time_offset':
				break;				
				case 'avatar':
				break;				
				case 'pm_email_notify':
				break;				
				case 'karma_bad':
				break;				
				case 'karma_good':
				break;				
				case 'usertitle':
				break;				
				case 'notify_announcements':
				break;				
				case 'notify_regularity':
				break;				
				case 'notify_send_body':
				break;				
				case 'notify_types':
				break;				
				case 'member_ip':
					$key = 'user_ip';
				break;				
				case 'member_ip2':
					$key = 'user_ip2';
				break;				
				case 'secret_question':
				break;				
				case 'secret_answer':
				break;				
				case 'id_theme':
					$key = 'user_style';
				break;				
				case 'is_activated':
					$key = 'user_active';
				break;				
				case 'validation_code':
				break;				
				case 'id_msg_last_visit':
				break;				
				case 'additional_groups':
					$key = 'user_groups';
				break;				
				case 'smiley_set':
				break;				
				case 'id_post_group':
					$key = 'user_default_group';
				break;				
				case 'total_time_logged_in':
					$key = 'user_last_online';
				break;				
				case 'password_salt':
				break;				
				case 'ignore_boards':
				break;				
				case 'warning':
					$key = 'user_warnings';
				break;				
				case 'passwd_flood':
					$key = 'user_logintry';
				break;				
				case 'pm_receive_from':					
					$key = 'user_pm_from';
				break;					
			}
			if ($do)
			{
				return $userdata[$key] = $value;
			}
		}		
	}

	/**
	 * A replacement for unserialize that returns whether it worked and
	 * populates the unserialized variable by reference.
	 *
	 * @author walf
	 * @link   http://www.php.net/manual/pt_BR/function.unserialize.php#105500
	 * @param  string $serialized the serialized data
	 * @param  array $into the variable to hold the unserialized array
	 * @return bool whether the data was unserialized or not
	 * @since  0.1.2
	 *
	 */
	function funserialize($serialized, &$into)
	{
	    static $sfalse;
	    if ($sfalse === null)
		{		
	        $sfalse = serialize(false);
		}	    
		$into = @unserialize($serialized);
	    return $into !== false || @rtrim($serialized) === $sfalse;
	    //whitespace at end of serialized var is ignored by PHP
	}
	
	/**
	 * Setup style
	 *
	 * Define backend specific style defs
	 *
	 */
	function setup_style()
	{
		return;
	}

	/**
	* Add Language Items - use_db and use_help are assigned where needed (only use them to force inclusion)
	*
	* @param mixed $lang_set specifies the language entries to include
	* @param bool $use_db internal variable for recursion, do not use
	* @param bool $use_help internal variable for recursion, do not use
	*
	* Examples:
	* <code>
	* $lang_set = array('posting', 'help' => 'faq');
	* $lang_set = array('posting', 'viewtopic', 'help' => array('bbcode', 'faq'))
	* $lang_set = array(array('posting', 'viewtopic'), 'help' => array('bbcode', 'faq'))
	* $lang_set = 'posting'
	* $lang_set = array('help' => 'faq', 'db' => array('help:faq', 'posting'))
	* </code>
	*/
	function add_lang($lang_set, $use_db = false, $use_help = false)
	{
		global $phpEx;

		if (is_array($lang_set))
		{
			foreach ($lang_set as $key => $lang_file)
			{
				// Please do not delete this line.
				// We have to force the type here, else [array] language inclusion will not work
				$key = (string) $key;

				if ($key == 'db')
				{
					$this->add_lang($lang_file, true, $use_help);
				}
				else if ($key == 'help')
				{
					$this->add_lang($lang_file, $use_db, true);
				}
				else if (!is_array($lang_file))
				{
					$this->set_lang($this->lang, $this->help, $lang_file, $use_db, $use_help);
				}
				else
				{
					$this->add_lang($lang_file, $use_db, $use_help);
				}
			}
			unset($lang_set);
		}
		elseif ($lang_set)
		{
			$this->set_lang($this->lang, $this->help, $lang_set, $use_db, $use_help);
		}
	}

	/**
	* Set language entry (called by add_lang)
	* @access private
	*/
	function set_lang(&$lang, &$help, $lang_file, $use_db = false, $use_help = false)
	{
		global $phpbb_root_path, $phpEx;

		// $lang == $this->lang
		// $help == $this->help
		// - add appropriate variables here, name them as they are used within the language file...
		if (!$use_db)
		{
			if ($use_help && strpos($lang_file, '/') !== false)
			{
				$language_filename = $this->lang_path . substr($lang_file, 0, stripos($lang_file, '/') + 1) . 'help_' . substr($lang_file, stripos($lang_file, '/') + 1) . '.' . $phpEx;
			}
			else
			{
				$language_filename = $this->lang_path . (($use_help) ? 'help_' : '') . $lang_file . '.' . $phpEx;
			}

			//fix for mxp
			if ((@include $language_filename) === false)
			{
				//this will fix the path for anonymouse users
				if ((@include $phpbb_root_path . $language_filename) === false)
				{
					die('Language file ' . $language_filename . ' couldn\'t be opened.');
				}
			}
		}
		else
		{
			// Get Database Language Strings
			// Put them into $lang if nothing is prefixed, put them into $help if help: is prefixed
			// For example: help:faq, posting
			die("You should not use db with MX-Publisher!");
		}

		// We include common language file here to not load it every time a custom language file is included
		$this->lang = &$lang;
	}
	
	/**
	* Get language id currently used by the user
	**/
	function get_iso_lang_id()
	{
		global $board_config, $db;
		
		if (!empty($this->lang_id))
		{
			return $this->lang_id;
		}
		
		if (!$this->lang_name)
		{
			$this->lang_name = $board_config['default_lang'];
		}
		return false;
	}

	/**
	* Get users profile fields
	*/
	function get_profile_fields($user_id)
	{
		return false;
	}
	
	/**
	 * Gets the user's info
	 *
	 * Will take the users email, username or member id and return their data
	 *
	 * @param  int || string $username the user's email address username or member id
	 * @return array $results containing the user info || bool false
	 * @since  0.1.2
	 */
	function load_user($user, $force_str = false)
	{
		if (!is_numeric($user) || $force_str)
		{
			$user = phpBB2::phpbb_clean_username($user);
		}
		else
		{
			$user = intval($user);
		}	
		
	    $this_data = array();
		
	    // we'll try id || email, then username
	    if (is_numeric($user))
		{
	        // number is most likely a member id
	        $this_data = $this->get_user_by_id($user);
	    } 
		else 
		{
	        // the email can't be purely numeric
	        $this_data = $this->get_user_by_email($user);
	    }
		
	    if (empty($this_data))
		{
	        $this_data = $this->get_user_by_name($user);
	    }
		
	    if (empty($this_data)) 
		{
	        return false;
	    } 
		else
		{
	        return $this_data;
	    }
		
	}

	/**
	* Load user helper
	*
	* @param array $user_ids
	*/
	function load_users(array $user_ids)
	{
		$user_ids[] = ANONYMOUS;
		
		// Make user_ids unique and convert to integer.
		$user_ids = array_map('intval', array_unique($user_ids));
		
		// Do not load users we already have in $this->users
		$user_ids = array_diff($user_ids, array_keys($this->users));
		
		if (sizeof($user_ids))
		{
			$sql = $db->sql_build_query('SELECT', array(
			'SELECT'	=> 'u.*, u.id_member as user_id, u.id_member as user_id, u.lngfile as user_lang, u.time_format as user_dateformat, u.time_offset as user_timezone',
				
			'FROM'		=> array(
					USERS_TABLE	=> "u",
			),
				
			'WHERE'		=> $db->sql_in_set('id_member', $user_ids)
			));	
			$result = $db->sql_query($sql);
			
			while ($row = $db->sql_fetchrow($result))
			{
				$this->users[$row['id_member']] = $row;
			}
			$db->sql_freeresult($result);
		}
	}	
	
	/**
	 * Gets the user's info from their email address
	 *
	 * Will take the users email address and return an array containing all the
	 * user's information in the db. Will return false on failure
	 *
	 * @param  string $email the user's email address
	 * @return array $results containing the user info || bool false
	 * @since  0.1.0
	 */
	function get_user_by_email($email = '')
	{
		global $db;
		if ('' == $email || !is_string($email) || 2 > count(explode('@', $email))) 
		{
			return false;
		}
		$sql = $db->sql_build_query('SELECT', '
			SELECT * FROM ' . USERS_TABLE . '
				WHERE email_address = {string:email_address}',
				array('email_address' => $email, ));
		$result = $db->sql_query_limit($sql, 1);
		$return = $db->sql_fetchrow($result);
		if (!$return)
		{
			$db->sql_freeresult($result);
			//trigger_error($mx_user->lang['NO_USER'] . adm_back_link($this->u_action), E_USER_WARNING);
		}
		if (empty($return)) 
		{
			return false;
		} 
		else
		{
		    // return all the results.
		    return $return;
		}
	}

	/**
	 * Gets the user's info from their member id
	 *
	 * Will take the users member id and return an array containing all the
	 * user's information in the db. Will return false on failure
	 *
	 * @param  int $id the user's member id
	 * @return array $results containing the user info || bool false
	 * @since  0.1.2
	 */
	function get_user_by_id($id = '')
	{
		global $db;
		if ('' == $id || !is_numeric($id))
		{
			return false;
		} 
		else
		{
			$id = intval($id);
			if (0 == $id) 
			{
				return false;
			}
		}
		$sql = $db->sql_build_query('SELECT', '
			SELECT * FROM ' . USERS_TABLE . '
				WHERE id_member = {int:id_member}',
				array('id_member' => $id, ));
		$result = $db->sql_query_limit($sql, 1);
		$return = $db->sql_fetchrow($result);
		if (!$return)
		{
			$db->sql_freeresult($result);
			//trigger_error($mx_user->lang['NO_USER'] . adm_back_link($this->u_action), E_USER_WARNING);
		}
		if (empty($return)) 
		{
			return false;
		} 
		else
		{
		    // return all the results.
		    return $return;
		}
	}
	
	/**
	 * Gets the user's info from their member name (username)
	 *
	 * Will take the users member name and return an array containing all the
	 * user's information in the db. Will return false on failure
	 *
	 * @param  string $username the user's member name
	 * @return array $results containing the user info || bool false
	 * @since  0.1.0
	 */
	function get_user_by_name($username = '')
	{
	    global $db;
		if ('' == $username || !is_string($username))
		{
	        return false;
	    }	
		$sql = $db->sql_build_query('SELECT', '
			SELECT * FROM ' . USERS_TABLE . '
				WHERE member_name = {string:member_name}',
				array('member_name' => $username, ));
		$result = $db->sql_query_limit($sql, 1);
		$return = $db->sql_fetchrow($result);
		if (!$return)
		{
			$db->sql_freeresult($result);
			//trigger_error($mx_user->lang['NO_USER'] . adm_back_link($this->u_action), E_USER_WARNING);
		}
		if (empty($return)) 
		{
			return false;
		} 
		else
		{
		    // return all the results.
		    return $return;
		}
	}		
	
	/**
	* Specify/Get image
	//
	// phpBB2 Graphics - redefined for mxBB
	// - Uncomment and redefine phpBB graphics
	//
	// If you need to redefine some phpBB graphics, look within the phpBB/templates folder for the template_name.cfg file and
	// redefine those $image['xxx'] you want. Note: Many phpBB images are reused all over mxBB (eg see below), thus if you redefine
	// common phpBB images, this will have immedaite effect for all mxBB pages.
	//
	*/
	function img($img, $alt = '', $width = false, $suffix = '', $type = 'full_tag')
	{
		static $imgs;
		global $phpbb_root_path, $mx_root_path, $mx_images;
		
		//
		// Load phpBB Template configuration data
		// - First try current template
		//
		if ( file_exists( $phpbb_root_path . $this->current_template_path . "/images" ) )
		{
			$current_template_path = $this->current_template_path;
			$template_name = $this->template_name;

			@include($phpbb_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg');
		}

		//
		// Since we have no current Template Config file, try the cloned template instead
		//
		if ( file_exists( $phpbb_root_path . $this->cloned_current_template_path . "/images" ) && !defined('TEMPLATE_CONFIG') )
		{
			$current_template_path = $this->cloned_current_template_path;
			$template_name = $this->cloned_template_name;

			@include($phpbb_root_path . $this->cloned_current_template_path . '/' . $this->cloned_template_name . '.cfg');
		}

		//
		// Last attempt, use default template intead
		//
		if ( file_exists( $phpbb_root_path . $this->default_current_template_path . "/images" ) && !defined('TEMPLATE_CONFIG') )
		{
			$current_template_path = $this->default_current_template_path;
			$template_name = $this->default_template_name;

			@include($phpbb_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg');
		}

		$this->img_lang = (file_exists($phpbb_root_path . $current_template_path . $this->lang_name)) ? $this->lang_name : $board_config['default_lang'];		

		/* Here we overwrite phpBB images from the template configuration file with images from database  */
		
		$this->img_array['image_filename'] = array(
			'img_site_logo' => "logo.gif",
			'img_upload_bar' => "upload_bar.gif",
			'img_icon_contact_aim' => "icon_aim.gif",
			'img_icon_contact_email' => "icon_email.gif",
			'img_icon_contact_icq' => "icon_icq_add.gif",
			'img_icon_contact_jabber' => "icon_jabber.gif",
			'img_icon_contact_msnm' => "icon_msnm.gif",
			'img_icon_contact_pm' => "icon_pm.gif",
			'img_icon_contact_yahoo' => "icon_yim.gif",
			'img_icon_contact_www' => "icon_www.gif",
			'img_icon_post_delete' => "icon_delete.gif",
			'img_icon_post_edit' => "icon_edit.gif",
			'img_icon_post_info' => "icon_info.gif",
			'img_icon_post_quote' => "icon_quote.gif",
			'img_icon_post_report' => "icon_report.gif",
			'img_icon_user_online' => "icon_online.gif",
			'img_icon_user_offline' => "icon_offline.gif",
			'img_icon_user_profile' => "icon_profile.gif",
			'img_icon_user_search' => "icon_search.gif",
			'img_icon_user_warn' => "icon_warn.gif",
			'img_button_pm_forward' => "reply.gif",
			'img_button_pm_new' => "msg_newpost.gif",
			'img_button_pm_reply' => "reply.gif",
			'img_button_topic_locked' => "msg_newpost.gif",
			'img_button_topic_new' => "post.gif",
			'img_button_topic_reply' => "reply.gif",
			'img_forum_link' => "forum_link.gif",
			'img_forum_read' => "forum_read.gif",
			'img_forum_read_locked' => "forum_read_locked.gif",
			'img_forum_read_subforum' => "forum_read_subforum.gif",
			'img_forum_unread' => "forum_unread.gif",
			'img_forum_unread_locked' => "forum_unread_locked.gif",
			'img_forum_unread_subforum' => "forum_unread_subforum.gif",
			'img_topic_moved' => "topic_moved.gif",
			'img_topic_read' => "topic_read.gif",
			'img_topic_read_mine' => "topic_read_mine.gif",
			'img_topic_read_hot' => "topic_read_hot.gif",
			'img_topic_read_hot_mine' => "topic_read_hot_mine.gif",
			'img_topic_read_locked' => "topic_read_locked.gif",
			'img_topic_read_locked_mine' => "topic_read_locked_mine.gif",
			'img_topic_unread' => "topic_unread.gif",
			'img_topic_unread_mine' => "topic_unread_mine.gif",
			'img_topic_unread_hot' => "topic_unread_hot.gif",
			'img_topic_unread_hot_mine' => "topic_unread_hot_mine.gif",
			'img_topic_unread_locked' => "topic_unread_locked.gif",
			'img_topic_unread_locked_mine' => "topic_unread_locked_mine.gif",
			'img_sticky_read' => "sticky_read.gif",
			'img_sticky_read_mine' => "sticky_read_mine.gif",
			'img_sticky_read_locked' => "sticky_read_locked.gif",
			'img_sticky_read_locked_mine' => "ticky_read_locked_mine.gif",
			'img_sticky_unread' => "sticky_unread.gif",
			'img_sticky_unread_mine' => "sticky_unread_mine.gif",
			'img_sticky_unread_locked' => "sticky_unread_locked.gif",
			'img_sticky_unread_locked_mine' => "sticky_unread_locked_mine.gif",
			'img_announce_read' => "announce_read.gif",
			'img_announce_read_mine' => "announce_read_mine.gif",
			'img_announce_read_locked' => "announce_read_locked.gif",
			'img_announce_read_locked_mine' => "announce_read_locked_mine.gif",
			'img_announce_unread' => "announce_unread.gif",
			'img_announce_unread_mine' => "announce_unread_mine.gif",
			'img_announce_unread_locked' => "announce_unread_locked.gif",
			'img_announce_unread_locked_mine' => "announce_unread_locked_mine.gif",
			'img_global_read' => "announce_read.gif",
			'img_global_read_mine' => "announce_read_mine.gif",
			'img_global_read_locked' => "announce_read_locked.gif",
			'img_global_read_locked_mine' => "announce_read_locked_mine.gif",
			'img_global_unread' => "announce_unread.gif",
			'img_global_unread_mine' => "announce_unread_mine.gif",
			'img_global_unread_locked' => "announce_unread_locked.gif",
			'img_global_unread_locked_mine' => "announce_unread_locked_mine.gif",
			'img_subforum_read' => "", 
			'img_subforum_unread' => "",
			'img_pm_read' => "topic_read.gif",
			'img_pm_unread' => "topic_unread.gif",
			'img_icon_back_top' => "",
			'img_icon_post_target' => "icon_post_target.gif",
			'img_icon_post_target_unread' => "icon_post_target_unread.gif",
			'img_icon_topic_attach' => "icon_topic_attach.gif",
			'img_icon_topic_latest' => "icon_topic_latest.gif",
			'img_icon_topic_newest' => "icon_topic_newest.gif",
			'img_icon_topic_reported' => "icon_topic_reported.gif",
			'img_icon_topic_unapproved' => "icon_topic_unapproved.gif"			
		);
		
		$this->img_array['image_lang'] = array(
			'img_icon_post_edit' => $this->img_lang,
			'img_icon_post_quote' => $this->img_lang,
			'img_button_pm_forward' => $this->img_lang,
			'img_button_pm_new' => $this->img_lang,
			'img_button_pm_reply' => $this->img_lang,
			'img_button_topic_new' => $this->img_lang,
			'img_button_topic_reply' => $this->img_lang		
		);		
		
		$img_data = &$imgs[$img];

		if (empty($img_data))
		{
			if (!isset($this->img_array[$img]))
			{
				// Do not fill the image to let designers decide what to do if the image is empty
				$img_data = '';
				return $img_data;
			}

			$img_data['src'] = PHPBB_URL . $current_template_path . ($this->img_array[$img]['image_lang'] ? $this->img_array[$img]['image_lang'] .'/' : '') . $this->img_array[$img]['image_filename'];
			$img_data['width'] = (!empty($width)) ? $width : ''; //$this->img_array[$img]['image_width'];
			$img_data['height'] = (!empty($height)) ? $height : ''; //$this->img_array[$img]['image_height'];
		}

		$alt = (!empty($this->lang[$alt])) ? $this->lang[$alt] : $alt;

		switch ($type)
		{
			case 'src':
				return $img_data['src'];
			break;

			case 'width':
				return ($width === false) ? $img_data['width'] : $width;
			break;

			case 'height':
				return $img_data['height'];
			break;

			default:
				$use_width = ($width === false) ? $img_data['width'] : $width;

				return '<img src="' . $img_data['src'] . '"' . (($use_width) ? ' width="' . $use_width . '"' : '') . (($img_data['height']) ? ' height="' . $img_data['height'] . '"' : '') . ' alt="' . $alt . '" title="' . $alt . '" />';
			break;
		}
	}

	/**
	* Get option bit field from user options
	*/
	function optionget($key, $data = false)
	{
		if (!isset($this->keyvalues[$key]))
		{
			$var = ($data) ? $data : $this->data['user_options'];
			$this->keyvalues[$key] = ($var & 1 << $this->keyoptions[$key]) ? true : false;
		}

		return $this->keyvalues[$key];
	}

	/**
	* Set option bit field for user options
	*/
	function optionset($key, $value, $data = false)
	{
		$var = ($data) ? $data : $this->data['user_options'];

		if ($value && !($var & 1 << $this->keyoptions[$key]))
		{
			$var += 1 << $this->keyoptions[$key];
		}
		else if (!$value && ($var & 1 << $this->keyoptions[$key]))
		{
			$var -= 1 << $this->keyoptions[$key];
		}
		else
		{
			return ($data) ? $var : false;
		}

		if (!$data)
		{
			$this->data['user_options'] = $var;
			return true;
		}
		else
		{
			return $var;
		}
	}	

	/**
	 * encode_lang
	 *
	 * This function is used with internal backend to specify xml:lang  in overall headers (only two chars are allowed)
	 * This function can be also used to convert the user_lang oe default_lang to be undestend by tiny_mce like in mx_contact module
	 * Do not change!
	 *
	 * 'L_TINY_MCE_LANGUAGE' => $mx_user->encode_lang($board_config['default_lang']),
	 *
	 * @param unknown_type $lang
	 * @return unknown
	 */
	function encode_lang($lang)
	{
			switch($lang)
			{
				case 'afar':
					$lang_name = 'aa';
				break;
				case 'abkhazian':
					$lang_name = 'ab';
				break;
				case 'avestan':
					$lang_name = 'ae';
				break;
				case 'afrikaans':
					$lang_name = 'af';
				break;
				case 'akan':
					$lang_name = 'ak';
				break;
				case 'amharic':
					$lang_name = 'am';
				break;
				case 'aragonese':
					$lang_name = 'an';
				break;
				case 'arabic':
					$lang_name = 'ar';
				break;
				case 'assamese':
					$lang_name = 'as';
				break;
				case 'avaric':
					$lang_name = 'av';
				break;
				case 'aymara':
					$lang_name = 'ay';
				break;
				case 'azerbaijani':
					$lang_name = 'az';
				break;
				case 'bashkir':
					$lang_name = 'ba';
				break;
				case 'belarusian':
					$lang_name = 'be';
				break;
				case 'bulgarian':
					$lang_name = 'bg';
				break;
				case 'bihari':
					$lang_name = 'bh';
				break;
				case 'bislama':
					$lang_name = 'bi';
				break;
				case 'bambara':
					$lang_name = 'bm';
				break;
				case 'bengali':
					$lang_name = 'bn';
				break;
				case 'tibetan':
					$lang_name = 'bo';
				break;
				case 'breton':
					$lang_name = 'br';
				break;
				case 'bosnian':
					$lang_name = 'bs';
				break;
				case 'catalan':
					$lang_name = 'ca';
				break;
				case 'chechen':
					$lang_name = 'ce';
				break;
				case 'chamorro':
					$lang_name = 'ch';
				break;
				case 'corsican':
					$lang_name = 'co';
				break;
				case 'cree':
					$lang_name = 'cr';
				break;
				case 'czech':
					$lang_name = 'cs';
				break;
				case 'slavonic':
					$lang_name = 'cu';
				break;
				case 'chuvash':
					$lang_name = 'cv';
				break;
				case 'welsh_cymraeg':
					$lang_name = 'cy';
				break;
				case 'danish':
					$lang_name = 'da';
				break;
				case 'german':
					$lang_name = 'de';
				break;
				case 'divehi':
					$lang_name = 'dv';
				break;
				case 'dzongkha':
					$lang_name = 'dz';
				break;
				case 'ewe':
					$lang_name = 'ee';
				break;
				case 'greek':
					$lang_name = 'el';
				break;
				case 'hebrew':
					$lang_name = 'he';
				break;
				case 'english':
					$lang_name = 'en';
				break;
				case 'english_us':
					$lang_name = 'en_us';
				break;
				case 'esperanto':
					$lang_name = 'eo';
				break;
				case 'spanish':
					$lang_name = 'es';
				break;
				case 'estonian':
					$lang_name = 'et';
				break;
				case 'basque':
					$lang_name = 'eu';
				break;
				case 'persian':
					$lang_name = 'fa';
				break;
				case 'fulah':
					$lang_name = 'ff';
				break;
				case 'finnish':
					$lang_name = 'fi';
				break;
				case 'fijian':
					$lang_name = 'fj';
				break;
				case 'faroese':
					$lang_name = 'fo';
				break;
				case 'french':
					$lang_name = 'fr';
				break;
				case 'frisian':
					$lang_name = 'fy';
				break;
				case 'irish':
					$lang_name = 'ga';
				break;
				case 'scottish':
					$lang_name = 'gd';
				break;
				case 'galician':
					$lang_name = 'gl';
				break;
				case 'guaran�':
					$lang_name = 'gn';
				break;
				case 'gujarati':
					$lang_name = 'gu';
				break;
				case 'manx':
					$lang_name = 'gv';
				break;
				case 'hausa':
					$lang_name = 'ha';
				break;
				case 'hebrew':
					$lang_name = 'he';
				break;
				case 'hindi':
					$lang_name = 'hi';
				break;
				case 'hiri_motu':
					$lang_name = 'ho';
				break;
				case 'croatian':
					$lang_name = 'hr';
				break;
				case 'haitian':
					$lang_name = 'ht';
				break;
				case 'hungarian':
					$lang_name = 'hu';
				break;
				case 'armenian':
					$lang_name = 'hy';
				break;
				case 'herero':
					$lang_name = 'hz';
				break;
				case 'interlingua':
					$lang_name = 'ia';
				break;
				case 'indonesian':
					$lang_name = 'id';
				break;
				case 'interlingue':
					$lang_name = 'ie';
				break;
				case 'igbo':
					$lang_name = 'ig';
				break;
				case 'sichuan_yi':
					$lang_name = 'ii';
				break;
				case 'inupiaq':
					$lang_name = 'ik';
				break;
				case 'ido':
					$lang_name = 'io';
				break;
				case 'icelandic':
					$lang_name = 'is';
				break;
				case 'italian':
					$lang_name = 'it';
				break;
				case 'inuktitut':
					$lang_name = 'iu';
				break;
				case 'japanese':
					$lang_name = 'ja';
				break;
				case 'javanese':
					$lang_name = 'jv';
				break;
				case 'georgian':
					$lang_name = 'ka';
				break;
				case 'kongo':
					$lang_name = 'kg';
				break;
				case 'kikuyu':
					$lang_name = 'ki';
				break;
				case 'kwanyama':
					$lang_name = 'kj';
				break;
				case 'kazakh':
					$lang_name = 'kk';
				break;
				case 'kalaallisut':
					$lang_name = 'kl';
				break;
				case 'khmer':
					$lang_name = 'km';
				break;
				case 'kannada':
					$lang_name = 'kn';
				break;
				case 'korean':
					$lang_name = 'ko';
				break;
				case 'kanuri':
					$lang_name = 'kr';
				break;
				case 'kashmiri':
					$lang_name = 'ks';
				break;
				case 'kurdish':
					$lang_name = 'ku';
				break;
				case 'kv':
					$lang_name = 'komi';
				break;
				case 'cornish_kernewek':
					$lang_name = 'kw';
				break;
				case 'kirghiz':
					$lang_name = 'ky';
				break;
				case 'latin':
					$lang_name = 'la';
				break;
				case 'luxembourgish':
					$lang_name = 'lb';
				break;
				case 'ganda':
					$lang_name = 'lg';
				break;
				case 'limburgish':
					$lang_name = 'li';
				break;
				case 'lingala':
					$lang_name = 'ln';
				break;
				case 'lao':
					$lang_name = 'lo';
				break;
				case 'lithuanian':
					$lang_name = 'lt';
				break;
				case 'luba-katanga':
					$lang_name = 'lu';
				break;
				case 'latvian':
					$lang_name = 'lv';
				break;
				case 'malagasy':
					$lang_name = 'mg';
				break;
				case 'marshallese':
					$lang_name = 'mh';
				break;
				case 'maori':
					$lang_name = 'mi';
				break;
				case 'macedonian':
					$lang_name = 'mk';
				break;
				case 'malayalam':
					$lang_name = 'ml';
				break;
				case 'mongolian':
					$lang_name = 'mn';
				break;
				case 'moldavian':
					$lang_name = 'mo';
				break;
				case 'marathi':
					$lang_name = 'mr';
				break;
				case 'malay':
					$lang_name = 'ms';
				break;
				case 'maltese':
					$lang_name = 'mt';
				break;
				case 'burmese':
					$lang_name = 'my';
				break;
				case 'nauruan':
					$lang_name = 'na';
				break;
				case 'norwegian':
					$lang_name = 'nb';
				break;
				case 'ndebele':
					$lang_name = 'nd';
				break;
				case 'nepali':
					$lang_name = 'ne';
				break;
				case 'ndonga':
					$lang_name = 'ng';
				break;
				case 'dutch':
					$lang_name = 'nl';
				break;
				case 'norwegian_nynorsk':
					$lang_name = 'nn';
				break;
				case 'norwegian':
					$lang_name = 'no';
				break;
				case 'southern_ndebele':
					$lang_name = 'nr';
				break;
				case 'navajo':
					$lang_name = 'nv';
				break;
				case 'chichewa':
					$lang_name = 'ny';
				break;
				case 'occitan':
					$lang_name = 'oc';
				break;
				case 'ojibwa':
					$lang_name = 'oj';
				break;
				case 'oromo':
					$lang_name = 'om';
				break;
				case 'oriya':
					$lang_name = 'or';
				break;
				case 'ossetian':
					$lang_name = 'os';
				break;
				case 'panjabi':
					$lang_name = 'pa';
				break;
				case 'pali':
					$lang_name = 'pi';
				break;
				case 'polish':
					$lang_name = 'pl';
				break;
				case 'pashto':
					$lang_name = 'ps';
				break;
				case 'portuguese':
					$lang_name = 'pt';
				break;
				case 'portuguese_brasil':
					$lang_name = 'pt_br';
				break;
				case 'quechua':
					$lang_name = 'qu';
				break;
				case 'romansh':
					$lang_name = 'rm';
				break;
				case 'kirundi':
					$lang_name = 'rn';
				break;
				case 'romanian':
					$lang_name = 'ro';
				break;
				case 'russian':
					$lang_name = 'ru';
				break;
				case 'kinyarwanda':
					$lang_name = 'rw';
				break;
				case 'sanskrit':
					$lang_name = 'sa';
				break;
				case 'sardinian':
					$lang_name = 'sc';
				break;
				case 'sindhi':
					$lang_name = 'sd';
				break;
				case 'northern_sami':
					$lang_name = 'se';
				break;
				case 'sango':
					$lang_name = 'sg';
				break;
				case 'serbo-croatian':
					$lang_name = 'sh';
				break;
				case 'sinhala':
					$lang_name = 'si';
				break;
				case 'slovak':
					$lang_name = 'sk';
				break;
				case 'slovenian':
					$lang_name = 'sl';
				break;
				case 'samoan':
					$lang_name = 'sm';
				break;
				case 'shona':
					$lang_name = 'sn';
				break;
				case 'somali':
					$lang_name = 'so';
				break;
				case 'albanian':
					$lang_name = 'sq';
				break;
				case 'serbian':
					$lang_name = 'sr';
				break;
				case 'swati':
					$lang_name = 'ss';
				break;
				case 'sotho':
					$lang_name = 'st';
				break;
				case 'sundanese':
					$lang_name = 'su';
				break;
				case 'swedish':
					$lang_name = 'sv';
				break;
				case 'swahili':
					$lang_name = 'sw';
				break;
				case 'tamil':
					$lang_name = 'ta';
				break;
				case 'telugu':
					$lang_name = 'te';
				break;
				case 'tajik':
					$lang_name = 'tg';
				break;
				case 'thai':
					$lang_name = 'th';
				break;
				case 'tigrinya':
					$lang_name = 'ti';
				break;
				case 'turkmen':
					$lang_name = 'tk';
				break;
				case 'tagalog':
					$lang_name = 'tl';
				break;
				case 'tswana':
					$lang_name = 'tn';
				break;
				case 'tonga':
					$lang_name = 'to';
				break;
				case 'turkish':
					$lang_name = 'tr';
				break;
				case 'tsonga':
					$lang_name = 'ts';
				break;
				case 'tatar':
					$lang_name = 'tt';
				break;
				case 'twi':
					$lang_name = 'tw';
				break;
				case 'tahitian':
					$lang_name = 'ty';
				break;
				case 'uighur':
					$lang_name = 'ug';
				break;
				case 'ukrainian':
					$lang_name = 'uk';
				break;
				case 'urdu':
					$lang_name = 'ur';
				break;
				case 'uzbek':
					$lang_name = 'uz';
				break;
				case 'venda':
					$lang_name = 've';
				break;
				case 'vietnamese':
					$lang_name = 'vi';
				break;
				case 'volapuk':
					$lang_name = 'vo';
				break;
				case 'walloon':
					$lang_name = 'wa';
				break;
				case 'wolof':
					$lang_name = 'wo';
				break;
				case 'xhosa':
					$lang_name = 'xh';
				break;
				case 'yiddish':
					$lang_name = 'yi';
				break;
				case 'yoruba':
					$lang_name = 'yo';
				break;
				case 'zhuang':
					$lang_name = 'za';
				break;
				case 'chinese':
					$lang_name = 'zh';
				break;
				case 'chinese_simplified':
					$lang_name = 'zh_cmn_hans';
				break;
				case 'chinese_traditional':
					$lang_name = 'zh_cmn_hant';
				break;
				case 'zulu':
					$lang_name = 'zu';
				break;
				default:
					$lang_name = $lang;
					break;
			}
		return $lang_name;
	}

	/**
	 * decode_lang
	 *
	 * $default_lang = $mx_user->decode_lang($board_config['default_lang']);
	 *
	 * @param unknown_type $lang
	 * @return unknown
	 */
	function decode_lang($lang)
	{
		return $lang;
	}
}

//
// Append $SID to a url. Borrowed from phplib and modified. This is an
// extra routine utilised by the session code above and acts as a wrapper
// around every single URL and form action. If you replace the session
// code you must include this routine, even if it's empty.
//
function append_sid($url, $non_html_amp = false)
{
	global $SID;

	if ( !empty($SID) && !preg_match('#sid=#', $url) )
	{
		$url .= ( ( strpos($url, '?') !== false ) ?  ( ( $non_html_amp ) ? '&' : '&amp;' ) : '?' ) . $SID;
	}

	return $url;
}

/**
 * Break the url into pieces
 *
 * Gets the domain and path for the cookie
 *
 * @param  bool $local whether local cookies are on
 * @param  bool $global whether global cookies are on
 * @return array with domain and path for the cookie to set using
 * @since smf  0.1.0
 */
function url_parts($local, $global)
{

	// parse the URL with PHP to make life easier
	$parsed_url = parse_url(BOARD_URL);

	// are local cookies off?
	if (empty($parsed_url['path']) || !$local)
	{
		$parsed_url['path'] = '';
    }

	// globalize cookies across domains (filter out IP-addresses)?
	if ($global && preg_match('~^\d{1,3}(\.\d{1,3}){3}$~', $parsed_url['host']) == 0 && preg_match('~(?:[^\.]+\.)?([^\.]{2,}\..+)\z~i', $parsed_url['host'], $parts) == 1)
	{
	    $parsed_url['host'] = '.' . $parts[1];
    }
    // we shouldn't use a host at all if both options are off
	elseif (!$local && !$global) 
	{
		$parsed_url['host'] = '';
    }
	// the host also shouldn't be set if there aren't any dots in it
	elseif (!isset($parsed_url['host']) || strpos($parsed_url['host'], '.') === false) 
	{
		$parsed_url['host'] = '';
    }

	return array($parsed_url['host'], $parsed_url['path'] . '/');
}

?>