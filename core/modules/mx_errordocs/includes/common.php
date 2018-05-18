<?php
/**
*
* @package MX-Publisher Module - mx_errordocs
* @version $Id: common.php,v 1.3 2010/10/16 04:06:46 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

//
// Define table names.
//
define('ERRORDOCS_LOG_TABLE', $mx_table_prefix.'errordocs_log');

global $mx_user;

//
// Base template
//
$mx_user->set_module_default_style('_core'); // For compatibility with core 2.8.x

//
// Load language files.
//
if( file_exists($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) )
{
	include_once($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
}
else
{
	include_once($module_root_path . 'language/lang_english/lang_admin.' . $phpEx);
}
if( file_exists($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx) )
{
	include_once($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
}
else
{
	include_once($module_root_path . 'language/lang_english/lang_main.' . $phpEx);
}

// ================================================================================
//								[ COMMON CLASSES ]
// ================================================================================

//
// ErrorDocs class
//
class clsErrorDocs
{
	var	$code,
		$short_info,
		$long_info,
		$title,
		$server_name,
		$request_uri,
		$http_referer,
		$referer_info,
		$user_id,
		$user_ip;
	var	$include_codes,
		$exclude_fiext;

	//
	// Constructor...
	//

	function clsErrorDocs($max_log_records)
	{
		$this->code = 0;
		$this->include_codes = array();
		$this->exclude_fiext = array();

		$id = $this->dbMaxId(ERRORDOCS_LOG_TABLE, 'id');
		$sql = "DELETE FROM ".ERRORDOCS_LOG_TABLE." WHERE id < ".max(0, ($id - $max_log_records));
		$this->dbQuery($sql);
	}

	//
	// Public Methods...
	//
	function set_include_codes($include_codes)
	{
		$this->include_codes = ( empty($include_codes) ? array() : explode(',', $include_codes) );
	}

	function set_exclude_fiext($exclude_fiext)
	{
		$this->exclude_fiext = ( empty($exclude_fiext) ? array() : explode(',', $exclude_fiext) );
	}

	function capture_error_info($code)
	{
		global $lang, $userdata, $user_ip;
		global $HTTP_SERVER_VARS, $HTTP_ENV_VARS, $REMOTE_ADDR;

		$this->code = $code;

		//
		// Retrieve relevant information...
		//
		if( !empty($lang['ErrorDocs_Error'][$this->code]['short']) )
		{
			$this->short_info = $lang['ErrorDocs_Error'][$this->code]['short'];
			$this->long_info  = $lang['ErrorDocs_Error'][$this->code]['long'];
		}
		else
		{
			$this->short_info = $lang['ErrorDocs_Error'][0]['short'];
			$this->long_info  = $lang['ErrorDocs_Error'][0]['long'];
		}
		$this->title = sprintf($lang['ErrorDocs_Title'], $this->code.'', $this->short_info);

		$this->server_name = $HTTP_SERVER_VARS['SERVER_NAME'];
		$this->request_uri = $HTTP_SERVER_VARS['REQUEST_URI'];
		$this->http_referer = $HTTP_SERVER_VARS['HTTP_REFERER'];

		if( !empty($this->http_referer) )
		{
			$this->referer_info = sprintf($lang['ErrorDocs_Referer'], $this->http_referer);
		}
		else
		{
			$this->referer_info = $lang['ErrorDocs_ChkRequ'];
		}

		//
		// Capture user's identifier...
		//
		$this->user_id = $userdata['user_id'];

		//
		// Capture user's IP Address (even if behind a proxy)...
		//
		$client_ip = ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : $REMOTE_ADDR );
		if( getenv('HTTP_X_FORWARDED_FOR') != '' )
		{
			if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", getenv('HTTP_X_FORWARDED_FOR'), $ip_list) )
			{
				$private_ip = array('/^0\./', '/^127\.0\.0\.1/', '/^192\.168\..*/', '/^172\.16\..*/', '/^10.\.*/', '/^224.\.*/', '/^240.\.*/');
				$client_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
			}
		}
		$this->user_ip = encode_ip($client_ip);
	}

	function is_write_log_allowed()
	{
		//
		// Filter Log Records depending on ErrorDocs_Include_Codes...
		//
		if( count($this->include_codes) > 0 && !in_array($this->code, $this->include_codes) )
		{
			return FALSE;
		}
		//
		// Filter Log Records depending on ErrorDocs_Exclude_Extensions...
		//
		$uri = parse_url($this->request_uri);
		$fiext = end(@explode(".", $uri['path']));
		if( count($this->exclude_fiext) > 0 && in_array($fiext, $this->exclude_fiext) )
		{
			return FALSE;
		}
		return TRUE;
	}

	function write_log()
	{
		global $userdata;

		if( !$this->is_write_log_allowed() )
		{
			return FALSE;
		}
		$id = $this->dbMaxId(ERRORDOCS_LOG_TABLE, 'id');
		if( empty($id) )
			$id = 0;
		$id++;
		$sql = "INSERT INTO ".ERRORDOCS_LOG_TABLE.
				" (id, tstamp, errno, user_id, user_ip, request_uri, http_referer)".
				" VALUES ($id, ".time().", $this->code, ".$this->user_id.", '".$this->user_ip."', '".addslashes($this->request_uri)."', '".addslashes($this->http_referer)."')";
		if( !@$this->dbQuery($sql) )
		{
			if( $userdata['user_level'] == ADMIN  && !defined("IN_ADMIN") && !defined("IN_LOGIN") )
			{
				//mx_message_die(GENERAL_ERROR, "Couldn't insert data into ErrorDocs table", '', __LINE__, __FILE__, $sql);
			}
			return FALSE;
		}
		return TRUE;
	}

	//
	// DataBase interface...
	//

	var	$sql;			// Last SQL query executed.

	function dbQuery($sql)
	{
		global $db;
		$this->sql = $sql;
		$result = $db->sql_query($sql);
		return $result;
	}

	function dbFetchRow($sql)
	{
		global $db;
		$this->sql = $sql;
		if( !$result = $db->sql_query($sql) )
			return false;
		if( !$row = $db->sql_fetchrow($result) )
			return false;
		return $row;
	}

	function dbMaxId($table_name, $table_key)
	{
		global $db;
		$sql = "SELECT MAX(" . $table_key . ") AS max_id FROM " . $table_name;
		$this->sql = $sql;
		if( !$row = $this->dbFetchRow($sql) )
			return -1;
		return $row['max_id'];
	}

	function dbCount($table_name)
	{
		global $db;
		$sql = "SELECT COUNT(*) AS numrecs FROM " . $table_name;
		$this->sql = $sql;
		if( !$row = $this->dbFetchRow($sql) )
			return 0;
		return $row['numrecs'];
	}

} //class clsErrorDocs
?>