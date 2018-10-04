<?php
/** 
*
* lang_admin [Turkish]
*
* @package language
* @version $Id: lang_admin.php,v 1.2 2007/03/23 21:22:22 angelside Exp $
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/


//
// Format is same as lang_main
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//


$lang['General']        = 'Genel Yönetim';
$lang['Users']          = 'Kullanýcý Yönetimi';
$lang['Groups']         = 'Grup Yönetimi';
$lang['Forums']         = 'Forum Yönetimi';
$lang['Styles']         = 'Tema Yönetimi';

$lang['Configuration']  = 'Ayarlar';
$lang['Permissions']    = 'Ýzinler';
$lang['Manage']         = 'Yönetim';
$lang['Disallow']       = 'Yasaklý Ýsimler';
$lang['Prune']          = 'Eski Ýletileri Sil';
$lang['Mass_Email']     = 'Kullanýcýlara E-Posta';
$lang['Ranks']          = 'Kullanýcý Seviyeleri';
$lang['Smilies']        = 'Ýfadeler';
$lang['Ban_Management'] = 'Yasaklý Yönetimi';
$lang['Word_Censor']    = 'Sansürlü Kelimeler';
$lang['Export']         = 'Kaydet';
$lang['Create_new']     = 'Oluþtur';
$lang['Add_new']        = 'Ekle';
$lang['Backup_DB']      = 'Veritabanýný Yedekle';
$lang['Restore_DB']     = 'Veritabanýný Yükle';


//
// Index
//
$lang['Admin']            = 'Yönetim';
$lang['Not_admin']        = 'Bu sitenin yöneticiliðini yapma yetkiniz yok';
$lang['Welcome_phpBB']    = 'phpBB\'ye hoþgeldiniz';
$lang['Admin_intro']      = 'PhpBB2\'yi panonuz olarak seçtiðiniz için teþekkür ederiz. Bu ekran size sitenizin bilgilerinin kýsa bir özetini sunmaktadýr. Bu sayfaya soldaki <u>Yönetim - Ana Sayfa</u> linkine basarak geri dönebilirsiniz. Sitenizin ana sayfasýna dönmek için soldaki küçük logoyu kullanabilirsiniz. Soldaki diðer linkler forumunuzun her türlü ayarýný yapmanýzý saðlayacaktýr, her ekran kendinin nasýl kullanýlacaðýný anlatacaktýr.';
$lang['Main_index']       = 'Ana Sayfa';
$lang['Forum_stats']      = 'Pano Ýstatistikleri';
$lang['Admin_Index']      = 'Yönetim - Ana Sayfa';
$lang['Preview_forum']    = 'Pano Önizlemesi';

$lang['Click_return_admin_index'] = 'Yönetim ana sayfasýna dönmek için %sburaya%s týklayýn';

$lang['Statistic']        = 'Ýstatistik';
$lang['Value']            = 'Deðer';
$lang['Number_posts']     = 'Ýleti sayýsý';
$lang['Posts_per_day']    = 'Günlük ortalama ileti';
$lang['Number_topics']    = 'Konu sayýsý';
$lang['Topics_per_day']   = 'Günlük ortalama konu';
$lang['Number_users']     = 'Üye sayýsý';
$lang['Users_per_day']    = 'Günlük ortalama üye';
$lang['Board_started']    = 'Pano açýlýþ tarihi';
$lang['Avatar_dir_size']  = 'Kiþisel sembol dizini büyüklüðü';
$lang['Database_size']    = 'Veritabaný büyüklüðü';
$lang['Gzip_compression'] = 'Gzip sýkýþtýrma';
$lang['Not_available']    = 'Mevcut deðil';

$lang['ON']               = 'Açýk';
$lang['OFF']              = 'Kapalý';


//
// DB Utils
//
$lang['Database_Utilities']       = 'Veritabaný Ýþlemleri';

$lang['Restore']                  = 'Geri Yükleme';
$lang['Backup']                   = 'Yedekleme';
$lang['Restore_explain']          = 'Bu iþlem bir dosyadan tüm phpBB veritabaný tablolarýný <B>geri yükleyecektir</B>. Eðer sunucunuz izin veriyorsa gzip ile sýkýþtýrýlmýþ bir text dosyasý yükleyebilirsiniz, otomatik olarak açýlacaktýr. <b>UYARI:</b> Bu iþlem bütün bulunan verileri silecek yerine yenilerini yazacaktýr. Geri yükleme uzun sürebilir, tamamlanana kadar lütfen bu sayfayý kapatmayýnýz.';
$lang['Backup_explain']           = 'Buradan tüm phpBB verilerinizi yedekleyebilirsiniz. Eðer ayný veritabanýnda saklamak istediðiniz baþka tablolarýnýz da varsa, aþaðýdaki Ek Tablolar bölümüne isimlerini virgülle ayýrarak giriniz. Eðer sunucunuz izin veriyorsa backup dosyanýzý gzip ile sýkýþtýrýp da alabilirsiniz.';

$lang['Backup_options']           = 'Yedekleme seçenekleri';
$lang['Start_backup']             = 'Yedeklemeyi baþlat';
$lang['Full_backup']              = 'Tam yedekleme';
$lang['Structure_backup']         = 'Sadece tablo yapýsý';
$lang['Data_backup']              = 'Sadece veriler';
$lang['Additional_tables']        = 'Ek tablolar';
$lang['Gzip_compress']            = 'Gzip sýkýþtýrma';
$lang['Select_file']              = 'Bir dosya seçin';
$lang['Start_Restore']            = 'Geri yüklemeyi baþlat';

$lang['Restore_success']          = 'Veritabaný baþarýyla yedeklendi.<br /><br />Siteniz yedeklemenin yapýldýðý zamanki haline dönüþtürüldü.';
$lang['Backup_download']          = 'Ýndirme kýsa bir süre içinde baþlayacak, lütfen bekleyiniz';
$lang['Backups_not_supported']    = 'Kullandýðýnýz veritabaný sistemin henüz yedekleme desteklenmiyor';

$lang['Restore_Error_uploading']  = 'Yedekleme dosyasýný gönderirken hata';
$lang['Restore_Error_filename']   = 'Dosya isminde problem oluþtu, lütfen alternatif bir dosya deneyin';
$lang['Restore_Error_decompress'] = 'Gzip sýkýþtýrmasý açýlamýyor, lütfen düzyazý sürümünü gönderin';
$lang['Restore_Error_no_file']    = 'Dosya gönderilmedi';


//
// Auth pages
//
$lang['Select_a_User']             = 'Bir kullanýcý seç';
$lang['Select_a_Group']            = 'Bir grup seç';
$lang['Select_a_Forum']            = 'Bir forum seç';
$lang['Auth_Control_User']         = 'Kullanýcý Ýzinleri Kontrolü';
$lang['Auth_Control_Group']        = 'Grup Ýzinleri Kontrolü';
$lang['Auth_Control_Forum']        = 'Forum Ýzinleri Kontrolü';
$lang['Look_up_User']              = 'Ayrýntýlar';
$lang['Look_up_Group']             = 'Ayrýntýlar';
$lang['Look_up_Forum']             = 'Ayrýntýlar';

$lang['Group_auth_explain']        = 'Burada her gruba verilmiþ olan izinleri ve bölüm yetkilisi durumlarýný deðiþtirebilirsiniz. Grup izinlerini deðiþtirirken kullanýcý izinlerinin gruptaki bazý kullanýcýlara hala bazý özel haklar tanýyabileceðini unutmayýn. Eðer böyle bir durum söz konusuysa uyarýlacaksýnýz.';
$lang['User_auth_explain']         = 'Burada her kullanýcýya verilmiþ olan izinleri ve bölüm yetkilisi durumlarýný deðiþtirebilirsiniz. Kullanýcý izinlerini deðiþtirirken grup izinlerinin bazý kullanýcýlara hala bazý özel haklar tanýyabileceðini unutmayýn. Eðer böyle bir durum söz konusuysa uyarýlacaksýnýz.';
$lang['Forum_auth_explain']        = 'Buradan her forumun izin derecesini deðiþtirebilirsiniz. Geliþmiþ ve Basit olaraka ikiye ayrýlmýþ olan izinlerde, geliþmiþ seçeneðini kullanarak daha özel izinler verebileceðinizi unutmayýnýz.';

$lang['Simple_mode']               = 'Basit Mod';
$lang['Advanced_mode']             = 'Geliþmiþ Mod';
$lang['Moderator_status']          = 'Bölüm yetkilisi durumu';

$lang['Allowed_Access']            = 'Eriþim izni verilmiþ';
$lang['Disallowed_Access']         = 'Eriþim izni verilmemiþ';
$lang['Is_Moderator']              = 'Bölüm yetkilisi';
$lang['Not_Moderator']             = 'Bölüm yetkilisi deðil';

$lang['Conflict_warning']          = 'Yetki Çeliþkisi Uyarýsý';
$lang['Conflict_access_userauth']  = 'Bu kullanýcýnýn üye olduðu grup aracýlýðý ile bu foruma eriþimi var. Grup izinleriyle oynayabilir ya da kullanýcýyý gruptan çýkartabilirsiniz. Bu durumu oluþturan gruplar ve forumlar aþaðýda listelenmiþtir.';
$lang['Conflict_mod_userauth']     = 'Bu kullanýcýnýn üye olduðu grup aracýlýðý ile bu foruma yönetici eriþimi var. Grup izinleriyle oynayabilir ya da kullanýcýyý gruptan çýkartabilirsiniz. Bu durumu oluþturan gruplar ve forumlar aþaðýda listelenmiþtir.';

$lang['Conflict_access_groupauth'] = 'Aþaðýdaki kullanýcýlarýn hala kullanýcý izinleriyle bu foruma eriþimleri var. Kullanýcý izinlerini deðiþtirebilirsiniz. Özel hakký olan kullanýcýlar ve forumlar aþaðýda listelenmiþtir.';
$lang['Conflict_mod_groupauth']    = 'Aþaðýdaki kullanýcýlarýn hala kullanýcý izinleriyle bu foruma yönetici eriþimleri var. Kullanýcý izinlerini deðiþtirebilirsiniz. Özel hakký olan kullanýcýlar ve forumlar aþaðýda listelenmiþtir.';

$lang['Public']                    = 'Herkese Açýk';
$lang['Private']                   = 'Özel';
$lang['Registered']                = 'Kayýtlýlara Açýk';
$lang['Administrators']            = 'Pano Yöneticilerine Açýk';
$lang['Hidden']                    = 'Gizli';


// These are displayed in the drop down boxes for advanced 
// mode forum auth, try and keep them short!
$lang['Forum_ALL']              = 'Herkes';
$lang['Forum_REG']              = 'Kayýtlý';
$lang['Forum_PRIVATE']          = 'Özel';
$lang['Forum_MOD']              = 'Bölüm Yetkilisi';
$lang['Forum_ADMIN']            = 'Pano Yöneticisi';

$lang['View']                   = 'Görüntüleme';
$lang['Read']                   = 'Okuma';
$lang['Post']                   = 'Gönderme';
$lang['Reply']                  = 'Cevap yazma';
$lang['Edit']                   = 'Deðiþtirme';
$lang['Delete']                 = 'Silme';
$lang['Sticky']                 = 'Önemli';
$lang['Announce']               = 'Duyuru';
$lang['Vote']                   = 'Oy kullanma';
$lang['Pollcreate']             = 'Anket yaratma';

$lang['Permissions']            = 'Ýzinler';
$lang['Simple_Permission']      = 'Basit Mod';

$lang['User_Level']             = 'Kullanýcý seviyesi';
$lang['Auth_User']              = 'Kullanýcý';
$lang['Auth_Admin']             = 'Pano Yöneticisi';
$lang['Group_memberships']      = 'Grup üyelikleri';
$lang['Usergroup_members']      = 'Bu grubun üyeleri';

$lang['Forum_auth_updated']     = 'Forum izinleri güncellendi';
$lang['User_auth_updated']      = 'Kullanýcý izinleri güncellendi';
$lang['Group_auth_updated']     = 'Grup izinleri güncellendi';

$lang['Auth_updated']           = 'Ýzinler güncellendi';
$lang['Click_return_userauth']  = 'Kullanýcý izinlerine dönmek için %sburaya%s týklayýn';
$lang['Click_return_groupauth'] = 'Grup izinlerine dönmek için %sburaya%s týklayýn';
$lang['Click_return_forumauth'] = 'Forum izinlerine dönmek için %sburaya%s týklayýn';


//
// Banning
//
$lang['Ban_control']            = 'Yasaklý Kontrolü';
$lang['Ban_explain']            = 'Buradan kullanýcýlarý yasaklama ayarlarýný yapabilirsiniz. Bunu kullanýcý adýný, IP adresini ya da sunucu adýný banlayarak yapabilirsiniz. Bu, o kullanýcýnýn anasayfaya bile eriþimini engelleyecektir. Bir kullanýcýnýn baþka bir kullanýcý adýyla kaydolmasýný engellemek için o e-posta adresini yasaklayabilirsiniz. Unutmayýn ki bir e-posta adresini yasaklamak o kullanýcýnýn anasayfaya girmesini ya da ileti gondermesini engellemez. Bunun için kullanýcý adý ya da IP - sunucu yasaklamalýsýnýz.';
$lang['Ban_explain_warn']       = 'Bir IP dizisinin yasaklanmasý baþlangýç ve bitiþ IP\'leri arasýndaki tüm IP\'leri yasaklayacaktýr. Veritabanýnda yer kaplamamasý için uygun olduðu yerlerde joker kullanýlacaktýr. Eðer gerçekten bir IP dizisi girmek istiyorsanýz lütfen onu kýsa tutun ya da tek tek IP\'leri girin.';

$lang['Select_username']        = 'Kullanýcý adý seçin';
$lang['Select_ip']              = 'IP seçin';
$lang['Select_email']           = 'E-posta adresi seçin';

$lang['Ban_username']           = 'Kullanýcý yasaklama';
$lang['Ban_username_explain']   = 'Birden fazla kullanýcý yasaklamak istiyorsanýz web tarayýcýnýza uygun klavye-fare kombinasyonunu kullanýn.';

$lang['Ban_IP']                 = 'IP ve Sunucu yasaklama';
$lang['IP_hostname']            = 'IP ve sunucu adresleri';
$lang['Ban_IP_explain']         = 'Birden fazla IP/sunucu yasaklamak için araya virgül koyun. Bir IP dizisi belirtmek için baþlangýç ve bitiþ arasýna - koyun. Joker olarak * kullanýn';

$lang['Ban_email']              = 'E-posta yasaklama';
$lang['Ban_email_explain']      = 'Birden fazla e-posta yasaklamak için virgül kullanýn. Joker olarak * kullanýn, mesela *@hotmail.com';

$lang['Unban_username']         = 'Bir veya daha fazla kullanýcý baný kaldýrma';
$lang['Unban_username_explain'] = 'Birden fazla kullanýcýnýn yasaðýný kaldýrmak istiyorsanýz web tarayýcýnýza uygun klavye-fare kombinasyonunu kullanýn';

$lang['Unban_IP']               = 'IP/sunucu yasaðý kaldýrma';
$lang['Unban_IP_explain']       = 'Birden fazla IP/sunucu yasaðýný kaldýrmak istiyorsanýz web tarayýcýnýza uygun klavye-fare kombinasyonunu kullanýn';

$lang['Unban_email']            = 'E-posta yasaðý kaldýrma';
$lang['Unban_email_explain']    = 'Birden fazla e-posta yasaðýný kaldýrmak istiyorsanýz web tarayýcýnýza uygun klavye-fare kombinasyonunu kullanýn';

$lang['No_banned_users']        = 'Yasaklý kullanýcý yok';
$lang['No_banned_ip']           = 'Yasaklý IP yok';
$lang['No_banned_email']        = 'Yasaklý e-posta yok';

$lang['Ban_update_sucessful']   = 'Yasak listesi baþarýyla güncellendi';
$lang['Click_return_banadmin']  = 'Yasak kontrolüne dönmek için %sburaya%s týklayýn';


//
// Configuration
//
$lang['General_Config']           = 'Genel Ayarlar';
$lang['Config_explain']           = 'Aþaðýdaki form sitenizdeki genel ayarlarý yapmak için kullanýlacaktýr. Kullanýcý ve forum bazlý ayarlar için sol taraftaki ilgili linklere týklayýnýz.';

$lang['Click_return_config']      = 'Genel ayarlara dönmek için %sburaya%s týklayýn';

$lang['General_settings']         = 'Genel Pano Ayarlarý';
$lang['Server_name']              = 'Alan adý';
$lang['Server_name_explain']      = 'Bu panonun olduðu sitenin alan adý';
$lang['Script_path']              = 'Yazýlým yolu'; 
$lang['Script_path_explain']      = 'Alan adýna göre phpBB yazýlýmýnýn bulunduðu yol';
$lang['Server_port']              = 'Sunucu portu';
$lang['Server_port_explain']      = 'Sunucunuzun çalýþtýðý port, genelde 80\'dir, sadece farklýysa deðiþtirin';
$lang['Site_name']                = 'Pano ismi';
$lang['Site_desc']                = 'Pano açýklamasý';
$lang['Board_disable']            = 'Panoyu kapat';
$lang['Board_disable_explain']    = 'Bu panoyu kullanýcýlara kapayacaktýr.';
$lang['Acct_activation']          = 'Hesap etkinleþtirme';
$lang['Acc_None']                 = 'Kapalý';
$lang['Acc_User']                 = 'Kullanýcý';
$lang['Acc_Admin']                = 'Pano Yöneticisi';

$lang['Abilities_settings']       = 'Kullanýcý ve Forum Genel Ayarlarý';
$lang['Max_poll_options']         = 'Maksimum anket seçeneði sayýsý';
$lang['Flood_Interval']           = 'Flood aralýðý';
$lang['Flood_Interval_explain']   = 'Kullanýcýnýn iki ileti arasýnda beklemesi gereken süre [ saniye ]';
$lang['Board_email_form']         = 'Kullanýcýlar arasý e-posta';
$lang['Board_email_form_explain'] = 'Bu site aracýlýðý ile kullanýcýlarýn birbirlerine e-posta göndermesini saðlar';
$lang['Topics_per_page']          = 'Her sayfadaki konu sayýsý';
$lang['Posts_per_page']           = 'Her sayfadaki ileti sayýsý';
$lang['Hot_threshold']            = 'Popülerlik sýnýrý';
$lang['Default_style']            = 'Varsayýlan tema';
$lang['Override_style']           = 'Kullanýcý temasýný gözardý et';
$lang['Override_style_explain']   = 'Kullanýcýlarýn seçtiði stili varsayýlan ile deðiþtirir';
$lang['Default_language']         = 'Varsayýlan dil';
$lang['Date_format']              = 'Saat formatý';
$lang['System_timezone']          = 'Sistem zaman dilimi';
$lang['Enable_gzip']              = 'GZip sýkýþtýrma';
$lang['Enable_prune']             = 'Ýleti temizliði';
$lang['Allow_HTML']               = 'HTML\'e izin ver';
$lang['Allow_BBCode']             = 'Biçimlendirmeye (BBCode) izin ver';
$lang['Allowed_tags']             = 'Ýzin verilen HTML etiketleri';
$lang['Allowed_tags_explain']     = 'Etiketleri virgüllerle ayýrýn';
$lang['Allow_smilies']            = 'Ýfadelere izin ver';
$lang['Smilies_path']             = 'Ýfade dizini';
$lang['Smilies_path_explain']     = 'phpBB ana dizinine göre ifadeler dizini, örn: images/smilies';
$lang['Allow_sig']                = 'Ýmzaya izin ver';
$lang['Max_sig_length']           = 'Maksimum imza uzunluðu';
$lang['Max_sig_length_explain']   = 'Kullanýcý imzalarýndaki maksimum karakter sayýsý';
$lang['Allow_name_change']        = 'Kullanýcý adý deðiþikliðine izin ver';

// Avatar ayarlarý
$lang['Avatar_settings']             = 'Kiþisel Sembol Ayarlarý';
$lang['Allow_local']                 = 'Galeri sembolerini aç';
$lang['Allow_remote']                = 'Uzak sembolleri aç';
$lang['Allow_remote_explain']        = 'Baþka bir siteden link verilen semboller';
$lang['Allow_upload']                = 'Sembol göndermeyi aç';
$lang['Max_filesize']                = 'Maksimum sembol dosya büyüklüðü';
$lang['Max_filesize_explain']        = 'Gönderilen semboller için';
$lang['Max_avatar_size']             = 'Maksimum sembol boyutlarý';
$lang['Max_avatar_size_explain']     = '(Piksel olarak Yükseklik x Geniþlik)';
$lang['Avatar_storage_path']         = 'Sembol dizini';
$lang['Avatar_storage_path_explain'] = 'phpBB ana dizinine göre, örn: images/avatars';
$lang['Avatar_gallery_path']         = 'Sembol galeri dizini';
$lang['Avatar_gallery_path_explain'] = 'phpBB ana dizinine göre önceden yüklenmiþ sembollerin yeri, örn: images/avatars/gallery';

// COPPA Ayarlarý
$lang['COPPA_settings']              = 'COPPA Ayarlarý';
$lang['COPPA_fax']                   = 'COPPA fax numarasý';
$lang['COPPA_mail']                  = 'COPPA e-posta adresi';
$lang['COPPA_mail_explain']          = 'Ebeveynlerin COPPA anlaþmasýný gönderecekleri yer';

// E-posta ayarlarý
$lang['Email_settings']        = 'E-posta Ayarlarý';
$lang['Admin_email']           = 'Yönetici e-posta adresi';
$lang['Email_sig']             = 'E-posta imzasý';
$lang['Email_sig_explain']     = 'Gönderilecek tüm e-postalara bu yazý eklenir';
$lang['Use_SMTP']              = 'E-posta için SMTP sunucusunu kullan';
$lang['Use_SMTP_explain']      = 'Yerel sendmail fonksiyonu yerine SMTP sunucusunu kullanmak için Evet\'i seçin';
$lang['SMTP_server']           = 'SMTP sunucu adresi';
$lang['SMTP_username']         = 'SMTP kullanýcý adý';
$lang['SMTP_username_explain'] = 'Sadece SMTP sunucunuz kullanýcý adý istiyorsa giriniz';
$lang['SMTP_password']         = 'SMTP parolasý';
$lang['SMTP_password_explain'] = 'Sadece SMTP sunucunuz parola istiyorsa giriniz';

$lang['Disable_privmsg']       = 'Özel mesajlaþma';
$lang['Inbox_limits']          = 'Gelenler\'deki maksimum msj. sayýsý ';
$lang['Sentbox_limits']        = 'Ulaþanlar\'daki maksimum msj. sayýsý';
$lang['Savebox_limits']        = 'Saklananlar\'daki maksimum msj. sayýsý';

// Cookie Ayarlarý
$lang['Cookie_settings']         = 'Çerez (cookie) Ayarlarý';
$lang['Cookie_settings_explain'] = 'Bu çerez\'lerin browserlara nasýl gönderildiðini ayarlamak içindir. Bir çok durumda bu ilk halinde býrakýlmalýdýr. Bunlarý deðiþtirmeniz gerekiyorsa dikkatli olun, yanlýþ ayarlar kullanýcýlarýn oturum açmasýný engeller.';
$lang['Cookie_domain']           = 'Çerez alan adý';
$lang['Cookie_name']             = 'Çerez adý';
$lang['Cookie_path']             = 'Çerez yolu';
$lang['Cookie_secure']           = 'Çerez güvenliði [ https ]';
$lang['Cookie_secure_explain']   = 'Sunucunuz SSL modunda çalýþýyorsa açýn, aksi halde açmayýn';
$lang['Session_length']          = 'Oturum uzunluðu [ saniye ]';

// Visual Confirmation System
$lang['Visual_confirm']         = 'Görsel kayýt doðrulamaya izin ver';
$lang['Visual_confirm_explain'] = 'Yeni kayýt olanlarý, resim ile gösterilen bir kodu girmeye mecbur eder.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin']         = 'Otomatik oturum';
$lang['Allow_autologin_explain'] = 'Kullanýcýlarýn giriþte beni hatýrla seçeneðini seçmelerine izin ver.';
$lang['Autologin_time']          = 'Otomatik giriþ geçerliliði ';
$lang['Autologin_time_explain']  = 'Panoyu ziyaret etmeyenler için otomatik giriþin geçerlilik süresi. Kapamak için sýfýr yapýn.';

// Search Flood Control - added 2.0.20
$lang['Search_Flood_Interval']         = 'Arama Flood Aralýðý';
$lang['Search_Flood_Interval_explain'] = 'Kullanýcýnýn iki arama arasýnda beklemesi gereken süre [ saniye ]';

//
// Forum Management
//
$lang['Forum_admin']               = 'Forum Yönetimi';
$lang['Forum_admin_explain']       = 'Buradan kategori ve forumlar ekleyebilir, silebilir, deðiþtirebilirsiniz.';
$lang['Edit_forum']                = 'Forumu deðiþtir';
$lang['Create_forum']              = 'Yeni forum ekle';
$lang['Create_category']           = 'Yeni kategori ekle';
$lang['Remove']                    = 'Çýkar';
$lang['Action']                    = 'Eylem';
$lang['Update_order']              = 'Sýralamayý güncelle';
$lang['Config_updated']            = 'Ayarlar Baþarýyla Güncellendi';
$lang['Edit']                      = 'Deðiþtir';
$lang['Delete']                    = 'Sil';
$lang['Move_up']                   = 'Yukarý taþý';
$lang['Move_down']                 = 'Aþaðý taþý';
$lang['Resync']                    = 'Yenile';
$lang['No_mode']                   = 'Hiçbir yöntem seçilmedi';
$lang['Forum_edit_delete_explain'] = 'Aþaðýdaki form panonuzdaki genel ayarlarý yapmak için kullanýlacaktýr. Kullanýcý ve forum bazlý ayarlar için sol taraftaki ilgili linklere týklayýnýz.';

$lang['Move_contents']             = 'Tüm içeriði taþý';
$lang['Forum_delete']              = 'Forumu sil';
$lang['Forum_delete_explain']      = 'Aþaðýdaki form ile forum ya da kategori silebilir, içeriklerini istediðiniz yere taþýyabilirsiniz';

$lang['Status_locked']             = 'Kilitli';
$lang['Status_unlocked']           = 'Kilitli deðil';
$lang['Forum_settings']            = 'Genel Forum Ayarlarý';
$lang['Forum_name']                = 'Forum adý';
$lang['Forum_desc']                = 'Açýklama';
$lang['Forum_status']              = 'Forum durumu';
$lang['Forum_pruning']             = 'Otomatik Ýleti Temizleme';

$lang['prune_freq']                = 'Her x günde bir forumu kontrol et';
$lang['prune_days']                = 'x gün içinde cevap gelmeyen konularý sil';
$lang['Set_prune_data']            = 'Ýleti temizliðini açtýðýnýz halde kaç günde bir ileti temizliði yapýlacagýný seçmediniz';

$lang['Move_and_Delete']           = 'Taþý ve Sil';

$lang['Delete_all_posts']          = 'Tüm iletileri sil';
$lang['Nowhere_to_move']           = 'Taþýnacak yer yok';

$lang['Edit_Category']             = 'Kategoriyi deðiþtir';
$lang['Edit_Category_explain']     = 'Bir kategorinin ismini deðiþtirmek için bu formu kullanýn.';

$lang['Forums_updated']            = 'Forum ve Kategori bilgisi baþarýyla güncellendi';
$lang['Must_delete_forums']        = 'Bu kategoriyi silmeden önce içindeki tüm forumlarý silmelisiniz';

$lang['Click_return_forumadmin']   = 'Forum yönetim paneline dönmek için %sburaya%s týklayýn';


//
// Smiley Management
//
$lang['smiley_title']            = 'Ýfade Kontrol Paneli';
$lang['smile_desc']              = 'Buradan kullanýcýlara sunulan ifadeleri ekleyebilir kaldýrabilir ya da deðiþtirebilirsiniz.';

$lang['smiley_config']           = 'Ýfade Ayarlarý';
$lang['smiley_code']             = 'Ýfade Kodu';
$lang['smiley_url']              = 'Ýfade Resim Dosyasý';
$lang['smiley_emot']             = 'Ýfade Açýklamasý';
$lang['smile_add']               = 'Yeni ifade ekle';
$lang['Smile']                   = 'Ýfade';
$lang['Emotion']                 = 'Açýklama';

$lang['Select_pak']              = 'Paket (.pak) dosyasý seç';
$lang['replace_existing']        = 'Var olan ifadeyi bununla deðiþtir';
$lang['keep_existing']           = 'Var olan ifadeyi koru';

$lang['smiley_import_inst']      = 'Ýfade dosyasýný zip ile açmalý ve uygun ifade dizinine göndermelisiniz. Sonra buradan doðru seçenekleri bularak yükleme iþlemini gerçekleþtiriniz.';
$lang['smiley_import']           = 'Ýfade Paketi Kurma';
$lang['choose_smile_pak']        = 'Ýfade Paket Dosyasý (.pak) Seçin';
$lang['import']                  = 'Ýfade Paketi Kur';
$lang['smile_conflicts']         = 'Ýkilemlerde ne yapýlmalý?';
$lang['del_existing_smileys']    = 'Kurumdan önce var olan ifadeleri sil';
$lang['import_smile_pack']       = 'Ýfade Paketi Kur';
$lang['export_smile_pack']       = 'Ýfade Paketi Yarat';
$lang['export_smiles']           = 'Var olan ifadelerinizden bir paket yaratmak için, smiles.pak dosyasýný indirmek için %sburaya%s týklayýn. .pak uzantýsýný korumak suretiyle bu dosyanýn ismini deðiþtirin. Sonra bu .pak dosyasýný ve ilgili ifade resimlerini tek bir zip dosyasý içinde sýkýþtýrýn.';

$lang['smiley_add_success']      = 'Ýfade baþarýyla eklendi';
$lang['smiley_edit_success']     = 'Ýfade baþarýyla güncellendi';
$lang['smiley_import_success']   = 'Ýfade Paketi kurulumu baþarýldý!';
$lang['smiley_del_success']      = 'Ýfade baþarýyla silindi';
$lang['Click_return_smileadmin'] = 'Ýfade kontrol paneline dönmek için %sburaya%s týklayýn';
$lang['Confirm_delete_smiley']   = 'Bu ifadeyi silmek istediðinize emin misiniz?';


//
// User Management
//
$lang['User_admin']             = 'Kullanýcý Yönetimi';
$lang['User_admin_explain']     = 'Buradan kullanýcýlarýnýzýn ayarlarýný deðiþtirebilirsiniz. Ýzinleri deðiþtirmek için soldan Ýzinler linkini kullanýn.';

$lang['Look_up_user']           = 'Kullanýcýyý incele';

$lang['Admin_user_fail']        = 'Kullanýcýnýn bilgileri güncellenemedi.';
$lang['Admin_user_updated']     = 'Kullanýcý bilgileri baþarýyla güncellendi.';
$lang['Click_return_useradmin'] = 'Kullanýcý Yönetim Paneline dönmek için %sburaya%s týklayýn';

$lang['User_delete']            = 'Bu kullanýcýyý sil';
$lang['User_delete_explain']    = 'Kullanýcýyý silmek için burayý iþaretleyin. Bu dönüþü olmayan bir iþlemdir.';
$lang['User_deleted']           = 'Kullanýcý baþarýyla silindi.';

$lang['User_status']            = 'Bu kullanýcý þu anda aktif';
$lang['User_allowpm']           = 'Özel mesaj atabilir';
$lang['User_allowavatar']       = 'Kiþisel sembol kullanabilir';

$lang['Admin_avatar_explain']   = 'Burdan kullanýcýnýn þu andaki kiþisel sembolünü silebilir ya da deðiþtirebilirsiniz.';
$lang['User_special']           = 'Özel yönetici alanlarý';
$lang['User_special_explain']   = 'Bu alanlar kullanýcýlar tarafýndan deðiþtirilemez. Buradan bütün kullanýcýlara verilmeyen ayarlarý yapabilirsiniz.';


//
// Group Management
//
$lang['Group_administration']     = 'Grup Yönetimi';
$lang['Group_admin_explain']      = 'Burdan gruplarýnýzý yaratabilir, silebilir ya da deðiþtirebilirsiniz. Grup yöneticilerini, grup durumlarýný, grup isimlerini deðiþtirebilirsiniz';
$lang['Error_updating_groups']    = 'Gruplar güncellenirken bir hata oluþtu';
$lang['Updated_group']            = 'Grup baþarýyla güncellendi';
$lang['Added_new_group']          = 'Yeni grup baþarýyla yaratýldý';
$lang['Deleted_group']            = 'Grup baþarýyla silindi';
$lang['New_group']                = 'Yeni grup yarat';
$lang['Edit_group']               = 'Grubu deðiþtir';
$lang['group_name']               = 'Grup adý';
$lang['group_description']        = 'Grup açýklamasý';
$lang['group_moderator']          = 'Grup yöneticisi';
$lang['group_status']             = 'Grup durumu';
$lang['group_open']               = 'Açýk grup';
$lang['group_closed']             = 'Kapalý grup';
$lang['group_hidden']             = 'Gizli grup';
$lang['group_delete']             = 'Grubu sil';
$lang['group_delete_check']       = 'Bu grubu sil';
$lang['submit_group_changes']     = 'Deðiþiklikleri gönder';
$lang['reset_group_changes']      = 'Deðiþiklikleri sil';
$lang['No_group_name']            = 'Bu grup için bir isim belirtmelisiniz';
$lang['No_group_moderator']       = 'Bu grup için bir yönetici belirtmelisiniz';
$lang['No_group_mode']            = 'Bu grup için bir mod belirmelisiniz, açýk ya da kapalý';
$lang['No_group_action']          = 'Bir görev seçilmemiþ';
$lang['delete_group_moderator']   = 'Eski grup yöneticisi sil';
$lang['delete_moderator_explain'] = 'Grup yöneticisi deðiþtirirken, eski yöneticiyi gruptan atmak için burayý iþaretleyin. Aksi takdirde kullanýcý grubun normal bir üyesi olacaktýr.';
$lang['Click_return_groupsadmin'] = 'Grup yönetimine dönmek için %sburaya%s týklayýn.';
$lang['Select_group']             = 'Grup seç';
$lang['Look_up_group']            = 'Grubu incele';


//
// Prune Administration
//
$lang['Forum_Prune']             = 'Ýleti Temizliði';
$lang['Forum_Prune_explain']     = 'Bu form ile seçtiðiniz gün sayýsý içinde cevap gelmeyen konularý silebilirsiniz. Eðer bir sayý girmezseniz tüm iletiler silinir. Ýçinde anket olan iletileri ya da duyurularý silmeyecektir. Onlarý tek tek elle silmek zorundasýnýz.';
$lang['Do_Prune']                = 'Temizlik Yap';
$lang['All_Forums']              = 'Tüm forumlar';
$lang['Prune_topics_not_posted'] = 'Bu kadar gün içinde cevap gelmemiþ iletileri sil';
$lang['Topics_pruned']           = 'Silinen konular';
$lang['Posts_pruned']            = 'Silinen iletiler';
$lang['Prune_success']           = 'Ýleti temizliði baþarýlý!';


//
// Word censor
//
$lang['Words_title']            = 'Kelime Sansürleme';
$lang['Words_explain']          = 'Buradan otomatik olarak sansürlenecek kelimeleri ekleyebilir, silebilir, deðiþtirebilirsiniz. Ayrýca insanlar bu kelimeleri kullanýcý adlarýnda da kullanamazlar. Joker olarak * kullanabilirsiniz, Örn: *siklo* ansiklopedi\'yi, siklo* siklon\'u, *siklo dersiklo\'yu sansürleyecektir.';
$lang['Word']                   = 'Kelime';
$lang['Edit_word_censor']       = 'Sansürlü kelimeyi deðiþtir';
$lang['Replacement']            = 'Yerine konulacak';
$lang['Add_new_word']           = 'Yeni kelime ekle';
$lang['Update_word']            = 'Sansürü güncelle';

$lang['Must_enter_word']        = 'Bir kelime ve onun yerine girilecek kelimeyi girmelisiniz';
$lang['No_word_selected']       = 'Deðiþtirmek için bir kelime seçmediniz';

$lang['Word_updated']           = 'Seçilen sansürlü kelime baþarýyla güncellendi';
$lang['Word_added']             = 'Sansürlü kelime baþarýyla eklendi';
$lang['Word_removed']           = 'Seçilen sansürlü kelime baþarýyla silindi';

$lang['Click_return_wordadmin'] = 'Kelime sansürü yönetim paneline dönmek için %sburaya%s týklayýn';
$lang['Confirm_delete_word']    = 'Bu kelime sansürünü silmek istediðinize emin misiniz?';


//
// Mass Email
//
$lang['Mass_email_explain']     = 'Buradan tüm kullanýcýlarýnýza ya da bir gruba dahil tüm kullanýcýlara e-posta gönderebilirsiniz. Bu yönetici e-postasýna atýlan mesajýn gizli karbon kopyalarýnýn kullanýcýlara gönderilmesi yoluyla yapýlacak. Eðer geniþ bir gruba gönderiyorsanýz lütfen stop butonuna basmayýn ve sayfanýn yüklenmesini sabýrlý bir þekilde bekleyin. Büyük bir toptan e-posta gönderiminin yavaþ olmasý doðaldýr, yazýlým görevini tamamladýðýnda size haber verilecektir.';
$lang['Compose']                = 'Oluþtur';
$lang['Recipients']             = 'Alýcýlar';
$lang['All_users']              = 'Tüm Kullanýcýlar';
$lang['Email_successfull']      = 'Mesajýnýz Gönderilmiþtir';
$lang['Click_return_massemail'] = 'Toptan e-posta formuna dönmek için %sburaya%s týklayýnýz';


//
// Ranks admin
//
$lang['Ranks_title']        = 'Seviye Yönetimi';
$lang['Ranks_explain']      = 'Buradan kullanýcýlarýnýza verilecek seviyeler yaratabilir, silebilir ve deðiþtirebilirsiniz. Kullanýcý yönetiminden kullanýcýlara verilebilecek özel seviyeler de yaratabilirsiniz.';

$lang['Add_new_rank']       = 'Yeni seviye ekle';

$lang['Rank_title']         = 'Seviye Adý';
$lang['Rank_special']       = 'Özel Seviye';
$lang['Rank_minimum']       = 'Minimum Ýleti Sayýsý';
$lang['Rank_maximum']       = 'Maksimum Ýleti Sayýsý';
$lang['Rank_image']         = 'Seviye resmi (phpBB ana dizinine göre)';
$lang['Rank_image_explain'] = 'Seviye için ufak bir resim kullanýn';

$lang['Must_select_rank']   = 'Bir seviye seçmelisiniz';
$lang['No_assigned_rank']   = 'Hiç özel seviye atanmamýþ';

$lang['Rank_updated']       = 'Seviye baþarýyla güncellendi';
$lang['Rank_added']         = 'Seviye baþarýyla eklendi';
$lang['Rank_removed']       = 'Seviye baþarýyla silindi';
$lang['No_update_ranks']    = 'Bu seviye baþarýyla silindi, ancak bu seviyeye sahip olan kullanýcýlarýn ayarlarý deðiþmedi. Bu kullanýcýlarýn hesaplarýný kendiniz güncellemelisiniz';

$lang['Click_return_rankadmin'] = 'Seviye yönetimine dönmek için %sburaya%s týklayýn';
$lang['Confirm_delete_rank']    = 'Bu seviyeyi silmek istediðinize emin misiniz?';


//
// Disallow Username Admin
//
$lang['Disallow_control']        = 'Yasaklý Kullanýcý Ýsmi Kontrolü';
$lang['Disallow_explain']        = 'Burada kullanýlmamasý gereken kullanýcý adlarýný ayarlayabilirsiniz. Joker olarak * kullanabilirsiniz. Kayýt olmuþ bir kullanýcý adýný yasaklayamazsýnýz, bunu yapmak için ilk önce o kullanýcýyý silmelisiniz';

$lang['Delete_disallow']         = 'Sil';
$lang['Delete_disallow_title']   = 'Yasaklý bir kullanýcý adýný kaldýr';
$lang['Delete_disallow_explain'] = 'Buradan yasaklý bir kullanýcý adýný seçip sil butonuna basarak yasaðý kaldýrabilirsiniz';

$lang['Add_disallow']            = 'Ekle';
$lang['Add_disallow_title']      = 'Yasaklý bir kullanýcý adý ekle';
$lang['Add_disallow_explain']    = 'Joker olarak * kullanabilirsiniz';

$lang['No_disallowed']           = 'Yasaklý kullanýcý adý yok';

$lang['Disallowed_deleted']      = 'Yasaklý kullanýcý adý baþarýyla kaldýrýldý';
$lang['Disallow_successful']     = 'Yasaklý kullanýcý adý baþarýyla eklendi';
$lang['Disallowed_already']      = 'Girdiðiniz ad yasaklanamadý. Ya listede var, ya sansür listesinde var, ya da böyle bir kullanýcý mevcut';

$lang['Click_return_disallowadmin'] = 'Yasaklý kullanýcý adý kontrol paneline dönmek için %sburaya%s týklayýn';


//
// Styles Admin
//
$lang['Styles_admin']          = 'Stil Yönetimi';
$lang['Styles_explain']        = 'Buradan kullanýcýlarýnýza sunduðunuz temalarýnýzý yönetebilirsiniz';
$lang['Styles_addnew_explain'] = 'Burada tüm tema\'larýnýz listelenmiþtir. Bunlar henüz veritabanýna kaydedilmemiþtir. Kaydetmek için birini seçin ve Yükle tuþuna basýn';

$lang['Select_template'] = 'Bir tema seçin';

$lang['Style']    = 'Stil';
$lang['Template'] = 'Tema';
$lang['Install']  = 'Yükle';
$lang['Download'] = 'Ýndir';

$lang['Edit_theme']         = 'Tema\'yý deðiþtir';
$lang['Edit_theme_explain'] = 'Aþaðýdaki form ile seçtiðiniz tema\'yý deðiþtirebilirsiniz';

$lang['Create_theme']         = 'Tema yarat';
$lang['Create_theme_explain'] = 'Aþaðýdaki form ile seçilen tema için yeni bir stil yaratýn. Renkleri girerken # iþaretini kullanmayýn. Örn: CCCCCC doðru, #CCCCCC yanlýþ';

$lang['Export_themes']  = 'Tema\'yý kaydet';
$lang['Export_explain'] = 'Bu panel ile seçtiðiniz tema için bir stil dosyasý yaratýp kaydedebileceksiniz. Aþaðýdan temayý seçin ve yazýlým onun için gerekli tema dosyasýný yaratýp o dizine kaydetmeyi deneyecektir. Eðer kaydedemezse size indirme seçeneðini sunacaktýr. Yazýlým\'ýn dosyayý kaydedebilmesi için o dizine yazma izninin verilmiþ olmasý gerekir. Ayrýntýlý bilgi için PhpBB2 kullanma kýlavuzuna bakýn.';

$lang['Theme_installed']  = 'Seçilen tema baþarýyla yüklendi'; // eklendi
$lang['Style_removed']    = 'Seçilen tema veritabanýndan baþarýyla silindi. Bu tema\'yý sisteminizden tamamýyla silmek için dosylarýný da silmelisiniz.';
$lang['Theme_info_saved'] = 'Seçilen tema için stil bilgisi kaydedildi.';
$lang['Theme_updated']    = 'Seçilen tema güncellendi. Þimdi yeni tema ayarlarýný kaydetmelisiniz';
$lang['Theme_created']    = 'Tema yaratýldý. Þimdi bu tema\'yý sonradan kullanmak ya da taþýmak için kaydetmelisiniz';

$lang['Confirm_delete_style'] = 'Bu stili silmek istediðinize emin misiniz?';

$lang['Download_theme_cfg']  = 'Tema bilgi dosyasý yazýlamadý. Dosyayý indirmek için aþaðýdaki butona týklayýnýz. Sonra onu ilgili tema dosyalarýnýn bulunduðu dizine göndermelisiniz. Sonra isterseniz dosyalarý daðýtým ya da baþka bir amaçla paketleyebilirsiniz';
$lang['No_themes']           = 'Seçilen temanýn atanmýþ hiç stili yok. Sol taraftaki Stil Yönetimi\'nden Yarat\'a týklayýnýz';
$lang['No_template_dir']     = 'Tema dizini açýlamadý. Web sunucusu tarafýndan okunamýyor olabilir ya da böyle bir dizin yok';
$lang['Cannot_remove_style'] = 'Bu stil þu anda varsayýlan stil olduðu için silinemez. Varsayýlan stili deðiþtirip tekrar deneyin.';
$lang['Style_exists']        = 'Seçilen stil adý kullanýmda, lütfen baþka bir isim seçiniz.';

$lang['Click_return_styleadmin'] = 'Stil yönetimine dönmek için %sburaya%s týklayýn';

$lang['Theme_settings'] = 'Tema Ayarlarý';
$lang['Theme_element']  = 'Tema Elemanlarý';
$lang['Simple_name']    = 'Ýsmi';
$lang['Value']          = 'Deðer';
$lang['Save_Settings']  = 'Ayarlarý Kaydet';

$lang['Stylesheet']         = 'CSS Stil Þablonu';
$lang['Stylesheet_explain'] = 'Bu tema için kullanýlacak CSS þablonunun adý.';
$lang['Background_image']   = 'Arkaplan Resmi';
$lang['Background_color']   = 'Arkaplan Rengi';
$lang['Theme_name']  = 'Tema Adý';
$lang['Link_color']  = 'Link Rengi';
$lang['Text_color']  = 'Yazý Rengi';
$lang['VLink_color'] = 'Ziyaret Edilmiþ Link Rengi';
$lang['ALink_color'] = 'Aktif Link Rengi';
$lang['HLink_color'] = 'Üstüne Gelinen Link Rengi';
$lang['Tr_color1'] = 'Tablo Satýr Rengi 1';
$lang['Tr_color2'] = 'Tablo Satýr Rengi 2';
$lang['Tr_color3'] = 'Tablo Satýr Rengi 3';
$lang['Tr_class1'] = 'Tablo Satýr Sýnýfý 1';
$lang['Tr_class2'] = 'Tablo Satýr Sýnýfý 2';
$lang['Tr_class3'] = 'Tablo Satýr Sýnýfý 3';
$lang['Th_color1'] = 'Tablo Konu Rengi 1';
$lang['Th_color2'] = 'Tablo Konu Rengi 2';
$lang['Th_color3'] = 'Tablo Konu Rengi 3';
$lang['Th_class1'] = 'Tablo Konu Sýnýfý 1';
$lang['Th_class2'] = 'Tablo Konu Sýnýfý 2';
$lang['Th_class3'] = 'Tablo Konu Sýnýfý 3';
$lang['Td_color1'] = 'Tablo Hücre Rengi 1';
$lang['Td_color2'] = 'Tablo Hücre Rengi 2';
$lang['Td_color3'] = 'Tablo Hücre Rengi 3';
$lang['Td_class1'] = 'Tablo Hücre Sýnýfý 1';
$lang['Td_class2'] = 'Tablo Hücre Sýnýfý 2';
$lang['Td_class3'] = 'Tablo Hücre Sýnýfý 3';
$lang['fontface1'] = 'Karakter Tipi 1';
$lang['fontface2'] = 'Karakter Tipi 2';
$lang['fontface3'] = 'Karakter Tipi 3';
$lang['fontsize1'] = 'Karakter Büyüklüðü 1';
$lang['fontsize2'] = 'Karakter Büyüklüðü 2';
$lang['fontsize3'] = 'Karakter Büyüklüðü 3';
$lang['fontcolor1'] = 'Karakter Rengi 1';
$lang['fontcolor2'] = 'Karakter Rengi 2';
$lang['fontcolor3'] = 'Karakter Rengi 3';
$lang['span_class1'] = 'Span Sýnýfý 1';
$lang['span_class2'] = 'Span Sýnýfý 2';
$lang['span_class3'] = 'Span Sýnýfý 3';
$lang['img_poll_size'] = 'Anket resmi büyüklüðü [px]';
$lang['img_pm_size']   = 'Özel mesajlar durum resmi büyüklüðü [px]';


//
// Install Process
//
$lang['Welcome_install']  = 'phpBB Yüklemesine Hoþgeldiniz';
$lang['Initial_config']   = 'Genel Ayarlar';
$lang['DB_config']        = 'Veritabaný Ayarlarý';
$lang['Admin_config']     = 'Yönetici Ayarlarý';
$lang['continue_upgrade'] = 'Config dosyasýný bilgisayarýnza indirdikten sonra \'Güncellemeye Devam\' düðmesine basarak güncelleme iþlemine devam edebilirsiniz.';
$lang['upgrade_submit']   = 'Güncellemeye Devam';

$lang['Installer_Error']  = 'Yükleme sýrasýnda bir problem oluþtu';
$lang['Previous_Install'] = 'Önceden yüklenmiþ bir phpBB bulundu';
$lang['Install_db_error'] = 'Veritabanýný güncellerken bir hata oluþtu';

$lang['Re_install']       = 'Önceden yüklediðiniz phpBB halen aktif. <br /><br />Eðer phpBB\'yi yeniden yüklemek istiyorsanýz aþaðýdaki evet düðmesine basýn. Bunu yaparken bunun þu andaki tüm verileri sileceðini, yedek yapýlmayacaðýný unutmayýn! Yönetici kullanýcý adý ve parolanýz yeniden oluþturulacaktýr; baþka hiçbir ayarýnýz korunmayacaktýr. <br /><br />Evet\'e basmadan önce iyi düþünün!';
$lang['Inst_Step_0']      = 'phpBB\'yi seçtiðiniz için teþekkür ederiz. Yükleme iþlemini bitirmek için lütfen aþaðýdaki boþluklarý doldurunuz. Kullanacaðýnýz veritabanýný önceden yaratmýþ olmanýz gerekmektedir. ODBC kullanan bir veritabanýna yükleme yapacaksanýz, (Örn: MS Access) devam etmeden önce bir DSN yaratmalýsýnýz.';

$lang['Start_Install']  = 'Yüklemeye baþla';
$lang['Finish_Install'] = 'Yüklemeyi bitir';

$lang['Default_lang']   = 'Panonun varsayýlan dili';
$lang['DB_Host']        = 'Veritabaný sunucu adresi';
$lang['DB_Name']        = 'Veritabaný adý';
$lang['DB_Username']    = 'Veritabaný kullanýcý adý';
$lang['DB_Password']    = 'Veritabaný parolasý';
$lang['Database']       = 'Veritabanýnýz';
$lang['Install_lang']   = 'Yükleme dilini seçin';
$lang['dbms']           = 'Veritabaný türü';
$lang['Table_Prefix']   = 'Veritabaný tablo önadlarý';
$lang['Admin_Username'] = 'Yönetici kullanýcý adý';
$lang['Admin_Password'] = 'Yönetici parolasý';
$lang['Admin_Password_confirm'] = 'Yönetici parolasý [ onay ]';

$lang['Inst_Step_2'] = 'Yönetici kullanýcý oluþturuldu. Bu noktada temel yükleme tamamlandý. Þimdi yeni yüklediðiniz panoyu yönetebileceðiniz bir sayfaya yönlendirileceksiniz. Genel ayarlarý kontrol edin ve kendi ihtiyaçlarýnýz doðrultusunda ayarlarlayýn. phpBB\'yi seçtiðiniz için teþekkür ederiz.';

$lang['Unwriteable_config'] = 'Þu anda config dosyasýna yazýlamýyor. Aþaðýdaki butona basýnca bu config dosyasýnýn bir kopyasý bilgisayarýnýza indirilecektir. Bu dosyayý phpBB ile ayný dizin içine göndermelisiniz. Bunu yaptýktan sonra bir önceki form\'la yaratýlan yönetici adý ve parolasýný kullanarak yönetim paneline girmeli ve ayarlarý yapmalýsýnýz. (Oturum açtýktan sonra ekranýn altýnda bir link görünecektir). phpBB\'yi seçtiðiniz için teþekkür ederiz.';
$lang['Download_config']    = 'Config dosyasýný indir';

$lang['ftp_choose']      = 'Ýndirme Metodunu Seçin';
$lang['ftp_option']      = '<br />PHP\'nin bu sürümünde ftp komutlarýna izin verildiði için direk config dosyasýný yerine ftp ile gönderebilirsiniz.';
$lang['ftp_instructs']   = 'Config dosyasýný phpBB\'nin bulunduðu yere otomatik olarak ftp ile göndermeyi seçtiniz.  Lütfen aþaðýdaki bilgileri doldurunuz';
$lang['ftp_info']        = 'FTP bilgilerinizi girin';
$lang['Attempt_ftp']     = 'FTP ile gönderme deneniyor';
$lang['Send_file']       = 'Bana sadece dosyayý gönder ve ben onu kendim FTP\'liyim';
$lang['ftp_path']        = 'phpBB FTP yolu';
$lang['ftp_username']    = 'FTP Kullanýcý Adý';
$lang['ftp_password']    = 'FTP Parolasý';
$lang['Transfer_config'] = 'Transfere baþla';
$lang['NoFTP_config']    = 'FTP iþlemi baþarýsýz. Lütfen config doyasýný indirip kendiniz gönderiniz';

$lang['Install'] = 'Yükle';
$lang['Upgrade'] = 'Güncelle';

$lang['Install_Method']  = 'Yükleme metodu';
$lang['Install_No_Ext']  = 'Sunucu\'nuz seçtiðiniz veritabaný türünü desteklemiyor';
$lang['Install_No_PCRE'] = 'phpBB, php için \'Perl-Compatible Regular Expressions\' modülüne ihtiyaç duymaktadýr. Kullandýðýnýz php ayarlarý bunu desteklememektedir';

//
// Version Check
//
$lang['Version_up_to_date']              = 'Son phpBB2 sürümünü kullanýyorsunuz. Önerilen güncelleme bulunmamaktadýr.';
$lang['Version_not_up_to_date']          = 'Kullandýðýnýz phpBB2 sürümü güncel <b>deðil</b>. Güncel sürüme sahip olmak için phpbb.com sitesinin <a href="http://www.phpbb.com/downloads.php" title="http://www.phpbb.com/downloads.php" target="_new">phpbb indirme</a> bölümünü ziyaret ediniz.';
$lang['Latest_version_info']             = 'Mevcut olan en yeni phpBB sürümü: <b>%s</b>. ';
$lang['Current_version_info']            = 'Kullandýðýnýz phpBB sürümü: <b>%s</b>.';
$lang['Connect_socket_error']            = 'phpBB sitesi ile baðlantý kurulamadý. Bildirilen hata:<br />%s';
$lang['Socket_functions_disabled']       = 'Soket fonksiyonlarýnda sorun oluþtu.';
$lang['Mailing_list_subscribe_reminder'] = 'En son phpBB güncellemelerinden haberdar olmak istiyorsanýz, lütfen <a href="http://www.phpbb.com/support/" target="_new"> phpBB Haber Servisine</a> abone olun.';
$lang['Version_information']             = 'Sürüm Bilgisi';

//
// Login attempts configuration
//
$lang['Max_login_attempts']         = 'Ýzin verilen oturum açma denemesi';
$lang['Max_login_attempts_explain'] = 'Pano için izin verilen oturum açma deneme sayýsý.';
$lang['Login_reset_time']           = 'Oturum açma kilit zamaný';
$lang['Login_reset_time_explain']   = 'Ýzin verilen oturum açma deneme sayýsý aþýldýktan sonra, bir sonraki oturum açma izni için mecburi beklenmesi gereken dakika.';

//
// That's all Folks!
// -------------------------------------------------

?>