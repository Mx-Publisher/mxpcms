<?php
/***************************************************************************
 *                             mx_news.php
 *                            -------------------
 *   begin                : April, 2002
 *   copyright            : (C) 2002 MX-System
 *   email                : support@mx-system.com
 *
 *
 ***************************************************************************/
if( !defined('IN_PORTAL') || !is_object($mx_block) )
{
	die("Hacking attempt");
}
  
$block_config = read_block_config($block_id);
$block_config = $mx_cache->_get_block_config($block_id, 0, 'block_config');
//$block_parameters = $mx_cache->_get_block_config($block_id, 0, 'block_parameters');
//$block_config = $mx_cache->read($block_id);
//
// Read block Configuration
//
$title = $mx_block->block_info['block_title'];
$block_size = (isset($block_size) && !empty($block_size) ? $block_size : '100%');
$description = $mx_block->block_info['block_desc'];
$show_block = $mx_block->block_info['show_block'];
$show_title = ($userdata['user_level'] == ADMIN) ? true : $mx_block->block_info['show_title'];
$show_stats = $mx_block->block_info['show_stats'];

global $newsbuffer;

$New_Cache_Time = 1800;
//$News_Xml_File  = $mx_block->block_parameters['News_Xml_File']['parameter_value'];
$News_Xml_File  = $block_config[$block_id]['block_parameters']['News_Xml_File']['parameter_value'];
$News_Folder    = $block_config[$block_id]['block_parameters']['News_Folder']['parameter_value'];
$New_Cache_Time = $block_config[$block_id]['block_parameters']['New_Cache_Time']['parameter_value'];
// News feed URL. Please select your category from http://w.moreover.com/categories/category_list_xml.html
//		$xmlfile = "https://www.huffingtonpost.com/topic/israel/feed?o=xml";
/* $feed = json_decode(json_encode(simplexml_load_file('news.google.com/?output=rss')), true); */
//$News_Xml_File  = "https://www.huffingtonpost.com/topic/israel/feed?o=xml";
//$News_Xml_File  = "https://news.google.com/news/rss/headlines/section/topic/WORLD?ned=us&hl=en&gl=US";

//
// Load module constants and functions
//
include_once($mx_root_path . $mx_block->module_root_path . "includes/mx_constants.$phpEx"); // Will load additional module lang keys, definitions, copyrights and theme data
include_once($mx_root_path . $mx_block->module_root_path . "includes/mx_functions.$phpEx"); // Will load additional module functions (be sure to prefix with 'mx_' to avoid function conflicts)


if (preg_match('|^https?:|', $News_Xml_File))
{	
	$host = explode("//", $News_Xml_File);
	$host = $host[1];
	$host = explode("/", $host);
	$domain = $host[0];
	$counthost = count($host) - 1;
	$docid2 = $host[$counthost];
	
	$sitename = substr(feed_sitename($domain), 1);
	$sitesufix = feed_sitesufix($domain);	
}		


// Cache duration in seconds. The cache will be updated with a live feed after the specified time
$cachetimeinseconds = $New_Cache_Time;

// Location to the raw news cache file
$newsfile = $module_root_path . $News_Folder . str_replace(' ', '_', $title) . (!empty($sitename) ? str_replace('www.', '_', $title) : '') . ".xml";
//$newsfile = $module_root_path . $News_Folder . str_replace(' ', '_', $title) . ".xml";
// Location to the formatted news cache file (used by phpBB)
$cachefile = $module_root_path . $News_Folder . str_replace(' ', '_', $title) . ".php";

$current_time = explode(" ", microtime(), 2);

$newsfeedtext = "";

if (!is_writable($module_root_path . $News_Folder))
{
  $newsfeedtext = "Can't not write in Folder or overwrite File in : " . $module_root_path . $News_Folder;
  //return;
}

	
if((!file_exists($mx_root_path . $newsfile) || (!filesize($mx_root_path . $newsfile)) || ($current_time[1] - filemtime($mx_root_path . $newsfile) > $cachetimeinseconds)))
{
	// Step 1 - Caching Routine
	if (($file = @fopen($News_Xml_File, "r"))) 
	{
		$fpwrite = @fopen($mx_root_path . $newsfile, "w");

		$line = "";
		while ((!feof($file))) 
		{
			$line = @fgets($file, 1024);
			@fputs($fpwrite, $line);
		}

		@fclose($file);
		@fclose($fpwrite);

		// Step 2 - XML Parsing and Content Rendering Routine
		$depth = $obj;
		//$depth->tree = '$obj->tree';
		//$depth->xml = '$obj->xml';		
		$content = array();
		$curtag = "";
		$newsbuffer = "";
		$headline_count = 1;

		if (($fp = @fopen($mx_root_path . $newsfile, "r"))) 
		{
			$newsbuffer = "";
			
			
			$json = feed_get_contents($newsfile);
			$newsbuffer = json_encode($json);
			
			//xml_parser_free($xml_parser); $newsfeedtext .= print_r($json, true); 
			
			fclose($fp);
			/** Step 3 - Generate HTML **/			
			$fpwrite = fopen($mx_root_path . $cachefile, "w");
			fputs($fpwrite, "<?php\n  " . str_replace("'", "\\'", str_replace('\\', '\\\\', print_r($json, true))) . "\n?>" );	
			fclose($fpwrite);
			/**/			
			$newsfeedtext .= "<!-- NewsCache Updated //-->\n\n";
		}
		else
		{		
			$newsfeedtext .= "<!-- Could not open XML input //-->\n\n"; 
		}			
	} 
}
//
// Display information
//
$template->set_filenames(array(
	"body_news" => "mx_news.tpl")
); 
$newsbuffer = "";
if (file_exists($mx_root_path . $newsfile))
{
	$newsbuffer = feed_get_contents($newsfile);
    	
	$title = !empty($newsbuffer['title']) ? $newsbuffer['title'] : $title; // Israel
    $description = !empty($newsbuffer['description']) ? $newsbuffer['description'] : $description; // Israel news and opinion
    $link = $newsbuffer['link']; // https://www.huffingtonpost.com/topic/israel
    $items = $newsbuffer['item']; // array()
	
	$template->assign_vars(array(
		'BLOCK_SIZE'	=> (!empty( $block_size ) ? $block_size : '100%'),
		'MY_NEWS_CODE'	=> $description,
		'L_TITLE'		=> $title,
		'U_URL'			=> $link
	));	
	
	/**/
	
	$headline_count = 0;	
	
	foreach($items as $key => $item) 
	{		
		$items[$key] = $item;
		$title = urldecode($item['title']);
		$description = urldecode($item['description']);
		$enclosure = urldecode($item['enclosure']);
		$type = !empty($item['type']) ? urldecode($item['type']) : 'image';
		$length = $item['length'];		
		$pubdate = $item['pubdate'];
		$ts = $item['ts'];
		$guid = urldecode($item['guid']);
		$domain = 'youtube.' . 'com';
		
		if (preg_match('|^https?:|', $enclosure))
		{	
			$host = explode("//", $enclosure);
			$host = $host[1];
			$host = explode("/", $host);
			$domain = $host[0];
			$counthost = count($host) - 1;
			$docid2 = $host[$counthost];			
		}		
		
		$sitename = substr(feed_sitename($domain), 1);
		$sitesufix = feed_sitesufix($domain);
		$domain = $sitename . $sitesufix;
		
		if (preg_match('|^youtube?:|', $enclosure))
		{	
			$videoid = explode("=", $enclosure);		
			$img_id = 'http://img.' . $domain . '/vi/' . $videoid[1] . '/default.jpg';
			$url_video = 'http://' . $domain . '/v/' . $videoid[1];
		}
		
		switch ($type)
		{
			case (preg_match('/flash.*/', $type) ? true : false) :
				$html_code = '<EMBED src="' . $url_video . '" quality=high scale=noborder wmode=transparent bgcolor=#000000 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>';
				$enclosure = 'url="' . $enclosure . '" ' . 'type="application/x-shockwave-flash" length="1024000"';
				break;

			case (preg_match('/(\.ram|\real|\realaudio)$/i', $type) ? true : false) :
				$html_code = '<embed src="' . $enclosure . '" id="VideoPlayback" type="audio/x-pn-realaudio-plugin" wmode="transparent" width="425" height="350"></embed>';
				$enclosure = 'url="' . $enclosure . '" ' . 'type="audio/x-pn-realaudio-plugin" length="1024000"';
				break;

			case (preg_match('/flash.*/', $type) ? true : false) :
				$html_code = '<embed src="' . $url_video . '" wmode="transparent" width="425" height="350" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
				$enclosure = 'url="' . $enclosure . '" ' . 'type="application/x-shockwave-flash" length="1024000"';
				break;

			case (preg_match('/(\.youtube|\shockwave)$/i', $type) ? true : false) :
				$html_code = '<embed src="' . $url_video . '" id="VideoPlayback" wmode="transparent" width="425" height="350" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />' . '<a href="' . $enclosure . '">' . '<br />' . '<img src="' . $enclosure . '" border="1" vspace="2" hspace="2" align="left" width="425" height="350" />' . '</a>';
				$enclosure = 'url="' . $enclosure . '" ' . 'type="application/x-shockwave-flash" length="1024000"';
				break;

			case (preg_match('/flv.*/', $type) ? true : false) :
				$html_code = '<embed src="' . $url_video . '" flashvars="file=' . $enclosure. '&image=' . $enclosure . '&shuffleOnLoad=no" loop="false" allowfullscreen="true" menu="false" quality="high" width="425" height="350" scale="noscale" salign="lt" name="flvplayer" align="center" bgcolor="000000" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
				$enclosure = 'url="' . $enclosure . '" ' . 'type="application/x-shockwave-flash" length="1024000"';
				break;

			case (preg_match('/(\.qt|\quicktime)$/i', $type) ? true : false) :
				$html_code  = '<embed src="templates/subSilver/images/uneedqt41.jpg" qtsrc="' . $enclosure . '" width="377" height="212" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/" controller="true" loop="false" autoplay="false" kioskmode="true" cache="false"></embed>';
				$enclosure = 'url="' . $enclosure . '" ' . 'type="$type" length="1024000"';
				break;

			case (preg_match('/(\.image|\jpeg|\/png|\/gif|\/bmp)$/i', $type) ? true : false) :
				$html_code = '<a href="' . $guid . ' "target="_new">' . '<img src="' . $enclosure . '" border="1" vspace="2" hspace="2" align="left" width="425" height="350" />' . '</a>';
				$enclosure = 'url="' . $enclosure . '" ' . 'type="$type" length="1024000"';
				break;
				
			case (preg_match('/(\.audio|\mpeg)$/i', $type) ? true : false) :
			default:
				$html_code = '<embed type="$type" height="70" width="300" AUTOSTART="0" filename="' . $enclosure . '" src="' . $enclosure . '" ></embed>';
				$enclosure = 'url="' . $enclosure . '" ' . 'type="$type" length="' . $length . '"';
		}

		$rss_description = '';
		$rss_description .= '' . $description  . ' ';
		$rss_description .= '' . $html_code  . ' ';
		$rss_description .= '<a href="' . $guid  . ' "target=\"_blank\">';
		$rss_description .= '' . str_replace(array('https://', 'http://'), '', $link) . '</a>' . '<br/>';		
		$rss_description .= '' . $newsfeedtext  . '<br/>';
		
		$template->assign_block_vars('items', array( //#
			'U_KEY'			=> strtoupper($key),
			'KEY'			=> $key,					
			'BLOCK_SIZE'	=> (!empty( $block_size ) ? $block_size : '100%'),
			'L_TITLE'		=> $title,
			'MY_NEWS_CODE'	=> $rss_description,			
			'U_URL'			=> $enclosure,
			'COUNTER'		=> $headline_count,
		));				
		$headline_count++;	
	}
	/**/	
}
else
{			
	$newsbuffer = "Unavailable.<br><br>Please try later.";
	$news_text = $newsbuffer . "\n\n" . $newsfeedtext; //gen_news(); // 
	
	$template->assign_block_vars("no_news_and_items", array(
		'BLOCK_SIZE'	=> (!empty( $block_size ) ? $block_size : '100%'),
		'MY_NEWS_CODE'	=> $news_text,
		'L_TITLE'		=> $title,
		'U_URL'			=> $link
	));	
}


  
$template->pparse("body_news");
$template->destroy();
?>