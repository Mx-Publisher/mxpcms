<?php
/**
*
* @package Style
* @version $Id: mx_functions_style.php,v 1.2 2009/01/24 16:47:51 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
*
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


//
// Include templating (XS style)
//
include_once($mx_root_path . 'includes/template.' . $phpEx);

/**
 * Class: mx_Template.
 *
 * The mx_Template class extends the native phpBB Template class, in reality only redefining the make_filename method.
 * Thus modded phpBB templates (eg eXtreme Styles MOD) will also be available for mxBB.
 *
 * @package Style
 * @author Markus, Jon Ohlsson
 * @access public
 */
class mx_Template extends Template
{	
	var $inherit_root = '';
	var $css_style_include = array();
	var $css_include = array();
	var $js_include = array();		

	var	$cloned_template_name = 'subSilver';
	var	$default_template_name = 'subsilver2';
	
	var $template_path = 'templates/';
	var $style_path = 'templates/';	
	
	var $debug_paths;	
	
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
		
		if (empty($this->template_path))
		{
			$this->template_path = $this->style_path;
		}
		
		if (empty($this->style_path))
		{
			$this->style_path = $this->template_path;
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
		$this->styles_path = $mx_root_path . $this->template_path;
		
		//
		// Also search for "the other" file extension
		//
		$filename = substr_count($filename, 'tpl') ? str_replace(".tpl", ".html", $filename) : str_replace(".html", ".tpl", $filename);
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
		// Look for new template files at MX-Publisher-Module folder.........................................................................MX-Publisher-module
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
			$fileSearch[] = $style_path  . '/template'; // First check current template
			$fileSearch[] = $mx_user->cloned_template_name . '/template'; // Then check Cloned template
			$fileSearch[] = $moduleDefault . '/template'; // Finally check Default template
			$fileSearch[] = './'; // Compatibility with primitive modules

			$temppath = $this->doFileSearch($fileSearch, $filename2, $filename, 'templates/', $module_root_path);
			if (!empty($this->module_template_path))
			{
				return $temppath;
			}
		}		
		
		//
		// Look at Root folder
		//		
		if (!empty($phpbb_root_path))
		{				
			$moduleDefault = $this->default_template_name;
			
			
			$this->debug_paths .= '<br>xs_mod';
			$fileSearch = array();
			$fileSearch[] = 'tpl';
			$fileSearch[] = $this->tpldir;			
			//$fileSearch[] = $style_path; // First check current template
			//$fileSearch[] = $this->cloned_template_name; // Then check Cloned template
			//$fileSearch[] = $moduleDefault; // Finally check Default template
			$fileSearch[] = './'; // Compatibility with primitive modules

			$temppath = $this->doFileSearch($fileSearch, $filename, $filename2, 'xs_mod/', $phpbb_root_path);
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
		// Look at MX-Publisher-Root folder.........................................................................MX-Publisher-Root
		//
		$this->debug_paths .= '<br>CORE';
		$fileSearch = array();
		$fileSearch[] = $style_path . '/template'; // First check current template
		$fileSearch[] = $mx_user->cloned_template_name . '/template'; // Then check Cloned template
		$fileSearch[] = $mx_user->default_template_name . '/template'; // Then check Default template
		$fileSearch[] = './';

		$temppath = $this->doFileSearch($fileSearch, $filename2, $filename, 'templates/', $mx_root_path);
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
		// Look at phpBB for new styles
		//
		if (!empty($phpbb_root_path))
		{				
			$moduleDefault = $this->default_template_name;
			
			
			$this->debug_paths .= '<br>phpbb';
			$fileSearch = array();
			$fileSearch[] = $style_path . '/template'; // First check current template
			$fileSearch[] = $mx_user->cloned_template_name . '/template'; // Then check Cloned template
			$fileSearch[] = $moduleDefault . '/template'; // Finally check Default template
			$fileSearch[] = './'; // Compatibility with primitive modules

			$temppath = $this->doFileSearch($fileSearch, $filename2, $filename, 'templates/', $phpbb_root_path);
			if (!empty($this->module_template_path))
			{
				return $temppath;
			}
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

/**#@+
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
\** **/
define('MX_LANG_MAIN'	, 10);
define('MX_LANG_ADMIN'	, 20);
define('MX_LANG_ALL'	, 30);
define('MX_LANG_NONE'	, 40);
define('MX_IMAGES'		, 50);
define('MX_IMAGES_NONE'	, 60);
define('MX_LANG_CUSTOM'	, 70);
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
	
	var $lang_path = 'language/';
	var $template_path = 'templates/';
	var $styles_path = 'templates/';

	var $template_name = '';
	var $template_names = array();
	var $current_template_path = ''; 
	
	/**
	 * @var string	ISO code of the default board language
	 */
	protected $default_language;
	protected $default_language_name;
	/**
	 * @var string	ISO code of the User's language
	 */
	protected $user_language;
	protected $user_language_name;
	
	var $lang;		
	var $lang_iso = 'en';		
	var $lang_dir = 'lang_english';
	
	var $img_lang_dir = 'en';
	var $lang_english_name = 'English';		
	var $lang_local_name = 'English United Kingdom';	
	var $language_list = array();
	
	/**** /
	var	$cloned_template_name = 'subSilver';
	var	$default_template_name = 'subsilver2';
	
	var $cloned_current_template_name = 'prosilver';
	var $default_current_template_name = '';	
	
	var $cloned_current_template_path = 'templates/subSilver';
	var $default_current_template_path = 'templates/subsilver2';
	/****/
	
	var $block_border_graphics = '';
	
	var $parent_template_name = '';
	var $parent_template_path = '';	
	
	var $cloned_template_name = '';
	var $cloned_current_template_path = '';

	var $default_template_name = 'subSilver';
	var $default_current_template_path = '';

	var $imageset_path = '/theme/images/';	
	var $img_array = array();
	var $images;
	
	var $default_module_style = '';

	var $module_lang_path = array();
	
	var $style = array();
	var $theme = array();
	
	// Able to add new options (up to id 31)
	var $keyoptions = array('viewimg' => 0, 'viewflash' => 1, 'viewsmilies' => 2, 'viewsigs' => 3, 'viewavatars' => 4, 'viewcensors' => 5, 'attachsig' => 6, 'bbcode' => 8, 'smilies' => 9, 'sig_bbcode' => 15, 'sig_smilies' => 16, 'sig_links' => 17);
	
	var $is_admin = false;
	
	var $page_id = '';
	var $user_ip = '';

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;
	/** @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\db\driver\driver_interface */
	protected $db; 

	var $cookie_data = array();
	var $page = array();
	var $data = array(); // For future Olympus comp.
	var $service_providers; // For future Ascraeus comp.
	var $browser = '';
	var $forwarded_for = '';
	var $host = '';
	var $session_id = '';
	var $ip = '';
	var $datetime = '';
	var $load = 0;
	var $time_now = 0;
	var $update_session_page = true;
	
	//var  $phpbb_root_path;	
	//var  $mx_root_path;		
	/**#@-*/

	// ------------------------------
	// Properties
	//

	// ------------------------------
	// Constructor
	//
	/**
	 * Load sessions
	 * @access public
	 *
	 */	
	function mx_user()
	{
		global $mx_cache, $board_config, $db, $phpbb_root_path, $mx_root_path, $phpEx;
 		
		$this->cache = $mx_cache;
		$this->config = $board_config;
		$this->db = $db;
		$this->user = $this;
		$this->service_providers = array('user_id'	=> 1, 'session_id'	=> 0, 'provider'	=> '', 'oauth_token' => '');		
		$this->phpbb_root_path = $phpbb_root_path;	
		$this->mx_root_path = $mx_root_path;			
		$this->php_ext = $phpEx;

		
		$this->lang_path = $mx_root_path . 'language/';
	}
	/**
	 * Load sessions
	 * @access public
	 *
	 */
	 
	// ------------------------------
	// Private Methods
	//
	/**
	 * Load sessions
	 * @access public
	 *
	 * /
	function load()
	{
		if (!isset($user_ip)) 
		{
			global $user_ip;
		
			$this->user_ip = $user_ip;
		}		
		
		if (!isset($page_id)) 
		{
			global $mx_request_vars;

			$this->page_id = $mx_request_vars->request('page', MX_TYPE_INT, 1);
		}	
		
		//
		// Populate user data
		//			
		$this->data = $this->session_pagestart($this->user_ip, $this->page_id);
		
		if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) 
		{
		    $this->data['is_bot'] = true;
		}
		else
		{
		    $this->data['is_bot'] = false;
		}
		
		$this->data['user_topic_sortby_type'] = 't';
		$this->data['user_topic_sortby_dir'] = 'd';
		$this->data['user_topic_show_days'] = 0;

		$this->data['user_post_sortby_type'] = 't';
		$this->data['user_post_sortby_dir'] = 'a';
		$this->data['user_post_show_days'] = 0;

		
		$this->data['user_form_salt'] = bin2hex(random_bytes(8));
		
		//
		// Populate session_id
		//
		$this->session_id = $this->data['session_id'];
	}
	/**
	 * Load sessions
	 * @access public
	 *
	 */	
	
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
		global $userdata;
		$this->mx_session_begin();		
		$this->data = $userdata; //for compatibility with Olympus style modules
		
		// Give us some basic information
		//$this->time_now		= time();
		
		//$this->browser			= $_SERVER['HTTP_USER_AGENT'];
		//$this->referer			= $_SERVER['Referer'];
		//$this->forwarded_for		= $_SERVER['X-Forwarded-For'];

		//$this->host			= extract_current_hostname();
		//$this->page			= extract_current_page($mx_root_path);		
				
		$this->is_admin = $this->data['user_level'] == ADMIN && $this->data['session_logged_in'];
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
		$this->_init_session($user_ip, $page_id);
		$this->_init_userprefs();

		//
		// Inititate User style
		//
		if ($init_style)
		{
			$this->_init_style();
		}
	}	
	// ------------------------------
	// Public Methods
	//

	/**
	 * Init userprefs.
	 *
	 * Initialise user settings on page load.
	 * - populate $lang, $theme, $images and initiate $template
	 *
	 * @access private
	 */
	function _init_userprefs($lang_set = false)
	{
		global $mx_cache, $mx_user, $userdata, $board_config, $portal_config, $theme, $images;
		global $template, $lang, $phpEx, $phpbb_root_path, $mx_root_path, $db;
		global $phpBB2, $phpBB3, $nav_links;
		
		$this->data = !empty($this->data['user_id']) ? $this->data : session_pagestart($this->user_ip, $this->page_id);
		
		$this->cache = is_object($mx_cache) ? $mx_cache : new mx_cache();
		
		if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) 
		{
		    $this->data['is_bot'] = true;
		}
		else
		{
		    $this->data['is_bot'] = false;
		}

		//
		// Populate session_id
		//
		$this->session_id = $this->data['session_id'];
		
		$this->lang_path = $mx_root_path . 'language/';
		
		$lang_set = !$lang_set ? (defined('IN_ADMIN') ? 'lang_admin' : 'lang_main') : $lang_set;		
	
		//
		// Send a proper content-language to the output
		//
		$img_lang = $board_config['default_lang'];		
		
		//
		// Clean up and ensure we are using mxp internal (long) lang format
		//
		$board_config['phpbb_lang'] = $board_config['default_lang']; // Handy switch
		$this->lang['default_lang'] = $phpBB2->phpbb_ltrim(basename($phpBB2->phpbb_rtrim($this->decode_lang($board_config['default_lang']))), "'");
		$this->data['user_lang'] = $phpBB2->phpbb_ltrim(basename($phpBB2->phpbb_rtrim($this->decode_lang($this->data['user_lang']))), "'");
		
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
			$this->lang['default_lang'] = ((file_exists($mx_root_path . 'language/lang_' . $this->decode_lang(strval($phpBB2->request_var('lang', ''))) . "/lang_main.$phpEx")) ? strval($phpBB2->request_var('lang', '')) : ((file_exists($mx_root_path . 'language/lang_' . strval($phpBB2->request_var('lang', '')) . "/lang_main.$phpEx")) ? strval($phpBB2->request_var('lang', '')) : $this->lang['default_lang']));			
		}
		
		// Now, $this->lang['default_lang'] is populated, but do we have a mathing MX-Publisher lang file installed?
		if ( !file_exists($phpBB2->phpbb_realpath($mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx)) )
		{
			// If not, try english (desperate try)
			$this->lang['default_lang'] = 'english';

			if ( !file_exists($phpBB2->phpbb_realpath($mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not locate valid language pack: ' . $mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx);
			}
		}

		// If we've had to change the value in any way then let's write it back to the database
		// before we go any further since it means there is something wrong with it
		if ($this->data['session_logged_in'] && $this->data['user_lang'] !== $this->lang['default_lang'])
		{
			$sql = 'UPDATE ' . USERS_TABLE . "
				SET user_lang = '" . $this->encode_lang($this->lang['default_lang']) . "'
				WHERE user_lang = '" . $this->encode_lang($this->data['user_lang']) . "'";
			if ( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not update user language info');
			}

			$userdata['user_lang'] = $this->lang['default_lang'];
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
		
		$board_config['default_lang'] = $this->lang['default_lang'];

		$this->lang_name = $this->lang['default_lang'] = $this->lang['default_lang'];
		$this->lang_path = 'language/lang_' . $this->lang_name . '/';


		/*
		* Load MXP lang keys
		*/
		//Load vanilla phpBB2 lang files if is possible
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
				$shared_lang_path = $phpbb_root_path . 'includes/shared/phpbb2/language/';
				//$template_path = 'styles/';
			break;			
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
			case 'proteus':			
				$shared_lang_path = $phpbb_root_path . 'includes/shared/phpbb2/language/';
				//$template_path = 'styles/';
			break;
				
			case 'phpbb2':	
				$shared_lang_path = $phpbb_root_path . 'language/';
			break;
		}
		
		// 
		//
		// We include common language file here to not load it every time a custom language file is included
		//
		//$lang = &$this->lang;
		
		//
		// We setup common user language variables
		//
		//$this->lang = &$lang;
		
		/** Sort of pointless here, since we have already included all main lang files **/
		//this will fix the path for anonymouse users
		if ((@include $mx_root_path . $this->lang_path . "lang_main.$phpEx") === false)
		{
			echo('<br />');
			echo(filesize($mx_root_path . $this->lang_path . "lang_main.$phpEx") . '');
			echo('<br />');			
			die('Language file <a class="textbutton" href="' . $mx_root_path . $this->lang_path . 'lang_main.' . $phpEx . '"><span>' . $mx_root_path . $this->lang_path . "lang_main.$phpEx" . '</span></a>' . ' couldn\'t be opened.');
		}
		
		//$this->lang = &$lang;	
		
		// Shared phpBB keys
		if ((@include $shared_lang_path . "lang_" . $this->lang_name . "/lang_main.$phpEx") === false)
		{
			if ((@include $shared_lang_path . "lang_english/lang_main.$phpEx") === false)
			{
				mx_message_die(GENERAL_ERROR, 'Language file ' . $shared_lang_path . "lang_" . $this->lang_name . "/lang_main.$phpEx" . ' couldn\'t be opened.');
			}
		}			
		
		//$this->lang = &$lang;	
		
		$this->add_lang($lang_set);
		
		unset($lang_set);
			
		if (defined('IN_ADMIN'))
		{
			if(!file_exists(@phpbb_realpath($mx_root_path . 'language/lang_' . $this->lang_name . '/lang_admin.'.$phpEx)))
			{
				$board_config['default_lang'] = 'english';
			}

			include($mx_root_path . 'language/lang_' . $this->lang_name . '/lang_admin.' . $phpEx);
			
			$this->lang = &$lang;			
			
			// Shared phpBB keys
			if ((include $shared_lang_path . "lang_" . $this->lang_name . "/lang_admin.$phpEx") === false)
			{
				if ((@include $shared_lang_path . "lang_english/lang_admin.$phpEx") === false)
				{
					mx_message_die(GENERAL_ERROR, 'Language file ' . $shared_lang_path . "lang_" . $this->lang_name . "/lang_admin.$phpEx" . ' couldn\'t be opened.');
				}
			}				
		}
		
		// 
		//
		// We include common language file here to not load it every time a custom language file is included
		//
		//$lang = &$this->lang;
		$this->lang = &$lang;
		$this->user_lang = !empty($this->lang['USER_LANG']) ? $this->lang['USER_LANG'] : $this->encode_lang($this->lang_name);
		$user_lang = $this->user_lang;
		
		$this->user_language		= $this->encode_lang($this->lang_name);
		$this->default_language		= $this->encode_lang($board_config['default_lang']);
		
		$this->user_language_name		= $this->decode_lang($this->lang_name);
		$this->default_language_name	= $this->decode_lang($board_config['default_lang']);
		
		$counter = 0; //First language pack lang_id		
		$lang_ids = array();
		
		$lang_list = $this->get_lang_list();	
		
		if (is_array($lang_list))
		{		
			foreach ($lang_list as $lang_english_name => $lang_local_name)
			{
				$lang_ids[$lang_english_name] = $counter;
				$counter++;	
			}	
		}	
		
		$lang_entries = array(
			'lang_id' => !empty($lang_ids['lang_' . $this->user_language_name]) ? $lang_ids['lang_' . $this->user_language_name] : $counter,
			'lang_iso' => !empty($lang['USER_LANG']) ? $lang['USER_LANG'] : $this->encode_lang($this->lang_name),
			'lang_dir' => 'lang_' . $this->lang_name,
			'lang_english_name' => $this->user_language_name,
			'lang_local_name' => $this->ucstrreplace('lang_', '', $this->lang_name),
			'lang_author' => !empty($lang['TRANSLATION_INFO']) ? $lang['TRANSLATION_INFO'] : 'Language pack author not set in ACP.'
		);
		
		//
		// Finishing setting language variables to ouput
		//
		$this->lang_iso = $lang_iso = $lang_entries['lang_iso'];		
		$this->lang_dir = $lang_dir = $lang_entries['lang_dir'];
		$this->lang_english_name = $lang_english_name = $lang_entries['lang_english_name'];
				
		if(file_exists(@phpbb_realpath($phpbb_root_path . $this->lang_path . '/common.'.$phpEx)))
		{
			//$this->set_lang($this->lang, $this->help, 'common');
			
			//this will fix the path for anonymouse users
			if ((@include $phpbb_root_path . $this->lang_path . '/common.'.$phpEx) === false)
			{
				die('Language file (_init_userprefs) ' . $phpbb_root_path . $this->lang_path . '/common.'.$phpEx . ' couldn\'t be opened by _init_userprefs().');
			}			
		}		
		
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
		
		$this->nav_links = $nav_links;
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
		global $mx_page;

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
					setcookie('demo_theme', $style, (time() + 21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
					return;
				}
		}

		//
		// Setup style
		//
		if ( !$init_override )
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

		$style = isset($_POST['default_style']) ? intval($_POST['default_style']) : $init_style;
		$theme = $this->_setup_style($style);

		return;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $style
	 * @return unknown
	 */
	function _style_query($style = true)
	{
		global $db, $board_config, $portal_config, $template, $phpbb_root_path, $mx_root_path;
		
		global $mx_request_vars, $theme;				
		
		//
		// Set up style to output
		//
		if ($this->data['user_id'] == ANONYMOUS && empty($this->data['user_style']))
		{
			$this->data['user_style'] = $board_config['default_style'];
		}
			
		$style_request = $mx_request_vars->request('style', 0);
			
		if ($style_request && (!$board_config['override_user_style'] || !defined('IN_ADMIN')))
		{
			global $SID, $_EXTRA_URL;

			$style = $style_request;
			$SID .= '&amp;style=' . $style;
			$_EXTRA_URL = array('style=' . $style);
		}
		else
		{
			// Set up style
			$style = ($style) ? $style : ((!$board_config['override_user_style']) ? $this->data['user_style'] : $board_config['default_style']);
		}		
		
		// END Styles_Demo MOD 
		if (intval($style) == 0)
		{
			//Query MX style_name
			$sql_and = "s.template_name = $style";								
		}
		else  
		{		
			//Query MX themes_id
			$sql_and = "s.themes_id = " . (int) $style;								
		}				
		$sql = "SELECT s.*, mxt.*, mxt.template_name as style_path
			FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " s
				WHERE mxt.template_name = s.template_name
				AND " . $sql_and;			
		if (!$result = $db->sql_query_limit($sql, 1))
		{
			mx_message_die(CRITICAL_ERROR, "Could not query database for theme info '$style_id'", '', __LINE__, __FILE__, $sql);
		}
		
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		//
		$style_value = $row['style_name'];
		//
		
		return $row;
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
		
		global $mx_request_vars, $images, $theme;

		$row = false;
		//
		// Are we trying a userstyle?
		//
		if ($user_style)
		{
			$row = $this->style = $this->theme = $theme = $this->_style_query($user_style);
		}

		//
		// ...or a Custom Page/AdminCP Style
		//
		if (!$row)
		{
			$row = $this->style = $this->theme = $theme = $this->_style_query($init_style);
		}

		//
		// Seems like we need to try the default style
		//
		if (!$row)
		{
			$row = $this->style = $this->theme = $theme = $this->_style_query($portal_config['default_style']);
		}

		//
		// Last desperate try...
		//
		if (!$row)
		{
			//
			// Set up style to output
			//
			if ($this->data['user_id'] == ANONYMOUS && empty($this->data['user_style']))
			{
				$this->data['user_style'] = $board_config['default_style'];
			}
			
			$style_request = $mx_request_vars->request('style', 0);
			
			if ($style_request && (!$board_config['override_user_style'] || !defined('IN_ADMIN')))
			{
				global $SID, $_EXTRA_URL;

				$init_style = $style_request;
				$SID .= '&amp;style=' . $init_style;
				$_EXTRA_URL = array('style=' . $init_style);
			}
			else
			{
				// Set up style
				$init_style = ($init_style) ? $init_style : ((!$board_config['override_user_style']) ? $this->data['user_style'] : $board_config['default_style']);
			}
			
			$sql = "SELECT s.*, mxt.*, mxt.template_name as style_path
				FROM " . MX_THEMES_TABLE . " AS mxt, " . THEMES_TABLE . " AS s
				WHERE s.themes_id = " . (int) $init_style . "
					AND s.template_name = mxt.template_name";	
			$result = $db->sql_query($sql, 3600);
			$row = $this->style = $this->theme = $theme = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			
			/** Fallback to user's standard style **/
			if (!$this->style && $init_style != $this->data['user_style'])
			{
				$init_style = $this->data['user_style'];

			$sql = "SELECT s.*, mxt.*, mxt.template_name as style_path
				FROM " . MX_THEMES_TABLE . " AS mxt, " . THEMES_TABLE . " AS s
				WHERE s.themes_id = " . (int) $init_style . "
					AND s.template_name = mxt.template_name";	
				$result = $db->sql_query($sql, 3600);
				$row = $this->style = $this->theme = $theme = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
			}
			/** Fallback to user's standard style **/
			if (!$row)
			{
				$row = setup_style($init_style);
				
				mx_message_die(CRITICAL_ERROR, "Could not query database for phpbb_styles info [$init_style]", "", __LINE__, __FILE__, $sql);
			}
			
			$this->template_name = $row['template_name'];
				
			// We are trying to setup a style which does not exist in the database
			// Try to fallback to the board default (if the user had a custom style)
			// and then any users using this style to the default if it succeeds
			if ($row['themes_id'] != $board_config['default_style'])
			{					
				$sql = 'SELECT template_name
						FROM ' . THEMES_TABLE . '
						WHERE themes_id = ' . (int) $board_config['default_style'];
				
				if ($row = $db->sql_fetchrow($result = $db->sql_query($sql)))
				{
					$db->sql_freeresult($result);
					$this->default_current_template_name = !empty($row['template_name']) ? $row['template_name'] : $this->default_current_template_name;
				}				
			}
			$db->sql_freeresult($result);
		}
		
		if (!$this->style)
		{				
			mx_message_die(CRITICAL_ERROR, "Could not query database for phpbb_styles info [$init_style]", "", __LINE__, __FILE__, $sql);
		}		
		
		//
		// Init class settings
		//
		$this->template_name = $row['template_name'];
		$style = $this->style['themes_id'];
		
		$style_value = $this->style['style_name'];
				
		$this->current_template_path = $this->template_path . $this->template_name;
		$this->default_current_template_path = $this->template_path . $this->default_template_name;
		
		//
		// Load template settings
		// - pass cloned template name to $theme
		//
		$template_config_row = $this->_load_template_config();

		$this->style['template_copy'] = $template_config_row['template_copy'];
		$this->style['cloned_template_name'] = $template_config_row['cloned_template'];
		$this->style['border_graphics'] = $template_config_row['border_graphics'];

		$this->style['style_copy'] = $template_config_row['template_copy'];
		$this->style['head_stylesheet'] = !empty($this->style['head_stylesheet']) ? $this->style['head_stylesheet'] : $this->style['style_path'] . '.css';
		
		$this->style['body_background'] = $this->theme['body_background'] = !empty($this->theme['body_background']) ? $this->theme['body_background'] : '';
		$this->style['border_graphics'] = $this->theme['border_graphics'] = !empty($this->theme['border_graphics']) ? $this->theme['border_graphics'] : '';
		
		$this->block_border_graphics =  $this->style['border_graphics'];		
		
		$this->cloned_template_name = !empty($this->style['cloned_template_name']) ? $this->style['cloned_template_name'] : 'prosilver2';
		$this->cloned_current_template_path = !empty($this->cloned_template_name) ? $this->template_path . $this->cloned_template_name : '';
		
		/** Setup cloned template as prosilver based for phpBB3 styles **/	//todo@ if is file .cfg at mxp	
		if( @file_exists(@phpbb_realpath($phpbb_root_path . $this->template_path . $this->template_name . '/style.cfg')) )
		{
			$cfg = parse_cfg_file($phpbb_root_path . $this->template_path . $this->template_name . '/style.cfg');
			$this->parent_template_name = !empty($cfg['parent']) ? $cfg['parent'] : 'prosilver';
			$this->parent_template_path = $this->template_path . $this->parent_template_name;
		}
		/** **/
		//
		// What template to use?
		//
		$template = new mx_Template($mx_root_path . $this->template_path . $this->template_name);
		@define('IP_ROOT_PATH', $this->phpbb_root_path); //for ICY-PHOENIX Styles
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
		$this->cloned_style_phpbb_path = !empty($this->cloned_template_name) ? $this->template_path . $this->cloned_template_name : ''; //new
			
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

		}
		
		//
		// Load mxBB Template configuration data
		//		
		if( @file_exists(@phpbb_realpath($mx_root_path . $this->template_path . $this->template_name . '/' . $this->template_name . '.cfg')) )
		{
			@include($mx_root_path . $this->template_path . $this->template_name . '/' . $this->template_name . '.cfg');

		}
		
		if ( !$mx_template_config )
		{
			mx_message_die(CRITICAL_ERROR, "Could not open mxBB $this->template_name template config file", '', __LINE__, __FILE__);
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
		
		$style_found = ''; //default
		
		//
		// Load phpBB Template configuration data
		// - First try current template
		//
		if (is_dir($phpbb_root_path . $this->current_template_path . "/images/") || is_dir($phpbb_root_path . $this->current_template_path . "/theme/images/"))
		{
			$current_template_path = $this->current_template_path;
			$template_name = $this->template_name;			
			
			$style_found = '_'; //default
		}
		
		//
		// Since we have no current Template Config file, try the cloned template instead
		//
		if ((is_dir($phpbb_root_path . $this->cloned_current_template_path . "/images/") || is_dir($phpbb_root_path . $this->cloned_current_template_path . "/theme/images/")) && empty($style_found) )
		{
			$current_template_path = $this->cloned_current_template_path;
			$template_name = $this->cloned_template_name;
			
			$style_found = 'cloned_'; //default	
		}

		//
		// Last attempt, use default template intead
		//
		if ((is_dir($phpbb_root_path . $this->default_current_template_path . "/images/") || is_dir($phpbb_root_path . $this->default_current_template_path . "/theme/images/")) && empty($style_found) )		
		{
			$current_template_path = $this->default_current_template_path;
			$template_name = $this->default_template_name;
			
			$style_found = 'default_'; //default			
		}		
			
		if(is_dir($phpbb_root_path . $current_template_path . '/theme/images/'))
		{
			$current_template_images = $this->current_template_images = $current_template_path . "/theme/images";						
		}
		elseif(is_dir($phpbb_root_path . $this->current_template_path . '/images/'))
		{
			$current_template_images = $this->current_template_images = $current_template_path . "/images";					
		}		
		
		//
		// Try phpBB2 then phpBB3 style configuration file
		//		
		if(@file_exists(@phpbb_realpath($phpbb_root_path . $current_template_path . '/' . $template_name . '.cfg')) )
		{
			include($phpbb_root_path . $current_template_path . '/' . $template_name . '.cfg');
				
			if (!defined('TEMPLATE_CONFIG'))
			{
				//
				// Do not alter this line!
				//
				@define(TEMPLATE_CONFIG, TRUE);					
			}
			
		}			
		elseif( @file_exists(@phpbb_realpath($phpbb_root_path . $current_template_path . "/style.cfg")) )
		{
			//
			// Do not alter this line!
			//
			@define(TEMPLATE_CONFIG, TRUE);
			
			//		
			// - First try phpBB2 then phpBB3 template lang images then old Olympus image sets
			//		
			if ( file_exists($phpbb_root_path . $current_template_path . '/images/') )
			{
				$this->current_template_images = $current_template_path . '/images';
			}		
			else if ( file_exists($phpbb_root_path . $current_template_path  . '/theme/images/') )
			{		
				$this->current_template_images = $current_template_path  . '/theme/images';
			}		
			if ( file_exists($phpbb_root_path . $current_template_path  . '/imageset/') )
			{		
				$this->current_template_images = $current_template_path  . '/imageset';
			}
				
			$current_template_images = $this->current_template_images;
				
			$images['icon_quote'] = "$current_template_images/{LANG}/" . $this->img('icon_post_quote.gif', '', '', '', 'filename');
			$images['icon_edit'] = "$current_template_images/{LANG}/" . $this->img('icon_post_edit.gif', '', '', '', 'filename');			
			$images['icon_search'] = "$current_template_images/{LANG}/" . $this->img('icon_user_search.gif', '', '', '', 'filename');
			$images['icon_profile'] = "$current_template_images/{LANG}/" . $this->img('icon_user_profile.gif', '', '', '', 'filename');
			$images['icon_pm'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_pm.gif', '', '', '', 'filename');
			$images['icon_email'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_email.gif', '', '', '', 'filename');
			$images['icon_delpost'] = "$current_template_images/{LANG}/" . $this->img('icon_post_delete.gif', '', '', '', 'filename');
			$images['icon_ip'] = "$current_template_images/{LANG}/" . $this->img('icon_user_ip.gif', '', '', '', 'filename');
			$images['icon_www'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_www.gif', '', '', '', 'filename');
			$images['icon_icq'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_icq_add.gif', '', '', '', 'filename');
			$images['icon_aim'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_aim.gif', '', '', '', 'filename');
			$images['icon_yim'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_yim.gif', '', '', '', 'filename');
			$images['icon_msnm'] = "$current_template_images/{LANG}/" . $this->img('icon_contact_msnm.gif', '', '', '', 'filename');
			$images['icon_minipost'] = "$current_template_images/" . $this->img('icon_post_target.gif', '', '', '', 'filename');
			$images['icon_gotopost'] = "$current_template_images/" . $this->img('icon_gotopost.gif', '', '', '', 'filename');
			$images['icon_minipost_new'] = "$current_template_images/" . $this->img('icon_post_target_unread.gif', '', '', '', 'filename');
			$images['icon_latest_reply'] = "$current_template_images/" . $this->img('icon_latest_reply.gif', '', '', '', 'filename');
			$images['icon_newest_reply'] = "$current_template_images/" . $this->img('icon_newest_reply.gif', '', '', '', 'filename');

			$images['forum'] = "$current_template_images/" . $this->img('forum_read.gif', '', '27', '', 'filename');
			$images['forum_new'] = "$current_template_images/" . $this->img('forum_unread.gif', '', '', '', 'filename');
			$images['forum_locked'] = "$current_template_images/" . $this->img('forum_read_locked.gif', '', '', '', 'filename');

			// Begin Simple Subforums MOD
			$images['forums'] = "$current_template_images/" . $this->img('forum_read_subforum.gif', '', '', '', 'filename');
			$images['forums_new'] = "$current_template_images/" . $this->img('forum_unread_subforum.gif', '', '', '', 'filename');
			// End Simple Subforums MOD

			$images['folder'] = "$current_template_images/" . $this->img('topic_read.gif', '', '', '', 'filename');
			$images['folder_new'] = "$current_template_images/" . $this->img('topic_unread.gif', '', '', '', 'filename');
			$images['folder_hot'] = "$current_template_images/" . $this->img('topic_read_hot.gif', '', '', '', 'filename');
			$images['folder_hot_new'] = "$current_template_images/" . $this->img('topic_unread_hot.gif', '', '', '', 'filename');
			$images['folder_locked'] = "$current_template_images/" . $this->img('topic_read_locked.gif', '', '', '', 'filename');
			$images['folder_locked_new'] = "$current_template_images/" . $this->img('topic_unread_locked.gif', '', '', '', 'filename');
			$images['folder_sticky'] = "$current_template_images/" . $this->img('topic_read_mine.gif', '', '', '', 'filename');
			$images['folder_sticky_new'] = "$current_template_images/" . $this->img('topic_unread_mine.gif', '', '', '', 'filename');
			$images['folder_announce'] = "$current_template_images/" . $this->img('announce_read.gif', '', '', '', 'filename');
			$images['folder_announce_new'] = "$current_template_images/" . $this->img('announce_unread.gif', '', '', '', 'filename');

			$images['post_new'] = "$current_template_images/{LANG}/" . $this->img('button_topic_new.gif', '', '', '', 'filename');
			$images['post_locked'] = "$current_template_images/{LANG}/" . $this->img('button_topic_locked.gif', '', '', '', 'filename');
			$images['reply_new'] = "$current_template_images/{LANG}/" . $this->img('button_topic_reply.gif', '', '', '', 'filename');
			$images['reply_locked'] = "$current_template_images/{LANG}/" . $this->img('icon_post_target_unread.gif', '', '', '', 'filename');

			$images['pm_inbox'] = "$current_template_images/" . $this->img('msg_inbox.gif', '', '', '', 'filename');
			$images['pm_outbox'] = "$current_template_images/" . $this->img('msg_outbox.gif', '', '', '', 'filename');
			$images['pm_savebox'] = "$current_template_images/" . $this->img('msg_savebox.gif', '', '', '', 'filename');
			$images['pm_sentbox'] = "$current_template_images/" . $this->img('msg_sentbox.gif', '', '', '', 'filename');
			$images['pm_readmsg'] = "$current_template_images/" . $this->img('topic_read.gif', '', '', '', 'filename');
			$images['pm_unreadmsg'] = "$current_template_images/" . $this->img('topic_unread.gif', '', '', '', 'filename');
			$images['pm_replymsg'] = "$current_template_images/{LANG}/" . $this->img('reply.gif', '', '', '', 'filename');
			$images['pm_postmsg'] = "$current_template_images/{LANG}/" . $this->img('msg_newpost.gif', '', '', '', 'filename');
			$images['pm_quotemsg'] = "$current_template_images/{LANG}/" . $this->img('icon_quote.gif', '', '', '', 'filename');
			$images['pm_editmsg'] = "$current_template_images/{LANG}/" . $this->img('icon_edit.gif', '', '', '', 'filename');
			$images['pm_new_msg'] = "";
			$images['pm_no_new_msg'] = "";

			$images['Topic_watch'] = "";
			$images['topic_un_watch'] = "";
			$images['topic_mod_lock'] = "$current_template_images/" . $this->img('topic_lock.gif', '', '', '', 'filename');
			$images['topic_mod_unlock'] = "$current_template_images/" . $this->img('topic_unlock.gif', '', '', '', 'filename');
			$images['topic_mod_split'] = "$current_template_images/" . $this->img('topic_split.gif', '', '', '', 'filename');
			$images['topic_mod_move'] = "$current_template_images/" . $this->img('topic_move.gif', '', '', '', 'filename');
			$images['topic_mod_delete'] = "$current_template_images/" . $this->img('topic_delete.gif', '', '', '', 'filename');

			$images['voting_graphic'][0] = "$current_template_images/voting_bar.gif";
			$images['voting_graphic'][1] = "$current_template_images/voting_bar.gif";
			$images['voting_graphic'][2] = "$current_template_images/voting_bar.gif";
			$images['voting_graphic'][3] = "$current_template_images/voting_bar.gif";
			$images['voting_graphic'][4] = "$current_template_images/voting_bar.gif";
			
			@include($phpbb_root_path . $this->cloned_current_template_path . '/' . $this->cloned_template_name . '.cfg');

			//
			// Vote graphic length defines the maximum length of a vote result
			// graphic, ie. 100% = this length
			//
			$board_config['vote_graphic_length'] = 205;
			$board_config['privmsg_graphic_length'] = 175;			
		}
		else		
		{		
			if ((@include $phpbb_root_path . $this->template_path . "prosilver/prosilver.cfg") === false)
			{
				//mx_message_die(CRITICAL_ERROR, "Could not open phpBB $this->template_name template config file", '', __LINE__, __FILE__);
			}					
		}

		//
		// We have no template to use - die
		//
		if ( !defined('TEMPLATE_CONFIG') )
		{
			//
			// Load phpBB Template configuration data
			// - Last try current template
			//		
			if ((@include $phpbb_root_path . $this->template_path . $this->template_name . '/' . $this->template_name . '.cfg') === false)
			{
				mx_message_die(CRITICAL_ERROR, "Could not open phpBB $this->template_name template config file", '', __LINE__, __FILE__);
			}			
		}

		$parsed_array = $this->cache->get('_cfg_' . $this->template_path);

		if ($parsed_array === false)
		{
			$parsed_array = array();
		}	
		
		if( @file_exists(@phpbb_realpath($phpbb_root_path . $this->current_template_path . '/style.cfg')) )
		{
			//parse phpBB3 style cfg file
			$cfg_file_name = 'style.cfg';			
			$cfg_file = $phpbb_root_path . $this->current_template_path . '/style.cfg';
					
			if (!isset($parsed_array['filetime']) || (@filemtime($cfg_file) > $parsed_array['filetime']))
			{
				// Re-parse cfg file
				$parsed_array = parse_cfg_file($cfg_file);		
				$parsed_array['filetime'] = @filemtime($cfg_file);				
				$this->cache->put('_cfg_' . $this->template_path, $parsed_array);
			}							
		}
		else
		{	
			//parse phpBB2 style cfg file	
			$cfg_file_name = $this->template_name . '.cfg';
			$cfg_file = $phpbb_root_path . $this->current_template_path . '/' . $cfg_file_name;
			
			if (file_exists($phpbb_root_path .  $this->current_template_path . '/' . $cfg_file_name))
			{
				if (!isset($parsed_array['filetime']) || (@filemtime($cfg_file) > $parsed_array['filetime']))
				{				
					$parsed_array = parse_cfg_file($cfg_file);		
					$parsed_array['filetime'] = @filemtime($cfg_file);
					$this->cache->put('_cfg_' . $this->template_path, $parsed_array);				
				}
			}		
		}
		
		$check_for = array(
			'pagination_sep'    => (string) ', '
		);

		foreach ($check_for as $key => $default_value)
		{
			$this->style[$key] = (isset($parsed_array[$key])) ? $parsed_array[$key] : $default_value;
			$this->theme[$key] = (isset($parsed_array[$key])) ? $parsed_array[$key] : $default_value;
			settype($this->style[$key], gettype($default_value));
			settype($this->theme[$key], gettype($default_value));
			if (is_string($default_value))
			{
				$this->style[$key] = htmlspecialchars($this->style[$key]);
				$this->theme[$key] = htmlspecialchars($this->theme[$key]);
			}
		}
		
 		// If the style author specified the theme needs to be cached
		// (because of the used paths and variables) than make sure it is the case.
		// For example, if the theme uses language-specific images it needs to be stored in db.
		if (file_exists($phpbb_root_path . $this->template_path . $this->template_name . '/theme/stylesheet.css'))
		{
			//phpBB3 Style Sheet
			$theme_file = 'stylesheet.css'; 
			$css_file_path = $this->template_path . $this->template_name . '/theme/';
			$stylesheet = file_get_contents("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/stylesheet.css");
		}
		else
		{	
			//phpBB2 Style Sheet	
			$theme_file = !empty($this->theme['head_stylesheet']) ?  $this->theme['head_stylesheet'] : $this->template_name . '.css'; 
			$css_file_path = $this->template_path . $this->template_name . '/';
			if (file_exists($phpbb_root_path . $this->template_path . $this->template_name . '/' . $theme_file))
			{
				$stylesheet = file_get_contents("{$phpbb_root_path}{$this->template_path}{$this->template_name}/{$theme_file}");
			}		
		}		
		
		if (!empty($stylesheet))
		{			
			// Match CSS imports
			$matches = array();
			preg_match_all('/@import url\(["\'](.*)["\']\);/i', $stylesheet, $matches);
			
			if (sizeof($matches))
			{
				$content = '';
				foreach ($matches[0] as $idx => $match)
				{
					if ($content = @file_get_contents("{$phpbb_root_path}{$css_file_path}" . $matches[1][$idx]))
					{
						$content = trim($content);
					}
					else
					{
						$content = '';
					}
					$stylesheet = str_replace($match, $content, $stylesheet);
				}
				unset($content);
			}

			$stylesheet = str_replace('./', $css_file_path, $stylesheet);

			$theme_info = array(
				'theme_data'	=> $stylesheet,
				'theme_mtime'	=> time(),
				'theme_storedb'	=> 0
			);
			$theme_data = &$theme_info['theme_data'];
		}			
		
		//		
		// - First try old Olympus image sets then phpBB2  and phpBB3 Proteus template lang images 	
		//		
		if (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/imageset/"))
		{
			$this->imageset_path = '/imageset/'; //Olympus ImageSet
			$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . $this->imageset_path . $this->lang_iso)) ? $this->lang_iso : $this->default_language;
			$this->img_lang_dir = $this->img_lang;
			$this->imageset_backend = 'olympus';		
		}
		elseif (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/"))
		{
			$this->imageset_path = '/theme/images/';  //phpBB3 Images
			if ((@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/lang_{$this->user_language_name}")) || (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/lang_{$this->default_language_name}")))
			{
				$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . $this->imageset_path . 'lang_' . $this->user_language_name)) ? $this->user_language_name : $this->default_language_name;
				$this->img_lang_dir = 'lang_' . $this->img_lang;
				$this->imageset_backend = 'phpbb2';	
			}
			if ((@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/{$this->user_language}")) || (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/{$this->default_language}")))
			{
				$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . $this->imageset_path . $this->user_language_name)) ? $this->user_language : $this->default_language;
				$this->img_lang_dir = $this->img_lang;
				$this->imageset_backend = 'phpbb3';	
			}			
		}		
		elseif (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/images/"))
		{
			$this->imageset_path = '/images/';  //phpBB2 Images
			$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . $this->imageset_path . '/images/lang_' . $this->user_language_name)) ? $this->user_language_name : $this->default_language_name;
			$this->img_lang_dir = 'lang_' . $this->img_lang;
			$this->imageset_backend = 'phpbb2';	
		}
		
		//		
		// phpBB2 image sets main images
		//				
		$img_lang = ( file_exists($phpbb_root_path . $this->current_template_path . $this->img_lang_dir) ) ? $this->img_lang : $this->default_language_name;

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
		
		//		
		// Import phpBB Olympus image sets main images
		//		
		if (@file_exists("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}/imageset.cfg"))
		{		
			$cfg_data_imageset = parse_cfg_file("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}/imageset.cfg");
			
			foreach ($cfg_data_imageset as $image_name => $value)
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
					$row[] = array(
						'image_name'		=> (string) $image_name,
						'image_filename'	=> (string) $image_filename,
						'image_height'		=> (int) $image_height,
						'image_width'		=> (int) $image_width,
						'imageset_id'		=> (int) $style_id,
						'image_lang'		=> '',
					);
					
					if (!empty($row['image_lang']))
					{
						$localised_images = true;
					}					
					$row['image_filename'] = !empty($row['image_filename']) ? rawurlencode($row['image_filename']) : '';
					$row['image_name'] = !empty($row['image_name']) ? rawurlencode($row['image_name']) : '';
					$this->img_array[$row['image_name']] = $row;									
				}
			}		
		}
		
		//		
		// - Olympus image sets lolalised images	
		//		
		if (@file_exists("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}{$this->img_lang}/imageset.cfg"))
		{
			$cfg_data_imageset_data = parse_cfg_file("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}{$this->img_lang}/imageset.cfg");
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
					$row[] = array(
						'image_name'		=> (string) $image_name,
						'image_filename'	=> (string) $image_filename,
						'image_height'		=> (int) $image_height,
						'image_width'		=> (int) $image_width,
						'imageset_id'		=> !empty($this->theme['imageset_id']) ? (int) $this->theme['imageset_id'] : 0,
						'image_lang'		=> (string) $this->img_lang,
					);
					
					if (!empty($row['image_lang']))
					{
						$localised_images = true;
					}					
					$row['image_filename'] = !empty($row['image_filename']) ? rawurlencode($row['image_filename']) : '';
					$row['image_name'] = !empty($row['image_name']) ? rawurlencode($row['image_name']) : '';
					$this->img_array[$row['image_name']] = $row;									
				}
			}
		}
		
		//		
		// - Import phpBB phpBB3 Rhea and Proteus images 	
		//		
		if (empty($this->img_array))
		{
			/** 
				* Now check for the correct existance of all of the images into
				* each image of a prosilver based style. 			
			* /
			
			/* Here we overwrite phpBB images from the template db or configuration file  */		
			$rows = $this->image_rows($this->images);		
			
			foreach ($rows as $row)
			{
				$row['image_filename'] = rawurlencode($row['image_filename']);
				
				if(empty($row['image_name']))
				{
					//print_r('Your style configuration file has a typo! ');
					//print_r($row);
					$row['image_name'] = 'spacer.gif';
				}
							
				$this->img_array[$row['image_name']] = $row;				
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
		global $mx_block;

		//unset($GLOBALS['MX_TEMPLATE_CONFIG']);
		$mx_template_config = false;

		//
		// Load module cfg
		//
		$moduleCfgFile = str_replace('/', '', str_replace('modules/', '', $mx_block->module_root_path));

		//
		// Load mxBB Template configuration data
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
		if ( !$mx_template_config )
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
		if ( !$mx_template_config )
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
		if ( !$mx_template_config )
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
		$module_key = !empty($module_root_path) ? $module_root_path : 'subSilver';
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

		$default_lang = ($this->lang['default_lang']) ? $this->lang['default_lang'] : $board_config['default_lang'];

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