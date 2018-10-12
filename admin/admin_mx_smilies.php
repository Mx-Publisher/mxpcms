<?php
/***************************************************************************
*                               admin_mx_smilies.php
*                              -------------------
*     begin                : Thu May 31, 2001
*     copyright            : (C) 2001 The phpBB Group
*     email                : support@phpbb.com
*
*     $Id: admin_mx_smilies.php,v 1.25 2013/06/26 09:15:22 orynider Exp $
*
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

/**************************************************************************
*	This file will be used for modifying the smiley settings for a board.
**************************************************************************/

/*
* Security and Page header
*/
@define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

// First we do the setmodules stuff for the admin cp.
if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['3_CP']['2_3_smilies'] = 'admin/' . $filename;

	return;
}
$no_page_header = false;

/*
* Load default header
*/
include_once('./pagestart.' . $phpEx);
if ($mx_request_vars->is_get('export_pack'))
{
	if ($mx_request_vars->get('export_pack', MX_TYPE_NO_TAGS) == "send" )
	{
		$no_page_header = true;
	}
}

$cancel = $mx_request_vars->is_post('cancel');

// Load default header
if ($no_page_header !== true)
{
	include_once('./page_header_admin.' . $phpEx);
}

if ($cancel)
{
	redirect('admin/' . mx_append_sid("admin_mx_smilies.$phpEx", true));
}

//
// Check to see what mode we should operate in.
//
if ($mx_request_vars->is_request('mode'))
{
	$mode = $mx_request_vars->request('mode',MX_TYPE_NO_TAGS);
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = "";
}

switch (PORTAL_BACKEND)
{
	case 'internal':
		$smiley_path_url = PHPBB_URL; //change this to PORTAL_URL when shared folder will be removed
		$smiley_root_path =	$phpbb_root_path; //same here
		$fields = 'smilies';
		$smiley_url = 'smile_url';
		$emotion = 'emoticon';
		$table = SMILIES_TABLE;
		$delimeter  = '=+:';
	break;
	case 'phpbb2':
		$smiley_path_url = PHPBB_URL;
		$smiley_root_path =	$phpbb_root_path;
		$fields = 'smilies';
		$smiley_url = 'smile_url';
		$emotion = 'emoticon';
		$table = SMILIES_TABLE;
		$delimeter  = '=+:';
	break;
	case 'phpbb3':
		$smiley_path_url = PHPBB_URL;
		$smiley_root_path =	$phpbb_root_path;
		$fields = 'smiley';
		$smiley_url = 'smiley_url';
		$emotion = 'emotion';
		$table = SMILIES_TABLE;
		$delimeter  = ', ';
		$board_config['smilies_path'] = str_replace("smiles", "smilies", $board_config['smilies_path']);
	break;
}

//
// Read a listing of uploaded smilies for use in the add or edit smliey code...
//
$dir = @opendir($smiley_root_path . $board_config['smilies_path']);

while($file = @readdir($dir))
{
	if( !@is_dir($smiley_root_path . $board_config['smilies_path'] . '/' . $file) )
	{
		$img_size = @getimagesize($smiley_root_path . $board_config['smilies_path'] . '/' . $file);

		if( $img_size[0] && $img_size[1] )
		{
			$smiley_images[] = $file;
		}
		else if( stristr($file, '.pak$') )
		{
			$smiley_paks[] = $file;
		}
	}
}

@closedir($dir);

//
// Select main mode
//
if ($mx_request_vars->is_request('import_pack'))
{
	//
	// Import a list a "Smiley Pack"
	//
	$smile_pak = $mx_request_vars->request('smile_pak', MX_TYPE_NO_TAGS);
	$clear_current = $mx_request_vars->request('clear_current', MX_TYPE_NO_TAGS);
	$replace_existing = $mx_request_vars->request('replace', MX_TYPE_NO_TAGS);

	if ( !empty($smile_pak) )
	{
		//
		// The user has already selected a smile_pak file.. Import it.
		//
		if( !empty($clear_current)  )
		{
			switch ($db->sql_layer)
			{
				case 'sqlite':
				case 'firebird':
					$db->sql_query('DELETE FROM ' . $table);
				break;

				default:
					$db->sql_query('TRUNCATE TABLE ' . $table);
				break;
			}
		}
		else
		{
			$sql = "SELECT code
				FROM ". $table;
			if( !$result = $db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't get current smilies", "", __LINE__, __FILE__, $sql);
			}

			$cur_smilies = $db->sql_fetchrowset($result);

			for( $i = 0; $i < count($cur_smilies); $i++ )
			{
				$k = $cur_smilies[$i]['code'];
				$smiles[$k] = 1;
			}
		}

		$smiley_order = 0;

		$fcontents = @file($smiley_root_path . $board_config['smilies_path'] . '/'. $smile_pak);

		if( empty($fcontents) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't read smiley pak file", "", __LINE__, __FILE__, $sql);
		}

		for($i = 0; $i < count($fcontents); $i++)
		{
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'phpbb2':
					$smile_data = explode($delimeter, trim(addslashes($fcontents[$i])));
					$count_data = 2;
				break;

				case 'phpbb3':
					$smile_data = explode($delimeter, trim($fcontents[$i]));
					$smile_data = str_replace("'", "", $smile_data);
					$smile_data = str_replace(",", "", $smile_data);
					$count_data = 5;
				break;
			}

			for($j = $count_data; $j < count($smile_data); $j++)
			{
				//
				// Replace > and < with the proper html_entities for matching.
				//
				$smile_data[$j] = str_replace("<", "&lt;", $smile_data[$j]);
				$smile_data[$j] = str_replace(">", "&gt;", $smile_data[$j]);
				$k = $smile_data[$j];

				// Stripslash here because it got addslashed before... (on export)
				$smile_url = stripslashes($smile_data[0]);
				$smiley_width = stripslashes($smile_data[1]);
				$smiley_height = stripslashes($smile_data[2]);
				$display_on_posting = stripslashes($smile_data[3]);

				if (isset($smile_data[4]) && isset($smile_data[5]))
				{
					$smile_emotion = stripslashes($smile_data[4]);
					$smile_code = stripslashes($smile_data[5]);
				}

				if( $smiles[$k] == 1 )
				{
					if( !empty($replace_existing) )
					{
						switch (PORTAL_BACKEND)
						{
							case 'internal':
							case 'phpbb2':
								$sql = "UPDATE " . $table . "
									SET smile_url = '" . str_replace("\'", "''", $smile_data[0]) . "', emoticon = '" . str_replace("\'", "''", $smile_data[1]) . "'
									WHERE code = '" . str_replace("\'", "''", $smile_data[$j]) . "'";
								$result = $db->sql_query($sql);
							break;

							case 'phpbb3':
								$sql = array(
									'emotion'			=> $smile_emotion,
									$fields . '_url'	=> $smile_url,
									$fields . '_height'	=> (int) $smiley_height,
									$fields . '_width'	=> (int) $smiley_width,
									$fields . '_order'	=> (int) $smiley_order,
									'display_on_posting'=> (int) $display_on_posting,
								);

								$sql = "UPDATE $table SET " . $db->sql_build_array('UPDATE', $sql) . "
									WHERE code = '" . $db->sql_escape($smile_code) . "'";
								$result = $db->sql_query($sql);
							break;
						}
					}
					else
					{
						$sql = '';
					}
				}
				else
				{
					switch (PORTAL_BACKEND)
					{
						case 'internal':
						case 'phpbb2':
							$sql = "INSERT INTO " . $table . " (code, smile_url, emoticon)
								VALUES('" . str_replace("\'", "''", $smile_data[$j]) . "', '" . str_replace("\'", "''", $smile_data[0]) . "', '" . str_replace("\'", "''", $smile_data[1]) . "')";
							$result = $db->sql_query($sql);
						break;

						case 'phpbb3':
							++$smiley_order;
							$sql = array(
								$fields . '_url'	=> $smile_url,
								$fields . '_height'	=> (int) $smiley_height,
								$fields . '_width'	=> (int) $smiley_width,
								$fields . '_order'	=> (int) $smiley_order,
								'display_on_posting'=> (int) $display_on_posting,
							);

							$sql = array_merge($sql, array(
								'code'				=> $smile_code,
								'emotion'			=> $smile_emotion,
							));

							$result = $db->sql_query("INSERT INTO $table " . $db->sql_build_array('INSERT', $sql));
						break;
					}
				}

				if( $sql != '' )
				{
					if( !$result )
					{
						mx_message_die(GENERAL_ERROR, "Couldn't update smilies!", "", __LINE__, __FILE__, $sql);
					}
				}
			}
		}

		$message = $lang['smiley_import_success'] . "<br /><br />" . sprintf($lang['Click_return_smileadmin'], "<a href=\"" . mx_append_sid("admin_mx_smilies.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid($mx_root_path . "admin/index.$phpEx?pane=right") . "\">", "</a>");

		mx_message_die(GENERAL_MESSAGE, $message);

	}
	else
	{
		//
		// Display the script to get the smile_pak cfg file...
		//
		$smile_paks_select = "<select name='smile_pak'><option value=''>" . $lang['Select_pak'] . "</option>";
		while( list($key, $value) = @each($smiley_paks) )
		{
			if ( !empty($value) )
			{
				$smile_paks_select .= "<option>" . $value . "</option>";
			}
		}
		$smile_paks_select .= "</select>";

		$hidden_vars = "<input type='hidden' name='mode' value='import'/>";

		$template->set_filenames(array(
			"body" => "admin/smile_import_body.tpl")
		);

		$template->assign_vars(array(
			"L_SMILEY_TITLE" => $lang['smiley_title'],
			"L_SMILEY_EXPLAIN" => $lang['smiley_import_inst'],
			"L_SMILEY_IMPORT" => $lang['smiley_import'],
			"L_SELECT_LBL" => $lang['choose_smile_pak'],
			"L_IMPORT" => $lang['import'],
			"L_CONFLICTS" => $lang['smile_conflicts'],
			"L_DEL_EXISTING" => $lang['del_existing_smileys'],
			"L_REPLACE_EXISTING" => $lang['replace_existing'],
			"L_KEEP_EXISTING" => $lang['keep_existing'],

			"S_SMILEY_ACTION" => mx_append_sid("admin_mx_smilies.$phpEx"),
			"S_SMILE_SELECT" => $smile_paks_select,
			"S_HIDDEN_FIELDS" => $hidden_vars)
		);

		$template->pparse("body");
	}
}
else if ($mx_request_vars->is_request('export_pack'))
{
	//
	// Export our smiley config as a smiley pak...
	//
	if ($mx_request_vars->get('export_pack', MX_TYPE_NO_TAGS) == "send" )
	{
		//$gen_simple_header = true;

		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'phpbb2':
				$sql = "SELECT *
					FROM " . SMILIES_TABLE;
			break;

			case 'phpbb3':
				$sql = 'SELECT *
					FROM ' . SMILIES_TABLE . '
					ORDER BY smiley_order';
			break;
		}

		if( !$result = $db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, "Could not get smiley list", "", __LINE__, __FILE__, $sql);
		}

		$resultset = $db->sql_fetchrowset($result);

		$smile_pak = "";
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'phpbb2':
				for($i = 0; $i < count($resultset); $i++ )
				{
					$smile_pak .= $resultset[$i][$smiley_url] . $delimeter;
					$smile_pak .= $resultset[$i]['emoticon'] . $delimeter;
					$smile_pak .= $resultset[$i]['code'] . "\n";
				}
			break;

			case 'phpbb3':
				for($i = 0; $i < count($resultset); $i++ )
				{
					$smile_pak .= "'" . addslashes($resultset[$i][$smiley_url]) . "'" . $delimeter;
					$smile_pak .= "'" . addslashes($resultset[$i][$fields . '_width']) . "'" . $delimeter;
					$smile_pak .= "'" . addslashes($resultset[$i][$fields . '_height']) . "'" . $delimeter;
					$smile_pak .= "'" . addslashes($resultset[$i]['display_on_posting']) . "'" . $delimeter;
					$smile_pak .= "'" . addslashes($resultset[$i][$emotion]) . "'" . $delimeter;
					$smile_pak .= "'" . addslashes($resultset[$i]['code']) . "'" . $delimeter . "\n";
				}
			break;
		}
		$db->sql_freeresult($result);

		if ($smile_pak != '')
		{
			//garbage_collection();
			header('Pragma: public');
			header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

			// Send out the Headers
			header('Content-Type: text/x-delimtext; name="smilies.pak"');
			header('Content-Disposition: inline; filename="smilies.pak"');
			echo $smile_pak;

			flush();
			exit;
		}
		else
		{
			mx_message_die(GENERAL_MESSAGE, 'Error');
		}
	}
	$message = sprintf($lang['export_smiles'], "<a href=\"" . mx_append_sid("admin_mx_smilies.$phpEx?export_pack=send", true) . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_smileadmin'], "<a href=\"" . mx_append_sid("admin_mx_smilies.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid($mx_root_path . "admin/index.$phpEx?pane=right") . "\">", "</a>");

	mx_message_die(GENERAL_MESSAGE, $message);

}
else if ($mx_request_vars->is_request('add'))
{
	//
	// Admin has selected to add a smiley.
	//

	$template->set_filenames(array(
		"body" => "admin/smile_edit_body.tpl")
	);

	$filename_list = "";
	for( $i = 0; $i < count($smiley_images); $i++ )
	{
		$filename_list .= '<option value="' . $smiley_images[$i] . '">' . $smiley_images[$i] . '</option>';
	}

	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	$template->assign_vars(array(
		"L_SMILEY_TITLE" => $lang['smiley_title'],
		"L_SMILEY_CONFIG" => $lang['smiley_config'],
		"L_SMILEY_EXPLAIN" => $lang['smile_desc'],
		"L_SMILEY_CODE" => $lang['smiley_code'],
		"L_SMILEY_URL" => $lang['smiley_url'],
		"L_SMILEY_EMOTION" => $lang['smiley_emot'],
		"L_WIDTH" => $lang['Width'],
		"L_HEIGHT" => $lang['Height'],
		"L_ORDER" => $lang['Order'],
		"L_SUBMIT" => $lang['Submit'],
		"L_RESET" => $lang['Reset'],

		"SMILEY_IMG" => $smiley_root_path . $board_config['smilies_path'] . '/' . $smiley_images[0],

		'SMILEY_WIDTH'		=> (PORTAL_BACKEND === 'phpbb3') ? '' : '',
		'SMILEY_HEIGHT'		=> (PORTAL_BACKEND === 'phpbb3') ? '' : '',
		'SMILEY_ORDER'		=> (PORTAL_BACKEND === 'phpbb3') ? '' : '',

		'POSTING_CHECKED'	=> ($mx_request_vars->is_request('add')) ? ' checked="checked"' : '',


		"S_SMILEY_ACTION" => mx_append_sid("admin_mx_smilies.$phpEx"),
		"S_HIDDEN_FIELDS" => $s_hidden_fields,
		"S_FILENAME_OPTIONS" => $filename_list,
		"S_SMILEY_BASEDIR" => $smiley_root_path . $board_config['smilies_path'])
	);

	$template->pparse("body");
}
else if ( $mode != "" )
{
	switch( $mode )
	{
		case 'delete':
			//
			// Admin has selected to delete a smiley.
			//

			$smiley_id = $mx_request_vars->request('id', MX_TYPE_INT);

			if ($mx_request_vars->is_post('confirm'))
			{
				$sql = "DELETE FROM $table
					WHERE {$fields}_id = $smiley_id";
				$result = $db->sql_query($sql);
				if( !$result )
				{
					mx_message_die(GENERAL_ERROR, "Couldn't delete smiley", "", __LINE__, __FILE__, $sql);
				}

				$message = $lang['smiley_del_success'] . "<br /><br />" . sprintf($lang['Click_return_smileadmin'], "<a href=\"" . mx_append_sid("admin_mx_smilies.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid($mx_root_path . "admin/index.$phpEx?pane=right") . "\">", "</a>");

				mx_message_die(GENERAL_MESSAGE, $message);
			}
			else
			{
				// Present the confirmation screen to the user
				$template->set_filenames(array(
					'body' => 'admin/confirm_body.tpl')
				);

				$hidden_fields = '<input type="hidden" name="mode" value="delete" /><input type="hidden" name="id" value="' . $fields . '_id' . '" />';

				$template->assign_vars(array(
					'MESSAGE_TITLE' => $lang['Confirm'],
					'MESSAGE_TEXT' => $lang['Confirm_delete_smiley'],

					'L_YES' => $lang['Yes'],
					'L_NO' => $lang['No'],

					'S_CONFIRM_ACTION' => mx_append_sid("admin_mx_smilies.$phpEx"),
					'S_HIDDEN_FIELDS' => $hidden_fields)
				);
				$template->pparse('body');
			}
			break;

		case 'edit':
			//
			// Admin has selected to edit a smiley.
			//
			$smiley_id = $mx_request_vars->request('id', MX_TYPE_INT);
			$sql = "SELECT *
				FROM " . $table . "
				 WHERE {$fields}_id = " . $smiley_id;

			$result = $db->sql_query($sql);
			if( !$result )
			{
				mx_message_die(GENERAL_ERROR, 'Could not obtain ' . $emotion . ' information', "", __LINE__, __FILE__, $sql);
			}
			$smile_data = $db->sql_fetchrow($result);

			$filename_list = "";
			for( $i = 0; $i < count($smiley_images); $i++ )
			{
				if( $smiley_images[$i] == $smile_data[$smiley_url] )
				{
					$smiley_selected = "selected=\"selected\"";
					$smiley_edit_img = $smiley_images[$i];
				}
				else
				{
					$smiley_selected = "";
				}

				$filename_list .= '<option value="' . $smiley_images[$i] . '"' . $smiley_selected . '>' . $smiley_images[$i] . '</option>';
			}

			$template->set_filenames(array(
				"body" => "admin/smile_edit_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="smile_id" value="' . $smile_data[$fields . '_id'] . '" />';

			$template->assign_vars(array(
				'SMILEY_URL'		=> addslashes($smile_data[$smiley_url]),
				'SMILEY_CODE'		=> addslashes($smile_data['code']),
				'SMILEY_EMOTICON'	=> addslashes($smile_data[$emotion]),
				'S_ID'				=> (isset($smile_data[$fields . '_id'])) ? true : false,
				'ID'				=> (isset($smile_data[$fields . '_id'])) ? $smile_data[$fields . '_id'] : 0,
				'SMILEY_WIDTH'		=> (PORTAL_BACKEND === 'phpbb3') ? $smile_data['smiley_width'] : '',
				'SMILEY_HEIGHT'		=> (PORTAL_BACKEND === 'phpbb3') ? $smile_data['smiley_height'] : '',
				'SMILEY_ORDER'		=> (PORTAL_BACKEND === 'phpbb3') ? $smile_data['smiley_order'] : '',

				'POSTING_CHECKED'	=> (!empty($smile_data['display_on_posting']) || $mx_request_vars->is_request('add')) ? ' checked="checked"' : '',

				"L_SMILEY_TITLE" => $lang['smiley_title'],
				"L_SMILEY_CONFIG" => $lang['smiley_config'],
				"L_SMILEY_EXPLAIN" => $lang['smile_desc'],
				"L_SMILEY_CODE" => $lang['smiley_code'],
				"L_SMILEY_URL" => $lang['smiley_url'],
				"L_SMILEY_EMOTION" => $lang['smiley_emot'],
				"L_WIDTH" => $lang['Width'],
				"L_HEIGHT" => $lang['Height'],
				"L_ORDER" => $lang['Order'],
				"L_SUBMIT" => $lang['Submit'],
				"L_RESET" => $lang['Reset'],

				"SMILEY_IMG" => $smiley_path_url . $board_config['smilies_path'] . '/' . $smiley_edit_img,

				"S_SMILEY_ACTION" => mx_append_sid("admin_mx_smilies.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields,
				"S_FILENAME_OPTIONS" => $filename_list,
				"S_SMILEY_BASEDIR" => $smiley_path_url . $board_config['smilies_path'])
			);

			$template->pparse("body");
			break;

		case "save":
			//
			// Admin has submitted changes while editing a smiley.
			//

			//
			// Get the submitted data, being careful to ensure that we only
			// accept the data we are looking for.
			//
			$smile_code = $mx_request_vars->post('smile_code');
			$smile_url = $mx_request_vars->post('smile_url', MX_TYPE_NO_TAGS);
			$smile_url = phpBB2::phpbb_ltrim(basename($smile_url), "'");
			$smile_emotion = $mx_request_vars->post('smile_emotion', MX_TYPE_NO_HTML);
			$smile_id = $mx_request_vars->post('smile_id', MX_TYPE_INT, 0);
			$smile_code = trim($smile_code);
			$smile_url = trim($smile_url);

			if (PORTAL_BACKEND === 'phpbb3')
			{
				$smiley_width = $mx_request_vars->post('smile_width', MX_TYPE_NO_HTML);
				$smiley_height = $mx_request_vars->post('smile_height', MX_TYPE_NO_HTML);
				$smiley_order = $mx_request_vars->post('smile_order', MX_TYPE_NO_HTML);
			}


			// If no code was entered complain ...
			if ($smile_code == '' || $smile_url == '')
			{
				mx_message_die(GENERAL_MESSAGE, $lang['Fields_empty']);
			}

			//
			// Convert < and > to proper htmlentities for parsing.
			//
			$smile_code = str_replace('<', '&lt;', $smile_code);
			$smile_code = str_replace('>', '&gt;', $smile_code);

			//
			// Proceed with updating the smiley table.
			//
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'phpbb2':
					$sql = "UPDATE " . $table . "
						SET code = '" . str_replace("\'", "''", $smile_code) . "', smile_url = '" . str_replace("\'", "''", $smile_url) . "', emoticon = '" . str_replace("\'", "''", $smile_emotion) . "'
						WHERE smilies_id = $smile_id";
				break;

				case 'phpbb3':
					$sql = array(
						'emotion'			=> $smile_emotion,
						$fields . '_url'	=> $smile_url,
						$fields . '_height'	=> (int) $smiley_height,
						$fields . '_width'	=> (int) $smiley_width,
						$fields . '_order'	=> (int) $smiley_order,
						'display_on_posting'=> (int) $display_on_posting,
					);

					$sql = "UPDATE $table SET " . $db->sql_build_array('UPDATE', $sql) . "
						WHERE code = '" . $db->sql_escape($smile_code) . "'";
				break;
			}

			if( !($result = $db->sql_query($sql)) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't update smilies info", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['smiley_edit_success'] . "<br /><br />" . sprintf($lang['Click_return_smileadmin'], "<a href=\"" . mx_append_sid("admin_mx_smilies.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid($mx_root_path . "admin/index.$phpEx?pane=right") . "\">", "</a>");

			mx_message_die(GENERAL_MESSAGE, $message);
			break;

		case "savenew":
			//
			// Admin has submitted changes while adding a new smiley.
			//

			//
			// Get the submitted data being careful to ensure the the data
			// we recieve and process is only the data we are looking for.
			//
			$smile_code = $mx_request_vars->post('smile_code');
			$smile_url = $mx_request_vars->post('smile_url');
			$smile_url = phpBB2::phpbb_ltrim(basename($smile_url), "'");
			$smile_emotion = $mx_request_vars->post('smile_emotion', MX_TYPE_NO_HTML);
			$smile_code = trim($smile_code);
			$smile_url = trim($smile_url);

			if (PORTAL_BACKEND === 'phpbb3')
			{
				$smiley_width = $mx_request_vars->post('smile_width', MX_TYPE_NO_HTML);
				$smiley_height = $mx_request_vars->post('smile_height', MX_TYPE_NO_HTML);
				$smiley_order = $mx_request_vars->post('smile_order', MX_TYPE_NO_HTML);
				$display_on_posting = $mx_request_vars->request('display', MX_TYPE_INT, 1);
			}

			// If no code was entered complain ...
			if ($smile_code == '' || $smile_url == '')
			{
				mx_message_die(GENERAL_MESSAGE, $lang['Fields_empty']);
			}

			//
			// Convert < and > to proper htmlentities for parsing.
			//
			$smile_code = str_replace('<', '&lt;', $smile_code);
			$smile_code = str_replace('>', '&gt;', $smile_code);

			//
			// Save the data to the smiley table.
			//
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'phpbb2':
					$sql = "INSERT INTO " . $table . " (code, smile_url, emoticon)
						VALUES ('" . str_replace("\'", "''", $smile_code) . "', '" . str_replace("\'", "''", $smile_url) . "', '" . str_replace("\'", "''", $smile_emotion) . "')";
					$result = $db->sql_query($sql);
				break;

				case 'phpbb3':
					$sql = array(
						'code'				=> $smile_code,
						'emotion'			=> $smile_emotion,
						$fields . '_url'	=> $smile_url,
						$fields . '_height'	=> (int) $smiley_height,
						$fields . '_width'	=> (int) $smiley_width,
						$fields . '_order'	=> (int) $smiley_order,
						'display_on_posting'=> (int) $display_on_posting,
					);
					$result = $db->sql_query("INSERT INTO $table " . $db->sql_build_array('INSERT', $sql));
				break;
			}


			if( !$result )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't insert new smiley", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['smiley_add_success'] . "<br /><br />" . sprintf($lang['Click_return_smileadmin'], "<a href=\"" . mx_append_sid("admin_mx_smilies.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid($mx_root_path . "admin/index.$phpEx?pane=right") . "\">", "</a>");

			mx_message_die(GENERAL_MESSAGE, $message);
			break;
	}
}
else
{

	//
	// This is the main display of the page before the admin has selected
	// any options.
	//
	switch (PORTAL_BACKEND)
	{
		case 'internal':
		case 'phpbb2':
			$sql = "SELECT *
				FROM " . $table;
			$result = $db->sql_query($sql);
		break;

		case 'phpbb3':
			$sql = 'SELECT *
				FROM ' . $table . '
				ORDER BY smiley_order';
			$result = $db->sql_query($sql);
		break;
	}
	if( !$result )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain smileys from database", "", __LINE__, __FILE__, $sql);
	}

	$smilies = $db->sql_fetchrowset($result);
	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	$template->set_filenames(array(
		"body" => "admin/smile_list_body.tpl")
	);

	$template->assign_vars(array(
		"L_ACTION" => $lang['Action'],
		"L_SMILEY_TITLE" => $lang['smiley_title'],
		"L_SMILEY_TEXT" => $lang['smile_desc'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		"L_SMILEY_ADD" => $lang['smile_add'],
		"L_CODE" => $lang['Code'],
		"L_EMOT" => $lang['Emotion'],
		'L_WIDTH' => $lang['Width'],
		'L_HEIGHT' => $lang['Height'],
		'L_ORDER' => $lang['Order'],
		"L_SMILE" => $lang['Smile'],
		"L_IMPORT_PACK" => $lang['import_smile_pack'],
		"L_EXPORT_PACK" => $lang['export_smile_pack'],

		"S_HIDDEN_FIELDS" => $s_hidden_fields,
		"S_SMILEY_ACTION" => mx_append_sid("admin_mx_smilies.$phpEx"))
	);

	//
	// Loop throuh the rows of smilies setting block vars for the template.
	//
	for($i = 0; $i < count($smilies); $i++)
	{
		//
		// Replace htmlentites for < and > with actual character.
		//
		$smilies[$i]['code'] = str_replace('&lt;', '<', $smilies[$i]['code']);
		$smilies[$i]['code'] = str_replace('&gt;', '>', $smilies[$i]['code']);

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars("smiles", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,

			"SMILEY_IMG" =>  $smiley_path_url . $board_config['smilies_path'] . '/' . $smilies[$i][$smiley_url],
			"CODE" => $smilies[$i]['code'],
			"EMOT" => $smilies[$i][$emotion],

			'WIDTH'		=> (PORTAL_BACKEND === 'phpbb3') ? $smilies[$i]['smiley_width'] : '',
			'HEIGHT'	=> (PORTAL_BACKEND === 'phpbb3') ? $smilies[$i]['smiley_height'] : '',
			'ORDER'		=> (PORTAL_BACKEND === 'phpbb3') ? $smilies[$i]['smiley_order'] : '',

			"U_SMILEY_EDIT" => mx_append_sid("admin_mx_smilies.$phpEx?mode=edit&amp;id=" . $smilies[$i][$fields . '_id']),
			"U_SMILEY_DELETE" => mx_append_sid("admin_mx_smilies.$phpEx?mode=delete&amp;id=" . $smilies[$i][$fields . '_id']))
		);
	}

	//
	// Spit out the page.
	//
	$template->pparse("body");
}

//
// Page Footer
//
include_once($mx_root_path . 'admin/page_footer_admin.' . $phpEx);

?>