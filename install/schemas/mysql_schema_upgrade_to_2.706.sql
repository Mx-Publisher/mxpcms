#
# mxBB-Portal - MySQL Schema - Upgrade "2.706"
#
# $Id: mysql_schema_upgrade_to_2.706.sql,v 1.1 2005/03/06 01:18:56 jonohlsson Exp $
#

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#
ALTER TABLE mx_table_portal ADD portal_version VARCHAR(255) DEFAULT '';
ALTER TABLE mx_table_portal ADD top_phpbb_links SMALLINT(5) UNSIGNED DEFAULT '1' NOT NULL;

# ------------------------------------------------------------
#
# New Fields in Table `mx_block`
#
ALTER TABLE mx_table_block ADD auth_view_group SMALLINT(5) NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block ADD auth_edit_group SMALLINT(5) NOT NULL DEFAULT '0';
ALTER TABLE mx_table_block ADD auth_delete_group SMALLINT(5) NOT NULL DEFAULT '0';

# ------------------------------------------------------------
#
# New Fields in Table `mx_page`
#
ALTER TABLE mx_table_page ADD auth_view_group SMALLINT(5) NOT NULL DEFAULT '0';

# ------------------------------------------------------------
#
# New Fields in Table `mx_menu_nav`
#
ALTER TABLE mx_table_menu_nav ADD page_id SMALLINT(5) UNSIGNED DEFAULT '0';
ALTER TABLE mx_table_menu_nav ADD auth_view_group SMALLINT(5) NOT NULL DEFAULT '0';

# ------------------------------------------------------------
#
# New Fields in Table `mx_menu_categories`
#
ALTER TABLE mx_table_menu_categories ADD cat_show TINYINT(1) UNSIGNED DEFAULT '1' NOT NULL;


# ------------------------------------------------------------
