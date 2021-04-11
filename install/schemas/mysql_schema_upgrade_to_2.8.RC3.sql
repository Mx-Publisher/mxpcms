#
# mxBB-Portal - MySQL Schema - Upgrade "2.8 - RC3"
#
# $Id: mysql_schema_upgrade_to_2.8.RC3.sql,v 1.1 2005/03/06 01:18:56 jonohlsson Exp $
#

# ------------------------------------------------------------
#
# New Fields in Table `mx_module`
#
ALTER TABLE mx_table_module ADD module_version varchar(255) default NULL;
ALTER TABLE mx_table_module ADD module_copy text default NULL;

# ------------------------------------------------------------

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#
ALTER TABLE mx_table_portal ADD mx_use_cache smallint(5) unsigned NOT NULL default '1';

# ------------------------------------------------------------
