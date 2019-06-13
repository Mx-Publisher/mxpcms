<?php
/***************************************************************************
 *                            lang_main.php [Czech]
 *                            ---------------------
 *     characterset         : UTF-8
 *     phpBB version        : 2.0.20
 *     copyright            : © 2005 The phpBB CZ Group
 *     www                  : http://www.phpbbcz.com
 *     last modified        : 08. 04. 2006
 *
 ***************************************************************************/

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


$lang['ENCODING'] = 'UTF-8';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'left';
$lang['RIGHT'] = 'right';
$lang['DATE_FORMAT'] =  'j.n.Y'; // This should be changed to the default date format for your language, php date() format // j.n.Y == 23.5.1985


// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
// $lang['TRANSLATION'] = '';


//
// Common, these terms are used
// extensively on several pages
//
$lang['Forum'] = 'Fórum';
$lang['Category'] = 'Kategorie';
$lang['Topic'] = 'Téma';
$lang['Topics'] = 'Témata';
$lang['Replies'] = 'Odpovědi';
$lang['Views'] = 'Zhlédnuto';
$lang['Post'] = 'Příspěvek';
$lang['Posts'] = 'Příspěvky';
$lang['Posted'] = 'Zaslal';
$lang['Username'] = 'Uživatel';
$lang['Password'] = 'Heslo';
$lang['Email'] = 'E-mail';
$lang['Poster'] = 'Odesílatel';
$lang['Author'] = 'Autor';
$lang['Time'] = 'Čas';
$lang['Hours'] = 'Hodin';
$lang['Message'] = 'Zpráva';

$lang['1_Day'] = '1 den';
$lang['7_Days'] = '1 týden';
$lang['2_Weeks'] = '2 týdny';
$lang['1_Month'] = '1 měsíc';
$lang['3_Months'] = '3 měsíce';
$lang['6_Months'] = '6 měsíců';
$lang['1_Year'] = '1 rok';

$lang['Go'] = 'jdi';
$lang['Jump_to'] = 'Přejdi na';
$lang['Submit'] = 'Odeslat';
$lang['Reset'] = 'Původní hodnoty';
$lang['Cancel'] = 'Storno';
$lang['Preview'] = 'Náhled';
$lang['Confirm'] = 'Potvrdit';
$lang['Spellcheck'] = 'Kontrola pravopisu';
$lang['Yes'] = 'Ano';
$lang['No'] = 'Ne';
$lang['Enabled'] = 'Povoleno';
$lang['Disabled'] = 'Zakázáno';
$lang['Error'] = 'Chyba';

$lang['Next'] = 'Další';
$lang['Previous'] = 'Předchozí';
$lang['Goto_page'] = 'Jdi na stránku';
$lang['Joined'] = 'Založen';
$lang['IP_Address'] = 'IP adresa';

$lang['Select_forum'] = 'Zvolte fórum';
$lang['View_latest_post'] = 'Zobrazit poslední příspěvek';
$lang['View_newest_post'] = 'Zobraz nejnovější příspěvky';
$lang['Page_of'] = 'Strana <b>%d</b> z <b>%d</b>'; // Replaces with: Page 1 of 2 for example

$lang['ICQ'] = 'ICQ';
$lang['AIM'] = 'AOL Instant Messenger';
$lang['MSNM'] = 'MSN Messenger';
$lang['YIM'] = 'Yahoo Messenger';

$lang['Forum_Index'] = 'Obsah fóra %s';  // eg. sitename Forum Index, %s can be removed if you prefer

$lang['Post_new_topic'] = 'Přidat nové téma';
$lang['Reply_to_topic'] = 'Zaslat odpověď';
$lang['Reply_with_quote'] = 'Citovat';

$lang['Click_return_topic'] = 'Klikněte %szde%s pro návrat do tématu.'; // %s's here are for uris, do not remove!
$lang['Click_return_login'] = 'Klikněte %szde%s pro opakování volby.';
$lang['Click_return_forum'] = 'Klikněte %szde%s pro návrat na obsah fóra.';
$lang['Click_view_message'] = 'Klikněte %szde%s pro zobrazení vaší zprávy.';
$lang['Click_return_modcp'] = 'Klikněte %szde%s pro návrat do moderátorského ovládacího panelu.';
$lang['Click_return_group'] = 'Klikněte %szde%s pro návrat do informací o skupinách.';

$lang['Admin_panel'] = 'Administrace fóra';

$lang['Board_disable'] = 'Promiňte, ale toto fórum je momentálně nedostupné. Zkuste opakovat volbu později.';


//
// Global Header strings
//
$lang['Registered_users'] = 'Registrovaní uživatelé:';
$lang['Browsing_forum'] = 'Uživatelé prohlížející toto fórum:';
$lang['Online_users_zero_total'] = 'Celkem je zde přítomno <b>0</b> uživatelů: ';
$lang['Online_users_total'] = 'Celkem je zde přítomno <b>%d</b> uživatelů: ';
$lang['Online_user_total'] = 'Celkem je zde přítomen  <b>%d</b> uživatel: ';
$lang['Reg_users_zero_total'] = '0 registrovaných, ';
$lang['Reg_users_total'] = '%d registrovaných, ';
$lang['Reg_user_total'] = '%d registrovaný, ';
$lang['Hidden_users_zero_total'] = '0 skrytých a ';
$lang['Hidden_user_total'] = '%d skrytý a ';
$lang['Hidden_users_total'] = '%d skrytých a ';
$lang['Guest_users_zero_total'] = '0 anonymních.';
$lang['Guest_users_total'] = '%d anonymních.';
$lang['Guest_user_total'] = '%d anonymní.';
$lang['Record_online_users'] = 'Nejvíce zde bylo současně přítomno <b>%s</b> uživatelů dne %s.'; // first %s = number of users, second %s is the date.

$lang['Admin_online_color'] = '%sadministrátoři%s';
$lang['Mod_online_color'] = '%smoderátoři%s';

$lang['You_last_visit'] = 'Naposledy jste zde byl %s'; // %s replaced by date/time
$lang['Current_time'] = 'Právě je %s'; // %s replaced by time

$lang['Search_new'] = 'Zobrazit nové příspěvky od poslední návštěvy';
$lang['Search_your_posts'] = 'Zobrazit vaše příspěvky';
$lang['Search_unanswered'] = 'Zobrazit příspěvky bez odpovědí';

$lang['Register'] = 'Registrace';
$lang['Profile'] = 'Profil';
$lang['Edit_profile'] = 'Změna nastavení';
$lang['Search'] = 'Hledat';
$lang['Memberlist'] = 'Seznam uživatelů';
$lang['FAQ'] = 'FAQ';
$lang['BBCode_guide'] = 'Průvodce značkami';
$lang['Usergroups'] = 'Uživatelské skupiny';
$lang['Last_Post'] = 'Poslední příspěvek';
$lang['Moderator'] = 'Moderátor';
$lang['Moderators'] = 'Moderátoři';


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = 'Uživatelé zaslali celkem <b>0</b> příspěvků.'; // Number of posts
$lang['Posted_articles_total'] = 'Uživatelé zaslali celkem <b>%d</b> příspěvků.'; // Number of posts
$lang['Posted_article_total'] = 'Uživatelé zaslali celkem <b>%d</b> příspěvek.'; // Number of posts
$lang['Registered_users_zero_total'] = 'Je zde <b>0</b> registrovaných uživatelů.'; // # registered users
$lang['Registered_users_total'] = 'Je zde <b>%d</b> registrovaných uživatelů.'; // # registered users
$lang['Registered_user_total'] = 'Je zde <b>%d</b> registrovaný uživatel.'; // # registered users
$lang['Newest_user'] = 'Nejnovějším registrovaným uživatelem je <b>%s%s%s</b>.'; // a href, username, /a

$lang['No_new_posts_last_visit'] = 'Žádné nové příspěvky od vaší poslední návštěvy';
$lang['No_new_posts'] = 'Žádné nové příspěvky';
$lang['New_posts'] = 'Nové příspěvky';
$lang['New_post'] = 'Nový příspěvek';
$lang['No_new_posts_hot'] = 'Žádné nové příspěvky [oblíbené]';
$lang['New_posts_hot'] = 'Nové příspěvky [oblíbené]';
$lang['No_new_posts_locked'] = 'Žádné nové příspěvky [zamknuto]';
$lang['New_posts_locked'] = 'Nové příspěvky [zamknuto]';
$lang['Forum_is_locked'] = 'Fórum je zamknuto';


//
// Login
//
$lang['Enter_password'] = 'Zadejte prosím vaše uživatelské jméno a heslo';
$lang['Login'] = 'Přihlášení';
$lang['Logout'] = 'Odhlášení';

$lang['Forgotten_password'] = 'Zapomněli jste svoje heslo?';

$lang['Log_me_in'] = 'Přihlásit automaticky při příští návštěvě';

$lang['Error_login'] = 'Bylo zadáno neplatné uživatelské jméno nebo heslo.';


//
// Index page
//
$lang['Index'] = 'Fórum';
$lang['No_Posts'] = 'Žádné příspěvky';
$lang['No_forums'] = 'Žádná fóra';

$lang['Private_Message'] = 'Soukromá zpráva';
$lang['Private_Messages'] = 'Soukromé zprávy';
$lang['Who_is_Online'] = 'Kdo je přítomen';

$lang['Mark_all_forums'] = 'Označit všechna fóra jako přečtená';
$lang['Forums_marked_read'] = 'Všechna fóra byla označena jako přečtená.';


//
// Viewforum
//
$lang['View_forum'] = 'Zobrazit fórum';

$lang['Forum_not_exist'] = 'Zvolené fórum neexistuje.';
$lang['Reached_on_error'] = 'Došlo k chybě na této stránce.';

$lang['Display_topics'] = 'Zobrazit témata za předchozí';
$lang['All_Topics'] = 'Všechna témata';

$lang['Topic_Announcement'] = '<b>Oznámení:</b>';
$lang['Topic_Sticky'] = '<b>Důležité:</b>';
$lang['Topic_Moved'] = '<b>Přesunuto:</b>';
$lang['Topic_Poll'] = '<b>[Hlasování]</b>';

$lang['Mark_all_topics'] = 'Označit všechna témata jako přečtená';
$lang['Topics_marked_read'] = 'Témata tohoto fóra byla označena jako přečtená.';

$lang['Rules_post_can'] = '<b>Můžete</b> přidat nové téma do tohoto fóra.';
$lang['Rules_post_cannot'] = '<b>Nemůžete</b> odesílat nové téma do tohoto fóra.';
$lang['Rules_reply_can'] = '<b>Můžete</b> odpovídat na témata v tomto fóru.';
$lang['Rules_reply_cannot'] = '<b>Nemůžete</b> odpovídat na témata v tomto fóru.';
$lang['Rules_edit_can'] = '<b>Můžete</b> upravovat své příspěvky v tomto fóru.';
$lang['Rules_edit_cannot'] = '<b>Nemůžete</b> upravovat své příspěvky v tomto fóru.';
$lang['Rules_delete_can'] = '<b>Můžete</b> mazat své příspěvky v tomto fóru.';
$lang['Rules_delete_cannot'] = '<b>Nemůžete</b> mazat své příspěvky v tomto fóru.';
$lang['Rules_vote_can'] = '<b>Můžete</b> hlasovat v tomto fóru.';
$lang['Rules_vote_cannot'] = '<b>Nemůžete</b> hlasovat v tomto fóru.';
$lang['Rules_moderate'] = '<b>Můžete</b> %smoderovat toto fórum%s.'; // %s replaced by a href links, do not remove!

$lang['No_topics_post_one'] = 'Toto fórum neobsahuje žádná témata.<br />Klikněte na odkaz <b>Nové téma</b> pro přidání nového tématu.';


//
// Viewtopic
//
$lang['View_topic'] = 'Zobrazit téma';

$lang['Guest'] = 'Anonymní';
$lang['Post_subject'] = 'Předmět';
$lang['View_next_topic'] = 'Zobrazit následující téma';
$lang['View_previous_topic'] = 'Zobrazit předchozí téma';
$lang['Submit_vote'] = 'Odeslat hlas';
$lang['View_results'] = 'Zobrazit výsledek';

$lang['No_newer_topics'] = 'V tomto fóru nejsou žádná novější témata.';
$lang['No_older_topics'] = 'V tomto fóru nejsou žádná starší témata.';
$lang['Topic_post_not_exist'] = 'Téma nebo příspěvek který požadujete nebyl nalezen.';
$lang['No_posts_topic'] = 'Pro toto téma neexistují žádné příspěvky.';

$lang['Display_posts'] = 'Zobrazit příspěvky z předchozích';
$lang['All_Posts'] = 'Všechny příspěvky';
$lang['Newest_First'] = 'Nejdříve nejnovější';
$lang['Oldest_First'] = 'Nejdříve nejstarší';

$lang['Back_to_top'] = 'Návrat nahoru';

$lang['Read_profile'] = 'Zobrazit informace o autorovi';
$lang['Visit_website'] = 'Zobrazit autorovy WWW stránky';
$lang['ICQ_status'] = 'ICQ stav';
$lang['Edit_delete_post'] = 'Upravit/Odstranit tento příspěvek';
$lang['View_IP'] = 'Zobrazit IP adresu odesilatele';
$lang['Delete_post'] = 'Odstranit tento příspěvek';

$lang['wrote'] = 'napsal'; // proceeds the username and is followed by the quoted text
$lang['Quote'] = 'citace'; // comes before bbcode quote output.
$lang['Code'] = 'kód'; // comes before bbcode code output.

$lang['Edited_time_total'] = 'Naposledy upravil %s dne %s, celkově upraveno %d krát.'; // Last edited by me on 12 Oct 2001, edited 1 time in total
$lang['Edited_times_total'] = 'Naposledy upravil %s dne %s, celkově upraveno %d krát.'; // Last edited by me on 12 Oct 2001, edited 2 times in total

$lang['Lock_topic'] = 'Zamknout toto téma';
$lang['Unlock_topic'] = 'Odemknout toto téma';
$lang['Move_topic'] = 'Přesunout toto téma';
$lang['Delete_topic'] = 'Odstranit toto téma';
$lang['Split_topic'] = 'Rozdělit toto téma';

$lang['Stop_watching_topic'] = 'Ukončit sledování tohoto tématu';
$lang['Start_watching_topic'] = 'Sledovat odpovědi na toto téma';
$lang['No_longer_watching'] = 'Přestal(a) jste sledovat odpovědi na toto téma.';
$lang['You_are_watching'] = 'Začal(a) jste sledovat odpovědi na toto téma.';

$lang['Total_votes'] = 'Celkem hlasů';


//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = 'Tělo zprávy';
$lang['Topic_review'] = 'Přehled tématu';

$lang['No_post_mode'] = 'Nebyl zvolen typ odeslání!'; // If posting.php is called without a mode (newtopic/reply/delete/etc, shouldn't be shown normaly)

$lang['Post_a_new_topic'] = 'Přidat nové téma';
$lang['Post_a_reply'] = 'Odeslat odpověď';
$lang['Post_topic_as'] = 'Odeslat téma jako';
$lang['Edit_Post'] = 'Upravit příspěvek';
$lang['Options'] = 'Předvolby';

$lang['Post_Announcement'] = 'Oznámení';
$lang['Post_Sticky'] = 'Důležité';
$lang['Post_Normal'] = 'Normální';

$lang['Confirm_delete'] = 'Opravdu chcete odstranit tento příspěvek?';
$lang['Confirm_delete_poll'] = 'Opravdu chcete odstranit toto hlasování?';

$lang['Flood_Error'] = 'Nemůžete odeslat nový příspěvek takto brzy po předchozím příspěvku, chvíli vyčkejte a zkuste to znovu.';
$lang['Empty_subject'] = 'Musíte zadat text předmětu!';
$lang['Empty_message'] = 'Musíte zadat text příspěvku!';
$lang['Forum_locked'] = 'Toto fórum je zamknuto, nemůžete zde psát ani upravovat příspěvky!';
$lang['Topic_locked'] = 'Toto téma je zamknuto, nemůžete zde přidávat odpovědi ani upravovat své příspěvky!';
$lang['No_post_id'] = 'Musíte zvolit příspěvek, který chcete upravovat!';
$lang['No_topic_id'] = 'Musíte zvolit téma na které chcete odpovědět!';
$lang['No_valid_mode'] = 'Můžete jen odesílat, upravovat nebo citovat příspěvky, vraťte se zpět a zkuste to znovu.';
$lang['No_such_post'] = 'Takovýto příspěvek neexistuje, vraťte se zpět a zkuste to znovu.';
$lang['Edit_own_posts'] = 'Promiňte, ale můžete upravovat jen své příspěvky!';
$lang['Delete_own_posts'] = 'Promiňte, ale můžete mazat jen své příspěvky!';
$lang['Cannot_delete_replied'] = 'Promiňte, ale nemůžete mazat příspěvky, na které již bylo odpovězeno!';
$lang['Cannot_delete_poll'] = 'Promiňte, ale nemůžete vymazat aktivní hlasování!';
$lang['Empty_poll_title'] = 'Musíte napsat hlasovací otázku!';
$lang['To_few_poll_options'] = 'Musíte napsat alespoň dvě hlasovací možnosti!';
$lang['To_many_poll_options'] = 'Pokoušíte se napsat příliš mnoho hlasovacích možností.';
$lang['Post_has_no_poll'] = 'Tento příspěvek nemá hlasování.';
$lang['Already_voted'] = 'V tomto hlasování jste již hlasoval(a).';
$lang['No_vote_option'] = 'Při hlasování musíte zvolit některou z možností.';

$lang['Add_poll'] = 'Přidat hlasování';
$lang['Add_poll_explain'] = 'Jestliže nechcete přidat možnost hlasování k tomuto tématu, nechte pole prázdná.';
$lang['Poll_question'] = 'Hlasovací otázka';
$lang['Poll_option'] = 'Možné odpovědi';
$lang['Add_option'] = 'Přidat odpověď';
$lang['Update'] = 'Aktualizovat';
$lang['Delete'] = 'Odstranit';
$lang['Poll_for'] = 'Délka trvání';
$lang['Days'] = 'dní'; // This is used for the Run poll for ... Days + in admin_forums for pruning
$lang['Poll_for_explain'] = '(zadejte 0 nebo nevyplňujte pro neomezenou dobu hlasování)';
$lang['Delete_poll'] = 'Smazat hlasování';

$lang['Disable_HTML_post'] = 'Zakázat HTML v tomto příspěvku';
$lang['Disable_BBCode_post'] = 'Zakázat značky v tomto příspěvku';
$lang['Disable_Smilies_post'] = 'Zakázat smajlíky v tomto příspěvku';

$lang['HTML_is_ON'] = 'HTML: <u>POVOLENO</u>';
$lang['HTML_is_OFF'] = 'HTML: <u>VYPNUTO</u>';
$lang['BBCode_is_ON'] = '%sZnačky%s: <u>POVOLENY</u>'; // %s are replaced with URI pointing to FAQ
$lang['BBCode_is_OFF'] = '%sZnačky%s: <u>VYPNUTY</u>';
$lang['Smilies_are_ON'] = 'Smajlíky: <u>POVOLENY</u>';
$lang['Smilies_are_OFF'] = 'Smajlíky: <u>VYPNUTY</u>';

$lang['Attach_signature'] = 'Připojit podpis (podpis můžete změnit ve vašem nastavení)';
$lang['Notify'] = 'Upozornit mne, přijde-li odpověď';

$lang['Stored'] = 'Vaše zpráva byla úspěšně odeslána.';
$lang['Deleted'] = 'Vaše zpráva byla úspěšně odstraněna.';
$lang['Poll_delete'] = 'Hlasování bylo úspěšně odstraněno.';
$lang['Vote_cast'] = 'Váš hlas byl přijat.';

$lang['Topic_reply_notification'] = 'Upozornění na odpověď';

$lang['bbcode_b_help'] = 'Tučné: [b]text[/b]  (alt+b)';
$lang['bbcode_i_help'] = 'Kurzíva: [i]text[/i]  (alt+i)';
$lang['bbcode_u_help'] = 'Podtržené: [u]text[/u]  (alt+u)';
$lang['bbcode_q_help'] = 'Citace: [quote]text[/quote]  (alt+q)';
$lang['bbcode_c_help'] = 'Zobrazení kódu: [code]code[/code]  (alt+c)';
$lang['bbcode_l_help'] = 'Seznam: [list]text[/list] (alt+l)';
$lang['bbcode_o_help'] = 'Uspořádaný seznam: [list=]text[/list]  (alt+o)';
$lang['bbcode_p_help'] = 'Vložit obrázek: [img]http://image_url[/img]  (alt+p)';
$lang['bbcode_w_help'] = 'Vložit URL: [url]http://url[/url] or [url=http://url]URL text[/url]  (alt+w)';
$lang['bbcode_a_help'] = 'Zavře všechny otevřené značky';
$lang['bbcode_s_help'] = 'Barva písma: [color=red]text[/color] Tip: můžete použít také color=#FF0000';
$lang['bbcode_f_help'] = 'Velikost písma: [size=x-small]malý text[/size]';

$lang['Emoticons'] = 'Smajlíky (emotikony)';
$lang['More_emoticons'] = 'Zobrazit další smajlíky (emotikony)';

$lang['Font_color'] = 'Barva písma';
$lang['color_default'] = 'Výchozí';
$lang['color_dark_red'] = 'Kaštanová';
$lang['color_red'] = 'Červená';
$lang['color_orange'] = 'Oranžová';
$lang['color_brown'] = 'Hnědá';
$lang['color_yellow'] = 'Žlutá';
$lang['color_green'] = 'Zelená';
$lang['color_olive'] = 'Olivová';
$lang['color_cyan'] = 'Azurová';
$lang['color_blue'] = 'Modrá';
$lang['color_dark_blue'] = 'Tmavě modrá';
$lang['color_indigo'] = 'Fialová';
$lang['color_violet'] = 'Fuchsiová';
$lang['color_white'] = 'Bílá';
$lang['color_black'] = 'Černá';

$lang['Font_size'] = 'Velikost písma';
$lang['font_tiny'] = 'Drobné';
$lang['font_small'] = 'Malé';
$lang['font_normal'] = 'Výchozí';
$lang['font_large'] = 'Velké';
$lang['font_huge'] = 'Obrovské';

$lang['Close_Tags'] = 'zavřít značky';
$lang['Styles_tip'] = 'Tip: Styl můžete aplikovat rychleji na označeném textu.';


//
// Private Messaging
//
$lang['Private_Messaging'] = 'Soukromé zprávy';
$lang['Login_check_pm'] = 'Soukromé zprávy';
$lang['New_pms'] = 'Soukromé zprávy (%d nové)'; // You have 2 new messages
$lang['New_pm'] = 'Soukromé zprávy (%d nová)'; // You have 1 new message
$lang['No_new_pm'] = 'Soukromé zprávy';
$lang['Unread_pms'] = 'Máte %d nepřečtené zprávy';
$lang['Unread_pm'] = 'Máte %d nepřečtenou zprávu';
$lang['No_unread_pm'] = 'Nemáte žádné nepřečtené zprávy';
$lang['You_new_pm'] = 'Nová soukromá zpráva čeká na přečtení v doručených zprávách.';
$lang['You_new_pms'] = 'Nové soukromé zprávy čekají na přečtení v doručených zprávách.';
$lang['You_no_new_pm'] = 'Žádné nové soukromé zprávy nečekají na přečtení.';
$lang['Unread_message'] = 'Nepřečtená zpráva';
$lang['Read_message'] = 'Číst zprávu';

$lang['Read_pm'] = 'Číst zprávu';
$lang['Post_new_pm'] = 'Poslat zprávu';
$lang['Post_reply_pm'] = 'Odpovědět na zprávu';
$lang['Post_quote_pm'] = 'Citovat zprávu';
$lang['Edit_pm'] = 'Upravit zprávu';

$lang['Inbox'] = 'Doručené';
$lang['Outbox'] = 'Nedoručené';
$lang['Savebox'] = 'Uložené';
$lang['Sentbox'] = 'Odeslané';
$lang['Flag'] = 'Příznak';
$lang['Subject'] = 'Předmět';
$lang['From'] = 'Od';
$lang['To'] = 'Komu';
$lang['Date'] = 'Datum';
$lang['Mark'] = 'Označit';
$lang['Sent'] = 'Zasláno';
$lang['Saved'] = 'Uloženo';
$lang['Delete_marked'] = 'Odstranit označené';
$lang['Delete_all'] = 'Odstranit vše';
$lang['Save_marked'] = 'Uložit označené';
$lang['Save_message'] = 'Uložit zprávu';
$lang['Delete_message'] = 'Odstranit zprávu';

$lang['Display_messages'] = 'Zobrazit zprávy za předchozí'; // Followed by number of days/weeks/months
$lang['All_Messages'] = 'Všechny zprávy';

$lang['No_messages_folder'] = 'Nemáte žádné zprávy v této složce.';

$lang['PM_disabled'] = 'Posílání soukromých zpráv bylo na tomto boardu zakázáno.';
$lang['Cannot_send_privmsg'] = 'Promiňte, ale administrátor vám neumožnil zasílání soukromých zpráv.';
$lang['No_to_user'] = 'Musíte zadat uživatelské jméno aby bylo možné odeslat tuto zprávu.';
$lang['No_such_user'] = 'Tento uživatel není registrován.';

$lang['Disable_HTML_pm'] = 'Zakázat HTML v této zprávě';
$lang['Disable_BBCode_pm'] = 'Zakázat značky v této zprávě';
$lang['Disable_Smilies_pm'] = 'Zakázat smajlíky v této zprávě';

$lang['Message_sent'] = 'Vaše zpráva byla odeslána.';

$lang['Click_return_inbox'] = 'Klikněte %szde%s pro návrat do doručených.';
$lang['Click_return_index'] = 'Klikněte %szde%s pro návrat na obsah.';

$lang['Send_a_new_message'] = 'Odeslat novou soukromou zprávu';
$lang['Send_a_reply'] = 'Odpovědět na soukromou zprávu';
$lang['Edit_message'] = 'Upravit soukromou zprávu';

$lang['Notification_subject'] = 'Přišla nová soukromá zpráva';

$lang['Find_username'] = 'Hledat uživatele';
$lang['Find'] = 'Hledat';
$lang['No_match'] = 'Žádný výsledek';

$lang['No_post_id'] = 'Nebylo zvoleno ID zprávy.';
$lang['No_such_folder'] = 'Požadovaná složka neexistuje.';
$lang['No_folder'] = 'Nebyla zvolena složka.';

$lang['Mark_all'] = 'Označit vše';
$lang['Unmark_all'] = 'Odznačit vše';

$lang['Confirm_delete_pm'] = 'Opravdu chcete odstranit tuto zprávu?';
$lang['Confirm_delete_pms'] = 'Opravdu chcete odstranit tyto zprávy?';

$lang['Inbox_size'] = 'Schránka je zaplněna z %d%%.'; // eg. Your Inbox is 50% full
$lang['Sentbox_size'] = 'Schránka je zaplněna z %d%%.';
$lang['Savebox_size'] = 'Schránka je zaplněna z %d%%.';

$lang['Click_view_privmsg'] = 'Klikněte %szde%s pro zobrazení obsahu příchozích zpráv';


//
// Profiles/Registration
//
$lang['Viewing_user_profile'] = 'Informace o uživateli: %s'; // %s is username
$lang['About_user'] = 'Vše o uživateli %s'; // %s is username

$lang['Preferences'] = 'Možnosti';
$lang['Items_required'] = 'Pole označená "*" jsou povinná a musí být vyplněna';
$lang['Registration_info'] = 'Registrační údaje';
$lang['Profile_info'] = 'Osobní údaje';
$lang['Profile_info_warn'] = 'Tyto informace budou veřejně zobrazitelné';
$lang['Avatar_panel'] = 'Nastavení postaviček';
$lang['Avatar_gallery'] = 'Galerie postaviček';

$lang['Website'] = 'WWW';
$lang['Location'] = 'Bydliště';
$lang['Contact'] = 'Kontakt';
$lang['Email_address'] = 'E-mailová adresa';
$lang['Send_private_message'] = 'Odeslat soukromou zprávu';
$lang['Hidden_email'] = '[ skrytý ]';
$lang['Interests'] = 'Zájmy';
$lang['Occupation'] = 'Povolání';
$lang['Poster_rank'] = 'Odesilatelovo hodnocení';

$lang['Total_posts'] = 'Příspěvků';
$lang['User_post_pct_stats'] = '%.2f%% ze všech příspěvků'; // 1.25% of total
$lang['User_post_day_stats'] = '%.2f příspěvků za den'; // 1.5 posts per day
$lang['Search_user_posts'] = 'Hledat všechny příspěvky od uživatele %s'; // Find all posts by username

$lang['No_user_id_specified'] = 'Promiňte, ale tento uživatel neexistuje.';
$lang['Wrong_Profile'] = 'Nemůžete modifikovat toto nastavení, jelikož nejste jeho vlastníkem.';

$lang['Only_one_avatar'] = 'Může být zvolen pouze jeden obrázek postavičky.';
$lang['File_no_data'] = 'Soubor na zadané URL adrese neobsahuje žádná data.';
$lang['No_connection_URL'] = 'Nelze navázat spojení se zadanou URL adresou.';
$lang['Incomplete_URL'] = 'Vámi zadaná URL adresa není kompletní.';
$lang['Wrong_remote_avatar_format'] = 'URL adresa vzdáleného obrázku postavičky není dostupná.';
$lang['No_send_account_inactive'] = 'Promiňte, ale vaše heslo nemůže být nalezeno, protože je váš účet momentálně neaktivní. Pro více informací kontaktujte administrátora tohoto boardu.';

$lang['Always_smile'] = 'Vždy povolit smajlíky';
$lang['Always_html'] = 'Vždy povolit HTML';
$lang['Always_bbcode'] = 'Vždy povolit značky';
$lang['Always_add_sig'] = 'Vždy připojit můj podpis';
$lang['Always_notify'] = 'Vždy mně upozornit na odpovědi';
$lang['Always_notify_explain'] = 'Pošle e-mail když někdo odpoví na vámi poslané téma. Toto může být změněno kdykoli před odesláním nového tématu.';

$lang['Board_style'] = 'Vzhled fóra';
$lang['Board_lang'] = 'Jazyk fóra';
$lang['No_themes'] = 'Vzhled není v databázi';
$lang['Timezone'] = 'Časové pásmo';
$lang['Date_format'] = 'Formát data a času';
$lang['Date_format_explain'] = 'Použitá syntaxe je shodná s PHP funkcí <a href="http://www.php.net/date" target="_other">date()</a>';
$lang['Signature'] = 'Podpis';
$lang['Signature_explain'] = 'Text, který může být přidáván do vašich příspěvků<br />Maximálně %d znaků';
$lang['Public_view_email'] = 'Vždy zobrazovat mou e-mailovou adresu';

$lang['Current_password'] = 'Aktuální heslo';
$lang['New_password'] = 'Nové heslo';
$lang['Confirm_password'] = 'Potvrzení hesla';
$lang['Confirm_password_explain'] = 'Pokud chcete změnit heslo nebo upravit e-mailovou adresu musíte zadat vaše aktuální heslo.';
$lang['password_if_changed'] = 'Vyplňte pokud chcete změnit aktuální heslo.';
$lang['password_confirm_if_changed'] = 'Vyplňte pro potvrzení, pokud chcete změnit vaše aktuální heslo.';

$lang['Avatar'] = 'Obrázek postavičky';
$lang['Avatar_explain'] = 'Zobrazit malý obrázek postavičky pod podrobnostmi v příspěvcích. Pouze jeden obrázek postavičky bude zobrazen, jeho šířka by neměla být větší než %d bodů a výška %d bodů a velikost souboru by neměla přesahovat %dkB.';
$lang['Upload_Avatar_file'] = 'Nahraj obrázek postavičky ze svého počítače na server';
$lang['Upload_Avatar_URL'] = 'Přihrát obrázek postavičky z URL';
$lang['Upload_Avatar_URL_explain'] = 'Zadejte URL umístění obrázku postavičky, pro zkopírování na tento server.';
$lang['Pick_local_Avatar'] = 'Zvolte obrázek postavičky z galerie';
$lang['Link_remote_Avatar'] = 'Odkaz na vzdálený obrázek postavičky';
$lang['Link_remote_Avatar_explain'] = 'Zadejte URL umístění obrázku postavičky, na který chcete odkázat.';
$lang['Avatar_URL'] = 'URL adresa obrázku s postavičkou';
$lang['Select_from_gallery'] = 'Zvolte obrázek postavičky z galerie';
$lang['View_avatar_gallery'] = 'Zobrazit galerii postaviček';

$lang['Select_avatar'] = 'Zvolte obrázek postavičky';
$lang['Return_profile'] = 'Návrat do nastavení';
$lang['Select_category'] = 'Volba kategorie';

$lang['Delete_Image'] = 'Odstranit obrázek';
$lang['Current_Image'] = 'Aktuální obrázek';

$lang['Notify_on_privmsg'] = 'Upozornit na příchod nové soukromé zprávy';
$lang['Popup_on_privmsg'] = 'Otevřít nové okno při příchodu nové soukromé zprávy';
$lang['Popup_on_privmsg_explain'] = 'Některé šablony mohou otevřít nové okno, aby vás informovaly o nově příchozí soukromé zprávě.';
$lang['Hide_user'] = 'Skrýt vaší přítomnost ve fóru';

$lang['Profile_updated'] = 'Vaše nastavení bylo aktualizováno.';
$lang['Profile_updated_inactive'] = 'Vaše nastavení bylo aktualizováno, ale jelikož jste změnil(a) důležité informace je nyní váš účet neaktivní. Zkontrolujte váš e-mail pro informace jak jej znovu aktivovat nebo pokud je nutná administrátorská aktivace počkejte až administrátor váš účet znovu aktivuje.';

$lang['Password_mismatch'] = 'Zadaná hesla se neshodují.';
$lang['Current_password_mismatch'] = 'Vámi zadané aktuální heslo není správné.';
$lang['Password_long'] = 'Vaše heslo nesmí přesahovat 32 znaků.';
$lang['Username_taken'] = 'Promiňte, ale tento uživatel je již registrován.';
$lang['Username_invalid'] = 'Promiňte, ale toto uživatelské jméno obsahuje nepovolené znaky.';
$lang['Username_disallowed'] = 'Promiňte, ale toto uživatelské jméno je zakázáno.';
$lang['Email_taken'] = 'Promiňte, ale tuto e-mailovou adresu má již registrována některý uživatel.';
$lang['Email_banned'] = 'Promiňte, ale tato e-mailová adresa byla zakázána.';
$lang['Email_invalid'] = 'Promiňte, tato e-mailová adresa není platná.';
$lang['Signature_too_long'] = 'Váš podpis je příliš dlouhý.';
$lang['Fields_empty'] = 'Musíte zadat požadované údaje!';
$lang['Avatar_filetype'] = 'Obrázek postavičky musí být typu .jpg, .gif nebo .png.';
$lang['Avatar_filesize'] = 'Soubor obrázku postavičky musí být menší než %d kB.'; // The avatar image file size must be less than 6 kB
$lang['Avatar_imagesize'] = 'Obrázek postavičky musí mít šířku maximálně %d bodů a výšku %d bodů.';

$lang['Welcome_subject'] = 'Vítejte na %s fóru'; // Welcome to my.com forums
$lang['New_account_subject'] = 'Nový uživatelský účet';
$lang['Account_activated_subject'] = 'Účet aktivován';

$lang['Account_added'] = 'Děkujeme za registraci, váš účet byl vytvořen. Nyní se můžete přihlásit pod svým jménem a heslem.';
$lang['Account_inactive'] = 'Váš uživatelský účet byl vytvořen. Ovšem tento board vyžaduje aktivaci účtu. Aktivační klíč vám byl zaslán na vámi poskytnutou e-mailovou adresu, kde se dozvíte bližší informace.';
$lang['Account_inactive_admin'] = 'Váš uživatelský účet byl vytvořen. Ovšem tento board vyžaduje aktivaci účtu administrátorem. Po aktivaci administrátorem budete vyrozuměn(a) na vaší e-mailové adrese.';
$lang['Account_active'] = 'Váš účet byl aktivován. Děkujeme za registraci.';
$lang['Account_active_admin'] = 'Účet byl aktivován.';
$lang['Reactivate'] = 'Reaktivujte si svůj účet!';
$lang['Already_activated'] = 'Váš účet jste již aktivoval.';
$lang['COPPA'] = 'Váš účet byl vytvořen ale nemusí být ještě akceptován. Pro potvrzení si přečtěte bližší informace v zaslaném e-mailu.';

$lang['Registration'] = 'Registrační podmínky';
$lang['Reg_agreement'] = 'Ačkoliv se administrátoři a moderátoři tohoto fóra pokusí odstranit nebo upravit jakýkoliv všeobecně nežádoucí materiál tak rychle, jak je to jen možné, je nemožné prohlédnout každý příspěvek. Proto musíte vzít na vědomí, že všechny příspěvky v tomto fóru vyjadřují pohledy a názory autora příspěvku a ne administrátorů, moderátorů a webmastera (mimo příspěvků od těchto lidí), a proto za ně nemohou být zodpovědní.<br /><br />Souhlasíte s tím, že nebudete posílat žádné hanlivé, neslušné, vulgární, nenávistné, zastrašující, sexuálně orientované nebo jiné materiály, které mohou porušovat zákony. Posílání takových materiálů vám může přivodit okamžité a permanentní vyhoštění z fóra (a váš ISP bude o vaší činnosti informován). IP adresa všech příspěvků je zaznamenávána pro případ potřeby vynucení těchto podmínek. Souhlasíte, že webmaster, administrátor a moderátoři tohoto fóra mají právo odstranit, upravit, přesunout nebo ukončit jakékoliv téma, kdykoliv zjistí, že odporuje těmto podmínkám. Jako uživatel souhlasíte, že jakékoliv informace, které vložíte, budou uloženy v databázi. Dokud nebudou tyto informace prozrazeny třetí straně bez vašeho svolení, nemohou být webmaster, administrátor a moderátoři činěni zodpovědnými za jakékoliv hackerské pokusy, které mohou vést k tomu, že data budou kompromitována.<br /><br />Systém tohoto fóra používá cookies k ukládání informací na vašem počítači. Tato cookies neobsahují žádné informace, které jste vložil, slouží jen ke zvýšení vašeho pohodlí při prohlížení. E-mailová adresa je používána jen pro potvrzení vašich registračních detailů a hesla (a pro posláni nového hesla, pokud jste zapomněl aktuální).<br /><br />Kliknutím na Registraci níže souhlasíte být vázaný těmito podmínkami.';

$lang['Agree_under_13'] = 'Souhlasím s těmito podmínkami a je mi <b>méně</b> než 13 let.';
$lang['Agree_over_13'] = 'Souhlasím s těmito podmínkami a je mi <b>více</b> než 13 let.';
$lang['Agree_not'] = 'Nesouhlasím s těmito podmínkami.';

$lang['Wrong_activation'] = 'Vámi poskytnutý aktivační klíč se neshoduje s žádným z databáze.';
$lang['Send_password'] = 'Zašlete mi nové heslo';
$lang['Password_updated'] = 'Nové heslo bylo vytvořeno, očekávejte e-mail s informacemi jak jej aktivovat.';
$lang['No_email_match'] = 'E-mailová adresa nesouhlasí s adresou přiřazenou k vašemu uživatelskému jménu.';
$lang['New_password_activation'] = 'Aktivace nového hesla';
$lang['Password_activated'] = 'Váš účet byl reaktivován. Pro přihlášení použijte heslo, která vám bylo zasláno e-mailem.';

$lang['Send_email_msg'] = 'Odeslat e-mail';
$lang['No_user_specified'] = 'Nebyl zvolen žádný uživatel';
$lang['User_prevent_email'] = 'Tento uživatel si nepřeje přijímat odpovědi e-mailem. Zkuste mu zaslat soukromou zprávu.';
$lang['User_not_exist'] = 'Tento uživatel neexistuje.';
$lang['CC_email'] = 'Odeslat kopii tohoto e-mailu sobě.';
$lang['Email_message_desc'] = 'Tato zpráva bude zaslána jako prostý text, nebude obsahovat žádné HTML ani značky. Adresa pro odpověď na tuto zprávu bude nastavena na vaši e-mailovou adresu.';
$lang['Flood_email_limit'] = 'Nemůžete nyní odeslat další e-mail, zkuste opakovat později.';
$lang['Recipient'] = 'Příjemce';
$lang['Email_sent'] = 'E-mail byl odeslán.';
$lang['Send_email'] = 'Odeslat e-mail';
$lang['Empty_subject_email'] = 'Musíte zadat předmět e-mailu!';
$lang['Empty_message_email'] = 'Musíte zadat text zprávy!';


//
// Visual confirmation system strings
//
$lang['Confirm_code_wrong'] = 'Vámi zadaný ověřovací kód není správný!';
$lang['Too_many_registers'] = 'Překročil jste maximální množství pokusů o registraci. Prosím, zkuste to znovu později.';
$lang['Confirm_code_impaired'] = 'Pokud si nejste jistý nebo je tento kód nečitelný, kontaktujte %sadministrátora%s, který vám rád pomůže.';
$lang['Confirm_code'] = 'Ověřovací kód';
$lang['Confirm_code_explain'] = 'Zapište kód přesně tak, jak ho vidíte. Je citlivý na malá a velká písmena a nulu poznáte podle přeškrtnutí.';


//
// Memberslist
//
$lang['Select_sort_method'] = 'Setřídit dle';
$lang['Sort'] = 'Setřídit';
$lang['Sort_Top_Ten'] = 'Nejčastější přispěvatelé';
$lang['Sort_Joined'] = 'Data registrace';
$lang['Sort_Username'] = 'Jména uživatele';
$lang['Sort_Location'] = 'Bydliště';
$lang['Sort_Posts'] = 'Počtu příspěvků';
$lang['Sort_Email'] = 'E-mailu';
$lang['Sort_Website'] = 'WWW stránky';
$lang['Sort_Ascending'] = 'Vzestupně';
$lang['Sort_Descending'] = 'Sestupně';
$lang['Order'] = 'Dle pořadí';


//
// Group control panel
//
$lang['Group_Control_Panel'] = 'Skupina - Ovládací panel';
$lang['Group_member_details'] = 'Detaily členství ve skupině';
$lang['Group_member_join'] = 'Vstoupit do skupiny';

$lang['Group_Information'] = 'Informace o skupině';
$lang['Group_name'] = 'Jméno skupiny';
$lang['Group_description'] = 'Popis skupiny';
$lang['Group_membership'] = 'Vaše členství';
$lang['Group_Members'] = 'Členové Skupiny';
$lang['Group_Moderator'] = 'Moderátor skupiny';
$lang['Pending_members'] = 'Čekající členové';

$lang['Group_type'] = 'Typ skupiny';
$lang['Group_open'] = 'Otevřená skupina';
$lang['Group_closed'] = 'Uzavřená skupina';
$lang['Group_hidden'] = 'Skrytá skupina';

$lang['Current_memberships'] = 'Aktuální členství';
$lang['Non_member_groups'] = 'Skupiny bez členů';
$lang['Memberships_pending'] = 'Čekací členství';

$lang['No_groups_exist'] = 'Neexistuje žádná skupina.';
$lang['Group_not_exist'] = 'Tato skupina neexistuje.';

$lang['Join_group'] = 'Přihlásit se do skupiny';
$lang['No_group_members'] = 'Tato skupina nemá žádné členy.';
$lang['Group_hidden_members'] = 'Tato skupina je skrytá, nemůžete vidět seznam jejích členů.';
$lang['No_pending_group_members'] = 'Tato skupina nemá čekající členy.';
$lang['Group_joined'] = 'Úspěšně jste vstoupil do této skupiny<br />Budete informován až bude váš vstup moderátorem této skupiny odsouhlasen.';
$lang['Group_request'] = 'Vaše žádost o vstup do skupiny byla odeslána.';
$lang['Group_approved'] = 'Vaše žádost byla odsouhlasena.';
$lang['Group_added'] = 'Byl jste přijat do této skupiny.';
$lang['Already_member_group'] = 'Již jste členem této skupiny.';
$lang['User_is_member_group'] = 'Uživatel již je členem této skupiny.';
$lang['Group_type_updated'] = 'Typ skupiny byl úspěšně aktualizován.';

$lang['Could_not_add_user'] = 'Zvolený uživatel neexistuje.';
$lang['Could_not_anon_user'] = 'Anonymní uživatel nemůže být členem skupiny.';

$lang['Confirm_unsub'] = 'Opravdu chcete ukončit členství v této skupině?';
$lang['Confirm_unsub_pending'] = 'Vaše členství v této skupině zatím nebylo odsouhlaseno, opravdu je chcete ukončit?';

$lang['Unsub_success'] = 'Přestal jste být členem této skupiny.';

$lang['Approve_selected'] = 'Akceptovat zvolené';
$lang['Deny_selected'] = 'Zamítnout zvolené';
$lang['Not_logged_in'] = ' Pro vstup do skupiny musíte být přihlášen.';
$lang['Remove_selected'] = 'Odstranit zvolené';
$lang['Add_member'] = 'Přidat člena';
$lang['Not_group_moderator'] = 'Nejste moderátorem této skupiny, proto nemůžete provést tuto akci.';

$lang['Login_to_join'] = 'Přihlásit pro vstup do skupiny nebo úpravy členství.';
$lang['This_open_group'] = 'Toto je otevřená skupina, klikněte pro požádání o členství.';
$lang['This_closed_group'] = 'Toto je uzavřená skupina, žádní další uživatelé nejsou příjímáni.';
$lang['This_hidden_group'] = 'Toto je skrytá skupina, automatické přidávání uživatelů není dovoleno.';
$lang['Member_this_group'] = 'Jste členem této skupiny.';
$lang['Pending_this_group'] = 'Vaše členství v této skupině čeká na odsouhlasení.';
$lang['Are_group_moderator'] = 'Jste moderátorem skupiny.';
$lang['None'] = 'nikdo není přítomen';

$lang['Subscribe'] = 'Požádat o členství';
$lang['Unsubscribe'] = 'Ukončit členství';
$lang['View_Information'] = 'Zobrazit informace';


//
// Search
//
$lang['Search_query'] = 'Hledaný řetězec';
$lang['Search_options'] = 'Možnosti hledání';

$lang['Search_keywords'] = 'Klíčová slova';
$lang['Search_keywords_explain'] = 'Můžete použít <u>AND</u> pro slova, která musí být ve výsledcích, <u>OR</u> pro taková, která tam mohou náležet a <u>NOT</u> pro taková, která by ve výsledcích neměla být. Znak "*" nahradí část řetězce při vyhledávání.';
$lang['Search_author'] = 'Autora';
$lang['Search_author_explain'] = 'Znak "*" nahradí část řetězce při vyhledávání.';

$lang['Search_for_any'] = 'Hledej kterékoliv slovo nebo výraz jak je zadaný';
$lang['Search_for_all'] = 'Hledej všechna slova';
$lang['Search_title_msg'] = 'Hledej název tématu a text zprávy';
$lang['Search_msg_only'] = 'Hledat jen text zprávy';

$lang['Return_first'] = 'Zobraz prvních'; // followed by xxx characters in a select box
$lang['characters_posts'] = 'znaků z příspěvku';

$lang['Search_previous'] = 'Prohledej předchozí'; // followed by days, weeks, months, year, all in a select box

$lang['Sort_by'] = 'Setřídit dle';
$lang['Sort_Time'] = 'Čas odeslání';
$lang['Sort_Post_Subject'] = 'Předmětu';
$lang['Sort_Topic_Title'] = 'Hlavičky tématu';
$lang['Sort_Author'] = 'Autora';
$lang['Sort_Forum'] = 'Fóra';

$lang['Display_results'] = 'Zobrazit výsledek jako';
$lang['All_available'] = 'Všechny dostupné';
$lang['No_searchable_forums'] = 'Pokud nechcete povolit vyhledávání v libovolných fórech tohoto serveru';

$lang['No_search_match'] = 'Žádné téma nebo příspěvek nebyl nalezen dle zvolených kritérií.';
$lang['Found_search_match'] = 'Byl nalezen %d výsledek hledání.'; // eg. Search found 1 match
$lang['Found_search_matches'] = 'Bylo nalezeno %d výsledků hledání.'; // eg. Search found 24 matches

$lang['Search_Flood_Error'] = 'Nemůžete provést další hledání takto brzy po předchozím hledání, chvíli vyčkejte a zkuste to znovu.';

$lang['Close_window'] = 'Zavřít okno';


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = 'Promiňte, ale jen %s mohou posílat oznámení do tohoto fóra.';
$lang['Sorry_auth_sticky'] = 'Promiňte, ale jen %s mohou posílat důležité zprávy do tohoto fóra.';
$lang['Sorry_auth_read'] = 'Promiňte, ale jen %s mohou číst témata v tomto fóru.';
$lang['Sorry_auth_post'] = 'Promiňte, ale jen %s mohou posílat témata do tohoto fóra.';
$lang['Sorry_auth_reply'] = 'Promiňte, ale jen %s mohou odpovídat na příspěvky v tomto fóru.';
$lang['Sorry_auth_edit'] = 'Promiňte, ale jen %s mohou upravovat příspěvky v tomto fóru.';
$lang['Sorry_auth_delete'] = 'Promiňte, ale jen %s mohou mazat příspěvky v tomto fóru.';
$lang['Sorry_auth_vote'] = 'Promiňte, ale jen %s mohou hlasovat v hlasování tohoto fóra.';

// These replace the %s in the above strings
$lang['Auth_Anonymous_Users'] = '<b>anonymní uživatelé</b>';
$lang['Auth_Registered_Users'] = '<b>registrovaní uživatelé</b>';
$lang['Auth_Users_granted_access'] = '<b>uživatelé se zvláštním oprávněním</b>';
$lang['Auth_Moderators'] = '<b>moderátoři</b>';
$lang['Auth_Administrators'] = '<b>administrátoři</b>';

$lang['Not_Moderator'] = 'Nejste moderátorem tohoto fóra.';
$lang['Not_Authorised'] = 'Neautorizovaný';

$lang['You_been_banned'] = 'Byl jste vykázán z tohoto fóra<br />Prosím kontaktujte webmastera nebo administrátora tohoto fóra pro získání bližších informací.';


//
// Viewonline
//
$lang['Reg_users_zero_online'] = 'Je zde 0 registrovaných uživatelů a '; // There ae 5 Registered and
$lang['Reg_users_online'] = 'Je zde %d registrovaných uživatelů a '; // There ae 5 Registered and
$lang['Reg_user_online'] = 'Je zde %d registrovaný uživatel a '; // There ae 5 Registered and
$lang['Hidden_users_zero_online'] = '0 skrytých uživatelů.'; // 6 Hidden users online
$lang['Hidden_users_online'] = '%d skrytých uživatelů.'; // 6 Hidden users online
$lang['Hidden_user_online'] = '%d skrytý uživatel.'; // 6 Hidden users online
$lang['Guest_users_online'] = 'Je zde %d anonymních uživatelů.'; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = 'Je zde 0 anonymních uživatelů.'; // There are 10 Guest users online
$lang['Guest_user_online'] = 'Je zde %d anonymní uživatel.'; // There is 1 Guest user online
$lang['No_users_browsing'] = 'Momentálně zde nejsou žádní uživatelé.';

$lang['Online_explain'] = 'Tato data jsou založena na aktivitě uživatelů během posledních 5 minut.';

$lang['Forum_Location'] = 'Nachází se';
$lang['Last_updated'] = 'Poslední aktualizace';

$lang['Forum_index'] = 'Obsah fóra';
$lang['Logging_on'] = 'Přihlašuje se';
$lang['Posting_message'] = 'Odesílá zprávu';
$lang['Searching_forums'] = 'Prohledává fóra';
$lang['Viewing_profile'] = 'Prohlíží nastavení';
$lang['Viewing_online'] = 'Prohlíží seznam přítomných uživatelů';
$lang['Viewing_member_list'] = 'Prohlíží seznam uživatelů';
$lang['Viewing_priv_msgs'] = 'Prohlíží soukromé zprávy';
$lang['Viewing_FAQ'] = 'prohlíží FAQ';


//
// Moderator Control Panel
//
$lang['Mod_CP'] = 'Moderátor - Ovládací panel';
$lang['Mod_CP_explain'] = 'Pomocí následujícího formuláře můžete provádět hromadné zásahy do tohoto fóra. Můžete zamykat, odemykat, přesouvat a mazat jakýkoliv počet témat.';

$lang['Select'] = 'Zvolit';
$lang['Delete'] = 'Odstranit';
$lang['Move'] = 'Přesunout';
$lang['Lock'] = 'Zamknout';
$lang['Unlock'] = 'Odemknout';

$lang['Topics_Removed'] = 'Zvolená témata byla úspěšně odstraněna z databáze.';
$lang['Topics_Locked'] = 'Zvolená témata byla uzamknuta.';
$lang['Topics_Moved'] = 'Zvolená témata byla přesunuta.';
$lang['Topics_Unlocked'] = 'Zvolená témata byla odemknuta.';
$lang['No_Topics_Moved'] = 'Žádná témata nebyla přesunuta.';

$lang['Confirm_delete_topic'] = 'Opravdu chcete odstranit zvolená témata?';
$lang['Confirm_lock_topic'] = 'Opravdu chcete zamknout zvolená témata?';
$lang['Confirm_unlock_topic'] = 'Opravdu chcete odemknout zvolená témata?';
$lang['Confirm_move_topic'] = 'Opravdu chcete přesunout zvolená témata?';

$lang['Move_to_forum'] = 'Přesunout do fóra';
$lang['Leave_shadow_topic'] = 'Ponechat stínové téma ve starém fóru?';

$lang['Split_Topic'] = 'Rozdělení tématu - Ovládací panel';
$lang['Split_Topic_explain'] = 'Pomocí následujícího formuláře můžete téma rozdělit na dvě, buď vybráním příspěvků jednotlivě, nebo rozdělením od vybraného příspěvku.';
$lang['Split_title'] = 'Titulek nového tématu';
$lang['Split_forum'] = 'Forum pro nové téma';
$lang['Split_posts'] = 'Rozdělit vybrané příspěvky';
$lang['Split_after'] = 'Rozdělit od vybraného příspěvku';
$lang['Topic_split'] = 'Vybrané téma bylo úspěšně rozděleno';

$lang['Too_many_error'] = 'Vybral(a) jste příliš mnoho příspěvků. Můžete vybrat pouze jeden příspěvek, od kterého chcete téma rozdělit!';

$lang['None_selected'] = 'Nebylo vybrání žádné téma pro vykonání této operace. Proveďte návrat zpět a zvolte alespoň jedno téma!';
$lang['New_forum'] = 'Nové fórum';

$lang['This_posts_IP'] = 'IP adresa příspěvku';
$lang['Other_IP_this_user'] = 'Další IP adresy ze kterých uživatel odesílal příspěvky';
$lang['Users_this_IP'] = 'Uživatelé zasílající příspěvek z této IP adresy';
$lang['IP_info'] = 'Informace o IP adrese';
$lang['Lookup_IP'] = 'Hledat IP adresu';


//
// Timezones ... for display on each page
//
$lang['All_times'] = 'Časy uváděny v %s'; // eg. All times are GMT - 12 Hours (times from next block)

$lang['-12'] = 'GMT - 12 hodin';
$lang['-11'] = 'GMT - 11 hodin';
$lang['-10'] = 'GMT - 10 hodin';
$lang['-9'] = 'GMT - 9 hodin';
$lang['-8'] = 'GMT - 8 hodin';
$lang['-7'] = 'GMT - 7 hodin';
$lang['-6'] = 'GMT - 6 hodin';
$lang['-5'] = 'GMT - 5 hodin';
$lang['-4'] = 'GMT - 4 hodiny';
$lang['-3.5'] = 'GMT - 3.5 hodiny';
$lang['-3'] = 'GMT - 3 hodiny';
$lang['-2'] = 'GMT - 2 hodiny';
$lang['-1'] = 'GMT - 1 hodina';
$lang['0'] = 'GMT';
$lang['1'] = 'GMT + 1 hodina';
$lang['2'] = 'GMT + 2 hodiny';
$lang['3'] = 'GMT + 3 hodiny';
$lang['3.5'] = 'GMT + 3.5 hodiny';
$lang['4'] = 'GMT + 4 hodiny';
$lang['4.5'] = 'GMT + 4.5 hodiny';
$lang['5'] = 'GMT + 5 hodin';
$lang['5.5'] = 'GMT + 5.5 hodiny';
$lang['6'] = 'GMT + 6 hodin';
$lang['6.5'] = 'GMT + 6.5 hodiny';
$lang['7'] = 'GMT + 7 hodin';
$lang['8'] = 'GMT + 8 hodin';
$lang['9'] = 'GMT + 9 hodin';
$lang['9.5'] = 'GMT + 9.5 hodin';
$lang['10'] = 'GMT + 10 hodin';
$lang['11'] = 'GMT + 11 hodin';
$lang['12'] = 'GMT + 12 hodin';
$lang['13'] = 'GMT + 13 hodin';

// These are displayed in the timezone select box
$lang['tz']['-12'] = '(GMT -12:00 hodin) Eniwetok, Kwajalein';
$lang['tz']['-11'] = '(GMT -11:00 hodin) Midway Island, Samoa';
$lang['tz']['-10'] = '(GMT -10:00 hodin) Hawaii';
$lang['tz']['-9'] = '(GMT -9:00 hodin) Alaska';
$lang['tz']['-8'] = '(GMT -8:00 hodin) Pacific Time (US &amp; Canada), Tijuana';
$lang['tz']['-7'] = '(GMT -7:00 hodin) Mountain Time (US &amp; Canada), Arizona';
$lang['tz']['-6'] = '(GMT -6:00 hodin) Central Time (US &amp; Canada), Mexico City';
$lang['tz']['-5'] = '(GMT -5:00 hodin) Eastern Time (US &amp; Canada), Bogota, Lima, Quito';
$lang['tz']['-4'] = '(GMT -4:00 hodiny) Atlantic Time (Canada), Caracas, La Paz';
$lang['tz']['-3.5'] = '(GMT -3.5 hodiny) Newfoundland';
$lang['tz']['-3'] = '(GMT -3:00 hodiny) Brassila, Buenos Aires, Georgetown, Falkland Is';
$lang['tz']['-2'] = '(GMT -2:00 hodiny) Mid-Atlantic, Ascension Is., St. Helena';
$lang['tz']['-1'] = '(GMT -1:00 hodina) Azores, Cape Verde Islands';
$lang['tz']['0'] = '(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia';
$lang['tz']['1'] = '(GMT +1:00 hodina) Prague, Amsterdam, Berlin, Brussels, Madrid, Paris';
$lang['tz']['2'] = '(GMT +2:00 hodiny) Cairo, Helsinki, Kaliningrad, South Africa';
$lang['tz']['3'] = '(GMT +3:00 hodiny) Baghdad, Riyadh, Moscow, Nairobi';
$lang['tz']['3.5'] = '(GMT +3.5 hodiny) Tehran';
$lang['tz']['4'] = '(GMT +4:00 hodiny) Abu Dhabi, Baku, Muscat, Tbilisi';
$lang['tz']['4.5'] = '(GMT +4.5 hodiny) Kabul';
$lang['tz']['5'] = '(GMT +5:00 hodin) Ekaterinburg, Islamabad, Karachi, Tashkent';
$lang['tz']['5.5'] = '(GMT +5.5 hodiny) Bombay, Calcutta, Madras, New Delhi';
$lang['tz']['6'] = '(GMT +6:00 hodin) Almaty, Colombo, Dhaka, Novosibirsk';
$lang['tz']['6.5'] = '(GMT +6.5 hodiny) Rangoon';
$lang['tz']['7'] = '(GMT +7:00 hodin) Bangkok, Hanoi, Jakarta';
$lang['tz']['8'] = '(GMT +8:00 hodin) Beijing, Hong Kong, Perth, Singapore, Taipei';
$lang['tz']['9'] = '(GMT +9:00 hodin) Osaka, Sapporo, Seoul, Tokyo, Yakutsk';
$lang['tz']['9.5'] = '(GMT +9.5 hodiny) Adelaide, Darwin';
$lang['tz']['10'] = '(GMT +10:00 hodin) Canberra, Guam, Melbourne, Sydney, Vladivostok';
$lang['tz']['11'] = '(GMT +11:00 hodin) Magadan, New Caledonia, Solomon Islands';
$lang['tz']['12'] = '(GMT +12:00 hodin) Auckland, Wellington, Fiji, Marshall Island';
$lang['tz']['13'] = '(GMT +13:00 hodin) Nuku\'alofa';

$lang['datetime']['Sunday'] = 'neděle';
$lang['datetime']['Monday'] = 'pondělí';
$lang['datetime']['Tuesday'] = 'úterý';
$lang['datetime']['Wednesday'] = 'středa';
$lang['datetime']['Thursday'] = 'čtvrtek';
$lang['datetime']['Friday'] = 'pátek';
$lang['datetime']['Saturday'] = 'sobota';
$lang['datetime']['Sun'] = 'ne';
$lang['datetime']['Mon'] = 'po';
$lang['datetime']['Tue'] = 'út';
$lang['datetime']['Wed'] = 'st';
$lang['datetime']['Thu'] = 'čt';
$lang['datetime']['Fri'] = 'pá';
$lang['datetime']['Sat'] = 'so';
$lang['datetime']['January'] = 'leden';
$lang['datetime']['February'] = 'únor';
$lang['datetime']['March'] = 'březen';
$lang['datetime']['April'] = 'duben';
$lang['datetime']['May'] = 'květen';
$lang['datetime']['June'] = 'červen';
$lang['datetime']['July'] = 'červenec';
$lang['datetime']['August'] = 'srpen';
$lang['datetime']['September'] = 'září';
$lang['datetime']['October'] = 'říjen';
$lang['datetime']['November'] = 'listopad';
$lang['datetime']['December'] = 'prosinec';
$lang['datetime']['Jan'] = 'leden';
$lang['datetime']['Feb'] = 'únor';
$lang['datetime']['Mar'] = 'březen';
$lang['datetime']['Apr'] = 'duben';
$lang['datetime']['May'] = 'květen';
$lang['datetime']['Jun'] = 'červen';
$lang['datetime']['Jul'] = 'červenec';
$lang['datetime']['Aug'] = 'srpen';
$lang['datetime']['Sep'] = 'září';
$lang['datetime']['Oct'] = 'říjen';
$lang['datetime']['Nov'] = 'listopad';
$lang['datetime']['Dec'] = 'prosinec';

$lang['TRANSLATION_INFO'] = 'Český překlad <a href="http://www.phpbbcz.com" target="_blank">phpBB Czech - www.phpbbcz.com</a>';

//
// Errors (not related to a
// specific failure on a page)
//
$lang['Information'] = 'Informace';
$lang['Critical_Information'] = 'Kritická informace';

$lang['General_Error'] = 'Všeobecná chyba';
$lang['Critical_Error'] = 'Kritická chyba';
$lang['An_error_occured'] = 'Objevila se chyba';
$lang['A_critical_error'] = 'Objevila se kritická chyba';

$lang['Admin_reauthenticate'] = 'Pro vstup do administrátorské sekce se musíte znovu přihlásit';

$lang['Login_attempts_exceeded'] = 'Byl překročen maximální počet pokusů o přihlášení (%s). Následujících %s minut nebudete mít povoleno se přihlásit.';
$lang['Please_remove_install_contrib'] = 'Zkontrolujte zda jsou odstraněny složky install/ a contrib/.';

//
// That's all Folks!
// -------------------------------------------------
?>
