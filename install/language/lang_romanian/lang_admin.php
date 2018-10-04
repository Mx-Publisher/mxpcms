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
$lang['Welcome_install'] 			= 'Bine a�i venit la Vr�jitorul de Installare al MX-Publisher';
$lang['Install_Instruction']		= 'Te rog complectez� detaliile cerute jos. Acest program de instalare va creea fi�ierul config.php personalizat (�n directorul r�d�cin� al Portalului) �i baza de date a Portalului cu set�rile implicite. Odat� ce aceasta este gata, vei vedea un raport al tuturor pa�ilor f�cu�i (te rog noteaz� c� MX-Publisher nu modific� baza de date a forumului phpBB �n nici un fel). Ar trebui s� te logezi cu numele utilizatorului administrator �i parola �i s� mergi la Panoul de Control de Administratie pt. a configura portalul cu preferin�ele tale. Te rog noteaz� c� MX-Publisher nu va lucra de unul singur, phpBB trebuie instalat dinainte �i configurat. Mul�umim pentru c� ai ales MX-Publisher.';
$lang['Install_Instruction_mxBB'] 	= 'Asigura�i-v� c� completa�i formularul de mai jos cu aten�ie. Dac� ave�i nevoie, consulta�i documenta�ia MXP pentru asisten�� suplimentar�.';
$lang['Install_Instruction_MXP_Admin']	= 'Dac� MXP nume-admin �i parola sunt l�sate goale, administratorul dvs. de cont va fi creat: numele de utilizator (admin), parola (admin). Modifica�i aceast� parol� URGENT!';
$lang['Install_Instruction_phpBB']	= 'V� rug�m s� lua�i seama, chiar dac� ave�i de g�nd s� folosi�i MX-Publisher cu phpBB, aceast� instalare nu v� modific� baza de date phpBB �n nici un fel.';
$lang['Upgrade_Instruction']		= 'MX-Publisher este deja instalat. Te rog f� backuri la baza ta de date acum !<br /><br />Urm�toarea etap� va modifica structura bazei de date (te rog noteaz� c� MX-Publisher nu modific� baza de date a forumului phpBB �n nici un fel). Dac� totu�i din oarecare motiv acest� procedur� de upgradare e�uiaz�, Nu ar exista nici o cale de �ntoarcere la statutul curect. Te rog f� backupuri ale bazei de date �NAINTE de a proceda !<br /><br />Odat� ce aceasta este gata, d� click pe butonul de jos pentru a �ncepe procedura de upgradare.';
$lang['Install_moreinfo']			= '%sNote de Lansare%s | %sPachet Bun Venit%s | %sFAQ Online%s | %sForumuri de Suport%s | %sTermeni De Utilizare%s';
$lang['Install_settings']			= 'Set�ri Instalare';
$lang['Choose_lang_explain']		= 'Te rog folose�te formularul de jos pentru a selecta limba pe care vrei so folose�ti �n procesul de instalare.';
$lang['Choose_lang']				= 'Alege Limba';
$lang['Language']					= 'Limba';
$lang['Phpbb_only'] 				= '[phpBBX]';
$lang['Mxbb_only'] 					= '[Internal]';
$lang['Portal_backend'] 			= 'Nume Backend';
$lang['Session_backend'] 			= 'Users & Sessions';
$lang['Session_backend_explain'] 	= 'The MX-Publisher-IWizard has detected installed phpBB boards on this server. <br />Select here if you plan to use MX-Publisher with phpBB users and sessions. <br />If you are unsure (or if you want to install MX-Publisher without phpBB), select \'Internal\' setup. <br />You may update this setting later in the MX-Publisher adminCP';
$lang['Phpbb_path']					= 'phpBB cale relativ�';
$lang['Phpbb_path_explain'] 		= 'Cale relativ� la phpBB, ex. phpBB/ or ../phpBB/<br />Noteaz� sla�urile "/", ele sunt importante!';
$lang['Phpbb_url'] 					= 'URL phpBB Complet';
$lang['Portal_backend'] 			= 'Portal Backend';
$lang['Phpbb_url_explain']			= 'Exemplu URL phpBB Complect, ex. <br />http://www.exemplu.ro/phpBB/';
$lang['Portal_url'] 				= 'URL Complet CMS';
$lang['Portal_url_explain'] 		= 'URL Complet CMS, ex. <br />http://www.exemplu.ro/';
$lang['Database_settings']			= 'Setari Baz� de Date';
$lang['dbms']						= 'Tip Baz� de Date';
$lang['DB_Host']					= 'Baz�Date Server NumeHost/DSN';
$lang['DB_Name']					= 'Numele Baz�Date';
$lang['DB_Username']				= 'NumeUser Baz� de Date';
$lang['MXP_Adminname'] 				= 'MXP Admin Username';
$lang['DB_Password']				= 'Parola Baz�Date';
$lang['MXP_Password'] 				= 'MXP Admin Password';
$lang['MXP_Password2'] 				= 'MXP Admin Password (repeat)';
$lang['Table_Prefix']				= 'phpBB Prefix �n DB';
$lang['MX_Table_Prefix']			= 'MX-Publisher Prefix �n DB';
$lang['Start_Install']				= 'Porne�te Instalrea mxBB';
$lang['Start_Upgrade']				= 'Da, Eu am facut deja backup �i vreau s�-mi upgradez MX-Publisher acum.';
$lang['Portal_intalled']			= 'MX-Publisher a fost instalat !';
$lang['Portal_upgraded']			= 'MX-Publisher a fost upgradat !';
$lang['Unwriteable_config']			= 'Fi�ierul de configurare mxBB (config.php) este ne-write-abil (protejat la scriere) �n prezent.<br /><br />O copie a fi�irului de configurare o sa-�i fie downloadat (descarcat) c�nd dai click pe butonul de jos. Trebuie s� upload-ezi (urci) acest fi�ier �n directorul r�d�cin� (root) al mxBB: %s <br /><br />C�nd ai facut acest lucru, te rog d� %sREFRESH%s la acest� ferestr� �i procedeaz� cu urm�torul pas al instal�rii.<br /><br />Mul�umim pentru c� ai ales MX-Publisher.<br />';
$lang['Send_file']					= 'Trimite-mi doar fi�ierul �i eu o sa il urc manual prin FTP';
$lang['phpBB_nfnd_retry']			= 'Ne pare r�u, nu putem gasi instalarea ta a phpBB. Te rog apasa butonul %sBACK%s (�napoi) al browserului tau �i re�ncearc�.';
$lang['Installation_error']			= 'O eroare s-a �nt�mplat �n timpul instal�rii';
$lang['Debug_Information']			= 'INFORMA�II DEBUG';
$lang['Install_phpbb_not_found']	= 'Ne pare r�u, nu gasim nici un forum phpBB instalat pe acest server.<br />Te rog instaleaza phpBB �NAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_phpbb_db_failed']	= 'Ne pare r�u, nu putem conecta la baza de date (Baz�Date) a phpBB.<br />Te rog verific� dac� phpBB este instalat corect �i merge bine �NAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_phpbb_unsupported']	= 'Din p�cate, forumul phpBB instalat pe acest server nu este suportat de MX-Publisher.<br />Te rog verific� notele de lansare pentru a vedea cerin�ele pentru instalare.<br />\n<br />\n';
$lang['Install_noscript_warning']	= 'Ne pare r�u, acest� instalare necesit� JavaScript activat �n browser. Sar putea s� nu mearg� pe browserul t�u.';
$lang['Upgrade_are_you_sure']		= 'Acest� procedur� de upgrade va face modific�ri �n baza de date. E�ti sigur c� vrei s� procedezi?';
$lang['Writing_config']				= 'Scriu fi�ierul config.php';
$lang['Processing_schema']			= 'Procesarea Schemei SQL "%s"';
$lang['Portal_intalling']			= 'Instalarea MX-Publisher versiunea %s';
$lang['Portal_upgrading']			= 'Upgradare MX-Publisher versiunea %s';
$lang['Install_warning']			= 'A fost 1 scriere actualizat� �n baza de date';
$lang['Install_warnings']			= 'Au fost %d avertizari la actualizarea bazei de date';
$lang['Subscribe_mxBB_News_now']	= 'I�i recomand�m s� te �nscrii pentru %smxBB-News la Lista de Mail%s pt. a primi informa�ii despre �tirile importante �i anun�uri de lans�ri.<br />&nbsp;<br />%s�nscriete la mxBB-News, acum!%s';
$lang['Portal_install_done'][0]		= 'La acest punct instalarea de baz� este complect�.';
$lang['Portal_install_done'][1]		= 'Te rog �terge folderele /install �i /contrib �NAINTE de a proceda mai departe!!!';
$lang['Portal_install_done'][2]		= '�ine minte s� faci backup-uri c�t mai des posibil ;-)';
$lang['Portal_install_done'][3]		= 'Apas� butonul de jos �i folose�te utilizatorul de Administrator �i parola sa te logezi �n sistem.';
$lang['Portal_install_done'][4]		= 'Intr� �n Panoul de Control al Admin - Management, �i upgradeaz� TOATE modulele - una cate una!';
$lang['Portal_install_done'][5]		= 'Te rog agigur�te c� verifici Configura�ia Portalului �i f� orice schimb�ri necesare.';
$lang['Go_to_admincp']				= 'Acum viziteaz� Panoul de Control al Admin �i upgradeaz� modulele tale';
$lang['Thanks_for_choosing']		= 'Mersi pentru c� ai ales MX-Publisher.';
$lang['Critical_Error']				= 'EROARE CRITIC�';
$lang['Error_loading_config']		= 'Ne pare r�u, nu s-a putut lansa config.php al MX-Publisher';
$lang['Error_database_down']		= 'Ne pare r�u, nu sa putut conecta la baza de date.';
$lang['PasswordMissmatch'] 			= 'Ne pare r�u, nepotrivire de parole �n panoul MXP Admin';

//
// That's all Folks!
// -------------------------------------------------
?>