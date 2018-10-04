#
# MX-Publisher - MySQL Schema - Upgrade "2.8 - a2"
#
# $Id: mysql_schema_upgrade_to_2.8_a2.sql,v 1.5 2008/02/04 15:58:07 joasch Exp $
#

# ------------------------------------------------------------
#
# New Fields in Table `mx_page`
#
ALTER TABLE mx_table_page ADD ip_filter VARCHAR(255) NOT NULL DEFAULT '';

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#
ALTER TABLE mx_table_portal ADD mod_rewrite smallint(2) NOT NULL DEFAULT '0';

# ------------------------------------------------------------
#
# Changed Fields in Table `mx_block` (updated type)
#
ALTER TABLE mx_table_block MODIFY auth_view tinyint(2) NOT NULL default '0';
ALTER TABLE mx_table_block MODIFY auth_edit tinyint(2) NOT NULL default '0';
ALTER TABLE mx_table_block MODIFY auth_delete tinyint(2) NOT NULL default '0';

ALTER TABLE mx_table_block MODIFY auth_view_group varchar(255) NOT NULL default '0';
ALTER TABLE mx_table_block MODIFY auth_edit_group varchar(255) NOT NULL default '0';
ALTER TABLE mx_table_block MODIFY auth_delete_group varchar(255) NOT NULL default '0';
ALTER TABLE mx_table_block MODIFY auth_moderator_group varchar(255) NOT NULL default '0';

# ------------------------------------------------------------
#
# Changed Fields in Table `mx_page` (updated type)
#
ALTER TABLE mx_table_page MODIFY auth_view tinyint(2) NOT NULL default '0';
ALTER TABLE mx_table_page MODIFY auth_view_group varchar(255) NOT NULL default '0';
ALTER TABLE mx_table_page MODIFY auth_moderator_group varchar(255) NOT NULL default '0';
ALTER TABLE mx_table_page ADD phpbb_stats smallint(2) NOT NULL DEFAULT '-1';

# ------------------------------------------------------------
#
# Changed Fields in Table `mx_menu_nav` (updated type)
#
ALTER TABLE mx_table_menu_nav MODIFY auth_view tinyint(2) NOT NULL default '0';
ALTER TABLE mx_table_menu_nav MODIFY auth_view_group smallint(5) NOT NULL default '0';

# ------------------------------------------------------------
#
# New Fields in Table `mx_table_parameter`
#
ALTER TABLE mx_table_parameter ADD parameter_auth tinyint(2) NOT NULL default '0' AFTER parameter_function;
