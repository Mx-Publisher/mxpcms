<?php
/**
*
* @package mxBB Portal Module - mx_import_tools
* @version $Id: lang_import.php,v 1.5 2007/05/05 20:22:56 jonohlsson Exp $
* @copyright (c) 2002-2006 [Graham Eames, Jon Ohlsson] mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mxbb.net
*
*/

// Error Messages
$lang['import_file_missing'] = 'File not found';
$lang['import_file_missing_details'] = 'The %s file was not found.'; // e.g. "The members.csv file was not found"
$lang['import_error_user_id'] = 'Could not obtain next user_id information';

// Information Messages
$lang['import_complete'] = 'Import Complete';
$lang['import_complete_members'] = 'The members have been imported into the forum.';
$lang['import_in_progress'] = 'Import In Progress';
$lang['import_in_progress_members'] = 'The import of the members into the forum is still in progress. Please click the button below to begin the next pass through the file.';
$lang['import_continue'] = 'Continue Import';

// Settings Messages
$lang['import_settings'] = 'Import Settings';
$lang['import_explain_members'] = 'This tool allows you to import a list on members obtained from another source to create user accounts for all those members on your forum. The members will be imported from a file named members.csv which should be placed in the admin/import/ directory, and contain entries of the format shown below, without the header line.';
$lang['import_password_format'] = 'Password Format';
$lang['import_password_format_explain'] = 'This setting specifies the format used for the passwords in the file we are importing from.';
$lang['import_password_format_plain'] = 'Plain text';
$lang['import_password_format_md5'] = 'MD5';
$lang['import_rate'] = 'Import Rate';
$lang['import_rate_explain'] = 'This setting determines the number of lines imported on each pass through the file.';
$lang['import_start'] = 'Start Import';

$lang['csv_list'] = 'Select *.csv files to import';

$lang['group_list'] = 'Add users to group:';

$lang['group_yes'] = 'Yes, do it';
$lang['group_no'] = 'No, only add users';
?>