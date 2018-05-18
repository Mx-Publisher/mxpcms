<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_search.php,v 1.2 2009/01/24 16:47:53 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
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

if( !function_exists('add_search_words') )
{
	mx_cache::load_file('functions_search', 'phpbb2');
}

//
// Define initial vars
//
$mode = $mx_request_vars->request('mode', MX_TYPE_NO_TAGS, '');

if ($mx_request_vars->is_request('search_keywords'))
{
	$search_keywords = $mx_request_vars->request('search_keywords', MX_TYPE_NO_TAGS);
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

$show_results = $mx_request_vars->post('show_results', MX_TYPE_NO_TAGS, 'posts');

if ($mx_request_vars->is_post('search_terms'))
{
	$search_terms = ( $mx_request_vars->post('search_terms',MX_TYPE_NO_TAGS) == 'all' ) ? 1 : 0;
}
else
{
	$search_terms = 0;
}

if ( $mx_request_vars->is_post('search_fields'))
{
	$search_fields = ($mx_request_vars->post('search_fields', MX_TYPE_NO_TAGS) == 'all' ) ? 1 : 0;
}
else
{
	$search_fields = 0;
}

$sort_by = $mx_request_vars->post('sort_by', MX_TYPE_INT, 0);

if ($mx_request_vars->is_post('sort_dir'))
{
	$sort_dir = ($mx_request_vars->post('sort_dir', MX_TYPE_NO_TAGS) == 'DESC' ) ? 'DESC' : 'ASC';
}
else
{
	$sort_dir = 'DESC';
}

$start = $mx_request_vars->get('start', MX_TYPE_INT, 0);

$per_page = isset($board_config['topics_per_page']) ? $board_config['topics_per_page'] : 15;

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
				//if (preg_match('#^[\*%]+$#', trim($split_search[$i])) || preg_match('#^[^\*]{1,2}$#', str_replace(array('*', '%'), '', trim($split_search[$i])))) // < phpBB 2.0.21
				if ( strlen(str_replace(array('*', '%'), '', trim($split_search[$i]))) < $board_config['search_min_chars'] )
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

				$db->sql_freeresult($result);
			}

			$search_ids = explode(',', $search_results);
		}

		//
		// Look up data ...
		//
		if ( count($search_ids) > 0 )
		{
			/*
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
				$mx_page_temp = new mx_page();
				$mx_page_temp->init($page_row['page_id']);

				if ( $mx_page_temp->auth_view )
				{
					$valid_page_ids_array[] = $page_row['page_id'];
				}
			}

			$db->sql_freeresult($result);
			*/

			$valid_page_ids_array = array();
			foreach( $mx_page->page_rowset as $temp_key => $page_row )
			{
				$_auth_ary = $mx_page->auth($page_row['auth_view'], $page_row['auth_view_group'], $page_row['auth_moderator_group']);
				if ($_auth_ary['auth_view'])
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

			$db->sql_freeresult($result);

		}

		//
		// Output header
		//
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
		$editor_name_tmp = array();
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

			if (empty($editor_name_tmp[$searchdata['block_editor_id']]))
			{
				$editor_name_tmp[$searchdata['block_editor_id']] = mx_get_userdata( $searchdata['block_editor_id'] );
				$editor_name = $editor_name_tmp[$searchdata['block_editor_id']]['username'];
			}

			$edit_time = !empty($searchdata['block_time']) ? '(' . $phpBB2->create_date($board_config['default_dateformat'], $searchdata['block_time'], $board_config['board_timezone'] ) . ')' : '';

			$block_editor = '<a href="' . mx_append_sid(PHPBB_URL . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $searchdata['block_editor_id']) . '" class="name">';
			$block_editor .= $editor_name;
			$block_editor .= '</a>';

			$block_title = $searchdata['block_title'];
			$block_desc = $searchdata['block_desc'];

			$block_title_url = '<a href="' . $temp_url . '" class="name">' . $block_title . '</a>';
			$page_title_url = '<a href="' . $temp_url . '" class="name">' .$page_title . '</a>';

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
			'PAGINATION' => $phpBB2->generate_pagination( $base_url, $total_match_count, $per_page, $start ),
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