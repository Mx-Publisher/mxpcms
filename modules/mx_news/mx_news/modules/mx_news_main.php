<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: mx_news_main.php,v 1.4 2008/06/03 20:12:40 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

/**
 * Enter description here...
 *
 */
class mx_news_main extends mx_news_public
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $action
	 */
	function main( $action )
	{
		global $template, $lang, $board_config, $phpEx, $mx_news_config, $images, $user_ip;
		global $phpbb_root_path, $userdata, $db, $mx_news_functions;
		global $mx_root_path, $module_root_path, $is_block, $mx_request_vars;

		// =======================================================
		// Request vars
		// =======================================================
		$start = $mx_request_vars->get('start', MX_TYPE_INT, 0);
		$block_id = $this->block_id;
		$page_num = $mx_request_vars->request('page_num', MX_TYPE_INT, 1) - 1;

		if ( empty( $block_id ) )
		{
			mx_message_die( GENERAL_MESSAGE, $lang['Link_not_exist'] );
		}

		//
		// Comments
		//
			$comments_type = $this->comments[$block_id]['internal_comments'] ? 'internal' : 'phpbb';

			//
			// Instatiate comments
			//
			include_once( $module_root_path . 'mx_news/includes/functions_comment.' . $phpEx );
			$mx_news_comments = new mx_news_comments();
			$mx_news_comments->init( $mx_news_data, $comments_type );
			$mx_news_comments->display_comments();

		//
		// Output all
		//
		$this->display( $lang['Links'], 'mx_news_body.tpl' );
	}
}
?>