#
# MX-Publisher - MySQL Schema - Upgrade "2.8.0 - b3"
#
# $Id: mysql_schema_upgrade_to_2.8_b3.sql,v 1.8 2014/05/18 06:24:35 orynider Exp $
#

#
# All phpBB2 blocks are moved to a new mx_phpbb2blocks module
#

#
# First rename the mx_last_msg -> mx_phpbb2blocks
#
SET module = SELECT * FROM mx_table_module WHERE module_path = 'modules/mx_last_msg/';

UPDATE mx_table_module
	SET module_name  = 'phpBB2 blocks',
	 	module_path  = 'modules/mx_phpbb2blocks/',
	 	module_desc  = 'phpBB2 blocks Module',
	 	module_include_admin  = '0',
	 	module_version  = 'mxBB Core Module',
	 	module_copy  = 'Original mxBB <i>phpBB2 Blocks</i> module by <a href=\"http://mxpcms.sourceforge.net\" target=\"_blank\"> The MX-Publisher Development Team</a>'
	WHERE module_id = '{module.module_id}';

#
# Now we have a module id...proceed...
#

#
# Move Last Message block (not really necessary ;)
#
SET function = SELECT * FROM mx_table_function WHERE function_file = 'mx_last_msg.php';

UPDATE mx_table_function
	SET module_id  = '{module.module_id}'
	WHERE function_id = '{function.function_id}';

#
# Move Statistics block
#
SET function = SELECT * FROM mx_table_function WHERE function_file = 'mx_statistics.php';

UPDATE mx_table_function
	SET module_id  = '{module.module_id}'
	WHERE function_id = '{function.function_id}';

#
# Move Announcement block
#
SET function = SELECT * FROM mx_table_function WHERE function_file = 'mx_announce.php';

UPDATE mx_table_function
	SET module_id  = '{module.module_id}'
	WHERE function_id = '{function.function_id}';

#
# Move Polls block
#
SET function = SELECT * FROM mx_table_function WHERE function_file = 'mx_poll.php';

UPDATE mx_table_function
	SET module_id  = '{module.module_id}'
	WHERE function_id = '{function.function_id}';

#
# Move Forum block
#
SET function = SELECT * FROM mx_table_function WHERE function_file = 'mx_forum.php';

UPDATE mx_table_function
	SET module_id  = '{module.module_id}'
	WHERE function_id = '{function.function_id}';

#
# Remove old mx_statistics
#
DELETE FROM mx_table_module WHERE module_path = 'modules/mx_statistics/';

# ------------------------------------------------------------
#
# New Fields in Table `mx_page`
ALTER TABLE mx_table_page ADD page_main_layout varchar(255) default '' AFTER page_header;
ALTER TABLE mx_table_page MODIFY page_header varchar(255) default '';
ALTER TABLE mx_table_page MODIFY phpbb_stats tinyint(2) NOT NULL default '-1';
# Whats the Field Drop syntax?????????????????????????????
#ALTER TABLE mx_table_page DELETE page_graph_border;

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#
ALTER TABLE mx_table_portal ADD overall_header varchar(255) default 'overall_header.tpl';
ALTER TABLE mx_table_portal ADD navigation_block smallint(5) unsigned NOT NULL default '0';
ALTER TABLE mx_table_portal ADD main_layout varchar(255) default 'mx_main_layout.tpl' AFTER overall_header;

# ------------------------------------------------------------
#
# Updated Fields from Table `mx_page`
ALTER TABLE mx_table_page ADD navigation_block smallint(5) unsigned NOT NULL default '0' AFTER page_main_layout;
