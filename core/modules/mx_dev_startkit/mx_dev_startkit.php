<?php
/**
*
* @package MX-Publisher Module - mx_dev_startkit
* @version $Id: mx_dev_startkit.php,v 1.8 2008/06/03 20:07:26 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

/********************************************************************************\
| Developers Startkit Module
|********************************************************************************
|
| General Core resources
| ------------------
| Every block inherit a basic set of block and page attributes. These are obtained from the mx_block and mx_page objects.
| Core also defines a set of basic variables
|
|
| Examples:
|
| Block attributes: $mx_block->block_id, $mx_block->block_title|block_desc, $mx_block->auth_view|auth_edit|auth_mod
| Page attributes: $mx_page->info['page_name']
| Basic variables: $mx_root_path (string), $phpbb_root_path (string), $template (object), $db (object)
|
| The full list of object attributes are available in the classes technical notes (see includes/mx_functions_core.php).
| The full set of portal predefined variables are defined in includes/mx_constants.php
|
| Handy Core methods
| ------------------
| When porting phpBB MODs to MX-Publisher, typically you need a few standard rewrites. The mx_modules class provides a handy set of methods.
|
|
| Examples:
|
| $mx_module->mx_append_sid()
| $mx_module->redirect()
| $mx_module->make_jumpbox()
| $mx_module->generate_pagination()
| $mx_module->smilies_pass()
| $mx_module->generate_smilies()
|
|
| Remember: All instances of page_header and page_tail inclusions should be removed, not to interfer with MX-Publisher headers
|
|
| Module Parameters Api
| ------------------
| Core provides a rich set of parameter types. Additional block specific types are defined in module_root/admin/mx_module_defs.php.
| Block parameters are accessed with the mx_block->get_parameters() method.
|
| mx_block->get_parameters() Api
|
| Available switches: MX_GET_ALL_PARS, MX_GET_PAR_VALUE (default), MX_GET_PAR_OPTIONS
|
| Examples:
|
| $mx_block->get_parameters( MX_GET_ALL_PARS )
| - returns an array with all parameters :: array('par_name1' => $par1_value, 'par_name2' => $par2_value,  ...)
|
| $mx_block->get_parameters( 'parameter_name' )
| - returns value for 'parameter_name'
|
| $mx_block->get_parameters( 'parameter_name',  MX_GET_PAR_OPTIONS )
| - returns options for 'parameter_name', eg bbcodes etc
|
|
| Module Settings using additional db tables
| ------------------
| More advanced modules need additional settings, intended for ALL module blocks.
| For example, a image album module needs a defined pics folder and other modules may use global settings
| NOTE: Block specific parameters should never use additional (non portal) db tables, since such data is NOT included in the portal cache engine and therefore speed will be affected.
|
| Example:
|
| Data should be managed in an axtra module adminCP panel
| Db tables to be used should be defined in the includes/mx_module_constants.php file
| Data should be accessed using the standard $db api.
|
\********************************************************************************/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Load module constants and functions
//
include_once($mx_root_path . $mx_block->module_root_path . "includes/startkit_constants.$phpEx"); // Will load additional module lang keys, definitions, copyrights and theme data
include_once($mx_root_path . $mx_block->module_root_path . "includes/startkit_functions.$phpEx"); // Will load additional module functions (be sure to prefix with 'mx_' to avoid function conflicts)

//
// Load POST/GET vars
// - When php.ini is set with Register Globals Off (highly recommended due to security), you need to declare all GET/POST vars
// - The $mx_request_vars api is documented in includes/mx_functions.php.
//
$test_get_var = $mx_request_vars->request('test', MX_TYPE_INT, 1); // In this example the GET var is validated for integer and set to '1' as default (if no GET var is given)

// Load main module configs (using an additional db tables)
// Consider if this is really needed for the module, since it requeres one additinal db query per page block instance
//
$sql = "SELECT * FROM " . STARTKIT_CONFIG_TABLE;
if ( !$result = $db->sql_query( $sql ) )
{
	mx_message_die( CRITICAL_ERROR, "Could not query config information", "", __LINE__, __FILE__, $sql );
}
else
{
	$mx_module_config = array();
	while ( $results = $db->sql_fetchrow( $result ) )
	{
		$config_name = $results['config_name'];
		$config_value = $results['config_value'];
		$mx_module_configs[$config_name] = $config_value;
	}
}

//
// Load (custom) module block parameters
// - be careful not to use too common variable names - to avoid conflicts with other blocks
// - additional module parameters are defined in module_root/admin/mx_module_defs.php
//
// If possible, do this instead
//
// $mx_startkit_pars['test_string'] = $mx_block->get_parameters( 'startkit_test_string' );
// $mx_startkit_pars['test_number'] = $mx_block->get_parameters( 'startkit_test_number' );
// $mx_startkit_pars['test_custom'] = $mx_block->get_parameters( 'startkit_test_custom' );
//
$mx_par_test_string = $mx_block->get_parameters( 'startkit_test_string' );
$mx_par_test_number = $mx_block->get_parameters( 'startkit_test_number' );
$mx_par_test_custom = $mx_block->get_parameters( 'startkit_test_custom' );

//
// Get Module Name from module_id
//
$sql = "SELECT module_name FROM " . MODULE_TABLE . " WHERE module_id = " . $mx_par_test_custom;
if ( !$result = $db->sql_query( $sql ) )
{
	mx_message_die( CRITICAL_ERROR, "Could not query module information", "", __LINE__, __FILE__, $sql );
}
$results = $db->sql_fetchrow( $result );
$startkit_module_name = $results['module_name'];

//
// Load module functions
//
$mx_startkit = new mx_startkit;

//
// Start output of Block
//
$template->set_filenames( array( 'body' => 'startkit_body.tpl' ));

//
// Block Body
// - not much to do in this simple block
//

/*
...
*/

//
// Use a module function
//
$mx_manipulated_test_number = $mx_startkit->double($mx_par_test_number);

//
// Pass Block data to template
//
$template->assign_vars( array(
	//
	// Titles
	//
	'L_STARTKIT' => $lang['Startkit'],

	'L_STARTKIT_PARAMETER' => $lang['Startkit_parameter'],
	'L_STARTKIT_PARAMETER_EXPLAIN' => $lang['Startkit_parameter_explain'],
	'L_TEST_STRING' => $lang['Test_string'],
	'L_TEST_NUMBER' => $lang['Test_number'],

	'L_STARTKIT_PARAMETER_MODIFIED' => $lang['Startkit_parameter_modified'],
	'L_STARTKIT_PARAMETER_MODIFIED_EXPLAIN' => $lang['Startkit_parameter_modified_explain'],
	'L_TEST_MODIFIED' => $lang['Test_modified'],

	'L_STARTKIT_PARAMETER_CUSTOM' => $lang['Startkit_parameter_custom'],
	'L_STARTKIT_PARAMETER_CUSTOM_EXPLAIN' => $lang['Startkit_parameter_custom_explain'],
	'L_TEST_CUSTOM' => $lang['Test_custom'],

	'L_STARTKIT_CONFIG' => $lang['Startkit_config'],
	'L_STARTKIT_CONFIG_EXPLAIN' => $lang['Startkit_config_explain'],
	'L_TEST_CONFIG1' => $lang['Test_config1'],
	'L_TEST_CONFIG2' => $lang['Test_config2'],

	'L_STARTKIT_GET' => $lang['Startkit_get'],
	'L_STARTKIT_GET_EXPLAIN' => $lang['Startkit_get_explain'],
	'L_TEST_GET' => $lang['Test_get_par'],

	//
	// Values
	//
	'TEST_STRING' => $mx_par_test_string,
	'TEST_NUMBER' => $mx_par_test_number,
	'TEST_MODIFIED' => $mx_manipulated_test_number,
	'TEST_CUSTOM' => $startkit_module_name,

	'TEST_CONFIG1' => $mx_module_configs['startkit_config1'],
	'TEST_CONFIG2' => $mx_module_configs['startkit_config2'],

	'TEST_GET' => $test_get_var
));

//
// Generate Block
//
$template->pparse( 'body' );

?>