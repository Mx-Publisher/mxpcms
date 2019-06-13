<?php
/***************************************************************************
 *                            lang_main.php [Dutch]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_main.php,v 1.85.2.21 2006/02/05 15:59:48 grahamje Exp $
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
// Add your details here if wanted, e.g. Name, username, email address, website
// Lennart Goosens, LGoosens, webmaster@warpcore.tk, www.warpcore.tk
// This language was previously maintained by Stefan Koopmanschap
//
// phpBB version(s): 2.0.0 - 2.0.22
//
// Using this translation on a higher version number may result in confusing
// situations with missing text and captions.
//
// Please do NOT remove the author's notice from the page footer; I've worked
// very hard on this and you should be glad you may benefit from it.
//

//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

$lang['ENCODING'] = 'iso-8859-1';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'left';
$lang['RIGHT'] = 'right';
$lang['DATE_FORMAT'] = 'd M Y'; // This should be changed to the default date format for your language, php date() format

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
$lang['TRANSLATION'] = 'Vertaling door <a href="http://www.warpcore.tk/" target="_blank">Lennart Goosens</a>.';

//
// Common, these terms are used
// extensively on several pages
//
$lang['Forum'] = 'Forum';
$lang['Category'] = 'Categorie';
$lang['Topic'] = 'Onderwerp';
$lang['Topics'] = 'Onderwerpen';
$lang['Replies'] = 'Antwoorden';
$lang['Views'] = 'Bekeken';
$lang['Post'] = 'Bericht';
$lang['Posts'] = 'Berichten';
$lang['Posted'] = 'Geplaatst';
$lang['Username'] = 'Gebruikersnaam';
$lang['Password'] = 'Wachtwoord';
$lang['Email'] = 'E-mail';
$lang['Poster'] = 'Gebruiker';
$lang['Author'] = 'Auteur';
$lang['Time'] = 'Tijd';
$lang['Hours'] = 'Uur';
$lang['Message'] = 'Bericht';

$lang['1_Day'] = '1 Dag';
$lang['7_Days'] = '7 Dagen';
$lang['2_Weeks'] = '2 Weken';
$lang['1_Month'] = '1 Maand';
$lang['3_Months'] = '3 Maanden';
$lang['6_Months'] = '6 Maanden';
$lang['1_Year'] = '1 Jaar';

$lang['Go'] = 'OK';
$lang['Jump_to'] = 'Ga naar';
$lang['Submit'] = 'Verzenden';
$lang['Reset'] = 'Herstellen';
$lang['Cancel'] = 'Annuleren';
$lang['Preview'] = 'Voorbeeld';
$lang['Confirm'] = 'Bevestigen';
$lang['Spellcheck'] = 'Spellingcontrole';
$lang['Yes'] = 'Ja';
$lang['No'] = 'Nee';
$lang['Enabled'] = 'Ingeschakeld';
$lang['Disabled'] = 'Uitgeschakeld';
$lang['Error'] = 'Fout';

$lang['Next'] = 'Volgende';
$lang['Previous'] = 'Vorige';
$lang['Goto_page'] = 'Ga naar pagina';
$lang['Joined'] = 'Geregistreerd op';
$lang['IP_Address'] = 'IP-adres';

$lang['Select_forum'] = 'Kies een forum';
$lang['View_latest_post'] = 'Laatste bericht bekijken';
$lang['View_newest_post'] = 'Nieuwste bericht bekijken';
$lang['Page_of'] = 'Pagina <b>%d</b> van <b>%d</b>'; // Replaces with: Page 1 of 2 for example

$lang['ICQ'] = 'ICQ-nummer';
$lang['AIM'] = 'AIM-naam';
$lang['MSNM'] = 'MSN Messenger';
$lang['YIM'] = 'Yahoo Messenger';

$lang['Forum_Index'] = '%s Forumindex';  // eg. sitename Forum Index, %s can be removed if you prefer

$lang['Post_new_topic'] = 'Nieuw onderwerp plaatsen';
$lang['Reply_to_topic'] = 'Reageren';
$lang['Reply_with_quote'] = 'Reageren met citaat';

$lang['Click_return_topic'] = 'Klik %shier%s om terug te keren naar het onderwerp'; // %s's here are for uris, do not remove!
$lang['Click_return_login'] = 'Klik %shier%s om het nogmaals te proberen';
$lang['Click_return_forum'] = 'Klik %shier%s om terug te keren naar de onderwerpenlijst';
$lang['Click_view_message'] = 'Klik %shier%s om je bericht te bekijken';
$lang['Click_return_modcp'] = 'Klik %shier%s om terug te keren naar het Moderator Controlepaneel';
$lang['Click_return_group'] = 'Klik %shier%s om terug te keren naar het groepenoverzicht';

$lang['Admin_panel'] = 'Beheerderspaneel openen';

$lang['Board_disable'] = 'Sorry, maar dit forum is tijdelijk buiten gebruik. Probeer het later nog eens.';


//
// Global Header strings
//
$lang['Registered_users'] = 'Actieve leden:';
$lang['Browsing_forum'] = 'Gebruikers op dit forum:';
$lang['Online_users_zero_total'] = 'Er zijn in totaal <b>0</b> gebruikers online :: ';
$lang['Online_users_total'] = 'Er zijn in totaal <b>%d</b> gebruikers online :: ';
$lang['Online_user_total'] = 'Er is in totaal <b>%d</b> gebruiker online :: ';
$lang['Reg_users_zero_total'] = '0 Geregistreerd, ';
$lang['Reg_users_total'] = '%d Geregisteerd, ';
$lang['Reg_user_total'] = '%d Geregisteerd, ';
$lang['Hidden_users_zero_total'] = '0 verborgen en ';
$lang['Hidden_user_total'] = '%d verborgen en ';
$lang['Hidden_users_total'] = '%d verborgen en ';
$lang['Guest_users_zero_total'] = '0 gasten';
$lang['Guest_users_total'] = '%d gasten';
$lang['Guest_user_total'] = '%d gast';
$lang['Record_online_users'] = 'Grootst aantal gebruikers online was <b>%s</b> op %s'; // first %s = number of users, second %s is the date.

$lang['Admin_online_color'] = '%sBeheerder%s';
$lang['Mod_online_color'] = '%sModerator%s';

$lang['You_last_visit'] = 'Je laatste bezoek was op %s'; // %s replaced by date/time
$lang['Current_time'] = 'Het is nu %s'; // %s replaced by time

$lang['Search_new'] = 'Berichten sinds laatste bezoek bekijken';
$lang['Search_your_posts'] = 'Jouw berichten bekijken';
$lang['Search_unanswered'] = 'Onbeantwoorde berichten bekijken';

$lang['Register'] = 'Registreren';
$lang['Profile'] = 'Profiel';
$lang['Edit_profile'] = 'Profiel bewerken';
$lang['Search'] = 'Zoeken';
$lang['Memberlist'] = 'Gebruikerslijst';
$lang['FAQ'] = 'FAQ';
$lang['BBCode_guide'] = 'BBCode overzicht';
$lang['Usergroups'] = 'Gebruikersgroepen';
$lang['Last_Post'] = 'Laatste bericht';
$lang['Moderator'] = 'Moderator';
$lang['Moderators'] = 'Moderators';


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = 'De gebruikers hebben in totaal <b>0</b> berichten geplaatst'; // Number of posts
$lang['Posted_articles_total'] = 'De gebruikers hebben in totaal <b>%d</b> berichten geplaatst'; // Number of posts
$lang['Posted_article_total'] = 'De gebruikers hebben in totaal <b>%d</b> bericht geplaatst'; // Number of posts
$lang['Registered_users_zero_total'] = 'We hebben <b>0</b> geregistreerde gebruikers'; // # registered users
$lang['Registered_users_total'] = 'We hebben <b>%d</b> geregistreerde gebruikers'; // # registered users
$lang['Registered_user_total'] = 'We hebben <b>%d</b> geregistreerde gebruiker'; // # registered users
$lang['Newest_user'] = 'De nieuwste gebruiker is <b>%s%s%s</b>'; // a href, username, /a

$lang['No_new_posts_last_visit'] = 'Geen nieuwe berichten sinds je laatste bezoek';
$lang['No_new_posts'] = 'Geen nieuwe berichten';
$lang['New_posts'] = 'Nieuwe berichten';
$lang['New_post'] = 'Nieuw bericht';
$lang['No_new_posts_hot'] = 'Geen nieuwe berichten [ Populair ]';
$lang['New_posts_hot'] = 'Nieuwe berichten [ Populair ]';
$lang['No_new_posts_locked'] = 'Geen nieuwe berichten [ Gesloten ]';
$lang['New_posts_locked'] = 'Nieuwe berichten [ Gesloten ]';
$lang['Forum_is_locked'] = 'Forum is gesloten';


//
// Login
//
$lang['Enter_password'] = 'Vul je gebruikersnaam en wachtwoord in om in te loggen';
$lang['Login'] = 'Inloggen';
$lang['Logout'] = 'Uitloggen';

$lang['Forgotten_password'] = 'Ik ben mijn wachtwoord vergeten';

$lang['Log_me_in'] = 'Log me automatisch in bij elk bezoek';

$lang['Error_login'] = 'Je hebt een foutieve of inactieve gebruikersnaam of een foutief wachtwoord opgegeven.';


//
// Index page
//
$lang['Index'] = 'Index';
$lang['No_Posts'] = 'Geen berichten';
$lang['No_forums'] = 'Dit forum heeft geen subfora';

$lang['Private_Message'] = 'Priv&eacute;bericht';
$lang['Private_Messages'] = 'Priv&eacute;berichten';
$lang['Who_is_Online'] = 'Wie zijn er online?';

$lang['Mark_all_forums'] = 'Alle fora als gelezen markeren';
$lang['Forums_marked_read'] = 'Alle fora zijn als gelezen gemarkeerd';


//
// Viewforum
//
$lang['View_forum'] = 'Subforum bekijken';

$lang['Forum_not_exist'] = 'Het subforum dat je gekozen hebt bestaat niet.';
$lang['Reached_on_error'] = 'Je hebt deze pagina per abuis bereikt.';

$lang['Display_topics'] = 'Onderwerpen van afgelopen';
$lang['All_Topics'] = 'Alle onderwerpen';

$lang['Topic_Announcement'] = '<b>Mededeling:</b>';
$lang['Topic_Sticky'] = '<b>Sticky:</b>';
$lang['Topic_Moved'] = '<b>Verplaatst:</b>';
$lang['Topic_Poll'] = '<b>[ Poll ]</b>';

$lang['Mark_all_topics'] = 'Alle onderwerpen als gelezen markeren';
$lang['Topics_marked_read'] = 'Alle onderwerpen in dit forum zijn als gelezen gemarkeerd';

$lang['Rules_post_can'] = 'Je <b>mag</b> nieuwe onderwerpen plaatsen in dit subforum';
$lang['Rules_post_cannot'] = 'Je <b>mag geen</b> nieuwe onderwerpen plaatsen in dit subforum';
$lang['Rules_reply_can'] = 'Je <b>mag</b> reacties plaatsen in dit subforum';
$lang['Rules_reply_cannot'] = 'Je <b>mag geen</b> reacties plaatsen in dit subforum';
$lang['Rules_edit_can'] = 'Je <b>mag</b> je berichten bewerken in dit subforum';
$lang['Rules_edit_cannot'] = 'Je <b>mag</b> je berichten <b>niet</b> bewerken in dit subforum';
$lang['Rules_delete_can'] = 'Je <b>mag</b> je berichten verwijderen in dit subforum';
$lang['Rules_delete_cannot'] = 'Je <b>mag</b> je berichten <b>niet</b> verwijderen in dit subforum';
$lang['Rules_vote_can'] = 'Je <b>mag</b> stemmen in polls in dit subforum';
$lang['Rules_vote_cannot'] = 'Je <b>mag niet</b> stemmen in polls in dit subforum';
$lang['Rules_moderate'] = 'Je <b>kunt</b> dit subforum %sbeheren%s'; // %s replaced by a href links, do not remove!

$lang['No_topics_post_one'] = 'Er zijn geen berichten in dit subforum.<br />Klik op de <b>Plaats Nieuw Onderwerp</b> link op deze pagina om een bericht te plaatsen.';


//
// Viewtopic
//
$lang['View_topic'] = 'Onderwerp bekijken';

$lang['Guest'] = 'Gast';
$lang['Post_subject'] = 'Onderwerp';
$lang['View_next_topic'] = 'Volgende onderwerp';
$lang['View_previous_topic'] = 'Vorige onderwerp';
$lang['Submit_vote'] = 'Stem uitbrengen';
$lang['View_results'] = 'Resultaten bekijken';

$lang['No_newer_topics'] = 'Er zijn geen nieuwere berichten in dit subforum';
$lang['No_older_topics'] = 'Er zijn geen oudere berichten in dit subforum';
$lang['Topic_post_not_exist'] = 'Het onderwerp of bericht dat je zoekt bestaat niet';
$lang['No_posts_topic'] = 'Er staan geen berichten in dit onderwerp';

$lang['Display_posts'] = 'Berichten van afgelopen';
$lang['All_Posts'] = 'Alle berichten';
$lang['Newest_First'] = 'Nieuwste eerst';
$lang['Oldest_First'] = 'Oudste eerst';

$lang['Back_to_top'] = 'Terug naar boven';

$lang['Read_profile'] = 'Profiel bekijken';
$lang['Visit_website'] = 'Website bekijken';
$lang['ICQ_status'] = 'ICQ Status';
$lang['Edit_delete_post'] = 'Bericht bewerken/verwijderen';
$lang['View_IP'] = 'IP-adres van deze gebruiker bekijken';
$lang['Delete_post'] = 'Bericht verwijderen';

$lang['wrote'] = 'schreef'; // proceeds the username and is followed by the quoted text
$lang['Quote'] = 'Citaat'; // comes before bbcode quote output.
$lang['Code'] = 'Code'; // comes before bbcode code output.

$lang['Edited_time_total'] = 'Laatst aangepast door %s op %s; in totaal %d keer bewerkt'; // Last edited by me on 12 Oct 2001; edited 1 time in total
$lang['Edited_times_total'] = 'Laatst aangepast door %s op %s; in totaal %d keer bewerkt'; // Last edited by me on 12 Oct 2001; edited 2 times in total

$lang['Lock_topic'] = 'Onderwerp sluiten';
$lang['Unlock_topic'] = 'Onderwerp heropenen';
$lang['Move_topic'] = 'Onderwerp verplaatsen';
$lang['Delete_topic'] = 'Onderwerp verwijderen';
$lang['Split_topic'] = 'Onderwerp splitsen';

$lang['Stop_watching_topic'] = 'Abonnement op dit onderwerp opzeggen';
$lang['Start_watching_topic'] = 'Abonneren op dit onderwerp';
$lang['No_longer_watching'] = 'Je wordt niet langer gewaarschuwd bij reacties op dit onderwerp';
$lang['You_are_watching'] = 'Je wordt vanaf nu gewaarschuwd bij reacties op dit onderwerp';

$lang['Total_votes'] = 'Totaal aantal stemmen';

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = 'Bericht';
$lang['Topic_review'] = 'Onderwerp nalezen';

$lang['No_post_mode'] = 'Er is geen actie aangegeven'; // If posting.php is called without a mode (newtopic/reply/delete/etc, shouldn't be shown normaly)

$lang['Post_a_new_topic'] = 'Plaats een nieuw onderwerp';
$lang['Post_a_reply'] = 'Plaats een reactie';
$lang['Post_topic_as'] = 'Soort bericht';
$lang['Edit_Post'] = 'Bericht bewerken';
$lang['Options'] = 'Opties';

$lang['Post_Announcement'] = 'Mededeling';
$lang['Post_Sticky'] = 'Sticky';
$lang['Post_Normal'] = 'Normaal';

$lang['Confirm_delete'] = 'Weet je zeker dat je dit bericht wil verwijderen?';
$lang['Confirm_delete_poll'] = 'Weet je zeker dat je deze poll wil verwijderen?';

$lang['Flood_Error'] = 'Je kan niet zo snel na je laatst geplaatste bericht een ander plaatsen, probeer het later nog eens.';
$lang['Empty_subject'] = 'Je moet een titel opgeven als je een nieuw onderwerp opent.';
$lang['Empty_message'] = 'Je moet een bericht typen bij het plaatsen van een bericht.';
$lang['Forum_locked'] = 'Dit subforum is gesloten. Het plaatsen of bewerken van berichten of onderwerpen is niet mogelijk.';
$lang['Topic_locked'] = 'Dit onderwerp is gesloten. Het plaatsen of bewerken van berichten is niet mogelijk.';
$lang['No_post_id'] = 'Je moet een bericht selecteren om te bewerken';
$lang['No_topic_id'] = 'Je moet een onderwerp selecteren om op te reageren';
$lang['No_valid_mode'] = 'Je kunt alleen berichten plaatsen, bewerken, citeren of er op reageren. Probeer het opnieuw.';
$lang['No_such_post'] = 'Het opgegeven bericht bestaat niet (meer). Probeer het opnieuw.';
$lang['Edit_own_posts'] = 'Sorry, maar je mag alleen je eigen berichten aanpassen.';
$lang['Delete_own_posts'] = 'Sorry, maar je mag alleen je eigen berichten verwijderen.';
$lang['Cannot_delete_replied'] = 'Sorry, maar je mag geen berichten verwijderen waar op geantwoord is.';
$lang['Cannot_delete_poll'] = 'Sorry, maar je kan geen actieve poll verwijderen.';
$lang['Empty_poll_title'] = 'Je moet een titel voor je poll invullen.';
$lang['To_few_poll_options'] = 'Je moet minimaal twee keuzemogelijkheden opgeven.';
$lang['To_many_poll_options'] = 'Je hebt te veel keuzemogelijkheden opgegeven.';
$lang['Post_has_no_poll'] = 'Dit onderwerp heeft geen poll.';
$lang['Already_voted'] = 'Je hebt al in deze poll gestemd.';
$lang['No_vote_option'] = 'Je moet een optie selecteren bij het stemmen.';

$lang['Add_poll'] = 'Voeg een poll toe';
$lang['Add_poll_explain'] = 'Indien je geen poll wilt maken, laat deze velden dan leeg.';
$lang['Poll_question'] = 'Poll-vraag';
$lang['Poll_option'] = 'Poll-keuze';
$lang['Add_option'] = 'Keuze toevoegen';
$lang['Update'] = 'Bijwerken';
$lang['Delete'] = 'Verwijderen';
$lang['Poll_for'] = 'Poll blijft geldig voor';
$lang['Days'] = 'dagen'; // This is used for the Run poll for ... Days + in admin_forums for pruning
$lang['Poll_for_explain'] = '[ Leeg laten of 0 invullen voor oneindig geldige poll ]';
$lang['Delete_poll'] = 'Verwijder poll';

$lang['Disable_HTML_post'] = 'HTML uitschakelen in dit bericht';
$lang['Disable_BBCode_post'] = 'BBCode uitschakelen in dit bericht';
$lang['Disable_Smilies_post'] = 'Smilies uitschakelen in dit bericht';

$lang['HTML_is_ON'] = 'HTML is <u>AAN</u>';
$lang['HTML_is_OFF'] = 'HTML is <u>UIT</u>';
$lang['BBCode_is_ON'] = '%sBBCode%s is <u>AAN</u>'; // %s are replaced with URI pointing to FAQ
$lang['BBCode_is_OFF'] = '%sBBCode%s is <u>UIT</u>';
$lang['Smilies_are_ON'] = 'Smilies staan <u>AAN</u>';
$lang['Smilies_are_OFF'] = 'Smilies staan <u>UIT</u>';

$lang['Attach_signature'] = 'Onderschrift toevoegen (dit kan aangepast worden in je profiel)';
$lang['Notify'] = 'Waarschuwen als er gereageerd is';

$lang['Stored'] = 'Je bericht is geplaatst.';
$lang['Deleted'] = 'Je bericht is verwijderd.';
$lang['Poll_delete'] = 'Je poll is verwijderd.';
$lang['Vote_cast'] = 'Je stem is uitgebracht.';

$lang['Topic_reply_notification'] = 'Melding van het plaatsen van een reactie';

$lang['bbcode_b_help'] = 'Vette tekst: [b]tekst[/b]  (alt+b)';
$lang['bbcode_i_help'] = 'Cursieve tekst: [i]tekst[/i]  (alt+i)';
$lang['bbcode_u_help'] = 'Onderstreepte tekst: [u]tekst[/u]  (alt+u)';
$lang['bbcode_q_help'] = 'Geciteerde tekst: [quote]tekst[/quote]  (alt+q)';
$lang['bbcode_c_help'] = 'Voorbeeld van code: [code]code[/code]  (alt+c)';
$lang['bbcode_l_help'] = 'Lijst: [list]tekst[/list] (alt+l)';
$lang['bbcode_o_help'] = 'Genummerde lijst: [list=]tekst[/list]  (alt+o)';
$lang['bbcode_p_help'] = 'Afbeelding invoegen: [img]http://url_afbeelding[/img]  (alt+p)';
$lang['bbcode_w_help'] = 'Hyperlink invoegen: [url]http://url[/url] of [url=http://url]Tekst van link[/url]  (alt+w)';
$lang['bbcode_a_help'] = 'Alle onafgesloten BBCode tags sluiten';
$lang['bbcode_s_help'] = 'Tekstkleur: [color=red]tekst[/color]  Tip: hexadecimale waarden zijn ook toegestaan: color=#FF0000';
$lang['bbcode_f_help'] = 'Tekstgrootte: [size=x-small]kleine tekst[/size]';

$lang['Emoticons'] = 'Emoticons';
$lang['More_emoticons'] = 'Meer emoticons';

$lang['Font_color'] = 'Tekstkleur';
$lang['color_default'] = 'Standaard';
$lang['color_dark_red'] = 'Donkerrood';
$lang['color_red'] = 'Rood';
$lang['color_orange'] = 'Oranje';
$lang['color_brown'] = 'Bruin';
$lang['color_yellow'] = 'Geel';
$lang['color_green'] = 'Groen';
$lang['color_olive'] = 'Olijf';
$lang['color_cyan'] = 'Cyaan';
$lang['color_blue'] = 'Blauw';
$lang['color_dark_blue'] = 'Donkerblauw';
$lang['color_indigo'] = 'Indigo';
$lang['color_violet'] = 'Violet';
$lang['color_white'] = 'Wit';
$lang['color_black'] = 'Zwart';

$lang['Font_size'] = 'Tekstgrootte';
$lang['font_tiny'] = 'Heel klein';
$lang['font_small'] = 'Klein';
$lang['font_normal'] = 'Normaal';
$lang['font_large'] = 'Groot';
$lang['font_huge'] = 'Heel groot';

$lang['Close_Tags'] = 'Sluit tags';
$lang['Styles_tip'] = 'Tip: BBCode kan je snel toepassen op geselecteerde tekst.';


//
// Private Messaging
//
$lang['Private_Messaging'] = 'Priv&eacute;berichten';

$lang['Login_check_pm'] = 'Log in om je priv&eacute;berichten te bekijken';
$lang['New_pms'] = 'Je hebt %d nieuwe berichten'; // You have 2 new messages
$lang['New_pm'] = 'Je hebt %d nieuw bericht'; // You have 1 new message
$lang['No_new_pm'] = 'Je hebt geen nieuwe berichten';
$lang['Unread_pms'] = 'Je hebt %d ongelezen berichten';
$lang['Unread_pm'] = 'Je hebt %d ongelezen bericht';
$lang['No_unread_pm'] = 'Je hebt geen ongelezen berichten';
$lang['You_new_pm'] = 'Er is een nieuw priv&eacute;bericht in je Postvak IN';
$lang['You_new_pms'] = 'Er zijn nieuwe priv&eacute;berichten in je Postvak IN';
$lang['You_no_new_pm'] = 'Er zijn geen nieuwe priv&eacute;berichten voor je';

$lang['Unread_message'] = 'Ongelezen bericht';
$lang['Read_message'] = 'Gelezen bericht';

$lang['Read_pm'] = 'Bericht lezen';
$lang['Post_new_pm'] = 'Nieuw priv&eacute;bericht';
$lang['Post_reply_pm'] = 'Bericht beantwoorden';
$lang['Post_quote_pm'] = 'Bericht citeren';
$lang['Edit_pm'] = 'Bericht bewerken';

$lang['Inbox'] = 'Postvak IN';
$lang['Outbox'] = 'Postvak UIT';
$lang['Savebox'] = 'Bewaarde berichten';
$lang['Sentbox'] = 'Verzonden berichten';
$lang['Flag'] = 'Gelezen';
$lang['Subject'] = 'Onderwerp';
$lang['From'] = 'Van';
$lang['To'] = 'Aan';
$lang['Date'] = 'Datum';
$lang['Mark'] = 'Markeren';
$lang['Sent'] = 'Verzonden';
$lang['Saved'] = 'Bewaard';
$lang['Delete_marked'] = 'Geselecteerde berichten verwijderen';
$lang['Delete_all'] = 'Alle berichten verwijderen';
$lang['Save_marked'] = 'Geselecteerde berichten bewaren';
$lang['Save_message'] = 'Bericht bewaren';
$lang['Delete_message'] = 'Bericht verwijderen';

$lang['Display_messages'] = 'Bekijk berichten van de afgelopen'; // Followed by number of days/weeks/months
$lang['All_Messages'] = 'Alle berichten';

$lang['No_messages_folder'] = 'Je hebt geen berichten in deze map';

$lang['PM_disabled'] = 'Priv&eacute;berichten zijn niet ingeschakeld op dit forum.';
$lang['Cannot_send_privmsg'] = 'De beheerder heeft ervoor gezorgd dat je geen priv&eacute;berichten kan versturen.';
$lang['No_to_user'] = 'Je moet een gebruikersnaam opgeven om een bericht naar te versturen.';
$lang['No_such_user'] = 'Sorry, deze gebruiker bestaat niet.';

$lang['Disable_HTML_pm'] = 'HTML in dit bericht uitschakelen';
$lang['Disable_BBCode_pm'] = 'BBCode in dit bericht uitschakelen';
$lang['Disable_Smilies_pm'] = 'Smilies in dit bericht uitschakelen';

$lang['Message_sent'] = 'Je bericht is verzonden.';

$lang['Click_return_inbox'] = 'Klik %shier%s om terug te keren naar je Postvak IN';
$lang['Click_return_index'] = 'Klik %shier%s om terug te keren naar de Index';

$lang['Send_a_new_message'] = 'Een priv&eacute;bericht sturen';
$lang['Send_a_reply'] = 'Een priv&eacute;bericht beantwoorden';
$lang['Edit_message'] = 'Priv&eacute;bericht bewerken';

$lang['Notification_subject'] = 'Er is een nieuw priv&eacute;bericht';

$lang['Find_username'] = 'Gebruikersnaam zoeken';
$lang['Find'] = 'Zoeken';
$lang['No_match'] = 'Geen resultaten gevonden.';

$lang['No_post_id'] = 'Er is geen Post ID opgegeven';
$lang['No_such_folder'] = 'De opgegeven map bestaat niet';
$lang['No_folder'] = 'Geen map opgegeven';

$lang['Mark_all'] = 'Alles markeren';
$lang['Unmark_all'] = 'Niets markeren';

$lang['Confirm_delete_pm'] = 'Weet je zeker dat je dit bericht wil verwijderen?';
$lang['Confirm_delete_pms'] = 'Weet je zeker dat je deze berichten wil verwijderen?';

$lang['Inbox_size'] = 'Je Postvak IN is voor %d%% gevuld'; // eg. Your Inbox is 50% full
$lang['Sentbox_size'] = 'Je map Verzonden berichten is voor %d%% gevuld';
$lang['Savebox_size'] = 'Je map Bewaarde berichten is voor %d%% gevuld';

$lang['Click_view_privmsg'] = 'Klik %shier%s om naar je Postvak IN te gaan';


//
// Profiles/Registration
//
$lang['Viewing_user_profile'] = 'Profiel van :: %s'; // %s is username
$lang['About_user'] = 'Alles over %s'; // %s is username

$lang['Preferences'] = 'Voorkeuren';
$lang['Items_required'] = 'Onderdelen met een * zijn verplicht.';
$lang['Registration_info'] = 'Registratieinformatie';
$lang['Profile_info'] = 'Profielinformatie';
$lang['Profile_info_warn'] = 'Deze informatie is openbaar';
$lang['Avatar_panel'] = 'Avatar-paneel';
$lang['Avatar_gallery'] = 'Avatar-gallerij';

$lang['Website'] = 'Website';
$lang['Location'] = 'Woonplaats';
$lang['Contact'] = 'Contact';
$lang['Email_address'] = 'E-mail-adres';
$lang['Send_private_message'] = 'Stuur priv&eacute;bericht';
$lang['Hidden_email'] = '[ Verborgen ]';
$lang['Interests'] = 'Interesses';
$lang['Occupation'] = 'Beroep';
$lang['Poster_rank'] = 'Rang';

$lang['Total_posts'] = 'Totaal aantal berichten';
$lang['User_post_pct_stats'] = '%.2f%% van het totaal'; // 1.25% of total
$lang['User_post_day_stats'] = '%.2f berichten per dag'; // 1.5 posts per day
$lang['Search_user_posts'] = 'Zoek naar alle berichten van %s'; // Find all posts by username

$lang['No_user_id_specified'] = 'Sorry, maar die gebruiker bestaat niet.';
$lang['Wrong_Profile'] = 'Je kan alleen je eigen profiel bewerken.';

$lang['Only_one_avatar'] = 'Je kan maar &eacute;&eacute;n soort avatar gebruiken';
$lang['File_no_data'] = 'Het bestand op de URL die je opgaf bevat geen gegevens';
$lang['No_connection_URL'] = 'Er kan geen verbinding gemaakt worden met de URL die je hebt opgegeven';
$lang['Incomplete_URL'] = 'De URL die je hebt opgegeven is niet compleet';
$lang['Wrong_remote_avatar_format'] = 'De URL die je hebt opgegeven is niet geldig';
$lang['No_send_account_inactive'] = 'Sorry, maar je wachtwoord kan niet opgehaald worden omdat je account momenteel uitgeschakeld is. Neem contact op met de forumbeheerder voor meer informatie.';

$lang['Always_smile'] = 'Schakel smilies altijd in';
$lang['Always_html'] = 'Schakel HTML altijd in';
$lang['Always_bbcode'] = 'Schakel BBCode altijd in';
$lang['Always_add_sig'] = 'Gebruik altijd mijn onderschrift';
$lang['Always_notify'] = 'Breng mij standaard op de hoogte van reacties';
$lang['Always_notify_explain'] = 'Stuurt een e-mail als iemand reageert op een onderwerp waar je in gepost hebt. Dit kan altijd veranderd worden als je een bericht plaatst.';

$lang['Board_style'] = 'Forumstijl';
$lang['Board_lang'] = 'Forumtaal';
$lang['No_themes'] = 'Geen thema\'s in database';
$lang['Timezone'] = 'Tijdzone';
$lang['Date_format'] = 'Datumweergave';
$lang['Date_format_explain'] = 'De gebruikte syntaxis is identiek aan die van de PHP-functie <a href="http://www.php.net/date" target="_other">date()</a>.';
$lang['Signature'] = 'Onderschrift';
$lang['Signature_explain'] = 'Dit is een stukje tekst dat onder je berichten wordt gezet. Er is een limiet van %d tekens.';
$lang['Public_view_email'] = 'Iedereen mag mijn e-mail-adres zien';

$lang['Current_password'] = 'Huidig wachtwoord';
$lang['New_password'] = 'Nieuw wachtwoord';
$lang['Confirm_password'] = 'Bevestig wachtwoord';
$lang['Confirm_password_explain'] = 'Je moet je huidige wachtwoord invoeren indien je je wachtwoord of e-mail-adres wilt aanpassen';
$lang['password_if_changed'] = 'Geef alleen een wachtwoord op als je het wilt wijzigen';
$lang['password_confirm_if_changed'] = 'Je hoeft alleen je wachtwoord te bevestigen als je het verandert';

$lang['Avatar'] = 'Avatar';
$lang['Avatar_explain'] = 'Laat een kleine afbeelding onder je naam zien in ieder bericht. Je kan maar &eacute;&eacute;n afbeelding tegelijkertijd gebruiken, de breedte mag niet meer dan %d pixels zijn, de hoogte niet meer dan %d pixels. De maximale bestandsgrootte is %d KB.';
$lang['Upload_Avatar_file'] = 'Upload avatar van je computer';
$lang['Upload_Avatar_URL'] = 'Upload avatar vanaf een URL';
$lang['Upload_Avatar_URL_explain'] = 'Voer de URL waar je avatar staat in, en de afbeelding wordt gekopieerd naar deze site.';
$lang['Pick_local_Avatar'] = 'Selecteer een avatar uit de gallerij';
$lang['Link_remote_Avatar'] = 'Gebruik avatar van andere site';
$lang['Link_remote_Avatar_explain'] = 'Voer de URL van de avatar die op de andere site staat in.';
$lang['Avatar_URL'] = 'URL van de avatar';
$lang['Select_from_gallery'] = 'Selecteer een avatar uit de gallerij';
$lang['View_avatar_gallery'] = 'Gallerij bekijken';

$lang['Select_avatar'] = 'Avatar selecteren';
$lang['Return_profile'] = 'Annuleren';
$lang['Select_category'] = 'Selecteer categorie';

$lang['Delete_Image'] = 'Afbeelding verwijderen';
$lang['Current_Image'] = 'Huidige afbeelding';

$lang['Notify_on_privmsg'] = 'Waarschuw me als ik nieuwe priv&eacute;berichten heb';
$lang['Popup_on_privmsg'] = 'Laat een pop-up zien als ik nieuwe priv&eacute;berichten heb';
$lang['Popup_on_privmsg_explain'] = 'Sommige stijlen openen een nieuw venster (pop-up) als er nieuwe priv&eacute;berichten zijn.';
$lang['Hide_user'] = 'Laat andere gebruikers niet weten dat ik online ben';

$lang['Profile_updated'] = 'Je profiel is bijgewerkt';
$lang['Profile_updated_inactive'] = 'Je profiel is bijgewerkt. Je hebt echter wel belangrijke informatie aangepast waardoor je account nu tijdelijk uitgeschakeld is. Controleer je e-mail om te kijken hoe je je account weer kun activeren of, als dit door de beheerder gedaan moet worden, wacht dan tot de beheerder dit gedaan heeft.';

$lang['Password_mismatch'] = 'De wachtwoorden die je hebt opgegeven komen niet overeen.';
$lang['Current_password_mismatch'] = 'Het huidige wachtwoord wat je hebt opgegeven komt niet overeen met het in de database opgeslagen wachtwoord.';
$lang['Password_long'] = 'Je wachtwoord mag maximaal uit 32 tekens bestaan.';
$lang['Username_taken'] = 'Sorry, maar deze gebruikersnaam is reeds in gebruik.';
$lang['Username_invalid'] = 'Sorry, maar deze gebruikersnaam bevat een ongeldig teken zoals \'.';
$lang['Username_disallowed'] = 'Sorry, maar deze gebruikersnaam is niet toegestaan.';
$lang['Email_taken'] = 'Sorry, maar dit e-mailadres wordt al gebruikt door een gebruiker.';
$lang['Email_banned'] = 'Sorry, maar dit e-mailadres is verbannen.';
$lang['Email_invalid'] = 'Sorry, maar dit e-mailadres is ongeldig.';
$lang['Signature_too_long'] = 'Je onderschrift is te lang.';
$lang['Fields_empty'] = 'Je moet alle verplichte velden invullen.';
$lang['Avatar_filetype'] = 'De avatar moet een .jpg-, .gif- of .png-bestand zijn';
$lang['Avatar_filesize'] = 'De avatar moet minder dan %d KB groot zijn'; // The avatar image file size must be less than 6 kB
$lang['Avatar_imagesize'] = 'De avatar moet minder dan %d pixels breed en %d pixels hoog zijn';

$lang['Welcome_subject'] = 'Welkom op het %s Forum'; // Welcome to my.com forums
$lang['New_account_subject'] = 'Nieuwe gebruikersaccount';
$lang['Account_activated_subject'] = 'Account geactiveerd';

$lang['Account_added'] = 'Bedankt voor je registratie. Je account is aangemaakt. Je kunt nu inloggen met je gebruikersnaam en wachtwoord';
$lang['Account_inactive'] = 'Je account is aangemaakt. Dit forum vereist echter dat je je account activeert. Een activeringscode is opgestuurd naar het e-mail-adres dat je hebt opgegeven. Controleer je e-mail voor meer informatie';
$lang['Account_inactive_admin'] = 'Je account is aangemaakt. Dit forum vereist echter dat je account wordt goedgekeurd door de beheerder. Er wordt contact met je opgenomen zodra dit is gebeurd';
$lang['Account_active'] = 'Je account is geactiveerd. Bedankt voor je registratie';
$lang['Account_active_admin'] = 'De account is geactiveerd';
$lang['Reactivate'] = 'Je moet je account opnieuw activeren!';
$lang['Already_activated'] = 'Je hebt je account reeds geactiveerd';
$lang['COPPA'] = 'Je account is aangemaakt maar moet goedgekeurd worden. Controleer je e-mail voor meer details.';

$lang['Registration'] = 'Registratievoorwaarden';
$lang['Reg_agreement'] = 'Hoewel de beheerders en moderators van dit forum zullen trachten elk algemeen verwerpelijk materiaal zo snel mogelijk te verwijderen, is het niet mogelijk om elk bericht te lezen. Dit gegeven erkent u dat alle berichten die op dit forum worden geplaatst de visies en meningen van de auteurs geven, en niet die van de beheerders, moderators of webmaster (behalve berichten geplaatst door deze mensen) en dat deze niet verantwoordelijk kunnen worden gehouden voor de inhoud ervan.<br /><br />U gaat ermee akkoord geen kwetsende, obscene, vulgaire, lasterlijke, haatdragende, dreigende, seksueel ge&ouml;rienteerde of anderzijds verwerpelijke berichten te plaatsen, die van toepassing zijnde regels en/of wetten schenden. Het plaatsen van dergelijke berichten kan ertoe leiden dat u onmiddelijk en permanent wordt verbannen van deelname aan dit forum, en uw service provider kan ge&iuml;nformeerd worden. Het IP-adres van alle berichten wordt opgeslagen om deze voorwaarden te kunnen  opleggen. U gaat ermee akkoord dat de webmaster, beheerder en moderators van dit forum het recht hebben om onderwerpen te verwijderen, bewerken, verplaatsen of sluiten wanneer zij dit nodig vinden. Als gebruiker gaat u ermee akkoord dat de informatie die u bij ons invoert wordt opgeslagen in een database. Hoewel deze informatie niet aan een derde partij zal worden verstrekt zonder uw toestemming aan de webmaster, kunnen de beheerder en moderators niet verantwoordelijk worden gehouden voor een hack-poging die ertoe leidt dat de gegevens vrijkomen.<br /><br />Dit forumsysteem gebruikt cookies om informatie op te slaan op uw lokale computer. Deze cookies bevatten niets van de informatie die u hierna zal invullen; ze dienen enkel om uw gebruikerservaring te verbeteren. Het e-mail-adres wordt alleen gebruikt om uw registratiedetails en wachtwoord te bevestigen (en voor het sturen van nieuwe wachtwoorden mocht u uw huidige vergeten).<br /><br />Door hieronder toe te stemmen gaat u ermee akkoord dat u gebonden bent aan deze voorwaarden.';

$lang['Agree_under_13'] = 'Ik stem toe met de voorwaarden en ben <b>jonger</b> dan 13 jaar';
$lang['Agree_over_13'] = 'Ik stem toe met de voorwaarden en ben <b>ouder</b> dan 13 jaar';
$lang['Agree_not'] = 'Ik ben het niet eens met de voorwaarden';

$lang['Wrong_activation'] = 'De activeringscode is onjuist.';
$lang['Send_password'] = 'Stuur me een nieuw wachtwoord';
$lang['Password_updated'] = 'Een nieuw wachtwoord is aangemaakt, bekijk je e-mail voor meer details over hoe je dit moet activeren.';
$lang['No_email_match'] = 'Het e-mail-adres komt niet overeen met het adres dat bij ons bekend is voor deze gebruiker.';
$lang['New_password_activation'] = 'Activatie van nieuw wachtwoord';
$lang['Password_activated'] = 'Je account is weer geactiveerd. Gebruik het nieuwe wachtwoord dat je per e-mail ontvangen hebt om in te loggen.';

$lang['Send_email_msg'] = 'Verstuur een e-mail-bericht';
$lang['No_user_specified'] = 'Geen gebruiker aangegeven';
$lang['User_prevent_email'] = 'Deze gebruiker wenst geen e-mail te ontvangen. Probeer een priv&eacute;bericht te sturen.';
$lang['User_not_exist'] = 'Die gebruiker bestaat niet';
$lang['CC_email'] = 'Stuur jezelf een kopie van dit e-mail-bericht';
$lang['Email_message_desc'] = 'Dit bericht word verstuurd als eenvoudige tekst, dus gebruik geen HTML of BBCode. Het antwoordadres wordt ingesteld op je eigen e-mail-adres.';
$lang['Flood_email_limit'] = 'Je kan nog geen nieuwe e-mail versturen. Probeer het later nog eens.';
$lang['Recipient'] = 'Geadresseerde';
$lang['Email_sent'] = 'De e-mail is verstuurd.';
$lang['Send_email'] = 'E-mail versturen';
$lang['Empty_subject_email'] = 'Je moet een onderwerp invullen voor de e-mail.';
$lang['Empty_message_email'] = 'Je moet een bericht typen om te versturen.';

//
// Visual confirmation system strings
//
$lang['Confirm_code_wrong'] = 'De ingevoerde bevestigingscode is onjuist';
$lang['Too_many_registers'] = 'Je hebt het maximum aantal registratiepogingen voor deze sessie overschreden. Probeer het later nog eens.';
$lang['Confirm_code_impaired'] = 'Indien je de code niet kan lezen of blind of slechtziend bent, neem dan contact op met de %sAdministrator%s.';
$lang['Confirm_code'] = 'Bevestigingscode';
$lang['Confirm_code_explain'] = 'Voer de code in exact zoals je die ziet. De code is hoofdlettergevoelig, en een nul heeft een diagonale lijn.';

//
// Memberslist
//
$lang['Select_sort_method'] = 'Kies sorteermethode';
$lang['Sort'] = 'Sorteren';
$lang['Sort_Top_Ten'] = 'Top Tien posters';
$lang['Sort_Joined'] = 'Aanmelddatum';
$lang['Sort_Username'] = 'Gebruikersnaam';
$lang['Sort_Location'] = 'Woonplaats';
$lang['Sort_Posts'] = 'Geplaatste berichten';
$lang['Sort_Email'] = 'E-mail';
$lang['Sort_Website'] = 'Website';
$lang['Sort_Ascending'] = 'Oplopend';
$lang['Sort_Descending'] = 'Aflopend';
$lang['Order'] = 'Volgorde';


//
// Group control panel
//
$lang['Group_Control_Panel'] = 'Groepenoverzicht';
$lang['Group_member_details'] = 'Details groepslidmaatschap';
$lang['Group_member_join'] = 'Word lid van een groep';

$lang['Group_Information'] = 'Groepsinformatie';
$lang['Group_name'] = 'Groepsnaam';
$lang['Group_description'] = 'Groepsomschrijving';
$lang['Group_membership'] = 'Groepslidmaatschap';
$lang['Group_Members'] = 'Groepsleden';
$lang['Group_Moderator'] = 'Groepsmoderator';
$lang['Pending_members'] = 'Nog niet toegelaten gebruikers';

$lang['Group_type'] = 'Groepstype';
$lang['Group_open'] = 'Open groep';
$lang['Group_closed'] = 'Gesloten groep';
$lang['Group_hidden'] = 'Verborgen groep';

$lang['Current_memberships'] = 'Groepen waarvan je lid bent';
$lang['Non_member_groups'] = 'Groepen waarvan je niet lid bent';
$lang['Memberships_pending'] = 'Lidmaatschappen in aanvraag';

$lang['No_groups_exist'] = 'Er zijn geen groepen';
$lang['Group_not_exist'] = 'Die gebruikersgroep bestaat niet';

$lang['Join_group'] = 'Lid worden';
$lang['No_group_members'] = 'Deze groep heeft geen leden';
$lang['Group_hidden_members'] = 'Deze groep is verborgen, je kan de ledenlijst niet bekijken';
$lang['No_pending_group_members'] = 'Deze groep heeft geen leden die wachten op toelating';
$lang['Group_joined'] = 'Je hebt je succesvol aangemeld voor deze groep.<br />Je wordt op de hoogte gesteld als de groepsmoderator je aanmelding goedgekeurd heeft.';
$lang['Group_request'] = 'Er is een verzoek gedaan om lid te worden van jouw groep.';
$lang['Group_approved'] = 'Je aanmelding is goedgekeurd.';
$lang['Group_added'] = 'Je bent toegevoegd aan deze gebruikersgroep.';
$lang['Already_member_group'] = 'Je bent al lid van deze groep.';
$lang['User_is_member_group'] = 'Gebruiker is al lid van deze groep.';
$lang['Group_type_updated'] = 'Groepstype is veranderd.';

$lang['Could_not_add_user'] = 'De gebruiker die je opgaf bestaat niet.';
$lang['Could_not_anon_user'] = 'Anonieme gebruikers kunnen geen lid worden van een groep.';

$lang['Confirm_unsub'] = 'Weet je zeker dat je je lidmaatschap voor deze groep wilt opzeggen?';
$lang['Confirm_unsub_pending'] = 'Je aanmelding voor deze groep is nog niet goedgekeurd, weet je zeker dat je je lidmaatschap wilt opzeggen?';

$lang['Unsub_success'] = 'Je lidmaatschap voor deze groep is opgezegd.';

$lang['Approve_selected'] = 'Geselecteerde gebruikers toelaten';
$lang['Deny_selected'] = 'Geselecteerde gebruikers afwijzen';
$lang['Not_logged_in'] = 'Je moet ingelogd zijn om lid te worden van een groep.';
$lang['Remove_selected'] = 'Geselecteerde gebruikers verwijderen';
$lang['Add_member'] = 'Lid toevoegen';
$lang['Not_group_moderator'] = 'Je bent niet de moderator van deze groep, daarom kan je deze actie niet uitvoeren.';

$lang['Login_to_join'] = 'Log in om lid te worden of groepslidmaatschappen te beheren';
$lang['This_open_group'] = 'Dit is een open groep: klik om lidmaatschap aan te vragen';
$lang['This_closed_group'] = 'Dit is een gesloten groep: er worden geen nieuwe gebruikers geaccepteerd';
$lang['This_hidden_group'] = 'Dit is een verborgen groep: het automatisch toevoegen van gebruikers is niet toegestaan';
$lang['Member_this_group'] = 'Je bent lid van deze groep';
$lang['Pending_this_group'] = 'Je lidmaatschap is nog niet goedgekeurd';
$lang['Are_group_moderator'] = 'Je bent de groepsmoderator';
$lang['None'] = 'Geen';

$lang['Subscribe'] = 'Lid worden';
$lang['Unsubscribe'] = 'Lidmaatschap opzeggen';
$lang['View_Information'] = 'Gegevens bekijken';


//
// Search
//
$lang['Search_query'] = 'Zoekopdracht';
$lang['Search_options'] = 'Zoekopties';

$lang['Search_keywords'] = 'Zoek op trefwoorden';
$lang['Search_keywords_explain'] = 'Je kan <u>AND</u> gebruiken om woorden aan te geven die in het resultaat MOETEN voorkomen, <u>OR</u> om woorden aan te geven die MOGEN voorkomen in het resultaat en <u>NOT</u> om woorden aan te geven die NIET in het resultaat mogen voorkomen. Gebruik een * (wildcard) om te zoeken op een deel van een woord.';
$lang['Search_author'] = 'Zoek op auteur';
$lang['Search_author_explain'] = 'Gebruik een * (wildcard) om op een deel van een naam te zoeken';

$lang['Search_for_any'] = 'Zoek voor <i>een</i> van de woorden of gebruik AND, OR en NOT';
$lang['Search_for_all'] = 'Zoek naar <i>alle</i> woorden';
$lang['Search_title_msg'] = 'Zoek in berichttitel en tekst';
$lang['Search_msg_only'] = 'Zoek alleen in tekst bericht';

$lang['Return_first'] = 'Geef eerste'; // followed by xxx characters in a select box
$lang['characters_posts'] = 'tekens van het bericht weer';

$lang['Search_previous'] = 'Zoek in afgelopen'; // followed by days, weeks, months, year, all in a select box

$lang['Sort_by'] = 'Sorteer op';
$lang['Sort_Time'] = 'Plaatsingstijd';
$lang['Sort_Post_Subject'] = 'Titel reactie';
$lang['Sort_Topic_Title'] = 'Titel onderwerp';
$lang['Sort_Author'] = 'Auteur';
$lang['Sort_Forum'] = 'Forum';

$lang['Display_results'] = 'Geef resultaten weer als';
$lang['All_available'] = 'Alle fora';
$lang['No_searchable_forums'] = 'Je hebt onvoldoende rechten om elk forum te doorzoeken.';

$lang['No_search_match'] = 'Er zijn geen resultaten die voldoen aan je zoekopdracht';
$lang['Found_search_match'] = '%d resultaat gevonden'; // eg. Search found 1 match
$lang['Found_search_matches'] = '%d resultaten gevonden'; // eg. Search found 24 matches
$lang['Search_Flood_Error'] = 'Je kunt geen nieuwe zoekopdracht doen zo vlak na de vorige; probeer het in enkele ogenblikken opnieuw.';

$lang['Close_window'] = 'Sluit venster';


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = 'Sorry, alleen %s kunnen mededelingen plaatsen in dit forum.';
$lang['Sorry_auth_sticky'] = 'Sorry, alleen %s kunnen sticky-berichten plaatsen in dit forum.';
$lang['Sorry_auth_read'] = 'Sorry, alleen %s kunnen onderwerpen lezen in dit forum.';
$lang['Sorry_auth_post'] = 'Sorry, alleen %s kunnen nieuwe onderwerpen plaatsen in dit forum.';
$lang['Sorry_auth_reply'] = 'Sorry, alleen %s kunnen reageren op berichten in dit forum.';
$lang['Sorry_auth_edit'] = 'Sorry, alleen %s kunnen berichten bewerken in dit forum.';
$lang['Sorry_auth_delete'] = 'Sorry, alleen %s kunnen berichten verwijderen in dit forum.';
$lang['Sorry_auth_vote'] = 'Sorry, alleen %s kunnen stemmen op polls in dit forum.';

// These replace the %s in the above strings
$lang['Auth_Anonymous_Users'] = '<b>anonieme gebruikers</b>';
$lang['Auth_Registered_Users'] = '<b>geregistreerde gebruikers</b>';
$lang['Auth_Users_granted_access'] = '<b>gebruikers met speciale toegangsrechten</b>';
$lang['Auth_Moderators'] = '<b>moderators</b>';
$lang['Auth_Administrators'] = '<b>beheerders</b>';

$lang['Not_Moderator'] = 'Je ben geen moderator van dit forum.';
$lang['Not_Authorised'] = 'Geen toegang';

$lang['You_been_banned'] = 'Je bent verbannen van dit forum.<br />Neem contact op met de webmaster of forumbeheerder voor meer informatie.';


//
// Viewonline
//
$lang['Reg_users_zero_online'] = 'Er zijn 0 geregistreerde en '; // There are 5 Registered and
$lang['Reg_users_online'] = 'Er zijn %d geregistreerde en '; // There are 5 Registered and
$lang['Reg_user_online'] = 'Er is %d geregistreerde en '; // There is 1 Registered and
$lang['Hidden_users_zero_online'] = '0 verborgen gebruikers online'; // 6 Hidden users online
$lang['Hidden_users_online'] = '%d verborgen gebruikers online'; // 6 Hidden users online
$lang['Hidden_user_online'] = '%d verborgen gebruiker online'; // 6 Hidden users online
$lang['Guest_users_online'] = 'Er zijn %d gasten online'; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = 'Er zijn 0 gasten online'; // There are 10 Guest users online
$lang['Guest_user_online'] = 'Er is %d gast online'; // There is 1 Guest user online
$lang['No_users_browsing'] = 'Er zijn momenteel geen gebruikers aanwezig';

$lang['Online_explain'] = 'Deze lijst geeft de gebruikers weer die actief waren in de laatste 5 minuten';

$lang['Forum_Location'] = 'Forumlocatie';
$lang['Last_updated'] = 'Laatst bijgewerkt';

$lang['Forum_index'] = 'Forumindex';
$lang['Logging_on'] = 'Logt in';
$lang['Posting_message'] = 'Plaatst een bericht';
$lang['Searching_forums'] = 'Doorzoekt fora';
$lang['Viewing_profile'] = 'Bekijkt profiel';
$lang['Viewing_online'] = 'Bekijkt lijst met online gebruikers';
$lang['Viewing_member_list'] = 'Bekijkt gebruikerslijst';
$lang['Viewing_priv_msgs'] = 'Leest priv&eacute;berichten';
$lang['Viewing_FAQ'] = 'Leest FAQ';


//
// Moderator Control Panel
//
$lang['Mod_CP'] = 'Moderatorscontrolepaneel';
$lang['Mod_CP_explain'] = 'Gebruikmakend van onderstaand formulier, is het mogelijk grootschalige beheertaken uit te voeren op dit forum. Je kunt elk onderwerp sluiten, openen, verplaatsen of verwijderen.';

$lang['Select'] = 'Selecteren';
$lang['Delete'] = 'Verwijderen';
$lang['Move'] = 'Verplaatsen';
$lang['Lock'] = 'Sluiten';
$lang['Unlock'] = 'Heropenen';

$lang['Topics_Removed'] = 'De geselecteerde onderwerpen zijn verwijderd uit de database.';
$lang['Topics_Locked'] = 'De geselecteerde onderwerpen zijn gesloten.';
$lang['Topics_Moved'] = 'De geselecteerde onderwerpen zijn verplaatst.';
$lang['Topics_Unlocked'] = 'De geselecteerde onderwerpen zijn heropend.';
$lang['No_Topics_Moved'] = 'Er zijn geen onderwerpen verplaatst.';

$lang['Confirm_delete_topic'] = 'Weet je zeker dat je de geselecteerde onderwerpen wil verwijderen?';
$lang['Confirm_lock_topic'] = 'Weet je zeker dat je de geselecteerde onderwerpen wil sluiten?';
$lang['Confirm_unlock_topic'] = 'Weet je zeker dat je de geselecteerde onderwerpen wil heropenen?';
$lang['Confirm_move_topic'] = 'Weet je zeker dat je de geselecteerde onderwerpen wil verplaatsen?';

$lang['Move_to_forum'] = 'Verplaats naar forum';
$lang['Leave_shadow_topic'] = 'Laat link achter op oude forum.';

$lang['Split_Topic'] = 'Onderwerpen splitsen';
$lang['Split_Topic_explain'] = 'Gebruikmakend van onderstaand formulier kun je een onderwerp splitsen. Dit kan door het apart selecteren van de te splitsen berichten, of te splitsen vanaf de plaats van het geselecteerde bericht.';
$lang['Split_title'] = 'Titel nieuw onderwerp';
$lang['Split_forum'] = 'Forum voor nieuw onderwerp';
$lang['Split_posts'] = 'Geselecteerde berichten afsplitsen';
$lang['Split_after'] = 'Vanaf geselecteerd bericht afsplitsen';
$lang['Topic_split'] = 'Het onderwerp is succesvol opgesplitst';

$lang['Too_many_error'] = 'Je hebt teveel berichten geselecteerd. Je kunt maar &eacute;&eacute;n bericht selecteren om een onderwerp na dit bericht te splitsen!';

$lang['None_selected'] = 'Je hebt geen enkel onderwerp geselecteerd om deze actie op uit te voeren. Ga terug en selecteer minimaal 1 onderwerp.';
$lang['New_forum'] = 'Nieuw subforum';

$lang['This_posts_IP'] = 'IP-adres voor dit bericht';
$lang['Other_IP_this_user'] = 'Andere IP-adressen waarvan deze gebruiker heeft gepost';
$lang['Users_this_IP'] = 'Gebruikers die van dit IP-adres hebben gepost';
$lang['IP_info'] = 'IP Informatie';
$lang['Lookup_IP'] = 'Zoek IP-adres op';


//
// Timezones ... for display on each page
//
$lang['All_times'] = 'Tijden zijn in %s'; // eg. All times are GMT - 12 Hours (times from next block)

$lang['-12'] = 'GMT - 12 uur';
$lang['-11'] = 'GMT - 11 uur';
$lang['-10'] = 'GMT - 10 uur';
$lang['-9'] = 'GMT - 9 uur';
$lang['-8'] = 'GMT - 8 uur';
$lang['-7'] = 'GMT - 7 uur';
$lang['-6'] = 'GMT - 6 uur';
$lang['-5'] = 'GMT - 5 uur';
$lang['-4'] = 'GMT - 4 uur';
$lang['-3.5'] = 'GMT - 3.5 uur';
$lang['-3'] = 'GMT - 3 uur';
$lang['-2'] = 'GMT - 2 uur';
$lang['-1'] = 'GMT - 1 uur';
$lang['0'] = 'GMT';
$lang['1'] = 'GMT + 1 uur';
$lang['2'] = 'GMT + 2 uur';
$lang['3'] = 'GMT + 3 uur';
$lang['3.5'] = 'GMT + 3.5 uur';
$lang['4'] = 'GMT + 4 uur';
$lang['4.5'] = 'GMT + 4.5 uur';
$lang['5'] = 'GMT + 5 uur';
$lang['5.5'] = 'GMT + 5.5 uur';
$lang['6'] = 'GMT + 6 uur';
$lang['6.5'] = 'GMT + 6.5 uur';
$lang['7'] = 'GMT + 7 uur';
$lang['8'] = 'GMT + 8 uur';
$lang['9'] = 'GMT + 9 uur';
$lang['9.5'] = 'GMT + 9.5 uur';
$lang['10'] = 'GMT + 10 uur';
$lang['11'] = 'GMT + 11 uur';
$lang['12'] = 'GMT + 12 uur';
$lang['13'] = 'GMT + 13 uur';

// These are displayed in the timezone select box
$lang['tz']['-12'] = 'GMT - 12 uur';
$lang['tz']['-11'] = 'GMT - 11 uur';
$lang['tz']['-10'] = 'GMT - 10 uur';
$lang['tz']['-9'] = 'GMT - 9 uur';
$lang['tz']['-8'] = 'GMT - 8 uur';
$lang['tz']['-7'] = 'GMT - 7 uur';
$lang['tz']['-6'] = 'GMT - 6 uur';
$lang['tz']['-5'] = 'GMT - 5 uur';
$lang['tz']['-4'] = 'GMT - 4 uur';
$lang['tz']['-3.5'] = 'GMT - 3.5 uur';
$lang['tz']['-3'] = 'GMT - 3 uur';
$lang['tz']['-2'] = 'GMT - 2 uur';
$lang['tz']['-1'] = 'GMT - 1 uur';
$lang['tz']['0'] = 'GMT';
$lang['tz']['1'] = 'GMT + 1 uur';
$lang['tz']['2'] = 'GMT + 2 uur';
$lang['tz']['3'] = 'GMT + 3 uur';
$lang['tz']['3.5'] = 'GMT + 3.5 uur';
$lang['tz']['4'] = 'GMT + 4 uur';
$lang['tz']['4.5'] = 'GMT + 4.5 uur';
$lang['tz']['5'] = 'GMT + 5 uur';
$lang['tz']['5.5'] = 'GMT + 5.5 uur';
$lang['tz']['6'] = 'GMT + 6 uur';
$lang['tz']['6.5'] = 'GMT + 6.5 uur';
$lang['tz']['7'] = 'GMT + 7 uur';
$lang['tz']['8'] = 'GMT + 8 uur';
$lang['tz']['9'] = 'GMT + 9 uur';
$lang['tz']['9.5'] = 'GMT + 9.5 uur';
$lang['tz']['10'] = 'GMT + 10 uur';
$lang['tz']['11'] = 'GMT + 11 uur';
$lang['tz']['12'] = 'GMT + 12 uur';
$lang['tz']['13'] = 'GMT + 13 uur';

$lang['datetime']['Sunday'] = 'Zondag';
$lang['datetime']['Monday'] = 'Maandag';
$lang['datetime']['Tuesday'] = 'Dinsdag';
$lang['datetime']['Wednesday'] = 'Woensdag';
$lang['datetime']['Thursday'] = 'Donderdag';
$lang['datetime']['Friday'] = 'Vrijdag';
$lang['datetime']['Saturday'] = 'Zaterdag';
$lang['datetime']['Sun'] = 'Zo';
$lang['datetime']['Mon'] = 'Ma';
$lang['datetime']['Tue'] = 'Di';
$lang['datetime']['Wed'] = 'Wo';
$lang['datetime']['Thu'] = 'Do';
$lang['datetime']['Fri'] = 'Vr';
$lang['datetime']['Sat'] = 'Za';
$lang['datetime']['January'] = 'Januari';
$lang['datetime']['February'] = 'Februari';
$lang['datetime']['March'] = 'Maart';
$lang['datetime']['April'] = 'April';
$lang['datetime']['May'] = 'Mei';
$lang['datetime']['June'] = 'Juni';
$lang['datetime']['July'] = 'Juli';
$lang['datetime']['August'] = 'Augustus';
$lang['datetime']['September'] = 'September';
$lang['datetime']['October'] = 'Oktober';
$lang['datetime']['November'] = 'November';
$lang['datetime']['December'] = 'December';
$lang['datetime']['Jan'] = 'Jan';
$lang['datetime']['Feb'] = 'Feb';
$lang['datetime']['Mar'] = 'Mrt';
$lang['datetime']['Apr'] = 'Apr';
$lang['datetime']['May'] = 'Mei';
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
$lang['Information'] = 'Informatie';
$lang['Critical_Information'] = 'Belangrijke informatie';

$lang['General_Error'] = 'Algemene fout';
$lang['Critical_Error'] = 'Fatale fout';
$lang['An_error_occured'] = 'Er is een fout opgetreden';
$lang['A_critical_error'] = 'Er is een fatale fout opgetreden';

$lang['Admin_reauthenticate'] = 'Om het forum te kunnen beheren moet je opnieuw inloggen';
$lang['Login_attempts_exceeded'] = 'Je hebt het maximaal aantal van %s login-pogingen overschreden. Je mag niet inloggen voor de komende %s minuten.';
$lang['Please_remove_install_contrib'] = 'Verzeker je ervan dat de \'install/\'- en \'contrib/\'-mappen verwijderd zijn';
$lang['Session_invalid'] = 'Ongeldie sessie. Verstuur het formulier opnieuw.';
//
// That's all, Folks!
// -------------------------------------------------

?>