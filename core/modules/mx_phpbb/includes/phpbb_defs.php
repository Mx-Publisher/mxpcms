<?php
/**
*
* @package Mx-Publisher Module - mx_phpbb
* @version $Id: phpbb_defs.php,v 1.2 2010/10/16 04:07:43 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] Mx-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

define( 'NEWS_CAT_TABLE', FORUMS_TABLE );
$cat_extract_order = 'cat_id, forum_order';

$cool_array_category_id = 'forum_id';

$cat_table_category_id = 'f.forum_id';
$item_table_category_id = 't.forum_id';

$item_table_item_id = 't.topic_id';
$item_table_item_type = 't.topic_type';
$item_table_item_time = 't.topic_time';
$item_table_item_last_time = 't.topic_last_post_id';
$item_table_item_title = 't.topic_title';

$item_id = 'topic_id';
$item_type = 'topic_type';
$item_cat_id = 'forum_id';
$item_text = 'post_text';
$item_bbcode_uid = 'bbcode_uid';
$item_time = 'topic_time';
$item_views = 'topic_views';
$item_title = 'topic_title';

$catt_id = 'forum_id';
$catt_name = 'forum_name';
$catt_desc = 'forum_desc';

$item_types_all = 'forum_news';
$item_types_array = array( 'forum_news_announce', 'forum_news_announce', 'forum_news_sticky', 'forum_news_post' );
$item_types_id_array = array( POST_GLOBAL_ANNOUNCE, POST_ANNOUNCE, POST_STICKY, POST_NORMAL );

?>