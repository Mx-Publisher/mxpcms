#
# mxBB-Portal - MySQL Schema - Upgrade "2.7.8"
#
# $Id: mysql_schema_upgrade_to_2.7.8.sql,v 1.3 2010/10/16 04:06:19 orynider Exp $
#

# ------------------------------------------------------------
#
# New Fields in Table `mx_page`
ALTER TABLE mx_table_page MODIFY page_header varchar(255) default '';
ALTER TABLE mx_table_page MODIFY phpbb_stats tinyint(2) NOT NULL default '-1';
ALTER TABLE mx_table_page ADD page_footer varchar(255) default '' AFTER page_header;
ALTER TABLE mx_table_page ADD page_main_layout varchar(255) default '' AFTER page_header;
ALTER TABLE mx_table_page ADD navigation_block smallint(5) unsigned NOT NULL default '0' AFTER page_main_layout;
ALTER TABLE mx_table_page ADD default_style smallint(5) NOT NULL default '-1' AFTER auth_moderator_group;
ALTER TABLE mx_table_page ADD override_user_style smallint(2) NOT NULL default '-1' AFTER default_style;
# Whats the Field Drop syntax?????????????????????????????
#ALTER TABLE mx_table_page DELETE page_graph_border;

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#
ALTER TABLE mx_table_portal ADD overall_header varchar(255) default 'overall_header.tpl';
ALTER TABLE mx_table_portal ADD overall_footer varchar(255) default 'overall_footer.tpl' AFTER overall_header;
ALTER TABLE mx_table_portal ADD navigation_block smallint(5) unsigned NOT NULL default '0';
ALTER TABLE mx_table_portal ADD main_layout varchar(255) default 'mx_main_layout.tpl' AFTER overall_header;
ALTER TABLE mx_table_portal ADD default_admin_style smallint(5) NOT NULL default '-1' AFTER portal_version;
ALTER TABLE mx_table_portal ADD default_style smallint(5) NOT NULL default '-1' AFTER default_admin_style;
ALTER TABLE mx_table_portal ADD override_user_style smallint(2) NOT NULL default '1' AFTER default_style;
ALTER TABLE mx_table_portal ADD portal_backend varchar(255) default 'phpbb2' AFTER mod_rewrite;
ALTER TABLE mx_table_portal ADD portal_status smallint(2) NOT NULL default '1' AFTER portal_backend;
ALTER TABLE mx_table_portal ADD disabled_message varchar(255) default 'We are currenty upgrading this site with latest mxBB software.' AFTER portal_status;
ALTER TABLE mx_table_portal ADD mod_rewrite smallint(2) NOT NULL DEFAULT '0';
# ------------------------------------------------------------

# ------------------------------------------------------------
#
# Changed Fields in Table `mx_menu_nav` (updated type)
#
ALTER TABLE mx_table_menu_nav MODIFY auth_view tinyint(2) NOT NULL default '0';
ALTER TABLE mx_table_menu_nav MODIFY auth_view_group smallint(5) NOT NULL default '0';
ALTER TABLE mx_table_menu_nav ADD menu_alt_icon varchar(255) default '' AFTER menu_icon;
ALTER TABLE mx_table_menu_nav ADD menu_alt_icon_hot varchar(255) default '' AFTER menu_alt_icon;

