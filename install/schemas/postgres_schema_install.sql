--
-- MX-Publisher - PostgreSQL Schema - version 2.8.0
--
-- $Id: postgres_schema_install.sql,v 1.7 2014/05/18 06:24:35 orynider Exp $
--
--
-- Table structure for table `mx_block`
--

DROP TABLE IF EXISTS mx_table_block CASCADE;
CREATE SEQUENCE mx_table_block_seq;
CREATE TABLE "mx_table_block" (
  "block_id" INT2 NOT NULL nextval('mx_table_block_seq'),
  "block_title" VARCHAR(150) NULL DEFAULT NULL,
  "block_desc" TEXT NULL DEFAULT NULL,
  "function_id" INTEGER NULL DEFAULT NULL,
  "auth_view" SMALLINT NOT NULL DEFAULT '0',
  "auth_edit" SMALLINT NOT NULL DEFAULT '0',
  "auth_delete" SMALLINT NOT NULL DEFAULT '0',
  "auth_view_group" VARCHAR(255) NOT NULL DEFAULT '0',
  "auth_edit_group" VARCHAR(255) NOT NULL DEFAULT '0',
  "auth_delete_group" VARCHAR(255) NOT NULL DEFAULT '0',
  "auth_moderator_group" VARCHAR(255) NOT NULL DEFAULT '0',
  "show_title" SMALLINT NOT NULL DEFAULT '1',
  "show_block" SMALLINT NOT NULL DEFAULT '1',
  "show_stats" SMALLINT NOT NULL DEFAULT '0',
  "block_time" VARCHAR(255) NOT NULL DEFAULT '',
  "block_editor_id" INTEGER NOT NULL DEFAULT '0',
  CONSTRAINT mx_table_block_pkey PRIMARY KEY ("block_id")
);

--
-- Dumping data for table 'mx_table_block'
--

INSERT INTO "mx_table_block" VALUES (1,'phpBB TextBlock','This is a Demo Block',24,0,5,0,'0','0','0','0',1,1,1,'1125865999',2);
INSERT INTO "mx_table_block" VALUES (2,'Split Block','This is a Demo Block',11,0,5,0,'0','0','0','0',1,1,0,'1144407740',2);
INSERT INTO "mx_table_block" VALUES (3,'Site Log','This is a Demo Block',10,0,5,0,'0','0','0','0',1,1,0,'1125841954',2);
INSERT INTO "mx_table_block" VALUES (4,'Dynamic Block','This is a Demo Block',3,0,5,0,'0','0','0','0',1,1,0,'1125841802',2);
INSERT INTO "mx_table_block" VALUES (6,'Poll','This is a Demo Block',14,0,5,0,'0','0','0','0',1,1,0,'1125841942',2);
INSERT INTO "mx_table_block" VALUES (7,'Language Select','This is a Demo Block',6,0,5,0,'0','0','0','0',1,1,0,'1125841887',2);
INSERT INTO "mx_table_block" VALUES (8,'Navigation Menu','This is a vertical Navigation Menu Demo Block',51,0,5,0,'0','0','0','0',1,1,0,'1126034018',2);
INSERT INTO "mx_table_block" VALUES (9,'mxBB TextBlock','This is a Demo Block',22,0,5,0,'0','0','0','0',1,1,1,'1144408393',2);
INSERT INTO "mx_table_block" VALUES (10,'WYSIWYG TextBlock','This is a Demo Block',23,0,5,0,'0','0','0','0',1,1,1,'1144408349',2);
INSERT INTO "mx_table_block" VALUES (13,'Login','This is a Demo Block',7,9,5,0,'0','0','0','0',1,1,0,'1125867452',2);
INSERT INTO "mx_table_block" VALUES (14,'Theme Select','This is a Demo Block',12,0,5,0,'0','0','0','0',1,1,0,'1125841964',2);
INSERT INTO "mx_table_block" VALUES (15,'Site Search','Site Search',15,0,5,0,'0','0','0','0',1,1,0,'1125841954',2);
INSERT INTO "mx_table_block" VALUES (16,'Last Message Post','This is a Demo Block',31,0,5,0,'0','0','0','0',1,1,0,'1125842159',2);
INSERT INTO "mx_table_block" VALUES (18,'Announcements','This is a Demo Block',2,0,5,0,'0','0','0','0',1,1,0,'1125868467',2);
INSERT INTO "mx_table_block" VALUES (19,'Who is Online?','This is a Demo Block',13,0,5,0,'0','0','0','0',1,1,0,'1125841983',2);
INSERT INTO "mx_table_block" VALUES (21,'Google','This is a Demo Block',4,0,5,0,'0','0','0','0',1,1,0,'1126033253',2);
INSERT INTO "mx_table_block" VALUES (24,'Forum','This is a Demo Block',8,0,5,0,'0','0','0','0',1,1,0,'1125841817',2);
INSERT INTO "mx_table_block" VALUES (25,'Navigation Menu','This is a horizontal Navigation Menu Demo Block',51,0,5,0,'0','0','0','0',1,1,0,'1144406422',2);
INSERT INTO "mx_table_block" VALUES (26,'Statistics','This is a Demo Block',41,0,5,0,'0','0','0','0',1,1,0,'1125842177',2);
INSERT INTO "mx_table_block" VALUES (27,'IncludeX','This is a Demo Block',5,0,5,0,'0','0','0','0',1,1,0,'1125841878',2);
INSERT INTO "mx_table_block" VALUES (28,'Welcome','This is the firstpage welcome block',24,0,5,0,'0','0','0','0',1,1,1,'1144408417',2);
INSERT INTO "mx_table_block" VALUES (29,'Demo Pages','Introduction',24,0,5,0,'0','0','0','0',1,1,1,'1144407996',2);
INSERT INTO "mx_table_block" VALUES (30,'Modules Info','Introduction',24,0,5,0,'0','0','0','0',1,1,1,'1144407795',2);



--
-- Table structure for table 'mx_table_block_system_parameter'
--

DROP TABLE IF EXISTS mx_table_block_system_parameter CASCADE;
CREATE TABLE "mx_block_system_parameter" (
  "block_id" INTEGER NOT NULL DEFAULT '0',
  "parameter_id" INTEGER NOT NULL DEFAULT '0',
  "parameter_value" TEXT NULL DEFAULT NULL,
  "parameter_opt" TEXT NULL DEFAULT NULL,
  "sub_id" BIGINT NOT NULL DEFAULT '0',
  CONSTRAINT mx_table_block_system_parameter_pkey PRIMARY KEY ("block_id", "parameter_id", "sub_id")
);
CREATE INDEX "mx_table_block_system_parameter_sub_id" ON "mx_table_block_system_parameter" ("sub_id");
CREATE INDEX "mx_table_block_system_parameter_parameter_id" ON "mx_table_block_system_parameter" ("parameter_id");
CREATE INDEX "mx_table_block_system_parameter_block_id" ON "mx_table_block_system_parameter" ("block_id");


INSERT INTO "mx_table_block_system_parameter" VALUES (1,15,'This is a [i:d4ee1ca70a]standard [/i:d4ee1ca70a]TextBlock, featuring BBCode, HTML, and smilies, as defined by the phpBB config settings. Try it out! (to edit use the top right edit button)','d4ee1ca70a',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (2,60,'16,13,9','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (2,61,'33%, 33%,*','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (2,62,'4','',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (3,91,'3 months','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (3,92,'5','',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (4,80,'29','',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (6,36,'',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (6,13,'0',NULL,0);

INSERT INTO "mx_table_block_system_parameter" VALUES (8,66,'','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (8,93,'Classic','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (8,63,'vertical','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (8,64,'TRUE','',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (25,66,'','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (25,93,'Classic','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (25,63,'horizontal','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (25,64,'TRUE','',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (9,50,'This is basically a [i:021a122fa6]standard[/i:021a122fa6] TextBlock, but you may configure settings for bbcodes, html and smilies for [i:021a122fa6]this[/i:021a122fa6] block. Try it out! (to edit use the top right edit button)','021a122fa6',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (9,51,'none','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (9,52,'TRUE','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (9,53,'TRUE','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (9,56,'TRUE','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (9,54,'TRUE','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (9,57,'TRUE','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (9,55,'b,i,u,img','',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (10,16,'<table width="100%" cellpadding="2" border="0"><tbody><tr><td valign="top" align="left" class="row2"><span class="genmed"><strong>Mon</strong></span></td><td class="row2"><span class="gensmall"><!-- MANDAG -->Busy with <em>this and that</em></span></td></tr><tr><td valign="top" align="left" class="row1"><span class="genmed"><strong>Tue</strong></span></td><td class="row1"><span class="gensmall"><!-- TISDAG-->Not so busy</span></td></tr><tr><td valign="top" align="left" class="row2"><span class="genmed"><strong>Wen</strong></span></td><td class="row2"><span class="gensmall"><!-- ONSDAG-->Very busy</span></td></tr><tr><td valign="top" align="left" class="row1"><span class="genmed"><strong>Thu</strong></span></td><td class="row1"><span class="gensmall"><!-- TORSDAG-->Lazy</span></td></tr><tr><td valign="top" align="left" class="row2"><span class="genmed"><strong>Fri</strong></span></td><td class="row2"><span class="gensmall"><!-- FREDAG-->Resting...</span></td></tr></tbody></table><p>This basic table structure is a nice demonstration in which the wysiwyg editor comes in handy!</p><p>Try it out! <br />(to edit use the top right edit button)</p><p>Note: The wysiwyg editor is a 3rd party product (tinyMCE), and must be installed separately. Visit <a target="_blank" href="http://www.moxiecode.com">Moxiecode Systems AB</a> to get the software and place the \'tinymce\' folder in the root/modules/mx_shared directory. </p>','0',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (16,17,'5',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (16,18,'TRUE',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (16,19,'30',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (16,20,'_self',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (16,21,'left',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (16,22,'TRUE',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (16,37,'',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (16,38,'FALSE',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (16,39,'FALSE',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (16,40,'TRUE',NULL,0);
INSERT INTO "mx_table_block_system_parameter" VALUES (16,95,'5',NULL,0);

INSERT INTO "mx_table_block_system_parameter" VALUES (18,1,'3','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (18,2,'10','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (18,3,'TRUE','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (18,4,'TRUE','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (18,5,'FALSE','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (18,7,'thumb_news.gif','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (18,8,'thumb_globe.gif','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (18,9,'thumb_globe.gif','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (18,6,'TRUE','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (18,10,'thumb_globe.gif','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (18,11,'','',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (27,70,'x_iframe','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (27,71,'/docs','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (27,72,'325','',0);
INSERT INTO "mx_table_block_system_parameter" VALUES (27,73,'','',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (28,15,'[b:31f05e4fa3]MX-Publisher[/b:31f05e4fa3] is a fully modular portal and CMS for phpBB, featuring dynamic pages, blocks, themes, and more by means of a powerful yet flexible AdminCP. It works without touching phpBB by using integrated features and functions.  MX-Publisher requires phpBB to run, and currently supports the mySQL and postgreSQL databases, with planned support for MS-SQL and other DBMSs. MX-Publisher is the classical phpBB portal add-on, improved and enhanced for every phpBB version released since 2001.\r\n\r\n[i:31f05e4fa3]Welcome, and thanks for using MX-Publisher![/i:31f05e4fa3] \r\n\r\n :lol:','31f05e4fa3',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (29,15,'On this page we [i:621ded23c6]demonstrate [/i:621ded23c6]a few basic portal blocks (not already present on this or other pages) - to get you started. Please, try out the top links.','621ded23c6',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (30,15,'You may enrich your portal with addon modules - for specific functionality:\r\n\r\n- Download manager\r\n- Picture Album\r\n- Calendar Tools\r\n- Knowledge Base\r\n- Links Gallery\r\n- Games\r\n\r\nand many more. Be sure to visit mxpcms.sourceforge.net for latest available modules!','eacbc1f61a',0);

--
-- Table structure for table 'mx_table_bots'
--
DROP TABLE IF EXISTS `mx_table_bots`;
CREATE SEQUENCE mx_table_bots_seq;
CREATE TABLE IF NOT EXISTS `mx_table_bots` (
  "bot_id" INT4 DEFAULT nextval('mx_table_bots_seq'),
  "bot_active" SMALLINT NOT NULL DEFAULT '-1',
  "block_title" VARCHAR(150) NOT NULL DEFAULT '1',
  "bot_color" VARCHAR(255) NOT NULL DEFAULT '9E8DA7',
  "user_id" INTEGER NOT NULL DEFAULT '0',
  "bot_agent" VARCHAR(255) NOT NULL DEFAULT 'YahooSeeker/',
  "bot_ip" VARCHAR(255) NOT NULL DEFAULT '::f',
  "bot_last_visit" VARCHAR(10) NOT NULL DEFAULT '1617274666',
  "bot_visit_counter" INTEGER NOT NULL DEFAULT '1'
  CONSTRAINT mx_table_bots PRIMARY KEY ("bot_id")
CREATE INDEX "mx_table_bots" ON "mx_table_bots" ("bot_active");

--
-- Table structure for table 'mx_table_column'
--

DROP TABLE IF EXISTS mx_table_column CASCADE;
CREATE SEQUENCE mx_table_column_seq;
CREATE TABLE "mx_table_column" (
  "column_id" INT2 NOT NULL nextval('mx_table_column_seq'),
  "column_title" VARCHAR(100) NULL DEFAULT NULL,
  "column_order" INTEGER NOT NULL DEFAULT '0',
  "bbcode_uid" VARCHAR(10) NULL DEFAULT NULL,
  "column_size" VARCHAR(5) NULL DEFAULT '100%',
  "page_id" SMALLINT NOT NULL DEFAULT '0',
  CONSTRAINT mx_table_column_pkey PRIMARY KEY ("column_id")
);
CREATE INDEX "mx_table_column_cat_order" ON "mx_table_column" ("column_order");


--
-- Dumping data for table 'mx_table_column'
--
INSERT INTO "mx_table_column" VALUES (8,'Main',50,NULL,'100%',4);
INSERT INTO "mx_table_column" VALUES (2,'Main',35,NULL,'100%',1);
INSERT INTO "mx_table_column" VALUES (7,'Left',40,NULL,'200',4);
INSERT INTO "mx_table_column" VALUES (6,'Main',50,NULL,'100%',3);
INSERT INTO "mx_table_column" VALUES (5,'Left',40,NULL,'200',3);
INSERT INTO "mx_table_column" VALUES (4,'Main',50,NULL,'100%',2);
INSERT INTO "mx_table_column" VALUES (1,'Left',25,NULL,'200',1);
INSERT INTO "mx_table_column" VALUES (3,'Left',40,NULL,'200',2);
INSERT INTO "mx_table_column" VALUES (10,'Main',50,NULL,'100%',5);
INSERT INTO "mx_table_column" VALUES (9,'Left',40,NULL,'200',5);


--
-- Table structure for table 'mx_table_column_block'
--

DROP TABLE IF EXISTS mx_table_column_block CASCADE;
CREATE TABLE "mx_table_column_block" (
  "column_id" SMALLINT NOT NULL DEFAULT '0',
  "block_id" SMALLINT NOT NULL DEFAULT '0',
  "block_order" SMALLINT NOT NULL DEFAULT '0',
  CONSTRAINT mx_table_column_block_pkey PRIMARY KEY ("column_id", "block_id")
);

--
-- Dumping data for table 'mx_table_column_block'
--
INSERT INTO "mx_table_column_block" VALUES (5, 14, 40);
INSERT INTO "mx_table_column_block" VALUES (4, 19, 20);
INSERT INTO "mx_table_column_block" VALUES (8, 19, 20);
INSERT INTO "mx_table_column_block" VALUES (4, 24, 10);
INSERT INTO "mx_table_column_block" VALUES (1, 13, 30);
INSERT INTO "mx_table_column_block" VALUES (3, 16, 20);
INSERT INTO "mx_table_column_block" VALUES (5, 3, 30);
INSERT INTO "mx_table_column_block" VALUES (2, 19, 20);
INSERT INTO "mx_table_column_block" VALUES (2, 28, 10);
INSERT INTO "mx_table_column_block" VALUES (1, 8, 10);
INSERT INTO "mx_table_column_block" VALUES (6, 25, 10);
INSERT INTO "mx_table_column_block" VALUES (8, 26, 10);
INSERT INTO "mx_table_column_block" VALUES (7, 8, 10);
INSERT INTO "mx_table_column_block" VALUES (6, 4, 20);
INSERT INTO "mx_table_column_block" VALUES (5, 8, 10);
INSERT INTO "mx_table_column_block" VALUES (6, 19, 30);
INSERT INTO "mx_table_column_block" VALUES (5, 7, 20);
INSERT INTO "mx_table_column_block" VALUES (3, 13, 30);
INSERT INTO "mx_table_column_block" VALUES (3, 8, 10);
INSERT INTO "mx_table_column_block" VALUES (10, 15, 10);
INSERT INTO "mx_table_column_block" VALUES (9, 8, 10);

--
-- Table structure for table 'mx_table_column_templates'
--

DROP TABLE IF EXISTS mx_table_column_templates CASCADE;
CREATE TABLE "mx_table_column_templates" (
  "column_template_id" INTEGER NOT NULL ,
  "column_title" VARCHAR(100) NULL DEFAULT '0',
  "column_order" INTEGER NOT NULL DEFAULT '0',
  "column_size" VARCHAR(5) NULL DEFAULT '0',
  "page_template_id" SMALLINT NOT NULL DEFAULT '0',
  CONSTRAINT mx_table_column_templates_pkey PRIMARY KEY (column_template_id)
);
CREATE INDEX "mx_table_column_templates_cat_order" ON "mx_table_column_templates" ("column_order");


--
-- Dumping data for table 'mx_table_column_templates'
--

INSERT INTO "mx_table_column_templates" VALUES (1,'Left',40,'200',2);
INSERT INTO "mx_table_column_templates" VALUES (2,'Main',50,'100%',2);
INSERT INTO "mx_table_column_templates" VALUES (3,'Main',10,'100%',3);
INSERT INTO "mx_table_column_templates" VALUES (4,'Right',20,'200',3);
INSERT INTO "mx_table_column_templates" VALUES (5,'Left',10,'180',4);
INSERT INTO "mx_table_column_templates" VALUES (6,'Middle',20,'100%',4);
INSERT INTO "mx_table_column_templates" VALUES (7,'Right',30,'180',4);

--
-- Table structure for table 'mx_table_function'
--

DROP TABLE IF EXISTS mx_table_function CASCADE;
CREATE SEQUENCE mx_table_functions_seq;
CREATE TABLE "mx_table_function" (
  "function_id" INT2 NOT NULL nextval('mx_table_functions_seq'),
  "module_id" INTEGER NOT NULL DEFAULT '0',
  "function_name" VARCHAR(150) NULL DEFAULT NULL,
  "function_desc" TEXT NULL DEFAULT NULL,
  "function_file" VARCHAR(255) NULL DEFAULT NULL,
  "function_admin" VARCHAR(255) NULL DEFAULT NULL,
  CONSTRAINT mx_table_function_pkey PRIMARY KEY ("function_id")
);
CREATE INDEX "mx_table_function_module_id" ON "mx_table_function" ("module_id");


--
-- Dumping data for table 'mx_table_function'
--
INSERT INTO "mx_table_function" VALUES (8, 30,'phpBB Index','phpBB Index Block','mx_forum.php','');
INSERT INTO "mx_table_function" VALUES (51, 50,'User Navigation Menu','Site Navigation','mx_menu_nav.php','');
INSERT INTO "mx_table_function" VALUES (52, 50,'Site Navigation Menu','Site Navigation','mx_site_nav.php','');
INSERT INTO "mx_table_function" VALUES (14, 30,'mxBB Polls','mxBB Polls','mx_poll.php','');
INSERT INTO "mx_table_function" VALUES (6, 10,'Language Select','Language Select Block','mx_language.php','');
INSERT INTO "mx_table_function" VALUES (7, 10,'Login','Login Block','mx_login.php','');
INSERT INTO "mx_table_function" VALUES (12, 10,'Theme Select','Theme Select Block','mx_theme.php','');
INSERT INTO "mx_table_function" VALUES (4, 10,'Google Search','Google Search Block','mx_google.php','');
INSERT INTO "mx_table_function" VALUES (2, 30,'phpBB Announcements','phpBB Announcements Block','mx_announce.php','');
INSERT INTO "mx_table_function" VALUES (13, 10,'Who is Online','Who is Online Block','mx_online.php','');
INSERT INTO "mx_table_function" VALUES (11, 10,'Split Block','Split Block Function - a block that puts subblocks side by side','mx_multiple_blocks.php','');
INSERT INTO "mx_table_function" VALUES (24, 20,'TextBlock (phpBB)','BBcodes, html and smilies - defined by phpBB config','mx_textblock_bbcode.php','');
INSERT INTO "mx_table_function" VALUES (23, 20,'TextBlock (Html/wysiwyg)','Plain html textblock, or featuring a wysiwyg editor','mx_textblock_html.php','');
INSERT INTO "mx_table_function" VALUES (22, 20,'TextBlock (Customized)','Textblock, featuring block defined settings','mx_textblock_multi.php','');
INSERT INTO "mx_table_function" VALUES (31, 30,'Last Posts','phpBB Last Posts Function','mx_last_msg.php','');
INSERT INTO "mx_table_function" VALUES (41, 30,'Statistics','Site Statistics Function','mx_statistics.php','');
INSERT INTO "mx_table_function" VALUES (5, 10,'IncludeX','Include a iframe, site, multimedia or file','mx_includex.php','');
INSERT INTO "mx_table_function" VALUES (3, 10,'DynamicBlock','Dynamic block, defined by its block_id','mx_dynamic.php','');
INSERT INTO "mx_table_function" VALUES (10, 10,'Site Log','Site Log monitor','mx_site_log.php','');
INSERT INTO "mx_table_function" VALUES (15, 10,'Site Search','Site Search Block','mx_search.php','');

--
-- Table structure for table 'mx_table_menu_categories'
--

DROP TABLE IF EXISTS mx_table_menu_categories CASCADE;
CREATE SEQUENCE mx_table_menu_categories_seq;
CREATE TABLE "mx_table_menu_categories" (
  "block_id" INTEGER NOT NULL DEFAULT '1',
  "cat_id" INT2 NOT NULL nextval('mx_table_mwnu_categories_seq'),
  "cat_title" VARCHAR(100) NULL DEFAULT NULL,
  "cat_order" INTEGER NOT NULL DEFAULT '0',
  "bbcode_uid" VARCHAR(10) NULL DEFAULT NULL,
  "cat_desc" TEXT NULL DEFAULT NULL,
  "cat_show" INTEGER NOT NULL DEFAULT '0',
  "cat_url" INTEGER NULL DEFAULT '0',
  "cat_target" SMALLINT NOT NULL DEFAULT '0',
  CONSTRAINT mx_table_menu_categories_pkey PRIMARY KEY ("cat_id")
);
CREATE INDEX "mx_table_menu_categories_cat_order" ON "mx_table_menu_categories" ("cat_order");


--
-- Dumping data for table 'mx_table_menu_categories'
--
INSERT INTO "mx_table_menu_categories" VALUES (8,1,'Resources',20,'c1affc0aaa','',0,0,0);
INSERT INTO "mx_table_menu_categories" VALUES (8,3,'Home',10,'eab7a16ce5','',1,1,0);
INSERT INTO "mx_table_menu_categories" VALUES (25,4,'Core Blocks',40,'a5abf5b8c4','Demo Core blocks',1,0,0);
INSERT INTO "mx_table_menu_categories" VALUES (25,5,'TextBlocks',50,'fa33545edc','Demo TextBlocks',0,0,0);
INSERT INTO "mx_table_menu_categories" VALUES (25,6,'Modules',60,'7dafcede48','Modules Info',0,0,0);
SELECT setval('public."mx_menu_categories_cat_id_seq"', max("cat_id") ) FROM "mx_table_menu_categories";


--
-- Table structure for table 'mx_table_menu_nav'
--

DROP TABLE IF EXISTS mx_table_menu_nav CASCADE;
CREATE SEQUENCE mx_table_menu_seq;
CREATE TABLE "mx_table_menu_nav" (
  "menu_id" INT2 NOT NULL nextval('mx_table_menu_seq'),
  "cat_id" INTEGER NOT NULL DEFAULT '0',
  "menu_name" VARCHAR(150) NULL DEFAULT NULL,
  "menu_desc" TEXT NULL DEFAULT NULL,
  "menu_links" VARCHAR(255) NULL DEFAULT NULL,
  "auth_view" SMALLINT NOT NULL DEFAULT '0',
  "menu_order" INTEGER NULL DEFAULT '0',
  "bbcode_uid" VARCHAR(10) NULL DEFAULT NULL,
  "menu_icon" VARCHAR(255) NULL DEFAULT NULL,
  "menu_alt_icon" VARCHAR(255) NULL DEFAULT NULL,
  "menu_alt_icon_hot" VARCHAR(255) NULL DEFAULT NULL,
  "function_id" INTEGER NULL DEFAULT '0',
  "block_id" SMALLINT NOT NULL DEFAULT '0',
  "page_id" INTEGER NULL DEFAULT '0',
  "auth_view_group" SMALLINT NOT NULL DEFAULT '0',
  "link_target" SMALLINT NOT NULL DEFAULT '0',
  CONSTRAINT mx_table_menu_nav_pkey PRIMARY KEY ("menu_id")
);
CREATE INDEX "mx_table_menu_nav_cat_id" ON "mx_table_menu_nav" ("cat_id");


--
-- Dumping data for table 'mx_table_menu_nav'
--
INSERT INTO "mx_table_menu_nav" VALUES (7,4,'Split Block','Split block Demo','',0,10,'043673560e','icon_dot.gif',0,2,0,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (8,4,'Google Block','Google Block Demo','',0,20,'795e2489d7','icon_dot.gif',0,21,0,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (9,4,'phpBB Announcements (if any)','phpBB Announcements Demo','',0,30,'29add66982','icon_dot.gif',0,18,0,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (10,4,'IncludeX','IncludeX Demo','',0,40,'f7adaf1201','icon_dot.gif',0,27,0,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (11,4,'phpBB Polls (if any)','phpBB Polls Demo','',0,50,'a80fe73aee','icon_dot.gif',0,6,0,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (12,5,'phpBB TextBlock','phpBB TextBlock Demo','',0,10,'85d178caa8','icon_dot.gif',0,1,3,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (13,5,'WYSIWYG TextBlock','WYSIWYG TextBlock Demo','',0,20,'51e2ddb3a7','icon_dot.gif',0,10,3,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (14,5,'Custom TextBlock','Custom TextBlock Demo','',0,30,'22cb7a4f9f','icon_dot.gif',0,9,3,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (15,6,'Modules Info','Information','',0,10,'630ce0e7f0','icon_dot.gif',0,30,3,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (5,1,'phpBB Home','','http://www.phpbb.com',0,20,'a9ff189bf5','icon_info.gif',0,0,0,0,1);
INSERT INTO "mx_table_menu_nav" VALUES (3,3,'Statistics','Site Statistics','',0,30,'98b16ec029','icon_stats.gif',0,0,4,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (4,1,'MX-Publisher Home','','http://mxpcms.sourceforge.net',0,10,'1f171544ea','icon_info.gif',0,0,0,0,1);
INSERT INTO "mx_table_menu_nav" VALUES (6,1,'Demo Pages','On this page are several demo blocks located','',0,30,'fb028ba583','icon_dot.gif',0,0,3,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (1,3,'Home','Back to home','',0,10,'bb51181967','icon_home.gif',0,0,1,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (2,3,'Forum','phpBB Forum Index','',0,20,'a33e401abc','icon_forum.gif',0,0,2,0,0);


--
-- Table structure for table 'mx_table_module'
--

DROP TABLE IF EXISTS mx_table_module CASCADE;
CREATE SEQUENCE mx_table_module_seq;
CREATE TABLE "mx_table_module" (
  "module_id" INT2 NOT NULL nextval('mx_table_module_seq'),
  "module_name" VARCHAR(150) NULL DEFAULT NULL,
  "module_path" VARCHAR(255) NULL DEFAULT NULL,
  "module_desc" TEXT NULL DEFAULT NULL,
  "module_include_admin" CHAR(1) NULL DEFAULT '0',
  "module_version" VARCHAR(255) NULL DEFAULT NULL,
  "module_copy" TEXT NULL DEFAULT NULL,
  CONSTRAINT mx_table_module_pkey PRIMARY KEY ("module_id")
);


--
-- Dumping data for table 'mx_table_module'
--
INSERT INTO "mx_table_module" VALUES (10,'Core Blocks','modules/mx_coreblocks/','MX-Publisher Core Blocks','','mxBB Core Module','Original mxBB <i>Core Blocks</i> module by <a href="http://mxpcms.sourceforge.net" target="_blank">The MX-Publisher Development Team</a>');
INSERT INTO "mx_table_module" VALUES (20,'Textblocks','modules/mx_textblocks/','MX-Publisher Textblocks','','mxBB Core Module','Original mxBB <i>Textblocks</i> module by <a href="http://mxpcms.sourceforge.net" target="_blank">Jon</a>');
INSERT INTO "mx_table_module" VALUES (30,'phpBB2 Blocks','modules/mx_phpbb2blocks/','MX-Publisher phpBB2 blocks','','mxBB Core Module','Original mxBB <i>phpBB2 Blocks</i> module by <a href="http://mxpcms.sourceforge.net" target="_blank"> The MX-Publisher Development Team</a>');
INSERT INTO "mx_table_module" VALUES (50,'Navigation Menu','modules/mx_navmenu/','MX-Publisher Site Navigation','','mxBB Core Module','Original mxBB <i>Navigation Menu</i> module by <a href="http://mxpcms.sourceforge.net" target="_blank">Jon</a>');


--
-- Table structure for table 'mx_table_page'
--

DROP TABLE IF EXISTS mx_table_page CASCADE;
CREATE SEQUENCE mx_table_page_seq;
CREATE TABLE "mx_table_page" (
  "page_id" INT2 NOT NULL nextval('mx_table_page_seq'),
  "page_name" VARCHAR(255) NULL DEFAULT NULL,
  "page_desc" VARCHAR(255) NULL DEFAULT NULL,
  "page_parent" INTEGER DEFAULT '0',
  "parents_data" TEXT NOT NULL DEFAULT NULL,
  "page_order" SMALLINT NOT NULL DEFAULT '0',
  "page_icon" VARCHAR(255) NULL DEFAULT NULL,
  "page_alt_icon" VARCHAR(255) NULL DEFAULT NULL,
  "menu_icon" VARCHAR(255) NULL DEFAULT NULL,
  "menu_alt_icon" VARCHAR(255) NULL DEFAULT NULL,
  "menu_alt_icon_hot" VARCHAR(255) NULL DEFAULT NULL,
  "menu_active" SMALLINT NOT NULL DEFAULT '1',
  "auth_view" SMALLINT NOT NULL DEFAULT '0',
  "auth_view_group" VARCHAR(255) NOT NULL DEFAULT '0',
  "auth_moderator_group" VARCHAR(255) NOT NULL DEFAULT '0',
  "default_style" SMALLINT NOT NULL DEFAULT '-1',
  "override_user_style" SMALLINT NOT NULL DEFAULT '-1',
  "page_header" VARCHAR(255) NULL DEFAULT '',
  "page_footer" VARCHAR(255) NULL DEFAULT '',
  "page_main_layout" VARCHAR(255) NULL DEFAULT '',
  "navigation_block" INTEGER NOT NULL DEFAULT '0',
  "ip_filter" VARCHAR(255) NOT NULL DEFAULT '',
  "phpbb_stats" SMALLINT NOT NULL DEFAULT '-1',
  CONSTRAINT mx_table_page_pkey PRIMARY KEY ("page_id")
);


--
-- Dumping data for table 'mx_table_page'
--
INSERT INTO "mx_table_page" VALUES (1,'Home','This is the startpage','0','','10','icon_home.gif','','','','','1','0','0','0',-1,-1,'','','','0','a:1:{i:0;s:0:"";}',-1);
INSERT INTO "mx_table_page" VALUES (2,'Forum','This is the phpBB Forum startpage','0','','20','icon_forum.gif','','','','','1','0','0','0',-1,-1,'','','','0','a:1:{i:0;s:0:"";}',1);
INSERT INTO "mx_table_page" VALUES (3,'Demo Page','Block Demos','0','','30','icon_settings.gif','','','','','1','0','0','0',-1,-1,'','','','0','a:1:{i:0;s:0:"";}',-1);
INSERT INTO "mx_table_page" VALUES (4,'Sitestats','Sitestats page','0','','40','icon_statistics.gif','','','','','1','0','0','0',-1,-1,'','','','0','a:1:{i:0;s:0:"";}',-1);
INSERT INTO "mx_table_page" VALUES (5,'Site Search','Site Search page','0','','50','icon_search.gif','','','','','1','0','0','0',-1,-1,'','','','0','a:1:{i:0;s:0:"";}',-1);


--
-- Table structure for table 'mx_table_page_templates'
--

DROP TABLE IF EXISTS mx_table_page_templates CASCADE;
CREATE TABLE "mx_table_page_templates" (
  "page_template_id" INTEGER NOT NULL ,
  "template_name" VARCHAR(255) NOT NULL DEFAULT '',
  CONSTRAINT mx_table_page_templates_pkey PRIMARY KEY ("page_template_id")
);


--
-- Dumping data for table 'mx_table_page_templates'
--
INSERT INTO "mx_table_page_templates" VALUES (1,'NONE');
INSERT INTO "mx_table_page_templates" VALUES (2,'Two-Columns left');
INSERT INTO "mx_table_page_templates" VALUES (3,'Two-Columns right');
INSERT INTO "mx_table_page_templates" VALUES (4,'Three-Columns');


--
-- Table structure for table 'mx_table_parameter'
--

DROP TABLE IF EXISTS mx_table_parameter CASCADE;
CREATE SEQUENCE mx_table_parameter_seq;
CREATE TABLE "mx_table_parameter" (
  "parameter_id" INT2 NOT NULL nextval('mx_table_parameter_seq'),
  "function_id" INTEGER NOT NULL DEFAULT '0',
  "parameter_name" VARCHAR(150) NULL DEFAULT NULL,
  "parameter_type" VARCHAR(30) NULL DEFAULT NULL,
  "parameter_default" VARCHAR(150) NULL DEFAULT NULL,
  "parameter_function" VARCHAR(255) NULL DEFAULT NULL,
  "parameter_auth" SMALLINT NOT NULL DEFAULT '0',
  "parameter_order" INTEGER NOT NULL DEFAULT '0',
  CONSTRAINT mx_table_parameter_pkey PRIMARY KEY ("parameter_id")
);



--
-- Dumping data for table 'mx_table_parameter'
--
INSERT INTO "mx_table_parameter" VALUES (1,2,'announce_nbr_display','Number','1','',0,0);
INSERT INTO "mx_table_parameter" VALUES (2,2,'announce_nbr_days','Number','14','',0,0);
INSERT INTO "mx_table_parameter" VALUES (3,2,'announce_display','Boolean','TRUE','',0,0);
INSERT INTO "mx_table_parameter" VALUES (4,2,'announce_display_sticky','Boolean','TRUE','',0,0);
INSERT INTO "mx_table_parameter" VALUES (5,2,'announce_display_normal','Boolean','FALSE','',0,0);
INSERT INTO "mx_table_parameter" VALUES (7,2,'announce_img','Text','thumb_globe.gif','',0,0);
INSERT INTO "mx_table_parameter" VALUES (8,2,'announce_img_sticky','Text','thumb_globe.gif','',0,0);
INSERT INTO "mx_table_parameter" VALUES (9,2,'announce_img_normal','Text','thumb_globe.gif','',0,0);
INSERT INTO "mx_table_parameter" VALUES (6,2,'announce_display_global','Boolean','TRUE','',0,0);
INSERT INTO "mx_table_parameter" VALUES (10,2,'announce_img_global','Text','thumb_globe.gif','',0,0);
INSERT INTO "mx_table_parameter" VALUES (11,2,'announce_forum','Function','','get_list_multiple("{parameter_id}[]", FORUMS_TABLE, \'forum_id\', \'forum_name\', "{parameter_value}", TRUE)',0,0);

INSERT INTO "mx_table_parameter" VALUES (13,14,'Poll_Display','Function','0','poll_select( {parameter_value}, "{parameter_id}" )',0,0);
INSERT INTO "mx_table_parameter" VALUES (36,14,'poll_forum','Function','','get_list_multiple("{parameter_id}[]", FORUMS_TABLE, \'forum_id\', \'forum_name\', "{parameter_value}", TRUE)',0,0);

INSERT INTO "mx_table_parameter" VALUES (15,24,'Text','phpBBTextBlock','Insert your text here','',0,0);

INSERT INTO "mx_table_parameter" VALUES (16,23,'Html','WysiwygTextBlock','Entre your Html code here','',0,0);

INSERT INTO "mx_table_parameter" VALUES (17,31,'Last_Msg_Number_Title','Number','15','',0,0);
INSERT INTO "mx_table_parameter" VALUES (18,31,'Last_Msg_Display_Date','Boolean','TRUE','',0,0);
INSERT INTO "mx_table_parameter" VALUES (19,31,'Last_Msg_Title_Length','Number','30','',0,0);
INSERT INTO "mx_table_parameter" VALUES (20,31,'Last_Msg_Target','Values','_blank','',0,0);
INSERT INTO "mx_table_parameter" VALUES (21,31,'Last_Msg_Align','Values','left','',0,0);
INSERT INTO "mx_table_parameter" VALUES (22,31,'Last_Msg_Display_Forum','Boolean','TRUE','',0,0);
INSERT INTO "mx_table_parameter" VALUES (37,31,'Last_Msg_forum','Function','','get_list_multiple("{parameter_id}[]", FORUMS_TABLE, \'forum_id\', \'forum_name\', "{parameter_value}", TRUE)',0,0);
INSERT INTO "mx_table_parameter" VALUES (38,31,'Last_Msg_Display_Last_Author','Boolean','TRUE','',0,0);
INSERT INTO "mx_table_parameter" VALUES (39,31,'Last_Msg_Display_Author','Boolean','FALSE','',0,0);
INSERT INTO "mx_table_parameter" VALUES (40,31,'Last_Msg_Display_Icon_View','Boolean','TRUE','',0,0);

INSERT INTO "mx_table_parameter" VALUES (50,22,'Text','CustomizedTextBlock','Enter your block text here','',0,0);
INSERT INTO "mx_table_parameter" VALUES (51,22,'text_style','Text','none','',0,0);
INSERT INTO "mx_table_parameter" VALUES (52,22,'block_style','Boolean','TRUE','',0,0);
INSERT INTO "mx_table_parameter" VALUES (53,22,'title_style','Boolean','TRUE','',0,0);

INSERT INTO "mx_table_parameter" VALUES (91,10,'log_filter_date','Menu_single_select','1 month','a:12:{i:0;s:8:"no limit";i:1;s:5:"1 day";i:2;s:6:"2 days";i:3;s:6:"3 days";i:4;s:6:"1 week";i:5;s:7:"2 weeks";i:6;s:7:"3 weeks";i:7;s:7:"1 month";i:8;s:8:"2 months";i:9;s:8:"3 months";i:10;s:8:"6 months";i:11;s:6:"1 year";}',0,0);

INSERT INTO "mx_table_parameter" VALUES (60,11,'block_ids','Function','1,2,3','get_list_multiple( "{parameter_id}[]", BLOCK_TABLE, \'block_id\', \'block_title\', "{parameter_value}", TRUE, \'block_desc\')',0,0);
INSERT INTO "mx_table_parameter" VALUES (61,11,'block_sizes','Text','20%,30%,*','',0,0);
INSERT INTO "mx_table_parameter" VALUES (62,11,'space_between','Number','4','',0,0);

INSERT INTO "mx_table_parameter" VALUES (80,3,'default_block_id','Function','0','get_list_formatted("block_list","{parameter_value}","{parameter_id}[]")',0,0);

INSERT INTO "mx_table_parameter" VALUES (70,5,'x_mode','Menu_single_select','x_iframe','a:6:{i:0;s:8:"x_listen";i:1;s:8:"x_iframe";i:2;s:10:"x_textfile";i:3;s:12:"x_multimedia";i:4;s:5:"x_pic";i:5;s:8:"x_format";}',0,0);
INSERT INTO "mx_table_parameter" VALUES (71,5,'x_1','Text','/docs','',0,0);
INSERT INTO "mx_table_parameter" VALUES (72,5,'x_2','Text','325','',0,0);
INSERT INTO "mx_table_parameter" VALUES (73,5,'x_3','Text','','',0,0);

INSERT INTO "mx_table_parameter" VALUES (66,51,'Nav menu','nav_menu','','',0,10);
INSERT INTO "mx_table_parameter" VALUES (93,51,'menu_display_style','Radio_single_select','Classic','a:5:{i:0;s:7:"Classic";i:1;s:8:"Advanced";i:2;s:15:"Simple_CSS_menu";i:3;s:17:"Advanced_CSS_menu";i:4;s:18:"Overall_navigation";}',0,20);
INSERT INTO "mx_table_parameter" VALUES (63,51,'menu_display_mode','Radio_single_select','vertical','a:2:{i:0;s:8:"vertical";i:1;s:10:"horizontal";}',0,30);
INSERT INTO "mx_table_parameter" VALUES (64,51,'menu_page_sync','Boolean','0','',0,40);

INSERT INTO "mx_table_parameter" VALUES (100,52,'Site menu','site_menu','','',0,10);
INSERT INTO "mx_table_parameter" VALUES (101,52,'menu_display_style','Radio_single_select','Overall_navigation','a:5:{i:0;s:7:"Classic";i:1;s:8:"Advanced";i:2;s:15:"Simple_CSS_menu";i:3;s:17:"Advanced_CSS_menu";i:4;s:18:"Overall_navigation";}',0,20);
INSERT INTO "mx_table_parameter" VALUES (102,52,'menu_display_mode','Radio_single_select','Horizontal','a:2:{i:0;s:8:"Vertical";i:1;s:10:"Horizontal";}',0,30);
INSERT INTO "mx_table_parameter" VALUES (103,52,'menu_page_sync','Boolean','1','',0,40);

INSERT INTO "mx_table_parameter" VALUES (92,10,'numOfEvents','Number','5','',0,0);

INSERT INTO "mx_table_parameter" VALUES (57,22,'allow_smilies','Boolean','TRUE','',1,0);
INSERT INTO "mx_table_parameter" VALUES (54,22,'allow_html','Boolean','TRUE','',1,0);
INSERT INTO "mx_table_parameter" VALUES (56,22,'allow_bbcode','Boolean','TRUE','',1,0);
INSERT INTO "mx_table_parameter" VALUES (55,22,'html_tags','Text','b,i,u','',1,0);

INSERT INTO "mx_table_parameter" VALUES (95,31,'msg_filter_date','Function','5','get_list_static("{parameter_id}[]",array("no limit", "1 day", "2 days", "3 days", "1 week", "2 weeks", "3 weeks", "1 month", "2 months", "3 months", "6 months", "1 year"),"{parameter_value}")',0,0);


--
-- Table structure for table 'mx_table_portal'
--

DROP TABLE IF EXISTS mx_table_portal CASCADE;
CREATE SEQUENCE mx_table_portal_seq;
CREATE TABLE "mx_table_portal" (
  "portal_id" INT2 NOT NULL nextval('mx_table_portal_seq'),
  "portal_name" varchar(255) NOT NULL DEFAULT 'yourdomain.com',
  "portal_desc" varchar(255) NOT NULL DEFAULT 'A _little_ text to describe your site',
  "portal_status" INT2 NOT NULL DEFAULT '1',
  "disabled_message" varchar(255) NOT NULL DEFAULT 'We are currently upgrading this site with latest MX-Publisher software.',
  "server_name" varchar(255) NOT NULL DEFAULT 'www.myserver.tld',
  "script_path" varchar(255) NOT NULL DEFAULT '/',
  "script_protocol" varchar(255) NOT NULL DEFAULT 'http://',
  "server_port" varchar(255) NOT NULL DEFAULT '80',
  "default_dateformat" varchar(255) NOT NULL DEFAULT 'D M d, Y g:i a',
  "board_timezone" INT2 NOT NULL DEFAULT '0',
  "gzip_compress" INT2 NOT NULL DEFAULT '0',
  "mx_use_cache" INT2 NOT NULL DEFAULT '1',
  "mod_rewrite" INT2 NOT NULL DEFAULT '0',
  "cookie_domain" varchar(255) NOT NULL DEFAULT '',
  "cookie_name" varchar(255) NOT NULL DEFAULT 'mxbb30x',
  "cookie_path" varchar(255) NOT NULL DEFAULT '/',
  "cookie_secure" INT2 NOT NULL DEFAULT '0',
  "session_length" varchar(255) NOT NULL DEFAULT '3600',
  "allow_autologin" INT2 NOT NULL DEFAULT '1',
  "max_autologin_time" INT2 NOT NULL DEFAULT '0',
  "max_login_attempts" INT2 NOT NULL DEFAULT '5',
  "login_reset_time" varchar(255) NOT NULL DEFAULT '30',
  "default_lang" varchar(255) NOT NULL DEFAULT 'english',
  "default_style" INT4 NOT NULL DEFAULT '-1',
  "override_user_style" INT2 NOT NULL DEFAULT '1',
  "default_admin_style" INT4 NOT NULL DEFAULT '-1',
  "overall_header" varchar(255) NOT NULL DEFAULT 'overall_header_navigation.tpl',
  "overall_footer" varchar(255) NOT NULL DEFAULT 'overall_footer.tpl',
  "main_layout" varchar(255) NOT NULL DEFAULT 'mx_main_layout.tpl',
  "navigation_block" INT4 NOT NULL DEFAULT '31',
  "top_phpbb_links" INT2 NOT NULL DEFAULT '0',
  "allow_html" INT2 NOT NULL DEFAULT '1',
  "allow_html_tags" varchar(255) NOT NULL DEFAULT 'b,i,u,pre',
  "allow_bbcode" INT2 NOT NULL DEFAULT '1',
  "allow_smilies" INT2 NOT NULL DEFAULT '1',
  "smilies_path" varchar(255) NOT NULL DEFAULT 'images/smiles',
  "board_email" varchar(255) NOT NULL DEFAULT 'youraddress@yourdomain.com',
  "board_email_sig" varchar(255) NOT NULL DEFAULT 'Thanks, the MX-Publisher Team',
  "smtp_delivery" INT2 NOT NULL DEFAULT '0',
  "smtp_host" varchar(255) NOT NULL DEFAULT '',
  "smtp_username" varchar(255) NOT NULL DEFAULT '',
  "smtp_password" varchar(255) NOT NULL DEFAULT '',
  "smtp_auth_method" varchar(255) NOT NULL DEFAULT '',
  "portal_version" varchar(255) NOT NULL DEFAULT '',
  "portal_recached" varchar(255) NOT NULL DEFAULT '',
  "portal_backend" varchar(255) NOT NULL DEFAULT 'internal',
  "portal_backend_path" varchar(255) NOT NULL DEFAULT '',
  "portal_startdate" varchar(255) NOT NULL DEFAULT '0',
  "rand_seed" varchar(255) NOT NULL DEFAULT '0',
  "record_online_users" varchar(255) NOT NULL DEFAULT '0',
  "record_online_date" varchar(255) NOT NULL DEFAULT '0',
  CONSTRAINT mx_table_portal_pkey PRIMARY KEY ("portal_id")
);

--
-- Dumping data for table `mx_portal`
--

-- INSERT INTO "mx_table_portal" VALUES (1,'MX-Publisher','http://yoursite.com/forum/','http://yoursite.com/','2.8.0',-1,-1,1,'overall_header.tpl','overall_footer.tpl','mx_main_layout.tpl',0,0,1,'1182515561',0,'phpBB2','1','We are currently upgrading this site with latest MX-Publisher software.');

--
-- Table structure for table 'mx_table_search_results'
--

DROP TABLE IF EXISTS mx_table_search_results CASCADE;
CREATE TABLE "mx_search_results" (
  "search_id" BIGINT NOT NULL DEFAULT '0',
  "session_id" VARCHAR(32) NOT NULL DEFAULT '',
  "search_array" TEXT NOT NULL DEFAULT '',
  CONSTRAINT mx_table_search_results_pkey PRIMARY KEY ("search_id")
);
CREATE INDEX "mx_table_search_results_session_id" ON "mx_table_search_results" ("session_id");

--
-- Table structure for table 'mx_table_wordlist'
--

DROP TABLE IF EXISTS mx_table_wordlist CASCADE;
CREATE SEQUENCE mx_table_wordlist_seq;
CREATE TABLE "mx_table_wordlist" (
  "word_id" INT4 DEFAULT nextval('mx_table_wordlist_seq'),
  "word_text" varchar(255) DEFAULT '' NOT NULL,
  "word_common" INT2 DEFAULT '0' NOT NULL CHECK (word_common >= 0),
  "word_count" INT4 DEFAULT '0' NOT NULL CHECK (word_count >= 0),
  "word" varchar(255) DEFAULT '' NOT NULL,
  "replacement" varchar(255) DEFAULT '' NOT NULL,
  CONSTRAINT mx_table_wordlist_pkey PRIMARY KEY ("word_text")
);
CREATE INDEX "mx_table_wordlist_word_id" ON "mx_table_wordlist" ("word_id");

--
-- Table structure for table 'mx_table_wordmatch'
--

DROP TABLE IF EXISTS mx_table_wordmatch CASCADE;
CREATE SEQUENCE mx_table_wordmatch_seq;
CREATE TABLE "mx_table_wordmatch" (
  "block_id" INT4 DEFAULT '0' NOT NULL CHECK (block_id >= 0),
  "word_id" INT4 DEFAULT '0' NOT NULL CHECK (word_id >= 0),
  "title_match" INT2 DEFAULT '0' NOT NULL CHECK (title_match >= 0)
);
CREATE UNIQUE INDEX "mx_table_wordmatch_unq_mtch" ON "mx_table_wordmatch" ("word_id", "block_id", "title_match");
CREATE INDEX "mx_table_wordmatch_block_id" ON "mx_table_wordmatch" ("block_id");
CREATE INDEX "mx_table_wordmatch_word_id" ON "mx_table_wordmatch" ("word_id");

/*
	Table: 'mx_table_user_group'
*/
DROP TABLE IF EXISTS mx_table_user_group CASCADE;
CREATE SEQUENCE mx_table_user_group_seq;
CREATE TABLE "mx_table_user_group" (
	"group_id" INT4 DEFAULT '0' NOT NULL CHECK (group_id >= 0),
	"user_id" INT4 DEFAULT '0' NOT NULL CHECK (user_id >= 0),
	"group_leader" INT2 DEFAULT '0' NOT NULL CHECK (group_leader >= 0),
	"user_pending" INT2 DEFAULT '1' NOT NULL CHECK (user_pending >= 0)
);
CREATE INDEX "mx_table_user_group_group_id" ON "mx_table_user_group" ("group_id");
CREATE INDEX "mx_table_user_group_user_id" ON "mx_table_user_group" ("user_id");
CREATE INDEX "mx_table_user_group_group_leader" ON "mx_table_user_group" ("group_leader");

/*
	Table: 'mx_table_groups'
*/
DROP TABLE IF EXISTS mx_table_groups CASCADE;
CREATE SEQUENCE mx_table_groups_seq;
CREATE TABLE mx_table_groups (
	"group_id" INT4 DEFAULT nextval('mx_table_groups_seq'),
	"group_type" INT2 DEFAULT '1' NOT NULL,
	"group_name" varchar_ci DEFAULT '' NOT NULL,
	"group_description" varchar(4000) DEFAULT '' NOT NULL,
	"group_moderator" INT2 DEFAULT '0' NOT NULL,
	"group_single_user" INT2 DEFAULT '1' NOT NULL,
	"group_display" INT2 DEFAULT '0' NOT NULL CHECK (group_display >= 0),
	"group_avatar" varchar(255) DEFAULT '' NOT NULL,
	"group_avatar_type" INT2 DEFAULT '0' NOT NULL,
	"group_avatar_width" INT2 DEFAULT '0' NOT NULL CHECK (group_avatar_width >= 0),
	"group_avatar_height" INT2 DEFAULT '0' NOT NULL CHECK (group_avatar_height >= 0),
	"group_colour" varchar(6) DEFAULT '' NOT NULL,
	"group_legend" INT2 DEFAULT '1' NOT NULL CHECK (group_legend >= 0),
	PRIMARY KEY ("group_id")
);

CREATE INDEX "mx_table_groups_group_legend_name" ON "mx_table_groups" ("group_legend", "group_name");

/* --------------------------------------------------------
#
# Table structure for table 'mx_table_sessions'
#
# Note that if you are running 3.23.x you may want to make
# this table a type HEAP. This type of table is stored
# within system memory and therefore for big busy boards
# is likely to be noticeably faster than continually
# writing to disk ...
*/
DROP TABLE IF EXISTS mx_table_sessions CASCADE;
CREATE TABLE "mx_table_sessions" (
	"session_id" char(32) DEFAULT '' NOT NULL,
	"session_user_id" INT4 DEFAULT '0' NOT NULL CHECK (session_user_id >= 0),
	"session_start" INT4 DEFAULT '0' NOT NULL CHECK (session_start >= 0),
	"session_time" INT4 DEFAULT '0' NOT NULL CHECK (session_time >= 0),
	"session_ip" varchar(40) DEFAULT '' NOT NULL,
	"session_page" varchar(255) DEFAULT '' NOT NULL,
	"session_logged_in" INT2 DEFAULT '1' NOT NULL CHECK (session_logged_in >= 0),
	"session_admin" INT2 DEFAULT '0' NOT NULL CHECK (session_admin >= 0),
	PRIMARY KEY ("session_id")
);

CREATE INDEX "mx_table_sessions_session_time" ON "mx_table_sessions" ("session_time");
CREATE INDEX "mx_table_sessions_session_user_id" ON "mx_table_sessions" ("session_user_id");

/*
	Table: 'phpbb_sessions_keys'
*/
DROP TABLE IF EXISTS mx_table_sessions_keys CASCADE;
CREATE TABLE "mx_table_sessions_keys" (
	"key_id" char(32) DEFAULT '' NOT NULL,
	"user_id" INT4 DEFAULT '0' NOT NULL CHECK (user_id >= 0),
	"last_ip" varchar(40) DEFAULT '' NOT NULL,
	"last_login" INT4 DEFAULT '0' NOT NULL CHECK (last_login >= 0),
	PRIMARY KEY ("key_id", "user_id")
);

CREATE INDEX "mx_table_sessions_keys_last_login" ON "mx_table_sessions_keys" ("last_login");


/*
	Table: 'mx_table_users'
*/
DROP TABLE IF EXISTS mx_table_users CASCADE;
CREATE SEQUENCE mx_table_users_seq;
CREATE TABLE "mx_table_users" (
	user_id INT4 DEFAULT nextval('mx_table_users_seq'),
	user_type INT2 DEFAULT '0' NOT NULL,
	group_id INT4 DEFAULT '3' NOT NULL CHECK (group_id >= 0),
	user_active INT2 DEFAULT '1',
	user_permissions TEXT DEFAULT '' NOT NULL,
	user_perm_from INT4 DEFAULT '0' NOT NULL CHECK (user_perm_from >= 0),
	user_ip varchar(40) DEFAULT '' NOT NULL,
	user_regdate INT4 DEFAULT '0' NOT NULL CHECK (user_regdate >= 0),
	username varchar_ci DEFAULT '' NOT NULL,
	username_clean varchar_ci DEFAULT '' NOT NULL,
	user_password varchar(40) DEFAULT '' NOT NULL,
	user_passchg INT4 DEFAULT '0' NOT NULL CHECK (user_passchg >= 0),
	user_pass_convert INT2 DEFAULT '0' NOT NULL CHECK (user_pass_convert >= 0),
	user_email varchar(100) DEFAULT '' NOT NULL,
	user_email_hash INT8 DEFAULT '0' NOT NULL,
	user_birthday varchar(10) DEFAULT '' NOT NULL,
	user_lastvisit INT4 DEFAULT '0' NOT NULL CHECK (user_lastvisit >= 0),
	user_lastmark INT4 DEFAULT '0' NOT NULL CHECK (user_lastmark >= 0),
	user_lastpost_time INT4 DEFAULT '0' NOT NULL CHECK (user_lastpost_time >= 0),
	user_lastpage varchar(200) DEFAULT '' NOT NULL,
	user_last_confirm_key varchar(10) DEFAULT '' NOT NULL,
	user_last_search INT4 DEFAULT '0' NOT NULL CHECK (user_last_search >= 0),
	user_warnings INT2 DEFAULT '0' NOT NULL,
	user_last_warning INT4 DEFAULT '0' NOT NULL CHECK (user_last_warning >= 0),
	user_login_attempts INT2 DEFAULT '0' NOT NULL,
	user_inactive_reason INT2 DEFAULT '0' NOT NULL,
	user_inactive_time INT4 DEFAULT '0' NOT NULL CHECK (user_inactive_time >= 0),
	user_posts INT4 DEFAULT '0' NOT NULL CHECK (user_posts >= 0),
	user_lang varchar(30) DEFAULT '' NOT NULL,
	user_timezone decimal(5,2) DEFAULT '0' NOT NULL,
	user_dst INT2 DEFAULT '0' NOT NULL CHECK (user_dst >= 0),
	user_dateformat varchar(30) DEFAULT 'd M Y H:i' NOT NULL,
	user_style INT4 DEFAULT '0' NOT NULL CHECK (user_style >= 0),
	user_rank INT4 DEFAULT '0' NOT NULL CHECK (user_rank >= 0),
	user_colour varchar(6) DEFAULT '' NOT NULL,
	user_new_privmsg INT4 DEFAULT '0' NOT NULL,
	user_unread_privmsg INT4 DEFAULT '0' NOT NULL,
	user_last_privmsg INT4 DEFAULT '0' NOT NULL CHECK (user_last_privmsg >= 0),
	user_message_rules INT2 DEFAULT '0' NOT NULL CHECK (user_message_rules >= 0),
	user_full_folder INT4 DEFAULT '-3' NOT NULL,
	user_emailtime INT4 DEFAULT '0' NOT NULL CHECK (user_emailtime >= 0),
	user_topic_show_days INT2 DEFAULT '0' NOT NULL CHECK (user_topic_show_days >= 0),
	user_topic_sortby_type varchar(1) DEFAULT 't' NOT NULL,
	user_topic_sortby_dir varchar(1) DEFAULT 'd' NOT NULL,
	user_post_show_days INT2 DEFAULT '0' NOT NULL CHECK (user_post_show_days >= 0),
	user_post_sortby_type varchar(1) DEFAULT 't' NOT NULL,
	user_post_sortby_dir varchar(1) DEFAULT 'a' NOT NULL,
	user_notify INT2 DEFAULT '0' NOT NULL CHECK (user_notify >= 0),
	user_notify_pm INT2 DEFAULT '1' NOT NULL CHECK (user_notify_pm >= 0),
	user_notify_type INT2 DEFAULT '0' NOT NULL,
	user_allow_pm INT2 DEFAULT '1' NOT NULL CHECK (user_allow_pm >= 0),
	user_allow_viewonline INT2 DEFAULT '1' NOT NULL CHECK (user_allow_viewonline >= 0),
	user_allow_viewemail INT2 DEFAULT '1' NOT NULL CHECK (user_allow_viewemail >= 0),
	user_allow_massemail INT2 DEFAULT '1' NOT NULL CHECK (user_allow_massemail >= 0),
	user_options INT4 DEFAULT '230271' NOT NULL CHECK (user_options >= 0),
	user_avatar varchar(255) DEFAULT '' NOT NULL,
	user_avatar_type INT2 DEFAULT '0' NOT NULL,
	user_avatar_width INT2 DEFAULT '0' NOT NULL CHECK (user_avatar_width >= 0),
	user_avatar_height INT2 DEFAULT '0' NOT NULL CHECK (user_avatar_height >= 0),
	user_sig TEXT DEFAULT '' NOT NULL,
	user_sig_bbcode_uid varchar(8) DEFAULT '' NOT NULL,
	user_sig_bbcode_bitfield varchar(255) DEFAULT '' NOT NULL,
	user_actkey varchar(32) DEFAULT '' NOT NULL,
	user_newpasswd varchar(40) DEFAULT '' NOT NULL,
	user_form_salt varchar(32) DEFAULT '' NOT NULL,
	user_new INT2 DEFAULT '1' NOT NULL CHECK (user_new >= 0),
	user_reminded INT2 DEFAULT '0' NOT NULL,
	user_reminded_time INT4 DEFAULT '0' NOT NULL CHECK (user_reminded_time >= 0),
	PRIMARY KEY ("user_id")
);

CREATE INDEX "mx_table_users_user_birthday" ON "mx_table_users" ("user_birthday");
CREATE INDEX "mx_table_users_user_email_hash" ON "mx_table_users" ("user_email_hash");
CREATE INDEX "mx_table_users_user_type" ON "mx_table_users" ("user_type");
CREATE UNIQUE INDEX "mx_table_users_username_clean" ON "mx_table_users" ("username_clean");

/* -- Users */
INSERT INTO "mx_table_users" ("user_id", "user_active", "username", "user_password", "user_session_time", "user_session_page", "user_lastvisit", "user_regdate", "user_level", "user_login_tries", "user_last_login_try", "user_email") VALUES('-1', '0', 'Anonymous', '', '0', '0', '0', '1221460256', '0', '0', '0', '');

/* -- username: admin    password: admin (change this or remove it once everything is working!) */
INSERT INTO "mx_table_users" ("user_id", "user_active", "username", "user_password", "user_session_time", "user_session_page", "user_lastvisit", "user_regdate", "user_level", "user_login_tries", "user_last_login_try", "user_email") VALUES('2', '1', 'Admin', '21232f297a57a5a743894a0e4a801fc3', '1223142439', '0', '1221524623', '1221460256', '1', '0', '0', 'admin@localhost');

/* -- Groups */
INSERT INTO "mx_table_groups" ("group_id", "group_name", "group_description", "group_single_user") VALUES (1, 'Anonymous', 'Personal User', 1);
INSERT INTO "mx_table_groups" ("group_id", "group_name", "group_description", "group_single_user") VALUES (2, 'Admin', 'Personal User', 1);


/* -- User -> Group */
INSERT INTO "mx_table_user_group" ("group_id", "user_id", "user_pending") VALUES (1, -1, 0);
INSERT INTO "mx_table_user_group" ("group_id", "user_id", "user_pending") VALUES (2, 2, 0);

DROP TABLE IF EXISTS mx_table_themes CASCADE;
CREATE SEQUENCE mx_table_themes_seq;
CREATE TABLE "mx_table_themes" (
   "themes_id" INT4 DEFAULT nextval('mx_table_themes_seq'),
   "template_name" varchar(255) DEFAULT '' NOT NULL,
   "style_name" varchar(255) DEFAULT '' NOT NULL,
   "head_stylesheet" varchar(100) default NULL,
   "portal_backend" varchar(30) DEFAULT '' NOT NULL,
   PRIMARY KEY  ("themes_id")
);
CREATE UNIQUE INDEX "mx_table_themes_template_name" ON "mx_table_themes" ("template_name");

INSERT INTO "mx_table_themes" ("themes_id", "template_name", "style_name", "head_stylesheet", "portal_backend") VALUES (1, 'mxBase1', 'mxBase1', 'mxBase1.css', 'internal');
INSERT INTO "mx_table_themes" ("themes_id", "template_name", "style_name", "head_stylesheet", "portal_backend") VALUES (2, 'mxBase2', 'mxBase2', 'mxBase2.css', 'internal');
INSERT INTO "mx_table_themes" ("themes_id", "template_name", "style_name", "head_stylesheet", "portal_backend") VALUES (3, 'mxSilver', 'mxSilver', 'mxSilver.css', 'internal');
INSERT INTO "mx_table_themes" ("themes_id", "template_name", "style_name", "head_stylesheet", "portal_backend") VALUES (4, 'subSilver', 'subSilver', 'subSilver.css', 'phpbb2');
INSERT INTO "mx_table_themes" ("themes_id", "template_name", "style_name", "head_stylesheet", "portal_backend") VALUES (5, 'subsilver2', 'subsilver2', 'subsilver2.css', 'phpbb3');
INSERT INTO "mx_table_themes" ("themes_id", "template_name", "style_name", "head_stylesheet", "portal_backend") VALUES (6, 'prosilver', 'prosilver', 'prosilver.css', 'phpbb3');

/*
	Table: 'phpbb_smilies'
*/
DROP TABLE IF EXISTS mx_table_smilies CASCADE;
CREATE SEQUENCE mx_table_smilies_seq;
CREATE TABLE "mx_table_smilies" (
	"smilies_id" INT4 DEFAULT nextval('mx_table_smilies_seq'),
	"code" varchar(50) DEFAULT '' NOT NULL,
	"emoticon" varchar(50) DEFAULT '' NOT NULL,
	"smile_url" varchar(50) DEFAULT '' NOT NULL,
	"smile_width" INT2 DEFAULT '0' NOT NULL CHECK (smiley_width >= 0),
	"smile_height" INT2 DEFAULT '0' NOT NULL CHECK (smiley_height >= 0),
	"smile_order" INT4 DEFAULT '0' NOT NULL CHECK (smiley_order >= 0),
	"display_on_posting" INT2 DEFAULT '1' NOT NULL CHECK (display_on_posting >= 0),
	PRIMARY KEY ("smilies_id")
);

CREATE INDEX "mx_table_smilies_display_on_post" ON "mx_table_smilies" ("display_on_posting");

/* -- Smilies */
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 1, ':D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 2, ':-D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 3, ':grin:', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 4, ':)', 'icon_smile.gif', 'Smile');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 5, ':-)', 'icon_smile.gif', 'Smile');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 6, ':smile:', 'icon_smile.gif', 'Smile');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 7, ':(', 'icon_sad.gif', 'Sad');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 8, ':-(', 'icon_sad.gif', 'Sad');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 9, ':sad:', 'icon_sad.gif', 'Sad');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 10, ':o', 'icon_surprised.gif', 'Surprised');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 11, ':-o', 'icon_surprised.gif', 'Surprised');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 12, ':eek:', 'icon_surprised.gif', 'Surprised');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 13, ':shock:', 'icon_eek.gif', 'Shocked');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 14, ':?', 'icon_confused.gif', 'Confused');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 15, ':-?', 'icon_confused.gif', 'Confused');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 16, ':???:', 'icon_confused.gif', 'Confused');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 17, '8)', 'icon_cool.gif', 'Cool');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 18, '8-)', 'icon_cool.gif', 'Cool');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 19, ':cool:', 'icon_cool.gif', 'Cool');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 20, ':lol:', 'icon_lol.gif', 'Laughing');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 21, ':x', 'icon_mad.gif', 'Mad');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 22, ':-x', 'icon_mad.gif', 'Mad');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 23, ':mad:', 'icon_mad.gif', 'Mad');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 24, ':P', 'icon_razz.gif', 'Razz');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 25, ':-P', 'icon_razz.gif', 'Razz');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 26, ':razz:', 'icon_razz.gif', 'Razz');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 27, ':oops:', 'icon_redface.gif', 'Embarassed');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 28, ':cry:', 'icon_cry.gif', 'Crying or Very sad');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 29, ':evil:', 'icon_evil.gif', 'Evil or Very Mad');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 30, ':twisted:', 'icon_twisted.gif', 'Twisted Evil');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 31, ':roll:', 'icon_rolleyes.gif', 'Rolling Eyes');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 32, ':wink:', 'icon_wink.gif', 'Wink');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 33, ';)', 'icon_wink.gif', 'Wink');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 34, ';-)', 'icon_wink.gif', 'Wink');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 35, ':!:', 'icon_exclaim.gif', 'Exclamation');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 36, ':?:', 'icon_question.gif', 'Question');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 37, ':idea:', 'icon_idea.gif', 'Idea');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 38, ':arrow:', 'icon_arrow.gif', 'Arrow');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 39, ':|', 'icon_neutral.gif', 'Neutral');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 40, ':-|', 'icon_neutral.gif', 'Neutral');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 41, ':neutral:', 'icon_neutral.gif', 'Neutral');
INSERT INTO "mx_table_smilies" ("smilies_id", "code", "smile_url", "emoticon") VALUES ( 42, ':mrgreen:', 'icon_mrgreen.gif', 'Mr. Green');

/*
	Table: 'mx_table_words'
*/
CREATE SEQUENCE mx_table_words_seq;
CREATE TABLE mx_table_words (
	"word_id" INT4 DEFAULT nextval('mx_table_words_seq'),
	"word" varchar(255) DEFAULT '' NOT NULL,
	"replacement" varchar(255) DEFAULT '' NOT NULL,
	PRIMARY KEY ("word_id")
);