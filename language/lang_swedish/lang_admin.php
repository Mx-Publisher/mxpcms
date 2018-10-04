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
$lang['1_General_admin']			= 'Allm�nt';
$lang['1_1_Management']				= 'Konfiguration';
$lang['1_2_WordCensors']				= 'Ordcensur';

$lang['2_CP']						= 'Hantering';
$lang['2_1_Modules']				= 'Modulupps�ttning<br /><hr>';
$lang['2_2_ModuleCP']				= 'Portalmoduler';
$lang['2_3_BlockCP']				= 'Portalblock';
$lang['2_4_PageCP']					= 'Portalsidor';

$lang['3_CP'] = 'Stilar';
$lang['2_1_new'] = 'L�gg till';
$lang['2_2_manage'] = 'Hantera';
$lang['2_3_smilies'] = 'Smilies';

$lang['4_Panel_system']				= 'Systemverktyg';
$lang['4_1_Cache']					= '�terskapa cache';
$lang['4_1_Integrity']				= 'Integrity Checker';
$lang['4_1_Meta']					= 'META tags';
$lang['4_1_PHPinfo']				= 'PHPinfo()';

//
// Index
//
$lang['Welcome_mxBB'] = 'V�lkommen till MX-Publisher';
$lang['Admin_intro_mxBB'] = 'Tack f�r att du har valt MX-Publisher som din portall�sning och phpBB som din foruml�sning. Den h�r sidan ger dig en snabb �verblick �ver all m�jlig statistik. Du kan komma tillbaka till den h�r sidan genom att klicka p� <u>Admin index</u> l�nken p� den v�nstra sidan. F�r att komma tillbaka till indexet f�r sidan tryck p� loggan, som finns i den v�nstra panelen. De �vriga l�nkarna p� v�nster hand l�ter dig kontrollera alla aspekter p� hur portalen/forumet presenteras, varje sida har intruktioner p� hur du anv�nder verktygen.';

//
// General
//
$lang['Yes'] 						= 'Ja';
$lang['No'] 						= 'Nej';
$lang['No_modules']					= 'Inga moduler �r installerade';
$lang['No_functions']				= 'Denna modul saknar blockfunktioner';
$lang['No_parameters']				= 'Denna blockfunktion saknar parametrar';
$lang['No_blocks']					= 'Inga block �r skapade';
$lang['No_pages']					= 'Inga sidor �r skapade';
$lang['No_settings']				= 'Fler alternativ finns ej f�r detta block';
$lang['Quick_nav']					= 'Snabbnavigering';
$lang['Include_all_modules']		= 'Visa alla moduler';
$lang['Include_block_quickedit']	= 'Inkludera blockinst�llningar';
$lang['Include_block_private']		= 'Inkludera blockr�ttigheter';
$lang['Include_all_pages']			= 'Visa alla sidor';
$lang['View']                      	= 'L�sa';
$lang['Edit']                      	= 'Redigera';
$lang['Settings']                  	= 'Inst�llningar';
$lang['Delete']                    	= 'Radera';
$lang['Move_up']                   	= 'Flytta upp';
$lang['Move_down']                 	= 'Flytta ner';
$lang['Resync']                    	= 'Synkronisera allt';
$lang['Update']                    	= 'Uppdatera';
$lang['Permissions']				= 'R�ttigheter';
$lang['Permissions_std']			= 'Standardr�ttigheter';
$lang['Permissions_adv']			= 'Avancerade r�ttigheter';
$lang['return_to_page']				= 'Tillbaka till portalsidan';
$lang['Use_default'] 				= 'Anv�nd grundinst�llningar';

$lang['AdminCP_status']						= '<b>Status rapport</b>';
$lang['AdminCP_action']						= '<b>DB h�ndelse</b>';
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

$lang['error_no_field']                    	= 'Du har inte fyllt i alla n�dv�ndiga f�lt...';

//
// Configuration
//
$lang['Portal_admin']              			= 'Portaladministration';
$lang['Portal_admin_explain']      			= 'Anv�nd detta formul�r f�r att skr�ddarsy din portal';
$lang['Portal_General_Config']     			= 'Portalkonfiguration';
$lang['Portal_General_Config_explain'] 		= 'Anv�nd detta formul�r f�r att hantera MXP-portalens huvudinst�llningar.';
$lang['Portal_General_settings']   			= 'Allm�nna inst�llningar';
$lang['Portal_Style_settings']   			= 'Stilinst�llningar';
$lang['Portal_General_config_info'] 		= 'Information om allm�nna inst�llningar';
$lang['Portal_General_config_info_explain'] = 'config.php v�rden - f�r k�nnedom (ingen redigering)';
$lang['Portal_Name']               			= 'Portalens namn:';
$lang['Portal_PHPBB_Url']          			= 'URL till PHPBB (forum) installationen:';
$lang['Portal_Url']                			= 'URL till MXP-installationen:';
$lang['Portal_Config_updated']     			= 'Portalkonfigurationen uppdaterades...';
$lang['Click_return_portal_config'] 		= 'Klicka %sh�r%s f�r att �terg� till Portalkonfigurationen';
$lang['PHPBB_info']                			= 'PHPBB-information';
$lang['PHPBB_version']             			= 'PHPBB-version:';
$lang['PHPBB_script_path']         			= 'PHPBB-script_path:';
$lang['PHPBB_server_name']         			= 'PHPBB-domain (server_name):';
$lang['MX_Portal']							= 'MX-Publisher Portal';
$lang['MX_Modules']							= 'MX-Publisher Moduler';
$lang['Phpbb']								= 'phpBB';
$lang['Top_phpbb_links'] 					= 'Visa (phpBB) statistik i sidhuvudet (default)';
$lang['Top_phpbb_links_explain'] 			= '- l�nkar till ny/ol�st post etc';
$lang['Portal_version']            			= 'MX-Publisher portalversion:';
$lang['Mx_use_cache'] 						= 'Anv�nd MXP blockcache';
$lang['Mx_use_cache_explain'] 				= 'Blockdata sparas i speciella cache/block_x.xml filer. Cachefiler skapas n�r block �ndras.';
$lang['Mx_mod_rewrite'] 					= 'Anv�nd mod_rewrite';
$lang['Mx_mod_rewrite_explain'] 			= 'Om du har en Apache server, med mod_rewrite aktiverat, kan ers�tta de vanliga \'page=x\' etc med mer intuitiva alternativ. Se fullst�ndig dokumentation i mx_mod_rewrite modulen.';
$lang['Portal_Overall_header'] 				= 'Sidhuvudfil (default)';
$lang['Portal_Overall_header_explain'] 		= '- Detta �r grundinst�llningen f�r vilken sidhuvudfil som anv�nds, t ex overall_header.tpl.';
$lang['Portal_Overall_footer'] 				= 'Sidfotfil (default)';
$lang['Portal_Overall_footer_explain'] 		= '- Detta �r grundinst�llningen f�r vilken sidfotfil som anv�nds, t ex overall_footer.tpl.';
$lang['Portal_Main_layout'] 				= 'Sidlayoutfil (default)';
$lang['Portal_Main_layout_explain'] 		= '- Detta �r grundinst�llningen f�r vilken sidlayoutfil som anv�nds, t ex mx_main_layout.tpl.';
$lang['Portal_Navigation_block'] 			= 'Sidhuvudets navigeringsblock (default)';
$lang['Portal_Navigation_block_explain'] 	= '- Detta �r grundinst�llningen f�r vilket navigeringsblock i sidhuvudet som anv�nds.';
$lang['Default_style'] 						= 'Portalstil f�r sidor (standard)';
$lang['Default_admin_style'] 				= 'Portalstil f�r kontrollpanelen(standard)';
$lang['Select_page_style'] 					= 'V�lj (eller anv�nd standard)';
$lang['Override_style'] 					= '�sidos�tt anv�ndarstil';
$lang['Override_style_explain'] 			= 'Ers�tter anv�ndarens stil med standardstilen (f�r portalsidor)';
$lang['Portal_status'] 						= 'Aktivera MX-Publisher';
$lang['Portal_status_explain'] 				= 'Praktisk switch n�r admin underh�ller sajten. N�r MX-Publisher �r inaktiverad visas meddelandet nedan.';
$lang['Disabled_message'] 					= 'Inaktiverad meddelande';
$lang['Portal_Backend'] 					= 'MX-Publisher anv�ndare och sessioner';
$lang['Portal_Backend_explain'] 			= 'V�lj internal, phpBB2 or phpBB3 anv�ndare och sessioner';
$lang['Portal_Backend_path'] 				= 'Relative s�kv�g till phpBB [non-internal]';
$lang['Portal_Backend_path_explain'] 		= 'Om du valt non-internal anv�ndare och sessioner, ange den relativa s�kv�gen till phpbb, t ex \'phpBB2/\' eller \'../phpBB2/\'.';
$lang['Portal_Backend_submit'] 				= 'Byt och validera anv�ndare och sessioner';
$lang['Portal_config_valid'] 				= 'Aktuell status: ';
$lang['Portal_config_valid_true'] 			= '<b><font color="green">Ok</font></b>';
$lang['Portal_config_valid_false'] 			= '<b><font color="red">Fel. Antingen �r din relativa s�kv�g till phpBB felaktig, eller s� �r phpBB inte installerat (din phpBB databas hittas inte). S�lunda anv�nda \'internal\'.</font></b>';

//
// Module Management
//
$lang['Module_admin']              	= 'Moduladministration';
$lang['Module_admin_explain']      	= 'Anv�nd detta formul�r f�r att hantera portalmodulerna - installation, uppgradering och utveckling.<br /><b>F�r att kunna anv�nda denna sida kr�vs att du aktiverat javascript och cookies i din webbl�sare</b>.';
$lang['Modulecp_admin']				= 'Modulkontrollpanel';
$lang['Modulecp_admin_explain']		= 'Anv�nd detta formul�r f�r att hantera portalmodulerna - blockfunktioner, parametrar & portalblock.<br /><b>F�r att kunna anv�nda denna sida kr�vs att du aktiverat javascript och cookies i din webbl�sare</b>.';
$lang['Modules']                   	= 'Portalmoduler';
$lang['Module']                    	= 'Portalmodul';
$lang['Module_delete']             	= 'Radera en portalmodul';
$lang['Module_delete_explain']     	= 'Anv�nd detta formul�r f�r att radera en portalmodul (eller blockfunktion)';
$lang['Edit_module']               	= 'Redigera en portalmodul';
$lang['Create_module']             	= 'Utveckla ny portalmodul';
$lang['Module_name']               	= 'Modulnamn';
$lang['Module_desc']               	= 'Beskrivning';
$lang['Module_path']               	= 'S�kv�g, t ex "modules/mx_textblocks"';
$lang['Module_include_admin']      	= 'Inkludera denna portalmodul i kontrollpanelens menynavigering (t v)';

//
// Module Installation
//
$lang['Module_delete_db']   		= 'Vill du avinstallera modulen? Varning: denna data kan inte �terskapas. �verv�g att uppgradera ist�llet...';
$lang['Click_module_delete_yes']   	= 'Klicka %sh�r%s f�r att avinstallera modulen';
$lang['Click_module_upgrade_yes']	= 'Klicka %sh�r%s f�r att uppgradera modulen';
$lang['Click_module_export_yes']	= 'Klicka %sh�r%s f�r att exportera modulen';
$lang['Error_no_db_install'] 		= 'Fel: filen db_install.php finns inte. V�nligen verifiera och f�rs�k igen...';
$lang['Error_no_db_uninstall'] 		= 'Fel: filen db_uninstall.php finns inte eller avinstallations m�jligheterna st�ds inte f�r denna modul. V�nligen verifiera och f�rs�k igen...';
$lang['Error_no_db_upgrade'] 		= 'Fel: filen db_upgrade.php finns inte eller s� st�ds inte uppgraderingsm�jligheterna av denna modul. V�nligen verifiera och f�rs�k igen...';
$lang['Error_module_installed'] 	= 'Fel: Denna modul �r redan installerad! V�nligen antingen radera modulen eller uppgradera modulen ist�llet.';
$lang['Uninstall_module'] 			= 'Avinstallera portalmodul';
$lang['import_module_pack']        	= 'Installera portalmodul';
$lang['import_module_pack_explain']	= 'Detta kommmer installera en portalmodul. Var s�ker p� att portalmodulen �r uppladdad till /portalmodul mappen... och anv�nd den senaste versionen!';
$lang['upgrade_module_pack']       	= 'Upgradera portalmodul';
$lang['upgrade_module_pack_explain']= 'Detta kommer uppgradera din portalmodul. Var s�ker p� att l�sa dokumentationen innan du forts�tter, annars kan du f�rlora data.';
$lang['export_module_pack']        	= 'Exportera portalmodul';
$lang['Export_Module']             	= 'V�lj en portalmodul:';
$lang['export_module_pack_explain'] = 'Detta kommer att exportera en portalmodul *.pak fil. Endast avsedd f�r utvecklare/kodare...';
$lang['Module_Config_updated']     	= 'Modulkonfiguration uppdaterades...';
$lang['Click_return_module_admin'] 	= 'Klicka %sh�r%s f�r att �terg� till moduladministrationen';
$lang['Module_updated']            	= 'Modulinformation uppdaterades...';

//
// Functions & Parameters Administration
//
$lang['Function_admin']            	= 'Blockfunktionadministration';
$lang['Function_admin_explain']    	= 'Varje portalmodul har en eller fler blockfunktioner. Anv�nd detta formul�r f�r att redigera, l�gga till, eller radera en blockfunktion';
$lang['Function']                  	= 'Blockfunktion';
$lang['Function_name']             	= 'Blockfunktionsnamn';
$lang['Function_desc']             	= 'Beskrivning';
$lang['Function_file']             	= 'Fil';
$lang['Function_admin_file']       	= 'Fil (Redigera block) <br /> Xtra inst�llningar f�r redigeringspanelen f�r detta block. L�mna tom f�r att anv�nda standardpanelen';
$lang['Create_function']           	= 'L�gg till en ny blockfunktion';
$lang['Delete_function']			= 'Ta bort blockfunktion';
$lang['Delete_function_explain']	= 'Vill du ta bort blockfunktion, och uppdatera alla associerade portalblock? Varning, detta val kan inte �ngras!';
$lang['Click_function_delete_yes']	= 'Klicka %sh�r%s f�r att ta bort blockfunktionen';

$lang['Parameter_admin']           	= 'Parameteradministration';
$lang['Parameter_admin_explain']   	= 'Lista alla parametrar f�r denna funktion';
$lang['Parameter']					= 'Parameter';
$lang['Parameter_name']            	= '<b>Namn</b><br />- anv�nds f�r �tkomst av parametern';
$lang['Parameter_type']            	= '<b>Typ</b>';
$lang['Parameter_default']         	= '<b>Standardv�rde</b>';
$lang['Parameter_function'] 		= '<b>Funktionsanrop/alternativ</b>';
$lang['Parameter_function_explain'] = '<b>Funktionsanrop</b> (f�r parametertyp "Funktion")<br />- du kan anropa en extern funktion f�r att skapa formul�rf�ltet.<br />- T ex: get_list_formatted(\"block_list\",\"{parameter_value}\",\"{parameter_id}[]\")';
$lang['Parameter_function_explain'] .= '<br /><br /><b>Alternativ</b> (f�r parametertyp "Selections")<br />- h�r listar du alla alternativ f�r valm�jligheterna (radiobuttons, checkboxes, drop down menys)';
$lang['Parameter_auth']				= '<b>Endast f�r Admin/Block Moderator</b>';

$lang['Parameters']					= 'Parametrar';
$lang['Parameter_id']              	= 'Id';
$lang['Create_parameter']          	= 'L�gg till en ny parameter';
$lang['Delete_parameter']				= 'Ta bort funktionsparameter';
$lang['Delete_parameter_explain']		= 'Vill du ta bort funktionsparametern, och uppdatera alla associerade portalblock? Varning, detta val kan inte �ngras!';
$lang['Click_parameter_delete_yes']		= 'Klicka %sh�r%s f�r att ta bort funktionsparametern';

//
// Parameter Types
//
$lang['ParType_BBText'] 			= 'Enkelt BBText textblock';
$lang['ParType_BBText_info'] 		= 'Detta �r ett enkelt textblock, som accepterar bbcodes';
$lang['ParType_Html'] 				= 'Enkelt Html textblock';
$lang['ParType_Html_info'] 			= 'Detta �r ett enkelt textblock, som accepterar html';
$lang['ParType_Text'] 				= 'Textf�lt (enkelrad)';
$lang['ParType_Text_info'] 			= 'Detta �r ett enkelt textf�lt';
$lang['ParType_TextArea'] 			= 'Textruta (flera rader)';
$lang['ParType_TextArea_info'] 		= 'Detta �r en enkel textruta';
$lang['ParType_Boolean'] 			= 'Boolean';
$lang['ParType_Boolean_info'] 		= 'Detta �r ett \'ja\' eller \'nej\' val';
$lang['ParType_Number'] 			= 'Nummer';
$lang['ParType_Number_info'] 		= 'Detta �r ett enkelt nummerf�lt';
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
$lang['Block_admin_explain']       	= 'Anv�nd detta formul�r f�r att hantera portalblock.<br /><b>F�r att kunna anv�nda denna sida kr�vs att du aktiverat javascript och cookies i din webbl�sare</b>.';
$lang['Block']                     	= 'Portalblock';
$lang['Show_title'] 				= 'Visa blocktitel?';
$lang['Show_title_explain'] 		= 'Visa eller inte visa blocktiteln';
$lang['Show_block'] 				= 'Visa block?';
$lang['Show_block_explain'] 		= '- om \'nej\', �r blocket dolt f�r alla utom admin';
$lang['Show_stats'] 				= 'Visa statistik?';
$lang['Show_stats_explain'] 		= '- om \'ja\', visas \'senast updaterad av...\' under blocket';
$lang['Show_blocks']               	= 'Visa portalblock';
$lang['Block_delete']              	= 'Radera ett portalblock';
$lang['Block_delete_explain']      	= 'Anv�nd detta formul�r f�r att radera ett portalblock (eller kolumn)';
$lang['Block_title']               	= 'Titel';
$lang['Block_desc']                	= 'Beskrivning';
$lang['Add_Block']                 	= 'L�gg till portalblock';
$lang['Auth_Block']                	= 'R�ttigheter';
$lang['Auth_Block_explain']			= 'ALL: Alla anv�ndare<br />REG: Registrerade anv�ndare<br />PRIVATE: Gruppmedlemmar (se avancerade r�ttigheter)<br />MOD: blockmoderatorer (se avancerade r�ttigheter)<br />ADMIN: Admin<br />ANONYMOS: Ej inloggade anv�ndare (endast)';
$lang['Block_quick_stats']			= 'Block Stats';
$lang['Block_quick_edit']			= 'Snabbinst�llningar';
$lang['Create_block']              	= 'Skapa nytt portalblock';
$lang['Delete_block']				= 'Ta bort portalblock';
$lang['Delete_block_explain']		= 'Vill du ta bort portalblocket, och uppdatera alla portalsidor? Varning, detta val kan inte �ngras!';
$lang['Click_block_delete_yes']		= 'Klicka %sh�r%s f�r att ta bort portalblocket';

//
// BlockCP Administration
//
$lang['Block_cp']                  	= 'Kontrollpanel';
$lang['Click_return_blockCP_admin']	= 'Klicka %sH�r%s f�r att �terv�nda till kontrollpanelen';
$lang['Click_return_portalpage_admin']	= 'Klicka %sH�r%s f�r att �terv�nda till portalsidan';
$lang['BlockCP_Config_updated']		= 'Blockinformationen uppdateras...';

//
// Page Administration
//
$lang['Page_admin']                	= 'Portalsidaadministration';
$lang['Page_admin_explain']			= 'Anv�nd detta formul�r f�r att l�gga till, radera eller �ndra inst�llningar f�r portalsidor och portalsidmallar.<br /><b>F�r att kunna anv�nda denna sida kr�vs att du aktiverat javascript och cookies i din webbl�sare</b>.';
$lang['Page_admin_edit']			= '�ndra';
$lang['Page_admin_private']			= 'Avancerade (PRIVATE) r�ttigheter';
$lang['Page_admin_settings']		= 'Sidinst�llningar';
$lang['Page_admin_new_page']		= 'Ny sida';
$lang['Page']                      	= 'Sida';
$lang['Page_Id']                   	= 'Portalsida ID';
$lang['Page_icon']                 	= 'Portalsidbild <br /> - f�r att anv�ndas i adminCP endast, eg. icon_home.gif (standard)';
$lang['Page_alt_icon']              = 'Alternativ portalsidbild <br /> - Ange full url (http://...) till bilden.';
$lang['Default_page_style'] 		= 'Portalstil (standard)<br />- F�r att anv�nda defaultinst�llningen, l�mna detta f�lt tomt.';
$lang['Override_page_style'] 		= '�sidos�tt anv�ndarstil';
$lang['Override_page_style_explain']= ' ';
$lang['Page_header']               	= 'Sidhuvudfil <br /> - det vill s�ga overall_header.tpl (standard), overall_noheader.tpl (no header) eller egen fil. F�r att anv�nda defaultinst�llningen, l�mna detta f�lt tomt.';
$lang['Page_footer']               	= 'Sidfotfil <br /> - det vill s�ga overall_footer.tpl (standard) eller egen fil. F�r att anv�nda defaultinst�llningen, l�mna detta f�lt tomt.';
$lang['Page_main_layout']           = 'Sidlayoutfil <br /> - det vill s�ga mx_main_layout.tpl (standard) eller egen fil. F�r att anv�nda defaultinst�llningen, l�mna detta f�lt tomt.';
$lang['Page_Navigation_block'] 			= 'Sidhuvudets navigeringsblock';
$lang['Page_Navigation_block_explain'] 	= '- Detta �r valet av sidhuvudets navigeringsblock, f�rutsatt att du valt en sidhuvudfil som st�djer navigeringsblock. F�r att anv�nda defaultinst�llningen, l�mna detta f�lt tomt.';
$lang['Auth_Page']                 	= 'R�ttigheter';
$lang['Select_sort_method']			= 'V�lj sorteringss�tt';
$lang['Order']						= 'Riktning';
$lang['Sort']						= 'Sortera';
$lang['Page_sort_title']			= 'Sidnamn';
$lang['Page_sort_desc']				= 'Sidbeskrivning';
$lang['Page_sort_created']			= 'Sidan skapad';
$lang['Sort_Ascending']				= 'ASC';
$lang['Sort_Descending']			= 'DESC';
$lang['Return_to_page']            	= '�terg� till portalsidan';
$lang['Auth_Page_group'] 			= '-> PRIVAT Grupp';
$lang['Page_desc'] 					= 'Beskrivning';
$lang['Page_parent'] 				= '�verordnad sida';
$lang['Add_Page']                  	= 'L�gg till en ny sida';
$lang['Page_Config_updated']       	= 'Portalsidakonfigurationen uppdaterades...';
$lang['Click_return_page_admin']   	= 'Klicka %sh�r%s f�r att �terv�nda till portalsidaadministrationen';
$lang['Remove_block']				= 'Ta bort portalblock';
$lang['Remove_block_explain']		= 'Vill du ta bort portalblocket fr�n sidan? Varning, detta val kan inte �ngras!';
$lang['Click_block_remove_yes']		= 'Klicka %sh�r%s f�r att ta bort portalblocket';
$lang['Delete_page']				= 'Ta bort sidan';
$lang['Delete_page_explain']		= 'Vill du ta bort sidan? Varning, detta val kan inte �ngras!';
$lang['Click_page_delete_yes']		= 'Klicka %sh�r%s f�r att ta bort sidan';

$lang['Mx_IP_filter']				= 'IP filter';
$lang['Mx_IP_filter_explain']		= 'F�r att begr�nsa tilltr�de till sidan baserat p� IP, ange godk�nda IP-adresser - en per rad. <br> T ex 127.0.0.1 eller 127.0.*.*';
$lang['Mx_phpBB_stats']				= 'Visa (phpBB) statistik i sidhuvudet (default)';
$lang['Mx_phpBB_stats_explain']		= '- l�nkar till ny/ol�st post etc';
$lang['Column_admin']				= 'Sidkolumnadministration';
$lang['Column_admin_explain']		= 'Administrera sidkolumner';
$lang['Column']                    	= 'Sidkolumn';
$lang['Columns']                   	= 'Sidkolumner';
$lang['Column_block']               = 'Sidkolumnblock';
$lang['Column_blocks']              = 'Sidkolumnblock';
$lang['Edit_Column']               	= 'Redigera en kolumn';
$lang['Edit_Column_explain']       	= 'Anv�nd detta formul�r f�r att modifiera en kolumn';
$lang['Column_Size']               	= 'Storleken p� kolumnen';
$lang['Column_name']               	= 'Kolumnnamn';
$lang['Column_delete']             	= 'Radera en kolumn';
$lang['Page_updated']              	= 'Portalsida- och kolumninformation uppdaterades...';
$lang['Create_column']             	= 'L�gg till ny kolumn';
$lang['Delete_page_column']				= 'Ta bort sidkolumn';
$lang['Delete_page_column_explain']		= 'Vill du ta bort sidkolumnen? Varning, detta val kan inte �ngras!';
$lang['Click_page_column_delete_yes']	= 'Klicka %sh�r%s f�r att ta bort sidkolumnen';

$lang['Add_Split_Block'] 			= 'L�gg till kolumndelarblock';
$lang['Add_Split_Block_explain'] 	= 'Detta block delar upp kolumnen';
$lang['Add_Dynamic_Block'] 			= 'L�gg till dynamiskt (sub) block';
$lang['Add_Dynamic_Block_explain'] 	= 'Detta block �r ett dynamiskt block, vars inneh�ll best�ms via navigeringsmenyn';
$lang['Add_Virtual_Block'] 			= 'L�gg till virtuellt (sidblogg) block';
$lang['Add_Virtual_Block_explain'] 	= 'Detta block g�r sidan till en virtuell (blogg-) sida';

//
// Page templates
//
$lang['Page_templates_admin'] 		= 'Kontrollpanel f�r sidmallar';
$lang['Page_templates_admin_explain'] = 'P� denna sida kan du skapa, �ndra och ta bort sidmallar';
$lang['Page_template']				= 'Sidmall';
$lang['Page_templates']				= 'Sidmallar';
$lang['Page_template_column']		= 'Sidmallskolumn';
$lang['Page_template_columns']		= 'Sidmallskolumner';
$lang['Choose_page_template']		= 'V�lj sidmall';
$lang['Template_Config_updated'] 	= 'Sidmallskonfigurationen uppdaterades...';
$lang['Add_Template'] 				= 'L�gg till sidmall';
$lang['Template'] 					= 'Sidmall';
$lang['Template_name']				= 'Sidmallens namn';
$lang['Page_template_delete'] 		= 'Ta bort sidmall';
$lang['Delete_page_template']			= 'Ta bort sidmall';
$lang['Delete_page_template_explain']	= 'Vill du ta bort sidmallen? Varning, detta val kan inte �ngras!';
$lang['Click_page_template_delete_yes']	= 'Klicka %sh�r%s f�r att ta bort sidmallen';
$lang['Delete_page_template_column']			= 'Ta bort sidmallskolumn';
$lang['Delete_page_template_column_explain']	= 'Vill du ta bort sidmallskolumnen? Varning, detta val kan inte �ngras!';
$lang['Click_page_template_column_delete_yes']	= 'Klicka %sh�r%s f�r att ta bort sidmallskolumnen';

//
// Cache
//
$lang['Cache_dir_write_protect']   	= 'Din cachemapp �r skrivskyddad, kan inte skapa cachefilerna';
$lang['Cache_generate']            	= 'Dina cachefiler �r skapade';
$lang['Cache_submit']              	= 'Generera cachefilerna?';
$lang['Cache_explain']             	= 'Nu kan du skapa alla xml-filer (cachefiler) f�r systemet. Dessa filer hj�lper till att minska antalet fr�gor till databasen och f�rb�ttra portalprestandan.<br />Notera: Du m�ste aktivera cachefunktionen (Portal hantering adminCP) f�r att cachefilerna skall l�sas.<br />Notera vidare: Cachefilerna skapas automatiskt av systemet n�r block �ndras.';
$lang['Generate_mx_cache'] 			= 'Skapa cachefiler';

//
// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!
//
$lang['Menu_Navigation']           	= 'Navigationsmeny';
$lang['Portal_index']              	= 'Portalindex';
$lang['Save_Settings']             	= 'Spara inst�llningar';
$lang['Translation_Tools']         	= '�vers�ttningsverktyg';
$lang['Preview_portal']            	= 'F�rhandsgranska portal';

//
// META Administration
//
$lang['Meta_admin']                	= 'Meta Tag administration';
$lang['Mega_admin_explain']        	= 'Anv�nd detta formul�r f�r att skr�ddarsy din Meta information';
$lang['Meta_Title']                	= 'Titel';
$lang['Meta_Author']               	= 'F�rfattare';
$lang['Meta_Copyright']            	= 'Copyright';
$lang['Meta_Keywords']             	= 'Nyckelord';
$lang['Meta_Keywords_explain']     	= '(kommaseparerad lista)';
$lang['Meta_Description']          	= 'Beskrivning';
$lang['Meta_Language']             	= 'Spr�kkod';
$lang['Meta_Rating']               	= 'R�stning';
$lang['Meta_Robots']               	= 'Robots';
$lang['Meta_Pragma']               	= 'Pragma no-cache';
$lang['Meta_Bookmark_icon']        	= 'Bokm�rkesbild';
$lang['Meta_Bookmark_explain']     	= '(relativ plats)';
$lang['Meta_HTITLE']               	= 'Extra huvudinst�llningar';
$lang['Meta_data_updated']			= 'Meta data file (mx_meta.inc) has been updated!<br />Click %sHERE%s to return to Meta Tags Administration.';
$lang['Meta_data_ioerror']			= 'Unable to open mx_meta.inc. Make sure the file is writable (chmod 777).';

//
// Permissions
//
$lang['Mx_Block_Auth_Title'] 		= 'Blockr�ttigheter (PRIVATE)' ;
$lang['Mx_Block_Auth_Explain'] 		= 'H�r konfigurerar du dina blockr�ttigheter';
$lang['Mx_Page_Auth_Title'] 		= 'Sidr�ttigheter (PRIVATE)' ;
$lang['Mx_Page_Auth_Explain'] 		= 'H�r konfigurerar du dina sidr�ttigheter';
$lang['Block_Auth_successfully'] 	= 'Blockr�ttigheterna uppdaterades...';
$lang['Click_return_block_auth'] 	= 'Klicka %sh�r%s f�r att �terg� till blockr�ttigheterna';
$lang['Page_Auth_successfully'] 	= 'Sidr�ttigheterna uppdaterades...';
$lang['Click_return_page_auth'] 	= 'Klicka %sh�r%s f�r att �terg� till sidr�ttigheterna';
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
$lang['target_block']				= 'M�lblock';
$lang['target_block_explain']		= '- l�nkar, data etc h�nvisar till detta block';

//
// Split column
//
$lang['block_ids']            		= 'K�llblock';
$lang['block_ids_explain']          = '- att placeras v�nster till h�ger';
$lang['block_sizes']   				= 'Blockstorlek, kommaseparerad lista';
$lang['block_sizes_explain']   		= '- anv�nd relativa m�tt, t ex \'40%\' och \'*\' f�r att fylla ut';
$lang['space_between'] 				= 'Mellanrum';

//
// Stats
//
$lang['log_filter_date'] 			= 'Datumfilter';
$lang['log_filter_date_explain'] 	= '- Visa log fr�n senaste dagen, veckan, m�ndaden, �ret...';
$lang['numOfEvents']				= 'Antal';
$lang['numOfEvents_explain']		= '- Antal h�ndelser att visa';

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
$lang['x_mode_explain'] 			= '- IncludeX blocket anv�nds p� olika s�tt beroende p� funktionsval. Om du v�ljer \'Lyssna (GET)\', best�ms funktionen genom att skicka med informationen i urlen: \'x_mode=mode\' och associerade parametrar \'x_1=, x_2=, etc\'.<br />Exemplel: F�r att anv�nda en url i en iframe: \'domain/index.php?page=x&x_mode=iframe&x_1=http://domain\'  ';
$lang['x_1'] 						= 'Variabel 1:';
$lang['x_1_explain'] 				= '- <i>IFrame:</i> url<br /><i>Textfil:</i> relativ s�kv�g till filen (t ex \'/include_file/min_fil.xxx\')<br /><i>Multimedia:</i> relativ s�kv�g till filen (t ex \'/include_file/min_fil.xxx\')<br /><i>Bild:</i> relativ s�kv�g till filen (t ex \'/include_file/min_fil.xxx\')<br /><i>Formaterad textfil:</i> not available';
$lang['x_2'] 						= 'Variabel 2:';
$lang['x_2_explain'] 				= '- <i>IFrame:</i> ramh�jd (pixlar)<br /><i>Multimedia:</i> bredd (pixlar)';
$lang['x_3'] 						= 'Variabel 3:';
$lang['x_3_explain'] 				= '- <i>Multimedia:</i> h�jd (pixlar)';

//
// Dynamic Block
//
$lang['default_block_id']			= 'Basblock';
$lang['default_block_id_explain']	= '- Detta block visas (f�rst) om inget dynamiskt block �r givet';

//
// Menu Navigation
//
$lang['menu_display_mode']				= 'Layoutl�ge';
$lang['menu_display_mode_explain ']		= 'Horisontellt eller vertikalt layoutl�ge';
$lang['menu_custom_tpl']				= 'Alternativ stilfil';
$lang['menu_custom_tpl_explain ']		= 'Filnamn p� alternativ stilfil, t ex mx_menu_custom.tpl';
$lang['menu_page_parent']				= 'Toppsida';
$lang['menu_page_parent_explain ']		= 'Navigera fr�n denna sida och ner';

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