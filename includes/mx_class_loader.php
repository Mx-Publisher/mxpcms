<?php
/**
*
* @package MXP3
* @copyright (c) 2005 MX Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
*/
if (!defined('IN_PORTAL'))
{
	exit;
}

/**
* The class loader resolves class names to file system paths and loads them if
* necessary.
*
* Classes have to be of the form mx_(dir_)*(classpart_)*, so directory names
* must never contain underscores. Example: mx_dir_subdir_class_name is a
* valid class name, while mx_dir_sub_dir_class_name is not.
*
* If every part of the class name is a directory, the last directory name is
* also used as the filename, e.g. mx_dir would resolve to dir/dir.php.
*
* @package MXP3
*/
class mx_class_loader
{
	private $prefix;
	private $path;
	private $php_ext;
	private $mx_cache;

	/**
	* A map of looked up class names to paths relative to $this->path.
	* This map is stored in cache and looked up if the cache is available.
	*
	* @var array
	*/
	private $cached_paths = array();

	/**
	* Creates a new mx_class_loader, which loads files with the given
	* file extension from the given path.
	*
	* @param string $prefix  Required class name prefix for files to be loaded
	* @param string $path    Directory to load files from
	* @param string $php_ext The file extension for PHP files
	* @param mx_cache_driver_interface $cache An implementation of the MX cache interface.
	*/
	public function __construct($prefix, $path, $php_ext = 'php', mx_cache_driver_interface $mx_cache = null)
	{
		$this->prefix 		= $prefix;
		$this->path 		= $path;
		$this->php_ext	= $php_ext;
		
		$this->set_cache($mx_cache);
	}

	/**
	* Provide the class loader with a cache to store paths. If set to null, the
	* the class loader will resolve paths by checking for the existance of every
	* directory in the class name every time.
	*
	* @param mx_cache_driver_interface $cache An implementation of the mx cache interface.
	*/
	public function set_cache(mx_cache_driver_interface $mx_cache = null)
	{
		if ($mx_cache)
		{
			$this->cached_paths = $mx_cache->get('class_loader_' . $this->prefix);
			
			if ($this->cached_paths === false)
			{
				$this->cached_paths = array();
			}
		}
		
		$this->mx_cache = $mx_cache;
	}

	/**
	* Registers the class loader as an autoloader using SPL.
	*/
	public function register()
	{
		spl_autoload_register(array($this, 'load_class'));
	}

	/**
	* Removes the class loader from the SPL autoloader stack.
	*/
	public function unregister()
	{
		spl_autoload_unregister(array($this, 'load_class'));
	}

	/**
	* Resolves a MX class name to a relative path which can be included.
	*
	* @param string       $class The class name to resolve, must have a MX_
	*                            prefix
	* @return string|bool        A relative path to the file containing the
	*                            class or false if looking it up failed.
	*/
	public function resolve_path($class)
	{
		if (isset($this->cached_paths[$class]))
		{
			return $this->path . $this->cached_paths[$class] . '.' . $this->php_ext;
		}

		if (!preg_match('/^' . $this->prefix . '[a-zA-Z0-9_]+$/', $class))
		{
			return false;
		}

		$parts = explode('_', substr($class, strlen($this->prefix)));

		$dirs = '';

		for ($i = 0, $n = sizeof($parts); $i < $n && is_dir($this->path . $dirs . $parts[$i]); $i++)
		{
			$dirs .= $parts[$i] . '/';
		}

		// no file name left => use last dir name as file name
		if ($i == sizeof($parts))
		{
			$parts[] = $parts[$i - 1];
		}

		$relative_path = $dirs . implode(array_slice($parts, $i, sizeof($parts) - $i), '_');

		if (!file_exists($this->path . $relative_path . '.' . $this->php_ext))
		{
			return false;
		}

		if ($this->mx_cache)
		{
			$this->cached_paths[$class] = $relative_path;
			$this->mx_cache->put('class_loader_' . $this->prefix, $this->cached_paths);
		}

		return $this->path . $relative_path . '.' . $this->php_ext;
	}

	/**
	* Resolves a class name to a path and then includes it.
	*
	* @param string $class The class name which is being loaded.
	*/
	public function load_class($class)
	{
		// In general $class is not supposed to contain a leading backslash,
		// but sometimes it does. See tickets PHP-50731 and HHVM-1840.
		if ($class[0] !== '\\')
		{
			$class = '\\' . $class;
		}

		if (substr($class, 0, strlen($this->prefix)) === $this->prefix)
		{
			$path = $this->resolve_path($class);

			if ($path)
			{
				require $path;
			}
		}
	}
}
?>
