<?php
/**
*
* @package MX-Publisher Core
* @version $Id: lang_admin.php,v 1.4 2013/06/28 17:08:52 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

/*  Editor Settings: Please set Tabsize to 4 ;-) */ 

/*  The format of this file is:  ---> $lang['message'] = 'text';
/*  Specify your language character encoding... [optional] */  
setlocale(LC_ALL, 'en');

$lang['Mx-Publisher_adminCP'] = 'MX-Publisher Administration';
$lang['Portal_Desc'] = 'A little text to describe your website.';
/*  Left AdminCP Panel */ 
$lang['Admin'] = 'Amministrazione';
$lang['Admin_Index'] = 'Admin index';
$lang['1_General_admin'] = 'General';
$lang['1_1_Management'] = 'Configuration';
$lang['1_2_WordCensors'] = 'Word Censors';

$lang['2_CP'] = 'Management';
$lang['2_1_Modules'] = 'Modules Setup<br /><hr>';
$lang['2_2_ModuleCP'] = 'Module Control Panel';
$lang['2_3_BlockCP'] = 'Block Control Panel';
$lang['2_4_PageCP'] = 'Page Control Panel';

$lang['3_CP'] = 'Styles';
$lang['2_1_new'] = 'Add new';
$lang['2_2_manage'] = 'Manage';
$lang['2_3_smilies'] = 'Smilies';

$lang['4_Panel_system'] = 'System Tools';
$lang['4_1_Cache'] = 'Regenerate Cache';
$lang['4_1_Integrity'] = 'Integrity Checker';
$lang['4_1_Meta'] = 'META Tags';
$lang['4_1_PHPinfo'] = 'phpInfo()';
/*  Index */ 
$lang['Welcome_mxBB'] = 'Welcome to MX-Publisher';
$lang['Admin_intro_mxBB'] = 'Thank you for choosing MX-Publisher as your portal/cms solution and phpBB as your forum solution. This screen will give you a quick overview of all the various statistics of your site. You can get back to this page by clicking on the <span style="text-decoration: underline;">Admin Index</span> link in the left panel. To return to the index of your board, click the logo that is also in the left panel. The other links on the left hand side of this screen will allow you to control every aspect of your portal and forum experience. Each screen will have instructions on how to use the provided tools.';
$lang['Version_information'] = 'Informazione versione';
/*  General */ 
$lang['Yes'] = 'Yes';
$lang['No'] = 'No';
$lang['No_modules'] = 'No modules are installed.';
$lang['No_functions'] = 'This module has no block functions.';
$lang['No_parameters'] = 'This function has no parameters.';
$lang['No_blocks'] = 'No blocks for this function exist.';
$lang['No_pages'] = 'No pages exist here.';
$lang['No_settings'] = 'There are no further settings for this block.';
$lang['Quick_nav'] = 'Quick Navigation';
$lang['Include_all_modules'] = 'List all modules';
$lang['Include_block_quickedit'] = 'Include Block QuickEdit panel';
$lang['Include_block_private'] = 'Include Block Private Auth Panel';
$lang['Include_all_pages'] = 'List all pages';
$lang['View'] = 'View';
$lang['Edit'] = 'Edit';
$lang['Delete'] = 'Delete';
$lang['Settings'] = 'Settings';
$lang['Move_up'] = 'Move up';
$lang['Move_down'] = 'Move down';
$lang['Resync'] = 'Resync';
$lang['Update'] = 'Update';
$lang['Permissions'] = 'Permissions';
$lang['Permissions_std'] = 'Standard Permissions';
$lang['Permissions_adv'] = 'Advanced Permissions';
$lang['return_to_page'] = 'Back to Portal Page';
$lang['Use_default'] = 'Use default setting';
$lang['Server_name'] = 'Nome dominio';
$lang['Server_name_explain'] = 'Il nome del dominio da cui lanci il forum';
$lang['Script_path'] = 'Percorso cartella phpbb';
$lang['Script_path_explain'] = 'Il percorso dove � situato phpbb relativo al nome di dominio';
$lang['Server_port'] = 'Porta del server';
$lang['Server_port_explain'] = 'La porta del tuo server, di solito 80, cambia solo se � diversa';
$lang['Site_name'] = 'Nome del sito';
$lang['Site_desc'] = 'Descrizione del sito';
$lang['AdminCP_status'] = '<b>Progress report</b>';
$lang['AdminCP_action'] = '<b>Database Action</b>';
$lang['Invalid_action'] = 'Error';
$lang['was_installed'] = 'was installed.';
$lang['was_uninstalled'] = 'was uninstalled.';
$lang['was_upgraded'] = 'was upgraded';
$lang['was_exported'] = 'was exported';
$lang['was_deleted'] = 'was deleted';
$lang['was_removed'] = 'was removed';
$lang['was_inserted'] = 'was inserted';
$lang['was_updated'] = 'was updated';
$lang['was_added'] = 'was added';
$lang['was_moved'] = 'was moved';
$lang['was_synced'] = 'was synchronized';

$lang['error_no_field'] = 'There is a missing field. Please fill out all the required fields.';
$lang['Email_settings'] = 'Impostazioni e-mail';
$lang['Admin_email'] = 'Indirizzo e-mail amministratore';
$lang['Email_sig'] = 'Firma e-mail';
$lang['Email_sig_explain'] = 'Questo testo verr� allegato ad ogni e-mail spedita dal forum';
$lang['Use_SMTP'] = 'Usa un Server SMTP per le e-mail';
$lang['Use_SMTP_explain'] = 'Rispondi si se vuoi o devi inviare email attraverso un server specifico invece della funzione mail locale';
$lang['SMTP_server'] = 'Indirizzo server SMTP';
$lang['SMTP_username'] = 'Username SMTP';
$lang['SMTP_username_explain'] = 'Compila il campo username soltanto se il server lo richiede';
$lang['SMTP_password'] = 'Password SMTP';
$lang['SMTP_password_explain'] = 'Compila il campo password soltanto se il server lo richiede';
$lang['Cookie_settings'] = 'Impostazioni cookie'; 
$lang['Cookie_settings_explain'] = 'Questo modulo controlla come vengono definiti i cookie inviati ai browser. In molti casi l\'impostazione di default � sufficiente. Se devi cambiare queste impostazioni fallo con attenzione, le impostazioni non corrette possono impedire agli utenti di entrare.';
$lang['Cookie_domain'] = 'Dominio cookie';
$lang['Cookie_name'] = 'Nome cookie';
$lang['Cookie_path'] = 'Percorso cookie';
$lang['Cookie_secure'] = 'Cookie sicuri';
$lang['Cookie_secure_explain'] = 'Se il server funziona via SSL abilita questo altrimenti lascia disabilitato';
$lang['Session_length'] = 'Lunghezza sessione [ secondi ]';
$lang['Allow_autologin'] = 'Permetti login automatici';
$lang['Allow_autologin_explain'] = 'Determina se viene data la possibilit� di fare il login automaticamente quando visitano il forum';
$lang['Autologin_time'] = 'Login automatico';
$lang['Autologin_time_explain'] = 'Determina la funzione di auto login in giorni, quindi inserisci un numero valido per attivarlo. Lascia 0 se non lo vuoi attivare.';
$lang['Date_format'] = 'Formato data';
$lang['Date_format_explain'] = 'La sintassi utilizzata e\' la funzione <a href=\'http://www.php.net/manual/it/html/function.date.html\' target=\'_other\'>data()</a> del PHP.';
$lang['System_timezone'] = 'Fuso orario del sistema';
$lang['Enable_gzip'] = 'Abilita la compressione GZip';
$lang['Max_login_attempts'] = 'Tentativi di login permessi';
$lang['Max_login_attempts_explain'] = 'Il numero di tentativi di login consentiti.';
$lang['Login_reset_time'] = 'Tempo di blocco login';
$lang['Login_reset_time_explain'] = 'Determina il tempo in minuti che l\'utente deve aspettare prima di fare di nuovo il login dopo avere ecceduto il numero di tentativi di login consentiti.';
$lang['Default_language'] = 'Lingua di default';
/*  Configuration */ 
$lang['Portal_admin'] = 'Portal Administration';
$lang['Portal_admin_explain'] = 'Use this form to customize your portal';
$lang['Portal_General_Config'] = 'Portal Configuration';
$lang['Portal_General_Config_explain'] = 'Use this form to manage the main settings of your MX-Publisher site.';
$lang['Portal_General_settings'] = 'General Settings';
$lang['Portal_Style_settings'] = 'Style Settings';
$lang['Portal_General_config_info'] = 'General Portal Config Info ';
$lang['Portal_General_config_info_explain'] = 'Current setup info from config.php (no editing needed)';
$lang['Portal_Name'] = 'Portal Name:';
$lang['Portal_PHPBB_Url'] = 'URL to your phpBB installation:';
$lang['Portal_Url'] = 'URL to MX-Publisher:';
$lang['Portal_Config_updated'] = 'Portal Configuration Updated Successfully';
$lang['Click_return_portal_config'] = 'Click %sHere%s to return to Portal Configuration';
$lang['PHPBB_info'] = 'phpBB Info';
$lang['PHPBB_version'] = 'phpBB Version:';
$lang['PHPBB_script_path'] = 'phpBB Script Path:';
$lang['PHPBB_server_name'] = 'phpBB Domain (server_name):';
$lang['MX_Portal'] = 'MX-Publisher';
$lang['MX_Modules'] = 'Modules';
$lang['Phpbb'] = 'phpBB';
$lang['Top_phpbb_links'] = 'phpBB Statistics in Header (default value)';
$lang['Top_phpbb_links_explain'] = '- Links to new, unread posts';
$lang['Portal_version'] = 'MX-Publisher Version:';
$lang['Mx_use_cache'] = 'Use MX-Publisher Block Cache';
$lang['Mx_use_cache_explain'] = 'Block data is cached to individual cache/block_*.xml files. Block cache files are created/updated when blocks are edited.';
$lang['Mx_mod_rewrite'] = 'Use mod_rewrite';
$lang['Mx_mod_rewrite_explain'] = 'If you\'re running on an Apache server and have mod_rewrite activated, you may rewrite URLS; for example, you can rewrite pages like \'page=x\' with more intuitive alternatives. Please read further documentation for the mx_mod_rewrite module.';
$lang['Portal_Overall_header'] = 'Overall Header File (default value)';
$lang['Portal_Overall_header_explain'] = '- This is the default template overall_header file, e.g. overall_header.tpl.';
$lang['Portal_Overall_footer'] = 'Overall Footer File (default value)';
$lang['Portal_Overall_footer_explain'] = '- This is the default template overall_footer file, e.g. overall_footer.tpl.';
$lang['Portal_Main_layout'] = 'Main Layout File (default value)';
$lang['Portal_Main_layout_explain'] = '- This is the default template main_layout file, e.g. mx_main_layout.tpl.';
$lang['Portal_Navigation_block'] = 'Overall Navigation Block (default value)';
$lang['Portal_Navigation_block_explain'] = '- This is the page header navigation block, provided you\'ve chosen a overall header file which supports page navigation.';
$lang['Default_style'] = 'Portal Pages Style (default)';
$lang['Default_admin_style'] = 'AdminCP Style';
$lang['Select_page_style'] = "Select (or use default)";
$lang['Override_style'] = 'Override user style';
$lang['Override_style_explain'] = 'Replaces users style with the default (for pages)';
$lang['Portal_status'] = 'Enable portal';
$lang['Portal_status_explain'] = 'Handy switch, when reconstructing the site. Only admin is able to view pages and browse around normally. While disabled, the message below is displayed.';
$lang['Disabled_message'] = 'Portal disabled message';
$lang['Portal_Backend'] = 'MX-Publisher User/Session backend';
$lang['Portal_Backend_explain'] = 'Select internal, phpBB2 or phpBB3 sessions and users';
$lang['Portal_Backend_path'] = 'Relative path to phpBB [non-internal]';
$lang['Portal_Backend_path_explain'] = 'If using non-internal sessions and users, enter the relative path to phpbb, eg \'phpBB2/\' or \'../phpBB2/\'. Note: slashes are important.';
$lang['Portal_Backend_submit'] = 'Change and validate Backend';
$lang['Portal_config_valid'] = 'Current Backend Status: ';
$lang['Portal_config_valid_true'] = '<b><font color="green">Valid</font></b>';
$lang['Portal_config_valid_false'] = '<b><font color="red">Bad Setup. Either your phpBB relative path is wrong or phpBB is uninstalled (your phpBB database is unavailable). Thus, \'internal\' backend is used.</font></b>';
/*  Module Management */ 
$lang['Module_admin'] = 'Module Administration';
$lang['Module_admin_explain'] = 'Use this form to manage modules: installation, upgrading and module development.<br /><b>To use this panel, you need to have JavaScript and cookies enabled in your browser!</b>';
$lang['Modulecp_admin'] = 'Module Control Panel';
$lang['Modulecp_admin_explain'] = 'Use this form to manage modules: block functions (parameters) and portal blocks.<br /><b>To use this panel, you need to have JavaScript and cookies enabled in your browser!</b>';
$lang['Modules'] = 'Modules';
$lang['Module'] = 'Module';
$lang['Module_delete'] = 'Delete a Module';
$lang['Module_delete_explain'] = 'Use this form to delete a module (or block function)';
$lang['Edit_module'] = 'Edit a Module';
$lang['Create_module'] = 'Create a New Module';
$lang['Module_name'] = 'Module Name';
$lang['Module_desc'] = 'Description';
$lang['Module_path'] = 'Path, ex. \'modules/mx_textblocks/\'';
$lang['Module_include_admin'] = 'Include this module in the AdminCP navigation';
/*  Module Installation */ 
$lang['Module_delete_db'] = 'Do you really want to uninstall the module? Warning: You will lose all module data. Consider upgrading instead.';
$lang['Click_module_delete_yes'] = 'Click %sHere%s to uninstall the module';
$lang['Click_module_upgrade_yes'] = 'Click %sHere%s to upgrade the module';
$lang['Click_module_export_yes'] = 'Click %sHere%s to export the module';
$lang['Error_no_db_install'] = 'Error: The file db_install.php does not exist. Please verify this and try again.';
$lang['Error_no_db_uninstall'] = 'Error: The file db_uninstall.php does not exist, or the uninstall feature is not supported for this module. Please verify this and try again.';
$lang['Error_no_db_upgrade'] = 'Error: The file db_upgrade.php does not exist, or the upgrade feature is not supported for this module. Please verify this and try again.';
$lang['Error_module_installed'] = 'Error: This module is already installed! Please either first delete the module, or upgrade the module instead.';
$lang['Uninstall_module'] = 'Uninstall Module';
$lang['import_module_pack'] = 'Install Module';
$lang['import_module_pack_explain'] = 'This will install a module to the portal. Be sure that the module\'s package is uploaded to the /modules/ folder. Remember to use the latest module version!';
$lang['upgrade_module_pack'] = 'Upgrade Module';
$lang['upgrade_module_pack_explain']= 'This will upgrade your module. Be sure to read the module\'s documentation before proceeding, or you risk module data loss.';
$lang['export_module_pack'] = 'Export Module';
$lang['Export_Module'] = 'Select a Module:';
$lang['export_module_pack_explain'] = 'This will export a module *.pak file. This is intended for module writers; regular users don\'t need to worry about this.';
$lang['Module_Config_updated'] = 'Module Configuration Updated Successfully';
$lang['Click_return_module_admin'] = 'Click %sHere%s to return to Module Administration';
$lang['Module_updated'] = 'Module Information Updated successfully';
$lang['list_of_queries'] = 'This is the result list of the SQL queries needed for the install/upgrade';
$lang['already_added'] = 'Error or Already added';
$lang['added_upgraded'] = 'Added/Updated';
$lang['upgrading_modules'] = 'If you get some Errors, Already Added or Updated messages, relax, this is normal when updating mods';
$lang['consider_upgrading'] = 'Module is already installed...consider upgrading ;)';
$lang['upgrading'] = 'Upgrading';
$lang['module_upgrade'] = 'This is a upgrade';
$lang['nothing_upgrade'] = 'Nothing to upgrade...';
$lang['upgraded_to_ver'] = '...Now upgraded to v. ';
$lang['module_not_installed'] = 'Module not installed...and thus cannot be upgraded';
$lang['fresh_install'] = 'This is a fresh install';
$lang['module_install_info'] = 'Mod Installation/Upgrading/Uninstalling Information - mod specific db tables';
/*  Functions & Parameters Administration */ 
$lang['Function_admin'] = 'Block Function Administration';
$lang['Function_admin_explain'] = 'Modules have one or more block bunctions. Use this form to edit, add, or delete a block function';
$lang['Function'] = 'Block Function';
$lang['Function_name'] = 'Block Function Name';
$lang['Function_desc'] = 'Description';
$lang['Function_file'] = 'File ';
$lang['Function_admin_file'] = 'File (Edit block script) <br /> Extra parameters for this edit block panel. Leave blank to use default edit panel.';
$lang['Create_function'] = 'Add New Block Function';
$lang['Delete_function'] = 'Delete Block Function';
$lang['Delete_function_explain'] = 'This will delete the function and all of its associated portal blocks. Beware: this operation cannot be undone!';
$lang['Click_function_delete_yes'] = 'Click %sHere%s to delete the Function';

$lang['Parameter_admin'] = 'Function Parameter Administration';
$lang['Parameter_admin_explain'] = 'List all parameters for this function';
$lang['Parameter'] = 'Parameter';
$lang['Parameter_name'] = '<b>Parameter Name</b><br />- to be used to access the parameter';
$lang['Parameter_type'] = '<b>Parameter Type</b>';
$lang['Parameter_default'] = '<b>Default Value</b>';
$lang['Parameter_function'] = '<b>Function/Options</b>';
$lang['Parameter_function_explain'] = '<b>Function</b> (when using the \'Function\' type)<br />- You may pass the parameter data to an external function <br /> to generate the parameter form field.<br />- For example: <br />get_list_formatted("block_list","{parameter_value}","{parameter_id}[]")';
$lang['Parameter_function_explain'] .= '<br /><br /><b>Option(s)</b> (when using \'Selection\' parameter types)<br />- For all selection parameters (radiobuttons, checkboxes and menus) all options are listed here, one option per line.';
$lang['Parameter_auth'] = '<b>Admin/Block Moderator only</b>';

$lang['Parameters'] = 'Parameters';
$lang['Parameter_id'] = 'ID';
$lang['Create_parameter'] = 'Add New Parameter';
$lang['Delete_parameter'] = 'Delete Function Parameter';
$lang['Delete_parameter_explain'] = 'This will delete the parameter and update all associated portal blocks. Beware: this operation cannot be undone!';
$lang['Click_parameter_delete_yes'] = 'Click %sHere%s to delete the Parameter';
/*  Parameter Types */ 
$lang['ParType_BBText'] = 'Simple BBCode Textblock';
$lang['ParType_BBText_info'] = 'This is a simple textblock that parses BBCode';
$lang['ParType_Html'] = 'Simple HTML Textblock';
$lang['ParType_Html_info'] = 'This is a simple textblock, parsing HTML';
$lang['ParType_Text'] = 'Plain Text (single-row)';
$lang['ParType_Text_info'] = 'This is a simple text field';
$lang['ParType_TextArea'] = 'Plain Text Area (multiple-row)';
$lang['ParType_TextArea_info'] = 'This is a simple textarea field';
$lang['ParType_Boolean'] = 'Boolean';
$lang['ParType_Boolean_info'] = 'This is a \'yes\' or \'no\' radio switch.';
$lang['ParType_Number'] = 'Plain Number';
$lang['ParType_Number_info'] = 'This is a simple number field';
$lang['ParType_Function'] = 'Parameter function';
$lang['ParType_Values'] = 'Values';

$lang['ParType_Radio_single_select'] = 'Single-Selection Radio Buttons';
$lang['ParType_Radio_single_select_info'] = '';
$lang['ParType_Menu_single_select'] = 'Single-Selection Menu';
$lang['ParType_Menu_single_select_info'] = '';
$lang['ParType_Menu_multiple_select'] = 'Multiple-Selection Menu';
$lang['ParType_Menu_multiple_select_info'] = '';
$lang['ParType_Checkbox_multiple_select'] = 'Multiple-Selection Checkbox';
$lang['ParType_Checkbox_multiple_select_info'] = '';

/*  Blocks Administration */ 
$lang['Block_admin'] = 'Block Control Panel';
$lang['Block_admin_explain'] = 'Use this form to manage portal blocks.<br /><b>To use this panel, you need to have JavaScript and cookies enabled in your browser!</b>';
$lang['Block'] = 'Block';
$lang['Show_title'] = 'Show Block Title?';
$lang['Show_title_explain'] = 'Whether or not to display the block title';
$lang['Show_block'] = 'Show Block?';
$lang['Show_block_explain'] = '- If \'no\', the Block is hidden to all users, except administrators';
$lang['Show_stats'] = 'Show Statistics?';
$lang['Show_stats_explain'] = '- If \'yes\', \'edited by...\' will be displayed below the block';
$lang['Show_blocks'] = 'View Function Blocks';
$lang['Block_delete'] = 'Delete a Block';
$lang['Block_delete_explain'] = 'Use this form to delete a Block (or column)';
$lang['Block_title'] = 'Title';
$lang['Block_desc'] = 'Description';
$lang['Add_Block'] = 'Add New Block';
$lang['Auth_Block'] = 'Permissions';
$lang['Auth_Block_explain'] = 'ALL: All users<br />REG: Registered Users<br />PRIVATE: Group members (see advanced permissions)<br />MOD: block moderators (see advanced permissions)<br />ADMIN: Admin<br />ANONYMOUS: Guest users ONLY';
$lang['Block_quick_stats'] = 'Quick Stats';
$lang['Block_quick_edit'] = 'Quick Edit';
$lang['Create_block'] = 'Create New Block';
$lang['Delete_block'] = 'Delete Portal Block';
$lang['Delete_block_explain'] = 'This will delete the block and update all associated Portal Pages. Beware: this operation cannot be undone!';
$lang['Click_block_delete_yes'] = 'Click %sHere%s to delete the Block';

/*  BlockCP Administration */ 
$lang['Block_cp'] = 'BlockCP';
$lang['Click_return_blockCP_admin'] = 'Click %sHere%s to return to the Block Control Panel';
$lang['Click_return_portalpage_admin'] = 'Click %sHere%s to return to the Portal Page';
$lang['BlockCP_Config_updated'] = 'This block has been updated.';

/*  Pages Administration */ 
$lang['Page_admin'] = 'Page Administration';
$lang['Page_admin_explain'] = 'Use this form to add, delete and change the settings for Portal Pages and Page Templates.<br /><b>To use this panel, you need to have JavaScript and cookies enabled in your browser!</b>';
$lang['Page_admin_edit'] = 'Page Edit';
$lang['Page_admin_private'] = 'Advanced Page (PRIVATE) Permissions';
$lang['Page_admin_settings'] = 'Page Settings';
$lang['Page_admin_new_page'] = 'New Page Administration';
$lang['Page'] = 'Page';
$lang['Page_Id'] = 'Page ID';
$lang['Page_icon'] = 'Page Icon <br /> - to be used in the adminCP only, eg. icon_home.gif (default)';
$lang['Page_alt_icon'] = 'Alternative Page Icon <br /> - Full url (http://...) to custom page icon.';
$lang['Default_page_style'] = 'Portal Style (default)<br />To use the default setting, leave this unset.';
$lang['Override_page_style'] = 'Override user style';
$lang['Override_page_style_explain'] = ' ';
$lang['Page_header'] = 'Page header file <br /> - i.e. overall_header.tpl (default), overall_noheader.tpl (no header) or user custom header file.<br />To use the default setting, leave this blank.';
$lang['Page_footer'] = 'Page footer file <br /> - i.e. overall_footer.tpl (default) or user custom footer file.<br />To use the default setting, leave this blank.';
$lang['Page_main_layout'] = 'Page main layout file <br /> - i.e. mx_main_layout.tpl (default) or user custom header file.<br />To use the default setting, leave this blank.';
$lang['Page_Navigation_block'] = 'Page header navigation block';
$lang['Page_Navigation_block_explain'] = '- This is the page header navigation block, provided you\'ve chosen a overall header file which supports page navigation.<br />To use the default setting, leave this unset.';
$lang['Auth_Page'] = 'Permissions';
$lang['Select_sort_method'] = 'Select Sort Method';
$lang['Order'] = 'Order';
$lang['Sort'] = 'Sort';
$lang['Width'] = 'Width';
$lang['Height'] = 'Height';
$lang['Page_sort_title'] = 'Page title';
$lang['Page_sort_desc'] = 'Page description';
$lang['Page_sort_created'] = 'Page created';
$lang['Sort_Ascending'] = 'ASC';
$lang['Sort_Descending'] = 'DESC';
$lang['Return_to_page'] = 'Return to Portal Page';
$lang['Auth_Page_group'] = '-> PRIVATE Group';
$lang['Page_desc'] = 'Description';
$lang['Page_parent'] = 'Parent Page';
$lang['Add_Page'] = 'Add New Page';
$lang['Page_Config_updated'] = 'Page Configuration Updated Successfully';
$lang['Click_return_page_admin'] = 'Click %sHere%s to return to Page Administration';
$lang['Remove_block'] = 'Remove Portal Block';
$lang['Remove_block_explain'] = 'This will remove the block from this page. Beware: this operation cannot be undone!';
$lang['Click_block_remove_yes'] = 'Click %sHere%s to remove the Block';
$lang['Delete_page'] = 'Delete Page';
$lang['Delete_page_explain'] = 'This will delete the Page. Beware: this operation cannot be undone!';
$lang['Click_page_delete_yes'] = 'Click %sHere%s to delete the Page';

$lang['Mx_IP_filter'] = 'IP Filter';
$lang['Mx_IP_filter_explain'] = 'To restrict access to this page by IP, enter the valid IP adresses, with one IP address per line.<br>Example: 127.0.0.1 or 127.1.*.*';
$lang['Mx_phpBB_stats'] = 'phpBB Statistics in Header';
$lang['Mx_phpBB_stats_explain'] = '- Links to new, unread posts, etc.';
$lang['Column_admin'] = 'Page Column Administration';
$lang['Column_admin_explain'] = 'Administrate Page Columns';
$lang['Column'] = 'Page Column';
$lang['Columns'] = 'Page Columns';
$lang['Column_block'] = 'Page Column Block';
$lang['Column_blocks'] = 'Page Column Blocks';
$lang['Edit_Column'] = 'Edit a Column';
$lang['Edit_Column_explain'] = 'Use this form to modify a column';
$lang['Column_Size'] = 'Size of the column';
$lang['Column_name'] = 'Column Name';
$lang['Column_delete'] = 'Delete a Column';
$lang['Page_updated'] = 'Page and Column information updated successfully';
$lang['Create_column'] = 'Add New Column';
$lang['Delete_page_column'] = 'Delete Page Column';
$lang['Delete_page_column_explain'] = 'This will delete the Page Column. Beware: this operation cannot be undone!';
$lang['Click_page_column_delete_yes'] = 'Click %sHere%s to delete the Page Column';

$lang['Add_Split_Block'] 			= 'Add Split Column Block';
$lang['Add_Split_Block_explain'] 	= 'This block splits the column';
$lang['Add_Dynamic_Block'] 			= 'Add Dynamic (Sub) Block';
$lang['Add_Dynamic_Block_explain'] 	= 'This dynamic block defines subpages, set from the navigation menu';
$lang['Add_Virtual_Block'] 			= 'Add Virtual (Page Blog) Block';
$lang['Add_Virtual_Block_explain'] 	= 'This block turns the page into a virtual (blog) page';

/*  Page templates */ 
$lang['Page_templates_admin'] = 'Page Templates Administration';
$lang['Page_templates_admin_explain'] = 'Use this page to create, edit or delete Page Templates';
$lang['Page_template'] = 'Page Template';
$lang['Page_templates'] = 'Page Templates';
$lang['Page_template_column'] = 'Page Template Column';
$lang['Page_template_columns'] = 'Page Template Columns';
$lang['Choose_page_template'] = 'Choose Page Template';
$lang['Template_Config_updated'] = 'Template Configuration Updated';
$lang['Add_Template'] = 'Add New Template';
$lang['Template'] = 'Template';
$lang['Template_name'] = 'Template Name';
$lang['Page_template_delete'] = 'Delete Template';
$lang['Delete_page_template'] = 'Delete Page Template';
$lang['Delete_page_template_explain'] = 'This will delete the Page Template. Beware: this operation cannot be undone!';
$lang['Click_page_template_delete_yes'] = 'Click %sHere%s to delete the Page Template';
$lang['Delete_page_template_column'] = 'Delete Page Template';
$lang['Delete_page_template_column_explain'] = 'This will delete the Page Template. Beware: this operation cannot be undone!';
$lang['Click_page_template_column_delete_yes'] = 'Click %sHere%s to delete the Page Template';

/*  Cache */ 
$lang['Cache_dir_write_protect'] = 'Your cache directory is write-protected. MX-Publisher is unable to generate the cache file. Please make your cache directory writeable to continue.';
$lang['Cache_generate'] = 'Your cache files have been generated.';
$lang['Cache_submit'] = 'Generate the cache file?';
$lang['Cache_explain'] = 'With this option you can generate all cache files (XMLs files) at once for all portal blocks. These files allow the reduction of the number of database queries needed and improves overall portal performance. <br />Note: the MX-Publisher cache must be enabled (in the Portal General Admin CP) for these files to be used by the system.<br>Further note: the cache files are created on the fly when editing blocks as well.';
$lang['Generate_mx_cache'] = 'Generate Block Cache';

/*  These are displayed in the drop down boxes for advanced  mode Module auth, try and keep them short! */ 
$lang['Menu_Navigation'] = 'Navigation Menu';
$lang['Portal_index'] = 'Portal Index';
$lang['Save_Settings'] = 'Save Settings';
$lang['Translation_Tools'] = 'Translation Tools';
$lang['Preview_portal'] = 'Preview Portal';

/*  META */ 
$lang['Meta_admin'] = 'META Tags Administration';
$lang['Mega_admin_explain'] = 'Use this form to customize your META tags';
$lang['Meta_Title'] = 'Title';
$lang['Meta_Author'] = 'Author';
$lang['Meta_Copyright'] = 'Copyright';
$lang['Meta_Keywords'] = 'Keywords';
$lang['Meta_Keywords_explain'] = '(comma seperated list)';
$lang['Meta_Description'] = 'Description';
$lang['Meta_Language'] = 'Language Code';
$lang['Meta_Rating'] = 'Rating';
$lang['Meta_Robots'] = 'Robots';
$lang['Meta_Pragma'] = 'Pragma no-cache';
$lang['Meta_Bookmark_icon'] = 'Bookmark Icon';
$lang['Meta_Bookmark_explain'] = '(relative location)';
$lang['Meta_HTITLE'] = 'Extra Header Settings';
$lang['Meta_data_updated'] = 'Meta data file (mx_meta.inc) has been updated!<br />Click %sHere%s to return to Meta Tags Administration.';
$lang['Meta_data_ioerror'] = 'Unable to open mx_meta.inc. Make sure the file is writeable (chmod 777).';

/*  Portal permissons */ 
$lang['Mx_Block_Auth_Title'] = 'Private Block Permissions' ;
$lang['Mx_Block_Auth_Explain'] = 'Here you can configure Private Block Permissions';
$lang['Mx_Page_Auth_Title'] = 'Private Page Permissions' ;
$lang['Mx_Page_Auth_Explain'] = 'Here you configure Private Page Permissions';
$lang['Block_Auth_successfully'] = 'Block Permissions Updated Successfully';
$lang['Click_return_block_auth'] = 'Click %sHere%s to return to Private Block Permissions';
$lang['Page_Auth_successfully'] = 'Page Permissions Updated Successfully';
$lang['Click_return_page_auth'] = 'Click %sHere%s to return to Private Page Permissions';
$lang['AUTH_ALL'] = 'ALL';
$lang['AUTH_REG'] = 'REG';
$lang['AUTH_PRIVATE'] = 'PRIVATE';
$lang['AUTH_MOD'] = 'MOD';
$lang['AUTH_ADMIN'] = 'ADMIN';
$lang['AUTH_ANONYMOUS'] = 'ANONYMOUS';

/* -----------------------------------
 BlockCP - Block Parameter Specific 
 ----------------------------------- */
 
/*  General */ 
$lang['target_block'] = 'Target Block';
$lang['target_block_explain'] = '- links, data etc are refering with this block';

/*  Split column */ 
$lang['block_ids'] = 'Source Blocks';
$lang['block_ids_explain'] = '- to be placed left to right';
$lang['block_sizes'] = 'Block Sizes (comma separated)';
$lang['block_sizes_explain'] = '- You may specify size using numbers (pixels), percentages (relative sizes, ie. \'40%\') or \'*\' for the remainder.';
$lang['space_between'] = 'Space between Blocks';

/*  Sitelog */ 
$lang['log_filter_date'] = 'Filter by time';
$lang['log_filter_date_explain'] = '- Show logs from last week, month, year...';
$lang['numOfEvents'] = 'Number';
$lang['numOfEvents_explain'] = '- Number of events to show';

/*  IncludeX */ 
$lang['x_listen'] = 'Listen (GET)';
$lang['x_iframe'] = 'IFrame';
$lang['x_textfile'] = 'Textfile';
$lang['x_multimedia'] = 'WMP Multimedia';
$lang['x_pic'] = 'Pic';
$lang['x_format'] = 'Formatted Textfile';
$lang['x_mode'] = 'IncludeX mode:';
$lang['x_mode_explain'] = '- The IncludeX block operates in one of the following modes. If mode \'Listen (GET)\' is selected, the mode may be set by a url \'x_mode=mode\' and associated parameters with \'x_1=, x_2=, etc\'.<br />Example: To pass a url to a iframe use \'domain/index.php?page=x&x_mode=iframe&x_1=http://domain\' ';
$lang['x_1'] = 'Variable 1:';
$lang['x_1_explain'] = '- <i>IFrame:</i> url<br /><i>Textfile:</i> relative path from root (eg in \'/include_file/my_file.xxx\')<br /><i>Multimedia:</i> relative path from root (eg in \'/include_file/my_file.xxx\')<br /><i>Pic:</i> relative path from root (eg in \'/include_file/my_file.xxx\')<br /><i>Formatted textfile:</i> not available';
$lang['x_2'] = 'Variable 2:';
$lang['x_2_explain'] = '- <i>IFrame:</i> frame height (pixels)<br /><i>Multimedia:</i> width (pixles)';
$lang['x_3'] = 'Variable 3:';
$lang['x_3_explain'] = '- <i>Multimedia:</i> height (pixles)';

/*  Dynamic Block */ 
$lang['default_block_id'] = 'Default Block';
$lang['default_block_id_explain'] = '- This is the default or first block to display, unless a dynamic block is set';

/*  Menu Navigation */ 
$lang['menu_display_mode'] = 'Layout mode';
$lang['menu_display_mode_explain '] = 'Horizonal or Vertical layout mode';
$lang['menu_custom_tpl']				= "Custom template file";
$lang['menu_custom_tpl_explain ']		= "Eg mx_menu_custom.tpl";
$lang['menu_page_parent']				= "Parent Page";
$lang['menu_page_parent_explain ']		= "Navigation from this parent page";

/*  Version Checker */ 
$lang['MXP_Version_up_to_date'] = 'Your MX-Publisher installation is up to date. No updates are available for your version of MX-Publisher.';
$lang['MXP_Version_outdated'] = 'Your MX-Publisher installation does <b>not</b> seem to be up to date. Updates are available for your version of MX-Publisher. Please visit <a href="http://mxpcms.sourceforge.net/download" target="_new">the MX-Publisher Core package download</a> to obtain the latest version.';
$lang['MXP_Latest_version_info'] = 'The latest available version is <b>MX-Publisher %s</b>. ';
$lang['MXP_Current_version_info'] = 'You are running <b>MX-Publisher %s</b>.';
$lang['MXP_Mailing_list_subscribe_reminder'] = 'For the latest information on news and updates to MX-Publisher, why not <a href="http://lists.sourceforge.net/lists/listinfo/mxpcms-news" target="_new">subscribe to our mailing list</a>?';
/* lang_admin_gd_info.php - BEGIN */
$lang['GD_Title'] = 'GD Info';
$lang['NO_GD'] = 'No GD';
$lang['GD_Description'] = 'Retrieve information about the currently installed GD library';
$lang['GD_Freetype_Support'] = 'Freetype Fonts Support:';
$lang['GD_Freetype_Linkage'] = 'Freetype Link Type:';
$lang['GD_T1lib_Support'] = 'T1lib Support:';
$lang['GD_Gif_Read_Support'] = 'Gif Read Support:';
$lang['GD_Gif_Create_Support'] = 'Gif Create Support:';
$lang['GD_Jpg_Support'] = 'Jpg/Jpeg Support:';
$lang['GD_Png_Support'] = 'Png Support:';
$lang['GD_Wbmp_Support'] = 'WBMP Support:';
$lang['GD_XBM_Support'] = 'XBM Support:';
$lang['GD_WebP_Support'] = 'WebP Support:';
$lang['GD_Jis_Mapped_Support'] = 'Japanese Font Support:';
$lang['GD_True'] = 'Yes';
$lang['GD_False'] = 'No';
$lang['GD_VERSION'] = 'GD Version:';
$lang['GD_0'] = 'No GD';
$lang['GD_1'] = 'GD1';
$lang['GD_2'] = 'GD2';
$lang['GD_show_img_no_gd'] = 'Show GIF thumbnails without using GD libraries (full images are loaded and then just shown resized).';
/* lang_admin_gd_info.php - END */
/*
* That's all Folks!
* -------------------------------------------------*/
?>