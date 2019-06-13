<?php
/**
*
* @package Auth
*
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license GNU General Public License, version 2 (GPL-2.0)
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if (!defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

/**
* Apache authentication provider for phpBB3
* 
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

class apache extends phpbb_auth_base
{
	
	/**
	* phpBB passwords manager
	*
	* @var \phpbb\passwords\manager
	*/
	protected $passwords_manager;


	/**
	 * Apache Authentication Constructor
	 *
	 * @param	\phpbb\db\driver\driver_interface 	$db		Database object
	 * @param	\phpbb\config\config 		$config		Config object
	 * @param	\phpbb\passwords\manager	$passwords_manager		Passwords Manager object
	 * @param	\phpbb\request\request 		$request		Request object
	 * @param	\phpbb\user 			$user		User object
	 * @param	string 				$phpbb_root_path		Relative path to phpBB root
	 * @param	string 				$php_ext		PHP file extension
	 
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\passwords\manager $passwords_manager, \phpbb\request\request $request, \phpbb\user $user, $phpbb_root_path, $php_ext)
	{
		$this->db = $db;
		$this->config = $config;
		$this->passwords_manager = $passwords_manager;
		$this->request = $request;
		$this->user = $user;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}
	 */

	public function apache()
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
		if (!$this->request->is_set('PHP_AUTH_USER', \phpbb\request\request_interface::SERVER) || $this->user->data['username'] !== htmlspecialchars_decode($this->request->server('PHP_AUTH_USER')))
		{
			return $this->user->lang['APACHE_SETUP_BEFORE_USE'];
		}
		return false;
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
	 */
	public function login($username, $password)
	{
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

		if (!$this->request->is_set('PHP_AUTH_USER', \phpbb\request\request_interface::SERVER))
		{
			return array(
				'status'		=> LOGIN_ERROR_EXTERNAL_AUTH,
				'error_msg'		=> 'LOGIN_ERROR_EXTERNAL_AUTH_APACHE',
				'user_row'		=> array('user_id' => ANONYMOUS),
			);
		}

		$php_auth_user = htmlspecialchars_decode($this->request->server('PHP_AUTH_USER'));
		$php_auth_pw = htmlspecialchars_decode($this->request->server('PHP_AUTH_PW'));

		if (!empty($php_auth_user) && !empty($php_auth_pw))
		{
			if ($php_auth_user !== $username)
			{
				return array(
					'status'	=> LOGIN_ERROR_USERNAME,
					'error_msg'	=> 'LOGIN_ERROR_USERNAME',
					'user_row'	=> array('user_id' => ANONYMOUS),
				);
			}

			$sql = 'SELECT user_id, username, user_password, user_passchg, user_email, user_type
				FROM ' . USERS_TABLE . "
				WHERE username = '" . $this->db->sql_escape($php_auth_user) . "'";
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($row)
			{
				// User inactive...
				if ($row['user_type'] == USER_INACTIVE || $row['user_type'] == USER_IGNORE)
				{
					return array(
						'status'		=> LOGIN_ERROR_ACTIVE,
						'error_msg'		=> 'ACTIVE_ERROR',
						'user_row'		=> $row,
					);
				}

				// Successful login...
				return array(
					'status'		=> LOGIN_SUCCESS,
					'error_msg'		=> false,
					'user_row'		=> $row,
				);
			}

			// this is the user's first login so create an empty profile
			return array(
				'status'		=> LOGIN_SUCCESS_CREATE_PROFILE,
				'error_msg'		=> false,
				'user_row'		=> $this->user_row($php_auth_user, $php_auth_pw),
			);
		}

		// Not logged into apache
		return array(
			'status'		=> LOGIN_ERROR_EXTERNAL_AUTH,
			'error_msg'		=> 'LOGIN_ERROR_EXTERNAL_AUTH_APACHE',
			'user_row'		=> array('user_id' => ANONYMOUS),
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
		if (!$this->request->is_set('PHP_AUTH_USER', \phpbb\request\request_interface::SERVER))
		{
			return array();
		}

		$php_auth_user = htmlspecialchars_decode($this->request->server('PHP_AUTH_USER'));
		$php_auth_pw = htmlspecialchars_decode($this->request->server('PHP_AUTH_PW'));

		if (!empty($php_auth_user) && !empty($php_auth_pw))
		{
			set_var($php_auth_user, $php_auth_user, 'string', true);
			set_var($php_auth_pw, $php_auth_pw, 'string', true);

			$sql = 'SELECT *
				FROM ' . USERS_TABLE . "
				WHERE username = '" . $this->db->sql_escape($php_auth_user) . "'";
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($row)
			{
				return ($row['user_type'] == USER_INACTIVE || $row['user_type'] == USER_IGNORE) ? array() : $row;
			}

			if (!function_exists('user_add'))
			{
				include($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
			}

			// create the user if he does not exist yet
			user_add($this->user_row($php_auth_user, $php_auth_pw));

			$sql = 'SELECT *
				FROM ' . USERS_TABLE . "
				WHERE username_clean = '" . $this->db->sql_escape(utf8_clean_string($php_auth_user)) . "'";
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($row)
			{
				return $row;
			}
		}

		return array();
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
		return;
	}

	/**
	 * This function generates an array which can be passed to the user_add
	 * function in order to create a user
	 *
	 * @param 	string	$username 	The username of the new user.
	 * @param 	string	$password 	The password of the new user.
	 * @return 	array 				Contains data that can be passed directly to
	 *								the user_add function.
	 */
	private function user_row($username, $password)
	{
		// first retrieve default group id
		$sql = 'SELECT group_id
			FROM ' . GROUPS_TABLE . "
			WHERE group_name = '" . $this->db->sql_escape('REGISTERED') . "'
				AND group_type = " . GROUP_SPECIAL;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row)
		{
			trigger_error('NO_GROUP');
		}

		// generate user account data
		return array(
			'username'		=> $username,
			'user_password'	=> $this->passwords_manager->hash($password),
			'user_email'	=> '',
			'group_id'		=> (int) $row['group_id'],
			'user_type'		=> USER_NORMAL,
			'user_ip'		=> $this->user->ip,
			'user_new'		=> ($this->config['new_member_post_limit']) ? 1 : 0,
		);
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
		// Check if PHP_AUTH_USER is set and handle this case
		if ($this->request->is_set('PHP_AUTH_USER', \phpbb\request\request_interface::SERVER))
		{
			$php_auth_user = $this->request->server('PHP_AUTH_USER');

			return ($php_auth_user === $user['username']) ? true : false;
		}

		// PHP_AUTH_USER is not set. A valid session is now determined by the user type (anonymous/bot or not)
		if ($user['user_type'] == USER_IGNORE)
		{
			return true;
		}

		return false;
	}
}
