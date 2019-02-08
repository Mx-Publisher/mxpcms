<?php
/**
*
* @package DBal
* @version $Id: sqlite3.php,v 1.17 2018/10/10 15:39:10 orynider Exp $
* @copyright (c) 2005 phpBB Group
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @link http://mxpcms.sourceforge.net/
*
*/

/**
*/
if (!defined('IN_PORTAL'))
{
	exit;
}

/**
* @ignore
*/
//if (!defined('SQL_LAYER'))
if (!is_object('dbal_sqlite3'))
{
	define('SQL_LAYER', 'sqlite3');
	include_once($mx_root_path . 'includes/db/dbal.' . $phpEx);
	$sql_db = 'dbal_' . $dbms; // Repopulated for multiple db connections

/**
* SQLite3 Database Abstraction Layer
* Minimum Requirement: 3.6.15+
*/
class dbal_sqlite3 extends dbal
{
	/**
	* @var	string		Stores errors during connection setup in case the driver is not available
	*/
	protected $connect_error = '';

	/**
	* @var	\SQLite3	The SQLite3 database object to operate against
	*/
	protected $dbo = null;

	/**
	* Connect to server
	* downgraded for phpBB2 backend
	* @access public
	*/
	public function sql_connect($sqlserver, $sqluser, $sqlpassword, $database, $port = false, $persistency = false, $new_link = false)
	{
		$this->persistency = false;
		$this->user = $sqluser;
		$this->server = $sqlserver . (($port) ? ':' . $port : '');
		$this->dbname = $database;

		if (!class_exists('SQLite3', false))
		{
			$this->connect_error = 'SQLite3 not found, is the extension installed?';
			return $this->sql_error('');
		}

		try
		{
			$this->dbo = new \SQLite3($this->server, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
			$this->dbo->busyTimeout(60000);
			$this->db_connect_id = true;
		}
		catch (\Exception $e)
		{
			$this->connect_error = $e->getMessage();
			return array('message' => $this->connect_error);
		}

		return true;
	}
	
	function sql_connect_id() 
	{
		return $this->db_connect_id;
	}

	/**
	* Version information about used database
	*/
	public function sql_server_info($raw = false, $use_cache = true)
	{
		global $mx_cache;

		if (!$use_cache || empty($mx_cache) || ($this->sql_server_version = $mx_cache->get('sqlite_version')) === false)
		{
			$version = \SQLite3::version();

			$this->sql_server_version = $version['versionString'];

			if (!empty($mx_cache) && $use_cache)
			{
				$mx_cache->put('sqlite_version', $this->sql_server_version);
			}
		}

		return ($raw) ? $this->sql_server_version : 'SQLite ' . $this->sql_server_version;
	}

	/**
	* SQL Transaction
	*
	* @param	string	$status		Should be one of the following strings:
	*								begin, commit, rollback
	* @return	bool	Success/failure of the transaction query
	*/
	protected function _sql_transaction($status = 'begin')
	{
		switch ($status)
		{
			case 'begin':
				return $this->dbo->exec('BEGIN IMMEDIATE');
			break;

			case 'commit':
				return $this->dbo->exec('COMMIT');
			break;

			case 'rollback':
				return @$this->dbo->exec('ROLLBACK');
			break;
		}

		return true;
	}


	/**
	* Base query method
	*/
	public function sql_query($query = '', $cache_ttl = 0)
	{
		if ($query != '')
		{
			global $cache;

			// EXPLAIN only in extra debug mode
			if (defined('DEBUG'))
			{
				$this->sql_report('start', $query);
			}
			else if (defined('MXP_DISPLAY_LOAD_TIME'))
			{
				$this->curtime = microtime(true);
			}

			$this->last_query_text = $query;
			$this->query_result = ($cache && $cache_ttl) ? $cache->sql_load($query) : false;
			$this->sql_add_num_queries($this->query_result);

			if ($this->query_result === false)
			{
				if ($this->transaction === true && strpos($query, 'INSERT') === 0)
				{
					$query = preg_replace('/^INSERT INTO/', 'INSERT OR ROLLBACK INTO', $query);
				}

				if (($this->query_result = @$this->dbo->query($query)) === false)
				{
					// Try to recover a lost database connection
					if ($this->dbo && !@$this->dbo->lastErrorMsg())
					{
						if ($this->sql_connect($this->server, $this->user, '', $this->dbname))
						{
							$this->query_result = @$this->dbo->query($query);
						}
					}

					if ($this->query_result === false)
					{
						$this->sql_error($query);
					}
				}

				if (defined('DEBUG'))
				{
					$this->sql_report('stop', $query);
				}
				else if (defined('MXP_DISPLAY_LOAD_TIME'))
				{
					$this->sql_time += microtime(true) - $this->curtime;
				}

				if (!$this->query_result)
				{
					return false;
				}

				if ($cache && $cache_ttl)
				{
					$this->query_result = $cache->sql_save($this, $query, $this->query_result, $cache_ttl);
				}
			}
			else if (defined('DEBUG'))
			{
				$this->sql_report('fromcache', $query);
			}
		}
		else
		{
			return false;
		}

		return $this->query_result;
	}

	/**
	* Build LIMIT query
	*
	* @param	string	$query		The SQL query to execute
	* @param	int		$total		The number of rows to select
	* @param	int		$offset
	* @param	int		$cache_ttl	Either 0 to avoid caching or
	*				the time in seconds which the result shall be kept in cache
	* @return	mixed	Buffered, seekable result handle, false on error
	*/
	protected function _sql_query_limit($query, $total, $offset = 0, $cache_ttl = 0)
	{
		$this->query_result = false;

		// if $total is set to 0 we do not want to limit the number of rows
		if ($total == 0)
		{
			$total = -1;
		}

		$query .= "\n LIMIT " . ((!empty($offset)) ? $offset . ', ' . $total : $total);

		return $this->sql_query($query, $cache_ttl);
	}

	/**
	* Return number of affected rows
	*/
	public function sql_affectedrows()
	{
		return ($this->db_connect_id) ? $this->dbo->changes() : false;
	}

	/**
	* Fetch current row
	*/
	public function sql_fetchrow($query_id = false)
	{
		global $cache;

		if ($query_id === false)
		{
			/** @var \SQLite3Result $query_id */
			$query_id = $this->query_result;
		}

		if ($cache && !is_object($query_id) && $cache->sql_exists($query_id))
		{
			return $cache->sql_fetchrow($query_id);
		}

		return is_object($query_id) ? @$query_id->fetchArray(SQLITE3_ASSOC) : false;
	}

	/**
	* Get last inserted id after insert statement
	*/
	public function sql_nextid()
	{
		return ($this->db_connect_id) ? $this->dbo->lastInsertRowID() : false;
	}

	/**
	* Free sql result
	*/
	public function sql_freeresult($query_id = false)
	{
		global $cache;

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if ($cache && !is_object($query_id) && $cache->sql_exists($query_id))
		{
			return $cache->sql_freeresult($query_id);
		}

		if ($query_id)
		{
			return @$query_id->finalize();
		}
	}

	/**
	* Escape string used in sql query
	*/
	public function sql_escape($msg)
	{
		return \SQLite3::escapeString($msg);
	}

	/**
	* {@inheritDoc}
	*
	* For SQLite an underscore is an unknown character.
	*/
	public function sql_like_expression($expression)
	{
		// Unlike LIKE, GLOB is unfortunately case sensitive.
		// We only catch * and ? here, not the character map possible on file globbing.
		$expression = str_replace(array(chr(0) . '_', chr(0) . '%'), array(chr(0) . '?', chr(0) . '*'), $expression);

		$expression = str_replace(array('?', '*'), array("\?", "\*"), $expression);
		$expression = str_replace(array(chr(0) . "\?", chr(0) . "\*"), array('?', '*'), $expression);

		return 'GLOB \'' . $this->sql_escape($expression) . '\'';
	}

	/**
	* {@inheritDoc}
	*
	* For SQLite an underscore is an unknown character.
	*/
	public function sql_not_like_expression($expression)
	{
		// Unlike NOT LIKE, NOT GLOB is unfortunately case sensitive
		// We only catch * and ? here, not the character map possible on file globbing.
		$expression = str_replace(array(chr(0) . '_', chr(0) . '%'), array(chr(0) . '?', chr(0) . '*'), $expression);

		$expression = str_replace(array('?', '*'), array("\?", "\*"), $expression);
		$expression = str_replace(array(chr(0) . "\?", chr(0) . "\*"), array('?', '*'), $expression);

		return 'NOT GLOB \'' . $this->sql_escape($expression) . '\'';
	}

	/**
	* return sql error array
	*
	* @return array
	*/
	protected function _sql_error()
	{
		if (class_exists('SQLite3', false) && isset($this->dbo))
		{
			$error = array(
				'message'	=> $this->dbo->lastErrorMsg(),
				'code'		=> $this->dbo->lastErrorCode(),
			);
		}
		else
		{
			$error = array(
				'message'	=> $this->connect_error,
				'code'		=> '',
			);
		}

		return $error;
	}

	/**
	* Build db-specific query data
	*
	* @param	string	$stage		Available stages: FROM, WHERE
	* @param	mixed	$data		A string containing the CROSS JOIN query or an array of WHERE clauses
	*
	* @return	string	The db-specific query fragment
	*/
	protected function _sql_custom_build($stage, $data)
	{
		return $data;
	}

	/**
	* Close sql connection
	*
	* @return	bool		False if failure
	*/
	protected function _sql_close()
	{
		return $this->dbo->close();
	}

	/**
	* Build db-specific report
	*
	* @param	string	$mode		Available modes: display, start, stop,
	*								add_select_row, fromcache, record_fromcache
	* @param	string	$query		The Query that should be explained
	* @return	mixed		Either a full HTML page, boolean or null
	*/
	protected function _sql_report($mode, $query = '')
	{
		switch ($mode)
		{
			case 'start':

				$explain_query = $query;
				if (preg_match('/UPDATE ([a-z0-9_]+).*?WHERE(.*)/s', $query, $m))
				{
					$explain_query = 'SELECT * FROM ' . $m[1] . ' WHERE ' . $m[2];
				}
				else if (preg_match('/DELETE FROM ([a-z0-9_]+).*?WHERE(.*)/s', $query, $m))
				{
					$explain_query = 'SELECT * FROM ' . $m[1] . ' WHERE ' . $m[2];
				}

				if (preg_match('/^SELECT/', $explain_query))
				{
					$html_table = false;

					if ($result = $this->dbo->query("EXPLAIN QUERY PLAN $explain_query"))
					{
						while ($row = $result->fetchArray(SQLITE3_ASSOC))
						{
							$html_table = $this->sql_report('add_select_row', $query, $html_table, $row);
						}
					}

					if ($html_table)
					{
						$this->html_hold .= '</table>';
					}
				}

			break;

			case 'fromcache':
				$endtime = explode(' ', microtime());
				$endtime = $endtime[0] + $endtime[1];

				$result = $this->dbo->query($query);
				if ($result)
				{
						while ($void = $result->fetchArray(SQLITE3_ASSOC))
						{
							// Take the time spent on parsing rows into account
						}
				}

				$splittime = explode(' ', microtime());
				$splittime = $splittime[0] + $splittime[1];

				$this->sql_report('record_fromcache', $query, $endtime, $splittime);

			break;
		}
	}

	/**
	* Cache clear function
	*/
	function clear_cache($cache_prefix = '', $cache_folder = SQL_CACHE_FOLDER, $files_per_step = 0)
	{
		global $phpEx;
		
		$cache_folder = (empty($cache_folder) ? SQL_CACHE_FOLDER : $cache_folder);

		$cache_prefix = 'sql_' . $cache_prefix;
		$cache_folder = (!empty($cache_folder) && @is_dir($cache_folder)) ? $cache_folder : SQL_CACHE_FOLDER;
		$cache_folder = ((@is_dir($cache_folder)) ? $cache_folder : realpath($cache_folder));

		$res = opendir($cache_folder);
		if($res)
		{
			$files_counter = 0;
			while(($file = readdir($res)) !== false)
			{
				if(!@is_dir($file) && (substr($file, 0, strlen($cache_prefix)) === $cache_prefix) && (substr($file, -(strlen($phpEx) + 1)) === '.' . $phpEx))
				{
					@unlink($cache_folder . $file);
					$files_counter++;
				}
				if (($files_per_step > 0) && ($files_counter >= $files_per_step))
				{
					closedir($res);
					return $files_per_step;
				}
			}
		}
		@closedir($res);
	}	
}

} // if ... define

// Connect to DB
$db	= new $sql_db();
if(!$db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, false))
{
	mx_message_die(CRITICAL_ERROR, "Could not connect to the database");
}
?>
