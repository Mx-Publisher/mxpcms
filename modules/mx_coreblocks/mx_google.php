<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_google.php,v 1.12 2008/02/04 16:04:30 joasch Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
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