#
# mxBB-Portal - MySQL Schema - Upgrade "2.8 - RC2"
#
# $Id: mysql_schema_upgrade_to_2.8.RC2.sql,v 1.2 2005/03/07 14:19:42 markus_petrux Exp $
#

# ------------------------------------------------------------
#
# Fix table names related to the new Portal search feature.
#

#
# Fix Table `mx_wordlist`
#
CREATE TABLE mx_table_wordlist (
	word_text VARCHAR(50) BINARY NOT NULL DEFAULT '',
	word_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	word_common TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (word_text),
	KEY word_id (word_id)
);
INSERT INTO mx_table_wordlist SELECT * FROM mx_table_mx_wordlist;
DROP TABLE mx_table_mx_wordlist;

#
# Fix Table `mx_search_results`
#
CREATE TABLE mx_table_search_results (
	search_id INT(11) UNSIGNED NOT NULL DEFAULT '0',
	session_id VARCHAR(32) NOT NULL DEFAULT '',
	search_array TEXT NOT NULL,
	PRIMARY KEY (search_id),
	KEY session_id (session_id)
);
INSERT INTO mx_table_search_results SELECT * FROM mx_table_mx_search_results;
DROP TABLE mx_table_mx_search_results;

#
# Fix Table `mx_wordmatch`
#
CREATE TABLE mx_table_wordmatch (
	block_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
	word_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
	title_match TINYINT(1) NOT NULL DEFAULT '0',
	KEY block_id (block_id),
	KEY word_id (word_id)
);
INSERT INTO mx_table_wordmatch SELECT * FROM mx_table_mx_wordmatch;
DROP TABLE mx_table_mx_wordmatch;


# ------------------------------------------------------------
