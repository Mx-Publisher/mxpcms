# MySQL-Front Dump 2.4
#
# Host: localhost   Database: MX-Publisher
#--------------------------------------------------------


#
# Table structure for table 'mx_table_block'
#
DROP TABLE IF EXISTS `mx_table_block`;
CREATE TABLE `mx_table_block` (
  `block_id` smallint(5) unsigned NOT NULL auto_increment,
  `block_title` varchar(150),
  `block_desc` text,
  `function_id` smallint(5) unsigned,
  `auth_view` tinyint(2) NOT NULL DEFAULT '0',
  `auth_edit` tinyint(2) NOT NULL DEFAULT '0',
  `auth_delete` tinyint(2) NOT NULL DEFAULT '0',
  `auth_view_group` varchar(255) NOT NULL DEFAULT '0',
  `auth_edit_group` varchar(255) NOT NULL DEFAULT '0',
  `auth_delete_group` varchar(255) NOT NULL DEFAULT '0',
  `auth_moderator_group` varchar(255) NOT NULL DEFAULT '0',
  `show_title` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `show_block` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `show_stats` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `block_time` varchar(255) NOT NULL DEFAULT '',
  `block_editor_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`block_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_block'
#
INSERT INTO `mx_table_block` VALUES("1", "Demo Page 3", "Demo", "24", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202765204", "2");
INSERT INTO `mx_table_block` VALUES("2", "Split Block", "This is a Demo Block", "11", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202598000", "2");
INSERT INTO `mx_table_block` VALUES("3", "Site Log", "This is a Demo Block", "10", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202598000", "2");
INSERT INTO `mx_table_block` VALUES("4", "Demo page", "SubBlocks", "3", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202761342", "2");
INSERT INTO `mx_table_block` VALUES("7", "Language Select", "This is a Demo Block", "6", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202598000", "2");
INSERT INTO `mx_table_block` VALUES("8", "Navigation Menu", "This is a vertical Navigation Menu Demo Block", "51", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202598000", "2");
INSERT INTO `mx_table_block` VALUES("9", "Demo Page 5 - Custom", "Demo", "22", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202761540", "2");
INSERT INTO `mx_table_block` VALUES("10", "Demo Page 4 - wysiwyg", "Demo", "23", "0", "5", "0", "0", "0", "0", "0", "1", "1", "1", "1202761496", "2");
INSERT INTO `mx_table_block` VALUES("13", "Login", "This is a Demo Block", "7", "9", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202598000", "2");
INSERT INTO `mx_table_block` VALUES("14", "Theme Select", "This is a Demo Block", "12", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202598000", "2");
INSERT INTO `mx_table_block` VALUES("15", "Site Search", "Site Search", "15", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202598000", "2");
INSERT INTO `mx_table_block` VALUES("19", "Who is Online?", "This is a Demo Block", "13", "5", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202763740", "2");
INSERT INTO `mx_table_block` VALUES("21", "Google", "This is a Demo Block", "4", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202598000", "2");
INSERT INTO `mx_table_block` VALUES("32", "Demo page", "", "51", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202761705", "2");
INSERT INTO `mx_table_block` VALUES("27", "IncludeX", "This is a Demo Block", "5", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202598000", "2");
INSERT INTO `mx_table_block` VALUES("28", "Welcome", "This is the welcome block", "24", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202766730", "2");
INSERT INTO `mx_table_block` VALUES("29", "Demo Page 1", "Demo", "24", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202765153", "2");
INSERT INTO `mx_table_block` VALUES("30", "Demo Page 2", "Demo", "24", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202765190", "2");
INSERT INTO `mx_table_block` VALUES("31", "Page Navigation", "This is a page navigation menu", "52", "0", "5", "0", "0", "0", "0", "0", "1", "1", "0", "1202598000", "2");



#
# Table structure for table 'mx_table_block_system_parameter'
#
DROP TABLE IF EXISTS `mx_table_block_system_parameter`;
CREATE TABLE `mx_table_block_system_parameter` (
  `block_id` smallint(5) unsigned NOT NULL default '0',
  `parameter_id` smallint(5) unsigned NOT NULL default '0',
  `parameter_value` mediumtext,
  `parameter_opt` text,
  `sub_id` int(255) unsigned NOT NULL default '0',
  PRIMARY KEY  (`block_id`,`parameter_id`,`sub_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_block_system_parameter'
#
INSERT INTO `mx_table_block_system_parameter` VALUES("1", "15", "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas malesuada semper ante. Aliquam orci ipsum, aliquam sodales, dictum id, tincidunt non, elit. Proin tincidunt felis id urna. Praesent in erat. Nunc at arcu et nisi tempor interdum. Quisque enim. Nunc et lorem. Ut tortor. Suspendisse potenti. Nam egestas orci at mi. Sed pulvinar est sit amet ante. Mauris pharetra mollis risus. Donec accumsan fermentum leo.\r\n\r\nSuspendisse potenti. Quisque tincidunt, mi viverra semper iaculis, nisl metus vehicula libero, eget tincidunt est massa ac purus. Aenean a justo. Sed ultrices, mi vitae hendrerit suscipit, mauris velit rutrum lectus, eget pharetra metus ipsum in purus. Sed placerat ornare nulla. Nullam vel leo non nulla fermentum varius. Integer nec pede a velit tempor aliquam. Sed eu neque in eros scelerisque eleifend. Vivamus id urna. Pellentesque nec nulla. Fusce et sapien. Nulla venenatis imperdiet ligula. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin vel nunc eu leo malesuada congue. Praesent faucibus. Vivamus quis sapien in dolor gravida vehicula.", "46dd886e9d", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("2", "60", "16,13,9", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("2", "61", "33%, 33%,*", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("2", "62", "4", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("3", "91", "3 months", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("3", "92", "5", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("4", "80", "29", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("8", "66", "", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("8", "93", "", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("8", "63", "Vertical", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("32", "93", "", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("32", "66", "", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("31", "100", "", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("31", "101", "", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("31", "102", "Overall_navigation", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("9", "50", "This is basically a [i:021a122fa6]standard[/i:021a122fa6] TextBlock, but you may configure settings for bbcodes, html and smilies for [i:021a122fa6]this[/i:021a122fa6] block.\r\n\r\nTry it out! \r\n(to edit use the top right edit button)", "021a122fa6", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("9", "51", "none", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("9", "52", "TRUE", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("9", "53", "TRUE", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("9", "56", "TRUE", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("9", "54", "TRUE", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("9", "57", "TRUE", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("9", "55", "b,i,u,img", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("10", "16", "<table width=\"100%\" cellpadding=\"2\" border=\"0\"><tbody><tr><td valign=\"top\" align=\"left\" class=\"row2\"><span class=\"genmed\"><strong>Mon</strong></span></td><td class=\"row2\"><span class=\"gensmall\"><!-- MĹNDAG -->Busy with <em>this and that</em></span></td></tr><tr><td valign=\"top\" align=\"left\" class=\"row1\"><span class=\"genmed\"><strong>Tue</strong></span></td><td class=\"row1\"><span class=\"gensmall\"><!-- TISDAG-->Not so busy</span></td></tr><tr><td valign=\"top\" align=\"left\" class=\"row2\"><span class=\"genmed\"><strong>Wen</strong></span></td><td class=\"row2\"><span class=\"gensmall\"><!-- ONSDAG-->Very busy</span></td></tr><tr><td valign=\"top\" align=\"left\" class=\"row1\"><span class=\"genmed\"><strong>Thu</strong></span></td><td class=\"row1\"><span class=\"gensmall\"><!-- TORSDAG-->Lazy</span></td></tr><tr><td valign=\"top\" align=\"left\" class=\"row2\"><span class=\"genmed\"><strong>Fri</strong></span></td><td class=\"row2\"><span class=\"gensmall\"><!-- FREDAG-->Resting...</span></td></tr></tbody></table><p>This basic table structure is a nice demonstration in which the wysiwyg editor comes in handy!</p><p>Try it out! <br />(to edit use the top right edit button)</p><p>Note: The wysiwyg editor is a 3rd party product (tinyMCE), and must be installed separately. Visit <a target=\"_blank\" href=\"http://www.moxiecode.com\">Moxiecode Systems AB</a> to get the software and place the \'tinymce\' folder in the root/modules/mx_shared directory. </p>", "0", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("32", "63", "Vertical", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("27", "70", "x_iframe", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("27", "71", "/docs", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("27", "72", "325", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("27", "73", "", "", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("28", "15", "[b:787bdbfe25]MX-Publisher[/b:787bdbfe25] is a fully modular CMS, featuring dynamic pages, blocks, styles, and more (eg modules) by means of a powerful yet flexible AdminCP. It works standalone or with phpBB2/phpBB3 by using integrated features and functions. MX-Publisher currently supports the mySQL and postgreSQL databases. MX-Publisher is the classical phpBB portal add-on, improved and enhanced for every phpBB version released since 2001.\r\n\r\n[i:787bdbfe25]Welcome, and thanks for using MX-Publisher![/i:787bdbfe25]", "787bdbfe25", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("29", "15", "On this page we [i:6d09b58ee2]demonstrate[/i:6d09b58ee2] how subpages are easily created, using the CORE dynamic block and the user navigation block. Create new textblocks in the adminCP, and add them in the navigation menu. Have fun!\r\n\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas malesuada semper ante. Aliquam orci ipsum, aliquam sodales, dictum id, tincidunt non, elit. Proin tincidunt felis id urna. Praesent in erat. Nunc at arcu et nisi tempor interdum. Quisque enim. Nunc et lorem. Ut tortor. Suspendisse potenti. Nam egestas orci at mi. Sed pulvinar est sit amet ante. Mauris pharetra mollis risus. Donec accumsan fermentum leo.", "6d09b58ee2", "0");
INSERT INTO `mx_table_block_system_parameter` VALUES("30", "15", "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas malesuada semper ante. Aliquam orci ipsum, aliquam sodales, dictum id, tincidunt non, elit. Proin tincidunt felis id urna. Praesent in erat. Nunc at arcu et nisi tempor interdum. Quisque enim. Nunc et lorem. Ut tortor. Suspendisse potenti. Nam egestas orci at mi. Sed pulvinar est sit amet ante. Mauris pharetra mollis risus. Donec accumsan fermentum leo.\r\n\r\nSuspendisse potenti. Quisque tincidunt, mi viverra semper iaculis, nisl metus vehicula libero, eget tincidunt est massa ac purus. Aenean a justo. Sed ultrices, mi vitae hendrerit suscipit, mauris velit rutrum lectus, eget pharetra metus ipsum in purus. Sed placerat ornare nulla. Nullam vel leo non nulla fermentum varius. Integer nec pede a velit tempor aliquam. Sed eu neque in eros scelerisque eleifend. Vivamus id urna. Pellentesque nec nulla. Fusce et sapien. Nulla venenatis imperdiet ligula. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin vel nunc eu leo malesuada congue. Praesent faucibus. Vivamus quis sapien in dolor gravida vehicula.", "61fc3afdd8", "0");



#
# Table structure for table 'mx_table_column'
#
DROP TABLE IF EXISTS `mx_table_column`;
CREATE TABLE `mx_table_column` (
  `column_id` smallint(5) unsigned NOT NULL auto_increment,
  `column_title` varchar(100),
  `column_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `bbcode_uid` varchar(10),
  `column_size` varchar(5) DEFAULT '100%',
  `page_id` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`column_id`),
   KEY cat_order (`column_order`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_column'
#
INSERT INTO `mx_table_column` VALUES("2", "Main", "35", NULL, "100%", "1");
INSERT INTO `mx_table_column` VALUES("6", "Main", "50", NULL, "100%", "3");
INSERT INTO `mx_table_column` VALUES("5", "Left", "40", NULL, "200", "3");
INSERT INTO `mx_table_column` VALUES("1", "Left", "25", NULL, "200", "1");
INSERT INTO `mx_table_column` VALUES("10", "Main", "50", NULL, "100%", "5");
INSERT INTO `mx_table_column` VALUES("9", "Left", "40", NULL, "200", "5");



#
# Table structure for table 'mx_table_column_block'
#
DROP TABLE IF EXISTS `mx_table_column_block`;
CREATE TABLE `mx_table_column_block` (
  `column_id` smallint(5) NOT NULL DEFAULT '0',
  `block_id` smallint(5) NOT NULL DEFAULT '0',
  `block_order` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`column_id`,`block_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_column_block'
#
INSERT INTO `mx_table_column_block` VALUES("2", "19", "20");
INSERT INTO `mx_table_column_block` VALUES("2", "28", "10");
INSERT INTO `mx_table_column_block` VALUES("1", "8", "10");
INSERT INTO `mx_table_column_block` VALUES("9", "21", "10");
INSERT INTO `mx_table_column_block` VALUES("6", "4", "20");
INSERT INTO `mx_table_column_block` VALUES("5", "32", "10");
INSERT INTO `mx_table_column_block` VALUES("10", "15", "10");



#
# Table structure for table 'mx_table_column_templates'
#
DROP TABLE IF EXISTS `mx_table_column_templates`;
CREATE TABLE `mx_table_column_templates` (
  `column_template_id` smallint(5) unsigned NOT NULL auto_increment,
  `column_title` varchar(100) DEFAULT '0',
  `column_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `column_size` varchar(5) DEFAULT '0',
  `page_template_id` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`column_template_id`),
   KEY cat_order (`column_order`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_column_templates'
#
INSERT INTO `mx_table_column_templates` VALUES("1", "Left", "40", "200", "2");
INSERT INTO `mx_table_column_templates` VALUES("2", "Main", "50", "100%", "2");
INSERT INTO `mx_table_column_templates` VALUES("3", "Main", "10", "100%", "3");
INSERT INTO `mx_table_column_templates` VALUES("4", "Right", "20", "200", "3");
INSERT INTO `mx_table_column_templates` VALUES("5", "Left", "10", "180", "4");
INSERT INTO `mx_table_column_templates` VALUES("6", "Middle", "20", "100%", "4");
INSERT INTO `mx_table_column_templates` VALUES("7", "Right", "30", "180", "4");



#
# Table structure for table 'mx_table_function'
#
DROP TABLE IF EXISTS `mx_table_function`;
CREATE TABLE `mx_table_function` (
  `function_id` smallint(5) unsigned NOT NULL auto_increment,
  `module_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `function_name` varchar(150),
  `function_desc` text,
  `function_file` varchar(255),
  `function_admin` varchar(255),
  PRIMARY KEY (`function_id`),
   KEY module_id (`module_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_function'
#
INSERT INTO `mx_table_function` VALUES("51", "50", "User Navigation", "Advanced menus", "mx_menu_nav.php", "");
INSERT INTO `mx_table_function` VALUES("52", "50", "Page Navigation", "Standard Page Menus", "mx_site_nav.php", "");
INSERT INTO `mx_table_function` VALUES("6", "10", "Language Select", "Quick Language Select Block", "mx_language.php", "");
INSERT INTO `mx_table_function` VALUES("7", "10", "Login", "Login Block", "mx_login.php", "");
INSERT INTO `mx_table_function` VALUES("12", "10", "Style Select", "Quick Style Select Block", "mx_theme.php", "");
INSERT INTO `mx_table_function` VALUES("4", "10", "Google Search", "Simple Google Search Block", "mx_google.php", "");
INSERT INTO `mx_table_function` VALUES("13", "10", "Who is Online", "Who is Online Block", "mx_online.php", "");
INSERT INTO `mx_table_function` VALUES("11", "10", "Split Block", "Split columns, put blocks side by side", "mx_multiple_blocks.php", "");
INSERT INTO `mx_table_function` VALUES("24", "20", "TextBlock (phpBB)", "BBcodes, html and smilies - phpBB style", "mx_textblock_bbcode.php", "");
INSERT INTO `mx_table_function` VALUES("23", "20", "TextBlock (HTML/WYSIWYG)", "User friendly textblocks", "mx_textblock_html.php", "");
INSERT INTO `mx_table_function` VALUES("22", "20", "TextBlock (Customized)", "Textblock, featuring block defined settings", "mx_textblock_multi.php", "");
INSERT INTO `mx_table_function` VALUES("5", "10", "IncludeX", "Include Whatever", "mx_includex.php", "");
INSERT INTO `mx_table_function` VALUES("3", "10", "DynamicBlock", "SubBlocks on the same page", "mx_dynamic.php", "");
INSERT INTO `mx_table_function` VALUES("10", "10", "Site Log", "Admin Site Log monitor", "mx_site_log.php", "");
INSERT INTO `mx_table_function` VALUES("15", "10", "Site Search", "Textblock Search Block", "mx_search.php", "");



#
# Table structure for table 'mx_table_menu_categories'
#
DROP TABLE IF EXISTS `mx_table_menu_categories`;
CREATE TABLE `mx_table_menu_categories` (
  `block_id` smallint(5) unsigned NOT NULL default '1',
  `cat_id` mediumint(8) unsigned NOT NULL auto_increment,
  `cat_title` varchar(100),
  `cat_order` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `bbcode_uid` varchar(10),
  `cat_desc` text,
  `cat_show` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cat_url` smallint(5) unsigned DEFAULT '0',
  `cat_target` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`),
   KEY cat_order (`cat_order`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_menu_categories'
#
INSERT INTO `mx_table_menu_categories` VALUES("8", "1", "Resources", "20", "c1affc0aaa", "", "0", "0", "0");
INSERT INTO `mx_table_menu_categories` VALUES("8", "3", "Home", "10", "eab7a16ce5", "", "1", "1", "0");
INSERT INTO `mx_table_menu_categories` VALUES("32", "7", "Demo", "10", "", "", "1", "0", "0");



#
# Table structure for table 'mx_table_menu_nav'
#
DROP TABLE IF EXISTS `mx_table_menu_nav`;
CREATE TABLE `mx_table_menu_nav` (
  `menu_id` smallint(5) unsigned NOT NULL auto_increment,
  `cat_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `menu_name` varchar(150),
  `menu_desc` text,
  `menu_links` varchar(255),
  `auth_view` tinyint(2) NOT NULL DEFAULT '0',
  `menu_order` smallint(5) unsigned DEFAULT '0',
  `bbcode_uid` varchar(10),
  `menu_icon` varchar(255),
  `menu_alt_icon` varchar(255),
  `menu_alt_icon_hot` varchar(255),
  `function_id` smallint(5) unsigned DEFAULT '0',
  `block_id` smallint(8) NOT NULL DEFAULT '0',
  `page_id` smallint(5) unsigned DEFAULT '0',
  `auth_view_group` smallint(5) NOT NULL DEFAULT '0',
  `link_target` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`),
   KEY cat_id (`cat_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_menu_nav'
#
INSERT INTO `mx_table_menu_nav` VALUES("5", "1", "phpBB Home", "", "http://www.phpbb.com", "0", "20", "a9ff189bf5", "icon_info.gif", "", "", "0", "0", "0", "0", "1");
INSERT INTO `mx_table_menu_nav` VALUES("16", "7", "Page 1", "", "", "0", "10", "", "icon_home.gif", "", "", "0", "0", "3", "0", "0");
INSERT INTO `mx_table_menu_nav` VALUES("4", "1", "MX-Publisher Home", "", "http://www.mx-publisher.com", "0", "10", "1f171544ea", "icon_info.gif", "", "", "0", "0", "0", "0", "1");
INSERT INTO `mx_table_menu_nav` VALUES("6", "1", "Demo Page", "On this page we demonstrate a basic subpage setup with textblocks.", "", "0", "30", "", "icon_message.gif", "", "", "0", "0", "3", "0", "0");
INSERT INTO `mx_table_menu_nav` VALUES("1", "3", "Welcome to MXP", "Back to home", "", "0", "10", "", "", "", "", "0", "0", "1", "0", "0");
INSERT INTO `mx_table_menu_nav` VALUES("17", "7", "Page 2", "", "", "0", "20", "", "icon_dot.gif", "", "", "0", "30", "3", "0", "0");
INSERT INTO `mx_table_menu_nav` VALUES("18", "7", "Page 3", "", "", "0", "30", "", "icon_dot.gif", "", "", "0", "1", "3", "0", "0");
INSERT INTO `mx_table_menu_nav` VALUES("19", "7", "WYSIWYG", "", "", "0", "40", "", "icon_dot.gif", "", "", "0", "10", "3", "0", "0");
INSERT INTO `mx_table_menu_nav` VALUES("20", "7", "CUSTOM", "", "", "0", "50", "", "icon_dot.gif", "", "", "0", "9", "3", "0", "0");



#
# Table structure for table 'mx_table_module'
#
DROP TABLE IF EXISTS `mx_table_module`;
CREATE TABLE `mx_table_module` (
  `module_id` smallint(5) unsigned NOT NULL auto_increment,
  `module_name` varchar(150),
  `module_path` varchar(255),
  `module_desc` text,
  `module_include_admin` char(1) DEFAULT '0',
  `module_version` varchar(255),
  `module_copy` text,
  PRIMARY KEY (`module_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_module'
#
INSERT INTO `mx_table_module` VALUES("10", "Core Blocks", "modules/mx_coreblocks/", "MX-Publisher Core Blocks", "", "MX-Publisher Core Module", "Original mxBB <i>Core Blocks</i> module by <a href=\"http://www.mx-publisher.com\" target=\"_blank\">The MX-Publisher Development Team</a>");
INSERT INTO `mx_table_module` VALUES("20", "Textblocks", "modules/mx_textblocks/", "MX-Publisher Textblocks", "", "MX-Publisher Core Module", "Original mxBB <i>Textblocks</i> module by <a href=\"http://www.mx-publisher.com\" target=\"_blank\">Jon</a>");
INSERT INTO `mx_table_module` VALUES("40", "Users and Groups", "modules/mx_users/", "MX-Publisher Users and Groups", "1", "MX-Publisher Core Module", "Based on original phpBB <i>Admin Tool MODs</i> by Adam Alkins, Omar Ramadan & wGEric :: Adapted for MX-Publisher by <a href=\"http://www.mx-publisher.com\" target=\"_blank\">Jon</a>");
INSERT INTO `mx_table_module` VALUES("50", "Navigation Menu", "modules/mx_navmenu/", "MX-Publisher Site Navigation", "", "MX-Publisher Core Module", "Original mxBB <i>Navigation Menu</i> module by <a href=\"http://www.mx-publisher.com\" target=\"_blank\">Jon</a>");



#
# Table structure for table 'mx_table_page'
#
DROP TABLE IF EXISTS `mx_table_page`;
CREATE TABLE `mx_table_page` (
  `page_id` smallint(5) NOT NULL auto_increment,
  `page_name` varchar(255),
  `page_desc` varchar(255),
  `page_parent` int(50) DEFAULT '0',
  `parents_data` mediumtext NOT NULL,
  `page_order` smallint(5) DEFAULT '0',
  `page_icon` varchar(255),
  `page_alt_icon` varchar(255),
  `menu_icon` varchar(255),
  `menu_alt_icon` varchar(255),
  `menu_alt_icon_hot` varchar(255),
  `menu_active` tinyint(2) DEFAULT '1',
  `auth_view` tinyint(2) NOT NULL DEFAULT '0',
  `auth_view_group` varchar(255) NOT NULL DEFAULT '0',
  `auth_moderator_group` varchar(255) NOT NULL DEFAULT '0',
  `default_style` smallint(5) NOT NULL DEFAULT '-1',
  `override_user_style` smallint(2) NOT NULL DEFAULT '-1',
  `page_header` varchar(255) DEFAULT '',
  `page_footer` varchar(255) DEFAULT '',
  `page_main_layout` varchar(255) DEFAULT '',
  `navigation_block` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ip_filter` varchar(255) NOT NULL DEFAULT '',
  `phpbb_stats` tinyint(2) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`page_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_page'
#
INSERT INTO `mx_table_page` VALUES("1", "Home", "This is the startpage", "0", "", "10", "icon_home.gif", "", "none", "", "", "1", "0", "0", "0", "-1", "-1", "", "", "", "0", "a:1:{i:0;s:0:\"\";}", "-1");
INSERT INTO `mx_table_page` VALUES("3", "Demo Page", "Block Demos", "0", "", "30", "icon_docs.gif", "", "", "", "", "1", "0", "0", "0", "-1", "-1", "", "", "", "0", "a:1:{i:0;s:0:\"\";}", "-1");
INSERT INTO `mx_table_page` VALUES("5", "Site Search", "Site Search page", "0", "", "50", "icon_search.gif", "", "", "", "", "1", "0", "0", "0", "-1", "-1", "", "", "", "0", "a:1:{i:0;s:0:\"\";}", "-1");



#
# Table structure for table 'mx_table_page_templates'
#
DROP TABLE IF EXISTS `mx_table_page_templates`;
CREATE TABLE `mx_table_page_templates` (
  `page_template_id` smallint(3) unsigned NOT NULL auto_increment,
  `template_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`page_template_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_page_templates'
#
INSERT INTO `mx_table_page_templates` VALUES("1", "NONE");
INSERT INTO `mx_table_page_templates` VALUES("2", "Two-Columns left");
INSERT INTO `mx_table_page_templates` VALUES("3", "Two-Columns right");
INSERT INTO `mx_table_page_templates` VALUES("4", "Three-Columns");



#
# Table structure for table 'mx_table_parameter'
#
DROP TABLE IF EXISTS `mx_table_parameter`;
CREATE TABLE `mx_table_parameter` (
  `parameter_id` smallint(5) unsigned NOT NULL auto_increment,
  `function_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `parameter_name` varchar(150),
  `parameter_type` varchar(30),
  `parameter_default` varchar(150),
  `parameter_function` varchar(255),
  `parameter_auth` tinyint(2) NOT NULL DEFAULT '0',
  `parameter_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`parameter_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Dumping data for table 'mx_table_parameter'
#
INSERT INTO `mx_table_parameter` VALUES("15", "24", "Text", "phpBBTextBlock", "Insert your text here", "", "0", "0");
INSERT INTO `mx_table_parameter` VALUES("16", "23", "Html", "WysiwygTextBlock", "Entre your Html code here", "", "0", "0");
INSERT INTO `mx_table_parameter` VALUES("50", "22", "Text", "CustomizedTextBlock", "Enter your block text here", "", "0", "0");
INSERT INTO `mx_table_parameter` VALUES("51", "22", "text_style", "Text", "none", "", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("52", "22", "block_style", "Boolean", "TRUE", "", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("53", "22", "title_style", "Boolean", "TRUE", "", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("91", "10", "log_filter_date", "Menu_single_select", "1 month", "a:12:{i:0;s:8:\"no limit\";i:1;s:5:\"1 day\";i:2;s:6:\"2 days\";i:3;s:6:\"3 days\";i:4;s:6:\"1 week\";i:5;s:7:\"2 weeks\";i:6;s:7:\"3 weeks\";i:7;s:7:\"1 month\";i:8;s:8:\"2 months\";i:9;s:8:\"3 months\";i:10;s:8:\"6 months\";i:11;s:6:\"1 year\";}", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("60", "11", "block_ids", "Function", "1,2,3", "get_list_multiple( \"{parameter_id}[]\", BLOCK_TABLE, \'block_id\', \'block_title\', \"{parameter_value}\", TRUE, \'block_desc\')", "0", "0");
INSERT INTO `mx_table_parameter` VALUES("61", "11", "block_sizes", "Text", "20%,30%,*", "", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("62", "11", "space_between", "Number", "4", "", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("80", "3", "default_block_id", "Function", "0", "get_list_formatted(\"block_list\",\"{parameter_value}\",\"{parameter_id}[]\")", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("70", "5", "x_mode", "Menu_single_select", "x_iframe", "a:6:{i:0;s:8:\"x_listen\";i:1;s:8:\"x_iframe\";i:2;s:10:\"x_textfile\";i:3;s:12:\"x_multimedia\";i:4;s:5:\"x_pic\";i:5;s:8:\"x_format\";}", "0", "0");
INSERT INTO `mx_table_parameter` VALUES("71", "5", "x_1", "Text", "/docs", "", "0", "0");
INSERT INTO `mx_table_parameter` VALUES("72", "5", "x_2", "Text", "325", "", "0", "0");
INSERT INTO `mx_table_parameter` VALUES("73", "5", "x_3", "Text", "", "", "0", "0");
INSERT INTO `mx_table_parameter` VALUES("66", "51", "Nav menu", "nav_menu", "", "", "0", "10");
INSERT INTO `mx_table_parameter` VALUES("93", "51", "menu_custom_tpl", "Text", "", "", "1", "20");
INSERT INTO `mx_table_parameter` VALUES("63", "51", "menu_display_mode", "Radio_single_select", "Vertical", "a:3:{i:0;s:8:\"Vertical\";i:1;s:10:\"Horizontal\";i:2;s:18:\"Overall_navigation\";}", "1", "30");
INSERT INTO `mx_table_parameter` VALUES("100", "52", "Site menu", "site_menu", "", "", "0", "10");
INSERT INTO `mx_table_parameter` VALUES("101", "52", "menu_custom_tpl", "Text", "", "", "1", "20");
INSERT INTO `mx_table_parameter` VALUES("102", "52", "menu_display_mode", "Radio_single_select", "Overall_navigation", "a:3:{i:0;s:8:\"Vertical\";i:1;s:10:\"Horizontal\";i:2;s:18:\"Overall_navigation\";}", "1", "30");
INSERT INTO `mx_table_parameter` VALUES("92", "10", "numOfEvents", "Number", "5", "", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("57", "22", "allow_smilies", "Boolean", "TRUE", "", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("54", "22", "allow_html", "Boolean", "TRUE", "", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("56", "22", "allow_bbcode", "Boolean", "TRUE", "", "1", "0");
INSERT INTO `mx_table_parameter` VALUES("55", "22", "html_tags", "Text", "b,i,u", "", "1", "0");



#
# Table structure for table 'mx_table_portal'
#
DROP TABLE IF EXISTS `mx_table_portal`;
CREATE TABLE `mx_table_portal` (
  `portal_id` smallint(2) unsigned NOT NULL auto_increment,
  `portal_name` varchar(255) NOT NULL DEFAULT 'yourdomain.com',
  `portal_desc` varchar(255) NOT NULL DEFAULT 'A _little_ text to describe your site',
  `portal_status` smallint(2) unsigned NOT NULL DEFAULT '1',
  `disabled_message` varchar(255) NOT NULL DEFAULT 'We are currently upgrading this site with latest MX-Publisher software.',
  `server_name` varchar(255) NOT NULL DEFAULT 'www.myserver.tld',
  `script_path` varchar(255) NOT NULL DEFAULT '/',
  `script_protocol` varchar(255) NOT NULL DEFAULT 'http://',
  `server_port` varchar(255) NOT NULL DEFAULT '80',
  `default_dateformat` varchar(255) NOT NULL DEFAULT 'D M d, Y g:i a',
  `board_timezone` smallint(2) NOT NULL DEFAULT '0',
  `gzip_compress` smallint(2) unsigned NOT NULL DEFAULT '0',
  `mx_use_cache` smallint(2) unsigned NOT NULL DEFAULT '1',
  `mod_rewrite` smallint(2) unsigned NOT NULL DEFAULT '0',
  `cookie_domain` varchar(255) NOT NULL DEFAULT '',
  `cookie_name` varchar(255) NOT NULL DEFAULT 'mxbb30x',
  `cookie_path` varchar(255) NOT NULL DEFAULT '/',
  `cookie_secure` smallint(2) unsigned NOT NULL DEFAULT '0',
  `session_length` varchar(255) NOT NULL DEFAULT '3600',
  `allow_autologin` smallint(2) unsigned NOT NULL DEFAULT '1',
  `max_autologin_time` smallint(2) NOT NULL DEFAULT '0',
  `max_login_attempts` smallint(2) NOT NULL DEFAULT '5',
  `login_reset_time` varchar(255) NOT NULL DEFAULT '30',
  `default_lang` varchar(255) NOT NULL DEFAULT 'english',
  `default_style` smallint(5) NOT NULL DEFAULT '-1',
  `override_user_style` smallint(2) unsigned NOT NULL DEFAULT '1',
  `default_admin_style` smallint(5) NOT NULL DEFAULT '-1',
  `overall_header` varchar(255) NOT NULL DEFAULT 'overall_header_navigation.tpl',
  `overall_footer` varchar(255) NOT NULL DEFAULT 'overall_footer.tpl',
  `main_layout` varchar(255) NOT NULL DEFAULT 'mx_main_layout.tpl',
  `navigation_block` smallint(5) unsigned NOT NULL DEFAULT '31',
  `top_phpbb_links` smallint(2) unsigned NOT NULL DEFAULT '0',
  `allow_html` smallint(2) unsigned NOT NULL DEFAULT '1',
  `allow_html_tags` varchar(255) NOT NULL DEFAULT 'b,i,u,pre',
  `allow_bbcode` smallint(2) unsigned NOT NULL DEFAULT '1',
  `allow_smilies` smallint(2) unsigned NOT NULL DEFAULT '1',
  `smilies_path` varchar(255) NOT NULL DEFAULT 'images/smiles',
  `board_email` varchar(255) NOT NULL DEFAULT 'youraddress@yourdomain.com',
  `board_email_sig` varchar(255) NOT NULL DEFAULT 'Thanks, the MX-Publisher Team',
  `smtp_delivery` smallint(2) unsigned NOT NULL DEFAULT '0',
  `smtp_host` varchar(255) NOT NULL DEFAULT '',
  `smtp_username` varchar(255) NOT NULL DEFAULT '',
  `smtp_password` varchar(255) NOT NULL DEFAULT '',
  `smtp_auth_method` varchar(255) NOT NULL DEFAULT '',
  `portal_version` varchar(255) NOT NULL DEFAULT '',
  `portal_recached` varchar(255) NOT NULL DEFAULT '',
  `portal_backend` varchar(255) NOT NULL DEFAULT 'internal',
  `portal_backend_path` varchar(255) NOT NULL DEFAULT '',
  `portal_startdate` varchar(255) NOT NULL DEFAULT '0',
  `rand_seed` varchar(255) NOT NULL DEFAULT '0',
  `record_online_users` varchar(255) NOT NULL DEFAULT '0',
  `record_online_date` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`portal_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Table structure for table 'mx_table_search_results'
#
DROP TABLE IF EXISTS `mx_table_search_results`;
CREATE TABLE `mx_table_search_results` (
  `search_id` int(11) unsigned NOT NULL default '0',
  `session_id` varchar(32) NOT NULL default '',
  `search_array` text NOT NULL,
  PRIMARY KEY  (`search_id`),
  KEY `session_id` (`session_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Table structure for table 'mx_table_wordlist'
#
DROP TABLE IF EXISTS `mx_table_wordlist`;
CREATE TABLE `mx_table_wordlist` (
  `word_text` varchar(50) binary NOT NULL default '',
  `word_id` mediumint(8) unsigned NOT NULL auto_increment,
  `word_common` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`word_text`),
  KEY `word_id` (`word_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Table structure for table 'mx_table_wordmatch'
#
DROP TABLE IF EXISTS `mx_table_wordmatch`;
CREATE TABLE `mx_table_wordmatch` (
  `block_id` mediumint(8) unsigned NOT NULL default '0',
  `word_id` mediumint(8) unsigned NOT NULL default '0',
  `title_match` tinyint(1) NOT NULL default '0',
  KEY `block_id` (`block_id`),
  KEY `word_id` (`word_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Table structure for table 'mx_table_user_group'
#
DROP TABLE IF EXISTS `mx_table_user_group`;
CREATE TABLE `mx_table_user_group` (
   group_id mediumint(8) DEFAULT '0' NOT NULL,
   user_id mediumint(8) DEFAULT '0' NOT NULL,
   user_pending tinyint(1),
   KEY group_id (group_id),
   KEY user_id (user_id)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



#
# Table structure for table 'mx_table_groups'
#
DROP TABLE IF EXISTS `mx_table_groups`;
CREATE TABLE `mx_table_groups` (
   group_id mediumint(8) NOT NULL auto_increment,
   group_type tinyint(4) DEFAULT '1' NOT NULL,
   group_name varchar(40) NOT NULL,
   group_description varchar(255) NOT NULL,
   group_moderator mediumint(8) DEFAULT '0' NOT NULL,
   group_single_user tinyint(1) DEFAULT '1' NOT NULL,
   PRIMARY KEY (group_id),
   KEY group_single_user (group_single_user)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



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
DROP TABLE IF EXISTS `mx_table_sessions`;
CREATE TABLE `mx_table_sessions` (
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
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



# --------------------------------------------------------
#
# Table structure for table `mx_table_sessions_keys`
#
DROP TABLE IF EXISTS `mx_table_sessions_keys`;
CREATE TABLE `mx_table_sessions_keys` (
  key_id varchar(32) DEFAULT '0' NOT NULL,
  user_id mediumint(8) DEFAULT '0' NOT NULL,
  last_ip varchar(8) DEFAULT '0' NOT NULL,
  last_login int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (key_id, user_id),
  KEY last_login (last_login)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



# --------------------------------------------------------
#
# Table structure for table 'mx_table_users'
#
DROP TABLE IF EXISTS `mx_table_users`;
CREATE TABLE `mx_table_users` (
   user_id mediumint(8) NOT NULL,
   user_active tinyint(1) DEFAULT '1',
   username varchar(25) NOT NULL,
   user_password varchar(32) NOT NULL,
   user_session_time int(11) DEFAULT '0' NOT NULL,
   user_session_page smallint(5) DEFAULT '0' NOT NULL,
   user_lastvisit int(11) DEFAULT '0' NOT NULL,
   user_regdate int(11) DEFAULT '0' NOT NULL,
   user_level tinyint(4) DEFAULT '0',
   user_login_tries smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
   user_last_login_try int(11) DEFAULT '0' NOT NULL,
   user_email varchar(255),
   PRIMARY KEY (user_id),
   KEY user_session_time (user_session_time)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



# -- Users
INSERT INTO `mx_table_users` (user_id, username, user_level, user_regdate, user_password, user_email, user_active) VALUES ( -1, 'Anonymous', 0, 0, '', '', 0);

# -- username: admin    password: admin (change this or remove it once everything is working!)
INSERT INTO `mx_table_users` (user_id, username, user_level, user_regdate, user_password, user_email, user_active) VALUES ( 2, 'Admin', 1, 0, '21232f297a57a5a743894a0e4a801fc3', 'admin@yourdomain.com', 1);

# -- Groups
INSERT INTO `mx_table_groups` (group_id, group_name, group_description, group_single_user) VALUES (1, 'Anonymous', 'Personal User', 1);
INSERT INTO `mx_table_groups` (group_id, group_name, group_description, group_single_user) VALUES (2, 'Admin', 'Personal User', 1);


# -- User -> Group
INSERT INTO `mx_table_user_group` (group_id, user_id, user_pending) VALUES (1, -1, 0);
INSERT INTO `mx_table_user_group` (group_id, user_id, user_pending) VALUES (2, 2, 0);



# --------------------------------------------------------
#
# Table structure for table 'mx_table_themes'
#
DROP TABLE IF EXISTS `mx_table_themes`;
CREATE TABLE `mx_table_themes` (
   themes_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   template_name varchar(30) NOT NULL default '',
   style_name varchar(30) NOT NULL default '',
   head_stylesheet varchar(100) default NULL,
   portal_backend varchar(30) NOT NULL default '',
   PRIMARY KEY  (themes_id)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



INSERT INTO `mx_table_themes` (themes_id, template_name, style_name, head_stylesheet, portal_backend) VALUES (1, 'mxBase1', 'mxBase1', 'mxBase1.css', 'internal');
INSERT INTO `mx_table_themes` (themes_id, template_name, style_name, head_stylesheet, portal_backend) VALUES (2, 'mxBase2', 'mxBase2', 'mxBase2.css', 'internal');
INSERT INTO `mx_table_themes` (themes_id, template_name, style_name, head_stylesheet, portal_backend) VALUES (3, 'mxSilver', 'mxSilver', 'mxSilver.css', 'internal');
INSERT INTO `mx_table_themes` (themes_id, template_name, style_name, head_stylesheet, portal_backend) VALUES (4, 'subSilver', 'subSilver', 'subSilver.css', 'phpbb2');
INSERT INTO `mx_table_themes` (themes_id, template_name, style_name, head_stylesheet, portal_backend) VALUES (5, 'subsilver2', 'subsilver2', 'subsilver2.css', 'phpbb3');
INSERT INTO `mx_table_themes` (themes_id, template_name, style_name, head_stylesheet, portal_backend) VALUES (6, 'prosilver', 'prosilver', 'prosilver.css', 'phpbb3');



# --------------------------------------------------------
#
# Table structure for table 'mx_table_smilies'
#
DROP TABLE IF EXISTS `mx_table_smilies`;
CREATE TABLE `mx_table_smilies` (
   smilies_id smallint(5) UNSIGNED NOT NULL auto_increment,
   code varchar(50),
   smile_url varchar(100),
   emoticon varchar(75),
   PRIMARY KEY (smilies_id)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;



# -- Smilies
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 1, ':D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 2, ':-D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 3, ':grin:', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 4, ':)', 'icon_smile.gif', 'Smile');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 5, ':-)', 'icon_smile.gif', 'Smile');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 6, ':smile:', 'icon_smile.gif', 'Smile');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 7, ':(', 'icon_sad.gif', 'Sad');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 8, ':-(', 'icon_sad.gif', 'Sad');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 9, ':sad:', 'icon_sad.gif', 'Sad');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 10, ':o', 'icon_surprised.gif', 'Surprised');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 11, ':-o', 'icon_surprised.gif', 'Surprised');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 12, ':eek:', 'icon_surprised.gif', 'Surprised');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 13, ':shock:', 'icon_eek.gif', 'Shocked');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 14, ':?', 'icon_confused.gif', 'Confused');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 15, ':-?', 'icon_confused.gif', 'Confused');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 16, ':???:', 'icon_confused.gif', 'Confused');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 17, '8)', 'icon_cool.gif', 'Cool');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 18, '8-)', 'icon_cool.gif', 'Cool');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 19, ':cool:', 'icon_cool.gif', 'Cool');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 20, ':lol:', 'icon_lol.gif', 'Laughing');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 21, ':x', 'icon_mad.gif', 'Mad');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 22, ':-x', 'icon_mad.gif', 'Mad');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 23, ':mad:', 'icon_mad.gif', 'Mad');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 24, ':P', 'icon_razz.gif', 'Razz');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 25, ':-P', 'icon_razz.gif', 'Razz');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 26, ':razz:', 'icon_razz.gif', 'Razz');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 27, ':oops:', 'icon_redface.gif', 'Embarassed');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 28, ':cry:', 'icon_cry.gif', 'Crying or Very sad');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 29, ':evil:', 'icon_evil.gif', 'Evil or Very Mad');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 30, ':twisted:', 'icon_twisted.gif', 'Twisted Evil');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 31, ':roll:', 'icon_rolleyes.gif', 'Rolling Eyes');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 32, ':wink:', 'icon_wink.gif', 'Wink');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 33, ';)', 'icon_wink.gif', 'Wink');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 34, ';-)', 'icon_wink.gif', 'Wink');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 35, ':!:', 'icon_exclaim.gif', 'Exclamation');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 36, ':?:', 'icon_question.gif', 'Question');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 37, ':idea:', 'icon_idea.gif', 'Idea');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 38, ':arrow:', 'icon_arrow.gif', 'Arrow');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 39, ':|', 'icon_neutral.gif', 'Neutral');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 40, ':-|', 'icon_neutral.gif', 'Neutral');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 41, ':neutral:', 'icon_neutral.gif', 'Neutral');
INSERT INTO `mx_table_smilies` (smilies_id, code, smile_url, emoticon) VALUES ( 42, ':mrgreen:', 'icon_mrgreen.gif', 'Mr. Green');



# --------------------------------------------------------
#
# Table structure for table 'mx_table_words'
#
DROP TABLE IF EXISTS `mx_table_words`;
CREATE TABLE `mx_table_words` (
   word_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   word char(100) NOT NULL,
   replacement char(100) NOT NULL,
   PRIMARY KEY (word_id)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;
