# MySQL-Front Dump 2.4
#
# Host: localhost   Database: core_28
#--------------------------------------------------------
# Server version 3.23.51-nt


#
# Table structure for table 'mx_table_block'
#

CREATE TABLE `mx_table_block` (
  `block_id` smallint(5) unsigned NOT NULL auto_increment,
  `block_title` varchar(150) default NULL,
  `block_desc` text,
  `function_id` smallint(5) unsigned default NULL,
  `auth_view` tinyint(2) NOT NULL default '0',
  `auth_edit` tinyint(2) default '0',
  `auth_delete` tinyint(2) default '0',
  `auth_view_group` varchar(255) NOT NULL default '0',
  `auth_edit_group` varchar(255) NOT NULL default '0',
  `auth_delete_group` varchar(255) NOT NULL default '0',
  `auth_moderator_group` varchar(255) NOT NULL default '0',
  `show_title` tinyint(2) unsigned NOT NULL default '1',
  `show_block` tinyint(2) unsigned NOT NULL default '1',
  `show_stats` tinyint(2) unsigned NOT NULL default '0',
  `block_time` varchar(255) binary NOT NULL default '',
  `block_editor_id` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`block_id`)
) ;



#
# Dumping data for table 'mx_table_block'
#
INSERT INTO mx_table_block VALUES("1", "phpBB TextBlock", "This is a Demo Block", "24", "0", "5", "0", "0", "0", "0", "0", "1", "1", "1", "1125865999", "2");
INSERT INTO mx_table_block VALUES("2", "Split Block", "This is a Demo Block", "11", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125841933", "2");
INSERT INTO mx_table_block VALUES("6", "Poll", "This is a Demo Block", "14", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125841942", "2");
INSERT INTO mx_table_block VALUES("7", "Language Select", "This is a Demo Block", "6", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125841887", "2");
INSERT INTO mx_table_block VALUES("8", "Navigation Menu", "This is a vertical Navigation Menu Demo Block", "51", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1126034018", "2");
INSERT INTO mx_table_block VALUES("24", "Forum", "This is a Demo Block", "8", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125841817", "2");
INSERT INTO mx_table_block VALUES("13", "Login", "This is a Demo Block", "7", "9", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125867452", "2");
INSERT INTO mx_table_block VALUES("14", "Theme Select", "This is a Demo Block", "12", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125841964", "2");
INSERT INTO mx_table_block VALUES("21", "Google", "This is a Demo Block", "4", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1126033253", "2");
INSERT INTO mx_table_block VALUES("18", "Announcements", "This is a Demo Block", "2", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125868467", "2");
INSERT INTO mx_table_block VALUES("19", "Who is Online?", "This is a Demo Block", "13", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125841983", "2");
INSERT INTO mx_table_block VALUES("16", "Last Message Post", "This is a Demo Block", "31", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125842159", "2");
INSERT INTO mx_table_block VALUES("26", "Statistics", "This is a Demo Block", "41", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125842177", "2");
INSERT INTO mx_table_block VALUES("27", "IncludeX", "This is a Demo Block", "5", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125841878", "2");
INSERT INTO mx_table_block VALUES("25", "Navigation Menu", "This is a horizontal Navigation Menu Demo Block", "51", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125842132", "2");
INSERT INTO mx_table_block VALUES("4", "Dynamic Block", "This is a Demo Block", "3", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125841802", "2");
INSERT INTO mx_table_block VALUES("5", "Blog TextBlock", "This is a Demo Block", "21", "0", "5", "0", "0", "0", "0", "0", "1", "1", "1", "1125842544", "2");
INSERT INTO mx_table_block VALUES("10", "WYSIWYG TextBlock", "This is a Demo Block", "23", "0", "5", "0", "0", "0", "0", "0", "1", "1", "1", "1125842503", "2");
INSERT INTO mx_table_block VALUES("28", "Welcome", "This is the firstpage welcome block", "24", "0", "5", "0", "0", "0", "0", "0", "1", "1", "1", "1125852430", "2");
INSERT INTO mx_table_block VALUES("29", "Demo Pages", "Introduction", "24", "0", "5", "0", "0", "0", "0", "0", "1", "1", "1", "1125859625", "2");
INSERT INTO mx_table_block VALUES("30", "Modules Info", "Introduction", "24", "0", "5", "0", "0", "0", "0", "0", "1", "1", "1", "1125859742", "2");
INSERT INTO mx_table_block VALUES("3", "Site Log", "This is a Demo Block", "10", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1125841954", "2");
INSERT INTO mx_table_block VALUES("9", "mxBB TextBlock", "This is a Demo Block", "22", "0", "5", "0", "0", "0", "0", "0", "1", "1", "1", "1125865570", "2");


#
# Table structure for table 'mx_table_block_system_parameter'
#

CREATE TABLE `mx_table_block_system_parameter` (
  `block_id` smallint(5) unsigned NOT NULL default '0',
  `parameter_id` smallint(5) unsigned NOT NULL default '0',
  `parameter_value` text,
  `parameter_opt` text,
  `sub_id` int(255) unsigned NOT NULL default '0',
  PRIMARY KEY  (`block_id`,`parameter_id`,`sub_id`)
) ;



#
# Dumping data for table 'mx_table_block_system_parameter'
#
INSERT INTO mx_table_block_system_parameter VALUES("8", "66", "", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("25", "66", "", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("2", "60", "21,7,14", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("2", "61", "33%, 33%,*", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("2", "62", "4", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("6", "36", "", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("6", "13", "0", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "17", "5", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "18", "TRUE", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "19", "30", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "20", "_self", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "21", "left", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "22", "TRUE", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "37", "", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "38", "FALSE", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "39", "FALSE", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "40", "TRUE", NULL, "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "1", "3", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "2", "10", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "3", "TRUE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "4", "TRUE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "5", "FALSE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "7", "thumb_news.gif", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "8", "thumb_globe.gif", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "9", "thumb_globe.gif", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "6", "TRUE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "10", "thumb_globe.gif", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("18", "11", "", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("8", "63", "Vertical", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("8", "64", "TRUE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("27", "72", "http://127.0.0.1/include_file/startsidan.htm", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("27", "70", "1", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("27", "73", "325", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("25", "63", "Horizontal", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("25", "64", "TRUE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("4", "80", "29", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("10", "16", "<table cellpadding=\"2\" width=\"100%\" border=\"0\"><tr><td class=\"row2\" valign=\"top\" align=\"left\"><span class=\"genmed\"><strong>Mon</strong></span></td><td class=\"row2\"><span class=\"gensmall\"><!-- MÅNDAG -->Busy with <em>this and that</em></span></td></tr><tr><td class=\"row1\" valign=\"top\" align=\"left\"><span class=\"genmed\"><strong>Tue</strong></span></td><td class=\"row1\"><span class=\"gensmall\"><!-- TISDAG-->Not so busy</span></td></tr><tr><td class=\"row2\" valign=\"top\" align=\"left\"><span class=\"genmed\"><strong>Wen</strong></span></td><td class=\"row2\"><span class=\"gensmall\"><!-- ONSDAG-->Very busy</span></td></tr><tr><td class=\"row1\" valign=\"top\" align=\"left\"><span class=\"genmed\"><strong>Thu</strong></span></td><td class=\"row1\"><span class=\"gensmall\"><!-- TORSDAG-->Lazy</span></td></tr><tr><td class=\"row2\" valign=\"top\" align=\"left\"><span class=\"genmed\"><strong>Fri</strong></span></td><td class=\"row2\"><span class=\"gensmall\"><!-- FREDAG-->Resting...</span></td></tr></table><p>This basic table structure is a nice demonstration in which the wysiwyg editor comes in handy!</p><p>Try it out! <br />(to edit use the top right edit button)</p>", "0", "0");
INSERT INTO mx_table_block_system_parameter VALUES("1", "15", "This is a [i:d4ee1ca70a]standard [/i:d4ee1ca70a]TextBlock, featuring bbcodes, html and smilies as defined by the phpBB config settings.\r\n\r\nTry it out! \r\n(to edit use the top right edit button)", "d4ee1ca70a", "0");
INSERT INTO mx_table_block_system_parameter VALUES("16", "65", "5", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("3", "91", "3 months", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("28", "15", "[b:5093963b57]mxBB Portal [/b:5093963b57]is a fully modular portal and CMS, for phpBB, featuring dynamic pages, blocks, themes and more by means of a powerful yet flexible adminCP and front end block editing possibilites on the fly. While it uses integrated features it works without touching phpBB.  mxBB Portal requires phpBB to run, and currently supports the MySQL and PostgreSQL databases. mxBB Portal is the classical phpBB portal addon, improved and enhanced for every phpBB version since 2001.\r\n\r\n[i:5093963b57]Welcome, and thanks for using the mxBB Portal![/i:5093963b57] \r\n\r\n :lol:", "5093963b57", "0");
INSERT INTO mx_table_block_system_parameter VALUES("29", "15", "On this page we [i:a561d23b0e]demonstrate [/i:a561d23b0e]a few basic portal blocks (not already present on this or other pages) - to get you started. Please, try out the top links to different demo blocks.", "a561d23b0e", "0");
INSERT INTO mx_table_block_system_parameter VALUES("30", "15", "You may enrich your portal with addon modules - for specific functionality:\r\n\r\n- Download manager\r\n- Picture Album\r\n- Calendar Tools\r\n- Knowledge Base\r\n- Links Gallery\r\n- Games\r\n\r\nand many more. Be sure to visit www.mx-publisher.com for latest available modules!", "ecfe9a4569", "0");
INSERT INTO mx_table_block_system_parameter VALUES("3", "92", "5", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("9", "50", "This is basically a [i:3883289f58]standard[/i:3883289f58] TextBlock, but you may configure settings for bbcodes, html and smilies for [i:3883289f58]this[/i:3883289f58] block.\r\n\r\nTry it out! \r\n(to edit use the top right edit button)", "3883289f58", "0");
INSERT INTO mx_table_block_system_parameter VALUES("9", "51", "none", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("9", "52", "TRUE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("9", "53", "TRUE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("9", "56", "TRUE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("9", "54", "TRUE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("9", "57", "TRUE", "", "0");
INSERT INTO mx_table_block_system_parameter VALUES("9", "55", "b,i,u,img", "", "0");


#
# Table structure for table 'mx_table_column'
#

CREATE TABLE `mx_table_column` (
  `column_id` smallint(5) unsigned NOT NULL auto_increment,
  `column_title` varchar(100) default NULL,
  `column_order` smallint(5) unsigned NOT NULL default '0',
  `bbcode_uid` varchar(10) default NULL,
  `column_size` varchar(5) default '100%',
  `page_id` smallint(5) NOT NULL default '0',
  PRIMARY KEY  (`column_id`),
  KEY `cat_order` (`column_order`)
) ;



#
# Dumping data for table 'mx_table_column'
#
INSERT INTO mx_table_column VALUES("8", "Main", "50", NULL, "100%", "4");
INSERT INTO mx_table_column VALUES("2", "Main", "35", NULL, "100%", "1");
INSERT INTO mx_table_column VALUES("7", "Left", "40", NULL, "200", "4");
INSERT INTO mx_table_column VALUES("6", "Main", "50", NULL, "100%", "3");
INSERT INTO mx_table_column VALUES("5", "Left", "40", NULL, "200", "3");
INSERT INTO mx_table_column VALUES("4", "Main", "50", NULL, "100%", "2");
INSERT INTO mx_table_column VALUES("1", "Left", "25", NULL, "200", "1");
INSERT INTO mx_table_column VALUES("3", "Left", "40", NULL, "200", "2");


#
# Table structure for table 'mx_table_column_block'
#

CREATE TABLE `mx_table_column_block` (
  `column_id` smallint(5) NOT NULL default '0',
  `block_id` smallint(5) NOT NULL default '0',
  `block_order` smallint(5) NOT NULL default '0'
) ;



#
# Dumping data for table 'mx_table_column_block'
#
INSERT INTO mx_table_column_block VALUES("5", "14", "40");
INSERT INTO mx_table_column_block VALUES("4", "19", "20");
INSERT INTO mx_table_column_block VALUES("8", "19", "20");
INSERT INTO mx_table_column_block VALUES("4", "24", "10");
INSERT INTO mx_table_column_block VALUES("1", "13", "20");
INSERT INTO mx_table_column_block VALUES("3", "16", "20");
INSERT INTO mx_table_column_block VALUES("5", "3", "30");
INSERT INTO mx_table_column_block VALUES("2", "19", "20");
INSERT INTO mx_table_column_block VALUES("2", "28", "10");
INSERT INTO mx_table_column_block VALUES("1", "8", "10");
INSERT INTO mx_table_column_block VALUES("6", "25", "10");
INSERT INTO mx_table_column_block VALUES("8", "26", "10");
INSERT INTO mx_table_column_block VALUES("7", "8", "10");
INSERT INTO mx_table_column_block VALUES("6", "4", "20");
INSERT INTO mx_table_column_block VALUES("5", "8", "10");
INSERT INTO mx_table_column_block VALUES("6", "19", "30");
INSERT INTO mx_table_column_block VALUES("5", "7", "20");
INSERT INTO mx_table_column_block VALUES("3", "13", "30");
INSERT INTO mx_table_column_block VALUES("3", "8", "10");


#
# Table structure for table 'mx_table_column_templates'
#

CREATE TABLE `mx_table_column_templates` (
  `column_template_id` smallint(5) unsigned NOT NULL auto_increment,
  `column_title` varchar(100) default '0',
  `column_order` smallint(5) unsigned NOT NULL default '0',
  `column_size` varchar(5) default '0',
  `page_template_id` smallint(5) NOT NULL default '0',
  PRIMARY KEY  (`column_template_id`),
  KEY `cat_order` (`column_order`)
) ;



#
# Dumping data for table 'mx_table_column_templates'
#
INSERT INTO mx_table_column_templates VALUES("1", "Left", "40", "200", "2");
INSERT INTO mx_table_column_templates VALUES("2", "Main", "50", "100%", "2");
INSERT INTO mx_table_column_templates VALUES("3", "Main", "10", "100%", "3");
INSERT INTO mx_table_column_templates VALUES("4", "Right", "20", "200", "3");
INSERT INTO mx_table_column_templates VALUES("5", "Left", "10", "180", "4");
INSERT INTO mx_table_column_templates VALUES("6", "Middle", "20", "100%", "4");
INSERT INTO mx_table_column_templates VALUES("7", "Right", "30", "180", "4");


#
# Table structure for table 'mx_table_function'
#

CREATE TABLE `mx_table_function` (
  `function_id` smallint(5) unsigned NOT NULL auto_increment,
  `module_id` smallint(5) unsigned NOT NULL default '0',
  `function_name` varchar(150) default NULL,
  `function_desc` text,
  `function_file` varchar(255) default NULL,
  `function_admin` varchar(255) default NULL,
  PRIMARY KEY  (`function_id`),
  KEY `module_id` (`module_id`)
) ;



#
# Dumping data for table 'mx_table_function'
#
INSERT INTO mx_table_function VALUES("8", "10", "phpBB forum", "phpBB Function for the phpBB Index Block", "mx_forum.php", "");
INSERT INTO mx_table_function VALUES("51", "50", "Navigation Menu", "This is the function for Navigation Menu Blocks", "mx_menu_nav.php", "");
INSERT INTO mx_table_function VALUES("14", "10", "Polls", "This is the function for Polls", "mx_poll.php", "");
INSERT INTO mx_table_function VALUES("6", "10", "Language Select", "Language Select Function", "mx_language.php", "");
INSERT INTO mx_table_function VALUES("7", "10", "Login", "Login Function", "mx_login.php", "");
INSERT INTO mx_table_function VALUES("12", "10", "Theme Select", "Theme Select Function", "mx_theme.php", "");
INSERT INTO mx_table_function VALUES("4", "10", "Google", "Google Block Function", "mx_google.php", "");
INSERT INTO mx_table_function VALUES("2", "10", "Announcements", "Announcements Function", "mx_announce.php", "");
INSERT INTO mx_table_function VALUES("13", "10", "Who is Online", "Who is Online Function", "mx_online.php", "");
INSERT INTO mx_table_function VALUES("11", "10", "Split Block", "Split Block Function - a block that puts subblocks side by side", "mx_multiple_blocks.php", "");
INSERT INTO mx_table_function VALUES("24", "20", "TextBlock (phpBB)", "BBcodes, html and smilies - defined by phpBB config", "mx_textblock_bbcode.php", "");
INSERT INTO mx_table_function VALUES("23", "20", "TextBlock (Html/wysiwyg)", "Plain html textblock, or featuring a wysiwyg editor", "mx_textblock_html.php", "");
INSERT INTO mx_table_function VALUES("22", "20", "TextBlock (Customized)", "Textblock, featuring block defined settings", "mx_textblock_multi.php", "");
INSERT INTO mx_table_function VALUES("31", "30", "Post Last Message", "Post Last Message Function", "mx_last_msg.php", "");
INSERT INTO mx_table_function VALUES("41", "40", "Statistics MX", "Statistics Function", "mx_statistics.php", NULL);
INSERT INTO mx_table_function VALUES("5", "10", "IncludeX", "Include a iframe, site, multimedia or file", "mx_includex.php", "");
INSERT INTO mx_table_function VALUES("3", "10", "DynamicBlock", "Dynamic block defined by its block_id", "mx_dynamic.php", "");
INSERT INTO mx_table_function VALUES("21", "20", "TextBlock (Blog)", "UserBlog Textblock", "mx_textblock_blog.php", "");
INSERT INTO mx_table_function VALUES("10", "10", "Site Log", "Site Log monitor Function", "mx_site_log.php", "");


#
# Table structure for table 'mx_table_menu_categories'
#

CREATE TABLE `mx_table_menu_categories` (
  `block_id` smallint(5) unsigned NOT NULL default '1',
  `cat_id` mediumint(8) unsigned NOT NULL auto_increment,
  `cat_title` varchar(100) default NULL,
  `cat_order` mediumint(8) unsigned NOT NULL default '0',
  `bbcode_uid` varchar(10) default NULL,
  `cat_desc` text,
  `cat_show` tinyint(1) unsigned NOT NULL default '0',
  `cat_url` smallint(5) unsigned default '0',
  `cat_target` tinyint(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cat_id`),
  KEY `cat_order` (`cat_order`)
) ;



#
# Dumping data for table 'mx_table_menu_categories'
#
INSERT INTO mx_table_menu_categories VALUES("8", "1", "Resources", "20", "c1affc0aaa", "", "0", "0", "0");
INSERT INTO mx_table_menu_categories VALUES("8", "3", "Home", "10", "eab7a16ce5", "", "1", "1", "0");
INSERT INTO mx_table_menu_categories VALUES("25", "4", "Core Blocks", "40", "a5abf5b8c4", "Demo Core blocks", "1", "0", "0");
INSERT INTO mx_table_menu_categories VALUES("25", "5", "TextBlocks", "50", "fa33545edc", "Demo TextBlocks", "0", "0", "0");
INSERT INTO mx_table_menu_categories VALUES("25", "6", "Modules", "60", "7dafcede48", "Modules Info", "0", "0", "0");


#
# Table structure for table 'mx_table_menu_nav'
#

CREATE TABLE `mx_table_menu_nav` (
  `menu_id` smallint(5) unsigned NOT NULL auto_increment,
  `cat_id` mediumint(8) unsigned NOT NULL default '0',
  `menu_name` varchar(150) default NULL,
  `menu_desc` text,
  `menu_links` varchar(255) default NULL,
  `auth_view` tinyint(2) NOT NULL default '0',
  `menu_order` smallint(5) unsigned default '0',
  `bbcode_uid` varchar(10) default NULL,
  `menu_icon` varchar(255) default NULL,
  `function_id` smallint(5) unsigned default '0',
  `block_id` smallint(8) NOT NULL default '0',
  `page_id` smallint(5) unsigned default '0',
  `auth_view_group` smallint(5) NOT NULL default '0',
  `link_target` tinyint(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`menu_id`),
  KEY `cat_id` (`cat_id`)
) ;



#
# Dumping data for table 'mx_table_menu_nav'
#
INSERT INTO mx_table_menu_nav VALUES("7", "4", "Split Block", "Split block Demo", "", "0", "10", "043673560e", "icon_dot.gif", "0", "2", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("8", "4", "Google Block", "Google Block Demo", "", "0", "20", "795e2489d7", "icon_dot.gif", "0", "21", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("9", "4", "phpBB Announcements (if any)", "phpBB Announcements Demo", "", "0", "30", "29add66982", "icon_dot.gif", "0", "18", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("10", "4", "IncludeX", "IncludeX Demo", "", "0", "40", "f7adaf1201", "icon_dot.gif", "0", "27", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("11", "4", "phpBB Polls (if any)", "phpBB Polls Demo", "", "0", "50", "a80fe73aee", "icon_dot.gif", "0", "6", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("12", "5", "phpBB TextBlock", "phpBB TextBlock Demo", "", "0", "10", "85d178caa8", "icon_dot.gif", "0", "1", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("13", "5", "WYSIWYG TextBlock", "WYSIWYG TextBlock Demo", "", "0", "20", "51e2ddb3a7", "icon_dot.gif", "0", "10", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("14", "5", "Custom TextBlock", "Custom TextBlock Demo", "", "0", "30", "22cb7a4f9f", "icon_dot.gif", "0", "9", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("15", "6", "Modules Info", "Information", "", "0", "10", "630ce0e7f0", "icon_dot.gif", "0", "30", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("5", "1", "phpBB Home", "", "http://www.phpbb.com", "0", "20", "71fe54c6a2", "icon_info.gif", "0", "0", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("3", "3", "SiteStats", "Some Sitestats", "", "0", "30", "62b47107b4", "icon_stats.gif", "0", "0", "4", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("4", "1", "mxBB-Portal Home", "", "http://www.mx-publisher.com", "0", "10", "c40e66a4ae", "icon_info.gif", "0", "0", "0", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("6", "1", "Demo Pages", "On this page are several demo blocks located", "", "0", "30", "348dc29f4a", "icon_dev.gif", "0", "0", "3", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("1", "3", "Home", "Back to home", "", "0", "10", "bb51181967", "icon_home.gif", "0", "0", "1", "0", "0");
INSERT INTO mx_table_menu_nav VALUES("2", "3", "Forum", "phpBB Forum Index", "", "0", "20", "a33e401abc", "icon_forum.gif", "0", "0", "2", "0", "0");


#
# Table structure for table 'mx_table_module'
#

CREATE TABLE `mx_table_module` (
  `module_id` smallint(5) unsigned NOT NULL auto_increment,
  `module_name` varchar(150) default NULL,
  `module_path` varchar(255) default NULL,
  `module_desc` text,
  `module_include_admin` char(1) default '0',
  `module_version` varchar(255) default NULL,
  `module_copy` text,
  PRIMARY KEY  (`module_id`)
) ;



#
# Dumping data for table 'mx_table_module'
#
INSERT INTO mx_table_module VALUES("10", "Core Blocks", "modules/mx_coreblocks/", "mxBB Core (standard) Module", "0", "", "mzBB Core Module");
INSERT INTO mx_table_module VALUES("20", "Text Blocks", "modules/mx_textblocks/", "mxBB Textblocks Module", "0", NULL, "mzBB Core Module");
INSERT INTO mx_table_module VALUES("30", "Post Last Message", "modules/mx_last_msg/", "mxBB Last Message Module", "0", NULL, "mzBB Core Module");
INSERT INTO mx_table_module VALUES("40", "Statistics MX", "modules/mx_statistics/", "mxBB Statistics Module", "0", NULL, "mzBB Core Module");
INSERT INTO mx_table_module VALUES("50", "Navigation Menu", "modules/mx_navmenu/", "mxBB Navigation Module", "0", NULL, "mzBB Core Module");


#
# Table structure for table 'mx_table_page'
#

CREATE TABLE `mx_table_page` (
  `page_id` smallint(5) NOT NULL auto_increment,
  `page_name` varchar(255) default NULL,
  `page_desc` varchar(255) default NULL,
  `page_icon` varchar(255) default NULL,
  `auth_view` tinyint(2) NOT NULL default '0',
  `auth_view_group` varchar(255) NOT NULL default '0',
  `auth_moderator_group` varchar(255) NOT NULL default '0',
  `page_header` varchar(255) default 'overall_header.tpl',
  `page_graph_border` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`page_id`)
) ;



#
# Dumping data for table 'mx_table_page'
#
INSERT INTO mx_table_page VALUES("4", "Sitestats", "Sitestats page", "nav_statistics.gif", "0", "0", "0", "overall_header.tpl", "");
INSERT INTO mx_table_page VALUES("1", "Home", "This is the startpage", "nav_home.gif", "0", "0", "0", "overall_header.tpl", "");
INSERT INTO mx_table_page VALUES("2", "Forum", "This is the phpBB Forum startpage", "nav_forum.gif", "0", "0", "0", "overall_header.tpl", "");
INSERT INTO mx_table_page VALUES("3", "Demo Page", "Block Demos", "nav_develope.gif", "0", "0", "0", "overall_header.tpl", "");


#
# Table structure for table 'mx_table_page_templates'
#

CREATE TABLE `mx_table_page_templates` (
  `page_template_id` smallint(3) unsigned NOT NULL auto_increment,
  `template_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`page_template_id`)
) ;



#
# Dumping data for table 'mx_table_page_templates'
#
INSERT INTO mx_table_page_templates VALUES("1", "NONE");
INSERT INTO mx_table_page_templates VALUES("2", "Two-Columns left1");
INSERT INTO mx_table_page_templates VALUES("3", "Two-Columns right");
INSERT INTO mx_table_page_templates VALUES("4", "Three-Columns");


#
# Table structure for table 'mx_table_parameter'
#

CREATE TABLE `mx_table_parameter` (
  `parameter_id` smallint(5) unsigned NOT NULL auto_increment,
  `function_id` smallint(5) unsigned NOT NULL default '0',
  `parameter_name` varchar(150) default NULL,
  `parameter_type` varchar(30) default NULL,
  `parameter_default` varchar(150) default NULL,
  `parameter_function` varchar(255) default NULL,
  `parameter_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`parameter_id`)
) ;



#
# Dumping data for table 'mx_table_parameter'
#
INSERT INTO mx_table_parameter VALUES("1", "2", "announce_nbr_display", "Number", "1", "", "0");
INSERT INTO mx_table_parameter VALUES("2", "2", "announce_nbr_days", "Number", "14", "", "0");
INSERT INTO mx_table_parameter VALUES("3", "2", "announce_display", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("4", "2", "announce_display_sticky", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("5", "2", "announce_display_normal", "Boolean", "FALSE", "", "0");
INSERT INTO mx_table_parameter VALUES("7", "2", "announce_img", "Text", "thumb_globe.gif", "", "0");
INSERT INTO mx_table_parameter VALUES("8", "2", "announce_img_sticky", "Text", "thumb_globe.gif", "", "0");
INSERT INTO mx_table_parameter VALUES("9", "2", "announce_img_normal", "Text", "thumb_globe.gif", "", "0");
INSERT INTO mx_table_parameter VALUES("6", "2", "announce_display_global", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("10", "2", "announce_img_global", "Text", "thumb_globe.gif", "", "0");
INSERT INTO mx_table_parameter VALUES("11", "2", "announce_forum", "Function", "", "get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)", "0");
INSERT INTO mx_table_parameter VALUES("13", "14", "Poll_Display", "Function", "0", "poll_select( {parameter_value}, \"{parameter_id}\" )", "0");
INSERT INTO mx_table_parameter VALUES("36", "14", "poll_forum", "Function", "", "get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)", "0");
INSERT INTO mx_table_parameter VALUES("15", "24", "Text", "phpBBTextBlock", "Insert your text here", "", "0");
INSERT INTO mx_table_parameter VALUES("16", "23", "Html", "WysiwygTextBlock", "Entre your Html code here", "", "0");
INSERT INTO mx_table_parameter VALUES("17", "31", "Last_Msg_Number_Title", "Number", "15", "", "0");
INSERT INTO mx_table_parameter VALUES("18", "31", "Last_Msg_Display_Date", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("19", "31", "Last_Msg_Title_Length", "Number", "30", "", "0");
INSERT INTO mx_table_parameter VALUES("20", "31", "Last_Msg_Target", "Values", "_blank", "", "0");
INSERT INTO mx_table_parameter VALUES("21", "31", "Last_Msg_Align", "Values", "left", "", "0");
INSERT INTO mx_table_parameter VALUES("22", "31", "Last_Msg_Display_Forum", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("37", "31", "Last_Msg_forum", "Function", "", "get_list_multiple(\"{parameter_id}[]\", FORUMS_TABLE, \'forum_id\', \'forum_name\', \"{parameter_value}\", TRUE)", "0");
INSERT INTO mx_table_parameter VALUES("38", "31", "Last_Msg_Display_Last_Author", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("39", "31", "Last_Msg_Display_Author", "Boolean", "FALSE", "", "0");
INSERT INTO mx_table_parameter VALUES("40", "31", "Last_Msg_Display_Icon_View", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("50", "22", "Text", "CustomizedTextBlock", "Enter your block text here", "", "0");
INSERT INTO mx_table_parameter VALUES("51", "22", "text_style", "Text", "none", "", "0");
INSERT INTO mx_table_parameter VALUES("52", "22", "block_style", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("53", "22", "title_style", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("91", "10", "log_filter_date", "Menu_single_select", "1 month", "a:12:{i:0;s:8:\"no limit\";i:1;s:5:\"1 day\";i:2;s:6:\"2 days\";i:3;s:6:\"3 days\";i:4;s:6:\"1 week\";i:5;s:7:\"2 weeks\";i:6;s:7:\"3 weeks\";i:7;s:7:\"1 month\";i:8;s:8:\"2 months\";i:9;s:8:\"3 months\";i:10;s:8:\"6 months\";i:11;s:6:\"1 year\";}", "0");
INSERT INTO mx_table_parameter VALUES("60", "11", "block_ids", "Function", "1,2,3", "get_list_multiple( \"{parameter_id}[]\", BLOCK_TABLE, \'block_id\', \'block_title\', \"{parameter_value}\", TRUE)", "0");
INSERT INTO mx_table_parameter VALUES("61", "11", "block_sizes", "Text", "20%,30%,*", "", "0");
INSERT INTO mx_table_parameter VALUES("62", "11", "space_between", "Number", "4", "", "0");
INSERT INTO mx_table_parameter VALUES("70", "5", "x_mode", "Menu_single_select", "x_iframe", "a:6:{i:0;s:8:\"x_listen\";i:1;s:8:\"x_iframe\";i:2;s:10:\"x_textfile\";i:3;s:12:\"x_multimedia\";i:4;s:5:\"x_pic\";i:5;s:8:\"x_format\";}", "0");
INSERT INTO mx_table_parameter VALUES("80", "3", "default_block_id", "Function", "0", "get_list_formatted(\"block_list\",\"{parameter_value}\",\"{parameter_id}[]\")", "0");
INSERT INTO mx_table_parameter VALUES("72", "5", "x_1", "Text", "", "", "0");
INSERT INTO mx_table_parameter VALUES("73", "5", "x_2", "Text", "", "", "0");
INSERT INTO mx_table_parameter VALUES("63", "51", "menu_display_mode", "Radio_single_select", "Vertical", "a:2:{i:0;s:8:\"Vertical\";i:1;s:10:\"Horizontal\";}", "20");
INSERT INTO mx_table_parameter VALUES("64", "51", "menu_page_sync", "Boolean", "0", "", "30");
INSERT INTO mx_table_parameter VALUES("71", "5", "x_3", "Text", "http://www.mx-publisher.com", "", "0");
INSERT INTO mx_table_parameter VALUES("81", "21", "Blog", "BBText", "Add your text here...", "", "0");
INSERT INTO mx_table_parameter VALUES("92", "10", "numOfEvents", "Number", "5", "", "0");
INSERT INTO mx_table_parameter VALUES("65", "51", "msg_filter_date", "Function", "5", "get_list_static(\"{parameter_id}[]\",array(\"no limit\", \"1 day\", \"2 days\", \"3 days\", \"1 week\", \"2 weeks\", \"3 weeks\", \"1 month\", \"2 months\", \"3 months\", \"6 months\", \"1 year\"),\"{parameter_value}\")", "0");
INSERT INTO mx_table_parameter VALUES("57", "22", "allow_smilies", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("54", "22", "allow_html", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("56", "22", "allow_bbcode", "Boolean", "TRUE", "", "0");
INSERT INTO mx_table_parameter VALUES("55", "22", "html_tags", "Text", "b,i,u,img", "", "0");
INSERT INTO mx_table_parameter VALUES("66", "51", "Nav menu", "nav_menu", "", "", "10");


#
# Table structure for table 'mx_table_portal'
#

CREATE TABLE `mx_table_portal` (
  `portal_id` smallint(5) unsigned NOT NULL auto_increment,
  `portal_name` varchar(150) default NULL,
  `portal_phpbb_url` varchar(255) default 'http://www.phpbb.com/phpBB/',
  `portal_url` varchar(255) default NULL,
  `portal_version` varchar(255) default NULL,
  `top_phpbb_links` smallint(5) unsigned NOT NULL default '1',
  `mx_use_cache` smallint(5) unsigned NOT NULL default '1',
  `portal_recached` varchar(255) binary NOT NULL default '',
  PRIMARY KEY  (`portal_id`)
) ;



#
# Dumping data for table 'mx_table_portal'
#
INSERT INTO mx_table_portal VALUES("1", "mxBB-Portal (Fresh install)", "http://127.0.0.1/phpBB2/", "http://127.0.0.1/", "2.8 - RC1", "0", "1", "1126035152");


#
# Table structure for table 'mx_table_search_results'
#

CREATE TABLE `mx_table_search_results` (
  `search_id` int(11) unsigned NOT NULL default '0',
  `session_id` varchar(32) NOT NULL default '',
  `search_array` text NOT NULL,
  PRIMARY KEY  (`search_id`),
  KEY `session_id` (`session_id`)
) ;



#
# Dumping data for table 'mx_table_search_results'
#


#
# Table structure for table 'mx_table_wordlist'
#

CREATE TABLE `mx_table_wordlist` (
  `word_text` varchar(50) binary NOT NULL default '',
  `word_id` mediumint(8) unsigned NOT NULL auto_increment,
  `word_common` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`word_text`),
  KEY `word_id` (`word_id`)
) ;



#
# Dumping data for table 'mx_table_wordlist'
#


#
# Table structure for table 'mx_table_wordmatch'
#

CREATE TABLE `mx_table_wordmatch` (
  `block_id` mediumint(8) unsigned NOT NULL default '0',
  `word_id` mediumint(8) unsigned NOT NULL default '0',
  `title_match` tinyint(1) NOT NULL default '0',
  KEY `block_id` (`block_id`),
  KEY `word_id` (`word_id`)
) ;



#
# Dumping data for table 'mx_table_wordmatch'
#
