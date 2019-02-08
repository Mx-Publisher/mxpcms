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
$lang['0_Configuration'] = 'Inställningar';
$lang['1_Cat_manage'] = 'Kategorihantering';
$lang['2_File_manage'] = 'Filhantering';
$lang['3_Permissions'] = 'Rättigheter';
$lang['4_License'] = 'Licenser';
$lang['5_Custom_manage'] = 'Extra fält';
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
$lang['pa_quick_cat_explain'] = 'Denna kategori väljs när ingen mappning matchar';

//
// Admin Panels - Configuration
//
$lang['Panel_config_title'] = 'Inställningar';
$lang['Panel_config_explain'] = 'Här bestämmer du alla allmänna konfigurationsinställningar.';

//
// General
//
$lang['General_title'] = 'Allmänt';

$lang['Module_name'] = 'Databasens namn';
$lang['Module_name_explain'] = 'Detta är namnet på din nerladdningsdatabas, t ex \'Min databas\'';

$lang['Enable_module'] = 'Aktivera modulen';
$lang['Enable_module_explain'] = 'När modulen är inaktiverad för användare har fortfarande administratören tillträde.';

$lang['Wysiwyg_path'] = 'Var finns wysiwyg mjukvaran?';
$lang['Wysiwyg_path_explain'] = 'Sövägen till (från MX-Publisher roten) mappen där wysiwyg mjukvaran är uppladdad, t ex \'modules/mx_shared/\' om tinymce finns i mappen modules/mx_shared/tinymce.';

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
$lang['Php_template_info'] = 'Detta låter dig använda PHP direkt i mallfilerna';

$lang['Max_filesize'] = 'Max filstorlek';
$lang['Max_filesize_explain'] = 'Max filstorlek. Värdet 0 betyder \'obegränsat\'. Detta värde begränsas av din server. Om din PHP-installation begränsar filer till 2 MB kan inte detta värde överstigas.';

$lang['Forbidden_extensions'] = 'Förbjudna filändelser';
$lang['Forbidden_extensions_explain'] = 'Här anger du en kommaseparerad lista med förbjudna filändelser.';

$lang['Bytes'] = 'Bytes';
$lang['KB'] = 'KB';
$lang['MB'] = 'MB';

//
// Appearance
//
$lang['Appearance_title'] = 'Utseende';

$lang['File_pagination'] = 'Filer och sidbrytning';
$lang['File_pagination_explain'] = 'Antal filer att visa innan sidbrytning.';

$lang['Sort_method'] = 'Sorteringssätt';
$lang['Sort_method_explain'] = 'Bestäm hur filer sorteras inom sin kategori.';

$lang['Sort_order'] = 'ASC eller DESC sortering';
$lang['Sort_order_explain'] = '';

$lang['Topnum'] = 'X antal toppnerladdade filer';
$lang['Topnuminfo'] = 'Detta bestämmer antal filer som visas på \'Top X Downloaded files\' listan';

$lang['Showva'] = 'Visa \'Visa alla filer\'';
$lang['Showvainfo'] = 'Välj om \'Visa alla filer\' alternativet skall visas på varje sida';

$lang['Use_simple_navigation'] = 'Enkel kategorinavigering';
$lang['Use_simple_navigation_explain'] = 'Enklare navigering...';

$lang['Cat_col'] = 'Antal kategorikolumner (används bara vid \'Enkel kategorinavigering\')';

$lang['Nfdays'] = 'Antal dagar nya';
$lang['Nfdaysinfo'] = 'Antal dagar en fil visas som ny, med en \'Ny fil\' ikon. Om värdet sätt till 5, kommer alla filer uppladdade de senaste 5 dagarna visas med en \'Ny fil\' ikon';

//
// Comments
//
$lang['Comments_title'] = 'Kommentarer';
$lang['Comments_title_explain'] = 'Vissa kommentarinställningar är defaultvärden, och kan ändras per kategori';

$lang['Use_comments'] = 'Kommentarer';
$lang['Use_comments_explain'] = 'Aktivera kommentarer.';

$lang['Internal_comments'] = 'Interna eller phpBB kommentarer';
$lang['Internal_comments_explain'] = 'Använd interna eller phpBB kommentarer';

$lang['Select_topic_id'] = 'Välj phpBB kommentarforum!';

$lang['Internal_comments_phpBB'] = 'phpBB kommentarer';
$lang['Internal_comments_internal'] = 'Interna kommentarer';

$lang['Forum_id'] = 'phpBB Forum ID';
$lang['Forum_id_explain'] = 'Om phpBB kommentarer används är detta det forum där kommentarerna samlas';

$lang['Autogenerate_comments'] = 'Skapa autokommentarer';
$lang['Autogenerate_comments_explain'] = 'När en fil ändras/skrivs, görs ett inlägg i kommentarforumet automatiskt.';

$lang['Del_topic'] = 'Ta bort forumkommentarer';
$lang['Del_topic_explain'] = 'När en fil tas bort, skall även associerade forumkommentarer tas bort?';

$lang['Comments_pag'] = 'Kommentarer och sidbrytning';
$lang['Comments_pag_explain'] = 'Antal kommentarer att visa innan sidbrytning.';

$lang['Allow_Wysiwyg'] = 'Använd wysiwyg editor';
$lang['Allow_Wysiwyg_explain'] = 'Om aktiverad, ersätts den vanliga bbcode/html/smilies redigeraren med en wysiwyg editor.';

$lang['Allow_links'] = 'Tillåt länkar';
$lang['Allow_links_message'] = 'Default \'inga länkar\' meddelande';
$lang['Allow_links_explain'] = 'Om länkar ej är tillåtna visas detta meddelande istället';

$lang['Allow_images'] = 'Tillåt bilder';
$lang['Allow_images_message'] = 'Default \'No Images\' meddelande';
$lang['Allow_images_explain'] = 'Om bilder ej är tillåtna visas detta meddelande istället';

$lang['Max_subject_char'] = 'Max antal tecken (i titel)';
$lang['Max_subject_char_explain'] = 'Om man skriven en titel med fler tecken visas ett felmeddelande.';

$lang['Max_desc_char'] = 'Max antal tecken (i beskrivning)';
$lang['Max_desc_char_explain'] = 'Om man skriven en titel med fler tecken visas ett felmeddelande.';

$lang['Max_char'] = 'Max antal tecken';
$lang['Max_char_explain'] = 'Om man skriven en kommentar med fler tecken visas ett felmeddelande.';

$lang['Format_wordwrap'] = 'Avstavning';
$lang['Format_wordwrap_explain'] = '';

$lang['Format_truncate_links'] = 'Förkorta länkar';
$lang['Format_truncate_links_explain'] = 'Länkar skrivs om, t ex \'www.mxp-portal...\'';

$lang['Format_image_resize'] = 'Skala om bilder';
$lang['Format_image_resize_explain'] = 'Bilder omskalas till denna bredd (pixlar)';

//
// Ratings
//
$lang['Ratings_title'] = 'Betygsättning';
$lang['Ratings_title_explain'] = 'Vissa inställning är grundinställningar och kan ändras per kategori';

$lang['Use_ratings'] = 'Betygsättning (rösta)';
$lang['Use_ratings_explain'] = 'Aktivera betygsättning';

$lang['Votes_check_ip'] = 'Godkänn röstningar - IP';
$lang['Votes_check_ip_explain'] = 'Endast en röst per IP-adress godkänns.';

$lang['Votes_check_userid'] = 'Godkänn röstningar - användare';
$lang['Votes_check_userid_explain'] = 'Användare får endast rösta en gång.';

//
// Instructions
//
$lang['Instructions_title'] = 'Användarinstruktioner';

$lang['Pre_text_name'] = 'Instruktionstext';
$lang['Pre_text_explain'] = 'Aktivera instruktionstext som visas för användare då de skall ladda upp en fil.';

$lang['Pre_text_header'] = 'Instruktionstextens - rubrik';
$lang['Pre_text_body'] = 'Instruktionstext - text';

$lang['Show'] = 'Visa';
$lang['Hide'] = 'Dölj';

//
// Notifications
//
$lang['Notifications_title'] = 'Påminnelser';

$lang['Notify'] = 'Informera admin via: ';
$lang['Notify_explain'] = 'Bestäm på vilket sätt admin skall bli informerad om nya/redigerade artiklar';
$lang['PM'] = 'PM';

$lang['Notify_group'] = 'och till grupp: ';
$lang['Notify_group_explain'] = 'Informera dessutom medlemmarna i denna grupp.';

//
// Permissions
//
$lang['Permission_settings'] = 'Rättigheter';

$lang['Auth_search'] = 'Sök röttighet';
$lang['Auth_search_explain'] = 'Tillåt sökning av vissa typer av användare';

$lang['Auth_stats'] = 'Statistik';
$lang['Auth_stats_explain'] = 'Tillåt statistik för vissa typer av användare';

$lang['Auth_toplist'] = 'Topplista';
$lang['Auth_toplist_explain'] = 'Tillåt topplista för vissa typer av användare';

$lang['Auth_viewall'] = 'Visa alla filer';
$lang['Auth_viewall_explain'] = 'Tillåt \'visa alla filer\' för vissa typer av användare';

$lang['Settings'] = 'Konfiguration';
$lang['Settings_changed'] = 'Inställningarna uppdaterades...';

//
// Admin Panels - Categories
//
$lang['Panel_cat_title'] = 'Kategorihantering';
$lang['Panel_cat_explain'] = 'Du använder denna panel för att skapa, ändra, tabort och sortera kategorier. För att kunna ladda upp en fil till databasen krävs minst en kategori.';

$lang['Use_default'] = 'Andvänd grundinställning';

$lang['Maintenance'] = 'Filunderhåll';
$lang['Acat'] = 'Kategori: Lägg till';
$lang['Ecat'] = 'Kategori: Ändra';
$lang['Dcat'] = 'Kategori: Ta bort';
$lang['Rcat'] = 'Kategori: Sortera';
$lang['Cat_Permissions'] = 'Kategorirättigheter';
$lang['User_Permissions'] = 'Användarrättigheter';
$lang['Group_Permissions'] = 'Grupprättigheter';
$lang['User_Global_Permissions'] = 'Allmänna användarrättigheter';
$lang['Group_Global_Permissions'] = 'Allmänna grupprättigheter';
$lang['Acattitle'] = 'Lägg till kategori';
$lang['Ecattitle'] = 'Ändra kategori';
$lang['Dcattitle'] = 'Ta bort kategori';
$lang['Rcattitle'] = 'Sortera kategorier';
$lang['Catexplain'] = 'Du använder denna panel för att skapa, ändra, tabort och sortera kategorier. För att kunna ladda upp en fil till databasen krävs minst en kategori.';
$lang['Rcatexplain'] = 'Sortera kategorier för att kontrollera i vilken ordning de skall visas.';
$lang['Catadded'] = 'Kategorin skapades...';
$lang['Catname'] = 'Kategorinamn';
$lang['Catnameinfo'] = 'Kategorins namn.';
$lang['Catdesc'] = 'Kategoribeskrivning';
$lang['Catdescinfo'] = 'Kategorins beskrivning';
$lang['Catparent'] = 'Överordnad kategori';
$lang['Catparentinfo'] = 'Om du vill att detta skall vara en subkategori, ange i så fall till vilken kategori den skall vara underordnad.';
$lang['Allow_file'] = 'Tillåt lägga till filer';
$lang['Allow_file_info'] = 'Om du inte tillåter att filer läggs till denna kategori, så blir kategorin en toppnivåkategori - en plats med subkategorier.';
$lang['None'] = 'Ingen';
$lang['Catedited'] = 'Kategorin ändrades...';
$lang['Delfiles'] = 'Vad vill du göra med filerna i denna kategorin?';
$lang['Do_cat'] = 'Vad vill du göra med subkategorin i denna kategori?';
$lang['Move_to'] = 'Flytta till';
$lang['Catsdeleted'] = 'Kategorin (kategorierna) togs bort...';
$lang['Cdelerror'] = 'Du valde inga kategorier att ta bort.';
$lang['Rcatdone'] = 'Kategorierna sorterades...';

//
// Admin Panels - File Maintainance
//
$lang['Fchecker'] = 'Fil: Underhåll';
$lang['File_checker'] = 'Filunderhåll';
$lang['File_checker_explain'] = 'Here you can perform a checking for all file in database and the file in the download directory.';
$lang['File_saftey'] = 'File maintenance will attempt to delete all files and screenshots that are currently not needed and will remove any file records where the file has been deleted and will clear all screenshots that are not found.<br /><br />If the files do not start with <FONT COLOR="#FF0000">{html_path}</FONT> then the files will be skipped for security reasons.<br /><br />Please make sure that <FONT COLOR="#FF0000">{html_path}</FONT> is the path that you use for your files.<br /><br />.';

$lang['File_checker_perform'] = 'Genomför kontroll';
$lang['Checker_saved'] = 'Totalt sparat utrymme';
$lang['Checker_sp1'] = 'Kontrollerar felaktiga/saknade filer...';
$lang['Checker_sp2'] = 'Kontrollerar felaktiga/saknade screenshots...';
$lang['Checker_sp3'] = 'Tar bort ej använda filer...';

//
// Admin Panels - Permissions
//
$lang['View'] = 'Visa';
$lang['Read'] = 'Läsa';
$lang['View_file'] = 'Visa fil';
$lang['Delete_file'] = 'Ta bort fil';
$lang['Edit_file'] = 'Ändra fil';
$lang['Upload'] = 'Ladda upp fil';
$lang['Approval'] = 'Godkänna fil';
$lang['Approval_edit'] = 'Godkänna ändrade filer';
$lang['Download_file'] = 'Ladda ner fil';
$lang['Rate'] = 'Rösta';
$lang['View_comment'] = 'Visa kommentarer';
$lang['Post_comment'] = 'Skriv kommentarer';
$lang['Edit_comment'] = 'Ändra kommentarer';
$lang['Delete_comment'] = 'Ta bort kommentarer';
$lang['Category_auth_updated'] = 'Kategorirättigheterna uppdaterades...';
$lang['Click_return_catauth'] = 'Klicka %shär%s för att återgå till kategorirättigheterna';
$lang['Auth_Control_Category'] = 'Kategorirättigheter - panel';
$lang['Category_auth_explain'] = 'Här betämmer du kategorirättigheter. Kontrollera dina inställningar noga så att användare inte får tillträde till obehöriga filer.';
$lang['Select_a_Category'] = 'Välj kategori';
$lang['Look_up_Category'] = 'Undersök kategori';
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
$lang['Fieldselecttitle'] = 'Välj ett alternativ';
$lang['Afield'] = 'Extra fält: lägg till';
$lang['Efield'] = 'Extra fält: ändra';
$lang['Dfield'] = 'Extra fält: ta bort';
$lang['Mfieldtitle'] = 'Extra fält';
$lang['Afieldtitle'] = 'Lägg till fält';
$lang['Efieldtitle'] = 'Ändra fält';
$lang['Dfieldtitle'] = 'Ta bort fält';
$lang['Fieldexplain'] = 'Här kan du lägga till extra fält. Om du exempelvis vill ha ett fält där användaren kan ange filstorleken själv, skapar du ett sådant fält.';
$lang['Fieldname'] = 'Fältnamn';
$lang['Fieldnameinfo'] = 'Detta är fältnamnet, t ex \'Filstorlek\'';
$lang['Fielddesc'] = 'Fältbeskrivning';
$lang['Fielddescinfo'] = 'Detta är en fältbeskrivning, t ex \'Storlek på filen\'';
$lang['Fieldadded'] = 'Fältet lades till';
$lang['Fieldedited'] = 'Fältet ändrades...';
$lang['Dfielderror'] = 'Du valde inga fält att ta bort';
$lang['Fieldsdel'] = 'Fältet togs bort...';

$lang['Field_data'] = 'Options';
$lang['Field_data_info'] = 'Enter the options that the user can choose from. Separate each option with a new-line (carriage return).';
$lang['Field_regex'] = 'Regular Expression';
$lang['Field_regex_info'] = 'You may require the input field to match a regular expression %s(PCRE)%s.';
$lang['Field_order'] = 'Display Order';

//
// Admin Panels - License
//
$lang['License_title'] = 'Licenser';
$lang['Alicense'] = 'Licens: lägg till';
$lang['Elicense'] = 'Licens: ändra';
$lang['Dlicense'] = 'Licens: ta bort';
$lang['Alicensetitle'] = 'Lägg till licens';
$lang['Elicensetitle'] = 'Ändra licens';
$lang['Dlicensetitle'] = 'Ta bort licens';
$lang['Licenseexplain'] = 'Här kan du hantera licenser - lägga till, ändra och ta bort. Ett licensavtal visas innan användare får ladda ner filen.';
$lang['Lname'] = 'Licenstitel';
$lang['Ltext'] = 'Licenstext';
$lang['Licenseadded'] = 'Licensinformationen lades till...';
$lang['Licenseedited'] = 'Licensinformationen togs bort...';
$lang['Lderror'] = 'Du valde ingen licensinformtaion att ta bort';
$lang['Ldeleted'] = 'Licensinformationen du valde har tagits bort...';

$lang['Click_return'] = 'Klicka %shär%s för att återgå till föregående sida';
$lang['Click_edit_permissions'] = 'Klicka %shär%s för att ändra kategorirättigheter';

//Java script messages and php errors
$lang['Cat_name_missing'] = 'Ange kategorinamnet';
$lang['Cat_conflict'] = 'Du kan inte ha en kategori utan filer i en annan kateogri utan filer';
$lang['Cat_id_missing'] = 'Välj en kategori';
$lang['Missing_field'] = 'Fyll i alla nödvändiga fält';

//
// Admin Panels - Field Types
//
$lang['Field_Input'] = 'Single-Line Text Box';
$lang['Field_Textarea'] = 'Multiple-Line Text Box';
$lang['Field_Radio'] = 'Single-Selection Radio Buttons';
$lang['Field_Select'] = 'Single-Selection Menu';
$lang['Field_Select_multiple'] = 'Multiple-Selection Menu';
$lang['Field_Checkbox'] = 'Multiple-Selection Checkbox';

$lang['Com_settings'] = 'Inställningar för kommentarer';
$lang['Validation_settings'] = 'Inställningar för godkännande';
$lang['Ratings_settings'] = 'Inställningar för betygsättning';
$lang['PM_notify'] = 'PM information (till admin)';

$lang['Use_comments'] = 'Aktivera kommentarer';
$lang['Allow_comments'] = 'Tillåt kommentarer';
$lang['Allow_comments_info'] = 'Aktivera/inaktivera kommentarer i denna kategori.';

$lang['Use_ratings'] = 'Aktivera betygsättning';
$lang['Allow_ratings'] = 'Tillåt omröstningar';
$lang['Allow_ratings_info'] = 'Aktivera/inaktivera röstningar i denna kategori.';

$lang['Fileadded_not_validated'] = 'Filen laddades upp, men en admin (eller moderator) måste godkänna filen innan andra kan använda den.';

//
// Toplists
//
$lang['toplist_sort_method']     	= 'Typ av toplista';
$lang['toplist_display_options']    = 'Visningsalternativ';
$lang['toplist_use_pagination']     = 'Bläddra \'antal rader\' i taget';
$lang['toplist_pagination']         = 'Antal rader';
$lang['toplist_filter_date'] 			= 'Datumfilter';
$lang['toplist_filter_date_explain'] 	= '- Visa inlägg från senaste dagen, veckan, måndaden, året...';
$lang['toplist_cat_id']       		= 'Begränsa till kategori';
$lang['target_block']       		= 'Associerat pafileDB block';

//
// Mini
//
$lang['mini_display_options']    = 'Visningsalternativ';
$lang['mini_pagination']         = 'Antal rader';
$lang['mini_default_cat_id']     = 'Begränsa till kategori';

//
// Quickdl
//
$lang['Panel_title']							= 'pafileDB associering';
$lang['Panel_title_explain']					= 'Här kan du associera dynamiska portalblock och filkategorier. Kategorin kommer visas om det dynamiska blocket är aktivt.';

$lang['Map_pafiledb']							= 'Välj en filkategori...';
$lang['Map_mxbb']								= '...som skall associeras med ett portalblock';
?>