<?php
/**
*
* @package DBal
* @version $Id: mssql.php,v 1.17 2008/08/19 02:46:22 orynider Exp $
* @copyright (c) 2005 phpBB Group
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @link http://www.mx-publisher.com
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
if (!is_object('dbal_mssql'))
{
	define('SQL_LAYER', 'mssql');
	include_once($mx_root_path . 'includes/db/dbal.' . $phpEx);
	$sql_db = 'dbal_' . $dbms; // Repopulated for multiple db connections

/**
* @package DBal
* MSSQL Database Abstraction Layer
* Minimum Requirement is MSSQL 2000+
*/
class dbal_mssql extends dbal
{
	/**
	* Connect to server
	*/
	/**
	* Connect to server
	*/
	function sql_connect($sqlserver, $sqluser, $sqlpassword, $database, $port = false, $persistency = false, $new_link = false)
	{
		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->server = $sqlserver . (($port) ? ':' . $port : '');
		$this->dbname = $database;

		if (UTF_STATUS === 'phpbb3')
		{				
				@ini_set('mssql.charset', 'UTF-8');
				// enforce strict mode on databases that support it
		}		
		@ini_set('mssql.textlimit', 2147483647);
		@ini_set('mssql.textsize', 2147483647);

		if (version_compare(PHP_VERSION, '5.1.0', '>=') || (version_compare(PHP_VERSION, '5.0.0-dev', '<=') && version_compare(PHP_VERSION, '4.4.1', '>=')))
		{
			$this->db_connect_id = ($this->persistency) ? @mssql_pconnect($this->server, $this->user, $sqlpassword, $new_link) : @mssql_connect($this->server, $this->user, $sqlpassword, $new_link);
		}
		else
		{
			$this->db_connect_id = ($this->persistency) ? @mssql_pconnect($this->server, $this->user, $sqlpassword) : @mssql_connect($this->server, $this->user, $sqlpassword);
		}

		if ($this->db_connect_id && $this->dbname != '')
		{
			if (!@mssql_select_db($this->dbname, $this->db_connect_id))
			{
				@mssql_close($this->db_connect_id);
				return false;
			}
		}

		return ($this->db_connect_id) ? $this->db_connect_id : $this->sql_error('');
	}

	/**
	* Version information about used database
	*/
	function sql_server_info()
	{
		$result_id = @mssql_query("SELECT SERVERPROPERTY('productversion'), SERVERPROPERTY('productlevel'), SERVERPROPERTY('edition')", $this->db_connect_id);

		$row = false;
		if ($result_id)
		{
			$row = @mssql_fetch_assoc($result_id);
			@mssql_free_result($result_id);
		}

		if ($row)
		{
			return 'MSSQL<br />' . implode(' ', $row);
		}

		return 'MSSQL';
	}

	/**
	* sql transaction
	*/
	function sql_transaction($status = 'begin')
	{
		switch ($status)
		{
			case 'begin':
				$result = @mssql_query('BEGIN TRANSACTION', $this->db_connect_id);
				$this->transaction = true;
				break;

			case 'commit':
				$result = @mssql_query('commit', $this->db_connect_id);
				$this->transaction = false;

				if (!$result)
				{
					@mssql_query('ROLLBACK', $this->db_connect_id);
				}
				break;

			case 'rollback':
				$result = @mssql_query('ROLLBACK', $this->db_connect_id);
				$this->transaction = false;
				break;

			default:
				$result = true;
		}

		return $result;
	}

	/**
	* Base query method
	*/
	function sql_query($query = '', $cache_ttl = 0)
	{
		if ($query != '')
		{
			global $mx_cache;

			// EXPLAIN only in extra debug mode
			if (defined('DEBUG_EXTRA'))
			{
				$this->sql_report('start', $query);
			}

			$this->query_result = ($cache_ttl && method_exists($mx_cache, 'sql_load')) ? $mx_cache->sql_load($query) : false;

			if (!$this->query_result)
			{
				$this->num_queries++;

				if (($this->query_result = @mssql_query($query, $this->db_connect_id)) === false)
				{
					$this->sql_error($query);
				}

				if (defined('DEBUG_EXTRA'))
				{
					$this->sql_report('stop', $query);
				}

				if ($cache_ttl && method_exists($mx_cache, 'sql_save'))
				{
					$this->open_queries[(int) $this->query_result] = $this->query_result;
					$mx_cache->sql_save($query, $this->query_result, $cache_ttl);
				}
				else if (strpos($query, 'SELECT') === 0 && $this->query_result)
				{
					$this->open_queries[(int) $this->query_result] = $this->query_result;
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
				$total = -1;
			}

			$row_offset = ($total) ? $offset : '';
			$num_rows = ($total) ? $total : $offset;

			$query = 'SELECT TOP ' . ($row_offset + $num_rows) . ' ' . substr($query, 6);

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

		return ($query_id) ? @mssql_num_rows($query_id) : false;
	}

	/**
	* Return number of affected rows
	*/
	function sql_affectedrows()
	{
		return ($this->db_connect_id) ? @mssql_rows_affected($this->db_connect_id) : false;
	}

	/**
	* Fetch current row
	*/
	function sql_fetchrow($query_id = false)
	{
		global $mx_cache;

		if (!$query_id)
		{
			$query_id = $this->query_result;
		}

		if (isset($mx_cache->sql_rowset[$query_id]))
		{
			return $mx_cache->sql_fetchrow($query_id);
		}

		$row = @mssql_fetch_assoc($query_id);

		// I hope i am able to remove this later... hopefully only a PHP or MSSQL bug
		if ($row)
		{
			foreach ($row as $key => $value)
			{
				$row[$key] = ($value === ' ') ? '' : $value;
			}
		}

		return $row;
	}

	/**
	* Fetch field
	* if rownum is false, the current row is used, else it is pointing to the row (zero-based)
	*/
	function sql_fetchfield($field, $rownum = false, $query_id = false)
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
			return isset($row[$field]) ? $row[$field] : false;
		}

		return false;
	}

	/**
	* Seek to given row number
	* rownum is zero-based
	*/
	function sql_rowseek($rownum, $query_id = false)
	{
		if (!$query_id)
		{
			$query_id = $this->query_result;
		}

		return ($query_id) ? @mssql_data_seek($query_id, $rownum) : false;
	}

	/**
	* Get last inserted id after insert statement
	*/
	function sql_nextid()
	{
		$result_id = @mssql_query('SELECT @@IDENTITY', $this->db_connect_id);
		if ($result_id)
		{
			if (@mssql_fetch_assoc($result_id))
			{
				$id = @mssql_result($result_id, 1);
				@mssql_free_result($result_id);
				return $id;
			}
			@mssql_free_result($result_id);
		}

		return false;
	}

	/**
	* Free sql result
	*/
	function sql_freeresult($query_id = false)
	{
		if (!$query_id)
		{
			$query_id = $this->query_result;
		}

		if (isset($this->open_queries[$query_id]))
		{
			unset($this->open_queries[$query_id]);
			return @mssql_free_result($query_id);
		}

		return false;
	}

	/**
	* Escape string used in sql query
	*/
	function sql_escape($msg)
	{
		return str_replace("'", "''", str_replace('\\', '\\\\', $msg));
	}

	/**
	* return sql error array
	* @private
	*/
	function _sql_error()
	{
		return array(
			'message'	=> @mssql_get_last_message($this->db_connect_id),
			'code'		=> ''
		);
	}

	/**
	* Build LIKE expression
	* @access private
	*/
	function _sql_like_expression($expression)
	{
		return $expression . " ESCAPE '\\'";
	}

	/**
	* Build db-specific query data
	* @access private
	*/
	function _sql_custom_build($stage, $data)
	{
		return $data;
	}

	/**
	* Close sql connection
	* @private
	*/
	function _sql_close()
	{
		return @mssql_close($this->db_connect_id);
	}

	/**
	* Build db-specific report
	* @private
	*/
	function _sql_report($mode, $query = '')
	{
		switch ($mode)
		{
			case 'start':
			break;

			case 'fromcache':
				$endtime = explode(' ', microtime());
				$endtime = $endtime[0] + $endtime[1];

				$result = @mssql_query($query, $this->db_connect_id);
				while ($void = @mssql_fetch_assoc($result))
				{
					// Take the time spent on parsing rows into account
				}
				@mssql_free_result($result);

				$splittime = explode(' ', microtime());
				$splittime = $splittime[0] + $splittime[1];

				$this->sql_report('record_fromcache', $query, $endtime, $splittime);

			break;
		}
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