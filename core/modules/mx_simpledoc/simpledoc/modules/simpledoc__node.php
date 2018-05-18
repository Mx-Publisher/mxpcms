<?php
// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | node.php                                                           |
// | Execute tree actions.                                              |
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

$do = get('do');
$id = $mx_simpledoc->unicode_urldecode($mx_simpledoc_functions->fix_charset(get('id')));
$name = $mx_simpledoc->unicode_urldecode($mx_simpledoc_functions->fix_charset(get('name')));
$is_folder = get('is_folder');

switch ($do)
{
    case 'moveUp':
    case 'moveDown':
    case 'moveLeft':
    case 'moveRight':
    case 'insert':
    case 'insertBefore':
    case 'insertAfter':
    case 'insertInsideAtStart':
    case 'insertInsideAtEnd':
    case 'rename':
    case 'remove':
        $Node = new Node($id);
        break;
}

switch ($do)
{
    case 'moveUp':
        $Node->moveUp();
        break;

    case 'moveDown':
        $Node->moveDown();
        break;

    case 'moveLeft':
        $Node->moveLeft();
        break;

    case 'moveRight':
        $Node->moveRight();
        break;

    case 'insert':
        $Node->insert($name, $is_folder);
        break;

    case 'insertBefore':
        $Node->insertBefore($name, $is_folder);
        break;

    case 'insertAfter':
        $Node->insertAfter($name, $is_folder);
        break;

    case 'insertInsideAtStart':
        $Node->insertInsideAtStart($name, $is_folder);
        break;

    case 'insertInsideAtEnd':
        $Node->insertInsideAtEnd($name, $is_folder);
        break;

    case 'rename':
        $Node->rename($name, $is_folder);
        break;

    case 'remove':
        $Node->remove();
        break;

    default:
        trigger_error("node.php failed, unknown action: '$do' (query_string={$_SERVER['QUERY_STRING']})", E_USER_ERROR);
        break;
}

?>