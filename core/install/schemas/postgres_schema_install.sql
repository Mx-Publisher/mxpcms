--
-- mxBB-Portal - PostgreSQL Schema - version 2.7.5
--
-- $Id: postgres_schema_install.sql,v 1.2 2005/05/26 21:54:09 jonohlsson Exp $
--

-- --------------------------------------------------------

--
-- Table structure for table `mx_block`
--

DROP TABLE mx_table_block;
CREATE TABLE mx_table_block (
  block_id SERIAL,
  block_title varchar(150) default NULL,
  block_desc text,
  function_id int  default NULL,
  auth_view smallint NOT NULL default '0',
  auth_edit smallint default '0',
  auth_delete smallint default '0',
  auth_view_group smallint NOT NULL default '0',
  auth_edit_group smallint NOT NULL default '0',
  auth_delete_group smallint NOT NULL default '0',
  CONSTRAINT mx_table_block_pkey PRIMARY KEY (block_id) 
);

--
-- Dumping data for table `mx_block`
--

INSERT INTO mx_table_block VALUES (1, 'Welcome', '', 20, 0, 5, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (2, 'Multiple Horizontal Blocks', '', 19, 0, 0, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (3, 'Demo Textblock Multi', '', 22, 0, 5, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (4, 'Demo Textblock BBcode', '', 20, 0, 5, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (5, 'Demo Textblock Html', '', 21, 0, 5, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (6, 'Poll', '', 12, 0, 5, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (7, 'Language Select', '', 13, 99, 5, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (8, 'Navigation Menu', '', 11, 0, 5, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (24, 'Forum', '', 10, 0, 0, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (13, 'Login', NULL, 14, 99, 5, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (14, 'Theme Select', '', 15, 0, 5, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (21, 'Google', '', 16, 0, 0, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (18, 'Announcements', NULL, 17, 0, 0, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (19, 'Online', '', 18, 0, 0, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (16, 'Last Message Post', NULL, 30, 0, 0, 0, 0, 0, 0);
INSERT INTO mx_table_block VALUES (32, 'Statistics', '', 40, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mx_block_system_parameter`
--

DROP TABLE mx_table_block_system_parameter;
CREATE TABLE mx_table_block_system_parameter (
  block_id int  NOT NULL default '0',
  parameter_id int  NOT NULL default '0',
  parameter_value text,
  bbcode_uid varchar(10) default NULL,
  CONSTRAINT mx_table_block_system_parameter_pkey PRIMARY KEY (block_id, parameter_id) 
);
CREATE INDEX mx_table_block_system_parameter_parameter_id ON mx_table_block_system_parameter (parameter_id);
CREATE INDEX mx_table_block_system_parameter_block_id ON mx_table_block_system_parameter (block_id);

--
-- Dumping data for table `mx_block_system_parameter`
--

INSERT INTO mx_table_block_system_parameter VALUES (1, 15, 'Welcome to the Mx-system Portal!\r\n\r\nPlease visit www.mx-system.com for further information.\r\n\r\nThe Mx-Portal version is announced and documented [url=http://www.mx-system.com/forum/viewforum.php?f=11] here[/url].', '10bec5b560');
INSERT INTO mx_table_block_system_parameter VALUES (2, 60, '3,4,5', '');
INSERT INTO mx_table_block_system_parameter VALUES (2, 61, '33%,*,33%', '');
INSERT INTO mx_table_block_system_parameter VALUES (2, 62, '4', '');
INSERT INTO mx_table_block_system_parameter VALUES (3, 50, 'This is a demo multi textblock!\r\n\r\n - featuring bbcode, html, style parameters (click the EDIT button and try them out) and permissions (view and edit permissions for users and PRIVATE groups).', '10bec5b560');
INSERT INTO mx_table_block_system_parameter VALUES (3, 51, 'none', '');
INSERT INTO mx_table_block_system_parameter VALUES (3, 52, 'TRUE', '');
INSERT INTO mx_table_block_system_parameter VALUES (3, 53, 'TRUE', '');
INSERT INTO mx_table_block_system_parameter VALUES (3, 54, 'TRUE', '');
INSERT INTO mx_table_block_system_parameter VALUES (4, 15, 'This is a demo bbcode textblock!\r\n\r\n- featuring bbcode & html (if enabled for phpbb) and permissions (view and edit permissions for users and PRIVATE groups).', '10bec5b560');
INSERT INTO mx_table_block_system_parameter VALUES (5, 16, 'This is a demo html/wysiwyg textblock!\r\n\r\n- featuring html (or wysiwyg if addon pack is installed) and permissions (view and edit permissions for users and PRIVATE groups).', '10bec5b560');
INSERT INTO mx_table_block_system_parameter VALUES (6, 36, '', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (6, 13, '0', NULL);
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
INSERT INTO mx_table_block_system_parameter VALUES (18, 7, 'thumb_news.gif', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 8, 'thumb_globe.gif', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 9, 'thumb_globe.gif', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 6, 'TRUE', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 10, 'thumb_globe.gif ', NULL);
INSERT INTO mx_table_block_system_parameter VALUES (18, 11, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mx_column`
--

DROP TABLE mx_table_column;
CREATE TABLE mx_table_column (
  column_id SERIAL,
  column_title varchar(100) default NULL,
  column_order int  NOT NULL default '0',
  bbcode_uid varchar(10) default NULL,
  column_size varchar(5) default '100%',
  page_id smallint NOT NULL default '0',
  CONSTRAINT mx_table_column_pkey PRIMARY KEY (column_id) 
);
CREATE INDEX mx_table_column_cat_order ON mx_table_column (column_order);

--
-- Dumping data for table `mx_column`
--

INSERT INTO mx_table_column VALUES (1, 'Column 1', 10, NULL, '220', 1);
INSERT INTO mx_table_column VALUES (2, 'Column 2', 20, NULL, '100%', 1);
INSERT INTO mx_table_column VALUES (20, 'Menu', 10, NULL, '200', 2);
INSERT INTO mx_table_column VALUES (21, 'Forum', 20, NULL, '100%', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mx_column_block`
--

DROP TABLE mx_table_column_block;
CREATE TABLE mx_table_column_block (
  column_id smallint NOT NULL default '0',
  block_id smallint NOT NULL default '0',
  block_order smallint NOT NULL default '0'
);

--
-- Dumping data for table `mx_column_block`
--

INSERT INTO mx_table_column_block VALUES (1, 8, 10);
INSERT INTO mx_table_column_block VALUES (1, 16, 20);
INSERT INTO mx_table_column_block VALUES (1, 6, 30);
INSERT INTO mx_table_column_block VALUES (1, 13, 40);
INSERT INTO mx_table_column_block VALUES (1, 7, 50);
INSERT INTO mx_table_column_block VALUES (1, 14, 60);
INSERT INTO mx_table_column_block VALUES (2, 1, 10);
INSERT INTO mx_table_column_block VALUES (2, 2, 10);
INSERT INTO mx_table_column_block VALUES (2, 18, 20);
INSERT INTO mx_table_column_block VALUES (2, 19, 30);
INSERT INTO mx_table_column_block VALUES (20, 8, 10);
INSERT INTO mx_table_column_block VALUES (20, 16, 20);
INSERT INTO mx_table_column_block VALUES (21, 24, 30);
INSERT INTO mx_table_column_block VALUES (21, 19, 40);

-- --------------------------------------------------------

--
-- Table structure for table `mx_function`
--

DROP TABLE mx_table_function;
CREATE TABLE mx_table_function (
  function_id SERIAL,
  module_id int  NOT NULL default '0',
  function_name varchar(150) default NULL,
  function_desc text,
  function_file varchar(255) default NULL,
  function_admin varchar(255) default NULL,
  CONSTRAINT mx_table_function_pkey PRIMARY KEY (function_id) 
);
CREATE INDEX mx_table_function_module_id ON mx_table_function (module_id);

--
-- Dumping data for table `mx_function`
--

INSERT INTO mx_table_function VALUES (10, 10, 'Forum phpBB', 'Forum phpBB', 'mx_forum.php', NULL);
INSERT INTO mx_table_function VALUES (11, 10, 'Navigation Menu', 'Menu Navigation', 'mx_menu_nav.php', 'admin/admin_mx_menu.php');
INSERT INTO mx_table_function VALUES (12, 10, 'Polls', 'Polls', 'mx_poll.php', NULL);
INSERT INTO mx_table_function VALUES (13, 10, 'Language Select', 'Language Select', 'mx_language.php', NULL);
INSERT INTO mx_table_function VALUES (14, 10, 'Login', 'Login', 'mx_login.php', NULL);
INSERT INTO mx_table_function VALUES (15, 10, 'Theme Select', 'Theme Select', 'mx_theme.php', NULL);
INSERT INTO mx_table_function VALUES (16, 10, 'Google', 'Google', 'mx_google.php', NULL);
INSERT INTO mx_table_function VALUES (17, 10, 'Announcements', 'Announcements', 'mx_announce.php', NULL);
INSERT INTO mx_table_function VALUES (18, 10, 'Who is Online', 'Who is Online', 'mx_online.php', NULL);
INSERT INTO mx_table_function VALUES (19, 10, 'Multiple Horizontal Blocks', 'Block that can arrange other blocks in a horizontal line.', 'mx_multiple_blocks.php', '');
INSERT INTO mx_table_function VALUES (20, 20, 'TextBlock_BBcode', 'Textblock featuring BBCodes and html (if allowed by phpBB config)', 'mx_textblock_bbcode.php', 'modules/mx_textblocks/admin/admin_edit.php');
INSERT INTO mx_table_function VALUES (21, 20, 'TextBlock_Html', 'Textblock featuring html (or wysiwyg interface if addon pack is installed)', 'mx_textblock_html.php', 'modules/mx_textblocks/admin/admin_edit.php');
INSERT INTO mx_table_function VALUES (22, 20, 'TextBlock_Multi', 'Textblock for bbcode and html with parameters', 'mx_textblock_multi.php', 'modules/mx_textblocks/admin/admin_edit.php');
INSERT INTO mx_table_function VALUES (30, 30, 'Post Last Message', 'Post Last Message', 'mx_last_msg.php', NULL);
INSERT INTO mx_table_function VALUES (40, 40, 'Statistics MX', 'Statistics MX', 'mx_statistics.php', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mx_menu_categories`
--

DROP TABLE mx_table_menu_categories;
CREATE TABLE mx_table_menu_categories (
  block_id int  NOT NULL default '1',
  cat_id SERIAL,
  cat_title varchar(100) default NULL,
  cat_order int  NOT NULL default '0',
  bbcode_uid varchar(10) default NULL,
  cat_desc text,
  cat_show int  NOT NULL default '0',
  CONSTRAINT mx_table_menu_categories_pkey PRIMARY KEY (cat_id) 
);
CREATE INDEX mx_table_menu_categories_cat_order ON mx_table_menu_categories (cat_order);

--
-- Dumping data for table `mx_menu_categories`
--

INSERT INTO mx_table_menu_categories VALUES (8, 1, 'Main Menu', 20, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mx_menu_nav`
--

DROP TABLE mx_table_menu_nav;
CREATE TABLE mx_table_menu_nav (
  menu_id SERIAL,
  cat_id int  NOT NULL default '0',
  menu_name varchar(150) default NULL,
  menu_desc text,
  menu_links varchar(255) default NULL,
  auth_view smallint NOT NULL default '0',
  menu_order int  default '0',
  bbcode_uid varchar(10) default NULL,
  menu_icon varchar(255) default NULL,
  function_id int  default '0',
  block_id smallint NOT NULL default '0',
  page_id int  default '0',
  auth_view_group smallint NOT NULL default '0',
  link_target int  NOT NULL default '0',
  CONSTRAINT mx_table_menu_nav_pkey PRIMARY KEY (menu_id) 
);
CREATE INDEX mx_table_menu_nav_cat_id ON mx_table_menu_nav (cat_id);

--
-- Dumping data for table `mx_menu_nav`
--

INSERT INTO mx_table_menu_nav VALUES (1, 1, 'Home', 'Home Page', 'index.php', 0, 10, 'bc5d5e65eb', 'icon_home.gif', 0, 0, 0, 0, 0);
INSERT INTO mx_table_menu_nav VALUES (2, 1, 'Forum', 'phpBB Forum', 'index.php', 0, 20, '1a7e19f246', 'icon_forum.gif', 0, 0, 2, 0, 0);
INSERT INTO mx_table_menu_nav VALUES (3, 1, 'Statistics', 'Statistics Module', '', 0, 30, 'e16b0fbb51', 'icon_stat.gif', 40, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mx_module`
--

DROP TABLE mx_table_module;
CREATE TABLE mx_table_module (
  module_id SERIAL,
  module_name varchar(150) default NULL,
  module_path varchar(255) default NULL,
  module_desc text,
  module_include_admin char(1) default '0',
  CONSTRAINT mx_table_module_pkey PRIMARY KEY (module_id) 
);

--
-- Dumping data for table `mx_module`
--

INSERT INTO mx_table_module VALUES (10, 'Core Blocks', './', 'Core blocks', '');
INSERT INTO mx_table_module VALUES (20, 'Text Blocks', 'modules/mx_textblocks/', 'Textblocks module', '');
INSERT INTO mx_table_module VALUES (30, 'Post Last Message', 'modules/mx_last_msg/', 'Last Message Module', '0');
INSERT INTO mx_table_module VALUES (40, 'Statistics MX', 'modules/mx_statistics/', 'Statistics Modules', '0');

-- --------------------------------------------------------

--
-- Table structure for table `mx_page`
--

DROP TABLE mx_table_page;
CREATE TABLE mx_table_page (
  page_id SERIAL,
  page_name varchar(255) default NULL,
  page_icon varchar(255) default NULL,
  auth_view smallint NOT NULL default '0',
  auth_view_group smallint NOT NULL default '0',
  page_header varchar(255) default 'overall_header.tpl',
  CONSTRAINT mx_table_page_pkey PRIMARY KEY (page_id) 
);

--
-- Dumping data for table `mx_page`
--

INSERT INTO mx_table_page VALUES (1, 'Home', 'icon_home.gif', 0, 0, 'overall_header.tpl');
INSERT INTO mx_table_page VALUES (2, 'Forum', 'icon_forum.gif', 0, 0, 'overall_header.tpl');

-- --------------------------------------------------------

--
-- Table structure for table `mx_parameter`
--

DROP TABLE mx_table_parameter;
CREATE TABLE mx_table_parameter (
  parameter_id SERIAL,
  function_id int  NOT NULL default '0',
  parameter_name varchar(150) default NULL,
  parameter_type varchar(30) default NULL,
  parameter_default varchar(150) default NULL,
  parameter_function varchar(255) default NULL,
  CONSTRAINT mx_table_parameter_pkey PRIMARY KEY (parameter_id) 
);

--
-- Dumping data for table `mx_parameter`
--

INSERT INTO mx_table_parameter VALUES (1, 17, 'announce_nbr_display', 'Number', '1', NULL);
INSERT INTO mx_table_parameter VALUES (2, 17, 'announce_nbr_days', 'Number', '14', NULL);
INSERT INTO mx_table_parameter VALUES (3, 17, 'announce_display', 'Boolean', 'TRUE', NULL);
INSERT INTO mx_table_parameter VALUES (4, 17, 'announce_display_sticky', 'Boolean', 'TRUE', NULL);
INSERT INTO mx_table_parameter VALUES (5, 17, 'announce_display_normal', 'Boolean', 'FALSE', NULL);
INSERT INTO mx_table_parameter VALUES (7, 17, 'announce_img', 'Text', 'thumb_globe.gif', NULL);
INSERT INTO mx_table_parameter VALUES (8, 17, 'announce_img_sticky', 'Text', 'thumb_globe.gif', NULL);
INSERT INTO mx_table_parameter VALUES (9, 17, 'announce_img_normal', 'Text', 'thumb_globe.gif', NULL);
INSERT INTO mx_table_parameter VALUES (6, 17, 'announce_display_global', 'Boolean', 'TRUE', NULL);
INSERT INTO mx_table_parameter VALUES (10, 17, 'announce_img_global', 'Text', 'thumb_globe.gif', NULL);
INSERT INTO mx_table_parameter VALUES (11, 17, 'announce_forum', 'Function', NULL, 'get_list_multiple("{parameter_id}[]", FORUMS_TABLE, \'forum_id\', \'forum_name\', "{parameter_value}", TRUE)');
INSERT INTO mx_table_parameter VALUES (13, 12, 'Poll_Display', 'Function', '0', 'poll_select( {parameter_value}, "{parameter_id}" )');
INSERT INTO mx_table_parameter VALUES (36, 12, 'poll_forum', 'Function', '', 'get_list_multiple("{parameter_id}[]", FORUMS_TABLE, \'forum_id\', \'forum_name\', "{parameter_value}", TRUE)');
INSERT INTO mx_table_parameter VALUES (15, 20, 'Text', 'BBText', 'Insert your text here', NULL);
INSERT INTO mx_table_parameter VALUES (16, 21, 'Html', 'Html', 'Entre your Html code here', NULL);
INSERT INTO mx_table_parameter VALUES (17, 30, 'Last_Msg_Number_Title', 'Number', '15', NULL);
INSERT INTO mx_table_parameter VALUES (18, 30, 'Last_Msg_Display_Date', 'Boolean', 'TRUE', NULL);
INSERT INTO mx_table_parameter VALUES (19, 30, 'Last_Msg_Title_Length', 'Number', '30', NULL);
INSERT INTO mx_table_parameter VALUES (20, 30, 'Last_Msg_Target', 'Values', '_blank', NULL);
INSERT INTO mx_table_parameter VALUES (21, 30, 'Last_Msg_Align', 'Values', 'left', NULL);
INSERT INTO mx_table_parameter VALUES (22, 30, 'Last_Msg_Display_Forum', 'Boolean', 'TRUE', NULL);
INSERT INTO mx_table_parameter VALUES (37, 30, 'Last_Msg_forum', 'Function', '', 'get_list_multiple("{parameter_id}[]", FORUMS_TABLE, \'forum_id\', \'forum_name\', "{parameter_value}", TRUE)');
INSERT INTO mx_table_parameter VALUES (38, 30, 'Last_Msg_Display_Last_Author', 'Boolean', 'TRUE', '');
INSERT INTO mx_table_parameter VALUES (39, 30, 'Last_Msg_Display_Author', 'Boolean', 'FALSE', '');
INSERT INTO mx_table_parameter VALUES (40, 30, 'Last_Msg_Display_Icon_View', 'Boolean', 'TRUE', '');
INSERT INTO mx_table_parameter VALUES (50, 22, 'Text', 'BBText', 'Enter your block text here', '');
INSERT INTO mx_table_parameter VALUES (51, 22, 'text_style', 'Values', 'none', '');
INSERT INTO mx_table_parameter VALUES (52, 22, 'block_style', 'Boolean', 'TRUE', '');
INSERT INTO mx_table_parameter VALUES (53, 22, 'title_style', 'Boolean', 'TRUE', '');
INSERT INTO mx_table_parameter VALUES (54, 22, 'show_title', 'Boolean', 'TRUE', '');
INSERT INTO mx_table_parameter VALUES (60, 19, 'block_ids', 'Function', '1,2,3', 'get_list_multiple( "{parameter_id}[]", BLOCK_TABLE, \'block_id\', \'block_title\', "{parameter_value}", TRUE)');
INSERT INTO mx_table_parameter VALUES (61, 19, 'block_sizes', 'Text', '20%,30%,*', '');
INSERT INTO mx_table_parameter VALUES (62, 19, 'space_between', 'Number', '4', '');

-- --------------------------------------------------------

--
-- Table structure for table `mx_parameter_option`
--

DROP TABLE mx_table_parameter_option;
CREATE TABLE mx_table_parameter_option (
  option_id SERIAL,
  parameter_id int  NOT NULL default '0',
  option_code varchar(150) default NULL,
  option_desc text,
  CONSTRAINT mx_table_parameter_option_pkey PRIMARY KEY (option_id) 
);

--
-- Dumping data for table `mx_parameter_option`
--

INSERT INTO mx_table_parameter_option VALUES (3, 21, 'left', 'left ');
INSERT INTO mx_table_parameter_option VALUES (4, 21, 'right', 'right');
INSERT INTO mx_table_parameter_option VALUES (5, 21, 'center', 'center');
INSERT INTO mx_table_parameter_option VALUES (6, 20, '_blank', 'New Window');
INSERT INTO mx_table_parameter_option VALUES (7, 20, '_self', 'Current Window');

-- --------------------------------------------------------

--
-- Table structure for table `mx_portal`
--

DROP TABLE mx_table_portal;
CREATE TABLE mx_table_portal (
  portal_id SERIAL,
  portal_name varchar(150) default NULL,
  portal_phpbb_url varchar(255) default 'http://www.phpbb.com/phpBB/',
  portal_url varchar(255) default NULL,
  portal_version varchar(255) default NULL,
  top_phpbb_links int  NOT NULL default '1',
  CONSTRAINT mx_table_portal_pkey PRIMARY KEY (portal_id) 
);
