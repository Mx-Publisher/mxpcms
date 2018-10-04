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
$lang['Page_Not_Authorised']    	= 'Ne pare r�u, dar nu e�ti autorizat s� accesezi aceast� pagin�.';
$lang['Execution_Stats'] 			= 'Pagina a generat %s querie - Timpul gener�rii: %s secunde';
$lang['Redirect_login']    			= 'Click %sAici%s s� te logezi.';
$lang['Show_admin_options']    		= 'Arat�/Ascunde Op�iunile Admin pe Pagin�: ';
$lang['Block_updated_date'] 		= 'Updatat ';
$lang['Block_updated_by'] 			= 'de ';
$lang['Powered_by'] 				= 'Powered by ';

$lang['mx_spacer'] 					= 'Spacer';
$lang['Yes'] 						= 'Da';
$lang['No'] 						= 'Nu';

$lang['Link'] = 'Leg�tur�';

$lang['Hidden_block'] 				= 'Block ascuns...';
$lang['Hidden_block_explain'] 		= 'Acest bloc este \'ascuns\', dar visibil deoarece e�ti un admin/moderator.';

//
// Overall Navigation Navigation
//
$lang['MX_home'] 					= 'Acas�';
$lang['MX_forum'] 					= 'Forum';

//
// Core Blocks - Language
//
$lang['Change_default_lang']   		= 'Seteaz� Limba Implicit�'; 
$lang['Change_user_lang']      		= 'Seteaz� Limba Ta'; 
$lang['Portal_lang']            	= 'LimbaCP';
$lang['Select_lang']          		= 'Selecteaz� Limba:';

//
// Core Blocks - Theme
//
$lang['Change']                 	= 'Schimb� Acum';
$lang['Change_default_style']   	= 'Seteaz� Silul Implicit'; 
$lang['Change_user_style']      	= 'Seteaz� Stilul T�u'; 
$lang['Theme']                  	= 'CP Tem�/Stil';  // Blocktitle
$lang['SelectTheme']            	= 'Selecteaz� Tema/Stilul:';

//
// Core Blocks - Search
//
$lang['Mx_Page'] 					= 'Pagin�';
$lang['Mx_Block'] 					= 'Sec�iune';

//
// Core Blocks - Site Log (and many last 'item' blocks)
//
$lang['No_items_found'] 			= 'Nimic nou de raportat. ';

//
// BlockCP
//
$lang['Block_Title']            	= 'Titlu';
$lang['Block_Info']            		= 'Informa�ii';

$lang['Block_Config_updated']   	= 'Configura�ia blocului actualizat� cu succes';
$lang['Block_Edit']             	= 'Editeaz� Bloc';
$lang['Block_Edit_dyn']         	= 'Editeaz� Blocul p�rinte dinamic';
$lang['Block_Edit_sub']         	= 'Editeaz� Blocul p�rinte �mp�r�it';


$lang['General_updated_return_settings'] 	= 'Configura�ia upgradat� cu succes...<br /><br />Click %saici%s pentru a continua.'; // %s petru parametrii URI - NU IL SCOATE
$lang['General_update_error'] 			= 'Configura�ia nu se poate upgrada...';

//
// Header
//
$lang['Mx_search_site'] 		= 'Site';
$lang['Mx_search_forum'] 		= 'Forum';
$lang['Mx_search_kb'] 			= 'Articole';
$lang['Mx_search_pafiledb'] 	= 'Download-uri';
$lang['Mx_search_google'] 		= 'Google';
$lang['Mx_new_search'] 			= 'Nou� C�utare';


//
// Copyrights page
//
$lang['mx_about_title'] 			= 'Despre Mx-Publisher Portal';
$lang['mx_copy_title'] 				= 'Mx-Publisher Portal Informa�ii';
$lang['mx_copy_modules_title'] 		= 'Module Mx-Publisher Portal Instalate';
$lang['mx_copy_template_title'] 	= 'Despre stil';
$lang['mx_copy_translation_title'] 	= 'Despre traducere';

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
$lang['TRANSLATION_INFO_MXBB'] = 'Traducerea �n Limba Rom�n� de <a href="http://mxpcms.sourceforge.net//phpBB2/profile.php?mode=viewprofile&u=6605" target="_blank">FlorinCB</a>';

//
// Installation
//
$lang['Please_remove_install_contrib'] = 'Te rog asigur�-te c� am�ndou� directoarele install/ �i contrib/ sunt �terse';

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