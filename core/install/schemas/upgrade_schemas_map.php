<?php
/** ------------------------------------------------------------------------
 *		subject				: mxBB-Portal Upgrade Schemas Map
 *		begin            	: june, 2002
 *		copyright          	: (C) 2002-2005 mxBB-Portal
 *		email             	: jonohlsson@hotmail.com
 *		project site		: www.mx-publisher.com
 * 
 *		description			:
 * -------------------------------------------------------------------------
 * 
 *    $Id: upgrade_schemas_map.php,v 1.4 2011/03/05 10:29:55 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

//
// The following array is processed by mx_install.php script to guess the SQL schemas
// that should be applied when upgrading a target system.
//
// Please, note we use here 'mx_table_' as table prefix, as we also do in schema files.
// This will be replaced by mx_install.php with the real table prefix selected by the
// user in the installation panels.
//
// The map is read as follows:
//
// If the SQL statement fails, mx_install.php will process upgrades schemas from that
// point till the end of the table. So, the order of elements IS very important. ;-)
//
// When adding more elements to the map, please do so at the end.
//

$upgrade_schemas_map = array(
	array('schema' => 'upgrade_to_2.705'	, 'sql' => "SELECT auth_view FROM mx_table_page"),
	array('schema' => 'upgrade_to_2.706'	, 'sql' => "SELECT portal_version FROM mx_table_portal"),
	array('schema' => 'upgrade_to_2.7.1'	, 'sql' => "SELECT link_target FROM mx_table_menu_nav"),
	array('schema' => 'upgrade_to_2.8_rc5'	, 'sql' => "SELECT parameter_order FROM mx_table_parameter"),
	array('schema' => 'upgrade_to_2.8_rc7'	, 'sql' => "SELECT ip_filter FROM mx_table_page"),
	array('schema' => 'upgrade_to_2.7.8'	, 'sql' => "SELECT overall_header FROM mx_table_portal")	
);

// --------------------
// DEBUG ONLY ;-)
//
//echo('upgrade_schemas_map: '.var_export($upgrade_schemas_map, true)."<br />\n");
// --------------------

?>