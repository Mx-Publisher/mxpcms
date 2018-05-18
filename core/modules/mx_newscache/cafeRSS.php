<?php

/* CaféRSS 1.0

   by Michel Valdrighi, on 2002/08/08
   licensed under the GPL, see license.txt for information

   please keep this comment here */
   
if(!defined('IN_PORTAL'))
{
	die("Hacking attempt");
}

class cafeRSS 
{

	var $url;
	var $debugtimer;

	/* defaut values */
	var $items = 'all';
	var $use_cache = 1;
	var $cache_dir = 'cache'; # if you want to cache, chmod a directory 777 and put its name here
	var $refresh_time = 900; # in seconds - has no effect if $use_cache = 0;
	var $echo = 1;
	var $debug = 0;
	var $block_size = '100%';

  /* usage: $this->assign('var','value'); */

	function assign($var, $value) {
		$this->$var = $value;
	}


	/* usage: $this->display('url' [, those optional parameters below ]); */

	function display($rss_file = 'blah', $rss_items = 'blah', $rss_use_cache= 'blah', $rss_cache_dir = 'blah', $rss_refresh_time = 'blah', $rss_echo = 'blah', $rss_debug = 'blah') {

    global $template;

		if ($rss_file            == 'blah') { $rss_file            = $this->url; }
		if ($rss_items           == 'blah') { $rss_items           = $this->items; }
		if ($rss_use_cache       == 'blah') { $rss_use_cache       = $this->use_cache; }
		if ($rss_cache_dir       == 'blah') { $rss_cache_dir       = $this->cache_dir; }
		if ($rss_refresh_time    == 'blah') { $rss_refresh_time    = $this->refresh_time; }
		if ($rss_echo            == 'blah') { $rss_echo            = $this->echo; }
		if ($rss_debug           == 'blah') { $rss_debug           = $this->debug; }

		$rss_cache_file = $rss_cache_dir.'/'.preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $rss_file).'.cache';


		if (preg_match('/</', $rss_file)) {
			$content = $rss_file;
		} else {

			/* the secret cache ops, part I */

			if (($rss_cache_dir != '') && ($rss_use_cache)) {
				clearstatcache();
				$get_rss = 1;
				$cache_rss = 1;
				if (file_exists($rss_cache_file)) {
					if ((time() - filemtime($rss_cache_file)) < $rss_refresh_time) {
						$this->timer_start();
						$f = fopen($rss_cache_file, 'r');
						$content = fread($f, filesize($rss_cache_file));
						fclose($f);
						$debugfopencachetime = $this->timer_stop(0);
						$get_rss = 0;
					}
				}
			} else {
				$get_rss = 1;
				$cache_rss = 0;
			}


			/* opens the RSS file */

			$this->timer_start();
			if ($get_rss) {
				$f = @fopen($rss_file,'r');
				if (!$f)
				{
				  echo "Error file $rss_file does not exist";
				  return;
				}

				while (!feof($f)) {
					$content .= fgets($f, 4096);
				}
				fclose($f);
			}
			$debugfopentime = $this->timer_stop(0);


			/* the secret cache ops, part II */

			if (($cache_rss) && ($rss_use_cache)) {
				$this->timer_start();
				$f = fopen($rss_cache_file, 'w+');
				fwrite($f, $content);
				fclose($f);
				$debugcachetime = $this->timer_stop(0);
			} else {
				$debugcachetime = 0;
			}

		}

		/* gets RSS channel info and RSS items info */

		$this->timer_start();
		preg_match_all("'<channel>(.+?)<title>(.*?)</title>(.+?)</channel>'si",$content,$rss_title);
		preg_match_all("'<channel>(.+?)<link>(.*?)</link>(.+?)</channel>'si",$content,$rss_link);
		preg_match_all("'<channel>(.+?)<description>(.*?)</description>(.+?)</channel>'si",$content,$rss_description);
		preg_match_all("'<channel>(.+?)<lastBuildDate>(.*?)</lastBuildDate>(.+?)</channel>'si",$content,$rss_lastBuildDate);
		preg_match_all("'<channel>(.+?)<docs>(.*?)</docs>(.+?)</channel>'si",$content,$rss_docs);
		preg_match_all("'<channel>(.+?)<managingEditor>(.*?)</managingEditor>(.+?)</channel>'si",$content,$rss_managingEditor);
		preg_match_all("'<channel>(.+?)<webMaster>(.*?)</webMaster>(.+?)</channel>'si",$content,$rss_webMaster);
		preg_match_all("'<channel>(.+?)<language>(.*?)</language>(.+?)</channel>'si",$content,$rss_language);
		preg_match_all("'<image>(.+?)<link>(.*?)</link>(.+?)</image>'si",$content,$rss_image_link);
		preg_match_all("'<image>(.+?)<url>(.*?)</url>(.+?)</image>'si",$content,$rss_image_url);
		preg_match_all("'<image>(.+?)<title>(.*?)</title>(.+?)</image>'si",$content,$rss_image_title);
		preg_match_all("'<item>(.+?)<title>(.*?)</title>(.+?)</item>'si",$content,$rss_item_titles);
		preg_match_all("'<item>(.+?)<link>(.*?)</link>(.+?)</item>'si",$content,$rss_item_links);
		preg_match_all("'<item>(.+?)<description>(.*?)</description>(.+?)</item>'si",$content,$rss_item_descriptions);
		$rss_title          = $rss_title[2][0];
		$rss_link           = $rss_link[2][0];
		$rss_description    = $rss_description[2][0];
		$rss_lastBuildDate  = $rss_lastBuildDate[2][0];
		$rss_docs           = $rss_docs[2][0];
		$rss_managingEditor = $rss_managingEditor[2][0];
		$rss_webMaster      = $rss_webMaster[2][0];
		$rss_language       = $rss_language[2][0];
		$rss_image_title    = $rss_image_title[2][0];
		$rss_image_url      = $rss_image_url[2][0];
		$rss_image_link     = $rss_image_link[2][0];

		$debugparsersstime  = $this->timer_stop(0);

		/* processes the template - rss channel info */

		$this->timer_start();
		
    $template->assign_vars(array( 
  	   'RSS_TITLE'   => $rss_title,
       'RSS_LINK'    => $rss_link
    ) ); 
	

		/* processes the template - rss image info */

		if ($rss_image_url != '') {
  	  $template->assign_block_vars("rss_image", array(
	      'RSS_IMAGE_URL'   => $rss_image_url,
        'RSS_IMAGE_TITLE' => $rss_image_title,
        'RSS_IMAGE_LINK'  => $rss_image_link 
      ));
		}

		/* processes the template - rss items info */

		$k = count($rss_item_titles[2]);
		$j = (($rss_items == 'all') || ($rss_items > $k)) ? $k : intval($rss_items);
		for ($i = 0; $i<$j; $i++) {



			$tmp_title       = $rss_item_titles[2][$i];
			$tmp_link        = $rss_item_links[2][$i];
			$tmp_description = $rss_item_descriptions[2][$i];
			if ($tmp_description == '') {
				$tmp_description = '-';
			}
			if ($tmp_title == '') {
				$tmp_title = substr($tmp_description,0,20);
				if (strlen($tmp_description) > 20) {
					$tmp_title .= '...';
				}
			}

  	  $template->assign_block_vars("rss_items", array(
	      'RSS_ITEM_LINK'         => $tmp_link,
        'RSS_ITEM_TITLE'        => $tmp_title,
        'RSS_ITEM_DESCRIPTION'  => $tmp_description
      ));

		}

		$debugprocesstemplatetime = $this->timer_stop(0);

		clearstatcache();
		
		
		/* echoes or returns the processed template :) */

		if ($rss_echo) {
			echo $rss_template;
			if ($rss_debug) {
				echo '<p>';
				echo $debugfopentime.' seconds to load the remote RSS file.<br />';
				echo $debugparsersstime.' seconds to parse the RSS.<br />';
				echo $debugfopentemplatetime.' seconds to load the template file.<br />';
				echo $debugprocesstemplatetime.' seconds to process the template.<br />';
				if ($cache_rss) {
					echo $debugcachetime.' seconds to cache the parsing+processing.<br />';
				}
				echo '<br />';
				$debugtotaltime = ($debugfopentime+$debugparsersstime+$debugfopentemplatetime+$debugfopentemplatetime+$debugprocesstemplatetime+$debugcachetime);
				echo 'Total: '.$debugtotaltime.' seconds.';
				echo '</p>';
			}
		} else {
			return;
		}

	}

	function timer_start() {
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$this->debugtimer = $mtime;
		return true;
	}

	function timer_stop($display=0,$precision=3) {
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$this->debugtimer = $mtime - $this->debugtimer;
		if ($display)
			echo number_format($this->debugtimer,$precision);
		return($this->debugtimer);
	}

}
?>