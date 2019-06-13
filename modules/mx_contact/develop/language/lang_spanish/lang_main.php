<?php
/***************************************************************************
 *                               lang_contact.php - Spanish
 *                              ----------------------------
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *   	Copyright:	(C) 2006, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		21:23 01/06/2007
 *
 *	Translated by:	Dogs and things
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software;you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation;either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

$lang['Contact_intro'] = 'Si tiene comentarios o sugerencias relacionados con este sitio web o problemas cuando intente registrarse o conectarse, por favor utilice este Formulario de Contacto para ponerse en contacto con el Adminitrador.';

$lang['Username'] = 'Nombre de usuario';
$lang['Real_name'] = 'Nombre real';
$lang['Rname_require'] = 'Nombre real *';
$lang['E-mail'] = 'Direcci�n de correo el�ctronico';
$lang['E-mail_require'] = 'Direcci�n de correo el�ctronico *';
$lang['Comments'] = 'Comentarios';
$lang['Comments_require'] = 'Comentarios *';
$lang['Attachment'] = 'Adjunto';

$lang['Feedback'] = 'Hemos recibido tu sugerencia';

$lang['Real_name_explain'] = 'Introduzca tu nombre aqu�. Esto nos ayuda a contactar m�s f�cilmente contigo si no eres un usuario registrado.';
$lang['Explain_email'] = 'Introduzca tu direcci�n de correo el�ctronico aqu�. Esto lo usaremos en caso de tener que contactar contigo directamente.';
$lang['Comments_explain'] = 'Introduzca tus sugerencias aqu�.';
$lang['Flood_explain'] = '<br /><br />Este sistema usa un sistema de control de "flood". Solamente puedes enviar un formulario cada %s %s.';
$lang['Comments_limit'] = '<br /><br />El Administrador ha establecido un n� m�ximo de %s car�cteres permitido en tu mensaje.';
$lang['Attachment_explain'] = 'A�ade un adjunto aqu�, en caso necesario, y ser� recibido por el Administrador del sitio. Solamente se admiten adjuntos con un tama�o de %sKb o menos.';

$lang['Guest'] = 'Invitado';
$lang['Notify_IP'] = 'Tu direcci�n IP ser� registrado por razones de seguridad.';
$lang['Fields_required'] = 'Campos con un * son obligatorios.';
$lang['Contact_form'] = 'Formulario de Contacto';
$lang['Empty'] = 'No Especificado';

$lang['hours'] = 'horas';
$lang['hour'] = 'hora';

$lang['Chars'] = ' car�cteres';

$lang['Captcha_code'] = 'Captcha *';
$lang['Captcha_code_explain'] = 'Por favor, introduzca el c�digo que ves en la imagen. Esto es obligatorio para evitar robots publicitarios.';

//
// Errores
//
$lang['Rname-Empty'] = 'No has introducido tu nombre real.';
$lang['Comments-Empty'] = 'No rellenaste el campo de sugerencias.';
$lang['Comments_exceeded'] = 'Tu mensaje tiene m�s car�cteres de lo permitido.';
$lang['Email-Empty'] = 'No rellenaste el campo de direcci�n de correo el�ctronico.';
$lang['Email-Check'] = 'Tu direcci�n de correo el�ctronico no es v�lida.';
$lang['Attach-File_exists'] = 'Ya existe un adjunto con este nombre enviado desde tu direcci�n IP.';
$lang['Attach-Too_big'] = 'El adjunto que intentas enviar es demasiado grande. Aseg�rate de que tiene %sKb o menos.';
$lang['Attach_dud'] = 'El adjunto que intentas enviar no existe. Por favor, revisa el enlace de subida.';
$lang['Attach-Uploaded'] = 'Tu adjunto ha sido subido con �xcito.';
$lang['Flood_limit'] = 'Perd�na, pero debes esperar %d hora(s) antes de que puedas enviar otro formulario.';
$lang['Illegal_ext'] = '�Este tipo de archivo (%s) no esta permitido!';
$lang['Unknown_ext'] = '�Este tipo de archivo (%s) no se puede aceptar!';
$lang['zip_advise'] = 'Si es necesario, por favor zip el archivo antes de reenviarlo.';
$lang['POST_ERROR'] = '�Error de subida - por favor int�ntalo de nuevo!';
$lang['Image_error'] = '�Error de subida - Ha sido imposible procesar esta imagen!';
$lang['Image_zip'] = 'Por favor, zip este tipo de imagen antes de enviarlo.';
$lang['Code_Empty'] = '�No has introducido el c�digo de la imagen!';
$lang['Code_Wrong'] = 'El c�digo introducido es incorrecto!';

$lang['Contact_error'] = '<b>�Ha ocurrido un error al intentar enviar tu sugerencia!</b>';
$lang['Contact_success'] = '<b>�Tu mensaje ha sido enviado con �xcito!</b>';

$lang['Click_return_form'] = '<br /><br />Click %sAqu�%s para volver al Formulario de Contacto';

$lang['Contact_Disabled'] = 'En este momento el Formulario de Contacto no esta disponible';

//
// Admin
//
$lang['General_settings'] = 'Configuraci�n General';
$lang['Contact_title'] = 'Formulario de Contacto';
$lang['Contact_explain'] = 'Utiliza esta p�gina para cambiar la configuraci�n del Formulario de Contacto.';
$lang['Req_settings'] = 'Configuraci�n de Requisitos';
$lang['Attachment_settings'] = 'Configuraci�n de Adjuntos';
$lang['Contact_updated'] = 'Configuraci�n de Contacto actualizada con �xcito';
$lang['Click_return_contact'] = 'Click %sAqu�%s para volver a la Configuraci�n del Formulario de Contacto';
$lang['Admin_email_explain'] = 'Si dejas esto en blanco los e-mails ser�n enviados al Administrador del Sitio de este foro.';

$lang['Form_Enable'] = 'Activar Formulario de Contacto'; 

$lang['kb'] = 'kilobytes';

$lang['Hash'] = 'M�todo de Hashing de Adjuntos';
$lang['Hash_explain'] = 'Todas las subidas pueden ser renombradas con un Hash aleatorio, para mejorar la seguridad.';
$lang['md5'] = 'MD5';
$lang['no_hash'] = 'No Hash';

$lang['auth_permission'] = 'Permisos de Adjuntos';
$lang['auth_perm_explain'] = 'Cuando Adjuntos est�n permitidos puedes seleccionar quien puede subir archivos.';
$lang['auth_guests'] = 'Invitados';
$lang['auth_members'] = 'Miembros';
$lang['auth_mods'] = 'Moderadores';
$lang['auth_admins'] = 'Admins';

$lang['Require_rname'] = 'Pedir Nombre Real';
$lang['Require_email'] = 'Pedir correo el�ctronico';
$lang['Require_comments'] = 'Pedir Comentarios';
$lang['Permit_attachments'] = 'Permitir Adjuntos';
$lang['Prune'] = 'Activar borrar l�mites de data de de la tabla Flood';
$lang['Prune_explain'] = 'Activa esto para eliminar cualquier entrada SQL que ya ha hecho su trabajo de limitar el L�mite de flood para reducir el tama�o de la base de datos.';
$lang['Max_file_size'] = 'Tama�o M�ximo de Archivo';
$lang['Max_file_size_explain'] = 'El tama�o m�ximo de Adjuntos para guardar en tu servidor web. Recuerda que esto no puede superar tu configuraci�n del php.ini. (%s)';
$lang['File_root'] = 'Directorio Ra�z de Archivos Adjuntos';
$lang['File_root_explain'] = 'El directorio en el cual todos los Adjuntos son guardados. Este directorio debe ser CHMOD 777 y es relativo al ra�z de phpBB.';
$lang['Flood_limit_admin'] = 'L�mite de Flood';
$lang['Flood_limit_admin_explain'] = 'Esto especifica cuanto tiempo debe pasar antes de que un usuario puede enviar un nuevo formulario. P�nlo en \'0\' para desactivar esta funci�n (solamente recommendada para pruebas).';
$lang['Char_limit_admin'] = 'M�ximo de Car�cteres';
$lang['Char_limit_admin_explain'] = 'Puedes especificar un l�mite m�ximo del n�mero de car�cteres que puede tener un mensaje. P�nlo en \'0\' para desactivar esta opci�n.';

$lang['Captcha'] = 'Opciones de Captcha';
$lang['Activate'] = '�Activar Captcha?';
$lang['Enable'] = 'Activar';
$lang['Disable'] = 'Desactivar';
$lang['Captcha_explain'] = 'Activar para pedir que un usuario debe confirmar un c�digo antes de enviar un formulario. Esto previene que spambots abusan del formulario.';
$lang['Type'] = 'Apariencia del Captcha';
$lang['Type_explain'] = 'Selecciona el tipo de Captcha que quieres mostrar en tu formulario.';
$lang['Image_bg'] = 'Imagen';
$lang['Coloured'] = 'Coloros';
$lang['Random'] = 'Aleatorio';

$lang['Copyright'] = '"Contact Form" by <a href="http://www.phobbia.net/mods/" target="_phpbb"><b>Ma&reg;&copy;uS</b></a> &copy;2006-2007<br />(Mod Original: darkassasin93)';

//
// "Quick Delete" - Added to 7.0.0
//
$lang['QDelete'] = 'Borrado R�pido';
$lang['QDelete_disabled'] = 'La opci�n "Borrado R�pido" ha sido desactivada';
$lang['File_Not_Here'] = 'Parece que este Adjunto no existe.';
$lang['File_Removed'] = 'El archivo ha sido borrado con �xcito.';
$lang['QDelete_explain'] = '�Permitir Admin el "Borrado R�pido" de Adjuntos mediante un enlace por E-mail?';
$lang['Remove_file'] = 'Para borrar este archivo, siga este enlace: %s';

// 
// "Messages Log" - Added in 8.6.0 
// 
$lang['Contact_date'] = 'Fecha';
$lang['Contact_ip'] = 'IP';
$lang['Contact_get'] = '%sBajar%s';
$lang['Contact_remove'] = '%sEliminar%s';
$lang['Msg_delete'] = 'Borrar';

$lang['Contact_msgs_title'] = 'Formulario de Contacto :: Lista de Mensajes';
$lang['Contact_msgs_text'] = 'Estos son los mensajes que has recibido a traves de tu Formulario de Contacto, los �ltimos mensajes aparecen al principio de la lista.<br />&nbsp;&bull; Los mensajes se pueden revisar y borrar.<br />&nbsp;&bull; Archivos Adjuntos se pueden revisar y borrar.';

$lang['Msg_del_success'] = 'El Mensaje se ha borrado con �xcito';
$lang['File_del_success'] = 'El Adjunto se ha borrado con �xcito';
$lang['Confirm_delete_msg'] = '�Est�s seguro de que quieres borrar este Mensaje?';
$lang['Confirm_delete_file'] = '�Est�s seguro de que quieres borrar este Adjunto?';
$lang['File_Not_Here'] = 'Parece que este Adjunto no existe.';
$lang['Click_return_msglog'] = 'Click %sAqu�%s para volver a la Lista de Mensajes';

$lang['Msg_Log'] = 'Lista de Mensajes';
$lang['Msg_Log_explain'] = 'Activar esto te permita guardar mensajes en tu base de datos';

$lang['more'] = 'm�s';

//
// "Thank You" - Added in 8.9.8
//
$lang['Thankyou_settings'] = '"Gracias" Configuraci�n';
$lang['Thankyou_option'] = 'Dar las gracias al remitente';
$lang['Thankyou_explain'] = 'Marcar "Nadie" para desactivar, "Usuarios" para que solamente Usuarios Registrados lo reciben, o "Todos" para incluir Invitados tambi�n.';
$lang['Thank_none'] = 'Nadie';
$lang['Thank_members'] = 'Usuarios';
$lang['Thank_all'] = 'Todos';
$lang['Thankyou_limit'] = 'Lo sentimos, no podemos recibir m�s comentarios desde esta direcci�n de email durante las pr�ximas 24 horas.';

?>