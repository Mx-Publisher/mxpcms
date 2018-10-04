<?php
/**
*
* @package MX-Publisher Core
* @version $Id: index_jon.php,v 1.2 2008/07/10 23:17:13 jonohlsson Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

/**
 * MX-Publisher Notes:
 *    This file is borrowed from phpBB, with some modifications
 */

//
// Security and Page header
//
define('IN_PORTAL', 1);
define('ADMIN_START', true);
define('NEED_SID', true);

$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = TRUE;

require('./pagestart.' . $phpEx);

define( 'MAIN_CATEGORY', 'portal' );
define( 'MODULE_CATEGORY', 'modules' );
define( 'PHPBB2X_CATEGORY', 'phpbb2' );
define( 'OLYMPUS_CATEGORY', 'phpbb3' );


// ------------------------------
// DEBUG ONLY ;-)
//
//error_reporting(E_ALL);
// ------------------------------

/**
 * Enter description here...
 *
 * @param unknown_type $needle
 * @param unknown_type $haystack
 * @return unknown
 */
function inarray( $needle, $haystack )
{
	for( $i = 0; $i < sizeof( $haystack ); $i++ )
	{
		if ( $haystack[$i] == $needle )
		{
			return true;
		}
	}
	return false;
}

/**
 * Enter description here...
 *
 * @param unknown_type $needle
 * @param unknown_type $haystack
 * @return unknown
 */
function inarray_dec_( $needle, $haystack )
{
	return inarray( $needle, $haystack );
}

/**
 * Enter description here...
 *
 * @param unknown_type $dir_module
 * @return unknown
 */
function read_admin( $dir_module )
{
	global $phpEx, $template, $lang, $board_config, $phpbb_root_path, $mx_user;

	$module = array();
	if ( $dir = @opendir( $dir_module ) )
	{
		$setmodules = 1;
		while ( $file = @readdir( $dir ) )
		{
			if ( preg_match( "/^admin_.*?\." . $phpEx . "$/", $file ) )
			{
				include( $dir_module . '/' . $file );
			}
		}
		@closedir( $dir );
		unset( $setmodules );
	}
	return $module;
}
// End functions
// -------------

/**
 * Enter description here...
 *
 */
class mx_acp
{
	var $panel_html = '';
	var $category = '';
	var $panel = '';

	var $tabs = array();

	var $menu_complete = array();
	var $menu_actions = array();
	var $menu = array();
	var $category_title = '';
	var $panel_title = '';

	var $action_script = '';
	var $phpbb3_hook = null;
	var $phpbb3_i = null;

	/**
	 * Constructor
	 *
	 * @access protected
	 */
	function mx_acp()
	{
		global $template, $db, $lang, $phpEx, $mx_root_path, $phpbb_root_path, $phpbb_auth, $mx_user;

		$this->_template_set_filenames();
		$this->category = MAIN_CATEGORY;
		$this->category_title = $lang['MX_Portal'];

		//
		// Some includes
		//
		if ( PORTAL_BACKEND == 'phpbb2' )
		{
			mx_cache::load_file( 'functions', true );
			mx_cache::load_file( 'functions_selects', true );
			mx_cache::load_file( 'functions_validate', true );
		}

		if ( PORTAL_BACKEND == 'phpbb3' )
		{
			include_once( $mx_root_path . 'includes/sessions/phpbb3/auth.' . $phpEx );
			mx_cache::load_file( 'functions_admin', 'phpbb3' );
			mx_cache::load_file( 'acp/auth', 'phpbb3' );
			mx_cache::load_file( 'auth', 'phpbb3');
			mx_cache::load_file( 'functions', 'phpbb3' );
			mx_cache::load_file( 'functions', 'phpbb2' );
			mx_cache::load_file( 'functions_module', 'phpbb3' );
			mx_cache::load_file( 'message_parser' , 'phpbb3' );

			$phpbb_admin_path = ( defined( 'PHPBB_ADMIN_PATH' ) ) ? PHPBB_ADMIN_PATH : 'adm/';

			include_once( $mx_root_path . 'includes/shared/phpbb3/includes/functions_hook.' . $phpEx );
			$this->phpbb3_hook = new mx_phpbb3_admin( $this );

		}
	}

	/**
	 * Parsing params for display
	 *
	 * @param string $params query string
	 */
	function decode_url( $params )
	{
		global $lang, $mx_user ;
		if ( isset( $params['cat'] ) )
		{
			$this->category = $params['cat'];
			switch ( $this->category )
			{
				case MAIN_CATEGORY:
					$this->category_title = $lang['MX_Portal'];
					break;
				case MODULE_CATEGORY:
					$this->category_title = $lang['MX_Modules'];
					break;
				case PHPBB2X_CATEGORY:
					$this->category_title = $lang['Phpbb'];
					break;
				case OLYMPUS_CATEGORY:
					$this->category_title = '';
					$this->phpbb3_i = @$params['i'];
					break;
			} // switch
		}
		if ( isset( $params['panel'] ) )
		{
			$this->panel = $params['panel'];
		}
	}

	/**
	 * get current tabs
	 */
	function assign_tabs()
	{
		global $lang, $mx_user, $db, $template;
		// MX PORTAL MAIN CATEGORY
		$this->tabs = array();
		$this->tabs[] = array( // #
			'ACTIVE_TAB' => ( $this->category == MAIN_CATEGORY )?'activetab':'',
			'CATEGORY' => MAIN_CATEGORY,
			'PARAMS' => '',
			'L_TAB' => $lang['MX_Portal'],
			);
		// MX PORTAL MODULE CATEGORY
		$this->tabs[] = array( // #
			'ACTIVE_TAB' => ( $this->category == MODULE_CATEGORY )?'activetab':'',
			'CATEGORY' => MODULE_CATEGORY,
			'PARAMS' => '',
			'L_TAB' => $lang['MX_Modules'],
			);
		// PHPBB TABS
		switch ( PORTAL_BACKEND )
		{
			case 'phpbb2': // phpBB2 Backend TABS
				$this->tabs[] = array( // #
					'ACTIVE_TAB' => ( $this->category == PHPBB2X_CATEGORY )?'activetab':'',
					'CATEGORY' => PHPBB2X_CATEGORY,
					'PARAMS' => '',
					'L_TAB' => $lang['Phpbb'],
					);
				break;
			case 'phpbb3': // phpBB3 Backend TABS
				$phpbb3_tabs = $this->phpbb3_hook->get_tabs( $this->phpbb3_i );
				if ( $this->category == OLYMPUS_CATEGORY )
				{
					$this->category_title = $lang['Phpbb'] . ' &bull; ' . $phpbb3_tabs['CATEGORY_TITLE'];
				}
				$this->tabs = array_merge( $this->tabs, $phpbb3_tabs['TABS'] );
				break;
		}

		foreach( $this->tabs as $key => $tab )
		{
			$template->assign_block_vars( 'tab', $tab );
		}
	}

	function _read_menu_actions( $menu_array, $category = MAIN_CATEGORY )
	{
		if ( !is_array( $menu_array ) )
		{
			return;
		}

		switch ( $category )
		{
			case MAIN_CATEGORY:
			case MODULE_CATEGORY:
			case PHPBB2X_CATEGORY:
				$cat_keys = array_keys( $menu_array );
				for( $i = 0; $i < count( $menu_array ); $i++ )
				{
					while ( list( $menu, $action ) = each( $menu_array[$cat_keys[$i]] ) )
					{
						$this->menu_actions[$action] = 'panel=' . $menu;
					}
				}
				break;
			case OLYMPUS_CATEGORY:

				$cat_main = array_keys( $menu_array );

				for( $i = 0; $i < count( $menu_array ); $i++ )
				{
					$cat_keys = array_keys( $menu_array[$cat_main[$i]] );
					for( $j = 0; $j < count( $menu_array[$cat_main[$i]] ); $j++ )
					{
						while ( list( $menu, $action ) = each( $menu_array[$cat_main[$i]][$cat_keys[$j]] ) )
						{
							$this->menu_actions[$action] = $menu;
						}
					}
				}
				break;
		}
	}

	function assign_menu()
	{
		global $lang, $db, $template, $mx_user, $mx_root_path, $phpbb_root_path, $phpEx;

		$allow_menu_sort = true;
		// #
		// # Load Main Portal Menu
		// #
		$this->menu_complete[MAIN_CATEGORY] = read_admin( './' );
		$this->_read_menu_actions( $this->menu_complete[MAIN_CATEGORY], MAIN_CATEGORY );
		// #
		// # Load Main Modules Menu
		// #
		$sql = "SELECT *
				FROM " . MODULE_TABLE . "
				WHERE module_include_admin = 1
				ORDER BY module_name";

		if ( !( $q_modules = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not query modules information", '', __LINE__, __FILE__, $sql );
		}

		if ( $total_modules = $db->sql_numrows( $q_modules ) )
		{
			$module_rows = $db->sql_fetchrowset( $q_modules );
		}
		$db->sql_freeresult( $result );
		$menu_array = array();
		for( $module_cnt = 0; $module_cnt < $total_modules; $module_cnt++ )
		{
			$module_path_admin = $mx_root_path . $module_rows[$module_cnt]['module_path'] . "admin/";
			$module_path_root = $mx_root_path . $module_rows[$module_cnt]['module_path'];
			// **********************************************************************
			// Read language definition
			// **********************************************************************
			$board_langfile = $module_path_root . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx;
			$main_langfile = $module_path_root . 'language/lang_english/lang_admin.' . $phpEx;
			if ( file_exists( $board_langfile ) )
			{
				include( $board_langfile );
			}
			else if ( file_exists( $main_langfile ) )
			{
				include( $main_langfile );
			}

			$menu_array = array_merge_recursive( $menu_array, read_admin( $module_path_admin ) );
		}

		$this->menu_complete[MODULE_CATEGORY] = $menu_array;
		$this->_read_menu_actions( $this->menu_complete[MODULE_CATEGORY], MODULE_CATEGORY );

		switch ( PORTAL_BACKEND )
		{
			case 'phpbb2':
				$mnu_ary = read_admin( $phpbb_root_path . 'admin/' );
				$menu_array = array();

				foreach( $mnu_ary as $key => $menu )
				{
					$i = 0;

					foreach( $menu as $menu_id => $action_file )
					{
						$menu_array[$key][$menu_id . '_' . $key] = substr( $phpbb_root_path, strlen( $mx_root_path ) ) . 'admin/' . $action_file;
						$lang[ $menu_id . '_' . $key ] = $lang[ $menu_id];
						$i++;
					}
				}
				$this->menu_complete[PHPBB2X_CATEGORY] = $menu_array;
				$this->_read_menu_actions( $menu_array, PHPBB2X_CATEGORY );

				break;
			case 'phpbb3':
				$this->menu_complete[OLYMPUS_CATEGORY] = $this->phpbb3_hook->get_menu_complete();
				$this->_read_menu_actions( $this->menu_complete[OLYMPUS_CATEGORY], OLYMPUS_CATEGORY );
				break;
		}

		$menu_array = $this->menu_complete[$this->category];
		switch ( $this->category )
		{
			case MAIN_CATEGORY:
			case MODULE_CATEGORY:
			case PHPBB2X_CATEGORY:
				if ( empty( $this->panel ) )
				{
					$mnu_ary = $menu_array;
					ksort( $mnu_ary );
					$menu_array_keys = array_keys( $mnu_ary );
					ksort( $mnu_ary[$menu_array_keys[0]] );
					$panel_keys = array_keys( $mnu_ary[$menu_array_keys[0]] );
					$this->panel = $panel_keys[0];
				}
				break;
			case OLYMPUS_CATEGORY:
				$allow_menu_sort = false;
				$menu_array = $this->phpbb3_hook->get_menu( $this->phpbb3_i );
				if ( empty( $this->panel ) )
				{
					$menu_keys = array_keys( $menu_array );
					$p_keys = array_keys( $menu_array[$menu_keys[0]] );
					$this->panel = $p_keys[0];
				}
				break;
		}

		if ( sizeOf( $menu_array ) == 0 )
		{
			return;
		}

		$this->menu = $menu_array;

		if ( $allow_menu_sort )
		{
			ksort( $menu_array );
		}
		$menu_cat_id = 0;
		while ( list( $category, $action_array ) = each( $menu_array ) )
		{
			$lang_category = ( !empty( $lang[$category] ) ) ? $lang[$category] : preg_replace( "/_/", " ", $category );

			$template->assign_block_vars( 'category', array(
					// +MOD: DHTML Menu for ACP
					'MENU_CAT_ID' => $menu_cat_id,
					'MENU_CAT_ROWS' => count( $action_array ),
					// -MOD: DHTML Menu for ACP
					'ADMIN_CATEGORY' => $lang_category )
				);

			if ( $allow_menu_sort )
			{
				ksort( $action_array );
			}
			$row_count = 0;
			while ( list( $panel, $file ) = each( $action_array ) )
			{
				$lang_menu = isset( $mx_user->lang[$panel] )?$mx_user->lang[$panel]:( !empty( $lang[$panel] ) ? $lang[$panel] : preg_replace( "/_/", " ", $panel ) );
				$file_part = explode( '?', $file );
				if ( $this->panel == $panel )
				{
					if ( strpos( $file, 'http://' ) !== false )
					{
						header( 'Location: ' . $file );
					}
					$this->action_script = $file_part[0];
					$this->panel_title = $lang_menu;
				}

				switch ( $this->category )
				{
					case OLYMPUS_CATEGORY:
						$menu_link_params = preg_replace( '#panel=[^&]*#', '&amp;cat=' . $this->category . '&amp;panel=' . $panel, $file_part[1] );
						break;
					case PHPBB2X_CATEGORY:
					case MODULE_CATEGORY:
					case MAIN_CATEGORY:
						$menu_link_params = str_replace( '?', '', '&amp;cat=' . $this->category . '&amp;panel=' . $panel . '&amp;' . $file_part[1] );
						break;
				}

				$menu_link_params = explode( '&amp;', $menu_link_params );
				sort( $menu_link_params, SORT_STRING );
				reset( $menu_link_params );
				$menu_link = basename( __FILE__ ) . '?' . implode( '&amp;', $menu_link_params );

				$menu_link = str_replace( '&amp;&amp;', '&amp;', $menu_link );
				$menu_link = str_replace( '?&amp;', '?', $menu_link );

				if ( strpos( $menu_link, 'sid=' ) === false )
				{
					$menu_link = mx_append_sid( $menu_link );
				}

				$template->assign_block_vars( 'category.panel', array( "ROW_COLOR" => "#" . $row_color,
						"ROW_CLASS" => $row_class,
						// +MOD: DHTML Menu for ACP
						'ROW_COUNT' => $row_count,
						// -MOD: DHTML Menu for ACP
						"L_PANEL" => $lang_menu,
						'U_PANEL' => $menu_link,
						'A_PANEL' => $this->panel == $panel?'activemenu':'',
						) );
				$row_count++;
			}
			// +MOD: DHTML Menu for ACP
			$menu_cat_id++;
			// -MOD: DHTML Menufor ACP
		}
		$this->menu_actions = array_merge( array( $this->action_script => $this->menu_actions[$this->action_script] ), $this->menu_actions );
	}

	function prepare_action_script()
	{
		if ( empty( $this->action_script ) )
		{
			mx_message_die( GENERAL_INFO, 'No action script to place in panel' );
		}

		global $mx_root_path, $phpbb_root_path, $phpEx;

		switch ( $this->category )
		{
			case MAIN_CATEGORY:
			case MODULE_CATEGORY:
			case PHPBB2X_CATEGORY:
				$script = trim( file_get_contents( $mx_root_path . $this->action_script ) );
				$folders = explode( '/' , dirname( $this->action_script ) );
				$module_root_path = '';
				for( $i = 0; $i < sizeOf( $folders ); $i++ )
				{
					if ( $folders[$i] == 'admin' )
					{
						unset( $folders[$i] );
					}
				}
				$module_root_path = implode( '/', $folders ) . '/';

				$preg_array = array( '#^<\?(php)?#' => '',
					'#\?>$#' => '',
					"#define\('IN_PORTAL', 1\);#si" => '',
					'#\$mx_root_path = [^;]*;#si' => '',
					'#([^_]{1})append_sid#si' => '\1mx_append_sid',
					'#([^_]{1})mx_message_die#si' => '\1$mx_acp->mx_message_die_acp',
					'#([^_]{1})message_die#si' => '\1$mx_acp->mx_message_die_acp',
					'#\$phpEx = [^;]*;#' => '',
					'#(include|require)(_once)?.*(pagestart|footer|header)(_admin)?[^;]*;#' => '',
					"#\\\$module_root_path = ['\\\"]([^']*)['\\\"];#" => '$module_root_path = "' . $mx_root_path . $module_root_path . '";',
					'#.*(\$HTTP_GET_VARS\[\'pane\'\] == \'right\')#si' => 'if ( 1==1',
					'#\$db->sql_close\(\);#si' => '',
					'#->assign_vars\([^(]*\(#si' => '\0 ' . "'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,'U_PORTAL_ROOT_PATH' => PORTAL_URL,",
					'#\$phpbb_root_path =[^;]*;#si' => '// \0 //<= has been allready defined $phpbb_root_path',
					'#require[^;]*;#si' => '// \0',
					'#\sexit;#si' => 'return;// exit;',

					);
				$preg_array = array_merge( $preg_array, array( // #
						"#([\n\t ](@?(include|require)\\(\\\$phpbb_root_path[^;]*;))#si" => '// \2 // <<== PHPBB2 INCLUDE',
						"#([\n\t ](@?(include|require)[^(lang)]*;))#si" => "\n" . '// \2 //<= has been allready defined INCLUDE',
						) );
				// PHPBB2 FUNCTIONS REPLACE
				$functions_ary = array( // #
					'get_userdata', 'phpbb_clean_username', phpbb_realpath
					);
				$preg_array = array_merge( $preg_array, array( // #
						'#(' . implode( '|', $functions_ary ) . ')\(#si' => 'phpBB2::\1(',
						) );
				// REPLACE FUNCTIONS that ARE ALLREADY DECLARED
				$func_cnt = preg_match_all( "#\nfunction ([^(]*)\\(#si", $script, $func_match );

				for( $i = 0; $i < $func_cnt; $i++ )
				{
					if ( function_exists( $func_match[1][$i] ) )
					{
						$preg_array = array_merge( $preg_array, array( // #
								"#" . $func_match[1][$i] . '([^)]*?\()#si' => "" . $func_match[1][$i] . '_dec_\1',
								) );
					}
				}

				$script = preg_replace( array_keys( $preg_array ), $preg_array, $script );
				$script = str_replace( 'phpBB2::phpBB2::', 'PHPBB2::', $script );
				break;
			case OLYMPUS_CATEGORY:
				$script = $this->phpbb3_hook->prepare_action_script( $this->panel );
				break;
		} // switch
		return $script;
	}

	function display()
	{
		global $template;

		$this->_template_assign_vars();
		$template->pparse( 'adm_header' );
		$template->pparse( 'adm_body' );
		$template->pparse( 'adm_footer' );
	}

	function _template_set_filenames()
	{
		global $template;

		$template->set_filenames( array( 'adm_header' => 'admin/mainpage_header.html',
				'adm_body' => 'admin/mainpage_body.html',
				'adm_footer' => 'admin/mainpage_footer.html',
				) );
	}

	function _convert_links( &$text, $match_links = array() )
	{
		global $phpEx, $mx_root_path;
		$match_count = count( $match_links['LINK'] );
		$values = array_keys( $this->menu_actions );
		$values_cnt = count( $values );
		$admin_path = substr( str_replace( dirname( realpath( $mx_root_path . 'index.' . $phpEx ) ) , '', dirname( __FILE__ ) ), 1 ) . '/';
		switch ( $this->category )
		{
			case MAIN_CATEGORY:
			case MODULE_CATEGORY:
			case PHPBB2X_CATEGORY:
			default:
				for( $i = 0; $i < $match_count; $i++ )
				{
					if ( eregi( 'javascript:', $match_links['LINK'][$i] ) || empty( $match_links['SCRIPT'][$i] ) || eregi( $mx_root_path . 'index.' . $phpEx, $match_links['LINK'][$i] ) || eregi( $admin_path . 'index.' . $phpEx, $match_links['LINK'][$i] ) )
					{
						continue;
					}
					if ( eregi( 'index.' . $phpEx, $match_links['LINK'][$i] ) )
					{
						$text = str_replace( $match_links['LINK'][$i], PORTAL_URL . $admin_path . $match_links['LINK'][$i], $text );
						continue;
					} // if END
					for( $j = 0; $j < $values_cnt; $j++ )
					{
						if ( strpos( $values[$j], $match_links['SCRIPT'][$i] ) !== false )
						{
							$text = str_replace( $match_links['LINK'][$i], PORTAL_URL . $admin_path . 'index.' . $phpEx . '?cat=' . $this->category . '&' . $this->menu_actions[$values[$j]] . '&' . $match_links['PARAMS'][$i], $text );
							break;
						} // if END
					} // for END
				} // for END
				break;
			case OLYMPUS_CATEGORY:
				$text = $this->phpbb3_hook->_convert_links( $text );
				/*print '<pre>';
				print htmlentities( $text);
				print '<hr/>';
				print_r( $match_links);
				//die( 'here');*/
				break;
		}
	}

	function mx_message_die_acp( $error_type, $message, $title = '', $line = '', $file = '', $sql = '' )
	{
		$match_count = preg_match_all( '#(href|action)="(((' . PORTAL_URL . '|' . PHPBB_URL . ')?((' . $mx_root_path . ')?(admin/|adm/)?([^"?]*)?))\??([^"]*?))"#si', $message, $match_links );
		$matched_links['LINK'] = $match_links[2];
		$matched_links['SCRIPT'] = $match_links[8];
		$matched_links['PARAMS'] = $match_links[9];
		$this->_convert_links( $message, $matched_links );
		if ( $error_type == GENERAL_INFO || $error_type == GENERAL_MESSAGE )
		{

			$this->assign_content_acp( '<div class="successbox">' . $message . '</div>' );
			$this->display();
			die();
		}
		else
		{
			mx_message_die( $error_type, $message, $title, $line, $file, $sql );
		}
	}

	function assign_content_acp( $acp_html )
	{
		global $mx_root_path, $phpbb_root_path, $phpEx, $template;

		$preg_pattern = $preg_replace = array();
		switch ( $this->category )
		{
			case MAIN_CATEGORY:
			case MODULE_CATEGORY:
			case PHPBB2X_CATEGORY:
			default:
				$match_count = preg_match_all( '#(href|action)="(((' . PORTAL_URL . '|' . PHPBB_URL . ')?((' . $mx_root_path . ')?(admin/|adm/)?([^"?]*)?))\??([^"]*?))"#si', $acp_html, $match_links );
				$menu_actions = $this->menu_actions;
				$matched_links['LINK'] = $match_links[2];
				$matched_links['SCRIPT'] = $match_links[8];
				$matched_links['PARAMS'] = $match_links[9];

				$this->_convert_links( $acp_html, $matched_links );
				break;
			case OLYMPUS_CATEGORY:
				$acp_html = $this->phpbb3_hook->assign_content_acp( $acp_html );
				// $acp_html = '<h1>' . $this->panel_title . '</h1><p>Panel: ' . $this->panel . '</p>' . $acp_html;
				break;
		} // switch
		$forms_cnt = preg_match_all( "#<form([^>]*)>#si", $acp_html, $forms );

		for( $f_i = 0; $f_i < $forms_cnt; $f_i++ )
		{
			$form_cnt = preg_match_all( "#([^=]*)=[\"']([^\"']*)[\"']#si", $forms[1][$f_i], $form );
			$form_action = '';
			$form_method = '';
			for( $i = 0; $i < $form_cnt; $i++ )
			{
				if ( strtolower( trim( $form[1][$i] ) ) == 'method' )
				{
					$form_method = strtoupper( $form[2][$i] );
				}
				else if ( strtolower( trim( $form[1][$i] ) ) == 'action' )
				{
					$form_action = $form[2][$i];
				}
			}
			$html_add = "\n";

			if ( $form_method == 'GET' )
			{
				$action = explode( '?', $form_action );
				$params = explode( '&', $action[1] );
				for( $i = 0; $i < count( $params ); $i++ )
				{
					$param = explode( '=', $params[$i] );
					$html_add .= '<input type="hidden" name="' . $param[0] . '" value="' . $param[1] . '" />' . "\n";
				}
			}
			$acp_html = str_replace( $forms[1][$f_i] . '>', $forms[1][$f_i] . '>' . $html_add, $acp_html );
		}

		$template->assign_var( 'CONTENT_ACP', $acp_html );
	}

	function _template_assign_vars()
	{
		global $board_config, $userdata, $lang, $mx_user, $admincp_nav_icon_url;
		global $theme, $images, $mx_starttime, $db, $phpEx, $template;

		$l_timezone = explode( '.', $board_config['board_timezone'] );
		$l_timezone = ( count( $l_timezone ) > 1 && $l_timezone[count( $l_timezone )-1] != 0 ) ? $lang[sprintf( '%.1f', $board_config['board_timezone'] )] : $lang[number_format( $board_config['board_timezone'] )];
		// Generate stats
		$endtime = explode( ' ', microtime() );
		$stime = ( $endtime[1] + $endtime[0] ) - $mx_starttime;
		$execution_stats = sprintf( $lang['Execution_Stats'], $db->num_queries, round( $stime, 4 ) );

		switch ( PORTAL_BACKEND )
		{
			case 'internal':
			case 'phpbb2':
				$current_phpbb_version = '2' . $board_config['version'];
				break;

			case 'phpbb3':
				$current_phpbb_version = $board_config['version'];
				break;
		}
		// isset( $mx_user->lang[$action_file_id] )?$mx_user->lang[$action_file_id]:( isset( $lang[$action_file_id] )?$lang[$action_file_id]:str_replace( '_' , ' ', $action_file_id ) )
		$global_vars = array(
			// +MOD: DHTML Menu for ACP
			'COOKIE_NAME' => $board_config['cookie_name'],
			'COOKIE_PATH' => $board_config['cookie_path'],
			'COOKIE_DOMAIN' => $board_config['cookie_domain'],
			'COOKIE_SECURE' => $board_config['cookie_secure'],
			'IMG_URL_CONTRACT' => $admincp_nav_icon_url . '/contract.gif',
			'IMG_URL_EXPAND' => $admincp_nav_icon_url . '/expand.gif',
			// -MOD: DHTML Menu for ACP
			'U_PORTAL_ROOT_PATH' => PORTAL_URL,
			'U_PHPBB_ROOT_PATH' => PHPBB_URL,
			'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,

			'T_PHPBB_STYLESHEET' => $theme['head_stylesheet'],
			'T_MXBB_STYLESHEET' => $theme['head_stylesheet'],
			'T_GECKO_STYLESHEET' => 'gecko.css',

			'MX_ICON_CSS' => $images['mx_graphics']['icon_style'],
			'LOGO' => !empty( $images['mx_logo_acp'] ) ? @$images['mx_logo_acp']: @$images['mx_logo'],

			"U_PORTAL_INDEX" => mx_append_sid( PORTAL_URL . basename( __FILE__ ) ),
			"U_FORUM_INDEX" => mx_append_sid( PHPBB_URL . "index.$phpEx" ),
			"U_PORTAL_ADMIN_INDEX" => mx_append_sid( basename( __FILE__ ) ),
			"U_ADMIN_INDEX" => mx_append_sid( basename( __FILE__ ) ),
			'U_LOGOUT' => mx_append_sid( PORTAL_URL . 'login.' . $phpEx . '?logout=1' ),

			'ADMIN_TITLE' => $lang['mxBB_adminCP'],

			'USERNAME' => $mx_user->data['username'],
			'CATEGORY' => $this->category,

			'L_LOGGED_IN_AS' => $lang['Logged_in_as'],
			"L_PORTAL_INDEX" => $lang['Portal_index'],
			"L_PREVIEW_PORTAL" => $lang['Preview_portal'],

			'L_LOGOUT' => @$lang['Log_out'],
			"L_FORUM_INDEX" => $lang['Main_index'],
			"L_ADMIN_INDEX" => $lang['Admin_Index'],
			"L_PREVIEW_FORUM" => $lang['Preview_forum'],
			'L_ADMIN_CATEGORY' => $this->category_title,
			'L_ADMIN_PART' => $this->panel_title,

			'ACTION_SCRIPT' => $this->action_script,

			'SITENAME' => $board_config['sitename'],

			'L_ADMIN' => $lang['Admin'],
			'L_INDEX' => sprintf( $lang['Forum_Index'], $board_config['sitename'] ),
			'L_FAQ' => $lang['FAQ'],
			'U_INDEX' => mx_append_sid( '../index.' . $phpEx ),

			'S_TIMEZONE' => sprintf( $lang['All_times'], $l_timezone ),
			'S_LOGIN_ACTION' => mx_append_sid( '../login.' . $phpEx ),
			'S_JUMPBOX_ACTION' => mx_append_sid( '../viewforum.' . $phpEx ),
			'S_CURRENT_TIME' =>
			( PORTAL_BACKEND == 'phpbb3' )?
			sprintf( $lang['Current_time'], phpBB2::create_date( $board_config['default_dateformat'], time(), $board_config['board_timezone'] ) ):
			sprintf( $lang['Current_time'], create_date( $board_config['default_dateformat'], time(), $board_config['board_timezone'] ) ),

			'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
			'S_CONTENT_ENCODING' => $lang['ENCODING'],
			'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
			'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
			'S_USER_LANG' => $mx_user->lang['default_lang'],

			'PHPBB_VERSION' => ( $userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS ) ? $current_phpbb_version : '',
			'MX_VERSION' => ( $userdata['user_level'] == ADMIN && $userdata['user_id'] != ANONYMOUS ) ? PORTAL_VERSION : '',
			'TRANSLATION_INFO' => ( isset( $lang['TRANSLATION_INFO'] ) ) ? $lang['TRANSLATION_INFO'] : ( ( isset( $lang['TRANSLATION'] ) ) ? $lang['TRANSLATION'] : '' ),
			'POWERED_BY' => $lang['Powered_by'],
			'EXECUTION_STATS' => $execution_stats
			);

		$template->assign_vars( $global_vars );
	}
}

$mx_acp = new mx_acp();
$mx_acp->decode_url( $HTTP_GET_VARS );

$mx_acp->assign_tabs();
$mx_acp->assign_menu();

$script = $mx_acp->prepare_action_script();

$i = 1;

// VERSION mx v2.8
// $script = str_replace( 'phpBB2::', '', $script);
// VERSION mxP v2.9
//$script = str_replace( 'mx_phpBB2::', 'phpBB2::', $script );

switch ( 0 )
{
	case 0:
		ob_start();
		eval( $script );
		$panel_html = ob_get_contents();
		ob_end_clean();
		break;
	case 1:
		$panel_html = preg_replace( array( "#\n#esi", "#\t#si" ), array( "sprintf('%4d', \$i++) . '\n'", '&nbsp;&nbsp;&nbsp;' ), str_replace( "\n", "<br/>\n", htmlentities( $script ) ) );
		break;
	case 2:
		ob_start();
		eval( $script );
		$panel_html = ob_get_contents();
		ob_end_clean();
		print_r( $HTTP_POST_VARS );
		$panel_html .= preg_replace( array( "#\n#esi", "#\t#si" ), array( "sprintf('%4d', \$i++) . '\n'", '&nbsp;&nbsp;&nbsp;' ), str_replace( "\n", "<br/>\n", htmlentities( $script ) ) );
		break;
	case 3:
		ob_start();
		eval( $script );
		$panel_html = ob_get_contents();
		ob_end_clean();
		$panel_html = preg_replace( array( "#\n#esi", "#\t#si" ), array( "sprintf('%4d', \$i++) . '\n'", '&nbsp;&nbsp;&nbsp;' ), str_replace( "\n", "<br/>\n", htmlentities( $panel_html ) ) );;
		break;
	case 4:
		eval( $script );
}

$mx_acp->assign_content_acp( $panel_html );
$mx_acp->display();
?>