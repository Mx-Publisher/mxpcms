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

//
// Read block Configuration
//
$title = $mx_block->block_info['block_title'];
$block_size = (isset($block_size) && !empty($block_size) ? $block_size : '100%');
$description = $mx_block->block_info['block_desc'];
$show_block = $mx_block->block_info['show_block'];
$show_title = ($userdata['user_level'] == ADMIN) ? true : $mx_block->block_info['show_title'];
$show_stats = $mx_block->block_info['show_stats'];

$rss_nbr_display = $block_config[$block_id]['rss_nbr_display']['parameter_value'];
$rss_title = $block_config[$block_id]['rss_title']['parameter_value'];
$rss_source = $block_config[$block_id]['rss_source']['parameter_value'];
$news_folder   = $block_config[$block_id]['News_Folder']['parameter_value'];


include_once($module_root_path . 'cafeRSS.php');


	// Cache duration in seconds. The cache will be updated with a live feed after the specified time
	$cachetimeinseconds=1800;

	// Location to the raw news cache file

  $cache_file = $module_root_path . $news_folder;
  if ( is_writable( $cache_file ) )
  {
    $f_fcache = true;
  }
  else
  {
    $f_fcache = false;
  }

  //
  // Display information
  //
  $template->set_filenames(array(
		"body_news_rss" => "mx_news_rss.tpl")
  );


  $rss = new cafeRSS();
  $rss->assign('items', $rss_nbr_display);
  $rss->assign('use_cache', $f_fcache);
  if ( $f_fcache )
  {
    $rss->assign('cache_dir', $cache_file);
  }
  $rss->display( $rss_source );

  if (!empty($rss_title))
  {
    $template->assign_vars(array( 
  	 'RSS_TITLE'      => $rss_title
    ) ); 
  }

  $template->assign_vars(array( 
     'BLOCK_SIZE'   => ( !empty( $block_size ) ? $block_size : '100%' ),
     'U_URL'        => mx_append_sid( 'index.php?block_id=' . $block_id ),
     'L_CHANGE_NOW' => $lang['Change']
 ) ); 


  
$template->pparse("body_news_rss");


?>
