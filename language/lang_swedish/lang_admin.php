<?php
/**
*
* @package MX-Publisher Core
* @version $Id: lang_admin.php,v 1.6 2008/06/16 20:41:35 jonohlsson Exp $
* @copyright (c) 2002-2006 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
*
*/

//
// Editor Settings: Please, set Tabsize to 4 ;-)
//

//
// The format of this file is:
//
// ---> $lang["message"] = "text";
//
// Specify your language character encoding... [optional]
//
//setlocale(LC_ALL, "sv");

$lang['mxBB_adminCP']				= 'MX-Publisher administration';

//
// Left AdminCP Panel
//
$lang['1_General_admin']			= 'Allmänt';
$lang['1_1_Management']				= 'Konfiguration';
$lang['1_2_WordCensors']				= 'Ordcensur';

$lang['2_CP']						= 'Hantering';
$lang['2_1_Modules']				= 'Moduluppsättning<br /><hr>';
$lang['2_2_ModuleCP']				= 'Portalmoduler';
$lang['2_3_BlockCP']				= 'Portalblock';
$lang['2_4_PageCP']					= 'Portalsidor';

$lang['3_CP'] = 'Stilar';
$lang['2_1_new'] = 'Lägg till';
$lang['2_2_manage'] = 'Hantera';
$lang['2_3_smilies'] = 'Smilies';

$lang['4_Panel_system']				= 'Systemverktyg';
$lang['4_1_Cache']					= 'Återskapa cache';
$lang['4_1_Integrity']				= 'Integrity Checker';
$lang['4_1_Meta']					= 'META tags';
$lang['4_1_PHPinfo']				= 'PHPinfo()';

//
// Index
//
$lang['Welcome_mxBB'] = 'Välkommen till MX-Publisher';
$lang['Admin_intro_mxBB'] = 'Tack för att du har valt MX-Publisher som din portallösning och phpBB som din forumlösning. Den här sidan ger dig en snabb överblick över all möjlig statistik. Du kan komma tillbaka till den här sidan genom att klicka på <u>Admin index</u> länken på den vänstra sidan. För att komma tillbaka till indexet för sidan tryck på loggan, som finns i den vänstra panelen. De övriga länkarna på vänster hand låter dig kontrollera alla aspekter på hur portalen/forumet presenteras, varje sida har intruktioner på hur du använder verktygen.';

//
// General
//
$lang['Yes'] 						= 'Ja';
$lang['No'] 						= 'Nej';
$lang['No_modules']					= 'Inga moduler är installerade';
$lang['No_functions']				= 'Denna modul saknar blockfunktioner';
$lang['No_parameters']				= 'Denna blockfunktion saknar parametrar';
$lang['No_blocks']					= 'Inga block är skapade';
$lang['No_pages']					= 'Inga sidor är skapade';
$lang['No_settings']				= 'Fler alternativ finns ej för detta block';
$lang['Quick_nav']					= 'Snabbnavigering';
$lang['Include_all_modules']		= 'Visa alla moduler';
$lang['Include_block_quickedit']	= 'Inkludera blockinställningar';
$lang['Include_block_private']		= 'Inkludera blockrättigheter';
$lang['Include_all_pages']			= 'Visa alla sidor';
$lang['View']                      	= 'Läsa';
$lang['Edit']                      	= 'Redigera';
$lang['Settings']                  	= 'Inställningar';
$lang['Delete']                    	= 'Radera';
$lang['Move_up']                   	= 'Flytta upp';
$lang['Move_down']                 	= 'Flytta ner';
$lang['Resync']                    	= 'Synkronisera allt';
$lang['Update']                    	= 'Uppdatera';
$lang['Permissions']				= 'Rättigheter';
$lang['Permissions_std']			= 'Standardrättigheter';
$lang['Permissions_adv']			= 'Avancerade rättigheter';
$lang['return_to_page']				= 'Tillbaka till portalsidan';
$lang['Use_default'] 				= 'Använd grundinställningar';

$lang['AdminCP_status']						= '<b>Status rapport</b>';
$lang['AdminCP_action']						= '<b>DB händelse</b>';
$lang['Invalid_action']						= 'Fel!';
$lang['was_installed']                    	= 'installerades';
$lang['was_uninstalled']                   	= 'avinstallerades';
$lang['was_upgraded']                    	= 'uppgraderades';
$lang['was_exported']                    	= 'exporterades';
$lang['was_deleted']                    	= 'raderades';
$lang['was_removed']                    	= 'togs bort';
$lang['was_inserted']                    	= 'lades till';
$lang['was_updated']                    	= 'uppdaterades';
$lang['was_added']                    		= 'lades till';
$lang['was_moved']                    		= 'flyttades';
$lang['was_synced']                    		= 'synkades';

$lang['error_no_field']                    	= 'Du har inte fyllt i alla nödvändiga fält...';

//
// Configuration
//
$lang['Portal_admin']              			= 'Portaladministration';
$lang['Portal_admin_explain']      			= 'Använd detta formulär för att skräddarsy din portal';
$lang['Portal_General_Config']     			= 'Portalkonfiguration';
$lang['Portal_General_Config_explain'] 		= 'Använd detta formulär för att hantera MXP-portalens huvudinställningar.';
$lang['Portal_General_settings']   			= 'Allmänna inställningar';
$lang['Portal_Style_settings']   			= 'Stilinställningar';
$lang['Portal_General_config_info'] 		= 'Information om allmänna inställningar';
$lang['Portal_General_config_info_explain'] = 'config.php värden - för kännedom (ingen redigering)';
$lang['Portal_Name']               			= 'Portalens namn:';
$lang['Portal_PHPBB_Url']          			= 'URL till PHPBB (forum) installationen:';
$lang['Portal_Url']                			= 'URL till MXP-installationen:';
$lang['Portal_Config_updated']     			= 'Portalkonfigurationen uppdaterades...';
$lang['Click_return_portal_config'] 		= 'Klicka %shär%s för att återgå till Portalkonfigurationen';
$lang['PHPBB_info']                			= 'PHPBB-information';
$lang['PHPBB_version']             			= 'PHPBB-version:';
$lang['PHPBB_script_path']         			= 'PHPBB-script_path:';
$lang['PHPBB_server_name']         			= 'PHPBB-domain (server_name):';
$lang['MX_Portal']							= 'MX-Publisher Portal';
$lang['MX_Modules']							= 'MX-Publisher Moduler';
$lang['Phpbb']								= 'phpBB';
$lang['Top_phpbb_links'] 					= 'Visa (phpBB) statistik i sidhuvudet (default)';
$lang['Top_phpbb_links_explain'] 			= '- länkar till ny/oläst post etc';
$lang['Portal_version']            			= 'MX-Publisher portalversion:';
$lang['Mx_use_cache'] 						= 'Använd MXP blockcache';
$lang['Mx_use_cache_explain'] 				= 'Blockdata sparas i speciella cache/block_x.xml filer. Cachefiler skapas när block ändras.';
$lang['Mx_mod_rewrite'] 					= 'Använd mod_rewrite';
$lang['Mx_mod_rewrite_explain'] 			= 'Om du har en Apache server, med mod_rewrite aktiverat, kan ersätta de vanliga \'page=x\' etc med mer intuitiva alternativ. Se fullständig dokumentation i mx_mod_rewrite modulen.';
$lang['Portal_Overall_header'] 				= 'Sidhuvudfil (default)';
$lang['Portal_Overall_header_explain'] 		= '- Detta är grundinställningen för vilken sidhuvudfil som används, t ex overall_header.tpl.';
$lang['Portal_Overall_footer'] 				= 'Sidfotfil (default)';
$lang['Portal_Overall_footer_explain'] 		= '- Detta är grundinställningen för vilken sidfotfil som används, t ex overall_footer.tpl.';
$lang['Portal_Main_layout'] 				= 'Sidlayoutfil (default)';
$lang['Portal_Main_layout_explain'] 		= '- Detta är grundinställningen för vilken sidlayoutfil som används, t ex mx_main_layout.tpl.';
$lang['Portal_Navigation_block'] 			= 'Sidhuvudets navigeringsblock (default)';
$lang['Portal_Navigation_block_explain'] 	= '- Detta är grundinställningen för vilket navigeringsblock i sidhuvudet som används.';
$lang['Default_style'] 						= 'Portalstil för sidor (standard)';
$lang['Default_admin_style'] 				= 'Portalstil för kontrollpanelen(standard)';
$lang['Select_page_style'] 					= 'Välj (eller använd standard)';
$lang['Override_style'] 					= 'Åsidosätt användarstil';
$lang['Override_style_explain'] 			= 'Ersätter användarens stil med standardstilen (för portalsidor)';
$lang['Portal_status'] 						= 'Aktivera MX-Publisher';
$lang['Portal_status_explain'] 				= 'Praktisk switch när admin underhåller sajten. När MX-Publisher är inaktiverad visas meddelandet nedan.';
$lang['Disabled_message'] 					= 'Inaktiverad meddelande';
$lang['Portal_Backend'] 					= 'MX-Publisher användare och sessioner';
$lang['Portal_Backend_explain'] 			= 'Välj internal, phpBB2 or phpBB3 användare och sessioner';
$lang['Portal_Backend_path'] 				= 'Relative sökväg till phpBB [non-internal]';
$lang['Portal_Backend_path_explain'] 		= 'Om du valt non-internal användare och sessioner, ange den relativa sökvägen till phpbb, t ex \'phpBB2/\' eller \'../phpBB2/\'.';
$lang['Portal_Backend_submit'] 				= 'Byt och validera användare och sessioner';
$lang['Portal_config_valid'] 				= 'Aktuell status: ';
$lang['Portal_config_valid_true'] 			= '<b><font color="green">Ok</font></b>';
$lang['Portal_config_valid_false'] 			= '<b><font color="red">Fel. Antingen är din relativa sökväg till phpBB felaktig, eller så är phpBB inte installerat (din phpBB databas hittas inte). Sålunda använda \'internal\'.</font></b>';

//
// Module Management
//
$lang['Module_admin']              	= 'Moduladministration';
$lang['Module_admin_explain']      	= 'Använd detta formulär för att hantera portalmodulerna - installation, uppgradering och utveckling.<br /><b>För att kunna använda denna sida krävs att du aktiverat javascript och cookies i din webbläsare</b>.';
$lang['Modulecp_admin']				= 'Modulkontrollpanel';
$lang['Modulecp_admin_explain']		= 'Använd detta formulär för att hantera portalmodulerna - blockfunktioner, parametrar & portalblock.<br /><b>För att kunna använda denna sida krävs att du aktiverat javascript och cookies i din webbläsare</b>.';
$lang['Modules']                   	= 'Portalmoduler';
$lang['Module']                    	= 'Portalmodul';
$lang['Module_delete']             	= 'Radera en portalmodul';
$lang['Module_delete_explain']     	= 'Använd detta formulär för att radera en portalmodul (eller blockfunktion)';
$lang['Edit_module']               	= 'Redigera en portalmodul';
$lang['Create_module']             	= 'Utveckla ny portalmodul';
$lang['Module_name']               	= 'Modulnamn';
$lang['Module_desc']               	= 'Beskrivning';
$lang['Module_path']               	= 'Sökväg, t ex "modules/mx_textblocks"';
$lang['Module_include_admin']      	= 'Inkludera denna portalmodul i kontrollpanelens menynavigering (t v)';

//
// Module Installation
//
$lang['Module_delete_db']   		= 'Vill du avinstallera modulen? Varning: denna data kan inte återskapas. Överväg att uppgradera istället...';
$lang['Click_module_delete_yes']   	= 'Klicka %shär%s för att avinstallera modulen';
$lang['Click_module_upgrade_yes']	= 'Klicka %shär%s för att uppgradera modulen';
$lang['Click_module_export_yes']	= 'Klicka %shär%s för att exportera modulen';
$lang['Error_no_db_install'] 		= 'Fel: filen db_install.php finns inte. Vänligen verifiera och försök igen...';
$lang['Error_no_db_uninstall'] 		= 'Fel: filen db_uninstall.php finns inte eller avinstallations möjligheterna stöds inte för denna modul. Vänligen verifiera och försök igen...';
$lang['Error_no_db_upgrade'] 		= 'Fel: filen db_upgrade.php finns inte eller så stöds inte uppgraderingsmöjligheterna av denna modul. Vänligen verifiera och försök igen...';
$lang['Error_module_installed'] 	= 'Fel: Denna modul är redan installerad! Vänligen antingen radera modulen eller uppgradera modulen istället.';
$lang['Uninstall_module'] 			= 'Avinstallera portalmodul';
$lang['import_module_pack']        	= 'Installera portalmodul';
$lang['import_module_pack_explain']	= 'Detta kommmer installera en portalmodul. Var säker på att portalmodulen är uppladdad till /portalmodul mappen... och använd den senaste versionen!';
$lang['upgrade_module_pack']       	= 'Upgradera portalmodul';
$lang['upgrade_module_pack_explain']= 'Detta kommer uppgradera din portalmodul. Var säker på att läsa dokumentationen innan du fortsätter, annars kan du förlora data.';
$lang['export_module_pack']        	= 'Exportera portalmodul';
$lang['Export_Module']             	= 'Välj en portalmodul:';
$lang['export_module_pack_explain'] = 'Detta kommer att exportera en portalmodul *.pak fil. Endast avsedd för utvecklare/kodare...';
$lang['Module_Config_updated']     	= 'Modulkonfiguration uppdaterades...';
$lang['Click_return_module_admin'] 	= 'Klicka %shär%s för att återgå till moduladministrationen';
$lang['Module_updated']            	= 'Modulinformation uppdaterades...';

//
// Functions & Parameters Administration
//
$lang['Function_admin']            	= 'Blockfunktionadministration';
$lang['Function_admin_explain']    	= 'Varje portalmodul har en eller fler blockfunktioner. Använd detta formulär för att redigera, lägga till, eller radera en blockfunktion';
$lang['Function']                  	= 'Blockfunktion';
$lang['Function_name']             	= 'Blockfunktionsnamn';
$lang['Function_desc']             	= 'Beskrivning';
$lang['Function_file']             	= 'Fil';
$lang['Function_admin_file']       	= 'Fil (Redigera block) <br /> Xtra inställningar för redigeringspanelen för detta block. Lämna tom för att använda standardpanelen';
$lang['Create_function']           	= 'Lägg till en ny blockfunktion';
$lang['Delete_function']			= 'Ta bort blockfunktion';
$lang['Delete_function_explain']	= 'Vill du ta bort blockfunktion, och uppdatera alla associerade portalblock? Varning, detta val kan inte ångras!';
$lang['Click_function_delete_yes']	= 'Klicka %shär%s för att ta bort blockfunktionen';

$lang['Parameter_admin']           	= 'Parameteradministration';
$lang['Parameter_admin_explain']   	= 'Lista alla parametrar för denna funktion';
$lang['Parameter']					= 'Parameter';
$lang['Parameter_name']            	= '<b>Namn</b><br />- används för åtkomst av parametern';
$lang['Parameter_type']            	= '<b>Typ</b>';
$lang['Parameter_default']         	= '<b>Standardvärde</b>';
$lang['Parameter_function'] 		= '<b>Funktionsanrop/alternativ</b>';
$lang['Parameter_function_explain'] = '<b>Funktionsanrop</b> (för parametertyp "Funktion")<br />- du kan anropa en extern funktion för att skapa formulärfältet.<br />- T ex: get_list_formatted(\"block_list\",\"{parameter_value}\",\"{parameter_id}[]\")';
$lang['Parameter_function_explain'] .= '<br /><br /><b>Alternativ</b> (för parametertyp "Selections")<br />- här listar du alla alternativ för valmöjligheterna (radiobuttons, checkboxes, drop down menys)';
$lang['Parameter_auth']				= '<b>Endast för Admin/Block Moderator</b>';

$lang['Parameters']					= 'Parametrar';
$lang['Parameter_id']              	= 'Id';
$lang['Create_parameter']          	= 'Lägg till en ny parameter';
$lang['Delete_parameter']				= 'Ta bort funktionsparameter';
$lang['Delete_parameter_explain']		= 'Vill du ta bort funktionsparametern, och uppdatera alla associerade portalblock? Varning, detta val kan inte ångras!';
$lang['Click_parameter_delete_yes']		= 'Klicka %shär%s för att ta bort funktionsparametern';

//
// Parameter Types
//
$lang['ParType_BBText'] 			= 'Enkelt BBText textblock';
$lang['ParType_BBText_info'] 		= 'Detta är ett enkelt textblock, som accepterar bbcodes';
$lang['ParType_Html'] 				= 'Enkelt Html textblock';
$lang['ParType_Html_info'] 			= 'Detta är ett enkelt textblock, som accepterar html';
$lang['ParType_Text'] 				= 'Textfält (enkelrad)';
$lang['ParType_Text_info'] 			= 'Detta är ett enkelt textfält';
$lang['ParType_TextArea'] 			= 'Textruta (flera rader)';
$lang['ParType_TextArea_info'] 		= 'Detta är en enkel textruta';
$lang['ParType_Boolean'] 			= 'Boolean';
$lang['ParType_Boolean_info'] 		= 'Detta är ett \'ja\' eller \'nej\' val';
$lang['ParType_Number'] 			= 'Nummer';
$lang['ParType_Number_info'] 		= 'Detta är ett enkelt nummerfält';
$lang['ParType_Function'] 			= 'Parameter function';
$lang['ParType_Values'] 			= 'Values';

$lang['ParType_Radio_single_select'] 			= 'Single-Selection Radio Buttons';
$lang['ParType_Radio_single_select_info'] 		= '';
$lang['ParType_Menu_single_select'] 			= 'Single-Selection Menu';
$lang['ParType_Menu_single_select_info'] 		= '';
$lang['ParType_Menu_multiple_select'] 			= 'Multiple-Selection Menu';
$lang['ParType_Menu_multiple_select_info'] 		= '';
$lang['ParType_Checkbox_multiple_select'] 		= 'Multiple-Selection Checkbox';
$lang['ParType_Checkbox_multiple_select_info'] 	= '';

//
// Blocks Administration
//
$lang['Block_admin']               	= 'Kontrollpanel - Portalblock';
$lang['Block_admin_explain']       	= 'Använd detta formulär för att hantera portalblock.<br /><b>För att kunna använda denna sida krävs att du aktiverat javascript och cookies i din webbläsare</b>.';
$lang['Block']                     	= 'Portalblock';
$lang['Show_title'] 				= 'Visa blocktitel?';
$lang['Show_title_explain'] 		= 'Visa eller inte visa blocktiteln';
$lang['Show_block'] 				= 'Visa block?';
$lang['Show_block_explain'] 		= '- om \'nej\', är blocket dolt för alla utom admin';
$lang['Show_stats'] 				= 'Visa statistik?';
$lang['Show_stats_explain'] 		= '- om \'ja\', visas \'senast updaterad av...\' under blocket';
$lang['Show_blocks']               	= 'Visa portalblock';
$lang['Block_delete']              	= 'Radera ett portalblock';
$lang['Block_delete_explain']      	= 'Använd detta formulär för att radera ett portalblock (eller kolumn)';
$lang['Block_title']               	= 'Titel';
$lang['Block_desc']                	= 'Beskrivning';
$lang['Add_Block']                 	= 'Lägg till portalblock';
$lang['Auth_Block']                	= 'Rättigheter';
$lang['Auth_Block_explain']			= 'ALL: Alla användare<br />REG: Registrerade användare<br />PRIVATE: Gruppmedlemmar (se avancerade rättigheter)<br />MOD: blockmoderatorer (se avancerade rättigheter)<br />ADMIN: Admin<br />ANONYMOS: Ej inloggade användare (endast)';
$lang['Block_quick_stats']			= 'Block Stats';
$lang['Block_quick_edit']			= 'Snabbinställningar';
$lang['Create_block']              	= 'Skapa nytt portalblock';
$lang['Delete_block']				= 'Ta bort portalblock';
$lang['Delete_block_explain']		= 'Vill du ta bort portalblocket, och uppdatera alla portalsidor? Varning, detta val kan inte ångras!';
$lang['Click_block_delete_yes']		= 'Klicka %shär%s för att ta bort portalblocket';

//
// BlockCP Administration
//
$lang['Block_cp']                  	= 'Kontrollpanel';
$lang['Click_return_blockCP_admin']	= 'Klicka %sHär%s för att återvända till kontrollpanelen';
$lang['Click_return_portalpage_admin']	= 'Klicka %sHär%s för att återvända till portalsidan';
$lang['BlockCP_Config_updated']		= 'Blockinformationen uppdateras...';

//
// Page Administration
//
$lang['Page_admin']                	= 'Portalsidaadministration';
$lang['Page_admin_explain']			= 'Använd detta formulär för att lägga till, radera eller ändra inställningar för portalsidor och portalsidmallar.<br /><b>För att kunna använda denna sida krävs att du aktiverat javascript och cookies i din webbläsare</b>.';
$lang['Page_admin_edit']			= 'Ändra';
$lang['Page_admin_private']			= 'Avancerade (PRIVATE) rättigheter';
$lang['Page_admin_settings']		= 'Sidinställningar';
$lang['Page_admin_new_page']		= 'Ny sida';
$lang['Page']                      	= 'Sida';
$lang['Page_Id']                   	= 'Portalsida ID';
$lang['Page_icon']                 	= 'Portalsidbild <br /> - för att användas i adminCP endast, eg. icon_home.gif (standard)';
$lang['Page_alt_icon']              = 'Alternativ portalsidbild <br /> - Ange full url (http://...) till bilden.';
$lang['Default_page_style'] 		= 'Portalstil (standard)<br />- För att använda defaultinställningen, lämna detta fält tomt.';
$lang['Override_page_style'] 		= 'Åsidosätt användarstil';
$lang['Override_page_style_explain']= ' ';
$lang['Page_header']               	= 'Sidhuvudfil <br /> - det vill säga overall_header.tpl (standard), overall_noheader.tpl (no header) eller egen fil. För att använda defaultinställningen, lämna detta fält tomt.';
$lang['Page_footer']               	= 'Sidfotfil <br /> - det vill säga overall_footer.tpl (standard) eller egen fil. För att använda defaultinställningen, lämna detta fält tomt.';
$lang['Page_main_layout']           = 'Sidlayoutfil <br /> - det vill säga mx_main_layout.tpl (standard) eller egen fil. För att använda defaultinställningen, lämna detta fält tomt.';
$lang['Page_Navigation_block'] 			= 'Sidhuvudets navigeringsblock';
$lang['Page_Navigation_block_explain'] 	= '- Detta är valet av sidhuvudets navigeringsblock, förutsatt att du valt en sidhuvudfil som stödjer navigeringsblock. För att använda defaultinställningen, lämna detta fält tomt.';
$lang['Auth_Page']                 	= 'Rättigheter';
$lang['Select_sort_method']			= 'Välj sorteringssätt';
$lang['Order']						= 'Riktning';
$lang['Sort']						= 'Sortera';
$lang['Page_sort_title']			= 'Sidnamn';
$lang['Page_sort_desc']				= 'Sidbeskrivning';
$lang['Page_sort_created']			= 'Sidan skapad';
$lang['Sort_Ascending']				= 'ASC';
$lang['Sort_Descending']			= 'DESC';
$lang['Return_to_page']            	= 'Återgå till portalsidan';
$lang['Auth_Page_group'] 			= '-> PRIVAT Grupp';
$lang['Page_desc'] 					= 'Beskrivning';
$lang['Page_parent'] 				= 'Överordnad sida';
$lang['Add_Page']                  	= 'Lägg till en ny sida';
$lang['Page_Config_updated']       	= 'Portalsidakonfigurationen uppdaterades...';
$lang['Click_return_page_admin']   	= 'Klicka %shär%s för att återvända till portalsidaadministrationen';
$lang['Remove_block']				= 'Ta bort portalblock';
$lang['Remove_block_explain']		= 'Vill du ta bort portalblocket från sidan? Varning, detta val kan inte ångras!';
$lang['Click_block_remove_yes']		= 'Klicka %shär%s för att ta bort portalblocket';
$lang['Delete_page']				= 'Ta bort sidan';
$lang['Delete_page_explain']		= 'Vill du ta bort sidan? Varning, detta val kan inte ångras!';
$lang['Click_page_delete_yes']		= 'Klicka %shär%s för att ta bort sidan';

$lang['Mx_IP_filter']				= 'IP filter';
$lang['Mx_IP_filter_explain']		= 'För att begränsa tillträde till sidan baserat på IP, ange godkända IP-adresser - en per rad. <br> T ex 127.0.0.1 eller 127.0.*.*';
$lang['Mx_phpBB_stats']				= 'Visa (phpBB) statistik i sidhuvudet (default)';
$lang['Mx_phpBB_stats_explain']		= '- länkar till ny/oläst post etc';
$lang['Column_admin']				= 'Sidkolumnadministration';
$lang['Column_admin_explain']		= 'Administrera sidkolumner';
$lang['Column']                    	= 'Sidkolumn';
$lang['Columns']                   	= 'Sidkolumner';
$lang['Column_block']               = 'Sidkolumnblock';
$lang['Column_blocks']              = 'Sidkolumnblock';
$lang['Edit_Column']               	= 'Redigera en kolumn';
$lang['Edit_Column_explain']       	= 'Använd detta formulär för att modifiera en kolumn';
$lang['Column_Size']               	= 'Storleken på kolumnen';
$lang['Column_name']               	= 'Kolumnnamn';
$lang['Column_delete']             	= 'Radera en kolumn';
$lang['Page_updated']              	= 'Portalsida- och kolumninformation uppdaterades...';
$lang['Create_column']             	= 'Lägg till ny kolumn';
$lang['Delete_page_column']				= 'Ta bort sidkolumn';
$lang['Delete_page_column_explain']		= 'Vill du ta bort sidkolumnen? Varning, detta val kan inte ångras!';
$lang['Click_page_column_delete_yes']	= 'Klicka %shär%s för att ta bort sidkolumnen';

$lang['Add_Split_Block'] 			= 'Lägg till kolumndelarblock';
$lang['Add_Split_Block_explain'] 	= 'Detta block delar upp kolumnen';
$lang['Add_Dynamic_Block'] 			= 'Lägg till dynamiskt (sub) block';
$lang['Add_Dynamic_Block_explain'] 	= 'Detta block är ett dynamiskt block, vars innehåll bestäms via navigeringsmenyn';
$lang['Add_Virtual_Block'] 			= 'Lägg till virtuellt (sidblogg) block';
$lang['Add_Virtual_Block_explain'] 	= 'Detta block gör sidan till en virtuell (blogg-) sida';

//
// Page templates
//
$lang['Page_templates_admin'] 		= 'Kontrollpanel för sidmallar';
$lang['Page_templates_admin_explain'] = 'På denna sida kan du skapa, ändra och ta bort sidmallar';
$lang['Page_template']				= 'Sidmall';
$lang['Page_templates']				= 'Sidmallar';
$lang['Page_template_column']		= 'Sidmallskolumn';
$lang['Page_template_columns']		= 'Sidmallskolumner';
$lang['Choose_page_template']		= 'Välj sidmall';
$lang['Template_Config_updated'] 	= 'Sidmallskonfigurationen uppdaterades...';
$lang['Add_Template'] 				= 'Lägg till sidmall';
$lang['Template'] 					= 'Sidmall';
$lang['Template_name']				= 'Sidmallens namn';
$lang['Page_template_delete'] 		= 'Ta bort sidmall';
$lang['Delete_page_template']			= 'Ta bort sidmall';
$lang['Delete_page_template_explain']	= 'Vill du ta bort sidmallen? Varning, detta val kan inte ångras!';
$lang['Click_page_template_delete_yes']	= 'Klicka %shär%s för att ta bort sidmallen';
$lang['Delete_page_template_column']			= 'Ta bort sidmallskolumn';
$lang['Delete_page_template_column_explain']	= 'Vill du ta bort sidmallskolumnen? Varning, detta val kan inte ångras!';
$lang['Click_page_template_column_delete_yes']	= 'Klicka %shär%s för att ta bort sidmallskolumnen';

//
// Cache
//
$lang['Cache_dir_write_protect']   	= 'Din cachemapp är skrivskyddad, kan inte skapa cachefilerna';
$lang['Cache_generate']            	= 'Dina cachefiler är skapade';
$lang['Cache_submit']              	= 'Generera cachefilerna?';
$lang['Cache_explain']             	= 'Nu kan du skapa alla xml-filer (cachefiler) för systemet. Dessa filer hjälper till att minska antalet frågor till databasen och förbättra portalprestandan.<br />Notera: Du måste aktivera cachefunktionen (Portal hantering adminCP) för att cachefilerna skall läsas.<br />Notera vidare: Cachefilerna skapas automatiskt av systemet när block ändras.';
$lang['Generate_mx_cache'] 			= 'Skapa cachefiler';

//
// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!
//
$lang['Menu_Navigation']           	= 'Navigationsmeny';
$lang['Portal_index']              	= 'Portalindex';
$lang['Save_Settings']             	= 'Spara inställningar';
$lang['Translation_Tools']         	= 'Översättningsverktyg';
$lang['Preview_portal']            	= 'Förhandsgranska portal';

//
// META Administration
//
$lang['Meta_admin']                	= 'Meta Tag administration';
$lang['Mega_admin_explain']        	= 'Använd detta formulär för att skräddarsy din Meta information';
$lang['Meta_Title']                	= 'Titel';
$lang['Meta_Author']               	= 'Författare';
$lang['Meta_Copyright']            	= 'Copyright';
$lang['Meta_Keywords']             	= 'Nyckelord';
$lang['Meta_Keywords_explain']     	= '(kommaseparerad lista)';
$lang['Meta_Description']          	= 'Beskrivning';
$lang['Meta_Language']             	= 'Språkkod';
$lang['Meta_Rating']               	= 'Röstning';
$lang['Meta_Robots']               	= 'Robots';
$lang['Meta_Pragma']               	= 'Pragma no-cache';
$lang['Meta_Bookmark_icon']        	= 'Bokmärkesbild';
$lang['Meta_Bookmark_explain']     	= '(relativ plats)';
$lang['Meta_HTITLE']               	= 'Extra huvudinställningar';
$lang['Meta_data_updated']			= 'Meta data file (mx_meta.inc) has been updated!<br />Click %sHERE%s to return to Meta Tags Administration.';
$lang['Meta_data_ioerror']			= 'Unable to open mx_meta.inc. Make sure the file is writable (chmod 777).';

//
// Permissions
//
$lang['Mx_Block_Auth_Title'] 		= 'Blockrättigheter (PRIVATE)' ;
$lang['Mx_Block_Auth_Explain'] 		= 'Här konfigurerar du dina blockrättigheter';
$lang['Mx_Page_Auth_Title'] 		= 'Sidrättigheter (PRIVATE)' ;
$lang['Mx_Page_Auth_Explain'] 		= 'Här konfigurerar du dina sidrättigheter';
$lang['Block_Auth_successfully'] 	= 'Blockrättigheterna uppdaterades...';
$lang['Click_return_block_auth'] 	= 'Klicka %shär%s för att återgå till blockrättigheterna';
$lang['Page_Auth_successfully'] 	= 'Sidrättigheterna uppdaterades...';
$lang['Click_return_page_auth'] 	= 'Klicka %shär%s för att återgå till sidrättigheterna';
$lang['AUTH_ALL']                  	= 'ALLA';
$lang['AUTH_REG']                  	= 'REG';
$lang['AUTH_PRIVATE']              	= 'PRIVAT';
$lang['AUTH_MOD']                  	= 'MOD';
$lang['AUTH_ADMIN']                	= 'ADMIN';
$lang['AUTH_ANONYMOUS']            	= 'ANONYM';

// -----------------------------------
// Block Parameter Specific
// -----------------------------------

//
// General
//
$lang['target_block']				= 'Målblock';
$lang['target_block_explain']		= '- länkar, data etc hänvisar till detta block';

//
// Split column
//
$lang['block_ids']            		= 'Källblock';
$lang['block_ids_explain']          = '- att placeras vänster till höger';
$lang['block_sizes']   				= 'Blockstorlek, kommaseparerad lista';
$lang['block_sizes_explain']   		= '- använd relativa mått, t ex \'40%\' och \'*\' för att fylla ut';
$lang['space_between'] 				= 'Mellanrum';

//
// Stats
//
$lang['log_filter_date'] 			= 'Datumfilter';
$lang['log_filter_date_explain'] 	= '- Visa log från senaste dagen, veckan, måndaden, året...';
$lang['numOfEvents']				= 'Antal';
$lang['numOfEvents_explain']		= '- Antal händelser att visa';

//
// IncludeX
//
$lang['x_listen'] 					= 'Lyssna (GET)';
$lang['x_iframe'] 					= 'Iframe';
$lang['x_textfile'] 				= 'Textfil';
$lang['x_multimedia'] 				= 'WMP Multimedia';
$lang['x_pic'] 						= 'Bild';
$lang['x_format'] 					= 'Formaterad textfil';
$lang['x_mode'] 					= 'IncludeX funktion:';
$lang['x_mode_explain'] 			= '- IncludeX blocket används på olika sätt beroende på funktionsval. Om du väljer \'Lyssna (GET)\', bestäms funktionen genom att skicka med informationen i urlen: \'x_mode=mode\' och associerade parametrar \'x_1=, x_2=, etc\'.<br />Exemplel: För att använda en url i en iframe: \'domain/index.php?page=x&x_mode=iframe&x_1=http://domain\'  ';
$lang['x_1'] 						= 'Variabel 1:';
$lang['x_1_explain'] 				= '- <i>IFrame:</i> url<br /><i>Textfil:</i> relativ sökväg till filen (t ex \'/include_file/min_fil.xxx\')<br /><i>Multimedia:</i> relativ sökväg till filen (t ex \'/include_file/min_fil.xxx\')<br /><i>Bild:</i> relativ sökväg till filen (t ex \'/include_file/min_fil.xxx\')<br /><i>Formaterad textfil:</i> not available';
$lang['x_2'] 						= 'Variabel 2:';
$lang['x_2_explain'] 				= '- <i>IFrame:</i> ramhöjd (pixlar)<br /><i>Multimedia:</i> bredd (pixlar)';
$lang['x_3'] 						= 'Variabel 3:';
$lang['x_3_explain'] 				= '- <i>Multimedia:</i> höjd (pixlar)';

//
// Dynamic Block
//
$lang['default_block_id']			= 'Basblock';
$lang['default_block_id_explain']	= '- Detta block visas (först) om inget dynamiskt block är givet';

//
// Menu Navigation
//
$lang['menu_display_mode']				= 'Layoutläge';
$lang['menu_display_mode_explain ']		= 'Horisontellt eller vertikalt layoutläge';
$lang['menu_custom_tpl']				= 'Alternativ stilfil';
$lang['menu_custom_tpl_explain ']		= 'Filnamn på alternativ stilfil, t ex mx_menu_custom.tpl';
$lang['menu_page_parent']				= 'Toppsida';
$lang['menu_page_parent_explain ']		= 'Navigera från denna sida och ner';

//
// Version Checker
//
$lang['mxBB_Version_up_to_date'] = 'Your MX-Publisher installation is up to date. No updates are available for your version of mxBB.';
$lang['mxBB_Version_outdated'] = 'Your MX-Publisher installation does <b>not</b> seem to be up to date. Updates are available for your version of MX-Publisher. Please visit <a href="http://www.mx-publisher.com/download" target="_new">the mxBB Core package download</a> to obtain the latest version.';
$lang['mxBB_Latest_version_info'] = 'The latest available version is <b>MX-Publisher %s</b>. ';
$lang['mxBB_Current_version_info'] = 'You are running <b>MX-Publisher %s</b>.';
$lang['mxBB_Mailing_list_subscribe_reminder'] = 'For the latest information on news and updates to MX-Publisher, why not <a href="http://lists.sourceforge.net/lists/listinfo/mxbb-news" target="_new">subscribe to our mailing list</a>?';

//
// That's all Folks!
// -------------------------------------------------
?>