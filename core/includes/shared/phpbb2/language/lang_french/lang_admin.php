<?php
/***************************************************************************
 *                            lang_admin.php [French]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_admin.php,v 1.1 2013/10/03 08:32:41 orynider Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

/***************************************************************************
 *                         Translation: Informations
 *
 *   Version: 1.0.2
 *   Date: 07/03/2008 19:04:16
 *   Author: Xaphos (Ma�l Soucaze)
 *   Website: http://www.phpbb.fr/
 *
 ***************************************************************************/

/* CONTRIBUTORS
	2002-12-15	Philip M. White (pwhite@mailhaven.com)
		Fixed many minor grammatical mistakes
*/

//
// Format is same as lang_main
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//
$lang['General'] = 'Administration g�n�rale';
$lang['Users'] = 'Administration des utilisateurs';
$lang['Groups'] = 'Administration des groupes';
$lang['Forums'] = 'Administration des forums';
$lang['Styles'] = 'Administration des styles';

$lang['Configuration'] = 'Configuration';
$lang['Permissions'] = 'Permissions';
$lang['Manage'] = 'Gestion';
$lang['Disallow'] = 'Interdire des noms';
$lang['Prune'] = 'D�lestage';
$lang['Mass_Email'] = 'E-mail de masse';
$lang['Ranks'] = 'Rangs';
$lang['Smilies'] = '�motic�nes';
$lang['Ban_Management'] = 'Contr�le des bannissements';
$lang['Word_Censor'] = 'Censure de mots';
$lang['Export'] = 'Exporter';
$lang['Create_new'] = 'Cr�er';
$lang['Add_new'] = 'Ajouter';
$lang['Backup_DB'] = 'Sauvegarder la base de donn�es';
$lang['Restore_DB'] = 'Restaurer la base de donn�es';


//
// Index
//
$lang['Admin'] = 'Administration';
$lang['Not_admin'] = 'Vous n��tes pas autoris� � administrer ce forum';
$lang['Welcome_phpBB'] = 'Bienvenue sur phpBB';
$lang['Admin_intro'] = 'Nous vous remercions d�avoir s�lectionn� phpBB comme solution pour votre forum. Cet �cran vous donne un aper�u rapide des diverses statistiques de votre forum. Vous pouvez retourner sur cette page en cliquant sur le lien <u>Index de l�administration</u> dans le panneau de gauche. Pour retourner � l�index de votre forum, cliquez sur le logo phpBB qui est �galement situ� dans le panneau de gauche. Les autres liens situ�s sur le volet � gauche de cet �cran vous permettront de contr�ler tous les aspects de votre forum. Chaque page contiendra des instructions sur l�utilisation des outils disponibles.';
$lang['Main_index'] = 'Index du forum';
$lang['Forum_stats'] = 'Statistiques du forum';
$lang['Admin_Index'] = 'Index de l�administration';
$lang['Preview_forum'] = 'Aper�u du forum';

$lang['Click_return_admin_index'] = 'Cliquez %sici%s afin de retourner � l�index de l�administration';

$lang['Statistic'] = 'Statistique';
$lang['Value'] = 'Valeur';
$lang['Number_posts'] = 'Nombre de messages';
$lang['Posts_per_day'] = 'Messages par jour';
$lang['Number_topics'] = 'Nombre de sujets';
$lang['Topics_per_day'] = 'Sujets par jour';
$lang['Number_users'] = 'Nombre d�utilisateurs';
$lang['Users_per_day'] = 'Utilisateurs par jour';
$lang['Board_started'] = 'Date d�ouverture du forum';
$lang['Avatar_dir_size'] = 'Taille du r�pertoire des avatars';
$lang['Database_size'] = 'Taille de la base de donn�es';
$lang['Gzip_compression'] ='Compression GZip';
$lang['Not_available'] = 'Indisponible';

$lang['ON'] = 'Activ�e'; // This is for GZip compression
$lang['OFF'] = 'D�sactiv�e'; 


//
// DB Utils
//
$lang['Database_Utilities'] = 'Utilitaires de la base de donn�es';

$lang['Restore'] = 'Restaurer';
$lang['Backup'] = 'Sauvegarder';
$lang['Restore_explain'] = 'Cela ex�cutera une restauration compl�te de toutes les tables de phpBB � partir d�un fichier de sauvegarde. Si votre serveur le supporte, vous pouvez utiliser un fichier texte compress� en GZip qui sera automatiquement d�compress�. <b>ATTENTION :</b> cela �crasera toutes les donn�es existantes. La restauration est un processus pouvant prendre beaucoup de temps, veuillez ne pas vous d�placer de la page avant que l�op�ration soit termin�e.';
$lang['Backup_explain'] = 'Vous pouvez sauvegarder ici toutes les donn�es relatives � votre forum phpBB. Si vous avez cr�� des tables additionnelles personnalis�es dans la m�me base de donn�es et que vous souhaitez les sauvegarder, veuillez saisir leurs noms, s�par�s par une virgule, dans la bo�te de texte <u>Tables additionnelles</u> ci-dessous. Si votre serveur le supporte, vous pouvez �galement compresser votre fichier au format GZip afin de r�duire sa taille avant de le t�l�charger.';

$lang['Backup_options'] = 'Options de la sauvegarde';
$lang['Start_backup'] = 'D�marrer la sauvegarde';
$lang['Full_backup'] = 'Sauvegarde compl�te';
$lang['Structure_backup'] = 'Sauvegarde de la structure uniquement';
$lang['Data_backup'] = 'Sauvegarde des donn�es uniquement';
$lang['Additional_tables'] = 'Tables additionnelles';
$lang['Gzip_compress'] = 'Fichier compress� GZip';
$lang['Select_file'] = 'S�lectionner un fichier';
$lang['Start_Restore'] = 'D�marrer la restauration';

$lang['Restore_success'] = 'La base de donn�es a �t� restaur�e avec succ�s.<br /><br />Votre forum devrait �tre tel qu�il l��tait lorsque la sauvegarde a �t� faite.';
$lang['Backup_download'] = 'Votre t�l�chargement va d�marrer sous peu ; veuillez patienter jusqu�� ce qu�il d�marre.';
$lang['Backups_not_supported'] = 'D�sol�, mais les sauvegardes ne sont actuellement pas support�es par votre syst�me de base de donn�es.';

$lang['Restore_Error_uploading'] = 'Erreur lors du transfert du fichier de sauvegarde';
$lang['Restore_Error_filename'] = 'Probl�me avec le nom du fichier ; veuillez essayer avec un autre fichier';
$lang['Restore_Error_decompress'] = 'Impossible de d�compresser le fichier GZip ; veuillez transf�rer un fichier texte';
$lang['Restore_Error_no_file'] = 'Aucun fichier n�a �t� transf�r�';


//
// Auth pages
//
$lang['Select_a_User'] = 'S�lectionner un utilisateur';
$lang['Select_a_Group'] = 'S�lectionner un groupe';
$lang['Select_a_Forum'] = 'S�lectionner un forum';
$lang['Auth_Control_User'] = 'Contr�le des permissions des utilisateurs'; 
$lang['Auth_Control_Group'] = 'Contr�le des permissions des groupes'; 
$lang['Auth_Control_Forum'] = 'Contr�le des permissions des forums'; 
$lang['Look_up_User'] = 'Rechercher un utilisateur'; 
$lang['Look_up_Group'] = 'Rechercher un groupe'; 
$lang['Look_up_Forum'] = 'Rechercher un forum'; 

$lang['Group_auth_explain'] = 'Vous pouvez modifier ici les permissions et le statut de mod�rateur assign�s � chaque groupe d�utilisateurs. N�oubliez pas qu�en modifiant les permissions des groupes, certaines permissions individuelles peuvent toutefois permettre � un utilisateur d�acc�der � un forum, etc. Vous serez averti si tel �tait le cas.';
$lang['User_auth_explain'] = 'Vous pouvez modifier ici les permissions et le statut de mod�rateur assign�s � chaque utilisateur individuel. N�oubliez pas qu�en modifiant les permissions des groupes, certaines permissions individuelles peuvent toutefois permettre � un utilisateur d�acc�der � un forum, etc. Vous serez averti si tel �tait le cas.';
$lang['Forum_auth_explain'] = 'Vous pouvez modifier ici les niveaux de permissions de chaque forum. Vous disposerez du mode simple et avanc� pour r�aliser cela, o� le mode avanc� offre un plus grand contr�le de chaque op�ration du forum. Rappelez-vous qu�en modifiant le niveau de permissions des forums, chaque utilisateur sera affect� des diverses op�rations faites dans celui-ci.';

$lang['Simple_mode'] = 'Mode simple';
$lang['Advanced_mode'] = 'Mode avanc�';
$lang['Moderator_status'] = 'Statut de mod�rateur';

$lang['Allowed_Access'] = 'Acc�s autoris�';
$lang['Disallowed_Access'] = 'Acc�s interdit';
$lang['Is_Moderator'] = 'est mod�rateur';
$lang['Not_Moderator'] = 'n�est pas mod�rateur';

$lang['Conflict_warning'] = 'Avertissement de conflit d�autorisations';
$lang['Conflict_access_userauth'] = 'Cet utilisateur disposera toujours des droits d�acc�s sur ce forum � cause de son appartenance � un groupe. Vous devriez modifier les permissions du groupe ou supprimer cet utilisateur du groupe afin de l�emp�cher compl�tement de disposer des droits d�acc�s. Les groupes (et les forums impliqu�s) accordant des droits sont indiqu�s ci-dessous.';
$lang['Conflict_mod_userauth'] = 'Cet utilisateur disposera toujours des droits de mod�rateur sur ce forum � cause de son appartenance � un groupe. Vous devriez modifier les permissions du groupe ou supprimer cet utilisateur du groupe afin de l�emp�cher compl�tement de disposer des droits de mod�rateur. Les groupes (et les forums impliqu�s) accordant des droits sont indiqu�s ci-dessous.';

$lang['Conflict_access_groupauth'] = 'L�utilisateur (ou les utilisateurs) suivant dispose toujours des droits d�acc�s sur ce forum � cause des r�glages des permissions de l�utilisateur. Vous devriez modifier les permissions de l�utilisateur afin de l�emp�cher compl�tement de disposer des droits d�acc�s. Les utilisateurs (et les forums impliqu�s) accordant des droits sont indiqu�s ci-dessous.';
$lang['Conflict_mod_groupauth'] = 'L�utilisateur (ou les utilisateurs) suivant dispose toujours des droits de mod�rateur sur ce forum � cause des r�glages des permissions de l�utilisateur. Vous devriez modifier les permissions de l�utilisateur afin de l�emp�cher compl�tement de disposer des droits de mod�rateur. Les utilisateurs (et les forums impliqu�s) accordant des droits sont indiqu�s ci-dessous.';

$lang['Public'] = 'Public';
$lang['Private'] = 'Priv�';
$lang['Registered'] = 'Inscrit';
$lang['Administrators'] = 'Administrateurs';
$lang['Hidden'] = 'Invisible';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = 'TOUS';
$lang['Forum_REG'] = 'INSCRITS';
$lang['Forum_PRIVATE'] = 'PRIV�';
$lang['Forum_MOD'] = 'MOD�RATEURS';
$lang['Forum_ADMIN'] = 'ADMINISTRATEURS';

$lang['View'] = 'Voir';
$lang['Read'] = 'Lire';
$lang['Post'] = 'Publier';
$lang['Reply'] = 'R�pondre';
$lang['Edit'] = '�diter';
$lang['Delete'] = 'Supprimer';
$lang['Sticky'] = 'Note';
$lang['Announce'] = 'Annonce'; 
$lang['Vote'] = 'Voter';
$lang['Pollcreate'] = 'Cr�er un sondage';

$lang['Permissions'] = 'Permissions';
$lang['Simple_Permission'] = 'Permissions simples';

$lang['User_Level'] = 'Niveau de l�utilisateur'; 
$lang['Auth_User'] = 'Utilisateur';
$lang['Auth_Admin'] = 'Administrateur';
$lang['Group_memberships'] = 'Adh�rents du groupe d�utilisateurs';
$lang['Usergroup_members'] = 'Ce groupe est compos� des membres suivants';

$lang['Forum_auth_updated'] = 'Les permissions des forums ont �t� mises � jour avec succ�s';
$lang['User_auth_updated'] = 'Les permissions des utilisateurs ont �t� mises � jour avec succ�s';
$lang['Group_auth_updated'] = 'Les permissions des groupes ont �t� mises � jour avec succ�s';

$lang['Auth_updated'] = 'Les permissions ont �t� mises � jour avec succ�s';
$lang['Click_return_userauth'] = 'Cliquez %sici%s pour retourner aux permissions des utilisateurs';
$lang['Click_return_groupauth'] = 'Cliquez %sici%s pour retourner aux permissions des groupes';
$lang['Click_return_forumauth'] = 'Cliquez %sici%s pour retourner aux permissions des forums';


//
// Banning
//
$lang['Ban_control'] = 'Contr�le des bannissements';
$lang['Ban_explain'] = 'Vous pouvez contr�ler ici le bannissement d�utilisateurs. Vous pouvez faire cela en bannissant un ou des utilisateurs sp�cifiques ou un ou des intervalles d�adresses IP ou de noms d�h�tes. Ces m�thodes emp�cheront un utilisateur d�atteindre les pages votre forum. Afin d�emp�cher un utilisateur de s�inscrire sous un nom d�utilisateur diff�rent, vous pouvez �galement bannir les adresses e-mail. Veuillez noter que bannir uniquement une adresse e-mail n�emp�chera pas l�utilisateur concern� de se connecter ou de publier des messages sur votre forum. Vous devrez utiliser une des deux premi�res m�thodes cit�es afin de r�aliser cela.';
$lang['Ban_explain_warn'] = 'Veuillez noter que la saisie d�un intervalle d�adresses IP ne prendra en compte que les adresses situ�es entre la premi�re et la derni�re adresse IP. Des essais seront effectu�s afin de r�duire le nombre d�adresses ajout�es � la base de donn�es en ajoutant automatiquement des jokers o� cela est appropri�. Si vous souhaitez tout de m�me saisir un intervalle, essayez de le rendre court ou au mieux, saisissez des adresses sp�cifiques.';

$lang['Select_username'] = 'S�lectionner un nom d�utilisateur';
$lang['Select_ip'] = 'S�lectionner une adresse IP';
$lang['Select_email'] = 'S�lectionner une adresse e-mail';

$lang['Ban_username'] = 'Bannir un ou plusieurs utilisateurs sp�cifiques';
$lang['Ban_username_explain'] = 'Vous pouvez bannir plusieurs utilisateurs en une fois en utilisant la combinaison appropri�e de la souris et du clavier de votre ordinateur et de votre navigateur Internet';

$lang['Ban_IP'] = 'Bannir une ou plusieurs adresses IP ou noms d�h�tes';
$lang['IP_hostname'] = 'Adresses IP ou noms d�h�tes';
$lang['Ban_IP_explain'] = 'Afin de sp�cifier plusieurs adresses IP ou plusieurs noms d�h�tes diff�rents, veuillez les s�parer par une virgule. Afin de sp�cifier un intervalle d�adresses IP, veuillez s�parer le d�but et la fin par un tiret (-). Afin de sp�cifier un joker, veuillez utiliser un ast�risque (*).';

$lang['Ban_email'] = 'Bannir une ou plusieurs adresses e-mail';
$lang['Ban_email_explain'] = 'Afin de sp�cifier plusieurs adresses e-mail, veuillez les s�parer par une virgule. Afin de sp�cifier un nom d�utilisateur joker, veuillez utiliser un ast�risque (*), comme *@hotmail.com';

$lang['Unban_username'] = 'D�bannir un ou plusieurs utilisateurs sp�cifiques';
$lang['Unban_username_explain'] = 'Vous pouvez d�bannir plusieurs utilisateurs en une fois en utilisant la combinaison appropri�e de la souris et du clavier de votre ordinateur et de votre navigateur Internet';

$lang['Unban_IP'] = 'D�bannir une ou plusieurs adresses IP ou noms d�h�tes';
$lang['Unban_IP_explain'] = 'Vous pouvez d�bannir plusieurs adresses IP ou plusieurs noms d�h�tes en une fois en utilisant la combinaison appropri�e de la souris et du clavier de votre ordinateur et de votre navigateur Internet';

$lang['Unban_email'] = 'D�bannir une ou plusieurs adresses e-mail';
$lang['Unban_email_explain'] = 'Vous pouvez d�bannir plusieurs adresses e-mail en une fois en utilisant la combinaison appropri�e de la souris et du clavier de votre ordinateur et de votre navigateur Internet';

$lang['No_banned_users'] = 'Aucun nom d�utilisateur n�a �t� banni';
$lang['No_banned_ip'] = 'Aucune adresse IP n�a �t� bannie';
$lang['No_banned_email'] = 'Aucune adresse e-mail n�a �t� bannie';

$lang['Ban_update_sucessful'] = 'La lise des bannissements a �t� mise � jour avec succ�s';
$lang['Click_return_banadmin'] = 'Cliquez %sici%s afin de retourner au contr�le des bannissements';


//
// Configuration
//
$lang['General_Config'] = 'Configuration g�n�rale';
$lang['Config_explain'] = 'Le formulaire ci-dessous vous permet de personnaliser toutes les options g�n�rales de votre forum. Pour les configurations des utilisateurs et des forums, veuillez utiliser les liens appropri�s situ�s sur le volet de gauche.';

$lang['Click_return_config'] = 'Cliquez %sici%s afin de retourner � la configuration g�n�rale';

$lang['General_settings'] = 'R�glages g�n�raux du forum';
$lang['Server_name'] = 'Nom de domaine';
$lang['Server_name_explain'] = 'Le nom de domaine � partir duquel ce forum fonctionne';
$lang['Script_path'] = 'Chemin du script';
$lang['Script_path_explain'] = 'Le chemin o� phpBB2 est install� par rapport au nom de domaine';
$lang['Server_port'] = 'Port du serveur';
$lang['Server_port_explain'] = 'Le port sous lequel fonctionne votre serveur, souvent 80. Ne le modifiez que s�il est diff�rent';
$lang['Site_name'] = 'Nom du site';
$lang['Site_desc'] = 'Description du site';
$lang['Board_disable'] = 'D�sactiver le forum';
$lang['Board_disable_explain'] = 'Cela rendra le forum indisponible aux utilisateurs. Les administrateurs pourront toutefois acc�der au panneau de contr�le de l�administrateur.';
$lang['Acct_activation'] = 'Activation du compte';
$lang['Acc_None'] = 'Aucune'; // These three entries are the type of activation
$lang['Acc_User'] = 'Utilisateur';
$lang['Acc_Admin'] = 'Administrateur';

$lang['Abilities_settings'] = 'R�glages de base des utilisateurs et des forums';
$lang['Max_poll_options'] = 'Nombre maximal d�options des sondages';
$lang['Flood_Interval'] = 'Intervalle de flood';
$lang['Flood_Interval_explain'] = 'Nombre de secondes durant lequel un utilisateur doit patienter avant de pouvoir publier de nouveau'; 
$lang['Board_email_form'] = 'Envoi d�e-mail par le forum';
$lang['Board_email_form_explain'] = 'Les utilisateurs pourront envoyer des e-mail aux autres utilisateurs par ce forum';
$lang['Topics_per_page'] = 'Sujets par page';
$lang['Posts_per_page'] = 'Messages par page';
$lang['Hot_threshold'] = 'Seuil de popularit� des messages';
$lang['Default_style'] = 'Style par d�faut';
$lang['Override_style'] = 'Remplacer le style des utilisateurs';
$lang['Override_style_explain'] = 'Remplace le style des utilisateurs avec celui par d�faut';
$lang['Default_language'] = 'Langue par d�faut';
$lang['Date_format'] = 'Format de la date';
$lang['System_timezone'] = 'Fuseau horaire';
$lang['Enable_gzip'] = 'Activer la compression GZip';
$lang['Enable_prune'] = 'Activer le d�lestage du forum';
$lang['Allow_HTML'] = 'Autoriser l�HTML';
$lang['Allow_BBCode'] = 'Autoriser le BBCode';
$lang['Allowed_tags'] = 'Balises HTML autoris�es';
$lang['Allowed_tags_explain'] = 'S�parez les balises par une virgule';
$lang['Allow_smilies'] = 'Autoriser les �motic�nes';
$lang['Smilies_path'] = 'Chemin de stockage des �motic�nes';
$lang['Smilies_path_explain'] = 'Le chemin depuis la racine de votre r�pertoire phpBB, ex : images/smiles';
$lang['Allow_sig'] = 'Autoriser les signatures';
$lang['Max_sig_length'] = 'Longueur maximale de la signature';
$lang['Max_sig_length_explain'] = 'Nombre de caract�res maximum dans les signatures des utilisateurs';
$lang['Allow_name_change'] = 'Autoriser la modification du nom d�utilisateur';

$lang['Avatar_settings'] = 'R�glages des avatars';
$lang['Allow_local'] = 'Activer la galerie des avatars';
$lang['Allow_remote'] = 'Activer les avatars � distance';
$lang['Allow_remote_explain'] = 'Les avatars situ�s sur un autre site Internet';
$lang['Allow_upload'] = 'Activer le transfert des avatars';
$lang['Max_filesize'] = 'Taille maximale de l�avatar';
$lang['Max_filesize_explain'] = 'Valable pour les avatars transf�r�s';
$lang['Max_avatar_size'] = 'Dimensions maximales de l�avatar';
$lang['Max_avatar_size_explain'] = '(hauteur x largeur en pixels)';
$lang['Avatar_storage_path'] = 'Chemin de stockage des avatars';
$lang['Avatar_storage_path_explain'] = 'Le chemin depuis la racine de votre r�pertoire phpBB, ex : images/avatars';
$lang['Avatar_gallery_path'] = 'Chemin de la galerie des avatars';
$lang['Avatar_gallery_path_explain'] = 'Le chemin depuis la racine de votre r�pertoire phpBB, ex : images/avatars/gallery';

$lang['COPPA_settings'] = 'R�glages de la COPPA';
$lang['COPPA_fax'] = 'Num�ro de fax de la COPPA';
$lang['COPPA_mail'] = 'Adresse postale de la COPPA';
$lang['COPPA_mail_explain'] = 'Ceci est l�adresse postale o� les parents doivent envoyer le formulaire d�inscription de la COPPA';

$lang['Email_settings'] = 'R�glages des e-mail';
$lang['Admin_email'] = 'Adresse e-mail de l�administrateur';
$lang['Email_sig'] = 'Signature de l�e-mail';
$lang['Email_sig_explain'] = 'Ce texte sera ins�r� dans tous les e-mail que le forum enverra';
$lang['Use_SMTP'] = 'Utiliser un serveur SMTP pour l�envoi d�e-mail';
$lang['Use_SMTP_explain'] = 'Envoi les e-mail par l�interm�diaire de ce serveur au lieu d�utiliser la fonction e-mail locale';
$lang['SMTP_server'] = 'Adresse du serveur SMTP';
$lang['SMTP_username'] = 'Nom d�utilisateur SMTP';
$lang['SMTP_username_explain'] = 'Ne saisir le nom d�utilisateur que si votre serveur SMTP le demande';
$lang['SMTP_password'] = 'Mot de passe SMTP';
$lang['SMTP_password_explain'] = 'Ne saisir le mot de passe que si votre serveur SMTP le demande';

$lang['Disable_privmsg'] = 'Messagerie priv�e';
$lang['Inbox_limits'] = 'Messages maximum dans la bo�te de r�ception';
$lang['Sentbox_limits'] = 'Messages maximum dans la bo�te d�envoi';
$lang['Savebox_limits'] = 'Messages maximum dans les archives';

$lang['Cookie_settings'] = 'R�glages du cookie'; 
$lang['Cookie_settings_explain'] = 'Ces informations d�finissent la m�thode d�envoi aux navigateurs des utilisateurs. Dans la plupart des cas, les valeurs par d�faut sont suffisantes, mais il se peut que vous ayez besoin de les modifier. Des r�glages incorrects pourraient provoquer des d�connexions chez vos utilisateurs';
$lang['Cookie_domain'] = 'Domaine du cookie';
$lang['Cookie_name'] = 'Nom du cookie';
$lang['Cookie_path'] = 'Chemin du cookie';
$lang['Cookie_secure'] = 'Cookie s�curis�';
$lang['Cookie_secure_explain'] = 'Si votre serveur fonctionne par l�interm�diaire d�SSL, activez cette fonctionnalit�';
$lang['Session_length'] = 'Dur�e de la session [ secondes ]';

// Visual Confirmation
$lang['Visual_confirm'] = 'Activer la confirmation visuelle';
$lang['Visual_confirm_explain'] = 'Les utilisateurs devront saisir un code situ� dans une image lors de leur inscription.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin'] = 'Autoriser les connexions automatiques';
$lang['Allow_autologin_explain'] = 'Autorise les utilisateurs � se connecter automatiquement lorsqu�ils visitent le forum';
$lang['Autologin_time'] = 'Expiration de la cl� de la connexion automatique';
$lang['Autologin_time_explain'] = 'Dur�e en jours de validit� de la cl� de la connexion automatique si les utilisateurs ne visitent pas le forum. Si cela est r�gl� sur z�ro, elle n�expirera jamais.';

// Search Flood Control - added 2.0.20
$lang['Search_Flood_Interval'] = 'Intervalle de flood de la recherche';
$lang['Search_Flood_Interval_explain'] = 'Nombre de secondes durant lequel un utilisateur devra patienter entre chaque recherche'; 

//
// Forum Management
//
$lang['Forum_admin'] = 'Administration des forums';
$lang['Forum_admin_explain'] = 'De ce panneau, vous pouvez ajouter, supprimer, �diter, r�organiser et resynchroniser les cat�gories et les forums.';
$lang['Edit_forum'] = '�diter le forum';
$lang['Create_forum'] = 'Cr�er un nouveau forum';
$lang['Create_category'] = 'Cr�er une nouvelle cat�gorie';
$lang['Remove'] = 'Supprimer';
$lang['Action'] = 'Action';
$lang['Update_order'] = 'Mettre � jour l�ordre';
$lang['Config_updated'] = 'La configuration du forum a �t� mise � jour avec succ�s';
$lang['Edit'] = '�diter';
$lang['Delete'] = 'Supprimer';
$lang['Move_up'] = 'Monter';
$lang['Move_down'] = 'Descendre';
$lang['Resync'] = 'Resynchroniser';
$lang['No_mode'] = 'Aucun mode n�a �t� r�gl�';
$lang['Forum_edit_delete_explain'] = 'Le formulaire ci-dessous vous permettra de personnaliser toutes les options g�n�rales du forum. Pour ce qui concerne les configurations des utilisateurs ou des forums, veuillez utiliser les liens situ�s sur le volet de gauche.';

$lang['Move_contents'] = 'D�placer tout le contenu';
$lang['Forum_delete'] = 'Supprimer un forum';
$lang['Forum_delete_explain'] = 'Le formulaire ci-dessous vous permettra de supprimer un forum ou une cat�gorie et de d�placer tous les sujets ou les forums qu�il contient o� vous souhaitez.';

$lang['Status_locked'] = 'Verrouill�';
$lang['Status_unlocked'] = 'D�verrouill�';
$lang['Forum_settings'] = 'R�glages g�n�raux des forums';
$lang['Forum_name'] = 'Nom du forum';
$lang['Forum_desc'] = 'Description';
$lang['Forum_status'] = 'Statut du forum';
$lang['Forum_pruning'] = 'D�lestage automatique';

$lang['prune_freq'] = 'V�rifier l��ge des sujets tous les';
$lang['prune_days'] = 'Supprimer les sujet n�ayant obtenus aucune r�ponse depuis';
$lang['Set_prune_data'] = 'Vous souhaitez activer le d�lestage automatique dans ce forum mais nous n�avez pas r�gl� sa fr�quence ou son nombre de jours. Veuillez apporter ces r�glages.';

$lang['Move_and_Delete'] = 'D�placer et supprimer';

$lang['Delete_all_posts'] = 'Supprimer tous les messages';
$lang['Nowhere_to_move'] = 'Nulle part � d�placer';

$lang['Edit_Category'] = '�diter la cat�gorie';
$lang['Edit_Category_explain'] = 'Utilisez ce formulaire afin de modifier le nom de la cat�gorie.';

$lang['Forums_updated'] = 'Les informations sur le forum ou sur la cat�gorie ont �t� mises � jours avec succ�s';

$lang['Must_delete_forums'] = 'Vous devez supprimer tous les forums de cette cat�gorie avant de pouvoir la supprimer';

$lang['Click_return_forumadmin'] = 'Cliquez %sici%s afin de retourner � l�administration des forums';


//
// Smiley Management
//
$lang['smiley_title'] = 'Utilitaire d��dition des �motic�nes';
$lang['smile_desc'] = 'De cette page vous pouvez ajouter, supprimer et �diter les �motic�nes que vous utilisateurs utilisent dans leurs messages et messages priv�s.';

$lang['smiley_config'] = 'Configuration des �motic�nes';
$lang['smiley_code'] = 'Code de l��motic�ne';
$lang['smiley_url'] = 'Image de l��motic�ne';
$lang['smiley_emot'] = '�motion';
$lang['smile_add'] = 'Ajouter une nouvelle �motic�ne';
$lang['Smile'] = '�motic�ne';
$lang['Emotion'] = '�motion';

$lang['Select_pak'] = 'S�lectionner une archive d��motic�nes .pak';
$lang['replace_existing'] = 'Remplacer l��motic�ne existante';
$lang['keep_existing'] = 'Pr�server l��motic�ne existante';
$lang['smiley_import_inst'] = 'Vous devez extraire l�archive d��motic�nes et transf�rer tous les fichiers dans le r�pertoire propre aux �motic�nes pour votre installation. Cela s�lectionnera l�information correcte dans ce formulaire afin d�importer l�archive d��motic�nes.';
$lang['smiley_import'] = 'Importer l�archive d��motic�nes';
$lang['choose_smile_pak'] = 'S�lectionner une archive d��motic�nes .pak';
$lang['import'] = 'Importer les �motic�nes';
$lang['smile_conflicts'] = 'Que doit-il �tre fait en cas de conflits ?';
$lang['del_existing_smileys'] = 'Supprimer les �motic�nes existantes avant l�importation';
$lang['import_smile_pack'] = 'Importer l�archive d��motic�nes';
$lang['export_smile_pack'] = 'Cr�er une archive d��motic�nes';
$lang['export_smiles'] = 'Pour cr�er une archive d��motic�nes de vos �motic�nes install�es existantes, veuillez cliquer %sici%s afin de t�l�charger le fichier smiles.pak. Renommez le fichier correctement en pr�servant l�extension .pak. Cela cr�era un fichier .zip qui contiendra toutes les images et les configurations de vos �motic�nes.';

$lang['smiley_add_success'] = 'L��motic�ne a �t� ajout�e avec succ�s';
$lang['smiley_edit_success'] = 'L��motic�ne a �t� mise � jour avec succ�s';
$lang['smiley_import_success'] = 'L�archive d��motic�nes a �t� import�e avec succ�s !';
$lang['smiley_del_success'] = 'L��motic�ne a �t� supprim�e avec succ�s';
$lang['Click_return_smileadmin'] = 'Cliquez %sici%s afin de retourner � la configuration des �motic�nes';

$lang['Confirm_delete_smiley'] = '�tes-vous s�r de vouloir supprimer cette �motic�ne ?';

//
// User Management
//
$lang['User_admin'] = 'Administration des utilisateurs';
$lang['User_admin_explain'] = 'Vous pouvez modifier ici les informations et certaines options de vos utilisateurs. Pour modifier les permissions des utilisateurs, veuillez utiliser le syst�me de permissions des utilisateurs et des groupes d�utilisateurs.';

$lang['Look_up_user'] = 'Rechercher un utilisateur';

$lang['Admin_user_fail'] = 'Il n�a pas �t� possible de mettre � jour le profil de l�utilisateur.';
$lang['Admin_user_updated'] = 'Le profil de l�utilisateur a �t� mis � jour avec succ�s.';
$lang['Click_return_useradmin'] = 'Cliquez %sici%s afin de retourner � l�administration des utilisateurs';

$lang['User_delete'] = 'Supprimer cet utilisateur';
$lang['User_delete_explain'] = 'Cliquez ici afin de supprimer cet utilisateur. Cette op�ration est irr�versible.';
$lang['User_deleted'] = 'L�utilisateur a �t� supprim� avec succ�s.';

$lang['User_status'] = 'L�utilisateur est actif';
$lang['User_allowpm'] = 'Peut envoyer des messages priv�s';
$lang['User_allowavatar'] = 'Peut afficher un avatar';

$lang['Admin_avatar_explain'] = 'Vous pouvez consulter et supprimer ici l�avatar actuel de l�utilisateur.';

$lang['User_special'] = 'Champs sp�ciaux r�serv�s � l�administrateur';
$lang['User_special_explain'] = 'Ces champs ne peuvent pas �tre modifi�s par les utilisateurs. Vous pouvez r�gler ici leurs statuts et les autres options qui ne sont pas fournies aux utilisateurs.';


//
// Group Management
//
$lang['Group_administration'] = 'Administration des groupes';
$lang['Group_admin_explain'] = 'De ce panneau vous pouvez administrer tous les groupes d�utilisateurs. Vous pouvez supprimer, cr�er et �diter les groupes d�utilisateurs existants. Vous pouvez choisir des responsables, ouvrir ou fermer le statut d�un groupe d�utilisateurs et modifier son nom et sa description';
$lang['Error_updating_groups'] = 'Une erreur est survenue lors de la mise � jour des groupes d�utilisateurs';
$lang['Updated_group'] = 'Le groupe d�utilisateurs a �t� mis � jour avec succ�s';
$lang['Added_new_group'] = 'Le nouveau groupe d�utilisateurs a �t� cr�e avec succ�s';
$lang['Deleted_group'] = 'Le groupe d�utilisateurs a �t� supprim� avec succ�s';
$lang['New_group'] = 'Cr�er un nouveau groupe';
$lang['Edit_group'] = '�diter le groupe';
$lang['group_name'] = 'Nom du groupe';
$lang['group_description'] = 'Description du groupe';
$lang['group_moderator'] = 'Responsable du groupe';
$lang['group_status'] = 'Statut du groupe';
$lang['group_open'] = 'Groupe ouvert';
$lang['group_closed'] = 'Groupe ferm�';
$lang['group_hidden'] = 'Groupe invisible';
$lang['group_delete'] = 'Supprimer un groupe';
$lang['group_delete_check'] = 'Supprimer ce groupe';
$lang['submit_group_changes'] = 'Envoyer les modifications';
$lang['reset_group_changes'] = 'Remise � z�ro des modifications';
$lang['No_group_name'] = 'Vous devez saisir le nom de ce groupe';
$lang['No_group_moderator'] = 'Vous devez sp�cifier le responsable du groupe';
$lang['No_group_mode'] = 'Vous devez sp�cifier le statut du groupe, ouvert ou ferm�';
$lang['No_group_action'] = 'Aucune action n�a �t� sp�cifi�e';
$lang['delete_group_moderator'] = 'Supprimer l�ancien responsable du groupe ?';
$lang['delete_moderator_explain'] = 'Si vous souhaitez modifier le responsable du groupe, cochez cette case afin de supprimer l�ancien responsable du groupe. Dans le cas contraire, ne la cochez pas et l�utilisateur deviendra simplement un membre du groupe.';
$lang['Click_return_groupsadmin'] = 'Cliquez %sici%s afin de retourner � l�administration des groupes.';
$lang['Select_group'] = 'S�lectionner un groupe';
$lang['Look_up_group'] = 'Rechercher un groupe';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'D�lester un forum';
$lang['Forum_Prune_explain'] = 'Cela supprimera tous les sujets qui n�ont pas �t� publi�s dans le nombre de jours que vous avez s�lectionn�. Si vous ne souhaitez pas saisir un nombre, tous les sujets seront alors supprim�s. Cela ne supprimera ni sujets dans lesquels un sondage est en cours, ni les annonces. Vous devrez supprimer ces sujets manuellement.';
$lang['Do_Prune'] = 'R�aliser le d�lestage';
$lang['All_Forums'] = 'Tous les forums';
$lang['Prune_topics_not_posted'] = 'D�lester les sujets sans r�ponse � partir de ce nombre de jours';
$lang['Topics_pruned'] = 'Sujets d�lest�s';
$lang['Posts_pruned'] = 'Messages d�lest�s';
$lang['Prune_success'] = 'Les forums ont �t� d�lest�s avec succ�s';


//
// Word censor
//
$lang['Words_title'] = 'Censure de mots';
$lang['Words_explain'] = 'De ce panneau de contr�le vous pouvez ajouter, �diter et supprimer les mots qui seront automatiquement censur�s sur votre forum. De plus, il ne sera plus possible de s�inscrire avec un nom d�utilisateur contenant un de ces mots. Les jokers (*) sont accept�s dans le champ du mot. Par exemple, *test* censurera d�testable, test* censurera testament, *test censurera contest.';
$lang['Word'] = 'Mot';
$lang['Edit_word_censor'] = '�diter la censure du mot';
$lang['Replacement'] = 'Remplacement';
$lang['Add_new_word'] = 'Ajouter un nouveau mot';
$lang['Update_word'] = 'Mettre � jour la censure du mot';

$lang['Must_enter_word'] = 'Vous devez saisir un mot et son remplacement';
$lang['No_word_selected'] = 'Aucun mot n�a �t� s�lectionn� pour l��dition';

$lang['Word_updated'] = 'La censure du mot que vous avez s�lectionn�e a �t� mise � jour avec succ�s';
$lang['Word_added'] = 'La censure du mot a �t� ajout�e avec succ�s';
$lang['Word_removed'] = 'La censure du mot que vous avez s�lectionn�e a �t� supprim�e avec succ�s';

$lang['Click_return_wordadmin'] = 'Cliquez %sici%s afin de retourner � la censure de mots';

$lang['Confirm_delete_word'] = '�tes-vous s�r de vouloir supprimer la censure du mot s�lectionn�e ?';


//
// Mass Email
//
$lang['Mass_email_explain'] = 'Vous pouvez envoyer ici des messages e-mail � tous les utilisateurs ou groupes d�utilisateurs de votre forum. Pour r�aliser cela, un e-mail sera envoy� � partir de l�adresse e-mail que vous avez sp�cifi�e avec une copie envoy�e � tous les destinataires. Si vous envoyez un e-mail de masse � de nombreux utilisateurs, merci de patienter et de ne pas quitter la page le temps de l�envoi. Il est normal qu�un e-mail un masse prenne un certain temps, vous serez averti lorsque le script aura termin�';
$lang['Compose'] = 'Composer'; 

$lang['Recipients'] = 'Destinataires'; 
$lang['All_users'] = 'Tous les utilisateurs';

$lang['Email_successfull'] = 'Votre message a �t� envoy� avec succ�s';
$lang['Click_return_massemail'] = 'Cliquez %sici%s afin de retourner au formulaire de l�e-mail de masse';


//
// Ranks admin
//
$lang['Ranks_title'] = 'Administration des rangs';
$lang['Ranks_explain'] = 'En utilisant ce formulaire vous pouvez ajouter, �diter, consulter et supprimer des rangs. Vous pouvez �galement cr�er des rangs personnalis�s qui seront mis en place � des utilisateurs sp�cifiques par l�interm�diaire de l�outil de gestion des utilisateurs';

$lang['Add_new_rank'] = 'Ajouter un nouveau rang';

$lang['Rank_title'] = 'Titre du rang';
$lang['Rank_special'] = 'D�finir comme rang sp�cial';
$lang['Rank_minimum'] = 'Messages minimum';
$lang['Rank_maximum'] = 'Messages maximum';
$lang['Rank_image'] = 'Image du rang';
$lang['Rank_image_explain'] = 'Utilisez cela afin de d�finir une petite image associ�e avec le rang. Elle est relative au chemin � la racine de phpBB';

$lang['Must_select_rank'] = 'Vous devez s�lectionner un rang';
$lang['No_assigned_rank'] = 'Aucun rang sp�cial n�a �t� d�fini';

$lang['Rank_updated'] = 'Le rang a �t� mis � jour avec succ�s';
$lang['Rank_added'] = 'Le rang a �t� ajout� avec succ�s';
$lang['Rank_removed'] = 'Le rang a �t� supprim� avec succ�s';
$lang['No_update_ranks'] = 'Le rang a �t� supprim� avec succ�s. Cependant, les comptes des utilisateurs utilisant ce rang n�ont pas �t� mis � jour. Vous devez r�initialiser manuellement le rang sur ces comptes';

$lang['Click_return_rankadmin'] = 'Cliquez %sici%s afin de retourner � l�administration des rangs';

$lang['Confirm_delete_rank'] = '�tes-vous s�r de vouloir supprimer ce rang ?';

//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'Interdiction de noms d�utilisateurs';
$lang['Disallow_explain'] = 'Vous pouvez contr�ler ici les noms d�utilisateurs qui ne sont pas autoris�s � �tre utilis�s. Les noms d�utilisateurs interdits peuvent contenir un joker (*). Veuillez noter que vous ne pouvez pas interdire un nom d�utilisateur qui a d�j� �t� enregistr�. Vous devez supprimer en premier lieu l�utilisateur, puis interdire son nom d�utilisateur.';

$lang['Delete_disallow'] = 'Supprimer';
$lang['Delete_disallow_title'] = 'Supprimer un nom d�utilisateur interdit';
$lang['Delete_disallow_explain'] = 'Vous pouvez supprimer un nom d�utilisateur interdit en s�lectionnant celui-ci dans la liste et en cliquant sur supprimer';

$lang['Add_disallow'] = 'Ajouter';
$lang['Add_disallow_title'] = 'Ajouter un nom d�utilisateur interdit';
$lang['Add_disallow_explain'] = 'Vous pouvez interdire un nom d�utilisateur en utilisant un joker (*) afin de remplacer n�importe quel caract�re';

$lang['No_disallowed'] = 'Aucun nom d�utilisateur interdit';

$lang['Disallowed_deleted'] = 'Le nom d�utilisateur interdit a �t� supprim� avec succ�s';
$lang['Disallow_successful'] = 'Le nom d�utilisateur interdit a �t� ajout� avec succ�s';
$lang['Disallowed_already'] = 'Vous ne pouvez pas interdire ce nom d�utilisateur. Soit il existe d�j� dans cette liste, soit il existe dans la liste de la censure de mots, soit le nom d�utilisateur est d�j� enregistr�.';

$lang['Click_return_disallowadmin'] = 'Cliquez %sici%s afin de retourner � l�interdiction de noms d�utilisateurs';


//
// Styles Admin
//
$lang['Styles_admin'] = 'Administration des styles';
$lang['Styles_explain'] = 'En utilisant cet outil vous pouvez ajouter, supprimer et g�rer les styles (templates et th�mes) disponibles � vos utilisateurs';
$lang['Styles_addnew_explain'] = 'La liste suivante contient tous les th�mes qui sont disponibles aux templates que vous avez actuellement. Les objets de cette liste ne sont pas encore install�s dans la base de donn�es de phpBB. Pour installer un th�me, cliquez tout simplement sur le lien d�installation ci-dessous.';

$lang['Select_template'] = 'S�lectionner un template';

$lang['Style'] = 'Style';
$lang['Template'] = 'Template';
$lang['Install'] = 'Installer';
$lang['Download'] = 'T�l�charger';

$lang['Edit_theme'] = '�diter un th�me';
$lang['Edit_theme_explain'] = 'Dans le formulaire ci-dessous, vous pouvez �diter les r�glages du th�me s�lectionn�';

$lang['Create_theme'] = 'Cr�er un th�me';
$lang['Create_theme_explain'] = 'Utilisez le formulaire ci-dessous afin de cr�er un nouveau th�me pour un template s�lectionn�. Lors de la mise en place des couleurs (pour laquelle vous pouvez utiliser la notation hexad�cimale), vous ne devez pas inclure #. Par exemple, CCCCCC est correct alors que #CCCCCC ne l�est pas';

$lang['Export_themes'] = 'Exporter des th�mes';
$lang['Export_explain'] = 'De ce panneau, vous pouvez exporter le th�me pour un template s�lectionn�. S�lectionnez le template � partir de la liste ci-dessous et le script cr�era le fichier de configuration du th�me et essaiera de le sauvegarder vers le r�pertoire du template. S�il n�arrive pas � sauvegarder le fichier, il vous fournira une option afin de le t�l�charger. Vous devez en premier lieu attribuer au r�pertoire du template les droits d��critures n�cessaires � la sauvegarde du fichier. Pour plus d�informations, veuillez consulter le guide des utilisateurs de phpBB2.';

$lang['Theme_installed'] = 'Le th�me s�lectionn� a �t� install� avec succ�s';
$lang['Style_removed'] = 'Le style s�lectionn� a �t� supprim� de la base de donn�es avec succ�s. Pour supprimer enti�rement ce style de votre syst�me, vous devez supprimer le style appropri� du r�pertoire de vos templates.';
$lang['Theme_info_saved'] = 'L�information du th�me du template s�lectionn� a �t� sauvegard� avec succ�s. Vous devriez � pr�sent restaurer les permissions de non-�criture sur le fichier theme_info.cfg, et, si possible, sur le r�pertoire du template s�lectionn� �galement';
$lang['Theme_updated'] = 'Le th�me s�lectionn� a �t� mis � jour avec succ�s. Vous devriez � pr�sent exporter les r�glages du nouveau th�me';
$lang['Theme_created'] = 'Le th�me a �t� cr�e avec succ�s. Vous devriez � pr�sent exporter le th�me sur le fichier de configuration du th�me pour plus de s�curit� et afin de l�utiliser n�importe o�';

$lang['Confirm_delete_style'] = '�tes-vous s�r de vouloir supprimer ce style ?';

$lang['Download_theme_cfg'] = 'L�outil d�exportation n�arrive pas � �crire le fichier d�information du th�me. Cliquez sur le bouton ci-dessous afin de t�l�charger ce fichier avec votre navigateur. Une fois t�l�charg�, vous pouvez le transf�rer dans le r�pertoire contenant les fichiers du template. Si vous le souhaitez, vous pouvez �galement compresser les fichiers pour les distribuer ou les utiliser n�importe o�';
$lang['No_themes'] = 'Le template que vous avez s�lectionn� n�a aucun th�me qui lui est associ�. Pour cr�er un nouveau th�me, cliquez sur le lien de cr�ation sur le volet de gauche';
$lang['No_template_dir'] = 'Il n�a pas �t� possible d�ouvrir le r�pertoire du template. Il n�est peut-pas pas possible d�y �crire ou il n�existe pas';
$lang['Cannot_remove_style'] = 'Vous ne pouvez pas supprimer le style que vous avez s�lectionn� depuis qu�il est celui par d�faut. Veuillez modifier le style par d�faut et r�essayer.';
$lang['Style_exists'] = 'Le nom du style que vous avez saisi existe d�j�, veuillez en s�lectionner un autre.';

$lang['Click_return_styleadmin'] = 'Cliquez %sici%s afin de retourner � l�administration des styles';

$lang['Theme_settings'] = 'R�glages du th�me';
$lang['Theme_element'] = '�l�ment du th�me';
$lang['Simple_name'] = 'Nom simple';
$lang['Value'] = 'Valeur';
$lang['Save_Settings'] = 'Sauvegarder les r�glages';

$lang['Stylesheet'] = 'Feuille de style CSS';
$lang['Stylesheet_explain'] = 'Nom du fichier pour la feuille de style CSS � utiliser pour ce th�me.';
$lang['Background_image'] = 'Image de fond';
$lang['Background_color'] = 'Couleur de fond';
$lang['Theme_name'] = 'Nom du th�me';
$lang['Link_color'] = 'Couleur du lien';
$lang['Text_color'] = 'Couleur du texte';
$lang['VLink_color'] = 'Couleur du lien visit�';
$lang['ALink_color'] = 'Couleur du lien actif';
$lang['HLink_color'] = 'Couleur du lien survol�';
$lang['Tr_color1'] = 'Couleur 1 de la colonne du tableau';
$lang['Tr_color2'] = 'Couleur 2 de la colonne du tableau';
$lang['Tr_color3'] = 'Couleur 3 de la colonne du tableau';
$lang['Tr_class1'] = 'Classe 1 de la colonne du tableau';
$lang['Tr_class2'] = 'Classe 2 de la colonne du tableau';
$lang['Tr_class3'] = 'Classe 3 de la colonne du tableau';
$lang['Th_color1'] = 'Couleur 1 du haut du tableau';
$lang['Th_color2'] = 'Couleur 2 du haut du tableau';
$lang['Th_color3'] = 'Couleur 3 du haut du tableau';
$lang['Th_class1'] = 'Classe 1 du haut du tableau';
$lang['Th_class2'] = 'Classe 2 du haut du tableau';
$lang['Th_class3'] = 'Classe 3 du haut du tableau';
$lang['Td_color1'] = 'Couleur 1 de la cellule du tableau';
$lang['Td_color2'] = 'Couleur 2 de la cellule du tableau';
$lang['Td_color3'] = 'Couleur 3 de la cellule du tableau';
$lang['Td_class1'] = 'Classe 1 de la cellule du tableau';
$lang['Td_class2'] = 'Classe 2 de la cellule du tableau';
$lang['Td_class3'] = 'Classe 3 de la cellule du tableau';
$lang['fontface1'] = 'Apparence 1 de la police';
$lang['fontface2'] = 'Apparence 2 de la police';
$lang['fontface3'] = 'Apparence 3 de la police';
$lang['fontsize1'] = 'Taille 1 de la police';
$lang['fontsize2'] = 'Taille 2 de la police';
$lang['fontsize3'] = 'Taille 3 de la police';
$lang['fontcolor1'] = 'Couleur 1 de la police';
$lang['fontcolor2'] = 'Couleur 2 de la police';
$lang['fontcolor3'] = 'Couleur 3 de la police';
$lang['span_class1'] = 'Classe 1 de span';
$lang['span_class2'] = 'Classe 2 de span';
$lang['span_class3'] = 'Classe 3 de span';
$lang['img_poll_size'] = 'Taille de l�image du sondage [px]';
$lang['img_pm_size'] = 'Taille du statut des messages priv�s [px]';


//
// Install Process
//
$lang['Welcome_install'] = 'Bienvenue � l�installation de phpBB2';
$lang['Initial_config'] = 'Configuration de base';
$lang['DB_config'] = 'Configuration de la base de donn�es';
$lang['Admin_config'] = 'Configuration de l�administrateur';
$lang['continue_upgrade'] = 'Une fois que vous avez t�l�charg� votre fichier de configuration sur votre machine locale, vous devez cliquer sur le bouton\'Continuer la mise � jour\' ci-dessous afin de poursuivre la proc�dure d�installation. Veuillez patienter le temps de transf�rer le fichier de configuration afin que la proc�dure de mise � jour soit termin�e.';
$lang['upgrade_submit'] = 'Continuer la mise � jour';

$lang['Installer_Error'] = 'Une erreur est survenue lors de l�installation';
$lang['Previous_Install'] = 'Une installation ant�rieure a �t� d�tect�e';
$lang['Install_db_error'] = 'Une erreur est survenue lors de la mise � jour de la base de donn�es';

$lang['Re_install'] = 'Votre installation ant�rieure est toujours active.<br /><br />Si vous souhaitez r�installer phpBB2, cliquez sur le bouton <em>Oui</em> ci-dessous. Veuillez faire attention � tout ce que vous faites, une mauvaise man�uvre pourrait d�truire toutes les donn�es existantes d�une mani�re irr�versible ! Le nom d�utilisateur et le mot de passe de l�administrateur que vous avez utilis� afin de vous connecter sur le forum sera de nouveau cr�� apr�s la r�installation. Tout autre r�glage ne sera pas sauvegard�.<br /><br />Soyez s�r de savoir ce que vous faites, et faites-le en tout s�curit� !';

$lang['Inst_Step_0'] = 'Nous vous remercions d�avoir s�lectionn� phpBB2. Pour terminer cette installation, veuillez fournir toutes les informations ci-dessous avant toute chose. Veuillez noter que la base de donn�es qui servira � l�installation doit d�j� exister. Si l�installation se fait � partir d�une base de donn�es de type ODBC, comme Microsoft Access par exemple, vous devez en tout premier lieu cr�er un DSN.';

$lang['Start_Install'] = 'Commencer l�installation';
$lang['Finish_Install'] = 'Terminer l�installation';

$lang['Default_lang'] = 'Langue par d�faut du forum';
$lang['DB_Host'] = 'Nom d�h�te du serveur de la base de donn�es';
$lang['DB_Name'] = 'Le nom de votre base de donn�es';
$lang['DB_Username'] = 'Nom d�utilisateur de la base de donn�es';
$lang['DB_Password'] = 'Mot de passe de la base de donn�es';
$lang['Database'] = 'Votre base de donn�es';
$lang['Install_lang'] = 'S�lectionnez une langue pour l�installation';
$lang['dbms'] = 'Type de la base de donn�es';
$lang['Table_Prefix'] = 'Pr�fixe des tables dans la base de donn�es';
$lang['Admin_Username'] = 'Nom d�utilisateur de l�administrateur';
$lang['Admin_Password'] = 'Mot de passe de l�administrateur';
$lang['Admin_Password_confirm'] = 'Mot de passe de l�administrateur [ Confirmation ]';

$lang['Inst_Step_2'] = 'Le nom d�utilisateur de l�administrateur a �t� cr�� avec succ�s. Votre installation de base est � pr�sent termin�e. Vous allez �tre conduit � une page qui vous permettra d�administrer votre nouveau forum. Veuillez vous assurer de v�rifier et d�apporter les modifications n�cessaires aux informations de la configuration g�n�rale. Nous vous remercions d�avoir s�lectionn� phpBB2.';

$lang['Unwriteable_config'] = 'Votre fichier de configuration est � pr�sent inaccessible en �criture. Une copie de ce fichier peut �tre t�l�charg�e sur votre ordinateur en cliquant sur le bouton ci-dessous. Vous devez transf�rer ce fichier dans la m�me r�pertoire que celui de phpBB2. Une fois cela r�alis�, vous devez vous connecter sur le forum en utilisant le nom d�utilisateur et le mot de passe de l�administrateur que vous avez s�lectionn� sur le formulaire pr�c�dent afin de vous rendre sur votre panneau de contr�le de l�administrateur (le lien est pr�sent en bas de chaque page du forum) pour v�rifier la configuration g�n�rale du forum. Nous vous remercions d�avoir s�lectionn� phpBB2.';
$lang['Download_config'] = 'T�l�charger la configuration';

$lang['ftp_choose'] = 'S�lectionnez une m�thode de t�l�chargement';
$lang['ftp_option'] = '<br />Depuis que les extensions FTP sont activ�s dans cette version de PHP, vous pouvez � pr�sent essayer de transf�rer automatiquement le fichier de configuration.';
$lang['ftp_instructs'] = 'Vous avez s�lectionn� de transf�rer le fichier de configuration sur votre FTP de mani�re automatique. Veuillez saisir les informations demand�es ci-dessous afin de faciliter la proc�dure. Veuillez noter que le chemin FTP doit �tre exactement le m�me chemin que celui de votre installation, comme si vous utilisiez normalement le FTP.';
$lang['ftp_info'] = 'Saisissez vos informations FTP';
$lang['Attempt_ftp'] = 'Transf�rer le fichier de configuration automatiquement';
$lang['Send_file'] = 'T�l�charger le fichier de configuration afin de le transf�rer manuellement';
$lang['ftp_path'] = 'Chemin FTP vers phpBB2';
$lang['ftp_username'] = 'Votre nom d�utilisateur FTP';
$lang['ftp_password'] = 'Votre mot de passe FTP';
$lang['Transfer_config'] = 'D�marrer le transfert';
$lang['NoFTP_config'] = 'Le transfert automatique du fichier de configuration a �chou�e. Veuillez t�l�charger le fichier afin de le transf�rer manuellement.';

$lang['Install'] = 'Installer';
$lang['Upgrade'] = 'Mettre � jour';


$lang['Install_Method'] = 'S�lectionnez votre m�thode d�installation';

$lang['Install_No_Ext'] = 'La configuration PHP de votre serveur ne supporte pas le type de base de donn�es que vous avez s�lectionn�';

$lang['Install_No_PCRE'] = 'Le logiciel a besoin du module des expressions r�guli�res compatible avec Perl, mais votre configuration de PHP ne le supporte apparemment pas !';

//
// Version Check
//
$lang['Version_up_to_date'] = 'Votre installation est � jour, aucune mise � jour n�est disponible pour votre version de phpBB.';
$lang['Version_not_up_to_date'] = 'Votre installation ne semble <b>pas</b> � jour. Des mises � jour sont disponibles, veuillez vous rendre sur <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/downloads.php</a> ou sur <a href="http://www.phpbb.fr/" target="_new">http://www.phpbb.fr/</a> afin d�obtenir la derni�re version de phpBB.';
$lang['Latest_version_info'] = 'La derni�re version disponible est <b>phpBB %s</b>.';
$lang['Current_version_info'] = 'Vous utilisez actuellement <b>phpBB %s</b>.';
$lang['Connect_socket_error'] = 'Impossible d�ouvrir une connexion au serveur de phpBB. L�erreur rapport�e est :<br />%s';
$lang['Socket_functions_disabled'] = 'Impossible d�utiliser les fonctions du port.';
$lang['Mailing_list_subscribe_reminder'] = 'Pour obtenir les derni�res informations � propos des mises � jour de phpBB, pourquoi ne pas vous <a href="http://www.phpbb.com/support/" target="_new">inscrire sur notre liste de diffusion</a> ?';
$lang['Version_information'] = 'Information sur la version';

//
// Login attempts configuration
//
$lang['Max_login_attempts'] = 'Tentatives de connexions autoris�es';
$lang['Max_login_attempts_explain'] = 'Le nombre de tentatives de connexions autoris�es sur le forum.';
$lang['Login_reset_time'] = 'Dur�e de verrouillage de la connexion';
$lang['Login_reset_time_explain'] = 'Dur�e en minutes que l�utilisateur devra patienter le temps de pouvoir de nouveau se connecter apr�s avoir d�pass� le nombre de tentatives de connexions autoris�es.';

//
// That's all Folks!
// -------------------------------------------------

?>
