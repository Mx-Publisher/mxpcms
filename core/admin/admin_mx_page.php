<?php
/***************************************************************************
 *                    admin_mx_page.php
 *                            -------------------
 *   begin                : mars, 2003
 *   copyright            : (C) 2003 MX-System
 *   email                : support@mx-system.com
 *
 *   $Id: admin_mx_page.php,v 1.2 2010/10/16 04:05:59 orynider Exp $
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
	$module['2_CP']['Page_admin'] = 'admin/' . $file;

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
// Instatiate the mx_cache class
//
$mx_admin = new mx_admin();

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


if( !empty($mode) ) 
{
  switch($mode)
  {
    case 'add':
    case 'edit':
      page_edit( $mode, $page_id );
      break;

    case 'create':
    case 'modify':
      page_modify( $mode, $page_id );
      break;

    case 'delete':
      page_delete( $mode, $page_id );
      break;

    case 'delpage':
      page_delete( $mode, $page_id );
      break;

    default:
      mx_message_die(GENERAL_MESSAGE, $lang['No_mode']);
      break;
  }
  exit;
}


// CODE STARTS HERE
$template->set_filenames(array(
  "body" => 'admin/mx_page_admin_edit.tpl')
);

$sql = "SELECT * FROM " . PAGE_TABLE .  " ORDER BY page_id"; 
	
if( !($result = $db->sql_query($sql)) )
{
  mx_message_die(GENERAL_ERROR, "Couldn't get list of page", "", __LINE__, __FILE__, $sql);
}


$row_count = 0;
while( $tblock[$row_count] = $db->sql_fetchrow($result) )
{	

  $page_id = $tblock[$row_count]['page_id'];
  $template->assign_block_vars("pages", array(
      'ID'          => $page_id,
	  'NAME'	    =>  $tblock[$row_count]['page_name'],
	  'U_PAGES'	    => mx_append_sid( PORTAL_URL . "admin/admin_mx_page_cp.php?page_id=" . $page_id),
	  'ICON'	    => PORTAL_URL . TEMPLATE_ROOT_PATH. "images/page_icons/" . $tblock[$row_count]['page_icon'],
      'U_EDIT'      => mx_append_sid( PORTAL_URL . "admin/admin_mx_page.$phpEx?mode=edit&amp;page_id=$page_id"),
      'U_SETTING'   => mx_append_sid( PORTAL_URL . "admin/admin_mx_page_cp.php?page_id=" . $page_id), 
      'U_DELETE'    => mx_append_sid( PORTAL_URL . "admin/admin_mx_page.$phpEx?mode=delete&amp;id=$page_id")
		));
		
	$row_count++;
}
$template->assign_vars(array(
  'L_TITLE'            => $lang['Page_admin'], 
  'L_EXPLAIN'          => $lang['Page_admin_explain'], 
    'S_ACTION'     => mx_append_sid( PORTAL_URL . "admin/admin_mx_page.$phpEx?mode=add"),
	'BLOCK_SIZE'   => ( !empty( $block_size ) ? $block_size : '100%' ) ,
	'L_TITLE'	   => $lang['Page_admin'],
    'L_EDIT'       => $lang['Edit'], 
    'L_SETTING'    => $lang['Settings'], 
    'L_DELETE'     => $lang['Delete'], 
    'L_CREATE_PAGE' => $lang['Add_Page']
));


include_once('./page_header_admin.'.$phpEx);

$template->pparse("body");

include_once('./page_footer_admin.'.$phpEx);
// CODE ENDS HERE (obviously)

exit;

// ******************************************************************
//
//
// ******************************************************************
function page_edit( $mode, $page_id )
{
  global $template, $lang, $db, $board_config, $theme, $HTTP_GET_VARS, $HTTP_POST_VARS;

  $auth_fields = array('auth_view');

  $auth_ary = array(
    "auth_view"   => AUTH_ALL
  );
  
  $auth_levels = array('ALL', 'REG', 'PRIVATE', 'MOD', 'ADMIN', 'ANONYMOUS');
  $auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN, AUTH_ANONYMOUS);
  
  $field_names = array( 'auth_view' => $lang['View']);

  //
  // Show form to create/modify a page
  //
  if ($mode == 'edit')
  {
    // $newmode determines if we are going to INSERT or UPDATE after posting?
    $newmode = 'modify';
    $buttonvalue = $lang['Update'];

    $row = mx_get_info( PAGE_TABLE, 'page_id', $page_id);

    $page_name   = $row['page_name'];
    $page_icon   = $row['page_icon'];
    $page_header   = empty($row['page_header']) ? 'overall_header.tpl' : $row['page_header'];
    $page_group_auth_id   = $row['auth_view_group'];
	
  }
  else
  {
    $newmode = 'create';
    $buttonvalue = $lang['Submit'];
    $page_name = $HTTP_POST_VARS[page_name];
    $page_icon   = empty($row['page_icon']) ? 'icon_home.gif' : $row['page_icon'];
    $page_header   = empty($row['page_header']) ? 'overall_header.tpl' : $row['page_header'];

    $sql = "SELECT MAX( page_id ) AS page_id FROM " . PAGE_TABLE;
    if( !$result = $db->sql_query($sql) )
    {
      mx_message_die(GENERAL_ERROR, "Couldn't get page information", "", __LINE__, __FILE__, $sql);
    }

    $row = $db->sql_fetchrow($result);
    $page_id = $row['page_id'] + 1;
  }

  $template->set_filenames(array(
    "edit_page" => "admin/mx_page_edit_body.tpl")
  );

  $s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode .'" /><input type="hidden" name="page_id" value="' . $page_id . '" />';

  //

  //
  // Output values of individual
  // fields
  //
  for($j = 0; $j < count($auth_fields); $j++)
  {
  	$custom_auth[$j] = '&nbsp;<select name="' . $auth_fields[$j] . '">';
  
  	for($k = 0; $k < count($auth_levels); $k++)
  	{
  		$selected = ( $row[$auth_fields[$j]] == $auth_const[$k] ) ? ' selected="selected"' : '';
  		$custom_auth[$j] .= '<option value="' . $auth_const[$k] . '"' . $selected . '>' . $lang['AUTH_' . $auth_levels[$k]] . '</option>';
  	}
  	$custom_auth[$j] .= '</select>&nbsp;';

	$custom_group_auth = mx_get_groups($page_group_auth_id);
  
  	$cell_title = $field_names[$auth_fields[$j]];
  
  	$template->assign_block_vars('page_auth_titles', array(
  		'CELL_TITLE' => $cell_title)
  	);
  	$template->assign_block_vars('page_auth_data', array(
  		'S_AUTH_GROUP_LEVELS_SELECT' => $custom_group_auth,
		'L_AUTH_GROUP_LEVELS_SELECT' => $lang['Auth_Page_group'],
  		'S_AUTH_LEVELS_SELECT' => $custom_auth[$j])
  	);

  	$s_column_span++;
  }

  $template->assign_vars(array(
    'L_TITLE'      	 			=> $lang['Page_admin'],
	'L_TITLE_NEW'				=> $lang['Page_admin_new_page'],
	'L_TITLE_TEMPLATES'			=> $lang['Page_templates_admin'],
    'L_EXPLAIN'     			=> $lang['Page_admin_explain'],
	
	'L_TITLE_TEMPLATE' 			=> $lang['Page_templates_admin'],
	'L_EXPLAIN_TEMPLATE' 		=> $lang['Page_templates_admin_explain'],	
	
    'L_PAGE_NAME'   => $lang['Page'], 
    'L_PAGE_ID'     => empty( $lang['Page_Id'] ) ? "Page Id" : $lang['Page_Id'] , 
    'L_PAGE_ICON'   => empty( $lang['Page_icon'] ) ? "Page Icon" : $lang['Page_icon'] , 
    'L_PAGE_HEADER'	=> empty( $lang['Page_header'] ) ? "Page header file" : $lang['Page_header'] , 
  	'L_AUTH_TITLE'  => empty( $lang['Auth_Page'] ) ? "Permission" : $lang['Auth_Page'],

    'PAGE_ID'        => $page_id,
    'PAGE_NAME'      => $page_name,
    'PAGE_ICON'      => post_icons('page_icons/', $page_icon),
    'PAGE_HEADER'      => $page_header,

    'S_ACTION'         => mx_append_sid("admin_mx_page.php"),
    'S_HIDDEN_FIELDS'  => $s_hidden_fields,
    'S_SUBMIT_VALUE'   => $buttonvalue, 
    'S_FUNCTION_LIST'  => $functionlist,

  ));


  define('IN_ADMIN', 1);
  include('./page_header_admin.php');
  $template->pparse("edit_page");

  include('./page_footer_admin.php');

}

// ******************************************************************
//
// Modify a page in the DB
//
// ******************************************************************
function page_modify( $mode, $page_id )
{
  global $template, $lang, $db, $board_config, $theme, $HTTP_POST_VARS, $mx_cache, $mx_request_vars;

	$page_id_new = $mx_request_vars->post('page_id_new', MX_TYPE_INT, 0);  
	$page_name = $mx_request_vars->post('page_name', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
	$page_desc = $mx_request_vars->post('page_desc', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
	$page_icon = $mx_request_vars->post('menuicons', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
	$page_header = $mx_request_vars->post('page_header', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
	$page_main_layout = $mx_request_vars->post('page_main_layout', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED, '');
	$navigation_block = $mx_request_vars->post('navigation_block', MX_TYPE_INT, '0');
	$auth_view = $mx_request_vars->post('auth_view', MX_TYPE_INT, 0);
	$ipfilter = $mx_request_vars->post('ip_filter', MX_TYPE_POST_VARS, '');
	$phpbb_stats = $mx_request_vars->post('phpbb_stats', MX_TYPE_INT, '-1'); 

	//
	// Format the mod_rewrite array
	//
	if ( $mode == "modify" )
	{
	    if ($page_id != intval($page_id_new))
	    {
	      $sql = "UPDATE " . COLUMN_TABLE . "
	        SET page_id        = " . intval($page_id_new) . "
	        WHERE page_id = " . $page_id;
	    
	      if( !$result = $db->sql_query($sql) )
	      {
	        mx_message_die(GENERAL_ERROR, "Couldn't update page information", "", __LINE__, __FILE__, $sql);
	      }
	    }

		//
		// Format the mod_rewrite array
		//
		$ipfilter = explode( "\n", htmlspecialchars( trim( $ipfilter ) ) );

		foreach( $ipfilter as $key => $value )
		{
			$ipfilter[$key] = trim( $value );
		}
		$ipfilter = addslashes( serialize( $ipfilter ) );

		$sql = "UPDATE " . PAGE_TABLE . "
			SET page_id				= '$page_id_new',		
				page_name			= '$page_name',
				page_desc			= '$page_desc',
				page_icon			= '$page_icon',
				page_header			= '$page_header',
				page_main_layout	= '$page_main_layout',
				navigation_block	= '$navigation_block',
				auth_view			= '$auth_view',
				ip_filter			= '$ipfilter',
				phpbb_stats			= '$phpbb_stats'
			WHERE page_id			= $page_id";
		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die( GENERAL_ERROR, "Couldn't update page information", '', __LINE__, __FILE__, $sql);
		}

		//
		// Update cache
		//
		$mx_cache->update(MX_CACHE_PAGE_TYPE, $page_id);
  }

  if ( $mode == "create" )
  {
	$sql = "INSERT INTO " . PAGE_TABLE . " ( page_id, page_name, page_desc, page_icon, auth_view, page_header, page_main_layout, navigation_block, ip_filter, phpbb_stats )
		VALUES ( 	'" . $page_id_new . "',
				'" . $page_name . "',
				'" . $page_desc . "',
				'" . $page_icon . "',
				'" . $auth_view . "',
				'" . $page_header . "',
				'" . $page_main_layout . "',
				'" . $navigation_block . "',
				'" . $ipfilter . "',
				'" . $phpbb_stats . "' )";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't insert page information", '', __LINE__, __FILE__, $sql);
	}		
  }
  $message = $lang['Portal_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_portal_config'], "<a href=\"" . mx_append_sid("admin_mx_page.php") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.php?pane=right") . "\">", "</a>");

  mx_message_die(GENERAL_MESSAGE, $message);
};


// ******************************************************************
//
// Delete a page 
//
// ******************************************************************
function page_delete( $mode, $page_id )
{
  global $template, $lang, $db, $board_config, $theme, $HTTP_POST_VARS;

  if ( $mode == "delete" )
  {
    $template->set_filenames(array(
       "admin_page" => "admin/mx_page_delete_body.tpl")
    );
  
    $buttonvalue = $lang['Delete'];
    $newmode = 'delpage';
  
    $s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" />';
  
    $page_name   = mx_get_list( "page_id", PAGE_TABLE, 'page_id', 'page_name', $page_id, TRUE);
  
    $template->assign_vars(array(
      'NAME' => $name, 
  
      'L_PAGE_DELETE'         => $lang['Page_admin'], 
      'L_PAGE_DELETE_EXPLAIN' => $lang['Page_admin_explain'], 
      'L_PAGE_NAME'           => $lang['Page'], 
      'NAME'                  => $page_name,
  
      "S_HIDDEN_FIELDS" => $s_hidden_fields,
      'S_PAGE_ACTION' => mx_append_sid("admin_mx_page.php"), 
      'S_SUBMIT_VALUE' => $buttonvalue)
    );
  
    define('IN_ADMIN', 1);
    include_once('./page_header_admin.php');
    $template->pparse("admin_page");
    include_once('./page_footer_admin.php');
  }

  if ( $mode == "delpage" )
  {

    $sql = "SELECT column_id FROM " . COLUMN_TABLE . " WHERE page_id = " . $page_id;
    if( !$result = $db->sql_query($sql) )
    {
      mx_message_die(GENERAL_ERROR, "Couldn't get list of Column", "", __LINE__, __FILE__, $sql);
    }

    while( $row = $db->sql_fetchrow($result) )
    {
      $sql = "DELETE FROM " . COLUMN_BLOCK_TABLE . "
        WHERE column_id = " . $row[column_id] ;
      if( !$result = $db->sql_query($sql) )
      {
        mx_message_die(GENERAL_ERROR, "Couldn't delete column/block information", "", __LINE__, __FILE__, $sql);
      }
    }

    $sql = "DELETE FROM " . COLUMN_TABLE . " WHERE page_id = " . $page_id;
  
    if( !$result = $db->sql_query($sql) )
    {
      mx_message_die(GENERAL_ERROR, "Couldn't delete page information", "", __LINE__, __FILE__, $sql);
    }

    $sql = "DELETE FROM " . PAGE_TABLE . " WHERE page_id = " . $page_id;
  
    if( !$result = $db->sql_query($sql) )
    {
      mx_message_die(GENERAL_ERROR, "Couldn't delete page information", "", __LINE__, __FILE__, $sql);
    }

    $message = $lang['Portal_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_portal_config'], "<a href=\"" . mx_append_sid("admin_mx_page.php") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.php?pane=right") . "\">", "</a>");
 
    mx_message_die(GENERAL_MESSAGE, $message);

  }    
};

?>
