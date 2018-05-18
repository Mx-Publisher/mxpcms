<?php
/**
*
* @package mxBB Portal Core
* @version $Id: index.php,v 1.2 2009/01/24 16:47:51 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

define( 'IN_PORTAL', 1 );
$mx_root_path = "./";

//
// Let's include some stuff...
//
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($mx_root_path . 'common.' . $phpEx);

//
// Page selector
//
$page_id = $mx_request_vars->request('page', MX_TYPE_INT, 1);

//
// Start user session
// - populate $userdata and $lang
//
$mx_user->init($user_ip, $page_id, false);
$userdata = session_pagestart($user_ip, $page_id);
mx_init_userprefs($userdata);

// Load and instatiate CORE (page) and block classes
$mx_page->init( $page_id );
//
// Initiate user style (template + theme) management
// - populate $theme, $images and initiate $template.
//
$mx_user->init_style();

//
// Handy switch, when recostructing the site. Only admin is able to view pages and browse around normally
//
/*
if( !($userdata['user_level'] == ADMIN && $userdata['session_logged_in']) )
{
	mx_message_die(GENERAL_MESSAGE, 'We are currenty upgrading this site with latest mxBB software. Hopefully everything will run smoothly again later tonight (GMT). /Jon', 'Information');
}
*/

//
// Site under reconstruction
//
if( !$portal_config['portal_status'] && !($userdata['user_level'] == ADMIN && $userdata['session_logged_in']) )
{
	mx_message_die(GENERAL_MESSAGE, $portal_config['disabled_message'], 'Information');
}

//
// Show copyrights
//
if ( $mx_request_vars->is_request('mx_copy') )
{
	compose_mx_copy();
}

//
// Page Auth and IP filter
//
if ( !($mx_page->auth_view || $mx_page->auth_mod) && $userdata['session_logged_in'] )
{
	$message = empty( $lang['Page_Not_Authorised'] ) ? "Sorry, but you don't have privilege to access this page." : $lang['Page_Not_Authorised'];
	mx_message_die(GENERAL_MESSAGE, $message, '', __LINE__, __FILE__, '');
}
elseif ( !($mx_page->auth_view || $mx_page->auth_mod) && !$userdata['session_logged_in'] )
{
	mx_redirect( append_sid( "login.$phpEx?redirect=" . 'index.php?page=' . $page_id, true ) );
}
elseif ( !$mx_page->auth_ip )
{
	$message = empty( $lang['Page_Not_Authorised'] ) ? "Sorry, but you don't have privilege to access this page." : $lang['Page_Not_Authorised'];
	mx_message_die(GENERAL_MESSAGE, $message, '', __LINE__, __FILE__, '');
}

//
// Initialize page layout template
//
$layouttemplate = new mx_Template( $mx_root_path . 'templates/'. $theme['template_name'] );

$layouttemplate->set_filenames(array(
	'mx_main_layout' => $mx_page->page_main_layout)
);

//
// Start output of page blocks
// ------------------------------------------------------------------------------------------------------------
//

//
// Page columns - loop through each column
//
for( $column = 0; $column < $mx_page->total_column; $column++ )
{
	//
	// Pass column data
	//
	$mx_page->output_column( $column );
	
	//
	// Column blocks - loop through column blocks
	//
	$column_contents = array();
	
	for( $block = 0; $block < $mx_page->total_block; $block++ )
	{
		//
		// Validate this block is visible and exists for the column
		//
		if ( $mx_page->columns[$column]['column_id'] == $mx_page->blocks[$block]['column_id'] )
		{ 
			
			$block_id = $mx_block_id = $mx_page->blocks[$block]['block_id'];
			$mx_block->init( $block_id );
			
			//
			// Toggle mode: default, dynamic, sub
			// 
			if ( $mx_block->is_dynamic )
			{
				//
				// Create a parent block
				//
				$mx_dynamic_block = new mx_block();
				$mx_dynamic_block->init( $mx_block->block_id );	
					
				//
				// Instatiate the dynamic block
				//
				$mx_block->init( $mx_dynamic_block->dynamic_block_id );
			}

			if ( $mx_block->is_sub )
			{
				//
				// Create a parent block
				//				
				$mx_parent_block = new mx_block();
				$mx_parent_block->init( $mx_block->block_id );
				
				$total_subs = $mx_parent_block->total_subs;				
			}
			else
			{
				$total_subs = 1;
			}

			//
			// Additional loop for subblocks - split block
			//
			for( $subblock = 0; $subblock < $total_subs; $subblock++ )
			{
				if ( is_object($mx_parent_block) )
				{
					if ($mx_parent_block->is_sub)
					{
						$block_id = intval( $mx_parent_block->sub_block_ids[$subblock] );

						//
						// Instatiate the sub block
						//						
						$mx_block->init( $block_id );
					}
				}		
										
					
				//
				// View Auth ------------------------------------------------------------------------------- 
				//
				if ( ( $mx_block->auth_view && $mx_block->show_block ) || $mx_block->auth_mod )
				{
					//$template = new mx_Template($template->root, $board_config, $db);
					$template = new mx_Template($mx_root_path . 'templates/'. $theme['template_name'], $board_config, $db);
					
					//
					// Define $module_root_path, to be used within blocks
					//
					$module_root_path = $mx_block->module_root_path;
	
					//
					// Include block file and cache output
					//
					ob_start();
					include($module_root_path . $mx_block->block_file);
					$column_contents[$column] = ob_get_contents();
					ob_end_clean();
	
					//
					// Pass block data
					//
					if ( $mx_block->show_block || $mx_block->auth_mod )
					{
						//
						// Output Block contents
						//
						$mx_block->output( $column_contents[$column] );
	
						//
						// Switch: Block border graphics?
						//
						if ( $mx_page->block_border_graphics )
						{
							$mx_block->output_border_graphics();
						} 
	
						//
						// Output Block stats
						//
						$mx_block->output_stats();
					}
				} 
				
				//
				// Edit Auth --------------------------------------------------------------------------------- 
				//
				if ( ( ( $mx_block->auth_view && $mx_block->auth_edit && $mx_block->show_block ) || $mx_block->auth_mod ) )
				{
					//
					// Now use the editCP on/off switch
					//
					$mx_page->show_editcp_switch();
	
					//
					// Output editcp controls/buttons
					//
					if ( is_object($mx_dynamic_block) && $subblock == $total_subs - 1 )
					{
						if ($mx_dynamic_block->dynamic_block_id > 0 && $mx_dynamic_block->auth_edit)
						{
							$mx_dynamic_block->output_cp_button();
						}
					}
					
					if ( is_object($mx_parent_block) && $subblock == $total_subs - 1 && $mx_parent_block->auth_edit )
					{
						$mx_parent_block->output_cp_button();
					}					
					
					$mx_block->output_cp_button();
	
					//
					// Is the Block hidden ? Output 'hidden' indicator
					//
					if ( !$mx_block->show_block || !$mx_block->auth_view)
					{
						$mx_block->output_hidden_indicator();
					}
				} 
				
				//
				// Block header -------------------------------------------------------------------------------- 
				//
				if ( $mx_block->auth_view && $mx_block->show_block && ( $mx_page->editcp_switch_on || $mx_block->show_title ) || $mx_block->auth_mod )
				{
				 	$layouttemplate->assign_block_vars('layout_column.blocks.block_header', array());
	
				 	//
					// Switch: show title -------------------
					//
					if ( $mx_block->show_title || $mx_block->auth_mod )
					{
						$mx_block->output_title();
					}
				}
				
				//
				// Output some subblock wrappers
				//
				if (is_object($mx_parent_block))
				{
					if ( $mx_parent_block->is_sub )
					{
						if ( $subblock == 0 )
						{
							$layouttemplate->assign_block_vars('layout_column.blocks.sub_start', array());
							$inner_space = '';
						}
						else 
						{
							$inner_space = '<td width="'.$mx_parent_block->sub_inner_space.'">&nbsp;</td>';
						}
							
						$layouttemplate->assign_block_vars('layout_column.blocks.sub_col', array(
							'INNER_SPACE' => $inner_space,
							'BLOCK_SIZE' => $mx_parent_block->sub_block_sizes[$subblock]
						));
							
						if ( intval($subblock + 1) == $total_subs )
						{
							$layouttemplate->assign_block_vars('layout_column.blocks.sub_end', array());
						}
					}
				}

				
			} // for ... subblocks
			
			//
			// Destroy parent block data
			//
			if ( is_object($mx_parent_block) && $mx_parent_block->is_sub )
			{
				unset( $mx_parent_block );
			}
			
			if ( is_object($mx_dynamic_block) )
			{
				unset( $mx_dynamic_block );
			}			
			
			$mx_block->kill_me($block_id);
		}
		
	} // for ... blocks
	
} // for ... column

//
// Output header
//
include( $mx_root_path . 'includes/page_header.' . $phpEx );

//
// Output page
//
$layouttemplate->pparse('mx_main_layout');

//
// Output footer
//
include($mx_root_path . 'includes/page_tail.' . $phpEx);
?>