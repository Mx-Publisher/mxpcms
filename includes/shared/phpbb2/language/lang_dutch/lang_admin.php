<?php

/***************************************************************************
 *                            lang_admin.php [Dutch]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_admin.php,v 1.35.2.17 2006/02/05 15:59:48 grahamje Exp $
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
// Format is same as lang_main
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//
$lang['General'] = 'Algemeen';
$lang['Users'] = 'Gebruikers';
$lang['Groups'] = 'Groepen';
$lang['Forums'] = 'Fora';
$lang['Styles'] = 'Stijlen';

$lang['Configuration'] = 'Configuratie';
$lang['Permissions'] = 'Permissies';
$lang['Manage'] = 'Beheer';
$lang['Disallow'] = 'Geweigerde gebruikersnamen';
$lang['Prune'] = 'Opruimen';
$lang['Mass_Email'] = 'Massa-mailing';
$lang['Ranks'] = 'Rangen';
$lang['Smilies'] = 'Smilies';
$lang['Ban_Management'] = 'Verbanningsbeheer';
$lang['Word_Censor'] = 'Woordcensuur';
$lang['Export'] = 'Exporteren';
$lang['Create_new'] = 'Aanmaken';
$lang['Add_new'] = 'Toevoegen';
$lang['Backup_DB'] = 'Back-up Database';
$lang['Restore_DB'] = 'Database herstellen';


//
// Index
//
$lang['Admin'] = 'Beheer';
$lang['Not_admin'] = 'Je bent niet bevoegd om dit forum te beheren';
$lang['Welcome_phpBB'] = 'Welkom bij phpBB';
$lang['Admin_intro'] = 'Bedankt dat je phpBB gekozen hebt als je forumsoftware. Dit scherm geeft je een kort overzicht van de verschillende statistieken van je forum. Je kan op deze pagina terug komen door te klikken op de <u>Beheerdersindex</u> link in het linker vlak. Om terug te gaan naar de index van je forum, kun je op het phpBB-logo klikken dat ook in het linker vlak staat. Met de andere links aan de linkerkant van dit scherm kun je elk aspect van je forum beheren. Elk scherm geeft uitleg over het gebruik van de gereedschappen.';
$lang['Main_index'] = 'Forumindex';
$lang['Forum_stats'] = 'Forumstatistieken';
$lang['Admin_Index'] = 'Beheerdersindex';
$lang['Preview_forum'] = 'Voorbeeldindex';

$lang['Click_return_admin_index'] = 'Klik %shier%s om terug te gaan naar de Beheerdersindex';

$lang['Statistic'] = 'Statistiek';
$lang['Value'] = 'Waarde';
$lang['Number_posts'] = 'Aantal berichten';
$lang['Posts_per_day'] = 'Berichten per dag';
$lang['Number_topics'] = 'Aantal onderwerpen';
$lang['Topics_per_day'] = 'Onderwerpen per dag';
$lang['Number_users'] = 'Aantal gebruikers';
$lang['Users_per_day'] = 'Gebruikers per dag';
$lang['Board_started'] = 'Forum gestart';
$lang['Avatar_dir_size'] = 'Grootte van avatar-map';
$lang['Database_size'] = 'Grootte van database';
$lang['Gzip_compression'] = 'Gzip-compressie';
$lang['Not_available'] = 'Niet beschikbaar';

$lang['ON'] = 'AAN'; // This is for GZip compression
$lang['OFF'] = 'UIT';


//
// DB Utils
//
$lang['Database_Utilities'] = 'Hulpprogramma\'s Database';

$lang['Restore'] = 'Herstellen';
$lang['Backup'] = 'Back-up';
$lang['Restore_explain'] = 'Dit herstelt alle phpBB-tabellen volledig vanuit een opgeslagen bestand. Als je server het ondersteunt, kun je een met gzip gecomprimeerd tekstbestand uploaden; dit wordt dan automatisch uitgepakt. <b>WAARSCHUWING</B> Dit overschrijft alle bestaande data. Het herstellen kan geruime tijd in beslag nemen, verlaat deze pagina niet voordat dit proces is afgerond.';
$lang['Backup_explain'] = 'Hier kun je alle aan phpBB gerelateerde gegevens opslaan. Als je extra tabellen hebt aangemaakt in dezelfde database als phpBB, die je ook wilt opslaan, voer dan hun namen in, gescheiden door komma\'s, in het \'Extra tabellen\'-tekstvak hieronder. Als je server het ondersteunt, kun je het bestand eerst met gzip laten comprimeren voordat je het downloadt.';

$lang['Backup_options'] = 'Back-up-opties';
$lang['Start_backup'] = 'Back-up starten';
$lang['Full_backup'] = 'Volledige backup';
$lang['Structure_backup'] = 'Back-up van structuur';
$lang['Data_backup'] = 'Back-up van data';
$lang['Additional_tables'] = 'Extra tabellen';
$lang['Gzip_compress'] = 'Comprimeer bestand met gzip';
$lang['Select_file'] = 'Selecteer een bestand';
$lang['Start_Restore'] = 'Herstelproces starten';

$lang['Restore_success'] = 'De database is succesvol hersteld.<br /><br />Je forum zou terug moeten zijn in dezelfde staat als op het moment dat de backup gemaakt is.';
$lang['Backup_download'] = 'Je download begint over enkele ogenblikken, wacht totdat deze gestart is.';
$lang['Backups_not_supported'] = 'Sorry, maar database back-ups worden momenteel niet ondersteund voor jouw database-systeem.';

$lang['Restore_Error_uploading'] = 'Fout bij het uploaden van het back-up-bestand';
$lang['Restore_Error_filename'] = 'Probleem met de bestandsnaam, probeer een ander bestand';
$lang['Restore_Error_decompress'] = 'Kan geen gzip-bestand decomprimeren, upload een plain text versie';
$lang['Restore_Error_no_file'] = 'Er is geen bestand ge-upload';


//
// Auth pages
//
$lang['Select_a_User'] = 'Selecteer een gebruiker';
$lang['Select_a_Group'] = 'Selecteer een groep';
$lang['Select_a_Forum'] = 'Selecteer een forum';
$lang['Auth_Control_User'] = 'Gebruikerspermissies';
$lang['Auth_Control_Group'] = 'Groepspermissies';
$lang['Auth_Control_Forum'] = 'Forumpermissies';
$lang['Look_up_User'] = 'Gebruiker bekijken';
$lang['Look_up_Group'] = 'Groep bekijken';
$lang['Look_up_Forum'] = 'Forum bekijken';

$lang['Group_auth_explain'] = 'Hier kun je de permissies en moderator-status veranderen die zijn toegewezen aan elke gebruikersgroep. Vergeet niet dat, wanneer je groepspermissies verandert, individuele gebruikerspermissies de gebruiker nog steeds toegang kunnen geven tot forums e.d. Je krijgt een waarschuwing wanneer dit het geval is.';
$lang['User_auth_explain'] = 'Hier kun je de permissies en moderator-status veranderen die zijn toegewezen aan elke individuele gebruiker. Vergeet niet dat, wanneer je gebruikerspermissies verandert, groepspermissies de gebruiker nog steeds toegang kunnen geven tot forums e.d. Je krijgt een waarschuwing wanneer dit het geval is.';
$lang['Forum_auth_explain'] = 'Hier kun je het authorisatieniveau van elk forum aanpassen. Je hebt hiervoor een simpele en een uitgebreide methode, de uitgebreide methode geeft je meer invloed op elke forumactie. Denk eraan dat wanneer je het permissieniveau van forums aanpast, dit invloed heeft op welke gebruikers bepaalde acties daarbinnen kunnen uitvoeren.';

$lang['Simple_mode'] = 'Simpele Modus';
$lang['Advanced_mode'] = 'Uitgebreide Modus';
$lang['Moderator_status'] = 'Moderator-status';

$lang['Allowed_Access'] = 'Toegang verleend';
$lang['Disallowed_Access'] = 'Toegang geweigerd';
$lang['Is_Moderator'] = 'Moderator';
$lang['Not_Moderator'] = 'Geen moderator';

$lang['Conflict_warning'] = 'Authorisatieconflictwaarschuwing';
$lang['Conflict_access_userauth'] = 'Deze gebruiker heeft nog toegang tot dit forum via een groep waarvan hij/zij deel uit maakt. Je kunt de groepspermissies aanpassen om volledig te voorkomen dat hij/zij toegangsrechten heeft. De betrokken groepen (en de forums waarom het gaat) staan hieronder opgesomd.';
$lang['Conflict_mod_userauth'] = 'Deze gebruiker heeft nog moderator-rechten op dit forum via een groep waarvan hij/zij deel uit maakt. Je kunt de groepspermissies aanpassen om volledig te voorkomen dat hij/zij moderator-rechten heeft. De betrokken groepen (en de forums waarom het gaat) staan hieronder opgesomd.';

$lang['Conflict_access_groupauth'] = 'De volgende gebruiker (of gebruikers) heeft/hebben nog toegang tot dit forum via gebruikerspermissies. Je kunt de gebruikerspermissies aanpassen om volledig te voorkomen dat hij/zij toegangsrechten heeft. De gebruikersrechten (en de forums waarom het gaat) staan hieronder opgesomd.';
$lang['Conflict_mod_groupauth'] = 'De volgende gebruiker (of gebruikers) heeft/hebben nog moderator rechten op dit forum via gebruikerspermissies. Je kunt de gebruikerspermissies aanpassen om volledig te voorkomen dat hij/zij moderator rechten heeft. De gebruikersrechten (en de forums waarom het gaat) staan hieronder opgesomd.';

$lang['Public'] = 'Openbaar';
$lang['Private'] = 'Priv&eacute;';
$lang['Registered'] = 'Geregistreerd';
$lang['Administrators'] = 'Beheerders';
$lang['Hidden'] = 'Verborgen';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = 'ALLE';
$lang['Forum_REG'] = 'LEDEN';
$lang['Forum_PRIVATE'] = 'PRIV&Eacute;';
$lang['Forum_MOD'] = 'MOD';
$lang['Forum_ADMIN'] = 'ADMIN';

$lang['View'] = 'Zien';
$lang['Read'] = 'Lezen';
$lang['Post'] = 'Posten';
$lang['Reply'] = 'Antwoorden';
$lang['Edit'] = 'Bewerken';
$lang['Delete'] = 'Verwijderen';
$lang['Sticky'] = 'Sticky';
$lang['Announce'] = 'Aankondigen';
$lang['Vote'] = 'Stemmen';
$lang['Pollcreate'] = 'Poll aanmaken';

$lang['Permissions'] = 'Permissies';
$lang['Simple_Permission'] = 'Eenvoudige permissies';

$lang['User_Level'] = 'Gebruikersniveau';
$lang['Auth_User'] = 'Gebruiker';
$lang['Auth_Admin'] = 'Beheerder';
$lang['Group_memberships'] = 'Gebruikersgroepslidmaatschap';
$lang['Usergroup_members'] = 'Deze groep heeft de volgende leden';

$lang['Forum_auth_updated'] = 'Forumpermissies bijgewerkt';
$lang['User_auth_updated'] = 'Gebruikerspermissies bijgewerkt';
$lang['Group_auth_updated'] = 'Groepspermissies bijgewerkt';

$lang['Auth_updated'] = 'Permissies zijn bijgewerkt';
$lang['Click_return_userauth'] = 'Klik %shier%s om terug te gaan naar Gebruikerspermissies';
$lang['Click_return_groupauth'] = 'Klik %shier%s om terug te gaan naar Groepspermissies';
$lang['Click_return_forumauth'] = 'Klik %shier%s om terug te gaan naar Forumpermissies';


//
// Banning
//
$lang['Ban_control'] = 'Verbanningsbeheer';
$lang['Ban_explain'] = 'Hier kun je het verbannen van gebruikers beheren. Je kunt dit bereiken door een specifieke gebruiker, een IP-ades of host-naam, of een reeks van IP-adressen of host-namen te verbannen. Deze methode zorgt ervoor dat de gebruiker niet eens de indexpagina van je forum kan bereiken. Om te voorkomen dat de gebruiker zich onder een andere gebruikersnaam registreert kun je ook verbannen e-mail-adressen specificeren. Denk eraan dat het verbannen van alleen een e-mail-adres niet voorkomt dat een gebruiker in kan loggen en berichten kan plaatsen op je forum. Daarvoor moet je een van de eerste twee methoden gebruiken.';
$lang['Ban_explain_warn'] = 'Denk eraan dat bij het invoeren van een IP-reeks alle adressen tussen het begin en einde aan de verbanlijst worden toegevoegd. Er wordt geprobeerd om het aantal adressen in de database te minimaliseren door, waar toepasselijk, automatisch wildcards in te voegen. Als je echt een reeks in wilt voeren, probeer deze dan klein te houden. Of beter nog, vermeld een specifiek adres.';

$lang['Select_username'] = 'Selecteer een gebruikersnaam';
$lang['Select_ip'] = 'Selecteer een IP-adres';
$lang['Select_email'] = 'Selecteer een e-mail-adres';

$lang['Ban_username'] = 'Verban een of meer specifieke gebruikers';
$lang['Ban_username_explain'] = 'Je kunt meerdere gebruikers in een keer verbannen door de juiste combinatie van muis en toetsenbord voor jouw computer en browser te gebruiken';

$lang['Ban_IP'] = 'Verban een of meer IP-adressen of host-namen';
$lang['IP_hostname'] = 'IP-adressen of host-namen';
$lang['Ban_IP_explain'] = 'Om meerdere IP-adressen of host-namen in te voeren dien je ze te scheiden met komma\'s. Om een IP-reeks in te voeren zet je een streepje (-) tussen het begin en het eind. Om een wildcard aan te geven gebruik je *.';

$lang['Ban_email'] = 'Verban een of meer e-mail-adressen';
$lang['Ban_email_explain'] = 'Om meerdere e-mail-adressen in te voeren dien je ze te scheiden met komma\'s. Om een wildcard aan te geven gebruik je *, bijvoorbeeld \'*@hotmail.com\'.';

$lang['Unban_username'] = 'Hef verbanning van een of meer specifieke gebruikers op';
$lang['Unban_username_explain'] = 'Je kunt de verbanning van meerdere gebruikers in een keer opheffen door de juiste combinatie van muis en toetsenbord voor jouw computer en browser te gebruiken';

$lang['Unban_IP'] = 'Hef verbanning van een of meer IP-adressen op';
$lang['Unban_IP_explain'] = 'Je kunt de verbanning van meerdere IP-adressen in een keer opheffen door de juiste combinatie van muis en toetsenbord voor jouw computer en browser te gebruiken';

$lang['Unban_email'] = 'Hef verbanning van een of meer e-mail-adressen op';
$lang['Unban_email_explain'] = 'Je kunt de verbanning van meerdere e-mail-adressen in een keer opheffen door de juiste combinatie van muis en toetsenbord voor jouw computer en te gebruiken ';

$lang['No_banned_users'] = 'Geen verbannen gebruikersnamen';
$lang['No_banned_ip'] = 'Geen verbannen IP-adressen';
$lang['No_banned_email'] = 'Geen verbannen e-mail-adressen';

$lang['Ban_update_sucessful'] = 'De verbanlijst is succesvol bijgewerkt';
$lang['Click_return_banadmin'] = 'Klik %shier%s om terug te gaan naar Verbanningsbeheer';


//
// Configuration
//
$lang['General_Config'] = 'Algemene configuratie';
$lang['Config_explain'] = 'Met het formulier hieronder kun je alle algemene forumopties aanpassen. Voor gebruikers- en forumconfiguratie gebruik je de links aan de linkerkant.';

$lang['Click_return_config'] = 'Klik %shier%s om terug te gaan naar Algemene configuratie';

$lang['General_settings'] = 'Algemene Foruminstellingen';
$lang['Server_name'] = 'Domeinnaam';
$lang['Server_name_explain'] = 'Het domein waar dit forum is gehost';
$lang['Script_path'] = 'Scriptpad';
$lang['Script_path_explain'] = 'Het pad waar phpBB geinstalleerd is, relatief aan het domein';
$lang['Server_port'] = 'Serverpoort';
$lang['Server_port_explain'] = 'De poort waarop de server draait, gewoonlijk 80. Verander dit alleen als deze in jouw geval anders is.';
$lang['Site_name'] = 'Naam van de site';
$lang['Site_desc'] = 'Omschrijving van de site';
$lang['Board_disable'] = 'Forum uitschakelen';
$lang['Board_disable_explain'] = 'Dit maakt het forum onbereikbaar voor gebruikers. Beheerders kunnen nog steeds van het beheerderspaneel gebruik maken.';
$lang['Acct_activation'] = 'Account-activering aanzetten';
$lang['Acc_None'] = 'Geen'; // These three entries are the type of activation
$lang['Acc_User'] = 'Gebruiker';
$lang['Acc_Admin'] = 'Beheerder';

$lang['Abilities_settings'] = 'Basisinstellingen gebruikers en forum';
$lang['Max_poll_options'] = 'Max aantal opties in polls';
$lang['Flood_Interval'] = 'Flood Interval';
$lang['Flood_Interval_explain'] = 'Aantal seconden dat een gebruiker moet wachten tussen posts';
$lang['Board_email_form'] = 'Gebruikers-e-mail via dit forum';
$lang['Board_email_form_explain'] = 'Gebruikers sturen elkaar e-mail via dit forum';
$lang['Topics_per_page'] = 'Onderwerpen per pagina';
$lang['Posts_per_page'] = 'Berichten per pagina';
$lang['Hot_threshold'] = 'Aantal berichten voor een populair onderwerp';
$lang['Default_style'] = 'Standaardstijl';
$lang['Override_style'] = 'Negeer gebruikersstijl';
$lang['Override_style_explain'] = 'Vervang gebruikersstijl door de standaard';
$lang['Default_language'] = 'Standaardtaal';
$lang['Date_format'] = 'Datumformaat';
$lang['System_timezone'] = 'Tijdzone van het systeem';
$lang['Enable_gzip'] = 'GZip-compressie aanzetten';
$lang['Enable_prune'] = 'Automatisch opruimen aanzetten';
$lang['Allow_HTML'] = 'HTML toestaan';
$lang['Allow_BBCode'] = 'BBCode toestaan';
$lang['Allowed_tags'] = 'Toegestane HTML tags';
$lang['Allowed_tags_explain'] = 'Tags scheiden met komma\'s';
$lang['Allow_smilies'] = 'Smilies toestaan';
$lang['Smilies_path'] = 'Smilies-map';
$lang['Smilies_path_explain'] = 'Map onder je phpBB root dir, bijv. images/smiles';
$lang['Allow_sig'] = 'Onderschrift toestaan';
$lang['Max_sig_length'] = 'Maximale lengte van onderschrift';
$lang['Max_sig_length_explain'] = 'Maximum aantal karakters in onderschrift van gebruikers';
$lang['Allow_name_change'] = 'Wijzigen van gebruikersnamen toestaan';

$lang['Avatar_settings'] = 'Instellingen Avatar';
$lang['Allow_local'] = 'Avatars uit gallerij toestaan';
$lang['Allow_remote'] = 'Externe avatars toestaan';
$lang['Allow_remote_explain'] = 'Avatars die van een andere website worden opgehaald';
$lang['Allow_upload'] = 'Uploaden van avatar toestaan';
$lang['Max_filesize'] = 'Maximale bestandsgrootte avatar';
$lang['Max_filesize_explain'] = 'Voor ge&uuml;ploade avatar-bestanden';
$lang['Max_avatar_size'] = 'Maximale afmetingen avatar';
$lang['Max_avatar_size_explain'] = '(Hoogte x breedte in pixels)';
$lang['Avatar_storage_path'] = 'Avatar-map';
$lang['Avatar_storage_path_explain'] = 'Map onder phpBB root dir, bijv. images/avatars';
$lang['Avatar_gallery_path'] = 'Avatar gallery-map';
$lang['Avatar_gallery_path_explain'] = 'Map onder je phpBB root dir voor voorgeselecteerde avatars, bijv. images/avatars/gallery';

$lang['COPPA_settings'] = 'COPPA-instellingen';
$lang['COPPA_fax'] = 'COPPA-faxnummer';
$lang['COPPA_mail'] = 'COPPA-postadres';
$lang['COPPA_mail_explain'] = 'Dit is het postadres waar ouders COPPA-registratieformulieren naar toe sturen';

$lang['Email_settings'] = 'E-mail-instellingen';
$lang['Admin_email'] = 'E-mailadres beheerder';
$lang['Email_sig'] = 'E-mail-afsluiting';
$lang['Email_sig_explain'] = 'Deze tekst wordt toegevoegd aan alle emails die het forum verstuurt';
$lang['Use_SMTP'] = 'Gebruik SMTP server voor e-mail';
$lang['Use_SMTP_explain'] = 'Kies \'Ja\' als je de e-mail via een benoemde server wilt of moet versturen in plaats van via de \'local mail\'-functie';
$lang['SMTP_server'] = 'SMTP-server-adres';
$lang['SMTP_username'] = 'SMTP-gebruikersnaam';
$lang['SMTP_username_explain'] = 'Vul alleen een gebruikersnaam in als je SMTP-server dit vereist';
$lang['SMTP_password'] = 'SMTP-wachtwoord';
$lang['SMTP_password_explain'] = 'Vul alleen een wachtwoord in als je SMTP-server dit vereist';

$lang['Disable_privmsg'] = 'Priv&eacute;berichten';
$lang['Inbox_limits'] = 'Max berichten in Postvak IN';
$lang['Sentbox_limits'] = 'Max berichten in Verzonden berichten';
$lang['Savebox_limits'] = 'Max berichten in Bewaarde berichten';

$lang['Cookie_settings'] = 'Cookie-instellingen';
$lang['Cookie_settings_explain'] = 'Deze instellingen bepalen hoe cookies worden verstuurd naar de browser van gebruikers. In de meeste gevallen zijn de standaardinstellingen voldoende, maar als je ze moet veranderen, wees dan voorzichtig -- incorrecte instellingen kunnen tot gevolg hebben dat gebruikers niet kunnen inloggen.';
$lang['Cookie_domain'] = 'Cookie-domein';
$lang['Cookie_name'] = 'Cookie-naam';
$lang['Cookie_path'] = 'Cookie-pad';
$lang['Cookie_secure'] = 'Beveiligde cookies';
$lang['Cookie_secure_explain'] = 'Zet dit alleen aan als je server gebruikt maakt van SSL';
$lang['Session_length'] = 'Sessielengte [ seconden ]';

// Visual Confirmation
$lang['Visual_confirm'] = 'Visuele bevestiging aanzetten';
$lang['Visual_confirm_explain'] = 'Gebruikers dienen een code uit een afbeelding over te typen bij registratie.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin'] = 'Automatisch inloggen toestaan';
$lang['Allow_autologin_explain'] = 'Bepaalt of gebruikers er voor kunnen kiezen om automatisch ingelogd te worden als ze het forum bezoeken';
$lang['Autologin_time'] = 'Verlopen van automatische-login-sleutel';
$lang['Autologin_time_explain'] = 'Hoe lang een autologin-sleutel geldig is in dagen als de gebruiker het forum niet bezoekt. Stel dit in op 0 zodat sleutels nooit verlopen.';

// Search Flood Control - added 2.0.20
$lang['Search_Flood_Interval'] = 'Flood Interval voor zoeken';
$lang['Search_Flood_Interval_explain'] = 'Aantal seconden dat een gebruiker moet wachten tussen zoekpogingen';

//
// Forum Management
//
$lang['Forum_admin'] = 'Forumbeheer';
$lang['Forum_admin_explain'] = 'Vanuit dit paneel kun je categorie&euml;n en subfora toevoegen, verwijderen, bewerken, van volgorde veranderen en opnieuw synchroniseren';
$lang['Edit_forum'] = 'Forum bewerken';
$lang['Create_forum'] = 'Nieuw forum aanmaken';
$lang['Create_category'] = 'Nieuwe categorie aanmaken';
$lang['Remove'] = 'Verwijderen';
$lang['Action'] = 'Actie';
$lang['Update_order'] = 'Volgorde vernieuwen';
$lang['Config_updated'] = 'Forumconfiguratie succesvol bijgewerkt';
$lang['Edit'] = 'Bewerken';
$lang['Delete'] = 'Verwijderen';
$lang['Move_up'] = 'Omhoog';
$lang['Move_down'] = 'Omlaag';
$lang['Resync'] = 'Synchroniseren';
$lang['No_mode'] = 'Er is geen modus opgegeven';
$lang['Forum_edit_delete_explain'] = 'Met het formulier hieronder kun je alle algemene forumopties aanpassen. Voor gebruikers- en forumconfiguratie kun je de links aan de linkerkant gebruiken';

$lang['Move_contents'] = 'Alle inhoud verplaatsen';
$lang['Forum_delete'] = 'Forum verwijderen';
$lang['Forum_delete_explain'] = 'Met het formulier hieronder kun je een forum (of categorie) verwijderen en bepalen waarheen je alle onderwerpen (of forums) die het bevatte wilt verplaatsen.';

$lang['Status_locked'] = 'Gesloten';
$lang['Status_unlocked'] = 'Open';
$lang['Forum_settings'] = 'Algemene Foruminstellingen';
$lang['Forum_name'] = 'Naam forum';
$lang['Forum_desc'] = 'Omschrijving';
$lang['Forum_status'] = 'Status forum';
$lang['Forum_pruning'] = 'Automatisch opruimen';

$lang['prune_freq'] = 'Controleer de leeftijd van onderwerpen elke';
$lang['prune_days'] = 'Verwijder topics waarin niets gepost is in';
$lang['Set_prune_data'] = 'Je hebt automatisch opruimen aangezet voor dit forum, maar hebt geen frequentie of aantal dagen aangegeven. Ga terug om dit alsnog te doen.';

$lang['Move_and_Delete'] = 'Verplaatsen en verwijderen';

$lang['Delete_all_posts'] = 'Alle berichten verwijderen';
$lang['Nowhere_to_move'] = 'Geen plaats om naartoe te verplaatsen';

$lang['Edit_Category'] = 'Categorie bewerken';
$lang['Edit_Category_explain'] = 'Gebruik dit formulier om de naam van een categorie aan te passen.';

$lang['Forums_updated'] = 'Forum- en categorieinformatie succesvol bijgewerkt';

$lang['Must_delete_forums'] = 'Je moet alle subfora verwijderen voordat je deze categorie kunt verwijderen';

$lang['Click_return_forumadmin'] = 'Klik %shier%s om terug te gaan naar Forumbeheer';


//
// Smiley Management
//
$lang['smiley_title'] = 'Smilies Bewerken';
$lang['smile_desc'] = 'Vanaf deze pagina kun je de emoticons of smilies die gebruikers in hun berichten of priv&eacute;berichten kunnen gebruiken toevoegen, verwijderen en bewerken.';

$lang['smiley_config'] = 'Smiley-configuratie';
$lang['smiley_code'] = 'Smiley-code';
$lang['smiley_url'] = 'Smiley-afbeelding';
$lang['smiley_emot'] = 'Smiley-emotie';
$lang['smile_add'] = 'Nieuwe smiley toevoegen';
$lang['Smile'] = 'Smile';
$lang['Emotion'] = 'Emotie';

$lang['Select_pak'] = 'Selecteer Pakket (.pak-bestand)';
$lang['replace_existing'] = 'Bestaande smiley vervangen';
$lang['keep_existing'] = 'Bestaande smiley behouden';
$lang['smiley_import_inst'] = 'Je moet het smiley-pakket unzippen en alle bestanden uploaden naar de juiste smiley-map voor jouw installatie. Selecteer vervolgens de juiste informatie in dit formulier om het smiley-pakket te importeren.';
$lang['smiley_import'] = 'Smiley-pakket importeren';
$lang['choose_smile_pak'] = 'Kies een smiley-pakket (.pak-bestand)';
$lang['import'] = 'Importeer smilies';
$lang['smile_conflicts'] = ' Wat er gedaan moet worden in geval van een conflict';
$lang['del_existing_smileys'] = 'Verwijder bestaande smilies voor het importeren';
$lang['import_smile_pack'] = 'Smiley-pakket importeren';
$lang['export_smile_pack'] = 'Smiley-pakket aanmaken';
$lang['export_smiles'] = 'Om een smiley-pakket aan te maken met je huidige ge&iuml;nstalleerde smilies, kun je %shier%s klikken om het smiles.pak bestand te downloaden. Hernoem het bestand naar een geschikte naam, maar houd de .pak-extensie. Maak vervolgens een zip-bestand aan met al je smiley-afbeeldingen plus dit .pak-configuratiebestand.';

$lang['smiley_add_success'] = 'De smiley is succesvol toegevoegd';
$lang['smiley_edit_success'] = 'De smiley is succesvol bijgewerkt';
$lang['smiley_import_success'] = 'Het smiley-pakket is succesvol ge&iuml;mporteerd!';
$lang['smiley_del_success'] = 'De smiley is succesvol verwijderd';
$lang['Click_return_smileadmin'] = 'Klik %shier%s om terug te gaan naar Smiley-beheer';

$lang['Confirm_delete_smiley'] = 'Weet je zeker dat je deze smiley wilt verwijderen?';


//
// User Management
//
$lang['User_admin'] = 'Gebruikersbeheer';
$lang['User_admin_explain'] = 'Hier kun je de informatie en bepaalde opties van gebruikers aanpassen. Als je de gebruikerspermissies wilt aanpassen dien je het gebruikers- en groepspermissiesysteem te gebruiken.';

$lang['Look_up_user'] = 'Gebruiker bekijken';

$lang['Admin_user_fail'] = 'Gebruikersprofiel kon niet bijgewerkt worden.';
$lang['Admin_user_updated'] = 'Gebruikersprofiel is succesvol bijgewerkt.';
$lang['Click_return_useradmin'] = 'Klik %shier%s om terug te gaan naar Gebruikersbeheer';

$lang['User_delete'] = 'Deze gebruiker verwijderen';
$lang['User_delete_explain'] = 'Klik hier om deze gebruiker te verwijderen, dit kan niet ongedaan worden gemaakt.';
$lang['User_deleted'] = 'Gebruiker is succesvol verwijderd.';

$lang['User_status'] = 'Gebruiker is actief';
$lang['User_allowpm'] = 'Kan priv&eacute;berichten versturen';
$lang['User_allowavatar'] = 'Kan avatar weergeven';

$lang['Admin_avatar_explain'] = 'Hier kun je de huidige avatar van de gebruiker bekijken en verwijderen.';

$lang['User_special'] = 'Speciale velden voor beheerder';
$lang['User_special_explain'] = 'Deze velden kunnen niet worden aangepast door gebruikers. Hier kun je hun status instellen en andere opties die niet beschikbaar zijn voor gebruikers.';


//
// Group Management
//
$lang['Group_administration'] = 'Groepsbeheer';
$lang['Group_admin_explain'] = 'Vanaf dit paneel kun je al je gebruikersgroepen beheren. Je kunt groepen aanmaken, verwijderen en bewerken. Je kunt moderators kiezen, groepen op open of gesloten instellen en de groepsnaam en -beschrijving instellen.';
$lang['Error_updating_groups'] = 'Er heeft zich een fout voorgedaan tijdens het bijwerken van de groepen';
$lang['Updated_group'] = 'De groep is succesvol bijgewerkt';
$lang['Added_new_group'] = 'De nieuwe groep is succesvol aangemaakt';
$lang['Deleted_group'] = 'De groep is succesvol verwijderd';
$lang['New_group'] = 'Nieuwe groep aanmaken';
$lang['Edit_group'] = 'Groep bewerken';
$lang['group_name'] = 'Groepsnaam';
$lang['group_description'] = 'Groepsomschrijving';
$lang['group_moderator'] = 'Groepsmoderator';
$lang['group_status'] = 'Groepsstatus';
$lang['group_open'] = 'Open groep';
$lang['group_closed'] = 'Gesloten groep';
$lang['group_hidden'] = 'Verborgen groep';
$lang['group_delete'] = 'Groep verwijderen';
$lang['group_delete_check'] = 'Deze groep verwijderen';
$lang['submit_group_changes'] = 'Wijzigingen bevestigen';
$lang['reset_group_changes'] = 'Wijzigingen herstellen';
$lang['No_group_name'] = 'Je moet een naam opgeven voor deze groep';
$lang['No_group_moderator'] = 'Je moet een moderator aanstellen voor deze groep';
$lang['No_group_mode'] = 'Je moet de staat van deze groep aangeven, open of gesloten';
$lang['No_group_action'] = 'Geen actie opgegeven';
$lang['delete_group_moderator'] = 'De oude groepsmoderator verwijderen?';
$lang['delete_moderator_explain'] = 'Als je de groepsmoderator wijzigt, kun je dit vakje aanvinken om de oude groepsmoderator uit de groep te verwijderen. Als je dit niet doet wordt de oude groepsmoderator een gewoon lid van de groep.';
$lang['Click_return_groupsadmin'] = 'Klik %shier%s om terug te gaan naar Groepsbeheer.';
$lang['Select_group'] = 'Selecteer een groep';
$lang['Look_up_group'] = 'Informatie bekijken';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'Automatisch opruimen';
$lang['Forum_Prune_explain'] = 'Dit verwijdert elk onderwerp waarop geen reactie is geweest in het aantal dagen dat je aangeeft. Als je geen nummer invoert worden alle onderwerpen verwijderd. Dit verwijdert geen onderwerpen waarin nog peilingen (polls) lopen, ook verwijdert het geen aankondigingen. Die onderwerpen dien je handmatig te verwijderen.';
$lang['Do_Prune'] = 'Opruimen';
$lang['All_Forums'] = 'Alle forums';
$lang['Prune_topics_not_posted'] = 'Verwijder onderwerpen zonder reacties in';
$lang['Topics_pruned'] = 'Onderwerpen verwijderd';
$lang['Posts_pruned'] = 'Berichten verwijderd';
$lang['Prune_success'] = 'Opruimen van de fora is succesvol afgerond';


//
// Word censor
//
$lang['Words_title'] = 'Woordcensuur';
$lang['Words_explain'] = 'In dit paneel kun je woorden toevoegen, bewerken en verwijderen die automatisch gecensureerd worden. Bovendien kunnen gebruikers zich niet registreren met een gebruikersnaam waarin een van die woorden voorkomt. Wildcards (*) worden geaccepteerd in het woordveld. Bijvoorbeeld: *pik* komt overeen met Lopikkerwaard, pik* met pikant en *pik met hospik.';
$lang['Word'] = 'Woord';
$lang['Edit_word_censor'] = 'Bewerk woordcensuur';
$lang['Replacement'] = 'Vervangen door';
$lang['Add_new_word'] = 'Nieuw woord toevoegen';
$lang['Update_word'] = 'Woordcensuur bijwerken';

$lang['Must_enter_word'] = 'Je moet een woord en de vervanging daarvoor opgeven';
$lang['No_word_selected'] = 'Geen woord geselecteerd om te bewerken';

$lang['Word_updated'] = 'Het geselecteerde censuurwoord is succesvol bijgewerkt';
$lang['Word_added'] = 'Het censuurwoord is succesvol toegevoegd';
$lang['Word_removed'] = 'Het geselecteerde censuurwoord is succesvol verwijderd';

$lang['Click_return_wordadmin'] = 'Klik %shier%s om terug te gaan naar Censuurwoordenbeheer';

$lang['Confirm_delete_word'] = 'Weet je zeker dat je dit censuurwoord wilt verwijderen?';

//
// Mass Email
//
$lang['Mass_email_explain'] = 'Hier kun je e-mail sturen aan al je gebruikers, of aan gebruikers uit een specifieke groep. Hiervoor wordt een e-mail verstuurd aan het e-mail-adres van de beheerder dat opgegeven is, met een \'blind carbon copy\' aan alle ontvangers. Als je een grote groep wilt e-mailen, wees dan geduldig en stop de pagina niet halverwege. Het is normaal dat massa-e-mail geruime tijd in beslag neemt, en je krijgt een melding wanneer het script is afgerond.';
$lang['Compose'] = 'Opstellen';

$lang['Recipients'] = 'Ontvangers';
$lang['All_users'] = 'Alle gebruikers';

$lang['Email_successfull'] = 'Je bericht is verzonden';
$lang['Click_return_massemail'] = 'Klik %shier%s om terug te gaan naar het massa-e-mail-formulier';


//
// Ranks admin
//
$lang['Ranks_title'] = 'Rangen';
$lang['Ranks_explain'] = 'Met dit formulier kun je rangen toevoegen, bewerken, bekijken en verwijderen. Je kunt ook aangepaste rangen aanmaken die toegepast kunnen worden via de gebruikersbeheerfunctie.';

$lang['Add_new_rank'] = 'Nieuwe rang toevoegen';

$lang['Rank_title'] = 'Rangtitel';
$lang['Rank_special'] = 'Als speciale rang instellen';
$lang['Rank_minimum'] = 'Minimum Berichten';
$lang['Rank_maximum'] = 'Maximum Berichten';
$lang['Rank_image'] = 'Rangafbeelding (relatief aan phpBB2 root-pad)';
$lang['Rank_image_explain'] = 'Gebruik dit om een kleine afbeelding aan een rang te verbinden';

$lang['Must_select_rank'] = 'Je moet een rang selecteren';
$lang['No_assigned_rank'] = 'Geen speciale rang toegewezen';

$lang['Rank_updated'] = 'De rang is succesvol bijgewerkt';
$lang['Rank_added'] = 'De rang is succesvol toegevoegd';
$lang['Rank_removed'] = 'De rang is succesvol verwijderd';
$lang['No_update_ranks'] = 'De rang is succesvol verwijderd, maar de gebruikers die deze rang gebruikten zijn niet aangepast. Je zal dit handmatig moeten veranderen.';

$lang['Click_return_rankadmin'] = 'Klik %shier%s om terug te gaan naar Rangenbeheer';

$lang['Confirm_delete_rank'] = 'Weet je zeker dat je deze rang wilt verwijderen?';

//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'Geweigerde gebruikersnamen';
$lang['Disallow_explain'] = 'Hier kun je bepalen welke gebruikersnamen niet gebruikt mogen worden. Geweigerde gebruikersnamen mogen wildcards (*) bevatten. Denk eraan dat je geen gebruikersnaam kunt specficeren die al geregistreerd is, je moet die dan eerst verwijderen en dan aan deze lijst toevoegen.';

$lang['Delete_disallow'] = 'Verwijderen';
$lang['Delete_disallow_title'] = 'Geweigerde gebruikersnaam verwijderen';
$lang['Delete_disallow_explain'] = 'Je kunt een geweigerde gebruikersnaam verwijderen door de naam in deze lijst te selecteren en op Verwijderen te klikken';

$lang['Add_disallow'] = 'Toevoegen';
$lang['Add_disallow_title'] = 'Geweigerde gebruikersnaam toevoegen';
$lang['Add_disallow_explain'] = 'Je kunt een gebruikersnaam weigeren door gebruik te maken van een wildcard (*) om een willekeurig ander karakter te vervangen';

$lang['No_disallowed'] = 'Geen geweigerde gebruikersnamen';

$lang['Disallowed_deleted'] = 'De geweigerde gebruikersnaam is succesvol verwijderd';
$lang['Disallow_successful'] = 'De geweigerde gebruikersnaam is succesvol toegevoegd';
$lang['Disallowed_already'] = 'De naam die je ingevoerd hebt kon niet worden toegevoegd aan de lijst. Hij staat reeds in de lijst, staat in de censuurwoordenlijst, of er bestaat reeds een gebruiker met die naam.';

$lang['Click_return_disallowadmin'] = 'Klik %shier%s om terug te gaan naar Geweigerde Gebruikersnamen';


//
// Styles Admin
//
$lang['Styles_admin'] = 'Stijlenbeheer';
$lang['Styles_explain'] = 'Met dit onderdeel kun je de stijlen die beschikbaar zijn voor je gebruikers toevoegen, verwijderen en beheren';
$lang['Styles_addnew_explain'] = 'De volgende lijst bevat alle thema\'s die momenteel beschikbaar zijn voor de stijlen die je ge&iuml;nstalleerd hebt. De onderdelen op deze lijst zijn nog niet geinstalleerd in de phpBB-database. Om een thema te installeren  kun je simpelweg klikken op de \'Installeren\'-link naast de vermelding.';

$lang['Select_template'] = 'Selecteer een sjabloon';

$lang['Style'] = 'Stijl';
$lang['Template'] = 'Sjabloon';
$lang['Install'] = 'Installeren';
$lang['Download'] = 'Downloaden';

$lang['Edit_theme'] = 'Thema bewerken';
$lang['Edit_theme_explain'] = 'In dit formulier kun je de instellingen van het geselecteerde thema bewerken';

$lang['Create_theme'] = 'Thema aanmaken';
$lang['Create_theme_explain'] = 'Gebruk dit formulier om een nieuw thema aan te maken voor een geselecteerd sjabloon. Wanneer je kleuren toevoegt (waarvoor je de hexadecimale schrijfwijze moet gebruiken) moet je het voorafgaande # weglaten, bijv. CCCCCC is geldig, #CCCCCC niet.';

$lang['Export_themes'] = 'Thema\'s exporteren';
$lang['Export_explain'] = 'In dit venster kun je de themagegevens voor een geselecteerd sjabloon exporteren. Selecteer het sjabloon uit de lijst hieronder en het script zal het configuratiebestand van het thema aanmaken en proberen dit op te slaan in de geselecteerde map. Als het bestand niet kan worden opgeslagen krijg je de mogelijkheid om het te downloaden. Om het bestand op te kunnen slaan met het script, dient de webserver schrijfrechten te hebben in de map van het geselecteerde sjabloon. Zie, voor meer informatie hierover, de handleiding van phpBB2.';

$lang['Theme_installed'] = 'Het geselecteerde thema is succesvol ge&iuml;nstalleerd';
$lang['Style_removed'] = 'De geselecteerde stijl is verwijderd uit de database. Om de stijl volledig van je systeem te verwijderen moet je de betreffende bestanden verwijderen uit je \'templates/\'-map.';
$lang['Theme_info_saved'] = 'De thema-informatie voor het geselecteerde sjabloon is opgeslagen. Je dient nu de permissies op \'theme_info.cfg\' (en indien van toepassing, de map van het geselecteerde sjabloon) terug te zetten naar alleen-lezen (read-only).';
$lang['Theme_updated'] = 'Het geselecteerde thema is bijgewerkt. Je dient nu de nieuwe thema-instellingen te exporteren.';
$lang['Theme_created'] = 'Thema aangemaakt. Je dient nu het thema op te slaan in het themaconfiguratiebestand als reservekopie of om elders te gebruiken.';

$lang['Confirm_delete_style'] = 'Weet je zeker dat je deze stijl wilt verwijderen?';

$lang['Download_theme_cfg'] = 'Het thema-informatiebestand kon niet worden geschreven. Klik op de knop hieronder om dit bestand via je browser te downloaden. Wanneer je het gedownload hebt, kun je het overzetten naar de map waarin de bestanden van het sjabloon staan. Je kunt de bestanden vervolgens verpakken voor distributie of elders gebruiken.';
$lang['No_themes'] = 'Aan het sjabloon dat je geselecteerd hebt zijn geen thema\'s verbonden. Om een nieuw thema aan te maken, klik je op \'Aanmaken\' in het vlak aan de linkerkant.';
$lang['No_template_dir'] = 'Kon de \'templates/\'-map niet openen. Deze kan mogelijk niet gelezen worden door de webserver of de map bestaat niet.';
$lang['Cannot_remove_style'] = 'Je kunt deze stijl niet verwijderen aangezien het de standaard is voor het forum. Verander de standaardstijl en probeer het opnieuw.';
$lang['Style_exists'] = 'De naam die je opgegeven hebt voor de stijl bestaat al, ga terug en kies een andere naam.';

$lang['Click_return_styleadmin'] = 'Klik %shier%s om terug te gaan naar Stijlenbeheer';

$lang['Theme_settings'] = 'Thema-instellingen';
$lang['Theme_element'] = 'Thema-element';
$lang['Simple_name'] = 'Eenvoudige naam';
$lang['Value'] = 'Waarde';
$lang['Save_Settings'] = 'Instellingen opslaan';

$lang['Stylesheet'] = 'Cascading Style Sheet';
$lang['Stylesheet_explain'] = 'Bestandsnaam van het stylesheet voor dit thema.';
$lang['Background_image'] = 'Achtergrondafbeelding';
$lang['Background_color'] = 'Achtergrondkleur';
$lang['Theme_name'] = 'Naam thema';
$lang['Link_color'] = 'Kleur links';
$lang['Text_color'] = 'Tekstkleur';
$lang['VLink_color'] = 'Kleur bekeken links';
$lang['ALink_color'] = 'Kleur actieve links';
$lang['HLink_color'] = 'Kleur aangewezen links';
$lang['Tr_color1'] = 'Kleur tabelrij  1';
$lang['Tr_color2'] = 'Kleur tabelrij  2';
$lang['Tr_color3'] = 'Kleur tabelrij  3';
$lang['Tr_class1'] = 'Klasse tabelrij  1';
$lang['Tr_class2'] = 'Klasse tabelrij  2';
$lang['Tr_class3'] = 'Klasse tabelrij  3';
$lang['Th_color1'] = 'Kleur tabelkop 1';
$lang['Th_color2'] = 'Kleur tabelkop 2';
$lang['Th_color3'] = 'Kleur tabelkop 3';
$lang['Th_class1'] = 'Klasse tabelkop 1';
$lang['Th_class2'] = 'Klasse tabelkop 2';
$lang['Th_class3'] = 'Klasse tabelkop 3';
$lang['Td_color1'] = 'Kleur tabelcel 1';
$lang['Td_color2'] = 'Kleur tabelcel 2';
$lang['Td_color3'] = 'Kleur tabelcel 3';
$lang['Td_class1'] = 'Klasse tabelcel 1';
$lang['Td_class2'] = 'Klasse tabelcel 2';
$lang['Td_class3'] = 'Klasse tabelcel 3';
$lang['fontface1'] = 'Lettertype 1';
$lang['fontface2'] = 'Lettertype 2';
$lang['fontface3'] = 'Lettertype 3';
$lang['fontsize1'] = 'Lettergrootte 1';
$lang['fontsize2'] = 'Lettergrootte 2';
$lang['fontsize3'] = 'Lettergrootte 3';
$lang['fontcolor1'] = 'Tekstkleur 1';
$lang['fontcolor2'] = 'Tekstkleur 2';
$lang['fontcolor3'] = 'Tekstkleur 3';
$lang['span_class1'] = 'Klasse span 1';
$lang['span_class2'] = 'Klasse span 2';
$lang['span_class3'] = 'Klasse span 3';
$lang['img_poll_size'] = 'Grootte van pollafbeelding [px]';
$lang['img_pm_size'] = 'Grootte van priv&eacute;berichtstatus [px]';


//
// Install Process
//
$lang['Welcome_install'] = 'Welkom bij de installatie van phpBB 2';
$lang['Initial_config'] = 'Basisconfiguratie';
$lang['DB_config'] = 'Databaseconfiguratie';
$lang['Admin_config'] = 'Beheerconfiguratie';
$lang['continue_upgrade'] = 'Zodra je het config-bestand naar je lokale computer hebt gedownload, kan je op de \'Upgrade vervolgen\' knop hieronder klikken om verder te gaan met de upgrade. Wacht met het uploaden van het config-bestand tot de upgrade voltooid is.';
$lang['upgrade_submit'] = 'Upgrade vervolgen';

$lang['Installer_Error'] = 'Er is een fout opgetreden tijdens de installatie';
$lang['Previous_Install'] = 'Een vorige installatie is gevonden';
$lang['Install_db_error'] = 'Er is een fout opgetreden tijdens het bijwerken van de database';

$lang['Re_install'] = 'Je vorige installatie is nog actief.<br /><br />Als je phpBB2 opnieuw wilt installeren, klik dan op de \'Ja\'-knop hieronder. LET OP: hiermee vernietig je alle bestaande gegevens, er worden geen back-ups gemaakt! De gebruikersnaam en het wachtwoord van de beheerder die je gebruikte om op je forum in te loggen worden opnieuw aangemaakt na de her-installatie, en geen enkele andere instelling wordt bewaard.<br /><br />Denk goed na voordat je op \'Ja\' klikt!';

$lang['Inst_Step_0'] = 'Bedankt dat je voor phpBB 2 hebt gekozen. Vul, om de installatie te voltooien, de gegevens in die hieronder gevraagd worden. Denk eraan dat de database waarnaar je installeert al dient te bestaan. Wanneer je installeert op een database die ODBC gebruikt, bijv. MS Access, dien je eerst een DSN aan te maken voordat je verder gaat.';

$lang['Start_Install'] = 'Installatie starten';
$lang['Finish_Install'] = 'Installatie afronden';

$lang['Default_lang'] = 'Standaard forumtaal';
$lang['DB_Host'] = 'Database Server host-naam / DSN';
$lang['DB_Name'] = 'Database-naam';
$lang['DB_Username'] = 'Database-gebruikersnaam';
$lang['DB_Password'] = 'Database-wachtwoord';
$lang['Database'] = 'Database';
$lang['Install_lang'] = 'Kies taal voor installatie';
$lang['dbms'] = 'Database-type';
$lang['Table_Prefix'] = 'Prefix voor tabellen in database';
$lang['Admin_Username'] = 'Gebruikersnaam beheerder';
$lang['Admin_Password'] = 'Wachtwoord beheerder';
$lang['Admin_Password_confirm'] = 'Wachtwoord beheerder [ Bevestig ]';

$lang['Inst_Step_2'] = 'Je beheerders-account is aangemaakt. Nu is je basisinstallatie compleet. Je komt nu in een scherm waarmee je je nieuwe installatie kunt inrichten. Zorg ervoor dat je de algemene configuratiedetails controleert en de vereiste vranderingen aanbrengt. Bedankt dat je voor phpBB 2 hebt gekozen.';

$lang['Unwriteable_config'] = 'Er kan momenteel niet naar je config-bestand worden geschreven. Een kopie van het config-bestand wordt gedownload als je op de knop hieronder klikt. Je dient dit bestand te uploaden naar dezelfde map als phpBB 2. Wanneer dat gedaan is dien je in te loggen, met de beheerdersaccount en bijbehorend wachtwoord die je in het vorige formulier hebt opgegeven, en het beheerderspaneel op te zoeken (er verschijnt een link onderaan elke pagina wanneer je ingelogd bent) om de algemene configuratie te controleren. Bedankt dat je voor phpBB 2  hebt gekozen.';
$lang['Download_config'] = 'Config-bestand downloaden';

$lang['ftp_choose'] = 'Kies Download-methode';
$lang['ftp_option'] = '<br />Aangezien FTP-extensies mogelijk zijn in deze versie van PHP kun je ook eerst de mogelijkheid krijgen om te proberen het config-bestand automatisch naar de juiste plek te verplaatsen met behulp van FTP.';
$lang['ftp_instructs'] = 'Je hebt ervoor gekozen om het bestand automatisch naar het account waarin phpBB 2 staat te verplaatsen met FTP. Vul hieronder de voor dit proces benodigde informatie in. Denk eraan dat het FTP-pad het exacte pad naar je phpBB2-installatie moet zijn, zoals je het normaal zou bereiken met een normale FTP client.';
$lang['ftp_info'] = 'Voer je FTP-informatie in';
$lang['Attempt_ftp'] = 'Probeer het config-bestand naar de juiste plek te verplaatsen met FTP';
$lang['Send_file'] = 'Stuur me het bestand toe zodat ik het handmatig kan uploaden';
$lang['ftp_path'] = 'FTP-pad naar phpBB 2';
$lang['ftp_username'] = 'FTP-gebruikersnaam';
$lang['ftp_password'] = 'FTP-wachtwoord';
$lang['Transfer_config'] = 'Overdracht starten';
$lang['NoFTP_config'] = 'De poging om het config-bestand naar de juiste plek te verplaatsen met behulp van FTP is mislukt. Download het config-bestand en upload het handmatig naar de juiste plek.';

$lang['Install'] = 'Installeren';
$lang['Upgrade'] = 'Upgraden';


$lang['Install_Method'] = 'Kies je installatiemethode';

$lang['Install_No_Ext'] = 'De PHP-configuratie op je server biedt geen ondersteuning voor het database-type dat je koos';

$lang['Install_No_PCRE'] = 'phpBB2 heeft de Perl-Compatible Regular Expressions Module voor PHP nodig, die kennelijk niet ondersteund wordt door je PHP-configuratie!';

//
// Version Check
//
$lang['Version_up_to_date'] = 'Je installatie is bijgewerkt met de nieuwste versie, er zijn geen updates beschikbaar voor jouw versie van phpBB.';
$lang['Version_not_up_to_date'] = 'Je installatie is <b>niet</b> bijgewerkt met de nieuwste versie. Er zijn updates beschikbaar voor jouw versie van phpBB, bezoek <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/downloads.php</a> om de laatste versie te bemachtigen.';
$lang['Latest_version_info'] = 'De meest recente versie is <b>phpBB %s</b>.';
$lang['Current_version_info'] = 'Je draait momenteel <b>phpBB %s</b>.';
$lang['Connect_socket_error'] = 'Kan geen verbinding maken met de phpBB-server, gerapporteerde fout is:<br />%s';
$lang['Socket_functions_disabled'] = 'Kan geen gebruik maken van socket-functies.';
$lang['Mailing_list_subscribe_reminder'] = 'Voor het laatste nieuws over updates voor phpBB, word je lid van <a href="http://www.phpbb.com/support/" target="_new">onze mailing list</a>.';
$lang['Version_information'] = 'Versieinformatie';

//
// Login attempts configuration
//
$lang['Max_login_attempts'] = 'Toegestane login-pogingen';
$lang['Max_login_attempts_explain'] = 'Het aantal toegestande login-pogingen.';
$lang['Login_reset_time'] = 'Duur login-vergrendeling';
$lang['Login_reset_time_explain'] = 'Tijd in minuten die de gebruiker moet wachten tot hij/zij weer mag inloggen na het overschrijden van het aantal login-pogingen.';


//
// That's all Folks!
// -------------------------------------------------

?>