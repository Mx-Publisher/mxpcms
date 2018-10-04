<?php
/**
*
* @package MX-Publisher Installation
* @version $Id: functions_install.php,v 1.20 2008/09/30 07:04:45 orynider Exp $
* @copyright (c) 2006 phpBB Group
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

/*
*
* Dealing with template header/footer...
*/
function page_header_install($title, $instruction_text = '')
{
	global $template, $lang, $mx_root_path, $mx_portal_name, $mx_portal_version, $tplEx;

	$template->set_filenames(array('header' => 'mx_install_header.'.$tplEx));
	$template->assign_vars(array(
		'L_PORTAL_NAME'			=> $mx_portal_name,
		'L_PORTAL_VERSION'		=> $mx_portal_version,
		'U_INSTALL_URL'			=> $mx_root_path . 'install/',
		'L_INSTALLATION'		=> $title,
		'L_INSTRUCTION_TEXT'	=> $instruction_text,
	));
	$template->pparse('header');
}

function page_footer_install($show_phpinfo = true)
{
	global $db, $template, $lang, $tplEx;

	$install_moreinfo = sprintf($lang['Install_moreinfo'],
		'<a href="'.U_RELEASE_NOTES.'" target="_blank">', '</a>',
		'<a href="'.U_ONLINE_MANUAL.'" target="_blank">', '</a>',
		'<a href="'.U_ONLINE_KB.'" target="_blank">', '</a>',
		'<a href="'.U_ONLINE_SUPPORT.'" target="_blank">', '</a>',
		'<a href="'.U_TERMS_OF_USE.'" target="_blank">', '</a>'
	);

	$template->set_filenames(array('footer' => 'mx_install_footer.'.$tplEx));
	$template->assign_vars(array(
		'L_INSTALLER_NAME'		=> INSTALLER_NAME,
		'L_INSTALLER_VERSION'	=> INSTALLER_VERSION,
		'L_INSTALL_MOREINFO'	=> $install_moreinfo,
		'L_INSTALL_PHPINFO'		=> ( $show_phpinfo ? '<a href="?phpinfo" target="_blank">phpInfo</a>' : '' ),
	));
	$template->pparse('footer');

	if( $db )
	{
		$db->sql_close();
		$db = false;
	}
	exit;
}

/**
* Determine if we are able to load a specified PHP module and do so if possible
*/
function can_load_dll($dll)
{
	return ((@ini_get('enable_dl') || strtolower(@ini_get('enable_dl')) == 'on') && (!@ini_get('safe_mode') || strtolower(@ini_get('safe_mode')) == 'off') && @dl($dll . '.' . PHP_SHLIB_SUFFIX)) ? true : false;
}

/**
* Returns an array of available DBMS with some data, if a DBMS is specified it will only
* return data for that DBMS and will load its extension if necessary.
*/
function get_available_dbms($dbms = false, $return_unavailable = false, $only_20x_options = false)
{
	global $lang;
	$available_dbms = array(
//		'firebird'	=> array(
//			'LABEL'			=> 'FireBird',
//			'SCHEMA'		=> 'firebird',
//			'MODULE'		=> 'interbase',
//			'DELIM'			=> ';;',
//			'COMMENTS'		=> 'remove_remarks',
//			'DRIVER'		=> 'firebird',
//			'AVAILABLE'		=> true,
//			'2.0.x'			=> false,
//		),
		'mysql6' => array(
			'LABEL'			=> 'MySQL 6.x',
			'SCHEMA'		=> 'mysql_61',
			'MODULE'		=> 'mysqli',
			'DELIM'			=> ';',
			'COMMENTS'		=> 'remove_remarks',
			'DRIVER'		=> 'mysqli',
			'AVAILABLE'		=> true,
			'2.0.x'			=> true,
		),
		'mysqli'	=> array(
			'LABEL'			=> 'MySQL with MySQLi Extension',
			'SCHEMA'		=> 'mysql_41',
			'MODULE'		=> 'mysqli',
			'DELIM'			=> ';',
			'COMMENTS'		=> 'remove_remarks',
			'DRIVER'		=> 'mysqli',
			'AVAILABLE'		=> true,
			'2.0.x'			=> true,
		),
		'mysql'		=> array(
			'LABEL'			=> 'MySQL',
			'SCHEMA'		=> 'mysql',
			'MODULE'		=> 'mysql',
			'DELIM'			=> ';',
			'COMMENTS'		=> 'remove_remarks',
			'DRIVER'		=> 'mysql',
			'AVAILABLE'		=> true,
			'2.0.x'			=> true,
		),
		'mysql4' => array(
			'LABEL'			=> 'MySQL 4.x',
			'SCHEMA'		=> 'mysql',
			'MODULE'		=> 'mysql',
			'DELIM'			=> ';',
			'COMMENTS'		=> 'remove_remarks',
			'DRIVER'		=> 'mysql',
			'AVAILABLE'		=> true,
			'2.0.x'			=> true,
		),		
//		'mssql'		=> array(
//			'LABEL'			=> 'MS SQL Server 2000+',
//			'SCHEMA'		=> 'mssql',
//			'MODULE'		=> 'mssql',
//			'DELIM'			=> 'GO',
//			'COMMENTS'		=> 'remove_comments',
//			'DRIVER'		=> 'mssql',
//			'AVAILABLE'		=> true,
//			'2.0.x'			=> true,
//		),
//		'mssql_odbc'=>	array(
//			'LABEL'			=> 'MS SQL Server [ ODBC ]',
//			'SCHEMA'		=> 'mssql',
//			'MODULE'		=> 'odbc',
//			'DELIM'			=> 'GO',
//			'COMMENTS'		=> 'remove_comments',
//			'DRIVER'		=> 'mssql_odbc',
//			'AVAILABLE'		=> true,
//			'2.0.x'			=> true,
//		),
//		'oracle'	=>	array(
//			'LABEL'			=> 'Oracle',
//			'SCHEMA'		=> 'oracle',
//			'MODULE'		=> 'oci8',
//			'DELIM'			=> '/',
//			'COMMENTS'		=> 'remove_comments',
//			'DRIVER'		=> 'oracle',
//			'AVAILABLE'		=> true,
//			'2.0.x'			=> false,
//		),
		'postgres' => array(
			'LABEL'			=> 'PostgreSQL 7.x/8.x',
			'SCHEMA'		=> 'postgres',
			'MODULE'		=> 'pgsql',
			'DELIM'			=> ';',
			'COMMENTS'		=> 'remove_comments',
			'DRIVER'		=> 'postgres',
			'AVAILABLE'		=> true,
			'2.0.x'			=> true,
		),
//		'sqlite'		=> array(
//			'LABEL'			=> 'SQLite',
//			'SCHEMA'		=> 'sqlite',
//			'MODULE'		=> 'sqlite',
//			'DELIM'			=> ';',
//			'COMMENTS'		=> 'remove_remarks',
//			'DRIVER'		=> 'sqlite',
//			'AVAILABLE'		=> true,
//			'2.0.x'			=> false,
//		),
	);

	if ($dbms)
	{
		if (isset($available_dbms[$dbms]))
		{
			$available_dbms = array($dbms => $available_dbms[$dbms]);
		}
		else
		{
			return array();
		}
	}

	// now perform some checks whether they are really available
	foreach ($available_dbms as $db_name => $db_ary)
	{
		if ($only_20x_options && !$db_ary['2.0.x'])
		{
			if ($return_unavailable)
			{
				$available_dbms[$db_name]['AVAILABLE'] = false;
			}
			else
			{
				unset($available_dbms[$db_name]);
			}
			continue;
		}

		$dll = $db_ary['MODULE'];

		if (!@extension_loaded($dll))
		{
			if (!can_load_dll($dll))
			{
				if ($return_unavailable)
				{
					$available_dbms[$db_name]['AVAILABLE'] = false;
				}
				else
				{
					unset($available_dbms[$db_name]);
				}
				continue;
			}
		}
		$any_db_support = true;
	}

	if ($return_unavailable)
	{
		$available_dbms['ANY_DB_SUPPORT'] = $any_db_support;
	}
	return $available_dbms;
}

/**
* Generate the drop down of available database options
*/
function dbms_select($default = '', $only_20x_options = false)
{
	global $lang;

	$available_dbms = get_available_dbms(false, false, $only_20x_options);
	$dbms_options = '';
	foreach ($available_dbms as $dbms_name => $details)
	{
		$selected = ($dbms_name == $default) ? ' selected="selected"' : '';
		$dbms_options .= '<option value="' . $dbms_name . '"' . $selected .'>' . $dbms_name . '</option>';
	}
	return $dbms_options;
}

/**
* Get tables of a database
*/
function get_tables($db)
{
	switch ($db->sql_layer)
	{
		case 'mysql':
		case 'mysql4':
		case 'mysqli':
			$sql = 'SHOW TABLES';
		break;

		case 'sqlite':
			$sql = 'SELECT name
				FROM sqlite_master
				WHERE type = "table"';
		break;

		case 'mssql':
		case 'mssql_odbc':
			$sql = "SELECT name
				FROM sysobjects
				WHERE type='U'";
		break;

		case 'postgres':
			$sql = 'SELECT relname
				FROM pg_stat_user_tables';
		break;

		case 'firebird':
			$sql = 'SELECT rdb$relation_name
				FROM rdb$relations
				WHERE rdb$view_source is null
					AND rdb$system_flag = 0';
		break;

		case 'oracle':
			$sql = 'SELECT table_name
				FROM USER_TABLES';
		break;
	}

	$result = $db->sql_query($sql);

	$tables = array();

	while ($row = $db->sql_fetchrow($result))
	{
		$tables[] = current($row);
	}

	$db->sql_freeresult($result);

	return $tables;
}

/**
* Used to test whether we are able to connect to the database the user has specified
* and identify any problems (eg there are already tables with the names we want to use
* @param	array	$dbms should be of the format of an element of the array returned by {@link get_available_dbms get_available_dbms()}
*					necessary extensions should be loaded already
*/
function connect_check_db($error_connect, &$error, $dbms, $table_prefix, $dbhost, $dbuser, $dbpasswd, $dbname, $dbport, $prefix_may_exist = false, $load_dbal = true, $unicode_check = true)
{
	global $phpbb_root_path, $phpEx, $config, $lang; $mx_php_version;

	if ($load_dbal)
	{
		// Include the DB layer
		// If we are on PHP < 5.0.0 we need to force include or we get a blank page
		if (version_compare(PHP_VERSION, '5.0.0', '<')) 
		{
			global $mx_php_version;
		
			$dbms = 'mysqli' ? 'mysql4' : $dbms; //this version of php does not have mysqli extension and my crash the installer if finds a forum using this
		
			print("This version of php is not supported, returned: " . PHP_VERSION . "<br />Please upgrade at least to $mx_php_version.<br />");
		
		}
		require_once($mx_root_path . 'includes/db/' . $dbms . '.' . $phpEx); // Load dbal and initiate class		
	}

	// Instantiate it and set return on error true
	$sql_db = 'dbal_' . $dbms['DRIVER'];
	$db = new $sql_db();
	$db->sql_return_on_error(true);

	// Check that we actually have a database name before going any further.....
	if ($dbms['DRIVER'] != 'sqlite' && $dbname === '')
	{
		$error[] = $lang['INST_ERR_DB_NO_NAME'];
		return false;
	}

	// Make sure we don't have a daft user who thinks having the SQLite database in the forum directory is a good idea
	if ($dbms['DRIVER'] == 'sqlite' && stripos(phpbb_realpath($dbhost), phpbb_realpath('../')) === 0)
	{
		$error[] = $lang['INST_ERR_DB_FORUM_PATH'];
		return false;
	}

	// Check the prefix length to ensure that index names are not too long and does not contain invalid characters
	switch ($dbms['DRIVER'])
	{
		case 'mysql':
		case 'mysqli':
			if (strpos($table_prefix, '-') !== false || strpos($table_prefix, '.') !== false)
			{
				$error[] = $lang['INST_ERR_PREFIX_INVALID'];
				return false;
			}

		// no break;

		case 'postgres':
			$prefix_length = 36;
		break;

		case 'mssql':
		case 'mssql_odbc':
			$prefix_length = 90;
		break;

		case 'sqlite':
			$prefix_length = 200;
		break;

		case 'firebird':
		case 'oracle':
			$prefix_length = 6;
		break;
	}

	if (strlen($table_prefix) > $prefix_length)
	{
		$error[] = sprintf($lang['INST_ERR_PREFIX_TOO_LONG'], $prefix_length);
		return false;
	}

	// Try and connect ...
	if (is_array($db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport, false, true)))
	{
		$db_error = $db->sql_error();
		$error[] = $lang['INST_ERR_DB_CONNECT'] . '<br />' . (($db_error['message']) ? $db_error['message'] : $lang['INST_ERR_DB_NO_ERROR']);
	}
	else
	{
		// Likely matches for an existing phpBB installation
		if (!$prefix_may_exist)
		{
			$temp_prefix = strtolower($table_prefix);
			$table_ary = array($temp_prefix . 'attachments', $temp_prefix . 'config', $temp_prefix . 'sessions', $temp_prefix . 'topics', $temp_prefix . 'users');

			$tables = get_tables($db);
			$table_intersect = array_intersect($tables, $table_ary);

			if (sizeof($table_intersect))
			{
				$error[] = $lang['INST_ERR_PREFIX'];
			}
		}

		// Make sure that the user has selected a sensible DBAL for the DBMS actually installed
		switch ($dbms['DRIVER'])
		{
			case 'mysqli':
				if (version_compare(mysqli_get_server_info($db->db_connect_id), '4.1.3', '<'))
				{
					$error[] = $lang['INST_ERR_DB_NO_MYSQLI'];
				}
			break;

			case 'sqlite':
				if (version_compare(sqlite_libversion(), '2.8.2', '<'))
				{
					$error[] = $lang['INST_ERR_DB_NO_SQLITE'];
				}
			break;

			case 'firebird':
				// check the version of FB, use some hackery if we can't get access to the server info
				if ($db->service_handle !== false && function_exists('ibase_server_info'))
				{
					$val = @ibase_server_info($db->service_handle, IBASE_SVC_SERVER_VERSION);
					preg_match('#V([\d.]+)#', $val, $match);
					if ($match[1] < 2)
					{
						$error[] = $lang['INST_ERR_DB_NO_FIREBIRD'];
					}
					$db_info = @ibase_db_info($db->service_handle, $dbname, IBASE_STS_HDR_PAGES);

					preg_match('/^\\s*Page size\\s*(\\d+)/m', $db_info, $regs);
					$page_size = intval($regs[1]);
					if ($page_size < 8192)
					{
						$error[] = $lang['INST_ERR_DB_NO_FIREBIRD_PS'];
					}
				}
				else
				{
					$sql = "SELECT *
						FROM RDB$FUNCTIONS
						WHERE RDB$SYSTEM_FLAG IS NULL
							AND RDB$FUNCTION_NAME = 'CHAR_LENGTH'";
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					// if its a UDF, its too old
					if ($row)
					{
						$error[] = $lang['INST_ERR_DB_NO_FIREBIRD'];
					}
					else
					{
						$sql = "SELECT FIRST 0 char_length('')
							FROM RDB\$DATABASE";
						$result = $db->sql_query($sql);
						if (!$result) // This can only fail if char_length is not defined
						{
							$error[] = $lang['INST_ERR_DB_NO_FIREBIRD'];
						}
						$db->sql_freeresult($result);
					}

					// Setup the stuff for our random table
					$char_array = array_merge(range('A', 'Z'), range('0', '9'));
					$char_len = mt_rand(7, 9);
					$char_array_len = sizeof($char_array) - 1;

					$final = '';

					for ($i = 0; $i < $char_len; $i++)
					{
						$final .= $char_array[mt_rand(0, $char_array_len)];
					}

					// Create some random table
					$sql = 'CREATE TABLE ' . $final . " (
						FIELD1 VARCHAR(255) CHARACTER SET UTF8 DEFAULT '' NOT NULL COLLATE UNICODE,
						FIELD2 INTEGER DEFAULT 0 NOT NULL);";
					$db->sql_query($sql);

					// Create an index that should fail if the page size is less than 8192
					$sql = 'CREATE INDEX ' . $final . ' ON ' . $final . '(FIELD1, FIELD2);';
					$db->sql_query($sql);

					if (ibase_errmsg() !== false)
					{
						$error[] = $lang['INST_ERR_DB_NO_FIREBIRD_PS'];
					}
					else
					{
						// Kill the old table
						$db->sql_query('DROP TABLE ' . $final . ';');
					}
					unset($final);
				}
			break;

			case 'oracle':
				if ($unicode_check)
				{
					$sql = "SELECT *
						FROM NLS_DATABASE_PARAMETERS
						WHERE PARAMETER = 'NLS_RDBMS_VERSION'
							OR PARAMETER = 'NLS_CHARACTERSET'";
					$result = $db->sql_query($sql);

					while ($row = $db->sql_fetchrow($result))
					{
						$stats[$row['parameter']] = $row['value'];
					}
					$db->sql_freeresult($result);

					if (version_compare($stats['NLS_RDBMS_VERSION'], '9.2', '<') && $stats['NLS_CHARACTERSET'] !== 'UTF8')
					{
						$error[] = $lang['INST_ERR_DB_NO_ORACLE'];
					}
				}
			break;

			case 'postgres':
				if ($unicode_check)
				{
					$sql = "SHOW server_encoding;";
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if ($row['server_encoding'] !== 'UNICODE' && $row['server_encoding'] !== 'UTF8')
					{
						$error[] = $lang['INST_ERR_DB_NO_POSTGRES'];
					}
				}
			break;
		}

	}

	if ($error_connect && (!isset($error) || !sizeof($error)))
	{
		return true;
	}
	return false;
}

/**
* remove_remarks will strip the sql comment lines out of an uploaded sql file
*/
function remove_remarks(&$sql)
{
	$sql = preg_replace('/\n{2,}/', "\n", preg_replace('/^#.*$/m', "\n", $sql));
}

/**
* split_sql_file will split an uploaded sql file into single sql statements.
* Note: expects trim() to have already been run on $sql.
*/
function split_sql_file($sql, $delimiter)
{
	$sql = str_replace("\r" , '', $sql);
	$data = preg_split('/' . preg_quote($delimiter, '/') . '$/m', $sql);

	$data = array_map('trim', $data);

	// The empty case
	$end_data = end($data);

	if (empty($end_data))
	{
		unset($data[key($data)]);
	}

	return $data;
}

/**
* For replacing {L_*} strings with preg_replace_callback
*/
function adjust_language_keys_callback($matches)
{
	if (!empty($matches[1]))
	{
		global $lang, $db;

		return (!empty($lang[$matches[1]])) ? $db->sql_escape($lang[$matches[1]]) : $db->sql_escape($matches[1]);
	}
}

function install_die($message, $debuginfo = false)
{
	global $mx_root_path, $phpEx, $template, $lang;

	$message = '<table cellpadding="20" cellspacing="0" border="1" style="margin:30px 80px 30px 80px;">'.
		'<tr><td class="row1"><span class="gen"><b>' . $lang['Installation_error'] . ':</b><br /><br />' . $message . '</span>';
	if( is_array($debuginfo) )
	{
		$message .= '<hr /><table cellpadding="2" cellspacing="0" border="0">
			<tr><td colspan="2"><span class="genmed"><b>' . $lang['Debug_Information'] . ':</b><br />&nbsp;</span></td></tr>';
		for( $i=0; $i < count($debuginfo); $i++ )
		{
			$info_field = ( !empty($debuginfo[$i][0]) ? (str_replace(' ', '&nbsp;', $debuginfo[$i][0]).':') : '' );
			$message .= '<tr><td><span class="genmed">'.$info_field.'&nbsp;</span></td>'.
				'<td><span class="genmed" style="color:blue;">'.$debuginfo[$i][1].'</span></td></tr>';
		}
		$message .= '</table>';
	}
	$message .= '</td></tr></table>';

	if( headers_sent() )
	{
		echo $message;
	}
	else
	{
		include_once($mx_root_path . "install/includes/template.$phpEx");
		$template = new Template($mx_root_path . 'install/templates');
		page_header_install($lang['Installation_error'], $message);
	}
	page_footer_install();
}

/*
*
* Pick a language, any language...
*/
function install_language_select(&$lang_select, $default, $select_name = 'language', $dirname = 'language')
{
	global $mx_root_path;

	$dir = @opendir($mx_root_path . $dirname);
	$lang = array();
	while ( $file = @readdir($dir) )
	{
		if ( ereg("^lang_", $file) && !@is_file($dirname . '/' . $file) && !@is_link($dirname . '/' . $file) )
		{
			$filename = trim(str_replace('lang_', '', $file));
			$displayname = preg_replace("/^(.*?)_(.*)$/", "\\1 [ \\2 ]", $filename);
			$displayname = preg_replace("/\[(.*?)_(.*)\]/", "[ \\1 - \\2 ]", $displayname);
			$lang[$displayname] = $filename;
		}
	}
	@closedir($dir);
	@asort($lang);
	@reset($lang);

	$lang_select = '<select name="' . $select_name . '">';
	while ( list($displayname, $filename) = @each($lang) )
	{
		$selected = ( strtolower($default) == strtolower($filename) ) ? ' selected="selected"' : '';
		$lang_select .= '<option value="' . $filename . '"' . $selected . '>' . ucwords($displayname) . '</option>';
	}
	$lang_select .= '</select>';

	return count($lang);
}

// Guess an initial language ... borrowed from phpBB 2.2 it's not perfect,
// really it should do a straight match first pass and then try a "fuzzy"
// match on a second pass instead of a straight "fuzzy" match.
function guess_lang()
{
	global $mx_root_path;

	// The order here _is_ important, at least for major_minor
	// matches. Don't go moving these around without checking with
	// me first - psoTFX
	$match_lang = array(
		'arabic'					=> 'ar([_-][a-z]+)?',
		'bulgarian'					=> 'bg',
		'catalan'					=> 'ca',
		'czech'						=> 'cs',
		'danish'					=> 'da',
		'german'					=> 'de([_-][a-z]+)?',
		'english'					=> 'en([_-][a-z]+)?',
		'estonian'					=> 'et',
		'finnish'					=> 'fi',
		'french'					=> 'fr([_-][a-z]+)?',
		'greek'						=> 'el',
		'spanish_argentina'			=> 'es[_-]ar',
		'spanish'					=> 'es([_-][a-z]+)?',
		'gaelic'					=> 'gd',
		'galego'					=> 'gl',
		'gujarati'					=> 'gu',
		'hebrew'					=> 'he',
		'hindi'						=> 'hi',
		'croatian'					=> 'hr',
		'hungarian'					=> 'hu',
		'icelandic'					=> 'is',
		'indonesian'				=> 'id([_-][a-z]+)?',
		'italian'					=> 'it([_-][a-z]+)?',
		'japanese'					=> 'ja([_-][a-z]+)?',
		'korean'					=> 'ko([_-][a-z]+)?',
		'latvian'					=> 'lv',
		'lithuanian'				=> 'lt',
		'macedonian'				=> 'mk',
		'dutch'						=> 'nl([_-][a-z]+)?',
		'norwegian'					=> 'no',
		'punjabi'					=> 'pa',
		'polish'					=> 'pl',
		'portuguese_brazil'			=> 'pt[_-]br',
		'portuguese'				=> 'pt([_-][a-z]+)?',
		'romanian'					=> 'ro([_-][a-z]+)?',
		'russian'					=> 'ru([_-][a-z]+)?',
		'slovenian'					=> 'sl([_-][a-z]+)?',
		'albanian'					=> 'sq',
		'serbian'					=> 'sr([_-][a-z]+)?',
		'slovak'					=> 'sv([_-][a-z]+)?',
		'swedish'					=> 'sv([_-][a-z]+)?',
		'thai'						=> 'th([_-][a-z]+)?',
		'turkish'					=> 'tr([_-][a-z]+)?',
		'ukranian'					=> 'uk([_-][a-z]+)?',
		'urdu'						=> 'ur',
		'viatnamese'				=> 'vi',
		'chinese_traditional_taiwan'=> 'zh[_-]tw',
		'chinese_simplified'		=> 'zh',
	);

	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
	{
		$accept_lang_ary = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		for ($i = 0; $i < sizeof($accept_lang_ary); $i++)
		{
			@reset($match_lang);
			while (list($lang, $match) = each($match_lang))
			{
				if (preg_match('#' . $match . '#i', trim($accept_lang_ary[$i])))
				{
					if (@file_exists($mx_root_path . 'language/lang_' . $lang))
					{
						return $lang;
					}
				}
			}
		}
	}
	return 'english';
}


//
// Findind phpBB in the current web server...
//
function mx_scandir($directory, $sorting_order = 0 /*resource context not implemented here*/)
{
	if( !is_dir($directory) ) return false;
	$files = array();
	$handle = @opendir($directory);
	while( ($file = @readdir($handle)) !== false )	// Yep! !== requires 4.0.0-RC2 or greater!
	{
		$files[] = $file;
	}
	@closedir($handle);

	$sort_func = ( $sorting_order ? 'rsort' : 'sort' );
	$sort_func($files);

	return $files;
}

function _whereis($cwd, $pattern, $max_levels = 3 /*for internal use only !!! --->*/, $cur_level = 1)
{
	static $dirs;
	if( $cur_level <= 1 )
	{
		$dirs = array();
	}

	if( substr($cwd, -1) != '/' ) $cwd .= '/';

	$tmpary = @mx_scandir($cwd);
	$tmpcnt = count($tmpary);

	for( $i = 0; $i < $tmpcnt; $i++ )
	{
		if( $tmpary[$i] == '.' || $tmpary[$i] == '..' ) continue;
		$fullname = $cwd.$tmpary[$i];
		if( @is_dir($fullname) )
		{
			if( $cur_level < $max_levels )
			{
				_whereis($fullname, $pattern, $max_levels, $cur_level+1, true);
			}
		}
		else
		{
			if( preg_match($pattern, basename($fullname)) )
			{
				$dirs[] = dirname($fullname);
			}
		}
	}
	return $dirs;
}

function find_phpbb($basedir, $max_levels = 3)
{
	global $phpEx;

	$basedir_length = strlen($basedir) + ( substr($basedir, -1) == '/' ? 0 : 1 );

	//
	// From the document_root scan up to specified level of dirs
	// searching for files named config.* (regexp)
	//
	$tmpary = _whereis($basedir, "/^config\\.$phpEx/", $max_levels);

	//
	// Now, let's see if we can find well known phpBB files...
	// Note: ALL elements must exist!
	//
	$phpbb_files = array(
		"common.$phpEx",
		"faq.$phpEx",
		"posting.$phpEx",
		"search.$phpEx",
		"viewonline.$phpEx",
		"viewtopic.$phpEx",
		"includes/template.$phpEx",
	);
	$phpbb_dirs = array();
	for( $i = 0; $i < count($tmpary); $i++ )
	{
		$is_phpbb_dir = true;
		for( $j = 0; $j < count($phpbb_files); $j++ )
		{
			$fullname = $tmpary[$i] . '/' . $phpbb_files[$j];
			if( !@is_file($fullname) )
			{
				$is_phpbb_dir = false;
				break;
			}
		}
		if( $is_phpbb_dir && is_phpbb_installed($tmpary[$i] . "/config.$phpEx") )
		{
			$phpbb_dirs[] = substr($tmpary[$i], $basedir_length);
		}
	}

	return $phpbb_dirs;
}

function is_phpbb_installed($config)
{
	@include($config);
	return ( !empty($dbhost) && !empty($dbname) && !empty($dbuser) );
}

function get_phpbb_info($config)
{

	if ((@include $config) === false)
	{
		install_die(GENERAL_ERROR, 'Configuration file ' . $config . ' couldn\'t be opened.');
	}
	
	// If we are on PHP < 5.0.0 we need to force include or we get a blank page
	if (version_compare(PHP_VERSION, '5.0.0', '<')) 
	{		
		$dbms = str_replace('mysqli', 'mysql4', $dbms); //this version of php does not have mysqli extension and my crash the installer if finds a forum using this		
	}	

	return array(
		'dbms'			=> $dbms,
		'dbhost'		=> $dbhost,
		'dbname'		=> $dbname,
		'dbuser'		=> $dbuser,
		'dbpasswd'		=> $dbpasswd,
		'table_prefix'	=> $table_prefix,
		'acm_type'		=> $acm_type ? $acm_type : '',
		'status'		=> defined('PHPBB_INSTALLED') ? true : false,		
	);
}

function get_mxbb_info($config)
{

	if ((@include $config) === false)
	{
		install_die(GENERAL_ERROR, 'Configuration file ' . $config . ' couldn\'t be opened.');
	}
	
	return array(
		'dbms'			=> $dbms,
		'dbhost'		=> $dbhost,
		'dbname'		=> $dbname,
		'dbuser'		=> $dbuser,
		'dbpasswd'		=> $dbpasswd,
		'mx_table_prefix'		=> $mx_table_prefix,
		'status'		=> (defined('MX_INSTALLED') && (MX_INSTALLED === true)) ? true : false,
	);
}


//
// Get the full phpBB URL by reading its config table.
//
function get_phpbb_url($table_prefix, $portal_backend)
{
	global $mx_root_path, $phpEx, $db;
	
	$were_sql = ($portal_backend === 'phpbb3') ? 'WHERE is_dynamic = 1' : '';
	
	$sql = 'SELECT config_name, config_value
		FROM ' . $table_prefix . 'config' . $were_sql;
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$board_config[$row['config_name']] = $row['config_value'];
	}
	$db->sql_freeresult($result);
	
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? $script_name : '/' . $script_name;

	return $server_protocol . $server_name . $server_port . $script_name . '/';
}

//
// Connecting to a phpBB Database.
//
function open_phpbb_db(&$db, &$phpbb_info)
{
	global $mx_root_path, $phpEx;
	
	if( !defined('BEGIN_TRANSACTION') )
	{
		define('BEGIN_TRANSACTION', 1);
		define('END_TRANSACTION', 2);
	}

	$dbhost = $phpbb_info['dbhost'];
	$dbuser = $phpbb_info['dbuser'];
	$dbpasswd = $phpbb_info['dbpasswd'];
	$dbname = $phpbb_info['dbname'];

	$dbms = $phpbb_info['dbms'];
	
	// If we are on PHP < 5.0.0 we need to force include or we get a blank page
	if (version_compare(PHP_VERSION, '5.0.0', '<')) 
	{		
		$dbms = str_replace('mysqli', 'mysql4', $dbms); //this version of php does not have mysqli extension and my crash the installer if finds a forum using this		
	}
	
	// Load dbal and initiate class
	//Apache 2.0.x and php < 5.2.5 combination will crash here this is fixed by upgrading to php 5.2.6 or Apache 2.2.x
	require_once($mx_root_path . 'includes/db/' . $dbms . '.' . $phpEx);
	
	if(!$db->db_connect_id)
	{
		// Connect to DB
		@define('SQL_LAYER', $dbms);
		$sql_db = 'dbal_' . $dbms;
			
		$db	= new $sql_db();
			
		if(!is_object($db))
		{
			print("Could not load class " . $db . '<br />');
		}

		if(!$db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, false))
		{
			print("Could not connect to all databases");
		}
	}	
	
	return $db->db_connect_id;
	
}


/*
* Compute the Relative Path from dir A to dir B
* Both MUST be absolute or relative to the same parent.
*/
function get_relative_path($dir_a, $dir_b)
{
	$ary_a = explode('/', trim($dir_a, '/'));
	$ary_b = explode('/', trim($dir_b, '/'));
	if( empty($ary_a[0]) ) unset($ary_a[0]);
	if( empty($ary_b[0]) ) unset($ary_b[0]);
	for( $i=0; $i < count($ary_a); $i++ )
	{
		if( isset($ary_b[$i]) && $ary_a[$i] == $ary_b[$i] )
		{
			unset($ary_a[$i], $ary_b[$i]);
			continue;
		}
		break;
	}
	return str_repeat('../', count($ary_a)) . implode('/', $ary_b) . ( count($ary_b) > 0 ? '/' : '' );
}


/*
* Hey, I also wanted to create my own custom phpinfo
* based on subSilver CSS classes :-)
*/
function show_phpinfo()
{
	global $template, $mx_root_path, $phpEx, $tplEx;

	//
	// Capture the phpInfo output
	//
	ob_start();
	phpinfo();
	$output = ob_get_contents();
	ob_end_clean();

	//
	// Extract the BODY part.
	//
	preg_match_all('#<body[^>]*>(.*)</body>#siU', $output, $body_part);
	$body_part = $body_part[1][0];

	//
	// Remove all, but some HTML Tags.
	//
	$allowedTags = '<h1><h2><h3><hr><ul><ol><li><b><i><u>'.
		'<a><pre><blockquote><img><div><span><p><br>'.
		'<table><tr><td><th><thead><tbody><tfoot>';
	$body_part = strip_tags($body_part, $allowedTags);

	//
	// Alter some CSS related attributes.
	//
	$body_part = preg_replace('# (style|class)=["\'](.*?)["\']#si', '', $body_part);
	$body_part = preg_replace('#<hr(.*?)>#si', '<hr size="1" width="600" />', $body_part);
	$body_part = preg_replace('#<img(.*?)>#si', '<img style="float:right; border:0px;"\1>', $body_part);
	$body_part = preg_replace('#<td(.*?)>(.*?)</td>#si', '<td\1><span class="genmed">\2</span></td>', $body_part);
	$body_part = preg_replace('#cellpadding="(.*?)"#si', 'cellpadding="2"', $body_part);
	$body_part = preg_replace('#cellspacing="(.*?)"#si', '', $body_part);
	$body_part = preg_replace('#<table(.*?)>#si', '<table\1 cellspacing="1" class="forumline">', $body_part);
	$body_part = preg_replace('#<td(.*?)>#si', '<td\1 class="row1">', $body_part);
	$body_part = preg_replace('#<td(.*?)class="row1">#si', '<td\1class="row2">', $body_part);

	//
	// Send the result to the browser.
	//
	include_once($mx_root_path . "install/includes/template.$phpEx");
	$template = new Template($mx_root_path . 'install/templates');
	page_header_install('phpInfo()');
	$template->set_filenames(array('phpinfo' => 'mx_install_phpinfo.'.$tplEx));
	$template->assign_vars(array('PHPINFO' => $body_part));
	$template->pparse('phpinfo');
	page_footer_install(false);
}


/*
*
* Build the array of upgrade schemas required for the target system
*/
function get_upgrade_schemas()
{
	global $db, $mx_root_path, $phpEx, $mx_table_prefix;

	$schemas = array();

	//
	// This is a special case, when migrating from really old portal versions.
	// TODO: Should we maintain compatibility with them? =:-o
	//
	if( $db->sql_query("SELECT * FROM ${mx_table_prefix}welcome_msg") )
	{
		$schemas[] = 'upgrade_to_2.7.0';
	}

	//
	// We externalize the $upgrade_schemas_map array, in the hope to
	// make it easier to maintain. ;-)
	//
	include($mx_root_path . "install/schemas/upgrade_schemas_map.$phpEx");

	$upgrade_from_here = false;

	foreach( $upgrade_schemas_map as $upgrade_map )
	{
		if( !$upgrade_from_here )
		{
			//
			// Ok, build the SQL statement
			//
			$sql = preg_replace('/mx_table_/', $mx_table_prefix, $upgrade_map['sql']);
			//
			// If it works, we know the target system has been upgraded
			// to this particular level, so we skip to the next check.
			//
			if( $db->sql_query($sql) )
			{
				continue;
			}
			$upgrade_from_here = true;
		}
		$schemas[] = $upgrade_map['schema'];
	}
	return $schemas;
}

/*
*
* Commands Processor (very simple parser, but still useful)
*/
function mx_remove_remarks(&$sql)
{
	return preg_replace('/(\n){2,}/', "\n", preg_replace('/^#.*/m', "\n", $sql));
}
function mx_remove_comments(&$sql)
{
	return preg_replace('/(\n){2,}/', "\n", preg_replace('/^--.*/m', "\n", $sql));
}

/*
*
* Commands Processor (very simple parser, but still useful)
*/
function parse_schema($schema)
{
	global $dbms, $available_dbms, $mx_table_prefix;

	$remove_remarks = $available_dbms[$dbms]['COMMENTS'];
	$delimiter = $available_dbms[$dbms]['DELIM'];
	$delimiter_basic = $available_dbms[$dbms]['DELIM_BASIC'];

	//
	// Read the schemas file and build an array of statements
	//
	$commands_ary = @file_get_contents($schema);
	$commands_ary = encode_serialized_data($commands_ary);
	$commands_ary = preg_replace('/mx_table_/', $mx_table_prefix, $commands_ary);
	$commands_ary = $remove_remarks($commands_ary);
	$commands_ary = split_sql_file($commands_ary, $delimiter);
	$commands_cnt = count($commands_ary);


	//
	// Let's process the statements
	//
	for( $i=0; $i < $commands_cnt; $i++ )
	{
		$command = trim($commands_ary[$i]);
		if( !empty($command) )
		{
			//
			// Select the function to deal with the current command.
			//
			// Commands supported: SQL statements and SET (see format below).
			//
			$command = decode_serialized_data($command);
			$parse_command = ( preg_match('#^set[\s]+[a-z][a-z0-9_\.]+#i', $command) ? 'parse_cmd_set' : 'parse_cmd_sql' );
			//
			// Let's execute this command (before we'll convert any variable stored by any previous SET command)
			//

			$parse_command(convert_setvars($command, true));
		}
	}
}

/*
*
* Encode/decode serialized data
*/
function encode_serialized_data($command)
{
	$command = str_replace(';i:', '::i::', $command);
	$command = str_replace(';s:', '::s::', $command);
	$command = str_replace(';}', '::end::', $command);

	return $command;
}

function decode_serialized_data($command)
{
	$command = str_replace('::i::', ';i:',  $command);
	$command = str_replace('::s::', ';s:',  $command);
	$command = str_replace('::end::',';}',  $command);

	return $command;
}

/*
* Command: SET name = SELECT ...;
*
* Note: 'name' must be alphanumeric and begin with a letter.
*/
function parse_cmd_set($cmd)
{
	global $process_msgs, $process_vars;

	$process_msgs[] = '<span style="color:green;">'.$cmd.';</span>';

	//
	// Try to get the SET variable name and the SELECT statement.
	//
	if( !preg_match_all('#^set\s+([a-z][a-z0-9_\.]+)\s*=\s*(.*?)$#i', $cmd, $matches) )
	{
		$process_msgs[] = format_error('Unknown Command');
		return false;
	}

	//
	// The following assignments provided for readability ;-)
	//
	$setvar = $matches[1][0];
	$expression = $matches[2][0];

	//
	// Expression could be an equation or a SELECT statement
	//
	if( preg_match('#^SELECT #i', $expression) )
	{
		if( !($result = parse_cmd_sql($expression)) )
		{
			//$process_vars[$setvar] = '';
			return false;
		}
	}
	else
	{
		//
		// If it's an equation, we first evaluate the result.
		//
		$expression = convert_setvars($expression, false);
		eval('$result = ' . $expression . ';');
		$process_msgs[] = '<span style="color:#888888;">SET '.$setvar.' = '.$result.' = '.$expression.';</span>';
		//
		// Then we have an additional step to deal with setvars in the form of 'name.xxx' which is
		// what SELECT statements return (ie. an array of values, the row). So, we might this kind
		// of setvars in the left side.
		//
		if( strpos($setvar, '.') !== false )
		{
			$names = explode('.', $setvar);
			$setvar = $names[0];
			$result = array($names[1] => $result);
		}
	}
	//
	// Save the data for later use (see convert_setvars function)
	//
	$process_vars[$setvar] = $result;
	return true;
}

function convert_setvars($cmd, $curly_braced)
{
	global $process_vars;

	$curly_braces = ( $curly_braced ? array('{','}') : array('','') );

	foreach( $process_vars as $setvar => $row )
	{
		if( is_array($row) )
		{
			foreach( $row as $varkey => $value )
			{
				$cmd = preg_replace('#'.$curly_braces[0].$setvar.'\.'.$varkey.$curly_braces[1].'#', $value, $cmd);
			}
		}
		else
		{
			$cmd = preg_replace('#'.$curly_braces[0].$setvar.$curly_braces[1].'#', $row, $cmd);
		}
	}
	return $cmd;
}

/*
*
* Command: Execute SQL statements.
*/
function parse_cmd_sql($sql)
{
	global $db, $process_msgs;

	$process_msgs[] = '<span style="color:blue;">'.$sql.';</span>';

	if( !($result = $db->sql_query($sql)) )
	{
		$error = $db->sql_error();
		$process_msgs[] = format_error($error['code'] . ' ' . $error['message']);
		return false;
	}
	//
	// If it's a SELECT statement, we'll try to retrieve the row
	//
	if( preg_match('#^SELECT #i', $sql) )
	{
		if( !($row = $db->sql_fetchrow($result)) )
		{
			$error = $db->sql_error();
			$process_msgs[] = format_error($error['code'] . ' ' . $error['message']);
			return false;
		}
		return $row;
	}
	return true;
}

/**
 * Generate Output
 *
 * @access public
 * @param unknown_type $sql
 * @param unknown_type $main_install
 * @return unknown
 */
function mx_install_cmd_sql( $sql = '', $main_install = false )
{
	global $table_prefix, $mx_table_prefix, $db;

	$inst_error = false;
	$n = 0;
	$message = "<b>" . "list_of_queries" . "</b><br /><br />";

	while ( $sql[$n] )
	{
		if ( !$result = $db->sql_query( $sql[$n] ) )
		{
			$message .= '<b><font color=#FF0000>[' . "already_added" . ']</font></b> line: ' . ( $n + 1 ) . ' , ' . $sql[$n] . '<br />';
			$inst_error = true;
		}
		else
		{
			$message .= '<b><font color=#0000fF>[' .  'added_upgraded' . ']</font></b> line: ' . ( $n + 1 ) . ' , ' . $sql[$n] . '<br />';
		}
		$n++;
	}
	$message .= '<br /> ' . 'upgrading';

	return $message;
}


/*
*
* Post Process populates the basic portal settings into database
*/
function exec_post_process($mode, $upgrade_mode)
{
	global $mx_portal_name, $mx_portal_version, $tplEx, $db, $table_prefix;
	global $language, $board_email, $script_path, $server_port, $server_name, $portal_backend, $phpbb_path;
	global $mx_root_path, $phpbb_root_path;
	global $admin_name, $admin_pass1;
	global $portal_backend;

	if( $mode == 'install' )
	{
		$portal_table = array(
			'portal_id'			=> 1,
			'portal_name'		=> "'$mx_portal_name'",
			'portal_version'	=> "'$mx_portal_version'",
			'portal_startdate'	=> "'".time()."'",
			'default_lang'		=> "'$language'",
			'board_email'		=> "'$board_email'",
			'script_path'		=> "'$script_path'",
			'server_port'		=> "'$server_port'",
			'server_name'		=> "'$server_name'",
			'portal_backend'	=> "'$portal_backend'",
			'portal_backend_path'	=> "'$phpbb_path'",
		);

		if ($_POST['mxbb']) // Internal install
		{
			$portal_table['default_style'] = "'1'";
			$portal_table['default_admin_style'] = "'3'";
		}
		else if (!$_POST['mxbb'] && $portal_backend = 'phpbb2') // phpBB2 install
		{
			$portal_table['default_style'] = "'4'";
			$portal_table['default_admin_style'] = "'4'";
		}
		else
		{
			$portal_table['default_style'] = "'6'";
			$portal_table['default_admin_style'] = "'5'";
		}

		$sql = "INSERT INTO ".PORTAL_TABLE." (".
			implode(', ', array_keys($portal_table)).
			") VALUES (".
			implode(', ', array_values($portal_table)).
			")";

		parse_cmd_sql($sql);

		$admin_pass_md5 = md5($admin_pass1);

		$sql = "UPDATE " . USERS_TABLE . "
			SET username = '" . str_replace("\'", "''", $admin_name) . "', user_password='" . str_replace("\'", "''", $admin_pass_md5) . "'
			WHERE username = 'admin'";

		parse_cmd_sql($sql);

		$sql = "UPDATE " . USERS_TABLE . "
			SET user_regdate = " . time();

		parse_cmd_sql($sql);

		if (!$_POST['mxbb'] && $portal_backend == 'phpbb2') // phpBB2 install
		{
			$sql_phpbb = "SELECT * FROM ".$table_prefix."users WHERE user_level = 1";

			if( !($result = $db->sql_query($sql_phpbb)) )
			{
				return false;
			}
			$user_id = 2; // Add ontop admin user...
			while( $row = $db->sql_fetchrow($result) )
			{
				$user_id++;
				$sql = "INSERT INTO " . USERS_TABLE . "
					(user_id, username, user_password, user_email, user_level, user_regdate, user_active)
					VALUES ('" . $user_id . "', '" . $row['username'] . "', '" . $row['user_password'] . "', '" . $row['user_email'] . "', '" . $row['user_level'] . "', '" . time() . "', '1')";

					parse_cmd_sql($sql);
			}
		}		
	}
	else
	{
		$sql = "UPDATE ".PORTAL_TABLE."
			SET portal_name='$mx_portal_name',
			portal_version='$mx_portal_version'";

		if ($upgrade_mode == 'from28x')
		{
			//
			// Get data from phpBB2 -> CORE
			//
			$sql_phpbb = "SELECT * FROM ".$table_prefix."config";
			if( !($result = $db->sql_query($sql_phpbb)) )
			{
				return false;
			}
			while( $row = $db->sql_fetchrow($result) )
			{
				$board_config[$row['config_name']] = $row['config_value'];
			}

			$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://'; // Fix for Olympus

			$phpbb_backend_path = str_replace($mx_root_path, '', $phpbb_root_path); // Read from old config.php

			$sql .= ", portal_startdate = '".$board_config['board_startdate']."',

				default_style = '".$board_config['default_style']."',
				override_user_style = '".$board_config['override_user_style']."',
				default_lang = '".$board_config['default_lang']."',

				allow_html = '".$board_config['allow_html']."',
				allow_html_tags = '".$board_config['allow_html_tags']."',
				allow_bbcode = '".$board_config['allow_bbcode']."',
				allow_smilies = '".$board_config['allow_smilies']."',
				smilies_path = '".$board_config['smilies_path']."',

				board_email = '".$board_config['board_email']."',
				board_email_sig = '".$board_config['board_email_sig']."',
				smtp_delivery = '".$board_config['smtp_delivery']."',
				smtp_host = '".$board_config['smtp_host']."',
				smtp_username = '".$board_config['smtp_username']."',
				smtp_password = '".$board_config['smtp_password']."',
				smtp_auth_method = '".$board_config['smtp_auth_method']."',

				default_dateformat = '".$board_config['default_dateformat']."',
				board_timezone = '".$board_config['board_timezone']."',
				gzip_compress = '".$board_config['gzip_compress']."',

				script_path	= '".$script_path."',
				server_port	= '".$board_config['server_port']."',
				script_protocol	= '".$server_protocol."',
				server_name	= '".$board_config['server_name']."',
				portal_backend = 'phpbb2',
				portal_backend_path	= '$phpbb_backend_path'";
		}

		$sql .= " WHERE portal_id = 1";

		parse_cmd_sql($sql);

		if ($upgrade_mode == 'from28x')
		{
			//
			// Get admins from phpBB2 -> CORE
			//
			$sql = "DELETE FROM " . USERS_TABLE . "
						WHERE username = 'Admin'";

			parse_cmd_sql($sql);

			$sql_phpbb = "SELECT * FROM ".$table_prefix."users WHERE user_level = 1";

			if( !($result = $db->sql_query($sql_phpbb)) )
			{
				return false;
			}
			$user_id = 2; // Add ontop admin user...
			while( $row = $db->sql_fetchrow($result) )
			{
				$user_id++;
				$sql = "INSERT INTO " . USERS_TABLE . "
					(user_id, username, user_password, user_email, user_level, user_regdate, user_active)
					VALUES ('" . $user_id . "', '" . $row['username'] . "', '" . $row['user_password'] . "', '" . $row['user_email'] . "', '" . $row['user_level'] . "', '" . time() . "', '1')";

					parse_cmd_sql($sql);
			}
		}
	}
}

function format_error($message)
{
	global $process_errors;
	$process_errors++;
	$message = '<b><span style="color:orange;">Warning:</span> ' . $message . '</b>';
	return $message;
}
//
// FYI: This is our easy workaround to the PHP realpath function, which might be disabled
// on some servers (Lycos and maybe others) ...they say it's for "security" reasons, heh.
//
// When the PHP realpath function is disabled it returns false and generates a message like:
//
// Warning: realpath (and maybe other functions) has been disabled for security reasons in
// path-to-your/install/mx_install.php on line XXX
//
// This "security" measure seems somehow stupid since information of the filesystem layout
// can be easily retrieved from PHP (and Apache) global variables ...as well as from the
// same PHP generated warning message! :P
//
// Just wanted to mention I already saw the phpBB guys also created their own phpbb_realpath
// function (in includes/functions.php). I never understood why they did it. Only if they
// had documented the correct reason in their source code. ;-)
//
function mx_realpath($path)
{
	return ( @function_exists('realpath') && @realpath(__FILE__) ? realpath($path) : $path );
}

?>