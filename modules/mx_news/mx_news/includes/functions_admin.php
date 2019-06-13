<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: functions_admin.php,v 1.3 2008/06/03 20:12:40 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/**
 * Public mx_news_admin class.
 *
 */
class mx_news_admin extends mx_news_public
{
	/**
	 * load admin module
	 *
	 * @param unknown_type $module_name send module name to load it
	 */
	function adminmodule( $module_name )
	{
		if ( !class_exists( 'mx_news_' . $module_name ) )
		{
			global $module_root_path, $phpEx;

			$this->module_name = $module_name;

			require_once( $module_root_path . 'mx_news/admin/admin_' . $module_name . '.' . $phpEx );
			eval( '$this->modules[' . $module_name . '] = new mx_news_' . $module_name . '();' );

			if ( method_exists( $this->modules[$module_name], 'init' ) )
			{
				$this->modules[$module_name]->init();
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $sel_id
	 * @param unknown_type $use_default_option
	 * @param unknown_type $select_name
	 * @return unknown
	 */
	function get_forums( $sel_id = 0, $use_default_option = false, $select_name = 'forum_id' )
	{
		global $db, $lang;

		$sql = "SELECT forum_id, forum_name
			FROM " . FORUMS_TABLE;

		if ( !$result = $db->sql_query( $sql ) )
		{
			mx_message_die( GENERAL_ERROR, "Couldn't get list of forums", "", __LINE__, __FILE__, $sql );
		}

		$forumlist = '<select name="'.$select_name.'">';

		if ( $sel_id == 0 )
		{
			$forumlist .= '<option value="0" selected >'.$lang['Select_topic_id'].'</option>';
		}

		if ( $use_default_option )
		{
			$status = $sel_id == "-1" ? "selected" : "";
			$forumlist .= '<option value="-1" '.$status.' >::'.$lang['Use_default'].'::</option>';
		}

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			if ( $sel_id == $row['forum_id'] )
			{
				$status = "selected";
			}
			else
			{
				$status = '';
			}
			$forumlist .= '<option value="' . $row['forum_id'] . '" ' . $status . '>' . $row['forum_name'] . '</option>';
		}

		$forumlist .= '</select>';

		return $forumlist;
	}
}
?>