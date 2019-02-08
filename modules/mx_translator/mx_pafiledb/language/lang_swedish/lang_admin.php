<?php
/**
*
* @package MX-Publisher Module - mx_pafiledb
* @version $Id: lang_admin.php,v 1.3 2008/06/03 20:16:02 jonohlsson Exp $
* @copyright (c) 2002-2006 [Jon Ohlsson, Mohd Basri, wGEric, PHP Arena, pafileDB, CRLin] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// adminCP index
//
$lang['pafileDB_Download'] = 'PafileDB Admin';
$lang['0_Configuration'] = 'Inst�llningar';
$lang['1_Cat_manage'] = 'Kategorihantering';
$lang['2_File_manage'] = 'Filhantering';
$lang['3_Permissions'] = 'R�ttigheter';
$lang['4_License'] = 'Licenser';
$lang['5_Custom_manage'] = 'Extra f�lt';
$lang['6_Fchecker'] = 'Filkontroll';

//
// Parameter Types
//
$lang['ParType_pa_mapping'] = 'pafileDB category mapping';
$lang['ParType_pa_mapping_info'] = '';

$lang['ParType_pa_quick_cat'] = 'pafileDB grundkategori';
$lang['ParType_pa_quick_cat_info'] = '';

//
// Parameter Names
//
$lang['pa_mapping'] = 'pafileDB category mapping';
$lang['pa_mapping_explain'] = 'pafileDB categories and portal dynamic blocks mapping';

$lang['pa_quick_cat'] = 'pafileDB grundkategori';
$lang['pa_quick_cat_explain'] = 'Denna kategori v�ljs n�r ingen mappning matchar';

//
// Admin Panels - Configuration
//
$lang['Panel_config_title'] = 'Inst�llningar';
$lang['Panel_config_explain'] = 'H�r best�mmer du alla allm�nna konfigurationsinst�llningar.';

//
// General
//
$lang['General_title'] = 'Allm�nt';

$lang['Module_name'] = 'Databasens namn';
$lang['Module_name_explain'] = 'Detta �r namnet p� din nerladdningsdatabas, t ex \'Min databas\'';

$lang['Enable_module'] = 'Aktivera modulen';
$lang['Enable_module_explain'] = 'N�r modulen �r inaktiverad f�r anv�ndare har fortfarande administrat�ren tilltr�de.';

$lang['Wysiwyg_path'] = 'Var finns wysiwyg mjukvaran?';
$lang['Wysiwyg_path_explain'] = 'S�v�gen till (fr�n MX-Publisher roten) mappen d�r wysiwyg mjukvaran �r uppladdad, t ex \'modules/mx_shared/\' om tinymce finns i mappen modules/mx_shared/tinymce.';

$lang['Upload_directory'] = 'Uppladdningsmapp';
$lang['Upload_directory_explain'] = 'Enter the relative path from your root installation (where phpBB or MX-Publisher is located) to the files upload directory. If you stick to the file structure provided in the shipped package, enter \'pafiledb/uploads/\'.';

$lang['Screenshots_directory'] = 'Screenshots Directory';
$lang['Screenshots_directory_explain'] = 'Enter the relative path from your root installation (where phpBB or MX-Publisher is located) to the Screenshots upload directory. If you stick to the file structure provided in the shipped package, enter \'pafiledb/images/screenshots/\'.';

//
// File
//
$lang['File_title'] = 'Filer';

$lang['Hotlink_prevent'] = 'Hotlink Prevention';
$lang['Hotlinl_prevent_info'] = 'Set this to yes if you don\'t want to allow hotlinks to the files';

$lang['Hotlink_allowed'] = 'Allowed domains for hotlink';
$lang['Hotlink_allowed_info'] = 'Allowed domains for hotlink (separated by a comma), for example, www.phpbb.com, www.forumimages.com';

$lang['Php_template'] = 'PHP i mallen';
$lang['Php_template_info'] = 'Detta l�ter dig anv�nda PHP direkt i mallfilerna';

$lang['Max_filesize'] = 'Max filstorlek';
$lang['Max_filesize_explain'] = 'Max filstorlek. V�rdet 0 betyder \'obegr�nsat\'. Detta v�rde begr�nsas av din server. Om din PHP-installation begr�nsar filer till 2 MB kan inte detta v�rde �verstigas.';

$lang['Forbidden_extensions'] = 'F�rbjudna fil�ndelser';
$lang['Forbidden_extensions_explain'] = 'H�r anger du en kommaseparerad lista med f�rbjudna fil�ndelser.';

$lang['Bytes'] = 'Bytes';
$lang['KB'] = 'KB';
$lang['MB'] = 'MB';

//
// Appearance
//
$lang['Appearance_title'] = 'Utseende';

$lang['File_pagination'] = 'Filer och sidbrytning';
$lang['File_pagination_explain'] = 'Antal filer att visa innan sidbrytning.';

$lang['Sort_method'] = 'Sorteringss�tt';
$lang['Sort_method_explain'] = 'Best�m hur filer sorteras inom sin kategori.';

$lang['Sort_order'] = 'ASC eller DESC sortering';
$lang['Sort_order_explain'] = '';

$lang['Topnum'] = 'X antal toppnerladdade filer';
$lang['Topnuminfo'] = 'Detta best�mmer antal filer som visas p� \'Top X Downloaded files\' listan';

$lang['Showva'] = 'Visa \'Visa alla filer\'';
$lang['Showvainfo'] = 'V�lj om \'Visa alla filer\' alternativet skall visas p� varje sida';

$lang['Use_simple_navigation'] = 'Enkel kategorinavigering';
$lang['Use_simple_navigation_explain'] = 'Enklare navigering...';

$lang['Cat_col'] = 'Antal kategorikolumner (anv�nds bara vid \'Enkel kategorinavigering\')';

$lang['Nfdays'] = 'Antal dagar nya';
$lang['Nfdaysinfo'] = 'Antal dagar en fil visas som ny, med en \'Ny fil\' ikon. Om v�rdet s�tt till 5, kommer alla filer uppladdade de senaste 5 dagarna visas med en \'Ny fil\' ikon';

//
// Comments
//
$lang['Comments_title'] = 'Kommentarer';
$lang['Comments_title_explain'] = 'Vissa kommentarinst�llningar �r defaultv�rden, och kan �ndras per kategori';

$lang['Use_comments'] = 'Kommentarer';
$lang['Use_comments_explain'] = 'Aktivera kommentarer.';

$lang['Internal_comments'] = 'Interna eller phpBB kommentarer';
$lang['Internal_comments_explain'] = 'Anv�nd interna eller phpBB kommentarer';

$lang['Select_topic_id'] = 'V�lj phpBB kommentarforum!';

$lang['Internal_comments_phpBB'] = 'phpBB kommentarer';
$lang['Internal_comments_internal'] = 'Interna kommentarer';

$lang['Forum_id'] = 'phpBB Forum ID';
$lang['Forum_id_explain'] = 'Om phpBB kommentarer anv�nds �r detta det forum d�r kommentarerna samlas';

$lang['Autogenerate_comments'] = 'Skapa autokommentarer';
$lang['Autogenerate_comments_explain'] = 'N�r en fil �ndras/skrivs, g�rs ett inl�gg i kommentarforumet automatiskt.';

$lang['Del_topic'] = 'Ta bort forumkommentarer';
$lang['Del_topic_explain'] = 'N�r en fil tas bort, skall �ven associerade forumkommentarer tas bort?';

$lang['Comments_pag'] = 'Kommentarer och sidbrytning';
$lang['Comments_pag_explain'] = 'Antal kommentarer att visa innan sidbrytning.';

$lang['Allow_Wysiwyg'] = 'Anv�nd wysiwyg editor';
$lang['Allow_Wysiwyg_explain'] = 'Om aktiverad, ers�tts den vanliga bbcode/html/smilies redigeraren med en wysiwyg editor.';

$lang['Allow_links'] = 'Till�t l�nkar';
$lang['Allow_links_message'] = 'Default \'inga l�nkar\' meddelande';
$lang['Allow_links_explain'] = 'Om l�nkar ej �r till�tna visas detta meddelande ist�llet';

$lang['Allow_images'] = 'Till�t bilder';
$lang['Allow_images_message'] = 'Default \'No Images\' meddelande';
$lang['Allow_images_explain'] = 'Om bilder ej �r till�tna visas detta meddelande ist�llet';

$lang['Max_subject_char'] = 'Max antal tecken (i titel)';
$lang['Max_subject_char_explain'] = 'Om man skriven en titel med fler tecken visas ett felmeddelande.';

$lang['Max_desc_char'] = 'Max antal tecken (i beskrivning)';
$lang['Max_desc_char_explain'] = 'Om man skriven en titel med fler tecken visas ett felmeddelande.';

$lang['Max_char'] = 'Max antal tecken';
$lang['Max_char_explain'] = 'Om man skriven en kommentar med fler tecken visas ett felmeddelande.';

$lang['Format_wordwrap'] = 'Avstavning';
$lang['Format_wordwrap_explain'] = '';

$lang['Format_truncate_links'] = 'F�rkorta l�nkar';
$lang['Format_truncate_links_explain'] = 'L�nkar skrivs om, t ex \'www.mxp-portal...\'';

$lang['Format_image_resize'] = 'Skala om bilder';
$lang['Format_image_resize_explain'] = 'Bilder omskalas till denna bredd (pixlar)';

//
// Ratings
//
$lang['Ratings_title'] = 'Betygs�ttning';
$lang['Ratings_title_explain'] = 'Vissa inst�llning �r grundinst�llningar och kan �ndras per kategori';

$lang['Use_ratings'] = 'Betygs�ttning (r�sta)';
$lang['Use_ratings_explain'] = 'Aktivera betygs�ttning';

$lang['Votes_check_ip'] = 'Godk�nn r�stningar - IP';
$lang['Votes_check_ip_explain'] = 'Endast en r�st per IP-adress godk�nns.';

$lang['Votes_check_userid'] = 'Godk�nn r�stningar - anv�ndare';
$lang['Votes_check_userid_explain'] = 'Anv�ndare f�r endast r�sta en g�ng.';

//
// Instructions
//
$lang['Instructions_title'] = 'Anv�ndarinstruktioner';

$lang['Pre_text_name'] = 'Instruktionstext';
$lang['Pre_text_explain'] = 'Aktivera instruktionstext som visas f�r anv�ndare d� de skall ladda upp en fil.';

$lang['Pre_text_header'] = 'Instruktionstextens - rubrik';
$lang['Pre_text_body'] = 'Instruktionstext - text';

$lang['Show'] = 'Visa';
$lang['Hide'] = 'D�lj';

//
// Notifications
//
$lang['Notifications_title'] = 'P�minnelser';

$lang['Notify'] = 'Informera admin via: ';
$lang['Notify_explain'] = 'Best�m p� vilket s�tt admin skall bli informerad om nya/redigerade artiklar';
$lang['PM'] = 'PM';

$lang['Notify_group'] = 'och till grupp: ';
$lang['Notify_group_explain'] = 'Informera dessutom medlemmarna i denna grupp.';

//
// Permissions
//
$lang['Permission_settings'] = 'R�ttigheter';

$lang['Auth_search'] = 'S�k r�ttighet';
$lang['Auth_search_explain'] = 'Till�t s�kning av vissa typer av anv�ndare';

$lang['Auth_stats'] = 'Statistik';
$lang['Auth_stats_explain'] = 'Till�t statistik f�r vissa typer av anv�ndare';

$lang['Auth_toplist'] = 'Topplista';
$lang['Auth_toplist_explain'] = 'Till�t topplista f�r vissa typer av anv�ndare';

$lang['Auth_viewall'] = 'Visa alla filer';
$lang['Auth_viewall_explain'] = 'Till�t \'visa alla filer\' f�r vissa typer av anv�ndare';

$lang['Settings'] = 'Konfiguration';
$lang['Settings_changed'] = 'Inst�llningarna uppdaterades...';

//
// Admin Panels - Categories
//
$lang['Panel_cat_title'] = 'Kategorihantering';
$lang['Panel_cat_explain'] = 'Du anv�nder denna panel f�r att skapa, �ndra, tabort och sortera kategorier. F�r att kunna ladda upp en fil till databasen kr�vs minst en kategori.';

$lang['Use_default'] = 'Andv�nd grundinst�llning';

$lang['Maintenance'] = 'Filunderh�ll';
$lang['Acat'] = 'Kategori: L�gg till';
$lang['Ecat'] = 'Kategori: �ndra';
$lang['Dcat'] = 'Kategori: Ta bort';
$lang['Rcat'] = 'Kategori: Sortera';
$lang['Cat_Permissions'] = 'Kategorir�ttigheter';
$lang['User_Permissions'] = 'Anv�ndarr�ttigheter';
$lang['Group_Permissions'] = 'Gruppr�ttigheter';
$lang['User_Global_Permissions'] = 'Allm�nna anv�ndarr�ttigheter';
$lang['Group_Global_Permissions'] = 'Allm�nna gruppr�ttigheter';
$lang['Acattitle'] = 'L�gg till kategori';
$lang['Ecattitle'] = '�ndra kategori';
$lang['Dcattitle'] = 'Ta bort kategori';
$lang['Rcattitle'] = 'Sortera kategorier';
$lang['Catexplain'] = 'Du anv�nder denna panel f�r att skapa, �ndra, tabort och sortera kategorier. F�r att kunna ladda upp en fil till databasen kr�vs minst en kategori.';
$lang['Rcatexplain'] = 'Sortera kategorier f�r att kontrollera i vilken ordning de skall visas.';
$lang['Catadded'] = 'Kategorin skapades...';
$lang['Catname'] = 'Kategorinamn';
$lang['Catnameinfo'] = 'Kategorins namn.';
$lang['Catdesc'] = 'Kategoribeskrivning';
$lang['Catdescinfo'] = 'Kategorins beskrivning';
$lang['Catparent'] = '�verordnad kategori';
$lang['Catparentinfo'] = 'Om du vill att detta skall vara en subkategori, ange i s� fall till vilken kategori den skall vara underordnad.';
$lang['Allow_file'] = 'Till�t l�gga till filer';
$lang['Allow_file_info'] = 'Om du inte till�ter att filer l�ggs till denna kategori, s� blir kategorin en toppniv�kategori - en plats med subkategorier.';
$lang['None'] = 'Ingen';
$lang['Catedited'] = 'Kategorin �ndrades...';
$lang['Delfiles'] = 'Vad vill du g�ra med filerna i denna kategorin?';
$lang['Do_cat'] = 'Vad vill du g�ra med subkategorin i denna kategori?';
$lang['Move_to'] = 'Flytta till';
$lang['Catsdeleted'] = 'Kategorin (kategorierna) togs bort...';
$lang['Cdelerror'] = 'Du valde inga kategorier att ta bort.';
$lang['Rcatdone'] = 'Kategorierna sorterades...';

//
// Admin Panels - File Maintainance
//
$lang['Fchecker'] = 'Fil: Underh�ll';
$lang['File_checker'] = 'Filunderh�ll';
$lang['File_checker_explain'] = 'Here you can perform a checking for all file in database and the file in the download directory.';
$lang['File_saftey'] = 'File maintenance will attempt to delete all files and screenshots that are currently not needed and will remove any file records where the file has been deleted and will clear all screenshots that are not found.<br /><br />If the files do not start with <FONT COLOR="#FF0000">{html_path}</FONT> then the files will be skipped for security reasons.<br /><br />Please make sure that <FONT COLOR="#FF0000">{html_path}</FONT> is the path that you use for your files.<br /><br />.';

$lang['File_checker_perform'] = 'Genomf�r kontroll';
$lang['Checker_saved'] = 'Totalt sparat utrymme';
$lang['Checker_sp1'] = 'Kontrollerar felaktiga/saknade filer...';
$lang['Checker_sp2'] = 'Kontrollerar felaktiga/saknade screenshots...';
$lang['Checker_sp3'] = 'Tar bort ej anv�nda filer...';

//
// Admin Panels - Permissions
//
$lang['View'] = 'Visa';
$lang['Read'] = 'L�sa';
$lang['View_file'] = 'Visa fil';
$lang['Delete_file'] = 'Ta bort fil';
$lang['Edit_file'] = '�ndra fil';
$lang['Upload'] = 'Ladda upp fil';
$lang['Approval'] = 'Godk�nna fil';
$lang['Approval_edit'] = 'Godk�nna �ndrade filer';
$lang['Download_file'] = 'Ladda ner fil';
$lang['Rate'] = 'R�sta';
$lang['View_comment'] = 'Visa kommentarer';
$lang['Post_comment'] = 'Skriv kommentarer';
$lang['Edit_comment'] = '�ndra kommentarer';
$lang['Delete_comment'] = 'Ta bort kommentarer';
$lang['Category_auth_updated'] = 'Kategorir�ttigheterna uppdaterades...';
$lang['Click_return_catauth'] = 'Klicka %sh�r%s f�r att �terg� till kategorir�ttigheterna';
$lang['Auth_Control_Category'] = 'Kategorir�ttigheter - panel';
$lang['Category_auth_explain'] = 'H�r bet�mmer du kategorir�ttigheter. Kontrollera dina inst�llningar noga s� att anv�ndare inte f�r tilltr�de till obeh�riga filer.';
$lang['Select_a_Category'] = 'V�lj kategori';
$lang['Look_up_Category'] = 'Unders�k kategori';
$lang['Category'] = 'Kategori';

$lang['Category_NONE'] = 'INGEN';
$lang['Category_ALL'] = 'ALLA';
$lang['Category_REG'] = 'REGISTRERAD';
$lang['Category_PRIVATE'] = 'PRIVAT';
$lang['Category_MOD'] = 'MOD';
$lang['Category_ADMIN'] = 'ADMIN';

//
// Admin Panels - Custom Fields
//
$lang['Fieldselecttitle'] = 'V�lj ett alternativ';
$lang['Afield'] = 'Extra f�lt: l�gg till';
$lang['Efield'] = 'Extra f�lt: �ndra';
$lang['Dfield'] = 'Extra f�lt: ta bort';
$lang['Mfieldtitle'] = 'Extra f�lt';
$lang['Afieldtitle'] = 'L�gg till f�lt';
$lang['Efieldtitle'] = '�ndra f�lt';
$lang['Dfieldtitle'] = 'Ta bort f�lt';
$lang['Fieldexplain'] = 'H�r kan du l�gga till extra f�lt. Om du exempelvis vill ha ett f�lt d�r anv�ndaren kan ange filstorleken sj�lv, skapar du ett s�dant f�lt.';
$lang['Fieldname'] = 'F�ltnamn';
$lang['Fieldnameinfo'] = 'Detta �r f�ltnamnet, t ex \'Filstorlek\'';
$lang['Fielddesc'] = 'F�ltbeskrivning';
$lang['Fielddescinfo'] = 'Detta �r en f�ltbeskrivning, t ex \'Storlek p� filen\'';
$lang['Fieldadded'] = 'F�ltet lades till';
$lang['Fieldedited'] = 'F�ltet �ndrades...';
$lang['Dfielderror'] = 'Du valde inga f�lt att ta bort';
$lang['Fieldsdel'] = 'F�ltet togs bort...';

$lang['Field_data'] = 'Options';
$lang['Field_data_info'] = 'Enter the options that the user can choose from. Separate each option with a new-line (carriage return).';
$lang['Field_regex'] = 'Regular Expression';
$lang['Field_regex_info'] = 'You may require the input field to match a regular expression %s(PCRE)%s.';
$lang['Field_order'] = 'Display Order';

//
// Admin Panels - License
//
$lang['License_title'] = 'Licenser';
$lang['Alicense'] = 'Licens: l�gg till';
$lang['Elicense'] = 'Licens: �ndra';
$lang['Dlicense'] = 'Licens: ta bort';
$lang['Alicensetitle'] = 'L�gg till licens';
$lang['Elicensetitle'] = '�ndra licens';
$lang['Dlicensetitle'] = 'Ta bort licens';
$lang['Licenseexplain'] = 'H�r kan du hantera licenser - l�gga till, �ndra och ta bort. Ett licensavtal visas innan anv�ndare f�r ladda ner filen.';
$lang['Lname'] = 'Licenstitel';
$lang['Ltext'] = 'Licenstext';
$lang['Licenseadded'] = 'Licensinformationen lades till...';
$lang['Licenseedited'] = 'Licensinformationen togs bort...';
$lang['Lderror'] = 'Du valde ingen licensinformtaion att ta bort';
$lang['Ldeleted'] = 'Licensinformationen du valde har tagits bort...';

$lang['Click_return'] = 'Klicka %sh�r%s f�r att �terg� till f�reg�ende sida';
$lang['Click_edit_permissions'] = 'Klicka %sh�r%s f�r att �ndra kategorir�ttigheter';

//Java script messages and php errors
$lang['Cat_name_missing'] = 'Ange kategorinamnet';
$lang['Cat_conflict'] = 'Du kan inte ha en kategori utan filer i en annan kateogri utan filer';
$lang['Cat_id_missing'] = 'V�lj en kategori';
$lang['Missing_field'] = 'Fyll i alla n�dv�ndiga f�lt';

//
// Admin Panels - Field Types
//
$lang['Field_Input'] = 'Single-Line Text Box';
$lang['Field_Textarea'] = 'Multiple-Line Text Box';
$lang['Field_Radio'] = 'Single-Selection Radio Buttons';
$lang['Field_Select'] = 'Single-Selection Menu';
$lang['Field_Select_multiple'] = 'Multiple-Selection Menu';
$lang['Field_Checkbox'] = 'Multiple-Selection Checkbox';

$lang['Com_settings'] = 'Inst�llningar f�r kommentarer';
$lang['Validation_settings'] = 'Inst�llningar f�r godk�nnande';
$lang['Ratings_settings'] = 'Inst�llningar f�r betygs�ttning';
$lang['PM_notify'] = 'PM information (till admin)';

$lang['Use_comments'] = 'Aktivera kommentarer';
$lang['Allow_comments'] = 'Till�t kommentarer';
$lang['Allow_comments_info'] = 'Aktivera/inaktivera kommentarer i denna kategori.';

$lang['Use_ratings'] = 'Aktivera betygs�ttning';
$lang['Allow_ratings'] = 'Till�t omr�stningar';
$lang['Allow_ratings_info'] = 'Aktivera/inaktivera r�stningar i denna kategori.';

$lang['Fileadded_not_validated'] = 'Filen laddades upp, men en admin (eller moderator) m�ste godk�nna filen innan andra kan anv�nda den.';

//
// Toplists
//
$lang['toplist_sort_method']     	= 'Typ av toplista';
$lang['toplist_display_options']    = 'Visningsalternativ';
$lang['toplist_use_pagination']     = 'Bl�ddra \'antal rader\' i taget';
$lang['toplist_pagination']         = 'Antal rader';
$lang['toplist_filter_date'] 			= 'Datumfilter';
$lang['toplist_filter_date_explain'] 	= '- Visa inl�gg fr�n senaste dagen, veckan, m�ndaden, �ret...';
$lang['toplist_cat_id']       		= 'Begr�nsa till kategori';
$lang['target_block']       		= 'Associerat pafileDB block';

//
// Mini
//
$lang['mini_display_options']    = 'Visningsalternativ';
$lang['mini_pagination']         = 'Antal rader';
$lang['mini_default_cat_id']     = 'Begr�nsa till kategori';

//
// Quickdl
//
$lang['Panel_title']							= 'pafileDB associering';
$lang['Panel_title_explain']					= 'H�r kan du associera dynamiska portalblock och filkategorier. Kategorin kommer visas om det dynamiska blocket �r aktivt.';

$lang['Map_pafiledb']							= 'V�lj en filkategori...';
$lang['Map_mxbb']								= '...som skall associeras med ett portalblock';
?>