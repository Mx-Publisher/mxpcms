<?php
/**
*
* @package MX-Publisher Installation
* @version $Id: upgrade_schemas_map.php,v 1.23 2008/02/04 15:58:07 joasch Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

$upgrade_schemas_map = array(
	//array('schema' => 'upgrade_to_2.705'	, 'sql' => "SELECT auth_view FROM mx_table_page"),
	//array('schema' => 'upgrade_to_2.706'	, 'sql' => "SELECT portal_version FROM mx_table_portal"),
	//array('schema' => 'upgrade_to_2.7.1'	, 'sql' => "SELECT link_target FROM mx_table_menu_nav"),
	array('schema' => 'upgrade_to_2.8_a1'	, 'sql' => "SELECT parameter_order FROM mx_table_parameter"),
	array('schema' => 'upgrade_to_2.8_a2'	, 'sql' => "SELECT phpbb_stats FROM mx_table_page"),
	array('schema' => 'upgrade_to_2.8_b2'	, 'sql' => "SELECT overall_header FROM mx_table_portal"),
	array('schema' => 'upgrade_to_2.8_b3'	, 'sql' => "SELECT main_layout FROM mx_table_portal"),
	array('schema' => 'upgrade_to_2.8.0'	, 'sql' => "SELECT override_user_style FROM mx_table_portal"),
	array('schema' => 'upgrade_to_2.8.1'	, 'sql' => "SELECT portal_status FROM mx_table_portal"),
	array('schema' => 'upgrade_to_2.9.0'	, 'sql' => "SELECT portal_desc FROM mx_table_portal"),
	array('schema' => 'upgrade_to_2.9.1'	, 'sql' => "SELECT themes_id FROM mx_table_themes"),
	array('schema' => 'upgrade_to_2.9.2'	, 'sql' => "SELECT smilies_id FROM mx_table_smilies"),
);

// --------------------
// DEBUG ONLY ;-)
//
//echo('upgrade_schemas_map: '.var_export($upgrade_schemas_map, true)."<br />\n");
// --------------------
?>