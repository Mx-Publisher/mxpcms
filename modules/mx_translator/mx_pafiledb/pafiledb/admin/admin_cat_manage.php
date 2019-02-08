<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: admin_cat_manage.php,v 1.9 2008/07/15 22:07:04 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) || !defined( 'IN_ADMIN' ) )
{
	die( "Hacking attempt" );
}

class pafiledb_cat_manage extends pafiledb_admin
{
	function main( $module_id = false )
	{
		global $db, $images, $template, $template, $lang, $phpEx, $pafiledb_functions, $pafiledb_cache, $pafiledb_config, $phpbb_root_path, $module_root_path, $mx_root_path, $mx_request_vars, $portal_config;
		
		$action = $module_id;
		
		$mode = ( isset( $_REQUEST['mode'] ) ) ? htmlspecialchars( $_REQUEST['mode'] ) : '';
		$cat_id = ( isset( $_REQUEST['cat_id'] ) ) ? intval( $_REQUEST['cat_id'] ) : 0;
		$cat_id_other = ( isset( $_REQUEST['cat_id_other'] ) ) ? intval( $_REQUEST['cat_id_other'] ) : 0;

		if ( $mode == 'do_add' && !$cat_id )
		{
			$new_cat_id = $this->update_add_cat();
			$mode = 'add';
			if ( !sizeof( $this->error ) )
			{
				$this->_pafiledb();
				$message = $lang['Catadded'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( "admin_pafiledb.$phpEx?action=cat_manage" ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_edit_permissions'], '<a href="' . mx_append_sid( "admin_pafiledb.$phpEx?action=catauth_manage&cat_id=$new_cat_id" ) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
			$mode = 'add';
		}
		elseif ( $mode == 'do_add' && $cat_id )
		{
			$new_cat_id = $this->update_add_cat( $cat_id );
			if ( !sizeof( $this->error ) )
			{
				$this->_pafiledb();
				$message = $lang['Catedited'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( "admin_pafiledb.$phpEx?action=cat_manage" ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_edit_permissions'], '<a href="' . mx_append_sid( "admin_pafiledb.$phpEx?action=catauth_manage&cat_id=$new_cat_id" ) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
			$mode = 'edit';
		}
		elseif ( $mode == 'do_delete' )
		{
			$this->delete_cat( $cat_id );
			if ( !sizeof( $this->error ) )
			{
				$this->_pafiledb();
				$message = $lang['Catsdeleted'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( "admin_pafiledb.$phpEx?action=cat_manage" ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_admin_index'], '<a href="' . mx_append_sid( $mx_root_path . "admin/index.$phpEx?pane=right" ) . '">', '</a>' );
				mx_message_die( GENERAL_MESSAGE, $message );
			}
		}
		elseif ( $mode == 'cat_order' )
		{
			$this->order_cat( $cat_id_other );
		}
		elseif ( $mode == 'sync' )
		{
			$this->sync( $cat_id_other );
		}
		elseif ( $mode == 'sync_all' )
		{
			$this->sync_all();
		}

		switch ( $mode )
		{
			case '':
			case 'cat_order':
			case 'sync':
			default:
				$template_file = 'admin/pa_admin_cat.tpl';
				$l_title = $lang['Panel_cat_title'];
				$l_explain = $lang['Panel_cat_explain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="add">';
			break;
			case 'add':
				$template_file = 'admin/pa_admin_cat_edit.tpl';
				$l_title = $lang['Acattitle'];
				$l_explain = $lang['Catexplain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="do_add">';
			break;
			case 'edit':
				$template_file = 'admin/pa_admin_cat_edit.tpl';
				$l_title = $lang['Ecattitle'];
				$l_explain = $lang['Catexplain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="do_add">';
				$s_hidden_fields .= '<input type="hidden" name="cat_id" value="' . $cat_id . '">';
			break;
			case 'delete':
				$template_file = 'admin/pa_admin_cat_delete.tpl';
				$l_title = $lang['Dcattitle'];
				$l_explain = $lang['Catexplain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="do_delete">';
			break;
		}

		$template->set_filenames( array( 'admin' => $template_file ) );

		if ( sizeof( $this->error ) ) $template->assign_block_vars( 'pafiledb_error', array() );

		$template->assign_vars( array(
			'L_CAT_TITLE' => $l_title,
			'L_CAT_EXPLAIN' => $l_explain,

			'ERROR' => ( sizeof( $this->error ) ) ? implode( '<br />', $this->error ) : '',
			'S_HIDDEN_FIELDS' => $s_hidden_fields,
			'S_CAT_ACTION' => mx_append_sid( "admin_pafiledb.$phpEx?action=cat_manage" )
		));

		if ( $mode == '' || $mode == 'cat_order' || $mode == 'sync' || $mode == 'sync_all' )
		{
			$template->assign_vars( array(
				'L_CREATE_CATEGORY' => $lang['Create_category'],
				'L_EDIT' => $lang['Edit'],
				'L_DELETE' => $lang['Delete'],
				'L_MOVE_UP' => $lang['Move_up'],
				'L_MOVE_DOWN' => $lang['Move_down'],
				'L_SUB_CAT' => $lang['Sub_category'],
				'L_RESYNC' => $lang['Resync']
			));
			$this->admin_cat_main( $cat_id );
		}
		elseif ( $mode == 'add' || $mode == 'edit' )
		{
			if ( $mode == 'add' )
			{
				if ( !$_POST['cat_parent'] )
				{
					$cat_list .= '<option value="0" selected>' . $lang['None'] . '</option>';
				}
				else
				{
					$cat_list .= '<option value="0">' . $lang['None'] . '</option>';
				}

				$cat_list .= ( !$_POST['cat_parent'] ) ? $this->generate_jumpbox() : $this->generate_jumpbox( 0, 0, array( $_POST['cat_parent'] => 1 ) );
				$checked_yes = ( $_POST['cat_allow_file'] ) ? ' checked' : '';
				$checked_no = ( !$_POST['cat_allow_file'] ) ? ' checked' : '';
				$cat_name = ( !empty( $_POST['cat_name'] ) ) ? $_POST['cat_name'] : '';
				$cat_desc = ( !empty( $_POST['cat_desc'] ) ) ? $_POST['cat_desc'] : '';

				//
				// Comments
				//
				$use_comments_yes = "";
				$use_comments_no = "";
				$use_comments_default = "checked=\"checked\"";

				$internal_comments_internal = "";
				$internal_comments_phpbb = "";
				$internal_comments_default = "checked=\"checked\"";

				$autogenerate_comments_yes = "";
				$autogenerate_comments_no = "";
				$autogenerate_comments_default = "checked=\"checked\"";

				$comments_forum_id = -1;

				//
				// Ratings
				//
				$use_ratings_yes = "";
				$use_ratings_no = "";
				$use_ratings_default = "checked=\"checked\"";

				//
				// Instructions
				//
				$pretext_show = "";
				$pretext_hide = "";
				$pretext_default = "checked=\"checked\"";

				//
				// Notification
				//
				$notify_none = "";
				$notify_pm = "";
				$notify_email = "";
				$notify_default = "checked=\"checked\"";

				$notify_group_list = mx_get_groups('', 'notify_group');
			}
			else
			{
				if ( !$this->cat_rowset[$cat_id]['cat_parent'] )
				{
					$cat_list .= '<option value="0" selected>' . $lang['None'] . '</option>\n';
				}
				else
				{
					$cat_list .= '<option value="0">' . $lang['None'] . '</option>\n';
				}
				$cat_list .= $this->generate_jumpbox( 0, 0, array( $this->cat_rowset[$cat_id]['cat_parent'] => 1 ) );

				if ( $this->cat_rowset[$cat_id]['cat_allow_file'] )
				{
					$checked_yes = ' checked';
					$checked_no = '';
				}
				else
				{
					$checked_yes = '';
					$checked_no = ' checked';
				}

				$cat_name = $this->cat_rowset[$cat_id]['cat_name'];
				$cat_desc = $this->cat_rowset[$cat_id]['cat_desc'];

				//
				// Comments
				//
				$use_comments_yes = ( $this->cat_rowset[$cat_id]['cat_allow_comments'] == 1 ) ? "checked=\"checked\"" : "";
				$use_comments_no = ( $this->cat_rowset[$cat_id]['cat_allow_comments'] == 0 ) ? "checked=\"checked\"" : "";
				$use_comments_default = ( $this->cat_rowset[$cat_id]['cat_allow_comments'] == -1 ) ? "checked=\"checked\"" : "";

				$internal_comments_internal = ( $this->cat_rowset[$cat_id]['internal_comments'] == 1 ) ? "checked=\"checked\"" : "";
				$internal_comments_phpbb = ( $this->cat_rowset[$cat_id]['internal_comments'] == 0 ) ? "checked=\"checked\"" : "";
				$internal_comments_default = ( $this->cat_rowset[$cat_id]['internal_comments'] == -1 ) ? "checked=\"checked\"" : "";

				$comments_forum_id = $this->cat_rowset[$cat_id]['comments_forum_id'];

				$autogenerate_comments_yes = ( $this->cat_rowset[$cat_id]['autogenerate_comments'] == 1 ) ? "checked=\"checked\"" : "";
				$autogenerate_comments_no = ( $this->cat_rowset[$cat_id]['autogenerate_comments'] == 0 ) ? "checked=\"checked\"" : "";
				$autogenerate_comments_default = ( $this->cat_rowset[$cat_id]['autogenerate_comments'] == -1 ) ? "checked=\"checked\"" : "";

				//
				// Ratings
				//
				$use_ratings_yes = ( $this->cat_rowset[$cat_id]['cat_allow_ratings'] == 1 ) ? "checked=\"checked\"" : "";
				$use_ratings_no = ( $this->cat_rowset[$cat_id]['cat_allow_ratings'] == 0 ) ? "checked=\"checked\"" : "";
				$use_ratings_default = ( $this->cat_rowset[$cat_id]['cat_allow_ratings'] == -1 ) ? "checked=\"checked\"" : "";

				//
				// Instructions
				//
				$pretext_show = ( $this->cat_rowset[$cat_id]['show_pretext'] == 1 ) ? "checked=\"checked\"" : "";
				$pretext_hide = ( $this->cat_rowset[$cat_id]['show_pretext'] == 0 ) ? "checked=\"checked\"" : "";
				$pretext_default = ( $this->cat_rowset[$cat_id]['show_pretext'] == -1 ) ? "checked=\"checked\"" : "";

				//
				// Notification
				//
				$notify_none = ( $this->cat_rowset[$cat_id]['notify'] == 0 ) ? "checked=\"checked\"" : "";
				$notify_pm = ( $this->cat_rowset[$cat_id]['notify'] == 1 ) ? "checked=\"checked\"" : "";
				$notify_email = ( $this->cat_rowset[$cat_id]['notify'] == 2 ) ? "checked=\"checked\"" : "";
				$notify_default = ( $this->cat_rowset[$cat_id]['notify'] == -1 ) ? "checked=\"checked\"" : "";

				$notify_group_list = mx_get_groups($this->cat_rowset[$cat_id]['notify_group'], 'notify_group');
			}

			$template->assign_vars( array(
				'CAT_NAME' => $cat_name,
				'CAT_DESC' => $cat_desc,
				'CHECKED_YES' => $checked_yes,
				'CHECKED_NO' => $checked_no,

				//
				// Comments
				//
				'L_COMMENTS_TITLE' => $lang['Comments_title'],

				'L_USE_COMMENTS' => $lang['Use_comments'],
				'L_USE_COMMENTS_EXPLAIN' => $lang['Use_comments_explain'],
				'S_USE_COMMENTS_YES' => $use_comments_yes,
				'S_USE_COMMENTS_NO' => $use_comments_no,
				'S_USE_COMMENTS_DEFAULT' => $use_comments_default,

				'L_INTERNAL_COMMENTS' => $lang['Internal_comments'],
				'L_INTERNAL_COMMENTS_EXPLAIN' => $lang['Internal_comments_explain'],
				'S_INTERNAL_COMMENTS_INTERNAL' => $internal_comments_internal,
				'S_INTERNAL_COMMENTS_PHPBB' => $internal_comments_phpbb,
				'S_INTERNAL_COMMENTS_DEFAULT' => $internal_comments_default,
				'L_INTERNAL_COMMENTS_INTERNAL' => $lang['Internal_comments_internal'],
				'L_INTERNAL_COMMENTS_PHPBB' => $lang['Internal_comments_phpBB'],

				'L_FORUM_ID' => $lang['Forum_id'],
				'L_FORUM_ID_EXPLAIN' => $lang['Forum_id_explain'],
				'FORUM_LIST' => $portal_config['portal_backend'] != 'internal' ? $this->get_forums( $comments_forum_id, true, 'comments_forum_id' ) : 'not available',
				//'FORUM_LIST' => $this->get_forums( $comments_forum_id, true, 'comments_forum_id' ),

				'L_AUTOGENERATE_COMMENTS' => $lang['Autogenerate_comments'],
				'L_AUTOGENERATE_COMMENTS_EXPLAIN' => $lang['Autogenerate_comments_explain'],
				'S_AUTOGENERATE_COMMENTS_YES' => $autogenerate_comments_yes,
				'S_AUTOGENERATE_COMMENTS_NO' => $autogenerate_comments_no,
				'S_AUTOGENERATE_COMMENTS_DEFAULT' => $autogenerate_comments_default,

				//
				// Ratings
				//
				'L_RATINGS_TITLE' => $lang['Ratings_title'],

				'L_USE_RATINGS' => $lang['Use_ratings'],
				'L_USE_RATINGS_EXPLAIN' => $lang['Use_ratings_explain'],
				'S_USE_RATINGS_YES' => $use_ratings_yes,
				'S_USE_RATINGS_NO' => $use_ratings_no,
				'S_USE_RATINGS_DEFAULT' => $use_ratings_default,

				//
				// Instructions
				//
				'L_INSTRUCTIONS_TITLE' => $lang['Instructions_title'],

				'L_PRE_TEXT_NAME' => $lang['Pre_text_name'],
				'L_PRE_TEXT_EXPLAIN' => $lang['Pre_text_explain'],
				'S_SHOW_PRETEXT' => $pretext_show,
				'S_HIDE_PRETEXT' => $pretext_hide,
				'S_DEFAULT_PRETEXT' => $pretext_default,

				'L_SHOW' => $lang['Show'],
				'L_HIDE' => $lang['Hide'],

				//
				// Notifications
				//
				'L_NOTIFICATIONS_TITLE' => $lang['Notifications_title'],

				'L_NOTIFY' => $lang['Notify'],
				'L_NOTIFY_EXPLAIN' => $lang['Notify_explain'],
				'L_EMAIL' => $lang['Email'],
				'L_PM' => $lang['PM'],

				'S_NOTIFY_NONE' => $notify_none,
				'S_NOTIFY_EMAIL' => $notify_email,
				'S_NOTIFY_PM' => $notify_pm,
				'S_NOTIFY_DEFAULT' => $notify_default,

				'L_NOTIFY_GROUP' => $lang['Notify_group'],
				'L_NOTIFY_GROUP_EXPLAIN' => $lang['Notify_group_explain'],
				'NOTIFY_GROUP' => $notify_group_list,

				'L_CAT_NAME' => $lang['Catname'],
				'L_CAT_NAME_INFO' => $lang['Catnameinfo'],
				'L_CAT_DESC' => $lang['Catdesc'],
				'L_CAT_DESC_INFO' => $lang['Catdescinfo'],
				'L_CAT_PARENT' => $lang['Catparent'],
				'L_CAT_PARENT_INFO' => $lang['Catparentinfo'],
				'L_CAT_ALLOWFILE' => $lang['Allow_file'],
				'L_CAT_ALLOWFILE_INFO' => $lang['Allow_file_info'],
				'L_CAT_ALLOWCOMMENTS' => $lang['Allow_comments'],
				'L_CAT_ALLOWCOMMENTS_INFO' => $lang['Allow_comments_info'],
				'L_CAT_ALLOWRATINGS' => $lang['Allow_ratings'],
				'L_CAT_ALLOWRATINGS_INFO' => $lang['Allow_ratings_info'],

				'L_DEFAULT' => $lang['Use_default'],
				'L_NONE' => $lang['None'],
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],
				'L_CAT_NAME_FIELD_EMPTY' => $lang['Cat_name_missing'],
				'S_CAT_LIST' => $cat_list )
			);
		}
		elseif ( $mode == 'delete' )
		{
			$select_cat = $this->generate_jumpbox( 0, 0, array( $cat_id => 1 ) );
			$file_to_select_cat = $this->generate_jumpbox( 0, 0, '', true );

			$template->assign_vars( array(
				'S_SELECT_CAT' => $select_cat,
				'S_FILE_SELECT_CAT' => $file_to_select_cat,

				'L_DELETE' => $lang['Delete'],
				'L_DO_FILE' => $lang['Delfiles'],
				'L_DO_CAT' => $lang['Do_cat'],
				'L_MOVE_TO' => $lang['Move_to'],
				'L_SELECT_CAT' => $lang['Select_a_Category'],
				'L_DELETE' => $lang['Delete'],
				'L_MOVE' => $lang['Move']
			));
		}

		$template->pparse( 'admin' );

		$this->_pafiledb();
		$pafiledb_cache->unload();
	}
}
?>