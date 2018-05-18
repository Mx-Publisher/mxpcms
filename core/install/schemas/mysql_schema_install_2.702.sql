#
# mxBB-Portal - MySQL Schema - version 2.702
#
# $Id: mysql_schema_install_2.702.sql,v 1.3 2010/10/16 04:06:19 orynider Exp $
#

# --------------------------------------------------------

#
# Table structure for table `mx_block`
#

CREATE TABLE mx_table_block (
  block_id smallint(5) unsigned NOT NULL auto_increment,
  block_title varchar(150) default NULL,
  block_desc text,
  function_id smallint(5) unsigned default NULL,
  auth_view tinyint(2) NOT NULL default '0',
  auth_edit tinyint(2) default '0',
  auth_delete tinyint(2) default '0',
  PRIMARY KEY  (block_id)
);

#
# Dumping data for table `mx_block`
#

INSERT INTO mx_table_block VALUES (1, 'Welcome', '', 10, 0, 5, 0);
INSERT INTO mx_table_block VALUES (4, 'Navigation Menu', '', 30, 0, 5, 0);
INSERT INTO mx_table_block VALUES (5, 'Poll', '', 40, 0, 5, 0);
INSERT INTO mx_table_block VALUES (7, 'Language', '', 50, 99, 5, 0);
INSERT INTO mx_table_block VALUES (13, 'Login', NULL, 80, 99, 5, 0);
INSERT INTO mx_table_block VALUES (14, 'Theme', '', 90, 0, 5, 0);
INSERT INTO mx_table_block VALUES (16, 'Last Message', NULL, 170, 0, 0, 0);
INSERT INTO mx_table_block VALUES (21, 'Google', '', 100, 0, 0, 0);
INSERT INTO mx_table_block VALUES (18, 'Announcement', NULL, 110, 0, 0, 0);
INSERT INTO mx_table_block VALUES (19, 'Online', '', 120, 0, 0, 0);
INSERT INTO mx_table_block VALUES (24, 'Forum', '', 20, 0, 0, 0);
INSERT INTO mx_table_block VALUES (32, 'Statistics', '', 190, 0, 0, 0);

# --------------------------------------------------------

#
# Table structure for table `mx_block_system_parameter`
#

CREATE TABLE mx_table_block_system_parameter (
  block_id smallint(5) unsigned NOT NULL default '0',
  parameter_id smallint(5) unsigned NOT NULL auto_increment,
  parameter_value text,
  bbcode_uid varchar(10) default NULL,
  PRIMARY KEY  (block_id, parameter_id)
);

#
# Dumping data for table `mx_block_system_parameter`
#

INSERT INTO mx_table_block_system_parameter VALUES (1, 15, 'Welcome to the mx-publisher Portal!\r\n\r\nPlease visit www.mx-publisher.com for further information.\r\n\r\nThis Mx-Portal version is announced and documented [url=http://mxpcms.sourceforge.net/forum/viewforum.php?f=11] here[/url].', '10bec5b560');
INSERT INTO mx_table_block_system_parameter VALUES (5, 36, '', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (5, 13, '0', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (16, 17, '5', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (16, 18, 'TRUE', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (16, 19, '30', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (16, 20, '_self', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (16, 21, 'left', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (16, 22, 'TRUE', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (16, 37, '', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (16, 38, 'FALSE', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (16, 39, 'FALSE', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (16, 40, 'TRUE', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 1, '1', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 2, '999', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 3, 'TRUE', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 4, 'FALSE', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 5, 'FALSE', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 7, './images/news_02.gif', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 8, './images/globe7.gif', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 9, './images/globe7.gif', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 6, 'TRUE', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 10, './images/globe7.gif ', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 11, '', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (35, 15, 'Insert your text here', NULL);

# --------------------------------------------------------

#
# Table structure for table `mx_block_user_parameter`
#

CREATE TABLE mx_table_block_user_parameter (
  block_id smallint(5) unsigned NOT NULL default '0',
  parameter_id smallint(5) unsigned NOT NULL auto_increment,
  parameter_value text,
  PRIMARY KEY  (block_id, parameter_id)
);

#
# Dumping data for table `mx_block_user_parameter`
#


# --------------------------------------------------------

#
# Table structure for table `mx_column`
#

CREATE TABLE mx_table_column (
  column_id smallint(5) unsigned NOT NULL auto_increment,
  column_title varchar(100) default NULL,
  column_order smallint(5) unsigned NOT NULL default '0',
  bbcode_uid varchar(10) default NULL,
  column_size varchar(5) default '100%',
  page_id smallint(5) NOT NULL default '0',
  PRIMARY KEY  (column_id),
  KEY cat_order (column_order)
);

#
# Dumping data for table `mx_column`
#

INSERT INTO mx_table_column VALUES (1, 'Column 1', 10, NULL, '220', 1);
INSERT INTO mx_table_column VALUES (2, 'Column 2', 20, NULL, '100%', 1);
INSERT INTO mx_table_column VALUES (20, 'Menu', 10, NULL, '200', 2);
INSERT INTO mx_table_column VALUES (21, 'Forum', 20, NULL, '100%', 2);

# --------------------------------------------------------

#
# Table structure for table `mx_column_block`
#

CREATE TABLE mx_table_column_block (
  column_id smallint(5) NOT NULL default '0',
  block_id smallint(5) NOT NULL default '0',
  block_order smallint(5) NOT NULL default '0'
);

#
# Dumping data for table `mx_column_block`
#

INSERT INTO mx_table_column_block VALUES (1, 4, 10);
INSERT INTO mx_table_column_block VALUES (1, 16, 20);
INSERT INTO mx_table_column_block VALUES (1, 5, 30);
INSERT INTO mx_table_column_block VALUES (1, 13, 40);
INSERT INTO mx_table_column_block VALUES (1, 7, 50);
INSERT INTO mx_table_column_block VALUES (1, 14, 60);
INSERT INTO mx_table_column_block VALUES (2, 1, 10);
INSERT INTO mx_table_column_block VALUES (2, 18, 20);
INSERT INTO mx_table_column_block VALUES (2, 19, 30);
INSERT INTO mx_table_column_block VALUES (20, 4, 10);
INSERT INTO mx_table_column_block VALUES (20, 16, 20);
INSERT INTO mx_table_column_block VALUES (21, 24, 30);
INSERT INTO mx_table_column_block VALUES (21, 19, 40);

# --------------------------------------------------------

#
# Table structure for table `mx_function`
#

CREATE TABLE mx_table_function (
  function_id smallint(5) unsigned NOT NULL auto_increment,
  module_id smallint(5) unsigned NOT NULL default '0',
  function_name varchar(150) default NULL,
  function_desc text,
  function_file varchar(255) default NULL,
  function_admin varchar(255) default NULL,
  PRIMARY KEY  (function_id),
  KEY module_id (module_id)
);

#
# Dumping data for table `mx_function`
#

INSERT INTO mx_table_function VALUES (10, 10, 'Block', 'Block', 'mx_block.php', 'admin/admin_mx_block_edit.php');
INSERT INTO mx_table_function VALUES (20, 10, 'Forum', 'Forum', 'mx_forum.php', NULL);
INSERT INTO mx_table_function VALUES (30, 10, 'Menu Navigation', 'Menu Navigation', 'mx_menu_nav.php', 'admin/admin_mx_menu.php');
INSERT INTO mx_table_function VALUES (40, 10, 'Poll', 'Poll', 'mx_poll.php', NULL);
INSERT INTO mx_table_function VALUES (50, 10, 'Language', 'Language', 'mx_language.php', NULL);
INSERT INTO mx_table_function VALUES (70, 10, 'Block Html', 'Block Html', 'mx_block_html.php', NULL);
INSERT INTO mx_table_function VALUES (80, 10, 'Login', 'Login', 'mx_login.php', NULL);
INSERT INTO mx_table_function VALUES (90, 10, 'Theme', 'Theme', 'mx_theme.php', NULL);
INSERT INTO mx_table_function VALUES (100, 10, 'Google', 'Google', 'mx_google.php', NULL);
INSERT INTO mx_table_function VALUES (110, 10, 'Announcement', 'Announcement', 'mx_announce.php', NULL);
INSERT INTO mx_table_function VALUES (120, 10, 'Who is Online', 'Who is Online', 'mx_online.php', NULL);
INSERT INTO mx_table_function VALUES (170, 50, 'Last Message', 'Last Message', 'mx_last_msg.php', NULL);
INSERT INTO mx_table_function VALUES (190, 70, 'Statistics', 'Statistics Module', 'mx_statistics.php', NULL);

# --------------------------------------------------------

#
# Table structure for table `mx_menu_categories`
#

CREATE TABLE mx_table_menu_categories (
  block_id smallint(5) unsigned NOT NULL default '1',
  cat_id mediumint(8) unsigned NOT NULL auto_increment,
  cat_title varchar(100) default NULL,
  cat_order mediumint(8) unsigned NOT NULL default '0',
  bbcode_uid varchar(10) default NULL,
  cat_desc text,
  PRIMARY KEY  (cat_id),
  KEY cat_order (cat_order)
);

#
# Dumping data for table `mx_menu_categories`
#

INSERT INTO mx_table_menu_categories VALUES (4, 1, 'Main Menu', 20, NULL, NULL);

# --------------------------------------------------------

#
# Table structure for table `mx_menu_nav`
#

CREATE TABLE mx_table_menu_nav (
  menu_id smallint(5) unsigned NOT NULL auto_increment,
  cat_id mediumint(8) unsigned NOT NULL default '0',
  menu_name varchar(150) default NULL,
  menu_desc text,
  menu_links varchar(255) default NULL,
  auth_view tinyint(2) NOT NULL default '0',
  menu_order smallint(5) unsigned default '0',
  bbcode_uid varchar(10) default NULL,
  menu_icon varchar(255) default NULL,
  function_id smallint(5) unsigned default '0',
  block_id smallint(8) NOT NULL default '0',
  PRIMARY KEY  (menu_id),
  KEY cat_id (cat_id)
);

#
# Dumping data for table `mx_menu_nav`
#

INSERT INTO mx_table_menu_nav VALUES (1, 1, 'Home Page', 'Home Page', 'index.php', 0, 10, 'bc5d5e65eb', 'icon_home.gif', 0, 0);
INSERT INTO mx_table_menu_nav VALUES (2, 1, 'Forum', 'Forum', 'index.php?page=2', 0, 20, '1a7e19f246', 'icon_help.gif', 0, 0);
INSERT INTO mx_table_menu_nav VALUES (6, 1, 'Statistics', 'Module Statistics', '', 0, 60, 'e16b0fbb51', 'icon_poll.gif', 190, 0);

# --------------------------------------------------------

#
# Table structure for table `mx_module`
#

CREATE TABLE mx_table_module (
  module_id smallint(5) unsigned NOT NULL auto_increment,
  module_name varchar(150) default NULL,
  module_path varchar(255) default NULL,
  module_desc text,
  module_include_admin char(1) default '0',
  PRIMARY KEY  (module_id)
);

#
# Dumping data for table `mx_module`
#

INSERT INTO mx_table_module VALUES (10, 'Standard', './', 'Module standard', '');
INSERT INTO mx_table_module VALUES (50, 'Last Message', 'modules/mx_last_msg/', 'Last Message Module', '0');
INSERT INTO mx_table_module VALUES (70, 'Statistics', 'modules/mx_statistics/', 'Statistics Modules', '0');

# --------------------------------------------------------

#
# Table structure for table `mx_page`
#

CREATE TABLE mx_table_page (
  page_id smallint(5) NOT NULL auto_increment,
  page_name varchar(255) default NULL,
  page_icon varchar(255) default NULL,
  PRIMARY KEY  (page_id)
);

#
# Dumping data for table `mx_page`
#

INSERT INTO mx_table_page VALUES (1, 'Portal', 'home.jpg');
INSERT INTO mx_table_page VALUES (2, 'Forum', 'forum.jpg');

# --------------------------------------------------------

#
# Table structure for table `mx_parameter`
#

CREATE TABLE mx_table_parameter (
  parameter_id smallint(5) unsigned NOT NULL auto_increment,
  function_id smallint(5) unsigned NOT NULL default '0',
  parameter_name varchar(150) default NULL,
  parameter_type varchar(30) default NULL,
  parameter_default varchar(150) default NULL,
  parameter_function varchar(255) default NULL,
  PRIMARY KEY  (parameter_id)
);

#
# Dumping data for table `mx_parameter`
#

INSERT INTO mx_table_parameter VALUES (1, 110, 'announce_nbr_display', 'Number', '1', NULL);
INSERT INTO mx_table_parameter VALUES (2, 110, 'announce_nbr_days', 'Number', '14', NULL);
INSERT INTO mx_table_parameter VALUES (3, 110, 'announce_display', 'Boolean', 'TRUE', NULL);
INSERT INTO mx_table_parameter VALUES (4, 110, 'announce_display_sticky', 'Boolean', 'TRUE', NULL);
INSERT INTO mx_table_parameter VALUES (5, 110, 'announce_display_normal', 'Boolean', 'FALSE', NULL);
INSERT INTO mx_table_parameter VALUES (7, 110, 'announce_img', 'Text', './images/globe7.gif', NULL);
INSERT INTO mx_table_parameter VALUES (8, 110, 'announce_img_sticky', 'Text', './images/globe7.gif', NULL);
INSERT INTO mx_table_parameter VALUES (9, 110, 'announce_img_normal', 'Text', './images/globe7.gif', NULL);
INSERT INTO mx_table_parameter VALUES (6, 110, 'announce_display_global', 'Boolean', 'TRUE', NULL);
INSERT INTO mx_table_parameter VALUES (10, 110, 'announce_img_global', 'Text', './images/globe7.gif', NULL);
INSERT INTO mx_table_parameter VALUES (11, 110, 'announce_forum', 'Function', NULL, 'get_list_multiple(&quot;{parameter_id}[]&quot;, FORUMS_TABLE, \'forum_id\', \'forum_name\', &quot;{parameter_value}&quot;, TRUE)');
INSERT INTO mx_table_parameter VALUES (13, 40, 'Poll_Display', 'Function', '0', 'poll_select( {parameter_value}, &quot;{parameter_id}&quot; )');
INSERT INTO mx_table_parameter VALUES (15, 10, 'Text', 'BBText', 'Insert your text here', NULL);
INSERT INTO mx_table_parameter VALUES (16, 70, 'Html', 'Html', 'Entre your Html code here', NULL);
INSERT INTO mx_table_parameter VALUES (17, 170, 'Last_Msg_Number_Title', 'Number', '15', NULL);
INSERT INTO mx_table_parameter VALUES (18, 170, 'Last_Msg_Display_Date', 'Boolean', 'TRUE', NULL);
INSERT INTO mx_table_parameter VALUES (19, 170, 'Last_Msg_Title_Length', 'Number', '30', NULL);
INSERT INTO mx_table_parameter VALUES (20, 170, 'Last_Msg_Target', 'Values', '_blank', NULL);
INSERT INTO mx_table_parameter VALUES (21, 170, 'Last_Msg_Align', 'Values', 'left', NULL);
INSERT INTO mx_table_parameter VALUES (22, 170, 'Last_Msg_Display_Forum', 'Boolean', 'TRUE', NULL);
INSERT INTO mx_table_parameter VALUES (37, 170, 'Last_Msg_forum', 'Function', '', 'get_list_multiple(&quot;{parameter_id}[]&quot;, FORUMS_TABLE, \'forum_id\', \'forum_name\', &quot;{parameter_value}&quot;, TRUE)');
INSERT INTO mx_table_parameter VALUES (38, 170, 'Last_Msg_Display_Last_Author', 'Boolean', 'FALSE', '');
INSERT INTO mx_table_parameter VALUES (39, 170, 'Last_Msg_Display_Author', 'Boolean', 'FALSE', '');
INSERT INTO mx_table_parameter VALUES (40, 170, 'Last_Msg_Display_Icon_View', 'Boolean', 'FALSE', '');
INSERT INTO mx_table_parameter VALUES (36, 40, 'poll_forum', 'Function', '', 'get_list_multiple(&quot;{parameter_id}[]&quot;, FORUMS_TABLE, \'forum_id\', \'forum_name\', &quot;{parameter_value}&quot;, TRUE)');

# --------------------------------------------------------

#
# Table structure for table `mx_parameter_option`
#

CREATE TABLE mx_table_parameter_option (
  option_id smallint(5) unsigned NOT NULL auto_increment,
  parameter_id smallint(5) unsigned NOT NULL default '0',
  option_code varchar(150) default NULL,
  option_desc text,
  PRIMARY KEY  (option_id)
);

#
# Dumping data for table `mx_parameter_option`
#

INSERT INTO mx_table_parameter_option VALUES (1, 14, '0', 'Sunday');
INSERT INTO mx_table_parameter_option VALUES (2, 14, '1', 'Monday');
INSERT INTO mx_table_parameter_option VALUES (3, 21, 'left', 'left ');
INSERT INTO mx_table_parameter_option VALUES (4, 21, 'right', 'right');
INSERT INTO mx_table_parameter_option VALUES (5, 21, 'center', 'center');
INSERT INTO mx_table_parameter_option VALUES (6, 20, '_blank', 'New Window');
INSERT INTO mx_table_parameter_option VALUES (7, 20, '_self', 'Current Window');

# --------------------------------------------------------

#
# Table structure for table `mx_portal`
#

CREATE TABLE mx_table_portal (
  portal_id smallint(5) unsigned NOT NULL auto_increment,
  portal_name varchar(150) default NULL,
  portal_phpbb_url varchar(255) default 'http://www.phpbb.com/phpBB/',
  portal_url varchar(255) default NULL,
  PRIMARY KEY  (portal_id)
);
