<?php
/** ------------------------------------------------------------------------
 *		subject				: mx-portal, CMS & portal
 *		begin            	: june, 2002
 *		copyright          	: (C) 2002-2005 MX-System
 *		email             	: jonohlsson@hotmail.com
 *		project site		: www.mx-system.com
 * 
 *		description			:
 * -------------------------------------------------------------------------
 * 
 *    $Id: admin_edit.php,v 1.3 2005/01/09 21:53:02 jonohlsson Exp $
 */

 /**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */
 
$no_page_header = true;

define( 'IN_PORTAL', 1 );
$mx_root_path = './../../../';
$module_root_path = $mx_root_path . 'modules/mx_textblocks/';
$admin_module_root_path = $module_root_path . 'admin/';

$post_editbbcode = $module_root_path . "admin/mx_textblock_edit.$phpEx?mode=editbbcode";
$post_edithtml = $module_root_path . "admin/mx_textblock_edit.$phpEx?mode=edithtml";
$post_editblog = $module_root_path . "admin/mx_textblock_edit.$phpEx?mode=editblog";
$post_editmulti = $module_root_path . "admin/mx_textblock_edit.$phpEx?mode=editmulti";

$lang['ACP_TEXTBLOCKS_CONFIG']	= $lang['Edit'] . ' ' . $lang['Settings'];
$lang['ParType_phpBBTextBlock'] = "phpBB Block";
$lang['ParType_BBText'] = "UserBlog block";
$lang['ParType_CustomizedTextBlock'] = "Customized Block";
$lang['ParType_WysiwygTextBlock'] = "Wysiwyg Block";

/* */
if ( !empty( $setmodules))
{	
	$module['TextBlocks'][$lang['Edit'] . ' ' . $lang['ParType_phpBBTextBlock']] = mx_append_sid($post_editbbcode);	
	$module['TextBlocks'][$lang['Edit'] . ' ' . $lang['ParType_BBText']] = mx_append_sid($post_editblog);
	$module['TextBlocks'][$lang['Edit'] . ' ' . $lang['ParType_WysiwygTextBlock']] = mx_append_sid($post_edithtml);
	$module['TextBlocks'][$lang['Edit'] . ' ' . $lang['ParType_CustomizedTextBlock']] = mx_append_sid($post_editmulti);	
	return;
}
/* */

// Security and page header
require( $mx_root_path . 'admin/pagestart.php' );

mx_message_die( GENERAL_MESSAGE, 'Sorry, but this block is NOT designed to be configured in the AdminCP <br /> - please use the EDIT feature in normal portal mode instead.' );

include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );

?>