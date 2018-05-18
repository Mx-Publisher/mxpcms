--
-- mxBB-Portal - PostgreSQL Schema - Upgrade "2.705"
--
-- $Id: postgres_schema_upgrade_to_2.705.sql,v 1.1 2005/05/06 06:47:59 jonohlsson Exp $
--

-- ------------------------------------------------------------
--
-- Remove SERIAL attribute from field parameter_id
-- in Tables `mx_block_system_parameter` and `mx_block_user_parameter`
--
-- NOTE 1: This change was really implemented in 2.704
-- NOTE 2: Not all DB managers support changing column attributes.
--
CREATE TABLE mx_table_block_system_parameter_tmp (
	block_id smallint unsigned NOT NULL default '0',
	parameter_id smallint unsigned NOT NULL default '0',
	parameter_value text,
	bbcode_uid varchar(10) default NULL,
	PRIMARY KEY (block_id, parameter_id)
);
INSERT INTO mx_table_block_system_parameter_tmp SELECT * FROM mx_table_block_system_parameter;
DROP TABLE mx_table_block_system_parameter;
CREATE TABLE mx_table_block_system_parameter (
	block_id smallint unsigned NOT NULL default '0',
	parameter_id smallint unsigned NOT NULL default '0',
	parameter_value text,
	bbcode_uid varchar(10) default NULL,
	PRIMARY KEY (block_id, parameter_id)
);
INSERT INTO mx_table_block_system_parameter SELECT * FROM mx_table_block_system_parameter_tmp;
DROP TABLE mx_table_block_system_parameter_tmp;

CREATE TABLE mx_table_block_user_parameter_tmp (
	block_id smallint unsigned NOT NULL default '0',
	parameter_id smallint unsigned NOT NULL default '0',
	parameter_value text,
	PRIMARY KEY (block_id, parameter_id)
);
INSERT INTO mx_table_block_user_parameter_tmp SELECT * FROM mx_table_block_user_parameter;
DROP TABLE mx_table_block_user_parameter;
CREATE TABLE mx_table_block_user_parameter (
	block_id smallint unsigned NOT NULL default '0',
	parameter_id smallint unsigned NOT NULL default '0',
	parameter_value text,
	PRIMARY KEY (block_id, parameter_id)
);
INSERT INTO mx_table_block_user_parameter SELECT * FROM mx_table_block_user_parameter_tmp;
DROP TABLE mx_table_block_user_parameter_tmp;

-- ------------------------------------------------------------
--
-- New Fields in Table `mx_page`
--
ALTER TABLE mx_table_page ADD auth_view smallint NOT NULL DEFAULT '0';

-- ------------------------------------------------------------
--
-- Changed images affecting default page icons
--
UPDATE mx_table_page SET page_icon = 'icon_home.gif' WHERE page_icon = 'home.jpg';
UPDATE mx_table_page SET page_icon = 'icon_forum.gif' WHERE page_icon = 'forum.jpg';

-- ------------------------------------------------------------
--
-- Changed images affecting default menu entries
--
UPDATE mx_table_menu_nav SET menu_icon = 'icon_forum.gif' WHERE menu_icon = 'icon_help.gif';
UPDATE mx_table_menu_nav SET menu_icon = 'icon_stat.gif' WHERE menu_icon = 'icon_poll.gif';

-- ------------------------------------------------------------
--
-- Changed images affecting some block parameters
--
UPDATE mx_table_block_system_parameter SET parameter_value = 'thumb_news.gif' WHERE block_id = 18 AND parameter_value = './images/news_02.gif';
UPDATE mx_table_block_system_parameter SET parameter_value = 'thumb_globe.gif' WHERE block_id = 18 AND parameter_value = './images/globe7.gif';

UPDATE mx_table_parameter SET parameter_default = 'thumb_globe.gif' WHERE function_id = 110 AND parameter_default = './images/globe7.gif';

-- ------------------------------------------------------------
--
-- Changed default values on some parameters of the LastMsgPost block
--
UPDATE mx_table_parameter SET parameter_default = 'TRUE' WHERE parameter_name = 'Last_Msg_Display_Last_Author';
UPDATE mx_table_parameter SET parameter_default = 'TRUE' WHERE parameter_name = 'Last_Msg_Display_Icon_View';

-- ------------------------------------------------------------
