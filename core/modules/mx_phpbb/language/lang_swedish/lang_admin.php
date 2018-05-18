<?php
/**
*
* @package MX-Publisher Module - mx_phpbb
* @version $Id: lang_admin.php,v 1.2 2010/10/16 04:07:51 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

$lang['mx_forum_admin'] = 'MXP Forum Integration';
$lang['mx_forum_admin_explain'] = 'H�r associerar du phpBB och MXP sidor.<br /> Om du k�r modulen med statiska associationer (val "Anv�nd statiska grundinst�llnignar") beh�ver du endast skapa ett mx_phpbb block. Detta block placerar du p� ALLA sidor med phpBB associationer. Om du vill dela upp forumet och k�ra olika kategorier p� olika sidor, m�ste du skapa ytterligare mx_phpbb block - ett f�r varje subforum.';

//
// phpbb
//
$lang['Cat_all'] = 'All';

$lang['phpbb_config_updated'] = 'phpBB-Plugin-konfigurationen uppdaterades....';
$lang['Click_return_phpbb_config'] = 'Klicka %sh�r%s f�r att �terg� till phpBB-Plugin-konfigurationen';

//
// Pages
//
$lang['phpbb_index']		= 'index';
$lang['phpbb_viewforum']	= 'viewforum';
$lang['phpbb_viewtopic']	= 'viewtopic';

$lang['phpbb_faq']			= 'faq';
$lang['phpbb_groupcp']		= 'groupcp';
$lang['phpbb_login']		= 'login';
$lang['phpbb_memberlist']	= 'memberlist';
$lang['phpbb_modcp']		= 'modcp';
$lang['phpbb_posting']		= 'posting';
$lang['phpbb_privmsg']		= 'privmsg';
$lang['phpbb_profile']		= 'profile';
$lang['phpbb_search']		= 'search';
$lang['phpbb_viewonline']	= 'viewonline';

$lang['phpbb_other']	= 'Andra phpBB sidor';

$lang['phpbb_explain']	= 'Statisk association, eller defaultv�rde (f�r blockinst�llningar)';

$lang['submit']		= 'Skicka';
$lang['reset']		= 'Nollst�llen';

$lang['default_pages_title'] = 'MXP och phpBB integrering';
$lang['default_pages_title_explain'] = '';

$lang['default_pages_more_title'] = 'Fler phpBB associationer...';
$lang['default_pages_more_title_explain'] = '';

$lang['default_pages_profilecp'] = 'Om du har profile CP modulen installerad, kan du g�ra sidassociationer h�r (ist�llet f�r att modda phpBB filerna direkt).';

$lang['phpbb_integration_enabled'] = 'Aktivera phpBB modulen?';
$lang['phpbb_integration_enabled_explain'] = 'N�r phpBB modulen �r aktiverad omdirigeras alla phpBB anrop till MXP sidor. V�ljer du att inte aktivera modulen fungerar phpBB "som vanligt"';

$lang['phpbb_integration_enabled_yes'] = 'Aktivera';
$lang['phpbb_integration_enabled_no'] = 'Anv�nd inte modulen';

$lang['phpbb_override'] = 'Associera phpBB och portalsidor';
$lang['phpbb_override_explain'] = 'Anrop till phpBB sidor skickas vidare till MXP portalsidor enligt dessa inst�llningar.<br />Om du anv�nder "blockinst�llningar", gl�m inte att konfigurera phpbb blocket.';

$lang['phpbb_override_yes'] = 'Anv�nd blockinst�llningar';
$lang['phpbb_override_no'] = 'Anv�nd statiska grundinst�llningar (se nedan)';

$lang['Group_Home'] = 'Alla grupper';
?>