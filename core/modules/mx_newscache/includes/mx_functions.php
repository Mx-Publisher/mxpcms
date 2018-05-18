<?php
/***************************************************************************
 *                             functions.php
 *                            -------------------
 *   begin                : May, 2002
 *   copyright            : (C) 2002 MX-System
 *   email                : support@mx-system.com
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License', or
 *   ('at your option) any later version.
 *
 ***************************************************************************/
if( !defined('IN_PORTAL') || !is_object($mx_block) )
{
	die("Hacking attempt");
}

	function read_news_config()
	{
		  global $db, $mx_cache, $mx_root_path, $module_root_path;

		$sql = "SELECT news_title 
		               , news_xml_file
		               , news_folder 
		     FROM " . CONFIG_NEWS_TABLE ;
		  
		if ( !($result = $db->sql_query($sql)) )
		{ 
		    mx_message_die(GENERAL_ERROR, 'Could not obtain module configuration', '', __LINE__, __FILE__, $sql);
		}
		$module_config = $db->sql_fetchrow($result);
		  
		//$mode = '';
		  
		$sql_block =  !empty($module_root_path) ? " AND mdl.module_path = '" . str_replace($mx_root_path, '', $module_root_path) . "'" : " AND module_name = 'News Read'";
	 
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
			print_r(array("Could not query Music Center module information", "\n\n", __LINE__, "\n\n", __FILE__, "\n\n", $sql));
			return $module_config;
		}
		
		$row = $db->sql_fetchrow($result);
		
		$block_id = $row['block_id'];
		
		$block_config = $mx_cache->_get_block_config($block_id, 0, 'block_config');
		
		// Read block Configuration
		$module_config['news_title'] = $title = $mx_block->block_info['block_title'];
		$block_size = (isset($block_size) && !empty($block_size) ? $block_size : '100%');
		$description = $mx_block->block_info['block_desc'];
		$show_block = $mx_block->block_info['show_block'];
		$show_title = ($userdata['user_level'] == ADMIN) ? true : $mx_block->block_info['show_title'];
		$show_stats = $mx_block->block_info['show_stats'];
		$New_Cache_Time = 1800;
		//$News_Xml_File  = $mx_block->block_parameters['News_Xml_File']['parameter_value'];
		$module_config['news_xml_file'] = $News_Xml_File = $block_config[$block_id]['block_parameters']['News_Xml_File']['parameter_value'];
		$module_config['news_folder'] = $News_Folder = $block_config[$block_id]['block_parameters']['News_Folder']['parameter_value'];
		$module_config['new_cache_time'] = $New_Cache_Time = $block_config[$block_id]['block_parameters']['New_Cache_Time']['parameter_value'];
		
		return $module_config;	  
	}

	function resolve_file($file_or_url) 
	{
		global $mx_root_path;
		if (!preg_match('|^https?:|', $file_or_url))
		{	
			$feed_uri = $mx_root_path . $file_or_url;
		}
		else
		{		
			$feed_uri = $file_or_url;
		}
		return $feed_uri;
	}
	
	/** Truncate summary line to max characters **/
	function summarize_text($summary) 
	{
		$summary = strip_tags($summary);
		// Truncate summary line to 100 characters
		$max_len = 100;
		if (strlen($summary) > $max_len)
		{	
			$summary = substr($summary, 0, $max_len) . '...';
			return $summary;
		}		
	}
	
	/** 10x to hbxuser **/
	if( !function_exists('feed_sitename') )
	{
		function feed_sitename($domain) 
		{
			$domaintmp = explode(".", $domain);
							
			$y = count($domaintmp) - 1;
			$r = "";
			for ($a = 0; $y > $a; $a++) 
			{
				$r .= ".".$domaintmp[$a];
			}
			return $r;
		}
	}
	
	/** 10x to hbxuser **/
	if( !function_exists('feed_sitesufix') )
	{
		function feed_sitesufix($domain) 
		{
			$domaintmp = explode(".", $domain);
				
			$y = count($domaintmp) - 1;
			$r = $domaintmp[$y];;
			return $r;
		}
	}				
	
	function feed_get_contents($feed_file, $force_cache = false)
	{
		global $mx_root_path;
		
		$docsfeed	= new DOMDocument();
		
		/* $feed = json_decode(json_encode(simplexml_load_file('news.google.com/?output=rss')), true); */
		$docsfeed->load($mx_root_path . $feed_file);
			
		//$xpath = new DOMXPath($docsfeed);
			
		$json = array();
			
		/** echo "--------- root\n"; **/
		//$rootnode = $docsfeed->documentElement;
		//print_r($rootnode);

		/** echo "--------- children of root\n"; **/
		//$children = $rootnode->childNodes;
		//print_r($children);

		// The last node should be identical with the last entry in the children array
		/** echo "--------- last\n"; **/
		//$last = $rootnode->lastChild;	
		//print_node($last);
			
		$json['title'] = $docsfeed->getElementsByTagName('channel')->item(0)->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
		$json['description'] = $docsfeed->getElementsByTagName('channel')->item(0)->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
		$json['link'] = $docsfeed->getElementsByTagName('channel')->item(0)->getElementsByTagName('link')->item(0)->firstChild->nodeValue;
		$items = $docsfeed->getElementsByTagName('channel')->item(0)->getElementsByTagName('item');			

		if (preg_match('|^https?:|', $json['link']))
		{	
			$host = explode("//", $json['link']);
			$host = $host[1];
			$host = explode("/", $host);
			//array ( [0] => www.huffingtonpost.com [1] => topic [2] => israel )
			$domain = $host[0];
			$counthost = count($host) - 1;
			$json['topic'] = $host[$counthost];
			
			$sitename = substr(feed_sitename($domain), 1);
			$sitesufix = feed_sitesufix($domain);
			
			/** $domain = $sitename . $sitesufix;	**/
		}		
		
		$json['item'] = array();
		
		foreach($items as $key => $item) 
		{
			$title = $item->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
			$description = $item->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
			
			if (preg_match('@^(?:huffington://)?([^/]+)@i', $json['link']) &&
				preg_match('@^(?:yahoo://)?([^/]+)@i', $json['link']) &&
				preg_match('@^(?:aol://)?([^/]+)@i', $json['link']))
			{	
				$enclosure = $item->getElementsByTagName('enclosure')->item(0)->getAttributeNode('url');				
				$filetype = $item->getElementsByTagName('enclosure')->item(0)->getAttributeNode('type');
				$length = $item->getElementsByTagName('enclosure')->item(0)->getAttributeNode('length');
			}
			
			$pubDate = $item->getElementsByTagName('pubDate')->item(0)->firstChild->nodeValue;
			$guid = $item->getElementsByTagName('guid')->item(0)->firstChild->nodeValue;
				
			$json['item'][$key]['title'] = (string) urlencode($title);
			$json['item'][$key]['description'] = (string) urlencode($description);
			$json['item'][$key]['enclosure'] = (string) urlencode($enclosure->nodeValue);
			$json['item'][$key]['type'] = (string) urlencode($filetype->nodeValue);
			$json['item'][$key]['length'] = (string) $length->nodeValue;			
			$json['item'][$key]['pubdate'] = (string) $pubDate;
			$json['item'][$key]['ts'] = strtotime($pubDate);
			$json['item'][$key]['guid'] = (string) urlencode($guid);				
		}
		return $json;
	}	

?>