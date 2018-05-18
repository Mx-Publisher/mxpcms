#
# mxBB-Portal - MySQL Schema - Upgrade "2.8.0"
#
# $Id: mysql_schema_upgrade_to_2.8.1.sql,v 1.2 2009/01/24 16:47:53 orynider Exp $
#

# ------------------------------------------------------------
#
# New Fields in Table `mx_table_menu_nav`
ALTER TABLE mx_table_menu_nav ADD menu_alt_icon varchar(255) default '' AFTER menu_icon;
ALTER TABLE mx_table_menu_nav ADD menu_alt_icon_hot varchar(255) default '' AFTER menu_alt_icon;

# ------------------------------------------------------------
#
# New Fields in Table `mx_table_page`
ALTER TABLE mx_table_page ADD page_alt_icon varchar(255) default '' AFTER page_icon;

ALTER TABLE mx_table_page ADD menu_icon varchar(255) default '' AFTER page_alt_icon;
ALTER TABLE mx_table_page ADD menu_alt_icon varchar(255) default '' AFTER menu_icon;
ALTER TABLE mx_table_page ADD menu_alt_icon_hot varchar(255) default '' AFTER menu_alt_icon;
ALTER TABLE mx_table_page ADD menu_active tinyint(2) default '1' AFTER menu_alt_icon_hot;

ALTER TABLE mx_table_page ADD page_parent int(50) default '0' AFTER page_desc;
ALTER TABLE mx_table_page ADD parents_data text NOT NULL AFTER page_parent;

ALTER TABLE mx_table_page ADD page_order smallint(5) default '0' AFTER parents_data;

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#
ALTER TABLE mx_table_portal ADD portal_backend varchar(255) default 'phpbb2' AFTER mod_rewrite;
ALTER TABLE mx_table_portal ADD portal_status smallint(2) NOT NULL default '1' AFTER portal_backend;
ALTER TABLE mx_table_portal ADD disabled_message varchar(255) default 'We are currenty upgrading this site with latest mxBB software.' AFTER portal_status;
