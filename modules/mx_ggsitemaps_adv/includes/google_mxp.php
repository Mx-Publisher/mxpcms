<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: google_mxp.php,v 1.1 2008/06/23 20:21:02 jonohlsson Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/

//
// First basic security
//
if ( !defined('IN_PHPBB') && !defined('IN_PORTAL') )
{
	die('Hacking attempt');
	exit;
}

if (!($this->actions['type'] === 'google_'))
{
	$this->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Request not accepted');
}

//
// Build unauthed array
//
$this->set_exclude_list($this->ggsitemaps_config['ggs_mx_exclude']);

//
// we can start wroking
//
if ($this->actions['action'] === 'mxp')
{
	//
	// It's the mxp sitemap
	//
	$mxp_sitemap_url = $this->path_config['sitemap_url'] . (($this->mod_r_config['mod_rewrite']) ? 'mx-sitemap.xml' . $this->ext_config['gzip_ext_out'] : 'sitemap.'.$phpEx . '?mxp');
	$this->seo_kill_dupes($mxp_sitemap_url);

	//
	// Reuse cached MXP page data
	//
	$mx_page->init( '1' );

	//
	// First get all visible blocks
	//
	$sql = "SELECT block_id
	   		FROM " . BLOCK_TABLE . "
			WHERE show_block = 1 AND auth_view = 0";

	if ( !$result = $db->sql_query( $sql ) )
	{
		mx_message_die( GENERAL_ERROR, 'Could not obtain block results', '', __LINE__, __FILE__, $sql );
	}

	$block_rowset = $db->sql_fetchrowset( $result );
	$db->sql_freeresult($result);

	$excluded_page_ids_array = array();
	foreach( $this->output_data['exclude_list'] as $temp_key => $excluded_page_id )
	{
		$excluded_page_ids_array[] = $excluded_page_id;
	}

	$valid_page_ids_array = array();
	foreach( $mx_page->page_rowset as $temp_key => $page_row )
	{
		$_auth_ary = $mx_page->auth($page_row['auth_view'], $page_row['auth_view_group'], $page_row['auth_moderator_group']);

		// Check VIEW auth and if the page is allowed to index
		if ($_auth_ary['auth_view'] && !in_array($page_row['page_id'], $excluded_page_ids_array))
		{
			$valid_page_ids_array[] = $page_row['page_id'];
		}
	}

	//
	// Now find the associated pages
	//
	$page_ids = array();
	$block_ids = array();
	$valid_page_ids = '';
	foreach($block_rowset as $key => $block_row)
	{
		$page_id_array = get_page_id($block_row['block_id'], false, true);

		if (in_array($page_id_array['page_id'], $valid_page_ids_array))
		{
			$page_ids[$block_row['block_id']] = $page_id_array;
			$block_ids[] = $block_row['block_id'];
		}
	}

	$valid_block_ids = implode( ', ', $block_ids );

	//
	// Dump out the results
	//
	$pageids = array();
	foreach($page_ids as $block_id => $page_row )
	{
		if (is_array($page_row) && !empty($page_row['block_id']))
		{
			$dynamic_block_id = $page_row['block_id'];
			$pageid = $page_row['page_id'];
			$priority = '0.8';
		}
		else if (is_array($page_row))
		{
			$dynamic_block_id = '';
			$pageid = $page_row['page_id'];
			$priority = '1.0';
		}
		else
		{
			$dynamic_block_id = '';
			$pageid = $page_row;
			$priority = '1.0';
		}

		//
		// Remove duplicate pages
		//
		if (empty($dynamic_block_id))
		{
			if (in_array($pageid,$pageids) )
			{
				continue;
			}
			else
			{
				$pageids[] = $pageid;
			}
		}

		$page_title = $page_row['page_name'];
		$page_desc = $page_row['page_desc'];

		$temp_url = !empty($dynamic_block_id) ?  mx_append_sid( PORTAL_URL . 'index.php?page=' . $pageid . '&amp;dynamic_block=' . $dynamic_block_id, false, true )  : mx_append_sid( PORTAL_URL . 'index.php?page=' . $pageid );

		$this->output_data['data'] .= sprintf($this->style_config['Sitemap_tpl'], $temp_url, gmdate('Y-m-d\TH:i:s'.'+00:00', (time() - $this->output_data['url_sofar'] * rand(100, 1000))), 'always', $priority);
		$this->output_data['url_sofar']++;
	}

	$db->sql_freeresult($result);
	unset($page_ids);
	unset($block_rowset);
	unset($page_row);
}
else
{
	//
	// it's a sitemap index call
	//
	$mxp_sitemap_url = ($this->mod_r_config['mod_rewrite']) ? 'mx-sitemap.xml' . $this->ext_config['gzip_ext_out'] : 'sitemap.'.$phpEx.'?mxp';
		$this->output_data['data'] .= sprintf( $this->style_config['SitmIndex_tpl'], $this->path_config['sitemap_url'] .  $mxp_sitemap_url, gmdate('Y-m-d\TH:i:s'.'+00:00', time() - rand(100, 1000)) );
		$this->output_data['url_sofar']++;
}

/*
//
// Filter forums & build sql components
//
if (!empty($this->output_data['exclude_list']))
{
	$not_in_id_sql = " page_id NOT IN (" . implode(",", $this->output_data['exclude_list']) . ") AND auth_view = 0";
}
else
{
	$not_in_id_sql = "auth_view = 0";
}

//
// we can start wroking
//
if ($this->actions['action'] === 'mxp')
{
	//
	// It's the mxp sitemap
	//
	$mxp_sitemap_url = $this->path_config['sitemap_url'] . (($this->mod_r_config['mod_rewrite']) ? 'mx-sitemap.xml' . $this->ext_config['gzip_ext_out'] : 'sitemap.'.$phpEx . '?mxp');
	$this->seo_kill_dupes($mxp_sitemap_url);

	//
	// Only query for public pages
	//
	$sql = "SELECT page_id, page_name
			FROM " . PAGE_TABLE . "
			WHERE $not_in_id_sql";

	if ( !($result = $db->sql_query($sql)) )
	{
		$this->mx_sitemaps_message_die(GENERAL_ERROR, "Could not obtain Forum data", '', __LINE__, __FILE__, $sql);
	}

	while  ( $mx_page_info =  $db->sql_fetchrow($result))
	{
		$page_id = $mx_page['page_id'];

		//
		// Built mx urls
		//
		if ( $portal_config['mod_rewrite'] )
		{
			$mx_page_url = $this->path_config['mxp_url'] . 'page' . $mx_page_info['page_id'];
		}
		else
		{
			$mx_page_url = $this->path_config['mxp_url'] . 'index.' . $phpEx . '?page=' . $mx_page_info['page_id'];
		}
		$this->output_data['data'] .= sprintf($this->style_config['Sitemap_tpl'], $mx_page_url, gmdate('Y-m-d\TH:i:s'.'+00:00', (time() - $this->output_data['url_sofar'] * rand(100, 1000))), 'always', '1.0');
		$this->output_data['url_sofar']++;

	}
	$db->sql_freeresult($result);
	unset ($mx_page_info);
}
else
{
	//
	// it's a sitemap index call
	//
	$mxp_sitemap_url = ($this->mod_r_config['mod_rewrite']) ? 'mx-sitemap.xml' . $this->ext_config['gzip_ext_out'] : 'sitemap.'.$phpEx.'?mxp';
		$this->output_data['data'] .= sprintf( $this->style_config['SitmIndex_tpl'], $this->path_config['sitemap_url'] .  $mxp_sitemap_url, gmdate('Y-m-d\TH:i:s'.'+00:00', time() - rand(100, 1000)) );
		$this->output_data['url_sofar']++;
}
*/
?>
