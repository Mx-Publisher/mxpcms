<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: simpledoc_publish.php,v 1.4 2008/06/03 20:14:12 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

class mx_simpledoc_publish extends mx_simpledoc_public
{
	function main( $action )
	{
		global $template, $lang, $db, $theme, $board_config, $phpEx, $simpledoc_config, $debug, $mx_root_path, $module_root_path, $CONTENT, $PUBLISH;
		global $mx_page, $simpledoc_projectName;

		$template->set_filenames( array( 'body' => 'simpledoc_publish.tpl' ));

		//
		// Start
		//
		$documents = 0;
		$folders = 0;
		$size = 0;

		$files = IoDir::readFull($CONTENT);
		$sections = array();
		foreach ($files as $file)
		{
		    if ($this->get_name($file) == $SORT) continue;
		    $id = substr($file, strlen($CONTENT)+1);

		    if (IoFile::exists($file))
		    {
		        $documents++;
		        $size += IoFile::getSize($file);
		    }
		    else if (IoDir::exists($file))
		    {
		        $folders++;
		        $sections[$id] = $id;
		    }
		}

		$publish_dir_ok = true;
		if ($CONFIG['publish_dir'])
		{
		    if (!IoDir::exists($PUBLISH) || !IoDir::isWritable($PUBLISH)) { $publish_dir_ok = false; }
		}

		$size = $this->get_readable_size($size);

	    $publish_dir_error = !$publish_dir_ok ? 'Publish Dir doesn\'t exist or is not writable' : '';
	    $template_options = sugolibTemplate::htmlOptions($sections);

		$template->assign_vars( array(
			'PUBLISH_DIR_ERROR' => !$CONFIG['publish_dir'] || !$publish_dir_ok,

			'MX_ROOT_PATH' => $mx_root_path,
			'MODULE_ROOT_PATH' => $module_root_path,
			'TEMPLATE_PATH' => $template->module_template_path,
			'PAGE_ID' => $mx_page->page_id,

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

			'DOCUMENT' => $documents,
			'FOLDERS' => $folders,
			'SIZE' => $size,
			'PUBLISH_DIR' => $CONFIG['publish_dir'],
			'PUBLISH_DIR_ERROR' => $publish_dir_error,
			'TEMPLATE_OPTIONS' => $template_options,

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
			// Publish
			//
			'L_DOCUMENTS' => $lang['sd_p_Documents'],
			'L_FOLDERS' => $lang['sd_p_Folders'],
			'L_SIZE' => $lang['sd_p_Size'],
			'L_SENDTEMPLATES' => $lang['sd_p_SendTemplates'],
			'L_OPTIONMENU' => $lang['sd_p_optionMenu'],
			'L_OPTIONRAW' => $lang['sd_p_optionRaw'],
			'L_SENDZIP' => $lang['sd_p_SendZip'],
			'L_PUBLISHTEMPLATES' => $lang['sd_p_PublishTemplates'],
			'L_OPTIONSECTION' => $lang['sd_p_optionSection'],
			'L_PUBLISHDIR' => $lang['sd_p_PublishDir'],
			'L_PUBLISH' => $lang['sd_p_Publish'],

		));

	}
}
?>