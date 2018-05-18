<?php
/***************************************************************************
 *                    admin_mx_page_setting.php
 *                            -------------------
 *   begin                : november, 2002
 *   copyright            : (C) 2002 MX-System
 *   email                : support@mx-system.com
 *
 *   $Id: admin_mx_page_setting.php,v 1.3 2005/12/05 22:25:11 jonohlsson Exp $
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

$no_page_header = TRUE;

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['2_CP']['2_5_PageCP_settings'] = 'admin/' . $file;

  return;
}

//
// Security and Page header
//
define('IN_PORTAL', 1);
$mx_root_path = './../';
require($mx_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Mode setting
//
if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
  $mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
}
else
{
  $mode = "";
}


if( isset($HTTP_POST_VARS['page_id']) || isset($HTTP_GET_VARS['page_id']) )
{
  $page_id = ( isset($HTTP_POST_VARS['page_id']) ) ? $HTTP_POST_VARS['page_id'] : $HTTP_GET_VARS['page_id'];
}
else
{
  $page_id = 1;
}

if( isset($HTTP_POST_VARS['addcolumn']) )
{
  $mode = "addcolumn";
}

if( isset($HTTP_POST_VARS['addpage']) )
{
  $mode = "addpage";
}


if( isset($HTTP_POST_VARS['insertcolumn']) )
{
  $mode = "insertcolumn";
}

function renumber_order($mode, $column = 0, $page_id)
{
  global $db;

  switch($mode)
  {
    case 'column':
      $table = COLUMN_TABLE;
      $idfield = 'column_id';
      $orderfield = 'column_order';
      $column = 0;
      break;

    case 'block':
      $table = COLUMN_BLOCK_TABLE;
      $idfield = 'block_id';
      $orderfield = 'block_order';
      $columnfield = 'column_id';
      break;

    default:
      mx_message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
      break;
  }

  $sql = "SELECT * FROM $table";

  if( $column != 0)
  {
    $sql .= " WHERE $columnfield = $column";
  }
  else
  {
    $sql .= " WHERE page_id = $page_id ";
  }
  $sql .= " ORDER BY $orderfield ASC";

  if( !$result = $db->sql_query($sql) )
  {
    mx_message_die(GENERAL_ERROR, "Couldn't get list of Column", "", __LINE__, __FILE__, $sql);
  }

  $i = 10;
  $inc = 10;

  while( $row = $db->sql_fetchrow($result) )
  {
    $sql = "UPDATE $table
      SET $orderfield = $i
      WHERE $idfield = " . $row[$idfield];
    if( !$db->sql_query($sql) )
    {
      mx_message_die(GENERAL_ERROR, "Couldn't update order fields", "", __LINE__, __FILE__, $sql);
    }
    $i += 10;
  }

}
//
// End function block
// ------------------

//
// Begin program proper
//

if( !empty($mode) ) 
{
  switch($mode)
  {
    case 'addpage':
      $page_name = $HTTP_POST_VARS['pagename'];

      $sql = "INSERT INTO " . PAGE_TABLE . " ( page_name )
        VALUES ( '$page_name' )";

      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't add new page", "", __LINE__, __FILE__, $sql);
      }

      $message = $lang['Page_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_page_admin'], "<a href=\"" . append_sid("admin_mx_page_setting.php?page_id=$page_id") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");

      mx_message_die(GENERAL_MESSAGE, $message);

      break;
    
    case 'block_order':
      //
      // Change order of blocks in the DB
      //
      $move = intval($HTTP_GET_VARS['move']);
      $column_id = intval($HTTP_GET_VARS[column_id]);
      $block_id = intval($HTTP_GET_VARS[block_id]);

      $sql = "UPDATE " . COLUMN_BLOCK_TABLE . "
        SET block_order = block_order + $move
        WHERE column_id = $column_id
          AND block_id  = $block_id ";
      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't change column order", "", __LINE__, __FILE__, $sql);
      }

      renumber_order('block', $column_id, $page_id );
      $show_index = TRUE;

      break;
      
    case 'column_order':
      //
      // Change order of column in the DB
      //
      $column_id = intval($HTTP_GET_VARS[column_id]);
      $move = intval($HTTP_GET_VARS['move']);

      $sql = "UPDATE " . COLUMN_TABLE . "
        SET column_order = column_order + $move
        WHERE column_id = $column_id";
      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't change column order", "", __LINE__, __FILE__, $sql);
      }

      renumber_order('column', 0, $page_id);
      $show_index = TRUE;

      break;

    case 'block_sync':
      $column_id = intval($HTTP_GET_VARS[column_id]);
      sync('block', intval($HTTP_GET_VARS[block_id]));
      $show_index = TRUE;

      break;

    case 'addblock':
  		list($column_id) = each($HTTP_POST_VARS['addblock']);

      $block_id = $HTTP_POST_VARS['block_id'][$column_id];

      $sql = "INSERT INTO " . COLUMN_BLOCK_TABLE . " (column_id,  block_id,  block_order )
        VALUES ( $column_id, $block_id, 9999 )";

      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't add new block", "", __LINE__, __FILE__, $sql);
      }

      renumber_order('block', $column_id, $page_id);

      $message = $lang['Page_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_page_admin'], "<a href=\"" . append_sid("admin_mx_page_setting.php?page_id=$page_id") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");

      mx_message_die(GENERAL_MESSAGE, $message);

      break;

    case 'deleteblock':
      $block_id = ( isset($HTTP_POST_VARS['block_id']) ) ? $HTTP_POST_VARS['block_id'] : $HTTP_GET_VARS['block_id'];
      $column_id = ( isset($HTTP_POST_VARS['column_id']) ) ? $HTTP_POST_VARS['column_id'] : $HTTP_GET_VARS['column_id'];
      $sql = "DELETE FROM " . COLUMN_BLOCK_TABLE . " WHERE block_id = $block_id AND column_id = $column_id";
      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't delete the block information", "", __LINE__, __FILE__, $sql);
      }

      $message = $lang['Page_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_page_admin'], "<a href=\"" . append_sid("admin_mx_page_setting.php?page_id=$page_id") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");

      mx_message_die(GENERAL_MESSAGE, $message);

      break;

    case 'addcolumn':
    case 'editcolumn':
      //
      // Show form to edit a column
      //
      $column_id = intval($HTTP_GET_VARS[column_id]);

      $s_hidden_fields = '<input type="hidden" name="column_id" value="' . $column_id . '" />';

      if ( $column_id == 0 )
      {
        $buttonvalue = $lang['Submit'];
        $newmode = 'insertcolumn';
        $column_title = $HTTP_POST_VARS['columnname'];
        $column_size =  "100%";
      }
      else
      {
        $buttonvalue = $lang['Update'];
        $newmode = 'modcolumn';
        $row = get_info( COLUMN_TABLE, 'column_id', $column_id );
        $column_title = $row['column_title'] ;
        $column_size =  $row['column_size']  ;
      }
      $template->set_filenames(array(
        "edit_column" => "admin/mx_page_admin_column.tpl")
      );

      $s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="column_id" value="' . $column_id . '" />';

      $template->assign_vars(array(
        'COLUMN_TITLE'  => $column_title,
        'L_EDIT_COLUMN' => $lang['Edit_Column'], 
        'L_EDIT_COLUMN_EXPLAIN' => $lang['Edit_Column_explain'], 
        'L_COLUMN' => $lang['Column'], 
    
        'L_COLUMN_SIZE'    => $lang['Column_Size'] ,
        'COLUMN_SIZE'      => $column_size,

        'S_HIDDEN_FIELDS' => $s_hidden_fields, 
        'S_SUBMIT_VALUE' => $buttonvalue)
      );

      define('IN_ADMIN', 1);
      include_once('./page_header_admin.'.$phpEx);
      $template->pparse("edit_column");
      break;

    case 'insertcolumn':
      // Create a column in the DB

      $sql = "SELECT MAX(column_order) AS max_order
        FROM " . COLUMN_TABLE;
      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't get order number from column table", "", __LINE__, __FILE__, $sql);
      }
      $row = $db->sql_fetchrow($result);

      $max_order = $row['max_order'];
      $next_order = $max_order + 10;

      //
      // There is no problem having duplicate page names so we won't check for it.
      //
      $sql = "INSERT INTO " . COLUMN_TABLE . " (column_title, column_order, column_size, page_id)
        VALUES ('" . $HTTP_POST_VARS['column_title'] . "',  $next_order, '" . $HTTP_POST_VARS['column_size'] . "', $page_id)";
      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't insert row in column table", "", __LINE__, __FILE__, $sql);
      }

      $message = $lang['Page_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_page_admin'], "<a href=\"" . append_sid("admin_mx_page_setting.php?page_id=$page_id") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");

      mx_message_die(GENERAL_MESSAGE, $message);

      break;

    case 'modcolumn':
      // Modify a column in the DB
      
      $sql = "UPDATE " . COLUMN_TABLE . "
        SET column_title = '" . str_replace("\'", "''", $HTTP_POST_VARS['column_title']) . "'
          , column_size  = '" . str_replace("\'", "''", $HTTP_POST_VARS['column_size']) . "'
        WHERE column_id = " . intval($HTTP_POST_VARS[column_id]);
        
      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't update block information", "", __LINE__, __FILE__, $sql);
      }

      $message = $lang['Page_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_page_admin'], "<a href=\"" . append_sid("admin_mx_page_setting.php?page_id=$page_id") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");
      mx_message_die(GENERAL_MESSAGE, $message);

      break;

    case 'deletecolumn' :
      // Modify a column in the DB
      $sql = "DELETE FROM " . COLUMN_BLOCK_TABLE . "
        WHERE column_id = " . intval($HTTP_GET_VARS[column_id]);
      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't delete column/block information", "", __LINE__, __FILE__, $sql);
      }
      
      $sql = "DELETE FROM " . COLUMN_TABLE . " WHERE column_id = " . intval($HTTP_GET_VARS[column_id]) ;
      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't delete column information", "", __LINE__, __FILE__, $sql);
      }
      $message = $lang['Page_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_page_admin'], "<a href=\"" . append_sid("admin_mx_page_setting.php?page_id=$page_id") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");
      mx_message_die(GENERAL_MESSAGE, $message);

      break;

    default:
      print( $mode );
      mx_message_die(GENERAL_MESSAGE, $lang['No_mode']);
      break;
  }


  if ($show_index != TRUE)
  {
    include_once('./page_footer_admin.'.$phpEx);
    exit;
  }
}

//
// Start page proper
//
$template->set_filenames(array(
  "admin_page" => "admin/mx_page_admin_body.tpl")
);


$pagelist = get_list( "page_id", PAGE_TABLE, 'page_id', 'page_name', $page_id, TRUE);


$template->assign_vars(array(
  'S_ACTION'           => append_sid("admin_mx_page_setting.$phpEx?mode=addblock&amp;page_id=$page_id"),
  'S_PAGE_ACTION'      => append_sid("admin_mx_page_setting.$phpEx?page_id=$page_id"),
  'L_TITLE'            => $lang['Page_admin'], 
  'L_EXPLAIN'          => $lang['Page_admin_explain'], 

  'U_PHPBB_ROOT_PATH'       => PHPBB_URL,
  'TEMPLATE_ROOT_PATH'      => TEMPLATE_ROOT_PATH,
  'PAGELIST'                => $pagelist,
  'L_CREATE_PAGE'           => $lang['Add_Page'], 
  'L_CREATE_BLOCK'          => $lang['Add_Block'], 
  'L_PAGE'                  => $lang['Page']  ,
  'L_CREATE_COLUMN'         => $lang['Create_column'], 
  'L_EDIT'                  => $lang['Edit'], 
  'L_DELETE'                => $lang['Delete'], 
  'L_SETTING'               => $lang['Settings'], 
  'L_MOVE_UP'               => $lang['Move_up'], 
  'L_MOVE_DOWN'             => $lang['Move_down'], 
  'L_CHANGE_NOW'            => $lang['Change'], 
  'L_RESYNC'                => $lang['Resync'] )
);


$sql = "SELECT column_id, column_title, column_order
  FROM " . COLUMN_TABLE . "
  WHERE page_id = $page_id
  ORDER BY page_id, column_order";

if( !$q_column = $db->sql_query($sql) )
{
  mx_message_die(GENERAL_ERROR, "Could not query column list", "", __LINE__, __FILE__, $sql);
}

if( $total_column = $db->sql_numrows($q_column) )
{
  $column_rows = $db->sql_fetchrowset($q_column);

// added column blk.function_id 
$sql = "SELECT cbl.*, blk.block_title, blk.block_desc, function_admin, blk.function_id 
   FROM " . COLUMN_BLOCK_TABLE . " cbl, 
   " . BLOCK_TABLE . " blk, 
   " . FUNCTION_TABLE . " fnc 
   WHERE blk.function_id = fnc.function_id 
   AND blk.block_id = cbl.block_id 
   ORDER BY column_id, block_order"; 
  if(!$q_blocks = $db->sql_query($sql))
  {
    mx_message_die(GENERAL_ERROR, "Could not query blocks information", "", __LINE__, __FILE__, $sql);
  }

  if( $total_blocks = $db->sql_numrows($q_blocks) )
  {
    $block_rows = $db->sql_fetchrowset($q_blocks);
  }

  //
  // Okay, let's build the index
  //
  for($i = 0; $i < $total_column; $i++)
  {
    $column_id = $column_rows[$i]['column_id'];
 
    $s_hidden_fields   = '<input type="hidden" name="column_id[$column_id]" value="' . $column_id . '" />';

    $blocklist = get_list( "block_id[$column_id]", BLOCK_TABLE, 'block_id', 'block_title', 0, TRUE);

    $template->assign_block_vars("columnrow", array( 
      'S_HIDDEN_FIELDS'    => $s_hidden_fields,
      'COLUMN_ID'   => $column_id,
      'COLUMN_DESC' => $column_rows[$i]['column_title'],
      'S_ADD_BLOCK_SUBMIT' => "addblock[$column_id]", 
      'LIST_BLOCK'         => $blocklist, 

      'U_COLUMN_EDIT'      => append_sid("admin_mx_page_setting.$phpEx?mode=editcolumn&amp;column_id=$column_id&amp;page_id=$page_id"),
      'U_COLUMN_DELETE'    => append_sid("admin_mx_page_setting.$phpEx?mode=deletecolumn&amp;column_id=$column_id&amp;page_id=$page_id"),
      'U_COLUMN_MOVE_UP'   => append_sid("admin_mx_page_setting.$phpEx?mode=column_order&amp;move=-15&amp;column_id=$column_id&amp;page_id=$page_id"),
      'U_COLUMN_MOVE_DOWN' => append_sid("admin_mx_page_setting.$phpEx?mode=column_order&amp;move=15&amp;column_id=$column_id&amp;page_id=$page_id"),
      'U_VIEWCOLUMN'       => append_sid( PHPBB_URL ."index.$phpEx?column_id=$column_id&amp;page_id=$page_id"))
    );


    for($j = 0; $j < $total_blocks; $j++)
    {
      $block_id = $block_rows[$j]['block_id'];

      if ( !empty( $block_rows[$j]['function_admin'] ) )
      {
        $l_setting = $lang['Settings'];
        $u_setting = append_sid( PORTAL_URL . $block_rows[$j]['function_admin'] . "?block_id=$block_id&amp;page=$page_id");
      }
      else
      {
        $u_setting = '';
        $l_setting = '';
    
        // Show Block Settings even if no BLOCK_SYSTEM_PARAMETER_TABLE row exists. 
		// admin_mx_block.php will populate them if necessary (see B4). 
		$param_rows = get_exists( PARAMETER_TABLE, 'function_id', $block_rows[$j]['function_id']);
        if ( $param_rows['number'] >0 )
        {
          $l_setting = $lang['Settings'];
          $u_setting = append_sid("admin_mx_block.$phpEx?mode=setting&amp;block_id=$block_id");
        }
      }

      if ($block_rows[$j]['column_id'] == $column_id)
      {
        $template->assign_block_vars("columnrow.blockrow",  array(
          'L_SETTING'          => $l_setting, 

          'BLOCK_NAME'         => $block_rows[$j]['block_title'],
          'BLOCK_DESC'         => $block_rows[$j]['block_desc'], 
          'ROW_COLOR'          => $row_color,
          'U_BLOCK_EDIT'       => append_sid("admin_mx_block.php?mode=edit_block&amp;block_id=$block_id"),
          'U_BLOCK_SETTING'    => $u_setting,

          'U_BLOCK_DELETE'    => append_sid("admin_mx_page_setting.$phpEx?mode=deleteblock&amp;block_id=$block_id&amp;column_id=$column_id&amp;page_id=$page_id"),
          'U_BLOCK_MOVE_UP'   => append_sid("admin_mx_page_setting.$phpEx?mode=block_order&amp;move=-15&amp;block_id=$block_id&amp;column_id=$column_id&amp;page_id=$page_id"),
          'U_BLOCK_MOVE_DOWN' => append_sid("admin_mx_page_setting.$phpEx?mode=block_order&amp;move=15&amp;block_id=$block_id&amp;column_id=$column_id&amp;page_id=$page_id"),
          'U_BLOCK_RESYNC'    => append_sid("admin_mx_page_setting.$phpEx?mode=block_sync&amp;block_id=$block_id&amp;column_id=$column_id&amp;page_id=$page_id"))
        );

      }// if ... column_id == column_id
      
    } // for ... blocks

  } // for ... column

}// if ... total_categories

include_once('./page_header_admin.'.$phpEx);

$template->pparse("admin_page");

include_once('./page_footer_admin.'.$phpEx);

?>
