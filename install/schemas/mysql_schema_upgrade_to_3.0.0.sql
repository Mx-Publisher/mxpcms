#
# MX-Publisher - MySQL Schema - Upgrade "3.0.0"
#
# $Id: mysql_schema_upgrade_to_3.0.0.sql,v 1.2 2012/01/23 03:51:59 orynider Exp $
#

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#

# ------------------------------------------------------------
#
# New Fields in Table `mx_parameter`
#
ALTER TABLE mx_table_parameter MODIFY parameter_default text default '';
