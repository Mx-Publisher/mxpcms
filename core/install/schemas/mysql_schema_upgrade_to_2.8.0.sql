#
# mxBB-Portal - MySQL Schema - Upgrade "2.8.0"
#
# $Id: mysql_schema_upgrade_to_2.8.0.sql,v 1.2 2009/01/24 16:47:53 orynider Exp $
#

# ------------------------------------------------------------
#
# New Fields in Table `mx_page`
ALTER TABLE mx_table_page ADD page_footer varchar(255) default '' AFTER page_header;
ALTER TABLE mx_table_page ADD default_style smallint(5) NOT NULL default '-1' AFTER auth_moderator_group;
ALTER TABLE mx_table_page ADD override_user_style smallint(2) NOT NULL default '-1' AFTER default_style;

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#
ALTER TABLE mx_table_portal ADD overall_footer varchar(255) default 'overall_footer.tpl' AFTER overall_header;
ALTER TABLE mx_table_portal ADD default_admin_style smallint(5) NOT NULL default '-1' AFTER portal_version;
ALTER TABLE mx_table_portal ADD default_style smallint(5) NOT NULL default '-1' AFTER default_admin_style;
ALTER TABLE mx_table_portal ADD override_user_style smallint(2) NOT NULL default '1' AFTER default_style;