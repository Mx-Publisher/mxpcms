<?php
// Romanian phpBB online community - Versiune actualizata pentru PhpBB 2.0.20
/***************************************************************************
 *                            lang_admin.php [rom�n�]
 *                              -------------------
 *     begin                : Sep 7 2002
 *     last update          : Jun 11, 2005
 *     language version     : 8.0
 *     copyright            : Romanian phpBB online community
 *     website              : http://www.phpbb.ro
 *     copyright 1          : (C) Daniel T�nasie
 *     email     1          : danielt@phpbb.ro
 *     copyright 2          : (C) Bogdan Toma
 *     email     2          : bogdan@phpbb.ro
 *
 *     $Id: lang_admin.php,v 1.1 2009/10/18 04:16:00 orynider Exp $
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


$lang['ENCODING'] = 'Windows-1250';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'st�nga';
$lang['RIGHT'] = 'dreapta';
$lang['DATE_FORMAT'] =  'd/M/Y'; // This should be changed to the default date format for your language, php date() format

$lang['General'] = 'Administrare general�';
$lang['Users'] = 'Administrare utilizatori';
$lang['Groups'] = 'Administrare grupuri';
$lang['Forums'] = 'Administrare forumuri';
$lang['Styles'] = 'Administrare stiluri';

$lang['Configuration'] = 'Configurare general�';
$lang['Permissions'] = 'Permisiuni';
$lang['Manage'] = 'Management';
$lang['Disallow'] = 'Dezactivare nume';
$lang['Prune'] = 'Cur��ire';
$lang['Mass_Email'] = 'Expediere mesaje �n bloc';
$lang['Ranks'] = 'Ranguri';
$lang['Smilies'] = 'Z�mbete';
$lang['Ban_Management'] = 'Control restric�ii';
$lang['Word_Censor'] = 'Cuvinte cenzurate';
$lang['Export'] = 'Export�';
$lang['Create_new'] = 'Creeaz�';
$lang['Add_new'] = 'Adaug�';
$lang['Backup_DB'] = 'Salveaz� baza de date';
$lang['Restore_DB'] = 'Restaureaz� baza de date';


//
// Index
//
$lang['Admin'] = 'Administrare';
$lang['Not_admin'] = 'Nu sunte�i autorizat s� administra�i acest forum';
$lang['Welcome_phpBB'] = 'Bine a�i venit la centrul de control al forumului phpBB';
$lang['Admin_intro'] = 'V� mul�umim pentru c� a�i ales phpBB ca solu�ie pentru forumul dumneavoastr�. Acest ecran v� ofer� o privire de ansamblu a diverselor statistici ale forumului dumneavoastr�. Pute�i reveni la aceast� pagin� folosind leg�tura <i>Pagina de start a administratorului</i> din partea st�ng�. Pentru a reveni la pagina de start a forumului dumneavoastr�, ap�sa�i pe logo-ul phpBB-ului aflat, de asemenea, �n partea st�ng�. Celelalte leg�turi din partea st�ng� v� permit s� controla�i orice aspect al forumului, fiecare ecran va avea instruc�iuni care dau explica�ii despre cum se folosesc instrumentele.';
$lang['Main_index'] = 'Pagina de start a forumului';
$lang['Forum_stats'] = 'Statisticile forumului';
$lang['Admin_Index'] = 'Pagina de start a administratorului';
$lang['Preview_forum'] = 'Previzualizare forum';

$lang['Click_return_admin_index'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Pagina de start a administratorului';

$lang['Statistic'] = 'Statistica';
$lang['Value'] = 'Valoarea';
$lang['Number_posts'] = 'Num�rul mesajelor scrise';
$lang['Posts_per_day'] = 'Mesaje scrise pe zi';
$lang['Number_topics'] = 'Num�rul subiectelor';
$lang['Topics_per_day'] = 'Subiecte pe zi';
$lang['Number_users'] = 'Num�rul utilizatorilor';
$lang['Users_per_day'] = 'Utilizatori pe zi';
$lang['Board_started'] = 'Data lans�rii forumului';
$lang['Avatar_dir_size'] = 'Dimensiunea directorului cu imagini asociate (Avatar)';
$lang['Database_size'] = 'Dimensiunea bazei de date';
$lang['Gzip_compression'] ='Compresia Gzip';
$lang['Not_available'] = 'Nu este disponibil(�)';

$lang['ON'] = 'Activ�'; // This is for GZip compression
$lang['OFF'] = 'Inactiv�';


//
// DB Utils
//
$lang['Database_Utilities'] = 'Instrumentele bazei de date';

$lang['Restore'] = 'Restaurare';
$lang['Backup'] = 'Salvare (Backup)';
$lang['Restore_explain'] = 'Aceasta va efectua o restaurare complet� a tuturor tabelelor phpBB dintr-in fi�ier salvat. Dac� serverul dumneavoastr� suport�, pute�i publica un fi�ier text compresat cu gzip �i aceasta va fi decomprimat automat. <b>ATEN�IE:</b> Aceast� procedur� va rescrie orice informa�ie deja existent�. Procesul de restaurare poate dura un timp �ndelungat; v� rug�m nu p�r�si�i aceast� pagin� p�n� c�nd restaurarea nu se termin�.';
$lang['Backup_explain'] = 'Aici pute�i face copii de rezerv� ale tuturor datelor ce �in de phpBB. Dac� ave�i �i tabele adi�ionale �n aceea�i baz� de date cu phpBB-ul pe care dori�i s� le p�stra�i, v� rug�m s� introduce�i numele lor separate prin virgul� �n c�su�a <i>Tabele Suplimentare</i> de mai jos. Dac� serverul dumneavoastr� suport�, pute�i comprima fi�ierul cu gzip pentru a reduce dimensiunea sa �nainte de a efectua opera�iunea de desc�rcare.';

$lang['Backup_options'] = 'Op�iunile de salvare (backup)';
$lang['Start_backup'] = 'Porne�te opera�iunea de salvare (backup)';
$lang['Full_backup'] = 'Salvare (Backup) total�';
$lang['Structure_backup'] = 'Salveaz� (copie de siguran��) doar structura';
$lang['Data_backup'] = 'Salveaz� (copie de siguran��) doar datele';
$lang['Additional_tables'] = 'Tabele suplimentare';
$lang['Gzip_compress'] = 'Fi�ier comprimat cu Gzip';
$lang['Select_file'] = 'Selecta�i un fi�ier';
$lang['Start_Restore'] = 'Porne�te opera�iunea de restaurare';

$lang['Restore_success'] = 'Baza de date a fost restaurat� cu succes.<br /><br />Forumul dumneavoastr� ar trebui s� revin� la starea lui �nainte ca salvarea s� se fi realizat.';
$lang['Backup_download'] = 'Opera�iunea de desc�rcare va �ncepe �n cur�nd; v� rug�m s� a�tepta�i p�n� aceasta va �ncepe';
$lang['Backups_not_supported'] = 'Scuza�i, dar efectuarea salv�rii (backup-ului) nu este �n prezent realizabil� pentru sistemul dumneavoastr� de baze de date';

$lang['Restore_Error_uploading'] = 'Eroare la publicarea fi�ierului de salvare (backup)';
$lang['Restore_Error_filename'] = 'Problem� cu numele fi�ierului; v� rug�m, �ncerca�i cu un alt fi�ier';
$lang['Restore_Error_decompress'] = 'Nu pot decomprima un fi�ier gzip; v� rug�m, publica�i o versiune text �ntreg (plain text)';
$lang['Restore_Error_no_file'] = 'Nici un fi�ier nu a fost publicat/�nc�rcat';


//
// Auth pages
//
$lang['Select_a_User'] = 'Selecta�i un utilizator';
$lang['Select_a_Group'] = 'Selecta�i un grup';
$lang['Select_a_Forum'] = 'Selecta�i un forum';
$lang['Auth_Control_User'] = 'Controlul permisiunilor utilizatorului';
$lang['Auth_Control_Group'] = 'Controlul permisiunilor grupului';
$lang['Auth_Control_Forum'] = 'Controlul permisiunilor forumului';
$lang['Look_up_User'] = 'Selecteaz� utilizatorul';
$lang['Look_up_Group'] = 'Selecteaz� grupul';
$lang['Look_up_Forum'] = 'Selecteaz� forumul';

$lang['Group_auth_explain'] = 'Aici pute�i modifica permisiunile �i starea moderatorului asociat la fiecare grup de utilizatori. Nu uita�i c�nd schimba�i permisiunile grupului c� permisiunile individuale ale utilizatorului pot s� permit� accesul utilizatorului la forumuri, etc. Ve�i fi aten�ionat dac� va ap�rea aceast� situa�ie.';
$lang['User_auth_explain'] = 'Aici pute�i modifica permisiunile �i starea moderatorului asociat la fiecare utilizator individual. Nu uita�i c�nd schimba�i permisiunile utilizatorului c� permisiunile individuale ale grupului pot s� permit� accesul utilizatorului la forumuri, etc. Ve�i fi aten�ionat dac� va ap�rea aceast� situa�ie.';
$lang['Forum_auth_explain'] = 'Aici pute�i modifica nivelurile de autorizare ale fiec�rui forum. Pentru a realiza acest lucru ave�i la dispozi�ie at�t o metod� simpl� c�t �i una avansat�, metoda avansat� oferind un control mai mare al fiec�riei opera�ii din forum. Aminti�i-v� c� schimbarea nivelului de permisiuni ale forumurilor va afecta modul de realizare(finalizare) al diverselor opera�iuni solicitate de c�tre utilizatori.';

$lang['Simple_mode'] = 'Modul simplu';
$lang['Advanced_mode'] = 'Modul avansat';
$lang['Moderator_status'] = 'Starea moderatorului';

$lang['Allowed_Access'] = 'Acces permis';
$lang['Disallowed_Access'] = 'Acces interzis';
$lang['Is_Moderator'] = 'este moderator';
$lang['Not_Moderator'] = 'nu este moderator';

$lang['Conflict_warning'] = 'Avertizare - Conflict de autorizare';
$lang['Conflict_access_userauth'] = 'Acest utilizator are �nc� drepturi de acces la acest forum datorate apartenen�ei acestuia la grup. Pute�i s� modifica�i permisiunile grupului sau s� �nl�tura�i acest utilizator din grup pentru a nu mai avea depturi de acces. Grupurile care dau drepturi (�i forumurile implicate) sunt afi�ate mai jos.';
$lang['Conflict_mod_userauth'] = 'Acest utilizator are �nc� drepturi de moderator la acest forum datorate apartenen�ei acestuia la grup. Pute�i s� modifica�i permisiunile grupului sau s� �nl�tura�i acest utilizator din grup pentru a nu mai avea depturi de moderator. Grupurile care dau drepturi (�i forumurile implicate) sunt afi�ate mai jos.';

$lang['Conflict_access_groupauth'] = 'Utilizatorul(i) urm�tor(i) are(au) �nc� drepturi de acces la acest forum datorate set�rilor lui(lor) de permisiuni. Pute�i s� modifica�i permisiunile utilizatorului pentru a nu mai avea drepturi de acces. Utilizatorii care dau drepturi (�i forumurile implicate) sunt afi�a�i mai jos.';
$lang['Conflict_mod_groupauth'] = 'Utilizatorul(i) urm�tor(i) are(au) �nc� drepturi de acces la acest forum datorate set�rilor lui(lor) de permisiuni. Pute�i s� modifica�i permisiunile utilizatorului pentru a nu mai avea drepturi de moderator. Utilizatorii care dau drepturi (�i forumurile implicate) sunt afi�a�i mai jos.';

$lang['Public'] = 'Public';
$lang['Private'] = 'Privat';
$lang['Registered'] = '�nregistrat';
$lang['Administrators'] = 'Administratori';
$lang['Hidden'] = 'Ascuns';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = 'TO�I';
$lang['Forum_REG'] = '�NREG';
$lang['Forum_PRIVATE'] = 'PRIVAT';
$lang['Forum_MOD'] = 'MOD';
$lang['Forum_ADMIN'] = 'ADMIN';

$lang['View'] = 'Vizualizare';
$lang['Read'] = 'Citire';
$lang['Post'] = 'Scriere';
$lang['Reply'] = 'R�spunde';
$lang['Edit'] = 'Modific�';
$lang['Delete'] = '�terge';
$lang['Sticky'] = 'Important';
$lang['Announce'] = 'Anun�';
$lang['Vote'] = 'Vot';
$lang['Pollcreate'] = 'Creare sondaj';

$lang['Permissions'] = 'Permisiuni';
$lang['Simple_Permission'] = 'Permisiune simpl�';

$lang['User_Level'] = 'Nivelul utilizatorului';
$lang['Auth_User'] = 'Utilizator';
$lang['Auth_Admin'] = 'Administrator';
$lang['Group_memberships'] = 'Membru al grupurilor';
$lang['Usergroup_members'] = 'Acest grup con�ine urm�torii membrii';

$lang['Forum_auth_updated'] = 'Permisiunile forumului au fost actualizate';
$lang['User_auth_updated'] = 'Permisiunile utilizatorului au fost actualizate';
$lang['Group_auth_updated'] = 'Permisiunile grupului au fost actualizate';

$lang['Auth_updated'] = 'Permisiunile au fost actualizate';
$lang['Click_return_userauth'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Controlul permisiunilor utilizatorului';
$lang['Click_return_groupauth'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Controlul permisiunilor grupului';
$lang['Click_return_forumauth'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Controlul permisiunilor forumului';


//
// Banning
//
$lang['Ban_control'] = 'Controlul interdic�iilor';
$lang['Ban_explain'] = 'Aici pute�i s� controla�i interdic�iile utilizatorilor. Pute�i ob�ine acest lucru interzic�nd una sau mai multe din elementele caracteristice unui utilizator: denumire utilizator, mul�imea adreselor IP sau numele host-urilor. Aceste metode �mpiedic� un utilizator s� nu ajung� �n pagina de �nceput a forumului. Pentru a �mpiedica un utilizator s� se �nregistreze sub un alt nume de utilizator pute�i specifica o adres� de mail interzis�. Re�ine�i c� o singur� adres� de mail interzis� nu-l va �mpiedeca pe utilizatorul �n cauz� s� intre sau s� scrie �n forumul dumneavoastr�; ar trebui s� folosi�i prima din cele dou� metode.';
$lang['Ban_explain_warn'] = 'Re�ine�i c� introducerea unei mul�imi de adrese IP �nseamn� c� toate adresele dintre �nceputul �i sf�r�itul mul�imii au fost ad�ugate la lista interzis�. Pentru a reduce num�rul de adrese ad�ugate la baza de date se pot folosi <i>wildcard</i>-urile unde este cazul. Dac� chiar trebuie s� introduce�i o plaj� de valori, �ncerca�i s� o p�stra�i c�t mai mic� sau mai bine re�ine�i doar adresele specifice.';

$lang['Select_username'] = 'Selecta�i un nume de utilizator';
$lang['Select_ip'] = 'Selecta�i un IP';
$lang['Select_email'] = 'Selecta�i o adres� de email';

$lang['Ban_username'] = 'Interzice�i unul sau mai mul�i utilizatori';
$lang['Ban_username_explain'] = 'Pute�i interzice mai mul�i utilizatori �ntr-un singur pas folosind combina�ii potrivite ale mouse-ului (�n browser) �i tastaturii calculatorului dumneavoastr�';

$lang['Ban_IP'] = 'Interzice�i una sau mai multe adrese IP sau nume de host-uri';
$lang['IP_hostname'] = 'Adrese IP sau nume de host-uri';
$lang['Ban_IP_explain'] = 'Pentru a specifica mai multe IP-uri diferite sau nume de host-uri trebuie s� le separa�i prin virgul�. Pentru a specifica o mul�ime de adrese IP, separa�i �nceputul �i sf�r�itul mul�imii cu o liniu�� de unire (-); ca s� specifica�i caracterul <i>wildcard</i> folosi�i *';

$lang['Ban_email'] = 'Interzice�i una sau mai multe adrese de email';
$lang['Ban_email_explain'] = 'Pentru a specifica mai multe adrese de email folosi�i separatorul virgul�. Ca s� specifica�i un utilizator cu ajutorul <i>wildcard</i>-ului folosi�i *, de exemplu *@hotmail.com';

$lang['Unban_username'] = 'Deblocarea utilizatorilor';
$lang['Unban_username_explain'] = 'Pute�i s� debloca�i mai mul�i utilizatori �ntr-un singur pas folosind combina�ii potrivite ale mouse-ului (�n browser) �i tastaturii calculatorului dumneavoastr�';

$lang['Unban_IP'] = 'Deblocarea adreselor IP';
$lang['Unban_IP_explain'] = 'Pute�i s� debloca�i mai multe adrese IP �ntr-un singur pas folosind combina�ii potrivite ale mouse-ului (�n browser) �i tastaturii calculatorului dumneavoastr�';

$lang['Unban_email'] = 'Deblocarea adreselor email';
$lang['Unban_email_explain'] = 'Pute�i s� debloca�i mai multe adrese email �ntr-un singur pas folosind combina�ii potrivite ale mouse-ului (�n browser) �i tastaturii calculatorului dumneavoastr�';

$lang['No_banned_users'] = 'Nu este nici un utilizator interzis';
$lang['No_banned_ip'] = 'Nu este nici o adres� IP interzis�';
$lang['No_banned_email'] = 'Nu este nici o adres� de email interzis�';

$lang['Ban_update_sucessful'] = 'Lista restric�iilor a fost actualizat� cu succes';
$lang['Click_return_banadmin'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Control Restric�ii';


//
// Configuration
//
$lang['General_Config'] = 'Configurare general�';
$lang['Config_explain'] = 'Formularul de mai jos v� permite s� personaliza�i toate op�iunile generale ale forumului. Pentru configurarea utilizatorilor �i forumurilor folosi�i leg�turile specifice aflate �n partea st�ng�.';

$lang['Click_return_config'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Configurare general�';

$lang['General_settings'] = 'Set�rile generale ale forumului';
$lang['Server_name'] = 'Numele domeniului';
$lang['Server_name_explain'] = 'Numele domeniului acestui forum ruleaz� din';
$lang['Script_path'] = 'Calea script-ului';
$lang['Script_path_explain'] = 'Calea unde phpBB2 este localizat relativ la numele domeniului';
$lang['Server_port'] = 'Port-ul serverului';
$lang['Server_port_explain'] = 'Port-ul pe care serverul dumneavoastr� ruleaz� este de obicei 80 (numai dac� nu a fost schimbat)';
$lang['Site_name'] = 'Numele site-ului';
$lang['Site_desc'] = 'Descrierea site-ului';
$lang['Board_disable'] = 'Forum dezactivat';
$lang['Board_disable_explain'] = 'Aceast� ac�iune va face forumul indisponibil utilizatorilor. Nu �nchide�i sesiunea curent� c�nd dezactiva�i forumul, altfel nu ve�i mai fi capabil s� v� autentifica�i din nou!';
$lang['Acct_activation'] = 'Validarea contului activat� de';
$lang['Acc_None'] = 'Nimeni'; // These three entries are the type of activation
$lang['Acc_User'] = 'Utilizator';
$lang['Acc_Admin'] = 'Administrator';

$lang['Abilities_settings'] = 'Configur�rile de baz� ale utilizatorilor �i forumurilor';
$lang['Max_poll_options'] = 'Num�rul maxim al op�iunilor chestionarului';
$lang['Flood_Interval'] = 'Interval de flood';
$lang['Flood_Interval_explain'] = 'Num�rul de secunde pe care un utilzator trebuie s�-l a�tepte �ntre public�ri';
$lang['Board_email_form'] = 'Trimite mesaj la utilizator via forum';
$lang['Board_email_form_explain'] = 'Utilizatorii pot trimit mesaje unii la al�i prin acest forum';
$lang['Topics_per_page'] = 'Subiecte pe pagin�';
$lang['Posts_per_page'] = 'Mesaje pe pagin�';
$lang['Hot_threshold'] = 'Mesaje pentru statutul popular';
$lang['Default_style'] = 'Stilul standard';
$lang['Override_style'] = 'Suprascrie stilul utilizatorului';
$lang['Override_style_explain'] = '�nlocuirea sitului utilizatorilor cu cel standard';
$lang['Default_language'] = 'Limba standard';
$lang['Date_format'] = 'Formatul datei';
$lang['System_timezone'] = 'Timpul zonal al sistemului';
$lang['Enable_gzip'] = 'Activare compresie GZip';
$lang['Enable_prune'] = 'Activare cur��ire forum';
$lang['Allow_HTML'] = 'Permite HTML';
$lang['Allow_BBCode'] = 'Permite cod BB';
$lang['Allowed_tags'] = 'Permite balize (tag-uri) HTML';
$lang['Allowed_tags_explain'] = 'Separ� balizele (tag-urile) cu virgule';
$lang['Allow_smilies'] = 'Permite z�mbete';
$lang['Smilies_path'] = 'Calea unde se p�streaz� z�mbetele';
$lang['Smilies_path_explain'] = 'Calea aflat� �n directorul dumneavoastr� phpBB , de exemplu. imagini/z�mbete';
$lang['Allow_sig'] = 'Permite semn�turi';
$lang['Max_sig_length'] = 'Lungimea maxim� a semn�turii';
$lang['Max_sig_length_explain'] = 'Num�rul maxim de caractere aflate �n semn�tura utilizatorului';
$lang['Allow_name_change'] = 'Permite schimbarea numelui de utilizator';

$lang['Avatar_settings'] = 'Configur�ri pentru imagini asociate (Avatar)';
$lang['Allow_local'] = 'Permite galerie de imagini asociate';
$lang['Allow_remote'] = 'Permite imagini asociate la distan��';
$lang['Allow_remote_explain'] = 'Imaginile asociate sunt specificate cu o leg�tur� la alt site web';
$lang['Allow_upload'] = 'Permite �nc�rcarea imaginii asociate';
$lang['Max_filesize'] = 'Dimensiunea maxim� a fi�ierului ce con�ine imaginea asociat�';
$lang['Max_filesize_explain'] = 'Pentru fi�ierele ce con�in imaginile asociate �nc�rcate';
$lang['Max_avatar_size'] = 'Dimensiunea maxim� a imaginii asociate';
$lang['Max_avatar_size_explain'] = '(�n�l�ime x L��ime �n pixeli)';
$lang['Avatar_storage_path'] = 'Calea de p�strare a imaginilor asociate';
$lang['Avatar_storage_path_explain'] = 'Calea aflat� �n directorul dumneavoastr� phpBB, de exemplu. imagini/avatar';
$lang['Avatar_gallery_path'] = 'Calea de p�strare a galeriilor cu imagini asociate';
$lang['Avatar_gallery_path_explain'] = 'Calea aflat� �n directorul dumneavoastr� phpBB, de exemplu. imagini/avatar/galerie';

$lang['COPPA_settings'] = 'Configur�rile COPPA';
$lang['COPPA_fax'] = 'Num�rul de fax';
$lang['COPPA_mail'] = 'Adresa po�tal� COPPA';
$lang['COPPA_mail_explain'] = 'Aceasta este adresa po�tal� unde p�rin�ii vor trimite formularele de �nregistrare COPPA';

$lang['Email_settings'] = 'Configur�rile de email';
$lang['Admin_email'] = 'Adresa de email a administratorului';
$lang['Email_sig'] = 'Semn�tura din email';
$lang['Email_sig_explain'] = 'Acest text va fi ata�at la toate mesajele pe care forumul le trimite';
$lang['Use_SMTP'] = 'Folosi�i serverul SMTP pentru email';
$lang['Use_SMTP_explain'] = 'Specifica�i da dac� dori�i sau ave�i nevoie s� trimite�i mesaje printr-un alt server �n loc s� folosi�i func�ia local� de mesagerie';
$lang['SMTP_server'] = 'Adresa serverului SMTP';
$lang['SMTP_username'] = 'Numele de utilizator SMTP';
$lang['SMTP_username_explain'] = 'Introduce�i numele de utilizator doar dac� serverul dumneavoastr� SMTP necesit� aceast� specificare';
$lang['SMTP_password'] = 'Parola SMTP';
$lang['SMTP_password_explain'] = 'Introduce�i parola doar dac� serverul dumneavoastr� SMTP necesit� aceast� specificare';

$lang['Disable_privmsg'] = 'Mesagerie privat�';
$lang['Inbox_limits'] = 'Num�rul maxim al mesajelor �n Cutia cu mesaje (Inbox)';
$lang['Sentbox_limits'] = 'Num�rul maxim al mesajelor �n Cutia cu mesaje trimise (Sentbox)';
$lang['Savebox_limits'] = 'Num�rul maxim al mesajelor �n Cutia cu mesaje salvate (Savebox)';

$lang['Cookie_settings'] = 'Configur�rile pentru cookie';
$lang['Cookie_settings_explain'] = 'Aceste detalii definesc cum sunt cookie-urile trimise c�tre browser-ele utilizatorilor. �n cele mai multe cazuri valorile standard pentru set�rile cookie-urilor ar trebui s� fie suficiente dar dac� trebuie s� le schimba�i ave�i mare grij�, set�rile incorecte pot �mpiedica utilizatorii s� se autentifice';
$lang['Cookie_domain'] = 'Domeniul pentru cookie';
$lang['Cookie_name'] = 'Numele pentru cookie';
$lang['Cookie_path'] = 'Calea pentru cookie';
$lang['Cookie_secure'] = 'Securizare cookie';
$lang['Cookie_secure_explain'] = 'Dac� serverul dumneavoastr� ruleaz� via SSL, selecta�i <i>Activat</i> altfel selecta�i <i>Dezactivat</i>';
$lang['Session_length'] = 'Durata sesiunii [ secunde ]';


// Visual Confirmation
$lang['Visual_confirm'] = 'Activeaz� Confirmarea Vizual�';
$lang['Visual_confirm_explain'] = 'Necesit� introducerea unui cod vizual definit ca o imagine la �nregistrare.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin'] = 'Permite autentific�ri automate';
$lang['Allow_autologin_explain'] = 'Determin� dac� utilizatorii au voie s� selecteze s� fie autentifica�i automat c�nd viziteaz� forumul.';
$lang['Autologin_time'] = 'Expirarea cheii de autentificare automat�.';
$lang['Autologin_time_explain'] = 'C�te zile este valid� o cheie de autentificare automat� dac� utilizatorul nu viziteaz� forumul. Seteaz� 0 pentru a dezactiva expirarea.';

// Intervalul limita pentru cautari - adaugat la 2.0.20
$lang['Search_Flood_Interval'] = 'Intervalul limit� pentru c�ut�ri';
$lang['Search_Flood_Interval_explain'] = 'Num�rul de secunde pe care un utilizator trebuie s�-l a�tepte �ntre c�utari'; 

//
// Forum Management
//
$lang['Forum_admin'] = 'Administrare forumuri';
$lang['Forum_admin_explain'] = '�n aceast� sec�iune pute�i ad�uga, �terge, modifica, reordona �i resincroniza categoriile �i forumurile.';
$lang['Edit_forum'] = 'Modificare forum';
$lang['Create_forum'] = 'Creaz� un forum nou';
$lang['Create_category'] = 'Creaz� o categorie nou�';
$lang['Remove'] = '�terge';
$lang['Action'] = 'Ac�iune';
$lang['Update_order'] = 'Actualizeaz� ordinea';
$lang['Config_updated'] = 'Configur�rile la forum au fost actualizate cu succes';
$lang['Edit'] = 'Modific�';
$lang['Delete'] = '�terge';
$lang['Move_up'] = 'Mut� mai sus';
$lang['Move_down'] = 'Mut� mai jos';
$lang['Resync'] = 'Resincronizare';
$lang['No_mode'] = 'Nici un mod nu a fost specificat';
$lang['Forum_edit_delete_explain'] = 'Formularul de mai jos v� permite s� personaliza�i toate op�iunile generale ale forumului. Pentru configurarea utilizatorilor �i forumurilor folosi�i leg�turile specifice aflate �n partea st�ng�.';

$lang['Move_contents'] = 'Mut� tot con�inutul';
$lang['Forum_delete'] = '�tergere forum';
$lang['Forum_delete_explain'] = 'Formularul de mai jos v� permite s� �terge�i un forum (sau o categorie) �i s� decide�i unde dori�i s� plasa�i toate subiectele (sau forumurile) pe care le con�ine.';

$lang['Status_locked'] = '�nchis';
$lang['Status_unlocked'] = 'Deschis';
$lang['Forum_settings'] = 'Configur�rile generale ale forumului';
$lang['Forum_name'] = 'Numele forumului';
$lang['Forum_desc'] = 'Descriere';
$lang['Forum_status'] = 'Starea forumului';
$lang['Forum_pruning'] = 'Autocur��are';

$lang['Forum_postcount'] = 'Count user\'s posts';

$lang['prune_freq'] = 'Verific� v�rsta subiectelor la fiecare';
$lang['prune_days'] = '�terge subiectele la care nu s-au scris r�spunsuri de';
$lang['Set_prune_data'] = 'A�i selectat op�iunea autocur��ire pentru acest forum dar nu a�i specificat o frecven�� sau un num�r de zile al intervalului pentru acest proces. V� rug�m reveni�i �i specifica�i aceste valori';

$lang['Move_and_Delete'] = 'Mut� �i �terge';

$lang['Delete_all_posts'] = '�terge toate mesajele';
$lang['Nowhere_to_move'] = 'Nu muta mesajele';

$lang['Edit_Category'] = 'Modificare categorie';
$lang['Edit_Category_explain'] = 'Pute�i folosi acest forumlar pentru a modifica numele categoriilor.';

$lang['Forums_updated'] = 'Informa�iile despre forumuri �i categorii au fost actualizate cu succes';

$lang['Must_delete_forums'] = 'Trebuie s� �terge�i toate forumurile �nainte ca s� �terge�i aceast� categorie';

$lang['Click_return_forumadmin'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Administrare forumuri';


//
// Smiley Management
//
$lang['smiley_title'] = 'Administrare z�mbete';
$lang['smile_desc'] = 'Din aceast� pagin� pute�i ad�uga, �terge �i modifica z�mbetele sau emo�iile asociate pe care utilizatorii dumneavoastr� le pot folosi c�nd scriu mesaje sau c�nd trimit mesaje private.';

$lang['smiley_config'] = 'Configurare z�mbete';
$lang['smiley_code'] = 'Cod z�mbet';
$lang['smiley_url'] = 'Fi�ierul imagine al z�mbetului';
$lang['smiley_emot'] = 'Emo�ia asociat�';
$lang['smile_add'] = 'Ad�uga�i un z�mbet nou';
$lang['Smile'] = 'Z�mbet';
$lang['Emotion'] = 'Emo�ia asociat�';

$lang['Select_pak'] = 'Selecta�i un fi�ier de tip Pack (.pak)';
$lang['replace_existing'] = '�nlocui�i z�mbetele existente';
$lang['keep_existing'] = 'P�stra�i z�mbetele existente';
$lang['smiley_import_inst'] = 'Ar trebui s� decomprima�i pachetul cu iconi�e �i s� �nc�rca�i toate fi�ierele �n directorul cu z�mbete specificat la instalare. Apoi selecta�i informa�iile corecte �n acest formular ca s� importa�i pachetul cu z�mbete.';
$lang['smiley_import'] = 'Importa�i z�mbetele';
$lang['choose_smile_pak'] = 'Selecta�i un fi�ier pachet cu z�mbete de tip .pak';
$lang['import'] = 'Importa�i z�mbete';
$lang['smile_conflicts'] = 'Ce ar trebui s� fie f�cut �n caz de conflicte';
$lang['del_existing_smileys'] = '�terge�i z�mbetele existente �nainte de import';
$lang['import_smile_pack'] = 'Importa�i pachetul cu z�mbete';
$lang['export_smile_pack'] = 'Crea�i pachetul cu z�mbete';
$lang['export_smiles'] = 'Ca s� crea�i un pachet cu z�mbete din z�mbetele instalate, ap�sa�i %saici%s ca s� desc�rca�i fi�ierul cu z�mbete .pak. Numi�i acest fi�ier cum dori�i dar asigura�i-v� c� a�i p�strat fi�ierului extensia .pak. Apoi crea�i un fie�ier arhivat con�in�nd toate imaginile z�mbete ale dumneavoastr� plus acest fi�ier .pak.';

$lang['smiley_add_success'] = 'Z�mbetul a fost ad�ugat cu succes';
$lang['smiley_edit_success'] = 'Z�mbetul a fost actualizat cu succes';
$lang['smiley_import_success'] = 'Pachetul cu z�mbete a fost importat cu succes!';
$lang['smiley_del_success'] = 'Z�mbetul a fost �ters cu succes';
$lang['Click_return_smileadmin'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Administrare z�mbete';

$lang['Confirm_delete_smiley'] = 'Sunte�i sigur c� dori�i s� �terge�i acest z�mbet ?';

//
// User Management
//
$lang['User_admin'] = 'Administrare utilizatori';
$lang['User_admin_explain'] = 'Aici pute�i schimba informa�iile despre utilizatorii dumneavoastr� �i op�iunile specifice. Ca s� modifica�i drepturile utilizatorilor, folosi�i drepturile din sistem ale utilizatorilor �i grupurilor.';

$lang['Look_up_user'] = 'Selecteaz� utilizatorul';

$lang['Admin_user_fail'] = 'Nu se poate actualiza profilul utilizatorului.';
$lang['Admin_user_updated'] = 'Profilul utilizatorului a fost actualizat cu succes.';
$lang['Click_return_useradmin'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Administrare utilizatori';

$lang['User_delete'] = '�terge�i acest utilizator';
$lang['User_delete_explain'] = 'Ap�sa�i aici pentru a �terge acest utilizator, aceast� opera�ie este ireversibil�.';
$lang['User_deleted'] = 'Utilizatorul a fost �ters cu succes.';

$lang['User_status'] = 'Utilizatorul este activ';
$lang['User_allowpm'] = 'Poate trimite mesaje private';
$lang['User_allowavatar'] = 'Poate folosi imagini asociate';

$lang['Admin_avatar_explain'] = 'Aici pute�i vizualiza �i �terge imaginea asociat� a utilizatorului.';

$lang['User_special'] = 'C�mpuri speciale doar pentru administrator';
$lang['User_special_explain'] = 'Aceste c�mpuri nu pot fi modificate de c�tre utilizatori. Aici pute�i s� specifica�i stadiul lor �i alte op�iuni care nu sunt oferite utilizatorilor.';


//
// Group Management
//
$lang['Group_administration'] = 'Administrarea grupurilor';
$lang['Group_admin_explain'] = 'Din aceast� sec�iune pute�i administra toate grupurile cu utilizatori ale dumneavoastr�, pute�i �terge, crea �i modifica grupurile existente. Pute�i alege moderatorii, schimba �n deschis/�nchis statutul grupului �i specifica numele �i descrierea grupului';
$lang['Error_updating_groups'] = 'A fost o eroare �n timpul actualiz�rii grupurilor';
$lang['Updated_group'] = 'Grupul a fost actualizat cu succes';
$lang['Added_new_group'] = 'Noul grup a fost creat cu succes';
$lang['Deleted_group'] = 'Grupul a fost �ters cu succes';
$lang['New_group'] = 'Creaz� un grup nou';
$lang['Edit_group'] = 'Modific� grupul';
$lang['group_name'] = 'Numele grupului';
$lang['group_description'] = 'Descrierea grupului';
$lang['group_moderator'] = 'Moderatorul grupului';
$lang['group_status'] = 'Statutul grupului';
$lang['group_open'] = 'Grup deschis';
$lang['group_closed'] = 'Grup �nchis';
$lang['group_hidden'] = 'Grup ascuns';
$lang['group_delete'] = '�terg grupul';
$lang['group_delete_check'] = 'Vreau s� �terg acest grup';
$lang['submit_group_changes'] = 'Efectueaz� modific�rile';
$lang['reset_group_changes'] = 'Reseteaz� modific�rile';
$lang['No_group_name'] = 'Trebuie s� specifica�i un nume pentru acest grup';
$lang['No_group_moderator'] = 'Trebuie s� specifica�i un moderator pentru acest grup';
$lang['No_group_mode'] = 'Trebuie s� specifica�i un mod (deschis/�nchis) pentru acest grup';
$lang['No_group_action'] = 'Nici o ac�iune nu a fost specificat�';
$lang['delete_group_moderator'] = 'Dori�i s� �terge�i moderatorul vechi al grupului?';
$lang['delete_moderator_explain'] = 'Dac� schimba�i moderatorul grupului, bifa�i aceast� c�su�� ca s� �terge�i vechiul moderator al grupului din grup. Altfel, nu o bifa�i �i utilizatorul va deveni un membru normal al grupului.';
$lang['Click_return_groupsadmin'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Administrarea grupurilor.';
$lang['Select_group'] = 'Selecteaz� un grup';
$lang['Look_up_group'] = 'Selecteaz� grupul';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'Cur��irea forumurilor';
$lang['Forum_Prune_explain'] = 'Aceast� ac�iune va �terge orice subiect care nu a fost completat �ntr-un num�r de zile egal cu cel pe care l-a�i specificat. Dac� nu a�i introdus un num�r atunci toate subiectele vor fi �terse. Nu vor fi �terse subiecte �n care sondajele �nc� ruleaz� �i nici anun�urile. Aceste subiecte trebuie s� le �terge�i manual.';
$lang['Do_Prune'] = 'Efectueaz� cur��irea';
$lang['All_Forums'] = 'Toate forumurile';
$lang['Prune_topics_not_posted'] = 'Cur��irea subiectelor f�r� r�spunsuri �n multe zile';
$lang['Topics_pruned'] = 'Subiecte cur��ite';
$lang['Posts_pruned'] = 'Mesaje cur��ite';
$lang['Prune_success'] = 'Cur��irea mesajelor s-a efectuat cu succes';


//
// Word censor
//
$lang['Words_title'] = 'Administrarea cuvintelor cenzurate';
$lang['Words_explain'] = 'Din aceast� sec�iune pute�i ad�uga, modifica �i �terge cuvinte care vor fi automat cenzurate �n forumurile dumneavoastr�. �n plus, persoanelor nu le va fi permis s� se �nregistreze cu nume de utilizator ce con�in aceste cuvinte. Wildcard-urile (*) sunt acceptate �n c�mpul pentru cuvinte, de exemplu *test* se va potrivi cu detestabil, test* se va potrivi cu testare, *test se va potrivi cu detest.';
$lang['Word'] = 'Cuv�nt';
$lang['Edit_word_censor'] = 'Modific cuv�ntul cenzurat';
$lang['Replacement'] = '�nlocuire';
$lang['Add_new_word'] = 'Adaug� un cuv�nt nou';
$lang['Update_word'] = 'Actualizeaz� cuv�ntul cenzurat';

$lang['Must_enter_word'] = 'Trebuie s� introduce�i un cuv�nt �i �nlocuirile acestuia';
$lang['No_word_selected'] = 'Nici un cuv�nt nu a fost selectat pentru modificare';

$lang['Word_updated'] = 'Cuv�ntul cenzurat selectat a fost actualizat cu succes';
$lang['Word_added'] = 'Cuv�ntul cenzurat a fost ad�ugat cu succes';
$lang['Word_removed'] = 'Cuv�ntul cenzurat selectat a fost �ters cu succes';

$lang['Click_return_wordadmin'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Administrarea cuvintelor cenzurate';

$lang['Confirm_delete_word'] = 'Sunte�i sigur c� dori�i s� �terge�i acest acest cuv�nt cenzurat ?';


//
// Mass Email
//
$lang['Mass_email_explain'] = 'Aici pute�i trimite un email la to�i utilizatorii dumneavoastr� sau la utilizatorii dintr-un grup specific. Pentru a realiza acest lucru, un email va fi trimis la adresa de email a administratorulu cu to�i destinatarii specifica�i �n c�mpul BCC. Dac� trimite�i email la un grup mare de oameni, v� rug�m s� fi�i atent dup� trimitere �i nu v� opri�i la jum�tatea paginii. Este normal ca pentru o coresponden�� masiv� s� fie nevoie de un timp mai lung astfel c� ve�i fi notificat c�nd ac�iunea s-a terminat';
$lang['Compose'] = 'Compune';

$lang['Recipients'] = 'Destinatari';
$lang['All_users'] = 'To�i utilizatorii';

$lang['Email_successfull'] = 'Mesajul dumneavoastr� a fost trimis';
$lang['Click_return_massemail'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Coresponden�� masiv�';


//
// Ranks admin
//
$lang['Ranks_title'] = 'Administrarea rangurilor';
$lang['Ranks_explain'] = 'Folosind acest formular pute�i ad�uga, modifica, vizualiza �i �terge ranguri. De asemenea, pute�i crea ranguri personalizate care pot fi aplicate unui utilizator via facilit��ii date de managementul utilizatorilor';

$lang['Add_new_rank'] = 'Adaug� un rang nou';

$lang['Rank_title'] = 'Titlul rangului';
$lang['Rank_special'] = 'Seteaz� ca rang special';
$lang['Rank_minimum'] = 'Num�r minim de mesaje';
$lang['Rank_maximum'] = 'Num�r maxim de mesaje';
$lang['Rank_image'] = 'Imaginea rangului (relativ la calea phpBB2-ului)';
$lang['Rank_image_explain'] = 'Aceasta este folosit� pentru a defini o imagine mic� asociat� cu rangul';

$lang['Must_select_rank'] = 'Trebuie s� selecta�i un rang';
$lang['No_assigned_rank'] = 'Nici un rang special nu a fost repartizat';

$lang['Rank_updated'] = 'Rangul a fost actualizat cu succes';
$lang['Rank_added'] = 'Rangul a fost ad�ugat cu succes';
$lang['Rank_removed'] = 'Rangul a fost �ters cu succes';
$lang['No_update_ranks'] = 'Rangul a fost �ters cu succes, conturile utilizatorilor care folosesc acest rang nu au fost actualizate. Trebuie s� reseta�i manual rangul pentru aceste conturi';

$lang['Click_return_rankadmin'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Administrarea rangurilor';

$lang['Confirm_delete_rank'] = 'Sunteti sigur ca doriti sa stergeti acest rang ?';

//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'Administrarea numelor de utilizator nepremise';
$lang['Disallow_explain'] = 'Aici pute�i controla numele de utilizator care nu sunt permise s� fie folosite. Numele de utilizator care nu sunt permise pot con�ine caracterul *. Re�ine�i c� nu ave�i posibilitatea s� specifica�i orice nume de utilizator care a fost deja �nregistrat; trebuie mai �nt�i s� �terge�i acel nume �i apoi s�-l interzice�i';

$lang['Delete_disallow'] = '�terge';
$lang['Delete_disallow_title'] = '�terge un nume de utilizator nepermis';
$lang['Delete_disallow_explain'] = 'Pute�i �terge un nume de utilizator nepermis select�nd numele de utilizator din aceast� list� �i ap�s�nd butonul <i>�terge</i>';

$lang['Add_disallow'] = 'Adaug�';
$lang['Add_disallow_title'] = 'Adaug� un nume de utilizator nepermis';
$lang['Add_disallow_explain'] = 'Pute�i interzice un nume de utilizator folosind caracterul wildcard * care se potrive�te la orice caracter';

$lang['No_disallowed'] = 'Nici un nume de utilizator nu a fost interzis';

$lang['Disallowed_deleted'] = 'Numele de utilizator nepermis a fost �ters cu succes';
$lang['Disallow_successful'] = 'Numele de utilizator nepermis a fost ad�ugat cu succes';
$lang['Disallowed_already'] = 'Numele pe care l-a�i introdus nu poate fi interzis. Ori exist� deja �n list�, exist� �n lista cuvintelor cenzurate sau exist� un nume de utilizator similar';

$lang['Click_return_disallowadmin'] = 'Ap�sa�i %saici%s pentru a reveni la sec�iunea Administrarea numelor de utilizator nepremise';


//
// Styles Admin
//
$lang['Styles_admin'] = 'Administrarea stilurilor';
$lang['Styles_explain'] = 'Folosind aceast� facilitate pute�i ad�uga, �terge �i administra stilurile (�abloanele �i temele) disponibile utilizatorilor dumneavoastr�';
$lang['Styles_addnew_explain'] = 'Lista urm�toare con�ine toate temele care sunt disponibile pentru �abloanele pe care le ave�i. Elementele din aceast� list� nu au fost instalate �n baza de date a phpBB-ului. Ca s� instala�i o tem� ap�sa�i pe leg�tura <i>Instaleaz�</i> de l�ng� denumirea temei';

$lang['Select_template'] = 'Selecta�i un �ablon';

$lang['Style'] = 'Stilul';
$lang['Template'] = '�ablonul';
$lang['Install'] = 'Instaleaz�';
$lang['Download'] = 'Descarc�';

$lang['Edit_theme'] = 'Modific� tema';
$lang['Edit_theme_explain'] = '�n formularul de mai jos pute�i modifica configur�rile pentru tema selectat�';

$lang['Create_theme'] = 'Creaz� tem�';
$lang['Create_theme_explain'] = 'Folosi�i formularul de mai jos ca s� crea�i o tem� nou� pentru un �ablon selectat. C�nd introduce�i culori (pentru care trebuie s� folosi�i nota�ie hexazecimal�) nu trebuie s� include�i ini�iala #, de exemplu CCCCCC este valid�, #CCCCCC nu este valid�';

$lang['Export_themes'] = 'Export� teme';
$lang['Export_explain'] = '�n aceast� sec�iune pute�i exporta teme dintr-un �ablon selectat. Selecta�i �ablonul din lista de mai jos �i programul va crea un fi�ier de configurare a temei �i �ncerca�i s�-l salva�i �n directorul �ablonului selectat. Dac� fi�ierul nu poate fi salvat vi se va da posibilitatea s�-l desc�rca�i. Pentru ca programul s� salveze fi�ierul trebuie s� da�i drepturi de scriere pentru serverul web pe directorul �ablonului selectat. Pentru mai multe informa�ii consulta�i pagina 2 din ghidul utilizatorilor phpBB.';

$lang['Theme_installed'] = 'Tema selectat� a fost instalat� cu succes';
$lang['Style_removed'] = 'Stilul selectat a fost �ters din baza de date. Pentru a �terge definitiv acest stil din sistem, trebuie s�-l �terge�i din directorul dumneavoastr� cu �abloane.';
$lang['Theme_info_saved'] = 'Informa�iile temei pentru �ablonul curent au fost salvate. Acum trebuie s� specifica�i permisiunile �n fi�ierul theme_info.cfg (�i dac� se poate directorul �ablonului selectat) la acces doar de citire';
$lang['Theme_updated'] = 'Tema selectat� a fost actualizat�. Acum ar trebui s� exporta�i set�rile temei noi';
$lang['Theme_created'] = 'Tem� a fost creat�. Acum ar trebui s� exporta�i tema �n fi�ierul de configurare al temei pentru p�strarea �n siguran�� a acesteia sau s-o folosi�i altundeva';

$lang['Confirm_delete_style'] = 'Sunte�i sigur c� dori�i s� �terge�i acest stil?';

$lang['Download_theme_cfg'] = 'Procedura de export nu poate scrie fi�ierul cu informa�iile temei. Ap�sa�i butonul de mai jos ca s� desc�rca�i acest fi�ier. Odat� ce l-a�i desc�rcat pute�i s�-l transfera�i �n directorul care con�ine fi�ierele cu �abloane. Pute�i �mpacheta fi�ierele pentru distribu�ie sau s� le folosi�i unde dori�i';
$lang['No_themes'] = '�ablonul pe care l-a�i selectat nu are teme ata�ate. Ca s� crea�i o tem� nou� ap�sa�i leg�tura <i>Creaz� tem�</i> din partea st�ng�';
$lang['No_template_dir'] = 'Nu se poate deschide directorul cu �abloane. Acesta ori nu poate fi citit de c�tre serverul web ori nu exist�';
$lang['Cannot_remove_style'] = 'Nu pute�i �terge stilul selectat �n timp ce este acesta este stilul standard pentru forum. Schimba�i stilul standard �i �ncerca�i din nou.';
$lang['Style_exists'] = 'Numele stilului pe care l-a�i selectat exist� deja, v� rug�m reveni�i �i alege�i un nume diferit.';

$lang['Click_return_styleadmin'] = 'Ap�sa�i %saici%s ca s� reveni�i la sec�iunea Administrarea stilurilor';

$lang['Theme_settings'] = 'Configur�rile temei';
$lang['Theme_element'] = 'Elementul temei';
$lang['Simple_name'] = 'Numele simplu';
$lang['Value'] = 'Valoarea';
$lang['Save_Settings'] = 'Salveaz� configur�rile';

$lang['Stylesheet'] = 'Stilul CSS';
$lang['Stylesheet_explain'] = 'Numele fi�ierului pentru stilul CSS folosit �n aceast� tem�.';
$lang['Background_image'] = 'Imaginea fundalului';
$lang['Background_color'] = 'Culoarea fundalului';
$lang['Theme_name'] = 'Numele temei';
$lang['Link_color'] = 'Culoarea leg�turii';
$lang['Text_color'] = 'Culoarea textului';
$lang['VLink_color'] = 'Culoarea leg�turii vizitate';
$lang['ALink_color'] = 'Culoarea leg�turii active';
$lang['HLink_color'] = 'Culoarea leg�turii acoperite';
$lang['Tr_color1'] = 'Culoarea 1 a r�ndului din tabel';
$lang['Tr_color2'] = 'Culoarea 2 a r�ndului din tabel';
$lang['Tr_color3'] = 'Culoarea 3 a r�ndului din tabel';
$lang['Tr_class1'] = 'Clasa 1 a r�ndului din tabel';
$lang['Tr_class2'] = 'Clasa 2 a r�ndului din tabel';
$lang['Tr_class3'] = 'Clasa 3 a r�ndului din tabel';
$lang['Th_color1'] = 'Culoarea 1 a antetului din tabel';
$lang['Th_color2'] = 'Culoarea 2 a antetului din tabel';
$lang['Th_color3'] = 'Culoarea 3 a antetului din tabel';
$lang['Th_class1'] = 'Clasa 1 a antetului din tabel';
$lang['Th_class2'] = 'Clasa 2 a antetului din tabel';
$lang['Th_class3'] = 'Clasa 3 a antetului din tabel';
$lang['Td_color1'] = 'Culoarea 1 a celulei din tabel';
$lang['Td_color2'] = 'Culoarea 2 a celulei din tabel';
$lang['Td_color3'] = 'Culoarea 3 a celulei din tabel';
$lang['Td_class1'] = 'Clasa 1 a celulei din tabel';
$lang['Td_class2'] = 'Clasa 2 a celulei din tabel';
$lang['Td_class3'] = 'Clasa 3 a celulei din tabel';
$lang['fontface1'] = 'Fontul de fa�� 1';
$lang['fontface2'] = 'Fontul de fa�� 2';
$lang['fontface3'] = 'Fontul de fa�� 3';
$lang['fontsize1'] = 'Dimensiunea 1 a fontului';
$lang['fontsize2'] = 'Dimensiunea 2 a fontului';
$lang['fontsize3'] = 'Dimensiunea 3 a fontului';
$lang['fontcolor1'] = 'Culoarea 1 a fontului';
$lang['fontcolor2'] = 'Culoarea 2 a fontului';
$lang['fontcolor3'] = 'Culoarea 3 a fontului';
$lang['span_class1'] = 'Clasa 1 a separatorului';
$lang['span_class2'] = 'Clasa 2 a separatorului';
$lang['span_class3'] = 'Clasa 3 a separatorului';
$lang['img_poll_size'] = 'Dimensiunea imaginii sondajului [px]';
$lang['img_pm_size'] = 'Dimensiunea statutului de mesaj privat [px]';


//
// Install Process
//
$lang['Welcome_install'] = 'Bine a�i venit la procedura de instalare a forumului phpBB2';
$lang['Initial_config'] = 'Configura�ia de baz�';
$lang['DB_config'] = 'Configura�ia bazei de date';
$lang['Admin_config'] = 'Configura�ia administratorului';
$lang['continue_upgrade'] = 'Odat� ce a�i desc�rcat fi�ierul dumneavoastr� de configurare pe calculatorul local pute�i folosi butonul <i>Continu� actualizarea</i> de mai jos ca s� trece�i la urm�torul pas din actualizare. V� rug�m a�tepta�i s� se �ncarce fi�ierul de configurare p�n� ce actualizarea  este complet�.';
$lang['upgrade_submit'] = 'Continu� actualizarea';

$lang['Installer_Error'] = 'O eroare a ap�rut �n timpul instal�rii';
$lang['Previous_Install'] = 'O instalare anterioar� a fost detectat�';
$lang['Install_db_error'] = 'O eroare a ap�rut �n timpul actualiz�rii bazei de date';

$lang['Re_install'] = 'Instalarea anterioar� este �nc� activ�. <br /><br />Dac� dori�i s� reinstala�i phpBB2-ul ar trebui s� ap�sa�i pe butonul Da de mai jos. V� rug�m s� ave�i grij� ca s� nu distruge�i toate datele existente, nici o copie de siguran�� nu va fi f�cut�! Numele de utilizator �i parola administratorului pe care le-a�i folosit s� v� autentifica�i �n forum vor fi recreate dup� reinstalare, nici o alt� setare nu va fi p�strat�. <br /><br />G�ndi�i-v� atent �nainte de a ap�sa butonul <i>Porne�te instalarea</i>!';

$lang['Inst_Step_0'] = 'V� mul�umim c� a�i ales phpBB2. Pentru a completa aceast� instalare v� rug�m s� completa�i detaliile de mai jos. Re�ine�i c� baza de date pe care o folosi�i trebuie s� existe deja. Dac� instala�i �ntr-o baz� de date care folose�te ODBC, de exemplu MS Access ar trebui mai �nt�i s� crea�i un DSN pentru aceasta �nainte de a continua.';

$lang['Start_Install'] = 'Porne�te instalarea';
$lang['Finish_Install'] = 'Termin� instalarea';

$lang['Default_lang'] = 'Limba standard pentru forum';
$lang['DB_Host'] = 'Numele serverului gazd� pentru baza de date / DSN';
$lang['DB_Name'] = 'Numele bazei dumneavoastr� de date';
$lang['DB_Username'] = 'Numele de utilizator al bazei de date';
$lang['DB_Password'] = 'Parola de utilizator al bazei de date';
$lang['Database'] = 'Baza dumneavoastr� de date';
$lang['Install_lang'] = 'Alege�i limba pentru instalare';
$lang['dbms'] = 'Tipul bazei de date';
$lang['Table_Prefix'] = 'Prefixul pentru tabelele din baza de date';
$lang['Admin_Username'] = 'Numele de utilizator al administratorului';
$lang['Admin_Password'] = 'Parola administratorului';
$lang['Admin_Password_confirm'] = 'Parola administratorului [ Confirma�i ]';

$lang['Inst_Step_2'] = 'Numele de utilizator pentru administrator a fost creat. Acum instalarea de baz� este complet�. Va ap�rea un ecran care v� va permite s� administra�i noua dumneavoastr� instalare. Asigura�i-v� c� a�i verificat detaliile sec�iunii Configurare general� �i a�i efectuat orice schimbare necesar�. V� mul�umim c� a�i ales phpBB2.';

$lang['Unwriteable_config'] = 'Fi�ierul dumneavoastr� de configurare �n acest moment este protejat la scriere. O copie a fi�ierului de configurare va fi desc�rcat� c�nd ap�sa�i butonul de mai jos. At trebui s� �nc�rca�i acest fi�ier �n acela�i director ca �i phpBB2. Odat� ce aceast� opera�iune este terminat� ar trebui s� v� autentifica�i folosind numele de utilizator �i parola administratorului pe care le-a�i specificat �n formularul anterior �i s� vizita�i centrul de control al administratorului (o leg�tur� va ap�rea la cap�tul fiec�rei pagini odat� ce v-a�i autentificat) ca s� verifica�i configura�ia general�. V� mul�umim c� a�i ales phpBB2.';
$lang['Download_config'] = 'Descarc� fi�ierul de configurare';

$lang['ftp_choose'] = 'Alege�i metoda de desc�rcare';
$lang['ftp_option'] = '<br />�ntruc�t extensiile FTP sunt activate �n aceast� versiune a PHP-ului, ave�i posibilitatea de a �ncerca s� plasa�i prin ftp fi�ierul de configurare la locul lui.';
$lang['ftp_instructs'] = 'A�i ales s� transmite�i fi�ierul automat prin ftp �n contul care con�ine phpBB2-ul. V� rug�m introduce�i informa�iile cerute mai jos ca s� facilita�i aceast proces. Calea unde este situat FTP-ul trebuie s� fie calea exact� via ftp la instalarea phpBB2-ului dumneavoastr� ca �i cum a�i transmite folosind un client normal de ftp.';
$lang['ftp_info'] = 'Introduce�i informa�iile dumneavoastr� despre FTP';
$lang['Attempt_ftp'] = '�ncercare de a transfera la locul specificat fi�ierul de configurare prin ftp';
$lang['Send_file'] = 'Trimite doar fi�ierul la mine �i eu voi �l voi trimite manual prin ftp';
$lang['ftp_path'] = 'Calea FTP la phpBB2';
$lang['ftp_username'] = 'Numele dumneavoastr� de utilizator pentru FTP';
$lang['ftp_password'] = 'Parola dumneavoastr� de utilizator pentru FTP';
$lang['Transfer_config'] = 'Porne�te transferul';
$lang['NoFTP_config'] = '�ncercarea de a transfera la locul specificat fi�ierul de configurare prin ftp a e�uat. V� rug�m s� desc�rca�i fi�ierul de configurare �i s�-l transmite�i manual prin ftp la locul specificat.';

$lang['Install'] = 'Instaleaz�';
$lang['Upgrade'] = 'Actualizeaz�';


$lang['Install_Method'] = 'Alege�i metoda de instalare';

$lang['Install_No_Ext'] = 'Configurarea php-ului pe serverul dumneavoastr� nu suport� tipul de baz� de date pe care l-a�i ales';

$lang['Install_No_PCRE'] = 'phpBB2 necesit� modulul de expresii regulate compatibil Perl pentru php pe care configura�ia dumneavoastr� de php se pare c� nu-l suport�!';

//
// Version Check
//
$lang['Version_up_to_date'] = 'Forumul dumneavoastr� folose�te ultima versiune phpBB. Nu sunt actualiz�ri disponibile pentru versiunea dumneavoastr�.';
$lang['Version_not_up_to_date'] = 'Forumul dumneavoastr� pare s� <b>nu</b> fie actualizat. Noile versiuni sunt disponibile la adresa <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/downloads.php</a>.';
$lang['Latest_version_info'] = 'Cea mai nou� versiune este <b>phpBB %s</b>.';
$lang['Current_version_info'] = 'Folosi�i <b>phpBB %s</b>.';
$lang['Connect_socket_error'] = 'Nu am putut deschide conexiunea cu serverul phpBB, eroarea raportat� este:<br />%s';
$lang['Socket_functions_disabled'] = 'Nu am putut folosi func�iile socket.';
$lang['Mailing_list_subscribe_reminder'] = 'Pentru cele mai noi informa�ii despre phpBB, <a href="http://www.phpbb.com/support/" target="_new">v� pute�i �nscrie la serviciul de �tiri</a>.';
$lang['Version_information'] = 'Informa�ii despre versiuni';

//
// Login attempts configuration
//
$lang['Max_login_attempts'] = 'Permite �ncerc�ri de autentificare';
$lang['Max_login_attempts_explain'] = 'Num�rul de �ncerc�ri de autentificare permise.';
$lang['Login_reset_time'] = 'Timpul necesar reautentific�rii';
$lang['Login_reset_time_explain'] = 'Num�rul de minute pe care un user trebuie s�-l a�tepte pentru a i se permite s� se autentifice din nou, dup� dep�irea num�rului de �ncerc�ri de autentificare permise.';

// Start add - Bin Mod
$lang['Bin_forum'] = 'Bin forum';
$lang['Bin_forum_explain'] = 'Fill with the forum ID where topics moved to bin, a value of 0 will disable this feature. You should edit this forum permissions to allow or not view/post/reply... by users or forbid access to this forum.';
// End add - Bin Mod

$lang['Draft_allow']='Allow users to make their posts a draft';

//
// That's all Folks!
// -------------------------------------------------

?>
