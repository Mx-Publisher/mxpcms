#
# MX-Publisher - MySQL Schema - Upgrade "2.9.0"
#
# $Id: mysql_schema_upgrade_to_2.9.0.sql,v 1.2 2008/02/04 15:58:07 joasch Exp $
#

#
# Table structure for table 'mx_table_user_group'
#
CREATE TABLE mx_table_user_group (
   group_id mediumint(8) DEFAULT '0' NOT NULL,
   user_id mediumint(8) DEFAULT '0' NOT NULL,
   user_pending tinyint(1),
   KEY group_id (group_id),
   KEY user_id (user_id)
);

#
# Table structure for table 'mx_table_groups'
#
CREATE TABLE mx_table_groups (
   group_id mediumint(8) NOT NULL auto_increment,
   group_type tinyint(4) DEFAULT '1' NOT NULL,
   group_name varchar(40) NOT NULL,
   group_description varchar(255) NOT NULL,
   group_moderator mediumint(8) DEFAULT '0' NOT NULL,
   group_single_user tinyint(1) DEFAULT '1' NOT NULL,
   PRIMARY KEY (group_id),
   KEY group_single_user (group_single_user)
);

# --------------------------------------------------------
#
# Table structure for table 'mx_table_sessions'
#
# Note that if you\'re running 3.23.x you may want to make
# this table a type HEAP. This type of table is stored
# within system memory and therefore for big busy boards
# is likely to be noticeably faster than continually
# writing to disk ...
#
CREATE TABLE mx_table_sessions (
   session_id char(32) DEFAULT '' NOT NULL,
   session_user_id mediumint(8) DEFAULT '0' NOT NULL,
   session_start int(11) DEFAULT '0' NOT NULL,
   session_time int(11) DEFAULT '0' NOT NULL,
   session_ip char(8) DEFAULT '0' NOT NULL,
   session_page int(11) DEFAULT '0' NOT NULL,
   session_logged_in tinyint(1) DEFAULT '0' NOT NULL,
   session_admin tinyint(2) DEFAULT '0' NOT NULL,
   PRIMARY KEY (session_id),
   KEY session_user_id (session_user_id),
   KEY session_id_ip_user_id (session_id, session_ip, session_user_id)
);

# --------------------------------------------------------
#
# Table structure for table `mx_table_sessions_keys`
#
CREATE TABLE mx_table_sessions_keys (
  key_id varchar(32) DEFAULT '0' NOT NULL,
  user_id mediumint(8) DEFAULT '0' NOT NULL,
  last_ip varchar(8) DEFAULT '0' NOT NULL,
  last_login int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (key_id, user_id),
  KEY last_login (last_login)
);

# --------------------------------------------------------
#
# Table structure for table 'mx_table_users'
#
CREATE TABLE mx_table_users (
   user_id mediumint(8) NOT NULL,
   user_active tinyint(1) DEFAULT '1',
   username varchar(25) NOT NULL,
   user_password varchar(32) NOT NULL,
   user_session_time int(11) DEFAULT '0' NOT NULL,
   user_session_page smallint(5) DEFAULT '0' NOT NULL,
   user_lastvisit int(11) DEFAULT '0' NOT NULL,
   user_regdate int(11) DEFAULT '0' NOT NULL,
   user_level tinyint(4) DEFAULT '0',
#   user_posts mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
#   user_timezone decimal(5,2) DEFAULT '0' NOT NULL,
#   user_style tinyint(4),
#   user_lang varchar(255),
#   user_dateformat varchar(14) DEFAULT 'd M Y H:i' NOT NULL,
#   user_new_privmsg smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
#   user_unread_privmsg smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
#   user_last_privmsg int(11) DEFAULT '0' NOT NULL,
   user_login_tries smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
   user_last_login_try int(11) DEFAULT '0' NOT NULL,
#   user_emailtime int(11),
#   user_viewemail tinyint(1),
#   user_attachsig tinyint(1),
#   user_allowhtml tinyint(1) DEFAULT '1',
#   user_allowbbcode tinyint(1) DEFAULT '1',
#   user_allowsmile tinyint(1) DEFAULT '1',
#   user_allowavatar tinyint(1) DEFAULT '1' NOT NULL,
#   user_allow_pm tinyint(1) DEFAULT '1' NOT NULL,
#   user_allow_viewonline tinyint(1) DEFAULT '1' NOT NULL,
#   user_notify tinyint(1) DEFAULT '1' NOT NULL,
#   user_notify_pm tinyint(1) DEFAULT '0' NOT NULL,
#   user_popup_pm tinyint(1) DEFAULT '0' NOT NULL,
#   user_rank int(11) DEFAULT '0',
#   user_avatar varchar(100),
#   user_avatar_type tinyint(4) DEFAULT '0' NOT NULL,
   user_email varchar(255),
#   user_icq varchar(15),
#   user_website varchar(100),
#   user_from varchar(100),
#   user_sig text,
#   user_sig_bbcode_uid char(10),
#   user_aim varchar(255),
#   user_yim varchar(255),
#   user_msnm varchar(255),
#   user_occ varchar(100),
#   user_interests varchar(255),
#   user_actkey varchar(32),
#   user_newpasswd varchar(32),
   PRIMARY KEY (user_id),
   KEY user_session_time (user_session_time)
);

# -- Users
INSERT INTO mx_table_users (user_id, username, user_level, user_regdate, user_password, user_email, user_active) VALUES ( -1, 'Anonymous', 0, 0, '', '', 0);

# -- username: admin    password: admin (change this or remove it once everything is working!)
INSERT INTO mx_table_users (user_id, username, user_level, user_regdate, user_password, user_email, user_active) VALUES ( 2, 'Admin', 1, 0, '21232f297a57a5a743894a0e4a801fc3', 'admin@yourdomain.com', 1);

# -- Groups
INSERT INTO mx_table_groups (group_id, group_name, group_description, group_single_user) VALUES (1, 'Anonymous', 'Personal User', 1);
INSERT INTO mx_table_groups (group_id, group_name, group_description, group_single_user) VALUES (2, 'Admin', 'Personal User', 1);


# -- User -> Group
INSERT INTO mx_table_user_group (group_id, user_id, user_pending) VALUES (1, -1, 0);
INSERT INTO mx_table_user_group (group_id, user_id, user_pending) VALUES (2, 2, 0);

# ------------------------------------------------------------
#
# New Fields in Table `mx_portal`
#
ALTER TABLE mx_table_portal ADD portal_desc varchar(255) NOT NULL default 'A _little_ text to describe your site';
ALTER TABLE mx_table_portal ADD server_name varchar(255) NOT NULL default 'www.myserver.tld';
ALTER TABLE mx_table_portal ADD script_path varchar(255) NOT NULL default '/';
ALTER TABLE mx_table_portal ADD script_protocol varchar(255) NOT NULL default 'http://';
ALTER TABLE mx_table_portal ADD server_port varchar(255) NOT NULL default '80';
ALTER TABLE mx_table_portal ADD default_dateformat varchar(255) NOT NULL default 'D M d, Y g:i a';
ALTER TABLE mx_table_portal ADD board_timezone smallint(2) NOT NULL default '0';
ALTER TABLE mx_table_portal ADD gzip_compress smallint(2) unsigned NOT NULL default '0';

ALTER TABLE mx_table_portal ADD cookie_domain varchar(255) NOT NULL default '';
ALTER TABLE mx_table_portal ADD cookie_name varchar(255) NOT NULL default 'mxbb28x';
ALTER TABLE mx_table_portal ADD cookie_path varchar(255) NOT NULL default '/';
ALTER TABLE mx_table_portal ADD cookie_secure smallint(2) unsigned NOT NULL default '0';
ALTER TABLE mx_table_portal ADD session_length varchar(255) NOT NULL default '3600';
ALTER TABLE mx_table_portal ADD allow_autologin smallint(2) unsigned NOT NULL default '1';
ALTER TABLE mx_table_portal ADD max_autologin_time smallint(2) NOT NULL default '0';
ALTER TABLE mx_table_portal ADD max_login_attempts smallint(2) NOT NULL default '5';
ALTER TABLE mx_table_portal ADD login_reset_time varchar(255) NOT NULL default '30';

ALTER TABLE mx_table_portal ADD default_lang varchar(255) NOT NULL default 'english';
ALTER TABLE mx_table_portal ADD allow_html smallint(2) unsigned NOT NULL default '1';
ALTER TABLE mx_table_portal ADD allow_html_tags varchar(255) NOT NULL default 'b,i,u,pre';
ALTER TABLE mx_table_portal ADD allow_bbcode smallint(2) unsigned NOT NULL default '1';
ALTER TABLE mx_table_portal ADD allow_smilies smallint(2) unsigned NOT NULL default '1';
ALTER TABLE mx_table_portal ADD smilies_path varchar(255) NOT NULL default 'images/smiles';

ALTER TABLE mx_table_portal ADD board_email varchar(255) NOT NULL default 'youraddress@yourdomain.com';
ALTER TABLE mx_table_portal ADD board_email_sig varchar(255) NOT NULL default 'Thanks, the MX-Publisher Team';
ALTER TABLE mx_table_portal ADD smtp_delivery smallint(2) unsigned NOT NULL default '0';
ALTER TABLE mx_table_portal ADD smtp_host varchar(255) NOT NULL default '';
ALTER TABLE mx_table_portal ADD smtp_username varchar(255) NOT NULL default '';
ALTER TABLE mx_table_portal ADD smtp_password varchar(255) NOT NULL default '';
ALTER TABLE mx_table_portal ADD smtp_auth_method varchar(255) NOT NULL default '';

ALTER TABLE mx_table_portal ADD portal_startdate varchar(255) NOT NULL default '0';
ALTER TABLE mx_table_portal ADD rand_seed varchar(255) NOT NULL default '0';
ALTER TABLE mx_table_portal ADD record_online_users varchar(255) NOT NULL default '0';
ALTER TABLE mx_table_portal ADD record_online_date varchar(255) NOT NULL default '0';

ALTER TABLE mx_table_portal ADD portal_backend_path varchar(255) NOT NULL default '';

# Remove from mx_table_portal
# Help??
# ALTER TABLE mx_table_portal DELETE portal_url;
# ALTER TABLE mx_table_portal DELETE portal_phpbb_url;

