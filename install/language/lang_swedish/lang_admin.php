<?php
/**
*
* @package mxBB Portal Core
* @version $Id: lang_admin.php,v 1.2 2009/01/24 16:47:52 orynider Exp $
* @copyright (c) 2002-2006 mxBB Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mxbb.net
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
//setlocale(LC_ALL, 'en');

$lang['USER_LANG'] = 'sv';
$lang['ENCODING'] = 'UTF-8';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'left';
$lang['RIGHT'] = 'right';
$lang['DATE_FORMAT'] =  'd/M/Y'; // This should be changed to the default date format for your language, php date() format


//
// Install Process
//
$lang['Portal_paths'] 				= "Sökvägar";
$lang['ReadOnly'] 					= " (skrivskyddade)";
$lang['Welcome_install']           	= "Välkommen till mxBB Portalens installationsguide";
$lang['Install_Instruction']       	= "Tack för att du valde mxBB Portalen. För att fortsätta denna installation vänligen fyll i detaljerna som efterfrĺgas nedan.";
$lang['Install_Instruction_mxBB'] 	= "Ditt adminkonto kommer skapas: användarnamn (admin), lösenord (admin). Ändra lösenordet snarast!";
$lang['Install_Instruction_phpBB'] 	= "Notera, även om du väljer att använda mxBB med phpBB, sĺ kommer inte phpBB databasen att pĺverkas av denna installation.";
$lang['Upgrade_Instruction'] 		= "mxBB-Portal är redan installerad. Vänligen, gör en backup av din databas nu!<br /><br />The next step will modify the structure of your database. If for whatever reason this upgrade procedure fails, there would be no other way to return to your current state. Please, make backups of your database BEFORE proceeding !<br /><br />Once done, click the button below to start the upgrade procedure.";
$lang['Install_moreinfo'] 			= '%sRelease Notes%s | %sOnline Manual%s | %sOnline KB%s | %sSupport Forums%s | %sTerms Of Use%s';
$lang['Install_settings']			= "Installationinställningar";
$lang['Choose_lang_explain']		= "Välj vilket sprĺk du vill använda under installationen.";
$lang['Choose_lang']				= "Välj sprĺk";
$lang['Phpbb_only'] 				= '[phpBBX]';
$lang['Mxbb_only'] 					= '[Internal]';
$lang['Language']                  	= "Sprĺk";
$lang['Session_backend'] 			= 'Användare och sessioner';
$lang['Session_backend_explain'] 	= 'mxBB-IWizard (installationsguiden) har upptäckt att phpBB är installerat pĺ servern. Välj här om du vill använda mxBB med phpBB användare och sessioner. Om du är osäker (eller om du vill installera mxBB utan phpBB), välj \'Internal\' istället. <br />Du kan ändra denna inställning senare i administrationspanelen';
$lang['Phpbb_path']                	= "Phpbb-relativ sökväg";
$lang['Phpbb_path_explain']        	= "Phpbb-relativ sökväg, t ex. /phpbb2/ eller ../phpbb2/ <br /> Notera snesträcken '/', de är viktiga";
$lang['Phpbb_url']                 	= "Full PHPBB URL";
$lang['Phpbb_url_explain']         	= "Full PHPBB URL, t ex <br /> http://www.mydomain.com/phpbb2/";
$lang['Portal_url']                	= "Full Portal URL";
$lang['Portal_url_explain']        	= "Full Portal URL, t ex <br /> http://www.mydomain.com/";
$lang['Database_settings']			= "Databasinställningar";
$lang['dbms']                      	= "Databastyp";
$lang['DB_Host']                   	= "Databas Server Hostname/DSN";
$lang['DB_Name']                   	= "Databasnamn";
$lang['DB_Username']               	= "Databasanvändarnamn";
$lang['DB_Password']               	= "Databaslösenord";
$lang['Table_Prefix']              	= "PhpBB Prefix (t ex phpbb_)";
$lang['MX_Table_Prefix']           	= "mxBB Portal Prefix (t ex mx_)";
$lang['Start_Install']             	= "Starta mxBB installation";
$lang['Start_Upgrade'] 				= "Yes, I already did a backup and wish to upgrade my mxBB-Portal now.";
$lang['Portal_intalled'] 			= "mxBB-Portalen är installerad!";
$lang['Portal_upgraded'] 			= "mxBB-Portalen är uppgraderad!";
$lang['Unwriteable_config']        	= "Din konfigfil (config.php) är oskrivbar för tillfället.<br />En kopia av konfigfilen kommer laddas ner till dig när du klickar pĺ knappen nedan. <br />Du ska ladda upp denna filen till samma mapp som mxBB portalen. <br />När detta är gjort ska du lägga till db tabellerna manuellt genom att köra mx_db_upgrade.php skriptet. Sedan behöver du lägga till den korrekta sökvägen till db table mxBB Portal genom att använda ett valfritt db-verktyg. <br />Sedan, loggar du in med administratörnamn och lösenord för ditt portal/forum.<br /> Tack för att du har valt mxBB Portal.";
$lang['Send_file']                 	= "Skicka bara filen till mig och jag ftp:ar den manuellt";
$lang['phpBB_nfnd_retry'] 			= "Tyvärr, lyckades inte lokalisera din phpBB-installation. Please, press the %sBACK%s button of your browser and retry.";
$lang['MissingVariables'] 			= 'Du mĺste fylla i alla fälten. Please press the %sBACK%s button of your browser and retry.';
$lang['Installation_error']			= "Ett fel uppstod under installationen";
$lang['Debug_Information']			= "DEBUG INFORMATION";
$lang['Install_phpbb_not_found'] 	= "Tyvärr hittades ingen phpBB installation pĺ denna server.<br />Vänligen, se till att phpBB är installerat INNAN ni försöker installera mxBB.<br />\n<br />\n";
$lang['Install_phpbb_db_failed'] 	= "Tyvärr lyckades vi inte fĺ kontakt med phpBB databasen.<br />Vänligen, kontrollera att phpBB är korrekt installerard (och fungerar) INNAN ni försöker installera mxBB.<br />\n<br />\n";
$lang['Install_phpbb_unsupported'] 	= "phpBB installationen pĺ denna server stöds inte av mxBB.<br />Vänligen, läs installationskraven.<br />\n<br />\n";
$lang['Install_noscript_warning'] 	= "Denna installation kräver en webbläsare med javascriptstöd. Installationen kanske inte fungerar i din webbläsare.";
$lang['Upgrade_are_you_sure'] 		= "Denna uppgradering kommer att ändra i din databas. Vill du fortsätta?";
$lang['Writing_config'] 			= "Skriver config.php filen";
$lang['Processing_schema'] 			= "Behandlar SQL informationen '%s'";
$lang['Portal_intalling'] 			= "Installera mxBB-Portalen, version %s";
$lang['Portal_upgrading'] 			= "Uppgraderar mxBB-Portalen, version %s";
$lang['Install_warning']			= "Det uppstod 1 varning under uppdateringen av databsen";
$lang['Install_warnings']			= "Det uppstod %d varningar under uppdateringen av databsen";
$lang['Subscribe_mxBB_News_now']	= "We recommend that you subscribe to the %smxBB-News Mailing List%s to receive information about important news and release announcements.<br />&nbsp;<br />%sSubscribe to mxBB-News, now!%s";
$lang['Portal_install_done'][0]		= "Sĺ här lĺngt är installationen klar.";
$lang['Portal_install_done'][1]		= "Vänligen, ta bort mapparna /install och /contrib innan du fortsätter!!!";
$lang['Portal_install_done'][2]		= "Glöm inte att göra säkerhetskopior sĺ ofta som möjligt ;-)";
$lang['Portal_install_done'][3]		= "Tryck pĺ knappen nedan och ange ditt administratörsnamn och lösenord för att logga in pĺ systemet.";
$lang['Portal_install_done'][4]		= "Uppgradera alla moduler (en efter en) i portaladministrationen - hantering!";
$lang['Portal_install_done'][5]		= "Kontrollera portalens inställningar och gör eventuella ändringar.";
$lang['Go_to_admincp']				= "Uppgradera alla moduler i portaladministrationen - hantering";
$lang['Thanks_for_choosing']		= "Tack för att du valde mxBB-Portal.";
$lang['Critical_Error']				= "CRITICAL ERROR";
$lang['Error_loading_config']		= "Tyvärr misslyckades systemet att hitta mxBB-Portal config.php";
$lang['Error_database_down']		= "Misslyckades att ansluta till databasen.";

//
// That's all Folks!
// -------------------------------------------------
?>