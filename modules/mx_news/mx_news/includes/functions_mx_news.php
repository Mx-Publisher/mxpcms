<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: functions_mx_news.php,v 1.6 2008/06/03 20:12:40 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

/**
 * mx_news class
 *
 */
class mx_news extends mx_news_auth
{
	var $comments = array();
	var $information = array();
	var $notification = array();

	var $modified = false;
	var $error = array();

	var $page_title = '';
	var $block_id = '';

	var $debug = false; // Toggle debug output on/off
	var $debug_msg = array();

	/**
	 * Prepare data
	 *
	 */
	function init()
	{
		global $db, $userdata, $debug, $mx_news_config, $mx_block;
		global $mx_news_functions;
		global $toplist_config;

		unset( $this->block_id );
		unset( $this->comments );
		unset( $this->information );
		unset( $this->notification );

		$temp_id = isset($toplist_config['target_block']) ? $toplist_config['target_block'] : $mx_block->block_id;
		$this->block_id = $mx_news_functions->generate_virtualId($temp_id);

		//
		// Comments
		//
		$this->comments[$this->block_id]['activated'] = true;

		switch($portal_config['portal_backend'])
		{
			case 'internal':
				$this->comments[$this->block_id]['internal_comments'] = true; // phpBB or internal comments
				$this->comments[$this->block_id]['comments_forum_id'] = 0; // phpBB target forum (only used for phpBB comments)
				break;

			default:
				$this->comments[$this->block_id]['internal_comments'] = ($mx_news_config['internal_comments'] == 1 ? true : false ); // phpBB or internal comments
				$this->comments[$this->block_id]['comments_forum_id'] = ( intval($mx_news_config['comments_forum_id']) ); // phpBB target forum (only used for phpBB comments)
				break;
		}

		if ($this->comments[$this->block_id]['activated'] && !$this->comments[$this->block_id]['internal_comments'] && intval($this->comments[$this->block_id]['comments_forum_id']) < 1)
		{
		 	mx_message_die(GENERAL_ERROR, 'Init Failure, phpBB comments with no target forum_id :(<br> Block: ' . $this->block_id . ' Forum_id: ' . $this->comments[$block_id]['comments_forum_id']);
		}

		//
		// Notification
		//
		$this->notification[$this->block_id]['activated'] = (intval($mx_news_config['notify'])); // -1, 0, 1, 2
		$this->notification[$this->block_id]['notify_group'] = (intval($mx_news_config['notify_group'])); // Group_id

	}

	/**
	 * Clean up
	 *
	 */
	function _mx_news()
	{
		if ( $this->modified )
		{
			//$this->sync_all();
		}
	}

	/**
	 * Add debug message.
	 *
	 * @param unknown_type $debug_msg
	 * @param unknown_type $file
	 * @param unknown_type $line_break
	 */
	function debug($debug_msg, $file = '', $line_break = true)
	{
		if ($this->debug)
		{
			$module_name = !empty($this->module_name) ? $this->module_name . ' :: ' : '';
			$file = !empty($file) ? ' (' . $file . ')' : '';
			$line_break = $line_break ? '<br>' : '';
			$this->debug_msg[] = $line_break . $module_name . $debug_msg . $file ;
		}
	}

	/**
	 * Display debug message.
	 *
	 * @return unknown
	 */
	function display_debug()
	{
		if ($this->debug)
		{
			$debug_message = '';
			foreach ($this->debug_msg as $key => $value)
			{
				$debug_message .= $value;
			}

			return $debug_message;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $true_false
	 */
	function modified( $true_false = false )
	{
		$this->modified = $true_false;
	}

	/**
	 * url rewrites.
	 *
	 * @param unknown_type $args
	 * @param unknown_type $force_standalone_mode
	 * @param unknown_type $non_html_amp
	 * @return unknown
	 */
	function this_mxurl( $args = '', $force_standalone_mode = false, $non_html_amp = false, $pageId = '' )
	{
		global $mx_root_path, $module_root_path, $page_id, $phpEx, $is_block;

		$pageId = empty($pageId) ? $page_id : $pageId;
		$dynamicId = !empty($_GET['dynamic_block']) ? ( $non_html_amp ? '&dynamic_block=' : '&amp;dynamic_block=' ) . $_GET['dynamic_block'] : '';

		if ($_GET['dynamic_block'] != '')
		{
			$args = 'dynamic_block='. $_GET['dynamic_block'] . ($args == '' ? '' : '&' ) . $args;
		}

		$args .= ($args == '' ? '' : '&' ) . 'modrewrite=no';

		if ( !MXBB_MODULE )
		{
			$mxurl = $module_root_path . 'mx_news.' . $phpEx . ( $args == '' ? '' : '?' . $args );
			return $mxurl;
		}

		if ( $force_standalone_mode || !$is_block )
		{
			$mxurl = $mx_root_path . 'modules/mx_news/mx_news.' . $phpEx . ( $args == '' ? '' : '?' . $args );
		}
		else
		{
			$mxurl = $mx_root_path . 'index.' . $phpEx;
			if ( is_numeric( $pageId ) )
			{
					$mxurl .= '?page=' . $pageId . $dynamicId . ( $args == '' ? '' : ( $non_html_amp ? '&' : '&amp;' ) . $args );
			}
			else
			{
				$mxurl .= ( $args == '' ? '' : '?' . $args );
			}
		}
		return $mxurl;
	}

	// =============================================
	// Admin and mod functions
	// =============================================

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $link_data
	 * @param unknown_type $item_id
	 * @param unknown_type $cid
	 * @param unknown_type $subject
	 * @param unknown_type $message
	 * @param unknown_type $html_on
	 * @param unknown_type $bbcode_on
	 * @param unknown_type $smilies_on
	 */
	function update_add_comment($link_data = '', $item_id, $cid, $subject = '', $message = '', $html_on = false, $bbcode_on = true, $smilies_on = false, $allow_wysiwyg = false)
	{
		global $template, $mx_news_functions, $lang, $board_config, $phpEx, $mx_news_config, $db, $images, $userdata;
		global $html_entities_match, $html_entities_replace, $unhtml_specialchars_match, $unhtml_specialchars_replace;
		global $mx_root_path, $module_root_path, $phpbb_root_path, $is_block, $phpEx, $mx_request_vars;

		$link_data['link_catid'] = $this->block_id;

		//
		// vars (can both be POSTed or send through the function)
		//
		$update_comment = $cid > 0 ? true : false;
		$subject = !empty($subject) ? $subject : $_POST['subject'];
		$message = !empty($message) ? $message : $_POST['message'];

		$length = strlen( $message );

		//
		// Instantiate the mx_text class
		//
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on);
		$mx_text->allow_all_html_tags = $allow_wysiwyg;

		//
		// Encode for db storage
		//
		$title = $mx_text->encode_simple($subject);
		$comments_text = $mx_text->encode($message);
		$comment_bbcode_uid = $mx_text->bbcode_uid;

		if ( $length > $mx_news_config['max_comment_chars'] )
		{
			mx_message_die( GENERAL_ERROR, 'Your comment is too long!<br/>The maximum length allowed in characters is ' . $mx_news_config['max_comment_chars'] . '' );
		}

		if ( $update_comment )
		{
			if ( $this->comments[$link_data['link_catid']]['internal_comments'] )
			{
				$sql = "UPDATE " . MX_NEWS_COMMENTS_TABLE . "
					SET comments_text = '" . str_replace( "\'", "''", $comments_text ) . "',
				          comments_title = '" . str_replace( "\'", "''", $title ) . "',
				          comment_bbcode_uid = '" . $comment_bbcode_uid . "'
				    WHERE comments_id = " . $cid . "
						AND block_id = ". $item_id;

				if ( !( $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt update comments', '', __LINE__, __FILE__, $sql );
				}
			}
			else
			{
				include( $module_root_path . 'mx_news/includes/functions_comment.' . $phpEx );
				$mx_news_comments = new mx_news_comments();
				$mx_news_comments->init( $item_id );

				$return_data = $mx_news_comments->post( 'update', $cid, $title, $comments_text, $userdata['user_id'], $userdata['username'], 0, '', '', $comment_bbcode_uid);
			}

		}
		else
		{
			if ( $this->comments[$link_data['link_catid']]['internal_comments'] )
			{
				$time = time();
				$poster_id = intval( $userdata['user_id'] );
				$sql = "INSERT INTO " . MX_NEWS_COMMENTS_TABLE . "(block_id, comments_text, comments_title, comments_time, comment_bbcode_uid, poster_id)
					VALUES('$item_id','" . str_replace( "\'", "''", $comments_text ) . "','" . str_replace( "\'", "''", $title ) . "','$time', '$comment_bbcode_uid','$poster_id')";

				if ( !( $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt insert comments', '', __LINE__, __FILE__, $sql );
				}
			}
			else
			{
				include( $module_root_path . 'mx_news/includes/functions_comment.' . $phpEx );
				$mx_news_comments = new mx_news_comments();
				$mx_news_comments->init( $item_id );

				$return_data = $mx_news_comments->post( 'insert', '', $title, $comments_text, $userdata['user_id'], $userdata['username'], 0, '', '', $comment_bbcode_uid);
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $block_id
	 * @param unknown_type $mode_notification
	 */
	function update_add_comment_notify( $block_id = false, $mode_notification = 'edit' )
	{
		global $db, $portal_config;

		if ( in_array( $mode_notification, array( 'add', 'edit', 'do_approve', 'do_unapprove', 'delete' ) ) )
		{
			if (!$block_id)
			{
				die('bad update_add_file_notify arg');
			}

			if (is_array( $block_id ) && !empty( $block_id ))
			{
				$fileIdsArray = $block_id;
			}
			else
			{
				$fileIdsArray[] = $block_id;
			}

			foreach($fileIdsArray as $fileId)
			{
				//
				// Notification
				//
				if ( $this->notification[$block_id]['activated'] > 0 ) // -1, 0, 1, 2
				{
					//
					// Instatiate notification
					//
					$mx_news_notification = new mx_news_notification();
					$mx_news_notification->init( $block_id );

					//
					// Now send notification
					//
					$mx_notification_mode = $this->notification[$block_id]['activated'] == 1 ? MX_PM_MODE : MX_MAIL_MODE;

					switch ( $mode_notification )
					{
						case 'add':
							$mx_notification_action = MX_NEW_NOTIFICATION;
						break;
						case 'edit':
							$mx_notification_action = MX_EDITED_NOTIFICATION;
						break;
						case 'do_approve':
							$mx_notification_action = MX_APPROVED_NOTIFICATION;
						break;
						case 'do_unapprove':
							$mx_notification_action = MX_UNAPPROVED_NOTIFICATION;
						break;
						case 'delete':
							$mx_notification_action = MX_DELETED_NOTIFICATION;
						break;
					}

					$html_entities_match = array('#&(?!(\#[0-9]+;))#', '#<#', '#>#', '#"#');
					$html_entities_replace = array('&amp;', '&lt;', '&gt;', '&quot;');

					$mx_news_notification->notify( $mx_notification_mode, $mx_notification_action );

					if ( $this->notification[$block_id]['notify_group'] > 0 )
					{
						$mx_news_notification->notify( $mx_notification_mode, $mx_notification_action, - intval($this->notification[$block_id]['notify_group']) );
					}
				}
			}
		}
	}
}

/**
 * Public mx_news class
 *
 */
class mx_news_public extends mx_news
{
	var $modules = array();
	var $module_name = '';
	
	/**
	 * this will be replaced by the loaded module
	 *
	 * @param unknown_type $module_id
	 * @return unknown
	 */
	function main($action)
	{
		return false;
	}
	
	/**
	 * load module
	 *
	 * @param unknown_type $module_name send module name to load it
	 */
	function module( $module_name )
	{
		if ( !class_exists( 'mx_news_' . $module_name ) )
		{
			global $module_root_path, $phpEx;

			$this->module_name = $module_name;

			require_once( $module_root_path . 'mx_news/modules/mx_news_' . $module_name . '.' . $phpEx );
			eval( '$this->modules[' . $module_name . '] = new mx_news_' . $module_name . '();' );

			if ( method_exists( $this->modules[$module_name], 'init' ) )
			{
				$this->modules[$module_name]->init();
			}
		}
	}

	/**
	 * go ahead and output the page
	 *
	 * @param unknown_type $page_title send page title
	 * @param unknown_type $tpl_name template file name
	 */
	function display( $page_title1, $tpl_name )
	{
		global $page_title, $mx_news_tpl_name;

		$page_title = $page_title1;
		$mx_news_tpl_name = $tpl_name;
	}
}
?>