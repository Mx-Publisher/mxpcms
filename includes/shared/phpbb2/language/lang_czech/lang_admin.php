<?php
/***************************************************************************
 *                            lang_admin.php [Czech]
 *                            ----------------------
 *     characterset         : UTF-8
 *     phpBB version        : 2.0.20
 *     copyright            : © 2005 The phpBB CZ Group
 *     www                  : http://www.phpbbcz.com
 *     last modified        : 08. 04. 2006
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/


//
// Format is same as lang_main
//


//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//
$lang['General'] = 'Obecné';
$lang['Users'] = 'Uživatelé';
$lang['Groups'] = 'Skupiny';
$lang['Forums'] = 'Fórum';
$lang['Styles'] = 'Styly';

$lang['Configuration'] = 'Konfigurace';
$lang['Permissions'] = 'Oprávnění';
$lang['Manage'] = 'Administrace';
$lang['Disallow'] = 'Nepovolená jména';
$lang['Prune'] = 'Pročištění';
$lang['Mass_Email'] = 'Hromadný e-mail';
$lang['Ranks'] = 'Hodnocení';
$lang['Smilies'] = 'Smajlíky (emotikony)';
$lang['Ban_Management'] = 'Zakázání vstupu';
$lang['Word_Censor'] = 'Cenzura slov';
$lang['Export'] = 'Exportovat';
$lang['Create_new'] = 'Vytvořit';
$lang['Add_new'] = 'Přidat';
$lang['Backup_DB'] = 'Zálohovat databázi';
$lang['Restore_DB'] = 'Obnovit databázi';


//
// Index
//
$lang['Admin'] = 'Administrace';
$lang['Not_admin'] = 'Nemáte oprávnění k administraci tohoto fóra.';
$lang['Welcome_phpBB'] = 'Vítejte na phpBB';
$lang['Admin_intro'] = 'Děkujeme, že jste si zvolil(a) phpBB jako řešení pro vaše fórum. Tato stránka slouží k rychlému zobrazení různých statistik vašeho fóra. Pokud se budete chtít vrátit zpět na tuto stránku klikněte na odkaz <u>Obsah administrace</u> v levém panelu. Pro návrat na obsah vašeho fóra, klikněte na logo fóra umístěném též na levém panelu. Ostatní odkazy na levém panelu této stránky vás dovedou k jednotlivým položkám možného nastavení fóra dle vašich požadavků, každá stránka obsahuje návod jak použít danou funkci.';
$lang['Main_index'] = 'Obsah fóra';
$lang['Forum_stats'] = 'Statistiky fóra';
$lang['Admin_Index'] = 'Obsah administrace';
$lang['Preview_forum'] = 'Náhled na fórum';

$lang['Click_return_admin_index'] = 'Klikněte %szde%s pro návrat na obsah administrace.';

$lang['Statistic'] = 'Statistiky';
$lang['Value'] = 'Hodnota';
$lang['Number_posts'] = 'Počet příspěvků';
$lang['Posts_per_day'] = 'Příspěvků za den';
$lang['Number_topics'] = 'Počet témat';
$lang['Topics_per_day'] = 'Témat za den';
$lang['Number_users'] = 'Počet uživatelů';
$lang['Users_per_day'] = 'Uživatelů za den';
$lang['Board_started'] = 'Fórum spuštěno';
$lang['Avatar_dir_size'] = 'Velikost adresáře s obrázky postaviček';
$lang['Database_size'] = 'Velikost databáze';
$lang['Gzip_compression'] ='GZIP komprese';
$lang['Not_available'] = 'Nedostupné';

$lang['ON'] = 'Ano'; // This is for GZip compression
$lang['OFF'] = 'Ne';


//
// DB Utils
//
$lang['Database_Utilities'] = 'Databázové nástroje';

$lang['Restore'] = 'Obnovení';
$lang['Backup'] = 'Zálohování';
$lang['Restore_explain'] = 'Tato funkce je určena k úplnému obnovení všech databázových tabulek phpBB fóra z uložených souborů. Jestliže to váš server podporuje, můžete použít GZIP komprimované textové soubory a ty pak budou automaticky dekomprimovány. <b>POZOR</b> Tímto budou přepsána veškerá existující data. Obnovení potřebuje delší čas na zpracování, proto prosím neopouštějte tuto stránku dokud nebude vše dokončeno.';
$lang['Backup_explain'] = 'Tato funkce je určena ke kompletní záloze dat phpBB fóra. Jestliže používáte některé další tabulky společně s phpBB databází, doporučujeme je též zálohovat, zadejte proto prosím názvy tabulek a oddělte je oddělovačem (,). Jestliže to váš server podporuje, můžete použít GZIP kompresy dat pro zmenšení velikosti souborů před jejich stažením do vašeho počítače.';

$lang['Backup_options'] = 'Nastavení zálohy';
$lang['Start_backup'] = 'Spustit zálohování';
$lang['Full_backup'] = 'Kompletní záloha';
$lang['Structure_backup'] = 'Zálohovat pouze strukturu';
$lang['Data_backup'] = 'Zálohovat pouze data';
$lang['Additional_tables'] = 'Další tabulky';
$lang['Gzip_compress'] = 'GZIP komprese souborů';
$lang['Select_file'] = 'Zvolit soubor';
$lang['Start_Restore'] = 'Spustit obnovení';

$lang['Restore_success'] = 'Databáze byla úspěšně obnovena.<br><br>Vaše fórum by nyní mělo být ve stavu před provedením zálohy.';
$lang['Backup_download'] = 'Prosím vyčkejte začátku stahování.';
$lang['Backups_not_supported'] = 'Lituji, ale zálohování databáze není v současné době ve vešem databázovém systému podporováno.';

$lang['Restore_Error_uploading'] = 'Vyskytla se chyba při nahrávání souboru zálohy.';
$lang['Restore_Error_filename'] = 'Vyskytl se problém s názvem souboru, zkuste jiný.';
$lang['Restore_Error_decompress'] = 'Nebylo možné dekomprimovat GZIP soubor, použijte textový soubor.';
$lang['Restore_Error_no_file'] = 'Nebyl nahrán žádný soubor.';


//
// Auth pages
//
$lang['Select_a_User'] = 'Zvolit uživatele';
$lang['Select_a_Group'] = 'Zvolit skupinu';
$lang['Select_a_Forum'] = 'Zvolit fórum';
$lang['Auth_Control_User'] = 'Uživatelská oprávnění';
$lang['Auth_Control_Group'] = 'Oprávnění skupiny';
$lang['Auth_Control_Forum'] = 'Oprávnění fóra';
$lang['Look_up_User'] = 'Zvolit uživatele';
$lang['Look_up_Group'] = 'Zvolit skupinu';
$lang['Look_up_Forum'] = 'Zvolit fórum';

$lang['Group_auth_explain'] = 'Zde můžete měnit oprávnění a přiřadit moderování skupině uživatelů. Nezapomeňte, že individuální oprávnění uživatele mohou stále dovolovat uživateli akce, které jste skupině zakázali (vstup uživatele na fórum apod.). Pokud tento případ nastane, budete varováni.';
$lang['User_auth_explain'] = 'Zde můžete měnit oprávnění a přiřadit moderování zvolenému uživateli. Nezapomeňte, že oprávnění skupiny může stále dovolovat uživateli akce, které jste uživateli zakázali (vstup uživatele na fórum apod.). Pokud tento případ nastane, budete varováni.';
$lang['Forum_auth_explain'] = 'Zde můžete nastavit úroveň zabezpečení fóra. Můžete zvolit základní nebo rozšířený mód pro tuto činnost. Rozšířený mód nabízí mnohem větší škálu možností pro nastavení fóra. Pamatujte, že před změnou zabezpečení fóra by se na fóru neměly provádět jiné operace.';

$lang['Simple_mode'] = 'Základní režim';
$lang['Advanced_mode'] = 'Rozšířený režim';
$lang['Moderator_status'] = 'Moderátor';

$lang['Allowed_Access'] = 'Přístup povolen';
$lang['Disallowed_Access'] = 'Přístup zamítnut';
$lang['Is_Moderator'] = 'Je moderátorem';
$lang['Not_Moderator'] = 'Není moderátorem';

$lang['Conflict_warning'] = 'Varování, autorizační konflikt';
$lang['Conflict_access_userauth'] = 'Tento uživatel má požadovaná přístupová práva k tomuto fóru přes členství ve skupině. Můžete povolit oprávnění skupině nebo odstranit tohoto uživatele ze skupiny pro úplné zabránění požadovaných přístupových práv.';
$lang['Conflict_mod_userauth'] = 'Tento moderátor má požadovaná práva pro toto fórum přes členství ve skupině. Můžete povolit oprávnění skupině nebo odstranit tohoto uživatele ze skupiny pro úplné zabránění požadovaných přístupových práv.';
$lang['Conflict_access_groupauth'] = 'Následující uživatel (uživatelé) mají požadovaná práva pro toto fórum přes jejich nastavené oprávnění. Můžete povolit oprávnění skupině nebo odstranit tohoto uživatele ze skupiny pro úplné zabránění požadovaných přístupových práv.';
$lang['Conflict_mod_groupauth'] = 'Následující uživatel (uživatelé) mají požadovaná práva pro toto fórum přes jejich nastavené oprávnění. Můžete povolit oprávnění skupině nebo odstranit tohoto uživatele ze skupiny pro úplné zabránění požadovaných přístupových práv.';

$lang['Public'] = 'Veřejný';
$lang['Private'] = 'Soukromý';
$lang['Registered'] = 'Registrovaný';
$lang['Administrators'] = 'Administrátor';
$lang['Hidden'] = 'skrytý';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = 'Všichni';
$lang['Forum_REG'] = 'Registrovaný';
$lang['Forum_PRIVATE'] = 'Soukromý';
$lang['Forum_MOD'] = 'Moderátor';
$lang['Forum_ADMIN'] = 'Administrátor';

$lang['View'] = 'Zobrazit';
$lang['Read'] = 'Číst';
$lang['Post'] = 'Odeslat';
$lang['Reply'] = 'Odpovědět';
$lang['Edit'] = 'Upravit';
$lang['Delete'] = 'Odstranit';
$lang['Sticky'] = 'Důležité';
$lang['Announce'] = 'Oznámení';
$lang['Vote'] = 'Hlasování';
$lang['Pollcreate'] = 'Hlas přidán';

$lang['Permissions'] = 'Oprávnění';
$lang['Simple_Permission'] = 'Základní oprávnění';

$lang['User_Level'] = 'Uživatelská úroveň';
$lang['Auth_User'] = 'Uživatel';
$lang['Auth_Admin'] = 'Administrátor';
$lang['Group_memberships'] = 'Členství uživatelské skupiny';
$lang['Usergroup_members'] = 'Tato skupina má následující členy';

$lang['Forum_auth_updated'] = 'Oprávnění fóra bylo aktualizováno.';
$lang['User_auth_updated'] = 'Uživatelské oprávnění bylo aktualizováno.';
$lang['Group_auth_updated'] = 'Oprávnění skupiny bylo aktualizováno.';

$lang['Auth_updated'] = 'Oprávnění bylo aktualizováno.';
$lang['Click_return_userauth'] = 'Klikněte %szde%s pro návrat do uživatelského oprávnění.';
$lang['Click_return_groupauth'] = 'Klikněte %szde%s pro návrat do oprávnění skupiny.';
$lang['Click_return_forumauth'] = 'Klikněte %szde%s pro návrat na oprávnění fóra.';


//
// Banning
//
$lang['Ban_control'] = 'Zakázání vstupu';
$lang['Ban_explain'] = 'Zde můžete zakázat vstup zvoleným uživatelům. Můžete zakázat konkrétního uživatele nebo rozsah IP adres nebo jméno počítače. Touto metodou ochráníte vaše fórum proti vstupu nežádoucích uživatelů na stránky fóra. Proti registraci uživatele pod jiným jménem můžete zakázat jeho e-mailovou adresu.';
$lang['Ban_explain_warn'] = 'Dávejte si prosím pozor při zadávání rozsahu IP adres zda jsou všechny adresy od začátku do konce v seznamu. Doporučuje se, aby byl seznam uložených IP adres v databázi co nejmenší, proto se pokuste raději použít znaku "*" pro specifikaci namísto zadávání rozsahu IP adres. Pokud je přesto nutno zadat rozsah IP adres, pokuste se, aby byl seznam co nejkratší.';

$lang['Select_username'] = 'Zvolte uživatele';
$lang['Select_ip'] = 'Zvolte IP';
$lang['Select_email'] = 'Zvolte e-mailovou adresu';

$lang['Ban_username'] = 'Zakázání vstupu zadaným uživatelům';
$lang['Ban_username_explain'] = 'Chcete-li přidat do zakázaných některého uživatele, zadejte zde jeho jméno, případně jej vyhledejte ze seznamu registrovaných uživatelů.';

$lang['Ban_IP'] = 'Zakázání vstupu dle IP adresy nebo jména počítače';
$lang['IP_hostname'] = 'IP adresa nebo jméno počítače';
$lang['Ban_IP_explain'] = 'Zde můžete zadat název počítače, či IP adresy, kterým chcete zakázat vstup. Jednotlivé adresy či jména od sebe oddělte oddělovčem. Chcete-li zadat rozsah IP adres, oddělte je od sebe znakem "-". Můžete použít i znak "*" pro nahrazení části řetězce.';

$lang['Ban_email'] = 'Zakázání vstupu dle e-mailových adres';
$lang['Ban_email_explain'] = 'Zde můžete zadat seznam e-mailových adres, kterým chcete zamezit vstup, jednotlivé adresy od sebe oddělte oddělovačem. Můžete použít i znak "*" pro nahrazení části adresy, např. *@hotmail.com';

$lang['Unban_username'] = 'Vyjmutí uživatelů ze seznamu zakázaných';
$lang['Unban_username_explain'] = 'Jestliže chcete vyjmout některé uživatele z tohoto seznamu, označte je pomocí myši či klávesnice a potvrďte odesláním.';

$lang['Unban_IP'] = 'Vyjmutí IP adres ze seznamu zakázaných';
$lang['Unban_IP_explain'] = 'Jestliže chcete vyjmout některé IP adresy z tohoto seznamu, označte je pomocí myši či klávesnice a potvrďte odesláním.';

$lang['Unban_email'] = 'Vyjmutí e-mailových adres ze seznamu zakázaných';
$lang['Unban_email_explain'] = 'Jestliže chcete vyjmout některé e-mailové adresy z tohoto seznamu, označte je pomocí myši či klávesnice a potvrďte odesláním.';

$lang['No_banned_users'] = 'Žádní zakázaní uživatelé';
$lang['No_banned_ip'] = 'Žádné zakázané IP adresy';
$lang['No_banned_email'] = 'Žádné zakázané e-mailové adresy';

$lang['Ban_update_sucessful'] = 'Seznam zakázaných uživatelů byl úspěšně aktualizován.';
$lang['Click_return_banadmin'] = 'Klikněte %szde%s pro návrat do ovládacího panelu zakázaní vstupu.';


//
// Configuration
//
$lang['General_Config'] = 'Konfigurace';
$lang['Config_explain'] = 'Níže uvedené položky vám umožní nastavit fórum dle vašich požadavků. Pro nastavení uživatelů a fóra používejte odkazy v levé části stránky.';

$lang['Click_return_config'] = 'Klikněte %szde%s pro návrat do konfigurace.';

$lang['General_settings'] = 'Obecné nastavení fóra';
$lang['Server_name'] = 'Jméno domény';
$lang['Server_name_explain'] = 'Doménové jméno tohoto fóra běží na';
$lang['Script_path'] = 'Cesta ke skriptům';
$lang['Script_path_explain'] = 'Cesta ke skriptům phpBB, relativní umístění v doméně';
$lang['Server_port'] = 'Port serveru';
$lang['Server_port_explain'] = 'Port na kterém běží váš server, standardně 80';
$lang['Site_name'] = 'Jméno fóra';
$lang['Site_desc'] = 'Popis fóra';
$lang['Board_disable'] = 'Uzavřít fórum';
$lang['Board_disable_explain'] = 'Tímto znepřístupníte fórum pro uživatele. Neodhlašujte se pokud jste znepřístupnil fórum, jinak se nebudete moci přihlásit zpět!';
$lang['Acct_activation'] = 'Způsob aktivace účtu';
$lang['Acc_None'] = 'Žádný'; // These three entries are the type of activation
$lang['Acc_User'] = 'Uživatelem';
$lang['Acc_Admin'] = 'Administrátorem';

$lang['Abilities_settings'] = 'Základní nastavení pro uživatele a fórum';
$lang['Max_poll_options'] = 'Maximální počet možnosti pro hlasování';
$lang['Flood_Interval'] = 'Ochranný interval';
$lang['Flood_Interval_explain'] = 'Počet vteřin, po které musí uživatel počkat mezi příspěvky';
$lang['Board_email_form'] = 'Zasílat e-maily přes toto fórum';
$lang['Board_email_form_explain'] = 'Umožňuje zasílání e-mailů jiným uživatelům přes toto fórum (není přímo vidět e-mailová adresa příjemce)';
$lang['Topics_per_page'] = 'Témat na stránku';
$lang['Posts_per_page'] = 'Příspěvků na stránku';
$lang['Hot_threshold'] = 'Příspěvky do přípustné hranice';
$lang['Default_style'] = 'Výchozí vzhled';
$lang['Override_style'] = 'Ignorovat uživatelovo nastavení vzhledu';
$lang['Override_style_explain'] = 'Použije výchozí vzhled namísto zvoleného uživatelem';
$lang['Default_language'] = 'Výchozí jazyk';
$lang['Date_format'] = 'Formát data';
$lang['System_timezone'] = 'Časové pásmo fóra';
$lang['Enable_gzip'] = 'Povolit GZIP kompresi';
$lang['Enable_prune'] = 'Povolit pročištění fóra';
$lang['Allow_HTML'] = 'Povolit HTML';
$lang['Allow_BBCode'] = 'Povolit značky';
$lang['Allowed_tags'] = 'Povolené HTML značky';
$lang['Allowed_tags_explain'] = 'oddělte značky oddělovačem (,)';
$lang['Allow_smilies'] = 'Povolit smajlíky (emotikony)';
$lang['Smilies_path'] = 'Cesta k umístění smajlíků';
$lang['Smilies_path_explain'] = 'Cesta mimo váš phpBB kořenový adresář, př.: images/smilies';
$lang['Allow_sig'] = 'Povolit podpisy';
$lang['Max_sig_length'] = 'Maximální délka podpisu';
$lang['Max_sig_length_explain'] = 'Maximální počet znaků uživatelova podpisu';
$lang['Allow_name_change'] = 'Povolit změnu uživatelského jména';

$lang['Avatar_settings'] = 'Nastavení obrázků postaviček';
$lang['Allow_local'] = 'Povolit galerii postaviček';
$lang['Allow_remote'] = 'Povolit pouze odkazy na obrázky postaviček';
$lang['Allow_remote_explain'] = 'Obrázek postavičky je stahován z jiného serveru';
$lang['Allow_upload'] = 'Povolit přihrávání obrázků postaviček na server';
$lang['Max_filesize'] = 'Maximální velikost souboru s obrázkem postavičky';
$lang['Max_filesize_explain'] = 'Pro přihrávání souborů obrázků postaviček';
$lang['Max_avatar_size'] = 'Maximální rozměry obrázku postavičky';
$lang['Max_avatar_size_explain'] = '(výška × šířka v bodech)';
$lang['Avatar_storage_path'] = 'Cesta k ukládání obrázků postaviček';
$lang['Avatar_storage_path_explain'] = 'Cesta mimo váš phpBB kořenový adresář, př.: images/avatars';
$lang['Avatar_gallery_path'] = 'Cesta ke galerii obrázků postaviček';
$lang['Avatar_gallery_path_explain'] = 'Cesta mimo váš phpBB kořenový adresář pro přednastavené obrázky, př.: images/avatars/gallery';

$lang['COPPA_settings'] = 'COPPA nastavení';
$lang['COPPA_fax'] = 'COPPA faxové číslo';
$lang['COPPA_mail'] = 'COPPA e-mailové adresy';
$lang['COPPA_mail_explain'] = 'Toto je seznam adres na které budou rodiče zasílat COPPA registrační formulář';

$lang['Email_settings'] = 'Nastavení e-mailů';
$lang['Admin_email'] = 'Administrátorova e-mailová adresa:';
$lang['Email_sig'] = 'Podpis e-mailu';
$lang['Email_sig_explain'] = 'Tento text bude připojen ke všem e-mailům odeslaným z tohoto fóra';
$lang['Use_SMTP'] = 'Použít SMTP server pro e-mail';
$lang['Use_SMTP_explain'] = 'Zvolte Ano, jestliže chcete odesílat e-maily přes jméno serveru namísto lokální mail funkce.';
$lang['SMTP_server'] = 'Adresa SMTP serveru';
$lang['SMTP_username'] = 'SMTP účet';
$lang['SMTP_username_explain'] = 'Zadejte pouze v případě, že to váš SMTP server vyžaduje';
$lang['SMTP_password'] = 'SMTP heslo';
$lang['SMTP_password_explain'] = 'Zadejte pouze v případě, že to váš SMTP server vyžaduje';

$lang['Disable_privmsg'] = 'Soukromé zprávy';
$lang['Inbox_limits'] = 'Max. počet příspěvků ve složce doručené';
$lang['Sentbox_limits'] = 'Max. počet příspěvků ve složce odeslané';
$lang['Savebox_limits'] = 'Max. počet příspěvků ve složce uložené';

$lang['Cookie_settings'] = 'Nastavení cookies';
$lang['Cookie_settings_explain'] = 'Toto detailní nastavení definuje jak budou zasílány cookies ve vašem prohlížeči. Doporučujeme ponechat výchozí hodnoty nastavení cookie, ale je možno změnit hodnoty dle vašich požadavků. Nastavení se projeví po příštím přihlášení.';
$lang['Cookie_domain'] = 'Doména cookie';
$lang['Cookie_name'] = 'Jméno cookie';
$lang['Cookie_path'] = 'Cesta k cookie';
$lang['Cookie_secure'] = 'Zabezpečení cookie';
$lang['Cookie_secure_explain'] = 'Jestliže váš server běží přes SSL, nastavte na povoleno, jesliže ne tak nastavte zakázáno';
$lang['Session_length'] = 'Délka platnosti session (sezení) [ vteřin ]';


// Visual Confirmation
$lang['Visual_confirm'] = 'Vyžadovat vizuální ověření';
$lang['Visual_confirm_explain'] = 'Vyžaduje přepsání kódu, který se zobrazí v obrázku při registraci nového uživatele.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin'] = 'Povolit automatické přihlašování';
$lang['Allow_autologin_explain'] = 'Umožňuje povolit nebo zakázat možnost automatického přihlašovaní na fórum.';
$lang['Autologin_time'] = 'Doba platnosti automatického přihlášení';
$lang['Autologin_time_explain'] = 'Zde můžete nastavit, kolik dní je platný klíč pro automatické přihlášení. Napište nulu pro neomezenou platnost.';

// Search Flood Control - added 2.0.20
$lang['Search_Flood_Interval'] = 'Ochranný interval pro hledání';
$lang['Search_Flood_Interval_explain'] = 'Počet vteřin, po které uživatel musí čekat na další hledání';

//
// Forum Management
//
$lang['Forum_admin'] = 'Administrace fóra';
$lang['Forum_admin_explain'] = 'Z tohoto panelu můžete přidávat, odstraňovat, upravovat, třídit a synchronizovat kategorie a fóra';
$lang['Edit_forum'] = 'Úprava fóra';
$lang['Create_forum'] = 'Vytvořit nové fórum';
$lang['Create_category'] = 'Vytvořit novou kategorii';
$lang['Remove'] = 'Vyjmout';
$lang['Action'] = 'Akce';
$lang['Update_order'] = 'Aktualizovat instrukce';
$lang['Config_updated'] = 'Změna konfigurace fóra byla úspěšně provedena.';
$lang['Edit'] = 'Upravit';
$lang['Delete'] = 'Odstranit';
$lang['Move_up'] = 'přesunout nahoru';
$lang['Move_down'] = 'přesunout dolu';
$lang['Resync'] = 'Synchronizovat';
$lang['No_mode'] = 'Mód nebyl přiřazen';
$lang['Forum_edit_delete_explain'] = 'Níže uvedený formulář vám umožní úpravy obecného nastavení fóra. Pro nastavení uživatelů a fóra používejte odkazy v levé části stránky.';

$lang['Move_contents'] = 'Přesunout veškerý obsah';
$lang['Forum_delete'] = 'Odstranit fórum';
$lang['Forum_delete_explain'] = 'Níže uvedený formulář vám umožní odstranit fóra či kategorie a rozhodnout kam chcete dát všechna témata která jsou v něm obsaženy.';

$lang['Status_locked'] = 'Zamknuto';
$lang['Status_unlocked'] = 'Odemknuto';
$lang['Forum_settings'] = 'Obecné nastavení fóra';
$lang['Forum_name'] = 'Jméno fóra';
$lang['Forum_desc'] = 'Popis';
$lang['Forum_status'] = 'Stav fóra';
$lang['Forum_pruning'] = 'Automatické pročištění';

$lang['prune_freq'] = 'Kontrolovat starší témata každých';
$lang['prune_days'] = 'Odstranit témata, která jsou starší';
$lang['Set_prune_data'] = 'Chcete nastavit povolení automatického pročištění tohoto fóra, ale nemáte nastavenu četnost nebo počet dní. Vraťte se prosím zpět a zadejte požadované hodnoty.';

$lang['Move_and_Delete'] = 'Přesunout a odstranit';

$lang['Delete_all_posts'] = 'Odstranit všechny příspěvky';
$lang['Nowhere_to_move'] = 'Sem to nelze přesunout';

$lang['Edit_Category'] = 'Úprava kategorie';
$lang['Edit_Category_explain'] = 'Použijte tento formulář pro úpravu jména kategorie.';

$lang['Forums_updated'] = 'Fórum a informace o skupině byly aktualizovány.';

$lang['Must_delete_forums'] = 'Musíte odstranit všechna fóra ještě před odstraněním této kategorie.';

$lang['Click_return_forumadmin'] = 'Klikněte %szde%s pro návrat do administrace fóra.';


//
// Smiley Management
//
$lang['smiley_title'] = 'Úprava smajlíků (emotikonů)';
$lang['smile_desc'] = 'Na této stránce můžete přidávat, odebírat a upravovat smajlíky (emotikony), které mohou Vaši uživatelé používat v příspěvcích a soukromých zprávách.';

$lang['smiley_config'] = 'Nastavení smajlíku';
$lang['smiley_code'] = 'Kód smajlíku';
$lang['smiley_url'] = 'Grafický soubor smajlíku';
$lang['smiley_emot'] = 'Výraz smajlíku';
$lang['smile_add'] = 'Přidej nový smajlík';
$lang['Smile'] = 'Smajlík';
$lang['Emotion'] = 'Výraz';

$lang['Select_pak'] = 'Vyberte (.pak) soubor';
$lang['replace_existing'] = 'Nahradit dosavadní smajlík';
$lang['keep_existing'] = 'Zachovat již existující smajlík';
$lang['smiley_import_inst'] = 'Rozbalte kolekci smajlíků a nahrajte všechny soubory do příslušného adresáře smajlíků pro instalaci. Pak vyberte správnou informaci v tomto formuláři k importování kolekce smajlíků.';
$lang['smiley_import'] = 'Import kolekce smajlíků';
$lang['choose_smile_pak'] = 'Vyberte soubor smajlíků (.pak)';
$lang['import'] = 'Importuj smajlíky';
$lang['smile_conflicts'] = 'Co udělat v případě shody již přítomného a nově importovaného smajlíku?';
$lang['del_existing_smileys'] = 'Před importováním smazat dosavadní smajlíky';
$lang['import_smile_pack'] = 'Importovat kolekci smajlíků';
$lang['export_smile_pack'] = 'Vytvořit kolekci smajlíků';
$lang['export_smiles'] = 'Pokud chcete vytvořit kolekci smajlíků z dosud užívaných smajlíků, klikněte %szde%s a stáhněte soubor smiles.pak. Pojmenujte tento příslušný soubor, ale nezapomeňte zachovat příponu (.pak). Pak vytvořte komprimovaný soubor všech vašich smajlíků i s vaším souborem nastavení .pak';

$lang['smiley_add_success'] = 'Smajlík byl úspěšně přidán.';
$lang['smiley_edit_success'] = 'Smajlík byl úspěšně změněn.';
$lang['smiley_import_success'] = 'Soubor smajlíků byl úspěšně importován.';
$lang['smiley_del_success'] = 'Smajlík byl úspěšně odstraněn.';
$lang['Click_return_smileadmin'] = 'Klikněte %szde%s k návratu na administraci smajlíků.';
$lang['Confirm_delete_smiley'] = 'Opravdu chcete odstranit tohoto smajlíka?';

//
// User Management
//
$lang['User_admin'] = 'Uživatelská administrace';
$lang['User_admin_explain'] = 'Zde můžete změnit informaci o uživateli a některá specifická nastavení. K úpravě práv použijte uživatele a skupinový povolovací systém.';

$lang['Look_up_user'] = 'Zvolit uživatele';

$lang['Admin_user_fail'] = 'Nelze změnit nastavení uživatele.';
$lang['Admin_user_updated'] = 'Změna nastavení uživatele proběhla úspěšně.';
$lang['Click_return_useradmin'] = 'Klikněte %szde%s k návratu do Uživatelské administrace.';

$lang['User_delete'] = 'Odstranit tohoto uživatele';
$lang['User_delete_explain'] = 'Zde smažete tohoto uživatele. POZOR Tato akce nelze vrátit zpět!';
$lang['User_deleted'] = 'Uživatel byl úspěšně odstraněn.';

$lang['User_status'] = 'Uživatel je aktivní';
$lang['User_allowpm'] = 'Může posílat soukromé zprávy';
$lang['User_allowavatar'] = 'Může zobrazovat postavičky';

$lang['Admin_avatar_explain'] = 'Zde můžete vidět a odstranit současnou uživatelovu postavičku.';

$lang['User_special'] = 'Zvláštní oblasti administrátorských nastavení';
$lang['User_special_explain'] = 'Tyto oblasti nemůžou být upravovány uživateli. Zde můžete nastavit jejich zařazení a další oblasti, které nejsou uživatelům přiřazeny.';


//
// Group Management
//
$lang['Group_administration'] = 'Skupinová administrace';
$lang['Group_admin_explain'] = 'Z tohoto panelu můžete spravovat všechny uživatelské skupiny, můžete odstranit, vytvořit a změnit současné skupiny. Můžete vybírat moderátory, zamykat otevřené/uzavřené skupiny a nastavovat jméno a popis skupiny';
$lang['Error_updating_groups'] = 'Při nahrávání skupin došlo k chybě!';
$lang['Updated_group'] = 'Skupina byla úspěšně nahrána.';
$lang['Added_new_group'] = 'Nová skupina byla úspěšně vytvořena.';
$lang['Deleted_group'] = 'Skupina byla úspěšně odstraněna.';
$lang['New_group'] = 'Vytvořit novou skupinu';
$lang['Edit_group'] = 'Změnit skupinu';
$lang['group_name'] = 'Jméno skupiny';
$lang['group_description'] = 'Popis skupiny';
$lang['group_moderator'] = 'Moderátor skupiny';
$lang['group_status'] = 'Nastavení skupiny';
$lang['group_open'] = 'Otevřená skupina';
$lang['group_closed'] = 'Uzavřená skupina';
$lang['group_hidden'] = 'Skrytá skupina';
$lang['group_delete'] = 'Odstranit skupinu';
$lang['group_delete_check'] = 'Odstranit tuto skupinu';
$lang['submit_group_changes'] = 'Odeslat změny';
$lang['reset_group_changes'] = 'Obnovit změny';
$lang['No_group_name'] = 'Musíte zadat jméno pro tuto skupinu.';
$lang['No_group_moderator'] = 'Musíte zadat moderátora pro tuto skupinu.';
$lang['No_group_mode'] = 'Musíte zadat nastavení této skupiny, otevřená nebo uzavřená.';
$lang['No_group_action'] = 'Nebyla vybrána žádná akce';
$lang['delete_group_moderator'] = 'Odstranit moderátora původní skupiny?';
$lang['delete_moderator_explain'] = 'Pokud chcete změnit moderátora skupiny, zatrhněte toto políčko k odstranění původního moderátora z této skupiny. V opačném případě se tento uživatel stane běžným členem této skupiny.';
$lang['Click_return_groupsadmin'] = 'Klikněte %szde%s k návratu do Skupinové administrace.';
$lang['Select_group'] = 'Vyberte skupinu';
$lang['Look_up_group'] = 'Vyhledejte skupinu';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'Pročištění fóra';
$lang['Forum_Prune_explain'] = 'Tato funkce odstraní všechna témata, ke kterým nebyly přidány příspěvky za Vámi zadaný počet dní. Pokud nezadáte počet dní, pak budou odstraněna všechna témata. Nebudou odstraněna témata, v nichž běží hlasování a stejně tak se neodstraní oznámení. Tato témata budete muset odstranit ručně.';
$lang['Do_Prune'] = 'Pročistit';
$lang['All_Forums'] = 'Všechna fóra';
$lang['Prune_topics_not_posted'] = 'Pročistit témata bez odpovědi starší';
$lang['Topics_pruned'] = 'Témata pročištěna';
$lang['Posts_pruned'] = 'Příspěvky pročištěny';
$lang['Prune_success'] = 'Pročištění fór proběhlo úspěšně.';


//
// Word censor
//
$lang['Words_title'] = 'Slovní cenzura';
$lang['Words_explain'] = 'Z tohoto kontrolního panelu můžete přidat, změnit a odstranit slova, která budou automaticky cenzurována na vašich fórech. Stejně tak nebude možné zaregistrovat uživatelská jména obsahující tyto výrazy. Hvězdičku (*) lze použít za část slova, takže např. výraz *test* vyhledá výraz \'protestovat\', test* potom \'testovat\' a *test slovo \'protest\'.';
$lang['Word'] = 'Slovo';
$lang['Edit_word_censor'] = 'Změňte slovní cenzuru';
$lang['Replacement'] = 'Náhrada';
$lang['Add_new_word'] = 'Přidejte nové slovo';
$lang['Update_word'] = 'Nahrajte slovní cenzuru';

$lang['Must_enter_word'] = 'Musíte vložit slovo a jeho náhradu';
$lang['No_word_selected'] = 'K úpravě nebylo vybráno žádné slovo';

$lang['Word_updated'] = 'Vybraná slovo bylo úspěšně nahráno do cenzury.';
$lang['Word_added'] = 'Slovo bylo úspěšně přidáno do cenzury.';
$lang['Word_removed'] = 'Cenzurované slovo bylo úspěšně odstraněno.';

$lang['Click_return_wordadmin'] = 'Klikněte %szde%s k návratu do Administrace slovní cenzury.';

$lang['Confirm_delete_word'] = 'Opravdu chcete odstranit toto cenzurované slovo?';

//
// Mass Email
//
$lang['Mass_email_explain'] = 'Odtud můžete zaslat vzkaz jakémukoliv uživateli nebo všem z vybrané skupiny. Stane se tak zasláním e-mailu na zadanou administrátorskou adresu, přičemž uživatelům bude zaslána skrytá kopie. Pokud zasíláte vzkaz větší skupině, prosím, mějte chvilku strpení a nezastavujte akci, když se provádí. Je zcela běžné, že hromadná korespondence trvá delší dobu a budete upozorněni, když se akce dokončí';
$lang['Compose'] = 'Napsat';

$lang['Recipients'] = 'Příjemci';
$lang['All_users'] = 'Všichni uživatelé';

$lang['Email_successfull'] = 'Vaše zpráva byla odeslána';
$lang['Click_return_massemail'] = 'Klikněte %szde%s k návratu na formulář Hromadné korespondence.';


//
// Ranks admin
//
$lang['Ranks_title'] = 'Administrace hodnocení';
$lang['Ranks_explain'] = 'Tímto formulářem přidáváte, měníte, prohlížíte a mažete hodnocení. Můžete rovněž vytvořit vlastní nastavení hodnocení, která mohou být přiřazena přes funkci nastavení uživatele.';

$lang['Add_new_rank'] = 'Přidat nové hodnocení';

$lang['Rank_title'] = 'Název hodnocení';
$lang['Rank_special'] = 'Nastavit jako zvláštní hodnocení';
$lang['Rank_minimum'] = 'Minimální počet příspěvků';
$lang['Rank_maximum'] = 'Maximální počet příspěvků';
$lang['Rank_image'] = 'Obrázek hodnocení';
$lang['Rank_image_explain'] = 'Použijte tuto funkci k definování malého obrázku spojeného s daným hodnocením. Cesta mimo váš phpBB kořenový adresář a název souboru, např.: images/ranks/image1.png';

$lang['Must_select_rank'] = 'Musíte vybrat hodnocení';
$lang['No_assigned_rank'] = 'Nebylo zadáno žádné zvláštní hodnocení';

$lang['Rank_updated'] = 'Hodnocení bylo úspěšně změněno.';
$lang['Rank_added'] = 'Hodnocení bylo úspěšně přidáno.';
$lang['Rank_removed'] = 'Hodnocení bylo úspěšně zrušeno.';
$lang['No_update_ranks'] = 'Hodnocení byla úspěšně odstraněno, ovšem uživatelské účty s tímto hodnocením se nezměnily. Bude zapotřebí tato hodnocení upravit ručně.';

$lang['Click_return_rankadmin'] = 'Klikněte %szde%s pro návrat do Administrace hodnocení.';

$lang['Confirm_delete_rank'] = 'Opravdu chcete odstranit toto hodnocení?';

//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'Správa nepovolených uživatelských jmen';
$lang['Disallow_explain'] = 'Zde můžete spravovat uživatelská jména, která nebudou povolena k použití.  Nepovolená uživatelská jména mohou obsahovat \*\.  Upozorňujeme, že nebudete moci určit již registrované uživatelské jméno. Nejdříve ho musíte odstranit a následně jej nepovolit.';

$lang['Delete_disallow'] = 'Odstranit';
$lang['Delete_disallow_title'] = 'Odstranit nepovolené uživatelské jméno';
$lang['Delete_disallow_explain'] = 'Můžete odstranit nepovolené uživatelské jméno tak, že jej vyberete ze seznamu a zmáčknete tlačítko Odstranit.';

$lang['Add_disallow'] = 'Přidat';
$lang['Add_disallow_title'] = 'Přidat nepovolené uživatelské jméno';
$lang['Add_disallow_explain'] = 'Můžete zakázat některá nepovolená uživatelská jména. Tato jména si nebude moci žádný uživatel zaregistrovat. Můžete použít i znak "*" pro nahrazení části jména';

$lang['No_disallowed'] = 'Žádná nepovolená uživatelská jména';

$lang['Disallowed_deleted'] = 'Nepovolené uživatelské jméno bylo úspěšně odstraněno.';
$lang['Disallow_successful'] = 'Nepovolené uživatelské jméno bylo úspěšně přidáno.';
$lang['Disallowed_already'] = 'Jméno, které jste zadali, nemůže být zakázáno. Buď se již vyskytuje v tomto seznamu nebo v seznamu cenzurovaných slov, nebo existuje totožné uživatelské jméno.';

$lang['Click_return_disallowadmin'] = 'Klikněte %szde%s pro návrat do Administrace nastavení nepovolených uživatelských jmen.';


//
// Styles Admin
//
$lang['Styles_admin'] = 'Administrace stylů';
$lang['Styles_explain'] = 'Zde můžete přidávat, odebírat a spravovat styly (vzory a motivy) dostupné pro vaše uživatele';
$lang['Styles_addnew_explain'] = 'Tento seznam obsahuje všechny motivy, které jsou dostupné pro vzory, které nyní máte. Části na tomto seznamu ještě nebyly nainstalovány do odpovídající databáze phpBB. Pro nainstalování klikněte na instalační odkaz vedle zadání';

$lang['Select_template'] = 'Vybrat vzor';

$lang['Style'] = 'Styl';
$lang['Template'] = 'Vzor';
$lang['Install'] = 'Nainstalovat';
$lang['Download'] = 'Stáhnout';

$lang['Edit_theme'] = 'Upravit motiv';
$lang['Edit_theme_explain'] = 'Ve spodním formuláři můžete upravovat nastavení pro zvolený vzor';

$lang['Create_theme'] = 'Vytvořit motiv';
$lang['Create_theme_explain'] = 'Ve spodním formuláři můžete vytvořit nový motiv. Při zadávání barev (pro které použijete hexadecimální hodnoty) neuvádějte znak #, tzn. hodnota CCCCCC je platná, #CCCCCC nikoliv';

$lang['Export_themes'] = 'Exportovat motivy';
$lang['Export_explain'] = 'V tomto panelu můžete exportovat zadání motivu pro zvolený vzor. Vyberte vzor ze spodního výběru a skript vytvoří konfigurační soubor motiv a bude jej chtít uložit do vybraného adresáře vzorů. Pokud se mu to nepodaří, nabídne vám možnost soubor stáhnout na disk. Aby se mohl soubor uložit, je nutné, aby byl povolen přístup pro zápis do příslušného adresáře. Pro více informací se podívejte na uživatelský manuál k phpBB 2.';

$lang['Theme_installed'] = 'Vybraný motiv byl úspěšně nainstalován.';
$lang['Style_removed'] = 'Vybraný styl byl odstraněn z databáze. K plnému odstranění tohoto stylu ze systému musíte odstranit příslušný styl z adresáře vzorů.';
$lang['Theme_info_saved'] = 'Informace ke zvolenému vzoru byly uloženy. Teď nastavte povolení na theme_info.cfg (a také vybraného adresáři vzorů) na \'jen ke čtení\'.';
$lang['Theme_updated'] = 'Vybraný motiv byl změněn. Vyexportujte nyní nastavení nového motivu.';
$lang['Theme_created'] = 'Motiv vytvořen. Vyexportujte nyní nový motiv do konfiguračního souboru kvůli bezpečnému uložení nebo použití pro jiné případy.';

$lang['Confirm_delete_style'] = 'Jste si jisti, že chcete odstranit tento styl?';

$lang['Download_theme_cfg'] = 'Nelze zapsat informaci do konfiguračního souboru. Klikněte na spodní tlačítko ke stažení souboru vaším prohlížečem. Až jej stáhnete, můžete jej přesunout do adresáře obsahujícího soubory vzorů. Pak můžete zabalit soubory pro distribuci nebo použít jinde, pakliže chcete.';
$lang['No_themes'] = 'Ke vzoru, který jste vybrali, se nevážou žádné motivy. Nový motiv vytvoříte kliknutím na \'Vytvořit nové\' na levé straně panelu.';
$lang['No_template_dir'] = 'Nelze otevřít adresář se vzory. Možná, že nemáte právo pro čtení nebo adresář neexistuje.';
$lang['Cannot_remove_style'] = 'Nelze odstranit vybraný styl, je-li stanoven jako výchozí. Změňte, prosím, původní styl a zkuste to znovu.';
$lang['Style_exists'] = 'Jméno stylu již existuje. Prosím vraťte se a zvolte jiné jméno.';

$lang['Click_return_styleadmin'] = 'Klikněte %szde%s k návratu do Administrace stylů.';

$lang['Theme_settings'] = 'Nastavení motivu';
$lang['Theme_element'] = 'Součást vzoru';
$lang['Simple_name'] = 'Jednoduchý název';
$lang['Value'] = 'Hodnota';
$lang['Save_Settings'] = 'Ulož nastavení';

$lang['Stylesheet'] = 'CSS styl';
$lang['Stylesheet_explain'] = 'Název CSS souboru používaného tímto stylem.';

$lang['Background_image'] = 'Obrázek pozadí';
$lang['Background_color'] = 'Barva pozadí';
$lang['Theme_name'] = 'Jméno motivu';
$lang['Link_color'] = 'Barva odkazu';
$lang['Text_color'] = 'Barva textu';
$lang['VLink_color'] = 'Barva navštíveného odkazu';
$lang['ALink_color'] = 'Barva odkazu';
$lang['HLink_color'] = 'Barva aktivního odkazu';
$lang['Tr_color1'] = 'Barva řádku tabulky 1';
$lang['Tr_color2'] = 'Barva řádku tabulky 2';
$lang['Tr_color3'] = 'Barva řádku tabulky 3';
$lang['Tr_class1'] = 'Třída řádku tabulky 1';
$lang['Tr_class2'] = 'Třída řádku tabulky 2';
$lang['Tr_class3'] = 'Třída řádku tabulky 3';
$lang['Th_color1'] = 'Barva titulu tabulky 1';
$lang['Th_color2'] = 'Barva titulu tabulky 2';
$lang['Th_color3'] = 'Barva titulu tabulky 3';
$lang['Th_class1'] = 'Table Header Class 1';
$lang['Th_class2'] = 'Table Header Class 2';
$lang['Th_class3'] = 'Table Header Class 3';
$lang['Td_color1'] = 'Barva buňky tabulky 1';
$lang['Td_color2'] = 'Barva buňky tabulky 2';
$lang['Td_color3'] = 'Barva buňky tabulky 3';
$lang['Td_class1'] = 'Třída buňky tabulky 1';
$lang['Td_class2'] = 'Třída buňky tabulky 2';
$lang['Td_class3'] = 'Třída buňky tabulky 3';
$lang['fontface1'] = 'Vzhled písma 1';
$lang['fontface2'] = 'Vzhled písma 2';
$lang['fontface3'] = 'Vzhled písma 3';
$lang['fontsize1'] = 'Velikost písma 1';
$lang['fontsize2'] = 'Velikost písma 2';
$lang['fontsize3'] = 'Velikost písma 3';
$lang['fontcolor1'] = 'Barva písma 1';
$lang['fontcolor2'] = 'Barva písma 2';
$lang['fontcolor3'] = 'Barva písma 3';
$lang['span_class1'] = 'Třída SPAN 1';
$lang['span_class2'] = 'Třída SPAN 2';
$lang['span_class3'] = 'Třída SPAN 3';
$lang['img_poll_size'] = 'Velikost obrázku pro hlasování [v pixelech]';
$lang['img_pm_size'] = 'Velikost obrázku pro soukromou zprávu [v pixelech]';


//
// Install Process
//
$lang['Welcome_install'] = 'Vítejte v instalaci phpBB 2';
$lang['Initial_config'] = 'Základní nastavení';
$lang['DB_config'] = 'Nastavení databáze';
$lang['Admin_config'] = 'Administrátorské nastavení';
$lang['continue_upgrade'] = 'Poté, co jste si stáhli konfigurační soubor na váš disk můžete spodním tlačítkem \'Pokračovat v instalaci novější verze\'. Počkejte s nahráním konfiguračního souboru dokud není ukončena instalace novější verze.';
$lang['upgrade_submit'] = 'Pokračujte v instalování novější verze';

$lang['Installer_Error'] = 'Během instalace se objevila chyba!';
$lang['Previous_Install'] = 'Byla nalezena předešlá instalace.';
$lang['Install_db_error'] = 'Během nahrávání novější instalace databáze se objevila chyba.';

$lang['Re_install'] = 'Vaše předešlá instalace je stále aktivní.<br /><br />Pokud si přejete přeinstalovat phpBB 2, pokračujte tlačítkem \'Ano\'. Uvědomte si, prosím, že v tomto případě se zničí veškerá data; nedojde k zálohování. Administrátorské uživatelské jméno a heslo, které jste používali k přihlašování budou po reinstalaci přepsány novými, žádná další nastavení nebudou zachována.<br /><br />Zamyslete se pozorně před zmáčknutím tlačítka \'Ano\'!';

$lang['Inst_Step_0'] = 'Děkujeme Vám, že jste si zvolili phpBB 2 fórum. Pro úspěšnou instalaci vyplňte všechny požadované položky. Databáze, do které chcete fórum instalovat, musí existovat. Jestliže používáte databázi přes ODBC ovladače, vytvořte nejprve DSN záznam.';

$lang['Start_Install'] = 'Začít instalaci';
$lang['Finish_Install'] = 'Dokončit instalaci';

$lang['Default_lang'] = 'Výchozí jazyk boardu';
$lang['DB_Host'] = 'Adresa databázového serveru / DSN';
$lang['DB_Name'] = 'Název vaší databáze';
$lang['DB_Username'] = 'Uživatelské jméno databáze';
$lang['DB_Password'] = 'Heslo databáze';
$lang['Database'] = 'Vaše databáze';
$lang['Install_lang'] = 'Vyberte jazyk pro instalaci';
$lang['dbms'] = 'Typ databáze';
$lang['Table_Prefix'] = 'Předpona pro tabulky v databázi';
$lang['Admin_Username'] = 'Administrátorské uživ. jméno';
$lang['Admin_Password'] = 'Administrátorské heslo';
$lang['Admin_Password_confirm'] = 'Administrátorské heslo [ Potvrdit ]';

$lang['Inst_Step_2'] = 'Vaše uživatelské jméno bylo vytvořeno. V této chvíli je základní instalace u konce. Nyní budete přeneseni na další část, která vám umožní další správu nové instalace. Zkontrolujte, prosím, detaily Obecných preferencí a udělejte nezbytné změny. Děkujeme, že jste si vybrali phpBB 2.';

$lang['Unwriteable_config'] = 'Na váš konfigurační soubor nelze nyní zapisovat. Kopie tohoto souboru bude stažena, když kliknete tlačítko dole. Posléze nahrajte tento soubor do adresáře phpBB 2. Poté se přihlašte jako administrátor s heslem, které jste zadali v předchozím formuláři a navštivte administrátorské centrum (odkaz se objeví ve spodní části každé stránky poté, co se přihlásíte) a zkontrolujte obecnou konfiguraci. Děkujeme, že jste si vybrali phpBB 2.';
$lang['Download_config'] = 'Stáhnout konfigurační soubor';

$lang['ftp_choose'] = 'Vyberte si způsob stáhnutí';
$lang['ftp_option'] = '<br />Vzhledem k tomu, že je v této verzi umožněn rozšířený přenos php, může vám být dán prostor nejdříve přenést váš konfigurační soubor automaticky.';
$lang['ftp_instructs'] = 'Vybrali jste automatickou volbu přenosu. Zadejte, prosím, informace k uskutečnění tohoto procesu. Prosím, pamatujte na to, že cesta přenosu má být přesně taková, jakou byste zadávali cestu přes jakéhokoliv běžného klienta.';
$lang['ftp_info'] = 'Zadejte vaše informace přenosu FTP';
$lang['Attempt_ftp'] = 'Pokus o přenos konfiguračního souboru na místo';
$lang['Send_file'] = 'Pošlete mi soubor a já jej přenesu sám';
$lang['ftp_path'] = 'Cesta FTP na phpBB';
$lang['ftp_username'] = 'Vaše uživatelské jméno FTP';
$lang['ftp_password'] = 'Vaše heslo FTP';
$lang['Transfer_config'] = 'Začít přenos';
$lang['NoFTP_config'] = 'Pokus přenést soubor na místo selhal. Prosím, stáhněte a pak nahrajte konfigurační soubor sami.';

$lang['Install'] = 'Instalovat';
$lang['Upgrade'] = 'Inovovat verzi';

$lang['Install_Method'] = 'Vyberte druh instalace';

$lang['Install_No_Ext'] = 'Nastavení php na vašem serveru nepodporuje databázi, kterou jste zvolili';

$lang['Install_No_PCRE'] = 'phpBB2 požaduje the Perl-Compatible Regular Expressions Module pro php, což vaše konfigurace php zřejmě nepodporuje!';


//
// Version Check
//
$lang['Version_up_to_date'] = 'Vaše instalace je aktuální, nejsou dostupné žádné aktualizace pro tuto verzi phpBB.';
$lang['Version_not_up_to_date'] = 'Vaše instalace <b>není</b> aktuální. Aktualizace pro tuto verzi phpBB je dostupná na stránkách <a href="http://www.phpbb.com/downloads.php" target="_blank">http://www.phpbb.com/downloads.php</a>.';
$lang['Latest_version_info'] = 'Poslední dostupná verze <b>phpBB je %s</b>.';
$lang['Current_version_info'] = 'Používáte <b>phpBB %s</b>.';
$lang['Connect_socket_error'] = 'Není možné navázat spojení s phpBB serverem, chybová hláška je:<br />%s';
$lang['Socket_functions_disabled'] = 'Není možno použít funkci socket.';
$lang['Mailing_list_subscribe_reminder'] = 'Pro nejnovější informace o aktualizacích phpBB je možno se přihlásit pro <a href="http://www.phpbb.com/support/" target="_blank">zásílání novinek na váš e-mail</a>.';
$lang['Version_information'] = 'Informace o verzi';


//
// Login attempts configuration
//
$lang['Max_login_attempts'] = 'Pokusů pro přihlášení';
$lang['Max_login_attempts_explain'] = 'Maximální počet pokusů pro přihlášení na fórum.';
$lang['Login_reset_time'] = 'Doba trvání zákazu přihlášení';
$lang['Login_reset_time_explain'] = 'Počet minut po které bude trvat zákaz přihlášení v případě překročení maximálního počtu pokusů o přihlášení na fórum.';

//
// That's all Folks!
// -------------------------------------------------
?>
