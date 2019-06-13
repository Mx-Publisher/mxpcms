<?php
/***************************************************************************
 *                            lang_main.php [English]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_main.php,v 1.1 2002/04/01 12:45:01 psotfx Exp $
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
// The format of this file is:
//
// ---> $lang['message'] = "text";
//
// You should also try to set a locale and a character
// encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may
// not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

//setlocale(LC_ALL, "en");
$lang['ENCODING'] = "iso-8859-1";
$lang['DIRECTION'] = "LTR";
$lang['LEFT'] = "LEFT";
$lang['RIGHT'] = "RIGHT";
$lang['DATE_FORMAT'] = "d M Y"; // This should be changed to the default date format for your language, php date() format

//
// Common, these terms are used
// extensively on several pages
//
$lang['Forum'] = "Forum";
$lang['Category'] = "Kategori";
$lang['Topic'] = "Tema";
$lang['Topics'] = "Temat";
$lang['Replies'] = "P�rgjigjet";
$lang['Views'] = "Shikime";
$lang['Post'] = "Mesazh";
$lang['Posts'] = "Mesazhe";
$lang['Posted'] = "Postuar";
$lang['Username'] = "Identifikim";
$lang['Password'] = "Fjal�kalim";
$lang['Email'] = "Email";
$lang['Poster'] = "Shkruesi";
$lang['Author'] = "Autori";
$lang['Time'] = "Ora";
$lang['Hours'] = "Or�";
$lang['Message'] = "Mesazh";

$lang['1_Day'] = "1 Dit�";
$lang['7_Days'] = "7 Dit�";
$lang['2_Weeks'] = "2 Jav�";
$lang['1_Month'] = "1 Muaj";
$lang['3_Months'] = "3 Muaj";
$lang['6_Months'] = "6 Muaj";
$lang['1_Year'] = "1 Vit";

$lang['Go'] = "Shko";
$lang['Jump_to'] = "K�rce tek";
$lang['Submit'] = "Paraqit";
$lang['Reset'] = "Nga e para";
$lang['Cancel'] = "Anullo";
$lang['Preview'] = "Preview";
$lang['Confirm'] = "Konfirmo";
$lang['Spellcheck'] = "Spellcheck";
$lang['Yes'] = "Po";
$lang['No'] = "Jo";
$lang['Enabled'] = "Aktivizuar";
$lang['Disabled'] = "C'aktivizuar";
$lang['Error'] = "Problem";

$lang['Next'] = "Tjetri";
$lang['Previous'] = "I m�parsh�m";
$lang['Goto_page'] = "Shko tek faqja";
$lang['Joined'] = "An�tar�suar";
$lang['IP_Address'] = "Adresa IP";

$lang['Select_forum'] = "Zgjidh nj� forum";
$lang['View_latest_post'] = "Shiko mesazhin e fundit";
$lang['View_newest_post'] = "Shiko mesazhin m� t� ri";
$lang['Page_of'] = "Faqja <b>%d</b> e <b>%d</b>"; // Replaces with: Page 1 of 2 for example

$lang['ICQ'] = "Nr. i ICQ";
$lang['AIM'] = "Adresa e AIM";
$lang['MSNM'] = "MSN Messenger";
$lang['YIM'] = "Yahoo Messenger";

$lang['Forum_Index'] = "%s Indeksi i forumit";  // eg. sitename Forum Index, %s can be removed if you prefer

$lang['Post_new_topic'] = "Posto tem� t� re";
$lang['Reply_to_topic'] = "P�rgjigju tem�s";
$lang['Reply_with_quote'] = "P�rgjigju me kuot�";

$lang['Click_return_topic'] = "Kliko %sk�tu%s p�r tu kthyer tek tema"; // %s's here are for uris, do not remove!
$lang['Click_return_login'] = "Kliko %sk�tu%s p�r ta riprovuar";
$lang['Click_return_forum'] = "Kliko %sk�tu%s p�r tu kthyer tek forumi";
$lang['Click_view_message'] = "Kliko %sk�tu%s p�r t� par� mesazhin t�nd";
$lang['Click_return_modcp'] = "Kliko %sk�tu%s p�r tu kthyer Paneli i Kontrollit p�r Moderator�t";
$lang['Click_return_group'] = "Kliko %sk�tu%s p�r tu kthyer tek informacioni i grupit";

$lang['Admin_panel'] = "Shko tek Paneli i Administrimit";

$lang['Board_disable'] = "K�rkojme ndjes� po ky forum nuk �sht� i disponuesh�m";


//
// Global Header strings
//
$lang['Registered_users'] = "An�tar�t e regjistruar";
$lang['Browsing_forum'] = "P�rdoruesit q� po shfletojn� forumin:";
$lang['Online_users_zero_total'] = "<b>0</b> p�rdorues online:";
$lang['Online_users_total'] = "<b>%d</b> p�rdorues online:";
$lang['Online_user_total'] = "<b>%d</b> p�rdorues online:";
$lang['Reg_users_zero_total'] = " 0 an�tar�";
$lang['Reg_users_total'] = " %d an�tar�";
$lang['Reg_user_total'] = " %d an�tar";
$lang['Hidden_users_zero_total'] = " 0 t� fshehur";
$lang['Hidden_user_total'] = " %d t� fshehur";
$lang['Hidden_users_total'] = " %d t� fshehur";
$lang['Guest_users_zero_total'] = " 0 vizitor�";
$lang['Guest_users_total'] = " %d vizitor�";
$lang['Guest_user_total'] = " %d vizitor";
$lang['Record_online_users'] = "Nr. Rekord i p�rdoruesve online ishte <b>%s</b> m� %s"; // first %s = number of users, second %s is the date.

$lang['Admin_online_color'] = "%sAdministrator%s";
$lang['Mod_online_color'] = "%sModerator%s";

$lang['You_last_visit'] = "Hera e fundit q� vizituat %s"; // %s replaced by date/time
$lang['Current_time'] = "Ora �sht� %s"; // %s replaced by time

$lang['Search_new'] = "Shiko mesazhet q� nga vizita e fundit";
$lang['Search_your_posts'] = "Shiko mesazhet e tua";
$lang['Search_unanswered'] = "Shiko mesazhet pa p�rgjigje";

$lang['Register'] = "Regjistrohu";
$lang['Profile'] = "Profili";
$lang['Edit_profile'] = "Modifiko profilin";
$lang['Search'] = "K�rko";
$lang['Memberlist'] = "Lista e An�tar�ve";
$lang['FAQ'] = "FAQ";
$lang['BBCode_guide'] = "Udh�zuesi i BBCode";
$lang['Usergroups'] = "Grupet e An�tar�ve";
$lang['Last_Post'] = "Mesazhi i fundit";
$lang['Moderator'] = "Moderator";
$lang['Moderators'] = "Moderator�";


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = "An�tar�t e k�tij forumi kan� postuar <b>0</b> artikuj"; // Number of posts
$lang['Posted_articles_total'] = "An�tar�t e k�tij forumi kan� postuar <b>%d</b> artikuj"; // Number of posts
$lang['Posted_article_total'] = "An�tar�t e k�tij forumi kan� postuar <b>%d</b> artikull"; // Number of posts
$lang['Registered_users_zero_total'] = "Forumi ka <b>0</b> an�tar� t� regjistruar"; // # registered users
$lang['Registered_users_total'] = "Forumi ka <b>%d</b> an�tar� t� regjistruar"; // # registered users
$lang['Registered_user_total'] = "Forumi ka <b>%d</b> an�tar t� regjistruar"; // # registered users
$lang['Newest_user'] = "An�tari m� i ri �sht� <b>%s%s%s</b>"; // a href, username, /a 

$lang['No_new_posts_last_visit'] = "Asnj� mesazh i ri q� nga vizita juaj e fundit";
$lang['No_new_posts'] = "Asnj� mesazh i ri";
$lang['New_posts'] = "Mesazhe t� reja";
$lang['New_post'] = "Mesazh i ri";
$lang['No_new_posts_hot'] = "Asnj� mesazh i ri [ Popular ]";
$lang['New_posts_hot'] = "Mesazhe t� reja [ Popular ]";
$lang['No_new_posts_locked'] = "Asnj� mesazh i ri [ Locked ]";
$lang['New_posts_locked'] = "Mesazhe t� reja [ Locked ]";
$lang['Forum_is_locked'] = "Forumi �sht� kycur";


//
// Login
//
$lang['Enter_password'] = "Ju lutem shkruani identifikimin dhe fjalkalimin p�r tu identifikuar";
$lang['Login'] = "Identifikohu";
$lang['Logout'] = "C'identifikohu";

$lang['Forgotten_password'] = "Harrova fjalkalimin";

$lang['Log_me_in'] = "M� identifiko automatikisht sa her� q� vizitoj";

$lang['Error_login'] = "Keni specifikuar nj� llogari inekzistente, inaktive ose nj� fjal�kalim t� gabuar";


//
// Index page
//
$lang['Index'] = "Indeksi";
$lang['No_Posts'] = "Asnj� mesazh";
$lang['No_forums'] = "Ky forum �sht� bosh";

$lang['Private_Message'] = "Mesazh Privat";
$lang['Private_Messages'] = "Mesazhe Private";
$lang['Who_is_Online'] = "Kush �sht� online";

$lang['Mark_all_forums'] = "Sh�noji gjith� forumet si t� vizituar";
$lang['Forums_marked_read'] = "T� gjith� forumet jan� sh�nuar si t� lexuar";


//
// Viewforum
//
$lang['View_forum'] = "Shiko forumin";

$lang['Forum_not_exist'] = "Forumi q� zgjodh�t nuk ekziston";
$lang['Reached_on_error'] = "Keni arritur tek kjo faqe n�p�rmjet nj� gabimi";

$lang['Display_topics'] = "Shfaq tema nga ";
$lang['All_Topics'] = "Gjith� temat";

$lang['Topic_Announcement'] = "<b>Lajm�rim:</b>";
$lang['Topic_Sticky'] = "<b>Ngjit�s</b>";
$lang['Topic_Moved'] = "<b>Ka l�vizur</b>";
$lang['Topic_Poll'] = "<b>[ Sondazh ]</b>";

$lang['Mark_all_topics'] = "Sh�noji gjith� temat si t� lexuara";
$lang['Topics_marked_read'] = "Temat e k�tij forumi u sh�nuan si t� lexuara";

$lang['Rules_post_can'] = "Ju <b>mund</b> t� krijoni tema t� reja n� k�t� forum";
$lang['Rules_post_cannot'] = "Ju <b>nuk mund</b> t� krijoni tema t� reja n� k�t� forum";
$lang['Rules_reply_can'] = "Ju <b>mund</b> ti p�rgjigjeni temave t� k�tij forumi";
$lang['Rules_reply_cannot'] = "Ju <b>nuk mund</b> ti p�rgjigjeni temave t� k�tij forumi";
$lang['Rules_edit_can'] = "Ju <b>mund</b> t� modifikoni postimet tuaja n� k�t� forum";
$lang['Rules_edit_cannot'] = "Ju <b>nuk mund</b> t� modifikoni postimet tuaja n� k�t� forum";
$lang['Rules_delete_can'] = "Ju <b>mund</b> t� fshini postimet tuaja n� k�t� forum";
$lang['Rules_delete_cannot'] = "Ju <b>nuk mund</b> t� fshini postimet tuaja n� k�t� forum";
$lang['Rules_vote_can'] = "Ju <b>mund</b> t� votoni n� votimet e k�tij forumi";
$lang['Rules_vote_cannot'] = "Ju <b>nuk mund</b> t� votoni n� votimet e k�tij forumi";
$lang['Rules_moderate'] = "Ju <b>mund</b> t� %smoderoni k�t� forum%s"; // %s replaced by a href links, do not remove! 

$lang['No_topics_post_one'] = "Nuk ka asnj� mesazh n� k�t� forum<br />Kliko tek <b>Hap tem� t� re</b> p�r t� hapur nj�";


//
// Viewtopic
//
$lang['View_topic'] = "Shiko tem�n";

$lang['Guest'] = 'Guest';
$lang['Post_subject'] = "Titulli i mesazhit";
$lang['View_next_topic'] = "Shiko tem�n pasuese";
$lang['View_previous_topic'] = "Shiko tem�n e m�parshme";
$lang['Submit_vote'] = "Paraqit vot�n";
$lang['View_results'] = "Shiko rezultatin";

$lang['No_newer_topics'] = "Nuk ka tema m� t� reja n� k�t� forum";
$lang['No_older_topics'] = "Nuk ka tema m� t� vjetra n� k�t� forum";
$lang['Topic_post_not_exist'] = "Tema ose mesazhi q� k�rkuat nuk ekziston";
$lang['No_posts_topic'] = "Nuk ka asnj� mezash p�r k�t� tem�";

$lang['Display_posts'] = "Shfaq mesazhe nga";
$lang['All_Posts'] = "T� gjitha mesazhet";
$lang['Newest_First'] = "M� i riu n� krye";
$lang['Oldest_First'] = "M� i vjetri n� krye";

$lang['Back_to_top'] = "Mbrapsht n� krye";

$lang['Read_profile'] = "Shiko profilin e an�tarit"; 
$lang['Send_email'] = "D�rgo email";
$lang['Visit_website'] = "Vizito websitin e shkruesit";
$lang['ICQ_status'] = "Statusi n� ICQ";
$lang['Edit_delete_post'] = "Modifiko/fshi k�t� mesazh";
$lang['View_IP'] = "Shiko IP e shkruesit";
$lang['Delete_post'] = "Fshije k�t� mesazh";

$lang['wrote'] = "shkruajti"; // proceeds the username and is followed by the quoted text
$lang['Quote'] = "Kuot�"; // comes before bbcode quote output.
$lang['Code'] = "Kodi"; // comes before bbcode code output.

$lang['Edited_time_total'] = "Edituar p�r her� t� fundit nga %s n� %s, edituar %d her� gjithsej"; // Last edited by me on 12 Oct 2001, edited 1 time in total
$lang['Edited_times_total'] = "Edituar p�r her� t� fundit nga %s n� %s, edituar %d her� gjithsej"; // Last edited by me on 12 Oct 2001, edited 2 times in total

$lang['Lock_topic'] = "Kyce k�t� tem�";
$lang['Unlock_topic'] = "Shkyce k�t� tem�";
$lang['Move_topic'] = "Zhvendose k�t� tem�";
$lang['Delete_topic'] = "Fshije k�t� tem�";
$lang['Split_topic'] = "Ndaje k�t� tem�";

$lang['Stop_watching_topic'] = "Ndalo s� v�zhguari k�t� tem�";
$lang['Start_watching_topic'] = "V�zhgo k�t� tem� p�r p�rgjigje";
$lang['No_longer_watching'] = "Ju nuk e v�zhgoni m� k�t� tem�";
$lang['You_are_watching'] = "Ju jeni duke e v�zhguar k�t� tem�";

$lang['Total_votes'] = "Totali i votave";

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = "P�rmbajtja e mesazhit";
$lang['Topic_review'] = "Shqyrto tem�n";

$lang['No_post_mode'] = "M�nyra e postimit nuk �sht� specifikuar"; // If posting.php is called without a mode (newtopic/reply/delete/etc, shouldn't be shown normaly)

$lang['Post_a_new_topic'] = "Hap nj� tem� t� re";
$lang['Post_a_reply'] = "P�rgjigju";
$lang['Post_topic_as'] = "Hap nj� tem� si";
$lang['Edit_Post'] = "Modifiko mesazhin";
$lang['Options'] = "Mund�sit�";

$lang['Post_Announcement'] = "Lajm�rim";
$lang['Post_Sticky'] = "Ngjit�s";
$lang['Post_Normal'] = "Normal";

$lang['Confirm_delete'] = "Jeni i sigurt� p�r fshirjen e k�tij mesazhi?";
$lang['Confirm_delete_poll'] = "Jeni i sigurt� p�r fshirjen e k�tij sondazhi?";

$lang['Flood_Error'] = "Nuk mund t� postoni prap� menj�her�";
$lang['Empty_subject'] = "Duhet t� specifikoni nj� titull kur postoni nj� mesazh";
$lang['Empty_message'] = "Duhet t� shkruani dicka kur postoni nj� mesazh";
$lang['Forum_locked'] = "Forumi �sht� kycur. Postimi, modifikimi dhe fshirja e temave s'lejohet";
$lang['Topic_locked'] = "Forumi �sht� kycur. Postimi dhe modifikimi i mesazheve nuk lejohet";
$lang['No_post_id'] = "Nuk u specifikua ID e postimit";
$lang['No_topic_id'] = "Duhet t� zgjidhni nj� tem� p�r tu p�rgjigjur";
$lang['No_valid_mode'] = "Ju vet�m mund t� postoni, p�rgjigjeni, modifikoni ose kuotoni mesazhet...ju lutem provojeni prap�";
$lang['No_such_post'] = "Nj� post i till� nuk ekziston, ju lutem provoni prap�";
$lang['Edit_own_posts'] = "Na vjen keq po ju mund t� editoni vet�m mesazhet tuaja";
$lang['Delete_own_posts'] = "Na vjen keq po ju mund t� fshini vet�m mesazhet tuaja";
$lang['Cannot_delete_replied'] = "Na vjen keq po ju nuk mund t� fshini mesazhe t� cilat kan� p�rgjigje";
$lang['Cannot_delete_poll'] = "Na vjen keq po ju nuk mund t� fshini nj� sondazh aktiv";
$lang['Empty_poll_title'] = "Duhet t� specifikoni nj� titull p�r sondazhin tuaj";
$lang['To_few_poll_options'] = "Duhet t� specifikoni t� pakt�n dy zgjedhje p�r sondazhin";
$lang['To_many_poll_options'] = "Keni v�n� shum� zgjedhje p�r sondazhin";
$lang['Post_has_no_poll'] = "Ky mesazh nuk ka sondazh";

$lang['Add_poll'] = "Hap nj� sondazh";
$lang['Add_poll_explain'] = "Nqs nuk do t� shtosh nj� sondazh tek tema, l�re fush�n bosh";
$lang['Poll_question'] = "Pyetja e sondazhit";
$lang['Poll_option'] = "Zgjedhje sondazhi";
$lang['Add_option'] = "Shto mund�si";
$lang['Update'] = "Ri-fresko";
$lang['Delete'] = "Fshi";
$lang['Poll_for'] = "Vazhdo sondazhin p�r";
$lang['Days'] = "Dit�"; // This is used for the Run poll for ... Days + in admin_forums for pruning
$lang['Poll_for_explain'] = "[ Shkruaj 0 ose l�r bosh p�r nj� sondazh q� vazhdon gjithmon� ]";
$lang['Delete_poll'] = "Fshi sondazhin";

$lang['Disable_HTML_post'] = "Disaktivizo HTML n� k�t� mesazh";
$lang['Disable_BBCode_post'] = "Disaktivizo BBCode n� k�t� mesazh";
$lang['Disable_Smilies_post'] = "Disaktivizo figurinat n� k�t� mesazh";

$lang['HTML_is_ON'] = "HTML �sht� e <u>aktivizuar</u>";
$lang['HTML_is_OFF'] = "HTML �sht� e <u>disaktivizuar</u>";
$lang['BBCode_is_ON'] = "%sBBCode%s �sht� i <u>aktivizuar</u>"; // %s are replaced with URI pointing to FAQ
$lang['BBCode_is_OFF'] = "%sBBCode%s �sht� i <u>disaktivizuar</u>";
$lang['Smilies_are_ON'] = "Figurinat jan� <u>aktivizuar</u>";
$lang['Smilies_are_OFF'] = "Figurinat jan� <u>disaktivizuar</u>";

$lang['Attach_signature'] = "Bashkangjit firm�n (firma mund t� modifikohet tek profili)";
$lang['Notify'] = "M� njofto kur dikush p�rgjigjet";
$lang['Delete_post'] = "Fshije k�t� mesazh";

$lang['Stored'] = "Mesazhi juaj u postua me sukses";
$lang['Deleted'] = "Mesazhi juaj u fshi me sukses";
$lang['Poll_delete'] = "Sondazhi juaj u fshi me sukses";
$lang['Vote_cast'] = "Vota juaj u regjistrua";

$lang['Topic_reply_notification'] = "Njoftim p�r p�rgjigje tek tema";

$lang['bbcode_b_help'] = "Bold text: [b]text[/b] (alt+b)";
$lang['bbcode_i_help'] = "Italic text: [i]text[/i] (alt+i)";
$lang['bbcode_u_help'] = "Underline text: [u]text[/u] (alt+u)";
$lang['bbcode_q_help'] = "Quote text: [quote]text[/quote] (alt+q)";
$lang['bbcode_c_help'] = "Code display: [code]code[/code] (alt+c)";
$lang['bbcode_l_help'] = "List: [list]text[/list] (alt+l)";
$lang['bbcode_o_help'] = "Ordered list: [list=]text[/list] (alt+o)";
$lang['bbcode_p_help'] = "Insert image: [img]http://image_url[/img] (alt+p)";
$lang['bbcode_w_help'] = "Insert URL: [url]http://url[/url] or [url=http://url]URL text[/url] (alt+w)";
$lang['bbcode_a_help'] = "Close all open bbCode tags";
$lang['bbcode_s_help'] = "Font color: [color=red]text[/color] Tip: you can also use color=#FF0000";
$lang['bbcode_f_help'] = "Font size: [size=x-small]small text[/size]";

$lang['Emoticons'] = "Emocionet";
$lang['More_emoticons'] = "Trego m� shum� emocione";

$lang['Font_color'] = "Ngjyra e fontit";
$lang['color_default'] = "E paracaktuar";
$lang['color_dark_red'] = "E kuqe e err�t";
$lang['color_red'] = "E kuqe";
$lang['color_orange'] = "Portokalli";
$lang['color_brown'] = "Kafe";
$lang['color_yellow'] = "E verdh�";
$lang['color_green'] = "Jeshile";
$lang['color_olive'] = "Ngjyr� ulliri";
$lang['color_cyan'] = "Boj�qielli";
$lang['color_blue'] = "Blu";
$lang['color_dark_blue'] = "Blu e err�t";
$lang['color_indigo'] = "Lejla";
$lang['color_violet'] = "Vjollc�";
$lang['color_white'] = "E bardh�";
$lang['color_black'] = "E zez�";

$lang['Font_size'] = "Nr. i fontit";
$lang['font_tiny'] = "i vock�l";
$lang['font_small'] = "i vog�l";
$lang['font_normal'] = "normal";
$lang['font_large'] = "i madh";
$lang['font_huge'] = "i st�rmadh";

$lang['Close_Tags'] = "Close Tags";
$lang['Styles_tip'] = "Tip: Styles can be applied quickly to selected text";


//
// Private Messaging
//
$lang['Private_Messaging'] = "Mesazhim privat";

$lang['Login_check_pm'] = "Identifikohu p�r t� par� mesazhet private";
$lang['New_pms'] = "Ju keni %d mesazhe t� reja"; // You have 2 new messages
$lang['New_pm'] = "Ju keni %d mesazh t� ri"; // You have 1 new message
$lang['No_new_pm'] = "Ju nuk keni asnj� mesazh t� ri";
$lang['Unread_pms'] = "Ju keni %d mesazhe t� palexuara";
$lang['Unread_pm'] = "Ju keni % mesazh t� palexuar";
$lang['No_unread_pm'] = "Ju nuk keni mesazhe t� palexuara";
$lang['You_new_pm'] = "Nj� mesazh privat i ri ka ardhur p�r ju tek Inbox";
$lang['You_new_pms'] = "Disa mesazhe private t� reja kan� ardhur p�r ju tek Inbox";
$lang['You_no_new_pm'] = "Asnj� mesazh privat i ri n� Inbox";

$lang['Inbox'] = "Inbox";
$lang['Outbox'] = "Outbox";
$lang['Savebox'] = "Savebox";
$lang['Sentbox'] = "Sentbox";
$lang['Flag'] = "Flag";
$lang['Subject'] = "Titulli";
$lang['From'] = "Nga";
$lang['To'] = "P�r";
$lang['Date'] = "Data";
$lang['Mark'] = "Sh�no";
$lang['Sent'] = "D�rguar";
$lang['Saved'] = "Ruajtur";
$lang['Delete_marked'] = "Fshi t� sh�nuar�t";
$lang['Delete_all'] = "Fshiji t� gjith�";
$lang['Save_marked'] = "Ruaji t� sh�nuar�t"; 
$lang['Save_message'] = "Ruaj mesazhin";
$lang['Delete_message'] = "Fshi mesazhin";

$lang['Display_messages'] = "Shfaq mesazhe nga"; // Followed by number of days/weeks/months
$lang['All_Messages'] = "T� gjith� mesazhet";

$lang['No_messages_folder'] = "Ju nuk keni asnj� mesazh n� k�t� dosje";

$lang['PM_disabled'] = "Mesazhet private nuk lejohen n� k�t� forum";
$lang['Cannot_send_privmsg'] = "Na vjen keq, po administratori jua ka ndaluar d�rgimin e mesazheve private";
$lang['No_to_user'] = "Duhet t� specifikoni nj� em�r p�r t� d�rguar k�t� mesazh";
$lang['No_such_user'] = "Na vjen keq po ky an�tar nuk ekziston";

$lang['Disable_HTML_pm'] = "C'aktivizo HTML n� k�t� mesazh";
$lang['Disable_BBCode_pm'] = "C'aktivizo BBCode n� k�t� mesazh";
$lang['Disable_Smilies_pm'] = "C'aktivizo figurinat n� k�t� mesazh";

$lang['Message_sent'] = "Mesazhi juaj u d�rgua";

$lang['Click_return_inbox'] = "Kliko %sk�tu%s p�r tu kthyer tek Inbox";
$lang['Click_return_index'] = "Kliko %sk�tu%s p�r tu kthyer tek Indeksi";

$lang['Send_a_new_message'] = "D�rgo nj� mesazh t� ri privat";
$lang['Send_a_reply'] = "P�rgjigju nj� mesazhi privat";
$lang['Edit_message'] = "Modifiko mesazhin privat";

$lang['Notification_subject'] = "Nj� mesazh i ri privat ka ardhur";

$lang['Find_username'] = "Gjej nj� an�tar";
$lang['Find'] = "Gjej";
$lang['No_match'] = "Nuk u gjet asnj�";

$lang['No_post_id'] = "Nuk u specifikua ID e postimit";
$lang['No_such_folder'] = "Nj� dosje e till� nuk ekziston";
$lang['No_folder'] = "Asnj� dosje nuk u specifikua";

$lang['Mark_all'] = "Sh�noji t� gjith�/a";
$lang['Unmark_all'] = "De-Sh�no t� gjitha :)";

$lang['Confirm_delete_pm'] = "Jeni i sigurt� q� doni ta fshini k�t� mesazh?";
$lang['Confirm_delete_pms'] = "Jeni i sigurt� q� doni ti fshini k�to mesazhe?";

$lang['Inbox_size'] = "Ju e keni Inbox %d%% plot"; // eg. Your Inbox is 50% full
$lang['Sentbox_size'] = "Ju e keni Sentbox %d%% plot"; 
$lang['Savebox_size'] = "Ju e keni Savebox %d%% plot"; 

$lang['Click_view_privmsg'] = "Kliko %sk�tu%s p�r t� vizituar Inbox-in tuaj";


//
// Profiles/Registration
//
$lang['Viewing_user_profile'] = "Duke par� profilin :: %s"; // %s is username 
$lang['About_user'] = "Gjithcka mbi %s"; // %s is username

$lang['Preferences'] = "Preferencat";
$lang['Items_required'] = "Artikujt e sh�nuar me * jan� t� domosdosh�m (unless stated otherwise)";
$lang['Registration_info'] = "Informacioni i regjistrimit";
$lang['Profile_info'] = "Informacioni i profilit";
$lang['Profile_info_warn'] = "Ky informacion do jet� i disponuesh�m tek publiku";
$lang['Avatar_panel'] = "Paneli i kontrollit t� ikonave personale";
$lang['Avatar_gallery'] = "Galeria e ikonave personale";

$lang['Website'] = "Websit";
$lang['Location'] = "Vendodhja";
$lang['Contact'] = "Kontakto";
$lang['Email_address'] = "Adresa e e-mail";
$lang['Email'] = "Email";
$lang['Send_private_message'] = "D�rgo mesazh privat";
$lang['Hidden_email'] = "[ I/e fshehur ]";
$lang['Search_user_posts'] = "Gjej gjith� mesazhet nga %s";
$lang['Interests'] = "Interesat";
$lang['Occupation'] = "Profesioni"; 
$lang['Poster_rank'] = "Grada e an�tarit";

$lang['Total_posts'] = "Nr. total i mesazheve";
$lang['User_post_pct_stats'] = "%.2f%% i totalit"; // 1.25% of total
$lang['User_post_day_stats'] = "%.2f mesazhe n� dit�"; // 1.5 posts per day
$lang['Search_user_posts'] = "Gjej gjith� mesazhet nga %s"; // Find all posts by username

$lang['No_user_id_specified'] = "Na vjen keq po ai an�tar nuk ekziston";
$lang['Wrong_Profile'] = "Nuk lejohet modifiki i profilit t� nj� tjetri";

$lang['Only_one_avatar'] = "Lejohet vet�m nj� ikon� personale";
$lang['File_no_data'] = "Skedari tek URL q� specifikuat �sht� i korruptuar";
$lang['No_connection_URL'] = "Lidhja me URL q� specifikuat �sht� e pamundur p�r momentin";
$lang['Incomplete_URL'] = "URL q� specifikuat nuk ekziston";
$lang['Wrong_remote_avatar_format'] = "URL e ikon�s personale nuk �sht� e sakt�";
$lang['No_send_account_inactive'] = "Na vjen keq, po fjal�kalimi juaj nuk mund t� nxirret nga regjistri sepse llogaria juaj nuk �sht� aktive. Kontaktoni administratorin ";

$lang['Always_smile'] = "Lejo figurinat gjithmon�";
$lang['Always_html'] = "Lejo HTML gjithmon�";
$lang['Always_bbcode'] = "Lejo BBCode gjithmon�";
$lang['Always_add_sig'] = "Bashkangjite firm�n gjithmon�";
$lang['Always_notify'] = "M� njofto gjithmon� kur ka p�rgjigje";
$lang['Always_notify_explain'] = "D�rgon nj� email kur dikush shkruan n� nj� tem� ku keni shkruar edhe ju. Ky opsion mund t� ndryshohet sa her� q� poston";

$lang['Board_style'] = "Stili i forumit";
$lang['Board_lang'] = "Gjuha e forumit";
$lang['No_themes'] = "Asnj� tem� n� regjist�r";
$lang['Timezone'] = "Brezi orar";
$lang['Date_format'] = "Formati i koh�s";
$lang['Date_format_explain'] = "Sintaksa e p�rdorur �sht� identike me at� t� funksionit  <a href=\"http://www.php.net/date\" target=\"_other\">date()</a> t� PHP";
$lang['Signature'] = "Firma";
$lang['Signature_explain'] = "Kjo �sht� nj� th�nie ose grup fjal�sh q� i bashkangjitet cdo meszhi q� shkruani. Nj� limit prej %d karakteresh ekziston";
$lang['Public_view_email'] = "Gjithmon� tregoje adres�n time t� e-mail";

$lang['Current_password'] = "Fjal�kalimi i tanish�m";
$lang['New_password'] = "Fjal�kalimi i ri";
$lang['Confirm_password'] = "Konfirmo fjal�kalimin";
$lang['Confirm_password_explain'] = "You must confirm your current password if you wish to change it or alter your email address";
$lang['password_if_changed'] = "Vendosja e nj� fjal�kalimi �sht� e nevojshme vet�m n�se doni t� ndryshoni fjal�kalimin e tanish�m";
$lang['password_confirm_if_changed'] = "Konfirmimi i fjal�kalimit �sht� i nevojsh�m vet�m n�se doni t� ndryshoni fjal�kalimin e tanish�m";

$lang['Avatar'] = "Ikona personale";
$lang['Avatar_explain'] = "Shfaq nj� imazh t� vog�l posht� emrit tuaj kur postoni. Vet�m nj� imazh �sht� i lejuar dhe gjer�sia lejohet deri n� %d pixel, lart�sia deri n� %d pixel dhe madh�sia e skedarit deri n� %d kB."; 
$lang['Upload_Avatar_URL'] = "Ngarko ikon�n nga interneti";
$lang['Upload_Avatar_URL_explain'] = "Shkruaj adres�n e ikon�s, do kopjohet k�tu";
$lang['Pick_local_Avatar'] = "Zgjidh nj� ikon� nga galeria";
$lang['Link_remote_Avatar'] = "Link to off-site Avatar";
$lang['Link_remote_Avatar_explain'] = "Specifiko adres�n e internetit (URL) t� imazhit q� doni t� lidhni si ikon�";
$lang['Avatar_URL'] = "URL of Avatar Image";
$lang['Select_from_gallery'] = "Select Avatar from gallery";
$lang['View_avatar_gallery'] = "Show gallery";

$lang['Select_avatar'] = "Zgjidh ikon�n";
$lang['Return_profile'] = "Anulloje ikon�n";
$lang['Select_category'] = "Zgjidh kategorin�";

$lang['Delete_Image'] = "Fshi imazhin";
$lang['Current_Image'] = "Imazhi i tanish�m";

$lang['Notify_on_privmsg'] = "M� njofto p�r cdo mesazh privat";
$lang['Popup_on_privmsg'] = "Hap dritare t� re kur merr mesazh privat"; 
$lang['Popup_on_privmsg_explain'] = "Some templates may open a new window to inform you when new private messages arrive"; 
$lang['Hide_user'] = "Hide your online status";

$lang['Profile_updated'] = "Profili juaj u rifreskua";
$lang['Profile_updated_inactive'] = "Your profile has been updated, however you have changed vital details thus your account is now inactive. Check your email to find out how to reactivate your account, or if admin activation is require wait for the administrator to reactivate your account";

$lang['Password_mismatch'] = "Fjal�kalimet q� specifikuat jan� t� ndrysh�m";
$lang['Current_password_mismatch'] = "Fjal�kalimi q� specifikuat nuk �sht� i nj�jt� me at� n� regjistrin ton�";
$lang['Password_long'] = "Fjal�kalimi juaj nuk duhet t� ket� m� shum� se 32 karaktere";
$lang['Username_taken'] = "Na vjen keq po ky identifikim �sht� n� p�rdorim";
$lang['Username_invalid'] = "Na vjen keq po ky identifikim p�rmban nj� karakter invalid si psh. \"";
$lang['Username_disallowed'] = "Na vjen keq po ky identifikim nuk �sht� i lejuesh�m";
$lang['Email_taken'] = "Na vjen keq po ajo adres� poste elektronike �sht� p�rdorur m� par�";
$lang['Email_banned'] = "Na vjen keq po ajo adres� poste elektronike �sht� p�rjashtuar";
$lang['Email_invalid'] = "Na vjen keq po ajo adres� poste elektronike �sht� invalide";
$lang['Signature_too_long'] = "Firma juaj �sht� shum� e gjat�";
$lang['Fields_empty'] = "Duhet t� mbushni fushat e domosdoshme";
$lang['Avatar_filetype'] = "Lloji i skedarit t� ikon�s personale duhet t� jet� .jpg, .gif or .png";
$lang['Avatar_filesize'] = "Madh�sia e skedarit t� ikon�s personale lejohet deri n� %d kB"; // The avatar image file size must be less than 6 kB
$lang['Avatar_imagesize'] = "Ikona personale duhet t� jet� deri n� %d pixel e gj�r� dhe %d pixel e lart�"; 

$lang['Welcome_subject'] = "Mir�sevini tek %s Forums"; // Welcome to my.com forums
$lang['New_account_subject'] = "Llogari e re p�r an�tar�";
$lang['Account_activated_subject'] = "Llogaria u aktivizua";

$lang['Account_added'] = "Faleminderit p�r regjistrimin, llogaria juaj u hap. Ju tashti keni mund�si t� identifikoheni. ";
$lang['Account_inactive'] = "Llogaria juaj u hap. Megjithat�, ky forum k�rkon aktivizimin e llogaris�. Nj� mesazh me cel�sin e aktivizimit u d�rgua tek adresa q� dhat�. Shikoni mesazhin p�r m� shum� informacion.";
$lang['Account_inactive_admin'] = "Llogaria juaj u hap. Megjithat�, ky forum k�rkon aktivizimin e llogaris� nga administratori. Nj� mesazh do ju d�rgohet sapo llogaria juaj t� aktivizohet.";
$lang['Account_active'] = "Llogaria juaj u aktivizua, faleminderit p�r regjistrimin";
$lang['Account_active_admin'] = "Llogaria u aktivizua";
$lang['Reactivate'] = "Riaktivizo llogarin�";
$lang['COPPA'] = "Llogaria juaj u krijua por duhet t� aprovohet nga administratori. Shikoni post�n elektronike p�r detaje.";

$lang['Registration'] = "Kushtet e Regjistrimit";
$lang['Reg_agreement'] = "Megjith�se administrator�t dhe moderator�t e k�tij forumi do mundohen t� fshijn� ose redaktojn� shkrime t� kund�rshtueshme sa m� par�, �sht� e pamundur q� t� rishikohet cdo mesazh. Prandaj ju duhet t� kuptoni se mesazhet e postuara n� k�t� forum jan� shprehje e opinionit t� autorit dhe jo t� administratorit, moderator�ve apo webmasterit (p�rvec rasteve kur k�ta t� fundit jan� autor� t� shkrimeve) dhe ata nuk mund t� mbahen p�rgjegj�s. <br /><br />Ju pranoni t� mos shkruani mesazhe abuzuese, vulgare, t� neveritshme, urryese, k�rc�nuese, shpif�se apo cdo lloj materiali q� mund t� bjer� ndesh me ligjet n� p�rdorim. Shkrime t� tilla do cojn� n� p�rjashtimin tuaj t� menj�hersh�m dhe t� p�rhersh�m (dhe njoftimin e ISP-s� tuaj). Adresa IP p�r cdo mesazh regjistrohet p�r t� b�r� t� mundur aplikimin e k�tyre procedurave. Ju pranoni q� webmasteri, administratori dhe moderator�t e k�tij forumi kan� t� drejt� t� fshijn�, redaktojn�, zhvendosin apo kycin cdo tem� sipas gjykimit t� tyre. Si p�rdorues ju pranoni q� informacioni q� ju dhat� do t� ruhet n� nj� regjist�r. Megjith�se ky informacion nuk do i jepet askujt pa lejen tuaj webmasteri, administratori dhe moderator�t nuk mund t� mbahen p�rgjegj�s nqs ky informacion vidhet.<br /><br />Ky forum p�rdor cookies p�r t� ruajtur informacion n� kompjuterin tuaj. K�to cookies nuk p�rmbajn� asnj� informacion personal, ato sh�rbejn� vet�m p�r p�rmir�simin e sh�rbimit q� ofrohet nga ky forum. Adresa e post�s elektronike p�rdoret vet�m p�r konfirmimin e regjistrimit tuaj dhe fjal�kalimit (dhe n� rastet kur u d�rgohet nj� fjal�kalimi i ri nqs harroni at� q� kishit).";

$lang['Agree_under_13'] = "I pranoj k�to kushte dhe jam <b>n�n</b> 13 vjec";
$lang['Agree_over_13'] = "I pranoj k�to kushte dhe jam <b>mbi</b> 13 vjec";
$lang['Agree_not'] = "Nuk i pranoj k�to kushte";

$lang['Wrong_activation'] = "Cel�si i aktivizimit q� dhat� nuk p�rkon me asnj� cel�s n� regjistrin ton�.";
$lang['Send_password'] = "M� d�rgo nj� fjal�kalim t� ri"; 
$lang['Password_updated'] = "Nj� fjal�kalim i ri u krijua, shiko post�n elektronike p�r detajet e aktivizimit";
$lang['No_email_match'] = "Adresa e post�s elektronike q� dhat� nuk p�rkon me adres�n e atij an�tari";
$lang['New_password_activation'] = "Aktivizim i fjal�kalimit t� ri";
$lang['Password_activated'] = "Llogaria juaj u ri-aktivizua. Jepni fjal�kalimin e ri p�r tu identifikuar";

$lang['Send_email_msg'] = "D�rgo nj� mesazh me post� elektronike";
$lang['No_user_specified'] = "Asnj� an�tar nuk u specifikua";
$lang['User_prevent_email'] = "Ky an�tar nuk pranon mesazhe me post� elektronike. Provo ti d�rgosh nj� mesazh privat.";
$lang['User_not_exist'] = "Ai an�tar nuk ekziston";
$lang['CC_email'] = "D�rgoi vetes nj� kopje t� mesazhit";
$lang['Email_message_desc'] = "Ky mesazh do d�rgohet si tekst i thjesht�. Mos p�rdor HTML ose BBCode. Adresa e kthimit do jet� adresa juaj.";
$lang['Flood_email_limit'] = "Nuk mund t� d�rgosh nj� mesazh tashti. Provo m� von�";
$lang['Recipient'] = "Marr�si";
$lang['Email_sent'] = "Mesazhi u d�rgua";
$lang['Send_email'] = "D�rgo nj� mesazh";
$lang['Empty_subject_email'] = "Duhet t� specifikoni nj� subjekt p�r k�t� mesazh";
$lang['Empty_message_email'] = "Duhet t� shkruani dicka q� t� d�rgohet ky mesazh ";


//
// Memberslist
//
$lang['Select_sort_method'] = "Zgjidh metod�n e renditjes";
$lang['Sort'] = "Rendit";
$lang['Sort_Top_Ten'] = "Top Ten Posters";
$lang['Sort_Joined'] = "Data e an�tar�simit";
$lang['Sort_Username'] = "Identifikimi";
$lang['Sort_Location'] = "Vendi";
$lang['Sort_Posts'] = "Nr. total i mesazheve";
$lang['Sort_Email'] = "Adresa e post�s elektronike";
$lang['Sort_Website'] = "Websiti";
$lang['Sort_Ascending'] = "N� ngjitje";
$lang['Sort_Descending'] = "N� zbritje";
$lang['Order'] = "Rregulli";


//
// Group control panel
//
$lang['Group_Control_Panel'] = "Paneli i Kontrollit t� Grupeve";
$lang['Group_member_details'] = "Detajet e an�tar�sis� s� grupeve";
$lang['Group_member_join'] = "Futu n� nj� grup";

$lang['Group_Information'] = "Informacioni i grupit";
$lang['Group_name'] = "Emri i grupit";
$lang['Group_description'] = "P�rshkrimi i grupit";
$lang['Group_membership'] = "An�tar�sia e grupit";
$lang['Group_Members'] = "An�tar�t e grupit";
$lang['Group_Moderator'] = "Moderatori i grupit";
$lang['Pending_members'] = "An�tar�t n� pritje";

$lang['Group_type'] = "Lloji i grupit";
$lang['Group_open'] = "Grup i hapur";
$lang['Group_closed'] = "Grup i mbyllur";
$lang['Group_hidden'] = "Grup i fsheht�";

$lang['Current_memberships'] = "An�tar�sia aktuale";
$lang['Non_member_groups'] = "Grupet pa an�tar�";
$lang['Memberships_pending'] = "An�tar�sit� n� pritje";

$lang['No_groups_exist'] = "Asnj� grup nuk ekziston";
$lang['Group_not_exist'] = "Ai grup nuk ekziston";

$lang['Join_group'] = "Futu n� grup";
$lang['No_group_members'] = "Ky grup nuk ka an�tar�";
$lang['Group_hidden_members'] = "Ky grup �sht� i fsheht�. Nuk mund t'ja shikosh an�tar�sin�";
$lang['No_pending_group_members'] = "Ky grup nuk ka an�tar� n� pritje";
$lang["Group_joined"] = "Ju jeni pajtuar tek ky grup me sukses <br /> Ju do lajm�roheni me post� elektronike kur t� aprovoheni nga moderatori i grupit";
$lang['Group_request'] = "Esht� b�r� nj� k�rkes� p�r an�tar�sim";
$lang['Group_approved'] = "K�rkesa juaj u aprovua";
$lang['Group_added'] = "Ju shtuat k�tij grupi"; 
$lang['Already_member_group'] = "Ju jeni an�tar i k�tij grupi tashm�!";
$lang['User_is_member_group'] = "P�rdoruesi �sht� an�tar i k�tij grupi tashm�";
$lang['Group_type_updated'] = "Lloji i grupit u ri-freskua";

$lang['Could_not_add_user'] = "P�rdoruesi q� zgjodh�t nuk ekziston";
$lang['Could_not_anon_user'] = "Nuk mund ta b�sh an�tar grupi p�rdoruesin Anonymous";

$lang['Confirm_unsub'] = "Jeni i sigurt� p�r anullimin e pajtimit tek ky grup?";
$lang['Confirm_unsub_pending'] = "Pajtimi juaj tek ky grup nuk �sht� aprovuar akoma,  jeni i sigurt� q� doni ta anulloni?";

$lang['Unsub_success'] = "Pajtimi juaj tek ky grup �sht� anulluar";

$lang['Approve_selected'] = "Aprovo t� zgjedhurit";
$lang['Deny_selected'] = "Kund�rshto t� zgjedhurit";
$lang['Not_logged_in'] = "Duhet t� jeni i identifikuar p�r tu futur n� nj� grup";
$lang['Remove_selected'] = "Hiq t� zgjedhurit";
$lang['Add_member'] = "Shto an�tar";
$lang['Not_group_moderator'] = "Nuk mund ta kryeni at� veprim sepse nuk jeni moderatori i k�tij grupi";

$lang['Login_to_join'] = "Identifikohu p�r tu futur n� nj� grup ose p�r t� menaxhuar an�tar�sit�";
$lang['This_open_group'] = "Ky �sht� nj� grup i hapur, klikoni p�r t� k�rkuar an�tar�si";
$lang['This_closed_group'] = "Ky grup �sht� mbyllur, nuk pranohen m� an�tar�";
$lang['This_hidden_group'] = "Ky �sht� grup i fsheht�, nuk lejohet aplikimi automatik";
$lang['Member_this_group'] = "Ju jeni an�tar i k�tij grupi";
$lang['Pending_this_group'] = "K�rkesa juaj p�r an�tar�si n� k�t� grup nuk �sht� konfirmuar akoma";
$lang['Are_group_moderator'] = "Ju jeni moderatori i grupit";
$lang['None'] = "Asnj�";

$lang['Subscribe'] = "Pajtohu";
$lang['Unsubscribe'] = "Anullo pajtimin";
$lang['View_Information'] = "Shiko informacionin";


//
// Search
//
$lang['Search_query'] = "Search Query";
$lang['Search_options'] = "Search Options";

$lang['Search_keywords'] = "Search for Keywords";
$lang['Search_keywords_explain'] = "You can use <u>AND</u> to define words which must be in the results, <u>OR</u> to define words which may be in the result and <u>NOT</u> to define words which should not be in the result. Use * as a wildcard for partial matches";
$lang['Search_author'] = "K�rko p�r autorin";
$lang['Search_author_explain'] = "Use * as a wildcard for partial matches";

$lang['Search_for_any'] = "Search for any terms or use query as entered";
$lang['Search_for_all'] = "Search for all terms";
$lang['Search_title_msg'] = "K�rko titullin dhe p�rmbajtjen mesazhit";
$lang['Search_msg_only'] = "K�rko vet�m p�rmbajtjen mesazhit";

$lang['Return_first'] = "Return first"; // followed by xxx characters in a select box
$lang['characters_posts'] = "characters of posts";

$lang['Search_previous'] = "Search previous"; // followed by days, weeks, months, year, all in a select box

$lang['Sort_by'] = "Rendit sipas";
$lang['Sort_Time'] = "Koh�s s� postimit";
$lang['Sort_Post_Subject'] = "Subjekit t� mesazhit";
$lang['Sort_Topic_Title'] = "Titullit t� tem�s";
$lang['Sort_Author'] = "Autorit";
$lang['Sort_Forum'] = "Forumit";

$lang['Display_results'] = "Display results as";
$lang['All_available'] = "All available";
$lang['No_searchable_forums'] = "You do not have permissions to search any forum on this site";

$lang['No_search_match'] = "No topics or posts met your search criteria";
$lang['Found_search_match'] = "Search found %d match"; // eg. Search found 1 match
$lang['Found_search_matches'] = "Search found %d matches"; // eg. Search found 24 matches

$lang['Close_window'] = "Close Window";


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = "Sorry but only %s can post announcements in this forum";
$lang['Sorry_auth_sticky'] = "Sorry but only %s can post sticky messages in this forum"; 
$lang['Sorry_auth_read'] = "Sorry but only %s can read topics in this forum"; 
$lang['Sorry_auth_post'] = "Sorry but only %s can post topics in this forum"; 
$lang['Sorry_auth_reply'] = "Sorry but only %s can reply to posts in this forum"; 
$lang['Sorry_auth_edit'] = "Sorry but only %s can edit posts in this forum"; 
$lang['Sorry_auth_delete'] = "Sorry but only %s can delete posts in this forum"; 
$lang['Sorry_auth_vote'] = "Sorry but only %s can vote in polls in this forum"; 

// These replace the %s in the above strings
$lang['Auth_Anonymous_Users'] = "<b>p�rdorues anonim�</b>";
$lang['Auth_Registered_Users'] = "<b>p�rdorues t� regjistruar</b>";
$lang['Auth_Users_granted_access'] = "<b>users granted special access</b>";
$lang['Auth_Moderators'] = "<b>moderator�t</b>";
$lang['Auth_Administrators'] = "<b>administrator�t</b>";

$lang['Not_Moderator'] = "Ju nuk jeni moderator i k�tij forumi";
$lang['Not_Authorised'] = "I pa autorizuar";

$lang['You_been_banned'] = "Ju jeni p�rjashtuar nga ky forum <br />Kontaktoni webmasterin ose administratorin e forumit";


//
// Viewonline
//
$lang['Reg_users_zero_online'] = "Ka 0 an�tar� dhe "; // There ae 5 Registered and
$lang['Reg_users_online'] = "Ka %d an�tar� dhe "; // There ae 5 Registered and
$lang['Reg_user_online'] = "Ka %d an�tar dhe "; // There ae 5 Registered and
$lang['Hidden_users_zero_online'] = "0 Hidden users online"; // 6 Hidden users online
$lang['Hidden_users_online'] = "%d an�tar� sekret n� linj�"; // 6 Hidden users online
$lang['Hidden_user_online'] = "%d an�tar sekret n� linj�"; // 6 Hidden users online
$lang['Guest_users_online'] = "Ka %d vizitor� n� linj�"; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = "Ka 0 vizitor� n� linj�"; // There are 10 Guest users online
$lang['Guest_user_online'] = "Ka %d vizitor n� linj�"; // There is 1 Guest user online
$lang['No_users_browsing'] = "Nuk ka asnj� p�rdorues n� linj�";

$lang['Online_explain'] = "This data is based on users active over the past five minutes";

$lang['Forum_Location'] = "Venddodhja e forumit";
$lang['Last_updated'] = "Rifreskuar m�";

$lang['Forum_index'] = "Indeksi i forumit";
$lang['Logging_on'] = "Duke u identifikuar";
$lang['Posting_message'] = "Duke shkruar nj� mesazh";
$lang['Searching_forums'] = "Duke k�rkuar n�p�r forum";
$lang['Viewing_profile'] = "Duke par� profilin";
$lang['Viewing_online'] = "Duke par� kush �sht� n� linj�";
$lang['Viewing_member_list'] = "Duke par� list�n e an�tar�ve";
$lang['Viewing_priv_msgs'] = "Duke par� mesazhet private";
$lang['Viewing_FAQ'] = "Duke par� FAQ";


//
// Moderator Control Panel
//
$lang['Mod_CP'] = "Paneli i kontrollit p�r moderator�t";
$lang['Mod_CP_explain'] = "N�p�rmjet formularit t� m�posht�m mund t� moderoni k�t� forum. Mund t� kycni, shkycni, l�vizni ose fshini cdo tem� ose nr. temash.";

$lang['Select'] = "Zgjidh";
$lang['Delete'] = "Fshi";
$lang['Move'] = "L�viz";
$lang['Lock'] = "Kyc";
$lang['Unlock'] = "Shkyc";

$lang['Topics_Removed'] = "Temat e zgjedhura u hoq�n me sukses nga regjistri";
$lang['Topics_Locked'] = "Temat e zgjedhura u kyc�n me sukses";
$lang['Topics_Moved'] = "Temat e zgjedhura u zhvendos�n me sukses";
$lang['Topics_Unlocked'] = "Temat e zgjedhura u shkyc�n me sukses";
$lang['No_Topics_Moved'] = "Asnj� tem� nuk u zhvendos";

$lang['Confirm_delete_topic'] = "Jeni i sigurt� q� doni t� fshini tem�n/at e zgjedhur/a?";
$lang['Confirm_lock_topic'] = "Jeni i sigurt� q� doni t� kycni tem�n/at e zgjedhur/a?";
$lang['Confirm_unlock_topic'] = "Jeni i sigurt� q� doni t� shkycni tem�n/at e zgjedhur/a?";
$lang['Confirm_move_topic'] = "Jeni i sigurt� q� doni t� l�vizni tem�n/at e zgjedhur/a";

$lang['Move_to_forum'] = "Zhvendos tek forumi";
$lang['Leave_shadow_topic'] = "L�r hijen e tem�s tek forumi i vjet�r";

$lang['Split_Topic'] = "Split Topic Control Panel";
$lang['Split_Topic_explain'] = "Using the form below you can split a topic in two, either by selecting the posts individually or by splitting at a selected post";
$lang['Split_title'] = "New topic title";
$lang['Split_forum'] = "Forum for new topic";
$lang['Split_posts'] = "Split selected posts";
$lang['Split_after'] = "Split from selected post";
$lang['Topic_split'] = "The selected topic has been split successfully";

$lang['Too_many_error'] = "You have selected too many posts. You can only select one post to split a topic after!";

$lang['None_selected'] = "You have no selected any topics to preform this operation on. Please go back and select at least one.";
$lang['New_forum'] = "New forum";

$lang['This_posts_IP'] = "IP for this post";
$lang['Other_IP_this_user'] = "Other IP's this user has posted from";
$lang['Users_this_IP'] = "Users posting from this IP";
$lang['IP_info'] = "IP Information";
$lang['Lookup_IP'] = "Look up IP";


//
// Timezones ... for display on each page
//
$lang['All_times'] = "Ora �sht� sipas %s"; // eg. All times are GMT - 12 Hours (times from next block)

$lang['-12'] = "GMT - 12 Hours";
$lang['-11'] = "GMT - 11 Hours";
$lang['-10'] = "HST (Hawaii)";
$lang['-9'] = "GMT - 9 Hours";
$lang['-8'] = "PST (U.S./Canada)";
$lang['-7'] = "MST (U.S./Canada)";
$lang['-6'] = "CST (U.S./Canada)";
$lang['-5'] = "EST (U.S./Canada)";
$lang['-4'] = "GMT - 4 Hours";
$lang['-3.5'] = "GMT - 3.5 Hours";
$lang['-3'] = "GMT - 3 Hours";
$lang['-2'] = "Mid-Atlantic";
$lang['-1'] = "GMT - 1 Hours";
$lang['0'] = "GMT";
$lang['1'] = "CET (Europe)";
$lang['2'] = "EET (Europe)";
$lang['3'] = "GMT + 3 Hours";
$lang['3.5'] = "GMT + 3.5 Hours";
$lang['4'] = "GMT + 4 Hours";
$lang['4.5'] = "GMT + 4.5 Hours";
$lang['5'] = "GMT + 5 Hours";
$lang['5.5'] = "GMT + 5.5 Hours";
$lang['6'] = "GMT + 6 Hours";
$lang['6.5'] = "GMT + 6.5 Hours";
$lang['7'] = "GMT + 7 Hours";
$lang['8'] = "WST (Australia)";
$lang['9'] = "GMT + 9 Hours";
$lang['9.5'] = "CST (Australia)";
$lang['10'] = "EST (Australia)";
$lang['11'] = "GMT + 11 Hours";
$lang['12'] = "GMT + 12 Hours";

// These are displayed in the timezone select box
$lang['tz']['-12'] = "(GMT -12:00 hours) Eniwetok, Kwajalein";
$lang['tz']['-11'] = "(GMT -11:00 hours) Midway Island, Samoa";
$lang['tz']['-10'] = "(GMT -10:00 hours) Hawaii";
$lang['tz']['-9'] = "(GMT -9:00 hours) Alaska";
$lang['tz']['-8'] = "(GMT -8:00 hours) Pacific Time (US &amp; Canada), Tijuana";
$lang['tz']['-7'] = "(GMT -7:00 hours) Mountain Time (US &amp; Canada), Arizona";
$lang['tz']['-6'] = "(GMT -6:00 hours) Central Time (US &amp; Canada), Mexico City";
$lang['tz']['-5'] = "(GMT -5:00 hours) Eastern Time (US &amp; Canada), Bogota, Lima, Quito";
$lang['tz']['-4'] = "(GMT -4:00 hours) Atlantic Time (Canada), Caracas, La Paz";
$lang['tz']['-3.5'] = "(GMT -3:30 hours) Newfoundland";
$lang['tz']['-3'] = "(GMT -3:00 hours) Brassila, Buenos Aires, Georgetown, Falkland Is";
$lang['tz']['-2'] = "(GMT -2:00 hours) Mid-Atlantic, Ascension Is., St. Helena";
$lang['tz']['-1'] = "(GMT -1:00 hours) Azores, Cape Verde Islands";
$lang['tz']['0'] = "(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia";
$lang['tz']['1'] = "(GMT +1:00 hours) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome";
$lang['tz']['2'] = "(GMT +2:00 hours) Cairo, Helsinki, Kaliningrad, South Africa, Warsaw";
$lang['tz']['3'] = "(GMT +3:00 hours) Baghdad, Riyadh, Moscow, Nairobi";
$lang['tz']['3.5'] = "(GMT +3:30 hours) Tehran";
$lang['tz']['4'] = "(GMT +4:00 hours) Abu Dhabi, Baku, Muscat, Tbilisi";
$lang['tz']['4.5'] = "(GMT +4:30 hours) Kabul";
$lang['tz']['5'] = "(GMT +5:00 hours) Ekaterinburg, Islamabad, Karachi, Tashkent";
$lang['tz']['5.5'] = "(GMT +5:30 hours) Bombay, Calcutta, Madras, New Delhi";
$lang['tz']['6'] = "(GMT +6:00 hours) Almaty, Colombo, Dhaka, Novosibirsk";
$lang['tz']['6.5'] = "(GMT +6:30 hours) Rangoon";
$lang['tz']['7'] = "(GMT +7:00 hours) Bangkok, Hanoi, Jakarta";
$lang['tz']['8'] = "(GMT +8:00 hours) Beijing, Hong Kong, Perth, Singapore, Taipei";
$lang['tz']['9'] = "(GMT +9:00 hours) Osaka, Sapporo, Seoul, Tokyo, Yakutsk";
$lang['tz']['9.5'] = "(GMT +9:30 hours) Adelaide, Darwin";
$lang['tz']['10'] = "(GMT +10:00 hours) Canberra, Guam, Melbourne, Sydney, Vladivostok";
$lang['tz']['11'] = "(GMT +11:00 hours) Magadan, New Caledonia, Solomon Islands";
$lang['tz']['12'] = "(GMT +12:00 hours) Auckland, Wellington, Fiji, Marshall Island";

$lang['datetime']['Sunday'] = "e Diel�";
$lang['datetime']['Monday'] = "e H�n�";
$lang['datetime']['Tuesday'] = "e Mart�";
$lang['datetime']['Wednesday'] = "e M�rkur�";
$lang['datetime']['Thursday'] = "e Enjte";
$lang['datetime']['Friday'] = "e Premte";
$lang['datetime']['Saturday'] = "e Shtun�";
$lang['datetime']['Sun'] = "Sun";
$lang['datetime']['Mon'] = "Mon";
$lang['datetime']['Tue'] = "Tue";
$lang['datetime']['Wed'] = "Wed";
$lang['datetime']['Thu'] = "Thu";
$lang['datetime']['Fri'] = "Fri";
$lang['datetime']['Sat'] = "Sat";
$lang['datetime']['January'] = "Janar";
$lang['datetime']['February'] = "Shkurt";
$lang['datetime']['March'] = "Mars";
$lang['datetime']['April'] = "Prill";
$lang['datetime']['May'] = "Maj";
$lang['datetime']['June'] = "Qershor";
$lang['datetime']['July'] = "Korrik";
$lang['datetime']['August'] = "Gusht";
$lang['datetime']['September'] = "Shtator";
$lang['datetime']['October'] = "Tetor";
$lang['datetime']['November'] = "N�ntor";
$lang['datetime']['December'] = "Dhjetor";
$lang['datetime']['Jan'] = "Jan";
$lang['datetime']['Feb'] = "Feb";
$lang['datetime']['Mar'] = "Mar";
$lang['datetime']['Apr'] = "Apr";
$lang['datetime']['May'] = "May";
$lang['datetime']['Jun'] = "Jun";
$lang['datetime']['Jul'] = "Jul";
$lang['datetime']['Aug'] = "Aug";
$lang['datetime']['Sep'] = "Sep";
$lang['datetime']['Oct'] = "Oct";
$lang['datetime']['Nov'] = "Nov";
$lang['datetime']['Dec'] = "Dec";

//
// Errors (not related to a
// specific failure on a page)
//
$lang['Information'] = "Informacion";
$lang['Critical_Information'] = "Informacion kritik ";

$lang['General_Error'] = "Problem i p�rgjithsh�m";
$lang['Critical_Error'] = "Problem kritik";
$lang['An_error_occured'] = "Pati nj� problem";
$lang['A_critical_error'] = "Pati nj� problem kritik";

//
// That's all Folks!
// -------------------------------------------------

?>