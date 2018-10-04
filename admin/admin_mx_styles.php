<?php
/***************************************************************************
 *                              admin_styles.php
 *                            -------------------
 *   begin                : Thursday, Jul 12, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: admin_mx_styles.php,v 1.8 2008/10/04 07:04:24 orynider Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['3_CP']['2_1_new'] = 'admin/' . "$filename?mode=addnew";
	//$module['Styles']['Create_new'] = 'admin/' . "$filename?mode=create";
	$module['3_CP']['2_2_manage'] = 'admin/' . $filename;
	//$module['Styles']['Export'] = 'admin/' . "$filename?mode=export";
	//$module['2_CP']['2_1_Modules'] = 'admin/' . $filename;
	return;
}

//
// Security and Page header
//
define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = TRUE;
require('./pagestart.' . $phpEx);

//
// Load default header
//
include_once('./page_header_admin.' . $phpEx);

$confirm = $mx_request_vars->is_post('confirm');
$cancel = $mx_request_vars->is_post('cancel');

if ($cancel)
{
	redirect('admin/' . mx_append_sid("admin_mx_styles.$phpEx", true));
}

if ($mx_request_vars->is_request('mode'))
{
	$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS);
}
else
{
	$mode = '';
}

switch( $mode )
{
	case "addnew":
		$install_to = $mx_request_vars->is_get('install_to') ? urldecode($mx_request_vars->get('install_to', MX_TYPE_NO_TAGS)) : $mx_request_vars->post('install_to', MX_TYPE_NO_TAGS);
		$style_name = $mx_request_vars->is_get('style') ? urldecode($mx_request_vars->get('style', MX_TYPE_NO_TAGS)) : $mx_request_vars->post('style', MX_TYPE_NO_TAGS);

		if( !empty($install_to) )
		{
			include($mx_root_path. "templates/" . basename($install_to) . "/". basename($install_to). ".cfg");

			$sql = "INSERT INTO " . MX_THEMES_TABLE . " (template_name, style_name, head_stylesheet, portal_backend)
					VALUES( '" . $style_name . "',
						'" . $style_name . "',
						'" . $style_name . ".css',
						'" . PORTAL_BACKEND . "' )";

			if( !$result = $db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Could not insert theme data!", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Theme_installed'] . "<br /><br />" . sprintf($lang['Click_return_styleadmin'], "<a href=\"" . mx_append_sid("admin_mx_styles.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			mx_message_die(GENERAL_MESSAGE, $message);
		}
		else
		{

			$installable_themes = array();

			if( $dir = @opendir($mx_root_path. "templates/") )
			{
				while( $sub_dir = @readdir($dir) )
				{
					if( !is_file($phpBB2->phpbb_realpath($mx_root_path . 'templates/' .$sub_dir)) && !is_link($phpBB2->phpbb_realpath($mx_root_path . 'templates/' .$sub_dir)) && $sub_dir != "." && $sub_dir != ".." && $sub_dir != "CVS" )
					{
						if( @file_exists(@$phpBB2->phpbb_realpath($mx_root_path. "templates/" . $sub_dir . "/$sub_dir.cfg")) )
						{
							@include($mx_root_path. "templates/" . $sub_dir . "/$sub_dir.cfg");

							if ($mx_template_settings['portal_backend'] == PORTAL_BACKEND)
							{
								$style_name = $sub_dir;

								$sql = "SELECT themes_id
									FROM " . MX_THEMES_TABLE . "
									WHERE style_name = '" . str_replace("\'", "''", $style_name) . "'";

								if(!$result = $db->sql_query($sql))
								{
									mx_message_die(GENERAL_ERROR, "Could not query themes table!", "", __LINE__, __FILE__, $sql);
								}

								if(!$db->sql_numrows($result))
								{
									$installable_themes[] = array('style_name'=>$sub_dir, 'template_name'=>$sub_dir);
								}
							}
						}
					}
				}

				$template->set_filenames(array(
					"body" => "admin/styles_addnew_body.tpl")
				);

				$template->assign_vars(array(
					"L_STYLES_TITLE" => $lang['Styles_admin'],
					"L_STYLES_ADD_TEXT" => $lang['Styles_addnew_explain'],
					"L_STYLE" => $lang['Style'],
					//"L_TEMPLATE" => $lang['Template'],
					"L_INSTALL" => $lang['Install'],
					"L_ACTION" => $lang['Action'])
				);

				for($i = 0; $i < count($installable_themes); $i++)
				{
					$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

					$template->assign_block_vars("styles", array(
						"ROW_CLASS" => $row_class,
						"ROW_COLOR" => "#" . $row_color,
						"STYLE_NAME" => $installable_themes[$i]['style_name'],
						//"TEMPLATE_NAME" => $installable_themes[$i]['template_name'],

						"U_STYLES_INSTALL" => mx_append_sid("admin_mx_styles.$phpEx?mode=addnew&amp;style=" . urlencode($installable_themes[$i]['style_name']) . "&amp;install_to=" . urlencode($installable_themes[$i]['template_name'])))
					);

				}
				$template->pparse("body");

			}
			closedir($dir);
		}
		break;

	case "delete":
		$style_id = $mx_request_vars->request('style_id', MX_TYPE_INT);

		if( !$confirm )
		{
			if($style_id == $board_config['default_style'])
			{
				mx_message_die(GENERAL_MESSAGE, $lang['Cannot_remove_style']);
			}

			$hidden_fields = '<input type="hidden" name="mode" value="'.$mode.'" /><input type="hidden" name="style_id" value="'.$style_id.'" />';

			//
			// Set template files
			//
			$template->set_filenames(array(
				"confirm" => "admin/confirm_body.tpl")
			);

			$template->assign_vars(array(
				"MESSAGE_TITLE" => $lang['Confirm'],
				"MESSAGE_TEXT" => $lang['Confirm_delete_style'],

				"L_YES" => $lang['Yes'],
				"L_NO" => $lang['No'],

				"S_CONFIRM_ACTION" => mx_append_sid("admin_mx_styles.$phpEx"),
				"S_HIDDEN_FIELDS" => $hidden_fields)
			);

			$template->pparse("confirm");

		}
		else
		{
			//
			// The user has confirmed the delete. Remove the style, the style element
			// names and update any users who might be using this style
			//
			$sql = "DELETE FROM " . MX_THEMES_TABLE . "
				WHERE themes_id = $style_id";
			if(!$result = $db->sql_query($sql, BEGIN_TRANSACTION))
			{
				mx_message_die(GENERAL_ERROR, "Could not remove style data!", "", __LINE__, __FILE__, $sql);
			}

			$sql = "UPDATE " . USERS_TABLE . "
				SET user_style = " . $board_config['default_style'] . "
				WHERE user_style = $style_id";
			if(!$result = $db->sql_query($sql, END_TRANSACTION))
			{
				mx_message_die(GENERAL_ERROR, "Could not update user style information", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Style_removed'] . "<br /><br />" . sprintf($lang['Click_return_styleadmin'], "<a href=\"" . mx_append_sid("admin_mx_styles.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			mx_message_die(GENERAL_MESSAGE, $message);
		}
		break;

	default:

		$sql = "SELECT themes_id, template_name, style_name
			FROM " . MX_THEMES_TABLE . "
			WHERE portal_backend = '" . PORTAL_BACKEND . "'
			ORDER BY template_name";
		if(!$result = $db->sql_query($sql))
		{
			mx_message_die(GENERAL_ERROR, "Could not get style information!", "", __LINE__, __FILE__, $sql);
		}

		$style_rowset = $db->sql_fetchrowset($result);

		$template->set_filenames(array(
			"body" => "admin/styles_list_body.tpl")
		);

		$template->assign_vars(array(
			"L_STYLES_TITLE" => $lang['Styles_admin'],
			"L_STYLES_TEXT" => $lang['Styles_explain'],
			"L_STYLE" => $lang['Style'],
			"L_DELETE" => $lang['Delete'])
		);

		for($i = 0; $i < count($style_rowset); $i++)
		{
			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			$template->assign_block_vars("styles", array(
				"ROW_CLASS" => $row_class,
				"ROW_COLOR" => $row_color,
				"STYLE_NAME" => $style_rowset[$i]['style_name'],

				"U_STYLES_DELETE" => mx_append_sid("admin_mx_styles.$phpEx?mode=delete&amp;style_id=" . $style_rowset[$i]['themes_id']))
			);
		}

		$template->pparse("body");
		break;
}

if ($mx_request_vars->is_empty_post('send_file'))
{
	include('./page_footer_admin.' . $phpEx);
}

?>