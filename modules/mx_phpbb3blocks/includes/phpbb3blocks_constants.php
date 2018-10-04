<?php
/**
*
* @package MX-Publisher Module - mx_phpbb2blocks
* @version $Id: phpbb3blocks_constants.php,v 1.6 2014/05/19 18:15:12 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if (!defined('IN_PORTAL'))
{
	exit;
}

switch (PORTAL_BACKEND)
{
	case 'internal':
	case 'smf2':
	case 'phpbb2':
		mx_message_die(GENERAL_MESSAGE, 'There are blocks on this page designed for MX-Publisher with phpBB3 backend, thus not compatible with current setup.');
	break;
	
	case 'phpbb3':
	case 'olympus':
	case 'ascraeus':
	
	break;
}

// -------------------------------------------------------------------------
// Footer Copyrights
// -------------------------------------------------------------------------
if (is_object($mx_page))
{
	// -------------------------------------------------------------------------
	// Extend User Style with module lang and images
	// Usage:  $mx_user->extend(LANG, IMAGES)
	// Switches:
	// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
	// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
	// -------------------------------------------------------------------------
	$mx_user->extend(MX_LANG_MAIN, MX_IMAGES);
}

// Forum/Topic states
!defined('FORUM_CAT') ? define('FORUM_CAT', 0) : false;
!defined('FORUM_POST') ? define('FORUM_POST', 1) : false;
!defined('FORUM_LINK') ? define('FORUM_LINK', 2) : false;
!defined('ITEM_UNLOCKED') ? define('ITEM_UNLOCKED', 0) : false;
!defined('ITEM_LOCKED') ? define('ITEM_LOCKED', 1) : false;
!defined('ITEM_MOVED') ? define('ITEM_MOVED', 2) : false;

// Topic types
!defined('POST_NORMAL') ? define('POST_NORMAL', 0) : false;
!defined('POST_STICKY') ? define('POST_STICKY', 1) : false;
!defined('POST_ANNOUNCE') ? define('POST_ANNOUNCE', 2) : false;
!defined('POST_GLOBAL') ? define('POST_GLOBAL', 3) : false;
!defined('POST_GLOBAL_ANNOUNCE') ? define('POST_GLOBAL_ANNOUNCE', 3) : false;
!defined('POST_NEWS') ? define('POST_NEWS', 4) : false;
?>