<?php
/***************************************************************************
 *                            lang_main.php [French]
 *                              -------------------
 ****************************************************************************/

//
// The format of this file is:
//
// ---> $lang['message'] = "text";
//
// You should also try to set a locale and a character
// encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may
// not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

// setlocale(LC_ALL, "fr");

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!

$lang['Portal_ALL']                = "TOUS";
$lang['Portal_REG']                = "MEMBRES";
$lang['Portal_PRIVATE']            = "PRIVE";
$lang['Portal_MOD']                = "MOD";
$lang['Portal_ADMIN']              = "ADMIN";


// Configuration
//
$lang['Portal_admin']              = "Administration du portal";
$lang['Portal_admin_explain']      = "Depuis ce panneau de contr�le, vous pouvez ajouter, supprimer, �diter, r�ordonner et resynchroniser votre portal.";

$lang['Portal_General_Config']     = "Configuration du Portal";
$lang['Portal_Config_explain']     = "Ce formulaire va vous permettre de configurer votre portal";
$lang['Portal_General_settings']   = "Configuration g�n�rale";
$lang['Portal_Name']               = "Nom du portal :";   
$lang['Portal_PHPBB_Url']          = "Adresse URL du module phpbb :";

$lang['Portal_Config_updated']     = "Informations du Portal mises � jour avec succ�s";
$lang['Click_return_portal_config']= "Cliquez %sici%s pour revenir � l'Administration du Portal";


//
// Menu Management
//

$lang['Menu_admin']                = "Administration des menus";
$lang['Menu_admin_explain']        = "Depuis ce panneau de contr�le, vous pouvez ajouter, supprimer, �diter, r�ordonner et resynchroniser vos cat�gories et menu.";

$lang['Menu_edit_delete_explain']  = "Depuis ce panneau de contr�le, vous pouvez modifier les informations sur cette option de menu";
$lang['Menu_settings']             = "Information du menu";

$lang['Menu_delete']               = "Supprimer un menu";
$lang['Menu_delete_explain']       = "Le formulaire ci-dessous vous permettra de supprimer un menu (ou une cat�gorie) ";


$lang['Edit_menu']                 = "Editer un menu";
$lang['Update']                    = "Mettre � jour";
$lang['Create_menu']               = "Cr�er un nouveau menu";
$lang['Create_category']           = "Cr�er une nouvelle cat�gorie";
$lang['Menu_Config_updated']       = "Configuration du Menu mise � jour avec succ�s";
$lang['Menus_updated']             = "Informations du Menu et de la Cat�gorie mises � jour avec succ�s";
$lang['Click_return_menuadmin']    = "Cliquez %sici%s pour revenir � l'Administration des Menus";
$lang['Menu_name']                 = "Nom du menu ";
$lang['Menu_desc']                 = "Description ";
$lang['Menu_links']                = 'Lien Web ';
$lang['Category']                  = "Cat�gorie ";

$lang['Edit']                      = "Editer";
$lang['Delete']                    = "Supprimer";
$lang['Move_up']                   = "Monter";
$lang['Move_down']                 = "Descendre";
$lang['Resync']                    = "Resynchroniser";

$lang['Click_return_admin_index']  = "Cliquez %sici%s pour revenir � l'Index d'Administration";

//
// Module Management
//

$lang['Modules']                   = "Modules";

$lang['Module_admin']              = "Administration des modules";
$lang['Module_Config_explain']     = "Ce formulaire va vous permettre de configurer vos modules";

$lang['Column_delete']             = "Supprimer un Colonne";

$lang['Module_delete']             = "Supprimer un module";
$lang['Module_delete_explain']     = "Le formulaire ci-dessous vous permettra de supprimer un module (ou une colonne) ";


$lang['Edit_module']               = "Editer un module";
$lang['Create_module']             = "Cr�er un nouveau module";
$lang['Module_Config_updated']     = "Configuration du Module mise � jour avec succ�s";
$lang['Module_updated']            = "Informations du Module et de la Cat�gorie mises � jour avec succ�s";
$lang['Click_return_moduleadmin']  = "Cliquez %sici%s pour revenir � l'Administration des modules";

$lang['Column_name']              = "Nom de la colonne";

$lang['Module_name']              = "Nom du Module";
$lang['Module_desc']              = "Description";
$lang['Module_var_text']          = "Text pour block variable";
$lang['Module_path']              = "Path pour le module";
$lang['Module_file']              = "Nom du Fichier";
$lang['Module_display']           = "Afficher le module ";
$lang['Create_column']            = "Cr�er une nouvelle colonne";

$lang['Column']                   = "Colonne";

$lang['Edit_Column']              = "Editer une Colonne";
$lang['Edit_Column_explain']      = "Utilisez ce formulaire pour modifer une Colonne.";

// delete size_column
$lang['Column_Size']              = "Largeur de la colonne";

// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!

$lang['Module_ALL']               = "TOUS";
$lang['Module_REG']               = "MEMBRES";
$lang['Module_PRIVATE']           = "PRIVE";
$lang['Module_MOD']               = "MOD";
$lang['Module_ADMIN']             = "ADMIN";

$lang['Auth_Module']              = "Permissions" ;

$lang['Menu Navigation']          = "Menu de Navigation";
$lang['Modules']                   = "Modules";
$lang['Poll Administration']       = "Sondage Administration";

$lang['Portal_index']              = "Index du Portal";

$lang['Module Last Message']      = "Administration du module Dernier Message"; 
$lang['Module News']              = "Administration du module News"; 
$lang['Module Weather']           = "Administration du module M�t�o";  

$lang['Poll_Settings']            = "Configuration du module - Sondage :";
$lang['Poll_Display']             = "Quel sondage voulez-vous afficher ?";

$lang['Welcome_install']          = "Bienvenue a MX-Portal Installation";
$lang['Install_Instruction']      = "Merci d'avoir choisie MX-System comme solution de Portal. Afin d'achever cette installation, veuillez remplir les d�tails demand�s ci-dessous. Veuillez noter que PHPBB doit �tre installer avant de faire l'installation du portal";
$lang['Language']                 = "Langue";
$lang['Initial_config']           = "Configuration de base";
$lang['Install_lang']             = "Choisissez la Langue pour l'Installation";
$lang['Table_Prefix']             = "Pr�fixe des tables";
$lang['Installer_Error']          = "Une erreur s'est produite durant l'installation";
$lang['Install_db_error']         = "Une erreur s'est produite en essayant de mettre � jour la base de donn�es";
$lang['Phpbb_path']               = "Phpbb path";
$lang['Phpbb_path_explain']       = "Entrez le chemin o� PHPBB est install�";
$lang['Phpbb_url']                = "Phpbb url";
$lang['Phpbb_url_explain']        = "Adresse Web o� phpBB2 is installed ( cette url est utilis� pour afficher les images sur le portal";

$lang['Install']                  = "Install";

$lang['Portal_intalled']          = "Portal install� avec succ�s";

$lang['Update_Old_Version']         = "Update une autre version du portal :";

//
// That's all Folks!
// -------------------------------------------------

?>