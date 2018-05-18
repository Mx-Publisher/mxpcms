<?php
/**
*
* @package MX-Publisher Module - mx_textblocks
* @version $Id: mx_textblock_bbcode.php,v 1.2 2009/01/24 16:48:09 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
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

//
// Decode for display
//
$title = $mx_text->display($title);
$message = $mx_text->display($message, $mx_block->get_parameters( 'Text', MX_GET_PAR_OPTIONS ));

$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $block_id . '" />';

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