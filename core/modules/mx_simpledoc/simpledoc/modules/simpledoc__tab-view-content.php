<?php
// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | tab-edit-content.php                                               |
// | Editing document, wysiwyg editor, saving data, returns html.       |
// +--------------------------------------------------------------------+
// | Author:  Cezary Tomczak [www.gosu.pl]                              |
// | Project: SimpleDoc                                                 |
// | URL:     http://gosu.pl/php/simpledoc.html                         |
// | License: GPL                                                       |
// +--------------------------------------------------------------------+

define( 'IN_PORTAL', 1 );
$mx_root_path = "./../../../../";

$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($mx_root_path . 'common.' . $phpEx);

//
// Page selector
//
$page_id = $mx_request_vars->request('page_id', MX_TYPE_INT, 0);

//
// Start session, user and style (template + theme) management
// - populate $userdata, $lang, $theme, $images and initiate $template.
//
$mx_user->init($user_ip, - ( 1000 + $page_id ));

//
// Load and instatiate page and block classes
//
$mx_page->init( $page_id );
$mx_block = new mx_block();

//
// Block selector
//
$block_id = $mx_request_vars->request('block_id', MX_TYPE_INT, 0);

//
// Instatiate block
//
$mx_block->init( $block_id );

//
// Page Auth and IP filter
//
if ( !$mx_page->auth_view && $userdata['session_logged_in'] )
{
	echo('Not authorized - 1');
	return;
}
elseif ( !$mx_page->auth_view && !$userdata['session_logged_in'] )
{
	echo('Not authorized - 2');
	return;
}
elseif ( !$mx_page->auth_ip )
{
	echo('Not authorized - 3');
	return;
}

//
// Page Auth and IP filter
//
if ( !( ( $mx_block->auth_view && $mx_block->show_block ) || $mx_block->auth_mod ) )
{
	echo('Not authorized - 4');
	return;
}

//
// Define $module_root_path, to be used within blocks
//
$module_root_path = $mx_root_path . $mx_block->module_root_path;

// ===================================================
// Include the common file
// ===================================================
include_once( $module_root_path . 'simpledoc/simpledoc_common.' . $phpEx );

if ($simpledoc_debug)
{
	set_error_handler('myErrorHandler');
}
else
{
	set_error_handler('logError');
	$LOGERROR = 'error.txt';
}

$id = $mx_simpledoc->unicode_urldecode($mx_simpledoc_functions->fix_charset(get('id')));
$path = $CONTENT.'/'.$id;

if (!IoFile::exists($path)) {
    echo "Unknown document: $path";
    exit;
}

$html = IoFile::read($path);
//$html = $mx_bbcode->decode($html,'');

$search = array (
		"'<script[^>]*?>.*?</script>'si",  	// Strip out javascript
		"'<head[^>]*?>.*?</head>'si",  	// Strip out javascript
       //"'([\r\n])[\s]+'",                	// Strip out white space
		"'<br />'i",
		"'<html>'i",
		"'</html>'i",
		"'<body>'i",
		"'</body>'i",
	);
$replace = array (
	 	"",
	 	"",
        //"\\1",
		"",
		"",
		"",
		"",
		"",
	);

$html = preg_replace( $search, $replace, $html );

// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// always modified
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache");

header('Content-type: text/html; charset='.$CONFIG['encoding']);
?>

<?php echo $html; ?>
