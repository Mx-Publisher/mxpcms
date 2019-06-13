<?php
/**
*
* @package MX-Publisher Module - mx_navmenu
* @version $Id: mx_site_nav.php,v 1.12 2013/06/02 12:56:34 orynider Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$b_description = $mx_block->block_info['block_desc'];

//
// Includes
//
include_once( $module_root_path . 'includes/navmenu_constants.' . $phpEx );
include_once( $module_root_path . 'includes/navmenu_functions.' . $phpEx );

//
// Setup config parameters
//
$config_name = array('menu_display_style', 'menu_display_mode', 'menu_page_sync', 'menu_page_parent', 'menu_custom_tpl');

for( $i = 0; $i < count($config_name); $i++ )
{
	$config_value = $mx_block->get_parameters( $config_name[$i] );
	$mx_menu_config[$config_name[$i]] = $config_value;
}

//
// Define some parameters
//
/*
$menu_display_style = 'Overall_navigation';
$menu_display_mode == 'Horizontal';
$menu_page_sync = true;
*/
$menu_custom_tpl = $mx_menu_config['menu_custom_tpl'];
$menu_display_style = $mx_menu_config['menu_display_style'];
$menu_display_mode = $mx_menu_config['menu_display_mode'];
$menu_page_sync = ( $mx_menu_config['menu_page_sync'] != 'No' );

$page_parent = !empty($mx_menu_config['menu_page_parent']) ? $mx_menu_config['menu_page_parent'] : 0;

//
// Prevent this block to be used both in overall_header and as a block
// Define this menu block has been used on this page - either as a block or in the header. To avoid it being used several times
//
$nav_def_key = 'MX_SITE_MENU_' . $block_id;

if ( defined($nav_def_key) )
{
	$mx_block->show_title = false;
	$mx_block->show_block = false;
	return;
}
define($nav_def_key, true);

//
// Get the current MX page.
//
$page_id = $mx_request_vars->request('page', MX_TYPE_INT, 1);
$virtual_id = $mx_request_vars->request('virtual', MX_TYPE_INT, '');

if (!empty($menu_custom_tpl))
{
	$template_tmp = array('body' => $menu_custom_tpl);
	$template_tmp_path = str_replace(strrchr($template_tmp, '/'), '', $template_tmp) . '/';
	$kick_js = @file_exists($mx_root_path . $module_root_path . 'templates/' .$mx_user->template_names[$module_root_path] . $template_tmp_path) ? ($menu_display_mode == 'Horizontal' ? 'horizontal' : 'vertical') : '';
	if (!empty($kick_js))
	{
		$mx_page->add_footer_text( 'templates/' . $mx_user->template_names[$module_root_path] . $template_tmp_path . $kick_js . '.js', true );
	}
}
else
{
	switch( $menu_display_style )
	{
		case 'Classic':
			$template_tmp = $menu_display_mode == 'Horizontal' ? array('body' => 'mx_menu_classic_hor.tpl') : array('body' => 'mx_menu_classic_ver.tpl');
			break;
		case 'Advanced':
			$template_tmp = $menu_display_mode == 'Horizontal' ? array('body' => 'mx_menu_advanced_hor.tpl') : array('body' => 'mx_menu_advanced_ver.tpl');
			$kick_js = $menu_display_mode == 'Horizontal' ? 'adv_hor.js' : 'adv_ver.js';
			$mx_page->add_footer_text( 'includes/js/' . $kick_js, true );
			break;
		case 'Simple_CSS_menu':
			$template_tmp = $menu_display_mode == 'Horizontal' ? array('body' => 'mx_menu_simple_CSS_hor.tpl') : array('body' => 'mx_menu_simple_CSS_ver.tpl');
			$kick_js = $menu_display_mode == 'Horizontal' ? 'simple_CSS_hor.js' : 'simple_CSS_ver.js';
			$mx_page->add_footer_text( 'includes/js/' . $kick_js, true );
			break;
		case 'Advanced_CSS_menu':
			$template_tmp = $menu_display_mode == 'Horizontal' ? array('body' => 'mx_menu_advanced_CSS_hor.tpl') : array('body' => 'mx_menu_advanced_CSS_ver.tpl');
			$kick_js = $menu_display_mode == 'Horizontal' ? 'adv_CSS_hor.js' : 'adv_CSS_ver.js';
			$mx_page->add_footer_text( 'includes/js/' . $kick_js, true );
			break;
		case 'Simple_x':
			$template_tmp = $menu_display_mode == 'Horizontal' ? array('body' => 'mx_menu_simple_x_hor.tpl') : array('body' => 'mx_menu_simple_x_ver.tpl');
			break;			
		case 'Overall_navigation':
			$template_tmp = array('body' => 'mx_menu_overall_standard.tpl');
			break;			
		default:
			$template_tmp = $menu_display_mode == 'Horizontal' ? array('body' => 'mx_menu_classic_hor.tpl') : array('body' => 'mx_menu_classic_ver.tpl');
			break;
	}
	
	switch( $menu_display_mode )
	{
		case 'Overall_navigation':
			$template_tmp = array('body' => "mx_menu_overall_standard.$tplEx");
			break;
		default:
			$template_tmp = $template_tmp;
			break;
	}	
}

$template->set_filenames($template_tmp);

generate_site_menu($page_parent);

$cat_width = $num_of_cats > 0 ? ceil(100 / $num_of_cats) . '%' : '100%';

$template->assign_vars(array(
	'BLOCK_SIZE'			=> ( !empty($block_size) ? $block_size : '100%' ),
	'L_TITLE'				=> $title,
	'L_DESC'				=> $b_description,
	'NUM_OF_CATS'			=> $num_of_cats,
	'NUM_OF_CATS_EDIT'		=> $num_of_cats - 1,
	'CAT_WIDTH'				=> $cat_width,

	//+ mxp
	'U_PORTAL_ROOT_PATH' 	=> PORTAL_URL,
	'U_PHPBB_ROOT_PATH' 	=> PHPBB_URL,
	'TEMPLATE_ROOT_PATH'	=> TEMPLATE_ROOT_PATH,
	

	//
	// mygosmenu
	//
	'MX_ROOT_PATH'			=> $mx_root_path,
	'T_TR_COLOR1' 			=> '#'.$theme['tr_color1'],
	'T_TR_COLOR2' 			=> '#'.$theme['tr_color2'],
	'T_TR_COLOR3' 			=> '#'.$theme['tr_color3'],
	'T_BODY_LINK' 			=> '#'.$theme['body_link'],
	'T_BODY_VLINK' 			=> '#'.$theme['body_vlink'],
	'T_TH_COLOR1' 			=> '#'.$theme['th_color1'],
	'T_FONTFACE1' 			=> $theme['fontface1'],
	'IMG_CONTRACT' 			=> $images['mx_contract'],
	'IMG_EXPAND' 			=> $images['mx_expand'],
	'MENU_MODE'				=> $menu_display_mode,
	'MENU_ID'				=> $block_id
));

$template->pparse('body');
?>