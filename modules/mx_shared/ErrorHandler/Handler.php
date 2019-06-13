<?php
/**
* @project mygosuLib
* @package ErrorHandler
* @version 2.0.1
* @license BSD
* @copyright (c) 2003,2004 Cezary Tomczak
* @link http://gosu.pl/software/mygosulib.html
*/
define('ERROR_HANDLER_ROOT', dirname(__FILE__));

/**
* @access public
* @package ErrorHandler
*/
class ErrorHandler 
{

    /**
    * Constructor
    * @access public
    */
    function ErrorHandler() 
	{
        @ini_set('docref_root', null);
        @ini_set('docref_ext', null);
    }

    /**
    * @param int $errNo
    * @param string $errMsg
    * @param string $file
    * @param int $line
    * @return void
    * @access public
    */
    function raiseError($errNo, $errMsg, $file, $line) 
	{
    	global $mx_user;

        if ( !($errNo & error_reporting())) 
		{
            return;
        }

        while (ob_get_level()) 
		{
            ob_end_clean();
        }
		
		// figure out the error level 
		$errType = array(
			0    => "Unknown PHP Error",		
            1    => "Php Error",
            2    => "Php Warning",
            4    => "Parsing Error",
            8    => "Php Notice",
            16   => "Core Error",
            32   => "Core Warning",
            64   => "Compile Error",
            128  => "Compile Warning",
            256  => "Php User Error",
            512  => "Php User Warning",
            1024 => "Php User Notice",
			2048 => 'PHP Strict',			
        );
		
        $info = array();

        if (($errNo & E_USER_ERROR) && is_array($arr = @unserialize($errMsg))) 
		{
            foreach ($arr as $k => $v) 
			{
                $info[$k] = $v;
            }
        }

        $trace = array();

        if (function_exists('debug_backtrace')) 
		{
            $trace = debug_backtrace();
            array_shift($trace);
        }

        include ERROR_HANDLER_ROOT . '/error.tpl';
        exit;
    }
}

?>