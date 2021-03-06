<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_google.php,v 1.13 2014/05/18 06:24:56 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net
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