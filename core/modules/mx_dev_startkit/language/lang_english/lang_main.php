<?php
/**
*
* @package MX-Publisher Module - mx_dev_startkit
* @version $Id: lang_main.php,v 1.7 2008/06/03 20:07:28 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

//
// Block specific
//
$lang['Startkit'] 					= 'This is a developer\'s startkit example block';

$lang['Startkit_parameter'] 		= 'Block Parameters';
$lang['Startkit_parameter_explain'] = 'Block parameters are set in the blockCP - unique for this block and included in MXP cache';
$lang['Test_string'] 				= 'This is block parameter (string), with value: ';
$lang['Test_number'] 				= 'This is block parameter (number), with value: ';

$lang['Startkit_parameter_modified'] 			= 'Modified block parameter';
$lang['Startkit_parameter_modified_explain'] 	= 'This parameter has been modified by the script';
$lang['Test_modified'] 				= 'This is a modified block parameter: the parameter \'number\' has been doubled';

$lang['Startkit_parameter_custom'] 	= 'Custom block parameter';
$lang['Startkit_parameter_custom_explain'] 		= 'Additional module parameters are defined in admin/mx_module_defs.php';
$lang['Test_custom'] 				= 'This is a block parameter (custom), with value: ';

$lang['Startkit_config'] 			= 'Module config values';
$lang['Startkit_config_explain'] 	= 'Config values are set in the adminCP - main settings for all module blocks';
$lang['Test_config1'] 				= 'This is a config setting, with value: ';
$lang['Test_config2'] 				= 'This is a second config setting, with value: ';

$lang['Startkit_get'] 				= 'GET value';
$lang['Startkit_get_explain'] 		= 'This is a fetched GET parameter';
$lang['Test_get_par'] 				= 'This block recognizes the GET var "test". Try adding "&amp;test=whatever" to the page url.';
?>