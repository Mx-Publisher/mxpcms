<?php
/**
*
* @package Mx-Publisher Module - mx_phpbb
* @version $Id: lang_admin.php,v 1.2 2010/10/16 04:07:51 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] Mx-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

$lang['mx_forum_admin'] = 'Mx-Publisher Forum Integration';
$lang['mx_forum_admin_explain'] = 'Here, you can do phpBB and Mx-Publisher page mappings.<br />If you run the module with fixed mappings, you only have to use ONE mx_phpbb block, and place this on every Mx-Publisher page with phpBB mappings. If you intend to split phpBB and run different forums on different Mx-Publisher pages, you need one mx_phpbb block for each subinstance.';

//
// phpBB
//
$lang['Cat_all'] = 'All';

$lang['phpbb_config_updated'] = 'phpBB Plugin Configuration Updated Successfully.';
$lang['Click_return_phpbb_config'] = 'Click %sHere%s to return to phpBB Plugin Configuration';

//
// Pages
//
$lang['phpbb_index']		= 'Index';
$lang['phpbb_viewforum']	= 'Viewforum';
$lang['phpbb_viewtopic']	= 'Viewtopic';

$lang['phpbb_faq']			= 'FAQ';
$lang['phpbb_groupcp']		= 'GroupCP';
$lang['phpbb_login']		= 'Login';
$lang['phpbb_memberlist']	= 'Memberlist';
$lang['phpbb_modcp']		= 'ModCP';
$lang['phpbb_posting']		= 'Posting';
$lang['phpbb_privmsg']		= 'Privmsg';
$lang['phpbb_profile']		= 'Profile';
$lang['phpbb_search']		= 'Search';
$lang['phpbb_viewonline']	= 'View Online';

$lang['phpbb_other']		= 'Other phpBB pages';

$lang['phpbb_explain']	= 'Fixed mapping, or default mapping (if using block settings)';

$lang['submit']		= 'Submit';
$lang['reset']		= 'Reset';

$lang['default_pages_title'] = 'Mx-Publisher and phpBB integration';
$lang['default_pages_title_explain'] = '';

$lang['default_pages_more_title'] = 'More phpBB mappings...';
$lang['default_pages_more_title_explain'] = '';

$lang['default_pages_profilecp'] = 'If you have the ProfileCP module installed, you can do the page mapping here (instead of editing the phpBB files directly)';

$lang['phpbb_integration_enabled'] = 'Activate the phpBB module?';
$lang['phpbb_integration_enabled_explain'] = 'When the phpBB module is activated, all phpBB URLs will be directed to Mx-Publisher pages. If deactivated, phpBB will operate "as usual", independently of Mx-Publisher';

$lang['phpbb_integration_enabled_yes'] = 'Activate';
$lang['phpbb_integration_enabled_no'] = 'Do not use this module';

$lang['phpbb_override'] = 'Associate phpBB and Mx-Publisher pages';
$lang['phpbb_override_explain'] = 'phpBB urls are redirected to Mx-Publisher pages following these settings.<br /> If using "Block Settings", be sure to edit the phpBB blocks themselves.';

$lang['phpbb_override_yes'] = 'Use Block Settings';
$lang['phpbb_override_no'] = 'Use fixed mappings (see below)';

$lang['Group_Home'] = 'All groups';
?>