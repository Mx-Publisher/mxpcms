<?php

/***************************************************************************
 *                            lang_admin.php [Swedish]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group and (C) 2003 Jonathan Gulbrandsen
 *     email                : support@phpbb.com (translator:virtuality@carlssonplanet.com)
 *
 *     $Id: lang_admin.php,v 1.1 2008/02/13 21:15:13 jonohlsson Exp $
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

/* CONTRIBUTORS
	XXXX-XX-XX
                Orginal translation to Swedish by Marcus Svensson, Jan�ke R�nnblom, Bruce and Jakob Persson

        2003-07-11 Virtuality aka Jonathan Gulbrandsen (virtuality@carlssonplanet.com)
                Updated the language file to phpBB2.0.5

        2003-08-13 Virtuality aka Jonathan Gulbrandsen (virtuality@carlssonplanet.com)
                Updated to 2.0.6, no changes. Lots of "swinglish", grammars and mispellings fixed
*/

//
// Format is same as lang_main
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//
$lang['General'] = "Generell admin";
$lang['Users'] = "Anv�ndaradmin";
$lang['Groups'] = "Gruppadmin";
$lang['Forums'] = "Forumadmin";
$lang['Styles'] = "Stiladmin";

$lang['Configuration'] = "Konfiguration";
$lang['Permissions'] = "R�ttigheter";
$lang['Manage'] = "Hantering";
$lang['Disallow'] = "F�rbjuda namn";
$lang['Prune'] = "Reducering";
$lang['Mass_Email'] = "Mass email";
$lang['Ranks'] = "Ranker";
$lang['Smilies'] = "Smilies";
$lang['Ban_Management'] = "Bannlys";
$lang['Word_Censor'] = "Ordcensur";
$lang['Export'] = "Exportera";
$lang['Create_new'] = "Skapa";
$lang['Add_new'] = "L�gg till";
$lang['Backup_DB'] = "Backup av databas";
$lang['Restore_DB'] = "�terst�ll databas";


//
// Index
//
$lang['Admin'] = "Administration";
$lang['Not_admin'] = "Du har inte r�ttighet att administrera detta forum";
$lang['Welcome_phpBB'] = "V�lkommen till phpBB";
$lang['Admin_intro'] = "Tack f�r att du har valt phpBB som din foruml�sning. Den h�r sidan ger dig en snabb �verblick �ver all m�jlig statistik om ditt forum. Du kan komma tillbaka till den h�r sidan genom att klicka p� <u>Admin index</u> l�nken p� den v�nstra sidan. F�r att komma tillbaka till indexet till forumet tryck p� phpBB logon, som finns i den v�nstra panelen. De �vriga l�nkarna p� v�nster hand l�ter dig kontrollera alla aspekter p� hur ditt forum presenteras, varje sidan har intruktioner p� hur du anv�nder verktygen.";
$lang['Main_index'] = "Forumindex";
$lang['Forum_stats'] = "Forumstatistik";
$lang['Admin_Index'] = "Admin index";
$lang['Preview_forum'] = "F�rhandsgranska forum";

$lang['Click_return_admin_index'] = "Klicka %sH�r%s f�r att �terv�nda till Admin index";

$lang['Statistic'] = "Statistik";
$lang['Value'] = "V�rde";
$lang['Number_posts'] = "Antal inl�gg";
$lang['Posts_per_day'] = "Inl�gg per dag";
$lang['Number_topics'] = "Antal �mnen";
$lang['Topics_per_day'] = "�mnen per dag";
$lang['Number_users'] = "Antal anv�ndare";
$lang['Users_per_day'] = "Anv�ndare per dag";
$lang['Board_started'] = "Start av forum";
$lang['Avatar_dir_size'] = "Avatarkatalogens storlek";
$lang['Database_size'] = "Databasstorlek";
$lang['Gzip_compression'] ="Gzip komprimering";
$lang['Not_available'] = "Inte tillg�nglig";

$lang['ON'] = "P�"; // This is for GZip compression
$lang['OFF'] = "AV";


//
// DB Utils
//
$lang['Database_Utilities'] = "Databasverktyg";

$lang['Restore'] = "�terst�ll";
$lang['Backup'] = "Backup";
$lang['Restore_explain'] = "Detta kommer att utf�ra en fullst�ndig �terst�llning av alla phpBB tabeller fr�n en sparad fil. Om din server st�djer det kan du ladda upp en gzip komprimerad text fil vilken kommer att dekomprimeras. <b>VARNING</b>Detta kommer att skriva �ver all existerande data. �terst�llningen kan ta en l�ng tid att utf�ra men l�mna inte denna sida f�rr�n den �r f�rdig.";
$lang['Backup_explain'] = "H�r kan du ta backup p� alla dina phpBB relaterade data. Om du har andra egna tabeller i samma databas som phpBB som du ocks� vill s�kerhetskopiera s� ange deras namn separerad med komman i \"�vriga tabeller\"-rutan nedanf�r Om din server st�jder det kan du ocks� gzip komprimera filen f�r att minska storleken innan du laddar ner den.";

$lang['Backup_options'] = "Backup alternativ";
$lang['Start_backup'] = "Starta backup";
$lang['Full_backup'] = "Fullst�ndig backup";
$lang['Structure_backup'] = "Enbart backup av strukturen";
$lang['Data_backup'] = "Backup av endast data";
$lang['Additional_tables'] = "�vriga tabeller";
$lang['Gzip_compress'] = "Gzip komprimera filen";
$lang['Select_file'] = "V�lj en fil";
$lang['Start_Restore'] = "Starta �terst�llningen";

$lang['Restore_success'] = "Databasen �r �terst�lld utan problem.<br /><br />Ditt forum b�r vara tillbaka i samma skick som n�r du gjorde backupen.";
$lang['Backup_download'] = "Din nedladdning kommer att starta snart, var god v�nta tills den startar";
$lang['Backups_not_supported'] = "Tyv�rr s� st�ds inte backup �n av ditt databassystem";

$lang['Restore_Error_uploading'] = "Fel n�r filen skulle laddas upp.";
$lang['Restore_Error_filename'] = "Problem med filnamnet, f�rs�k med en annan fil";
$lang['Restore_Error_decompress'] = "Kunde inte dekomprimera gzip fil, f�rs�k ladda upp en textversion";
$lang['Restore_Error_no_file'] = "Ingen fil �r uppladdad";


//
// Auth pages
//
$lang['Select_a_User'] = "V�lj en anv�ndare";
$lang['Select_a_Group'] = "V�lj en grupp";
$lang['Select_a_Forum'] = "V�lj ett forum";
$lang['Auth_Control_User'] = "Anv�ndarr�ttigheter";
$lang['Auth_Control_Group'] = "Gruppr�ttigheter";
$lang['Auth_Control_Forum'] = "Forumr�ttigheter";
$lang['Look_up_User'] = "Sl� upp en anv�ndare";
$lang['Look_up_Group'] = "Sl� upp en grupp";
$lang['Look_up_Forum'] = "Sl� upp ett forum";

$lang['Group_auth_explain'] = "H�r kan du �ndra r�ttigheter och moderatorstatus f�r varje grupp. Gl�m inte att fast�n du �ndrar gruppr�ttigheten att anv�ndarens egna r�ttigheter fortfarande kan ge dom access till forum, m.m. Du kommer att f� en varning i s� fall.";
$lang['User_auth_explain'] = "H�r kan du �ndra r�ttigheter och moderator status f�r varje enskild anv�ndare. Gl�m inte att fast�n du �ndrar grupp r�ttigheten att anv�ndarens egna r�ttigheter fortfarande kan ge dom access till forum, m.m. Du kommer att f� en varning i s� fall.";
$lang['Forum_auth_explain'] = "H�r kan du �ndra auktorisionsniv�er f�r varje forum. Du har b�de en enkel och en avancerad metod f�r att g�ra detta, avancerad ger dig st�rre kontroll �ver varje forums funktioner. Kom ih�g att n�r du �ndrar r�ttigheterna till forumet s� p�verkar du vilka anv�ndare som kan utf�ra olika funktioner i forumet.";

$lang['Simple_mode'] = "Enkelt l�ge";
$lang['Advanced_mode'] = "Avancerat l�ge";
$lang['Moderator_status'] = "Moderator status";

$lang['Allowed_Access'] = "Till�t tilltr�de";
$lang['Disallowed_Access'] = "Neka tilltr�de";
$lang['Is_Moderator'] = "�r Moderator";
$lang['Not_Moderator'] = "�r inte moderator";

$lang['Conflict_warning'] = "Varning! Auktorisationskonflikt";
$lang['Conflict_access_userauth'] = "Denna anv�ndare har fortfarande tillg�ng till detta forum via gruppmedlemskap. Du kanske vill �ndra gruppr�ttigheterna eller ta bort denna anv�ndare fr�n gruppen f�r att f�rhindra att de har tilltr�de. Gruppens r�ttigheter (och ber�rda forum) listas nedan.";
$lang['Conflict_mod_userauth'] = "Anv�ndaren har fortfarande moderatorr�ttigheter till forumet via gruppmedlemskap. Du kan antingen �ndra gruppr�ttigheterna eller ta bort denna anv�ndare fr�n gruppen f�r att f�rhindra att de har moderatorr�ttigheter. Gruppens r�ttigheter (och ber�rda forum) listas nedan.";

$lang['Conflict_access_groupauth'] = "F�ljande anv�ndare har fortfarande �tkomstr�ttigheter till detta forum via deras anv�ndarr�ttigheter. Du kanske vill �ndra anv�ndarr�ttigheterna f�r att f�rhindra dem fr�n att ha �tkomst till forumet. Anv�ndarens r�ttigheter (och ber�rda forum) listas nedan.";
$lang['Conflict_mod_groupauth'] = "F�ljande anv�ndare har fortfarande moderatorr�ttigheter till forumet via anv�ndarr�ttigheter. Du kanske vill �ndra anv�ndarr�ttigheterna f�r att f�rhindra dem fr�n att ha �tkomst till forumet. Anv�ndarens r�ttigheter (och ber�rda forum) listas nedan.";

$lang['Public'] = "Publik";
$lang['Private'] = "Privat";
$lang['Registered'] = "Registrerad";
$lang['Administrators'] = "Administrat�rer";
$lang['Hidden'] = "Dold";

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = "ALLA";
$lang['Forum_REG'] = "REG";
$lang['Forum_PRIVATE'] = "PRIVAT";
$lang['Forum_MOD'] = "MOD";
$lang['Forum_ADMIN'] = "ADMIN";

$lang['View'] = "Visa";
$lang['Read'] = "L�s";
$lang['Post'] = "Inl�gg";
$lang['Reply'] = "Svara";
$lang['Edit'] = "�ndra";
$lang['Delete'] = "Radera";
$lang['Sticky'] = "Klibbig";
$lang['Announce'] = "Viktigt meddelande";
$lang['Vote'] = "R�sta";
$lang['Pollcreate'] = "Skapa omr�stning";

$lang['Permissions'] = "R�ttigheter";
$lang['Simple_Permission'] = "Enkla r�ttigheter";

$lang['User_Level'] = "Anv�ndarniv�";
$lang['Auth_User'] = "Anv�ndare";
$lang['Auth_Admin'] = "Administrat�r";
$lang['Group_memberships'] = "Gruppmedlemskap";
$lang['Usergroup_members'] = "Den h�r gruppen har f�ljande medlemmar";

$lang['Forum_auth_updated'] = "Forumr�ttigeheterna �r uppdaterade";
$lang['User_auth_updated'] = "Anv�ndarr�ttigeheterna �r uppdaterade";
$lang['Group_auth_updated'] = "Gruppr�ttigeheterna �r uppdaterade";

$lang['Auth_updated'] = "R�ttigheterna �r uppdaterade";
$lang['Click_return_userauth'] = "Klicka %sh�r%s f�r att �terg� till anv�ndarr�ttigheter";
$lang['Click_return_groupauth'] = "Klicka %sh�r%s f�r att �terg� till gruppr�ttigheter";
$lang['Click_return_forumauth'] = "Klicka %sh�r%s  f�r att �terg� till forumr�ttigheter";


//
// Banning
//
$lang['Ban_control'] = "Bannlysningskontroll";
$lang['Ban_explain'] = "H�r sk�ter du bannlysningen av anv�ndare. Du kan uppn� detta genom att bannlysa vilket som helst eller alla av en anv�ndare eller en s�rskild eller ett omr�de av IP adresser eller v�rdnamn. Dessa metoder f�rhindrar en anv�ndare fr�n att n� index sidan p� ditt forum. F�r att f�rhindra en anv�ndare att registrera under ett annat anv�ndarnamn kan du ocks� ange en bannlyst epostadress. Notera att bannlysa enbart en epostadress inte kommer att f�rhindra anv�ndaren fr�n att logga p� eller skriva ett inl�gg p� ditt forum, du b�r anv�nda n�gon av de tv� f�rsta metoderna f�r att uppn� det.";
$lang['Ban_explain_warn'] = "Notera att genom att ange ett omr�de av IP adresser s� resulterar det i att alla adresser mellan start och slut l�ggs till i banlysningslistan. En anstr�ngning kommer att g�ras f�r att minska antalet adresser som l�ggs in i databasen genom att introducera jokertecken automatiskt d�r det �r l�mpligt. Om du verkligen m�ste ange ett omr�de av adresser s� f�rs�k h�lla det litet eller �nnu b�ttre f�rs�ka att explicit ange enstaka adresserna.";

$lang['Select_username'] = "V�lj ett anv�ndarnamn";
$lang['Select_ip'] = "V�lj en IP adress";
$lang['Select_email'] = "V�lj en e-post adress";

$lang['Ban_username'] = "Bannlys en eller flera anv�ndare";
$lang['Ban_username_explain'] = 'Du kan banna flera anv�ndare p� en g�ng genom att anv�nda den r�tta kombinationen mellan mus och tangentbord';

$lang['Ban_IP'] = "Bannlys en eller flera IP adresser eller v�rdnamn";
$lang['IP_hostname'] = "IP adresser eller v�rdnamn";
$lang['Ban_IP_explain'] = "F�r att specifiera flera olika IP adresser eller v�rdnamn, skilj dem �t med kommatecken. F�r att specifiera en rad olika IP adresser separera b�rjan och slutet med ett bindesstreck(-), f�r att specifiera ett wildcard (vad som helst) anv�nd *";

$lang['Ban_email'] = "Bannlys en eller flera epost adresser";
$lang['Ban_email_explain'] = "F�r att specificera mer �n en e-post adress, skilj dem �t med kommatecken. F�r att specifiera ett wildcard (vad som helst) namn anv�nd *, till exempel *@hotmail.com";

$lang['Unban_username'] = "H�v en eller flera bannlysta anv�ndare";
$lang['Unban_username_explain'] = "Du kan ta bort flera bannlysningar samtidigt genom att anv�nda den �ndam�lsenliga kombinationen av mus och tangenbord f�r din dator och webl�sare.";

$lang['Unban_IP'] = "H�v en eller flera bannlysta IP adresser";
$lang['Unban_IP_explain'] = "Du kan ta bort flera bannlysningar av IP adresser samtidigt genom att anv�nda den �ndam�lsenliga kombinationen av mus och tangenbord f�r din dator och webl�sare.";

$lang['Unban_email'] = "H�v en eller flera bannlysta e-post adresser";
$lang['Unban_email_explain'] = "Du kan ta bort flera bannlysningar av e-post adresser samtidigt genom att anv�nda den �ndam�lsenliga kombinationen av mus och tangenbord f�r din dator och webl�sare.";

$lang['No_banned_users'] = "Inga bannlysta anv�ndarnamn";
$lang['No_banned_ip'] = "Inga bannlysta IP adresser";
$lang['No_banned_email'] = "Inga bannlysta e-post adresser";

$lang['Ban_update_sucessful'] = "Banlistan har blivit uppdaterad.";
$lang['Click_return_banadmin'] = "Klicka %sh�r%s f�r att �terv�nda till bannlysningskontrollen";


//
// Configuration
//
$lang['General_Config'] = "Generell Konfiguration";
$lang['Config_explain'] = "Formul�ret h�r ger dig m�jlighet att �ndra alla allm�nna foruminst�llningar. F�r anv�ndar och forumkonfiguration s� �nv�nd de relaterade l�nkarna p� v�nster sida.";

$lang['Click_return_config'] = "Klicka %sh�r%s f�r att �terv�nda till Generell Konfiguration";

$lang['General_settings'] = "Generella foruminst�llningar";
$lang['Server_name'] = "Dom�nnamn";
$lang['Server_name_explain'] = "Dom�nnamnet som forumet k�rs fr�n";
$lang['Script_path'] = "Skripts�kv�g";
$lang['Script_path_explain'] = "S�kv�gen d�r phpBB2 �r placerat under dom�nnamnet (dom�nnamn.com/s�kv�g)";
$lang['Server_port'] = "Serverport";
$lang['Server_port_explain'] = "Porten som servern k�rs p�, vanligtvis 80, �ndra bara om porten �r annorlunda";
$lang['Site_name'] = "Sitenamn";
$lang['Site_desc'] = "Sitebeskrivning";
$lang['Board_disable'] = "St�ng av forumet";
$lang['Board_disable_explain'] = "Detta g�r forumet otillg�ngligt f�r anv�ndarna. Logga inte ut n�r du har deaktiverat forumet, du kommer inte att kunna logga in igen!";
$lang['Acct_activation'] = "Aktivera kontoaktivering";
$lang['Acc_None'] = "Ingen"; // These three entries are the type of activation
$lang['Acc_User'] = "Anv�ndare";
$lang['Acc_Admin'] = "Administrat�r";

$lang['Abilities_settings'] = "Anv�ndar och foruminst�llningar";
$lang['Max_poll_options'] = "Maximalt antal val f�r omr�stningar";
$lang['Flood_Interval'] = "Tid mellan inl�gg";
$lang['Flood_Interval_explain'] = "Antal sekunder en anv�ndare m�ste v�nta mellan inl�ggen";
$lang['Board_email_form'] = "E-posta anv�ndare via forumet";
$lang['Board_email_form_explain'] = "Anv�ndare kan skicka e-post till varandra via forumet";
$lang['Topics_per_page'] = "�mnen per sida";
$lang['Posts_per_page'] = "Inl�gg per sida";
$lang['Hot_threshold'] = "Antal inl�gg f�r popul�ritet";
$lang['Default_style'] = "Standardstil";
$lang['Override_style'] = "�sidos�tt anv�ndarstil";
$lang['Override_style_explain'] = "Ers�tter anv�ndarens stil med standard stilen";
$lang['Default_language'] = "Standardspr�k";
$lang['Date_format'] = "Datumformat";
$lang['System_timezone'] = "Systemets tidszon";
$lang['Enable_gzip'] = "Aktivera GZip Kompression";
$lang['Enable_prune'] = "Aktivera forum reducering";
$lang['Allow_HTML'] = "Till�t HTML";
$lang['Allow_BBCode'] = "Till�t BBCode";
$lang['Allowed_tags'] = "Till�tna HTML taggar";
$lang['Allowed_tags_explain'] = "Separera taggarna med komma";
$lang['Allow_smilies'] = "Till�t smilies";
$lang['Smilies_path'] = "Smilies s�kv�g";
$lang['Smilies_path_explain'] = "S�kv�g under din phpBB root katalog, t.ex images/smilies";
$lang['Allow_sig'] = "Till�t signaturer";
$lang['Max_sig_length'] = "Maximal l�ngd p� signaturen";
$lang['Max_sig_length_explain'] = "Maximalt antal tecken i anv�ndarens signatur";
$lang['Allow_name_change'] = "Till�t �ndring av anv�ndarnamn";

$lang['Avatar_settings'] = "Avatarinst�llningar";
$lang['Allow_local'] = "Aktivera galleriavatarer";
$lang['Allow_remote'] = "Aktivera fj�rravatarer";
$lang['Allow_remote_explain'] = "G�r det m�jligt att l�nka till avatarer p� andra websiter";
$lang['Allow_upload'] = "Aktivera Avataruppladdning";
$lang['Max_filesize'] = "Maximal Avatar filstorlek";
$lang['Max_filesize_explain'] = "F�r avatarer som laddas upp";
$lang['Max_avatar_size'] = "Maximal Avatar storlek";
$lang['Max_avatar_size_explain'] = "(H�jd x Bredd i pixelar)";
$lang['Avatar_storage_path'] = "Avatar s�kv�g";
$lang['Avatar_storage_path_explain'] = "S�kv�g under din phpBB root katalog, t.ex. images/avatars";
$lang['Avatar_gallery_path'] = "Avatar galleriets s�kv�g";
$lang['Avatar_gallery_path_explain'] = "S�kv�g under din phpBB root katalog f�r f�r-laddade bilder, t.ex. images/avatars/gallery";

$lang['COPPA_settings'] = "COPPA inst�llningar";
$lang['COPPA_fax'] = "COPPA fax nummer";
$lang['COPPA_mail'] = "COPPA adress";
$lang['COPPA_mail_explain'] = "Detta �r adressen dit f�r�ldrar ska skicka registreringsforuml�ren f�r COPPA";

$lang['Email_settings'] = "E-post inst�llningar";
$lang['Admin_email'] = "Admin e-post adress";
$lang['Email_sig'] = "E-post signatur";
$lang['Email_sig_explain'] = "Denna text kommer att bifogas i all e-post som forumet skickar.";
$lang['Use_SMTP'] = "Anv�nd SMTP server f�r epost";
$lang['Use_SMTP_explain'] = "S�g ja om du vill eller m�ste skicka e-post via en angiven server ist�llet f�r via den lokala e-post funktionen";
$lang['SMTP_server'] = "SMTP server Adress";
$lang['SMTP_username'] = "SMTP Anv�ndarnamn";
$lang['SMTP_username_explain'] = "Skriv endast in ett anv�ndarnamn om din smtp server beh�ver det";
$lang['SMTP_password'] = "SMTP L�senord";
$lang['SMTP_password_explain'] = "Skriv endast in ett l�senord om din smtp server beh�ver det";

$lang['Disable_privmsg'] = "Personliga Meddelandehantering";
$lang['Inbox_limits'] = "Max inl�gg i Inl�dan";
$lang['Sentbox_limits'] = "Max inl�gg i Skickade brev";
$lang['Savebox_limits'] = "Max inl�gg i Sparade brev";

$lang['Cookie_settings'] = "Cookie/session inst�llningar";
$lang['Cookie_settings_explain'] = "Detta styr hur cookien som skickas till webl�saren �r definerad. I de flesta fall s� �r standard inst�llningarna tillr�ckliga. Om du beh�ver �ndra dessa s� g�r det med varsamhet, felaktiga inst�llningar kan hindra anv�ndare fr�n att logga in.";
$lang['Cookie_settings_explain_mxp'] = "Observera: Om du anv�nder phpBB-sessioner, anv�nds ej dessa interna inst�llningar.";
$lang['Cookie_domain'] = "Cookie dom�n";
$lang['Cookie_name'] = "Cookie namn";
$lang['Cookie_path'] = "Cookie s�kv�g";
$lang['Cookie_secure'] = "Cookie s�kerhet [ https ]";
$lang['Cookie_secure_explain'] = "Om servern k�rs via SSL aktivera det h�r, annars l�t det vara inaktiverat";
$lang['Session_length'] = "Sessionsl�ngd [ sekunder ]";

// Visual Confirmation
$lang['Visual_confirm'] = 'Aktivera Visuell Bekr�ftning';
$lang['Visual_confirm_explain'] = 'Tvingar anv�ndare att ange en kod som visas genom bilder vid registrering.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin'] = 'Till�t automatisk inloggning';
$lang['Allow_autologin_explain'] = 'Best�mmer om anv�ndare kan anv�nda automatisk inloggning';
$lang['Autologin_time'] = 'Automatisk inloggningsvaliditiet';
$lang['Autologin_time_explain'] = 'Hur l�nge den automatiska inloggningsnyckeln �r aktuell (i dagar). S�tt till noll f�r att inaktivera tidsbegr�nsning.';

// Search Flood Control - added 2.0.20
$lang['Search_Flood_Interval'] = 'Search Flood intervall';
$lang['Search_Flood_Interval_explain'] = 'Antal sekunder anv�ndaren m�ste v�nta mellan s�kningar';

//
// Forum Management
//
$lang['Forum_admin'] = "Forum Administration";
$lang['Forum_admin_explain'] = "Fr�n denna panel kan du l�gga till, radera, �ndra, sortera och synkronisera katagorier och forum";
$lang['Edit_forum'] = "�ndra forum";
$lang['Create_forum'] = "Skapa nytt forum";
$lang['Create_category'] = "Skapa ny kategori";
$lang['Remove'] = "Radera";
$lang['Action'] = "Handling";
$lang['Update_order'] = "Uppdatera sorteringsordning";
$lang['Config_updated'] = "Forumkonfigurationen �r uppdaterad";
$lang['Edit'] = "�ndra";
$lang['Delete'] = "Radera";
$lang['Move_up'] = "Flytta upp";
$lang['Move_down'] = "Flytta ner";
$lang['Resync'] = "Synkronisera";
$lang['No_mode'] = "Inget mode angavs";
$lang['Forum_edit_delete_explain'] = "Foruml�ret under l�ter dig skr�ddarsy alla allm�nna foruminst�llningar. Anv�nd relaterad l�nkar p� v�nster sida f�r anv�ndar och forum konfiguraration";

$lang['Move_contents'] = "Flytta allt inneh�ll";
$lang['Forum_delete'] = "Radera forum";
$lang['Forum_delete_explain'] = "Foruml�ret under l�ter dig radera ett forum (eller kategori) och tala om var du vill flytta alla �mnen (eller forum) som det inneh�ll.";

$lang['Status_locked'] = 'L�st';
$lang['Status_unlocked'] = '�ppen';
$lang['Forum_settings'] = "Generella foruminst�llningar";
$lang['Forum_name'] = "Forumnamm";
$lang['Forum_desc'] = "Beskrivning";
$lang['Forum_status'] = "Forum status";
$lang['Forum_pruning'] = "Autoreducering";

$lang['prune_freq'] = 'S�k efter gamla �mnen varje';
$lang['prune_days'] = "Ta bort �mnen som inte har svarats p� efter";
$lang['Set_prune_data'] = "Du har aktiverat autoreducering f�r detta forum men har inte satt en frekvens eller antal dagar f�r reducering. G� tillbaka och s�tt detta";

$lang['Move_and_Delete'] = "Flytta och radera";

$lang['Delete_all_posts'] = "Radera alla inl�gg";
$lang['Nowhere_to_move'] = "Ingenstans att flytta till";

$lang['Edit_Category'] = "�ndra kategori";
$lang['Edit_Category_explain'] = "Anv�nda detta foruml�r f�r att modifiera kategorinamnet.";

$lang['Forums_updated'] = "Forum och kategori-information �r uppdaterad";

$lang['Must_delete_forums'] = "Du m�ste radera alla forum innan du kan radera denna kategori";

$lang['Click_return_forumadmin'] = "Klicka %sh�r%s f�r att �terg� till Forum Administrationen";


//
// Smiley Management
//
$lang['smiley_title'] = "Smiles redigering";
$lang['smile_desc'] = "P� denna sida kan du l�gga till, radera och redigera emoticons eller smileys som dina anv�ndare kan anv�nda i inl�gg och personliga meddelanden.";

$lang['smiley_config'] = "Smiley konfiguration";
$lang['smiley_code'] = "Smiley kod";
$lang['smiley_url'] = "Smiley bildfil";
$lang['smiley_emot'] = "Smiley Emotion";
$lang['smile_add'] = "L�gg till en ny Smiley";
$lang['Smile'] = "Smile";
$lang['Emotion'] = "Emotion";

$lang['Select_pak'] = "V�lj paket (.pak) fil";
$lang['replace_existing'] = "Ers�tt befintlig Smiley";
$lang['keep_existing'] = "Beh�ll befintlig Smiley";
$lang['smiley_import_inst'] = "Du b�r packa upp (unzip) smiley paketet och ladda upp alla filer till avsedd smiley katalog f�r din installation. Sen s�tter du r�tt information i detta formul�r och importerar smiley paketet.";
$lang['smiley_import'] = "Smiley paket import";
$lang['choose_smile_pak'] = "V�lj en Smile Pack .pak fil";
$lang['import'] = "Importera Smileys";
$lang['smile_conflicts'] = "Vad ska g�ras om det finns konflikter";
$lang['del_existing_smileys'] = "Radera befintlig smileys f�re import";
$lang['import_smile_pack'] = "Importera Smiley paket";
$lang['export_smile_pack'] = "Skapa Smiley paket";
$lang['export_smiles'] = "F�r att skapa ett smiley paket fr�n dina installerade smileys, klicka %sh�r%s f�r att ladda ner smiles.pak filen. Ge filen ett passande namn och se till att beh�lla .pak till�gget.  Skapa sen en zip fil som inneh�ller alla dina smileys bilder plus din .pak konfigurations fil.";

$lang['smiley_add_success'] = "Smileyn adderades.";
$lang['smiley_edit_success'] = "Smileyn uppdaterades";
$lang['smiley_import_success'] = "Smiley paketet �r importerat!";
$lang['smiley_del_success'] = "Smileyn togs bort";
$lang['Click_return_smileadmin'] = "Klicka %sh�r%s f�r att �terg� Smiley Administrationen";

//
// Group control panel
//
$lang['Group_Control_Panel'] = 'Gruppkontrollpanel';
$lang['Group_member_details'] = 'Gruppmedlemskapsdetaljer';
$lang['Group_member_join'] = 'G� med i en grupp';

$lang['Group_Information'] = 'Gruppinformation';
$lang['Group_name'] = 'Gruppnamn';
$lang['Group_description'] = 'Gruppbeskrivning';
$lang['Group_membership'] = 'Gruppmedlemskap';
$lang['Group_Members'] = 'Gruppmedlemmar';
$lang['Group_Moderator'] = 'Gruppmoderator';
$lang['Pending_members'] = 'Medlemskapsf�rfr�gningar';

$lang['Group_type'] = 'Grupptyp';
$lang['Group_open'] = '�ppen grupp';
$lang['Group_closed'] = 'St�ngd grupp';
$lang['Group_hidden'] = 'Dold grupp';

$lang['Current_memberships'] = 'Grupper du �r med i';
$lang['Non_member_groups'] = 'Grupper du ej �r med i';
$lang['Memberships_pending'] = 'Medlemskapsf�rfr�gningar';

$lang['No_groups_exist'] = 'Det finns inga grupper';
$lang['Group_not_exist'] = 'Den anv�ndargruppen finns inte';

$lang['Join_group'] = 'G� med i grupp';
$lang['No_group_members'] = 'Den h�r gruppen har inga medlemmar';
$lang['Group_hidden_members'] = 'Den h�r gruppen �r dold, du kan inte se dess medlemmar';
$lang['No_pending_group_members'] = 'Den h�r gruppen har inga medlemskapsf�rfr�gningar';
$lang['Group_joined'] = 'Du har nu ans�kt om att bli medlem i den h�r gruppen<br />Du kommer att bli meddelad om du blir godk�nd som medlem eller inte av gruppmoderatorn.';
$lang['Group_request'] = 'En f�rfr�gan att om att bli medlem i din grupp har gjorts.';
$lang['Group_approved'] = 'Din f�rfr�gan har godk�nnts.';
$lang['Group_added'] = 'Du har lagts till i den h�r anv�ndargruppen.';
$lang['Already_member_group'] = 'Du �r redan medlem av den h�r gruppen.';
$lang['User_is_member_group'] = 'Anv�ndaren �r redan medlem i den h�r gruppen.';
$lang['Group_type_updated'] = 'Uppdaterade grupptypen.';

$lang['Could_not_add_user'] = 'Anv�ndaren du valde existerar inte.';
$lang['Could_not_anon_user'] = 'Du kan inte g�ra en Anonym till medlem i gruppen.';

$lang['Confirm_unsub'] = '�r du s�ker p� att du vill l�mna den h�r gruppen?';
$lang['Confirm_unsub_pending'] = 'Ditt medlemskap i den h�r gruppen har inte �n blivit godk�nt, �r du s�ker p� att du vill avbryta ans�kan?';

$lang['Unsub_success'] = 'Ditt medlemskap i den h�r gruppen har avbrutits.';

$lang['Approve_selected'] = 'Godk�nn valda';
$lang['Deny_selected'] = 'Avsl� valda';
$lang['Not_logged_in'] = 'Du m�ste logga in f�r att g� med i en grupp.';
$lang['Remove_selected'] = 'Ta bort valda';
$lang['Add_member'] = 'L�gg till Medlem';
$lang['Not_group_moderator'] = 'Du �r inte moderator av den h�r gruppen och d�rf�r kan du inte g�ra det h�r.';

$lang['Login_to_join'] = 'Logga in f�r att kontollera gruppmedlemskap';
$lang['This_open_group'] = 'Det h�r �r en �ppen grupp, klicka f�r att beg�ra medlemskap';
$lang['This_closed_group'] = 'Det h�r �r en st�ngd grupp, inga fler medlemmar accepteras';
$lang['This_hidden_group'] = 'Det h�r �r en dold grupp, fler medlemmar kan inte l�ggas till automatiskt';
$lang['Member_this_group'] = 'Du �r medlem i den h�r gruppen';
$lang['Pending_this_group'] = 'Ditt medlemskap i den h�r gruppen �r under behandling';
$lang['Are_group_moderator'] = 'Du �r moderator i den h�r gruppen';
$lang['None'] = 'Inga';

$lang['Subscribe'] = 'Ans�k om medlemskap';
$lang['Unsubscribe'] = 'Avbryt medlemskap';
$lang['View_Information'] = 'Visa Information';

//
// Prune Administration
//
$lang['Forum_Prune'] = "Forumreducering";
$lang['Forum_Prune_explain'] = "Detta kommer att radera alla �mnen d�r inga nya inl�gg har skrivits inom det antal dagar du angett. Om du inte anger ett nummer s� kommer alla �mnen att raderas. Det kommer inte att radera �mnen inom vilka omr�stningar fortfarande �r aktiva och det kommer inte heller att ta bort tillk�nnagivelser. Du beh�ver radera dessa �mnen manuellt";
$lang['Do_Prune'] = "Reducera";
$lang['All_Forums'] = "Alla forum";
$lang['Prune_topics_not_posted'] = "Radera �mnen med inga svar i efter detta antal dagar";
$lang['Topics_pruned'] = "�mnen reducerade";
$lang['Posts_pruned'] = "Inl�gg reducerade";
$lang['Prune_success'] = "Reduceringen gick bra";


//
// Word censor
//
$lang['Words_title'] = "Censurering av ord";
$lang['Words_explain'] = "Fr�n denna kontrollpanel kan du l�gga till, redigera och radera ord som automatiskt kommer at bli censurerade i dina forum. Dessutom kommer man inte att till�tas att registera anv�ndarnamn som inneh�ller dessa ord. Wildcards (*) accepteras i ord f�ltet, eg. *test* matchar omtestning, test* matchar testning, *test matchar sluttest.";
$lang['Word'] = "Ord";
$lang['Edit_word_censor'] = "Redigera ordcensur";
$lang['Replacement'] = "Ers�ttning";
$lang['Add_new_word'] = "L�gg till nytt ord";
$lang['Update_word'] = "Uppdatera ordcensur";

$lang['Must_enter_word'] = "Du m�ste skriva ett ord och dess ers�ttning";
$lang['No_word_selected'] = "Inget ord �r valt f�r redigering";

$lang['Word_updated'] = "Censuren �r uppdaterad";
$lang['Word_added'] = "Ordet har lagts till censuren";
$lang['Word_removed'] = "Ordet har tagits bort fr�n censuren";

$lang['Click_return_wordadmin'] = "Klicka %sh�r% f�r att �terg� till censurering av ord";


//
// Mass Email
//
$lang['Mass_email_explain'] = "H�r kan du skicka ett e-post meddelande till antingen alla dina anv�ndare eller till anv�ndare i en specifik grupp.  F�r att kunna g�ra detta, kommer ett email att skickas till den administrativa epost adressen som du angett, med en bcc till alla mottagare. Ha lite t�lamod om du mailar en stor grupp av m�nniskor efter att ha skickat meddelandet och avbryt inte sidan halvv�gs igenom. Det �r normalt f�r mass epost (spam) att ta en l�ngre tid, du kommer att meddelas n�r skriptet �r klart.";
$lang['Compose'] = "Komponerna";

$lang['Recipients'] = "Mottagare";
$lang['All_users'] = "Alla anv�ndare";

$lang['Email_successfull'] = "Ditt meddelande har skickats";
$lang['Click_return_massemail'] = "Klicka %sh�r%s f�r att �terg� till mass e-post formul�ret";


//
// Ranks admin
//
$lang['Ranks_title'] = "Titel Administration";
$lang['Ranks_explain'] = "Via detta foruml�r kan du skapa nya, redigera, visa och ta bort titlar. Du kan ocks� skapa speciella titlar som kan tilldelas till en anv�ndare via anv�ndaradministration.";

$lang['Add_new_rank'] = "L�gg till en ny titel";

$lang['Rank_title'] = "Namn p� titel";
$lang['Rank_special'] = "s�tt som speciell titel";
$lang['Rank_minimum'] = "Minimum antal inl�gg";
$lang['Rank_maximum'] = "Maximum antal inl�gg";
$lang['Rank_image'] = "Titel bild (relativt till phpBB2 root katalogen)";
$lang['Rank_image_explain'] = "Anv�nda denna f�r att tala om vilken bild som ska associeras med titeln";

$lang['Must_select_rank'] = "Du m�ste v�lja en titel";
$lang['No_assigned_rank'] = "Ingen speciell titel tilldelad";

$lang['Rank_updated'] = "Titeln �r uppdaterad";
$lang['Rank_added'] = "Titeln las till";
$lang['Rank_removed'] = "Titeln raderades";
$lang['No_update_ranks'] = 'Titeln raderades. Hursomhelst, anv�ndar konton som anv�nder denna titel blev inte uppdaterade.  Du m�ste manuellt �terst�lla titeln p� dessa konton.';

$lang['Click_return_rankadmin'] = "Klicka %sh�r%s f�r att �terg� till Titel administration";


//
// Disallow Username Admin
//
$lang['Disallow_control'] = "F�rbjuda anv�ndarnamn";
$lang['Disallow_explain'] = "H�r kan du styra vilka anv�ndarnamn som inte f�r anv�ndas.  F�rbjudna anv�ndarnamn f�r inneh�lla wildcard (*).  Notera att du inte kan f�rbjuda redan registrerade anv�ndarnamn, du m�ste f�rst radera anv�ndaren f�r att sedan f�rbjuda den";

$lang['Delete_disallow'] = "Radera";
$lang['Delete_disallow_title'] = "Radera ett f�rbjudet namn";
$lang['Delete_disallow_explain'] = "Du kan radera ett f�rbjudet anv�ndarnamn genom att v�lja namnet fr�n listan och klicka p� skicka";

$lang['Add_disallow'] = "L�gg till";
$lang['Add_disallow_title'] = "L�gg till ett f�rbjudet namn";
$lang['Add_disallow_explain'] = "Du kan f�rbjuda ett anv�ndarnamn med hj�lp av jokertecknet * f�r att matcha vilket tecken som helst";

$lang['No_disallowed'] = "Inga f�rbjudna anv�ndarnamn";

$lang['Disallowed_deleted'] = "Anv�ndarnamnet �r giltigt igen";
$lang['Disallow_successful'] = "Anv�ndarnamnet har f�rbjudits";
$lang['Disallowed_already'] = "Namnet som du angav kan inte f�rbjudas. Antingen finns det redan i listan, eller i ordcensur listan, eller s� finns anv�ndaren redan.";

$lang['Click_return_disallowadmin'] = "Klicka %sh�r%s f�r att �terg� till F�rbjuda anv�ndarnamn";


//
// Styles Admin
//
$lang['Styles_admin'] = "Stil Administration";
$lang['Styles_explain'] = "Genom denna kontrollpanel kan du l�gga till, radera och hantera stilar (mallar och teman) som �r tillg�ngliga f�r dina anv�ndare";
$lang['Styles_addnew_explain'] = "F�ljande lista inneh�ller alla teman som �r tillg�ngliga f�r de mallar som du har. Artiklarna p� denna lista har �nnu inte blivit installerade i phpBB databasen. F�r att installera ett tema klicka p� install l�nken brevid en post.";

$lang['Select_template'] = "V�lj en mall";

$lang['Style'] = "Stil";
$lang['Template'] = "Mall";
$lang['Install'] = "Installera";
$lang['Download'] = "Ladda ner";

$lang['Edit_theme'] = "Redigera tema";
$lang['Edit_theme_explain'] = "I foruml�ret h�r under kan du redigera inst�llningarna f�r valt tema";

$lang['Create_theme'] = "Skapa tema";
$lang['Create_theme_explain'] = "Anv�nd foruml�ret h�r f�r att skapa ett nytt tema f�r vald mall. N�r du anger f�rger (vilka b�r anges i hexadecimal form) f�r du inte inkludera #, i.e.. CCCCCC �r giltigt, #CCCCCC �r inte det.";

$lang['Export_themes'] = "Exportera teman";
$lang['Export_explain'] = "I denna kontrollpanel har du m�jlighet att exportera tema data f�r en mall. V�lj en mall fr�n listan och skriptet kommer att f�rs�ka skapa en tema konfigurationsfil samt spara den till mall katalogen. Om skriptet inte kan spara filen sj�lv kommer du att ges m�jlighet att ladda hem den. F�r att skriptet ska kunna spara filen m�ste du ge skriv r�ttigheter till webserver i malla katalogen. F�r mer information om detta se phpBB 2 anv�ndarguide.";

$lang['Theme_installed'] = "Det valda temat har installerats.";
$lang['Style_removed'] = "Den valda stilen har tagits bort fr�n databasen. F�r att fullst�ndigt ta bort denna stil fr�n ditt system m�ste du radera de stilen fr�n din mall katalog.";
$lang['Theme_info_saved'] = "Tema information f�r vald mall har sparats. Du b�r nu �terst�lla r�ttigheterna p� theme_info.cfg (och p� mall katalogen) till l�s r�ttigheter.";
$lang['Theme_updated'] = "Det valda temat har uppdaterats. Du b�r nu exportera de nya tema inst�llningarna";
$lang['Theme_created'] = "Temat har skapas. Du b�r nu exportera temat till tema konfigurationsfilen f�r s�kerhets skull och f�r anv�ndning p� andra forum";

$lang['Confirm_delete_style'] = "�r du s�ker p� att du vill radera denna stil";

$lang['Download_theme_cfg'] = "Exporeraren kunde inte spara tema informationsfilen. Klicka p� kanppen nedan f�r att ladda ner denna fil med din webl�sare. N�r du har laddat hem den kan du �verf�ra den till katalogen som inneh�ller mall filerna. Du kan d�refter paketera filerna f�r distribution eller f�r anv�ndning n�gon annanstans om du s� �nskar";
$lang['No_themes'] = "Mallen du har valt har inga teman knuta till den. Skapa ett nytt tema genom att klicka p� Skapa Ny l�nken p� v�nster sida om panelen.";
$lang['No_template_dir'] = "Kan inte �ppna mall katalogen. Den kan vara ol�sbar av webservern (kontrollera r�ttigheterna) eller saknas.";
$lang['Cannot_remove_style'] = "Du kan inte ta bort den valda stilen d� den just nu �r de forumets standard stil. �ndra standard stil och f�rs�k igen.";
$lang['Style_exists'] = "Stilen finns redan, g� tillbaka ovh v�lj ett annat namn.";

$lang['Click_return_styleadmin'] = "Klicka %sH�r%s f�r att �terg� till Stiladministrationen";

$lang['Theme_settings'] = "Temainst�llningar";
$lang['Theme_element'] = "Tema Element";
$lang['Simple_name'] = "Enkelt namn";
$lang['Value'] = "V�rde";
$lang['Save_Settings'] = "Spara inst�llningar";

$lang['Stylesheet'] = "CSS Stylesheet";
$lang['Stylesheet_explain'] = 'Filnamn f�r detta CSS Stylesheet.';
$lang['Background_image'] = "Bakgrundsbild";
$lang['Background_color'] = "Bakgrundsf�rg";
$lang['Theme_name'] = "Tema namn";
$lang['Link_color'] = "L�nkf�rg";
$lang['Text_color'] = "Textf�rg";
$lang['VLink_color'] = "Bes�kt l�nkf�rg";
$lang['ALink_color'] = "Aktiv l�nkf�rg";
$lang['HLink_color'] = "Hover l�nkf�rg";
$lang['Tr_color1'] = "Table Row Colour 1";
$lang['Tr_color2'] = "Table Row Colour 2";
$lang['Tr_color3'] = "Table Row Colour 3";
$lang['Tr_class1'] = "Table Row Class 1";
$lang['Tr_class2'] = "Table Row Class 2";
$lang['Tr_class3'] = "Table Row Class 3";
$lang['Th_color1'] = "Table Header Colour 1";
$lang['Th_color2'] = "Table Header Colour 2";
$lang['Th_color3'] = "Table Header Colour 3";
$lang['Th_class1'] = "Table Header Class 1";
$lang['Th_class2'] = "Table Header Class 2";
$lang['Th_class3'] = "Table Header Class 3";
$lang['Td_color1'] = "Table Cell Colour 1";
$lang['Td_color2'] = "Table Cell Colour 2";
$lang['Td_color3'] = "Table Cell Colour 3";
$lang['Td_class1'] = "Table Cell Class 1";
$lang['Td_class2'] = "Table Cell Class 2";
$lang['Td_class3'] = "Table Cell Class 3";
$lang['fontface1'] = "Textstil 1";
$lang['fontface2'] = "Textstil 2";
$lang['fontface3'] = "Textstil 3";
$lang['fontsize1'] = "Textstil 1";
$lang['fontsize2'] = "Textstil 2";
$lang['fontsize3'] = "Textstil 3";
$lang['fontcolor1'] = "Textf�rg 1";
$lang['fontcolor2'] = "Textf�rg 2";
$lang['fontcolor3'] = "Textf�rg 3";
$lang['span_class1'] = "Span Class 1";
$lang['span_class2'] = "Span Class 2";
$lang['span_class3'] = "Span Class 3";
$lang['img_poll_size'] = "Omr�stning bild storlek [px]";
$lang['img_pm_size'] = "Personligt meddelande status storlek [px]";


//
// Install Process
//
$lang['Welcome_install'] = "V�lkommen till phpBB 2 Installationen";
$lang['Initial_config'] = "Grundl�ggande  konfiguration";
$lang['DB_config'] = "Databas konfiguration";
$lang['Admin_config'] = "Admin konfiguration";
$lang['continue_upgrade'] = "N�r du har laddat ner din config fil till din lokala maskin kan du v�lja \"Forts�tta uppgraderingen\" knappen nedan f�r att forts�tta uppgraderingsprocessen. V�nta med att ladda upp config filen tills uppgraderingsprocessen �r f�rdig.";
$lang['upgrade_submit'] = "Forts�tta uppgraderingen";

$lang['Installer_Error'] = "Ett fel har uppst�tt under installationen";
$lang['Previous_Install'] = "En f�reg�ende installation har uppt�ckts";
$lang['Install_db_error'] = "Ett fel uppstod vid uppdateringen av databasen";

$lang['Re_install'] = "Din f�reg�ende installation �r fortfarande aktiv. <br /><br />Om du vill ominstallera phpBB 2 b�r du klicka p� Ja-knappen nedan. Var medveten om att detta f�rst�r all befintlig data, ingen s�kerhetskopiering kommer att ske! Administrat�rs anv�ndarnamnet och l�senord som du har anv�nt f�r att logga in till forumet kommer att �terskapas efter ominstallation, inga andra inst�llningar kommer att beh�llas. <br /><br />T�nk igenom det noga innan du trycker p� Ja!";

$lang['Inst_Step_0'] = "Tack f�r att du valt phpBB 2. F�r att fullborda installation fyll i information som efterfr�gas nedan. Notera att databasen som du vill installera till m�ste finnas. Om du installerar till en databas som anv�nder ODBC, e.g. MS Access s� b�r du f�rst skapa en DSN f�r den innan du g�r vidare.";

$lang['Start_Install'] = "Starta installationen";
$lang['Finish_Install'] = "Avsluta installationen";

$lang['Default_lang'] = "Standardspr�k i forumet";
$lang['DB_Host'] = "Databasserver v�rdnamn / DSN";
$lang['DB_Name'] = "Ditt databasnamn";
$lang['DB_Username'] = "Databas anv�ndarnamn";
$lang['DB_Password'] = "Databas l�senord";
$lang['Database'] = "Din databas";
$lang['Install_lang'] = "V�lj spr�k f�r installation";
$lang['dbms'] = "Databastyp";
$lang['Table_Prefix'] = "Prefix f�r tabeller i databasen";
$lang['Admin_Username'] = "Administrat�r anv�ndarnamn";
$lang['Admin_Password'] = "Administrat�r l�senord";
$lang['Admin_Password_confirm'] = "Administrat�r l�senord [ bekr�fta ]";

$lang['Inst_Step_2'] = "Din administrat�rsanv�ndare har skapats. Vid detta tillf�lle �r din grundinstallation f�rdig. Du kommer nu att skickas till en sida d�r du har m�jlighet att administrera din nya installation. Var god kontrollera dina Allm�na inst�llningar och g�r n�dv�ndiga �ndringar. Tack f�r att du valt phpBB 2.";

$lang['Unwriteable_config'] = "Din config-fil �r icke skrivbar f�r tillf�llet. En kopia av config filen kommer att skickas till dig n�r du klickar p� kanppen nedan. Du b�r ladda upp denna fil till samma katalog som phpBB 2. N�r detta �r gjort b�r du logga in med ditt administrat�r anv�ndarnamn och l�senord (som du angav i ett tidigare formul�r) och bes�ka administrat�rskontrollpanelen (en l�nk kommer att finns l�ngst ner p� varje sida n�r du v�l har logga int) f�r att kontrollera den allm�nna konfigurationen. Tack f�r att du valt phpBB 2.";
$lang['Download_config'] = "Ladda ner konfiguration";

$lang['ftp_choose'] = "V�lj nedladdningsmetod";
$lang['ftp_option'] = "<br />Eftersom FTP till�gg �r aktiverat i denna version av PHP ges du ocks� m�jlighet att f�rs�ka ftp:a config filen till servern helt automatiskt.";
$lang['ftp_instructs'] = "Du har valt att ftp:a filen till kontot som har phpBB 2 helt automatiskt. Ange informationen som saknas nedan. Notera att FTP s�kv�gen ska vara exakt samma s�kv�g till din phpBB 2 installation som du skulle anv�nda om du anv�nder en vanlig ftp klient.";
$lang['ftp_info'] = "Ange din FTP information";
$lang['Attempt_ftp'] = "F�rs�ker skriva config-filen till r�tt st�lle via ftp";
$lang['Send_file'] = "Skicka filen till mig s� fixar jag det manuellt via ftp";
$lang['ftp_path'] = "FTP s�kv�g till phpBB 2";
$lang['ftp_username'] = "Ditt FTP anv�ndarnamn";
$lang['ftp_password'] = "Ditt FTP l�senord";
$lang['Transfer_config'] = "Starta �verf�ring";
$lang['NoFTP_config'] = "F�rs�ket att ftp:a config-filen misslyckades. Ladda hem filen och ftp:a upp filen manuellt.";

$lang['Install'] = "Installera";
$lang['Upgrade'] = "Uppgradera";


$lang['Install_Method'] = "V�lj installationsmetod";

$lang['Install_No_Ext'] = "PHP konfigurationen p� din server st�djer inte den databas typ du har valt";

$lang['Install_No_PCRE'] = "phpBB2 kr�ver den \"Perl-Compatible Regular Expressions Module for php\" vilket din php konfiguration inte st�djer";

// Version Check
//
$lang['Version_up_to_date'] = 'Din installation anv�nder senaste phpBB versionen, inga nya uppdateringar finns tillg�ngliga.';
$lang['Version_not_up_to_date'] = 'Din phpBB installation �r <b>inte</b> uppdaterad. Det finns nya uppdateringar tillg�ngliga, v�nligen bes�k <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/downloads.php</a> f�r att tillg� senaste versionen.';
$lang['Latest_version_info'] = 'Senaste versionen �r <b>phpBB %s</b>.';
$lang['Current_version_info'] = 'Du anv�nder <b>phpBB %s</b>.';
$lang['Connect_socket_error'] = 'Tyv�rr, lyckas inte ansluta till phpBB servern, rapporterat fel �r:<br />%s';
$lang['Socket_functions_disabled'] = 'Lyckas inte �ppna socketfunktion.';
$lang['Mailing_list_subscribe_reminder'] = 'F�r information om senaste phpBB version, anslut dig till <a href="http://www.phpbb.com/support/" target="_new">phpBB mailing list</a>.';
$lang['Version_information'] = 'Versioninformation';

//
// Login attempts configuration
//
$lang['Max_login_attempts'] = 'Allowed login attempts';
$lang['Max_login_attempts_explain'] = 'The number of allowed board login attempts.';
$lang['Login_reset_time'] = 'Login lock time';
$lang['Login_reset_time_explain'] = 'Time in minutes the user have to wait until he is allowed to login again after exceeding the number of allowed login attempts.';

//
// That's all Folks!
// -------------------------------------------------

?>