<?php
/**
*
* @package mxBB Portal Core
* @version $Id: lang_main.php,v 1.35 2007/01/13 00:16:44 mennonitehobbit Exp $
* @copyright (c) 2002-2006 mxBB Project Team
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

$lang['Hidden_block'] = 'Skrytý blok';
$lang['Hidden_block_explain'] = 'Tento blok je \'skrytý\', ale viditelný vámi do řádného nastavení oprávnění.';

//
// Overall Navigation Navigation
//
$lang['MX_home'] = 'Domovská stránka';
$lang['MX_forum'] = 'Fórum';

//
// Core Blocks - Language
//
$lang['Change_default_lang'] = 'Nastavení výchozího jazyka fóra';
$lang['Change_user_lang'] = 'Nastavení jazyka';
$lang['Portal_lang'] = 'Jazyk portálu';
$lang['Select_lang'] = 'Výběr jazyka:';

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
//$lang['pagetitle_NameOfFirstPage'] = 'Whatever one';
//$lang['pagetitle_NameOfSecondPage'] = 'Whatever two';

//
// Multilangual block titles
// - To have multilangual block titles, add lang keys 'blocktitle_BLOCK_TITLE' below
// - This lang key replaces the block title (BLOCK_TITLE) for the block given in the adminCP/blockCP
//
//$lang['blocktitle_NameOfFirstPage'] = 'Whatever one';
//$lang['blocktitle_NameOfSecondPage'] = 'Whatever two';

//
// That's all Folks!
// -------------------------------------------------
?>