#
# mxBB-Portal - MySQL Schema - Upgrade "2.7.4"
#
# $Id: mysql_schema_upgrade_to_2.7.4.sql,v 1.3 2010/10/16 04:06:19 orynider Exp $
#

# ------------------------------------------------------------
#
# New Function, Block and Parameters 'IncludeX'
#
SET module = SELECT * FROM mx_table_module WHERE module_name = 'Core Blocks';
SET function	= SELECT MAX(function_id)	AS next_id FROM mx_table_function;
SET block		= SELECT MAX(block_id)		AS next_id FROM mx_table_block;
SET parameter	= SELECT MAX(parameter_id)	AS next_id FROM mx_table_parameter;

SET function.next_id = function.next_id + 1;
INSERT INTO mx_table_function VALUES('{function.next_id}', '{module.module_id}', 'IncludeX', 'IncludeX Block, include file or url', 'mx_include_file.php', NULL);

SET block.next_id = block.next_id + 1;
INSERT INTO mx_table_block VALUES('{block.next_id}', 'IncludeX', 'IncludeX Block, include file or url', '{function.next_id}', '0', '0', '0', '', '', '', '', '1', '1', '0', '', '0');

SET parameter.next_id = parameter.next_id + 1;
INSERT INTO mx_table_parameter VALUES('{parameter.next_id}', '{function.next_id}', 'include_file', 'Text', '0', '');
INSERT INTO mx_table_block_system_parameter VALUES('{block.next_id}', '{parameter.next_id}', '0', '', '0');

SET parameter.next_id = parameter.next_id + 1;
INSERT INTO mx_table_parameter VALUES('{parameter.next_id}', '{function.next_id}', 'show_title', 'Boolean', 'TRUE', '');
INSERT INTO mx_table_block_system_parameter VALUES('{block.next_id}', '{parameter.next_id}', 'TRUE', '', '0');

SET parameter.next_id = parameter.next_id + 1;
INSERT INTO mx_table_parameter VALUES('{parameter.next_id}', '{function.next_id}', 'iframe_mode', 'Boolean', 'FALSE', '');
INSERT INTO mx_table_block_system_parameter VALUES('{block.next_id}', '{parameter.next_id}', 'FALSE', '', '0');

SET parameter.next_id = parameter.next_id + 1;
INSERT INTO mx_table_parameter VALUES('{parameter.next_id}', '{function.next_id}', 'include_url', 'Text', 'http://www.mx-publisher.com', '');
INSERT INTO mx_table_block_system_parameter VALUES('{block.next_id}', '{parameter.next_id}', 'http://www.mx-publisher.com', '', '0');

SET parameter.next_id = parameter.next_id + 1;
INSERT INTO mx_table_parameter VALUES('{parameter.next_id}', '{function.next_id}', 'iframe_height', '300', '0', '');
INSERT INTO mx_table_block_system_parameter VALUES('{block.next_id}', '{parameter.next_id}', '0', '', '0');

# ------------------------------------------------------------
#
# New Parameters for Function 'Navigation Menu' (added by Jaime)
#
SET function = SELECT * FROM mx_table_function WHERE function_name = 'Navigation Menu';
SET block = SELECT * FROM mx_table_block WHERE block_title = 'Navigation Menu';

SET parameter.next_id = parameter.next_id + 1;
INSERT INTO mx_table_parameter VALUES('{parameter.next_id}', '{function.function_id}', 'menu_display_mode', 'Text', 'Vertical', '');
INSERT INTO mx_table_block_system_parameter VALUES('{block.block_id}', '{parameter.next_id}', 'Vertical', NULL);

SET parameter.next_id = parameter.next_id + 1;
INSERT INTO mx_table_parameter VALUES('{parameter.next_id}', '{function.function_id}', 'menu_page_sync', 'Text', '0', '');
INSERT INTO mx_table_block_system_parameter VALUES('{block.block_id}', '{parameter.next_id}', '0', NULL);

# ------------------------------------------------------------
#
# New Fields in Table `mx_menu_categories` (added by Jaime)
#
ALTER TABLE mx_table_menu_categories ADD cat_url SMALLINT(5) UNSIGNED DEFAULT '0';
ALTER TABLE mx_table_menu_categories ADD cat_target TINYINT(2) UNSIGNED DEFAULT '0' NOT NULL;

# ------------------------------------------------------------
#
# New Table `mx_page_templates` (added by Jaime)
#
CREATE TABLE mx_table_page_templates (
	page_template_id SMALLINT(3) UNSIGNED NOT NULL auto_increment,
	template_name VARCHAR(255) NOT NULL DEFAULT '',
	PRIMARY KEY (page_template_id)
);
INSERT INTO mx_table_page_templates VALUES('1', 'NONE');
INSERT INTO mx_table_page_templates VALUES('2', 'Two-Columns left');
INSERT INTO mx_table_page_templates VALUES('3', 'Two-Columns right');
INSERT INTO mx_table_page_templates VALUES('4', 'Three-Columns');

# ------------------------------------------------------------
#
# New Table `mx_column_templates` (added by Jaime)
#
CREATE TABLE mx_table_column_templates (
	column_template_id SMALLINT(5) UNSIGNED NOT NULL auto_increment,
	column_title VARCHAR(100) DEFAULT '0',
	column_order SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
	column_size VARCHAR(5) DEFAULT '0',
	page_template_id SMALLINT(5) NOT NULL DEFAULT '0',
	PRIMARY KEY (column_template_id),
	KEY cat_order (column_order)
);
INSERT INTO mx_table_column_templates VALUES('1', 'Left', '10', '200', '2');
INSERT INTO mx_table_column_templates VALUES('2', 'Right', '20', '100%', '2');
INSERT INTO mx_table_column_templates VALUES('3', 'Left', '10', '100%', '3');
INSERT INTO mx_table_column_templates VALUES('4', 'Right', '20', '200', '3');
INSERT INTO mx_table_column_templates VALUES('5', 'Left', '10', '150', '4');
INSERT INTO mx_table_column_templates VALUES('6', 'Middle', '20', '100%', '4');
INSERT INTO mx_table_column_templates VALUES('7', 'Right', '30', '150', '4');

# ------------------------------------------------------------
