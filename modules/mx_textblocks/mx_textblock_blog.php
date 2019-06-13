<?php
/**
*
* @package mxBB Portal Module - mx_textblocks
* @version $Id: mx_textblock_blog.php,v 1.14 2006/08/30 19:15:44 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// NOTE: This script is NOT updated for mxBB 2.8
//
if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

if( isset($HTTP_POST_VARS['u']) || isset($HTTP_GET_VARS['u']) )
{
	$sub_id = ( isset($HTTP_POST_VARS['u']) ) ? intval($HTTP_POST_VARS['u']) : intval($HTTP_GET_VARS['u']);
	$blog_mode = 'user';
}
else if( isset($HTTP_POST_VARS['g']) || isset($HTTP_GET_VARS['g']) )
{
	$sub_id = ( isset($HTTP_POST_VARS['g']) ) ? intval($HTTP_POST_VARS['g']) : intval($HTTP_GET_VARS['g']);
	$blog_mode = 'group';
}
else
{
	// $sub_id = $userdata['user_id'];
	// $blog_mode = 'user';
	$block_rows[$block]['show_title'] = 0;
	$block_rows[$block]['show_block'] = 0;
	return;
}

$block_config = read_block_config($block_id, false, $sub_id);
$title = $block_config[$block_id]['block_title'];

$message = $block_config[$block_id]['Blog']['parameter_value'];
$blog_id = $block_config[$block_id]['blog_id']['parameter_value'];

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
if( isset($HTTP_POST_VARS['page_num']) || isset($HTTP_GET_VARS['page_num']) )
{
	$page_num = ( isset($HTTP_POST_VARS['page_num']) ) ? $HTTP_POST_VARS['page_num'] : $HTTP_GET_VARS['page_num'];
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
$bbcode_uid = $block_config[$block_id]['Blog']['bbcode_uid'];
$message = mx_decode($message, $bbcode_uid);

//
// EDIT BLOG
//
$iss_auth_ary = block_auth(AUTH_EDIT, $block_id, $userdata, $block_config[$block_id]['auth_edit'], $block_config[$block_id]['auth_edit_group']);

$blog_validate = ( $blog_mode == 'user' ) ? $sub_id == $userdata['user_id'] : mx_auth_group($sub_id, true);

if( $blog_validate || $iss_auth_ary['auth_edit'] )
{
	$ss_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
	$ss_hidden_fields .= '<input type="hidden" name="block_id" value="' . $block_id . '" />';
	$ss_hidden_fields .= '<input type="hidden" name="portalpage" value="' . $page_id . '" />';
	$ss_hidden_fields .= '<input type="hidden" name="mode" value="editblog" />';
	//$ss_hidden_fields .= '<input type="hidden" name="u" value="' . intval($HTTP_GET_VARS['u']) . '" />';
	//$ss_hidden_fields .= '<input type="hidden" name="g" value="' . intval($HTTP_GET_VARS['g']) . '" />';
	$ss_hidden_fields .= '<input type="hidden" name="u" value="' . $sub_id. '" />';
	$ss_hidden_fields .= '<input type="hidden" name="g" value="' . $sub_id. '" />';
	$ss_hidden_fields .= '<input type="hidden" name="sub_id" value="' . $sub_id . '" />';
	$ss_hidden_fields .= '<input type="hidden" name="blog_mode" value="' . $blog_mode . '" />';

	$splitt_admin_file = 'modules/mx_textblocks/admin/mx_textblock_edit.php';
	$editt_url = append_sid( $mx_root_path . $splitt_admin_file . "?sid=" . $userdata['session_id'] );
	$editt_img = '<input type="image" src="' . PORTAL_URL . TEMPLATE_ROOT_PATH . 'images/block_icons/block_edit.gif" alt="' . $lang['Block_Edit'] . '" title="' . $lang['Block_Edit'] . ' :: ' . $block_config[$block_id]['block_title'] . '"></input>';

	$template->assign_block_vars('switch_blog_edit', array(
		'EDIT_ACTION' => $editt_url,
		'EDIT_IMG' => $editt_img,
		'S_HIDDEN_FORM_FIELDS' => $ss_hidden_fields
	));
}
else
{
	$template->assign_block_vars('switch_blog_noedit', array());
}

//
// Start output of page
//
$template->set_filenames(array(
	'body_block' => 'mx_textblock_blog.tpl')
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

if( !empty($blog_id) && $userdata['session_logged_in'] && $blog_mode == 'user' )
{
	$template->assign_block_vars('switch_blog_id', array(
		'BLOG_ID' => sprintf($blog_id, $userdata['username'])
	));
}

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

//
// article pages table of contents
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
		// Fix up the toc title
		if( !$board_config['allow_html'] )
		{
			$article_toc = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $article_toc);
		}

		//
		// Parse message
		//
		// $bbcode_uid = $row['bbcode_uid'];
		// $article_toc = preg_replace('/\:[0-9a-z\:]+\]/si', ']', $article_toc);
		$article_toc = preg_replace("/\[(\S+)\]/e", "", $article_toc);
		// $txt = preg_replace("/<a href=\"(.*)\">(.*)<\/a>/i", "\\2 (\\1)", $txt);
		$article_toc = make_clickable($article_toc);

		//
		// Parse smilies
		//
		if( $board_config['allow_smilies'] )
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
		// Replace newlines (we use this rather than nl2br because
		// till recently it wasn't XHTML compliant)
		// $article_toc = str_replace("\n", "\n<br />\n", $article_toc);
		$page_toc = $art_pages[$i];

		if( $page_num != $i )
		{
			$temp_url = append_sid(PORTAL_URL . "index.php?page=$page_id&amp;mode=article&amp;page_num=$page_number");
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
// article pages
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
			$temp_url = append_sid(PORTAL_URL . "index.php?page=$page_id&amp;mode=article&amp;page_num=$page_number");
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