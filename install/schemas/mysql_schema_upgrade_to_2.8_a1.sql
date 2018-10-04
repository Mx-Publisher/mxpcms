#
# MX-Publisher - MySQL Schema - Upgrade "2.8 - a1"
#
# $Id: mysql_schema_upgrade_to_2.8_a1.sql,v 1.3 2008/02/04 15:58:07 joasch Exp $
#

# ------------------------------------------------------------
#
# Changed Fields in Table `mx_block` (update for new permissions)
#
ALTER TABLE mx_table_block MODIFY auth_view_group VARCHAR(255) NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block MODIFY auth_edit_group VARCHAR(255) NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block MODIFY auth_delete_group VARCHAR(255) NOT NULL DEFAULT '0';

# ------------------------------------------------------------
#
# New Fields in Table `mx_block`
#
ALTER TABLE mx_table_block ADD auth_moderator_group VARCHAR(255) NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block ADD show_title TINYINT(2) UNSIGNED NOT NULL DEFAULT '1';
ALTER TABLE mx_table_block ADD show_block TINYINT(2) UNSIGNED NOT NULL DEFAULT '1';
ALTER TABLE mx_table_block ADD show_stats TINYINT(2) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block ADD block_time VARCHAR(255) BINARY NOT NULL DEFAULT '';
ALTER TABLE mx_table_block ADD block_editor_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0';

# ------------------------------------------------------------
#
# New/Changed Fields in Table `mx_block_system_parameter` // Maybe this only works for mySQL
#
ALTER TABLE mx_table_block_system_parameter CHANGE bbcode_uid parameter_opt TEXT;
ALTER TABLE mx_table_block_system_parameter ADD sub_id INT(255) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block_system_parameter DROP INDEX block_id;
ALTER TABLE mx_table_block_system_parameter DROP INDEX parameter_id;
ALTER TABLE mx_table_block_system_parameter DROP PRIMARY KEY, ADD PRIMARY KEY (block_id, parameter_id, sub_id);

# ------------------------------------------------------------
#
# New Fields in Table `mx_page` (update for new permissions)
#
ALTER TABLE mx_table_page ADD page_desc varchar(255) default NULL AFTER page_name;
ALTER TABLE mx_table_page ADD auth_moderator_group varchar(255) NOT NULL default '0' AFTER auth_view_group;
ALTER TABLE mx_table_page ADD page_graph_border varchar(255) NOT NULL default '';

# ------------------------------------------------------------
#
# Changed Fields in Table `mx_page` (update for new permissions)
#
ALTER TABLE mx_table_page MODIFY auth_view_group VARCHAR(255) NOT NULL DEFAULT '0';

# ------------------------------------------------------------
#
# New Fields in Table `mx_table_menu_categories`
#
ALTER TABLE mx_table_menu_categories ADD cat_url smallint(5) unsigned default '0';
ALTER TABLE mx_table_menu_categories ADD cat_target tinyint(2) unsigned NOT NULL default '0';

# ------------------------------------------------------------
#
# New Fields in Table `mx_module`
#
ALTER TABLE mx_table_module ADD module_version varchar(255) default NULL;
ALTER TABLE mx_table_module ADD module_copy text default NULL;

# ------------------------------------------------------------
#
# Table structure for table `mx_wordlist`
#
CREATE TABLE mx_table_wordlist (
	word_text VARCHAR(50) BINARY NOT NULL DEFAULT '',
	word_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	word_common TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (word_text),
	KEY word_id (word_id)
);

# ------------------------------------------------------------
#
# Table structure for table `mx_search_results`
#
CREATE TABLE mx_table_search_results (
	search_id INT(11) UNSIGNED NOT NULL DEFAULT '0',
	session_id VARCHAR(32) NOT NULL DEFAULT '',
	search_array TEXT NOT NULL,
	PRIMARY KEY (search_id),
	KEY session_id (session_id)
);

# ------------------------------------------------------------
#
# Table structure for table `mx_wordmatch`
#
CREATE TABLE mx_table_wordmatch (
	block_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
	word_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
	title_match TINYINT(1) NOT NULL DEFAULT '0',
	KEY block_id (block_id),
	KEY word_id (word_id)
);

# ------------------------------------------------------------
#
# New Fields in Table `mx_parameter`
#
ALTER TABLE mx_table_parameter ADD parameter_order smallint(5) unsigned NOT NULL default '0';

#
# Delete Table `mx_parameter_option`
#

DROP TABLE IF EXISTS mx_table_parameter_option;

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#
ALTER TABLE mx_table_portal ADD portal_recached VARCHAR(255) BINARY NOT NULL DEFAULT '';
ALTER TABLE mx_table_portal ADD mx_use_cache smallint(5) unsigned NOT NULL default '1' AFTER top_phpbb_links;

#
# Table structure for table 'mx_table_page_templates'
#

DROP TABLE IF EXISTS mx_table_page_templates;
CREATE TABLE `mx_table_page_templates` (
  `page_template_id` smallint(3) unsigned NOT NULL auto_increment,
  `template_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`page_template_id`)
) TYPE=MyISAM;

#
# Dumping data for table 'mx_table_page_templates'
#
INSERT INTO mx_table_page_templates VALUES("1", "NONE");
INSERT INTO mx_table_page_templates VALUES("2", "Two-Columns left");
INSERT INTO mx_table_page_templates VALUES("3", "Two-Columns right");
INSERT INTO mx_table_page_templates VALUES("4", "Three-Columns");

#
# Table structure for table 'mx_table_column_templates'
#

DROP TABLE IF EXISTS mx_table_column_templates;
CREATE TABLE `mx_table_column_templates` (
  `column_template_id` smallint(5) unsigned NOT NULL auto_increment,
  `column_title` varchar(100) default '0',
  `column_order` smallint(5) unsigned NOT NULL default '0',
  `column_size` varchar(5) default '0',
  `page_template_id` smallint(5) NOT NULL default '0',
  PRIMARY KEY  (`column_template_id`),
  KEY `cat_order` (`column_order`)
) TYPE=MyISAM;



#
# Dumping data for table 'mx_table_column_templates'
#
INSERT INTO mx_table_column_templates VALUES("1", "Left", "40", "200", "2");
INSERT INTO mx_table_column_templates VALUES("2", "Main", "50", "100%", "2");
INSERT INTO mx_table_column_templates VALUES("3", "Main", "10", "100%", "3");
INSERT INTO mx_table_column_templates VALUES("4", "Right", "20", "200", "3");
INSERT INTO mx_table_column_templates VALUES("5", "Left", "10", "180", "4");
INSERT INTO mx_table_column_templates VALUES("6", "Middle", "20", "100%", "4");
INSERT INTO mx_table_column_templates VALUES("7", "Right", "30", "180", "4");

#
# Some fixes related to the navigation menu block being modulized
#
SET module 		= SELECT MAX(module_id)	AS next_id FROM mx_table_module;

SET module.next_id = module.next_id + 1;
INSERT INTO mx_table_module VALUES('{module.next_id}', "Navigation Menu", "modules/mx_navmenu/", "mxBB Navigation Module", "0", NULL, "mzBB Core Module");

SET function = SELECT * FROM mx_table_function WHERE function_file = 'mx_menu_nav.php';

UPDATE mx_table_function
	SET module_id  = '{module.next_id}',
		function_name = 'Navigation Menu',
		function_desc = 'This is the function for Navigation Menu Blocks',
		function_admin = ''
	WHERE function_id = '{function.function_id}';

#
# Updating the TextBlocks
#
SET function = SELECT * FROM mx_table_function WHERE function_file = 'mx_textblock_bbcode.php';

UPDATE mx_table_function
	SET function_name = 'TextBlock (phpBB)',
		function_desc = 'BBcodes, html and smilies - defined by phpBB config',
		function_admin = ''
	WHERE function_id = '{function.function_id}';

SET function = SELECT * FROM mx_table_function WHERE function_file = 'mx_textblock_html.php';

UPDATE mx_table_function
	SET function_name = 'TextBlock (Html/wysiwyg)',
		function_desc = 'Plain html textblock, or featuring a wysiwyg editor',
		function_admin = ''
	WHERE function_id = '{function.function_id}';

SET function = SELECT * FROM mx_table_function WHERE function_file = 'mx_textblock_multi.php';

UPDATE mx_table_function
	SET function_name = 'TextBlock (Customized)',
		function_desc = 'Textblock, featuring block defined settings',
		function_admin = ''
	WHERE function_id = '{function.function_id}';

#
# Finally, all core blocks have been moved to the modules/mx_coreblocks folder
#
SET module = SELECT * FROM mx_table_module WHERE module_path = './';

UPDATE mx_table_module
	SET module_name = 'Core Blocks',
	 	module_desc = 'mxBB Core (standard) Module',
	 	module_path = 'modules/mx_coreblocks/',
	 	module_include_admin = '0'
	WHERE module_id = '{module.module_id}';

#
# Minor mistake for the textblocks
#
SET module = SELECT * FROM mx_table_module WHERE module_path = 'modules/mx_textblocks/';

UPDATE mx_table_module
	SET	module_include_admin = '0'
	WHERE module_id = '{module.module_id}';
