# --------------------------------------------------------
#
# Table structure for table 'mx_table_themes'
#
CREATE TABLE mx_table_themes (
   themes_id mediumint(8) UNSIGNED NOT NULL auto_increment,
   template_name varchar(30) NOT NULL default '',
   style_name varchar(30) NOT NULL default '',
   head_stylesheet varchar(100) default NULL,
   portal_backend varchar(30) NOT NULL default '',
   PRIMARY KEY  (themes_id)
);

# -- Themes
INSERT INTO mx_table_themes (themes_id, template_name, style_name, head_stylesheet, portal_backend) VALUES (1, 'mxSilver', 'mxSilver', 'mxSilver.css', 'internal');
INSERT INTO mx_table_themes (themes_id, template_name, style_name, head_stylesheet, portal_backend) VALUES (2, 'subSilver', 'subSilver', 'subSilver.css', 'phpbb2');
INSERT INTO mx_table_themes (themes_id, template_name, style_name, head_stylesheet, portal_backend) VALUES (3, 'subsilver2', 'subsilver2', 'subsilver2.css', 'phpbb3');
INSERT INTO mx_table_themes (themes_id, template_name, style_name, head_stylesheet, portal_backend) VALUES (4, 'prosilver', 'prosilver', 'prosilver.css', 'phpbb3');

