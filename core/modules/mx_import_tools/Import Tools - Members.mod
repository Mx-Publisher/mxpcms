############################################################## 
## MOD Title: Import Tools - Members
## MOD Author: Graham < phpbb@grahameames.co.uk > (Graham Eames) http://www.grahameames.co.uk/phpbb/
## MOD Description: This MOD will import a list of members held
##    in a CSV file and create user accounts for each of those members
##    on the forum.
##
## MOD Version: 0.1.4
## 
## Installation Level: Easy 
## Installation Time: 3 Minutes
## Files To Edit:
##    language/lang_english/lang_admin.php
## Included Files: 
##    admin_import_members.php
##    import_members_settings.tpl
##    import_message_body.tpl
##    lang_import.php
##    functions_mod_user.php
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##    The CSV file should be formatted as follows:
##    username, email, password
##    Password can either be provided in plain text, or as an MD5
##    hash, just select the appropriate option on the initial screen.
##
##    Additional information can be included in the CSV file and
##    imported by altering the relevant lines in the script.
##    For further information please post in the relevant thread at
##    phpBB.com or contact me directly.
##
############################################################## 
## MOD History:
## Aug 20, 2004 - Version 0.1.4
##  - Bug fix to remove redundant $'s from some code
## Mar 20, 2004 - Version 0.1.3
##  - Incorporates a bugfix to the functions_mod_user.php file so that the
##    personal groups are actually created correctly
## Mar 06, 2004 - Version 0.1.2
##  - Changed code to use my insert_user tools to act as an code example
## Feb 29, 2004 - Version 0.1.1
##  - Moved all text to language files as required in the coding standards
##  - Added the option to specify how many items are imported per pass
##  - Added validation of usernames as carried out in normal registrations
## Nov 15, 2003 - Version 0.1.0
##  - Initial Release
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ COPY ]------------------------------------------ 
# 
copy admin_import_members.php to admin/admin_import_members.php 
copy import_members_settings.tpl to templates/subSilver/admin/import_members_settings.tpl 
copy import_mesaage_body.tpl to templates/subSilver/admin/import_message_body.tpl 
copy lang_import.php to language/lang_english/lang_import.php
copy functions_mod_user.php to includes/functions_mod_user.php

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Restore_DB'] = 'Restore Database';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// Import Tools Menu Entries
$lang['Import_Tools'] = 'Import Tools';
$lang['Members'] = 'Members';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 