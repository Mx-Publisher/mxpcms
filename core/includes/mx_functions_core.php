<?php
/**
*
* @package Core
* @version $Id: mx_functions_core.php,v 1.2 2009/01/24 16:47:51 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/**#@+
 * Class mx_cache specific definitions
 *
 */
define('MX_CACHE_ALL'			, -1);		// Flag - all
define('MX_CACHE_SINGLE'		, -2);		// Flag - single
define('MX_CACHE_PAGE_TYPE'		, -3);		// Flag - blocks data
define('MX_CACHE_BLOCK_TYPE'	, -4);		// Flag - pages data

define('MX_QUERY_DB'		, true);	// Flag - to force db query // not used
define('MX_CACHE_DEBUG'		, false);	// echo lots of debug info

define('MX_GET_ALL_PARS'	, -10);		// Flag - get all parameters
define('MX_GET_PAR_VALUE'	, -20);		// Flag - get parameter value
define('MX_GET_PAR_OPTIONS'	, -30);		// Flag - get parameter option
/**#@-*/

/**
 * Class: mx_cache.
 *
 * Wrappers for retrieving config, page and block data.
 *
 * The mx_cache class handles all page and block data to/from cache files and/or db.
 * The block and page data are either retrieved from cache or db queried (adminCP switch), or db query is forced using flag 'MX_QUERY_DB'.
 *
 * Examples:
 * - $block_config = $mx_cache->read( MX_BLOCK, $block_id );
 * - $page_config = $mx_cache->read( MX_PAGE, $page_id, [MX_QUERY_DB] ); // Force db query
 * - $mx_cache->update( MX_CACHE_ALL ); // All
 * - $mx_cache->update( MX_CACHE_BLOCK_TYPE, [$block_id] ); // Block [block_id]
 * - $mx_cache->update( MX_CACHE_PAGE_TYPE, [$page_id] ); // Page [page_id]
 *
 * @access public
 * @author Jon Ohlsson
 * @package mxBBcache
 *
 */
class mx_cache extends cache
{
	// ------------------------------
	// Private Methods
	//
	//
	/**
	* Creates a cache service around a cache driver
	*
	 * @return cache	
	*/
	public function __construct()
	{
		global $mx_root_path, $phpbb_root_path, $phpEx;
		global $db, $portal_config;
		global $mx_table_prefix, $table_prefix, $phpEx, $tplEx;
		global $mx_backend, $phpbb_auth, $mx_bbcode;		
		
		$this->path = $mx_root_path;
		$this->backend = $mx_backend;		
		$this->backend_path = $phpbb_root_path;		
		$this->db = $db;
		$this->config = $portal_config; 		
		$this->php_ex =	$phpEx; 
		$this->tpl_ex =	$tplEx;		
		$this->cache_dir = $mx_root_path . 'cache/';
		$this->prefix = $mx_table_prefix;  			
	}
	
	/**
	 * load_backend
	 *
	 * Define Users/Group/Sessions backend, and validate
	 * Set $portal_config, $phpbb_root_path, $tplEx, $table_prefix & PORTAL_BACKEND/$mx_backend
	 *
	 */
	public function load_backend()
	{
		global $portal_config, $mx_table_prefix, $table_prefix, $phpEx, $tplEx;
		global $mx_backend, $phpbb_auth, $mx_bbcode;	

		// Get MX-Publisher config settings $portal_config = $this->obtain_mxbb_config();
		
		// Check some vars
		if (!$portal_config['portal_version'])
		{
			$portal_config = $this->obtain_mxbb_config(false);
		}
		
		// Overwrite Backend
		$this->portal_config = $portal_config;
		
		if ($this->backend)
		{
			$portal_config['portal_backend'] = $this->backend;
		}
		
		// No backend defined ? Portal not updated to v. 3 ?
		if ((!$portal_config['portal_backend']) && @file_exists($this->phpbb_path . "profile.$phpEx"))
		{
			$portal_config['portal_backend'] = 'phpbb2';
			$portal_config['portal_backend_path'] = $this->backend_path;			
		}
		
		// No backend defined ? Try Internal.		
		if (!$portal_config['portal_backend'])
		{
			$portal_config['portal_backend'] = 'internal';
			$portal_config['portal_backend_path'] = $this->backend_path;			
		}
		// Load backend
		$mx_root_path = $this->path;
		$phpbb_root_path = $this->backend_path; 
		$phpEx = $this->php_ex;
		$tplEx = $this->tpl_ex;			
		require($this->path . 'includes/sessions/'.$portal_config['portal_backend'].'/core.'. $this->php_ex); 
		
		//Redirect to upgrade or redefine portal backend path
		if (!isset($portal_config['portal_backend_path']))
		{
			if(@file_exists($this->path . "install"))
			{
				// Redirect via an HTML form for PITA webservers
				if (@preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')))
				{
					header('Refresh: 0; URL=' . $this->path . "install/mx_install.$phpEx");
					echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . PORTAL_URL . $url . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . PORTAL_URL . $url . '">HERE</a> to be redirected</div></body></html>';
					exit;
				}

				// Behave as per HTTP/1.1 spec for others
				header('Location: ' . $this->path . "install/mx_install.$phpEx");
				exit;				
			}
			else
			{
				$portal_config['portal_backend_path'] = $this->path . 'includes/shared/phpbb2/';
			}						
		}
		
		// Instantiate the mx_backend class
		$mx_backend = new mx_backend();
		// Validate backend
		if (!$mx_backend->validate_backend())
		{
			// If backend setup is bad, revert to standalone/internal. Thus we can access the adminCP ;)
			define('PORTAL_BACKEND', 'internal');
			$phpbb_root_path = $this->path . 'includes/shared/phpbb2/';
			str_replace("//", "/", $phpbb_root_path);
			$tplEx ='tpl';
		}
		else
		{
			define('PORTAL_BACKEND', $portal_config['portal_backend']);
		}
		// Now, load backend specific constants
		require($mx_root_path  . 'includes/sessions/'.PORTAL_BACKEND.'/constants.' . $phpEx);
	}

	/**
	 * Enter description here...
	 *
	 * @access public
	 * @param boolean $use_cache
	 * @return unknown
	 */
	function obtain_phpbb_config($use_cache = true)
	{
		global $db;

		if (($config = $this->get('phpbb_config')) && $use_cache)
		{
			return $config;
		}
		else
		{
			$sql = "SELECT *
				FROM " . CONFIG_TABLE;

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt query config information', '', __LINE__, __FILE__, $sql );
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				$config[$row['config_name']] = $row['config_value'];
			}
			$db->sql_freeresult($result);

			if ($use_cache)
			{
				$this->put('phpbb_config', $config);
			}

			return ( $config );
		}
	}

	/**
	 * Get mxBB config data
	 *
	 * @access public
	 * @return unknown
	 */
	function obtain_mxbb_config($use_cache = true)
	{
		global $db;

		if ( ($config = $this->get('mxbb_config')) && ($use_cache) )
		{
			return $config;
		}
		else
		{
			$sql = "SELECT *
				FROM " . PORTAL_TABLE . "
				WHERE portal_id = '1'";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt query portal configuration', '', __LINE__, __FILE__, $sql );
			}

			$row = $db->sql_fetchrow( $result );
			foreach ( $row as $config_name => $config_value )
			{
				$config[$config_name] = trim( $config_value );
			}
			$db->sql_freeresult( $result );
			$this->put('mxbb_config', $config);
			return ( $config );
		}
	}
	/**
	* Obtain list of naughty words and build preg style replacement arrays for use by the
	* calling script
	*
	* * @return unknown
	*/
	public function obtain_word_list()
	{
		global $board_config, $mx_user, $db;

		if (!$mx_user->optionget('viewcensors') && $board_config['allow_nocensors'])
		{
			return array();
		}

		if (($censors = $this->get('_word_censors')) === false)
		{
			$sql = 'SELECT word, replacement
				FROM ' . WORDS_TABLE;
			$result = $db->sql_query($sql);

			$censors = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$censors['match'][] = '#(?<!\w)(' . str_replace('\*', '\w*?', preg_quote($row['word'], '#')) . ')(?!\w)#i';
				$censors['replace'][] = $row['replacement'];
			}
			$db->sql_freeresult($result);

			$this->put('_word_censors', $censors);
		}

		return $censors;
	}
	/**
	 * Load file.
	 *
	 * Load additional functions/classes.
	 *
	 * The $force_shared parameter will ensure we include the mxp shared version of the file.
	 * If you need to include a shared version from a different backend, pass this info.
	 *
	 * Examples
	 *
	 * mx_cache::load_file('functions_post'), will include the phpbb version of the file
	 * mx_cache::load_file('functions_post', true), will include the shared phpbb version of the file
	 * mx_cache::load_file('functions_post', 'phpbb2'), will include the shared phpbb2 version of the file, even though we are running in internal/phpbb3 mode
	 *
	 * @param unknown_type $file
	 * @param unknown_type $backend
	 * @param unknown_type $force_shared
	 */
	function load_file($file = '', $force_shared = false)
	{
		global $mx_root_path, $phpbb_root_path, $phpEx;

		/** /
		$path = PORTAL_BACKEND == 'internal' || $force_shared ? $mx_root_path . 'includes/shared/' . PORTAL_BACKEND . '/includes/' : $phpbb_root_path . 'includes/';

		if (file_exists($path . $file.'.'.$phpEx))
		{
			@include_once($path . $file.'.'.$phpEx);
		}
		/**/
		if (PORTAL_BACKEND == 'internal' || $force_shared)
		{
			$backend = in_array($force_shared, array('internal', 'phpbb2', 'phpbb3')) ? $force_shared : PORTAL_BACKEND;
			switch ($backend)
			{
				case 'internal':
				case 'phpbb2':
					$path = $mx_root_path . 'includes/shared/phpbb2/includes/';
					break;
			}
		}
		else
		{
			$path = $phpbb_root_path . 'includes/';
		}

		if (file_exists($path . $file.'.'.$phpEx))
		{
			@include_once($path . $file.'.'.$phpEx);
		}
	}

	/**
	 * Read.
	 *
	 * Read page and block data.
	 *
	 * @access private
	 * @param unknown_type $id
	 * @param unknown_type $sub_id
	 * @param unknown_type $type
	 * @param unknown_type $cache
	 * @return unknown
	 */
	function _read_config( $id, $sub_id, $type, $cache )
	{
		global $portal_config, $mx_root_path;

		switch ( $type )
		{
			case MX_CACHE_BLOCK_TYPE:

				if ($portal_config['mx_use_cache'] == 1)
				{
					if ( $this->_exists( '_block_' . $id ) )
					{
						$this->block_config = $this->get( '_block_' . $id );
					}
					else
					{
						$this->_get_block_config( $id, $sub_id );
						$this->put( '_block_' . $id,  $this->block_config);
					}
				}
				else
				{
					$this->_get_block_config( $id, $sub_id );
				}

			break;

			case MX_CACHE_PAGE_TYPE:

				if ($portal_config['mx_use_cache'] == 1)
				{
					if ( $this->_exists( '_page_' . $id ) )
					{
						$this->pages_config = $this->get( '_page_' . $id );
					}
					else
					{
						$this->_get_page_config( $id );
						$this->put( '_page_' . $id, $this->pages_config );
					}
				}
				else
				{
					$this->_get_page_config( $id );
				}

			break;
		}
	}

	/**
	 * Query and format block data.
	 *
	 * @access private
	 * @param unknown_type $id
	 * @param unknown_type $sub_id
	 * @return unknown
	 */
	function _get_block_config( $id = '', $sub_id = 0 )
	{
		global $db;

		$this->block_config = array();

		//
		// If this block doesn't have any parameters, we need this additional query :(
		//
		$sql_block =  !empty($id) ? " AND block_id = " . $id : '';

		//
		// Generate block parameter data
		//
		$sql = "SELECT 	blk.*,
						mdl.module_path,
						fnc.function_file, fnc.function_id, fnc.function_admin
			FROM " . BLOCK_TABLE . " blk,
					" . FUNCTION_TABLE . " fnc,
			        " . MODULE_TABLE . " mdl
			WHERE   blk.function_id = fnc.function_id
					AND fnc.module_id   = mdl.module_id";

		$sql .= $sql_block;
		$sql .= " ORDER BY block_id";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not obtain block data information', '', __LINE__, __FILE__, $sql );
		}

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$block_id = $row['block_id'];

			$block_row = array(
				"block_id" => $row['block_id'],
				"block_title" => $row['block_title'],
				"block_desc" => $row['block_desc'],
				"auth_view" => $row['auth_view'],
				"auth_view_group" => $row['auth_view_group'],
				"auth_edit" => $row['auth_edit'],
				"auth_edit_group" => $row['auth_edit_group'],
				"auth_moderator_group" => $row['auth_moderator_group'],
				"show_block" => $row['show_block'],
				"show_title" => $row['show_title'],
				"show_stats" => $row['show_stats'],
				"block_time" => $row['block_time'],
				"block_editor_id" => $row['block_editor_id'],
				"module_root_path" => $row['module_path'],
				"block_file" => $row['function_file'],
				"block_edit_file" => $row['function_admin'],
				"function_id" => $row['function_id']
			);

			$this->block_config[$block_id]['block_info'] = $block_row;
		}

		$db->sql_freeresult($result);
		$sql_block =  !empty( $id ) ? " AND sys.block_id = " . $id : '';

		//
		// Generate block parameter data
		//
		$sql = "SELECT 	blk.*,
						
						sys.parameter_id, sys.parameter_value, sys.parameter_opt,
						par.parameter_name, par.parameter_type, par.parameter_auth, par.parameter_function, par.parameter_default, par.parameter_order,
						mdl.module_path,
						fnc.function_file, fnc.function_id, fnc.function_admin
			FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
					" . PARAMETER_TABLE . " par,
					" . BLOCK_TABLE . " blk,
					
			        " . FUNCTION_TABLE . " fnc,
			        " . MODULE_TABLE . " mdl
			WHERE sys.parameter_id = par.parameter_id
					AND sys.block_id = blk.block_id
					
					AND blk.function_id = fnc.function_id
					AND fnc.module_id   = mdl.module_id";

		$sql .= $sql_block;
		$sql .= " ORDER BY sys.block_id, par.parameter_order";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not obtain block data information', '', __LINE__, __FILE__, $sql );
		}

		$block_id = 0;
		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$next_block = ( $block_id != $row['block_id'] ) ? true : false;
			$block_id = $row['block_id'];

			$block_row = array(
				"block_id" => $row['block_id'],
				"block_title" => $row['block_title'],
				"block_desc" => $row['block_desc'],
				"column_id" => false,
				"auth_view" => $row['auth_view'],
				"auth_view_group" => $row['auth_view_group'],
				"auth_edit" => $row['auth_edit'],
				"auth_edit_group" => $row['auth_edit_group'],
				"auth_moderator_group" => $row['auth_moderator_group'],
				"show_block" => $row['show_block'],
				"show_title" => $row['show_title'],
				"show_stats" => $row['show_stats'],
				"block_time" => $row['block_time'],
				"block_editor_id" => $row['block_editor_id'],
				"module_root_path" => $row['module_path'],
				"block_file" => $row['function_file'],
				"block_edit_file" => $row['function_admin'],
				"function_id" => $row['function_id']
			);

			$param_row = array(
				"parameter_id" => $row['parameter_id'],
				"function_id" => $row['function_id'],
				"parameter_name" => $row['parameter_name'],
				"parameter_type" => $row['parameter_type'],
				"parameter_auth" => $row['parameter_auth'],
				"parameter_value" => $row['parameter_value'],
				"parameter_default" => $row['parameter_default'],
				"parameter_function" => $row['parameter_function'],
				"parameter_opt" => $row['parameter_opt']
			);

			if ( $next_block )
			{
				$temp_row = array();
				$temp_row = array( 'block_info' => $block_row );
			}

			$temp_row['block_parameters'][$param_row['parameter_name']] = $param_row;

			//
			// Compose the pages config array
			//
			$this->block_config[$block_id] = $temp_row;
		}

		unset($row);
		$db->sql_freeresult($result);
	}
	// -------------------------------------------------------------------GET DATA	
	// Read the variable block configuration
	function block_config($id = '', $sub_id = 0, $config = '')
	{
		global $db;

		$this->block_config = array();

		// If this block doesn't have any parameters, we need this additional query :(
		$sql_block =  !empty($id) ? " AND block_id = " . $id : '';

		// Generate block parameter data
		$sql = "SELECT 	blk.*,
						mdl.module_path, mdl.module_name,
						fnc.function_file, fnc.function_id, fnc.function_admin
			FROM " . BLOCK_TABLE . " blk,
					" . FUNCTION_TABLE . " fnc,
			        " . MODULE_TABLE . " mdl
			WHERE   blk.function_id = fnc.function_id
					AND fnc.module_id   = mdl.module_id";

		$sql .= $sql_block;
		$sql .= " ORDER BY block_id";
		
		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not obtain block data information', '', __LINE__, __FILE__, $sql );
		}
		
		while ($row = $db->sql_fetchrow($result))
		{
			$block_id = $row['block_id'];
			
			$block_row = array(
				"block_id" => $row['block_id'],
				"block_title" => $row['block_title'],
				"block_desc" => $row['block_desc'],
				"auth_view" => $row['auth_view'],
				"auth_view_group" => $row['auth_view_group'],
				"auth_edit" => $row['auth_edit'],
				"auth_edit_group" => $row['auth_edit_group'],
				"auth_moderator_group" => $row['auth_moderator_group'],
				"show_block" => $row['show_block'],
				"show_title" => $row['show_title'],
				"show_stats" => $row['show_stats'],
				"block_time" => $row['block_time'],
				"block_editor_id" => $row['block_editor_id'],
				"module_root_path" => $row['module_path'],
				"module_name" => $row['module_name'],				
				"block_file" => $row['function_file'],
				"block_edit_file" => $row['function_admin'],
				"function_id" => $row['function_id']
			);
			
			$this->block_config[$block_id]['block_info'] = $block_row;
		}
		
		$db->sql_freeresult($result);
		$sql_block =  !empty( $id ) ? ' AND sys.block_id = ' . $id : '';
		$sql_sub =  !empty( $sub_id ) ? ' AND sys.sub_id = ' . $sub_id : ' AND sys.sub_id = 0';

		// Generate block parameter data
		$sql = "SELECT 	blk.*,
						sys.parameter_id, sys.parameter_value, sys.parameter_opt,
						par.*,
						mdl.module_path, mdl.module_name,
						bct.column_id,
						fnc.function_file, fnc.function_id, fnc.function_admin
			FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
				" . PARAMETER_TABLE . " par,
				" . BLOCK_TABLE . " blk,
				" . FUNCTION_TABLE . " fnc,
				" . MODULE_TABLE . " mdl,
				" . COLUMN_BLOCK_TABLE . " bct				
			WHERE sys.parameter_id = par.parameter_id			
				AND sys.block_id 	= blk.block_id
				AND blk.function_id = fnc.function_id
				AND fnc.module_id   = mdl.module_id";
				
		$sql .= $sql_block;
		$sql .= $sql_sub;
		$sql .= " ORDER BY sys.block_id, par.parameter_order";

		if (!($result = $db->sql_query($sql)))
		{
			mx_message_die( GENERAL_ERROR, 'Could not obtain block data information', '', __LINE__, __FILE__, $sql );
		}
		
		$block_id = 0;
		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$next_block = ( $block_id != $row['block_id'] ) ? true : false;
			$block_id = $row['block_id'];
			
			$block_row = array(
				"block_id" => $row['block_id'],
				"block_title" => $row['block_title'],
				"block_desc" => $row['block_desc'],
				"column_id" => $row['column_id'],
				"auth_view" => $row['auth_view'],
				"auth_view_group" => $row['auth_view_group'],
				"auth_edit" => $row['auth_edit'],
				"auth_edit_group" => $row['auth_edit_group'],
				"auth_moderator_group" => $row['auth_moderator_group'],
				"show_block" => $row['show_block'],
				"show_title" => $row['show_title'],
				"show_stats" => $row['show_stats'],
				"block_time" => $row['block_time'],
				"block_editor_id" => $row['block_editor_id'],
				"module_root_path" => $row['module_path'],
				"module_name" => $row['module_name'],				
				"block_file" => $row['function_file'],
				"block_edit_file" => $row['function_admin'],
				"function_id" => $row['function_id']
			);
			
			$param_row = array(
				"parameter_id" => $row['parameter_id'],
				"function_id" => $row['function_id'],
				"parameter_name" => $row['parameter_name'],
				"parameter_type" => $row['parameter_type'],
				"parameter_auth" => $row['parameter_auth'],
				"parameter_value" => $row['parameter_value'],
				"parameter_default" => $row['parameter_default'],
				"parameter_function" => $row['parameter_function'],
				"parameter_opt" => $row['parameter_opt'],
				"parameter_order" => $row['parameter_order']				
			);
			
			if ( $next_block )
			{
				$temp_row = array();
				$temp_row = array( 'block_info' => $block_row );
			}
			
			$temp_row['block_parameters'][$param_row['parameter_name']] = $param_row;
			//
			// Compose the pages config array
			//
			$this->block_config[$block_id] = $temp_row;
		}
		unset($row);
		$db->sql_freeresult($result);
		
		switch($config)
		{
			case 'block_info':
				return $block_row;				
			break;
			
			case 'block_parameters':
				return $param_row;			
			break;
			
			case 'block_config':			
				return $this->block_config;
			break;
						
			default:
				return $this->block_config;
			break;			
		}
	}
	/**
	 * Query page data
	 *
	 * @access private
	 * @param unknown_type $id
	 * @return unknown
	 */
	function _get_page_config( $id = '' )
	{
		global $db, $_SESSION, $mx_request_vars;

		$this->pages_config = array();

		$sql_page = !empty($id) ? " AND col.page_id = '" . $id . "'" : "";

		//
		// Get page_blocks data
		//col.page_id as is_current,
		$sql = "SELECT 	col.page_id,
						pag.page_name,
						pag.page_parent,
						pag.parents_data,
						pag.page_icon,
						pag.page_alt_icon,
						pag.default_style,
						pag.override_user_style,
						pag.page_header,
						pag.page_footer,
						pag.page_main_layout,
						pag.navigation_block,
						pag.auth_view AS pag_auth_view,
						pag.auth_view_group AS pag_auth_view_group,
						pag.auth_moderator_group AS pag_auth_moderator_group,
						pag.ip_filter,
						pag.phpbb_stats,
						bct.column_id,
						col.column_title,
						col.column_order,
						col.column_size,
						blk.block_id
	    		FROM " . COLUMN_BLOCK_TABLE . " bct,
			         	" . BLOCK_TABLE . " blk,
			         	" . FUNCTION_TABLE . " fnc,
			         	" . MODULE_TABLE . " mdl,
			         	" . PAGE_TABLE . " pag,
						" . COLUMN_TABLE . " col
				WHERE blk.function_id = fnc.function_id
			      		AND pag.page_id    	= col.page_id
			      		AND blk.block_id    = bct.block_id
			      		AND fnc.module_id   = mdl.module_id
						AND bct.column_id 	= col.column_id ";
				$sql .= $sql_page;
	      		$sql .= " ORDER BY col.page_id, column_order, block_order";

	    if ( !$result = $db->sql_query( $sql ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not query page information", "", __LINE__, __FILE__, $sql );
		}
		$column_id = isset($column_id) ? intval($column_id) : 0;
		$page_id = 0;
		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$next_page = ( $page_id != $row['page_id'] ) ? true : false;
			$next_column = ( $column_id != $row['column_id'] ) ? true : false;
			$page_id = $row['page_id'];
			$column_id = $row['column_id'];

			$page_row = array(
				"page_id" => $row['page_id'],
				//"is_current" => ($row['page_id'] == $mx_request_vars->request('page', MX_TYPE_INT, 1)) ? $row['page_id'] : false,				
				"page_name" => $row['page_name'],
				"page_parent" => $row['page_parent'],
				"parent_data" => $row['parents_data'],
				"page_icon" => $row['page_icon'],
				"page_alt_icon" => $row['page_alt_icon'],
				"default_style" => $row['default_style'],
				"override_user_style" => $row['override_user_style'],
				"page_header" => $row['page_header'],
				"page_footer" => $row['page_footer'],
				"page_main_layout" => $row['page_main_layout'],
				"page_navigation_block" => $row['navigation_block'],
				"page_auth_view" => $row['pag_auth_view'],
				"page_auth_view_group" => $row['pag_auth_view_group'],
				"page_auth_moderator_group" => $row['pag_auth_moderator_group'],
				"ip_filter" => $row['ip_filter'],
				"phpbb_stats" => $row['phpbb_stats']
			);

			$column_row = array(
				"column_id" => $row['column_id'],
				"column_title" => $row['column_title'],
				"column_order" => $row['column_order'],
				"column_size" => $row['column_size']
			);

			$block_row = array(
				"block_id" => $row['block_id'],
				"column_id" => $row['column_id']
				//"module_path" => $row['module_path'],
				//"function_file" => $row['function_file'],
				//"function_admin" => $row['function_admin']
			);

			if ( $next_page )
			{
				$temp_row = array();
				$temp_row = array( 'page_info' => $page_row );
			}

			if ( $next_column )
			{
				$temp_row['columns'][] = $column_row;
			}

			$temp_row['blocks'][] = $block_row;

			//
			// Compose the pages config array
			//
			$this->pages_config[$page_id] = $temp_row;
		};

		unset($row);
		$db->sql_freeresult($result);
	}

	/**
	 * Update internal cache log
	 *
	 * @access private
	 */
	function _update_cache( )
	{
		global $db, $_SESSION, $mx_root_path, $phpbb_root_path, $phpEx, $mx_use_cache, $portal_config;

		$portal_cache_time = time();

		$sql = "UPDATE ".PORTAL_TABLE."
			SET portal_recached = '$portal_cache_time'
			WHERE portal_id = 1";

		if ( !( $result = $db->sql_query( $sql, BEGIN_TRANSACTION ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not update portal cache time.", "", __LINE__, __FILE__, $sql );
		}
	}

	// ------------------------------
	// Public Methods
	//
	//

	/**
	 * Read.
	 *
	 * Read page/block data.
	 *
	 * @access public
	 * @param unknown_type $id
	 * @param unknown_type $type
	 * @param unknown_type $force_query
	 * @return unknown
	 */
	function read( $id = '', $type = MX_CACHE_BLOCK_TYPE, $force_query = false )
	{
		if ( is_array( $id ) )
		{
			$id = $id['id'];
			$sub_id =  $id['sub_id'];
		}
		else
		{
			$sub_id = 0;
		}

		if ( $id > 0 )
		{
			$this->_read_config( $id, $sub_id, $type, !$force_query );
			return $type == MX_CACHE_BLOCK_TYPE ? $this->block_config : $this->pages_config;
		}
		else
		{
			die('invalid cache read call - no id');
		}
	}

	/**
	 * Update (write).
	 *
	 * In reality the update method removes old cache files, to be repopulated as soon as called for.
	 *
	 * @access public
	 * @param unknown_type $type
	 * @param unknown_type $id
	 */
	function update( $type = MX_CACHE_ALL, $id = '' )
	{
		global $mx_cache;

		//
		// ALL
		//
		if ( $type == MX_CACHE_ALL && empty($id) )
		{
			$this->trash('pages');
			$this->trash('blocks');
		}
		//
		// ALL blocks
		//
		else if ( $type == MX_CACHE_BLOCK_TYPE && empty($id) )
		{
			$this->trash('blocks');
		}
		//
		// ALL pages
		//
		else if ( $type == MX_CACHE_PAGE_TYPE && empty($id) )
		{
			$this->trash('pages');
		}
		//
		// This block
		//
		else if ( $type == MX_CACHE_BLOCK_TYPE && $id > 0 )
		{
			$this->destroy('_block_' . $id);
		}
		//
		// This Page
		//
		else if ( $type == MX_CACHE_PAGE_TYPE && $id > 0 )
		{
			$this->destroy('_page_' . $id);
		}
		else
		{
			die('invalid cache write call - no id');
		}
		$this->_update_cache( );
	}

	/**
	 * Trash.
	 *
	 * Trash all cache files.
	 * - $mx_cache->trash();
	 *
	 * @access public
	 */
	function trash($type = 'all')
	{
		$dir = opendir($this->cache_dir);
		while (($entry = readdir($dir)) !== false)
		{
			if ($type == 'all')
			{
				if (preg_match('/^(sql_|_block_|_page_|data_(?!global))/', $entry))
				{
					unlink($this->cache_dir . $entry);
				}
			}
			else if ($type == 'blocks')
			{
				if (preg_match('/^(_block_)/', $entry))
				{
					unlink($this->cache_dir . $entry);
				}

			}
			else if ($type == 'pages')
			{
				if (preg_match('/^(_page_|_pagemap_)/', $entry))
				{
					unlink($this->cache_dir . $entry);
				}

			}
			else if ($type == 'install')
			{
				if (preg_match('/^(tpl2_|tpl_|_block_|_page_|data_(?!global))/', $entry)) // Cannot remove tpl cache files currently in use ;)
				{
					unlink($this->cache_dir . $entry);
				}
			}
		}
		@closedir($dir);
	}
}

/**
 * Class: cache.
 *
 * This is the mxBB custom cache for eg config data.
 *
 * @package mxBBcache
 * @author Jon Ohlsson
 * @author www.phpbb.com
 * @access public
 *
 */
class cache
{
	//
	// Implementation Conventions:
	// Properties and methods prefixed with underscore are intented to be private. ;-)
	//

	// ------------------------------
	// Vars
	//

	/**#@+
	 * Class Flags
	 * @access private
	 */
	var $vars = array();
	var $var_expires = array();
	var $is_modified = false;
	var $sql_rowset = array('1' => '1'); // Cache fix. Now also FIRST query can be cached. Unsolved phpBB bug...i think ;)
	/**#@-*/

	// ------------------------------
	// Private Methods
	//
	//

	/**
	 * Constructor.
	 *
	 * @return cache
	 */
	function cache()
	{
		global $mx_root_path;
		$this->cache_dir = $mx_root_path . 'cache/';
	}

	/**
	 * Load.
	 *
	 * @access private
	 * @return unknown
	 */
	function load()
	{
		global $phpEx;
		if (file_exists($this->cache_dir . 'data_global.' . $phpEx))
		{
			include($this->cache_dir . 'data_global.' . $phpEx);
		}
		else
		{
			return false;
		}
	}

	/**
	 * Enter description here...
	 * @access private
	 */
	function save()
	{
		if (!$this->is_modified)
		{
			return;
		}

		global $phpEx;
		$file = '<?php $this->vars=' . $this->format_array($this->vars) . ";\n\$this->var_expires=" . $this->format_array($this->var_expires) . ' ?>';

		if ($fp = @fopen($this->cache_dir . 'data_global.' . $phpEx, 'wb'))
		{
			@flock($fp, LOCK_EX);
			fwrite($fp, $file);
			@flock($fp, LOCK_UN);
			fclose($fp);
		}

		$this->is_modified = false;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $array
	 * @return unknown
	 */
	function format_array($array)
	{
		$lines = array();
		foreach ($array as $k => $v)
		{
			if (is_array($v))
			{
				$lines[] = "'$k'=>" . $this->format_array($v);
			}
			else if (is_int($v))
			{
				$lines[] = "'$k'=>$v";
			}
			else if (is_bool($v))
			{
				$lines[] = "'$k'=>" . (($v) ? 'true' : 'false');
			}
			else
			{
				$lines[] = "'$k'=>'" . str_replace("'", "\\'", str_replace('\\', '\\\\', $v)) . "'";
			}
		}
		return 'array(' . implode(',', $lines) . ')';
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $query
	 * @return unknown
	 */
	function sql_load($query)
	{
		global $phpEx;

		// Remove extra spaces and tabs
		$query = preg_replace('/[\n\r\s\t]+/', ' ', $query);
		$query_id = sizeof($this->sql_rowset);

		if (!file_exists($this->cache_dir . 'sql_' . md5($query) . ".$phpEx"))
		{
			return false;
		}

		@include($this->cache_dir . 'sql_' . md5($query) . ".$phpEx");

		if (!isset($expired))
		{
			return false;
		}
		else if ($expired)
		{
			unlink($this->cache_dir . 'sql_' . md5($query) . ".$phpEx");
			return false;
		}
		return $query_id;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $query
	 * @param unknown_type $query_result
	 * @param unknown_type $ttl
	 */
	function sql_save($query, &$query_result, $ttl)
	{
		global $db, $phpEx;

		// Remove extra spaces and tabs
		$query = preg_replace('/[\n\r\s\t]+/', ' ', $query);

		if ($fp = @fopen($this->cache_dir . 'sql_' . md5($query) . '.' . $phpEx, 'wb'))
		{
			@flock($fp, LOCK_EX);

			$lines = array();
			$query_id = sizeof($this->sql_rowset);
			$this->sql_rowset[$query_id] = array();

			while ($row = $db->sql_fetchrow($query_result))
			{
				$this->sql_rowset[$query_id][] = $row;

				$lines[] = "unserialize('" . str_replace("'", "\\'", str_replace('\\', '\\\\', serialize($row))) . "')";
			}
			$db->sql_freeresult($query_result);

			fwrite($fp, "<?php\n\n/*\n$query\n*/\n\n\$expired = (time() > " . (time() + $ttl) . ") ? true : false;\nif (\$expired) { return; }\n\n\$this->sql_rowset[\$query_id] = array(" . implode(',', $lines) . ') ?>');
			@flock($fp, LOCK_UN);
			fclose($fp);

			$query_result = $query_id;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $query_id
	 * @return unknown
	 */
	function sql_exists($query_id)
	{
		return isset($this->sql_rowset[$query_id]);
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $query_id
	 * @return unknown
	 */
	function sql_fetchrow($query_id)
	{
		return @array_shift($this->sql_rowset[$query_id]);
	}

	// ------------------------------
	// Public Methods
	//
	//

	/**
	 * Enter description here...
	 *
	 * @access public
	 * @param unknown_type $var_name
	 * @return unknown
	 */
	function _exists($var_name)
	{
		if ($var_name{0} == '_')
		{
			global $phpEx;
			return file_exists($this->cache_dir . 'data' . $var_name . ".$phpEx");
		}
		else
		{
			if (!sizeof($this->vars))
			{
				$this->load();
			}

			if (!isset($this->var_expires[$var_name]))
			{
				return false;
			}

			return (time() > $this->var_expires[$var_name]) ? false : isset($this->vars[$var_name]);
		}
	}

	/**
	 * Unload.
	 *
	 * Unload and save modified cache, must be done before the DB connection if closed
	 * <code>
	 * if (!empty($mx_cache))
	 * {
	 * 		$mx_cache->unload();
	 * }
	 * </code>
	 *
	 * @access public
	 */
	function unload()
	{
		$this->save();
		unset($this->vars);
		unset($this->var_expires);
		unset($this->sql_rowset);
	}

	/**
	 * Tidy.
	 *
	 * Tidy cache. Remove expired files etc
	 * - $mx_cache->tidy();
	 *
	 * @access public
	 */
	function tidy()
	{
		global $phpEx;

		$dir = opendir($this->cache_dir);
		while (($entry = readdir($dir)) !== false)
		{
			if (!preg_match('/^(sql_|data_(?!global))/', $entry))
			{
				continue;
			}

			$expired = true;
			include($this->cache_dir . $entry);
			if ($expired)
			{
				unlink($this->cache_dir . $entry);
			}
		}
		@closedir($dir);

		if (file_exists($this->cache_dir . 'data_global.' . $phpEx))
		{
			if (!sizeof($this->vars))
			{
				$this->load();
			}

			foreach ($this->var_expires as $var_name => $expires)
			{
				if (time() > $expires)
				{
					$this->destroy($var_name);
				}
			}
		}
	}

	/**
	 * Enter description here...
	 * - $mx_cache->get('some_data')
	 *
	 * @access public
	 * @param unknown_type $var_name
	 * @return unknown
	 */
	function get($var_name)
	{
		if ($var_name{0} == '_')
		{
			global $phpEx;

			if (!$this->_exists($var_name))
			{
				return false;
			}

			include($this->cache_dir . 'data' . $var_name . ".$phpEx");
			return (isset($data)) ? $data : false;
		}
		else
		{
			return ($this->_exists($var_name)) ? $this->vars[$var_name] : false;
		}
	}

	/**
	 * Enter description here...
	 * - $mx_cache->put('some_data', $this->some_data)
	 *
	 * @access public
	 * @param unknown_type $var_name
	 * @param unknown_type $var
	 * @param unknown_type $ttl
	 */
	function put($var_name, $var, $ttl = 31536000)
	{
		if ($var_name{0} == '_')
		{
			global $phpEx;

			if ($fp = @fopen($this->cache_dir . 'data' . $var_name . ".$phpEx", 'wb'))
			{
				@flock($fp, LOCK_EX);
				fwrite($fp, "<?php\n\$expired = (time() > " . (time() + $ttl) . ") ? true : false;\nif (\$expired) { return; }\n\n\$data = unserialize('" . str_replace("'", "\\'", str_replace('\\', '\\\\', serialize($var))) . "');\n?>");
				@flock($fp, LOCK_UN);
				fclose($fp);
			}
		}
		else
		{
			$this->vars[$var_name] = $var;
			$this->var_expires[$var_name] = time() + $ttl;
			$this->is_modified = true;
		}
	}

	/**
	 * Destroy.
	 *
	 * Remove cache file.
	 * - $mx_cache->destroy('sql', SOME_TABLE);
	 * - $mx_cache->destroy('some_data');
	 *
	 * @access public
	 * @param unknown_type $var_name
	 * @param unknown_type $table
	 */
	function destroy($var_name, $table = '')
	{
		global $phpEx;

		if ($var_name == 'sql' && !empty($table))
		{
			$regex = '(' . ((is_array($table)) ? implode('|', $table) : $table) . ')';

			$dir = opendir($this->cache_dir);
			while (($entry = readdir($dir)) !== false)
			{
				if (strpos($entry, 'sql_') !== 0)
				{
					continue;
				}

				$fp = fopen($this->cache_dir . $entry, 'rb');
				$file = fread($fp, filesize($this->cache_dir . $entry));
				@fclose($fp);

				if (preg_match('#/\*.*?\W' . $regex . '\W.*?\*/#s', $file, $m))
				{
					unlink($this->cache_dir . $entry);
				}
			}
			@closedir($dir);

			return;
		}

		if (!$this->_exists($var_name))
		{
			return;
		}

		if ($var_name{0} == '_')
		{
			@unlink($this->cache_dir . 'data' . $var_name . ".$phpEx");
		}
		else if (isset($this->vars[$var_name]))
		{
			$this->is_modified = true;
			unset($this->vars[$var_name]);
			unset($this->var_expires[$var_name]);

			// We save here to let the following cache hits succeed
			$this->save();
		}
	}
}

/**
 * Class: mx_block.
 *
 * This is the CORE block object. The mx_block object defines all block properties, extending the mx_parameter class,
 * handles all block contents output, and is called from index.php. The object calls the mx_cache class for retrieving block data.
 *
 * Usage examples:
 * - $mx_block->init($block_id);
 * - $this_block_id = $mx_block->block_id;
 * - $mx_block->output_stats();
 *
 * @access public
 * @author Jon Ohlsson
 * @package Core
 */
class mx_block extends mx_block_parameter
{
	//
	// Implementation Conventions:
	// Properties and methods prefixed with underscore are intented to be private. ;-)
	//

	// ------------------------------
	// Vars
	//

	/**#@+
	 * Block data containers.
	 *
	 * @access public
	 * @var array
	 */
	var $block_info = array();
	var $block_parameters = array();
	var $_auth_ary = array();
	/**#@-*/

	/**#@+
	 * @access public
	 * @var string
	 */
	var $function_id = '';
	var $block_id = '';
	var $block_title = '';
	var $block_desc = '';
	/**#@-*/

	/**#@+
	 * @access public
	 * @var boolean
	 */
	var $show_block = true;
	var $show_title = true;
	var $show_stats = false;
	var $auth_view = false;
	var $auth_edit = false;
	var $auth_mod = false;
	var $full_page = false;

	var $init_error_msg = false;
	/**#@-*/

	/**#@+
	 * @access public
	 * @var string
	 */
	var $module_root_path = '';
	var $block_file = '';
	var $block_edit_file = '';
	/**#@-*/

	/**#@+
	 * Dynamic block variables
	 *
	 * @access public
	 */
	var $dynamic_block_id = '';
	var $is_dynamic = false;
	/**#@-*/

	/**#@+
	 * Sub block variables
	 *
	 * @access public
	 */
	var $total_subs = '';
	var $sub_block_ids = '';
	var $sub_block_sizes = '';
	var $sub_inner_space = '';
	var $is_sub = false;
	/**#@-*/

	/**
	 * Data container
	 *
	 * @access private
	 * @var string
	 */
	var $block_contents = '';

	// ------------------------------
	// Properties
	//

	// ------------------------------
	// Constructor
	//

	// ------------------------------
	// Private Methods
	//

	/**
	 * Initiate and load block data
	 *
	 * @access private
	 * @param unknown_type $unset
	 */
	function _set_all()
	{
		global $userdata, $lang;

		//
		// Weird rewrite for php5 - anyone explaining why wins a medal ;)
		//
		$temp = $this->block_config[$this->block_id];
		$this->block_info = $temp['block_info'];
		$this->block_parameters = !empty($temp['block_parameters']) ? $temp['block_parameters'] : '';
		unset($temp);

		$this->block_id = $this->block_info['block_id'];
		$this->block_title = !empty($lang['blocktitle_' . $this->block_info['block_title']]) ? $lang['blocktitle_' . $this->block_info['block_title']] : $this->block_info['block_title'];
		$this->block_desc = !empty($lang['blocktitle_' . $this->block_info['block_desc']]) ? $lang['blockdesc_' . $this->block_info['block_desc']] : $this->block_info['block_desc'];

		$this->show_block = $this->block_info['show_block'] == '1';
		$this->show_title = $this->block_info['show_title'] == '1';
		$this->show_stats = $this->block_info['show_stats'] == '1';

		$this->_auth_ary = $this->auth( AUTH_ALL );
		$this->auth_view = $this->_auth_ary['auth_view'];
		$this->auth_edit = $this->_auth_ary['auth_edit'];
		$this->auth_mod = $this->_auth_ary['auth_mod'];

		$this->block_time = $this->block_info['block_time'];
		$this->editor_id = $this->block_info['block_editor_id'];

		$this->module_root_path = $this->block_info['module_root_path'];
		$this->block_file = $this->block_info['block_file'];
		$this->block_edit_file = $this->block_info['block_edit_file'];
		$this->function_id = $this->block_info['function_id'];

		$this->is_dynamic = $this->_is_dynamic();
		$this->is_sub = $this->_is_sub();
	}

	/**
	 * Enter description here...
	 * @access private
	 */
	function _unset()
	{
		unset($this->block_config);
		unset($this->block_info);
		unset($this->block_parameters);
		unset($this->block_contents);

		unset($this->block_id);
		unset($this->block_title);
		unset($this->block_desc);

		unset($this->show_block);
		unset($this->show_title);
		unset($this->show_stats);

		unset($this->_auth_ary);
		unset($this->auth_view);
		unset($this->auth_edit);
		unset($this->auth_mod);

		unset($this->block_time);
		unset($this->editor_id);

		unset($this->module_root_path);
		unset($this->block_file);
		unset($this->block_edit_file);
		unset($this->function_id);

		unset($this->is_dynamic);
		unset($this->is_sub);

		unset($this->init_error_msg);
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @return unknown
	 */
	function _is_dynamic()
	{
		global $mx_request_vars;

		$is_dynamic = ( ( $this->block_file == 'mx_dynamic.php' ) ? true : false );

		if ( $is_dynamic )
		{
			$this->dynamic_block_id = $mx_request_vars->request('dynamic_block', MX_TYPE_INT, $this->block_parameters['default_block_id']['parameter_value']);

			if ( $this->dynamic_block_id == 0 || empty( $this->dynamic_block_id ) )
			{
				$is_dynamic = false;
			}

		}

		return $is_dynamic;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @return unknown
	 */
	function _is_sub()
	{
		$is_sub = ( ( $this->block_file == 'mx_multiple_blocks.php' ) ? true : false );

		if ( $is_sub )
		{
			$sub_block_ids = $this->block_parameters['block_ids']['parameter_value'];
			$this->sub_block_ids = explode( ',', $sub_block_ids );

			$this->total_subs = sizeof( $this->sub_block_ids );

			if ( $this->total_subs < 2 )
			{
				$is_sub = false;
				$this->init_error_msg = "Nested block count must be >=2.";
			}

			$sub_block_sizes = $this->block_parameters['block_sizes']['parameter_value'];
			$this->sub_block_sizes = explode( ',', $sub_block_sizes );

			if ( sizeof( $this->sub_block_sizes ) != $this->total_subs )
			{
				$is_sub = false;
				$this->init_error_msg = "Number of block sizes must be equal to block count.";
			}

			$this->sub_inner_space = $this->block_parameters['space_between']['parameter_value'];
		}

		return $is_sub;
	}

	// ------------------------------
	// Public Methods
	//

	/**
	 * Initiate block object.
	 *
	 * This method initiates the block object and loads data for block_id.
	 *
	 * @access public
	 * @param unknown_type $block_id
	 * @param unknown_type $force_query
	 */
	function init( $block_id, $force_query = false )
	{
		global $mx_cache;

		$this->block_id = $block_id;
	 	$this->block_config = $mx_cache->read( $this->block_id, MX_CACHE_BLOCK_TYPE, $force_query );
	 	$this->_set_all();
	}

	/**
	 * Hide block
	 * @access public
	 */
	function hide_me()
	{
	 	$this->show_block = false;
	}

	/**
	 * Destroys block object
	 * @access public
	 */
	function kill_me()
	{
	 	$this->_unset();
	}

	/**
	 * Pass block data to main CORE template
	 *
	 * @access public
	 * @param string $block_contents
	 */
	function output()
	{
		global $layouttemplate, $mx_page;

		$layouttemplate->assign_block_vars('layout_column.blocks', array(
			'BLOCK_ID'		=> $this->block_id,
			'BLOCK'			=> $this->block_contents
		));

		//
		// Update all-in-all stats for the page
		//
		if (!empty($this->block_time) && $this->block_time > $mx_page->last_updated)
		{
			$mx_page->last_updated = $this->block_time;
			$mx_page->last_updated_by = $this->editor_id;
		}
	}

	/**
	 * Pass block data to full page
	 *
	 * @access public
	 */
	function output_full_page()
	{
		global $layouttemplate, $mx_page;

		mx_message_die(GENERAL_MESSAGE, $this->block_contents);
	}

	/**
	 * Block border graphics.
	 *
	 * This switch allows code within the 'block_border_graphics' temnplate environment.
	 *
	 * @access public
	 */
	function output_border_graphics()
	{
		global $layouttemplate;

		$layouttemplate->assign_block_vars('layout_column.blocks.graph_border', array(
			'TEMPLATE_ROOT_PATH'	=> TEMPLATE_ROOT_PATH
		));
	}

	/**
	 * Output block stats.
	 * @access public
	 */
	function output_stats()
	{
		global $user, $layouttemplate, $board_config, $lang, $userdata;

		if ( $this->show_stats && !empty($this->block_time) && !empty($this->editor_id) )
		{
			$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;
			$editor_name_tmp = mx_get_userdata($this->editor_id);
			$editor_name = $editor_name_tmp['username'];
			$edit_time = create_date( $board_config['default_dateformat'], $this->block_time, $board_config['board_timezone'] );

			$layouttemplate->assign_block_vars('layout_column.blocks.block_stats', array(
				'L_BLOCK_UPDATED'	=> $user->lang['Block_updated_date'],
				'EDITOR_NAME'		=> $is_admin ? $user->lang['Block_updated_by'] . $editor_name : '',
				'EDIT_TIME'			=> $edit_time
			));
		}
		else
		{
			$layouttemplate->assign_block_vars('layout_column.blocks.no_stats', array());
		}
	}

	/**
	 * Output 'hidden' indicator.
	 * @access public
	 */
	function output_hidden_indicator()
	{
		global $layouttemplate, $lang, $images;

		$hidden_img = '<img src="' . $images['mx_block_hidden'] . '" alt="' . $lang['Hidden_block_explain'] . '" title="' . $lang['Hidden_block_explain'] . '">';
		$layouttemplate->assign_block_vars('layout_column.blocks.edit.hidden_block', array(
			'HIDDEN_BLOCK'	=> $hidden_img
		));
	}

	/**
	 * Output block title.
	 * @access public
	 */
	function output_title()
	{
		global $layouttemplate;

		$this_block_title = !$this->show_title  && $this->auth_mod ? '<i>(' . $this->block_title . ')</i>' : $this->block_title;
		$layouttemplate->assign_block_vars('layout_column.blocks.show_title', array(
			'L_TITLE'		=> $this_block_title
		));
	}

	/**
	 * Output block editCP button.
	 * @access public
	 */
	function output_cp_button($overall_header = false)
	{
		global $layouttemplate, $userdata, $mx_root_path, $mx_page, $lang, $block_size, $images;

		//
		// Define some hidden Edit Block parameters
		//
		$s_hidden_fields = $mx_page->s_hidden_fields;

		//
		// Switch between different block types
		//
		if ($this->is_dynamic)
		{
			$block_edit_img = $images['mx_block_edit_admin'];
			$block_edit_alt = $lang['Block_Edit_dyn'];
		}
		else if ($this->is_sub)
		{
			$block_edit_img = $images['mx_block_edit_split'];
			$block_edit_alt = $lang['Block_Edit_sub'];
		}
		else
		{
			$block_edit_img = $images['mx_block_edit'];
			$block_edit_alt = $lang['Block_Edit'];
		}

		$edit_file = !empty( $this->block_edit_file ) ? $this->block_edit_file : 'modules/mx_coreblocks/mx_blockcp.php';

		//
		// Compose buttons and info
		//
		$block_desc = !empty( $this->block_desc ) ? ' (' . $this->block_desc . ')' : '';
		$edit_url = mx_append_sid( $mx_root_path . $edit_file . "?sid=" . $userdata['session_id'] );
		$edit_img = '<input type="image" src="' . $block_edit_img . '" alt="' . $block_edit_alt . ' :: ' . $this->block_title . $block_desc . '" title="' . $block_edit_alt . ' :: ' . $this->block_title . $block_desc . '">';

		$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $this->block_id . '" />';
		$s_hidden_fields .= '<input type="hidden" name="dynamic_block" value="' . $this->dynamic_block_id . '" />';

		//
		// Output
		//
		$temp_array = array(
			'BLOCK_SIZE'			=> ( !empty( $block_size ) ? $block_size : '100%' ),
			'EDIT_ACTION'			=> $edit_url,
			'EDIT_IMG'				=> $edit_img,
			'EDITCP_SHOW' 			=> $mx_page->editcp_show ? '' : 'none',
			'S_HIDDEN_FORM_FIELDS'	=> $s_hidden_fields
		);

		if (isset($layouttemplate))
		{
			if ($overall_header)
			{
				$layouttemplate->assign_block_vars('editcp', $temp_array);
			}
			else
			{
				$layouttemplate->assign_block_vars('layout_column.blocks.edit', $temp_array);
			}
		}
	}

	/**
	 * Module Parameters Api.
	 *
	 * Core provides a rich set of parameter types. Additional block specific types are defined in module_root/admin/mx_module_defs.php.
	 * Block parameters are accessed with the mx_block->get_parameters() method.
	 *
	 * Api:
	 * - mx_block->get_parameters()
	 *
	 * Available switches:
	 * - MX_GET_ALL_PARS, MX_GET_PAR_VALUE (default), MX_GET_PAR_OPTIONS
	 *
	 * Examples:
	 * - $mx_block->get_parameters( MX_GET_ALL_PARS ) // returns an array with all parameters :: array('par_name1' => $par1_value, 'par_name2' => $par2_value,  ...)
	 * - $mx_block->get_parameters( 'parameter_name' ) // returns value for 'parameter_name'
	 * - $mx_block->get_parameters( 'parameter_name',  MX_GET_PAR_OPTIONS ) // returns options for 'parameter_name', eg bbcodes etc
	 *
	 * @access public
	 * @param unknown_type $key
	 * @param unknown_type $mode
	 * @return unknown
	 */
	function get_parameters($key = MX_GET_ALL_PARS, $mode = MX_GET_PAR_VALUE)
	{
		$block_config_temp = '';				
		
		if ($key == MX_GET_ALL_PARS)
		{
			return array_merge($this->block_info, $this->block_parameters);
		}

		if ($mode == MX_GET_PAR_OPTIONS)
		{
			return $this->block_parameters[$key]['parameter_opt'];
		}
		/** **/
		if (!isset($this->block_parameters[$key]['parameter_value']))
		{
			$keys = (array) $key;		
			
			foreach ($keys as $key)
			{
				$level = 0;
				if (is_array($key))
				{
					$pars_key = $key[0];
					$param_key = $key[1];
					if (count($key) > 2)
					{
						$level = $key[2];
					}
				}
				else
				{
					$pars_key = $key;
					$param_key = $keys[0];
				}
				$key = trim($pars_key);		
			}
		}				
		/** **/		
		return isset($this->block_parameters[$key]['parameter_value']) ? $this->block_parameters[$key]['parameter_value'] : (isset($this->block_parameters[$param_key]['parameter_value']) ? $this->block_parameters[$param_key]['parameter_value'] : false);
	}

	/**
	 * Block auth
	 *
	 * @access private
	 * @param integer $type all, view or edit
	 * @return array
	 */
	function auth($type)
	{
		global $user, $db, $lang, $userdata;

		switch( $type )
		{
			case AUTH_ALL:
				$auth_fields = array('auth_view', 'auth_edit');
				$auth_fields_groups = array('auth_view_group', 'auth_edit_group');
			break;

			case AUTH_VIEW:
				$auth_fields = array('auth_view');
				$auth_fields_groups = array('auth_view_group');
			break;

			case AUTH_EDIT:
				$auth_fields = array('auth_edit');
				$auth_fields_groups = array('auth_edit_group');
			break;

			default:
			break;
		}

		$auth_user = array();
		//
		// If block_id is messed up, give only admin auth
		//
		if( $this->block_id == 0 )
		{
			for( $i = 0; $i < count($auth_fields); $i++ )
			{
				if( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] )
				{
					$auth_user[$auth_fields[$i]] = 1;
				}
				else
				{
					$auth_user[$auth_fields[$i]] = 0;
				}
			}
			return $auth_user;
		}

		$is_admin = ( $user->data['user_level'] == ADMIN && $user->data['session_logged_in'] ) ? TRUE : 0;

		for( $i = 0; $i < count($auth_fields); $i++ )
		{
			//
			// If the user is logged on and the module type is either ALL or REG then the user has access
			//
			// If the type if ACL, MOD or ADMIN then we need to see if the user has specific permissions
			// to do whatever it is they want to do ... to do this we pull relevant information for the
			// user (and any groups they belong to)
			//
			// Now we compare the users access level against the modules. We assume here that a moderator
			// and admin automatically have access to an ACL module, similarly we assume admins meet an
			// auth requirement of MOD
			//
			switch( $this->block_info[$auth_fields[$i]] )
			{
				case AUTH_ALL:
					$auth_user[$auth_fields[$i]] = TRUE;
					$auth_user[$auth_fields[$i] . '_type'] = $user->lang['Auth_Anonymous_Users'];
				break;

				case AUTH_REG:
					$auth_user[$auth_fields[$i]] = ( $user->data['session_logged_in'] ) ? TRUE : 0;
					$auth_user[$auth_fields[$i] . '_type'] = $user->lang['Auth_Registered_Users'];
				break;

				case AUTH_ANONYMOUS:
					$auth_user[$auth_fields[$i]] = ( !$user->data['session_logged_in'] ) ? TRUE : 0;
					$auth_user[$auth_fields[$i] . '_type'] = $user->lang['Auth_Anonymous_Users'];
				break;

				case AUTH_ACL: // PRIVATE
					$auth_user[$auth_fields[$i]] = ( $user->data['session_logged_in'] ) ? mx_is_group_member($this->block_info[$auth_fields_groups[$i]]) || $is_admin : 0;
					$auth_user[$auth_fields[$i] . '_type'] = $user->lang['Auth_Users_granted_access'];
				break;

				case AUTH_MOD:
					$auth_user[$auth_fields[$i]] = ( $user->data['session_logged_in'] ) ? mx_is_group_member($this->block_info['auth_moderator_group']) || $is_admin : 0;
					$auth_user[$auth_fields[$i] . '_type'] = $user->lang['Auth_Moderators'];
				break;

				case AUTH_ADMIN:
					$auth_user[$auth_fields[$i]] = $is_admin;
					$auth_user[$auth_fields[$i] . '_type'] = $user->lang['Auth_Administrators'];
				break;

				default:
					$auth_user[$auth_fields[$i]] = 0;
				break;
			}
		}

		//
		// Is user a moderator?
		//
		$auth_user['auth_mod'] = ( $user->data['session_logged_in'] ) ? mx_is_group_member($this->block_info['auth_moderator_group']) || $is_admin : 0;

		return $auth_user;
	}
}	// class mx_block

/**
 * Class: mx_block_parameter.
 *
 * This is the CORE mx_block_parameter object.
 * The mx_block_parameter class is actually a mx_block parent class, and shouldn't be called by itself ;).
 * This class handles all block parameter editing and loads module specific block parameters.
 *
 * Example:
 * - $this->load_block_parameters($block_id) // Load all block parameters and format the form element
 * - $this->load_block_panels($block_id) // Load (if exists) an additional module panel. Eg the Navigation Menu Panel
 * - $this->submit_parameters($block_id) // Submit all block parameters and update cache
 *
 * @access public
 * @author Jon Ohlsson
 * @package Core
 */
class mx_block_parameter
{
	/**
	 * Parameter type.
	 *
	 * If the Block Parameter is not only a simple form field, but an advanced panel itself, this is turn true
	 *
	 * @var unknown_type
	 */
	var $is_panel = false;
	var $init_error_msg = false;
	/**
	 * Load custom module parameters
	 *
	 * @access private
	 * @param unknown_type $parameter_data
	 * @param unknown_type $block_id
	 * @return unknown
	 */
	function _get_custom_module_parameters($parameter_data, $block_id)
	{
		global $mx_root_path;

		if ( file_exists( $mx_root_path . $this->module_root_path . 'admin/mx_module_defs.php' ) )
		{
			include_once( $mx_root_path . $this->module_root_path . 'admin/mx_module_defs.php' );

			if (class_exists('mx_module_defs'))
			{
				$mx_module_defs = new mx_module_defs();

				if ( method_exists( $mx_module_defs,  'display_module_parameters' ) )
				{
					$mx_module_defs->display_module_parameters($parameter_data, $block_id);
				}
			}
		}

		return $mx_module_defs->is_panel;
	}

	/**
	 * load custom module panels
	 *
	 * @access private
	 * @param unknown_type $parameter_data
	 * @param unknown_type $block_id
	 */
	function _get_custom_module_panels($parameter_data, $block_id)
	{
		global $mx_root_path;

		if ( file_exists( $mx_root_path . $this->module_root_path . 'admin/mx_module_defs.php' ) )
		{
			include_once( $mx_root_path . $this->module_root_path . 'admin/mx_module_defs.php' );

			if (class_exists('mx_module_defs'))
			{
				$mx_module_defs = new mx_module_defs();

				if ( method_exists( $mx_module_defs,  'display_module_panels' ) )
				{
					$mx_module_defs->display_module_panels($parameter_data, $block_id);
				}
			}
		}
	}

	/**
	 * submit custom module parameters
	 *
	 * @access private
	 * @param unknown_type $parameter_data
	 * @param unknown_type $block_id
	 * @return unknown
	 */
	function _submit_custom_module_parameters($parameter_data, $block_id)
	{
		global $mx_root_path;

		if ( file_exists( $mx_root_path . $this->module_root_path . 'admin/mx_module_defs.php' ) )
		{
			include_once( $mx_root_path . $this->module_root_path . 'admin/mx_module_defs.php' );

			if (class_exists('mx_module_defs'))
			{
				$mx_module_defs = new mx_module_defs();

				if ( method_exists( $mx_module_defs,  'submit_module_parameters' ) )
				{
					$parameter_custom = $mx_module_defs->submit_module_parameters($parameter_data, $block_id);
				}
			}
		}
		return $parameter_custom;
	}

	/**
	 * check if there is a data in the database
	 *
	 * @access private
	 * @return unknown
	 */
	function _parameter_data_exist()
	{
		if ( !empty( $this->block_parameters ) )
		{
			return true;
		}
		return false;
	}

	/**
	 * submit_parameters.
	 *
	 * @access public
	 * @param unknown_type $block_id
	 * @return unknown
	 */
	function submit_parameters( $block_id = false )
	{
		global $_POST, $db, $mx_bbcode, $mx_cache, $lang, $userdata;

		$return = false;
		if ( $this->_parameter_data_exist() )
		{
			foreach( $this->block_parameters as $parameter_name => $parameter_data )
			{
				//
				// Switch for admin only parameters
				//
				if ($parameter_data['parameter_auth'] == 0 || $userdata['user_level'] == ADMIN)
				{
					$parameter_id = $parameter_data['parameter_id'];
					$parameter_value = isset($_POST[$parameter_id]) ? $_POST[$parameter_id] : $parameter_data['parameter_default'];
					$parameter_opt = '';

					switch ( $parameter_data['parameter_type'] )
					{
						case 'Boolean':
						case 'Text':
						case 'TextArea':
							$parameter_value = htmlspecialchars( trim( $parameter_value ) );
							break;
						case 'BBText':
							$bbcode_uid = $parameter_opt = $mx_bbcode->make_bbcode_uid();
							$parameter_value = $mx_bbcode->prepare_message($parameter_value, true, true, true, $bbcode_uid);
							break;
						case 'Html':
							$parameter_value = $mx_bbcode->prepare_message($parameter_value, true, false, false);
							break;
						case 'Number':
							$parameter_value = intval($parameter_value);
							break;
						case 'Function':
							if( is_array($parameter_value) )
							{
								//$parameter_value = implode(',' , htmlspecialchars($parameter_value));
								$parameter_value = implode(',' , $parameter_value);
							}
							break;

						// Custom Fields
						case 'Radio_single_select':
						case 'Menu_single_select':
							$parameter_value = htmlspecialchars( trim( $parameter_value ) );
							break;
						case 'Menu_multiple_select':
						case 'Checkbox_multiple_select':
							$parameter_value = addslashes( serialize( $parameter_value ) );
							break;
						case 'Separator':
							break;

						default:
							$parameter_custom = $this->_submit_custom_module_parameters($parameter_data, $block_id);
							$parameter_value = $parameter_custom['parameter_value'];
							$parameter_opt = $parameter_custom['parameter_opt'];
						break;
					}

					//
					// Update block data
					//
					if ( $sub_id == $parameter_data['sub_id'] || true )
					{
						//
						// If standard block
						//
						$sql = "UPDATE " . BLOCK_SYSTEM_PARAMETER_TABLE . "
							SET parameter_value		= '" . str_replace("\'", "''", $parameter_value) . "',
								parameter_opt      	= '$parameter_opt'
							WHERE block_id 			= '$block_id'
								AND parameter_id 	= '$parameter_id'
								AND sub_id 	= '$sub_id'";
					}
					else
					{
						/*
						//
						// If subblock
						//
						$sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "(block_id, parameter_id, parameter_value, parameter_opt, sub_id)
							VALUES('$block_id','$parameter_id','" . str_replace("\'", "''", $parameter_value) . "','$parameter_opt', '$sub_id')";
						*/
					}

					if( !($db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update system parameter table", "", __LINE__, __FILE__, $sql);
					}

					//
					// Update block itself
					//
					if( $sub_id == 0 )
					{
						$block_time = time();
						$block_editor_id = $userdata['user_id'];

						$sql = "UPDATE " . BLOCK_TABLE . "
							SET block_time = '" . str_replace("\'", "''", $block_time) . "',
								block_editor_id = '" . intval($block_editor_id) . "'
							WHERE block_id = $block_id";

						if( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
						{
							mx_message_die(GENERAL_ERROR, "Could not update block title information.", "", __LINE__, __FILE__, $sql);
						}
					}
				} // allowed parameter
			} // End foreach

			//
			// Update cache
			//
			$mx_cache->update(MX_CACHE_BLOCK_TYPE, $block_id); // Maybe ambitious, but why not ;)
			$message .= $lang['AdminCP_action'] . ": " . $lang['Block'] . ' ' . $lang['was_updated'];


		}
		return $message;
	}

	/**
	 * load_block_parameters.
	 *
	 * @access public
	 * @param unknown_type $block_id
	 * @return unknown
	 */
	function load_block_parameters( $block_id = false )
	{
		global $mx_root_path, $module_root_path, $template, $blockcptemplate, $board_config, $theme, $userdata;

		$return = false;
		$block_panel_data = $block_parameter_data = '';

		if ( $this->_parameter_data_exist() )
		{
			foreach( $this->block_parameters as $parameter_name => $parameter_data )
			{
				//
				// Switch for admin only parameters
				//
				if ($parameter_data['parameter_auth'] == 0 || $userdata['user_level'] == ADMIN)
				{
					ob_start();
					$this->is_panel = false;
					$template = new mx_Template($mx_root_path . $this->module_root_path);

					switch ( $parameter_data['parameter_type'] )
					{
						case 'Separator':
							$this->display_edit_Separator( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
							case 'Text':
							$this->display_edit_PlainTextField( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
						case 'TextArea':
							$this->display_edit_PlainTextAreaField( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
						case 'BBText':
							$this->display_edit_BBText( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
						case 'Html':
							$this->display_edit_Html( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
						case 'Boolean':
							$this->display_edit_Boolean( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
						case 'Number':
							$this->display_edit_Number( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
						case 'Function':
							$this->display_edit_Function( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;

						// Custom Fields
						case 'Radio_single_select':
							$this->display_edit_Radio_single_select( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
						case 'Menu_single_select':
							$this->display_edit_Menu_single_select( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
						case 'Menu_multiple_select':
							$this->display_edit_Menu_multiple_select( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
						case 'Checkbox_multiple_select':
							$this->display_edit_Checkbox_multiple_select( $block_id, $parameter_data['parameter_id'], $parameter_data );
						break;
						default:
							$module_root_path = $mx_root_path . $this->module_root_path;
							$this->is_panel = $this->_get_custom_module_parameters($parameter_data, $block_id);
							$module_root_path = '';
						break;
					}

					$block_output_data = ob_get_contents();
					ob_end_clean();

					if ($this->is_panel)
					{
						$blockcptemplate->assign_block_vars('blockcp_panel', array(
							'BLOCKCP_PANELS' => ( !empty($block_output_data) ) ? $block_output_data : ''
						));
					}
					else
					{
						$block_parameter_data .= $block_output_data;
					}

					$return = true;
				}
			}

			//
			// Now send all parameter data to main blockcp template
			//
			$blockcptemplate->assign_vars(array(
				'BLOCKCP_PARAMETERS' => ( !empty($block_parameter_data) ) ? $block_parameter_data : ''
			));
		}
		return $return;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_Separator( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		// $parameter_field = '<input type="text" maxlength="150" size="50" name="' . $parameter_id . '" value="' . $parameter_data['parameter_value'] . '" />';

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars('separator', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',
			'PARAMETER_TYPE' 			=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_INFO' 		=> ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? ' :: ' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"] : ''
		));

		$template->pparse('parameter');
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_PlainTextField( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$parameter_field = '<input type="text" maxlength="150" size="50" name="' . $parameter_id . '" value="' . $parameter_data['parameter_value'] . '" />';

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars('block_parameter', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',
			'PARAMETER_TYPE' 			=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_INFO' 		=> ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? ' :: ' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"] : '',
			'PARAMETER_FIELD' 			=> $parameter_field
		));

		$template->pparse('parameter');
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_PlainTextAreaField( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$parameter_field = '<textarea rows="10" cols="100" wrap="virtual" name="' . $parameter_id . '" class="post">' . $parameter_data['parameter_value'] . '</textarea>';

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars('block_parameter', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',
			'PARAMETER_TYPE' 			=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_INFO' 		=> ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? ' :: ' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"] : '',
			'PARAMETER_FIELD' 			=> $parameter_field
		));

		$template->pparse('parameter');
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_BBText( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$bbcode_uid = $parameter_data['parameter_opt'];
		$parameter_value = preg_replace("/\:(([a-z0-9]:)?)$bbcode_uid/si", '', $parameter_data['parameter_value']);
		$parameter_value = str_replace('<br />', "\n", $parameter_value);
		$parameter_value = preg_replace('#</textarea>#si', '&lt;/textarea&gt;', $parameter_value);
		$parameter_field = '<textarea rows="10" cols="100" wrap="virtual" name="' . $parameter_id . '" class="post">' . $parameter_value . '</textarea>';

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars('block_parameter', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',
			'PARAMETER_TYPE' 			=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_INFO' 		=> ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? ' :: ' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"] : '',
			'PARAMETER_FIELD' 			=> $parameter_field
		));

		$template->pparse('parameter');
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_Html( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$parameter_field = '<textarea rows="10" cols="100" wrap="virtual" name="' . $parameter_id . '" class="post">' . $parameter_data['parameter_value'] . '</textarea>';

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars('block_parameter', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',
			'PARAMETER_TYPE' 			=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_INFO' 		=> ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? ' :: ' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"] : '',
			'PARAMETER_FIELD' 			=> $parameter_field
		));

		$template->pparse('parameter');
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_Number( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$parameter_field = '<input type="text" maxlength="5" size="5" name="' . $parameter_id . '" value="' . $parameter_data['parameter_value'] . '" />';

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars('block_parameter', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',
			'PARAMETER_TYPE' 			=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_INFO' 		=> ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? ' :: ' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"] : '',
			'PARAMETER_FIELD' 			=> $parameter_field
		));

		$template->pparse('parameter');
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_Boolean( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$selected_true = '';
		$selected_false = '';
		if( $parameter_data['parameter_value'] == 'TRUE' || $parameter_data['parameter_value'] == '1' )
		{
			$selected_true = ' checked="checked"';
		}
		else
		{
			$selected_false = ' checked="checked"';
		}
		$parameter_field = '<input type="radio" name="' .$parameter_id. '" value="TRUE" '.$selected_true.' /> <span class="gensmall">'. $lang['Yes'] .'&nbsp;&nbsp;</span><input type="radio" name="'. $parameter_id .'" value="FALSE" '. $selected_false .' /> <span class="gensmall">'. $lang['No'] .'</span>';

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars('block_parameter', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',
			'PARAMETER_TYPE' 			=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_INFO' 		=> ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? ' :: ' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"] : '',
			'PARAMETER_FIELD' 			=> $parameter_field
		));

		$template->pparse('parameter');
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_Function( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$parameter_function = str_replace('{parameter_value}', $parameter_data['parameter_value'], $parameter_data['parameter_function']);
		$parameter_function = str_replace('{parameter_id}', $parameter_id, $parameter_function);
		$parameter_field = eval('return ' . $parameter_function . ';');

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars('block_parameter', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',
			'PARAMETER_TYPE' 			=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_INFO' 		=> ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? ' :: ' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"] : '',
			'PARAMETER_FIELD' 			=> $parameter_field
		));

		$template->pparse('parameter');
	}

	/**
	 * Custom Fields
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_Radio_single_select( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$data = ( !empty( $parameter_data['parameter_value'] ) ) ? $parameter_data['parameter_value'] : '';
		$parameter_datas = ( !empty( $parameter_data['parameter_function'] ) ) ? unserialize( stripslashes( $parameter_data['parameter_function'] ) ) : array();

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars( 'radio', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',

				'FIELD_NAME' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
				'FIELD_ID' 				=> $parameter_data['parameter_id'],
				'FIELD_DESCRIPTION' 	=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : ''
			));

		if ( !empty( $parameter_datas ) )
		{
			foreach( $parameter_datas as $key => $value )
			{
				$template->assign_block_vars( 'radio.row', array( 'FIELD_VALUE' => $value,
						'FIELD_SELECTED' => ( $data == $value ) ? ' checked="checked"' : '' )
					);
			}
		}

		$template->pparse('parameter');
	}

	/**
	 * Custom Fields
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_Menu_single_select( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$data = ( !empty( $parameter_data['parameter_value'] ) ) ? $parameter_data['parameter_value'] : '';
		$parameter_datas = ( !empty( $parameter_data['parameter_function'] ) ) ? unserialize( stripslashes( $parameter_data['parameter_function'] ) ) : array();

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars( 'select', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',

				'FIELD_NAME' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
				'FIELD_ID' 				=> $parameter_data['parameter_id'],
				'FIELD_DESCRIPTION' 	=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : ''
			));

		if ( !empty( $parameter_datas ) )
		{
			foreach( $parameter_datas as $key => $value )
			{
				$template->assign_block_vars( 'select.row', array( 'FIELD_VALUE' => $value,
						'FIELD_SELECTED' => ( $data == $value ) ? ' selected="selected"' : '' )
					);
			}
		}

		$template->pparse('parameter');
	}

	/**
	 * Custom Fields
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_Menu_multiple_select( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$data = ( !empty( $parameter_data['parameter_value'] ) ) ? unserialize($parameter_data['parameter_value']) : array();
		$parameter_datas = ( !empty( $parameter_data['parameter_function'] ) ) ? unserialize( stripslashes( $parameter_data['parameter_function'] ) ) : array();

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars( 'select_multiple', array(
				'FIELD_NAME' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
				'FIELD_ID' 				=> $parameter_data['parameter_id'],
				'FIELD_DESCRIPTION' 	=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : ''
			));

		if ( !empty( $parameter_datas ) )
		{
			foreach( $parameter_datas as $key => $value )
			{
				$selected = '';
				if (is_array($data))
				{
					foreach( $data as $field_value )
					{
						if ( $field_value == $value )
						{
							$selected = '  selected="selected"';
							break;
						}
					}
				}
				$template->assign_block_vars( 'select_multiple.row', array( 'FIELD_VALUE' => $value,
						'FIELD_SELECTED' => $selected )
					);
			}
		}

		$template->pparse('parameter');
	}

	/**
	 * Custom Fields
	 *
	 * @access private
	 * @param unknown_type $block_id
	 * @param unknown_type $parameter_id
	 * @param unknown_type $parameter_data
	 */
	function display_edit_Checkbox_multiple_select( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang;

		$data = ( !empty( $parameter_data['parameter_value'] ) ) ? unserialize($parameter_data['parameter_value']) : array();
		$parameter_datas = ( !empty( $parameter_data['parameter_function'] ) ) ? unserialize( stripslashes( $parameter_data['parameter_function'] ) ) : array();

		$template->set_filenames(array(
			'parameter' => 'admin/mx_core_parameters.tpl')
		);

		$template->assign_block_vars( 'checkbox', array(
			'PARAMETER_TITLE' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TITLE_EXPLAIN' 	=> ( !empty($lang[$parameter_data['parameter_name']. "_explain"]) ) ? '<br />' . $lang[$parameter_data['parameter_name']. "_explain"] : '',

				'FIELD_NAME' 			=> ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
				'FIELD_ID' 				=> $parameter_data['parameter_id'],
				'FIELD_DESCRIPTION' 	=> ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : ''
			));

		if ( !empty( $parameter_datas ) )
		{
			foreach( $parameter_datas as $key => $value )
			{
				$checked = '';
				if (is_array($data))
				{
					foreach( $data as $field_value )
					{
						if ( $field_value == $value )
						{
							$checked = ' checked';
							break;
						}
					}
				}
				$template->assign_block_vars( 'checkbox.row', array( 'FIELD_VALUE' => $value,
						'FIELD_CHECKED' => $checked )
					);
			}
		}

		$template->pparse('parameter');
	}

}

/**
 * Class: mx_page.
 *
 * This is the CORE page object. The mx_page class defines all page properties
 * and handles all page output and layout structure, and is called from index.php.
 *
 * Examples:
 * - $mx_page->init($page_id)
 * - $mx_page->kill_me()
 * - $mx_page->output_column($column)
 * - $mx_page->output_editcp_switch()
 *
 * @access public
 * @author Jon Ohlsson
 * @package Core
 */
class mx_page
{
	//
	// Implementation Conventions:
	// Properties and methods prefixed with underscore are intented to be private. ;-)
	//

	// ------------------------------
	// Vars
	//
	var $is_virtual;
	/**#@+
	 * Core data containers.
	 *
	 * @access public
	 * @var array
	 */
	var $page_rowset = array();
	var $subpage_rowset = array();
	var $total_page = 0;

	var $modified = false;
	var $error = array();

	var $navigation = '';
	/**#@-*/

	/**#@+
	 * Page data containers.
	 *
	 * @access public
	 * @var array
	 */
	var $info = array();
	var $columns = array();
	var $blocks = array();
	var $_auth_ary = array();
	/**#@-*/

	var $page_id = '1';
	var $page_title = '';
	var $page_icon = '';
	var $default_style = '-1';
	var $override_user_style = '-1';
	var $page_ov_header = '';
	var $page_ov_footer = '';
	var $page_main_layout = '';
	var $page_navigation_block = 31;
	var $vertical_navigation_block = 8;
	
	var $mxbb_copyright_addup = array();
	var $mxbb_css_addup = array();

	var $total_column = '';
	var $total_block = '';

	var $auth_view = false;
	var $auth_mod = false;
	var $auth_ip = false;
	var $phpbb_stats = '-1';

	var $block_border_graphics = false;
	var $editcp_exists = false;
	var $editcp_show = false;

	var $last_updated = '';
	var $last_updated_by = '';

	// ------------------------------
	// Properties
	//

	// ------------------------------
	// Constructor
	//
	/**
	 * Init CORE/page.
	 *
	 * @access public
	 * @param integer $page_id
	 * @param boolean $force_query
	 */
	function init( $page_id, $force_query = false )
	{
		global $db, $mx_cache, $userdata, $debug, $portal_config, $mx_request_vars;

		unset( $this->page_rowset );
		unset( $this->subpage_rowset );

		$sql = 'SELECT pag.*, pag.page_id as is_current
			FROM ' . PAGE_TABLE . ' pag
			ORDER BY pag.page_parent, pag.page_order ASC';

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query pages info', '', __LINE__, __FILE__, $sql );
		}
		$page_rowset = $db->sql_fetchrowset( $result );

		$db->sql_freeresult( $result );

		for( $i = 0; $i < count($page_rowset); $i++ )
		{
			$this->page_rowset[$page_rowset[$i]['page_id']] = $page_rowset[$i];
			$page_rowset[$i]['is_current'] = ($page_rowset[$i]['page_id'] == $mx_request_vars->request('page', MX_TYPE_INT, 1)) ? true : false;
			$this->subpage_rowset[$page_rowset[$i]['page_parent']][$page_rowset[$i]['page_id']] = $page_rowset[$i];
			$this->total_page++;
		}

		//
		// Load page data
		//
		$this->page_id = $page_id;
	 	$this->page_config = $mx_cache->read( $this->page_id, MX_CACHE_PAGE_TYPE, $force_query );
	 	$this->_set_all();
	}

	// ------------------------------
	// Private Methods
	//

	/**
	 * Clean up
	 * @access private
	 */
	function _core()
	{
		if ( $this->modified )
		{
			$this->sync_all();
		}
	}

	/**
	 * Sync All.
	 * @access private
	 */
	function sync_all()
	{
		foreach( $this->page_rowset as $page_id => $void )
		{
			$this->sync( $page_id, false );
		}
		$this->init();
	}

	/**
	 * Do Sync
	 *
	 * @access private
	 * @param unknown_type $page_id
	 * @param unknown_type $init
	 */
	function sync( $page_id, $init = true )
	{
		global $db;

		$page_nav = array();
		$this->core_nav( $this->page_rowset[$cat_id]['page_parent'], $page_nav );

		$sql = 'UPDATE ' . PAGE_TABLE . "
			SET parents_data = ''
			WHERE page_parent = " . $this->page_rowset[$page_id]['page_parent'];

		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query pages info', '', __LINE__, __FILE__, $sql );
		}

		if ( $init )
		{
			$this->init();
		}
		return;
	}

	/**
	 * Navigation data
	 *
	 * @access public
	 * @param unknown_type $parent_id
	 * @param unknown_type $page_nav
	 */
	function core_nav( $parent_id, &$page_nav )
	{
		if ( !empty( $this->page_rowset[$parent_id] ) )
		{
			$this->core_nav( $this->page_rowset[$parent_id]['page_parent'], $page_nav );
			$page_nav[$parent_id] = $this->page_rowset[$parent_id]['page_name'];
		}
		return;
	}

	/**
	 * Is modified
	 *
	 * @access public
	 * @param unknown_type $true_false
	 */
	function modified( $true_false = false )
	{
		$this->modified = $true_false;
	}

	/**
	 * Initiate and load page data
	 * @access private
	 */
	function _set_all()
	{
		global $mx_user, $db, $userdata, $board_config, $mx_root_path, $_GET, $_COOKIE, $portal_config, $theme, $lang, $mx_request_vars;
		global $mx_block;

		$this->info = $this->page_config[$this->page_id]['page_info'];

		//
		// IP filter
		//user_style
		$mx_ip = new mx_ip;
		
		// We are trying to setup a style which does not exist in the database
		// Try to fallback to the board default (if the user had a custom style)
		// and then any users using this style to the default if it succeeds
		if (($mx_user->data['user_style'] == $board_config['default_style']) || ($mx_user->data['user_id'] == ANONYMOUS))
		{					
			$sql = 'SELECT template_name
					FROM ' . THEMES_TABLE . '
					WHERE themes_id = ' . (int) $board_config['default_style'];		
			if ($theme = $db->sql_fetchrow($result = $db->sql_query($sql)))
			{
				$db->sql_freeresult($result);
			}		
		}
		else
		{					
			$sql = 'SELECT template_name
					FROM ' . THEMES_TABLE . '
					WHERE themes_id = ' . (int) $mx_user->data['user_style'];		
			if ($theme = $db->sql_fetchrow($result = $db->sql_query($sql)))
			{
				$db->sql_freeresult($result);
			}		
		}
		
		if (file_exists($mx_root_path . 'templates/'. $theme['template_name'] . '/template/'))
		{		
			$overall_header_tpl = (($this->page_id != 2) && file_exists($mx_root_path . 'templates/'. $theme['template_name'] . '/template/overall_header_navigation.html')) ? 'overall_header_navigation.html' : $portal_config['overall_header'];
			$overall_header_tpl = (($this->page_id == 2) && file_exists($mx_root_path . 'templates/'. $theme['template_name'] . '/template/overall_header_navigation_phpbb.html')) ? 'overall_header_navigation_phpbb.html' : $overall_header_tpl;
		}		
		else
		{		
			$overall_header_tpl = (($this->page_id != 2) && file_exists($mx_root_path . 'templates/'. $theme['template_name'] . '/overall_header_navigation.html')) ? 'overall_header_navigation.html' : $portal_config['overall_header'];
			$overall_header_tpl = (($this->page_id == 2) && file_exists($mx_root_path . 'templates/'. $theme['template_name'] . '/overall_header_navigation_phpbb.html')) ? 'overall_header_navigation_phpbb.html' : $overall_header_tpl;
		}		
		
		//
		// General
		//
		$this->page_title = !empty($lang['pagetitle_' . $this->info['page_name']]) ? $lang['pagetitle_' . $this->info['page_name']] : $this->info['page_name'];
		$this->page_icon = $this->info['page_icon'];
		$this->page_alt_icon = $this->info['page_alt_icon'];

		$this->default_style = $this->info['default_style'] == -1 ? ($portal_config['default_style']) : ( $this->info['default_style'] );
		$this->override_user_style = $this->info['override_user_style'] == -1 ? ($portal_config['override_user_style'] == 1 ? 1 : 0 ) : ( $this->info['override_user_style'] == 1 ? 1 : 0 );

		$this->page_ov_header = !empty($this->info['page_header']) ? $this->info['page_header'] : $overall_header_tpl;
		$this->page_ov_footer = !empty($this->info['page_footer']) ? $this->info['page_footer'] : $portal_config['overall_footer'];
		$this->page_main_layout = !empty($this->info['page_main_layout']) ? $this->info['page_main_layout'] : $portal_config['main_layout'];
		//echo($this->page_ov_header);
		$this->phpbb_stats = $this->info['phpbb_stats'] == -1 ? ($portal_config['top_phpbb_links'] == 1 ? true : false ) : ( $this->info['phpbb_stats'] == 1 ? true : false );
		$this->page_navigation_block = $this->info['page_navigation_block'] == 0 ? $portal_config['navigation_block'] : $this->info['page_navigation_block'];
		//$this->vertical_navigation_block = $this->info['page_navigation_block'] == 0 ? $portal_config['navigation_block'] : $this->info['page_navigation_block'];		
		
		//
		// Set the public view auth
		//
		$this->_auth_ary = $this->auth();
		$this->auth_view = $this->_auth_ary['auth_view'];
		$this->auth_mod = $this->_auth_ary['auth_mod'];
		$this->auth_ip = $mx_ip->auth($this->info['ip_filter']);

		$this->columns = $this->page_config[$this->page_id]['columns'];
		$this->total_column = count($this->columns);

		$this->blocks = $this->page_config[$this->page_id]['blocks'];
		$this->total_block = count($this->blocks);

		$this->block_border_graphics =  $mx_user->block_border_graphics;

		$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
		$s_hidden_fields .= '<input type="hidden" name="portalpage" value="' . $this->page_id . '" />';
		$s_hidden_fields .= '<input type="hidden" name="mode" value="setting" />';
		$s_hidden_fields .= isset( $_GET['f'] ) ? '<input type="hidden" name="f" value="' . intval( $_GET['f'] ) . '" />' : '';
		$s_hidden_fields .= isset( $_GET['t'] ) ? '<input type="hidden" name="t" value="' . intval( $_GET['t'] ) . '" />' : '';
		$s_hidden_fields .= isset( $_GET['p'] ) ? '<input type="hidden" name="p" value="' . intval( $_GET['p'] ) . '" />' : '';
		$this->s_hidden_fields = $s_hidden_fields;

		//
		// Generate the fold/unfold menu navigation switches (cookie based)
		//
		$this->editcp_show = ( $userdata['user_level'] == ADMIN && isset($_COOKIE['editCP_switch']) ) ? $_COOKIE['editCP_switch'] == 1 : true;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $column
	 * @return unknown
	 */
	function _get_colclass( $column )
	{
		if ( $this->total_column == 1 )
		{
			$colclass = 'middlecol';
		}
		else
		{
			switch( $column )
			{
				case 0:
					$colclass = 'leftcol';
					break;
				case 1:
					$colclass = 'middlecol';
					break;
				case 2:
					$colclass = 'rightcol';
					break;
			}
		}

		return $colclass;
	}

	// ------------------------------
	// Public Methods
	//

	/**
	 * Kill me.
	 *
	 * Unset and unload all page data
	 *
	 * @access public
	 */
	function kill_me()
	{
		global $mx_cache;

	 	$this->page_config = '';
	}

	/**
	 * Jump menu function.
	 *
	 * @access public
	 * @param unknown_type $page_id to handle parent page_id
	 * @param unknown_type $depth related to function to generate tree
	 * @param unknown_type $default the page you wanted to be selected
	 * @return unknown
	 */
	function generate_jumpbox( $page_id = 0, $depth = 0, $default = '' )
	{
		$page_list .= '';

		$pre = str_repeat( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $depth );

		if ( !empty( $this->page_rowset ) )
		{
			foreach ( $this->page_rowset as $temp_page_id => $page )
			{
				if ( $page['page_parent'] == $page_id )
				{
					if ( is_array( $default ) )
					{
						if ( isset( $default[$page['page_id']] ) )
						{
							$sel = ' selected="selected"';
						}
						else
						{
							$sel = '';
						}
					}
					$page_pre = '+ ';
					$sub_page_id = $page['page_id'];
					$page_class = '';
					$page_list .= '<option value="' . $sub_page_id . '"' . $sel . ' ' . $page_class . ' />' . $pre . $page_pre . $page['page_name'] . (!empty($page['page_desc']) ? ' (' .  $page['page_desc'] . ')'  : '') . '</option>';
					$page_list .= $this->generate_jumpbox( $page['page_id'], $depth + 1, $default );
				}
			}
			return $page_list;
		}
		else
		{
			return;
		}
	}

	/**
	 * Generate_navigation.
	 *
	 * Not in use...
	 *
	 * @access public
	 * @param unknown_type $page_id
	 */
	function generate_navigation( $page_id )
	{
		global $template, $db;

		if ( $this->page_rowset[$page_id]['parents_data'] == '' )
		{
			$page_nav = array();
			$this->core_nav( $this->page_rowset[$page_id]['page_parent'], $page_nav );

			$sql = 'UPDATE ' . PAGE_TABLE . "
				SET parents_data = '" . addslashes( serialize( $page_nav ) ) . "'
				WHERE page_parent = " . $this->page_rowset[$page_id]['page_parent'];

			if ( !( $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Query pages info', '', __LINE__, __FILE__, $sql );
			}
		}
		else
		{
			$page_nav = unserialize( stripslashes( $this->page_rowset[$page_id]['parents_data'] ) );
		}

		if ( !empty( $page_nav ) )
		{
			foreach ( $page_nav as $parent_page_id => $parent_name )
			{
				$template->assign_block_vars( 'navlinks', array(
					'PAGE_NAME' => $parent_name,
					'U_VIEW_PAGE' => mx_append_sid( $this->this_mxurl( 'page=' . $parent_page_id ) ) )
				);
			}
		}

		$template->assign_block_vars( 'navlinks', array(
			'PAGE_NAME' => $this->page_rowset[$page_id]['page_name'],
			'U_VIEW_PAGE' => mx_append_sid( $this->this_mxurl( 'page=' . $this->page_rowset[$page_id]['page_id'] ) ) )
		);

		return;
	}

	/**
	 * Add copyrights.
	 *
	 * Not in use...
	 *
	 * @access public
	 * @param string $key
	 */
	function add_copyright($key = '')
	{
	 	$this->mxbb_copyright_addup[] = $key;
	}

	/**
	 * Add css file.
	 *
	 * Build up what css files to include in overall_header.
	 *
	 * @access public
	 * @param string $path
	 */
	function add_css_file($filename = '')
	{
		global $mx_block, $theme, $mx_user;


		$style_path = $theme['template_name'];

		$moduleDefault = !empty($mx_user->loaded_default_styles[$mx_block->module_root_path]) ? $mx_user->loaded_default_styles[$mx_block->module_root_path] : $mx_user->default_template_name;

		if ( file_exists($mx_block->module_root_path . 'templates/' . $style_path.'/'.(!empty($filename) ? $filename : $theme['head_stylesheet']) ))
		{
	 		$this->mxbb_css_addup[] = $mx_block->module_root_path . 'templates/' . $style_path.'/'.(!empty($filename) ? $filename : $theme['head_stylesheet']);
		}
		else if ( file_exists($mx_block->module_root_path . 'templates/' . $mx_user->cloned_template_name.'/'.(!empty($filename) ? $filename : $mx_user->cloned_template_name)) )
		{
	 		$this->mxbb_css_addup[] = $mx_block->module_root_path . 'templates/' . $mx_user->cloned_template_name.'/'.(!empty($filename) ? $filename : $mx_user->cloned_template_name);
		}
		else
		{
			$this->mxbb_css_addup[] = $mx_block->module_root_path . 'templates/'. $moduleDefault .'/' . (!empty($filename) ? $filename : $moduleDefault);
		}
	}

	/**
	 * Add js file.
	 *
	 * Build up what js files to include in overall_header.
	 *
	 * @access public
	 * @param string $path
	 */
	function add_js_file($path = '')
	{
	 	$this->mxbb_js_addup[] = $mx_block->module_root_path . $path;
	}

	/**
	 * Add header text.
	 *
	 * Build up additional header text.
	 *
	 * @access public
	 * @param string $text
	 * @param boolean $read_file
	 */
	function add_header_text($text = '', $read_file = false)
	{
		// Provide these variables to be evaluated in the file
		global $mx_block, $theme;

		if ($read_file)
		{
			if (file_exists($mx_block->module_root_path . $text))
			{
				$data = file_get_contents($mx_block->module_root_path . $text);

				foreach ($theme as $key => $value)
				{
					$data = str_replace('$theme[\''.$key.'\']', $value, $data);
				}

				$this->mxbb_footer_addup[] = $data;
			}
			else
			{
				echo('Warning: Your module is trying to load a file ('.$mx_block->module_root_path . $text .') that doesn\'t exist)');
			}
		}
		else
		{
	 		$this->mxbb_header_addup[] = $text;
		}
	}

	/**
	 * Add footer text.
	 *
	 * Build up additional footer text.
	 *
	 * @access public
	 * @param string $text
	 * @param boolean $read_file
	 */
	function add_footer_text($text = '', $read_file = false)
	{
		// Provide these variables to be evaluated in the file
		global $mx_block, $theme;

		if ($read_file)
		{
			if (file_exists($mx_block->module_root_path . $text))
			{
				$data = file_get_contents($mx_block->module_root_path . $text);

				// Substitute theme variables
				foreach ($theme as $key => $value)
				{
					$data = str_replace('$theme[\''.$key.'\']', $value, $data);
				}

				// Substitute block data
				foreach ($mx_block->block_info as $key => $value)
				{
					$data = str_replace('{$'.$key . '}', $value, $data);
				}

				$this->mxbb_footer_addup[] = $data;
			}
			else
			{
				echo('Warning: Your module is trying to load a file ('.$mx_block->module_root_path . $text .') that doesn\'t exist)');
			}
		}
		else
		{
	 		$this->mxbb_footer_addup[] = $text;
		}
	}

	/**
	 * editcp_exists.
	 *
	 * @access private
	 */
	function editcp_exists()
	{
		global $userdata;

		if ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'])
		{
	 		$this->editcp_exists = true;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param integer $column
	 */
	function output_column( $column )
	{
		global $layouttemplate;

		//
		// Get column width
		//

		$block_size = $this->columns[$column]['column_size'];

		//
		// Setup column css styles
		//
		$colclass = $this->_get_colclass( $column );

		//
		// Output
		//
		$layouttemplate->assign_block_vars('layout_column', array(
			'COL_CLASS'		=> $colclass,
			'BLOCK_SIZE'	=> $block_size
		));
	}

	/**
	 * Page auth.
	 *
	 * @access private
	 * @param unknown_type $auth_data
	 * @param unknown_type $group_data
	 * @param unknown_type $moderator_data
	 * @return array
	 */
	function auth($auth_data = '', $group_data = '', $moderator_data = '')
	{
		global $db, $user, $lang, $userdata, $mx_root_path, $phpEx;

		$auth_label = array('auth_view');
		$auth_fields = array('page_auth_view');
		$auth_fields_groups = array('page_auth_view_group');

		$is_admin = ( $user->data['user_level'] == ADMIN && $user->data['session_logged_in'] ) ? TRUE : 0;

		$auth_user = array();
		for( $i = 0; $i < count($auth_fields); $i++ )
		{
			//
			// Fix for making this method useful also other pages, not only current one.
			//
			$auth_data = !empty($auth_data) ? $auth_data : $this->info[$auth_fields[$i]];
			$group_data = !empty($group_data) ? $group_data : $this->info[$auth_fields_groups[$i]];
			$moderator_data = !empty($moderator_data) ? $moderator_data : $this->info['page_auth_moderator_group'];

			switch( $auth_data )
			{
				case AUTH_ALL:
					$auth_user[$auth_label[$i]] = TRUE;
					$auth_user[$auth_label[$i] . '_type'] = $user->lang['Auth_Anonymous_Users'];
				break;

				case AUTH_REG:
					$auth_user[$auth_label[$i]] = ( $user->data['session_logged_in'] ) ? TRUE : 0;
					$auth_user[$auth_label[$i] . '_type'] = $user->lang['Auth_Registered_Users'];
				break;

				case AUTH_ANONYMOUS:
					$auth_user[$auth_label[$i]] = ( ! $user->data['session_logged_in'] ) ? TRUE : 0;
					$auth_user[$auth_label[$i] . '_type'] = $user->lang['Auth_Anonymous_Users'];
				break;

				case AUTH_ACL: // PRIVATE
					$auth_user[$auth_label[$i]] = ( $user->data['session_logged_in'] ) ? mx_is_group_member($group_data) || $is_admin : 0;
					$auth_user[$auth_label[$i] . '_type'] = $user->lang['Auth_Users_granted_access'];
				break;

				case AUTH_MOD:
					$auth_user[$auth_label[$i]] = ( $user->data['session_logged_in'] ) ? mx_is_group_member($moderator_data) || $is_admin : 0;
					$auth_user[$auth_label[$i] . '_type'] = $user->lang['Auth_Moderators'];
				break;

				case AUTH_ADMIN:
					$auth_user[$auth_label[$i]] = $is_admin;
					$auth_user[$auth_label[$i] . '_type'] = $user->lang['Auth_Administrators'];
				break;

				default:
					$auth_user[$auth_label[$i]] = 0;
				break;
			}
		}

		//
		// Is user a moderator?
		$auth_user['auth_mod'] = ( $user->data['session_logged_in'] ) ? mx_is_group_member($moderator_data) || $is_admin : 0;

		return $auth_user;
	}

}	// class mx_page

/**
 * Class: mx_ip.
 *
 * This is the CORE IP object.
 *
 * @access public
 * @package Core
 * @author Jon Ohlsson
 */
class mx_ip
{

	/**
	 * Enter description here...
	 *
	 * @access public
	 * @return string
	 */
	function mx_getip()
	{
	   	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
	   	{
	   		return getenv("HTTP_CLIENT_IP");
	   	}
	   	else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
	   	{
	   		return getenv("HTTP_X_FORWARDED_FOR");
	   	}
	   	else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
	   	{
	   		return getenv("REMOTE_ADDR");
	   	}
	   	else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
	   	{
	  	 	return $_SERVER['REMOTE_ADDR'];
	   	}
	   	else
	   	{
	   		return "unknown";
	   	}
	}

	/**
	 * Enter description here...
	 *
	 * @access public
	 * @param string $mx_page_allowed_ips serialized array of IPs
	 * @return boolean
	 */
	function auth( $mx_page_allowed_ips = '' )
	{
		//
		// Turn the serialized data into an array
		//
		$mx_page_allowed_ips = !empty($mx_page_allowed_ips) ? unserialize( stripslashes( $mx_page_allowed_ips )) : array();

		//
		// If no IP filtering is defined, return valid
		//
		if (count($mx_page_allowed_ips) == 0 || $mx_page_allowed_ips[0] == '')
		{
			unset($mx_page_allowed_ips);
			return true;
		}

		//
		// If IP filter is set, go thorugh the filters
		//
		$mx_client_ip = $this->mx_getip();
		$mx_client_ip_subs = explode('.', $mx_client_ip);

		foreach($mx_page_allowed_ips as $key => $mx_page_allowed_ip)
		{
			$mx_page_allowed_ip_subs = explode('.', $mx_page_allowed_ip);

			$valid = true;
			for( $i=0; $i < count($mx_client_ip_subs); $i++)
			{
				if ($mx_client_ip_subs[$i] != $mx_page_allowed_ip_subs[$i] && $mx_page_allowed_ip_subs[$i] != '*')
				{
					$valid = false;
					continue;
				}
			}

			if ($valid)
			{
				unset($mx_page_allowed_ips);
				return $valid;
			}
		}

		unset($mx_page_allowed_ips);
		return false;
	}
}

/**#@+
 * Class mx_request_vars specific definitions
 *
 * Following flags are options for the $type parameter in method _read()
 *
 */
define('MX_TYPE_ANY'		, 0);		// Retrieve the get/post var as-is (only stripslashes() will be applied).
define('MX_TYPE_INT'		, 1);		// Be sure we get a request var of type INT.
define('MX_TYPE_FLOAT'		, 2);		// Be sure we get a request var of type FLOAT.
define('MX_TYPE_NO_HTML'	, 4);		// Be sure we get a request var of type STRING (htmlspecialchars).
define('MX_TYPE_NO_TAGS'	, 8);		// Be sure we get a request var of type STRING (strip_tags + htmlspecialchars).
define('MX_TYPE_NO_STRIP'	, 16);		// By default strings are slash stripped, this flag avoids this.
define('MX_TYPE_SQL_QUOTED'	, 32);		// Be sure we get a request var of type STRING, safe for SQL statements (single quotes escaped)
define('MX_TYPE_POST_VARS'	, 64);		// Read a POST variable.
define('MX_TYPE_GET_VARS'	, 128);		// Read a GET variable.
define('MX_NOT_EMPTY'		, true);	//

/**#@-*/

/**
 * Class: mx_request_vars.
 *
 * This is the CORE request vars object. Encapsulate several functions related to GET/POST variables.
 * More than one flag can specified by OR'ing the $type argument. Examples:
 * - For instance, we could use ( MX_TYPE_POST_VARS | MX_TYPE_GET_VARS ), see method request().
 * - or we could use ( MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED ).
 * - However, MX_TYPE_NO_HTML and MX_TYPE_NO_TAGS can't be specified at a time (defaults to MX_TYPE_NO_TAGS which is more restritive).
 * - Also, MX_TYPE_INT and MX_TYPE_FLOAT ignore flags MX_TYPE_NO_*
 * Usage examples:
 * - $mode = $mx_request_vars->post('mode', MX_TYPE_NO_TAGS, '');
 * - $page_id = $mx_request_vars->get('page', MX_TYPE_INT, 1);
 * This class IS instatiated in common.php ;-)
 *
 * @access public
 * @author Markus
 * @package Core
 */
class mx_request_vars
{
	//
	// Implementation Conventions:
	// Properties and methods prefixed with underscore are intented to be private. ;-)
	//

	// ------------------------------
	// Properties
	//

	// ------------------------------
	// Constructor
	//

	// ------------------------------
	// Private Methods
	//

	/**
	 * Function: _read().
	 *
	 * Get the value of the specified request var (post or get) and force the result to be
	 * of specified type. It might also transform the result (stripslashes, htmlspecialchars) for security
	 * purposes. It all depends on the $type argument.
	 * If the specified request var does not exist, then the default ($dflt) value is returned.
	 * Note the $type argument behaves as a bit array where more than one option can be specified by OR'ing
	 * the passed argument. This is tipical practice in languages like C, but it can also be done with PHP.
	 *
	 * @access private
	 * @param unknown_type $var
	 * @param unknown_type $type
	 * @param unknown_type $dflt
	 * @return unknown
	 */
	function _read($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
	{
		global $_POST, $_GET;
	
		if( ($type & (MX_TYPE_POST_VARS|MX_TYPE_GET_VARS)) == 0 )
		{
			$type |= (MX_TYPE_POST_VARS|MX_TYPE_GET_VARS);
		}

		if( ($type & MX_TYPE_POST_VARS) && isset($_POST[$var]) ||
			($type & MX_TYPE_GET_VARS)  && isset($_GET[$var]) )
		{
			$val = ( ($type & MX_TYPE_POST_VARS) && isset($_POST[$var]) ? $_POST[$var] : $_GET[$var] );
			if( !($type & MX_TYPE_NO_STRIP) )
			{
				if( is_array($val) )
				{
					foreach( $val as $k => $v )
					{
						$val[$k] = trim(stripslashes($v));
					}
				}
				else
				{
					$val = trim(stripslashes($val));
				}
			}
		}
		else
		{
			$val = $dflt;
		}

		if( $type & MX_TYPE_INT )		// integer
		{
			return $not_null && empty($val) ? $dflt : intval($val);
		}

		if( $type & MX_TYPE_FLOAT )		// float
		{
			return $not_null && empty($val) ? $dflt : floatval($val);
		}

		if( $type & MX_TYPE_NO_TAGS )	// ie username
		{
			if( is_array($val) )
			{
				foreach( $val as $k => $v )
				{
					$val[$k] = htmlspecialchars(strip_tags(ltrim(rtrim($v, " \t\n\r\0\x0B\\"))));
				}
			}
			else
			{
				$val = htmlspecialchars(strip_tags(ltrim(rtrim($val, " \t\n\r\0\x0B\\"))));
			}
		}
		elseif( $type & MX_TYPE_NO_HTML )	// no slashes nor html
		{
			if( is_array($val) )
			{
				foreach( $val as $k => $v )
				{
					$val[$k] = htmlspecialchars(ltrim(rtrim($v, " \t\n\r\0\x0B\\")));
				}
			}
			else
			{
				$val = htmlspecialchars(ltrim(rtrim($val, " \t\n\r\0\x0B\\")));
			}
		}

		if( $type & MX_TYPE_SQL_QUOTED )
		{
			if( is_array($val) )
			{
				foreach( $val as $k => $v )
				{
					$val[$k] = str_replace(($type & MX_TYPE_NO_STRIP ? "\'" : "'"), "''", $v);
				}
			}
			else
			{
				$val = str_replace(($type & MX_TYPE_NO_STRIP ? "\'" : "'"), "''", $val);
			}
		}

		return $not_null && empty($val) ? $dflt : $val;
	}

	// ------------------------------
	// Public Methods
	//

	/**
	 * Request POST variable.
	 *
	 * _read() wrappers to retrieve POST, GET or any REQUEST (both) variable.
	 *
	 * @access public
	 * @param string $var
	 * @param integer $type
	 * @param string $dflt
	 * @return string
	 */
	function post($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
	{
		return $this->_read($var, ($type | MX_TYPE_POST_VARS), $dflt, $not_null);
	}

	/**
	 * Request GET variable.
	 *
	 * _read() wrappers to retrieve POST, GET or any REQUEST (both) variable.
	 *
	 * @access public
	 * @param string $var
	 * @param integer $type
	 * @param string $dflt
	 * @return string
	 */
	function get($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
	{
		return $this->_read($var, ($type | MX_TYPE_GET_VARS), $dflt, $not_null);
	}

	/**
	 * Request GET or POST variable.
	 *
	 * _read() wrappers to retrieve POST, GET or any REQUEST (both) variable.
	 *
	 * @access public
	 * @param string $var
	 * @param integer $type
	 * @param string $dflt
	 * @return string
	 */
	function request($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
	{
		return $this->_read($var, ($type | MX_TYPE_POST_VARS | MX_TYPE_GET_VARS), $dflt, $not_null);
	}

	/**
	 * Is POST var?
	 *
	 * Boolean method to check for existence of POST variable.
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	function is_post($var)
	{
		global $_POST;
		// Note: _x and _y are used by (at least IE) to return the mouse position at onclick of INPUT TYPE="img" elements.
		return (isset($_POST[$var]) || ( isset($_POST[$var.'_x']) && isset($_POST[$var.'_y']))) ? 1 : 0;
	}

	/**
	 * Is GET var?
	 *
	 * Boolean method to check for existence of GET variable.
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	function is_get($var)
	{
		global $_GET;	
		return isset($_GET[$var]) ? 1 : 0 ;
	}

	/**
	 * Is REQUEST (either GET or POST) var?
	 *
	 * Boolean method to check for existence of any REQUEST (both) variable.
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	function is_request($var)
	{
		return ($this->is_get($var) || $this->is_post($var)) ? 1 : 0;
	}
	/**
	 * Is POST var empty?
	 *
	 * Boolean method to check if POST variable is empty
	 * as it might be set but still be empty.
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	function is_empty_post($var)
	{
		global $_POST;
	
		return (empty($_POST[$var]) && ( empty($_POST[$var.'_x']) || empty($_POST[$var.'_y']))) ? 1 : 0 ;
	}
	/**
	 * Is GET var empty?
	 *
	 * Boolean method to check if GET variable is empty
	 * as it might be set but still be empty
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	function is_empty_get($var)
	{
		global $_GET;
		return empty($_GET[$var]) ? 1 : 0 ;
	}

	/**
	 * Is REQUEST empty (GET and POST) var?
	 *
	 * Boolean method to check if REQUEST (both) variable is empty.
	 *
	 * @access public
	 * @param string $var
	 * @return boolean
	 */
	function is_empty_request($var)
	{
		return ($this->is_empty_get($var) && $this->is_empty_post($var)) ? 1 : 0;
	}

}	// class mx_request_vars
?>