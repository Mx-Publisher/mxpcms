<?php
/***************************************************************************
 *                               lang_contact.php
 *                              ------------------
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *   	Copyright:	(C) 2006-07, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		21:20 01/06/2007
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

$lang['Contact_intro'] = 'Dacă aveţi comentarii, feedback sau sugestii referitoare la acest site, vă rugăm să folosiţi acest formular pentru a contacta direct.';
$lang['Newsletter_intro'] = 'Informatii prin email.';

$lang['Username'] = 'Username';
$lang['Real_name'] = 'Numele şi Prenumele Dvs. ';
$lang['Rname_require'] = 'Numele Dvs *';
$lang['Institution'] = 'Instituţia';
$lang['Explain_institution'] = '';
$lang['Phone'] = 'Nr.de telefon';
$lang['Explain_phone'] = '';
$lang['Fax'] = 'Nr. de fax';
$lang['Explain_fax'] = '';
$lang['E-mail'] = 'E-mail-ul Dvs.';
$lang['E-mail_require'] = 'E-mail-ul Dvs. *';
$lang['Comments'] = 'Mesajul Dvs.';
$lang['Comments_require'] = 'Mesajul Dvs. *';
$lang['Attachment'] = 'Attachment';
$lang['Agreement'] = 'Acord personal';
$lang['Agreement_explain'] = 'Da, doresc sa primesc si pe viitor articole (Debifati daca nu sunteti de acord)';

$lang['Feedback'] = 'Aţi primit Feedback';

$lang['Real_name_explain'] = 'Introduceţi numele dumneavoastră de aici. Acest lucru ne ajută să vă contactăm.';
$lang['Explain_email'] = 'Introduceţi adresa de e-mail aici. Acesta este utilizat în cazul în care avem nevoie să vă răspundem.';
$lang['Comments_explain'] = 'Introduceţi comentariile sau feedback-ul dumneavoastră aici.';
$lang['Flood_explain'] = '<br /><br />Acest formular are un sistem de control împotriva flood-ului. Puteţi să trimiteţi formularul doar o dată la fiecare %s %s.';
$lang['Comments_limit'] = '<br /><br />Administratorul a stabilit un maxim de %s caractere permise în mesaj.';
$lang['Attachment_explain'] = 'Post an attachment here, if required, and it will be received by the board Admin. Only files that are %sKb or lower are allowed.';

$lang['Guest'] = 'Vizitator';
$lang['Notify_IP'] = 'IP-ul Dvs. va fi logat pentru măsuri de siguranţă.';
$lang['Fields_required'] = 'Câmpurile cu * sunt obligatorii.';
$lang['Contact_form'] = 'Contact Form';
$lang['Newsletter_form'] = 'VA RUGAM SA COMPLETATI INFORMATIILE DE MAI JOS';
$lang['Newsletter_explain'] = 'daca doriti sa primiti pe viitor cataloage si oferte.';
$lang['Empty'] = 'Nu se specifică';

$lang['hours'] = 'ore';
$lang['hour'] = 'oră';

$lang['Chars'] = ' caractere';

$lang['Captcha_code'] = 'Captcha *';
$lang['Captcha_code_explain'] = 'The rugăm confirmă codul din imagine. Acest lucru este necesar pentru a descuraja spamboţii.';

$lang['Page_Not_Authorised']    	= 'Ne pare rău, dar nu eşti autorizat să accesezi această pagină.';
$lang['Execution_Stats'] 			= 'Pagina a generat %s querie - Timpul generării: %s secunde';
$lang['Redirect_login']    			= 'Click %sAici%s să te logezi.';
$lang['Show_admin_options']    		= 'Arată/Ascunde Opţiunile Admin pe Pagină: ';
$lang['Block_updated_date'] 		= 'Updatat ';
$lang['Block_updated_by'] 			= 'de ';
$lang['Powered_by'] 				= 'Powered by ';

$lang['mx_spacer'] 					= 'Spacer';
$lang['Yes'] 						= 'Da';
$lang['No'] 						= 'Nu';

$lang['domainkey_signature'] = 'DomainKey Signature';
$lang['domainkey_signature_exp'] = 'Your Domain Key Signature.';
$lang['smtp_port'] = 'SMTP PORT';
$lang['smtp_port_exp'] = 'The SMTP port supported by your e-mail server.';

//
// Errors
//
$lang['Rname-Empty'] = 'Numele real nu a fost furnizat.';
$lang['Comments-Empty'] = 'Câmpul de comentarii nu a fost complectat.';
$lang['Comments_exceeded'] = 'Mesajul dvs. este mai mare decât este permis.';
$lang['Email-Empty'] = 'Câmpul pentru e-mail nu a fost completat.';
$lang['Email-Check'] = 'Adresa de e-mail care aţi furnizato nu a fost valabilă.';
$lang['Attach-File_exists'] = 'A file already exists with that name from your IP Address.';
$lang['Attach-Too_big'] = 'The attachment you tried to send was too big. Make sure its %sKb or lower.';
$lang['Attach_dud'] = 'The attachment you tried to send does not exist. Please double check your upload link.';
$lang['Attach-Uploaded'] = 'Your attachment was successfully uploaded.';
$lang['Flood_limit'] = 'Sorry, but you must wait %d hour(s) until you can submit another form.';
$lang['Illegal_ext'] = 'This filetype (%s) is not permitted!';
$lang['Unknown_ext'] = 'This filetype (%s) cannot be accepted!';
$lang['zip_advise'] = 'If necessary, please zip the file before resubmitting.';
$lang['POST_ERROR'] = 'Upload Error - please try again!';
$lang['Image_error'] = 'Upload Error - Unable to process this image!';
$lang['Image_zip'] = 'Please zip this type of image before sending it.';
$lang['Code_Empty'] = 'Nu aţi confirmat codul din imagine!';
$lang['Code_Wrong'] = 'Codul care le-aţi introdus a fost incorect!';

$lang['Contact_error'] = '<b>A apărut o eroare la încercarea de a trimite feedback-ul dvs.!</b>';
$lang['Contact_success'] = '<b>Mesajul dvs. a fost trimis cu succes!</b>';

$lang['Click_return_form'] = '<br /><br />Faceţi clic %sAici%s pentru a reveni la formular.';

$lang['Contact_Disabled'] = 'Formularul nu este disponibil în prezent.';

//
// Admin
//
$lang['General_settings'] = 'General Settings';
$lang['Contact_title'] = 'Contact Form';
$lang['Contact_explain'] = 'Use this page to alter the settings and features of the Contact Form, as well as field requirements.';
$lang['Req_settings'] = 'Requirement Settings';
$lang['Attachment_settings'] = 'Attachment Settings';
$lang['Contact_updated'] = 'Contact Configuration Updated Successfully';
$lang['Click_return_contact'] = 'Click %sHere%s to return to the Contact Form configuration';
$lang['Disable'] = 'Disable';

$lang['Form_Enable'] = 'Enable Contact Form';

$lang['kb'] = 'kilobytes';

$lang['Hash'] = 'Attachment Hashing Method';
$lang['Hash_explain'] = 'All uploads can be renamed with a random hash, for increased security.';
$lang['md5'] = 'MD5';
$lang['no_hash'] = 'No Hash';

$lang['auth_permission'] = 'Attachment Permissions';
$lang['auth_perm_explain'] = 'If attachments are permitted you can select who can upload files.';
$lang['auth_guests'] = 'Guests';
$lang['auth_members'] = 'Members';
$lang['auth_mods'] = 'Moderators';
$lang['auth_admins'] = 'Admins';

$lang['Require_rname'] = 'Require Real Name';
$lang['Require_email'] = 'Require E-mail';
$lang['Require_comments'] = 'Require Comments';
$lang['Permit_attachments'] = 'Permit Attachments';
$lang['Prune'] = 'Enable Pruning';
$lang['Prune_explain'] = 'Enable this to delete any SQL entries that have already done their flood limit job to reduce database size.';
$lang['Max_file_size'] = 'Max File Size';
$lang['Max_file_size_explain'] = 'The maximum file size for attachments for storing on your web server. Remember, this cannot exceed your php.ini setting. (%s)';
$lang['File_root'] = 'Attachment File Root';
$lang['File_root_explain'] = 'The folder in which any attachments are saved. The folder must be CHMOD 777 and is relative to the phpBB root path.';
$lang['Flood_limit_admin'] = 'Flood Limit';
$lang['Flood_limit_admin_explain'] = 'This is how long is allowed before a user can submit a new form. Set to \'0\' to disable this function (only recommended for testing).';
$lang['Char_limit_admin'] = 'Maximum Characters';
$lang['Char_limit_admin_explain'] = 'You can set an upper limit as to how many characters can be in a message.  Set to \'0\' to disable this option.';

$lang['Captcha'] = 'Captcha Options';
$lang['Activate'] = 'Activate Captcha?';
$lang['Enable'] = 'Enable';
$lang['Disable'] = 'Disable';
$lang['Captcha_explain'] = 'Enable this to require users to enter a code before submitting a form. This will prevent spambots abusing the form.';
$lang['Type'] = 'Captcha Appearance';
$lang['Type_explain'] = 'Select the type of Captcha you want displayed on your form.';
$lang['Image_bg'] = 'Image based';
$lang['Coloured'] = 'Coloured';
$lang['Random'] = 'Random';

$lang['Copyright'] = '"Contact Form" by <a href="http://www.phobbia.net/mods/" target="_phpbb"><b>Ma&reg;&copy;uS</b></a> &copy; 2006-2007<br />(Original mod: darkassasin93)';

//
// "Quick Delete" - Added to 7.0.0
//
$lang['QDelete'] = 'Quick Delete';
$lang['QDelete_disabled'] = 'Quick Delete option has been Disabled';
$lang['File_Not_Here'] = 'That Attachment does not appear to exist.';
$lang['File_Removed'] = 'The File has been successfully deleted.';
$lang['QDelete_explain'] = 'Allow Admin to Quick Delete Attachments via an E-mail link?';
$lang['Remove_file'] = 'To delete this file, follow this link: %s';

//
// "Messages Log" - Added in 8.6.0
//
$lang['Admin_email_explain'] = 'If left blank e-mails will be sent to the Site Admin address of this board.';

$lang['Contact_date'] = 'Date';
$lang['Contact_ip'] = 'IP';
$lang['Contact_get'] = '%sGet%s';
$lang['Contact_remove'] = '%sRemove%s';
$lang['Msg_delete'] = 'Delete';

$lang['Contact_msgs_title'] = 'Contact Form :: Messages Log';
$lang['Contact_msgs_text'] = 'These are the messages you have received via your Contact Form, with the newest messages listed first.<br />&nbsp;&bull; Messages can be reviewed and deleted.<br />&nbsp;&bull; Attached files can be retrieved and deleted.';

$lang['Msg_del_success'] = 'Message(s) deleted successfully';
$lang['File_del_success'] = 'Attachment deleted successfully';
$lang['Confirm_delete_msg'] = 'Are you sure you want to delete the Message(s)?';
$lang['Confirm_delete_file'] = 'Are you sure you want to delete this Attachment?';
$lang['File_Not_Here'] = 'That Attachment does not appear to exist.';
$lang['Click_return_msglog'] = 'Click %sHere%s to return to the Messages Log';

$lang['Msg_Log'] = 'Messages Log';
$lang['Msg_Log_explain'] = 'Activating this allows you to store messages in your database for reference';

$lang['more'] = 'more';

//
// "Thank You"
//
$lang['Thankyou_settings'] = '"Thank You" Settings';
$lang['Thankyou_option'] = 'Thank the Sender';
$lang['Thankyou_explain'] = 'Set as "None" to disable, "Members" for Registered users only to receive this, or "All" for Guests also.';
$lang['Thank_none'] = 'Nici unul';
$lang['Thank_members'] = 'Membrii';
$lang['Thank_all'] = 'Toţi';
$lang['Thankyou_limit'] = 'Ne pare rău, nu putem accepta mai cereri de la această adresă de e-mail pentru 24 de ore.';

//Mass News
$lang['All_subcribers'] = 'Toţi abonaţii';
$lang['newsletter_mass_Explain'] = 'Here you can email a message to either all of your users, or all users of a specific group.  To do this, an email will be sent out to the administrative email address supplied, with a blind carbon copy sent to all recipients. <br />
This modified script will send the emails in several batches. This should circumvent timeout and server-load issues. The status of the mass mail sending will be saved in the db. You can close the window, when you want to pause mass-mail-sending (the current batch will be sent out). You can later simply continue where you left off.';
$lang['newsletter_mass_header'] = 'Your Email-Sessions';
$lang['newsletter_mass_id'] = 'Mail-ID';
$lang['newsletter_mass_batchstart'] = 'Processed';
$lang['newsletter_mass_batchsize'] = 'Mails per Batch';
$lang['newsletter_mass_batchwait'] = 'Pause';
$lang['newsletter_mass_created_message'] = 'The Mass Mail has been saved to the database.<br /><br/> To start sending %sclick here%s or wait until the Meta-Refresh takes you there...';
$lang['newsletter_mass_send_message'] = 'The Current Batch (%s - %s) has been sent .<br /><br/> To continue sending %sclick here%s or wait until the Meta-Refresh takes you there...';
$lang['newsletter_mass_status'] = 'Status';
$lang['newsletter_mass_proceed'] = '%sProceed now%s';
$lang['newsletter_mass_done'] = 'DONE';
$lang['newsletter_mass_none'] = 'No records were found.';

//Mass Mail
$lang['Megamail_Explain'] = 'Here you can email a message to either all of your users, or all users of a specific group.  To do this, an email will be sent out to the administrative email address supplied, with a blind carbon copy sent to all recipients. <br />
This modified script will send the emails in several batches. This should circumvent timeout and server-load issues. The status of the mass mail sending will be saved in the db. You can close the window, when you want to pause mass-mail-sending (the current batch will be sent out). You can later simply continue where you left off.';
$lang['megamail_header'] = 'Your Email-Sessions';
$lang['megamail_id'] = 'Mail-ID';
$lang['megamail_batchstart'] = 'Processed';
$lang['megamail_batchsize'] = 'Mails per Batch';
$lang['megamail_batchwait'] = 'Pause';
$lang['megamail_created_message'] = 'The Mass Mail has been saved to the database.<br /><br/> To start sending %sclick here%s or wait until the Meta-Refresh takes you there...';
$lang['megamail_send_message'] = 'The Current Batch (%s - %s) has been sent .<br /><br/> To continue sending %sclick here%s or wait until the Meta-Refresh takes you there...';
$lang['megamail_status'] = 'Status';
$lang['megamail_proceed'] = '%sProceed now%s';
$lang['megamail_done'] = 'DONE';
$lang['megamail_none'] = 'No records were found.';

?>