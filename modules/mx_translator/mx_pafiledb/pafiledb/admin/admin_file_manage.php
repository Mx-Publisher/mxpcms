<?php
/**
*
* @package MX-pafiledb Module - mx_pafiledb
* @version $Id: admin_pa_file.php,v 1.9 2008/07/15 22:07:04 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, FlorinCB, CRLin] MX-pafiledb Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/


/**
*
* @Extra credits for this file
* Todd - (todd@phparena.net) - (http://www.phparena.net)
*
*/

if ( !defined( 'IN_PORTAL' ) || !defined( 'IN_ADMIN' ) )
{
	die("Hacking attempt");
}

class pafiledb_file_manage extends pafiledb_admin
{
	function main( $module_id = false )
	{
		$action = $module_id;
		global $mx_user, $db, $images, $template, $template, $lang, $phpEx, $pafiledb_functions, $pafiledb_cache, $pafiledb_config, $phpbb_root_path, $module_root_path, $mx_root_path, $mx_request_vars, $portal_config;

		//include( $module_root_path . 'pafiledb/includes/functions_field.' . $phpEx );

		//$custom_field = new custom_field();
		//$custom_field->init();

		//$pafiledb->init();

		$cat_id = ( isset( $_REQUEST['cat_id'] ) ) ? intval( $_REQUEST['cat_id'] ) : 0;
		$file_id = ( isset( $_REQUEST['file_id'] ) ) ? intval( $_REQUEST['file_id'] ) : 0;
		$file_ids = ( isset( $_POST['file_ids'] ) ) ? array_map( 'intval', $_POST['file_ids'] ) : array();
		$start = ( isset( $_REQUEST['start'] ) ) ? intval( $_REQUEST['start'] ) : 0;

		$mode = ( isset( $_REQUEST['mode'] ) ) ? htmlspecialchars( $_REQUEST['mode'] ) : '';
		$mode_js = ( isset( $_REQUEST['mode_js'] ) ) ? htmlspecialchars( $_REQUEST['mode_js'] ) : '';
		$mode = ( isset( $_POST['addfile'] ) ) ? 'add' : $mode;
		$mode = ( isset( $_POST['delete'] ) ) ? 'delete' : $mode;
		$mode = ( isset( $_POST['approve'] ) ) ? 'do_approve' : $mode;
		$mode = ( isset( $_POST['unapprove'] ) ) ? 'do_unapprove' : $mode;
		$mode = ( empty( $mode ) ) ? $mode_js : $mode;

		$mirrors = ( isset( $_POST['mirrors'] ) ) ? true : 0;

		if ( isset( $_REQUEST['sort_method'] ) )
		{
			switch ( $_REQUEST['sort_method'] )
			{
				case 'file_name':
					$sort_method = 'file_name';
					break;
				case 'file_time':
					$sort_method = 'file_time';
					break;
				case 'file_dls':
					$sort_method = 'file_dls';
					break;
				case 'file_rating':
					$sort_method = 'rating';
					break;
				case 'file_update_time':
					$sort_method = 'file_update_time';
					break;
				default:
					$sort_method = $pafiledb_config['sort_method'];
			}
		}
		else
		{
			$sort_method = $pafiledb_config['sort_method'];
		}

		if ( isset( $_REQUEST['sort_order'] ) )
		{
			switch ( $_REQUEST['sort_order'] )
			{
				case 'ASC':
					$sort_order = 'ASC';
					break;
				case 'DESC':
					$sort_order = 'DESC';
					break;
				default:
					$sort_order = $pafiledb_config['sort_order'];
			}
		}
		else
		{
			$sort_order = $pafiledb_config['sort_order'];
		}

		$s_file_actions = array( 'approved' => $lang['Approved_files'],
			'broken' => $lang['Broken_files'],
			'file_cat' => $lang['File_cat'],
			'all_file' => $lang['All_files'],
			'maintenance' => $lang['Maintenance'] );

		// Here we set the main switches to use within the ACP
		$this->page_title = $lang['ACP_EDIT_DOWNLOADS'];
		$this->tpl_name = 'acp_pa_files_list';
		//if (!extension_loaded("tokenizer")) print "tokenizer extension not loaded!";
		switch ($mode)
		{
			case 'new_download';
			case 'add':
				$this->page_title = $lang['ACP_NEW_DOWNLOAD'];
				$this->tpl_name = 'acp_pa_files_new';
				//$admin_controller->new_download();
				$template_file = 'admin/pa_admin_file_edit.tpl';
				$l_title = $lang['Afiletitle'];
				$l_explain = $lang['Fileexplain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="do_add">';
			break;

			case 'copy_new';
				$this->page_title = $lang['ACP_NEW_DOWNLOAD'];
				$this->tpl_name = 'acp_pa_files_new_copy';
				$admin_controller->copy_new();
			break;

			case 'edit':
			case 'do_add':
				$this->page_title = $lang['ACP_EDIT_DOWNLOADS'];
				$this->tpl_name = 'acp_pa_files_edit';
				//$admin_controller->edit();
				$template_file = 'admin/pa_admin_file_edit.tpl';
				$l_title = $lang['Efiletitle'];
				$l_explain = $lang['Fileexplain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="do_add">';
				$s_hidden_fields .= '<input type="hidden" name="file_id" value="' . $file_id . '">';
			break;

			case 'add_new';
				//$admin_controller->add_new();
			break;

			case 'update';
				//$admin_controller->update();
			break;
			
			case 'maintenance':
				$template_file = 'admin/pa_admin_file_checker.tpl';
				$l_title = $lang['File_checker'];
				$l_explain = $lang['File_checker_explain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="do_maintenace">';
			break;
			
			case 'mirrors':
				$template_file = 'admin/pa_admin_file_mirrors.tpl';
				$l_title = $lang['Mirrors'];
				$l_explain = $lang['Mirrors_explain'];
				$s_hidden_fields = '<input type="hidden" name="mode" value="mirrors">';
				$s_hidden_fields .= '<input type="hidden" name="file_id" value="' . $file_id . '">';
			break;

			case 'delete';
			case '':
			case 'approved':
			case 'broken':
			case 'do_approve':
			case 'do_unapprove':
			case 'file_cat':
			case 'all_file':
			default:
				$template_file = 'admin/pa_admin_file.tpl';
				$l_title = $lang['File_manage_title'];
				$l_explain = $lang['Fileexplain']; 
				// $s_hidden_fields = '<input type="hidden" name="mode" value="add">';
				//$admin_controller->delete();
			break;
		}
		
		
		
		
	}
}
?>
