#
# mxBB-Portal - MySQL Schema - Upgrade "2.704"
#
# $Id: mysql_schema_upgrade_to_2.704.sql,v 1.1 2005/03/06 01:18:56 jonohlsson Exp $
#

# ------------------------------------------------------------
#
# New Fields in Table `mx_page`
#
ALTER TABLE mx_table_page ADD auth_view TINYINT(2) NOT NULL DEFAULT '0';


# ------------------------------------------------------------
