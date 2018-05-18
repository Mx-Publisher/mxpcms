<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: mx_includex.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */
 
if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];

$iframe_mode = $mx_block->get_parameters( 'x_mode' );

$x_mode = ( $iframe_mode == 'x_listen' && !empty($HTTP_GET_VARS['x_mode']) ? $HTTP_GET_VARS['x_mode'] : $iframe_mode );

$x_1 = ( $iframe_mode == 'x_listen' && !empty($HTTP_GET_VARS['x_1']) ? $HTTP_GET_VARS['x_1'] : $mx_block->get_parameters( 'x_1' ) );
$x_2 = ( $iframe_mode == 'x_listen' && !empty($HTTP_GET_VARS['x_2']) ? $HTTP_GET_VARS['x_2'] : $mx_block->get_parameters( 'x_2' ) );
$x_3 = ( $iframe_mode == 'x_listen' && !empty($HTTP_GET_VARS['x_3']) ? $HTTP_GET_VARS['x_3'] : $mx_block->get_parameters( 'x_3' ) );

//
// Start output of page
//
$template->set_filenames(array(
	'includex_block' => 'mx_includex.tpl')
);

$template->assign_vars(array(
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'L_TITLE' => ( !empty($lang[$title]) ? $lang[$title] : $title )
));
			
switch( $x_mode )
{
	case 'x_listen':		// Listen
		break;

	case 'x_iframe':		// Iframe
		$file_url = $x_1;

		if ( substr_count($file_url, 'http://') == 0 )
		{
			$file_url = PORTAL_URL . $file_url;
		}

		$template->assign_block_vars('iframe_mode', array(
			'FILE_URL' => $file_url,
			'IFRAME_HEIGHT' => $x_2
		));
		break;

	case 'x_textfile':		// Textfile
		ob_start();
		@readfile($mx_root_path . $file);
		$file_contents = ob_get_contents();
		ob_clean();

		$template->assign_block_vars('textfile_mode', array(
			'FILE_CONTENTS' => $file_contents
		));
		break;

	case 'x_multimedia':	// Multimedia
		$template->assign_block_vars('multimedia_mode', array(
			'MEDIA_URL' => PORTAL_URL . $x_1,
			'WIDTH' => !empty($x_2) ? 'width="'.$x_2.'"' : '',
			'HEIGHT' => !empty($x_3) ? 'height="'.$x_3.'"' : ''
		));
		break;

	case 'x_pic':			// Pic
		$template->assign_block_vars('pic_mode', array(
			'FILE_CONTENTS' => $file_contents
		));
		break;

	case 'x_format':		// Formatted file
		// not ready ;) do nothing
		break;

	default:				// Hidden
		$mx_block->show_title = false;
		$mx_block->show_block = false;
		return;
}

$template->pparse('includex_block');

?>