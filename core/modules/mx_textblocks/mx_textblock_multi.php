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
 *    $Id: mx_textblock_multi.php,v 1.3 2010/10/16 04:06:37 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

if( !defined('IN_PORTAL') || !is_object($mx_block) )
{
	die("Hacking attempt");
}

//
// Read Block Settings
//$block_config = read_block_config($block_id);
//$title   = $block_config[$block_id]['block_title'];
//$message = $block_config[$block_id]['parameter_value'];

$show_title = $mx_block->block_info['show_title'];
$title = $mx_block->block_info['block_title'];
$desc = $mx_block->block_info['block_desc'];

$block_style = $mx_block->block_parameters['block_style'];
$text_style = $mx_block->block_parameters['text_style'];
$title_style = $mx_block->block_parameters['title_style'];

/** Debug Block Configuration in MXP 2.7 **/
$message = $mx_block->get_parameters('Text');
/** **/

$bbcode_on = $board_config['allow_bbcode'] ? true : false;
$html_on = $board_config['allow_html'] ? true : false;
$smilies_on = $board_config['allow_smilies'] ? true : false;

$allow_bbcode = $mx_block->get_parameters('allow_bbcode') == TRUE;
$allow_html = $mx_block->get_parameters('allow_html') == TRUE;
$allow_smilies = $mx_block->get_parameters('allow_smilies') == TRUE;
$board_config['allow_html_tags'] = $mx_block->get_parameters('html_tags');

// **********************************************************************
// Read language definition
// **********************************************************************
if( !file_exists($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx) )
{
	include($module_root_path . 'language/lang_english/lang_main.' . $phpEx);
}
else
{
	include($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
}

//
// Block Pages/toc
//
if( isset($_POST['page_num']) || isset($_GET['page_num']) )
{
	$page_num = ( isset($_POST['page_num']) ) ? $_POST['page_num'] : $_GET['page_num'];
	$page_num = $page_num - 1;
}
else
{
	$page_num = 0;
}

$art_pages = explode('[page]', $message);
$message = trim($art_pages[$page_num]);
$message = str_replace('[toc]', '', $message);
//
// End Pages/TOC
//

if( !$allow_html )
{
	$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
}

if($bbcode_on)
{
	$bbcode_uid = $mx_block->block_parameters['Text']['parameter_opt'];
	$message = mx_decode($message, $bbcode_uid, $smilies_on, $bbcode_on);
}

//
// Start output of page
//
$template->set_filenames(array(
	'body_block' => 'mx_textblock_multi.tpl')
);

if( $show_title == 'TRUE' )
{
	if( $title_style == 'TRUE' )
	{
		$template->assign_block_vars('switch_standard_style', array());
	}
	else
	{
		$template->assign_block_vars('switch_no_style', array());
	}
}

$block_style = ( ( $block_style == '' ) || ( $block_style == 'FALSE' ) ) ? '' : 'forumline';
$text_style = ( ( $text_style == '' ) || ( $text_style == 'none' ) ) ? 'genmed' : $text_style;

$template->assign_vars(array(
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'L_TITLE' => ( !empty($lang[$title]) ? $lang[$title] : $title ),
	'U_TEXT' => $message,
	'BLOCK_ID' => $block_id,
	'BLOCK_STYLE' => $block_style,
	'TEXT_STYLE' => $text_style,
	'TITLE_STYLE' => $block_style,
	'S_HIDDEN_FORM_FIELDS' => $s_hidden_fields,
	'L_TOC' => $lang['Toc_title'],
	'L_GOTO_PAGE' => $lang['Goto_page']
));

$xtra_dynamic = isset($HTTP_GET_VARS['dynamic_block']) ? '&amp;dynamic_block=' . $HTTP_GET_VARS['dynamic_block'] : '';

//
// Formatting the TOC
//
if( count($art_pages) > 1 )
{
	$template->assign_block_vars('switch_toc', array());

	$i = 0;

	while( $i < count($art_pages) )
	{
		$page_number = $i + 1;

		$art_split = explode('[toc]', $art_pages[$i]);
		$article_toc = $art_split[0];
		// $article_body = $art_split[1];

		//
		// Fix up the toc title
		//
		if( !$allow_html )
		{
			$article_toc = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $article_toc);
		}

		//
		// Parse message
		//
		$article_toc = preg_replace("/\[(\S+)\]/e", "", $article_toc);
		$article_toc = make_clickable($article_toc);

		//
		// Parse smilies
		//
		if( $allow_smilies )
		{
			$article_toc = mx_smilies_pass($article_toc);
		}

		//
		// Replace naughty words
		//
		if( count($orig_word) )
		{
			$article_toc = str_replace('\"', '"', substr(preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $article_toc . '<'), 1, -1));
		}

		//
		// Replace newlines (we use this rather than nl2br because
		// till recently it wasn't XHTML compliant)
		// $article_toc = str_replace("\n", "\n<br />\n", $article_toc);
		//
		$page_toc = $art_pages[$i];

		if( $page_num != $i )
		{
			$temp_url = mx_append_sid(PORTAL_URL . "index.php?page=$page_id&amp;mode=pagination&amp;page_num=$page_number" . $xtra_dynamic);
			$page_link = '<a href="' . $temp_url . '" class="nav">' . $page_number . ' - ' . $article_toc . '</a>';
		}
		else
		{
			$page_link = $page_number . ' - ' . $article_toc;
		}

		if( $i < count($art_pages) - 1 )
		{
			$page_link .= '<br />';
		}

		$template->assign_block_vars('switch_toc.pages', array(
			'TOC_ITEM' => $page_link)
		);

		$i++;
	}
}

//
// Formatting the TOC navigation/pagination
//
if( count($art_pages) > 1 )
{
	$template->assign_block_vars('switch_pages', array());

	$i = 0;

	while( $i < count($art_pages) )
	{
		$page_number = $i + 1;

		if( $page_num != $i )
		{
			$temp_url = mx_append_sid(PORTAL_URL . "index.php?page=$page_id&amp;mode=pagination&amp;page_num=$page_number" . $xtra_dynamic);
			$page_link = '<a href="' . $temp_url . '" class="nav">' . $page_number . '</a>';
		}
		else
		{
			$page_link = $page_number;
		}

		if( $i < count($art_pages) - 1 )
		{
			$page_link .= ', ';
		}

		$template->assign_block_vars('switch_pages.pages', array(
			'PAGE_LINK' => $page_link)
		);

		$i++;
	}
}

$template->pparse('body_block');

?>