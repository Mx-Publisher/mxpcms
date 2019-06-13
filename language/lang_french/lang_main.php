<?php
/**
*
* @package MX-Publisher CMS Core
* @version $Id: lang_main.php,v 1.4 2013/06/28 15:34:31 orynider Exp $
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

setlocale(LC_ALL, 'fr');

$lang['USER_LANG'] = 'fr';
$lang['ENCODING'] = 'UTF-8';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'gauche';
$lang['RIGHT'] = 'droit';
$lang['DATE_FORMAT'] =  'd/M/Y'; // This should be changed to the default date format for your language, php date() format


$lang['message'] = 'text'; 
// 
// Specify your language character encoding... [optional] 
// 
// setlocale(LC_ALL, 'en'); 

// 
// General 
// 
$lang['Page_Not_Authorised'] = 'Désolé, Vous n\'êtes pas autorisé à acceder à cette page.'; 
$lang['Execution_Stats'] = 'Page générée en %s requêtes - %s secondes'; 
$lang['Redirect_login'] = 'Cliquez %sIci%s pour vous identifier.'; 
$lang['Show_admin_options'] = 'Afficher/Masquer les options d\'administrateur'; 
$lang['Block_updated_date'] = 'Mis à jour '; 
$lang['Block_updated_by'] = 'par '; 
$lang['Page_updated_date'] = 'Cette page a été mise à jour le '; 
$lang['Page_updated_by'] = 'par '; 
$lang['Powered_by'] = 'Powered by '; 

$lang['mx_spacer'] = 'Séparateur'; 
$lang['Yes'] = 'Oui'; 
$lang['No'] = 'Non'; 

$lang['Link'] = 'Lien'; 

$lang['Hidden_block'] = 'Bloc Masqué'; 
$lang['Hidden_block_explain'] = 'Ce bloc est \'masqué\', mais visible tant que vous êtes admin/modérateur.'; 

// 
// Overall Navigation Navigation 
// 
$lang['MX_home'] = 'Accueil'; 
$lang['MX_forum'] = 'Forum'; 
$lang['MX_navigation'] = 'Pages navigation, eg. forum navigation, like pafiledb navigation.';
// 
// Core Blocks - Language 
// 
$lang['Change_default_lang'] = 'Définir la Langue par Défaut du Portail'; 
$lang['Change_user_lang'] = 'Définir votre Langue'; 
$lang['Portal_lang'] = 'LangageCP'; 
$lang['Select_lang'] = 'Selectionner la Langue:'; 

// 
// Core Blocks - Theme 
// 
$lang['Change'] = 'Modifier Maintenant'; 
$lang['Change_default_style'] = 'Définir le Style par défaut du portail'; 
$lang['Change_user_style'] = 'Définir votre Style'; 
$lang['Theme'] = 'ThemeCP/StyleCP'; 
$lang['Select_theme'] = 'Selectionner Theme/Style:'; 

// 
// Core Blocks - Search 
// 
$lang['Mx_Page'] = 'Page'; 
$lang['Mx_Block'] = 'Section'; 

// 
// Core Blocks - Virtual 
// 
$lang['Virtual_Create_new'] = 'Créer une nouvelle '; 
$lang['Virtual_Create_new_user'] = 'Page Utilisateur'; 
$lang['Virtual_Create_new_group'] = 'Page Groupe'; 
$lang['Virtual_Create_new_project'] = 'Page Projet'; 
$lang['Virtual_Create'] = 'Créer maintenant'; 
$lang['Virtual_Edit'] = 'Mettre à jour le nom de la page'; 
$lang['Virtual_Delete'] = 'Supprimer cette page'; 

$lang['Virtual_Welcome'] = 'Bienvenue '; 
$lang['Virtual_Info'] = 'Ici vous pouvez controler votre page web personnelle.'; 
$lang['Virtual_CP'] = 'Panneau de Contrôle de la Page'; 
$lang['Virtual_Go'] = 'Go'; 
$lang['Virtual_Select'] = 'Selectionner:'; 

// 
// Core Blocks - Site Log (and many last 'item' blocks) 
// 
$lang['No_items_found'] = 'Rien de neuf à signaler. '; 

// 
// BlockCP 
// 
$lang['Block_Title'] = 'Titre'; 
$lang['Block_Info'] = 'Information'; 

$lang['Block_Config_updated'] = 'Configuration de Bloc mise à jour.'; 
$lang['Edit'] = 'EDITER';
$lang['Block_Edit'] = 'Editer le Bloc'; 
$lang['Block_Edit_dyn'] = 'Editer le bloc dynamique parent'; 
$lang['Block_Edit_sub'] = 'Editer le bloc subdivisé parent'; 

$lang['General_updated_return_settings'] = 'Configuration mise à jour.<br><br>Cliquer %sici%s pour continuer.'; // %s's for URI params - DO NOT REMOVE 
$lang['General_update_error'] = 'Impossible de mettre la Configuration à jour.'; 

// 
// Header 
// 
$lang['Mx_search_site'] = 'Site'; 
$lang['Mx_search_forum'] = 'Forum'; 
$lang['Mx_search_kb'] = 'Articles'; 
$lang['Mx_search_pafiledb'] = 'Téléchargements'; 
$lang['Mx_search_google'] = 'Google'; 
$lang['Mx_new_search'] = 'Nouvelle recherche'; 

// 
// Copyrights page 
// 
$lang['mx_about_title'] = 'A propos de MX-Publisher'; 
$lang['mx_copy_title'] = 'Informations sur MX-Publisher'; 
$lang['mx_copy_modules_title'] = 'Modules MX-Publisher Installés'; 
$lang['mx_copy_template_title'] = 'A propos du style'; 
$lang['mx_copy_translation_title'] = 'A propos de la traduction'; 

// This is optional, if you would like a _SHORT_ message output 
// along with our copyright message indicating you are the translator 
// please add it here. 
$lang['TRANSLATION_INFO_MXBB'] = 'Traduction vers le français par <a href="http://mxpcms.sourceforge.net//phpBB2/profile.php?mode=viewprofile&u=7879" target="_blank">sturmy</a>';


// 
// Installation 
// 
$lang['Please_remove_install_contrib'] = 'Assurez vous que les deux répertoires install/ et contrib/ sont supprimés.'; 


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

//// C'est tout le monde. 
// -------------------------------------------------

?>