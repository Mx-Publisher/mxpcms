<?php
/**
*
* @package MX-Publisher Module - mx_kb
* @version $Id: simpledoc_common.php,v 1.10 2008/06/03 20:14:14 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

$simpledoc_debug = true;

// ===================================================
// Include pafiledb data file
// ===================================================
include_once( $module_root_path . 'simpledoc/includes/simpledoc_constants.' . $phpEx );
include_once( $module_root_path . 'simpledoc/includes/functions.' . $phpEx );
include_once( $module_root_path . 'simpledoc/includes/functions_cache.' . $phpEx );
include_once( $module_root_path . 'simpledoc/includes/functions_simpledoc.' . $phpEx );

//
// Load a wrapper for common phpBB2 functions (compatibility with core 2.8.x)
//
include_once( $mx_root_path . 'includes/shared/phpbb2/includes/functions.' . $phpEx );

$mx_simpledoc = new mx_simpledoc_public();
$mx_simpledoc_cache = new mx_simpledoc_cache();
$mx_simpledoc_functions = new mx_simpledoc_functions();

//
// Cache
//
/*
if ( $mx_simpledoc_cache->exists( 'config' ) )
{
	$simpledoc_config = $mx_simpledoc_cache->get( 'config' );
}
else
{
	$simpledoc_config = $mx_simpledoc_functions->simpledoc_config();
	$mx_simpledoc_cache->put( 'config', $simpledoc_config );
}
*/

//
// Error reporting
//
//error_reporting(E_ALL);

//
// Includes
//
require( $module_root_path . 'simpledoc/includes/sugolib4.' . $phpEx );

include_once( $module_root_path . 'simpledoc/includes/functions_io.' . $phpEx );
include_once( $module_root_path . 'simpledoc/includes/functions_node.' . $phpEx );

//include_once( $module_root_path . 'config.' . $phpEx );
$CONFIG['encoding'] = 'iso-8859-1';

@ini_set('display_errors', 1);
@ini_set('magic_quotes_runtime', 0);
@ini_set('zend.ze1_compatibility_mode', 1);
set_error_handler('raiseError');

if (ini_get('magic_quotes_gpc')) {
    stripQuotes($_GET);
    stripQuotes($_POST);
    stripQuotes($_REQUEST);
    stripQuotes($_COOKIE);
}

//
// Globals
//
global $CONTENT, $SORT, $CHMOD_FILE, $CHMOD_DIR;

//
// Get Project Name and Flag it it hasn't been set
//
$simpledoc_projectName = $mx_block->get_parameters( 'project_name' );
$simpledoc_projectFolder = $mx_block->get_parameters( 'project_folder' );

if(empty($simpledoc_projectName))
{
	mx_message_die(GENERAL_MESSAGE, 'No Project Name is set for this SimpleDoc. Please go to the admiCP/blockCP panel and fill out a Project Name.');
}

//$CONTENT = $module_root_path . 'simpledoc/data/content';
$CONTENT = $module_root_path . 'simpledoc/data/content/' . $simpledoc_projectFolder;
//$PUBLISH = $module_root_path . 'simpledoc/data/' . $CONFIG['publish_dir'];
$PUBLISH = $module_root_path . 'simpledoc/data/publish/' . $simpledoc_projectFolder;

$SORT = '.sort';
$CHMOD_FILE = 666;
$CHMOD_DIR = 777;

//
// If new Project - create
//
if (!IoDir::exists($PUBLISH))
{
	echo('Creating publish dir');
	IoDir::create($PUBLISH, $CHMOD_DIR);
}

if (!IoDir::exists($CONTENT))
{
	echo('Creating content dir');
	IoDir::create($CONTENT, $CHMOD_DIR);
}

//
// Initialization
//
$error = array();

if (!IoDir::exists($PUBLISH) || !IoDir::isWritable($PUBLISH))
{
    $error[] = $PUBLISH;
}

if (IoDir::exists($CONTENT))
{
    if (!IoDir::isWritable($CONTENT)) $error[] = $CONTENT;
    $all = IoDir::readFull($CONTENT);
    foreach ($all as $v)
    {
        if (IoDir::exists($v))
        {
            if (!IoDir::isWritable($v)) $error[] = $v;
        }
        else
        {
            if (!IoFile::isWritable($v)) $error[] = $v;
        }
    }
    if (count($error) == 0)
    {
        if (!IoFile::exists($CONTENT.'/'.$SORT))
        {
            IoFile::create($CONTENT.'/'.$SORT, $CHMOD_FILE);
        }
    }
}
else
{
    $error[] = $CONTENT;
}

if (count($error) > 0)
{
	foreach($error as $key => $error_str)
	{
		echo('<br> - '.$error_str);
	}
	die('<br><br>Initialization error');
}

?>