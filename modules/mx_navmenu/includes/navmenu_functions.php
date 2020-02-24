<?php
/**
*
* @package MX-Publisher Module - mx_navmenu
* @version $Id: navmenu_functions.php,v 3.17 2020/02/24 04:49:09 orynider Exp $
* @copyright (c) 2002-2008 [Martin, Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
*
*/

/********************************************************************************\
|	$type's accepted (pre-pend with AUTH_):
|	VIEW, READ, POST, REPLY, EDIT, DELETE, STICKY, ANNOUNCE, VOTE, POLLCREATE
|
|	Possible options ($type/module_id combinations):
|
|	* If you include a type and module_id then a specific lookup will be done and
|	the single result returned
|
|	* If you set type to AUTH_ALL and specify a module_id an array of all auth types
|	will be returned
|
|	* If you provide a module_id a specific lookup on that module will be done
|
|	* If you set module_id to AUTH_LIST_ALL and specify a type an array listing the
|	results for all modules will be returned
|
|	* If you set module_id to AUTH_LIST_ALL and type to AUTH_ALL a multidimensional
|	array containing the auth permissions for all types and all modules for that
|	user is returned
|
|	All results are returned as associative arrays, even when a single auth type is
|	specified.
|
|	If available you can send an array (either one or two dimensional) containing the
|	module auth levels, this will prevent the auth function having to do its own
|	lookup
\********************************************************************************/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

function menu_auth($type, $menu_id, $userdata, $f_access = '', $f_access_group = '')
{
	global $db, $lang;

	switch( $type )
	{
		case AUTH_ALL:
			$a_sql = 'a.auth_view';
			$auth_fields = array('auth_view');
			break;

		case AUTH_VIEW:
			$a_sql = 'a.auth_view';
			$auth_fields = array('auth_view');
			break;

		default:
			break;
	}

	//
	// If f_access has been passed, or auth is needed to return an array of menus
	// then we need to pull the auth information on the given menu (or all menus)
	//
	$is_admin = ( $userdata['user_level'] == ADMIN && $userdata['session_logged_in'] ) ? TRUE : 0;

	$auth_user = array();
	for( $i = 0; $i < count($auth_fields); $i++ )
	{
		$key = $auth_fields[$i];

		//
		// If the user is logged on and the menu type is either ALL or REG then the user has access
		//
		// If the type if ACL, MOD or ADMIN then we need to see if the user has specific permissions
		// to do whatever it is they want to do ... to do this we pull relevant information for the
		// user (and any groups they belong to)
		//
		// Now we compare the users access level against the menus. We assume here that a moderator
		// and admin automatically have access to an ACL menu, similarly we assume admins meet an
		// auth requirement of MOD
		//
		$value = $f_access[$key];

		switch( $value )
		{
			case AUTH_ALL:
				$auth_user[$key] = TRUE;
				$auth_user[$key . '_type'] = $lang['Auth_Anonymous_Users'];
				break;

			case AUTH_REG:
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? TRUE : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Registered_Users'];
				break;

			case AUTH_ANONYMOUS:
				$auth_user[$key] = ( ! $userdata['session_logged_in'] ) ? TRUE : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Anonymous_Users'];
				break;

			case AUTH_ACL:
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($f_access_group) || $is_admin : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Users_granted_access'];
				break;

			case AUTH_MOD:
				$auth_user[$key] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($f_access_group) || $is_admin : 0;
				$auth_user[$key . '_type'] = $lang['Auth_Moderators'];
				break;

			case AUTH_ADMIN:
				$auth_user[$key] = $is_admin;
				$auth_user[$key . '_type'] = $lang['Auth_Administrators'];
				break;

			default:
				$auth_user[$key] = 0;
				break;
		}
	}

	//
	// Is user a moderator?
	// $auth_user['auth_mod'] = ( $userdata['session_logged_in'] ) ? mx_is_group_member($f_access_group) || $is_admin : 0;

	return $auth_user;
}

/**
 * UserCP Panel
 *
 * @access public
 * @param unknown_type $block_id
 * @return unknown
 */
function mx_get_nav_menu($block_id)
{
	global $db;

	$sql = "SELECT *
		FROM " . MENU_CAT_TABLE . " cat,
			" . MENU_NAV_TABLE . " nav
		WHERE cat.block_id = '" . $block_id . "'
				AND cat.cat_id = nav.cat_id
		ORDER BY cat.cat_order, nav.menu_order";

	if ( !( $result = $db->sql_query( $sql ) ) )
	{
		mx_message_die( GENERAL_ERROR, 'Couldnt query Navigation Menu', '', __LINE__, __FILE__, $sql );
	}

	$mx_nav_data = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$num_of_menus = count($mx_nav_data);

	//
	// Generate Page to Menu Cat mapping
	//
	$cat_id = 0;
	$num_of_cats = 0;
	$navCategory = array();
	$pageMapping = array();
	for( $menu_count = 0; $menu_count < $num_of_menus; $menu_count++ )
	{
		//
		// New category
		//
		if ( $cat_id != $mx_nav_data[$menu_count]['cat_id'] )
		{
			if ($mx_nav_data[$menu_count]['cat_url'] != '0' && !isset($pageMapping[$mx_nav_data[$menu_count]['cat_url']]))
			{
				$pageMapping[$mx_nav_data[$menu_count]['cat_url']] = $mx_nav_data[$menu_count]['cat_id'];
			}
		}

		$cat_id	= $mx_nav_data[$menu_count]['cat_id'];

		//
		// Menu Maps
		//
		if ($mx_nav_data[$menu_count]['page_id'] != '0' && !isset($pageMapping[$mx_nav_data[$menu_count]['page_id']]))
		{
			$pageMapping[$mx_nav_data[$menu_count]['page_id']] = $mx_nav_data[$menu_count]['cat_id'];
		}

		//
		// Group categories
		//
		$navCategory[$mx_nav_data[$menu_count]['cat_id']][] = $mx_nav_data[$menu_count];
	}

	unset($mx_nav_data);

	return ( array('pagemapping' => $pageMapping, 'navcategory' => $navCategory) );
}

/**
 * UserCP Panel
 *
 * @access public
 * @param unknown_type $block_id
 * @return unknown
 */
function mx_get_site_menu($block_id)
{
	global $db;

	$sql = "SELECT *
		FROM " . MENU_CAT_TABLE . " cat,
			" . MENU_NAV_TABLE . " nav
		WHERE cat.block_id = '" . $block_id . "'
				AND cat.cat_id = nav.cat_id
		ORDER BY cat.cat_order, nav.menu_order";

	if ( !( $result = $db->sql_query( $sql ) ) )
	{
		mx_message_die( GENERAL_ERROR, 'Couldnt query Navigation Menu', '', __LINE__, __FILE__, $sql );
	}

	$mx_nav_data = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$num_of_menus = count($mx_nav_data);

	//
	// Generate Page to Menu Cat mapping
	//
	$cat_id = 0;
	$num_of_cats = 0;
	$navCategory = array();
	$pageMapping = array();
	for( $menu_count = 0; $menu_count < $num_of_menus; $menu_count++ )
	{
		//
		// New category
		//
		if ( $cat_id != $mx_nav_data[$menu_count]['cat_id'] )
		{
			if ($mx_nav_data[$menu_count]['cat_url'] != '0' && !isset($pageMapping[$mx_nav_data[$menu_count]['cat_url']]))
			{
				$pageMapping[$mx_nav_data[$menu_count]['cat_url']] = $mx_nav_data[$menu_count]['cat_id'];
			}
		}

		$cat_id	= $mx_nav_data[$menu_count]['cat_id'];

		//
		// Menu Maps
		//
		if ($mx_nav_data[$menu_count]['page_id'] != '0' && !isset($pageMapping[$mx_nav_data[$menu_count]['page_id']]))
		{
			$pageMapping[$mx_nav_data[$menu_count]['page_id']] = $mx_nav_data[$menu_count]['cat_id'];
		}

		//
		// Group categories
		//
		$navCategory[$mx_nav_data[$menu_count]['cat_id']][] = $mx_nav_data[$menu_count];
	}

	unset($mx_nav_data);

	return ( array('pagemapping' => $pageMapping, 'navcategory' => $navCategory) );
}

/**
 * Enter description here...
 *
 * @param unknown_type $cat_parent
 * @param unknown_type $depth
 */
function generate_site_menu( $page_parent = 0, $depth = 0, $current_parent_page = false )
{
	global $mx_page, $mx_bbcode, $language, $lang, $template, $phpEx, $images, $block_id, $mx_root_path;

	if ( isset( $mx_page->subpage_rowset[$page_parent] ) )
	{
		$first_menu = true;
		foreach( $mx_page->subpage_rowset[$page_parent] as $subpage_id => $page_data )
		{
			// Define the global bbcode bitfield, will be used to load bbcodes
			$bbcode_uid = $page_data['bbcode_uid'];
			$bbcode_bitfield = 'cA==';
			//$bbcode_bitfield = $bbcode_bitfield | base64_decode($catData[0]['bbcode_bitfield']);	
			// Instantiate BBCode if need be
			if ($bbcode_bitfield !== '')
			{
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'phpbb2':
					case 'smf2':
					case 'mybb':
						$mx_bbcode = new mx_bbcode();
					break;
					case 'phpbb3':
					case 'olympus':
					case 'ascraeus':
					default:
						$mx_bbcode = new mx_bbcode(base64_encode($bbcode_bitfield));
					break;
				}
			}
			
			// Auth check
			$_auth_ary = $mx_page->auth($page_data['auth_view'], $page_data['auth_view_group'], $page_data['auth_moderator_group']);
			if ($_auth_ary['auth_view'] && $page_data['menu_active'])
			{
				if ( $depth == 0 )
				{
					$cat = $page_data['page_name'];
					$cat = ((mb_strlen($lang[str_replace(' ', '_', $cat)]) !== 0) ? $lang[str_replace(' ', '_', $cat)] : $language->lang($cat));
					
					$desc = $page_data['page_desc'];
					$desc = ((mb_strlen($lang[str_replace(' ', '_', $desc)]) !== 0) ? $lang[str_replace(' ', '_', $desc)] : $language->lang($desc));
					$desc = $mx_bbcode->decode($desc, $bbcode_uid, false);
					
					//
					// Is this category a custom link? If not, link to first menu page.
					//
					$cat_target = ( true ) ? '' : '_blank';
					$cat_url_tmp = mx_append_sid(PORTAL_URL . 'index.php?page=' . $page_data['page_id'] . '&cat_link=' . $page_data['page_id']);
					$catt = ( true ) ? '<a class="nav" href="' . $cat_url_tmp . '" target="' . $cat_target . '" /><span class="nav">' . $cat . '</span></a>' : '<span class="nav">' . $cat . '</span>';
					$cat_url = ( true ) ? $cat_url_tmp : 'javascript:void(0)';

					//
					// Get menu icon
					//
					if (true)
					{
						$icon_tmp = ( file_exists($mx_root_path . $images['mx_graphics']['menu_icons'] . '/' . $page_data['menu_icon']) ? $page_data['menu_icon'] : 'icon_blank.gif' );
						$icon_url_hot = str_replace('.gif', '_hot.gif', $icon_tmp);

						if ( file_exists($mx_root_path . $images['mx_graphics']['menu_icons'] . '/' . $icon_url_hot) )
						{
							$icon_url = ( $page_data['is_current'] ) ? $icon_url_hot : $icon_tmp;
							$icon_style = ( $page_data['is_current'] ) ? 'mx_icon_hot' : 'mx_icon';
						}
						else
						{
							$icon_url = $icon_tmp;
							$icon_style = '';
						}

						$menu_icon = ( !empty($page_data['menu_icon']) && $page_data['menu_icon'] != 'none' ) ? '<img class="'.$icon_style.'" border="0" align="absmiddle" src="' . PORTAL_URL . $images['mx_graphics']['menu_icons'] . '/' . $icon_url . '" alt="' . $desc . '" />&nbsp;' : '';
					}
					else
					{
						$icon_url = ( $is_current ) ? (!empty($page_data['menu_alt_icon_hot']) ? $page_data['menu_alt_icon_hot'] : $page_data['menu_alt_icon']) : $page_data['menu_alt_icon'];
						$menu_icon = '<img border="0" align="absmiddle" src="' . $icon_url . '" alt="' . $desc . '" />&nbsp;';
					}

					//
					// For overall_header navigation
					// - is this current page category?
					//$current_parent_page = ($mx_page->page_id == $page_data['page_id'] || has_active_subpage($subpage_id) || ( isset($_GET['cat_link']) ? intval($_GET['cat_link']) == $page_data['page_id'] : false) ) ? true : false;
					$current_parent_page = ($mx_page->page_id == $page_data['page_id'] || has_active_subpage($subpage_id) ) ? true : false;

					//
					// Update cookie - if this was a cat link
					//
					if ( (isset($_GET['cat_link']) ? intval($_GET['cat_link']) == $page_data['page_id'] : false) || $current_parent_page)
					{
						setcookie('mxNavCat_' . intval($block_id) . intval($page_data['page_id']), true, (time()+21600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
						$_COOKIE['mxNavCat_' . $block_id . $page_data['page_id']] = 1;
					}

					//
					// Generate the fold/unfold categories switches
					//
					$cat_on = $current_parent_page ? true : ( isset($_COOKIE['mxNavCat_' . $block_id . $page_data['page_id']]) ? $_COOKIE['mxNavCat_' . $block_id . $page_data['page_id']] == 1 : $catData[0]['cat_show'] == 1 );
					$menu_sep = $first_menu ? '' : '|';
					$style = $current_parent_page ? 'cattitle' : 'genmed';
					$first_menu = false;

					$template->assign_block_vars('catrow', array(
						'CAT_ID'				=> intval($page_data['page_id']),
						'BLOCK_ID'				=> intval($block_id),
						'CATEGORY'				=> $catt,
						'CATEGORY_NAME'			=> $cat,
						'U_CATEGORY_URL'		=> $cat_url,
						'U_CAT_NAV_CONTRACT' 	=> $images['mx_contract'],
						'U_CAT_NAV_EXPAND' 		=> $images['mx_expand'],
						'U_CAT_NAV_DYNAMIC' 	=> $cat_on ? $images['mx_contract'] : $images['mx_expand'],
						'CAT_SHOW' 				=> $cat_on ? '' : 'none',
						'U_MENU_ICON'			=> $menu_icon,
						'CURRENT' 				=> $current_parent_page ? '-current' : '',
						'MENU_SEP'				=> $menu_sep,

						//
						// Overall Nav
						//
						'U_CATEGORY_URL'			=> $cat_url,
						'U_CATEGORY_URL_TARGET'		=> $link_target,
						'CATEGORY_NAME'				=> $cat,
						'CATEGORY_DESC'				=> $desc,
						'CATEGORY_STYLE'			=> $style,

					));

					if ($current_parent_page)
					{
						//
						// Overall Nav
						//
						$is_current = $mx_page->page_id == $page_data['page_id'];
						$style = $is_current ? 'cattitle' : 'genmed';
						$link_target = ( true ) ? '' : '_blank';

						$template->assign_block_vars('menurow_cat', array(
							//
							// Overall Nav
							//
							'U_CATEGORY_URL'		=> $cat_url,
							'U_CATEGORY_URL_TARGET' => $link_target,
							'CATEGORY_NAME'			=> $cat,
							'CATEGORY_DESC'			=> $desc,
							'CATEGORY_STYLE'		=> $style,
							'CURRENT' 				=> $is_current ? '-current' : '',
							'MENU_SEP'				=> $menu_sep,
						));
					}

					// Recursive call
					generate_site_menu( $subpage_id, $depth + 1, $current_parent_page );
				}
				else
				{
					output_menu($page_data, $current_parent_page);
				}
			} // End Auth
		}
		return;
	}
	return;
}

function output_menu($page_data, $current_parent_page)
{
	global $mx_page, $template, $phpEx, $images, $block_id, $mx_root_path, $virtual_id;

	$row_color_over = $theme['tr_color2'];

	$is_current = $mx_page->page_id == $page_data['page_id'] || has_active_subpage($page_data['page_id']);
	$action = $page_data['page_name'];
	$action = ( !empty($lang[$action]) ? $lang[$action] : $action );
	$desc = $page_data['page_desc'];
	$style = $is_current ? 'cattitle' : 'genmed';

	$menu_sep = $first_menu ? '' : '|';
	$first_menu = false;

	//
	// Get menu icon
	//
	if (true)
	{
		$icon_tmp = ( file_exists($mx_root_path . $images['mx_graphics']['menu_icons'] . '/' . $page_data['menu_icon']) ? $page_data['menu_icon'] : 'icon_blank.gif' );
		$icon_url_hot = str_replace('.gif', '_hot.gif', $icon_tmp);

		if ( file_exists($mx_root_path . $images['mx_graphics']['menu_icons'] . '/' . $icon_url_hot) )
		{
			$icon_url = ( $page_data['is_current'] ) ? $icon_url_hot : $icon_tmp;
			$icon_style = ( $page_data['is_current'] ) ? 'mx_icon_hot' : 'mx_icon';
		}
		else
		{
			$icon_url = $icon_tmp;
			$icon_style = '';
		}

		$menu_icon = ( !empty($page_data['menu_icon']) && $page_data['menu_icon'] != 'none' ) ? '<img class="'.$icon_style.'" border="0" align="absmiddle" src="' . PORTAL_URL . $images['mx_graphics']['menu_icons'] . '/' . $icon_url . '" alt="' . $desc . '" />&nbsp;' : '';
	}
	else
	{
		$icon_url = ( $is_current ) ? (!empty($page_data['menu_alt_icon_hot']) ? $page_data['menu_alt_icon_hot'] : $page_data['menu_alt_icon']) : $page_data['menu_alt_icon'];
		$menu_icon = '<img border="0" align="absmiddle" src="' . $icon_url . '" alt="' . $desc . '" />&nbsp;';
	}

	//
	// Generate Links
	//
	$menu_link = mx_append_sid(PORTAL_URL . 'index.php?page=' . $page_data['page_id']) . ( !empty($virtual_id) ? '&virtual=' . $virtual_id : '');

	$link_target = ( true ) ? '' : '_blank';

	$menu_array = array(
		'ROW_COLOR_OVER'	=> '#' . $row_color_over,
		'MENU_NAME'			=> $action,
		'MENU_STYLE'		=> $style,
		'MENU_DESC'			=> $desc,
		'MENU_SEP'			=> $menu_sep,
		'U_MENU_URL'		=> $menu_link,
		'U_MENU_URL_TARGET'	=> $link_target,
		'U_MENU_ICON'		=> $menu_icon,
		'CURRENT' 			=> $is_current ? '-current' : '',
	);

	$template->assign_block_vars('catrow.menurow', $menu_array);

	if ($current_parent_page)
	{
		$template->assign_block_vars('menurow', $menu_array);
	}
}

function has_active_subpage($page_parent = 0, $depth = 0)
{
	global $mx_page;

	if ( isset( $mx_page->subpage_rowset[$page_parent] ) )
	{
		foreach( $mx_page->subpage_rowset[$page_parent] as $subpage_id => $page_data )
		{
			if ($mx_page->page_id == $subpage_id)
			{
				return true;
			}
		}
		return has_active_subpage($subpage_id, $depth + 1);;
	}
	return false;
}
?>
