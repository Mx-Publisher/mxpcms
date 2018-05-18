<?php
/**
*
* @package MX-Publisher Module - mx_errordocs
* @version $Id: lang_admin.php,v 1.3 2010/10/16 04:06:54 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

//
// ErrorDocs v.1.0.0
//
$lang['ErrorDocs'] = "ErrorDocs";
$lang['Log_Management'] = "Log Management";
$lang['Log_Management_Explain'] = "Use this form to review and/or delete HTTP Error Log records.";
$lang['Display_Records'] = "Display records from previous";
$lang['All_Records'] = "All Records";
$lang['Are_you_sure'] = "Are you sure?";
$lang['Log_Settings'] = "Log Settings";

// -----------------------------------
// Block Parameter Specific
// -----------------------------------
$lang['ErrorDocs_Enable_Log'] = "Enable Log";
$lang['ErrorDocs_Enable_Log_explain'] = "Use this parameter to enable or disable the Log (ie. ignore <b>errlog=yes</b>).";
$lang['ErrorDocs_Include_Codes'] = "Include Codes";
$lang['ErrorDocs_Include_Codes_explain'] = "HTTP Error Codes (comma separated list) to Log. All errors logged by default.";
$lang['ErrorDocs_Exclude_Extensions'] = "Exclude Extensions";
$lang['ErrorDocs_Exclude_Extensions_explain'] = "File extensions (comma separated list) to ignore from filling the Log (ie. gif,jpg).";
$lang['ErrorDocs_Max_Records'] = "Max Log Records";
$lang['ErrorDocs_Max_Records_explain'] = "Use this parameter to set the maximum number of Log records to keep.";

//
// That's all Folks!
// -------------------------------------------------
?>