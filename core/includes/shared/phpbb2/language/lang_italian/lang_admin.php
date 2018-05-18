<?php

/***************************************************************************
 *                            lang_admin.php [Italian]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_admin.php,v 1.1 2012/10/21 00:03:48 orynider Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

/* CONTRIBUTORS
	2005-03-15	phpBB.it (info@phpbb.it)
		Fixed many minor grammatical mistakes
*/

//
// Format is same as lang_main
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//
$lang['General'] = 'Generale';
$lang['Users'] = 'Utenti';
$lang['Groups'] = 'Gruppi';
$lang['Forums'] = 'Forum';
$lang['Styles'] = 'Stili';

$lang['Configuration'] = 'Configurazione';
$lang['Permissions'] = 'Permessi';
$lang['Manage'] = 'Gestione';
$lang['Disallow'] = 'Disabilita Nomi';
$lang['Prune'] = 'Pruning';
$lang['Mass_Email'] = 'Email Generali';
$lang['Ranks'] = 'Livelli';
$lang['Smilies'] = 'Smilies';
$lang['Ban_Management'] = 'Ban Control';
$lang['Word_Censor'] = 'Censura Parole';
$lang['Export'] = 'Esporta';
$lang['Create_new'] = 'Crea';
$lang['Add_new'] = 'Aggiungi';
$lang['Backup_DB'] = 'Backup Database';
$lang['Restore_DB'] = 'Ripristina Database';


//
// Index
//
$lang['Admin'] = 'Amministrazione';
$lang['Not_admin'] = 'Non sei autorizzato ad Amministrare questo Forum';
$lang['Welcome_phpBB'] = 'Benvenuto in phpBB';
$lang['Admin_intro'] = 'Grazie per aver scelto phpBB come Forum. Questa schermata mostra alcune Statistiche del tuo Forum. Puoi tornare a questa pagina cliccando sul link  <u>Admin Index</u> nel pannello di sinistra. Per tornare all\'indice del tuo forum, clicca il logo phpBB nel pannello di sinistra. Gli altri collegamenti nella parte sinistra dello schermo ti permettono di controllare ogni aspetto del tuo Forum, in tutte le schermata avrai le informazioni su come usare al meglio le varie funzioni. Per maggiori info e Supporto visita ( <a href="http://www.phpbb.com" target="_blank"><strong>phpBB.com</strong></a> o <a href="http://www.phpbb.it" target="_blank"><strong>phpBB.it</strong></a> )';
$lang['Main_index'] = 'Forum Index';
$lang['Forum_stats'] = 'Statistiche Forum';
$lang['Admin_Index'] = 'Admin Index';
$lang['Preview_forum'] = 'Anteprima Forum';

$lang['Click_return_admin_index'] = 'Clicca %squi%s per tornare in Admin Index';

$lang['Statistic'] = 'Statistiche';
$lang['Value'] = 'Valore';
$lang['Number_posts'] = 'Numero di messaggi';
$lang['Posts_per_day'] = 'Messaggi per giorno';
$lang['Number_topics'] = 'Numero di argomenti';
$lang['Topics_per_day'] = 'Argomenti per giorno';
$lang['Number_users'] = 'Numero di utenti';
$lang['Users_per_day'] = 'Utenti per giorno';
$lang['Board_started'] = 'Forum attivato il';
$lang['Avatar_dir_size'] = 'Dimensione directory Avatar';
$lang['Database_size'] = 'Dimensione Database';
$lang['Gzip_compression'] ='Compressione Gzip';
$lang['Not_available'] = 'Non disponibile';

$lang['ON'] = 'ON'; // This is for GZip compression
$lang['OFF'] = 'OFF'; 


//
// DB Utils
//
$lang['Database_Utilities'] = 'Utilit� Database';

$lang['Restore'] = 'Ripristina';
$lang['Backup'] = 'Backup';
$lang['Restore_explain'] = 'Questa funzione ripristiner� tutte le tabelle del forum phpBB da un file salvato. Se il tuo server lo supporta puoi caricare un file di testo con compressione Gzip e verr� automaticamente decompresso. <b>ATTENZIONE</b> Questa operazione sovrascriver� tutti i dati esistenti. L\'operazione di ripristino potrebbe impiegare molto tempo per essere completata. Non muoverti da questa pagina finch� l\'operazione non sar� completata.';
$lang['Backup_explain'] = 'Qui puoi fare il backup di tutti i dati del forum. Se hai delle tabelle personalizzate nello stesso database di cui vorresti fare il backup inserisci i nomi separati da virgole nel campo Tabelle Addizionali. Se il tuo server lo supporta puoi comprimere i files utilizzando Gzip per ridurre le loro dimensioni prima del download.';

$lang['Backup_options'] = 'Opzioni Backup';
$lang['Start_backup'] = 'Inizia Backup';
$lang['Full_backup'] = 'Backup Completo';
$lang['Structure_backup'] = 'Backup solo Struttura';
$lang['Data_backup'] = 'Backup solo Dati';
$lang['Additional_tables'] = 'Tabelle Addizionali';
$lang['Gzip_compress'] = 'File di compressione Gzip';
$lang['Select_file'] = 'Seleziona un file';
$lang['Start_Restore'] = 'Inizia Ripristino';

$lang['Restore_success'] = 'Il Database � stato ripristinato con successo.<br /><br />Il tuo Forum dovrebbe tornare allo stato che era al momento del backup.';
$lang['Backup_download'] = 'Il tuo Download comincer� presto. Attendi...';
$lang['Backups_not_supported'] = 'Spiacenti, il backup del database non pu� essere concluso, a causa della mancanza di permessi. Contatta il tuo WebHost.';

$lang['Restore_Error_uploading'] = 'Errore nel caricamento del file di backup';
$lang['Restore_Error_filename'] = 'Problema con il nome del file, provane uno alternativo.';
$lang['Restore_Error_decompress'] = 'Non � possibile decomprimere un file Gzip, carica il file di testo.';
$lang['Restore_Error_no_file'] = 'Nessun file � stato caricato';


//
// Auth pages
//
$lang['Select_a_User'] = 'Seleziona un Utente';
$lang['Select_a_Group'] = 'Seleziona un Gruppo';
$lang['Select_a_Forum'] = 'Seleziona un Forum';
$lang['Auth_Control_User'] = 'Controllo Permessi Utente'; 
$lang['Auth_Control_Group'] = 'Controllo Permessi Gruppo'; 
$lang['Auth_Control_Forum'] = 'Controllo Permessi Forum'; 
$lang['Look_up_User'] = 'Cerca Utente'; 
$lang['Look_up_Group'] = 'Cerca Gruppo'; 
$lang['Look_up_Forum'] = 'Cerca Forum'; 

$lang['Group_auth_explain'] = 'Qui puoi modificare i permessi e lo stato dei moderatori assegnati ad ogni gruppo. Non dimenticare che quando cambi i permessi di un gruppo, l\'utente potrebbe accedere comunque ai forum. Grazie ai suoi permessi individuali. In questo caso sarai avvisato.';
$lang['User_auth_explain'] = 'Qui puoi modificare i permessi e lo stato dei moderatori assegnati ad ogni utente individuale. Non dimenticare quando cambi i permessi di un utente i permessi del gruppo gli potrebbero permettere di accedere comunque ai forum. In questo caso sarai avvisato.';
$lang['Forum_auth_explain'] = 'Qui puoi modificare i livelli di autorizzazione per ogni forum. Puoi fare questo utilizzando una modalit� semplice e una modalit� avanzata. La modalit� avanzata offre maggior controllo per ogni operazione sui forum. Ricorda che cambiare i permessi dei forum mostrer� gli utenti che possono eseguire le varie operazioni nei forum.';

$lang['Simple_mode'] = 'Modalit� Semplice';
$lang['Advanced_mode'] = 'Modalit� Avanzata';
$lang['Moderator_status'] = 'Stato dei moderatori';

$lang['Allowed_Access'] = 'Accessi Ammessi';
$lang['Disallowed_Access'] = 'Accessi non Ammessi';
$lang['Is_Moderator'] = '� Moderatore';
$lang['Not_Moderator'] = 'Non � Moderatore';

$lang['Conflict_warning'] = 'Attenzione Conflitto di Autorizzazione';
$lang['Conflict_access_userauth'] = 'Questo utente ha ancora diritti di accesso a questo forum per il suo gruppo di appartenenza. Potresti voler cambiare i permessi del gruppo o rimuovere questo utente dal gruppo per togliere completamente i suoi diritti di accesso. I diritti del gruppo (e i forum coinvolti) sono elencati qui sotto.';
$lang['Conflict_mod_userauth'] = 'Questo utente ha ancora i diritti di moderatore a questo forum per il suo gruppo di appartenenza. Potresti voler cambiare i permessi del gruppo o rimuovere questo utente dal gruppo per togliere completamente i suoi diritti di moderatore. I diritti del gruppo (e i forum coinvolti) sono elencati qui sotto.';

$lang['Conflict_access_groupauth'] = 'I seguenti utenti hanno ancora diritti di accesso a questo forum per le impostazioni dei permessi utenti. Potresti voler cambiare i permessi del gruppo o rimuovere questo utente dal gruppo per togliere completamente i suoi diritti di accesso. I diritti del gruppo (e i forum coinvolti) sono elencati qui sotto.';
$lang['Conflict_mod_groupauth'] = 'I seguenti utenti hanno ancora i diritti di moderatore a questo forum per le impostazioni dei permessi utenti. Potresti voler cambiare i permessi del gruppo o rimuovere questo utente dal gruppo per togliere completamente i suoi diritti di moderatore. I diritti del gruppo (e i forum coinvolti) sono elencati qui sotto.';

$lang['Public'] = 'Pubblico';
$lang['Private'] = 'Privato';
$lang['Registered'] = 'Registrato';
$lang['Administrators'] = 'Amministratori';
$lang['Hidden'] = 'Nascosto';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = 'TUTTI';
$lang['Forum_REG'] = 'REG';
$lang['Forum_PRIVATE'] = 'PRIVATO';
$lang['Forum_MOD'] = 'MOD';
$lang['Forum_ADMIN'] = 'ADMIN';

$lang['View'] = 'Guarda';
$lang['Read'] = 'Leggi';
$lang['Post'] = 'Invia';
$lang['Reply'] = 'Rispondi';
$lang['Edit'] = 'Modifica';
$lang['Delete'] = 'Cancella';
$lang['Sticky'] = 'Importante';
$lang['Announce'] = 'Annuncio'; 
$lang['Vote'] = 'Vota';
$lang['Pollcreate'] = 'Crea Sondaggio';

$lang['Permissions'] = 'Permessi';
$lang['Simple_Permission'] = 'Permesso Semplice';

$lang['User_Level'] = 'Livello Utente'; 
$lang['Auth_User'] = 'Utente';
$lang['Auth_Admin'] = 'Amministratore';
$lang['Group_memberships'] = 'Membri gruppo utenti';
$lang['Usergroup_members'] = 'Questo gruppo ha i seguenti membri';

$lang['Forum_auth_updated'] = 'Permessi Forum Aggiornati';
$lang['User_auth_updated'] = 'Permessi Utente Aggiornati';
$lang['Group_auth_updated'] = 'Permessi Gruppo Aggiornati';

$lang['Auth_updated'] = 'I permessi sono stati aggiornati';
$lang['Click_return_userauth'] = 'Clicca %squi%s per tornare a Permessi Utenti';
$lang['Click_return_groupauth'] = 'Clicca %squi%s per tornare a Permessi Gruppo';
$lang['Click_return_forumauth'] = 'Clicca %squi%s per tornare a Permessi Forum';


//
// Banning
//
$lang['Ban_control'] = 'Controllo Disabilitazione';
$lang['Ban_explain'] = 'Qui puoi controllare la disabilitazione degli utenti. Puoi disabilitare per utente specifico o un individuole, per intervallo di indirizzi IP o hostnames. Questi metodi impediscono all\'utente di raggiungere anche l\'indice del tuo forum. Per impedire ad un utente di registrarsi con uno username diverso puoi anche disabilitare un indirizzo email specifico. Nota che disabilitare solo un indirizzo email non eviter� che quell\'utente possa essere in grado di entrare o di inviare messaggi al tuo forum. Per questo devi usare uno dei primi due metodi.';
$lang['Ban_explain_warn'] = 'Nota che inserendo un intervallo di indirizzi IP, nella disabilitazione verranno inclusi tutti gli indirizzi tra l\'inizio e la fine degli indirizzi. Verranno fatti dei tentativi per minimalizzare il numero degli indirizzi aggiunti al database introducendo abbreviazioni generate automaticamente in modo apprpopriato. Se davvero devi inserire un intervallo di indirizzi, prova a mantenerlo piccolo o meglio specifica un singolo indirizzo.';

$lang['Select_username'] = 'Seleziona uno Username';
$lang['Select_ip'] = 'Seleziona un indirizzo IP';
$lang['Select_email'] = 'Seleziona un indirizzo Email';

$lang['Ban_username'] = 'Disabilita uno o pi� Utenti specifici';
$lang['Ban_username_explain'] = 'Puoi disabilitare pi� utenti con una sola operazione utilizzando l\'appropriata combinazione di mouse e tastiera per il tuo computer e browser';

$lang['Ban_IP'] = 'Disabilita uno o pi� indirizzi IP o hostname';
$lang['IP_hostname'] = 'Indirizzo IP o hostname';
$lang['Ban_IP_explain'] = 'Per specificare diversi indirizzi IP o hostname separali con virgole (,). Per specificare un intervallo di indirizzi IP separa l\'inizio dalla fine con un trattino (-), per specificare un\'abbreviazione usa (*)';

$lang['Ban_email'] = 'Disabilita uno o pi� indirizzi email';
$lang['Ban_email_explain'] = 'Per specificare diversi indirizzi email separali con virgole (,). Per specificare una abbreviazione per gli username usa *, per esempio *@hotmail.com';

$lang['Unban_username'] = 'Riabilita uno o pi� utenti specifici';
$lang['Unban_username_explain'] = 'Puoi riabilitare pi� utenti con un unica operazione utilizzando l\'appropiata combinazione di mouse e tastiera per il tuo computer e browser';

$lang['Unban_IP'] = 'Riabilita uno o pi� indirizzi IP';
$lang['Unban_IP_explain'] = 'Puoi riabilitare pi� indirizzi IP con un unica operazione utilizzando l\'appropiata combinazione di mouse e tastiera per il tuo computer e browser';

$lang['Unban_email'] = 'Riabilita uno o pi� indirizzi email';
$lang['Unban_email_explain'] = 'Puoi riabilitare pi� indirizzi email con un unica operazione utilizzando l\'appropiata combinazione di mouse e tastiera per il tuo computer e browser';

$lang['No_banned_users'] = 'Non ci sono username disabilitati';
$lang['No_banned_ip'] = 'Non ci sono indirizzi IP disabilitati';
$lang['No_banned_email'] = 'Non ci sono indirizzi email disabilitati';

$lang['Ban_update_sucessful'] = 'La lista degli utenti disabilitati � stata aggiornata con successo';
$lang['Click_return_banadmin'] = 'Clicca %squi%s per tornare a Controllo Disabilitazione';


//
// Configuration
//
$lang['General_Config'] = 'Configurazione Generale';
$lang['Config_explain'] = 'Il modulo qui sotto ti permette di personalizzare tutte le opzioni generali del Forum. Per la configurazione dei Forum e degli Utenti utilizza i collegamenti appropriati nel pannello di sinistra.';

$lang['Click_return_config'] = 'Clicca %squi%s per tornare a Configurazione Generale';

$lang['General_settings'] = 'Impostazioni Generali Forum';
$lang['Server_name'] = 'Nome Dominio';
$lang['Server_name_explain'] = 'Il nome del dominio da cui lanci il forum';
$lang['Script_path'] = 'Percorso Cartella phpBB';
$lang['Script_path_explain'] = 'Il percorso dove � situato phpBB2 relativo al nome di dominio';
$lang['Server_port'] = 'Porta del Server';
$lang['Server_port_explain'] = 'La porta del tuo server, di solito 80, cambia solo se � diversa';
$lang['Site_name'] = 'Nome del Sito';
$lang['Site_desc'] = 'Descrizione del Sito';
$lang['Board_disable'] = 'Disabilita il Forum';
$lang['Board_disable_explain'] = 'Questo render� il forum non disponibile per gli utenti. Non uscire dopo aver disabilitato il forum, altrimenti non sarai pi� in grado di entrare di nuovo!';
$lang['Acct_activation'] = 'Abilita l\'attivazione degli account';
$lang['Acc_None'] = 'Nessuno'; // These three entries are the type of activation
$lang['Acc_User'] = 'Utente';
$lang['Acc_Admin'] = 'Amministratore';

$lang['Abilities_settings'] = 'Impostazioni base per Utenti e Forum';
$lang['Max_poll_options'] = 'Numero massimo di opzioni per sondaggio';
$lang['Flood_Interval'] = 'Intervallo del Flood';
$lang['Flood_Interval_explain'] = 'Numero di secondi di attesa tra ogni messaggio'; 
$lang['Board_email_form'] = 'Messaggistica email attraverso il forum';
$lang['Board_email_form_explain'] = 'Gli utenti possono inviarsi email utilizzando il forum';
$lang['Topics_per_page'] = 'Argomenti per Pagina';
$lang['Posts_per_page'] = 'Messaggi per Pagina';
$lang['Hot_threshold'] = 'Numero di Messaggi per essere Popolare';
$lang['Default_style'] = 'Stile di Default';
$lang['Override_style'] = 'Annulla il tema dell\'utente';
$lang['Override_style_explain'] = 'Sostituisce lo stile dell\'utente con quello di Default';
$lang['Default_language'] = 'Linguaggio di Default';
$lang['Date_format'] = 'Formato Data';
$lang['System_timezone'] = 'Fuso Orario del Sistema';
$lang['Enable_gzip'] = 'Abilita la Compressione GZip';
$lang['Enable_prune'] = 'Abilita il Pruning del Forum';
$lang['Allow_HTML'] = 'Permetti HTML';
$lang['Allow_BBCode'] = 'Permetti BBCode';
$lang['Allowed_tags'] = 'Tags HTML Permessi';
$lang['Allowed_tags_explain'] = 'Separa i tags con virgole';
$lang['Allow_smilies'] = 'Permetti Smilies';
$lang['Smilies_path'] = 'Percorso Salvataggio Smilies';
$lang['Smilies_path_explain'] = 'Percorso principale directory phpBB, es. images/smilies';
$lang['Allow_sig'] = 'Permetti Firma';
$lang['Max_sig_length'] = 'Lunghezza massima firma';
$lang['Max_sig_length_explain'] = 'Numero massimo di caratteri per la firma degli utenti';
$lang['Allow_name_change'] = 'Permetti cambio Username';

$lang['Avatar_settings'] = 'Impostazioni Avatar';
$lang['Allow_local'] = 'Abilita Galleria Avatar';
$lang['Allow_remote'] = 'Abilita Avatar remoti';
$lang['Allow_remote_explain'] = 'Avatar linkati da un altro sito web';
$lang['Allow_upload'] = 'Abilita il caricamento degli Avatar';
$lang['Max_filesize'] = 'Dimensione massima File Avatar';
$lang['Max_filesize_explain'] = 'Per i file Avatar caricati';
$lang['Max_avatar_size'] = 'Dimensioni Massime Avatar';
$lang['Max_avatar_size_explain'] = '(Altezza x Larghezza in pixels)';
$lang['Avatar_storage_path'] = 'Percorso Salvataggio Avatar';
$lang['Avatar_storage_path_explain'] = 'Percorso principale directory phpBB, es. images/avatars';
$lang['Avatar_gallery_path'] = 'Percorso Galleria Avatar';
$lang['Avatar_gallery_path_explain'] = 'Percorso principale directory phpBB per il per-caricamento delle immagini, es. images/avatars/gallery';

$lang['COPPA_settings'] = 'Impostazioni Reg. Minore';
$lang['COPPA_fax'] = 'Numero di Fax per Reg. Minore';
$lang['COPPA_mail'] = 'Indirizzo per Reg. Minore';
$lang['COPPA_mail_explain'] = 'Questo � l\'indirizzo al quale i genitori manderanno il modulo di registrazione Minore';

$lang['Email_settings'] = 'Impostazioni Email';
$lang['Admin_email'] = 'Indirizzo Email Amministratore';
$lang['Email_sig'] = 'Firma Email';
$lang['Email_sig_explain'] = 'Questo testo verr� allegato ad ogni email spedita dal Forum';
$lang['Use_SMTP'] = 'Usa un Server SMTP per le email';
$lang['Use_SMTP_explain'] = 'Rispondi s� se vuoi o devi inviare email attraverso un server specifico invece della funzione mail locale';
$lang['SMTP_server'] = 'Indirizzo Server SMTP';
$lang['SMTP_username'] = 'Username SMTP';
$lang['SMTP_username_explain'] = 'Compila il campo username soltanto se il server lo richiede';
$lang['SMTP_password'] = 'Password SMTP';
$lang['SMTP_password_explain'] = 'Compila il campo password soltanto se il server lo richiede';

$lang['Disable_privmsg'] = 'Messaggi Privati';
$lang['Inbox_limits'] = 'Numero massimo di messaggi per Posta in Arrivo';
$lang['Sentbox_limits'] = 'Numero massimo di messaggi per Posta Inviata';
$lang['Savebox_limits'] = 'Numero massimo di messaggi per Posta Salvata';

$lang['Cookie_settings'] = 'Impostazioni Cookie'; 
$lang['Cookie_settings_explain'] = 'Questo modulo controlla come vengono definiti i cookie inviati ai browser. In molti casi l\'impostazione di default � sufficiente. Se devi cambiare queste impostazioni fallo con attenzione, le impostazioni non corrette possono impedire agli utenti di entrare.';
$lang['Cookie_domain'] = 'Dominio Cookie';
$lang['Cookie_name'] = 'Nome Cookie';
$lang['Cookie_path'] = 'Percorso Cookie';
$lang['Cookie_secure'] = 'Cookie Sicuri';
$lang['Cookie_secure_explain'] = 'Se il server funziona via SSL abilita questo altrimenti lascia disabilitato';
$lang['Session_length'] = 'Lunghezza Sessione [ secondi ]';

// Visual Confirmation
$lang['Visual_confirm'] = 'Abilita Conferma Visuale';
$lang['Visual_confirm_explain'] = 'Richiede agli utenti di scrivere un codice definito da un\'immagine al momento della registrazione.';

//
// Forum Management
//
$lang['Forum_admin'] = 'Amministrazione Forum';
$lang['Forum_admin_explain'] = 'Da questo pannello puoi aggiungere, modificare, cancellare, riordinare e ri-sincronizzare le categorie e i forum';
$lang['Edit_forum'] = 'Modifica forum';
$lang['Create_forum'] = 'Crea un nuovo forum';
$lang['Create_category'] = 'Crea una nuova categoria';
$lang['Remove'] = 'Rimuovi';
$lang['Action'] = 'Azione';
$lang['Update_order'] = 'Aggiorna Ordine';
$lang['Config_updated'] = 'Configurazione Forum Aggiornata con Successo';
$lang['Edit'] = 'Modifica';
$lang['Delete'] = 'Cancella';
$lang['Move_up'] = 'Sposta su';
$lang['Move_down'] = 'Sposta gi�';
$lang['Resync'] = 'Sincronizza';
$lang['No_mode'] = 'Nessun mode impostato';
$lang['Forum_edit_delete_explain'] = 'Il modulo qui sotto ti permette di personalizzare tutte le opzioni generali del Forum. Per la Configurazione degli Utenti e dei Forum usa i collegamenti appropriati nel pannello di sinistra';

$lang['Move_contents'] = 'Sposta tutti i contenuti';
$lang['Forum_delete'] = 'Cancella Forum';
$lang['Forum_delete_explain'] = 'Il modulo qui sotto ti permette di cancellare un forum (o una categoria) e decidere dove mettere tutti gli argomenti (o forum) in esso/a contenuti';

$lang['Status_locked'] = 'Chiuso';
$lang['Status_unlocked'] = 'Ri-aperto';
$lang['Forum_settings'] = 'Impostazioni Generali Forum';
$lang['Forum_name'] = 'Nome Forum';
$lang['Forum_desc'] = 'Descrizione';
$lang['Forum_status'] = 'Stato del Forum';
$lang['Forum_pruning'] = 'Eliminazione Automatica';

$lang['prune_freq'] = 'Verifica l\'et� degli argomenti ogni';
$lang['prune_days'] = 'Rimuovi gli argomenti che non hanno avuto risposte per';
$lang['Set_prune_data'] = 'Hai attivato l\'eliminazione automatica per questo forum ma non hai impostato la frequenza o il numero di giorni per l\'autoeliminazione. Torna indietro e attivalo';

$lang['Move_and_Delete'] = 'Sposta e Cancella';

$lang['Delete_all_posts'] = 'Cancella tutti i messaggi';
$lang['Nowhere_to_move'] = 'Nessun posto dove spostare';

$lang['Edit_Category'] = 'Modifica Categoria';
$lang['Edit_Category_explain'] = 'Utilizza questo forum per modificare un nome di categorie';

$lang['Forums_updated'] = 'Le informazioni dei Forum e delle Categorie sono state aggiornate con successo';

$lang['Must_delete_forums'] = 'Devi cancellare tutti i forum per cancellare questa categoria';

$lang['Click_return_forumadmin'] = 'Clicca %squi%s per tornare a Amministrazione Forum';


//
// Smiley Management
//
$lang['smiley_title'] = 'Utility Modifica Smiley';
$lang['smile_desc'] = 'Da questa pagina puoi aggiungere, togliere e modificare le emoticons o gli smiley che i tuoi utenti possono utilizzare nei loro messaggi.';

$lang['smiley_config'] = 'Configurazione Smiley';
$lang['smiley_code'] = 'Codice Smiley';
$lang['smiley_url'] = 'File Immagine Smiley';
$lang['smiley_emot'] = 'Emozione Smiley';
$lang['smile_add'] = 'Aggiungi un nuovo Smiley';
$lang['Smile'] = 'Smile';
$lang['Emotion'] = 'Emotion';

$lang['Select_pak'] = 'Seleziona Pacchetto (.pak) File';
$lang['replace_existing'] = 'Sovrascrivi gli Smiley Esistenti';
$lang['keep_existing'] = 'Mantieni gli Smiley Esistenti';
$lang['smiley_import_inst'] = 'Devi decomprimere il pacchetto di smiley caricare i file nella cartella appropriata per l\'installazione. Poi seleziona le informazioni corrette da questo modulo per importare il pacchetto di smiley.';
$lang['smiley_import'] = 'Importazione Pacchetto Smiley';
$lang['choose_smile_pak'] = 'Seleziona un pacchetto di Smiley, estensione .pak';
$lang['import'] = 'Importa gli Smiley';
$lang['smile_conflicts'] = 'Cosa devi fare in caso di conflitti';
$lang['del_existing_smileys'] = 'Cancella gli smiley esistenti prima di importare';
$lang['import_smile_pack'] = 'Importa Pacchetto Smiley';
$lang['export_smile_pack'] = 'Crea Pacchetto Smiley';
$lang['export_smiles'] = 'Per creare un pacchetto di smiley dagli smiley installati, clicca %squi%s per scaricare il file di estensione .pak degli smiley. Nomina questo file in modo appropriato mantenendo l\'estensione .pak. Crea un file zip che contenga tutti i file immagine degli smiley e questo file .pak di configurazione.';

$lang['smiley_add_success'] = 'Gli Smiley sono stati aggiunti con successo.';
$lang['smiley_edit_success'] = 'Gli Smiley sono stati aggiornati con successo.';
$lang['smiley_import_success'] = 'Il pacchetto di Smiley � stato importato con successo!';
$lang['smiley_del_success'] = 'Gli Smiley sono stati rimossi con successo.';
$lang['Click_return_smileadmin'] = 'Clicca %squi%s per tornare a Amministrazione Smiley';


//
// User Management
//
$lang['User_admin'] = 'Administrazione Utenti';
$lang['User_admin_explain'] = 'Qui puoi cambiare le informazioni degli utenti e alcune opzioni specifiche. Per modificare il permessi degli utenti, utilizza il modulo di Amministrazione dei Permessi per Utenti e Gruppi.';

$lang['Look_up_user'] = 'Cerca Utente';

$lang['Admin_user_fail'] = 'Non � stato possibile aggiornare il profilo utente.';
$lang['Admin_user_updated'] = 'Il profilo utente � stato aggiornato con successo.';
$lang['Click_return_useradmin'] = 'Clicca %squi%s per tornare a Amministrazione Utenti';

$lang['User_delete'] = 'Cancela questo utente';
$lang['User_delete_explain'] = 'Clicca qui per cancellare questo utente. Questa operazione non pu� essere annullata.';
$lang['User_deleted'] = 'L\'utente � stato cancellato con successo.';

$lang['User_status'] = 'L\'utente � attivo';
$lang['User_allowpm'] = 'Pu� inviare Messaggi Privati';
$lang['User_allowavatar'] = 'Pu� mostrare gli Avatar';

$lang['Admin_avatar_explain'] = 'Qui puoi vedere e cancellare l\'avatar attuale dell\'utente.';

$lang['User_special'] = 'Campi speciali solo per l\'amministratore';
$lang['User_special_explain'] = 'Questi campi non possono essere modificati dagli utenti. Qui puoi impostare il loro stato e altre opzioni che non vengono date agli utenti.';


//
// Group Management
//
$lang['Group_administration'] = 'Amministrazione Gruppi';
$lang['Group_admin_explain'] = 'Da questo pannello puoi amministrare tutti i Gruppi Utenti. Puoi cancellare, creare e modificare i gruppi esistenti. Puoi scegliere i moderatori, modificare lo stato del gruppo (aperto/chiuso) e impostare il nome del gruppo e la descrizione.';
$lang['Error_updating_groups'] = 'C\'� stato un errore durante l\'aggiornamento dei gruppi';
$lang['Updated_group'] = 'Il gruppo � stato aggiornato con successo';
$lang['Added_new_group'] = 'Il nuovo gruppo � stato creato con successo';
$lang['Deleted_group'] = 'Il gruppo � stato cancellato con successo';
$lang['New_group'] = 'Crea nuovo gruppo';
$lang['Edit_group'] = 'Modifica gruppo';
$lang['group_name'] = 'Nome Gruppo';
$lang['group_description'] = 'Descrizione Gruppo';
$lang['group_moderator'] = 'Moderatore Gruppo';
$lang['group_status'] = 'Stato Gruppo';
$lang['group_open'] = 'Gruppo Aperto';
$lang['group_closed'] = 'Gruppo Chiuso';
$lang['group_hidden'] = 'Gruppo Nascosto';
$lang['group_delete'] = 'Cancella Gruppo';
$lang['group_delete_check'] = 'Cancella questo gruppo';
$lang['submit_group_changes'] = 'Invia Modifiche';
$lang['reset_group_changes'] = 'Annulla Modifiche';
$lang['No_group_name'] = 'Devi specificare un nome per questo gruppo';
$lang['No_group_moderator'] = 'Devi specificare un moderatore per questo gruppo';
$lang['No_group_mode'] = 'Devi specificare uno stato per questo gruppo, aperto o chiuso';
$lang['No_group_action'] = 'Nessuna azione specificata';
$lang['delete_group_moderator'] = 'Vuoi cancellare il vecchio moderatore del gruppo?';
$lang['delete_moderator_explain'] = 'Se cambi il moderatore del gruppo, seleziona questo box per rimuovere il vecchio moderatore. In caso contrario, non selezionarlo e l\'utente diverr� un normale membro del gruppo.';
$lang['Click_return_groupsadmin'] = 'Clicca %squi%s per tornare a Amministrazione Gruppi';
$lang['Select_group'] = 'Seleziona un gruppo';
$lang['Look_up_group'] = 'Controlla gruppo';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'Eliminazione Forum';
$lang['Forum_Prune_explain'] = 'Questo canceller� tutti gli argomenti a cui non � stata inviata una risposta nel numero di giorni che hai selezionato. Se non inserisci un numero TUTTI gli argomenti saranno cancellati. Non verranno cancellati gli argomenti con sondaggi ancora attivi e neppure gli Annunci. Devi cancellare questi argomenti manualmente.';
$lang['Do_Prune'] = 'Elimina';
$lang['All_Forums'] = 'Tutti i Forum';
$lang['Prune_topics_not_posted'] = 'Elimina gli argomenti senza risposte da giorni';
$lang['Topics_pruned'] = 'Argomenti eliminati';
$lang['Posts_pruned'] = 'Messaggi eliminati';
$lang['Prune_success'] = 'L\'eliminazione dei forum � avvenuta con successo';


//
// Word censor
//
$lang['Words_title'] = 'Censura Parole';
$lang['Words_explain'] = 'Da questo pannello puoi aggiungere, modificare e rimuovere parole che saranno censurate automaticamente da tutto il forum. Inoltre non sar� possibile registrarsi con gli username che contengono queste parole. Le abbreviazioni (*) sono accettate nel campo parola , eg. *tra* comprender� attraverso, tra* comprender� trave, *tra comprender� finestra.';
$lang['Word'] = 'Parola';
$lang['Edit_word_censor'] = 'Modifica Lista';
$lang['Replacement'] = 'Sostituto';
$lang['Add_new_word'] = 'Aggiungi una nuova parola';
$lang['Update_word'] = 'Aggiorna Lista';

$lang['Must_enter_word'] = 'Devi inserire una parola e il suo sostituto';
$lang['No_word_selected'] = 'Nessuna parola selezionata per la modifica';

$lang['Word_updated'] = 'La parola selezionata � stat aggiornata con successo';
$lang['Word_added'] = 'La parola � stata aggiunta con successo';
$lang['Word_removed'] = 'La Parola selezionata � stata rimossa con successo';

$lang['Click_return_wordadmin'] = 'Clicca %squi%s per tornare a Censure Parole';


//
// Mass Email
//
$lang['Mass_email_explain'] = 'Qui puoi inviare un messaggio a tutti i tuoi utenti o agli utenti di un gruppo specifico. Per fare questo, verr� inviato un messaggio all\'indirizzo email dell\'amministratore che hai fornito, ed una BCC (Blind Carbon Copy) verr� inviata ai destinatari. Se stai inviando una mail ad un grosso gruppo di utenti per favore si paziente dopo aver inviato e non interrompere il caricamento della pagina. Un tempo lungo � normale per una mass-email. quando il processo sar� finito, sarai avvisato.';
$lang['Compose'] = 'Componi'; 

$lang['Recipients'] = 'Destinatari'; 
$lang['All_users'] = 'Tutti gli Utenti';

$lang['Email_successfull'] = 'Il tuo messaggio � stato inviato';
$lang['Click_return_massemail'] = 'Clicca %squi%s per tornare a Email Generali';


//
// Ranks admin
//
$lang['Ranks_title'] = 'Amministrazione Livelli';
$lang['Ranks_explain'] = 'Con questo modulo puoi aggiungere, cancellare, modificare e guardare il livello degli utenti. Puoi anche creare dei livelli personali che possono essere applicati ad un utente attraverso la Gestione Utenti';

$lang['Add_new_rank'] = 'Aggiungi un novo livello';

$lang['Rank_title'] = 'Titolo Livello';
$lang['Rank_special'] = 'Imposta un Livello Speciale';
$lang['Rank_minimum'] = 'Messaggi Minimi';
$lang['Rank_maximum'] = 'Messaggi Massimi';
$lang['Rank_image'] = 'Immagine Livello (Relativo al percorso del forum)';
$lang['Rank_image_explain'] = 'Utilizza questo per definire una piccola immagine associata con il livello';

$lang['Must_select_rank'] = 'Devi selezionare un livello';
$lang['No_assigned_rank'] = 'Nessun livello speciale assegnato';

$lang['Rank_updated'] = 'Il livello � stato aggiornato con successo';
$lang['Rank_added'] = 'Il livello � stato aggiunto con successo';
$lang['Rank_removed'] = 'Il livello � stato cancellato con successo';
$lang['No_update_ranks'] = 'Il livello � stato cancellato con successo, in ogni caso gli utenti che utilizzavano questo livello non sono stati aggiornati. Dovrai impostare manualmente il nuovo livello a questi utenti';

$lang['Click_return_rankadmin'] = 'Clicca %squi%s per tornare a Amministrazione Livelli';


//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'Controllo Disabilitazione Utenti';
$lang['Disallow_explain'] = 'Qui puoi controllare gli username che non si possono utilizzare. Gli username disabilitati possono contenere una abbreviazione (*). Per favore nota che non puoi specificare nessuno username che � gi� stato registrato, devi prima cancellare il nome e poi disabilitarlo';

$lang['Delete_disallow'] = 'Cancella';
$lang['Delete_disallow_title'] = 'Rimuovi uno Username Disabilitato';
$lang['Delete_disallow_explain'] = 'Puoi rimuovere uno username disabilitato selezionando lo username da questa lista e cliccando su invia';

$lang['Add_disallow'] = 'Aggiungi';
$lang['Add_disallow_title'] = 'Aggiungi uno username disabilitato';
$lang['Add_disallow_explain'] = 'Puoi disabilitare uno username utilizzando l\'abbreviazione * per comprendere ogni carattere';

$lang['No_disallowed'] = 'Nessuno Username Disabilitato';

$lang['Disallowed_deleted'] = 'Lo username disabilitato � stato rimosso con successo';
$lang['Disallow_successful'] = 'Lo username disabilitato � stato aggiunto con successo';
$lang['Disallowed_already'] = 'Il nome che hai inserito non pu� essere disabilitato. Esiste gi� nella lista delle parole censurate o esiste uno username con questo nome';

$lang['Click_return_disallowadmin'] = 'Clicca %squi%s per tornare a Disabilitazione Utenti';


//
// Styles Admin
//
$lang['Styles_admin'] = 'Amministrazione Stili';
$lang['Styles_explain'] = 'Utilizzando queste opzioni puoi aggiungere, rimuovere e gestire gli stili (modelli e temi) del tuo forum';
$lang['Styles_addnew_explain'] = 'La lista seguente contiene tutti i temi che sono disponibili per i modelli che hai al momento. I temi nella lista non sono ancora stati caricati nel database del forum. Per installarli semplicemente clicca sul link installa di fianco ad ogni stile.';

$lang['Select_template'] = 'Seleziona un Modello';

$lang['Style'] = 'Stile';
$lang['Template'] = 'Modello';
$lang['Install'] = 'Installa';
$lang['Download'] = 'Scarica';

$lang['Edit_theme'] = 'Modifica Tema';
$lang['Edit_theme_explain'] = 'Nel modulo qui sotto puoi modificare le impostazioni per il tema selezionato';

$lang['Create_theme'] = 'Crea Tema';
$lang['Create_theme_explain'] = 'Utilizza il modulo qui sotto per creare un unovo tema per il modello selezionato. Quando inserisci i colori (devi usare la notazione esadecimale) non  devi includere all\'inizio #, es. CCCCCC � valido, #CCCCCC non valido.';

$lang['Export_themes'] = 'Esporta Temi';
$lang['Export_explain'] = 'In questo pannello puoi esportare i dati del tema per il modello selezionato. Seleziona un modello dalla lista qui sotto e lo script creer� il file di configurazione del tema e tenter� di salvarlo nella directory dei modelli (template). Se non pu� salvare il file, il programma ti dar� la possibilit� di scaricarlo. Per permettere allo script di salvare il file devi dare il permesso di scrittura alla directory dei modelli sul server. Per ulteriori informazioni consulta la guida utenti di phpBB2.';

$lang['Theme_installed'] = 'Il tema selezionato � stato installato con successo';
$lang['Style_removed'] = 'Lo stile selezionato � stato rimosso dal database. Per rimuovere completamente questo stile dal tuo sistema, devi cancellare lo stile dalla directory dei modelli (template).';
$lang['Theme_info_saved'] = 'Le informazioni dl tema per il modello selezionato sono state salvate. Adesso devi reimpostare i permessi del file theme_info.cfg (e se possibile anche nella directory dei modelli) su sola lettura';
$lang['Theme_updated'] = 'Il tema selezionato � stato aggiornato. Adesso devi esportare le impostazioni del nuovo tema';
$lang['Theme_created'] = 'Tema creato. Adesso devi esportare il tema nel file di configurazione del tema per utilizzarlo da un\'altra parte';

$lang['Confirm_delete_style'] = 'Sei sicuro di voler cancellare questo stile?';

$lang['Download_theme_cfg'] = 'Il processo di esportazione non riesce a scrivere il file di configurazione del tema. Clicca il bottone qui sotto per scaricare questo file con il tuo browser. Dopo averlo scaricato puoi trasferirlo nella directory che contiene i file dei modelli. Dopo puoi compattare i file per distribuirli o per riutilizzarli';
$lang['No_themes'] = 'Il modello che hai selezionato non ha temi allegati. Per creare un nuovo tema clicca sul link Crea Tema nel pannello di sinistra';
$lang['No_template_dir'] = 'Non � possibile aprire la directory dei modelli. Potrebbe essere non leggibile dal server o potrebbe non esistere';
$lang['Cannot_remove_style'] = 'You cannot remove the style selected since it is currently the forum default. Please change the default style and try again.';
$lang['Style_exists'] = 'Non puoi rimuovere lo stile selezionato perch� � quello di default nel forum. Cambia lo stile di default e poi riprova';

$lang['Click_return_styleadmin'] = 'Clicca %squi%s per tornare a Amministrazione Stili';

$lang['Theme_settings'] = 'Impostazioni del Tema';
$lang['Theme_element'] = 'Elemento del Tema';
$lang['Simple_name'] = 'Nome Semplice';
$lang['Value'] = 'Valore';
$lang['Save_Settings'] = 'Salva Impostazioni';

$lang['Stylesheet'] = 'Foglio di Stile CSS';
$lang['Background_image'] = 'Immagine di Sfondo';
$lang['Background_color'] = 'Colore di Sfondo';
$lang['Theme_name'] = 'Nome Tema';
$lang['Link_color'] = 'Colore Link';
$lang['Text_color'] = 'Colore Testo';
$lang['VLink_color'] = 'Colore Link Visitato';
$lang['ALink_color'] = 'Colore Link Attivo';
$lang['HLink_color'] = 'Colore Link Hover';
$lang['Tr_color1'] = 'Tabella Colonna Colore 1';
$lang['Tr_color2'] = 'Tabella Colonna Colore 2';
$lang['Tr_color3'] = 'Tabella Colonna Colore 3';
$lang['Tr_class1'] = 'Tabella Colonna Classe 1';
$lang['Tr_class2'] = 'Tabella Colonna Classe 2';
$lang['Tr_class3'] = 'Tabella Colonna Classe 3';
$lang['Th_color1'] = 'Tabella Intestazione Colore 1';
$lang['Th_color2'] = 'Tabella Intestazione Colore 2';
$lang['Th_color3'] = 'Tabella Intestazione Colore 3';
$lang['Th_class1'] = 'Tabella Intestazione Colore 1';
$lang['Th_class2'] = 'Tabella Intestazione Colore 2';
$lang['Th_class3'] = 'Tabella Intestazione Colore 3';
$lang['Td_color1'] = 'Tabella Cella Colore 1';
$lang['Td_color2'] = 'Tabella Cella Colore 2';
$lang['Td_color3'] = 'Tabella Cella Colore 3';
$lang['Td_class1'] = 'Tabella Cella Colore 1';
$lang['Td_class2'] = 'Tabella Cella Colore 2';
$lang['Td_class3'] = 'Tabella Cella Colore 3';
$lang['fontface1'] = 'Nome Carattere 1';
$lang['fontface2'] = 'Nome Carattere 2';
$lang['fontface3'] = 'Nome Carattere 3';
$lang['fontsize1'] = 'Dimensione Carattere 1';
$lang['fontsize2'] = 'Dimensione Carattere 2';
$lang['fontsize3'] = 'Dimensione Carattere 3';
$lang['fontcolor1'] = 'Colore Carattere 1';
$lang['fontcolor2'] = 'Colore Carattere 2';
$lang['fontcolor3'] = 'Colore Carattere 3';
$lang['span_class1'] = 'Classe Span 1';
$lang['span_class2'] = 'Classe Span 2';
$lang['span_class3'] = 'Classe Span 3';
$lang['img_poll_size'] = 'Dimensione Immagine Votazione [px]';
$lang['img_pm_size'] = 'Dimensione Stato Messaggi Privati [px]';


//
// Install Process
//
$lang['Welcome_install'] = 'Benvenuto nell\'installazione di phpBB 2';
$lang['Initial_config'] = 'Configurazione Base';
$lang['DB_config'] = 'Configurazione Database';
$lang['Admin_config'] = 'Configurazione Amministrazione';
$lang['continue_upgrade'] = 'Dopo aver scaricato il file di configurazione sul tuo computer puoi cliccare sul bottone \"Continua l\'Aggiornamento\" qui sotto per avanzare con il processo di aggiornamento. Caricare il file di configurazione aspetta la fine del processo di aggiornamento.';
$lang['upgrade_submit'] = 'Continua Aggiornamento';

$lang['Installer_Error'] = 'Si � verificato un errore durante l\'installazione';
$lang['Previous_Install'] = '� stata rilevata una precedente installazione';
$lang['Install_db_error'] = 'Si � verificato un errore durante l\'aggiornamento del database';

$lang['Re_install'] = 'La tua installazione precedente � ancora attiva. <br /><br />Se vuoi installare di nuovo phpBB 2 clicca il bottone di conferma qui sotto. Sappi che questa operazione distrugger� tutti i dati esistenti, non verr� fatto alcun backup! Username e Password dell\'amministratore che hai usato per entrare nel forum verranno ricreate dopo la nuova installazione, nessun altra impostazione verr� mantenuta. <br /><br />Pensaci bene prima di CONFERMARE!';

$lang['Inst_Step_0'] = 'Grazie per aver scelto phpBB 2. Per completare correttamente l\'installazione devi riempire tutti i campi sottostanti. Prima di procedere assicurarti di avere un database con tutti i dati d\'accesso. Se stai installando il forum su un database che utilizza ODBC, es. MS Access devi prima creargli un DSN prima di procedere all\'installazione.';

$lang['Start_Install'] = 'Inizia Installazione';
$lang['Finish_Install'] = 'Termina Installazione';

$lang['Default_lang'] = 'Lingua di Default del Forum';
$lang['DB_Host'] = 'Database Server Hostname / DSN';
$lang['DB_Name'] = 'Nome Database';
$lang['DB_Username'] = 'Username Database';
$lang['DB_Password'] = 'Password Database';
$lang['Database'] = 'Il Tuo Database';
$lang['Install_lang'] = 'Scegli una Lingua per l\'Installazione';
$lang['dbms'] = 'Tipo di Database';
$lang['Table_Prefix'] = 'Prefisso Tabelle Database';
$lang['Admin_Username'] = 'Username Amministratore';
$lang['Admin_Password'] = 'Password Amministratore';
$lang['Admin_Password_confirm'] = 'Password Amministratore [ Conferma ]';

$lang['Inst_Step_2'] = 'Il tuo username come Amministratore � stato creato. A questo punto la tua installazione di base � terminata. Adesso ti verr� mostrato una schermata dove potrai amministrare il tuo Nuovo phpBB. Per favore verifica i dettagli della Configurazione Generale e cambiali in base alle tue esigenze. Grazie per aver scelto phpBB 2.';

$lang['Unwriteable_config'] = 'Non posso scrivere il file config.php automaticamente. Scaricare una copia del tuo file di configurazione cliccando sul bottone qui sotto. Devi caricare questo file nella stessa directory di phpBB 2. Successivamente potrai logarti con nome e password di amministrazione che hai fornito nel modulo precedente e andare nel pannello di controllo (un link apparir� in fondo ad ogni pagina dopo che sei entrato) per verificare le impostazioni generali di configurazione. Grazie per aver scelto phpBB 2.';
$lang['Download_config'] = 'Scarica il file di Configurazione';

$lang['ftp_choose'] = 'Scegli Metodo Scaricamento';
$lang['ftp_option'] = '<br />Poich� le estensioni FTP non sono disponibili in questa versione di  PHP usa l\'opzione di caricare automaticamente via ftp il file di configurazione.';
$lang['ftp_instructs'] = 'Hai scelto di caricare automaticamente via ftp il file sull\'account che contiene phpBB 2. Inserisci le informazioni per facilitare il processo. Il percorso FTP deve essere il percorso esatto dell\'installazione di phpBB2 come se stessi caricando via ftp con un normale programma client.';
$lang['ftp_info'] = 'Inserisci le Tue Informazioni FTP';
$lang['Attempt_ftp'] = 'Tentativo di caricare via FTP il file di configurazione';
$lang['Send_file'] = 'Inviatemi il file e lo caricher� via FTP manualmente';
$lang['ftp_path'] = 'Percorso FTP per phpBB 2';
$lang['ftp_username'] = 'Il tuo Username FTP';
$lang['ftp_password'] = 'La tua Password FTP';
$lang['Transfer_config'] = 'Inizio Trasferimento';
$lang['NoFTP_config'] = 'Il tentativo di trasferire il file via FTP � fallito. Scarica il file config e trasferiscilo sul server manualmente.';

$lang['Install'] = 'Installa';
$lang['Upgrade'] = 'Aggiorna';


$lang['Install_Method'] = 'Scegli un metodo di installazione';

$lang['Install_No_Ext'] = 'La configurazione php del tuo server non supporta il tipo di database che hai scelto';

$lang['Install_No_PCRE'] = 'phpBB2 Richiede il Perl-Compatible Regular Expressions Module. La tua configurazione PHP non lo supporta!';

//
// Version Check
//
$lang['Version_up_to_date'] = 'Nessun aggiornamento disponibili per la versione in uso di phpBB.';
$lang['Version_not_up_to_date'] = 'La versione in uso <il b>non </ b>� recente. Per gli aggiornamenti disponibili visita <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/downloads.php</a> per vedere l\'ultima versione.';
$lang['Latest_version_info'] = 'L\'ultima versione disponibile � <b>phpBB %s</b>.';
$lang['Current_version_info'] = 'La tua Versione � <b>phpBB %s</b>.';
$lang['Connect_socket_error'] = 'Impossibile il collegamento a phpBB. Rapporto errore:<br />%s';
$lang['Socket_functions_disabled'] = 'Impossibile utilizzare la funzione socket.';
$lang['Mailing_list_subscribe_reminder'] = 'Per le ultime informazioni su aggiornamenti a phpBB <a href="http://www.phpbb.com/support/" target="_new">iscriviti alla mailing list</a>.';
$lang['Version_information'] = 'Informazione Versione';

//
// That's all Folks!
// -------------------------------------------------

?>