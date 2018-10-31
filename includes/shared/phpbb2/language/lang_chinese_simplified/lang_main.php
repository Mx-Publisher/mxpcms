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
// CONTRIBUTORS:
//	 Add your details here if wanted, e.g. Name, username, email address, website
// 2002-08-27  Philip M. White        - fixed many grammar problems
//

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
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

$lang['ENCODING'] = "gb2312";
$lang['DIRECTION'] = "LTR";
$lang['LEFT'] = "LEFT";
$lang['RIGHT'] = "RIGHT";
$lang['DATE_FORMAT'] =  "Y-m-d"; // This should be changed to the default date format for your language, php date() format

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
$lang['TRANSLATION'] = 'phpBB �������Ľ����� iCy-fLaME ���·���';
$lang['TRANSLATION_INFO'] = 'phpBB �������Ľ����� iCy-fLaME ���·���';
//
// Common, these terms are used
// extensively on several pages
//
$lang['Forum'] = "��̳";
$lang['Category'] = "������";
$lang['Topic'] = "����";
$lang['Topics'] = "����";
$lang['Replies'] = "�ظ�";
$lang['Views'] = "�Ķ�";
$lang['Post'] = "����";
$lang['Posts'] = "����";
$lang['Posted'] = "������";
$lang['Username'] = "��Ա����";
$lang['Password'] = "����";
$lang['Email'] = "Email";
$lang['Poster'] = "������";
$lang['Author'] = "����";
$lang['Time'] = "ʱ��";
$lang['Hours'] = "Сʱ��";
$lang['Message'] = "����";

$lang['1_Day'] = "1 ����";
$lang['7_Days'] = "7 ����";
$lang['2_Weeks'] = "2 ������";
$lang['1_Month'] = "1 ����";
$lang['3_Months'] = "3 ����";
$lang['6_Months'] = "6 ����";
$lang['1_Year'] = "1 ����";

$lang['Go'] = "Go";
$lang['Jump_to'] = "ת����";
$lang['Submit'] = "����";
$lang['Reset'] = "����";
$lang['Cancel'] = "ȡ��";
$lang['Preview'] = "Ԥ��";
$lang['Confirm'] = "ȷ��";
$lang['Spellcheck'] = "�﷨���";
$lang['Yes'] = "��";
$lang['No'] = "��";
$lang['Enabled'] = "����";
$lang['Disabled'] = "�ر�";
$lang['Error'] = "����";

$lang['Next'] = "��һ��";
$lang['Previous'] = "��һ��";
$lang['Goto_page'] = "ǰ��ҳ��";
$lang['Joined'] = "ע��ʱ��";
$lang['IP_Address'] = "IP ��ַ";

$lang['Select_forum'] = "ѡ��һ������";
$lang['View_latest_post'] = "�����󷢱������";
$lang['View_newest_post'] = "������µ�����";
$lang['Page_of'] = "��<b>%d</b>ҳ/��<b>%d</b>ҳ"; // Replaces with: Page 1 of 2 for example

$lang['ICQ'] = "ICQ ����";
$lang['AIM'] = "AIM Address";
$lang['MSNM'] = "MSN Messenger";
$lang['YIM'] = "Yahoo Messenger";

$lang['Forum_Index'] = "%s ��ҳ";  // eg. sitename Forum Index, %s can be removed if you prefer

$lang['Post_new_topic'] = "��������";
$lang['Reply_to_topic'] = "�ظ�����";
$lang['Reply_with_quote'] = "���ò��ظ�";

$lang['Click_return_topic'] = "��� %s����%s ��������"; // %s's here are for uris, do not remove!
$lang['Click_return_login'] = "��� %s����%s ����һ��";
$lang['Click_return_forum'] = "��� %s����%s ������̳";
$lang['Click_view_message'] = "��� %s����%s �Ķ���������";
$lang['Click_return_modcp'] = "��� %s����%s ���س��Ϲ�����";
$lang['Click_return_group'] = "��� %s����%s ���س�Ա����Ϣ��(to return to group information)";

$lang['Admin_panel'] = "��̳����Ա�������";

$lang['Board_disable'] = "�Բ���,����̳��ʱ���ܷ���,���Ժ�����.";


//
// Global Header strings
//
$lang['Registered_users'] = "ע���Ա:";
$lang['Browsing_forum'] = "��������������ĳ�Ա:";
$lang['Online_users_zero_total'] = "�ܼ��� <b>0</b> λ�������� :: ";
$lang['Online_users_total'] = "�ܼ��� <b>%d</b> λ�������� :: ";
$lang['Online_user_total'] = "�ܼ��� <b>%d</b> λ�������� :: ";
$lang['Reg_users_zero_total'] = "0 λ��Ա, ";
$lang['Reg_users_total'] = "%d λ��Ա, ";
$lang['Reg_user_total'] = "%d λ��Ա, ";
$lang['Hidden_users_zero_total'] = "0 λ����ͺ� ";
$lang['Hidden_user_total'] = "%d λ����ͺ� ";
$lang['Hidden_users_total'] = "%d λ����ͺ� ";
$lang['Guest_users_zero_total'] = "0 λ�ο�";
$lang['Guest_users_total'] = "%d λ�ο�";
$lang['Guest_user_total'] = "%d λ�ο�";
$lang['Record_online_users'] = "������߼�¼�� <b>%s</b> �� %s"; // first %s = number of users, second %s is the date.

$lang['Admin_online_color'] = "%s��̳����Ա%s";
$lang['Mod_online_color'] = "%s����%s";

$lang['You_last_visit'] = "���ϴη���ʱ���� %s"; // %s replaced by date/time
$lang['Current_time'] = "���ڵ�ʱ���� %s"; // %s replaced by time

$lang['Search_new'] = "�Ķ��ϴη��ʺ������";
$lang['Search_your_posts'] = "�Ķ������������";
$lang['Search_unanswered'] = "�Ķ���δ�ش������";

$lang['Register'] = "ע��";
$lang['Profile'] = "��������";
$lang['Edit_profile'] = "�༭���ĸ�������";
$lang['Search'] = "����";
$lang['Memberlist'] = "��Ա�б�";
$lang['FAQ'] = "������������ (FAQ)";
$lang['BBCode_guide'] = "BBCode ָ��";
$lang['Usergroups'] = "��Ա��";
$lang['Last_Post'] = "��󷢱�";
$lang['Moderator'] = "����";
$lang['Moderators'] = "����";


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = "��̳����û������"; // Number of posts
$lang['Posted_articles_total'] = "��̳���� <b>%d</b> ������"; // Number of posts
$lang['Posted_article_total'] = "��̳���� <b>%d</b> ������"; // Number of posts
$lang['Registered_users_zero_total'] = "��̳����û��ע���Ա"; // # registered users
$lang['Registered_users_total'] = "��̳���� <b>%d</b> λע���Ա"; // # registered users
$lang['Registered_user_total'] = "��̳���� <b>%d</b> λע���Ա"; // # registered users
$lang['Newest_user'] = "����ע��ĳ�Ա�� <b>%s%s%s</b>"; // a href, username, /a

$lang['No_new_posts_last_visit'] = "�ϴη��ʺ�û������";
$lang['No_new_posts'] = "û������";
$lang['New_posts'] = "������";
$lang['New_post'] = "������";
$lang['No_new_posts_hot'] = "û������ [ ���� ]";
$lang['New_posts_hot'] = "������ [ ���� ]";
$lang['No_new_posts_locked'] = "û������ [ ���� ]";
$lang['New_posts_locked'] = "������ [ ���� ]";
$lang['Forum_is_locked'] = "�����İ���";


//
// Login
//
$lang['Enter_password'] = "�����������û����������½";
$lang['Login'] = "��½";
$lang['Logout'] = "ע��";

$lang['Forgotten_password'] = "������������!";

$lang['Log_me_in'] = "���ʱ�Զ���½";

$lang['Error_login'] = "���ṩ���û��������벻��ȷ";


//
// Index page
//
$lang['Index'] = "��ҳ";
$lang['No_Posts'] = "û������";
$lang['No_forums'] = "������滹û������";

$lang['Private_Message'] = "˽������";
$lang['Private_Messages'] = "˽������";
$lang['Who_is_Online'] = "��ǰ����״̬";

$lang['Mark_all_forums'] = "���������̳Ϊ�Ѷ�";
$lang['Forums_marked_read'] = "������̳�ѱ��Ϊ�Ѷ�";


//
// Viewforum
//
$lang['View_forum'] = "�����̳";

$lang['Forum_not_exist'] = "��ѡ�����̳������";
$lang['Reached_on_error'] = "��ѡ�����̳������";

$lang['Display_topics'] = "��ʱ����ʾ��ǰ������";
$lang['All_Topics'] = "���е�����";

$lang['Topic_Announcement'] = "<b>����:</b>";
$lang['Topic_Sticky'] = "<b>�ö�:</b>";
$lang['Topic_Moved'] = "<b>�ƶ�:</b>";
$lang['Topic_Poll'] = "<b>[ ������� ]</b>";

$lang['Mark_all_topics'] = "�����������Ϊ�Ѷ�";
$lang['Topics_marked_read'] = "�����̳�����������ѱ��Ϊ�Ѷ�";

$lang['Rules_post_can'] = "��<b>����</b>����������";
$lang['Rules_post_cannot'] = "��<b>����</b>����������";
$lang['Rules_reply_can'] = "��<b>����</b>�������̳�ظ�����";
$lang['Rules_reply_cannot'] = "��<b>����</b>�������̳�ظ�����";
$lang['Rules_edit_can'] = "��<b>����</b>�������̳�༭�Լ�������";
$lang['Rules_edit_cannot'] = "��<b>����</b>�������̳�༭�Լ�������";
$lang['Rules_delete_can'] = "��<b>����</b>�������̳ɾ���Լ�������";
$lang['Rules_delete_cannot'] = "��<b>����</b>�������̳ɾ���Լ�������";
$lang['Rules_vote_can'] = "��<b>����</b>�������̳�����������";
$lang['Rules_vote_cannot'] = "��<b>����</b>�������̳�����������";
$lang['Rules_moderate'] = "��<b>����</b>%s���������̳%s"; // %s replaced by a href links, do not remove!

$lang['No_topics_post_one'] = "�����̳�ﻹû������<br />���<b>��������</b>����һ������";


//
// Viewtopic
//
$lang['View_topic'] = "�Ķ�����";

$lang['Guest'] = '�ο�';
$lang['Post_subject'] = "��������";
$lang['View_next_topic'] = "�Ķ���һ������";
$lang['View_previous_topic'] = "�Ķ���һ������";
$lang['Submit_vote'] = "�����������";
$lang['View_results'] = "������";

$lang['No_newer_topics'] = "�����̳û�и��µ�����";
$lang['No_older_topics'] = "�����̳û�и��ɵ�����";
$lang['Topic_post_not_exist'] = "��ѡ������ⲻ����";
$lang['No_posts_topic'] = "���������û������";

$lang['Display_posts'] = "����ǰ�����ӿ�ʼ��ʾ";
$lang['All_Posts'] = "��������";
$lang['Newest_First'] = "���µ�����";
$lang['Oldest_First'] = "��ɵ�����";

$lang['Back_to_top'] = "����ҳ��";

$lang['Read_profile'] = "������Ա���� (Profile)";
$lang['Send_email'] = "����Ա�������ʼ�";
$lang['Visit_website'] = "��������ߵ���ҳ";
$lang['ICQ_status'] = "ICQ ״̬";
$lang['Edit_delete_post'] = "�༭/ɾ������";
$lang['View_IP'] = "��������ߵ�IP��ַ";
$lang['Delete_post'] = "ɾ���������";

$lang['wrote'] = "д��"; // proceeds the username and is followed by the quoted text
$lang['Quote'] = "����"; // comes before bbcode quote output.
$lang['Code'] = "����"; // comes before bbcode code output.

$lang['Edited_time_total'] = "�����б༭���� %s on %s, �ܼƵ� %d �α༭"; // Last edited by me on 12 Oct 2001, edited 1 time in total
$lang['Edited_times_total'] = "�����б༭���� %s on %s, �ܼƵ� %d �α༭"; // Last edited by me on 12 Oct 2001, edited 2 times in total

$lang['Lock_topic'] = "��������";
$lang['Unlock_topic'] = "��������";
$lang['Move_topic'] = "�ƶ�����";
$lang['Delete_topic'] = "ɾ������";
$lang['Split_topic'] = "�ָ��";

$lang['Stop_watching_topic'] = "ֹͣ���ı�����";
$lang['Start_watching_topic'] = "���ı�����";
$lang['No_longer_watching'] = "�����ٶ��ı�����";
$lang['You_are_watching'] = "���Ѷ����˱�����";

$lang['Total_votes'] = "ͶƱ����";

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = "��������";
$lang['Topic_review'] = "Ԥ������";

$lang['No_post_mode'] = "No post mode specified"; // If posting.php is called without a mode (newtopic/reply/delete/etc, shouldn't be shown normaly)

$lang['Post_a_new_topic'] = "��������";
$lang['Post_a_reply'] = "����ظ�";
$lang['Post_topic_as'] = "����";
$lang['Edit_Post'] = "�༭����";
$lang['Options'] = "ѡ��";

$lang['Post_Announcement'] = "����";
$lang['Post_Sticky'] = "�ö�";
$lang['Post_Normal'] = "��ͨ";

$lang['Confirm_delete'] = "��ȷ��Ҫɾ�����������?";
$lang['Confirm_delete_poll'] = "��ȷ��Ҫɾ��������������?";

$lang['Flood_Error'] = "�������ڷ��������Ϸ������������һ������.";
$lang['Empty_subject'] = "����������ӱ�����һ������.";
$lang['Empty_message'] = "����������ӱ���������.";
$lang['Forum_locked'] = "�����̳�Ѿ�������,�����ܷ���,�ظ����߱༭����.";
$lang['Topic_locked'] = "��������Ѿ�������,�����ܷ���,�ظ����߱༭����.";
$lang['No_post_id'] = "��ѡ����Ҫ�༭������";
$lang['No_topic_id'] = "��ѡ����Ҫ�ظ�������";
$lang['No_valid_mode'] = "��ֻ����ѡ�񷢱�,�ظ�������������,���������.";
$lang['No_such_post'] = "û���������,���������.";
$lang['Edit_own_posts'] = "�Բ�����ֻ���Ա༭�Լ�������.";
$lang['Delete_own_posts'] = "�Բ�����ֻ����ɾ���Լ�������.";
$lang['Cannot_delete_replied'] = "�Բ��������ܲ�����ɾ���Ѿ����ظ�������.";
$lang['Cannot_delete_poll'] = "�Բ�����������ɾ�������ڻ״̬���������.";
$lang['Empty_poll_title'] = "��������������������齨��һ������.";
$lang['To_few_poll_options'] = "������Ҫ��������������������ѡ��.";
$lang['To_many_poll_options'] = "��ѡ����̫�����������ѡ��";
$lang['Post_has_no_poll'] = "�������û�н����������";
$lang['Already_voted'] = '���Ѿ�������Ͷ��Ʊ��.';
$lang['No_vote_option'] = '�����ѡ��һ����Ŀ.';

$lang['Add_poll'] = "����һ���������";
$lang['Add_poll_explain'] = "��������뽨����������벻Ҫ��д���ѡ��.";
$lang['Poll_question'] = "�����������";
$lang['Poll_option'] = "�������ѡ��";
$lang['Add_option'] = "����ѡ��";
$lang['Update'] = "����";
$lang['Delete'] = "ɾ��";
$lang['Poll_for'] = "�����������";
$lang['Days'] = "����"; // This is used for the Run poll for ... Days + in admin_forums for pruning
$lang['Poll_for_explain'] = "[ ѡ�� 0 ���߲�ѡ�����ѡ�������Զ����������� ]";
$lang['Delete_poll'] = "ɾ���������";

$lang['Disable_HTML_post'] = "������������ֹHTML����";
$lang['Disable_BBCode_post'] = "������������ֹBBCode";
$lang['Disable_Smilies_post'] = "������������ֹ�������";

$lang['HTML_is_ON'] = "HTML is <u>ON</u>";
$lang['HTML_is_OFF'] = "HTML is <u>OFF</u>";
$lang['BBCode_is_ON'] = "%sBBCode%s is <u>ON</u>"; // %s are replaced with URI pointing to FAQ
$lang['BBCode_is_OFF'] = "%sBBCode%s is <u>OFF</u>";
$lang['Smilies_are_ON'] = "Smilies are <u>ON</u>";
$lang['Smilies_are_OFF'] = "Smilies are <u>OFF</u>";

$lang['Attach_signature'] = "����ǩ�� (���ĸ���ǩ�������ڸ������������)";
$lang['Notify'] = "���˻ظ�ʱ���͵����ʼ�֪ͨ";
$lang['Delete_post'] = "ɾ���������";

$lang['Stored'] = "���������Ѿ��ɹ��Ĵ���";
$lang['Deleted'] = "���������Ѿ��ɹ��ı�ɾ��";
$lang['Poll_delete'] = "����������������Ѿ��ɹ��ı�ɾ��";
$lang['Vote_cast'] = "����ѡƱ�Ѿ�Ͷ��";

$lang['Topic_reply_notification'] = "����֪ͨ";

$lang['bbcode_b_help'] = "����: [b]text[/b]  (alt+b)";
$lang['bbcode_i_help'] = "��д: [i]text[/i]  (alt+i)";
$lang['bbcode_u_help'] = "�»���: [u]text[/u]  (alt+u)";
$lang['bbcode_q_help'] = "�����ı�: [quote]text[/quote]  (alt+q)";
$lang['bbcode_c_help'] = "��ʾ���� : [code]code[/code]  (alt+c)";
$lang['bbcode_l_help'] = "�б�: [list]text[/list] (alt+l)";
$lang['bbcode_o_help'] = "�����б�: [list=]text[/list]  (alt+o)";
$lang['bbcode_p_help'] = "����ͼ��: [img]http://image_url[/img]  (alt+p)";
$lang['bbcode_w_help'] = "����������ַ: [url]http://url[/url] or [url=http://url]URL text[/url]  (alt+w)";
$lang['bbcode_a_help'] = "�ر����п�����bbCode��ǩ";
$lang['bbcode_s_help'] = "������ɫ: [color=red]text[/color]  ��ʾ: ��Ҳ����ʹ���� color=#FF0000 ������html���";
$lang['bbcode_f_help'] = "�����С: [size=x-small]small text[/size]";

$lang['Emoticons'] = "����ͼ��";
$lang['More_emoticons'] = "�������ı���ͼ��";

$lang['Font_color'] = "������ɫ";
$lang['color_default'] = "��׼";
$lang['color_dark_red'] = "���";
$lang['color_red'] = "��ɫ";
$lang['color_orange'] = "��ɫ";
$lang['color_brown'] = "��ɫ";
$lang['color_yellow'] = "��ɫ";
$lang['color_green'] = "��ɫ";
$lang['color_olive'] = "���";
$lang['color_cyan'] = "��ɫ";
$lang['color_blue'] = "��ɫ";
$lang['color_dark_blue'] = "����";
$lang['color_indigo'] = "����";
$lang['color_violet'] = "��ɫ";
$lang['color_white'] = "��ɫ";
$lang['color_black'] = "��ɫ";

$lang['Font_size'] = "�����С";
$lang['font_tiny'] = "��С";
$lang['font_small'] = "С";
$lang['font_normal'] = "����";
$lang['font_large'] = "��";
$lang['font_huge'] = "���";

$lang['Close_Tags'] = "��ɱ�ǩ";
$lang['Styles_tip'] = "��ʾ: ���ַ����Կ���ʹ����ѡ���������";


//
// Private Messaging
//
$lang['Private_Messaging'] = "˽������";

$lang['Login_check_pm'] = "��½�鿴����˽������";
$lang['New_pms'] = "���� %d ���µ�����"; // You have 2 new messages
$lang['New_pm'] = "���� %d ���µ�����"; // You have 1 new message
$lang['No_new_pm'] = "��û���µ�����";
$lang['Unread_pms'] = "���� %d ��δ��������";
$lang['Unread_pm'] = "���� %d ��δ��������";
$lang['No_unread_pm'] = "��û��δ��������";
$lang['You_new_pm'] = "һ���µ������������ռ�����";
$lang['You_new_pms'] = "�����µ������������ռ�����";
$lang['You_no_new_pm'] = "û���µ�����";

$lang['Unread_message'] = 'δ������';
$lang['Read_message'] = '�Ѷ�����';

$lang['Read_pm'] = '�鿴˽������';
$lang['Post_new_pm'] = '����˽������';
$lang['Post_reply_pm'] = '�ظ�����';
$lang['Post_quote_pm'] = '��������';
$lang['Edit_pm'] = '�༭˽������';

$lang['Inbox'] = "�ռ���";
$lang['Outbox'] = "������";
$lang['Savebox'] = "�ղؼ�";
$lang['Sentbox'] = "�ѷ��͵��ż���";
$lang['Flag'] = "״̬";
$lang['Subject'] = "����";
$lang['From'] = "����";
$lang['To'] = "������";
$lang['Date'] = "����";
$lang['Mark'] = "ѡ��";
$lang['Sent'] = "����";
$lang['Saved'] = "�ѱ��浽�ղؼ�";
$lang['Delete_marked'] = "ɾ����ѡ�������";
$lang['Delete_all'] = "ɾ�����е�����";
$lang['Save_marked'] = "������ѡ������Ե��ղؼ�";
$lang['Save_message'] = "�������Ե��ղؼ�";
$lang['Delete_message'] = "ɾ������";

$lang['Display_messages'] = "��ʾ��ǰ������"; // Followed by number of days/weeks/months
$lang['All_Messages'] = "���е�����";

$lang['No_messages_folder'] = "����ļ�����û���ż�";

$lang['PM_disabled'] = "�����̳��˽�������Ѿ�������";
$lang['Cannot_send_privmsg'] = "�Բ�����̳����Ա�Ѿ���ֹ������˽������";
$lang['No_to_user'] = "������ָ��˽�����Է��͵Ķ���";
$lang['No_such_user'] = "�Բ�������û�������";

$lang['Disable_HTML_pm'] = "������ż����ֹHTML����";
$lang['Disable_BBCode_pm'] = "������ż����ֹBBCode";
$lang['Disable_Smilies_pm'] = "������ż����ֹ�������";

$lang['Message_sent'] = "����˽�����Է��ͳɹ�";

$lang['Click_return_inbox'] = "��� %s����%s ���������ռ���";
$lang['Click_return_index'] = "��� %s����%s ������ҳ";

$lang['Send_a_new_message'] = "����һ���µ�˽������";
$lang['Send_a_reply'] = "�ظ�����";
$lang['Edit_message'] = "�༭����";

$lang['Notification_subject'] = "�µ�˽������";

$lang['Find_username'] = "����һ���û�";
$lang['Find'] = "����";
$lang['No_match'] = "�Ҳ���ƥ����û�";

$lang['No_post_id'] = "û��ָ������";
$lang['No_such_folder'] = "û���������ļ��д���";
$lang['No_folder'] = "û��ָ���ļ���";

$lang['Mark_all'] = "ѡ�������ż�";
$lang['Unmark_all'] = "ȡ������ѡ��";

$lang['Confirm_delete_pm'] = "��ȷ��Ҫɾ�����������?";
$lang['Confirm_delete_pms'] = "��ȷ��Ҫɾ����Щ������?";

$lang['Inbox_size'] = "�����ռ�����ʹ�� %d%%"; // eg. Your Inbox is 50% full
$lang['Sentbox_size'] = "�����ѷ����ļ�����ʹ�� %d%%";
$lang['Savebox_size'] = "�����ղؼ���ʹ�� %d%%";

$lang['Click_view_privmsg'] = "���%s����%s��������ռ���";


//
// Profiles/Registration
//
$lang['Viewing_user_profile'] = "�������� :: %s"; // %s is username
$lang['About_user'] = "���� %s"; // %s is username

$lang['Preferences'] = "ѡ��";
$lang['Items_required'] = "��*����Ŀ�Ǳ�����д��";
$lang['Registration_info'] = "ע����Ϣ";
$lang['Profile_info'] = "��������";
$lang['Profile_info_warn'] = "������Ϣ��������";
$lang['Avatar_panel'] = "ͷ��������";
$lang['Avatar_gallery'] = "ͷ�񻭼�";

$lang['Website'] = "��ҳ";
$lang['Location'] = "����";
$lang['Contact'] = "����";
$lang['Email_address'] = "Email ��ַ";
$lang['Email'] = "Email";
$lang['Send_private_message'] = "����˽������ (PM)";
$lang['Hidden_email'] = "[ ���� ]";
$lang['Search_user_posts'] = "������λ�û����������";
$lang['Interests'] = "��Ȥ";
$lang['Occupation'] = "ְҵ";
$lang['Poster_rank'] = "�û�����";

$lang['Total_posts'] = "�����ܼ�";
$lang['User_post_pct_stats'] = "�ܷ�������%.2f%%"; // 1.25% of total
$lang['User_post_day_stats'] = "ƽ��ÿ��%.2f������"; // 1.5 posts per day
$lang['Search_user_posts'] = "����%s�������������"; // Find all posts by username

$lang['No_user_id_specified'] = "�Բ�������û�������";
$lang['Wrong_Profile'] = "�������Ա༭ȥ���û��ĸ�������";

$lang['Only_one_avatar'] = "��ֻ��ѡ��һ��ͷ��";
$lang['File_no_data'] = "���ṩ�����ӵ�ַ����������";
$lang['No_connection_URL'] = "�޷��������ṩ�����ӵ�ַ";
$lang['Incomplete_URL'] = "���ṩ�����ӵ�ַ������";
$lang['Wrong_remote_avatar_format'] = "���ṩ��ͷ�����ӵ�ַ��Ч";
$lang['No_send_account_inactive'] = "�Բ����޷��һ�����������Ϊ�����˻����ڲ��ڻ״̬,��������̳����Ա�õ��������Ϣ.";

$lang['Always_smile'] = "ʹ�ñ������";
$lang['Always_html'] = "ʹ�� HTML";
$lang['Always_bbcode'] = "ʹ�� BBCode";
$lang['Always_add_sig'] = "�����︽�����ĸ���ǩ��";
$lang['Always_notify'] = "����ظ�֪ͨ";
$lang['Always_notify_explain'] = "�����˻ظ���������ʱ����һ������ʼ�֪ͨ��.���ѡ��Ҳ������������ʱ����";

$lang['Board_style'] = "��̳���";
$lang['Board_lang'] = "��̳����";
$lang['No_themes'] = "���ݿ���û��װ������";
$lang['Timezone'] = "ʱ��";
$lang['Date_format'] = "���ڸ�ʽ";
$lang['Date_format_explain'] = "���ڸ�ʽ���﷨�� PHP <a href=\"http://www.php.net/date\" target=\"_other\">date() ���</a>��ȫ��ͬ";
$lang['Signature'] = "����ǩ��";
$lang['Signature_explain'] = "����д�ĸ���ǩ�����Է��������������·�.����ǩ����%d���ַ�������";
$lang['Public_view_email'] = "��ʾ���ĵ����ʼ���ַ";

$lang['Current_password'] = "���ڵ�����";
$lang['New_password'] = "�µ�����";
$lang['Confirm_password'] = "ȷ��������";
$lang['Confirm_password_explain'] = "����ϣ���ı�����������ĵ����ʼ���ַʱ������ȷ����������ʹ�õ�����";
$lang['password_if_changed'] = "ֻ�е���ϣ����������ʱ����Ҫ�ṩ�µ�����";
$lang['password_confirm_if_changed'] = "ֻ�е���ϣ����������ʱ����Ҫȷ���µ�����";

$lang['Avatar'] = "ͷ��";
$lang['Avatar_explain'] = "��ʾһ��СͼƬ���������������,ͬһʱ��ֻ����ʾһ��ͼƬ.ͼƬ��Ȳ��ܳ���%d ����, �߶Ȳ��ܳ���%d ����,ͼƬ��С���ܳ���%dkB."; $lang['Upload_Avatar_file'] = "�����ļ�����ϴ�ͼƬ";
$lang['Upload_Avatar_file'] = '����ĵ����ϴ����ͷ��';
$lang['Upload_Avatar_URL'] = "��һ�������ϴ�ͼƬ";
$lang['Upload_Avatar_URL_explain'] = "�ṩһ��ͼƬ�����ӵ�ַ,ͼƬ�������Ƶ�����̳.";
$lang['Pick_local_Avatar'] = "��ϵͳ�����ѡ��һ��ͷ��";
$lang['Link_remote_Avatar'] = "��������λ�õ�ͷ��";
$lang['Link_remote_Avatar_explain'] = "�ṩ��������ͷ��ĵ�ַ";
$lang['Avatar_URL'] = "ͼƬ���ӵ�ַ";
$lang['Select_from_gallery'] = "��ϵͳ��ͷ�������ѡ��һ��ͷ��";
$lang['View_avatar_gallery'] = "��ʾϵͳͷ�����";

$lang['Select_avatar'] = "ѡ��ͷ��";
$lang['Return_profile'] = "ȡ��ѡ��ͷ��";
$lang['Select_category'] = "ѡ��һ������";

$lang['Delete_Image'] = "ɾ��ͼƬ";
$lang['Current_Image'] = "����ʹ�õ�ͼƬ";

$lang['Notify_on_privmsg'] = "�����µ�˽������ʱ���͵����ʼ�֪ͨ";
$lang['Popup_on_privmsg'] = "�����µ�˽������ʱ��������֪ͨ";
$lang['Popup_on_privmsg_explain'] = "�������µ�˽������ʱ����������֪ͨ��";
$lang['Hide_user'] = "������������״̬";

$lang['Profile_updated'] = "���ĸ��������Ѿ�����";
$lang['Profile_updated_inactive'] = "���ĸ��������Ѿ�����,Ȼ��,���������˻�״̬.�����˻����ڴ����䶳״̬.�쿴���ĵ����ʼ������λָ������˻�,��������ȴ���̳����Ա�ָ������˻��״̬.(however you have changed vital details thus your account is now inactive. or if admin activation is require wait for the administrator to reactivate your account)";

$lang['Password_mismatch'] = "���ṩ�����벻ƥ��";
$lang['Current_password_mismatch'] = "������ʹ�õ�������ע��ʱ�ṩ�Ĳ�ƥ��";
$lang['Password_long'] = "���벻�ܶ���32���ӷ�";
$lang['Too_many_registers'] = '��Ǽǵ�̫Ƶ��. ���Ժ�����.';
$lang['Username_taken'] = "�Բ�����ѡ����û����Ѿ�����ʹ����";
$lang['Username_invalid'] = "��ѡ����û�����������Ч���ַ�,�� \"";
$lang['Username_disallowed'] = "�Բ�����ѡ����û����Ѿ�������";
$lang['Email_taken'] = "�Բ������ṩ�ĵ����ʼ���ַ�Ѿ���ĳ���û�ע����";
$lang['Email_banned'] = "�Բ������ṩ�ĵ����ʼ���ַ�Ѿ�������";
$lang['Email_invalid'] = "�Բ������ṩ�ĵ����ʼ���ַ����ȷ";
$lang['Signature_too_long'] = "���ĸ���ǩ��̫����";
$lang['Fields_empty'] = "��������д������д����Ŀ(*)";
$lang['Avatar_filetype'] = "ͷ��ͼƬ�����ͱ����� .jpg, .gif or .png";
$lang['Avatar_filesize'] = "ͷ��ͼƬ�Ĵ�С����С�� %d kB"; // The avatar image file size must be less than 6 kB
$lang['Avatar_imagesize'] = "ͷ��ͼƬ�Ŀ�ȱ���С�� %d ���� ���Ҹ߶ȱ���С�� %d ����";

$lang['Welcome_subject'] = "��ӭ������ %s ��̳"; // Welcome to my.com forums
$lang['New_account_subject'] = "���û��ʻ�";
$lang['Account_activated_subject'] = "�˻�����";

$lang['Account_added'] = "��л����ע��,�����˻��Ѿ�������.�����ھͿ���ʹ�������û����������½";
$lang['Account_inactive'] = "��л����ע��,�����˻��Ѿ�������.����̳��Ҫ�����˻�.��鿴���ĵ����ʼ��˽⼤�����Ϣ.";
$lang['Account_inactive_admin'] = "��л����ע��,�����˻��Ѿ�������.���Ǳ���̳��Ҫ��̳����Ա�����˻�. һ������ʼ��Ѿ������͵�����Ա,�����˻�������ʱ�����յ�֪ͨ.";
$lang['Account_active'] = "��л����ע��,�����˻��Ѿ�������.";
$lang['Account_active_admin'] = "�˻������Ѿ����ɹ�����";
$lang['Reactivate'] = "���¼��������˻�!";
$lang['Already_activated'] = '����ʺ��Ѿ�����';
$lang['COPPA'] = "�����˻��Ѿ�������������Ҫ����׼,��鿴���ĵ����ʼ��˽�ϸ��.";

$lang['Registration'] = "ע���������";
$lang['Reg_agreement'] = "������̳�����Ա�ᾡ���ܾ���ɾ����༭��������ǲ�����������,�������ǲ������Ķ����е���������.�������ó��������̳�����е�����ֻ�����ķ����߳е�����,��������̳�Ĺ����Ա��(�����������Ƿ����).<br /><br />������ͬ�ⲻ�����������,����,����,�̰�,���г����,���ŵ�,�������Ļ����κ�Υ�����ɵ�����. ����������������������˻��������������Եı�����.(������������ṩ��Ҳ�ᱻ֪ͨ). ����������,���IP��ַ�������û���������¼.������ͬ��ϵͳ�����Ա�������κ�ʱ��ɾ��,�޸�,�ƶ���ر��κ������Ȩ��. ��Ϊһ��ʹ����, ������ͬ�������ṩ���κ����϶������������ݿ���,��Щ���ϳ���������ͬ��,ϵͳ����Ա�Ǿ�����Ե���������,Ȼ�����ǲ��ܱ�֤�κο��ܵ�������й¶�ĺ���������Ϊ.<br /><br />���������ϵͳʹ��cookie���������ĸ�����Ϣ(����ʹ�õı��ؼ����), ��Щcookie�������κ����������������Ϣ,����ֻΪ�˷������ܸ���������. �����ʼ���ַֻ����ȷ������ע��ͷ�������ʹ��.(���������������,���ᷢ��������ĵ�ַ)<br /><br />�����������Ӵ�����ͬ���ܵ���Щ���������Լ��.";

$lang['Agree_under_13'] = "��ͬ�Ⲣ����<b>С��</b>13��";
$lang['Agree_over_13'] = "��ͬ�Ⲣ����<b>����</b>13��";
$lang['Agree_not'] = "�Ҳ�ͬ��";

$lang['Wrong_activation'] = "���ṩ�ļ�����������ݿ��еĲ�ƥ��";
$lang['Send_password'] = "����һ���µļ����������";
$lang['Password_updated'] = "�����µļ��������Ѿ�������,��鿴���ĵ����ʼ��˽⼤��ϸ��";
$lang['No_email_match'] = "���ṩ�ĵ����ʼ���ַ�����ݿ��еĲ�ƥ��";
$lang['New_password_activation'] = "�����뼤��";
$lang['Password_activated'] = "�����˻��Ѿ������¼���.��ʹ�����յ��ĵ����ʼ��е������½";

$lang['Send_email_msg'] = "����һ������ʼ�";
$lang['No_user_specified'] = "û��ѡ���û�";
$lang['User_prevent_email'] = "�����û���ϣ���յ������ʼ�,�����Է���˽������ (PM)�������û�";
$lang['User_not_exist'] = "�л�������";
$lang['CC_email'] = "�����������ʼ����͸��Լ�";
$lang['Email_message_desc'] = "����ʼ������Դ��ı���ʽ����,�벻Ҫ�����κ� HTML ���� BBCode.��ƪ�ʼ��Ļظ���ַ��ָ�����ĵ����ʼ���ַ.";
$lang['Flood_email_limit'] = "���������ڷ��������ĵ����ʼ�,���һ������.";
$lang['Recipient'] = "������";
$lang['Email_sent'] = "�ʼ��Ѿ�������";
$lang['Send_email'] = "���͵����ʼ�";
$lang['Empty_subject_email'] = "������������ʼ�����һ������";
$lang['Empty_message_email'] = "������������ʼ���д����";


//
// Visual confirmation system strings
//
$lang['Confirm_code_wrong'] = '���������֤�벻��ȷ';
$lang['Too_many_registers'] = '���Ѿ�����������ĳ��Դ�������. ���Ժ�����.';
$lang['Confirm_code_impaired'] = '���������Ӿ��ϰ�, �����޷�������֤��������%s��̳����Ա%s.';
$lang['Confirm_code'] = '��֤��';
$lang['Confirm_code_explain'] = '���������㿴������֤��. ��֤���Ǵ�Сд�б��, ���� "��" ���м����һб��.';



//
// Memberslist
//
$lang['Select_sort_method'] = "��ѡ��һ�����򷽷�";
$lang['Sort'] = "����";
$lang['Sort_Top_Ten'] = "��Ծǰʮ";
$lang['Sort_Joined'] = "ע������";
$lang['Sort_Username'] = "�û�����";
$lang['Sort_Location'] = "���Ե���";
$lang['Sort_Posts'] = "��������";
$lang['Sort_Email'] = "�����ʼ�";
$lang['Sort_Website'] = "������ҳ";
$lang['Sort_Ascending'] = "����";
$lang['Sort_Descending'] = "����";
$lang['Order'] = "˳��";


//
// Group control panel
//
$lang['Group_Control_Panel'] = "��Ա��������";
$lang['Group_member_details'] = "��Ա���Աϸ��";
$lang['Group_member_join'] = "����һ����Ա��";

$lang['Group_Information'] = "��Ա����Ϣ";
$lang['Group_name'] = "��Ա������";
$lang['Group_description'] = "��Ա������";
$lang['Group_membership'] = "��Ա���Ա";
$lang['Group_Members'] = "��Ա���Ա";
$lang['Group_Moderator'] = "��Ա����ϯ";
$lang['Pending_members'] = "����еĳ�Ա";

$lang['Group_type'] = "��Ա������";
$lang['Group_open'] = "������Ա��";
$lang['Group_closed'] = "�رճ�Ա��";
$lang['Group_hidden'] = "���س�Ա��";

$lang['Current_memberships'] = "Ŀǰ�����ڵĳ�Ա��";
$lang['Non_member_groups'] = "û�г�Ա�ĳ�Ա��";
$lang['Memberships_pending'] = "�����ڱ�����еĳ�Ա��";

$lang['No_groups_exist'] = "û�г�Ա�����";
$lang['Group_not_exist'] = "�����������Ա��";

$lang['Join_group'] = "�����Ա��";
$lang['No_group_members'] = "�����Ա��û�г�Ա";
$lang['Group_hidden_members'] = "�����Ա�鴦������״̬,�����ܲ鿴���ĳ�Ա";
$lang['No_pending_group_members'] = "�����Ա�鲻��������г�Ա";
$lang["Group_joined"] = "���Ѿ�������������Ա��,<br />����������ͨ����������ܵ�֪ͨ";
$lang['Group_request'] = "���������Ա��������Ѿ��ύ";
$lang['Group_approved'] = "���������Ѿ�����׼��";
$lang['Group_added'] = "���Ѿ������������Ա��";
$lang['Already_member_group'] = "���Ѿ��������Ա��ĳ�Ա";
$lang['User_is_member_group'] = "�û��Ѿ��������Ա��ĳ�Ա";
$lang['Group_type_updated'] = "�ɹ����³�Ա������";

$lang['Could_not_add_user'] = "��ѡ����û�������";
$lang['Could_not_anon_user'] = "�����ܽ������ο���Ϊ��Ա���Ա";

$lang['Confirm_unsub'] = "��ȷ��Ҫ�������Ա����������?";
$lang['Confirm_unsub_pending'] = "���ĳ�Ա�����뻹û�б���׼,��ȷ��Ҫ���������?";

$lang['Unsub_success'] = "���Ѿ��������Ա����������.";

$lang['Approve_selected'] = "ѡ����׼";
$lang['Deny_selected'] = "ѡ��ܾ�";
$lang['Not_logged_in'] = "�����Ա��ǰ���������ȵ�½.";
$lang['Remove_selected'] = "ѡ���Ƴ�";
$lang['Add_member'] = "���ӳ�Ա";
$lang['Not_group_moderator'] = "�����������Ա��Ĺ���Ա,���޷�ִ�г�Ա��Ĺ�����.";

$lang['Login_to_join'] = "���½������߹����Ա���Ա";
$lang['This_open_group'] = "����һ�����ŵĳ�Ա��,��������Ա";
$lang['This_closed_group'] = "����һ���رյĳ�Ա��,�������µĳ�Ա";
$lang['This_hidden_group'] = "����һ�����صĳ�Ա��,�������Զ����ӳ�Ա";
$lang['Member_this_group'] = "���������Ա��ĳ�Ա";
$lang['Pending_this_group'] = "�����������������";
$lang['Are_group_moderator'] = "���ǳ�Ա�����Ա";
$lang['None'] = "û��";

$lang['Subscribe'] = "����";
$lang['Unsubscribe'] = "�������";
$lang['View_Information'] = "����ϸ��";


//
// Search
//
$lang['Search_query'] = "����Ŀ��";
$lang['Search_options'] = "����ѡ��";

$lang['Search_keywords'] = "�����ؼ���";
$lang['Search_keywords_explain'] = "������ʹ��<u>AND</u>�������ϣ������������ֵĹؼ���,����ʹ��<u>OR</u>�������ϣ���������ܳ��ֵĹؼ��ֺ�<u>NOT</u>���������ϣ���������ֵĹؼ���.������ʹ��ͨ���*����������ϵĽ��";
$lang['Search_author'] = "��������";
$lang['Search_author_explain'] = "������ʹ��ͨ���*����������ϵĽ��";

$lang['Search_for_any'] = "�����������ṩ������ؼ��ֵ�����";
$lang['Search_for_all'] = "�����������ṩ�����йؼ��ֵ�����";
$lang['Search_title_msg'] = "�������������";
$lang['Search_msg_only'] = "ֻ��������";

$lang['Return_first'] = "��ʾ���ȵ�"; // followed by xxx characters in a select box
$lang['characters_posts'] = "�����ϵ���Ŀ";

$lang['Search_previous'] = "ʱ�䷶Χ"; // followed by days, weeks, months, year, all in a select box

$lang['Sort_by'] = "���򷽷�";
$lang['Sort_Time'] = "����ʱ��";
$lang['Sort_Post_Subject'] = "��������";
$lang['Sort_Topic_Title'] = "���ӱ���";
$lang['Sort_Author'] = "����";
$lang['Sort_Forum'] = "����";

$lang['Display_results'] = "��ʾ�����";
$lang['All_available'] = "������̳";
$lang['No_searchable_forums'] = "��û����������������̳��Ȩ��";

$lang['No_search_match'] = "û�з�����Ҫ������������";
$lang['Found_search_match'] = "������ %d �����ϵ�����"; // eg. Search found 1 match
$lang['Found_search_matches'] = "������ %d �����ϵ�����"; // eg. Search found 24 matches

$lang['Close_window'] = "�رմ���";


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = "�Բ���ֻ�� %s �����������̳������";
$lang['Sorry_auth_sticky'] = "�Բ���ֻ�� %s �����������̳�����ö�";
$lang['Sorry_auth_read'] = "�Բ���ֻ�� %s �����������̳�������";
$lang['Sorry_auth_post'] = "�Բ���ֻ�� %s �����������̳��������";
$lang['Sorry_auth_reply'] = "�Բ���ֻ�� %s �����������̳�ظ�����";
$lang['Sorry_auth_edit'] = "�Բ���ֻ�� %s �����������̳�༭����";
$lang['Sorry_auth_delete'] = "�Բ���ֻ�� %s �����������̳ɾ������";
$lang['Sorry_auth_vote'] = "�Բ���ֻ�� %s �����������̳�����������";

// These replace the %s in the above strings
$lang['Auth_Anonymous_Users'] = "<b>�����ο�</b>";
$lang['Auth_Registered_Users'] = "<b>ע���û�</b>";
$lang['Auth_Users_granted_access'] = "<b>��Ȩ�û�</b>";
$lang['Auth_Moderators'] = "<b>����</b>";
$lang['Auth_Administrators'] = "<b>����Ա</b>";

$lang['Not_Moderator'] = "�����������̳�ĳ���";
$lang['Not_Authorised'] = "û����Ȩ";

$lang['You_been_banned'] = "�����̳�Ѿ���ֹ������<br />��������̳����Ա�˽�ϸ��";


//
// Viewonline
//
$lang['Reg_users_zero_online'] = "������ 0 λע���л��� "; // There ae 5 Registered and
$lang['Reg_users_online'] = "������ %d λע���л��� "; // There ae 5 Registered and
$lang['Reg_user_online'] = "������ %d λע���л��� "; // There ae 5 Registered and
$lang['Hidden_users_zero_online'] = "0 λ�����û���"; // 6 Hidden users online
$lang['Hidden_users_online'] = "%d λ�����û�����"; // 6 Hidden users online
$lang['Hidden_user_online'] = "%d λ�����û�����"; // 6 Hidden users online
$lang['Guest_users_online'] = "������ %d λ�ο�����"; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = "������ 0 λע���û�����"; // There are 10 Guest users online
$lang['Guest_user_online'] = "������ %d λ�ο�����"; // There is 1 Guest user online
$lang['No_users_browsing'] = "����û���û��������̳���";

$lang['Online_explain'] = "����5����֮�ڵ���̳�������";

$lang['Forum_Location'] = "��̳λ��";
$lang['Last_updated'] = "�������";

$lang['Forum_index'] = "��̳��ҳ";
$lang['Logging_on'] = "��½";
$lang['Posting_message'] = "��������";
$lang['Searching_forums'] = "������̳";
$lang['Viewing_profile'] = "�����������";
$lang['Viewing_online'] = "����������";
$lang['Viewing_member_list'] = "�����Ա�б�";
$lang['Viewing_priv_msgs'] = "���˽������";
$lang['Viewing_FAQ'] = "������������";


//
// Moderator Control Panel
//
$lang['Mod_CP'] = "���Ͽ������";
$lang['Mod_CP_explain'] = "ʹ�����µ�ѡ���������������̳���д󲿷������Ĳ���. ����������,����, �ƶ�����ɾ����������������.";

$lang['Select'] = "ѡ��";
$lang['Delete'] = "ɾ��";
$lang['Move'] = "�ƶ�";
$lang['Lock'] = "����";
$lang['Unlock'] = "����";

$lang['Topics_Removed'] = "ѡ��������Ѿ��ɹ��ش����ݿ���ɾ��.";
$lang['Topics_Locked'] = "ѡ��������Ѿ��ɹ��ı�����";
$lang['Topics_Moved'] = "ѡ��������Ѿ��ɹ��ı��ƶ�";
$lang['Topics_Unlocked'] = "ѡ��������Ѿ��ɹ��ı�����";
$lang['No_Topics_Moved'] = "û�����ⱻ�ƶ�";

$lang['Confirm_delete_topic'] = "��ȷ��Ҫɾ��ѡ���������?";
$lang['Confirm_lock_topic'] = "��ȷ��Ҫ����ѡ���������?";
$lang['Confirm_unlock_topic'] = "��ȷ��Ҫ����ѡ���������?";
$lang['Confirm_move_topic'] = "��ȷ��Ҫ�ƶ�ѡ���������?";

$lang['Move_to_forum'] = "�ƶ�����һ����̳";
$lang['Leave_shadow_topic'] = "�������Ᵽ���ھ���̳";

$lang['Split_Topic'] = "�ָ�����������";
$lang['Split_Topic_explain'] = "ʹ�����µ�ѡ�������Էָ����ӱ������,������ѡ��ָ�һ����������";
$lang['Split_title'] = "��������";
$lang['Split_forum'] = "Ҫ�ָ����⵽�µ���̳";
$lang['Split_posts'] = "�ָ�ѡ�������";
$lang['Split_after'] = "�ָ���ѡ�����µ�����(����ѡ�������)";
$lang['Topic_split'] = "ѡ��������Ѿ��ɹ��ر��ָ�";

$lang['Too_many_error'] = "��ѡ����̫�������.��ֻ��ѡ��һ���������ָ����µ�����!";

$lang['None_selected'] = "��û��ѡ���κε������������������.�����ѡ������һ������.";
$lang['New_forum'] = "����̳";

$lang['This_posts_IP'] = "������ӵ�IP��ַ";
$lang['Other_IP_this_user'] = "������ߵ������ĵ�ַ";
$lang['Users_this_IP'] = "�������IP���û�";
$lang['IP_info'] = "IP��ַ��Ϣ";
$lang['Lookup_IP'] = "����IP��ַ";


//
// Timezones ... for display on each page
//
$lang['All_times'] = "��̳ʱ��Ϊ %s"; // eg. All times are GMT - 12 Hours (times from next block)

$lang['-12'] = "GMT - 12 Сʱ";
$lang['-11'] = "GMT - 11 Сʱ";
$lang['-10'] = "HST (������)";
$lang['-9'] = "GMT - 9 Сʱ";
$lang['-8'] = "PST (����/���ô�)";
$lang['-7'] = "MST (����/���ô�)";
$lang['-6'] = "CST (����/���ô�)";
$lang['-5'] = "EST (����/���ô�)";
$lang['-4'] = "GMT - 4 Сʱ";
$lang['-3.5'] = "GMT - 3.5 Сʱ";
$lang['-3'] = "GMT - 3 Сʱ";
$lang['-2'] = "�д�����";
$lang['-1'] = "GMT - 1 Сʱ";
$lang['0'] = "GMT";
$lang['1'] = "CET (ŷ��)";
$lang['2'] = "EET (ŷ��)";
$lang['3'] = "GMT + 3 Сʱ";
$lang['3.5'] = "GMT + 3.5 Сʱ";
$lang['4'] = "GMT + 4 Сʱ";
$lang['4.5'] = "GMT + 4.5 Сʱ";
$lang['5'] = "GMT + 5 Сʱ";
$lang['5.5'] = "GMT + 5.5 Сʱ";
$lang['6'] = "GMT + 6 Сʱ";
$lang['6.5'] = 'GMT + 6.5 Сʱ';
$lang['7'] = "GMT + 7 Сʱ";
$lang['8'] = "����ʱ��";
$lang['9'] = "GMT + 9 Сʱ";
$lang['9.5'] = "CST (�Ĵ�����)";
$lang['10'] = "EST (�Ĵ�����)";
$lang['11'] = "GMT + 11 Сʱ";
$lang['12'] = "GMT + 12 Сʱ";
$lang['13'] = "GMT + 13 Сʱ";


// These are displayed in the timezone select box
$lang['tz']['-12'] = "(GMT -12:00 Сʱ) �������п˵�, ����ֵ�";
$lang['tz']['-11'] = "(GMT -11:00 Сʱ) ��;��, ��Ħ��Ⱥ��";
$lang['tz']['-10'] = "(GMT -10:00 Сʱ) ��������";
$lang['tz']['-9'] = "(GMT -9:00 Сʱ) ����˹����";
$lang['tz']['-8'] = "(GMT -8:00 Сʱ) ̫ƽ��ʱ�� (���� &amp; ���ô�), �Ừ��";
$lang['tz']['-7'] = "(GMT -7:00 Сʱ) ɽ�ر�׼ʱ�� (���� &amp; ���ô�), ����ɣ����";
$lang['tz']['-6'] = "(GMT -6:00 Сʱ) ����ʱ (���� &amp; ���ô�), ī�����";
$lang['tz']['-5'] = "(GMT -5:00 Сʱ) ����ʱ�� (���� &amp; ���ô�), �����, ����, ����";
$lang['tz']['-4'] = "(GMT -4:00 Сʱ) ������ʱ�� (���ô�), ������˹, ����˹";
$lang['tz']['-3.5'] = "(GMT -3:30 Сʱ) Ŧ����";
$lang['tz']['-3'] = "(GMT -3:00 Сʱ) ����, ����ŵ˹����˹, ���ζ�, ������Ⱥ��";
$lang['tz']['-2'] = "(GMT -2:00 Сʱ) �д�����, ��ɭ�ɵ�, ʥ������";
$lang['tz']['-1'] = "(GMT -1:00 Сʱ) ���ٶ�Ⱥ��, ά�½ǵ�";
$lang['tz']['0'] = "(GMT) ����������, ������, ������, �׶�, ��˹��, ����ά��";
$lang['tz']['1'] = "(GMT +1:00 Сʱ) ��ķ˹�ص�, ����, ��³����, �籾����, �����, ����, ����";
$lang['tz']['2'] = "(GMT +2:00 Сʱ) ����, �ն�����, ����������, �Ϸ�";
$lang['tz']['3'] = "(GMT +3:00 Сʱ) �͸��, ���ŵ�, Ī˹��, ���ޱ�";
$lang['tz']['3.5'] = "(GMT +3:30 Сʱ) �º���";
$lang['tz']['4'] = "(GMT +4:00 Сʱ) ��������, �Ϳ�, ��˹����, �ڱ���˹";
$lang['tz']['4.5'] = "(GMT +4:30 Сʱ) ������";
$lang['tz']['5'] = "(GMT +5:00 Сʱ) �������ձ�, ��˹����, ������, ��ʲ��";
$lang['tz']['5.5'] = "(GMT +5:30 Сʱ) ����, �Ӷ�����, �����˹, �µ���";
$lang['tz']['6'] = "(GMT +6:00 Сʱ) ������, ������, �￨������������";
$lang['tz']['6.5'] = "(GMT +6:30 Сʱ) ����";
$lang['tz']['7'] = "(GMT +7:00 Сʱ) ����, ����, �żӴ�";
$lang['tz']['8'] = "(GMT +8:00 Сʱ) ����, ���, ��˼, �¼���, ̨��";
$lang['tz']['9'] = "(GMT +9:00 Сʱ) ����, ����, ����, ����, �ſ�Ŀ�";
$lang['tz']['9.5'] = "(GMT +9:30 Сʱ) �����׵�, �����";
$lang['tz']['10'] = "(GMT +10:00 Сʱ) ���������ص���Ī����, Ϥ��, ��������˹�п�";
$lang['tz']['11'] = "(GMT +11:00 Сʱ) ��ӵ�, �¿��������, ������Ⱥ��";
$lang['tz']['12'] = "(GMT +12:00 Сʱ) �¿���, �����, 쳼�, ��Ъ��Ⱥ��";
$lang['tz']['13'] = "(GMT +13:00 Сʱ) Ŭ�Ⱒ�巨";

$lang['datetime']['Sunday'] = "������";
$lang['datetime']['Monday'] = "����һ";
$lang['datetime']['Tuesday'] = "���ڶ�";
$lang['datetime']['Wednesday'] = "������";
$lang['datetime']['Thursday'] = "������";
$lang['datetime']['Friday'] = "������";
$lang['datetime']['Saturday'] = "������";
$lang['datetime']['Sun'] = "������";
$lang['datetime']['Mon'] = "����һ";
$lang['datetime']['Tue'] = "���ڶ�";
$lang['datetime']['Wed'] = "������";
$lang['datetime']['Thu'] = "������";
$lang['datetime']['Fri'] = "������";
$lang['datetime']['Sat'] = "������";
$lang['datetime']['January'] = "һ��";
$lang['datetime']['February'] = "����";
$lang['datetime']['March'] = "����";
$lang['datetime']['April'] = "����";
$lang['datetime']['May'] = "����";
$lang['datetime']['June'] = "����";
$lang['datetime']['July'] = "����";
$lang['datetime']['August'] = "����";
$lang['datetime']['September'] = "����";
$lang['datetime']['October'] = "ʮ��";
$lang['datetime']['November'] = "ʮһ��";
$lang['datetime']['December'] = "ʮ����";
$lang['datetime']['Jan'] = "һ��";
$lang['datetime']['Feb'] = "����";
$lang['datetime']['Mar'] = "����";
$lang['datetime']['Apr'] = "����";
$lang['datetime']['May'] = "����";
$lang['datetime']['Jun'] = "����";
$lang['datetime']['Jul'] = "����";
$lang['datetime']['Aug'] = "����";
$lang['datetime']['Sep'] = "����";
$lang['datetime']['Oct'] = "ʮ��";
$lang['datetime']['Nov'] = "ʮһ��";
$lang['datetime']['Dec'] = "ʮ����";

//
// Errors (not related to a
// specific failure on a page)
//
$lang['Information'] = "��Ϣ��ʾ";
$lang['Critical_Information'] = "�ؼ���Ϣ";

$lang['General_Error'] = "��ͨ����";
$lang['Critical_Error'] = "�ؼ�����";
$lang['An_error_occured'] = "������һ������";
$lang['A_critical_error'] = "������һ���ؼ��Դ���";

//
// That's all Folks!
// -------------------------------------------------

?>