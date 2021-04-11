<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_virtual.php,v 1.2 2014/05/18 06:24:56 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
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
$message = $mx_block->get_parameters( 'Text' );

$block_size = ( !empty( $block_size ) ? $block_size : '100%' );

//
// Read block Configuration
//
$virtualMode = $mx_block->get_parameters( 'Virtual_mode' );

$template->set_filenames( array( "body" => "mx_virtual.tpl" ) );

//
// VirtualCP - DO
//
if (($mx_block->auth_edit || $mx_block->auth_mod))
{
	if ($mx_request_vars->is_get('virtual_action'))
	{
		switch ($virtualMode)
		{
			case 'user':
				$create_id = $userdata['user_id'];
				$opt_data = '';
				$current_id = $mx_request_vars->post('id', MX_TYPE_INT);
			break;
			case 'group':
				$create_id = $mx_request_vars->post('group_id', MX_TYPE_INT);
				$opt_data = '';
				$current_id = $mx_request_vars->post('id', MX_TYPE_INT);
			break;
			case 'project':
				$create_id = -1;
				$opt_data = $mx_request_vars->post('project_name', MX_TYPE_NO_TAGS | MX_TYPE_SQL_QUOTED);;
				$current_id = $mx_request_vars->get('id', MX_TYPE_INT);
			break;
		}

		if ($mx_request_vars->is_post('create'))
		{
			//
			// Insert the parameters
			//
			$mx_block->virtual_create($create_id, $opt_data);
		}
		else if ($mx_request_vars->is_post('rename'))
		{
			//
			// Update the parameters
			//
			$mx_block->virtual_update($current_id, $opt_data);
		}
		else if ($mx_request_vars->is_get('delete'))
		{
			//
			// Delete the parameters
			//
			$mx_block->virtual_delete($current_id);
		}
	}
}

//
// Navigation
//
if (($mx_block->auth_view || $mx_block->auth_mod))
{
	switch ($virtualMode)
	{
		case 'user':
			$sql = "SELECT 	sys.sub_id,
							usr.username as name
				FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
						" . USERS_TABLE . " usr
				WHERE   sys.block_id = '" . $mx_block->block_id . "'
						AND sys.sub_id <> 0
						AND sys.sub_id = usr.user_id";
			$sql .= " ORDER BY usr.username";
		break;
		case 'group':

			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'phpbb2':
					$sql = "SELECT 	sys.sub_id,
									grp.group_name as name
						FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
								" . GROUPS_TABLE . " grp
						WHERE   sys.block_id = '" . $mx_block->block_id . "'
								AND sys.sub_id <> 0
								AND sys.sub_id = grp.group_id
								AND grp.group_single_user <> " . TRUE;
					$sql .= " ORDER BY grp.group_name";
				break;
				case 'phpbb3':
				default:
					$sql = "SELECT 	sys.sub_id,
									grp.group_name as name
						FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . " sys,
								" . GROUPS_TABLE . " grp
						WHERE   sys.block_id = '" . $mx_block->block_id . "'
								AND sys.sub_id <> 0
								AND sys.sub_id = grp.group_id
								AND grp.group_name NOT IN ('BOTS', 'GUESTS')";
					$sql .= " ORDER BY grp.group_name";
				break;
			}
		break;
		case 'project':
			$sql = "SELECT 	sub_id,parameter_opt as name
				FROM " . BLOCK_SYSTEM_PARAMETER_TABLE . "
				WHERE   block_id = '" . $mx_block->block_id . "'
						AND sub_id <> 0";
			$sql .= " ORDER BY parameter_opt";
		break;
	}

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't delete block data information", "", __LINE__, __FILE__, $sql);
	}

	$group_ids = '';
	$virtual_navigation = false;

	$virtual_select = '<select name="virtual" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'virtual_jumpbox\'].submit() }">';
	$virtual_select .= '<option value="-1" >' . $lang['Virtual_Select'] . '</option>';
	while ( $row = $db->sql_fetchrow($result) )
	{
		//
		// Either Drop down list...
		//
		$group_ids .= !empty($group_ids) ? ',' . $row['sub_id'] : $row['sub_id'];
		$virtual_navigation = true;
		$selected = ( $row['sub_id'] == $mx_request_vars->get('virtual') ) ? ' selected="selected"' : '';
		if (!empty($selected))
		{
			$globname = $row['name'];
		}
		$virtual_select .= '<option value="' . $row['sub_id'] . '"' . $selected . '>' . $row['name'] . '</option>';

		//
		// ...or standard output
		//
		$use_icons = true;
		$menuData['menu_icon'] = 'icon_dot.gif';

		//
		// Get menu icon
		//
		if ($use_icons)
		{
			$icon_tmp = ( file_exists($mx_root_path . $images['mx_graphics']['menu_icons'] . '/' . $menuData['menu_icon']) ? $menuData['menu_icon'] : 'icon_blank.gif' );
			$icon_url_hot = str_replace('.gif', '_hot.gif', $icon_tmp);

			if ( file_exists($mx_root_path . $images['mx_graphics']['menu_icons'] . '/' . $icon_url_hot) )
			{
				$icon_url = ( !empty($selected) ) ? $icon_url_hot : $icon_tmp;
				$icon_style = ( !empty($selected) ) ? 'mx_icon_hot' : 'mx_icon';
			}
			else
			{
				$icon_url = $icon_tmp;
				$icon_style = '';
			}

			$icon_url = PORTAL_URL . $images['mx_graphics']['menu_icons'] . '/' . $icon_url;
			$menu_icon = ( !empty($menuData['menu_icon']) && $menuData['menu_icon'] != 'none' ) ? '<img class="'.$icon_style.'" border="0" align="absmiddle" src="' . $icon_url . '" alt="' . $desc . '" />&nbsp;' : '';
		}

		$template->assign_block_vars('virtual_items', array(
			'NAME'			=> $row['name'],
			'ICON'			=> $menu_icon,
			'U_MENU_URL'	=> mx_append_sid( mx_this_url( 'page='.$page_id.'&virtual='.$row['sub_id'])),
			'STYLE'			=> !empty($selected) ? 'cattitle' : 'genmed'
		));
	}
	$virtual_select .= '</select>';
	$db->sql_freeresult($result);

	$template->assign_vars(array(
		'VIRTUAL_NAVIGATION' => $virtual_navigation,
		'VIRTUAL_SELECT' => $virtual_select,
		'L_VIRTUAL_SELECT' => $lang['Virtual_Go'],

		'S_ACTION_NAVIGATE' => mx_append_sid( mx_this_url( 'page='.$page_id ) ),
		'VIRTUAL_PAGE_ID' => $page_id,
	));
}

//
// Mode
//
if (($mx_block->auth_edit || $mx_block->auth_mod))
{
	//
	// We are visiting a virtual page
	//
	if ($mx_request_vars->is_get('virtual'))
	{
		//
		// My Page?
		//
		switch ($virtualMode)
		{
			case 'user':
				$is_created = $mx_block->virtual_init($userdata['user_id']);
				$my_page = $mx_request_vars->get('virtual', MX_TYPE_INT) == $userdata['user_id'] || $mx_block->auth_mod;
				$l_name = $userdata['username'];
				$mx_page->page_title .= ' - ' . $globname;
			break;
			
			case 'group':
				$is_created = $mx_block->virtual_init($mx_request_vars->get('virtual', MX_TYPE_INT));
				$my_page = mx_is_group_member($mx_request_vars->get('virtual', MX_TYPE_INT)) || $mx_block->auth_mod;
				$l_name = $userdata['username'];
				$mx_page->page_title .= ' - ' . $globname;
			break;
			
			case 'project':
				$is_created = $mx_block->virtual_init($mx_request_vars->get('virtual', MX_TYPE_INT));
				$my_page = $mx_block->auth_mod;
				$l_name = $userdata['username'];
				$mx_page->page_title .= ' - ' . $globname;
			break;
		}
	}
	else
	//
	// Main page
	//
	{
		$create_new = true;
		//
		// Create Langs
		//
		switch ($virtualMode)
		{
			case 'user':
				$l_create = $lang['Virtual_Create_new_user'];
			break;
			
			case 'group':
				$l_create = $lang['Virtual_Create_new_group'];
			break;
			
			case 'project':
				$l_create = $lang['Virtual_Create_new_project'];
			break;
		}

		//
		// Create New?
		//
		switch ($virtualMode)
		{
			case 'user':
				break;

			case 'group':

				$not_in_groups = !empty($group_ids) ? ' AND group_id NOT IN ('.$group_ids.')' : '';
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'phpbb2':
						$sql = "SELECT 	group_id, group_name
							FROM " . GROUPS_TABLE . "
							WHERE group_single_user <> " . TRUE . $not_in_groups;
						$sql .= " ORDER BY group_id";
					break;
					case 'phpbb3':
					default:
						$sql = "SELECT 	group_id, group_name
							FROM " . GROUPS_TABLE . "
							WHERE   group_name NOT IN ('BOTS', 'GUESTS')".$not_in_groups;
						$sql .= " ORDER BY group_id";
					break;
				}

				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Couldn't get list of groups", '', __LINE__, __FILE__, $sql);
				}

				if( $total_groups = $db->sql_numrows($result) )
				{
					$group_select = '<select name="group_id">';
					while ( $row = $db->sql_fetchrow($result) )
					{
						$group_select .= '<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
					}
					$group_select .= '</select>';
				}
				else
				{
					$create_new = false;
				}
				$db->sql_freeresult($result);
			break;

			case 'project':
			
			break;
		}
	}

	$template->assign_vars(array(
		'MY_PAGE' => $is_created && $my_page,
		'CREATE_NEW' => $create_new,

		'VIRTUAL_USER' => $virtualMode == 'user',
		'VIRTUAL_GROUP' => $virtualMode == 'group',
		'VIRTUAL_PROJECT' => $virtualMode == 'project',

		'L_VIRTUAL_CREATE_INFO' => $lang['Virtual_Create_new'] . $l_create,
		'L_VIRTUAL_CREATE' => $lang['Virtual_Create'],
		'L_VIRTUAL_EDIT' => $lang['Virtual_Edit'],
		'L_VIRTUAL_DELETE' => $lang['Virtual_Delete'],

		'L_VIRTUAL_INFO' => $lang['Virtual_Info'],
		'L_VIRTUAL_WELCOME' => $lang['Virtual_Welcome'],
		'L_VIRTUAL_CP' => $lang['Virtual_CP'],

		'VIRTUAL_NAME' => $l_name,
		'VIRTUAL_ID' => $mx_request_vars->get('virtual', MX_TYPE_INT),

		'GROUP_SELECT' => $group_select,
		'S_ACTION_GROUP' => mx_append_sid( mx_this_url( 'page='.$page_id ) ),

		'S_ACTION_MANAGE' => mx_append_sid( mx_this_url( 'virtual_action=manage' ) ),
		'U_DELETE' => mx_append_sid( mx_this_url( 'virtual_action=manage&delete=do&id='.$mx_request_vars->get('virtual', MX_TYPE_INT) ) ),
		'VIRTUAL_PAGE_ID' => $page_id,
	));
}

$template->pparse("body");
?>