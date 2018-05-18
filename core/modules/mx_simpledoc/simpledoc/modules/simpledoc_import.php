<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: simpledoc_import.php,v 1.4 2008/06/03 20:14:12 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

class mx_simpledoc_import extends mx_simpledoc_public
{
	function main( $action )
	{
		global $template, $lang, $db, $theme, $board_config, $phpEx, $simpledoc_config, $debug, $mx_root_path, $module_root_path, $CONTENT, $PUBLISH, $CHMOD_FILE, $CHMOD_DIR;
		global $simpledoc_projectName;

		include_once( $module_root_path . 'simpledoc/includes/functions_zip.' . $phpEx );

		$template->set_filenames( array( 'body' => 'simpledoc_import.tpl' ));

		$ZipFile = new Upload('zip_file');
		$err = array();

		if (isPOST() && $ZipFile->isValid()) {

		    $name = substr($ZipFile->filename, 0, -strlen($ZipFile->getExtension()));
		    $path = $ZipFile->tmp;

		    $zip = new zip;
		    $list = @$zip->get_List($path);
		    if (!$list || !count($list)) $err['invalid_zip'] = true;

		    if (!count($err)) {
		        $root = $list[0]['filename'];
		        $root = substr($root, 0, strpos($root, '/'));
		        if ($root != $name) $err['invalid_zip'] = true;
		    }

		    if (!count($err)) {
		        $tmp = $PUBLISH.'/import-'.$name;
		        IoDir::create($tmp, $CHMOD_DIR);
		        $this->extract_zip($path, $tmp);
		        IoDir::delete($CONTENT, false);
		        IoDir::copy($tmp.'/'.$name, $CONTENT, $CHMOD_FILE, $CHMOD_DIR);
		        IoDir::delete($tmp);
		        mx_redirect($module_root_path . 'redirect.php?url=index.php&msg=Content+imported+successfully');
		    }
		}

	    if (isPOST() && !$ZipFile->isValid())
	    {
	        die('There was an error while uploading file');
	    }

	    if (isset($err['invalid_zip']))
	    {
	        die('The zip file contains invalid data');
	    }

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
			'MODE_SETTINGS_URL' => $this->this_simpledoc_mxurl('mode=settings'),
			'MODE_VIEW_URL' => $this->this_simpledoc_mxurl('mode=view'),
			'TREE_HTML' => $tree_html,

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
			// Import
			//
			'L_ZIP_FILE' => $lang['sd_Zip_file'],
			'L_ZIP_IMPORT' => $lang['sd_Import'],
			'L_ZIP_FILE_REQUIRED' => $lang['sd_Zip_file_required'],
			'L_ZIP_INFO' => $lang['sd_Zip_info'],

		));
	}
}
?>