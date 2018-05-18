<?php
/**
 *
 * @package Functions_phpBB3
 * @version $Id: functions_hook.php,v 1.22 2013/06/28 15:34:11 orynider Exp $
 * @copyright (c) 2002-2008 MX-Publisher Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
 * @link http://mxpcms.sourceforge.net/
 */

/**
 * @ignore
 */
if (!defined('IN_PORTAL'))
{
	exit;
}


class mx_phpbb3_admin
{
	var $main_part = '';
	var $current_tab = '';
	var $id_tabs = '';
	var $complete_menu = array();

	var $action_scripts = array();

	var $p_master = null;
	var $mx_master = null;

	/**
	 * Constructor
	 *
	 * @param resource $mx_master master admin object
	 * @return resource mx_phpbb3_admin
	 */
	function mx_phpbb3_admin( $mx_master = null)
	{
		if ( $mx_master != null)
		{
			$this->mx_master = $mx_master;
		}
	}

	/**
	 * new hook
	 */
	function get_tabs( $current_tab = 1 )
	{
		global $lang, $mx_user, $user, $db;

		$sql = "SELECT m1.*, count(m2.module_id) AS subcount
				FROM " . MODULES_TABLE . " AS m1 LEFT OUTER JOIN " . MODULES_TABLE . " AS m2 ON m1.module_id = m2.parent_id AND m2.module_enabled = 1 AND m2.module_display = 1
				WHERE m1.parent_id = 0 AND m1.module_class = 'acp'
				GROUP BY m1.module_id
				HAVING count(m2.module_id) > 0
				ORDER BY m1.left_id";

		if ( !( $rs = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not obtain tabs data form phpbb3 modules', 'Error', __LINE__, __FILE__, $sql );
		}

		$return_category = '';

		$tabs = array();
		while ( $row = $db->sql_fetchrow( $rs ) )
		{
			if ( isset( $mx_user->lang[$row['module_langname']] ) )
			{
				$l_mx_phpbb = $mx_user->lang[$row['module_langname']];
			}
			else if ( isset( $lang[$row['module_langname']] ) )
			{
				$l_mx_phpbb = $lang[$row['module_langname']];
			}
			else
			{
				$l_mx_phpbb = $row['module_langname'];
			}

			if ( $row['module_id'] == $current_tab )
			{
				$return_category = $l_mx_phpbb;
			}
			$tabs[] = array( // #
				'ACTIVE_TAB' => $row['module_id'] == $current_tab?'activetab':'',
				'CATEGORY' => OLYMPUS_CATEGORY,
				'PARAMS' => '&i=' . $row['module_id'] ,
				'L_TAB' => $l_mx_phpbb,
			);
			$this->id_tabs .= ', ' . $row['module_id'] . ' ';
		}
		$this->id_tabs = trim( substr( $this->id_tabs, 1 ) );
		$db->sql_freeresult( $rs );
		return array( 'CATEGORY_TITLE' => $return_category, 'TABS' => $tabs );
	}

	function get_menu_complete()
	{
		global $db, $phpbb_root_path, $phpEx;
		$sql = "SELECT m1.parent_id AS m1_parent, m1.module_langname AS m1_langname, m2.module_langname AS m2_langname, m2.module_basename AS m2_basename, m2.module_mode AS m2_mode
				FROM " . MODULES_TABLE . " AS m1 RIGHT OUTER JOIN " . MODULES_TABLE . " AS m2 ON m1.module_id = m2.parent_id AND m2.module_enabled = 1 AND m2.module_display = 1
				WHERE m1.parent_id IN (" . $this->id_tabs . ") AND m1.module_class = 'acp'
				ORDER BY m1.left_id";

		if ( !( $rs = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not obtain menu data from phpbb3 modules', 'Error', __LINE__, __FILE__, $sql );
		}

		$header = '';
		$this->menu_complete = array();

		while ( $row = $db->sql_fetchrow( $rs ) )
		{
			if ( $header != $row['m1_langname'] )
			{
				$header = $row['m1_langname'];
				$this->menu_complete[$row['m1_parent']][$header] = array();
			}
			$this->action_scripts[$row['m2_langname']] = $row['m2_basename'];
			$this->menu_complete[$row['m1_parent']][$header][$row['m2_langname']] = "adm/index.$phpEx?i=" . $row['m1_parent'] . '&panel=' . $row['m2_basename'] . ( !empty( $row['m2_mode'] )?'&mode=' . $row['m2_mode']:'' ) ;
		}
		$db->sql_freeresult( $rs );
		return $this->menu_complete;
	}

	function get_menu( $category )
	{
		return $this->menu_complete[$category];
	}

	function prepare_action_script( $panel )
	{
		global $phpbb_root_path, $phpEx, $mx_request_vars, $phpbb_admin_path, $template;

		$admin_panel_script_path = $phpbb_root_path . 'includes/acp/acp_'. $this->action_scripts[$panel] . '.' . $phpEx;

		if ( !file_exists( $admin_panel_script_path ))
		{
			return "echo '<div class=\"errorbox\">phpbb3 admin nanel not found<br/>$admin_panel_script_path</div>';";
		}

		$script = trim( file_get_contents( $phpbb_root_path . 'adm/index.' . $phpEx ) );

		$preg_array = array( '#(<\?(php)?|\?>)#si' => '',
			'#\$php(Ex|bb_root_path|bb_admin_path) = [^;]*;#si' => '// MX_ACP_REPLACE \0',
			'#\$user->session_begin[^;]*;#si' => '// MX_ACP_REPLACE \0',
			'#\$auth->acl\(\$user->data\)[^;]*;#si' => '// MX_ACP_REPLACE \0',
			'#\$user->setup[^;]*;#si' => '// MX_ACP_REPLACE \0',
			'#(include|require)\(([^)]*)\)[^;]*#s' => '// MX_ACP_REPLACE mx_cache::load_file(\2, \'phpbb3\')',
			'#\$user#si' => '$mx_user',
			'#\$auth#si' => '$phpbb_auth',
			'#\$config#si' => '$board_config',
			'#([^_])append_sid#si' => '\1mx_append_sid',
			'#\$module_id[ \t][^;]*;#si' => "\$module_id = '" . $this->action_scripts[$panel] . "';",
			'#\$mode[ \t][^;]*;#si' => "\$mode = '" . $mx_request_vars->request( 'mode', MX_TYP_NO_TAGS) . "';",
			'#request_var#si' => '$mx_request_vars->request',
			'#login_box\(#si' => '// login_box(',
			'#\$cache#si' => '$mx_cache',
			'#trigger_error\(#si' => '// trigger_error(',
			'#\'body\' => \$module#si' => '\'panel\' => $module',
			'#([ \t\n])define#si' => '\1@define',
			'#display\(\'body\'\);#si' => "display('panel');",
			'#(garbage_collection|exit_handler)\(\);#si' => 'phpBB3::\1();',
			//'#\$template->#si' => '$mx_acp->template->',
			'#adm_page_footer\(\);#si' => '$mx_acp->_template_assign_vars();$template->pparse(\'panel\');',
			'#global #si' => 'global $mx_acp, ',
			'#\s(header\()#si' => '// \1',
			'#ob_start\(\'ob_gzhandler\'\);#si' => '// \0',
		);

		$func_cnt = preg_match_all( "#\nfunction ([^(]*)\\(#si", $script, $func_match );

		mx_cache::load_file( 'utf/utf_tools');

		for( $i = 0; $i < $func_cnt; $i++ )
		{
			if ( function_exists( $func_match[1][$i] ) )
			{
				$preg_array = array_merge( $preg_array, array( // #
			"#\nfunction " . $func_match[1][$i] . '#si' => "\nfunction " . $func_match[1][$i] . '_defined',
				) );
			}
		}

		$script = preg_replace( array_keys( $preg_array ), $preg_array, $script );
		return $script;
	}

	function assign_content_acp( $html)
	{
		global $phpbb_root_path, $phpbb_admin_path;
		$html = trim(preg_replace('#<!-- INCLUDE overall_(header|footer)\.html -->#si', '', $html));
		$html = preg_replace( '#^.*\<div id="page-body"\>|<\/div>[^<]*<div id="page-footer">.*$#si', '', $html);

		//$match_img_count = preg_match_all( '#img src="(adm\/[^"]*)"#s', $html, $match_img);
		// REPLACE IMAGES_PATHs
		$preg_array = array(
			'#img src="((adm|..)\/[^"]*)"#si' => 'img src="'.$phpbb_root_path.'\1"',
			'#img src="(images\/[^"]*)"#si' => 'img src="'.$phpbb_root_path . $phpbb_admin_path.'\1"',
		);
		$html = preg_replace( array_keys( $preg_array), $preg_array, $html);

		// REPLACE LINK PATHs

		$html = $this->_convert_links( $html);
		if ( 0 )
		{
			print '<pre>';
			print htmlentities( $html);
			//print_r( $match_link);
			die( );
		}
		return $html;
	}

	function _convert_links( $html )
	{
		global $phpEx, $mx_request_vars, $mx_root_path;
		$panel_i = $mx_request_vars->request( 'i', MX_TYPE_NO_TAGS);
		$menu_action = $this->mx_master->menu_actions;
		array_shift( $menu_action);
		$admin_path = $mx_root_path. 'acp/';

		$match_link_cnt = preg_match_all( '#(action|href)=[\'"](([^?\'"]*)\??([^\'"]*)?)[\'"]#si', $html, $match_link);

		$preg_array = array( '##si' => '');
		$do_not_convert_ary = array( "{$phpbb_root_path}memberlist");
		$do_not_convert = "(" . implode( "|", $do_not_convert_ary) . ")";
		for( $i=0; $i<$match_link_cnt; $i++)
		{
			$params = str_replace( '&amp;', '&', $match_link[4][$i]);
			$p_cnt = preg_match_all( '#([^=&]*)=([^&]*)#si', '&' . $params  , $link_parts);
			$link_compare_ary = @array_combine( $link_parts[1], $link_parts[2]);
			$eregi = "adm/index.{$phpEx}?i={$panel_i}&panel={$link_compare_ary[i]}&mode={$link_compare_ary[mode]}";
			$panel = $menu_action[$eregi];
			$filename = basename( $_SERVER['PHP_SELF']);
			$link = "{$filename}?cat=" . OLYMPUS_CATEGORY . "&i={$panel_i}&panel=" .$menu_action[$eregi] . "&mode={$link_compare_ary[mode]}";
			unset( $link_compare_ary['i']);
			unset( $link_compare_ary['mode']);

			if ( is_array( $link_compare_ary))
			{
				ksort( $link_compare_ary);
				$par_count = count( $link_compare_ary);
				$par_keys = array_keys( $link_compare_ary);
				for( $j=0; $j<$par_count; $j++)
				{
					$link .= '&' . $par_keys[$j] . '=' . $link_compare_ary[$par_keys[$j]];
				}
			}
			$link_orig = preg_replace( '#([./\[\]\(\)?\\\\])#si', "\\\\\\1", $match_link[2][$i]);
			$link_orig = str_replace( '#', '\#', $link_orig);
			$link = str_replace( 'sid=sid=', 'sid=', $link);
			if ( !empty($link_orig) && !( eregi($do_not_convert, $link_orig)) )
			{
				$preg_array = array_merge( $preg_array, array( '#' . $link_orig .'#si' => @$mx_admin_path . $link));
			}
		}

		if( 0)
		{
			print '<pre>';
			//print htmlentities( trim($html));
			foreach( $preg_array as $patt => $repl)
			{
				print '"' . $patt . '" => "' . $repl . '"<hr/>';
			}
			die();
		}

		return preg_replace( array_keys( $preg_array), $preg_array, $html);
	}


}

?>