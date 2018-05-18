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

$html = IoFile::read($path);

/*
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
*/
?>
<!--
<form name="simpleform" action="./modules/mx_simpledoc/simpledoc/modules/simpledoc__tab-save-content.php" method="post" onSubmit="ste.submit(); saveContent(this); this.blur();return false;">
	<input type="hidden" id="id" name="id" value="<?php echo get('id'); ?>">
	<input type="hidden" id="block_id" name="block_id" value="<?php echo $block_id; ?>">
	<input type="hidden" id="page_id" name="page_id" value="<?php echo $page_id; ?>">
	<textarea id="body" name="body" cols="60" rows="10"><?php echo htmlspecialchars($html); ?></textarea>
	<p><input id="save-document"type="submit" value="Save Document"> (ctrl+s)</p>
    <input type="hidden" id="body-tmp" name="body-tmp" value="<?php echo htmlspecialchars($html); ?>">
</form>
-->
<form action="javascript:void(0)" method="post">
    <textarea id="body" name="body" cols="100" rows="40"><?php echo $html; ?></textarea>
    <p><input id="save-document" type="button" value="Save Document" onclick="saveContent(); this.blur();"> (ctrl+s)</p>
    <!--<input type="hidden" id="body-tmp" name="body-tmp" value="<?php echo trim($html); ?>">-->
</form>

<p id="saved"></p>