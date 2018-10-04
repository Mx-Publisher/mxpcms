<?php
/**
*
* @package MX-Publisher Module - mx_navmenu
* @version $Id: mx_menu_nav.php,v 1.36 2008/09/04 18:05:27 orynider Exp $
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
$config_name = array('menu_custom_tpl', 'menu_display_mode');

for( $i = 0; $i < count($config_name); $i++ )
{
	$config_value = $mx_block->get_parameters( $config_name[$i] );
	$mx_menu_config[$config_name[$i]] = $config_value;
}

//
// Define some parameters
//
$menu_custom_tpl = $mx_menu_config['menu_custom_tpl'];
$menu_display_mode = $mx_menu_config['menu_display_mode'];

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
$virtual_id = $mx_request_vars->request('virtual', MX_TYPE_INT, '');

if (!empty($menu_custom_tpl) && !in_array($menu_custom_tpl, array('Classic','Advanced','Simple_CSS_menu','Advanced_CSS_menu','Overall_navigation')))
{
	$template_tmp = $menu_custom_tpl;
	$template_tmp_path = str_replace(strrchr($template_tmp, '/'), '', $template_tmp) . '/';
	$kick_js = file_exists($mx_root_path . $module_root_path . 'templates/' .$mx_user->template_names[$module_root_path] . $template_tmp_path) ? ($menu_display_mode == 'Horizontal' ? 'horizontal' : 'vertical') : '';
	if (!empty($kick_js))
	{
		$mx_page->add_footer_text( 'templates/' . $mx_user->template_names[$module_root_path] . $template_tmp_path . $kick_js . '.js', true );
	}
}
else
{
	switch( $menu_display_mode )
	{
		case 'Horizontal':
			$template_tmp = "mx_menu_horizontal.$tplEx";
			break;
		case 'Vertical':
			$template_tmp = "mx_menu_vertical.$tplEx";
			break;
		case 'Overall_navigation':
			$template_tmp = "mx_menu_overall_navigation.$tplEx";
			break;
		default:
			$template_tmp = "mx_menu_vertical.$tplEx";
			break;
	}
}

$template->set_filenames(array('body' => $template_tmp));

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
		if (!$hasCurrentMenu)
		{
			if ($mx_request_vars->is_get('dynamic_block') ? $menuData['block_id'] == $mx_request_vars->get('dynamic_block', MX_TYPE_INT) : false )
			{
				$catData[$key]['is_current'] = true;
			}
			else if ( $menuData['page_id'] == $page_id && $menuData['block_id'] == 0  && !$mx_request_vars->is_get('dynamic_block'))
			{
				$catData[$key]['is_current'] = true;
			}
			else if ( $menu_display_mode == 'Overall_navigation' && $current_cat && $menuData['page_id'] == $page_id )
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
	global $mx_bbcode;

	$cat = ( !empty($lang[$cat_title]) ? $lang[$cat_title] : $cat_title );
	$bbcode_uid = $catData[0]['bbcode_uid'];
	$cat = $mx_bbcode->decode($cat, $bbcode_uid, false);

	$cat_desc = '';
	$cat_desc = $catData[0]['cat_desc'];
	$cat_desc = $mx_bbcode->decode($cat_desc, $bbcode_uid, false);

	//
	// Is this category a custom link? If not, link to first menu page.
	//
	$cat_target = ( $catData[0]['cat_target'] == 0 ) ? '' : '_blank';
	$cat_url_tmp = mx_append_sid(PORTAL_URL . 'index.php?page=' . $catData[0]['cat_url'] . '&cat_link=' . intval($cat_id));
	$cat_url_tmp_this = mx_append_sid(PORTAL_URL . 'index.php?page=' . $page_id);
	$catt = ( $catData[0]['cat_url'] != 0 ) ? '<a class="nav" href="' . $cat_url_tmp . '" target="' . $cat_target . '" /><span class="nav">' . $cat . '</span></a>' : '<span class="nav">' . $cat . '</span>';
	$cat_url = ( $catData[0]['cat_url'] != 0 ) ? $cat_url_tmp : $cat_url_tmp_this;

	//
	// For overall_header navigation
	// - is this current page category?
	$current_cat = ($pageMapping[$mx_page->page_id] == $cat_id || $mx_request_vars->is_get('cat_link') ? $mx_request_vars->get('cat_link', MX_TYPE_INT) == $cat_id : false) ? true : false;

	//
	// Update cookie - if this was a cat link
	//
	if ( $mx_request_vars->is_get('cat_link') ? $mx_request_vars->get('cat_link', MX_TYPE_INT) == $cat_id : false || $current_cat)
	{
		setcookie('mxNavCat_' . intval($block_id) . intval($cat_id), true, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
		$_COOKIE['mxNavCat_' . $block_id . $cat_id] = 1;
	}

	//
	// Generate the fold/unfold categories switches
	//
	//echo(intval($current_cat) . intval($hasCurrentMenu) . intval($_COOKIE['mxNavCat_' . $block_id . $cat_id]));
	$cat_on = $current_cat || $hasCurrentMenu ? true : ( isset($_COOKIE['mxNavCat_' . $block_id . $cat_id]) ? $_COOKIE['mxNavCat_' . $block_id . $cat_id] == 1 : $catData[0]['cat_show'] == 1 );

	$style = $catData[0]['cat_url'] == $page_id && !$hasCurrentMenu ? 'cattitle' : 'genmed';

	$template->assign_block_vars('catrow', array(
		'CAT_ID'				=> intval($cat_id),
		'BLOCK_ID'				=> intval($block_id),
		'CATEGORY'				=> $catt,
		'CATEGORY_NAME'			=> $cat,
		'CATEGORY_STYLE'		=> $style,
		'U_CATEGORY_URL'		=> $cat_url,
		'U_CAT_NAV_CONTRACT' 	=> $images['mx_contract'],
		'U_CAT_NAV_EXPAND' 		=> $images['mx_expand'],
		'U_CAT_NAV_DYNAMIC' 	=> $cat_on ? $images['mx_contract'] : $images['mx_expand'],
		'CAT_SHOW' 				=> $cat_on ? '' : 'none',
		'CURRENT' 				=> $current_cat ? '-current' : '',
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
		$action = $mx_bbcode->decode($action, $bbcode_uid, false);


		$style = $menuData['is_current'] ? 'cattitle' : 'genmed';

		//
		// Get menu icon
		//
		if (empty($menuData['menu_alt_icon']))
		{
			$icon_tmp = ( file_exists($mx_root_path . $images['mx_graphics']['menu_icons'] . '/' . $menuData['menu_icon']) ? $menuData['menu_icon'] : 'icon_blank.gif' );
			$icon_url_hot = str_replace('.gif', '_hot.gif', $icon_tmp);

			if ( file_exists($mx_root_path . $images['mx_graphics']['menu_icons'] . '/' . $icon_url_hot) )
			{
				$icon_url = ( $menuData['is_current'] ) ? $icon_url_hot : $icon_tmp;
				$icon_style = ( $menuData['is_current'] ) ? 'mx_icon_hot' : 'mx_icon';
			}
			else
			{
				$icon_url = $icon_tmp;
				$icon_style = '';
			}

			$icon_url = PORTAL_URL . $images['mx_graphics']['menu_icons'] . '/' . $icon_url;
			$menu_icon = ( !empty($menuData['menu_icon']) && $menuData['menu_icon'] != 'none' ) ? '<img class="'.$icon_style.'" border="0" align="absmiddle" src="' . $icon_url . '" alt="' . $desc . '" />&nbsp;' : '';
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

		//
		// Virtual
		//
		$menu_link = !empty($virtual_id) ? $menu_link . '&amp;virtual=' . $virtual_id : $menu_link;

		$link_target = ( $menuData['link_target'] == 0 || $menuData['link_target'] == 2 ) ? '' : '_blank';
		$row_color_over = $theme['tr_color2'];

		$menu_array = array(
			'ROW_COLOR_OVER'	=> '#' . $row_color_over,
			'MENU_NAME'			=> $action,
			'MENU_STYLE'		=> $style,
			'MENU_DESC'			=> $desc,
			'MENU_SEP'			=> $menu_sep,
			'U_MENU_URL'		=> $menu_link,
			'U_MENU_URL_TARGET'	=> $link_target,
			'U_MENU_ICON'		=> $menu_icon,
			'MENU_ICON'			=> $icon_url,
			'CURRENT' 			=> $menuData['is_current'] ? '-current' : '',
		);

		$template->assign_block_vars('catrow.menurow', $menu_array);

		if ($current_cat)
		{
			$template->assign_block_vars('menurow', $menu_array);
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
	// css
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