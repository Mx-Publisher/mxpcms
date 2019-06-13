<?php
/***************************************************************************
 *                            lang_main.php [Swedish]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group and (C) 2003 Jonathan Gulbrandsen
 *     email                : support@phpbb.com (translator:virtuality@carlssonplanet.com)
 *
 *     $Id: lang_main.php,v 1.3 2013/06/28 15:34:00 orynider Exp $
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

//  *************************************
//  First, original Swedish translation by:
//
//	Marcus Svensson
//      admin@world-of-war.com
//      http://www.world-of-war.com
//	-------------------------------------
// 	Jan�ke R�nnblom
//	jan-ake.ronnblom@skeria.skelleftea.se
//	-------------------------------------
//	Bruce
//	bruce@webway.se
//	-------------------------------------
//      Jakob Persson
//      jakob.persson@iname.com
//      http://www.jakob-persson.com
//
//  *************************************
//  Maintained and kept up-to-date by:
//
//  Jonathan Gulbrandsen (Virtuality)
//  virtuality@carlssonplanet.com
//  http://www.carlssonplanet.com
//  *************************************
//

// CONTRIBUTORS:
//	 Add your details here if wanted, e.g. Name, username, email address, website
// XXXX-XX-XX  Orginal translation to Swedish by Marcus Svensson, Jan�ke R�nnblom, Bruce and Jakob Persson
// 2003-07-31  Virtuality aka Jonathan Gulbrandsen (virtuality@carlssonplanet.com)        - updated to 2.0.5, also fixed loads of grammar problems
// 2003-08-12  Virtuality aka Jonathan Gulbrandsen (virtuality@carlssonplanet.com)        - updated to 2.0.6, from 2.0.5. COMPLETE survey of the file. Loads of stuff fixed.
// 2005-03-01  "_Haplo" Jon Ohlsson (jonohlsson@hotmail.com)        - updated to 2.0.13, from 2.0.6. COMPLETE survey of the file. Loads of stuff fixed.

//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

// Specify your language character encoding... [optional]
//
setlocale(LC_ALL, "sv");

//$lang['ENCODING'] = 'utf-8';
$lang['ENCODING'] = 'iso-8859-1';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'left';
$lang['RIGHT'] = 'right';
$lang['DATE_FORMAT'] = 'd F Y'; // This should be changed to the default date format for your language, php date() format

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
$lang['TRANSLATION_INFO'] = '<a href="http://mxpcms.sourceforge.net/" target="_blank" class="gensmall">Swedish</a> translation by <a href="mailto:jon.ohlsson@mx-publisher.com" title="Jon Ohlsson" class="gensmall">Jon Ohlsson</a> &copy; 2004-2008';

//
// Common, these terms are used
// extensively on several pages
//
$lang['Forum'] = 'Forum';
$lang['Category'] = 'Kategori';
$lang['Topic'] = '�mne';
$lang['Topics'] = '�mnen';
$lang['Replies'] = 'Svar';
$lang['Views'] = 'Visningar';
$lang['Post'] = 'Inl�gg';
$lang['Posts'] = 'Inl�gg';
$lang['Posted'] = 'Skrivet';
$lang['Username'] = 'Anv�ndarnamn';
$lang['Password'] = 'L�senord';
$lang['Email'] = 'E-post';
$lang['Poster'] = 'Avs�ndare';
$lang['Author'] = 'F�rfattare';
$lang['Time'] = 'Tid';
$lang['Hours'] = 'Timmar';
$lang['Message'] = 'Meddelande';

$lang['1_Day'] = '1 Dag';
$lang['7_Days'] = '7 Dagar';
$lang['2_Weeks'] = '2 Veckor';
$lang['1_Month'] = '1 M�nad';
$lang['3_Months'] = '3 M�nader';
$lang['6_Months'] = '6 M�nader';
$lang['1_Year'] = '1 �r';

$lang['Go'] = 'G�';
$lang['Jump_to'] = 'Hoppa till';
$lang['Submit'] = 'Skicka';
$lang['Reset'] = '�terst�ll';
$lang['Cancel'] = 'Avbryt';
$lang['Preview'] = 'F�rhandsgranska';
$lang['Confirm'] = 'Bekr�fta';
$lang['Spellcheck'] = 'Stavningskontroll';
$lang['Yes'] = 'Ja';
$lang['No'] = 'Nej';
$lang['Enabled'] = 'Aktiverad';
$lang['Disabled'] = 'Inaktiverad';
$lang['Error'] = 'Fel';

$lang['Next'] = 'N�sta';
$lang['Previous'] = 'F�reg�ende';
$lang['Goto_page'] = 'G� till sida';
$lang['Joined'] = 'Blev medlem';
$lang['IP_Address'] = 'IP Adress';

$lang['Select_forum'] = 'V�lj forum';
$lang['View_latest_post'] = 'Visa senaste inl�gg';
$lang['View_newest_post'] = 'Visa nyaste inl�gg';
$lang['Page_of'] = 'Sida <b>%d</b> av <b>%d</b>'; // Replaces with: Page 1 of 2 for example

$lang['ICQ'] = 'ICQ-nummer';
$lang['AIM'] = 'AIM-adress';
$lang['MSNM'] = 'MSN Messenger';
$lang['YIM'] = 'Yahoo Messenger';

$lang['Forum_Index'] = 'Forumindex';  // eg. sitename Forum Index, %s can be removed if you prefer

$lang['Post_new_topic'] = 'Skapa nytt inl�gg';
$lang['Reply_to_topic'] = 'Svara p� inl�gget';
$lang['Reply_with_quote'] = 'Citera';

$lang['Click_return_topic'] = 'Klicka %sH�r%s f�r att �terv�nda till �mnet'; // %s's here are for urls, do not remove!
$lang['Click_return_login'] = 'Klicka %sH�r%s f�r att f�rs�ka igen';
$lang['Click_return_forum'] = 'Klicka %sH�r%s f�r att �terv�nda till forumet';
$lang['Click_view_message'] = 'Klicka %sH�r%s f�r att visa ditt meddelande';
$lang['Click_return_modcp'] = 'Klicka %sH�r%s f�r att �terv�nda till Moderatorkontollpanel';
$lang['Click_return_group'] = 'Klicka %sH�r%s f�r att �terv�nda till gruppinformationen';

$lang['Admin_panel'] = 'G&aring; till Administrationspanelen';

$lang['Board_disable'] = 'Det h�r forumet �r tyv�rr otillg�ngligt f�r tillf�llet, var v�nlig f�rs�k senare.';


//
// Global Header strings
//
$lang['Registered_users'] = 'Registrerade anv�ndare:';
$lang['Browsing_forum'] = 'Anv�ndare som �r p� forumet just nu:';
$lang['Online_users_zero_total'] = 'Det �r totalt <b>0</b> anv�ndare online :: ';
$lang['Online_users_total'] = 'Det �r totalt <b>%d</b> anv�ndare online :: ';
$lang['Online_user_total'] = 'Det �r totalt <b>%d</b> anv�ndare online :: ';
$lang['Reg_users_zero_total'] = '0 Registrerade, ';
$lang['Reg_users_total'] = '%d Registrerade, ';
$lang['Reg_user_total'] = '%d Registrerad, ';
$lang['Hidden_users_zero_total'] = '0 Dolda och ';
$lang['Hidden_user_total'] = '%d Dold and ';
$lang['Hidden_users_total'] = '%d Dolda and ';
$lang['Guest_users_zero_total'] = '0 G�ster';
$lang['Guest_users_total'] = '%d G�ster';
$lang['Guest_user_total'] = '%d G�st';
$lang['Record_online_users'] = 'Flest anv�ndare samtidigt var <b>%s</b> den %s'; // first %s = number of users, second %s is the date.

$lang['Admin_online_color'] = '%sAdministrat�r%s';
$lang['Mod_online_color'] = '%sModerator%s';

$lang['You_last_visit'] = 'Du gjorde ditt senaste bes�k den %s'; // %s replaced by date/time
$lang['Current_time'] = 'Lokal tid (f�r forumet) %s'; // %s replaced by time

$lang['Search_new'] = 'Visa nya inl�gg sedan ditt senaste bes�k';
$lang['Search_your_posts'] = 'Visa dina inl�gg';
$lang['Search_unanswered'] = 'Visa obesvarade �mnen';

$lang['Register'] = 'Bli medlem';
$lang['Profile'] = 'Min profil';
$lang['Edit_profile'] = '�ndra dina inst�llningar';
$lang['Search'] = 'S&ouml;k';
$lang['Memberlist'] = 'Medlemmar';
$lang['FAQ'] = 'Vanliga fr�gor';
$lang['BBCode_guide'] = 'BBCode-guide';
$lang['Usergroups'] = 'Anv�ndargrupper';
$lang['Last_Post'] = 'Senaste inl�gg';
$lang['Moderator'] = '<b>Moderator</b>';
$lang['Moderators'] = '<b>Moderatorer</b>';


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = 'V�ra anv�ndare har skrivit totalt <b>0</b> inl�gg'; // Number of posts
$lang['Posted_articles_total'] = 'V�ra anv�ndare har skrivit totalt <b>%d</b> inl�gg'; // Number of posts
$lang['Posted_article_total'] = 'V�ra anv�ndare har skrivit totalt <b>%d</b> inl�gg'; // Number of posts
$lang['Registered_users_zero_total'] = 'Vi har <b>0</b> registrerade anv�ndare'; // # registered users
$lang['Registered_users_total'] = 'Vi har <b>%d</b> registrerade anv�ndare'; // # registered users
$lang['Registered_user_total'] = 'Vi har <b>%d</b> registrerad anv�ndare'; // # registered users
$lang['Newest_user'] = 'Den senast registrerade anv�ndaren �r <b>%s%s%s</b>'; // a href, username, /a

$lang['No_new_posts_last_visit'] = 'Inga nya inl�gg sedan ditt senaste bes�k';
$lang['No_new_posts'] = 'Inga nya inl�gg';
$lang['New_posts'] = 'Nya inl�gg';
$lang['New_post'] = 'Nya inl�gg';
$lang['No_new_posts_hot'] = 'Inga nya inl�gg [ Popul�r ]';
$lang['New_posts_hot'] = 'Nya inl�gg [ Popul�r ]';
$lang['No_new_posts_locked'] = 'Inga nya inl�gg [ L�st ]';
$lang['New_posts_locked'] = 'Nya inl�gg [ L�st ]';
$lang['Forum_is_locked'] = 'Forumet �r l�st';


//
// Login
//
$lang['Enter_password'] = 'Skriv in ditt anv�ndarnamn och l�senord f�r att logga in';
$lang['Login'] = 'Logga in';
$lang['Logout'] = 'Logga ut';

$lang['Forgotten_password'] = 'Jag har gl�mt mitt l�senord';

$lang['Log_me_in'] = 'Logga in mig automatiskt';

$lang['Error_login'] = 'Du har skrivit in antingen ett felaktigt eller inaktivt anv�ndarnamn eller ett felaktigt l�senord';


//
// Index page
//
$lang['Index'] = 'Index';
$lang['No_Posts'] = 'Inga inl�gg';
$lang['No_forums'] = 'Inga forum �r skapade �n';

$lang['Private_Message'] = 'Meddelande';
$lang['Private_Messages'] = 'Mina mess';
$lang['Who_is_Online'] = 'Vem �r Online';

$lang['Mark_all_forums'] = 'Markera alla forum som l�sta';
$lang['Forums_marked_read'] = 'Alla forum har nu markerats som l�sta';


//
// Viewforum
//
$lang['View_forum'] = 'Visa forum';

$lang['Forum_not_exist'] = 'Det forum som du valt finns inte';
$lang['Reached_on_error'] = 'Du har n�tt den h�r sidan p� fel s�tt';

$lang['Display_topics'] = 'Visa tidigare �mnen';
$lang['All_Topics'] = 'Alla �mnen';

$lang['Topic_Announcement'] = '<b>Viktigt meddelande:</b>';
$lang['Topic_Sticky'] = '<b>Klistrad:</b>';
$lang['Topic_Moved'] = '<b>Flyttad:</b>';
$lang['Topic_Poll'] = '<b>[ Omr�stning ]</b>';

$lang['Mark_all_topics'] = 'Markera alla �mnen som l�sta';
$lang['Topics_marked_read'] = 'Alla �mnen i det h�r forumet har markerats som l�sta';

$lang['Rules_post_can'] = 'Du <b>kan</b> skapa nya inl�gg i det h�r forumet';
$lang['Rules_post_cannot'] = 'Du <b>kan inte</b> skapa nya inl�gg i det h�r forumet';
$lang['Rules_reply_can'] = 'Du <b>kan</b> svara p� inl�gg i det h�r forumet';
$lang['Rules_reply_cannot'] = 'Du <b>kan inte</b> svara p� inl�gg i det h�r forumet';
$lang['Rules_edit_can'] = 'Du <b>kan</b> �ndra dina inl�gg i det h�r forumet';
$lang['Rules_edit_cannot'] = 'Du <b>kan inte</b> �ndra dina inl�gg i det h�r forumet';
$lang['Rules_delete_can'] = 'Du <b>kan</b> ta bort dina inl�gg i det h�r forumet';
$lang['Rules_delete_cannot'] = 'Du <b>kan inte</b> ta bort dina inl�gg i det h�r forumet';
$lang['Rules_vote_can'] = 'Du <b>kan</b> r�sta i det h�r forumet';
$lang['Rules_vote_cannot'] = 'Du <b>kan inte</b> r�sta i det h�r forumet';
$lang['Rules_moderate'] = 'Du <b>�r</b> %smoderator i det h�r forumet%s'; // %s replaced by a href links, do not remove!

$lang['No_topics_post_one'] = 'Det finns inga �mnen i det h�r forumet<br />Klicka p� <b>Skapa Nytt �mne</b>-l�nken p� denna sidan f�r att skapa ett.';


//
// Viewtopic
//
$lang['View_topic'] = 'Visa �mne';

$lang['Guest'] = 'G�st';
$lang['Post_subject'] = 'Rubrik';
$lang['View_next_topic'] = 'Visa n�sta �mne';
$lang['View_previous_topic'] = 'Visa f�reg�ende �mne';
$lang['Submit_vote'] = 'Skicka in r�st';
$lang['View_results'] = 'Visa resultat';

$lang['No_newer_topics'] = 'Det finns inga nyare �mnen i det h�r forumet';
$lang['No_older_topics'] = 'Det finns inga �ldre �mnen i det h�r forumet';
$lang['Topic_post_not_exist'] = 'Det s�kta inl�gget existerar inte';
$lang['No_posts_topic'] = 'Det finns inga svar till det h�r �mnet';

$lang['Display_posts'] = 'Visa tidigare inl�gg';
$lang['All_Posts'] = 'Alla inl�gg';
$lang['Newest_First'] = 'Nyaste f�rst';
$lang['Oldest_First'] = '�ldsta f�rst';

$lang['Back_to_top'] = 'Till �verst p� sidan';

$lang['Read_profile'] = 'Visa anv�ndarens profil';
$lang['Send_email'] = 'Skicka e-post';
$lang['Visit_website'] = 'Bes�k anv�ndarens hemsida';
$lang['ICQ_status'] = 'ICQ Status';
$lang['Edit_delete_post'] = '�ndra/Ta bort det h�r inl�gget';
$lang['View_IP'] = 'Visa f�rfattarens IP';
$lang['Delete_post'] = 'Ta bort det h�r inl�gget';

$lang['wrote'] = 'skrev'; // proceeds the username and is followed by the quoted text
$lang['Quote'] = 'Citat'; // comes before bbcode quote output.
$lang['Code'] = 'Kod'; // comes before bbcode code output.

$lang['Edited_time_total'] = 'Senast �ndrad av %s den %s, �ndrad totalt %d g�ng'; // Last edited by me on 12 Oct 2001; edited 1 time in total
$lang['Edited_times_total'] = 'Senast �ndrad av %s den %s, �ndrad totalt %d g�nger'; // Last edited by me on 12 Oct 2001; edited 2 times in total

$lang['Lock_topic'] = 'L�s det h�r �mnet';
$lang['Unlock_topic'] = 'L�s upp det h�r �mnet';
$lang['Move_topic'] = 'Flytta det h�r �mnet';
$lang['Delete_topic'] = 'Ta bort det h�r �mnet';
$lang['Split_topic'] = 'Dela det h�r �mnet';

$lang['Stop_watching_topic'] = 'Sluta bevaka det h�r �mnet';
$lang['Start_watching_topic'] = 'Bevaka det h�r �mnet f�r svar';
$lang['No_longer_watching'] = 'Du bevakar inte l�ngre det h�r �mnet';
$lang['You_are_watching'] = 'Du bevakar nu det h�r �mnet';

$lang['Total_votes'] = 'Totalt antal r�ster';

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = 'Meddelande';
$lang['Topic_review'] = '�mneshistorik';

$lang['No_post_mode'] = 'Inget postningsval specificerat'; // If posting.php is called without a mode (newtopic/reply/delete/etc, shouldn't be shown normaly)

$lang['Post_a_new_topic'] = 'Skapa nytt �mne';
$lang['Post_a_reply'] = 'Svara p� �mne';
$lang['Post_topic_as'] = 'Skapa �mne som';
$lang['Edit_Post'] = '�ndra inl�gg';
$lang['Options'] = 'Alternativ';

$lang['Post_Announcement'] = 'Viktigt meddelande';
$lang['Post_Sticky'] = 'Klistrad';
$lang['Post_Normal'] = 'Normal';

$lang['Confirm_delete'] = '�r du s�ker p� att du vill ta bort det h�r inl�gget?';
$lang['Confirm_delete_poll'] = '�r du s�ker p� att du vill ta bort den h�r omr�stnignen?';

$lang['Flood_Error'] = 'Du m�ste v�nta lite innan du kan posta ett nytt inl�gg.';
$lang['Empty_subject'] = 'Du m�ste skriva en rubrik om du skapar ett nytt inl�gg.';
$lang['Empty_message'] = 'Du m�ste skriva ett meddelande n�r du postar.';
$lang['Forum_locked'] = 'Det h�r forumet �r l�st s� du kan varken skapa, svara p� eller �ndra inl�gg.';
$lang['Topic_locked'] = 'Det h�r �mnet �r l�st s� du kan varken svara p� eller �ndra det.';
$lang['No_post_id'] = 'Inget inl�ggs ID specificerat';
$lang['No_topic_id'] = 'Du m�ste v�lja ett inl�gg att svara p�';
$lang['No_valid_mode'] = 'Du kan bara skapa, svara p� eller �ndra inl�gg, g� tillbaka och f�rs�k igen.';
$lang['No_such_post'] = 'Inl�gget du letade efter finns inte, g� tillbaka och f�rs�k igen.';
$lang['Edit_own_posts'] = 'Du kan bara �ndra dina egna inl�gg.';
$lang['Delete_own_posts'] = 'Du kan bara ta bort dina egna inl�gg.';
$lang['Cannot_delete_replied'] = 'Du inte ta bort inl�gg som svarats p�.';
$lang['Cannot_delete_poll'] = 'Du kan tyv�rr inte ta bort en aktiv omr�stning.';
$lang['Empty_poll_title'] = 'Du m�ste skriva in ett namn p� omr�stningen.';
$lang['To_few_poll_options'] = 'Du m�ste l�gga till minst 2 val i omr�stningen.';
$lang['To_many_poll_options'] = 'Du f�rs�kte l�gga till f�r m�nga val i omr�stningen.';
$lang['Post_has_no_poll'] = 'Detta inl�gge har ingen omr�stning.';
$lang['Already_voted'] = 'Du har redan deltagit i den h�r omr�stningen.';
$lang['No_vote_option'] = 'Du m�ste markera ett alternativ n�r du r�star.';

$lang['Add_poll'] = 'L�gg till omr�stning';
$lang['Add_poll_explain'] = 'Om du inte vill l�gga till n�gon omr�stning till ditt inl�gg, l�mna f�lten tomma.';
$lang['Poll_question'] = 'Omr�stningsfr�ga';
$lang['Poll_option'] = 'Svarsalternativ';
$lang['Add_option'] = 'L�gg till svarsalternativ';
$lang['Update'] = 'Uppdatera';
$lang['Delete'] = 'Ta bort';
$lang['Poll_for'] = 'Antal dagar omr�stningen l�per';
$lang['Days'] = 'Dagar'; // This is used for the Run poll for ... Days + in admin_forums for pruning
$lang['Poll_for_explain'] = '[ Ange 0 f�r att skapa en omr�stning som aldrig slutar ]';
$lang['Delete_poll'] = 'Ta bort omr�stning';

$lang['Disable_HTML_post'] = 'Inaktivera HTML i det h�r inl�gget';
$lang['Disable_BBCode_post'] = 'Inaktivera BBCode i det h�r inl�gget';
$lang['Disable_Smilies_post'] = 'Inaktivera Smilies i det h�r inl�gget';

$lang['HTML_is_ON'] = 'HTML �r <u>P�</u>';
$lang['HTML_is_OFF'] = 'HTML �r <u>AV</u>';
$lang['BBCode_is_ON'] = '%sBBCode%s �r <u>P�</u>'; // %s are replaced with URI pointing to FAQ
$lang['BBCode_is_OFF'] = '%sBBCode%s �r <u>AV</u>';
$lang['Smilies_are_ON'] = 'Smilies �r <u>P�</u>';
$lang['Smilies_are_OFF'] = 'Smilies �r <u>AV</u>';

$lang['Attach_signature'] = 'L�gg till signatur (signaturen kan �ndras i profilen)';
$lang['Notify'] = 'Kontakta mig vid svar';
$lang['Delete_post'] = 'Ta bort det h�r inl�gget';

$lang['Stored'] = 'Ditt meddelande har sparats.';
$lang['Deleted'] = 'Ditt meddelande har tagits bort.';
$lang['Poll_delete'] = 'Din omr�stning har tagits bort.';
$lang['Vote_cast'] = 'Din r�st har r�knats.';

$lang['Topic_reply_notification'] = 'Meddelande om svar p� inl�gg';

$lang['bbcode_b_help'] = 'Fetstilad text: [b]text[/b]  (alt+b)';
$lang['bbcode_i_help'] = 'Kursiv text: [i]text[/i]  (alt+i)';
$lang['bbcode_u_help'] = 'Understruken text: [u]text[/u]  (alt+u)';
$lang['bbcode_q_help'] = 'Citerad text: [quote]text[/quote]  (alt+q)';
$lang['bbcode_c_help'] = 'Visning av kod: [code]kod[/code]  (alt+c)';
$lang['bbcode_l_help'] = 'Lista: [list]text[/list] (alt+l)';
$lang['bbcode_o_help'] = 'Ordnad lista: [list=]text[/list]  (alt+o)';
$lang['bbcode_p_help'] = 'L�gg till bild: [img]http://image_url[/img]  (alt+p)';
$lang['bbcode_w_help'] = 'L�gg till l�nk: [url]http://url[/url] eller [url=http://url]URL text[/url]  (alt+w)';
$lang['bbcode_a_help'] = 'St�ng alla �ppna bbCode taggar';
$lang['bbcode_s_help'] = 'Teckenf�rg: [color=red]text[/color]  Tips: du kan �ven anv�nda color=#FF0000';
$lang['bbcode_f_help'] = 'Teckenstorlek: [size=x-small]liten text[/size]';

$lang['Emoticons'] = 'Smilies';
$lang['More_emoticons'] = 'Visa fler Smilies';

$lang['Font_color'] = 'Teckenf�rg';
$lang['color_default'] = 'Standard';
$lang['color_dark_red'] = 'M�rkr�d';
$lang['color_red'] = 'R�d';
$lang['color_orange'] = 'Orange';
$lang['color_brown'] = 'Brun';
$lang['color_yellow'] = 'Gul';
$lang['color_green'] = 'Gr�n';
$lang['color_olive'] = 'Oliv';
$lang['color_cyan'] = 'Cyan';
$lang['color_blue'] = 'Bl�';
$lang['color_dark_blue'] = 'M�rkbl�';
$lang['color_indigo'] = 'Lila';
$lang['color_violet'] = 'Rosa';
$lang['color_white'] = 'Vit';
$lang['color_black'] = 'Svart';

$lang['Font_size'] = 'Teckenstorlek';
$lang['font_tiny'] = 'Pytteliten';
$lang['font_small'] = 'Liten';
$lang['font_normal'] = 'Normal';
$lang['font_large'] = 'Stor';
$lang['font_huge'] = 'Enorm';

$lang['Close_Tags'] = 'St�ng taggar';
$lang['Styles_tip'] = 'Tips: Stilar kan snabbt anv�ndas p� markerad text';


//
// Private Messaging
//
$lang['Private_Messaging'] = 'Personliga Meddelanden';

$lang['Login_check_pm'] = 'Logga in f�r att l�sa dina meddelanden';
$lang['New_pms'] = 'Du har %d nya meddelanden'; // You have 2 new messages
$lang['New_pm'] = 'Du har %d nytt meddelande'; // You have 1 new message
$lang['No_new_pm'] = 'Du har inga nya meddelanden';
$lang['Unread_pms'] = 'Du har %d ol�sta meddelanden';
$lang['Unread_pm'] = 'Du har %d ol�st meddelande';
$lang['No_unread_pm'] = 'Du har inga ol�sta meddelanden';
$lang['You_new_pm'] = 'Ett nytt meddelande v�ntar p� dig i din Inkorg';
$lang['You_new_pms'] = 'Nya meddelanden v�ntar p� dig i din Inkorg';
$lang['You_no_new_pm'] = 'Inga nya meddelanden v�ntar p� dig';

$lang['Unread_message'] = 'Ol�st meddelande';
$lang['Read_message'] = 'L�st meddelande';

$lang['Read_pm'] = 'L�s meddelande';
$lang['Post_new_pm'] = 'Skicka meddelande';
$lang['Post_reply_pm'] = 'Svara p� meddelande';
$lang['Post_quote_pm'] = 'Citera meddelande';
$lang['Edit_pm'] = '�ndra meddelande';

$lang['Inbox'] = 'Inkorg';
$lang['Outbox'] = 'Utkorg';
$lang['Savebox'] = 'Sparat';
$lang['Sentbox'] = 'Skickat';
$lang['Flag'] = 'Flagga';
$lang['Subject'] = 'Rubrik';
$lang['From'] = 'Fr�n';
$lang['To'] = 'Till';
$lang['Date'] = 'Datum';
$lang['Mark'] = 'Markera';
$lang['Sent'] = 'Skickad';
$lang['Saved'] = 'Sparat';
$lang['Delete_marked'] = 'Ta bort markerade';
$lang['Delete_all'] = 'Ta bort alla';
$lang['Save_marked'] = 'Spara markerade';
$lang['Save_message'] = 'Spara meddelande';
$lang['Delete_message'] = 'Ta bort meddelande';

$lang['Display_messages'] = 'Visa tidigare meddelanden'; // Followed by number of days/weeks/months
$lang['All_Messages'] = 'Alla meddelanden';

$lang['No_messages_folder'] = 'Du har inga meddelanden i denna mappen';

$lang['PM_disabled'] = 'Personliga meddelanden har inaktiverats p� detta forum.';
$lang['Cannot_send_privmsg'] = 'Administrat�ren har tyv�rr hindrat dig fr�n att skicka personliga meddelanden';
$lang['No_to_user'] = 'Du m�ste skriva in ett anv�ndarnamn att skicka meddelandet till.';
$lang['No_such_user'] = 'Anv�ndaren finns inte, var god f�rs�k igen.';

$lang['Disable_HTML_pm'] = 'Inaktivera HTML i det h�r meddelandet';
$lang['Disable_BBCode_pm'] = 'Inaktivera BBCode i det h�r meddelandet';
$lang['Disable_Smilies_pm'] = 'Inaktivera Smilies i detta meddelande';

$lang['Message_sent'] = 'Ditt meddelande har skickats.';

$lang['Click_return_inbox'] = 'Klicka %sH�r%s f�r att �terg� till din Inkorg';
$lang['Click_return_index'] = 'Klicka %sH�r%s f�r att �terg� till index';

$lang['Send_a_new_message'] = 'Skicka ett nytt personligt meddelande';
$lang['Send_a_reply'] = 'Svara p� ett personligt meddelande';
$lang['Edit_message'] = '�ndra ett personligt meddelande';

$lang['Notification_subject'] = 'Du har f�tt ett Personligt Meddelande!';

$lang['Find_username'] = 'S�k efter anv�ndarnamn';
$lang['Find'] = 'S�k';
$lang['No_match'] = 'Inga matchande tr�ffar hittades.';

$lang['No_post_id'] = 'Inget inl�ggs ID specificerat';
$lang['No_such_folder'] = 'Den mappen finns inte';
$lang['No_folder'] = 'Ingen mapp specificerad';

$lang['Mark_all'] = 'Markera alla';
$lang['Unmark_all'] = 'Avmarkera alla';

$lang['Confirm_delete_pm'] = '�r du s�ker p� att du vill ta bort det h�r meddelandet?';
$lang['Confirm_delete_pms'] = '�r du s�ker p� att du vill ta bort de h�r meddelandena?';

$lang['Inbox_size'] = 'Din Inkorg �r %d%% full'; // eg. Your Inbox is 50% full
$lang['Sentbox_size'] = 'Din Utkorg �r %d%% full';
$lang['Savebox_size'] = 'Din Sparat mapp �r %d%% full';

$lang['Click_view_privmsg'] = 'Klicka %sH�r%s f�r att g� till din Inkorg';


//
// Profiles/Registration
//
$lang['Viewing_user_profile'] = 'Visar Profil :: %s'; // %s is username
$lang['About_user'] = 'Allt om %s'; // %s is username

$lang['Preferences'] = 'Inst�llningar';
$lang['Items_required'] = 'Allt som �r markerat med * m�ste fyllas i om inte annat angivs';
$lang['Registration_info'] = 'Registreringsinformation';
$lang['Profile_info'] = 'Profilinformation';
$lang['Profile_info_warn'] = 'F�ljande information kommer vara synlig f�r andra';
$lang['Avatar_panel'] = 'Avatarkontrollpanel';
$lang['Avatar_gallery'] = 'Avatargalleri';

$lang['Website'] = 'Hemsida';
$lang['Location'] = 'Fr�n';
$lang['Contact'] = 'Kontakt';
$lang['Email_address'] = 'E-post adress';
$lang['Email'] = 'E-post';
$lang['Send_private_message'] = 'Skicka personligt meddelande';
$lang['Hidden_email'] = '[ Dold ]';
$lang['Search_user_posts'] = 'Hitta alla inl�gg av %s';
$lang['Interests'] = 'Intressen';
$lang['Occupation'] = 'Yrke/syssels�ttning';
$lang['Poster_rank'] = 'Rank';

$lang['Total_posts'] = 'Totalt antal inl�gg';
$lang['User_post_pct_stats'] = '%.2f%% av totala'; // 1.25% of total
$lang['User_post_day_stats'] = '%.2f inl�gg per dag'; // 1.5 posts per day
$lang['Search_user_posts'] = 'Hitta alla inl�gg av %s'; // Find all posts by username

$lang['No_user_id_specified'] = 'Den anv�ndaren finns tyv�rr inte.';
$lang['Wrong_Profile'] = 'Du kan inte �ndra en profil som inte �r din egen.';

$lang['Only_one_avatar'] = 'Endast en typ av avatar kan v�ljas';
$lang['File_no_data'] = 'Filen p� adressen du angav inneh�ll ingen data';
$lang['No_connection_URL'] = 'En anslutning kunde ej g�ras till adressen du angav';
$lang['Incomplete_URL'] = 'Adressen du angav �r inte komplett';
$lang['Wrong_remote_avatar_format'] = 'Adressen till avataren du angav �r inte giltig';
$lang['No_send_account_inactive'] = 'Tyv�rr kan inte ditt l�senord skickas eftersom ditt konto �r inaktivt. Kontakta forumadministrat�ren f�r mer information.';

$lang['Always_smile'] = 'Aktivera alltid Smilies';
$lang['Always_html'] = 'Till�t alltid HTML';
$lang['Always_bbcode'] = 'Till�t alltid BBCode';
$lang['Always_add_sig'] = 'Inkludera alltid min signatur';
$lang['Always_notify'] = 'Kontakta alltid mig vid svar';
$lang['Always_notify_explain'] = 'Skickar ett e-post meddelande till dig n�r n�gon svarar p� ett �mne d�r du har skrivit/svarat. Det h�r kan �ndras n�r du skapar ett inl�gg.';

$lang['Board_style'] = 'Forumstil';
$lang['Board_lang'] = 'Forumspr�k';
$lang['No_themes'] = 'Inga teman i databasen';
$lang['Timezone'] = 'Tidszon';
$lang['Date_format'] = 'Datumformat';
$lang['Date_format_explain'] = 'Det h�r syntaxet �r identiskt med PHP <a href=\\"http://www.php.net/date\\" target=\\"_other\\">date()</a> funktionen';
$lang['Signature'] = 'Signatur';
$lang['Signature_explain'] = 'Det h�r �r ett stycke text som kan l�ggas till i inl�gg du skapar. Det finns en gr�ns p� %d tecken';
$lang['Public_view_email'] = 'Visa alltid min e-post adress';

$lang['Current_password'] = 'Nuvarande l�senord';
$lang['New_password'] = 'Nytt l�senord';
$lang['Confirm_password'] = 'Bekr�fta nytt l�senord';
$lang['Confirm_password_explain'] = 'Du m�ste ange ditt nuvarande l�senord om du vill �ndra l�senord eller e-post adress';
$lang['password_if_changed'] = 'Du beh�ver bara fylla i ett l�senord om du skall �ndra det';
$lang['password_confirm_if_changed'] = 'Du beh�ver bara bekr�fta ditt l�senord om du skall �ndra det';

$lang['Avatar'] = 'Avatar';
$lang['Avatar_explain'] = 'Visar en liten bild precis under dina detaljer i dina inl�gg. Endast en bild kan visas �t g�ngen, bredden f�r inte vara st�rre �n %d pixlar, h�jden f�r inte vara st�rre �n %d pixlar och filstoleken f�r inte vara st�rre �n %d KB.';
$lang['Upload_Avatar_file'] = 'Ladda upp en avatar fr�n din dator';
$lang['Upload_Avatar_URL'] = 'Ladda upp en avatar fr�n en webbadress';
$lang['Upload_Avatar_URL_explain'] = 'Skriv in webbadressen d�r avatarbilden finns, den kommer att kopieras till det h�r forumet.';
$lang['Pick_local_Avatar'] = 'V�lj en avatar fr�n galleriet';
$lang['Link_remote_Avatar'] = 'L�nka till en avatar p� en annan sida';
$lang['Link_remote_Avatar_explain'] = 'Skriv in webbadressen d�r avatarbilden som du vill l�nka till finns';
$lang['Avatar_URL'] = 'Adress till avatarbild';
$lang['Select_from_gallery'] = 'V�lj en avatar fr�n galleriet';
$lang['View_avatar_gallery'] = 'Visa galleriet';

$lang['Select_avatar'] = 'V�lj avatar';
$lang['Return_profile'] = 'Avbryt';
$lang['Select_category'] = 'V�lj kategori';

$lang['Delete_Image'] = 'Ta bort bild';
$lang['Current_Image'] = 'Nuvarande bild';

$lang['Notify_on_privmsg'] = 'Kontakta mig vid nytt Personligt Meddelande';
$lang['Popup_on_privmsg'] = 'Poppa upp f�nster vid nytt Personligt Meddelande';
$lang['Popup_on_privmsg_explain'] = 'Vissa forumstilar kan poppa upp ett f�nster som meddelar dig om att du f�tt ett nytt Personligt Meddelande.';
$lang['Hide_user'] = 'Visa inte om jag �r online';

$lang['Profile_updated'] = 'Din profil har blivit uppdaterad';
$lang['Profile_updated_inactive'] = 'Din profil har uppdaterats, men eftersom att du �ndrade viktiga detaljer har ditt konto nu inaktiverats. Kontollera din e-post f�r att f� reda p� hur du skall g� till v�ga f�r att aktivera ditt konto igen. Eller om adminaktivering �r n�dv�ndig, var god v�nta tills administrat�ren aktiverat ditt konto igen.';

$lang['Password_mismatch'] = 'L�senorden du skrev in matchade inte.';
$lang['Current_password_mismatch'] = 'Ditt nuvarande l�senord matchade inte med vad du skrev in.';
$lang['Password_long'] = 'Ditt l�senord f�r inte vara l�ngre �n 32 tecken.';
$lang['Too_many_registers'] = 'Du har �verskridit antalet till�tna registreringsf�rs�k f�r denna session. F�rs�k igen senare.';
$lang['Username_taken'] = 'Tyv�rr var det h�r anv�ndarnamnet redan upptaget.';
$lang['Username_invalid'] = 'Ditt anv�ndarnamn inneh�ll ett ogiltigt tecken som t.ex. \"';
$lang['Username_disallowed'] = 'Tyv�rr �r inte det h�r anv�ndarnamnet till�tet.';
$lang['Email_taken'] = 'Den e-post adressen �r redan registrerad hos oss.';
$lang['Email_banned'] = 'Tyv�rr �r den e-post adressen avst�ngd (bannad).';
$lang['Email_invalid'] = 'E-post adressen �r felaktig.';
$lang['Signature_too_long'] = 'Din signatur �r f�r l�ng.';
$lang['Fields_empty'] = 'Du m�ste fylla i alla f�lt som �r markerade med *.';
$lang['Avatar_filetype'] = 'Avatar filtypen p�ste vara .jpg, .gif eller .png';
$lang['Avatar_filesize'] = 'Avatar filstorleken m�ste vara mindre �n %d kB'; // The avatar image file size must be less than 6 KB
$lang['Avatar_imagesize'] = 'Avataren m�ste vara mindre �n %d pixlar bred och %d pixlar h�g';

$lang['Welcome_subject'] = 'V�lkommen till %s Forum'; // Welcome to my.com forums
$lang['New_account_subject'] = 'Nytt anv�ndarkonto';
$lang['Account_activated_subject'] = 'Konto aktiverat';

$lang['Account_added'] = 'Tack f�r att du registrerade dig, ditt konto har nu blivit skapat. Du kan nu logga in med ditt anv�ndarnamn och l�senord';
$lang['Account_inactive'] = 'Ditt konto har skapats. Men, det h�r forumet kr�ver kontoaktivering, en aktiveringskod har skickats till e-post adressen du angav. Var god kontrollera din e-post f�r mer information';
$lang['Account_inactive_admin'] = 'Ditt konto har skapats. Men, det h�r forumet kr�ver kontoaktivering av administrat�ren. Ett e-postmeddelande har skickats till dem och du kommer att bli informerad om n�r ditt konto blivit aktiverat';
$lang['Account_active'] = 'Ditt konto har nu aktiverats. Tack f�r att du registrerade dig';
$lang['Account_active_admin'] = 'Kontot har nu aktiverats';
$lang['Reactivate'] = '�teraktivera ditt konto!';
$lang['Already_activated'] = 'Du har redan aktiverat ditt konto!';
$lang['COPPA'] = 'Ditt konto har skapats men m�ste bli godk�nt, kontrollera din e-post f�r mer information.';

$lang['Registration'] = 'Registreringsavtal';
$lang['Reg_agreement'] = 'Fast�n administrat�rer och moderatorer p� det h�r forumet f�rs�ker att ta bort eller �ndra allt st�rande eller st�tande material s� fort som m�jligt, �r det om�jligt att g� igenom alla meddelanden. Vi vill d�rf�r meddela dig om att alla inl�gg som skrivits p� de h�r forumet uttrycker vad f�rfattaren t�nker och tycker, och administrat�rer eller moderatorer skall inte st� till ansvar f�r det (f�rrutom d� f�r de meddelanden som de sj�lva skrivit).<br /><br /> Du g�r med p� att inte posta n�got st�rande, st�tande, vulg�rt, hatiskt, hotande, sexuellt anspelande eller n�got annat material som kan t�nkas bryta mot n�gon till�mplig lag. Om du bryter mot det h�r kan det leda till att du blir permanent avst�ngd fr�n forumen (och din Internet Leverant�r blir kontaktad). Ip adressen av alla meddelanden sparas f�r att st�rka de h�r vilkoren. Du g�r med p� att webmaster, administrat�r och moderatorer har r�tt att ta bort, �ndra, flytta eller st�nga vilka inl�gg som helst n�r som helst. Som en anv�ndare g�r du med p� att all information som du skrivit in sparas i databasen. Den informationen kommer inte att distruberas till n�gon tredje part utan ditt samtycke. Webmastern, administrat�ren eller moderatorer kan inte h�llas ansvariga vid hackningsf�rs�k som kan leda till att data stj�ls. <br /><br />Det h�r forums systemet anv�nder cookies till att spara information p� din dator. De h�r cookiesen inneh�ller inte n�got av den information du skrivit in ovan, utan de anv�nds endast f�r att g�ra ditt anv�nda av forumet b�ttre. Email adressen �r anv�nd bara f�r att aktivera din registrering (och f�r att skicka nytt l�senord till dig om du r�kar gl�mma det).<br /><br /> Genom att klicka p� Registrera nedan g�r du med p� att bindas till de h�r vilkoren.';

$lang['Agree_under_13'] = 'Jag accepterar villkoren och �r <b>under</b> 13 �r';
$lang['Agree_over_13'] = 'Jag accepterar villkoren och �r <b>�ver</b> eller <b>exakt</b> 13 �r';
$lang['Agree_not'] = 'Jag g�r inte med p� de h�r vilkoren';

$lang['Wrong_activation'] = 'Aktiveringskoden du angav matchar inte med den i databasen';
$lang['Send_password'] = 'Skicka ett nytt l�senord till mig';
$lang['Password_updated'] = 'Ett nytt l�senord har skapats, kontrollera din e-post f�r mer information om hur du skall aktivera det';
$lang['No_email_match'] = 'E-post adressen som du angav matchar inte med den som �r listad med det anv�ndarnamnet';
$lang['New_password_activation'] = 'Ny l�senordsaktivering';
$lang['Password_activated'] = 'Ditt konto har �teraktiverats. F�r att logga in anv�nd l�senordet som du hittar i emailet du fick';

$lang['Send_email_msg'] = 'Skicka ett e-postmeddelande';
$lang['No_user_specified'] = 'Ingen anv�ndare specificerad';
$lang['User_prevent_email'] = 'Den h�r anv�ndaren vill inte ta emot e-post. F�rs�k att skicka ett Personligt Meddelande ist�llet';
$lang['User_not_exist'] = 'Den anv�ndaren finns inte';
$lang['CC_email'] = 'Skicka en kopia av det h�r meddelandet till dig sj�lv';
$lang['Email_message_desc'] = 'Det h�r meddelandet kommer att skickas som oformaterad text, inkludera inte n�gon HTML eller BBCode. Svarsadressen f�r det h�r meddelandet kommer att vara din e-post adress.';
$lang['Flood_email_limit'] = 'Du kan inte skicka ett till email just nu, f�rs�k igen senare.';
$lang['Recipient'] = 'Mottagare';
$lang['Email_sent'] = 'E-postmeddelandet har skickats.';
$lang['Send_email'] = 'Skicka e-post';
$lang['Empty_subject_email'] = 'Du m�ste skriva in en rubrik p� e-postmeddelandet.';
$lang['Empty_message_email'] = 'Du m�ste skriva in ett meddelande som skall skickas.';


//
// Visual confirmation system strings
//
$lang['Confirm_code_wrong'] = 'Bekr�ftelsekoden du angav var felaktig.';
$lang['Too_many_registers'] = 'Du har �verskridit antalet till�tna registreringsf�rs�k f�r denna session. F�rs�k igen senare.';
$lang['Confirm_code_impaired'] = 'Om du har d�lig syn eller p� annat s�tt inte kan l�sa denna kod, var god kontakta %sAdministrat�ren%s f�r hj�lp.';
$lang['Confirm_code'] = 'Bekr�ftelsekod';
$lang['Confirm_code_explain'] = 'Ange koden exakt s� som du ser den. Koden �r k�nslig f�r stora/sm� bokst�ver och noll har ett diagonalt streck genom sig.';



//
// Memberslist
//
$lang['Select_sort_method'] = 'V�lj sorteringss�tt';
$lang['Sort'] = 'Sortera';
$lang['Sort_Top_Ten'] = 'Top Tio F�rfattare';
$lang['Sort_Joined'] = 'Blev medlem';
$lang['Sort_Username'] = 'Anv�ndarnamn';
$lang['Sort_Location'] = 'Fr�n';
$lang['Sort_Posts'] = 'Antal inl�gg';
$lang['Sort_Email'] = 'E-post';
$lang['Sort_Website'] = 'Hemsida';
$lang['Sort_Ascending'] = 'Stigande ordning';
$lang['Sort_Descending'] = 'Fallande ordning';
$lang['Order'] = 'Ordning';

//
// Search
//
$lang['Search_query'] = 'S�kfr�ga';
$lang['Search_options'] = 'S�kalternativ';

$lang['Search_keywords'] = 'S�k efter nyckelord';
$lang['Search_keywords_explain'] = 'Du kan anv�nda <u>AND</u> f�r att best�mma vilka ord som m�ste finnas i s�kresultatet, <u>OR</u> f�r att best�mma vilka ord som kan finnas i s�kresultatet och <u>NOT</u> f�r att best�mma ord som inte f�r finnas i s�kresultatet. Anv�nd * som "wildcard" (vad som helst) f�r ofullst�ndiga ord.';
$lang['Search_author'] = 'S�k efter f�rfattare';
$lang['Search_author_explain'] = 'Anv�nd * som "wildcard" (vad som helst) f�r ofullst�ndiga ord.';

$lang['Search_for_any'] = 'S�k efter alla termer eller anv�nd den specificerade fr�gan';
$lang['Search_for_all'] = 'S�k efter alla termer';
$lang['Search_title_msg'] = 'S�k i �mnesrubrik och i meddelandetext';
$lang['Search_msg_only'] = 'S�k endast i meddelandetext';

$lang['Return_first'] = 'Skriv ut f�rsta'; // followed by xxx characters in a select box
$lang['characters_posts'] = 'tecknen fr�n inl�gget';

$lang['Search_previous'] = 'S�k tidigare'; // followed by days, weeks, months, year, all in a select box

$lang['Sort_by'] = 'Sortera efter';
$lang['Sort_Time'] = 'Tid skapad';
$lang['Sort_Post_Subject'] = 'Inl�ggsrubrik';
$lang['Sort_Topic_Title'] = '�mnestitel';
$lang['Sort_Author'] = 'F�rfattare';
$lang['Sort_Forum'] = 'Forum';

$lang['Display_results'] = 'Visa resultat som';
$lang['All_available'] = 'Alla tillg�ngliga';
$lang['No_searchable_forums'] = 'Du har inte tillst�nd att s�ka p� n�got forum p� den h�r sajten.';

$lang['No_search_match'] = 'Inga �mnen eller inl�gg matchade dina s�kkriterier';
$lang['Found_search_match'] = 'S�kningen hittade %d matchande resultat'; // eg. Search found 1 match
$lang['Found_search_matches'] = 'S�kningen hittade %d matchande resultat'; // eg. Search found 24 matches
$lang['Search_Flood_Error'] = 'Du kan inte s�ka s� snart inp� f�rra s�kningen. V�nligen, f�rs�k igen om en stund.';

$lang['Close_window'] = 'St�ng f�nster';


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = 'Tyv�rr kan endast %s skapa viktiga meddelanden i det h�r forumet';
$lang['Sorry_auth_sticky'] = 'Tyv�rr kan endast %s skapa klistrade meddelanden i det h�r forumet';
$lang['Sorry_auth_read'] = 'Tyv�rr kan endast %s l�sa �mnen i det h�r forumet';
$lang['Sorry_auth_post'] = 'Tyv�rr kan endast %s skapa �mnen i det h�r forumet';
$lang['Sorry_auth_reply'] = 'Tyv�rr kan endast %s skapa inl�gg i det h�r forumet';
$lang['Sorry_auth_edit'] = 'Tyv�rr kan endast %s �ndra inl�gg i det h�r forumet';
$lang['Sorry_auth_delete'] = 'Tyv�rr kan endast %s ta bort inl�gg fr�n det h�r forumet';
$lang['Sorry_auth_vote'] = 'Tyv�rr kan endast %s vara med i omr�stningar p� det h�r forumet';

// These replace the %s in the above strings
$lang['Auth_Anonymous_Users'] = '<b>anonyma anv�ndare</b>';
$lang['Auth_Registered_Users'] = '<b>registrerade anv�ndare</b>';
$lang['Auth_Users_granted_access'] = '<b>anv�ndare beviljade speciell �tkomst</b>';
$lang['Auth_Moderators'] = '<b>moderatorer</b>';
$lang['Auth_Administrators'] = '<b>administrat�rer</b>';

$lang['Not_Moderator'] = 'Du �r inte en moderator i det h�r forumet.';
$lang['Not_Authorised'] = 'Inte legitimerad';

$lang['You_been_banned'] = 'Du har blivit avst�ngd (bannad) fr�n det h�r forumet<br />Var god kontakta webmastern eller forumadministrat�ren f�r mer information.';


//
// Viewonline
//
$lang['Reg_users_zero_online'] = 'Det �r 0 registrerade anv�ndare och '; // There are 5 Registered and
$lang['Reg_users_online'] = 'Det �r %d registrerade anv�ndare och '; // There are 5 Registered and
$lang['Reg_user_online'] = 'Det �r %d registrerad anv�ndare och '; // There is 1 Registered and
$lang['Hidden_users_zero_online'] = '0 dolda anv�ndare online'; // 6 Hidden users online
$lang['Hidden_users_online'] = '%d dolda anv�ndare online'; // 6 Hidden users online
$lang['Hidden_user_online'] = '%d dold anv�ndare online'; // 6 Hidden users online
$lang['Guest_users_online'] = 'Det �r %d g�ster online'; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = 'Det �r 0 g�ster online'; // There are 10 Guest users online
$lang['Guest_user_online'] = 'Det �r %d g�st online'; // There is 1 Guest user online
$lang['No_users_browsing'] = 'Det �r inga anv�ndare p� forumet just nu';

$lang['Online_explain'] = 'Informationen ovan �r baserad p� aktiva anv�ndare under de senaste 5 minuterna';

$lang['Forum_Location'] = 'Forum plats';
$lang['Last_updated'] = 'Senast aktiv';

$lang['Forum_index'] = 'Forumindex';
$lang['Logging_on'] = 'Loggar in';
$lang['Posting_message'] = 'Skriver ett inl�gg';
$lang['Searching_forums'] = 'S�ker p� forumen';
$lang['Viewing_profile'] = 'Kollar p� profil';
$lang['Viewing_online'] = 'Kollar vilka som �r online';
$lang['Viewing_member_list'] = 'Kollar p� medlemslistan';
$lang['Viewing_priv_msgs'] = 'Kollar Personliga Meddelanden';
$lang['Viewing_FAQ'] = 'Kollar p� FAQ';


//
// Moderator Control Panel
//
$lang['Mod_CP'] = 'Moderatorkontrollpanel';
$lang['Mod_CP_explain'] = 'Genom att anv�nda formul�ret nedan kan du utf�ra massmodererings operationer p� det h�r forumet. Du kan l�sa, l�sa upp, flytta eller ta bort hur m�nga �mnen som helst.';

$lang['Select'] = 'V�lj';
$lang['Delete'] = 'Ta bort';
$lang['Move'] = 'Flytta';
$lang['Lock'] = 'L�s';
$lang['Unlock'] = 'L�s upp';

$lang['Topics_Removed'] = 'De valda �mnena har tagits bort fr�n databasen.';
$lang['Topics_Locked'] = 'De valda �mnena har l�sts.';
$lang['Topics_Moved'] = 'De valda �mnena har flyttats.';
$lang['Topics_Unlocked'] = 'De valda �mnena har l�sts upp.';
$lang['No_Topics_Moved'] = 'Inga �mnen flyttades.';

$lang['Confirm_delete_topic'] = '�r du s�ker p� att du vill ta bort de valda �mnena?';
$lang['Confirm_lock_topic'] = '�r du s�ker p� att du vill l�sa de valda �mnena?';
$lang['Confirm_unlock_topic'] = '�r du s�ker p� att du vill l�sa upp de valda �mnena?';
$lang['Confirm_move_topic'] = '�r du s�ker p� att du vill flytta de valda �mnena?';

$lang['Move_to_forum'] = 'Flytta till forum';
$lang['Leave_shadow_topic'] = 'L�mna skugga av �mnet i det gamla forumet.';

$lang['Split_Topic'] = 'Dela �mneskontrollpanel';
$lang['Split_Topic_explain'] = 'Genom att anv�nda formul�ret nedan kan du dela ett �mne i 2 delar, antingen genom att v�lja inl�ggen individuellt eller genom att dela vid ett valt inl�gg';
$lang['Split_title'] = 'Ny �mnestitel';
$lang['Split_forum'] = 'Forum f�r nytt �mne';
$lang['Split_posts'] = 'Dela valda inl�gg';
$lang['Split_after'] = 'Dela fr�n valt inl�gg';
$lang['Topic_split'] = 'Det valda �mnet har blivit delat';

$lang['Too_many_error'] = 'DU har valt f�r m�nga inl�gg. Du kan endast v�lja ett inl�gg att dela �mnet efter!';

$lang['None_selected'] = 'Du har inte valt n�gra �mnen att utf�ra operationen p�. G� tillbaka och v�lj minst en.';
$lang['New_forum'] = 'Nytt forum';

$lang['This_posts_IP'] = 'IP f�r det h�r inl�gget';
$lang['Other_IP_this_user'] = 'Andra IP adresser som den h�r anv�ndaren har postat fr�n';
$lang['Users_this_IP'] = 'Anv�ndare som postar fr�n den h�r IP adressen';
$lang['IP_info'] = 'IP Information';
$lang['Lookup_IP'] = 'Sl� upp IP';


//
// Timezones ... for display on each page
//
$lang['All_times'] = 'Alla tider �r %s'; // eg. All times are GMT - 12 Hours (times from next block)

$lang['-12'] = 'GMT - 12 timmar';
$lang['-11'] = 'GMT - 11 timmar';
$lang['-10'] = 'GMT - 10 timmar';
$lang['-9'] = 'GMT - 9 timmar';
$lang['-8'] = 'GMT - 8 timmar';
$lang['-7'] = 'GMT - 7 timmar';
$lang['-6'] = 'GMT - 6 timmar';
$lang['-5'] = 'GMT - 5 timmar';
$lang['-4'] = 'GMT - 4 timmar';
$lang['-3.5'] = 'GMT - 3.5 timmar';
$lang['-3'] = 'GMT - 3 timmar';
$lang['-2'] = 'GMT - 2 timmar';
$lang['-1'] = 'GMT - 1 timme';
$lang['0'] = 'GMT';
$lang['1'] = 'GMT + 1 timme (svensk vintertid)';
$lang['2'] = 'GMT + 2 timmar (svensk sommartid)';
$lang['3'] = 'GMT + 3 timmar';
$lang['3.5'] = 'GMT + 3.5 timmar';
$lang['4'] = 'GMT + 4 timmar';
$lang['4.5'] = 'GMT + 4.5 timmar';
$lang['5'] = 'GMT + 5 timmar';
$lang['5.5'] = 'GMT + 5.5 timmar';
$lang['6'] = 'GMT + 6 Timmar';
$lang['6.5'] = 'GMT + 6.5 timmar';
$lang['7'] = 'GMT + 7 timmar';
$lang['8'] = 'GMT + 8 timmar';
$lang['9'] = 'GMT + 9 timmar';
$lang['9.5'] = 'GMT + 9.5 timmar';
$lang['10'] = 'GMT + 10 timmar';
$lang['11'] = 'GMT + 11 timmar';
$lang['12'] = 'GMT + 12 timmar';
$lang['13'] = 'GMT + 13 timmar';

// These are displayed in the timezone select box
$lang['tz']['-12'] = 'GMT - 12 timmar';
$lang['tz']['-11'] = 'GMT - 11 timmar';
$lang['tz']['-10'] = 'GMT - 10 timmar';
$lang['tz']['-9'] = 'GMT - 9 timmar';
$lang['tz']['-8'] = 'GMT - 8 timmar';
$lang['tz']['-7'] = 'GMT - 7 timmar';
$lang['tz']['-6'] = 'GMT - 6 timmar';
$lang['tz']['-5'] = 'GMT - 5 timmar';
$lang['tz']['-4'] = 'GMT - 4 timmar';
$lang['tz']['-3.5'] = 'GMT - 3.5 timmar';
$lang['tz']['-3'] = 'GMT - 3 timmar';
$lang['tz']['-2'] = 'GMT - 2 timmar';
$lang['tz']['-1'] = 'GMT - 1 timme';
$lang['tz']['0'] = 'GMT';
$lang['tz']['1'] = 'GMT + 1 timme';
$lang['tz']['2'] = 'GMT + 2 timmar';
$lang['tz']['3'] = 'GMT + 3 timmar';
$lang['tz']['3.5'] = 'GMT + 3.5 timmar';
$lang['tz']['4'] = 'GMT + 4 timmar';
$lang['tz']['4.5'] = 'GMT + 4.5 timmar';
$lang['tz']['5'] = 'GMT + 5 timmar';
$lang['tz']['5.5'] = 'GMT + 5.5 timmar';
$lang['tz']['6'] = 'GMT + 6 timmar';
$lang['tz']['6.5'] = 'GMT + 6.5 timmar';
$lang['tz']['7'] = 'GMT + 7 timmar';
$lang['tz']['8'] = 'GMT + 8 timmar';
$lang['tz']['9'] = 'GMT + 9 timmar';
$lang['tz']['9.5'] = 'GMT + 9.5 timmar';
$lang['tz']['10'] = 'GMT + 10 timmar';
$lang['tz']['11'] = 'GMT + 11 timmar';
$lang['tz']['12'] = 'GMT + 12 timmar';
$lang['tz']['13'] = 'GMT + 13 timmar';

$lang['datetime']['Sunday'] = 'S�ndag';
$lang['datetime']['Monday'] = 'M�ndag';
$lang['datetime']['Tuesday'] = 'Tisdag';
$lang['datetime']['Wednesday'] = 'Onsdag';
$lang['datetime']['Thursday'] = 'Torsdag';
$lang['datetime']['Friday'] = 'Fredag';
$lang['datetime']['Saturday'] = 'L�rdag';
$lang['datetime']['Sun'] = 'S�n';
$lang['datetime']['Mon'] = 'M�n';
$lang['datetime']['Tue'] = 'Tis';
$lang['datetime']['Wed'] = 'Ons';
$lang['datetime']['Thu'] = 'Tor';
$lang['datetime']['Fri'] = 'Fre';
$lang['datetime']['Sat'] = 'L�r';
$lang['datetime']['January'] = 'Januari';
$lang['datetime']['February'] = 'Februari';
$lang['datetime']['March'] = 'Mars';
$lang['datetime']['April'] = 'April';
$lang['datetime']['May'] = 'Maj';
$lang['datetime']['June'] = 'Juni';
$lang['datetime']['July'] = 'Juli';
$lang['datetime']['August'] = 'Augusti';
$lang['datetime']['September'] = 'September';
$lang['datetime']['October'] = 'Oktober';
$lang['datetime']['November'] = 'November';
$lang['datetime']['December'] = 'December';
$lang['datetime']['Jan'] = 'Jan';
$lang['datetime']['Feb'] = 'Feb';
$lang['datetime']['Mar'] = 'Mar';
$lang['datetime']['Apr'] = 'Apr';
$lang['datetime']['May'] = 'Maj';
$lang['datetime']['Jun'] = 'Jun';
$lang['datetime']['Jul'] = 'Jul';
$lang['datetime']['Aug'] = 'Aug';
$lang['datetime']['Sep'] = 'Sep';
$lang['datetime']['Oct'] = 'Okt';
$lang['datetime']['Nov'] = 'Nov';
$lang['datetime']['Dec'] = 'Dec';

//
// Errors (not related to a
// specific failure on a page)
//
$lang['Information'] = 'Information';
$lang['Critical_Information'] = 'Kritisk Information';

$lang['General_Error'] = 'Fel';
$lang['Critical_Error'] = 'Kritiskt Fel';
$lang['An_error_occured'] = 'Ett Fel Intr�ffade';
$lang['A_critical_error'] = 'Ett Kritiskt Fel Intr�ffade';

$lang['Admin_reauthenticate'] = 'To administer the board you must re-authenticate yourself.';
$lang['Login_attempts_exceeded'] = 'The maximum number of %s login attempts has been exceeded. You are not allowed to login for the next %s minutes.';
$lang['Please_remove_install_contrib'] = 'Please ensure both the install/ and contrib/ directories are deleted';

//
// That's all, Folks!
// -------------------------------------------------

?>