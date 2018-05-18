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
 *    $Id: mx_textblock_html.php,v 1.3 2010/10/16 04:06:37 orynider Exp $
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
//$block_config = read_block_config( $block_id );
//$title   = $block_config[$block_id]['block_title'];
//$message = $block_config[$block_id]['parameter_value'];

$show_title = $mx_block->block_info['show_title'];
$title = $mx_block->block_info['block_title'];
$desc = $mx_block->block_info['block_desc'];

/** Debug Block Configuration in MXP 2.7 **/
$message = $mx_block->get_parameters('Html');
/** **/

//
// Start output of page
//
$template->set_filenames(array(
	'body_block' => 'mx_textblock_html.tpl')
);

$template->assign_vars(array(
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'L_TITLE' => ( !empty($lang[$title]) ? $lang[$title] : $title ),
	'U_URL' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?block_id=' . $block_id),
	'U_TEXT' => $message,
	'BLOCK_ID' => $block_id,
	'S_HIDDEN_FORM_FIELDS' => $s_hidden_fields)
);

$template->pparse('body_block');

?>