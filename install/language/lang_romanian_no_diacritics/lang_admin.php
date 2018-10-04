<?php
/**
*
* @package MX-Publisher Core
* @version $Id: lang_admin.php,v 1.2 2008/08/19 02:46:23 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

//
// Editor Settings: Please set Tabsize to 4 ;-)
//

//
// The format of this file is:
//
// ---> $lang['message'] = 'text';
//
// Specify your language character encoding... [optional]
//
// setlocale(LC_ALL, 'ro');

//
// Install Process
//
$lang['Portal_paths'] 				= 'Cale Portal';
$lang['ReadOnly'] 					= '(doar pentru citire)';
$lang['Welcome_install'] 			= 'Bine ati venit la Vrajitorul de Installare al MX-Publisher';
$lang['Install_Instruction']		= 'Te rog complecteza detaliile cerute jos. Acest program de instalare va creea fisierul config.php personalizat (in directorul radacina al Portalului) si baza de date a Portalului cu setarile implicite. Odata ce aceasta este gata, vei vedea un raport al tuturor pasilor facuti (te rog noteaza ca MX-Publisher nu modifica baza de date a forumului phpBB in nici un fel). Ar trebui sa te logezi cu numele utilizatorului administrator si parola si sa mergi la Panoul de Control de Administratie pt. a configura portalul cu preferintele tale. Te rog noteaza ca MX-Publisher nu va lucra de unul singur, phpBB trebuie instalat dinainte si configurat. Multumim pentru ca ai ales MX-Publisher.';
$lang['Install_Instruction_mxBB'] 	= 'Asigurati-va ca completati formularul de mai jos cu atentie. Daca aveti nevoie, consultati documentatia MXP pentru asistenta suplimentara.';
$lang['Install_Instruction_MXP_Admin']	= 'Daca MXP nume-admin si parola sunt lasate goale, administratorul dvs. de cont va fi creat: numele de utilizator (admin), parola (admin). Modificati aceasta parola URGENT!';
$lang['Install_Instruction_phpBB']	= 'Va rugam sa luati seama, chiar daca aveti de gand sa folositi MX-Publisher cu phpBB, aceasta instalare nu va modifica baza de date phpBB in nici un fel.';
$lang['Upgrade_Instruction']		= 'MX-Publisher este deja instalat. Te rog fa backuri la baza ta de date acum !<br /><br />Urmatoarea etapa va modifica structura bazei de date (te rog noteaza ca MX-Publisher nu modifica baza de date a forumului phpBB in nici un fel). Daca totusi din oarecare motiv acesta procedura de upgradare esuiaza, Nu ar exista nici o cale de intoarcere la statutul curect. Te rog fa backupuri ale bazei de date iNAINTE de a proceda !<br /><br />Odata ce aceasta este gata, da click pe butonul de jos pentru a incepe procedura de upgradare.';
$lang['Install_moreinfo']			= '%sNote de Lansare%s | %sPachet Bun Venit%s | %sFAQ Online%s | %sForumuri de Suport%s | %sTermeni De Utilizare%s';
$lang['Install_settings']			= 'Setari Instalare';
$lang['Choose_lang_explain']		= 'Te rog foloseste formularul de jos pentru a selecta limba pe care vrei so folosesti in procesul de instalare.';
$lang['Choose_lang']				= 'Alege Limba';
$lang['Language']					= 'Limba';
$lang['Phpbb_only'] 				= '[phpBBX]';
$lang['Mxbb_only'] 					= '[Internal]';
$lang['Portal_backend'] 			= 'Nume Backend';
$lang['Session_backend'] 			= 'Users & Sessions';
$lang['Session_backend_explain'] 	= 'The MX-Publisher-IWizard has detected installed phpBB boards on this server. <br />Select here if you plan to use MX-Publisher with phpBB users and sessions. <br />If you are unsure (or if you want to install MX-Publisher without phpBB), select \'Internal\' setup. <br />You may update this setting later in the MX-Publisher adminCP';
$lang['Phpbb_path']					= 'phpBB cale relativa';
$lang['Phpbb_path_explain'] 		= 'Cale relativa la phpBB, ex. phpBB/ or ../phpBB/<br />Noteaza slasurile "/", ele sunt importante!';
$lang['Phpbb_url'] 					= 'URL phpBB Complet';
$lang['Portal_backend'] 			= 'Portal Backend';
$lang['Phpbb_url_explain']			= 'Exemplu URL phpBB Complect, ex. <br />http://www.exemplu.ro/phpBB/';
$lang['Portal_url'] 				= 'URL Complet CMS';
$lang['Portal_url_explain'] 		= 'URL Complet CMS, ex. <br />http://www.exemplu.ro/';
$lang['Database_settings']			= 'Setari Baza de Date';
$lang['dbms']						= 'Tip Baza de Date';
$lang['DB_Host']					= 'BazaDate Server NumeHost/DSN';
$lang['DB_Name']					= 'Numele BazaDate';
$lang['DB_Username']				= 'NumeUser Baza de Date';
$lang['MXP_Adminname'] 				= 'MXP Admin Username';
$lang['DB_Password']				= 'Parola BazaDate';
$lang['MXP_Password'] 				= 'MXP Admin Password';
$lang['MXP_Password2'] 				= 'MXP Admin Password (repeat)';
$lang['Table_Prefix']				= 'phpBB Prefix in DB';
$lang['MX_Table_Prefix']			= 'MX-Publisher Prefix in DB';
$lang['Start_Install']				= 'Porneste Instalrea mxBB';
$lang['Start_Upgrade']				= 'Da, Eu am facut deja backup si vreau sa-mi upgradez MX-Publisher acum.';
$lang['Portal_intalled']			= 'MX-Publisher a fost instalat !';
$lang['Portal_upgraded']			= 'MX-Publisher a fost upgradat !';
$lang['Unwriteable_config']			= 'Fisierul de configurare mxBB (config.php) este ne-write-abil (protejat la scriere) in prezent.<br /><br />O copie a fisirului de configurare o sa-ti fie downloadat (descarcat) cand dai click pe butonul de jos. Trebuie sa upload-ezi (urci) acest fisier in directorul radacina (root) al mxBB: %s <br /><br />Cand ai facut acest lucru, te rog da %sREFRESH%s la acesta ferestra si procedeaza cu urmatorul pas al instalarii.<br /><br />Multumim pentru ca ai ales MX-Publisher.<br />';
$lang['Send_file']					= 'Trimite-mi doar fisierul si eu o sa il urc manual prin FTP';
$lang['phpBB_nfnd_retry']			= 'Ne pare rau, nu putem gasi instalarea ta a phpBB. Te rog apasa butonul %sBACK%s (inapoi) al browserului tau si reincearca.';
$lang['Installation_error']			= 'O eroare s-a intamplat in timpul instalarii';
$lang['Debug_Information']			= 'INFORMAtII DEBUG';
$lang['Install_phpbb_not_found']	= 'Ne pare rau, nu gasim nici un forum phpBB instalat pe acest server.<br />Te rog instaleaza phpBB iNAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_phpbb_db_failed']	= 'Ne pare rau, nu putem conecta la baza de date (BazaDate) a phpBB.<br />Te rog verifica daca phpBB este instalat corect si merge bine iNAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_phpbb_unsupported']	= 'Din pacate, forumul phpBB instalat pe acest server nu este suportat de MX-Publisher.<br />Te rog verifica notele de lansare pentru a vedea cerintele pentru instalare.<br />\n<br />\n';
$lang['Install_noscript_warning']	= 'Ne pare rau, acesta instalare necesita JavaScript activat in browser. Sar putea sa nu mearga pe browserul tau.';
$lang['Upgrade_are_you_sure']		= 'Acesta procedura de upgrade va face modificari in baza de date. Esti sigur ca vrei sa procedezi?';
$lang['Writing_config']				= 'Scriu fisierul config.php';
$lang['Processing_schema']			= 'Procesarea Schemei SQL "%s"';
$lang['Portal_intalling']			= 'Instalarea MX-Publisher versiunea %s';
$lang['Portal_upgrading']			= 'Upgradare MX-Publisher versiunea %s';
$lang['Install_warning']			= 'A fost 1 scriere actualizata in baza de date';
$lang['Install_warnings']			= 'Au fost %d avertizari la actualizarea bazei de date';
$lang['Subscribe_mxBB_News_now']	= 'Iti recomandam sa te inscrii pentru %smxBB-News la Lista de Mail%s pt. a primi informatii despre stirile importante si anunturi de lansari.<br />&nbsp;<br />%sinscriete la mxBB-News, acum!%s';
$lang['Portal_install_done'][0]		= 'La acest punct instalarea de baza este complecta.';
$lang['Portal_install_done'][1]		= 'Te rog sterge folderele /install si /contrib iNAINTE de a proceda mai departe!!!';
$lang['Portal_install_done'][2]		= 'tine minte sa faci backup-uri cat mai des posibil ;-)';
$lang['Portal_install_done'][3]		= 'Apasa butonul de jos si foloseste utilizatorul de Administrator si parola sa te logezi in sistem.';
$lang['Portal_install_done'][4]		= 'Intra in Panoul de Control al Admin - Management, si upgradeaza TOATE modulele - una cate una!';
$lang['Portal_install_done'][5]		= 'Te rog agigurate ca verifici Configuratia Portalului si fa orice schimbari necesare.';
$lang['Go_to_admincp']				= 'Acum viziteaza Panoul de Control al Admin si upgradeaza modulele tale';
$lang['Thanks_for_choosing']		= 'Mersi pentru ca ai ales MX-Publisher.';
$lang['Critical_Error']				= 'EROARE CRITICa';
$lang['Error_loading_config']		= 'Ne pare rau, nu s-a putut lansa config.php al MX-Publisher';
$lang['Error_database_down']		= 'Ne pare rau, nu sa putut conecta la baza de date.';
$lang['PasswordMissmatch'] 			= 'Ne pare rau, nepotrivire de parole in panoul MXP Admin';

//
// That's all Folks!
// -------------------------------------------------
?>