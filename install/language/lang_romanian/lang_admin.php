<?php
/**
*
* @package MX-Publisher Core
* @version $Id: lang_admin.php,v 1.5 2014/05/13 17:59:43 orynider Exp $
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
$lang['Welcome_install'] 			= 'Bine aţi venit la Vrăjitorul de Installare al MX-Publisher';
$lang['Install_Instruction']		= 'Te rog complecteză detaliile cerute jos. Acest program de instalare va creea fişierul config.php personalizat (în directorul rădăcină al Portalului) şi baza de date a Portalului cu setările implicite. Odată ce aceasta este gata, vei vedea un raport al tuturor paşilor făcuţi (te rog notează că MX-Publisher nu modifică baza de date a forumului phpBB în nici un fel). Ar trebui să te logezi cu numele utilizatorului administrator şi parola şi să mergi la Panoul de Control de Administratie pt. a configura portalul cu preferinţele tale. Te rog notează că MX-Publisher nu va lucra de unul singur, phpBB trebuie instalat dinainte şi configurat. Mulţumim pentru că ai ales MX-Publisher.';
$lang['Install_Instruction_mxBB'] 	= 'Asiguraţi-vă că completaţi formularul de mai jos cu atenţie. Dacă aveţi nevoie, consultaţi documentaţia MXP pentru asistenţă suplimentară.';
$lang['Install_Instruction_MXP_Admin']	= 'Dacă MXP nume-admin şi parola sunt lăsate goale, administratorul dvs. de cont va fi creat: numele de utilizator (admin), parola (admin). Modificaţi această parolă URGENT!';
$lang['Install_Instruction_phpBB']	= 'Vă rugăm să luaţi seama, chiar dacă aveţi de gând să folosiţi MX-Publisher cu phpBB, această instalare nu vă modifică baza de date phpBB în nici un fel.';
$lang['Install_Instruction_SMF']	= 'Vă rugăm să luaţi seama, chiar dacă aveţi de gând să folosiţi MX-Publisher cu SMF, această instalare nu vă modifică baza de date SMF în nici un fel.';
$lang['Install_Instruction_MyBB']	= 'Vă rugăm să luaţi seama, chiar dacă aveţi de gând să folosiţi MX-Publisher cu MyBB, această instalare nu vă modifică baza de date MyBB în nici un fel.';
$lang['Upgrade_Instruction']		= 'MX-Publisher este deja instalat. Te rog fă backuri la baza ta de date acum !<br /><br />Următoarea etapă va modifica structura bazei de date (te rog notează că MX-Publisher nu modifică baza de date a forumului phpBB în nici un fel). Dacă totuşi din oarecare motiv acestă procedură de upgradare eşuiază, Nu ar exista nici o cale de întoarcere la statutul curect. Te rog fă backupuri ale bazei de date ÎNAINTE de a proceda !<br /><br />Odată ce aceasta este gata, dă click pe butonul de jos pentru a începe procedura de upgradare.';
$lang['Install_moreinfo']			= '%sNote de Lansare%s | %sPachet Bun Venit%s | %sFAQ Online%s | %sForumuri de Suport%s | %sTermeni De Utilizare%s';
$lang['Install_settings']			= 'Setări Instalare';
$lang['Choose_lang_explain']		= 'Te rog foloseşte formularul de jos pentru a selecta limba pe care vrei so foloseşti în procesul de instalare.';
$lang['Choose_lang']				= 'Alege Limba';
$lang['Language']					= 'Limba';
$lang['Phpbb_only'] 				= '[phpBBX]';
$lang['Mxbb_only'] 					= '[Internal]';
$lang['Portal_backend'] 			= 'Nume Backend';
$lang['Session_backend'] 			= 'Users & Sessions';
$lang['Session_backend_explain'] 	= 'The MX-Publisher-IWizard has detected installed forum boards on this server. <br />Select here if you plan to use MX-Publisher with forums users and sessions. <br />If you are unsure (or if you want to install MX-Publisher without phpBB), select \'Internal\' setup. <br />You may update this setting later in the MX-Publisher adminCP';
$lang['Phpbb_path']					= 'phpBB cale relativă';
$lang['Phpbb_path_explain'] 		= 'Cale relativă la phpBB, ex. phpBB/ or ../phpBB/<br />Notează slaşurile "/", ele sunt importante!';
$lang['Phpbb_url'] 					= 'URL phpBB Complet';
$lang['Portal_backend'] 			= 'Portal Backend';
$lang['Phpbb_url_explain']			= 'Exemplu URL phpBB Complect, ex. <br />http://www.exemplu.ro/phpBB/';
$lang['Portal_url'] 				= 'URL Complet CMS';
$lang['Portal_url_explain'] 		= 'URL Complet CMS, ex. <br />http://www.exemplu.ro/';
$lang['Database_settings']			= 'Setari Bază de Date';
$lang['dbms']						= 'Tip Bază de Date';
$lang['DB_Host']					= 'BazăDate Server NumeHost/DSN';
$lang['DB_Name']					= 'Numele BazăDate';
$lang['DB_Username']				= 'NumeUser Bază de Date';
$lang['DB_Character_Set'] 			= 'Setul de Caractere Database';
$lang['DB_Character_Set_explain'] 	= 'Setul de Caractere ex. utf8';
$lang['MXP_Adminname'] 				= 'MXP Admin Username';
$lang['DB_Password']				= 'Parola BazăDate';
$lang['MXP_Password'] 				= 'MXP Admin Password';
$lang['MXP_Password2'] 				= 'MXP Admin Password (repeat)';
$lang['Table_Prefix']				= 'phpBB Prefix în DB';
$lang['MX_Table_Prefix']			= 'MX-Publisher Prefix în DB';
$lang['Start_Install']				= 'Porneşte Instalrea mxBB';
$lang['Start_Upgrade']				= 'Da, Eu am facut deja backup şi vreau să-mi upgradez MX-Publisher acum.';
$lang['Portal_intalled']			= 'MX-Publisher a fost instalat !';
$lang['Portal_upgraded']			= 'MX-Publisher a fost upgradat !';
$lang['Unwriteable_config']			= 'Fişierul de configurare mxBB (config.php) este ne-write-abil (protejat la scriere) în prezent.<br /><br />O copie a fişirului de configurare o sa-ţi fie downloadat (descarcat) când dai click pe butonul de jos. Trebuie să upload-ezi (urci) acest fişier în directorul rădăcină (root) al mxBB: %s <br /><br />Când ai facut acest lucru, te rog dă %sREFRESH%s la acestă ferestră şi procedează cu următorul pas al instalării.<br /><br />Mulţumim pentru că ai ales MX-Publisher.<br />';
$lang['Send_file']					= 'Trimite-mi doar fişierul şi eu o sa il urc manual prin FTP';
$lang['phpBB_nfnd_retry']			= 'Ne pare rău, nu putem gasi instalarea ta a phpBB. Te rog apasa butonul %sBACK%s (Înapoi) al browserului tau şi reîncearcă.';
$lang['Installation_error']			= 'O eroare s-a întâmplat în timpul instalării';
$lang['Debug_Information']			= 'INFORMAŢII DEBUG';
$lang['Install_phpbb_not_found']	= 'Ne pare rău, nu gasim nici un forum phpBB instalat pe acest server.<br />Te rog instaleaza phpBB ÎNAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_phpbb_db_failed']	= 'Ne pare rău, nu putem conecta la baza de date a phpBB.<br />Te rog verifică dacă phpBB este instalat corect şi merge bine ÎNAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_phpbb_unsupported']	= 'Din păcate, forumul phpBB instalat pe acest server nu este suportat de MX-Publisher.<br />Te rog verifică notele de lansare pentru a vedea cerinţele pentru instalare.<br />\n<br />\n';
$lang['Install_smf_not_found']		= 'Ne pare rău, nu gasim nici un forum SMF instalat pe acest server.<br />Te rog instaleaza SMF ÎNAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_smf_db_failed']		= 'Ne pare rău, nu putem conecta la baza de date a SMF.<br />Te rog verifică dacă phpBB este instalat corect şi merge bine ÎNAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_smf_unsupported']	= 'Din păcate, forumul SMF instalat pe acest server nu este suportat de MX-Publisher.<br />Te rog verifică notele de lansare pentru a vedea cerinţele pentru instalare.<br />\n<br />\n';
$lang['Install_mybb_not_found']		= 'Ne pare rău, nu gasim nici un forum SMF instalat pe acest server.<br />Te rog instaleaza phpBB ÎNAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_mybb_db_failed']		= 'Ne pare rău, nu putem conecta la baza de date a myBB.<br />Te rog verifică dacă myBB este instalat corect şi merge bine ÎNAINTE de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_mybb_unsupported']	= 'Din păcate, forumul myBB instalat pe acest server nu este suportat de MX-Publisher.<br />Te rog verifică notele de lansare pentru a vedea cerinţele pentru instalare.<br />\n<br />\n';
$lang['Install_forums_not_found']	= 'Ne pare rău, nu gasim nici un forum instalat pe acest server.<br />Te rog instaleaza un forum suportat de acest instalator de a instala MX-Publisher.<br />\n<br />\n';
$lang['Install_forums_unsupported']	= 'Din păcate, nici un forum suportat de MX-Publisher nu este instalat pe acest server.<br />Te rog verifică notele de lansare pentru a vedea cerinţele pentru instalare.<br />\n<br />\n';
$lang['Install_noscript_warning']	= 'Ne pare rău, acestă instalare necesită JavaScript activat în browser. Sar putea să nu meargă pe browserul tău.';
$lang['Upgrade_are_you_sure']		= 'Acestă procedură de upgrade va face modificări în baza de date. Eşti sigur că vrei să procedezi?';
$lang['Writing_config']				= 'Scriu fişierul config.php';
$lang['Processing_schema']			= 'Procesarea Schemei SQL "%s"';
$lang['Portal_intalling']			= 'Instalarea MX-Publisher versiunea %s';
$lang['Portal_upgrading']			= 'Upgradare MX-Publisher versiunea %s';
$lang['Install_warning']			= 'A fost 1 scriere actualizată în baza de date';
$lang['Install_warnings']			= 'Au fost %d avertizari la actualizarea bazei de date';
$lang['Subscribe_mxBB_News_now']	= 'Iţi recomandăm să te înscrii pentru %smxBB-News la Lista de Mail%s pt. a primi informaţii despre ştirile importante şi anunţuri de lansări.<br />&nbsp;<br />%sÎnscriete la mxBB-News, acum!%s';
$lang['Portal_install_done'][0]		= 'La acest punct instalarea de bază este complectă.';
$lang['Portal_install_done'][1]		= 'Te rog şterge folderele /install şi /contrib ÎNAINTE de a proceda mai departe!!!';
$lang['Portal_install_done'][2]		= 'Ţine minte să faci backup-uri cât mai des posibil ;-)';
$lang['Portal_install_done'][3]		= 'Apasă butonul de jos şi foloseşte utilizatorul de Administrator şi parola sa te logezi în sistem.';
$lang['Portal_install_done'][4]		= 'Intră în Panoul de Control al Admin - Management, şi upgradează TOATE modulele - una cate una!';
$lang['Portal_install_done'][5]		= 'Te rog agigurăte că verifici Configuraţia Portalului şi fă orice schimbări necesare.';
$lang['Go_to_admincp']				= 'Acum vizitează Panoul de Control al Admin şi upgradează modulele tale';
$lang['Thanks_for_choosing']		= 'Mersi pentru că ai ales MX-Publisher.';
$lang['Critical_Error']				= 'EROARE CRITICĂ';
$lang['Error_loading_config']		= 'Ne pare rău, nu s-a putut lansa config.php al MX-Publisher';
$lang['Error_database_down']		= 'Ne pare rău, nu sa putut conecta la baza de date.';
$lang['PasswordMissmatch'] 			= 'Ne pare rău, nepotrivire de parole în panoul MXP Admin';
$lang['Cache_generate'] 			= 'Your cache files have been generated.';
//
// That's all Folks!
// -------------------------------------------------
?>