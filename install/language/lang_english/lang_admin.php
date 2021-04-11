<?php
/**
*
* @package MX-Publisher Core
* @version $Id: lang_admin.php,v 1.7 2014/05/13 17:59:43 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

//
// Editor Settings: Please set Tabsize to 4 ;-)
//

//
// The format of this file is:
//
// ---> $lang['message'] = 'text';
//
// Specify your language character encoding... [optional]
//
// setlocale(LC_ALL, 'en');

//
// Install Process
//
$lang['Portal_paths'] 	= 'Portal Paths';
$lang['ReadOnly'] 	= ' (read only)';
$lang['Welcome_install'] = 'Welcome to the MX-Publisher Installation Wizard';
$lang['Install_Instruction'] = 'Please fill out the details requested below. This installation program will create your personalized config.php (in the Portal root directory) and the Portal database with default settings. Once this is done, you\'ll see a report of all the steps taken. You should then login to your board with your administrator username and password and go to the Administration Control Panel to configure your portal with your own preferences. Thank you for choosing MX-Publisher.';
$lang['Install_Instruction_mxBB'] = 'Be sure to fill out the form below carefully. If you need, consult the MXP documentation for further assistance.';
$lang['Install_Instruction_MXP_Admin'] = 'If the MXP adminname and password are left blank, your admin account will be created: username (admin), password (admin). Modify this password asap!';
$lang['Install_Instruction_phpBB'] = 'Please note, even if you plan to use MX-Publisher with phpBB, this installation does not modify your phpBB database in any way.';
$lang['Install_Instruction_SMF'] = 'Please note, even if you plan to use MX-Publisher with SMF, this installation does not modify your SMF database in any way.';
$lang['Install_Instruction_MyBB'] = 'Please note, even if you plan to use MX-Publisher with MyBB, this installation does not modify your SMF database in any way.';
$lang['Upgrade_Instruction'] = 'MX-Publisher is already installed. Please make backups of your database now !<br /><br />The next step will modify the structure of your database (please note MX-Publisher does not modify your MyBB database in any way). If for whatever reason this upgrade procedure fails, there would be no other way to return to your current state. Please make backups of your database BEFORE proceeding !<br /><br />Once done, click the button below to start the upgrade procedure.';
$lang['Install_moreinfo'] = '%sRelease Notes%s | %sOnline Manual%s | %sOnline KB%s | %sSupport Forums%s | %sTerms Of Use%s';
$lang['Install_settings'] = 'Installation Settings';
$lang['Choose_lang_explain'] = 'Please use the form below to select the language you wish to use throughout the installation process.';
$lang['Choose_lang'] = 'Choose Language';
$lang['Phpbb_only'] = '[phpBBX]';
$lang['Mxbb_only'] = '[Internal]';
$lang['Language'] = 'Language';
$lang['Portal_backend'] = 'Backend Name';
$lang['Session_backend'] = 'Users & Sessions';
$lang['Session_backend_explain'] = 'The MX-Publisher-IWizard has detected installed forum boards on this server. <br />Select here if you plan to use MX-Publisher with forums users and sessions. <br />If you are unsure (or if you want to install MX-Publisher without phpBB), select \'Internal\' setup. <br />You may update this setting later in the MX-Publisher adminCP';
$lang['Phpbb_path'] = 'phpBB relative path';
$lang['Phpbb_path_explain'] = 'Relative path to phpBB, ex. phpBB/ or ../phpBB/<br />Note the slashes "/", they are important!';
$lang['Phpbb_url'] = 'Full phpBB URL';
$lang['Phpbb_url_explain'] = 'Full phpBB URL, ex. <br />http://www.example.com/phpBB/';
$lang['Portal_url'] = 'Full Portal URL';
$lang['Portal_backend'] = 'Portal Backend';
$lang['Portal_url_explain'] = 'Full Portal URL, ex. <br />http://www.example.com/';
$lang['Database_settings'] = 'Database Settings';
$lang['dbms'] = 'Database Type';
$lang['DB_Host'] = 'Database Server Hostname/DSN';
$lang['DB_Name'] = 'Your Database Name';
$lang['DB_Username'] = 'Database Username';
$lang['DB_Character_Set'] = 'Database Character Set';
$lang['DB_Character_Set_explain'] = 'Character Set ex. utf8';
$lang['MXP_Adminname'] = 'MXP Admin Username';
$lang['DB_Password'] = 'Database Password';
$lang['MXP_Password'] = 'MXP Admin Password';
$lang['MXP_Password2'] = 'MXP Admin Password (repeat)';
$lang['Table_Prefix'] = 'phpBB Prefix in DB';
$lang['MX_Table_Prefix'] = 'MX-Publisher Prefix in DB';
$lang['Start_Install'] = 'Start MX-Publisher Installation';
$lang['Start_Upgrade'] = 'Yes, I have already done a backup and wish to upgrade my MX-Publisher now.';
$lang['Portal_intalled'] = 'MX-Publisher has been installed !';
$lang['Portal_upgraded'] = 'MX-Publisher has been upgraded !';
$lang['Unwriteable_config'] = 'Your MX-Publisher config file (config.php) is currently un-writeable.<br /><br />A copy of the config file will be downloaded to you when you click the button below. You should upload this file to your MX-Publisher root directory: %s <br /><br />Once this is done, please %sREFRESH%s this window to proceed with the next installation step.<br /><br />Thank you for choosing MX-Publisher.<br />';
$lang['Send_file'] = 'Just send the file to me and I\'ll FTP it manually';
$lang['phpBB_nfnd_retry'] = 'Sorry, but we could not find your phpBB installation. Please press the %sBACK%s button of your browser and retry.';
$lang['MissingVariables'] = 'Sorry, but you need to fill out all required fields. Please press the %sBACK%s button of your browser and retry.';
$lang['Installation_error'] = 'An error has occurred during the installation';
$lang['Debug_Information'] = 'DEBUG INFORMATION';
$lang['Install_phpbb_not_found'] = 'Sorry, we could not find any phpBB board installed on this server.<br />Please install phpBB BEFORE installing MX-Publisher.<br />\n<br />\n';
$lang['Install_phpbb_db_failed'] = 'Sorry, we could not connect to the phpBB database.<br />Please check that your phpBB is correctly installed and up and running BEFORE installing MX-Publisher.<br />\n<br />\n';
$lang['Install_phpbb_unsupported'] = 'Unfortunately, the phpBB board installed on this server is not supported by MX-Publisher.<br />Please check the release notes for installation requirements.<br />\n<br />\n';
$lang['Install_smf_not_found'] = 'Sorry, we could not find any SMF board installed on this server.<br />Please install phpBB BEFORE installing MX-Publisher.<br />\n<br />\n';
$lang['Install_smf_db_failed'] = 'Sorry, we could not connect to the SMF database.<br />Please check that your phpBB is correctly installed and up and running BEFORE installing MX-Publisher.<br />\n<br />\n';
$lang['Install_smf_unsupported'] = 'Unfortunately, the phpBB board installed on this server is not supported by MX-Publisher.<br />Please check the release notes for installation requirements.<br />\n<br />\n';
$lang['Install_mybb_not_found'] = 'Sorry, we could not find any myBB board installed on this server.<br />Please install myBB BEFORE installing MX-Publisher.<br />\n<br />\n';
$lang['Install_mybb_db_failed'] = 'Sorry, we could not connect to the myBB database.<br />Please check that your myBB is correctly installed and up and running BEFORE installing MX-Publisher.<br />\n<br />\n';
$lang['Install_mybb_unsupported'] = 'Unfortunately, the phpBB board installed on this server is not supported by MX-Publisher.<br />Please check the release notes for installation requirements.<br />\n<br />\n';
$lang['Install_forums_not_found'] = 'Sorry, we could not find any forum board installed on this server.<br />Please install a forum suppported by this installer BEFORE installing MX-Publisher.<br />\n<br />\n';
$lang['Install_forums_unsupported'] = 'Unfortunately, any forum board installed on this server is not supported by MX-Publisher.<br />Please check the release notes for installation requirements.<br />\n<br />\n';
$lang['Install_noscript_warning'] = 'Sorry, this installation requires a JavaScript enabled browser. It might not work on your browser.';
$lang['Upgrade_are_you_sure'] = 'This upgrade procedure will make modifications to your database. Are you sure you wish to proceed?';
$lang['Writing_config'] = 'Writing config.php file';
$lang['Processing_schema'] = 'Processing SQL Schema \'%s\'';
$lang['Portal_intalling'] = 'Installing MX-Publisher version %s';
$lang['Portal_upgrading'] = 'Upgrading MX-Publisher version %s';
$lang['Install_warning'] = 'There was 1 warning updating the database';
$lang['Install_warnings'] = 'There were %d warnings updating the database';
$lang['Subscribe_mxBB_News_now'] = 'We recommend that you subscribe to the %smxBB-News Mailing List%s to receive information about important news and release announcements.<br />&nbsp;<br />%sSubscribe to mxBB-News, now!%s';
$lang['Portal_install_done'][0] = 'At this point your basic installation is complete.';
$lang['Portal_install_done'][1] = 'Please delete the /install/ and /contrib/ folders BEFORE proceeding!!!';
$lang['Portal_install_done'][2] = 'Remember to make backups as often as possible ;-)';
$lang['Portal_install_done'][3] = 'Press the button below and use your Administrator username and password to login to the system.';
$lang['Portal_install_done'][4] = 'Enter the Admin Control Panel - Management, and upgrade ALL modules - one by one!';
$lang['Portal_install_done'][5] = 'Please be sure to check the Portal Configurations and make any required changes.';
$lang['Go_to_admincp'] = 'Now visit the Admin Control Panel and upgrade your modules';
$lang['Thanks_for_choosing'] = 'Thank you for choosing MX-Publisher!';
$lang['Critical_Error'] = 'CRITICAL ERROR';
$lang['Error_loading_config'] = 'Sorry, could not load MX-Publisher config.php';
$lang['Error_database_down'] = 'Sorry, could not connect to the database.';
$lang['PasswordMissmatch'] = 'Sorry, your MXP Admin passwords mismatch.';
$lang['Cache_generate'] = 'Your cache files have been generated.';
//
// That's all Folks!
// -------------------------------------------------
?>