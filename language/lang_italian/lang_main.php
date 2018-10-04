<?php
/**
*
* @package MX-Publisher Core
* @version $Id: lang_main.php,v 1.2 2013/06/28 15:34:32 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
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
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

$lang['ENCODING'] = 'iso-8859-1';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'sinistra';
$lang['RIGHT'] = 'destra';
$lang['DATE_FORMAT'] =  'd/m/y H:i'; // This should be changed to the default date format for your language, php date() format

//
// General
//
$lang['Page_Not_Authorised'] = 'Spiacenti, ma non sei autorizzato ad accedere a questa pagina.';
$lang['Execution_Stats'] = 'La pagina ha generato %s query - Tempo di generazione: %s secondi';
$lang['Redirect_login'] = 'Clicca %sQui%s per collegarti.';
$lang['Show_admin_options'] = 'Mostra/Nascondi opzioni amministrative: ';
$lang['Block_updated_date'] = 'Aggiornato ';
$lang['Block_updated_by'] = 'da ';
$lang['Page_updated_date'] = 'Questa pagina &egrave; stata aggiornata il ';
$lang['Page_updated_by'] = 'da ';
$lang['Powered_by'] = 'Realizzato con';
$lang['Username'] = 'Nome Utente';
$lang['Password'] = 'Password';
$lang['Register'] = 'Registrati';
$lang['Search'] = 'Cerca';
$lang['mx_spacer'] = 'Spaziatore';
$lang['Yes'] = 'Si';
$lang['No'] = 'No';
$lang['Link'] = 'Collegamento';
$lang['Hidden_block'] = 'Blocco nascosto';
$lang['Hidden_block_explain'] = 'Questo blocco &egrave; \'nascosto\', ma puoi vederlo in quanto hai i giusti permessi.';
$lang['Admin_panel'] = 'Amministrazione';
$lang['Information'] = 'Informazione';
$lang['CHANGE_FONT_SIZE'] = 'Modifica dimensione carattere';
$lang['Who_is_Online'] = 'Chi c\'è in linea';
$lang['Forum_Location'] = 'Località del forum';
$lang['Last_updated'] = 'Ultimo aggiornamento';
$lang['IP_Address'] = 'Indirizzo IP';
$lang['Submit'] = 'Invia';
$lang['Reset'] = 'Azzera';
$lang['Cancel'] = 'Cancella';
$lang['Preview'] = 'Anteprima';
//
// Timezones ... for display on each page
//
$lang['All_times'] = 'Tutti i fusi orari sono %s'; // eg. All times are GMT - 12 Hours (times from next block)

$lang['-12'] = 'GMT - 12 ore';
$lang['-11'] = 'GMT - 11 ore';
$lang['-10'] = 'GMT - 10 ore';
$lang['-9'] = 'GMT - 9 ore';
$lang['-8'] = 'GMT - 8 ore';
$lang['-7'] = 'GMT - 7 ore';
$lang['-6'] = 'GMT - 6 ore';
$lang['-5'] = 'GMT - 5 ore';
$lang['-4'] = 'GMT - 4 ore';
$lang['-3.5'] = 'GMT - 3.5 ore';
$lang['-3'] = 'GMT - 3 ore';
$lang['-2'] = 'GMT - 2 ore';
$lang['-1'] = 'GMT - 1 ore';
$lang['0'] = 'GMT';
$lang['1'] = 'GMT + 1 ora';
$lang['2'] = 'GMT + 2 ore';
$lang['3'] = 'GMT + 3 ore';
$lang['3.5'] = 'GMT + 3.5 ore';
$lang['4'] = 'GMT + 4 ore';
$lang['4.5'] = 'GMT + 4.5 ore';
$lang['5'] = 'GMT + 5 ore';
$lang['5.5'] = 'GMT + 5.5 ore';
$lang['6'] = 'GMT + 6 ore';
$lang['6.5'] = 'GMT + 6.5 ore';
$lang['7'] = 'GMT + 7 ore';
$lang['8'] = 'GMT + 8 ore';
$lang['9'] = 'GMT + 9 ore';
$lang['9.5'] = 'GMT + 9.5 ore';
$lang['10'] = 'GMT + 10 ore';
$lang['11'] = 'GMT + 11 ore';
$lang['12'] = 'GMT + 12 ore';
$lang['13'] = 'GMT + 13 ore';

// These are displayed in the timezone select box
$lang['tz']['-12'] = 'GMT -12:00 ore';
$lang['tz']['-11'] = 'GMT -11:00 ore';
$lang['tz']['-10'] = 'GMT -10:00 ore';
$lang['tz']['-9'] = 'GMT -9:00 ore';
$lang['tz']['-8'] = 'GMT -8:00 ore';
$lang['tz']['-7'] = 'GMT -7:00 ore';
$lang['tz']['-6'] = 'GMT -6:00 ore';
$lang['tz']['-5'] = 'GMT -5:00 ore';
$lang['tz']['-4'] = 'GMT -4:00 ore';
$lang['tz']['-3.5'] = 'GMT -3:30 ore';
$lang['tz']['-3'] = 'GMT -3:00 ore';
$lang['tz']['-2'] = 'GMT -2:00 ore';
$lang['tz']['-1'] = 'GMT -1:00 ora';
$lang['tz']['0'] = 'GMT';
$lang['tz']['1'] = 'GMT +1:00 ora';
$lang['tz']['2'] = 'GMT +2:00 ore';
$lang['tz']['3'] = 'GMT +3:00 ore';
$lang['tz']['3.5'] = 'GMT +3:30 ore';
$lang['tz']['4'] = 'GMT +4:00 ore';
$lang['tz']['4.5'] = 'GMT +4:30 ore';
$lang['tz']['5'] = 'GMT +5:00 ore';
$lang['tz']['5.5'] = 'GMT +5:30 ore';
$lang['tz']['6'] = 'GMT +6:00 ore';
$lang['tz']['6.5'] = 'GMT +6:30 ore';
$lang['tz']['7'] = 'GMT +7:00 ore';
$lang['tz']['8'] = 'GMT +8:00 ore';
$lang['tz']['9'] = 'GMT +9:00 ore';
$lang['tz']['9.5'] = 'GMT +9:30 ore';
$lang['tz']['10'] = 'GMT + 10 ore';
$lang['tz']['11'] = 'GMT + 11 ore';
$lang['tz']['12'] = 'GMT + 12 ore';
$lang['tz']['13'] = 'GMT + 13 ore';

$lang['datetime']['Sunday'] = 'Domenica';
$lang['datetime']['Monday'] = 'Lunedì';
$lang['datetime']['Tuesday'] = 'Martedì';
$lang['datetime']['Wednesday'] = 'Mercoledì';
$lang['datetime']['Thursday'] = 'Giovedì';
$lang['datetime']['Friday'] = 'Venerdì';
$lang['datetime']['Saturday'] = 'Sabato';
$lang['datetime']['Sun'] = 'Dom';
$lang['datetime']['Mon'] = 'Lun';
$lang['datetime']['Tue'] = 'Mar';
$lang['datetime']['Wed'] = 'Mer';
$lang['datetime']['Thu'] = 'Gio';
$lang['datetime']['Fri'] = 'Ven';
$lang['datetime']['Sat'] = 'Sab';
$lang['datetime']['January'] = 'Gennaio';
$lang['datetime']['February'] = 'Febbraio';
$lang['datetime']['March'] = 'Marzo';
$lang['datetime']['April'] = 'Aprile';
$lang['datetime']['May'] = 'Maggio';
$lang['datetime']['June'] = 'Giugno';
$lang['datetime']['July'] = 'Luglio';
$lang['datetime']['August'] = 'Agosto';
$lang['datetime']['September'] = 'Settembre';
$lang['datetime']['October'] = 'Ottobre';
$lang['datetime']['November'] = 'Novembre';
$lang['datetime']['December'] = 'Dicembre';
$lang['datetime']['Jan'] = 'Gen';
$lang['datetime']['Feb'] = 'Feb';
$lang['datetime']['Mar'] = 'Mar';
$lang['datetime']['Apr'] = 'Apr';
$lang['datetime']['May'] = 'Mag';
$lang['datetime']['Jun'] = 'Giu';
$lang['datetime']['Jul'] = 'Lug';
$lang['datetime']['Aug'] = 'Ago';
$lang['datetime']['Sep'] = 'Set';
$lang['datetime']['Oct'] = 'Ott';
$lang['datetime']['Nov'] = 'Nov';
$lang['datetime']['Dec'] = 'Dic';

//
// Login
//
$lang['Enter_password'] = 'Inserisci il tuo Nome Utente e la Password per collegarti.';
$lang['Login'] = 'Collegati';
$lang['Logout'] = 'Scollegati';
$lang['Log_me_in'] = 'Collegami automaticamente ad ogni visita';
$lang['Error_login'] = 'Hai inserito un Nome Utente o una Password non corretti.';
$lang['Click_return_login'] = 'Clicca %squi%s per riprovare il login';

//
// Core Blocks - Search
//
$lang['Mx_Page'] = 'Pagina';
$lang['Mx_Block'] = 'Sezione';
$lang['Search_for_any'] = 'Cerca per parola o usa frase esatta';
$lang['Search_for_all'] = 'Cerca tutte le parole';
$lang['Search_keywords'] = 'Cerca per parole chiave';
$lang['Search_keywords_explain'] = 'Puoi usare <u>AND</u> per definire le parole che devono essere nel risultato della ricerca, <u>OR</u> per definire le parole che potrebbero essere nel risultato e <u>NOT</u> per definire le parole che non devono essere nel risultato. Usa * come abbreviazione per parole parziali';

//
// Core Blocks - Virtual
//
$lang['Virtual_Create_new'] = 'Create new ';
$lang['Virtual_Create_new_user'] = 'User Page';
$lang['Virtual_Create_new_group'] = 'Group Page';
$lang['Virtual_Create_new_project'] = 'Project Page';
$lang['Virtual_Create'] = 'Create now';
$lang['Virtual_Edit'] = 'Update page name';
$lang['Virtual_Delete'] = 'Delete this page';

$lang['Virtual_Welcome'] = 'Welcome ';
$lang['Virtual_Info'] = 'Here you can control your private web page.';
$lang['Virtual_CP'] = 'Page Control Panel';
$lang['Virtual_Go'] = 'Vai';
$lang['Virtual_Select'] = 'Seleziona:';

//
// Core Blocks - Site Log (and many last 'item' blocks)
//
$lang['No_items_found'] = 'Nessuna novit&agrave;. ';

//
// BlockCP
//
$lang['Block_Title'] = 'Titolo';
$lang['Block_Info'] = 'Informazione';

$lang['Block_Config_updated'] = 'Configurazione blocco aggiornata correttamente.';
$lang['Block_Edit'] = 'Edita Blocco';
$lang['Block_Edit_dyn'] = 'Edita blocco dinamico contenitore';
$lang['Block_Edit_sub'] = 'Edita blocco affiancato contenitore';

$lang['General_updated_return_settings'] = 'Configurazione aggiornata correttamente.<br /><br />Clickìca %squi%s per continuare.'; // %s's for URI params - DO NOT REMOVE
$lang['General_update_error'] = 'Impossibile aggiornare configurazione.';
//
// Header
//
$lang['Mx_search_site'] = 'Sito';
$lang['Mx_search_forum'] = 'Forum';
$lang['Mx_search_kb'] = 'Articoli';
$lang['Mx_search_pafiledb'] = 'Scaricamenti';
$lang['Mx_search_google'] = 'Google';
$lang['Mx_new_search'] = 'Nuova ricerca';

//
// Copyrights page
//
$lang['mx_about_title'] = 'Informazioni';
$lang['mx_copy_modules_title'] = 'Moduli Installati';
$lang['mx_copy_template_title'] = 'Informazioni sullo Stile';
$lang['mx_copy_translation_title'] = 'Informazioni sulla traduzione';

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
//$lang['TRANSLATION_INFO_MXBB'] = 'English Language by <a href="http://mxpcms.sourceforge.net/" target="_blank">MX-Publisher Development Team</a>';

//
// Installation
//
$lang['Please_remove_install_contrib'] = 'Prego assicurati che entrambe le cartelle install/ e contrib/ siano state cancellate.';

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