CREATE TABLE mx_table_block (
    block_id SMALLINT NOT NULL IDENTITY(1, 1),
    block_title VARCHAR(150) NULL DEFAULT (NULL),
    block_desc TEXT NULL,
    function_id SMALLINT NULL DEFAULT (NULL),
    auth_view SMALLINT NOT NULL DEFAULT (0),
    auth_edit SMALLINT NULL DEFAULT (0),
    auth_delete SMALLINT NULL DEFAULT (0),
    auth_view_group SMALLINT NOT NULL DEFAULT (0),
    auth_edit_group SMALLINT NOT NULL DEFAULT (0),
    auth_delete_group SMALLINT NOT NULL DEFAULT (0),
    CONSTRAINT mx_table_block_pk PRIMARY KEY (block_id) ON [PRIMARY],
    CHECK (block_id>=0),
    CHECK (function_id>=0)
)  ON [PRIMARY] TEXTIMAGE_ON [PRIMARY];

INSERT INTO mx_table_block VALUES(1,'Welcome','',20,0,5,0,0,0,0);

INSERT INTO mx_table_block VALUES(2,'Multiple Horizontal Blocks','',19,0,0,0,0,0,0);

INSERT INTO mx_table_block VALUES(3,'Demo Textblock Multi','',22,0,5,0,0,0,0);

INSERT INTO mx_table_block VALUES(4,'Demo Textblock BBcode','',20,0,5,0,0,0,0);

INSERT INTO mx_table_block VALUES(5,'Demo Textblock Html','',21,0,5,0,0,0,0);

INSERT INTO mx_table_block VALUES(6,'Poll','',12,0,5,0,0,0,0);

INSERT INTO mx_table_block VALUES(7,'Language Select','',13,99,5,0,0,0,0);

INSERT INTO mx_table_block VALUES(8,'Navigation Menu','',11,0,5,0,0,0,0);

INSERT INTO mx_table_block VALUES(24,'Forum','',10,0,0,0,0,0,0);

INSERT INTO mx_table_block VALUES(13,'Login',NULL,14,99,5,0,0,0,0);

INSERT INTO mx_table_block VALUES(14,'Theme Select','',15,0,5,0,0,0,0);

INSERT INTO mx_table_block VALUES(21,'Google','',16,0,0,0,0,0,0);

INSERT INTO mx_table_block VALUES(18,'Announcements',NULL,17,0,0,0,0,0,0);

INSERT INTO mx_table_block VALUES(19,'Online','',18,0,0,0,0,0,0);

INSERT INTO mx_table_block VALUES(16,'Last Message Post',NULL,30,0,0,0,0,0,0);

INSERT INTO mx_table_block VALUES(32,'Statistics','',40,0,0,0,0,0,0);

CREATE TABLE mx_block_system_parameter (
    block_id SMALLINT NOT NULL DEFAULT (0),
    parameter_id SMALLINT NOT NULL DEFAULT (0),
    parameter_value TEXT NULL,
    bbcode_uid VARCHAR(10) NULL DEFAULT (NULL),
    CONSTRAINT mx_block_system_parameter_pk PRIMARY KEY (block_id, parameter_id) ON [PRIMARY],
    CHECK (block_id>=0),
    CHECK (parameter_id>=0)
)  ON [PRIMARY] TEXTIMAGE_ON [PRIMARY];

INSERT INTO mx_block_system_parameter VALUES(1,15,'Welcome to the mx-publisher Portal!\r\n\r\nPlease visit www.mx-publisher.com for further information.\r\n\r\nThe Mx-Portal version is announced and documented [url=http://www.mx-publisher.com/forum/viewforum.php?f=11] here[/url].','10bec5b560');

INSERT INTO mx_block_system_parameter VALUES(2,60,'3,4,5','');

INSERT INTO mx_block_system_parameter VALUES(2,61,'33%,*,33%','');

INSERT INTO mx_block_system_parameter VALUES(2,62,'4','');

INSERT INTO mx_block_system_parameter VALUES(3,50,'This is a demo multi textblock!\r\n\r\n - featuring bbcode, html (if allowed by phpbb config), style parameters (click the EDIT button and try them out) and permissions (view and edit permissions for users and PRIVATE groups).','10bec5b560');

INSERT INTO mx_block_system_parameter VALUES(3,51,'none','');

INSERT INTO mx_block_system_parameter VALUES(3,52,'TRUE','');

INSERT INTO mx_block_system_parameter VALUES(3,53,'TRUE','');

INSERT INTO mx_block_system_parameter VALUES(3,54,'TRUE','');

INSERT INTO mx_block_system_parameter VALUES(4,15,'This is a demo bbcode textblock!\r\n\r\n- featuring bbcode, html (if allowed by phpbb config) and permissions (view and edit permissions for users and PRIVATE groups).','10bec5b560');

INSERT INTO mx_block_system_parameter VALUES(5,16,'This is a demo html textblock!\r\n\r\n- featuring html (if allowed by phpbb config) and permissions (view and edit permissions for users and PRIVATE groups).','10bec5b560');

INSERT INTO mx_block_system_parameter VALUES(6,36,'',NULL);

INSERT INTO mx_block_system_parameter VALUES(6,13,'0',NULL);

INSERT INTO mx_block_system_parameter VALUES(16,17,'5',NULL);

INSERT INTO mx_block_system_parameter VALUES(16,18,'TRUE',NULL);

INSERT INTO mx_block_system_parameter VALUES(16,19,'30',NULL);

INSERT INTO mx_block_system_parameter VALUES(16,20,'_self',NULL);

INSERT INTO mx_block_system_parameter VALUES(16,21,'left',NULL);

INSERT INTO mx_block_system_parameter VALUES(16,22,'TRUE',NULL);

INSERT INTO mx_block_system_parameter VALUES(16,37,'',NULL);

INSERT INTO mx_block_system_parameter VALUES(16,38,'FALSE',NULL);

INSERT INTO mx_block_system_parameter VALUES(16,39,'FALSE',NULL);

INSERT INTO mx_block_system_parameter VALUES(16,40,'TRUE',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,1,'1',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,2,'999',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,3,'TRUE',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,4,'FALSE',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,5,'FALSE',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,7,'thumb_news.gif',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,8,'thumb_globe.gif',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,9,'thumb_globe.gif',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,6,'TRUE',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,10,'thumb_globe.gif ',NULL);

INSERT INTO mx_block_system_parameter VALUES(18,11,'',NULL);

CREATE TABLE mx_table_column (
    column_id SMALLINT NOT NULL IDENTITY(1, 1),
    column_title VARCHAR(100) NULL DEFAULT (NULL),
    column_order SMALLINT NOT NULL DEFAULT (0),
    bbcode_uid VARCHAR(10) NULL DEFAULT (NULL),
    column_size VARCHAR(5) NULL DEFAULT ('100%'),
    page_id SMALLINT NOT NULL DEFAULT (0),
    CONSTRAINT mx_table_column_pk PRIMARY KEY (column_id) ON [PRIMARY],
    CHECK (column_id>=0),
    CHECK (column_order>=0)
)  ON [PRIMARY];

CREATE INDEX mx_table_column_cat_order ON mx_table_column (column_order) ON [PRIMARY];

INSERT INTO mx_table_column VALUES(1,'Column 1',10,NULL,'220',1);

INSERT INTO mx_table_column VALUES(2,'Column 2',20,NULL,'100%',1);

INSERT INTO mx_table_column VALUES(20,'Menu',10,NULL,'200',2);

INSERT INTO mx_table_column VALUES(21,'Forum',20,NULL,'100%',2);

CREATE TABLE mx_table_column_block (
    column_id SMALLINT NOT NULL DEFAULT (0),
    block_id SMALLINT NOT NULL DEFAULT (0),
    block_order SMALLINT NOT NULL DEFAULT (0)
)  ON [PRIMARY];

INSERT INTO mx_table_column_block VALUES(1,8,10);

INSERT INTO mx_table_column_block VALUES(1,16,20);

INSERT INTO mx_table_column_block VALUES(1,6,30);

INSERT INTO mx_table_column_block VALUES(1,13,40);

INSERT INTO mx_table_column_block VALUES(1,7,50);

INSERT INTO mx_table_column_block VALUES(1,14,60);

INSERT INTO mx_table_column_block VALUES(2,1,10);

INSERT INTO mx_table_column_block VALUES(2,2,10);

INSERT INTO mx_table_column_block VALUES(2,18,20);

INSERT INTO mx_table_column_block VALUES(2,19,30);

INSERT INTO mx_table_column_block VALUES(20,8,10);

INSERT INTO mx_table_column_block VALUES(20,16,20);

INSERT INTO mx_table_column_block VALUES(21,24,30);

INSERT INTO mx_table_column_block VALUES(21,19,40);

CREATE TABLE mx_table_function (
    function_id SMALLINT NOT NULL IDENTITY(1, 1),
    module_id SMALLINT NOT NULL DEFAULT (0),
    function_name VARCHAR(150) NULL DEFAULT (NULL),
    function_desc TEXT NULL,
    function_file VARCHAR(255) NULL DEFAULT (NULL),
    function_admin VARCHAR(255) NULL DEFAULT (NULL),
    CONSTRAINT mx_table_function_pk PRIMARY KEY (function_id) ON [PRIMARY],
    CHECK (function_id>=0),
    CHECK (module_id>=0)
)  ON [PRIMARY] TEXTIMAGE_ON [PRIMARY];

CREATE INDEX mx_table_function_module_id ON mx_table_function (module_id) ON [PRIMARY];

INSERT INTO mx_table_function VALUES(10,10,'Forum phpBB','Forum phpBB','mx_forum.php',NULL);

INSERT INTO mx_table_function VALUES(11,10,'Navigation Menu','Menu Navigation','mx_menu_nav.php','admin/admin_mx_menu.php');

INSERT INTO mx_table_function VALUES(12,10,'Polls','Polls','mx_poll.php',NULL);

INSERT INTO mx_table_function VALUES(13,10,'Language Select','Language Select','mx_language.php',NULL);

INSERT INTO mx_table_function VALUES(14,10,'Login','Login','mx_login.php',NULL);

INSERT INTO mx_table_function VALUES(15,10,'Theme Select','Theme Select','mx_theme.php',NULL);

INSERT INTO mx_table_function VALUES(16,10,'Google','Google','mx_google.php',NULL);

INSERT INTO mx_table_function VALUES(17,10,'Announcements','Announcements','mx_announce.php',NULL);

INSERT INTO mx_table_function VALUES(18,10,'Who is Online','Who is Online','mx_online.php',NULL);

INSERT INTO mx_table_function VALUES(19,10,'Multiple Horizontal Blocks','Block that can arrange other blocks in a horizontal line.','mx_multiple_blocks.php','');

INSERT INTO mx_table_function VALUES(20,20,'TextBlock_BBcode','TextBlock_BBcode','mx_textblock_bbcode.php','modules/mx_textblocks/admin/admin_edit.php');

INSERT INTO mx_table_function VALUES(21,20,'TextBlock_Html','TextBlock_Html','mx_textblock_html.php','modules/mx_textblocks/admin/admin_edit.php');

INSERT INTO mx_table_function VALUES(22,20,'TextBlock_Multi','Textblock for bbcode and html with parameters','mx_textblock_multi.php','modules/mx_textblocks/admin/admin_edit.php');

INSERT INTO mx_table_function VALUES(30,30,'Post Last Message','Post Last Message','mx_last_msg.php',NULL);

INSERT INTO mx_table_function VALUES(40,40,'Statistics MX','Statistics MX','mx_statistics.php',NULL);

CREATE TABLE mx_table_menu_categories (
    block_id SMALLINT NOT NULL DEFAULT (1),
    cat_id INTEGER NOT NULL IDENTITY(1, 1),
    cat_title VARCHAR(100) NULL DEFAULT (NULL),
    cat_order INTEGER NOT NULL DEFAULT (0),
    bbcode_uid VARCHAR(10) NULL DEFAULT (NULL),
    cat_desc TEXT NULL,
    cat_show TINYINT NOT NULL DEFAULT (0),
    CONSTRAINT mx_table_menu_categories_pk PRIMARY KEY (cat_id) ON [PRIMARY],
    CHECK (block_id>=0),
    CHECK (cat_id>=0),
    CHECK (cat_order>=0),
    CHECK (cat_show>=0)
)  ON [PRIMARY] TEXTIMAGE_ON [PRIMARY];

CREATE INDEX mx_tablemenucategoriescatorder ON mx_table_menu_categories (cat_order) ON [PRIMARY];

INSERT INTO mx_table_menu_categories VALUES(8,1,'Main Menu',20,NULL,NULL,1);

CREATE TABLE mx_table_menu_nav (
    menu_id SMALLINT NOT NULL IDENTITY(1, 1),
    cat_id INTEGER NOT NULL DEFAULT (0),
    menu_name VARCHAR(150) NULL DEFAULT (NULL),
    menu_desc TEXT NULL,
    menu_links VARCHAR(255) NULL DEFAULT (NULL),
    auth_view SMALLINT NOT NULL DEFAULT (0),
    menu_order SMALLINT NULL DEFAULT (0),
    bbcode_uid VARCHAR(10) NULL DEFAULT (NULL),
    menu_icon VARCHAR(255) NULL DEFAULT (NULL),
    function_id SMALLINT NULL DEFAULT (0),
    block_id SMALLINT NOT NULL DEFAULT (0),
    page_id SMALLINT NULL DEFAULT (0),
    auth_view_group SMALLINT NOT NULL DEFAULT (0),
    link_target TINYINT NOT NULL DEFAULT (0),
    CONSTRAINT mx_table_menu_nav_pk PRIMARY KEY (menu_id) ON [PRIMARY],
    CHECK (menu_id>=0),
    CHECK (cat_id>=0),
    CHECK (menu_order>=0),
    CHECK (function_id>=0),
    CHECK (page_id>=0),
    CHECK (link_target>=0)
)  ON [PRIMARY] TEXTIMAGE_ON [PRIMARY];

CREATE INDEX mx_table_menu_nav_cat_id ON mx_table_menu_nav (cat_id) ON [PRIMARY];

INSERT INTO mx_table_menu_nav VALUES(1,1,'Home','Home Page','index.php',0,10,'bc5d5e65eb','icon_home.gif',0,0,0,0,0);

INSERT INTO mx_table_menu_nav VALUES(2,1,'Forum','phpBB Forum','index.php',0,20,'1a7e19f246','icon_forum.gif',0,0,2,0,0);

INSERT INTO mx_table_menu_nav VALUES(3,1,'Statistics','Statistics Module','',0,30,'e16b0fbb51','icon_stat.gif',40,0,0,0,0);

CREATE TABLE mx_table_module (
    module_id SMALLINT NOT NULL IDENTITY(1, 1),
    module_name VARCHAR(150) NULL DEFAULT (NULL),
    module_path VARCHAR(255) NULL DEFAULT (NULL),
    module_desc TEXT NULL,
    module_include_admin CHAR(1) NULL DEFAULT ('0'),
    CONSTRAINT mx_table_module_pk PRIMARY KEY (module_id) ON [PRIMARY],
    CHECK (module_id>=0)
)  ON [PRIMARY] TEXTIMAGE_ON [PRIMARY];

INSERT INTO mx_table_module VALUES(10,'Core Blocks','./','Core blocks','');

INSERT INTO mx_table_module VALUES(20,'Text Blocks','modules/mx_textblocks/','Textblocks module','');

INSERT INTO mx_table_module VALUES(30,'Post Last Message','modules/mx_last_msg/','Last Message Module','0');

INSERT INTO mx_table_module VALUES(40,'Statistics MX','modules/mx_statistics/','Statistics Modules','0');

CREATE TABLE mx_table_page (
    page_id SMALLINT NOT NULL IDENTITY(1, 1),
    page_name VARCHAR(255) NULL DEFAULT (NULL),
    page_icon VARCHAR(255) NULL DEFAULT (NULL),
    auth_view SMALLINT NOT NULL DEFAULT (0),
    auth_view_group SMALLINT NOT NULL DEFAULT (0),
    page_header VARCHAR(255) NULL DEFAULT ('overall_header.tpl'),
    CONSTRAINT mx_table_page_pk PRIMARY KEY (page_id) ON [PRIMARY]
)  ON [PRIMARY];

INSERT INTO mx_table_page VALUES(1,'Home','icon_home.gif',0,0,'overall_header.tpl');

INSERT INTO mx_table_page VALUES(2,'Forum','icon_forum.gif',0,0,'overall_header.tpl');

CREATE TABLE mx_table_parameter (
    parameter_id SMALLINT NOT NULL IDENTITY(1, 1),
    function_id SMALLINT NOT NULL DEFAULT (0),
    parameter_name VARCHAR(150) NULL DEFAULT (NULL),
    parameter_type VARCHAR(30) NULL DEFAULT (NULL),
    parameter_default VARCHAR(150) NULL DEFAULT (NULL),
    parameter_function VARCHAR(255) NULL DEFAULT (NULL),
    CONSTRAINT mx_table_parameter_pk PRIMARY KEY (parameter_id) ON [PRIMARY],
    CHECK (parameter_id>=0),
    CHECK (function_id>=0)
)  ON [PRIMARY];

INSERT INTO mx_table_parameter VALUES(1,17,'announce_nbr_display','Number','1',NULL);

INSERT INTO mx_table_parameter VALUES(2,17,'announce_nbr_days','Number','14',NULL);

INSERT INTO mx_table_parameter VALUES(3,17,'announce_display','Boolean','TRUE',NULL);

INSERT INTO mx_table_parameter VALUES(4,17,'announce_display_sticky','Boolean','TRUE',NULL);

INSERT INTO mx_table_parameter VALUES(5,17,'announce_display_normal','Boolean','FALSE',NULL);

INSERT INTO mx_table_parameter VALUES(7,17,'announce_img','Text','thumb_globe.gif',NULL);

INSERT INTO mx_table_parameter VALUES(8,17,'announce_img_sticky','Text','thumb_globe.gif',NULL);

INSERT INTO mx_table_parameter VALUES(9,17,'announce_img_normal','Text','thumb_globe.gif',NULL);

INSERT INTO mx_table_parameter VALUES(6,17,'announce_display_global','Boolean','TRUE',NULL);

INSERT INTO mx_table_parameter VALUES(10,17,'announce_img_global','Text','thumb_globe.gif',NULL);

INSERT INTO mx_table_parameter VALUES(11,17,'announce_forum','Function',NULL,'get_list_multiple(&quot;{parameter_id}[]&quot;, FORUMS_TABLE, \'forum_id\', \'forum_name\', &quot;{parameter_value}&quot;, TRUE)');

INSERT INTO mx_table_parameter VALUES(13,12,'Poll_Display','Function','0','poll_select( {parameter_value}, &quot;{parameter_id}&quot; )');

INSERT INTO mx_table_parameter VALUES(36,12,'poll_forum','Function','','get_list_multiple(&quot;{parameter_id}[]&quot;, FORUMS_TABLE, \'forum_id\', \'forum_name\', &quot;{parameter_value}&quot;, TRUE)');

INSERT INTO mx_table_parameter VALUES(15,20,'Text','BBText','Insert your text here',NULL);

INSERT INTO mx_table_parameter VALUES(16,21,'Html','Html','Entre your Html code here',NULL);

INSERT INTO mx_table_parameter VALUES(17,30,'Last_Msg_Number_Title','Number','15',NULL);

INSERT INTO mx_table_parameter VALUES(18,30,'Last_Msg_Display_Date','Boolean','TRUE',NULL);

INSERT INTO mx_table_parameter VALUES(19,30,'Last_Msg_Title_Length','Number','30',NULL);

INSERT INTO mx_table_parameter VALUES(20,30,'Last_Msg_Target','Values','_blank',NULL);

INSERT INTO mx_table_parameter VALUES(21,30,'Last_Msg_Align','Values','left',NULL);

INSERT INTO mx_table_parameter VALUES(22,30,'Last_Msg_Display_Forum','Boolean','TRUE',NULL);

INSERT INTO mx_table_parameter VALUES(37,30,'Last_Msg_forum','Function','','get_list_multiple(&quot;{parameter_id}[]&quot;, FORUMS_TABLE, \'forum_id\', \'forum_name\', &quot;{parameter_value}&quot;, TRUE)');

INSERT INTO mx_table_parameter VALUES(38,30,'Last_Msg_Display_Last_Author','Boolean','TRUE','');

INSERT INTO mx_table_parameter VALUES(39,30,'Last_Msg_Display_Author','Boolean','FALSE','');

INSERT INTO mx_table_parameter VALUES(40,30,'Last_Msg_Display_Icon_View','Boolean','TRUE','');

INSERT INTO mx_table_parameter VALUES(50,22,'Text','BBText','Enter your block text here','');

INSERT INTO mx_table_parameter VALUES(51,22,'text_style','Values','none','');

INSERT INTO mx_table_parameter VALUES(52,22,'block_style','Boolean','TRUE','');

INSERT INTO mx_table_parameter VALUES(53,22,'title_style','Boolean','TRUE','');

INSERT INTO mx_table_parameter VALUES(54,22,'show_title','Boolean','TRUE','');

INSERT INTO mx_table_parameter VALUES(60,19,'block_ids','Function','1,2,3','get_list_multiple( &quot;{parameter_id}[]&quot;, BLOCK_TABLE, \'block_id\', \'block_title\', &quot;{parameter_value}&quot;, TRUE)');

INSERT INTO mx_table_parameter VALUES(61,19,'block_sizes','Text','20%,30%,*','');

INSERT INTO mx_table_parameter VALUES(62,19,'space_between','Number','4','');

CREATE TABLE mx_table_parameter_option (
    option_id SMALLINT NOT NULL IDENTITY(1, 1),
    parameter_id SMALLINT NOT NULL DEFAULT (0),
    option_code VARCHAR(150) NULL DEFAULT (NULL),
    option_desc TEXT NULL,
    CONSTRAINT mx_table_parameter_option_pk PRIMARY KEY (option_id) ON [PRIMARY],
    CHECK (option_id>=0),
    CHECK (parameter_id>=0)
)  ON [PRIMARY] TEXTIMAGE_ON [PRIMARY];

INSERT INTO mx_table_parameter_option VALUES(1,14,'0','Sunday');

INSERT INTO mx_table_parameter_option VALUES(2,14,'1','Monday');

INSERT INTO mx_table_parameter_option VALUES(3,21,'left','left ');

INSERT INTO mx_table_parameter_option VALUES(4,21,'right','right');

INSERT INTO mx_table_parameter_option VALUES(5,21,'center','center');

INSERT INTO mx_table_parameter_option VALUES(6,20,'_blank','New Window');

INSERT INTO mx_table_parameter_option VALUES(7,20,'_self','Current Window');

CREATE TABLE mx_table_portal (
    portal_id SMALLINT NOT NULL IDENTITY(1, 1),
    portal_name VARCHAR(150) NULL DEFAULT (NULL),
    portal_phpbb_url VARCHAR(255) NULL DEFAULT ('http://www.phpbb.com/phpBB/'),
    portal_url VARCHAR(255) NULL DEFAULT (NULL),
    portal_version VARCHAR(255) NULL DEFAULT (NULL),
    top_phpbb_links SMALLINT NOT NULL DEFAULT (1),
    CONSTRAINT mx_table_portal_pk PRIMARY KEY (portal_id) ON [PRIMARY],
    CHECK (portal_id>=0),
    CHECK (top_phpbb_links>=0)
)  ON [PRIMARY];

