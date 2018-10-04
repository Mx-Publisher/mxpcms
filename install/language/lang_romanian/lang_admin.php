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
setlocale(LC_ALL, 'ro');

//
// Install Process
//
$lang['Portal_paths'] 				= 'Cale Portal';
$lang['ReadOnly'] 					= '(doar pentru citire)';
$lang['Welcome_install'] 			= 'Bine aþi venit la Vrãjitorul de Installare al MX-Publisher';
$lang['Install_Instruction']		= 'Te rog complectezã detaliile cerute jos. Acest program de instalare va creea fiºierul config.php personalizat (în directorul rãdãcinã al Portalului) ºi baza de date a Portalului cu setãrile implicite. Odatã ce aceasta este gata, vei vedea un raport al tuturor paºilor fãcuþi (te rog noteazã cã MX-Publisher nu modificã baza de date a forumului phpBB în nici un fel). Ar trebui sã te logezi cu numele utilizatorului administrator ºi parola ºi sã mergi la Panoul de Control de Administratie pt. a configura portalul cu preferinþele tale. Te rog noteazã cã MX-Publisher nu va lucra de unul singur, phpBB trebuie instalat dinainte ºi configurat. Mulþumim pentru cã ai ales MX-Publisher.';
$lang['Install_Instruction_mxBB'] 	= 'Asiguraþi-vã cã completaþi formularul de mai jos cu atenþie. Dacã aveþi nevoie, consultaþi documentaþia MXP pentru asistenþã suplimentarã.';
$lang['Install_Instruction_MXP_Admin']	= 'Dacã MXP nume-admin ºi parola sunt lãsate goale, administratorul dvs. de cont va fi creat: numele de utilizator (admin), parola (admin). Modificaþi aceastã parolã URGENT!';
$lang['Install_Instruction_phpBB']	= 'Vã rugãm sã luaþi seama, chiar dacã aveþi de gând sã folosiþi MX-Publisher cu phpBB, aceastã instalare nu vã modificã baza de date phpBB în nici un fel.';
$lang['Upgrade_Instruction']		= 'MX-Publisher este deja instalat. Te rog fã backuri la baza ta de date acum !<br /><br />Urmãtoarea etapã va modifica structura bazei de date (te rog noteazã cã MX-Publisher nu modificã baza de date a forumului phpBB în nici un fel). Dacã totuºi din oarecare motiv acestã procedurã de upgradare eºuiazã, Nu ar exista nici o cale de întoarcere la statutul curect. Te rog fã backupuri ale bazei de date ÎNAINTE de a proceda !<br /><br />Odatã ce aceasta este gata, dã click pe butonul de jos pentru a începe procedura de upgradare.';
$lang['Install_moreinfo']			= '%sNote de Lansare%s | %sPachet Bun Venit%s | %sFAQ Online%s | %sForumuri de Suport%s | %sTermeni De Utilizare%s';
$lang['Install_settings']			= 'Setãri Instalare';
$lang['Choose_lang_explain']		= 'Te rog foloseºte formularul de jos pentru a selecta limba pe care vrei so foloseºti în procesul de instalare.';
$lang['Choose_lang']				= 'Alege Limba';
$lang['Language']					= 'Limba';
$lang['Phpbb_only'] 				= '[phpBBX]';
$lang['Mxbb_only'] 					= '[Internal]';
$lang['Portal_backend'] 			= 'Nume Backend';
$lang['Session_backend'] 			= 'Users & Sessions';
$lang['Session_backend_explain'] 	= 'The MX-Publisher-IWizard has detected installed phpBB boards on this server. <br />Select here if you plan to use MX-Publisher with phpBB users and sessions. <br />If you are unsure (or if you want to install MX-Publisher without phpBB), select \'Internal\' setup. <br />You may update this setting later in the MX-Publisher adminCP';
$lang['Phpbb_path']					= 'phpBB cale relativã';
$lang['Phpbb_path_explain'] 		= 'Cale relativã la phpBB, ex. phpBB/ or ../phpBB/<br />Noteazã slaºurile "/", ele sunt importante!';
$lang['Phpbb_url'] 					= 'URL phpBB Complet';
$lang['Portal_backend'] 			= 'Portal Backend';
$lang['Phpbb_url_explain']			= 'Exemplu URL phpBB Complect, ex. <br />http://www.exemplu.ro/phpBB/';
$lang['Portal_url'] 				= 'URL Complet CMS';
$lang['Portal_url_explain'] 		= 'URL Complet CMS, ex. <br />http://www.exemplu.ro/';
$lang['Database_settings']			= 'Setari Bazã de Date';
$lang['dbms']						= 'Tip Bazã de Date';
$lang['DB_Host']					= 'BazãDate Server NumeHost/DSN';
$lang['DB_Name']					= 'Numele BazãDate';
$lang['DB_Username']				= 'NumeUser Bazã de Date';
$lang['MXP_Adminname'] 				= 'MXP Admin Username';
$lang['DB_Password']				= 'Parola BazãDate';
$lang['MXP_Password'] 				= 'MXP Admin Password';
$lang['MXP_Password2'] 				= 'MXP Admin Password (repeat)';
$lang['Table_Prefix']				= 'phpBB Prefix în DB';
$lang['MX_Table_Prefix']			= 'MX-Publisher Prefix în DB';
$lang['Start_Install']				= 'Porneºte Instalrea mxBB';
$lang['Start_Upgrade']				= 'Da, Eu am facut deja backup ºi vreau sã-mi upgradez MX-Publisher acum.';
$lang['Portal_intalled']			= 'MX-Publisher a fost instalat !';
$lang['Portal_upgraded']			= 'MX-Publisher a fost upgradat !';
$lang['Unwriteable_config']			= 'Fiºierul de configurare mxBB (config.php) este ne-write-abil (protejat la scriere) în prezent.<br /><br />O copie a fiºirului de configurare o sa-þi fie downloadat (descarcat) când dai click pe butonul de jos. Trebuie sã upload-ezi (urci) acest fiºier în directorul rãdãcinã (root) al mxBB: %s <br /><br />Când ai facut acest lucru, te rog dã %sREFRESH%s la acestã ferestrã ºi procedeazã cu urmãtorul pas al instalãrii.<br /><br />Mulþumim pentru cã ai ales MX-Publisher.<br />';
$lang['Send_file']					= 'Trimite-mi doar fiºierul ºi eu o sa il urc manual prin FTP';
$lang['phpBB_nfnd_retry']			= 'Ne pare rãu, nu putem gasi instalarea ta a phpBB. Te rog apasa butonul %sBACK%s (Înapoi) al browserului tau ºi reîncearcã.';
$lang['Installation_error']			= 'O eroare s-a întâmplat în timpul instalãrii';
$lang['Debug_Information']			= 'INFORMAÞII DEBUG';
$lang['Install_phpbb_not_found']	= 'Ne pare rãu, nu gasim nici un forum phpBB instalat pe acest server.<br />Te rog instaleaza phpBB ÎNAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_phpbb_db_failed']	= 'Ne pare rãu, nu putem conecta la baza de date (BazãDate) a phpBB.<br />Te rog verificã dacã phpBB este instalat corect ºi merge bine ÎNAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_phpbb_unsupported']	= 'Din pãcate, forumul phpBB instalat pe acest server nu este suportat de MX-Publisher.<br />Te rog verificã notele de lansare pentru a vedea cerinþele pentru instalare.<br />\n<br />\n';
$lang['Install_noscript_warning']	= 'Ne pare rãu, acestã instalare necesitã JavaScript activat în browser. Sar putea sã nu meargã pe browserul tãu.';
$lang['Upgrade_are_you_sure']		= 'Acestã procedurã de upgrade va face modificãri în baza de date. Eºti sigur cã vrei sã procedezi?';
$lang['Writing_config']				= 'Scriu fiºierul config.php';
$lang['Processing_schema']			= 'Procesarea Schemei SQL "%s"';
$lang['Portal_intalling']			= 'Instalarea MX-Publisher versiunea %s';
$lang['Portal_upgrading']			= 'Upgradare MX-Publisher versiunea %s';
$lang['Install_warning']			= 'A fost 1 scriere actualizatã în baza de date';
$lang['Install_warnings']			= 'Au fost %d avertizari la actualizarea bazei de date';
$lang['Subscribe_mxBB_News_now']	= 'Iþi recomandãm sã te înscrii pentru %smxBB-News la Lista de Mail%s pt. a primi informaþii despre ºtirile importante ºi anunþuri de lansãri.<br />&nbsp;<br />%sÎnscriete la mxBB-News, acum!%s';
$lang['Portal_install_done'][0]		= 'La acest punct instalarea de bazã este complectã.';
$lang['Portal_install_done'][1]		= 'Te rog ºterge folderele /install ºi /contrib ÎNAINTE de a proceda mai departe!!!';
$lang['Portal_install_done'][2]		= 'Þine minte sã faci backup-uri cât mai des posibil ;-)';
$lang['Portal_install_done'][3]		= 'Apasã butonul de jos ºi foloseºte utilizatorul de Administrator ºi parola sa te logezi în sistem.';
$lang['Portal_install_done'][4]		= 'Intrã în Panoul de Control al Admin - Management, ºi upgradeazã TOATE modulele - una cate una!';
$lang['Portal_install_done'][5]		= 'Te rog agigurãte cã verifici Configuraþia Portalului ºi fã orice schimbãri necesare.';
$lang['Go_to_admincp']				= 'Acum viziteazã Panoul de Control al Admin ºi upgradeazã modulele tale';
$lang['Thanks_for_choosing']		= 'Mersi pentru cã ai ales MX-Publisher.';
$lang['Critical_Error']				= 'EROARE CRITICÃ';
$lang['Error_loading_config']		= 'Ne pare rãu, nu s-a putut lansa config.php al MX-Publisher';
$lang['Error_database_down']		= 'Ne pare rãu, nu sa putut conecta la baza de date.';
$lang['PasswordMissmatch'] 			= 'Ne pare rãu, nepotrivire de parole în panoul MXP Admin';

//
// That's all Folks!
// -------------------------------------------------
?>