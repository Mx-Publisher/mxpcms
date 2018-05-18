<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: simpledoc_settings.php,v 1.3 2008/06/03 20:14:13 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

class mx_simpledoc_settings extends mx_simpledoc_public
{
	function main( $action )
	{
		global $template, $lang, $db, $theme, $board_config, $phpEx, $simpledoc_config, $debug, $mx_root_path, $module_root_path, $CONTENT, $PUBLISH;
		global $CONFIG, $simpledoc_projectName;

		$template->set_filenames( array( 'body' => 'simpledoc_settings.tpl' ));

		//
		// Start
		//
		$mayEdit = IoFile::isWritable($module_root_path . 'config.php');

		$encoding = post('encoding');
		$editorWidth = post('editor-width');
		$editorHeight = post('editor-height');
		$publish_dir = post('publish_dir');

		$encoding = $this->config_safe($encoding);
		$publish_dir = $this->config_safe($publish_dir);
		$publish_dir = str_replace('\\', '/', $publish_dir);

		if (substr($publish_dir, -1) == '/') {
		    $publish_dir = substr($publish_dir, 0, -1);
		}

		if (!is_numeric($editorWidth)) { $editorWidth = null; }
		if (!is_numeric($editorHeight)) { $editorHeight = null; }

		if (!$encoding) { $publish_dir =  $CONFIG['publish_dir']; }

		//
		// Prefix
		//
		$publish_dir_full = $module_root_path . 'simpledoc/' . $publish_dir;

		$err_publish_dir = false;

		if (!$publish_dir_full || !IoDir::exists($publish_dir_full) || !IoDir::isWritable($publish_dir_full)) { $err_publish_dir = true;}

		$ok = $mayEdit && $encoding && $editorWidth && $editorHeight && !$err_publish_dir;

		if ($ok) {
		    $s = "<"."?"."php\r\n";
		    $s .= "\$CONFIG['username'] = '{$CONFIG['username']}';\r\n";
		    $s .= "\$CONFIG['password'] = '{$CONFIG['password']}';\r\n";
		    $s .= "\$CONFIG['encoding'] = '$encoding';\r\n";
		    $s .= "\$CONFIG['editor-width'] = '$editorWidth';\r\n";
		    $s .= "\$CONFIG['editor-height'] = '$editorHeight';\r\n";
		    $s .= "\$CONFIG['publish_dir'] = '$publish_dir';\r\n";
		    $s .= "?".">";
		    IoFile::write($module_root_path . 'config.php', $s);
		}

		if (!$encoding) {
		    $encoding = $CONFIG['encoding'];
		    $editorWidth = $CONFIG['editor-width'];
		    $editorHeight = $CONFIG['editor-height'];
		    $publish_dir = $CONFIG['publish_dir'];
		}

		//
		// Error
		//

	    if ($ok)
	    {
	        $message = 'Settings saved successfully';
	    }

	    if (!$mayEdit)
	    {
	        $message = 'File /config.php must be writable to change settings';
	    }

	    if ($err_publish_dir)
	    {
	       $message = 'Publish Dir doesn\'t exist or is not writable';
		}

		$template->assign_block_vars("message", array(
			'MESSAGE' => $message
		));

		$template->assign_vars( array(
			'MX_ROOT_PATH' => $mx_root_path,
			'MODULE_ROOT_PATH' => $module_root_path,
			'TEMPLATE_PATH' => $template->module_template_path,

			'L_PROJECT_NAME' => $simpledoc_projectName,

			//
			// Menu
			//
			'MODE_MANAGE_URL' => $this->this_simpledoc_mxurl('mode=index'),
			'MODE_PUBLISH_URL' => $this->this_simpledoc_mxurl('mode=publish'),
			'MODE_PUBLISH_EXPORT_URL' => $this->this_simpledoc_mxurl('mode=publish_export'),
			'MODE_IMPORT_URL' => $this->this_simpledoc_mxurl('mode=import'),
			'MODE_EXPORT_URL' => $this->this_simpledoc_mxurl('mode=export'),
			'MODE_VIEW_URL' => $this->this_simpledoc_mxurl('mode=view'),
			'MODE_SETTINGS_URL' => $this->this_simpledoc_mxurl('mode=settings'),

			'ENCODING' => $encoding,
			'EDITOR_WIDTH' => $editorWidth,
			'EDITOR_HEIGHT' => $editorHeight,
			'PUBLISH_DIR' => $publish_dir,

			'DISABLED' => !$mayEdit ? 'disabled="disabled"' : '',

			//
			// Menu langs
			//
			'L_PROJECT' => $lang['sd_Project'],
			'L_MANAGEMENT' => $lang['sd_Management'],
			'L_PUBLISH' => $lang['sd_Publish'],
			'L_IMPORT_CONTENT' => $lang['sd_Import_content'],
			'L_EXPORT_CONTENT' => $lang['sd_Export_content'],
			'L_OPTIONS' => $lang['sd_Options'],
			'L_SETTINGS' => $lang['sd_Settings'],
			'L_DOC_VIEW' => $lang['sd_Doc_view'],
			'L_HELP' => $lang['sd_Help'],
			'L_CONTENTS' => $lang['sd_Contents'],
			'L_ABOUT' => $lang['sd_About'],

			//
			// Tree
			//
			'L_TREE_VIEW' => $lang['sd_Tree_View'],
			'L_WHERE' => $lang['sd_Where'],
			'L_BEFORE' => $lang['sd_Before'],
			'L_AFTER' => $lang['sd_After'],
			'L_TYPE' => $lang['sd_Type'],
			'L_NAME' => $lang['sd_Name'],
			'L_DOCUMENT' => $lang['sd_Document'],
			'L_FOLDER' => $lang['sd_Folder'],

			//
			// Theme
			//
			'T_TR_COLOR1' 			=> '#'.$theme['tr_color1'], // row1
			'T_TR_COLOR2' 			=> '#'.$theme['tr_color2'], // row2
			'T_TR_COLOR3' 			=> '#'.$theme['tr_color3'], // row3
			'T_BODY_TEXT' 			=> '#'.$theme['body_text'],
			'T_BODY_LINK' 			=> '#'.$theme['body_link'],
			'T_BODY_VLINK' 			=> '#'.$theme['body_vlink'],
			'T_BODY_HLINK' 			=> '#'.$theme['body_hlink'],
			'T_TH_COLOR1' 			=> '#'.$theme['th_color1'],	// Border Colors (main)
			'T_TH_COLOR2' 			=> '#'.$theme['th_color2'],	// Border Colors (forumline)
			'T_TH_COLOR3' 			=> '#'.$theme['th_color3'],	// Border Colors (bozes)
			'T_FONTFACE1' 			=> $theme['fontface1'],
			'T_TD_COLOR1' 			=> '#'.$theme['td_color1'], // Background code/quote
			'T_TD_COLOR2' 			=> '#'.$theme['td_color2'], // Background post/input

			//
			// Settings
			//
			'L_CHANGE_SETTINGS' => $lang['sd_Change_settings'],
			'L_ERROR_EMPTY' => $lang['sd_Error_empty'],
			'L_ERROR_WIDTH' => $lang['sd_Error_width'],
			'L_ERROR_HEIGHT' => $lang['sd_Error_height'],
			'L_ERROR_DIR' => $lang['sd_Error_dir'],


		));

	}
}
?>