<?php
/**
*
* @package MXP Portal Core
* @version $Id: lang_admin.php,v 1.15 2013/06/28 17:08:52 orynider Exp $
* @copyright (c) 2002-2006 MXP Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

/*  Editor Settings: Please set Tabsize to 4 ;-) */
 
/*  The format of this file is:  ---> $lang['message'] = 'text';
/*  Specify your language character encoding... [optional] */  
setlocale(LC_ALL, 'en');


$lang['ENCODING'] = 'UTF-8';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'stânga';
$lang['RIGHT'] = 'dreapta';
$lang['DATE_FORMAT'] =  'd/M/Y'; // This should be changed to the default date format for your language, php date() format

$lang['Mx-Publisher_adminCP']	= 'Mx-Publisher Administraţie';	
$lang['Portal_Desc'] 			= 'A little text to describe your website.';

/*
* Left AdminCP Panel
*/
$lang['1_General_admin']		= 'General';
$lang['1_1_Management']			= 'Configuraţie';
$lang['1_2_WordCensors'] 		= 'Cenzori de cuvinte';

$lang['2_CP']					= 'Management';
$lang['2_1_Modules']			= 'Instalare Module<br /><hr>';
$lang['2_2_ModuleCP']			= 'Panou de Control Module';
$lang['2_3_BlockCP']			= 'Panou de Control Bloc';
$lang['2_4_PageCP']				= 'Panou de Control Pagină';

$lang['3_CP'] 					= 'Stiluri';
$lang['2_1_new'] 				= 'Adaugă nou';
$lang['2_2_manage'] 			= 'Configurează';
$lang['2_3_smilies'] 			= 'Emoticoane';

$lang['4_Panel_system']			= 'Unelte Sistem';
$lang['4_1_Cache']				= 'Regenerează Cache-ul';
$lang['4_1_Integrity']			= 'Verificator Integritate';
$lang['4_1_Meta']				= 'Taguri META';
$lang['4_1_PHPinfo']			= 'phpInfo()';
$lang['4_2_Translate'] 			= 'Panou de Control Traduceri';


/*
* Index
*/
$lang['Welcome_Mx-Publisher'] 				= 'Bine aţi venit la panoul de control al MXP CMS';
$lang['Admin_intro_Mx-Publisher'] 			= 'Vă mulţumim pentru aţi ales Mx-Publisher ca soluţie pentru portalul/cms-ul dumneavoastră şi phpBB ca soluţie pentru forumul dumneavoastră. Acest ecran vă oferă o privire de ansamblu a diverselor statistici ale site-ului dumneavoastră. Puteţi reveni la această pagină folosind legătura <span style="text-decoration: underline;">Pagina de start a administratorului</span> din panel-ul stâng. Pentru a reveni la pagina de start a forumului dumneavoastră, apăsaţi pe logo-ul phpBB-ului aflat, de asemenea, în panel-ul stâng. Celelalte legături din partea stângă vă permit să controlaţi orice aspect al forumului, fiecare ecran va avea instrucţiuni care dau explicaţii despre cum se folosesc uneltele.';

/*
* General
*/
$lang['Yes']						= 'Da';
$lang['No']							= 'Nu';
$lang['No_modules']					= 'Nici un Modul instalat';
$lang['No_functions']				= 'Acest modul nu are funcţii bloc';
$lang['No_parameters']				= 'Această funcţie nu are parametri';
$lang['No_blocks']					= 'Nici un bloc nu a fost creat pentru aceasta funcţie';
$lang['No_pages']					= 'Nici o pagină nu a fost creată';
$lang['No_settings']				= 'Nu mai există setari pentru acest bloc';
$lang['Quick_nav']					= 'Navigare Quick-Rapidă';
$lang['Include_all_modules']		= 'Listează toate modulele';
$lang['Include_block_quickedit']	= 'Include Blocul Panoul Quickedit';
$lang['Include_block_private']		= 'Include Blocul Panoul Autentificare Prv';
$lang['Include_all_pages']			= 'Lisează toate paginile';
$lang['View']						= 'Vizualizeză';
$lang['Edit']						= 'Editează';
$lang['Delete']						= 'Şterge';
$lang['Settings']					= 'Setări';
$lang['Move_up']					= 'Mută în sus';
$lang['Move_down']					= 'Mută în jos';
$lang['Resync']						= 'Resinc';
$lang['Update']						= 'Actualizare';
$lang['Permissions']				= 'Permisii';
$lang['Permissions_std']			= 'Permisii Standard';
$lang['Permissions_adv']			= 'Permisii Avansate';
$lang['return_to_page']				= 'Înapoi la Pagina Portalului';
$lang['Use_default'] 				= 'Foloseşte setări implicite';

$lang['AdminCP_status']				= '<b>Raport Progres</b>';
$lang['AdminCP_action']				= '<b>Acţiune DB</b>';
$lang['Invalid_action']				= 'Eroare';
$lang['was_installed']             	= 'a fost instalat';
$lang['was_uninstalled']           	= 'a fost dezinstalat';
$lang['was_upgraded']              	= 'a fost upgradat';
$lang['was_exported']               = 'a fost exportat';
$lang['was_deleted']               	= 'a fost şters';
$lang['was_removed']               	= 'a fost scos';
$lang['was_inserted']              	= 'a fost inserat';
$lang['was_updated']               	= 'a fost actualizat';
$lang['was_added']                 	= 'a fost adăugat';
$lang['was_moved']                 	= 'a fost mutat';
$lang['was_synced']                	= 'a fost sincronizat';

$lang['error_no_field']					= 'Este un câmp lipsă. Te rog complecteză toate câmpurile necesare...';
$lang['Cookie_settings_mxp'] 			= 'Configurările pentru cookie';
$lang['Cookie_settings_explain_mxp']	= 'Aceste detalii definesc cum sunt cookie-urile trimise către browser-ele utilizatorilor. În cele mai multe cazuri valorile standard pentru setările cookie-urilor ar trebui să fie suficiente dar dacă trebuie să le schimbaţi aveţi mare grijă, setările incorecte pot împiedica utilizatorii să se autentifice';

/*
* Configuration
*/
$lang['Portal_admin']						= 'Administraţia Portalului';
$lang['Portal_admin_explain']				= 'Foloseste acest form pt. a customiza portalul tau';
$lang['Portal_General_Config']				= 'Configuraţie Portal';
$lang['Portal_General_Config_explain'] 		= 'Use this form to manage the main settings of your MX-Publisher site.';
$lang['Portal_General_settings']			= 'Setari Generale';
$lang['Portal_Style_settings'] 				= 'Setari Stiluri';
$lang['Portal_General_config_info']			= 'Info General Configurare Portal ';
$lang['Portal_General_config_info_explain'] = 'Postată informaţii instalare din fişierul config.php (nu e nevoie de editare)';
$lang['Portal_Name']					= 'Nume Portal:';
$lang['Portal_Description']				= 'Descriptie Portal:';
$lang['Portal_PHPBB_Url']				= 'URL pt. instarea ta de forum phpBB:';
$lang['Portal_Url']						= 'URL pentru Mx-Publisher:';
$lang['Portal_Config_updated']			= 'Configuraţia Portalului Actualizată cu Succes';
$lang['Click_return_portal_config']		= 'Click %sAici%s pentru a te intoarce la Configurarea Portalului';
$lang['PHPBB_info']						= 'Informatii phpBB';
$lang['PHPBB_version']					= 'Versiunea phpBB:';
$lang['PHPBB_script_path']				= 'phpBB Cale Script:';
$lang['PHPBB_server_name']				= 'phpBB Domeniu (nume_server):';
$lang['MX_Portal']						= 'Mx-Publisher';
$lang['MX_Modules']						= 'MXP-Module';
$lang['Phpbb']							= 'phpBB';
$lang['Top_phpbb_links']				= 'phpBB Stats în Header (valoare impicită)<br /> - linkuri la postari noi/necitite etc';
$lang['Top_phpbb_links_explain'] 		= '- Legaturi la noi, postari necitite';
$lang['Portal_version']					= 'Versiune Mx-Publisher:';
$lang['Mx_use_cache']					= 'Foloseşte MXP Bloc Cache';
$lang['Mx_use_cache_explain']			= 'Datele din Bloc este în fişiere individuale cache/bloc_*.xml. Fişierele Bloc cache sunt create când Blocurile sunt editate.';
$lang['Mx_mod_rewrite'] 				= 'Foloseste mod_rewrite';
$lang['Mx_mod_rewrite_explain'] 		= 'Daca eşti pe server Apache, şi ai mod_rewrite activat, poţi rescrie url-urile ca \'page=x\' cu alternative mai intuitive. Citeşte pentru mai multe documentaţia pentru modulul mx_mod_rewrite.';

$lang['Portal_Overall_header'] 					= 'Fişier Overall Header (valoare impicită)';
$lang['Portal_Overall_header_explain'] 			= '- Aceasta este valoarea implicită a fişierului overall_header, e.g. overall_header.tpl.';

$lang['Portal_Overall_footer'] 					= 'Fişier Overall Footer (valoare impicită)';
$lang['Portal_Overall_footer_explain'] 			= '- Aceasta este valoarea implicită a fişierului overall_footer, e.g. overall_footer.tpl.';

$lang['Portal_Main_layout'] 					= 'Fişier Main Layout (valoare impicită)';
$lang['Portal_Main_layout_explain'] 			= '- This is the default template main_layout file, e.g. mx_main_layout.tpl.';
$lang['Portal_Navigation_block'] 				= 'Overall Header Navigation Block (valoare impicită)';
$lang['Portal_Navigation_block_explain'] 		= '- This is the default template overall_header navigation block.';

$lang['Default_style'] = 'Style Pagini Portal (implicit)';
$lang['Default_admin_style'] = 'Style AdminCP';
$lang['Select_page_style'] = 'Selectează (ori foloseşte implicit)';
$lang['Override_style'] = 'Supracrie stilul utilizatorului';
$lang['Override_style_explain'] = 'Înlocuieşte stilul utilizatorului cu cel implicit (pentru pagini)';

$lang['Portal_status'] = 'Stare Portal';
$lang['Portal_status_explain'] = 'Un switch, când reconstruiţi website-ul. Doar administratorul poate să vadă paginile şi să navigheze normal. Când e dezactivat mesajul de mai jos va fi afişat.';
$lang['Disabled_message'] = 'Mesaj când portalul e dezactivat';

$lang['Portal_Backend'] = 'Utilizator Intern/Sesiune Backend';
$lang['Portal_Backend_explain'] = 'Selectează intern, phpBB2 sau phpBB3 sessiuni şi utilizatori';
$lang['Portal_Backend_path'] = 'Cale relativă pentru phpBB [non-intern]';
$lang['Portal_Backend_path_explain'] = 'Dacă folosiţi sessiuni şi utilizatori non-interne, introduceţi calea relativă către phpbb, ex \'phpBB2/\' sau \'../phpBB2/\'. Notă: slaşurile sunt importante.';
$lang['Portal_Backend_submit'] = 'Modifică şi validează Backendul';
$lang['Portal_config_valid'] = 'Statut Backend Curent: ';
$lang['Portal_config_valid_true'] = '<b><font color=\"green\">Valid</font></b>';
$lang['Portal_config_valid_false'] = '<b><font color=\"red\">Instalare Invalidă. Sau calea către phpBB este greşită ori phpBB nu este instalat (baza de date phpBB nu este disponibilă). Deci, este folosit backend \'intern\'.</font></b>';

$lang['Phpbb_path']					= 'phpBB cale relativă';
$lang['Phpbb_path_explain'] 		= 'Cale relativă la phpBB, ex. phpBB/ or ../phpBB/<br />Notează slaşurile "/", ele sunt importante!';
$lang['Phpbb_url'] 					= 'URL phpBB Complet';
$lang['Portal_backend'] 			= 'Portal Backend';
$lang['Phpbb_url_explain']			= 'Exemplu URL phpBB Complect, ex. <br />http://www.exemplu.ro/phpBB/';
$lang['Portal_url'] 				= 'URL Complet CMS';
$lang['Portal_url_explain'] 		= 'URL Complet CMS, ex. <br />http://www.exemplu.ro/';

/*
* Module Management
*/
$lang['Module_admin']				= 'Administraţie Module';
$lang['Module_admin_explain']		= 'Foloseşte acest form pentru a administra modulele: instalare, upgradare şi dezvoltare module.<br /><b>Pentru a folosi acest panou, trebuie să ai JavaScript şi cooki-urile activate în browser!</b>';
$lang['Modulecp_admin']				= 'Panou de Control Module';
$lang['Modulecp_admin_explain']		= 'Foloseşte acest form pentru a administra modulele: funcţii bloc (parametrii) şi blocuri portal.<br /><b>Pentru a folosi acest panou, trebuie să ai JavaScript şi cooki-urile activate în browser!</b>';
$lang['Modules']					= 'Module';
$lang['Module']						= 'Modul';
$lang['Module_delete']				= 'Şterge un Modul';
$lang['Module_delete_explain']		= 'Foloseşte acest form pentru a şterge un Modul (sau funcţie bloc)';
$lang['Edit_module']				= 'Editează un Modul';
$lang['Create_module']				= 'Crează Modul Nou';
$lang['Module_name']				= 'Nume Modul';
$lang['Module_desc']				= 'Descripţie';
$lang['Module_path']				= 'Cale, ex: \'modules/mx_textblocks/\'';
$lang['Module_include_admin']		= 'Include acest modul în panoul din stânga Navigare Admin Meniu';

/*
* Module Installation
*/
$lang['Module_delete_db']			= 'Chiar vrei să dezinstalezi acest Modul? Atenţie: O să pierzi tote datele modulului. Consideră upgradare în loc...';
$lang['Click_module_delete_yes']	= 'Click %sAici%s pt. a dezinstala modulul';
$lang['Click_module_upgrade_yes']	= 'Click %sAici%s pt. a upgrada modulul';
$lang['Click_module_export_yes']	= 'Click %sAici%s pt. a exporta modulul';
$lang['Error_no_db_install']		= 'Eroare: Fişierul db_install.php nu există. Te rog verifică şi încearcă din nou...';
$lang['Error_no_db_uninstall']		= 'Eroare: Fişierul db_uninstall.php nu există, sau funcţia de dezinstalare nu este suportată în acest modul. Te rog verifică aceasta şi încearcă din nou...';
$lang['Error_no_db_upgrade']		= 'Eroare: Fişierul db_upgrade.php nu există, sau funţia de upgradare nu este suportată în acest modul. Te rog verifică aceasta şi încearcă din nou...';
$lang['Error_module_installed']		= 'Eroare: Acest modul este deja instalat! Te rog înainte ori şterge modulul, ori upgradează modul.';
$lang['Uninstall_module']			= 'Dezinstalează Modul';
$lang['import_module_pack']			= 'Instalează Modul';
$lang['import_module_pack_explain']	= 'Aceasta va adauga un modul la portal. Asigurate că Pachetul Modulului este uploadat în folderul /modules. Ţine minte să foloseşti unltima versiune de Modul!';
$lang['upgrade_module_pack']		= 'Upgradare Modul';
$lang['upgrade_module_pack_explain']	= 'Aceasta va upgrada modulul tău. Asigurăte că ai citit Documentaţia Modulului înainte de a proceda, sau poţi risca pierderi de date la modul.';
$lang['export_module_pack']			= 'Exportare Modul';
$lang['Export_Module']				= 'Selectează un Modul:';
$lang['export_module_pack_explain']	= 'Aceasta va exporta fişierul *.pak al modulului. Aceasta este intentat pentru scriitori de module numai...';
$lang['Module_Config_updated']		= 'Configuraţia Modulului Actualizată cu Succes';
$lang['Click_return_module_admin']	= 'Click %sAici%s pt. a te întoarce la Administraţie Module';
$lang['Module_updated']				= 'Informaţiile Modulului Actualizate cu Succes';
$lang['list_of_queries'] = 'This is the result list of the SQL queries needed for the install/upgrade';
$lang['already_added'] = 'Error or Already added';
$lang['added_upgraded'] = 'Added/Updated';
$lang['upgrading_mods'] = 'If you get some Errors, Already Added or Updated messages, relax, this is normal when updating mods';
$lang['module_upgrade'] = 'This is a upgrade';
$lang['fresh_install'] = 'This is a fresh install';
$lang['module_install_info'] = 'Mod Installation/Upgrading/Uninstalling Information - mod specific db tables';

/*
* Functions & Parameters Administration
*/
$lang['Function_admin']				= 'Administraţie Funcţiune Bloc';
$lang['Function_admin_explain']		= 'Modulele au una sau mai multe Funcţiuni Bloc. Foloseşte acest form pt. a edita, şi, sau şterge Funcţiunea unui Bloc';
$lang['Function']					= 'Funcţiune Bloc';
$lang['Function_name']				= 'Nume Funcţiune Bloc';
$lang['Function_desc']				= 'Descripţie';
$lang['Function_file']				= 'Fişier ';
$lang['Function_admin_file']       	= 'Fişier (Script Editare Bloc) <br /> Parametrii extra pentru acest panou editare bloc. Lasă blank (gol) pentru a folosi panoul de editare implicit.';
$lang['Create_function']			= 'Funcţiune Editare Bloc Nou';
$lang['Delete_function']			= 'Funcţiune Ştergere Block';
$lang['Delete_function_explain']	= 'Acesta va şterge funcţiunea şi toate blocurile portalului asociate. Atenţie, această operaţie nu este reversibilă!';
$lang['Click_function_delete_yes']	= 'Click %sAici%s pt. a şterge Funcţiunea';

$lang['Parameter_admin']			= 'Administrare Parametru Funcţiune';
$lang['Parameter_admin_explain']	= 'Listează toţi Parametrii pt. această Funcţiune';
$lang['Parameter']					= 'Parametru';
$lang['Parameter_name']				= '<b>Nume Parametru</b><br />- pt. a fi folosit pt. a accesa parametru';
$lang['Parameter_type']				= '<b>Tip Parametru</b>';
$lang['Parameter_desc'] 			= "<b>Decriere Parametru</b>";
$lang['Parameter_default']			= '<b>Valoare Implicită</b>';
$lang['Parameter_function']			= '<b>Funcţiune/Opţiuni</b>';
$lang['Parameter_function_explain']	= '<b>Funcţiune</b> (când foloseşti tipul \'Funcţiune\')<br />- Poţi pasa data parametrului la o funcţiune externă <br /> pt. a genera câmpul form al parametrului.<br />- De exemplu: <br />get_list_formatted(\"block_list\",\"{parameter_value}\",\"{parameter_id}[]\")';
$lang['Parameter_function_explain']	.= '<br /><br /><b>Opţiune(s)</b> (când foloseşti \'Selecţie\' tipuri parametri)<br />- Pentru toţi parametri selecţiei (butoane radio, boxe verificare şi meniuri) toate opţiunile sunt listate aici, o opţiune per linie.';
$lang['Parameter_auth']				= '<b>Admin/Bloc şi Moderatori numai</b>';

$lang['Parameters']					= 'Parametrii';
$lang['Parameter_id']				= 'ID';
$lang['Create_parameter']			= 'Adaugă Parametru Nou';
$lang['Delete_parameter']			= 'Şterge Funcţiune Parametru';
$lang['Delete_parameter_explain']	= 'Acesta va şterge parametru şi va actualiza toate blocurile portalului asociate. Atenţie, această operaţie nu este reversibilă!';
$lang['Click_parameter_delete_yes']	= 'Click %sAici%s pentru a şterge Parametru';

/*
* Parameter Types
*/
$lang['ParType_BBText'] 			= 'Simplu BBText BlocText';
$lang['ParType_BBText_info'] 		= 'Acesta este un simplu bloctext, permite bbcod-uri';
$lang['ParType_Html'] 				= 'Simplu Html BlocText';
$lang['ParType_Html_info'] 			= 'Acesta este un simplu bloctext, permite html';
$lang['ParType_Text'] 				= 'Text Obişnuit (singur-rând)';
$lang['ParType_Text_info'] 			= 'Acesta este un simplu câmp de text';
$lang['ParType_TextArea'] 			= 'Zona Text Obişnuit (multiple-rânduri)';
$lang['ParType_TextArea_info'] 		= 'Acesta este o simplă zonă câmp de text';
$lang['ParType_Boolean'] 			= 'Boolean';
$lang['ParType_Boolean_info'] 		= 'Acesta este un \'da\' sau \'nu\' comutator radio.';
$lang['ParType_Number'] 			= 'Număr Obişnuit';
$lang['ParType_Number_info'] 		= 'Acesta este un simplu câmp de numar';
$lang['ParType_Function'] 			= 'Funcţie Parametru';
$lang['ParType_Values'] 			= 'Valori';

$lang['ParType_Radio_single_select'] 			= 'Singur-Selecţie Buton Radio';
$lang['ParType_Radio_single_select_info'] 		= '';
$lang['ParType_Menu_single_select'] 			= 'Singur-Selecţie Meniu';
$lang['ParType_Menu_single_select_info'] 		= '';
$lang['ParType_Menu_multiple_select'] 			= 'Multiplu-Selecţie Meniu';
$lang['ParType_Menu_multiple_select_info'] 		= '';
$lang['ParType_Checkbox_multiple_select'] 		= 'Multiplu-Selecţie Boxă Verificare';
$lang['ParType_Checkbox_multiple_select_info'] 		= '';

/*
* Blocks Administration
*/
$lang['Block_admin']				= 'Panou de Contol Bloc';
$lang['Block_admin_explain']		= 'Foloseşte acest form pentru a administra Blocurile Portalului.<br /><b>Pentru a folosi acest panou, trebuie să ai JavaScript şi cooki-urile activate în browser!</b>';
$lang['Block']						= 'Bloc';
$lang['Show_title']					= 'Arata Titlu Bloc?';
$lang['Show_title_explain']			= 'Dacă ori nu se arată titlul blocului';
$lang['Show_block']					= 'Arată Bloc?';
$lang['Show_block_explain']			= '- Daca \'nu\', Blocul este ascuns pt. toţi utilizatorii, exceptând administratorii';
$lang['Show_stats']					= 'Arată Statistice?';
$lang['Show_stats_explain']			= '- Daca \'da\', \'editat de...\' va fi afişat langă bloc';
$lang['Show_blocks']               	= 'Vizualizeză Funcţia Blocurilor';
$lang['Block_delete']				= 'Şterge un Bloc';
$lang['Block_delete_explain']		= 'Foloseşte acest form pt. a şterge un Bloc (ori coloană)';
$lang['Block_title']				= 'Titlu';
$lang['Block_desc']					= 'Descripţie';
$lang['Add_Block']					= 'Adaugă Bloc Nou';
$lang['Auth_Block']					= 'Permisii';
$lang['Auth_Block_explain']			= 'TOŢI: Toţi utilizatorii<br />REG: utilizatori Înregistraţi<br />PRIVAT: Memberi Grup (vezi permisiile avansate)<br />MOD: bloc moderatori (vezi permisiile avansate)<br />ADMIN: Admin<br />ANONYMOUS: NUMAI utilizatori vizitatori';
$lang['Block_quick_stats']			= 'Statistice Rapid';
$lang['Block_quick_edit']			= 'Editare Rapidă';
$lang['Create_block']				= 'Creare Bloc Nou';
$lang['Delete_block']				= 'Şterge Bloc din Portal';
$lang['Delete_block_explain']		= 'Acesta va şterge blocul şi va actualiza toate paginile portalului asociate. Atenţie, această operaţie nu este reversibilă!';
$lang['Click_block_delete_yes']		= 'Click %sAici%s pt. a şterge Blocul';

/*
* BlockCP Administration
*/
$lang['Block_cp']                   	= 'BlockCP';
$lang['Click_return_blockCP_admin']		= 'Click %sAici%s pt. întoarcere la Panoul de Control Bloc';
$lang['Click_return_portalpage_admin']	= 'Click %sAici%s pt. întoarcere la Pagina Portalului';
$lang['BlockCP_Config_updated']			= 'Blocul a fost Actualizat...';


/*
* Pages Administration
*/
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

/*
* Page templates
*/
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

/*
* Pages Administration
*/
$lang['Page_admin']				= 'Administraţia Paginii';
$lang['Page_admin_explain']		= 'Foloseşte acest form pt. a adăuga, şterge şi schimba setarile pentru Paginile Portalului şi Paginile Templaturi.<br /><b>Pentru a folosi acest panou, trebuie să ai JavaScript şi cooki-urile activate în browser!</b>';
$lang['Page_admin_edit']		= 'Editare Pagina';
$lang['Page_admin_private']		= 'Pagina Avansată (PRIVAT) Permisii';
$lang['Page_admin_settings']	= 'Setari Pagină';
$lang['Page_admin_new_page']	= 'Administraţie Pagina Noua';
$lang['Page']					= 'Pagină';
$lang['Page_Id']				= 'ID Pagină';
$lang['Page_icon']				= 'Iconiţa Paginii <br /> - pt. a fi folosită numai în AdminCP, ex. icon_home.gif (implicit)';
$lang['Page_header']			= 'Fişier Header Pagina <br /> - de ex. overall_header.tpl (implicit), overall_noheader.tpl (fară header) ori fişier header custom a utilizatorului.';
$lang['Auth_Page']				= 'Permisii';
$lang['Select_sort_method']		= 'Selectează Metoda de Sortare';
$lang['Order']					= 'Ordine';
$lang['Sort']					= 'Sortare';
$lang['Width'] 					= 'Lăţime';
$lang['Height'] 				= 'Înălţime';
$lang['Page_sort_title']		= 'Titlu pagină';
$lang['Page_sort_desc']			= 'Descripţie pagină';
$lang['Page_sort_created']		= 'Pagina creată';
$lang['Sort_Ascending']			= 'ASC';
$lang['Sort_Descending']		= 'DESC';
$lang['Return_to_page']			= 'Întoarcere la Pagina Portalului';
$lang['Auth_Page_group']		= '-> Grup PRIVAT';
$lang['Page_desc']				= 'Descripţie';
$lang['Page_graph_border']		= 'Grafică bordura paginii - fişier prefix';
$lang['Page_graph_border_explain']	= 'Pentru a folosi grafica bordurii în jurul Blocurilor, specifică prefixul pentru fişierele grafice aici. De exemplu, introdu \'border_\' pt. a folosi fişierele: border_1-1.gif, border_1-2.gif,..., border_3-3.gif pentru matricea de 3x3 cu imagini-gif. Lasă blank (gol) pt. a dezactiva grafica bordurii (implicit).';
$lang['Add_Page']					= 'Adaugă Pagina Noua';
$lang['Page_Config_updated']		= 'Configuraţia Paginii Actualizată cu Succes';
$lang['Click_return_page_admin']	= 'Click %sAici%s pt. întoarcere la Administratia Paginii';
$lang['Remove_block']				= 'Scoate Bloc al Portalului';
$lang['Remove_block_explain']		= 'Acesta va scoate blocul din acestă pagina. Atenţie, acestă operaţie nu este reversibilă!';
$lang['Click_block_remove_yes']		= 'Click %sAici%s pt. a scoate Blocul';
$lang['Delete_page']				= 'Şterge Pagina';
$lang['Delete_page_explain']		= 'Acesta va şterge Pagina. Atenţie, acestă operaţie nu este reversibilă!';
$lang['Click_page_delete_yes']		= 'Click %sAici%s pt. a şterge Pagina';

$lang['Mx_IP_filter']				= 'Filtru IP';
$lang['Mx_IP_filter_explain']		= 'Pentru a restrictiona accesul la acestă pagina după IP, introdu adresele IP valide - o adresă IP per linie.<br>Ex. 127.0.0.1 ori 127.1.*.*';
$lang['Mx_phpBB_stats']				= 'phpBB Statistice în Header';
$lang['Mx_phpBB_stats_explain']		= '- linkuri la postari noi/necitite etc';
$lang['Column_admin']				= 'Administraţie Coloane Pagină';
$lang['Column_admin_explain']		= 'Administrează Coloanele Paginii';
$lang['Column']						= 'Coloana Paginii';
$lang['Columns']					= 'Coloanele Paginii';
$lang['Column_block']				= 'Bloc Coloană Pagină';
$lang['Column_blocks']				= 'Blocuri Coloana Paginii';
$lang['Edit_Column']				= 'Editează o Coloană';
$lang['Edit_Column_explain']		= 'Foloseşte acest form pt. a modifica o coloană';
$lang['Column_Size']				= 'Mărimea coloanei';
$lang['Column_name']				= 'Nume Coloană';
$lang['Column_delete']				= 'Şterge o Coloană';
$lang['Page_updated']				= 'Informaţia Paginii şi Coloanei Actualizată cu Succes';
$lang['Create_column']				= 'Adaugă Coloană Nouă';
$lang['Delete_page_column']			= 'Şterge Coloana Paginii';
$lang['Delete_page_column_explain']		= 'Acesta va şterge Coloana Paginii. Atenţie, acestă operaţie nu este reversibilă!';
$lang['Click_page_column_delete_yes']	= 'Click %sAici%s pt. a şterge Colana Paginii';


$lang['Add_Split_Block'] 			= 'Add Split Column Block';
$lang['Add_Split_Block_explain'] 	= 'This block splits the column';
$lang['Add_Dynamic_Block'] 			= 'Add Dynamic (Sub) Block';
$lang['Add_Dynamic_Block_explain'] 	= 'This dynamic block defines subpages, set from the navigation menu';
$lang['Add_Virtual_Block'] 			= 'Add Virtual (Page Blog) Block';
$lang['Add_Virtual_Block_explain'] 	= 'This block turns the page into a virtual (blog) page';

/*
* Page templates
*/
$lang['Page_templates_admin']			= 'Administartie Templaturi Pagină';
$lang['Page_templates_admin_explain'] 	= 'Foloseşte acesta pt. a crea, edita ori şterge Templaturi';
$lang['Page_template']					= 'Template Pagină';
$lang['Page_templates']					= 'Templaturi Pagină';
$lang['Page_template_column']			= 'Coloană Template Pagină';
$lang['Page_template_columns']			= 'Coloane Template Pagină';
$lang['Choose_page_template']			= 'Alege Templatul Paginii';
$lang['Template_Config_updated']		= 'Configuraţia Templetului a fost Actualizată';
$lang['Add_Template']					= 'Adaugă Template Nou';
$lang['Template']						= 'Template';
$lang['Template_name']					= 'Nume Template';
$lang['Page_template_delete']			= 'Şterge Template';
$lang['Delete_page_template']			= 'Şterge Pagină Template';
$lang['Delete_page_template_explain']	= 'Acesta va şterge Templatul Paginii. Atenţie, acestă operaţie nu este reversibilă!';
$lang['Click_page_template_delete_yes']	= 'Click %sAici%s pt. a şterge Templatul Paginii';
$lang['Delete_page_template_column']	= 'Şterge Pagina Template';
$lang['Delete_page_template_column_explain']	= 'Acesta va şterge Templatul Paginii. Atenţie, acestă operaţie nu este reversibilă!';
$lang['Click_page_template_column_delete_yes']	= 'Click %sAici%s pt. a şterge Templatul Paginii';

/*
* Cache
*/
$lang['Cache_dir_write_protect']	= 'Directorul tau cache este protejat la scriere. Nu s-a putut genera fişierul cache';
$lang['Cache_generate']				= 'Fişierele cache au fost generate.';
$lang['Cache_submit']				= 'Să generez fişierul cache?';
$lang['Cache_explain']				= 'Cu acestă opţiune poţi să generezi toate fişierele XML (fişiere cache) odată pentru toate blocurile portalului. Aceste fişiere permit reducerea numărului de cereri ale bazei de date necesare şi îmbunătăţesc performanţa portalului. <br />Notează: MXP cache trebuie activat (în Portal General Admin CP) petru ca aceste fişiere să fie folosite de sistem.<br>Mai Notează: fişierele cache sunt create on the fly când sunt şi blocurile de editare la fel.';
$lang['Generate_mx_cache']			= 'Generează Bloc Cache';

/*
* These are displayed in the drop down boxes for advanced
* mode Module auth, try and keep them short!
*/
$lang['Menu_Navigation']			= 'Meniu Navigare';
$lang['Portal_index']				= 'Index Portal';
$lang['Save_Settings']				= 'Salvare Setări';
$lang['Translation_Tools']			= 'Unelte de Traducere';
$lang['Preview_portal']				= 'Previzualizare Portal';

/*
* META
*/
$lang['Meta_admin']					= 'Administratie Meta Taguri';
$lang['Mega_admin_explain']			= 'Foloseste acest form să customizezi meta tagurile tale';
$lang['Meta_Title']					= 'Titlu';
$lang['Meta_Author']				= 'Autor';
$lang['Meta_Copyright']				= 'Copyright';
$lang['Meta_ImageToolBar'] 			= 'Image ToolBar';
$lang['Meta_Distribution'] 			= 'Distribution';
$lang['Meta_Keywords']				= 'Cuvinte Cheie';
$lang['Meta_Keywords_explain']		= '(lista separată de virgulă)';
$lang['Meta_Description']			= 'Descripţie';
$lang['Meta_Language']				= 'Cod Limbă';
$lang['Meta_Rating']				= 'Clasare';
$lang['Meta_Robots']				= 'Robots';
$lang['Meta_Pragma']				= 'Pragma no-cache';
$lang['Meta_Bookmark_icon']			= 'Bookmark Iconiţă';
$lang['Meta_Bookmark_explain']		= '(locaţie relativă)';
$lang['Meta_HTITLE']				= 'Setări Extra Header';
$lang['Meta_data_updated']			= 'Fişierul de date meta (mx_meta.inc) a fost actualizat!<br />Click %sAICI%s pt. intoarcere la Administraţie Meta Taguri.';
$lang['Meta_data_ioerror']			= 'Nu se poate deschide mx_meta.inc. Asigurăte că fişierul e writabil (chmod 777).';

/*
* Portal permissons
*/
$lang['Mx_Block_Auth_Title']		= 'Permisii Bloc Privat';
$lang['Mx_Block_Auth_Explain']		= 'Aici poti să configurezi Permisiile Blocului Privat';
$lang['Mx_Page_Auth_Title']			= 'Permisii Pagina Privată';
$lang['Mx_Page_Auth_Explain']		= 'Aici poţi să configurezi Permisiile Paginii Private';
$lang['Block_Auth_successfully']	= 'Permisiunile Blocului Actualizate cu Succes';
$lang['Click_return_block_auth']	= 'Click %sAici%s pt. întoarcere la Permisii Bloc Privat';
$lang['Page_Auth_successfully']		= 'Permisiunile Paginii Actualizate cu Succes';
$lang['Click_return_page_auth']		= 'Click %sAici%s pt. întoarcere la Permisii Pagina Privata';
$lang['AUTH_ALL']					= 'TOŢI';
$lang['AUTH_REG']					= 'REG';
$lang['AUTH_PRIVATE']				= 'PRIVAT';
$lang['AUTH_MOD']					= 'MOD';
$lang['AUTH_ADMIN']					= 'ADMIN';
$lang['AUTH_ANONYMOUS']				= 'ANONYMOUS';

/* -----------------------------------/
* BlockCP - Block Parameter Specific/
* ----------------------------------- */

/*
* General
*/
$lang['target_block']				= 'Bloc Ţinta';
$lang['target_block_explain']		= '- linkuri, date etc sunt referite cu acest bloc';

/*
* Split column
*/
$lang['block_ids']					= 'Blocuri Sursă';
$lang['block_ids_explain']			= '- să fie poziţionate stânga spre dreapta';
$lang['block_sizes']				= 'Marimi Bloc (separate de virgulă)';
$lang['block_sizes_explain']		= '- Poţi specifica mărimile folosind numere (pixeli), procente (mărimi relative, de ex. "40%") ori "*" pentru remainder.';
$lang['space_between']				= 'Spaţiu între blocuri';

/*
* Sitelog
*/
$lang['log_filter_date']			= 'Filtru după timp';
$lang['log_filter_date_explain']	= '- Arată loguri din săptămâna trecută, luna, anul...';
$lang['numOfEvents']				= 'Număr';
$lang['numOfEvents_explain']		= '- Număr evenimente de arătat';

/*
* IncludeX
*/
$lang['x_listen']					= 'Ascultă (GET)';
$lang['x_iframe']					= 'IFrame';
$lang['x_textfile']					= 'Fişier Text';
$lang['x_multimedia']				= 'WMP Multimedia';
$lang['x_pic']						= 'Pictură';
$lang['x_format']					= 'Fişier text formatat';
$lang['x_mode']						= 'IncludeX mode:';
$lang['x_mode_explain']				= '- Blocul IncludeX operează în unul din urmatoarele moduri. Dacă modul \'Ascultă (GET)\' este selectat, modul pote fi setat de un url \'x_mode=mode\' şi parametrul asociat cu \'x_1=, x_2=, etc\'.<br />Exemplu: Pentru a trimite un url la iframe foloseşte \'domain/index.php?page=x&x_mode=iframe&x_1=http://domain\'  ';
$lang['x_1']						= 'Variabila 1:';
$lang['x_1_explain']				= '- <i>IFrame:</i> url<br /><i>FişierText:</i> cale relativă din radacină (ex în \'/include_file/my_file.xxx\')<br /><i>Multimedia:</i> cale relativă din radacină (ex în \'/include_file/my_file.xxx\')<br /><i>Pic:</i> cale relativă din radacină (ex în \'/include_file/my_file.xxx\')<br /><i>Fişier Text Formatat:</i> indisponibil';
$lang['x_2']						= 'Variabila 2:';
$lang['x_2_explain']				= '- <i>IFrame:</i> înaltime frame (pixeli)<br /><i>Multimedia:</i> lăţime (pixeli)';
$lang['x_3']						= 'Variabila 3:';
$lang['x_3_explain']				= '- <i>Multimedia:</i> înaltime (pixeli)';

/*
* Announcement
*/
$lang['announce_nbr_display']		= 'Număr Maxim de Mesaje care să fie Afişate';
$lang['announce_nbr_days']			= 'Număr de Zile în care se Afişeaza Mesaje';
$lang['announce_img']				= 'Imagine Anunţuri';
$lang['announce_img_sticky']		= 'Imagine Lipicioasă';
$lang['announce_img_normal']		= 'Imagine Mesaj Normal';
$lang['announce_img_global']		= 'Imagine Anunţuri Globale';
$lang['announce_display']			= 'Afişează Mesaje Anunţ(uri) în acest Bloc';
$lang['announce_display_sticky']	= 'Afisează Lipicios(asă) în acest Bloc';
$lang['announce_display_normal']	= 'Afisează Mesaj(e) Normale în acest Bloc';
$lang['announce_display_global']	= 'Afisează Anunţurile Globale în acest Bloc';
$lang['announce_forum']				= 'Forumuri Sursă';
$lang['announce_forum_explain']		= '- Poţi face selecţii multiple<br />* Dacă nu este selectat nimic, toate forumurile autorizate vor fi vizibile';

/*
* Polls
*/
$lang['Poll_Display']				= 'Care urnă vrei să o afişezi?';
$lang['poll_forum']					= 'Forumuri Sursă';
$lang['poll_forum_explain']			= '- Poţi face selecţii mutiple<br />* Dacă nimic nu este selectat, toate forumurile autorizate vor fi vizibile';
$lang['Not_Specified']				= 'Ne Specificat';

/*
* Dynamic Block
*/
$lang['default_block_id']			= 'Bloc Implicit';
$lang['default_block_id_explain']	= '- Acesta este blocul implicit de afişat, exceptând dacă un bloc dinamic este selectat';

/*
* Menu Navigation
*/
$lang['menu_display_mode']			= 'Mod Plan';
$lang['menu_display_mode_explain ']	= 'Mod plan Orizonal ori Vertical';
$lang['menu_page_sync']				= 'Lumineză cel curent?';
$lang['menu_page_sync_explain']		= 'Lumineză intrare la Meniul de Nav. curent...';

/*
* Version Checker
*/
$lang['MXP_Version_up_to_date'] = 'Instalarea MXP este la zi. Nu există actualizări pentru versiunea ta de MXP.';
$lang['MXP_Version_outdated'] = 'Se pare ca instalarea ta MXP <b>nu</b> este la zi. Actualizări există pentru versiunea ta de MXP. Te rog viziteză <a href="http://mxpcms.sourceforge.net/index.php?page=4&action=file&file_id=2" target="_new">downloadare pachetul MXP Core</a> pt. a obţine ultima versiune.';
$lang['MXP_Latest_version_info'] = 'Ultima veriune disponibilă este <b>MXP %s</b>. ';
$lang['MXP_Current_version_info'] = 'Tu ai <b>MXP %s</b>.';
$lang['MXP_Mailing_list_subscribe_reminder'] = 'Pentru ultimile informaţii de ştiri şi actualizări pentru MXP, de ce nu <a href="http://lists.sourceforge.net/lists/listinfo/mxpcms-news" target="_new">înscriete la lista de mailuri</a>.';

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