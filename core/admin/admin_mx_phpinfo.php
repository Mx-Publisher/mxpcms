<?php
/**
*
* @package mxBB Portal Core
* @version $Id: admin_mx_phpinfo.php,v 1.2 2009/01/24 16:45:47 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if( !empty($setmodules) )
{
	$module['4_Panel_system']['4_1_PHPinfo'] = 'admin/' . basename(__FILE__);
	return;
}

//
// Security and Page header
//
@define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require('./pagestart.' . $phpEx);

//
// Capture the phpInfo output
//
ob_start();
phpinfo();
$output = ob_get_contents();
ob_end_clean();

//
// Extract the BODY part.
//
preg_match_all('#<body[^>]*>(.*)</body>#siU', $output, $body_part);
$body_part = $body_part[1][0];

//
// Remove all, but some HTML Tags.
//
$allowedTags = '<h1><h2><h3><hr><ul><ol><li><b><i><u>'.
	'<a><pre><blockquote><img><div><span><p><br>'.
	'<table><tr><td><th><thead><tbody><tfoot>';

$body_part = strip_tags($body_part, $allowedTags);

//
// Alter some CSS related attributes.
//
$body_part = preg_replace('# (style|class)=["\'](.*?)["\']#si', '', $body_part);
$body_part = preg_replace('#<hr(.*?)>#si', '<hr size="1" width="600" />', $body_part);
$body_part = preg_replace('#<img(.*?)>#si', '<img style="float:right; border:0px;"\1>', $body_part);
$body_part = preg_replace('#<td(.*?)>(.*?)</td>#si', '<td\1><span class="genmed">\2</span></td>', $body_part);
$body_part = preg_replace('#cellpadding="(.*?)"#si', 'cellpadding="2"', $body_part);
$body_part = preg_replace('#cellspacing="(.*?)"#si', '', $body_part);
$body_part = preg_replace('#<table(.*?)>#si', '<table\1 cellspacing="1" class="forumline" style="margin-left:auto;margin-right:auto;">', $body_part);
$body_part = preg_replace('#<td(.*?)>#si', '<td\1 class="row1">', $body_part);
$body_part = preg_replace('#<td(.*?)class="row1">#si', '<td\1class="row2">', $body_part);

//
// Send the formatted result to the browser.
//
$template->set_filenames(array('phpinfo' => 'admin/admin_mx_phpinfo.tpl'));
$template->assign_vars(array('PHPINFO' => $body_part));
$template->pparse('phpinfo');

//
// Send page footer.
//
include_once('page_footer_admin.' . $phpEx);
?>