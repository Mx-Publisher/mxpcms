<?php
/** ------------------------------------------------------------------------
 *		subject				: mx-portal, CMS & portal
 *		begin            	: june, 2002
 *		copyright          	: (C) 2002-2005 MX-System
 *		email             	: jonohlsson@hotmail.com
 *		project site		: www.mx-system.com
 * 
 *		description			:
 * -------------------------------------------------------------------------
 *    $Id: mx_textblock_edit.php,v 1.15 2005/03/21 21:52:40 jonohlsson Exp $
 */

 /**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */
 
define( 'IN_PORTAL', 1 );
$basename = basename( __FILE__);
$mx_root_path = './../../../';
$module_path = 'modules/mx_textblocks/';
$module_root_path = $mx_root_path . $module_path;
$admin_module_root_path = $module_root_path . 'admin/';

/* */
if (!empty($setmodules))
{	
	$module['TextBlocks']['Edit'] = mx_append_sid($admin_module_root_path . $basename);	
	return;
}
/* */

// Security and page header
require($mx_root_path . 'admin/pagestart.php');
include_once($phpbb_root_path . 'includes/functions_search.'.$phpEx); // required for search tables
include_once($phpbb_root_path . "includes/functions_post.$phpEx");	// required by mx_generate_smilies

// Mode setting

if (isset( $_POST['mode']) || isset($_GET['mode']))
{
	$mode = (isset( $_POST['mode'])) ? $_POST['mode'] : $_GET['mode'];
	$mode = htmlspecialchars($mode);

	switch($mode)
	{
		case 'editmulti':
			$function_file =  "mx_textblock_multi.php";
			//Array ( [block_id] => 9 [block_title] => mxBB TextBlock [block_desc] => This is a Demo Block [function_id] => 22 [auth_view] => 0 [auth_edit] => 5 [auth_delete] => 0 [auth_view_group] => 0 [auth_edit_group] => 0 [auth_delete_group] => 0 [auth_moderator_group] => 0 [show_title] => 1 [show_block] => 1 [show_stats] => 1 [block_time] => 1125865570 [block_editor_id] => 2 [module_path] => modules/mx_textblocks/ [module_name] => Text Blocks [function_file] => mx_textblock_multi.php [function_admin] => ) 			
		break;
			
		case 'editblog':
			$function_file =  "mx_textblock_blog.php";
			//Array ( [block_id] => 5 [block_title] => Blog TextBlock [block_desc] => This is a Demo Block [function_id] => 21 [auth_view] => 0 [auth_edit] => 5 [auth_delete] => 0 [auth_view_group] => 0 [auth_edit_group] => 0 [auth_delete_group] => 0 [auth_moderator_group] => 0 [show_title] => 1 [show_block] => 1 [show_stats] => 1 [block_time] => 1125842544 [block_editor_id] => 2 [module_path] => modules/mx_textblocks/ [module_name] => Text Blocks [function_file] => mx_textblock_blog.php [function_admin] => ) 	
		break;
			
		case 'edithtml':			
			$function_file =  "mx_textblock_html.php";
			//Array ( [block_id] => 10 [block_title] => WYSIWYG TextBlock [block_desc] => This is a Demo Block [function_id] => 23 [auth_view] => 0 [auth_edit] => 5 [auth_delete] => 0 [auth_view_group] => 0 [auth_edit_group] => 0 [auth_delete_group] => 0 [auth_moderator_group] => 0 [show_title] => 1 [show_block] => 1 [show_stats] => 1 [block_time] => 1125842503 [block_editor_id] => 2 [module_path] => modules/mx_textblocks/ [module_name] => Text Blocks [function_file] => mx_textblock_html.php [function_admin] => ) 
		break;
						
		default:
		case 'editbbcode':		
			$function_file =  "mx_textblock_bbcode.php";
			//Array ( [block_id] => 1 [block_title] => phpBB TextBlock [block_desc] => This is a Demo Block [function_id] => 24 [auth_view] => 0 [auth_edit] => 5 [auth_delete] => 0 [auth_view_group] => 0 [auth_edit_group] => 0 [auth_delete_group] => 0 [auth_moderator_group] => 0 [show_title] => 1 [show_block] => 1 [show_stats] => 1 [block_time] => 1125865999 [block_editor_id] => 2 [module_path] => modules/mx_textblocks/ [module_name] => Text Blocks [function_file] => mx_textblock_bbcode.php [function_admin] => ) 
		break;			
	}
	
	$sql_block =  " AND function_file = '" . $function_file . "'";	
}
else
{
	$mode = '';
	$sql_block =  !empty($module_root_path) ? " AND mdl.module_path = '" . str_replace($mx_root_path, '', $module_root_path) . "'" : " AND module_name = 'Text Blocks'";
}

// Initial vars
$block_id = isset( $_GET['block_id'] ) ? intval( $_GET['block_id'] ) : intval( $_POST['block_id'] );
$portalpage = isset( $_GET['portalpage'] ) ? intval( $_GET['portalpage'] ) : intval( $_POST['portalpage'] );
$sub_id = isset( $_POST['sub_id'] ) ? intval( $_POST['sub_id'] ) : "0";
$blog_u = isset( $_POST['u'] ) ? intval( $_POST['u'] ) : $userdata['user_id'];
$blog_mode = isset( $_GET['blog_mode'] ) ? $_GET['blog_mode'] : $_POST['blog_mode'];

if( empty($block_id) )
{
	// If this block doesn't have any id get, we need this additional query :-)	
	$sql = "SELECT 	blk.*,
					mdl.module_path, mdl.module_name,
					fnc.function_file, fnc.function_id, fnc.function_admin
			FROM " . BLOCK_TABLE . " blk,
					" . FUNCTION_TABLE . " fnc,
			        " . MODULE_TABLE . " mdl
			WHERE   blk.function_id = fnc.function_id
					AND fnc.module_id   = mdl.module_id";
	$sql .= $sql_block;
					
	if(!$result = $db->sql_query($sql))
	{
		mx_message_die(GENERAL_ERROR, "Could not query Music Center module information", "", __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$block_id = $row['block_id'];
}
	
$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
$s_hidden_fields .= '<input type="hidden" name="block_id" value="' . $block_id . '" />';
$s_hidden_fields .= '<input type="hidden" name="portalpage" value="' . $portalpage . '" />';
$s_hidden_fields .= '<input type="hidden" name="sub_id" value="' . $sub_id . '" />';
$s_hidden_fields .= '<input type="hidden" name="u" value="' . $blog_u . '" />';
$s_hidden_fields .= '<input type="hidden" name="blog_mode" value="' . $blog_mode . '" />';

// Setup config parameters
$block_config = $mode == 'editblog' ? read_block_config( $block_id, false, $sub_id ) : read_block_config( $block_id, false );

// Blog mode:
// $blog_validate = ( $blog_mode == 'group' ) ? mx_auth_group( $sub_id, $userdata['user_id'], true ) : $sub_id == $userdata['user_id'];
$blog_validate = ( $blog_mode == 'group' ) ? mx_auth_group_cache( $sub_id, true ) : $sub_id == $userdata['user_id'];

/*
if ( !( $blog_validate || $is_auth_ary[auth_edit] ) )
{
	$header_location = ( @preg_match( '/Microsoft|WebSTAR|Xitami/', getenv( 'SERVER_SOFTWARE' ) ) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header( $header_location . append_sid( PORTAL_URL . "index.$phpEx", true ) );
	exit;
}
*/

// **********************************************************************
// Read language definition
// **********************************************************************
if ( !file_exists( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx ) )
{
	include( $module_root_path . 'language/lang_english/lang_main.' . $phpEx );
}
else
{
	include( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx );
} 

// Parameters

$submit = ( isset( $_POST['post'] ) ) ? true : false;
$cancel = ( isset( $_POST['cancel'] ) ) ? true : false;
$preview = ( isset( $_POST['preview'] ) ) ? true : false;
$refresh = $preview || $submit_search;

// Cancel

if ( $cancel )
{
	$header_location = ( @preg_match( '/Microsoft|WebSTAR|Xitami/', getenv( 'SERVER_SOFTWARE' ) ) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header( $header_location . append_sid( PORTAL_URL . "index.$phpEx?page=" . $portalpage, true ) );
	exit;
}

$error = false; 

/**/
// Toggles

if ( !$board_config['allow_html'] )
{
	$html_on = 0;
}
else
{
	// $html_on = ( $submit || $refresh ) ? ( ( !empty($_POST['disable_html']) ) ? 0 : TRUE ) : $userdata['user_allowhtml'];
	$html_on = true;
}

if ( !$board_config['allow_bbcode'] )
{
	$bbcode_on = 0;
}
else
{
	// $bbcode_on = ( $submit || $refresh ) ? ( ( !empty($_POST['disable_bbcode']) ) ? 0 : TRUE ) : $userdata['user_allowbbcode'];
	$bbcode_on = true;
}
/**/

if ( !$board_config['allow_smilies'] )
{
	$smilies_on = 0;
}
else
{
	$smilies_on = ( $submit || $refresh ) ? ( ( !empty( $_POST['disable_smilies'] ) ) ? 0 : true ) : $userdata['user_allowsmile'];
}

$attach_sig = ( $submit || $refresh ) ? ( ( !empty( $_POST['attach_sig'] ) ) ? true : 0 ) : $userdata['user_attachsig'];
$user_sig = ( $userdata['user_sig'] != '' && $board_config['allow_sig'] ) ? $userdata['user_sig'] : "";

// Define all config data

// Main parameters

$block_title_par = "block_title";
$block_desc_par = "block_desc";
$show_block_par = "show_block";
$show_title_par = "show_title";
$show_stats_par = "show_stats";

if ( isset( $block_config[$block_id]['Html'] ) ) // Html Textblock
{
	$block_text_par = "Html";
	$mode = "edithtml";
	$bbcode_on = false;
	$html_on = true;

	$html_entities_match = array( );
	$html_entities_replace = array( );	
}
else if ( isset( $block_config[$block_id]['Text'] ) ) // Multi or BBcode Textblock
{
	$block_text_par = "Text";
	$mode = "edit";
	$bbcode_on = true;
	$html_on = true;
	
	$html_entities_match = array( '#&#', '#<#', '#>#' );
	$html_entities_replace = array( '&amp;', '&lt;', '&gt;' );	
}
else if ( isset( $block_config[$block_id]['Blog'] ) ) // Blog Textblock
{
	$block_text_par = "Blog";
	$mode = "editblog";
	$bbcode_on = true;
	$html_on = true;

	$html_entities_match = array( '#&#', '#<#', '#>#' );
	$html_entities_replace = array( '&amp;', '&lt;', '&gt;' );	
}
else
{
	$block_text_par = "Text";
	$mode = "edit";
}

// Style parameters
$block_style_par = "block_style";
$text_style_par = "text_style";
$title_style_par = "title_style";
$blog_id_par = "blog_id";

$text_style_options = array();
$text_style_options = array( "none", "gen", "gensmall", "genmed", "genlarge", "postbody" );

$new_vars = array();
$new_vars = array( $block_text_par, $block_style_par, $text_style_par, $title_style_par, $blog_id_par );

$new = array();

// Extract info - main loop
for( $j = 0; $j < count( $new_vars ); $j++ )
{
	$new[$new_vars[$j]] = ( isset( $_POST[$new_vars[$j]] ) ) ? $_POST[$new_vars[$j]] : $block_config[$block_id][$new_vars[$j]]['parameter_value'];
	$parameter_id = $block_config[$block_id][$new_vars[$j]]['parameter_id'];

	if ( $submit )
	{
		if ( empty( $new[$new_vars[$j]] ) || ( $new_vars[$j] == $blog_id_par && $sub_id > 0 ) )
		{
			$error = true;
		}
		else
		{
			if ( $new_vars[$j] == $block_text_par )
			{
				if ( $bbcode_on )
				{
					$bbcode_uid = make_bbcode_uid();
				}
				
				//Format the input:
				$new[$new_vars[$j]] = prepare_message( trim($new[$new_vars[$j]]), $html_on, $bbcode_on, $smilies_on, $bbcode_uid );
			}

			if ( $block_config[$block_id][$new_vars[$j]]['sub_id'] == $sub_id )
			{
				$sql = "UPDATE " . BLOCK_SYSTEM_PARAMETER_TABLE . "
	  			SET parameter_value = '" . str_replace( "\'", "''", $new[$new_vars[$j]] ) . "', 
	  	   			 bbcode_uid = '$bbcode_uid'
	  			WHERE block_id     = '$block_id'
  					AND parameter_id = '$parameter_id'
	  	  			AND sub_id = '$sub_id'";

				if ( !( $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, "Could not update textblock information.", "", __LINE__, __FILE__, $sql );
				}
				
			}
			else
			{
				$sql = "INSERT INTO " . BLOCK_SYSTEM_PARAMETER_TABLE . "(block_id, parameter_id, parameter_value, bbcode_uid, sub_id) 
					VALUES('$block_id','$parameter_id','" . str_replace( "\'", "''", $new[$new_vars[$j]] ) . "','$bbcode_uid', '$sub_id')";
				if ( !( $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Couldnt insert comments', '', __LINE__, __FILE__, $sql );
				}
			}
			
			if ( $sub_id == 0 )
			{
				mx_remove_search_post( $block_id );
			}
		}
	}
}
// For title, cache and submit
if ( $submit )
{
	if ( $sub_id == "0" )
	{
		$block_title = ( isset( $_POST['block_title'] ) ) ? htmlspecialchars(trim( $_POST['block_title'] ) ) : $block_config[$block_id]['block_title'];
		$block_desc = htmlspecialchars(trim( $_POST['block_desc'] ) );
		$show_block = intval( $_POST['show_block'] );
		$show_title = intval( $_POST['show_title'] );
		$show_stats = intval( $_POST['show_stats'] );

		$block_time = time();
		$block_editor_id = $userdata['user_id'];
			
		$sql = "UPDATE " . BLOCK_TABLE . "
	  			SET block_title = '" . str_replace( "\'", "''", $block_title ) . "',
			  			 block_desc = '" . str_replace( "\'", "''", $block_desc ) . "',
			  			 block_time = '" . str_replace( "\'", "''", $block_time ) . "',
			  			 block_editor_id = '" . intval( $block_editor_id ) . "',
			  			 show_block = '" . intval( $show_block ) . "',
			  			 show_title = '" . intval( $show_title ) . "',
			  			 show_stats = '" . intval( $show_stats ) . "'
	  			WHERE block_id     = $block_id";

		if ( !( $result = $db->sql_query( $sql, BEGIN_TRANSACTION ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not update block title information.", "", __LINE__, __FILE__, $sql );
		}

		mx_add_search_words( 'single', $block_id, stripslashes( str_replace( "\'", "''", $new[$block_text_par] ) ), stripslashes( str_replace( "\'", "''", $block_title ) ) );
	}

	// Update cache
	update_session_cache( $block_id );

	$template->assign_vars( array( 'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid( PORTAL_URL . "index.$phpEx?page=" . $portalpage ) . '">' ) 
		);

	if ( !empty( $portalpage ) )
	{
		$page_title = $lang['Block_admin'];
		$blog_return = $blog_u > 0 ? "&u=" . $blog_u : ( $sub_id > 0 ? "&g=" . $sub_id : '' );
		$msg = $lang['Block_Config_updated'] . '<br /><br />' . sprintf( $lang['Click_return_index'], '<a href="' . append_sid( PORTAL_URL . "index.$phpEx?page=" . $portalpage . $blog_return ) . '">', '</a>' );
	}
	else
	{
		$msg = $lang['Block_Config_updated'] . '<br /><br />' . sprintf( $lang['Click_return_index'], '<a href="' . append_sid( PORTAL_URL . "admin/admin_mx_block.php" ) . '">', '</a>' );
	}
	mx_message_die( GENERAL_MESSAGE, $msg );
} 

$block_text = $new[$block_text_par];
$bbcode_uid = $block_config[$block_id][$block_text_par]['bbcode_uid'];

$blog_id = trim( stripslashes( $new[$blog_id_par] ));

$block_text = htmlspecialchars( trim( stripslashes( $block_text ) ) );
$block_title = htmlspecialchars( trim( stripslashes( $block_title ) ) );

if ( $mode != 'edithtml' )
{
	$block_text = preg_replace( "/\:(([a-z0-9]:)?)$bbcode_uid/si", '', $block_text );
	$block_text = str_replace( '<br />', "\n", $block_text );
	$block_text = preg_replace( '#</textarea>#si', '&lt;/textarea&gt;', $block_text );
	$block_text = trim( stripslashes( $block_text ) );
}
else
{
	$block_title = trim( strip_tags( stripslashes( $block_title ) ) );
	$block_text = str_replace( '<br />', "\n", $block_text );
	$block_text = preg_replace( '#</textarea>#si', '&lt;/textarea&gt;', $block_text );
	$block_text = trim( stripslashes( $block_text ) );
} 
// Style parameters
$block_style_yes = ( $new[$block_style_par] == 'TRUE' ) ? "checked=\"checked\"" : "";
$block_style_no = ( !( $new[$block_style_par] == 'TRUE' ) ) ? "checked=\"checked\"" : "";

$text_style_list = '<select name="text_style">';
for( $j = 0; $j < count( $text_style_options ); $j++ )
{
	if ( $new[$text_style_par] == $text_style_options[$j] )
	{
		$status = "selected";
	}
	else
	{
		$status = '';
	}
	$text_style_list .= '<option value="' . $text_style_options[$j] . '" ' . $status . '>' . $text_style_options[$j] . '</option>';
}
$text_style_list .= '</select>';

$text_style_yes = ( $new[$text_style_par] == 'TRUE' ) ? "checked=\"checked\"" : "";
$text_style_no = ( !( $new[$text_style_par] == 'TRUE' ) ) ? "checked=\"checked\"" : "";

$title_style_yes = ( $new[$title_style_par] == 'TRUE' ) ? "checked=\"checked\"" : "";
$title_style_no = ( !( $new[$title_style_par] == 'TRUE' ) ) ? "checked=\"checked\"" : "";

// Main parameters
$block_title = ( isset( $_POST[$block_title_par] ) ) ? stripslashes( htmlspecialchars( $_POST[$block_title_par] ) ) : $block_config[$block_id][$block_title_par];
$block_desc = ( isset( $_POST[$block_desc_par] ) ) ? stripslashes( htmlspecialchars( $_POST[$block_desc_par] ) ) : $block_config[$block_id][$block_desc_par];
$show_block = ( isset( $_POST[$show_block_par] ) ) ? intval( $_POST[$show_block_par] ) : $block_config[$block_id][$show_block_par];
$show_title = ( isset( $_POST[$show_title_par] ) ) ? intval( $_POST[$show_title_par] ) : $block_config[$block_id][$show_title_par];
$show_stats = ( isset( $_POST[$show_stats_par] ) ) ? intval( $_POST[$show_stats_par] ) : $block_config[$block_id][$show_stats_par];

$show_title_yes = ( $show_title == 1 ) ? "checked=\"checked\"" : "";
$show_title_no = ( $show_title == 0 ) ? "checked=\"checked\"" : "";

$show_block_yes = ( $show_block == 1 ) ? "checked=\"checked\"" : "";
$show_block_no = ( $show_block == 0 ) ? "checked=\"checked\"" : "";

$show_stats_yes = ( $show_stats == 1 ) ? "checked=\"checked\"" : "";
$show_stats_no = ( $show_stats == 0 ) ? "checked=\"checked\"" : "";

// Start output, first preview, then errors then post form

$title = $block_config[$block_id]['block_title'];
$page_title = $title;

$template->assign_block_vars( "switch_view", array() );

if ( !empty( $portalpage ) )
{
	$page_title = $lang['Block_admin'];
	include_once( $mx_root_path . 'includes/page_header.' . $phpEx );
}
else
{
	include_once( $mx_root_path . 'admin/page_header_admin.' . $phpEx );
} 
// --------------------------------------------------------
// Previews Layout
// --------------------------------------------------------
if ( $preview && !$error )
{
	$preview_title = $block_title;
	$preview_text = $block_text;
	
	// $preview_text = preg_replace( '#<textarea>#si', '&lt;textarea&gt;', $preview_text );
	
	$orig_word = array();
	$replacement_word = array();
	obtain_word_list( $orig_word, $replacement_word );

	if ( $bbcode_on && $mode != 'edithtml' )
	{
		$bbcode_uid = make_bbcode_uid();
	}
	
	//$mxbb_tmp = $board_config['allow_html_tags']; //Should we have specfic allowed tags spec for mx textblocks?
	//$board_config['allow_html_tags'] = '';
	$preview_text = stripslashes(prepare_message(addslashes(unprepare_message($preview_text)), $html_on, $bbcode_on, $smilies_on, $bbcode_uid)); 
	//$board_config['allow_html_tags'] = $mxbb_tmp;
	
	// Finalise processing as per viewtopic
	
	if ( $bbcode_on && $mode != 'edithtml' )
	{
		$preview_text = bbencode_second_pass( $preview_text, $bbcode_uid );
	}

	if ( count( $orig_word ) )
	{
		$preview_title = preg_replace( $orig_word, $replacement_word, $preview_title );
		$preview_text = preg_replace( $orig_word, $replacement_word, $preview_text );
	}

	if ( $smilies_on && $mode != 'edithtml' )
	{
		$preview_text = mx_smilies_pass( $preview_text );
	}

	$preview_text = make_clickable( $preview_text );
	
	if ( $mode != 'edithtml' )
	{
		$preview_text = str_replace( "\n", '<br />', $preview_text );
	}

	$s_hidden_fields .= '<input type="hidden" name="mode" value="' . $mode . '" />';
	$s_hidden_fields .= '<input type="hidden" name="portalpage" value="' . $portalpage . '" />';
	$s_hidden_fields .= '<input type="hidden" name="sub_id" value="' . $sub_id . '" />';

	$template->set_filenames( array( "preview" => 'mx_textblock_preview.tpl' ) 
		);

	$template->assign_vars( array( 'BLOCK_TITLE' => $preview_title,
			'BLOCK_INFO' => $preview_text,

			'S_HIDDEN_FIELDS' => $s_hidden_fields,

			'L_BLOCK_TITLE' => $lang['Block_Title'],
			'L_PREVIEW' => $lang['Preview'] 
			) );

	$template->assign_var_from_handle( 'POST_PREVIEW_BOX', 'preview' );
} 
// --------------------------------------------------------
// Default Layout
// --------------------------------------------------------
if ($mode == 'editblog')
{
	$template->set_filenames(array('body' => 'mx_textblock_editblog.tpl'));
}
else
{
	$template->set_filenames(array('body' => 'mx_textblock_edit.tpl'));
} 

// Send smilies to template

if ($mode != 'edithtml')
{
	mx_generate_smilies('inline', PAGE_INDEX );
}

if ( $mode == 'edit' )
{
	$POST_ACTION = $module_root_path . "admin/mx_textblock_edit.$phpEx?mode=edit";
}
elseif ( $mode == 'edithtml' )
{
	$POST_ACTION = $module_root_path . "admin/mx_textblock_edit.$phpEx?mode=edithtml";
}
elseif ( $mode == 'editblog' )
{
	$POST_ACTION = $module_root_path . "admin/mx_textblock_edit.$phpEx?mode=editblog";
}
else
{
	$POST_ACTION = $module_root_path . "admin/mx_textblock_edit.$phpEx";
}

if ( $mode != 'edithtml' )
{
	$template->assign_block_vars( "switch_bbcodes", array() );
}

if ( $sub_id == 0 )
{
	$template->assign_block_vars( "titles_row", array() );
}

if ( !empty( $new[$text_style_par] ) )
{
	$template->assign_block_vars( "switch_text_style", array() );
}
if ( !empty( $new[$block_style_par] ) )
{
	$template->assign_block_vars( "switch_block_style", array() );
}
if ( !empty( $new[$title_style_par] ) )
{
	$template->assign_block_vars( "switch_title_style", array() );
}
if ( !empty( $new[$blog_id_par] ) &&  $sub_id == 0 )
{
	$template->assign_block_vars( "switch_blog_id", array() );
}

$template->assign_vars( array( 
		'L_TITLE' => $lang['Block_admin'],
		'L_EXPLAIN' => $lang['Block_admin_explain'],
		'BLOCK_TITLE' => $block_title,
		'BLOCK_INFO' => $block_text,
		'HTML_STATUS' => $html_status,
		'SMILIES_STATUS' => $smilies_status,

		'BLOCK_TEXT_NAME' => $block_text_par,

		'L_BLOCK_STYLE' => $lang['Block_Style'],
		'L_TEXT_STYLE' => $lang['Text_Style'],
		'L_TITLE_STYLE' => $lang['Title_Style'],

		'L_YES' => $lang['Yes'],
		'L_NO' => $lang['No'],

		'L_BLOCK_STYLE_EXPLAIN' => $lang['Block_Style_Explain'],
		'L_TEXT_STYLE_EXPLAIN' => $lang['Text_Style_Explain'],
		'L_TITLE_STYLE_EXPLAIN' => $lang['Title_Style_Explain'],

		'L_BLOCK_TITLE' => $lang['Block_Title'],
		'L_BLOCK_INFO' => $lang['Block_Info'],
		'L_OPTIONS' => $lang['Options'],
		'L_PREVIEW' => $lang['Preview'],
		'L_SUBMIT' => $lang['Submit'],
		'L_CANCEL' => $lang['Cancel'],
		'L_DISABLE_HTML' => $lang['Disable_HTML_pm'],
		'L_DISABLE_BBCODE' => $lang['Disable_BBCode_pm'],
		'L_DISABLE_SMILIES' => $lang['Disable_Smilies_pm'],
		'L_ATTACH_SIGNATURE' => $lang['Attach_signature'],

		'L_BLOG_ID' => $lang['Blog_id'],
		'BLOG_ID' => $blog_id,
		
		'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
		'L_BBCODE_I_HELP' => $lang['bbcode_i_help'],
		'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
		'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'],
		'L_BBCODE_C_HELP' => $lang['bbcode_c_help'],
		'L_BBCODE_L_HELP' => $lang['bbcode_l_help'],
		'L_BBCODE_O_HELP' => $lang['bbcode_o_help'],
		'L_BBCODE_P_HELP' => $lang['bbcode_p_help'],
		'L_BBCODE_W_HELP' => $lang['bbcode_w_help'],
		'L_BBCODE_A_HELP' => $lang['bbcode_a_help'],
		'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
		'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
		'L_EMPTY_MESSAGE' => $lang['Empty_message'],

		'L_FONT_COLOR' => $lang['Font_color'],
		'L_COLOR_DEFAULT' => $lang['color_default'],
		'L_COLOR_DARK_RED' => $lang['color_dark_red'],
		'L_COLOR_RED' => $lang['color_red'],
		'L_COLOR_ORANGE' => $lang['color_orange'],
		'L_COLOR_BROWN' => $lang['color_brown'],
		'L_COLOR_YELLOW' => $lang['color_yellow'],
		'L_COLOR_GREEN' => $lang['color_green'],
		'L_COLOR_OLIVE' => $lang['color_olive'],
		'L_COLOR_CYAN' => $lang['color_cyan'],
		'L_COLOR_BLUE' => $lang['color_blue'],
		'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'],
		'L_COLOR_INDIGO' => $lang['color_indigo'],
		'L_COLOR_VIOLET' => $lang['color_violet'],
		'L_COLOR_WHITE' => $lang['color_white'],
		'L_COLOR_BLACK' => $lang['color_black'],

		'L_FONT_SIZE' => $lang['Font_size'],
		'L_FONT_TINY' => $lang['font_tiny'],
		'L_FONT_SMALL' => $lang['font_small'],
		'L_FONT_NORMAL' => $lang['font_normal'],
		'L_FONT_LARGE' => $lang['font_large'],
		'L_FONT_HUGE' => $lang['font_huge'],

		'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'],
		'L_STYLES_TIP' => $lang['Styles_tip'],

		'S_HTML_CHECKED' => ( !$html_on ) ? ' checked="checked"' : '',
		'S_BBCODE_CHECKED' => ( !$bbcode_on ) ? ' checked="checked"' : '',
		'S_SMILIES_CHECKED' => ( !$smilies_on ) ? ' checked="checked"' : '',
		'S_HIDDEN_FORM_FIELDS' => $s_hidden_fields,
		'S_POST_ACTION' => append_sid( "$POST_ACTION" ),

		'S_BLOCK_STYLE_YES' => $block_style_yes,
		'S_BLOCK_STYLE_NO' => $block_style_no,

		'S_TEXT_STYLE' => $text_style_list,

		'S_TITLE_STYLE_YES' => $title_style_yes,
		'S_TITLE_STYLE_NO' => $title_style_no,

		'L_BLOCK_TITLE' => $lang['Block_title'],
		'L_BLOCK_DESC' => $lang['Block_desc'],
		'L_SHOW_BLOCK' => $lang['Show_block'],
		'L_SHOW_TITLE' => $lang['Show_title'],
		'L_SHOW_STATS' => $lang['Show_stats'],

		'E_BLOCK_TITLE' => $block_title,
		'E_BLOCK_DESC' => $block_desc,

		'S_SHOW_BLOCK_YES' => $show_block_yes,
		'S_SHOW_BLOCK_NO' => $show_block_no, 
		
		'S_SHOW_TITLE_YES' => $show_title_yes,
		'S_SHOW_TITLE_NO' => $show_title_no,	
			
		'S_SHOW_STATS_YES' => $show_stats_yes,
		'S_SHOW_STATS_NO' => $show_stats_no,
				
		'U_PHPBB_ROOT_PATH' => PHPBB_URL 
		) );

$template->pparse( 'body' );

if ( !empty( $portalpage ) )
{
	$page_title = $lang['Block_admin'];
	include( $mx_root_path . 'includes/page_tail.' . $phpEx );
}
else
{
	include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );
}

?>