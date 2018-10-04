<?php
/**
*
* @package MX-Publisher Core
* @version $Id: lang_main.php,v 1.4 2008/06/03 20:04:29 jonohlsson Exp $
* @copyright (c) 2002-2006 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

//
// The format of this file is:
//
// ---> $lang['message'] = 'text';
//
// Specify your language character encoding... [optional]
//
setlocale(LC_ALL, 'sv');

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
$lang['TRANSLATION_INFO_MXBB'] 		= '<a href="http://www.mx-publisher.com" target="_blank" class="gensmall">Swedish</a> translation by <a href="mailto:jon.ohlsson@mx-publisher.com" title="Jon Ohlsson" class="gensmall">Jon Ohlsson</a> &copy; 2004-2008';

//
// General
//
$lang['Page_Not_Authorised']    	= 'Tyvärr, du saknar rättighet att besöka denna sida.';
$lang['Execution_Stats'] 			= 'Sidan genererade %s db-frågor - Tid: %s sekunder';
$lang['Redirect_login']    			= 'Klicka %shär%s för att logga in.';
$lang['Show_admin_options']    		= 'Visa/d&ouml;lj sidadminkontroller: ';
$lang['Block_updated_date'] 		= 'Uppdaterad ';
$lang['Block_updated_by'] 			= 'av ';
$lang['Page_updated_date'] 			= 'Sidan uppdaterades ';
$lang['Page_updated_by'] 			= 'av ';
$lang['Powered_by'] 				= 'Sidan genereras av ';

$lang['mx_spacer'] 					= 'Spacer';
$lang['Yes'] 						= 'Ja';
$lang['No'] 						= 'Nej';

$lang['Hidden_block'] 				= 'Dolt block...';
$lang['Hidden_block_explain'] 		= 'Detta block är \'dolt\', men visas eftersom du är admin/moderator';

//
// Overall Navigation Navigation
//
$lang['MX_home'] 					= 'Hem';
$lang['MX_forum'] 					= 'Diskussionsforum';

//
// Core Blocks - Language
//
$lang['Change_default_lang']   		= 'Standardspråk:';
$lang['Change_user_lang']      		= 'Ditt standardspråk:';
$lang['Portal_lang']            	= 'Språk';
$lang['Select_lang']          		= 'Välj språk:';

//
// Core Blocks - Theme
//
$lang['Change']                 	= 'Ändra nu';
$lang['Change_default_style']   	= 'Standardutseende:';
$lang['Change_user_style']      	= 'Ditt utseende:';
$lang['Theme']                  	= 'Tema/Layout';
$lang['SelectTheme']            	= 'Välj Tema/Layout:';

//
// Core Blocks - Search
//
$lang['Mx_Page'] 					= 'Sida';
$lang['Mx_Block'] 					= 'Rubrik';

//
// Core Blocks - Virtual
//
$lang['Virtual_Create_new'] = 'Skapa ny ';
$lang['Virtual_Create_new_user'] = 'användarsida';
$lang['Virtual_Create_new_group'] = 'gruppsida';
$lang['Virtual_Create_new_project'] = 'Projektsida';
$lang['Virtual_Create'] = 'Skapa nu';
$lang['Virtual_Edit'] = 'Ändra sidnamnet';
$lang['Virtual_Delete'] = 'Ta bort sidan';

$lang['Virtual_Welcome'] = 'Välkommen ';
$lang['Virtual_Info'] = 'Här kan du hantera din webbsida.';
$lang['Virtual_CP'] = 'Sidkontrollpanel';
$lang['Virtual_Go'] = 'Gå';
$lang['Virtual_Select'] = 'Välj:';

//
// Core Blocks - Site Log (and many last 'item' blocks)
//
$lang['No_items_found'] 			= 'Inget nytt ... ';

//
// BlockCP
//
$lang['Block_Title']            	= 'Titel';
$lang['Block_Info']            	 	= 'Information';

$lang['Block_Config_updated']   	= 'Blockkonfigurationen uppdaterades...';
$lang['Block_Edit']             	= 'Ändra block';
$lang['Block_Edit_dyn']         	= 'Ändra dynamiskt block';
$lang['Block_Edit_sub']         	= 'Ändra uppdelat block';

$lang['General_updated_return_settings'] 	= 'Valet uppdaterades...<br /><br />Klicka %shär%s för att återgå.'; // %s's for URI params - DO NOT REMOVE
$lang['General_update_error'] 				= 'Lyckades INTE uppdatera valet...';

//
// Header
//
$lang['Mx_search_site'] 			= 'Hela sidan';
$lang['Mx_search_forum'] 			= 'Forumsinl&auml;gg';
$lang['Mx_search_kb'] 				= 'Artiklar';
$lang['Mx_search_pafiledb'] 		= 'Nedladdningar';
$lang['Mx_search_google'] 			= 'Google';
$lang['Mx_new_search'] 				= 'Ny sökning';

//
// Copyrights page
//
$lang['mx_about_title'] 			= 'About MX-Publisher';
$lang['mx_copy_title'] 				= 'MX-Publisher Information';
$lang['mx_copy_modules_title'] 		= 'Installed MX-Publisher Modules';
$lang['mx_copy_template_title'] 	= 'About the style';
$lang['mx_copy_translation_title'] 	= 'About the translation';

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
//$lang['TRANSLATION_INFO_MXBB'] = 'English Language by <a href="http://www.mx-publisher.com" target="_blank">MX-Publisher Development Team</a>';

//
// Installation
//
$lang['Please_remove_install_contrib'] = 'Please ensure both the install/ and contrib/ directories are deleted';

//
// Multilangual page titles
// - To have multilangual page titles, add lang keys 'pagetitle_PAGE_TITLE' below
// - This lang key replaces the page title (PAGE_TITLE) for the page given in the adminCP
//
//$lang['pagetitle_NameOfFirstPage'] 				= 'Whatever one';
//$lang['pagetitle_NameOfSecondPage'] 				= 'Whatever two';

//
// Multilangual block titles
// - To have multilangual block titles, add lang keys 'blocktitle_BLOCK_TITLE' below
// - This lang key replaces the block title (BLOCK_TITLE) for the block given in the adminCP/blockCP
//
//$lang['blocktitle_NameOfFirstPage'] 				= 'Whatever one';
//$lang['blocktitle_NameOfSecondPage'] 				= 'Whatever two';

//
// That's all Folks!
// -------------------------------------------------
?>