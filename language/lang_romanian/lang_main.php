<?php
/**
 *
 * @package MX-Publisher CMS Core
 * @version $Id: lang_main.php,v 1.10 2013/06/28 15:34:32 orynider Exp $
 * @copyright (c) 2002-2006 Mx-Publisher Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
 *
 * Encoding: UTF-8
 * 1 tab = 4 spaces
 */

if ( !isset($lang) )
{
	$lang = array();
}
/*  Editor Settings: Please set Tabsize to 4 ;-) */
 
/*  The format of this file is:  ---> $lang['message'] = 'text';
/*  Specify your language character encoding... [optional] */  
setlocale(LC_ALL, 'ro');

$lang = array_merge( $lang, array( // #
//
// General
//
	'Page_Not_Authorised'				=> 'Ne pare rău, dar nu eşti autorizat să accesezi această pagină.',
	'Execution_Stats'					=> 'Pagina a generat %s querie - Timpul generării: %s secunde',
	'Redirect_login'					=> 'Click %sAici%s să te logezi.',
	'Show_admin_options'				=> 'Arată/Ascunde Opţiunile Admin pe Pagină:',
	'Block_updated_date'				=> 'Updatat',
	'Block_updated_by'					=> 'de',
	'Page_updated_date'					=> 'Pagina actualizată',
	'Page_updated_by'					=> 'de',
	'Powered_by'						=> 'Powered by',
	'mx_spacer'							=> 'Spacer',
	'Yes'								=> 'Da',
	'No'								=> 'Nu',
	'Link'								=> 'Legătură',
	'Hidden_block'						=> 'Block ascuns...',
	'Hidden_block_explain'				=> 'Acest bloc este \'ascuns\', dar visibil deoarece eşti un admin/moderator.',
//
// Overall Navigation Navigation
//	
	'MX_home'							=> 'Acasă',
	'MX_forum'							=> 'Forum',
	'MX_navigation'						=> 'Pages navigation, eg. forum navigation, like pafiledb navigation.',	
//
// Core Blocks - Language
//	
	'Change_default_lang'				=> 'Setează Limba Implicită',
	'Change_user_lang'					=> 'Setează Limba Ta',
	'Portal_lang'						=> 'LimbaCP',
	'Select_lang'						=> 'Selectează Limba:',
//
// Core Blocks - Theme
//	
	'Change'							=> 'Schimbă Acum',
	'Change_default_style'				=> 'Setează Silul Implicit',
	'Change_user_style'					=> 'Setează Stilul Tău',
	'Theme'								=> 'CP Temă/Stil',
	'Select_theme'						=> 'Selectează Temă/Stil',
//
// Core Blocks - Search
//	
	'Mx_Page'							=> 'Pagină',
	'Mx_Block'							=> 'Secţiune',
//
// Core Blocks - Virtual
//	
	'Virtual_Create_new'				=> 'Creează Nou',
	'Virtual_Create_new_user'			=> 'Pagină Utilizator',
	'Virtual_Create_new_group'			=> 'Pagină Grup',
	'Virtual_Create_new_project'		=> 'Pagină Proiect',
	'Virtual_Create'					=> 'Creează Nou',
	'Virtual_Edit'						=> 'Editează Pagină Nouă',
	'Virtual_Delete'					=> 'Șterge Pagina Aceasta',
	'Virtual_Welcome'					=> 'Fii Binevenit',
	'Virtual_Info'						=> 'Unde Poți controla Pagina ta Virtuală',
	'Virtual_CP'						=> 'Panou de Control Pagină',
	'Virtual_Go'						=> 'Mergi',
	'Virtual_Select'					=> 'Selectare:',
//
// Core Blocks - Site Log (and many last 'item' blocks)
//	
	'No_items_found'					=> 'Nimic nou de raportat.',
//
// BlockCP
//	
	'Block_Title'						=> 'Titlu',
	'Block_Info'						=> 'Informaţii',
	'Block_Config_updated'				=> 'Configuraţia blocului actualizată cu succes',
	'Edit'								=> 'EDITARE',	
	'Block_Edit'						=> 'Editează Bloc',
	'Block_Edit_dyn'					=> 'Editează Blocul părinte dinamic',
	'Block_Edit_sub'					=> 'Editează Blocul părinte împărţit',
	'General_updated_return_settings'	=> 'Configuraţia upgradată cu succes...<br /><br />Click %saici%s pentru a continua.',
	'General_update_error'				=> 'Configuraţia nu se poate upgrada...',
//
// Header
//	
	'Mx_search_site'					=> 'Site',
	'Mx_search_forum'					=> 'Forum',
	'Mx_search_kb'						=> 'Articole',
	'Mx_search_pafiledb'				=> 'Download-uri',
	'Mx_search_google'					=> 'Google',
	'Mx_new_search'						=> 'Nouă Căutare',
//
// Copyrights page
//	
	'mx_about_title'					=> 'Despre Mx-Publisher CMS',
	'mx_copy_title'						=> 'Mx-Publisher :: Informaţii',
	'mx_copy_modules_title'				=> 'Module MXP Instalate',
	'mx_copy_template_title'			=> 'Despre stil',
	'mx_copy_translation_title'			=> 'Despre traducere',
	
// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
	'TRANSLATION_INFO_MXBB' => 'Romanian Language by <a href="http://mxpcms.sourceforge.net/" target="_blank">MX-Publisher Development Team</a>',

//
// Installation
//	
	'Please_remove_install_contrib'		=> 'Te rog asigură-te că amândouă directoarele install/ şi contrib/ sunt şterse',
));

//
// Multilangual page titles
// - To have multilangual page titles, add lang keys 'pagetitle_PAGE_TITLE' below
// - This lang key replaces the page title (PAGE_TITLE) for the page given in the adminCP
//
$lang['A__little__text_to_describe_your_site'] = 'Orice text pentru a descrie site-ul dvs.';
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
