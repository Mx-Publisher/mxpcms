<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: functions_simpledoc.php,v 1.9 2008/06/03 20:14:11 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

// ===================================================
// mx_simpledoc class
// ===================================================
class mx_simpledoc
{
	var $modified = false;
	var $error = array();

	var $page_title = '';

	var $debug = true;
	var $debug_msg = array();

	// ===================================================
	// Prepare data
	// ===================================================
	function init()
	{
		global $db, $userdata, $debug, $simpledoc_config;

		$this->debug('mx_simpledoc->init', basename( __FILE__ ));

	}

	// ===================================================
	// Clean up
	// ===================================================
	function _simpledoc()
	{
		$this->debug('mx_simpledoc->_simpledoc', basename( __FILE__ ));

		if ( $this->modified )
		{
			$this->sync_all();
		}
	}

	// ===================================================
	// Add debug message
	// ===================================================
	function debug($debug_msg, $file = '', $line_break = true)
	{
		if ($this->debug)
		{
			$module_name = !empty($this->module_name) ? $this->module_name . ' :: ' : '';
			$file = !empty($file) ? ' (' . $file . ')' : '';
			$line_break = $line_break ? '<br>' : '';
			$this->debug_msg[] = $line_break . $module_name . $debug_msg . $file ;
		}
	}


	// ===================================================
	// Display debug message
	// ===================================================
	function display_debug()
	{
		if ($this->debug)
		{
			$debug_message = '';
			foreach ($this->debug_msg as $key => $value)
			{
				$debug_message .= $value;
			}

			return $debug_message;
		}
	}

	function modified( $true_false = false )
	{
		$this->debug('mx_simpledoc->modified', basename( __FILE__ ));

		$this->modified = $true_false;
	}

	// ----------
	// HELP FUNCS
	// ----------

	function send_zip($dir, $filename, $new_dir = null) {
		global $module_root_path, $phpEx;

		include_once( $module_root_path . 'simpledoc/includes/functions_zip.' . $phpEx );

	    $files = IoDir::readFull($dir);

	    $zip = new zip;
	    foreach ($files as $file) {
	        $file2 = $new_dir ? $new_dir . substr($file, strlen($dir)) : $file;
	        if (IoDir::exists($file)) {
	            $zip->add_dir($file2);
	        } else if (IoFile::exists($file)) {
	            $zip->add_file(IoFile::read($file), $file2);
	        }
	    }

	    header("Content-type: application/octet-stream");
	    header("Content-Disposition: attachment; filename=\"$filename\"");
	    header("Pragma: no-cache");
	    header("Expires: 0");

	    echo $zip->get_file();
	    exit;
	}

	function send_zip_clear($dir, $filename, $new_dir = null) {
		global $module_root_path, $phpEx;

		include_once( $module_root_path . 'simpledoc/includes/functions_zip.' . $phpEx );
		$files = IoDir::readFull($dir);

		$zip = new zip();
		foreach ($files as $file) {
		    $file2 = $new_dir ? $new_dir . substr($file, strlen($dir)) : $file;
		    if (IoDir::exists($file)) {
		        $zip->add_dir($file2);
		    } else if (IoFile::exists($file)) {
		        $zip->add_file(IoFile::read($file), $file2);
		    }
		}

		IoDir::delete($dir);

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		echo $zip->get_file();
		exit;
	}

	function extract_zip($file, $to) {
		global $CHMOD_FILE, $CHMOD_DIR, $module_root_path, $phpEx;

		include_once( $module_root_path . 'simpledoc/includes/functions_zip.' . $phpEx );

	    $zip = new zip;
	    $list = $zip->get_List($file);
	    if (!count($list)) return;

	    $root = $list[0]['filename'];
	    $root = substr($root, 0, strpos($root, '/'));
	    IoDir::create($to.'/'.$root, $CHMOD_DIR);

	    $list2 = array();
	    foreach ($list as $v) {
	        $v['filename'] = $this->fix_path($v['filename']);
	        $list2[substr_count($v['filename'], '/')][] = $v;
	    }

	    $a = array_keys($list2);
	    sort($a);

	    foreach ($a as $level) {
	        foreach ($list2[$level] as $v) {
	            if ($v['folder']) {
	                if ($v['filename'] != $root) {
	                    IoDir::create($to.'/'.$v['filename'], $CHMOD_DIR);
	                }
	            }
	            else IoFile::create($to.'/'.$v['filename'], $CHMOD_FILE);
	        }
	    }

	    $er = error_reporting(E_ALL ^ E_NOTICE);
	    $zip->extract($file, $to);
	    error_reporting($er);
	}

	//
	// ??? publish/raw.php and publish/tree.php
	//
	function get_name($s) {
	    $s = str_replace('\\', '/', $s);
	    if (strpos($s, '/') === false) { return $s; }
	    return substr($s, strrpos($s, '/')+1);
	}

	function get_readable_size($bytes) {
	    $base = 1024;
	    $suffixes = array(' B', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB');
	    $usesuf = 0;
	    $n = (float) $bytes;
	    while ($n >= $base) {
	        $n /= (float) $base;
	        ++$usesuf;
	    }
	    $places = 2 - floor(log10($n));
	    $places = max($places, 0);
	    return number_format($n, $places, '.', '') . $suffixes[$usesuf];
	}

	//
	// ??? publish/raw.php and publish/tree.php
	//
	function fetch_document($id) {
	    global $CONTENT, $CONFIG, $module_root_path, $mx_root_path;

	    $path = $CONTENT.'/'.$id;
	    $html = IoFile::read($path);

	    if (preg_match('#<h1>(.+)</h1>#i', $html, $matches)) {
	        $title = $matches[1];
	    } else {
	        $title = substr($path, strlen(dirname($path).'/'));
	        $title = substr($title, -5) == '.html' ? substr($title, 0, strlen($title)-5) : $title;
	    }

	    $Page = new sugolibTemplate($module_root_path.'simpledoc/shared/publish/document.tpl');
	    $Page->setArray(array(
	        'encoding' => $CONFIG['encoding'],
	        'title' => $title,
	        'html' => $html
	    ));
	    return $Page->fetch();
	}

	//
	// ??? publish/tree.php
	//
	function fetch_document_tree($id) {
	    global $CONTENT, $CONFIG, $module_root_path;

	    $path = $CONTENT.'/'.$id;
	    $html = IoFile::read($path);

	    if (preg_match('#<h1>(.+)</h1>#i', $html, $matches)) {
	        $title = $matches[1];
	    } else {
	        $title = substr($path, strlen(dirname($path).'/'));
	        $title = substr($title, -5) == '.html' ? substr($title, 0, strlen($title)-5) : $title;
	    }

	    $Page = new sugolibTemplate($module_root_path.'simpledoc/shared/publish/document.tpl');
	    $Page->setArray(array(
	        'encoding' => $CONFIG['encoding'],
	        'title' => $title,
	        'html' => $html,
	        'tree' => true
	    ));
	    return $Page->fetch();
	}

	//
	// ??? publish/tre.php and tre-tre.php
	//
	function build_tree(&$tree, $root, $path = null) {
	    if (!isset($path)) $path = $root;
	    global $SORT;
	    $nodes = IoDir::read($path, array($SORT));
	    $names = array();
	    foreach ($nodes as $v) {
	        $names[] = (strpos($v, '/') !== false ? substr($v, strrpos($v, '/')+1) : $v);
	    }
	    $sort = IoFile::read($path.'/.sort');
	    $sort = $sort ? explode("\n", $sort) : array();
	    foreach ($sort as $k => $v) { $sort[$k] = trim($v); }
	    $nodes2 = array();
	    foreach ($sort as $v) {
	        $key = array_search($v, $names);
	        $nodes2[] = $nodes[$key];
	    }
	    sort($names);
	    sort($sort);
	    if (count($names) != count($sort) || count(array_diff($names, $sort))) {
	        return trigger_error("build_tree() failed, $path/.sort contains invalid data", E_USER_ERROR);
	    }
	    foreach ($nodes2 as $node) {
	        $id = substr($node, strlen($root.'/'));
	        if (IoDir::exists($node)) {
	            $tree[$id] = array();
	            $this->build_tree($tree[$id], $root, $node);
	        } else {
	            $tree[$id] = null;
	        }
	    }
	}

	//
	// Build the $tree html
	//
	function build_tree_html($tree) {
	    $ret = '';
	    foreach ($tree as $id => $v) {
	        $name = strpos($id, '/') !== false ? substr($id, (int)strrpos($id, '/')+1) : $id;
	        if (is_array($v)) {
	            $ret .= sprintf('<div onselectstart="return false" class="folder" id="tree-%s">%s', $id, $name);
	            $ret .= $this->build_tree_html($tree[$id]);
	            $ret .= '</div>';
	        } else {
	            $ret .= sprintf('<div class="doc" id="tree-%s">%s</div>', $id, substr($name, 0, -5));
	        }
	    }
	    return $ret;
	}

	//
	// Build the $tree html
	//
	function _build_tree_html($tree) {
		global $module_root_path, $PUBLISH;

	    $ret = '';
	    foreach ($tree as $id => $v) {
	        $name = strpos($id, '/') !== false ? substr($id, (int)strrpos($id, '/')+1) : $id;
	        if (is_array($v)) {
	            $ret .= sprintf('<div class="folder" id="tree-%s">%s', $id, $name);
	            $ret .= $this->build_tree_html($tree[$id]);
	            $ret .= '</div>';
	        } else {
	            $ret .= sprintf('<div class="doc" id="tree-%s"><a href="'.$PUBLISH.'/html/%s">%s</a></div>', $id, $id, substr($name, 0, -5));
	        }
	    }
	    return $ret;
	}


	// remove unsafe chars when saving config
	function config_safe($str) {
	    $str = strip_tags($str);
	    $str = str_replace("'", "\\'", $str);
	    return $str;
	}

	function fix_path($s) {
	    $s = str_replace('\\', '/', $s);
	    if (substr($s, -1) == '/') $s = substr($s, 0, -1);
	    return $s;
	}

	// ===================================================
	// url rewrites
	// ===================================================
	function this_simpledoc_mxurl( $args = '', $force_standalone_mode = false, $non_html_amp = false )
	{
		global $mx_root_path, $module_root_path, $page_id, $phpEx;

		$dynamicId = !empty($_GET['dynamic_block']) ? ( $non_html_amp ? '&dynamic_block=' : '&amp;dynamic_block=' ) . $_GET['dynamic_block'] : '';

		$mxurl = $mx_root_path . 'index.' . $phpEx;
		if ( is_numeric( $page_id ) )
		{
				$mxurl .= '?page=' . $page_id . $dynamicId . ( $args == '' ? '' : ( $non_html_amp ? '&' : '&amp;' ) . $args );
		}
		else
		{
			$mxurl .= ( $args == '' ? '' : '?' . $args );
		}

		return $mxurl;
	}

	function edit_lock()
	{
		global $db, $mx_simpledoc_cache, $userdata;

		//
		// $edit_lock array
		// - user_id
		// - user_name
		//
		if ( $mx_simpledoc_cache->exists( 'edit_lock' ) )
		{
			$edit_lock = $mx_simpledoc_cache->get( 'edit_lock' );

			//
			// Is cached simpledoc user online?
			//
			$sql = "SELECT u.username, u.user_id, u.user_level
				FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
				WHERE u.user_id = s.session_user_id
					AND u.user_id = " . $edit_lock['user_id'] . "
					AND s.session_logged_in = '1'
				ORDER BY u.username ASC, s.session_ip ASC";

			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, 'Could not obtain user/online information', '', __LINE__, __FILE__, $sql);
			}

			$row = array();
			if( $total_users = $db->sql_numrows($result) )
			{
				$row = $db->sql_fetchrow($result);
			}
			$db->sql_freeresult($result);

			if ($total_users == 0)
			{
				$edit_lock['user_id'] = $userdata['user_id'];
				$edit_lock['user_name'] = $userdata['username'];
				$mx_simpledoc_cache->put( 'edit_lock', $edit_lock );
			}
			else if ($userdata['user_id'] != $row['user_id'])
			{
				return false;
			}

		}
		else
		{
			$edit_lock['user_id'] = $userdata['user_id'];
			$edit_lock['user_name'] = $userdata['username'];
			$mx_simpledoc_cache->put( 'edit_lock', $edit_lock );
		}

		return true;
	}

	function unicode_urldecode($url)
	{
	   preg_match_all('/%u([[:alnum:]]{4})/', $url, $a);

	   foreach ($a[1] as $uniord)
	   {
	       $dec = hexdec($uniord);
	       $utf = '';

	       if ($dec < 128)
	       {
	           $utf = chr($dec);
	       }
	       else if ($dec < 2048)
	       {
	           $utf = chr(192 + (($dec - ($dec % 64)) / 64));
	           $utf .= chr(128 + ($dec % 64));
	       }
	       else
	       {
	           $utf = chr(224 + (($dec - ($dec % 4096)) / 4096));
	           $utf .= chr(128 + ((($dec % 4096) - ($dec % 64)) / 64));
	           $utf .= chr(128 + ($dec % 64));
	       }

	       $url = str_replace('%u'.$uniord, $utf, $url);
	   }

	   return urldecode($url);
	}

}

// ===================================================
// public mx_simpledoc class
// ===================================================
class mx_simpledoc_public extends mx_simpledoc
{
	var $modules = array();
	var $module_name = '';

	// ===================================================
	// load module
	// $module name : send module name to load it
	// ===================================================
	function module( $module_name )
	{
		if ( !class_exists( 'mx_simpledoc_' . $module_name ) )
		{
			global $phpbb_root_path, $phpEx;
			global $mx_root_path, $module_root_path, $is_block, $phpEx;

			$this->module_name = $module_name;

			require_once( $module_root_path . 'simpledoc/modules/simpledoc_' . $module_name . '.' . $phpEx );
			eval( '$this->modules[' . $module_name . '] = new mx_simpledoc_' . $module_name . '();' );

			if ( method_exists( $this->modules[$module_name], 'init' ) )
			{
				$this->modules[$module_name]->init();
			}
		}
	}

	// ===================================================
	// this will be replaced by the loaded module
	// ===================================================
	function main( $module_id = false )
	{
		return false;
	}

}
?>