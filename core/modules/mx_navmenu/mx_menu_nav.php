<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: mx_menu_nav.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
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
$config_name = array('menu_display_style', 'menu_display_mode', 'menu_page_sync');

for( $i = 0; $i < count($config_name); $i++ )
{
	$config_value = $mx_block->get_parameters( $config_name[$i] );
	$mx_menu_config[$config_name[$i]] = $config_value;
}

//
// Define some parameters
//
$menu_display_style = $mx_menu_config['menu_display_style'];
$menu_display_mode = $mx_menu_config['menu_display_mode'];
$menu_page_sync = ( $mx_menu_config['menu_page_sync'] != 'No' );

//
// Prevent this block to be used both in overall_header and as a block
// Define this menu block has been used on this page - either as a block or in the header. To avoid it being used several times
//
$nav_def_key = 'MX_NAV_MENU_' . $block_id;

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

$template->set_filenames($template_tmp);

//
// Get menu data
//
if ( $mx_cache->_exists( '_menu_' . $block_id ) )
{
	$mx_nav_data = $mx_cache->get( '_menu_' . $block_id );
}
else
{
	$mx_nav_data = mx_get_nav_menu($block_id);
	$mx_cache->put( '_menu_' . $block_id, $mx_nav_data );
}

$navCategory = $mx_nav_data['navcategory'];
$pageMapping = $mx_nav_data['pagemapping'];

$num_of_cats = count($navCategory);
foreach($navCategory as $cat_id => $catData)
{
	$hasCurrentMenu = false;

	//
	// Check if this Category contains any authorized menus, or any at all
	//
	$menuIsCat = false;
	foreach($catData as $key => $menuData)
	{
		//
		// Find if user is allowed for view menu
		//
		$is_auth_ary = menu_auth(AUTH_VIEW, $menuData['menu_id'], $userdata, $menuData, $menuData['auth_view_group']);

		if ( !$is_auth_ary['auth_view'] )
		{
			continue;
		}

		$menuIsCat = true;
		if ($catData[0]['cat_url'] == 0 && $menuData['page_id'] != 0)
		{
			$catData[0]['cat_url'] = $menuData['page_id'];
		}

		//
		// Highlight current menu
		//
		$catData[$key]['is_current'] = false;
		if ( $menu_page_sync && !$hasCurrentMenu)
		{
			if ( isset($HTTP_GET_VARS['dynamic_block']) ? $menuData['block_id'] == $HTTP_GET_VARS['dynamic_block'] : false )
			{
				$catData[$key]['is_current'] = true;
			}
			else if ( $menuData['page_id'] == $page_id && $menuData['block_id'] == 0  )
			{
				$catData[$key]['is_current'] = true;
			}
			else if ( $menu_display_style == 'Overall_navigation' && $current_cat && $menuData['page_id'] == $page_id )
			{
				$catData[$key]['is_current'] = true;
			}
			$hasCurrentMenu = $catData[$key]['is_current'];
		}

	}

	if(!$menuIsCat)
	{
		continue;
	}

	$cat_title = $catData[0]['cat_title'];

	$cat = ( !empty($lang[$cat_title]) ? $lang[$cat_title] : $cat_title );
	$bbcode_uid = $catData[0]['bbcode_uid'];
	$cat = mx_decode($cat, $bbcode_uid, false);

	$cat_desc = '';
	$cat_desc = $catData[0]['cat_desc'];
	$cat_desc = mx_decode($cat_desc, $bbcode_uid, false);

	//
	// Is this category a custom link? If not, link to first menu page.
	//
	$cat_target = ( $catData[0]['cat_target'] == 0 ) ? '' : '_blank';
	$cat_url_tmp = mx_append_sid(PORTAL_URL . 'index.php?page=' . $catData[0]['cat_url'] . '&cat_link=' . intval($cat_id));
	$catt = ( $catData[0]['cat_url'] != 0 ) ? '<a class="nav" href="' . $cat_url_tmp . '" target="' . $cat_target . '" /><span class="nav">' . $cat . '</span></a>' : '<span class="nav">' . $cat . '</span>';
	$cat_url = ( $catData[0]['cat_url'] != 0 ) ? $cat_url_tmp : 'javascript:void(0)';

	//
	// For overall_header navigation
	// - is this current page category?
	$current_cat = ($pageMapping[$mx_page->page_id] == $cat_id || ( isset($HTTP_GET_VARS['cat_link']) ? intval($HTTP_GET_VARS['cat_link']) == $cat_id : false) ) ? true : false;

	//
	// Update cookie - if this was a cat link
	//
	if ( (isset($HTTP_GET_VARS['cat_link']) ? intval($HTTP_GET_VARS['cat_link']) == $cat_id : false) || $current_cat)
	{
		setcookie('mxNavCat_' . intval($block_id) . intval($cat_id), true, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
		$HTTP_COOKIE_VARS['mxNavCat_' . $block_id . $cat_id] = 1;
	}
	
	$cat_nav_icon_url = PORTAL_URL . $current_template_path . '/images/';	

	//
	// Generate the fold/unfold categories switches
	//
	$cat_on = $current_cat || $hasCurrentMenu ? true : ( isset($HTTP_COOKIE_VARS['mxNavCat_' . $block_id . $cat_id]) ? $HTTP_COOKIE_VARS['mxNavCat_' . $block_id . $cat_id] == 1 : $catData[0]['cat_show'] == 1 );
	$style = $catData[0]['cat_url'] == $page_id && !$hasCurrentMenu ? 'cattitle' : 'genmed';

	$template->assign_block_vars('catrow', array(
		'CAT_ID'				=> intval($cat_id),
		'BLOCK_ID'				=> intval($block_id),
		'CATEGORY'				=> $catt,
		'CATEGORY_NAME'			=> $cat,
		'CATEGORY_STYLE'		=> $style,
		'CATEGORY_URL'			=> $cat_url,
		'U_CATEGORY_URL'		=> $cat_url, // For compatibility with 2.9.x+
		'U_CAT_NAV_CONTRACT' 	=> $cat_nav_icon_url . 'minus.gif',
		'U_CAT_NAV_EXPAND' 		=> $cat_nav_icon_url . 'plus.gif',
		'U_CAT_NAV_DYNAMIC' 	=> $cat_on ? $cat_nav_icon_url . 'minus.gif' : $cat_nav_icon_url . 'plus.gif',
		'CAT_SHOW' 				=> $cat_on ? '' : 'none',
		'CURRENT' 				=> $current_cat ? '-current' : ''
	));

	if ( $catData[0]['cat_url'] != 0 )
	{
		$template->assign_block_vars('catrow.menurow_cat', array(
			'CATEGORY_NAME'			=> $cat,
			'U_CATEGORY_URL'		=> $cat_url,
			'CATEGORY_STYLE'		=> $style,
		));
	}

	if (!empty($cat_desc))
	{
		$template->assign_block_vars('catrow.switch_cat_desc', array(
			'CAT_DESC'	=> $cat_desc
		));
	}

	//
	// Loop through each menu in this category
	//
	$first_menu = true;
	foreach($catData as $key => $menuData)
	{
		//
		// Find if user is allowed for view menu
		//
		$is_auth_ary = menu_auth(AUTH_VIEW, $menuData['menu_id'], $userdata, $menuData, $menuData['auth_view_group']);

		if ( !$is_auth_ary['auth_view'] )
		{
			continue;
		}

		$menu_sep = $first_menu ? '' : '|';
		$first_menu = false;

		$action = $menuData['menu_name'];
		$action = ( !empty($lang[$action]) ? $lang[$action] : $action );

		$desc = $menuData['menu_desc'];
		$desc = ( !empty($lang[$desc]) ? $lang[$desc] : $desc );

		$bbcode_uid = $menuData['bbcode_uid'];
		$action = mx_decode($action, $bbcode_uid, false);


		$style = $menuData['is_current'] ? 'cattitle' : 'genmed';
		
		//
		// Get menu icon
		//
		if (empty($menuData['menu_alt_icon']))
		{
			$icon_tmp = (@file_exists($mx_root_path . $current_template_path . '/images/menu_icons/' . $menuData['menu_icon']) ? $menuData['menu_icon'] : 'icon_blank.gif');
			$icon_url_hot = str_replace('.gif', '_hot.gif', $icon_tmp);

			if (@file_exists($mx_root_path . $current_template_path . '/images/menu_icons/' . $icon_url_hot) )
			{
				$icon_url = ( $menuData['is_current'] ) ? $icon_url_hot : $icon_tmp;
				$icon_style = ( $menuData['is_current'] ) ? 'mx_icon_hot' : 'mx_icon';
			}
			else
			{
				$icon_url = $icon_tmp;
				$icon_style = '';
			}

			$menu_icon = ( !empty($menuData['menu_icon']) && $menuData['menu_icon'] != 'none' ) ? '<img class="'.$icon_style.'" border="0" align="absmiddle" src="' . $current_template_path . '/images/menu_icons/' . $icon_url . '" alt="' . $desc . '" />&nbsp;' : '';
		}
		else
		{
			$icon_url = ( $menuData['is_current'] ) ? (!empty($menuData['menu_alt_icon_hot']) ? $menuData['menu_alt_icon_hot'] : $menuData['menu_alt_icon']) : $menuData['menu_alt_icon'];
			$menu_icon = '<img border="0" align="absmiddle" src="' . $icon_url . '" alt="' . $desc . '" />&nbsp;';
		}

		//
		// Generate Links
		//
		if ( $menuData['page_id'] != 0 && $menuData['block_id'] == 0 && $menuData['link_target'] != 2 )
		{
			$menu_link = mx_append_sid(PORTAL_URL . 'index.php?page=' . $menuData['page_id']);
		}
		else if ( $menuData['page_id'] != 0 && $menuData['link_target'] == 2 )
		{
			$menu_link = mx_append_sid(PORTAL_URL . 'index.php?page=' . $menuData['page_id'] . '&amp;' . $menuData['menu_links']);
		}
		else if ( $menuData['link_target'] == 2 )
		{
			$menu_link = mx_append_sid(PORTAL_URL . 'index.php?page=' . $page_id . '&amp;' . $menuData['menu_links']);
		}
		else if ( $menuData['menu_links'] != '' )
		{
			$menu_link = ( substr_count($menuData['menu_links'], 'http://') == 0 ? PORTAL_URL . $menuData['menu_links'] : $menuData['menu_links'] );
		}
		else if ( $menuData['page_id'] == 0 && $menuData['block_id'] != 0 )
		{
			$menu_link = mx_append_sid(PORTAL_URL . 'index.php?page=' . $page_id . '&amp;dynamic_block=' . $menuData['block_id']);
		}
		else if ( $menuData['page_id'] != 0 && $menuData['block_id'] != 0 )
		{
			$menu_link = mx_append_sid(PORTAL_URL . 'index.php?page=' . $menuData['page_id'] . '&amp;dynamic_block=' . $menuData['block_id']);
		}

		$link_target = ( $menuData['link_target'] == 0 || $menuData['link_target'] == 2 ) ? '' : '_blank';
		$row_color_over = $theme['tr_color2'];

		$menu_array = array(
			'ROW_COLOR_OVER'	=> '#' . $row_color_over,
			'MENU_NAME'			=> $action,
			'MENU_STYLE'		=> $style,
			'MENU_DESC'			=> $desc,
			'MENU_SEP'			=> $menu_sep,

			'U_MENU_MODULE'		=> $menu_link,
			'U_LINK_TARGET'		=> $link_target,
			'U_MENU_ICON'		=> $menu_icon,

			// For compatibility with 2.9.x+
			'U_MENU_URL'		=> $menu_link,
			'U_MENU_URL_TARGET'	=> $link_target,
			'MENU_ICON'			=> $icon_url,
			'CURRENT' 			=> $menuData['is_current'] ? '-current' : '',
		);

		$template->assign_block_vars('catrow.modulerow', $menu_array);
		$template->assign_block_vars('catrow.menurow', $menu_array); // For compatibility with 2.9.x+

		if ($current_cat)
		{
			$template->assign_block_vars('modulerow', $menu_array);
			$template->assign_block_vars('menurow', $menu_array); // For compatibility with 2.9.x+
		}
	}
}

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
	'TEMPLATE_IMAGES_PATH'	=> $images['mx_menu_images'], // Full path

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