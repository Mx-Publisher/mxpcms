<?php
/**
*
* @package Functions_phpBB3
*
 * @copyright (c) 2002-2008 MX-Publisher Project Team
* @license GNU General Public License, version 2 (GPL-2.0)
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
 * @link http://mxpcms.sourceforge.net/
*
*/

/**
 * @ignore
 */
if (!defined('IN_PORTAL'))
{
	exit;
}

class file_downloader
{
	/** @var string Error string */
	protected $error_string = '';

	/** @var int Error number */
	protected $error_number = 0;

	/**
	 * Retrieve contents from remotely stored file
	 *
	 * @param string	$host			File host
	 * @param string	$directory		Directory file is in
	 * @param string	$filename		Filename of file to retrieve
	 * @param int		$port			Port to connect to; default: 80
	 * @param int		$timeout		Connection timeout in seconds; default: 6
	 *
	 * @return mixed File data as string if file can be read and there is no
	 *			timeout, false if there were errors or the connection timed out
	 *
	 * @throws \phpbb\exception\runtime_exception If data can't be retrieved and no error
	 *		message is returned
	 */
	public function get($host, $directory, $filename, $port = 80, $timeout = 6)
	{
		// Set default values for error variables
		$this->error_number = 0;
		$this->error_string = '';

		if ($socket = @fsockopen(($port == 443 ? 'ssl://' : '') . $host, $port, $this->error_number, $this->error_string, $timeout))
		{
			@fputs($socket, "GET $directory/$filename HTTP/1.0\r\n");
			@fputs($socket, "HOST: $host\r\n");
			@fputs($socket, "Connection: close\r\n\r\n");

			$timer_stop = time() + $timeout;
			stream_set_timeout($socket, $timeout);

			$file_info = '';
			$get_info = false;

			while (!@feof($socket))
			{
				if ($get_info)
				{
					$file_info .= @fread($socket, 1024);
				}
				else
				{
					$line = @fgets($socket, 1024);
					if ($line == "\r\n")
					{
						$get_info = true;
					}
					else if (stripos($line, '404 not found') !== false)
					{
						mx_message_die(GENERAL_MESSAGE, 'FILE_NOT_FOUND', $filename);
					}
				}

				$stream_meta_data = stream_get_meta_data($socket);

				if (!empty($stream_meta_data['timed_out']) || time() >= $timer_stop)
				{
					mx_message_die(GENERAL_MESSAGE, 'FSOCK_TIMEOUT', $filename);
				}
			}
			@fclose($socket);
		}
		else
		{
			if ($this->error_string)
			{
				$this->error_string = utf8_convert_message($this->error_string);
				return false;
			}
			else
			{
				mx_message_die(GENERAL_MESSAGE, 'FSOCK_DISABLED', $filename);
			}
		}

		return $file_info;
	}

	/**
	 * Get error string
	 *
	 * @return string Error string
	 */
	public function get_error_string()
	{
		return $this->error_string;
	}

	/**
	 * Get error number
	 *
	 * @return int Error number
	 */
	public function get_error_number()
	{
		return $this->error_number;
	}
}
