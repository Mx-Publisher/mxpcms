<?php
// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | tab-document-info.php                                              |
// | Returns document info in html format.                              |
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
if ( !( ( $mx_block->auth_view && $mx_block->auth_edit && $mx_block->show_block ) || $mx_block->auth_mod ) )
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

$created = IoFile::getCreationTime($path);
$modified = IoFile::getLastWriteTime($path);
$size = IoFile::getSize($path);

$html = IoFile::read($path);
$text = strip_tags($html);
$words = str_word_count($text);

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

<table cellspacing="1" cellpadding="0" class="t0">
<tr>
    <td class="t1">Path</td>
    <td class="t2"><?php echo htmlspecialchars($id); ?></td>
</tr>
<tr>
    <td class="t1">Bytes</td>
    <td class="t2"><?php echo $size; ?></td>
</tr>
<tr>
    <td class="t1">Words</td>
    <td class="t2"><?php echo $words; ?></td>
</tr>
<tr>
    <td class="t1">Created</td>
    <td class="t2"><?php echo substr($created, 0, -3); ?></td>
</tr>
<tr>
    <td class="t1">Modified</td>
    <td class="t2"><?php echo substr($modified, 0, -3); ?></td>
</tr>
</table>

<p><a onclick="this.blur()" href="index.php?page=<?php echo $mx_page->page_id; ?>&mode=export_single&id=<?php echo urlencode($id); ?>">Export as single document</a></p>
