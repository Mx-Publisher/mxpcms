<?php
/***************************************************************************
 *                            lang_admin.php [English]
 *                              -------------------
 *     copyright            : (C) 2003 Mx System
 *     email                : support@mx-system.com
 *
 *   $Id: lang_admin.php,v 1.13 2003/12/31 11:07:04 jonohlsson Exp $
 *
 *	 Rev. hist            : Created by MarcMoris (support@mx-system.com),
                              reedited by Yomero
 ****************************************************************************/

//
// The format of this file is:
//
// ---> $lang["message"] = "text";
//
// Specify your language character encoding... [optional]
//
// setlocale(LC_ALL, "en");

//
// Configuration
//

 $lang['Portal_admin']              = "Administraci�n del Portal";
 $lang['Portal_admin_explain']      = "Use esta forma para  modificar tu portal";
 $lang['Portal_General_Config']     = "Configuraci�n del Portal";
 $lang['Portal_General_settings']   = "Configuraciones Generales";
 $lang['Portal_General_config_info'] = "Informaci�n General de la Configuraci�n del Portal";
 $lang['Portal_General_config_info_explain'] = "Informaci�n generada de la instalaci�n del archivo config.php (no editar)";
 $lang['Portal_Name']               = "Nombre del Portal:";
 $lang['Portal_PHPBB_Url']          = "URL a la instalaci�n del PHPBB:";
 $lang['Portal_Url']                = "URL al Mx Portal:";
 $lang['Portal_Config_updated']     = "Configuraci�n del Portal Actualizada Exit�samente";
 $lang['Click_return_portal_config'] = "Presiona %sHere%s para regresar a la Configuraci�n del Portal";

 //
// Menu Management
//

 $lang['Menu_admin']                = "Administraci�n del Men�";
 $lang['Menu_admin_explain']        = "Usa esta forma para modificar tu men�";
 $lang['Menu_edit_delete_explain']  = "Usa esta forma para modificar tu men�";
 $lang['Menu_settings']             = "Informaci�n del Men�";
 $lang['Menu_delete']               = "Borrar un Men�";
 $lang['Menu_delete_explain']       = "Usa esta forma para borrar (y/o mover) una categor�a y sus subelemento(s)";
 $lang['Edit_Menu']                 = "Editar un Men�";
 $lang['Update']                    = "Actualizar";
 $lang['Create_Menu']               = "Agregar nuevo Men�";
 $lang['Create_category']           = "Agregar nueva categoria";
 $lang['Menu_Config_updated']       = "Configuraci�n del Men� Actualizada exit�samente";
 $lang['Menus_updated']             = "Informaci�n del Men� y Categoria Actualizada exit�samente";
 $lang['Click_return_Menuadmin']    = "Presiona %sHere%s para regresar a la Administraci�n del Men�";
 $lang['Menu_name']                 = "Nombre del Men�";
 $lang['Menu_icon']                 = "Icono del Men�";
 $lang['Menu_desc']                 = "Descripci�n ";
 $lang['Edit']                      = "Editar";
 $lang['Delete']                    = "Borrar";
 $lang['Move_up']                   = "Mover hacia arriba";
 $lang['Move_down']                 = "Mover hacia abajo";
 $lang['Resync']                    = "Resincronizar";
 $lang['Click_return_admin_index']  = "Presiona %sHere%s para regresar a la Administraci�n del Indice";

//
// Module Management
//

 $lang['Module']                    = "M�dulo";
 $lang['Module_admin']              = "Administraci�n de M�dulo";
 $lang['Module_admin_explain']      = "Usa esta forma para modificar los m�dulos";
 $lang['Column_delete']             = "Borrar una Columna";
 $lang['Module_delete']             = "Borrar un Modulo";
 $lang['Module_delete_explain']     = "Usa esta forma para borrar un M�dulo (o funci�n)";
 $lang['Edit_module']               = "Editar un M�dulo";
 $lang['Create_module']             = "Agregar un M�dulo";
 $lang['Module_Config_updated']     = "Configuraci�n del M�dulo Actualizado exit�samente";
 $lang['Module_updated']            = "Informaci�n del M�dulo Actualizado exit�samente";
 $lang['Click_return_module_admin'] = "Presiona %sHere%s para regresar a la Administraci�n del M�dulo";
 $lang['Column_name']               = "Nombre de Columna";
 $lang['Module_name']               = "Nombre de M�dulo";
 $lang['Module_desc']               = "Descripci�n";
 $lang['Module_path']               = "Path";
 $lang['Create_column']             = "Agregar nueva columna";
 $lang['Column']                    = "Columna";
 $lang['Edit_Column']               = "Editar una Columna";
 $lang['Edit_Column_explain']       = "Usa esta forma para modificar una columna";
 $lang['Column_Size']               = "Tama�o de la columna";

//
// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!
//

 $lang['Menu_Navigation']           = "Men� de Navegaci�n";
 $lang['Modules']                   = "M�dulos";
 $lang['Portal_index']              = "Indice del Portal";
 $lang['Poll_Display']              = "Cual Poll quieres visualizar?";
 $lang['Meta_admin']                = "Administraci�n de Meta Tags";
 $lang['Mega_admin_explain']        = "Usa esta forma para modificar tus Meta tags";
 $lang['Meta_Title']                = "T�tulo";
 $lang['Meta_Author']               = "Autor";
 $lang['Meta_Copyright']            = "Copyright";
 $lang['Meta_Keywords']             = "Palabras clave";
 $lang['Meta_Keywords_explain']     = "(lista separada por comas)";
 $lang['Meta_Description']          = "Descripci�n";
 $lang['Meta_Language']             = "C�digo del lenguaje";
 $lang['Meta_Rating']               = "Rating";
 $lang['Meta_Robots']               = "Robots";
 $lang['Meta_Pragma']               = "Pragma no-cache";
 $lang['Meta_Bookmark_icon']        = "Icono de Favoritos";
 $lang['Meta_Bookmark_explain']     = "(locaciones relativas)";
 $lang['Meta_HTITLE']               = "Configuraciones extras del encabezado";
 $lang['Create_block']              = "Crear nuevo Bloque";
 $lang['Block_delete']              = "Borrar un  Bloque";
 $lang['Block_delete_explain']      = "Usa esta forma para borrar un Bloque (o columna)";
 $lang['Block']                     = "Bloque";
 $lang['Block_title']               = "T�tulo";
 $lang['Block_desc']                = "Descripci�n";
 $lang['Add_Block']                 = "Agregar Bloque";
 $lang['Auth_Block']                = "Permisos";
 $lang['AUTH_ALL']                  = "TODOS";
 $lang['AUTH_REG']                  = "REG";
 $lang['AUTH_PRIVATE']              = "PRIVADOS";
 $lang['AUTH_MOD']                  = "MOD";
 $lang['AUTH_ADMIN']                = "ADMIN";
 $lang['AUTH_ANONYMOUS']            = "ANONIMOS";
 $lang['Function']                  = "Funcci�n";
 $lang['Settings']                  = "Configuraciones";
 $lang['Save_Settings']             = "Guardar Configuraciones";
 $lang['announce_nbr_display']      = "N�mero de mensajes a mostrar (max)";
 $lang['announce_nbr_days']         = "N�mero de D�as para mostrar los Mensajes";
 $lang['announce_img']              = "Im�gen de Anuncios";
 $lang['announce_img_sticky']       = "Im�gen de Post it";
 $lang['announce_img_normal']       = "Im�gen de Mensaje Normal";
 $lang['announce_img_global']       = "Im�gen de Anuncio Global";
 $lang['announce_display']          = "Muestra en este M�dulo el Anuncio ";
 $lang['announce_display_sticky']   = "Muestra en este M�dulo el Post it ";
 $lang['announce_display_normal']   = "Muestra en este M�dulo el mensaje ";
 $lang['announce_display_global']   = "Muestra en este M�dulo el anuncio global  ";
 $lang['announce_forum']            = "Fuente de los Foros<br /> Podr�as hacer m�ltiples selecciones<br />* Si ninguno es seleccionado, todos los foros autorizados ser�n visibles";
 $lang['poll_forum']                = "Fuente de los Foros<br /> Podr�as hacer m�ltiples selecciones<br />* Si ninguno es seleccionado, todos los foros autorizados ser�n visibles";
 $lang['Function_admin']            = "Administraci�n de Funciones";
 $lang['Function_admin_explain']    = "Cada m�dulo tiene una o m�s funciones. Usa esta forma para editar, agregar, o borrar una funci�n";
 $lang['Function_name']             = "Nombre de Funci�n";
 $lang['Function_desc']             = "Descripci�n";
 $lang['Function_file']             = "Archivo ( Script ) ";
 $lang['Create_function']           = "Agregar nueva Funci�n";
 $lang['Parameter_name']            = "Nombre ";
 $lang['Parameter_desc']            = "Descripci�n";
 $lang['Parameter_type']            = "Tipo";
 $lang['Parameter_default']         = "Valor por Default";
 $lang['import_module_pack']        = "Instalar un M�dulo";
 $lang['import_module_pack_explain']        = "Esto agregar� un m�dulo al portal. Asegurese que el paquete del m�dulo este cargado a la carpeta /modules... y use la versi�n m�s actual de m�dulos!";
 $lang['upgrade_module_pack']       = "Actualizar M�dulos";
 $lang['upgrade_module_pack_explain']       = "Esto actualizar� tus m�dulos. Asegurese leer el documento module antes de proceder, o podr�a correr el riesgo de perder datos del m�dulo.";
 $lang['export_module_pack']        = "Exportar M�dulo";
 $lang['Export_Module']             = "Seleccionar un m�dulo:";
 $lang['export_module_pack_explain']             = "Esto exportar� un m�dulo de archivo *.pak. S�lamente recomendado para escritores de m�dulos...";
 $lang['Not_Specified']             = "No Especificado";
 $lang['Page']                      = "P�gina";
 $lang['Add_Page']                  = "Agregar nueva p�gina";
 $lang['Block_admin']               = "Administraci�n de Bloques";
 $lang['Block_admin_explain']       = "Use esta forma para agregar, borrar y cambiar la configuraci�n de cada bloque.";
 $lang['Module_include_admin']      = "Incluir este m�dulo en Administrador del Menu de Navegaci�n";
 $lang['Translation_Tools']         = "Herramientas de Traducci�n";
 $lang['Create_parameter']          = "Agregar nuevo Par�metro";
 $lang['Parameter_admin']           = "Administraci�n de Par�metros";
 $lang['Parameter_admin_explain']   = "Listar todos los par�metros para esta funci�n";
 $lang['Parameter_id']              = "Id";
 $lang['Parameter_function']        = "Funci�n";
 $lang['Preview_portal']            = "Preliminar del  Portal";
 $lang['Page_admin']                = "P�gina de Administraci�n";
 $lang['Page_Config_updated']       = "Configuraci�n de Pagina Actulizada Exitosamente";
 $lang['Page_updated']              = "Informaci�n de P�gina y Columna actualizadas exitosamente";
 $lang['Click_return_page_admin']   = "Presiona %sHere%s para regresar a la P�gina de Administraci�n";

 $lang['Module_delete_db']   = "Ahora este m�dulo esta borrado del portal, pero las tablas de la base de datos de este modulo siguen vigentes. Quiere eliminar definitivamente cualquier tabla relacionada del m�dulo. Advertencia: Eliminar� todos los datos. Esto no deber� hacerse si planea actualizar o reinstalar el m�dulo.";
 $lang['Click_module_delete_db_yes']   = "Presiona %sHere%s para eliminar todas las tablas de la base de datos permanentemente";


//
// Install Process
//

 $lang['Initial_config']            = "Configuraci�n B�sica";
 $lang['DB_config']                 = "Configuraci�n Base de Datos";
 $lang['Admin_config']              = "Configuraci�n del Administrador";
 $lang['continue_upgrade']          = "Una vez que ha bajado el archivo config a su computadora usted podr�a presionar el bot�n 'Continue Upgrade' debajo para continuar con el proceso de actualizaci�n.  Por favor espere hasta que el archivo config termine el proceso de actualizaci�n.";
 $lang['upgrade_submit']            = "Continuar Actualizaci�n";
 $lang['Installer_Error']           = "Un error ocurri� durante la intalacion";
 $lang['Previous_Install']          = "Una instalaci�n anterior ha sido detectada";
 $lang['Install_db_error']          = "Un error ocurrio al tratar de acrualizar la base de datos";
 $lang['Re_install']                = "Su instalaci�n previa sigue a�n activa. <br /><br />Si desea reinstalar MX-Portal debe presionar el bot�n Yes debajo. Por favor tenga en cuenta que al hacerlo destruir� todos los datos existentes, ning�n respaldo ser� hecho! El nombre de usuario y password del administrador username and password que ha utilizado para entrar a la pizarra ser�n re-creados despu�s de la re-instalaci�n, ninguna otra configuraci�n ser� retenida. <br /><br />Anal�celo cuidadosamente antes de proceder!";
 $lang['Start_Install']             = "Comienze Instalaci�n de MX";
 $lang['Finish_Install']            = "Omitir Instalaci�n de MX";
 $lang['Default_lang']              = "Lenguaje predeterminado de la pizarra";
 $lang['DB_Host']                   = "Base de Datos del Sevidor Hostname/DSN";
 $lang['DB_Name']                   = "Nombre de la Base de Datos";
 $lang['DB_Username']               = "Usuario de Base de Datos";
 $lang['DB_Password']               = "Password de Base de Datos";
 $lang['Database']                  = "Su Base de Datos";
 $lang['Install_lang']              = "Escoja lenguaje de la Instalaci�n";
 $lang['dbms']                      = "Tipo de Base de Datos";
 $lang['Table_Prefix']              = "Prefijo de PhpBB en Base de Datos";
 $lang['MX_Table_Prefix']           = "Prefijo de MX-Portal en Base de Datos";
 $lang['Admin_Username']            = "Nombre de Usuario de Administrador en el Portal";
 $lang['Admin_Password']            = "Password de Administrador en el Portal";
 $lang['Admin_Password_confirm']    = "Password de Administrador en el Porta [Confirmar]";
 $lang['Inst_Step_2']               = "En este punto la instalaci�n b�sica esta completa. Ahora ser� llevado a una pantalla que le perimitir�  administrar su nueva instalaci�n. Asegurese por favor de checar las configuraciones del Portal y haga los cambios requeridos. Gracias por elegir MX-Portal.";
 $lang['Unwriteable_config']        = "Su archivo config (config.php) esta como no-escitura en este momento.<br />Una copia del archivo config ser� bajada cuando presiones el bot�n de abajo. <br />Deber� subir este archivo en el mismo directorio ra�z del MX.<br />Una vez relizado esto agregue las tablas manualmente en la base de datos usando el  mx_db_install.php script. Necesitar� agregar las rutas correctas en la tabla table mx_portal de la base de datos usando la herramienta de su preferencia para base de datos. <br />Despu�s, ingrese usando su nombre y password de administrador para entrar a su Portal/foro.<br /> Gracias por elegir MX Portal.";
 $lang['Download_config']           = "Bajar Config";
 $lang['ftp_choose']                = "Escoja m�todo para bajar";
 $lang['ftp_option']                = "<br />Desde que las extensiones FTP estan habilitadas en ests versi�n de PHP deber�n ser escogidas las opciones de tratar automaticamente el ftp para que sea instalado el archivo config en su lugar.";
 $lang['ftp_instructs']             = "Ha escogido que ftp instale el archivo de la cuenta que contiene MX-Portal automaticamente. Por favor ingrese la informacion abajo para facilitar este proceso. Note que la ruta FTP deber� ser la ruta exacta via ftp para su instalaci�n de phpBB2 como si lo estuviera haciendo de un cliente ftp.";
 $lang['ftp_info']                  = "Ingrese su informaci�n FTP";
 $lang['Attempt_ftp']               = "Tratando de hacer ftp el archivo config en su lugar";
 $lang['Send_file']                 = "S�lamente envieme el archivo a m� y lo har� manualmente con mi ftp";
 $lang['ftp_path']                  = "Ruta FTP a MX-Portal";
 $lang['ftp_username']              = "Su Nombre de usuario FTP";
 $lang['ftp_password']              = "Su Password FTP";
 $lang['Transfer_config']           = "Comenzar tranferencia";
 $lang['NoFTP_config']              = "El intento de el archivo config en ftp de instalarlo en su lugar ha fallado.  Por favor baje el archivo config y hagalo manualmente con su FTP.";
 $lang['Install']                   = "Instalar";
 $lang['Upgrade']                   = "Actualizar";
 $lang['Install_Method']            = "Escoja su m�todo de instalaci�n.";
 $lang['Install_No_Ext']            = "La configuraci�n de su php de su servidor no soporta el tipo de base de datos que escogi�.";
 $lang['Install_No_PCRE']           = "MX-System requiere Perl-Compatible Regular Expressions Module para php la cual la configuraci�n php parece no ser soportada!";
 $lang['Phpbb_path']                = "Phpbb ruta relativa";
 $lang['Phpbb_path_explain']        = "Phpbb ruta relativa, ej /phpbb2/ o ../phpbb2/ <br /> vea que las diagonales '/', son importantes";
 $lang['Phpbb_url']                 = "Completa PHPBB URL";
 $lang['Phpbb_url_explain']         = "Completa PHPBB URL, por ejemplo <br /> http://www.midominio.com/phpbb2/";
 $lang['Portal_url']                = "Completo Portal URL";
 $lang['Portal_url_explain']        = "Completo Portal URL, por ejemplo <br /> http://www.midominio.com/";
 $lang['Portal_intalled']           = "Portal instalado exitosamente :-)";
 $lang['Update_Old_Version']        = "Actualiar de anteriores versiones del portal: ";
 $lang['Re_install_mx']             = "Su instalaci�n previa sigue a�n activa. <br /><br />Si desea re-instalar el MX-Portal deber� presionar el bot�n Yes button degajo. Por favor tenga en cuenta que hacer esto destruira todos los datos - ning�n respaldo ser� hecho! El nombre de usuario y password del administrador username and password que ha utilizado para entrar a la pizarra ser�n re-creados despu�s de la re-instalaci�n, ninguna otra configuraci�n ser� retenida. <br /><br />Anal�celo cuidadosamente antes de proceder!";
 $lang['Inst_Step_0']               = "Gracias por elegir MX-System Portal. Para completar esta instalaci�n por favor llene los detalles de agajo. Tome en cuenta que el PHPBB debe estar actualmente intalado y configurado. El Portal no trabajar� por s� mismo.";
 $lang['Welcome_install']           = "Bienvenido a la Gu�a de Instalaci�n de MX-Portal";
 $lang['Install_Instruction']       = "Gracias por elegir MX-System Portal. Para completar esta instalaci�n por favor llene los detalles de agajo. Tome en cuenta que el PHPBB debe estar actualmente intalado y configurado. El Portal no trabajar� por s� mismo.";
 $lang['Language']                  = "Lenguaje";

//
// New for v. 2.704
//

 $lang['Page_Id']                   = "ID de P�gina";
 $lang['Page_icon']                 = "Icono de P�gina <br /> - para ser usado en la adminCP solamente, ej. icon_home.gif (predeterminado)";
 $lang['Page_header']               = "Archivo de encabezado de p�gina <br /> - ej. overall_header.php (predet.), overall_noheader.php (no encabezado) o archivo de encabezado de usuario.";
 $lang['Auth_Page']                 = "Permisos";

 $lang['Cache_dir_write_protect']   = "Su directorio cache esta protegido contra escritura, no se puede generar el archivo cache";
 $lang['Cache_generate']            = "Su archivo cache esta generado";
 $lang['Cache_submit']              = "generar archivo cache?";
 $lang['Cache_explain']             = "Con esta opci�n puede generar archivos xml (archivos cache) con la configuraci�n del portal. Estos archivos permiten reducir el n�mero de entradas de la base de datos y mejoran el performance del portal. Por el momento esta opci�n no es autom�tica, Sin embargo deberas re-generar el archivo cache despu�s de cada configuraci�n del portal, de otra manera las actualizaciones no estar�n activas.";


//
// New for v. 2.705
//

$lang['install_phpbbdir_notgiven']	= 'Deber� especificar una ruta relativa a tu instalaci�n phpbb existente.';
$lang['install_phpbbdir_missing']	= 'La ruta relativa phpbb no existe.';
$lang['install_pathes_equal']		= 'La ruta phpbb y la ruta MX-System son iguales. Necesitas instalar MX-System en otro directorio diferente a phpbb.';

//
// New for v. 2.706
//

$lang['MX_Portal']	= 'MX-Portal';
$lang['MX_Modules']	= 'MX-Modules';
$lang['Phpbb']		= 'phpBB';

//
// New for v. 2.706
//

$lang['Top_phpbb_links'] = "Mostrar enlaces de encabezado phpbb <br /> - nuevos/temas no le�dos, etc en la P�gina principal del Portal";
$lang['Auth_Page_group'] = "-> Grupo PRIVADO";

// New for v. 2.71
$lang['Error_no_db_install'] = "Error: El archivo db_install.php no existe. Verifique y trate de nuevo...";
$lang['Error_no_db_uninstall'] = "Error: El archivo db_uninstall.php no existe o el desinstalador no es soportado por este m�dulo. Verifique y trate de nuevo...";
$lang['Error_no_db_upgrade'] = "Error: El archivo db_upgrade.php no existe o la actualizaci�n no es soportada por este m�dulo. Verifique y trate de nuevo...";
$lang['Error_module_installed'] = "Error: Este m�dulo ya est� instalado! Por favor primero borre el m�dulo o actualize el m�dulo.";

$lang['Menu_links']                = "Men� URL <br /> - Enlace a una p�gina externa";
$lang['Menu_page']                 = "Men� Page <br /> - Enlace a una p�gina interna del portal";
$lang['Menu_block']                = "Men� Block <br /> - Enlace a un bloque mx especifico";
$lang['Menu_function']             = "Men� Function <br /> - Enlace a una funci�n mx especifica";
$lang['Menu_action_title']         = "<b>Men� action:</b> <br /><i>(Escoja una de estas 4 opciones debajo. Las opciones de abajo ya elegidas ser�n ignoradas)</i> ";
$lang['Menu_action_adv']           = "<b>Advanced actions:</b> <br /><i>(use carefully):</i>";
$lang['Menu_permissions_title']    = "<b>VIEW/EDIT PERMISSIONS:</b>";
$lang['Link_target']                = "Link Target:";
$lang['Portal_version']                = "Mx Portal version:";

$lang['PHPBB_info']                = "PHPBB info";
$lang['PHPBB_version']                = "PHPBB version:";
$lang['PHPBB_script_path']                = "PHPBB script_path:";
$lang['PHPBB_server_name']                = "PHPBB domain (server_name):";


//
// That's all Folks!
// -------------------------------------------------
?>