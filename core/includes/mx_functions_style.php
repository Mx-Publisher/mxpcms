<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: mx_functions_style.php,v 1.2 2012/10/25 09:49:16 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}
//
// Load session class, based on mxp backend
//
include_once($mx_root_path . 'includes/sessions/phpbb2/session.' . $phpEx);
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
/********************************************************************************\
| Class: mx_Template
| The mx_Template class extends the native phpBB Template class, in reality only redefining the make_filename method. 
| Thus modded phpBB templates (eg eXtreme Styles MOD) will also be available for mxBB.
| 
| 
| //
| // Usage examples:
| //
| 
| Nothing new...	
\********************************************************************************/

//
// Include templating (XS style)
//
include_once($mx_root_path . 'includes/template.' . $phpEx);


class mx_Template extends Template
{
	/**
	 * Constructor. Simply calling parent construtor.
	 * This is required. Reason is constructors have different method names.
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
	 * This make_filename implementation overrides parent method.
	 *
	 * Generates a full path+filename for the given filename, which can either
	 * be an absolute name, or a name relative to the rootdir for this Template
	 * object.
	 */
	function make_filename($filename, $xs_include = false)
	{
		global $module_root_path, $mx_root_path, $phpbb_root_path, $theme, $mx_user, $mx_block;

		//
		// ?
		//
		if($this->subtemplates)
		{
			$filename = $this->subtemplates_make_filename($filename);
		}

		//
		// Check replacements list
		//
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
		// Look at phpBB-Root folder...
		//
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

		if( !file_exists($filename) )
		{
			die("Template->make_filename(): Error - file $filename does not exist. <br />Class-Root: $this->root <br /> $this->debug_paths");
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
				else if( file_exists($root . '/' . $filename) )
				{
					$this->module_template_path = $root . '/';
					return $root . '/' . $filename;
				}
				
				if ($check_file2 && file_exists($root_path . $root . $path . '/' . $filename2))
				{
					$this->module_template_path = $root . $path . '/';
					return $root_path . $root . $path . '/' . $filename2;
				}
				else if ($check_file2 && file_exists($root . '/' . $filename2))
				{
					$this->module_template_path = $root . '/';
					return $root . '/' . $filename2;
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
	 * set_template
	 *
	 * This set_template implementation overrides parent method.
	 * Generates a full path, which can either
	 * be an absolute, or relative to the rootdir for this Template
	 * object.
	 *
	 * @access public
	 */
	function set_template()
	{
		global $module_root_path, $mx_root_path, $phpbb_root_path, $theme, $mx_user, $mx_block;

		$style_path = $theme['template_name'] . '/';

		//
		// Look at mxBB-Module folder.........................................................................mxBB-module
		//
		if (!empty($module_root_path))
		{
			$this->module_template_path = '';
			$moduleDefault = !empty($mx_user->loaded_default_styles[$mx_block->module_root_path]) ? $mx_user->loaded_default_styles[$mx_block->module_root_path] : $mx_user->default_template_name;

			if( file_exists($module_root_path . 'templates/' . $style_path . '/') )
			{
				//
				// First check current template
				//
				$this->root = $module_root_path . 'templates/' . $style_path . '/';
				$this->module_template_path = 'templates/' . $style_path . '/';
			}
			else if( file_exists($module_root_path . 'templates/' . $mx_user->cloned_template_name . '/') && !empty($mx_user->cloned_template_name))
			{
				//
				// Then check Cloned template
				//
				$this->root = $module_root_path . 'templates/' . $mx_user->cloned_template_name . '/';
				$this->module_template_path = 'templates/' . $mx_user->cloned_template_name . '/';
			}
			else if( file_exists($module_root_path . 'templates/' . $moduleDefault . '/') )
			{
				//
				// Then check default template
				//
				$this->root = $module_root_path . 'templates/' . $moduleDefault . '/';
				$this->module_template_path = 'templates/' . $moduleDefault . '/';
			}
			else if( file_exists($module_root_path . 'templates/') )
			{
				//
				// Finally check the template root (for compatibility with some old modules)
				//
				$this->root = $module_root_path . 'templates/';
				$this->module_template_path = 'templates/';
			}

			if (!empty($this->module_template_path))
			{
				return '';
			}
		}

		//
		// Look at mxBB-Root folder.........................................................................mxBB-Root
		//
		if( file_exists($mx_root_path . 'templates/' . $style_path . '/') )
		{
			//
			// First check current template
			//
			$this->root = $mx_root_path . 'templates/' . $style_path . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $style_path . '_';
		}
		else if( file_exists($mx_root_path . 'templates/' . $mx_user->cloned_template_name . '/') && !empty($mx_user->cloned_template_name))
		{
			//
			// Then check Cloned template
			//
			$this->root = $mx_root_path . 'templates/' . $mx_user->cloned_template_name . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $mx_user->cloned_template_name . '_';
		}
		else if( file_exists($mx_root_path . 'templates/' . $mx_user->default_template_name . '/') )
		{
			//
			// Then check Default template
			//
			$this->root = $mx_root_path . 'templates/' . $mx_user->default_template_name . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $mx_user->default_template_name . '_';
		}
		//
		// Look at Custom Root folder..............this is used my mx_mod installers too.......this does not use standard templates folders wich are set when the template was re-initialized and defined as custom var
		//
		else if( file_exists( $this->root . '/') )
		{
			$this->root =  $this->root . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $this->root . '_';
		}
		else if( file_exists($this->root . '/' . $style_path . '/') )
		{
			//
			// First check current template
			//
			$this->root = $this->root . '/' . $style_path . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $style_path . '_';
		}
		else if( file_exists($this->root . '/' . $style_path . '/') )
		{
			//
			// tpl - html
			//
			$this->root = $this->root. '/' . $style_path . '/';
		}
		else if( file_exists($this->root . '/' . $mx_user->default_template_name . '/') )
		{
			//
			// Then check current template
			//
			$this->root = $mx_root_path . '/' . $mx_user->default_template_name . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $mx_user->default_template_name . '_';
		}
		else if( file_exists($this->root . '/' . $moduleDefault . '/') )
		{
			//
			// Finally check the Custom Root folde(for compatibility with some old modules)
			//
			$this->root = $this->root . '/' . $moduleDefault . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $moduleDefault . '_';
		}
		else
		{
			//
			// phpBB.........................................................................phpBB
			//
			if( file_exists($phpbb_root_path . 'templates/' . $style_path . '/') )
			{
				//
				// First check current template
				//
				$this->root = $phpbb_root_path . 'templates/' . $style_path . '/';
				$this->cachepath = $phpbb_root_path . 'cache/tpl_' . $style_path. '_';				
			}
			else if( file_exists($phpbb_root_path . 'templates/' . $mx_user->cloned_template_name . '/') && !empty($mx_user->cloned_template_name))
			{
				//
				// Then check Cloned
				//
				$this->root = $phpbb_root_path . 'templates/' . $mx_user->cloned_template_name . '/';
				$this->cachepath = $phpbb_root_path . 'cache/tpl_' . $mx_user->cloned_template_name . '_';				
			}
			else if( file_exists($phpbb_root_path . 'templates/' . $mx_user->default_template_name . '/') && !empty($mx_user->default_template_name))
			{
				//
				// Then check Default
				//
				$this->root = $phpbb_root_path . 'templates/' . $mx_user->default_template_name . '/';
				$this->cachepath = $phpbb_root_path . 'cache/tpl_' . $mx_user->default_template_name . '_';				
			}
			else if (file_exists($phpbb_root_path . 'styles/' . $mx_user->theme['template_path'] . '/template'))
			{
				//
				// Then check phpBB3 style
				//			
				$this->root = $phpbb_root_path . 'styles/' . $mx_user->theme['template_path'] . '/template';
				$this->cachepath = $phpbb_root_path . 'cache/tpl_' . $mx_user->theme['template_path'] . '_';
			}			
			else if( file_exists($phpbb_root_path . $this->root . '/') )
			{
				$this->root = $phpbb_root_path . $this->root . '/';
				$this->cachepath = $phpbb_root_path . 'cache/tpl_' . $this->root . '_';
			}
			else if( file_exists($this->root . '/') )
			{
				//
				// Check if it's an absolute or relative path.
				//
				$this->root = phpbb_realpath($this->root . '/');
				$this->cachepath = $phpbb_root_path . 'cache/tpl_' . phpbb_realpath($this->root . '/') . '_';
			}
			else
			{
				trigger_error('Template path could not be found: styles/' . $mx_user->theme['template_path'] . '/template', E_USER_ERROR);
			}		
		}
		$this->_rootref = &$this->_tpldata['.'][0];
		
		return true;	
	}
}	// class mx_Template

/********************************************************************************\
| Class: mx_user
| The mx_user class 
| 
| // 
| // Properties
| // 
| 
| // 
| // Methods
| // 
| 
| 
| //
| // Usage examples:
| //
| 
| 	
\********************************************************************************/
define('MX_LANG_MAIN'	, 10);
define('MX_LANG_ADMIN'	, 20);
define('MX_LANG_ALL'	, 30);
define('MX_LANG_NONE'	, 40);
define('MX_IMAGES'		, 50);
define('MX_IMAGES_NONE'	, 60);
	
class mx_user extends mx_session
{
	//
	// Implementation Conventions:
	// Properties and methods prefixed with underscore are intented to be private. ;-)
	//

	// ------------------------------
	// Vars
	//
	var $loaded_langs = array();
	var $loaded_styles = array();
	var $loaded_default_styles = array();
	
	var $template_path = 'templates/';

	var $template_name = '';
	var $template_names = array();
	var $current_template_path = '';

	var $cloned_template_name = '';
	var $cloned_current_template_path = '';

	var $default_template_name = 'subSilver';
	var $default_current_template_path = '';

	var $default_module_style = '';
	var $module_lang_path = array();

	var $is_admin = false;
	
	var $page_id = '';
	var $user_ip = '';

	var $data = array(); // For future Olympus comp.	
	
	// ------------------------------
	// Properties
	//

	// none in this class.

	// ------------------------------
	// Constructor
	//

	// ------------------------------
	// Private Methods
	//
	
	//
	// Start session management (phpBB 2.0.x)
	// - populate $userdata
	//
	function _init_session($user_ip, $page_id)
	{
		$this->mx_session_begin();
		$this->is_admin = $this->data['user_level'] == ADMIN && $this->data['session_logged_in'];
	}
	//
	// Initialise user settings on page load
	// - populate $lang, $theme, $images and initiate $template
	//	
	function _init_userprefs()
	{
		global $userdata, $board_config, $theme, $images;
		global $template, $lang, $phpEx, $phpbb_root_path, $mx_root_path;
		global $nav_links;
		
		//
		// Clean up and ensure we are using mxp internal (long) lang format
		//
		$board_config['phpbb_lang'] = $board_config['default_lang']; // Handy switch
		$this->lang['default_lang'] = phpbb_ltrim(basename(phpbb_rtrim($board_config['default_lang'])), "'");
		$this->data['user_lang'] = phpbb_ltrim(basename(phpbb_rtrim($this->data['user_lang'])), "'");
		
		if ( $userdata['user_id'] != ANONYMOUS )
		{
			if ( !empty($userdata['user_lang']))
			{
				$board_config['default_lang'] = $userdata['user_lang'];
			}
	
			if ( !empty($userdata['user_dateformat']) )
			{
				$board_config['default_dateformat'] = $userdata['user_dateformat'];
			}
	
			if ( isset($userdata['user_timezone']) )
			{
				$board_config['board_timezone'] = $userdata['user_timezone'];
			}
		}
	
		//
		// Is the lang installed?
		//
		if ( !file_exists($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx) || !file_exists($pbpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx))
		{
			$board_config['default_lang'] = 'english';
		}
	
		//
		// Include phpBB and mxBB lang keys
		//	
		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
		include($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
	
		//
		// Include Admin lang keys
		//
		if ( defined('IN_ADMIN') )
		{
			if( !file_exists($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) || !file_exists($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) )
			{
				$board_config['default_lang'] = 'english';
			}
			
			include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
			include($mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
		} 

		//
		// Set up demo style
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
		// Set up style
		//
		if ( !$board_config['override_user_style'] )
		{
			if ( $userdata['user_id'] != ANONYMOUS && $userdata['user_style'] > 0 )
			{
				$style = isset($_POST['user_style']) ? intval($_POST['user_style']) : $userdata['user_style'];
				if ( $theme = $this->_setup_style($style) )
				{
					return;
				}
			}
		}

		$style = isset($_POST['default_style']) ? intval($_POST['default_style']) : $board_config['default_style'];
		$theme = $this->_setup_style($style);
	
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
	
		return;
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
		// Setup MXP Style
		//
		$user_style = 0;
		if ( !$init_override )
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
	function _setup_style($init_style, $user_style = 0)
	{
		global $db, $board_config, $portal_config, $template, $phpbb_root_path, $mx_root_path;
		
		global $images, $theme;

		$row = false;
		//
		// Are we trying a userstyle?
		//
		if ($user_style)
		{
			$row = $this->_style_query($user_style);
		}

		//
		// ...or a Custom Page/AdminCP Style
		//
		if (!$row)
		{
			$row = $this->_style_query($init_style);
		}

		//
		// Seems like we need to try the default style
		//
		if (!$row)
		{
			$row = $this->_style_query($portal_config['default_style']);
		}

		//
		// Last desperate try...
		//
		if (!$row)
		{
			$sql = 'SELECT *
				FROM ' . THEMES_TABLE;

			if ( !($result = $db->sql_query_limit($sql, 1)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not query database for theme info - desperate try');
			}

			if ( !($row = $db->sql_fetchrow($result)) )
			{
				mx_message_die(CRITICAL_ERROR, "Could not get style data for themes_id [init_style: $init_style, user_style: $user_style]");
			}

			$db->sql_freeresult($result);
		}

		//
		// Init class settings
		//
		$this->template_name = $row['template_name'];
		$style = $row['themes_id'];
		
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

		$row['style_copy'] = $template_config_row['template_copy'];
		$row['head_stylesheet'] = $row['template_path'] . '.css';

		$this->cloned_template_name = 'subSilver'; //$row['cloned_template_name'];
		$this->cloned_current_template_path = !empty($this->cloned_template_name) ? $this->template_path . $this->cloned_template_name : '';

		//
		// What template to use?
		//
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
			
		foreach($template_config_row as $key => $value)
		{
			$row[$key] = $value;
		}

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
		// Load images
		//
		$this->_load_phpbb_images();
		$this->_load_mxbb_images();
		
		return $row;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $style
	 * @return unknown
	 */
	function _style_query($style)
	{
		global $db, $board_config, $portal_config, $template, $phpbb_root_path, $mx_root_path, $theme;

		//
		// Get theme data. To cache?
		// Note: This part is different from original phpBB style setup
		//
		$sql = 'SELECT *
			FROM ' . THEMES_TABLE . '
			WHERE themes_id = ' . (int) $style;
			
		//
		// Use default style if custom theme doesn't exist.
		//
		if (($result = $db->sql_query($sql)) )
		{
			
		}
		else
		{
			$default_style = $board_config['default_style'];
			$style = !empty($default_style) ? $default_style : 1;
			$sql = 'SELECT *
				FROM ' . THEMES_TABLE . '
				WHERE themes_id = ' . (int) $style;

			if ( !$result = $db->sql_query($sql) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not query database for theme info', '', __LINE__, __FILE__, $sql);
			}
		}
		//
		// Last desperate try...
		//
		if (($row = $db->sql_fetchrow($result)))
		{
			return $row;
		}
		else		
		{
			$init_style = $style;
			$user_style = $this->data['user_style'];
			$user_style = !empty($user_style) ? $user_style : 1;
			$sql = 'SELECT *
				FROM ' . THEMES_TABLE . '
				WHERE themes_id = ' . (int) $user_style;


			if ( !($result = $db->sql_query_limit($sql, 1)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not query database for theme info', '', __LINE__, __FILE__, $sql);
			}
			if ( !($row = $db->sql_fetchrow($result)) )
			{
				mx_message_die(CRITICAL_ERROR, "Could not get style data for themes_id [init_style: $init_style, user_style: $user_style]", '', __LINE__, __FILE__, $sql);
			}
		}
				
		$db->sql_freeresult($result);
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
		// Load mxBB Template configuration data
		//
		@include($mx_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg');
			
		if ( !$mx_template_config )
		{
			//
			// Since we have no Template Config file, use default (subSilver) instead
			//
			@include($mx_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg');	
			
			//
			// Make default template -> current template
			//
			$this->template_name = $this->default_template_name;
			$this->current_template_path = $this->default_current_template_path;
			$current_template_path = $this->current_template_path;			
			$default_template_path = $this->default_current_template_path;
			
			if (defined('TEMPLATE_CONFIG'))
			{
				$mx_template_config = true;
			}			
		}
		
		if ( !defined('MX_TEMPLATE_CONFIG') && (@file_exists($phpbb_root_path . $this->current_template_path . '/' . $this->template_name. '.cfg')))
		{
			define(MX_TEMPLATE_CONFIG, true);
			$this->template_name = $this->template_name;
			$this->current_template_path = $this->current_template_path;			
		}
		
		if ( !defined('MX_TEMPLATE_CONFIG') && (@file_exists($phpbb_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg')))
		{
			define(MX_TEMPLATE_CONFIG, true);
			$this->template_name = $this->default_template_name;
			$this->current_template_path = $this->default_current_template_path;
		}

		//
		// We have no template
		//
		if (!$mx_template_config)
		{
			define(MX_TEMPLATE_CONFIG, true);
			$mx_template_config = true;
			// Where are the phpbb images?
			$mx_images['mx_graphics']['phpbb_icons'] 	= !empty($current_template_path) && file_exists( $phpbb_root_path . $current_template_path . "/images" ) ? $current_template_path . "/images" : ( !empty($cloned_template_path) && file_exists( $phpbb_root_path . $cloned_template_path . "/images" ) ? $cloned_template_path . "/images" :  $default_template_path . "/images");
			$current_template_images 					= PORTAL_URL . $mx_images['mx_graphics']['general']; // Logo etc
			$current_template_page_images 				= PORTAL_URL . $mx_images['mx_graphics']['page_icons']; // Used by adminCP - Pages
			$current_template_block_images 				= PORTAL_URL . $mx_images['mx_graphics']['block_icons']; // Used by userCP block buttons
			$current_template_menu_images 				= PORTAL_URL . $mx_images['mx_graphics']['menu_icons']; // Used by adminCP - Navigation Menu
			$current_template_admin_images 				= PORTAL_URL . $mx_images['mx_graphics']['admin_icons']; // Internal graphics for the mxBB adminCP
			$current_template_theme_graphics 			= PORTAL_URL . $mx_images['mx_graphics']['theme_graphics']; // Internal graphics for the mxBB adminCP
			$current_template_phpbb_images 				= PHPBB_URL . $mx_images['mx_graphics']['phpbb_icons'];
			//mx_message_die(CRITICAL_ERROR, "Could not open " . $template_name . " template config file of module " . $mx_root_path . $module_root_path . $current_template_path . ".", '', __LINE__, __FILE__);
		}		
		
		//
		// Is this a cloned temmplate - defined by main *.cfg?
		//
		
		$template_config_row['cloned_template'] = trim(htmlspecialchars($mx_template_settings['cloned_template']));
		$template_config_row['border_graphics'] = $mx_template_settings['border_graphics'];
		$template_config_row['template_copy'] = $mx_template_settings['template_copy'];
		
		return $template_config_row;
	}
		
	function _load_phpbb_images()
	{
		global $images, $board_config, $template, $phpbb_root_path, $mx_root_path;

		unset($GLOBALS['TEMPLATE_CONFIG']);
		
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
		
		//
		// We have no template to use - die
		//		
		if ( !defined('TEMPLATE_CONFIG') )
		{
			mx_message_die(CRITICAL_ERROR, "Could not open phpBB $this->template_name template config file", '', __LINE__, __FILE__);
		}
	
		$img_lang = ( file_exists($phpbb_root_path . $this->current_template_path . '/images/lang_' . $board_config['default_lang']) ) ? $board_config['default_lang'] : 'english';
		
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
		
	function _load_mxbb_images($module_root_path = '')
	{
		global $images, $board_config, $template, $phpbb_root_path, $mx_root_path;

		//unset($GLOBALS['MX_TEMPLATE_CONFIG']); 
		$mx_template_config = false;
		
		//
		// Load mxBB Template configuration data
		// - First try current template
		//
		$current_template_path = $module_root_path . $this->current_template_path;
		$cloned_template_path = $module_root_path . $this->cloned_current_template_path;
		$template_name = $this->template_name;		
						
		@include($mx_root_path . $module_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg');
			
		//
		// Since we have no current Template Config file, try the cloned template instead
		//
		if ( !$mx_template_config )
		{
			$current_template_path = $module_root_path . $this->cloned_current_template_path;
			$template_name = $this->cloned_template_name;	
			
			@include($mx_root_path . $module_root_path . $this->cloned_current_template_path . '/' . $this->cloned_template_name . '.cfg');	
		}
		
		//
		// If use default template intead
		//		
		if ( !$mx_template_config )
		{
			$current_template_path = $module_root_path . $this->default_current_template_path;
			$template_name = $this->default_template_name;	
			
			@include($mx_root_path . $module_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg');	
		}

		if ( !$mx_template_config && (@file_exists($phpbb_root_path . $this->current_template_path. '/' . $this->template_name. '.cfg')))
		{
			define(MX_TEMPLATE_CONFIG, true);
			$current_template_path = $this->current_template_path;
		}
		
		if ( !$mx_template_config && (@file_exists($phpbb_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg')))
		{
			define(MX_TEMPLATE_CONFIG, true);
			$default_template_path = $this->default_current_template_path;
		}		
		
		//
		// We have no template
		//
		if ( !$mx_template_config )
		{
			$mx_template_config = true;
			// Where are the phpbb images?
			$mx_images['mx_graphics']['phpbb_icons'] 	= !empty($current_template_path) && file_exists( $phpbb_root_path . $current_template_path . "/images" ) ? $current_template_path . "/images" : ( !empty($cloned_template_path) && file_exists( $phpbb_root_path . $cloned_template_path . "/images" ) ? $cloned_template_path . "/images" :  $default_template_path . "/images");
			$current_template_images 					= PORTAL_URL . $mx_images['mx_graphics']['general']; // Logo etc
			$current_template_page_images 				= PORTAL_URL . $mx_images['mx_graphics']['page_icons']; // Used by adminCP - Pages
			$current_template_block_images 				= PORTAL_URL . $mx_images['mx_graphics']['block_icons']; // Used by userCP block buttons
			$current_template_menu_images 				= PORTAL_URL . $mx_images['mx_graphics']['menu_icons']; // Used by adminCP - Navigation Menu
			$current_template_admin_images 				= PORTAL_URL . $mx_images['mx_graphics']['admin_icons']; // Internal graphics for the mxBB adminCP
			$current_template_theme_graphics 			= PORTAL_URL . $mx_images['mx_graphics']['theme_graphics']; // Internal graphics for the mxBB adminCP
			$current_template_phpbb_images 				= PHPBB_URL . $mx_images['mx_graphics']['phpbb_icons'];
			//mx_message_die(CRITICAL_ERROR, "Could not open " . $template_name . " template config file of module " . $mx_root_path . $module_root_path . $current_template_path . ".", '', __LINE__, __FILE__);
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
			
		unset($mx_images);	
	}
	
	function _load_module_lang($lang_mode = MX_LANG_MAIN)
	{	
		global $lang, $board_config, $mx_block, $phpEx, $mx_root_path;
		
		if (!isset($this->loaded_langs[$mx_block->module_root_path]))
		{
			if ($lang_mode == MX_LANG_MAIN || $lang_mode == MX_LANG_ALL)
			{
				// -------------------------------------------------------------------------
				// Read Module Main Language Definition
				// -------------------------------------------------------------------------
				if ( !file_exists( $mx_root_path . $mx_block->module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx ) )
				{
					include( $mx_root_path . $mx_block->module_root_path . 'language/lang_english/lang_main.' . $phpEx );
				}
				else
				{
					include( $mx_root_path . $mx_block->module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx );
				}
			}

			if ($lang_mode == MX_LANG_ADMIN || $lang_mode == MX_LANG_ALL)
			{			
				// -------------------------------------------------------------------------
				// Read Module Admin Language Definition
				// -------------------------------------------------------------------------
				if ( !file_exists( $mx_root_path . $mx_block->module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx ) )
				{
					include( $mx_root_path . $mx_block->module_root_path . 'language/lang_english/lang_admin.' . $phpEx );
				}
				else
				{
					include( $mx_root_path . $mx_block->module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx );
				}	
			}		
			 
			$this->loaded_langs[$mx_block->module_root_path] = '1';		
		}
	}
	
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
		}
	}	
		
	// ------------------------------
	// Public Methods
	//
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
		$this->_init_session($user_ip, $thispage_id);
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
	
	// -------------------------------------------------------------------------
	// Extend User Style with module lang and images
	// Usage:  $mx_user->extend(LANG, IMAGES)
	// Switches:
	// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL
	// - IMAGES: MX_IMAGES (default), MX_NO_IMAGES
	// -------------------------------------------------------------------------	
	function extend($lang_mode = MX_LANG_MAIN, $image_mode = MX_IMAGES)
	{
		if (defined('IN_ADMIN'))
		{
			return;
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
			$this->default_template_name = 'subSilver';
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