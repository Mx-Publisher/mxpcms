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
 *    $Id: mx_textblock_bbcode.php,v 1.3 2010/10/16 04:06:37 orynider Exp $
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
// Virtual Blog Mode
//
if ($mx_page->is_virtual)
{
	if ($mx_request_vars->is_request('virtual'))
	{
		$mx_block->virtual_init($mx_request_vars->get('virtual', MX_TYPE_INT, 0), true);
	}
	else
	{
		$mx_block->show_title = false;
		$mx_block->show_block = false;
	}
}

//
// Read Block Settings
//
//$block_config = read_block_config( $block_id );
//$title   = $block_config[$block_id]['block_title'];
//$message = $block_config[$block_id]['parameter_value'];

$title = $mx_block->block_info['block_title'];
$desc = $mx_block->block_info['block_desc'];
/** Debug Block Configuration in MXP 2.7 ** /
$message = print_r($mx_block->block_info, true);
/** ** /
$message = $mx_block->block_parameters['parameter_value'];
/** Debug Parameters in MXP 2.7 **/
$message = $mx_block->get_parameters('Text');
/** **/
$bbcode_on = $board_config['allow_bbcode'] ? true : false;
$html_on = $board_config['allow_html'] ? true : false;
$smilies_on = $board_config['allow_smilies'] ? true : false;

//
// Decode for display
//		
if(!$html_on)
{
	$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
}
//
// Decode for display
//
if($bbcode_on)
{
	$bbcode_uid = $mx_block->block_parameters['Text']['parameter_opt'];
	$message = mx_decode($message, $bbcode_uid, $smilies_on, $bbcode_on);
}
 
//
// Start output of page
//
$template->set_filenames(array(
	'body_block' => 'mx_textblock_bbcode.tpl')
);

$template->assign_vars(array(
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'L_TITLE' => ( !empty($lang[$title]) ? $lang[$title] : $title ),
	'U_TEXT' => $message,
	'BLOCK_ID' => $block_id,
	'S_HIDDEN_FORM_FIELDS' => $s_hidden_fields
));

$template->pparse('body_block');
?>