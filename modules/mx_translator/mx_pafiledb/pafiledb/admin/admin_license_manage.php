<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: admin_license_manage.php,v 1.8 2008/07/15 22:07:05 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) || !defined( 'IN_ADMIN' ) )
{
	die( "Hacking attempt" );
}

class pafiledb_license_manage extends pafiledb_admin
{
	function main( $module_id = false )
	{
		$action = $module_id;
		global $db, $images, $template, $lang, $phpEx, $pafiledb_functions, $pafiledb_cache, $pafiledb_config, $phpbb_root_path, $module_root_path, $mx_root_path, $mx_request_vars;

		if ( isset( $_GET['license'] ) || isset( $_POST['license'] ) )
		{
			$license = ( isset( $_POST['license'] ) ) ? $_POST['license'] : $_GET['license'];

			switch ( $license )
			{
				case 'add':
					{
						$template->set_filenames( array( 'admin' => 'admin/pa_admin_license_add.tpl' ) );

						if ( isset( $_GET['add'] ) || isset( $_POST['add'] ) )
						{
							$add = ( isset( $_GET['add'] ) ) ? $_GET['add'] : $_POST['add'];
						}

						if ( $add == 'do' )
						{
							if ( isset( $_GET['form'] ) || isset( $_POST['form'] ) )
							{
								$form = ( isset( $_GET['form'] ) ) ? $_GET['form'] : $_POST['form'];
							}
							// $form['text'] = str_replace("\n", "<br>", $form['text']);
							$sql = "INSERT INTO " . PA_LICENSE_TABLE . " VALUES('NULL', '" . $form['name'] . "', '" . $form['text'] . "')";

							if ( !( $db->sql_query( $sql ) ) )
							{
								mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
							}

							$message = $lang['Licenseadded'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( "admin_pafiledb.$phpEx?action=license_manage" ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_admin_index'], '<a href="' . mx_append_sid( $mx_root_path . "admin/index.$phpEx?pane=right" ) . '">', '</a>' );
							mx_message_die( GENERAL_MESSAGE, $message );
						}

						if ( empty( $add ) )
						{
							$template->assign_vars( array(
								'S_ADD_LIC_ACTION' => mx_append_sid( "admin_pafiledb.$phpEx?action=license_manage" ),
								'L_ALICENSETITLE' => $lang['Alicensetitle'],
								'L_LICENSEEXPLAIN' => $lang['Licenseexplain'],
								'L_LNAME' => $lang['Lname'],
								'L_LTEXT' => $lang['Ltext']
							));
						}

						break;
					}

				case 'edit':
					{
						$template->set_filenames( array( 'admin' => 'admin/pa_admin_license_edit.tpl' ) );

						if ( isset( $_GET['edit'] ) || isset( $_POST['edit'] ) )
						{
							$edit = ( isset( $_GET['edit'] ) ) ? $_GET['edit'] : $_POST['edit'];
						}

						if ( $edit == 'do' )
						{
							if ( isset( $_GET['form'] ) || isset( $_POST['form'] ) )
							{
								$form = ( isset( $_GET['form'] ) ) ? $_GET['form'] : $_POST['form'];
							}

							if ( isset( $_GET['id'] ) || isset( $_POST['id'] ) )
							{
								$id = ( isset( $_GET['id'] ) ) ? intval( $_GET['id'] ) : intval( $_POST['id'] );
							}
							// $form['text'] = str_replace("\n", "<br>", $form['text']);
							$sql = "UPDATE " . PA_LICENSE_TABLE . " SET license_name = '" . $form['name'] . "', license_text = '" . $form['text'] . "' WHERE license_id = '" . $id . "'";

							if ( !( $db->sql_query( $sql ) ) )
							{
								mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
							}

							$message = $lang['Licenseedited'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( "admin_pafiledb.$phpEx?action=license_manage" ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_admin_index'], '<a href="' . mx_append_sid( $mx_root_path . "admin/index.$phpEx?pane=right" ) . '">', '</a>' );
							mx_message_die( GENERAL_MESSAGE, $message );
						}

						if ( $edit == 'form' )
						{
							if ( isset( $_GET['select'] ) || isset( $_POST['select'] ) )
							{
								$select = ( isset( $_GET['select'] ) ) ? $_GET['select'] : $_POST['select'];
							}

							$sql = "SELECT * FROM " . PA_LICENSE_TABLE . " WHERE license_id = '" . $select . "'";

							if ( !( $result = $db->sql_query( $sql ) ) )
							{
								mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
							}

							$license = $db->sql_fetchrow( $result );
							$text = str_replace( "<br>", "\n", $license['license_text'] );

							$template->assign_block_vars( "license_form", array() );

							$template->assign_vars( array(
								'S_EDIT_LIC_ACTION' => mx_append_sid( "admin_pafiledb.$phpEx?action=license_manage" ),
								'L_ELICENSETITLE' => $lang['Elicensetitle'],
								'L_LICENSEEXPLAIN' => $lang['Licenseexplain'],
								'L_LNAME' => $lang['Lname'],
								'LICENSE_NAME' => $license['license_name'],
								'TEXT' => $text,
								'SELECT' => $select,
								'L_LTEXT' => $lang['Ltext']
							));
						}

						if ( empty( $edit ) )
						{
							$sql = "SELECT * FROM " . PA_LICENSE_TABLE;

							if ( !( $result = $db->sql_query( $sql ) ) )
							{
								mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
							}

							while ( $license = $db->sql_fetchrow( $result ) )
							{
								$row .= '<tr><td width="3%" class="row1" align="center" valign="middle"><input type="radio" name="select" value="' . $license['license_id'] . '"></td><td width="97%" class="row1">' . $license['license_name'] . '</td></tr>';
							}

							$template->assign_block_vars( "license", array() );

							$template->assign_vars( array(
								'S_EDIT_LIC_ACTION' => mx_append_sid( "admin_pafiledb.$phpEx?action=license_manage" ),
								'L_ELICENSETITLE' => $lang['Elicensetitle'],
								'L_LICENSEEXPLAIN' => $lang['Licenseexplain'],
								'ROW' => $row
							));
						}

						break;
					}

				case 'delete':
					{
						$template->set_filenames( array( 'admin' => 'admin/pa_admin_license_delete.tpl' ) );

						if ( isset( $_GET['delete'] ) || isset( $_POST['delete'] ) )
						{
							$delete = ( isset( $_GET['delete'] ) ) ? $_GET['delete'] : $_POST['delete'];
						}

						if ( $delete == 'do' )
						{
							if ( isset( $_GET['select'] ) || isset( $_POST['select'] ) )
							{
								$select = ( isset( $_GET['select'] ) ) ? $_GET['select'] : $_POST['select'];
							}

							if ( empty( $select ) )
							{
								$message = $lang['lderror'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( "admin_pafiledb.$phpEx?action=license_manage&license=delete" ) . '">', '</a>' );

								mx_message_die( GENERAL_MESSAGE, $message );
							}
							else
							{
								foreach ( $select as $key => $value )
								{
									$sql = "DELETE FROM " . PA_LICENSE_TABLE . " WHERE license_id = '" . $key . "'";

									if ( !( $db->sql_query( $sql ) ) )
									{
										mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
									}

									$sql = "UPDATE " . PA_FILES_TABLE . " SET file_license = '0' WHERE file_license = '$key'";

									if ( !( $db->sql_query( $sql ) ) )
									{
										mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
									}
								}

								$message = $lang['Ldeleted'] . '<br /><br />' . sprintf( $lang['Click_return'], '<a href="' . mx_append_sid( "admin_pafiledb.$phpEx?action=license_manage" ) . '">', '</a>' ) . '<br /><br />' . sprintf( $lang['Click_return_admin_index'], '<a href="' . mx_append_sid( $mx_root_path . "admin/index.$phpEx?pane=right" ) . '">', '</a>' );

								mx_message_die( GENERAL_MESSAGE, $message );
							}
						}

						if ( empty( $delete ) )
						{
							$sql = "SELECT * FROM " . PA_LICENSE_TABLE;

							if ( !( $result = $db->sql_query( $sql ) ) )
							{
								mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
							}

							while ( $license = $db->sql_fetchrow( $result ) )
							{
								$row .= '<tr><td width="3%" class="row1" align="center" valign="middle"><input type="checkbox" name="select[' . $license['license_id'] . ']" value="yes"></td><td width="97%" class="row1">' . $license['license_name'] . '</td></tr>';
							}

							$template->assign_vars( array(
								'S_DELETE_LIC_ACTION' => mx_append_sid( "admin_pafiledb.$phpEx?action=license_manage" ),
								'L_DLICENSETITLE' => $lang['Dlicensetitle'],
								'L_LICENSEEXPLAIN' => $lang['Licenseexplain'],
								'ROW' => $row
							));
						}

						break;
					}
			}
		}
		else
		{
			// main
			$template->set_filenames( array( 'admin' => 'admin/pa_admin_license.tpl' ) );

			$sql = "SELECT * FROM " . PA_LICENSE_TABLE;

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt Query info', '', __LINE__, __FILE__, $sql );
			}

			while ( $license = $db->sql_fetchrow( $result ) )
			{
				$row .= '<tr><td width="80%" class="row1" align="center">' . $license['license_name'] . '</td></tr>';
			}

			$template->assign_vars( array(
				'S_DELETE_LIC_ACTION' => mx_append_sid( "admin_pafiledb.$phpEx?action=license_manage" ),
				'L_LICENSETITLE' => $lang['License_title'],
				'L_ALICENSETITLE' => $lang['Alicensetitle'],
				'L_ELICENSETITLE' => $lang['Elicensetitle'],
				'L_DLICENSETITLE' => $lang['Dlicensetitle'],
				'L_LICENSEEXPLAIN' => $lang['Licenseexplain'],
				'ROW' => $row
			));
		}

		// Output
		$template->pparse( 'admin' );
	}
}
?>