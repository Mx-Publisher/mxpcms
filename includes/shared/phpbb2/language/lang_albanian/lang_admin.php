<?php

/***************************************************************************
 *                            lang_admin.php [English]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_admin.php,v 1.1 2002/04/01 12:45:01 psotfx Exp $
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
$lang['General'] = "Administrim i P�rgjithsh�m";
$lang['Users'] = "Administrim i An�tar�ve";
$lang['Groups'] = "Administrim i Grupeve";
$lang['Forums'] = "Administrim i Forumeve";
$lang['Styles'] = "Administrim i Paraqitjes";

$lang['Configuration'] = "Konfigurimi";
$lang['Permissions'] = "Autorizimet";
$lang['Manage'] = "Menaxhimi";
$lang['Disallow'] = "Mos lejo emrat";
$lang['Prune'] = "Shkurtimi";
$lang['Mass_Email'] = "Email Masiv";
$lang['Ranks'] = "Gradimi";
$lang['Smilies'] = "Figurinat";
$lang['Ban_Management'] = "P�rjashtimet";
$lang['Word_Censor'] = "Fjal�t e Censuruara";
$lang['Export'] = "Eksporto";
$lang['Create_new'] = "Krijo";
$lang['Add_new'] = "Shto";
$lang['Backup_DB'] = "Krijo nj� kopje t� Regjistrit";
$lang['Restore_DB'] = "Rivendos Regjistrin";



//
// Index
//
$lang['Admin'] = "Administrim";
$lang['Not_admin'] = "Ju nuk keni autorizim p�r t� modifikuar k�t� forum";
$lang['Welcome_phpBB'] = "Mir�sevini tek phpBB";
$lang['Admin_intro'] = "Ju fal�nderojm� q� zgjodh�t phpBB p�r forumin tuaj. Kjo faqe jep nj� p�rmbledhje t� statistikave kryesore p�r forumin tuaj. Kthehuni tek kjo faqe duke klikuar mbi butonin <u>Indeksi i Administrimit</u> n� an�n e majt� t� faqes. Klikoni ikon�n e phpBB p�r t� shkuar tek indeksi kryesor i forumeve. Lidhjet e tjera n� an�n e majte t� faqes mund�sojn� kontrollin e plot� t� forumit dhe p�rmbajn� udh�zime mbi p�rdorimin e cdo kontrolli.";
$lang['Main_index'] = "Indeksi i Forumit";
$lang['Forum_stats'] = "Statistikat e Forumit";
$lang['Admin_Index'] = "Indeksi i Administrimit";
$lang['Preview_forum'] = "Shqyrto Forumin";

$lang['Click_return_admin_index'] = "Kliko %sk�tu%s p�r t� shkuar tek indeksi i administrimit";

$lang['Statistic'] = "Statistika";
$lang['Value'] = "Vlera";
$lang['Number_posts'] = "Numri i postimeve";
$lang['Posts_per_day'] = "Postime n� dit�";
$lang['Number_topics'] = "Numri i temave";
$lang['Topics_per_day'] = "Tema n� dit�";
$lang['Number_users'] = "Numri i an�tar�ve";
$lang['Users_per_day'] = "An�tar� n� dit�";
$lang['Board_started'] = "Forumi filloi";
$lang['Avatar_dir_size'] = "Madh�sia e direktoris� s� fotos personale";
$lang['Database_size'] = "Madh�sia e regjistrit";
$lang['Gzip_compression'] ="Kompresimi me Gzip";
$lang['Not_available'] = "Nuk ofrohet";

$lang['ON'] = "Aktiv"; // This is for GZip compression
$lang['OFF'] = "Jo-aktiv"; 


//
// DB Utils
//
$lang['Database_Utilities'] = "Vegla t� dobishme p�r p�rpunimin e regjistrit";

$lang['Restore'] = "Rivendos";
$lang['Backup'] = "Krijo kopje";
$lang['Restore_explain'] = "Ky veprim do kryej� nj� rivendosje t� plot� t� t� gjitha tabelave t� phpBB nga nj� skedar. Nqs serveri juaj e lejon, ju mund t� ngarkoni nj� skedar t� kompresuar me gzip. <b>KUJDES</b> Ky veprim do rishkruaj� t� gjitha t� dh�nat e forumit. Procesi i rivendosjes mund t� k�rkoj� shum� koh�, ju lutem mos ikni nga kjo faqe deri n� p�rfundim t� procesit!";
$lang['Backup_explain'] = "K�tu mund t� krijoni nj� kopje t� plot� t� phpBB. Nqs keni tabela speciale n� t� nj�jtin regjist�r me phpBB dhe doni ti kopjoni n� t� nj�jtin skedar, specifikoni emrat e tyre duke i ndar� me presje tek kutia e Tabelave Shtes�. Nqs serveri juaj e lejon, ju mund t� kompresoni skedarin me gzip para se ta shkarkoni.";

$lang['Backup_options'] = "Mund�sit� p�r Kopjen";
$lang['Start_backup'] = "Fillo kopjimin";
$lang['Full_backup'] = "Kopjim i plot�";
$lang['Structure_backup'] = "Vet�m - Kopjim i struktur�s";
$lang['Data_backup'] = "Vet�m - Kopjim i t� dh�nave";
$lang['Additional_tables'] = "Tabela Shtes�";
$lang['Gzip_compress'] = "Kompreso skedarin me gzip";
$lang['Select_file'] = "Zgjidh nj� skedar";
$lang['Start_Restore'] = "Fillo rivendosjen";

$lang['Restore_success'] = "Regjistri u rivendos n� m�nyr� t� suksesshme.<br /><br />Forumi juaj duhet t� kthehet n� gjendjen q� kishte kur u kopjua.";
$lang['Backup_download'] = "Shkarkimi do filloje s� shpejti, prisni deri sa t� filloj�";
$lang['Backups_not_supported'] = "Na vjen keq, por kopjimi nuk mb�shtetet p�r k�t� lloj regjistri";

$lang['Restore_Error_uploading'] = "Problem me ngarkimin e skedarit (kopja e regjistrit)";
$lang['Restore_Error_filename'] = "Problem me emrin e skedarit, provo nj� skedar tjet�r";
$lang['Restore_Error_decompress'] = "Nuk dekompreson dot skedarin me gzip, ngarkoni nj� text-file";
$lang['Restore_Error_no_file'] = "Asnj� skedar nuk u ngarkua";


//
// Auth pages
//
$lang['Select_a_User'] = "Zgjidh nj� an�tar";
$lang['Select_a_Group'] = "Zgjidh nj� grup";
$lang['Select_a_Forum'] = "Zgjidh nj� forum";
$lang['Auth_Control_User'] = "Kontrolli i autorizimeve personale"; 
$lang['Auth_Control_Group'] = "Kontrolli i autorizimeve t� grupeve"; 
$lang['Auth_Control_Forum'] = "Kontrolli i autorizimeve p�r forumet"; 
$lang['Look_up_User'] = "Analizo an�tarin"; 
$lang['Look_up_Group'] = "Analizo grupin"; 
$lang['Look_up_Forum'] = "Analizo forumin"; 

$lang['Group_auth_explain'] = "K�tu mund t� ndryshoni autorizimet dhe statusin e moderatorit q� i jan� caktuar cdo grupi an�tar�sh. Kujdes, mos harroni q� ndryshimi i autorizimeve p�r grupin mund t� mos ndikoj� autorizimet personale, etj. Ju do paralajm�roheni n� k�to raste.";
$lang['User_auth_explain'] = "K�tu mund t� ndryshoni autorizimet dhe statusin e moderatorit q� i jan� caktuar cdo p�rdoruesi. Kujdes, mos harroni q� ndryshimi i autorizimeve p�r p�rdoruesin mund t� mos ndikoj� autorizimet p�r grupin, etj. Ju do paralajm�roheni n� k�to raste.";
$lang['Forum_auth_explain'] = "K�tu mund t� ndryshoni autorizimet p�r cdo forum. Ka dy m�nyra p�r ta b�r� k�t�, m�nyra e thjesht� dhe m�nyra e avancuar. M�nyra e avancuar ofron kontroll m� t� p�rpikt� p�r cdo veprim. Mos harroni q� ndryshimi i nivelit t� autorizimit n� nj� forum do ndikoj� p�rdorimin e tij nga p�rdorues�t e ndrysh�m.";

$lang['Simple_mode'] = "M�nyra e thjesht�";
$lang['Advanced_mode'] = "M�nyra e avancuar";
$lang['Moderator_status'] = "Status moderatori";

$lang['Allowed_Access'] = "Lejohet hyrja";
$lang['Disallowed_Access'] = "Ndalohet hyrja";
$lang['Is_Moderator'] = "Esht� moderator";
$lang['Not_Moderator'] = "Nuk �sht� moderator";

$lang['Conflict_warning'] = "Paralajm�rim: Konflikt n� autorizim";
$lang['Conflict_access_userauth'] = "Ky p�rdorues ka akoma te drejta p�r hyrje n� k�t� forum n�p�rmjet an�tar�sis� n� grup. You duhet t� ndryshoni autorizimet e grupit, ose ta hiqni k�t� p�rdorues nga ky grup n� m�nyr� q� ta ndaloni. Grupet q� i japin t� drejta (dhe forumet q� ndikohen) jan� renditur m� posht�.";
$lang['Conflict_mod_userauth'] = "Ky p�rdorues ka akoma t� drejta Moderatori p�r k�t� forum n�p�rmjet an�tar�sis� n� grup. You duhet t� ndryshoni autorizimet e grupit, ose ta hiqni k�t� p�rdorues nga ky grup n� m�nyr� q� ta ndaloni. Grupet q� i japin t� drejta (dhe forumet q� ndikohen) jan� renditur m� posht�.";

$lang['Conflict_access_groupauth'] = "Ky p�rdorues/� kan� akoma te drejta p�r hyrje n� k�t� forum n�p�rmjet autorizimeve individuale. You duhet t� ndryshoni autorizimet individuale  q� ta/i ndaloni. P�rdorues�t me t� drejta (dhe forumet q� ndikohen) jan� renditur m� posht�.";
$lang['Conflict_mod_groupauth'] = "Ky p�rdorues ka akoma t� drejta Moderatori p�r k�t� forum n�p�rmjet autorizimeve personale. You duhet t� ndryshoni autorizimet individuale q� ta ndaloni. P�rdorues�t me t� drejta (dhe forumet q� ndikohen) jan� renditur m� posht�.";

$lang['Public'] = "Publik";
$lang['Private'] = "Privat";
$lang['Registered'] = "I regjistruar";
$lang['Administrators'] = "Administrator�t";
$lang['Hidden'] = "I fshehur";

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = "ALL";
$lang['Forum_REG'] = "REG";
$lang['Forum_PRIVATE'] = "PRIVATE";
$lang['Forum_MOD'] = "MOD";
$lang['Forum_ADMIN'] = "ADMIN";

$lang['View'] = "Shiko";
$lang['Read'] = "Lexo";
$lang['Post'] = "Shkruaj";
$lang['Reply'] = "P�rgjigju";
$lang['Edit'] = "Modifiko";
$lang['Delete'] = "Fshi";
$lang['Sticky'] = "Ngjit�s";
$lang['Announce'] = "Lajm�ro"; 
$lang['Vote'] = "Voto";
$lang['Pollcreate'] = "Krijo votim";

$lang['Permissions'] = "Autorizimet";
$lang['Simple_Permission'] = "Autorizim i thjesht�suar";

$lang['User_Level'] = "Nivel p�rdoruesi"; 
$lang['Auth_User'] = "P�rdorues";
$lang['Auth_Admin'] = "Administrator";
$lang['Group_memberships'] = "An�tar�sia e grupit";
$lang['Usergroup_members'] = "Ky grup ka keta an�tar�";

$lang['Forum_auth_updated'] = "Autorizimet e forumit u ri-freskuan";
$lang['User_auth_updated'] = "Autorizimet e p�rdoruesit u ri-freskuan";
$lang['Group_auth_updated'] = "Autorizimet e grupit u ri-freskuan";

$lang['Auth_updated'] = "Autorizimet u ri-freskuan";
$lang['Click_return_userauth'] = "Kliko %sketu%s p�r ty kthyer tek Autorizimet e P�rdoruesve";
$lang['Click_return_groupauth'] = "Kliko %sketu%s p�r ty kthyer tek Autorizimet e Grupeve";
$lang['Click_return_forumauth'] = "Kliko %sketu%s p�r ty kthyer tek Autorizimet e Forumeve";


//
// Banning
//
$lang['Ban_control'] = "Menaxhimi i p�rjashtimeve";
$lang['Ban_explain'] = "K�tu b�het p�rjashtimi i p�rdoruesve/an�tar�ve. Kjo arrihet duke p�rjashtuar nj� an�tar specifik, nj� IP/hostname ose grup IP/hostname, ose t� dyja bashk�. K�to metoda pengojn� nj� p�rdorues madje dhe t� shikojn� faqen kryesore t� forumit. Nqs doni t� pengoni dik� t� p�rjashtuar m� par� dhe q� tenton t� regjistrohet me nj� em�r t� ri, mund ta ndaloni at� duke p�rjashtuar adres�n e email. Kini parasysh, p�rjashtimi i email-it nuk pengon dik� q� t� shkruaj� apo shikoj� forumin. P�r k�t�  p�rdorni nj� ose t� dyja metodat e m�sip�rme.";
$lang['Ban_explain_warn'] = "Kujdes, p�rjashtimi i nj� serie IP-sh p�rjashton cdo IP midis fillimit dhe fundit t� seris�. Nqs ju duhet t� p�rjashtoni nj� seri, mundohuni ta minimizoni serin�. ";

$lang['Select_username'] = "Zgjidh identifikimin";
$lang['Select_ip'] = "Zgjidh IP";
$lang['Select_email'] = "Zgjidh adres�n e e-mail";

$lang['Ban_username'] = "P�rjashto nj� ose m� shum� an�tar�";
$lang['Ban_username_explain'] = "P�rjashtimi i nj� ose m� shum� an�tar�ve nj�koh�sisht �sht� i mundur me kombinimin e duhur t� butonave";

$lang['Ban_IP'] = "P�rjashto nj� ose m� shum� IP ose hostname";
$lang['IP_hostname'] = "IP ose hostnames";
$lang['Ban_IP_explain'] = "Per t� specifikuar m� shum� se nj� IP ose hostname, ndajini me presje. To specify a range of IP addresses separate the start and end with a hyphen (-), to specify a wildcard use *";

$lang['Ban_email'] = "P�jashto nj� ose m� shum� adresa e-mail";
$lang['Ban_email_explain'] = "Per t� specifikuar m� shum� se nj� adres� e-maili, ndajini me presje. P�r t� specifikuar nj� -wildcard username- p�rdor *, p�r shembull *@hotmail.com";

$lang['Unban_username'] = "Riprano nj� ose m� shum� an�tar�";
$lang['Unban_username_explain'] = "Ripranimi i nj� ose m� shum� an�tar�ve nj�koh�sisht �sht� i mundur me kombinimin e duhur t� butonave";

$lang['Unban_IP'] = "Riprano nj� ose m� shum� IP";
$lang['Unban_IP_explain'] = "Ripranimi i nj� ose m� shum� IP nj�koh�sisht �sht� i mundur me kombinimin e duhur t� butonave";

$lang['Unban_email'] = "Riprano nj� ose m� shum� adresa e-maili";
$lang['Unban_email_explain'] = "Ripranimi i nj� ose m� shum� adresave nj�koh�sisht �sht� i mundur me kombinimin e duhur t� butonave";

$lang['No_banned_users'] = "Asnj� an�tar i p�rjashtuar";
$lang['No_banned_ip'] = "Asnj� IP e p�rjashtuar";
$lang['No_banned_email'] = "Asnj� adres� e-maili e p�rjashtuar";

$lang['Ban_update_sucessful'] = "Lista e p�rjashtimeve u refreskua n� m�nyr� t� suksesshme";
$lang['Click_return_banadmin'] = "Kliko %sk�tu%s p�r tu kthyer tek menaxhimi i p�rjashtimeve";


//
// Configuration
//
$lang['General_Config'] = "Konfigurim i p�rgjithsh�m";
$lang['Config_explain'] = "Formulari i m�posht�m ju jep mund�sine e konfigurimit t� opsioneve t� p�rgjithshme. P�r administrimin dhe konfigurimin e an�tar�ve dhe forumeve, p�rdorni tabelat n� krahun e majt�.";

$lang['Click_return_config'] = "Kliko %sk�tu%s p�r tu kthyer tek konfigurimi i p�rgjithsh�m";

$lang['General_settings'] = "Vetit� e p�rgjithshme t� forumit(site)";
$lang['Server_name'] = "Domain Name";
$lang['Server_name_explain'] = "The domain name this board runs from";
$lang['Script_path'] = "Script path";
$lang['Script_path_explain'] = "The path where phpBB2 is located relative to the domain name";
$lang['Server_port'] = "Server Port";
$lang['Server_port_explain'] = "The port your server is running on, usually 80, only change if different";
$lang['Site_name'] = "Emri i websitit";
$lang['Site_desc'] = "P�rshkrimi i websitit";
$lang['Board_disable'] = "Disaktivizoje websitin";
$lang['Board_disable_explain'] = "KUJDES!!!! Ky veprim do e b�j� forumin jofunksional. Nqs b�ni logout pas disaktivizimit,nuk do keni mund�si q� t� b�ni login!";
$lang['Acct_activation'] = "Mund�so aktivizimin e llogaris� nga";
$lang['Acc_None'] = "Askush"; // K�to jan� 3 llojet e aktivizimit
$lang['Acc_User'] = "An�tari";
$lang['Acc_Admin'] = "Administratori";

$lang['Abilities_settings'] = "Veti Elementare t� An�tar�ve dhe Forumeve";
$lang['Max_poll_options'] = "Nr. maksimal i mund�sive p�r nj� votim";
$lang['Flood_Interval'] = "Flood Interval";
$lang['Flood_Interval_explain'] = "Numri i sekondave q� nj� an�tar duhet t� pres� midis postimeve"; 
$lang['Board_email_form'] = "P�rdorimi p�r e-mail";
$lang['Board_email_form_explain'] = "An�tar�t mund t� d�rgojn� e-mail n�p�rmjet k�tij serveri";
$lang['Topics_per_page'] = "Diskutime p�r faqe";
$lang['Posts_per_page'] = "Poste p�r faqe";
$lang['Hot_threshold'] = "Posts for Popular Threshold";
$lang['Default_style'] = "Paraqitja e paracaktuar";
$lang['Override_style'] = "Z�vend�so preferenc�n e p�rdoruesve?";
$lang['Override_style_explain'] = "Z�vend�son paraqitjen e preferuar t� p�rdoruesve me paraqitjen e paracaktuar";
$lang['Default_language'] = "Gjuha e paracaktuar";
$lang['Date_format'] = "Formatimi i Dat�s";
$lang['System_timezone'] = "Brezi orar i sistemit";
$lang['Enable_gzip'] = "Mund�so kompresimin me GZip";
$lang['Enable_prune'] = "Mund�so shkurtimin/shartimin e forumeve";
$lang['Allow_HTML'] = "Lejo HTML";
$lang['Allow_BBCode'] = "Lejo BBCode";
$lang['Allowed_tags'] = "Sh�njat HTML t� lejuara";
$lang['Allowed_tags_explain'] = "Ndaji sh�njat me presje";
$lang['Allow_smilies'] = "Lejo figurinat";
$lang['Smilies_path'] = "Shtegu i direktoris� s� figurinave";
$lang['Smilies_path_explain'] = "Path under your phpBB root dir, e.g. images/smilies";
$lang['Allow_sig'] = "Lejo firmat";
$lang['Max_sig_length'] = "Madh�sia maksimale e firmave";
$lang['Max_sig_length_explain'] = "Nr. maksimal i shkronjave t� lejuara n� nj� firm�";
$lang['Allow_name_change'] = "Lejo nd�rrimin e username";

$lang['Avatar_settings'] = "Vetit� e Ikonave Personale";
$lang['Allow_local'] = "Mund�so galerin� e ikonave personale";
$lang['Allow_remote'] = "Mund�so ikona personale nga servera t� tjer�";
$lang['Allow_remote_explain'] = "Ikona personale q� ruhen n� nj� websit tjet�r";
$lang['Allow_upload'] = "Mund�so ngarkimin e ikonave personale";
$lang['Max_filesize'] = "Madh�sia maksimale e ikon�s personale";
$lang['Max_filesize_explain'] = "Vet�m p�r ikonat e ngarkuara ne k�t� server";
$lang['Max_avatar_size'] = "Dimensionet maksimale t� ikonave personale";
$lang['Max_avatar_size_explain'] = "(Gjat�si x Gjer�si n� piksel)";
$lang['Avatar_storage_path'] = "Shtegu i magazinimit t� ikonave personale";
$lang['Avatar_storage_path_explain'] = "Path under your phpBB root dir, e.g. images/avatars";
$lang['Avatar_gallery_path'] = "Shtegu i galeris� s� ikonave personale";
$lang['Avatar_gallery_path_explain'] = "Path under your phpBB root dir for pre-loaded images, e.g. images/avatars/gallery";

$lang['COPPA_settings'] = "COPPA Settings";
$lang['COPPA_fax'] = "COPPA Fax Number";
$lang['COPPA_mail'] = "COPPA Mailing Address";
$lang['COPPA_mail_explain'] = "This is the mailing address where parents will send COPPA registration forms";

$lang['Email_settings'] = "Vetit� e E-mail";
$lang['Admin_email'] = "Adresa e email t� administratorit";
$lang['Email_sig'] = "Firma e email-it";
$lang['Email_sig_explain'] = "Kjo firm� do u bashkangjitet n� fund t� gjith� mesazheve t� derguara nga ky server";
$lang['Use_SMTP'] = "P�rdor server SMTP per d�rgimin e email-ave";
$lang['Use_SMTP_explain'] = "P�rcaktoje k�t� veti nqs doni/jeni i detyruar t� mos p�rdorni programin mail te serverit";
$lang['SMTP_server'] = "Adresa e serverit SMTP";
$lang['SMTP_username'] = "SMTP Username";
$lang['SMTP_username_explain'] = "Only enter a username if your smtp server requires it";
$lang['SMTP_password'] = "SMTP Password";
$lang['SMTP_password_explain'] = "Only enter a password if your smtp server requires it";

$lang['Disable_privmsg'] = "Private Messaging";
$lang['Inbox_limits'] = "Maksimumi i posteve n� Inbox";
$lang['Sentbox_limits'] = "Maksimumi i posteve n� Sentbox";
$lang['Savebox_limits'] = "Maksimumi i posteve n� Savebox";

$lang['Cookie_settings'] = "Vetit� e Cookie-s "; 
$lang['Cookie_settings_explain'] = "K�to t� dh�na kontrollojn� se si cooki i d�rgohet browser-it. N� shumic�n e rasteve, vlerat e paracaktuara jane t� mjaftueshme. Nqs keni nevoj� ti ndryshoni, kini kujdes se t� dh�na jokorrekte krijojne probleme me indentifikimin e an�tar�ve.";
$lang['Cookie_name'] = "Emri i Cookie";
$lang['Cookie_domain'] = "Domain i Cookie";
$lang['Cookie_path'] = "Shtegu i Cookie";
$lang['Session_length'] = "Zgjatja e sesionit [ n� sekonda ]";
$lang['Cookie_secure'] = "Cookie e sigurt� [ https ]";
$lang['Session_length'] = "Session length [ seconds ]";


//
// Forum Management
//
$lang['Forum_admin'] = "Administrim Forumi";
$lang['Forum_admin_explain'] = "Nga ky panel b�het krijimi, fshirja, modifikimi, ri-renditja, dhe ri-sinkronizimi i kategorive dhe forumeve";
$lang['Edit_forum'] = "Modifiko forumin";
$lang['Create_forum'] = "Krijo forum";
$lang['Create_category'] = "Krijo kategori";
$lang['Remove'] = "Hiq";
$lang['Action'] = "Veprimi";
$lang['Update_order'] = "Rifresko renditjen";
$lang['Config_updated'] = "Rifreskimi i konfigurimit t� forumit u b� n� m�nyr� t� suksesshme";
$lang['Edit'] = "Modifiko";
$lang['Delete'] = "Fshi";
$lang['Move_up'] = "L�vize sip�r";
$lang['Move_down'] = "L�vize posht�";
$lang['Resync'] = "Ri-sinkronizo";
$lang['No_mode'] = "No mode was set";
$lang['Forum_edit_delete_explain'] = "Formulari i m�posht�m ju jep mund�sine e konfigurimit t� opsioneve t� p�rgjithshme. P�r administrimin dhe konfigurimin e an�tar�ve dhe forumeve, p�rdorni tabelat n� krahun e majt�.";

$lang['Move_contents'] = "Zhvendos gjith� p�rmbajtjen";
$lang['Forum_delete'] = "Fshije k�t� forum";
$lang['Forum_delete_explain'] = "Formulari i m�posht�m ju jep mund�sine e fshirjes s� nj� forumi (apo kategorie) dhe ruajtjen e gjith� mesazheve (forumeve) q� p�rmban.";

$lang['Forum_settings'] = "Vetit� e p�rgjithshme t� forumit";
$lang['Forum_name'] = "Emri i forumit";
$lang['Forum_desc'] = "P�rshkrimi";
$lang['Forum_status'] = "Statusi i forumit";
$lang['Forum_pruning'] = "Auto-shkurtim";

$lang['prune_freq'] = 'Kontrollo vjet�rsin� e diskutimit cdo';
$lang['prune_days'] = "Hiq diskutimet ku nuk postohet prej";
$lang['Set_prune_data'] = "Ju zgjodh�t auto-shkurtim p�r k�t� forum por nuk specifikuat nj� frekuenc� ose nr. e dit�ve p�r shkurtim. Ju lutem shkoni mbrapsht dhe specifikoni k�to veti.";

$lang['Move_and_Delete'] = "Zhvendos dhe Fshi";

$lang['Delete_all_posts'] = "Fshi gjith� postet";
$lang['Nowhere_to_move'] = "S'ke ku e con";

$lang['Edit_Category'] = "Modifiko kategorin�";
$lang['Edit_Category_explain'] = "P�rdor k�t� formular p�r nd�rrimin e emrit t� kategoris�";

$lang['Forums_updated'] = "Informacioni rreth forumit dhe kategoris� u freskua n� menyr� t� suksesshme";

$lang['Must_delete_forums'] = "Fshi gjith� forumet n� k�t� kategori para se t� fshish kategorin� vet�";

$lang['Click_return_forumadmin'] = "Kliko %sk�tu%s p�r tu kthyer tek administrimi i forumeve";


//
// Smiley Management
//
$lang['smiley_title'] = "Veg�l p�r menaxhimin e figurinave";
$lang['smile_desc'] = "Nga ky panel ju mund t� shtoni, hiqni dhe editoni figurinat q� mund t� p�rdoren nga p�rdoruesit.";

$lang['smiley_config'] = "Konfigurimi i figurinave";
$lang['smiley_code'] = "Kodi i figurinave";
$lang['smiley_url'] = "Adresa e figurin�s";
$lang['smiley_emot'] = "Emocioni i figurin�s";
$lang['smile_add'] = "Shto nj� figurin�";
$lang['Smile'] = "Figurina";
$lang['Emotion'] = "Emocioni";

$lang['Select_pak'] = "Zgjidh skedarin paket� (.pak)";
$lang['replace_existing'] = "Z�vend�so figurin�n egzistuese";
$lang['keep_existing'] = "Mbaje figurin�n egzistuese";
$lang['smiley_import_inst'] = "You duhet t� dekompresoni skedarin me figurina dhe vendosni figurinat n� direktorin� e duhur. Pastaj zgjidhni informacionin e duhur n� k�t� formular q� t� importoni skedarin e figurinave (Smiley Pack)";
$lang['smiley_import'] = "Importo skedarin e figurinave (Smiley Pack)";
$lang['choose_smile_pak'] = "Zgjidh nj� nga skedar�t e figurinave ( .pak)";
$lang['import'] = "Importo figurina";
$lang['smile_conflicts'] = "Cfar� duhet b�r� n� rast konflikti";
$lang['del_existing_smileys'] = "Fshi figurinat ekzistuese p�rpara se t� importosh";
$lang['import_smile_pack'] = "Importo skedarin e figurinave";
$lang['export_smile_pack'] = "Krijo nj� skedar figurinash";
$lang['export_smiles'] = "P�r t� krijuar nj� skedar figurinash prej figurinave ekzistuese, kliko %sk�tu%s p�r t� shkarkuar skedarin smiles.pak Ndryshojini emrin skedarin nqs doni, po mos i ndryshoni -file extension-. Pastaj krijoni nj� skedar .zip q� p�rmban t� gjitha imazhet e figurinave plus skedarin .pak.";

$lang['smiley_add_success'] = "Figurina u shtua n� m�nyr� t� suksesshme.";
$lang['smiley_edit_success'] = "Figurina u ri-freskua n� m�nyr� t� suksesshme.";
$lang['smiley_import_success'] = "Skedari i figurinave (Smiley Pack) u importua n� m�nyr� t� suksesshme.";
$lang['smiley_del_success'] = "Figurina u hoq n� m�nyr� t� suksesshme.";
$lang['Click_return_smileadmin'] = "Kliko %sk�tu%s p�r ty kthyer tek Administrimi i Figurinave";


//
// User Management
//
$lang['User_admin'] = "Administrimi i An�tar�ve";
$lang['User_admin_explain'] = "K�tu mund t� ndryshoni informacionin mbi an�tar�t dhe disa opcione specifike. B�ni modifikimin e autorizimeve me an� t� panelit t� p�rshtatsh�m n� krahun e majt� t� panelit.";

$lang['Look_up_user'] = "Analizo an�tarin";

$lang['Admin_user_fail'] = "Nuk u arrit t� ri-freskohej profili i an�tarit.";
$lang['Admin_user_updated'] = "Profili i k�tij an�tari u ri-freskua n� m�nyr� t� suksesshme.";
$lang['Click_return_useradmin'] = "Kliko %sk�tu%s p�r tu kthyer tek Administrimi i An�tar�ve";

$lang['User_delete'] = "Fshije k�t� p�rdorues";
$lang['User_delete_explain'] = "Kliko k�tu p�r ta fshir� k�t� an�tar, ky veprim �sht� i pakthyesh�m.";
$lang['User_deleted'] = "An�tari u fshi n� m�nyr� t� suksesshme.";

$lang['User_status'] = "An�tari �sht� aktiv";
$lang['User_allowpm'] = "Mund t� d�rgoj� Mesazhe Private";
$lang['User_allowavatar'] = "Mund t� shfaq� ikon�n personale";

$lang['Admin_avatar_explain'] = "K�tu mund t� shikoni dhe fshini ikon�n aktuale personale t� an�tarit.";

$lang['User_special'] = "Fusha speciale vet�m p�r administrator�t.";
$lang['User_special_explain'] = "K�to fusha nuk mund t� modifikohen nga an�tar�t. Ju mund t� vendosni statusin dhe veti t� tjera q� nuk i jepen an�tar�ve.";


//
// Group Management
//
$lang['Group_administration'] = "Administrim i Grupeve";
$lang['Group_admin_explain'] = "Tek ky panel ju mund t� administroni t� gjith� grupet e p�rdoruesve. Fshi, krijo dhe modifiko grupet ekzistuese. Zgjidh moderator�t, hap/mbyll dhe vendos emrin dhe p�rshkrimin e grupit.";
$lang['Error_updating_groups'] = "Pati nj� problem gjat� ri-freskimit t� grupeve";
$lang['Updated_group'] = "Grupi u ri-freskua me sukses";
$lang['Added_new_group'] = "Grupi u krijua me sukses";
$lang['Deleted_group'] = "Grupi u fshi me sukses";
$lang['New_group'] = "Krijo grup t� ri";
$lang['Edit_group'] = "Modifiko grupin";
$lang['group_name'] = "Emri i grupit";
$lang['group_description'] = "P�rshkrimi i grupit";
$lang['group_moderator'] = "Moderatori i grupit";
$lang['group_status'] = "Statusi i grupit";
$lang['group_open'] = "Grup i hapur";
$lang['group_closed'] = "Grup i mbyllur";
$lang['group_hidden'] = "Grup i fshehte";
$lang['group_delete'] = "Fshi grupin";
$lang['group_delete_check'] = "Fshi k�t� grup";
$lang['submit_group_changes'] = "Paraqit ndryshimet";
$lang['reset_group_changes'] = "Pastro ndryshimet";
$lang['No_group_name'] = "Specifiko emrin e k�tij grupi";
$lang['No_group_moderator'] = "Specifiko moderatorin e k�tij grupi";
$lang['No_group_mode'] = "Specifiko nj� m�nyr� p�r k�t� grup, hapur ose mbyllur";
$lang['delete_group_moderator'] = "Fshi moderatorin e vjet�r t� grupit?";
$lang['delete_moderator_explain'] = "Nqs jeni duke ndryshuar moderatorin e grupit, v�r nj� kryq tek kjo kuti p�r t� hequr moderatorin e vjet�r nga grupi. Ndryshe, l�re bosh dhe moderatori i vjet�r do b�het nj� an�tar i thjesht� i grupit.";
$lang['Click_return_groupsadmin'] = "Kliko %sk�tu%s p�r ty kthyer tek Administrimi i Grupeve";
$lang['Select_group'] = "Zgjidh nj� grup";
$lang['Look_up_group'] = "Analizo nj� grup";


//
// Prune Administration
//
$lang['Forum_Prune'] = "Shkurto forumin";
$lang['Forum_Prune_explain'] = "Ky veprim do fshij� cdo tem� ku nuk �sht� postuar br�nda afatit q� ju keni p�rcaktuar. Nqs nuk p�rcaktoni nj� num�r, at�her� gjith� temat do fshihen. Megjithat�, temat ku ka votime t� hapura dhe lajm�rimet duhen fshir� mekanikisht.";
$lang['Do_Prune'] = "B�je shkurtimin";
$lang['All_Forums'] = "Gjith� forumet";
$lang['Prune_topics_not_posted'] = "Shkurto temat pa pergjigje br�nda";
$lang['Topics_pruned'] = "Temat e shkurtuara";
$lang['Posts_pruned'] = "Mesazhet e shkurtuara";
$lang['Prune_success'] = "Shkurtimi i forumeve u b� me sukses";


//
// Word censor
//
$lang['Words_title'] = "Censurimi i fjal�ve";
$lang['Words_explain'] = "Nga ky panel ju mund t� shtoni, modifikoni, dhe hiqni fjal� q� do censurohen automatikisht. Gjithashtu, emrat e an�tar�ve nuk do mund t� p�rmbajn� fjal� t� tilla. Wildcards (*) are accepted in the word field, eg. *test* will match detestable, test* would match testing, *test would match detest.";
$lang['Word'] = "Fjal�";
$lang['Edit_word_censor'] = "Modifiko censur�n";
$lang['Replacement'] = "Z�vend�simi";
$lang['Add_new_word'] = "Shto nj� fjal�";
$lang['Update_word'] = "Ri-fresko censur�n";

$lang['Must_enter_word'] = "You duhet t� specifikoni nj� fjal� dhe z�vend�simin e saj";
$lang['No_word_selected'] = "Asnj� fjal� nuk �sht� zgjedhur p�r modifikim";

$lang['Word_updated'] = "Censura e zgjedhur u ri-freskua me sukses";
$lang['Word_added'] = "Censura u shtua me sukses";
$lang['Word_removed'] = "Censura e zgjedhur u hoq me sukses";

$lang['Click_return_wordadmin'] = "Kliko %sk�tu%s p�r tu kthyer tek Administrimi i Censur�s";


//
// Mass Email
//
$lang['Mass_email_explain'] = "Nga ky panel ju mund t� d�rgoni nj� e-mail tek t� gjith� an�tar�t e forumit, ose nje grupi specifik. P�r t� kryer k�t�, nj� e-mail do i d�rgohet adres�s administrative t� specifikuar, dhe nj� kopje karboni do u d�rgohet gjith� marr�sve. Kini parasysh se nqs i d�rgoni e-mail nje grupi t� madh personash, ky proces do koh�, k�shtu q� prisni deri sa t� njoftoheni se procesi mbaroi.";
$lang['Compose'] = "Harto"; 

$lang['Recipients'] = "Marr�sit"; 
$lang['All_users'] = "T� gjith� an�tar�t";

$lang['Email_successfull'] = "Mesazhi u d�rgua";
$lang['Click_return_massemail'] = "Kliko %sk�tu%s p�r tu kthyer tek paneli i E-mail n� Mas�";


//
// Ranks admin
//
$lang['Ranks_title'] = "Administrimi i Gradave";
$lang['Ranks_explain'] = "Ky formular mund�son shtimin, modifikimin dhe fshirjen e gradave. Gjithashtu, ju mund t� krijoni grada t� personalizuara t� cilat i aplikohen p�rdoruesve n�p�rmjet panelit t� administrimit t� p�rdoruesve.";

$lang['Add_new_rank'] = "Shto nj� grad�";

$lang['Rank_title'] = "Titulli i grad�s";
$lang['Rank_special'] = "Cakto si grad� speciale";
$lang['Rank_minimum'] = "Minimumi i mesazheve";
$lang['Rank_maximum'] = "Maksimumi i mesazheve";
$lang['Rank_image'] = "Ikona e grad�s";
$lang['Rank_image_explain'] = "P�rdore k�t� p�r t� specifikuar ikon�n q� shoq�ron grad�n";

$lang['Must_select_rank'] = "Zgjidh nj� grad�";
$lang['No_assigned_rank'] = "Nuk �sht� dh�n� ndonj� grad� speciale";

$lang['Rank_updated'] = "Grada u ri-freskua me sukses";
$lang['Rank_added'] = "Grada u shtua me sukses";
$lang['Rank_removed'] = "Grada u fshi me sukses";
$lang['No_update_ranks'] = "The rank was successfully deleted, however, user accounts using this rank were not updated.  You will need to manually reset the rank on these accounts";

$lang['Click_return_rankadmin'] = "Kliko %sk�tu%s p�r tu kthyer tek Administrimi i Gradave";


//
// Disallow Username Admin
//
$lang['Disallow_control'] = "Kontrolli i emrave t� ndaluar";
$lang['Disallow_explain'] = "K�tu mund t� specifikoni emrat q� nuk mund t� p�rdoren. Disallowed usernames are allowed to contain a wildcard character of *. Kini parasysh se nuk mund t� specifikoni nj� em�r q� �sht� regjistruar tashm�. Fshini at� an�tar dhe pastaj ndalojeni at� fjal�.";

$lang['Delete_disallow'] = "Fshi";
$lang['Delete_disallow_title'] = "Hiq nj� nga emrat e ndaluar";
$lang['Delete_disallow_explain'] = "Heqja e nj� emri nga lista e ndaluar b�het duke e zgjedhur at� tek kjo list� dhe klikuar paraqit.";

$lang['Add_disallow'] = "Shto";
$lang['Add_disallow_title'] = "Shto nj� em�r t� ndaluar";
$lang['Add_disallow_explain'] = "Ju mund t� ndaloni nj� em�r duke p�rdorur * n� vend t� cdo karakteri n� at� pozicion.";

$lang['No_disallowed'] = "Asnj� em�r i ndaluar";

$lang['Disallowed_deleted'] = "Emri i ndaluar u fshi me sukses";
$lang['Disallow_successful'] = "Emri i ndaluar u shtua me sukses";
$lang['Disallowed_already'] = "Emri q� shtuat nuk mund t� ndalohet. Ky em�r ose ekziston n� list�n e emrave t� ndaluar, ose ekziston n� list�n e censur�s ose �sht� n� p�rdorim nga nj� an�tar.";

$lang['Click_return_disallowadmin'] = "Kliko %sk�tu%s p�r tu kthyer tek Administrimi i emrave t� ndaluar";


//
// Styles Admin
//
$lang['Styles_admin'] = "Administrimi i stileve";
$lang['Styles_explain'] = "Me an� t� k�tij paneli mund t� shtoni, hiqni dhe menaxhoni (shabllonet dhe motivet) n� dispozicion t� an�tar�ve.";
$lang['Styles_addnew_explain'] = "Lista e m�poshtme p�rmban t� gjith� motivet q� jan� t� mundsh�m p�r shabllonet q� keni. Artikujt n� k�t� list� nuk jan� instaluar akoma n� regjistrin e phpBB. Kliko butonin instalo p�r t� instaluar nj� nga k�to artikuj n� databaz�.";

$lang['Select_template'] = "Zgjidh nj� shabllon";

$lang['Style'] = "Stili";
$lang['Template'] = "Shabllon";
$lang['Install'] = "Instalo";
$lang['Download'] = "Shkarko";

$lang['Edit_theme'] = "Modifiko motivin";
$lang['Edit_theme_explain'] = "N� formularin m� posht� modifiko vetit� e motivit q� keni zgjedhur.";

$lang['Create_theme'] = "Krijo motiv";
$lang['Create_theme_explain'] = "P�rdor formularin e m�posht�m p�r t� krijuar nj� motiv p�r shabllonin e zgjedhur. Kur zgjidhni ngjyrat (p�r t� cilat duhen p�rdorur numrat me baz� 16 --hexadecimal--) mos vendosni shenj�n #. psh. #CC00BB �sht� gabim.";

$lang['Export_themes'] = "Eksporto motivet";
$lang['Export_explain'] = "Ky panel mund�son eksportimin e t� dh�nave t� motivit p�r shabllonin e zgjedhur. Zgjidh shabllonin nga lista e m�poshtme dhe phpBB do krijoj� automatikisht skedarin p�r konfigurimin e motivit dhe do provoj� ta ruaj� n� direktorin� ku shablloni i zgjedhur rri. Nqs nuk mund ta ruani skedarin atje, do keni mund�sin� p�r ta shkarkuar n� kompjuterin tuaj. N� m�nyr� q� skedari t� vendoset n� direktorin� e shabllonit, webserveri duhet t� ket� autorizim p�r t� shkruar n� at� direktori. P�r m� shum� info, shiko manualin e p�rdorimit.";

$lang['Theme_installed'] = "Motivi i zgjedhur u instalua me sukses";
$lang['Style_removed'] = "Stili i zgjedhur u hoq nga regjistri. P�r ta hequr k�t� stil p�rfundimisht nga sistemi juaj, fshijeni k�t� stil nga direktoria e shablloneve.";
$lang['Theme_info_saved'] = "Informacioni i motivit p�r shabllonin e zgjedhur u ruajt. Rivendosni autorizimet n� nivelin lexim-vet�m (read-only) p�r theme_info.cfg ";
$lang['Theme_updated'] = "Motivi i zgjedhur u ri-freskua. Tashti duhet t� eksportoni vetit� e reja t� motivit";
$lang['Theme_created'] = "Motivi u krijua. Tashti duhet t� eskportoni motivin e ri tek skedari i konfigurimit p�r ruajtje.";

$lang['Confirm_delete_style'] = "Jeni i sigurt� p�r fshirjen e k�tij stili";

$lang['Download_theme_cfg'] = "Eksportuesi nuk mundi t� shkruaj� skedarin e informacionit t� motivit. Kliko butonin e meposht�m p�r ta shkarkuar k�t� skedar. Pasi ta keni shkarkuar, transferojeni tek direktoria q� p�rmban skedar�t e shablloneve. You mund ti arkivoni skedar�t dhe ti shp�rndani p�r p�rdorim diku tjet�r.";
$lang['No_themes'] = "Shablloni q� zgjodh�t nuk ka asnj� motiv t� bashkangjitur. P�r t� krijuar nj� motiv t� ri kliko butonin Krijo n� an�n e majt�.";
$lang['No_template_dir'] = "Direktoria e shablloneve nuk hapet. Webserveri nuk mund ta lexoj� ose direktoria nuk ekziston.";
$lang['Cannot_remove_style'] = "Stili i zgjdhur nuk mund t� fshihet sepse �sht� stili i paracaktuar i forumi. Ndryshoni stilin e paracaktuar dh pastaj provoni nga e para";
$lang['Style_exists'] = "Emri i zgjedhur p�r k�t� stil ekziston. Zgjidhni nj� em�r tjet�r";

$lang['Click_return_styleadmin'] = "Kliko %sk�tu%s p�r tu kthyer tek Administratori i Stileve";

$lang['Theme_settings'] = "Vetit� e motivit";
$lang['Theme_element'] = "Elementi i motivit";
$lang['Simple_name'] = "Em�r i thjesht�";
$lang['Value'] = "Vlera";
$lang['Save_Settings'] = "Regjistro vetit�";

$lang['Stylesheet'] = "CSS Stylesheet";
$lang['Background_image'] = "Background Image";
$lang['Background_color'] = "Background Colour";
$lang['Theme_name'] = "Emri i Motivit";
$lang['Link_color'] = "Link Colour";
$lang['Text_color'] = "Ngjyra e tekstit";
$lang['VLink_color'] = "Visited Link Colour";
$lang['ALink_color'] = "Active Link Colour";
$lang['HLink_color'] = "Hover Link Colour";
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
$lang['fontface1'] = "Font Face 1";
$lang['fontface2'] = "Font Face 2";
$lang['fontface3'] = "Font Face 3";
$lang['fontsize1'] = "Font Size 1";
$lang['fontsize2'] = "Font Size 2";
$lang['fontsize3'] = "Font Size 3";
$lang['fontcolor1'] = "Font Colour 1";
$lang['fontcolor2'] = "Font Colour 2";
$lang['fontcolor3'] = "Font Colour 3";
$lang['span_class1'] = "Span Class 1";
$lang['span_class2'] = "Span Class 2";
$lang['span_class3'] = "Span Class 3";
$lang['img_poll_size'] = "Polling Image Size [px]";
$lang['img_pm_size'] = "Private Message Status size [px]";


//
// Install Process
//
$lang['Welcome_install'] = "Mir�sevini tek instaluesi i phpBB v.2";
$lang['Initial_config'] = "Konfigurimi elementar";
$lang['DB_config'] = "Konfigurimi i regjistrit";
$lang['Admin_config'] = "Konfigurimi i administratorit";
$lang['continue_upgrade'] = "Once you have downloaded your config file to your local machine you may\"Continue Upgrade\" button below to move forward with the upgrade process. Please wait to upload the config file until the upgrade process is complete.";
$lang['upgrade_submit'] = "Continue Upgrade";

$lang['Installer_Error'] = "An error has occurred during installation";
$lang['Previous_Install'] = "A previous installation has been detected";
$lang['Install_db_error'] = "An error occurred trying to update the database";

$lang['Re_install'] = "Your previous installation is still active. <br /><br />If you would like to re-install phpBB 2 you should click the Yes button below. Please be aware that doing so will destroy all existing data, no backups will be made! The administrator username and password you have used to login in to the board will be re-created after the re-installation, no other settings will be retained. <br /><br />Think carefully before pressing Yes!";

$lang['Inst_Step_0'] = "Thank you for choosing phpBB 2. In order to complete this install please fill out the details requested below. Please note that the database you install into should already exist. If you are installing to a database that uses ODBC, e.g. MS Access you should first create a DSN for it before proceeding.";

$lang['Start_Install'] = "Start Install";
$lang['Finish_Install'] = "Finish Installation";

$lang['Default_lang'] = "Default board language";
$lang['DB_Host'] = "Database Server Hostname / DSN";
$lang['DB_Name'] = "Your Database Name";
$lang['DB_Username'] = "Database Username";
$lang['DB_Password'] = "Database Password";
$lang['Database'] = "Your Database";
$lang['Install_lang'] = "Choose Language for Installation";
$lang['dbms'] = "Database Type";
$lang['Table_Prefix'] = "Prefix for tables in database";
$lang['Admin_Username'] = "Administrator Username";
$lang['Admin_Password'] = "Administrator Password";
$lang['Admin_Password_confirm'] = "Administrator Password [ Confirm ]";

$lang['Inst_Step_2'] = "Your admin username has been created. At this point your basic installation is complete. You will now be taken to a screen which will allow you to administer your new installation. Please be sure to check the General Configuration details and make any required changes. Thank you for choosing phpBB 2.";

$lang['Unwriteable_config'] = "Your config file is un-writeable at present. A copy of the config file will be downloaded to your when you click the button below. You should upload this file to the same directory as phpBB 2. Once this is done you should log in using the administrator name and password you provided on the previous form and visit the admin control centre (a link will appear at the bottom of each screen once logged in) to check the general configuration. Thank you for choosing phpBB 2.";
$lang['Download_config'] = "Download Config";

$lang['ftp_choose'] = "Choose Download Method";
$lang['ftp_option'] = "<br />Since FTP extensions are enabled in this version of PHP you may also be given the option of first trying to automatically ftp the config file into place.";
$lang['ftp_instructs'] = "You have chosen to ftp the file to the account containing phpBB 2 automatically. Please enter the information below to facilitate this process. Note that the FTP path should be the exact path via ftp to your phpBB2 installation as if you were ftping to it using any normal client.";
$lang['ftp_info'] = "Enter Your FTP Information";
$lang['Attempt_ftp'] = "Attempt to ftp config file into place";
$lang['Send_file'] = "Just send the file to me and I'll ftp it manually";
$lang['ftp_path'] = "FTP path to phpBB 2";
$lang['ftp_username'] = "Your FTP Username";
$lang['ftp_password'] = "Your FTP Password";
$lang['Transfer_config'] = "Start Transfer";
$lang['NoFTP_config'] = "The attempt to ftp the config file into place failed. Please download the config file and ftp it into place manually.";

$lang['Install'] = "Install";
$lang['Upgrade'] = "Upgrade";


$lang['Install_Method'] = "Choose your installation method";

$lang['Install_No_Ext'] = "The php configuration on your server doesn't support the database type that you choose";

$lang['Install_No_PCRE'] = "phpBB2 Requires the Perl-Compatible Regular Expressions Module for php which your php configuration doesn't appear to support!";

//
// That's all Folks!
// -------------------------------------------------

?>