<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: simpledoc_publish_export.php,v 1.3 2008/06/03 20:14:12 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

class mx_simpledoc_publish_export extends mx_simpledoc_public
{
	function main( $action )
	{
		global $template, $lang, $db, $board_config, $phpEx, $simpledoc_config, $debug, $mx_root_path, $module_root_path, $CONTENT, $PUBLISH, $CHMOD_FILE, $CHMOD_DIR, $SORT, $mx_simpledoc_functions;
		global $mx_page, $simpledoc_projectName;

		$template = get('template');
		$publish_dir = get('publish_dir');
		$section = get('section');

		switch ($template) {
		    case 'tree':
		    case 'drop':
		    case 'raw':
		        $DIR = "publish-$template-".date('Y-m-d');
		        $TMP = $PUBLISH.'/tmp-'.$DIR;
		        $SECTION = $section ? $CONTENT.'/'.$section : $CONTENT;
		        if ($publish_dir)
		        {
		            IoDir::delete($PUBLISH, false);
		            include $module_root_path . "simpledoc/shared/publish/$template.php";
		            IoDir::copy($TMP, $PUBLISH, $CHMOD_FILE, $CHMOD_DIR);
		            IoDir::delete($TMP);
		            sugolib_redirect($module_root_path . 'redirect.php?msg=Published+successfully&url=./../../index.php?page=' . $mx_page->page_id . '&mode=publish');
		        }
		        else
		        {
		            include $module_root_path . "simpledoc/shared/publish/$template.php";
		            $this->send_zip_clear($TMP, $DIR.'.zip', $DIR);
		        }
		        break;
		    default:
		        echo 'Unknown template.';
		        exit;
		        break;
		}

	}
}
?>