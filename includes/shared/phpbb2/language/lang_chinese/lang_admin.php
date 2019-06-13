<?php
/***************************************************************************
 *                            lang_admin.php [简体中文]
 *                              -------------------
 *      Разработка: phpBB Group.
 *      Оптимизация под WAP: Гутник Игорь ( чел ).
 *          2011 год
 *		简体中文：爱疯的云
 ***************************************************************************/

$lang['General'] = '网站的相关管理';
$lang['Users'] = '会员相关管理';
$lang['Groups'] = '小组相关管理';
$lang['Forums'] = '论坛相关管理';
$lang['Forums_Manage'] = '论坛管理';
$lang['Forums_Permissions'] = '论坛权限';
$lang['Forums_prune'] = '计划清理';
$lang['Photo_Album'] = '相册的相关管理'; 

$lang['Private_Messages'] = '信息列表';
$lang['Select_Users'] = '管理用户';
$lang['Styles'] = '风格';
$lang['Manage'] = '管理';
$lang['Photo_Album_Cat'] = '管理分类';
$lang['Advertisment'] = '管理广告';
$lang['Configuration'] = '全局设置';
$lang['Permissions'] = '论坛权限';
$lang['Attach_Manage'] = '附件管理';
$lang['Disallow'] = '敏感用户名';
$lang['Prune'] = '清除';
$lang['Mass_Email'] = '群发邮件';
$lang['Ranks'] = '用户等级';
$lang['Smilies'] = '表情图标';
$lang['Icon'] = '图标';
$lang['Ban_Management'] = '黑名单';
$lang['Word_Censor'] = '敏感词';
$lang['Export'] = '导出';
$lang['Create_new'] = '创建';
$lang['Add_new'] = '添加';
$lang['Backup_DB'] = '备份数据';
$lang['Restore_DB'] = '还原数据';
$lang['Number'] = '电话号码';
$lang['Min_login_regdate'] = '用户进入网站需要等待的时间（单位/分钟）';
$lang['Min_login_regdate_explain'] = '用户在此期间新注册的用户将无法登录网站，须用户阅读规则后才可以进入';
$lang['Index_announcement'] = '首页公告';
$lang['Index_announcement_explain'] = '这是显示在首页的一段公告信息，可以使用HTML的标签和表情代码';
$lang['Icq_send'] = '在线发送ICQ信息';
$lang['Icq_send_explain'] = '提示：此功能会对服务器造成负载，一些托管服务商是不允许的！';
$lang['Captcha_in_topic'] = '发表新主题是否开启图片验证';
$lang['Max_smiles'] = '表情的最大使用数量';
$lang['Default_icq'] = '默认ICQ号码';
$lang['Message_quote'] = '是否使用引用主题按钮';
$lang['Default_icq_explain'] = '在线发送ICQ信息的帐号';
$lang['Default_icq_pass'] = '默认ICQ密码';
$lang['Flood_icq_interval'] = '防止ICQ聊天灌水';
$lang['Flood_icq_interval_explain'] = '用户须间隔（秒）才可以发送第二条ICQ消息';
$lang['Poslednee_redaktirovanie'] ='是否显示最后编辑时间';
$lang['Poslednee_redaktirovanie_explain'] ='显示最后论坛帖子的最后编辑时间';
$lang['Index_spisok'] = '是否展开论坛列表';
$lang['Nic_color'] = '用户名颜色';
$lang['Categories'] = '分类'; 
$lang['Clear_Cache'] = '清除缓存'; 
$lang['Personal_Galleries'] = '个人相册';

//
// Index
//
$lang['Admin'] = '超级管理面板';
$lang['Admin_Index_Left'] = '功能管理';
$lang['Not_admin'] = '您没有超级管理员权限';
$lang['Welcome_phpBB'] = '欢迎来到超级管理面板';
$lang['Admin_intro'] = '感谢您使用phpBB-WAP论坛程序<br />开发者：phpBB Group<br />Оптимизация под WAP: Гутник Игорь ( чел )<br />中文phpBB-WAP：(爱疯的云)';
$lang['Main_index'] = '首页';
$lang['Forum_stats'] = '论坛统计';
$lang['Admin_Index'] = '后台面板';
$lang['Preview_forum'] = '浏览论坛';

$lang['Click_return_admin_index'] = '点击 %s这里%s 返回超级管理面板首页';

// 统计
$lang['Statistic'] = '统计';
$lang['Value'] = '值';
$lang['Number_posts'] = '主题数量';
$lang['Posts_per_day'] = '平均每天发表帖子数量';
$lang['Number_topics'] = '帖子数量';
$lang['Topics_per_day'] = '平均每天发表主题数量';
$lang['Number_users'] = '论坛已注册用户数量';
$lang['Users_per_day'] = '平均每日注册用户数量';
$lang['Board_started'] = '论坛建设日期';
$lang['Avatar_dir_size'] = '头像目录大小';
$lang['Database_size'] = '数据库大小';
$lang['Not_available'] = '不可用';

// 图片验证
$lang['Visual_confirm'] = '图片验证';
$lang['Visual_confirm_explain'] = '注册新用户时，要输入图片验证';

// Gzip
$lang['Gzip_compression'] ='Gzip压缩';
$lang['ON'] = '开启'; // 这是 Gzip 开关
$lang['OFF'] = '关闭'; 


//
// 数据库工具
//
$lang['Database_Utilities'] = '数据工具';

$lang['Restore'] = '恢复';
$lang['Backup'] = '备份';
$lang['Restore_explain'] = '在这个选项中，您可以恢复phpBB-WAP所有数据信息。如果您的服务器支持 GZIP 压缩的文件，服务器将会自动解压您所上传的压缩文件。<b>注意：</b> 恢复过程中将会完全覆盖所有现存的资料。数据库恢复过程可能会花费较长的时间，在恢复完成前请不要关闭或离开这个页面。';
$lang['Backup_explain'] = '在这个选项中，您可以备份phpBB-WAP所有数据信息。如果您有其它自行定义数据表放在phpBB-WAP论坛所使用的数据库内，而且您也想备份这些的表格，请在下方的 <b>附加数据表</b> 栏内输入它们的名字并用英文逗号分开（例如：abc, cde） 如果您的服务器有支持 GZIP 压缩格式，您可以在下载前使用 GZIP 压缩来减小文件的大小。';

$lang['Backup_options'] = '备份选项';
$lang['Start_backup'] = '开始备份';
$lang['Full_backup'] = '完整备份';
$lang['Structure_backup'] = '结构备份';
$lang['Data_backup'] = '数据备份';
$lang['Additional_tables'] = '附加表';
$lang['Gzip_compress'] = 'gzip压缩格式';
$lang['Select_file'] = '选择文件';
$lang['Start_Restore'] = '开始恢复';

$lang['Restore_success'] = '数据库成功恢复！<br />论坛已被恢复成备份时的状态。';
$lang['Backup_download'] = '请等待。。。您的备份文件将被下载！';
$lang['Backups_not_supported'] = '对不起！备份数据不支持您的数据库系统';

$lang['Restore_Error_uploading'] = '上传备份文件有误';
$lang['Restore_Error_filename'] = '文件名称有问题，请重选文件再试';
$lang['Restore_Error_decompress'] = '不能解压 Gzip 文件，请上传纯文本文件';
$lang['Restore_Error_no_file'] = '没有文件可以上传';

$lang['Search_Flood_Interval'] ='搜索论坛时间间隔（单位/秒）';
$lang['Search_Flood_Interval_explain'] ='防止用户恶意搜索，减轻服务器的压力';

//
// 权限
//
$lang['Select_a_User'] = '选择用户';
$lang['Select_a_Group'] = '选择小组';
$lang['Select_a_Forum'] = '选择论坛';
$lang['Auth_Control_User'] = '用户权限'; 
$lang['Auth_Control_Group'] = '小组权限'; 
$lang['Auth_Control_Forum'] = '论坛权限'; 
$lang['Look_up_User'] = '选择用户'; 
$lang['Look_up_Group'] = '选择小组'; 
$lang['Look_up_Forum'] = '选择论坛'; 

$lang['Group_auth_explain'] = '在这个选项中您可以更改小组的权限设定及指定管理员资格。请注意，修改小组权限设定后，独立的用户权限可能仍然可以使用户进入限制论坛。如果发生这种情况将会显示权限冲突的警告。';
$lang['User_auth_explain'] = '在这个选项中您可以更改用户的权限设定及指定管理员资格。请注意，修改用户权限设定后，独立的用户权限可能仍然可以使用户进入限制论坛。如果发生这种情况将会显示权限冲突的警告。';
$lang['Forum_auth_explain'] = '在这个选项中您可以更改论坛的使用权限。您可以选择使用简单或是高级两种模式，高级模式能提供您完整的权限设定控制。请注意，所有的改变都将会影响到用户的论坛使用权限。';

$lang['Simple_mode'] = '简洁模式';
$lang['Advanced_mode'] = '高级模式';
$lang['Moderator_status'] = '成为版主';

$lang['Allowed_Access'] = '允许进入';
$lang['Disallowed_Access'] = '禁止进入';
$lang['Is_Moderator'] = '是版主';
$lang['Not_Moderator'] = '不是版主';

$lang['Conflict_warning'] = '权限冲突警告';
$lang['Conflict_access_userauth'] = '这个用户仍然可以通过小组成员的资格进入特定的论坛。您可以更改小组权限或是取消这个用户的小组资格来禁止该用户进入限制的论坛。小组权限如下：';
$lang['Conflict_mod_userauth'] = '这个用户仍然可以通过小组成员的资格拥有论坛管理的权限。您可以更改小组权限或是取消这个用户的权限来禁止该用户进行论坛管理。论坛管理权限如下：';

$lang['Conflict_access_groupauth'] = '下列用户仍然可以通过用户权限设定进入这个特定的论坛。您可以更改用户权限来取消他们进入限制的论坛。用户权限如下：';
$lang['Conflict_mod_groupauth'] = '下列用户依然可以通过他们的用户权限拥有论坛管理的权限。您可以更改用户权限来取消他们的论坛管理权限。用户权限如下：';

$lang['Public'] = '公开';
$lang['Private'] = '加密';
$lang['Registered'] = '注册用户';
$lang['Administrators'] = '超级用户';
$lang['Hidden'] = '隐藏';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = '全部';
$lang['Forum_REG'] = '注册';
$lang['Forum_PRIVATE'] = '浏览';
$lang['Forum_MOD'] = '版主';
$lang['Forum_ADMIN'] = '管理员';

$lang['View'] = '浏览';
$lang['Read'] = '阅读';
$lang['Post'] = '发表';
$lang['Reply'] = '回复';
$lang['Edit'] = '编辑';
$lang['Delete'] = '删除';
$lang['Sticky'] = '置顶';
$lang['Announce'] = '公告';
$lang['Vote'] = '投票';
$lang['Pollcreate'] = '建立投票';

$lang['Permissions'] = '权限设定';
$lang['Simple_Permission'] = '基本权限';

$lang['User_Level'] = '用户权限'; 
$lang['Auth_User'] = '注册用户';
$lang['Auth_Admin'] = '超级管理员';
$lang['Group_memberships'] = '用户小组列表';
$lang['Usergroup_members'] = '小组成员列表';

$lang['Forum_auth_updated'] = '论坛权限设定更新';
$lang['User_auth_updated'] = '用户权限设定更新';
$lang['Group_auth_updated'] = '小组权限设定更新';

$lang['Auth_updated'] = '权限设定已经更新';
$lang['Click_return_userauth'] = '点击 %s这里%s 返回用户权限设定';
$lang['Click_return_groupauth'] = '点击 %s这里%s 返回小组权限设定';
$lang['Click_return_forumauth'] = '点击 %s这里%s 返回论坛权限设定';


//
// 黑名单
//
$lang['Ban_control'] = '黑名单控制面板';
$lang['Ban_explain'] = '在这个选项中您可以设定用户的黑名单，您可以指定一个用户为黑名单，一个指定范围的 IP 地址或是计算机主机名称，这些方法禁止被封锁的用户进入论坛首页，您也可以指定封锁电子邮件地址来防止注册用户使用不同的帐号重复注册，请注意当您只是封锁一个电子邮件地址时将不会影响到用户在您论坛的登陆或是发表文章，您应该使用前面两种方式其中之一或是两种一起来设置黑名单。';
$lang['Ban_explain_warn'] = '当您输入一个IP地址范围时，这个范围内所有的IP地址都将会被封锁，您可以使用统配符 * 定义要封锁的ip地址来降低被攻击的可能，如果您一定要输入一个范围请尽量保持精简和适当以免影响正常的使用。';

$lang['Select_username'] = '选择一个用户名称';
$lang['Select_ip'] = '选择一个 IP 地址';
$lang['Select_email'] = '选择一个邮件地址';

$lang['Ban_username'] = '添加黑名单用户';
$lang['Ban_username_explain'] = '您可以使用鼠标和组合键（如: Ctrl 或 Shift）一次值得多个用户名称为黑名单';

$lang['Ban_IP'] = '添加IP黑名单';
$lang['Ban_IP_explain'] = '要指定多个不同的 IP 地址或是主机名称，请使用英文逗号（,）来分隔它们，要指定 IP 地址的范围，请使用（-）来分隔起始地址及结束地址，或是使用统配符（*）';

$lang['Ban_email'] = '添加黑名单 E-mail';
$lang['Ban_email_explain'] = '要指定多个不同的电子邮件地址，请使用逗号（,）来分隔它们，或是使用通配符（*），例如：*@hotmail.com';

$lang['Unban_username'] = '解除用户黑名单';

$lang['Unban_IP'] = '解除 IP 黑名单';

$lang['Unban_email'] = '解除黑名单 E-mail';

$lang['No_banned_users'] = '没有用户被列入黑名单！';
$lang['No_banned_ip'] = '没有 IP 黑名单';
$lang['No_banned_email'] = '没有电子邮件地址黑名单';

$lang['Ban_update_sucessful'] = '黑名单列表已经成功更新';
$lang['Click_return_banadmin'] = '点击 %s这里%s 返回黑名单管理面板';


//
// 论坛基本配置
//
$lang['General_Config'] = '基本配置';
$lang['Config_explain'] = '在这里您可以更改网站的基本配置';

$lang['Click_return_config'] = '点击 %s这里%s 返回基本配置';

$lang['General_settings'] = '论坛基本设置';
$lang['Server_name'] = '服务器名称';
$lang['Server_name_explain'] = '运行该程序的服务器名称';
$lang['Script_path'] = '脚本路径';
$lang['Script_path_explain'] = '与程序相对应的路径';
$lang['Server_port'] = '服务器端口';
$lang['Server_port_explain'] = '您的服务器所运行的端口，默认值是80，只有在非默认值时改变这个选项';
$lang['Site_name'] = '域名（不用http://）';
$lang['Site_desc'] = '网站描述';
$lang['Board_disable'] = '是否停止使用网站';
$lang['Board_disable_explain'] = '这将会关闭网站，当您执行这个设定时请勿退出，否则您将无法重新登陆！';
$lang['Acct_activation'] = '是否开启用户帐号激活功能';
$lang['Acc_None'] = '关闭'; // These three entries are the type of activation
$lang['Acc_User'] = '注册用户自行激活';
$lang['Acc_Admin'] = '超级用户审核激活';

$lang['Abilities_settings'] = '用户及论坛基本设定';
$lang['Max_poll_options'] = '允许发起投票项目的最大数量';
$lang['Flood_Interval'] = '论坛发帖间隔时间（单位/秒）';
$lang['Flood_Interval_explain'] = '防止用户恶意刷帖'; 
$lang['Board_email_form'] = '在线发送 E-mail 开关';
$lang['Board_email_form_explain'] = '开启之后，用户可以通过本站在线发送电子邮件给对方';
$lang['Topics_per_page'] = '论坛每页显示主题的数量';
$lang['Posts_per_page'] = '主题每页显示帖子的数量';
$lang['Hot_threshold'] = '热门话题的数量限制';
$lang['Default_style'] = '默认风格';
$lang['Override_style'] = '忽略用户选择的风格';
$lang['Override_style_explain'] = '将用户所选的风格改为默认风格';
$lang['Default_language'] = '默认语言';
$lang['Date_format'] = '默认日期格式（Y=年,M=月,D=日,H=时,i=分）';
$lang['System_timezone'] = '默认时区（GMT+8 = 北京时间）';
$lang['Enable_gzip'] = '是否开启 GZip 文件压缩';
$lang['Enable_prune'] = '是否开启论坛自动清理主题';
$lang['Allow_HTML'] = '是否允许使用 HTML 语法';
$lang['Allow_BBCode'] = '是否允许使用 BBCode';
$lang['Allowed_tags'] = '是否允许使用 HTML 标签';
$lang['Allowed_tags_explain'] = '以英文逗号分隔 HTML 标签';
$lang['Allow_smilies'] = '是否允许使用表情';
$lang['Smilies_path'] = '表情的路径';
$lang['Smilies_path_explain'] = '默认在您 phpBB-WAP 根目录的路径，例如：images/smilies';
$lang['Allow_sig'] = '是否允许使用论坛帖子签名';
$lang['Max_sig_length'] = '论坛帖子签名长度限制';
$lang['Max_sig_length_explain'] = '用户个人签名最多可使用字数（单位/字节）';
$lang['Allow_name_change'] = '是否允许更改用户名';

// 头像
$lang['Avatar_settings'] = '头像设置';
$lang['Allow_local'] = '是否允许使用系统相册图片';
$lang['Allow_remote'] = '是否允许链接外站图片';
$lang['Allow_remote_explain'] = '如果允许，用户将可以从其他网址链接头像图片';
$lang['Allow_upload'] = '是否允许用户上传头像';
$lang['Max_filesize'] = '头像文件大小限制（单位/B）';
$lang['Max_filesize_explain'] = '用户上传头像图片的大小限制';
$lang['Max_avatar_size'] = '头像文件的像素限制';
$lang['Max_avatar_size_explain'] = '（最大高度 x 最大宽度)';
$lang['Avatar_storage_path'] = '会员头像的储存路径';
$lang['Avatar_storage_path_explain'] = '在您 phpBB-WAP 根目录底下的路径，例如：images/avatars';
$lang['Avatar_gallery_path'] = '系统相册的储存路径';
$lang['Avatar_gallery_path_explain'] = '在您 phpBB-WAP 根目录底下的路径，例如：images/avatars/gallery';

// COPPA ，与中国无关无需汉化
$lang['COPPA_settings'] = 'COPPA Settings';
$lang['COPPA_fax'] = 'COPPA Fax Number';
$lang['COPPA_mail'] = 'COPPA Mailing Address';
$lang['COPPA_mail_explain'] = 'This is the mailing address where parents will send COPPA registration forms';

// 电子邮件
$lang['Email_settings'] = 'E-mail设置';
$lang['Admin_email'] = '管理员E-mail';
$lang['Email_sig'] = 'E-mail签名';
$lang['Email_sig_explain'] = '这个签名档将会被附加在所有由论坛系统送出的电子邮件中';
$lang['Use_SMTP'] = '是否使用 SMTP 服务器发送电子邮件';
$lang['Use_SMTP_explain'] = '如果您想要使用 SMTP 服务器发送电子邮件请选择 是';
$lang['SMTP_server'] = 'SMTP 服务器名称（例如：smtp.phpbb-wap.com）';
$lang['SMTP_username'] = 'SMTP 用户名（例如：username）';
$lang['SMTP_username_explain'] = '只有您的 SMTP 服务器要求用户时才填写这个选项';
$lang['SMTP_password'] = 'SMTP 密码（例如：password）';
$lang['SMTP_password_explain'] = '只有您的 SMTP 服务器要求用户时才填写这个选项';

// 站内信息
$lang['Disable_privmsg'] = '用户站内信息功能开关';
$lang['Inbox_limits'] = '站内信息的 收信箱 最大数量（单位/条）';
$lang['Sentbox_limits'] = '站内信息的 发信箱 最大数量（单位/条）';
$lang['Savebox_limits'] = '站内信息的 草稿箱 最大容量（单位/条）';

// cookies
$lang['Cookie_settings'] = 'Cookie 设定'; 
$lang['Cookie_settings_explain'] = '这些设定控制着 Cookie 的定义，就一般的情况，使用系统预设值就可以了。如果您要更改这些设定，请谨慎设定，不当的设定将影响用户的登陆';
$lang['Cookie_domain'] = 'Cookie 域名';
$lang['Cookie_name'] = 'Cookie 名称';
$lang['Cookie_path'] = 'Cookie 路径';
$lang['Cookie_secure'] = 'Cookie 加密（https）';
$lang['Cookie_secure_explain'] = '如果您的服务器运行于 SSL 方式请设置为开启，否则请设置为关闭';
$lang['Session_length'] = 'Session 有效期限（秒）';


//
// 论坛管理
//
$lang['Forum_admin'] = '论坛管理';
$lang['Forum_admin_explain'] = '在这个控制面板里您可以增加、删除、编辑和重新排列分类和论坛，以及设定论坛内的相应资料';
$lang['Edit_forum'] = '编辑论坛';
$lang['Create_forum'] = '创建论坛';
$lang['Create_category'] = '创建分类';
$lang['Remove'] = '删除';
$lang['Action'] = '执行操作';
$lang['Update_order'] = '更新顺序';
$lang['Config_updated'] = '论坛配置更改成功';
$lang['Edit'] = '编辑';
$lang['Delete'] = '删除';
$lang['Move_up'] = '上移';
$lang['Move_down'] = '下移';
$lang['Resync'] = '同步';
$lang['No_mode'] = '没有指定模式';
$lang['Forum_edit_delete_explain'] = '您可以使用下列表格来调整一般的设定选项，用户及版面设定请使用画面左方（系统管理）的相关链接.';

$lang['Move_contents'] = '移动所有内容';
$lang['Forum_delete'] = '删除论坛';
$lang['Forum_delete_explain'] = '您可以使用下列表格来删除版面或分类，并可移动包含在版面内的所有内容';

$lang['Status_locked'] = '锁定';
$lang['Status_unlocked'] = '解锁';
$lang['Forum_settings'] = '论坛基本设定';
$lang['Forum_name'] = '论坛名称';
$lang['Forum_desc'] = '论坛描述';
$lang['Forum_status'] = '论坛状态';
$lang['Forum_pruning'] = '计划清理';
$lang['Forum_postcount'] = '论坛发帖统计';

$lang['prune_freq'] = '定期检查周期';
$lang['prune_days'] = '删除在几天内没有文章回覆的主题';
$lang['Set_prune_data'] = '您已经开启版面计划删文的功能, 但并未完成相关设定. 请回到上一步设定相关的项目';

$lang['Move_and_Delete'] = '移动删除';

$lang['Delete_all_posts'] = '删除所有发帖';
$lang['Nowhere_to_move'] = '没有移动的位置';

$lang['Edit_Category'] = '编辑分类名称';
$lang['Edit_Category_explain'] = '修改分类名称';

$lang['Forums_updated'] = '版面及分类资料成功更新';

$lang['Must_delete_forums'] = '在删除这个分类之前，您必须先删除分类底下的所有版面';

$lang['Click_return_forumadmin'] = '点击 %s这里%s 返回版面管理';


//
// 表情管理
//
$lang['smiley_title'] = '表情符号编辑';
$lang['smile_desc'] = '在这里，您可以编辑表情符，以便用户在发表帖子或是站内信息中使用';

$lang['smiley_config'] = '表情符号设定';
$lang['smiley_code'] = '表情代码';
$lang['smiley_url'] = '表情图片';
$lang['smiley_emot'] = '表情描述';
$lang['smile_add'] = '增加一个新表情';
$lang['Smile'] = '表情图标';
$lang['Emotion'] = '表情描述';

$lang['Select_pak'] = '选择的表情符号包（.pak）文件';
$lang['replace_existing'] = '替换现有的表情符号';
$lang['keep_existing'] = '保留现有的表情符号';
$lang['smiley_import_inst'] = '您应将表情符号包解压并上传至适当的表情符号目录，然后选择正确的项目导入表情符号';
$lang['smiley_import'] = '导入表情符号包';
$lang['choose_smile_pak'] = '选择一个表情符号包（.pak）文件';
$lang['import'] = '导入表情符号';
$lang['smile_conflicts'] = '在冲突的情况下所应做出的选择';
$lang['del_existing_smileys'] = '导入前先删除旧的表情符号';
$lang['import_smile_pack'] = '导入表情符号包';
$lang['export_smile_pack'] = '下载表情符号包';
$lang['export_smiles'] = '如您希望将现有的表情符号制作成表情符号包，请点击 %s这里%s 下载 smiles.pak 文件，并确定其后缀为.pak';

$lang['smiley_add_success'] = '新的表情符号已经成功增加';
$lang['smiley_edit_success'] = '表情符号已经成功更新';
$lang['smiley_import_success'] = '表情符号包已经成功导入!';
$lang['smiley_del_success'] = '表情符号已经成功删除';
$lang['Click_return_smileadmin'] = '点击 %s这里%s 返回表情符号编辑';

//
// 会员管理
//
$lang['User_admin'] = '用户管理';
$lang['User_admin_explain'] = '在这个控制面板里，您可以变更用户的个人资料以及现存的特殊选项，如果您要修改用户的权限，请使用用户及小组管理的权限设定功能';

$lang['Look_up_user'] = '查看用户';
$lang['Admin_users_list'] = '会员列表';


$lang['Admin_user_fail'] = '无法更新用户的个人资料';
$lang['Admin_user_updated'] = '用户的个人资料已经成功更新';
$lang['Click_return_useradmin'] = '点击 %s这里%s 返回用户管理';
$lang['User_zvanie'] = '你在商店购买的标题';

$lang['User_delete'] = '删除用户';
$lang['User_delete_explain'] = '点击这里将会删除用户，这个选择将无法恢复';
$lang['User_deleted'] = '用户已成功删除';

$lang['User_status'] = '用户帐号已激活';
$lang['User_allowpm'] = '允许使用站内信息';
$lang['User_allowavatar'] = '允许使用头像';

$lang['Admin_avatar_explain'] = '在这个选项您可以浏览或删除用户现存的个性头像';

$lang['User_special'] = '管理员专区';
$lang['User_special_explain'] = '您可以变更用户的帐号激活状态及其它未授权用户的选项设定，普通用户无法自行改变这些设定';


//
// 小组管理
//
$lang['Group_administration'] = '小组管理';
$lang['Group_admin_explain'] = '在这个控制面板里您可以管理所有的用户小组，您可以建立、删除以及编辑现存的用户小组，您可以指定小组管理员，设定小组模式（开放、封闭、隐藏）以及小组的名称和描述';
$lang['Error_updating_groups'] = '小组更新时发生错误';
$lang['Updated_group'] = '小组已经成功更新';
$lang['Added_new_group'] = '新的小组已成功添加';
$lang['Deleted_group'] = '小组已成功删除';
$lang['New_group'] = '新建小组';
$lang['Edit_group'] = '编辑小组';
$lang['group_name'] = '小组名称';
$lang['group_description'] = '小组描述';
$lang['group_moderator'] = '小组管理员';
$lang['group_status'] = '小组状态';
$lang['group_open'] = '开放小组';
$lang['group_closed'] = '关闭小组';
$lang['group_hidden'] = '隐藏小组';
$lang['group_delete'] = '删除小组';
$lang['group_delete_check'] = '删除小组';
$lang['group_gb_enable'] = '小组全局开关';
$lang['submit_group_changes'] = '更改';
$lang['reset_group_changes'] = '重置';
$lang['No_group_name'] = '您必许指定小组名称';
$lang['No_group_moderator'] = '您必许指定小组的管理员';
$lang['No_group_mode'] = '您必须指定小组状态（开放、封闭、隐藏）';
$lang['No_group_action'] = '没有指定操作';
$lang['delete_group_moderator'] = '是否删除原有的小组管理员？';
$lang['delete_moderator_explain'] = '如果您更改小组管理员而且勾选这个选项会将原有的小组管理员从小组中移除，如不勾选，这个用户将成为小组的普通成员';
$lang['Click_return_groupsadmin'] = '点击 %s这里%s 返回小组管理.';
$lang['Select_group'] = '选择小组';
$lang['Look_up_group'] = '查看小组';


//
// 自动清理
//
$lang['Forum_Prune'] = '版面计划清理';
$lang['Forum_Prune_explain'] = '这将删除所有在限定时间内没有回覆的主题，如果您没有指定时限（日数），所有的主题都将会被删除，但是无法删除正在进行中的投票主题或是公告，您必须手动移除这些主题';
$lang['Do_Prune'] = '执行计划清理';
$lang['All_Forums'] = '全部版面';
$lang['Prune_topics_not_posted'] = '删除在几天内没有文章回复的主题';
$lang['Topics_pruned'] = '计划删除的主题';
$lang['Posts_pruned'] = '计划删除的文章';
$lang['Prune_success'] = '成功完成版面文章删除';


//
// 文字过滤
//
$lang['Words_title'] = '文字过滤';
$lang['Words_explain'] = '在这个控制面板里您可以建立、编辑及删除过滤文字，这些指定的文字将会被过滤并以替换文字显示，另外用户也将无法使用含有这些限定文字的名称来注册，限定的名称允许使用通用匹配符 *，例如: *test* 代表包括 detestable等，test* 包括 testing等，*test 包括 detest等';
$lang['Word'] = '过滤文字';
$lang['Edit_word_censor'] = '编辑过滤文字';
$lang['Replacement'] = '替换文字';
$lang['Add_new_word'] = '增加过滤文字';
$lang['Update_word'] = '更新过滤文字';

$lang['Must_enter_word'] = '您必须输入要过滤的文字及其替换文字';
$lang['No_word_selected'] = '您没有选择要编辑的过滤文字';

$lang['Word_updated'] = '您所选择的过滤文字已经成功更新';
$lang['Word_added'] = '新的过滤文字已经成功加入';
$lang['Word_removed'] = '您所选择的过滤文字已被成功移除';

$lang['Click_return_wordadmin'] = '点击 %s这里%s 返回文字过滤';


//
// 群发 Email
//
$lang['Mass_email_explain'] = '在这个选项里您可以发送E-mail给所有的用户或是特定的小组的成员，这封E-mail将被寄送至系统管理员提供的E-mail信箱，并以密件副本的方式寄送给所有收件人。如果收件人数过多，系统需要较长的时间来执行，请在提交送出后耐心等候，<b>请勿</b>在程序完成之前停止网页动作，当发送完成时将显示提示';
$lang['Compose'] = '群发邮件'; 

$lang['Recipients'] = '收件人'; 
$lang['All_users'] = '所有用户';

$lang['Email_successfull'] = '邮件已经寄出';
$lang['Click_return_massemail'] = '点击 %s这里%s 返回E-mail群发';


//
// 等级管理
//
$lang['Ranks_title'] = '等级管理';
$lang['Ranks_explain'] = '在这个控制面板里，您可以在增加、编辑、浏览以及删除等级，您也可以使用等级应用于用户管理功能';

$lang['Add_new_rank'] = '新建等级';

$lang['Rank_title'] = '等级';
$lang['Rank_special'] = '特殊等级';
$lang['Rank_minimum'] = '至少需要发贴';
$lang['Rank_maximum'] = '至多需要发帖';
$lang['Rank_image'] = '等级图片（请使用 phpBB-WAP 的绝对路径）';
$lang['Rank_image_explain'] = '使用这个来定义等级图片的路径';

$lang['Must_select_rank'] = '您必须选择一个等级';
$lang['No_assigned_rank'] = '没有指定的等级';

$lang['Rank_updated'] = '等级设置已经成功更新';
$lang['Rank_added'] = '新的等级已经成功加入';
$lang['Rank_removed'] = '等级名称已被成功删除';
$lang['No_update_ranks'] = '等级名称已经被成功删除，尽管如此，使用该等级的用户帐号没有获得更新，您需要手动复置那些使用过该等级的用户帐号';

$lang['Click_return_rankadmin'] = '点击 %s这里%s 返回等级管理';


// 
// 禁止使用管理员用户名
// 
$lang['Disallow_control'] = '敏感用户名';
$lang['Disallow_explain'] = '在这个选项中，您可以控制禁止使用的用户名（可使用通配符 *），请注意，您无法禁用已经注册使用的用户名，您必须先删除或更改这个用户名，才能使用禁止管理员用户名的功能';

$lang['Delete_disallow'] = '删除';
$lang['Delete_disallow_title'] = '删除禁止使用的用户名';
$lang['Delete_disallow_explain'] = '您可以从列表中选择要移除禁止使用的用户名';

$lang['Add_disallow'] = '添加';
$lang['Add_disallow_title'] = '增加禁止使用的用户名';
$lang['Add_disallow_explain'] = '请输入用户名，您可以使用通配符 * 来禁用范围较大的用户名';

$lang['No_disallowed'] = '没有禁止使用的用户名';

$lang['Disallowed_deleted'] = '您所选择的禁用帐号名称已成功被移除';
$lang['Disallow_successful'] = '新的禁止使用的用户名已经成功加入';
$lang['Disallowed_already'] = '无法禁止使用您所输入的用户名，该用户名可能已在禁用列表内或已被注册使用';

$lang['Click_return_disallowadmin'] = '点击 %s这里%s 返回敏感用户名控制面板';

//
// 安装
//
$lang['Welcome_install'] = '欢迎使用 phpBB-WAP';
$lang['Initial_config'] = '安装配置';
$lang['DB_config'] = '数据库配置';
$lang['Admin_config'] = '管理配置';
$lang['continue_upgrade'] = '在您下载完系统设定文件（config.php）之后，您可以按下 继续升级 的按钮继续下一步. 请在所有升级程序完成后再上传设定档.';
$lang['upgrade_submit'] = '继续升级';

$lang['Installer_Error'] = '安装过程错误';
$lang['Previous_Install'] = '您之前已经安装过';
$lang['Install_db_error'] = '安装时数据出错';

$lang['Re_install'] = '您先前安装的 phpBB-WAP 论坛系统正在运行中<br />如果您希望重新安装 phpBB-WAP 论坛系统请选择 是 的按钮，请注意,执行后将会移除所有的现存资料，而且不会有任何备份！系统管理员帐号及密码将被重新建立，所有设定也将不会被保留。<br />请在您按下 是 的按钮前谨慎考虑！';

$lang['Inst_Step_0'] = '感谢您选择 phpBB-WAP 论坛系统，您必须填写下列资料以完成安装程序。在安装前，请先确定您所要使用的数据库已经建立';

$lang['Start_Install'] = '开始安装';
$lang['Finish_Install'] = '完成安装';

$lang['Default_lang'] = '默认语言';
$lang['DB_Host'] = 'MySQL地址';
$lang['DB_Name'] = '数据库名称';
$lang['DB_Username'] = '数据库用户名';
$lang['DB_Password'] = '数据库密码';
$lang['Database'] = '数据库';
$lang['Install_lang'] = '选择安装语言';
$lang['dbms'] = 'MySQL版本';
$lang['Table_Prefix'] = '数据表前缀';
$lang['Admin_Username'] = '管理员用户名';
$lang['Admin_Password'] = '管理员密码';
$lang['Admin_Password_confirm'] = '确认管理员密码';

$lang['Inst_Step_2'] = '您的网站管理员用户已经建立，相关基本安装过程已经完成，您将可以使用管理员用户名称对新安装的论坛进行管理，请检查整体设置资料并依据您的意愿进行任何修改，谢谢您选择 phpBB-WAP';

$lang['Unwriteable_config'] = '您的系统设定档无法写入，您可以点击下方按钮下载设定文件，再将这个文件上传至 phpBB-WAP 论坛的资料夹。在完成后您必须使用管理员帐号跟密码登陆并进入系统管理控制面板（在您登陆后，下方将出现一个 “超级管理面板” 的链接）检查您的基本配置设定，最后感谢您选择使用安装的 phpBB-WAP 论坛系统.';
$lang['Download_config'] = '下载配置';

$lang['ftp_choose'] = '选择下载方式';
$lang['ftp_option'] = '<br />在 FTP 设定完成后，您可以使用自动上传的功能';
$lang['ftp_instructs'] = '您已经选择使用 FTP 去自动安装您的 phpBB-WAP 论坛。请输入下列资料来简化这个过程。请注意：FTP 路径须跟您安装 phpBB-WAP 的 FTP 路径完全相同';
$lang['ftp_info'] = '输入您的 FTP 信息';
$lang['Attempt_ftp'] = '使用 FTP 上传设定文件:';
$lang['Send_file'] = '自行上传设定文件';
$lang['ftp_path'] = '安装 phpBB-WAP 的 FTP 路径:';
$lang['ftp_username'] = '您的 FTP 用户名称';
$lang['ftp_password'] = '您的 FTP 用户密码';
$lang['Transfer_config'] = '开始传送';
$lang['NoFTP_config'] = 'FTP 上传设定文件失败，请下载设定文件并使用手动上传';

$lang['Install'] = '全新安装';
$lang['Upgrade'] = '升级版本';


$lang['Install_Method'] = '请选择安装模式';

$lang['Install_No_Ext'] = '您服务器上的PHP配置不支持您所选择的数据库类型';

$lang['Install_No_PCRE'] = '您的PHP配置不支持安装phpBB-WAP所需要的Perl语言标准表达模式的兼容性';

//
// 风格
//

$lang['Confirm_delete_style'] = '请确认是否删除这个风格？';

//
// Shop
//
$lang['Shop'] = '商店相关管理';
$lang['Shop_url'] = '出售 URL';
$lang['Shop_sites'] = '出售链接';
$lang['Shop_icq'] = '出售ICQ';
$lang['Shop_Config'] = '全局设置';
$lang['Shop_meney'] = '金币管理';
$lang['Shop_pay'] = '支付管理';
// 需要该功能自己汉化
$lang['Shop_Open_Pay_money'] = 'Включить систему выплат за сообщения';
$lang['Shop_Kurs_Payment'] = 'Курс обмена монет на рубли (сколько выдавать рублей за одну монету)';
$lang['Shop_Kurs_Payment_Explain'] = 'в случае, если вы хотите указать не целое число, то вместо запятой используйте <b>точку</b>, например 0.4';
$lang['Shop_Error_Not_Open_Pay_money'] = 'Система выплат на этом форуме отключена.';
$lang['Shop_Cancel_User_Pay_money'] = 'Заработанная юзером %s сумма в %s руб аннулирована.';
$lang['Shop_Message_User_Pay_money'] = 'Сумма в %s руб помечена у юзера %s как выплаченная.<br />Перечислите ему эту сумму на кошелёк %s';
$lang['Shop_Pay_money_Explain'] = 'Здесь вы можете произвести выплаты отдельным пользователям, либо сбросить (аннулировать) их рублёвый заработок, например, за нарушения.<br />На данный момент юзерами всего заработано %s руб, из них вами выплачено %s руб.';
$lang['Shop_Not_Pay_Money_Users'] = 'Пока некому выплачивать';
$lang['Shop_Note_Pay_Money'] = '* - в этом списке отображаются только те пользователи, у которых есть рубли на виртуальном счёте';
$lang['Shop_Cancel'] = 'сброс';
$lang['Shop_Pay_Money'] = 'Конвертировать в рубли';

//
// 编辑网页
//
$lang['Edit_Page'] = '网页编辑';
$lang['Edit_Page_Direct_Select'] = '直接选择';
$lang['Edit_Page_Enter_Select'] = '输入选择';

//
// That's all Folks!
// -------------------------------------------------
// Start add - 在线/离线/隐身 Mod
$lang['Online_time'] = '在线时间';
$lang['Online_time_explain'] = '用户显示在线的时间（要求大与60秒）';
$lang['Online_setting'] = '在线设置';
$lang['Online_color'] = '在线颜色';
$lang['Offline_color'] = '离线颜色';
$lang['Hidden_color'] = '隐身颜色';
// End add - 在线/离线/隐身 Mod
$lang['Max_Topics_per_page'] ='每页主题的最大数量'; 
$lang['Max_Posts_per_page'] ='每页发帖的最大数目'; 

//
// Democracy MOD
//
$lang = array(
	'reputation_democracy' => '评价系统',
	'reputation_democracy_exp' => '',
	'reputation_enable' => '开启评价系统',
	'reputation_enable_warnings' => '启用警告功能',
	'reports_enabled' => '帖子主持人',
	'reputation_positive_only' => '只可以给予好的评价(+)',
	'reputation_positive_only_exp' => '用户不能给予差评，如果给予差评，那么它是保持不变的',
	'reputation_empty_reviews' => '允许空的评论',
	'reputation_reputation_options' => '评价设置',
	'reputation_warnings_options' => '警告设置',
	'reputation_reports_options' => '报告选项',
	'Click_return_reputation_index' => '点击 %s这里%s 返回到评价系统',

	'reputation_access_rights' => '访问权限',
	'reputation_add_rep' => '添加评论',
	'reputation_add_rep_nonpost' => '添加评价（可以不发表评论）',
	'reputation_edit_rep' => '编辑评论',
	'reputation_delete_rep' => '删除评论',
	'reputation_no_limits' => '没有限制',
	'reputation_warn' => '发出警告',
	'reputation_warn_nonpost' => '发出警告（不发表）',
	'reputation_ban' => '黑名单',
	'reputation_ban_nonpost' => '黑名单（不发表）',
	'reputation_edit_warns' => '编辑警告',
	'reputation_delete_warns' => '删除警告',
	'reputation_not_applicable' => '不适用于',
	'reputation_anonymous_view_rep' => '匿名用户可以浏览和评论',
	'reputation_anonymous_view_warns' => '匿名用户可以浏览和查看评论',
	'reputation_perms_notes' => '* = 只有自己<br />** = 只有在这些论坛, 他/她是一个版主',
	'reputation_warn_perms_notes' => '',

	'reputation_days_req' => '注册时间不小于 %s 天',
	'reputation_posts_req' => '发表的帖子不少于 %s 帖',
	'reputation_warnings_req' => '不多于 %s 警告',
	'reputation_points_req' => '如果得到一个好的评价增加 %s 积分',
	'reputation_time_limit' => '用户可以在评论后 %s 分钟内修改评论',
	'reputation_rotation_limit' => '旋转变化: %s 用户.',
	'reputation_rotation_limit_exp' => '有多少不同的用户需要更改的声誉，你可以改变的声誉两次以相同的用户。',
	'reputation_most_respected' => 'Показывать %s наиболее уважаемых пользователей.',//不知道是什么
	'reputation_least_respected' => 'Показывать %s наименее уважаемых пользователей.',//不知道是什么
	'reputation_display' => '个人资料显示选项',
	'reputation_display_sum' => '只显示总数',
	'reputation_display_plusminus' => '显示好评与和差评(+2/-3)',

	'reputation_infinite' => '没有限制',
	'reputation_infinite_exp' => '如果设置为无限制，版主、管理员需要手动删除发出的警告',
	'reputation_infinite_ban_exp' => '如果设置为无限制，版主、管理员需要手动删除用户黑名单',
	'reputation_fixed' => '固定 %s 天.',
	'reputation_modifiable' => '您可以更改 %s 至 %s 之间',
	'reputation_modifiable_exp' => '您可以留下一个或两个字段留空不设限。',
	'reputation_store' => '存储',
	'reputation_delete_days' => '%s 天后删除',
	'reputation_ban_warnings' => '自动禁止 %s 警告和黑名单',
	'reputation_ban_warnings_exp' => '最新的警告禁止自动转换。',
	'reputation_check_rate' => '检测 %s 分钟内有效的警告',
	'reputation_check_rate_exp' => '数值的大小设定会对服务器造成一定的负担',

	'reputation_check_confirm' => 'Подтвердите намеренность изменений, установив соответствующую галочку!',

	'reputation_reports_color' => 'Цвет для выделения ссылки на страницу уведомлений:',
	'reputation_reports_color_exp' => 'Оставьте поле пустым, чтобы не выделять ссылку цветом.',

	'reputation_warning_expiry' => '警告时间设定',
	'reputation_ban_expiry' => '黑名单时间设定',
	'reputation_expired_warnings' => '过期的警告',
	'reputation_index_page' => '声誉',
	'reputation_prerequirements' => '要求',
	'reputation_limits' => '其他限制',

	'reputation_maintenance' => '实用工具',
	'reputation_resync' => '同步评价系统设定',
	'reputation_resync_exp' => '本地与数据库的设定进行同步',
	'reputation_success' => '同步成功！',

	/*
	'reputation_reports_per_page' => 'Количество сообщений модераторам на страницу',
	'reputation_reviews_per_page' => 'Количество отзывов на страницу',
	'reputation_allow_empty_warns' => 'Разрешить предупреждения без указания причины',
	*/
) + $lang;

// Start add - Birthday MOD
$lang['Birthday_required'] ='是否要求用户注册时填写生日'; 
$lang['Enable_birthday_greeting'] ='是否开启用户生日祝福'; 
$lang['Birthday_greeting_expain'] ='当用户过生日时首页将送上用户的祝福'; 
$lang['Next_birthday_greeting'] ='为下一个过生日的用户送上祝福'; 
$lang['Next_birthday_greeting_expain'] ='当用户将快要过生日时，系统讲为下一个过生日的用户送上祝福'; 
$lang['Wrong_next_birthday_greeting'] ='您输入的出生年月是无效的，请再试一次'; 
$lang['Max_user_age'] = '用户填写生日时可填写的最大年龄';
$lang['Min_user_age'] ='用户填写生日时可填写的最低年龄'; 
$lang['Birthday_lookforward'] ='是否在网站首页显示用户的生日'; 
// End add - Birthday MOD

// 登录限制
$lang['Max_login_attempts'] = '最多允许登录尝试次数'; 
$lang['Max_login_attempts_explain'] ='防止用户尝试盗取会员密码以及机器人！'; 
$lang['Login_reset_time'] ='登录重置时间'; 
$lang['Login_reset_time_explain'] ='当用户登录超过 最多允许登录尝试次数 时，网站会锁定该用户名，需要等待多少时间（单位/分）才可以解除锁定'; 

// 奖
$lang['Medals'] = '奖的管理';
$lang['Medal_Config'] = '奖配置';
$lang['Medal_Config_explain'] = '在这里，您可以指定该奖的基本设置以及编辑奖';
$lang['Medal_setting'] = '奖设置';
$lang['Allow_medal'] = '是否允许使用论坛奖';
$lang['Medal_rand'] = '随机显示一个奖';
$lang['Medal_rand_explain'] = '它会显示一个随机的图像';
$lang['Medal_display'] = '表奖（行数×列数）';
$lang['Medal_display_explain'] = '指定的行数和列数每页<B>奖显示主题</ b><br />例如，一行和一列会显示一个图像，1号线和2列 - 2张图片。 <br/>确保设置是正确的，并不会造成问题时，显示该主题。';
$lang['Medal_size'] = '奖图标大小';
$lang['Medal_size_explain'] = '（最大 x Высота ），如果没有指定则按原图显示';
$lang['Click_return_medalcfg'] = '点击 %s这里%s 返回奖管理面板';
$lang['Medal_admin'] = '奖管理';
$lang['Medal_admin_explain'] = '在这里，您可以管理网站所有的奖，您也可以指定版主的奖和建立它的名称、说明和图标';
$lang['Updated_medal'] = '奖的设定已成功更新';
$lang['Updated_medal_category'] = '奖的分类已成功更新';
$lang['Added_new_medal'] = '奖已成功创建';
$lang['Added_new_category'] = '奖分类已成功创建';
$lang['Deleted_medal'] = '奖已成功删除';
$lang['Deleted_medal_category'] = '奖的分类已成功删除';
$lang['New_medal'] = '创建奖';
$lang['medal_name'] = '奖名称';
$lang['medal_description'] = '奖描述';
$lang['medal_image'] = '奖图片';
$lang['medal_image_explain'] = '填写奖图标的路径（使用 phpBB-WAP 的绝对路径）';
$lang['No_medal_name'] = '没有指定奖的名称';
$lang['No_medal_description'] = '没有指定奖的描述';
$lang['No_medal_image'] = '没有指定奖的图片';
$lang['Must_select_medal'] = '您必须选择一个奖';
$lang['Click_return_medaladmin'] = '点击 %s这里%s 返回奖管理面板';
$lang['Medal_mod'] = '版主奖';
$lang['Medal_mod_admin'] = '管理版主奖';
$lang['Medal_mod_admin_explain'] = '在这里，您可以管理管理员与版主的奖！';
$lang['Medal_mod_username'] = '版主的用户名';
$lang['Medal_unmod_username'] = '剥去奖';
$lang['Medal_unmod_username_explain'] = '剥去版主用户的奖';
$lang['No_medal_mod'] = '没有版主奖';
$lang['No_medal_in_cat'] = '这个分类目录下没有奖';
$lang['Must_delete_medal'] = '您必须删除奖';
$lang['Category_delete'] = '删除分类';
$lang['Category_delete_explain'] = '在删除这个分类之前，您必须先删除分类底下的所有奖';
$lang['Move_medals'] = '移动奖';
$lang['Category_name'] = '分类名称';
$lang['Medal_mod_update_sucessful'] = '版主奖已成功更新';
$lang['Click_return_medal_mod_admin'] = '点击 %s这里%s 返回版主奖管理面板';

//
// 用户账户操作
//
$lang['Account_actions'] = '账户操作';
$lang['Account_inactive_explain'] = '等待激活的用户帐号';
$lang['Account_active_explain'] = '已激活的用户帐号';
$lang['Account_active'] = '激活';
$lang['Account_inactive'] = '等待激活';
$lang['Account_activate'] = '激活';
$lang['Account_deactivate'] = '停用';
$lang['Account_none'] = '没有此帐号.';
$lang['Account_activation'] = '激活方法';
$lang['Account_inactive'] = '等待激活帐号';
$lang['Account_active'] = '已经激活账号';
$lang['Account_delete_users'] = '请确认是否删除这些用户帐号？';
$lang['Account_delete_user'] = '请确认是否删除这个用户帐号？';
$lang['Account_all'] = '全部';
$lang['Account_year'] = '年';
$lang['Account_years'] = '年';
$lang['Account_week'] = '周';
$lang['Account_weeks'] = '周';
$lang['Account_day'] = '天';
$lang['Account_days'] = '天';
$lang['Account_hour'] = '小时';
$lang['Account_hours'] = '小时';
$lang['Account_user_activated'] = '激活';
$lang['Account_users_activated'] = '激活';
$lang['Account_user_deactivated'] = '停用';
$lang['Account_users_deactivated'] = '停用';
$lang['Account_user_deleted'] = '删除';
$lang['Account_users_deleted'] = '删除';
$lang['Account_activated'] = '用户帐号激活';
$lang['Account_activated_text'] = '用户帐户已激活';
$lang['Account_deactivated'] = '停用用户帐号';
$lang['Account_deactivated_text'] = '用户帐号已停用';
$lang['Account_deleted'] = '删除用户帐号';
$lang['Account_deleted_text'] = '用户帐号已删除';
$lang['Account_notification'] = '用电子邮件通知用户';

// 留言板
$lang['gb_no_guest'] = '匿名用户(论坛游客)可以在留言板留言?';
$lang['gb_can'] = '是否显示留言板?';
$lang['gb_post'] = '同一个用户允许留言的数量(0代表无限)';
$lang['gb_quick'] = '是否允许给自己留言?';

// 模版编辑 Mod
$lang['Template_Edit_Choose'] = '请选择一个文件夹或文件';
$lang['Template_Edit_No_Template'] = '文件夹不存在！';
$lang['Template_Edit_No_File'] = '文件不存在！';
$lang['Template_Edit'] = '编辑文件';
$lang['Template_Edit_No_Open'] = '无法打开文件！';
$lang['Template_Edit_No_Write'] = '无法写入文件！';
$lang['Template_Edit_Yes_Write'] = '文件编辑完成！';
$lang['Click_return_template_edit'] = '点击 %s返回%s 文件编辑';

// 全局版主
$lang['Modcp'] = '全局版主面板';
$lang['global_MOD'] = '全局版主';
?>