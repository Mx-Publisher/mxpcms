<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: admin_fchecker_manage.php,v 1.7 2008/07/15 22:07:05 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) || !defined( 'IN_ADMIN' ) )
{
	die( "Hacking attempt" );
}

class pafiledb_fchecker_manage extends pafiledb_admin
{
	function main( $module_id = false )
	{
		$action = $module_id;
		global $db, $images, $template, $lang, $phpEx, $pafiledb_functions, $pafiledb_cache, $pafiledb_config, $phpbb_root_path, $module_root_path, $mx_root_path, $mx_request_vars;

		$this_dir = $module_root_path . 'pafiledb/uploads/';

		// MX
		$html_path = PORTAL_URL . $module_root_path . 'pafiledb/uploads/';

		if ( isset( $_GET['safety'] ) || isset( $_POST['safety'] ) )
		{
			$safety = ( isset( $_POST['safety'] ) ) ? intval( $_POST['safety'] ) : intval( $_GET['safety'] );
		}

		$template->set_filenames( array( 'admin' => 'admin/pa_admin_file_checker.tpl' ) );

		$template->assign_vars( array(
			'L_FILE_CHECKER' => $lang['File_checker'],
			'L_FCHECKER_EXPLAIN' => $lang['File_checker_explain']
		));

		if ( $safety == 1 )
		{
			$saved = 0;

			$template->assign_block_vars( "check", array() );

			$template->assign_vars( array( 'L_FILE_CHECKER_SP1' => $lang['Checker_sp1'] ) );

			$sql = "SELECT * FROM " . PA_FILES_TABLE;

			if ( !( $overall_result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
			}

			while ( $temp = $db->sql_fetchrow( $overall_result ) )
			{
				$temp_dlurl = $temp['file_dlurl'];
				if ( substr( $temp_dlurl, 0, strlen( $html_path ) ) !== $html_path )
				{
					continue;
				}

				if ( !is_file( $this_dir . "/" . str_replace( $html_path, "", $temp_dlurl ) ) )
				{
					$template->assign_block_vars( "check.check_step1", array( 'DEL_DURL' => $temp_dlurl ) );
				}
			}

			$template->assign_vars( array( 'L_FILE_CHECKER_SP2' => $lang['Checker_sp2'] ) );
			$sql = "SELECT * FROM " . PA_FILES_TABLE;

			if ( !( $overall_result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
			}
			while ( $temp = $db->sql_fetchrow( $overall_result ) )
			{
				$temp_ssurl = $temp['file_ssurl'];
				$temp_file_id = $temp['file_id'];
				if ( substr( $temp_ssurl, 0, strlen( $html_path ) ) !== $html_path )
				{
					continue;
				}

				if ( !is_file( $this_dir . "/" . str_replace( $html_path, "", $temp_ssurl ) ) )
				{
					/*$sql = "UPDATE " . PA_FILES_TABLE . " SET file_ssurl='' WHERE file_id = '" . $temp_file_id . "'";

					if ( !($db->sql_query($sql)) )
					{
						mx_message_die(GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql);
					}*/

					$template->assign_block_vars( "check.check_step2", array( 'DEL_SSURL' => $temp_file_id ) );
				}
			}

			$template->assign_vars( array( 'L_FILE_CHECKER_SP3' => $lang['Checker_sp3'] ) );

			$files = opendir( $this_dir );
			while ( $temp = readdir( $files ) )
			{
				if ( $temp == "." || $temp == ".." )
				{
					continue;
				}
				if ( !is_file( $this_dir . $temp ) )
				{
					continue;
				}

				$sql = "SELECT * FROM " . PA_FILES_TABLE . " WHERE file_dlurl = '" . $html_path . $temp . "' OR file_ssurl = '" . $html_path . $temp . "'";
				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
				}
				$numhits = $db->sql_numrows( $result );

				if ( !$numhits )
				{
					$saved = $saved + filesize( $this_dir . $temp );
					// unlink($this_dir.$temp);
					$template->assign_block_vars( "check.check_step3", array( 'DEL_FILE' => $temp ) );
				}
			}
			closedir( $files );

			if ( $saved == 0 )
			{
				$saved = "N/A";
			}elseif ( $saved >= 1073741824 )
			{
				$saved = round( $saved / 1073741824 * 100 ) / 100 . " Giga Byte";
			}elseif ( $saved >= 1048576 )
			{
				$saved = round( $saved / 1048576 * 100 ) / 100 . " Mega Byte";
			}elseif ( $saved >= 1024 )
			{
				$saved = round( $saved / 1024 * 100 ) / 100 . " Kilo Byte";
			}
			else
			{
				$saved = $saved . " Bytes";
			}

			$template->assign_vars( array(
				'L_FILE_CHECKER_SAVED' => $lang['Checker_saved'],
				'SAVED' => $saved
			));
		}
		else
		{
			$template->assign_block_vars( "perform", array() );

			$lang['File_saftey'] = str_replace( "{html_path}", $html_path, $lang['File_saftey'] );

			$template->assign_vars( array(
				'L_FILE_CHECKER' => $lang['File_checker'],
				'L_FILE_PERFORM' => $lang['File_checker_perform'],
				'L_FILE_SAFTEY' => $lang['File_saftey']
			));
		}

		// Output
		$template->pparse( 'admin' );
	}
}
?>