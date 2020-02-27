<?php
/**
*
* @package mxBB Portal Core
* @version $Id: lang_admin.php,v 1.70 2007/01/13 00:16:44 mennonitehobbit Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
* czech translation by Shaana 2007
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
// setlocale(LC_ALL, 'en');

$lang['mxBB_adminCP'] = 'Administrace mxBB Portálu';

//
// Left AdminCP Panel
//
$lang['1_General_admin'] = 'Hlavní';
$lang['1_1_Management'] = 'Konfigurace';

$lang['2_CP'] = 'Správa';
$lang['2_1_Modules'] = 'Nastavení modulů<br /><hr>';
$lang['2_2_ModuleCP'] = 'Ovládací panel modulů';
$lang['2_3_BlockCP'] = 'Ovládací panel bloků';
$lang['2_4_PageCP'] = 'Ovládací panel stránek';

$lang['4_Panel_system'] = 'Systémové nástroje';
$lang['4_1_Cache'] = 'Obnova mezipaměti (Cache)';
$lang['4_1_Integrity'] = 'Kontrola integrity';
$lang['4_1_Meta'] = 'META tagy';
$lang['4_1_PHPinfo'] = 'phpInfo()';

//
// Index
//
$lang['Welcome_mxBB'] = 'Vítejte v mxBB';
$lang['Admin_intro_mxBB'] = 'Děkujeme Vám za výběr mxBB portálu jako váší portálové platformy a phpBB jako platformy pro fórum. Tato obrazovka vám dá rychlý celkový přehled všech ruzných statistik vašeho webu. Kdykoliv se mužete vrátit na tuto stránku kliknutím na <span style="text-decoration: underline;">Index administrace</span> v levém panelu. Pro návrat na index vašeho fóra klikněte na logo, které je také v levém panelu. Ostatní odkazy na levé straně této stránky vám umožní ovládat každý aspekt vašeho portálu a fóra. Každá obrazovka obsahuje instrukce jak použít poskytované nástroje.';

//
// General
//
$lang['Yes'] = 'Ano';
$lang['No'] = 'Ne';
$lang['No_modules'] = 'Nejsou nainstalovány žádné moduly.';
$lang['No_functions'] = 'Tento modul nemá žádné blokové funkce.';
$lang['No_parameters'] = 'Tato funkce nemá žádné parametry.';
$lang['No_blocks'] = 'Pro tuto funkci nejsou dostupné žádné bloky.';
$lang['No_pages'] = 'Nejsou dostupné žádné stránky.';
$lang['No_settings'] = 'Nejsou žádná další nastavení pro tento blok.';
$lang['Quick_nav'] = 'Rychlá navigace';
$lang['Include_all_modules'] = 'Seznam všech modulů';
$lang['Include_block_quickedit'] = 'Panel rychlé editace včleněných (Include) bloků';
$lang['Include_block_private'] = 'Autorizace včleněných (Include) bloků';
$lang['Include_all_pages'] = 'Seznam všech stránek';
$lang['View'] = 'Zobrazit';
$lang['Edit'] = 'Editovat';
$lang['Delete'] = 'Smazat';
$lang['Settings'] = 'Nastavení';
$lang['Move_up'] = 'Přesunout nahoru';
$lang['Move_down'] = 'Přesunout dolů';
$lang['Resync'] = 'Resynchronizace';
$lang['Update'] = 'Aktualizace';
$lang['Permissions'] = 'Oprávnění';
$lang['Permissions_std'] = 'Standardní oprávnění';
$lang['Permissions_adv'] = 'Rozšířená oprávnění';
$lang['return_to_page'] = 'Zpět na portál';
$lang['Use_default'] = 'Použít výchozí nastavení';

$lang['AdminCP_status'] = '<b>Zobrazení průběhu</b>';
$lang['AdminCP_action'] = '<b>Databázové akce</b>';
$lang['Invalid_action'] = 'Chyba';
$lang['was_installed'] = 'nainstalován.';
$lang['was_uninstalled'] = 'odinstalován.';
$lang['was_upgraded'] = 'upgradován';
$lang['was_exported'] = 'exportován';
$lang['was_deleted'] = 'smazán';
$lang['was_removed'] = 'odstraněn';
$lang['was_inserted'] = 'vložen';
$lang['was_updated'] = 'aktualizován';
$lang['was_added'] = 'přidán';
$lang['was_moved'] = 'přesunut';
$lang['was_synced'] = 'synchronizován';

$lang['error_no_field'] = 'Nalezeno chybějící pole. Prosím vyplňte všechna požadovaná pole.';

//
// Configuration
//
$lang['Portal_admin'] = 'Administrace portálu';
$lang['Portal_admin_explain'] = 'Použijte tento formulář k přizpůsobení vašeho portálu';
$lang['Portal_General_Config'] = 'Konfigurace portálu';
$lang['Portal_General_settings'] = 'Obecná nastavení';
$lang['Portal_General_config_info'] = 'Přehled obecných nastavení portálu';
$lang['Portal_General_config_info_explain'] = 'načtený ze souboru config.php (není třeba editovat)';
$lang['Portal_Name'] = 'Jméno portálu:';
$lang['Portal_PHPBB_Url'] = 'URL vaší instalace phpBB:';
$lang['Portal_Url'] = 'URL mxBB Portálu:';
$lang['Portal_Config_updated'] = 'Konfigurace portálu byla úspěšně aktualizována';
$lang['Klikněte_return_portal_config'] = 'Klikněte %szde%s pro návrat ke konfiguraci portálu';
$lang['PHPBB_info'] = 'Přehled nastavení phpBB';
$lang['PHPBB_version'] = 'Verze phpBB:';
$lang['PHPBB_script_path'] = 'Cesta k phpBB:';
$lang['PHPBB_server_name'] = 'Doména phpBB (jméno serveru):';
$lang['MX_Portal'] = 'mxBB Portál';
$lang['MX_Modules'] = 'mxBB Moduly';
$lang['Phpbb'] = 'phpBB';
$lang['Top_phpbb_links'] = 'Statistiky phpBB v hlavičce (výchozí hodnota)';
$lang['Top_phpbb_links_explain'] = '- Odkazy na nové nepřečtené příspěvky';
$lang['Portal_version'] = 'Verze mxBB portálu:';
$lang['Mx_use_cache'] = 'Použít mxBB blokovou mezipaměť';
$lang['Mx_use_cache_explain'] = 'Data bloku jsou ukládána do mezipaměti jako jedinečný blok _*.xml souborů. Soubory v mezipaměti jsou vytvořeny/aktualizovány při editaci bloku.';
$lang['Mx_mod_rewrite'] = 'Použít mod_rewrite';
$lang['Mx_mod_rewrite_explain'] = 'Pokud je portál provozován na serveru Apache a je aktivován mod_rewrite, lze přepisovat URL adresy; např.:  můžete přepsat stránky jako \'page=x\' s více intuitivními alternativami. Prosím poeetite si další dokumentaci promodul mx_mod_rewrite.';
$lang['Portal_Overall_header'] = 'Hlavní hlavičkový soubor (výchozí hodnota)';
$lang['Portal_Overall_header_explain'] = '- toto je výchozí šablona hlavního hlavičkového souboru , např. overall_header.tpl.';
$lang['Portal_Main_layout'] = 'Hlavní soubor vzhledu (výchozí hodnota)';
$lang['Portal_Main_layout_explain'] = '- toto je výchozí šablona souboru vzhledu, např. mx_main_layout.tpl.';
$lang['Portal_Navigation_block'] = 'Hlavní hlavičkový navigační blok (výchozí hodnota)';
$lang['Portal_Navigation_block_explain'] = '- toto je výchozí šablona hlavičkového navigačního bloku.';

//
// Module Management
//
$lang['Module_admin'] = 'Administrace modulů';
$lang['Module_admin_explain'] = 'Použijte tento formulář ke správě modulů: instalaci, upgrade a vývoj modulů.<br /><b>Pro použití tohoto panelu  musíte mít v prohlížeči povolen JavaScript a cookies!</b>';
$lang['Modulecp_admin'] = 'Ovládací panel modulů';
$lang['Modulecp_admin_explain'] = 'Použijte tento formulář ke správě modulů: blokové funkce (parametry) a portálové bloky.<br /><b>Pro použití tohoto panelu  musíte mít v prohlížeči povolen JavaScript a cookies!</b>';
$lang['Modules'] = 'Moduly';
$lang['Module'] = 'Modul';
$lang['Module_delete'] = 'Smazat modul';
$lang['Module_delete_explain'] = 'Použijte tento formulář ke smazání modulu (nebo blokové funkce)';
$lang['Edit_module'] = 'Editace modulu';
$lang['Create_module'] = 'Vytvoření nového modulu';
$lang['Module_name'] = 'Jméno modulu';
$lang['Module_desc'] = 'Popis';
$lang['Module_path'] = 'Cesta, např. \'modules/mx_textblocks/\'';
$lang['Module_include_admin'] = 'Začlenit tento modul do navigace administrace';

//
// Module Installation
//
$lang['Module_delete_db'] = 'Opravdu chcete odinstalovat tento modul? Varování: ztratíte všechna data modulu, nechcete raději provést upgrade modulu?';
$lang['Click_module_delete_yes'] = 'Klikněte %szde%s pro odinstalaci modulu';
$lang['Click_module_upgrade_yes'] = 'Klikněte %szde%s pro upgrade modulu';
$lang['Click_module_export_yes'] = 'Klikněte %szde%s pro export modulu';
$lang['Error_no_db_install'] = 'Chyba: soubor db_install.php neexistuje. Prosím ověřte to a zkuste to znovu.';
$lang['Error_no_db_uninstall'] = 'Chyba: soubor db_uninstall.php neexistuje, nebo odinstalace není tímto modulem podporována. Prosím ověřte to a zkuste to znovu.';
$lang['Error_no_db_upgrade'] = 'Chyba: soubor db_upgrade.php neexistuje, nebo upgrade není tímto modulem podporován. Prosím ověřte to a zkuste to znovu.';
$lang['Error_module_installed'] = 'Chyba: tento modul je již nainstalován! Nejprve prosím smažte modul nebo proveďte jeho upgrade.';
$lang['Uninstall_module'] = 'Odinstalace modulu';
$lang['import_module_pack'] = 'Instalace modulu';
$lang['import_module_pack_explain'] = 'Modul bude nainstalován na portál. Ověřte zda balíček modulu je nahrán v adresáři /modules/. Nezapomeňte použít poslední verzi modulu!';
$lang['upgrade_module_pack'] = 'Upgrade modulu';
$lang['upgrade_module_pack_explain']= 'Bude proveden upgrade vašeho modulu. Před provedením pečlivě prostudujte dokumentaci modulu, jinak riskujete ztrátu dat.';
$lang['export_module_pack'] = 'Export modulu';
$lang['Export_Module'] = 'Vyberte modul:';
$lang['export_module_pack_explain'] = 'Bude vyexportován soubor *.pak modulu. Toto je určeno pro tvůrce modulů; běžní uživatelé si s tím nemusí  dělat starosti.';
$lang['Module_Config_updated'] = 'Konfigurace modulu byla úspěšně aktualizována';
$lang['Click_return_module_admin'] = 'Klikněte %szde%s pro návrat k administraci modulů';
$lang['Module_updated'] = 'Informace o modulu byly úspěšně aktualizovány';

//
// Functions & Parameters Administration
//
$lang['Function_admin'] = 'Administrace blokových funkcí';
$lang['Function_admin_explain'] = 'Moduly mívají jednu nebo více blokových funkcí. Použijte tento formulář k editaci, přidávání nebo mazání blokových funkcí';
$lang['Function'] = 'Blokové funkce';
$lang['Function_name'] = 'Jméno blokové funkce';
$lang['Function_desc'] = 'Popis';
$lang['Function_file'] = 'Soubor ';
$lang['Function_admin_file'] = 'Soubor (Editace bloku skriptu) <br /> Zvláštní parametry pro tento panel editace bloku. Ponechte prázdné pro použití výchozího editačního panelu.';
$lang['Create_function'] = 'Přidat novou blokovou funkci';
$lang['Delete_function'] = 'Smazat blokovou funkci';
$lang['Delete_function_explain'] = 'Tato volba smaže funkci a všechny jí asociované portálové bloky. Pozor - tato operace je nevratná!';
$lang['Click_function_delete_yes'] = 'Klikněte %szde%s pro smazání funkce';

$lang['Parameter_admin'] = 'Administrace parametrů funkce';
$lang['Parameter_admin_explain'] = 'Seznam všech parametrů této funkce';
$lang['Parameter'] = 'Parametr';
$lang['Parameter_name'] = '<b>Jméno parametru</b><br />- to be used to access the parameter';
$lang['Parameter_type'] = '<b>Typ parametru</b>';
$lang['Parameter_default'] = '<b>Výchozí hodnota</b>';
$lang['Parameter_function'] = '<b>Nastavení funkce</b>';
$lang['Parameter_function_explain'] = '<b>Funkce</b> (při použití typu \'Function\')<br />- Můžete vložit data parametru do externí funkce<br /> pro vygenerování formulářové položky.<br />- Např.: <br />get_list_formatted("block_list","{parameter_value}","{parameter_id}[]")';
$lang['Parameter_function_explain'] .= '<br /><br /><b>Možnost(i)</b> (při použití typu parametru \'Selection\' )<br />- Pro všechny parametry výběru (přepínače (radiobutton), zátržítka (checkbox) a menu) všechny možnosti jsou vypsány, jeden prvek na řádek.';
$lang['Parameter_auth'] = '<b>Pouze administrátoři a moderátoři bloku</b>';

$lang['Parameters'] = 'Parametry';
$lang['Parameter_id'] = 'ID';
$lang['Create_parameter'] = 'Přidat nový parametr';
$lang['Delete_parameter'] = 'Smazat parametr funkce';
$lang['Delete_parameter_explain'] = 'Tímto smažete parametr a aktualizujete všechny asociované portálové bloky.  Pozor - tato operace je nevratná!';
$lang['Click_parameter_delete_yes'] = 'Klikněte %szde%s pro sazání parametru';

//
// Parameter Types
//
$lang['ParType_BBText'] = 'Prostý textový blok BB kódu (BBCode)';
$lang['ParType_BBText_info'] = 'Toto je prostý textový blok syntakticky analyzující BB kód';
$lang['ParType_Html'] = 'Prostý textový blok HTML';
$lang['ParType_Html_info'] = 'Toto je prostý textový blok syntakticky analyzující HTML';
$lang['ParType_Text'] = 'Prostý text (jednořádkový)';
$lang['ParType_Text_info'] = 'Toto je jednoduché textové pole';
$lang['ParType_TextArea'] = 'Prostý text (víceřádkový)';
$lang['ParType_TextArea_info'] = 'Toto je víceřádkové textové pole (textarea)';
$lang['ParType_Boolean'] = 'Logická hodnota (Boolean)';
$lang['ParType_Boolean_info'] = 'Toto je přepínač \'ano\' a \'ne\'.';
$lang['ParType_Number'] = 'Prosté číslo';
$lang['ParType_Number_info'] = 'Toto je jednoduché číselné pole';
$lang['ParType_Function'] = 'Parametr funkce';
$lang['ParType_Values'] = 'Hodnoty';

$lang['ParType_Radio_single_select'] = 'Přepínače jednotlivého výběru (Radio Buttons)';
$lang['ParType_Radio_single_select_info'] = '';
$lang['ParType_Menu_single_select'] = 'Menu - jednotlivý výběr';
$lang['ParType_Menu_single_select_info'] = '';
$lang['ParType_Menu_multiple_select'] = 'Menu - vícenásobný výběr';
$lang['ParType_Menu_multiple_select_info'] = '';
$lang['ParType_Checkbox_multiple_select'] = 'Zátržítko (Checkbox) - vícenásobný výběr';
$lang['ParType_Checkbox_multiple_select_info'] = '';

//
// Blocks Administration
//
$lang['Block_admin'] = 'Ovládací panel bloku';
$lang['Block_admin_explain'] = 'Použijte tento formulář ke správě portálových bloků.<br /><b>Pro použití tohoto panelu  musíte mít v prohlížeči povolen JavaScript a cookies!</b>';
$lang['Block'] = 'Blok';
$lang['Show_title'] = 'Zobrazit nadpis bloku?';
$lang['Show_title_explain'] = 'Zobrazí/skryje nadpis bloku';
$lang['Show_block'] = 'Zobrazit blok?';
$lang['Show_block_explain'] = '- Jestliže je vybráno \'ne\', blok je skrytý všem uživatelům kromě administrátorů';
$lang['Show_stats'] = 'Zobrazit statistiky?';
$lang['Show_stats_explain'] = '- Jestliže je vybráno \'ano\', bude pod blokem zobrazeno \'editoval...\'';
$lang['Show_blocks'] = 'Zobrazit funkce bloku';
$lang['Block_delete'] = 'Smazat blok';
$lang['Block_delete_explain'] = 'Použijte tento formulář pro smazání bloku (případně sloupce)';
$lang['Block_title'] = 'Nadpis';
$lang['Block_desc'] = 'Popis';
$lang['Add_Block'] = 'Přidat nový blok';
$lang['Auth_Block'] = 'Oprávnění';
$lang['Auth_Block_explain'] = 'ALL: všichni uživatelé<br />REG: Registrovaní uživatelé<br />PRIVATE: Členové skupiny (viz rozšířená oprávnění)<br />MOD: moderátoři bloku (viz rozšířená oprávnění)<br />ADMIN: Administrátoři<br />ANONYMOUS: POUZE hosté - anonymní uživatelé';
$lang['Block_quick_stats'] = 'Rychlé statistiky';
$lang['Block_quick_edit'] = 'Rychlá editace';
$lang['Create_block'] = 'Vytvořit nový blok';
$lang['Delete_block'] = 'Smazat portálový blok';
$lang['Delete_block_explain'] = 'Tato volba smaže blok a aktualizuje všechny asociované portálové stránky. Pozor - tato operace je nevratná!';
$lang['Click_block_delete_yes'] = 'Klikněte %szde%s pro smazání bloku';

//
// BlockCP Administration
//
$lang['Block_cp'] = 'Ovládací panel bloku';
$lang['Click_return_blockCP_admin'] = 'Klikněte %szde%s pro návrat na ovládací panel bloku';
$lang['Click_return_portalpage_admin'] = 'Klikněte %szde%s pro návrat na portál';
$lang['BlockCP_Config_updated'] = 'Blok byl aktualizován.';

//
// Pages Administration
//
$lang['Page_admin'] = 'Administrace stránek';
$lang['Page_admin_explain'] = 'Použijte tento formulář pro přidání, smazání a změně nastavení portálových stráneka stránkových šablon.<br /><b>Pro použití tohoto panelu  musíte mít v prohlížeči povolen JavaScript a cookies!</b>';
$lang['Page_admin_edit'] = 'Editace stránky';
$lang['Page_admin_private'] = 'Rozšířená oprávnění pro stránky';
$lang['Page_admin_settings'] = 'Nastavení stránky';
$lang['Page_admin_new_page'] = 'Administrace nové stránky';
$lang['Page'] = 'Stránka';
$lang['Page_Id'] = 'ID stránky';
$lang['Page_icon'] = 'Ikona stránky <br /> - je využita jen v panelu administrace, např. icon_home.gif (výchozí)';
$lang['Page_header'] = 'Soubor hlavičky<br /> - tj. overall_header.tpl (výchozí), overall_noheader.tpl (bez hlavičky) nebo uživatelský.<br />Pro ponechání výchozího nastavení zanechte prázdné.';
$lang['Page_main_layout'] = 'Soubor vzhledu<br /> - tj. mx_main_layout.tpl (výchozí) nebo uživatelský.<br />Pro ponechání výchozího nastavení zanechte prázdné.';
$lang['Page_Navigation_block'] = 'Navigační blok hlavičky';
$lang['Page_Navigation_block_explain'] = '- Toto je navigační blok hlavičky (za předpokladu, že hlavičkový soubor podporuje stránku navigace).<br />Pro ponechání výchozího nastavení zanechte prázdné.';
$lang['Auth_Page'] = 'Oprávnění';
$lang['Select_sort_method'] = 'Vyberte metodu třídění';
$lang['Order'] = 'Pořadí třídění';
$lang['Sort'] = 'Třídění';
$lang['Page_sort_title'] = 'Titulek stránky';
$lang['Page_sort_desc'] = 'Popis stránky';
$lang['Page_sort_created'] = 'Stránka vytvořena';
$lang['Sort_Ascending'] = 'Vzestupně';
$lang['Sort_Descending'] = 'Sestupně';
$lang['Return_to_page'] = 'Návrat na portál';
$lang['Auth_Page_group'] = '-> Soukromé';
$lang['Page_desc'] = 'Popis';
$lang['Add_Page'] = 'Přidat novou stránku';
$lang['Page_Config_updated'] = 'Konfigurace stránky byla úspěšně aktualizována';
$lang['Click_return_page_admin'] = 'Klikněte %szde%s pro návrat na administraci stránky';
$lang['Remove_block'] = 'Odstranit portálový blok';
$lang['Remove_block_explain'] = 'Tato volba odstraní blok ze stránky. Pozor - tato operace je nevratná!';
$lang['Click_block_remove_yes'] = 'Klikněte %szde%s pro ostranění bloku';
$lang['Delete_page'] = 'Smazání stránky';
$lang['Delete_page_explain'] = 'Tato volba smaže stránku. Pozor - tato operace je nevratná!';
$lang['Click_page_delete_yes'] = 'Klikněte %szde%s pro smazání stránky';

$lang['Mx_IP_filter'] = 'Filtr IP';
$lang['Mx_IP_filter_explain'] = 'Pro omezení přístupu na tuto stránku podle IP, zadejte platné IP adresy, jedna IP adresa na řádek.<br>Např: 127.0.0.1 nebo 127.1.*.*';
$lang['Mx_phpBB_stats'] = 'Statistika phpBB v hlavičce';
$lang['Mx_phpBB_stats_explain'] = '- odkazy na nové, nepřečtené příspěvky, atd.';
$lang['Column_admin'] = 'Administrace stránkových sloupců';
$lang['Column_admin_explain'] = 'Administrace stránkových sloupců';
$lang['Column'] = 'Sloupec stránky';
$lang['Columns'] = 'Sloupce stránky';
$lang['Column_block'] = 'Stránkový sloupcový blok';
$lang['Column_blocks'] = 'Stránkové sloupcové bloky';
$lang['Edit_Column'] = 'Editace sloupce';
$lang['Edit_Column_explain'] = 'Použijte tento formulář k modifikaci sloupce';
$lang['Column_Size'] = 'Rozměr sloupce';
$lang['Column_name'] = 'Jméno sloupce';
$lang['Column_delete'] = 'Smazat sloupec';
$lang['Page_updated'] = 'Stránka a sloupce byly úspěšně aktualizovány';
$lang['Create_column'] = 'Přidat nový sloupec';
$lang['Delete_page_column'] = 'Smazat sloupec';
$lang['Delete_page_column_explain'] = 'Tato volba smaže sloupec. Pozor - tato operace je nevratná!';
$lang['Click_page_column_delete_yes'] = 'Klikněte %szde%s pro smazání sloupce';

//
// Page templates
//
$lang['Page_templates_admin'] = 'Administrace šablon';
$lang['Page_templates_admin_explain'] = 'Použijte tuto stránku k vytváření, editaci, nebo mazání šablon';
$lang['Page_template'] = 'Šablona';
$lang['Page_templates'] = 'Šablony';
$lang['Page_template_column'] = 'Sloupec šablony';
$lang['Page_template_columns'] = 'Sloupce šablon';
$lang['Choose_page_template'] = 'Vybrat šablonu';
$lang['Template_Config_updated'] = 'Konfigurace šablony aktualizována';
$lang['Add_Template'] = 'Přidat novou šablonu';
$lang['Template'] = 'Šablona';
$lang['Template_name'] = 'Jméno šablony';
$lang['Page_template_delete'] = 'Smazat šablonu';
$lang['Delete_page_template'] = 'Smazat šablonu';
$lang['Delete_page_template_explain'] = 'Tato volba smaže šablonu. POZOR - tato operace je nevratná!';
$lang['Click_page_template_delete_yes'] = 'Klikněte %szde%s pro smazání šablony';
$lang['Delete_page_template_column'] = 'Smazat šablonu';
$lang['Delete_page_template_column_explain'] = 'Tato volba smaže šablonu. POZOR - tato operace je nevratná!';
$lang['Click_page_template_column_delete_yes'] = 'Klikněte %szde%s  pro smazání šablony';

//
// Install Process
//
$lang['Welcome_install'] = 'Vítejte v průvodci instalací mxBB Portálu';
$lang['Install_Instruction'] = 'Prosím vyplňte následující údaje. Tento instalační program vytvoří personalizovaný soubor config.php (umístěný v kořenovém adresáři portálu) a databázi portálu s výchozími nastaveními. Po ukončení průvodce uvidíte zprávu s výpisem všech provedenýcn kroků (poznámka: mxBB Portál nemodifikuje Vaši databázi phpBB). Poté se můžete přihlásit na fórum jako administrátor, jít do ovládacího panelu administrace a nakonfigurovat Váš portál podle Vašich představ. Poznámka - mxBB Portál nepracuje samostatně, je třeba mít nainstalované a nakonfigurované phpBB. Děkujeme Vám za výběr mxBB Portálu.';
$lang['Upgrade_Instruction'] = 'mxBB Portál je již nainstalován. Nyní si prosím udělejte zálohu Vaší databáze!<br /><br />Následující krok zmodifikuje  strukturu Vaší databáze (poznámka: mxBB Portál nemodifikuje Vaši databázi phpBB). Pokud z jakéhokoliv důvodu tato aktualizační procedura zhavaruje, nelze se žádným způsobem navrátit do současného stavu. Prosím udělejte zálohu Vaší databáze PŘED provedením této procedury!<br /><br />Poté klikněte na tlačítko pro start aktualizační procedury.';
$lang['Install_moreinfo'] = '%sPoznámky k verzi%s | %sUvítací balíček%s | %sOnline FAQ%s | %sFóra podpory%s | %sPodmínky použití%s';
$lang['Install_settings'] = 'Instalační nastavení';
$lang['Choose_lang explain'] = 'Prosím použijte tento formulář k výběru jazyka, ve kterém bude probíhat instalační proces.';
$lang['Choose_lang'] = 'Výběr jazyka';
$lang['Language'] = 'Jazyk';
$lang['Phpbb_path'] = 'Relativní cesta k phpBB';
$lang['Phpbb_path_explain'] = 'Relativní cesta k phpBB, např. phpBB/ nebo ../phpBB/<br />Poznámka: uzavírací lomítko "/", je důležité!';
$lang['Phpbb_url'] = 'Celá URL instalace phpBB';
$lang['Phpbb_url_explain'] = 'Celá URL instalace phpBB, např. <br />http://www.example.com/phpBB/';
$lang['Portal_url'] = 'Celá URL portálu';
$lang['Portal_url_explain'] = 'Celá URL portálu, např. <br />http://www.example.com/';
$lang['Database_settings'] = 'Nastavení databáze';
$lang['dbms'] = 'Typ databáze';
$lang['DB_Host'] = 'Jméno databázového serveru/DSN';
$lang['DB_Name'] = 'Jméno databáze';
$lang['DB_Username'] = 'Databázový uživatel';
$lang['DB_Password'] = 'Heslo databázového uživatele';
$lang['Table_Prefix'] = 'Předpona tabulek phpBB v databázi';
$lang['MX_Table_Prefix'] = 'Předpona tabulek mxBB Portálu v databázi';
$lang['Start_Install'] = 'Start instalace mxBB';
$lang['Start_Upgrade'] = 'Mám vytvořenou zálohu a chci aktualizovat můj mxBB Portál.';
$lang['Portal_intalled'] = 'mxBB Portál byl nainstalován!';
$lang['Portal_upgraded'] = 'mxBB Portál byl aktualizován!';
$lang['Unwriteable_config'] = 'Do vašeho konfiguračního souboru mxBB (config.php) momentálně nelze zapisovat.<br /><br />Kopie konfiguračního souboru bude stažena po stisku tlačítka níže. Tento soubor můžete nahrát do Vašeho kořenového adresáře mxBB : %s <br /><br />Jakmile to bude hotovo, %sOBNOVTE%s prosím toto okno pro provedení dalšího instalačního kroku.<br /><br />Děkujeme Vám za výběr mxBB Portálu.<br />';
$lang['Send_file'] = 'Stáhnout soubor k manuálnímu nahrání na FTP';
$lang['phpBB_nfnd_retry'] = 'Litujeme, nelze najít Vaši instalaci phpBB. Prosím stiskněte ve Vašem prohlížeči tlačítko %sZPĚT%s a opakujte akci.';
$lang['Installation_error'] = 'Vyskytla se chyba v průběhu instalace';
$lang['Debug_Information'] = 'LADÍCÍ INFORMACE';
$lang['Install_phpbb_not_found'] = 'Litujeme, na serveru nelze najít phpBB fórum.<br />Nainstalujte prosím phpBB PŘED instalací mxBB Portálu.<br />\n<br />\n';
$lang['Install_phpbb_db_failed'] = 'Litujeme, nelze se připojit k databázi phpBB.<br />Zkontrolujte prosím, zda je phpBB korektně nainstalován a běží, PŘEDTÍM, než začnete instalovat mxBB Portál.<br />\n<br />\n';
$lang['Install_phpbb_unsupported'] = 'Bohužel, phpBB fórum nainstalované na tomto serveru není podporováno mxBB Portálem.<br />Prosím zkontrolujte poznámky k verzi a instalační požadavky.<br />\n<br />\n';
$lang['Install_noscript_warning'] = 'Litujeme, tato instalace vyžaduje prohlížeč s podporou JavaScriptu.';
$lang['Upgrade_are_you_sure'] = 'Tato aktualizační procedura provede modifikace ve Vaší databázi. Opravdu chcete pokračovat?';
$lang['Writing_config'] = 'Zapisuji do souboru config.php';
$lang['Processing_schema'] = 'Zpracovávám SQL schéma \'%s\'';
$lang['Portal_intalling'] = 'Instaluji mxBB Portál verze %s';
$lang['Portal_upgrading'] = 'Aktualizuji mxBB Portál verze %s';
$lang['Install_warning'] = 'Nalezeno 1 varování při aktualizaci databáze';
$lang['Install_warnings'] = 'Nalezeno %d varování při aktualizaci databáze';
$lang['Subscribe_mxBB_News_now'] = 'Doporučujeme přihlásit se k odběru %smxBB-novinek%s pro získávání informací o důležitých novinkách a oznámeních.<br />&nbsp;<br />%sPřihlásit se k odběru smxBB-novinek nyní!%s';
$lang['Portal_install_done'][0] = 'V tento okamžik je vaše základní instalace kompletní.';
$lang['Portal_install_done'][1] = 'Prosím smažte adresáře /install/ a /contrib/ PŘED startem portálu!!!';
$lang['Portal_install_done'][2] = 'Nezapomínejte provádět zálohy co nejčastěji ;-)';
$lang['Portal_install_done'][3] = 'Stiskněte tlačítko níže a použijte administrátorský účet a heslo k přihlášení do systému.';
$lang['Portal_install_done'][4] = 'Otevřte ovládací panel administrace - Správa a proveďte aktualizaci VŠECH modulů, jednoho po druhém!';
$lang['Portal_install_done'][5] = 'Zkontrolujte konfiguraci portálu a proveďte všechny potřebné změny..';
$lang['Go_to_admincp'] = 'Nyní otevřte ovládací panel administrace proveďte aktualizaci modulů';
$lang['Thanks_for_choosing'] = 'Děkujeme Vám za výběr mxBB Portálu!';
$lang['Critical_Error'] = 'KRITICKÁ CHYBA';
$lang['Error_loading_config'] = 'Litujeme, nelze nahrát config.php mxBB Portálu';
$lang['Error_database_down'] = 'Litujeme, nedá se připojit k databázi.';

//
// Cache
//
$lang['Cache_dir_write_protect'] = 'Váš adresář cache je chráněn proti zápisu. mxBB nemůže vygenerovat soubor mezipaměti. Prosím nastavte právo zápisu do adresáře cache a pokračujte.';
$lang['Cache_generate'] = 'Vaše soubory mezipaměti byly vygenerovány.';
$lang['Cache_submit'] = 'Generovat soubory mezipaměti?';
$lang['Cache_explain'] = 'Pomocí této volby můžete vygenerovat všechny soubory mezipaměti (XML soubory) pro všechny portálové bloky. Tyto soubory snižují počet databázových dotazů a zvyšují celkovou výkonnost portálu. <br />Poznámka: mezipaměť mxBB musí být povolena (v hlavním ovládacím panelu administrace portálu) aby systém mohl využívat tyto soubory.<br>Další poznámka: soubory mezipaměti jsou vytvářeny průběžně při editaci bloku.';
$lang['Generate_mx_cache'] = 'Generovat mezipaměť bloku';

//
// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!
//
$lang['Menu_Navigation'] = 'Navigační Menu';
$lang['Portal_index'] = 'Hlavní stránka portálu';
$lang['Save_Settings'] = 'Uložit nastavení';
$lang['Translation_Tools'] = 'Překladatelské nástroje';
$lang['Preview_portal'] = 'Náhled portálu';

//
// META
//
$lang['Meta_admin'] = 'Administrace META Tagů';
$lang['Mega_admin_explain'] = 'Použijte tento formulář pro přizpůsobení Vašich META tagů';
$lang['Meta_Title'] = 'Titulek';
$lang['Meta_Author'] = 'Autor';
$lang['Meta_Copyright'] = 'Copyright';
$lang['Meta_Keywords'] = 'Klíčová slova';
$lang['Meta_Keywords_explain'] = '(seznam oddělený čárkami)';
$lang['Meta_Description'] = 'Popis';
$lang['Meta_Language'] = 'Kód jazyka';
$lang['Meta_Rating'] = 'Hodnocení';
$lang['Meta_Robots'] = 'Roboti';
$lang['Meta_Pragma'] = 'Pragma no-cache';
$lang['Meta_Bookmark_icon'] = 'Ikona';
$lang['Meta_Bookmark_explain'] = '(relativní umístění)';
$lang['Meta_HTITLE'] = 'Zvláštní nastavení hlavičky';
$lang['Meta_data_updated'] = 'Soubor meta dat (mx_meta.inc) byl aktualizován!<br />Klikněte %szde%s pro návrat na Administraci META Tagů.';
$lang['Meta_data_ioerror'] = 'Nemohu otevřít mx_meta.inc. Zkontrolujte prosím právo k zápisu (chmod 777).';

//
// Portal permissons
//
$lang['Mx_Block_Auth_Title'] = 'Oprávnění soukromých bloků' ;
$lang['Mx_Block_Auth_Explain'] = 'Zde můžete konfigurovat oprávnění soukromých bloků';
$lang['Mx_Page_Auth_Title'] = 'Oprávnění soukromých stránek' ;
$lang['Mx_Page_Auth_Explain'] = 'Zde můžete konfigurovat oprávnění soukromých stránek';
$lang['Block_Auth_successfully'] = 'Oprávnění bloku byla úspěšně aktualizována';
$lang['Click_return_block_auth'] = 'Klikněte %szde%s pro návrat na oprávnění soukromých bloků';
$lang['Page_Auth_successfully'] = 'Oprávnění stránky byla úspěšně aktualizována';
$lang['Click_return_page_auth'] = 'Klikněte %szde%s pro návrat na oprávnění soukromých stránek';
$lang['AUTH_ALL'] = 'VŠICHNI';
$lang['AUTH_REG'] = 'REGISTROVANÍ';
$lang['AUTH_PRIVATE'] = 'SOUKROMÉ';
$lang['AUTH_MOD'] = 'MODERÁTOŘI';
$lang['AUTH_ADMIN'] = 'ADMINI';
$lang['AUTH_ANONYMOUS'] = 'ANONYMOVÉ';

// -----------------------------------
// BlockCP - Block Parameter Specific
// -----------------------------------

//
// General
//
$lang['target_block'] = 'Cílový blok';
$lang['target_block_explain'] = '- odkazy, data atd. - odkazy tohoto bloku';

//
// Split column
//
$lang['block_ids'] = 'Zdrojové bloky';
$lang['block_ids_explain'] = '- budou umístěny zleva doprava';
$lang['block_sizes'] = 'Velikosti bloků (oddělené čárkami)';
$lang['block_sizes_explain'] = '- Můžete specifikovat velikost číselně (v pixelech), procentuálně (relativní velikost, např. \'40%\') nebo \'*\' pro zbytek.';
$lang['space_between'] = 'Mezera mezi bloky';

//
// Sitelog
//
$lang['log_filter_date'] = 'Filtrovat podle času';
$lang['log_filter_date_explain'] = '- Zobrazit logy za poslední týden, měsíc, rok...';
$lang['numOfEvents'] = 'Počet';
$lang['numOfEvents_explain'] = '- Počet událostí k zobrazení';

//
// IncludeX
//
$lang['x_listen'] = 'Naslouchání (GET)';
$lang['x_iframe'] = 'IFrame';
$lang['x_textfile'] = 'Textový soubor';
$lang['x_multimedia'] = 'WMP Multimedia';
$lang['x_pic'] = 'Obrázek';
$lang['x_format'] = 'Formátovaný textový soubor';
$lang['x_mode'] = 'Mód IncludeX :';
$lang['x_mode_explain'] = '- Mód IncludeX pracuje s jedním z následujících módů. jestliže je vybrán mód \'Naslouchání (GET)\', může být mód nastaven pomocí url \'x_mode=mode\' a asociovány parametry pomocí \'x_1=, x_2=, etc\'.<br />Příklad: Pro překlad url do iframe použijte  \'domain/index.php?page=x&x_mode=iframe&x_1=http://domain\' ';
$lang['x_1'] = 'Proměnná 1:';
$lang['x_1_explain'] = '- <i>IFrame:</i> url<br /><i>textový soubor:</i> relativní cesta od kořenového adresáře (např. \'/include_file/my_file.xxx\')<br /><i>Multimedia:</i> relativní cesta od kořenového adresáře (např. \'/include_file/my_file.xxx\')<br /><i>Obrázek:</i> relativní cesta od kořenového adresáře (např. \'/include_file/my_file.xxx\')<br /><i>Formátovaný textový soubor:</i> nedostupné';
$lang['x_2'] = 'Proměnná 2:';
$lang['x_2_explain'] = '- <i>IFrame:</i> výška rámce (v pixelech)<br /><i>Multimedia:</i> šířka (v pixelech)';
$lang['x_3'] = 'Proměnná 3:';
$lang['x_3_explain'] = '- <i>Multimedia:</i> výška (v pixelech)';

//
// Dynamic Block
//
$lang['default_block_id'] = 'Výchozí blok';
$lang['default_block_id_explain'] = '- Toto je výchozí resp. první blok pro zobrazení, jestliže není nastaven dynamický blok';

//
// Menu Navigation
//
$lang['menu_display_style'] = 'Styl menu';
$lang['menu_display_style_explain '] = 'Standardní, jednoduchý, rozšířený nebo rozšířený aplikační';

$lang['menu_display_mode'] = 'Mód vzhledu';
$lang['menu_display_mode_explain '] = 'Horizontální nebo vertikální mód vzhledu';

$lang['menu_page_sync'] = 'Vysvítit aktuální?';
$lang['menu_page_sync_explain'] = 'Vysvítí aktuální položku navigačního menu...';

//
// Version Checker
//
$lang['mxBB_Version_up_to_date'] = 'Vaše instalace mxBB je aktuální. Nejsou dostupné žádné aktualizace pro Vaši verzi mxBB.';
$lang['mxBB_Version_outdated'] = 'Vaše instalace mxBB <b>není</b> aktuální. Pro Vaši verzi mxBB jsou dostupné aktualizace. Navštivte prosím  <a href="http://www.mx-system.com/index.php?page=4&action=file&file_id=2" target="_new">Stránky pro stažení balíčku jádra mxBB</a> k získání poslední verze.';
$lang['mxBB_Latest_version_info'] = 'Poslední dostupná verze je <b>mxBB %s</b>. ';
$lang['mxBB_Current_version_info'] = 'Vaše verze je <b>mxBB %s</b>.';
$lang['mxBB_Mailing_list_subscribe_reminder'] = 'Pro nejnovější informace, novinky a aktualizace týkající se mxBB se přihlašte do <a href="http://lists.sourceforge.net/lists/listinfo/mxbb-news" target="_new">mailing listu</a>.';

//
// That's all Folks!
// -------------------------------------------------
?>