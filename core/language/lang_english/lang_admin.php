<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: lang_admin.php,v 1.2 2010/10/14 01:52:52 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

//
// Editor Settings: Please set Tabsize to 4 ;-)
//

//
// The format of this file is:
//
// ---> $lang["message"] = "text";
//
// Specify your language character encoding... [optional]
//
// setlocale(LC_ALL, "en");

$lang['mxBB_adminCP']				= "mxBB-Portal Administration";	

//
// Left AdminCP Panel
//
$lang['1_General_admin']			= "General";
$lang['1_1_Management']				= "Configuration";

$lang['2_CP']						= "Management";
$lang['2_1_Modules']				= "Modules Setup<br /><hr>";
$lang['2_2_ModuleCP']				= "Module Control Panel";
$lang['2_3_BlockCP']				= "Block Control Panel";
$lang['2_4_PageCP']					= "Page Control Panel";

$lang['4_Panel_system']				= "System Tools";
$lang['4_1_Cache']					= "Regenerate Cache";
$lang['4_1_Integrity']				= "Integrity Checker";
$lang['4_1_Meta']					= "META tags";
$lang['4_1_PHPinfo']				= "phpInfo()";

//
// General
//
$lang['Yes']						= "Yes";
$lang['No']							= "No";
$lang['No_modules']					= "No Modules installed";
$lang['No_functions']				= "This module has no block functions";
$lang['No_parameters']				= "This function has no parameters";
$lang['No_blocks']					= "No blocks for this function have been created";
$lang['No_pages']					= "No pages created";
$lang['No_settings']				= "No further settings for this block";
$lang['Quick_nav']					= "Quick Navigation";
$lang['Include_all_modules']		= "List all modules";
$lang['Include_block_quickedit']	= "Include Block Quickedit panel";
$lang['Include_block_private']		= "Include Block Private Auth Panel";
$lang['Include_all_pages']			= "List all pages";
$lang['View']						= "View";
$lang['Edit']						= "Edit";
$lang['Delete']						= "Delete";
$lang['Settings']					= "Settings";
$lang['Move_up']					= "Move up";
$lang['Move_down']					= "Move down";
$lang['Resync']						= "Resync";
$lang['Update']						= "Update";
$lang['Permissions']				= "Permissions";
$lang['Permissions_std']			= "Standard Permissions";
$lang['Permissions_adv']			= "Advanced Permissions";
$lang['return_to_page']				= "Back to Portal Page";
$lang['Use_default'] 				= 'Use default setting';

$lang['AdminCP_status']				= "<b>Progress report</b>";
$lang['AdminCP_action']				= "<b>DB Action</b>";
$lang['Invalid_action']				= "Error";
$lang['was_installed']              = "was installed";
$lang['was_uninstalled']            = "was uninstalled";
$lang['was_upgraded']               = "was upgraded";
$lang['was_exported']               = "was exported";
$lang['was_deleted']                = "was deleted";
$lang['was_removed']                = "was removed";
$lang['was_inserted']               = "was inserted";
$lang['was_updated']                = "was updated";
$lang['was_added']                  = "was added";
$lang['was_moved']                  = "was moved";
$lang['was_synced']                 = "was synchronized";

$lang['error_no_field']                    	= "There is a missing field. Please fill out all the needed fields...";

//
// Configuration
//
$lang['Portal_admin']						= "Portal Administration";
$lang['Portal_admin_explain']				= "Use this form to customize your portal";
$lang['Portal_General_Config']				= "Portal Configuration";
$lang['Portal_General_settings']			= "General Settings";
$lang['Portal_General_config_info']			= "General Portal Config Info ";
$lang['Portal_General_config_info_explain'] = "Posted setup info from the config.php file (no edits needed)";
$lang['Portal_Name']						= "Portal Name:";
$lang['Portal_PHPBB_Url']					= "URL to your phpBB installation:";
$lang['Portal_Url']							= "URL to mxBB-Portal:";
$lang['Portal_Config_updated']				= "Portal Configuration Updated Successfully";
$lang['Click_return_portal_config']			= "Click %sHere%s to return to Portal Configuration";
$lang['PHPBB_info']							= "phpBB Info";
$lang['PHPBB_version']						= "phpBB Version:";
$lang['PHPBB_script_path']					= "phpBB Script Path:";
$lang['PHPBB_server_name']					= "phpBB Domain (server_name):";
$lang['MX_Portal']							= "mxBB-Portal";
$lang['MX_Modules']							= "mxBB-Modules";
$lang['Phpbb']								= "phpBB";
$lang['Top_phpbb_links']					= "phpBB Stats in Header (default value)<br /> - links to new/unread posts etc";
$lang['Portal_version']						= "mxBB-Portal Version:";
$lang['Mx_use_cache']						= "Use mxBB Block Cache";
$lang['Mx_use_cache_explain']				= "Block data is cached to individual cache/block_*.xml files. Block cache files are created when Blocks are edited.";
$lang['Mx_mod_rewrite'] 					= "Use mod_rewrite";
$lang['Mx_mod_rewrite_explain'] 			= "If you're running on an Apache server and have mod_rewrite activated, you may rewrite urls like 'page=x' with more intuitive alternatives. Read further documentation in the mx_mod_rewrite module.";


//
// Module Management
//
$lang['Module_admin']				= "Module Administration";
$lang['Module_admin_explain']		= "Use this form to manage modules: installation, upgrading and module development.<br /><b>To use this panel, you need to have JavaScript and cookies enabled in your browser!</b>";
$lang['Modulecp_admin']				= "Module Control Panel";
$lang['Modulecp_admin_explain']		= "Use this form to manage modules: block functions (parameters) and portal blocks.<br /><b>To use this panel, you need to have JavaScript and cookies enabled in your browser!</b>";
$lang['Modules']					= "Modules";
$lang['Module']						= "Module";
$lang['Module_delete']				= "Delete a Module";
$lang['Module_delete_explain']		= "Use this form to delete a Module (or block function)";
$lang['Edit_module']				= "Edit a Module";
$lang['Create_module']				= "Create new Module";
$lang['Module_name']				= "Module Name";
$lang['Module_desc']				= "Description";
$lang['Module_path']				= "Path, eg 'modules/mx_textblocks/'";
$lang['Module_include_admin']		= "Include this module in left pane Admin Menu Navigation";

//
// Module Installation
//
$lang['Module_delete_db']			= "Do you really want to uninstall the Module? Warning: You will lose all module data. Consider upgrading instead.";
$lang['Click_module_delete_yes']	= "Click %sHere%s to uninstall the module";
$lang['Click_module_upgrade_yes']	= "Click %sHere%s to upgrade the module";
$lang['Click_module_export_yes']	= "Click %sHere%s to export the module";
$lang['Error_no_db_install']		= "Error: The file db_install.php does not exist. Please verify this and try again...";
$lang['Error_no_db_uninstall']		= "Error: The file db_uninstall.php does not exist, or the uninstall feature is not supported for this module. Please verify this and try again.";
$lang['Error_no_db_upgrade']		= "Error: The file db_upgrade.php does not exist, or the upgrade feature is not supported for this module. Please verify this and try again.";
$lang['Error_module_installed']		= "Error: This module is already installed! Please either first delete the module, or upgrade the module instead.";
$lang['Uninstall_module']			= "Uninstall Module";
$lang['import_module_pack']			= "Install Module";
$lang['import_module_pack_explain']	= "This will add a module to the portal. Be sure the Module Package is uploaded to the /modules folder. Remember to use the latest Module version!";
$lang['upgrade_module_pack']		= "Upgrade Module";
$lang['upgrade_module_pack_explain']= "This will upgrade your module. Be sure to read the Module Documentation before proceeding, or you may risk module data loss.";
$lang['export_module_pack']			= "Export Module";
$lang['Export_Module']				= "Select a Module:";
$lang['export_module_pack_explain']	= "This will export a module *.pak file. This is only intended for module writers.";
$lang['Module_Config_updated']		= "Module Configuration Updated Successfully";
$lang['Click_return_module_admin']	= "Click %sHere%s to return to Module Administration";
$lang['Module_updated']				= "Module Information Updated successfully";

//
// Functions & Parameters Administration
//
$lang['Function_admin']				= "Block Function Administration";
$lang['Function_admin_explain']		= "Modules have one or more Block Functions. Use this form to edit, add, or delete a Block Function";
$lang['Function']					= "Block Function";
$lang['Function_name']				= "Block Function Name";
$lang['Function_desc']				= "Description";
$lang['Function_file']				= "File ";
$lang['Function_admin_file']       	= "File (Edit block script) <br /> Extra parameters for this edit block panel. Leave blank to use default edit panel.";
$lang['Create_function']			= "Add new Block Function";
$lang['Delete_function']			= "Delete Block Function";
$lang['Delete_function_explain']	= "This will delete the function and all its associated portal blocks. Beware, this operation cannot be undone!";
$lang['Click_function_delete_yes']	= "Click %sHere%s to delete the Function";

$lang['Parameter_admin']			= "Function Parameter Administration";
$lang['Parameter_admin_explain']	= "List all Parameters for this Function";
$lang['Parameter']					= "Parameter";
$lang['Parameter_name']				= "<b>Parameter Name</b><br />- to be used to access the parameter";
$lang['Parameter_type']				= "<b>Parameter Type</b>";
$lang['Parameter_default']			= "<b>Default Value</b>";
$lang['Parameter_function']			= "<b>Function/Options</b>";
$lang['Parameter_function_explain']	= "<b>Function</b> (when using the 'Function' type)<br />- You may pass the parameter data to an external function <br /> to generate the parameter form field.<br />- For example: <br />get_list_formatted(\"block_list\",\"{parameter_value}\",\"{parameter_id}[]\")";
$lang['Parameter_function_explain']	.= "<br /><br /><b>Option(s)</b> (when using 'Selection' parameter types)<br />- For all selection parameters (radiobuttons, checkboxes and menus) all options are listed here, one option per line.";
$lang['Parameter_auth']				= "<b>Admin/Block Moderator only</b>";

$lang['Parameters']					= "Parameters";
$lang['Parameter_id']				= "ID";
$lang['Create_parameter']			= "Add new Parameter";
$lang['Delete_parameter']			= "Delete Function Parameter";
$lang['Delete_parameter_explain']	= "This will delete the parameter and update all associated portal blocks. Beware, this operation cannot be undone!";
$lang['Click_parameter_delete_yes']	= "Click %sHere%s to delete the Parameter";

//
// Parameter Types
//
$lang['ParType_BBText'] 			= "Simple BBCode Textblock";
$lang['ParType_BBText_info'] 		= "This is a simple textblock that parses BBCode";
$lang['ParType_Html'] 				= "Simple HTML Textblock";
$lang['ParType_Html_info'] 			= "This is a simple textblock, parsing HTML";
$lang['ParType_Text'] 				= "Plain Text (single-row)";
$lang['ParType_Text_info'] 			= "This is a simple text field";
$lang['ParType_TextArea'] 			= "Plain Text Area (multiple-row)";
$lang['ParType_TextArea_info'] 		= "This is a simple textarea field";
$lang['ParType_Boolean'] 			= "Boolean";
$lang['ParType_Boolean_info'] 		= "This is a 'yes' or 'no' radio switch.";
$lang['ParType_Number'] 			= "Plain Number";
$lang['ParType_Number_info'] 		= "This is a simple number field";
$lang['ParType_Function'] 			= "Parameter function";
$lang['ParType_Values'] 			= "Values";

$lang['ParType_Radio_single_select'] 			= "Single-Selection Radio Buttons";
$lang['ParType_Radio_single_select_info'] 		= "";
$lang['ParType_Menu_single_select'] 			= "Single-Selection Menu";
$lang['ParType_Menu_single_select_info'] 		= "";
$lang['ParType_Menu_multiple_select'] 			= "Multiple-Selection Menu";
$lang['ParType_Menu_multiple_select_info'] 		= "";
$lang['ParType_Checkbox_multiple_select'] 		= "Multiple-Selection Checkbox";
$lang['ParType_Checkbox_multiple_select_info'] 	= "";

//
// Blocks Administration
//
$lang['Block_admin']				= "Block Control Panel";
$lang['Block_admin_explain']		= "Use this form to manage Portal Blocks.<br /><b>To use this panel, you need to have JavaScript and cookies enabled in your browser!</b>";
$lang['Block']						= "Block";
$lang['Show_title']					= "Show Block Title?";
$lang['Show_title_explain']			= "Whether or not to display the block title";
$lang['Show_block']					= "Show Block?";
$lang['Show_block_explain']			= "- If 'no', the Block is hidden to all users, except administrators";
$lang['Show_stats']					= "Show Statistics?";
$lang['Show_stats_explain']			= "- If 'yes', 'edited by...' will be displayed below the block";
$lang['Show_blocks']                = "View Function Blocks";
$lang['Block_delete']				= "Delete a Block";
$lang['Block_delete_explain']		= "Use this form to delete a Block (or column)";
$lang['Block_title']				= "Title";
$lang['Block_desc']					= "Description";
$lang['Add_Block']					= "Add new Block";
$lang['Auth_Block']					= "Permissions";
$lang['Auth_Block_explain']			= "ALL: All users<br />REG: Registered Users<br />PRIVATE: Group members (see advanced permissions)<br />MOD: block moderators (see advanced permissions)<br />ADMIN: Admin<br />ANONYMOUS: Guest users ONLY";
$lang['Block_quick_stats']			= "Quick Stats";
$lang['Block_quick_edit']			= "Quick Edit";
$lang['Create_block']				= "Create new Block";
$lang['Delete_block']				= "Delete Portal Block";
$lang['Delete_block_explain']		= "This will delete the block and update all associated portal pages. Beware, this operation cannot be undone!";
$lang['Click_block_delete_yes']		= "Click %sHere%s to delete the Block";

//
// BlockCP Administration
//
$lang['Block_cp']                   = "BlockCP";
$lang['Click_return_blockCP_admin']	= "Click %sHere%s to return to the Block Control Panel";
$lang['Click_return_portalpage_admin']	= "Click %sHere%s to return to the Portal Page";
$lang['BlockCP_Config_updated']		= "The Block was Updated...";

//
// Pages Administration
//
$lang['Page_admin']					= "Page Administration";
$lang['Page_admin_explain']			= "Use this form to add, delete and change the settings for Portal Pages and Page Templates.<br /><b>To use this panel, you need to have JavaScript and cookies enabled in your browser!</b>";
$lang['Page_admin_edit']			= "Page Edit";
$lang['Page_admin_private']			= "Advanced Page (PRIVATE) Permissions";
$lang['Page_admin_settings']		= "Page Settings";
$lang['Page_admin_new_page']		= "New Page Administration";
$lang['Page']						= "Page";
$lang['Page_Id']					= "Page ID";
$lang['Page_icon']					= "Page Icon <br /> - to be used in the adminCP only, eg. icon_home.gif (default)";
$lang['Page_header']				= "Page header file <br /> - i.e. overall_header.tpl (default), overall_noheader.tpl (no header) or user custom header file.";
$lang['Auth_Page']					= "Permissions";
$lang['Select_sort_method']			= "Select Sort Method";
$lang['Order']						= "Order";
$lang['Sort']						= "Sort";
$lang['Page_sort_title']			= "Page title";
$lang['Page_sort_desc']				= "Page description";
$lang['Page_sort_created']			= "Page created";
$lang['Sort_Ascending']				= "ASC";
$lang['Sort_Descending']			= "DESC";
$lang['Return_to_page']				= "Return to Portal Page";
$lang['Auth_Page_group']			= "-> PRIVATE Group";
$lang['Page_desc']					= "Description";
$lang['Page_graph_border']			= "Page border graphics - file prefix";
$lang['Page_graph_border_explain']	= "To use border graphics around Blocks, specify the prefix for the graphics files here. For example, enter 'border_' to use the files: border_1-1.gif, border_1-2.gif,..., border_3-3.gif for the 3x3 matrix with gif-images. Leave blank to disable border graphics (default).";
$lang['Add_Page']					= "Add new Page";
$lang['Page_Config_updated']		= "Page Configuration Updated Successfully";
$lang['Click_return_page_admin']	= "Click %sHere%s to return to Page Administration";
$lang['Remove_block']				= "Remove Portal Block";
$lang['Remove_block_explain']		= "This will remove the block from this page. Beware, this operation cannot be undone!";
$lang['Click_block_remove_yes']		= "Click %sHere%s to remove the Block";
$lang['Delete_page']				= "Delete Page";
$lang['Delete_page_explain']		= "This will delete the Page. Beware, this operation cannot be undone!";
$lang['Click_page_delete_yes']		= "Click %sHere%s to delete the Page";

$lang['Mx_IP_filter']				= "IP Filter";
$lang['Mx_IP_filter_explain']		= "To restrict access to this page by IP, enter the valid IP adresses - one IP address per line.<br>Eg 127.0.0.1 or 127.1.*.*";
$lang['Mx_phpBB_stats']				= "phpBB Stats in Header";
$lang['Mx_phpBB_stats_explain']		= "- links to new/unread posts etc";
$lang['Column_admin']				= "Page Column Administration";
$lang['Column_admin_explain']		= "Administer Page Columns";
$lang['Column']						= "Page Column";
$lang['Columns']					= "Page Columns";
$lang['Column_block']				= "Page Column Block";
$lang['Column_blocks']				= "Page Column Blocks";
$lang['Edit_Column']				= "Edit a Column";
$lang['Edit_Column_explain']		= "Use this form to modify a column";
$lang['Column_Size']				= "Size of the column";
$lang['Column_name']				= "Column Name";
$lang['Column_delete']				= "Delete a Column";
$lang['Page_updated']				= "Page and Column information updated successfully";
$lang['Create_column']				= "Add new Column";
$lang['Delete_page_column']				= "Delete Page Column";
$lang['Delete_page_column_explain']		= "This will delete the Page Column. Beware, this operation cannot be undone!";
$lang['Click_page_column_delete_yes']	= "Click %sHere%s to delete the Page Column";

//
// Page templates
//
$lang['Page_templates_admin']		= "Page Templates Administration";
$lang['Page_templates_admin_explain'] = "Use this page to create, edit or delete Page Templates";
$lang['Page_template']				= "Page Template";
$lang['Page_templates']				= "Page Templates";
$lang['Page_template_column']		= "Page Template Column";
$lang['Page_template_columns']		= "Page Template Columns";
$lang['Choose_page_template']		= "Choose Page Template";
$lang['Template_Config_updated']	= "Template Configuration Updated";
$lang['Add_Template']				= "Add new Template";
$lang['Template']					= "Template";
$lang['Template_name']				= "Template Name";
$lang['Page_template_delete']		= "Delete Template";
$lang['Delete_page_template']			= "Delete Page Template";
$lang['Delete_page_template_explain']	= "This will delete the Page Template. Beware, this operation cannot be undone!";
$lang['Click_page_template_delete_yes']	= "Click %sHere%s to delete the Page Template";
$lang['Delete_page_template_column']			= "Delete Page Template";
$lang['Delete_page_template_column_explain']	= "This will delete the Page Template. Beware, this operation cannot be undone!";
$lang['Click_page_template_column_delete_yes']	= "Click %sHere%s to delete the Page Template";

//
// Install Process
//
$lang['Welcome_install']			= "Welcome to the mxBB-Portal Installation Wizard";
$lang['Install_Instruction']		= "Please fill out the details requested below. This installation program will create your personalized config.php (in the Portal root directory) and the Portal database with default settings. Once this is done, you'll see a report of all the steps taken (please note mxBB-Portal does not modify your phpBB database in any way). You should then login to your board with your administrator username and password and go to the Administration Control Panel to configure your portal with your own preferences. Please note mxBB-Portal will not work by itself, phpBB must already be installed and configured. Thank you for choosing mxBB-Portal.";
$lang['Upgrade_Instruction']		= "mxBB-Portal is already installed. Please make backups of your database now !<br /><br />The next step will modify the structure of your database (please note mxBB-Portal does not modify your phpBB database in any way). If for whatever reason this upgrade procedure fails, there would be no other way to return to your current state. Please make backups of your database BEFORE proceeding !<br /><br />Once done, click the button below to start the upgrade procedure.";
$lang['Install_moreinfo']			= "%sRelease Notes%s | %sWelcome Pack%s | %sOnline FAQ%s | %sSupport Forums%s | %sTerms Of Use%s";
$lang['Install_settings']			= "Installation Settings";
$lang['Choose_lang_explain']		= "Please use the form below to select the language you wish to use throughout the installation process.";
$lang['Choose_lang']				= "Choose Language";
$lang['Language']					= "Language";
$lang['Phpbb_path']					= "phpBB relative path";
$lang['Phpbb_path_explain']			= "Relative path to phpBB, eg phpBB/ or ../phpBB/<br />Note the slashes '/', they are important!";
$lang['Phpbb_url']					= "Full phpBB URL";
$lang['Phpbb_url_explain']			= "Full phpBB URL, eg<br />http://www.example.com/phpBB/";
$lang['Portal_url']					= "Full Portal URL";
$lang['Portal_url_explain']			= "Full Portal URL, eg<br />http://www.example.com/";
$lang['Database_settings']			= "Database Settings";
$lang['dbms']						= "Database Type";
$lang['DB_Host']					= "Database Server Hostname/DSN";
$lang['DB_Name']					= "Your Database Name";
$lang['DB_Username']				= "Database Username";
$lang['DB_Password']				= "Database Password";
$lang['Table_Prefix']				= "phpBB Prefix in DB";
$lang['MX_Table_Prefix']			= "mxBB-Portal Prefix in DB";
$lang['Start_Install']				= "Start mxBB Installation";
$lang['Start_Upgrade']				= "Yes, I have already done a backup and wish to upgrade my mxBB-Portal now.";
$lang['Portal_intalled']			= "mxBB-Portal has been installed !";
$lang['Portal_upgraded']			= "mxBB-Portal has been upgraded !";
$lang['Unwriteable_config']			= "Your mxBB config file (config.php) is un-writeable at present.<br /><br />A copy of the config file will be downloaded to you when you click the button below. You should upload this file to your mxBB root directory: %s <br /><br />Once this is done, please %sREFRESH%s this window to proceed with the next installation step.<br /><br />Thank you for choosing mxBB-Portal.<br />";
$lang['Send_file']					= "Just send the file to me and I'll FTP it manually";
$lang['phpBB_nfnd_retry']			= "Sorry, we could not find your phpBB installation. Please press the %sBACK%s button of your browser and retry.";
$lang['Installation_error']			= "An error has occurred during the installation";
$lang['Debug_Information']			= "DEBUG INFORMATION";
$lang['Install_phpbb_not_found']	= "Sorry, we could not find any phpBB board installed on this server.<br />Please install phpBB BEFORE installing mxBB-Portal.<br />\n<br />\n";
$lang['Install_phpbb_db_failed']	= "Sorry, we could not connect to the phpBB database.<br />Please check that your phpBB is correctly installed and up and running BEFORE installing mxBB-Portal.<br />\n<br />\n";
$lang['Install_phpbb_unsupported']	= "Unfortunately, the phpBB board installed on this server is not supported by mxBB-Portal.<br />Please check the release notes for installation requirements.<br />\n<br />\n";
$lang['Install_noscript_warning']	= "Sorry, this installation requires a JavaScript enabled browser. It might not work on your browser.";
$lang['Upgrade_are_you_sure']		= "This upgrade procedure will make modifications to your database. Are you sure you wish to proceed?";
$lang['Writing_config']				= "Writing config.php file";
$lang['Processing_schema']			= "Processing SQL Schema '%s'";
$lang['Portal_intalling']			= "Installing mxBB-Portal version %s";
$lang['Portal_upgrading']			= "Upgrading mxBB-Portal version %s";
$lang['Install_warning']			= "There was 1 warning updating the database";
$lang['Install_warnings']			= "There were %d warnings updating the database";
$lang['Subscribe_mxBB_News_now']	= "We recommend that you subscribe to the %smxBB-News Mailing List%s to receive information about important news and release announcements.<br />&nbsp;<br />%sSubscribe to mxBB-News, now!%s";
$lang['Portal_install_done'][0]		= "At this point your basic installation is complete.";
$lang['Portal_install_done'][1]		= "Please delete the /install and /contrib folders BEFORE proceeding!!!";
$lang['Portal_install_done'][2]		= "Remember to make backups as often as possible ;-)";
$lang['Portal_install_done'][3]		= "Press the button below and use your Administrator username and password to login to the system.";
$lang['Portal_install_done'][4]		= "Enter the Admin Control Panel - Management, and upgrade ALL modules - one by one!";
$lang['Portal_install_done'][5]		= "Please be sure to check the Portal Configurations and make any required changes.";
$lang['Go_to_admincp']				= "Now visit the Admin Control Panel and upgrade your modules";
$lang['Thanks_for_choosing']		= "Thank you for choosing mxBB-Portal.";
$lang['Critical_Error']				= "CRITICAL ERROR";
$lang['Error_loading_config']		= "Sorry, could not load mxBB-Portal config.php";
$lang['Error_database_down']		= "Sorry, could not connect to database.";

//
// Cache
//
$lang['Cache_dir_write_protect']	= "Your cache directory is write-protected. Unable to generate the cache file";
$lang['Cache_generate']				= "Your cache files have been generated.";
$lang['Cache_submit']				= "Generate the cache file?";
$lang['Cache_explain']				= "With this option you can generate all XML files (cache files) at once for all portal blocks. These files allow the reduction of the number of database queries needed and improves overall portal performance. <br />Note: the mxBB cache must be enabled (in the Portal General Admin CP) for these files to be used by the system.<br>Further note: the cache files are created on the fly when editing blocks as well.";
$lang['Generate_mx_cache']			= "Generate Block Cache";

//
// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!
//
$lang['Menu_Navigation']			= "Navigation Menu";
$lang['Portal_index']				= "Portal Index";
$lang['Save_Settings']				= "Save Settings";
$lang['Translation_Tools']			= "Translation Tools";
$lang['Preview_portal']				= "Preview Portal";

//
// META
//
$lang['Meta_admin']					= "Meta Tags Administration";
$lang['Mega_admin_explain']			= "Use this form to customize your meta tags";
$lang['Meta_Title']					= "Title";
$lang['Meta_Author']				= "Author";
$lang['Meta_Copyright']				= "Copyright";
$lang['Meta_Keywords']				= "Keywords";
$lang['Meta_Keywords_explain']		= "(comma seperated list)";
$lang['Meta_Description']			= "Description";
$lang['Meta_Language']				= "Language Code";
$lang['Meta_Rating']				= "Rating";
$lang['Meta_Robots']				= "Robots";
$lang['Meta_Pragma']				= "Pragma no-cache";
$lang['Meta_Bookmark_icon']			= "Bookmark Icon";
$lang['Meta_Bookmark_explain']		= "(relative location)";
$lang['Meta_HTITLE']				= "Extra Header Settings";
$lang['Meta_data_updated']			= "Meta data file (mx_meta.inc) has been updated!<br />Click %sHERE%s to return to Meta Tags Administration.";
$lang['Meta_data_ioerror']			= "Unable to open mx_meta.inc. Make sure the file is writable (chmod 777).";

//
// Portal permissons
//
$lang['Mx_Block_Auth_Title']		= "Private Block Permissions" ;
$lang['Mx_Block_Auth_Explain']		= "Here you can configure Private Block Permissions";
$lang['Mx_Page_Auth_Title']			= "Private Page Permissions" ;
$lang['Mx_Page_Auth_Explain']		= "Here you configure Private Page Permissions";
$lang['Block_Auth_successfully']	= "Block Permissions Updated Successfully";
$lang['Click_return_block_auth']	= "Click %sHere%s to return to Private Block Permissions";
$lang['Page_Auth_successfully']		= "Page Permissions Updated Successfully";
$lang['Click_return_page_auth']		= "Click %sHere%s to return to Private Page Permissions";
$lang['AUTH_ALL']					= "ALL";
$lang['AUTH_REG']					= "REG";
$lang['AUTH_PRIVATE']				= "PRIVATE";
$lang['AUTH_MOD']					= "MOD";
$lang['AUTH_ADMIN']					= "ADMIN";
$lang['AUTH_ANONYMOUS']				= "ANONYMOUS";

// -----------------------------------
// BlockCP - Block Parameter Specific
// -----------------------------------

//
// General
//
$lang['target_block']				= "Target Block";
$lang['target_block_explain']		= "- links, data etc are refering with this block";

//
// Split column
//
$lang['block_ids']					= "Source Blocks";
$lang['block_ids_explain']			= "- to be placed left to right";
$lang['block_sizes']				= "Block Sizes (comma separated)";
$lang['block_sizes_explain']		= "- You may specify size using numbers (pixels), percentages (relative sizes, ie. '40%') or '*' for the remainder.";
$lang['space_between']				= "Space between Blocks";

//
// Sitelog
//
$lang['log_filter_date']			= "Filter by time";
$lang['log_filter_date_explain']	= "- Show logs from last week, month, year...";
$lang['numOfEvents']				= "Number";
$lang['numOfEvents_explain']		= "- Number of events to show";

//
// IncludeX
//
$lang['x_listen']					= "Listen (GET)";
$lang['x_iframe']					= "IFrame";
$lang['x_textfile']					= "Textfile";
$lang['x_multimedia']				= "WMP Multimedia";
$lang['x_pic']						= "Pic";
$lang['x_format']					= "Formatted Textfile";
$lang['x_mode']						= 'IncludeX mode:';
$lang['x_mode_explain']				= '- The IncludeX block operates in one of the following modes. If mode \'Listen (GET)\' is selected, the mode may be set by a url \'x_mode=mode\' and associated parameters with \'x_1=, x_2=, etc\'.<br />Example: To pass a url to a iframe use \'domain/index.php?page=x&x_mode=iframe&x_1=http://domain\'  ';
$lang['x_1']						= 'Variable 1:';
$lang['x_1_explain']				= '- <i>IFrame:</i> url<br /><i>Textfile:</i> relative path from root (eg in \'/include_file/my_file.xxx\')<br /><i>Multimedia:</i> relative path from root (eg in \'/include_file/my_file.xxx\')<br /><i>Pic:</i> relative path from root (eg in \'/include_file/my_file.xxx\')<br /><i>Formatted textfile:</i> not available';
$lang['x_2']						= 'Variable 2:';
$lang['x_2_explain']				= '- <i>IFrame:</i> frame height (pixels)<br /><i>Multimedia:</i> width (pixles)';
$lang['x_3']						= 'Variable 3:';
$lang['x_3_explain']				= '- <i>Multimedia:</i> height (pixles)';

//
// Announcement
//
$lang['announce_nbr_display']		= "Maximum Number of Messages to Display";
$lang['announce_nbr_days']			= "Number of Days to Display Messages";
$lang['announce_img']				= "Announcement Image";
$lang['announce_img_sticky']		= "Sticky Image";
$lang['announce_img_normal']		= "Normal Message Image";
$lang['announce_img_global']		= "Global Announcement Image";
$lang['announce_display']			= "Display Announcement(s) messages in this Block";
$lang['announce_display_sticky']	= "Display Sticky(ies) in this Block";
$lang['announce_display_normal']	= "Display Normal message(s) in this Block";
$lang['announce_display_global']	= "Display Global Announcements in this Block";
$lang['announce_forum']				= "Source Forums";
$lang['announce_forum_explain']		= "- You may make multiple selections. For example, hold down the CTRL button on your keyboard while clicking extra selections.<br />* If nothing is selected, all authorized forums will be visible";

//
// Polls
//
$lang['Poll_Display']				= "Which Poll do you want to display?";
$lang['poll_forum']					= "Source Forums";
$lang['poll_forum_explain']			= "- You may make multiple selections<br />* If nothing is selected, all authorized forums will be visible";
$lang['Not_Specified']				= "Not Specified";

//
// Dynamic Block
//
$lang['default_block_id']			= "Default Block";
$lang['default_block_id_explain']	= "- This is the default or first block to display, unless a dynamic block is set";

//
// Menu Navigation
//
$lang['menu_display_mode']			= "Layout Mode";
$lang['menu_display_mode_explain ']	= "Horizonal or Vertical layout mode";
$lang['menu_page_sync']				= "Highlight current?";
$lang['menu_page_sync_explain']		= "Highlight current Navigation Menu entry...";

//
// Version Checker
//
$lang['mxBB_Version_up_to_date'] = 'Your mxBB installation is up to date. No updates are available for your version of mxBB.';
$lang['mxBB_Version_outdated'] = 'Your mxBB installation does <b>not</b> seem to be up to date. Updates are available for your version of mxBB. Please visit <a href="http://www.mx-publisher.com/index.php?page=4&action=file&file_id=2" target="_new">the mxBB Core package download</a> to obtain the latest version.';
$lang['mxBB_Latest_version_info'] = 'The latest available version is <b>mxBB %s</b>. ';
$lang['mxBB_Current_version_info'] = 'You are running <b>mxBB %s</b>.';
$lang['mxBB_Mailing_list_subscribe_reminder'] = 'For the latest information on news and updates to mxBB, why not <a href="http://lists.sourceforge.net/lists/listinfo/mxbb-news" target="_new">subscribe to our mailing list</a>?';

//
// That's all Folks!
// -------------------------------------------------
?>