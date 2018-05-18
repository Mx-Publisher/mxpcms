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

 $lang['Portal_admin']              = "Administración del Portal";
 $lang['Portal_admin_explain']      = "Use esta forma para  modificar tu portal";
 $lang['Portal_General_Config']     = "Configuración del Portal";
 $lang['Portal_General_settings']   = "Configuraciones Generales";
 $lang['Portal_General_config_info'] = "Información General de la Configuración del Portal";
 $lang['Portal_General_config_info_explain'] = "Información generada de la instalación del archivo config.php (no editar)";
 $lang['Portal_Name']               = "Nombre del Portal:";
 $lang['Portal_PHPBB_Url']          = "URL a la instalación del PHPBB:";
 $lang['Portal_Url']                = "URL al Mx Portal:";
 $lang['Portal_Config_updated']     = "Configuración del Portal Actualizada Exitósamente";
 $lang['Click_return_portal_config'] = "Presiona %sHere%s para regresar a la Configuración del Portal";

 //
// Menu Management
//

 $lang['Menu_admin']                = "Administración del Menú";
 $lang['Menu_admin_explain']        = "Usa esta forma para modificar tu menú";
 $lang['Menu_edit_delete_explain']  = "Usa esta forma para modificar tu menú";
 $lang['Menu_settings']             = "Información del Menú";
 $lang['Menu_delete']               = "Borrar un Menú";
 $lang['Menu_delete_explain']       = "Usa esta forma para borrar (y/o mover) una categoría y sus subelemento(s)";
 $lang['Edit_Menu']                 = "Editar un Menú";
 $lang['Update']                    = "Actualizar";
 $lang['Create_Menu']               = "Agregar nuevo Menú";
 $lang['Create_category']           = "Agregar nueva categoria";
 $lang['Menu_Config_updated']       = "Configuración del Menú Actualizada exitósamente";
 $lang['Menus_updated']             = "Información del Menú y Categoria Actualizada exitósamente";
 $lang['Click_return_Menuadmin']    = "Presiona %sHere%s para regresar a la Administración del Menú";
 $lang['Menu_name']                 = "Nombre del Menú";
 $lang['Menu_icon']                 = "Icono del Menú";
 $lang['Menu_desc']                 = "Descripción ";
 $lang['Edit']                      = "Editar";
 $lang['Delete']                    = "Borrar";
 $lang['Move_up']                   = "Mover hacia arriba";
 $lang['Move_down']                 = "Mover hacia abajo";
 $lang['Resync']                    = "Resincronizar";
 $lang['Click_return_admin_index']  = "Presiona %sHere%s para regresar a la Administración del Indice";

//
// Module Management
//

 $lang['Module']                    = "Módulo";
 $lang['Module_admin']              = "Administración de Módulo";
 $lang['Module_admin_explain']      = "Usa esta forma para modificar los módulos";
 $lang['Column_delete']             = "Borrar una Columna";
 $lang['Module_delete']             = "Borrar un Modulo";
 $lang['Module_delete_explain']     = "Usa esta forma para borrar un Módulo (o función)";
 $lang['Edit_module']               = "Editar un Módulo";
 $lang['Create_module']             = "Agregar un Módulo";
 $lang['Module_Config_updated']     = "Configuración del Módulo Actualizado exitósamente";
 $lang['Module_updated']            = "Información del Módulo Actualizado exitósamente";
 $lang['Click_return_module_admin'] = "Presiona %sHere%s para regresar a la Administración del Módulo";
 $lang['Column_name']               = "Nombre de Columna";
 $lang['Module_name']               = "Nombre de Módulo";
 $lang['Module_desc']               = "Descripción";
 $lang['Module_path']               = "Path";
 $lang['Create_column']             = "Agregar nueva columna";
 $lang['Column']                    = "Columna";
 $lang['Edit_Column']               = "Editar una Columna";
 $lang['Edit_Column_explain']       = "Usa esta forma para modificar una columna";
 $lang['Column_Size']               = "Tamaño de la columna";

//
// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!
//

 $lang['Menu_Navigation']           = "Menú de Navegación";
 $lang['Modules']                   = "Módulos";
 $lang['Portal_index']              = "Indice del Portal";
 $lang['Poll_Display']              = "Cual Poll quieres visualizar?";
 $lang['Meta_admin']                = "Administración de Meta Tags";
 $lang['Mega_admin_explain']        = "Usa esta forma para modificar tus Meta tags";
 $lang['Meta_Title']                = "Título";
 $lang['Meta_Author']               = "Autor";
 $lang['Meta_Copyright']            = "Copyright";
 $lang['Meta_Keywords']             = "Palabras clave";
 $lang['Meta_Keywords_explain']     = "(lista separada por comas)";
 $lang['Meta_Description']          = "Descripción";
 $lang['Meta_Language']             = "Código del lenguaje";
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
 $lang['Block_title']               = "Título";
 $lang['Block_desc']                = "Descripción";
 $lang['Add_Block']                 = "Agregar Bloque";
 $lang['Auth_Block']                = "Permisos";
 $lang['AUTH_ALL']                  = "TODOS";
 $lang['AUTH_REG']                  = "REG";
 $lang['AUTH_PRIVATE']              = "PRIVADOS";
 $lang['AUTH_MOD']                  = "MOD";
 $lang['AUTH_ADMIN']                = "ADMIN";
 $lang['AUTH_ANONYMOUS']            = "ANONIMOS";
 $lang['Function']                  = "Funcción";
 $lang['Settings']                  = "Configuraciones";
 $lang['Save_Settings']             = "Guardar Configuraciones";
 $lang['announce_nbr_display']      = "Número de mensajes a mostrar (max)";
 $lang['announce_nbr_days']         = "Número de Días para mostrar los Mensajes";
 $lang['announce_img']              = "Imágen de Anuncios";
 $lang['announce_img_sticky']       = "Imágen de Post it";
 $lang['announce_img_normal']       = "Imágen de Mensaje Normal";
 $lang['announce_img_global']       = "Imágen de Anuncio Global";
 $lang['announce_display']          = "Muestra en este Módulo el Anuncio ";
 $lang['announce_display_sticky']   = "Muestra en este Módulo el Post it ";
 $lang['announce_display_normal']   = "Muestra en este Módulo el mensaje ";
 $lang['announce_display_global']   = "Muestra en este Módulo el anuncio global  ";
 $lang['announce_forum']            = "Fuente de los Foros<br /> Podrías hacer múltiples selecciones<br />* Si ninguno es seleccionado, todos los foros autorizados serán visibles";
 $lang['poll_forum']                = "Fuente de los Foros<br /> Podrías hacer múltiples selecciones<br />* Si ninguno es seleccionado, todos los foros autorizados serán visibles";
 $lang['Function_admin']            = "Administración de Funciones";
 $lang['Function_admin_explain']    = "Cada módulo tiene una o más funciones. Usa esta forma para editar, agregar, o borrar una función";
 $lang['Function_name']             = "Nombre de Función";
 $lang['Function_desc']             = "Descripción";
 $lang['Function_file']             = "Archivo ( Script ) ";
 $lang['Create_function']           = "Agregar nueva Función";
 $lang['Parameter_name']            = "Nombre ";
 $lang['Parameter_desc']            = "Descripción";
 $lang['Parameter_type']            = "Tipo";
 $lang['Parameter_default']         = "Valor por Default";
 $lang['import_module_pack']        = "Instalar un Módulo";
 $lang['import_module_pack_explain']        = "Esto agregará un módulo al portal. Asegurese que el paquete del módulo este cargado a la carpeta /modules... y use la versión más actual de módulos!";
 $lang['upgrade_module_pack']       = "Actualizar Módulos";
 $lang['upgrade_module_pack_explain']       = "Esto actualizará tus módulos. Asegurese leer el documento module antes de proceder, o podría correr el riesgo de perder datos del módulo.";
 $lang['export_module_pack']        = "Exportar Módulo";
 $lang['Export_Module']             = "Seleccionar un módulo:";
 $lang['export_module_pack_explain']             = "Esto exportará un módulo de archivo *.pak. Sólamente recomendado para escritores de módulos...";
 $lang['Not_Specified']             = "No Especificado";
 $lang['Page']                      = "Página";
 $lang['Add_Page']                  = "Agregar nueva página";
 $lang['Block_admin']               = "Administración de Bloques";
 $lang['Block_admin_explain']       = "Use esta forma para agregar, borrar y cambiar la configuración de cada bloque.";
 $lang['Module_include_admin']      = "Incluir este módulo en Administrador del Menu de Navegación";
 $lang['Translation_Tools']         = "Herramientas de Traducción";
 $lang['Create_parameter']          = "Agregar nuevo Parámetro";
 $lang['Parameter_admin']           = "Administración de Parámetros";
 $lang['Parameter_admin_explain']   = "Listar todos los parámetros para esta función";
 $lang['Parameter_id']              = "Id";
 $lang['Parameter_function']        = "Función";
 $lang['Preview_portal']            = "Preliminar del  Portal";
 $lang['Page_admin']                = "Página de Administración";
 $lang['Page_Config_updated']       = "Configuración de Pagina Actulizada Exitosamente";
 $lang['Page_updated']              = "Información de Página y Columna actualizadas exitosamente";
 $lang['Click_return_page_admin']   = "Presiona %sHere%s para regresar a la Página de Administración";

 $lang['Module_delete_db']   = "Ahora este módulo esta borrado del portal, pero las tablas de la base de datos de este modulo siguen vigentes. Quiere eliminar definitivamente cualquier tabla relacionada del módulo. Advertencia: Eliminará todos los datos. Esto no deberá hacerse si planea actualizar o reinstalar el módulo.";
 $lang['Click_module_delete_db_yes']   = "Presiona %sHere%s para eliminar todas las tablas de la base de datos permanentemente";


//
// Install Process
//

 $lang['Initial_config']            = "Configuración Básica";
 $lang['DB_config']                 = "Configuración Base de Datos";
 $lang['Admin_config']              = "Configuración del Administrador";
 $lang['continue_upgrade']          = "Una vez que ha bajado el archivo config a su computadora usted podría presionar el botón 'Continue Upgrade' debajo para continuar con el proceso de actualización.  Por favor espere hasta que el archivo config termine el proceso de actualización.";
 $lang['upgrade_submit']            = "Continuar Actualización";
 $lang['Installer_Error']           = "Un error ocurrió durante la intalacion";
 $lang['Previous_Install']          = "Una instalación anterior ha sido detectada";
 $lang['Install_db_error']          = "Un error ocurrio al tratar de acrualizar la base de datos";
 $lang['Re_install']                = "Su instalación previa sigue aún activa. <br /><br />Si desea reinstalar MX-Portal debe presionar el botón Yes debajo. Por favor tenga en cuenta que al hacerlo destruirá todos los datos existentes, ningún respaldo será hecho! El nombre de usuario y password del administrador username and password que ha utilizado para entrar a la pizarra serán re-creados después de la re-instalación, ninguna otra configuración será retenida. <br /><br />Analícelo cuidadosamente antes de proceder!";
 $lang['Start_Install']             = "Comienze Instalación de MX";
 $lang['Finish_Install']            = "Omitir Instalación de MX";
 $lang['Default_lang']              = "Lenguaje predeterminado de la pizarra";
 $lang['DB_Host']                   = "Base de Datos del Sevidor Hostname/DSN";
 $lang['DB_Name']                   = "Nombre de la Base de Datos";
 $lang['DB_Username']               = "Usuario de Base de Datos";
 $lang['DB_Password']               = "Password de Base de Datos";
 $lang['Database']                  = "Su Base de Datos";
 $lang['Install_lang']              = "Escoja lenguaje de la Instalación";
 $lang['dbms']                      = "Tipo de Base de Datos";
 $lang['Table_Prefix']              = "Prefijo de PhpBB en Base de Datos";
 $lang['MX_Table_Prefix']           = "Prefijo de MX-Portal en Base de Datos";
 $lang['Admin_Username']            = "Nombre de Usuario de Administrador en el Portal";
 $lang['Admin_Password']            = "Password de Administrador en el Portal";
 $lang['Admin_Password_confirm']    = "Password de Administrador en el Porta [Confirmar]";
 $lang['Inst_Step_2']               = "En este punto la instalación básica esta completa. Ahora será llevado a una pantalla que le perimitirá  administrar su nueva instalación. Asegurese por favor de checar las configuraciones del Portal y haga los cambios requeridos. Gracias por elegir MX-Portal.";
 $lang['Unwriteable_config']        = "Su archivo config (config.php) esta como no-escitura en este momento.<br />Una copia del archivo config será bajada cuando presiones el botón de abajo. <br />Deberá subir este archivo en el mismo directorio raíz del MX.<br />Una vez relizado esto agregue las tablas manualmente en la base de datos usando el  mx_db_install.php script. Necesitará agregar las rutas correctas en la tabla table mx_portal de la base de datos usando la herramienta de su preferencia para base de datos. <br />Después, ingrese usando su nombre y password de administrador para entrar a su Portal/foro.<br /> Gracias por elegir MX Portal.";
 $lang['Download_config']           = "Bajar Config";
 $lang['ftp_choose']                = "Escoja método para bajar";
 $lang['ftp_option']                = "<br />Desde que las extensiones FTP estan habilitadas en ests versión de PHP deberán ser escogidas las opciones de tratar automaticamente el ftp para que sea instalado el archivo config en su lugar.";
 $lang['ftp_instructs']             = "Ha escogido que ftp instale el archivo de la cuenta que contiene MX-Portal automaticamente. Por favor ingrese la informacion abajo para facilitar este proceso. Note que la ruta FTP deberá ser la ruta exacta via ftp para su instalación de phpBB2 como si lo estuviera haciendo de un cliente ftp.";
 $lang['ftp_info']                  = "Ingrese su información FTP";
 $lang['Attempt_ftp']               = "Tratando de hacer ftp el archivo config en su lugar";
 $lang['Send_file']                 = "Sólamente envieme el archivo a mí y lo haré manualmente con mi ftp";
 $lang['ftp_path']                  = "Ruta FTP a MX-Portal";
 $lang['ftp_username']              = "Su Nombre de usuario FTP";
 $lang['ftp_password']              = "Su Password FTP";
 $lang['Transfer_config']           = "Comenzar tranferencia";
 $lang['NoFTP_config']              = "El intento de el archivo config en ftp de instalarlo en su lugar ha fallado.  Por favor baje el archivo config y hagalo manualmente con su FTP.";
 $lang['Install']                   = "Instalar";
 $lang['Upgrade']                   = "Actualizar";
 $lang['Install_Method']            = "Escoja su método de instalación.";
 $lang['Install_No_Ext']            = "La configuración de su php de su servidor no soporta el tipo de base de datos que escogió.";
 $lang['Install_No_PCRE']           = "MX-System requiere Perl-Compatible Regular Expressions Module para php la cual la configuración php parece no ser soportada!";
 $lang['Phpbb_path']                = "Phpbb ruta relativa";
 $lang['Phpbb_path_explain']        = "Phpbb ruta relativa, ej /phpbb2/ o ../phpbb2/ <br /> vea que las diagonales '/', son importantes";
 $lang['Phpbb_url']                 = "Completa PHPBB URL";
 $lang['Phpbb_url_explain']         = "Completa PHPBB URL, por ejemplo <br /> http://www.midominio.com/phpbb2/";
 $lang['Portal_url']                = "Completo Portal URL";
 $lang['Portal_url_explain']        = "Completo Portal URL, por ejemplo <br /> http://www.midominio.com/";
 $lang['Portal_intalled']           = "Portal instalado exitosamente :-)";
 $lang['Update_Old_Version']        = "Actualiar de anteriores versiones del portal: ";
 $lang['Re_install_mx']             = "Su instalación previa sigue aún activa. <br /><br />Si desea re-instalar el MX-Portal deberá presionar el botón Yes button degajo. Por favor tenga en cuenta que hacer esto destruira todos los datos - ningún respaldo será hecho! El nombre de usuario y password del administrador username and password que ha utilizado para entrar a la pizarra serán re-creados después de la re-instalación, ninguna otra configuración será retenida. <br /><br />Analícelo cuidadosamente antes de proceder!";
 $lang['Inst_Step_0']               = "Gracias por elegir MX-System Portal. Para completar esta instalación por favor llene los detalles de agajo. Tome en cuenta que el PHPBB debe estar actualmente intalado y configurado. El Portal no trabajará por sí mismo.";
 $lang['Welcome_install']           = "Bienvenido a la Guía de Instalación de MX-Portal";
 $lang['Install_Instruction']       = "Gracias por elegir MX-System Portal. Para completar esta instalación por favor llene los detalles de agajo. Tome en cuenta que el PHPBB debe estar actualmente intalado y configurado. El Portal no trabajará por sí mismo.";
 $lang['Language']                  = "Lenguaje";

//
// New for v. 2.704
//

 $lang['Page_Id']                   = "ID de Página";
 $lang['Page_icon']                 = "Icono de Página <br /> - para ser usado en la adminCP solamente, ej. icon_home.gif (predeterminado)";
 $lang['Page_header']               = "Archivo de encabezado de página <br /> - ej. overall_header.php (predet.), overall_noheader.php (no encabezado) o archivo de encabezado de usuario.";
 $lang['Auth_Page']                 = "Permisos";

 $lang['Cache_dir_write_protect']   = "Su directorio cache esta protegido contra escritura, no se puede generar el archivo cache";
 $lang['Cache_generate']            = "Su archivo cache esta generado";
 $lang['Cache_submit']              = "generar archivo cache?";
 $lang['Cache_explain']             = "Con esta opción puede generar archivos xml (archivos cache) con la configuración del portal. Estos archivos permiten reducir el número de entradas de la base de datos y mejoran el performance del portal. Por el momento esta opción no es automática, Sin embargo deberas re-generar el archivo cache después de cada configuración del portal, de otra manera las actualizaciones no estarán activas.";


//
// New for v. 2.705
//

$lang['install_phpbbdir_notgiven']	= 'Deberá especificar una ruta relativa a tu instalación phpbb existente.';
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

$lang['Top_phpbb_links'] = "Mostrar enlaces de encabezado phpbb <br /> - nuevos/temas no leídos, etc en la Página principal del Portal";
$lang['Auth_Page_group'] = "-> Grupo PRIVADO";

// New for v. 2.71
$lang['Error_no_db_install'] = "Error: El archivo db_install.php no existe. Verifique y trate de nuevo...";
$lang['Error_no_db_uninstall'] = "Error: El archivo db_uninstall.php no existe o el desinstalador no es soportado por este módulo. Verifique y trate de nuevo...";
$lang['Error_no_db_upgrade'] = "Error: El archivo db_upgrade.php no existe o la actualización no es soportada por este módulo. Verifique y trate de nuevo...";
$lang['Error_module_installed'] = "Error: Este módulo ya está instalado! Por favor primero borre el módulo o actualize el módulo.";

$lang['Menu_links']                = "Menú URL <br /> - Enlace a una página externa";
$lang['Menu_page']                 = "Menú Page <br /> - Enlace a una página interna del portal";
$lang['Menu_block']                = "Menú Block <br /> - Enlace a un bloque mx especifico";
$lang['Menu_function']             = "Menú Function <br /> - Enlace a una función mx especifica";
$lang['Menu_action_title']         = "<b>Menú action:</b> <br /><i>(Escoja una de estas 4 opciones debajo. Las opciones de abajo ya elegidas serán ignoradas)</i> ";
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