<?php
/**
*
* @package mxBB Portal Module - mx_counter
* @version $Id: blocks_imp_visit_counter.php,v 1.1 2011/03/29 01:56:17 orynider Exp $
* @copyright (c) 2008 Mighty Gorgon, OryNider
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

/**
*
* @Extra credits for this file
* masterdavid - Ronald John David
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// ERROR HANDLING
//
//error_reporting( E_ALL );

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$block_size = (isset($block_size) && !empty($block_size) ? $block_size : '100%');

if(!function_exists('imp_visit_counter_block_func'))
{
	function imp_visit_counter_block_func()
	{
		global $template, $lang, $board_config;
		//
		// Start output of page
		//
		$template->set_filenames(array(
			'body_block' => 'visit_counter_block.tpl')
		);

		$template->assign_vars(array(
			'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
			'L_TITLE' => ( !empty($lang[$title]) ? $lang[$title] : $title ),
			'L_PORTAL_COUNTER' => ( !empty($lang['portal_counter']) ? $lang['portal_counter'] : '' ),
			'VISIT_COUNTER' => sprintf($lang['Visit_counter_statement'], $board_config['visit_counter'] + 1, create_date($board_config['default_dateformat'], $board_config['board_startdate'], $board_config['board_timezone'])),
			'L_VISIT_COUNTER' => $lang['Visit_counter'],
			'U_URL' => mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?block_id=' . $block_id),
			'BLOCK_ID' => $block_id,
			'S_HIDDEN_FORM_FIELDS' => $s_hidden_fields)
		);

		$template->pparse('body_block');		
	}
}

imp_visit_counter_block_func();

?>