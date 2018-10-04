<?php
/**
*
* @package Style
* @version $Id: session.php,v 1.14 2008/07/12 20:24:15 jonohlsson Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team & (C) 2001 The phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
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

		//
		// Simulate the user lang setting
		//
		$this->data['user_lang'] = $portal_config['default_lang'];
		$this->data['user_dateformat'] = $portal_config['user_dateformat'];
		$this->data['user_timezone'] = $portal_config['user_timezone'];

		//
		// Populate session_id
		//
		$this->session_id = $this->data['session_id'];
	}

	//
	// Adds/updates a new session to the database for the given userid.
	// Returns the new session ID on success.
	//
	function session_begin($user_id, $user_ip, $page_id, $auto_create = 0, $enable_autologin = 0, $admin = 0)
	{
		global $db, $board_config, $mx_backend;
		global $mx_request_vars, $SID;

		$cookiename = $board_config['cookie_name'];
		$cookiepath = $board_config['cookie_path'];
		$cookiedomain = $board_config['cookie_domain'];
		$cookiesecure = $board_config['cookie_secure'];

		if ( isset($_COOKIE[$cookiename . '_sid']) || isset($_COOKIE[$cookiename . '_data']) )
		{
			$session_id = isset($_COOKIE[$cookiename . '_sid']) ? $_COOKIE[$cookiename . '_sid'] : '';
			$sessiondata = isset($_COOKIE[$cookiename . '_data']) ? unserialize(stripslashes($_COOKIE[$cookiename . '_data'])) : array();
			$sessionmethod = SESSION_METHOD_COOKIE;
		}
		else
		{
			$sessiondata = array();
			$session_id = $mx_request_vars->get('sid', mztnt);
			$sessionmethod = SESSION_METHOD_GET;
		}

		//
		if (!preg_match('/^[A-Za-z0-9]*$/', $session_id))
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

		if ($user_id != ANONYMOUS)
		{
			if (isset($sessiondata['autologinid']) && (string) $sessiondata['autologinid'] != '' && $user_id)
			{
				$sql = 'SELECT u.*
					FROM ' . USERS_TABLE . ' u, ' . SESSIONS_KEYS_TABLE . ' k
					WHERE u.user_id = ' . (int) $user_id . "
						AND u.user_active = 1
						AND k.user_id = u.user_id
						AND k.key_id = '" . md5($sessiondata['autologinid']) . "'";
				if (!($result = $db->sql_query($sql)))
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
						AND user_active = 1';
				if (!($result = $db->sql_query($sql)))
				{
					mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
				}

				$userdata = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$login = 1;
			}
		}

		//
		// At this point either $userdata should be populated or
		// one of the below is true
		// * Key didn't match one in the DB
		// * User does not exist
		// * User is inactive
		//
		if (!sizeof($userdata) || !is_array($userdata) || !$userdata)
		{
			$sessiondata['autologinid'] = '';
			$sessiondata['userid'] = $user_id = ANONYMOUS;
			$enable_autologin = $login = 0;

			$sql = 'SELECT *
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . (int) $user_id;
			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
			}

			$userdata = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		}


		//
		// Initial ban check against user id, IP and email address
		//
		/*
		preg_match('/(..)(..)(..)(..)/', $user_ip, $user_ip_parts);

		$sql = "SELECT ban_ip, ban_userid, ban_email
			FROM " . BANLIST_TABLE . "
			WHERE ban_ip IN ('" . $user_ip_parts[1] . $user_ip_parts[2] . $user_ip_parts[3] . $user_ip_parts[4] . "', '" . $user_ip_parts[1] . $user_ip_parts[2] . $user_ip_parts[3] . "ff', '" . $user_ip_parts[1] . $user_ip_parts[2] . "ffff', '" . $user_ip_parts[1] . "ffffff')
				OR ban_userid = $user_id";
		if ( $user_id != ANONYMOUS )
		{
			$sql .= " OR ban_email LIKE '" . str_replace("\'", "''", $userdata['user_email']) . "'
				OR ban_email LIKE '" . substr(str_replace("\'", "''", $userdata['user_email']), strpos(str_replace("\'", "''", $userdata['user_email']), "@")) . "'";
		}
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(CRITICAL_ERROR, 'Could not obtain ban information', '', __LINE__, __FILE__, $sql);
		}

		if ( $ban_info = $db->sql_fetchrow($result) )
		{
			if ( $ban_info['ban_ip'] || $ban_info['ban_userid'] || $ban_info['ban_email'] )
			{
				mx_message_die(CRITICAL_MESSAGE, 'You_been_banned');
			}
		}
		*/

		//
		// Create or update the session
		//
		$sql = "UPDATE " . SESSIONS_TABLE . "
			SET session_user_id = $user_id, session_start = $current_time, session_time = $current_time, session_page = $page_id, session_logged_in = $login, session_admin = $admin
			WHERE session_id = '" . $session_id . "'
				AND session_ip = '$user_ip'";
		if ( !$db->sql_query($sql) || !$db->sql_affectedrows() )
		{
			$session_id = md5($mx_backend->dss_rand());

			$sql = "INSERT INTO " . SESSIONS_TABLE . "
				(session_id, session_user_id, session_start, session_time, session_ip, session_page, session_logged_in, session_admin)
				VALUES ('$session_id', $user_id, $current_time, $current_time, '$user_ip', $page_id, $login, $admin)";
			if ( !$db->sql_query($sql) )
			{
				mx_message_die(CRITICAL_ERROR, 'Error creating new session', '', __LINE__, __FILE__, $sql);
			}
		}

		if ( $user_id != ANONYMOUS )
		{
			$last_visit = ( $userdata['user_session_time'] > 0 ) ? $userdata['user_session_time'] : $current_time;

			if (!$admin)
			{
				$sql = "UPDATE " . USERS_TABLE . "
					SET user_session_time = $current_time, user_session_page = $page_id, user_lastvisit = $last_visit
					WHERE user_id = $user_id";
				if ( !$db->sql_query($sql) )
				{
					mx_message_die(CRITICAL_ERROR, 'Error updating last visit time', '', __LINE__, __FILE__, $sql);
				}
			}

			$userdata['user_lastvisit'] = $last_visit;

			//
			// Regenerate the auto-login key
			//
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
				$sessiondata['autologinid'] = '';
			}

	//		$sessiondata['autologinid'] = (!$admin) ? (( $enable_autologin && $sessionmethod == SESSION_METHOD_COOKIE ) ? $auto_login_key : '') : $sessiondata['autologinid'];
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

		setcookie($cookiename . '_data', serialize($sessiondata), $current_time + 31536000, $cookiepath, $cookiedomain, $cookiesecure);
		setcookie($cookiename . '_sid', $session_id, 0, $cookiepath, $cookiedomain, $cookiesecure);

		$SID = 'sid=' . $session_id;

		return $userdata;
	}

	//
	// Checks for a given user session, tidies session table and updates user
	// sessions at each page refresh
	//
	function session_pagestart($user_ip, $thispage_id)
	{
		global $db, $lang, $board_config;
		global $mx_request_vars, $SID;

		$cookiename = $board_config['cookie_name'];
		$cookiepath = $board_config['cookie_path'];
		$cookiedomain = $board_config['cookie_domain'];
		$cookiesecure = $board_config['cookie_secure'];

		$current_time = time();
		unset($userdata);

		if ( isset($_COOKIE[$cookiename . '_sid']) || isset($_COOKIE[$cookiename . '_data']) )
		{
			$sessiondata = isset( $_COOKIE[$cookiename . '_data'] ) ? unserialize(stripslashes($_COOKIE[$cookiename . '_data'])) : array();
			$session_id = isset( $_COOKIE[$cookiename . '_sid'] ) ? $_COOKIE[$cookiename . '_sid'] : '';
			$sessionmethod = SESSION_METHOD_COOKIE;
		}
		else
		{
			$sessiondata = array();
			$session_id = $mx_request_vars->get('sid',MX_TYPE_NO_TAGS);
			$sessionmethod = SESSION_METHOD_GET;
		}

		//
		if (!preg_match('/^[A-Za-z0-9]*$/', $session_id))
		{
			$session_id = '';
		}

		$thispage_id = (int) $thispage_id;

		//
		// Does a session exist?
		//
		if ( !empty($session_id) )
		{
			//
			// session_id exists so go ahead and attempt to grab all
			// data in preparation
			//
			$sql = "SELECT u.*, s.*
				FROM " . SESSIONS_TABLE . " s, " . USERS_TABLE . " u
				WHERE s.session_id = '$session_id'
					AND u.user_id = s.session_user_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Error doing DB query userdata row fetch', '', __LINE__, __FILE__, $sql);
			}

			$userdata = $db->sql_fetchrow($result);

			//
			// Did the session exist in the DB?
			//
			if ( isset($userdata['user_id']) )
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
						$update_admin = (!defined('IN_ADMIN') && $current_time - $userdata['session_time'] > ($board_config['session_length']+60)) ? ', session_admin = 0' : '';

						$sql = "UPDATE " . SESSIONS_TABLE . "
							SET session_time = $current_time, session_page = $thispage_id$update_admin
							WHERE session_id = '" . $userdata['session_id'] . "'";
						if ( !$db->sql_query($sql) )
						{
							mx_message_die(CRITICAL_ERROR, 'Error updating sessions table', '', __LINE__, __FILE__, $sql);
						}

						if ( $userdata['user_id'] != ANONYMOUS )
						{
							$sql = "UPDATE " . USERS_TABLE . "
								SET user_session_time = $current_time, user_session_page = $thispage_id
								WHERE user_id = " . $userdata['user_id'];
							if ( !$db->sql_query($sql) )
							{
								mx_message_die(CRITICAL_ERROR, 'Error updating sessions table', '', __LINE__, __FILE__, $sql);
							}
						}

						$this->session_clean($userdata['session_id']);

						setcookie($cookiename . '_data', serialize($sessiondata), $current_time + 31536000, $cookiepath, $cookiedomain, $cookiesecure);
						setcookie($cookiename . '_sid', $session_id, 0, $cookiepath, $cookiedomain, $cookiesecure);
					}

					// Add the session_key to the userdata array if it is set
					if ( isset($sessiondata['autologinid']) && $sessiondata['autologinid'] != '' )
					{
						$userdata['session_key'] = $sessiondata['autologinid'];
					}

					return $userdata;
				}
			}
		}

		//
		// If we reach here then no (valid) session exists. So we'll create a new one,
		// using the cookie user_id if available to pull basic user prefs.
		//
		$user_id = ( isset($sessiondata['userid']) ) ? intval($sessiondata['userid']) : ANONYMOUS;

		if ( !($userdata = $this->session_begin($user_id, $user_ip, $thispage_id, TRUE)) )
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
			WHERE session_id = '$session_id'
				AND session_user_id = $user_id";
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
				WHERE user_id = ' . (int) $user_id . "
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
			WHERE user_id = ' . ANONYMOUS;
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error obtaining user details', '', __LINE__, __FILE__, $sql);
		}
		if ( !($userdata = $db->sql_fetchrow($result)) )
		{
			mx_message_die(CRITICAL_ERROR, 'Error obtaining user details', '', __LINE__, __FILE__, $sql);
		}
		$db->sql_freeresult($result);


		setcookie($cookiename . '_data', '', $current_time - 31536000, $cookiepath, $cookiedomain, $cookiesecure);
		setcookie($cookiename . '_sid', '', $current_time - 31536000, $cookiepath, $cookiedomain, $cookiesecure);

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
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . '
			WHERE session_time < ' . (time() - (int) $board_config['session_length']) . "
				AND session_id <> '$session_id'";
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
			$sessiondata['userid'] = $user_id;
			$sessiondata['autologinid'] = $auto_login_key;
			$cookiename = $board_config['cookie_name'];
			$cookiepath = $board_config['cookie_path'];
			$cookiedomain = $board_config['cookie_domain'];
			$cookiesecure = $board_config['cookie_secure'];

			setcookie($cookiename . '_data', serialize($sessiondata), $current_time + 31536000, $cookiepath, $cookiedomain, $cookiesecure);

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
		global $mx_request_vars, $portal_config; //added for mxp

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
	 * encode_lang
	 *
	 * $default_lang = $mx_user->encode_lang($board_config['default_lang']);
	 *
	 * @param unknown_type $lang
	 * @return unknown
	 */
	function encode_lang($lang)
	{
		return $lang;
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
?>