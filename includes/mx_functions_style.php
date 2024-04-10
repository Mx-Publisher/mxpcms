<?php
/**
*
* @package Style
* @version $Id: mx_functions_style.php,v 3.146 2024/04/10 06:94:17 orynider Exp $
* @copyright (c) 2002-2024 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
* @link https://github.com/Mx-Publisher/mxpcms/
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
	var $inherit_root = '';
	var $css_style_include = array();
	var $css_include = array();
	var $js_include = array();		

	var	$cloned_template_name = 'subSilver';
	var	$default_template_name = 'subsilver2';
	
	var $template_path = 'templates/';
	var $style_path = 'styles/';	
	
	var $debug_paths;	
	
	/**
	 * Constructor.
	 *
	 * Simply calling parent construtor.
	 * This is required. Reason is constructors have different method names.
	 *
	 * @access private
	 */
	function __construct($root = '.')
	{
		parent::init($root);

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
		// Look for template files at MX-Publisher-Module template folder.........................................................................MX-Publisher-module
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
			$fileSearch[] = $style_path  . ''; // First check current template
			$fileSearch[] = $mx_user->cloned_template_name . ''; // Then check Cloned template
			$fileSearch[] = $moduleDefault . ''; // Finally check Default template
			$fileSearch[] = './'; // Compatibility with primitive modules

			$temppath = $this->doFileSearch($fileSearch, $filename2, $filename, 'templates/', $module_root_path);
			if (!empty($this->module_template_path))
			{
				return $temppath;
			}
		}		
		
		//
		// Look for new template files at MX-Publisher-Module adm/style folder.........................................................................MX-Publisher-module
		//
		if (!empty($module_root_path) && (defined('IN_ADMIN')))	
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
			$fileSearch[] = ''; // First check default adm template			
			$fileSearch[] = $style_path  . ''; // First check current template
			$fileSearch[] = $mx_user->cloned_template_name . ''; // Then check Cloned template
			$fileSearch[] = $moduleDefault . ''; // Finally check Default template
			$fileSearch[] = './'; // Compatibility with primitive modules

			$temppath = $this->doFileSearch($fileSearch, $filename2, $filename, 'adm/style/', $module_root_path, true);
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
		// Look at Forums for new styles
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
				
				$fileSearch[] = $style_path . '/template'; // First check current template
				$fileSearch[] = $mx_user->cloned_template_name . '/template'; // Then check Cloned template
				$fileSearch[] = $mx_user->default_template_name . '/template'; // Then check Default template					
				$fileSearch[] = './';
				
				$temppath = $this->doFileSearch($fileSearch, $filename2, $filename, 'templates/', $phpbb_root_path, true);
				if (!empty($this->module_template_path))
				{
					return $temppath;
				}
			break;

			// Look at phpBB3-Root folder...
			case 'olympus':
				$this->debug_paths .= '<br>phpbb3';
				$fileSearch = array();
				$fileSearch[] = $style_path . '/' . 'template'; // First check current template
				$fileSearch[] = $mx_user->cloned_template_name . '/' . 'template'; // Then check Cloned template
				$fileSearch[] = $mx_user->default_template_name . '/' . 'template'; // Then check Default template
				$fileSearch[] = './';
				$temppath = $this->doFileSearch($fileSearch, $filename, $filename2, 'styles/', $phpbb_root_path, true);
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
			case 'proteus':	
			case 'phpbb3':
			case 'ascraeus':
			default:
				$this->debug_paths .= '<br>phpbb3';
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

				if(@is_file($root_path . $root . $path . '/' . $filename) )
				{
					$this->module_template_path = $root . $path . '/';
					return $root_path . $root . $path . '/' . $filename;
				}
				else if(@is_file($root . '/' . $filename) )
				{
					$this->module_template_path = $root . '/';
					return $root . '/' . $filename;
				}
				
				if ($check_file2 && @is_file($root_path . $root . $path . '/' . $filename2))
				{
					$this->module_template_path = $root . $path . '/';
					return $root_path . $root . $path . '/' . $filename2;
				}
				else if ($check_file2 && @is_file($root . '/' . $filename2))
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
		
		// Look at MX-Publisher-Module folder.........................................................................MX-Publisher-module
		if (!empty($module_root_path))
		{
			$this->module_template_path = '';
			$moduleDefault = !empty($mx_user->loaded_default_styles[$mx_block->module_root_path]) ? $mx_user->loaded_default_styles[$mx_block->module_root_path] : $mx_user->default_template_name;

			if (file_exists($module_root_path . 'templates/' . $style_path . '/') )
			{
				// First check current template
				$this->root = $module_root_path . 'templates/' . $style_path . '/';
				$this->module_template_path = 'templates/' . $style_path . '/';
			}
			else if( file_exists($module_root_path . 'templates/' . $mx_user->cloned_template_name . '/') && !empty($mx_user->cloned_template_name))
			{
				// Then check Cloned template
				$this->root = $module_root_path . 'templates/' . $mx_user->cloned_template_name . '/';
				$this->module_template_path = 'templates/' . $mx_user->cloned_template_name . '/';
			}
			else if( file_exists($module_root_path . 'templates/' . $moduleDefault . '/') )
			{
				// Then check default template
				$this->root = $module_root_path . 'templates/' . $moduleDefault . '/';
				$this->module_template_path = 'templates/' . $moduleDefault . '/';
			}
			else if( file_exists($module_root_path . 'templates/') )
			{
				// Finally check the template root (for compatibility with some old modules)
				$this->root = $module_root_path . 'templates/';
				$this->module_template_path = 'templates/';
			}

			if (!empty($this->module_template_path))
			{
				return '';
			}
		}
		
		// Look at MX-Publisher-Root folder.........................................................................MX-Publisher-Root
		if (file_exists($mx_root_path . 'templates/' . $style_path . '/'))
		{
			// First check current template
			$this->root = $mx_root_path . 'templates/' . $style_path . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $style_path . '_';
		}
		else if( file_exists($mx_root_path . 'templates/' . $mx_user->cloned_template_name . '/') && !empty($mx_user->cloned_template_name))
		{
			// Then check Cloned template
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
		// Look at Custom Root folder..............this is used my mx_mod installers too.......this does not use standard templates folders wich are set when the template was re-initialized and defined as custom var
		else if( file_exists( $this->root . '/') )
		{
			$this->root =  $this->root . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $this->root . '_';
		}
		else if( file_exists($this->root . '/' . $style_path . '/') )
		{
			// First check current template
			$this->root = $this->root . '/' . $style_path . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $style_path . '_';
		}
		else if( file_exists($this->root . '/' . $style_path . '/') )
		{
			// tpl - html
			$this->root = $this->root. '/' . $style_path . '/';
		}
		else if( file_exists($this->root . '/' . $mx_user->default_template_name . '/') )
		{
			// Then check current template
			$this->root = $mx_root_path . '/' . $mx_user->default_template_name . '/';
			$this->cachepath = $mx_root_path . 'cache/tpl_' . $mx_user->default_template_name . '_';
		}
		else if( file_exists($this->root . '/' . $moduleDefault . '/') )
		{
			// Finally check the Custom Root folde(for compatibility with some old modules)
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
				// First check current template
				$this->root = $phpbb_root_path . 'templates/' . $style_path . '/';
				$this->cachepath = $phpbb_root_path . 'cache/tpl_' . $style_path. '_';
			}
			else if( file_exists($phpbb_root_path . 'templates/' . $mx_user->cloned_template_name . '/') && !empty($mx_user->cloned_template_name))
			{
				// Then check Cloned
				$this->root = $phpbb_root_path . 'templates/' . $mx_user->cloned_template_name . '/';
				$this->cachepath = $phpbb_root_path . 'cache/tpl_' . $mx_user->cloned_template_name . '_';
			}
			else if( file_exists($phpbb_root_path . 'templates/' . $mx_user->default_template_name . '/') && !empty($mx_user->default_template_name))
			{
				// Then check Default
				$this->root = $phpbb_root_path . 'templates/' . $mx_user->default_template_name . '/';
				$this->cachepath = $phpbb_root_path . 'cache/tpl_' . $mx_user->default_template_name . '_';
			}
			else if (file_exists($phpbb_root_path . 'styles/' . $mx_user->theme['template_path'] . '/template'))
			{
				// Then check phpBB3 style
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
				// Check if it's an absolute or relative path.
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
define('SHARED2_LANG_MAIN'	, 12);
define('SHARED3_LANG_MAIN'	, 13);
define('MX_LANG_ADMIN'	, 20);
define('SHARED2_LANG_ADMIN'	, 22);
define('SHARED3_LANG_ADMIN'	, 23);
define('MX_LANG_ALL'	, 30);
define('MX_LANG_NONE'	, 40);
define('MX_IMAGES'		, 50);
define('MX_IMAGES_NONE'	, 60);
define('MX_LANG_CUSTOM'	, 70);
define('SHARED2_LANG_CUSTOM'	, 72);
define('SHARED3_LANG_CUSTOM'	, 73);

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
	
	var $lang_path = 'language/';
	var $template_path = 'templates/';
	var $styles_path = 'templates/';
	
	var $template_name = '';
	var $template_names = array();
	var $current_template_path = ''; 
	
	/**
	 * @var string	ISO code of the default board language
	 */
	var $default_language;
	var $default_language_name;
	/**
	 * @var string	ISO code of the User's language
	 */
	var $user_language;
	var $user_language_name;
	
	var $lang;
	var $lang_iso = 'en';	
	var $lang_dir = 'lang_english';
	
	protected $common_language_files_loaded;
	
	var $img_lang_dir = 'en';
	var $lang_english_name = 'English';	
	var $lang_local_name = 'English United Kingdom';
	var $language_list = array();
	var $debug_paths;
	
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
	var $current_template_phpbb_path = '';
	var $current_template_phpbb_images = '';
	
	var $default_template_name = '_core';
	var $default_current_template_path = '';

	var $imageset_backend = PORTAL_BACKEND;
	var $ext_imageset_backend = PORTAL_BACKEND;
	
	var $imageset_path = '/theme/images/';
	var $img_array = array();
	var $images;

	var $style_name = '';
	var $style_path = 'styles/';	
	
	var $cloned_style_phpbb_path = '';
	var $current_style_phpbb_path = '';
	
	var $default_style_name = 'prosilver';
	var $default_style2_name = 'subsilver2';
	var $default_style_phpbb_path = '';
	
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

	protected $language;
	protected $request;
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

	/**
	* ------------------------------	
	* Constructor to set the lang path
	*
	* @param \phpbb\language\language	$lang	phpBB's Language loader
	* @param string	$datetime_class	Class name of datetime class
	*/
	function __construct()
	{
		global $mx_cache, $db, $mx_root_path, $module_root_path, $phpbb_root_path;
		global $lang, $language, $board_config, $phpbb_auth;
		
		$this->cache = $mx_cache;
		$this->mx_root_path = $mx_root_path;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->module_root_path = $module_root_path;
		
		
		$this->language = $language;
		$this->common_language_files_loaded = false;
		
		$this->lang_path = $mx_root_path . 'language/';
		$this->phpbb_lang_path = $phpbb_root_path . 'language/';
		$this->shared_lang_path = $mx_root_path . 'includes/shared/phpbb2/';
		$this->language = $lang;
		$this->config = $board_config;
		$this->db = $db;
		$this->auth = $phpbb_auth;
		$this->phpEx = substr(strrchr(__FILE__, '.'), 1);
		$this->php_ext = substr(strrchr(__FILE__, '.'), 1);
		
	}

	// ------------------------------
	// Private Methods
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

		$this->data = $this->data; //for compatibility with Olympus style modules

		// Give us some basic information
		//$this->time_now		= time();

		//$this->browser			= $_SERVER['HTTP_USER_AGENT'];
		//$this->referer			= $_SERVER['Referer'];
		//$this->forwarded_for		= $_SERVER['X-Forwarded-For'];

		//$this->host			= extract_current_hostname();
		//$this->page			= extract_current_page($mx_root_path);		

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
	function _init_userprefs($lang_set = false)
	{
		global $mx_cache, $mx_user, $userdata, $board_config, $portal_config, $theme, $images;
		global $template, $lang, $phpEx, $phpbb_root_path, $mx_root_path, $db;
		global $phpBB2, $phpBB3, $nav_links;
		
		//Enable URL Language Detection
		//$this->data = !empty($this->data['user_id']) ? $this->data : $this->session_pagestart($this->user_ip, $this->page_id);
		
		/** /
		if ( !empty($this->data['user_id']) )
		{
			// Language DataBase
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'phpbb2':
				case 'mybb':
					$this->data =  $this->session_pagestart($this->user_ip, $this->page_id);
				break;
			
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
				case 'proteus':
				default:				
					$this->data =  $this->session_pagestart($this->user_ip, $this->page_id);	
					//$this->session_begin();
				break;
				
				
				case 'smf2':
				default:
					$this->data =  $this->session_pagestart($this->user_ip, $this->page_id);
				break;
			}
		}
		/**/
		$this->cache = is_object($mx_cache) ? $mx_cache : new mx_cache();
		
		if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $_SERVER['HTTP_USER_AGENT'])) 
		{
		    $this->data['is_bot'] = true;
		}
		else
		{
		    $this->data['is_bot'] = false;
		}
		
		$this->data['user_options'] = isset($this->data['user_options']) ? $this->data['user_options'] : '230271'; //
		
		//
		// Populate session_id
		//
		$this->session_id = $this->data['session_id'];
		
		$this->lang_path = $mx_root_path . 'language/';
		
		$lang_set = !isset($lang_set) ? ((defined('IN_ADMIN') ? 'lang_admin' : 'lang_main')) : $lang_set;		
		
		//Line Issued on backend	
		//$this->data['session_logged_in'] = isset($this->data['session_logged_in']) ? $this->data['session_logged_in'] : (($this->data['user_id'] != ANONYMOUS) ? true : false);
		
		//
		// Send a proper content-language to the output in phpBB2 format i.e english
		// Clean up and ensure we are using mxp internal (long) lang format
		//
		$img_lang = $board_config['phpbb_lang'] = $board_config['default_lang']; // Handy switch
		$this->lang['default_lang'] = $phpBB2->phpbb_ltrim(basename($phpBB2->phpbb_rtrim($this->decode_lang($board_config['default_lang']))), "'");
		$this->data['user_lang'] = $phpBB2->phpbb_ltrim(basename($phpBB2->phpbb_rtrim($this->decode_lang($this->data['user_lang']))), "'");
		
		//Line Issued on backend		
		//
		// Send a proper content-language to the output
		/** /
		$img_lang = $default_lang = ($this->data['user_lang']) ? $this->data['user_lang'] : $board_config['default_lang'];
		
		if ($this->data['user_id'] != ANONYMOUS)
		{
			if (!empty($this->data['user_lang']))
			{
				$default_lang = phpbb_ltrim(basename(phpbb_rtrim($this->data['user_lang'])), "'");
			}

			if (!empty($this->data['user_dateformat']))
			{
				$board_config['default_dateformat'] = $this->data['user_dateformat'];
			}

			if (isset($userdata['user_timezone']))
			{
				$board_config['board_timezone'] = $this->data['user_timezone'];
			}
		}
		else
		{
			$default_lang = $phpBB2->phpbb_ltrim(basename($phpBB2->phpbb_rtrim($board_config['default_lang'])), "'");
		}
		/**/
		
		if ( $this->data['user_id'] != ANONYMOUS )
		{
			if ( !empty($this->data['user_lang']))
			{
				$img_lang = $this->lang['default_lang'] = $this->data['user_lang'];
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
			$img_lang = $this->lang['default_lang'] = ((file_exists($mx_root_path . 'language/lang_' . $this->decode_lang(strval($phpBB3->request_var('lang', ''))) . "/lang_main.$phpEx")) ? $this->decode_lang(strval($phpBB3->request_var('lang', ''))) : ((file_exists($mx_root_path . 'language/lang_' . strval($phpBB3->request_var('lang', '')) . "/lang_main.$phpEx")) ? strval($phpBB3->request_var('lang', '')) : $this->lang['default_lang']));			
		}
		//Enable URL Language Detection -@
		// Now, $this->lang['default_lang'] is populated, but do we have a mathing MX-Publisher lang file installed?
		if ( !file_exists($phpBB2->phpbb_realpath($mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx)) )
		{
			// If not, try english (desperate try)
			$this->lang['default_lang'] = 'english';
			//Enable URL Language Detection -@
			if ( !file_exists(@$phpBB2->phpbb_realpath($mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx)) )
			{
				mx_message_die(CRITICAL_ERROR, 'Could not locate valid language pack: ' . $mx_root_path . 'language/lang_' . $this->lang['default_lang'] . '/lang_main.'.$phpEx);
			}
		}
		
		// Language DataBase		
		switch (PORTAL_BACKEND)
		{
			case 'internal':			
			case 'phpbb2':		
			case 'mybb':							
					$sql_users = 'UPDATE ' . USERS_TABLE . "
						SET user_lang = '" . $this->decode_lang($this->lang['default_lang']) . "'
						WHERE user_lang = '" . $this->decode_lang($this->data['user_lang']) . "'";
					$sql_config = "UPDATE " . PORTAL_TABLE . " SET
						default_lang = '" . $this->decode_lang($this->lang['default_lang']) . "'
						WHERE portal_id = '1'";
			break;
		
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
			case 'proteus':
			default:
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
				mx_message_die(CRITICAL_ERROR, 'Could not update user language info', '', __LINE__, __FILE__, $sql_users);
			}
			//Line Issued on backend			
			$userdata['user_lang'] = $this->data['user_lang'] = $this->lang['default_lang'];
		}
		elseif ( !$this->data['session_logged_in'] && $board_config['default_lang'] !== $this->lang['default_lang'] )
		{
			//display an error debuging message only if the portal is installed/upgraded 
			if(!@$db->sql_query($sql_config) && !file_exists($mx_root_path.'/install/'))
			{
				mx_message_die(CRITICAL_ERROR, 'Could not UPDATE CONFIG_TABLE', '', __LINE__, __FILE__, $sql_config);
			}
		}
		
		/* * Pointless here, since we do not know watever we have queried language vanilla phpBB2 lang files installed  
		* Just in case we do fallback on $board_config['phpbb_lang']  * */
		$board_config['default_lang'] = $this->lang['default_lang'];
				
		$this->lang_name = $this->lang['default_lang'] = $this->lang['default_lang'];
		$this->lang_path = 'language/lang_' . $this->lang_name . '/';


		/*
		* Load MXP lang keys
		* Load vanilla phpBB lang files if is possible		
		*/
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
				$shared_lang_path = $mx_root_path . 'includes/shared/phpbb2/language/';
				
			break;
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
			case 'proteus':
			default:
				$shared_lang_path = $mx_root_path . 'includes/shared/phpbb2/language/';
				
			break;
				
			case 'phpbb2':
				$shared_lang_path = $mx_root_path . 'includes/shared/phpbb2/language/';
			
			break;
		}
		
		// 
		// We setup common user language variables
		// We include common language file here with funtion load_common_language_files() to not load it every time a custom language file is included
		//
		//$this->load_common_language_files();
		//$lang = &$this->lang;
		
		//
		// We include common language file here to not load it every time a custom language file is included
		//this line is issued on backend
		//$this->lang = &$lang;
		
		/** Sort of pointless here, since we have already included all main lang files **/
		//this will fix the path for anonymouse users
		if ((@include $mx_root_path . $this->lang_path . "lang_main.$phpEx") === false)
		{
			//this will fix the path for anonymouse users
			echo('<br />');
			echo(filesize($mx_root_path . $this->lang_path . "lang_main.$phpEx") . '');
			echo('<br />');
			die('Language file <a class="textbutton" href="' . $mx_root_path . $this->lang_path . 'lang_main.' . $phpEx . '"><span>' . $mx_root_path . $this->lang_path . "lang_main.$phpEx" . '</span></a>' . ' couldn\'t be opened.');
		}
		//  include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
		//this line is issued on backend		
		//$this->lang = &$lang;	
		
		// Shared phpBB keys
		if ((@include $shared_lang_path . "lang_" . $this->lang['default_lang'] . "/lang_main.$phpEx") === false)
		{
			if ((@include $shared_lang_path . "lang_english/lang_main.$phpEx") === false)
			{
				mx_message_die(GENERAL_ERROR, 'Language file ' . $shared_lang_path . "lang_" . $this->lang['default_lang'] . "/lang_main.$phpEx" . ' couldn\'t be opened.');
			}
		}
		
		//this line is issued on backend		
		//  We include common language file here to not load it every time a custom language file is included			
		//$this->lang = &$lang;			
		$this->add_lang($lang_set);
		
		unset($lang_set);
		
		//		
		// AdminCP
		//			
		if (defined('IN_ADMIN'))
		{
			// Core
			if ((include $mx_root_path . "language/lang_" . $this->lang_name . "/lang_admin.$phpEx") === false)
			{
				if ((@include $mx_root_path . "language/lang_english/lang_admin.$phpEx") !== false)
				{
					$board_config['default_lang'] = 'english';
				}
			}
			//this line is issued on backend
			include($mx_root_path . 'language/lang_' . $this->lang_name . '/lang_admin.' . $phpEx);
			//this line is issued on backend			
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
		// We setup common language file here to not load it every time a custom language file is included
		//
		//$lang = &$this->lang;
		$this->lang = &$lang;
		//print_r($this->lang);
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
		
		//this line is issued on backend		
		// Core Main Translation after shared phpBB keys so we can overwrite some settings
		include($mx_root_path . 'language/lang_' . $this->lang_name . '/lang_main.' . $phpEx);
		
		//
		// Finishing setting language variables to ouput
		//
		$this->lang_iso = $lang_iso = $lang_entries['lang_iso'];
		$this->lang_dir = $lang_dir = $lang_entries['lang_dir'];
		$this->lang_english_name = $lang_english_name = $lang_entries['lang_english_name'];
		$this->lang_local_name = $lang_local_name = $lang_entries['lang_local_name'];
		
		//this line is issued on backend		
		/**/
		if(file_exists($phpBB2->phpbb_realpath($phpbb_root_path . $this->lang_path . '/common.'.$phpEx)))
		{
			//$this->set_lang($this->lang, $this->help, 'common');
			
			//this will fix the path for anonymouse users
			if ((@include $phpbb_root_path . $this->lang_path . '/common.'.$phpEx) === false)
			{
				die('Language file (_init_userprefs) ' . $phpbb_root_path . $this->lang_path . '/common.'.$phpEx . ' couldn\'t be opened by _init_userprefs().');
			}
		}
		
		/**/
		/** /
		//
		// Set up style to output
		//
		if ($this->data['user_id'] == ANONYMOUS && empty($this->data['user_style']))
		{
			$this->data['user_style'] = $board_config['default_style'];
		}
		/**/

		
		
		// Core Main Translation after shared phpBB keys so we can overwrite some settings
		/** Sort of pointless here, since we have already included all main lang files **/
		//this will fix the path for anonymouse users

		
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
		global $mx_cache, $userdata, $board_config, $portal_config, $theme, $images;
		global $template, $lang, $phpEx, $phpbb_root_path, $mx_root_path, $db;
		global $mx_page, $mx_request_vars, $_GET, $_COOKIE, $phpBB3;
		
		if ( !empty($portal_config['default_style']) && !is_array($portal_config['default_style']) )
		{
			$portal_config = $mx_cache->obtain_mxbb_config();
		}
		
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
		
		/*
		* Setup demo style
		*/
		if (isset($_GET['style']))
		{
			global $SID, $_EXTRA_URL;

			$init_style = $phpBB3->request_var('style', $portal_config['default_style']);
			$SID .= '&amp;style=' . $init_style;
			$_EXTRA_URL = array('style=' . $init_style);
			
			//if ( $theme = $this->_setup_style($init_style) )
			//{
				setcookie('style', $init_style, (time() + 21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			//	return;
			//}			
		}
		/**/
		
		/*
		* Setup demo style
		*/
		if ( isset($_GET['demo_theme']))
		{
				$init_style = isset($_GET['demo_theme']) ? intval($_GET['demo_theme']) : intval($_COOKIE['demo_theme']);
				//if ( $theme = $this->_setup_style($init_style) )
				//{
					setcookie('demo_theme', $init_style, (time() + 21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
				//	return;
				//}
		}
		/**/
		
		/*
		* Setup demo style
		*/
		if ( isset($_GET['demostyle']))
		{
				$init_style = isset($_GET['demostyle']) ? intval($_GET['demostyle']) : intval($_COOKIE['demostyle']);
				//if ( $theme = $this->_setup_style($init_style) )
				//{
					setcookie('demostyle', $init_style, (time() + 21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
				//	return;
				//}
		}
		/**/		
		
		/*
		* Request demostyle or style, style_name or themes_id/style_id i.e. for prosilver
		*/		
		if (!$mx_request_vars->is_empty_request('demostyle') || !$mx_request_vars->is_empty_request('style') && !defined('IN_ADMIN'))
		{
			$init_style = !$mx_request_vars->is_empty_request('demostyle') ? $phpBB3->request_var('demostyle', '') : $phpBB3->request_var('style', '');
		}
		
		$init_style = !empty($init_style) ? $init_style : $portal_config['default_style'];
		
		/*
		* Query id for default_style, or for demostyle-style, style_name or themes_id
		*/	
		if (!is_numeric($init_style))
		{
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'smf2':
				case 'mybb':
					$sql = "SELECT  themes_id, style_name
						FROM " . MX_THEMES_TABLE . "
						WHERE portal_backend = 'internal'
						AND style_name = '$init_style'";
				break;
				case 'phpbb2':
					$sql = "SELECT s.themes_id as style_id, mxt.themes_id, mxt.template_name as style_path
						FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " s
							WHERE mxt.template_name = s.template_name
							AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
							AND s.style_name = '$init_style'";
				break;

				case 'olympus':
					$sql = "SELECT  mxt.*, bbt.style_id, bbt.style_name
						FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TEMPLATE_TABLE . " AS stt, " . STYLES_TABLE . " AS bbt
						WHERE bbt.style_active = 1 AND bbt.style_name = '$init_style'
							AND bbt.style_name = mxt.style_name
							AND mxt.portal_backend <> 'phpbb2'
							AND stt.template_id = bbt.template_id";
				break;
				
				case 'ascraeus':
				case 'rhea':
				case 'proteus':
				case 'phpbb3':
				default:
					$sql = "SELECT  mxt.*, bbt.style_id, bbt.style_name
						FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TABLE . " AS bbt
						WHERE bbt.style_active = 1 AND bbt.style_name = '$init_style'
							AND bbt.style_name = mxt.style_name
							AND mxt.portal_backend = 'phpbb3'
							AND mxt.template_path = bbt.style_path";
				break;
			}
		
			/*
			* Query ed id for default_style, or for demostyle-style, style_name or themes_id from mxt.themes_id
			*/	
			if (($result = $db->sql_query($sql)) && ($row = $db->sql_fetchrow($result)))
			{
				$init_style = $row['themes_id']; //Portal Style Id i.e. 7
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
							WHERE portal_backend = 'internal'";
					break;
					
					case 'phpbb2':
						$sql = "SELECT  themes_id, style_name
							FROM " . MX_THEMES_TABLE . "
							WHERE portal_backend = '" . PORTAL_BACKEND . "'";
					break;

					case 'olympus':
						$sql = "SELECT  themes_id, style_name
							FROM " . MX_THEMES_TABLE . "
							WHERE portal_backend <> 'phpbb2'";
					break;
					
					case 'ascraeus':
					case 'rhea':
					case 'proteus':
					case 'phpbb3':
					default:
						$sql = "SELECT  themes_id, style_name
							FROM " . MX_THEMES_TABLE . "
							WHERE portal_backend = 'phpbb3'";
					break;
				}

				print('Could not find style name: ' . $init_style . '!');

				if(($result = $db->sql_query_limit($sql, 1)) && ($row = $db->sql_fetchrow($result)))
				{
					$init_style = $row['themes_id']; //Portal Style Id i.e. 7
				}
			}

		}
		else
		{
			//Style ID
			$mx_themes_id = $init_style;
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'smf2':
				case 'mybb':
					$sql = "SELECT  themes_id, style_name
						FROM " . MX_THEMES_TABLE . "
						WHERE portal_backend = 'internal'
							AND themes_id = " . (int) $init_style;
				break;
			
				case 'phpbb2':
					$sql = "SELECT s.themes_id as style_id, mxt.themes_id, mxt.template_name as style_path
						FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " s
							WHERE mxt.template_name = s.template_name
							AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
							AND mxt.themes_id = " . (int) $init_style;
				break;
			
				case 'olympus':
					$sql = "SELECT  mxt.themes_id, bbt.style_id, bbt.style_name
						FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TEMPLATE_TABLE . " AS stt, " . STYLES_TABLE . " AS bbt
						WHERE bbt.style_active = 1 
							AND mxt.themes_id = " . (int) $init_style . "
							AND bbt.style_name = mxt.style_name
							AND mxt.portal_backend <> 'phpbb2'
							AND stt.template_id = bbt.template_id";
				break;
			
				case 'ascraeus':
				case 'rhea':
				case 'proteus':	
				case 'phpbb3':
				default:
					$sql = "SELECT  mxt.*, bbt.style_id, bbt.style_name
						FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TABLE . " AS bbt
						WHERE bbt.style_active = 1 
							AND bbt.style_id = " . (int) $init_style . "
							AND bbt.style_name = mxt.style_name
							AND mxt.portal_backend = 'phpbb3'
							AND mxt.template_name = bbt.style_path";
				break;
			}
			
			if(($result = $db->sql_query($sql)) && ($row = $db->sql_fetchrow($result)))
			{
				$init_style = $row['themes_id']; //Portal Style Id
			}
			else
			{			
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'smf2':
					case 'mybb':
						$sql2 = "SELECT  themes_id, style_name
							FROM " . MX_THEMES_TABLE . "
							WHERE portal_backend = '" . 'internal' . "'";
					break;
					
					case 'phpbb2':
						$sql2 = "SELECT s.themes_id as style_id, mxt.themes_id, mxt.template_name as style_path
							FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " s
								WHERE mxt.template_name = s.template_name
								AND mxt.portal_backend = '" . PORTAL_BACKEND . "'";
					break;
					
					case 'olympus':
						$sql2 = "SELECT  mxt.themes_id, bbt.style_id, bbt.style_name, bbt.style_path
							FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TEMPLATE_TABLE . " AS stt, " . STYLES_TABLE . " AS bbt
							WHERE bbt.style_active = 1 
								AND bbt.style_name = mxt.style_name
								AND mxt.portal_backend <> '" . 'phpbb2' . "'
								AND stt.template_id = bbt.template_id";
					break;
					
					case 'rhea':
					case 'proteus':
					case 'phpbb3':
					case 'ascraeus':
					default:
						$sql2 = "SELECT  mxt.themes_id, bbt.style_id, bbt.style_name, bbt.style_path
							FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TABLE . " AS bbt
							WHERE bbt.style_active = 1 
								AND bbt.style_name = mxt.style_name
								AND mxt.portal_backend = '" . 'phpbb3' . "'";
					break;
				}
				
				if (($result = $db->sql_query_limit($sql2, 1)) && ($row = $db->sql_fetchrow($result)))
				{
					$init_style = $row['themes_id']; //Portal Style Id
				}
				else
				{
					switch (PORTAL_BACKEND)
					{
						case 'internal':
						case 'smf2':
						case 'mybb':
							$sql = "SELECT  themes_id, style_name
								FROM " . MX_THEMES_TABLE;
						break;
						
						case 'phpbb2':
							$sql = "SELECT s.themes_id as style_id, mxt.themes_id, mxt.template_name as style_path
								FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " s
									WHERE mxt.template_name = s.template_name";
						break;
						
						case 'olympus':
							$sql = "SELECT  mxt.*, bbt.*, mxt.template_name as style_path
								FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TEMPLATE_TABLE . " AS stt, " . STYLES_TABLE . " AS bbt";						
						break;
						
						case 'rhea':
						case 'proteus':
						case 'phpbb3':
						case 'ascraeus':
						default:
							$sql = "SELECT  mxt.themes_id, bbt.style_id, bbt.style_name, bbt.style_path
								FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TABLE . " AS bbt
								WHERE bbt.style_name = mxt.style_name";
						break;
					}
					
					if (($result = $db->sql_query_limit($sql)) && ($row = $db->sql_fetchrowset($result)))
					{
						$count = count($row);
						
						for ($i = 0; $i < $count; $i++)
						{
							if (strpos($row[$i]['style_name'], 'prosilver'))
							{
								$style_id = $row[$i]['style_id']; //Forum Style Id
								$themes_id = $row[$i]['themes_id']; //Portal Style Id
							}
							else
							{
								$style_id = $row[$i]['style_id']; //Forum Style Id
								$themes_id = $row[$i]['themes_id']; //Portal Style Id
							}							
						}
					}
					else
					{
						$init_style = 'prosilver';
						$style_id = 1; //Forum Style Id
						$themes_id = 1; //Portal Style Id
					}	
					// AdminCP
					if (!defined('IN_ADMIN'))
					{
						//print('style_ids: ' . (($mx_themes_id !== $init_style)  ? $mx_themes_id . ', ' . $init_style : $mx_themes_id) . ', ' . $themes_id . ', no style with this id found ... wrong backend ? ' . $sql);
					}
				}
			}				
		}
		
		/*
		* Init queried id for demostyle or style, style_name or style_id
		*/		
		if ($theme = $this->_setup_style($init_style, false) )
		{
			@setcookie((!$mx_request_vars->is_empty_request('demostyle') ? 'demostyle' : 'style'), $init_style, (time() + 21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			return;
		}
		
		/*
		* Init overwrite queried
		*/		
		if (!$init_style)
		{
			$init_style = 1;
			$init_override = 1;
		}
		
		/*
		* Setup user_style, style_id
		*/
		$user_style = false;
		if (!$init_override)
		{
			if ( $this->data['user_id'] != ANONYMOUS && $this->data['user_style'] > 0 )
			{
				$user_style = $mx_request_vars->post('user_style', MX_TYPE_INT, $this->data['user_style']);
			}
		}
		
		$init_style = isset($_POST['default_style']) ? $mx_request_vars->post('default_style', MX_TYPE_INT, $init_style) : $init_style;		
		$theme = $this->_setup_style($init_style, $user_style);		
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
		if (!is_numeric($style))
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
					AND " . $sql_and . " = '" . $style . "'";
			break;
			case 'phpbb2':
				$sql = "SELECT s.themes_id as style_id, 
								mxt.themes_id, 
								mxt.template_name as style_path, 
								s.template_name,
								s.style_name,
								s.head_stylesheet,
								s.body_background,
								s.body_bgcolor,
								s.body_text,
								s.body_link,
								s.body_vlink,
								s.body_alink,
								s.body_hlink,
								s.tr_color1,
								s.tr_color2,
								s.tr_color3,
								s.tr_class1,
								s.tr_class2,
								s.tr_class3,
								s.th_color1,
								s.th_color2,
								s.th_color3,
								s.th_class1,
								s.th_class2,
								s.th_class3,
								s.td_color1,
								s.td_color2,
								s.td_color3,
								s.td_class1,
								s.td_class2,
								s.td_class3,
								s.fontface1,
								s.fontface2,
								s.fontface3,
								s.fontsize1,
								s.fontsize2,
								s.fontsize3,
								s.fontcolor1,
								s.fontcolor2,
								s.fontcolor3,
								s.span_class1,
								s.span_class2,
								s.span_class3,
								s.img_size_poll,
								s.img_size_privmsg
					FROM " . MX_THEMES_TABLE . " mxt, " . THEMES_TABLE . " s
					WHERE mxt.style_name = s.style_name
					AND mxt.portal_backend = '" . PORTAL_BACKEND . "'
					AND mxt." . $sql_and . " = '" . $style . "'";
			break;

			case 'olympus':
				$sql = "SELECT  t.* , s.* 
					FROM " . MX_THEMES_TABLE . " AS m, " . STYLES_TABLE . " AS s, " . STYLES_TEMPLATE_TABLE . " AS t, " . STYLES_THEME_TABLE . " AS c, " . STYLES_IMAGESET_TABLE . " i
					WHERE m.style_name = s.style_name
						AND m.portal_backend =  '" . 'phpbb3' . "'
						AND t.template_id = s.template_id
						AND c.theme_id = s.theme_id
						AND i.imageset_id = s.imageset_id
						AND m." . $sql_and . " = '" . $style . "'";
			break;
			
			#1146 - Table STYLES_TEMPLATE_TABLE 'rhea.phpbb_styles_template' doesn't exist
			case 'rhea':
			case 'proteus':	
			case 'phpbb3':
			case 'ascraeus':
			default:
			#AND mxt.template_name = style_path
				$sql = "SELECT  mxt.*, mxt.template_name AS template_path, s.* 
					FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TABLE . " AS s
					WHERE mxt.template_name = s.style_path
						AND mxt.portal_backend =  '" . 'phpbb3' . "'
						AND mxt." . $sql_and . " = '" . $style . "'";
			break;
		}
		if (!$result = $db->sql_query_limit($sql, 1))
		{
			//Upgrade from olympus ?
			$sql = "SELECT  t.* , s.* 
				FROM " . MX_THEMES_TABLE . " AS m, " . STYLES_TABLE . " AS s, " . STYLES_TEMPLATE_TABLE . " AS t, " . STYLES_THEME_TABLE . " AS c, " . STYLES_IMAGESET_TABLE . " i
					WHERE m.style_name = s.style_name
						AND m.portal_backend =  '" . 'phpbb3' . "'
						AND t.template_id = s.template_id
						AND c.theme_id = s.theme_id
						AND i.imageset_id = s.imageset_id
						AND m." . $sql_and . " = '" . $style . "'";
			if (!$result = $db->sql_query_limit($sql, 1))
			{
				mx_message_die(CRITICAL_ERROR, "Could not query database for theme info '$style'", '', __LINE__, __FILE__, $sql);
			}
			else
			{
				$sql = "UPDATE " . PORTAL_TABLE."
					SET portal_backend = 'olympus'";
				$sql .= " WHERE portal_id = 1";
				if (!$db->sql_query($sql))
				{
					print("Configuration file opened but backend check query failed for backend: UPDATE " . PORTAL_TABLE);
				}
			}
		}
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		
		$style_value = isset($row['style_name']) ? $row['style_name'] : $style;
		
		return $row;
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
		
		global $mx_request_vars, $images, $theme;

		$row = false;
		
		//
		// Are we trying a userstyle?
		//
		if (@is_numeric($user_style) && ($user_style !== false))
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
		if (!isset($row['style_name']))
		{
			//
			// Set up style to output
			//
			if ($this->data['user_id'] == ANONYMOUS && empty($this->data['user_style']))
			{
				$this->data['user_style'] = $board_config['default_style'];
			}
			
			$style_request = $mx_request_vars->request('style', 1);
			
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
			
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'smf2':
				case 'mybb':
					$sql = "SELECT *
						FROM " . MX_THEMES_TABLE . "
						WHERE themes_id = " . (int) $init_style;
				break;
	
				case 'phpbb2':
					$sql = "SELECT s.*, mxt.*, mxt.template_name as style_path
						FROM " . MX_THEMES_TABLE . " AS mxt, " . THEMES_TABLE . " AS s
						WHERE mxt.themes_id = " . (int) $init_style . "
							AND s.template_name = mxt.template_name";
				break;

				case 'olympus':
					$sql = "SELECT bbt.*, stt.*
						FROM " . MX_THEMES_TABLE . " mxt, " . STYLES_TABLE . " bbt, " . STYLES_TEMPLATE_TABLE . " stt
						WHERE mxt.themes_id = " . (int) $init_style . "
						AND mxt.template_name = stt.template_path";
				break;

				case 'phpbb3':
				case 'ascraeus':
				case 'rhea':
				case 'proteus':
				default:
					$sql = "SELECT mxt.*, mxt.template_name AS template_path, stt.*
						FROM " . MX_THEMES_TABLE . " mxt, " . STYLES_TABLE . " stt
						WHERE mxt.themes_id = " . (int) $init_style . "
						AND mxt.template_name = stt.style_path";
				break;
			}

			$result = $db->sql_query($sql);
			$row = $this->style = $this->theme = $theme = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			
			//Invert with style_id
			if (!isset($row['template_name']))
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
						$sql = "SELECT s.*, mxt.*, mxt.template_name as style_path
							FROM " . MX_THEMES_TABLE . " AS mxt, " . THEMES_TABLE . " AS s
							WHERE s.themes_id = " . (int) $init_style . "
								AND s.template_name = mxt.template_name";
					break;

					case 'olympus':
						$sql = "SELECT bbt.*, stt.*
							FROM " . MX_THEMES_TABLE . " mxt, " . STYLES_TABLE . " bbt, " . STYLES_TEMPLATE_TABLE . " stt
							WHERE bbt.style_id = " . (int) $init_style . "
							AND mxt.template_name = stt.template_path";
					break;

					case 'phpbb3':
					case 'ascraeus':
					case 'rhea':
					case 'proteus':
					default:
						$sql = "SELECT mxt.*, mxt.template_name AS template_path, sst.*
							FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TABLE . " AS sst
							WHERE sst.style_id = " . (int) $init_style . "
							AND mxt.template_name = stt.style_path";
					break;
				}
				$result = $db->sql_query_limit($sql, 1);
				$row = $this->style = $this->theme = $theme = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
			}
			
			//Default with any style_id
			if (!isset($row['template_name']))
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
						$sql = "SELECT s.*, mxt.*, mxt.template_name as style_path
							FROM " . MX_THEMES_TABLE . " AS mxt, " . THEMES_TABLE . " AS s
							WHERE s.template_name = mxt.template_name";
					break;

					case 'olympus':
						$sql = "SELECT bbt.*, stt.*
							FROM " . MX_THEMES_TABLE . " mxt, " . STYLES_TABLE . " bbt, " . STYLES_TEMPLATE_TABLE . " stt
							WHERE mxt.template_name = stt.template_path";
					break;

					case 'phpbb3':
					case 'ascraeus':
					case 'rhea':
					case 'proteus':
					default:
						$sql = "SELECT mxt.*, mxt.template_name AS template_path, stt.*
							FROM " . MX_THEMES_TABLE . " AS mxt, " . STYLES_TABLE . " AS stt
							WHERE mxt.template_name = stt.style_path";
					break;
				}
				$result = $db->sql_query_limit($sql, 1);
				$row = $this->style = $this->theme = $theme = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
			}
			
			if (!isset($row['template_name']))
			{
				mx_message_die(CRITICAL_ERROR, "Could not query database for themes_id [$init_style] portal backend: ". PORTAL_BACKEND . '  rows: ' . print_r($row, true), '', __LINE__, __FILE__, $sql);
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
			case 'olympus':
				$this->template_name = $row['template_path'];
				$this->style_name = $row['style_name'];
				$style = $row['style_id'];	
			break;
			case 'ascraeus':
			case 'proteus':
			case 'rhea':
			case 'phpbb3':
			default:
				$this->template_name = $row['template_name'];
				$row['template_path'] = $row['style_path'];
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
			
			case 'olympus':
				$row['style_copy'] = $template_config_row['template_copy'];
				$row['head_stylesheet'] = $row['template_path'] . '.css';
			break;
			
			case 'ascraeus':
			case 'phpbb3':
			case 'rhea':
			case 'proteus':
			default:	
				$row['style_copy'] = $template_config_row['template_copy'];
				$row['head_stylesheet'] = $row['style_path'] . '.css';
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
				$this->_load_mxbb_images();
			break;
			
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
			case 'proteus':
			default:	
				$this->_load_mxbb_images();
				$this->_load_phpbb_images();
			break;
		}
		// Load backend specific style defs.
		//$this->setup_style();
		
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
		
		unset($GLOBALS['MX_TEMPLATE_CONFIG']);
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
				//$phpbb_images = $images;
			break;
			
			case 'phpbb2':
				//$phpbb_images = $this->_load_phpbb_images();
			break;
			
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
			case 'proteus':
			default:
				//$phpbb_images = $this->_load_phpbb_images();				
			break;
		}
		
		//$images = (is_array($phpbb_images) && is_array($images)) ? array_merge($phpbb_images, @$images) : (is_array($images) ? $images: $phpbb_images);
		
		// Load MXP Template configuration data
		$template_config_filename = $mx_root_path . $this->current_template_path . '/' . $this->template_name . '.cfg';	
		
		/*
		*	fix for mxp
		**/
		if ((is_file($template_config_filename) !== true))
		{
			print('The files for path ' . $mx_root_path . ' and template ' . $this->template_name . ' are missing. The template configuration file ' . $template_config_filename . ' couldn\'t be opened.<br/><br/>');
			
			// Since we have no Template Config file, use default (subsilver) instead
			@include($mx_root_path . $this->default_current_template_path . '/' . $this->default_template_name . '.cfg');

			// Make default template -> current template
			$this->template_name = $this->default_template_name;
			$this->current_template_path = $this->default_current_template_path;	
		}
		else
		{
			include $template_config_filename;
		}
		
		$this->theme = (is_array($this->theme) && is_array($theme)) ? array_merge($this->theme, @$theme) : (is_array($theme) ? $theme: $this->theme);
		
		/* Removed since in 3.0.x+ our default template is no style
		if ( !$mx_template_config )
		{
			// Since we have no Template Config file, use default instead
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
	function _load_phpbb2_images()
	{
		global $images, $board_config, $template, $phpbb_root_path, $mx_root_path, $phpEx;

		unset($GLOBALS['TEMPLATE_CONFIG']);

		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
				@define(TEMPLATE_CONFIG, TRUE);
				return $images;
			break;
			
			case 'phpbb2':
					$current_template_path 				= $this->current_template_path;
					$default_current_template_path 	= $this->default_current_template_path;
					$current_style_phpbb_path 		= $this->current_style_phpbb_path; //new
					$cloned_current_template_path 	= $this->cloned_current_template_path;
					$template_path 	 						= $this->template_path; //new
					$default_style_phpbb_path 			= $this->default_style_phpbb_path; 
					$style_path 									= $this->style_path; //new
			break;
			
			case 'phpbb3':
			case 'olympus':
			case 'proteus':
			default:
					$current_template_path 					= $this->current_template_path;
					$default_current_template_path 	= $this->default_current_template_path;
					$cloned_current_template_path 	= $this->cloned_current_template_path;
					$current_style_phpbb_path 			= $this->current_style_phpbb_path; //new
					$template_path 	 							= $this->template_path; //new
					$default_style_phpbb_path 			= $this->default_style_phpbb_path; 
					$style_path 										= $this->style_path; // To main style init. Should be correct and valid.
			break;
		}	
		/*
		* Load phpBB3 Template configuration data
		*/			
		$style_found = ''; //default
		
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
		
		// Last attempt, use default template intead
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
	
		/**
		/* Try phpBB2 then phpBB3 style 
		/* mx_user->_load_phpbb_images( )
		/* Icludes here old phpBB styles configuration file
		/* include( 'www\phpbb2\templates\prosilver2\prosilver2.cfg' )
		**/
		if ((@include $phpbb_root_path . $current_template_path . '/' . $template_name . '.cfg') === true)
		{
			if (!defined('TEMPLATE_CONFIG'))
			{
				// Do not alter this line!
				@define(TEMPLATE_CONFIG, TRUE);
			}
			
		}
		elseif(@filemtime($phpbb_root_path . $current_template_path . "/style.cfg") )
		{
			// Do not alter this line!
			@define(TEMPLATE_CONFIG, TRUE);
			
			// - First try phpBB2 then phpBB3 template lang images then old Olympus image sets	
			if (is_dir($phpbb_root_path . $current_template_path . '/images/'))
			{
				$this->current_template_images = $current_template_path . '/images';
			}		
			else if (is_dir($phpbb_root_path . $current_template_path  . '/theme/images/') )
			{		
				$this->current_template_images = $current_template_path  . '/theme/images';
			}		
			
			if (is_dir($phpbb_root_path . $current_template_path  . '/imageset/') )
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
			
			// Vote graphic length defines the maximum length of a vote result
			// graphic, ie. 100% = this length
			$board_config['vote_graphic_length'] = 205;
			$board_config['privmsg_graphic_length'] = 175;			
		}
		else		
		{		
			//php5 in Safe Mode or MXP is in a subfolder and also phpBB
			if ( (mx_parse_cfg_file($phpbb_root_path . $current_template_path . '/style.cfg')))
			{
				if (!defined('TEMPLATE_CONFIG'))
				{
					// Do not alter this line!
					@define(TEMPLATE_CONFIG, TRUE);
				}
				
			}
			else
			{
				print_r("Could not open phpBB $this->template_name template config file");
			}

		}
		/**/
		
		// We have no template to use - die
		if ( !defined('TEMPLATE_CONFIG') )
		{
			// Load phpBB Template configuration data
			// - Last try current template		
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
		
		// Try phpBB2 then phpBB3 style configuration file	
		if (@file_exists(@phpbb_realpath($phpbb_root_path . $current_template_path . '/' . $template_name . '.cfg')) )
		{		
			//parse phpBB2 style cfg file	
			$cfg_file_name = $this->template_name . '.cfg';
			$cfg_file = $phpbb_root_path . $this->current_template_path . '/' . $cfg_file_name;
			
			if (file_exists($phpbb_root_path .  $this->current_template_path . '/' . $cfg_file_name))
			{
				if (!isset($parsed_array['filetime']) || (@filemtime($cfg_file) > $parsed_array['filetime']))
				{				
					$parsed_array = mx_parse_cfg_file($cfg_file);		
					$parsed_array['filetime'] = @filemtime($cfg_file);
					$this->cache->put('_cfg_' . $this->template_path, $parsed_array);				
				}
			}		
		}
		elseif( @file_exists(@phpbb_realpath($phpbb_root_path . $this->current_template_path . '/style.cfg')) )
		{
			//parse phpBB3 style cfg file
			$cfg_file_name = 'style.cfg';			
			$cfg_file = $phpbb_root_path . $this->current_template_path . '/style.cfg';
					
			if (!isset($parsed_array['filetime']) || (@filemtime($cfg_file) > $parsed_array['filetime']))
			{
				// Re-parse cfg file
				$parsed_array = mx_parse_cfg_file($cfg_file);		
				$parsed_array['filetime'] = @filemtime($cfg_file);				
				$this->cache->put('_cfg_' . $this->template_path, $parsed_array);
			}							
		}		
		$check_for = array(
			'pagination_sep'    => (string) ', '
		);

		foreach ($check_for as $key => $default_value)
		{
			//$this->style[$key] = (isset($parsed_array[$key])) ? $parsed_array[$key] : $default_value;
			$this->theme[$key] = (isset($parsed_array[$key])) ? $parsed_array[$key] : $default_value;
			//settype($this->style[$key], gettype($default_value));
			settype($this->theme[$key], gettype($default_value));
			if (is_string($default_value))
			{
				//$this->style[$key] = htmlspecialchars($this->style[$key]);
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
		if (is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/imageset/"))
		{
			$this->imageset_path = '/imageset/'; //Olympus ImageSet
			$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . $this->imageset_path . $this->lang_iso)) ? $this->lang_iso : $this->default_language;
			$this->img_lang_dir = $this->img_lang;
			$this->imageset_backend = 'olympus';		
		}
		elseif (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/images/"))
		{
			if ((@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/lang_{$this->user_language_name}")) || (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/lang_{$this->default_language_name}")))
			{
				$this->imageset_path = '/theme/images/';  //phpBB3 Images				
				$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . '/theme/' . 'lang_' . $this->user_language_name)) ? $this->user_language_name : $this->default_language_name;
				$this->img_lang_dir = 'lang_' . $this->img_lang;
				$this->imageset_backend = 'phpbb2';	
			}
			if ((@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/{$this->user_language}")) || (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/theme/{$this->default_language}")))
			{
				$this->imageset_path = '/theme/images/';  //phpBB3 Images				
				$this->img_lang = (file_exists($phpbb_root_path . $this->template_path . $this->template_name . '/theme/' . $this->user_language_name)) ? $this->user_language : $this->default_language;
				$this->img_lang_dir = $this->img_lang;
				$this->imageset_backend = 'phpbb3';	
			}			
		}		
		elseif (@is_dir("{$phpbb_root_path}{$this->template_path}{$this->template_name}/images/"))
		{
			$this->imageset_path = '/images/';  //phpBB2 Images
			$this->img_lang = (is_dir($phpbb_root_path . $this->template_path . $this->template_name . $this->imageset_path . '/images/lang_' . $this->user_language_name)) ? $this->user_language_name : $this->default_language_name;
			$this->img_lang_dir = 'lang_' . $this->img_lang;
			$this->imageset_backend = 'phpbb2';	
		}
		
		// phpBB2 image sets main images				
		$img_lang = ( is_dir($phpbb_root_path . $this->current_template_path . $this->img_lang_dir) ) ? $this->img_lang : $this->default_language_name;
		
		//
		// Import phpBB Graphics, prefix with PHPBB_URL, and apply LANG info
		//
		/* start Migrating from php5 to php7+ replace
			foreach ($mx_images as $key => $value) {
		with
			while (list($key, $value) = each($mx_images)) {
		ends Migrating */		
		foreach ($mx_images as $key => $value) 
		{
			if (is_array($value))
			{
				foreach( $value as $key2 => $val2 )
				{
					$this->images[$key][$key2] = $images[$key][$key2] = PHPBB_URL . $val2;
				}
			}
			else
			{
				$this->images[$key] = $images[$key] = str_replace('{LANG}', 'lang_' . $img_lang, $value);
				$this->images[$key] = $images[$key] = PHPBB_URL . $images[$key];
			}
			
			if(empty($images['forum']))
			{
				//print_r('Your style configuration file has a typo! ');
				//print_r($images);
				$images['forum'] = 'folder.gif';
			}						
			
			/* Here we overwrite phpBB images from the template db or configuration file  */		
			$rows = $this->image_rows($images);		
			
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
		
		//print_r($images);		
		// Import phpBB Olympus image sets main images
		//		
		if (@file_exists("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}/imageset.cfg"))
		{		
			$cfg_data_imageset = mx_parse_cfg_file("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}/imageset.cfg");
			
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
			$cfg_data_imageset_data = mx_parse_cfg_file("{$phpbb_root_path}{$this->template_path}{$this->template_name}{$this->imageset_path}{$this->img_lang}/imageset.cfg");
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
				
				if (empty($row['image_name']))
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
					$cfg_data_imageset_data = mx_parse_cfg_file("{$phpbb_root_path}styles/{$this->template_name}/imageset/{$this->img_lang}/imageset.cfg");
					
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
					$cfg_data_imageset_data = mx_parse_cfg_file("{$phpbb_root_path}styles/{$this->cloned_template_name}/imageset/{$this->img_lang}/imageset.cfg");
					
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
					$default_style_name = str_replace('_core', 'all', $this->default_template_name);
					$template_name = $this->default_style_name;
					
					$cfg_data_imageset_data = mx_parse_cfg_file("{$phpbb_root_path}styles/{$template_name}/imageset/{$this->img_lang}/imageset.cfg");
					
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
			case 'proteus':
			case 'phpbb3':
			default:
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
					$this->timezone = (int)$this->data['user_timezone'] * 3600;
					$this->dst = (int)$this->data['user_dst'] * 3600;
				}
				else
				{
					$this->lang_name = (file_exists($phpbb_root_path . 'language/' . $this->encode_lang($this->lang['default_lang']) . "/common.$phpEx")) ? $this->encode_lang($this->lang['default_lang']) : 'en';
					$this->lang_path = $phpbb_root_path . 'language/' . $this->lang_name . '/';
					$this->date_format = $board_config['default_dateformat'];
					$this->timezone = (int)$board_config['board_timezone'] * 3600;
					$this->dst = isset($this->data['user_dst']) ? (int)$this->data['user_dst'] * 3600 : (int)$board_config['user_timezone'] * 3600;
				}
				
				$this->img_lang = (@file_exists('{$phpbb_root_path}styles/{$this->template_path}/theme/images/{$this->lang_name}')) ? $this->lang_name : $this->encode_lang($board_config['default_lang']);				
				// $this->template_name = $this->template_path;
				// trigger_error("Could not get style data: $this->template_name", E_USER_ERROR);
				
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
					
					if ( !defined('TEMPLATE_CONFIG') )
					{ 
						@define('TEMPLATE_CONFIG', TRUE); 
					}
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
					
					if ( !defined('TEMPLATE_CONFIG') )
					{ 
						@define('TEMPLATE_CONFIG', TRUE); 
					}					
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
					
					if ( !defined('TEMPLATE_CONFIG') ) 
					{ 
						@define('TEMPLATE_CONFIG', TRUE); 
					}				
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
				
				if ( !defined('TEMPLATE_CONFIG') || (TEMPLATE_CONFIG !== TRUE)) 
				{ 
					@define('TEMPLATE_CONFIG', TRUE); 
				}
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
			//mx_message_die(CRITICAL_ERROR, "Could not open phpBB $this->template_name template config file", '', __LINE__, __FILE__);
		}
		
		$img_lang = ( file_exists($phpbb_root_path . $this->current_template_path . '/images/lang_' . $this->encode_lang($this->lang['default_lang'])) ) ? $this->encode_lang($this->lang['default_lang']) : 'english';
		
		/*
		* Import phpBB Graphics, prefix with PHPBB_URL, and apply LANG info
			/* start Migrating from php5 to php7+ replace
				foreach ($images as $default_key => $default_value) {
			with
				while (list($default_key, $default_value) = each($images)) {
			ends Migrating
		*/
		foreach ($images as $key => $value) 
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
				$template_name2 = 'mxSilver';
				@define(TEMPLATE_CONFIG, TRUE);
			break;
			
			case 'phpbb2':
				$template_name2 = 'subSilver';
			break;
			
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
			case 'proteus':
			default:
				$template_name2 = 'subsilver2';	
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
		$template_config_d = defined('TEMPLATE_CONFIG') ? true : false;
				
		/**
		/* Try phpBB2 then phpBB3 style 
		/* mx_user->_load_mxbb_images( )
		/* Icludes here MXP styles configuration file
		/* include( 'www\templates\prosilver2\prosilver2.cfg' )
		**/
		unset($GLOBALS['MX_TEMPLATE_CONFIG']);		
		
		$mx_template_config = false;
		
		if (@file_exists($mx_root_path . $module_root_path . $this->current_template_path . '/' . $template_name . '.cfg'))
		{
			include($mx_root_path . $module_root_path . $this->current_template_path . '/' . $template_name . '.cfg');
		}
		
		if ($module_root_path == 'modules/mx_coreblocks/')	
		{
			// - default module already populated in root core folder
			$mx_template_config = true;
		}						
		
		if (!$mx_template_config)
		{
			if (@file_exists($mx_root_path . $module_root_path . $this->current_template_path . '/' . $moduleCfgFile . '.cfg'))
			{				
				include($mx_root_path . $module_root_path . $this->current_template_path . '/' . $moduleCfgFile . '.cfg');
			}
		}		
		
		if (!$mx_template_config)
		{
			if (@file_exists($mx_root_path . $module_root_path . $this->current_template_path . '/_core.cfg'))
			{				
				include($mx_root_path . $module_root_path . $this->current_template_path . '/_core.cfg');
			}
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
		/* start Migrating from php5 to php7+ replace
			foreach ($mx_images as $key => $value) {
		with
			while (list($key, $value) = each($mx_images)) {
		ends Migrating */		
		foreach ($mx_images as $key => $value) 
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
		$this->images = $images = &$mx3_images;
		
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
	function _load_lang($path, $filename, $require = true)
	{
		$lang = array();
		
		$board_config = $this->config;
		$php_ext = $this->php_ext;
		
		// Now only the root for mxp blocks
		$user_path = $path . 'language/lang_' . $this->data['user_lang'] . '/' . $filename . '.' . $php_ext;
		$board_path = $path . 'language/lang_' . $board_config['default_lang'] . '/' . $filename . '.' . $php_ext;
		$default_path = $path . 'language/lang_english/' . $filename . '.' . $php_ext;
				
		// phpBB		
		if (($path != 'phpbb2') && ($path != 'phpbb3'))
		{
			$phpbb_user_path = $path . 'language/' . $this->data['user_lang'] . '/' . $filename . '.' . $php_ext;
			$phpbb_board_path = $path . 'language/' . $board_config['default_lang'] . '/' . $filename . '.' . $php_ext;
			$phpbb_default_path = $path . 'language/en/' . $filename . '.' . $php_ext;
		}
		
		// Shared phpBB2
		if ($path = 'phpbb2')
		{
			$phpbb2_shared_path = $this->mx_root_path . 'includes/shared/phpbb2/';
			
			$phpbb_user_path = $phpbb2_shared_path . 'language/lang_' . $this->data['user_lang'] . '/' . $filename . '.' . $php_ext;
			$phpbb_board_path = $phpbb2_shared_path . 'language/lang_' . $board_config['default_lang'] . '/' . $filename . '.' . $php_ext;
			$phpbb_default_path = $phpbb2_shared_path . 'language/lang_english/' . $filename . '.' . $php_ext;
		}
		
		// Shared phpBB3
		if ($path = 'phpbb3')
		{
			$phpbb3_shared_path = $this->mx_root_path . 'includes/shared/phpbb3/';

			$phpbb_user_path = $phpbb3_shared_path . 'language/lang_' . $this->data['user_lang'] . '/' . $filename . '.' . $php_ext;
			$phpbb_board_path = $phpbb3_shared_path . 'language/lang_' . $board_config['default_lang'] . '/' . $filename . '.' . $php_ext;
			$phpbb_default_path = $phpbb3_shared_path . 'language/lang_english/' . $filename . '.' . $php_ext;				
		}
		
		if ((@include $user_path) === false)
		{
			//continue;
			//print_r('Language file ' . $user_path . ' couldn\'t be opened.');
		}
		else if ($require)
		{
			if (file_exists($board_path))
			{
				include_once($board_path);
			}
			else if (file_exists($default_path))
			{
				include_once($default_path);
			}
		}
		else if (is_file($phpbb_user_path))
		{
			include_once($phpbb_user_path);
		}
		if ((@include $phpbb_user_path) === false)
		{
			if ($require)
			{
				if ((@include $phpbb_board_path) === false)
				{
					if ((@include $phpbb_default_path) === false)
					{
						//continue;
					}
				}
			}
		}
		
		if (count($lang) == 0)
		{
			// If the language entry is an empty array, we just return the language key $this->lang = $this->lang;	
			// The language file is not exist throw new language_file_not_found(
			print('Language file ' . $path . '|' . $filename . '.' . $php_ext . '|' . ($require ? $phpbb_user_path : $phpbb_board_path) . ' couldn\'t be opened.');
		}
		else
		{
			// If the language entry is not an empty array, we merge the language keys
			$this->lang = array_merge($this->lang, $lang);
		}
	}
	
	/**
	 * Loads common language files
	 */
	protected function load_common_language_files()
	{
		if (!$this->common_language_files_loaded)
		{	
			/*
			* Load MXP lang keys
			* Load vanilla phpBB2 lang files for old modules if is possible
			*/
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'smf2':
				case 'mybb':
					
					//Load shared phpBB2 language files for old modules				
					$shared_lang_path = $this->mx_root_path . 'includes/shared/phpbb2/language/';					
					
					// AdminCP
					if (defined('IN_ADMIN'))
					{
						// Shared phpBB2 AdminCP keys
						$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb2/', 'lang_admin');
						// Core MXP AdminCP 
						$this->_load_lang($this->mx_root_path, 'lang_admin');
						//Load Shared phpBB3 common language file
						$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb3/', 'acp/common');
					}
					// Shared phpBB keys
					$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb2/', 'lang_main');
					// Core Main Translation after shared phpBB keys so we can overwrite some settings
					$this->_load_lang($this->mx_root_path, 'lang_main');
					//Load Shared phpBB3 common language file
					$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb3/', 'common');
				break;
				
				case 'phpbb2':
					
					//Load vanilla phpBB2 language files for old modules if is possible				
					$shared_lang_path = $this->mx_root_path . 'includes/shared/phpbb2/language/';					
					
					// AdminCP
					if (defined('IN_ADMIN'))
					{
						// Load vanilla phpBB2 AdminCP keys
						$this->_load_lang($this->phpbb_root_path, 'lang_admin');
						// Core MXP AdminCP 
						$this->_load_lang($this->mx_root_path, 'lang_admin');
						//Load Shared phpBB3 AdminCP common language file
						$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb3/', 'acp/common');
					}
					
					// Load vanilla phpBB2 keys
					$this->_load_lang($this->phpbb_root_path, 'lang_main');
					// Core Main Translation after shared phpBB keys so we can overwrite some settings
					$this->_load_lang($this->mx_root_path, 'lang_main');
					//Load Shared phpBB3 common language file
					$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb3/', 'common');
				break;
				
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
				case 'proteus':
				default:
					//Load vanilla phpBB3 common language files for new modules if is possible				
					$shared_lang_path = $this->mx_root_path . 'includes/shared/phpbb3/language/';					
					
					// AdminCP
					if (defined('IN_ADMIN'))
					{
						// Shared phpBB2 AdminCP keys
						$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb2/', 'lang_admin');
						// Core MXP  AdminCP
						$this->_load_lang($this->mx_root_path, 'lang_admin');						
						//Load vanilla phpBB3 AdminCP common language file							
						$this->_load_lang($this->phpbb_root_path, 'acp/common');						
					}					
					// Shared phpBB keys
					$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb2/', 'lang_main');
					// Core Main Translation after shared phpBB keys so we can overwrite some settings
					$this->_load_lang($this->mx_root_path, 'lang_main');					
					//Load vanilla phpBB3 common language file					
					$this->_load_lang($this->phpbb_root_path, 'common');
				break;
			}	
			
			//
			// backend specific common language defs loaded.
			//
			$this->common_language_files_loaded = true;
		}
	}
	
	/**
	 * Returns language files list from an specific directory path
	 */	
	function get_lang_files($root_path, $language, $add_path = '', $dir_select = '')
	{ 
		global $mx_root_path, $phpEx;
		
		/* root path at witch we add ie. extension path */  
		$php_ext = $this->php_ext;
		
		//$path = $root_path . "language";	
		$path = $root_path . "language/lang_" . $language;		
		
		$file = $subdir_select = '';
		
		$lang_files = array();
		$subdirs = glob($path . '/*' , GLOB_ONLYDIR);
		
		/* */
		foreach($subdirs as $subdir_id => $subdir_from)
		{
			$subdir = $subdirs[$subdir_id];
			if ($subdir == '.' || $subdir == '..' || $subdir == 'CVS')
			{
				continue;
			}
			$subdir_select = basename($subdir);
		}
		/* */
		
		if (!is_dir($path . '/'))
		{
			//$dir = 'Resource id #53'.'Resource id #54'.'Resource id #55'.'Resource id #56'.'Resource id #57'.'Resource id #58';
			//return array_merge(array('common.php' => 'common.php', 'info_acp_translator.php' => 'info_acp_translator.php', 'lang_admin.php' => 'lang_admin.php'),  array ('lang_admin.php' => 'lang_admin.php', 'lang_main.php' => 'lang_main.php', 'lang_meta.php' => 'lang_meta.php'));		
		}
		else
		{
			$dir = opendir($path . '/');
		}
		
		while ($file = @readdir($dir))
		{
			if ( $file == '.' || $file == '..' || $file == 'CVS')
			{
				continue;
			}
		
			if (is_dir($path . '/' . $file))
			{
				$sub_files = $this->get_lang_files($path, $language, $add_path . '/'. $file);
				$lang_files = array_merge($lang_files, $sub_files);
			}
			else if( is_file($path . '/' . $file))
			{
				$lang_files[str_replace(".$php_ext", '', $file)] = $path . (!empty($path) ? '/' : '') . $file;
			}
		}
		@closedir($dir);
		
		if ((@is_dir($subdir_select . '/') || mx_local_file_exists($subdir_select . '/index.htm')) && is_array($subdirs))
		{
			$subdir = ($subdir_select == 'email') ? opendir($mx_root_path . 'language/lang_english/' . $subdir_select . '/') : opendir($subdir_select);
		}
		else
		{
			$subdir = $subdir_select;
		}			
		$subdir_select_from = $dir_select; //$root_path . $path . 'language/' . $language;
		
		if (is_dir($subdir))
		{
			while ($file = readdir($subdir))
			{
				if ($file == '.' || $file == '..' || $file == 'CVS')
				{
					continue;
				}
				
				if (is_file($subdir_select_from . '/' . $file))
				{
					$sub_files[str_replace(".$phpEx", '', $file)] = $subdir_select_from . (!empty($subdir_select_from) ? '/' : '') . $file;
					$lang_files = array_merge($lang_files, $sub_files);
				}
			}
			closedir($subdir);
		}
		else
		{
			print('Not uploaded yet: '.$subdir.' ?');
		}
		return $lang_files;
	}
	
	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $lang_mode
	 */
	function _load_module_lang($lang_mode = MX_LANG_MAIN, $force = false, $use_help = false)
	{
		global $lang, $board_config, $mx_block, $phpEx;
		
		$default_lang = ($this->default_language_name) ? $this->decode_lang($this->default_language_name) : (!empty($board_config['default_lang']) ? $board_config['default_lang'] : 'english');
		$language = ($this->user_language_name) ? $this->user_language_name : $default_lang;
		
		if ($mx_block->module_root_path == 'modules/mx_coreblocks/')
		{
			// - default module already populated in root core language pack
			$this->loaded_langs[$mx_block->module_root_path] = '1';
		}
		
		if (empty($mx_block->module_root_path))
		{
			global $module_root_path;
			$mx_block->module_root_path = $module_root_path;
		}
		
		if (empty($default_lang))
		{
			// - populate $default_lang
			$default_lang = 'english';
		}
		
		if (!isset($this->loaded_langs[$mx_block->module_root_path]) || $force)
		{					
			if (!empty($this->module_lang_path[$mx_block->module_root_path]))
			{
				$module_lang_path = $this->module_lang_path[$mx_block->module_root_path];
			}
			else
			{
				$module_lang_path = $mx_block->module_root_path;
			}
			
			if ($lang_mode == MX_LANG_ALL)
			{
				$lang_files = $this->get_lang_files($module_lang_path, $language);
				
				// -------------------------------------------------------------------------
				// Read Module Languages Definition
				// -------------------------------------------------------------------------
				foreach ($lang_files as $lang_set => $filename)
				{
					if (!empty($filename) && ($filename !== './') && strpos($filename, $phpEx))
					{
						$this->debug_paths .= '<br>' . $filename;
							
						if ((@include_once $filename) === false)
						{	
							print_r('Warning: Could not load module language file: ' . $this->debug_paths);
							
							if ((@include $module_lang_path . "language/lang_" . $language . "/$lang_set.$phpEx") === false)
							{
								print_r('<br> CRITICAL ERROR : Could not load module language file: ' . $module_lang_path . "language/lang_" . $language . "/$lang_set" . ' couldn\'t be opened.');
							}
						}
					}
				}
			}
			
			if (($lang_mode == MX_LANG_MAIN ) && ($lang_mode != MX_LANG_ALL))
			{
				// -------------------------------------------------------------------------
				// Read Module Main Language Definition
				// -------------------------------------------------------------------------
				if ((@include $module_lang_path . "language/lang_" . $language . "/lang_main.$phpEx") === false)
				{
					if (strpos($this->mx_root_path, 'mx_coreblocks') === 0)
					{
						if ((@include $module_lang_path . "language/$default_lang/lang_main.$phpEx") === false)
						{
							mx_message_die(CRITICAL_ERROR, 'Module main language file ' . $this->mx_root_path . $module_lang_path . "language/lang_" . $language . "/lang_main.$phpEx" . ' couldn\'t be opened.');
						}
					}
				}
			}
			
			if (($lang_mode == MX_LANG_ADMIN) && ($lang_mode != MX_LANG_ALL))
			{
				// -------------------------------------------------------------------------
				// Read Module Admin Language Definition
				// -------------------------------------------------------------------------
				if ((@include $module_lang_path . "language/lang_" . $language . "/lang_admin.$phpEx") === false)
				{
					if ((@include $module_lang_path . "language/$default_lang/lang_admin.$phpEx") === false)
					{
						mx_message_die(CRITICAL_ERROR, 'Module admin language file ' . $this->mx_root_path . $module_lang_path . "language/lang_" . $language . "/lang_admin.$phpEx" . ' couldn\'t be opened.');
					}
				}
			}				
			
			if (($lang_mode != MX_LANG_MAIN ) && ($lang_mode != MX_LANG_ADMIN) && ($lang_mode != MX_LANG_ALL))
			{
				$lang_set = $lang_mode;
				
				// -------------------------------------------------------------------------
				// Read Module Languages Definition
				// -------------------------------------------------------------------------
				$filename = $module_lang_path . "language/lang_" . $language . "/$lang_set.$phpEx";
				
				$this->debug_paths .= '<br>' . $filename;
							
				if ((@include_once $filename) === false)
				{	
					print_r('Warning: Could not load module language file: ' . $this->debug_paths);
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
	
	/**
	 * Load available languages list
	 * author: Jan Kalah aka culprit_cz
	 * @return array available languages list: KEY = folder name
	 */
	function get_lang_list($ext_root_path = '')
	{
		if (count($this->language_list))
		{
			return $this->language_list;
		}
		/* c:\Wamp\www\Rhea\language\ */
		$dir = opendir($this->mx_root_path . 'language/');			
		while($f = readdir($dir))
		{
			if (($f == '.' || $f == '..') || !is_dir($this->mx_root_path . 'language/' . $f))
			{
				continue;
			}
			$this->language_list[$f] =  $this->ucstrreplace('lang_', '', $f);	
		}
		closedir($dir);
		if (is_dir($this->phpbb_root_path . 'language/'))
		{	
			$dir = opendir($this->phpbb_root_path . 'language/');			
			while($f = readdir($dir))
			{
				if (($f == '.' || $f == '..') || !is_dir($this->phpbb_root_path . 'language/' . $f))
				{
					continue;
				}
				$this->phpbb_language_list[$f] =  $this->ucstrreplace('lang_', '', $f);	
			}
			closedir($dir);
			return $this->language_list = array_merge($this->phpbb_language_list, $this->language_list);
		}			
		return $this->language_list;
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
			global $user_ip, $mx_request_vars;
			
			$this->page_id = $mx_request_vars->request('page_id', 1);
			
			// Inititate User data
			$this->_init_session($user_ip, $this->page_id);
			$this->_init_userprefs();
			
			print('Style: Bad initialization method of the User Class!</br>');
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
			case 'proteus':
			default:	
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
	 * - $mx_user->extend(MX_LANG_ALL, MX_IMAGES)
	 *
	 * Switches:
	 * - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL
	 * - IMAGES: MX_IMAGES (default), MX_NO_IMAGES
	 *
	 * @access public
	 * @param unknown_type $lang_mode
	 * @param unknown_type $image_mode
	 */
	function extend($lang_mode = MX_LANG_MAIN, $image_mode = MX_IMAGES, $module_root_path = '', $force = false)
	{
		global $mx_root_path, $mx_block;	
		
		if (defined('IN_ADMIN') && !empty($module_root_path) && (empty($mx_block->module_root_path) || ($mx_block->module_root_path == 'modules/mx_coreblocks/')))
		{						
			$mx_block->module_root_path = $module_root_path;
		}			
		
		if (!empty($this->loaded_default_styles[$mx_block->module_root_path]))
		{
			$this->default_module_style = $this->loaded_default_styles[$mx_block->module_root_path];
			$this->default_template_name = $this->default_module_style;
			$this->default_current_template_path = 'templates/' . $this->default_template_name;
		}		
		
		if ($lang_mode != MX_LANG_NONE)
		{									
			$this->_load_module_lang($lang_mode, $force);
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
			if(@is_dir($mx_root_path . 'templates/' . '_core' . '/') )
			{
				$this->default_template_name = '_core';
				$this->default_current_template_path = 'templates/' . $this->default_template_name;
			}			
			elseif(@is_dir($mx_root_path . 'styles/' . 'all' . '/') )
			{
				$this->default_template_name = 'all';
				$this->default_current_template_path = 'styles/' . $this->default_template_name;
			}
			elseif(@is_dir($mx_root_path . 'templates/' . 'all' . '/') )
			{
				$this->default_template_name = 'all';
				$this->default_current_template_path = 'templates/' . $this->default_template_name;
			}			
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
	* Loads all extension information from the database
	*
	* @return null
	*/
	public function load_extensions()
	{
		$this->extensions = array();

		// Do not try to load any extensions if the extension table
		// does not exist or when installing or updating.
		// Note: database updater invokes this code, and in 3.0
		// there is no extension table therefore the rest of this function
		// fails
		if (defined('IN_INSTALL') || version_compare($this->config['version'], '3.1.0-dev', '<'))
		{
			return;
		}

		$sql = 'SELECT *
			FROM ' . $this->extension_table;

		$result = $this->db->sql_query($sql);
		$extensions = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		foreach ($extensions as $extension)
		{
			$extension['ext_path'] = $this->get_extension_path($extension['ext_name']);
			$this->extensions[$extension['ext_name']] = $extension;
		}

		ksort($this->extensions);

		if ($this->cache)
		{
			$this->cache->put($this->cache_name, $this->extensions);
		}
	}

	/**
	* Generates the path to an extension
	*
	* @param string $name The name of the extension
	* @param bool $phpbb_relative Whether the path should be relative to phpbb root
	* @return string Path to an extension
	*/
	public function get_extension_path($name, $phpbb_relative = false)
	{
		$name = str_replace('.', '', $name);

		return (($phpbb_relative) ? $this->phpbb_root_path : '') . 'ext/' . $name . '/';
	}

	/**
	* Instantiates the extension meta class for the extension with the given name
	*
	* @param string $name The extension name
	* @return \phpbb\extension\extension_interface Instance of the extension meta class or
	*                     \phpbb\extension\base if the class does not exist
	*/
	public function get_extension($name)
	{
		$extension_class_name = str_replace('/', '\\', $name) . '\\ext';
		
		//Not implemented yet
		$migrator = new mx_nothing();
		
		if (class_exists($extension_class_name))
		{
			return new $extension_class_name($this->cache, $this->get_finder(), $migrator, $name, $this->get_extension_path($name, true));
		}
		else
		{
			return new \phpbb\extension\base($this->container, $this->get_finder(), $migrator, $name, $this->get_extension_path($name, true));
		}
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
				$return = '<button class="button textbutton" type="submit" title="{$label}" style="font-size:9px;">';
				$return .= '<i class="fa fa-star-o" style="float:top;vertical-align: 25%;whitespace: false;" aria-hidden="false"></i>';
				$return .=  '<a class="textbutton" href="'. $url .'"><span>' . $label . '</span></a>';
				$return .= '</button>';
				return $return;
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
				$return = '<button class="button textbutton" type="submit" title="{$label}" style="font-size:9px;">';
				$return .= '<i class="fa fa-star-o" style="float:top;vertical-align: 25%;whitespace: false;" aria-hidden="false"></i>';
				$return .=  '<a class="textbutton" href="'. $url .'"><span>' . $label . '</span></a>';
				$return .= '</button>';
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
}	
/**  
* class mx_user 
 **/

/**
 * Language file loader
 */
class mx_language_file_loader
{
	/**
	 * Global fallback language
	 *
	 * ISO code of the language to fallback to when the specified language entries
	 * cannot be found.
	 *
	 * @var string
	 */
	const FALLBACK_LANGUAGE = 'en';
	
	/**
	 * @var string	Path to MXP root
	 */
	protected $mx_root_path;
	/**
	 * @var string	Path to phpBB's root
	 */
	protected $phpbb_root_path;
	/**
	 * @var string	Path to Module root
	 */
	protected $module_root_path;	
	/**
	 * @var string	Extension of PHP files
	 */
	protected $php_ext;

	/**
	 * @var \phpbb\extension\manager	Extension manager
	 */
	protected $extension_manager;

	/**
	 * Constructor
	 *
	 * @param string	$phpbb_root_path	Path to phpBB's root
	 * @param string	$php_ext Extension of PHP files
	 */
	public function __construct()
	{
		global $mx_root_path, $phpbb_root_path, $module_root_path;
		
		$this->mx_root_path	= $mx_root_path;
		$this->phpbb_root_path	= $phpbb_root_path;
		$this->module_root_path	= $module_root_path;		
		$this->php_ext = substr(strrchr(__FILE__, '.'), 1);
		
		$this->extension_manager = null;
	}

	/**
	 * Function to set user's language to display.
	 *
	 * @param string	$user_lang_iso		ISO code of the User's language
	 * @param bool		$reload				Whether or not to reload language files
	 */
	public function set_user_language($user_lang_iso, $reload = false)
	{
		$this->user_language = $user_lang_iso;

		$this->set_fallback_array($reload);
	}

	/**
	 * Function to set the board's default language to display.
	 *
	 * @param string	$default_lang_iso	ISO code of the board's default language
	 * @param bool		$reload				Whether or not to reload language files
	 */
	public function set_default_language($default_lang_iso, $reload = false)
	{
		$this->default_language = $default_lang_iso;

		$this->set_fallback_array($reload);
	}

	/**
	 * Returns language fallback data
	 *
	 * @param bool	$reload	Whether or not to reload language files
	 *
	 * @return array
	 */
	protected function set_fallback_array($reload = false)
	{
		$fallback_array = array();

		if ($this->user_language)
		{
			$fallback_array[] = $this->user_language;
		}

		if ($this->default_language)
		{
			$fallback_array[] = $this->default_language;
		}

		$fallback_array[] = self::FALLBACK_LANGUAGE;

		$this->language_fallback = $fallback_array;

		if ($reload)
		{
			$this->reload_language_files();
		}
	}

	/**
	 * Extension manager setter
	 *
	 * @param \phpbb\extension\manager	$extension_manager	Extension manager
	 */
	public function set_extension_manager()
	{
		$extension_manager = new mx_user();
		$this->extension_manager = $extension_manager;
	}

	/**
	 * Loads language array for the given component
	 *
	 * @param string		$component	Name of the language component
	 * @param string|array	$locale		ISO code of the language to load, or array of ISO codes if you want to
	 * 									specify additional language fallback steps
	 * @param array			$lang		Array reference containing language strings
	 */
	public function load($component, $locale, &$lang)
	{
		$locale = (array) $locale;

		// Determine path to language directory
		//$path = array($this->phpbb_root_path . 'language/', $this->mx_root_path . '/includes/shared/phpbb2/language/', $this->mx_root_path . '/includes/shared/phpbb3/language/');
		$path = $this->mx_root_path . '/includes/shared/phpbb3/language/';

		$this->load_file($path, $component, $locale, $lang);
	}
	/**
	 * Load core language file
	 *
	 * @param string	$component	Name of the component to load
	 */
	protected function load_core_file($component)
	{
		// Check if the component is already loaded
		if (isset($this->loaded_language_sets['PHPBB'][$component]))
		{
			return;
		}

		$this->loader->load($component, $this->language_fallback, $this->lang);
		$this->loaded_language_sets['PHPBB'][$component] = true;
	}
	/**
	 * Loads language array for the given extension component
	 *
	 * @param string		$extension	Name of the extension
	 * @param string		$component	Name of the language component
	 * @param string|array	$locale ISO code of the language to load, or array of ISO codes if you want to
	 * 					specify additional language fallback steps
	 * @param array	$lang	Array reference containing language strings
	 */
	public function load_extension($extension, $component, $locale = '', &$lang = '')
	{
		// Check if extension manager was loaded
		if ($this->extension_manager === null)
		{
			// If not, let's return
			return;
		}
		$locale = !empty($locale) ? (array) $locale : $this->language_fallback;
		
		$lang = !empty($lang) ? $lang : $this->lang;
		
		// Determine path to language directory
		$path = $this->extension_manager->get_extension_path($extension, true) . 'language/';

		$this->load_file($path, $component, $locale, $lang);
	}

	/**
	 * Prepares language file loading
	 *
	 * @param string	$path		Path to search for file in
	 * @param string	$component	Name of the language component
	 * @param array		$locale		Array containing language fallback options
	 * @param array		$lang		Array reference of language strings
	 */
	protected function load_file($path, $component, $locale, &$lang)
	{
		if (!is_array($path))
		{
			// This is BC stuff and not the best idea as it makes language fallback
			// implementation quite hard like below.
			if (strpos($this->phpbb_root_path . $component, $path) === 0)
			{
				// Filter out the path
				$path_diff = str_replace($path, '', dirname($this->phpbb_root_path . $component));
				$language_file = basename($component, '.' . $this->php_ext);
				$component = '';

				// This step is needed to resolve language/en/subdir style $component
				// $path already points to the language base directory so we need to eliminate
				// the first directory from the path (that should be the language directory)
				$path_diff_parts = explode('/', $path_diff);

				if (count($path_diff_parts) > 1)
				{
					array_shift($path_diff_parts);
					$component = implode('/', $path_diff_parts) . '/';
				}

				$component .= $language_file;
			}

			// Determine filename
			$filename = $component . '.' . $this->php_ext;
			
			// Determine path to file
			$file_path = $this->get_language_file_path($path, $filename, $locale);
			
			// Load language array
			$this->load_language_file($file_path, $lang);
		
		}
		else
		{
			foreach ($path as $file_path)
			{
				// This is BC stuff and not the best idea as it makes language fallback
				// implementation quite hard like below.
				if (strpos($this->phpbb_root_path . $component, $file_path) === 0)
				{
					// Filter out the path
					$path_diff = str_replace($file_path, '', dirname($this->phpbb_root_path . $component));
					$language_file = basename($component, '.' . $this->php_ext);
					$component = '';

					// This step is needed to resolve language/en/subdir style $component
					// $path already points to the language base directory so we need to eliminate
					// the first directory from the path (that should be the language directory)
					$path_diff_parts = explode('/', $path_diff);

					if (count($path_diff_parts) > 1)
					{
						array_shift($path_diff_parts);
						$component = implode('/', $path_diff_parts) . '/';
					}

					$component .= $language_file;
				}

				// Determine filename
				$filename = $component . '.' . $this->php_ext;
				
				// Determine path to file
				$file_path = $this->get_language_file_path($file_path, $filename, $locale);
				
				// Load language array
				$this->load_language_file($file_path, $lang);
			}
		}
	}

	/**
	 * This function implements language fallback logic
	 *
	 * @param string	$path		Path to language directory
	 * @param string	$filename	Filename to load language strings from
	 *
	 * @return string	Relative path to language file
	 *
	 * @throws language_file_not_found	When the path to the file cannot be resolved
	 */
	protected function get_language_file_path($path, $filename, $locales)
	{
		$language_file_path = $filename;
		
		// Language fallback logic
		foreach ($locales as $locale)
		{
			$language_file_path = $path . $locale . '/' . $filename;
			
			// If we are in install, try to use the updated version, when available
			if (defined('IN_INSTALL'))
			{
				$install_language_path = str_replace('language/', 'install/update/new/language/', $language_file_path);
				if (file_exists($install_language_path))
				{
					return $install_language_path;
				}
			}

			if (file_exists($language_file_path))
			{
				return $language_file_path;
			}
		}

		// The language file is not exist throw new language_file_not_found(
		print_r('Language file (get_language_file_path) ' . $language_file_path . ' couldn\'t be opened.');
	}

	/**
	 * Loads language file
	 *
	 * @param string	$path	Path to language file to load
	 * @param array	$lang	Reference of the array of language strings
	 */
	protected function load_language_file($path, &$lang)
	{
		// Do not suppress error if in DEBUG mode
		if (defined('DEBUG'))
		{
			include $path;
		}
		else
		{
			@include $path;
		}
	}
}
/**
 * 
 */

/**
 * 
 */
interface IException
{
    /* Protected methods inherited from Exception class */
    public function getMessage();                 // Exception message
    public function getCode();                    // User-defined Exception code
    public function getFile();                    // Source filename
    public function getLine();                    // Source line
    public function getTrace();                   // An array of the backtrace()
    public function getTraceAsString();           // Formated string of trace
   
    /* Overrideable methods inherited from Exception class */
    public function __toString();                 // formated string for display
    public function __construct($message = null, $code = 0);
}
/**
 * Class runtime_exception
 *
 * Define an exception which support a language var as message.
 */
abstract class runtime_exception extends Exception implements IException
{
	/**
	 * Parameters to use with the language var.
	 *
	 * @var array
	 */
	protected $message = 'Unknown exception';     // Exception message
    private   $string;                            // Unknown
    protected $code    = 0;                       // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private   $trace;                             // Unknown

	/**
	 * Constructor
	 *
	 * @param string		$message	The Exception message to throw (must be a language variable).
	 * @param integer		$code		The Exception code.
	 */
	public function __construct($message = "", $code = 0)
	{
        if (!empty($message)) 
		{
            //throw new $this('Unknown '. get_class($this));
			print_r($message);
        }
        //parent::__construct($message, $code);
	}
	/**
	 * {@inheritdoc}
	 */
	public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n" . "{$this->getTraceAsString()}";
    }	
	/**
	 */	
}   
/**
 *
 */
/**
 * Wrapper class for loading translations
 */
class mx_language extends mx_language_file_loader
{
	/**
	 * Global fallback language
	 *
	 * ISO code of the language to fallback to when the specified language entries
	 * cannot be found.
	 *
	 * @var string
	 */
	const FALLBACK_LANGUAGE = 'en';

	/**
	 * @var array	List of common language files
	 */
	protected $common_language_files;

	/**
	 * @var bool
	 */
	protected $common_language_files_loaded;

	/**
	 * @var string	ISO code of the default board language
	 */
	protected $default_language;

	/**
	 * @var string	ISO code of the User's language
	 */
	protected $user_language;

	/**
	 * @var array	Language fallback array (the order is important)
	 */
	protected $language_fallback;

	/**
	 * @var array	Array of language variables
	 */
	protected $lang;

	/**
	 * @var array	Loaded language sets
	 */
	protected $loaded_language_sets;

	/**
	 * @var \phpbb\language\language_file_loader Language file loader
	 */
	protected $loader;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language_file_loader	$loader			Language file loader
	 * @param array|null							$common_modules	Array of common language modules to load (optional)
	 */
	public function __construct($common_modules = null)
	{
		$this->loader = $this;

		global $board_config, $mx_user;	
		global $mx_root_path, $phpbb_root_path, $module_root_path;
		
		$this->mx_root_path	= $mx_root_path;
		$this->phpbb_root_path	= $phpbb_root_path;
		$this->module_root_path	= $module_root_path;
		
		$this->user	= $mx_user;	
		$this->config = $board_config;
		$this->backend = PORTAL_BACKEND;
		$this->php_ext = substr(strrchr(__FILE__, '.'), 1);
		// Set up default information
		$this->user_language		= false;
		$this->default_language		= false;
		$this->lang					= array();
		$this->loaded_language_sets	= array(
			'MXP'	=> array(), //mxp_core
			'MODS'	=> array(), //mxp_modules
			'PHPBB'	=> array(), //phpbb_core
			'phpbb_ext'	=> array(),	//phpbb_ext
		);		
		// Common language files
		if (is_array($common_modules))
		{
			$this->common_language_files = $common_modules;
		}
		else
		{
			$this->common_language_files = array(
				'common',
			);
		}
		$this->common_language_files_loaded = false;
		$this->language_fallback = array(self::FALLBACK_LANGUAGE);
	}
	/**
	 * encode_lang
	 *
	 * $default_lang = $language->encode_lang($config['default_lang']);
	 *
	 * @param unknown_type $lang
	 * @return unknown
	 */
	function encode_lang($lang)
	{
			if ($this->backend == 'phpbb2')
			{
				return $lang;
			}
			else
			{
				$lang = str_replace('lang_', '', $lang);
			}			
			
			switch($lang)
			{
				case 'afar':
					$lang_name = 'aa';
				break;
				case 'abkhazian':
					$lang_name = 'ab';
				break;
				case 'avestan':
					$lang_name = 'ae';
				break;
				case 'afrikaans':
					$lang_name = 'af';
				break;
				case 'akan':
					$lang_name = 'ak';
				break;
				case 'amharic':
					$lang_name = 'am';
				break;
				case 'aragonese':
					$lang_name = 'an';
				break;
				case 'arabic':
					$lang_name = 'ar';
				break;
				case 'assamese':
					$lang_name = 'as';
				break;
				case 'avaric':
					$lang_name = 'av';
				break;
				case 'aymara':
					$lang_name = 'ay';
				break;
				case 'azerbaijani':
					$lang_name = 'az';
				break;
				case 'bashkir':
					$lang_name = 'ba';
				break;
				case 'belarusian':
					$lang_name = 'be';
				break;
				case 'bulgarian':
					$lang_name = 'bg';
				break;
				case 'bihari':
					$lang_name = 'bh';
				break;
				case 'bislama':
					$lang_name = 'bi';
				break;
				case 'bambara':
					$lang_name = 'bm';
				break;
				case 'bengali':
					$lang_name = 'bn';
				break;
				case 'tibetan':
					$lang_name = 'bo';
				break;
				case 'breton':
					$lang_name = 'br';
				break;
				case 'bosnian':
					$lang_name = 'bs';
				break;
				case 'catalan':
					$lang_name = 'ca';
				break;
				case 'chechen':
					$lang_name = 'ce';
				break;
				case 'chamorro':
					$lang_name = 'ch';
				break;
				case 'corsican':
					$lang_name = 'co';
				break;
				case 'cree':
					$lang_name = 'cr';
				break;
				case 'czech':
					$lang_name = 'cs';
				break;
				case 'slavonic':
					$lang_name = 'cu';
				break;
				case 'chuvash':
					$lang_name = 'cv';
				break;
				case 'welsh_cymraeg':
					$lang_name = 'cy';
				break;
				case 'danish':
					$lang_name = 'da';
				break;
				case 'german':
					$lang_name = 'de';
				break;
				case 'divehi':
					$lang_name = 'dv';
				break;
				case 'dzongkha':
					$lang_name = 'dz';
				break;
				case 'ewe':
					$lang_name = 'ee';
				break;
				case 'greek':
					$lang_name = 'el';
				break;
				case 'hebrew':
					$lang_name = 'he';
				break;
				case 'english':
					$lang_name = 'en';
				break;
				case 'english_us':
					$lang_name = 'en_us';
				break;
				case 'esperanto':
					$lang_name = 'eo';
				break;
				case 'spanish':
					$lang_name = 'es';
				break;
				case 'estonian':
					$lang_name = 'et';
				break;
				case 'basque':
					$lang_name = 'eu';
				break;
				case 'persian':
					$lang_name = 'fa';
				break;
				case 'fulah':
					$lang_name = 'ff';
				break;
				case 'finnish':
					$lang_name = 'fi';
				break;
				case 'fijian':
					$lang_name = 'fj';
				break;
				case 'faroese':
					$lang_name = 'fo';
				break;
				case 'french':
					$lang_name = 'fr';
				break;
				case 'frisian':
					$lang_name = 'fy';
				break;
				case 'irish':
					$lang_name = 'ga';
				break;
				case 'scottish':
					$lang_name = 'gd';
				break;
				case 'galician':
					$lang_name = 'gl';
				break;
				case 'guaraní­':
					$lang_name = 'gn';
				break;
				case 'gujarati':
					$lang_name = 'gu';
				break;
				case 'manx':
					$lang_name = 'gv';
				break;
				case 'hausa':
					$lang_name = 'ha';
				break;
				case 'hebrew':
					$lang_name = 'he';
				break;
				case 'hindi':
					$lang_name = 'hi';
				break;
				case 'hiri_motu':
					$lang_name = 'ho';
				break;
				case 'croatian':
					$lang_name = 'hr';
				break;
				case 'haitian':
					$lang_name = 'ht';
				break;
				case 'hungarian':
					$lang_name = 'hu';
				break;
				case 'armenian':
					$lang_name = 'hy';
				break;
				case 'herero':
					$lang_name = 'hz';
				break;
				case 'interlingua':
					$lang_name = 'ia';
				break;
				case 'indonesian':
					$lang_name = 'id';
				break;
				case 'interlingue':
					$lang_name = 'ie';
				break;
				case 'igbo':
					$lang_name = 'ig';
				break;
				case 'sichuan_yi':
					$lang_name = 'ii';
				break;
				case 'inupiaq':
					$lang_name = 'ik';
				break;
				case 'ido':
					$lang_name = 'io';
				break;
				case 'icelandic':
					$lang_name = 'is';
				break;
				case 'italian':
					$lang_name = 'it';
				break;
				case 'inuktitut':
					$lang_name = 'iu';
				break;
				case 'japanese':
					$lang_name = 'ja';
				break;
				case 'javanese':
					$lang_name = 'jv';
				break;
				case 'georgian':
					$lang_name = 'ka';
				break;
				case 'kongo':
					$lang_name = 'kg';
				break;
				case 'kikuyu':
					$lang_name = 'ki';
				break;
				case 'kwanyama':
					$lang_name = 'kj';
				break;
				case 'kazakh':
					$lang_name = 'kk';
				break;
				case 'kalaallisut':
					$lang_name = 'kl';
				break;
				case 'khmer':
					$lang_name = 'km';
				break;
				case 'kannada':
					$lang_name = 'kn';
				break;
				case 'korean':
					$lang_name = 'ko';
				break;
				case 'kanuri':
					$lang_name = 'kr';
				break;
				case 'kashmiri':
					$lang_name = 'ks';
				break;
				case 'kurdish':
					$lang_name = 'ku';
				break;
				case 'kv':
					$lang_name = 'komi';
				break;
				case 'cornish_kernewek':
					$lang_name = 'kw';
				break;
				case 'kirghiz':
					$lang_name = 'ky';
				break;
				case 'latin':
					$lang_name = 'la';
				break;
				case 'luxembourgish':
					$lang_name = 'lb';
				break;
				case 'ganda':
					$lang_name = 'lg';
				break;
				case 'limburgish':
					$lang_name = 'li';
				break;
				case 'lingala':
					$lang_name = 'ln';
				break;
				case 'lao':
					$lang_name = 'lo';
				break;
				case 'lithuanian':
					$lang_name = 'lt';
				break;
				case 'luba-katanga':
					$lang_name = 'lu';
				break;
				case 'latvian':
					$lang_name = 'lv';
				break;
				case 'malagasy':
					$lang_name = 'mg';
				break;
				case 'marshallese':
					$lang_name = 'mh';
				break;
				case 'maori':
					$lang_name = 'mi';
				break;
				case 'macedonian':
					$lang_name = 'mk';
				break;
				case 'malayalam':
					$lang_name = 'ml';
				break;
				case 'mongolian':
					$lang_name = 'mn';
				break;
				case 'moldavian':
					$lang_name = 'mo';
				break;
				case 'marathi':
					$lang_name = 'mr';
				break;
				case 'malay':
					$lang_name = 'ms';
				break;
				case 'maltese':
					$lang_name = 'mt';
				break;
				case 'burmese':
					$lang_name = 'my';
				break;
				case 'nauruan':
					$lang_name = 'na';
				break;
				case 'norwegian':
					$lang_name = 'nb';
				break;
				case 'ndebele':
					$lang_name = 'nd';
				break;
				case 'nepali':
					$lang_name = 'ne';
				break;
				case 'ndonga':
					$lang_name = 'ng';
				break;
				case 'dutch':
					$lang_name = 'nl';
				break;
				case 'norwegian_nynorsk':
					$lang_name = 'nn';
				break;
				case 'norwegian':
					$lang_name = 'no';
				break;
				case 'southern_ndebele':
					$lang_name = 'nr';
				break;
				case 'navajo':
					$lang_name = 'nv';
				break;
				case 'chichewa':
					$lang_name = 'ny';
				break;
				case 'occitan':
					$lang_name = 'oc';
				break;
				case 'ojibwa':
					$lang_name = 'oj';
				break;
				case 'oromo':
					$lang_name = 'om';
				break;
				case 'oriya':
					$lang_name = 'or';
				break;
				case 'ossetian':
					$lang_name = 'os';
				break;
				case 'panjabi':
					$lang_name = 'pa';
				break;
				case 'pali':
					$lang_name = 'pi';
				break;
				case 'polish':
					$lang_name = 'pl';
				break;
				case 'pashto':
					$lang_name = 'ps';
				break;
				case 'portuguese':
					$lang_name = 'pt';
				break;
				case 'portuguese_brasil':
					$lang_name = 'pt_br';
				break;
				case 'quechua':
					$lang_name = 'qu';
				break;
				case 'romansh':
					$lang_name = 'rm';
				break;
				case 'kirundi':
					$lang_name = 'rn';
				break;
				case 'romanian':
					$lang_name = 'ro';
				break;
				case 'russian':
					$lang_name = 'ru';
				break;
				case 'kinyarwanda':
					$lang_name = 'rw';
				break;
				case 'sanskrit':
					$lang_name = 'sa';
				break;
				case 'sardinian':
					$lang_name = 'sc';
				break;
				case 'sindhi':
					$lang_name = 'sd';
				break;
				case 'northern_sami':
					$lang_name = 'se';
				break;
				case 'sango':
					$lang_name = 'sg';
				break;
				case 'serbo-croatian':
					$lang_name = 'sh';
				break;
				case 'sinhala':
					$lang_name = 'si';
				break;
				case 'slovak':
					$lang_name = 'sk';
				break;
				case 'slovenian':
					$lang_name = 'sl';
				break;
				case 'samoan':
					$lang_name = 'sm';
				break;
				case 'shona':
					$lang_name = 'sn';
				break;
				case 'somali':
					$lang_name = 'so';
				break;
				case 'albanian':
					$lang_name = 'sq';
				break;
				case 'serbian':
					$lang_name = 'sr';
				break;
				case 'swati':
					$lang_name = 'ss';
				break;
				case 'sotho':
					$lang_name = 'st';
				break;
				case 'sundanese':
					$lang_name = 'su';
				break;
				case 'swedish':
					$lang_name = 'sv';
				break;
				case 'swahili':
					$lang_name = 'sw';
				break;
				case 'tamil':
					$lang_name = 'ta';
				break;
				case 'telugu':
					$lang_name = 'te';
				break;
				case 'tajik':
					$lang_name = 'tg';
				break;
				case 'thai':
					$lang_name = 'th';
				break;
				case 'tigrinya':
					$lang_name = 'ti';
				break;
				case 'turkmen':
					$lang_name = 'tk';
				break;
				case 'tagalog':
					$lang_name = 'tl';
				break;
				case 'tswana':
					$lang_name = 'tn';
				break;
				case 'tonga':
					$lang_name = 'to';
				break;
				case 'turkish':
					$lang_name = 'tr';
				break;
				case 'tsonga':
					$lang_name = 'ts';
				break;
				case 'tatar':
					$lang_name = 'tt';
				break;
				case 'twi':
					$lang_name = 'tw';
				break;
				case 'tahitian':
					$lang_name = 'ty';
				break;
				case 'uighur':
					$lang_name = 'ug';
				break;
				case 'ukrainian':
					$lang_name = 'uk';
				break;
				case 'urdu':
					$lang_name = 'ur';
				break;
				case 'uzbek':
					$lang_name = 'uz';
				break;
				case 'venda':
					$lang_name = 've';
				break;
				case 'vietnamese':
					$lang_name = 'vi';
				break;
				case 'volapuk':
					$lang_name = 'vo';
				break;
				case 'walloon':
					$lang_name = 'wa';
				break;
				case 'wolof':
					$lang_name = 'wo';
				break;
				case 'xhosa':
					$lang_name = 'xh';
				break;
				case 'yiddish':
					$lang_name = 'yi';
				break;
				case 'yoruba':
					$lang_name = 'yo';
				break;
				case 'zhuang':
					$lang_name = 'za';
				break;
				case 'chinese':
					$lang_name = 'zh';
				break;
				case 'chinese_simplified':
					$lang_name = 'zh_cmn_hans';
				break;
				case 'chinese_traditional':
					$lang_name = 'zh_cmn_hant';
				break;
				case 'zulu':
					$lang_name = 'zu';
				break;
				default:
					$lang_name = (strlen($lang) > 2) ? substr($lang, 0, 2) : $lang;
				break;
			}
		return $lang_name;
	}
	
	function ucstrreplace($pattern = '%{$regex}%i', $matches = '', $string) 
	{
		/* return with no uppercase if patern not in string */
		if (strpos($string, $pattern) === false)
		{
			/* known languages */
			switch($string)
			{
				case 'aa':
					$lang_name = 'afar';
				break;
				case 'ab':
					$lang_name = 'abkhazian';
				break;
				case 'ae':
					$lang_name = 'avestan';
				break;
				case 'af':
					$lang_name = 'afrikaans';
				break;
				case 'ak':
					$lang_name = 'akan';
				break;
				case 'am':
					$lang_name = 'amharic';
				break;
				case 'an':
					$lang_name = 'aragonese';
				break;
				case 'ar':
					$lang_name = 'arabic';
				break;
				case 'as':
					$lang_name = 'assamese';
				break;
				case 'av':
					$lang_name = 'avaric';
				break;
				case 'ay':
					$lang_name = 'aymara';
				break;
				case 'az':
					$lang_name = 'azerbaijani';
				break;
				case 'ba':
					$lang_name = 'bashkir';
				break;
				case 'be':
					$lang_name = 'belarusian';
				break;
				case 'bg':
					$lang_name = 'bulgarian';
				break;
				case 'bh':
					$lang_name = 'bihari';
				break;
				case 'bi':
					$lang_name = 'bislama';
				break;
				case 'bm':
					$lang_name = 'bambara';
				break;
				case 'bn':
					$lang_name = 'bengali';
				break;
				case 'bo':
					$lang_name = 'tibetan';
				break;
				case 'br':
					$lang_name = 'breton';
				break;
				case 'bs':
					$lang_name = 'bosnian';
				break;
				case 'ca':
					$lang_name = 'catalan';
				break;
				case 'ce':
					$lang_name = 'chechen';
				break;
				case 'ch':
					$lang_name = 'chamorro';
				break;
				case 'co':
					$lang_name = 'corsican';
				break;
				case 'cr':
					$lang_name = 'cree';
				break;
				case 'cs':
					$lang_name = 'czech';
				break;
				case 'cu':
					$lang_name = 'slavonic';
				break;
				case 'cv':
					$lang_name = 'chuvash';
				break;
				case 'cy':
					$lang_name = 'welsh_cymraeg';
				break;
				case 'da':
					$lang_name = 'danish';
				break;
				case 'de':
					$lang_name = 'german';
				break;
				case 'dv':
					$lang_name = 'divehi';
				break;
				case 'dz':
					$lang_name = 'dzongkha';
				break;
				case 'ee':
					$lang_name = 'ewe';
				break;
				case 'el':
					$lang_name = 'greek';
				break;
				case 'he':
					$lang_name = 'hebrew';
				break;
				case 'en':
					$lang_name = 'english';
				break;
				case 'en_us':
					$lang_name = 'english';
				break;
				case 'eo':
					$lang_name = 'esperanto';
				break;
				case 'es':
					$lang_name = 'spanish';
				break;
				case 'et':
					$lang_name = 'estonian';
				break;
				case 'eu':
					$lang_name = 'basque';
				break;
				case 'fa':
					$lang_name = 'persian';
				break;
				case 'ff':
					$lang_name = 'fulah';
				break;
				case 'fi':
					$lang_name = 'finnish';
				break;
				case 'fj':
					$lang_name = 'fijian';
				break;
				case 'fo':
					$lang_name = 'faroese';
				break;
				case 'fr':
					$lang_name = 'french';
				break;
				case 'fy':
					$lang_name = 'frisian';
				break;
				case 'ga':
					$lang_name = 'irish';
				break;
				case 'gd':
					$lang_name = 'scottish';
				break;
				case 'gl':
					$lang_name = 'galician';
				break;
				case 'gn':
					$lang_name = 'guaraní';
				break;
				case 'gu':
					$lang_name = 'gujarati';
				break;
				case 'gv':
					$lang_name = 'manx';
				break;
				case 'ha':
					$lang_name = 'hausa';
				break;
				case 'he':
					$lang_name = 'hebrew';
				break;
				case 'hi':
					$lang_name = 'hindi';
				break;
				case 'ho':
					$lang_name = 'hiri_motu';
				break;
				case 'hr':
					$lang_name = 'croatian';
				break;
				case 'ht':
					$lang_name = 'haitian';
				break;
				case 'hu':
					$lang_name = 'hungarian';
				break;
				case 'hy':
					$lang_name = 'armenian';
				break;
				case 'hz':
					$lang_name = 'herero';
				break;
				case 'ia':
					$lang_name = 'interlingua';
				break;
				case 'id':
					$lang_name = 'indonesian';
				break;
				case 'ie':
					$lang_name = 'interlingue';
				break;
				case 'ig':
					$lang_name = 'igbo';
				break;
				case 'ii':
					$lang_name = 'sichuan_yi';
				break;
				case 'ik':
					$lang_name = 'inupiaq';
				break;
				case 'io':
					$lang_name = 'ido';
				break;
				case 'is':
					$lang_name = 'icelandic';
				break;
				case 'it':
					$lang_name = 'italian';
				break;
				case 'iu':
					$lang_name = 'inuktitut';
				break;
				case 'ja':
					$lang_name = 'japanese';
				break;
				case 'jv':
					$lang_name = 'javanese';
				break;
				case 'ka':
					$lang_name = 'georgian';
				break;
				case 'kg':
					$lang_name = 'kongo';
				break;
				case 'ki':
					$lang_name = 'kikuyu';
				break;
				case 'kj':
					$lang_name = 'kwanyama';
				break;
				case 'kk':
					$lang_name = 'kazakh';
				break;
				case 'kl':
					$lang_name = 'kalaallisut';
				break;
				case 'km':
					$lang_name = 'khmer';
				break;
				case 'kn':
					$lang_name = 'kannada';
				break;
				case 'ko':
					$lang_name = 'korean';
				break;
				case 'kr':
					$lang_name = 'kanuri';
				break;
				case 'ks':
					$lang_name = 'kashmiri';
				break;
				case 'ku':
					$lang_name = 'kurdish';
				break;
				case 'kv':
					$lang_name = 'komi';
				break;
				case 'kw':
					$lang_name = 'cornish_kernewek';
				break;
				case 'ky':
					$lang_name = 'kirghiz';
				break;
				case 'la':
					$lang_name = 'latin';
				break;
				case 'lb':
					$lang_name = 'luxembourgish';
				break;
				case 'lg':
					$lang_name = 'ganda';
				break;
				case 'li':
					$lang_name = 'limburgish';
				break;
				case 'ln':
					$lang_name = 'lingala';
				break;
				case 'lo':
					$lang_name = 'lao';
				break;
				case 'lt':
					$lang_name = 'lithuanian';
				break;
				case 'lu':
					$lang_name = 'luba-katanga';
				break;
				case 'lv':
					$lang_name = 'latvian';
				break;
				case 'mg':
					$lang_name = 'malagasy';
				break;
				case 'mh':
					$lang_name = 'marshallese';
				break;
				case 'mi':
					$lang_name = 'maori';
				break;
				case 'mk':
					$lang_name = 'macedonian';
				break;
				case 'ml':
					$lang_name = 'malayalam';
				break;
				case 'mn':
					$lang_name = 'mongolian';
				break;
				case 'mo':
					$lang_name = 'moldavian';
				break;
				case 'mr':
					$lang_name = 'marathi';
				break;
				case 'ms':
					$lang_name = 'malay';
				break;
				case 'mt':
					$lang_name = 'maltese';
				break;
				case 'my':
					$lang_name = 'burmese';
				break;
				case 'na':
					$lang_name = 'nauruan';
				break;
				case 'nb':
					$lang_name = 'norwegian';
				break;
				case 'nd':
					$lang_name = 'ndebele';
				break;
				case 'ne':
					$lang_name = 'nepali';
				break;
				case 'ng':
					$lang_name = 'ndonga';
				break;
				case 'nl':
					$lang_name = 'dutch';
				break;
				case 'nn':
					$lang_name = 'norwegian_nynorsk';
				break;
				case 'no':
					$lang_name = 'norwegian';
				break;
				case 'nr':
					$lang_name = 'southern_ndebele';
				break;
				case 'nv':
					$lang_name = 'navajo';
				break;
				case 'ny':
					$lang_name = 'chichewa';
				break;
				case 'oc':
					$lang_name = 'occitan';
				break;
				case 'oj':
					$lang_name = 'ojibwa';
				break;
				case 'om':
					$lang_name = 'oromo';
				break;
				case 'or':
					$lang_name = 'oriya';
				break;
				case 'os':
					$lang_name = 'ossetian';
				break;
				case 'pa':
					$lang_name = 'panjabi';
				break;
				case 'pi':
					$lang_name = 'pali';
				break;
				case 'pl':
					$lang_name = 'polish';
				break;
				case 'ps':
					$lang_name = 'pashto';
				break;
				case 'pt':
					$lang_name = 'portuguese';
				break;
				case 'pt_br':
					$lang_name = 'portuguese_brasil';
				break;
				case 'qu':
					$lang_name = 'quechua';
				break;
				case 'rm':
					$lang_name = 'romansh';
				break;
				case 'rn':
					$lang_name = 'kirundi';
				break;
				case 'ro':
					$lang_name = 'romanian';
				break;
				case 'ru':
					$lang_name = 'russian';
				break;
				case 'rw':
					$lang_name = 'kinyarwanda';
				break;
				case 'sa':
					$lang_name = 'sanskrit';
				break;
				case 'sc':
					$lang_name = 'sardinian';
				break;
				case 'sd':
					$lang_name = 'sindhi';
				break;
				case 'se':
					$lang_name = 'northern_sami';
				break;
				case 'sg':
					$lang_name = 'sango';
				break;
				case 'sh':
					$lang_name = 'serbo-croatian';
				break;
				case 'si':
					$lang_name = 'sinhala';
				break;
				case 'sk':
					$lang_name = 'slovak';
				break;
				case 'sl':
					$lang_name = 'slovenian';
				break;
				case 'sm':
					$lang_name = 'samoan';
				break;
				case 'sn':
					$lang_name = 'shona';
				break;
				case 'so':
					$lang_name = 'somali';
				break;
				case 'sq':
					$lang_name = 'albanian';
				break;
				case 'sr':
					$lang_name = 'serbian';
				break;
				case 'ss':
					$lang_name = 'swati';
				break;
				case 'st':
					$lang_name = 'sotho';
				break;
				case 'su':
					$lang_name = 'sundanese';
				break;
				case 'sv':
					$lang_name = 'swedish';
				break;
				case 'sw':
					$lang_name = 'swahili';
				break;
				case 'ta':
					$lang_name = 'tamil';
				break;
				case 'te':
					$lang_name = 'telugu';
				break;
				case 'tg':
					$lang_name = 'tajik';
				break;
				case 'th':
					$lang_name = 'thai';
				break;
				case 'ti':
					$lang_name = 'tigrinya';
				break;
				case 'tk':
					$lang_name = 'turkmen';
				break;
				case 'tl':
					$lang_name = 'tagalog';
				break;
				case 'tn':
					$lang_name = 'tswana';
				break;
				case 'to':
					$lang_name = 'tonga';
				break;
				case 'tr':
					$lang_name = 'turkish';
				break;
				case 'ts':
					$lang_name = 'tsonga';
				break;
				case 'tt':
					$lang_name = 'tatar';
				break;
				case 'tw':
					$lang_name = 'twi';
				break;
				case 'ty':
					$lang_name = 'tahitian';
				break;
				case 'ug':
					$lang_name = 'uighur';
				break;
				case 'uk':
					$lang_name = 'ukrainian';
				break;
				case 'ur':
					$lang_name = 'urdu';
				break;
				case 'uz':
					$lang_name = 'uzbek';
				break;
				case 've':
					$lang_name = 'venda';
				break;
				case 'vi':
					$lang_name = 'vietnamese';
				break;
				case 'vo':
					$lang_name = 'volapuk';
				break;
				case 'wa':
					$lang_name = 'walloon';
				break;
				case 'wo':
					$lang_name = 'wolof';
				break;
				case 'xh':
					$lang_name = 'xhosa';
				break;
				case 'yi':
					$lang_name = 'yiddish';
				break;
				case 'yo':
					$lang_name = 'yoruba';
				break;
				case 'za':
					$lang_name = 'zhuang';
				break;
				case 'zh':
					$lang_name = 'chinese';
				break;
				case 'zh_cmn_hans':
					$lang_name = 'chinese_simplified';
				break;
				case 'zh_cmn_hant':
					$lang_name = 'chinese_traditional';
				break;
				case 'zu':
					$lang_name = 'zulu';
				break;
				default:
					$lang_name = (strlen($string) > 2) ? ucfirst(str_replace($pattern, '', $string)) : $string;
				break;
			}		
			return ucwords(str_replace(array(" ","-","_"), ' ', $lang_name));	
		}
		return ucwords(str_replace(array(" ","-","_"), ' ', str_replace($pattern, '', $string)));
	}
	
	/* replacement for eregi($pattern, $string); outputs 0 or 1*/
	function trisstr($pattern = '%{$regex}%i', $string = '', $matches = '') 
	{
		return preg_match('/' . $pattern . '/i', $string, $matches);	
	}
	
	/**
	 * Enter description here...
	 *
	 * @access private
	 * @param unknown_type $lang_mode
	 */	
	function _load_lang($path, $filename, $require = true, $user_lang = '')
	{
		$board_config = $this->config;		
		$php_ext = $this->php_ext;
		
		// Now only the root for mxp blocks
		$board_path = $path . 'language/lang_' . $board_config['default_lang'] . '/' . $filename . '.' . $php_ext;
		$default_path = $path . 'language/lang_english/' . $filename . '.' . $php_ext;
		$user_path = !empty($user_lang) ? $path . 'language/lang_' . $user_lang . '/' . $filename . '.' . $php_ext : $board_path;
		
		$phpbb_board_path = $path . 'language/' . $board_config['default_lang'] . '/' . $filename . '.' . $php_ext;
		$phpbb_default_path = $path . 'language/en/' . $filename . '.' . $php_ext;		
		$phpbb_user_path = !empty($user_lang) ? $path . 'language/' . $user_lang . '/' . $filename . '.' . $php_ext : $board_path;
		
		$lang = array();
		if (file_exists($user_path))
		{
			include_once($user_path);
		}
		else if ($require)
		{
			if (file_exists($board_path))
			{
				include_once($board_path);
			}
			else if (file_exists($default_path))
			{
				include_once($default_path);
			}
		}
		else if (file_exists($phpbb_user_path))
		{
			include_once($phpbb_user_path);
		}
		else if ($require)
		{
			if (file_exists($phpbb_board_path))
			{
				include_once($phpbb_board_path);
			}
			else if (file_exists($phpbb_default_path))
			{
				include_once($phpbb_default_path);
			}
		}		
		$this->lang = array_merge($this->lang, $lang);
	}	
	
	/**
	 * Loads common language files
	 */
	protected function load_common_language_files()
	{
		if (!$this->common_language_files_loaded)
		{	
			/*
			* Load MXP lang keys
			* Load vanilla phpBB2 lang files for old modules if is possible
			*/
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'smf2':
				case 'mybb':
					
					//Load shared phpBB2 language files for old modules				
					$shared_lang_path = $this->mx_root_path . 'includes/shared/phpbb2/language/';					
					
					// AdminCP
					if (defined('IN_ADMIN'))
					{
						// Shared phpBB2 AdminCP keys
						$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb2/', 'lang_admin');
						// Core MXP AdminCP 
						$this->_load_lang($this->mx_root_path, 'lang_admin');
						//Load Shared phpBB3 common language file
						$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb3/', 'acp/common');
					}					
					// Shared phpBB keys
					$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb2/', 'lang_main');
					// Core Main Translation after shared phpBB keys so we can overwrite some settings
					$this->_load_lang($this->mx_root_path, 'lang_main');	
					//Load Shared phpBB3 common language file
					$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb3/', 'common');	
				break;
				
				case 'phpbb2':
					
					//Load vanilla phpBB2 language files for old modules if is possible				
					$shared_lang_path = $this->mx_root_path . 'includes/shared/phpbb2/language/';					
					
					// AdminCP
					if (defined('IN_ADMIN'))
					{
						// Load vanilla phpBB2 AdminCP keys
						$this->_load_lang($this->phpbb_root_path, 'lang_admin');
						// Core MXP AdminCP 
						$this->_load_lang($this->mx_root_path, 'lang_admin');
						//Load Shared phpBB3 AdminCP common language file
						$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb3/', 'acp/common');
					}					
					// Load vanilla phpBB2 keys
					$this->_load_lang($this->phpbb_root_path, 'lang_main');
					// Core Main Translation after shared phpBB keys so we can overwrite some settings
					$this->_load_lang($this->mx_root_path, 'lang_main');
					//Load Shared phpBB3 common language file
					$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb3/', 'common');
				break;
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
				case 'proteus':
				default:					
					//Load vanilla phpBB3 common language files for new modules if is possible				
					$shared_lang_path = $this->mx_root_path . 'includes/shared/phpbb2/language/';					
					
					// AdminCP
					if (defined('IN_ADMIN'))
					{
						// Shared phpBB2 AdminCP keys
						$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb2/', 'lang_admin');
						// Core MXP  AdminCP
						$this->_load_lang($this->mx_root_path, 'lang_admin');						
						//Load vanilla phpBB3 AdminCP common language file							
						$this->_load_lang($this->phpbb_root_path, 'acp/common');						
					}					
					// Shared phpBB keys
					$this->_load_lang($this->mx_root_path . 'includes/shared/phpbb2/', 'lang_main');
					// Core Main Translation after shared phpBB keys so we can overwrite some settings
					$this->_load_lang($this->mx_root_path, 'lang_main');					
					//Load vanilla phpBB3 common language file					
					$this->_load_lang($this->phpbb_root_path, 'common');
				break;
			}	
			
			//
			// Load backend specific lang defs.
			//
			//$this->user->setup();	
			$this->common_language_files_loaded = true;
		}
	}	
	
	/**
	 * Returns the raw value associated to a language key or the language key no translation is available.
	 * No parameter substitution is performed, can be a string or an array.
	 *
	 * @param string|array	$key	Language key
	 *
	 * @return array|string
	 */
	public function lang_raw($key)
	{
		// Load common language files if they not loaded yet
		if (!$this->common_language_files_loaded)
		{
			$this->load_common_language_files();
		}
		
		if (is_array($key))
		{
			$lang = &$this->lang[array_shift($key)];
			foreach ($key as $_key)
			{
				$lang = &$lang[$_key];
			}
		}
		else
		{
			$lang = &$this->lang[$key];
		}
		
		// Return if language string does not exist
		if (!isset($lang) || (!is_string($lang) && !is_array($lang)))
		{
			return $key;
		}
		return $lang;
	}

	/**
	 * Act like lang() but takes a key and an array of parameters instead of using variadic
	 *
	 * @param string|array	$key	Language key
	 * @param array			$args	Parameters
	 *
	 * @return string
	 */
	public function lang_array($key, $args = array())
	{
		$lang = $this->lang_raw($key);
		
		if ($lang === $key)
		{
			return $key;
		}
		
		// If the language entry is a string, we simply mimic sprintf() behaviour
		if (is_string($lang))
		{
			if (count($args) === 0)
			{
				return $lang;
			}
			// Replace key with language entry and simply pass along...
			return vsprintf($lang, $args);
		}
		else if (count($lang) == 0)
		{
			// If the language entry is an empty array, we just return the language key
			return $key;
		}
		
		// It is an array... now handle different nullar/singular/plural forms
		$key_found = false;

		// We now get the first number passed and will select the key based upon this number
		for ($i = 0, $num_args = count($args); $i < $num_args; $i++)
		{
			if (is_int($args[$i]) || is_float($args[$i]))
			{
				if ($args[$i] == 0 && isset($lang[0]))
				{
					// We allow each translation using plural forms to specify a version for the case of 0 things,
					// so that "0 users" may be displayed as "No users".
					$key_found = 0;
					break;
				}
				else
				{
					$use_plural_form = $this->get_plural_form($args[$i]);
					if (isset($lang[$use_plural_form]))
					{
						// The key we should use exists, so we use it.
						$key_found = $use_plural_form;
					}
					else
					{
						// If the key we need to use does not exist, we fall back to the previous one.
						$numbers = array_keys($lang);

						foreach ($numbers as $num)
						{
							if ($num > $use_plural_form)
							{
								break;
							}
							$key_found = $num;
						}
					}
					break;
				}
			}
		}
		
		// Ok, let's check if the key was found, else use the last entry (because it is mostly the plural form)
		if ($key_found === false)
		{
			$numbers = array_keys($lang);
			$key_found = end($numbers);
		}
		// Use the language string we determined and pass it to sprintf()
		return vsprintf($lang[$key_found], $args);
	}	
	/**
	 * Determine which plural form we should use.
	 *
	 * For some languages this is not as simple as for English.
	 *
	 * @param int|float		$number		The number we want to get the plural case for. Float numbers are floored.
	 * @param int|bool		$force_rule	False to use the plural rule of the language package
	 *									or an integer to force a certain plural rule
	 *
	 * @return int	The plural-case we need to use for the number plural-rule combination
	 *
	 * @throws \phpbb\language\exception\invalid_plural_rule_exception	When $force_rule has an invalid value
	 */
	public function get_plural_form($number, $force_rule = false)
	{
		$number			= (int) $number;
		$plural_rule	= ($force_rule !== false) ? $force_rule : ((isset($this->lang['PLURAL_RULE'])) ? $this->lang['PLURAL_RULE'] : 1);

		if ($plural_rule > 15 || $plural_rule < 0)
		{
			throw new invalid_plural_rule_exception('INVALID_PLURAL_RULE', array(
				'plural_rule' => $plural_rule,
			));
		}

		/**
		 * The following plural rules are based on a list published by the Mozilla Developer Network
		 * https://developer.mozilla.org/en/Localization_and_Plurals
		 */
		switch ($plural_rule)
		{
			case 0:
				/**
				 * Families: Asian (Chinese, Japanese, Korean, Vietnamese), Persian, Turkic/Altaic (Turkish), Thai, Lao
				 * 1 - everything: 0, 1, 2, ...
				 */
			return 1;
			case 1:
				/**
				 * Families: Germanic (Danish, Dutch, English, Faroese, Frisian, German, Norwegian, Swedish), Finno-Ugric (Estonian, Finnish, Hungarian), Language isolate (Basque), Latin/Greek (Greek), Semitic (Hebrew), Romanic (Italian, Portuguese, Spanish, Catalan)
				 * 1 - 1
				 * 2 - everything else: 0, 2, 3, ...
				 */
			return ($number === 1) ? 1 : 2;
			case 2:
				/**
				 * Families: Romanic (French, Brazilian Portuguese)
				 * 1 - 0, 1
				 * 2 - everything else: 2, 3, ...
				 */
			return (($number === 0) || ($number === 1)) ? 1 : 2;
			case 3:
				/**
				 * Families: Baltic (Latvian)
				 * 1 - 0
				 * 2 - ends in 1, not 11: 1, 21, ... 101, 121, ...
				 * 3 - everything else: 2, 3, ... 10, 11, 12, ... 20, 22, ...
				 */
			return ($number === 0) ? 1 : ((($number % 10 === 1) && ($number % 100 != 11)) ? 2 : 3);
			case 4:
				/**
				 * Families: Celtic (Scottish Gaelic)
				 * 1 - is 1 or 11: 1, 11
				 * 2 - is 2 or 12: 2, 12
				 * 3 - others between 3 and 19: 3, 4, ... 10, 13, ... 18, 19
				 * 4 - everything else: 0, 20, 21, ...
				 */
			return ($number === 1 || $number === 11) ? 1 : (($number === 2 || $number === 12) ? 2 : (($number >= 3 && $number <= 19) ? 3 : 4));
			case 5:
				/**
				 * Families: Romanic (Romanian)
				 * 1 - 1
				 * 2 - is 0 or ends in 01-19: 0, 2, 3, ... 19, 101, 102, ... 119, 201, ...
				 * 3 - everything else: 20, 21, ...
				 */
			return ($number === 1) ? 1 : ((($number === 0) || (($number % 100 > 0) && ($number % 100 < 20))) ? 2 : 3);
			case 6:
				/**
				 * Families: Baltic (Lithuanian)
				 * 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, ...
				 * 2 - ends in 0 or ends in 10-20: 0, 10, 11, 12, ... 19, 20, 30, 40, ...
				 * 3 - everything else: 2, 3, ... 8, 9, 22, 23, ... 29, 32, 33, ...
				 */
			return (($number % 10 === 1) && ($number % 100 != 11)) ? 1 : ((($number % 10 < 2) || (($number % 100 >= 10) && ($number % 100 < 20))) ? 2 : 3);
			case 7:
				/**
				 * Families: Slavic (Croatian, Serbian, Russian, Ukrainian)
				 * 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, ...
				 * 2 - ends in 2-4, not 12-14: 2, 3, 4, 22, 23, 24, 32, ...
				 * 3 - everything else: 0, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 25, 26, ...
				 */
			return (($number % 10 === 1) && ($number % 100 != 11)) ? 1 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 2 : 3);
			case 8:
				/**
				 * Families: Slavic (Slovak, Czech)
				 * 1 - 1
				 * 2 - 2, 3, 4
				 * 3 - everything else: 0, 5, 6, 7, ...
				 */
			return ($number === 1) ? 1 : ((($number >= 2) && ($number <= 4)) ? 2 : 3);
			case 9:
				/**
				 * Families: Slavic (Polish)
				 * 1 - 1
				 * 2 - ends in 2-4, not 12-14: 2, 3, 4, 22, 23, 24, 32, ... 104, 122, ...
				 * 3 - everything else: 0, 5, 6, ... 11, 12, 13, 14, 15, ... 20, 21, 25, ...
				 */
			return ($number === 1) ? 1 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 12) || ($number % 100 > 14))) ? 2 : 3);
			case 10:
				/**
				 * Families: Slavic (Slovenian, Sorbian)
				 * 1 - ends in 01: 1, 101, 201, ...
				 * 2 - ends in 02: 2, 102, 202, ...
				 * 3 - ends in 03-04: 3, 4, 103, 104, 203, 204, ...
				 * 4 - everything else: 0, 5, 6, 7, 8, 9, 10, 11, ...
				 */
			return ($number % 100 === 1) ? 1 : (($number % 100 === 2) ? 2 : ((($number % 100 === 3) || ($number % 100 === 4)) ? 3 : 4));
			case 11:
				/**
				 * Families: Celtic (Irish Gaeilge)
				 * 1 - 1
				 * 2 - 2
				 * 3 - is 3-6: 3, 4, 5, 6
				 * 4 - is 7-10: 7, 8, 9, 10
				 * 5 - everything else: 0, 11, 12, ...
				 */
			return ($number === 1) ? 1 : (($number === 2) ? 2 : (($number >= 3 && $number <= 6) ? 3 : (($number >= 7 && $number <= 10) ? 4 : 5)));
			case 12:
				/**
				 * Families: Semitic (Arabic)
				 * 1 - 1
				 * 2 - 2
				 * 3 - ends in 03-10: 3, 4, ... 10, 103, 104, ... 110, 203, 204, ...
				 * 4 - ends in 11-99: 11, ... 99, 111, 112, ...
				 * 5 - everything else: 100, 101, 102, 200, 201, 202, ...
				 * 6 - 0
				 */
			return ($number === 1) ? 1 : (($number === 2) ? 2 : ((($number % 100 >= 3) && ($number % 100 <= 10)) ? 3 : ((($number % 100 >= 11) && ($number % 100 <= 99)) ? 4 : (($number != 0) ? 5 : 6))));
			case 13:
				/**
				 * Families: Semitic (Maltese)
				 * 1 - 1
				 * 2 - is 0 or ends in 01-10: 0, 2, 3, ... 9, 10, 101, 102, ...
				 * 3 - ends in 11-19: 11, 12, ... 18, 19, 111, 112, ...
				 * 4 - everything else: 20, 21, ...
				 */
			return ($number === 1) ? 1 : ((($number === 0) || (($number % 100 > 1) && ($number % 100 < 11))) ? 2 : ((($number % 100 > 10) && ($number % 100 < 20)) ? 3 : 4));
			case 14:
				/**
				 * Families: Slavic (Macedonian)
				 * 1 - ends in 1: 1, 11, 21, ...
				 * 2 - ends in 2: 2, 12, 22, ...
				 * 3 - everything else: 0, 3, 4, ... 10, 13, 14, ... 20, 23, ...
				 */
			return ($number % 10 === 1) ? 1 : (($number % 10 === 2) ? 2 : 3);
			case 15:
				/**
				 * Families: Icelandic
				 * 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, 131, ...
				 * 2 - everything else: 0, 2, 3, ... 10, 11, 12, ... 20, 22, ...
				 */
			return (($number % 10 === 1) && ($number % 100 != 11)) ? 1 : 2;
		}
	}
	/**
	 * Add Language Items
	 *
	 * Examples:
	 * <code>
	 * $component = array('posting');
	 * $component = array('posting', 'viewtopic')
	 * $component = 'posting'
	 * </code>
	 *
	 * @param string|array	$component		The name of the language component to load
	 * @param string|null	$extension_name	Name of the extension to load component from, or null for core file
	 */
	public function add_lang($component, $extension_name = null)
	{
		// Load common language files if they not loaded yet
		// This needs to be here to correctly merge language arrays
		if (!$this->common_language_files_loaded)
		{
			$this->load_common_language_files();
		}

		if (!is_array($component))
		{
			if (!is_null($extension_name))
			{
				$this->load_extension($extension_name, $component);
			}
			else
			{
				$this->load_core_file($component);
			}
		}
		else
		{
			foreach ($component as $lang_file)
			{
				$this->add_lang($lang_file, $extension_name);
			}
		}
	}
	/**
	 * @param $key array|string		The language key we want to know more about. Can be string or array.
	 *
	 * @return bool		Returns whether the language key is set.
	 */
	public function is_set($key)
	{
		// Load common language files if they not loaded yet
		if (!$this->common_language_files_loaded)
		{
			$this->load_common_language_files();
		}

		if (is_array($key))
		{
			$lang = &$this->lang[array_shift($key)];

			foreach ($key as $_key)
			{
				$lang = &$lang[$_key];
			}
		}
		else
		{
			$lang = &$this->lang[$key];
		}

		return isset($lang);
	}

	/**
	 * Advanced language substitution
	 *
	 * Function to mimic sprintf() with the possibility of using phpBB's language system to substitute nullar/singular/plural forms.
	 * Params are the language key and the parameters to be substituted.
	 * This function/functionality is inspired by SHS` and Ashe.
	 *
	 * Example call: <samp>$user->lang('NUM_POSTS_IN_QUEUE', 1);</samp>
	 *
	 * If the first parameter is an array, the elements are used as keys and subkeys to get the language entry:
	 * Example: <samp>$user->lang(array('datetime', 'AGO'), 1)</samp> uses $user->lang['datetime']['AGO'] as language entry.
	 *
	 * @return string	Return localized string or the language key if the translation is not available
	 */
	public function lang()
	{
		$args = func_get_args();
		$key = array_shift($args);

		return $this->lang_array($key, $args);
	}
	
	/**
	 * BC function for loading language files
	 *
	 * @deprecated 3.2.0-dev (To be removed: 4.0.0)
	 */
	private function set_lang($lang_set, $use_help, $ext_name)
	{
		if (empty($ext_name))
		{
			$ext_name = null;
		}
		
		if ($use_help && strpos($lang_set, '/') !== false)
		{
			$component = dirname($lang_set) . '/help_' . basename($lang_set);
			if ($component[0] === '/')
			{
				$component = substr($component, 1);
			}
		}
		else
		{
			$component = (($use_help) ? 'help_' : '') . $lang_set;
		}
		
		$this->add_lang($component, $ext_name);
		
	}

	/**
	* Add Language Items from an extension - use_db and use_help are assigned where needed (only use them to force inclusion)
	*
	* @param string $ext_name The extension to load language from, or empty for core files
	* @param mixed $lang_set specifies the language entries to include
	* @param bool $use_db internal variable for recursion, do not use
	* @param bool $use_help internal variable for recursion, do not use
	*
	* Note: $use_db and $use_help should be removed. Kept for BC purposes.
	*
	* @deprecated: 3.2.0-dev (To be removed: 4.0.0)
	*/
	function add_lang_ext($ext_name, $lang_set, $use_db = false, $use_help = false)
	{
		if ($ext_name === '/')
		{
			$ext_name = '';
		}
		$this->add_lang($lang_set, $use_db, $use_help, $ext_name);
	}	
}
/**
 * Base exception class for language exceptions
 */
class language_exception extends runtime_exception
{

}	
/**
 * This exception is thrown when the language file is not found
 */
class language_file_not_found extends language_exception
{

} 
/**
 * class language
 */
?>
