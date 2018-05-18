<?php
/***************************************************************************
 *                            lang_main.php [German]
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

//setlocale(LC_ALL, "de_DE");

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!

$lang['Portal_ALL']                = "Alle";
$lang['Portal_REG']                = "Reg";
$lang['Portal_PRIVATE']            = "Privat";
$lang['Portal_MOD']                = "Mods";
$lang['Portal_ADMIN']              = "Admin";

// Configuration
//
$lang['Portal_admin']              = "Portal Administration";
$lang['Portal_admin_explain']      = "Hier kannst Du Kategorien und Portal hinzufügen, löschen, bearbeiten und neu anordnen.";


$lang['Portal_General_Config']     = "Portal konfiguration";
$lang['Portal_Config_explain']     = "Hier kannst Du die allgemeinen Einstellungen Deines Portal ändern.";
$lang['Portal_General_settings']   = "Allgemeine Konfiguration";
$lang['Portal_Name']               = "Name der Portal:";   
$lang['Portal_PHPBB_Url']          = "URL Adress for the PHPBB Module :";

$lang['Portal_Config_updated']     = "Portal konfiguration geändert";
$lang['Click_return_portal_config']= "Klick %shier%s, um zur Portal administration zurück zu kehren";


//
// Menu Management
//

$lang['Menu_admin']                = "Menü Administration";
$lang['Menu_admin_explain']        = "Hier kannst Du Kategorien und Menü hinzufügen, löschen, bearbeiten und neu anordnen.";

$lang['Menu_edit_delete_explain']  = "Hier kannst Du die Daten und spezielle Optionen eines Menü ändern.";
$lang['Menu_settings']             = "Menü Boardeinstellungen";

$lang['Menu_delete']               = "Menü löschen";
$lang['Menu_delete_explain']       = "Hier kannst ein Menü oder eine Kategorie löschen und entscheiden";


$lang['Edit_menu']                 = "Menü bearbeiten";
$lang['Update']                    = "Aktualisieren";
$lang['Create_menu']               = "Neues Menü erstellen";
$lang['Create_category']           = "Neue Kategorie erstellen";
$lang['Menu_Config_updated']       = "Menü konfiguration geändert";
$lang['Menus_updated']             = "Menü und Kategorie konfiguration geändert";
$lang['Click_return_menuadmin']    = "Klick %shier%s, um zur Menü administration zurück zu kehren";
$lang['Menu_name']                 = "Name der Menü";
$lang['Menu_desc']                 = "Description ";
$lang['Menu_links']                = 'Web Link ';
$lang['Category']                  = "Kategorie ";

$lang['Edit']                      = "Editieren";
$lang['Delete']                    = "Löschen";
$lang['Move_up']                   = "Nach oben";
$lang['Move_down']                 = "Nach unten";
$lang['Resync']                    = "Resync";

$lang['Click_return_admin_index']  = "Klicke %shier%s, um zum Admin Index zurück zu kehren";

//
// Module Management
//

$lang['Modules']                   = "Modules";

$lang['Module_admin']              = "Module Administration";
$lang['Module_Config_explain']     = "Hier kannst Du die Daten und spezielle Optionen eines Module ändern.";

$lang['Column_delete']             = "Spalte löschen";

$lang['Module_delete']             = "Module löschen";
$lang['Module_delete_explain']     = "Hier kannst Du Spalte und Module löschen";


$lang['Edit_module']               = "Module bearbeiten";
$lang['Create_module']             = "Neues Module erstellen";
$lang['Module_Config_updated']     = "Module konfiguration geändert";
$lang['Module_updated']            = "Module und Spalte konfiguration geändert";
$lang['Click_return_moduleadmin']  = "Klick %shier%s, um zur Module administration zurück zu kehren";

$lang['Column_name']              = "Name die Spalte";

$lang['Module_name']              = "Name der Module";
$lang['Module_desc']              = "Description";
$lang['Module_var_text']          = "Text für die variable Block";
$lang['Module_path']              = "Path";
$lang['Module_file']              = "Dateiname";
$lang['Module_display']           = "Module anzeigen";
$lang['Create_column']            = "Neues Spalte erstellen";

$lang['Column']                   = "Spalte";

$lang['Edit_Column']              = "Spalte bearbeiten";
$lang['Edit_Column_explain']      = "Hier kannst Du die Daten und spezielle Optionen eines Spalte ändern.";

// delete size_column
$lang['Column_Size']              = "Größe der Spalte";

// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!
                                  
$lang['Module_ALL']                = "Alle";
$lang['Module_REG']                = "Reg";
$lang['Module_PRIVATE']            = "Privat";
$lang['Module_MOD']                = "Mods";
$lang['Module_ADMIN']              = "Admin";

$lang['Auth_Module']               = "Erlaubnis" ;


$lang['Menu Navigation']           = "Menü-Navigation";
$lang['Modules']                   = "Module";
$lang['Poll Administration']       = "Umfrage Administration";

$lang['Portal_index']              = "Portal Index";

$lang['Module Last Message']      = "Module Last Message Administration"; 
$lang['Module News']              = "Module News Administration"; 
$lang['Module Weather']           = "Module Weather Administration";  

$lang['Poll_Settings']            = "Konfiguration für Module - Poll:";
$lang['Poll_Display']             = "elchen Poll möchtest Du darstellen?";

$lang['Welcome_install']          = "Welcome to MX-Portal Installation";
$lang['Install_Instruction']      = "Thank you for choosing MX-System. In order to complete this install please fill out the details requested below. Please note PHPBB must already be to install and configure to install MX-portal";
$lang['Language']                 = "Language";
$lang['Initial_config']           = "Basic Configuration";
$lang['Install_lang']             = 'Choose Language for Installation';
$lang['Table_Prefix']             = 'Prefix for tables in database';
$lang['Installer_Error']          = 'An error has occurred during installation';
$lang['Install_db_error']         = 'An error occurred trying to update the database';
$lang['Phpbb_path']               = 'Phpbb path';
$lang['Phpbb_path_explain']       = 'The path where phpBB2 is installed';
$lang['Phpbb_url']                = 'Phpbb url';
$lang['Phpbb_url_explain']        = 'Adresse Web where phpBB2 is installed ( this url is use for the images in the portal';

$lang['Install']                  = 'Install';

$lang['Portal_intalled']         = "Portal installed Successfully";

$lang['Update_Old_Version']       = "Update old portal version : "; 
//
// That's all Folks!
// -------------------------------------------------

?>