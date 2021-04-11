<?php
/**
*
* @package DBal
* @version $Id: mysqli.php,v 1.28 2014/05/16 18:02:06 orynider Exp $
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
if (!is_object('dbal_mysqli'))
{
	define('SQL_LAYER', 'mysqli');
	include_once($mx_root_path . 'includes/db/dbal.' . $phpEx);
	$sql_db = 'dbal_' . $dbms; // Repopulated for multiple db connections

/**
* @package DBal
* MySQLi Database Abstraction Layer
* mysqli-extension has to be compiled with:
* MySQL 4.1+ or MySQL 5.0+
*/
class dbal_mysqli extends dbal
{
	var $multi_insert = true;
	var $version;
	/**
	* Connect to server
	* downgraded for phpBB2 backend
	* @access public
	*/
	public function sql_connect($sqlserver, $sqluser, $sqlpassword, $database, $port = false, $persistency = false, $new_link = false)
	{
		if (!function_exists('mysqli_connect'))
		{
			$this->connect_error = 'mysqli_connect function does not exist, is mysqli extension installed?';
			return $this->sql_error('');
		}
		$this->persistency = $persistency;
		$this->user = $sqluser;
		
		// If persistent connection, set dbhost to localhost when empty and prepend it with 'p:' prefix
		$this->server = ($this->persistency) ? 'p:' . (($sqlserver) ? $sqlserver : 'localhost') : $sqlserver;
		$this->dbname = $database;
		$port = (!$port) ? null : $port;
		
		// If port is set and it is not numeric, most likely mysqli socket is set.
		// Try to map it to the $socket parameter.
		$socket = null;
		if ($port)
		{
			if (is_numeric($port))
			{
				$port = (int) $port;
			}
			else
			{
				$socket = $port;
				$port = null;
			}
		}

		$this->db_connect_id = mysqli_init();

		if (!@mysqli_real_connect($this->db_connect_id, $this->server, $this->user, $sqlpassword, $this->dbname, $port, $socket, MYSQLI_CLIENT_FOUND_ROWS))
		{
			$this->db_connect_id = '';
		}

		if ($this->db_connect_id && $this->dbname != '')
		{		
			// mysqli only supported by phpBB3
			if (defined('UTF_STATUS') && isset($lang['ENCODING']))
			{
				@mysqli_query($this->db_connect_id, "SET NAMES". $lang['ENCODING']); // enforce strict mode on databases that support it
			}
			else
			{			
				@mysqli_query($this->db_connect_id, "SET NAMES 'utf8'");
			}
			// enforce strict mode on databases that support it
			if (version_compare($this->sql_server_info(true), '5.0.2', '>='))
			{
				$result = @mysqli_query($this->db_connect_id, 'SELECT @@session.sql_mode AS sql_mode');
				if ($result)
				{
					$row = mysqli_fetch_assoc($result);
					mysqli_free_result($result);

					$modes = array_map('trim', explode(',', $row['sql_mode']));
				}
				else
				{
					$modes = array();
				}

				// TRADITIONAL includes STRICT_ALL_TABLES and STRICT_TRANS_TABLES
				if (!in_array('TRADITIONAL', $modes))
				{
					if (!in_array('STRICT_ALL_TABLES', $modes))
					{
						$modes[] = 'STRICT_ALL_TABLES';
					}

					if (!in_array('STRICT_TRANS_TABLES', $modes))
					{
						$modes[] = 'STRICT_TRANS_TABLES';
					}
				}

				$mode = implode(',', $modes);
				@mysqli_query($this->db_connect_id, "SET SESSION sql_mode='{$mode}'");
			}
			return $this->db_connect_id;
		}

		return $this->sql_error('');
	}
	
	function sql_connect_id()
	{
		return "SELECT CONNECTION_ID()";
	}	

	/**
	* Version information about used database
	*/
	function sql_server_info($raw = false, $use_cache = true)
	{
		global $mx_cache;

		if (!$use_cache || empty($mx_cache) || ($this->sql_server_version = $mx_cache->get('mysqli_version')) === false)
		{
			$result = @mysqli_query($this->db_connect_id, 'SELECT VERSION() AS version');
			if ($result)
			{
				$row = mysqli_fetch_assoc($result);
				mysqli_free_result($result);

				$this->sql_server_version = $row['version'];

				if (!empty($mx_cache) && $use_cache)
				{
					$mx_cache->put('mysqli_version', $this->sql_server_version);
				}
			}
		}

		return ($raw) ? $this->sql_server_version : 'MySQL(i) ' . $this->sql_server_version;
		//return 'MySQL(i) ' . @mysqli_get_server_info($this->db_connect_id);
	}

	/**
	* SQL Transaction
	* @access private
	*/
	function sql_transaction($status = 'begin')
	{
		switch ($status)
		{
			case 'begin':
				$result = @mysqli_autocommit($this->db_connect_id, false);
				$this->transaction = true;
				break;

			case 'commit':
				$result = @mysqli_commit($this->db_connect_id);
				@mysqli_autocommit($this->db_connect_id, true);
				$this->transaction = false;

				if (!$result)
				{
					@mysqli_rollback($this->db_connect_id);
					@mysqli_autocommit($this->db_connect_id, true);
				}
				break;

			case 'rollback':
				$result = @mysqli_rollback($this->db_connect_id);
				@mysqli_autocommit($this->db_connect_id, true);
				$this->transaction = false;
				break;

			default:
				$result = true;
		}

		return $result;
	}
	
	/**
	* Close sql connection
	* @access private
	*/
	function sql_close()
	{
		if($this->db_connect_id)
		{
			//
			// Commit any remaining transactions
			//
			if( $this->transaction )
			{
				@mysqli_query("COMMIT", $this->db_connect_id);
			}

			return @mysqli_close($this->db_connect_id);
		}
		else
		{
			return false;
		}
	}
	
	/**
	* Base query method
	*/
	public function sql_query($query = '', $cache_ttl = 0)
	{
		if ($query != '')
		{
			global $mx_cache;

			// EXPLAIN only in extra debug mode
			if (defined('DEBUG_EXTRA'))
			{
				$this->sql_report('start', $query);
			}
			else if (defined('MXP_DISPLAY_LOAD_TIME'))
			{
				$this->curtime = microtime(true);
			}
			$this->query_result = ($mx_cache && $cache_ttl && method_exists($mx_cache, 'sql_load')) ? $mx_cache->sql_load($query) : false;
			//$this->query_result = ($mx_cache && $cache_ttl) ? $mx_cache->sql_load($query) : false;
			//$this->sql_add_num_queries($this->query_result);

			if ($this->query_result === false)
			{
				$this->num_queries++;

				if (($this->query_result = @mysqli_query($this->db_connect_id, $query)) === false)
				{
					$this->sql_error($query);
				}

				if (defined('DEBUG_EXTRA'))
				{
					$this->sql_report('stop', $query);
				}
				else if (defined('MXP_DISPLAY_LOAD_TIME'))
				{
					$this->sql_time += microtime(true) - $this->curtime;
				}
				/** /
				if ($this->query_result === false)
				{
					return false;
				}
				/**/
				if ($mx_cache && $cache_ttl && method_exists($mx_cache, 'sql_save'))
				{
					$mx_cache->sql_save($query, $this->query_result, $cache_ttl);
					//$mx_cache->sql_save($this, $query, $this->query_result, $cache_ttl);
				}
			}
			else if (defined('DEBUG_EXTRA'))
			{
				$this->sql_report('fromcache', $query);
			}
		}
		else
		{
			return false;
		}

		return ($this->query_result) ? $this->query_result : false;
	}

	/**
	* Build LIMIT query
	*/
	function sql_query_limit($query, $total, $offset = 0, $cache_ttl = 0)
	{
		if ($query != '')
		{
			$this->query_result = false;

			// if $total is set to 0 we do not want to limit the number of rows
			if ($total == 0)
			{
				// MySQL 4.1+ no longer supports -1 in limit queries
				$total = '18446744073709551615';
			}

			$query .= "\n LIMIT " . ((!empty($offset)) ? $offset . ', ' . $total : $total);

			return $this->sql_query($query, $cache_ttl);
		}
		else
		{
			return false;
		}
	}

	/**
	* Return number of rows
	* Not used within core code
	*/
	function sql_numrows($query_id = false)
	{
		if (!$query_id)
		{
			$query_id = $this->query_result;
		}

		return ($query_id) ? @mysqli_num_rows($query_id) : false;
	}
	
	/**
	* Return fields num
	* Not used within core code
	*/		
	function sql_numfields($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mysqli_num_fields($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	/**
	* Return fields names by orynider
	* Not used within core code
	*/	
	function sql_fieldname($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{		
			$columns_cnt = mysqli_num_fields($query_id);
			// Get field information ($query_id, $offset);
			$column = mysqli_fetch_fields($query_id);
			$column_set = array();

			$result = $column[$offset]->name;
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Check if a field type in a database.
	 *
	 * @param string $offset of sql array.
	 * @param string $query_id from sql array.
	 * @return field type.
	 */
	function sql_fieldtype($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mysqli_field_type($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Gets a list of columns of a table.
	 *
	 * @param string $table_name	table name
	 * @return array of columns names (all lower case)
	 */
	function sql_list_columns($table_name)
	{
		$columns = array();
		$result = $this->sql_query("SHOW COLUMNS FROM $table_name");
		while ($row = $this->sql_fetchrow($result))
		{
			$column = strtolower(current($row));
			$columns[$column] = $column;
		}
		$this->sql_freeresult($result);
		
		return $columns;
	}
	
	/**
	 * Check if a field exists in a table.
	 *
	 * @param string $column for field name.
	 * @param string $table_name for table name.
	 * @return boolean true or false if not exists.
	 */
	function sql_field_exists($column, $table_name)
	{
		//$query = $this->sql_query("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_name='{$table_name}' AND column_name='{$column}'");
		$query = $this->sql_query("SHOW FULL COLUMNS FROM $table_name LIKE '$column'");
		$numrows = $this->sql_numrows($query);
		
		if($numrows > 0)
		{
			return true;
		}
		else
		{
			$columns = $this->sql_list_columns($table_name);
			return isset($columns[$column]);
		}
	}
	
	/**
	 * Check if a table exists in a database.
	 *
	 * @param string $table_name for the table name.
	 * @return boolean true or false if not exists.
	 */
	function sql_table_exists($table_name)
	{
		// Execute on master server to ensure if we've just created a table that we get the correct result
		$query = (version_compare($this->sql_get_version(), '5.0.2', '>=')) ? $this->sql_query("SHOW FULL TABLES FROM `".$this->dbname."` WHERE table_type = 'BASE TABLE' AND `Tables_in_".$this->dbname."` = '$table_name'") : $this->sql_query("SHOW TABLES LIKE '$table_name'");

		$exists = $this->sql_numrows($query);
		if($exists > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	* Return number of affected rows
	*/
	function sql_affectedrows()
	{
		return ($this->db_connect_id) ? @mysqli_affected_rows($this->db_connect_id) : false;
	}

	/**
	* Fetch current row
	*/
	function sql_fetchrow($query_id = false)
	{
		global $mx_cache;

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if ($mx_cache && !is_object($query_id) && isset($mx_cache->sql_rowset[$query_id]))
		{
			return $mx_cache->sql_fetchrow($query_id);
		}

		if ($query_id)
		{
			$result = mysqli_fetch_assoc($query_id);
			return $result !== null ? $result : false;
		}

		return false;
	}
	
	/**
	 * Return a result array for a query.
	 *
	 * @param resource $query for the query_id.
	 * @param int $resulttype for the type of array to return: 
	 *  MYSQLI_NUM, MYSQLI_BOTH or MYSQLI_ASSOC
	 * @return array for the query of result.
	 */
	function sql_fetch_array($query, $resulttype=MYSQLI_ASSOC)
	{
		switch($resulttype)
		{
			case MYSQLI_NUM:
			case MYSQLI_BOTH:
			case MYSQLI_ASSOC:
			break;
			
			default:
				$resulttype = MYSQLI_ASSOC;
			break;
		}
		return @mysqli_fetch_array($query, $resulttype);
	}
	
	/**
	* Fetch field
	* if rownum is false, the current row is used, else it is pointing to the row (zero-based)
	*/
	function sql_fetchfield($column, $rownum = false, $query_id = false)
	{
		if (!$query_id)
		{
			$query_id = $this->query_result;
		}

		if ($query_id)
		{
			if ($rownum !== false)
			{
				$this->sql_rowseek($rownum, $query_id);
			}

			$row = $this->sql_fetchrow($query_id);
			return isset($row[$column]) ? $row[$column] : false;
		}

		return false;
	}

	/**
	* Seek to given row number
	* rownum is zero-based
	*/
	function sql_rowseek($rownum, $query_id = false)
	{
		global $mx_cache;

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if ($mx_cache && !is_object($query_id) && $mx_cache->sql_exists($query_id))
		//if ($mx_cache && !is_object($query_id) && isset($mx_cache->sql_rowset[$query_id]))
		{
			return $mx_cache->sql_rowseek($rownum, $query_id);
		}

		return ($query_id) ? @mysqli_data_seek($query_id, $rownum) : false;
	}

	/**
	* Get last inserted id after insert statement
	*/
	function sql_nextid()
	{
		return ($this->db_connect_id) ? @mysqli_insert_id($this->db_connect_id) : false;
	}

	/**
	* Free sql result
	*/
	function sql_freeresult($query_id = false)
	{
		global $mx_cache;

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		//if ($mx_cache && !is_object($query_id) && $mx_cache->sql_exists($query_id))
		if ($mx_cache && !is_object($query_id) && isset($mx_cache->sql_rowset[$query_id]))
		{
			return $mx_cache->sql_freeresult($query_id);
		}

		if ($query_id === false)
		{
			return false;
		}

		if ($query_id === true)
		{
			return true;
		}

		//if (isset($this->open_queries[(int) $query_id]))
		//{
			//unset($this->open_queries[(int) $query_id]);
			return @mysqli_free_result($query_id);
		//}
	}

	/**
	* Escape string used in sql query
	*/
	function sql_escape($msg)
	{
		return @mysqli_real_escape_string($this->db_connect_id, $msg);
	}
	
	/**
	 * Gets db version.
	 *
	 * @return string Version of this db.
	 */
	function sql_get_version()
	{
		if($this->version)
		{
			return $this->version;
		}
		
		$query = $this->sql_query("SELECT VERSION() as version");
		$ver = $this->sql_fetch_array($query);
		$version = $ver['version'];
		
		if($version)
		{
			$version = explode(".", $version, 3);
			$this->version = (int)$version[0].".".(int)$version[1].".".(int)$version[2];
		}
		return $this->version;
	}
	
	/**
	* Gets the estimated number of rows in a specified table.
	*
	* @param string $table_name		Table name
	*
	* @return string				Number of rows in $table_name.
	*								Prefixed with ~ if estimated (otherwise exact).
	*
	* @access public
	*/
	function get_estimated_row_count($table_name)
	{
		$table_status = $this->get_table_status($table_name);

		if (isset($table_status['Engine']))
		{
			if ($table_status['Engine'] === 'MyISAM')
			{
				return $table_status['Rows'];
			}
			else if ($table_status['Engine'] === 'InnoDB' && $table_status['Rows'] > 100000)
			{
				return '~' . $table_status['Rows'];
			}
		}

		return parent::get_row_count($table_name);
	}

	/**
	* Gets the exact number of rows in a specified table.
	*
	* @param string $table_name		Table name
	*
	* @return string				Exact number of rows in $table_name.
	*
	* @access public
	*/
	function get_row_count($table_name)
	{
		$table_status = $this->get_table_status($table_name);

		if (isset($table_status['Engine']) && $table_status['Engine'] === 'MyISAM')
		{
			return $table_status['Rows'];
		}

		return parent::get_row_count($table_name);
	}

	/**
	* Gets some information about the specified table.
	*
	* @param string $table_name		Table name
	*
	* @return array
	*
	* @access protected
	*/
	function get_table_status($table_name)
	{
		$sql = "SHOW TABLE STATUS
			LIKE '" . $this->sql_escape($table_name) . "'";
		$result = $this->sql_query($sql);
		$table_status = $this->sql_fetchrow($result);
		$this->sql_freeresult($result);

		return $table_status;
	}

	/**
	* return sql error array
	* @access private
	*/
	function _sql_error($sql = '')
	{
		if ($this->db_connect_id)
		{
			$error = array(
				'message'	=> @mysqli_error($this->db_connect_id),
				'code'		=> @mysqli_errno($this->db_connect_id)
			);
		}
		else if (function_exists('mysqli_connect_error'))
		{
			$error = array(
				'message'	=> @mysqli_connect_error(),
				'code'		=> @mysqli_connect_errno(),
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
	* Build LIKE expression
	* @access private
	*/
	function _sql_like_expression($expression)
	{
		return $expression;
	}

	/**
	* Build db-specific query data
	* @access private
	*/
	function _sql_custom_build($stage, $data)
	{
		switch ($stage)
		{
			case 'FROM':
				$data = '(' . $data . ')';
			break;
		}

		return $data;
	}	
	

	/**
	* Close sql connection
	* @access private
	*/
	function _sql_close()
	{
		return @mysqli_close($this->db_connect_id);
	}

	/**
	* Build db-specific report
	* @access private
	*/
	function _sql_report($mode, $query = '')
	{
		static $test_prof;

		// current detection method, might just switch to see the existence of INFORMATION_SCHEMA.PROFILING
		if ($test_prof === null)
		{
			$test_prof = false;
			if (strpos(mysqli_get_server_info($this->db_connect_id), 'community') !== false)
			{
				$ver = mysqli_get_server_version($this->db_connect_id);
				if ($ver >= 50037 && $ver < 50100)
				{
					$test_prof = true;
				}
			}
		}

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

					// begin profiling
					if ($test_prof)
					{
						@mysqli_query($this->db_connect_id, 'SET profiling = 1;');
					}

					if ($result = @mysqli_query($this->db_connect_id, "EXPLAIN $explain_query"))
					{
						while ($row = @mysqli_fetch_assoc($result))
						{
							$html_table = $this->sql_report('add_select_row', $query, $html_table, $row);
						}
						//mysqli_free_result($result);
					}
					@mysqli_free_result($result);

					if ($html_table)
					{
						$this->html_hold .= '</table>';
					}

					if ($test_prof)
					{
						$html_table = false;

						// get the last profile
						if ($result = @mysqli_query($this->db_connect_id, 'SHOW PROFILE ALL;'))
						{
							$this->html_hold .= '<br />';
							while ($row = mysqli_fetch_assoc($result))
							{
								// make <unknown> HTML safe
								if (!empty($row['Source_function']))
								{
									$row['Source_function'] = str_replace(array('<', '>'), array('&lt;', '&gt;'), $row['Source_function']);
								}

								// remove unsupported features
								foreach ($row as $key => $val)
								{
									if ($val === null)
									{
										unset($row[$key]);
									}
								}
								$html_table = $this->sql_report('add_select_row', $query, $html_table, $row);
							}
							mysqli_free_result($result);
						}

						if ($html_table)
						{
							$this->html_hold .= '</table>';
						}

						@mysqli_query($this->db_connect_id, 'SET profiling = 0;');
					}
				}

			break;

			case 'fromcache':
				$endtime = explode(' ', microtime());
				$endtime = $endtime[0] + $endtime[1];

				$result = @mysqli_query($this->db_connect_id, $query);
				if ($result)
				{
					while ($void = mysqli_fetch_assoc($result))
					{
						// Take the time spent on parsing rows into account
					}
					mysqli_free_result($result);
				}
				//@mysqli_free_result($result);

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
		$cache_folder = ((@is_dir($cache_folder)) ? $cache_folder : @phpbb_realpath($cache_folder));

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