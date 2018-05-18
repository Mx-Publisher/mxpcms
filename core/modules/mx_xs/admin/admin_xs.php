<?php
/**
*
* @package mxBB Portal Module - mx_xs
* @version $Id: admin_xs.php,v 1.3 2010/10/16 04:08:34 orynider Exp $
* @copyright (c) 2002-2007 [Vjacheslav Trushkin, OryNider] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mxbb.net
*
*/

//if(empty($setmodules))
//{
//	return;
//}
$module_root_path = '../';
$mx_root_path = '../../../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

define('IN_XS', true);
define('XS_ADMIN_OVERRIDE', false);

include_once('xs_include.' . $phpEx);
//include_once('xs_config.' . $phpEx);
return;

?>