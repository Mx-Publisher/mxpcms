<?php
/**
*
* @package MXP Portal Core
* @version $Id: lang_admin.php,v 1.5 2013/06/28 17:08:52 orynider Exp $
* @copyright (c) 2002-2006 MXP Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

/*  Editor Settings: Please set Tabsize to 4 ;-)  */ 
 
/*  The format of this file is:  ---> $lang['message'] = 'text';
/*  Specify your language character encoding... [optional] */
setlocale(LC_ALL, "fr");


$lang['ENCODING'] = 'UTF-8';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'gauche';
$lang['RIGHT'] = 'droit';
$lang['DATE_FORMAT'] =  'd/M/Y'; // This should be changed to the default date format for your language, php date() format

$lang['Mx-Publisher_adminCP'] = 'Administration de MX-Publisher'; 
$lang['Portal_Desc'] = 'A little text to describe your website.';

/* Left AdminCP Panel */
$lang['1_General_admin'] = 'Général'; 
$lang['1_1_Management'] = 'Configuration'; 
$lang['1_2_WordCensors'] = 'Mots Censurés'; 

$lang['2_CP'] = 'Management'; 
$lang['2_1_Modules'] = 'Configuration des Modules<br><hr>'; 
$lang['2_2_ModuleCP'] = 'Panneau de contrôle de Module'; 
$lang['2_3_BlockCP'] = 'Panneau de contrôle de Bloc'; 
$lang['2_4_PageCP'] = 'Panneau de contrôle de Page'; 

$lang['3_CP'] = 'Styles'; 
$lang['2_1_new'] = 'Ajouter un nouveau'; 
$lang['2_2_manage'] = 'Gérer'; 
$lang['2_3_smilies'] = 'Smilies'; 

$lang['4_Panel_system'] = 'Outils Système'; 
$lang['4_1_Cache'] = 'Régénérer le Cache'; 
$lang['4_1_Integrity'] = 'Vérification d\'Integrité'; 
$lang['4_1_Meta'] = 'Tags META'; 
$lang['4_1_PHPinfo'] = 'phpInfo()'; 

/* Index */
$lang['Welcome_Mx-Publisher'] = 'Bienvenue dans MX-Publisher'; 
$lang['Admin_intro_Mx-Publisher'] = 'Merci d\'avoir choisi MX-Publisher comme solution de portail/cms et phpBB comme solution de forum. Cet écran vous donnera un aperçu rapide de diverses statistiques de votre site. Vous pouvez revenir à cette page en cliquant sur le lien <span>Index d\'Administration</span> dans le panneau de gauche. Pour revenir à l\'index de votre portail, cliquez sur le logo qui est aussi dans le panneau de gauche. Les autres liens de la partie gauche de cet écran vous permettent de contrôler tous les aspects de votre utilisation du portail et du forum. Chaque écran comporte des instructions quant à comment utiliser les outils fournis.'; 

/* General */
$lang['Yes'] = 'Oui'; 
$lang['No'] = 'Non'; 
$lang['No_modules'] = 'Aucun module n\'est installé.'; 
$lang['No_functions'] = 'Ce module n\'a aucune fonction de bloc.'; 
$lang['No_parameters'] = 'Cette fonction n\'a pas de paramètre.'; 
$lang['No_blocks'] = 'Aucun bloc n\'existe pour cette fonction.'; 
$lang['No_pages'] = 'Aucune page n\'existe ici.'; 
$lang['No_settings'] = 'Aucun autre paramètre pour ce bloc.'; 
$lang['Quick_nav'] = 'Navigation rapide'; 
$lang['Include_all_modules'] = 'Afficher tous les modules'; 
$lang['Include_block_quickedit'] = 'Inclure le panneau EditionRapide de Bloc'; 
$lang['Include_block_private'] = 'Inclure le panneau Autorisations Privées de Bloc'; 
$lang['Include_all_pages'] = 'Afficher toutes les pages'; 
$lang['View'] = 'Voir'; 
$lang['Edit'] = 'Editer'; 
$lang['Delete'] = 'Supprimer'; 
$lang['Settings'] = 'Paramètres'; 
$lang['Move_up'] = 'Monter'; 
$lang['Move_down'] = 'Descendre'; 
$lang['Resync'] = 'Resynchroniser'; 
$lang['Update'] = 'Mettre à Jour'; 
$lang['Permissions'] = 'Permissions'; 
$lang['Permissions_std'] = 'Permissions Standard'; 
$lang['Permissions_adv'] = 'Permissions Avancées'; 
$lang['return_to_page'] = 'Retour à la Page du Portail'; 
$lang['Use_default'] = 'Utiliser la configuration par défaut'; 

$lang['AdminCP_status'] = '<b>Rapport d\'état</b>'; 
$lang['AdminCP_action'] = '<b>Actions sur Base de Données</b>'; 
$lang['Invalid_action'] = 'Erreur'; 
$lang['was_installed'] = 'a été installé.'; 
$lang['was_uninstalled'] = 'a été désinstallé.'; 
$lang['was_upgraded'] = 'a été upgradé'; 
$lang['was_exported'] = 'a été exporté'; 
$lang['was_deleted'] = 'a été effacé'; 
$lang['was_removed'] = 'a été retiré'; 
$lang['was_inserted'] = 'a été inséré'; 
$lang['was_updated'] = 'a été mis à jour'; 
$lang['was_added'] = 'a été ajouté'; 
$lang['was_moved'] = 'a été déplacé'; 
$lang['was_synced'] = 'a été synchronisé'; 

$lang['error_no_field'] = 'Il manque un champ. Veuillez remplir tous les champs requis.'; 

/* Configuration */
$lang['Portal_admin'] = 'Administration du portail'; 
$lang['Portal_admin_explain'] = 'Utilisez ce formulaire pour personnaliser votre portail'; 
$lang['Portal_General_Config'] = 'Configuration du portail'; 
$lang['Portal_General_Config_explain'] = 'Utilisez ce formulaire pour gérer les principaux réglages de votre site MX-Publisher.'; 
$lang['Portal_General_settings'] = 'Réglages Généraux'; 
$lang['Portal_Style_settings'] = 'Réglages de Style'; 
$lang['Portal_General_config_info'] = 'Infos Générales de Configuration du Portail '; 
$lang['Portal_General_config_info_explain'] = 'Informations d\'installation actuelles issues de config.php (aucune modification requise)'; 
$lang['Portal_Name'] = 'Nom du Portail:'; 
$lang['Portal_PHPBB_Url'] = 'URL de votre installation phpBB:'; 
$lang['Portal_Url'] = 'URL de MX-Publisher:'; 
$lang['Portal_Config_updated'] = 'Configuration du Portail Configuration Mise à Jour'; 
$lang['Click_return_portal_config'] = 'Cliquer %sIci%s pour revenir à la Configuration du Portail'; 
$lang['PHPBB_info'] = 'Info phpBB'; 
$lang['PHPBB_version'] = 'Version phpBB:'; 
$lang['PHPBB_script_path'] = 'Chemin de Script phpBB:'; 
$lang['PHPBB_server_name'] = 'Domaine phpBB (server_name):'; 
$lang['MX_Portal'] = 'MX-Publisher'; 
$lang['MX_Modules'] = 'Modules MXP'; 
$lang['Phpbb'] = 'phpBB'; 
$lang['Top_phpbb_links'] = 'Statistiques phpBB dans l\'en-tête (valeur par défaut)'; 
$lang['Top_phpbb_links_explain'] = '- Liens vers les nouveaux messages non lus'; 
$lang['Portal_version'] = 'Version MX-Publisher:'; 
$lang['Mx_use_cache'] = 'Utiliser le Cache de Bloc MX-Publisher'; 
$lang['Mx_use_cache_explain'] = 'Les données de Blocs sont mise en cache dans des fichiers individuels cache/block_*.xml. Les fichiers de cache de Bloc sont créés/mis à jour quand les blocs sont edités.'; 
$lang['Mx_mod_rewrite'] = 'Utiliser mod_rewrite'; 
$lang['Mx_mod_rewrite_explain'] = 'Si vous utilisez un serveur Apache et avez mod_rewrite activé, vous pouvez réécrire les URLs; par exemple, vous pouvez réécrire des pages comme \'page=x\' avec des alternatives plus intuitives. Merci de lire la documentation complémentaire du module mx_mod_rewrite.'; 
$lang['Portal_Overall_header'] = 'Fichier d\'en-tête global (valeur par défaut)'; 
$lang['Portal_Overall_header_explain'] = '- Ceci est le fichier de modèle par défaut overall_header, i.e. overall_header.tpl.'; 
$lang['Portal_Overall_footer'] = 'Fichier de bas de page global (value par défaut)'; 
$lang['Portal_Overall_footer_explain'] = '- Ceci est le fichier de modèle par défaut overall_footer, i.e. overall_footer.tpl.'; 
$lang['Portal_Main_layout'] = 'Fichier de Disposition Générale (valeur par défaut)'; 
$lang['Portal_Main_layout_explain'] = '- Ceci est le fichier de modèle par défaut main_layout, i.e. mx_main_layout.tpl.'; 
$lang['Portal_Navigation_block'] = 'Bloc de Navigation général Overall Navigation Block (valeur par défaut)'; 
$lang['Portal_Navigation_block_explain'] = '- Ceci est le bloc de navigation d\'en-tête de page, a supposer que vous avez choisi un fichier d\'en-tête général qui accepte la navigation de page.'; 
$lang['Default_style'] = 'Style des Pages de Portail (par défaut)'; 
$lang['Default_admin_style'] = 'Style du Panneau Admin'; 
$lang['Select_page_style'] = "Sélectionner (ou utiliser le choix par défaut)"; 
$lang['Override_style'] = 'Ignorer le style utilisateur'; 
$lang['Override_style_explain'] = 'Remplace le style choisi par les utilisateurs par celui par défaut (pour les pages)'; 
$lang['Portal_status'] = 'Activer le portail'; 
$lang['Portal_status_explain'] = 'Choix pratique, durant une reconstruction du site. Seul les adminstrateurs peuvent voir les pages et naviguer normalement. Quand désactivé, le message ci-dessous est affiché.'; 
$lang['Disabled_message'] = 'Message de Portail désactivé'; 
$lang['Portal_Backend'] = 'Backend Utilisateur/Session pour MX-Publisher'; 
$lang['Portal_Backend_explain'] = 'Selectionner les sessions utilisateurs issus du backend interne, phpBB2 ou phpBB3'; 
$lang['Portal_Backend_path'] = 'Chemin relatif vers phpBB [non-interne]'; 
$lang['Portal_Backend_path_explain'] = 'Si vous utilisez des sessuions et utilisateurs non-internes, entrez le chemin relatif vers phpbb, eg \'phpBB2/\' ou \'../phpBB2/\'. Note: les slashs sont importants.'; 
$lang['Portal_Backend_submit'] = 'Changer et valider le Backend'; 
$lang['Portal_config_valid'] = 'Statut de Backend actuel: '; 
$lang['Portal_config_valid_true'] = '<b><font>Valide</font></b>'; 
$lang['Portal_config_valid_false'] = '<b><font>Mauvaise Installation. Soit le chemin relatif phpBB est faux soit phpBB n\'est pas installé (votre base de données phpBB est indisponible). Ainsi, le backend \'interne\' est utilisé.</font></b>'; 

/* Module Management */
$lang['Module_admin'] = 'Administration des Modules'; 
$lang['Module_admin_explain'] = 'Utiliser ce formulaire pour gérer les modules: installation, mise à jour et développement.<br><b>Pour utiliser ce panneau, JavaScript et les cookies doivent être activés dans votre navigateur!</b>'; 
$lang['Modulecp_admin'] = 'Panneau de Contrôle de Modules'; 
$lang['Modulecp_admin_explain'] = 'Utiliser ce formulaire pour gérer les modules: fonctions de bloc (paramètres) et blocs de portail.<br><b>Pour utiliser ce panneau, JavaScript et les cookies doivent être activés dans votre navigateur!</b>'; 
$lang['Modules'] = 'Modules'; 
$lang['Module'] = 'Module'; 
$lang['Module_delete'] = 'Supprimer un Module'; 
$lang['Module_delete_explain'] = 'Utiliser ce formulaire pour supprimer un module (ou une fonction de bloc)'; 
$lang['Edit_module'] = 'Editer un Module'; 
$lang['Create_module'] = 'Créer un Nouveau Module'; 
$lang['Module_name'] = 'Nom du Module'; 
$lang['Module_desc'] = 'Description'; 
$lang['Module_path'] = 'Chemin, ex. \'modules/mx_textblocks/\''; 
$lang['Module_include_admin'] = 'Inclure ce module dans la navigation du Panneau Administrateur'; 

/*Module Installation */
$lang['Module_delete_db'] = 'Etes-vous sur de vouloir désinstaller ce mondule? Attention: Vous perdrez toutes les données du module. Songez plutôt à mettre à jour.'; 
$lang['Click_module_delete_yes'] = 'Cliquer %sIci%s pour désinstaller ce module'; 
$lang['Click_module_upgrade_yes'] = 'Cliquer %sIci%s pour mettre à jour ce module'; 
$lang['Click_module_export_yes'] = 'Cliquer %sIci%s pour exporter ce module'; 
$lang['Error_no_db_install'] = 'Erreur: Le fichier db_install.php n\'existe pas. Merci de vérifier cela et réessayer.'; 
$lang['Error_no_db_uninstall'] = 'Erreur: Le fichier db_uninstall.php n\'existe pas, ou la fonctionnalité de désinstallation n\'est pas prise en charge par ce module. Merci de vérifier cela et réessayer.'; 
$lang['Error_no_db_upgrade'] = 'Erreur: Le fichier db_upgrade.php n\'existe pas, ou la fonctionnalité de mise à jour n\'est pas prise en charge par ce module. Merci de vérifier cela et réessayer.'; 
$lang['Error_module_installed'] = 'Erreur: Ce module est déjà installé! Merci de supprimer d\'abord ce module, ou de le mettre à jour.'; 
$lang['Uninstall_module'] = 'Désinstaller le Module'; 
$lang['import_module_pack'] = 'Installer le Module'; 
$lang['import_module_pack_explain'] = 'Ceci va installer un module dans le portail. Assurez vous que le package du module est uploadé dans le répertoire /modules/ . Souvenez-vous d\'utiliser la version la plus récente du module!'; 
$lang['upgrade_module_pack'] = 'Mettre à jour le Module'; 
$lang['upgrade_module_pack_explain']= 'Ceci va mettre à jour votre module. Assurez vous de lire la documentation du module avant de continuer, ou vous risquez de perdre les données du module.'; 
$lang['export_module_pack'] = 'Exporter le Module'; 
$lang['Export_Module'] = 'Selectionner un Module:'; 
$lang['export_module_pack_explain'] = 'Ceci va exporter un fichier *.pak du module. Ceci est conçu pour les auteurs de modules; les utilisateurs standard n\'ont pas à se soucier de cela.'; 
$lang['Module_Config_updated'] = 'Configuration de Module Mise à jour correctement'; 
$lang['Click_return_module_admin'] = 'Cliquer %sIci%s pour revenir à l\'administration des Modules'; 
$lang['Module_updated'] = 'Information de Module Mise à jour correctement'; 
$lang['list_of_queries'] = 'Ceci est la liste des résultats des requêtes SQL requises pour l\'installation/mise à jour'; 
$lang['already_added'] = 'Erreur ou Déjà Ajouté'; 
$lang['added_upgraded'] = 'Ajouté/Mis à jour'; 
$lang['upgrading_modules'] = 'Si vous avez des Messages Erreur, Déjà Ajouté ou Mis à jour, détendez-vous, ceci est normal lors de la mise à jour de mods'; 
$lang['consider_upgrading'] = 'Le Module est déjà installé...Envisagez de mettre à jour;)'; 
$lang['upgrading'] = 'Mise à jour'; 
$lang['module_upgrade'] = 'C\'est une mise à jour'; 
$lang['nothing_upgrade'] = 'Rien à mettre à jour...'; 
$lang['upgraded_to_ver'] = '...Mise à jour faite en v. '; 
$lang['module_not_installed'] = 'Module non installé...et donc ne peut être mis à jour'; 
$lang['fresh_install'] = 'C\'est une nouvelles installation'; 
$lang['module_install_info'] = 'Information Installation/Mise à Jour/Désinstallation de Mod - tables de BdD spécifiques'; 

/* Functions & Parameters Administration */
$lang['Function_admin'] = 'Aministration de Fonctions de Bloc'; 
$lang['Function_admin_explain'] = 'Les modules ont une ou plus fonction de bloc. Utilisez ce formulaire pour éditer, ajouter ou supprimer une fonction de bloc'; 
$lang['Function'] = 'Fonction de Bloc'; 
$lang['Function_name'] = 'Nom de Fonction de Bloc'; 
$lang['Function_desc'] = 'Description'; 
$lang['Function_file'] = 'Fichier '; 
$lang['Function_admin_file'] = 'Fichier (Editer le script de bloc) <br> Paramètres supplémentaires pour ce panneau d\'édition de bloc. Laisser vide pour utiliser le panneau d\'édition par défaut.'; 
$lang['Create_function'] = 'Ajouter une Nouvelle Fonction de Bloc'; 
$lang['Delete_function'] = 'Supprimer une Fonction de Bloc'; 
$lang['Delete_function_explain'] = 'Ceci supprimera la fonction et tous ses blocs de portail associés. Attention: cette opération ne peut être annulée!'; 
$lang['Click_function_delete_yes'] = 'Cliquer %sIci%s pour supprimer la Fonction'; 

$lang['Parameter_admin'] = 'Administration des Paramètres de Fonction'; 
$lang['Parameter_admin_explain'] = 'Lister tous les paramètres de cette fonction'; 
$lang['Parameter'] = 'Paramètre'; 
$lang['Parameter_name'] = '<b>Nom du Paramètre</b><br>- à utiliser pour accéder au paramètre'; 
$lang['Parameter_type'] = '<b>Type du Paramètre</b>'; 
$lang['Parameter_default'] = '<b>Valeur par Défaut</b>'; 
$lang['Parameter_function'] = '<b>Fonction/Options</b>'; 
$lang['Parameter_function_explain'] = '<b>Fonction</b> (quand le type \'Fonction\' est utilisé)<br>- Vous pouvez passer les données du paramètre data à une fonction externe <br> pour générer le champ de formulaire du paramètre.<br>- Par exemple: <br>get_list_formatted("block_list","{parameter_value}","{parameter_id}[]")'; 
$lang['Parameter_function_explain'] .= '<br><br><b>Option(s)</b> (quand le type \'Selection\' est utilisé)<br>- Pour tous les paramètres de selection (boutons radios, case à cocher et menus) toutes les options sont listées ici, une option par ligne.'; 
$lang['Parameter_auth'] = '<b>Admin/Modérateur de Bloc seulement</b>'; 

$lang['Parameters'] = 'Paramètres'; 
$lang['Parameter_id'] = 'ID'; 
$lang['Create_parameter'] = 'Ajouter un Nouveau Paramètre'; 
$lang['Delete_parameter'] = 'Supprimer un Paramètre de Fonction'; 
$lang['Delete_parameter_explain'] = 'Ceci va supprimer le paramètre et mettre à jout tous les blocs associés du portail. Attention cette opération ne peut être annulée!'; 
$lang['Click_parameter_delete_yes'] = 'Cliquer %sIci%s pour supprimer le Paramètre'; 

/* Parameter Types */
$lang['ParType_BBText'] = 'Bloc Texte BBCode Simple'; 
$lang['ParType_BBText_info'] = 'Ceci est un Bloc Texte simple qui interprète le BBCode'; 
$lang['ParType_Html'] = 'Bloc Texte HTML Simple'; 
$lang['ParType_Html_info'] = 'Ceci est un Bloc Texte simple qui interprète le HTML'; 
$lang['ParType_Text'] = 'Texte Seul (une seule ligne)'; 
$lang['ParType_Text_info'] = 'Ceci est un champ de texte simple'; 
$lang['ParType_TextArea'] = 'Zone de Texte Seul (multi-lignes)'; 
$lang['ParType_TextArea_info'] = 'Ceci est une zone de texte seul'; 
$lang['ParType_Boolean'] = 'Booléen'; 
$lang['ParType_Boolean_info'] = 'Cecu est un bouton radio \'oui\' ou \'non\'.'; 
$lang['ParType_Number'] = 'Chiffre'; 
$lang['ParType_Number_info'] = 'Ceci est un champ de valeur numérique'; 
$lang['ParType_Function'] = 'fonction Paramètre'; 
$lang['ParType_Values'] = 'Valeurs'; 

$lang['ParType_Radio_single_select'] = 'Boutons Radio à sélection unique'; 
$lang['ParType_Radio_single_select_info'] = ''; 
$lang['ParType_Menu_single_select'] = 'Menu à choix unique'; 
$lang['ParType_Menu_single_select_info'] = ''; 
$lang['ParType_Menu_multiple_select'] = 'Menu à choix Multiple'; 
$lang['ParType_Menu_multiple_select_info'] = ''; 
$lang['ParType_Checkbox_multiple_select'] = 'Cases à cocher Multiples'; 
$lang['ParType_Checkbox_multiple_select_info'] = ''; 
/* Blocks Administration */
$lang['Block_admin'] = 'Panneau de Contrôle de Bloc'; 
$lang['Block_admin_explain'] = 'Utiliser ce formulaire pour gérer les blocs de portail.<br><b>Pour utiliser ce panneau, JavaScript et les cookies doivent être activés dans votre navigateur!</b>'; 
$lang['Block'] = 'Bloc'; 
$lang['Show_title'] = 'Afficher le Titre du Bloc?'; 
$lang['Show_title_explain'] = 'Afficher ou non le titre du bloc'; 
$lang['Show_block'] = 'Afficher le Bloc?'; 
$lang['Show_block_explain'] = '- Si \'non\', le Bloc est masqué de tous les utilisateurs, sauf les administrateurs'; 
$lang['Show_stats'] = 'Afficher Statistiques?'; 
$lang['Show_stats_explain'] = '- Si \'oui\', \'modifié par...\' sera affiché sous le bloc'; 
/***** TBC */ 
$lang['Show_blocks'] = 'Voir les Blocs Fonction'; 
/***** TBC */
$lang['Block_delete'] = 'Supprimer un Bloc'; 
$lang['Block_delete_explain'] = 'Utiliser ce formulaire pour suppromer un bloc (ou une colonne)'; 
$lang['Block_title'] = 'Titre'; 
$lang['Block_desc'] = 'Description'; 
$lang['Add_Block'] = 'Ajouter un Nouveau Bloc'; 
$lang['Auth_Block'] = 'Permissions'; 
$lang['Auth_Block_explain'] = 'ALL: Tous utilisateurs<br>REG: Utilisateurs Enregistrés<br>PRIVE: Membres du groupe (voir permissions avancées)<br>MOD: modérateurs du bloc (voir permissions avancées)<br>ADMIN: Admin<br>ANONYMOUS: SEULEMENT les invités'; 
$lang['Block_quick_stats'] = 'Stats Rapides'; 
$lang['Block_quick_edit'] = 'Edition Rapide'; 
$lang['Create_block'] = 'Créer un Nouveau Bloc'; 
$lang['Delete_block'] = 'Supprimer un Bloc Portail'; 
$lang['Delete_block_explain'] = 'Ceci va supprimer le bloc et mettre a jour toutes les Pages Portail associées. Attention: cette opération ne peut être annulée!'; 
$lang['Click_block_delete_yes'] = 'Cliquer %sIci%s pour supprimer le Bloc';
 
/** BlockCP Administration */
$lang['Block_cp'] = 'Panneau de Contrôle de Bloc'; 
$lang['Click_return_blockCP_admin'] = 'Cliquer %sIci%s pour revenir au Panneau de Contrôle de Bloc'; 
$lang['Click_return_portalpage_admin'] = 'Cliquer %sIci%s pour revenir a la Page Portail'; 
$lang['BlockCP_Config_updated'] = 'Ce bloc a été mis à jour.';
 
/** Pages Administration */
$lang['Page_admin'] = 'Administration de Page'; 
$lang['Page_admin_explain'] = 'Utiliser ce formulaire pour ajouter, supprimer et changer les paramètres des Pages Portail et Modèles de Pages.<br><b>Pour utiliser ce panneau, JavaScript et les cookies doivent être activés dans votre navigateur!</b>'; 
$lang['Page_admin_edit'] = 'Editer la Page'; 
$lang['Page_admin_private'] = 'Permissions Avancées de Page (PRIVE)'; 
$lang['Page_admin_settings'] = 'Paramètres de Page'; 
$lang['Page_admin_new_page'] = 'Administration Nouvelle Page'; 
$lang['Page'] = 'Page'; 
$lang['Page_Id'] = 'ID de Page'; 
$lang['Page_icon'] = 'Icône de Page <br> - a utiliser dans adminCP seulement, eg. icon_home.gif (par défaut)'; 
$lang['Page_alt_icon'] = 'Icône de page Alternative <br> - Url complète (http://...) vers l\'icône de page personnalisée.'; 
$lang['Default_page_style'] = 'Style de Portail (par défaut)<br>Pour utiliser les paramètres par défaut, laissez ceci décoché.'; 
$lang['Override_page_style'] = 'Ignorer le style utilisateur'; 
$lang['Override_page_style_explain'] = ' '; 
$lang['Page_header'] = 'Fichier d\'en-tête de Page <br> - i.e. overall_header.tpl (par défaut), overall_noheader.tpl (pas d\'en-tête) ou fichier d\'en-tête utilisateur personnalisé.<br>Pour utiliser le paramètre par défaut, laisser vierge.'; 
$lang['Page_footer'] = 'Fichier de bas de Page par défaut <br> - i.e. overall_footer.tpl (par défaut) ou fichier de bas de page utilisateur personnalisé.<br>Pour utiliser le paramètre par défaut, laisser vierge.'; 
$lang['Page_main_layout'] = 'Fichier de disposition générale de Page <br> - i.e. mx_main_layout.tpl (par défaut) ou fichier de mise en forme utilisateur personnalisé.<br>Pour utiliser le paramètre par défaut, laisser vierge.'; 
$lang['Page_Navigation_block'] = 'Bloc d\'en-tête de navigation de la Page'; 
$lang['Page_Navigation_block_explain'] = '- Ceci est le bloc de navifation de la page, acompter que vous ayez choisi un fichier d\'en-tête général qui supporte la navigation de page.<br>Pour utiliser le paramètre par défaut, laisser vierge.'; 
$lang['Auth_Page'] = 'Permissions'; 
$lang['Select_sort_method'] = 'Sélectionner la Méthode de Tri'; 
$lang['Order'] = 'Ordre'; 
$lang['Sort'] = 'Tri'; 
$lang['Width'] = 'Largeur'; 
$lang['Height'] = 'Hauteur'; 
$lang['Page_sort_title'] = 'Titre de la Page'; 
$lang['Page_sort_desc'] = 'Description de la Page'; 
$lang['Page_sort_created'] = 'Page créée le '; 
$lang['Sort_Ascending'] = 'ASC'; 
$lang['Sort_Descending'] = 'DESC'; 
$lang['Return_to_page'] = 'Retour à la Page Portail'; 
$lang['Auth_Page_group'] = '-> Groupe PRIVE'; 
$lang['Page_desc'] = 'Description'; 
$lang['Page_parent'] = 'Page Parente'; 
$lang['Add_Page'] = 'Ajouter une Nouvelle Page'; 
$lang['Page_Config_updated'] = 'Configuration de Page Mise à Jour'; 
$lang['Click_return_page_admin'] = 'Cliquer %sIci%s pour revenir à l\'Administration de Page'; 
$lang['Remove_block'] = 'Retirer ce Bloc de Portail'; 
$lang['Remove_block_explain'] = 'Ceci va retirer ce bloc de la Page. Attention: cette opération ne peut être annulée!'; 
$lang['Click_block_remove_yes'] = 'Cliquer %sIci%s pour retirer ce Bloc'; 
$lang['Delete_page'] = 'Supprimer cette Page'; 
$lang['Delete_page_explain'] = 'Ceci va supprimer cette Page. Attention: cette opération ne peut être annulée!'; 
$lang['Click_page_delete_yes'] = 'Cliquer %sIci%s pour supprimer cette Page'; 

$lang['Mx_IP_filter'] = 'Filtre IP'; 
$lang['Mx_IP_filter_explain'] = 'Pour restreindre l\'accès à cette page par IP, entrer les addresses IP valides, une addresse par ligne.<br>Example: 127.0.0.1 or 127.1.*.*'; 
$lang['Mx_phpBB_stats'] = 'Statistiques phpBB dans l\'en-tête'; 
$lang['Mx_phpBB_stats_explain'] = '- Liens vers les nouveaux sujets, non lus, etc.'; 
$lang['Column_admin'] = 'Administration des Colonnes de Page'; 
$lang['Column_admin_explain'] = 'Administrer les Colonnes de Page'; 
$lang['Column'] = 'Colonne de Page'; 
$lang['Columns'] = 'Colonnes de Page'; 
$lang['Column_block'] = 'Bloc de Colonne de Page'; 
$lang['Column_blocks'] = 'Blocs de Colonne de Page'; 
$lang['Edit_Column'] = 'Editer une Colonne'; 
$lang['Edit_Column_explain'] = 'Utiliser ce formulaire pour modifier une Colonne'; 
$lang['Column_Size'] = 'Taille de la Colonne'; 
$lang['Column_name'] = 'Nom de la Colonne'; 
$lang['Column_delete'] = 'Supprimer une Colonne'; 
$lang['Page_updated'] = 'Informations de Page et Colonne mises à jour'; 
$lang['Create_column'] = 'Ajouter une Nouvelle Colonne'; 
$lang['Delete_page_column'] = 'Supprimer une Colonne de Page'; 
$lang['Delete_page_column_explain'] = 'Ceci supprime cette Colonne de Page. Attention: cette opération ne peut être annulée!'; 
$lang['Click_page_column_delete_yes'] = 'Cliquer %sIci%s pour supprimmer cette Colonne'; 

$lang['Add_Split_Block']          = 'Ajouter un Bloc de séparation de Colonne'; 
$lang['Add_Split_Block_explain']    = 'Ce bloc scinde la Colonne'; 
$lang['Add_Dynamic_Block']          = 'Ajouter un (Sous) Bloc Dynamique'; 
$lang['Add_Dynamic_Block_explain']    = 'Ce Bloc Dynamique définit des sous pages, accédées depuis le menu de navigation'; 
$lang['Add_Virtual_Block']          = 'Ajouter un Bloc Virtuel (Page de Blog)'; 
$lang['Add_Virtual_Block_explain']    = 'Ce bloc transforme cette Page en une page virtuelle (blog)'; 

/** Page templates */
$lang['Page_templates_admin'] = 'Administration des Modèles de Page'; 
$lang['Page_templates_admin_explain'] = 'Utiliser cette page pour créer, éditer ou supprimer des Modèles de Page'; 
$lang['Page_template'] = 'Modèle de Page'; 
$lang['Page_templates'] = 'Modèles de Page'; 
$lang['Page_template_column'] = 'Colonne de Modèle de Page'; 
$lang['Page_template_columns'] = 'Colonnes de Modèle de Page'; 
$lang['Choose_page_template'] = 'Choisir le Modèle de Page'; 
$lang['Template_Config_updated'] = 'Configuration de Modèle Mise à Jour'; 
$lang['Add_Template'] = 'Ajouter un Nouveau Modèle'; 
$lang['Template'] = 'Modèle'; 
$lang['Template_name'] = 'Nom du Modèle'; 
$lang['Page_template_delete'] = 'Supprimer le Modèle'; 
$lang['Delete_page_template'] = 'Supprimer le Modèle de Page'; 
$lang['Delete_page_template_explain'] = 'Ceci va supprimer le Modèle de Page. Attention: cette opération ne peut être annulée!'; 
$lang['Click_page_template_delete_yes'] = 'Cliquer %sIci%s pour supprimer le Modèle de Page'; 
$lang['Delete_page_template_column'] = 'Supprimer le Modèle de Page'; 
$lang['Delete_page_template_column_explain'] = 'Ceci va supprimer le Modèle de Page. Attention: cette opération ne peut être annulée!'; 
$lang['Click_page_template_column_delete_yes'] = 'Cliquer %sIci%s pour supprimer le Modèle de Page'; 

/** Cache */
$lang['Cache_dir_write_protect'] = 'Votre répertoire de cache est protégé en écriture. MX-Publisher ne peut générer le fichier cache. Veuillez rendre votre répertoire cache autorisé en écriture pour poursuivre.'; 
$lang['Cache_generate'] = 'Vos fichiers cache ont été générés.'; 
$lang['Cache_submit'] = 'Générer le fichier cache?'; 
$lang['Cache_explain'] = 'Avec cette option, vous pouvez générer tous les fichiers cache (fichiers XML) d\'un seul coup pour tous les blocs de portail. Ces fichiers permettent de réduire le nombre de requètes de base de donnée nécessaires et améliorent la performance générale du portail. <br>Note: le cache de MX-Publisher cache doit être activé (dans le Panneau Administration Générale du Portail) pour que ces fichiers soient utilisés par le système.<br>Note complémentaire: les fichiers cache sont également créés à la volée lors de l\'édition de blocs.'; 
$lang['Generate_mx_cache'] = 'Générer le Cache de Blocs'; 

/** These are displayed in the drop down boxes for advanced 
mode Module auth, try and keep them short! */
$lang['Menu_Navigation'] = 'Menu de Navigation'; 
$lang['Portal_index'] = 'Index du Portail'; 
$lang['Save_Settings'] = 'Sauver Paramètres'; 
$lang['Translation_Tools'] = 'Outils de Traduction'; 
$lang['Preview_portal'] = 'Aperçu du Portail';
 
/** META */
$lang['Meta_admin'] = 'Administration des Tags META'; 
$lang['Mega_admin_explain'] = 'Utiliser ce formulaire pour personnaliser vos tags META'; 
$lang['Meta_Title'] = 'Titre'; 
$lang['Meta_Author'] = 'Auteur'; 
$lang['Meta_Copyright'] = 'Copyright';
$lang['Meta_ImageToolBar'] 		= 'Image ToolBar';
$lang['Meta_Distribution'] 		= 'Distribution'; 
$lang['Meta_Keywords'] = 'Mots-clés'; 
$lang['Meta_Keywords_explain'] = '(liste séparée par des virgules)'; 
$lang['Meta_Description'] = 'Description'; 
$lang['Meta_Language'] = 'Code de Langue'; 
$lang['Meta_Rating'] = 'Rating'; 
$lang['Meta_Robots'] = 'Robots'; 
$lang['Meta_Pragma'] = 'Pragma no-cache'; 
$lang['Meta_Bookmark_icon'] = 'Icône de Favori'; 
$lang['Meta_Bookmark_explain'] = '(chemin relatif)'; 
$lang['Meta_HTITLE'] = 'Paramètre Additionel d\'en-tête'; 
$lang['Meta_data_updated'] = 'Le fichier de Méta données (mx_meta.inc) a été mis à jour!<br>Cliquer %sIci%s pour revenir à l\'Administration des Tags META.'; 
$lang['Meta_data_ioerror'] = 'Impossible d\'ouvrir mx_meta.inc. Vérifier que le fichier est autorisé en écriture (chmod 777).'; 

/** Portal permissons */
$lang['Mx_Block_Auth_Title'] = 'Permissions Privées de Bloc' ; 
$lang['Mx_Block_Auth_Explain'] = 'Ici, vous pouvez configurer des Permissions Privées de Bloc'; 
$lang['Mx_Page_Auth_Title'] = 'Permissions Privées de Page' ; 
$lang['Mx_Page_Auth_Explain'] = 'Ici, vous pouvez configurer des Permissions Privées de Page'; 
$lang['Block_Auth_successfully'] = 'Permissions de Bloc mises à jour'; 
$lang['Click_return_block_auth'] = 'Cliquer %sIci%s pour revenir aux Permissions Privées de Bloc'; 
$lang['Page_Auth_successfully'] = 'Permissions de Page mises à jour'; 
$lang['Click_return_page_auth'] = 'Cliquer %sIci%s pour revenir aux Permissions Privées de Page'; 
$lang['AUTH_ALL'] = 'TOUS'; 
$lang['AUTH_REG'] = 'REG'; 
$lang['AUTH_PRIVATE'] = 'PRIVE'; 
$lang['AUTH_MOD'] = 'MOD'; 
$lang['AUTH_ADMIN'] = 'ADMIN'; 
$lang['AUTH_ANONYMOUS'] = 'ANONYME'; 

/* -----------------------------------
 BlockCP - Block Parameter Specific 
 ----------------------------------- */
 
/** General */
$lang['target_block'] = 'Bloc Cible'; 
$lang['target_block_explain'] = '- liens, données etc... referant à ce bloc'; 

/** Split column */
$lang['block_ids'] = 'Blocs Source'; 
$lang['block_ids_explain'] = '- à placer de gauche à droite'; 
$lang['block_sizes'] = 'Tailles de Blocs (séparées par des virgules)'; 
$lang['block_sizes_explain'] = '- Vous pouvez spécifier des tailles en chiffres (pixels), pourcentages (tailles relatives, ie. \'40%\') ou \'*\' pour le reste.'; 
$lang['space_between'] = 'Espace entre les Blocs';
 
/** Sitelog */
$lang['log_filter_date'] = 'Filtrer par Date'; 
$lang['log_filter_date_explain'] = '- Montre les logs de la semaine, du mois, de l\'année précédents...'; 
$lang['numOfEvents'] = 'Nombre'; 
$lang['numOfEvents_explain'] = '- Nombre d\'évènements à afficher'; 

/** IncludeX */
$lang['x_listen'] = 'Listen (GET)'; 
$lang['x_iframe'] = 'IFrame'; 
$lang['x_textfile'] = 'Textfile'; 
$lang['x_multimedia'] = 'WMP Multimedia'; 
$lang['x_pic'] = 'Pic'; 
$lang['x_format'] = 'Formatted Textfile'; 
$lang['x_mode'] = 'Mode IncludeX:'; 
$lang['x_mode_explain'] = '- Le bloc IncludeX opère dans l\'un des modes sivants. Si le mode \'Listen (GET)\' est sélectionné, le mode peut être réglé dans l\'url \'x_mode=mode\' et les paramètres associés par \'x_1=, x_2=, etc\'.<br>Exemple: Pour passer une url a une iframe, utiliser \'domain/index.php?page=x&x_mode=iframe&x_1=http://domain\' '; 
$lang['x_1'] = 'Variable 1:'; 
$lang['x_1_explain'] = '- <i>IFrame:</i> url<br><i>Textfile:</i> chemin relatif depuis la racine (eg dans \'/include_file/my_file.xxx\')<br><i>Multimedia:</i> chemin relatif depuis la racine (eg dans \'/include_file/my_file.xxx\')<br><i>Pic:</i> chemin relatif depuis la racine (eg dans \'/include_file/my_file.xxx\')<br><i>Formatted textfile:</i> non disponible'; 
$lang['x_2'] = 'Variable 2:'; 
$lang['x_2_explain'] = '- <i>IFrame:</i> hauteur du cadre (pixels)<br><i>Multimedia:</i> largeur (pixels)'; 
$lang['x_3'] = 'Variable 3:'; 
$lang['x_3_explain'] = '- <i>Multimedia:</i> hauteur (pixels)';
 
/** Dynamic Block */
$lang['default_block_id'] = 'Bloc par Défaut'; 
$lang['default_block_id_explain'] = '- Ceci est le bloc par défaut ou le premier bloc à afficher, a moins qu\'un bloc dynamique soit défini'; 

/** Menu Navigation */
$lang['menu_display_mode'] = 'Mode de Disposition'; 
$lang['menu_display_mode_explain '] = 'Mode de disposition Horizonale ou Verticale'; 
$lang['menu_custom_tpl']            = "Fichier Modèle Personnalisé"; 
$lang['menu_custom_tpl_explain ']      = "Eg mx_menu_custom.tpl"; 
$lang['menu_page_parent']            = "Page Parente"; 
$lang['menu_page_parent_explain ']      = "Navigation depuis cette Page Parente"; 

/** Version Checker */
$lang['MXP_Version_up_to_date'] = 'Votre installation de MX-Publisher est à jour. Aucune mise à jour n\'est disponible pour votre version de MX-Publisher.'; 
$lang['MXP_Version_outdated'] = 'Votre installation de MX-Publisher ne semble <b>pas</b> être à jour. Des mises à jour sont disponibles pour votre version de MX-Publisher. Merci de visiter <a href="http://mxpcms.sourceforge.net/download" target="_new">the MX-Publisher Core package download</a> pour obtenir la dernière version.'; 
$lang['MXP_Latest_version_info'] = 'The latest available version is <b>MX-Publisher %s</b>. '; 
$lang['MXP_Current_version_info'] = 'Vous utilisez <b>MX-Publisher %s</b>.'; 
$lang['MXP_Mailing_list_subscribe_reminder'] = 'Pour toutes les dernières informations sur la vie et les mises à jour de MX-Publisher, pourquoi ne pas <a href="http://lists.sourceforge.net/lists/listinfo/mxpcms-news" target="_new">vous abonner à notre mailing list</a>?'; 

/*
* That's all Folks!
* -------------------------------------------------*/
?>