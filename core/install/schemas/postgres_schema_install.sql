--
-- mxBB-Portal - PostgreSQL Schema - version 2.8.0
--
-- $Id: postgres_schema_install.sql,v 1.2 2009/01/24 16:47:53 orynider Exp $
--

-- --------------------------------------------------------



--
-- Table structure for table `mx_block`
--

DROP TABLE IF EXISTS mx_table_block CASCADE;

CREATE TABLE "mx_table_block" (
  "block_id" SERIAL,
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

INSERT INTO "mx_table_block_system_parameter" VALUES (28,15,'[b:31f05e4fa3]mxBB-Portal[/b:31f05e4fa3] is a fully modular portal and CMS for phpBB, featuring dynamic pages, blocks, themes, and more by means of a powerful yet flexible AdminCP. It works without touching phpBB by using integrated features and functions.  mxBB-Portal requires phpBB to run, and currently supports the mySQL and postgreSQL databases, with planned support for MS-SQL and other DBMSs. mxBB-Portal is the classical phpBB portal add-on, improved and enhanced for every phpBB version released since 2001.\r\n\r\n[i:31f05e4fa3]Welcome, and thanks for using the mxBB-Portal![/i:31f05e4fa3] \r\n\r\n :lol:','31f05e4fa3',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (29,15,'On this page we [i:621ded23c6]demonstrate [/i:621ded23c6]a few basic portal blocks (not already present on this or other pages) - to get you started. Please, try out the top links.','621ded23c6',0);

INSERT INTO "mx_table_block_system_parameter" VALUES (30,15,'You may enrich your portal with addon modules - for specific functionality:\r\n\r\n- Download manager\r\n- Picture Album\r\n- Calendar Tools\r\n- Knowledge Base\r\n- Links Gallery\r\n- Games\r\n\r\nand many more. Be sure to visit www.mx-publisher.com for latest available modules!','eacbc1f61a',0);



--
-- Table structure for table 'mx_table_column'
--

DROP TABLE IF EXISTS mx_table_column CASCADE;
CREATE TABLE "mx_table_column" (
  "column_id" SERIAL,
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
CREATE TABLE "mx_table_function" (
  "function_id" SERIAL,
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
CREATE TABLE "mx_table_menu_categories" (
  "block_id" INTEGER NOT NULL DEFAULT '1',
  "cat_id" SERIAL,
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
CREATE TABLE "mx_table_menu_nav" (
  "menu_id" SERIAL,
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
INSERT INTO "mx_table_menu_nav" VALUES (4,1,'mxBB Portal Home','','http://mxpcms.sourceforge.net',0,10,'1f171544ea','icon_info.gif',0,0,0,0,1);
INSERT INTO "mx_table_menu_nav" VALUES (6,1,'Demo Pages','On this page are several demo blocks located','',0,30,'fb028ba583','icon_dot.gif',0,0,3,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (1,3,'Home','Back to home','',0,10,'bb51181967','icon_home.gif',0,0,1,0,0);
INSERT INTO "mx_table_menu_nav" VALUES (2,3,'Forum','phpBB Forum Index','',0,20,'a33e401abc','icon_forum.gif',0,0,2,0,0);


--
-- Table structure for table 'mx_table_module'
--

DROP TABLE IF EXISTS mx_table_module CASCADE;
CREATE TABLE "mx_table_module" (
  "module_id" SERIAL,
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
INSERT INTO "mx_table_module" VALUES (10,'Core Blocks','modules/mx_coreblocks/','mxBB Portal Core Blocks','','mxBB Core Module','Original mxBB <i>Core Blocks</i> module by <a href="http://mxpcms.sourceforge.net" target="_blank">The mxBB Development Team</a>');
INSERT INTO "mx_table_module" VALUES (20,'Textblocks','modules/mx_textblocks/','mxBB Portal Textblocks','','mxBB Core Module','Original mxBB <i>Textblocks</i> module by <a href="http://mxpcms.sourceforge.net" target="_blank">Jon</a>');
INSERT INTO "mx_table_module" VALUES (30,'phpBB2 Blocks','modules/mx_phpbb2blocks/','mxBB Portal phpBB2 blocks','','mxBB Core Module','Original mxBB <i>phpBB2 Blocks</i> module by <a href="http://mxpcms.sourceforge.net" target="_blank"> The mxBB Development Team</a>');
INSERT INTO "mx_table_module" VALUES (50,'Navigation Menu','modules/mx_navmenu/','mxBB Portal Site Navigation','','mxBB Core Module','Original mxBB <i>Navigation Menu</i> module by <a href="http://mxpcms.sourceforge.net" target="_blank">Jon</a>');


--
-- Table structure for table 'mx_table_page'
--

DROP TABLE IF EXISTS mx_table_page CASCADE;
CREATE TABLE "mx_table_page" (
  "page_id" SERIAL,
  "page_name" VARCHAR(255) NULL DEFAULT NULL,
  "page_desc" VARCHAR(255) NULL DEFAULT NULL,
  `page_parent` INTEGER DEFAULT '0',
  `parents_data` TEXT NOT NULL DEFAULT NULL,
  `page_order` SMALLINT NOT NULL DEFAULT '0',
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
CREATE TABLE "mx_table_parameter" (
  "parameter_id" SERIAL,
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
CREATE TABLE "mx_table_portal" (
  "portal_id" INTEGER NOT NULL ,
  "portal_name" VARCHAR(150) NULL DEFAULT NULL,
  "portal_phpbb_url" VARCHAR(255) NULL DEFAULT 'http://www.phpbb.com/phpBB/',
  "portal_url" VARCHAR(255) NULL DEFAULT NULL,
  "portal_version" VARCHAR(255) NULL DEFAULT NULL,
  "default_admin_style" SMALLINT NOT NULL DEFAULT '-1',
  "default_style" SMALLINT NOT NULL DEFAULT '-1',
  "override_user_style" SMALLINT NOT NULL DEFAULT '1',
  "overall_header" VARCHAR(255) NULL DEFAULT 'overall_header.tpl',
  "overall_footer" VARCHAR(255) NULL DEFAULT 'overall_footer.tpl',
  "main_layout" VARCHAR(255) NULL DEFAULT 'mx_main_layout.tpl',
  "navigation_block" INTEGER NOT NULL DEFAULT '0',
  "top_phpbb_links" INTEGER NOT NULL DEFAULT '0',
  "mx_use_cache" INTEGER NOT NULL DEFAULT '1',
  "portal_recached" VARCHAR(255) NOT NULL DEFAULT '',
  "mod_rewrite" SMALLINT NOT NULL DEFAULT '0',
  "portal_backend" VARCHAR(255) NULL DEFAULT 'phpbb2',
  "portal_status" SMALLINT NOT NULL DEFAULT '1',
  "disabled_message" VARCHAR(255) NULL DEFAULT '',
  CONSTRAINT mx_table_portal_pkey PRIMARY KEY ("portal_id")
);

--
-- Dumping data for table `mx_portal`
--

-- INSERT INTO "mx_table_portal" VALUES (1,'mxBB-Portal','http://yoursite.com/forum/','http://yoursite.com/','2.8.0',-1,-1,1,'overall_header.tpl','overall_footer.tpl','mx_main_layout.tpl',0,0,1,'1182515561',0,'phpBB2','1','We are currenty upgrading this site with latest mxBB software.');

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
CREATE TABLE "mx_table_wordlist" (
  "word_text" VARCHAR(50) NOT NULL DEFAULT '',
  "word_id" SERIAL NOT NULL ,
  "word_common" BOOLEAN NOT NULL DEFAULT '0',
  CONSTRAINT mx_table_wordlist_pkey PRIMARY KEY ("word_text")
);
CREATE INDEX "mx_table_wordlist_word_id" ON "mx_table_wordlist" ("word_id");




--
-- Table structure for table 'mx_table_wordmatch'
--

DROP TABLE IF EXISTS mx_table_wordmatch CASCADE;
CREATE TABLE "mx_table_wordmatch" (
  "block_id" INTEGER NOT NULL DEFAULT '0',
  "word_id" INTEGER NOT NULL DEFAULT '0',
  "title_match" BOOLEAN NOT NULL DEFAULT '0'
);
CREATE INDEX "mx_table_wordmatch_block_id" ON "mx_table_wordmatch" ("block_id");
CREATE INDEX "mx_table_wordmatch_word_id" ON "mx_table_wordmatch" ("word_id")

