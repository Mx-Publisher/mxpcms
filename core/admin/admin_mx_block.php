<?php
/***************************************************************************
 *                          admin_mx_block.php
 *                            -------------------
 *   begin                : juin, 2002
 *   copyright            : (C) 2002 MX-System
 *   email                : support@mx-system.com
 *
 *   $Id: admin_mx_block.php,v 1.3 2005/12/05 22:25:11 jonohlsson Exp $
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
  	$module['2_CP']['2_3_BlockCP'] = 'admin/' . $file;

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

if( !empty($mode) ) 
{
  switch($mode)
  {
    case 'save_setting':
      $block_id = intval($HTTP_GET_VARS[block_id]);
      block_save_setting( $block_id );
      break;

    case 'add_block':
    case 'edit_block':
      block_edit( $mode );
      break;

    case 'create_block':
      block_create_block( );
      break;

    case 'delete_block':
      $block_id = intval($HTTP_GET_VARS[block_id]);
      block_delete( $block_id );
      break;

    case 'modify_block':
      $block_id = intval($HTTP_POST_VARS[block_id]);
      block_modify( $block_id );
      break;

    case 'setting':
      $block_id = intval($HTTP_GET_VARS[block_id]);
      block_setting( $block_id );
      break;

    default:
      mx_message_die(GENERAL_MESSAGE, $lang['No_mode']);
      break;
  }
  if ( ! $show_index )
  {
    exit;
  }
} // if .. !empty($mode)


//
// Start page proper
//
$template->set_filenames(array(
  "admin_block" => "admin/mx_block_admin_body.tpl")
);


$template->assign_vars(array(
  'S_ACTION'           => append_sid("admin_mx_block." . $phpEx . '?mode=add_block'),
  'L_TITLE'            => $lang['Block_admin'], 
  'L_EXPLAIN'          => $lang['Block_admin_explain'], 

  'U_PORTAL_ROOT_PATH' => PORTAL_URL,
  'TEMPLATE_ROOT_PATH' => TEMPLATE_ROOT_PATH,

  'L_CREATE_BLOCK'     => ( !empty ($lang['Create_block'] )) ? $lang['Create_block'] : 'Create new block' , 
  'L_EDIT'             => $lang['Edit'], 
  'L_SETTING'          => $lang['Settings'], 
  'L_DELETE'           => $lang['Delete'], 
  'L_MOVE_UP'          => $lang['Move_up'], 
  'L_MOVE_DOWN'        => $lang['Move_down'], 
  'L_RESYNC'           => $lang['Resync'] )
);

$sql = "SELECT blk.*, function_admin 
  FROM " . BLOCK_TABLE . " blk,
       " . FUNCTION_TABLE . " fnc
  WHERE blk.function_id = fnc.function_id
  ORDER BY  block_title";

if(!$q_blocks = $db->sql_query($sql))
{
  mx_message_die(GENERAL_ERROR, "Could not query blocks information", "", __LINE__, __FILE__, $sql);
}

if( $total_blocks = $db->sql_numrows($q_blocks) )
{
  $block_rows = $db->sql_fetchrowset($q_blocks);
}

//
// let's build lists of module
//
for($j = 0; $j < $total_blocks; $j++)
{
  $block_id = $block_rows[$j]['block_id'];
 
  if ( !empty( $block_rows[$j]['function_admin'] ) )
  {
    $l_setting = $lang['Settings'];
    $u_setting = append_sid( PORTAL_URL . $block_rows[$j]['function_admin'] . "?block_id=$block_id");
  }
  else
  {
    $u_setting = '';
    $l_setting = '';

// Show Block Settings even if no BLOCK_SYSTEM_PARAMETER_TABLE row exists. 
// admin_mx_block.php will populate them if necessary (see B4). 
$param_rows  = get_exists( PARAMETER_TABLE, 'function_id', $block_rows[$j]['function_id']); 
// $param_rows  = get_exists( BLOCK_SYSTEM_PARAMETER_TABLE, 'block_id', $block_id); 
    if ( $param_rows['number'] >0 )
    {
      $l_setting = $lang['Settings'];
      $u_setting = append_sid("admin_mx_block.$phpEx?mode=setting&amp;block_id=$block_id");
    }
  }
  
  $template->assign_block_vars("blockrow",  array(
    'L_SETTING'          => $l_setting, 
    'BLOCK_TITLE'       => $block_rows[$j]['block_title'],
    'BLOCK_DESC'        => $block_rows[$j]['block_desc'] ,
    'U_BLOCK_EDIT'      => append_sid("admin_mx_block.$phpEx?mode=edit_block&amp;block_id=$block_id"),
    'U_BLOCK_SETTING'   => $u_setting, 
    'U_BLOCK_DELETE'    => append_sid("admin_mx_block.$phpEx?mode=delete_block&amp;block_id=$block_id")
   ));
 
} // for ... blocks

include_once('./page_header_admin.'.$phpEx);

$template->pparse("admin_block");

include_once('./page_footer_admin.'.$phpEx);

// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// Begin function 
//
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------



// ******************************************************************
//
//
// ******************************************************************
function get_parameter_option($parameter_id, $id)
{
  global $db;

  $table = PARAMETER_OPTION_TABLE;
  $idfield = 'option_code';
  $namefield = 'option_desc';

  $sql = "SELECT * FROM " . $table;
  $sql .= " WHERE parameter_id = $parameter_id";
  $sql .= " order by $namefield ";

  if( !$result = $db->sql_query($sql) )
  {
    mx_message_die(GENERAL_ERROR, "Couldn't get list options parameter", "", __LINE__, __FILE__, $sql);
  }

  $column_list = "";

  while( $row = $db->sql_fetchrow($result) )
  {

    $s = "";
    if ($row[$idfield] == $id)
    {
      $s = " selected=\"selected\"";
    }
    $columnlist .= "<option value=\"$row[$idfield]\"$s>" . $row[$namefield] . "</option>\n";
  }

  return($columnlist);
}

// ******************************************************************
//
// Modify a block in the DB
//
// ******************************************************************
function block_modify( $block_id )
{
  global $template, $lang, $db, $board_config, $theme, $HTTP_POST_VARS;


  $sql = "UPDATE " . BLOCK_TABLE . "
    SET block_title     = '" . str_replace("\'", "''", $HTTP_POST_VARS['block_title']) . "', 
        block_desc      = '" . str_replace("\'", "''", $HTTP_POST_VARS['block_desc']) . "', 
        function_id     = " . intval($HTTP_POST_VARS['function_id']) . ", 
        auth_view       = '" . $HTTP_POST_VARS['auth_view'] . "' , 
        auth_edit       = '" . $HTTP_POST_VARS['auth_edit'] . "' ,
        auth_view_group       = '" . $HTTP_POST_VARS['auth_view_group'] . "' , 
        auth_edit_group       = '" . $HTTP_POST_VARS['auth_edit_group'] . "' , 
        auth_delete     = '" . intval($HTTP_POST_VARS['auth_delete']) . "' 
    WHERE block_id = " . $block_id;

  if( !$result = $db->sql_query($sql) )
  {
    mx_message_die(GENERAL_ERROR, "Couldn't update block information", "", __LINE__, __FILE__, $sql);
  }

  //
  // delete the old parameters when user change the fonction_id of a block
  //

  $sql = "SELECT parameter_id FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = " . $block_id;
  if( !$result = $db->sql_query($sql) )
	{
	  mx_message_die(GENERAL_ERROR, "Couldn't get block_system_parameter information", "", __LINE__, __FILE__, $sql);
	}
	$sys_param_rows = $db->sql_fetchrowset($result);

	for($p = 0; $p < count($sys_param_rows); $p++ )
  {

    $sql_cnt = "SELECT count(*) as total FROM " . PARAMETER_TABLE . 
               " WHERE function_id = " . intval($HTTP_POST_VARS['function_id']) .
               "   AND parameter_id = " . $sys_param_rows[$p]['parameter_id'];
    if( !$result_cnt = $db->sql_query($sql_cnt) )
  	{
  	  mx_message_die(GENERAL_ERROR, "Couldn't get block_system_parameter information", "", __LINE__, __FILE__, $sql_cnt);
	  }
  	$count = $db->sql_fetchrow($result_cnt);
   	$count = $count['total'];

    if ( $count == 0 )
    {
      $sql_del = "DELETE FROM  " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = $block_id AND parameter_id = " . $sys_param_rows[$p]['parameter_id'];
	    $result_del = $db->sql_query($sql_del);
  	}
	}

  //
  // insert the new parameters when user change the fonction_id of a block
  //
  $sql_cnt = "SELECT count(*) as total FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " WHERE block_id = " . $block_id;
  if( !$result = $db->sql_query($sql_cnt) )
	{
	  mx_message_die(GENERAL_ERROR, "Couldn't get block_system_parameter information", "", __LINE__, __FILE__, $sql);
	}
	$count = $db->sql_fetchrow($result);
 	$count = $count['total'];

  if ( $count == 0 )
  {
    $sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "( block_id, parameter_id, parameter_value ) SELECT " . $block_id . ", parameter_id,   parameter_default from " . PARAMETER_TABLE . " par " . 
           " WHERE function_id = " . intval($HTTP_POST_VARS['function_id']);
    if( !$result = $db->sql_query($sql) )
    {
      mx_message_die(GENERAL_ERROR, "Couldn't insert parameter information", "", __LINE__, __FILE__, $sql);
    }
  }
  $message = $lang['Portal_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_portal_config'], "<a href=\"" . append_sid("admin_mx_block.php") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");

  mx_message_die(GENERAL_MESSAGE, $message);
};
      

// ******************************************************************
//
// Delete a block in the DB
//
// ******************************************************************
function block_delete( $block_id )
{
  global $template, $lang, $db, $board_config, $theme, $HTTP_POST_VARS;


  $sql = "DELETE FROM " . BLOCK_TABLE . "
    WHERE block_id = " . $block_id;

  if( !$result = $db->sql_query($sql) )
  {
    mx_message_die(GENERAL_ERROR, "Couldn't delete block information", "", __LINE__, __FILE__, $sql);
  }

  $sql = "DELETE FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " 
    WHERE block_id = " . $block_id; 

  if( !$result = $db->sql_query($sql) ) 
  { 
    mx_message_die(GENERAL_ERROR, "Couldn't delete block information", "", __LINE__, __FILE__, $sql); 
  }

  $message = $lang['Portal_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_portal_config'], "<a href=\"" . append_sid("admin_mx_block.php") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");

  mx_message_die(GENERAL_MESSAGE, $message);
};
      

// ******************************************************************
//
// Create a block in the DB
//
// ******************************************************************
function block_create_block( )
{
  global $template, $lang, $db, $board_config, $theme, $HTTP_POST_VARS;

  //
  //
  if( trim($HTTP_POST_VARS['block_title']) == "" )
  {
    mx_message_die(GENERAL_ERROR, "Can't create a block without a name");
  }

  //
  // Default permissions of public :: 
  //
  $field_sql = "";
  $value_sql = "";
  
  $sql = "SELECT MAX(block_id) AS next_id FROM " . BLOCK_TABLE ;
  if( !$result = $db->sql_query($sql) )
  {
    mx_message_die(GENERAL_ERROR, "Couldn't insert row in blocks table", "", __LINE__, __FILE__, $sql);
  }

  $row = $db->sql_fetchrow($result);
  
  $next_id = $row[next_id] + 1;
  if ( empty( $next_id ))
  { 
    $next_id = 1;
  };
  
  $sql = "INSERT INTO " . BLOCK_TABLE . " (block_id, block_title, block_desc, function_id, auth_view, auth_edit, auth_delete ) 
             VALUES ('" . $next_id . "', 
                     '" . str_replace("\'", "''", $HTTP_POST_VARS['block_title']) . "',
                     '" . str_replace("\'", "''", $HTTP_POST_VARS['block_desc']) . "',
                     '" . $HTTP_POST_VARS['function_id'] . "', 
                     '" . $HTTP_POST_VARS['auth_view'] . "' , 
                     '" . $HTTP_POST_VARS['auth_edit'] . "' , 
                     '" . intval($HTTP_POST_VARS['auth_delete']) . "' )";
  
  if( !$result = $db->sql_query($sql) )
  {
    mx_message_die(GENERAL_ERROR, "Couldn't insert row in blocks table", "", __LINE__, __FILE__, $sql);
  }

  //
  // Insert the new parameter
  //
  $sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "( block_id, parameter_id, parameter_value ) SELECT " . $next_id . ", parameter_id,   parameter_default from " . PARAMETER_TABLE . " par " . 
         " WHERE function_id = " . $HTTP_POST_VARS['function_id'];
  if( !$result = $db->sql_query($sql) )
  {
    mx_message_die(GENERAL_ERROR, "Couldn't insert parameter information", "", __LINE__, __FILE__, $sql);
  }

  $message = $lang['Portal_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_portal_config'], "<a href=\"" . append_sid("admin_mx_block.php") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");

  mx_message_die(GENERAL_MESSAGE, $message);

  break;
};


// ******************************************************************
//
//
// ******************************************************************
function block_edit( $mode )
{
  global $template, $lang, $db, $board_config, $theme, $HTTP_GET_VARS, $HTTP_POST_VARS;

  $block_auth_fields = array('auth_view', 'auth_edit'); // , 'auth_delete'
  $block_auth_group_fields = array('auth_view_group', 'auth_edit_group'); // , 'auth_delete'

      // "auth_delete" => AUTH_MOD
 
  $block_auth_ary = array(
    "auth_view"   => AUTH_ALL,
    "auth_edit"   => AUTH_MOD 
  );
  
  $block_auth_levels = array('ALL', 'REG', 'PRIVATE', 'MOD', 'ADMIN', 'ANONYMOUS');
  $block_auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN, AUTH_ANONYMOUS);
  
  
  //	'auth_delete' => $lang['Delete']
  $field_names = array(
  	'auth_view' => $lang['View'],
  	'auth_edit' => $lang['Edit']);

  //
  // Show form to create/modify a block
  //
  if ($mode == 'edit_block')
  {
    // $newmode determines if we are going to INSERT or UPDATE after posting?

    $l_title = $lang['Edit_block'];
    $newmode = 'modify_block';
    $buttonvalue = $lang['Update'];

    $block_id = intval($HTTP_GET_VARS[block_id]);

    $row = get_info( BLOCK_TABLE, 'block_id', $block_id);


    $blocktitle   = $row['block_title'];
    $blockdesc    = $row['block_desc'];
    $function_id  = $row['function_id'];
	$page_group_auth_id = array();
    $page_group_auth_id[0]   = $row['auth_view_group'];
    $page_group_auth_id[1]   = $row['auth_edit_group'];
	
	
  }
  else
  {
    $l_title = $lang['Create_block'];
    $newmode = 'create_block';
    $buttonvalue = $lang['Create_block'];
    $blocktitle = $HTTP_POST_VARS[block_name];
    $blockdesc = '';
    $block_id = ''; 
    $function_id = ''; 
  }


  $functionlist = get_list( "function_id", FUNCTION_TABLE, 'function_id', 'function_name', $function_id, TRUE);

  $template->set_filenames(array(
    "edit_block" => "admin/mx_block_edit_body.tpl")
  );

  $template->set_filenames(array(
    "edit_block2" => "posting_body.tpl")
  );

  $s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode .'" /><input type="hidden" name="block_id" value="' . $block_id . '" />';

  //

  //
  // Output values of individual
  // fields
  //
  for($j = 0; $j < count($block_auth_fields); $j++)
  {
  	$custom_auth[$j] = '&nbsp;<select name="' . $block_auth_fields[$j] . '">';
  
  	for($k = 0; $k < count($block_auth_levels); $k++)
  	{
  		$selected = ( $row[$block_auth_fields[$j]] == $block_auth_const[$k] ) ? ' selected="selected"' : '';
  		$custom_auth[$j] .= '<option value="' . $block_auth_const[$k] . '"' . $selected . '>' . $lang['AUTH_' . $block_auth_levels[$k]] . '</option>';
  	}
  	$custom_auth[$j] .= '</select>&nbsp;';

	$custom_group_auth[$j] = mx_get_groups($page_group_auth_id[$j], $block_auth_group_fields[$j]);
  
  	$cell_title = $field_names[$block_auth_fields[$j]];
  
  	$template->assign_block_vars('block_auth_titles', array(
  		'CELL_TITLE' => $cell_title)
  	);
  	$template->assign_block_vars('block_auth_data', array(
  		'S_AUTH_GROUP_LEVELS_SELECT' => $custom_group_auth[$j],
		'L_AUTH_GROUP_LEVELS_SELECT' => $lang['Auth_Page_group'],
  		'S_AUTH_LEVELS_SELECT' => $custom_auth[$j])
  	);

  	$s_column_span++;
  }

  $template->assign_vars(array(
    'L_TITLE'       => $lang['Block_admin'], 
    'L_EXPLAIN'     => $lang['Block_admin_explain'], 
    'L_BLOCK_TITLE' => $lang['Block_title'], 
    'L_BLOCK_DESC'  => $lang['Block_desc'], 
  	'L_AUTH_TITLE'  => $lang['Auth_Block'],
    'L_FUNCTION'    => $lang['Function'], 

    'BLOCK_TITLE'      => $blocktitle,
    'BLOCK_DESC'       => $blockdesc,

    'S_ACTION'         => append_sid("admin_mx_block.php"),
    'S_HIDDEN_FIELDS'  => $s_hidden_fields,
    'S_SUBMIT_VALUE'   => $buttonvalue, 
    'S_FUNCTION_LIST'  => $functionlist,

  ));


  define('IN_ADMIN', 1);
  include('./page_header_admin.php');
  $template->pparse("edit_block");

  include('./page_footer_admin.php');

};


// ******************************************************************
//
//
// ******************************************************************
function block_setting( $block_id )
{
  global $template, $lang, $db, $board_config, $theme, $HTTP_GET_VARS, $HTTP_POST_VARS, $phpEx, $mx_root_path;

  //
  // Generate Layout for each block parameter
  //
  $block_rows   = get_info( BLOCK_TABLE, 'block_id', $block_id);
  $function_row = get_info( FUNCTION_TABLE, 'function_id', $block_rows[function_id]);
  $module_row   = get_info( MODULE_TABLE  , 'module_id', $function_row[module_id]);

  $module_path = $mx_root_path . $module_row[module_path];


  if ( file_exists($module_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.'.$phpEx) )
  {
		include($module_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
	}
	else if ( file_exists($module_path . 'language/lang_english/lang_main.'.$phpEx) )
	{
		include($module_path . 'language/lang_english/lang_main.' . $phpEx);
	}

  if ( file_exists($module_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.'.$phpEx) )
  {
		include($module_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
	}
	else if ( file_exists($module_path . 'language/lang_english/lang_admin.'.$phpEx) )
	{
		include($module_path . 'language/lang_english/lang_admin.' . $phpEx);
	}



  //
  // Insert the new parameter
  // SB05
  $sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "( block_id, parameter_id, parameter_value ) SELECT " . $block_id . ", parameter_id,   parameter_default from " . PARAMETER_TABLE . " par " . 
         " WHERE function_id = " . $block_rows[function_id];
//         " WHERE function_id = " . intval($HTTP_POST_VARS['function_id']);
		 
  if( !$result = $db->sql_query($sql) )
  {
// If you encounter duplicate errors, simply comment out next mx message die line ;)  
//    mx_message_die(GENERAL_ERROR, "Couldn't insert parameter information", "", __LINE__, __FILE__, $sql);
  }

  //
  // 
  //
  $template->set_filenames(array(
    "edit_block" => "admin/mx_block_setting_body.tpl")
  );

  $newmode = 'save_setting';
  $s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="block_id" value="' . $block_id . '" />';

  //
  // Find which block are visible for this user
  //
  $template->assign_vars(array(
    'BLOCK_TITLE'       => $block_rows['block_title'],
    'S_HIDDEN_FIELDS' => $s_hidden_fields, 
    'S_SUBMIT_VALUE'    => $lang['Update']
  ));
  
  //
  // Generate Layout for each block parameter
  //
  $sql = "SELECT sys.parameter_id, par.parameter_name, sys.parameter_value, par.parameter_type, par.parameter_function, sys.bbcode_uid
      FROM " . BLOCK_SYSTEM_PARAMETER_TABLE    . " sys,
           " . PARAMETER_TABLE . " par
      WHERE sys.parameter_id = par.parameter_id
        AND sys.block_id = $block_id
      ORDER BY parameter_id";
        
  if(!$q_parameters = $db->sql_query($sql))
  {
    mx_message_die(GENERAL_ERROR, "Could not query parameter information", "", __LINE__, __FILE__, $sql);
  }
  
  if( $total_parameter = $db->sql_numrows($q_parameters) )
  {
    $parameter_rows = $db->sql_fetchrowset($q_parameters);
  }
  
  for($param = 0; $param < $total_parameter; $param++)
  {
    //
    // Find which block are visible for this user
    //
    $parameter_id      = $parameter_rows[$param][parameter_id];
    $parameter_name    = $parameter_rows[$param][parameter_name];
    $parameter_type    = $parameter_rows[$param][parameter_type];
   	$parameter_value   = $parameter_rows[$param]['parameter_value'];
   	$parameter_function= $parameter_rows[$param]['parameter_function'];
   	$bbcode_uid        = $parameter_rows[$param][bbcode_uid];

    switch($parameter_type)
    {
      case 'Text':
        $parameter_field = '<input type="text" maxlength="150" size="30" name="' . $parameter_id . '" value="' . $parameter_value . '" />';
        break;
	  case 'TextArea': 
  		$parameter_field = '<textarea rows="20" cols="100" wrap="virtual" name="' . $parameter_id . '" class="post">' . $parameter_value . '</textarea>'; 
  	  break;		
      case 'BBText' :
        $parameter_value = preg_replace("/\:(([a-z0-9]:)?)$bbcode_uid/si", '', $parameter_value);
        $parameter_value = str_replace('<br />', "\n", $parameter_value);
        $parameter_value = preg_replace('#</textarea>#si', '&lt;/textarea&gt;', $parameter_value);

        $parameter_field = '<textarea rows="20" cols="100" wrap="virtual" name="' . $parameter_id . '" class="post">' . $parameter_value . '</textarea>';
        break;
      case 'Html' :
        $parameter_field = '<textarea rows="20" cols="100" wrap="virtual" name="' . $parameter_id . '" class="post">' . $parameter_value . '</textarea>';
        break;
      case 'Number':
        $parameter_field = '<input type="text" maxlength="5" size="5" name="' . $parameter_id . '" value="' . $parameter_value . '" />';
        break;
      case 'Boolean':
        $selected_true = '';
        $selected_false = '';
        if ( $parameter_value == 'TRUE' )
        {
          $selected_true = 'SELECTED';
        }
        else
        {
          $selected_false = 'SELECTED';
        }
        $parameter_field = '<select name="' . $parameter_id . '">' .
                    '<option value="TRUE"  ' . $selected_true  . '>TRUE </option>' .
                    '<option value="FALSE" ' . $selected_false . '>FALSE </option>' .
                    '</select>';

        break;
      case 'Function':
        $parameter_function = str_replace("{parameter_value}", $parameter_value  , $parameter_function );
        $parameter_function = str_replace("{parameter_id}", $parameter_id  , $parameter_function );
         
        $parameter_field = eval("return " . $parameter_function . ";"); 

        break;

      case 'Values':

        $parameter_field = '<select name="' . $parameter_id . '">';
        $parameter_field .= get_parameter_option($parameter_id, $parameter_value);
        $parameter_field .= '</select>';
        break;

    }

  	$template->assign_block_vars('param_row', array(
   		'PARAMETER_LABEL' => ( ! empty( $lang[$parameter_name] ) ) ? $lang[$parameter_name] : $parameter_name,
   		'PARAMETER_INFO' => $lang[$parameter_name . "info"] ,
   		'PARAMETER_FIELD' => $parameter_field
    ));
  
  } // for ... parameter
  
  define('IN_ADMIN', 1);
  include('./page_header_admin.php');
  $template->pparse("edit_block");

  include('./page_footer_admin.php');

};

// ******************************************************************
//
//
// ******************************************************************
function block_save_setting( $block_id )
{
  global $template, $lang, $db, $board_config, $theme, $HTTP_POST_VARS;
  
  while( list($param_id, $param_value)	= each( $HTTP_POST_VARS ) )
  {
    if ( !( $param_id == "mode" || $param_id == "submit" || $param_id == "block_id" ))
    {
      if ( is_array( $param_value ))
      {
        $param_value = implode( ',' , $param_value);
      }
  
      $param_info = get_info( PARAMETER_TABLE, 'parameter_id', intval( $param_id ) );
      
      if ( $param_info[parameter_type] == 'BBText')
      {
        $bbcode_uid = make_bbcode_uid();
        $param_value = prepare_message($param_value, true, true, true, $bbcode_uid);
      };  
      
      $sql = "UPDATE " . BLOCK_SYSTEM_PARAMETER_TABLE . "
        SET parameter_value = '$param_value',
            bbcode_uid      = '$bbcode_uid'
        WHERE block_id = '$block_id' 
          AND parameter_id = '$param_id' ";
      
      if( !$db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't update system parameter table", "", __LINE__, __FILE__, $sql);
      }
    }
  }

  $message = $lang['Portal_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_portal_config'], "<a href=\"" . append_sid("admin_mx_block.php") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.php?pane=right") . "\">", "</a>");
  mx_message_die(GENERAL_MESSAGE, $message);

}

?>