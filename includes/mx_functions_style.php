<?php
/**
*
* @package Style
* @version $Id: mx_functions_style.php,v 1.144 2014/07/10 01:04:52 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined('IN_PORTAL'))
{
	die("Hacking attempt");
}

/*
* Load session class, based on mxp backend
**/
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
		
		// Zero
		$_SID = '';
		
		// Load session
		$this->load();
		
		// Syncronize
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

		// ?
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

		// Also search for "the other" file extension
		$filename2 = substr_count($filename, 'html') ? str_replace(".html", ".tpl", $filename) : str_replace(".tpl", ".html", $filename);

		//
		// Look at MX-Publisher-Module folder.........................................................................MX-Publisher-module
		//
		if (!empty($module_root_path))
		{		
			if (isset($mx_block->module_root_path))
			{		
				$moduleDefault = !empty($mx_user->loaded_default_styles[$mx_block->module_root_path]) ? $mx_user->loaded_default_styles[$mx_block->module_root_path] : $mx_user->default_template_name;
			}
			else
			{		
				$moduleDefault = !empty($mx_user->loaded_default_styles[$module_root_path]) ? $mx_user->loaded_default_styles[$module_root_path] : $mx_user->default_template_name;
			}			
			
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
			// Look at phpBB2-Root folder...
			case 'internal':
			case 'smf2':
			case 'mybb':
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
			// Look at phpBB3-Root folder...
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':			
				$this->debug_paths .= '<br>phpbb3';
				$fileSearch = array();
				$fileSearch[] = $style_path . '/' . 'template'; // First check current template
				$fileSearch[] = $mx_user->cloned_template_name . '/' . 'template'; // Then check Cloned template
				$fileSearch[] = $mx_user->default_template_name . '/' . 'template'; // Then check Default template
				$fileSearch[] = './';
				$temppath = $this->doFileSearch($fileSearch, $filename, $filename2, 'styles/', $phpbb_root_path, false);
				/*
				if (!empty($this->module_template_path))
				{
					// for mx_phpbb3
					if (!file_exists($mx_root_path . $this->module_template_path . 'gecko.css'))
					{
						//Do not include phpBB3 overall header and footer files.
						$temppath = str_replace('overall_header', 'overall_header_plugin', $temppath);
						$temppath = str_replace('overall_footer', 'overall_footer_plugin', $temppath);
					}
					return $temppath;
				}
				*/
				/*
				// MOVED FROM HERE TO SET_FILENAME(), NEED TO BE MERGED APPROPRIATELY.
				// For mx_phpbb3
				//
				// Do not include phpBB3 overall header and footer files using xs_include inside forum integration
				// Does this code need to be here?
				//
				if ($xs_include && @defined('MX_PHPBB3_BLOCK') && $module_root_path)
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
				*/
				
				/*
				* This doesn't fit in...so left as is.
				*/
				if(@file_exists($phpbb_root_path . 'adm/style/' . $filename) )
				{
					/*
					* First check  ACP template
					*/
					$this->module_template_path = $phpbb_root_path . 'adm/style/';
					$temppath = $phpbb_root_path . 'adm/style/' . $filename;
				}

				if (!empty($this->module_template_path))
				{
					return $temppath;
				}
				
			break;
			case 'rhea':			
				$this->debug_paths .= '<br>phpbb4';
				$fileSearch = array();
				$fileSearch[] = $style_path . '/' . 'template'; // First check current template
				$fileSearch[] = $mx_user->cloned_template_name . '/' . 'template'; // Then check Cloned template
				$fileSearch[] = $mx_user->default_template_name . '/' . 'template'; // Then check Default template
				$fileSearch[] = './';
				$temppath = $this->doFileSearch($fileSearch, $filename, $filename2, 'styles/', $phpbb_root_path, false);
				
				/*
				* This doesn't fit in...so left as is.
				*/
				if(@file_exists($phpbb_root_path . 'adm/style/' . $filename) )
				{
					/*
					* First check  ACP template
					*/
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
	 * Assigns template filename for handle.
	 *
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
		if (!empty($this->module_template_path))
		{
			// for mx_phpbb3
			if (!file_exists($mx_root_path . $this->module_template_path . 'gecko.css'))
			{
				//Do not include phpBB3 overall header and footer files.
				$temppath = str_replace('overall_header', 'overall_header_navigation_phpbb', $temppath);
				$temppath = str_replace('overall_footer', 'overall_footer_navigation_phpbb', $temppath);
			}
				//return $temppath;
		}
		
		//Do not include phpBB3 overall header and footer files using xs_include inside forum integration		
		if ($xs_include && @defined('MX_PHPBB3_BLOCK') && $module_root_path)
		{
			if (strpos($this->files[$handle],'overall_header.'))
			{
				//$this->files[$handle] = str_replace('overall_header', 'overall_header_plugin', $this->files[$handle]);
				$filename2 = 'overall_header_navigation_phpbb.html';
				$filename3 = 'index.htm';
				$this->debug_paths .= '<br>Module';
				$fileSearch = array();
				$fileSearch[] = $style_path; // First check current template
				$fileSearch[] = $mx_user->cloned_template_name; // Then check Cloned template
				$fileSearch[] = $moduleDefault; // Finally check Default template
				//$fileSearch[] = $mx_root_path . 'modules/mx_phpbb3/'; // Compatibility with primitive modules				
				$fileSearch[] = './'; // Compatibility with primitive modules

				$this->files[$handle] = $this->doFileSearch($fileSearch, $filename3, $filename2, 'templates/', $module_root_path);	
			}			
			
			if (strpos($this->files[$handle],'overall_footer.'))
			{
				$filename2 = 'overall_header_navigation_phpbb.html';
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
		//
		// This doesn't fit in...so left as is.
		//
		if(@file_exists($phpbb_root_path . 'adm/style/' . $filename) )
		{
			//
			// First check  ACP template
			//
			$this->module_template_path = $phpbb_root_path . 'adm/style/';
			$temppath = $phpbb_root_path . 'adm/style/' . $filename;
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
	*/

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

				if ($check_file2 && @file_exists($root_path . $root . $path . '/' . $filename2))
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
			print_r('Template path could not be found: styles/' . $mx_user->theme['template_path'] . '/template', E_USER_ERROR);
		}

		$this->_rootref = &$this->_tpldata['.'][0];

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
	var $theme = array(); 
	var $template_name = '';
	var $template_names = array();
	var $current_template_path = '';
	
	var $cloned_template_name = '';
	var $cloned_current_template_path = '';
	var $current_template_phpbb_path = '';
	var	$current_template_phpbb_images = '';
	
	var $default_template_name = '_core';
	var $default_current_template_path = '';

	var $style_name = '';	
	var $style_path = 'styles/';	
	
	var $cloned_style_phpbb_path = '';
	var $current_style_phpbb_path = '';
	
	var $default_style_name = 'prosilver';
	var $default_style2_name = 'subsilver2';	
	var $default_style_phpbb_path = '';	
	
	var $default_module_style = '';
	var $module_lang_path = array();

	var $is_admin = false;
	var $keyoptions = false;

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
		// Clean up and ensure we are using mxp internal (long) lang format
		//
		$board_config['phpbb_lang'] = $board_config['default_lang']; // Handy switch
		$this->lang['default_lang'] = phpBB2::phpbb_ltrim(basename(phpBB2::phpbb_rtrim($this->decode_lang($board_config['default_lang']))), "'");
		$this->data['user_lang'] = phpBB2::phpbb_ltrim(basename(phpBB2::phpbb_rtrim($this->decode_lang($this->data['user_lang']))), "'");

		//if ( $this->data['session_logged_in'] ) // Old code
		if ( $this->data['user_id'] != ANONYMOUS )
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
		//Enable URL Language Detection
		if (isset($_GET['lang']))
		{
			$this->lang['default_lang'] = ((file_exists($mx_root_path . 'language/lang_' . $this->decode_lang(strval(phpBB3::request_var('lang', ''))) . "/lang_main.$phpEx")) ? strval(phpBB3::request_var('lang', '')) : ((file_exists($mx_root_path . 'language/lang_' . strval(phpBB3::request_var('lang', '')) . "/lang_main.$phpEx")) ? strval(phpBB3::request_var('lang', '')) : $this->lang['default_lang']));			
		}
		// Now, $this->lang['default_lang'] is populated, but do we have a mathing MX-Publisher lang file installed?
		if ( !file_exists(@phpBB2::phpbb_realpath($mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx)) )
		{
			// If not, try english (desperate try)
			$this->lang['default_lang'] = 'english';

			if ( !file_exists(@phpBB2::phpbb_realpath($mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not locate valid language pack: ' . $mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx);
			}
		}
		
		switch (PORTAL_BACKEND)
		{
			//Load vanilla phpBB lang files if is possible
			case 'internal':
					$sql_users = 'UPDATE ' . USERS_TABLE . "
						SET user_lang = '" . $this->encode_lang($this->lang['default_lang']) . "'
						WHERE user_lang = '" . $this->encode_lang($this->data['user_lang']) . "'";
					$sql_config = "UPDATE " . PORTAL_TABLE . " SET
						default_lang = '" . $this->decode_lang($this->lang['default_lang']) . "'
						WHERE portal_id = '1'";						
			break;			
			case 'mybb':
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':				
			case 'phpbb2':
					$sql_users = 'UPDATE ' . USERS_TABLE . "
						SET user_lang = '" . $this->encode_lang($this->lang['default_lang']) . "'
						WHERE user_lang = '" . $this->encode_lang($this->data['user_lang']) . "'";
						
					$sql_config = 'UPDATE ' . CONFIG_TABLE . "
						SET config_value = '" . $this->encode_lang($this->lang['default_lang']) . "'
						WHERE config_name = 'default_lang'";
						
			break;
			case 'smf2':
					$sql_users = 'UPDATE ' . USERS_TABLE . "
						SET lng_file = '" . $this->decode_lang($this->lang['default_lang']) . "'
						WHERE lng_file = '" . $this->decode_lang($this->data['user_lang']) . "'";
						
					$sql_config = 'UPDATE ' . CONFIG_TABLE . "
						SET value = '" . $this->decode_lang($this->lang['default_lang']) . "'
						WHERE variable = 'userLanguage'";
			break;				
		}
		
		// If we've had to change the value in any way then let's write it back to the database
		// before we go any further since it means there is something wrong with it
		if ($this->data['session_logged_in'] && $this->data['user_lang'] !== $this->lang['default_lang'])
		{
			//display an error debuging message only if the portal is installed/upgraded 
			if(!@$db->sql_query($sql_users) && !file_exists($mx_root_path.'/install/'))
			{
				mx_message_die(CRITICAL_ERROR, 'Could not update user language info');
			}
			$this->data['user_lang'] = $this->lang['default_lang'];
		}
		elseif ( !$this->data['session_logged_in'] && $board_config['default_lang'] !== $this->lang['default_lang'] )
		{
			//display an error debuging message only if the portal is installed/upgraded 
			if(!@$db->sql_query($sql_config) && !file_exists($mx_root_path.'/install/'))
			{
				mx_message_die(CRITICAL_ERROR, 'Could not UPDATE CONFIG_TABLE', '', __LINE__, __FILE__, $sql_config);
			}
		}
		
		/*
		* Load MXP lang keys
		*/
		//Load vanilla phpBB2 lang files if is possible
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
				$shared_lang_path = $mx_root_path . 'includes/shared/phpbb2/language/';
				//$template_path = 'styles/';
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
			if ((include $shared_lang_path . "lang_" . $this->lang['default_lang'] . "/lang_admin.$phpEx") === false)
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
		include($mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.' . $phpEx);
		
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
		global $mx_page, $mx_request_vars, $_GET, $_COOKIE;

		/*
		* Build Portal style
		*/
		$portal_config['default_admin_style'] = $portal_config['default_admin_style'] == -1 ? $board_config['default_style'] : $portal_config['default_admin_style'];
		$portal_config['default_style'] = $portal_config['default_style'] == -1 ? $board_config['default_style'] : $portal_config['default_style'];
		$portal_config['override_user_style'] = $portal_config['override_user_style'] == -1 ? $board_config['override_user_style'] : $portal_config['override_user_style'];

		/*
		* Init ACP style
		* Init Portal style		
		*/
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
		/**/
		if (!empty($_GET['style']) || isset($_COOKIE['style']))
		{
			global $SID, $_EXTRA_URL;

			$style = phpBB3::request_var('style', 0);
			$SID .= '&amp;style=' . $style;
			$_EXTRA_URL = array('style=' . $style);
			
			if ( $theme = $this->_setup_style($style) )
			{
				setcookie('style', $style, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
				return;
			}			
		}
		/**/
		
		/*
		* Setup demo style
		*/
		if ( isset($_GET['demo_theme']) || isset($_COOKIE['demo_theme']))
		{
				$style = isset($_GET['demo_theme']) ? intval($_GET['demo_theme']) : intval($_COOKIE['demo_theme']);
				if ( $theme = $this->_setup_style($style) )
				{
					setcookie('demo_theme', $style, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
					return;
				}
		}		
		if (!$mx_request_vars->is_empty_request('demostyle') || !$mx_request_vars->is_empty_request('style') && !defined('IN_ADMIN'))
		{
			$init_style = !$mx_request_vars->is_empty_request('demostyle') ? phpBB3::request_var('demostyle', '') : phpBB3::request_var('style', '');
			if (intval($init_style) == 0)
			{
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'smf2':
					case 'mybb':
						$sql = "SELECT  themes_id, style_name
							FROM " . MX_THEMES_TABLE . "
							WHERE portal_backend = '" . PORTAL_BACKEND . "'
							AND style_name = '$init_style'";
					break;
					case 'phpbb2':
						$sql = "SELECT  mxt.themes_id, bbt.style_id, bbt.style_name
							FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " bbt
							WHERE mxt.style_name = bbt.style_name
							AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
							AND mxt.style_name = '$init_style'";
					break;
					case 'phpbb3':
					case 'olympus':
					case 'ascraeus':
					case 'rhea':
						$sql = "SELECT  mxt.themes_id, bbt.style_id, bbt.style_name
							FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TEMPLATE_TABLE . " AS stt, " . STYLES_TABLE . " AS bbt
							WHERE bbt.style_active = 1 AND bbt.style_name = '$init_style'
								AND bbt.style_name = mxt.style_name
								AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
								AND stt.template_id = bbt.template_id";
					break;
				}
				if(($result = $db->sql_query($sql)) && ($row = $db->sql_fetchrow($result)))
				{
					$init_style = $row['themes_id']; //Portal Style Id
				}
				else
				{
					die('Could not find style name: ' . $init_style . '!');
				}
			}
			else
			{
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'smf2':
					case 'mybb':
						$sql = "SELECT  themes_id, style_name
							FROM " . MX_THEMES_TABLE . "
							WHERE portal_backend = '" . PORTAL_BACKEND . "'
							AND themes_id = " . (int) $init_style;
					break;
					case 'phpbb2':
						$sql = "SELECT  mxt.themes_id, bbt.style_id, bbt.style_name
							FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " bbt
							WHERE mxt.style_name = bbt.style_name
							AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
							AND bbt.style_id = " . (int) $init_style;
					break;
					case 'phpbb3':
					case 'olympus':
					case 'ascraeus':
					case 'rhea':
						$sql = "SELECT  mxt.themes_id, bbt.style_id, bbt.style_name
							FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TEMPLATE_TABLE . " AS stt, " . STYLES_TABLE . " AS bbt
							WHERE bbt.style_active = 1 AND bbt.style_id = " . (int) $init_style . "
								AND bbt.style_name = mxt.style_name
								AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
								AND stt.template_id = bbt.template_id";
					break;
				}
				if(($result = $db->sql_query($sql)) && ($row = $db->sql_fetchrow($result)))
				{
					$init_style = $row['themes_id']; //Portal Style Id
				}
				else
				{
					die('style_id: ' . $init_style . ', no style with this id found ...');
				}
			}
			if ($theme = $this->_setup_style($init_style, false) )
			{
				@setcookie((!$mx_request_vars->is_empty_request('demostyle') ? 'demostyle' : 'style'), $init_style, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
				return;
			}
		}
		if (!$init_style)
		{
			$init_style = 1;
			$init_override = 1;
		}
		//
		// Setup MXP Style
		//
		$user_style = false;
		if (!$init_override)
		{
			if ( $this->data['user_id'] != ANONYMOUS && $this->data['user_style'] > 0 )
			{
				$user_style = $mx_request_vars->post('user_style', MX_TYPE_INT, $this->data['user_style']);
			}
		}
		$init_style = $mx_request_vars->post('default_style', MX_TYPE_INT, $init_style);		
		$theme = $this->_setup_style($init_style, $user_style);		
	}

	/**
	 * Setup style.
	 *
	 * @access private
	 * @param unknown_type $style
	 * @return unknown
	 */
	function _setup_style($init_style, $user_style = false)
	{
		global $db, $board_config, $portal_config, $template, $phpbb_root_path, $mx_root_path;
		
		global $images, $theme;

		$row = false;
		
		// Are we trying a userstyle?
		if ((intval($user_style) !== 0) && !empty($user_style))
		{
			$row = $this->_style_query($user_style);
		}

		// ...or a Custom Page/AdminCP Style
		if (!isset($row['style_name']))
		{
			$row = $this->_style_query($init_style);
		}
		
		// Seems like we need to try the default style
		if (!isset($row['style_name']))
		{
			$row = $this->_style_query($portal_config['default_style']);
		}
		
		// Last desperate try...
		if (!isset($row['style_name']))
		{
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'smf2':
				case 'mybb':
					$sql = 'SELECT *
						FROM ' . MX_THEMES_TABLE;
				break;
				case 'phpbb2':
					$sql = 'SELECT *
						FROM ' . THEMES_TABLE;
				break;
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
					$sql = "SELECT bbt.*, stt.*
						FROM " . MX_THEMES_TABLE . " mxt, " . STYLES_TABLE . " bbt, " . STYLES_TEMPLATE_TABLE . " stt
						WHERE mxt.template_name = stt.template_path";
				break;
			}
			if ( !($result = $db->sql_query_limit($sql, 1)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not query database for theme info - desperate try');
			}
			
			if ( !($row = $db->sql_fetchrow($result)) )
			{
				mx_message_die(CRITICAL_ERROR, "Could not get MX-Publisher style data for themes_id [$init_style]");
			}
			
			$db->sql_freeresult($result);
		}

		/*
		* Init class settings
		*/
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
			case 'phpbb2':
				$this->template_name = $row['template_name'];
				$this->style_name = $row['template_name'];				
				$style = $row['themes_id'];
			break;
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
				$this->template_name = $row['template_path'];
				$this->style_name = $row['style_name'];
				$style = $row['style_id'];				
			break;
		}
		
		//print_r("$this->style_name");
		$this->current_template_path = $this->template_path . $this->template_name;
		$this->default_current_template_path = $this->template_path . $this->default_template_name;
		$this->current_style_phpbb_path = $this->style_path . $this->template_name;	//new
		$this->default_style_phpbb_path = $this->style_path . $this->default_style_name; //new			
		$this->style = $style; // To main style init. Should be correct and valid.
		
		// What template to use?
		$template = new mx_Template($mx_root_path . $this->template_path . $this->template_name);
		//todo@ remove redefination
		@define('TEMPLATE_ROOT_PATH', $this->template_path . $this->template_name . '/');		
		
		/*
		* Load template settings
		* - pass cloned template name to $theme
		*/
		$template_config_row = $this->_load_template_config();

		$row['template_copy'] = $template_config_row['template_copy'];
		$row['cloned_template_name'] = $template_config_row['cloned_template'];
		$row['border_graphics'] = $template_config_row['border_graphics'];
		
		/*
		* Load template settings
		* - pass cloned template name to $theme
		*/	
		$this->cloned_template_name = $row['cloned_template_name'];
		$this->cloned_current_template_path = !empty($this->cloned_template_name) ? $this->template_path . $this->cloned_template_name : '';
		$this->cloned_style_phpbb_path = !empty($this->cloned_template_name) ? $this->style_path . $this->cloned_template_name : ''; //new
			

		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
				foreach($template_config_row as $key => $value)
				{
					$row[$key] = $value;
				}
			break;
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
				$row['style_copy'] = $template_config_row['template_copy'];
				$row['head_stylesheet'] = $row['template_path'] . '.css';
			break;
		}
		
		// Get missing theme colors from *.cfg file (sort of desperate fix)
		foreach($row as $key => $value)
		{
			if(empty($value) && !empty($theme[$key]))
			{
				$row[$key] = $theme[$key];
			}
		}
		/* 
		* Load images for example for 
		* ACP images/admin_icons/
		*/
		switch (PORTAL_BACKEND)
		{
			case 'phpbb2':
				$this->_load_phpbb_images();
				$this->_load_mxbb_images();
				break;
			case 'internal':
			case 'smf2':
			case 'mybb':
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':				
				$this->_load_mxbb_images();
				break;
		}		
		// Load backend specific style defs.
		$this->setup_style();
		return $row;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $style
	 * @return unknown
	 */
	function _style_query($style = true)
	{
		global $db, $board_config, $portal_config, $template, $phpbb_root_path, $mx_root_path, $theme;
		
		// END Styles_Demo MOD 
		if (intval($style) == 0)
		{
			//Query MX style_name
			$sql_and = "style_name";								
		}
		else  
		{		
			//Query MX themes_id
			$sql_and = "themes_id";								
		}		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
				$sql = "SELECT *
					FROM " . MX_THEMES_TABLE . "
					WHERE portal_backend = '" . PORTAL_BACKEND . "'
					AND " . $sql_and . " = " . (int) $style;
			break;
			case 'phpbb2':
				$sql = "SELECT bbt.*
					FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " bbt
					WHERE mxt.style_name = bbt.style_name
					AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
					AND mxt." . $sql_and . " = " . (int) $style;
			break;
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
				$sql = "SELECT  t . * , s . * 
					FROM " . MX_THEMES_TABLE . " AS m, " . STYLES_TABLE . " AS s, " . STYLES_TEMPLATE_TABLE . " AS t, " . STYLES_THEME_TABLE . " AS c, " . STYLES_IMAGESET_TABLE . " i
					WHERE m.style_name = s.style_name
						AND m.portal_backend = '" . PORTAL_BACKEND . "'									
						AND t.template_id = s.template_id
						AND c.theme_id = s.theme_id
						AND i.imageset_id = s.imageset_id
						AND m." . $sql_and . " = " . (int) $style;						
			break;
		}	
		if (!$result = $db->sql_query_limit($sql, 1))
		{
			mx_message_die(CRITICAL_ERROR, "Could not query database for theme info '$style_id'", '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		//$style_value = $row['style_name'];
		//print_R($style_value);
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
		global $board_config, $images, $theme, $template, $phpbb_root_path, $mx_root_path;
		
		//unset($GLOBALS['MX_TEMPLATE_CONFIG']);
		$mx_template_config = false;
		
		// Load MX-Publisher Template configuration data
		$current_template_path = $current_template_path_d = $mx_root_path . $this->current_template_path;
		$cloned_template_path = $cloned_template_path_d = $mx_root_path . $this->cloned_current_template_path;
		$default_template_path = $default_template_path_d = $mx_root_path . $this->default_current_template_path;
		$template_name = $template_name_d = $this->template_name;
		
		/*
		* Load phpBB3 images
		**/
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
			case 'phpbb2':
				$phpbb_images = $images;
			break;
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
				$phpbb_images = $this->_load_phpbb_images();				
			break;
		}
		$images = (is_array($phpbb_images) && is_array($images)) ? array_merge($phpbb_images, @$images) : (is_array($images) ? $images: $phpbb_images);
		$template_config_filename = $mx_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg';
		
		/*
		*fix for mxp
		**/
		if ((include $template_config_filename) === false)
		{
			print('template config filename ' . $template_config_filename . ' couldn\'t be opened.');
		}
		$this->theme = (is_array($this->theme) && is_array($theme)) ? array_merge($this->theme, @$theme) : (is_array($theme) ? $theme: $this->theme);
		
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
		
		if (!$mx_template_config)
		{
			mx_message_die(CRITICAL_ERROR, "Could not open MX-Publisher $this->template_name template config file", '', __LINE__, __FILE__);
		}
		
		/*
		* Is this a cloned temmplate - defined by main *.cfg?
		*/
		$template_config_row['cloned_template'] = trim(htmlspecialchars($mx_template_settings['cloned_template']));
		$template_config_row['border_graphics'] = $mx_template_settings['border_graphics'];
		$template_config_row['template_copy'] = $mx_template_settings['template_copy'];
		return $template_config_row;
	}
	
	/**
	 * Enter description here...
	 * @access private
	 */
	/**
	 * Enter description here...
	 * @access private
	 */	 
	function _load_phpbb_images()
	{
		global $images, $board_config, $template, $phpbb_root_path, $mx_root_path, $phpEx;

		unset($GLOBALS['TEMPLATE_CONFIG']);
		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
				@define(TEMPLATE_CONFIG, TRUE);
			break;
			case 'phpbb2':
				/*
				* Load phpBB Template configuration data
				* - First try current template
				*/
				if ( file_exists( $phpbb_root_path . $this->current_template_path . "/images" ) )
				{
					$current_template_path = $current_template_phpbb_path = $this->current_template_path;
					$current_template_phpbb_images = $current_template_path . $this->template_name . "/images";					
					$template_name = $this->template_name;
					
					@include($phpbb_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg');
				}
				
				/*
				* Since we have no current Template Config file, try the cloned template instead
				*/
				if ( file_exists( $phpbb_root_path . $this->cloned_current_template_path . "/images" ) && !defined('TEMPLATE_CONFIG') )
				{
					$current_template_path = $current_template_phpbb_path = $this->cloned_current_template_path;
					$current_template_phpbb_images = $current_template_path . "/images";					
					$template_name = $this->cloned_template_name;
					
					@include($phpbb_root_path . $this->cloned_current_template_path . '/' . $this->cloned_template_name . '.cfg');
				}
				/*
				* Last attempt, use default template intead
				*/
				if ( file_exists( $phpbb_root_path . $this->default_current_template_path . "/images" ) && !defined('TEMPLATE_CONFIG') )
				{
					$current_template_path = $current_template_phpbb_path = $this->default_current_template_path;
					$current_template_phpbb_images = $this->default_current_template_path . "/images";				
					$template_name = $this->default_template_name;
					@include($phpbb_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg');
				}
			break;
			case 'phpbb3':
			case 'olympus':		
				/*
				* Load phpBB Template configuration data
				* - First prepare the variables
				*/
				$this->setup_style();
				if (!$this->template_name)
				{
					trigger_error("Could not get style data: $this->template_name", E_USER_ERROR);
				}
				if ($this->data['session_logged_in'])
				{
					$this->lang_name = (file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->data['user_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->data['user_lang']) : ((file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->lang['default_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->lang['default_lang']) : 'en');
					$this->lang_path = $phpbb_root_path . 'language/' . $this->lang_name . '/';

					$this->date_format = $this->data['user_dateformat'];
					$this->timezone = $this->data['user_timezone'] * 3600;
					$this->dst = $this->data['user_dst'] * 3600;
				}
				else
				{
					$this->lang_name = (file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->lang['default_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->lang['default_lang']) : 'en';
					$this->lang_path = $phpbb_root_path . 'language/' . $this->lang_name . '/';
					$this->date_format = $board_config['default_dateformat'];
					$this->timezone = $board_config['board_timezone'] * 3600;
					$this->dst = $board_config['board_dst'] * 3600;
				}				
				$this->img_lang = (@file_exists($phpbb_root_path . 'styles/' . $this->theme['imageset_path'] . '/imageset/' . $this->lang_name)) ? $this->lang_name : $this->encode_lang($board_config['default_lang']);				
				//$this->template_name = $this->theme['imageset_path'];
				//trigger_error("Could not get style data: $this->template_name", E_USER_ERROR);
				
				//
				// Load phpBB Template configuration data
				// - Try current template
				//
				if (file_exists("{$phpbb_root_path}styles/{$this->template_name}/imageset/{$this->img_lang}/imageset.cfg"))
				{
					$cfg_data_imageset_data = phpBB3::parse_cfg_file("{$phpbb_root_path}styles/{$this->template_name}/imageset/{$this->img_lang}/imageset.cfg");
					
					$template_name = $this->template_name;
					$default_style_name = $this->default_style_name;
					
					$current_style_phpbb_path = $this->current_style_phpbb_path = $this->style_path . $this->template_name;	//new
					$current_template_phpbb_path = $current_style_phpbb_path . "/template";
					$current_template_phpbb_images = @file_exists($phpbb_root_path . $current_style_phpbb_path . "/imageset") ? $current_style_phpbb_path. "/imageset" : (@file_exists($phpbb_root_path . $this->default_style2_name . "/imageset") ? $phpbb_root_path . $this->default_style2_name . "/imageset" : $phpbb_root_path . $this->default_template_name . "/imageset");
					//@include($phpbb_root_path . $current_template_phpbb_images . '/imageset.cfg');
					@define('TEMPLATE_CONFIG', true);
				}	
				//
				// Since we have no current Template Config file, try the cloned template instead
				/**/
				else if (@file_exists($phpbb_root_path . $this->style_path . $this->cloned_template_name . "/imageset" ))
				{
					$cfg_data_imageset_data = phpBB3::parse_cfg_file("{$phpbb_root_path}styles/{$this->cloned_template_name}/imageset/{$this->img_lang}/imageset.cfg");
					
					$template_name = $this->cloned_template_name;
					$default_style_name = $this->default_style_name;
					
					$cloned_style_phpbb_path = $this->cloned_style_phpbb_path = $this->style_path . $this->cloned_template_name; //new					
					$current_template_phpbb_path = $cloned_style_phpbb_path . "/template";
					$current_template_phpbb_images = @file_exists($phpbb_root_path . $cloned_style_phpbb_path . "/imageset") ? $this->style_path . $this->cloned_template_name . "/imageset" : (@file_exists($phpbb_root_path . $this->default_style2_name . "/imageset") ? $phpbb_root_path . $this->default_style2_name . "/imageset" : $phpbb_root_path . $this->default_template_name . "/imageset");					
					//@include($phpbb_root_path . $this->cloned_current_template_path . '/imageset.cfg');
					@define('TEMPLATE_CONFIG', file_exists($phpbb_root_path . $current_template_phpbb_images . '/imageset.cfg') ? $phpbb_root_path . $current_template_phpbb_images . '/imageset.cfg' : false);					
				}
				/**/
				// Last attempt, use default template intead
				/**/
				else if (@file_exists($phpbb_root_path . $this->style_path . $this->default_style_name . "/imageset" ))
				{
					$cfg_data_imageset_data = phpBB3::parse_cfg_file("{$phpbb_root_path}styles/{$this->default_template_name}/imageset/{$this->img_lang}/imageset.cfg");
							
					$template_name = $this->default_template_name;
					$default_style_name = $this->default_style_name;
					
					$default_style_phpbb_path = $this->default_style_phpbb_path = $this->style_path . $this->default_style_name; //new					
					$current_template_phpbb_path = $default_style_phpbb_path . "/template";
					$current_template_phpbb_images = @file_exists($phpbb_root_path . $default_style_phpbb_path . "/imageset") ? $this->style_path . $this->default_style_name . "/imageset" : (@file_exists($phpbb_root_path . $this->default_style2_name . "/imageset") ? $phpbb_root_path . $this->default_style2_name . "/imageset" : $phpbb_root_path . $this->default_template_name . "/imageset");					
					//@include($phpbb_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg');
					@define('TEMPLATE_CONFIG', file_exists($phpbb_root_path . $current_template_phpbb_images . '/imageset.cfg') ? $phpbb_root_path . $current_template_phpbb_images . '/imageset.cfg' : false);					
				}
				
				foreach ($cfg_data_imageset_data as $image_name => $value)
				{
					if (strpos($value, '*') !== false)
					{
						if (substr($value, -1, 1) === '*')
						{
							list($image_filename, $image_height) = explode('*', $value);
							$image_width = 0;
						}
						else
						{
							list($image_filename, $image_height, $image_width) = explode('*', $value);
						}
					}
					else
					{
						$image_filename = $value;
						$image_height = $image_width = 0;
					}
					
					if (strpos($image_name, 'img_') === 0 && $image_filename)
					{
						$image_name = substr($image_name, 4);
						/*
						$image_ary[] = array(
							'image_name'		=> (string) $image_name,
							'image_filename'	=> (string) $image_filename,
							'image_height'		=> (int) $image_height,
							'image_width'		=> (int) $image_width,
							'imageset_id'		=> (int) $this->theme['imageset_id'],
							'image_lang'		=> (string) $this->img_lang,
						);
						*/
						//Here we overwrite phpBB3 images names from the template configuration file with images file names from database						
						//$phpbb_images[$image_name] = $image_filename;
						$images[$image_name] =  $this->images($image_name);
						//$images = is_array($images) ? array_merge($phpbb_images, $images) : $phpbb_images;	
					}					
				}
				
				/**/
				//Here we overwrite phpBB images from the template configuration file with images from database
				$images['icon_quote'] =  $this->images('img_icon_post_quote');
				$images['icon_edit'] = $this->images('img_icon_post_edit');
				$images['icon_search'] = $this->images('img_icon_user_search');
				$images['icon_profile'] = $this->images('img_icon_user_profile');
				$images['icon_pm'] = $this->images('img_icon_contact_pm');
				$images['icon_email'] = $this->images('img_icon_contact_email');
				$images['icon_delpost'] = $this->images('img_icon_post_delete');
				//$images['icon_ip'] = $this->images('icon_ip');
				$images['icon_www'] = $this->images('img_icon_contact_www');
				$images['icon_icq'] = $this->images('img_icon_contact_icq');
				$images['icon_aim'] = $this->images('img_icon_contact_aim');
				$images['icon_yim'] = $this->images('img_icon_contact_yahoo');
				$images['icon_msnm'] = $this->images('img_icon_contact_msnm');
				$images['icon_minipost'] = $this->images('img_icon_minipost');
				$images['icon_gotopost'] = $this->images('img_icon_gotopost');
				$images['icon_minipost_new'] = $this->images('img_icon_minipost_new');
				$images['icon_latest_reply'] = $images['img_icon_topic_latest'] = $this->images('img_icon_topic_latest');
				$images['icon_newest_reply'] = $this->images('img_icon_newest_reply');

				$images['forum'] = $this->images('img_forum_read');
				$images['forums'] = $this->images('img_forum_read_subforum');
				$images['forum_new'] = $this->images('img_forum_unread');
				$images['forum_locked'] = $this->images('img_forum_read_locked');

				$images['folder'] = $images['topic_read'] = $this->images('img_topic_read');
				$images['folder_new'] = $images['topic_unread'] = $this->images('img_topic_unread');
				$images['folder_hot'] = $images['topic_hot'] = $this->images('img_topic_read_hot');
				$images['folder_hot_new'] = $images['topic_hot_unread'] = $this->images('img_topic_unread_hot');
				$images['folder_locked'] = $images['topic_locked'] = $this->images('img_topic_unread_locked');
				$images['folder_locked_new'] = $images['topic_locked_unread'] = $this->images('img_topic_locked_unread');
				$images['folder_sticky'] = $images['topic_sticky'] = $this->images('img_topic_read_mine');
				$images['folder_sticky_new'] = $images['topic_sticky_unread'] = $this->images('img_topic_unread_mine');
				$images['folder_announce'] = $images['topic_announce'] = $this->images('img_announce_read');
				$images['folder_announce_new'] = $images['topic_announce_unread'] = $this->images('img_announce_unread');

				$images['post_new'] = $this->images('img_button_topic_new');
				$images['post_locked'] = $this->images('img_button_topic_locked');
				$images['reply_new'] = $this->images('img_button_topic_reply');
				$images['reply_locked'] = $this->images('img_icon_post_target_unread');
				
				/*
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
				/**/
				
				@define('TEMPLATE_CONFIG', TRUE);
				// We include common temlate config file here to not load it every time a module template config file is included
				//$this->theme = is_array($this->theme) ? array_merge($this->theme, $theme) : $theme;				
				//$this->theme = &$theme;
				
			break;
			case 'ascraeus':
			case 'rhea':
				/*
				* Load phpBB Template configuration data
				* - First prepare the variables
				*/
				$this->setup_style();
				if (!$this->template_name)
				{
					trigger_error("Could not get style data: $this->template_name", E_USER_ERROR);
				}
				
				if ($this->data['session_logged_in'])
				{
					$this->lang_name = (file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->data['user_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->data['user_lang']) : ((file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->lang['default_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->lang['default_lang']) : 'en');
					$this->lang_path = $phpbb_root_path . 'language/' . $this->lang_name . '/';

					$this->date_format = $this->data['user_dateformat'];
					$this->timezone = $this->data['user_timezone'] * 3600;
					$this->dst = $this->data['user_dst'] * 3600;
				}
				else
				{
					$this->lang_name = (file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->lang['default_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->lang['default_lang']) : 'en';
					$this->lang_path = $phpbb_root_path . 'language/' . $this->lang_name . '/';
					$this->date_format = $board_config['default_dateformat'];
					$this->timezone = $board_config['board_timezone'] * 3600;
					$this->dst = $board_config['board_dst'] * 3600;
				}
				
				$this->img_lang = (@file_exists($phpbb_root_path . 'styles/' . $this->theme['imageset_path'] . '/theme/' . $this->lang_name)) ? $this->lang_name : $this->encode_lang($board_config['default_lang']);				
				//$this->template_name = $this->theme['imageset_path'];
				//trigger_error("Could not get style data: $this->template_name", E_USER_ERROR);
				
				//
				// Load phpBB Template configuration data
				// - Try current template
				//
				if (file_exists("{$phpbb_root_path}styles/{$this->template_name}/style.cfg"))
				{				
					$template_name = $this->template_name;
					$default_style_name = $this->default_style_name;
					
					$current_style_phpbb_path = $this->current_style_phpbb_path = $this->style_path . $this->template_name;	//new
					$current_template_phpbb_path = $current_style_phpbb_path . "/template";
					$current_template_phpbb_images = @file_exists($phpbb_root_path . $current_style_phpbb_path . "/theme/images") ? $current_style_phpbb_path. "/theme/images" : (@file_exists($phpbb_root_path . $this->default_style2_name . "/theme/images") ? $phpbb_root_path . $this->default_style2_name . "/theme/images" : $phpbb_root_path . $this->default_template_name . "/theme/images");
					@define('TEMPLATE_CONFIG', true);
				}	
				//
				// Since we have no cloned Template Config file, try the cloned template instead
				/**/
				else if (@file_exists($phpbb_root_path . $this->style_path . $this->cloned_template_name . "/style.cfg"))
				{					
					$template_name = $this->cloned_template_name;
					$default_style_name = $this->default_style_name;
					
					$cloned_style_phpbb_path = $this->cloned_style_phpbb_path = $this->style_path . $this->cloned_template_name; //new					
					$current_template_phpbb_path = $cloned_style_phpbb_path . "/template";
					$current_template_phpbb_images = @file_exists($phpbb_root_path . $cloned_style_phpbb_path . "/theme/images") ? $this->style_path . $this->cloned_template_name . "/theme/images" : (@file_exists($phpbb_root_path . $this->default_style2_name . "/theme/images") ? $phpbb_root_path . $this->default_style2_name . "/theme/images" : $phpbb_root_path . $this->default_template_name . "/theme/images");					
					@define('TEMPLATE_CONFIG', true);					
				}
				/**/
				// Last attempt, use default template intead
				/**/
				else if (@file_exists($phpbb_root_path . $this->style_path . $this->default_style_name . "/style.cfg" ))
				{							
					$template_name = $this->default_template_name;
					$default_style_name = $this->default_style_name;
					
					$default_style_phpbb_path = $this->default_style_phpbb_path = $this->style_path . $this->default_style_name; //new					
					$current_template_phpbb_path = $default_style_phpbb_path . "/template";
					$current_template_phpbb_images = @file_exists($phpbb_root_path . $default_style_phpbb_path . "/theme/images") ? $this->style_path . $this->default_style_name . "/imageset" : (@file_exists($phpbb_root_path . $this->default_style2_name . "/imageset") ? $phpbb_root_path . $this->default_style2_name . "/imageset" : $phpbb_root_path . $this->default_template_name . "/imageset");					
					@define('TEMPLATE_CONFIG', true);					
				}
				
				
				/**/
				//Here we overwrite phpBB images from the template configuration file with images from css
				$images['icon_quote'] =  $this->images('img_icon_post_quote');
				$images['icon_edit'] = $this->images('img_icon_post_edit');
				$images['icon_search'] = $this->images('img_icon_user_search');
				$images['icon_profile'] = $this->images('img_icon_user_profile');
				$images['icon_pm'] = $this->images('img_icon_contact_pm');
				$images['icon_email'] = $this->images('img_icon_contact_email');
				$images['icon_delpost'] = $this->images('img_icon_post_delete');
				//$images['icon_ip'] = $this->images('icon_ip');
				$images['icon_www'] = $this->images('img_icon_contact_www');
				$images['icon_icq'] = $this->images('img_icon_contact_icq');
				$images['icon_aim'] = $this->images('img_icon_contact_aim');
				$images['icon_yim'] = $this->images('img_icon_contact_yahoo');
				$images['icon_msnm'] = $this->images('img_icon_contact_msnm');
				$images['icon_minipost'] = $this->images('img_icon_minipost');
				$images['icon_gotopost'] = $this->images('img_icon_gotopost');
				$images['icon_minipost_new'] = $this->images('img_icon_minipost_new');
				$images['icon_latest_reply'] = $images['img_icon_topic_latest'] = $this->images('img_icon_topic_latest');
				$images['icon_newest_reply'] = $this->images('img_icon_newest_reply');

				$images['forum'] = $this->images('img_forum_read'); //images/forum_read.gif
				$images['forums'] = $this->images('img_forum_read_subforum');
				$images['forum_new'] = $this->images('img_forum_unread');
				$images['forum_locked'] = $this->images('img_forum_read_locked');

				$images['folder'] = $images['topic_read'] = $this->images('img_topic_read');
				$images['folder_new'] = $images['topic_unread'] = $this->images('img_topic_unread');
				$images['folder_hot'] = $images['topic_hot'] = $this->images('img_topic_read_hot');
				$images['folder_hot_new'] = $images['topic_hot_unread'] = $this->images('img_topic_unread_hot');
				$images['folder_locked'] = $images['topic_locked'] = $this->images('img_topic_unread_locked');
				$images['folder_locked_new'] = $images['topic_locked_unread'] = $this->images('img_topic_locked_unread');
				$images['folder_sticky'] = $images['topic_sticky'] = $this->images('img_topic_read_mine');
				$images['folder_sticky_new'] = $images['topic_sticky_unread'] = $this->images('img_topic_unread_mine');
				$images['folder_announce'] = $images['topic_announce'] = $this->images('img_announce_read');
				$images['folder_announce_new'] = $images['topic_announce_unread'] = $this->images('img_announce_unread');

				$images['post_new'] = $this->images('img_button_topic_new');
				$images['post_locked'] = $this->images('img_button_topic_locked');
				$images['reply_new'] = $this->images('img_button_topic_reply');
				$images['reply_locked'] = $this->images('img_icon_post_target_unread');
				
				//@define('TEMPLATE_CONFIG', TRUE);
				// We include common temlate config file here to not load it every time a module template config file is included
				//$this->theme = is_array($this->theme) ? array_merge($this->theme, $theme) : $theme;				
				//$this->theme = &$theme;			
			break;			
		}
		
		/*
		* We have no template to use - die
		*/
		if ( !defined('TEMPLATE_CONFIG') )
		{
			mx_message_die(CRITICAL_ERROR, "Could not open phpBB $this->template_name template config file", '', __LINE__, __FILE__);
		}
		
		$img_lang = ( file_exists($phpbb_root_path . $this->current_template_path . '/images/lang_' . $this->encode_lang($this->lang['default_lang'])) ) ? $this->encode_lang($this->lang['default_lang']) : 'english';
		
		/*
		* Import phpBB Graphics, prefix with PHPBB_URL, and apply LANG info
		*/
		while( list($key, $value) = @each($images) )
		{
			if (is_array($value))
			{
				foreach( $value as $key2 => $val2 )
				{
					$images[$key][$key2] = str_replace(PORTAL_URL . PHPBB_URL, PHPBB_URL, $val2);
				}
			}
			else
			{
				$images[$key] = str_replace('{LANG}', 'lang_' . $img_lang, $value);
				$images[$key] = str_replace(PORTAL_URL . PHPBB_URL, PHPBB_URL, $images[$key]);
			}
		}
		return $images;
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
		global $mx_block, $mx_user, $phpEx;
		
		//This will  keep loaded images
		$mx3_images = $images;
		
		//unset($GLOBALS['MX_TEMPLATE_CONFIG']);
		$mx_template_config = false;
		
		/*
		* Load module cfg
		*/
		$moduleCfgFile = str_replace('/', '', str_replace('modules/', '', $mx_block->module_root_path));
		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
				@define(TEMPLATE_CONFIG, TRUE);
			break;
			
			case 'phpbb2':	
			break;
			
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':		
			case 'rhea':	
				/**/
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
				/**/
			break;				
		}
		
		/*
		* Load MX-Publisher Template configuration data
		* - First try current template
		*/
		$current_template_path = $current_template_path_d = $module_root_path . $this->current_template_path;
		$cloned_template_path = $cloned_template_path_d = $module_root_path . $this->cloned_current_template_path;
		$default_template_path = $default_template_path_d = $module_root_path . $this->default_current_template_path;
		$template_name = $template_name_d = $this->template_name;
		$template_config_d = TEMPLATE_CONFIG;
		
		//@define('MX_TEMPLATE_CONFIG', false);
		$mx_template_config = false;
		if (@file_exists($mx_root_path . $module_root_path . $this->current_template_path . '/' . $template_name . '.cfg'))
		{
			include($mx_root_path . $module_root_path . $this->current_template_path . '/' . $template_name . '.cfg');
		}
		
		if (!$mx_template_config)
		{
			include($mx_root_path . $module_root_path . $this->current_template_path . '/' . $moduleCfgFile . '.cfg');
		}
		
		/*
		* Since we have no current Template Config file, try the cloned template instead
		*/
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
		
		/*
		* If use default template intead
		*/
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
		
		/*
		* If old version 2 module search for  subSilver template intead
		*/
		if (!$mx_template_config)
		{
			$template_name2 = 'subSilver';
			
			$current_template_path = $module_root_path . $this->default_current_template_path;
			$template_name = $this->default_template_name;
			
			@include($mx_root_path . $module_root_path . $this->default_current_template_path . '/' . $template_name2 . '.cfg');
			if (!$mx_template_config)
			{
				@include($mx_root_path . $module_root_path . $this->default_current_template_path . '/' . $moduleCfgFile . '.cfg');
			}
		}
		
		/*
		* We have no template to use - die
		*/
		if (!$mx_template_config)
		{
			mx_message_die(CRITICAL_ERROR, "Could not open " . $mx_root_path . $module_root_path . $this->default_current_template_path .  '/' . $template_name . '.cfg' . " style config file " .	"<br /> current_template_path: " . $mx_root_path . $module_root_path . $current_template_path_d  . '/' . $template_name_d . '.cfg' . "<br /> cloned_template_path: " . $mx_root_path . $module_root_path . $cloned_template_path_d . "<br /> default_template_path: " . $mx_root_path . $module_root_path . $default_template_path_d . "<br /> template_name: " . $template_name_d . "<br /> template_config: "  . $template_config_d . "", '', __LINE__, __FILE__);
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
		$module_key = !empty($module_root_path) ? $module_root_path : '_core';
		$this->template_names[$module_key] = $template_name;
		
		//This will  keep loaded images
		$images = &$mx3_images;
		
		// We include common temlate config file here to not load it every time a module template config file is included
		//$this->theme = is_array($this->theme) ? array_merge($this->theme, $theme) : $theme;		
		$this->theme = &$theme;
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
		$default_lang = ($this->lang['default_lang']) ? $this->decode_lang($this->lang['default_lang']) : $board_config['default_lang'];
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
				if ((include $module_lang_path . "language/lang_" . $default_lang . "/lang_main.$phpEx") === false)
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
	function init($user_ip, $page_id, $init_style = true)
	{
		// Define basic constants
		$this->page_id = $page_id;
		$this->user_ip = $user_ip;

		// Inititate User data
		$this->_init_session($user_ip, $this->page_id);
		$this->_init_userprefs();

		// Inititate User style
		if ($init_style)
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
		global $images;
		
		/*
		* The User class must first be initiated.
		*/
		if (empty($this->page_id))
		{
			die('Bad initialization method of the User Class!');
		}

		/*
		* Inititate User style
		*/
		$this->_init_style();
		
		/*
		* Load images
		**/		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
			break;
				
			case 'phpbb2':
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':			
				$this->_load_phpbb_images();		
			break;
		}
		/**/
		
		// Load images
		$this->_load_mxbb_images();
		
		// Load backend specific style defs.
		$this->setup_style();		
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