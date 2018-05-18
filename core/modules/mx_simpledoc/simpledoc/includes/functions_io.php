<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: functions_io.php,v 1.3 2008/06/03 20:14:11 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | Author:  Cezary Tomczak [www.gosu.pl]                              |
// | Project: SimpleDoc                                                 |
// | URL:     http://gosu.pl/php/simpledoc.html                         |
// | License: GPL                                                       |
// +--------------------------------------------------------------------+

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

// File operations.
// Author: Cezary Tomczak [www.gosu.pl]
// Free for any use as long as all copyright messages are intact.

class IoFile {
    function exists($file) {
        return file_exists($file) && is_file($file);
    }
    function isWritable($file) {
        return is_writable($file);
    }
    function chmod($file, $mode) {
        return chmod($file, octdec('0'.(int)$mode));
    }
    function create($file, $mode = null) {
        if ($fp = fopen($file, 'wb')) {
            fclose($fp);
            if (isset($mode)) {
                chmod($file, octdec('0'.(int)$mode));
            }
        }
    }
    function read($file) {
        if ($fp = fopen($file, 'rb')) {
            $ret = '';
            while ($s = fread($fp, 1024)) {
                $ret .= $s;
            }
            fclose($fp);
            return $ret;
        }
    }
    function write($file, $content) {
        if ($fp = fopen($file, 'wb')) {
            fwrite($fp, $content, strlen($content));
            fclose($fp);
        }
    }
    function append($file, $content) {
        if ($fp = fopen($file, 'ab')) {
            fwrite($fp, $content, strlen($content));
            fclose($fp);
        }
    }
    function rename($file, $new) {
        return rename($file, $new);
    }
    function copy($file, $to, $mode = null) {
        copy($file, $to);
        if ($mode) IoFile::chmod($to, $mode);
    }
    function move($file, $to) {
        return rename($file, $to);
    }
    function delete($file) {
        return unlink($file);
    }
    function getSize($file) {
        return filesize($file);
    }
    function getCreationTime($file) {
        return date('Y-m-d H:i:s', filectime($file));
    }
    function getLastWriteTime($file) {
        return date('Y-m-d H:i:s', filemtime($file));
    }
}

// Directory operations.
// Author: Cezary Tomczak [www.gosu.pl]
// Free for any use as long as all copyright messages are intact.

class IoDir {
    function exists($dir) {
        return file_exists($dir) && is_dir($dir);
    }
    function isWritable($dir) {
        return is_writable($dir);
    }
    function chmod($dir, $mode) {
        return chmod($dir, octdec('0'.(int)$mode));
    }
    function create($dir, $mode = null) {
        if (isset($mode)) {
            $ret = mkdir($dir, octdec('0'.(int)$mode));
        } else {
            $ret = mkdir($dir);
        }
        return $ret;
    }
    function read($dir, $ignore = array()) {
        $ret = array();
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..' && !in_array($file, $ignore)) {
                    $ret[] = $dir.'/'.$file;
                }
            }
            closedir($handle);
        }
        return $ret;
    }
    function readFull($dir) {
        $ret = array();
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') {
                    $ret[] = $dir.'/'.$file;
                    if (is_dir($dir.'/'.$file)) {
                        $ret = array_merge($ret, IoDir::readFull($dir.'/'.$file));
                    }
                }
            }
            closedir($handle);
        }
        return $ret;
    }
    function rename($dir, $new) {
        return rename($dir, $new);
    }
    function copy($dir, $to, $chmod_file = null, $chmod_dir = null) {
        $files = IoDir::readFull($dir);
        if (!IoDir::exists($to)) { IoDir::create($to, $chmod_dir); }
        foreach ($files as $file) {
            $file2 = $to . substr($file, strlen($dir));
            if (IoFile::exists($file)) {
                IoFile::copy($file, $file2, $chmod_file);
            } else if (IoDir::exists($file)) {
                IoDir::create($file2, $chmod_dir);
            }
        }
    }
    function move($dir, $to) {
        return rename($dir, $to);
    }
    function delete($dir, $self = true) {
        $files = IoDir::readFull($dir);
        $files2 = array();
        foreach ($files as $file) {
            $files2[substr_count($file, '/')][] = $file;
        }
        $a = array_keys($files2);
        rsort($a);
        foreach ($a as $level) {
            foreach ($files2[$level] as $file) {
                if (is_file($file)) unlink($file);
                else rmdir($file);
            }
        }
        if ($self) { rmdir($dir); }
    }
}

?>