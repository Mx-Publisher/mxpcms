<?php
/**
*
* @package MX-Publisher CMS Core
* @version $Id: lang_main.php,v 1.3 2013/06/28 15:34:32 orynider Exp $
* @copyright (c) 2002-2006 Mx-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

setlocale(LC_ALL, 'ro');

$lang['USER_LANG'] = 'ro';
$lang['ENCODING'] = 'Widows-1250';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'left';
$lang['RIGHT'] = 'right';
$lang['DATE_FORMAT'] =  'd/M/Y'; // This should be changed to the default date format for your language, php date() format


//
// General
//
$lang['Page_Not_Authorised']    	= 'Ne pare rãu, dar nu eºti autorizat sã accesezi aceastã paginã.';
$lang['Execution_Stats'] 			= 'Pagina a generat %s querie - Timpul generãrii: %s secunde';
$lang['Redirect_login']    			= 'Click %sAici%s sã te logezi.';
$lang['Show_admin_options']    		= 'Aratã/Ascunde Opþiunile Admin pe Paginã: ';
$lang['Block_updated_date'] 		= 'Updatat ';
$lang['Block_updated_by'] 			= 'de ';
$lang['Powered_by'] 				= 'Powered by ';

$lang['mx_spacer'] 					= 'Spacer';
$lang['Yes'] 						= 'Da';
$lang['No'] 						= 'Nu';

$lang['Link'] = 'Legãturã';

$lang['Hidden_block'] 				= 'Block ascuns...';
$lang['Hidden_block_explain'] 		= 'Acest bloc este \'ascuns\', dar visibil deoarece eºti un admin/moderator.';

//
// Overall Navigation Navigation
//
$lang['MX_home'] 					= 'Acasã';
$lang['MX_forum'] 					= 'Forum';

//
// Core Blocks - Language
//
$lang['Change_default_lang']   		= 'Seteazã Limba Implicitã'; 
$lang['Change_user_lang']      		= 'Seteazã Limba Ta'; 
$lang['Portal_lang']            	= 'LimbaCP';
$lang['Select_lang']          		= 'Selecteazã Limba:';

//
// Core Blocks - Theme
//
$lang['Change']                 	= 'Schimbã Acum';
$lang['Change_default_style']   	= 'Seteazã Silul Implicit'; 
$lang['Change_user_style']      	= 'Seteazã Stilul Tãu'; 
$lang['Theme']                  	= 'CP Temã/Stil';  // Blocktitle
$lang['SelectTheme']            	= 'Selecteazã Tema/Stilul:';

//
// Core Blocks - Search
//
$lang['Mx_Page'] 					= 'Paginã';
$lang['Mx_Block'] 					= 'Secþiune';

//
// Core Blocks - Site Log (and many last 'item' blocks)
//
$lang['No_items_found'] 			= 'Nimic nou de raportat. ';

//
// BlockCP
//
$lang['Block_Title']            	= 'Titlu';
$lang['Block_Info']            		= 'Informaþii';

$lang['Block_Config_updated']   	= 'Configuraþia blocului actualizatã cu succes';
$lang['Block_Edit']             	= 'Editeazã Bloc';
$lang['Block_Edit_dyn']         	= 'Editeazã Blocul pãrinte dinamic';
$lang['Block_Edit_sub']         	= 'Editeazã Blocul pãrinte împãrþit';


$lang['General_updated_return_settings'] 	= 'Configuraþia upgradatã cu succes...<br /><br />Click %saici%s pentru a continua.'; // %s petru parametrii URI - NU IL SCOATE
$lang['General_update_error'] 			= 'Configuraþia nu se poate upgrada...';

//
// Header
//
$lang['Mx_search_site'] 		= 'Site';
$lang['Mx_search_forum'] 		= 'Forum';
$lang['Mx_search_kb'] 			= 'Articole';
$lang['Mx_search_pafiledb'] 	= 'Download-uri';
$lang['Mx_search_google'] 		= 'Google';
$lang['Mx_new_search'] 			= 'Nouã Cãutare';


//
// Copyrights page
//
$lang['mx_about_title'] 			= 'Despre Mx-Publisher Portal';
$lang['mx_copy_title'] 				= 'Mx-Publisher Portal Informaþii';
$lang['mx_copy_modules_title'] 		= 'Module Mx-Publisher Portal Instalate';
$lang['mx_copy_template_title'] 	= 'Despre stil';
$lang['mx_copy_translation_title'] 	= 'Despre traducere';

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
$lang['TRANSLATION_INFO_MXBB'] = 'Traducerea în Limba Românã de <a href="http://mxpcms.sourceforge.net//phpBB2/profile.php?mode=viewprofile&u=6605" target="_blank">FlorinCB</a>';

//
// Installation
//
$lang['Please_remove_install_contrib'] = 'Te rog asigurã-te cã amândouã directoarele install/ ºi contrib/ sunt ºterse';

//
// Multilangual page titles
// - To have multilangual page titles, add lang keys 'pagetitle_PAGE_TITLE' below
// - This lang key replaces the page title (PAGE_TITLE) for the page given in the adminCP
//
//$lang['pagetitle_NameOfFirstPage'] 	= 'Whatever one';
//$lang['pagetitle_NameOfSecondPage'] 	= 'Whatever two';

//
// Multilangual block titles
// - To have multilangual block titles, add lang keys 'blocktitle_BLOCK_TITLE' below
// - This lang key replaces the block title (BLOCK_TITLE) for the block given in the adminCP/blockCP
//
//$lang['blocktitle_NameOfFirstPage'] 	= 'Whatever one';
//$lang['blocktitle_NameOfSecondPage'] 	= 'Whatever two';

//
// Asta e tot lume!
//
// Translated from english to romanian by OryNider
// orynider@rdslink.ro // http://mx-publisher.com/
// (diacritics)
// -------------------------------------------------

?>