<?php
/**
*
* @package MX-Publisher Module - mx_navmenu
* @version $Id: mx_site_nav.php,v 1.13 2014/05/18 06:24:56 orynider Exp $
* @copyright (c) 2002-2024 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
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
<?php
/**
*
* @package MX-Publisher Module - mx_navmenu
* @version $Id: mx_menu_nav.php,v 1.39 2014/05/09 07:53:11 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
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
$menu_title = $mx_block->block_info['block_title'];
$menu_desc = $mx_block->block_info['block_desc'];

//
// Includes
//
include_once( $module_root_path . 'includes/navmenu_constants.' . $phpEx );
include_once( $module_root_path . 'includes/navmenu_functions.' . $phpEx );

//
// Pass Multilanguage Block Vars
//
$title = ((mb_strlen($lang[str_replace(' ', '_', $menu_title)]) !== 0) ? $lang[str_replace(' ', '_', $menu_title)] : $language->lang($menu_title));
$description = $b_description = (isset($lang[$menu_desc]) ? $lang[$menu_desc] : $menu_desc);

//
// Setup config parameters

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
$menu_custom_tpl = $mx_menu_config['menu_custom_tpl'];
$menu_display_style = $mx_menu_config['menu_display_style'];
$menu_display_mode = $mx_menu_config['menu_display_mode'];
$menu_page_sync = ( $mx_menu_config['menu_page_sync'] != 'No' );
/*	* /
$menu_custom_tpl = '';
$menu_display_style = 'Overall_navigation';
$menu_display_mode = 'Horizontal';
$menu_page_sync = true;
/*	*/
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
			$kick_js = $menu_display_mode == 'Horizontal' ? 'adv_hor.js' : 'adv_ver.js';
			$mx_page->add_footer_text( 'includes/js/' . $kick_js, true );
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
			$kick_js = $menu_display_mode == 'Horizontal' ? 'adv_CSS_hor.js' : 'adv_CSS_ver.js';
			$mx_page->add_footer_text( 'includes/js/' . $kick_js, true );
		break;			
		case 'Overall_navigation':
			$template_tmp = array('body' => 'mx_menu_overall_standard.tpl');
			$kick_js = $menu_display_mode == 'Horizontal' ? 'adv_CSS_hor.js' : 'adv_CSS_ver.js';
			$mx_page->add_footer_text( 'includes/js/' . $kick_js, true );
		break;			
		default:
			$template_tmp = $menu_display_mode == 'Horizontal' ? array('body' => 'mx_menu_classic_hor.tpl') : array('body' => 'mx_menu_classic_ver.tpl');
			$kick_js = $menu_display_mode == 'Horizontal' ? 'adv_CSS_hor.js' : 'adv_CSS_ver.js';
			$mx_page->add_footer_text( 'includes/js/' . $kick_js, true );
		break;
	}
	<?php
/**
*
* @package MX-Publisher Module - mx_navmenu
* @version $Id: mx_menu_nav.php,v 1.39 2014/05/09 07:53:11 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
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
$menu_title = $mx_block->block_info['block_title'];
$menu_desc = $mx_block->block_info['block_desc'];

//
// Includes
//
include_once( $module_root_path . 'includes/navmenu_constants.' . $phpEx );
include_once( $module_root_path . 'includes/navmenu_functions.' . $phpEx );

//
// Pass Multilanguage Block Vars
//
$title = ((mb_strlen($lang[str_replace(' ', '_', $menu_title)]) !== 0) ? $lang[str_replace(' ', '_', $menu_title)] : $language->lang($menu_title));
$description = $b_description = (isset($lang[$menu_desc]) ? $lang[$menu_desc] : $menu_desc);

//
// Setup config parameters

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
/*
* Get menu data
**/
if ( $mx_cache->_exists($nav_def_key) )
{
	$mx_nav_data = $mx_cache->get($nav_def_key);
}
else
{
	$mx_nav_data = mx_get_nav_menu($block_id);
	$mx_cache->put($nav_def_key, $mx_nav_data);
}
$navCategory = $mx_nav_data['navcategory'];
$pageMapping = $mx_nav_data['pagemapping'];

$num_of_cats = count($navCategory);
/*
* Get menu data
**/
$cat_width = ($num_of_cats > 0) ? ceil(100 / $num_of_cats) . '%' : '100%';

$template->assign_vars(array(
	'BLOCK_SIZE'						=> ( !empty($block_size) ? $block_size : '100%' ),
	'L_TITLE'								=> $title,
	'L_DESC'								=> $b_description,
	'NUM_OF_CATS'				=> $num_of_cats,
	'NUM_OF_CATS_EDIT'		=> $num_of_cats - 1,
	'CAT_WIDTH'						=> $cat_width,

	//+ mxp
	'U_PORTAL_ROOT_PATH' 	=> PORTAL_URL,
	'U_PHPBB_ROOT_PATH' 	=> PHPBB_URL,
	'TEMPLATE_ROOT_PATH'	=> TEMPLATE_ROOT_PATH,

	//SEARCH
	'U_SEARCH' 									=> mx_append_sid(PHPBB_URL .'search.'.$phpEx),
	'U_SEARCH_UNANSWERED'	=> mx_append_sid(PHPBB_URL . 'search.'.$phpEx.'?search_id=unanswered'),
	'U_SEARCH_SELF'						=> mx_append_sid(PHPBB_URL .'search.'.$phpEx.'?search_id=egosearch'),
	'U_SEARCH_NEW'						=> mx_append_sid(PHPBB_URL .'search.'.$phpEx.'?search_id=newposts'),

	//
	// mygosmenu
	//
	'MX_ROOT_PATH'			=> $mx_root_path,
	'T_TR_COLOR1' 			=> '#'.$mx_user->theme['tr_color1'],
	'T_TR_COLOR2' 			=> '#'.$mx_user->theme['tr_color2'],
	'T_TR_COLOR3' 			=> '#'.$mx_user->theme['tr_color3'],
	'T_BODY_LINK' 				=> '#'.$mx_user->theme['body_link'],
	'T_BODY_VLINK' 			=> '#'.$mx_user->theme['body_vlink'],
	'T_TH_COLOR1' 			=> '#'.$mx_user->theme['th_color1'],
	'T_FONTFACE1' 			=> $mx_user->theme['fontface1'],
	'IMG_CONTRACT' 			=> $images['mx_contract'],
	'IMG_EXPAND' 				=> $images['mx_expand'],
	'MENU_MODE'				=> $menu_display_mode,
	'MENU_ID'						=> $block_id
));

$template->pparse('body');
?>
