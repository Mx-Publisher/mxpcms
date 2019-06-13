<?php
/**
*
* @package MX-Publisher Module - mx_news
* @version $Id: mx_news_list.php,v 1.6 2008/07/10 22:23:06 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

$phpEx = substr(strrchr(__FILE__, '.'), 1);

if ( !defined('PORTAL_BACKEND') && @file_exists( './viewtopic.' . $phpEx ) ) // -------------------------------------------- phpBB MOD MODE
{
	define( 'MXBB_MODULE', false );
	define( 'IN_PHPBB', true );
	define( 'IN_PORTAL', true );
	define( 'IN_DOWNLOAD', true );

	// When run as a phpBB mod these paths are identical ;)
	$phpbb_root_path = $module_root_path = $mx_root_path = './';
	$mx_mod_path = $phpbb_root_path . 'mx_mod/';

	//Check for cash mod
	if (file_exists($phpbb_root_path . 'includes/functions_cash.'.$phpEx))
	{
		define('IN_CASHMOD', true);
	}

	include( $phpbb_root_path . 'common.' . $phpEx );

	@ini_set( 'display_errors', '1' );
	error_reporting (E_ERROR | E_WARNING | E_PARSE); // This will NOT report uninitialized variables

	include_once( $mx_mod_path . 'includes/functions_required.' . $phpEx );
	include_once( $mx_mod_path . 'includes/functions_core.' . $phpEx );

	define( 'PAGE_DOWNLOAD', -501 ); // If this id generates a conflict with other mods, change it ;)

	//
	// Instatiate the mx_cache class
	//
	$mx_cache = new mx_cache();

	//
	// Get MX-Publisher config settings
	//
	$portal_config = $mx_cache->obtain_mxbb_config();

	//
	// instatiate the mx_request_vars class
	//
	$mx_request_vars = new mx_request_vars();

	$is_block = false;

	if ( file_exists("./modcp.$phpEx") ) // phpBB2
	{
		define('PORTAL_BACKEND', 'phpbb2');
		$tplEx = 'tpl';

		mx_cache::load_file('bbcode', 'phpbb2');
		mx_cache::load_file('functions_post', 'phpbb2');

		// Start session management
		$userdata = session_pagestart( $user_ip, PAGE_DOWNLOAD );
		init_userprefs( $userdata );
		// End session management


	}
	else if ( @file_exists("./mcp.$phpEx") ) // phpBB3
	{
		define('PORTAL_BACKEND', 'phpbb3');
		$tplEx = 'html';

		//
		// Start session management
		//
		$user->session_begin();
		$userdata = $user->data;
		$user->setup();
		//
		// End session management
		//

		//
		// Get phpBB config settings
		//
		$board_config = $config;
	}
	else
	{
		die('Copy this file in phpbb_root_path were is your viewtopic.php file!!!');
	}
}
else
{
	define( 'MXBB_MODULE', true );

	if ( !function_exists( 'read_block_config' ) )
	{
		if( isset($_REQUEST['action']) && $_REQUEST['action'] == 'download' )
		{
		   define('MX_GZIP_DISABLED', true);
		}

		define( 'IN_PORTAL', true );
		$mx_root_path = '../../';
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		include_once( $mx_root_path . 'common.' . $phpEx );

		// Start session management
		$mx_user->init($user_ip, PAGE_INDEX);
		// End session management

		$block_id = ( !empty( $_GET['block_id'] ) ) ? $_GET['block_id'] : $_POST['id'];
		if ( empty( $block_id ) )
		{
			$sql = "SELECT * FROM " . BLOCK_TABLE . "  WHERE block_title = 'mxNews' LIMIT 1";
			if ( !$result = $db->sql_query( $sql ) )
			{
				mx_message_die( GENERAL_ERROR, "Could not query mx_news module information", "", __LINE__, __FILE__, $sql );
			}
			$row = $db->sql_fetchrow( $result );
			$block_id = $row['block_id'];
		}
		$is_block = false;
	}
	else
	{
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

		//Check for cash mod
		if (file_exists($phpbb_root_path . 'includes/functions_cash.'.$phpEx))
		{
			define('IN_CASHMOD', true);
		}

		$is_block = true;
		global $images;
	}
	define( 'MXBB_27x', @file_exists( $mx_root_path . 'mx_login.'.$phpEx ) );
}

// -------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------
// Start
// -------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------

// ===================================================
// ?
// ===================================================
list($trash, $mx_script_name_temp ) = preg_split(trim('//', $board_config['server_name']), PORTAL_URL);
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

if ($toplist_config['target_block'] == 0)
{
	echo('You need to set the target News Block for this list!');
	return;
}

$toplist_config['split_key'] = '<!-- ' . $toplist_config['split_key'] . ' -->';

//
// Include the common file
//
include( $module_root_path . 'mx_news/mx_news_common.' . $phpEx );

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
if ( !$is_block )
{
	include( $mx_root_path . 'includes/page_header.' . $phpEx );
}
$mx_news->module( $actions[$action] );
$mx_news->modules[$actions[$action]]->main( $action );

$mx_news_functions->page_header();

//
// page body for mx_news
//
$template->set_filenames( array( 'body' => $mx_news_tpl_name ) );

$template->pparse( 'body' );

$mx_news_functions->page_footer();

if ( !$is_block )
{
	include( $mx_root_path . 'includes/page_tail.' . $phpEx );
}
?>