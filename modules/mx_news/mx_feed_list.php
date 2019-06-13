<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: mx_news_list.php,v 1.6 2008/07/10 22:23:06 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
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
$desc = $mx_block->block_info['block_desc'];
$block_size = ( isset( $block_size ) && !empty( $block_size ) ? $block_size : '100%' );
$feed_url = $mx_block->get_parameters('url_feed');
$feed_url = "http://torahportions.org/portions_rss.php";	
//Check for cash mod
/*
if (file_exists($phpbb_root_path . 'includes/functions_cash.'.$phpEx))
{
	define('IN_CASHMOD', true);
}
*/
$is_block = true;
global $images;
define('MXBB_27x', @file_exists($mx_root_path . 'mx_login.'.$phpEx));

// -------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------
// Start
// -------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------

// ===================================================
// ?
// ===================================================
list( $trash, $mx_script_name_temp ) = split ( trim( $board_config['server_name'] ), PORTAL_URL );
$mx_script_name = preg_replace( '#^\/?(.*?)\/?$#', '\1', trim( $mx_script_name_temp ) );

//
// Setup config parameters
//
$config_name = array( 'toplist_pagination', 'toplist_use_pagination', 'target_block', 'split_key', 'max_title_characters' , 'max_characters' );

for( $i = 0; $i < count( $config_name ); $i++ )
{
	$config_value = $mx_block->get_parameters( $config_name[$i] );
	$toplist_config[$config_name[$i]] = $config_value;
}
/*
if ($toplist_config['target_block'] == 0)
{
	echo('You need to set the target News Block for this list!');
	return;
}
*/

$toplist_config['split_key'] = '<!-- ' . $toplist_config['split_key'] . ' -->';

//
// Include the common file
//
include($module_root_path . 'mx_news/mx_news_common.' . $phpEx);

$mx_news_config['max_comment_subject_chars'] = $toplist_config['max_title_characters'];
$mx_news_config['max_comment_chars'] = $toplist_config['max_characters'];

$toplist_page_id = intval($toplist_config['target_block']) > 0 ? get_page_id( $toplist_config['target_block'] ) : get_page_id( 'mx_news.php', true );

//
// Get action variable other wise set it to the main
//
//$action = $mx_request_vars->request('action', MX_TYPE_NO_TAGS, 'list');
$action = 'lists';

// ===================================================
// Is admin?
// ===================================================
switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'phpbb2':
		$is_admin = ( ( $userdata['user_level'] == ADMIN  ) && $userdata['session_logged_in'] ) ? true : 0;
		break;
	case 'phpbb3':
		$is_admin = ( $userdata['user_type'] == USER_FOUNDER ) ? true : 0;
		break;
}

// ===================================================
// if the module is disabled give them a nice message
// ===================================================
if (!($mx_news_config['enable_module'] || $mx_user->is_admin))
{
	mx_message_die( GENERAL_MESSAGE, $lang['mx_news_disable'] );
}

//
// an array of all expected actions
//
$actions = array(
	'lists' => 'lists'
);

//
// Lets Build the page
//
if (!$is_block)
{
	include( $mx_root_path . 'includes/page_header.' . $phpEx );
}
$mx_news_functions->page_header();

//
// page body for mx_news
//
//$template->set_filenames( array( 'body' => $mx_news_tpl_name ) );

/*
	RSS Extractor and Displayer
	(c) 2007-2010  Scriptol.com - Licence Mozilla 1.1.
	rsslib.php
	
	Requirements:
	- PHP 5.
	- A RSS feed.
	
	Using the library:
	Insert this code into the page that displays the RSS feed:
	
	<?php
	require_once("rsslib.php");
	echo RSS_Display("http://www.xul.fr/rss.xml", 15);
	? >
	
*/

$RSS_Content = array();

function RSS_Tags($item, $type)
{
		$y = array();
		$tnl = $item->getElementsByTagName("title");
		$tnl = $tnl->item(0);
		$title = $tnl->firstChild->textContent;

		$tnl = $item->getElementsByTagName("link");
		$tnl = $tnl->item(0);
		$link = $tnl->firstChild->textContent;
		
		$tnl = $item->getElementsByTagName("pubDate");
		$tnl = $tnl->item(0);
		$date = $tnl->firstChild->textContent;		

		$tnl = $item->getElementsByTagName("description");
		$tnl = $tnl->item(0);
		$description = $tnl->firstChild->textContent;

		$y["title"] = $title;
		$y["link"] = $link;
		$y["date"] = $date;		
		$y["description"] = $description;
		$y["type"] = $type;
		
		return $y;
}

function RSS_Channel($channel)
{
	global $RSS_Content;

	$items = $channel->getElementsByTagName("item");
	
	// Processing channel
	
	$y = RSS_Tags($channel, 0);		// get description of channel, type 0
	array_push($RSS_Content, $y);
	
	// Processing articles
	
	foreach($items as $item)
	{
		$y = RSS_Tags($item, 1);	// get description of article, type 1
		array_push($RSS_Content, $y);
	}
}

function RSS_Retrieve($url)
{
	global $RSS_Content;

	$doc  = new DOMDocument();
	$doc->load($url);

	$channels = $doc->getElementsByTagName("channel");
	
	$RSS_Content = array();
	
	foreach($channels as $channel)
	{
		 RSS_Channel($channel);
	}
	
}

function RSS_RetrieveLinks($url)
{
	global $RSS_Content;

	$doc  = new DOMDocument();
	$doc->load($url);

	$channels = $doc->getElementsByTagName("channel");
	
	$RSS_Content = array();
	
	foreach($channels as $channel)
	{
		$items = $channel->getElementsByTagName("item");
		foreach($items as $item)
		{
			$y = RSS_Tags($item, 1);	// get description of article, type 1
			array_push($RSS_Content, $y);
		}
		 
	}

}

function RSS_Links($url, $size = 15)
{
	global $RSS_Content;

	$page = "<ul>";

	RSS_RetrieveLinks($url);
	if($size > 0)
		$recents = array_slice($RSS_Content, 0, $size + 1);

	foreach($recents as $article)
	{
		$type = $article["type"];
		if($type == 0) continue;
		$title = $article["title"];
		$link = $article["link"];
		$page .= "<li><a href=\"$link\">$title</a></li>\n";			
	}

	$page .="</ul>\n";

	return $page;
	
}

function RSS_Display($url, $size = 15, $site = 0, $withdate = 0)
{
	global $RSS_Content;

	$opened = false;
	$page = "";
	$site = (intval($site) == 0) ? 1 : 0;

	RSS_Retrieve($url);
	if($size > 0)
		$recents = array_slice($RSS_Content, $site, $size + 1 - $site);

	foreach($recents as $article)
	{
		$type = $article["type"];
		if($type == 0)
		{
			if($opened == true)
			{
				$page .="</ul>\n";
				$opened = false;
			}
			$page .="<b>";
		}
		else
		{
			if($opened == false) 
			{
				$page .= "<ul>\n";
				$opened = true;
			}
		}
		$title = $article["title"];
		$link = $article["link"];
		$page .= "<li><a href=\"$link\">$title</a>";
		if($withdate)
		{
      $date = $article["date"];
      $page .=' <span class="rssdate">'.$date.'</span>';
    }
		$description = $article["description"];
		if($description != false)
		{
			$page .= "<br><span class='rssdesc'>$description</span>";
		}
		$page .= "</li>\n";			
		
		if($type==0)
		{
			$page .="</b><br />";
		}

	}

	if($opened == true)
	{	
		$page .="</ul>\n";
	}
	return $page."\n";
	
}

echo RSS_Display($feed_url, 15, false, true);

//mx_news_get_content($feed_url);
//$template->pparse( 'body' );

$mx_news_functions->page_footer();

if (!$is_block)
{
	include( $mx_root_path . 'includes/page_tail.' . $phpEx );
}
?>