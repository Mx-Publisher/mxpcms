<?php
/**
*
* @package MX-Publisher Module - mx_textblocks
* @version $Id: mx_textblock_bbcode.php,v 3.20 2020/02/24 01:50:49 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Virtual Blog Mode
//die($msg_text);
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
$title = $mx_block->block_info['block_title'];
$message = $mx_block->get_parameters( 'Text' );

$bbcode_on = $board_config['allow_bbcode'] ? true : false;
$html_on = $board_config['allow_html'] ? true : false;
$smilies_on = $board_config['allow_smilies'] ? true : false;

//
// Instantiate the mx_text class
//
include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
$mx_text = new mx_text();
$mx_text->init($html_on, $bbcode_on, $smilies_on);

/** Shared Language Tools  **/
$language_from = $board_config['default_lang']; 
$language_into = $mx_user->data['user_lang'];

if (is_object($mx_page))
{
	// -------------------------------------------------------------------------
	// Extend User Style with module lang and images
	// Usage:  $mx_user->extend(LANG, IMAGES)
	// Switches:
	// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
	// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
	// -------------------------------------------------------------------------
	$mx_user->extend(MX_LANG_MAIN, MX_IMAGES_NONE);
	$mx_page->add_copyright( 'MX-Publisher Text-Blocks Module' );
}

$message = !empty($lang[str_replace(' ', '_', $message)]) ? $lang[str_replace(' ', '_', $message)] : $message;

if (strrpos($message, '_'))
{
	$lang_strings = explode(' ', $message);
	$num_strings = count($lang_strings);
	
	$message_row = '';
	for ($i = 0; $i < $num_strings; $i++)
	{
		$message_row .= ($lang[$lang_strings[$i]]) ? $lang[$lang_strings[$i]] : $lang_strings[$i];
	}
	$message = $message_row;
}

//
// Decode for display
//
$title = ((mb_strlen($lang[str_replace(' ', '_', $title)]) !== 0) ? $lang[str_replace(' ', '_', $title)] : $language->lang($title));
$title = $mx_text->display($title);
$message = $mx_text->display($message, $mx_block->get_parameters( 'Text', MX_GET_PAR_OPTIONS ));

//
// Start output of page
//
$template->set_filenames(array(
	'body_block' => 'mx_textblock_bbcode.tpl')
);

$template->assign_vars(array(
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'L_TITLE' => $title,
	'U_TEXT' => $message,
	'BLOCK_ID' => $block_id,
	'S_HIDDEN_FORM_FIELDS' => isset($s_hidden_fields) ? $s_hidden_fields : ''
));

$template->pparse('body_block');
?>
