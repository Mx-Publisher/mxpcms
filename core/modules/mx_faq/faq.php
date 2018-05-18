<?php
/***************************************************************************
 *                                  faq.php
 *                            -------------------
 *   begin                : Sunday, Jul 8, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: faq.php,v 1.5 2008/02/09 00:00:45 jonohlsson Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$b_description = $mx_block->block_info['block_desc'];

$page1 = intval($HTTP_GET_VARS['page']);
if ( $page1 > 0 )
{
   $page = $page1;

}
else
{
   $page = 1;

}

//
// Load common language
//
include($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main_faq_editor.' . $phpEx);

// Set vars to prevent naughtiness
$faq = array();

//
// Load the appropriate faq file
//
if( isset($HTTP_GET_VARS['mode']) )
{
	switch( $HTTP_GET_VARS['mode'] )
	{
		case 'forum':
			$lang_file = 'lang_faq';
			$l_title = $lang['FAQ'];
			break;
		case 'bbcode':
			$lang_file = 'lang_bbcode';
			$l_title = $lang['BBCode_guide'];
			break;
		case 'portal':
			$lang_file = 'lang_portal_faq';
			$l_title = $lang['Mx_Portal_faq'];
			break;
		case 'module':
			$lang_file = 'lang_faq_module';
			$l_title = $lang['Mx_Module_faq'];
			break;
		default:
			$lang_file = 'lang_portal_faq';
			$l_title = $lang['Mx_Portal_faq'];
			break;
	}
}
else
{
			$lang_file = 'lang_portal_faq';
			$l_title = $lang['Mx_Portal_faq'];
}
if($HTTP_GET_VARS['mode']== 'forum')
{
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/' . $lang_file . '.' . $phpEx);
}
elseif($HTTP_GET_VARS['mode']== 'bbcode')
{
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/' . $lang_file . '.' . $phpEx);
}
elseif($HTTP_GET_VARS['mode']== 'module')
{
include($module_root_path . 'language/' . $lang_file . '.' . $phpEx);
}
else
{
include($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/' . $lang_file . '.' . $phpEx);
}
//
// Pull the array data from the lang pack
//
$j = 0;
$counter = 0;
$counter_2 = 0;
$faq_block = array();
$faq_block_titles = array();

for($i = 0; $i < count($faq); $i++)
{
	if( $faq[$i][0] != '--' )
	{
		$faq_block[$j][$counter]['id'] = $counter_2;
		$faq_block[$j][$counter]['question'] = $faq[$i][0];
		$faq_block[$j][$counter]['answer'] = $faq[$i][1];

		$counter++;
		$counter_2++;
	}
	else
	{
		$j = ( $counter != 0 ) ? $j + 1 : 0;

		$faq_block_titles[$j] = $faq[$i][1];

		$counter = 0;
	}
}

$template->set_filenames(array(
//+MOD: DHTML Collapsible FAQ MOD
	'body' => (isset($HTTP_GET_VARS['dhtml']) && $HTTP_GET_VARS['dhtml'] == 'no' ? 'faq_body.tpl' : 'faq_dhtml.tpl'))
//-MOD: DHTML Collapsible FAQ MOD
);

$template->assign_vars(array(
	'U_PORTAL_FAQ' => $mx_root_path ."index.$phpEx?page=$page&mode=portal",
	'L_PORTAL_FAQ' => $lang['Mx_Portal_faq'],
	'U_MODULE_FAQ' => $mx_root_path ."index.$phpEx?page=$page&mode=module",
	'L_MODULE_FAQ' => $lang['Mx_Module_faq'],
	'U_FORUM_FAQ' => $mx_root_path ."index.$phpEx?page=$page&mode=forum",
	'L_FORUM_FAQ' => $lang['Forum_faq'],
	'U_BBCODE_FAQ' => $mx_root_path ."index.$phpEx?page=$page&mode=bbcode",
	'L_BBCODE_FAQ' => $lang['BBcode_faq'],
//+MOD: DHTML Collapsible FAQ MOD
	'U_CFAQ_JSLIB' => $module_root_path . 'templates/collapsible_faq.js',
	'L_CFAQ_NOSCRIPT' => sprintf($lang['dhtml_faq_noscript'], ('<a href="'.mx_append_sid("faq.$phpEx?dhtml=no".(isset($HTTP_GET_VARS['mode']) ? '&amp;mode='.$HTTP_GET_VARS['mode'] : '')).'">'), '</a>'),
//-MOD: DHTML Collapsible FAQ MOD
	'L_FAQ_TITLE' => $l_title,
	'L_BACK_TO_TOP' => $lang['Back_to_top'])
);

for($i = 0; $i < count($faq_block); $i++)
{
	if( count($faq_block[$i]) )
	{
		$template->assign_block_vars('faq_block', array(
			'BLOCK_TITLE' => $faq_block_titles[$i])
		);
		$template->assign_block_vars('faq_block_link', array(
			'BLOCK_TITLE' => $faq_block_titles[$i])
		);

		for($j = 0; $j < count($faq_block[$i]); $j++)
		{
			$row_color = ( !($j % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($j % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			$template->assign_block_vars('faq_block.faq_row', array(
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,
				'FAQ_QUESTION' => $faq_block[$i][$j]['question'],
				'FAQ_ANSWER' => $faq_block[$i][$j]['answer'],

				'U_FAQ_ID' => $faq_block[$i][$j]['id'])
			);

			$template->assign_block_vars('faq_block_link.faq_row_link', array(
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,
				'FAQ_LINK' => $faq_block[$i][$j]['question'],

				'U_FAQ_LINK' => '#' . $faq_block[$i][$j]['id'])
			);
		}
	}
}

$template->pparse('body');

?>