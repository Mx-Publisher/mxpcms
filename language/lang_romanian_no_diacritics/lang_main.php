<?php
/**
*
* @package MXP Portal Core
* @version $Id: lang_main.php,v 1.2 2008/06/18 11:39:41 orynider Exp $
* @copyright (c) 2002-2006 MXP Project Team
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
// 

setlocale(LC_ALL, 'ro');

//
// General
//
$lang['Page_Not_Authorised']    	= 'Ne pare rau, dar nu esti autorizat sa accesezi aceasta pagina.';
$lang['Execution_Stats'] 			= 'Pagina a generat %s querie - Timpul generarii: %s secunde';
$lang['Redirect_login']    			= 'Click %sAici%s sa te logezi.';
$lang['Show_admin_options']    		= 'Arata/Ascunde Optiunile Admin pe Pagina: ';
$lang['Block_updated_date'] 		= 'Updatat ';
$lang['Block_updated_by'] 			= 'de ';
$lang['Powered_by'] 				= 'Powered by ';

$lang['mx_spacer'] 					= 'Spacer';
$lang['Yes'] 						= 'Da';
$lang['No'] 						= 'Nu';

$lang['Link'] = 'Legatura';

$lang['Hidden_block'] 				= 'Block ascuns...';
$lang['Hidden_block_explain'] 		= 'Acest bloc este \'ascuns\', dar visibil deoarece esti un admin/moderator.';

//
// Overall Navigation Navigation
//
$lang['MX_home'] 					= 'Acasa';
$lang['MX_forum'] 					= 'Forum';

//
// Core Blocks - Language
//
$lang['Change_default_lang']   		= 'Seteaza Limba Implicita'; 
$lang['Change_user_lang']      		= 'Seteaza Limba Ta'; 
$lang['Portal_lang']            	= 'LimbaCP';
$lang['Select_lang']          		= 'Selecteaza Limba:';

//
// Core Blocks - Theme
//
$lang['Change']                 	= 'Schimba Acum';
$lang['Change_default_style']   	= 'Seteaza Silul Implicit'; 
$lang['Change_user_style']      	= 'Seteaza Stilul Tau'; 
$lang['Theme']                  	= 'CP Tema/Stil';  // Blocktitle
$lang['SelectTheme']            	= 'Selecteaza Tema/Stilul:';

//
// Core Blocks - Search
//
$lang['Mx_Page'] 					= 'Pagina';
$lang['Mx_Block'] 					= 'Sectiune';

//
// Core Blocks - Site Log (and many last 'item' blocks)
//
$lang['No_items_found'] 			= 'Nimic nou de raportat. ';

//
// BlockCP
//
$lang['Block_Title']            	= 'Titlu';
$lang['Block_Info']            		= 'Informatii';

$lang['Block_Config_updated']   	= 'Configuratia blocului actualizata cu succes';
$lang['Block_Edit']             	= 'Editeaza Bloc';
$lang['Block_Edit_dyn']         	= 'Editeaza Blocul parinte dinamic';
$lang['Block_Edit_sub']         	= 'Editeaza Blocul parinte impartit';


$lang['General_updated_return_settings'] 	= 'Configuratia upgradata cu succes...<br /><br />Click %saici%s pentru a continua.'; // %s petru parametrii URI - NU IL SCOATE
$lang['General_update_error'] 			= 'Configuratia nu se poate upgrada...';

//
// Header
//
$lang['Mx_search_site'] 		= 'Site';
$lang['Mx_search_forum'] 		= 'Forum';
$lang['Mx_search_kb'] 			= 'Articole';
$lang['Mx_search_pafiledb'] 	= 'Download-uri';
$lang['Mx_search_google'] 		= 'Google';
$lang['Mx_new_search'] 			= 'Noua Cautare';


//
// Copyrights page
//
$lang['mx_about_title'] 			= 'Despre MXP Portal';
$lang['mx_copy_title'] 				= 'MXP Portal Informatii';
$lang['mx_copy_modules_title'] 		= 'Module MXP Portal Instalate';
$lang['mx_copy_template_title'] 	= 'Despre stil';
$lang['mx_copy_translation_title'] 	= 'Despre traducere';

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
$lang['TRANSLATION_INFO_MXBB'] = 'Traducerea in Limba Romana de <a href="http://www.mx-publisher.com/phpBB2/profile.php?mode=viewprofile&u=6605" target="_blank">FlorinCB</a>';

//
// Installation
//
$lang['Please_remove_install_contrib'] = 'Te rog asigura-te ca amandoua directoarele install/ si contrib/ sunt sterse';

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
// (no-diacritics)
// -------------------------------------------------

?>