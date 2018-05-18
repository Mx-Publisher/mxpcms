<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: sugolib4.php,v 1.3 2008/06/03 20:14:11 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

// +---------------------------------------------+
// | sugolib4.php                                |
// | Last updated: 2004-11-21                    |
// | Homepage: http://gosu.pl/php/libraries.html |
// +---------------------------------------------+

/*
    libraries/functions:
    Dao, Db, raiseError(), logError(), sugolibTemplate, Upload
    get(), post(), request(), cookie(), session(), redirect(), printR(), isPOST(), isGET(), stripQuotes()
*/

// +-----------------------------------------------------------------+
// | Base class for Data Access Objects.                             |
// | Author: Cezary Tomczak [www.gosu.pl]                            |
// | Free for any use as long as all copyright messages are intact.  |
// +-----------------------------------------------------------------+

class Dao {
    var $Db;
    var $table;
    var $pk;
    var $seq;
    function Db(&$Db) {
        $this->Db =& $Db;
    }
    // Returns ISO date.
    function now() {
        switch ($this->Db->driver) {
            case 'mysql': $q = "SELECT NOW()"; break;
            case 'oci8': $q = "SELECT SYSDATE FROM dual"; break;
            default: return trigger_error('Dao::now() not supported for this db driver', E_USER_ERROR);
        }
        return $this->Db->getOne($q);
    }
    function condition($key, $val) {
        return (is_null($val) ? "$key IS NULL" : $this->Db->bind("$key = ?", $val));
    }
    function insertId() {
        switch ($this->Db->driver) {
            case 'mysql': return $this->Db->insertId();
            case 'oci8': return $this->Db->getOne("SELECT {$this->seq}.currval FROM dual");
            default: return trigger_error('Dao::insertId() not implemented for this db driver', E_USER_ERROR);
        }
    }
    function find($id) {
        return $this->Db->getRow("SELECT * FROM {$this->table} WHERE {$this->pk} = ?", $id);
    }
    function insert($fields) {
        $this->Db->insert($this->table, $fields);
    }
    function update($fields) {
        $where = $this->Db->bind($this->pk . ' = ?', $fields[$this->pk]);
        unset($fields[$this->pk]);
        $this->Db->update($this->table, $fields, $where);
    }
    function delete($id) {
        $this->Db->execute("DELETE FROM {$this->table} WHERE {$this->pk} = ?", $id);
    }
    function count() {
        return $this->Db->getOne("SELECT COUNT(*) FROM {$this->table}");
    }
}

// +-----------------------------------------------------------------+
// | Database abstraction library (supporting mysql, oracle, pgsql). |
// | Author: Cezary Tomczak [www.gosu.pl]                            |
// | Free for any use as long as all copyright messages are intact.  |
// +-----------------------------------------------------------------+

define('DB_FETCH_ASSOC', 1);
define('DB_FETCH_NUM', 2);
define('DB_FETCH_BOTH', 3);
define('DB_FETCH_OBJECT', 4);

// --
// Db
// --

class Db {
    var $prepareTokens = array();
    var $prepareQueries = array();

    var $driver;
    var $Debug;

    var $fetchmode = DB_FETCH_ASSOC;
    var $autoFreeResult = 0;
    var $autoCommit = 1;
    var $lastQuery = "";
    var $connectId;

    function Db() {
        if (!extension_loaded($this->driver)) {
            trigger_error("Db::__construct() failed, '{$this->driver}' extension not loaded", E_USER_ERROR);
        }
        register_shutdown_function(array(&$this, 'destruct'));
    }
    function destruct() {
        if ($this->autoCommit == 0) { $this->rollback(); }
    }

    // Check whether query is a data selection query.
    function isSelect($query) {
        $s = 'SELECT|SHOW|CHECK|REPAIR|OPTIMIZE|ANALYZE|EXPLAIN|DESCRIBE';
        return preg_match('/^\s*('.$s.')\s+/i', $query);
    }
    function isConnected() {
        return is_resource($this->connectId) || is_object($this->connectId);
    }
    // $options = array('host' => ?, 'username' => ?, 'password' => ?, 'database' => ?, 'persistent' => ?);
    function connect($options) {
        $this->_connect($options);
        if (!$this->isConnected()) {
            return trigger_error(serialize(array(
                'message'  => 'Db::connect() failed',
                'error' => $this->getError()
            )), E_USER_ERROR);
        }
    }
    function disconnect() {
        $ret = $this->_disconnect();
        $this->connectId = null;
        return $ret;
    }
    // returns object|resource|true|false
    function simpleQuery($query) {
        return $this->_query($query);
    }
    // returns object|void
    function query($query) {
        if (!$this->isConnected()) { return trigger_error('Db::query() called, but not connected', E_USER_ERROR); }
        if ($this->Debug) { $this->Debug->start(); }

        $resultId = $this->_query($query);
        $this->lastQuery = $query;

        if ($resultId === false || $resultId === null) {
            return trigger_error(serialize(array(
                'message' => 'Db::query() failed',
                'error' => $this->getError(),
                'lastQuery' => $this->lastQuery
            )), E_USER_ERROR);
        }
        $result = null;
        if (is_resource($resultId) || is_object($resultId)) {
            $type = ucfirst($this->driver);
            $class = "Db{$type}Result";
            $result =& new $class($resultId, $this);
        }
        if ($this->Debug) { $this->Debug->end($query, $result); }
        if (is_object($result)) {
            return $result;
        }
    }
    function quote($s) {
        switch (true) {
            case is_null($s):   return 'NULL';
            case is_int($s):    return $s;
            case is_float($s):  return $s;
            case is_bool($s):   return (int) $s;
            case is_string($s): return "'" . str_replace("'", "''", $s) . "'";
            default: return trigger_error(sprintf("Db::quote() failed, invalida data type: '%s'", gettype($s)), E_USER_ERROR);
        }
    }
    function quoteLike($s) {
        return str_replace(array("'",  '%',  '_'), array("''", '\%', '\_'), $s);
    }
    // Last insert id
    function insertId() {
        $id = $this->_insertId();
        if (is_int($id) && ($id < 1)) {
            return trigger_error(serialize(array(
                'message' => 'Db::insertId() failed',
                'error' => $this->getError(),
                'lastQuery' => $this->lastQuery
            )), E_USER_ERROR);
        }
        return $id;
    }
    // Number of affected rows, after INSERT, UPDATE or DELETE query
    function affectedRows() {
        $rows = $this->_affectedRows();
        if (is_int($rows) && ($rows < 0)) {
            return trigger_error(serialize(array(
                'message' => 'Db::affectedRows() failed',
                'error' => $this->getError(),
                'lastQuery'   => $this->lastQuery
            )), E_USER_ERROR);
        }
        return $rows;
    }

    // Binds variables passed to the function with the given query.
    // returns string
    function bind($query, $data = array()) {
        if (func_num_args() > 2) {
            $data = func_get_args();
            array_shift($data);
        } else if (!is_array($data)) {
            $data = array($data);
        }
        $tokens = explode('?', $query);
        if (($c1 = count($data)) != ($c2 = (count($tokens) - 1) )) {
            $this->lastQuery = $query;
            return trigger_error(serialize(array(
                'message' => "Db::bind() failed, sizeof data ($c1) != sizeof params ($c2)",
                'error' => $this->getError(),
                'lastQuery' => $this->lastQuery
            )), E_USER_ERROR);
        }
        $s = $tokens[0];
        for ($i = 0; $i < $c1; ++$i) {
            $s .= ( $this->quote($data[$i]) . $tokens[$i + 1] );
        }
        return $s;
    }
    // Prepare query (emulated).
    // returns resource handle for the query (statement)
    function prepare($query) {
        $this->prepareTokens[] = explode('?', $query);
        end($this->prepareTokens);
        $k = key($this->prepareTokens);
        $this->prepareQueries[$k] = $query;
        return $k;
    }
    // Execute query or statement (emulated).
    // $stmt - query or prepared query handler
    // returns object|void
    function execute($stmt, $data = array()) {
        if (func_num_args() > 2) {
            $data = func_get_args();
            array_shift($data);
        } else if (!is_array($data)) {
            $data = array($data);
        }
        if (!is_int($stmt)) {
            $query = $stmt;
            $tokens = explode('?', $query);
        } else {
            $tokens = $this->prepareTokens[$stmt];
            $query  = $this->prepareQueries[$stmt];
        }
        if (!isset($tokens) || !is_array($tokens) || !count($tokens)) {
            $this->lastQuery = $query;
            return trigger_error(serialize(array(
                'message'   => 'Db::execute() failed, invalid statement',
                'error'     => $this->getError(),
                'lastQuery' => $this->lastQuery
            )), E_USER_ERROR);
        }
        if (($c1 = count($data)) != ($c2 = (count($tokens) - 1))) {
            $this->lastQuery = $query;
            return trigger_error(serialize(array(
                'message'   => "Db::execute() failed, sizeof data ($c1) != sizeof params ($c2)",
                'error'     => $this->getError(),
                'lastQuery' => $this->lastQuery
            )), E_USER_ERROR);
        }
        $realquery = $tokens[0];
        for ($i = 0; $i < $c1; ++$i) {
            $realquery .= ( $this->quote($data[$i]) . $tokens[$i + 1] );
        }
        return $this->query($realquery);
    }
    // Free statement resource that was created with prepare() (emulated)
    function free() {
        $args = func_get_args();
        if (count($args) == 0) { return trigger_error('Db::free() failed, no arguments found', E_USER_ERROR); }
        foreach ($args as $stmt) {
            if (!isset($this->prepareTokens[$stmt])) {
                return trigger_error('Db::free() failed, invalid statement resource', E_USER_ERROR);
            }
            unset($this->prepareTokens[$stmt], $this->prepareQueries[$stmt]);
        }
    }
    // Auto insert query.
    // $fields - associative array with fields names as keys and fields values as values.
    function insert($table, $fields) {
        if (!count($fields)) { return trigger_error('Db::insert() failed, array $fields is empty', E_USER_ERROR); }
        $cols = '';
        $vals = '';
        $first = true;
        foreach ($fields as $k => $v) {
            if ($first) {
                $cols .= $k;
                $vals .= $this->quote($v);
                $first = false;
            } else {
                $cols .= ',' . $k;
                $vals .= ',' . $this->quote($v);
            }
        }
        $query = "INSERT INTO $table ($cols) VALUES ($vals)";
        return $this->query($query);
    }
    // Auto update query.
    // $fields - associative array with fields names as keys and fields values as values
    // $where - string to put after the WHERE statement, you have to quote values there with quote() method
    function update($table, $fields, $where) {
        if (!count($fields)) { return trigger_error('Db::update() failed, array $fields is empty', E_USER_ERROR); }
        $set = '';
        $first = true;
        foreach ($fields as $k => $v) {
            if ($first) {
                $set   .= $k . '=' . $this->quote($v);
                $first  = false;
            } else {
                $set .= ',' . $k . '=' . $this->quote($v);
            }
        }
        $query = "UPDATE $table SET $set WHERE $where";
        return $this->query($query);
    }
    function getOne($query, $data = array()) {
        if (func_num_args() > 2) {
            $data = func_get_args();
            array_shift($data);
        } else if (!is_array($data)) {
            $data = array($data);
        }
        $Rs = (count($data) ? $this->execute($query, $data) : $this->query($query));
        return $Rs->fetchOne();
    }
    function getRow($query, $data = array()) {
        if (func_num_args() > 2) {
            $data = func_get_args();
            array_shift($data);
        } else if (!is_array($data)) {
            $data = array($data);
        }
        $Rs = (count($data) ? $this->execute($query, $data) : $this->query($query));
        $row = $Rs->fetchRow();
        $Rs->free();
        return $row;
    }
    function getCol($query, $data = array()) {
        if (func_num_args() > 2) {
            $data = func_get_args();
            array_shift($data);
        } else if (!is_array($data)) {
            $data = array($data);
        }
        $Rs = (count($data) ? $this->execute($query, $data) : $this->query($query));
        return $Rs->fetchCol();
    }
    function getAssoc($query, $data = array()) {
        if (func_num_args() > 2) {
            $data = func_get_args();
            array_shift($data);
        } else if (!is_array($data)) {
            $data = array($data);
        }
        $Rs = (count($data) ? $this->execute($query, $data) : $this->query($query));
        return $Rs->fetchAssoc();
    }
    function getAll($query, $data = array()) {
        if (func_num_args() > 2) {
            $data = func_get_args();
            array_shift($data);
        } else if (!is_array($data)) {
            $data = array($data);
        }
        $Rs = (count($data) ? $this->execute($query, $data) : $this->query($query));
        return $Rs->fetchAll();
    }
}

// --------
// DbResult
// --------

class DbResult {
    var $Db;
    var $fetchmode;
    var $resultId;

    function DbResult($resultId, &$Db) {
        $this->resultId = $resultId;
        $this->fetchmode = $Db->fetchmode;
        $this->Db = $Db;
        register_shutdown_function(array(&$this, 'destruct'));
    }
    function destruct() {
        if (is_resource($this->resultId) || is_object($this->resultId)) {
            $this->free();
        }
    }

    // Fetch 1st element in 1st row (and free result resource).
    function fetchOne() {
        $row = $this->fetchRow(DB_FETCH_NUM);
        if (!is_array($row)) { return false; }
        if (array_key_exists(0, $row)) {
            if ($this->Db->autoFreeResult) { $this->free(); }
            return $row[0];
        } else {
            return null;
        }
    }
    // Fetch 1st column from all rows into one array.
    function fetchCol() {
        $rows = array();
        $row = $this->fetchRow(DB_FETCH_NUM);
        if (!is_array($row)) { return $rows; }
        if (isset($row[0])) {
            $rows[] = $row[0];
        } else {
            return trigger_error('DbResult::fetchCol() failed, no column found', E_USER_ERROR);
        }
        while ($row = $this->fetchRow(DB_FETCH_NUM)) {
            $rows[] = $row[0];
        }
        return $rows;
    }
    // Fetch rows into associative array, using 1st column as key, 2nd column as value.
    function fetchAssoc() {
        $rows = array();
        $row = $this->fetchRow(DB_FETCH_NUM);
        if (!is_array($row)) { return $rows; }
        if (isset($row[0]) && isset($row[1])) {
            $rows[$row[0]] = $row[1];
        } else {
            return trigger_error('DbResult::fetchAssoc() failed, two columns required', E_USER_ERROR);
        }
        while ($row = $this->fetchRow(DB_FETCH_NUM)) {
            $rows[$row[0]] = $row[1];
        }
        return $rows;
    }
    // Fetch all rows.
    function fetchAll($fetchmode = null) {
        $rows = array();
        while ($rows[] = $this->fetchRow($fetchmode));
        array_pop($rows);
        return $rows;
    }
}

// -------
// DbMysql
// -------

class DbMysql extends Db {
    var $driver = 'mysql';
    function quote($s) {
        switch (true) {
            case is_null($s):   return 'NULL';
            case is_int($s):    return $s;
            case is_float($s):  return $s;
            case is_bool($s):   return (int) $s;
            case is_string($s): return "'" . mysql_real_escape_string($s, $this->connectId) . "'";
            default: return trigger_error(sprintf("Db::quote() failed, invalida data type: '%s'", gettype($s)), E_USER_ERROR);
        }
    }
    function quoteLike($s) {
        return str_replace(array("'",  '%',  '_'), array("\'", '\%', '\_'), $s);
    }
    function _connect($o) {
        $this->connectId = @mysql_connect($o['host'], $o['username'], $o['password']);
        if ($this->isConnected()) {
            if (!@mysql_select_db($o['database'], $this->connectId)) {
                return trigger_error(serialize(array(
                    'message'  => 'Db::connect() failed',
                    'error' => $this->getError()
                )), E_USER_ERROR);
            }
        }
    }
    function _disconnect() {
        return @mysql_close($this->connectId);
    }
    // returns object|true|false
    function _query($query) {
        return @mysql_query($query, $this->connectId);
    }
    function _affectedRows() {
        return @mysql_affected_rows($this->connectId);
    }
    function _insertId() {
        return @mysql_insert_id($this->connectId);
    }
    // Modify limit query.
    function limitQuery($query, $offset, $limit) {
        return $query .= " LIMIT $offset, $limit";
    }
    function getError() {
        if ($this->connectId) {
            return @mysql_error($this->connectId);
        }
        return "";
    }
    // Default lock mode is 'write'.
    // Example: $Db->lock(array('tab1' => 'read', 'tab2' => 'write', 'tab3'));
    function lock($tables) {
        if (!is_array($tables) || count($tables) == 0) { return trigger_error('Db::lock() failed, $tables is not an array or is empty', E_USER_ERROR); }
        $query = 'LOCK TABLES';
        foreach ($tables as $k => $v) {
            if (is_int($k)) {
                $table = $v;
                $mode = 'write';
            } else {
                $table = $k;
                $mode = $v;
            }
            $query .= " $table $mode,";
        }
        $query = substr($query, 0, -1);
        $this->query($query);
    }
    function unlock() {
        $this->query('UNLOCK TABLES');
    }
    function begin() {
        $this->query('SET AUTOCOMMIT=0');
        $this->autoCommit = 0;
        $this->query('BEGIN');
    }
    function commit() {
        $this->query('COMMIT');
        $this->query('SET AUTOCOMMIT=1');
        $this->autoCommit = 1;
    }
    function rollback() {
        $this->query('ROLLBACK');
        $this->query('SET AUTOCOMMIT=1');
        $this->autoCommit = 1;
    }
}

// -------------
// DbMysqlResult
// -------------

class DbMysqlResult extends DbResult {
    // When using single call to fetchRow(), mostly u have to free result resource by yourself.
    // returns mixed (If there are no more rows returns false)
    function fetchRow($fetchmode = null) {
        switch (isset($fetchmode) ? $fetchmode : $this->fetchmode) {
            case DB_FETCH_ASSOC:
                $ret = @mysql_fetch_assoc($this->resultId);
                break;
            case DB_FETCH_NUM:
                $ret = @mysql_fetch_row($this->resultId);
                break;
            case DB_FETCH_BOTH:
                $ret = @mysql_fetch_array($this->resultId);
                break;
            case DB_FETCH_OBJECT:
                $ret = @mysql_fetch_object($this->resultId);
                break;
            default:
                return trigger_error('DbResult::fetchRow() failed, invalid fetchmode', E_USER_ERROR);
        }
        if ($ret === null && $this->Db->autoFreeResult) {
            $this->free();
        } else if ($ret === null && (!is_object($this->resultId) || !is_resource($this->resultId))) {
            return trigger_error('Db::fetchRow() failed, result object has been already set free', E_USER_ERROR);
        }
        return $ret;
    }
    function seek($i) {
        return @mysql_data_seek($this->resultId, $i);
    }
    function free() {
        if (is_object($this->resultId) || is_resource($this->resultId)) {
            @mysql_free_result($this->resultId);
            $this->resultId = null;
        }
    }
    function numCols() {
        return @mysql_num_fields($this->resultId);
    }
    function numRows() {
        return @mysql_num_rows($this->resultId);
    }
}

// +----------------------------------------------------------------|
// | Error handler.                                                 |
// | Author: Cezary Tomczak [www.gosu.pl]                           |
// | Free for any use as long as all copyright messages are intact. |
// +----------------------------------------------------------------+

@ini_set('docref_root', null);
@ini_set('docref_ext', null);

global $LOGERROR;
$LOGERROR_FILE = 'error.txt';
$LOGERROR_MSG = 'An error occured.';

function raiseError($errNo, $errMsg, $file, $line) {
    if (!($errNo & error_reporting())) { return; }
    while (ob_get_level()) { ob_end_clean(); }
    $errType = array (
        1 => "Php Error", 2 => "Php Warning", 4 => "Parsing Error", 8 => "Php Notice",
        16 => "Core Error", 32 => "Core Warning", 64 => "Compile Error", 128 => "Compile Warning",
        256 => "Php User Error", 512 => "Php User Warning", 1024 => "Php User Notice"
    );
    $info = array();
    if (($errNo & E_USER_ERROR) && is_array($arr = @unserialize($errMsg))) {
        foreach ($arr as $k => $v) {
            $info[$k] = $v;
        }
    }
    $trace = array();
    if (function_exists('debug_backtrace')) {
        $trace = debug_backtrace();
        array_shift($trace);
    }
    displayError(array('errNo' => $errNo, 'errMsg' => $errMsg, 'file' => $file, 'line' => $line, 'errType' => $errType, 'info' => $info, 'trace' => $trace));
    exit;
}

function logError($errNo, $errMsg, $file, $line) {
    global $LOGERROR_FILE, $LOGERROR_MSG;
    if (!($errNo & error_reporting())) { return; }
    while (ob_get_level()) { ob_end_clean(); }
    $errType = array (
        1 => "Php Error", 2 => "Php Warning", 4 => "Parsing Error", 8 => "Php Notice",
        16 => "Core Error", 32 => "Core Warning", 64 => "Compile Error", 128 => "Compile Warning",
        256 => "Php User Error", 512 => "Php User Warning", 1024 => "Php User Notice"
    );
    $info = array();
    if (($errNo & E_USER_ERROR) && is_array($arr = @unserialize($errMsg))) {
        foreach ($arr as $k => $v) {
            $info[$k] = $v;
        }
    }
    $trace = array();
    if (function_exists('debug_backtrace')) {
        $trace = debug_backtrace();
        array_shift($trace);
    }
    $err = '';
    $err .= "ERROR TYPE: {$errType[$errNo]}\r\n";
    if (!count($info)) {
        $err .= "ERROR MESSAGE: $errMsg\r\n";
    }
    $err .= "DATE: ".(date('Y-m-d H:i:s'))."\r\n";
    $err .= "URI: ".$_SERVER['REQUEST_URI']."\r\n";
    $err .= "FILE: $file\r\n";
    $err .= "LINE: $line\r\n";
    foreach ($info as $k => $v) {
        $err .= strtoupper($k).": $v\r\n";
    }
    if (count($trace)) {
        $err .= "BACKTRACE:\r\n";
        foreach ($trace as $v) {
            $err .= "    [".@$v['line']."] ".basename(@$v['file'])." (".@$v['file'].")\r\n";
        }
    }
    $err .= "\r\n";
    if ($fp = fopen($LOGERROR_FILE, 'a')) {
        fwrite($fp, $err);
        fclose($fp);
    }
    echo $LOGERROR_MSG;
    exit;
}

function displayError($arr) {
    extract($arr);
    ?>
<script type="text/javascript">
function showParam(i) {
    currentParam = i;
    document.getElementById('paramHide').style.display = ''
    document.getElementById('paramSpace').style.display = ''
    document.getElementById('param').style.display = ''
    document.getElementById('param').innerHTML = '<pre>' + document.getElementById('param' + i).innerHTML + '</pre>'
}
function hideParam() {
    currentParam = -1;
    document.getElementById('paramHide').style.display = 'none'
    document.getElementById('paramSpace').style.display = 'none'
    document.getElementById('param').style.display = 'none'
}
function showOrHideParam(i) {
    if (currentParam == i) {
        hideParam()
    } else {
        showParam(i)
    }
}
function showFile(id) {
    eval('display = document.getElementById("file' + id + '").style.display')
    eval('if (display == "none") { document.getElementById("file' + id + '").style.display = "" } else { document.getElementById("file' + id + '").style.display = "none" } ');
}
function showDetails(cnt) {
    for (i = 0; i < cnt; ++i) {
        eval('document.getElementById("file' + i + '").style.display = ""')
    }
}
function hideDetails(cnt) {
    for (i = 0; i < cnt; ++i) {
        eval('document.getElementById("file' + i + '").style.display = "none"')
    }
}
var currentParam = -1;
</script>

<pre>
<hr />

<b>Error type:</b> <?php echo $errType[$errNo]; ?>

<?php

    function fontStart($color) {
        return '<font color="' . $color . '">';
    }
    function fontEnd() {
        return '</font>';
    }

    $c['default'] = '#000000';
    $c['keyword'] = '#0000A0';
    $c['number']  = '#800080';
    $c['string']  = '#404040';
    $c['comment'] = '#808080';

    if (count($info)) {
        foreach ($info as $k => $v) {
            echo '<b>';
            echo $k;
            echo ':</b> ';
            echo $v;
            echo "\r\n";
        }
    } else {
        echo '<b>Message:</b> ';
        echo $errMsg;
        echo "\r\n";
    }

    echo "\r\n";

    if (count($trace)) {

        echo '<span style="font-family: monospaced; font-size: 11px;">Trace: ' . count($trace) . "</span> ";
        echo '<span style="font-family: monospaced; font-size: 11px; cursor: pointer;" onclick="showDetails('.count($trace).')">[show details]</span> ';
        echo '<span style="font-family: monospaced; font-size: 11px; cursor: pointer;" onclick="hideDetails('.count($trace).')">[hide details]</span>';

        echo "\r\n";
        echo "\r\n";

        echo '<ul>';
        $currentParam = -1;

        foreach ($trace as $k => $v) {

            $currentParam++;

            echo '<li style="list-style-type: square;">';

            if (isset($v['class'])) {
                echo '<span onmouseover="this.style.color=\'#0000ff\'" onmouseout="this.style.color=\''.$c['keyword'].'\'" style="color: '.$c['keyword'].'; cursor: pointer;" onclick="showFile('.$k.')">';
                echo $v['class'];
                echo ".";
            } else {
                echo '<span onmouseover="this.style.color=\'#0000ff\'" onmouseout="this.style.color=\''.$c['keyword'].'\'" style="color: '.$c['keyword'].'; cursor: pointer;" onclick="showFile('.$k.')">';
            }

            echo $v['function'];
            echo '</span>';
            echo " (";

            $sep = '';
            $v['args'] = (array) @$v['args'];
            foreach ($v['args'] as $arg) {

                $currentParam++;

                echo $sep;
                $sep    = ', ';
                $color = '#404040';

                switch (true) {

                    case is_bool($arg):
                        $param  = 'TRUE';
                        $string = $param;
                        break;

                    case is_int($arg):
                    case is_float($arg):
                        $param  = $arg;
                        $string = $arg;
                        $color = $c['number'];
                        break;

                    case is_null($arg):
                        $param = 'NULL';
                        $string = $param;
                        break;

                    case is_string($arg):
                        $param = $arg;
                        $string = 'string[' . strlen($arg) . ']';
                        break;

                    case is_array($arg):
                        ob_start();
                        print_r($arg);
                        $param = ob_get_contents();
                        ob_end_clean();
                        $string = 'array[' . count($arg) . ']';
                        break;

                    case is_object($arg):
                        ob_start();
                        print_r($arg);
                        $param = ob_get_contents();
                        ob_end_clean();
                        $string = 'object: ' . get_class($arg);
                        break;

                    case is_resource($arg):
                        $param = 'resource: ' . get_resource_type($arg);
                        $string = 'resource';
                        break;

                    default:
                        $param = 'unknown';
                        $string = $param;
                        break;

                }

                echo '<span style="cursor: pointer; color: '.$color.';" onclick="showOrHideParam('.$currentParam.')" onmouseout="this.style.color=\''.$color.'\'" onmouseover="this.style.color=\'#dd0000\'">';
                echo $string;
                echo '</span>';
                echo '<span id="param'.$currentParam.'" style="display: none;">' . $param . '</span>';

            }

            echo ")";
            echo "\r\n";

            if (!isset($v['file'])) {
                $v['file'] = 'unknown';
            }
            if (!isset($v['line'])) {
                $v['line'] = 'unknown';
            }

            $v['line'] = @$v['line'];
            echo '<span id="file'.$k.'" style="display: none; color: gray;">';
            echo 'FILE: ' . fontStart('#007700') . basename($v['file']) . fontEnd();
            echo "\r\n";
            echo 'LINE: ' . fontStart('#007700') . $v['line'] . fontEnd() . "\r\n";
            echo 'DIR:  ' . fontStart('#007700') . dirname($v['file']) . fontEnd();
            echo '</span>';

            echo '</li>';
        }

        echo '</ul>';

    } else {
        echo '<b>File:</b> ';
        echo basename($file);
        echo ' (' . $line . ') ';
        echo dirname($file);
    }

?>

<?php echo '<span id="paramHide" style="display: none; font-family: monospaced; font-size: 11px; cursor: pointer;" onclick="hideParam()">[hide param]</span>';?>
<span id="paramSpace" style="display: none;">

</span><div id="param" perm="0" style="background-color: #FFFFE1; padding: 2px; display: none;"></div><hr />

Trick: click on a function's argument to see it fully
Trick: click on a function to see the file & line

</pre>
    <?php
}

// +----------------------------------------------------------------|
// | Template system based on native php.                           |
// | Author: Cezary Tomczak [www.gosu.pl]                           |
// | Free for any use as long as all copyright messages are intact. |
// +----------------------------------------------------------------+

class sugolibTemplate {
    var $file;
    var $vars = array();
    var $header;
    var $footer;

    function sugolibTemplate($file = null) {
        if (isset($file)) { $this->file = $file; }
    }
    function set($key, $value) {
        $this->vars[$key] = $value;
    }
    // Note: existing keys are not overwritten.
    function setArray($vars) {
        if (!is_array($vars)) { return trigger_error('sugolibTemplate::setArray() failed, vars must be an array', E_USER_ERROR); }
        $this->vars += $vars;
    }
    function fetch() {
        if (!file_exists($this->file) || !is_file($this->file)) {
            return trigger_error("sugolibTemplate::fetch() failed, file does not exist '{$this->file}'", E_USER_ERROR);
        }
        ob_start();
        extract($this->vars, EXTR_SKIP);
        if ($this->header) include $this->header;
        include $this->file;
        if ($this->footer) include $this->footer;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    function display($file = null) {
        if (isset($file)) { $this->file = $file; }
        echo $this->fetch();
    }
    // -------
    // PLUGINS
    // -------
    function htmlOptions($options, $selected = null) {
        $ret = '';
        foreach ($options as $k => $v) {
            $ret .= '<option value="'.str_replace('"', '\"', $k).'"';
            if ((is_array($selected) && in_array($k, $selected)) || (!is_array($selected) && $k == $selected && $selected !== '' && $selected !== null)) {
                if (!(is_numeric($k) xor is_numeric($selected))) {
                    $ret .= ' selected="selected"';
                }
            }
            $ret .= '>'.htmlspecialchars($v).'</option>';
        }
        return $ret;
    }
	//
	// ??? publish/document.tpl
	//
	function getTimezone() {
	    $t1 = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('y'));
	    $t2 = mktime(gmdate('H'), gmdate('i'), gmdate('s'), gmdate('m'), gmdate('d'), gmdate('y'));
	    $t = $t1 - $t2;
	    $t = floor($t/60);
	    $sign = $t>=0 ? '+':'-';
	    if ($t<0) $t = -$t;
	    $s1 = str_pad(floor($t/60), 2, '0', STR_PAD_LEFT);
	    $s2 = str_pad($t % 60, 2, '0', STR_PAD_LEFT);
	    return 'GMT'.$sign.$s1.':'.$s2;
	}
}

// +----------------------------------------------------------------+
// | Uploading files.                                               |
// | Author: Cezary Tomczak [www.gosu.pl]                           |
// | Free for any use as long as all copyright messages are intact. |
// +----------------------------------------------------------------+

class Upload {
    var $chmod = 666;
    var $tmp, $filename, $type, $size, $error;
    function Upload($name) {
        if (isset($_FILES[$name])) {
            $this->tmp      = @$_FILES[$name]['tmp_name'];
            $this->filename = @$_FILES[$name]['name'];
            $this->type     = @$_FILES[$name]['type'];
            $this->size     = @$_FILES[$name]['size'];
            $this->error    = @$_FILES[$name]['error'];
        }
        $this->filename = basename($this->filename);
        $this->size = (int) $this->size;
    }
    function isValid() {
        if ( (!file_exists($this->tmp) || !is_file($this->tmp))
            || !is_uploaded_file($this->tmp) || $this->size == 0 || !$this->filename ||
            (isset($this->error) && UPLOAD_ERR_OK !== $this->error) )
        {
            return false;
        }
        return true;
    }
    // Returns for example: '.gif' or null
    function getExtension() {
        $s = $this->filename;
        $ext = null;
        if (($pos = strrpos($s, '.')) !== false) {
            $len = strlen($s) - $pos;
            $ext = substr($s, -$len);
        }
        return $ext;
    }
    function moveTo($path, $chmod = null) {
        if (!isset($chmod)) { $chmod = $this->chmod; }
        if (isset($chmod) && !is_numeric($chmod)) { return trigger_error('Upload::moveTo() failed, chmod must be a decimal number, for example 604', E_USER_ERROR); }
        $ret = move_uploaded_file($this->tmp, $path);
        if ($ret && isset($chmod)) {
            $chmod = octdec('0' . $chmod);
            $ret = chmod($path, $chmod);
        }
        return $ret;
    }
}

// +----------------------------------------------------------------+
// | Getters for GET, POST, COOKIE variables.                       |
// | Author: Cezary Tomczak [www.gosu.pl]                           |
// | Free for any use as long as all copyright messages are intact. |
// +----------------------------------------------------------------+

function get($name) {
    if (func_num_args() > 1) {
        $name = func_get_args();
    }
    if (is_array($name)) {
        $ret = array();
        foreach ($name as $v) {
           $ret[$v] = get($v);
        }
        return $ret;
    }
    if (isset($_GET[$name])) {
        return $_GET[$name];
    }
    return null;
}

function post($name) {
    if (func_num_args() > 1) {
        $name = func_get_args();
    }
    if (is_array($name)) {
        $ret = array();
        foreach ($name as $v) {
           $ret[$v] = post($v);
        }
        return $ret;
    }
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    return null;
}

function request($name) {
    if (func_num_args() > 1) {
        $name = func_get_args();
    }
    if (is_array($name)) {
        $ret = array();
        foreach ($name as $v) {
           $ret[$v] = request($v);
        }
        return $ret;
    }
    if (isset($_REQUEST[$name])) {
        return $_REQUEST[$name];
    }
    return null;
}

function cookie($name) {
    if (isset($_COOKIE[$name])) { return $_COOKIE[$name]; }
    else { return null; }
}

function session($name) {
    if (isset($_SESSION[$name])) { return $_SESSION[$name]; }
    else { return null; }
}

// +-------+
// | OTHER |
// +-------+

function sugolib_redirect($path) {
    header("Location: $path");
    exit;
}

function printR($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    exit;
}

// check request method
function isPOST() { return $_SERVER['REQUEST_METHOD'] == 'POST'; }
function isGET() { return $_SERVER['REQUEST_METHOD'] == 'GET'; }

function stripQuotes(&$data) {
    if (is_array($data)) {
        foreach ($data as $k => $v) { stripQuotes($data[$k]); }
    } else {
        $data = stripslashes($data);
    }
}

?>