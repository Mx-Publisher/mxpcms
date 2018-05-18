<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: functions.php,v 1.3 2008/06/03 20:14:11 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

// =========================================
// This class is used for general simpledoc handling
// =========================================
class mx_simpledoc_functions
{
	function set_config( $config_name, $config_value )
	{
		global $mx_simpledoc_cache, $simpledoc_config, $db, $mx_simpledoc;

		$mx_simpledoc->debug('functions->set_config', basename( __FILE__ ));

		$sql = "UPDATE " . SIMPLEDOC_CONFIG_TABLE . " SET
			config_value = '" . str_replace( "\'", "''", $config_value ) . "'
			WHERE config_name = '$config_name'";

		if ( !$db->sql_query( $sql ) )
		{
			mx_message_die( GENERAL_ERROR, "Failed to update simpledoc configuration for $config_name", "", __LINE__, __FILE__, $sql );
		}

		if ( !$db->sql_affectedrows() && !isset( $simpledoc_config[$config_name] ) )
		{
			$sql = 'INSERT INTO ' . SIMPLEDOC_CONFIG_TABLE . " (config_name, config_value)
				VALUES ('$config_name', '" . str_replace( "\'", "''", $config_value ) . "')";

			if ( !$db->sql_query( $sql ) )
			{
				mx_message_die( GENERAL_ERROR, "Failed to update simpledoc configuration for $config_name", "", __LINE__, __FILE__, $sql );
			}
		}

		$simpledoc_config[$config_name] = $config_value;
		$mx_simpledoc_cache->destroy( 'config' );
	}

	function simpledoc_config()
	{
		global $db, $mx_simpledoc;

		$mx_simpledoc->debug('functions->get config', basename( __FILE__ ));

		$sql = "SELECT *
			FROM " . SIMPLEDOC_CONFIG_TABLE;

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt query simpledoc configuration', '', __LINE__, __FILE__, $sql );
		}

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$simpledoc_config[$row['config_name']] = trim( $row['config_value'] );
		}

		$db->sql_freeresult( $result );

		return ( $simpledoc_config );
	}

	// fix xmlhttprequest charset bug , utf-8 => windows-1250
	function fix_charset($str) {
	    global $CONFIG;
	    if ($CONFIG['encoding'] == 'windows-1250') {
	        $a = array('%u0105', '%u0107', '%u0119', '%u0142', '%u0144', '%u015B', 'ó', '%u017A', '%u017C');
	        $b = array('¹', 'æ', 'ê', '³', 'ñ', 'œ', 'ó', 'Ÿ', '¿');
	        $c = array('%u0104', '%u0106', '%u0118', '%u0141', '%u0143', '%u015A', 'Ó', '%u0179', '%u017B');
	        $d = array('¥', 'Æ', 'Ê', '£', 'Ñ', 'Œ', 'Ó', '?', '¯');
	        $str = str_replace($a, $b, $str);
	        $str = str_replace($c, $d, $str);
	    }
	    return $str;
	}

}

// error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
  	switch ($errno)
  	{
  		case E_USER_ERROR:
   			$Node->error = true;
   			echo "<b>My ERROR</b> [$errno] $errstr\n\n";
		  	echo "Fatal error in line $errline of file $errfile";
		   	echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")\n\n";
		   	echo "Aborting...\n";
		   	exit(1);
   		break;
  		case E_USER_WARNING:
   			echo "<b>My WARNING</b> [$errno] $errstr\n\n";
   		break;
  		case E_USER_NOTICE:
   			echo "<b>My NOTICE</b> [$errno] $errstr\n\n";
   		break;
  		default:
   			// echo "Unknown error type: [$errno] $errstr<br />\n";
   		break;
  	}
}
?>