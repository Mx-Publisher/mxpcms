<?php
/**
*
* @package MXP Portal Core
* @version $Id: lang_admin.php,v 1.5 2013/06/28 17:08:52 orynider Exp $
* @copyright (c) 2002-2006 MXP Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

/* Editor Settings: Please set Tabsize to 4 ;-) */ 

/*  The format of this file is:  ---> $lang['message'] = 'text';
/*  Specify your language character encoding... [optional] */ 
setlocale(LC_ALL, "ro");


$lang['ENCODING'] = 'Windows-1250';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'st�nga';
$lang['RIGHT'] = 'dreapta';
$lang['DATE_FORMAT'] =  'd/M/Y'; // This should be changed to the default date format for your language, php date() format

$lang['Mx-Publisher_adminCP']		= 'Mx-Publisher Administra�ie';	
$lang['Portal_Desc'] 				= 'A little text to describe your website.';

/* Left AdminCP Panel*/
$lang['1_General_admin']		= 'General';
$lang['1_1_Management']			= 'Configura�ie';
$lang['1_2_WordCensors'] 		= 'Cenzori de cuvinte';

$lang['2_CP']					= 'Management';
$lang['2_1_Modules']			= 'Instalare Module<br /><hr>';
$lang['2_2_ModuleCP']			= 'Panou de Control Module';
$lang['2_3_BlockCP']			= 'Panou de Control Bloc';
$lang['2_4_PageCP']				= 'Panou de Control Pagin�';

$lang['3_CP'] 					= 'Stiluri';
$lang['2_1_new'] 				= 'Adaug� nou';
$lang['2_2_manage'] 			= 'Configureaz�';
$lang['2_3_smilies'] 			= 'Emoticoane';

$lang['4_Panel_system']			= 'Unelte Sistem';
$lang['4_1_Cache']				= 'Regenereaz� Cache-ul';
$lang['4_1_Integrity']			= 'Verificator Integritate';
$lang['4_1_Meta']				= 'Taguri META';
$lang['4_1_PHPinfo']			= 'phpInfo()';
$lang['4_2_Translate'] 			= 'Panou de Control Traduceri';

/* Index*/
$lang['Welcome_Mx-Publisher'] 				= 'Bine a�i venit la panoul de control al MXP CMS';
$lang['Admin_intro_Mx-Publisher'] 			= 'V� mul�umim pentru a�i ales Mx-Publisher ca solu�ie pentru portalul/cms-ul dumneavoastr� �i phpBB ca solu�ie pentru forumul dumneavoastr�. Acest ecran v� ofer� o privire de ansamblu a diverselor statistici ale site-ului dumneavoastr�. Pute�i reveni la aceast� pagin� folosind leg�tura <span style="text-decoration: underline;">Pagina de start a administratorului</span> din panel-ul st�ng. Pentru a reveni la pagina de start a forumului dumneavoastr�, ap�sa�i pe logo-ul phpBB-ului aflat, de asemenea, �n panel-ul st�ng. Celelalte leg�turi din partea st�ng� v� permit s� controla�i orice aspect al forumului, fiecare ecran va avea instruc�iuni care dau explica�ii despre cum se folosesc uneltele.';

/* General*/
$lang['Yes']						= 'Da';
$lang['No']							= 'Nu';
$lang['No_modules']					= 'Nici un Modul instalat';
$lang['No_functions']				= 'Acest modul nu are func�ii bloc';
$lang['No_parameters']				= 'Aceast� func�ie nu are parametri';
$lang['No_blocks']					= 'Nici un bloc nu a fost creat pentru aceasta func�ie';
$lang['No_pages']					= 'Nici o pagin� nu a fost creat�';
$lang['No_settings']				= 'Nu mai exist� setari pentru acest bloc';
$lang['Quick_nav']					= 'Navigare Quick-Rapid�';
$lang['Include_all_modules']		= 'Listeaz� toate modulele';
$lang['Include_block_quickedit']	= 'Include Blocul Panoul Quickedit';
$lang['Include_block_private']		= 'Include Blocul Panoul Autentificare Prv';
$lang['Include_all_pages']			= 'Liseaz� toate paginile';
$lang['View']						= 'Vizualizez�';
$lang['Edit']						= 'Editeaz�';
$lang['Delete']						= '�terge';
$lang['Settings']					= 'Set�ri';
$lang['Move_up']					= 'Mut� �n sus';
$lang['Move_down']					= 'Mut� �n jos';
$lang['Resync']						= 'Resinc';
$lang['Update']						= 'Actualizare';
$lang['Permissions']				= 'Permisii';
$lang['Permissions_std']			= 'Permisii Standard';
$lang['Permissions_adv']			= 'Permisii Avansate';
$lang['return_to_page']				= '�napoi la Pagina Portalului';
$lang['Use_default'] 				= 'Folose�te set�ri implicite';

$lang['AdminCP_status']				= '<b>Raport Progres</b>';
$lang['AdminCP_action']				= '<b>Ac�iune DB</b>';
$lang['Invalid_action']				= 'Eroare';
$lang['was_installed']             	= 'a fost instalat';
$lang['was_uninstalled']           	= 'a fost dezinstalat';
$lang['was_upgraded']              	= 'a fost upgradat';
$lang['was_exported']               = 'a fost exportat';
$lang['was_deleted']               	= 'a fost �ters';
$lang['was_removed']               	= 'a fost scos';
$lang['was_inserted']              	= 'a fost inserat';
$lang['was_updated']               	= 'a fost actualizat';
$lang['was_added']                 	= 'a fost ad�ugat';
$lang['was_moved']                 	= 'a fost mutat';
$lang['was_synced']                	= 'a fost sincronizat';

$lang['error_no_field']				= 'Este un c�mp lips�. Te rog complectez� toate c�mpurile necesare...';

/* Configuration*/
$lang['Portal_admin']						= 'Administra�ia Portalului';
$lang['Portal_admin_explain']				= 'Foloseste acest form pt. a customiza portalul tau';
$lang['Portal_General_Config']				= 'Configura�ie Portal';
$lang['Portal_General_Config_explain'] 		= 'Use this form to manage the main settings of your MX-Publisher site.';
$lang['Portal_General_settings']			= 'Setari Generale';
$lang['Portal_Style_settings'] 				= 'Setari Stiluri';
$lang['Portal_General_config_info']			= 'Info General Configurare Portal ';
$lang['Portal_General_config_info_explain'] = 'Postat� informa�ii instalare din fi�ierul config.php (nu e nevoie de editare)';
$lang['Portal_Name']					= 'Nume Portal:';
$lang['Portal_Description']				= 'Descriptie Portal:';
$lang['Portal_PHPBB_Url']				= 'URL pt. instarea ta de forum phpBB:';
$lang['Portal_Url']						= 'URL pentru Mx-Publisher:';
$lang['Portal_Config_updated']			= 'Configura�ia Portalului Actualizat� cu Succes';
$lang['Click_return_portal_config']		= 'Click %sAici%s pentru a te intoarce la Configurarea Portalului';
$lang['PHPBB_info']						= 'Informatii phpBB';
$lang['PHPBB_version']					= 'Versiunea phpBB:';
$lang['PHPBB_script_path']				= 'phpBB Cale Script:';
$lang['PHPBB_server_name']				= 'phpBB Domeniu (nume_server):';
$lang['MX_Portal']						= 'Mx-Publisher';
$lang['MX_Modules']						= 'MXP-Module';
$lang['Phpbb']							= 'phpBB';
$lang['Top_phpbb_links']				= 'phpBB Stats �n Header (valoare impicit�)<br /> - linkuri la postari noi/necitite etc';
$lang['Portal_version']					= 'Versiune Mx-Publisher:';
$lang['Mx_use_cache']					= 'Folose�te MXP Bloc Cache';
$lang['Mx_use_cache_explain']			= 'Datele din Bloc este �n fi�iere individuale cache/bloc_*.xml. Fi�ierele Bloc cache sunt create c�nd Blocurile sunt editate.';
$lang['Mx_mod_rewrite'] 				= 'Foloseste mod_rewrite';
$lang['Mx_mod_rewrite_explain'] 		= 'Daca e�ti pe server Apache, �i ai mod_rewrite activat, po�i rescrie url-urile ca \'page=x\' cu alternative mai intuitive. Cite�te pentru mai multe documenta�ia pentru modulul mx_mod_rewrite.';

$lang['Portal_Overall_header'] 					= 'Fi�ier Overall Header (valoare impicit�)';
$lang['Portal_Overall_header_explain'] 			= '- Aceasta este valoarea implicit� a fi�ierului overall_header, e.g. overall_header.tpl.';

$lang['Portal_Overall_footer'] 					= 'Fi�ier Overall Footer (valoare impicit�)';
$lang['Portal_Overall_footer_explain'] 			= '- Aceasta este valoarea implicit� a fi�ierului overall_footer, e.g. overall_footer.tpl.';

$lang['Portal_Main_layout'] 					= 'Fi�ier Main Layout (valoare impicit�)';
$lang['Portal_Main_layout_explain'] 			= '- This is the default template main_layout file, e.g. mx_main_layout.tpl.';
$lang['Portal_Navigation_block'] 				= 'Overall Header Navigation Block (valoare impicit�)';
$lang['Portal_Navigation_block_explain'] 		= '- This is the default template overall_header navigation block.';

$lang['Default_style'] = 'Style Pagini Portal (implicit)';
$lang['Default_admin_style'] = 'Style AdminCP';
$lang['Select_page_style'] = 'Selecteaz� (ori folose�te implicit)';
$lang['Override_style'] = 'Supracrie stilul utilizatorului';
$lang['Override_style_explain'] = '�nlocuie�te stilul utilizatorului cu cel implicit (pentru pagini)';

$lang['Portal_status'] = 'Stare Portal';
$lang['Portal_status_explain'] = 'Un switch, c�nd reconstrui�i website-ul. Doar administratorul poate s� vad� paginile �i s� navigheze normal. C�nd e dezactivat mesajul de mai jos va fi afi�at.';
$lang['Disabled_message'] = 'Mesaj c�nd portalul e dezactivat';

$lang['Portal_Backend'] = 'Utilizator Intern/Sesiune Backend';
$lang['Portal_Backend_explain'] = 'Selecteaz� intern, phpBB2 sau phpBB3 sessiuni �i utilizatori';
$lang['Portal_Backend_path'] = 'Cale relativ� pentru phpBB [non-intern]';
$lang['Portal_Backend_path_explain'] = 'Dac� folosi�i sessiuni �i utilizatori non-interne, introduce�i calea relativ� c�tre phpbb, ex \'phpBB2/\' sau \'../phpBB2/\'. Not�: sla�urile sunt importante.';
$lang['Portal_Backend_submit'] = 'Modific� �i valideaz� Backendul';
$lang['Portal_config_valid'] = 'Statut Backend Curent: ';
$lang['Portal_config_valid_true'] = '<b><font color=\"green\">Valid</font></b>';
$lang['Portal_config_valid_false'] = '<b><font color=\"red\">Instalare Invalid�. Sau calea c�tre phpBB este gre�it� ori phpBB nu este instalat (baza de date phpBB nu este disponibil�). Deci, este folosit backend \'intern\'.</font></b>';

/* Module Management*/
$lang['Module_admin']				= 'Administra�ie Module';
$lang['Module_admin_explain']		= 'Folose�te acest form pentru a administra modulele: instalare, upgradare �i dezvoltare module.<br /><b>Pentru a folosi acest panou, trebuie s� ai JavaScript �i cooki-urile activate �n browser!</b>';
$lang['Modulecp_admin']				= 'Panou de Control Module';
$lang['Modulecp_admin_explain']		= 'Folose�te acest form pentru a administra modulele: func�ii bloc (parametrii) �i blocuri portal.<br /><b>Pentru a folosi acest panou, trebuie s� ai JavaScript �i cooki-urile activate �n browser!</b>';
$lang['Modules']					= 'Module';
$lang['Module']						= 'Modul';
$lang['Module_delete']				= '�terge un Modul';
$lang['Module_delete_explain']		= 'Folose�te acest form pentru a �terge un Modul (sau func�ie bloc)';
$lang['Edit_module']				= 'Editeaz� un Modul';
$lang['Create_module']				= 'Creaz� Modul Nou';
$lang['Module_name']				= 'Nume Modul';
$lang['Module_desc']				= 'Descrip�ie';
$lang['Module_path']				= 'Cale, ex: \'modules/mx_textblocks/\'';
$lang['Module_include_admin']		= 'Include acest modul �n panoul din st�nga Navigare Admin Meniu';

/* Module Installation*/
$lang['Module_delete_db']			= 'Chiar vrei s� dezinstalezi acest Modul? Aten�ie: O s� pierzi tote datele modulului. Consider� upgradare �n loc...';
$lang['Click_module_delete_yes']	= 'Click %sAici%s pt. a dezinstala modulul';
$lang['Click_module_upgrade_yes']	= 'Click %sAici%s pt. a upgrada modulul';
$lang['Click_module_export_yes']	= 'Click %sAici%s pt. a exporta modulul';
$lang['Error_no_db_install']		= 'Eroare: Fi�ierul db_install.php nu exist�. Te rog verific� �i �ncearc� din nou...';
$lang['Error_no_db_uninstall']		= 'Eroare: Fi�ierul db_uninstall.php nu exist�, sau func�ia de dezinstalare nu este suportat� �n acest modul. Te rog verific� aceasta �i �ncearc� din nou...';
$lang['Error_no_db_upgrade']		= 'Eroare: Fi�ierul db_upgrade.php nu exist�, sau fun�ia de upgradare nu este suportat� �n acest modul. Te rog verific� aceasta �i �ncearc� din nou...';
$lang['Error_module_installed']		= 'Eroare: Acest modul este deja instalat! Te rog �nainte ori �terge modulul, ori upgradeaz� modul.';
$lang['Uninstall_module']			= 'Dezinstaleaz� Modul';
$lang['import_module_pack']			= 'Instaleaz� Modul';
$lang['import_module_pack_explain']	= 'Aceasta va adauga un modul la portal. Asigurate c� Pachetul Modulului este uploadat �n folderul /modules. �ine minte s� folose�ti unltima versiune de Modul!';
$lang['upgrade_module_pack']		= 'Upgradare Modul';
$lang['upgrade_module_pack_explain']	= 'Aceasta va upgrada modulul t�u. Asigur�te c� ai citit Documenta�ia Modulului �nainte de a proceda, sau po�i risca pierderi de date la modul.';
$lang['export_module_pack']			= 'Exportare Modul';
$lang['Export_Module']				= 'Selecteaz� un Modul:';
$lang['export_module_pack_explain']	= 'Aceasta va exporta fi�ierul *.pak al modulului. Aceasta este intentat pentru scriitori de module numai...';
$lang['Module_Config_updated']		= 'Configura�ia Modulului Actualizat� cu Succes';
$lang['Click_return_module_admin']	= 'Click %sAici%s pt. a te �ntoarce la Administra�ie Module';
$lang['Module_updated']				= 'Informa�iile Modulului Actualizate cu Succes';
$lang['list_of_queries'] = 'This is the result list of the SQL queries needed for the install/upgrade';
$lang['already_added'] = 'Error or Already added';
$lang['added_upgraded'] = 'Added/Updated';
$lang['upgrading_mods'] = 'If you get some Errors, Already Added or Updated messages, relax, this is normal when updating mods';
$lang['module_upgrade'] = 'This is a upgrade';
$lang['fresh_install'] = 'This is a fresh install';
$lang['module_install_info'] = 'Mod Installation/Upgrading/Uninstalling Information - mod specific db tables';

/* Functions & Parameters Administration*/
$lang['Function_admin']					= 'Administra�ie Func�iune Bloc';
$lang['Function_admin_explain']			= 'Modulele au una sau mai multe Func�iuni Bloc. Folose�te acest form pt. a edita, �i, sau �terge Func�iunea unui Bloc';
$lang['Function']				= 'Func�iune Bloc';
$lang['Function_name']				= 'Nume Func�iune Bloc';
$lang['Function_desc']				= 'Descrip�ie';
$lang['Function_file']				= 'Fi�ier ';
$lang['Function_admin_file']       		= 'Fi�ier (Script Editare Bloc) <br /> Parametrii extra pentru acest panou editare bloc. Las� blank (gol) pentru a folosi panoul de editare implicit.';
$lang['Create_function']			= 'Func�iune Editare Bloc Nou';
$lang['Delete_function']			= 'Func�iune �tergere Block';
$lang['Delete_function_explain']		= 'Acesta va �terge func�iunea �i toate blocurile portalului asociate. Aten�ie, aceast� opera�ie nu este reversibil�!';
$lang['Click_function_delete_yes']		= 'Click %sAici%s pt. a �terge Func�iunea';

$lang['Parameter_admin']			= 'Administrare Parametru Func�iune';
$lang['Parameter_admin_explain']		= 'Listeaz� to�i Parametrii pt. aceast� Func�iune';
$lang['Parameter']				= 'Parametru';
$lang['Parameter_name']				= '<b>Nume Parametru</b><br />- pt. a fi folosit pt. a accesa parametru';
$lang['Parameter_type']				= '<b>Tip Parametru</b>';
$lang['Parameter_default']			= '<b>Valoare Implicit�</b>';
$lang['Parameter_function']			= '<b>Func�iune/Op�iuni</b>';
$lang['Parameter_function_explain']		= '<b>Func�iune</b> (c�nd folose�ti tipul \'Func�iune\')<br />- Po�i pasa data parametrului la o func�iune extern� <br /> pt. a genera c�mpul form al parametrului.<br />- De exemplu: <br />get_list_formatted(\"block_list\",\"{parameter_value}\",\"{parameter_id}[]\")';
$lang['Parameter_function_explain']		.= '<br /><br /><b>Op�iune(s)</b> (c�nd folose�ti \'Selec�ie\' tipuri parametri)<br />- Pentru to�i parametri selec�iei (butoane radio, boxe verificare �i meniuri) toate op�iunile sunt listate aici, o op�iune per linie.';
$lang['Parameter_auth']				= '<b>Admin/Bloc �i Moderatori numai</b>';

$lang['Parameters']					= 'Parametrii';
$lang['Parameter_id']					= 'ID';
$lang['Create_parameter']				= 'Adaug� Parametru Nou';
$lang['Delete_parameter']				= '�terge Func�iune Parametru';
$lang['Delete_parameter_explain']			= 'Acesta va �terge parametru �i va actualiza toate blocurile portalului asociate. Aten�ie, aceast� opera�ie nu este reversibil�!';
$lang['Click_parameter_delete_yes']			= 'Click %sAici%s pentru a �terge Parametru';
/* Parameter Types*/
$lang['ParType_BBText'] 			= 'Simplu BBText BlocText';
$lang['ParType_BBText_info'] 		= 'Acesta este un simplu bloctext, permite bbcod-uri';
$lang['ParType_Html'] 				= 'Simplu Html BlocText';
$lang['ParType_Html_info'] 			= 'Acesta este un simplu bloctext, permite html';
$lang['ParType_Text'] 				= 'Text Obi�nuit (singur-r�nd)';
$lang['ParType_Text_info'] 			= 'Acesta este un simplu c�mp de text';
$lang['ParType_TextArea'] 			= 'Zona Text Obi�nuit (multiple-r�nduri)';
$lang['ParType_TextArea_info'] 		= 'Acesta este o simpl� zon� c�mp de text';
$lang['ParType_Boolean'] 			= 'Boolean';
$lang['ParType_Boolean_info'] 		= 'Acesta este un \'da\' sau \'nu\' comutator radio.';
$lang['ParType_Number'] 			= 'Num�r Obi�nuit';
$lang['ParType_Number_info'] 		= 'Acesta este un simplu c�mp de numar';
$lang['ParType_Function'] 			= 'Func�ie Parametru';
$lang['ParType_Values'] 			= 'Valori';

$lang['ParType_Radio_single_select'] 			= 'Singur-Selec�ie Buton Radio';
$lang['ParType_Radio_single_select_info'] 		= '';
$lang['ParType_Menu_single_select'] 			= 'Singur-Selec�ie Meniu';
$lang['ParType_Menu_single_select_info'] 		= '';
$lang['ParType_Menu_multiple_select'] 			= 'Multiplu-Selec�ie Meniu';
$lang['ParType_Menu_multiple_select_info'] 		= '';
$lang['ParType_Checkbox_multiple_select'] 		= 'Multiplu-Selec�ie Box� Verificare';
$lang['ParType_Checkbox_multiple_select_info'] 		= '';

/* Blocks Administration*/
$lang['Block_admin']				= 'Panou de Contol Bloc';
$lang['Block_admin_explain']		= 'Folose�te acest form pentru a administra Blocurile Portalului.<br /><b>Pentru a folosi acest panou, trebuie s� ai JavaScript �i cooki-urile activate �n browser!</b>';
$lang['Block']						= 'Bloc';
$lang['Show_title']					= 'Arata Titlu Bloc?';
$lang['Show_title_explain']			= 'Dac� ori nu se arat� titlul blocului';
$lang['Show_block']					= 'Arat� Bloc?';
$lang['Show_block_explain']			= '- Daca \'nu\', Blocul este ascuns pt. to�i utilizatorii, except�nd administratorii';
$lang['Show_stats']					= 'Arat� Statistice?';
$lang['Show_stats_explain']			= '- Daca \'da\', \'editat de...\' va fi afi�at lang� bloc';
$lang['Show_blocks']               	= 'Vizualizez� Func�ia Blocurilor';
$lang['Block_delete']				= '�terge un Bloc';
$lang['Block_delete_explain']		= 'Folose�te acest form pt. a �terge un Bloc (ori coloan�)';
$lang['Block_title']				= 'Titlu';
$lang['Block_desc']					= 'Descrip�ie';
$lang['Add_Block']					= 'Adaug� Bloc Nou';
$lang['Auth_Block']					= 'Permisii';
$lang['Auth_Block_explain']			= 'TO�I: To�i utilizatorii<br />REG: utilizatori �nregistra�i<br />PRIVAT: Memberi Grup (vezi permisiile avansate)<br />MOD: bloc moderatori (vezi permisiile avansate)<br />ADMIN: Admin<br />ANONYMOUS: NUMAI utilizatori vizitatori';
$lang['Block_quick_stats']			= 'Statistice Rapid';
$lang['Block_quick_edit']			= 'Editare Rapid�';
$lang['Create_block']				= 'Creare Bloc Nou';
$lang['Delete_block']				= '�terge Bloc din Portal';
$lang['Delete_block_explain']		= 'Acesta va �terge blocul �i va actualiza toate paginile portalului asociate. Aten�ie, aceast� opera�ie nu este reversibil�!';
$lang['Click_block_delete_yes']		= 'Click %sAici%s pt. a �terge Blocul';

/* BlockCP Administration*/
$lang['Block_cp']                   	= 'BlockCP';
$lang['Click_return_blockCP_admin']		= 'Click %sAici%s pt. �ntoarcere la Panoul de Control Bloc';
$lang['Click_return_portalpage_admin']	= 'Click %sAici%s pt. �ntoarcere la Pagina Portalului';
$lang['BlockCP_Config_updated']			= 'Blocul a fost Actualizat...';

/* Pages Administration*/
$lang['Page_admin'] = 'Page Administration';
$lang['Page_admin_explain'] = 'Use this form to add, delete and change the settings for Portal Pages and Page Templates.<br /><b>To use this panel, you need to have JavaScript and cookies enabled in your browser!</b>';
$lang['Page_admin_edit'] = 'Page Edit';
$lang['Page_admin_private'] = 'Advanced Page (PRIVATE) Permissions';
$lang['Page_admin_settings'] = 'Page Settings';
$lang['Page_admin_new_page'] = 'New Page Administration';
$lang['Page'] = 'Page';
$lang['Page_Id'] = 'Page ID';
$lang['Page_icon'] = 'Page Icon <br /> - to be used in the adminCP only, eg. icon_home.gif (default)';
$lang['Page_alt_icon'] = 'Alternative Page Icon <br /> - Full url (http://...) to custom page icon.';
$lang['Default_page_style'] = 'Portal Style (default)<br />To use the default setting, leave this unset.';
$lang['Override_page_style'] = 'Override user style';
$lang['Override_page_style_explain'] = ' ';
$lang['Page_header'] = 'Page header file <br /> - i.e. overall_header.tpl (default), overall_noheader.tpl (no header) or user custom header file.<br />To use the default setting, leave this blank.';
$lang['Page_footer'] = 'Page footer file <br /> - i.e. overall_footer.tpl (default) or user custom footer file.<br />To use the default setting, leave this blank.';
$lang['Page_main_layout'] = 'Page main layout file <br /> - i.e. mx_main_layout.tpl (default) or user custom header file.<br />To use the default setting, leave this blank.';
$lang['Page_Navigation_block'] = 'Page header navigation block';
$lang['Page_Navigation_block_explain'] = '- This is the page header navigation block, provided you\'ve chosen a overall header file which supports page navigation.<br />To use the default setting, leave this unset.';
$lang['Auth_Page'] = 'Permissions';
$lang['Select_sort_method'] = 'Select Sort Method';
$lang['Order'] = 'Order';
$lang['Sort'] = 'Sort';
$lang['Width'] = 'Width';
$lang['Height'] = 'Height';
$lang['Page_sort_title'] = 'Page title';
$lang['Page_sort_desc'] = 'Page description';
$lang['Page_sort_created'] = 'Page created';
$lang['Sort_Ascending'] = 'ASC';
$lang['Sort_Descending'] = 'DESC';
$lang['Return_to_page'] = 'Return to Portal Page';
$lang['Auth_Page_group'] = '-> PRIVATE Group';
$lang['Page_desc'] = 'Description';
$lang['Page_parent'] = 'Parent Page';
$lang['Add_Page'] = 'Add New Page';
$lang['Page_Config_updated'] = 'Page Configuration Updated Successfully';
$lang['Click_return_page_admin'] = 'Click %sHere%s to return to Page Administration';
$lang['Remove_block'] = 'Remove Portal Block';
$lang['Remove_block_explain'] = 'This will remove the block from this page. Beware: this operation cannot be undone!';
$lang['Click_block_remove_yes'] = 'Click %sHere%s to remove the Block';
$lang['Delete_page'] = 'Delete Page';
$lang['Delete_page_explain'] = 'This will delete the Page. Beware: this operation cannot be undone!';
$lang['Click_page_delete_yes'] = 'Click %sHere%s to delete the Page';

$lang['Mx_IP_filter'] = 'IP Filter';
$lang['Mx_IP_filter_explain'] = 'To restrict access to this page by IP, enter the valid IP adresses, with one IP address per line.<br>Example: 127.0.0.1 or 127.1.*.*';
$lang['Mx_phpBB_stats'] = 'phpBB Statistics in Header';
$lang['Mx_phpBB_stats_explain'] = '- Links to new, unread posts, etc.';
$lang['Column_admin'] = 'Page Column Administration';
$lang['Column_admin_explain'] = 'Administrate Page Columns';
$lang['Column'] = 'Page Column';
$lang['Columns'] = 'Page Columns';
$lang['Column_block'] = 'Page Column Block';
$lang['Column_blocks'] = 'Page Column Blocks';
$lang['Edit_Column'] = 'Edit a Column';
$lang['Edit_Column_explain'] = 'Use this form to modify a column';
$lang['Column_Size'] = 'Size of the column';
$lang['Column_name'] = 'Column Name';
$lang['Column_delete'] = 'Delete a Column';
$lang['Page_updated'] = 'Page and Column information updated successfully';
$lang['Create_column'] = 'Add New Column';
$lang['Delete_page_column'] = 'Delete Page Column';
$lang['Delete_page_column_explain'] = 'This will delete the Page Column. Beware: this operation cannot be undone!';
$lang['Click_page_column_delete_yes'] = 'Click %sHere%s to delete the Page Column';

$lang['Add_Split_Block'] 			= 'Add Split Column Block';
$lang['Add_Split_Block_explain'] 	= 'This block splits the column';
$lang['Add_Dynamic_Block'] 			= 'Add Dynamic (Sub) Block';
$lang['Add_Dynamic_Block_explain'] 	= 'This dynamic block defines subpages, set from the navigation menu';
$lang['Add_Virtual_Block'] 			= 'Add Virtual (Page Blog) Block';
$lang['Add_Virtual_Block_explain'] 	= 'This block turns the page into a virtual (blog) page';

/* Page templates*/
$lang['Page_templates_admin'] = 'Page Templates Administration';
$lang['Page_templates_admin_explain'] = 'Use this page to create, edit or delete Page Templates';
$lang['Page_template'] = 'Page Template';
$lang['Page_templates'] = 'Page Templates';
$lang['Page_template_column'] = 'Page Template Column';
$lang['Page_template_columns'] = 'Page Template Columns';
$lang['Choose_page_template'] = 'Choose Page Template';
$lang['Template_Config_updated'] = 'Template Configuration Updated';
$lang['Add_Template'] = 'Add New Template';
$lang['Template'] = 'Template';
$lang['Template_name'] = 'Template Name';
$lang['Page_template_delete'] = 'Delete Template';
$lang['Delete_page_template'] = 'Delete Page Template';
$lang['Delete_page_template_explain'] = 'This will delete the Page Template. Beware: this operation cannot be undone!';
$lang['Click_page_template_delete_yes'] = 'Click %sHere%s to delete the Page Template';
$lang['Delete_page_template_column'] = 'Delete Page Template';
$lang['Delete_page_template_column_explain'] = 'This will delete the Page Template. Beware: this operation cannot be undone!';
$lang['Click_page_template_column_delete_yes'] = 'Click %sHere%s to delete the Page Template';

/* Pages Administration*/
$lang['Page_admin']				= 'Administra�ia Paginii';
$lang['Page_admin_explain']		= 'Folose�te acest form pt. a ad�uga, �terge �i schimba setarile pentru Paginile Portalului �i Paginile Templaturi.<br /><b>Pentru a folosi acest panou, trebuie s� ai JavaScript �i cooki-urile activate �n browser!</b>';
$lang['Page_admin_edit']		= 'Editare Pagina';
$lang['Page_admin_private']		= 'Pagina Avansat� (PRIVAT) Permisii';
$lang['Page_admin_settings']	= 'Setari Pagin�';
$lang['Page_admin_new_page']	= 'Administra�ie Pagina Noua';
$lang['Page']					= 'Pagin�';
$lang['Page_Id']				= 'ID Pagin�';
$lang['Page_icon']				= 'Iconi�a Paginii <br /> - pt. a fi folosit� numai �n AdminCP, ex. icon_home.gif (implicit)';
$lang['Page_header']			= 'Fi�ier Header Pagina <br /> - de ex. overall_header.tpl (implicit), overall_noheader.tpl (far� header) ori fi�ier header custom a utilizatorului.';
$lang['Auth_Page']				= 'Permisii';
$lang['Select_sort_method']		= 'Selecteaz� Metoda de Sortare';
$lang['Order']					= 'Ordine';
$lang['Sort']					= 'Sortare';
$lang['Width'] 					= 'L��ime';
$lang['Height'] 				= '�n�l�ime';
$lang['Page_sort_title']		= 'Titlu pagin�';
$lang['Page_sort_desc']			= 'Descrip�ie pagin�';
$lang['Page_sort_created']		= 'Pagina creat�';
$lang['Sort_Ascending']			= 'ASC';
$lang['Sort_Descending']		= 'DESC';
$lang['Return_to_page']			= '�ntoarcere la Pagina Portalului';
$lang['Auth_Page_group']		= '-> Grup PRIVAT';
$lang['Page_desc']				= 'Descrip�ie';
$lang['Page_graph_border']		= 'Grafic� bordura paginii - fi�ier prefix';
$lang['Page_graph_border_explain']	= 'Pentru a folosi grafica bordurii �n jurul Blocurilor, specific� prefixul pentru fi�ierele grafice aici. De exemplu, introdu \'border_\' pt. a folosi fi�ierele: border_1-1.gif, border_1-2.gif,..., border_3-3.gif pentru matricea de 3x3 cu imagini-gif. Las� blank (gol) pt. a dezactiva grafica bordurii (implicit).';
$lang['Add_Page']					= 'Adaug� Pagina Noua';
$lang['Page_Config_updated']		= 'Configura�ia Paginii Actualizat� cu Succes';
$lang['Click_return_page_admin']	= 'Click %sAici%s pt. �ntoarcere la Administratia Paginii';
$lang['Remove_block']				= 'Scoate Bloc al Portalului';
$lang['Remove_block_explain']		= 'Acesta va scoate blocul din acest� pagina. Aten�ie, acest� opera�ie nu este reversibil�!';
$lang['Click_block_remove_yes']		= 'Click %sAici%s pt. a scoate Blocul';
$lang['Delete_page']				= '�terge Pagina';
$lang['Delete_page_explain']		= 'Acesta va �terge Pagina. Aten�ie, acest� opera�ie nu este reversibil�!';
$lang['Click_page_delete_yes']		= 'Click %sAici%s pt. a �terge Pagina';

$lang['Mx_IP_filter']				= 'Filtru IP';
$lang['Mx_IP_filter_explain']		= 'Pentru a restrictiona accesul la acest� pagina dup� IP, introdu adresele IP valide - o adres� IP per linie.<br>Ex. 127.0.0.1 ori 127.1.*.*';
$lang['Mx_phpBB_stats']				= 'phpBB Statistice �n Header';
$lang['Mx_phpBB_stats_explain']		= '- linkuri la postari noi/necitite etc';
$lang['Column_admin']				= 'Administra�ie Coloane Pagin�';
$lang['Column_admin_explain']		= 'Administreaz� Coloanele Paginii';
$lang['Column']						= 'Coloana Paginii';
$lang['Columns']					= 'Coloanele Paginii';
$lang['Column_block']				= 'Bloc Coloan� Pagin�';
$lang['Column_blocks']				= 'Blocuri Coloana Paginii';
$lang['Edit_Column']				= 'Editeaz� o Coloan�';
$lang['Edit_Column_explain']		= 'Folose�te acest form pt. a modifica o coloan�';
$lang['Column_Size']				= 'M�rimea coloanei';
$lang['Column_name']				= 'Nume Coloan�';
$lang['Column_delete']				= '�terge o Coloan�';
$lang['Page_updated']				= 'Informa�ia Paginii �i Coloanei Actualizat� cu Succes';
$lang['Create_column']				= 'Adaug� Coloan� Nou�';
$lang['Delete_page_column']			= '�terge Coloana Paginii';
$lang['Delete_page_column_explain']		= 'Acesta va �terge Coloana Paginii. Aten�ie, acest� opera�ie nu este reversibil�!';
$lang['Click_page_column_delete_yes']	= 'Click %sAici%s pt. a �terge Colana Paginii';


$lang['Add_Split_Block'] 			= 'Add Split Column Block';
$lang['Add_Split_Block_explain'] 	= 'This block splits the column';
$lang['Add_Dynamic_Block'] 			= 'Add Dynamic (Sub) Block';
$lang['Add_Dynamic_Block_explain'] 	= 'This dynamic block defines subpages, set from the navigation menu';
$lang['Add_Virtual_Block'] 			= 'Add Virtual (Page Blog) Block';
$lang['Add_Virtual_Block_explain'] 	= 'This block turns the page into a virtual (blog) page';

/* Page templates*/
$lang['Page_templates_admin']			= 'Administartie Templaturi Pagin�';
$lang['Page_templates_admin_explain'] 	= 'Folose�te acesta pt. a crea, edita ori �terge Templaturi';
$lang['Page_template']					= 'Template Pagin�';
$lang['Page_templates']					= 'Templaturi Pagin�';
$lang['Page_template_column']			= 'Coloan� Template Pagin�';
$lang['Page_template_columns']			= 'Coloane Template Pagin�';
$lang['Choose_page_template']			= 'Alege Templatul Paginii';
$lang['Template_Config_updated']		= 'Configura�ia Templetului a fost Actualizat�';
$lang['Add_Template']					= 'Adaug� Template Nou';
$lang['Template']						= 'Template';
$lang['Template_name']					= 'Nume Template';
$lang['Page_template_delete']			= '�terge Template';
$lang['Delete_page_template']			= '�terge Pagin� Template';
$lang['Delete_page_template_explain']	= 'Acesta va �terge Templatul Paginii. Aten�ie, acest� opera�ie nu este reversibil�!';
$lang['Click_page_template_delete_yes']	= 'Click %sAici%s pt. a �terge Templatul Paginii';
$lang['Delete_page_template_column']	= '�terge Pagina Template';
$lang['Delete_page_template_column_explain']	= 'Acesta va �terge Templatul Paginii. Aten�ie, acest� opera�ie nu este reversibil�!';
$lang['Click_page_template_column_delete_yes']	= 'Click %sAici%s pt. a �terge Templatul Paginii';

/* Cache*/
$lang['Cache_dir_write_protect']	= 'Directorul tau cache este protejat la scriere. Nu s-a putut genera fi�ierul cache';
$lang['Cache_generate']				= 'Fi�ierele cache au fost generate.';
$lang['Cache_submit']				= 'S� generez fi�ierul cache?';
$lang['Cache_explain']				= 'Cu acest� op�iune po�i s� generezi toate fi�ierele XML (fi�iere cache) odat� pentru toate blocurile portalului. Aceste fi�iere permit reducerea num�rului de cereri ale bazei de date necesare �i �mbun�t��esc performan�a portalului. <br />Noteaz�: MXP cache trebuie activat (�n Portal General Admin CP) petru ca aceste fi�iere s� fie folosite de sistem.<br>Mai Noteaz�: fi�ierele cache sunt create on the fly c�nd sunt �i blocurile de editare la fel.';
$lang['Generate_mx_cache']			= 'Genereaz� Bloc Cache';

/* These are displayed in the drop down boxes for advanced mode Module auth, try and keep them short!*/
$lang['Menu_Navigation']			= 'Meniu Navigare';
$lang['Portal_index']				= 'Index Portal';
$lang['Save_Settings']				= 'Salvare Set�ri';
$lang['Translation_Tools']			= 'Unelte de Traducere';
$lang['Preview_portal']				= 'Previzualizare Portal';

/* META*/
$lang['Meta_admin']					= 'Administratie Meta Taguri';
$lang['Mega_admin_explain']			= 'Foloseste acest form s� customizezi meta tagurile tale';
$lang['Meta_Title']					= 'Titlu';
$lang['Meta_Author']				= 'Autor';
$lang['Meta_Copyright']				= 'Copyright';
$lang['Meta_ImageToolBar'] 			= 'Image ToolBar';
$lang['Meta_Distribution'] 			= 'Distribution';
$lang['Meta_Keywords']				= 'Cuvinte Cheie';
$lang['Meta_Keywords_explain']		= '(lista separat� de virgul�)';
$lang['Meta_Description']			= 'Descrip�ie';
$lang['Meta_Language']				= 'Cod Limb�';
$lang['Meta_Rating']				= 'Clasare';
$lang['Meta_Robots']				= 'Robots';
$lang['Meta_Pragma']				= 'Pragma no-cache';
$lang['Meta_Bookmark_icon']			= 'Bookmark Iconi��';
$lang['Meta_Bookmark_explain']		= '(loca�ie relativ�)';
$lang['Meta_HTITLE']				= 'Set�ri Extra Header';
$lang['Meta_data_updated']			= 'Fi�ierul de date meta (mx_meta.inc) a fost actualizat!<br />Click %sAICI%s pt. intoarcere la Administra�ie Meta Taguri.';
$lang['Meta_data_ioerror']			= 'Nu se poate deschide mx_meta.inc. Asigur�te c� fi�ierul e writabil (chmod 777).';

/* Portal permissons*/
$lang['Mx_Block_Auth_Title']		= 'Permisii Bloc Privat';
$lang['Mx_Block_Auth_Explain']		= 'Aici poti s� configurezi Permisiile Blocului Privat';
$lang['Mx_Page_Auth_Title']			= 'Permisii Pagina Privat�';
$lang['Mx_Page_Auth_Explain']		= 'Aici po�i s� configurezi Permisiile Paginii Private';
$lang['Block_Auth_successfully']	= 'Permisiunile Blocului Actualizate cu Succes';
$lang['Click_return_block_auth']	= 'Click %sAici%s pt. �ntoarcere la Permisii Bloc Privat';
$lang['Page_Auth_successfully']		= 'Permisiunile Paginii Actualizate cu Succes';
$lang['Click_return_page_auth']		= 'Click %sAici%s pt. �ntoarcere la Permisii Pagina Privata';
$lang['AUTH_ALL']					= 'TO�I';
$lang['AUTH_REG']					= 'REG';
$lang['AUTH_PRIVATE']				= 'PRIVAT';
$lang['AUTH_MOD']					= 'MOD';
$lang['AUTH_ADMIN']					= 'ADMIN';
$lang['AUTH_ANONYMOUS']				= 'ANONYMOUS';

/* -----------------------------------
 BlockCP - Block Parameter Specific 
 ----------------------------------- */
 
/* General*/
$lang['target_block']				= 'Bloc �inta';
$lang['target_block_explain']		= '- linkuri, date etc sunt referite cu acest bloc';

/* Split column*/
$lang['block_ids']					= 'Blocuri Surs�';
$lang['block_ids_explain']			= '- s� fie pozi�ionate st�nga spre dreapta';
$lang['block_sizes']				= 'Marimi Bloc (separate de virgul�)';
$lang['block_sizes_explain']		= '- Po�i specifica m�rimile folosind numere (pixeli), procente (m�rimi relative, de ex. "40%") ori "*" pentru remainder.';
$lang['space_between']				= 'Spa�iu �ntre blocuri';

/* Sitelog*/
$lang['log_filter_date']			= 'Filtru dup� timp';
$lang['log_filter_date_explain']	= '- Arat� loguri din s�pt�m�na trecut�, luna, anul...';
$lang['numOfEvents']				= 'Num�r';
$lang['numOfEvents_explain']		= '- Num�r evenimente de ar�tat';

/* IncludeX*/
$lang['x_listen']					= 'Ascult� (GET)';
$lang['x_iframe']					= 'IFrame';
$lang['x_textfile']					= 'Fi�ier Text';
$lang['x_multimedia']				= 'WMP Multimedia';
$lang['x_pic']						= 'Pictur�';
$lang['x_format']					= 'Fi�ier text formatat';
$lang['x_mode']						= 'IncludeX mode:';
$lang['x_mode_explain']				= '- Blocul IncludeX opereaz� �n unul din urmatoarele moduri. Dac� modul \'Ascult� (GET)\' este selectat, modul pote fi setat de un url \'x_mode=mode\' �i parametrul asociat cu \'x_1=, x_2=, etc\'.<br />Exemplu: Pentru a trimite un url la iframe folose�te \'domain/index.php?page=x&x_mode=iframe&x_1=http://domain\'  ';
$lang['x_1']						= 'Variabila 1:';
$lang['x_1_explain']				= '- <i>IFrame:</i> url<br /><i>Fi�ierText:</i> cale relativ� din radacin� (ex �n \'/include_file/my_file.xxx\')<br /><i>Multimedia:</i> cale relativ� din radacin� (ex �n \'/include_file/my_file.xxx\')<br /><i>Pic:</i> cale relativ� din radacin� (ex �n \'/include_file/my_file.xxx\')<br /><i>Fi�ier Text Formatat:</i> indisponibil';
$lang['x_2']						= 'Variabila 2:';
$lang['x_2_explain']				= '- <i>IFrame:</i> �naltime frame (pixeli)<br /><i>Multimedia:</i> l��ime (pixeli)';
$lang['x_3']						= 'Variabila 3:';
$lang['x_3_explain']				= '- <i>Multimedia:</i> �naltime (pixeli)';

/* Announcement*/
$lang['announce_nbr_display']		= 'Num�r Maxim de Mesaje care s� fie Afi�ate';
$lang['announce_nbr_days']			= 'Num�r de Zile �n care se Afi�eaza Mesaje';
$lang['announce_img']				= 'Imagine Anun�uri';
$lang['announce_img_sticky']		= 'Imagine Lipicioas�';
$lang['announce_img_normal']		= 'Imagine Mesaj Normal';
$lang['announce_img_global']		= 'Imagine Anun�uri Globale';
$lang['announce_display']			= 'Afi�eaz� Mesaje Anun�(uri) �n acest Bloc';
$lang['announce_display_sticky']	= 'Afiseaz� Lipicios(as�) �n acest Bloc';
$lang['announce_display_normal']	= 'Afiseaz� Mesaj(e) Normale �n acest Bloc';
$lang['announce_display_global']	= 'Afiseaz� Anun�urile Globale �n acest Bloc';
$lang['announce_forum']				= 'Forumuri Surs�';
$lang['announce_forum_explain']		= '- Po�i face selec�ii multiple<br />* Dac� nu este selectat nimic, toate forumurile autorizate vor fi vizibile';

/* Polls*/
$lang['Poll_Display']				= 'Care urn� vrei s� o afi�ezi?';
$lang['poll_forum']					= 'Forumuri Surs�';
$lang['poll_forum_explain']			= '- Po�i face selec�ii mutiple<br />* Dac� nimic nu este selectat, toate forumurile autorizate vor fi vizibile';
$lang['Not_Specified']				= 'Ne Specificat';

/* Dynamic Block*/
$lang['default_block_id']			= 'Bloc Implicit';
$lang['default_block_id_explain']	= '- Acesta este blocul implicit de afi�at, except�nd dac� un bloc dinamic este selectat';

/* Menu Navigation*/
$lang['menu_display_mode']			= 'Mod Plan';
$lang['menu_display_mode_explain ']	= 'Mod plan Orizonal ori Vertical';
$lang['menu_page_sync']				= 'Luminez� cel curent?';
$lang['menu_page_sync_explain']		= 'Luminez� intrare la Meniul de Nav. curent...';

/* Version Checker*/
$lang['MXP_Version_up_to_date'] = 'Instalarea MXP este la zi. Nu exist� actualiz�ri pentru versiunea ta de MXP.';
$lang['MXP_Version_outdated'] = 'Se pare ca instalarea ta MXP <b>nu</b> este la zi. Actualiz�ri exist� pentru versiunea ta de MXP. Te rog vizitez� <a href="http://mxpcms.sourceforge.net/index.php?page=4&action=file&file_id=2" target="_new">downloadare pachetul MXP Core</a> pt. a ob�ine ultima versiune.';
$lang['MXP_Latest_version_info'] = 'Ultima veriune disponibil� este <b>MXP %s</b>. ';
$lang['MXP_Current_version_info'] = 'Tu ai <b>MXP %s</b>.';
$lang['MXP_Mailing_list_subscribe_reminder'] = 'Pentru ultimile informa�ii de �tiri �i actualiz�ri pentru MXP, de ce nu <a href="http://lists.sourceforge.net/lists/listinfo/mxpcms-news" target="_new">�nscriete la lista de mailuri</a>.';

$lang['Trans_title']				= 'Translate to your Language';
$lang['Trans_description']			= 'Use Translate Control Panel to translate portal to your language';
$lang['Trans_which_core']			= 'Which Part';
$lang['Trans_select_file']			= 'Select file to translate';
$lang['Trans_from_desc']			= 'Default language to translate from';
$lang['Trans_leave_orig']			= 'If not translated <b>leave original</b> text';
$lang['Trans_selected_file']		= 'Selected File';
$lang['Trans_lang_source']			= 'Source Language';
$lang['Trans_lang_dest']			= 'Destination Language';
$lang['Trans_lang_block']			= 'Language block';
$lang['Trans_save_file']			= 'Save language file';

/*
* Asta e tot lume!
*
* Translated from english to romanian by OryNider
* orynider@rdslink.ro // http://pubory.uv.ro/
*
* ------------------------------------------------- */
?>