<?php
/**
*
* @package MX-Publisher Module - mx_dev_startkit
* @version $Id: admin_dev_startkit.php,v 1.7 2008/06/03 20:07:27 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

define( 'IN_PORTAL', true );

if ( !empty( $setmodules ) )
{
	$filename = basename( __FILE__ );
	$module['Hej']['Hej'] = 'modules/mx_dev_startkit/admin/' . $filename;
	return;
}

$mx_root_path = '../../../';
$module_root_path = "../";
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require( $mx_root_path . '/admin/pagestart.' . $phpEx );

//
// Includes
//
require( $module_root_path . 'includes/startkit_constants.' . $phpEx );

include_once( $mx_root_path . 'admin/page_header_admin.' . $phpEx );

// --------------------------------------------------
$sql = "SELECT * FROM " . STARTKIT_CONFIG_TABLE;
if ( !$result = $db->sql_query( $sql ) )
{
	mx_message_die( GENERAL_ERROR, "Couldn't query dev startkit config table", "", __LINE__, __FILE__, $sql );
}
else
{
	while ( $row = $db->sql_fetchrow( $result ) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = $config_value;

		$new[$config_name] = ( isset( $HTTP_POST_VARS[$config_name] ) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if ( isset( $HTTP_POST_VARS['submit'] ) )
		{
			$sql = "UPDATE " . STARTKIT_CONFIG_TABLE . " SET
				config_value = '" . str_replace( "\'", "''", $new[$config_name] ) . "'
				WHERE config_name = '$config_name'";

			if ( !$db->sql_query( $sql ) )
			{
				mx_message_die( GENERAL_ERROR, "Failed to update startkit configuration for $config_name", "", __LINE__, __FILE__, $sql );
			}
		}
	}

	if ( isset( $HTTP_POST_VARS['submit'] ) )
	{
		$message = $lang['Startkit_config_updated'] . "<br /><br />" . sprintf( $lang['Startkit_return_config'], "<a href=\"" . mx_append_sid( "admin_dev_startkit.$phpEx" ) . "\">", "</a>" ) . "<br /><br />" . sprintf( $lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid( $mx_root_path . "admin/index.$phpEx?pane=right" ) . "\">", "</a>" );
		mx_message_die( GENERAL_MESSAGE, $message );
	}
}

$startkit_config1 = $new['startkit_config1'];

$startkit_config2_yes = ( $new['startkit_config2'] ) ? "checked=\"checked\"" : "";
$startkit_config2_no = ( !$new['startkit_config2'] ) ? "checked=\"checked\"" : "";

$template->set_filenames( array(
	"body" => "admin/startkit_config_body.tpl" )
);

$template->assign_vars( array(
		"S_CONFIG_ACTION" => mx_append_sid( "admin_dev_startkit.$phpEx" ),

		"L_YES" => $lang['Yes'],
		"L_NO" => $lang['No'],

		"L_CONFIGURATION_TITLE" => $lang['Config_Startkit'],
		"L_CONFIGURATION_EXPLAIN" => $lang['Config_Startkit_explain'],
		"L_GENERAL_SETTINGS" => $lang['Config_Startkit'],

		"L_STARTKIT_CONFIG1" => $lang['startkit_config1'],
		"L_STARTKIT_CONFIG1_EXPLAIN" => $lang['startkit_config1_explain'],
		"L_STARTKIT_CONFIG2" => $lang['startkit_config2'],
		"L_STARTKIT_CONFIG2_EXPLAIN" => $lang['startkit_config2_explain'],

		"L_SUBMIT" => $lang['Submit'],
		"L_RESET" => $lang['Reset'],

		"STARTKIT_CONFIG1" => $startkit_config1,
		"S_STARTKIT_CONFIG2_YES" => $startkit_config2_yes,
		"S_STARTKIT_CONFIG2_NO" => $startkit_config2_no
	));

$template->pparse( "body" );

include_once( $mx_root_path . 'admin/page_footer_admin.' . $phpEx );

?>