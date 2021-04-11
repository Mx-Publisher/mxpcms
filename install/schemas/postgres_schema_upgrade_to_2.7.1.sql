--
-- mxBB-Portal - PostgreSQL Schema - Upgrade "2.7.1"
--
-- $Id: postgresql_schema_upgrade_to_2.7.1.sql,v 1.1 2005/03/06 01:18:56 jonohlsson Exp $
--

-- ------------------------------------------------------------
--
-- Drop unused Table `mx_block_user_parameter` (finally official)
--


-- ------------------------------------------------------------
--
-- New Fields in Table `mx_page`
--
ALTER TABLE mx_table_page ADD page_header VARCHAR(255) DEFAULT 'overall_header.tpl';

-- ------------------------------------------------------------
--
-- New Fields in Table `mx_menu_nav`
--
ALTER TABLE mx_table_menu_nav ADD link_target smallint UNSIGNED NOT NULL DEFAULT '0';

-- ------------------------------------------------------------
--
-- Updating Core Blocks Module
--
UPDATE mx_table_module
	SET module_name  = 'Core Blocks',
		module_desc = 'Core blocks'
	WHERE module_id = '10';

-- ------------------------------------------------------------
--
-- Updating TextBlocks Module
--
UPDATE mx_table_function
	SET module_id  = '20',
		function_name = 'TextBlock_BBcode',
		function_desc = 'TextBlock (BBcode) Block',
		function_file = 'mx_textblock_bbcode.php',
		function_admin = 'modules/mx_textblocks/admin/admin_edit.php'
	WHERE function_id = '10'
	OR function_file = 'mx_block.php';

UPDATE mx_table_function
	SET module_id  = '20',
		function_name = 'TextBlock_Html',
		function_desc = 'TextBlock (Html) Block',
		function_file = 'mx_textblock_html.php',
		function_admin = 'modules/mx_textblocks/admin/admin_edit.php'
	WHERE function_id = '70'
	OR function_file = 'mx_block_html.php';

INSERT INTO mx_table_module VALUES ('20', 'Text Blocks', 'modules/mx_textblocks/', 'Textblocks module', '');
INSERT INTO mx_table_function VALUES('22', '20', 'TextBlock_Multi', 'Textblock (BBcode and Html) with parameters', 'mx_textblock_multi.php', 'modules/mx_textblocks/admin/admin_edit.php');
INSERT INTO mx_table_parameter (function_id, parameter_name, parameter_type, parameter_default, parameter_function) VALUES('22', 'Text', 'BBText', 'Enter your block text here', '');
INSERT INTO mx_table_parameter (function_id, parameter_name, parameter_type, parameter_default, parameter_function) VALUES('22', 'text_style', 'Values', 'none', '');
INSERT INTO mx_table_parameter (function_id, parameter_name, parameter_type, parameter_default, parameter_function) VALUES('22', 'block_style', 'Boolean', 'TRUE', '');
INSERT INTO mx_table_parameter (function_id, parameter_name, parameter_type, parameter_default, parameter_function) VALUES('22', 'title_style', 'Boolean', 'TRUE', '');
INSERT INTO mx_table_parameter (function_id, parameter_name, parameter_type, parameter_default, parameter_function) VALUES('22', 'show_title', 'Boolean', 'TRUE', '');

-- ------------------------------------------------------------
--
-- Adding Multiple Horizontal Blocks from Flexible Blocks
--
INSERT INTO mx_table_function VALUES('19', '10', 'Split Blocks', 'Place blocks side by side in one column.', 'mx_multiple_blocks.php', '');
INSERT INTO mx_table_parameter (function_id, parameter_name, parameter_type, parameter_default, parameter_function) VALUES('19', 'block_ids', 'Function', '1,2,3', 'get_list_multiple( \"{parameter_id}[]\", BLOCK_TABLE, \'block_id\', \'block_title\', \"{parameter_value}\", TRUE)');
INSERT INTO mx_table_parameter (function_id, parameter_name, parameter_type, parameter_default, parameter_function) VALUES('19', 'block_sizes', 'Text', '20%,30%,*', '');
INSERT INTO mx_table_parameter (function_id, parameter_name, parameter_type, parameter_default, parameter_function) VALUES('19', 'space_between', 'Number', '4', '');

-- ------------------------------------------------------------
