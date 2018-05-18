<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: functions_cache.php,v 1.4 2008/06/03 20:14:11 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

class mx_simpledoc_cache
{
	var $vars = '';
	var $vars_ts = array();
	var $modified = false;

	function mx_simpledoc_cache()
	{
		global $phpbb_root_path;
		global $mx_root_path, $module_root_path, $is_block, $phpEx;

		$this->cache_dir = $module_root_path . 'simpledoc/cache/';
	}

	function load()
	{
		global $phpEx;
		@include( $this->cache_dir . 'data_global.' . $phpEx );
	}

	function unload()
	{
		$this->save();
		unset( $this->vars );
		unset( $this->vars_ts );
	}

	function save()
	{
		if ( !$this->modified )
		{
			return;
		}

		global $phpEx;
		$file = '<?php $this->vars=' . $this->format_array( $this->vars ) . ";\n\$this->vars_ts=" . $this->format_array( $this->vars_ts ) . ' ?>';

		if ( $fp = @fopen( $this->cache_dir . 'data_global.' . $phpEx, 'wb' ) )
		{
			@flock( $fp, LOCK_EX );
			fwrite( $fp, $file );
			@flock( $fp, LOCK_UN );
			fclose( $fp );
		}
	}

	function tidy( $expire_time = 0 )
	{
		global $phpEx;

		$dir = opendir( $this->cache_dir );
		while ( $entry = readdir( $dir ) )
		{
			if ( $entry{0} == '.' || substr( $entry, 0, 4 ) != 'sql_' )
			{
				continue;
			}

			if ( time() - $expire_time >= filemtime( $this->cache_dir . $entry ) )
			{
				unlink( $this->cache_dir . $entry );
			}
		}

		if ( file_exists( $this->cache_dir . 'data_global.' . $phpEx ) )
		{
			foreach ( $this->vars_ts as $varname => $timestamp )
			{
				if ( time() - $expire_time >= $timestamp )
				{
					$this->destroy( $varname );
				}
			}
		}
		else
		{
			$this->vars = $this->vars_ts = array();
			$this->modified = true;
		}
	}

	function get( $varname, $expire_time = 0 )
	{
		return ( $this->exists( $varname, $expire_time ) ) ? $this->vars[$varname] : null;
	}

	function put( $varname, $var )
	{
		$this->vars[$varname] = $var;
		$this->vars_ts[$varname] = time();
		$this->modified = true;
	}

	function destroy( $varname )
	{
		if ( isset( $this->vars[$varname] ) )
		{
			$this->modified = true;
			unset( $this->vars[$varname] );
			unset( $this->vars_ts[$varname] );
		}
	}

	function exists( $varname, $expire_time = 0 )
	{
		if ( !is_array( $this->vars ) )
		{
			$this->load();
		}

		if ( $expire_time > 0 && isset( $this->vars_ts[$varname] ) )
		{
			if ( $this->vars_ts[$varname] <= time() - $expire_time )
			{
				$this->destroy( $varname );
				return false;
			}
		}

		return isset( $this->vars[$varname] );
	}

	function format_array( $array )
	{
		$lines = array();
		foreach ( $array as $k => $v )
		{
			if ( is_array( $v ) )
			{
				$lines[] = "'$k'=>" . $this->format_array( $v );
			}elseif ( is_int( $v ) )
			{
				$lines[] = "'$k'=>$v";
			}elseif ( is_bool( $v ) )
			{
				$lines[] = "'$k'=>" . ( ( $v ) ? 'TRUE' : 'FALSE' );
			}
			else
			{
				$lines[] = "'$k'=>'" . str_replace( "'", "\'", str_replace( '\\', '\\\\', $v ) ) . "'";
			}
		}
		return 'array(' . implode( ',', $lines ) . ')';
	}
}
?>