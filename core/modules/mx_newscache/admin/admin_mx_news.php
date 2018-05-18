<?php
/***************************************************************************
 *                             admin_mx_last_msg.php
 *                            -------------------
 *   begin                : may, 2002
 *   copyright            : (C) 2002 MX-System
 *   email                : support@mx-system.com
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
//namespace orynider\mx_newscache\acp;
$basename = basename( __FILE__);
$mx_root_path = './../../../';
$module_root_path = $mx_root_path . 'modules/mx_newscache/';
$admin_module_root_path = $module_root_path . 'admin/';

/* */
if ( !empty( $setmodules))
{	
	$module['News_Module']['News_Module'] = mx_append_sid( $admin_module_root_path . $basename . '?mode=config');	
	return;
}
/* */

define('IN_PORTAL', 1);
define('IN_ADMIN', 1);
$phpEx = substr( __FILE__, strrpos( __FILE__, '.') + 1);
//
// Start session management
//
define('PAGE_NEWS_ADMIN', -52);
//
// End session management
//

//
// Load default header
//
require_once($mx_root_path . 'admin/pagestart.' . $phpEx);


if( $userdata['user_level'] != ADMIN )
{
	mx_message_die(GENERAL_MESSAGE, $lang['Not_admin']);
}

//
// Get general music information
//
include_once($module_root_path . 'includes/mx_constants.'.$phpEx);
// **********************************************************************
//  Read language definition
// **********************************************************************

if ( !file_exists($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.'.$phpEx ) )
{
  include( $module_root_path . 'language/lang_english/lang_main.'.$phpEx );
}
else
{
  include(  $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.'.$phpEx );
}  

include_once( $mx_root_path . 'admin/page_header_admin.'.$phpEx);


//
// Begin program proper
//
$mode = "";

if( isset($_POST['submit']) )
{
  $mode = "submit";
}


if( !empty($mode) ) 
{ 
  $new['news_title']               = $_POST['News_Title']   ;
  $new['news_xml_file']            = $_POST['News_Xml_File']   ;
  $new['news_folder']              = $_POST['News_Folder']   ;

  $sql = "UPDATE " . CONFIG_NEWS_TABLE . " SET " .
        "news_title              = '" . str_replace("\'", "''", $new['news_title'])    . "'," .
        "news_folder             = '" . str_replace("\'", "''", $new['news_folder'])   . "'," .
        "news_xml_file           = '" . str_replace("\'", "''", $new['news_xml_file']) . "'" ;

  if( !$db->sql_query($sql) )
  {
    mx_message_die(GENERAL_ERROR, "Failed to update last messages configuration ", "", __LINE__, __FILE__, $sql);
  }

  $message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_mx_news.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid( $mx_root_path . "admin/index.$phpEx?pane=right") . "\">", "</a>");

  mx_message_die(GENERAL_MESSAGE, $message);

}
else
{
  $template->set_filenames(array(
    "admin_news" => "admin/mx_news_admin.tpl")
  );

  // **********************************************************************
  //  Read module config
  // **********************************************************************
  include_once( $module_root_path . 'includes/mx_functions.'.$phpEx);
  
  $config = read_news_config();
  
  //
  $checked_on = 'checked';
  $checked_off = '';  

  $template->assign_vars(array(
    "S_CONFIG_ACTION" => mx_append_sid("admin_mx_news.$phpEx"),

    "L_CONFIGURATION_TITLE"   => $lang['News_Module'],
    "L_CONFIGURATION_EXPLAIN" => $lang['News_Settings'],

    "L_YES" => $lang['Yes'],
    "L_NO" => $lang['No'],
    "L_NEWS_SETTINGS"         => $lang['News_Settings'],

    "L_NEWS_BLOCK_TITLE"       => $lang['News_Block_Title'] ,
    "L_NEWS_XML_FILE"          => $lang['News_Xml_File'] ,
    "L_NEWS_FOLDER"            => $lang['News_Folder'] ,

    "NEWS_TITLE"               => $config['news_title'],
    "NEWS_XML_FILE"            => $config['news_xml_file'],
    "NEWS_FOLDER"              => $config['news_folder'],

    "L_SUBMIT"                 => $lang['Submit'],
    "L_RESET"                  => $lang['Reset'],

    )
  );

  $template->pparse('admin_news');

}


include_once( $mx_root_path . 'admin/page_footer_admin.'.$phpEx);
?>
