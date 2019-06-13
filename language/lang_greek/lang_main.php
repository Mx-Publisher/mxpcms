<?php
/**
*
* @package MX-Publisher Core
* @version $Id: lang_main.php,v 1.41 2008/06/18 11:37:47 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

/*
 Translation:	Ελληνικά(Greek)
 Translator:  "georges georgiou" <giorgio_athens@hotmail.com>
*/

//
// The format of this file is:
//
// ---> $lang['message'] = 'text';
//
// Specify your language character encoding... [optional]
//
// setlocale(LC_ALL, 'en');

//
// General
//
$lang['Page_Not_Authorised'] = 'Συγνώμη, αλλά δεν έχετε πρόσβαση σε αυτήν την σελίδα.';
$lang['Execution_Stats'] = 'Σελίδα παράγεται σε %s queries - Χρόνος παραγωγής: %s δευτερόλεπτα';
$lang['Redirect_login'] = 'Πατήστε %εδώ%s για είσοδο.';
$lang['Show_admin_options'] = 'Παρουσιάση/αποκρύψη επιλογές Διαχ. σελίδων: ';
$lang['Block_updated_date'] = 'Ενημερώθηκε ';
$lang['Block_updated_by'] = 'από ';
$lang['Page_updated_date'] = 'Αυτλη η σελίδα έχει ενημερωθεί ';
$lang['Page_updated_by'] = 'από ';
$lang['Powered_by'] = 'Υποστηριζόμενος από ';

$lang['mx_spacer'] = 'Πλήκτρο διαστήματος';
$lang['Yes'] = 'Ναι';
$lang['No'] = 'Οχι';

$lang['Link'] = 'Σύνδεσμος';

$lang['Hidden_block'] = 'Κρυμμένο block';
$lang['Hidden_block_explain'] = 'Αυτό το block είναι \'κρυμμένο\', αλλά ορατό σε σας δεδομένου ότι έχετε τα κατάλληλα δικαιώματα.';

//
// Overall Navigation Navigation
//
$lang['MX_home'] = 'Αρχική Σελίδα';
$lang['MX_forum'] = 'Δημόσια Συζήτηση';
$lang['MX_navigation'] = 'Pages navigation, eg. forum navigation, like pafiledb navigation.';	

//
// Core Blocks - Language
//
$lang['Change_default_lang'] = 'Ορίστε τη προεπιλεγμένη γλώσσα του Board';
$lang['Change_user_lang'] = 'Ορίστε τη γλώσσα';
$lang['Portal_lang'] = 'Γλώσσα';
$lang['Select_lang'] = 'Επιλογή γλώσσας:';

//
// Core Blocks - Theme
//
$lang['Change'] = 'Αλλαγή τώρα';
$lang['Change_default_style'] = 'Ορίστε το προεπιλεγμένο Board Στυλ';
$lang['Change_user_style'] = 'Ορίστε το Στυλ σας';
$lang['Theme'] = 'ΘέμαCP/ΣτυλCP';
$lang['Select_theme'] = 'Επιλογή Θέματος/Στύλ:';

//
// Core Blocks - Search
//
$lang['Mx_Page'] = 'Σελίδα';
$lang['Mx_Block'] = 'Τμήμα';

//
// Core Blocks - Virtual
//
$lang['Virtual_Create_new'] = 'Δημιουργήστε νέο ';
$lang['Virtual_Create_new_user'] = 'Σελίδα χρήστη';
$lang['Virtual_Create_new_group'] = 'Σελίδα ομάδας';
$lang['Virtual_Create_new_project'] = 'Σχεδιαζόμενη Σελίδα';
$lang['Virtual_Create'] = 'Δημιουργήστε τώρα';
$lang['Virtual_Edit'] = 'Ενημερώστε το όνομα της σελίδας';
$lang['Virtual_Delete'] = 'Διαγράψτε αυτήν την σελίδα';

$lang['Virtual_Welcome'] = 'Καλώς Ήλθατε ';
$lang['Virtual_Info'] = 'Εδώ μπορείτε να ελέγξετε ιδιωτική ιστοσελίδας σας.';
$lang['Virtual_CP'] = 'Σελίδα Ελέγχου';
$lang['Virtual_Go'] = 'Πηγαίνετε';
$lang['Virtual_Select'] = 'Επιλογή:';

//
// Core Blocks - Site Log (and many last 'item' blocks)
//
$lang['No_items_found'] = 'Τίποτα νεότερο για αναφορά. ';

//
// BlockCP
//
$lang['Block_Title'] = 'Τίτλος';
$lang['Block_Info'] = 'Πληροφορίες';

$lang['Block_Config_updated'] = 'Η διαμόρφωση του Block ενημερώθηκε επιτυχώς.';
$lang['Edit'] = 'ΕΠΕΞΕΡΓΑ';
$lang['Block_Edit'] = 'Επεξεργασία Block';
$lang['Block_Edit_dyn'] = 'Επεξεργασία μητρικού dynamic block';
$lang['Block_Edit_sub'] = 'Επεξεργασία μητρικού χωρισμένου block';

$lang['General_updated_return_settings'] = 'Η διαμόρφωση ενημερώθηκε επιτυχώς.<br /><br />Πατήστε %εδώ%s να συνεχίσετε.'; // %s's for URI params - DO NOT REMOVE
$lang['General_update_error'] = 'Δεν ενημερώθηκαν οι διαμορφώσεις.';

//
// Header
//
$lang['Mx_search_site'] = 'Ιστοσελίδα';
$lang['Mx_search_forum'] = 'Δημόσια Συζήτηση';
$lang['Mx_search_kb'] = 'ʼρθρα';
$lang['Mx_search_pafiledb'] = 'Μεταφορτώσεις';
$lang['Mx_search_google'] = 'Google';
$lang['Mx_new_search'] = 'Νέα Αναζήτηση';

//
// Copyrights page
//
$lang['mx_about_title'] = 'Σχετικά με το MX-Publisher';
$lang['mx_copy_title'] = 'Πληροφορίες για το MX-Publisher';
$lang['mx_copy_modules_title'] = 'Εγκαταστημένες Μονάδες MX-Publisher';
$lang['mx_copy_template_title'] = 'Σχετικά με το Στυλ';
$lang['mx_copy_translation_title'] = 'Σχετικά με την μετάφραση';

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
$lang['TRANSLATION_INFO_MXBB'] = 'Greek Language by <a href="http://mxpcms.sourceforge.net//index.php?page=2&phpbb_script=profile&mode=viewprofile&u=8128" target="_blank">georges</a>';

//
// Installation
//
$lang['Please_remove_install_contrib'] = 'Παρακαλώ βεβαιωθείτε ότι και τα δύο το install/ και contrib/ κατάλογοι έχουν διαγραφεί.';

//
// Multilangual page titles
// - To have multilangual page titles, add lang keys 'pagetitle_PAGE_TITLE' below
// - This lang key replaces the page title (PAGE_TITLE) for the page given in the adminCP
//
//$lang['pagetitle_NameOfFirstPage'] = 'Whatever one';
//$lang['pagetitle_NameOfSecondPage'] = 'Whatever two';

//
// Multilangual block titles
// - To have multilangual block titles, add lang keys 'blocktitle_BLOCK_TITLE' below
// - This lang key replaces the block title (BLOCK_TITLE) for the block given in the adminCP/blockCP
//
//$lang['blocktitle_NameOfFirstPage'] = 'Whatever one';
//$lang['blocktitle_NameOfSecondPage'] = 'Whatever two';

//
// That's all Folks!
// -------------------------------------------------
?>