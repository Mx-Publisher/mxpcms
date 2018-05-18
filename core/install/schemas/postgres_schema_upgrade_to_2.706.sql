--
-- mxBB-Portal - PostgreSQL Schema - Upgrade "2.706"
--
-- $Id: postgres_schema_upgrade_to_2.706.sql,v 1.1 2005/05/06 06:47:59 jonohlsson Exp $
--

-- ------------------------------------------------------------
--
-- New Fields in Table `mx_portal`
--
ALTER TABLE mx_table_portal ADD portal_version VARCHAR(255) DEFAULT NULL;
ALTER TABLE mx_table_portal ADD top_phpbb_links smallint UNSIGNED DEFAULT '1' NOT NULL;

-- ------------------------------------------------------------
--
-- New Fields in Table `mx_block`
--
ALTER TABLE mx_table_block ADD auth_view_group smallint NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block ADD auth_edit_group smallint NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block ADD auth_delete_group smallint NOT NULL DEFAULT '0';

-- ------------------------------------------------------------
--
-- New Fields in Table `mx_page`
--
ALTER TABLE mx_table_page ADD auth_view_group smallint NOT NULL DEFAULT '0';

-- ------------------------------------------------------------
--
-- New Fields in Table `mx_menu_nav`
--
ALTER TABLE mx_table_menu_nav ADD page_id smallint UNSIGNED DEFAULT '0';
ALTER TABLE mx_table_menu_nav ADD auth_view_group smallint NOT NULL DEFAULT '0';

-- ------------------------------------------------------------
--
-- New Fields in Table `mx_menu_categories`
--
ALTER TABLE mx_table_menu_categories ADD cat_show smallint UNSIGNED DEFAULT '1' NOT NULL;

-- ------------------------------------------------------------
