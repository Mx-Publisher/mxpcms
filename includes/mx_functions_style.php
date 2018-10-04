<?php
/**
*
* @package Style
* @version $Id: mx_functions_style.php,v 1.93 2008/09/06 17:46:40 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

//
// Load session class, based on mxp backend
//
include_once($mx_root_path . 'includes/sessions/'.PORTAL_BACKEND.'/session.' . $phpEx);

/**
 * Sessions
 *
 * Abstract layer for Internal, phpBB2 or phpBB3 based session handling.
 *
 */
class mx_session extends session
{
	var $page_id = '';
	var $user_ip = '';

	/**
	 * Load sessions
	 *
	 * This is where all session activity begins.
	 * This method is a little ambigious, since we duplicate all session data in $userdata and $this-data,
	 * to make mxp work smoothly for different kinds of modules.
	 *
	 */
	function mx_session_begin()
	{
		global $userdata, $board_config, $portal_config, $cache, $_SID;

		//
		// Zero
		//
		$_SID = '';

		//
		// Load session
		//
		$this->load();

		//
		// Syncronize
		//
		$userdata = $this->data;
	}
}

//
// Include templating (XS style)
//
include_once($mx_root_path . 'includes/template.' . $phpEx);

/**
 * Class: mx_Template.
 *
 * The mx_Template class extends the native phpBB Template class, in reality only redefining the make_filename method.
 * Thus modded phpBB templates (eg eXtreme Styles MOD) will also be available for MX-Publisher.
 *
 * @package Style
 * @author Markus, Jon Ohlsson
 * @access public
 */
class mx_Template extends Template
{
	/**
	 * Constructor.
	 *
	 * Simply calling parent construtor.
	 * This is required. Reason is constructors have different method names.
	 *
	 * @access private
	 */
	function mx_Template($root = '.')
	{
		parent::Template($root);

		//
		// Temp solution when the rootdir is not created
		//
		if (empty($this->root))
		{
			$this->root = $root;
		}
	}

	var $module_template_path = '';

	/**
	 * make_filename.
	 *
	 * This make_filename implementation overrides parent method.
	 * Generates a full path+filename for the given filename, which can either
	 * be an absolute name, or a name relative to the rootdir for this Template
	 * object.
	 *
	 * @access public
	 */
	function make_filename($filename, $xs_include = false)
	{
		global $module_root_path, $mx_root_path, $phpbb_root_path, $theme, $mx_user, $mx_block;

		/*
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'phpbb2':
				$style_path = $theme['template_name'];
				break;
			case 'phpbb3':
				$style_path = $theme['style_name'];
				break;
		}
		*/
	
		if($this->subtemplates)
		{
			$filename = $this->subtemplates_make_filename($filename);
		}
		// Check replacements list
		if(!$xs_include && isset($this->replace[$filename]))
		{
			$filename = $this->replace[$filename];
		}
		
		$style_path = $mx_user->template_name;

		//
		// Also search for "the other" file extension
		//
		$filename2 = substr_count($filename, 'html') ? str_replace(".html", ".tpl", $filename) : str_replace(".tpl", ".html", $filename);
		
		//
		// Look at MX-Publisher-Module folder.........................................................................MX-Publisher-module
		//
		if (!empty($module_root_path))
		{
			$moduleDefault = !empty($mx_user->loaded_default_styles[$mx_block->module_root_path]) ? $mx_user->loaded_default_styles[$mx_block->module_root_path] : $mx_user->default_template_name;

			$this->debug_paths .= '<br>Module';
			$fileSearch = array();
			$fileSearch[] = $style_path; // First check current template
			$fileSearch[] = $mx_user->cloned_template_name; // Then check Cloned template
			$fileSearch[] = $moduleDefault; // Finally check Default template
			$fileSearch[] = './'; // Compatibility with primitive modules

			$temppath = $this->doFileSearch($fileSearch, $filename, $filename2, 'templates/', $module_root_path);
			if (!empty($this->module_template_path))
			{
				return $temppath;
			}
		}
		

		//
		// Look at MX-Publisher-Root folder.........................................................................MX-Publisher-Root
		//
		$this->debug_paths .= '<br>CORE';
		$fileSearch = array();
		$fileSearch[] = $style_path; // First check current template
		$fileSearch[] = $mx_user->cloned_template_name; // Then check Cloned template
		$fileSearch[] = $mx_user->default_template_name; // Then check Default template
		$fileSearch[] = './';

		$temppath = $this->doFileSearch($fileSearch, $filename, $filename2, 'templates/', $mx_root_path);
		if (!empty($this->module_template_path))
		{
			return $temppath;
		}

		//
		// Look at Custom Root folder..............this is used my mx_mod installers too.......this does not use standard templates folders wich are set when the template was re-initialized and defined as custom var
		//
		$this->debug_paths .= '<br>This';
		$fileSearch = array();
		$fileSearch[] = './';
		$fileSearch[] = $style_path; // First check current template
		$fileSearch[] = $mx_user->cloned_template_name; // Then check Cloned template
		$fileSearch[] = $mx_user->default_template_name; // Then check Default template

		$temppath = $this->doFileSearch($fileSearch, $filename, $filename2, $this->root, $mx_root_path);
		if (!empty($this->module_template_path))
		{
			return $temppath;
		}

		//
		// phpBB.........................................................................phpBB
		//
		switch (PORTAL_BACKEND)
		{
			//
			// Look at phpBB2-Root folder...
			//
			case 'internal':
			case 'phpbb2':
				$this->debug_paths .= '<br>phpbb2';
				$fileSearch = array();
				$fileSearch[] = $style_path; // First check current template
				$fileSearch[] = $mx_user->cloned_template_name; // Then check Cloned template
				$fileSearch[] = $mx_user->default_template_name; // Then check Default template
				$fileSearch[] = './';

				$temppath = $this->doFileSearch($fileSearch, $filename, $filename2, 'templates/', $phpbb_root_path, false);
				if (!empty($this->module_template_path))
				{
					return $temppath;
				}

				break;
			//
			// Look at phpBB3-Root folder...
			//
			case 'phpbb3':
				$this->debug_paths .= '<br>phpbb3';
				$fileSearch = array();
				$fileSearch[] = $style_path . '/' . 'template'; // First check current template
				$fileSearch[] = $mx_user->cloned_template_name . '/' . 'template'; // Then check Cloned template
				$fileSearch[] = $mx_user->default_template_name . '/' . 'template'; // Then check Default template
				$fileSearch[] = './';
				

				$temppath = $this->doFileSearch($fileSearch, $filename, $filename2, 'styles/', $phpbb_root_path, false);				

				if (!empty($this->module_template_path))
				{					
					if (!file_exists($root_path . $this->module_template_path . 'gecko.css'))
					{
						//Do not include phpBB3 overall header and footer files.
						$temppath = str_replace('overall_header', 'overall_header_plugin', $temppath);
						$temppath = str_replace('overall_footer', 'overall_footer_plugin', $temppath);				
					}					
					
					return $temppath;
				}

				//
				// This doesn't fit in...so left as is.
				//
				if( file_exists($phpbb_root_path . 'adm/style/' . $filename) )
				{
					//
					// First check  ACP template
					//
					$this->module_template_path = $phpbb_root_path . 'adm/style/';
					$temppath = $phpbb_root_path . 'adm/style/' . $filename;
				}

				if (!empty($this->module_template_path))
				{
					return $temppath;
				}

				break;
		}

		echo($this->debug_paths);
		die("Template->make_filename(): Error - file $filename does not exist. <br />Class-Root: $this->root <br />Module: $module_root_path <br />Current style: $style_path <br />Cloned style: $mx_user->cloned_template_name <br />Default style: $mx_user->default_template_name <br />Custom module default style: $moduleDefault");
	}
	

	/**
	 * Help function
	 *
	 * @param unknown_type $fileSearch
	 * @param unknown_type $filename
	 * @param unknown_type $filename2
	 * @param unknown_type $module_root_path
	 * @return unknown
	 */
	function doFileSearch($fileSearch, $filename, $filename2, $root, $root_path = '', $check_file2 = true)
	{
		$this->module_template_path = '';
		foreach ($fileSearch as $key => $path)
		{		
			if (!empty($path) && ($path !== './'))
			{
				$this->debug_paths .= '<br>' . $root_path . $root . $path . '/' . $filename;
				
				if( file_exists($root_path . $root . $path . '/' . $filename) )
				{								
					$this->module_template_path = $root . $path . '/';
					return $root_path . $root . $path . '/' . $filename;					
				}

				if ($check_file2 && file_exists($root_path . $root . $path . '/' . $filename2))
				{
					$this->module_template_path = $root . $path . '/';
					return $root_path . $root . $path . '/' . $filename2;
				}
			}
			else if ($path == './')
			{
				if( file_exists($root_path . $root . $filename) )
				{
					$this->module_template_path = $root;
					return $root_path . $root . $filename;
				}
				if ($check_file2)
				{
					if( file_exists($root_path . $root . $filename2) )
					{
						$this->module_template_path = $root;
						return $root_path . $root . $filename2;
					}
				}
			}
		}
	}

	/**
	* Set template location
	* phpBB3
	* @access public
	*/
	function set_template()
	{
		global $phpbb_root_path, $mx_root_path, $mx_user;

		if (file_exists($phpbb_root_path . 'styles/' . $mx_user->theme['template_path'] . '/template'))
		{
			$this->root = $phpbb_root_path . 'styles/' . $mx_user->theme['template_path'] . '/template';
			$this->cachepath = $phpbb_root_path . 'cache/tpl_' . $mx_user->theme['template_path'] . '_';
		}
		else
		{
			trigger_error('Template path could not be found: styles/' . $mx_user->theme['template_path'] . '/template', E_USER_ERROR);
		}

		$this->_rootref = &$this->_tpldata['.'][0];

		return true;
	}
	
	/**
	 * Assigns template filename for handle.
	 */
	function set_filename($handle, $filename, $xs_include = false, $quiet = false)
	{
		global $board_config, $module_root_path, $mx_root_path, $phpbb_root_path, $theme, $mx_user, $mx_block;
		$can_cache = $this->use_cache;
		if(strpos($filename, '..') !== false)
		{
			$can_cache = false;
		}
		$this->files[$handle] = $this->make_filename($filename, $xs_include);
		$this->files_cache[$handle] = '';
		$this->files_cache2[$handle] = '';
		// check if we are in admin control panel and override extreme styles mod controls if needed
		if(defined('XS_ADMIN_OVERRIDE') && XS_ADMIN_OVERRIDE === true && @function_exists('xs_admin_override'))
		{
			xs_admin_override();
		}
		// checking if we have valid filename
		if(!$this->files[$handle])
		{
			if($xs_include || $quiet)
			{
				return false;
			}
			else
			{
				die("Template->make_filename(): Error - invalid template $filename");
			}
		}
		
		//Do not include phpBB3 overall header and footer files using xs_include inside forum integration		
		if ($xs_include && defined('MX_PHPBB3_BLOCK') && $module_root_path)
		{
			if (strpos($this->files[$handle],'overall_header.'))
			{
				//$this->files[$handle] = str_replace('overall_header', 'overall_header_plugin', $this->files[$handle]);
				$filename2 = 'overall_header_plugin.html';
				$filename3 = 'index.htm';
				$this->debug_paths .= '<br>Module';
				$fileSearch = array();
				$fileSearch[] = $style_path; // First check current template
				$fileSearch[] = $mx_user->cloned_template_name; // Then check Cloned template
				$fileSearch[] = $moduleDefault; // Finally check Default template
				$fileSearch[] = './'; // Compatibility with primitive modules

				$this->files[$handle] = $this->doFileSearch($fileSearch, $filename3, $filename2, 'templates/', $module_root_path);	
			}
			
			if (strpos($this->files[$handle],'overall_footer.'))
			{
				$filename2 = 'overall_footer_plugin.html';
				$filename3 = 'index.htm';
				$this->debug_paths .= '<br>Module';
				$fileSearch = array();
				$fileSearch[] = $style_path; // First check current template
				$fileSearch[] = $mx_user->cloned_template_name; // Then check Cloned template
				$fileSearch[] = $moduleDefault; // Finally check Default template
				$fileSearch[] = './'; // Compatibility with primitive modules

				$this->files[$handle] = $this->doFileSearch($fileSearch, $filename3, $filename2, 'templates/', $module_root_path);												
			}
		}


		// creating cache filename
		if($can_cache != '')
		{
			$this->files_cache2[$handle] = $this->make_filename_cache($this->files[$handle]);
			if(@file_exists($this->files_cache2[$handle]))
			{
				$this->files_cache[$handle] = $this->files_cache2[$handle];
			}
		}
		// checking if tpl and/or php file exists
		if(empty($this->files_cache[$handle]) && !@file_exists($this->files[$handle]))
		{
			// trying to load alternative filename (usually subSilver)
			if(!empty($this->tpldef) && !empty($this->tpl) && ($this->tpldef !== $this->tpl))
			{
				$this->files[$handle] = '';
				// save old configuration
				$root = $this->root;
				$tpl_name = $this->tpl;
				// set temporary configuration
				$this->root = $this->tpldir . $this->tpldef;
				$this->tpl = $this->tpldef;
				// recursively run set_filename
				$res = $this->set_filename($handle, $filename, $xs_include, $quiet);
				// restore old configuration
				$this->root = $root;
				$this->tpl = $tpl_name;
				return $res;
			}
			if($quiet)
			{
				return false;
			}
			if($xs_include)
			{
				if($board_config['xs_warn_includes'])
				{
					die('Template->make_filename(): Error - included template file not found: ' . $filename);
				}
				return false;
			}
			else
			{
				die('Template->make_filename(): Error - template file not found: ' . $filename);
			}
		}
		// checking if we should recompile cache
		if(!empty($this->files_cache[$handle]) && !empty($board_config['xs_auto_recompile']))
		{
			$cache_time = @filemtime($this->files_cache[$handle]);
			if(@filemtime($this->files[$handle]) > $cache_time || $board_config['xs_template_time'] > $cache_time)
			{
				// file was changed. don't use cache file (will be recompled if configuration allowes it)
				$this->files_cache[$handle] = '';
			}
		}
		return true;
	}
}	// class mx_Template

/**#@+
 * mx_user class specific definitions
 *
 */
define('MX_LANG_MAIN'	, 10);
define('MX_LANG_ADMIN'	, 20);
define('MX_LANG_ALL'	, 30);
define('MX_LANG_NONE'	, 40);
define('MX_IMAGES'		, 50);
define('MX_IMAGES_NONE'	, 60);
define('MX_LANG_CUSTOM'	, 70);

define('MX_BUTTON_IMAGE'	, 10);
define('MX_BUTTON_TEXT'		, 20);
define('MX_BUTTON_GENERIC'	, 30);
/**#@-*/

/**
 * Class: mx_user.
 *
 * @package Style
 * @author Jon Ohlsson
 * @access public
 */
class mx_user extends mx_session
{
	//
	// Implementation Conventions:
	// Properties and methods prefixed with underscore are intented to be private. ;-)
	//

	// ------------------------------
	// Vars
	//
	/**#@+
	 * mx_user class specific vars
	 *
	 */
	var $loaded_langs = array();
	var $loaded_styles = array();
	var $loaded_default_styles = array();

	var $template_path = 'templates/';

	var $template_name = '';
	var $template_names = array();
	var $current_template_path = '';

	var $cloned_template_name = '';
	var $cloned_current_template_path = '';

	var $default_template_name = '_core';
	var $default_current_template_path = '';

	var $default_module_style = '';
	var $module_lang_path = array();

	var $is_admin = false;

	/**#@-*/

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
	 * Init session.
	 *
	 * Start session management (phpBB 2.0.x)
	 * - populate $userdata, $mx_user->data
	 *
	 * @access private
	 * @param unknown_type $user_ip
	 * @param unknown_type $page_id
	 */
	function _init_session()
	{
		$this->mx_session_begin();
		$this->is_admin = $this->data['user_level'] == ADMIN && $this->data['session_logged_in'];
	}

	/**
	 * Init userprefs.
	 *
	 * Initialise user settings on page load.
	 * - populate $lang, $theme, $images and initiate $template
	 *
	 * @access private
	 */
	function _init_userprefs()
	{
		global $userdata, $board_config, $portal_config, $theme, $images;
		global $template, $lang, $phpEx, $phpbb_root_path, $mx_root_path, $db;
		global $nav_links;

		//
		// Clean up and ensure we are using mxp internal lang format
		//
		$board_config['phpbb_lang'] = $board_config['default_lang']; // Handy switch
		$this->lang['default_lang'] = phpBB2::phpbb_ltrim(basename(phpBB2::phpbb_rtrim($this->decode_lang($board_config['default_lang']))), "'");
		$this->data['user_lang'] = phpBB2::phpbb_ltrim(basename(phpBB2::phpbb_rtrim($this->decode_lang($this->data['user_lang']))), "'");

		if ( $this->data['session_logged_in'] )
		{
			if ( !empty($this->data['user_lang']))
			{
				$this->lang['default_lang'] = $this->data['user_lang'];
			}

			if ( !empty($this->data['user_dateformat']) )
			{
				$board_config['default_dateformat'] = $this->data['user_dateformat'];
			}

			if ( isset($this->data['user_timezone']) )
			{
				$board_config['board_timezone'] = $this->data['user_timezone'];
			}
		}

		//
		// Now, $this->lang['default_lang'] is populated, but do we have a mathing MX-Publisher lang file installed?
		//
		if ( !file_exists(@phpBB2::phpbb_realpath($mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx)) )
		{
			//
			// If not, try english (desperate try)
			//
			$this->lang['default_lang'] = 'english';

			if ( !file_exists(@phpBB2::phpbb_realpath($mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not locate valid language pack: ' . $mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx);
			}
		}

		// If we've had to change the value in any way then let's write it back to the database
		// before we go any further since it means there is something wrong with it
		if ( $this->data['session_logged_in'] && $this->data['user_lang'] !== $this->lang['default_lang'] )
		{
			$sql = 'UPDATE ' . USERS_TABLE . "
				SET user_lang = '" . $this->encode_lang($this->lang['default_lang']) . "'
				WHERE user_lang = '" . $this->encode_lang($this->data['user_lang']) . "'";

			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not update user language info');
			}

			$this->data['user_lang'] = $this->lang['default_lang'];
		}
		elseif ( !$this->data['session_logged_in'] && $board_config['default_lang'] !== $this->lang['default_lang'] )
		{
			$sql = 'UPDATE ' . CONFIG_TABLE . "
				SET config_value = '" . $this->encode_lang($this->lang['default_lang']) . "'
				WHERE config_name = 'default_lang'";

			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not update user language info');
			}
		}

		//
		// Load MXP lang keys
		//
		
		//Load vanilla phpBB2 lang files if is possible
		switch (PORTAL_BACKEND)
		{
			case 'internal':

			case 'phpbb3':

				$shared_lang_path = $mx_root_path . 'includes/shared/phpbb2/language/';
				break;

			case 'phpbb2':

				$shared_lang_path = $phpbb_root_path . 'language/';
				break;
		}		

		// AdminCP
		if (defined('IN_ADMIN'))
		{
			// Core
			include($mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_admin.' . $phpEx);

			// Shared phpBB keys
			if ((@include $shared_lang_path . "lang_" . $this->lang['default_lang'] . "/lang_admin.$phpEx") === false)
			{
				if ((@include $shared_lang_path . "lang_english/lang_admin.$phpEx") === false)
				{
					mx_message_die(GENERAL_ERROR, 'Language file ' . $shared_lang_path . "lang_" . $this->lang['default_lang'] . "/lang_admin.$phpEx" . ' couldn\'t be opened.');
				}
			}
		}

		// Shared phpBB keys
		if ((@include $shared_lang_path . "lang_" . $this->lang['default_lang'] . "/lang_main.$phpEx") === false)
		{
			if ((@include $shared_lang_path . "lang_english/lang_main.$phpEx") === false)
			{
				mx_message_die(GENERAL_ERROR, 'Language file ' . $shared_lang_path . "lang_" . $this->lang['default_lang'] . "/lang_main.$phpEx" . ' couldn\'t be opened.');
			}
		}
		
		// Core Main Translation after shared phpBB keys so we can overwrite some settings
		require($mx_root_path . "language/lang_" . $this->lang['default_lang'] . "/lang_main.$phpEx");		

		//
		// Load backend specific lang defs.
		//
		$this->setup();

		//
		// Repopulate MXP vars
		//
		$board_config['default_lang'] = $this->lang['default_lang'];
		$userdata['user_lang'] = $this->data['user_lang'];

		//
		// Mozilla navigation bar
		// Default items that should be valid on all pages.
		// Defined here to correctly assign the Language Variables
		// and be able to change the variables within code.
		//
		$nav_links['top'] = array (
			'url' => mx_append_sid($phpbb_root_path . 'index.' . $phpEx),
			'title' => sprintf($lang['Forum_Index'], $board_config['sitename'])
		);
		$nav_links['search'] = array (
			'url' => mx_append_sid($phpbb_root_path . 'search.' . $phpEx),
			'title' => $lang['Search']
		);
		$nav_links['help'] = array (
			'url' => mx_append_sid($phpbb_root_path . 'faq.' . $phpEx),
			'title' => $lang['FAQ']
		);
		$nav_links['author'] = array (
			'url' => mx_append_sid($phpbb_root_path . 'memberlist.' . $phpEx),
			'title' => $lang['Memberlist']
		);
	}

	/**
	 * Init style.
	 *
	 * @access private
	 * @return unknown
	 */
	function _init_style()
	{
		global $userdata, $board_config, $portal_config, $theme, $images;
		global $template, $lang, $phpEx, $phpbb_root_path, $mx_root_path, $db;
		global $mx_page, $mx_request_vars;

		//
		// Build Portal style
		//
		$portal_config['default_admin_style'] = $portal_config['default_admin_style'] == -1 ? $board_config['default_style'] : $portal_config['default_admin_style'];
		$portal_config['default_style'] = $portal_config['default_style'] == -1 ? $board_config['default_style'] : $portal_config['default_style'];
		$portal_config['override_user_style'] = $portal_config['override_user_style'] == -1 ? $board_config['override_user_style'] : $portal_config['override_user_style'];

		if ( defined('IN_ADMIN') )
		{
			$init_style = $portal_config['default_admin_style'];
			$init_override = 1;
		}
		else if (isset($mx_page))
		{
			$init_style = $mx_page->default_style == -1 ? $portal_config['default_style'] : $mx_page->default_style;
			$init_override = intval($mx_page->override_user_style) == -1 ? $portal_config['override_user_style'] : $mx_page->override_user_style;
		}
		else
		{
			$init_style = $portal_config['default_style'];
			$init_override = $portal_config['override_user_style'];
		}

		if (!$init_style)
		{
			$init_style = 1;
			$init_override = 1;
		}

		//
		// Setup demo style
		//
		if ( isset($_GET['demo_theme']) || isset($_COOKIE['demo_theme']))
		{
				$style = isset($_GET['demo_theme']) ? intval($_GET['demo_theme']) : intval($_COOKIE['demo_theme']);
				if ( $theme = $this->_setup_style($style) )
				{
					setcookie('demo_theme', $style, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
					return;
				}
		}

		//
		// Setup style
		//
		if ( !$init_override )
		{
			if ( $this->data['user_id'] != ANONYMOUS && $this->data['user_style'] > 0 )
			{
				$style = $mx_request_vars->post('user_style', MX_TYPE_INT, $this->data['user_style']);
				if ( $theme = $this->_setup_style($style) )
				{
					return;
				}
			}
		}

		$style = $mx_request_vars->post('default_style', MX_TYPE_INT, $init_style);
		$theme = $this->_setup_style($style);

		return;
	}

	/**
	 * Setup style.
	 *
	 * @access private
	 * @param unknown_type $style
	 * @return unknown
	 */
	function _setup_style($style)
	{
		global $db, $board_config, $portal_config, $template, $phpbb_root_path, $mx_root_path, $theme;

		//
		// Get Style data.
		//
		switch (PORTAL_BACKEND)
		{
			case 'internal':
				$sql = "SELECT *
					FROM " . MX_THEMES_TABLE . "
					WHERE portal_backend = '" . PORTAL_BACKEND . "'
					AND themes_id = " . (int) $style;
			break;
			case 'phpbb2':
				$sql = "SELECT bbt.*
					FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " bbt
					WHERE mxt.template_name = bbt.template_name
					AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
					AND mxt.themes_id = " . (int) $style;
			break;				
			case 'phpbb3':
				$sql = "SELECT bbt.*, stt.*
					FROM " . MX_THEMES_TABLE . " mxt, " . STYLES_TABLE . " bbt, " . STYLES_TEMPLATE_TABLE . " stt
					WHERE mxt.template_name = stt.template_path
					AND bbt.style_id = stt.template_id
					AND mxt.portal_backend = '" . PORTAL_BACKEND . "' 					
					AND mxt.themes_id = " . (int) $style;			
			break;
		}

		if ( !($result = $db->sql_query($sql, 120)) )
		{
			mx_message_die(CRITICAL_ERROR, "Could not query database for theme info", '', __LINE__, __FILE__, $sql);
		}

		//
		// Use default style if custom style doesn't exist.
		//
		if ( !($row = $db->sql_fetchrow($result)) )
		{
			switch (PORTAL_BACKEND)
			{
				case 'internal':
					$sql = "SELECT *
						FROM " . MX_THEMES_TABLE . "
						WHERE portal_backend = '" . PORTAL_BACKEND . "'
						AND themes_id = " . (int) $style;
				break;
				case 'phpbb2':
					$sql = "SELECT bbt.*
						FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " bbt
						WHERE mxt.style_name = bbt.template_name
						AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
						AND bbt.themes_id = " . (int) $style;
				break;				
				case 'phpbb3':
				$sql = "SELECT bbt.*, stt.*
						FROM " . MX_THEMES_TABLE . " mxt, " . STYLES_TABLE . " bbt, " . STYLES_TEMPLATE_TABLE . " stt
						WHERE mxt.template_name = stt.template_path
						AND bbt.style_id = stt.template_id
						AND mxt.portal_backend = '" . PORTAL_BACKEND . "'				
						AND stt.template_path = " . (int) $style;			
				break;
			}

			if ( !($result = $db->sql_query($sql, 120)) )
			{
				mx_message_die(CRITICAL_ERROR, "Could not query database for theme info", '', __LINE__, __FILE__, $sql);
			}

			if ( !($row = $db->sql_fetchrow($result)) )
			{				
				$style = $portal_config['default_style'];

				switch (PORTAL_BACKEND)
				{
					case 'internal':
						$sql = "SELECT *
							FROM " . MX_THEMES_TABLE . "
							WHERE portal_backend = '" . PORTAL_BACKEND . "'
							AND themes_id = " . (int) $style;
						break;
					case 'phpbb2':
						$sql = "SELECT bbt.*
							FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " bbt
							WHERE mxt.style_name = bbt.style_name
							AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
							AND mxt.themes_id = " . (int) $style;
						break;
					case 'phpbb3':
						$sql = "SELECT bbt.*, stt.*
							FROM " . MX_THEMES_TABLE . " mxt, " . STYLES_TABLE . " bbt, " . STYLES_TEMPLATE_TABLE . " stt
							WHERE mxt.template_name = stt.template_path
							AND bbt.style_id = stt.template_id
							AND mxt.portal_backend = '" . PORTAL_BACKEND . "'				
							AND mxt.themes_id = " . (int) $style;
						break;
				}

				if ( !($result = $db->sql_query($sql, 120)) )
				{
					mx_message_die(CRITICAL_ERROR, 'Could not query database for theme info');
				}

				//
				// Last desperate try...
				//
				if ( !($row = $db->sql_fetchrow($result)) )
				{
					switch (PORTAL_BACKEND)
					{
						case 'internal':
							$sql = 'SELECT *
								FROM ' . MX_THEMES_TABLE;
							break;
						case 'phpbb2':
							$sql = 'SELECT *
								FROM ' . THEMES_TABLE;
							break;
						case 'phpbb3':
							$sql = "SELECT bbt.*, stt.*
									FROM " . MX_THEMES_TABLE . " mxt, " . STYLES_TABLE . " bbt, " . STYLES_TEMPLATE_TABLE . " stt
									WHERE mxt.template_name = stt.template_path
									AND bbt.style_id = stt.template_id";
							break;
					}

					if ( !($result = $db->sql_query_limit($sql, 1)) )
					{
						mx_message_die(CRITICAL_ERROR, 'Could not query database for theme info');
					}

					if ( !($row = $db->sql_fetchrow($result)) )
					{
						mx_message_die(CRITICAL_ERROR, "Could not get MX-Publisher style data for themes_id [$style]");
					}
				}
			}				
		}

		$db->sql_freeresult($result);

		//
		// Init class settings
		//
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'phpbb2':
				$this->template_name = $row['template_name'];
				$style = $row['themes_id'];
				break;
			case 'phpbb3':
				$this->template_name = $row['template_path'];
				$style = $row['style_id'];
				break;
		}

		$this->current_template_path = $this->template_path . $this->template_name;
		$this->default_current_template_path = $this->template_path . $this->default_template_name;
		$this->style = $style;

		//
		// Load template settings
		// - pass cloned template name to $theme
		//
		$template_config_row = $this->_load_template_config();

		$row['template_copy'] = $template_config_row['template_copy'];
		$row['cloned_template_name'] = $template_config_row['cloned_template'];
		$row['border_graphics'] = $template_config_row['border_graphics'];

		switch (PORTAL_BACKEND)
		{
			case 'internal':
				foreach($template_config_row as $key => $value)
				{
					$row[$key] = $value;
				}
				break;
			case 'phpbb3':
				$row['style_copy'] = $template_config_row['template_copy'];
				$row['head_stylesheet'] = $row['template_path'] . '.css';
				break;
		}

		$this->cloned_template_name = $row['cloned_template_name'];
		$this->cloned_current_template_path = !empty($this->cloned_template_name) ? $this->template_path . $this->cloned_template_name : '';

		//
		// Load images
		//
		$this->_load_phpbb_images();
		$this->_load_mxbb_images();

		//
		// What template to use?
		//
		$template = new mx_Template($mx_root_path . $this->template_path . $this->template_name);

		define('TEMPLATE_ROOT_PATH', $this->template_path . $this->template_name . '/');

		//
		// Get missing theme colors from *.cfg file (sort of desperate fix)
		//
		foreach($row as $key => $value)
		{
			if(empty($value) && !empty($theme[$key]))
			{
				$row[$key] = $theme[$key];
			}
		}

		//
		// Load backend specific style defs.
		//
		$this->setup_style();

		return $row;
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @return unknown
	 */
	function _load_template_config()
	{
		global $board_config, $template, $phpbb_root_path, $mx_root_path;

		$mx_template_config = false;

		//
		// Load MX-Publisher Template configuration data
		//
		@include($mx_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg');		

		
		/* Removed since in 3.0.x+ our default template is no style
		if ( !$mx_template_config )
		{
			//
			// Since we have no Template Config file, use default instead
			//
			@include($mx_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg');

			//
			// Make default template -> current template
			//
			$this->template_name = $this->default_template_name;
			$this->current_template_path = $this->default_current_template_path;

		}
		*/

		if ( !$mx_template_config )
		{
			mx_message_die(CRITICAL_ERROR, "Could not open MX-Publisher $this->template_name template config file", '', __LINE__, __FILE__);
		}

		//
		// Is this a cloned temmplate - defined by main *.cfg?
		//
		$template_config_row['cloned_template'] = trim(htmlspecialchars($mx_template_settings['cloned_template']));
		$template_config_row['border_graphics'] = $mx_template_settings['border_graphics'];
		$template_config_row['template_copy'] = $mx_template_settings['template_copy'];

		return $template_config_row;
	}

	/**
	 * Enter description here...
	 * @access private
	 */
	function _load_phpbb_images()
	{
		global $images, $board_config, $template, $phpbb_root_path, $mx_root_path;

		unset($GLOBALS['TEMPLATE_CONFIG']);

		switch (PORTAL_BACKEND)
		{
			case 'internal':
				define(TEMPLATE_CONFIG, TRUE);
				break;
			case 'phpbb2':
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

				break;
			case 'phpbb3':

				// Here we overwrite phpBB images from the template configuration file with images from database

				$images['icon_quote'] =  $this->images('icon_quote');
				$images['icon_edit'] = $this->images('icon_edit');
				$images['icon_search'] = $this->images('icon_search');
				$images['icon_profile'] = $this->images('icon_profile');
				$images['icon_pm'] = $this->images('icon_pm');
				$images['icon_email'] = $this->images('icon_email');
				$images['icon_delpost'] = $this->images('icon_delpost');
				$images['icon_ip'] = $this->images('icon_ip');
				$images['icon_www'] = $this->images('icon_www');
				$images['icon_icq'] = $this->images('icon_icq');
				$images['icon_aim'] = $this->images('icon_aim');
				$images['icon_yim'] = $this->images('icon_yim');
				$images['icon_msnm'] = $this->images('icon_msnm');
				$images['icon_minipost'] = $this->images('icon_minipost');
				$images['icon_gotopost'] = $this->images('icon_gotopost');
				$images['icon_minipost_new'] = $this->images('icon_minipost_new');
				$images['icon_latest_reply'] = $images['icon_topic_latest'] = $this->images('icon_topic_latest');
				$images['icon_newest_reply'] = $this->images('icon_newest_reply');

				$images['forum'] = $this->images('forum');
				$images['forums'] = $this->images('forums');
				$images['forum_new'] = $this->images('forum_new');
				$images['forum_locked'] = $this->images('forum_locked');

				$images['folder'] = $images['topic_read'] = $this->images('topic_read');
				$images['folder_new'] = $images['topic_unread'] = $this->images('topic_unread');
				$images['folder_hot'] = $images['topic_hot'] = $this->images('topic_hot');
				$images['folder_hot_new'] = $images['topic_hot_unread'] = $this->images('topic_hot_unread');
				$images['folder_locked'] = $images['topic_locked'] = $this->images('topic_locked');
				$images['folder_locked_new'] = $images['topic_locked_unread'] = $this->images('topic_locked_unread');
				$images['folder_sticky'] = $images['topic_sticky'] = $this->images('topic_sticky');
				$images['folder_sticky_new'] = $images['topic_sticky_unread'] = $this->images('topic_sticky_unread');
				$images['folder_announce'] = $images['topic_announce'] = $this->images('topic_announce');
				$images['folder_announce_new'] = $images['topic_announce_unread'] = $this->images('topic_announce_unread');

				$images['post_new'] = $this->images('post_new');
				$images['post_locked'] = $this->images('post_locked');
				$images['reply_new'] = $this->images('reply_new');
				$images['reply_locked'] = $this->images('reply_locked');

				$images['pm_inbox'] = $this->images('pm_inbox');
				$images['pm_outbox'] = $this->images('pm_outbox');
				$images['pm_savebox'] = $this->images('pm_savebox');
				$images['pm_sentbox'] = $this->images('pm_sentbox');
				$images['pm_readmsg'] = $this->images('pm_readmsg');
				$images['pm_unreadmsg'] = $this->images('pm_unreadmsg');
				$images['pm_replymsg'] = $this->images('pm_replymsg');
				$images['pm_postmsg'] = $this->images('pm_postmsg');
				$images['pm_quotemsg'] = $this->images('pm_quotemsg');
				$images['pm_editmsg'] = $this->images('pm_editmsg');
				$images['pm_new_msg'] = $this->images('pm_new_msg');
				$images['pm_no_new_msg'] = $this->images('pm_no_new_msg');

				$images['Topic_watch'] = $this->images('Topic_watch');
				$images['topic_un_watch'] = $this->images('topic_un_watch');
				$images['topic_mod_lock'] = $this->images('topic_mod_lock');
				$images['topic_mod_unlock'] = $this->images('topic_mod_unlock');
				$images['topic_mod_split'] = $this->images('topic_mod_split');
				$images['topic_mod_move'] = $this->images('topic_mod_move');
				$images['topic_mod_delete'] = $this->images('topic_mod_delete');

				$images['voting_graphic'] = $this->images('voting_graphic');

				define('TEMPLATE_CONFIG', TRUE);

				break;
		}

		//
		// We have no template to use - die
		//
		if ( !defined('TEMPLATE_CONFIG') )
		{
			mx_message_die(CRITICAL_ERROR, "Could not open phpBB $this->template_name template config file", '', __LINE__, __FILE__);
		}

		$img_lang = ( file_exists($phpbb_root_path . $this->current_template_path . '/images/lang_' . $this->encode_lang($this->lang['default_lang'])) ) ? $this->encode_lang($this->lang['default_lang']) : 'english';

		//
		// Import phpBB Graphics, prefix with PHPBB_URL, and apply LANG info
		//
		while( list($key, $value) = @each($images) )
		{
			if (is_array($value))
			{
				foreach( $value as $key2 => $val2 )
				{
					$images[$key][$key2] = PHPBB_URL . $val2;
				}
			}
			else
			{
				$images[$key] = str_replace('{LANG}', 'lang_' . $img_lang, $value);
				$images[$key] = PHPBB_URL . $images[$key];
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $module_root_path
	 */
	function _load_mxbb_images($module_root_path = '')
	{
		global $images, $board_config, $template, $phpbb_root_path, $mx_root_path, $theme, $current_module_images;
		global $mx_block, $mx_user;

		//unset($GLOBALS['MX_TEMPLATE_CONFIG']);
		$mx_template_config = false;

		//
		// Load module cfg
		//
		$moduleCfgFile = str_replace('/', '', str_replace('modules/', '', $mx_block->module_root_path));

		//
		// Load MX-Publisher Template configuration data
		// - First try current template
		//
		$current_template_path = $module_root_path . $this->current_template_path;
		$cloned_template_path = $module_root_path . $this->cloned_current_template_path;
		$default_template_path = $module_root_path . $this->default_current_template_path;
		$template_name = $this->template_name;

		@include($mx_root_path . $module_root_path . $this->current_template_path . '/' . $template_name . '.cfg');
		if (!$mx_template_config)
		{
			@include($mx_root_path . $module_root_path . $this->current_template_path . '/' . $moduleCfgFile . '.cfg');
		}

		//
		// Since we have no current Template Config file, try the cloned template instead
		//
		if (!$mx_template_config)
		{
			$current_template_path = $module_root_path . $this->cloned_current_template_path;
			$template_name = $this->cloned_template_name;

			@include($mx_root_path . $module_root_path . $this->cloned_current_template_path . '/' . $template_name . '.cfg');
			if (!$mx_template_config)
			{
				@include($mx_root_path . $module_root_path . $this->cloned_current_template_path . '/' . $moduleCfgFile . '.cfg');
			}
		}

		//
		// If use default template intead
		//
		if (!$mx_template_config)
		{
			$current_template_path = $module_root_path . $this->default_current_template_path;
			$template_name = $this->default_template_name;

			@include($mx_root_path . $module_root_path . $this->default_current_template_path . '/' . $template_name . '.cfg');
			if (!$mx_template_config)
			{
				@include($mx_root_path . $module_root_path . $this->default_current_template_path . '/' . $moduleCfgFile . '.cfg');
			}
		}

		//
		// We have no template to use - die
		//
		if (!$mx_template_config)
		{
			mx_message_die(CRITICAL_ERROR, "Could not open " . $mx_root_path . $module_root_path . $this->default_current_template_path . " style config file", '', __LINE__, __FILE__);
		}

		$img_lang = ( file_exists($mx_root_path . $current_template_path . '/images/lang_' . $board_config['default_lang']) ) ? $board_config['default_lang'] : 'english';

		while( list($key, $value) = @each($mx_images) )
		{
			if (is_array($value))
			{
				foreach( $value as $key2 => $val2 )
				{
					$images[$key][$key2] = $val2;
				}
			}
			else
			{
				$images[$key] = str_replace('{LANG}', 'lang_' . $img_lang, $value);
			}
		}

		//
		// What template is the module using?
		//
		$module_key = !empty($module_root_path) ? $module_root_path : 'core';
		$this->template_names[$module_key] = $template_name;

		unset($mx_images);
	}

	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $lang_mode
	 */
	function _load_module_lang($lang_mode = MX_LANG_MAIN)
	{
		global $lang, $board_config, $mx_block, $phpEx, $mx_root_path;

		$default_lang = ($this->lang['default_lang']) ? $this->encode_lang($this->lang['default_lang']) : $board_config['default_lang'];

		if (empty($default_lang))
		{
			// - populate $default_lang
			$default_lang= 'english';
		}

		if (!isset($this->loaded_langs[$mx_block->module_root_path]))
		{
			if ($lang_mode == MX_LANG_MAIN || $lang_mode == MX_LANG_ALL)
			{
				if (!empty($this->module_lang_path[$mx_block->module_root_path]))
				{
					$module_lang_path = $this->module_lang_path[$mx_block->module_root_path];
				}
				else
				{
					$module_lang_path = $mx_root_path . $mx_block->module_root_path;
				}

				// -------------------------------------------------------------------------
				// Read Module Main Language Definition
				// -------------------------------------------------------------------------
				if ((@include $module_lang_path . "language/lang_" . $default_lang . "/lang_main.$phpEx") === false)
				{
					if ((@include $module_lang_path . "language/lang_english/lang_main.$phpEx") === false)
					{
							mx_message_die(CRITICAL_ERROR, 'Module main language file ' . $mx_root_path . $module_lang_path . "language/lang_" . $default_lang . "/lang_main.$phpEx" . ' couldn\'t be opened.');
					}
				}
			}

			if ($lang_mode == MX_LANG_ADMIN || $lang_mode == MX_LANG_ALL)
			{
				// -------------------------------------------------------------------------
				// Read Module Admin Language Definition
				// -------------------------------------------------------------------------
				if ((@include $module_lang_path . "language/lang_" . $default_lang . "/lang_admin.$phpEx") === false)
				{
					if ((@include $module_lang_path . "language/lang_english/lang_admin.$phpEx") === false)
					{
							mx_message_die(CRITICAL_ERROR, 'Modiule admin language file ' . $mx_root_path . $module_lang_path . "language/lang_" . $default_lang . "/lang_admin.$phpEx" . ' couldn\'t be opened.');
					}
				}
			}
			$this->loaded_langs[$mx_block->module_root_path] = '1';
		}
	}

	/**
	 * Enter description here...
	 * @access private
	 */
	function _load_module_style()
	{
		global $mx_block, $phpEx;

		if (!isset($this->loaded_styles[$mx_block->module_root_path]))
		{
			// -------------------------------------------------------------------------
			// Read Module Style Definition
			// -------------------------------------------------------------------------
			$this->_load_mxbb_images($mx_block->module_root_path);

			$this->loaded_styles[$mx_block->module_root_path] = '1';
			$this->loaded_default_styles[$mx_block->module_root_path] = $this->default_module_style;
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

	// ------------------------------
	// Public Methods
	//

	/**
	 * Init user class.
	 * Populate $userdata, $lang
	 *
	 * @access public
	 * @param unknown_type $user_ip
	 * @param unknown_type $page_id
	 */
	function init( $user_ip, $page_id, $init_style = true )
	{
		//
		// Define basic constants
		//
		$this->page_id = $page_id;
		$this->user_ip = $user_ip;

		//
		// Inititate User data
		//
		$this->_init_session($user_ip, $this->page_id);
		$this->_init_userprefs();

		//
		// Inititate User style
		//
		if ( $init_style )
		{
			$this->_init_style();
		}
	}

	/**
	 * Init user style.
	 * Populate $template, $theme, $images
	 *
	 * @access public
	 * @param unknown_type $user_ip
	 * @param unknown_type $thispage_id
	 */
	function init_style()
	{
		//
		// The User class must first be initiated.
		//
		if (empty($this->page_id))
		{
			die('Bad initialization method of the User Class!');
		}

		//
		// Inititate User style
		//
		$this->_init_style();
	}

	/**
	 * Extend.
	 *
	 * Extend User Style with module lang and images.
	 *
	 * Usage:
	 * - $mx_user->extend(LANG, IMAGES)
	 *
	 * Switches:
	 * - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL
	 * - IMAGES: MX_IMAGES (default), MX_NO_IMAGES
	 *
	 * @access public
	 * @param unknown_type $lang_mode
	 * @param unknown_type $image_mode
	 */
	function extend($lang_mode = MX_LANG_MAIN, $image_mode = MX_IMAGES)
	{
		global $mx_block;

		if (defined('IN_ADMIN'))
		{
			return;
		}

		if (!empty($this->loaded_default_styles[$mx_block->module_root_path]))
		{
			$this->default_module_style = $this->loaded_default_styles[$mx_block->module_root_path];
			$this->default_template_name = $this->default_module_style;
			$this->default_current_template_path = 'templates/' . $this->default_template_name;
		}

		if ($lang_mode != MX_LANG_NONE)
		{
			$this->_load_module_lang($lang_mode);
		}

		if ($image_mode != MX_IMAGES_NONE)
		{
			$this->_load_module_style();
		}

		//
		// Reset custom module default style, once used.
		//
		if (!empty($this->default_module_style))
		{
			$this->default_template_name = '_core';
			$this->default_current_template_path = 'templates/' . $this->default_template_name;
			$this->default_module_style = '';
		}
	}

	function set_module_default_style($default_module_style = '')
	{
		global $mx_block;

			$this->loaded_default_styles[$mx_block->module_root_path] = $default_module_style;
	}

	function set_module_lang_path($module_lang_path = '')
	{
		global $mx_block;

		$this->module_lang_path[$mx_block->module_root_path] = $module_lang_path;
	}

	/**
	 * Create buttons.
	 *
	 * You can create code for buttons:
	 * 1) Simple textlinks (MX_BUTTON_TEXT)
	 * 2) Standard image links (MX_BUTTON_IMAGE)
	 * 3) Generic buttons, with spanning text on top background image (MX_BUTTON_GENERIC)
	 *
	 * Note: The rollover feature is done using a css shift technique, so you do not need separate images
	 *
	 * @param unknown_type $type
	 * @param unknown_type $label
	 * @param unknown_type $url
	 * @param unknown_type $img
	 */
	function create_button($key, $label, $url)
	{
		global $images;

		switch($images['buttontype'][$key])
		{
			case MX_BUTTON_TEXT:
				return '<a class="textbutton" href="'. $url .'"><span>' . $label . '</span></a>';
				break;

			case MX_BUTTON_IMAGE:
				return '<a class="imagebutton" href="'. $url .'"><img src = "' . $images[$key] . '" alt="' . $label . '" title="' . $label . '" border="0"></a>';
				break;

			case MX_BUTTON_GENERIC:
				return '<a class="genericbutton" href="'. $url .'"><span>' . $label . '</span></a>';
				break;

			default:
				return '<a class="imagebutton" href="'. $url .'"><img src = "' . $images[$key] . '" alt="' . $label . '" title="' . $label . '" border="0"></a>';
				break;
		}
	}

	/**
	 * Create icons.
	 *
	 * You can create code for icons:
	 * 1) Simple textlinks (MX_BUTTON_TEXT)
	 * 2) Standard image links (MX_BUTTON_IMAGE)
	 * 3) Generic buttons, with spanning text on top background image (MX_BUTTON_GENERIC)
	 *
	 * Note: The rollover feature is done using a css shift technique, so you do not need separate images
	 *
	 * @param unknown_type $type
	 * @param unknown_type $label
	 * @param unknown_type $url
	 * @param unknown_type $img
	 */
	function create_icon($key, $label, $url)
	{
		global $images;

		switch($images['buttontype'][$key])
		{
			case MX_BUTTON_TEXT:
				return '<a class="textbutton" href="'. $url .'"><span>' . $label . '</span></a>';
				break;

			case MX_BUTTON_IMAGE:
				return '<a class="imagebutton" href="'. $url .'"><img src = "' . $images[$key] . '" alt="' . $label . '" title="' . $label . '" border="0"></a>';
				break;

			case MX_BUTTON_GENERIC:
				return '<a class="genericbutton" href="'. $url .'"><span>' . $label . '</span></a>';
				break;

			default:
				return '<a class="imagebutton" href="'. $url .'"><img src = "' . $images[$key] . '" alt="' . $label . '" title="' . $label . '" border="0"></a>';
				break;
		}
	}

}	// class mx_user
?>