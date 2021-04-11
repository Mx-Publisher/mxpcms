#
# mxBB-Portal - MySQL Schema - Upgrade "2.7.0"
#
# $Id: mysql_schema_upgrade_to_2.7.0.sql,v 1.1 2005/03/06 01:18:56 jonohlsson Exp $
#

# ------------------------------------------------------------
#
# Convert old Modules to Blocks
#
INSERT INTO mx_table_block_system_parameter (block_id, parameter_id, parameter_value) SELECT 1, 15, welcome_text from mx_table_welcome_msg;
INSERT INTO mx_table_block_system_parameter (block_id, parameter_id, parameter_value) SELECT 5, 13, poll_topic_id  FROM mx_table_config_poll;
INSERT INTO mx_table_block_system_parameter (block_id, parameter_id, parameter_value) SELECT 16, 17, last_msg_number FROM mx_table_config_last_msg;
INSERT INTO mx_table_block_system_parameter (block_id, parameter_id, parameter_value) SELECT 16, 18, last_msg_display_date FROM mx_table_config_last_msg;
INSERT INTO mx_table_block_system_parameter (block_id, parameter_id, parameter_value) SELECT 16, 19, last_msg_length FROM mx_table_config_last_msg;
INSERT INTO mx_table_block_system_parameter (block_id, parameter_id, parameter_value) SELECT 16, 20, last_msg_target FROM mx_table_config_last_msg;
INSERT INTO mx_table_block_system_parameter (block_id, parameter_id, parameter_value) SELECT 16, 21, last_msg_align FROM mx_table_config_last_msg;
INSERT INTO mx_table_block_system_parameter (block_id, parameter_id, parameter_value) SELECT 16, 22, last_msg_display_forum FROM mx_table_config_last_msg;
INSERT INTO mx_table_block_system_parameter (block_id, parameter_id, parameter_value) SELECT 10, 23, news_xml_file FROM mx_table_config_news;
INSERT INTO mx_table_block_system_parameter (block_id, parameter_id, parameter_value) SELECT 10, 24, news_folder FROM mx_table_config_news;

DROP TABLE IF EXISTS mx_table_config_ads;
DROP TABLE IF EXISTS mx_table_config_announcement;
DROP TABLE IF EXISTS mx_table_config_last_msg;
DROP TABLE IF EXISTS mx_table_config_news;
DROP TABLE IF EXISTS mx_table_config_poll;
DROP TABLE IF EXISTS mx_table_welcome_msg;


# ------------------------------------------------------------
