<?php
/**
*
* @package mxBB Portal Module - mx_counter
* @version $Id: counter_constants.php,v 1.4 2011/03/29 02:39:29 orynider Exp $
* @copyright (c) 2006 [orynider@rdslink.ro, OryNider] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

if ( !defined('IN_PORTAL') )
{
	die('Hacking attempt');
}

//
// Define table names.
//
@define('COUNTER_CONFIG_TABLE', $mx_table_prefix.'counter_config');
@define('COUNTER_SESSION_TABLE', $mx_table_prefix.'counter_session');
@define('IMAGEDIRECTORY', PORTAL_URL . 'modules/mx_counter/numbers/');


?>