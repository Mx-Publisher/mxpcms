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
 *    $Id: mx_google.php,v 1.3 2010/10/16 04:06:36 orynider Exp $
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

$template->set_filenames(array(
	'body_google' => 'mx_google.tpl')
);

$template->assign_vars(array(
	'BLOCK_SIZE' => $block_size,
	'L_SEARCH' => $lang['Search'],
	'L_TITLE' => 'Google'
));

$template->pparse('body_google');

?>