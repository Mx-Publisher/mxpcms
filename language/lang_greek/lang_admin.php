<?php
/**
*
* @package MX-Publisher Core
* @version $Id: lang_admin.php,v 1.84 2008/02/05 14:29:58 joasch Exp $
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

$lang['mxBB_adminCP'] = 'Διαχείριση MX-Publisher';

//
// Left AdminCP Panel
//
$lang['1_General_admin'] = 'Γενική Διαχείριση';
$lang['1_1_Management'] = 'Γενικές Ρυθμίσεις';
$lang['1_2_WordCensors'] = 'Ανίχνευση Λέξεων';

$lang['2_CP'] = 'Διαχείριση του Portal';
$lang['2_1_Modules'] = 'Εγκατάσταση Μονάδων<br /><hr>';
$lang['2_2_ModuleCP'] = 'Πίνακας ελέγχου μονάδων';
$lang['2_3_BlockCP'] = 'Πίνακας ελέγχου Blocks';
$lang['2_4_PageCP'] = 'Πίνακας ελέγχου Σελίδων';

$lang['3_CP'] = 'Στυλ';
$lang['2_1_new'] = 'Δημιουργήσετε ένα νέο στυλ';
$lang['2_2_manage'] = 'Διαχείριση';
$lang['2_3_smilies'] = 'Φατσούλες';

$lang['4_Panel_system'] = 'Εργαλεία συστήματος';
$lang['4_1_Cache'] = 'Εκκαθάριση Λανθάνουσας Μνήμης';
$lang['4_1_Integrity'] = 'Έλεγχος Ακεραιότητας';
$lang['4_1_Meta'] = 'META Tags';
$lang['4_1_PHPinfo'] = 'Πληροφορίες PHP - phpInfo()';

//
// Index
//
$lang['Welcome_mxBB'] = 'Καλώς ήλθατε στο MX-Publisher';
$lang['Admin_intro_mxBB'] = 'Σας ευχαριστούμε που επιλέξατε το MX-Publisher ως portal/cms και το phpBB ως επιλογή Δημόσιας Συζήτησης. Αυτή η σελίδα θα σας δώσει μια γρήγορη επισκόπηση διαφόρων στατιστικών της ιστοσελίδας σας. Μπορείτε να επιστρέψετε σε αυτή την σελίδα πατώντας στην σύνδεση Πίνακας Διαχείρισης στην αριστερή πλευρά. Για να επιστρέψετε στην αρχική σελίδα της πλοήγησης πατήστε επίσης στο λογότυπο που βρίσκετε στην αριστερή πλευρά. Οι άλλες συνδέσεις στην αριστερή πλευρά αυτής της οθόνης σας επιτρέπουν να ελέγξετε κάθε πτυχή του Portal και του  Forum. Στην οθόνη θα βρείτε τις οδηγίες για το πώς να χρησιμοποιήσει τα παρεχόμενα εργαλεία.';

//
// General
//
$lang['Yes'] = 'Ναι';
$lang['No'] = 'Οχι';
$lang['No_modules'] = 'Δεν έχουν εγκατασταθεί μονάδες.';
$lang['No_functions'] = 'Αυτή η μονάδα δεν έχει λειτουργικό block.';
$lang['No_parameters'] = 'Αυτή η λειτουργία δεν έχει καμία παράμετρο.';
$lang['No_blocks'] = 'Δεν υπάρχει κανένα blocks για αυτή την λειτουργία.';
$lang['No_pages'] = 'Δεν υπάρχει σελίδα εδώ.';
$lang['No_settings'] = 'Δεν υπάρχουν περαιτέρω ρυθμίσεις για αυτό το block.';
$lang['Quick_nav'] = 'Γρήγορη Πλοήγηση';
$lang['Include_all_modules'] = 'Κατάλογος όλων των μονάδων';
$lang['Include_block_quickedit'] = 'Περιλαμβάνει Block γρήγορης επεξεργασίας';
$lang['Include_block_private'] = 'Περιλαμβάνει ιδιωτικό Block Auth';
$lang['Include_all_pages'] = 'Κατάλογος όλων των σελίδων';
$lang['View'] = 'Προβολή';
$lang['Edit'] = 'Επεξεργασία';
$lang['Delete'] = 'Διαγραφή';
$lang['Settings'] = 'Ρυθμίσεις';
$lang['Move_up'] = 'Μετακίνηση επάνω';
$lang['Move_down'] = 'Μετακίνηση κάτω';
$lang['Resync'] = 'Συγχρονισμός';
$lang['Update'] = 'Ενημέρωση';
$lang['Permissions'] = 'Δικαιώματα';
$lang['Permissions_std'] = 'Προεπιλεγμένα Δικαιώματα';
$lang['Permissions_adv'] = 'Προχωρημένα Δικαιώματα';
$lang['return_to_page'] = 'Πίσω στην Αρχική Σελίδα';
$lang['Use_default'] = 'Χρησιμοποίηση Προεπιλεγμέμων Ρυθμίσεων';

$lang['AdminCP_status'] = '<b>Έκθεση προόδου</b>';
$lang['AdminCP_action'] = '<b>Ενέργεια Β. Δεδομένων</b>';
$lang['Invalid_action'] = 'Μη έγκυρη Ενέργεια';
$lang['was_installed'] = 'Εγκαταστάθηκε.';
$lang['was_uninstalled'] = 'Απεγκατεστάθηκε.';
$lang['was_upgraded'] = 'Αναβαθμίστηκε';
$lang['was_exported'] = 'Εξήχθη';
$lang['was_deleted'] = 'Διαγράφτηκε';
$lang['was_removed'] = 'Αφαιρέθηκε';
$lang['was_inserted'] = 'Εισήχθη';
$lang['was_updated'] = 'Ενημερώθηκε';
$lang['was_added'] = 'Προστέθηκε';
$lang['was_moved'] = 'Μετακινήθηκε';
$lang['was_synced'] = 'Συγχρονίστηκε';

$lang['error_no_field'] = 'Υπάρχει ένας ελλείπων τομέας. Παρακαλώ συμπληρώστε όλους τους απαραίτητους τομείς.';

//
// Configuration
//
$lang['Portal_admin'] = 'Διαχείριση Portal';
$lang['Portal_admin_explain'] = 'Χρησιμοποιήστε αυτήν την ενότητα για να προσαρμόσετε το portal';
$lang['Portal_General_Config'] = 'Ρυθμίσεις Portal';
$lang['Portal_General_Config_explain'] = 'Χρησιμοποιήστε αυτήν την ενότητα για να διαχειριστείτε τις κύριες ρυθμίσεις του MX-Publisher portal.';
$lang['Portal_General_settings'] = 'Γενικές Ρυθμίσεις';
$lang['Portal_Style_settings'] = 'Ρυθμίσεις στυλ';
$lang['Portal_General_config_info'] = 'Γενικές πληροφορίες ρυθμίσεων Portal';
$lang['Portal_General_config_info_explain'] = 'Τρέχουσες πληροφορίες ρυθμίσεων απο το config.php (δεν απαιτείται επεξεργασία)';
$lang['Portal_Name'] = 'Ονομα Portal:';
$lang['Portal_PHPBB_Url'] = 'URL της τρέχουσας phpBB εγκατάστασης:';
$lang['Portal_Url'] = 'URL του MX-Publisher:';
$lang['Portal_Config_updated'] = 'Οι ρυθμίσεις του Portal ενημερώθηκαν επιτυχώς';
$lang['Click_return_portal_config'] = 'Πατήστε %sΕδώ%s για να επιστρέψετε στις Ρυθμίσεις του Portal';
$lang['PHPBB_info'] = 'Πληροφορίες PHP';
$lang['PHPBB_version'] = 'Τρέχετε την έκδοση phpBB:';
$lang['PHPBB_script_path'] = 'phpBB Script Path:';
$lang['PHPBB_server_name'] = 'phpBB Domain (server_name):';
$lang['MX_Portal'] = 'MX-Publisher';
$lang['MX_Modules'] = 'MXP Μονάδες';
$lang['Phpbb'] = 'phpBB';
$lang['Top_phpbb_links'] = 'Στατιστικές phpBB στην κεφαλή (Προεπιλογή)';
$lang['Top_phpbb_links_explain'] = '- Συνδέσμος με τα νέα, αδιάβαστες δημοσιεύσεις';
$lang['Portal_version'] = 'Έκδοση MX-Publisher:';
$lang['Mx_use_cache'] = 'Χρήση MX-Publisher Block Λανθάνουσας Μνήμης';
$lang['Mx_use_cache_explain'] = 'Block data is cached to individual cache/block_*.xml files. Block cache files are created/updated when blocks are edited.';
$lang['Mx_mod_rewrite'] = 'Χρησιμοποίησε mod_rewrite';
$lang['Mx_mod_rewrite_explain'] = 'Εάν χρησιμοποιείτε κεντρικό υπολογιστή Apache και έχετε ενεργοποιήσει mod_rewrite, μπορείτε να ξαναγράψετε URLS παραδείγματος χάριν, μπορείτε να ξαναγράψετε τις σελίδες όπως \'page=x\' με τις πιό διαισθητικές εναλλακτικές λύσεις. Παρακαλώ διαβάστε το σχετικό έγγραφο της μονάδας mx_mod_rewrite.';
$lang['Portal_Overall_header'] = 'Φάκελλος στην κεφαλή (Προεπιλογή)';
$lang['Portal_Overall_header_explain'] = '- Αυτή είναι η προεπιλογή της template overall_header file, π.χ. overall_header.tpl.';
$lang['Portal_Overall_footer'] = 'Γενικό αρχείο υποσημείωσης (Προεπιλογή)';
$lang['Portal_Overall_footer_explain'] = '- Αυτή είναι η προεπιλογή της template overall_footer file, π.χ. overall_footer.tpl.';
$lang['Portal_Main_layout'] = 'Βασική Διάταξη αρχείου (Προεπιλογή)';
$lang['Portal_Main_layout_explain'] = '- Αυτή είναι η προεπιλογή της template main_layout file, e.g. mx_main_layout.tpl.';
$lang['Portal_Navigation_block'] = 'Γενική πλοήγηση Block (Προεπιλογή)';
$lang['Portal_Navigation_block_explain'] = '- Αυτή είναι η σελίδα της πλοήγησης κεφαλής, υπό τον όρο ότι έχετε επιλέξει ένα γενικό αρχείο κεφαλής που υποστηρίζει η σελίδα πλοήγησης.';
$lang['Default_style'] = 'Στυλ Σελιδών Portal (Προεπιλογή)';
$lang['Default_admin_style'] = 'AdminCP Στυλ';
$lang['Select_page_style'] = "Επιλογή (ή χρησ. την Προεπιλογή)";
$lang['Override_style'] = 'Προτεραιότητα στο στυλ χρηστών';
$lang['Override_style_explain'] = 'Αντικαταστήστε το στυλ των χρηστών με την προεπιλογή (για σελίδες)';
$lang['Portal_status'] = 'Ενεργό portal';
$lang['Portal_status_explain'] = 'Διακόπτης, όταν ανακατασκευάζετε τις ιστοσελίδες σας. Μόνο οι Διαχειριστές είναι σε θέση να δουν τις σελίδες και να κάνουν πλοήγηση. Όταν τίθεται εκτός λειτουργίας, εμφανίζετε το κατωτέρω μήνυμα.';
$lang['Disabled_message'] = 'Απενεργοποιημένα μηνύματα Portal';
$lang['Portal_Backend'] = 'MX-Publisher User/Session backend';
$lang['Portal_Backend_explain'] = 'Επιλέξτε internal, phpBB2 ή phpBB3 συνοδία και χρήστες';
$lang['Portal_Backend_path'] = 'Σχετικό path για phpBB [όχι-internal]';
$lang['Portal_Backend_path_explain'] = 'Εαν χρησιμοποιείται non-internal συνοδία και χρήστες, εισάγεται το σχετικό path του phpbb, πχ \'phpBB2/\' ή \'../phpBB2/\'. Σημείωση: οι κάθετοι είναι σημαντικές.';
$lang['Portal_Backend_submit'] = 'Αλλαγή και επικύρωση Backend';
$lang['Portal_config_valid'] = 'Τρέχουσα Θέση Backend: ';
$lang['Portal_config_valid_true'] = '<b><font color="green">Έγκυρο</font></b>';
$lang['Portal_config_valid_false'] = '<b><font color="red">Bad Setup. Είτε το σχετικό path του phpBB είναι λάθος είτε phpBB είναι αποεγκατεστημένο (η βάση δεδομένων phpBB δεν είναι διαθέσιμη). Κατά συνέπεια, \'internal\' backend  χρησιμοποιείται.</font></b>';

//
// Module Management
//
$lang['Module_admin'] = 'Διαχείρηση Μονάδων';
$lang['Module_admin_explain'] = 'Χρησιμοποιήστε αυτήν την ενοτητα να διαχειριστείτε τις μονάδες: εγκατάσταση, αναβάθμιση και ανάπτυξη.<br /><b>Για να χρησιμοποιήσετε αυτό τον πίνακα, πρέπει να έχετε ενεργά JavaScript και στο browser που χρησιμοποιείτε!</b>';
$lang['Modulecp_admin'] = 'Πίνακας Ελεγχου Μονάδας';
$lang['Modulecp_admin_explain'] = 'Χρησιμοποιήστε αυτήν την ενότητα για να διαχειριστείτε τις ενότητες: block λειτουργίες (παράμερτοι) και portal blocks.<br /><b>Για να χρησιμοποιήσετε αυτό τον πίνακα, πρέπει να έχετε ενεργά JavaScript και στο browser που χρησιμοποιείτε!</b>';
$lang['Modules'] = 'Μονάδες';
$lang['Module'] = 'Μονάδα';
$lang['Module_delete'] = 'Διαγραφή της Μονάδας';
$lang['Module_delete_explain'] = 'Χρησιμοποιήστε αυτήν την ενότητα για να διαγράψετε την μονάδα (ή λειτουργεία block)';
$lang['Edit_module'] = 'Επεξεργασία Μονάδας';
$lang['Create_module'] = 'Δημιουργία Νέας Μονάδας';
$lang['Module_name'] = 'Ονομα Μονάδας';
$lang['Module_desc'] = 'Περιγραφή';
$lang['Module_path'] = 'Path, πχ. \'modules/mx_textblocks/\'';
$lang['Module_include_admin'] = 'Συμπεριλάβετε αυτή την μονάδα στο πίνακα πλοήγησης AdminCP';

//
// Module Installation
//
$lang['Module_delete_db'] = 'Θέλετε πραγματικά να απεγκαταστήσετε την μονάδα? Προειδοποίηση: Θα χάσετε όλα τα στοιχεία της μονάδας. Εξετάστε την αναβάθμιση αντί αυτού.';
$lang['Click_module_delete_yes'] = 'Πατήστε %sΕδώ%s να απεγκαταστήσετε την μονάδα';
$lang['Click_module_upgrade_yes'] = 'Πατήστε %sΕδώ%s να αναβαθμίσετε την μονάδα';
$lang['Click_module_export_yes'] = 'Πατήστε %sΕδώ%s να εξάγετε την μονάδα';
$lang['Error_no_db_install'] = 'Λάθος: Το αρχείο db_install.php δεν υπάρχει. Παρακαλώ ελέγξτετο και προσπαθήστε πάλι.';
$lang['Error_no_db_uninstall'] = 'Λάθος: Το αρχείο db_uninstall.php δεν υπάρχει, ή το χαρακτηριστικό της απεγκατάστασης δεν υποστηρίζεται για την μονάδα. Παρακαλώ ελέγξτετο και προσπαθήστε πάλι.';
$lang['Error_no_db_upgrade'] = 'Λάθος: Το αρχείο db_upgrade.php δεν υπάρχει, ή το χαρακτηριστικό της αναβάθμισης δεν υποστηρίζεται για την μονάδα. Παρακαλώ ελέγξτετο και προσπαθήστε πάλι.';
$lang['Error_module_installed'] = 'Λάθος: Αυτή η μονάδα έχει ήδη εγκατασταθεί! Παρακαλώ, είτε πρώτα διέγραψε την μονάδα αυτή ή αναβαθμίστε την.';
$lang['Uninstall_module'] = 'Απεγκατάσταση Μονάδας';
$lang['import_module_pack'] = 'Εγκατάσταση Μονάδας';
$lang['import_module_pack_explain'] = 'Αυτό θα εγκαταστήσει την μονάδα στο portal. Να είστε βέβαιος ότι το πακέτο της μονάδας αυτής έχει μεταφορτωθεί στο φάκελο των μονάδων. Θυμηθείτε να χρησιμοποιήσετε την πιό πρόσφατη έκδοση της μονάδας!';
$lang['upgrade_module_pack'] = 'Aναβάθμιση Μονάδας';
$lang['upgrade_module_pack_explain']= 'Αυτό θα αναβαθμίσει την μονάδα. Να είστε βέβαιος ότι έχετε διαβάσει τις οδηγίες  της μονάδας πριν προχωρήσετε, ή διακινδυνεύετε την απώλεια στοιχείων της μονάδας.';
$lang['export_module_pack'] = 'Μεταφόρτωση Μονάδας';
$lang['Export_Module'] = 'Επιλογή Μονάδας:';
$lang['export_module_pack_explain'] = 'Αυτό θα εξαγάγει το αρχειο της μονάδας *.pak. Αυτό προορίζεται για τους συγγραφείς της μονάδας, οι κανονικοί χρήστες δεν πρέπει να ανησυχήσουν για αυτό.';
$lang['Module_Config_updated'] = 'Η Παραμετροποίηση της Μονάδος αναβαθμίστηκε επιτυχώς';
$lang['Click_return_module_admin'] = 'Πατήστε %sΕδώ%s να επιστρέψετε στην Διαχείριση Μονάδων';
$lang['Module_updated'] = 'Οι Πληροφορίες της Μονάδος ενημερωθήκαν επιτυχώς';
$lang['list_of_queries'] = 'Αυτό είναι ο κατάλογος αποτελέσματος των ερωτήσεων SQL που απαιτούνται γιατί εγκαταστήστε/αναβαθμίσετε';
$lang['already_added'] = 'Λάθος ή Ήδη έχει προστεθεί';
$lang['added_upgraded'] = 'Προστέθηκε/Αναβαθμίστηκε';
$lang['upgrading_modules'] = 'Εάν εμφανίζονται μερικά λάθη, στα ήδη προστιθέμενα ή ενημερωμένα μηνύματα, μην ανησυχείτε, αυτό συμβαίνει κατά την ενημέρωση των μονάδων';
$lang['consider_upgrading'] = 'Η μονάδα έχει ήδη εγκατασταθεί...θεωρήστε την αναβαθμισμένη ;)';
$lang['upgrading'] = 'Αναβαθμίστηκε';
$lang['module_upgrade'] = 'Αυτή είναι αναβαθμισμένη';
$lang['nothing_upgrade'] = 'Δεν υπαρχει για αναβάθμιση...';
$lang['upgraded_to_ver'] = '...Τώρα αναβαθμίστηκε στην v. ';
$lang['module_not_installed'] = 'Η Μονάδα δεν εγκαταστάθηκε...επομένως δεν μπορεί να αναβαθμιστεί';
$lang['fresh_install'] = 'Αυτή είναι νέα εγκατάσταση';
$lang['module_install_info'] = 'Mod Εγκατάσταση/Αναβάθμιση/Απεγκατάσταση Πληροφορίες - mod συγκεκριμένα db πίνακες';

//
// Functions & Parameters Administration
//
$lang['Function_admin'] = 'Block Διαχείρισης Λειτουργιών';
$lang['Function_admin_explain'] = 'Οι μονάδες έχουν μια ή περισσότερες λειτουργίες block. Χρησιμοποιήστε αυτήν την ενότητα για επεξεργασία, πρόσθεση, ή διαγραφή των λειτουργιών του block';
$lang['Function'] = 'Block Λειτουργιών';
$lang['Function_name'] = 'Ονομασία Λειτουργιών Block';
$lang['Function_desc'] = 'Περιγραφή';
$lang['Function_file'] = 'Αρχείο ';
$lang['Function_admin_file'] = 'Αρχείο (Επεξεργασία block script) <br /> Πρόσθετες παράμετροι για αυτό τον πίνακα επεξεργασίας block. Αφήστε το κενό για να χρησιμοποιήσετε την προεπιλογή του πίνακα.';
$lang['Create_function'] = 'Προσθέστε νέο Block Λειτουργιών';
$lang['Delete_function'] = 'Διαγραφή Block Λειτουργιών';
$lang['Delete_function_explain'] = 'Αυτό θα διαγράψει τη λειτουργία και όλα τα συνδεόμενα portal blocks. Προσοχή: Η εκτέλεση  δεν μπορεί να αναστραφεί!';
$lang['Click_function_delete_yes'] = 'Πατήστε %sΕδώ%s για διαγραφή της Λειτουργίας';

$lang['Parameter_admin'] = 'Διαχείριση Λειτουργία Παράμετροι';
$lang['Parameter_admin_explain'] = 'Κατάλογος όλων των Παραμέτρων για αυτή την λειτουργία';
$lang['Parameter'] = 'Παράμετρος';
$lang['Parameter_name'] = '<b>Όνομα Παραμέτρου</b><br />- για να χρησιμοποιηθεί συνδεθείτε στην παράμετρο';
$lang['Parameter_type'] = '<b>Τύπος Παραμέτρου</b>';
$lang['Parameter_default'] = '<b>Προεπιλογές</b>';
$lang['Parameter_function'] = '<b>Λειτουργία/Επιλογές</b>';
$lang['Parameter_function_explain'] = '<b>Λειτουργία</b> (Όταν χρησιμοποιείς τον τύπο \'Λειτουργία\')<br />- Μπορείτε να περάσετε τα στοιχεία παραμέτρου προς εξωτερική λειτουργία <br /> για να παράγει την παράμετρο από τον τομέα.<br />- Για παράδειγμα: <br />get_list_formatted("block_list","{parameter_value}","{parameter_id}[]")';
$lang['Parameter_function_explain'] .= '<br /><br /><b>Επιλογή(ές)</b> (Όταν χρησιμοποιείς \'Επιλογή\' τύπο παραμέτρο)<br />- Για όλες τις επιλεγμένες παραμέτρους (radiobuttons, checkboxes και menus) όλες οι επιλογές παρατίθενται εδώ, μια επιλογή ανά γραμμή.';
$lang['Parameter_auth'] = '<b>Διαχ./Block Συντονηστής μόνο</b>';

$lang['Parameters'] = 'Παράμετροι';
$lang['Parameter_id'] = 'ID';
$lang['Create_parameter'] = 'Προσθέστε Νέα Παράμετρο';
$lang['Delete_parameter'] = 'Διαγράψετε Λειτουργία Παραμέτρου';
$lang['Delete_parameter_explain'] = 'Αυτό θα διαγράψει την παράμετρο και θα ενημερώσει όλα τα συνδεόμενα portal blocks. Προσοχή: Η εκτέλεση  δεν μπορεί να αναστραφεί!';
$lang['Click_parameter_delete_yes'] = 'Πατήστε %sΕδώ%s να διαγράψετε την Παράμετρο';

//
// Parameter Types
//
$lang['ParType_BBText'] = 'Απλό BBCode Textblock';
$lang['ParType_BBText_info'] = 'Αυτό είναι ένα απλό textblock που αναλύει BBCode';
$lang['ParType_Html'] = 'Απλό HTML Textblock';
$lang['ParType_Html_info'] = 'Αυτό είναι ένα απλό textblock, αναλύοντας το HTML';
$lang['ParType_Text'] = 'Απλό Κείμενο (μόνο-σειρά)';
$lang['ParType_Text_info'] = 'Αυτό είναι ένας απλός τομέας κειμένων';
$lang['ParType_TextArea'] = 'Πλήρης περιοχή κειμένου (πολλές-σειρές)';
$lang['ParType_TextArea_info'] = 'Αυτό είναι ένας πλήρης τομέας κειμένων';
$lang['ParType_Boolean'] = 'Boolean';
$lang['ParType_Boolean_info'] = 'Αυτό είναι \'ναί\' ή \'όχι\' radio switch.';
$lang['ParType_Number'] = 'Μόνο Αριθμοί';
$lang['ParType_Number_info'] = 'Αυτό είναι ένας απλός τομέας αριθμών';
$lang['ParType_Function'] = 'Λειτουργία παραμέτρου';
$lang['ParType_Values'] = 'Τιμές';

$lang['ParType_Radio_single_select'] = 'Μοναδική Επιλογή Radio Buttons';
$lang['ParType_Radio_single_select_info'] = '';
$lang['ParType_Menu_single_select'] = 'Μοναδική Επιλογή Menu';
$lang['ParType_Menu_single_select_info'] = '';
$lang['ParType_Menu_multiple_select'] = 'Πολλαπλή Επιλογή Menu';
$lang['ParType_Menu_multiple_select_info'] = '';
$lang['ParType_Checkbox_multiple_select'] = 'Πολλαπλή Επιλογή Checkbox';
$lang['ParType_Checkbox_multiple_select_info'] = '';

//
// Blocks Administration
//
$lang['Block_admin'] = 'Πίνακας Ελέγχου Block';
$lang['Block_admin_explain'] = 'Χρησιμοποιήστε αυτήν την ενότητα για να διαχειριστείτε τα portal blocks.<br /><b>Για να χρησιμοποιήσετε αυτό το πίνακα, πρέπει να έχετε JavaScript και cookies ενεργοποιημένα στον browser!</b>';
$lang['Block'] = 'Block';
$lang['Show_title'] = 'Προβολή Τίτλου Block?';
$lang['Show_title_explain'] = 'Προβολή ή όχι του Τίτλου του block';
$lang['Show_block'] = 'Προβολή Block?';
$lang['Show_block_explain'] = '- Εάν \'όχι\', το Block θα είναι κρυμμένο από όλους τους χρήστες, εκτός τους διαχειριστές';
$lang['Show_stats'] = 'Προβολή Στατιστικών?';
$lang['Show_stats_explain'] = '- Εάν \'ναι\', \'επεξεργάστηκε από...\' θα εμφανίζετε κάτω από το block';
$lang['Show_blocks'] = 'Προβολή Λειτουργιών Blocks';
$lang['Block_delete'] = 'Διαγράψτε το Block';
$lang['Block_delete_explain'] = 'Χρησιμοποιήστε αυτήν την ενότητα για να διαγράψετε το Block (ή κολόνα)';
$lang['Block_title'] = 'Τίτλος';
$lang['Block_desc'] = 'Περιγραφή';
$lang['Add_Block'] = 'Προσθέστε Νέο Block';
$lang['Auth_Block'] = 'ʼδειες';
$lang['Auth_Block_explain'] = 'ΟΛΟΙ: Όλοι οι χρήστες<br />ΕΓΓ: Εγγραμμένοι χρήστες<br />ΙΔΙΩΤΙΚΟ: Μέλη ομάδας (δείτε τις προηγμένες άδειες)<br />ΣΥΝ: block συντονιστών (δείτε τις προηγμένες άδειες)<br />ΔΙΑΧ.: Διαχειριστής<br />ΑΝΩΝΥΜΟΣ: Επισκέπτες μέλη ΜΟΝΟ';
$lang['Block_quick_stats'] = 'Γρήγορη Στατ.';
$lang['Block_quick_edit'] = 'Γρήγορη Επεξεργασία';
$lang['Create_block'] = 'Δημιουργήστε νέο Block';
$lang['Delete_block'] = 'Διαγράψτε Portal Block';
$lang['Delete_block_explain'] = 'Αυτό θα διαγράψει το block και θα ενημερώσει όλες τις σχετικές Σελίδες του Portal. Προσοχή: Η εκτέλεση  δεν μπορεί να αναστραφεί!';
$lang['Click_block_delete_yes'] = 'Πατήστε %sΕδώ%s να διαγράψετε το Block';

//
// BlockCP Administration
//
$lang['Block_cp'] = 'BlockCP';
$lang['Click_return_blockCP_admin'] = 'Πατήστε %sΕδώ%s να επιστρέψετε στο Πίνακα Ελέγχου Block';
$lang['Click_return_portalpage_admin'] = 'Πατήστε %sΕδώ%s να επιστρέψετε στην Σελίδα Portal';
$lang['BlockCP_Config_updated'] = 'Αυτό το block έχει ενημερωθεί.';

//
// Pages Administration
//
$lang['Page_admin'] = 'Σελίδα Διαχείρισης';
$lang['Page_admin_explain'] = 'Χρησιμοποιήστε αυτήν την ενότητα για να προσθέσετε, να διαγράψετε και να αλλάξετε τις ρυθμίσεις των Σελίων του Portal Pages and των Σελίδων Templates.<br /><b>Για να χρησιμοποιήσετε αυτό το πίνακα, πρέπει να έχετε JavaScript και cookies ενεργοποιημένα στον browser!</b>';
$lang['Page_admin_edit'] = 'Επεξεργασία Σελίδας';
$lang['Page_admin_private'] = 'Προχωρημένη σελίδα (ΙΔΙΩΤΙΚΩΝ) Αδειών';
$lang['Page_admin_settings'] = 'Σελίδα Ρυθμίσεων';
$lang['Page_admin_new_page'] = 'Νέα Σελιδα Διαχείρισης';
$lang['Page'] = 'Σελίδα';
$lang['Page_Id'] = 'Σελίδα ID';
$lang['Page_icon'] = 'Εικόνα Σελίδας <br /> - για να χρησιμοποιηθεί στο adminCP only, πχ. icon_home.gif (προεπιλογή)';
$lang['Page_alt_icon'] = 'Εναλλακτική Εικόνα Σελίδας <br /> - Πλήρης url (http://...) στην σελίδα της εικόνας.';
$lang['Default_page_style'] = 'Στυλ Portal (προεπιλογή)<br />Να χρησιμοποιήσετε τις προεπιλεγμένες ρυθμίσεις, αφήστε το κενό.';
$lang['Override_page_style'] = 'Το στυλ του χρήστη έχει προτεραιότητα';
$lang['Override_page_style_explain'] = ' ';
$lang['Page_header'] = 'Αρχείο σελίδων κεφαλής <br /> - i.e. overall_header.tpl (προεπιλογή), overall_noheader.tpl (καμία επιγραφή) ή προσαρμοσμένο από τον χρήστη.<br />Για να χρησιμοποιήσετε την προεπιλογή, αφήστε το κενό.';
$lang['Page_footer'] = 'Αρχείο υποσημείωσης σελίδων <br /> - i.e. overall_footer.tpl (προεπιλογή) ή προσαρμοσμένο από τον χρήστη.<br />Για να χρησιμοποιήσετε την προεπιλογή, αφήστε το κενό.';
$lang['Page_main_layout'] = 'Κύριο αρχείο διάταξης σελίδων <br /> - i.e. mx_main_layout.tpl (προεπιλογή) ή προσαρμοσμένο από τον χρήστη.<br />Για να χρησιμοποιήσετε την προεπιλογή, αφήστε το κενό.';
$lang['Page_Navigation_block'] = 'Block πλοήγησης στην αρχή της Σελίδας';
$lang['Page_Navigation_block_explain'] = '- Αυτό είναι ένα block πλοήγησης στην κεφαλή, υπό τον όρο ότι έχετε επιλέξει ένα γενικό αρχείο επιγραφών που υποστηρίζει τη σελίδα πλοήγησης.<br />Για να χρησιμοποιήσετε την προεπιλογή, αφήστε το αδιάτακτο.';
$lang['Auth_Page'] = 'Άδειες';
$lang['Select_sort_method'] = 'Επιλέξτε την μέθοδο τακτοποίησης';
$lang['Order'] = 'Εντολή';
$lang['Sort'] = 'Τύπος';
$lang['Page_sort_title'] = 'Τίτλος Σελίδας';
$lang['Page_sort_desc'] = 'Περιγραφή Σελίδας';
$lang['Page_sort_created'] = 'Η Σελίδα Δημιουργήθηκε';
$lang['Sort_Ascending'] = 'ΑΥΞ';
$lang['Sort_Descending'] = 'ΦΘΙΝ';
$lang['Return_to_page'] = 'Επιστροφή Portal Page';
$lang['Auth_Page_group'] = '-> ΙΔΙΩΤΙΚΗ Ομάδα';
$lang['Page_desc'] = 'Περιγραφή';
$lang['Page_parent'] = 'Γονική Σελίδα';
$lang['Add_Page'] = 'Προσθέστε Νέα Σελίδα';
$lang['Page_Config_updated'] = 'Η Διαμόρφωση της Σελίδας ενημερώθηκε επιτυχώς';
$lang['Click_return_page_admin'] = 'Πατήστε %sΕδώ%s να επιστρέψετε στην Σελίδα Διαχείρισης';
$lang['Remove_block'] = 'Αφαιρέστε Portal Block';
$lang['Remove_block_explain'] = 'Αυτό θα αφαιρέσει το block από αυτήν την σελίδα. Προσοχή: Η εκτέλεση  δεν μπορεί να αναστραφεί!';
$lang['Click_block_remove_yes'] = 'Πατήστε %sΕδώ%s να αφαιρέσετε το Block';
$lang['Delete_page'] = 'Διαγραφή Σελίδας';
$lang['Delete_page_explain'] = 'Αυτό θα διαγράψει τη σελίδα. Προσοχή: Η εκτέλεση  δεν μπορεί να αναστραφεί!';
$lang['Click_page_delete_yes'] = 'Πατήστε %sΕδώ%s να διαγράψετε την Σελίδα';

$lang['Mx_IP_filter'] = 'IP Φίλτρα';
$lang['Mx_IP_filter_explain'] = 'Για να περιορίσετε την πρόσβαση σε αυτήν την σελίδα από τη IP, εισάγετε την έγκυρη IP διεύθυνση, μια διεύθυνση IP ανά γραμμή.<br>Παράδειγμα: 127.0.0.1 or 127.1.*.*';
$lang['Mx_phpBB_stats'] = 'phpBB Στατιστικές στην Κεφαλή';
$lang['Mx_phpBB_stats_explain'] = '- Συνδέσεις με τα Νέα, αδιάβαστες Δημοσιεύσεις, κλπ.';
$lang['Column_admin'] = 'Διαχείριση Κολονων Σελίδας';
$lang['Column_admin_explain'] = 'Διαχειριστείτε τις Κολόνες Σελίδας';
$lang['Column'] = 'Κολόνα Σελίδας';
$lang['Columns'] = 'Κολόνες Σελίδας';
$lang['Column_block'] = 'Σελίδα Κολόνα Block';
$lang['Column_blocks'] = 'Σελίδες Κολόνες Blocks';
$lang['Edit_Column'] = 'Επεξεργασία Κολόνας';
$lang['Edit_Column_explain'] = 'Χρησιμοποιήστε αυτήν την ενότητα για να τροποποιήσετε την κολόνα';
$lang['Column_Size'] = 'Μέγεθος της κολόνας';
$lang['Column_name'] = 'Όνομα Κολόνας';
$lang['Column_delete'] = 'Διαγραφή Κολόνας';
$lang['Page_updated'] = 'Σελίδα και πληροφορίες κολόνων ενημερωθήκαν επιτυχώς';
$lang['Create_column'] = 'Προσθέστε νέα Κολόνα';
$lang['Delete_page_column'] = 'Διαγραφή κολόνας της Σελίδας ';
$lang['Delete_page_column_explain'] = 'Αυτό θα διαγράψει τη κολόνα της σελίδας. Προσοχή: Η εκτέλεση  δεν μπορεί να αναστραφεί!';
$lang['Click_page_column_delete_yes'] = 'Πατήστε %sΕδώ%s να διαγράψετε την κολόνα της σελίδας ';

//
// Page templates
//
$lang['Page_templates_admin'] = 'Διαχείριση Σελίδων Templates';
$lang['Page_templates_admin_explain'] = 'Χρησιμοποιήστε αυτήν την σελίδα για να δημιουργήσετε, να επεξεργαστείτε ή να διαγράψετε τις Σελίδες Templates';
$lang['Page_template'] = 'Σελίδα Template';
$lang['Page_templates'] = 'Σελίδες Templates';
$lang['Page_template_column'] = 'Page Template Column';
$lang['Page_template_columns'] = 'Page Template Columns';
$lang['Choose_page_template'] = 'Επιλογή Σελίδας Template';
$lang['Template_Config_updated'] = 'Αναβαθμιστήκαν οι ρυθμίσεις Template';
$lang['Add_Template'] = 'Προσθέστε Νέα Template';
$lang['Template'] = 'Template';
$lang['Template_name'] = 'Όνομα Template';
$lang['Page_template_delete'] = 'Διαφραφή Template';
$lang['Delete_page_template'] = 'Διαγραφή Σελίδας Template';
$lang['Delete_page_template_explain'] = 'Αυτό θα διαγράψει την σελίδα Template. Προσοχή: Η εκτέλεση  δεν μπορεί να αναστραφεί!';
$lang['Click_page_template_delete_yes'] = 'Πατήστε %sΕδώ%s για να διαγράψετε την Σελίδα Template';
$lang['Delete_page_template_column'] = 'Διαγραφή Σελίδας Template';
$lang['Delete_page_template_column_explain'] = 'Αυτό θα διαγράψει την σελίδα Template. Προσοχή: Η εκτέλεση  δεν μπορεί να αναστραφεί!';
$lang['Click_page_template_column_delete_yes'] = 'Πατήστε %sΕδώ%s για να διαγράψετε την Κολόνα Template';

//
// Cache
//
$lang['Cache_dir_write_protect'] = 'Ο κατάλογος της λανθάνουσας μνήμης είναι προστατευμένος έναντι εγγραφής. MX-Publisher είναι ανίκανος να παραγάγει το αρχείο της λανθάνουσας μνήμης. Παρακαλώ καταστήστε τον κατάλογο της λανθάνουσας μνήμης εγγραφόμενο  για να συνεχίσετε.';
$lang['Cache_generate'] = 'Πραγματοποιήθηκε η εκκαθάριση των αρχείων της Λανθάνουσας Μνήμης.';
$lang['Cache_submit'] = 'Εκκαθάριση αρχείων Λανθάνουσας Μνήμης?';
$lang['Cache_explain'] = 'Με αυτήν την επιλογή μπορείτε να καθαρίσετε όλα τα αρχεία της λανθάνουσας μνήμης (XMLs files) με την μια για όλα portal blocks. Αυτά τα αρχεία επιτρέπουν την μείωση του αριθμού αναζητήσεων στην βάση δεδομένων και βελτιώνει συνολικά την απόδοση του portal. <br />Note: the MX-Publisher cache must be enabled (in the Portal General Admin CP) for these files to be used by the system.<br>Further note: the cache files are created on the fly when editing blocks as well.';
$lang['Generate_mx_cache'] = 'Εκκαθάριση Λανθάνουσας Μνήμης Block';

//
// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!
//
$lang['Menu_Navigation'] = 'Επιλογές Πλοήγησης';
$lang['Portal_index'] = 'Αρχική Portal';
$lang['Save_Settings'] = 'Αποθήκευση Ρυθμίσεων';
$lang['Translation_Tools'] = 'Εργαλεία Μετάφρασης';
$lang['Preview_portal'] = 'Προεπισκόπηση Portal';

//
// META
//
$lang['Meta_admin'] = 'Διαχείριση META Tags';
$lang['Mega_admin_explain'] = 'Χρησιμοποιήστε αυτήν την ενότητα για να προσαρμόσετε τα META tags';
$lang['Meta_Title'] = 'Τίτλος';
$lang['Meta_Author'] = 'Συντάκτης';
$lang['Meta_Copyright'] = 'Πνευματικά δικαιώματα';
$lang['Meta_Keywords'] = 'Λέξεις κλειδιά';
$lang['Meta_Keywords_explain'] = '(κόμμα  χωρίζει τον κατάλογο)';
$lang['Meta_Description'] = 'Περιγραφή';
$lang['Meta_Language'] = 'Κωδικός Γλώσσας';
$lang['Meta_Rating'] = 'Αξιολόγηση';
$lang['Meta_Robots'] = 'Robots';
$lang['Meta_Pragma'] = 'Pragma no-cache';
$lang['Meta_Bookmark_icon'] = 'Εικόνα Bookmark';
$lang['Meta_Bookmark_explain'] = '(σχετική θέση)';
$lang['Meta_HTITLE'] = 'Πρόσθετες τοποθετήσεις επιγραφών';
$lang['Meta_data_updated'] = 'Meta data αρχείο (mx_meta.inc) έχει ενημερωθεί!<br />Πατήστε %sΕδώ%s Να επιστρέψετε στην Διαχείριση των Meta Tags.';
$lang['Meta_data_ioerror'] = 'Ανίκανο να ανοίξει mx_meta.inc. Σιγουρευτείτε ότι το αρχείο είναι εγγραφόμενο (chmod 777).';

//
// Portal permissons
//
$lang['Mx_Block_Auth_Title'] = 'Ιδιωτικές Άδειες Block' ;
$lang['Mx_Block_Auth_Explain'] = 'Εδώ μπορείτε να διαμορφώσετε τις Ιδιωτικές ʼδειες Block';
$lang['Mx_Page_Auth_Title'] = 'Σελίδα Ιδιωτικών Άδειών' ;
$lang['Mx_Page_Auth_Explain'] = 'Εδώ διαμορφώνετε τις ρυθμίσεις των Ιδιωτικών Αδειών Block';
$lang['Block_Auth_successfully'] = 'Η Άδεια των Block ενημερώθεικε επιτυχώς';
$lang['Click_return_block_auth'] = 'Πατήστε %sΕδώ%s να επιστρέψετε στις Ιδιωτικές ʼδειες Block';
$lang['Page_Auth_successfully'] = 'Η Σελίδα Ιδιωτικών Αδειών ενημερώθεικε επιτυχώς';
$lang['Click_return_page_auth'] = 'Πατήστε %sΕδώ%s να επιστρέψετε στις Ιδιωτικές ʼδειες Block';
$lang['AUTH_ALL'] = 'ΟΛΟΙ';
$lang['AUTH_REG'] = 'ΜΕΛΗ';
$lang['AUTH_PRIVATE'] = 'ΙΔΙΩΤΙΚΟ';
$lang['AUTH_MOD'] = 'MOD';
$lang['AUTH_ADMIN'] = 'ΔΙΑΧ.';
$lang['AUTH_ANONYMOUS'] = 'ΕΠΙΣΚΕΠΤΕΣ';

// -----------------------------------
// BlockCP - Block Parameter Specific
// -----------------------------------

//
// General
//
$lang['target_block'] = 'Target Block';
$lang['target_block_explain'] = '- οι συνδέσεις, τα στοιχεία κ.λπ. αναφέρονται με αυτό το block';

//
// Split column
//
$lang['block_ids'] = 'Πηγή Blocks';
$lang['block_ids_explain'] = '- για να τοποθετηθεί αριστερά στο δικαίωμα';
$lang['block_sizes'] = 'Μεγέθη Block (χωρίζεται με κόμμα)';
$lang['block_sizes_explain'] = '- Μπορείτε να καθορίσετε το μέγεθος χρησιμοποιώντας τους αριθμούς (pixels), ποσοστά (σχετικά μεγέθη, ie. \'40%\') or \'*\' για το υπόλοιπο.';
$lang['space_between'] = 'Διάστημα μεταξύ των Blocks';

//
// Sitelog
//
$lang['log_filter_date'] = 'Φίλτρα ανά ώρα';
$lang['log_filter_date_explain'] = '- Παρουσιάστε τις εισόδους ανά τελευταία εβδομάδα, μήνα, έτος...';
$lang['numOfEvents'] = 'Αριθμός';
$lang['numOfEvents_explain'] = '- Αριθμός γεγονότων προς παρουσίαση';

//
// IncludeX
//
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

//
// Dynamic Block
//
$lang['default_block_id'] = 'Προεπιλεγμένο Block';
$lang['default_block_id_explain'] = '- Αυτό είναι η προεπιλογή ή το block προς προβολή, εκτός αν τίθεται ένα dynamic block';

//
// Menu Navigation
//
//$lang['menu_display_style'] = 'Menu Style';
//$lang['menu_display_style_explain '] = 'Standard, Simple, Advanced or Advanced App';
$lang['menu_display_mode'] = 'Τρόπος Προβολής';
$lang['menu_display_mode_explain '] = 'Οριζόντια ή Κάθετη προβολή';
//$lang['menu_page_sync'] = 'Highlight current?';
//$lang['menu_page_sync_explain'] = 'Highlight current Navigation Menu entry...';
$lang['menu_custom_tpl']				= "Αρχείο template";
$lang['menu_custom_tpl_explain ']		= "Πχ mx_menu_custom.tpl";

//
// Version Checker
//
$lang['mxBB_Version_up_to_date'] = 'Η εγκατάσταση του MX-Publisher είναι ενημερωμένη. Καμία αναβάθμιση δεν είναι διαθέσιμη για την έκδοση του MX-Publisher.';
$lang['mxBB_Version_outdated'] = 'Η εγκατάσταση του MX-Publisher <b>δεν</b> φαίνεται να είναι ενημερωμένη. Αναβαθμίσεις είναι διαθέσιμες για την έκδοση του MX-Publisher. Παρακαλώ επισκεφτείτε <a href="http://www.mx-publisher.com/index.php?page=4&action=file&file_id=2" target="_new">the MX-Publisher Core package download</a> για να αποκτήσετε την πιο πρόσφατη έκδοση.';
$lang['mxBB_Latest_version_info'] = 'Η πιό πρόσφατη διαθέσιμη έκδοση είναι <b>MX-Publisher %s</b>. ';
$lang['mxBB_Current_version_info'] = 'Τρέχετε <b>MX-Publisher %s</b>.';
$lang['mxBB_Mailing_list_subscribe_reminder'] = 'Για τις πιο πρόσφατες πληροφορίες για ειδήσεις και αναβαθμίσεις του, γιατί όχι <a href="http://lists.sourceforge.net/lists/listinfo/mxbb-news" target="_new">εγγραφείτε στον κατάλογο αλληλογραφίας</a>?';

//
// That's all Folks!
// -------------------------------------------------
?>