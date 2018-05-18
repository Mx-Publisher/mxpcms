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
 *    $Id: mx_search.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
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

include_once( $phpbb_root_path . 'includes/functions_post.' . $phpEx );
include_once( $phpbb_root_path . 'includes/functions_search.' . $phpEx );

//
// Define initial vars
//
$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS, '');

if ( isset( $HTTP_POST_VARS['search_keywords'] ) || isset( $HTTP_GET_VARS['search_keywords'] ) )
{
	$search_keywords = ( isset( $HTTP_POST_VARS['search_keywords'] ) ) ? $HTTP_POST_VARS['search_keywords'] : $HTTP_GET_VARS['search_keywords'];
}
else
{
	$search_keywords = '';
}

if ( !$search_keywords || $search_keywords == '' )
{
	$mode = '';
}

$search_id = $mx_request_vars->get('search_id', MX_TYPE_INT, '');

if ( $search_id )
{
	$mode = 'results';
}

$show_results = ( isset( $HTTP_POST_VARS['show_results'] ) ) ? $HTTP_POST_VARS['show_results'] : 'posts';

if ( isset( $HTTP_POST_VARS['search_terms'] ) )
{
	$search_terms = ( $HTTP_POST_VARS['search_terms'] == 'all' ) ? 1 : 0;
}
else
{
	$search_terms = 0;
}

if ( isset( $HTTP_POST_VARS['search_fields'] ) )
{
	$search_fields = ( $HTTP_POST_VARS['search_fields'] == 'all' ) ? 1 : 0;
}
else
{
	$search_fields = 0;
}

$sort_by = ( isset( $HTTP_POST_VARS['sort_by'] ) ) ? intval( $HTTP_POST_VARS['sort_by'] ) : 0;

if ( isset( $HTTP_POST_VARS['sort_dir'] ) )
{
	$sort_dir = ( $HTTP_POST_VARS['sort_dir'] == 'DESC' ) ? 'DESC' : 'ASC';
}
else
{
	$sort_dir = 'DESC';
}

$start = ( isset( $HTTP_GET_VARS['start'] ) ) ? intval( $HTTP_GET_VARS['start'] ) : 0;

$per_page = $board_config['topics_per_page']; 

switch ( $mode )
{
	case "results": 

		$store_vars = array('search_results', 'total_match_count', 'split_search', 'sort_by', 'sort_dir', 'show_results', 'return_chars');

		if ( $search_id == '' || $search_keywords != '' )
		{
			$stopword_array = @file( $phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/search_stopwords.txt' );
			$synonym_array = @file( $phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/search_synonyms.txt' );

			$split_search = array();
			$split_search = ( !strstr( $multibyte_charset, $lang['ENCODING'] ) ) ? split_words( clean_words( 'search', stripslashes( $search_keywords ), $stopword_array, $synonym_array ), 'search' ) : split( ' ', $search_keywords );

			$search_msg_only = ( !$search_fields ) ? "AND m.title_match = 0" : ( ( strstr( $multibyte_charset, $lang['ENCODING'] ) ) ? '' : '' );

			$word_count = 0;
			$current_match_type = 'or';

			$word_match = array();
			$result_list = array();

			for( $i = 0; $i < count( $split_search ); $i++ )
			{
				if (preg_match('#^[\*%]+$#', trim($split_search[$i])) || preg_match('#^[^\*]{1,2}$#', str_replace(array('*', '%'), '', trim($split_search[$i]))))
				{
					$split_search[$i] = '';
					continue;
				}
					
				switch ( $split_search[$i] )
				{
					case 'and':
						$current_match_type = 'and';
						break;

					case 'or':
						$current_match_type = 'or';
						break;

					case 'not':
						$current_match_type = 'not';
						break;

					default:
						if ( !empty( $search_terms ) )
						{
							$current_match_type = 'and';
						}

						if ( !strstr( $multibyte_charset, $lang['ENCODING'] ) )
						{
							$match_word = str_replace( '*', '%', $split_search[$i] );
							$sql = "SELECT m.block_id 
							    FROM " . MX_WORD_TABLE . " w, " . MX_MATCH_TABLE . " m 
								WHERE w.word_text LIKE '$match_word' 
								    AND m.word_id = w.word_id 
									AND w.word_common <> 1 
									$search_msg_only";
						}
						else
						{
							die('wrong charset');
//							$match_word = addslashes( '%' . str_replace( '*', '', $split_search[$i] ) . '%' );
//							$search_msg_only = ( $search_fields ) ? "OR article_title LIKE '$match_word'" : '';
//							$sql = "SELECT article_id
//							    FROM " . KB_ARTICLE_TABLE . "
//								WHERE article_body  LIKE '$match_word'
//								$search_msg_only";
						}
						if ( !( $result = $db->sql_query( $sql ) ) )
						{
							mx_message_die( GENERAL_ERROR, 'Could not obtain matched articles list', '', __LINE__, __FILE__, $sql );
						}

						$row = array();
						while ( $temp_row = $db->sql_fetchrow( $result ) )
						{
							$row[$temp_row['post_id']] = 1;

							if ( !$word_count )
							{
								$result_list[$temp_row['block_id']] = 1;
							}
							else if ( $current_match_type == 'or' )
							{
								$result_list[$temp_row['block_id']] = 1;
							}
							else if ( $current_match_type == 'not' )
							{
								$result_list[$temp_row['block_id']] = 0;
							}
						}

						if ( $current_match_type == 'and' && $word_count )
						{
							@reset( $result_list );
							while ( list( $block_id, $match_count ) = @each( $result_list ) )
							{
								if ( !$row[$post_id] )
								{
									$result_list[$post_id] = 0;
								}
							}
						}

						$word_count++;

						$db->sql_freeresult( $result );
				}
			}

			@reset( $result_list );

			$search_ids = array();
			while ( list( $block_id, $matches ) = each( $result_list ) )
			{
				if ( $matches )
				{
					$search_ids[] = $block_id;
				}
			}

			unset( $result_list );
			// $total_match_count = count( $search_ids ); // Added below after mx query
			// Store new result data
				
			$search_results = implode( ',', $search_ids );
 
				
			// Combine both results and search data (apart from original query)
			// so we can serialize it and place it in the DB
				
			$store_search_data = array(); 
				
			// Limit the character length (and with this the results displayed at all following pages) to prevent
			// truncated result arrays. Normally, search results above 12000 are affected.
			// - to include or not to include
			/*
				$max_result_length = 60000;
				if (strlen($search_results) > $max_result_length)
				{
			        $search_results = substr($search_results, 0, $max_result_length);
					$search_results = substr($search_results, 0, strrpos($search_results, ','));
					$total_match_count = count(explode(', ', $search_results));
			    }
			*/
	
			for( $i = 0; $i < count( $store_vars ); $i++ )
			{
				$store_search_data[$store_vars[$i]] = $$store_vars[$i];
			}
	
			$result_array = serialize( $store_search_data );
			unset( $store_search_data );
	
			mt_srand ( ( double ) microtime() * 1000000 );
			$search_id = mt_rand();
	
			$sql = "UPDATE " . MX_SEARCH_TABLE . " 
			        SET search_id = $search_id, search_array = '" . str_replace( "\'", "''", $result_array ) . "'
					WHERE session_id = '" . $userdata['session_id'] . "'";
			
			if ( !( $result = $db->sql_query( $sql ) ) || !$db->sql_affectedrows() )
			{
				$sql = "INSERT INTO " . MX_SEARCH_TABLE . " (search_id, session_id, search_array) 
				    	 VALUES($search_id, '" . $userdata['session_id'] . "', '" . str_replace( "\'", "''", $result_array ) . "')";
				
				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Could not insert search results', '', __LINE__, __FILE__, $sql );
				}
			}
		}
		else
		{
			$search_id = intval($search_id);
			if ( $search_id )
			{
				$sql = "SELECT search_array 
				        FROM " . MX_SEARCH_TABLE . " 
					    WHERE search_id = $search_id  
					        AND session_id = '" . $userdata['session_id'] . "'";

				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, 'Could not obtain search results', '', __LINE__, __FILE__, $sql );
				}

				if ( $row = $db->sql_fetchrow( $result ) )
				{
					$search_data = unserialize( $row['search_array'] );
					for( $i = 0; $i < count( $store_vars ); $i++ )
					{
						$$store_vars[$i] = $search_data[$store_vars[$i]];
					}
				}
			}
			
			$search_ids = explode(',', $search_results);
		} 
			
		//
		// Look up data ...
		//
		if ( count($search_ids) > 0 )
		{
			//
			// Get all pages with view access
			//
			$sql = "SELECT * FROM " . PAGE_TABLE;
			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, "Couldn't get list of page", "", __LINE__, __FILE__, $sql );
			}
				
			$valid_page_ids_array = array();
			while ( $page_row = $db->sql_fetchrow( $result ))
			{
				//
				// Page auth
				//
				$page_auth_ary = array();
				$page_auth_ary = page_auth( AUTH_VIEW, $userdata, $page_row['auth_view'], $page_row['auth_view_group'] );
				
				if ( $page_auth_ary['auth_view']  )
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
			foreach($search_ids as $key => $block_id)
			{
				$page_id_array = get_page_id($block_id, false, true);

				if (in_array($page_id_array['page_id'], $valid_page_ids_array))
				{
					$page_ids[$block_id] = $page_id_array;
					$block_ids[] = $block_id;
				}
			}
				
			$valid_block_ids = implode( ', ', $block_ids );
				
			//
			// Generate page_blocks data
			//
			$sql = "SELECT block_id, block_desc, block_title, block_time, block_editor_id
			   		FROM " . BLOCK_TABLE . "     
					WHERE block_id IN (" . $valid_block_ids . ")
					ORDER BY block_time DESC
					LIMIT ".$start.", ".$per_page;	

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not obtain search results', '', __LINE__, __FILE__, $sql );
			}	
							
		} 
						
		//
		// Output header
		//
		$mx_page->page_title = $lang['Search'];
		$template->set_filenames( array( 'body' => 'mx_search_results.tpl' ) );

		$total_match_count = count($block_ids);
		
		$l_search_matches = ( $total_match_count == 1 ) ? sprintf( $lang['Found_search_match'], $total_match_count ) : sprintf( $lang['Found_search_matches'], $total_match_count );

		$template->assign_vars( array( 
			'L_SEARCH_MATCHES' => $l_search_matches,
			'L_ARTICLE' => $lang['Mx_Page'] ) 
		);

		$highlight_active = '';
		$highlight_match = array();
		for( $j = 0; $j < count( $split_search ); $j++ )
		{
			$split_word = $split_search[$j];

			if ( $split_word != 'and' && $split_word != 'or' && $split_word != 'not' )
			{
				$highlight_match[] = '#\b(' . str_replace( "*", "([\w]+)?", $split_word ) . ')\b#is';
				$highlight_active .= " " . $split_word;

				for ( $k = 0; $k < count( $synonym_array ); $k++ )
				{
					list( $replace_synonym, $match_synonym ) = split( ' ', trim( strtolower( $synonym_array[$k] ) ) );

					if ( $replace_synonym == $split_word )
					{
						$highlight_match[] = '#\b(' . str_replace( "*", "([\w]+)?", $replace_synonym ) . ')\b#is';
						$highlight_active .= ' ' . $match_synonym;
					}
				}
			}
		}

		$highlight_active = urlencode( trim( $highlight_active ) );
			
		//
		// Dump out the results
		//
		while( $searchdata = $db->sql_fetchrow($result) )
		{
			$search_block_id = $searchdata['block_id'];
			
			if (is_array($page_ids[$search_block_id]) && !empty($page_ids[$search_block_id]['block_id']))
			{
				$dynamic_block_id = $page_ids[$search_block_id]['block_id'];
				$pageid = $page_ids[$search_block_id]['page_id'];
			}
			else if (is_array($page_ids[$search_block_id]))
			{
				$dynamic_block_id = '';
				$pageid = $page_ids[$search_block_id]['page_id'];				
			}
			else 
			{
				$dynamic_block_id = '';
				$pageid = $page_ids[$search_block_id];					
			}

			$page_title = $page_ids[$search_block_id]['page_name'];
			$page_desc = $page_ids[$search_block_id]['page_desc'];
			
			$temp_url = !empty($dynamic_block_id) ?  mx_append_sid( PORTAL_URL . 'index.php?page=' . $pageid . '&dynamic_block=' . $dynamic_block_id )  : mx_append_sid( PORTAL_URL . 'index.php?page=' . $pageid );
			
			$editor_name_tmp = get_userdata( $searchdata['block_editor_id'] );
			$editor_name = $editor_name_tmp['username'];
			
			$edit_time = !empty($searchdata['block_time']) ? '(' . create_date( $board_config['default_dateformat'], $searchdata['block_time'], $board_config['board_timezone'] ) . ')' : '';

			$block_editor = '<a href="' . mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $searchdata['block_editor_id']) . '" class="name">';
			$block_editor .= $editor_name;
			$block_editor .= '</a>';
						
			$block_title = $searchdata['block_title'];
			$block_desc = $searchdata['block_desc'];
			
			$block_title_url = '<a href="' . $temp_url . '" class="name">' . $block_title . '</a>';
			$page_title_url = '<a href="' . $temp_url . '" class="name">' .$page_title . '</a>';

			/*
			$message = '';
			if ( count( $orig_word ) )
			{
				$article_title = preg_replace( $orig_word, $replacement_word, $searchset[$i]['article_title'] );
			}
			*/

			$template->assign_block_vars( 'searchresults', array( 
				'BLOCK_ID' => $block_id,
				
				'L_BLOCK_UPDATED' => !empty($edit_time) ? '<br />' . $lang['Block_updated_by'] : '',
				'BLOCK_EDITOR' => !empty($edit_time) ? $block_editor : '',
				"EDIT_TIME" => !empty($edit_time) ? $edit_time : '',
				
				'BLOCK_TITLE_URL' => $block_title_url,
				'BLOCK_DESC' => !empty($block_desc) ? '<br />' . $block_desc : '',
				
				'PAGE_TITLE_URL' => $page_title_url,
				'PAGE_DESC' => !empty($page_desc) ? '<br />' . $page_desc : '',
			));
		}

		$base_url = mx_this_url( "search_id=$search_id" );
		$new_search_url = mx_append_sid( PORTAL_URL . 'index.php?page=' . $page_id );

		$template->assign_vars( array( 
			'PAGINATION' => generate_pagination( $base_url, $total_match_count, $per_page, $start ),
			'PAGE_NUMBER' => sprintf( $lang['Page_of'], ( floor( $start / $per_page ) + 1 ), ceil( $total_match_count / $per_page ) ),

			'L_AUTHOR' => $lang['Author'],
			'L_PAGE' => $lang['Mx_Page'],  
			'L_BLOCK' => $lang['Mx_Block'],  
			'L_NEW_SEARCH' => $lang['Mx_new_search'],
			  
			'U_NEW_SEARCH' => $new_search_url  
		));

		break;

	default: 
		
		//
		// Output the basic page
		//
		$mx_page->page_title = $lang['Search'];

		$template->set_filenames( array( 'body' => 'mx_search_body.tpl' ) );

		$template->assign_vars( array( 
			'L_SEARCH_QUERY' => $lang['Search_query'],
			'L_SEARCH_KEYWORDS' => $lang['Search_keywords'],
			'L_SEARCH_KEYWORDS_EXPLAIN' => $lang['Search_keywords_explain'],
			'L_SEARCH_ANY_TERMS' => $lang['Search_for_any'],
			'L_SEARCH_ALL_TERMS' => $lang['Search_for_all'],

			'S_SEARCH_ACTION' => mx_append_sid( mx_this_url( "mode=results" ) ),
			'S_HIDDEN_FIELDS' => '',
			'S_SEARCH' => $lang['Search']  
		));

		break;
}

$template->pparse( 'body' );

?>