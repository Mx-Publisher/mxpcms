<?php
/**
*
* @package Mx-Publisher Module - mx_phpbb
* @version $Id: phpbb_constants.php,v 1.2 2010/10/16 04:07:43 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] Mx-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

if ( PORTAL_BACKEND != 'phpbb2' )
{
	mx_message_die(GENERAL_MESSAGE, 'There are blocks on this page designed for Mx-Publisher with phpBB2 backend, thus not compatible with current setup.');
}

define( 'PAGE_FORUM', -502 );
define( 'PHPBB_CONFIG_TABLE', $mx_table_prefix . 'phpbb_plugin_config' );

define( 'POST_ADD_TYPE', 20 );
define( 'TOPIC_ADD_TYPE_TABLE', $mx_table_prefix . 'topic_add_type' );

// **********************************************************************
// Read theme definition
// **********************************************************************
if ( file_exists( $module_root_path . "templates/" . $theme['template_name'] . "/images" ) )
{
	// ----------
	$current_template_images = $module_root_path . "templates/" . $theme['template_name'] . "/images" ;
	// ----------
}
else
{
	// ----------
	$current_template_images = $module_root_path . "templates/" . "_core" . "/images" ;
	// ----------
}

$images['phpbb_folder_announce'] = $images['folder_announce'];
$images['phpbb_folder_sticky'] = $images['folder_sticky'];
$images['phpbb_folder'] = $images['folder'];

//
// get type list for adding and editing articles
//
function phpbb2_get_types()
{
	$item_types_array = array( 'forum_news_announce', 'forum_news_announce', 'forum_news_sticky', 'forum_news_post' );
	$item_types_id_array = array( POST_GLOBAL_ANNOUNCE, POST_ANNOUNCE, POST_STICKY, POST_NORMAL );

	return array( $item_types_array, $item_types_id_array );
}

if (is_object($mx_page))
{
	$mx_page->add_copyright( 'Mx-Publisher phpBB Module' );
}

$mx_user->set_module_default_style('_core'); // For compatibility with core 2.8.x
?>