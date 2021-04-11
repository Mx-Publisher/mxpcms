#
# mxBB-Portal - MySQL Schema - Upgrade "2.8 - RC1"
#
# $Id: mysql_schema_upgrade_to_2.8.RC1.sql,v 1.1 2005/03/06 01:18:56 jonohlsson Exp $
#

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
# New Fields in Table `mx_block_system_parameter`
#
ALTER TABLE mx_table_block_system_parameter ADD sub_id INT(255) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block_system_parameter DROP PRIMARY KEY, ADD PRIMARY KEY (block_id, parameter_id, sub_id);

# ------------------------------------------------------------
#
# New Fields in Table `mx_page`
#
ALTER TABLE mx_table_page ADD page_desc VARCHAR(255) DEFAULT NULL AFTER page_name;
ALTER TABLE mx_table_page ADD page_icon VARCHAR(255) DEFAULT NULL AFTER page_desc;
ALTER TABLE mx_table_page ADD page_graph_border VARCHAR(255) NOT NULL DEFAULT '' AFTER page_icon;
ALTER TABLE mx_table_page ADD auth_moderator_group VARCHAR(255) NOT NULL DEFAULT '0' AFTER auth_view_group;

# ------------------------------------------------------------
#
# Changed Fields in Tables `mx_block` & `mx_page` (update for new permissions)
#
ALTER TABLE mx_table_page MODIFY auth_view_group VARCHAR(255) NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block MODIFY auth_view_group VARCHAR(255) NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block MODIFY auth_edit_group VARCHAR(255) NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block MODIFY auth_delete_group VARCHAR(255) NOT NULL DEFAULT '0';

# ------------------------------------------------------------
#
# Table structure for table `mx_mx_wordlist`
#
CREATE TABLE mx_table_mx_wordlist (
	word_text VARCHAR(50) BINARY NOT NULL DEFAULT '',
	word_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	word_common TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (word_text),
	KEY word_id (word_id)
);

# ------------------------------------------------------------
#
# Table structure for table `mx_mx_search_results`
#
CREATE TABLE mx_table_mx_search_results (
	search_id INT(11) UNSIGNED NOT NULL DEFAULT '0',
	session_id VARCHAR(32) NOT NULL DEFAULT '',
	search_array TEXT NOT NULL,
	PRIMARY KEY (search_id),
	KEY session_id (session_id)
);

# ------------------------------------------------------------
#
# Table structure for table `mx_mx_wordmatch`
#
CREATE TABLE mx_table_mx_wordmatch (
	block_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
	word_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
	title_match TINYINT(1) NOT NULL DEFAULT '0',
	KEY block_id (block_id),
	KEY word_id (word_id)
);

# ------------------------------------------------------------
