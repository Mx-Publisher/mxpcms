<?php
/**
*
* @package AdminCP
* @version $Id: mx_functions_admincp.php,v 1.76 2014/07/07 20:36:52 orynider Exp $
* @copyright (c) 2002-2006 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/**#@+
 * AdminCP Class Flags
 *
 */
define('MX_ADD'							, 20);
define('MX_EDIT'						, 21);

// Types (Mode)
define('MX_MODULE_TYPE'					, 1);
define('MX_FUNCTION_TYPE'				, 2);
define('MX_PARAMETER_TYPE'				, 3);
define('MX_BLOCK_TYPE'					, 4);
define('MX_BLOCK_PARAMETER_TYPE'		, 5);
define('MX_BLOCK_PRIVATE_TYPE'			, 6);
define('MX_BLOCK_SETTINGS_TYPE'			, 7);
define('MX_PAGE_TYPE'					, 8);
define('MX_PAGE_COLUMN_TYPE'			, 9);
define('MX_PAGE_BLOCK_TYPE'				, 10);
define('MX_PAGE_PRIVATE_TYPE'			, 11);
define('MX_PAGE_TEMPLATE_TYPE'			, 12);
define('MX_PAGE_TEMPLATE_COLUMN_TYPE'	, 13);

// Action
define('MX_DO_INSERT'					, 101);
define('MX_DO_UPDATE'					, 102);
define('MX_DO_DELETE'					, 103);
define('MX_DO_MOVE'						, 104);
define('MX_DO_SYNC'						, 105);
define('MX_DO_UPGRADE'					, 106);
define('MX_DO_INSTALL'					, 107);
define('MX_DO_EXPORT'					, 108);

// Flow control
define('MX_ADMIN_DEBUG'					, false);
/**#@-*/

/**
 * Class: mx_admin.
 *
 * The mx_admin class provides all (most) tools for the adminCP Panels - Module area, Module CP, Block CP and Page CP administration.
 *
 * Method:
 * - $mx_admin->do_it( $mode, $action, $id, $parent [optional boolean], $recache [optional boolean] )
 *
 * Actions:
 * - MX_DO_INSERT, MX_DO_UPDATE, MX_DO_DELETE,
 * - MX_DO_MOVE, MX_DO_SYNC,
 * - MX_DO_INSTALL, MX_DO_UPGRADE, MX_DO_EXPORT
 *
 * Types:
 * - MX_MODULE_TYPE, MX_FUNCTION_TYPE, MX_PARAMETER_TYPE,
 * - MX_BLOCK_TYPE, MX_BLOCK_PARAMETER_TYPE, MX_BLOCK_PRIVATE_TYPE, MX_BLOCK_SETTINGS_TYPE,
 * - MX_PAGE_TYPE, MX_PAGE_COLUMN_TYPE, MX_PAGE_BLOCK_TYPE, MX_PAGE_PRIVATE_TYPE,
 * - MX_PAGE_TEMPLATE_TYPE, MX_PAGE_TEMPLATE_COLUMN_TYPE
 *
 * Usage examples:
 *  - $result_message = $mx_admin->do_it(MX_DO_INSERT, MX_BLOCK_TYPE ); // case 'create_block': // Insert
 *  - $result_message = $mx_admin->do_it(MX_DO_DELETE, MX_BLOCK_TYPE, $block_id); // case 'delete_block':
 *  - $result_message = $mx_admin->do_it(MX_DO_UPDATE, MX_BLOCK_TYPE, $block_id); // case 'modify_block':
 *
 * @package AdminCP
 * @author Jon Ohlsson
 * @access public
 *
 */
class mx_admin
{
	/**
	* This will hold the text output for the inputted command (if the mod author would like to display the command that was ran)
	*
	* @var string
	*/
	var $command = '';

	/**
	* This will hold the text output for the result of the command.  $user->lang['SUCCESS'] if everything worked.
	*
	* @var string
	*/
	var $result = '';

	/**
	* Auto run $this->display_results after running a command
	*/
	var $auto_display_results = false;

	/**
	* Stand Alone option (this makes it possible to just use the single umil file and not worry about any language stuff
	*/
	var $stand_alone = false;

	/**
	* Were any new permissions added (used in umil_frontend)?
	*/
	var $permissions_added = false;

	/**
	* Database Object
	*/
	var $db = false;

	/**
	* Database Tools Object
	*/
	var $db_tools = false;

	/**
	* Do we want a custom prefix besides the phpBB table prefix?  You *probably* should not change this...
	*/
	var $table_prefix = false;	
	
	/**#@-*/
	
	/**
	* Constructor
	*/
	function mx_admin($stand_alone = true, $db = false)
	{
		// Setup $this->db
		if ($db == true)
		{
			if (!is_object($db) || !method_exists($db, 'sql_query'))
			{
				trigger_error('Invalid $db Object');
			}

			$this->db = $db;
		}
		else
		{
			global $db;
			$this->db = $db;
		}

		// Setup $this->db_tools
		if (!class_exists('mx_db_tools'))
		{
			global $mx_root_path, $phpEx;
			include($mx_root_path . 'includes/db/db_tools.' . $phpEx);
		}
		$this->db_tools = new mx_db_tools($this->db);

		$this->stand_alone = $stand_alone;

		if (!$stand_alone)
		{
			global $portal_config, $mx_user, $mx_root_path, $phpEx;
			// Include the language keys.  First we check if the language file for the user's language is available, if not we check if the board's default language is available, if not we use the english file.
			//todo@  Dont foget to add any lang keys required to lang_admin.php
		}
	}
	
	// ------------------------------
	// Private Methods
	//
	//

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $type
	 * @param unknown_type $id
	 * @return unknown
	 */
	function _do_insert($type, $id )
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $userdata, $mx_request_vars, $mx_cache;

		switch ( $type )
		{
			case MX_MODULE_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ( $mx_request_vars->is_empty_post('module_name'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$sql = "INSERT INTO " . MODULE_TABLE . " (module_name, module_desc, module_path, module_include_admin)
							VALUES( '" . $mx_request_vars->post('module_name', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
								'" . $mx_request_vars->post('module_desc', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
								'" . $mx_request_vars->post('module_path', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
								'" . $mx_request_vars->post('module_include_admin', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "' )";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert module information", "", __LINE__, __FILE__, $sql);
					}
				}

				$sql = "SELECT MAX(module_id) AS next_id FROM " . MODULE_TABLE;
				if( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, "Couldn't find max module_id", "", __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);

				$module_id_new = $row['next_id'];

				//
				// Update Cache
				//
				// No update needed ;)
				$message['text'] = $lang['AdminCP_action'] . ": " . $lang['Module'] . ' (' . $mx_request_vars->post('module_name', MX_TYPE_NO_TAGS, 'error - no name given') . ') ' . $lang['was_inserted'];
				$message['new_module_id'] = $module_id_new;

			break;

			case MX_FUNCTION_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('function_name'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$sql = "INSERT INTO " . FUNCTION_TABLE . " (module_id, function_name, function_desc, function_file, function_admin)
							VALUES( " . intval($id) . ",
								'" . $mx_request_vars->post('function_name', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
								'" . $mx_request_vars->post('function_desc', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
								'" . $mx_request_vars->post('function_file', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
								'" . $mx_request_vars->post('function_admin', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "' )";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert function information", "", __LINE__, __FILE__, $sql);
					}

					//
					// Update Cache
					//
					// No update needed ;)
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Function'] . ' (' . $mx_request_vars->post('function_name', MX_TYPE_NO_TAGS, 'error - no name given') . ') ' . $lang['was_inserted'];

			break;

			case MX_PARAMETER_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('parameter_name'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$function_id = intval($id);
					$parameter_name = $mx_request_vars->post('parameter_name', MX_TYPE_NO_TAGS, '');
					$parameter_type = $mx_request_vars->post('parameter_type', MX_TYPE_NO_TAGS, '');
					$parameter_auth = $mx_request_vars->post('parameter_auth', MX_TYPE_INT, '0');
					$parameter_default = $mx_request_vars->post('parameter_default', MX_TYPE_POST_VARS, '');
					$data = $mx_request_vars->post('parameter_function', MX_TYPE_POST_VARS, '');

					//
					// Format the additional parameter data
					//
					if ( !empty( $data ) &&  $parameter_type != 'Function' )
					{
						$data = explode( "\n", htmlspecialchars( trim( $data ) ) );

						foreach( $data as $key => $value )
						{
							$data[$key] = trim( $value );
						}
						$data = addslashes( serialize( $data ) );
					}

					//
					// Format the default value for the multiple select fields
					//
					if ( !empty( $parameter_default ) &&  ($parameter_type == 'Menu_multiple_select' || $parameter_type == 'Checkbox_multiple_select') )
					{
						$parameter_default = explode( "\n", htmlspecialchars( trim( $parameter_default ) ) );

						foreach( $parameter_default as $key => $value )
						{
							$parameter_default[$key] = trim( $value );
						}
						$parameter_default = addslashes( serialize( $parameter_default ) );
					}

					if ( ( ( $parameter_type == RADIO || $parameter_type == SELECT || $parameter_type == SELECT_MULTIPLE || $parameter_type == CHECKBOX ) && empty( $data ) ) )
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					//
					// Insert New Parameter
					//
					$sql = "INSERT INTO " . PARAMETER_TABLE . " (function_id, parameter_name, parameter_type, parameter_auth, parameter_default, parameter_function)
							VALUES( " . $function_id . ",
								'" . str_replace("\'", "''", $parameter_name) . "',
								'" . str_replace("\'", "''", $parameter_type) . "',
								'" . str_replace("\'", "''", $parameter_auth) . "',
								'" . str_replace("\'", "''", $parameter_default) . "',
								'" . str_replace("\'", "''", $data) . "' )";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert parameter information", "", __LINE__, __FILE__, $sql);
					}

					//
					// Now update affected block_id(s)
					// This function also updates the cache
					//
					$message_tmp = $this->update_block_parameter_data($function_id);
					$message_tmp = !empty($message_tmp) ? '<br /><br />' . $message_tmp : '';

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Parameter'] . ' (' . $mx_request_vars->post('parameter_name', MX_TYPE_NO_TAGS, 'error - no name given') . ') ' . $lang['was_inserted'] . $message_tmp;

			break;

			case MX_BLOCK_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('block_title'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					//
					// Default permissions of public ::
					//
					$field_sql = '';
					$value_sql = '';

					$sql = "SELECT MAX(block_id) AS next_id FROM " . BLOCK_TABLE;
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert row in blocks table", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);

					$next_id = $row[next_id] + 1;

					if( empty($next_id) )
					{
						$next_id = 1;
					}

					$function_id = intval($id);
					$block_time = time();
					$block_editor_id = intval($userdata['user_id']);

					$sql = "INSERT INTO " . BLOCK_TABLE . " (block_id, block_title, block_desc, block_time, block_editor_id, function_id, auth_view, auth_edit, show_block, show_title, show_stats)
						VALUES ('" . $next_id . "',
							'" . $mx_request_vars->post('block_title', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
							'" . $mx_request_vars->post('block_desc', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
							'" . $block_time . "',
							'" . $block_editor_id . "',
							'" . $function_id . "',
							'" . $mx_request_vars->post('auth_view', MX_TYPE_INT, '0') . "' ,
							'" . $mx_request_vars->post('auth_edit', MX_TYPE_INT, '5') . "' ,
							'" . $mx_request_vars->post('show_block', MX_TYPE_INT, '1') . "' ,
							'" . $mx_request_vars->post('show_title', MX_TYPE_INT, '1') . "' ,
							'" . $mx_request_vars->post('show_stats', MX_TYPE_INT, '0') . "' )";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert row in blocks table", "", __LINE__, __FILE__, $sql);
					}

					//
					// Insert the parameters
					//
					$sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "(block_id, parameter_id, parameter_value)
						SELECT " . $next_id . ", parameter_id,   parameter_default
							FROM " . PARAMETER_TABLE . " par " . " WHERE function_id = " . $function_id;

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert parameter information", "", __LINE__, __FILE__, $sql);
					}

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_BLOCK_TYPE, $next_id);

				}
				$message['text'] = $lang['AdminCP_action'] . ": " . $lang['Block'] . ' (' . $mx_request_vars->post('block_title', MX_TYPE_NO_TAGS, 'error - no name given') . ') ' . $lang['was_inserted'];
				$message['new_id'] = $next_id;

			break;

			case MX_PAGE_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('page_name'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					//$page_id_new = $mx_request_vars->post('page_id_new', MX_TYPE_INT, 0);
					$page_name = $mx_request_vars->post('page_name', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$page_desc = $mx_request_vars->post('page_desc', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$page_parent = $mx_request_vars->post('page_parent', MX_TYPE_INT, '');
					$page_icon = $mx_request_vars->post('menuicons', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$page_alt_icon = $mx_request_vars->post('page_alt_icon', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$default_style = $mx_request_vars->post('mx_default_style', MX_TYPE_INT, '-1');
					$override_user_style = $mx_request_vars->post('mx_override_user_style', MX_TYPE_INT, '-1');
					$page_header = $mx_request_vars->post('page_header', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$page_footer = $mx_request_vars->post('page_footer', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$page_main_layout = $mx_request_vars->post('page_main_layout', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$navigation_block = $mx_request_vars->post('navigation_block', MX_TYPE_INT, '0');
					$auth_view = $mx_request_vars->post('auth_view', MX_TYPE_INT, 0);

					$ipfilter = $mx_request_vars->post('ip_filter', MX_TYPE_POST_VARS, '');
					$phpbb_stats = $mx_request_vars->post('phpbb_stats', MX_TYPE_INT, '-1');

					//
					// Format the mod_rewrite array
					//
					$ipfilter = explode( "\n", htmlspecialchars( trim( $ipfilter ) ) );

					foreach( $ipfilter as $key => $value )
					{
						$ipfilter[$key] = trim( $value );
					}
					$ipfilter = addslashes( serialize( $ipfilter ) );

					$sql = "SELECT MAX(page_id) AS next_id,  MAX(page_order) AS next_order FROM " . PAGE_TABLE;
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't find max page_id", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);

					$page_id_new = $row['next_id'] + 1;

					$page_order_new = $row['next_order'] + 1;

					if( empty($page_id_new) )
					{
						die('Couldn\'t find max page_id');
					}

					if( empty($page_order_new) )
					{
						$page_order_new = 0;
					}

					$page_row = array(
						"page_id"				=> (int) $page_id_new,
						"page_name"				=> $page_name,
						"page_desc"				=> $page_desc,
						"page_parent"			=> (int) $page_parent,
						"parents_data"			=> (int) $parents_data,
						"page_order"			=> (int) $page_order_new,
						"page_icon"				=> $page_icon,
						"page_alt_icon"			=> $page_alt_icon,
						"auth_view"				=> (int) $auth_view,
						"default_style"			=> (int) $default_style,
						"override_user_style"	=> (int) $override_user_style,
						"page_header"			=> $page_header,
						"page_footer"			=> $page_footer,
						"page_main_layout"		=> $page_main_layout,
						"navigation_block"		=> (int) $navigation_block,
						"ip_filter"				=> $ipfilter ,
						"phpbb_stats"			=> (int) $phpbb_stats,
						);

					$sql = "INSERT INTO " . PAGE_TABLE . $db->sql_build_array('INSERT', $page_row);

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert page information", '', __LINE__, __FILE__, $sql);
					}

					//
					// Page templates
					//
					$use_template = $mx_request_vars->post('use_template', MX_TYPE_INT, 0);

					if( $use_template > 0 )
					{
						$sql = " SELECT * FROM " . COLUMN_TEMPLATES . " WHERE page_template_id = " . $use_template;
						if( !($result = $db->sql_query($sql)) )
						{
							mx_message_die(GENERAL_ERROR, "Couldn't get list of Columns for this template", '', __LINE__, __FILE__, $sql);
						}

						$row = $db->sql_fetchrowset($result);

						for( $row_count = 0; $row_count < count($row); $row_count++ )
						{
							$sql1 = "INSERT INTO " . COLUMN_TABLE . " (column_title, column_order, column_size, page_id)
								VALUES ( '" . $row[$row_count]['column_title'] . "', '" . $row[$row_count]['column_order'] . "', '" . $row[$row_count]['column_size'] . "', '$page_id_new' )";
							if( !($result = $db->sql_query($sql1)) )
							{
								mx_message_die(GENERAL_ERROR, "Couldn't insert page information", '', __LINE__, __FILE__, $sql);
							}
						}
					}

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id_new);

				}
				$message['text'] = $lang['AdminCP_action'] . ": " . $lang['Page'] . ' (' . $mx_request_vars->post('page_name', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_inserted'];
				$message['new_page_id'] = $page_id_new;

			break;

			case MX_PAGE_COLUMN_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('column_title'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$page_id = $mx_request_vars->post('page_id', MX_TYPE_INT, 0);
					$column_title = $mx_request_vars->post('column_title', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$column_size = $mx_request_vars->post('column_size', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');

					$sql = "SELECT MAX(column_order) AS max_order FROM " . COLUMN_TABLE . " WHERE page_id = '" . $page_id . "'";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get order number from column table", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);

					$max_order = $row['max_order'];
					$next_order = intval($max_order + 10);
					
					// There is no problem having duplicate page names so we won't check for it.
					$sql = "INSERT INTO " . COLUMN_TABLE . " (column_title, column_order, column_size, page_id)
						VALUES ('" . $column_title . "',  $next_order, '" . $column_size . "', $page_id)";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert row in column table", "", __LINE__, __FILE__, $sql);
					}

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id);

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Column'] . ' (' . $mx_request_vars->post('column_title', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_inserted'];

			break;

			case MX_PAGE_BLOCK_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					//
					// First create split, dynamic or virtual blocks - if needed
					//
					if ($mx_request_vars->is_request('action_type'))
					{
						switch ($mx_request_vars->request('action_type'))
						{
							case 'split':
								$temp_row = mx_get_info(FUNCTION_TABLE, 'function_file', 'mx_multiple_blocks.php');
								$_POST['block_title'] = 'Split Column';
								$_POST['block_desc'] = 'Page: ' . $mx_request_vars->post('page_id', MX_TYPE_INT, 0);
								$message = $this->do_it(MX_BLOCK_TYPE, MX_DO_INSERT, $temp_row['function_id']);
								$_POST['block_id'] = $message['new_id'];
							break;

							case 'dynamic':
								$temp_row = mx_get_info(FUNCTION_TABLE, 'function_file', 'mx_dynamic.php');
								$_POST['block_title'] = 'Dynamic (Sub)';
								$_POST['block_desc'] = 'Page: ' . $mx_request_vars->post('page_id', MX_TYPE_INT, 0);
								$message = $this->do_it(MX_BLOCK_TYPE, MX_DO_INSERT, $temp_row['function_id']);
								$_POST['block_id'] = $message['new_id'];
							break;

							case 'virtual':
								$temp_row = mx_get_info(FUNCTION_TABLE, 'function_file', 'mx_virtual.php');
								$_POST['block_title'] = 'Virtual (Blog)';
								$_POST['block_desc'] = 'Page: ' . $mx_request_vars->post('page_id', MX_TYPE_INT, 0);
								$message = $this->do_it(MX_BLOCK_TYPE, MX_DO_INSERT, $temp_row['function_id']);
								$_POST['block_id'] = $message['new_id'];
							break;
						}
					}

					if ($mx_request_vars->is_empty_post('block_id'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$column_id = $mx_request_vars->post('id', MX_TYPE_INT, 0);
					$block_id = $mx_request_vars->post('block_id', MX_TYPE_INT, 0);

					$sql = "SELECT MAX(block_order) AS max_order FROM " . COLUMN_BLOCK_TABLE . " WHERE column_id = '" . $column_id . "'";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get order number from column table", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);

					$max_order = $row['max_order'];
					$next_order = intval($max_order + 10);

					$sql = "INSERT INTO " . COLUMN_BLOCK_TABLE . " (column_id,  block_id,  block_order)
						VALUES ( $column_id, $block_id, $next_order )";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't add new block", "", __LINE__, __FILE__, $sql);
					}

					//
					// Get parent page id, to update cache
					//
					$sql = " SELECT page_id FROM " . COLUMN_TABLE . " WHERE column_id = '" . $column_id . "'";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get list of Columns for this template", '', __LINE__, __FILE__, $sql);
					}

					$row = $db->sql_fetchrow($result);
					$page_id = $row['page_id'];

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id);
					$mx_cache->destroy('_pagemap_block' . $block_id);
					// We also need to destroy the cache for the function file...later

					//
					// ??????
					//
					//$this->move('block', $column_id, $page_id);

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Block'] . $lang['was_inserted'];

			break;

			case MX_PAGE_TEMPLATE_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('template_name'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$template_name = $mx_request_vars->post('template_name', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');

					$sql = "INSERT INTO " . PAGE_TEMPLATES . " ( template_name ) VALUES ( '$template_name' )";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't add new template", "", __LINE__, __FILE__, $sql);
					}

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Page_template'] . ' (' . $mx_request_vars->post('template_name', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_inserted'];

			break;

			case MX_PAGE_TEMPLATE_COLUMN_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('column_title') )
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$page_template_id = $mx_request_vars->post('page_template_id', MX_TYPE_INT, 0);
					$column_title = $mx_request_vars->post('column_title', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$column_size = $mx_request_vars->post('column_size', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');

					$sql = "SELECT MAX(column_order) AS max_order FROM " . COLUMN_TEMPLATES . " WHERE page_template_id = '" . $page_template_id . "'";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get order number from column template table", "", __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);

					$max_order = $row['max_order'];
					$next_order = $max_order + 10;

					//
					// There is no problem having duplicate page names so we won't check for it.
					//
					$sql = "INSERT INTO " . COLUMN_TEMPLATES . " (column_title, column_order, column_size, page_template_id)
						VALUES ('" . $column_title . "',  $next_order, '" . $column_size . "', $page_template_id)";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't insert row in column table", "", __LINE__, __FILE__, $sql);
					}

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Page_template_column'] . ' (' . $mx_request_vars->post('column_title',MX_TYPE_NO_TAGS) . ') ' . $lang['was_inserted'];

			break;


			default:
				$message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];
			break;
		}

		return $message;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $type
	 * @param unknown_type $id
	 * @return unknown
	 */
	function _do_update($type, $id )
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $userdata, $mx_request_vars, $mx_cache;

		switch ( $type )
		{
			case MX_MODULE_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('module_name'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$sql = "UPDATE " . MODULE_TABLE . "
							SET module_name = '" . $mx_request_vars->post('module_name', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
								module_desc = '" . $mx_request_vars->post('module_desc', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
								module_path = '" . $mx_request_vars->post('module_path', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
								module_include_admin = '" . $mx_request_vars->post('module_include_admin', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "'
							WHERE module_id = " . intval($id);

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update module information", "", __LINE__, __FILE__, $sql);
					}

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_ALL); // Maybe ambitious, but why not ;)
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Module'] . ' (' . $mx_request_vars->post('module_name', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'];

			break;

			case MX_FUNCTION_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('function_name'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$sql = "UPDATE " . FUNCTION_TABLE . "
						SET function_name = '" . $mx_request_vars->post('function_name', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
							function_desc = '" . $mx_request_vars->post('function_desc', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
							function_file = '" . $mx_request_vars->post('function_file', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
							function_admin = '" . $mx_request_vars->post('function_admin', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "'
						WHERE function_id = " . intval($id);

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update function information", "", __LINE__, __FILE__, $sql);
					}

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_ALL); // Maybe ambitious, but why not ;)
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Function'] . ' (' . $mx_request_vars->post('function_name', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'];

			break;

			case MX_PARAMETER_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('parameter_name'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$parameter_id = intval($id);
					$function_id = $mx_request_vars->post('function_id', MX_TYPE_INT, '0');
					$parameter_name = $mx_request_vars->post('parameter_name', MX_TYPE_NO_TAGS, '');
					$parameter_type = $mx_request_vars->post('parameter_type', MX_TYPE_NO_TAGS, '');
					$parameter_auth = $mx_request_vars->post('parameter_auth', MX_TYPE_INT, '0');
					$parameter_default = $mx_request_vars->post('parameter_default', MX_TYPE_POST_VARS, '');
					$data = $mx_request_vars->post('parameter_function', MX_TYPE_POST_VARS, '');

					//
					// Format the additional parameter data
					//
					if ( !empty( $data ) &&  $parameter_type != 'Function' )
					{
						$data = explode( "\n", htmlspecialchars( trim( $data ) ) );

						foreach( $data as $key => $value )
						{
							$data[$key] = trim( $value );
						}
						$data = addslashes( serialize( $data ) );
					}
					else
					{
						$data = addslashes( $data );
					}

					//
					// Format the default value for the multiple select fields
					//
					if ( !empty( $parameter_default ) &&  ($parameter_type == 'Menu_multiple_select' || $parameter_type == 'Checkbox_multiple_select') )
					{
						$parameter_default = explode( "\n", htmlspecialchars( trim( $parameter_default ) ) );

						foreach( $parameter_default as $key => $value )
						{
							$parameter_default[$key] = trim( $value );
						}
						$parameter_default = addslashes( serialize( $parameter_default ) );
					}

					if ( ( ( $parameter_type == RADIO || $parameter_type == SELECT || $parameter_type == SELECT_MULTIPLE || $parameter_type == CHECKBOX ) && empty( $data ) ) )
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$sql = "UPDATE " . PARAMETER_TABLE . "
						SET parameter_name = '" . str_replace("\'", "''", $parameter_name) . "',
							parameter_type = '" . str_replace("\'", "''", $parameter_type) . "',
							parameter_auth = '" . str_replace("\'", "''", $parameter_auth) . "',
							parameter_default = '" . str_replace("\'", "''", $parameter_default) . "',
							parameter_function = '" . str_replace("\'", "''", $data) . "'
						WHERE parameter_id = " . $parameter_id;

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update parameter information", "", __LINE__, __FILE__, $sql);
					}

					//
					// Now update affected block_id(s)
					// ...and cache
					//
					if (empty($function_id))
					{
						//
						// First get function_id (for later block data refresh)
						//
						$sql = "SELECT function_id FROM " . PARAMETER_TABLE . " WHERE parameter_id = " . $parameter_id . " LIMIT 1";
						if( !($result = $db->sql_query($sql)) )
						{
							mx_message_die(GENERAL_ERROR, "Couldn't get parameter information", "", __LINE__, __FILE__, $sql);
						}
						$temp_row = $db->sql_fetchrow($result);
						$function_id = $temp_row['function_id'];
					}

					$message_tmp = $this->update_block_parameter_data($function_id);
					$message_tmp = !empty($message_tmp) ? '<br /><br />' . $message_tmp : '';

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Parameter'] . ' (' . $mx_request_vars->post('parameter_name', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'] . $message_tmp;

			break;

			case MX_BLOCK_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('block_title'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$block_id = intval($id);
					//
					// Now get function_id
					//
					$sql = "SELECT function_id FROM " . BLOCK_TABLE . " WHERE block_id = " . $block_id . " LIMIT 1";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get block information", "", __LINE__, __FILE__, $sql);
					}
					$row_temp = $db->sql_fetchrow($result);
					$function_id = $row_temp['function_id'];

					$block_time = time();
					$block_editor_id = intval($userdata['user_id']);

					$sql = "UPDATE " . BLOCK_TABLE . "
						SET block_title	= '" . $mx_request_vars->post('block_title', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
							block_desc	= '" . $mx_request_vars->post('block_desc', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
							block_time = '" . $block_time . "',
							block_editor_id = '" . $block_editor_id . "',
							auth_view	= '" . $mx_request_vars->post('auth_view', MX_TYPE_INT, '') . "' ,
							auth_edit	= '" . $mx_request_vars->post('auth_edit', MX_TYPE_INT, '') . "' ,
							show_block	= '" . $mx_request_vars->post('show_block', MX_TYPE_INT, '') . "',
							show_title	= '" . $mx_request_vars->post('show_title', MX_TYPE_INT, '') . "',
							show_stats	= '" . $mx_request_vars->post('show_stats', MX_TYPE_INT, '') . "'
						WHERE block_id = " . $block_id;

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update block information", "", __LINE__, __FILE__, $sql);
					}

					/*
					//
					// delete the old parameters when user change the fonction_id of a block
					//
					$sql = "SELECT parameter_id FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = " . $block_id;
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get block_system_parameter information", "", __LINE__, __FILE__, $sql);
					}

					$sys_param_rows = $db->sql_fetchrowset($result);

					for( $p = 0; $p < count($sys_param_rows); $p++ )
					{
						$sql_cnt = "SELECT COUNT(*) AS total FROM " . PARAMETER_TABLE . " WHERE function_id = " . $function_id . " AND parameter_id = " . $sys_param_rows[$p]['parameter_id'];
						if( !($result_cnt = $db->sql_query($sql_cnt)) )
						{
							mx_message_die(GENERAL_ERROR, "Couldn't get block_system_parameter information", "", __LINE__, __FILE__, $sql_cnt);
						}
						$count = $db->sql_fetchrow($result_cnt);
						$count = $count['total'];

						if( $count == 0 )
						{
							$sql_del = "DELETE FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = $block_id AND parameter_id = " . $sys_param_rows[$p]['parameter_id'];
							$result_del = $db->sql_query($sql_del);
						}
					}

					//
					// insert the new parameters when user change the fonction_id of a block
					//
					$sql = "SELECT parameter_id FROM " . PARAMETER_TABLE . " WHERE function_id = " . $function_id;
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get parameter information", "", __LINE__, __FILE__, $sql);
					}

					$sys_param_rows = $db->sql_fetchrowset($result);

					for( $p = 0; $p < count($sys_param_rows); $p++ )
					{
						$sql_cnt = "SELECT COUNT(*) AS total FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = " . $block_id . " AND parameter_id = " . $sys_param_rows[$p]['parameter_id'];
						if( !($result = $db->sql_query($sql_cnt)) )
						{
							mx_message_die(GENERAL_ERROR, "Couldn't get block_system_parameter information", "", __LINE__, __FILE__, $sql);
						}

						$count = $db->sql_fetchrow($result);
						$count = $count['total'];

						if( $count == 0 )
						{
							$sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "( block_id, parameter_id, parameter_value )
								SELECT " . $block_id . ", parameter_id, parameter_default
									FROM " . PARAMETER_TABLE . " par " . " WHERE function_id = " . $function_id;
							if( !($result = $db->sql_query($sql)) )
							{
								mx_message_die(GENERAL_ERROR, "Couldn't insert parameter information", "", __LINE__, __FILE__, $sql);
							}
						}
					}
					*/

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_BLOCK_TYPE, $block_id);

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Block'] . ' (' . $mx_request_vars->post('block_title', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'];

			break;

			case MX_BLOCK_PRIVATE_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					$block_id = intval($id);
					$view_groups = @implode(',', $mx_request_vars->post('view', MX_TYPE_NO_STRIP, ''));
					$edit_groups = @implode(',', $mx_request_vars->post('edit', MX_TYPE_NO_STRIP, ''));
					$moderator_groups = @implode(',', $mx_request_vars->post('moderator', MX_TYPE_NO_STRIP, ''));
					
					//$view_groups = $mx_request_vars->post('view', MX_TYPE_NO_STRIP, '');
					
					//die("$view_groups");

					$sql = "UPDATE " . BLOCK_TABLE . "
						SET auth_view_group = '$view_groups',
							auth_edit_group = '$edit_groups',
							auth_moderator_group = '$moderator_groups'
						WHERE block_id = '$block_id'";

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not update Block Private table', '', __LINE__, __FILE__, $sql);
					}

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_BLOCK_TYPE, $block_id);

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Block'] . ' - ' . $lang['Permissions_adv'] . $lang['was_updated'];

			break;

			case MX_PAGE_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('page_name'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$page_id = intval($id);

					$page_name = $mx_request_vars->post('page_name', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$page_desc = $mx_request_vars->post('page_desc', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$page_parent = $mx_request_vars->post('page_parent', MX_TYPE_INT, '');
					$page_icon = $mx_request_vars->post('menuicons', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$page_alt_icon = $mx_request_vars->post('page_alt_icon', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$default_style = $mx_request_vars->post('mx_default_style', MX_TYPE_INT, '-1');
					$override_user_style = $mx_request_vars->post('mx_override_user_style', MX_TYPE_INT, '-1');
					$page_header = $mx_request_vars->post('page_header', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$page_footer = $mx_request_vars->post('page_footer', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$page_main_layout = $mx_request_vars->post('page_main_layout', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
					$navigation_block = $mx_request_vars->post('navigation_block', MX_TYPE_INT, '0');
					$auth_view = $mx_request_vars->post('auth_view', MX_TYPE_INT, 0);
					$ipfilter = $mx_request_vars->post('ip_filter', MX_TYPE_POST_VARS, '');
					$phpbb_stats = $mx_request_vars->post('phpbb_stats', MX_TYPE_INT, '-1');

					//
					// Format the mod_rewrite array
					//
					$ipfilter = explode( "\n", htmlspecialchars( trim( $ipfilter ) ) );

					foreach( $ipfilter as $key => $value )
					{
						$ipfilter[$key] = trim( $value );
					}
					$ipfilter = addslashes( serialize( $ipfilter ) );

					$sql = "UPDATE " . PAGE_TABLE . "
						SET page_name         = '$page_name',
							page_desc         = '$page_desc',
							page_parent       = '$page_parent',
							page_icon         = '$page_icon',
							page_alt_icon     = '$page_alt_icon',
							default_style     = '$default_style',
							override_user_style = '$override_user_style',
							page_header       = '$page_header',
							page_footer       = '$page_footer',
							page_main_layout  = '$page_main_layout',
							navigation_block  = '$navigation_block',
							auth_view         = '$auth_view',
							ip_filter         = '$ipfilter',
							phpbb_stats       = '$phpbb_stats'
						WHERE page_id = $page_id";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die( GENERAL_ERROR, "Couldn't update page information", '', __LINE__, __FILE__, $sql);
					}

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id);

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Page'] . ' (' . $mx_request_vars->post('page_name', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'];

			break;

			case MX_PAGE_COLUMN_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('column_title'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$sql = "UPDATE " . COLUMN_TABLE . "
						SET column_title = '" . $mx_request_vars->post('column_title', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
							column_size  = '" . $mx_request_vars->post('column_size', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "'
						WHERE column_id = " . $mx_request_vars->post('id', MX_TYPE_INT, '');

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update block information", "", __LINE__, __FILE__, $sql);
					}

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_PAGE_TYPE, $mx_request_vars->post('page_id', MX_TYPE_INT, 0));
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Column'] . ' (' . $mx_request_vars->post('column_title', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'];

			break;

			case MX_PAGE_PRIVATE_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					$page_id = intval($id);
					$view_groups = @implode(',', $mx_request_vars->post('view', MX_TYPE_NO_STRIP, ''));
					$moderator_groups = @implode(',', $mx_request_vars->post('moderator', MX_TYPE_NO_STRIP, ''));

					$sql = "UPDATE " . PAGE_TABLE . "
						SET auth_view_group = '$view_groups', auth_moderator_group = '$moderator_groups'
						WHERE page_id = '$page_id'";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not update Page config table', '', __LINE__, __FILE__, $sql);
					}

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id);

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Block'] . ' - ' . $lang['Permissions_adv'] . $lang['was_updated'];

			break;

			case MX_PAGE_TEMPLATE_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('template_name'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$sql = "UPDATE " . PAGE_TEMPLATES . "
						SET template_name = '" . $mx_request_vars->post('template_name', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "'
						WHERE page_template_id = " . intval($id);

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't template information", "", __LINE__, __FILE__, $sql);
					}
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Page_template'] . ' (' . $mx_request_vars->post('template_name', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'];

			break;

			case MX_PAGE_TEMPLATE_COLUMN_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{
					if ($mx_request_vars->is_empty_post('column_title'))
					{
						mx_message_die( GENERAL_ERROR, $lang['error_no_field'] );
					}

					$sql = "UPDATE " . COLUMN_TEMPLATES . "
						SET column_title = '" . $mx_request_vars->post('column_title', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "',
							column_size  = '" . $mx_request_vars->post('column_size', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '') . "'
						WHERE column_template_id = " . intval($id);

					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update block information", "", __LINE__, __FILE__, $sql);
					}
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Page_template_column'] . ' (' . $mx_request_vars->post('column_title', MX_TYPE_NO_TAGS, '') . ') ' . $lang['was_updated'];

			break;

			default:
				$message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];

			break;
		}

		return $message;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $type
	 * @param unknown_type $id
	 * @param unknown_type $parent
	 * @param unknown_type $recache
	 * @return unknown
	 */
	function _do_delete($type, $id, $parent, $recache)
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $mx_request_vars, $mx_cache, $mx_root_path, $mx_table_prefix, $table_prefix, $userdata;
		global $controller_block;
		$block_id = $id;
		$message_child = '';
		$words_removed = false;
		switch ( $type )
		{
			case MX_MODULE_TYPE: // ????????
			
				$module_id = intval($id);
				
				//
				// First delete all module functions
				//
				$message_child .= $this->do_it( MX_FUNCTION_TYPE, MX_DO_DELETE, $module_id, true, false );
				
				//
				// Then delete module itself
				//
				$sql = "DELETE FROM " . MODULE_TABLE . " WHERE module_id = " . $module_id;
				
				if ( !MX_ADMIN_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete parameter information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();
					
					//
					// Update cache
					//
					if ( $recache )
					{
						//
						// Update cache
						//
						$mx_cache->update(MX_CACHE_ALL);
					}
				}
				
				//
				// Now also delete module tables
				//
				$module_path = $mx_request_vars->request('module_path', MX_TYPE_NO_TAGS, '');
				//$file_name = $this->get_module_pak_file($module_path);
				if( file_exists($mx_root_path . $module_path . "db_uninstall.php") )
				{
					ob_start();
					include( $mx_root_path . $module_path . "db_uninstall.php" );
					$output_message .= ob_get_contents();
					ob_end_clean();
				}
				$message['is_pak'] = 'yes';
				$message['text'] = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . $lang['Module'] . ' (ID: ' . $module_id . ') ' . $lang['was_deleted'] . '<br />' . $message_child . '<br />' . $output_message;
			break;

			case MX_FUNCTION_TYPE:
			
				if( $parent )
				{
					$module_id = intval($id);
					//
					// First delete parameter(s) and block(s) for every module function
					//
					$sql_ids = "SELECT * FROM " . FUNCTION_TABLE . " WHERE module_id = $module_id";
					
					if( ($result = $db->sql_query($sql_ids)) )
					{
						$function_id = '';
						$delete_ids = $db->sql_fetchrowset($result);
						for( $i = 0; $i < count($delete_ids); $i++ )
						{
							$message_child .= $this->do_it( MX_BLOCK_TYPE, MX_DO_DELETE, $delete_ids[$i]['function_id'], true, false );
							$message_child .= $this->do_it( MX_PARAMETER_TYPE, MX_DO_DELETE, $delete_ids[$i]['function_id'], true, false );
							$function_id = empty($function_id) ?  $delete_ids[$i]['function_id'] : ', ' . $delete_ids[$i]['function_id'];
						}
					}
					
					//
					// Then delete function(s) themselves
					//
					$sql = "DELETE FROM " . FUNCTION_TABLE . " WHERE module_id = " . $module_id;
				}
				else
				{
					$function_id = intval($id);
					
					// First delete parameter(s) and block(s) for this module function
					$message_child .= $this->do_it( MX_BLOCK_TYPE, MX_DO_DELETE, $function_id, true, false);
					$message_child .= $this->do_it( MX_PARAMETER_TYPE, MX_DO_DELETE, $function_id, true, false);
					
					// Then delete function itself
					$sql = "DELETE FROM " . FUNCTION_TABLE . " WHERE function_id = " . $function_id;
				}
				
				if ( !MX_ADMIN_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete function information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();
					
					//
					// Update cache
					//
					if ( $recache )
					{
						//
						// Update cache
						//
						$mx_cache->update(MX_CACHE_ALL);
					}
				}
				
				if( !$parent || true)
				{
					$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . $lang['Function'] . ' (ID: ' . $function_id . ') ' . $lang['was_deleted'] . '<br />' . $message_child;
				}
			break;

			case MX_PARAMETER_TYPE:
			
				if( $parent )
				{
					$function_id = intval($id);
					$sql = "DELETE FROM " . PARAMETER_TABLE . " WHERE function_id = " . $function_id;
				}
				else
				{
					$parameter_id = intval($id);
					$sql = "DELETE FROM " . PARAMETER_TABLE . " WHERE parameter_id = " . $parameter_id;
					
					//
					// Now get function_id (for later block data refresh)
					//
					$sql_temp = "SELECT function_id FROM " . PARAMETER_TABLE . " WHERE parameter_id = " . $parameter_id . " LIMIT 1";
					if( !($result = $db->sql_query($sql_temp)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get parameter information", "", __LINE__, __FILE__, $sql);
					}
					$temp_row = $db->sql_fetchrow($result);
					$function_id = $temp_row['function_id'];
				}
				
				if ( !MX_ADMIN_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete parameter information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();
				}
				
				//
				// Now update affected block_id(s)
				// ...and cache
				//
				$message_tmp = $this->update_block_parameter_data($function_id);
				$message_tmp = !empty($message_tmp) ? '<br /><br />' . $message_tmp : '';
				
				if( !$parent || true)
				{
					$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . $lang['Parameter'] . ' ' . $lang['was_deleted'] . '<br />' . $message_child;
				}
			break;
			
			case MX_BLOCK_TYPE:
			
				if( $parent )
				{
					$function_id = intval($id);
					
					//
					// First delete block(s) parameter data and page occurances for every module function
					//
					$sql_ids = "SELECT * FROM " . BLOCK_TABLE . " WHERE function_id = $function_id";
					
					if( ($result = $db->sql_query($sql_ids)) )
					{
						$delete_ids = $db->sql_fetchrowset($result);
						for( $i = 0; $i < count($delete_ids); $i++ )
						{
							$message_child .= $this->do_it( MX_BLOCK_PARAMETER_TYPE, MX_DO_DELETE, $delete_ids[$i]['block_id'], false, false);
							$message_child .= $this->do_it( MX_PAGE_BLOCK_TYPE, MX_DO_DELETE, $delete_ids[$i]['block_id'], false, false);
						}
					}
					
					//
					// Then delete blocks(s) themselves
					//
					$sql = "DELETE FROM " . BLOCK_TABLE . " WHERE function_id = " . $function_id;
				}
				else
				{
					$delete_ids = '';
					$block_id = intval($id);
					
					//
					// First delete block parameter data and page occurances for this block
					//
					$message_child .= $this->do_it( MX_BLOCK_PARAMETER_TYPE, MX_DO_DELETE, $block_id, false, false);
					if ($controller_block != 'yes')
					{
						$message_child .= $this->do_it( MX_PAGE_BLOCK_TYPE, MX_DO_DELETE, $block_id, false, false);
					}
					
					//
					// Then delete blocks itself
					//
					$sql = "DELETE FROM " . BLOCK_TABLE . " WHERE block_id = " . $block_id;
				}
				
				if ( !MX_ADMIN_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete parameter information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();
					
					//
					// Update cache
					//
					if ( $recache )
					{
						//
						// Update cache
						//
						if (is_array($delete_ids))
						{
							$block_id = '';
							for( $i = 0; $i < count($delete_ids); $i++ )
							{
								$mx_cache->update(MX_CACHE_BLOCK_TYPE, $delete_ids[$i]['block_id']);
								$block_id = empty($block_id) ?  $delete_ids[$i]['block_id'] : ', ' . $delete_ids[$i]['block_id'];
							}
						}
						else
						{
							$mx_cache->update(MX_CACHE_BLOCK_TYPE, $block_id);
						}
					}
				}
				
				if( !$parent || true)
				{
					$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . $lang['Block'] . ' (ID: ' . $block_id . ') ' . $lang['was_deleted'] . '<br />' . $message_child;
				}
			break;
			
			case MX_BLOCK_PARAMETER_TYPE:

				$block_id = intval($id);
				
				//
				// First delete Block parameter data
				//
				$sql = "DELETE FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . "
				   	WHERE block_id = " . $block_id;
					
				if ( !MX_ADMIN_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete block parameter information", "", __LINE__, __FILE__, $sql);
					}
				}
				//
				// Update cache
				//
				// Not needed, since deleting the block itself is a parent function

				if( !$parent || true)
				{
					$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . $lang['Block_parameter'] . ' (ID: ' . $block_id . ') ' . $lang['was_deleted'] . '<br />' . $message_child;
				}
			break;

			case MX_PAGE_TYPE:
				$page_id = intval($id);
				
				//
				// First delete all Page columns
				//
				$message_child .= $this->do_it( MX_PAGE_COLUMN_TYPE, MX_DO_DELETE, $page_id, true, false);
				
				//
				// Then delete Page itself
				//
				$sql = "DELETE FROM " . PAGE_TABLE . " WHERE page_id = " . $page_id;
				
				if ( !MX_ADMIN_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete page information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();
					
					//
					// Update cache
					//
					if ( $recache )
					{
						//
						// Update cache
						//
						$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id);
					}
				}
				
				if( !$parent || true)
				{
					$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . $lang['Page'] . ' (ID: ' . $page_id . ') ' . $lang['was_deleted'] . '<br />' . $message_child;
				}
			break;

			case MX_PAGE_COLUMN_TYPE:

				if( $parent )
				{
					$page_id = intval($id);
					
					// First delete page column blocks for all page column(s)
					$sql_ids = "SELECT column_id FROM " . COLUMN_TABLE . " WHERE page_id = " . $page_id;
					
					if( ($result = $db->sql_query($sql_ids)) )
					{
						$delete_ids = $db->sql_fetchrowset($result);
						for( $i = 0; $i < count($delete_ids); $i++ )
						{
							$message_child .= $this->do_it( MX_PAGE_BLOCK_TYPE, MX_DO_DELETE, $delete_ids[$i]['column_id'], true, false );
						}
					}
					
					// Then delete page column(s) themselves
					$sql = "DELETE FROM " . COLUMN_TABLE . " WHERE page_id = " . $page_id;
				}
				else
				{
					$column_id = intval($id);
					
					// First delete page column blocks for this page column
					$message_child .= $this->do_it( MX_PAGE_BLOCK_TYPE, MX_DO_DELETE, $column_id, true, false );
					
					// Get parent page id, to update cache
					$sql = " SELECT page_id FROM " . COLUMN_TABLE . " WHERE column_id = '" . $column_id . "'";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get list of Columns for this template", '', __LINE__, __FILE__, $sql);
					}
					
					$row = $db->sql_fetchrow($result);
					$page_id = $row['page_id'];
					
					// First delete page column itself
					$sql = "DELETE FROM " . COLUMN_TABLE . " WHERE column_id = " . $column_id;
				}
				
				if ( !MX_ADMIN_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete page column information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();

					// Update cache
					if ( $recache )
					{
						//
						// Update cache
						//
						$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id);
					}
				}

				if( !$parent || true)
				{
					$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . ($words_removed > 1 ? $lang['Columns'] : $lang['Column']) . ' ' . $lang['was_deleted'] . '<br />' . $message_child;
				}
			break;

			case MX_PAGE_BLOCK_TYPE:

				//
				// Get function Ids for split, dynamic and virtual blocks
				//
				$temp_row = mx_get_info(FUNCTION_TABLE, 'function_file', 'mx_multiple_blocks.php');
				$tempFunctionId_split = $temp_row['function_id'];
				$temp_row = mx_get_info(FUNCTION_TABLE, 'function_file', 'mx_dynamic.php');
				$tempFunctionId_dynamic = $temp_row['function_id'];
				$temp_row = mx_get_info(FUNCTION_TABLE, 'function_file', 'mx_virtual.php');
				$tempFunctionId_virtual = $temp_row['function_id'];

				$blocksToDelete = array();

				if( $parent )
				{
					$column_id = intval($id);

					$sql = "DELETE FROM " . COLUMN_BLOCK_TABLE . " WHERE column_id = " . $column_id;

					//
					// Look for split, dynamic or virtual blocks
					//
					$temp_row = mx_get_info(COLUMN_BLOCK_TABLE, 'column_id', $column_id);
					foreach ($temp_row as $key => $data)
					{
						$temp_sql = "SELECT COUNT(*) AS total FROM " . BLOCK_TABLE . " WHERE (function_id = '$tempFunctionId_split' OR function_id = '$tempFunctionId_dynamic' OR function_id = '$tempFunctionId_virtual') AND block_id = '".$data['block_id']."'";
						$result = $db->sql_query($temp_sql);
						$temp_count = $db->sql_fetchrow($result);

						if ($temp_count['total']>0)
						{
							$blocksToDelete[] = $data['block_id'];
						}
					}
				}
				else
				{

					$block_id = intval($id);
					$column_id = $mx_request_vars->request('column_id', MX_TYPE_INT);
					$block_order = $mx_request_vars->request('block_order', MX_TYPE_INT);

					$sql_xtra_options = '';
					$sql_xtra_options .= $column_id > 0 ? ' AND column_id = ' . $column_id : '';
					$sql_xtra_options .= $block_order > 0 ? ' AND block_order = ' . $block_order : '';

					$sql = "DELETE FROM " . COLUMN_BLOCK_TABLE . " WHERE block_id = $block_id" . $sql_xtra_options;

					//
					// Look for split, dynamic or virtual blocks
					//
					$temp_sql = "SELECT COUNT(*) AS total FROM " . BLOCK_TABLE . " WHERE (function_id = '$tempFunctionId_split' OR function_id = '$tempFunctionId_dynamic' OR function_id = '$tempFunctionId_virtual') AND block_id = '".$block_id."'";
					$result = $db->sql_query($temp_sql);
					$temp_count = $db->sql_fetchrow($result);

					if ($temp_count['total']>0)
					{
						$blocksToDelete[] = $block_id;
					}
				}

				if ( !MX_ADMIN_DEBUG )
				{
					//
					// First delete split, dynamic or virtual blocks - if needed
					//
					if (count($blocksToDelete) > 0)
					{
						foreach ($blocksToDelete as $key => $delete_id)
						{
							//$message_child .= 'delete:' . $delete_id;
							$controller_block = 'yes';
							$message_child .= $this->do_it(MX_BLOCK_TYPE, MX_DO_DELETE, $delete_id);
						}
					}			
					$controller_block = '';

					//
					// Now remove page blocks
					//
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete page column block information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();

					//
					// Get parent page id, to update cache
					//
					$sql = " SELECT page_id FROM " . COLUMN_TABLE . " WHERE column_id = '" . $column_id . "'";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't get list of Columns for this template", '', __LINE__, __FILE__, $sql);
					}

					$row = $db->sql_fetchrow($result);
					$page_id = $row['page_id'];

					// Update cache
					if ( $recache )
					{
						//
						// Update cache
						//
						$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id);
						$mx_cache->destroy('_pagemap_block' . $block_id);
						// We also need to destroy the cache for the function file...later
					}
				}

				if( !$parent || true)
				{
					$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . ($words_removed > 1 ? $lang['Column_blocks'] : $lang['Column_block'])  . ' ' . $lang['was_removed']  . '<br />' . $message_child;
				}

			break;

			case MX_PAGE_TEMPLATE_TYPE:

				$page_template_id = intval($id);

				//
				// First delete all Page columns
				//
				$message_child .= $this->do_it( MX_PAGE_TEMPLATE_COLUMN_TYPE, MX_DO_DELETE, $page_template_id, true);

				//
				// Then delete Page itself
				//
				$sql = "DELETE FROM " . PAGE_TEMPLATES . " WHERE page_template_id = " . $page_template_id;

				if ( !MX_ADMIN_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete page template information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();
				}

				if( !$parent || true)
				{
					$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . $lang['Page_template'] . ' (ID: ' . $page_template_id . ') ' . $lang['was_deleted'] . '<br />' . $message_child;
				}

			break;

			case MX_PAGE_TEMPLATE_COLUMN_TYPE:

				if( $parent )
				{
					$page_template_id = intval($id);

					$sql = "DELETE FROM " . COLUMN_TEMPLATES . " WHERE page_template_id = " . $page_template_id;
				}
				else
				{
					$column_id = intval($id);

					$sql = "DELETE FROM " . COLUMN_TEMPLATES . " WHERE column_template_id = " . $column_id;
				}

				if ( !MX_ADMIN_DEBUG )
				{
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't delete page template column information", "", __LINE__, __FILE__, $sql);
					}
					$words_removed = $db->sql_affectedrows();
				}

				if( !$parent || true)
				{
					$message = $lang['AdminCP_action'] . ": " . $words_removed . ' ' . ($words_removed > 1 ? $lang['Page_template_columns'] : $lang['Page_template_column']) . ' ' . $lang['was_deleted'] . '<br />' . $message_child;
				}

			break;

			default:
				$message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];

			break;
		}

		return $message;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $type
	 * @return unknown
	 */
	function _do_move($type)
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $mx_request_vars, $mx_cache;

		switch ( $type )
		{
			case MX_PAGE_COLUMN_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{

					$page_id = $mx_request_vars->request('page_id', MX_TYPE_INT, 0);
					$column_id = $mx_request_vars->request('id', MX_TYPE_INT, 0);
					$move = $mx_request_vars->request('move', MX_TYPE_INT, 0);

					$sql = "UPDATE " . COLUMN_TABLE . "
						SET column_order = column_order + $move
						WHERE column_id = $column_id";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't change column order", "", __LINE__, __FILE__, $sql);
					}

					$this->move('column', 0, $page_id);
					$show_index = true;

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id);

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Column'] . ' ' . $lang['was_moved'];

			break;

			case MX_PAGE_BLOCK_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{

					$block_id = $mx_request_vars->request('id', MX_TYPE_INT, 0);
					$page_id = $mx_request_vars->request('page_id', MX_TYPE_INT, 0);
					$column_id = $mx_request_vars->request('column_id', MX_TYPE_INT, 0);

					$move = $mx_request_vars->request('move', MX_TYPE_INT, 0);
					$block_order = $mx_request_vars->request('block_order', MX_TYPE_INT, 0);

					$sql = "UPDATE " . COLUMN_BLOCK_TABLE . "
						SET block_order = block_order + $move
						WHERE column_id = $column_id
							AND block_id  = $block_id
							AND block_order  = $block_order";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't change column order", "", __LINE__, __FILE__, $sql);
					}

					$this->move('block', $column_id, $page_id);
					$show_index = true;

					//
					// Update cache
					//
					$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id);


				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Block'] . ' ' . $lang['was_moved'];

			break;

			case MX_PAGE_TEMPLATE_COLUMN_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{

					$page_template_id = $mx_request_vars->request('page_template_id', MX_TYPE_INT, 0);
					$column_id = $mx_request_vars->request('id', MX_TYPE_INT, 0);
					$move = $mx_request_vars->request('move', MX_TYPE_INT, 0);

					$sql = "UPDATE " . COLUMN_TEMPLATES . "
						SET column_order = column_order + $move
						WHERE column_template_id = $column_id";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't change column order", "", __LINE__, __FILE__, $sql);
					}

					$this->move('template_column', 0, $page_template_id);
					$show_index = true;
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Page_template_column'] . ' ' . $lang['was_moved'];

			break;

			case MX_PARAMETER_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{

					$parameter_id = $mx_request_vars->request('id', MX_TYPE_INT, 0);
					$function_id = $mx_request_vars->request('function_id', MX_TYPE_INT, 0);
					$move = $mx_request_vars->request('move', MX_TYPE_INT, 0);

					$sql = "UPDATE " . PARAMETER_TABLE . "
						SET parameter_order = parameter_order + $move
						WHERE parameter_id = $parameter_id";
					if( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't change column order", "", __LINE__, __FILE__, $sql);
					}

					$this->move('parameter', $function_id, $parameter_id);
					$show_index = true;
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Parameter'] . ' ' . $lang['was_moved'];

			break;

			default:
				$message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];
			break;
		}

		return $message;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $type
	 * @return unknown
	 */
	function _do_sync($type )
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $mx_request_vars;

		switch ( $type )
		{
			case MX_PAGE_BLOCK_TYPE:

				if ( !MX_ADMIN_DEBUG )
				{

					// Not implemented
					$column_id = $mx_request_vars->get('column_id', MX_TYPE_INT);
					//sync('block', $mx_request_vars->get('block_id', MX_TYPE_INT));
					$show_index = true;

				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Block'] . ' ' . $lang['was_synced'];

			break;

			default:
				$message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];
			break;
		}

		return $message;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $type
	 * @return unknown
	 */
	function _do_upgrade($type )
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $mx_request_vars;

		switch ( $type )
		{
			case MX_MODULE_TYPE:

				//
				//$message = $lang['AdminCP_action'] . ": " . $lang['Module'] . ' ' . $lang['was_upgraded'];
				//

				if ( !MX_ADMIN_DEBUG )
				{
					$module_id = $mx_request_vars->request('id', MX_TYPE_INT, '');
					$module_path = $mx_request_vars->request('module_path', MX_TYPE_NO_TAGS, '');
					$file_name = $this->get_module_pak_file($module_path);
					$message = $this->import_pak($file_name);

					$output_message['module_id'] = $message['new_module_id'];
					$output_message['text'] = $message['text'];
					$output_message['is_pak'] = 'yes';
				}


			break;

			default:
				$output_message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];
			break;
		}

		return $output_message;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $type
	 * @return unknown
	 */
	function _do_export($type )
	{
		global $template, $lang, $db, $board_config, $theme, $phpEx, $mx_request_vars;
		
		switch ($type)
		{
			case MX_MODULE_TYPE:
			
				if ( !MX_ADMIN_DEBUG )
				{
					$module_id = $mx_request_vars->request('id', MX_TYPE_INT, 0);
					$this->export_pack($module_id);
				}
				$message = $lang['AdminCP_action'] . ": " . $lang['Module'] . ' ' . $lang['was_exported'];
				
			break;
			
			default:
				$message = $lang['AdminCP_action'] . ": " . $lang['Invalid_action'];
			break;
		}
		return $message;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $dir_module
	 * @return unknown
	 */
	function get_module_pak_file($dir_module)
	{
		global $phpEx, $template, $mx_root_path;
		
		$pak_row = array();
		
		if($dir_module <> '..')
		{
			$dir = @opendir($mx_root_path . $dir_module);
			while( $file = @readdir($dir) )
			{
				if( preg_match("/^.*?\.pak$/", $file) )
				{
					$ret = $dir_module . $file;
					$pak_row[$ret] = $dir_module;
				}
			}
			@closedir($dir);
		}
			
		if (count($pak_row) == 0)
		{
			die('PAK error - cannot locate a *.pak file for this module');
		}
			
		if (count($pak_row) > 1)
		{
			die('PAK error - you have more than 1 *.pak files for this module');
		}
		return $ret;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $dir_module
	 * @return unknown
	 */
	function get_new_module_pak_files($dir_module = '')
	{
		global $phpEx, $template, $db, $mx_root_path;
		
		$sql = "SELECT module_path FROM " . MODULE_TABLE;
		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't get $table information", '', __LINE__, __FILE__, $sql);
		}
		$module_row = $db->sql_fetchrowset($result);
		
		$module_paths = array();
		foreach($module_row as $key => $value)
		{
			$module_paths[] = $value['module_path'];
		}
		$pak_row = array();

		/*
		// First get CORE
		$dir_mod = @opendir('../modules/mx_coreblocks/');
		while( $dir_module = @readdir($dir_mod) )
		{
			if( $dir_module <> '..' )
			{
				$dir = @opendir('../modules/mx_coreblocks/' . $dir_module);
				while( $file = @readdir($dir) )
				{
					if( preg_match("/^.*?\.pak$/", $file) )
					{
						$ret = '../modules/mx_coreblocks/' . $file;
						$pak_row[$ret] = 'MX CORE PORTAL';
					}
				}
				@closedir($dir);
			}
		}
		*/
		
		// Then get modules
		$dir_mod = @opendir($mx_root_path . 'modules/');
		while ($dir_module = @readdir($dir_mod))
		{
			if( $dir_module <> '..' && $dir_module <> '.')
			{
				$dir = @opendir($mx_root_path . 'modules/' . $dir_module);
				while( $file = @readdir($dir) )
				{
					if(preg_match("/^.*?\.pak$/", $file))
					{
							if(!in_array('modules/' . $dir_module . '/', $module_paths))
							{
								$ret = 'modules/' . $dir_module . '/';
								$pak_row[$ret] = $dir_module;
							}
					}
				}
				@closedir($dir);
			}
		}
		return $pak_row;
	}

	/**
	 * Enter description here...
	 *
	 * Whenever a parameter is added, updated or removed, associated blocks must also be updated
	 * This function is used both by module pak install/upgrade, and during module CP management
	 *
	 * @access private
	 * @param unknown_type $data
	 * @param unknown_type $pak_error
	 * @param unknown_type $pak_debug
	 * @return unknown
	 */
	function update_block_parameter_data($data = '', $pak_error = false, $pak_debug = false)
	{
		global $mx_cache;
		//
		// $data:
		//
		// 1) If scalar -> function_id
		//
		// 2) If array -> $parameter_row:
		// 0: 'parameter', 1: function_id, 2: parameter_id, 3: parameter_name,
		// 4: parameter_type, 5: parameter_default, 6: parameter_function
		//
		
		global $table_prefix, $mx_table_prefix, $userdata, $phpEx, $template, $lang, $db, $board_config;
		
		// Initial checks
		if( $pak_error )
		{
			return;
		}
		
		if( empty($data) )
		{
			mx_message_die(GENERAL_MESSAGE, 'No function_id or parameter_row is given');
		}
		
		if (is_array($data))
		{
			$parameter_row = $data;
			$function_id = intval($parameter_row[1]);
			$parameter_id = !empty($parameter_row[2]) ? intval( $parameter_row[2] ) : $this->getMaxId(PARAMETER_TABLE, 'parameter_id') + 1;
		}
		else
		{
			$function_id = $data;
		}
		$output_message = '&nbsp;&nbsp;  ---> Now get blocks_ids: <br />';
		
		// Now get associated block_id(s)
		$sql = "SELECT block_id FROM " . BLOCK_TABLE . " WHERE function_id = '" . $function_id . "'";
		
		$result_ids = !$pak_debug ? $db->sql_query($sql) : true;
		
		$output_message .= !$result_ids ? '<font color=#00ff00> [db...no blocks...ok] </font>' : '<font color=#00ff00> [db...ok] </font>';
		
		while( $block_row = $db->sql_fetchrow($result_ids) )
		{
			$block_id = intval($block_row['block_id']);
			
			// delete old/removed block parameters when user change the function_id of a block or delete function parameters
			$sql = "SELECT * FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = " . $block_id;
			
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't get block_system_parameter information", "", __LINE__, __FILE__, $sql);
			}
			
			$sys_param_rows = $db->sql_fetchrowset($result);
			
			for( $p = 0; $p < count($sys_param_rows); $p++ )
			{
				$sql_cnt = "SELECT COUNT(*) AS total FROM " . PARAMETER_TABLE . " WHERE function_id = " . $function_id . " AND parameter_id = " . $sys_param_rows[$p]['parameter_id'];
				
				if( !($result_cnt = $db->sql_query($sql_cnt)) )
				{
					mx_message_die(GENERAL_ERROR, "Couldn't get block_system_parameter information", "", __LINE__, __FILE__, $sql_cnt);
				}
				
				$count = $db->sql_fetchrow($result_cnt);
				$count = $count['total'];
				
				if( $count == 0 )
				{
					$sql_del = "DELETE FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = $block_id AND parameter_id = " . $sys_param_rows[$p]['parameter_id'];
					$result_del = $db->sql_query($sql_del);
					
					$output_message .= '<br /> - (' . $sys_param_rows[$p]['parameter_name'] . ', ' . $sys_param_rows[$p]['parameter_id'] . ', ' . $block_id . '),';
					$output_message .= !$result_del ? '<br /><b><font color=#0000ff>[db...error]</font></b> line: ' . __LINE__ . ' , ' . $result_del . '<br />' : '';
				}
			}
			
			// insert/update new block parameters when user change the function_id of a block or add/edit function parameters
			$sql = "SELECT * FROM " . PARAMETER_TABLE . " WHERE function_id = " . $function_id;
			
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't get parameter information", "", __LINE__, __FILE__, $sql);
			}
			
			$sys_param_rows = $db->sql_fetchrowset($result);
			
			for( $p = 0; $p < count($sys_param_rows); $p++ )
			{
				$sql_cnt = "SELECT COUNT(*) AS total FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = " . $block_id . " AND parameter_id = " . $sys_param_rows[$p]['parameter_id'];
				
				if( !($result = $db->sql_query($sql_cnt)) )
				{
					mx_message_die(GENERAL_ERROR, "Couldn't get block_system_parameter information", "", __LINE__, __FILE__, $sql);
				}
				
				$count = $db->sql_fetchrow($result);
				$count = $count['total'];
				
				if( $count == 0 )
				{
					$sql_add = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "( block_id, parameter_id, parameter_value )
						SELECT " . $block_id . ", " . $sys_param_rows[$p]['parameter_id'] . ", parameter_default
							FROM " . PARAMETER_TABLE . " par " . " WHERE function_id = " . $function_id . " AND parameter_id = " . $sys_param_rows[$p]['parameter_id'];
							
					$result_add = $db->sql_query($sql_add);
					
					$output_message .= '<br /> + (' . $sys_param_rows[$p]['parameter_name'] . ', ' . $sys_param_rows[$p]['parameter_id'] . ', ' . $block_id . '),';
					$output_message .= !$result_add ? '<br /><b><font color=#0000ff>[db...error]</font></b> line: ' . __LINE__ . ' , ' . $sql_add . '<br />' : '';
				}
			}			
			// Update cache
			$mx_cache->update(MX_CACHE_BLOCK_TYPE, $block_id);
		}
		$output_message .= ' <br />';
		return $output_message;
	}

	/**
	 * Enter description here...
	 *
	 * @access public
	 * @param unknown_type $mode
	 * @param unknown_type $column
	 * @param unknown_type $page_id
	 */
	function move($mode, $column = 0, $page_id)
	{
		global $db;
		switch( $mode )
		{
			case 'column':
				$table = COLUMN_TABLE;
				$idfield = 'column_id';
				$orderfield = 'column_order';
				$columnfield = 'page_id';
				$column = 0;
			break;

			case 'template_column':
				$table = COLUMN_TEMPLATES;
				$idfield = 'column_template_id';
				$orderfield = 'column_order';
				$columnfield = 'page_template_id';
				$column = 0;
			break;

			case 'block':
				$table = COLUMN_BLOCK_TABLE;
				$idfield = 'block_id';
				$orderfield = 'block_order';
				$columnfield = 'column_id';
			break;

			case 'parameter':
				$table = PARAMETER_TABLE;
				$idfield = 'parameter_id';
				$orderfield = 'parameter_order';
				$columnfield = 'function_id';
			break;

			default:
				mx_message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
		}

		$sql = "SELECT * FROM $table";

		switch( $mode )
		{
			case 'column':
				$sql .= " WHERE page_id = $page_id ";
			break;

			case 'template_column':
				$sql .= " WHERE page_template_id = $page_id ";
			break;

			case 'block':
				$sql .= " WHERE $columnfield = $column";
			break;

			case 'parameter':
				$sql .= " WHERE $columnfield = $column";
			break;

			default:
				mx_message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
		}

		$sql .= " ORDER BY $orderfield ASC";

		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't get list of Column", "", __LINE__, __FILE__, $sql);
		}

		$i = 10;
		$inc = 10;

		while( $row = $db->sql_fetchrow($result) )
		{
			$sql = "UPDATE $table
				SET $orderfield = $i
					WHERE $idfield = " . $row[$idfield] . "
					AND $columnfield = $column";
			if( !($db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't update order fields", "", __LINE__, __FILE__, $sql);
			}
			$i += 10;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $table_name
	 * @param unknown_type $table_key
	 * @return unknown
	 */
	function getMaxId($table_name, $table_key)
	{
		global $db;

		$sql = "SELECT MAX(" . $table_key . ") AS max_id FROM " . $table_name;
		if( !($row = $this->dbFetchRow($sql)) )
		{
			return -1;
		}
		return $row['max_id'];
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $sql
	 * @return unknown
	 */
	function dbFetchRow($sql)
	{
		global $db;

		if( !($result = $db->sql_query($sql)) )
		{
			return false;
		}

		if( !($row = $db->sql_fetchrow($result)) )
		{
			return false;
		}

		return $row;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $array
	 * @param unknown_type $ky
	 * @param unknown_type $val
	 * @return unknown
	 */
	function mx_array_insert($array, $ky, $val)
	{
		$n = $ky;

		foreach( $array as $key => $value )
		{
			$backup_array[$key] = $array[$key];
		}

		$upper_limit = count($array);

		while( $n <= $upper_limit )
		{
			if( $n == $ky )
			{
				$array[$n] = $val;
			}
			else
			{
				$ii = $n - "1";
				$array[$n] = $backup_array[$ii];
			}
			$n++;
		}

		return $array;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $table
	 * @param unknown_type $idfield
	 * @param unknown_type $id
	 * @param unknown_type $idfield2
	 * @param unknown_type $item_ids
	 * @return unknown
	 */
	function get_old_items($table, $idfield = '', $id = 0, $idfield2 = '', $item_ids = array())
	{
		global $db;

		$ids = array();
		for( $i = 0; $i < count($item_ids); $i++ )
		{
			$ids[] = $item_ids[$i];
		}
		$ids = implode(', ', $ids);

		$sql = "SELECT * FROM $table WHERE $idfield = '$id'";
		$sql .= ( count($item_ids) > 0 ) ? " AND $idfield2 NOT IN ($ids)" : '';

		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't get $table information", '', __LINE__, __FILE__, $sql);
		}

		$return = $db->sql_fetchrowset($result);
		return $return;
	}

	/**
	 * Enter description here...
	 *
	 * Get Safe object ids from the MX tables...
	 *
	 * @access private
	 * @param unknown_type $fcontents
	 * @return unknown
	 */
	function getSafeObjects($fcontents)
	{
		global $template, $lang, $db, $board_config, $theme, $delimeter;
		
		$module_id_max = $this->getMaxId(MODULE_TABLE, 'module_id');
		$function_id_max = $this->getMaxId(FUNCTION_TABLE, 'function_id');
		$parameter_id_max = $this->getMaxId(PARAMETER_TABLE, 'parameter_id');
		$option_id_max = $this->getMaxId(PARAMETER_OPTION_TABLE, 'option_id');
		$block_id_max = $this->getMaxId(BLOCK_TABLE, 'block_id');
		
		$function_count = -1;
		$parameter_count = -1;
		$option_count = -1;
		$block_count = -1;
		
		$delete_par = false;
		$delete_opt = false;
		$delete_fnc = false;
		
		/* 
		* Generate safe object identifiers for the target DB
		* where this module pack is going to be imported...
		*/
		$i = 0;
		$delete_option = false;
		$exists_option_ids = array();
		while( $i < count($fcontents) )
		{
			$module_data = explode($delimeter, trim($fcontents[$i]));
			
			switch( $module_data[0] )
			{
				/*
				* 0: module, 1: module_id, 2: module_name, 3: module_path,
				* 4: module_desc, 5: module_include_admin
				*/
				case 'module':
					$delete_fnc = false;
					$exists_fnc_ids = array();
					
					$safe_row = mx_get_info(MODULE_TABLE, 'module_path', $module_data[3]);
					
					/*
					* Switch to check if its updating or installing module
					*/
					if( $safe_row )
					{
						$module_data[6] = 'upgrade';
						$module_id = $safe_row['module_id'];
						$module_data[1] = $module_id;
					}
					else
					{
						$module_data[6] = 'install';
						$module_id_max++;
						$module_id = $module_id_max;
						$module_data[1] = $module_id;
					}
					break;
					
				/*
				* 0: function, 1: module_id, 2: function_id, 3: function_name,
				*
				* 4: function_desc, 5: function_file, 6: function_admin
				*/
				case 'function':
					$delete_par = false;
					$exists_par_ids = array();
					
					$module_data[1] = $module_id;
					
					if( $delete_fnc )
					{
						break;
					}
					
					$safe_row = mx_get_info(FUNCTION_TABLE, 'module_id', $module_id, 'function_file', $module_data['5']);
					
					if( $module_data['4'] == 'endoflist' )
					{
						$old_items = $this->get_old_items(FUNCTION_TABLE, 'module_id', $module_id, 'function_id', $exists_fnc_ids);
						
						for( $f = 0; $f < count($old_items); $f++ )
						{
							$insert_array = implode($delimeter, array('function', $old_items[$f]['module_id'], $old_items[$f]['function_id'], $old_items[$f]['function_name'], 'delete'));
							$fcontents = $this->mx_array_insert($fcontents, $i , $insert_array);
							$insert_array = implode($delimeter, array('parameter', '0', '0', '0', 'endoflist', '0'));
							$fcontents = $this->mx_array_insert($fcontents, $i + 1, $insert_array);
							$delete_fnc = true;
						}
					}
					else if( $safe_row  )
					{
						$function_id = $safe_row['function_id'];
						$module_data[2] = $function_id;
						$exists_fnc_ids[] = $function_id;
					}
					else
					{
						$function_id_max++;
						$function_id = $function_id_max;
						$module_data[2] = $function_id;
					}
					break;
					
				/*
				* 0: parameter, 1: function_id, 2: parameter_id, 3: parameter_name,
				* 4: parameter_type, 5: parameter_default, 6: parameter_function
				*/
				case 'parameter':
					$delete_option = false;
					$exists_option_ids = array();
					
					$module_data[1] = $function_id;
					
					if( $delete_par )
					{
						break;
					}
					
					$safe_row = mx_get_info(PARAMETER_TABLE, 'function_id', $function_id, 'parameter_name', $module_data['3']);
					
					if( $module_data['4'] == 'endoflist' )
					{
						$old_items = $this->get_old_items(PARAMETER_TABLE, 'function_id', $function_id, 'parameter_id', $exists_par_ids);
						
						for( $f = 0; $f < count( $old_items ); $f++ )
						{
							$insert_array = implode($delimeter, array('parameter', $old_items[$f]['function_id'], $old_items[$f]['parameter_id'], $old_items[$f]['parameter_name'], 'delete'));
							$fcontents = $this->mx_array_insert($fcontents, $i, $insert_array);
							$delete_par = true;
						}
					}
					else if( $safe_row  )
					{
						$parameter_id = $safe_row['parameter_id'];
						$module_data[2] = $parameter_id;
						$exists_par_ids[] = $parameter_id;
					}
					else
					{
						$parameter_id_max++;
						$parameter_id = $parameter_id_max;
						$module_data[2] = $parameter_id;
					}
					break;
					
				/*
				* 0: block, 1: block_id, 2: block_title, 3: block_desc,
				* 4: function_id, 5: auth_view, 6: auth_edit, 7: auth_delete
				*/
				case 'block':
					$safe_row = mx_get_info(BLOCK_TABLE, 'function_id', $function_id);
					if( $safe_row  )
					{
						// $block_id = $safe_row['block_id'];
						// $module_data[1] = $block_id;
						$module_data[4] = 'endoflist';
					}
					else
					{
						$block_id_max++;
						$block_id = $block_id_max;
						$module_data[1] = $block_id;
						$module_data[4] = $function_id;
					}
					break;
					
				case 'delete':
					break;
					
				case 'New_function':
					break;
					
				default:
					mx_message_die(GENERAL_MESSAGE, "Invalid Pack Format. Line: " . ( $i + 1 ));
			}
			
			if( !$delete_par && !$delete_option && !$delete_fnc )
			{
				$fcontents[$i] = implode($delimeter, $module_data);
			}
			$i++;
		}
		return $fcontents;
	}

	/**
	 * Enter description here...
	 *
	 * Import module pak - install/upgrade
	 *
	 * @access private
	 * @param unknown_type $file_name
	 * @return unknown
	 */
	function import_pak($file_name)
	{
		global $table_prefix, $mx_table_prefix, $userdata, $phpEx, $template, $lang, $db, $board_config, $theme, $delimeter, $mx_root_path;

		$fcontents = @file($mx_root_path . $file_name);
		$module_filerow = explode($delimeter, trim( $fcontents[0]));
		$module_name = $module_filerow[2];

		$function_id = '';
		$output_message = '';
		$pak_error = false;

		//
		// Debug mode true/false (debug mode will repress all db actions but still output intended actions)
		//
		$pak_debug = false;

		//
		// Get module id
		//
		$sql = "SELECT * FROM " . MODULE_TABLE . " WHERE module_name = '$module_name'";
		$result = $db->sql_query($sql);

		if( empty($fcontents) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't read module pak file", "", __LINE__, __FILE__, '');
		}

		//
		// Call parent function to get valid object ids, for db processing
		//
		$fcontents = $this->getSafeObjects($fcontents);

		$parameter_order = 0; // Needed?

		//
		// Proceed with fixed object ids (fcontents) for install/upgrade...
		//
		for($i = 0; $i < count($fcontents) && !$pak_error; $i++)
		{
			global $mx_request_vars;
			$module_data = explode($delimeter, trim(addslashes($fcontents[$i])));
			$module_data[7] = isset($module_data[7]) ? $module_data[7] : $mx_request_vars->post('parameter_auth', MX_TYPE_INT, 0); 
			$module_data[8] = isset($module_data[8]) ? $module_data[8] : $parameter_order; 
			switch( $module_data[0] )
			{
				//
				// 0: module, 1: module_id, 2: module_name, 3: module_path,
				// 4: module_desc, 5: module_include_admin
				//
				case 'module':
					$table = MODULE_TABLE;
					$fldkey = 'module_id';
					$key = $module_data[1];
					$mx_module_id = $module_data[1];

					//
					// Based on if the module exists or not - define import mode
					//
					$upgrade_module = ( $module_data[6] == 'upgrade' ) ? true : false;

					$sql_add = "INSERT INTO " . MODULE_TABLE . " (module_id, module_name, module_path, module_desc, module_include_admin)
						VALUES ( '$module_data[1]', '$module_data[2]', '$module_data[3]', '$module_data[4]', '$module_data[5]' ) ";

					$sql_update = "UPDATE " . MODULE_TABLE . "
						SET module_name = '$module_data[2]',
							module_path = '$module_data[3]',
							module_desc = '$module_data[4]',
							module_include_admin = '$module_data[5]'
						WHERE module_id = '$module_data[1]'";
					break;

				//
				// 0: function, 1: module_id, 2: function_id, 3: function_name,
				//
				// 4: function_desc, 5: function_file, 6: function_admin
				case 'function':
					$table = FUNCTION_TABLE;
					$fldkey = 'function_id';
					$key = $module_data[2];
					$function_id = $module_data[2] > 0 ? $module_data[2] : $function_id;

					$sql_add = "INSERT INTO " . FUNCTION_TABLE . " (module_id, function_id, function_name, function_desc, function_file, function_admin)
						VALUES ('" . intval($module_data[1]) . "', '" . str_replace("\'", "''",$module_data[2]) . "', '" . str_replace("\'", "''",$module_data[3]) . "', '" . str_replace("\'", "''",$module_data[4]) . "', '" . str_replace("\'", "''",$module_data[5]) . "', '" . str_replace("\'", "''",$module_data[6]) . "' )";
						
					$sql_update = "UPDATE " . FUNCTION_TABLE . "
						SET module_id       	= '" . intval($module_data[1]) . "',
							function_id     	= '" . str_replace("\'", "''",$module_data[2]) . "',
							function_name     	= '" . str_replace("\'", "''",$module_data[3]) . "',
							function_desc     	= '" . str_replace("\'", "''",$module_data[4]) . "',
							function_file 	= '" . str_replace("\'", "''", $module_data[5]) . "',
							function_admin 	= '" . str_replace("\'", "''",$module_data[6]) . "'
						WHERE function_id  = '" . intval($module_data[2]) . "'";
						
					$sql_delete = "DELETE FROM " . FUNCTION_TABLE . " WHERE module_id = " . $module_data[1] . " AND function_id = " . $module_data[2];
					break;

				//
				// 0: parameter, 1: function_id, 2: parameter_id, 3: parameter_name,
				// 4: parameter_type, 5: parameter_default, 6: parameter_function, 7: parameter_auth, 8: parameter_order
				//
				case 'parameter':
					$table = PARAMETER_TABLE;
					$fldkey = 'parameter_id';
					$key = $module_data[2];
					
					++$parameter_order;
					$sql_add = "INSERT INTO " . PARAMETER_TABLE . " (function_id, parameter_id, parameter_name, parameter_type, parameter_default, parameter_function, parameter_auth, parameter_order)
						VALUES ( '" . intval($module_data[1]) . "', '" . intval($module_data[2]) . "', '" . str_replace("\'", "''", $module_data[3]) . "', '" . str_replace("\'", "''",$module_data[4]) . "', '" . str_replace("\'", "''", $module_data[5]) . "', '" . str_replace("\'", "''", $module_data[6]) . "', '" . str_replace("\'", "''", $module_data[7]) . "', '" . str_replace("\'", "''", $module_data[8]) . "' ) ";

					/*
					++$parameter_order;
					$sql = array(
						'function_id'        	=> (int) $module_data[1],
						'parameter_id'  		=> (int) $module_data[2],
						'parameter_name'     	=> stripslashes($module_data[3]),
						'parameter_type'     	=> stripslashes($module_data[4]),
						'parameter_default'  	=> stripslashes($module_data[5]),
						'parameter_function' 	=> stripslashes($module_data[6]),
						'parameter_auth' 		=> stripslashes($module_data[7]),
						'parameter_order' 		=> (int) $parameter_order,
					);
					$sql_add = "INSERT INTO $table " . $db->sql_build_array('INSERT', $sql);
					*/

					$sql_update = "UPDATE " . PARAMETER_TABLE . "
						SET function_id        	= '" . intval($module_data[1]) . "',
							parameter_name     	= '" . str_replace("\'", "''",$module_data[3]) . "',
							parameter_type     	= '" . str_replace("\'", "''",$module_data[4]) . "',
							parameter_default  	= '" . str_replace("\'", "''", $module_data[5]) . "',
							parameter_function 	= '" . str_replace("\'", "''",$module_data[6]) . "',
							parameter_auth 		= '" . str_replace("\'", "''",$module_data[7]) . "',
							parameter_order 	= '" . str_replace("\'", "''",$module_data[8]) . "'
						WHERE parameter_id  = '" . intval($module_data[2]) . "'";

					$sql_delete = "DELETE FROM " . PARAMETER_TABLE . " WHERE function_id = " . $module_data[1] . " AND parameter_id = " . $module_data[2];
					break;

				//
				// 0: block, 1: block_id, 2: block_title, 3: block_desc,
				// 4: function_id, 5: auth_view, 6: auth_edit, 7: auth_delete
				// 8: auth_view, 9: auth_edit, 10: auth_delete , 11: show_title, 12: show_block
				//
				case 'block':
					$table = BLOCK_TABLE;
					$fldkey = 'block_id';
					$key = $module_data[1];

					$sql_add = "INSERT INTO " . BLOCK_TABLE . " (block_id, block_title, block_desc, function_id, auth_view, auth_edit, auth_delete, auth_view_group, auth_edit_group, auth_delete_group, show_title, show_block)
						VALUES ('$module_data[1]', '$module_data[2]', '$module_data[3]', '$module_data[4]', '$module_data[5]', '$module_data[6]', '$module_data[7]', '$module_data[8]', '$module_data[9]', '$module_data[10]', '$module_data[11]', '$module_data[12]')";

					$sql_update = "UPDATE " . BLOCK_TABLE . "
						SET block_title = '$module_data[2]',
							block_desc  = '$module_data[3]',
							function_id  = '$module_data[4]',
							auth_view  = '$module_data[5]',
							auth_edit  = '$module_data[6]',
							auth_delete  = '$module_data[7]',
							auth_view_group  = '$module_data[8]',
							auth_edit_group  = '$module_data[9]',
							auth_delete_group  = '$module_data[10]',
							show_title  = '$module_data[11]',
							show_block  = '$module_data[12]'
						WHERE block_id = '$module_data[1]'";
					break;

				case 'delete':
					break;

				case 'New_function':
					break;

				default:
					mx_message_die(GENERAL_MESSAGE, "Invalid Data");
			}

			//
			// Check to detect update mode
			//
			$sql_cnt = "SELECT COUNT(*) AS total FROM $table WHERE $fldkey = '" . $key . "'";
			if( !($result = $db->sql_query($sql_cnt)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't get $table information", "", __LINE__, __FILE__, $sql);
			}

			$count = $db->sql_fetchrow($result);
			$count = $count['total'];

			//
			// If delete
			//
			if( $module_data[4] == 'delete' )
			{
				if( $module_data[0] == 'function' )
				{
					//
					// delete function
					// 0: function, 1: module_id, 2: function_id, 3: function_name,
					// 4: function_desc, 5: function_file, 6: function_admin
					//
					$output_message .= '  - <font color=#0000ff>delete</font> ' . $module_data[0] . ' (' . $module_data[1] . ', ' . $module_data[2] .', ' . $module_data[3] .') ' .'<br />';
					$result = $pak_debug == false ? $db->sql_query($sql_delete) : true;

					if( !$result )
					{
						$output_message .= '<br /><b><font color=#0000FF>[db...error]</font></b> line: ' . __LINE__ . ' , ' . $sql_delete . '<br />';
						$pak_error = true;
					}
					else
					{
						$output_message .= '<font color=#00ff00>[db...ok]</font>' . '<br />';
					}

				}
				else if( $module_data[0] == 'parameter' )
				{
					//
					// delete parameter
					//
					$output_message .= '  - <font color=#0000ff>delete</font> ' . $module_data[0] . ' (' . $module_data[1] . ', ' . $module_data[2] .', ' . $module_data[3] .') ' .'<br />';
					$result = $pak_debug == false ? $db->sql_query($sql_delete) : true;

					if( !$result )
					{
						$output_message .= '<br /><b><font color=#0000FF>[db...error]</font></b> line: ' . __LINE__ . ' , ' . $sql_delete . '<br />';
						$pak_error = true;
					}
					else
					{
						$output_message .= '<font color=#00ff00>[db...ok]</font>' . '<br />';
					}

				}
				else
				{
					//
					// delete option
					//

				}
			}
			else if( $module_data[4] == 'endoflist' || $module_data[0] == 'New_function' )
			{
				// endoflist
			}
			else if( $count == 0 )
			{
				//
				// Add
				//
				$output_message .= (( $module_data[0] == 'function' ) ? '<br />----------------------------<br />' : '') . '  - <font color=#dd1144>add</font> ' . $module_data[0] . ' (' . $module_data[1] . ', ' . $module_data[2] .', ' . $module_data[3] .') ' .'<br />';
				$result = $pak_debug == false ? $db->sql_query($sql_add) : true;

				if( !$result )
				{
					$output_message .= '<br /><b><font color=#0000ff>[db...error]</font></b> line: ' . __LINE__ . ' , ' . $sql_add . '<br />';
					$pak_error = true;
				}
				else
				{
					$output_message .= '<font color=#00ff00>[db...ok]</font>' . '<br />';
				}

			}
			else
			{
				//
				// Upgrade
				//
				if( $module_data[0] != 'block' )
				{
					$output_message .= (( $module_data[0] == 'function' ) ? '<br />----------------------------<br />' : '') . '  - update ' . $module_data[0] . ' (' . $module_data[1] . ', ' . $module_data[2] .', ' . $module_data[3] .') ' .'<br />';
					$result = $pak_debug == false ? $db->sql_query($sql_update) : true;

					if( !$result )
					{
						$output_message .= '<br /><b><font color=#0000ff>[db...error]</font></b> line: ' . __LINE__ . ' , ' . $sql_update . '<br />';
						$pak_error = true;
					}
					else
					{
						$output_message .= '<font color=#00ff00>[db...ok]</font>' . '<br />';
					}
				}

				// EDITED: never upgrade old blocks
				// Now uppdate parameters in old blocks
				//	if( $module_data[0] == 'parameter' )
				//	{
				//		$output_message .= pak_modify_block_par('update', $module_data);
				//	}
			}

			//
			// Now update all related block parameters
			// This is done for every function
			//
			if( $module_data[0] == 'parameter' && $module_data[4] == 'endoflist' && is_numeric($function_id) )
			{
				//
				// Now update affected block_id(s)
				// ...and cache
				//
				$message_tmp = $this->update_block_parameter_data($function_id);
				$output_message .= !empty($message_tmp) ? '<br /><br />' . $message_tmp : '';
			}

			//
			// If this is a new demo block, give it parameters (Fix for 2.8 B4)
			//
			if( $module_data[0] == 'block' && is_numeric($module_data[4]) )
			{
				//
				// Now update affected block_id(s)
				// ...and cache
				//
				$message_tmp = $this->update_block_parameter_data($module_data[4]);
				$output_message .= !empty($message_tmp) ? '<br /><br />' . $message_tmp : '';
			}
		}

		if( $pak_error )
		{
			$output_message .= '<br /><b><font color=#FF0000>[terminated with errors]</font></b>' . '<br />';
		}
		else
		{
			$output_message .= '<br /><b><font color=#00ff00>[import succesfull]</font></b>' . '<br />';
		}

		if( file_exists(dirname($mx_root_path . $file_name) . "/db_install.php") && !$upgrade_module && !$pak_debug )
		{
			ob_start();
			global $lang;
			include( dirname( $mx_root_path .$file_name ) . "/db_install.php" );
			$output_message .= ob_get_contents();
			ob_end_clean();
		}
		else if( file_exists(dirname($mx_root_path . $file_name) . "/db_upgrade.php") && $upgrade_module && !$pak_debug )
		{
			ob_start();
			include(dirname( $mx_root_path .$file_name ) . "/db_upgrade.php");
			$output_message .= ob_get_contents();
			ob_end_clean();
		}

		$return_message = array();
		$return_message['new_module_id'] = $mx_module_id;
		$return_message['text'] = $output_message;

		return $return_message;
	}

	/**
	 * Enter description here...
	 *
	 * Export Module Pack
	 *
	 * @access private
	 * @param unknown_type $module_id
	 */
	function export_pack($module_id)
	{
		global $template, $lang, $db, $board_config, $theme, $delimeter;

		$sql = "SELECT * FROM " . MODULE_TABLE . " WHERE module_id = $module_id";

		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't read module data", "", __LINE__, __FILE__, $sql);
		}
		$resultset = $db->sql_fetchrowset($result);

		$module_pak = '';

		// 0: module, 1: module_id, 2: module_name, 3: module_path,
		// 4: module_desc, 5: module_include_admin
		for( $i = 0; $i < count($resultset); $i++ )
		{
			$module_name = $resultset[$i]['module_name'];
			$module_pak .= 'module' . $delimeter . $resultset[$i]['module_id'] . $delimeter;
			$module_pak .= $resultset[$i]['module_name'] . $delimeter;
			$module_pak .= $resultset[$i]['module_path'] . $delimeter;
			$module_pak .= $resultset[$i]['module_desc'] . $delimeter;
			$module_pak .= $resultset[$i]['module_include_admin'] . "\n";

			// Function
			$sql = "SELECT * FROM " . FUNCTION_TABLE . " WHERE module_id = $module_id ORDER BY function_file";
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't read function data", "", __LINE__, __FILE__, $sql);
			}
			$resultset_func = $db->sql_fetchrowset($result);

			// 0: function, 1: module_id, 2: function_id, 3: function_name,
			// 4: function_desc, 5: function_file, 6: function_admin
			for( $f = 0; $f < count($resultset_func); $f++ )
			{
				$module_pak .= 'New_function' . $delimeter . '---------------------------' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '0' . "\n";

				$module_pak .= 'function' . $delimeter . $resultset_func[$f]['module_id'] . $delimeter;
				$module_pak .= $resultset_func[$f]['function_id'] . $delimeter;
				$module_pak .= $resultset_func[$f]['function_name'] . $delimeter;
				$module_pak .= $resultset_func[$f]['function_desc'] . $delimeter;
				$module_pak .= $resultset_func[$f]['function_file'] . $delimeter;
				$module_pak .= $resultset_func[$f]['function_admin'] . "\n";

				$function_id = $resultset_func[$f]['function_id'];

				// Parameter
				$sql = "SELECT * FROM " . PARAMETER_TABLE . " WHERE function_id = $function_id ORDER BY parameter_order";
				if( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, "Couldn't read parameter data", "", __LINE__, __FILE__, $sql);
				}
				$resultset_param = $db->sql_fetchrowset($result);

				// 0: parameter, 1: function_id, 2: parameter_id, 3: parameter_name,
				// 4: parameter_type, 5: parameter_default, 6: parameter_function, 7: parameter_auth, 8: parameter_order
				for( $p = 0; $p < count($resultset_param); $p++ )
				{
					$module_pak .= 'parameter' . $delimeter . $resultset_param[$p]['function_id'] . $delimeter;
					$module_pak .= $resultset_param[$p]['parameter_id'] . $delimeter;
					$module_pak .= $resultset_param[$p]['parameter_name'] . $delimeter;
					$module_pak .= $resultset_param[$p]['parameter_type'] . $delimeter;
					$module_pak .= $resultset_param[$p]['parameter_default'] . $delimeter;
					$module_pak .= $resultset_param[$p]['parameter_function'] . $delimeter;
					$module_pak .= $resultset_param[$p]['parameter_auth'] . $delimeter;
					$module_pak .= $resultset_param[$p]['parameter_order'] . "\n";

					$paramater_id = $resultset_param[$p]['parameter_id'];
				}

				$module_pak .= 'parameter' . $delimeter . '0' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= 'endoflist' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '0' . "\n";

				//
				// Only output 1 default block
				//
				$module_pak .= 'block' . $delimeter . $resultset_param[$p]['block_id'] . $delimeter;
				$module_pak .= 'Demo - ' . $resultset_func[$f]['function_name'] . $delimeter;
				$module_pak .= 'Demo block' . $delimeter;
				$module_pak .= $resultset_func[$f]['function_id'] . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '5' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '0' . $delimeter;
				$module_pak .= '1' . $delimeter;
				$module_pak .= '1' . "\n";
			}

			//
			// End function def
			//
			$module_pak .= 'function' . $delimeter . '0' . $delimeter;
			$module_pak .= '0' . $delimeter;
			$module_pak .= '0' . $delimeter;
			$module_pak .= 'endoflist' . $delimeter;
			$module_pak .= '0' . $delimeter;
			$module_pak .= '0' . "\n";
		}

		header("Content-Type: text/x-delimtext; name=\"$module_name.pak\"");
		header("Content-disposition: attachment; filename=$module_name.pak");

		echo $module_pak;
		exit;
	}
	
	/**
	 * Index search words for textblocks.
	 *
	 * This function indexes search words for textblocks.
	 * Old outdated function need to be fixed
	 * @access private
	 * @param string $mode single or ?
	 * @param integer $block_id textblock id
	 * @param string $post_text textblock text
	 * @param string $post_title textblock title
	 */
	function mx_add_search_words($mode, $block_id, $post_text, $post_title = '')
	{
		global $db, $phpbb_root_path, $board_config, $lang, $phpEx, $mx_cache;

		if( !function_exists('add_search_words') )
		{
			$mx_cache->load_file('functions_search', 'phpbb2');
		}

		$search_match_table = MX_MATCH_TABLE;
		$search_word_table = MX_WORD_TABLE;
		$db_key = 'block_id';

		$stopword_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . "/search_stopwords.txt");
		$synonym_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . "/search_synonyms.txt");

		$search_raw_words = array();

		// Updated for utf-8
		$search_raw_words['text'] = split_words(@clean_words('post', utf8_normalize_nfc($post_text), $stopword_array, $synonym_array));
		$search_raw_words['title'] = split_words(@clean_words('post', utf8_normalize_nfc($post_title), $stopword_array, $synonym_array));

		@set_time_limit(0);

		$word = array();
		$word_insert_sql = array();
		while ( list($word_in, $search_matches) = @each($search_raw_words) )
		{
			$word_insert_sql[$word_in] = '';
			if ( !empty($search_matches) )
			{
				for ($i = 0; $i < count($search_matches); $i++)
				{
					$search_matches[$i] = trim($search_matches[$i]);

					if( $search_matches[$i] != '' )
					{
						$word[] = $search_matches[$i];
						if ( !strstr($word_insert_sql[$word_in], "'" . $search_matches[$i] . "'") )
						{
							$word_insert_sql[$word_in] .= ( $word_insert_sql[$word_in] != '' ) ? ", '" . $search_matches[$i] . "'" : "'" . $search_matches[$i] . "'";
						}
					}
				}
			}
		}

		if ( count($word) )
		{
			sort($word);

			$prev_word = '';
			$word_text_sql = '';
			$temp_word = array();
			for($i = 0; $i < count($word); $i++)
			{
				if ( $word[$i] != $prev_word )
				{
					$temp_word[] = $word[$i];
					$word_text_sql .= ( ( $word_text_sql != '' ) ? ', ' : '' ) . "'" . $word[$i] . "'";
				}
				$prev_word = $word[$i];
			}
			$word = $temp_word;

			$check_words = array();
			switch( SQL_LAYER )
			{
				case 'postgresql':
				case 'msaccess':
				case 'mssql-odbc':
				case 'oracle':
				case 'db2':
					$sql = "SELECT word_id, word_text
						FROM " . $search_word_table . "
						WHERE word_text IN ($word_text_sql)";
					if ( !($result = $db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, 'Could not select words', '', __LINE__, __FILE__, $sql);
					}

					while ( $row = $db->sql_fetchrow($result) )
					{
						$check_words[$row['word_text']] = $row['word_id'];
					}
					$db->sql_freeresult($result);
					break;
			}

			$value_sql = '';
			$match_word = array();
			for ($i = 0; $i < count($word); $i++)
			{
				$new_match = true;
				if ( isset($check_words[$word[$i]]) )
				{
					$new_match = false;
				}

				if ( $new_match )
				{
					switch( SQL_LAYER )
					{
						case 'mysql':
						case 'mysql4':
						case 'mysqli':
							$value_sql .= ( ( $value_sql != '' ) ? ', ' : '' ) . '(\'' . $word[$i] . '\', 0)';
							break;
						case 'mssql':
						case 'mssql-odbc':
							$value_sql .= ( ( $value_sql != '' ) ? ' UNION ALL ' : '' ) . "SELECT '" . $word[$i] . "', 0";
						break;
						
						default:
							$sql = "INSERT INTO " . $search_word_table . " (word_text, word_common)
								VALUES ('" . $word[$i] . "', 0)";
							if( !$db->sql_query($sql) )
							{
								mx_message_die(GENERAL_ERROR, 'Could not insert new word', '', __LINE__, __FILE__, $sql);
							}
						break;
					}
				}
			}

			if ( $value_sql != '' )
			{
				switch ( SQL_LAYER )
				{
					case 'mysql':
					case 'mysql4':
					case 'mysqli':
						$sql = "INSERT IGNORE INTO " . $search_word_table . " (word_text, word_common)
							VALUES " . $value_sql;
					break;
					
					case 'mssql':
					case 'mssql-odbc':
						$sql = "INSERT INTO " . $search_word_table . " (word_text, word_common)
							" . $value_sql;
					break;
				}

				if (!$result = $db->sql_query($sql))
				{
					mx_message_die(GENERAL_ERROR, 'Could not insert new word', '', __LINE__, __FILE__, $sql);
				}
				$db->sql_freeresult($result);
			}
		}

		while(list($word_in, $match_sql) = @each($word_insert_sql))
		{
			$title_match = ( $word_in == 'title' ) ? 1 : 0;
			
			if ( $match_sql != '' )
			{
				$sql = "INSERT INTO " . $search_match_table . " ($db_key, word_id, title_match)
					SELECT $block_id, word_id, $title_match
						FROM " . $search_word_table . "
						WHERE word_text IN ($match_sql)";
				if ( !$db->sql_query($sql) )
				{
					//mx_message_die(GENERAL_ERROR, 'Could not insert new word matches', '', __LINE__, __FILE__, $sql);
				}
				$db->sql_freeresult($result);
				/*
				$sql = "SELECT $block_id, word_id, $title_match
					FROM " . $search_word_table . "
					WHERE word_text IN ($match_sql)";
				if ( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not select words', '', __LINE__, __FILE__, $sql);
				}

				while ( $row = $db->sql_fetchrow($result) )
				{
					$word_id = $row['word_id'];
				}
				$db->sql_freeresult($result);


				//To do: Need to be upgraded for UTF-8
				//$sql_where = ' IN (' . $match_sql . ')';
				$sql = "INSERT INTO " . $search_match_table . " ($db_key, word_id, title_match)
					SELECT $block_id, word_id, $title_match
						FROM " . $search_word_table . "
						WHERE word_text IN ($match_sql)";

				$sql = array(
					$db_key => $block_id,
					'word_id' => $word_id,
					'title_match' => $title_match,
				);

				$sql = "INSERT INTO $search_match_table " . $db->sql_build_array('INSERT', $sql);

				if ( !($result = $db->sql_query($sql)) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not insert new word matches', '', __LINE__, __FILE__, $sql);
				}
				*/
			}
		}
		
		if ($mode == 'single')
		{
			// remove_common('single', 4/10, $word);
		}
		return;
	}

	/**
	 * Remove block search data.
	 *
	 * @access private
	 * @param string $block_id remove for block_id
	 * @return unknown words removed
	 */
	function mx_remove_search_post($block_id)
	{
		global $db;

		$search_match_table = MX_MATCH_TABLE;
		$search_word_table = MX_WORD_TABLE;
		$db_key = 'block_id';

		$words_removed = false;

		switch (SQL_LAYER)
		{
			case 'mysql':
			case 'mysql4':
			case 'mysqli':
				$sql = "SELECT word_id
					FROM " . $search_match_table . "
					WHERE $db_key IN ($block_id)
					GROUP BY word_id";
				if ( $result = $db->sql_query($sql) )
				{
					$word_id_sql = '';
					while ( $row = $db->sql_fetchrow($result) )
					{
						$word_id_sql .= ( $word_id_sql != '' ) ? ', ' . $row['word_id'] : $row['word_id'];
					}
					$sql = "SELECT word_id
						FROM " . $search_match_table . "
						WHERE word_id IN ($word_id_sql)
						GROUP BY word_id
						HAVING COUNT(word_id) = 1";
					if ( $result = $db->sql_query($sql) )
					{
						$word_id_sql = '';
						while ( $row = $db->sql_fetchrow($result) )
						{
							$word_id_sql .= ( $word_id_sql != '' ) ? ', ' . $row['word_id'] : $row['word_id'];
						}
						if ( $word_id_sql != '' )
						{
							$sql = "DELETE FROM " . $search_word_table . "
								WHERE word_id IN ($word_id_sql)";
							if ( !$db->sql_query($sql) )
							{
								mx_message_die(GENERAL_ERROR, 'Could not delete word list entry', '', __LINE__, __FILE__, $sql);
							}
							$words_removed = $db->sql_affectedrows();
						}
					}
				}
			break;
			
			default:
				$sql = "DELETE FROM " . $search_word_table . "
					WHERE word_id IN (
						SELECT word_id
						FROM " . $search_match_table . "
						WHERE word_id IN (
							SELECT word_id
							FROM " . $search_match_table . "
							WHERE $db_key IN ($block_id)
							GROUP BY word_id
						)
						GROUP BY word_id
						HAVING COUNT(word_id) = 1
					)";
				if ( !$db->sql_query($sql) )
				{
					mx_message_die(GENERAL_ERROR, 'Could not delete old words from word table', '', __LINE__, __FILE__, $sql);
				}
				$words_removed = $db->sql_affectedrows();
				$db->sql_freeresult($result);
			break;
		}

		$sql = "DELETE FROM " . $search_match_table . "
			WHERE $db_key IN ($block_id)";
		if ( !$db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
		}
		$db->sql_freeresult($result);
		return $words_removed;
	}

	// ------------------------------
	// Public Methods
	//

	/**
	 * Main method
	 *
	 * $action:
	 * - MX_DO_INSERT, MX_DO_UPDATE, MX_DO_DELETE,
	 * - MX_DO_MOVE, MX_DO_SYNC,
	 * - MX_DO_INSTALL, MX_DO_UPGRADE, MX_DO_EXPORT
	 *
	 * $type:
	 * - MX_MODULE_TYPE, MX_FUNCTION_TYPE, MX_PARAMETER_TYPE,
	 * - MX_BLOCK_TYPE, MX_BLOCK_PARAMETER_TYPE, MX_BLOCK_PRIVATE_TYPE, MX_BLOCK_SETTINGS_TYPE,
	 * - MX_PAGE_TYPE, MX_PAGE_COLUMN_TYPE, MX_PAGE_BLOCK_TYPE, MX_PAGE_PRIVATE_TYPE,
	 * - MX_PAGE_TEMPLATE_TYPE, MX_PAGE_TEMPLATE_COLUMN_TYPE
	 *
	 * @access public
	 * @param unknown_type $mode
	 * @param unknown_type $action
	 * @param unknown_type $id
	 * @param unknown_type $parent
	 * @param unknown_type $recache
	 * @return unknown
	 */
	function do_it( $mode = '', $action = '', $id = '', $parent = false, $recache = true )
	{
		switch ( $action )
		{
			case MX_DO_INSERT:
				$message = $this->_do_insert($mode, $id, $parent, $recache);
			break;

			case MX_DO_UPDATE:
				$message = $this->_do_update($mode, $id, $parent, $recache);
			break;

			case MX_DO_DELETE:
				$message = $this->_do_delete($mode, $id, $parent, $recache);
			break;

			case MX_DO_MOVE: // GET VARS
				$message = $this->_do_move($mode);
			break;

			case MX_DO_SYNC: // GET VARS
				$message = $this->_do_sync($mode);
			break;

			case MX_DO_INSTALL: // GET VARS
			case MX_DO_UPGRADE: // GET VARS
				$message = $this->_do_upgrade($mode);
			break;

			case MX_DO_EXPORT: // GET VARS
				$message = $this->_do_export($mode);
			break;
		}

		if (!empty($message))
		{
			return $message;
		}
	}
	/**
	* _start from umil_start
	*
	* A function which runs (almost) every time a function here is ran
	*/
	function _start()
	{
		global $mx_user;

		// Set up the command.  This will get the arguments sent to the function.
		$args = func_get_args();
		$this->command = call_user_func_array(array($this, 'get_output_text'), $args);

		$this->result = (isset($mx_user->lang['SUCCESS'])) ? $mx_user->lang['SUCCESS'] : 'SUCCESS';
		$this->db->sql_return_on_error(true);

		//$this->db->sql_transaction('begin');
	}

	/**
	* _end from umil_end
	*
	* A function which runs (almost) every time a function here is ran
	*/
	function _end()
	{
		global $mx_user;

		// Set up the result.  This will get the arguments sent to the function.
		$args = func_get_args();
		$result = call_user_func_array(array($this, 'get_output_text'), $args);
		$this->result = ($result) ? $result : $this->result;

		if ($this->db->sql_error_triggered)
		{
			if ($this->result == ((isset($mx_user->lang['SUCCESS'])) ? $mx_user->lang['SUCCESS'] : 'SUCCESS'))
			{
				$this->result = 'SQL ERROR ' . $this->db->sql_error_returned['message'];
			}
			else
			{
				$this->result .= '<br /><br />SQL ERROR ' . $this->db->sql_error_returned['message'];
			}

			//$this->db->sql_transaction('rollback');
		}
		else
		{
			//$this->db->sql_transaction('commit');
		}

		$this->db->sql_return_on_error(false);

		// Auto output if requested.
		if ($this->auto_display_results && method_exists($this, 'display_results'))
		{
			$this->display_results();
		}

		return '<strong>' . $this->command . '</strong><br />' . $this->result;
	}	
	
	/**
	* Multicall Helper from umil
	*
	* @param mixed $function Function name to call
	* @param mixed $params The parameters array
	*
	* @return bool True if we have done a multicall ($params is an array), false if not ($params is not an array)
	*/
	function multicall($function, $params)
	{
		if (is_array($params) && !empty($params))
		{
			foreach ($params as $param)
			{
				if (!is_array($param))
				{
					call_user_func(array($this, $function), $param);
				}
				else
				{
					call_user_func_array(array($this, $function), $param);
				}
			}
			return true;
		}

		return false;
	}	
	
	/**
	 * Enter description here...
	 * from umil module_add()
	 * @access public
	 * @param unknown_type $module_id
	 */
	function module_select($class, $parent = 0, $data = array(), $include_path = false)
	{
		global $mx_cache, $mx_user, $mx_root_path, $module_root_path, $phpEx;

		// Multicall
		if ($this->multicall(__FUNCTION__, $class))
		{
			return;
		}

		// Prevent stupid things like trying to add a module with no name or any data on it
		if (empty($data))
		{
			$this->_start('MODULE_ADD', $class, 'UNKNOWN');
			return $this->_end('FAIL');
		}

        // Allows '' to be sent as 0
		$parent = (!$parent) ? 0 : $parent;

		// allow sending the name as a string in $data to create a category
		if (!is_array($data))
		{
			$data = array('module_langname' => $data);
		}

		if (!isset($data['module_langname']))
		{
			// The "automatic" way
			$basename = (isset($data['module_basename'])) ? $data['module_basename'] : '';
			$basename = str_replace(array('/', '\\'), '', $basename);
			$class = str_replace(array('/', '\\'), '', $class);
			$info_file = "$class/info/{$class}_$basename.$phpEx";

			// The manual and automatic ways both failed...
			if (!file_exists((($include_path === false) ? $module_root_path . 'includes/' : $include_path) . $info_file))
			{
				$this->_start('MODULE_ADD', $class, $info_file);
				return $this->_end('FAIL');
			}

			$classname = "{$class}_{$basename}_info";

			if (!class_exists($classname))
			{
				include((($include_path === false) ? $module_root_path . 'includes/' : $include_path) . $info_file);
			}

			$info = new $classname;
			$module = $info->module();
			unset($info);

			$result = '';
			foreach ($module['modes'] as $mode => $module_info)
			{
				if (!isset($data['modes']) || in_array($mode, $data['modes']))
				{
					$new_module = array(
						'module_basename'	=> $basename,
						'module_langname'	=> $module_info['title'],
						'module_mode'		=> $mode,
						'module_auth'		=> $module_info['auth'],
						'module_display'	=> (isset($module_info['display'])) ? $module_info['display'] : true,
						'before'			=> (isset($module_info['before'])) ? $module_info['before'] : false,
						'after'				=> (isset($module_info['after'])) ? $module_info['after'] : false,
					);

					// Run the "manual" way with the data we've collected.
					//$result .= ((isset($data['spacer'])) ? $data['spacer'] : '<br />') . $this->module_add($class, $parent, $new_module);
					return $new_module;
				}
			}

			//return $result;
		}

		// The "manual" way
		//$this->_start('MODULE_ADD', $class, ((isset($mx_user->lang[$data['module_langname']])) ? $mx_user->lang[$data['module_langname']] : $data['module_langname']));
		//add_log('admin', 'LOG_MODULE_ADD', ((isset($mx_user->lang[$data['module_langname']])) ? $mx_user->lang[$data['module_langname']] : $data['module_langname']));
		
		$new_module = array(
			'module_basename'	=> $data['module_basename'],
			'module_langname'	=> $data['module_langname'],
			'module_mode'		=> $data['module_mode'],
			'module_auth'		=> $data['module_auth'],
			'module_display'	=> (isset($data['display'])) ? $data['display'] : true,
			'before'			=> (isset($data['before'])) ? $data['before'] : false,
			'after'				=> (isset($data['after'])) ? $data['after'] : false,
		);
		
		return $new_module;
	}	
}	// class mx_admin

/**
 * Class: mx_dynamic_select.
 *
 * The mx_dynamic_select class generates dynamic select dropdown boxes: the javascript and form itself.
 *
 * Methods:
 * - $tpl_code = $mx_dynamic_select->generate();
 *
 * Usage examples:
 * - $template->assign_block_vars('javamodule.javafunction.javablock', array( 'DYNAMIC_SELECT' => $tpl_code,
 *
 * @package AdminCP
 * @author Jon Ohlsson
 * @access public
 *
 */
class mx_dynamic_select
{
	/**#@+
	 * Class mx_dynamic_select specific vars
	 */
	var $tpl = '';

	var $module_default_id = '';
	var $function_default_id = '';
	var $block_default_id = '';

	var $modules = array();
	var $moduleFunctions = array();
	var $functionBlocks = array();	

	// ------------------------------
	// Private Methods
	//

	/**
	 * Enter description here...
	 * @access private
	 */
	function _get_data($all_functions = false)
	{
		global $db, $template, $lang, $board_config, $userdata;
		
		if ($all_functions)
		{
			$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? true : false;
			// Authorization SQL	
			if ($is_admin !== false)
			{
				$auth_blocks = get_auth_blocks();
				$auth_sql = " AND blk.block_id in ( ". $auth_blocks. " ) ";
			}
			else
			{
				$auth_blocks = "";
				$auth_sql = " ";
			}
			
			//
			// First, get a module, function, block mapping
			//
			$sql = "SELECT *
				FROM " . BLOCK_TABLE . " blk,
					" . FUNCTION_TABLE . " fnc
				WHERE blk.function_id = fnc.function_id
					" . $auth_sql . "
				ORDER BY fnc.function_id ASC, blk.block_title ASC";
				
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't get list of Functions/Block", '', __LINE__, __FILE__, $sql);
			}
			
			if( $total_blocks = $db->sql_numrows($result) )
			{
				$row = $db->sql_fetchrowset($result);
			}
			$db->sql_freeresult($result);
			$function_id = $block_id = 0;

			$functionBlocks = array();
			for( $j = 0; $j < $total_blocks; $j++ )
			{
				$functionBlocks[$row[$j]['function_id']][] = $row[$j];
			}
			unset($row);
			
			//
			// Generate dynamic block select
			//
			$sql = "SELECT *
				FROM " . FUNCTION_TABLE . " fnc,
					" . MODULE_TABLE . " mdl
				WHERE mdl.module_id = fnc.module_id
				ORDER BY mdl.module_name ASC, fnc.function_name ASC";
				
			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't get list of Modules/Functions", '', __LINE__, __FILE__, $sql);
			}
			
			if( $total_functions = $db->sql_numrows($result) )
			{
				$row = $db->sql_fetchrowset($result);
			}
			$db->sql_freeresult($result);
			$module_id = $function_id = 0;
			
			for($j = 0; $j < $total_functions; $j++)
			{
				if ($row[$j]['function_file'] == 'mx_multiple_blocks.php' || $row[$j]['function_file'] == 'mx_dynamic.php' || $row[$j]['function_file'] == 'mx_virtual.php')
				{
					continue;
				}
				
				$i = ($j > 0) ? abs($j - 1) : 0;		
				if( $row[$j]['module_id'] != $row[$i]['module_id'] )
				{
					$module_desc_tmp = str_replace("\n", '', $row[$j]['module_desc']);
					$module_desc_tmp = str_replace("\r", '', $module_desc_tmp);
					
					$module_id = $row[$j]['module_id'];
					$module_title = ($row[$j]['module_name']) ? addslashes(strip_tags(trim($row[$j]['module_name']))) : '';
					$module_desc = ($row[$j]['module_desc']) ? addslashes(strip_tags(trim($module_desc_tmp))) : '';
					
					$this->_addModule($module_id, $module_title, $module_desc);
				}
				
				$function_desc_tmp = str_replace("\n", '', $row[$j]['function_desc']);
				$function_desc_tmp = str_replace("\r", '', $function_desc_tmp);
				
				$function_id = $row[$j]['function_id'];
				$function_title = ($row[$j]['function_name']) ? addslashes(strip_tags(trim($row[$j]['function_name']))) : 'function';
				$function_desc = ($function_desc_tmp) ? addslashes(strip_tags(trim($function_desc_tmp))) : 'function desc';
				
				if(!is_null($module_id) && ($module_id !== 0))
				{
					$this->_addFunction($module_id, $function_id, $function_title, $function_desc);
				}
				
				// Get all function blocks (if any)
				if (isset($functionBlocks[$function_id]) && ($module_id !== 0))
				{
					foreach($functionBlocks[$function_id] as $key => $block_row)
					{
						$block_desc_tmp = str_replace("\n", '', $block_row['block_desc']);
						$block_desc_tmp = str_replace("\r", '', $block_desc_tmp);
						
						$block_id = $block_row['block_id'];
						$block_title = ($block_row['block_title']) ? substr(addslashes(strip_tags(trim($block_row['block_title']))), 0, 25 ) : '';
						$block_desc = ($block_desc_tmp) ? ' (' . substr(addslashes(strip_tags(trim($block_desc_tmp))), 0, 25 ) . ')' : '';
						
						$this->_addBlock($module_id, $function_id, $block_id, $block_title, $block_desc);
					}
				}
			}
			unset($row);
		}
		else
		{
			//
			// Authorization SQL
			//
			$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;
			$auth_blocks = get_auth_blocks();			
			$auth_sql = (!$is_admin) ? " AND blk.block_id in ( ". $auth_blocks. " ) " : "";
			
			//
			// Generate dynamic block select
			//
			$sql = "SELECT blk.*, function_admin, fnc.function_name, fnc.function_id, fnc.function_desc, fnc.function_file, fnc.module_id, mdl.module_name, mdl.module_id, mdl.module_desc
				FROM " . BLOCK_TABLE . " blk,
					" . FUNCTION_TABLE . " fnc,
					" . MODULE_TABLE . " mdl
				WHERE blk.function_id = fnc.function_id
					AND mdl.module_id = fnc.module_id
					" . $auth_sql . "
				ORDER BY mdl.module_name ASC, fnc.function_name ASC";

			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't get list of Modules/Functions", '', __LINE__, __FILE__, $sql);
			}

			if($total_blocks = $db->sql_numrows($result))
			{
				$row = $db->sql_fetchrowset($result);
			}
			$db->sql_freeresult($result);
			$module_id = $function_id = $block_id = 0;
			
			for( $j = 0; $j < $total_blocks; $j++ )
			{
				$i = ($j > 0) ? abs($j - 1) : 0;
				if($row[$j]['module_id'] != $row[$i]['module_id'])
				{
					$module_desc_tmp = str_replace("\n", '', $row[$j]['module_desc']);
					$module_desc_tmp = str_replace("\r", '', $module_desc_tmp);
					
					$module_id = $row[$j]['module_id'];
					$module_title = !empty($row[$j]['module_name']) ? addslashes(strip_tags(trim($row[$j]['module_name']))) : '';
					$module_desc = !empty($row[$j]['module_desc']) ? addslashes(strip_tags(trim($module_desc_tmp))) : '';
					
					$this->_addModule($module_id, $module_title, $module_desc);
				}
				
				if( $row[$j]['function_id'] != $row[$i]['function_id'] )
				{
					if ($row[$j]['function_file'] == 'mx_multiple_blocks.php' || $row[$j]['function_file'] == 'mx_dynamic.php' || $row[$j]['function_file'] == 'mx_virtual.php')
					{
						continue;
					}
					$function_desc_tmp = str_replace("\n", '', $row[$j]['function_desc']);
					$function_desc_tmp = str_replace("\r", '', $function_desc_tmp);
					
					$function_id = $row[$j]['function_id'];
					$function_title = !empty($row[$j]['function_name']) ? addslashes(strip_tags(trim($row[$j]['function_name']))) : '';
					$function_desc = !empty($function_desc_tmp) ? addslashes(strip_tags(trim($function_desc_tmp))) : '';
					
					if(!is_null($module_id) && ($module_id !== 0))
					{
						$this->_addFunction($module_id, $function_id, $function_title, $function_desc);
					}					
				}
				$block_desc_tmp = str_replace("\n", '', $row[$j]['block_desc']);
				$block_desc_tmp = str_replace("\r", '', $block_desc_tmp);
				
				$block_id = $row[$j]['block_id'];
				$block_title = !empty($row[$j]['block_title']) ? substr(addslashes(strip_tags(trim($row[$j]['block_title']))), 0, 25 ) : '';
				$block_desc = !empty($block_desc_tmp) ? ' (' . substr(addslashes(strip_tags(trim($block_desc_tmp))), 0, 25 ) . ')' : '';
				
				$this->_addBlock($module_id, $function_id, $block_id, $block_title, $block_desc);
			}
			unset($row);
		}
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $module_id
	 * @param unknown_type $function_id
	 * @param unknown_type $block_id
	 * @param unknown_type $block_title
	 * @param unknown_type $block_desc
	 */
	function _addBlock($module_id = '', $function_id = '', $block_id = '', $block_title = '', $block_desc = '')
	{
		if (!empty($this->functionBlocks[$module_id][$function_id]))
		{
			$this->functionBlocks[$module_id][$function_id] = $this->functionBlocks[$module_id][$function_id] . (!empty($this->functionBlocks[$module_id][$function_id]) ? ',' : '') . '"' . $block_title . $block_desc . '","' . $block_id . '"';
		}
		else
		{
			$this->functionBlocks[$module_id][$function_id] = (!empty($this->functionBlocks[$module_id][$function_id]) ? ',' : '') . '"' . $block_title . $block_desc . '","' . $block_id . '"';
		}		
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $module_id
	 * @param unknown_type $function_id
	 * @param unknown_type $function_title
	 * @param unknown_type $function_desc
	 */
	function _addFunction($module_id = '', $function_id = '', $function_title = '', $function_desc = '')
	{
		if (!empty($this->moduleFunctions[$module_id]))
		{
			$this->moduleFunctions[$module_id] = $this->moduleFunctions[$module_id] . (!empty($this->moduleFunctions[$module_id]) ? ',' : '') . '"' . $function_title . '","' . $function_id . '"';
		}
		else
		{
			$this->moduleFunctions[$module_id] =  '"' . $function_title . '","' . $function_id . '"';
		}		
	}
	
	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $module_id
	 * @param unknown_type $module_title
	 * @param unknown_type $module_desc
	 */
	function _addModule($module_id = '', $module_title = '', $module_desc = '')
	{
		if (!empty($module_title))
		{
			$this->modules[$module_id] = $module_title;
		}
		else
		{
			$this->modules[$module_id] = 'Module';
		}	
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $block_id
	 */
	function _generate_tpl($block_id)
	{
		global $template, $blockcptemplate, $lang, $phpEx, $mx_request_vars, $mx_root_path, $userdata, $portalpage, $dynamic_block_id;
		
		$module_select_list = '';
		$function_list = '';
		$block_list = '';
		$default_list = '';
		
		$this->module_default_id = $mx_request_vars->request('module_id', MX_TYPE_INT, '');
		$this->function_default_id = $mx_request_vars->request('function_id', MX_TYPE_INT, '');
		$this->block_default_id = $mx_request_vars->request('block_id', MX_TYPE_INT, $block_id);
		
		if (!empty($this->block_default_id) && (empty($this->module_default_id) || empty($this->function_default_id)))
		{
			$this->_get_default_data($this->block_default_id);
		}
		
		foreach($this->modules as $key => $value)
		{
			$selected = ( $key == $this->module_default_id ) ? ' selected="selected"' : '';
			$module_select_list .= '<option value="' . $key . '"' . $selected . '>' . $value . "</option>\n";
		}
		
		foreach($this->moduleFunctions as $module_id => $functions)
		{
			$function_list .= 'makeModule.forValue("'.$module_id.'").addOptionsTextValue('.$functions.')'.";\n";
		}
		
		foreach($this->functionBlocks as $module_id => $functions)
		{
			foreach($functions as $function_id => $blocks)
			{
				$block_list .= 'makeModule.forValue("'.$module_id.'").forValue("'.$function_id. '").addOptionsTextValue('.$blocks.')'.";\n";
			}
		}
		
		$default_list = 'makeModule.forField("module_id").setValues("'.$this->module_default_id.'")'.";\n";
		$default_list .= 'makeModule.forField("function_id").setValues("'.$this->function_default_id.'")'.";\n";
		$default_list .= 'makeModule.forField("block_id").setValues("'.$this->block_default_id.'")'.";\n";
		
		//
		// Hidden fields
		//
		$s_hidden_dyn_fields = 	'<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />
								<input type="hidden" name="dynamic_block" value="' . $dynamic_block_id . '" />
								<input type="hidden" name="portalpage" value="' . $portalpage . '" />';
								
		$tpl = array(
			'S_HIDDEN_DYN_FILEDS' => $s_hidden_dyn_fields,
			'MX_DYN_PATH' => $mx_root_path,
			'L_MODULE' => $lang['Module'],
			'L_FUNCTION' => $lang['Function'],
			'L_BLOCK' => $lang['Block'],
			
			'S_UPDATE' => $lang['Update'],
			'S_RESET' => $lang['Reset'],
			
			'DYNAMIC_MODULE_SELECT' => $module_select_list,
			'DYNAMIC_FUNCTION_SETUP' => $function_list,
			'DYNAMIC_BLOCK_SETUP' => $block_list,
			'DYNAMIC_DEFAULT_SETUP' => $default_list,
		);
		
		if (is_object($blockcptemplate))
		{
			$blockcptemplate->assign_vars($tpl);
		}
		else
		{
			$template->assign_vars($tpl);
		}
		unset($tpl);
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $block_id
	 */
	function _get_default_data($block_id)
	{
		global $db;
		//
		// Generate dynamic block select
		//
		$sql = "SELECT fnc.function_id, mdl.module_id
			FROM " . BLOCK_TABLE . " blk,
				" . FUNCTION_TABLE . " fnc,
				" . MODULE_TABLE . " mdl
			WHERE blk.function_id = fnc.function_id
				AND mdl.module_id = fnc.module_id
				AND blk.block_id = '".$block_id."'
			ORDER BY mdl.module_name ASC, fnc.function_name ASC";
			
		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't get default module/function id", '', __LINE__, __FILE__, $sql);
		}
		
		if( $total_blocks = $db->sql_numrows($result) )
		{
			$row = $db->sql_fetchrow($result);
		}
		$db->sql_freeresult($result);
		
		$this->module_default_id = $row['module_id'];
		$this->function_default_id = $row['function_id'];
		unset($row);
	}

	// ------------------------------
	// Public Methods
	//
	//

	/**
	 * Enter description here...
	 *
	 * @access public
	 * @param unknown_type $block_id
	 */
	function generate($block_id = '', $all_functions = false)
	{
		$this->_get_data($all_functions);
		$this->_generate_tpl($block_id);
	}	
}

/**
 * Generate Output
 *
 * @access public
 * @param unknown_type $sql
 * @param unknown_type $main_install
 * @return unknown
 */
function mx_do_install_upgrade(array $sql, $main_install = false)
{
	global $table_prefix, $mx_table_prefix, $userdata, $phpEx, $template, $lang, $db, $board_config;

	$inst_error = false;
	$n = 0;
	$message = "<b>" . $lang['list_of_queries'] . "</b><br /><br />";

	while (isset($sql[$n]))
	{
		if ( !$result = $db->sql_query( $sql[$n] ) )
		{
			$message .= '<b><font color=#FF0000>[' . $lang['already_added'] . ']</font></b> line: ' . ( $n + 1 ) . ' , ' . $sql[$n] . '<br />';
			$inst_error = true;
		}
		else
		{
			$message .= '<b><font color=#0000fF>[' .  $lang['added_upgraded'] . ']</font></b> line: ' . ( $n + 1 ) . ' , ' . $sql[$n] . '<br />';
		}
		$n++;
	}
	$message .= '<br /> ' . $lang['upgrading_modules'];

	return $message;
}

/**
 * Enter description here...
 *
 * @param unknown_type $default
 * @param unknown_type $select_name
 * @return unknown
 */
function mx_generate_meta_select($default, $select_name)
{
	global $lang;

	$select = '<select name="' . $select_name . '">';
	foreach( $lang['mx_meta'][$select_name] as $key => $value )
	{
		$selected = ( $key == $default ) ? ' selected="selected"' : '';
		$select .= '<option value="' . $key . '"' . $selected . '>' . $value . "</option>\n";
	}
	$select .= '</select>';

	return $select;
}

/**
	* Check MEM Limit
*/
function mx_check_mem_limit()
{
	$mem_limit = @ini_get('memory_limit');
	if (!empty($mem_limit))
	{
		$unit = strtolower(substr($mem_limit, -1, 1));
		$mem_limit = (int) $mem_limit;

		if ($unit == 'k')
		{
			$mem_limit = floor($mem_limit / 1024);
		}
		elseif ($unit == 'g')
		{
			$mem_limit *= 1024;
		}
		elseif (is_numeric($unit))
		{
			$mem_limit = floor((int) ($mem_limit . $unit) / 1048576);
		}
		$mem_limit = max(128, $mem_limit) . 'M';
	}
	else
	{
		$mem_limit = '128M';
	}
	return $mem_limit;
}
	
/**
* Retrieve contents from remotely stored file
*/
function mx_get_remote_file($host, $directory, $filename, &$errstr, &$errno, $port = 80, $timeout = 10)
{
	global $user;

	if ($fsock = @fsockopen($host, $port, $errno, $errstr, $timeout))
	{
		@fputs($fsock, "GET $directory/$filename HTTP/1.1\r\n");
		@fputs($fsock, "HOST: $host\r\n");
		@fputs($fsock, "Connection: close\r\n\r\n");

		$file_info = '';
		$get_info = false;

		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$file_info .= @fread($fsock, 1024);
			}
			else
			{
				$line = @fgets($fsock, 1024);
				if ($line == "\r\n")
				{
					$get_info = true;
				}
				else if (stripos($line, '404 not found') !== false)
				{
					$errstr = $user->lang['FILE_NOT_FOUND'] . ': ' . $filename;
					return false;
				}
			}
		}
		@fclose($fsock);
	}
	else
	{
		if ($errstr)
		{
			$errstr = utf8_convert_message($errstr);
			return false;
		}
		else
		{
			$errstr = $user->lang['FSOCK_DISABLED'];
			return false;
		}
	}

	return $file_info;
}
?>