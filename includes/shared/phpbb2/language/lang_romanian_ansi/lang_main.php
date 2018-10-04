<?php
// Romanian phpBB online community - Versiune actualizata pentru PhpBB 2.0.20
/***************************************************************************
 *                            lang_main.php [rom�n�]
 *                              -------------------
 *     begin                : Ian 14 2003
 *     last update          : Jun 11, 2005
 *     language version     : 8.0
 *     copyright            : Romanian phpBB online community
 *     website              : http://www.phpbb.ro
 *     copyright 1          : (C) Daniel T�nasie
 *     email     1          : danielt@phpbb.ro
 *     copyright 2          : (C) Bogdan Toma
 *     email     2          : bogdan@phpbb.ro
 *
 *     $Id: lang_main.php,v 1.1 2009/10/18 04:16:00 orynider Exp $
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
// Add your details here if wanted, e.g. Name, username, email address, website
//

//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

$lang['ENCODING'] = 'Windows-1250';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'left';
$lang['RIGHT'] = 'right';
$lang['DATE_FORMAT'] =  'd/M/Y'; // This should be changed to the default date format for your language, php date() format


// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.

$lang['TRANSLATION_INFO'] = 'Varianta �n limba rom�n�: <a href="http://www.phpbb.ro" target="_blank">Romanian phpBB online community</a>';

//
// Common, these terms are used
// extensively on several pages
//
$lang['Forum'] = 'Forum';
$lang['Category'] = 'Categorie';
$lang['Topic'] = 'Subiect';
$lang['Topics'] = 'Subiecte';
$lang['Replies'] = 'R�spunsuri';
$lang['Views'] = 'Vizualiz�ri';
$lang['Post'] = 'Mesaj';
$lang['Posts'] = 'Mesaje';
$lang['Posted'] = 'Trimis';
$lang['Username'] = 'Utilizator';
$lang['Password'] = 'Parola';
$lang['Email'] = 'Email';
$lang['Poster'] = 'Autor';
$lang['Author'] = 'Autor';
$lang['Time'] = 'Timp';
$lang['Hours'] = 'Ore';
$lang['Message'] = 'Mesaj';

$lang['1_Day'] = '1 Zi';
$lang['7_Days'] = '7 Zile';
$lang['2_Weeks'] = '2 S�pt�m�ni';
$lang['1_Month'] = '1 Lun�';
$lang['3_Months'] = '3 Luni';
$lang['6_Months'] = '6 Luni';
$lang['1_Year'] = '1 An';

$lang['Go'] = 'Du-te';
$lang['Jump_to'] = 'Mergi direct la';
$lang['Submit'] = 'Trimite';
$lang['Reset'] = 'Reseteaz�';
$lang['Cancel'] = 'Renun��';
$lang['Preview'] = 'Previzualizeaz�';
$lang['Confirm'] = 'Confirmare';
$lang['Spellcheck'] = 'Verific�';
$lang['Yes'] = 'Da';
$lang['No'] = 'Nu';
$lang['Enabled'] = 'Activat';
$lang['Disabled'] = 'Dezactivat';
$lang['Error'] = 'Eroare';

$lang['Next'] = 'Urm�toare';
$lang['Previous'] = 'Anterioar�';
$lang['Goto_page'] = 'Du-te la pagina';
$lang['Joined'] = 'Data �nscrierii';
$lang['IP_Address'] = 'Adresa IP';

$lang['Select_forum'] = 'Alege�i un forum';
$lang['View_latest_post'] = 'Vizualizarea ultimului mesaj';
$lang['View_newest_post'] = 'Vizualizarea celui cel mai nou mesaj';
$lang['Page_of'] = 'Pagina <b>%d</b> din <b>%d</b>'; // Replaces with: Page 1 of 2 for example

$lang['ICQ'] = 'Num�rul ICQ';
$lang['AIM'] = 'Adresa AIM';
$lang['MSNM'] = 'Codul MSN Messenger';
$lang['YIM'] = 'Codul Yahoo Messenger';

$lang['Forum_Index'] = 'Pagina de start a forumului %s';  // eg. sitename Forum Index, %s can be removed if you prefer

$lang['Post_new_topic'] = 'Creaz� un subiect nou';
$lang['Reply_to_topic'] = 'R�spunde la subiect';
$lang['Reply_with_quote'] = 'R�spunde cu citat (quote)';

$lang['Click_return_topic'] = 'Ap�sa�i %saici%s pentru a reveni la subiect'; // %s's here are for uris, do not remove!
$lang['Click_return_login'] = 'Ap�sa�i %saici%s pentru a �ncerca din nou';
$lang['Click_return_forum'] = 'Ap�sa�i %saici%s pentru a reveni la forum';
$lang['Click_view_message'] = 'Ap�sa�i %saici%s pentru a vizualiza mesajul';
$lang['Click_return_modcp'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Panoul de Control al Moderatorului';
$lang['Click_return_group'] = 'Ap�sa�i %saici%s pentru a reveni la informa�iile grupului';

$lang['Admin_panel'] = 'Panoul Administratorului';

$lang['Board_disable'] = 'Ne pare r�u dar aceast� facilitate nu este momentan disponibil�; v� rug�m �ncerca�i mai t�rziu';
$lang['Please_remove_install_contrib'] = 'Te rog asigur�-te c� ambele directoare install/ �i contrib/ sunt �terse.'; 

//
// Global Header strings
//
$lang['Registered_users'] = 'Utilizatori �nregistra�i:';
$lang['Browsing_forum'] = 'Utilizatori ce navigheaz� �n acest forum:';
$lang['Online_users_zero_total'] = '�n total aici sunt <b>0</b> utilizatori conecta�i : ';
$lang['Online_users_total'] = '�n total aici sunt <b>%d</b> utilizatori conecta�i : ';
$lang['Online_user_total'] = '�n total aici este <b>%d</b> utilizator conectat : ';
$lang['Reg_users_zero_total'] = '0 �nregistra�i, ';
$lang['Reg_users_total'] = '%d �nregistra�i, ';
$lang['Reg_user_total'] = '%d �nregistrat, ';
$lang['Hidden_users_zero_total'] = '0 Ascun�i �i ';
$lang['Hidden_user_total'] = '%d Ascuns �i ';
$lang['Hidden_users_total'] = '%d Ascun�i �i ';
$lang['Guest_users_zero_total'] = '0 Vizitatori';
$lang['Guest_users_total'] = '%d Vizitatori';
$lang['Guest_user_total'] = '%d Vizitator';
$lang['Record_online_users'] = 'Cei mai mul�i utilizatori conecta�i au fost <b>%s</b> la data de %s'; // first %s = number of users, second %s is the date.

$lang['Admin_online_color'] = '%sAdministrator%s';
$lang['Mod_online_color'] = '%sModerator%s';

$lang['You_last_visit'] = 'Ultima vizit� a fost %s'; // %s replaced by date/time
$lang['Current_time'] = 'Acum este: %s'; // %s replaced by time

$lang['Search_new'] = 'Mesajele scrise de la ultima vizit�';
$lang['Search_your_posts'] = 'Mesajele proprii';
$lang['Search_unanswered'] = 'Mesajele la care nu s-a r�spuns';

$lang['Register'] = '�nregistrare';
$lang['Profile'] = 'Profil';
$lang['Edit_profile'] = 'Editare profil';
$lang['Search'] = 'C�utare';
$lang['Memberlist'] = 'Membri';
$lang['FAQ'] = 'FAQ';
$lang['BBCode_guide'] = 'Ghid pentru codul BB';
$lang['Usergroups'] = 'Grupuri';
$lang['Last_Post'] = 'Ultimul mesaj';
$lang['Moderator'] = 'Moderator';
$lang['Moderators'] = 'Moderatori';


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = 'Utilizatorii no�tri au scris un num�r de <b>0</b> articole'; // Number of posts
$lang['Posted_articles_total'] = 'Utilizatorii no�tri au scris un num�r de <b>%d</b> articole'; // Number of posts
$lang['Posted_article_total'] = 'Utilizatorii no�tri au scris un num�r de <b>%d</b> articol'; // Number of posts
$lang['Registered_users_zero_total'] = 'Avem <b>0</b> utilizatori �nregistra�i'; // # registered users
$lang['Registered_users_total'] = 'Avem <b>%d</b> utilizatori �nregistra�i'; // # registered users
$lang['Registered_user_total'] = 'Avem <b>%d</b> utilizator �nregistrat'; // # registered users
$lang['Newest_user'] = 'Cel mai nou utilizator �nregistrat este: <b>%s%s%s</b>'; // a href, username, /a

$lang['No_new_posts_last_visit'] = 'Nu sunt mesaje noi de la ultima ta vizita';
$lang['No_new_posts'] = 'Nu sunt mesaje noi';
$lang['New_posts'] = 'Mesaje noi';
$lang['New_post'] = 'Mesaj nou';
$lang['No_new_posts_hot'] = 'Nu sunt mesaje noi [ Popular ]';
$lang['New_posts_hot'] = 'Mesaje noi [ Popular ]';
$lang['No_new_posts_locked'] = 'Nu sunt mesaje noi [ �nchis ]';
$lang['New_posts_locked'] = 'Mesaje noi [ �nchis ]';
$lang['Forum_is_locked'] = 'Forumul este �nchis';


//
// Login
//
$lang['Enter_password'] = 'V� rug�m introduce�i un nume de utilizator �i o parol� pentru a va autentifica';
$lang['Login'] = 'Autentificare';
$lang['Logout'] = 'Ie�ire';

$lang['Forgotten_password'] = 'Mi-am uitat parola';

$lang['Log_me_in'] = 'Autentific�-m� automat la fiecare vizit�';

$lang['Error_login'] = 'A�i introdus un nume de utilizator incorect sau inactiv sau o parol� gre�it�';


//
// Index page
//
$lang['Index'] = 'Pagina de start';
$lang['No_Posts'] = 'Nici un mesaj';
$lang['No_forums'] = 'Nu exist� forumuri';

$lang['Private_Message'] = 'Mesaj privat';
$lang['Private_Messages'] = 'Mesaje private';
$lang['Who_is_Online'] = 'Cine este conectat';

$lang['Mark_all_forums'] = 'Marcheaz� toate forumurile ca fiind citite';
$lang['Forums_marked_read'] = 'Toate forumurile au fost marcate ca fiind citite';


//
// Viewforum
//
$lang['View_forum'] = 'Vezi forum';

$lang['Forum_not_exist'] = 'Forumul selectat nu exist�';
$lang['Reached_on_error'] = 'A�i g�sit aceast� pagin� datorit� unei erori';

$lang['Display_topics'] = 'Afi�eaz� subiectul pentru previzualizare';
$lang['All_Topics'] = 'Toate subiectele';

$lang['Topic_Announcement'] = '<b>Anun�:</b>';
$lang['Topic_Sticky'] = '<b>Important:</b>';
$lang['Topic_Moved'] = '<b>Mutat:</b>';
$lang['Topic_Poll'] = '<b>[ Chestionar ]</b>';

$lang['Mark_all_topics'] = 'Marcheaz� toate subiectele ca fiind citite';
$lang['Topics_marked_read'] = 'Toate subiectele au fost marcate ca fiind citite';

$lang['Rules_post_can'] = '<b>Pute�i</b> crea un subiect nou �n acest forum';
$lang['Rules_post_cannot'] = '<b>Nu pute�i</b> crea un subiect nou �n acest forum';
$lang['Rules_reply_can'] = '<b>Pute�i</b> r�spunde la subiectele acestui forum';
$lang['Rules_reply_cannot'] = '<b>Nu pute�i</b> r�spunde �n subiectele acestui forum';
$lang['Rules_edit_can'] = '<b>Pute�i</b> modifica mesajele proprii din acest forum';
$lang['Rules_edit_cannot'] = '<b>Nu pute�i</b> modifica mesajele proprii din acest forum';
$lang['Rules_delete_can'] = '<b>Pute�i</b> �terge mesajele proprii din acest forum';
$lang['Rules_delete_cannot'] = '<b>Nu pute�i</b> �terge mesajele proprii din acest forum';
$lang['Rules_vote_can'] = '<b>Pute�i</b> vota �n chestionarele din acest forum';
$lang['Rules_vote_cannot'] = '<b>Nu pute�i</b> vota �n chestionarele din acest forum';
$lang['Rules_moderate'] = '<b>Pute�i</b> %smodera acest forum%s'; // %s replaced by a href links, do not remove!

$lang['No_topics_post_one'] = '<br />Nu este nici un mesaj �n acest forum<br /><br />Ap�sa�i pe butonul <b>Subiect nou</b> din aceast� pagin� pentru a scrie un mesaj';


//
// Viewtopic
//
$lang['View_topic'] = 'Vizualizare subiect';

$lang['Guest'] = 'Vizitator';
$lang['Post_subject'] = 'Titlul subiectului';
$lang['View_next_topic'] = 'Subiectul urm�tor';
$lang['View_previous_topic'] = 'Subiectul anterior';
$lang['Submit_vote'] = 'Trimite votul';
$lang['View_results'] = 'Vizualizare rezultate';

$lang['No_newer_topics'] = 'Nu sunt subiecte noi �n acest forum';
$lang['No_older_topics'] = 'Nu sunt subiecte vechi �n acest forum';
$lang['Topic_post_not_exist'] = 'Nu exist� subiectul sau mesajul cerut';
$lang['No_posts_topic'] = 'Nu exist� mesaje �n acest subiect';

$lang['Display_posts'] = 'Afi�eaz� mesajele pentru a le previzualiza';
$lang['All_Posts'] = 'Toate mesajele';
$lang['Newest_First'] = 'Primele, cele mai noi mesaje';
$lang['Oldest_First'] = 'Primele, cele mai vechi mesaje';

$lang['Back_to_top'] = 'Sus';

$lang['Read_profile'] = 'Vezi profilul utilizatorului';
$lang['Visit_website'] = 'Viziteaz� site-ul autorului';
$lang['ICQ_status'] = 'Statutul ICQ';
$lang['Edit_delete_post'] = 'Modific�/�terge acest mesaj';
$lang['View_IP'] = 'IP-ul autorului';
$lang['Delete_post'] = '�terge acest mesaj';

$lang['wrote'] = 'a scris'; // proceeds the username and is followed by the quoted text
$lang['Quote'] = 'Citat'; // comes before bbcode quote output.
$lang['Code'] = 'Cod'; // comes before bbcode code output.

$lang['Edited_time_total'] = 'Ultima modificare efectuat� de c�tre %s la %s, modificat de %d dat� �n total'; // Last edited by me on 12 Oct 2001, edited 1 time in total
$lang['Edited_times_total'] = 'Ultima modificare efectuat� %s la %s, modificat de %d ori �n total'; // Last edited by me on 12 Oct 2001, edited 2 times in total

$lang['Lock_topic'] = '�nchide acest subiect';
$lang['Unlock_topic'] = 'Deschide acest subiect';
$lang['Move_topic'] = 'Mut� acest subiect';
$lang['Delete_topic'] = '�terge acest subiect';
$lang['Split_topic'] = 'Desparte acest subiect';

$lang['Stop_watching_topic'] = 'Opre�te urm�rirea acestui subiect';
$lang['Start_watching_topic'] = 'Marcheaz� acest subiect pentru urm�rirea r�spunsurilor';
$lang['No_longer_watching'] = 'A�i oprit urm�rirea acestui subiect';
$lang['You_are_watching'] = 'Acest subiect este marcat pentru urm�rire';

$lang['Total_votes'] = 'Voturi totale';

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = 'Corpul mesajului';
$lang['Topic_review'] = 'Previzualizare revizie';

$lang['No_post_mode'] = 'Nu a fost specificat modul de trimitere a mesajului'; // If posting.php is called without a mode (newtopic/reply/delete/etc, shouldn't be shown normaly)

$lang['Post_a_new_topic'] = 'Creaz� un nou subiect';
$lang['Post_a_reply'] = 'R�spunde';
$lang['Post_topic_as'] = 'Creaz� un mesaj la';
$lang['Edit_Post'] = 'Modific�';
$lang['Options'] = 'Op�iuni';

$lang['Post_Announcement'] = 'Anun�';
$lang['Post_Sticky'] = 'Important';
$lang['Post_Normal'] = 'Normal';

$lang['Confirm_delete'] = 'Sunte�i sigur c� vre�i s� �terge�i acest mesaj?';
$lang['Confirm_delete_poll'] = 'Sunte�i sigur c� vre�i s� �terge�i acest chestionar?';

$lang['Flood_Error'] = 'Nu pute�i s� trimite�i un mesaj nou la un interval at�t de scurt dupa anteriorul; v� rug�m, �ncerca�i mai t�rziu.';
$lang['Empty_subject'] = 'Trebuie specificat titlul';
$lang['Empty_message'] = 'Trebuie sa scrie�i un mesaj';
$lang['Forum_locked'] = 'Acest forum este �nchis, nu se pot scrie, crea, r�spunde sau modifica subiecte';
$lang['Topic_locked'] = 'Acest subiect este �nchis, nu se pot crea sau r�spunde la mesaje';
$lang['No_post_id'] = 'Trebuie sa selecta�i un mesaj pentru modificare';
$lang['No_topic_id'] = 'Trebuie sa selecta�i un mesaj pentru a da un r�spuns la';
$lang['No_valid_mode'] = 'Pute�i doar s� ad�uga�i, s� modifica�i, s� cita�i sau s� r�spunde�i la mesaje; reveni�i �i �ncerca�i din nou';
$lang['No_such_post'] = 'Aici nu este nici un mesaj, reveni�i �i �ncerca�i din nou';
$lang['Edit_own_posts'] = 'Scuze dar pute�i modifica doar mesajele dumneavoastr�';
$lang['Delete_own_posts'] = 'Scuze dar pute�i �terge doar mesajele dumneavoastr�';
$lang['Cannot_delete_replied'] = 'Scuze dar nu pute�i �terge mesaje la care s-a r�spuns deja';
$lang['Cannot_delete_poll'] = 'Scuze dar nu pute�i �terge un chestionar aflat �n derulare';
$lang['Empty_poll_title'] = 'Trebuie s� introduce�i un titlu pentru chestionar';
$lang['To_few_poll_options'] = 'Trebuie s� introduce�i cel pu�in dou� op�iuni de vot �n chestionar';
$lang['To_many_poll_options'] = 'A�i �ncercat s� introduce�i prea multe op�iuni de vot �n chestionar';
$lang['Post_has_no_poll'] = 'Acest mesaj nu are chestionar';
$lang['Already_voted'] = 'A�i votat deja �n acest chestionar';
$lang['No_vote_option'] = 'Trebuie s� specifica�i o op�iune la votare';

$lang['Add_poll'] = 'Adaug� un chestionar';
$lang['Add_poll_explain'] = 'Dac� nu vre�i s� ad�uga�i un chestionar la mesajul dumneavoastr�, l�sa�i c�mpurile necompletate';
$lang['Poll_question'] = 'Chestionar';
$lang['Poll_option'] = 'Op�iunile chestionarului';
$lang['Add_option'] = 'Adaug� o op�iune';
$lang['Update'] = 'Actualizeaz�';
$lang['Delete'] = '�terge';
$lang['Poll_for'] = 'Ruleaz� chestionarul pentru';
$lang['Days'] = 'Zile'; // This is used for the Run poll for ... Days + in admin_forums for pruning
$lang['Poll_for_explain'] = '[ Introduce�i 0 sau l�sa�i necompletat pentru un chestionar nelimitat �n timp ]';
$lang['Delete_poll'] = '�terge chestionarul';

$lang['Disable_HTML_post'] = 'Dezactiveaz� codul HTML �n acest mesaj';
$lang['Disable_BBCode_post'] = 'Dezactiveaz� codul BBCode �n acest mesaj';
$lang['Disable_Smilies_post'] = 'Dezactiveaz� z�mbetele �n acest mesaj';

$lang['HTML_is_ON'] = 'Codul HTML este <u>Activat</u>';
$lang['HTML_is_OFF'] = 'Codul HTML este <u>Dezactivat</u>';
$lang['BBCode_is_ON'] = '%sCodulBB%s este <u>Activat</u>'; // %s are replaced with URI pointing to FAQ
$lang['BBCode_is_OFF'] = '%sCodul%s este <u>Dezactivat</u>';
$lang['Smilies_are_ON'] = 'Z�mbetele sunt <u>Activate</u>';
$lang['Smilies_are_OFF'] = 'Z�mbetele sunt <u>Dezactivate</u>';

$lang['Attach_signature'] = 'Adaug� semn�tura (semn�tura poate fi schimbat� din Profil)';
$lang['Notify'] = 'Anun�a-m� c�nd apare un r�spuns';

$lang['Stored'] = 'Mesajul a fost introdus cu succes';
$lang['Deleted'] = 'Mesajul a fost �ters cu succes';
$lang['Poll_delete'] = 'Chestionarul a fost �ters cu succes';
$lang['Vote_cast'] = 'Votul a fost acceptat';

$lang['Topic_reply_notification'] = 'Anun� de r�spuns la mesaj';

$lang['bbcode_b_help'] = "Text �ngro�at (bold): [b]text[/b]  (alt+b)";
$lang['bbcode_i_help'] = "Text �nclinat (italic): [i]text[/i]  (alt+i)";
$lang['bbcode_u_help'] = "Text subliniat: [u]text[/u]  (alt+u)";
$lang['bbcode_q_help'] = "Text citat: [quote]text[/quote]  (alt+q)";
$lang['bbcode_c_help'] = "Cod surs�: [code]cod sursa[/code]  (alt+c)";
$lang['bbcode_l_help'] = "List�: [list]text[/list] (alt+l)";
$lang['bbcode_o_help'] = "List� ordonat�: [list=]text[/list]  (alt+o)";
$lang['bbcode_p_help'] = "Insereaz� imagine: [img]http://image_url[/img]  (alt+p)";
$lang['bbcode_w_help'] = "Insereaz� URL: [url]http://url[/url] sau [url=http://url]URL text[/url]  (alt+w)";
$lang['bbcode_a_help'] = "�nchide toate tag-urile de cod BB deschise";
$lang['bbcode_s_help'] = "Culoare text: [color=red]text[/color]  Sfat: po�i folosi �i color=#FF0000";
$lang['bbcode_f_help'] = "M�rime font: [size=x-small]text m�runt[/size]";

$lang['Emoticons'] = 'Iconi�e emotive';
$lang['More_emoticons'] = 'Alte iconi�e emotive';

$lang['Font_color'] = "Culoare text";
$lang['color_default'] = "Implicit�";
$lang['color_dark_red'] = "Ro�u �nchis";
$lang['color_red'] = "Ro�u";
$lang['color_orange'] = "Oranj";
$lang['color_brown'] = "Maro";
$lang['color_yellow'] = "Galben";
$lang['color_green'] = "Verde";
$lang['color_olive'] = "M�sliniu";
$lang['color_cyan'] = "Cyan";
$lang['color_blue'] = "Albastru";
$lang['color_dark_blue'] = "Albastru �nchis";
$lang['color_indigo'] = "Indigo";
$lang['color_violet'] = "Violet";
$lang['color_white'] = "Alb";
$lang['color_black'] = "Negru";

$lang['Font_size'] = "M�rime text";
$lang['font_tiny'] = "M�runt�";
$lang['font_small'] = "Mic�";
$lang['font_normal'] = "Normal�";
$lang['font_large'] = "Mare";
$lang['font_huge'] = "Imens�";

$lang['Close_Tags'] = '�nchide tag-uri';
$lang['Styles_tip'] = 'Sfat: Stilurile pot fi aplicate imediat textului selectat';


//
// Private Messaging
//
$lang['Private_Messaging'] = 'Mesagerie privat�';

$lang['Login_check_pm'] = 'Mesaje private';
$lang['New_pms'] = 'Ave�i %d mesaje noi'; // You have 2 new messages
$lang['New_pm'] = 'Ave�i %d mesaj nou'; // You have 1 new message
$lang['No_new_pm'] = 'Nu ave�i mesaje noi';
$lang['Unread_pms'] = 'Ave�i %d mesaje necitite';
$lang['Unread_pm'] = 'Ave�i %d mesaj necitit';
$lang['No_unread_pm'] = 'Nu ave�i mesaje necitite';
$lang['You_new_pm'] = 'Un mesaj nou privat a�teapt� �n cutia cu mesaje';
$lang['You_new_pms'] = 'Mai multe mesaje noi a�teapt� �n cutia cu mesaje';
$lang['You_no_new_pm'] = 'Nu sunt mesaje noi �n a�teptare �n cutia cu mesaje';

$lang['Unread_message'] = 'Mesaj necitit';
$lang['Read_message'] = 'Mesaj citit';

$lang['Read_pm'] = 'Mesaj citit';
$lang['Post_new_pm'] = 'Scrie mesaj';
$lang['Post_reply_pm'] = 'Retrimite mesajul';
$lang['Post_quote_pm'] = 'Comenteaz� mesajul';
$lang['Edit_pm'] = 'Modific� mesajul';

$lang['Inbox'] = 'Cutia cu mesaje';
$lang['Outbox'] = 'Cutia cu mesaje �n curs de trimitere';
$lang['Savebox'] = 'Cutia cu mesaje salvate';
$lang['Sentbox'] = 'Cutia cu mesaje trimise';
$lang['Flag'] = 'Marcaj';
$lang['Subject'] = 'Subiect';
$lang['From'] = 'De la';
$lang['To'] = 'C�tre';
$lang['Date'] = 'Data';
$lang['Mark'] = 'Marcat';
$lang['Sent'] = 'Trimis';
$lang['Saved'] = 'Salvat';
$lang['Delete_marked'] = '�terge mesajele marcate';
$lang['Delete_all'] = '�terge toate mesajele';
$lang['Save_marked'] = 'Salveaz� mesajele marcate';
$lang['Save_message'] = 'Salveaz� mesajul';
$lang['Delete_message'] = '�terge mesajul';

$lang['Display_messages'] = 'Afi�eaz� mesajele din urm�'; // Followed by number of days/weeks/months
$lang['All_Messages'] = 'Toate mesajele';

$lang['No_messages_folder'] = 'Nu ave�i mesaje noi �n acest� cutie pentru mesaje';

$lang['PM_disabled'] = 'Mesajele private au fost dezactivate de pe acest panou';
$lang['Cannot_send_privmsg'] = 'Scuze dar administratorul v� �mpiedic� �n trimiterea mesajelor private';
$lang['No_to_user'] = 'Trebuie specificat un nume de utilizator pentru a putea trimite mesajul';
$lang['No_such_user'] = 'Scuze dar acest utilizator nu exist�';

$lang['Disable_HTML_pm'] = "Deactiveaz� codul HTML �n acest mesaj";
$lang['Disable_BBCode_pm'] = "Deactiveaz� codul BB �n acest mesaj";
$lang['Disable_Smilies_pm'] = "Deactiveaz� z�mbetele �n acest mesaj";

$lang['Message_sent'] = 'Mesajul a fost trimis';

$lang['Click_return_inbox'] = "Ap�sa�i %saici%s pentru a reveni la cutia cu mesaje";
$lang['Click_return_index'] = "Ap�sa�i %saici%s pentru a reveni la Pagina de start a forumului";

$lang['Send_a_new_message'] = "Trimite un nou mesaj privat";
$lang['Send_a_reply'] = "R�spunde la un mesaj privat";
$lang['Edit_message'] = "Modific� un mesaj privat";

$lang['Notification_subject'] = 'Un nou mesaj privat a sosit';

$lang['Find_username'] = "Caut� un utilizator";
$lang['Find'] = "Caut�";
$lang['No_match'] = "Nu a fost g�sit nici un utilizator";

$lang['No_post_id'] = "ID-ul mesajului nu a fost specificat";
$lang['No_such_folder'] = "Directorul specificat nu exist�";
$lang['No_folder'] = "Nu a fost specificat directorul";

$lang['Mark_all'] = "Marcheaz� toate";
$lang['Unmark_all'] = "Demarcheaz� toate";

$lang['Confirm_delete_pm'] = "Sunte�i sigur c� vre�i s� �terge�i acest mesaj?";
$lang['Confirm_delete_pms'] = "Sunte�i sigur c� vre�i s� �terge�i aceste mesaje?";

$lang['Inbox_size'] = "Cutia dumneavoastr� cu mesaje este %d%% plin�"; // eg. Your Inbox is 50% full
$lang['Sentbox_size'] = "Cutia dumneavoastr� cu mesaje trimise este %d%% plin�";
$lang['Savebox_size'] = "Cutia dumneavoastr� cu mesaje salvate este %d%% plin�";

$lang['Click_view_privmsg'] = "Ap�sa�i %saici%s pentru a ajunge la cutia dumneavoastr� cu mesaje";


//
// Profiles/Registration
//
$lang['Viewing_user_profile'] = 'Vezi profilul : %s'; // %s is username
$lang['About_user'] = 'Totul despre %s'; // %s is username

$lang['Preferences'] = 'Preferin�e';
$lang['Items_required'] = 'Ce este marcat cu * este obligatoriu';
$lang['Registration_info'] = 'Informa�ii de �nregistrare';
$lang['Profile_info'] = 'Informa�ii despre profil';
$lang['Profile_info_warn'] = 'Aceste informa�ii vor fi f�cute publice';
$lang['Avatar_panel'] = 'Panoul de control al imaginilor asociate';
$lang['Avatar_gallery'] = 'Galeria de imagini';

$lang['Website'] = 'Site Web';
$lang['Location'] = 'Loca�ie';
$lang['Contact'] = 'Contact';
$lang['Email_address'] = 'Adresa de email';
$lang['Send_private_message'] = 'Trimite mesaj privat';
$lang['Hidden_email'] = '[ Ascuns ]';
$lang['Interests'] = 'Interese';
$lang['Occupation'] = 'Ocupa�ia';
$lang['Poster_rank'] = 'Rangul utilizatorului';

$lang['Total_posts'] = 'Num�rul total de mesaje';
$lang['User_post_pct_stats'] = '%.2f%% din total'; // 1.25% of total
$lang['User_post_day_stats'] = '%.2f mesaje pe zi'; // 1.5 posts per day
$lang['Search_user_posts'] = 'Caut� toate mesajele lui %s'; // Find all posts by username

$lang['No_user_id_specified'] = 'Scuze dar acest utilizator nu exist�';
$lang['Wrong_Profile'] = 'Nu pute�i modifica un profil dac� nu este propriul dumneavoastr� profil.';

$lang['Only_one_avatar'] = 'Se poate specifica doar un tip de imagine asociat�';
$lang['File_no_data'] = 'Fi�ierul specificat de URL-ul dumneavoastr� nu con�ine informa�ii';
$lang['No_connection_URL'] = 'Conexiunea nu poate fi facut� la URL-ul specificat';
$lang['Incomplete_URL'] = 'URL-ul introdus este incomplet';
$lang['Wrong_remote_avatar_format'] = 'URL-ul c�tre imaginea asociat� nu este valid';
$lang['No_send_account_inactive'] = 'Scuze, dar parola dumneavoastr� nu mai poate fi folosit� deoarece contul este inactiv. Te rog contacteaza administratorul forumului pentru mai multe informatii';

$lang['Always_smile'] = 'Folosesc �ntotdeauna z�mbete';
$lang['Always_html'] = 'Folosesc �ntotdeauna cod HTML';
$lang['Always_bbcode'] = 'Folosesc �ntotdeauna cod BB';
$lang['Always_add_sig'] = 'Adaug� �ntotdeauna semn�tura mea la mesaje';
$lang['Always_notify'] = 'Anun��-m� �ntotdeauna de r�spunsuri la mesajele mele';
$lang['Always_notify_explain'] = 'Trimite-mi un email c�nd cineva r�spunde la mesajele mele. Op�iunea poate fi schimbat� la fiecare mesaj nou.';

$lang['Board_style'] = 'Stilul interfe�ei';
$lang['Board_lang'] = 'Limba interfe�ei';
$lang['No_themes'] = 'Nici o tem� �n baza de date';
$lang['Timezone'] = 'Timpul zonal';
$lang['Date_format'] = 'Formatul datei';
$lang['Date_format_explain'] = 'Sintaxa utilizat� este identic� cu cea folosit� de func�ia PHP <a href=\'http://www.php.net/date\' target=\'_other\'>date()</a>';
$lang['Signature'] = 'Semn�tura';
$lang['Signature_explain'] = 'Acesta este un bloc de text care poate fi ad�ugat mesajelor scrise de dumneavoastr�. Limita este de %d caractere';
$lang['Public_view_email'] = 'Afi�eaz� �ntotdeauna adresa mea de email';

$lang['Current_password'] = 'Parola curent�';
$lang['New_password'] = 'Parola nou�';
$lang['Confirm_password'] = 'Confirma�i parola';
$lang['Confirm_password_explain'] = 'Trebuie s� confirma�i parola curent� dac� vre�i s� o schimba�i sau vre�i s� ave�i alt� adres� de email';
$lang['password_if_changed'] = 'Este necesar s� specifica�i parola dac� vre�i s� o schimba�i';
$lang['password_confirm_if_changed'] = 'Este necesar s� confirma�i parola dac� a�i schimbat-o anterior';

$lang['Avatar'] = 'Imagine asociat� (Avatar)';
$lang['Avatar_explain'] = 'Afi�eaz� o imagine micu�a sub detaliile dumneavoastr� din mesaje. Doar o imagine poate fi afi�at� �n acela�i timp, m�rimea ei nu poate fi mai mare de %d pixeli ca �nal�ime �i %d ca l��ime �i m�rimea fi�ierului poate fi cel mult de %dko.';
$lang['Upload_Avatar_file'] = '�nc�rca�i de pe calculatorul dumneavoastr� imaginea asociat�';
$lang['Upload_Avatar_URL'] = '�nc�rca�i cu un URL imaginea asociat�';
$lang['Upload_Avatar_URL_explain'] = 'Introduce�i URL-ul locului unde este imaginea asociat�r pentru a fi copiat� pe acest site.';
$lang['Pick_local_Avatar'] = 'Alege�i o imagine asociat� din galerie';
$lang['Link_remote_Avatar'] = 'Leg�tura spre un alt site ce con�ine imagini asociate';
$lang['Link_remote_Avatar_explain'] = 'Introduce�i URL-ul locului unde este imaginea asociat� pentru a face o leg�tur� la ea.';
$lang['Avatar_URL'] = 'URL-ul imaginii asociate';
$lang['Select_from_gallery'] = 'Alege�i o imagine asociat� din galerie';
$lang['View_avatar_gallery'] = 'Arat� galeria de imagini asociate';

$lang['Select_avatar'] = 'Alege�i o imagine asociat�';
$lang['Return_profile'] = 'Renun�a�i la imaginea asociat�';
$lang['Select_category'] = 'Alege�i o categorie';

$lang['Delete_Image'] = '�terge�i imaginea';
$lang['Current_Image'] = 'Imaginea curent�';

$lang['Notify_on_privmsg'] = 'Aten�ioneaz�-m� c�nd primesc un mesaj privat nou';
$lang['Popup_on_privmsg'] = 'Deschide o fereastr� c�nd primesc un mesaj privat nou';
$lang['Popup_on_privmsg_explain'] = 'Unele �abloane pot deschide o fereastr� nou� pentru a v� informa de faptul c� a�i primit un mesaj privat nou';
$lang['Hide_user'] = 'Ascunde�i indicatorul de conectare';

$lang['Profile_updated'] = 'Profilul dumneavoastr� a fost actualizat';
$lang['Profile_updated_inactive'] = 'Profilul dumneavoastr� a fost actualizat, dar deoarece au fost modificate detalii importante contul este momentan inactiv. Verifica�i-v� email-ul pentru a afla cum i�i va fi reactivat contul sau dac� este necesar� interven�ia administratorului a�tepta�i p�n� ce acesta v� va reactiva contul.';

$lang['Password_mismatch'] = 'Parolele introduse nu sunt valide';
$lang['Current_password_mismatch'] = 'Parola furnizata de dumneavoastr� nu este gasit� �n baza de date';
$lang['Password_long'] = 'Parola nu trebuie s� dep�easc� 32 de caractere';
$lang['Username_taken'] = 'Scuze, dar numele de utilizator introdus, exist� deja';
$lang['Username_invalid'] = 'Scuze, dar numele de utilizator introdus con�ine caractere gre�ite, ca de exemplu: \'';
$lang['Username_disallowed'] = 'Scuze, dar acest nume de utilizator a fost interzis';
$lang['Email_taken'] = 'Scuze, dar adresa de email introdus� este deja folosit� de un alt utilizator';
$lang['Email_banned'] = 'Scuze, dar aceast� adres� de email a fost interzis�';
$lang['Email_invalid'] = 'Scuze, dar aceast� adres� de email nu este corect�';
$lang['Signature_too_long'] = 'Semn�tura dumneavoastr� este prea lung�';
$lang['Fields_empty'] = 'Trebuie s� completa�i c�mpurile obligatorii';
$lang['Avatar_filetype'] = 'Imaginile asociate trebuie s� fie de tipul: .jpg, .gif sau .png';
$lang['Avatar_filesize'] = 'Imaginile asociate trebuie s� fie mai mici de: %d kB'; // The avatar image file size must be less than 6 kB
$lang['Avatar_imagesize'] = 'Imaginile asociate trebuie s� fie mai mici de %d pixeli pe l��ime �i %d pixeli pe �n�l�ime';

$lang['Welcome_subject'] = 'Bine a�i venit pe forumul %s '; // Welcome to my.com forums
$lang['New_account_subject'] = 'Cont nou de utilizator';
$lang['Account_activated_subject'] = 'Contul a fost activat';

$lang['Account_added'] = 'V� mul�umim pentru �nregistrare, contul a fost creat. Pute�i s� v� autentifica�i cu numele de utilizator �i parola';
$lang['Account_inactive'] = 'Contul a fost creat. Acest forum necesit� activarea contului, o cheie de activare a fost trimisa pe adresa de email furnizata de dumneavoastr�. V� rug�m s� v� verifica�i c�su�a de email pentru mai multe informa�ii.';
$lang['Account_inactive_admin'] = 'Contul a fost creat. Acest forum necesit� activarea contului de c�tre administrator. Ve�i fi informat prin email c�nd contul va fi activat.';
$lang['Account_active'] = 'Contul a fost activat. Multumim pentru inregistrare.';
$lang['Account_active_admin'] = 'Contul a fost activat';
$lang['Reactivate'] = 'Reactiva�i-v� contul!';
$lang['Already_activated'] = 'Contul a fost deja activat';
$lang['COPPA'] = 'Contul a fost creat dar trebuie sa fie aprobat, verifica�i-v�, v� rug�m, casu�a de email.';

$lang['Registration'] = 'Termenii acordului de �nregistrare';
$lang['Reg_agreement'] = '�ntotdeauna administratorii �i moderatorii acestui forum vor �ncerca s� �ndep�rteze sau s� modifice orice material deranjant c�t mai repede posibil; este imposibil s� parcurg� fiecare mesaj �n parte. Din acest motiv trebuie s� �ti�i c� toate mesajele exprim� punctul de vedere �i opiniile autorilor �i nu ale administratorilor,
moderatorilor sau a web master-ului (excep�ie f�c�nd mesajele scrise chiar de c�tre ei) �i de aceea ei nu pot fi f�cu�i responsabili.<br /><br />Trebuie s� fi�i de acord s� nu publica�i mesaje cu con�inut abuziv, obscen, vulgar, calomnios, de ur�, amenin��tor, sexual sau orice alt material ce poate viola legile aflate �n vigoare. Dac� publica�i astfel de materiale pute�i fi imediat �i pentru totdeauna �ndep�rtat din forum (�i firma care v� ofer� accesul la Internet va fi anun�at�). Adresele IP ale tuturor mesajelor trimise sunt stocate pentru a fi de ajutor �n rezolvarea unor astfel de �nc�lc�ri ale regulilor. Trebuie s� fi�i de acord c� webmaster-ul, administratorul �i moderatorii acestui forum au dreptul de a �terge, modifica sau �nchide orice subiect, oric�nd cred ei c� acest lucru se impune. Ca utilizator, trebuie s� fi�i de acord c� orice informa�ie introdus� de dumneavoastr� s� fie stocat� �n baza de date. Aceste informa�ii nu vor fi ar�tate unei ter�e persoane f�r� consim��m�ntul webmaster-ului, administratorului �i moderatorilor care nu pot fi facu�i responsabili de atacurile de furt sau de vandalism care pot s� duc� la compromiterea datelor.<br /><br />Acest forum utilizeaz� fi�ierele tip cookie pentru a stoca informa�iile pe calculatorul dumneavoastr�. Aceste fi�iere cookie nu con�in informa�ii despre alte aplica�ii ci ele sunt folosite doar pentru u�urarea navig�rii pe forum. Adresele de email sunt utilizate doar pentru confirmarea �nregistr�rii dumneavoastr� ca utilizator �i pentru parol� (�i pentru trimiterea unei noi parole dac� a�i uitat-o pe cea curent�).<br /><br />Prin ap�sarea pe butonul de �nregistrare se consider� c� sunte�i de acord cu aceste condi�ii.';

$lang['Agree_under_13'] = 'Sunt de acord cu aceste condi�ii �i declar c� am <b>sub</b> 13 ani';
$lang['Agree_over_13'] = 'Sunt de acord cu aceste condi�ii �i declar c� am <b>peste</b> 13 ani';
$lang['Agree_not'] = 'Nu sunt de acord cu aceste condi�ii';

$lang['Wrong_activation'] = 'Cheia de activare furnizat� nu se reg�se�te �n baza de date';
$lang['Send_password'] = 'Trimite�i-mi o parol� nou�';
$lang['Password_updated'] = 'O parola nou� a fost creat�, v� rug�m verifica�i-v� c�su�a de email pentru informa�iile de activare';
$lang['No_email_match'] = 'Adresa de email furnizat� nu corespunde celei asociate acestui utilizator';
$lang['New_password_activation'] = 'Activarea parolei noi';
$lang['Password_activated'] = 'Contul dumneavoastr� a fost reactivat. La autentificare utiliza�i parola trimis� �n la adresa de email primit�';

$lang['Send_email_msg'] = "Trimite un email";
$lang['No_user_specified'] = "Nu a fost specificat utilizatorul";
$lang['User_prevent_email'] = "Acest utilizator nu dore�te s� primeasca mesaje. �ncearca�i s�-i trimite�i un mesaj privat";
$lang['User_not_exist'] = "Acest utilizator nu exist�";
$lang['CC_email'] = "Trimite�i-v� o copie";
$lang['Email_message_desc'] = "Acest mesaj va fi trimis �n mod text, nu include cod HTML sau cod BB. Adresa de �ntoarcere pentru acest mesaj va fi setat� c�tre adresa dumneavoastr� de email.";
$lang['Flood_email_limit'] = "Nu pute�i trimite �nca un email �n acest moment, �ncearca�i mai t�rziu.";
$lang['Recipient'] = "Recipient";
$lang['Email_sent'] = "Mesajul a fost trimis";
$lang['Send_email'] = "Trimite un mesaj";
$lang['Empty_subject_email'] = "Trebuie specificat un subiect pentru mesaj";
$lang['Empty_message_email'] = "Trebuie introdus con�inut �n mesaj";


//
// Visual confirmation system strings
//
$lang['Confirm_code_wrong'] = 'Codul de confirmare pe care l-a� introdus este incorect';
$lang['Too_many_registers'] = 'A�i dep�it num�rul de �nregistr�ri setat pentru aceast� sesiune. V� rug�m �ncerca�i mai tarziu.';
$lang['Confirm_code_impaired'] = 'Dac� nu pute�i citi codul sau acesta este neinteligibil, v� rug�m contacta�i %sAdministrator%s pentru ajutor .';
$lang['Confirm_code'] = 'Cod de confirmare';
$lang['Confirm_code_explain'] = 'Introduce�i codul exact cum �l vede�i. Codul este case sensitive �i zero este t�iat de o linie diagonal�.';

//
// Memberslist
//
$lang['Select_sort_method'] = 'Selecta�i metoda de sortare';
$lang['Sort'] = 'Sorteaz�';
$lang['Sort_Top_Ten'] = 'Top 10 utilizatori';
$lang['Sort_Joined'] = 'Data �nregistr�rii';
$lang['Sort_Username'] = 'Nume utilizator';
$lang['Sort_Location'] = 'Loca�ia';
$lang['Sort_Posts'] = 'Num�r total de mesaje';
$lang['Sort_Email'] = 'Email';
$lang['Sort_Website'] = 'Site Web';
$lang['Sort_Ascending'] = 'Ascendent';
$lang['Sort_Descending'] = 'Descendent';
$lang['Order'] = 'Ordine';


//
// Group control panel
//
$lang['Group_Control_Panel'] = 'Panoul de control al grupurilor';
$lang['Group_member_details'] = 'Detalii despre membrii grupului';
$lang['Group_member_join'] = 'Adera�i la un grup';

$lang['Group_Information'] = 'Informa�ii despre grup';
$lang['Group_name'] = 'Numele grupului';
$lang['Group_description'] = 'Descrierea grupului';
$lang['Group_membership'] = 'Membrii grupului';
$lang['Group_Members'] = 'Membrii grupului';
$lang['Group_Moderator'] = 'Moderatorul grupului';
$lang['Pending_members'] = 'Membri �n a�teptare';

$lang['Group_type'] = 'Tipul grupului';
$lang['Group_open'] = 'Grup deschis';
$lang['Group_closed'] = 'Grup �nchis';
$lang['Group_hidden'] = 'Grup ascuns';

$lang['Current_memberships'] = 'Grupurile din care fac parte';
$lang['Non_member_groups'] = 'Grupurile din care nu fac parte';
$lang['Memberships_pending'] = 'Membri �n a�teptare';

$lang['No_groups_exist'] = 'Nu exist� grupuri';
$lang['Group_not_exist'] = 'Acest grup de utilizatori nu exist�';

$lang['Join_group'] = 'Ader� la grup';
$lang['No_group_members'] = 'Acest grup nu are membri';
$lang['Group_hidden_members'] = 'Acest grup este ascuns, nu-i pute�i vedea membrii';
$lang['No_pending_group_members'] = 'Acest grup nu are membri �n a�teptare';
$lang['Group_joined'] = '�nscrierea la acest grup a fost facut� cu succes.<br />Ve�i fi anun�at c�nd cererea dumneavoastr� va fi aprobat� de moderatorul grupului';
$lang['Group_request'] = 'A fost depus� o cerere de aderare la grupul dumneavoastr�';
$lang['Group_approved'] = 'Cererea dumneavoastr� de aderare la grup a fost aprobat�';
$lang['Group_added'] = 'A�i fost acceptat la acest grup de utilizatori';
$lang['Already_member_group'] = 'Sunte�i deja membru al acestui grup';
$lang['User_is_member_group'] = 'Utilizatorul este deja membru al acestui grup';
$lang['Group_type_updated'] = 'Modificarea tipului de grup s-a realizat cu succes';

$lang['Could_not_add_user'] = 'Utilizatorul selectat nu exist�';
$lang['Could_not_anon_user'] = 'Un Anonim nu poate fi facut membru de grup';

$lang['Confirm_unsub'] = 'Sunte�i sigur c� vre�i s� p�r�si�i acest grup?';
$lang['Confirm_unsub_pending'] = 'Cererea dumneavoastr� de aderare la acest grup nu a fost �nca aprobat�, sunte�i sigur c� vre�i s�-l p�r�si�i?';

$lang['Unsub_success'] = 'Dorin�a dumneavoastr� de p�r�sire a grupului a fost �ndeplinit�.';

$lang['Approve_selected'] = 'Aprob� selec�iile';
$lang['Deny_selected'] = 'Respinge selec�iile';
$lang['Not_logged_in'] = 'Trebuie s� fi�i autentificat pentru a adera la grup.';
$lang['Remove_selected'] = '�terge selec�iile';
$lang['Add_member'] = 'Adaug� membru';
$lang['Not_group_moderator'] = 'Nu sunte�i moderator �n acest grup; prin urmare nu pute�i efectua aceste ac�iuni.';

$lang['Login_to_join'] = 'Autentifica�i-v� pentru a adera la grup sau pentru a organiza membrii';
$lang['This_open_group'] = 'Acesta este un grup deschis, ap�sa�i aici pentru a deveni membru';
$lang['This_closed_group'] = 'Acesta este un grup �nchis, nu mai accept� noi membri';
$lang['This_hidden_group'] = 'Acesta este un grup ascuns, cererile de aderare automate nu sunt acceptate';
$lang['Member_this_group'] = 'Sunte�i membru al acestui grup';
$lang['Pending_this_group'] = 'Cererea de membru al acestui grup este �n a�teptare';
$lang['Are_group_moderator'] = 'Sunte�i moderatorul grupului';
$lang['None'] = 'Nici unul';

$lang['Subscribe'] = "�nscriere";
$lang['Unsubscribe'] = "P�r�sire";
$lang['View_Information'] = "Vizualizare informa�ii";

//
// Search
//
$lang['Search_query'] = 'Interogare de c�utare';
$lang['Search_options'] = 'Op�iuni de c�utare';

$lang['Search_keywords'] = 'Caut� dup� cuvintele cheie';
$lang['Search_keywords_explain'] = 'Pute�i folosi <u>AND</u> pentru a defini cuvintele ce trebuie s� fie �n rezultate, <u>OR</u> pentru a defini cuvintele care pot sa fie �n rezultat, �i <u>NOT</u> pentru a defini cuvintele care nu trebuie s� fie �n rezultate. Se poate utiliza * pentru p�r�i de cuvinte.';
$lang['Search_author'] = 'Caut� dup� autor';
$lang['Search_author_explain'] = 'Utiliza�i * pentru par�i de cuvinte';

$lang['Search_for_any'] = "Caut� dupa oricare dintre termeni sau utilizeaz� o interogare ca intrare";
$lang['Search_for_all'] = "Caut� dupa to�i termenii";
$lang['Search_title_msg'] = "Caut� �n titlul subiectelor �i �n textele mesajelor";
$lang['Search_msg_only'] = "Caut� doar �n textele mesajelor";

$lang['Return_first'] = '�ntoarce primele'; // followed by xxx characters in a select box
$lang['characters_posts'] = 'de caractere ale mesajelor';

$lang['Search_previous'] = 'Caut� �n urm�'; // followed by days, weeks, months, year, all in a select box

$lang['Sort_by'] = 'Sorteaz� dup�';
$lang['Sort_Time'] = 'Data mesajului';
$lang['Sort_Post_Subject'] = 'Subiectul mesajului';
$lang['Sort_Topic_Title'] = 'Titlul subiectului';
$lang['Sort_Author'] = 'Autor';
$lang['Sort_Forum'] = 'Forum';

$lang['Display_results'] = 'Afi�eaz� rezultatele ca';
$lang['All_available'] = 'Disponibile toate';
$lang['No_searchable_forums'] = 'nu ave�i drepturi de c�utare �n nici un forum de pe acest site';

$lang['No_search_match'] = 'Nici un subiect sau mesaj nu �ndepline�te criteriul introdus la c�utare';
$lang['Found_search_match'] = 'C�utarea a gasit %d rezultat'; // eg. Search found 1 match
$lang['Found_search_matches'] = 'C�utarea a gasit %d rezultate'; // eg. Search found 24 matches
$lang['Search_Flood_Error'] = 'Nu po�i face alt� c�utare at�t de recent� fa�� de ultima; te rog �ncearc� din nou �n c�teva clipe.';

$lang['Close_window'] = '�nchide fereastra';


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = 'Ne pare r�u dar doar cei care sunt %s pot pune anun�uri �n acest forum';
$lang['Sorry_auth_sticky'] = 'Ne pare r�u dar doar cei care sunt %s pot pune mesaje importante �n acest forum';
$lang['Sorry_auth_read'] = 'Ne pare r�u dar doar cei care sunt %s pot citi subiectele din acest forum';
$lang['Sorry_auth_post'] = 'Ne pare r�u dar doar cei care sunt %s pot scrie subiecte �n acest forum';
$lang['Sorry_auth_reply'] = 'Ne pare r�u dar doar cei care sunt %s pot r�spunde �n acest forum';
$lang['Sorry_auth_edit'] = 'Ne pare r�u dar doar cei care sunt %s pot modifica un mesaj �n acest forum';
$lang['Sorry_auth_delete'] = 'Ne pare r�u dar doar cei care sunt %s pot sterge un mesaj din acest forum';
$lang['Sorry_auth_vote'] = 'Ne pare r�u dar doar cei care sunt %s pot vota �n chestionarele din acest forum';

// These replace the %s in the above strings
$lang['Auth_Anonymous_Users'] = '<b>utilizator anonim</b>';
$lang['Auth_Registered_Users'] = '<b>utilizator �nregistrat</b>';
$lang['Auth_Users_granted_access'] = '<b>utilizatori cu drepturi speciale de acces</b>';
$lang['Auth_Moderators'] = '<b>moderatori</b>';
$lang['Auth_Administrators'] = '<b>administratori</b>';

$lang['Not_Moderator'] = 'Dumneavoastr� nu sunte�i moderator �n acest forum';
$lang['Not_Authorised'] = 'Nu sunte�i autorizat';

$lang['You_been_banned'] = 'Accesul dumneavoastr� �n acest forum este blocat<br />V� rug�m s� contacta�i webmaster-ul sau administratorul pentru mai multe informa�ii';


//
// Viewonline
//
$lang['Reg_users_zero_online'] = 'Sunt 0 utilizatori �nregistra�i �i '; // There ae 5 Registered and
$lang['Reg_users_online'] = 'Sunt %d utilizatori �nregistra�i �i '; // There ae 5 Registered and
$lang['Reg_user_online'] = 'Este %d utilizator �nregistrat �i '; // There ae 5 Registered and
$lang['Hidden_users_zero_online'] = '0 utilizatori ascun�i conecta�i'; // 6 Hidden users online
$lang['Hidden_users_online'] = '%d utilizatori ascun�i conecta�i'; // 6 Hidden users online
$lang['Hidden_user_online'] = '%d utilizator ascuns conectat'; // 6 Hidden users online
$lang['Guest_users_online'] = 'Sunt %d utilizatori vizitatori conecta�i'; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = 'Sunt 0 utilizatori vizitatori conecta�i'; // There are 10 Guest users online
$lang['Guest_user_online'] = 'Este %d utilizator vizitator conectat'; // There is 1 Guest user online
$lang['No_users_browsing'] = 'Nici un utilizator nu navigheaz� acum �n acest forum';

$lang['Online_explain'] = 'Aceste date se bazeaz� pe utilizatorii activi de peste 5 minute';

$lang['Forum_Location'] = 'Unde se g�se�te';
$lang['Last_updated'] = 'Conectat la';

$lang['Forum_index'] = 'Pagina de start a forumului';
$lang['Logging_on'] = 'Autentificare';
$lang['Posting_message'] = 'Scrie un mesaj';
$lang['Searching_forums'] = 'Caut� �n forumuri';
$lang['Viewing_profile'] = 'Vezi profilul';
$lang['Viewing_online'] = 'Vezi cine este conectat';
$lang['Viewing_member_list'] = 'Vezi lista cu membri';
$lang['Viewing_priv_msgs'] = 'Vezi mesajele private';
$lang['Viewing_FAQ'] = 'Vezi lista cu �ntrebari frecvente';


//
// Moderator Control Panel
//
$lang['Mod_CP'] = 'Panoul de control al moderatorului';
$lang['Mod_CP_explain'] = 'Utiliz�nd formularul de mai jos pute�i efectua opera�ii de moderare masiv� �n forum. Pute�i �nchide, deschide, muta sau �terge orice num�r de subiecte.';

$lang['Select'] = 'Selecteaz�';
$lang['Delete'] = '�terge';
$lang['Move'] = 'Mut�';
$lang['Lock'] = '�nchide';
$lang['Unlock'] = 'Deschide';

$lang['Topics_Removed'] = 'Subiectele selectate au fost cu succes �terse din baza de date.';
$lang['Topics_Locked'] = 'Subiectele selectate au fost �nchise';
$lang['Topics_Moved'] = 'Subiectele selectate au fost mutate';
$lang['Topics_Unlocked'] = 'Subiectele selectate au fost deschise';
$lang['No_Topics_Moved'] = 'Nici un subiect nu a fost mutat';

$lang['Confirm_delete_topic'] = "Sunte�i sigur c� vre�i s� �terge�i subiectul/subiectele selectate?";
$lang['Confirm_lock_topic'] = "Sunte�i sigur c� vre�i s� �nchide�i subiectul/subiectele selectate?";
$lang['Confirm_unlock_topic'] = "Sunte�i sigur c� vre�i s� deschide�i subiectul/subiectele selectate?";
$lang['Confirm_move_topic'] = "Sunte�i sigur c� vre�i s� muta�i subiectul/subiectele selectate?";

$lang['Move_to_forum'] = 'Mut� forumul';
$lang['Leave_shadow_topic'] = 'Pastreaz� o umbr� a subiectului �n vechiul forum.';

$lang['Split_Topic'] = 'Panoul de control a �mp�r�irii subiectelor';
$lang['Split_Topic_explain'] = 'Utiliz�nd formularul de mai jos pute�i �mp�r�i un subiect �n dou�, pe r�nd sau �ncepand de la cel deja selectat';
$lang['Split_title'] = 'Titlul noului subiect';
$lang['Split_forum'] = 'Forumul pentru noul subiect';
$lang['Split_posts'] = '�mparte mesajele selectate';
$lang['Split_after'] = '�mparte mesajul selectat';
$lang['Topic_split'] = 'Subiectul selectat a fost �mp�r�it cu succes';

$lang['Too_many_error'] = 'A�i selectat prea multe mesaje. Pute�i s� selecta�i doar un mesaj la care s� �mp�r�i�i subiectul!';

$lang['None_selected'] = 'Nu a�i selectat nici un subiect pentru a efectua aceasta opera�ie. V� rug�m �ntoarce�i-v� �i selecta�i cel pu�in un subiect.';
$lang['New_forum'] = 'Forum nou';

$lang['This_posts_IP'] = 'IP-ul mesajului';
$lang['Other_IP_this_user'] = 'Alte adrese IP de la care acest utilizator a trimis mesaje';
$lang['Users_this_IP'] = 'Utilizatori care au trimis mesaje de la acest IP';
$lang['IP_info'] = 'Informa�ii IP';
$lang['Lookup_IP'] = 'Vizualizare IP';


//
// Timezones ... for display on each page
//
$lang['All_times'] = 'Ora este %s'; // eg. All times are GMT - 12 Hours (times from next block)

$lang['-12'] = 'GMT - 12 ore';
$lang['-11'] = 'GMT - 11 ore';
$lang['-10'] = 'GMT - 10 ore';
$lang['-9'] = 'GMT - 9 ore';
$lang['-8'] = 'GMT - 8 ore';
$lang['-7'] = 'GMT - 7 ore';
$lang['-6'] = 'GMT - 6 ore';
$lang['-5'] = 'GMT - 5 ore';
$lang['-4'] = 'GMT - 4 ore';
$lang['-3.5'] = 'GMT - 3.5 ore';
$lang['-3'] = 'GMT - 3 ore';
$lang['-2'] = 'GMT - 2 ore';
$lang['-1'] = 'GMT - 1 ora';
$lang['0'] = 'GMT';
$lang['1'] = 'GMT + 1 ora';
$lang['2'] = 'GMT + 2 ore';
$lang['3'] = 'GMT + 3 ore';
$lang['3.5'] = 'GMT + 3.5 ore';
$lang['4'] = 'GMT + 4 ore';
$lang['4.5'] = 'GMT + 4.5 ore';
$lang['5'] = 'GMT + 5 ore';
$lang['5.5'] = 'GMT + 5.5 ore';
$lang['6'] = 'GMT + 6 ore';
$lang['6.5'] = 'GMT + 6.5 ore';
$lang['7'] = 'GMT + 7 ore';
$lang['8'] = 'GMT + 8 ore';
$lang['9'] = 'GMT + 9 ore';
$lang['9.5'] = 'GMT + 9.5 ore';
$lang['10'] = 'GMT + 10 ore';
$lang['11'] = 'GMT + 11 ore';
$lang['12'] = 'GMT + 12 ore';
$lang['13'] = 'GMT + 13 ore';

// These are displayed in the timezone select box
$lang['tz']['-12'] = 'GMT - 12 ore';
$lang['tz']['-11'] = 'GMT - 11 ore';
$lang['tz']['-10'] = 'GMT - 10 ore';
$lang['tz']['-9'] = 'GMT - 9 ore';
$lang['tz']['-8'] = 'GMT - 8 ore';
$lang['tz']['-7'] = 'GMT - 7 ore';
$lang['tz']['-6'] = 'GMT - 6 ore';
$lang['tz']['-5'] = 'GMT - 5 ore';
$lang['tz']['-4'] = 'GMT - 4 ore';
$lang['tz']['-3.5'] = 'GMT - 3.5 ore';
$lang['tz']['-3'] = 'GMT - 3 ore';
$lang['tz']['-2'] = 'GMT - 2 ore';
$lang['tz']['-1'] = 'GMT - 1 ora';
$lang['tz']['0'] = 'GMT';
$lang['tz']['1'] = 'GMT + 1 ora';
$lang['tz']['2'] = 'GMT + 2 ore';
$lang['tz']['3'] = 'GMT + 3 ore';
$lang['tz']['3.5'] = 'GMT + 3.5 ore';
$lang['tz']['4'] = 'GMT + 4 ore';
$lang['tz']['4.5'] = 'GMT + 4.5 ore';
$lang['tz']['5'] = 'GMT + 5 ore';
$lang['tz']['5.5'] = 'GMT + 5.5 ore';
$lang['tz']['6'] = 'GMT + 6 ore';
$lang['tz']['6.5'] = 'GMT + 6.5 ore';
$lang['tz']['7'] = 'GMT + 7 ore';
$lang['tz']['8'] = 'GMT + 8 ore';
$lang['tz']['9'] = 'GMT + 9 ore';
$lang['tz']['9.5'] = 'GMT + 9.5 ore';
$lang['tz']['10'] = 'GMT + 10 ore';
$lang['tz']['11'] = 'GMT + 11 ore';
$lang['tz']['12'] = 'GMT + 12 ore';
$lang['tz']['13'] = 'GMT + 13 ore';

$lang['datetime']['Sunday'] = 'Duminic�';
$lang['datetime']['Monday'] = 'Luni';
$lang['datetime']['Tuesday'] = 'Mar�i';
$lang['datetime']['Wednesday'] = 'Miercuri';
$lang['datetime']['Thursday'] = 'Joi';
$lang['datetime']['Friday'] = 'Vineri';
$lang['datetime']['Saturday'] = 'S�mb�t�';
$lang['datetime']['Sun'] = 'Dum';
$lang['datetime']['Mon'] = 'Lun';
$lang['datetime']['Tue'] = 'Mar';
$lang['datetime']['Wed'] = 'Mie';
$lang['datetime']['Thu'] = 'Joi';
$lang['datetime']['Fri'] = 'Vin';
$lang['datetime']['Sat'] = 'S�m';
$lang['datetime']['January'] = 'Ianuarie';
$lang['datetime']['February'] = 'Februarie';
$lang['datetime']['March'] = 'Martie';
$lang['datetime']['April'] = 'Aprilie';
$lang['datetime']['May'] = 'Mai';
$lang['datetime']['June'] = 'Iunie';
$lang['datetime']['July'] = 'Iulie';
$lang['datetime']['August'] = 'August';
$lang['datetime']['September'] = 'Septembrie';
$lang['datetime']['October'] = 'Octobrie';
$lang['datetime']['November'] = 'Noiembrie';
$lang['datetime']['December'] = 'Decembrie';
$lang['datetime']['Jan'] = 'Ian';
$lang['datetime']['Feb'] = 'Feb';
$lang['datetime']['Mar'] = 'Mar';
$lang['datetime']['Apr'] = 'Apr';
$lang['datetime']['May'] = 'Mai';
$lang['datetime']['Jun'] = 'Iun';
$lang['datetime']['Jul'] = 'Iul';
$lang['datetime']['Aug'] = 'Aug';
$lang['datetime']['Sep'] = 'Sep';
$lang['datetime']['Oct'] = 'Oct';
$lang['datetime']['Nov'] = 'Noi';
$lang['datetime']['Dec'] = 'Dec';

// Begin Simple Subforums MOD
$lang['Subforums'] = 'Subforumuri';
// End Simple Subforums MO

//
// Errors (not related to a
// specific failure on a page)
//
$lang['Information'] = 'Informa�ii';
$lang['Critical_Information'] = 'Informa�ii primejdioase';

$lang['General_Error'] = 'Eroare general�';
$lang['Critical_Error'] = 'Eroare primejdioas�';
$lang['An_error_occured'] = 'A ap�rut o eroare';
$lang['A_critical_error'] = 'A ap�rut o eroare primejdioas�';

$lang['Admin_reauthenticate'] = 'Pentru a administra forumul trebuie s� v� autentifica�i din nou.';

// Start add - Bin Mod
$lang['Move_bin'] = 'Move this topic to bin';
$lang['Topics_Moved_bin'] = 'The selected topics have been moved to bin.';
$lang['Bin_disabled'] = 'Bin has been disabled';
$lang['Bin_recycle'] = 'Recycle';
// End add - Bin Mod

$lang['Draft_posting']="F� acest mesaj draft";
$lang['Draft_on']="Mesaj �n Construc�ie !";
$lang['Drafted_posts']="Draft-urile tale";

//====================================================================== |
//==== Start Advanced BBCode Box MOD =================================== |
//==== v5.1.0 ========================================================== |
//====
$lang['BBCode_box_hidden'] = 'Ascuns';
$lang['BBcode_box_view'] = 'Click s� vezi con�inutul';
$lang['BBcode_box_hide'] = 'Click s� acunzi con�inutul';
$lang['bbcode_help']['GVideo'] = 'GVideo: [GVideo]GVideo URL[/GVideo]';
$lang['GVideo_link'] = 'Link';
$lang['bbcode_help']['youtube'] = 'YouTube: [youtube]YouTube URL[/youtube]';
$lang['youtube_link'] = 'Link';
//====
//==== End Advanced BBCode Box MOD ==================================== |
//===================================================================== |

// Begin Simple Subforums MOD
$lang['Subforums'] = 'Subforumuri';
// End Simple Subforums MOD

//
// That's all Folks!
// -------------------------------------------------

?>
