<?php
/***************************************************************************
 *                               lang_contact.php
 *                              ------------------
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *	Copyright:	(C) 2006, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		21:21 01/06/2007
 *	Translated by:	Ram (www.phpbb-fr.com)
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

$lang['Contact_intro'] = 'Si vous avez le moindre commentaires, retour ou suggestions � propos du site, ou si vous avez recontrer des probl�me avec L\'enregistrement ou logging de votre compte, merci d\'utiliser ce formulaire pour contacer L\'administrateur directement.';

$lang['Username'] = 'Nom d\'utilisateur';
$lang['Real_name'] = 'Nom';
$lang['Rname_require'] = 'Nom *';
$lang['E-mail'] = 'Adresse E-mail';
$lang['E-mail_require'] = 'Adresse E-mail *';
$lang['Comments'] = 'Commentaires';
$lang['Comments_require'] = 'Commentaires *';
$lang['Attachment'] = 'Fichiers Attach�s';

$lang['Feedback'] = 'Retour recu';

$lang['Real_name_explain'] = 'Entrer votre nom ici. Cela nous aidera � vous contacter plus facile si vous n\'�tes pas enregistr�.';
$lang['Explain_email'] = 'Entrer votre adresse e-mail ici. Utilis�e au cas o� nous devrions vous r�pondre directement.';
$lang['Comments_explain'] = 'Entrer vos commentaires ici.';
$lang['Flood_explain'] = '<br /><br />Ce formulaire utilise un syst�me de contr�le de flood. Vous pouvez soumettre votre formulaire une fois toutes les %s %s.';
$lang['Comments_limit'] = '<br /><br />L\'administrateur a entr� un nombre de %s caract�res maximun pour ce message.';
$lang['Attachment_explain'] = 'Postez votre fichier attach� ici, si requis, et il sera re�u par L\'administrateur du forum. Seulement les fichiers qui font %sKb ou moins peuvent �tre li�s.';

$lang['Guest'] = 'Invit�';
$lang['Notify_IP'] = 'Votre adresse IP va �tre enregistr� pour des raisons de s�curit�.';
$lang['Fields_required'] = 'Les champs avec un * sont requis.';
$lang['Contact_form'] = 'Formulaire';
$lang['Empty'] = 'Non Specifi�';

$lang['hours'] = 'heures';
$lang['hour'] = 'heure';

$lang['Chars'] = ' caract�res';

$lang['Captcha_code'] = 'Captcha *';
$lang['Captcha_code_explain'] = 'Merci de confirmer le code de L\'image. Ce champ est requis afin de dissuader le spam des �ventuels robots.';

//
// Errors
//
$lang['Rname-Empty'] = 'Votre vrai nom n\'a pas �t� approuv�.';
$lang['Comments-Empty'] = 'Le champ du commentaire n\'a pas �t� rempli.';
$lang['Comments_exceeded'] = 'Votre message est plus long que le nombre de caract�res sp�cifi�s.';
$lang['Email-Empty'] = 'Le champ du courrier �lectronique n\'a pas �t� rempli.';
$lang['Email-Check'] = 'L\'adresse e-mail que vous avez entr� n\'est pas valide.';
$lang['Attach-File_exists'] = 'Un fichier existe d�j� avec ce nom depuis votre adresse IP.';
$lang['Attach-Too_big'] = 'Le fichier que vous essayez d\'attacher est trop gros. V�rifiez qu\'il p�se %sKb ou moins.';
$lang['Attach_dud'] = 'Le fichier que vous avez essay� d\'envoyer n\'existe pas. V�rifiez votre fichier avant de recommencer.';
$lang['Attach-Uploaded'] = 'Votre fichier a �t� correctement upload�.';
$lang['Flood_limit'] = 'D�sol�, mais vous d\'avez attendre %d heure(s) avant de pouvoir soumettre � nouveau.';
$lang['Illegal_ext'] = 'Ce type de fichier (%s) n\'est pas permis!';
$lang['Unknown_ext'] = 'Ce type de fichier (%s) ne peut pas �tre accept�!';
$lang['zip_advise'] = 'Si n�cessaire, merci de faire un zip du fichier afin de le soumettre � nouveau.';
$lang['POST_ERROR'] = 'Erreur d\'upload - r�essayez!';
$lang['Image_error'] = 'Erreur d\'pload - Incapable de traiter cette image!';
$lang['Image_zip'] = 'Merci de zip l\'image avant de l\'envoyer.';
$lang['Code_Empty'] = 'Vous n\'avez pas confirmer le code sur l\'image!';
$lang['Code_Wrong'] = 'Le code entr� est incorrecte!';

$lang['Contact_error'] = '<b>Une erreur est survenue lors de L\'envoie de votre commentaire!</b>';
$lang['Contact_success'] = '<b>Votre message a �t� envoy� avec succ�s!</b>';

$lang['Click_return_form'] = '<br /><br />Cliquez %sIci%s pour retourner au formulaire';

$lang['Contact_Disabled'] = 'Le formulaire est actuellement inaccessible.';

//
// Admin
//
$lang['General_settings'] = 'Configuration G�n�ral';
$lang['Contact_title'] = 'Formulaire de Contact';
$lang['Contact_explain'] = 'Utilisez cette page pour jouer sur les configurations du Formulaire, ainsi que les conditions des champs.';
$lang['Req_settings'] = 'Configuration requise';
$lang['Attachment_settings'] = 'Configurations des Fichiers Attach�s';
$lang['Contact_updated'] = 'Configuration du Contact mis � jour avec succ�s';
$lang['Click_return_contact'] = 'Cliquez %sICI%s pour retourner � la configuration du Formulaire';
$lang['Disable'] = 'D�sactiv�';

$lang['Form_Enable'] = 'Activer Le Formulaire';

$lang['kb'] = 'kilobytes';

$lang['Hash'] = 'Attacehment Hashing M�thode';
$lang['Hash_explain'] = 'Chaque uploads peuvent �tre renomm� avec un nom al�atoire, afin d\'augmenter la s�curit�.';
$lang['md5'] = 'MD5';
$lang['no_hash'] = 'Pas de Hash';

$lang['auth_permission'] = 'Permissions des Attachments';
$lang['auth_perm_explain'] = 'Si les fichiers attach�s sont permis vous pouvez selectionner qui peut uploader des fichiers.';
$lang['auth_guests'] = 'Invit�s';
$lang['auth_members'] = 'Membres';
$lang['auth_mods'] = 'Mod�rateurs';
$lang['auth_admins'] = 'Administrateurs';

$lang['Require_rname'] = 'Votre nom est requis';
$lang['Require_email'] = 'Votre e-mail est requis';
$lang['Require_comments'] = 'Votre commentaire est requis';
$lang['Permit_attachments'] = 'Vous pouvez attacher des fichiers';
$lang['Prune'] = 'Activ� Pruning';
$lang['Prune_explain'] = 'Activez cette option pour supprimer n\'importe quelles entr�es SQL qui ont d�j� fait leur "travail" afin de r�duire la taille de base de donn�es.';
$lang['Max_file_size'] = 'Taille Maximun des Fichiers';
$lang['Max_file_size_explain'] = 'Taille maximale des fichiers attach�s stocker sur votre serveur Web. Souvenez-vous, que cela ne peut pas exc�der les configurations de php.ini. (%s)';
$lang['File_root'] = 'R�pertoire des Fichiers Attach�s';
$lang['File_root_explain'] = 'Le dossier dans lequel les fichers attach�s sont stock�s. Ce dossier doit �tre en CHMOD 777 et se trouver � la racine du r�pertoire de phpBB..';
$lang['Flood_limit_admin'] = 'Limit de Flood';
$lang['Flood_limit_admin_explain'] = 'Dur� avant que l\'utilisateur puisse soumettre � nouveau un formulaire. Mettez � \'0\' pour d�sactiver cette fonction (recommand� seulement pour les tests).';
$lang['Char_limit_admin'] = 'Maximum de Caract�res';
$lang['Char_limit_admin_explain'] = 'Fixer un nombre limit� de caract�res par message.  Mettez l\'option � \'0\' pour la d�sactiver.';

$lang['Captcha'] = 'Configurations de la Confirmation Visuelle';
$lang['Activate'] = 'Activer la Confirmation Visuelle?';
$lang['Enable'] = 'Activ�';
$lang['Disable'] = 'D�sactiv�';
$lang['Captcha_explain'] = 'Activer ceci pour obliger les utilisateurs � entrer un code avant de soumettre leur formulaire. Cela emp�chera un �ventuel spam.';
$lang['Type'] = 'Apparance du Captcha';
$lang['Type_explain'] = 'Selectionner le type de Captcha que vous voulez montrer sur votre formulaire.';
$lang['Image_bg'] = 'Image bas�';
$lang['Coloured'] = 'Color�';
$lang['Random'] = 'Al�atoire';

$lang['Copyright'] = '"Contact Form" par <a href="http://www.phobbia.net/mods/" target="_phpbb"><b>Ma&reg;&copy;uS</b></a> &copy; 2006-2007<br />(Original mod: darkassasin93)';

//
// "Quick Delete" - Added to 7.0.0
//
$lang['QDelete'] = 'Quick Delete';
$lang['QDelete_disabled'] = 'L\'option de suppression rapide a �t� d�sactiv�e';
$lang['File_Not_Here'] = 'Cette extension ne semble pas exister.';
$lang['File_Removed'] = 'Le fichier a �t� correctement supprim�.';
$lang['QDelete_explain'] = 'Permettre � l\'administrateur de supprimer rapidement l\'attachment via le lien de l\'E-mail?';
$lang['Remove_file'] = 'Pour supprimer ce fichier, suivez ce lien: %s';

//
// "Messages Log" - Added in 8.6.0
//
$lang['Admin_email_explain'] = 'Si il y a aucune adresse dans ce champ, les messages seront envoy�s � l\'administrateur de ce forum.';

$lang['Contact_date'] = 'Date';
$lang['Contact_ip'] = 'IP';
$lang['Contact_get'] = '%sT�l�charger%s';
$lang['Contact_remove'] = '%sEnlever%s';
$lang['Msg_delete'] = 'Supprimer';

$lang['Contact_msgs_title'] = 'Contact Form :: Messages Log';
$lang['Contact_msgs_text'] = 'Ce sont les messages que vous avez re�u via votre Formulaire, avec les derniers messages en t�te de liste.<br />&nbsp;&bull; Les messages peuvent �tre vus et supprim�s.<br />&nbsp;&bull; Les fichiers attach�s peuvent �tre recouvr�s et supprim�s.';

$lang['Msg_del_success'] = 'Le Message a �t� correctement effac�';
$lang['File_del_success'] = 'Le fichier attach� a �t� correctement effac�';
$lang['Confirm_delete_msg'] = 'Etes vous s�r de vouloire supprimer ce message?';
$lang['Confirm_delete_file'] = 'Etes vous s�r de vouloire supprimer ce fichier attach�?';
$lang['File_Not_Here'] = 'Ce fichier attach� ne devrait pas exister.';
$lang['Click_return_msglog'] = 'Cliquez %sIci%s pour retourner au Log des Messages';

$lang['Msg_Log'] = 'Messages Log';
$lang['Msg_Log_explain'] = 'Activer cette option vous permet de stocker les messages in votre base de donn�e pour servir de r�f�rence';

$lang['more'] = 'plus';

//
// "Thank You" - Added in 8.9.8
//
$lang['Thankyou_settings'] = '"Remerciement" Configuration';
$lang['Thankyou_option'] = 'Remercier l\'envoyeur';
$lang['Thankyou_explain'] = 'Mettre "Aucun" pour d�sactiver, "Membres" pour que seul les utilisateurs enregistr�s le recoivent ou "Tous" pour les invit�s l\'aient aussi.';
$lang['Thank_none'] = 'Aucun';
$lang['Thank_members'] = 'Membres';
$lang['Thank_all'] = 'Tous';
$lang['Thankyou_limit'] = 'D�sol�, nous ne pouvons pas accepter plus de retour depuis cette adresse e-mail pour une dur�e de 24 heures.';

?>