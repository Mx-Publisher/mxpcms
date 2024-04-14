<?php
/**
*
* @package Auth
*
* @copyright (c) 2002-2024 MX-Publisher Project Team
* @license GNU General Public License, version 2 (GPL-2.0)
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
* @link http://github.com/MX-Publisher
*/

if (!defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

/**
* Database authentication provider for phpBB3
* This is for authentication via the integrated user table
 * 
 * Ported to MXP-CMS by FlorinCB in 19.12.2018
 *
 * Modifications Credits:
 *		- replaced \phpbb\auth\provider\base -> phpbb_auth_base
 *		- replaced $config -> $board_config - by Jon
 *		- replaced $request -> $mx_request_vars - by Ory
 *		- replaced $cache = new mx_nothing(); to disable bots() - by Jon
  *	- replaced $user -> $mx_user by - Ory
 *		- removed '?' in the returned $SID string - by Jon
 *		- in function setup()
 *			$auth -> $phpbb_auth - by Ory
 *			-new globals:  $mx_root_path, $mx_cache - by Ory
 *			$this->lang_name was redefined to use in
 *			worst case the new $board_config['phpbb_lang']
 *			wich was defined in mx_functions_style.php
 *			before lang name is expanded - by Ory
 *			$template = new mx_Template(); - by Ory
 *			- before $this->add_lang($lang_set); the phpBB common language is included
 *			if fails with $phpbb_root_path added
 *		- in function set_lang()
 *			- if empty $this->lang_path will be redefined
 *			from $phpbb_root_path and new $board_config['phpbb_lang']
 *			wich in this case are set as globals - by Ory
 *			(similar check has been added in the phpBB3 version too)
 *		- added function images() to help redefining $images var
 *		and indexes were is needed - by Ory
 */

class db extends phpbb_auth_base
{
	
	/**
	* DI container
	*
	* @var \Symfony\Component\DependencyInjection\ContainerInterface
	*/
	//protected $phpbb_container;

	/**
	* phpBB passwords manager
	*
	* @var \phpbb\passwords\manager
	*/
	//protected $passwords_manager;

	/**
	 * Database Authentication Constructor
	 *
	 * @param	\phpbb\db\driver\driver_interface		$db
	 * @param	\phpbb\config\config 		$config
	 * @param	\phpbb\passwords\manager	$passwords_manager
	 * @param	\phpbb\request\request		$request
	 * @param	\phpbb\user			$user
	 * @param	\Symfony\Component\DependencyInjection\ContainerInterface $phpbb_container DI container
	 * @param	string				$phpbb_root_path
	 * @param	string				$php_ext
	
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\passwords\manager $passwords_manager, \phpbb\request\request $request, \phpbb\user $user, \Symfony\Component\DependencyInjection\ContainerInterface $phpbb_container, $phpbb_root_path, $php_ext)
	{
		$this->db = $db;
		$this->config = $config;
		$this->passwords_manager = $passwords_manager;
		$this->request = $request;
		$this->user = $user;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->phpbb_container = $phpbb_container;
	}
	 */
	 
	public function db()
	{
		global $db, $board_config, $mx_request_vars, $mx_user, $mx_root_path, $phpbb_root_path, $phpEx;
		$this->db = $db;
		$this->config = $board_config;
		//$this->passwords_manager = $passwords_manager;
		$this->request = $mx_request_vars;
		$this->user = $mx_user;
		$this->mx_root_path = $phpbb_root_path;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $phpEx;
		//$this->phpbb_container = $phpbb_container;
	}

	/**
	 * Checks whether the user is currently identified to the authentication
	 * provider.
	 * Called in acp_board while setting authentication plugins.
	 * Changing to an authentication provider will not be permitted in acp_board
	 * if there is an error.
	 *
	 * @return 	boolean|string 	False if the user is identified, otherwise an
	 *							error message, or null if not implemented.
	 */
	public function init()
	{
		return;
	}

	/**
	 * Performs login.
	 *
	 * @param	string	$username 	The name of the user being authenticated.
	 * @param	string	$password	The password of the user.
	 * @return	array	An associative array of the format:
	 *						array(
	 *							'status' => status constant
	 *							'error_msg' => string
	 *							'user_row' => array
	 *						)
	 *					A fourth key of the array may be present:
	 *					'redirect_data'	This key is only used when 'status' is
	 *					equal to LOGIN_SUCCESS_LINK_PROFILE and its value is an
	 *					associative array that is turned into GET variables on
	 *					the redirect url.
	 * phpbb_auth_base::login($username, $password, $autologin = false, $viewonline = 1, $admin = 0)
	 */
	public function login($username, $password, $autologin = false, $viewonline = 1, $admin = 0)
	{
		// Auth plugins get the password untrimmed.
		// For compatibility we trim() here.
		$password = trim($password);

		// do not allow empty password
		if (!$password)
		{
			return array(
				'status'	=> LOGIN_ERROR_PASSWORD,
				'error_msg'	=> 'NO_PASSWORD_SUPPLIED',
				'user_row'	=> array('user_id' => ANONYMOUS),
			);
		}

		if (!$username)
		{
			return array(
				'status'	=> LOGIN_ERROR_USERNAME,
				'error_msg'	=> 'LOGIN_ERROR_USERNAME',
				'user_row'	=> array('user_id' => ANONYMOUS),
			);
		}

		$username_clean = utf8_clean_string($username);

		$sql = 'SELECT *
			FROM ' . USERS_TABLE . "
			WHERE username_clean = '" . $this->db->sql_escape($username_clean) . "'";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (($this->user->ip && !$this->config['ip_login_limit_use_forwarded']) ||
			($this->user->forwarded_for && $this->config['ip_login_limit_use_forwarded']))
		{
			$sql = 'SELECT COUNT(*) AS attempts
				FROM ' . LOGIN_ATTEMPT_TABLE . '
				WHERE attempt_time > ' . (time() - (int) $this->config['ip_login_limit_time']);
			if ($this->config['ip_login_limit_use_forwarded'])
			{
				$sql .= " AND attempt_forwarded_for = '" . $this->db->sql_escape($this->user->forwarded_for) . "'";
			}
			else
			{
				$sql .= " AND attempt_ip = '" . $this->db->sql_escape($this->user->ip) . "' ";
			}

			$result = $this->db->sql_query($sql);
			$attempts = (int) $this->db->sql_fetchfield('attempts');
			$this->db->sql_freeresult($result);

			$attempt_data = array(
				'attempt_ip'			=> $this->user->ip,
				'attempt_browser'		=> trim(substr($this->user->browser, 0, 149)),
				'attempt_forwarded_for'	=> $this->user->forwarded_for,
				'attempt_time'			=> time(),
				'user_id'				=> ($row) ? (int) $row['user_id'] : 0,
				'username'				=> $username,
				'username_clean'		=> $username_clean,
			);
			$sql = 'INSERT INTO ' . LOGIN_ATTEMPT_TABLE . $this->db->sql_build_array('INSERT', $attempt_data);
			$this->db->sql_query($sql);
		}
		else
		{
			$attempts = 0;
		}

		if (!$row)
		{
			if ($this->config['ip_login_limit_max'] && $attempts >= $this->config['ip_login_limit_max'])
			{
				return array(
					'status'		=> LOGIN_ERROR_ATTEMPTS,
					'error_msg'		=> 'LOGIN_ERROR_ATTEMPTS',
					'user_row'		=> array('user_id' => ANONYMOUS),
				);
			}

			return array(
				'status'	=> LOGIN_ERROR_USERNAME,
				'error_msg'	=> 'LOGIN_ERROR_USERNAME',
				'user_row'	=> array('user_id' => ANONYMOUS),
			);
		}

		$show_captcha = ($this->config['max_login_attempts'] && $row['user_login_attempts'] >= $this->config['max_login_attempts']) ||
			($this->config['ip_login_limit_max'] && $attempts >= $this->config['ip_login_limit_max']);

		// If there are too many login attempts, we need to check for a confirm image
		// Every auth module is able to define what to do by itself...
		if ($show_captcha)
		{
			/* @var $captcha_factory \phpbb\captcha\factory */
			$captcha_factory = $this->phpbb_container->get('captcha.factory');
			$captcha = $captcha_factory->get_instance($this->config['captcha_plugin']);
			$captcha->init(CONFIRM_LOGIN);
			$vc_response = $captcha->validate($row);
			if ($vc_response)
			{
				return array(
					'status'		=> LOGIN_ERROR_ATTEMPTS,
					'error_msg'		=> 'LOGIN_ERROR_ATTEMPTS',
					'user_row'		=> $row,
				);
			}
			else
			{
				$captcha->reset();
			}

		}

		// Check password ...
		if ($this->passwords_manager->check($password, $row['user_password'], $row))
		{
			// Check for old password hash...
			if ($this->passwords_manager->convert_flag || strlen($row['user_password']) == 32)
			{
				$hash = $this->passwords_manager->hash($password);

				// Update the password in the users table to the new format
				$sql = 'UPDATE ' . USERS_TABLE . "
					SET user_password = '" . $this->db->sql_escape($hash) . "'
					WHERE user_id = {$row['user_id']}";
				$this->db->sql_query($sql);

				$row['user_password'] = $hash;
			}

			$sql = 'DELETE FROM ' . LOGIN_ATTEMPT_TABLE . '
				WHERE user_id = ' . $row['user_id'];
			$this->db->sql_query($sql);

			if ($row['user_login_attempts'] != 0)
			{
				// Successful, reset login attempts (the user passed all stages)
				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_login_attempts = 0
					WHERE user_id = ' . $row['user_id'];
				$this->db->sql_query($sql);
			}

			// User inactive...
			if ($row['user_type'] == USER_INACTIVE || $row['user_type'] == USER_IGNORE)
			{
				return array(
					'status'		=> LOGIN_ERROR_ACTIVE,
					'error_msg'		=> 'ACTIVE_ERROR',
					'user_row'		=> $row,
				);
			}

			// Successful login... set user_login_attempts to zero...
			return array(
				'status'		=> LOGIN_SUCCESS,
				'error_msg'		=> false,
				'user_row'		=> $row,
			);
		}

		// Password incorrect - increase login attempts
		$sql = 'UPDATE ' . USERS_TABLE . '
			SET user_login_attempts = user_login_attempts + 1
			WHERE user_id = ' . (int) $row['user_id'] . '
				AND user_login_attempts < ' . LOGIN_ATTEMPTS_MAX;
		$this->db->sql_query($sql);

		// Give status about wrong password...
		return array(
			'status'		=> ($show_captcha) ? LOGIN_ERROR_ATTEMPTS : LOGIN_ERROR_PASSWORD,
			'error_msg'		=> 'LOGIN_ERROR_PASSWORD',
			'user_row'		=> $row,
		);
	}

	/**
	 * Autologin function
	 *
	 * @return 	array|null	containing the user row, empty if no auto login
	 * 						should take place, or null if not impletmented.
	 */
	public function autologin()
	{
		return;
	}

	/**
	 * This function is used to output any required fields in the authentication
	 * admin panel. It also defines any required configuration table fields.
	 *
	 * @return	array|null	Returns null if not implemented or an array of the
	 *						configuration fields of the provider.
	 */
	public function acp()
	{
		return;
	}

	/**
	 * This function updates the template with variables related to the acp
	 * options with whatever configuraton values are passed to it as an array.
	 * It then returns the name of the acp file related to this authentication
	 * provider.
	 * @param	array	$new_config Contains the new configuration values that
	 *								have been set in acp_board.
	 * @return	array|null		Returns null if not implemented or an array with
	 *							the template file name and an array of the vars
	 *							that the template needs that must conform to the
	 *							following example:
	 *							array(
	 *								'TEMPLATE_FILE'	=> string,
	 *								'TEMPLATE_VARS'	=> array(...),
	 *							)
	 *							An optional third element may be added to this
	 *							array: 'BLOCK_VAR_NAME'. If this is present,
	 *							then its value should be a string that is used
	 *							to designate the name of the loop used in the
	 *							ACP template file. When this is present, an
	 *							additional key named 'BLOCK_VARS' is required.
	 *							This must be an array containing at least one
	 *							array of variables that will be assigned during
	 *							the loop in the template. An example of this is
	 *							presented below:
	 *							array(
	 *								'BLOCK_VAR_NAME'	=> string,
	 *								'BLOCK_VARS'		=> array(
	 *									'KEY IS UNIMPORTANT' => array(...),
	 *								),
	 *								'TEMPLATE_FILE'	=> string,
	 *								'TEMPLATE_VARS'	=> array(...),
	 *							)
	 */
	public function get_acp_template($new_config)
	{
		return array(
			'TEMPLATE_FILE'	=> 'auth_provider_ldap.html',
			'TEMPLATE_VARS'	=> array(
				'AUTH_LDAP_BASE_DN'		=> $new_config['ldap_base_dn'],
				'AUTH_LDAP_EMAIL'		=> $new_config['ldap_email'],
				'AUTH_LDAP_PASSORD'		=> $new_config['ldap_password'] !== '' ? '********' : '',
				'AUTH_LDAP_PORT'		=> $new_config['ldap_port'],
				'AUTH_LDAP_SERVER'		=> $new_config['ldap_server'],
				'AUTH_LDAP_UID'			=> $new_config['ldap_uid'],
				'AUTH_LDAP_USER'		=> $new_config['ldap_user'],
				'AUTH_LDAP_USER_FILTER'	=> $new_config['ldap_user_filter'],
			),
		);
	}

	/**
	* Returns an array of data necessary to build custom elements on the login
	* form.
	*
	* @return	array|null	If this function is not implemented on an auth
	*						provider then it returns null. If it is implemented
	*						it will return an array of up to four elements of
	*						which only 'TEMPLATE_FILE'. If 'BLOCK_VAR_NAME' is
	*						present then 'BLOCK_VARS' must also be present in
	*						the array. The fourth element 'VARS' is also
	*						optional. The array, with all four elements present
	*						looks like the following:
	*						array(
	*							'TEMPLATE_FILE'		=> string,
	*							'BLOCK_VAR_NAME'	=> string,
	*							'BLOCK_VARS'		=> array(...),
	*							'VARS'				=> array(...),
	*						)
	*/
	public function get_login_data($data, $new_session)
	{
		return;
	}

	
	/**
	* Returns an array of data necessary to build the ucp_auth_link page
	*
	* @param int $user_id User ID for whom the data should be retrieved.
	*						defaults to 0, which is not a valid ID. The method
	*						should fall back to the current user's ID in this
	*						case.
	* @return	array|null	If this function is not implemented on an auth
	*						provider then it returns null. If it is implemented
	*						it will return an array of up to four elements of
	*						which only 'TEMPLATE_FILE'. If 'BLOCK_VAR_NAME' is
	*						present then 'BLOCK_VARS' must also be present in
	*						the array. The fourth element 'VARS' is also
	*						optional. The array, with all four elements present
	*						looks like the following:
	*						array(
	*							'TEMPLATE_FILE'		=> string,
	*							'BLOCK_VAR_NAME'	=> string,
	*							'BLOCK_VARS'		=> array(...),
	*							'VARS'				=> array(...),
	*						)
	*/
	public function get_auth_link_data($user_id = 0)
	{
		return;
	}

	/**
	 * Performs additional actions during logout.
	 *
	 * @param 	array	$data			An array corresponding to
	 *									\phpbb\session::data
	 * @param 	boolean	$new_session	True for a new session, false for no new
	 *									session.
	 */
	public function logout($data, $new_session)
	{
		return;
	}

	/**
	 * The session validation function checks whether the user is still logged
	 * into phpBB.
	 *
	 * @param 	array 	$user
	 * @return 	boolean	true if the given user is authenticated, false if the
	 * 					session should be closed, or null if not implemented.
	 */
	public function validate_session($user)
	{
		return null;
	}

	/**
	* Checks to see if $login_link_data contains all information except for the
	* user_id of an account needed to successfully link an external account to
	* a forum account.
	*
	* @param	array	$login_link_data	Any data needed to link a phpBB account to
	*								an external account.
	* @return	string|null	Returns a string with a language constant if there
	*						is data missing or null if there is no error.
	*/
	public function login_link_has_necessary_data($login_link_data)
	{
		return null;
	}

	/**
	* Links an external account to a phpBB account.
	*
	* @param	array	$link_data	Any data needed to link a phpBB account to
	*								an external account.
	*/
	public function link_account(array $link_data)
	{
		return null;
	}

	/**
	* Unlinks an external account from a phpBB account.
	*
	* @param	array	$link_data	Any data needed to unlink a phpBB account
	*								from a phpbb account.
	*/
	public function unlink_account(array $link_data)
	{
		return;
	}
}
