<?php
/**
*
* @package mxBB Portal Core
* @version $Id: lang_admin.php,v 1.3 2008/06/18 17:53:07 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// Editor Settings: Please set Tabsize to 4 ;-)
// 

//
// The formata of this file is:
//
// ---> $lang["message"] = 'text';
//
// Specify your language character encoding... [optional]
//
setlocale(LC_ALL, "ro");

$lang['mxBB_adminCP']				= 'mxBB-Portal Administratie';	

//
// Left AdminCP Panel
//
$lang['1_General_admin']		= 'General';
$lang['1_1_Management']			= 'Configuratie';
$lang['1_2_WordCensors'] 		= 'Cenzori de cuvinte';

$lang['2_CP']					= 'Management';
$lang['2_1_Modules']			= 'Instalare Module <br /><hr>';
$lang['2_2_ModuleCP']			= 'Panou de Control Module';
$lang['2_3_BlockCP']			= 'Panou de Control Bloc';
$lang['2_4_PageCP']				= 'Panou de Control Pagin';

$lang['3_CP'] 					= 'Stiluri';
$lang['2_1_new'] 				= 'Adauga nou';
$lang['2_2_manage'] 			= 'Configureaza';
$lang['2_3_smilies'] 			= 'Emoticoane';
$lang['4_Panel_system']			= 'Unelte Sistem';
$lang['4_1_Cache']				= 'Regenereaza Cache-ul';
$lang['4_1_Integrity']			= 'Verificator Integritate';
$lang['4_1_Meta']				= 'Taguri META';
$lang['4_1_PHPinfo']			= 'phpInfo()';
$lang['4_2_Translate'] 			= 'Panou de Control Traduceri';


//
// Index
//
$lang['Welcome_mxBB'] 				= 'Bine ati venit la panoul de control al portalului mxBB';
$lang['Admin_intro_mxBB'] 			= 'Va multumim pentru ati ales mxBB-Portal ca solutie pentru portalul/cms-ul dumneavoastra si phpBB ca solutie pentru forumul dumneavoastra. Acest ecran va ofera o privire de ansamblu a diverselor statistici ale site-ului dumneavoastra. Puteti reveni la aceasta pagina folosind legatura <span style="text-decoration: underline;">Pagina de start a administratorului</span> din panel-ul stang. Pentru a reveni la pagina de start a forumului dumneavoastra, apasati pe logo-ul phpBB-ului aflat, de asemenea, in panel-ul stang. Celelalte legaturi din partea stanga va permit sa controlati orice aspect al forumului, fiecare ecran va avea instructiuni care dau explicatii despre cum se folosesc uneltele.';

//
// General
//
$lang['Yes']						= 'Da';
$lang['No']							= 'Nu';
$lang['No_modules']					= 'Nici un Modul instalat';
$lang['No_functions']				= 'Acest modul nu are functii bloc';
$lang['No_parameters']				= 'Aceasta functie nu are parametri';
$lang['No_blocks']					= 'Nici un bloc nu a fost creat pentru aceasta functie';
$lang['No_pages']					= 'Nici o pagina nu a fost creata';
$lang['No_settings']				= 'Nu mai exista setari pentru acest bloc';
$lang['Quick_nav']					= 'Navigare Quick-Rapida';
$lang['Include_all_modules']		= 'Listeaza toate modulele';
$lang['Include_block_quickedit']	= 'Include Blocul Panoul Quickedit';
$lang['Include_block_private']		= 'Include Blocul Panoul Autentificare Prv';
$lang['Include_all_pages']			= 'Liseaza toate paginile';
$lang['View']						= 'Vizualizeza';
$lang['Edit']						= 'Editeaza';
$lang['Delete']						= 'sterge';
$lang['Settings']					= 'Setari';
$lang['Move_up']					= 'Muta in sus';
$lang['Move_down']					= 'Muta in jos';
$lang['Resync']						= 'Resinc';
$lang['Update']						= 'Actualizare';
$lang['Permissions']				= 'Permisii';
$lang['Permissions_std']			= 'Permisii Standard';
$lang['Permissions_adv']			= 'Permisii Avansate';
$lang['return_to_page']				= 'inapoi la Pagina Portalului';
$lang['Use_default'] 				= 'Foloseste setari implicite';

$lang['AdminCP_status']				= '<b>Raport Progres</b>';
$lang['AdminCP_action']				= '<b>Actiune DB</b>';
$lang['Invalid_action']				= 'Eroare';
$lang['was_installed']             	= 'a fost instalat';
$lang['was_uninstalled']           	= 'a fost dezinstalat';
$lang['was_upgraded']              	= 'a fost upgradat';
$lang['was_exported']               = 'a fost exportat';
$lang['was_deleted']               	= 'a fost sters';
$lang['was_removed']               	= 'a fost scos';
$lang['was_inserted']              	= 'a fost inserat';
$lang['was_updated']               	= 'a fost actualizat';
$lang['was_added']                 	= 'a fost adaugat';
$lang['was_moved']                 	= 'a fost mutat';
$lang['was_synced']                	= 'a fost sincronizat';

$lang['error_no_field']				= 'Este un camp lipsa. Te rog complecteza toate campurile necesare...';

//
// Configuration
//
$lang['Portal_admin']						= 'Administratia Portalului';
$lang['Portal_admin_explain']				= 'Foloseste acest form pt. a customiza portalul tau';
$lang['Portal_General_Config']				= 'Configuratie Portal';
$lang['Portal_General_settings']			= 'Setari Generale';
$lang['Portal_Style_settings'] 				= 'Setari Stiluri';
$lang['Portal_General_config_info']			= 'Info General Configurare Portal ';
$lang['Portal_General_config_info_explain'] 	= 'Postata informatii instalare din fisierul config.php (nu e nevoie de editare)';
$lang['Portal_Name']					= 'Nume Portal:';
$lang['Portal_PHPBB_Url']				= 'URL pt. instarea ta de forum phpBB:';
$lang['Portal_Url']						= 'URL pentru mxBB-Portal:';
$lang['Portal_Config_updated']				= 'Configuratia Portalului Actualizata cu Succes';
$lang['Click_return_portal_config']			= 'Click %sAici%s pentru a te intoarce la Configurarea Portalului';
$lang['PHPBB_info']						= 'Informatii phpBB';
$lang['PHPBB_version']					= 'Versiunea phpBB:';
$lang['PHPBB_script_path']				= 'phpBB Cale Script:';
$lang['PHPBB_server_name']				= 'phpBB Domeniu (nume_server):';
$lang['MX_Portal']						= 'mxBB-Portal';
$lang['MX_Modules']						= 'mxBB-Module';
$lang['Phpbb']							= 'phpBB';
$lang['Top_phpbb_links']				= 'phpBB Stats in Header (valoare impicita)<br /> - linkuri la postari noi/necitite etc';
$lang['Portal_version']					= 'Versiune mxBB-Portal:';
$lang['Mx_use_cache']					= 'Foloseste mxBB Bloc Cache';
$lang['Mx_use_cache_explain']			= 'Datele din Bloc este in fisiere individuale cache/bloc_*.xml. Fisierele Bloc cache sunt create cand Blocurile sunt editate.';
$lang['Mx_mod_rewrite'] 				= 'Foloseste mod_rewrite';
$lang['Mx_mod_rewrite_explain'] 		= 'Daca esti pe server Apache, si ai mod_rewrite activat, poti rescrie url-urile ca \'page=x\' cu alternative mai intuitive. Citeste pentru mai multe documentatia pentru modulul mx_mod_rewrite.';

$lang['Portal_Overall_header'] 					= 'Fisier Overall Header (valoare impicita)';
$lang['Portal_Overall_header_explain'] 			= '- Aceasta este valoarea implicita a fisierului overall_header, e.g. overall_header.tpl.';

$lang['Portal_Overall_footer'] 					= 'Fisier Overall Footer (valoare impicita)';
$lang['Portal_Overall_footer_explain'] 			= '- Aceasta este valoarea implicita a fisierului overall_footer, e.g. overall_footer.tpl.';

$lang['Portal_Main_layout'] 					= 'Fisier Main Layout (valoare impicita)';
$lang['Portal_Main_layout_explain'] 			= '- This is the default template main_layout file, e.g. mx_main_layout.tpl.';
$lang['Portal_Navigation_block'] 				= 'Overall Header Navigation Block (valoare impicita)';
$lang['Portal_Navigation_block_explain'] 		= '- This is the default template overall_header navigation block.';

$lang['Default_style'] = 'Style Pagini Portal (implicit)';
$lang['Default_admin_style'] = 'Style AdminCP';
$lang['Select_page_style'] = 'Selecteaza (ori foloseste implicit)';
$lang['Override_style'] = 'Supracrie stilul utilizatorului';
$lang['Override_style_explain'] = 'inlocuieste stilul utilizatorului cu cel implicit (pentru pagini)';

$lang['Portal_status'] = 'Stare Portal';
$lang['Portal_status_explain'] = 'Un switch, cand reconstruiti website-ul. Doar administratorul poate sa vada paginile si sa navigheze normal. Cand e dezactivat mesajul de mai jos va fi afisat.';
$lang['Disabled_message'] = 'Mesaj cand portalul e dezactivat';

$lang['Portal_Backend'] = 'Utilizator Intern/Sesiune Backend';
$lang['Portal_Backend_explain'] = 'Selecteaza intern, phpBB2 sau phpBB3 sessiuni si utilizatori';
$lang['Portal_Backend_path'] = 'Cale relativa pentru phpBB [non-intern]';
$lang['Portal_Backend_path_explain'] = 'Daca folositi sessiuni si utilizatori non-interne, introduceti calea relativa catre phpbb, ex \'phpBB2/\' sau \'../phpBB2/\'. Nota: slasurile sunt importante.';
$lang['Portal_Backend_submit'] = 'Modifica si valideaza Backendul';
$lang['Portal_config_valid'] = 'Statut Backend Curent: ';
$lang['Portal_config_valid_true'] = '<b><font color=\"green\">Valid</font></b>';
$lang['Portal_config_valid_false'] = '<b><font color=\"red\">Instalare Invalida. Sau calea catre phpBB este gresita ori phpBB nu este instalat (baza de date phpBB nu este disponibila). Deci, este folosit backend \'intern\'.</font></b>';


//
// Module Management
//
$lang['Module_admin']				= 'Administratie Module';
$lang['Module_admin_explain']		= 'Foloseste acest form pentru a administra modulele: instalare, upgradare si dezvoltare module.<br /><b>Pentru a folosi acest panou, trebuie sa ai JavaScript si cooki-urile activate in browser!</b>';
$lang['Modulecp_admin']				= 'Panou de Control Module';
$lang['Modulecp_admin_explain']		= 'Foloseste acest form pentru a administra modulele: functii bloc (parametrii) si blocuri portal.<br /><b>Pentru a folosi acest panou, trebuie sa ai JavaScript si cooki-urile activate in browser!</b>';
$lang['Modules']					= 'Module';
$lang['Module']						= 'Modul';
$lang['Module_delete']				= 'sterge un Modul';
$lang['Module_delete_explain']		= 'Foloseste acest form pentru a sterge un Modul (sau functie bloc)';
$lang['Edit_module']				= 'Editeaza un Modul';
$lang['Create_module']				= 'Creaza Modul Nou';
$lang['Module_name']				= 'Nume Modul';
$lang['Module_desc']				= 'Descriptie';
$lang['Module_path']				= 'Cale, ex: \'modules/mx_textblocks/\'';
$lang['Module_include_admin']		= 'Include acest modul in panoul din stanga Navigare Admin Meniu';

//
// Module Installation
//
$lang['Module_delete_db']			= 'Chiar vrei sa dezinstalezi acest Modul? Atentie: O sa pierzi tote datele modulului. Considera upgradare in loc...';
$lang['Click_module_delete_yes']	= 'Click %sAici%s pt. a dezinstala modulul';
$lang['Click_module_upgrade_yes']	= 'Click %sAici%s pt. a upgrada modulul';
$lang['Click_module_export_yes']	= 'Click %sAici%s pt. a exporta modulul';
$lang['Error_no_db_install']		= 'Eroare: Fisierul db_install.php nu exista. Te rog verifica si incearca din nou...';
$lang['Error_no_db_uninstall']		= 'Eroare: Fisierul db_uninstall.php nu exista, sau functia de dezinstalare nu este suportata in acest modul. Te rog verifica aceasta si incearca din nou...';
$lang['Error_no_db_upgrade']		= 'Eroare: Fisierul db_upgrade.php nu exista, sau funtia de upgradare nu este suportata in acest modul. Te rog verifica aceasta si incearca din nou...';
$lang['Error_module_installed']		= 'Eroare: Acest modul este deja instalat! Te rog inainte ori sterge modulul, ori upgradeaza modul.';
$lang['Uninstall_module']			= 'Dezinstaleaza Modul';
$lang['import_module_pack']			= 'Instaleaza Modul';
$lang['import_module_pack_explain']	= 'Aceasta va adauga un modul la portal. Asigurate ca Pachetul Modulului este uploadat in folderul /modules. tine minte sa folosesti unltima versiune de Modul!';
$lang['upgrade_module_pack']		= 'Upgradare Modul';
$lang['upgrade_module_pack_explain']	= 'Aceasta va upgrada modulul tau. Asigurate ca ai citit Documentatia Modulului inainte de a proceda, sau poti risca pierderi de date la modul.';
$lang['export_module_pack']			= 'Exportare Modul';
$lang['Export_Module']				= 'Selecteaza un Modul:';
$lang['export_module_pack_explain']	= 'Aceasta va exporta fisierul *.pak al modulului. Aceasta este intentat pentru scriitori de module numai...';
$lang['Module_Config_updated']		= 'Configuratia Modulului Actualizata cu Succes';
$lang['Click_return_module_admin']	= 'Click %sAici%s pt. a te intoarce la Administratie Module';
$lang['Module_updated']				= 'Informatiile Modulului Actualizate cu Succes';
$lang['list_of_queries'] = 'This is the result list of the SQL queries needed for the install/upgrade';
$lang['already_added'] = 'Error or Already added';
$lang['added_upgraded'] = 'Added/Updated';
$lang['upgrading_mods'] = 'If you get some Errors, Already Added or Updated messages, relax, this is normal when updating mods';
$lang['module_upgrade'] = 'This is a upgrade';
$lang['fresh_install'] = 'This is a fresh install';
$lang['module_install_info'] = 'Mod Installation/Upgrading/Uninstalling Information - mod specific db tables';

//
// Functions & Parameters Administration
//
$lang['Function_admin']					= 'Administratie Functiune Bloc';
$lang['Function_admin_explain']			= 'Modulele au una sau mai multe Functiuni Bloc. Foloseste acest form pt. a edita, si, sau sterge Functiunea unui Bloc';
$lang['Function']				= 'Functiune Bloc';
$lang['Function_name']				= 'Nume Functiune Bloc';
$lang['Function_desc']				= 'Descriptie';
$lang['Function_file']				= 'Fisier ';
$lang['Function_admin_file']       		= 'Fisier (Script Editare Bloc) <br /> Parametrii extra pentru acest panou editare bloc. Lasa blank (gol) pentru a folosi panoul de editare implicit.';
$lang['Create_function']			= 'Functiune Editare Bloc Nou';
$lang['Delete_function']			= 'Functiune stergere Block';
$lang['Delete_function_explain']		= 'Acesta va sterge functiunea si toate blocurile portalului asociate. Atentie, aceasta operatie nu este reversibila!';
$lang['Click_function_delete_yes']		= 'Click %sAici%s pt. a sterge Functiunea';

$lang['Parameter_admin']			= 'Administrare Parametru Functiune';
$lang['Parameter_admin_explain']		= 'Listeaza toti Parametrii pt. aceasta Functiune';
$lang['Parameter']				= 'Parametru';
$lang['Parameter_name']				= '<b>Nume Parametru</b><br />- pt. a fi folosit pt. a accesa parametru';
$lang['Parameter_type']				= '<b>Tip Parametru</b>';
$lang['Parameter_default']			= '<b>Valoare Implicita</b>';
$lang['Parameter_function']			= '<b>Functiune/Optiuni</b>';
$lang['Parameter_function_explain']		= '<b>Functiune</b> (cand folosesti tipul \'Functiune\')<br />- Poti pasa data parametrului la o functiune externa <br /> pt. a genera campul form al parametrului.<br />- De exemplu: <br />get_list_formatted(\"block_list\",\"{parameter_value}\",\"{parameter_id}[]\")';
$lang['Parameter_function_explain']		.= '<br /><br /><b>Optiune(s)</b> (cand folosesti \'Selectie\' tipuri parametri)<br />- Pentru toti parametri selectiei (butoane radio, boxe verificare si meniuri) toate optiunile sunt listate aici, o optiune per linie.';
$lang['Parameter_auth']				= '<b>Admin/Bloc si Moderatori numai</b>';

$lang['Parameters']					= 'Parametrii';
$lang['Parameter_id']					= 'ID';
$lang['Create_parameter']				= 'Adauga Parametru Nou';
$lang['Delete_parameter']				= 'sterge Functiune Parametru';
$lang['Delete_parameter_explain']			= 'Acesta va sterge parametru si va actualiza toate blocurile portalului asociate. Atentie, aceasta operatie nu este reversibila!';
$lang['Click_parameter_delete_yes']			= 'Click %sAici%s pentru a sterge Parametru';

//
// Parameter Types
//
$lang['ParType_BBText'] 			= 'Simplu BBText BlocText';
$lang['ParType_BBText_info'] 			= 'Acesta este un simplu bloctext, permite bbcod-uri';
$lang['ParType_Html'] 				= 'Simplu Html BlocText';
$lang['ParType_Html_info'] 			= 'Acesta este un simplu bloctext, permite html';
$lang['ParType_Text'] 				= 'Text Obisnuit (singur-rand)';
$lang['ParType_Text_info'] 			= 'Acesta este un simplu camp de text';
$lang['ParType_TextArea'] 			= 'Zona Text Obisnuit (multiple-randuri)';
$lang['ParType_TextArea_info'] 			= 'Acesta este o simpla zona camp de text';
$lang['ParType_Boolean'] 			= 'Boolean';
$lang['ParType_Boolean_info'] 			= 'Acesta este un \'da\' sau \'nu\' comutator radio.';
$lang['ParType_Number'] 			= 'Numar Obisnuit';
$lang['ParType_Number_info'] 			= 'Acesta este un simplu camp de numar';
$lang['ParType_Function'] 			= 'Functie Parametru';
$lang['ParType_Values'] 			= 'Valori';

$lang['ParType_Radio_single_select'] 			= 'Singur-Selectie Buton Radio';
$lang['ParType_Radio_single_select_info'] 		= '';
$lang['ParType_Menu_single_select'] 			= 'Singur-Selectie Meniu';
$lang['ParType_Menu_single_select_info'] 		= '';
$lang['ParType_Menu_multiple_select'] 			= 'Multiplu-Selectie Meniu';
$lang['ParType_Menu_multiple_select_info'] 		= '';
$lang['ParType_Checkbox_multiple_select'] 		= 'Multiplu-Selectie Boxa Verificare';
$lang['ParType_Checkbox_multiple_select_info'] 		= '';

//
// Blocks Administration
//
$lang['Block_admin']				= 'Panou de Contol Bloc';
$lang['Block_admin_explain']			= 'Foloseste acest form pentru a administra Blocurile Portalului.<br /><b>Pentru a folosi acest panou, trebuie sa ai JavaScript si cooki-urile activate in browser!</b>';
$lang['Block']					= 'Bloc';
$lang['Show_title']				= 'Arata Titlu Bloc?';
$lang['Show_title_explain']			= 'Daca ori nu se arata titlul blocului';
$lang['Show_block']				= 'Arata Bloc?';
$lang['Show_block_explain']			= '- Daca \'nu\', Blocul este ascuns pt. toti utilizatorii, exceptand administratorii';
$lang['Show_stats']				= 'Arata Statistice?';
$lang['Show_stats_explain']			= '- Daca \'da\', \'editat de...\' va fi afisat langa bloc';
$lang['Show_blocks']               		= 'Vizualizeza Functia Blocurilor';
$lang['Block_delete']				= 'sterge un Bloc';
$lang['Block_delete_explain']			= 'Foloseste acest form pt. a sterge un Bloc (ori coloana)';
$lang['Block_title']				= 'Titlu';
$lang['Block_desc']				= 'Descriptie';
$lang['Add_Block']				= 'Adauga Bloc Nou';
$lang['Auth_Block']				= 'Permisii';
$lang['Auth_Block_explain']			= 'TOtI: Toti utilizatorii<br />REG: utilizatori inregistrati<br />PRIVAT: Memberi Grup (vezi permisiile avansate)<br />MOD: bloc moderatori (vezi permisiile avansate)<br />ADMIN: Admin<br />ANONYMOUS: NUMAI utilizatori vizitatori';
$lang['Block_quick_stats']			= 'Statistice Rapid';
$lang['Block_quick_edit']			= 'Editare Rapida';
$lang['Create_block']				= 'Creare Bloc Nou';
$lang['Delete_block']				= 'sterge Bloc din Portal';
$lang['Delete_block_explain']			= 'Acesta va sterge blocul si va actualiza toate paginile portalului asociate. Atentie, aceasta operatie nu este reversibila!';
$lang['Click_block_delete_yes']			= 'Click %sAici%s pt. a sterge Blocul';

//
// BlockCP Administration
//
$lang['Block_cp']                   	= 'BlockCP';
$lang['Click_return_blockCP_admin']	= 'Click %sAici%s pt. intoarcere la Panoul de Control Bloc';
$lang['Click_return_portalpage_admin']	= 'Click %sAici%s pt. intoarcere la Pagina Portalului';
$lang['BlockCP_Config_updated']		= 'Blocul a fost Actualizat...';

//
// Pages Administration
//
$lang['Page_admin']			= 'Administratia Paginii';
$lang['Page_admin_explain']		= 'Foloseste acest form pt. a adauga, sterge si schimba setarile pentru Paginile Portalului si Paginile Templaturi.<br /><b>Pentru a folosi acest panou, trebuie sa ai JavaScript si cooki-urile activate in browser!</b>';
$lang['Page_admin_edit']		= 'Editare Pagina';
$lang['Page_admin_private']		= 'Pagina Avansata (PRIVAT) Permisii';
$lang['Page_admin_settings']		= 'Setari Pagina';
$lang['Page_admin_new_page']		= 'Administratie Pagina Noua';
$lang['Page']				= 'Pagina';
$lang['Page_Id']			= 'ID Pagina';
$lang['Page_icon']			= 'Iconita Paginii <br /> - pt. a fi folosita numai in AdminCP, ex. icon_home.gif (implicit)';
$lang['Page_header']			= 'Fisier Header Pagina <br /> - de ex. overall_header.tpl (implicit), overall_noheader.tpl (fara header) ori fisier header custom a utilizatorului.';
$lang['Auth_Page']			= 'Permisii';
$lang['Select_sort_method']		= 'Selecteaza Metoda de Sortare';
$lang['Order']				= 'Ordine';
$lang['Sort']				= 'Sortare';
$lang['Width'] 					= 'Latime';
$lang['Height'] 				= 'Inaltime';
$lang['Page_sort_title']		= 'Titlu pagina';
$lang['Page_sort_desc']			= 'Descriptie pagina';
$lang['Page_sort_created']		= 'Pagina creata';
$lang['Sort_Ascending']			= 'ASC';
$lang['Sort_Descending']		= 'DESC';
$lang['Return_to_page']			= 'intoarcere la Pagina Portalului';
$lang['Auth_Page_group']		= '-> Grup PRIVAT';
$lang['Page_desc']			= 'Descriptie';
$lang['Page_graph_border']		= 'Grafica bordura paginii - fisier prefix';
$lang['Page_graph_border_explain']	= 'Pentru a folosi grafica bordurii in jurul Blocurilor, specifica prefixul pentru fisierele grafice aici. De exemplu, introdu \'border_\' pt. a folosi fisierele: border_1-1.gif, border_1-2.gif,..., border_3-3.gif pentru matricea de 3x3 cu imagini-gif. Lasa blank (gol) pt. a dezactiva grafica bordurii (implicit).';
$lang['Add_Page']			= 'Adauga Pagina Noua';
$lang['Page_Config_updated']		= 'Configuratia Paginii Actualizata cu Succes';
$lang['Click_return_page_admin']	= 'Click %sAici%s pt. intoarcere la Administratia Paginii';
$lang['Remove_block']			= 'Scoate Bloc al Portalului';
$lang['Remove_block_explain']		= 'Acesta va scoate blocul din acesta pagina. Atentie, acesta operatie nu este reversibila!';
$lang['Click_block_remove_yes']		= 'Click %sAici%s pt. a scoate Blocul';
$lang['Delete_page']			= 'sterge Pagina';
$lang['Delete_page_explain']		= 'Acesta va sterge Pagina. Atentie, acesta operatie nu este reversibila!';
$lang['Click_page_delete_yes']		= 'Click %sAici%s pt. a sterge Pagina';

$lang['Mx_IP_filter']				= 'Filtru IP';
$lang['Mx_IP_filter_explain']			= 'Pentru a restrictiona accesul la acesta pagina dupa IP, introdu adresele IP valide - o adresa IP per linie.<br>Ex. 127.0.0.1 ori 127.1.*.*';
$lang['Mx_phpBB_stats']				= 'phpBB Statistice in Header';
$lang['Mx_phpBB_stats_explain']			= '- linkuri la postari noi/necitite etc';
$lang['Column_admin']				= 'Administratie Coloane Pagina';
$lang['Column_admin_explain']			= 'Administreaza Coloanele Paginii';
$lang['Column']					= 'Coloana Paginii';
$lang['Columns']				= 'Coloanele Paginii';
$lang['Column_block']				= 'Bloc Coloana Pagina';
$lang['Column_blocks']				= 'Blocuri Coloana Paginii';
$lang['Edit_Column']				= 'Editeaza o Coloana';
$lang['Edit_Column_explain']			= 'Foloseste acest form pt. a modifica o coloana';
$lang['Column_Size']				= 'Marimea coloanei';
$lang['Column_name']				= 'Nume Coloana';
$lang['Column_delete']				= 'sterge o Coloana';
$lang['Page_updated']				= 'Informatia Paginii si Coloanei Actualizata cu Succes';
$lang['Create_column']				= 'Adauga Coloana Noua';
$lang['Delete_page_column']			= 'sterge Coloana Paginii';
$lang['Delete_page_column_explain']		= 'Acesta va sterge Coloana Paginii. Atentie, acesta operatie nu este reversibila!';
$lang['Click_page_column_delete_yes']	= 'Click %sAici%s pt. a sterge Colana Paginii';

//
// Page templates
//
$lang['Page_templates_admin']			= 'Administartie Templaturi Pagina';
$lang['Page_templates_admin_explain'] 	= 'Foloseste acesta pt. a crea, edita ori sterge Templaturi';
$lang['Page_template']					= 'Template Pagina';
$lang['Page_templates']					= 'Templaturi Pagina';
$lang['Page_template_column']			= 'Coloana Template Pagina';
$lang['Page_template_columns']			= 'Coloane Template Pagina';
$lang['Choose_page_template']			= 'Alege Templatul Paginii';
$lang['Template_Config_updated']		= 'Configuratia Templetului a fost Actualizata';
$lang['Add_Template']					= 'Adauga Template Nou';
$lang['Template']						= 'Template';
$lang['Template_name']					= 'Nume Template';
$lang['Page_template_delete']			= 'sterge Template';
$lang['Delete_page_template']			= 'sterge Pagina Template';
$lang['Delete_page_template_explain']	= 'Acesta va sterge Templatul Paginii. Atentie, acesta operatie nu este reversibila!';
$lang['Click_page_template_delete_yes']	= 'Click %sAici%s pt. a sterge Templatul Paginii';
$lang['Delete_page_template_column']	= 'sterge Pagina Template';
$lang['Delete_page_template_column_explain']	= 'Acesta va sterge Templatul Paginii. Atentie, acesta operatie nu este reversibila!';
$lang['Click_page_template_column_delete_yes']	= 'Click %sAici%s pt. a sterge Templatul Paginii';

//
// Cache
//
$lang['Cache_dir_write_protect']	= 'Directorul tau cache este protejat la scriere. Nu s-a putut genera fisierul cache';
$lang['Cache_generate']				= 'Fisierele cache au fost generate.';
$lang['Cache_submit']				= 'Sa generez fisierul cache?';
$lang['Cache_explain']				= 'Cu acesta optiune poti sa generezi toate fisierele XML (fisiere cache) odata pentru toate blocurile portalului. Aceste fisiere permit reducerea numarului de cereri ale bazei de date necesare si imbunatatesc performanta portalului. <br />Noteaza: mxBB cache trebuie activat (in Portal General Admin CP) petru ca aceste fisiere sa fie folosite de sistem.<br>Mai Noteaza: fisierele cache sunt create on the fly cand sunt si blocurile de editare la fel.';
$lang['Generate_mx_cache']			= 'Genereaza Bloc Cache';

//
// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!
//
$lang['Menu_Navigation']			= 'Meniu Navigare';
$lang['Portal_index']				= 'Index Portal';
$lang['Save_Settings']				= 'Salvare Setari';
$lang['Translation_Tools']			= 'Unelte de Traducere';
$lang['Preview_portal']				= 'Previzualizare Portal';

//
// META
//
$lang['Meta_admin']					= 'Administratie Meta Taguri';
$lang['Mega_admin_explain']			= 'Foloseste acest form sa customizezi meta tagurile tale';
$lang['Meta_Title']					= 'Titlu';
$lang['Meta_Author']				= 'Autor';
$lang['Meta_Copyright']				= 'Copyright';
$lang['Meta_Keywords']				= 'Cuvinte Cheie';
$lang['Meta_Keywords_explain']		= '(lista separata de virgula)';
$lang['Meta_Description']			= 'Descriptie';
$lang['Meta_Language']				= 'Cod Limba';
$lang['Meta_Rating']				= 'Clasare';
$lang['Meta_Robots']				= 'Robots';
$lang['Meta_Pragma']				= 'Pragma no-cache';
$lang['Meta_Bookmark_icon']			= 'Bookmark Iconita';
$lang['Meta_Bookmark_explain']		= '(locatie relativa)';
$lang['Meta_HTITLE']				= 'Setari Extra Header';
$lang['Meta_data_updated']			= 'Fisierul de date meta (mx_meta.inc) a fost actualizat!<br />Click %sAICI%s pt. intoarcere la Administratie Meta Taguri.';
$lang['Meta_data_ioerror']			= 'Nu se poate deschide mx_meta.inc. Asigurate ca fisierul e writabil (chmod 777).';

//
// Portal permissons
//
$lang['Mx_Block_Auth_Title']		= 'Permisii Bloc Privat';
$lang['Mx_Block_Auth_Explain']		= 'Aici poti sa configurezi Permisiile Blocului Privat';
$lang['Mx_Page_Auth_Title']			= 'Permisii Pagina Privata';
$lang['Mx_Page_Auth_Explain']		= 'Aici poti sa configurezi Permisiile Paginii Private';
$lang['Block_Auth_successfully']	= 'Permisiunile Blocului Actualizate cu Succes';
$lang['Click_return_block_auth']	= 'Click %sAici%s pt. intoarcere la Permisii Bloc Privat';
$lang['Page_Auth_successfully']		= 'Permisiunile Paginii Actualizate cu Succes';
$lang['Click_return_page_auth']		= 'Click %sAici%s pt. intoarcere la Permisii Pagina Privata';
$lang['AUTH_ALL']					= 'TOtI';
$lang['AUTH_REG']					= 'REG';
$lang['AUTH_PRIVATE']				= 'PRIVAT';
$lang['AUTH_MOD']					= 'MOD';
$lang['AUTH_ADMIN']					= 'ADMIN';
$lang['AUTH_ANONYMOUS']				= 'ANONYMOUS';

// -----------------------------------
// BlockCP - Block Parameter Specific
// -----------------------------------

//
// General
//
$lang['target_block']				= 'Bloc tinta';
$lang['target_block_explain']		= '- linkuri, date etc sunt referite cu acest bloc';

//
// Split column
//
$lang['block_ids']					= 'Blocuri Sursa';
$lang['block_ids_explain']			= '- sa fie pozitionate stanga spre dreapta';
$lang['block_sizes']				= 'Marimi Bloc (separate de virgula)';
$lang['block_sizes_explain']		= '- Poti specifica marimile folosind numere (pixeli), procente (marimi relative, de ex. "40%") ori "*" pentru remainder.';
$lang['space_between']				= 'Spatiu intre blocuri';

//
// Sitelog
//
$lang['log_filter_date']			= 'Filtru dupa timp';
$lang['log_filter_date_explain']	= '- Arata loguri din saptamana trecuta, luna, anul...';
$lang['numOfEvents']				= 'Numar';
$lang['numOfEvents_explain']		= '- Numar evenimente de aratat';

//
// IncludeX
//
$lang['x_listen']					= 'Asculta (GET)';
$lang['x_iframe']					= 'IFrame';
$lang['x_textfile']					= 'Fisier Text';
$lang['x_multimedia']				= 'WMP Multimedia';
$lang['x_pic']						= 'Pictura';
$lang['x_format']					= 'Fisier text formatat';
$lang['x_mode']						= 'IncludeX mode:';
$lang['x_mode_explain']				= '- Blocul IncludeX opereaza in unul din urmatoarele moduri. Daca modul \'Asculta (GET)\' este selectat, modul pote fi setat de un url \'x_mode=mode\' si parametrul asociat cu \'x_1=, x_2=, etc\'.<br />Exemplu: Pentru a trimite un url la iframe foloseste \'domain/index.php?page=x&x_mode=iframe&x_1=http://domain\'  ';
$lang['x_1']						= 'Variabila 1:';
$lang['x_1_explain']				= '- <i>IFrame:</i> url<br /><i>FisierText:</i> cale relativa din radacina (ex in \'/include_file/my_file.xxx\')<br /><i>Multimedia:</i> cale relativa din radacina (ex in \'/include_file/my_file.xxx\')<br /><i>Pic:</i> cale relativa din radacina (ex in \'/include_file/my_file.xxx\')<br /><i>Fisier Text Formatat:</i> indisponibil';
$lang['x_2']						= 'Variabila 2:';
$lang['x_2_explain']				= '- <i>IFrame:</i> inaltime frame (pixeli)<br /><i>Multimedia:</i> latime (pixeli)';
$lang['x_3']						= 'Variabila 3:';
$lang['x_3_explain']				= '- <i>Multimedia:</i> inaltime (pixeli)';

//
// Announcement
//
$lang['announce_nbr_display']		= 'Numar Maxim de Mesaje care sa fie Afisate';
$lang['announce_nbr_days']			= 'Numar de Zile in care se Afiseaza Mesaje';
$lang['announce_img']				= 'Imagine Anunturi';
$lang['announce_img_sticky']		= 'Imagine Lipicioasa';
$lang['announce_img_normal']		= 'Imagine Mesaj Normal';
$lang['announce_img_global']		= 'Imagine Anunturi Globale';
$lang['announce_display']			= 'Afiseaza Mesaje Anunt(uri) in acest Bloc';
$lang['announce_display_sticky']	= 'Afiseaza Lipicios(asa) in acest Bloc';
$lang['announce_display_normal']	= 'Afiseaza Mesaj(e) Normale in acest Bloc';
$lang['announce_display_global']	= 'Afiseaza Anunturile Globale in acest Bloc';
$lang['announce_forum']				= 'Forumuri Sursa';
$lang['announce_forum_explain']		= '- Poti face selectii multiple<br />* Daca nu este selectat nimic, toate forumurile autorizate vor fi vizibile';

//
// Polls
//
$lang['Poll_Display']				= 'Care urna vrei sa o afisezi?';
$lang['poll_forum']					= 'Forumuri Sursa';
$lang['poll_forum_explain']			= '- Poti face selectii mutiple<br />* Daca nimic nu este selectat, toate forumurile autorizate vor fi vizibile';
$lang['Not_Specified']				= 'Ne Specificat';

//
// Dynamic Block
//
$lang['default_block_id']			= 'Bloc Implicit';
$lang['default_block_id_explain']	= '- Acesta este blocul implicit de afisat, exceptand daca un bloc dinamic este selectat';

//
// Menu Navigation
//
$lang['menu_display_mode']			= 'Mod Plan';
$lang['menu_display_mode_explain ']	= 'Mod plan Orizonal ori Vertical';
$lang['menu_page_sync']				= 'Lumineza cel curent?';
$lang['menu_page_sync_explain']		= 'Lumineza intrare la Meniul de Nav. curent...';

//
// Version Checker
//
$lang['mxBB_Version_up_to_date'] = 'Instalarea mxBB este la zi. Nu exista actualizari pentru versiunea ta de mxBB.';
$lang['mxBB_Version_outdated'] = 'Se pare ca instalarea ta mxBB <b>nu</b> este la zi. Actualizari exista pentru versiunea ta de mxBB. Te rog viziteza <a href="http://www.mx-publisher.com/index.php?page=4&action=file&file_id=2" target="_new">downloadare pachetul mxBB Core</a> pt. a obtine ultima versiune.';
$lang['mxBB_Latest_version_info'] = 'Ultima veriune disponibila este <b>mxBB %s</b>. ';
$lang['mxBB_Current_version_info'] = 'Tu ai <b>mxBB %s</b>.';
$lang['mxBB_Mailing_list_subscribe_reminder'] = 'Pentru ultimile informatii de stiri si actualizari pentru mxBB, de ce nu <a href="http://lists.sourceforge.net/lists/listinfo/mxbb-news" target="_new">inscriete la lista de mailuri</a>.';

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

//
// Asta e tot lume!
//
// Translated from english to romanian by OryNider
// orynider@rdslink.ro // http://mx-publisher.com/
//
// -------------------------------------------------
?>