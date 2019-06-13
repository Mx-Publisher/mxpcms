<?php
/**
*
* @package mxBB Portal Module - mx_counter
* @version $Id: admin_counter_cfg.php,v 1.5 2013/06/25 18:28:00 orynider Exp $
* @copyright (c) 2003 [orynider@rdslink.ro, OryNider] mxBB Development Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

// ======================================================
//			[ ADMINCP COMMON INITIALIZATION ]
// ======================================================


//
// Add our entry to the Administration Control Panel...
//
if ( !empty( $setmodules ) )
{
	$file = @basename( __FILE__ );
	$module['Portal_Counter']['Configuration std'] = 'modules/mx_counter/admin/' . $file;
	return;
}

//
// Setup basic portal stuff...
//
$mx_root_path = '../../../';
$module_root_path = "../";
@define('IN_PORTAL', 1);
//
// Security and page header...
//
//
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require($mx_root_path . '/admin/pagestart.'.$phpEx);

//
// Include common module stuff...
//
require($module_root_path . 'includes/counter_common.'.$phpEx);

// **********************************************************************
// Read language definition
// **********************************************************************
if ( !file_exists( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx ) )
{
	include( $module_root_path . 'language/lang_english/lang_admin.' . $phpEx );
}
else
{
	include( $module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx );
}

//
// Send page header...
//
include_once($mx_root_path . 'admin/page_header_admin.'.$phpEx);


// ======================================================
//			[ MAIN PROCESS ]
// ======================================================

//
// Read the module settings...
//
$sql = "SELECT * FROM ".COUNTER_CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	mx_message_die(GENERAL_ERROR, "Couldn't query counter config table", "", __LINE__, __FILE__, $sql);
}
while( $row = $db->sql_fetchrow($result) )
{
	$config_name = $row['config_name'];
	$config_value = $row['config_value'];
	$default_config[$config_name] = $config_value;

	$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];
	if( isset($HTTP_POST_VARS['submit']))
	{
		$sql = "UPDATE ".COUNTER_CONFIG_TABLE.
			" SET config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'" .
			" WHERE config_name = '$config_name'";
		if( !$db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, "Failed to update counter configuration for $config_name", "", __LINE__, __FILE__, $sql);
		}
	}
}

$digitpath = $default_config['digitpath'];

$template->set_filenames(array(
	"body" => "admin/counter_config_body.tpl")
);

for($i=0;$i<=$default_config['digits'];$i++)
{
	$digit_image = '<img src=' . $module_root_path . 'numbers/' . $digitpath . '/' . $i . '.gif>';

	$template->assign_block_vars('digitpreview', array('DIGIT_IMAGE' => $digit_image));
}

$dir = $module_root_path . 'numbers/';


$direct = opendir($dir);
$file = readdir($direct);

	while ($file)
	{
		$file = readdir($direct);
		$filetype = filetype($dir . $file);
		if ($file == ".." OR $file == "." OR $file == "")
		{
			$pagelist_digitpath = "";
		}
		elseif ($filetype == "dir")
		{
			$pagelist_digitpath = "<OPTION value=\"$file\" > $file \n";
		}
		$template->assign_block_vars('digitpagelist', array('DIGITPATH' => $pagelist_digitpath));
    }

$s_hidden_fields = '<input type="hidden" name="config_name" value="' . htmlspecialchars($new[$config_name]) . '" />';



$template->assign_vars(array(
	'S_ACTION'				=> mx_append_sid("admin_counter_cfg.$phpEx"),
	'S_HIDDEN_FIELDS'			=> $s_hidden_fields,
	'L_COUNTER_SETTINGS'			=> $lang['Counter_Settings'],
	'L_COUNTER_SETTINGS_EXPLAIN' 		=> $lang['Counter_Settings_explain'],
	'L_SUBMIT'				=> $lang['Submit'],
	'L_RESET'				=> $lang['Reset'],
	'L_DIGITS'				=> $lang['digits'],
	'L_DIGITPATH'				=> $lang['digitpath'],
	'L_DIGITPREVIEW'			=> $lang['digitpreview'],

	'DIGITS'				=> $new['digits'],
	'DIGITPATH'				=> $pagelist_digitpath
	));

$template->pparse("body");

include_once($mx_root_path . 'admin/page_footer_admin.' . $phpEx);

?>