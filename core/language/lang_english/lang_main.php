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
 *    $Id: lang_main.php,v 1.2 2010/10/14 01:52:52 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */
 
// 
// The format of this file is: 
// 
// ---> $lang["message"] = "text"; 
// 
// Specify your language character encoding... [optional]
// 
// setlocale(LC_ALL, "en"); 

// Menu_nav.php
$lang['Home Page']              = "Portal Home";
$lang['Announcements']          = "Announcements";   
$lang['Forum']                  = "Forum";
$lang['Main Menu']              = "Main Menu";
$lang['Module Statistics']      = "Statistics"; 
$lang['Send a Private message'] = "Send Private message";
$lang['Edit your Profile']      = "Edit Your Profile";

$lang['Portal_lang']            = "LanguageCP";  // Blocktitle
$lang['SELECTGUILANG']          = "Select Language:";

$lang['Change']                 = "Change now"; 
$lang['Change_default_style']   = "Set Board Default Style"; 
$lang['Change_user_style']      = "Set Your Style"; 

$lang['Change_default_lang']   	= "Set Board Default Language"; 
$lang['Change_user_lang']      	= "Set Your Language"; 

$lang['Block_Title']            = "Title";
$lang['Block_Info']             = "Information";

$lang['Theme']                  = "Theme/Style CP";  // Blocktitle
$lang['SelectTheme']            = "Select Theme/Style:";

$lang['Surveys/Polls']          = "Surveys/Polls";
$lang['Already_voted']          = "You have already voted";
$lang['Click_view_voted']       = "Click %sHere%s to view the results";

$lang['Annonce_sent']           = "The announcement has been sent";
$lang['Annonce_Deleted']        = "The announcement has been deleted";

$lang['Block_Config_updated']   = "Block Configuration updated successfully";
$lang['Block_Edit']             = "Edit Block";
$lang['Block_Edit_dyn']         = "Edit parent dynamic block";
$lang['Block_Edit_sub']         = "Edit parent split block";

//
// New for v. 2.704
//

$lang['Page_Not_Authorised']    = "Sorry, but you are not authorized to access this page.";

//
// New for v. 2.705
//

$lang['Execution_Stats'] 		= "Page generated %s queries - Generation time: %s seconds";

//
// New for v. 2.7.3
//

$lang['Redirect_login']    		= "Click %sHere%s to login.";

//
// New for v. 2.7.4 - 2.8
//
$lang['Show_admin_options']    	= "Show/Hide Page Admin Options: ";
$lang['Hidden_block'] 			= "Hidden block...";
$lang['Hidden_block_explain'] 	= "This block is 'hidden', but visible since you're an administrator or moderator.";

$lang['General_updated_return_settings'] 	= "Configuration updated successfully...<br /><br />Click %shere%s to continue."; // %s's for URI params - DO NOT REMOVE
$lang['General_update_error'] 				= "Couldn't update configuration...";

$lang['Mx_Page'] 				= "Page";
$lang['Mx_Block'] 				= "Section";

$lang['Mx_search_site'] 		= "Site";
$lang['Mx_search_forum'] 		= "Forum";
$lang['Mx_search_kb'] 			= "Articles";
$lang['Mx_search_pafiledb'] 	= "Downloads";
$lang['Mx_search_google'] 		= "Google";
$lang['Mx_new_search'] 			= 'New Search';

$lang['Block_updated_by'] 		= "Updated by ";
$lang['No_items_found'] 		= "Nothing new to report. ";

$lang['Powered_by'] 			= "Powered by ";
$lang['Modules_copy'] 			= "and mxBB Modules ";

$lang['mx_copy_text'] 			= '<b>mxBB - Modular Portal & CMS for phpBB!</b> <br /><br/> mxBB is a fully modular portal and CMS for phpBB, featuring dynamic pages, blocks, and themes, by means of a powerful yet flexible AdminCP. It works without touching phpBB by using integrated functions and features. mxBB-Portal is the classical phpBB portal add-on, improved and enhanced for every phpBB version released since 2001. <br /><br />Authors: The mxBB Development Team. <br />Please visit <a href="http://www.mx-publisher.com/">www.mx-publisher.com</a> for further information.';
$lang['mx_modules_text'] 		= '<b>mxBB Modules</b>';

$lang['mx_copy'] 				= 'mxBB Copyright Info';

$lang['Yes'] 					= 'Yes';
$lang['No'] 					= 'No';

$lang['Please_remove_install_contrib'] = 'Please ensure both the install/ and contrib/ directories are deleted';

//
// That's all Folks!
// -------------------------------------------------

?>