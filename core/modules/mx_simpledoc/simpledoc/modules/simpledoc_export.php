<?php
/**
*
* @package MX-Publisher Module - mx_simpledoc
* @version $Id: simpledoc_export.php,v 1.3 2008/06/03 20:14:12 jonohlsson Exp $
* @copyright (c) 2002-2006 [wGEric, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

class mx_simpledoc_export extends mx_simpledoc_public
{
	function main( $action )
	{
		global $template, $lang, $db, $board_config, $phpEx, $simpledoc_config, $debug, $mx_root_path, $module_root_path, $CONTENT, $PUBLISH;

		$this->send_zip($CONTENT, 'content-'.date('Y-m-d').'.zip', 'content-'.date('Y-m-d'));
	}
}
?>