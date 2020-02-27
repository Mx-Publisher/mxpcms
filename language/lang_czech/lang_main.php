<?php
/**
*
* @package MX-Publisher Core
* @version $Id: lang_main.php,v 1.35 2007/01/13 00:16:44 mennonitehobbit Exp $
* @copyright (c) 2002-2006 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// The format of this file is:
//
// ---> $lang['message'] = 'text';
//
// Specify your language character encoding... [optional]
//
// setlocale(LC_ALL, 'en');

$lang['USER_LANG'] = 'cz';
$lang['ENCODING'] = 'UTF-8';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'left';
$lang['RIGHT'] = 'right';
$lang['DATE_FORMAT'] =  'd/M/Y'; // This should be changed to the default date format for your language, php date() format

//
// General
//
$lang['Page_Not_Authorised'] = 'Promiňte, ale nejste oprávnění ke vstupu na tuto stránku.';
$lang['Execution_Stats'] = 'Stránka generovala %s dotazů - doba vygenerování: %s sekund';
$lang['Redirect_login'] = 'Klikněte %szde%s pro přihlášení.';
$lang['Show_admin_options'] = 'Zobrazit/skrýt možnost administrace stránky: ';
$lang['Block_updated_date'] = 'Aktualizoval ';
$lang['Block_updated_by'] = ' ';
$lang['Powered_by'] = 'Vytvořil ';

$lang['mx_spacer'] = 'Oddělovač';
$lang['Yes'] = 'Ano';
$lang['No'] = 'Ne';


$lang['Link'] = 'Link';

$lang['Hidden_block'] = 'Skrytý blok';
$lang['Hidden_block_explain'] = 'Tento blok je \'skrytý\', ale viditelný vámi do řádného nastavení oprávnění.';

//
// Navigation Block
//
$lang['Navigation_Menu'] = 'Menu';

//
// Overall Navigation Navigation
//
$lang['MX_home'] = 'Domovská stránka';
$lang['MX_forum'] = 'Fórum';
$lang['MX_navigation'] = 'Pages navigation, eg. forum navigation, like pafiledb navigation.';

//
// Core Blocks - Language
//
$lang['Change_default_lang'] = 'Nastavení výchozího jazyka fóra';
$lang['Change_user_lang'] = 'Nastavení jazyka';
$lang['Portal_lang'] = 'Jazyk portálu';
$lang['Select_lang'] = 'Výběr jazyka:';
$lang['Who_is_Online'] = 'Who is Online';
$lang['Who_is_Online?'] = 'Who is Online?';
$lang['Last_Message_Post'] = 'Last Post';

//
// Core Blocks - Theme
//
$lang['Change'] = 'Změnit teď';
$lang['Change_default_style'] = 'Nastavení výchozího stylu fóra';
$lang['Change_user_style'] = 'Nastavení stylu';
$lang['Theme'] = 'Téma/styl portálu';
$lang['Select_theme'] = 'Výběr tématu/styly:';

//
// Core Blocks - Search
//
$lang['Mx_Page'] = 'Stránka';
$lang['Mx_Block'] = 'Sekce';
//
// Core Blocks - Virtual
//
$lang['Virtual_Create_new'] = 'Create new ';
$lang['Virtual_Create_new_user'] = 'User Page';
$lang['Virtual_Create_new_group'] = 'Group Page';
$lang['Virtual_Create_new_project'] = 'Project Page';
$lang['Virtual_Create'] = 'Create now';
$lang['Virtual_Edit'] = 'Update page name';
$lang['Virtual_Delete'] = 'Delete this page';

$lang['Virtual_Welcome'] = 'Welcome ';
$lang['Virtual_Info'] = 'Here you can control your private web page.';
$lang['Virtual_CP'] = 'Page Control Panel';
$lang['Virtual_Go'] = 'Go';
$lang['Virtual_Select'] = 'Select:';

//
// Core Blocks - Site Log (and many last 'item' blocks)
//
$lang['No_items_found'] = 'Nic nového nenalezeno. ';

//
// BlockCP
//
$lang['Block_Title'] = 'Titulek';
$lang['Block_Info'] = 'Informace';

$lang['Block_Config_updated'] = 'Konfigurace bloku úspěšně aktualizována.';
$lang['Block_Edit'] = 'Editace bloku';
$lang['Block_Edit_dyn'] = 'Editace nadřízeného dynamického bloku';
$lang['Block_Edit_sub'] = 'Editace nadřízeného dílčího bloku';

$lang['General_updated_return_settings'] = 'Konfigurace úspěšně aktualizována.<br /><br />Klikněte %szde%s pro pokračování.'; // %s's for URI params - DO NOT REMOVE
$lang['General_update_error'] = 'Nemohu aktualizovat konfiguraci.';

//
// Header
//
$lang['Mx_search_site'] = 'Stránky';
$lang['Mx_search_forum'] = 'Fórum';
$lang['Mx_search_kb'] = 'Články';
$lang['Mx_search_pafiledb'] = 'Stahování';
$lang['Mx_search_google'] = 'Google';
$lang['Mx_new_search'] = 'Nové hledání';
//
// Overall Header Navigation Modules
//
$lang['Share'] = 'Downloads';
$lang['News_Module'] = 'News';

//
// Copyrights page
//
$lang['mx_about_title'] = 'O mxBB Portálu';
$lang['mx_copy_title'] = 'Informace o mxBB Portálu';
$lang['mx_copy_modules_title'] = 'Instalované moduly mxBB Portálu';
$lang['mx_copy_template_title'] = 'O stylu';
$lang['mx_copy_translation_title'] = 'O překladu';

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
//$lang['TRANSLATION_INFO_MXBB'] = 'English Language by <a href="http://www.mx-system.com" target="_blank">mxBB Development Team</a>';

//
// Installation
//
$lang['Please_remove_install_contrib'] = 'Prosím ujistěte se, zda oba adresáře install/ a contrib/ byly smazány.';

//
// Multilangual page titles
// - To have multilangual page titles, add lang keys 'pagetitle_PAGE_TITLE' below
// - This lang key replaces the page title (PAGE_TITLE) for the page given in the adminCP
//
$lang['A__little__text_to_describe_your_site'] = 'Whatever text to describe your site';
//$lang['pagetitle_NameOfFirstPage'] = 'Whatever one';
//$lang['pagetitle_NameOfSecondPage'] = 'Whatever two';

//$lang['pagedesc_NameOfFirstPage'] = 'Whatever one';
//$lang['pagedesc_NameOfSecondPage'] = 'Whatever two';

//
// Multilangual block titles
// - To have multilangual block titles, add lang keys 'blocktitle_BLOCK_TITLE' below
// - This lang key replaces the block title (BLOCK_TITLE) for the block given in the adminCP/blockCP
//
//$lang['blocktitle_NameOfFirstPage'] = 'Whatever one';
//$lang['blocktitle_NameOfSecondPage'] = 'Whatever two';

//$lang['blockdesc_DescOfFirstPage'] = 'Whatever one';
//$lang['blockdesc_DescOfSecondPage'] = 'Whatever two';

//
// That's all Folks!
// -------------------------------------------------
?>