<?php
/**
*
* @package Core
* @version $Id: mx_functions_core.php,v 1.140 2014/05/09 07:51:42 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
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
 * @package MX-Publisher cache
 *
 */
class mx_cache extends cache
{
	private $prefix;
	private $path;
	private $backend_path;	
	private $php_ext;
	private $mx_cache;
	private $config;
	
	protected $mx_root_path;
	protected $mx_backend;
	protected $phbb_root_path;	
	protected $phpEx;		
	protected $db;
	protected $portal_config;
	
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
	public function load_backend($portal_backend = false)
	{
		global $portal_config, $mx_table_prefix, $table_prefix, $phpEx, $tplEx;
		global $mx_backend, $phpbb_auth, $mx_bbcode;	

		// Get MX-Publisher config settings
		$portal_config = $this->obtain_mxbb_config();
		//print_r($portal_config);
		// Check some vars
		if (!$portal_config['portal_version'])
		{
			$portal_config = $this->obtain_mxbb_config(false);
		}
		
		if (!$portal_config['portal_backend_path'])
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
		if (!$portal_config['portal_backend_path'])
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
	 * Get MX-Publisher config data
	 *
	 * @access public
	 * @return unknown
	 */
	public function obtain_mxbb_config($use_cache = true)
	{
		global $db;

		if ( ($portal_config = $this->get('mx_config')) && ($use_cache) )
		{
			return $portal_config;
		}
		else
		{
			$sql = "SELECT *
				FROM " . PORTAL_TABLE . "
				WHERE portal_id = '1'";

			if ( !($result = $db->sql_query($sql)) )
			{
				if (!function_exists('mx_message_die'))
				{
					die("Couldnt query portal configuration, Allso this hosting or server is using a cache optimizer not compatible with MX-Publisher or just lost connection to database wile query.");
				}
				else
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt query portal configuration', '', __LINE__, __FILE__, $sql );
				}
			}
			$row = $db->sql_fetchrow($result);
			foreach ($row as $config_name => $config_value)
			{
				$portal_config[$config_name] = trim($config_value);
			}
			$db->sql_freeresult($result);
			$this->put('mx_config', $portal_config);

			return ($portal_config);
		}
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
	 * mx_cache::load_file('functions_x'), will include the phpbb version of the file
	 * mx_cache::load_file('functions_x', true), will include the shared phpbb version of the file
	 * mx_cache::load_file('functions_x', 'phpbb2'), will include the shared phpbb2 version of the file, even though we are running in internal/phpbb3 mode
	 *
	 * @param unknown_type $file
	 * @param unknown_type $backend
	 * @param unknown_type $force_shared
	 */
	public function load_file($file = '', $force_shared = false)
	{
		global $mx_root_path, $phpbb_root_path, $phpEx, $mx_page, $mx_backend;

		/*
		* Remember loaded files
		*/
		if (in_array(($file . (is_string($force_shared) ? $force_shared : '')), $mx_page->loaded_files))
		{
			return;
		}

		$mx_page->loaded_files[] = $file . (is_string($force_shared) ? $force_shared : '');

		$path = $mx_backend->load_file($force_shared);

		if (file_exists($path . $file.'.'.$phpEx))
		{
			@include_once($path . $file.'.'.$phpEx);
		}
	}

	/**
	 * Enter description here...
	 *
	 */
	public function init_mod_rewrite()
	{
		global $portal_config, $mx_root_path, $phpEx, $mx_mod_rewrite;

		if ($portal_config['mod_rewrite'])
		{
			if ( file_exists( $mx_root_path . 'modules/mx_mod_rewrite/includes/rewrite_functions.' . $phpEx ) )
			{
				include_once( $mx_root_path . 'modules/mx_mod_rewrite/includes/rewrite_functions.' . $phpEx );

				if (class_exists('mx_mod_rewrite'))
				{
					$mx_mod_rewrite = new mx_mod_rewrite();
				}
			}
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
	public function _read_config($id = 1, $sub_id = 0, $type, $force_query = false)
	{
		global $portal_config, $mx_root_path;

		switch ($type)
		{
			case MX_CACHE_BLOCK_TYPE:

				if ($portal_config['mx_use_cache'] == 1 && !$force_query)
				{
					if ( $this->_exists( '_block_' . $id . '_' . $sub_id ) )
					{
						$this->block_config = $this->get( '_block_' . $id . '_' . $sub_id );
					}
					else
					{
						$this->_get_block_config( $id, $sub_id );
						$this->put( '_block_' . $id . '_' . $sub_id,  $this->block_config);
					}
				}
				else
				{
					$this->_get_block_config( $id, $sub_id );
				}

			break;

			case MX_CACHE_PAGE_TYPE:

				if ($portal_config['mx_use_cache'] == 1 && !$force_query)
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
	public function _get_block_config($id = '', $sub_id = 0)
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
						par.parameter_name, par.parameter_type, par.parameter_auth, par.parameter_function, par.parameter_default, par.parameter_order,
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
	}

	/**
	 * Query page data
	 *
	 * @access private
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function _get_page_config($id = '')
	{
		global $db;

		$this->pages_config = array();
		$temp_row = $page_row = $column_row = $block_row = array();
		$sql_page = !empty($id) ? " AND col.page_id = '" . $id . "'" : "";

		// Get page_blocks data
		$sql = "SELECT 	col.page_id,
						col.column_title,
						col.column_order,
						col.column_size,
						pag.page_name,
						pag.page_desc,
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
						blk.block_id,
						mdl.module_path,
						mdl.module_name,						
						fnc.function_file
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

		if (!$result = $db->sql_query($sql))
		{
			mx_message_die(GENERAL_ERROR, "Could not query page information", "", __LINE__, __FILE__, $sql);
		}
		$page_id = 0;
		$column_id = 0;
		
		while ($row = $db->sql_fetchrow($result))
		{
			$next_page = ($row['page_id'] != $page_id) ? true : false;
			$next_column = ($row['column_id'] != $column_id) ? true : false;
			$page_id = $row['page_id'];
			$column_id = $row['column_id'];

			$page_row = array(
				"page_id" => $row['page_id'],
				"page_name" => $row['page_name'],
				"page_desc" => $row['page_desc'],
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
				"column_id" => $row['column_id'],
				//"module_path" => $row['module_path'],
				//"module_name" => $row['module_name'],
				//"function_file" => $row['function_file'],
				//"function_admin" => $row['function_admin']
				);

			if ($next_page)
			{
				$temp_row = array('page_info' => $page_row);
			}
			if ($next_column)
			{
				$temp_row['columns'][] = $column_row;
			}
			$temp_row['blocks'][] = $block_row;
			// Is this a virtual page?
			if ($row['function_file'] == 'mx_virtual.php')
			{
				$temp_row['virtual'] = true;
			}
			else
			{
				$temp_row['virtual'] = false;
			}
			// Compose the pages config array
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
	public function _update_cache( )
	{
		global $db, $mx_root_path, $phpbb_root_path, $mx_use_cache, $portal_config;

		$portal_cache_time = time();

		$sql = "UPDATE ".PORTAL_TABLE."
			SET portal_recached = '$portal_cache_time'
			WHERE portal_id = 1";

		if (!($result = $db->sql_query($sql, BEGIN_TRANSACTION)))
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
	public function read( $id = '', $type = MX_CACHE_BLOCK_TYPE, $force_query = false )
	{
		if ( is_array( $id ) )
		{
			$sub_id = $id['sub_id'];
			$id = $id['id'];
		}
		else
		{
			$sub_id = 0;
		}

		if ( $id > 0 )
		{
			$this->_read_config( $id, $sub_id, $type, $force_query );
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
	public function update( $type = MX_CACHE_ALL, $id = '', $sub_id = 0 )
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
			$this->destroy('_block_' . $id . '_' . $sub_id);
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
	public function trash($type = 'all')
	{
		$dir = opendir($this->cache_dir);
		while (($entry = readdir($dir)) !== false)
		{
			if ($type == 'all')
			{
				if (preg_match('/^(sql_|_block_|_page_|data_(?!global))/', $entry))
				{
					@unlink($this->cache_dir . $entry);
				}
			}
			else if ($type == 'blocks')
			{
				if (preg_match('/^(_block_)/', $entry))
				{
					@unlink($this->cache_dir . $entry);
				}

			}
			else if ($type == 'pages')
			{
				if (preg_match('/^(_page_|_pagemap_)/', $entry))
				{
					@unlink($this->cache_dir . $entry);
				}

			}
			else if ($type == 'install')
			{
				if (preg_match('/^(tpl2_|tpl_|_block_|_page_|data_(?!global))/', $entry)) // Cannot remove tpl cache files currently in use ;)
				{
					@unlink($this->cache_dir . $entry);
				}
			}
		}
		@closedir($dir);
	}
	/**
	* Read cached data from a specified file
	*
	* @access private
	* @param string $filename Filename to write
	* @return mixed False if an error was encountered, otherwise the data type of the cached data
	*/
	public function _read($filename)
	{
		global $phpEx;

		$file = "{$this->cache_dir}$filename.$phpEx";

		$type = substr($filename, 0, strpos($filename, '_'));

		if (!file_exists($file))
		{
			return false;
		}

		if (!($handle = @fopen($file, 'rb')))
		{
			return false;
		}

		// Skip the PHP header
		fgets($handle);

		if ($filename == 'data_global')
		{
			$this->vars = $this->var_expires = array();

			$time = time();

			while (($expires = (int) fgets($handle)) && !feof($handle))
			{
				// Number of bytes of data
				$bytes = substr(fgets($handle), 0, -1);

				if (!is_numeric($bytes) || ($bytes = (int) $bytes) === 0)
				{
					// We cannot process the file without a valid number of bytes
					// so we discard it
					fclose($handle);

					$this->vars = $this->var_expires = array();
					$this->is_modified = false;

					$this->remove_file($file);

					return false;
				}

				if ($time >= $expires)
				{
					fseek($handle, $bytes, SEEK_CUR);

					continue;
				}

				$var_name = substr(fgets($handle), 0, -1);

				// Read the length of bytes that consists of data.
				$data = fread($handle, $bytes - strlen($var_name));
				$data = @unserialize($data);

				// Don't use the data if it was invalid
				if ($data !== false)
				{
					$this->vars[$var_name] = $data;
					$this->var_expires[$var_name] = $expires;
				}

				// Absorb the LF
				fgets($handle);
			}

			fclose($handle);

			$this->is_modified = false;

			return true;
		}
		else
		{
			$data = false;
			$line = 0;

			while (($buffer = fgets($handle)) && !feof($handle))
			{
				$buffer = substr($buffer, 0, -1); // Remove the LF

				// $buffer is only used to read integers
				// if it is non numeric we have an invalid
				// cache file, which we will now remove.
				if (!is_numeric($buffer))
				{
					break;
				}

				if ($line == 0)
				{
					$expires = (int) $buffer;

					if (time() >= $expires)
					{
						break;
					}

					if ($type == 'sql')
					{
						// Skip the query
						fgets($handle);
					}
				}
				else if ($line == 1)
				{
					$bytes = (int) $buffer;

					// Never should have 0 bytes
					if (!$bytes)
					{
						break;
					}

					// Grab the serialized data
					$data = fread($handle, $bytes);

					// Read 1 byte, to trigger EOF
					fread($handle, 1);

					if (!feof($handle))
					{
						// Somebody tampered with our data
						$data = false;
					}
					break;
				}
				else
				{
					// Something went wrong
					break;
				}
				$line++;
			}
			fclose($handle);

			// unserialize if we got some data
			$data = ($data !== false) ? @unserialize($data) : $data;

			if ($data === false)
			{
				$this->remove_file($file);
				return false;
			}

			return $data;
		}
	}

	/**
	* Write cache data to a specified file
	*
	* 'data_global' is a special case and the generated format is different for this file:
	* <code>
	* <?php exit; ?>
	* (expiration)
	* (length of var and serialised data)
	* (var)
	* (serialised data)
	* ... (repeat)
	* </code>
	*
	* The other files have a similar format:
	* <code>
	* <?php exit; ?>
	* (expiration)
	* (query) [SQL files only]
	* (length of serialised data)
	* (serialised data)
	* </code>
	*
	* @access private
	* @param string $filename Filename to write
	* @param mixed $data Data to store
	* @param int $expires Timestamp when the data expires
	* @param string $query Query when caching SQL queries
	* @return bool True if the file was successfully created, otherwise false
	*/
	public function _write($filename, $data = null, $expires = 0, $query = '')
	{
		global $phpEx;

		$file = "{$this->cache_dir}$filename.$phpEx";

		$lock = new mx_lock_flock($file);
		$lock->acquire();

		if ($handle = @fopen($file, 'wb'))
		{
			// File header
			fwrite($handle, '<' . '?php exit; ?' . '>');

			if ($filename == 'data_global')
			{
				// Global data is a different format
				foreach ($this->vars as $var => $data)
				{
					if (strpos($var, "\r") !== false || strpos($var, "\n") !== false)
					{
						// CR/LF would cause fgets() to read the cache file incorrectly
						// do not cache test entries, they probably won't be read back
						// the cache keys should really be alphanumeric with a few symbols.
						continue;
					}
					$data = serialize($data);

					// Write out the expiration time
					fwrite($handle, "\n" . $this->var_expires[$var] . "\n");

					// Length of the remaining data for this var (ignoring two LF's)
					fwrite($handle, strlen($data . $var) . "\n");
					fwrite($handle, $var . "\n");
					fwrite($handle, $data);
				}
			}
			else
			{
				fwrite($handle, "\n" . $expires . "\n");

				if (strpos($filename, 'sql_') === 0)
				{
					fwrite($handle, $query . "\n");
				}
				$data = serialize($data);

				fwrite($handle, strlen($data) . "\n");
				fwrite($handle, $data);
			}

			fclose($handle);

			if (!function_exists('mx_chmod'))
			{
				global $mx_root_path;
				include($mx_root_path . 'includes/mx_functions.' . $phpEx);
			}

			mx_chmod($file, CHMOD_READ | CHMOD_WRITE);

			$return_value = true;
		}
		else
		{
			$return_value = false;
		}

		$lock->release();

		return $return_value;
	}

	/**
	* Removes/unlinks file
	*/
	public function remove_file($filename, $check = false)
	{
		if (!function_exists('phpbb_is_writable'))
		{
			global $phpbb_root_path, $phpEx;
			include($phpbb_root_path . 'includes/functions.' . $phpEx);
		}

		if ($check && !phpbb_is_writable($this->cache_dir))
		{
			// E_USER_ERROR - not using language entry - intended.
			trigger_error('Unable to remove files within ' . $this->cache_dir . '. Please check directory permissions.', E_USER_ERROR);
		}

		return @unlink($filename);
	}
}	

/**
 * Class: cache.
 *
 * This is the MX-Publisher custom cache for eg config data.
 *
 * @package MX-Publisher cache
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

	/**
	* Root path.
	*
	* @var string
	*/
	protected $mx_root_path;

	/**
	* PHP extension.
	*
	* @var string
	*/
	protected $phpEx;	
	
	/**#@-*/

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
		global $mx_root_path, $phpEx;
		
		$this->path = $mx_root_path;
		$this->php_ext = $phpEx;		
		$this->cache_dir = $mx_root_path . 'cache/';
	}	

	/**
	 * Load.
	 *
	 * @access private
	 * @return unknown
	 */
	public function load()
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
	public function save()
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
	public function format_array($array)
	{
		$lines = array();
		foreach ($array as $k => $v)
		{
			if (is_array($v))
			{
				$lines[] = "'$k'=>" . $this->format_array($v);
			}
			elseif (is_int($v))
			{
				$lines[] = "'$k'=>$v";
			}
			elseif (is_bool($v))
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
	 * Replaces variable placeholders in a string with the requested values 
	 * and escapes the values so they can be safely displayed as HTML.
	 * Function to sanitize values.
	 * @access private
	* @param unknown_type $string
	* @return unknown
	 */
	public function format_string($string, array $args = array())
	{
		$k = array();		
		// Transform arguments before inserting them.
		foreach ($args as $k => $v)
		{
			switch ($k[0])
			{
				case '@':
				// Escaped only.
				$args[$k] = htmlspecialchars($v, ENT_QUOTE, 'UTF-8');
				break;
				case '%':
				default:
				// Escaped and placeholder.
				$args[$k] = '<em class="placeholder">' . htmlspecialchars($v, ENT_QUOTE, 'UTF-8') . '</em>';
				break;
				case '!':
				// Pass-through.
			}
		}
		return strtr($string, $args);
	}	

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $query
	 * @return unknown
	 */
	public function sql_load($query)
	{
		global $phpEx;

		// Remove extra spaces and tabs
		$query = preg_replace('/[\n\r\s\t]+/', ' ', $query);
		$query_id = isset($this->sql_rowset) ? sizeof($this->sql_rowset) : 0;

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
			@unlink($this->cache_dir . 'sql_' . md5($query) . ".$phpEx");
			return false;
		}
		return $query_id;
	}
	
	/**
	* {@inheritDoc}.
	 *
	 * @access private
	 * @param unknown_type $query
	 * @param unknown_type $query_result
	 * @param unknown_type $ttl
	 */
	public function sql_save($query, &$query_result, $ttl)
	{
		global $db, $phpEx;
		
		// Remove extra spaces and tabs
		$query = preg_replace('/[\n\r\s\t]+/', ' ', $query);		
		$hash = md5($query);
		
		// determine which tables this query belongs to
		// Some queries use backticks, namely the get_database_size() query
		// don't check for conformity, the SQL would error and not reach here.
		if (!preg_match('/FROM \\(?(`?\\w+`?(?: \\w+)?(?:, ?`?\\w+`?(?: \\w+)?)*)\\)?/', $query, $regs))
		{
			// Bail out if the match fails.
			return $query_result;
		}
		$tables = array_map('trim', explode(',', $regs[1]));
		
		$fp = @fopen($this->cache_dir . 'sql_' . md5($query) . '.' . $phpEx, 'wb');
		@flock($fp, LOCK_EX);
		foreach ($tables as $table_name)
		{
			// Remove backticks
			$table_name = ($table_name[0] == '`') ? substr($table_name, 1, -1) : $table_name;

			if (($pos = strpos($table_name, ' ')) !== false)
			{
				$table_name = substr($table_name, 0, $pos);
			}

			$temp = $this->_read('sql_' . $table_name);

			if ($temp === false)
			{
				$temp = array();
			}

			$temp[$hash] = true;

			// This must never expire
			if ($fp === false)
			{
				$this->_write('sql_' . $table_name, $temp, 0);
			}
			else
			{
				fwrite($fp, "<?php\n\n/*\n$query\n*/\n\n\$temp[\$hash] = " . true . "; ?>");
				@flock($fp, LOCK_UN);
				fclose($fp);
			}						
		}		
		
		// store them in the right place
		$lines = array();
		$query_id = sizeof($this->sql_rowset);
		$query_id = !empty($query_id) ? $query_id : 1;
		$this->sql_rowset[$query_id] = array();
		$this->sql_row_pointer[$query_id] = 0;

		while ($row = $db->sql_fetchrow($query_result))
		{
			$this->sql_rowset[$query_id][] = $row;
			$lines[] = "unserialize('" . str_replace("'", "\\'", str_replace('\\', '\\\\', serialize($row))) . "')";
		}
		$db->sql_freeresult($query_result);
		
		if ($fp === false)
		{
			$this->_write('sql_' . $hash, $this->sql_rowset[$query_id], $ttl);
		}
		else
		{
			@fwrite($fp, "<?php\n\n/*\n$query\n*/\n\n\$expired = (time() > " . (time() + $ttl) . ") ? true : false;\nif (\$expired) { return; }\n\n\$this->sql_rowset[\$query_id] = array(" . implode(',', $lines) . '); ?>');
			@flock($fp, LOCK_UN);
			@fclose($fp);		
		}		
		$query_result = $query_id;
		
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
	public function sql2_save($query, &$query_result, $ttl)
	{
		global $db, $phpEx;

		// Remove extra spaces and tabs
		$query = preg_replace('/[\n\r\s\t]+/', ' ', $query);
		$hash = md5($query);

		if ($fp = @fopen($this->cache_dir . 'sql_' . md5($query) . '.' . $phpEx, 'wb'))
		{
			@flock($fp, LOCK_EX);

			$lines = array();
			$query_id = sizeof($this->sql_rowset);
			$query_id = !empty($query_id) ? $query_id : 1;
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
	public function sql_exists($query_id)
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
	public function sql_fetchrow($query_id)
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
	public function _exists($var_name)
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
	public function unload()
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
	public function tidy()
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
				@unlink($this->cache_dir . $entry);
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
	public function get($var_name)
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
	public function put($var_name, $var, $ttl = 31536000)
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
	public function destroy($var_name, $table = '')
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
				$file = @fread($fp, @filesize($this->cache_dir . $entry));
				@fclose($fp);

				if (preg_match('#/\*.*?\W' . $regex . '\W.*?\*/#s', $file, $m))
				{
					@unlink($this->cache_dir . $entry);
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

	/**
	 * Obtain currently listed icons
	 *
	 * @return unknown
	 */
	public function obtain_icons()
	{
		if (($icons = $this->get('_icons')) === false)
		{
			global $db;

			// Topic icons
			$sql = 'SELECT *
				FROM ' . ICONS_TABLE . '
				ORDER BY icons_order';
			$result = $db->sql_query($sql);

			$icons = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$icons[$row['icons_id']]['img'] = $row['icons_url'];
				$icons[$row['icons_id']]['width'] = (int) $row['icons_width'];
				$icons[$row['icons_id']]['height'] = (int) $row['icons_height'];
				$icons[$row['icons_id']]['display'] = (bool) $row['display_on_posting'];
			}
			$db->sql_freeresult($result);

			$this->put('_icons', $icons);
		}

		return $icons;
	}
	
	/**
	* Obtain ranks
	*/
	public function obtain_ranks()
	{
		if (($ranks = $this->get('_ranks')) === false)
		{
			global $db;

			$sql = 'SELECT *
				FROM ' . RANKS_TABLE . '
				ORDER BY rank_min DESC';
			$result = $db->sql_query($sql);

			$ranks = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if ($row['rank_special'])
				{
					$ranks['special'][$row['rank_id']] = array(
						'rank_title'	=>	$row['rank_title'],
						'rank_image'	=>	$row['rank_image']
					);
				}
				else
				{
					$ranks['normal'][] = array(
						'rank_title'	=>	$row['rank_title'],
						'rank_min'		=>	$row['rank_min'],
						'rank_image'	=>	$row['rank_image']
					);
				}
			}
			$db->sql_freeresult($result);

			$this->put('_ranks', $ranks);
		}

		return $ranks;
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
	 * Virtual block variables
	 *
	 * @access public
	 */
	var $virtual_id = '';
	var $block_virtual_parameters = array();
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
	public function _set_all()
	{
		global $userdata, $lang;
		
		$is_admin = ($userdata['user_level'] == ADMIN && $userdata['session_logged_in']) ? true : 0;
		
		// Weird rewrite for php5 - anyone explaining why wins a medal ;)
		$temp_row = isset($this->block_config[$this->block_id]) ? $this->block_config[$this->block_id] : false;
		$this->block_info = isset($temp_row['block_info']) ? $temp_row['block_info'] : mx_get_info(BLOCK_TABLE, 'block_id', $this->block_id);
		$this->block_parameters = isset($temp_row['block_parameters']) ? $temp_row['block_parameters'] : array();
		unset($temp_row);

		$this->block_id = $this->block_info['block_id'];
		$this->block_title = !empty($lang['blocktitle_' . $this->block_info['block_title']]) ? $lang['blocktitle_' . $this->block_info['block_title']] : $this->block_info['block_title'];
		$this->block_desc = !empty($lang['blocktitle_' . $this->block_info['block_desc']]) ? $lang['blockdesc_' . $this->block_info['block_desc']] : $this->block_info['block_desc'];

		$this->show_block = $this->block_info['show_block'] == '1';
		$this->show_title = $this->block_info['show_title'] == '1';
		$this->show_stats = $this->block_info['show_stats'] == '1';

		$this->_auth_ary = $this->auth( AUTH_ALL );
		$this->auth_view = $this->_auth_ary['auth_view'];
		$this->auth_edit = $this->_auth_ary['auth_edit'];
		$this->auth_mod = isset($this->_auth_ary['auth_mod']) ? $this->_auth_ary['auth_mod'] : $is_admin;

		$this->block_time = $this->block_info['block_time'];
		$this->editor_id = $this->block_info['block_editor_id'];
		
		if (isset($this->block_info['module_root_path']) && !defined('IN_ADMIN'))
		{
			$this->module_root_path = $this->block_info['module_root_path'];
			$this->block_file = $this->block_info['block_file'];
			$this->block_edit_file = $this->block_info['block_edit_file'];
			$this->function_id = $this->block_info['function_id'];
		}
		else
		{
			global $module_root_path;
			$this->module_root_path = isset($this->block_info['module_root_path']) ? $this->block_info['module_root_path'] : $module_root_path;
			$this->block_file = isset($this->block_info['block_file']) ? $this->block_info['block_file'] : '';
			$this->block_edit_file = isset($this->block_info['block_edit_file']) ? $this->block_info['block_edit_file'] : '';
			$this->function_id = isset($this->block_info['block_edit_file']) ? $this->block_info['block_edit_file'] : '';
		}
		$this->is_dynamic = $this->_is_dynamic();
		$this->is_sub = $this->_is_sub();
	}

	/**
	 * Enter description here...
	 * @access private
	 */
	public function _unset()
	{
		unset($this->block_config);
		unset($this->block_info);
		unset($this->block_parameters);
		unset($this->block_virtual_parameters);
		unset($this->block_contents);

		unset($this->block_id);
		unset($this->virtual_id);
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
		unset($this->is_virtual);

		unset($this->init_error_msg);
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @return unknown
	 */
	public function _is_dynamic()
	{
		global $mx_request_vars, $phpEx;

		$is_dynamic = ( ( $this->block_file == 'mx_dynamic.' . $phpEx ) ? true : false );

		if ( $is_dynamic )
		{
			$this->dynamic_block_id = $mx_request_vars->request('dynamic_block', MX_TYPE_INT, $this->block_parameters['default_block_id']['parameter_value']);
		}

		return $is_dynamic;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @return unknown
	 */
	public function _is_sub()
	{
		global $phpEx;
		$is_sub = ( ( $this->block_file == 'mx_multiple_blocks.' . $phpEx ) ? true : false );

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
	public function init( $block_id, $force_query = false )
	{
		global $mx_cache;

		$this->block_id = $block_id;
		$this->block_config = $mx_cache->read( $this->block_id, MX_CACHE_BLOCK_TYPE, $force_query );
		$this->_set_all();
	}

	/**
	 * Enter description here...
	 *
	 */
	public function virtual_init($virtual_id = '', $create_virtual = false)
	{
		global $mx_cache, $userdata;

		if ( empty($virtual_id) )
		{
			return false;
		}

		$this->virtual_id = $virtual_id;

		//
		// Check existance
		//
		$mx_cache->_read_config($this->block_id, $this->virtual_id, MX_CACHE_BLOCK_TYPE); // Try cache
		$this->block_virtual_parameters = $mx_cache->block_config[$this->block_id]['block_parameters'];

		if (!is_array($this->block_virtual_parameters))
		{
			$mx_cache->_read_config($this->block_id, $this->virtual_id, MX_CACHE_BLOCK_TYPE, true); // Query
			$this->block_virtual_parameters = $mx_cache->block_config[$this->block_id]['block_parameters'];
		}

		if (!is_array($this->block_virtual_parameters) && $create_virtual)
		{
			$this->virtual_create($this->virtual_id);
		}

		return is_array($this->block_virtual_parameters);
	}

	/**
	 * Enter description here...
	 *
	 */
	public function virtual_create($virtual_id = '', $project_name = '')
	{
		global $db, $mx_cache;

		if (!$this->block_id)
		{
			return;
		}

		if (!empty($virtual_id))
		{
			if ($virtual_id > 0)
			{
				$sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "(block_id, parameter_id, parameter_value, sub_id)
					SELECT " . $this->block_id . ", parameter_id,   parameter_default, " . intval($virtual_id) . "
					FROM " . PARAMETER_TABLE . " par " . " WHERE function_id = " . $this->function_id;

				if( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, "Couldn't insert block data information", "", __LINE__, __FILE__, $sql);
				}
				$db->sql_freeresult($result);
			}
			else if(!empty($project_name))
			{
				$sql = "SELECT MAX(sub_id) AS max_id FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = '" . $this->block_id . "'";
				if( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, "Couldn't get max_id from block data", "", __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);
				$virtual_id = $row['max_id'] + 1;

				$sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "(block_id, parameter_id, parameter_value, parameter_opt, sub_id)
					SELECT " . $this->block_id . ", parameter_id, parameter_default, '".$project_name."', " . intval($virtual_id) . "
					FROM " . PARAMETER_TABLE . " par " . " WHERE function_id = " . $this->function_id;

				if( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, "Couldn't insert block data information", "", __LINE__, __FILE__, $sql);
				}
				$db->sql_freeresult($result);
			}


		}

		$mx_cache->_read_config($this->block_id, $virtual_id, MX_CACHE_BLOCK_TYPE);
	}

	/**
	 * Enter description here...
	 *
	 */
	public function virtual_update($virtual_id = '', $project_name = '')
	{
		global $db, $mx_cache;

		if (!$this->block_id)
		{
			return;
		}

		if (!empty($virtual_id) && !empty($project_name))
		{
			$sql = "UPDATE " . BLOCK_SYSTEM_PARAMETER_TABLE . "
					SET parameter_opt = '" . $project_name . "'
					WHERE block_id = " . $this->block_id . " AND sub_id = ". intval($virtual_id);
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't update block data information", "", __LINE__, __FILE__, $sql);
			}
			$db->sql_freeresult($result);
		}

		$mx_cache->update(MX_CACHE_BLOCK_TYPE, $this->block_id, $virtual_id);
	}

	/**
	 * Enter description here...
	 *
	 */
	public function virtual_delete($virtual_id = '')
	{
		global $db, $mx_cache, $userdata;

		if (!$this->block_id)
		{
			return;
		}

		//
		// Delete all subdata
		//
		if (!empty($virtual_id))
		{
			$sql = "SELECT block_id FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE sub_id = " . intval($virtual_id);

			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't find block data information", "", __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				$sql_del = "DELETE FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = ".$row['block_id']." AND sub_id = " . intval($virtual_id);

				if( !($result_del = $db->sql_query($sql_del)) )
				{
					mx_message_die(GENERAL_ERROR, "Couldn't delete block data information", "", __LINE__, __FILE__, $sql);
				}

				$mx_cache->update(MX_CACHE_BLOCK_TYPE, $row['block_id'], intval($virtual_id));
			}
			$db->sql_freeresult($result);
		}
	}

	/**
	 * Hide block
	 * @access public
	 */
	public function hide_me()
	{
		$this->show_block = false;
	}

	/**
	 * Destroys block object
	 * @access public
	 */
	public function kill_me()
	{
		$this->_unset();
	}

	/**
	 * Pass block data to main CORE template
	 *
	 * @access public
	 */
	public function output()
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
	public function output_full_page()
	{
		global $layouttemplate, $mx_page;

		mx_message_die(GENERAL_MESSAGE,$this->block_contents);
	}

	/**
	 * Output block stats.
	 * @access public
	 */
	public function output_stats()
	{
		global $layouttemplate, $board_config, $lang, $userdata;

		if ( $this->show_stats && !empty($this->block_time) && !empty($this->editor_id) )
		{
			$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;
			$editor_name_tmp = mx_get_userdata($this->editor_id);
			$editor_name = $editor_name_tmp['username'];
			$edit_time = phpBB2::create_date( $board_config['default_dateformat'], $this->block_time, $board_config['board_timezone'] );

			$layouttemplate->assign_block_vars('layout_column.blocks.block_stats', array(
				'L_BLOCK_UPDATED'	=> $lang['Block_updated_date'],
				'EDITOR_NAME'		=> $is_admin ? $lang['Block_updated_by'] . $editor_name : '',
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
	public function output_hidden_indicator()
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
	public function output_title()
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
	public function output_cp_button($overall_header = false)
	{
		global $layouttemplate, $userdata, $mx_root_path, $mx_page, $lang, $block_size, $images, $phpEx;

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

		$edit_file = !empty( $this->block_edit_file ) ? $this->block_edit_file : 'modules/mx_coreblocks/mx_blockcp.' . $phpEx;

		//
		// Compose buttons and info
		//
		$block_desc = !empty( $this->block_desc ) ? ' (' . $this->block_desc . ')' : '';
		$edit_url = mx_append_sid( $mx_root_path . $edit_file . "?sid=" . $userdata['session_id'] );
		$edit_img = '<input type="image" src="' . $block_edit_img . '" alt="' . $block_edit_alt . ' :: ' . $this->block_title . $block_desc . '" title="' . $block_edit_alt . ' :: ' . $this->block_title . $block_desc . '">';

		$this->virtual_id = isset($this->virtual_id) ? $this->virtual_id : ''; //Virtual Id is Not Set ?		
		
		$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $this->block_id . '" />';
		$s_hidden_fields .= '<input type="hidden" name="dynamic_block" value="' . $this->dynamic_block_id . '" />';
		$s_hidden_fields .= '<input type="hidden" name="virtual" value="' . $this->virtual_id . '" />';

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
	public function get_parameters($key = MX_GET_ALL_PARS, $mode = MX_GET_PAR_VALUE)
	{
		global $mx_request_vars;

		$block_config_temp = '';

		if ($key == MX_GET_ALL_PARS)
		{
			return array_merge($this->block_info, $this->block_parameters);
		}

		if ($mode == MX_GET_PAR_OPTIONS)
		{
			return $this->block_parameters[$key]['parameter_opt'];
		}

		return !empty($this->virtual_id) ? $this->block_virtual_parameters[$key]['parameter_value'] : $this->block_parameters[$key]['parameter_value'];
	}

	/**
	 * Block auth
	 *
	 * @access private
	 * @param integer $type all, view or edit
	 * @return array
	 */
	public function auth($type)
	{
		global $db, $lang, $userdata;

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

		$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;

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
					$auth_user[$auth_fields[$i] . '_type'] = $lang['Auth_Anonymous_Users'];
					break;

				case AUTH_REG:
					$auth_user[$auth_fields[$i]] = ( $userdata['session_logged_in'] ) ? TRUE : 0;
					$auth_user[$auth_fields[$i] . '_type'] = $lang['Auth_Registered_Users'];
					break;

				case AUTH_ANONYMOUS:
					$auth_user[$auth_fields[$i]] = ( ! $userdata['session_logged_in'] ) ? TRUE : 0;
					$auth_user[$auth_fields[$i] . '_type'] = $lang['Auth_Anonymous_Users'];
					break;

				case AUTH_ACL: // PRIVATE
					$auth_user[$auth_fields[$i]] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($this->block_info[$auth_fields_groups[$i]]) || $is_admin : 0;
					$auth_user[$auth_fields[$i] . '_type'] = $lang['Auth_Users_granted_access'];
					break;

				case AUTH_MOD:
					$auth_user[$auth_fields[$i]] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($this->block_info['auth_moderator_group']) || $is_admin : 0;
					$auth_user[$auth_fields[$i] . '_type'] = $lang['Auth_Moderators'];
					break;

				case AUTH_ADMIN:
					$auth_user[$auth_fields[$i]] = $is_admin;
					$auth_user[$auth_fields[$i] . '_type'] = $lang['Auth_Administrators'];
					break;

				default:
					$auth_user[$auth_fields[$i]] = 0;
					break;
			}
		}

		//
		// Is user a moderator?
		//
		$auth_user['auth_mod'] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($this->block_info['auth_moderator_group']) || $is_admin : 0;

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
	
	/**
	 * Load custom module parameters
	 *
	 * @access private
	 * @param unknown_type $parameter_data
	 * @param unknown_type $block_id
	 * @return unknown
	 */
	public function _get_custom_module_parameters($parameter_data, $block_id, $classname = 'mx_module_defs', $include_path = false)
	{
		global $mx_root_path, $phpEx;
		$info_file = "{$classname}.$phpEx";
		if (file_exists((($include_path === false) ? $mx_root_path . $this->module_root_path . 'admin/' : $include_path) . $info_file))
		{
			include_once((($include_path === false) ? $mx_root_path . $this->module_root_path . 'admin/' : $include_path) . $info_file);
			if (class_exists($classname))
			{
				$mx_module_defs = new $classname;
				if (method_exists($mx_module_defs, 'display_module_parameters'))
				{
					$mx_module_defs->display_module_parameters($parameter_data, $block_id);
				}
			}
			//return $mx_module_defs->is_parameter;
		}				
	}

	/**
	 * load custom module panels
	 *
	 * @access private
	 * @param unknown_type $parameter_data
	 * @param unknown_type $block_id
	 */
	public function _get_custom_module_panels($parameter_data, $block_id, $classname = 'mx_module_defs', $include_path = false)
	{
		global $mx_root_path, $phpEx;
		$info_file = "{$classname}.$phpEx";
		if (file_exists((($include_path === false) ? $mx_root_path . $this->module_root_path . 'admin/' : $include_path) . $info_file))
		{
			include_once((($include_path === false) ? $mx_root_path . $this->module_root_path . 'admin/' : $include_path) . $info_file);
			if (class_exists($classname))
			{
				$mx_module_defs = new $classname;
				if (method_exists($mx_module_defs, 'display_module_panels'))
				{
					$mx_module_defs->display_module_panels($parameter_data, $block_id);
				}
			}
			return $mx_module_defs->is_panel;
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
	public function _submit_custom_module_parameters($parameter_data, $block_id)
	{
		global $mx_root_path, $phpEx;

		if ( file_exists( $mx_root_path . $this->module_root_path . 'admin/mx_module_defs.' . $phpEx ) )
		{
			include_once( $mx_root_path . $this->module_root_path . 'admin/mx_module_defs.' . $phpEx );

			if (class_exists('mx_module_defs'))
			{
				$mx_module_defs = new mx_module_defs();

				if (method_exists($mx_module_defs,  'submit_module_parameters'))
				{
					$parameter_custom = $mx_module_defs->submit_module_parameters($parameter_data, $block_id);
					return $parameter_custom;
				}				
			}
		}
		return false;
	}

	/**
	 * check if there is a data in the database
	 *
	 * @access private
	 * @return unknown
	 */
	public function _parameter_data_exist()
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
	public function submit_parameters( $block_id = false )
	{
		global $mx_request_vars, $db, $mx_cache, $lang, $userdata, $mx_bbcode;
		static $message, $return;
		
		$sub_id = $mx_request_vars->is_request('virtual') ? $mx_request_vars->request('virtual', MX_TYPE_INT, 0) : 0;
		$table = BLOCK_SYSTEM_PARAMETER_TABLE;
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
					$parameter_data['sub_id'] = isset($parameter_data['sub_id']) ? $parameter_data['sub_id'] : $sub_id;
					$parameter_value = $mx_request_vars->post($parameter_id, MX_TYPE_NO_TAGS, $parameter_data['parameter_default']);
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
					
					// Update block data
					if ($sub_id == $parameter_data['sub_id'] || true)
					{	
						$sub_id = $mx_request_vars->is_request('virtual') ? $mx_request_vars->request('virtual', MX_TYPE_INT, 0) : $sub_id;
					
						//
						// If standard block
						//
						$sql = "UPDATE " . $table . "
							SET parameter_value		= '" . str_replace("\'", "''", $parameter_value) . "',
								parameter_opt      	= '$parameter_opt'
							WHERE block_id 			= '$block_id'
								AND parameter_id 	= '$parameter_id'
								AND sub_id 	= '$sub_id'";
					}
					else
					{
						//
						// If subblock
						//
						$sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "(block_id, parameter_id, parameter_value, parameter_opt, sub_id)
							VALUES('$block_id','$parameter_id','" . str_replace("\'", "''", $parameter_value) . "','$parameter_opt', '$sub_id')";
					}					

					if( !($db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update system parameter table", "", __LINE__, __FILE__, $sql);
					}

					//
					// Update block itself
					//
					if ($sub_id == $parameter_data['sub_id'] || false)
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
			$mx_cache->update(MX_CACHE_BLOCK_TYPE, $block_id, $sub_id); // Maybe ambitious, but why not ;)
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
	public function load_block_parameters( $block_id = false )
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
	public function display_edit_Separator( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_PlainTextField( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_PlainTextAreaField( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_BBText( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_Html( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_Number( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_Boolean( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_Function( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_Radio_single_select( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_Menu_single_select( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_Menu_multiple_select( $block_id, $parameter_id, $parameter_data )
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
	public function display_edit_Checkbox_multiple_select( $block_id, $parameter_id, $parameter_data )
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
	var $page_navigation_block = '0';

	var $mxbb_copyright_addup = array();
	var $mxbb_css_addup = array();
	var $is_virtual = false;

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

	var $loaded_files = array();


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
	public function init($page_id, $force_query = false)
	{
		global $db, $userdata, $debug, $portal_config, $mx_cache, $lang;

		unset($this->page_rowset);
		unset($this->subpage_rowset);

		$sql = 'SELECT *
			FROM ' . PAGE_TABLE . '
			ORDER BY page_parent, page_order ASC';

		//display an error debuging message only if the portal is installed/upgraded 
		if((!$result = @$db->sql_query($sql)) && @!file_exists('install'))
		{
			mx_message_die(GENERAL_ERROR, 'Couldnt Query pages info', '', __LINE__, __FILE__, $sql);
		}
		elseif((!$result = @$db->sql_query($sql)) && @file_exists('install'))
		{
			mx_message_die(GENERAL_ERROR, "Couldnt Query pages info"."<br />Please finish installin/upgrading the database. <br />".$lang['Please_remove_install_contrib'], "",__LINE__, __FILE__, $sql);
		}
		
		$page_rowset = $db->sql_fetchrowset( $result );

		$db->sql_freeresult( $result );

		for( $i = 0; $i < count( $page_rowset ); $i++ )
		{
			$this->page_rowset[$page_rowset[$i]['page_id']] = $page_rowset[$i];
			$this->subpage_rowset[$page_rowset[$i]['page_parent']][$page_rowset[$i]['page_id']] = $page_rowset[$i];
			$this->total_page++;
		}

		// Load page data
		$this->page_id = $page_id;
	 	$this->page_config = $mx_cache->read( $this->page_id, MX_CACHE_PAGE_TYPE, $force_query );
	 	$this->_set_all();
	}

	/* ------------------------------
	* Private Methods
	*/

	/**
	 * Clean up
	 * @access private
	 */
	public function _core()
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
	public function sync_all()
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
	public function sync( $page_id, $init = true )
	{
		global $db;

		$page_nav = array();
		$this->core_nav($this->page_rowset[$cat_id]['page_parent'], $page_nav);

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
	public function core_nav( $parent_id, &$page_nav )
	{
		if ( !empty( $this->page_rowset[$parent_id] ) )
		{
			$this->core_nav($this->page_rowset[$parent_id]['page_parent'], $page_nav);
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
	public function modified( $true_false = false )
	{
		$this->modified = $true_false;
	}

	/**
	 * Initiate and load page data
	 * @access private
	 */
	public function _set_all()
	{
		global $userdata, $mx_root_path, $mx_request_vars, $portal_config, $theme, $lang;
		global $mx_block, $tplEx, $_GET;

		$this->info = &$this->page_config[$this->page_id]['page_info'];	
		
		$is_admin = ($userdata['user_level'] == ADMIN && $userdata['session_logged_in']) ? true : 0;
	
		/*
		* IP filter
		*/
		$mx_ip = new mx_ip;

		//
		// General
		//
		$this->page_title = !empty($lang['pagetitle_' . $this->info['page_name']]) ? $lang['pagetitle_' . $this->info['page_name']] : $this->info['page_name'];
		$this->page_icon = $this->info['page_icon'];
		$this->page_alt_icon = $this->info['page_alt_icon'];

		$this->default_style = $this->info['default_style'] == -1 ? ($portal_config['default_style']) : ( $this->info['default_style'] );
		$this->override_user_style = $this->info['override_user_style'] == -1 ? ($portal_config['override_user_style'] == 1 ? 1 : 0 ) : ( $this->info['override_user_style'] == 1 ? 1 : 0 );
		//
		// Setup demo style
		//
		if (isset($_GET['strip']) && ($_GET['strip'] == true))
		{
			$this->page_ov_header = 'overall_header_print.'.$tplEx;
		}
		else		
		{
			$this->page_ov_header = !empty($this->info['page_header']) ? $this->info['page_header'] : $portal_config['overall_header'];
		}
		$this->page_ov_footer = !empty($this->info['page_footer']) ? $this->info['page_footer'] : $portal_config['overall_footer'];
		$this->page_main_layout = !empty($this->info['page_main_layout']) ? $this->info['page_main_layout'] : $portal_config['main_layout'];
		$this->phpbb_stats = $this->info['phpbb_stats'] == -1 ? ($portal_config['top_phpbb_links'] == 1 ? true : false ) : ( $this->info['phpbb_stats'] == 1 ? true : false );
		$this->page_navigation_block = $this->info['page_navigation_block'] == 0 ? $portal_config['navigation_block'] : $this->info['page_navigation_block'];

		// Set the public view auth
		$this->_auth_ary = $this->auth();
		$this->auth_view = $this->_auth_ary['auth_view'];
		//$this->auth_mod = $this->_auth_ary['auth_mod'];
		$this->auth_mod = isset($this->_auth_ary['auth_mod']) ? $this->_auth_ary['auth_mod'] : $is_admin;
		$this->auth_ip = $mx_ip->auth($this->info['ip_filter']);

		$this->columns = &$this->page_config[$this->page_id]['columns'];
		$this->total_column = count($this->columns);

		$this->blocks = &$this->page_config[$this->page_id]['blocks'];
		$this->total_block = count($this->blocks);

		$this->block_border_graphics = isset($theme['border_graphics']) ? $theme['border_graphics'] : false;

		$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
		$s_hidden_fields .= '<input type="hidden" name="portalpage" value="' . $this->page_id . '" />';
		$s_hidden_fields .= '<input type="hidden" name="mode" value="setting" />';
		$s_hidden_fields .= $mx_request_vars->is_get('f') ? '<input type="hidden" name="f" value="' . $mx_request_vars->get('f', MX_TYPE_INT) . '" />' : '';
		$s_hidden_fields .= $mx_request_vars->is_get('t') ? '<input type="hidden" name="t" value="' . $mx_request_vars->get('t', MX_TYPE_INT) . '" />' : '';
		$s_hidden_fields .= $mx_request_vars->is_get('p') ? '<input type="hidden" name="p" value="' . $mx_request_vars->get('p', MX_TYPE_INT) . '" />' : '';
		$this->s_hidden_fields = $s_hidden_fields;

		//
		// Generate the fold/unfold menu navigation switches (cookie based)
		//
		$this->editcp_show = ( $userdata['user_level'] == ADMIN && isset($_COOKIE['editCP_switch']) ) ? $_COOKIE['editCP_switch'] == 1 : true;

		$this->is_virtual = isset($this->page_config[$this->page_id]['virtual']) ? $this->page_config[$this->page_id]['virtual'] : false;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $column
	 * @return unknown
	 */
	public function _get_colclass( $column )
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
	public function kill_me()
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
	public function generate_jumpbox($page_id = 0, $depth = 0, $default = '')
	{
		$page_list = '';

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
	public function generate_navigation( $page_id )
	{
		global $template, $db;

		if ( $this->page_rowset[$page_id]['parents_data'] == '' )
		{
			$page_nav = array();
			$this->core_nav($this->page_rowset[$page_id]['page_parent'], $page_nav);

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
	public function add_copyright($key = '')
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
	public function add_css_file($filename = '')
	{
		global $mx_block, $theme, $mx_user;

		if ( file_exists($mx_block->module_root_path . 'templates/' . $mx_user->template_name.'/'.(!empty($filename) ? $filename : $theme['head_stylesheet']) ))
		{
	 		$this->mxbb_css_addup[] = $mx_block->module_root_path . 'templates/' . $mx_user->template_name.'/'.(!empty($filename) ? $filename : $theme['head_stylesheet']);
		}
		else if ( file_exists($mx_block->module_root_path . 'templates/' . $mx_user->cloned_template_name.'/'.(!empty($filename) ? $filename : $mx_user->cloned_template_name)) )
		{
	 		$this->mxbb_css_addup[] = $mx_block->module_root_path . 'templates/' . $mx_user->cloned_template_name.'/'.(!empty($filename) ? $filename : $mx_user->cloned_template_name);
		}
		else
		{
			$this->mxbb_css_addup[] = $mx_block->module_root_path . 'templates/'.$mx_user->default_template_name.'/'.(!empty($filename) ? $filename : $mx_user->default_template_name);
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
	public function add_js_file($path = '')
	{
		//global $mx_block, $module_root_path;
		//$this->mxbb_js_addup[] = $mx_block->module_root_path . $path;
		$this->mxbb_js_addup[] = $path;
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
	public function add_header_text($text = '', $read_file = false)
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
	public function add_footer_text($text = '', $read_file = false)
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
	public function editcp_exists()
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
	public function output_column( $column )
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
	public function auth($auth_data = '', $group_data = '', $moderator_data = '')
	{
		global $db, $lang, $mx_user, $userdata;

		$auth_label = array('auth_view');
		$auth_fields = array('page_auth_view');
		$auth_fields_groups = array('page_auth_view_group');

		$is_admin = ($userdata['user_level'] == ADMIN && $userdata['session_logged_in']) ? TRUE : 0;
		$auth_user['auth_mod'] = $is_admin;
		
		$auth_user = array();
		for( $i = 0; $i < count($auth_fields); $i++ )
		{
			// Fix for making this method useful also other pages, not only current one.
			$auth_data = !empty($auth_data) ? $auth_data : $this->info[$auth_fields[$i]];
			$group_data = !empty($group_data) ? $group_data : $this->info[$auth_fields_groups[$i]];
			$moderator_data = !empty($moderator_data) ? $moderator_data : $this->info['page_auth_moderator_group'];

			switch( $auth_data )
			{
				case AUTH_ALL:
					$auth_user[$auth_label[$i]] = TRUE;
					$auth_user[$auth_label[$i] . '_type'] = $lang['Auth_Anonymous_Users'];
					break;

				case AUTH_REG:
					$auth_user[$auth_label[$i]] = ($userdata['session_logged_in']) ? TRUE : 0;
					$auth_user[$auth_label[$i] . '_type'] = $lang['Auth_Registered_Users'];
					break;

				case AUTH_ANONYMOUS:
					$auth_user[$auth_label[$i]] = (!$userdata['session_logged_in']) ? TRUE : 0;
					$auth_user[$auth_label[$i] . '_type'] = $lang['Auth_Anonymous_Users'];
					break;

				case AUTH_ACL: // PRIVATE
					$auth_user[$auth_label[$i]] = ($userdata['session_logged_in']) ? mx_is_group_member($group_data) || $is_admin : 0;
					$auth_user[$auth_label[$i] . '_type'] = $lang['Auth_Users_granted_access'];
					break;

				case AUTH_MOD:
					$auth_user[$auth_label[$i]] = ($userdata['session_logged_in']) ? mx_is_group_member($moderator_data) || $is_admin : 0;
					$auth_user[$auth_label[$i] . '_type'] = $lang['Auth_Moderators'];
					break;

				case AUTH_ADMIN:
					$auth_user[$auth_label[$i]] = $is_admin;
					$auth_user[$auth_label[$i] . '_type'] = $lang['Auth_Administrators'];
					break;

				default:
					$auth_user[$auth_label[$i]] = 0;
					break;
			}
		}
		// Is user a moderator?
		$auth_user['auth_mod'] = ($userdata['session_logged_in']) ? mx_is_group_member($moderator_data) || $is_admin : 0;

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
	public function mx_getip()
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
	public function auth( $mx_page_allowed_ips = '' )
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
	public function _read($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
	{
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
	public function post($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
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
	public function get($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
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
	public function request($var, $type = MX_TYPE_ANY, $dflt = '', $not_null = false)
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
	public function is_post($var)
	{
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
	public function is_get($var)
	{
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
	public function is_request($var)
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
	public function is_empty_post($var)
	{
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
	public function is_empty_get($var)
	{
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
	public function is_empty_request($var)
	{
		return ($this->is_empty_get($var) && $this->is_empty_post($var)) ? 1 : 0;
	}

}	// class mx_request_vars
?>