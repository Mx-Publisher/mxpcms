<?php
/**
*
* @package DBal
* @version $Id: dbal.php,v 1.17 2013/06/28 15:33:26 orynider Exp $
* @copyright (c) 2005 phpBB Group
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

/**
* @package DBal
* Database Abstraction Layer
*/
class dbal
{
	var $db_connect_id;
	var $query_result;
	var $return_on_error = false;
	var $transaction = false;
	var $sql_time = 0;
	var $num_queries = 0;
	var $open_queries = array();

	var $curtime = 0;
	var $query_hold = '';
	var $html_hold = '';
	var $sql_report = '';
	var $cache_num_queries = 0;

	var $persistency = false;
	var $user = '';
	var $server = '';
	var $dbname = '';

	/**
	* Constructor
	*/
	function dbal()
	{
		/*
		$this->num_queries = array(
			'cached'		=> 0,
			'normal'		=> 0,
			'total'			=> 0,
		);
		*/

		// Fill default sql layer based on the class being called.
		// This can be changed by the specified layer itself later if needed.
		$this->sql_layer = substr(get_class($this), 5);

		// Do not change this please! This variable is used to easy the use of it - and is hardcoded.
		$this->any_char = chr(0) . '%';
		$this->one_char = chr(0) . '_';
	}

	/**
	* return on error or display error message
	*/
	function sql_return_on_error($fail = false)
	{
		$this->return_on_error = $fail;
	}

	/**
	* Return number of sql queries used (cached and real queries are counted the same)
	*/
	function sql_num_queries()
	{
		return $this->num_queries;
	}

	/**
	* Build LIMIT query
	* Doing some validation here.
	*/
	function sql_query_limit($query, $total, $offset = 0, $cache_ttl = 0)
	{
		if (empty($query))
		{
			return false;
		}

		// Never use a negative total or offset
		$total = ($total < 0) ? 0 : $total;
		$offset = ($offset < 0) ? 0 : $offset;

		return $this->_sql_query_limit($query, $total, $offset, $cache_ttl);
	}

	/**
	* DBAL garbage collection, close sql connection
	*/
	function sql_close()
	{
		if (!$this->db_connect_id)
		{
			return false;
		}

		if ($this->transaction)
		{
			$this->sql_transaction('commit');
		}

		if (sizeof($this->open_queries))
		{
			foreach ($this->open_queries as $i_query_id => $query_id)
			{
				$this->sql_freeresult($query_id);
			}
		}

		return $this->_sql_close();
	}

	/**
	* Fetch all rows
	*/
	function sql_fetchrowset($query_id = false)
	{
		if (!$query_id)
		{
			$query_id = $this->query_result;
		}

		if ($query_id)
		{
			$result = array();
			while ($row = $this->sql_fetchrow($query_id))
			{
				$result[] = $row;
			}

			return $result;
		}

		return false;
	}

	/**
	* Build sql statement from array for insert/update/select statements
	*
	* Idea for this from Ikonboard
	* Possible query values: INSERT, INSERT_SELECT, MULTI_INSERT, UPDATE, SELECT
	*/
	function sql_build_array($query, $assoc_ary = false)
	{
		if (!is_array($assoc_ary))
		{
			return false;
		}

		$fields = array();
		$values = array();
		if ($query == 'INSERT' || $query == 'INSERT_SELECT')
		{
			foreach ($assoc_ary as $key => $var)
			{
				$fields[] = $key;

				if (is_null($var))
				{
					$values[] = 'NULL';
				}
				else if (is_string($var))
				{
					$values[] = "'" . $this->sql_escape($var) . "'";
				}
				else if (is_array($var) && is_string($var[0]))
				{
					// This is used for INSERT_SELECT(s)
					$values[] = $var[0];
				}
				else
				{
					$values[] = (is_bool($var)) ? intval($var) : $var;
				}
			}

			$query = ($query == 'INSERT') ? ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')' : ' (' . implode(', ', $fields) . ') SELECT ' . implode(', ', $values) . ' ';
		}
		else if ($query == 'MULTI_INSERT')
		{
			$ary = array();
			foreach ($assoc_ary as $id => $sql_ary)
			{
				$values = array();
				foreach ($sql_ary as $key => $var)
				{
					if (is_null($var))
					{
						$values[] = 'NULL';
					}
					else if (is_string($var))
					{
						$values[] = "'" . $this->sql_escape($var) . "'";
					}
					else
					{
						$values[] = (is_bool($var)) ? intval($var) : $var;
					}
				}
				$ary[] = '(' . implode(', ', $values) . ')';
			}

			$query = ' (' . implode(', ', array_keys($assoc_ary[0])) . ') VALUES ' . implode(', ', $ary);
		}
		else if ($query == 'UPDATE' || $query == 'SELECT')
		{
			$values = array();
			foreach ($assoc_ary as $key => $var)
			{
				if (is_null($var))
				{
					$values[] = "$key = NULL";
				}
				else if (is_string($var))
				{
					$values[] = "$key = '" . $this->sql_escape($var) . "'";
				}
				else
				{
					$values[] = (is_bool($var)) ? "$key = " . intval($var) : "$key = $var";
				}
			}
			$query = implode(($query == 'UPDATE') ? ', ' : ' AND ', $values);
		}

		return $query;
	}

	/**
	* Build IN or NOT IN sql comparison string, uses <> or = on single element
	* arrays to improve comparison speed
	*
	* @access public
	* @param	string	$field				name of the sql column that shall be compared
	* @param	array	$array				array of values that are allowed (IN) or not allowed (NOT IN)
	* @param	bool	$negate				true for NOT IN (), false for IN () (default)
	* @param	bool	$allow_empty_set	If true, allow $array to be empty, this function will return 1=1 or 1=0 then. Default to false.
	*/
	function sql_in_set($field, $array, $negate = false, $allow_empty_set = false)
	{
		if (!sizeof($array))
		{
			if (!$allow_empty_set)
			{
				// Print the backtrace to help identifying the location of the problematic code
				$this->sql_error('No values specified for SQL IN comparison');
			}
			else
			{
				// NOT IN () actually means everything so use a tautology
				if ($negate)
				{
					return '1=1';
				}
				// IN () actually means nothing so use a contradiction
				else
				{
					return '1=0';
				}
			}
		}

		if (!is_array($array))
		{
			$array = array($array);
		}

		if (sizeof($array) == 1)
		{
			@reset($array);
			$var = current($array);

			return $field . ($negate ? ' <> ' : ' = ') . $this->_sql_validate_value($var);
		}
		else
		{
			return $field . ($negate ? ' NOT IN ' : ' IN ') . '(' . implode(', ', array_map(array($this, '_sql_validate_value'), $array)) . ')';
		}
	}


	/**
	* Run more than one insert statement.
	*
	* @param string $table table name to run the statements on
	* @param array &$sql_ary multi-dimensional array holding the statement data.
	*
	* @return bool false if no statements were executed.
	* @access public
	*/
	function sql_multi_insert($table, &$sql_ary)
	{
		if (!sizeof($sql_ary))
		{
			return false;
		}

		if ($this->multi_insert)
		{
			$this->sql_query('INSERT INTO ' . $table . ' ' . $this->sql_build_array('MULTI_INSERT', $sql_ary));
		}
		else
		{
			foreach ($sql_ary as $ary)
			{
				if (!is_array($ary))
				{
					return false;
				}

				$this->sql_query('INSERT INTO ' . $table . ' ' . $this->sql_build_array('INSERT', $ary));
			}
		}

		return true;
	}

	/**
	* Function for validating values
	* @access private
	*/
	function _sql_validate_value($var)
	{
		if (is_null($var))
		{
			return 'NULL';
		}
		else if (is_string($var))
		{
			return "'" . $this->sql_escape($var) . "'";
		}
		else
		{
			return (is_bool($var)) ? intval($var) : $var;
		}
	}

	/**
	* Build sql statement from array for select and select distinct statements
	*
	* Possible query values: SELECT, SELECT_DISTINCT
	*/
	function sql_build_query($query, $array)
	{
		$sql = '';
		switch ($query)
		{
			case 'SELECT':
			case 'SELECT_DISTINCT';

				$sql = str_replace('_', ' ', $query) . ' ' . $array['SELECT'] . ' FROM ';

				$table_array = array();
				foreach ($array['FROM'] as $table_name => $alias)
				{
					if (is_array($alias))
					{
						foreach ($alias as $multi_alias)
						{
							$table_array[] = $table_name . ' ' . $multi_alias;
						}
					}
					else
					{
						$table_array[] = $table_name . ' ' . $alias;
					}
				}

				$sql .= $this->_sql_custom_build('FROM', implode(', ', $table_array));

				if (!empty($array['LEFT_JOIN']))
				{
					foreach ($array['LEFT_JOIN'] as $join)
					{
						$sql .= ' LEFT JOIN ' . key($join['FROM']) . ' ' . current($join['FROM']) . ' ON (' . $join['ON'] . ')';
					}
				}

				if (!empty($array['WHERE']))
				{
					$sql .= ' WHERE ' . $this->_sql_custom_build('WHERE', $array['WHERE']);
				}

				if (!empty($array['GROUP_BY']))
				{
					$sql .= ' GROUP BY ' . $array['GROUP_BY'];
				}

				if (!empty($array['ORDER_BY']))
				{
					$sql .= ' ORDER BY ' . $array['ORDER_BY'];
				}

			break;
		}

		return $sql;
	}

	/**
	* display sql error page
	*/
	function sql_error($sql = '')
	{
		global $mx_user, $mx_root_path, $phpEx, $lang, $board_config;


		// Set var to retrieve errored status
		$this->sql_error_triggered = true;
		$this->sql_error_sql = $sql;

		$this->sql_error_returned = $this->_sql_error();

		if (!$this->return_on_error)
		{
			$message = 'SQL ERROR [ ' . $this->sql_layer . ' ]<br /><br />' . $this->sql_error_returned['message'] . ' [' . $this->sql_error_returned['code'] . ']';

			// Show complete SQL error and path to administrators only
			// Additionally show complete error on installation or if extended debug mode is enabled
			// The DEBUG_EXTRA constant is for development only!
			if ((isset($phpbb_auth) && $phpbb_auth->acl_get('a_')) || defined('IN_INSTALL') || defined('DEBUG_EXTRA'))
			{
				$message .= ($sql) ? '<br /><br />SQL<br /><br />' . htmlspecialchars($sql) : '';
			}
			else
			{
				// If error occurs in initiating the session we need to use a pre-defined language string
				// This could happen if the connection could not be established for example (then we are not able to grab the default language)
				if (!isset($lang['SQL_ERROR_OCCURRED']))
				{
					$message .= '<br /><br />An sql error occurred while fetching this page. Please contact an administrator if this problem persists.';
				}
				else
				{
					if (!empty($config['board_contact']))
					{
						$message .= '<br /><br />' . sprintf($lang['SQL_ERROR_OCCURRED'], '<a href="mailto:' . htmlspecialchars($board_config['board_contact']) . '">', '</a>');
					}
					else
					{
						$message .= '<br /><br />' . sprintf($lang['SQL_ERROR_OCCURRED'], '', '');
					}
				}
			}

			if ($this->transaction)
			{
				$this->sql_transaction('rollback');
			}

			if (strlen($message) > 1024)
			{
				// We need to define $msg_long_text here to circumvent text stripping.
				global $msg_long_text;
				$msg_long_text = $message;

				//trigger_error(false, E_USER_ERROR);
				return $this->sql_error_returned;
			}

			//trigger_error($message, E_USER_ERROR);
			return $this->sql_error_returned;
		}

		if ($this->transaction)
		{
			$this->sql_transaction('rollback');
		}

		return $this->sql_error_returned;
	}

	/**
	* Explain queries
	*/
	function sql_report($mode, $query = '')
	{
		global $mx_cache, $mx_starttime, $phpbb_root_path, $user;

		if (empty($_GET['explain']))
		{
			return;
		}

		if (!$query && $this->query_hold != '')
		{
			$query = $this->query_hold;
		}

		switch ($mode)
		{
			case 'display':
				if (!empty($mx_cache))
				{
					$mx_cache->unload();
				}
				$this->sql_close();

				$mtime = explode(' ', microtime());
				$totaltime = $mtime[0] + $mtime[1] - $mx_starttime;

				echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
				echo '<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">';
				echo '<head>';
				echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
				echo '<title>SQL Report</title>';
				echo '<link href="' . $phpbb_root_path . 'adm/style/admin.css" rel="stylesheet" type="text/css" media="screen" />';
				echo '<link href="' . $phpbb_root_path . 'adm/style/sql_report.css" rel="stylesheet" type="text/css" media="screen" />';
				echo '</head>';
				echo '<body id="errorpage">';
				echo '<div id="wrap">';
				echo '	<div id="page-header">';
				echo '		<a href="' . htmlspecialchars(preg_replace('/&explain=([^&]*)/', '', $_SERVER['REQUEST_URI'])) . '">Return to previous page</a>';
				echo '	</div>';
				echo '	<div id="page-body">';
				echo '		<div class="panel">';
				echo '			<span class="corners-top"><span></span></span>';
				echo '			<div id="content">';
				echo '				<h1>SQL Report</h1>';
				echo '				<table width="95%" cellspacing="1" cellpadding="4" border="0" align="center"><tr>
										<td height="40" align="center" valign="middle"><b>Page generated in ' . round($totaltime, 4) . " seconds with {$this->num_queries} queries" . (($this->cache_num_queries) ? " + {$this->cache_num_queries} " . (($this->cache_num_queries == 1) ? 'query' : 'queries') . ' returning data from cache' : '') . '</b></td>
									</tr><tr>
										<td align="center" nowrap="nowrap">Time spent on MySQL queries: <b>' . round($this->sql_time, 5) . 's</b> | Time spent on PHP: <b>' . round($totaltime - $this->sql_time, 5) . 's</b></td>
									</tr></table>
									<table width="95%" cellspacing="1" cellpadding="4" border="0" align="center"><tr>
										<td>' . $this->sql_report . '</td>
									</tr></table>';
				echo '			</div>';
				echo '			<span class="corners-bottom"><span></span></span>';
				echo '		</div>';
				echo '	</div>';
				echo '	<div id="page-footer">';
				echo '		Powered by phpBB &copy; ' . date('Y') . ' <a href="http://www.phpbb.com/">phpBB Group</a>';
				echo '	</div>';
				echo '</div>';
				echo '</body>';
				echo '</html>';

				exit;
				break;

			case 'stop':
				$endtime = explode(' ', microtime());
				$endtime = $endtime[0] + $endtime[1];

				$this->sql_report .= '
					<hr width="100%"/><br />

					<table class="bg" width="100%" cellspacing="1" cellpadding="4" border="0">
					<tr>
						<th>Query #' . $this->num_queries . '</th>
					</tr>
					<tr>
						<td class="row1"><textarea style="font-family:\'Courier New\',monospace;width:100%" rows="5">' . preg_replace('/\t(AND|OR)(\W)/', "\$1\$2", htmlspecialchars(preg_replace('/[\s]*[\n\r\t]+[\n\r\s\t]*/', "\n", $query))) . '</textarea></td>
					</tr>
					</table> ' . $this->html_hold . '
					<p align="center">
				';

				if ($this->query_result)
				{
					if (preg_match('/^(UPDATE|DELETE|REPLACE)/', $query))
					{
						$this->sql_report .= 'Affected rows: <b>' . $this->sql_affectedrows($this->query_result) . '</b> | ';
					}
					$this->sql_report .= 'Before: ' . sprintf('%.5f', $this->curtime - $mx_starttime) . 's | After: ' . sprintf('%.5f', $endtime - $mx_starttime) . 's | Elapsed: <b>' . sprintf('%.5f', $endtime - $this->curtime) . 's</b>';
				}
				else
				{
					$error = $this->sql_error();
					$this->sql_report .= '<b style="color: red">FAILED</b> - ' . SQL_LAYER . ' Error ' . $error['code'] . ': ' . htmlspecialchars($error['message']);
				}

				$this->sql_report .= '</p>';

				$this->sql_time += $endtime - $this->curtime;
			break;

			case 'start':
				$this->query_hold = $query;
				$this->html_hold = '';

				$this->_sql_report($mode, $query);

				$this->curtime = explode(' ', microtime());
				$this->curtime = $this->curtime[0] + $this->curtime[1];

			break;

			case 'add_select_row':

				$html_table = func_get_arg(2);
				$row = func_get_arg(3);

				if (!$html_table && sizeof($row))
				{
					$html_table = true;
					$this->html_hold .= '<table class="bg" width="100%" cellspacing="1" cellpadding="4" border="0" align="center"><tr>';

					foreach (array_keys($row) as $val)
					{
						$this->html_hold .= '<th nowrap="nowrap">' . (($val) ? ucwords(str_replace('_', ' ', $val)) : '&nbsp;') . '</th>';
					}
					$this->html_hold .= '</tr>';
				}
				$this->html_hold .= '<tr>';

				$class = 'row1';
				foreach (array_values($row) as $val)
				{
					$class = ($class == 'row1') ? 'row2' : 'row1';
					$this->html_hold .= '<td class="' . $class . '">' . (($val) ? $val : '&nbsp;') . '</td>';
				}
				$this->html_hold .= '</tr>';

				return $html_table;

			break;

			case 'fromcache':

				$this->_sql_report($mode, $query);

				$this->cache_num_queries++;

			break;

			case 'record_fromcache':

				$endtime = func_get_arg(2);
				$splittime = func_get_arg(3);

				$time_cache = $endtime - $this->curtime;
				$time_db = $splittime - $endtime;
				$color = ($time_db > $time_cache) ? 'green' : 'red';

				$this->sql_report .= '<hr width="100%"/><br /><table class="bg" width="100%" cellspacing="1" cellpadding="4" border="0"><tr><th>Query results obtained from the cache</th></tr><tr><td class="row1"><textarea style="font-family:\'Courier New\',monospace;width:100%" rows="5">' . preg_replace('/\t(AND|OR)(\W)/', "\$1\$2", htmlspecialchars(preg_replace('/[\s]*[\n\r\t]+[\n\r\s\t]*/', "\n", $query))) . '</textarea></td></tr></table><p align="center">';
				$this->sql_report .= 'Before: ' . sprintf('%.5f', $this->curtime - $mx_starttime) . 's | After: ' . sprintf('%.5f', $endtime - $mx_starttime) . 's | Elapsed [cache]: <b style="color: ' . $color . '">' . sprintf('%.5f', ($time_cache)) . 's</b> | Elapsed [db]: <b>' . sprintf('%.5f', $time_db) . 's</b></p>';

				// Pad the start time to not interfere with page timing
				$mx_starttime += $time_db;

			break;

			default:

				$this->_sql_report($mode, $query);

			break;
		}
	}
}

/**
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* This variable holds the class name to use later
*/
$sql_db = 'dbal_' . $dbms;

?>