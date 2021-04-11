<?php
/**
*
* @package MX-Publisher Module - mx_textblocks
* @version $Id: mx_textblock_multi.php,v 1.25 2013/06/28 15:36:45 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block) )
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
		//$mx_block->show_title = false;
		//$mx_block->show_block = false;
	}
}

//
// Read Block Settings
//
$show_title = $mx_block->block_info['show_title'];
$title = $mx_block->block_info['block_title'];
$desc = $mx_block->block_info['block_desc'];

$block_style = $mx_block->block_parameters['block_style'];
$text_style = $mx_block->block_parameters['text_style'];
$title_style = $mx_block->block_parameters['title_style'];

/** Debug Block Configuration in MXP 2.7 **/
$message = $mx_block->get_parameters('Text');
/** **/

$block_style = $mx_block->get_parameters( 'block_style' );
$text_style = $mx_block->get_parameters( 'text_style' );
$title_style = $mx_block->get_parameters( 'title_style' );
$show_title = $mx_block->get_parameters( 'show_title' );

$allow_bbcode = $mx_block->get_parameters( 'allow_bbcode' ) == 'TRUE';
$allow_html = $mx_block->get_parameters( 'allow_html' ) == 'TRUE';
$allow_smilies = $mx_block->get_parameters( 'allow_smilies' ) == 'TRUE';
$board_config['allow_html_tags'] = $mx_block->get_parameters( 'html_tags' );

if (is_object($mx_page))
{
	// -------------------------------------------------------------------------
	// Extend User Style with module lang and images
	// Usage:  $mx_user->extend(LANG, IMAGES)
	// Switches:
	// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
	// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
	// -------------------------------------------------------------------------
	//$mx_user->extend(MX_LANG_MAIN, MX_IMAGES_NONE);
	$mx_page->add_copyright( 'MX-Publisher Knowledge Base Module' );
}

//
// Block Pages/toc
//
$page_num = $mx_request_vars->request('page_num', MX_TYPE_INT, 1) - 1;

$art_pages = explode('[page]', $message);
$message = trim($art_pages[$page_num]);
$message = str_replace('[toc]', '', $message);

//
// Instantiate the mx_text class
//
include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
$mx_text = new mx_text();
$mx_text->init($allow_html, $allow_bbcode, $allow_smilies); // Note: allowed_html_tags is altered above

//
// Decode for display
//
$title = $mx_text->display_simple($title);
//$message = $mx_text->display($message, $mx_block->get_parameters( 'Text', MX_GET_PAR_OPTIONS ));

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

$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $block_id . '" />';

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

$xtra_dynamic = $mx_request_vars->is_get('dynamic_block') ? '&amp;dynamic_block=' . $mx_request_vars->get('dynamic_block', MX_TYPE_NO_TAGS) : '';

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
		$article_toc = trim($art_split[0]);

		//$article_toc = preg_replace( "'\[[\/\!]*?[^\[\]]*?\]'si", "", $article_toc ); // Fixed
		$article_toc = $mx_text->display($article_toc, $mx_block->get_parameters( 'Text', MX_GET_PAR_OPTIONS ));
		$article_toc = strip_tags($article_toc);

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