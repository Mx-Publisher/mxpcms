<?php
/***************************************************************************
 *                       lang_main.php [Simplified Chinese]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_main.php,v 1.85.2.15 2003/06/10 00:31:19 psotfx Exp $
 *
 ****************************************************************************/


/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// Translation by:
//      inker    :: http://www.byink.com
//
//      For questions and comments use: support@byink.com
//      last modify   : 2002/3/1
//

//
// Update by:
//	iCy-fLaME
//      For questions and comments use: icy_flame_hm@hotmail.com
//      last modify   : 05 Apr 2004
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//
$lang['General'] = "��ͨ����";
$lang['Users'] = "��Ա����";
$lang['Groups'] = "��Ա�����";
$lang['Forums'] = "�������";
$lang['Styles'] = "������";

$lang['Configuration'] = "����ѡ��";
$lang['Permissions'] = "Ȩ�޹���";
$lang['Manage'] = "����ѡ��";
$lang['Disallow'] = "�����ʺ�";
$lang['Prune'] = "ɾ������";
$lang['Mass_Email'] = "Ⱥ���ż�";
$lang['Ranks'] = "�ȼ�����";
$lang['Smilies'] = "�������";
$lang['Ban_Management'] = "��������";
$lang['Word_Censor'] = "���ֹ���";
$lang['Export'] = "���";
$lang['Create_new'] = "�½�";
$lang['Add_new'] = "����";
$lang['Backup_DB'] = "�������ݿ�";
$lang['Restore_DB'] = "�ָ����ݿ�";


//
// Index
//
$lang['Admin'] = "ϵͳ����";
$lang['Not_admin'] = "��û��Ȩ�޽������Ա�������";
$lang['Welcome_phpBB'] = "��ӭ���� phpBB 2 ����Ա�������";
$lang['Admin_intro'] = "��л��ѡ�� phpBB 2 ��Ϊ������̳ϵͳ. ������������������̳�ĸ���ͳ������. �κ�ʱ����������ͨ���������������Ϸ���<u>���������ҳ</u>���ص���һҳ. ������ڿ���������Ϸ��� phpBB ��־ͼʾ���Իص�������̳��ҳ.����������󷽵���������,������������̳�����й���ѡ��.ÿ���������и���ܵ�ʹ�����.";
$lang['Main_index'] = "������̳��ҳ";
$lang['Forum_stats'] = "��̳ͳ������";
$lang['Admin_Index'] = "���������ҳ";
$lang['Preview_forum'] = "Ԥ��������̳";

$lang['Click_return_admin_index'] = "��� %s����%s �ص����������ҳ";

$lang['Statistic'] = "ͳ������";
$lang['Value'] = "��ֵ";
$lang['Number_posts'] = "�����ܼ�";
$lang['Posts_per_day'] = "ƽ��ÿ�췢�������";
$lang['Number_topics'] = "�����ܼ�";
$lang['Topics_per_day'] = "ƽ��ÿ�췢�������";
$lang['Number_users'] = "ע���Ա�ܼ�";
$lang['Users_per_day'] = "ƽ��ÿ��ע��Ļ�Ա";
$lang['Board_started'] = "��̳��������";
$lang['Avatar_dir_size'] = "ͷ�����ϼ��ļ���С";
$lang['Database_size'] = "���ݿ��ļ���С";
$lang['Gzip_compression'] ="Gzip �ļ�ѹ����ʽ";
$lang['Not_available'] = "��";

$lang['ON'] = "����"; // This is for GZip compression
$lang['OFF'] = "�ر�";


//
// DB Utils
//
$lang['Database_Utilities'] = "���ݿ⹤�߹���";

$lang['Restore'] = "�ָ�";
$lang['Backup'] = "����";
$lang['Restore_explain'] = "�����ѡ���������Իָ� phpBB 2 ��ʹ�õ����ݿ���. ������ķ�����֧�� GZIP ѹ�����ļ�, �����������Զ���ѹ�����ϴ���ѹ���ļ�. <b>ע�⣡</b> �ָ������н�����ȫ���������ִ������. ���ݿ�ָ����̿��ܻỨ�ѽϳ���ʱ��, �ڻָ����ǰ�벻Ҫ�رջ��뿪���ҳ��.";
$lang['Backup_explain'] = "�����ѡ����,�����Ա��� phpBB 2 ��̳��������������. ��������������ж���ı����� phpBB 2 ��̳��ʹ�õ����ݿ���, ������Ҳ�뱸����Щ�ı��, �����·��� <b>���ӵı��</b> �����������ǵ����ֲ��ö������� (����: abc, cde). ������ķ�������֧�� GZIP ѹ����ʽ, ������������ǰʹ�� GZIP ѹ������С�ļ��Ĵ�С.";

$lang['Backup_options'] = "����ѡ��";
$lang['Start_backup'] = "��ʼ����";
$lang['Full_backup'] = "��������";
$lang['Structure_backup'] = "�ṹ����";
$lang['Data_backup'] = "���ݱ���";
$lang['Additional_tables'] = "���ӵı��";
$lang['Gzip_compress'] = "Gzip ѹ����ʽ";
$lang['Select_file'] = "ѡ���ļ�";
$lang['Start_Restore'] = "��ʼ�ָ�";

$lang['Restore_success'] = "���ݿ�ɹ��ָ�.<br /><br />��̳�ѱ��ָ��ɱ���ʱ��״̬.";
$lang['Backup_download'] = "��ȴ�. ���ı����ļ���������!";
$lang['Backups_not_supported'] = "�Բ���! �������ݲ�֧���������ݿ�ϵͳ";

$lang['Restore_Error_uploading'] = "�ϴ��ı����ļ�����";
$lang['Restore_Error_filename'] = "�ļ����ƴ���, ������ѡ���ļ�";
$lang['Restore_Error_decompress'] = "�޷���ѹ Gzip �ļ�, ���Դ����ָ�ʽ�ϴ�";
$lang['Restore_Error_no_file'] = "û���ļ����ϴ�";


//
// Auth pages
//
$lang['Select_a_User'] = "ѡ��һ���û�";
$lang['Select_a_Group'] = "ѡ��һ����Ա��";
$lang['Select_a_Forum'] = "ѡ��һ������";
$lang['Auth_Control_User'] = "��ԱȨ���趨";
$lang['Auth_Control_Group'] = "��Ա��Ȩ���趨";
$lang['Auth_Control_Forum'] = "����Ȩ���趨";
$lang['Look_up_User'] = "��ѯ��Ա";
$lang['Look_up_Group'] = "��ѯ��Ա��";
$lang['Look_up_Forum'] = "��ѯ����";

$lang['Group_auth_explain'] = "�����ѡ���������Ը��ĳ�Ա���Ȩ���趨��ָ������Ա�ʸ�. ��ע��, �޸ĳ�Ա��Ȩ���趨��, �����Ļ�ԱȨ�޿�����Ȼ����ʹ��Ա�������ư���. ��������������������ʾȨ�޳�ͻ�ľ���.";
$lang['User_auth_explain'] = "�����ѡ���������Ը��Ļ�Ա��Ȩ���趨��ָ������Ա�ʸ�. ��ע��, �޸Ļ�ԱȨ���趨��, �����Ļ�ԱȨ�޿�����Ȼ����ʹ��Ա�������ư���. ��������������������ʾȨ�޳�ͻ�ľ���.";
$lang['Forum_auth_explain'] = "�����ѡ���������Ը��İ����ʹ��Ȩ��. ������ѡ��ʹ�ü򵥻��Ǹ߼�����ģʽ, �߼�ģʽ���ṩ��������Ȩ���趨����. ��ע��, ���еĸı䶼����Ӱ�쵽��Ա�İ���ʹ��Ȩ��.";

$lang['Simple_mode'] = "��ģʽ";
$lang['Advanced_mode'] = "�߼�ģʽ";
$lang['Moderator_status'] = "����Ա�ʸ�";

$lang['Allowed_Access'] = "�������";
$lang['Disallowed_Access'] = "��ֹ����";
$lang['Is_Moderator'] = "ӵ�а������Ȩ��";
$lang['Not_Moderator'] = "û�а������Ȩ��";

$lang['Conflict_warning'] = "Ȩ�޳�ͻ����";
$lang['Conflict_access_userauth'] = "�����Ա��Ȼ����ͨ����Ա���Ա���ʸ�����ض��İ���. �����Ը��ĳ�Ա��Ȩ�޻���ȡ�������Ա�ĳ�Ա���ʸ�����ֹ�û�Ա�������Ƶİ���.��Ա��Ȩ������:";
$lang['Conflict_mod_userauth'] = "�����Ա��Ȼ����ͨ����Ա���Ա���ʸ�ӵ�а�������Ȩ��. �����Ը��ĳ�Ա��Ȩ�޻���ȡ�������Ա��Ȩ������ֹ�û�Ա���а������.�������Ȩ������:";

$lang['Conflict_access_groupauth'] = "���л�Ա��Ȼ����ͨ����ԱȨ���趨��������ض��İ���. �����Ը��Ļ�ԱȨ����ȡ�����ǽ������Ƶİ���. ��ԱȨ������: ";
$lang['Conflict_mod_groupauth'] = "���л�Ա��Ȼ����ͨ�����ǵĻ�ԱȨ��ӵ�а�������Ȩ��. �����Ը��Ļ�ԱȨ����ȡ�����ǵİ������Ȩ��. ��ԱȨ������: ";

$lang['Public'] = "����";
$lang['Private'] = "�ǹ���";
$lang['Registered'] = "ע���Ա";
$lang['Administrators'] = "��̳����Ա";
$lang['Hidden'] = "����";

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = "ȫ��";
$lang['Forum_REG'] = "REG";
$lang['Forum_PRIVATE'] = "PRIVATE";
$lang['Forum_MOD'] = "MOD";
$lang['Forum_ADMIN'] = "����";

$lang['View'] = "���";
$lang['Read'] = "�Ķ�";
$lang['Post'] = "����";
$lang['Reply'] = "�ظ�";
$lang['Edit'] = "�༭";
$lang['Delete'] = "ɾ��";
$lang['Sticky'] = "�ö�";
$lang['Announce'] = "����";
$lang['Vote'] = "ͶƱ";
$lang['Pollcreate'] = "����ͶƱ";

$lang['Permissions'] = "Ȩ���趨";
$lang['Simple_Permission'] = "����Ȩ��";

$lang['User_Level'] = "��Ա�ȼ�";
$lang['Auth_User'] = "��Ա";
$lang['Auth_Admin'] = "��̳����Ա";
$lang['Group_memberships'] = "��Ա��Ա���б�";
$lang['Usergroup_members'] = "��Ա���Ա�б�";

$lang['Forum_auth_updated'] = "����Ȩ���趨����";
$lang['User_auth_updated'] = "��ԱȨ���趨����";
$lang['Group_auth_updated'] = "��Ա��Ȩ���趨����";

$lang['Auth_updated'] = "Ȩ���趨�Ѿ�����";
$lang['Click_return_userauth'] = "��� %s����%s ���ػ�ԱȨ���趨";
$lang['Click_return_groupauth'] = "��� %s����%s ���س�Ա��Ȩ���趨";
$lang['Click_return_forumauth'] = "��� %s����%s ���ذ���Ȩ���趨";


//
// Banning
//
$lang['Ban_control'] = "��������";
$lang['Ban_explain'] = "�����ѡ�����������趨��Ա�ķ���. �����Է���һ��ָ���Ļ�Ա��һ��ָ����Χ�� IP ��ַ���Ǽ������������, ��Щ������ֹ�������Ļ�Ա������̳��ҳ. ��Ҳ����ָ�����������ʼ���ַ����ֹע���Աʹ�ò�ͬ���ʺ��ظ�ע��. ��ע�⵱��ֻ�Ƿ���һ�������ʼ���ַʱ������Ӱ�쵽��Ա������̳�ĵ�½���Ƿ�������, ��Ӧ��ʹ��ǰ�����ַ�ʽ����֮һ��������һ������������.";
$lang['Ban_explain_warn'] = "��������һ��IP��ַ��Χʱ, �����Χ�����е�IP��ַ�����ᱻ����. ������ʹ��ͳ��� * ����Ҫ������ip��ַ�����ͱ������Ŀ���. �����һ��Ҫ����һ����Χ�뾡�����־�����ʵ�����Ӱ��������ʹ��.";

$lang['Select_username'] = "ѡ��һ����Ա����";
$lang['Select_ip'] = "ѡ��һ�� IP ��ַ";
$lang['Select_email'] = "ѡ��һ�������ʼ���ַ";

$lang['Ban_username'] = "����һ������ָ���Ļ�Ա����";
$lang['Ban_username_explain'] = "������ʹ��������ϼ� (��: Ctrl �� Shift)һ�η��������Ա����";

$lang['Ban_IP'] = "����һ������ IP ��ַ���Ǽ������������";
$lang['IP_hostname'] = "IP ��ַ���Ǽ������������";
$lang['Ban_IP_explain'] = "Ҫָ�������ͬ�� IP ��ַ������������, ��ʹ�ö��� ',' ���ָ�����. Ҫָ�� IP ��ַ�ķ�Χ, ��ʹ�� '-' ���ָ���ʼ��ַ��������ַ, ����ʹ��ͳ��� '*'";

$lang['Ban_email'] = "����һ�����������ʼ���ַ";
$lang['Ban_email_explain'] = "Ҫָ�������ͬ�ĵ����ʼ���ַ, ��ʹ�ö��� ',' ���ָ�����, ����ʹ��ͨ��� '*', ����: *@hotmail.com";

$lang['Unban_username'] = "���һ�����������Ļ�Ա����";
$lang['Unban_username_explain'] = "������ʹ����꼰��ϼ� (��: Ctrl �� Shift)һ�ν����������Ļ�Ա����";

$lang['Unban_IP'] = "���һ������������ IP ��ַ";
$lang['Unban_IP_explain'] = "������ʹ����꼰��ϼ� (����: Ctrl �� Shift), һ�ν����������� IP ��ַ";

$lang['Unban_email'] = "���һ�����������ĵ����ʼ���ַ";
$lang['Unban_email_explain'] = "������ʹ����꼰��ϼ� (����: Ctrl �� Shift), һ�ν����������ĵ����ʼ���ַ";

$lang['No_banned_users'] = "û�б������Ļ�Ա����";
$lang['No_banned_ip'] = "û�б������� IP ��ַ";
$lang['No_banned_email'] = "û�б������ĵ����ʼ���ַ";

$lang['Ban_update_sucessful'] = "�����б��Ѿ��ɹ�����";
$lang['Click_return_banadmin'] = "��� %s����%s ���ط����趨";


//
// Configuration
//
$lang['General_Config'] = "��������";
$lang['Config_explain'] = "������ʹ�����б��������һ����趨ѡ��. ��Ա�������趨��ʹ�û����� (��̳����) ���������.";

$lang['Click_return_config'] = "��� %s����%s ���ػ�������";

$lang['General_settings'] = "�����������";
$lang['Server_name'] = "����";
$lang['Server_name_explain'] = "������̳������λ�õ�����The domain name this board runs from";
$lang['Script_path'] = "�ű�·��";
$lang['Script_path_explain'] = "������̳��Ӧ��������·��";
$lang['Server_port'] = "����˿�";
$lang['Server_port_explain'] = "���ķ����������еĶ˿�,Ĭ��ֵ��80,ֻ���ڷ�Ĭ��ֵʱ�ı����ѡ��";
$lang['Site_name'] = "��̳����";
$lang['Site_desc'] = "��̳����";
$lang['Board_disable'] = "�ر���̳";
$lang['Board_disable_explain'] = "�⽫��ر���̳. ����ִ������趨ʱ����ǳ�,�����޷����µ�½!";
$lang['Acct_activation'] = "�����ʺż���";
$lang['Acc_None'] = "�ر�"; // These three entries are the type of activation
$lang['Acc_User'] = "�ɻ�Ա����";
$lang['Acc_Admin'] = "�ɹ���Ա����";

$lang['Abilities_settings'] = "��Ա����������趨";
$lang['Max_poll_options'] = "ͶƱ��Ŀ�������Ŀ";
$lang['Flood_Interval'] = "��ˮ�ж�";
$lang['Flood_Interval_explain'] = "���·���ļ��ʱ�� (��)";
$lang['Board_email_form'] = "��Ա�����ʼ��б�";
$lang['Board_email_form_explain'] = "��Ա���Ի��෢�͵����ʼ��������̳";
$lang['Topics_per_page'] = "ÿҳ��ʾ������";
$lang['Posts_per_page'] = "ÿҳ��ʾ������";
$lang['Hot_threshold'] = "���Ż����趨��";
$lang['Default_style'] = "Ԥ����";
$lang['Override_style'] = "���ӻ�Աѡ��ķ��";
$lang['Override_style_explain'] = "����Ա��ѡ�ķ���ΪԤ����";
$lang['Default_language'] = "Ԥ������";
$lang['Date_format'] = "���ڸ�ʽ";
$lang['System_timezone'] = "ϵͳʱ��";
$lang['Enable_gzip'] = "���� GZip �ļ�ѹ����ʽ";
$lang['Enable_prune'] = "�����ƻ�ɾ��ģʽ";
$lang['Allow_HTML'] = "����ʹ�� HTML �﷨";
$lang['Allow_BBCode'] = "����ʹ�� BBCode ����";
$lang['Allowed_tags'] = "����ʹ�� HTML ��ǩ";
$lang['Allowed_tags_explain'] = "�Զ��ŷָ� HTML ��ǩ";
$lang['Allow_smilies'] = "����ʹ�ñ������";
$lang['Smilies_path'] = "������Ŵ���·��";
$lang['Smilies_path_explain'] = "���� phpBB 2 ��Ŀ¼���µ�·��, ����: images/smilies";
$lang['Allow_sig'] = "����ʹ��ǩ����";
$lang['Max_sig_length'] = "ǩ���������޶�";
$lang['Max_sig_length_explain'] = "�û�����ǩ������ʹ������";
$lang['Allow_name_change'] = "������ĵ�½����";

$lang['Avatar_settings'] = "����ͷ���趨";
$lang['Allow_local'] = "ʹ��ϵͳ���";
$lang['Allow_remote'] = "��������ͷ��ͼƬ";
$lang['Allow_remote_explain'] = "��������ַ����ͷ��ͼƬ";
$lang['Allow_upload'] = "�����û��ϴ�ͷ��";
$lang['Max_filesize'] = "ͷ���ļ���С�趨";
$lang['Max_filesize_explain'] = "���û��ϴ�ͷ��ͼƬ";
$lang['Max_avatar_size'] = "ͼƬ��С���ɴ��";
$lang['Max_avatar_size_explain'] = "(�� x �� ����)";
$lang['Avatar_storage_path'] = "����ͷ�񴢴�·��";
$lang['Avatar_storage_path_explain'] = "���� phpBB 2 ��Ŀ¼���µ�·��, ����: images/avatars";
$lang['Avatar_gallery_path'] = "ϵͳ��ᴢ��·��";
$lang['Avatar_gallery_path_explain'] = "���� phpBB 2 ��Ŀ¼���µ�·��, ����: images/avatars/gallery";

$lang['COPPA_settings'] = "COPPA (������ͯ��·��˽������) �趨";
$lang['COPPA_fax'] = "COPPA �������";
$lang['COPPA_mail'] = "COPPA �ʵݵ�ַ";
$lang['COPPA_mail_explain'] = "���ǹ��ҳ����� COPPA ��Աע����������ʵݵ�ַ";

$lang['Email_settings'] = "�����ʼ��趨";
$lang['Admin_email'] = "��̳����Ա�����ʼ�����";
$lang['Email_sig'] = "�����ʼ�ǩ����";
$lang['Email_sig_explain'] = "���ǩ�������ᱻ��������������̳ϵͳ�ͳ��ĵ����ʼ���";
$lang['Use_SMTP'] = "ʹ�� SMTP ���������͵����ʼ�";
$lang['Use_SMTP_explain'] = "�������Ҫʹ�� SMTP ���������͵����ʼ���ѡ�� '��'";
$lang['SMTP_server'] = "SMTP ����������";
$lang['SMTP_username'] = "SMTP �û���";
$lang['SMTP_username_explain'] = "ֻ������smtp������Ҫ���û�ʱ����д���ѡ��";
$lang['SMTP_password'] = "SMTP ����";
$lang['SMTP_password_explain'] = "ֻ������smtp������Ҫ������ʱ����д���ѡ��";

$lang['Disable_privmsg'] = "˽����Ϣ";
$lang['Inbox_limits'] = "�ռ����������";
$lang['Sentbox_limits'] = "�ļ����������";
$lang['Savebox_limits'] = "������������";

$lang['Cookie_settings'] = "Cookie �趨";
$lang['Cookie_settings_explain'] = "��Щ�趨������ Cookie �Ķ���, ��һ������, ʹ��ϵͳԤ��ֵ�Ϳ�����. �����Ҫ������Щ�趨, ������趨, �������趨��Ӱ���Ա�ĵ�½";
$lang['Cookie_domain'] = "Cookie ����";
$lang['Cookie_name'] = "Cookie ����";
$lang['Cookie_path'] = "Cookie ·��";
$lang['Cookie_secure'] = "Cookie ���� [ https ]";
$lang['Cookie_secure_explain'] = '������ķ�����ʹ�� SSL, ��ʹ�ø�ѡ��';
$lang['Session_length'] = "Session ���ʱ�� [ �� ]";

// Visual Confirmation
$lang['Visual_confirm'] = 'ʹ���Ӿ���֤';
$lang['Visual_confirm_explain'] = 'Ҫ��������ע���ʱ��������ͼ�ζ������֤��.';

//
// Forum Management
//
$lang['Forum_admin'] = "��̳�������";
$lang['Forum_admin_explain'] = "������������������������, ɾ��, �༭���������з����Ͱ���, �Լ��趨�����ڵ���Ӧ����.";
$lang['Edit_forum'] = "�༭����";
$lang['Create_forum'] = "�����°���";
$lang['Create_category'] = "�����·���";
$lang['Remove'] = "ɾ��";
$lang['Action'] = "ִ��";
$lang['Update_order'] = "��������";
$lang['Config_updated'] = "��̳���óɹ�����";
$lang['Edit'] = "�༭";
$lang['Delete'] = "ɾ��";
$lang['Move_up'] = "�����ƶ�";
$lang['Move_down'] = "�����ƶ�";
$lang['Resync'] = "������Ӧ����";
$lang['No_mode'] = "û���趨ģʽ";
$lang['Forum_edit_delete_explain'] = "������ʹ�����б��������һ����趨ѡ��. ��Ա�������趨��ʹ�û����� (ϵͳ����) ���������.";

$lang['Move_contents'] = "�ƶ���������";
$lang['Forum_delete'] = "ɾ������";
$lang['Forum_delete_explain'] = "������ʹ�����б����ɾ������ (�����), �����ƶ������ڰ����ڵ�������������.";

$lang['Status_locked'] = '�Ѷ���';
$lang['Status_unlocked'] = '����';
$lang['Forum_settings'] = "��������趨";
$lang['Forum_name'] = "��������";
$lang['Forum_desc'] = "��������";
$lang['Forum_status'] = "����״̬";
$lang['Forum_pruning'] = "�ƻ�ɾ��";

$lang['prune_freq'] = '���ڼ������';
$lang['prune_days'] = "ɾ���ڼ�����û�����»ظ�������";
$lang['Set_prune_data'] = "���Ѿ���������ƻ�ɾ�ĵĹ���, ����δ�������趨. ��ص���һ���趨��ص���Ŀ";

$lang['Move_and_Delete'] = "�ƶ�/ɾ��";

$lang['Delete_all_posts'] = "ɾ����������";
$lang['Nowhere_to_move'] = "û���ƶ���λ��";

$lang['Edit_Category'] = "�༭��������";
$lang['Edit_Category_explain'] = "ʹ�����±���޸ķ�������";

$lang['Forums_updated'] = "���漰�������ϳɹ�����";

$lang['Must_delete_forums'] = "��ɾ���������֮ǰ, ��������ɾ���������µ����а���";

$lang['Click_return_forumadmin'] = "��� %s����%s ���ذ������";


//
// Smiley Management
//
$lang['smiley_title'] = "������ű༭";
$lang['smile_desc'] = "�����ѡ����, ����������, ɾ�����Ǳ༭������Ż������Ű��Ա��Ա�����·�����Ǹ�����Ϣ��ʹ��.";

$lang['smiley_config'] = "��������趨";
$lang['smiley_code'] = "������Ŵ���";
$lang['smiley_url'] = "����ͼƬ";
$lang['smiley_emot'] = "��������";
$lang['smile_add'] = "����һ���±���";
$lang['Smile'] = "����";
$lang['Emotion'] = "��������";

$lang['Select_pak'] = "ѡ��ı�����Ű� (.pak) �ļ�";
$lang['replace_existing'] = "�滻���еı������";
$lang['keep_existing'] = "�������еı������";
$lang['smiley_import_inst'] = "��Ӧ��������Ű���ѹ���ϴ����ʵ��ı������Ŀ¼.  Ȼ��ѡ����ȷ����Ŀ����������.";
$lang['smiley_import'] = "���������Ű�";
$lang['choose_smile_pak'] = "ѡ��һ��������Ű� .pak �ļ�";
$lang['import'] = "����������";
$lang['smile_conflicts'] = "�ڳ�ͻ���������Ӧ������ѡ��";
$lang['del_existing_smileys'] = "����ǰ��ɾ���ɵı������";
$lang['import_smile_pack'] = "���������Ű�";
$lang['export_smile_pack'] = "����������Ű�";
$lang['export_smiles'] = "����ϣ�������еı�����������ɱ�����Ű�, ���� %s����%s ���� smiles.pak �ļ�, ��ȷ�����׺Ϊ.pak.";

$lang['smiley_add_success'] = "�µı�������Ѿ��ɹ�����";
$lang['smiley_edit_success'] = "��������Ѿ��ɹ�����";
$lang['smiley_import_success'] = "������Ű��Ѿ��ɹ�����!";
$lang['smiley_del_success'] = "��������Ѿ��ɹ�ɾ��";
$lang['Click_return_smileadmin'] = "��� %s����%s ���ر�����ű༭";


//
// User Management
//
$lang['User_admin'] = "��Ա����";
$lang['User_admin_explain'] = "��������������, �����Ա����Ա�ĸ��������Լ��ִ������ѡ��. �����Ҫ�޸Ļ�Ա��Ȩ��, ��ʹ�û�Ա����Ա������Ȩ���趨����.";

$lang['Look_up_user'] = "��ѯ��Ա";

$lang['Admin_user_fail'] = "�޷����»�Ա�ĸ�������";
$lang['Admin_user_updated'] = "��Ա�ĸ��������Ѿ��ɹ�����";
$lang['Click_return_useradmin'] = "��� %s����%s ���ػ�Ա����";

$lang['User_delete'] = "ɾ����Ա";
$lang['User_delete_explain'] = "������ｫ��ɾ����Ա, ���ѡ���޷��ָ�";
$lang['User_deleted'] = "��Ա���ɹ�ɾ��.";

$lang['User_status'] = "��Ա�ʺ��Ѽ���";
$lang['User_allowpm'] = "����ʹ��˽��ѶϢ";
$lang['User_allowavatar'] = "����ʹ�ø���ͷ��";

$lang['Admin_avatar_explain'] = "�����ѡ�������������ɾ����Ա�ִ�ĸ���ͷ��";

$lang['User_special'] = "����Աר��";
$lang['User_special_explain'] = "�����Ա����Ա���ʺż���״̬������δ��Ȩ��Ա��ѡ���趨, ��ͨ��Ա�޷����иı���Щ�趨";


//
// Group Management
//
$lang['Group_administration'] = "��Ա�����";
$lang['Group_admin_explain'] = "�������������������Թ������еĳ�Ա��, �����Խ���, ɾ���Լ��༭�ִ�ĳ�Ա��. ������ָ����Ա�����Ա, �趨��Ա��ģʽ (����/���/����) �Լ���Ա������ƺ�����.";
$lang['Error_updating_groups'] = "��Ա�����ʱ��������";
$lang['Updated_group'] = "��Ա���Ѿ��ɹ�����";
$lang['Added_new_group'] = "�µĳ�Ա���Ѿ��ɹ�����";
$lang['Deleted_group'] = "��Ա���ѱ�˳��ɾ��";
$lang['New_group'] = "�����³�Ա��";
$lang['Edit_group'] = "�༭��Ա��";
$lang['group_name'] = "��Ա������";
$lang['group_description'] = "��Ա������";
$lang['group_moderator'] = "��Ա�����Ա";
$lang['group_status'] = "��Ա��״̬";
$lang['group_open'] = "���ų�Ա��";
$lang['group_closed'] = "�رճ�Ա��";
$lang['group_hidden'] = "���س�Ա��";
$lang['group_delete'] = "ɾ����Ա��";
$lang['group_delete_check'] = "ɾ�������Ա��";
$lang['submit_group_changes'] = "�ύ����";
$lang['reset_group_changes'] = "�������";
$lang['No_group_name'] = "������ָ����Ա������";
$lang['No_group_moderator'] = "������ָ����Ա��Ĺ���Ա";
$lang['No_group_mode'] = "������ָ����Ա��״̬ (����/���/����)";
$lang['No_group_action'] = 'δָ������';
$lang['delete_group_moderator'] = "ɾ��ԭ�еĳ�Ա�����Ա?";
$lang['delete_moderator_explain'] = "���������˳�Ա�����Ա���ҹ�ѡ���ѡ��Ὣԭ�еĳ�Ա�����Ա�ӳ�Ա�����Ƴ�, �粻��ѡ, �����Ա����Ϊ��Ա�����ͨ��Ա.";
$lang['Click_return_groupsadmin'] = "��� %s����%s ���س�Ա�����.";
$lang['Select_group'] = "ѡ���Ա��";
$lang['Look_up_group'] = "��ѯ��Ա��";


//
// Prune Administration
//
$lang['Forum_Prune'] = "����ƻ�ɾ��";
$lang['Forum_Prune_explain'] = "�⽫ɾ���������޶�ʱ����û�лظ�������. �����û��ָ��ʱ�� (����), ���е����ⶼ���ᱻɾ��. �����޷�ɾ�����ڽ����е�ͶƱ������ǹ���. �������ֶ��Ƴ���Щ����.";
$lang['Do_Prune'] = "ִ�мƻ�ɾ��";
$lang['All_Forums'] = "���а���";
$lang['Prune_topics_not_posted'] = "ɾ���ڼ�����û�����»ظ�������";
$lang['Topics_pruned'] = "�ƻ�ɾ��������";
$lang['Posts_pruned'] = "�ƻ�ɾ��������";
$lang['Prune_success'] = "�ɹ���ɰ�������ɾ��";


//
// Word censor
//
$lang['Words_title'] = "���ֹ���";
$lang['Words_explain'] = "�������������������Խ���, �༭��ɾ����������, ��Щָ�������ֽ��ᱻ���˲����滻������ʾ. �����ԱҲ���޷�ʹ�ú�����Щ�޶����ֵ�������ע��. �޶�����������ʹ��ͳ��� (*), ����: *test* ������� detestable��, test* ���� testing��, *test ���� detest��";
$lang['Word'] = "��������";
$lang['Edit_word_censor'] = "�༭��������";
$lang['Replacement'] = "�滻����";
$lang['Add_new_word'] = "���ӹ�������";
$lang['Update_word'] = "���¹�������";

$lang['Must_enter_word'] = "����������Ҫ���˵����ּ����滻����";
$lang['No_word_selected'] = "��û��ѡ��Ҫ�༭�Ĺ�������";

$lang['Word_updated'] = "����ѡ��Ĺ��������Ѿ��ɹ�����";
$lang['Word_added'] = "�µĹ��������Ѿ��ɹ�����";
$lang['Word_removed'] = "����ѡ��Ĺ��������ѱ��ɹ��Ƴ�";

$lang['Click_return_wordadmin'] = "��� %s����%s �������ֹ���";


//
// Mass Email
//
$lang['Mass_email_explain'] = "�����ѡ���������Է��͵����ʼ�ѶϢ�����еĻ�Ա�����ض��ĳ�Ա��ĳ�Ա. �������ʼ�����������ϵͳ����Ա�ṩ�ĵ����ʼ�����, �����ܼ������ķ�ʽ���͸������ռ���. ����ռ���������, ϵͳ��Ҫ�ϳ���ʱ����ִ��, �����ύ�ͳ������ĵȺ�, <b>����</b>�ڳ������֮ǰֹͣ��ҳ����.���������ʱ����ʾ��ʾ.";
$lang['Compose'] = "д�ʼ�";

$lang['Recipients'] = "�ռ���";
$lang['All_users'] = "���л�Ա";

$lang['Email_successfull'] = "ѶϢ�Ѿ��ĳ�";
$lang['Click_return_massemail'] = "��� %s����%s ���ص����ʼ�֪ͨ";


//
// Ranks admin
//
$lang['Ranks_title'] = "�ȼ�����";
$lang['Ranks_explain'] = "��������������, ������������, �༭, ����Լ�ɾ���ȼ�. ��Ҳ����ʹ�õȼ�Ӧ���ڻ�Ա������.";

$lang['Add_new_rank'] = "�����µĵȼ�";

$lang['Rank_title'] = "�ȼ�����";
$lang['Rank_special'] = "����ȼ�";
$lang['Rank_minimum'] = "���µ���С����";
$lang['Rank_maximum'] = "���µ��������";
$lang['Rank_image'] = "�ȼ�ͼƬ";
$lang['Rank_image_explain'] = "ʹ�����������ȼ�ͼƬ��·��";

$lang['Must_select_rank'] = "������ѡ��һ���ȼ�";
$lang['No_assigned_rank'] = "û��ָ���ĵȼ�";

$lang['Rank_updated'] = "�ȼ��Ѿ��ɹ�����";
$lang['Rank_added'] = "�µĵȼ��Ѿ��ɹ�����";
$lang['Rank_removed'] = "�ȼ������ѳɹ����Ƴ�";
$lang['No_update_ranks'] = '�õȼ��Ѿ��ɹ�ɾ��. �������ڸõȼ����û��ʺ����Բ�δ����. ����Ҫ�ֶ�������Щ�ʺŵĵǼ�����';

$lang['Click_return_rankadmin'] = "��� %s����%s ���صȼ�����";


//
// Disallow Username Admin
//
$lang['Disallow_control'] = "�����ʺſ���";
$lang['Disallow_explain'] = "�����ѡ����, �����Կ��ƽ��õĻ�Ա�ʺ����� (��ʹ��ͨ��� '*'). ��ע��, ���޷������Ѿ�ע��ʹ�õĻ�Ա����, ��������ɾ�������Ա�ʺ�, ����ʹ�ý����ʺŵĹ���.";

$lang['Delete_disallow'] = "ɾ��";
$lang['Delete_disallow_title'] = "ɾ�������ʵĺ�����";
$lang['Delete_disallow_explain'] = "�����Դ��б���ѡ��Ҫ�Ƴ��Ľ����ʺŵ�����";

$lang['Add_disallow'] = "����";
$lang['Add_disallow_title'] = "���ӽ��õ��ʺ�����";
$lang['Add_disallow_explain'] = "������ʹ��ͨ��� '*'�����÷�Χ�ϴ�Ļ�Ա����";

$lang['No_disallowed'] = "û�н��õ��ʺ�����";

$lang['Disallowed_deleted'] = "����ѡ��Ľ����ʺ������ѳɹ����Ƴ�";
$lang['Disallow_successful'] = "�µĽ����ʺ������Ѿ��ɹ�����";
$lang['Disallowed_already'] = "�޷���������������ʺ�����. ���ʺ����ƿ������ڽ����б��ڻ��ѱ�ע��ʹ��";

$lang['Click_return_disallowadmin'] = "��� %s����%s ���ؽ����ʺſ���";


//
// Styles Admin
//
$lang['Styles_admin'] = "���������";
$lang['Styles_explain'] = "ʹ�������������������, �Ƴ���������ֲ�ͬ�İ����� (����������) �ṩ��Աѡ��ʹ��.";
$lang['Styles_addnew_explain'] = "�����б�������п�ʹ�õ�����. ����б��ϵ��������δ��װ�� phpBB 2 �����ݿ���. Ҫ��װ�µ�������ֱ�Ӱ����ҷ���ִ������.";

$lang['Select_template'] = "ѡ�񷶱�����";

$lang['Style'] = "���";
$lang['Template'] = "����";
$lang['Install'] = "��װ";
$lang['Download'] = "����";

$lang['Edit_theme'] = "�༭����";
$lang['Edit_theme_explain'] = "������ʹ�����б��༭�����趨.";

$lang['Create_theme'] = "��������";
$lang['Create_theme_explain'] = "������ʹ�����б����Ϊָ���ķ��������µ�����. ���趨��ɫʱ (������ʹ��ʮ����λ��, ����: FFFFFF) ��������ʼ��Ԫ #, ��������: CCCCCC Ϊ��ȷ�ı�ʾ��, #CCCCCC ���Ǵ����.";

$lang['Export_themes'] = "�������";
$lang['Export_explain'] = "�����������, ���������ָ����������������. ���б���ѡ��ָ���ķ�����, ϵͳ���Ὠ����������������ļ������浽ָ���ķ���Ŀ¼. ��������޷�����, ������������������ļ�. �����ϣ��ϵͳ��ֱ�Ӵ�����Щ�ļ�����, ������ȷ��ָ������Ŀ¼��д. �������Ҫ�����ⷽ�������, ��ο� phpBB 2 ʹ��˵��.";

$lang['Theme_installed'] = "ָ���������Ѿ���װ���";
$lang['Style_removed'] = "ָ���İ������Ѵ����ݿ����Ƴ�. Ҫ������ϵͳ����ȫ���Ƴ����������, ������� /templates ���Ƴ���Ӧ�ķ���Ŀ¼";
$lang['Theme_info_saved'] = "ָ�������������Ѿ��ɹ�����. �����������޸� theme_info.cfg ��Ψ������ (��������ָ���ķ���Ŀ¼)";
$lang['Theme_updated'] = "ָ���������ѱ�����. ����������µ������趨ֵ";
$lang['Theme_created'] = "�����ѱ�����. ��������������趨�ļ�, ��ά�������Ĳ��������ϰ�ȫ";

$lang['Confirm_delete_style'] = "��ȷ��Ҫɾ�������������?";

$lang['Download_theme_cfg'] = "ϵͳ�޷�д��������趨�ļ�. �����Ե�����µİ�ť��������ļ�. ��������������ļ���, �����ɽ��ļ��Ƶ������˷�����Ŀ¼֮��. ���°�װ����ļ����Է��л����������ط�ʹ��.";
$lang['No_themes'] = "��ָ���ķ�����û�а����κε�����. Ҫ�����µ�����, �밴���󷽿������� '����' ����";
$lang['No_template_dir'] = "�޷��򿪷���Ŀ¼. ���п�������Ϊ��Ŀ¼�趨Ϊ���ɶ�ȡ�����Ի����ļ�����������";
$lang['Cannot_remove_style'] = "���޷��Ƴ�Ԥ��İ�����. ���ȱ�������Ԥ�����������һ��";
$lang['Style_exists'] = "ָ���İ����������Ѿ�����, ��ص���һ����ѡ��һ����ͬ������";

$lang['Click_return_styleadmin'] = "��� %s����%s ���ذ��������";

$lang['Theme_settings'] = "�����趨";
$lang['Theme_element'] = "����Ԫ��";
$lang['Simple_name'] = "��������";
$lang['Value'] = "��ֵ";
$lang['Save_Settings'] = "�����趨";

$lang['Stylesheet'] = "CSS ����";
$lang['Background_image'] = "����ͼ��";
$lang['Background_color'] = "������ɫ";
$lang['Theme_name'] = "��������";
$lang['Link_color'] = "������������ɫ";
$lang['Text_color'] = "������ɫ";
$lang['VLink_color'] = "�ι۹���������ɫ (visited)";
$lang['ALink_color'] = "��갴�µ�������ɫ (active)";
$lang['HLink_color'] = "����ƹ���������ɫ (hover)";
$lang['Tr_color1'] = "�������ɫһ";
$lang['Tr_color2'] = "�������ɫ��";
$lang['Tr_color3'] = "�������ɫ��";
$lang['Tr_class1'] = "������������һ";
$lang['Tr_class2'] = "�������������";
$lang['Tr_class3'] = "��������������";
$lang['Th_color1'] = "��Ŀ������ɫһ";
$lang['Th_color2'] = "��Ŀ������ɫ��";
$lang['Th_color3'] = "��Ŀ������ɫ��";
$lang['Th_class1'] = "��Ŀ�����������һ";
$lang['Th_class2'] = "��Ŀ������������";
$lang['Th_class3'] = "��Ŀ�������������";
$lang['Td_color1'] = "���ϸ���ɫһ";
$lang['Td_color2'] = "���ϸ���ɫ��";
$lang['Td_color3'] = "���ϸ���ɫ��";
$lang['Td_class1'] = "���ϸ��������һ";
$lang['Td_class2'] = "���ϸ���������";
$lang['Td_class3'] = "���ϸ����������";
$lang['fontface1'] = "��������һ";
$lang['fontface2'] = "���������";
$lang['fontface3'] = "����������";
$lang['fontsize1'] = "���ʹ�Сһ";
$lang['fontsize2'] = "���ʹ�С��";
$lang['fontsize3'] = "���ʹ�С��";
$lang['fontcolor1'] = "������ɫһ";
$lang['fontcolor2'] = "������ɫ��";
$lang['fontcolor3'] = "������ɫ��";
$lang['span_class1'] = "Span �������һ";
$lang['span_class2'] = "Span ��������";
$lang['span_class3'] = "Span ���������";
$lang['img_poll_size'] = "ͶƱͳ����ͼʾ��С [px]";
$lang['img_pm_size'] = "������Ϣʹ����ͼʾ��С [px]";


//
// Install Process
//
$lang['Welcome_install'] = "��ӭ��װ phpBB 2 ��̳ϵͳ";
$lang['Initial_config'] = "�����趨";
$lang['DB_config'] = "���ݿ��趨";
$lang['Admin_config'] = "ϵͳ����Ա�趨";
$lang['continue_upgrade'] = "����������ϵͳ�趨�ļ� (config.php) ֮��, �����԰��� '��������' �İ�ť������һ��. ������������������ɺ����ϴ��趨��.";
$lang['upgrade_submit'] = "��������";

$lang['Installer_Error'] = "��װ�����з�������";
$lang['Previous_Install'] = "������ɰ�װ����";
$lang['Install_db_error'] = "�ڸ������ݿ�ʱ��������";

$lang['Re_install'] = "����ǰ��װ�� phpBB 2 ��̳ϵͳ����ʹ����. <br /><br />�����ϣ�����°�װ phpBB 2 ��̳ϵͳ��ѡ�� '��' �İ�ť.  ��ע��, ִ�к󽫻��Ƴ����е��ִ�����, ���Ҳ������κα���! ϵͳ����Ա�ʺż����뽫�����½���, �����趨Ҳ�����ᱻ����. <br /><br />���������� '��' �İ�ťǰ��������!";

$lang['Inst_Step_0'] = "��л��ѡ�� phpBB 2 ��̳ϵͳ. ��������д������������ɰ�װ����. �ڰ�װǰ, ����ȷ������Ҫʹ�õ����ݿ��Ѿ�����.";

$lang['Start_Install'] = "��ʼ��װ";
$lang['Finish_Install'] = "��ɰ�װ";

$lang['Default_lang'] = "Ԥ����̳����";
$lang['DB_Host'] = "���ݿ��������������";
$lang['DB_Name'] = "�������ݿ�����";
$lang['DB_Username'] = "���ݿ��û��ʺ�";
$lang['DB_Password'] = "���ݿ�����";
$lang['Database'] = "�������ݿ�";
$lang['Install_lang'] = "ѡ��Ҫ��װ������";
$lang['dbms'] = "���ݿ��ʽ";
$lang['Table_Prefix'] = "���ݿ�ı������ (Prefix)";
$lang['Admin_Username'] = "ϵͳ����Ա�ʺ�����";
$lang['Admin_Password'] = "ϵͳ����Ա����";
$lang['Admin_Password_confirm'] = "ϵͳ����Ա���� [ ȷ�� ]";

$lang['Inst_Step_2'] = "����ϵͳ����Ա�ʺ��ѱ�����, ��̳�Ļ�����װ�Ѿ����, �Ժ������ִ���̳�Ĺ���ҳ��.  ��ȷ�����Ѽ��������õ��趨�����ʵ����޸�. ��һ�θ�л��ѡ��ʹ�� phpBB 2 ��̳ϵͳ.";

$lang['Unwriteable_config'] = "����ϵͳ�趨���޷�д��, �����Ե���·���ť�����趨�ļ�, �ٽ�����ļ��ϴ��� phpBB 2 ��̳�����ϼ�. ����ɺ�������ʹ�ù���Ա�ʺŸ������½������ϵͳ���������� (������½��, �·�������һ������\"ϵͳ����������\"������) ������Ļ��������趨. ����л��ѡ��ʹ�ð�װ phpBB 2 ��̳ϵͳ.";
$lang['Download_config'] = "�����趨�ļ�";

$lang['ftp_choose'] = "ѡ�����ط�ʽ";
$lang['ftp_option'] = "<br />�� FTP �趨��ɺ�, ������ʹ���Զ��ϴ��Ĺ���.";
$lang['ftp_instructs'] = "���Ѿ�ѡ��ʹ�� FTP ȥ�Զ���װ���� phpBB 2 ��̳.  �������������������������. ��ע��: FTP ·���������װ phpBB 2 �� FTP ·����ȫ��ͬ.";
$lang['ftp_info'] = "�������� FTP ��Ϣ";
$lang['Attempt_ftp'] = "ʹ�� FTP �ϴ��趨�ļ�:";
$lang['Send_file'] = "�����ϴ��趨�ļ�";
$lang['ftp_path'] = "��װ phpBB 2 �� FTP ·��:";
$lang['ftp_username'] = "���� FTP ��½����:";
$lang['ftp_password'] = "���� FTP ��½����:";
$lang['Transfer_config'] = "��ʼ����";
$lang['NoFTP_config'] = "FTP �ϴ��趨�ļ�ʧ��. �������趨�ļ���ʹ���ֶ��ϴ�.";

$lang['Install'] = "������װ";
$lang['Upgrade'] = "ϵͳ����";


$lang['Install_Method'] = '��ѡ��װģʽ';

$lang['Install_No_Ext'] = "���������ϵ�php���ò�֧������ѡ������ݿ�����";

$lang['Install_No_PCRE'] = "����php���ò�֧�ְ�װphpBB2����Ҫ��Perl���Ա�׼���ģʽ�ļ�����";

// Auto Language Detection
$lang['Auto_language_detection'] = 'Auto language detection';
$lang['auto_lang_title'] = 'Automatic language detection for guests';
$lang['auto_lang_edit_selected'] = 'Edit Selected';
$lang['auto_lang_explain'] = 'On this page you can configure the automatic language detection feature.  For possible language code settings check out the language preferences section within your browser. The values to use look like en, en-us, de, fr, etc.';
$lang['auto_lang_language_check'] = 'Selection';
$lang['auto_lang_language_code'] = 'Language code';
$lang['auto_lang_language_select'] = 'Associated language';
$lang['auto_lang_empty_lc'] = 'Please provide a language code';
$lang['auto_lang_exists_lc'] = 'The language code <strong>%s</strong> is existing already'; // %s inserts the language code
$lang['auto_lang_notexists_lc'] = 'The language code <strong>%s</strong> does not exist'; // %s Inserts the language code
$lang['auto_lang_not_exist'] = 'The language <strong>%s</strong> does not exist on this phpBB Board.';
$lang['auto_lang_invalid_characters'] = 'Please use alphanumerical characters and the minus (-) symbol only for the language code';

//
// That's all Folks!
// -------------------------------------------------

?>