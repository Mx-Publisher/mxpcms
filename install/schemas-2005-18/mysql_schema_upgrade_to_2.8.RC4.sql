#
# mxBB-Portal - MySQL Schema - Upgrade "2.8 - RC4"
#
# $Id: mysql_schema_upgrade_to_2.8.RC4.sql,v 1.1 2005/03/09 22:46:37 jonohlsson Exp $
#

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#
ALTER TABLE mx_table_portal ADD portal_recached VARCHAR(255) BINARY NOT NULL DEFAULT '';

# ------------------------------------------------------------
