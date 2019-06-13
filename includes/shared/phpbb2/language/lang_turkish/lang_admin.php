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


$lang['General']        = 'Genel Y�netim';
$lang['Users']          = 'Kullan�c� Y�netimi';
$lang['Groups']         = 'Grup Y�netimi';
$lang['Forums']         = 'Forum Y�netimi';
$lang['Styles']         = 'Tema Y�netimi';

$lang['Configuration']  = 'Ayarlar';
$lang['Permissions']    = '�zinler';
$lang['Manage']         = 'Y�netim';
$lang['Disallow']       = 'Yasakl� �simler';
$lang['Prune']          = 'Eski �letileri Sil';
$lang['Mass_Email']     = 'Kullan�c�lara E-Posta';
$lang['Ranks']          = 'Kullan�c� Seviyeleri';
$lang['Smilies']        = '�fadeler';
$lang['Ban_Management'] = 'Yasakl� Y�netimi';
$lang['Word_Censor']    = 'Sans�rl� Kelimeler';
$lang['Export']         = 'Kaydet';
$lang['Create_new']     = 'Olu�tur';
$lang['Add_new']        = 'Ekle';
$lang['Backup_DB']      = 'Veritaban�n� Yedekle';
$lang['Restore_DB']     = 'Veritaban�n� Y�kle';


//
// Index
//
$lang['Admin']            = 'Y�netim';
$lang['Not_admin']        = 'Bu sitenin y�neticili�ini yapma yetkiniz yok';
$lang['Welcome_phpBB']    = 'phpBB\'ye ho�geldiniz';
$lang['Admin_intro']      = 'PhpBB2\'yi panonuz olarak se�ti�iniz i�in te�ekk�r ederiz. Bu ekran size sitenizin bilgilerinin k�sa bir �zetini sunmaktad�r. Bu sayfaya soldaki <u>Y�netim - Ana Sayfa</u> linkine basarak geri d�nebilirsiniz. Sitenizin ana sayfas�na d�nmek i�in soldaki k���k logoyu kullanabilirsiniz. Soldaki di�er linkler forumunuzun her t�rl� ayar�n� yapman�z� sa�layacakt�r, her ekran kendinin nas�l kullan�laca��n� anlatacakt�r.';
$lang['Main_index']       = 'Ana Sayfa';
$lang['Forum_stats']      = 'Pano �statistikleri';
$lang['Admin_Index']      = 'Y�netim - Ana Sayfa';
$lang['Preview_forum']    = 'Pano �nizlemesi';

$lang['Click_return_admin_index'] = 'Y�netim ana sayfas�na d�nmek i�in %sburaya%s t�klay�n';

$lang['Statistic']        = '�statistik';
$lang['Value']            = 'De�er';
$lang['Number_posts']     = '�leti say�s�';
$lang['Posts_per_day']    = 'G�nl�k ortalama ileti';
$lang['Number_topics']    = 'Konu say�s�';
$lang['Topics_per_day']   = 'G�nl�k ortalama konu';
$lang['Number_users']     = '�ye say�s�';
$lang['Users_per_day']    = 'G�nl�k ortalama �ye';
$lang['Board_started']    = 'Pano a��l�� tarihi';
$lang['Avatar_dir_size']  = 'Ki�isel sembol dizini b�y�kl���';
$lang['Database_size']    = 'Veritaban� b�y�kl���';
$lang['Gzip_compression'] = 'Gzip s�k��t�rma';
$lang['Not_available']    = 'Mevcut de�il';

$lang['ON']               = 'A��k';
$lang['OFF']              = 'Kapal�';


//
// DB Utils
//
$lang['Database_Utilities']       = 'Veritaban� ��lemleri';

$lang['Restore']                  = 'Geri Y�kleme';
$lang['Backup']                   = 'Yedekleme';
$lang['Restore_explain']          = 'Bu i�lem bir dosyadan t�m phpBB veritaban� tablolar�n� <B>geri y�kleyecektir</B>. E�er sunucunuz izin veriyorsa gzip ile s�k��t�r�lm�� bir text dosyas� y�kleyebilirsiniz, otomatik olarak a��lacakt�r. <b>UYARI:</b> Bu i�lem b�t�n bulunan verileri silecek yerine yenilerini yazacakt�r. Geri y�kleme uzun s�rebilir, tamamlanana kadar l�tfen bu sayfay� kapatmay�n�z.';
$lang['Backup_explain']           = 'Buradan t�m phpBB verilerinizi yedekleyebilirsiniz. E�er ayn� veritaban�nda saklamak istedi�iniz ba�ka tablolar�n�z da varsa, a�a��daki Ek Tablolar b�l�m�ne isimlerini virg�lle ay�rarak giriniz. E�er sunucunuz izin veriyorsa backup dosyan�z� gzip ile s�k��t�r�p da alabilirsiniz.';

$lang['Backup_options']           = 'Yedekleme se�enekleri';
$lang['Start_backup']             = 'Yedeklemeyi ba�lat';
$lang['Full_backup']              = 'Tam yedekleme';
$lang['Structure_backup']         = 'Sadece tablo yap�s�';
$lang['Data_backup']              = 'Sadece veriler';
$lang['Additional_tables']        = 'Ek tablolar';
$lang['Gzip_compress']            = 'Gzip s�k��t�rma';
$lang['Select_file']              = 'Bir dosya se�in';
$lang['Start_Restore']            = 'Geri y�klemeyi ba�lat';

$lang['Restore_success']          = 'Veritaban� ba�ar�yla yedeklendi.<br /><br />Siteniz yedeklemenin yap�ld��� zamanki haline d�n��t�r�ld�.';
$lang['Backup_download']          = '�ndirme k�sa bir s�re i�inde ba�layacak, l�tfen bekleyiniz';
$lang['Backups_not_supported']    = 'Kulland���n�z veritaban� sistemin hen�z yedekleme desteklenmiyor';

$lang['Restore_Error_uploading']  = 'Yedekleme dosyas�n� g�nderirken hata';
$lang['Restore_Error_filename']   = 'Dosya isminde problem olu�tu, l�tfen alternatif bir dosya deneyin';
$lang['Restore_Error_decompress'] = 'Gzip s�k��t�rmas� a��lam�yor, l�tfen d�zyaz� s�r�m�n� g�nderin';
$lang['Restore_Error_no_file']    = 'Dosya g�nderilmedi';


//
// Auth pages
//
$lang['Select_a_User']             = 'Bir kullan�c� se�';
$lang['Select_a_Group']            = 'Bir grup se�';
$lang['Select_a_Forum']            = 'Bir forum se�';
$lang['Auth_Control_User']         = 'Kullan�c� �zinleri Kontrol�';
$lang['Auth_Control_Group']        = 'Grup �zinleri Kontrol�';
$lang['Auth_Control_Forum']        = 'Forum �zinleri Kontrol�';
$lang['Look_up_User']              = 'Ayr�nt�lar';
$lang['Look_up_Group']             = 'Ayr�nt�lar';
$lang['Look_up_Forum']             = 'Ayr�nt�lar';

$lang['Group_auth_explain']        = 'Burada her gruba verilmi� olan izinleri ve b�l�m yetkilisi durumlar�n� de�i�tirebilirsiniz. Grup izinlerini de�i�tirirken kullan�c� izinlerinin gruptaki baz� kullan�c�lara hala baz� �zel haklar tan�yabilece�ini unutmay�n. E�er b�yle bir durum s�z konusuysa uyar�lacaks�n�z.';
$lang['User_auth_explain']         = 'Burada her kullan�c�ya verilmi� olan izinleri ve b�l�m yetkilisi durumlar�n� de�i�tirebilirsiniz. Kullan�c� izinlerini de�i�tirirken grup izinlerinin baz� kullan�c�lara hala baz� �zel haklar tan�yabilece�ini unutmay�n. E�er b�yle bir durum s�z konusuysa uyar�lacaks�n�z.';
$lang['Forum_auth_explain']        = 'Buradan her forumun izin derecesini de�i�tirebilirsiniz. Geli�mi� ve Basit olaraka ikiye ayr�lm�� olan izinlerde, geli�mi� se�ene�ini kullanarak daha �zel izinler verebilece�inizi unutmay�n�z.';

$lang['Simple_mode']               = 'Basit Mod';
$lang['Advanced_mode']             = 'Geli�mi� Mod';
$lang['Moderator_status']          = 'B�l�m yetkilisi durumu';

$lang['Allowed_Access']            = 'Eri�im izni verilmi�';
$lang['Disallowed_Access']         = 'Eri�im izni verilmemi�';
$lang['Is_Moderator']              = 'B�l�m yetkilisi';
$lang['Not_Moderator']             = 'B�l�m yetkilisi de�il';

$lang['Conflict_warning']          = 'Yetki �eli�kisi Uyar�s�';
$lang['Conflict_access_userauth']  = 'Bu kullan�c�n�n �ye oldu�u grup arac�l��� ile bu foruma eri�imi var. Grup izinleriyle oynayabilir ya da kullan�c�y� gruptan ��kartabilirsiniz. Bu durumu olu�turan gruplar ve forumlar a�a��da listelenmi�tir.';
$lang['Conflict_mod_userauth']     = 'Bu kullan�c�n�n �ye oldu�u grup arac�l��� ile bu foruma y�netici eri�imi var. Grup izinleriyle oynayabilir ya da kullan�c�y� gruptan ��kartabilirsiniz. Bu durumu olu�turan gruplar ve forumlar a�a��da listelenmi�tir.';

$lang['Conflict_access_groupauth'] = 'A�a��daki kullan�c�lar�n hala kullan�c� izinleriyle bu foruma eri�imleri var. Kullan�c� izinlerini de�i�tirebilirsiniz. �zel hakk� olan kullan�c�lar ve forumlar a�a��da listelenmi�tir.';
$lang['Conflict_mod_groupauth']    = 'A�a��daki kullan�c�lar�n hala kullan�c� izinleriyle bu foruma y�netici eri�imleri var. Kullan�c� izinlerini de�i�tirebilirsiniz. �zel hakk� olan kullan�c�lar ve forumlar a�a��da listelenmi�tir.';

$lang['Public']                    = 'Herkese A��k';
$lang['Private']                   = '�zel';
$lang['Registered']                = 'Kay�tl�lara A��k';
$lang['Administrators']            = 'Pano Y�neticilerine A��k';
$lang['Hidden']                    = 'Gizli';


// These are displayed in the drop down boxes for advanced 
// mode forum auth, try and keep them short!
$lang['Forum_ALL']              = 'Herkes';
$lang['Forum_REG']              = 'Kay�tl�';
$lang['Forum_PRIVATE']          = '�zel';
$lang['Forum_MOD']              = 'B�l�m Yetkilisi';
$lang['Forum_ADMIN']            = 'Pano Y�neticisi';

$lang['View']                   = 'G�r�nt�leme';
$lang['Read']                   = 'Okuma';
$lang['Post']                   = 'G�nderme';
$lang['Reply']                  = 'Cevap yazma';
$lang['Edit']                   = 'De�i�tirme';
$lang['Delete']                 = 'Silme';
$lang['Sticky']                 = '�nemli';
$lang['Announce']               = 'Duyuru';
$lang['Vote']                   = 'Oy kullanma';
$lang['Pollcreate']             = 'Anket yaratma';

$lang['Permissions']            = '�zinler';
$lang['Simple_Permission']      = 'Basit Mod';

$lang['User_Level']             = 'Kullan�c� seviyesi';
$lang['Auth_User']              = 'Kullan�c�';
$lang['Auth_Admin']             = 'Pano Y�neticisi';
$lang['Group_memberships']      = 'Grup �yelikleri';
$lang['Usergroup_members']      = 'Bu grubun �yeleri';

$lang['Forum_auth_updated']     = 'Forum izinleri g�ncellendi';
$lang['User_auth_updated']      = 'Kullan�c� izinleri g�ncellendi';
$lang['Group_auth_updated']     = 'Grup izinleri g�ncellendi';

$lang['Auth_updated']           = '�zinler g�ncellendi';
$lang['Click_return_userauth']  = 'Kullan�c� izinlerine d�nmek i�in %sburaya%s t�klay�n';
$lang['Click_return_groupauth'] = 'Grup izinlerine d�nmek i�in %sburaya%s t�klay�n';
$lang['Click_return_forumauth'] = 'Forum izinlerine d�nmek i�in %sburaya%s t�klay�n';


//
// Banning
//
$lang['Ban_control']            = 'Yasakl� Kontrol�';
$lang['Ban_explain']            = 'Buradan kullan�c�lar� yasaklama ayarlar�n� yapabilirsiniz. Bunu kullan�c� ad�n�, IP adresini ya da sunucu ad�n� banlayarak yapabilirsiniz. Bu, o kullan�c�n�n anasayfaya bile eri�imini engelleyecektir. Bir kullan�c�n�n ba�ka bir kullan�c� ad�yla kaydolmas�n� engellemek i�in o e-posta adresini yasaklayabilirsiniz. Unutmay�n ki bir e-posta adresini yasaklamak o kullan�c�n�n anasayfaya girmesini ya da ileti gondermesini engellemez. Bunun i�in kullan�c� ad� ya da IP - sunucu yasaklamal�s�n�z.';
$lang['Ban_explain_warn']       = 'Bir IP dizisinin yasaklanmas� ba�lang�� ve biti� IP\'leri aras�ndaki t�m IP\'leri yasaklayacakt�r. Veritaban�nda yer kaplamamas� i�in uygun oldu�u yerlerde joker kullan�lacakt�r. E�er ger�ekten bir IP dizisi girmek istiyorsan�z l�tfen onu k�sa tutun ya da tek tek IP\'leri girin.';

$lang['Select_username']        = 'Kullan�c� ad� se�in';
$lang['Select_ip']              = 'IP se�in';
$lang['Select_email']           = 'E-posta adresi se�in';

$lang['Ban_username']           = 'Kullan�c� yasaklama';
$lang['Ban_username_explain']   = 'Birden fazla kullan�c� yasaklamak istiyorsan�z web taray�c�n�za uygun klavye-fare kombinasyonunu kullan�n.';

$lang['Ban_IP']                 = 'IP ve Sunucu yasaklama';
$lang['IP_hostname']            = 'IP ve sunucu adresleri';
$lang['Ban_IP_explain']         = 'Birden fazla IP/sunucu yasaklamak i�in araya virg�l koyun. Bir IP dizisi belirtmek i�in ba�lang�� ve biti� aras�na - koyun. Joker olarak * kullan�n';

$lang['Ban_email']              = 'E-posta yasaklama';
$lang['Ban_email_explain']      = 'Birden fazla e-posta yasaklamak i�in virg�l kullan�n. Joker olarak * kullan�n, mesela *@hotmail.com';

$lang['Unban_username']         = 'Bir veya daha fazla kullan�c� ban� kald�rma';
$lang['Unban_username_explain'] = 'Birden fazla kullan�c�n�n yasa��n� kald�rmak istiyorsan�z web taray�c�n�za uygun klavye-fare kombinasyonunu kullan�n';

$lang['Unban_IP']               = 'IP/sunucu yasa�� kald�rma';
$lang['Unban_IP_explain']       = 'Birden fazla IP/sunucu yasa��n� kald�rmak istiyorsan�z web taray�c�n�za uygun klavye-fare kombinasyonunu kullan�n';

$lang['Unban_email']            = 'E-posta yasa�� kald�rma';
$lang['Unban_email_explain']    = 'Birden fazla e-posta yasa��n� kald�rmak istiyorsan�z web taray�c�n�za uygun klavye-fare kombinasyonunu kullan�n';

$lang['No_banned_users']        = 'Yasakl� kullan�c� yok';
$lang['No_banned_ip']           = 'Yasakl� IP yok';
$lang['No_banned_email']        = 'Yasakl� e-posta yok';

$lang['Ban_update_sucessful']   = 'Yasak listesi ba�ar�yla g�ncellendi';
$lang['Click_return_banadmin']  = 'Yasak kontrol�ne d�nmek i�in %sburaya%s t�klay�n';


//
// Configuration
//
$lang['General_Config']           = 'Genel Ayarlar';
$lang['Config_explain']           = 'A�a��daki form sitenizdeki genel ayarlar� yapmak i�in kullan�lacakt�r. Kullan�c� ve forum bazl� ayarlar i�in sol taraftaki ilgili linklere t�klay�n�z.';

$lang['Click_return_config']      = 'Genel ayarlara d�nmek i�in %sburaya%s t�klay�n';

$lang['General_settings']         = 'Genel Pano Ayarlar�';
$lang['Server_name']              = 'Alan ad�';
$lang['Server_name_explain']      = 'Bu panonun oldu�u sitenin alan ad�';
$lang['Script_path']              = 'Yaz�l�m yolu'; 
$lang['Script_path_explain']      = 'Alan ad�na g�re phpBB yaz�l�m�n�n bulundu�u yol';
$lang['Server_port']              = 'Sunucu portu';
$lang['Server_port_explain']      = 'Sunucunuzun �al��t��� port, genelde 80\'dir, sadece farkl�ysa de�i�tirin';
$lang['Site_name']                = 'Pano ismi';
$lang['Site_desc']                = 'Pano a��klamas�';
$lang['Board_disable']            = 'Panoyu kapat';
$lang['Board_disable_explain']    = 'Bu panoyu kullan�c�lara kapayacakt�r.';
$lang['Acct_activation']          = 'Hesap etkinle�tirme';
$lang['Acc_None']                 = 'Kapal�';
$lang['Acc_User']                 = 'Kullan�c�';
$lang['Acc_Admin']                = 'Pano Y�neticisi';

$lang['Abilities_settings']       = 'Kullan�c� ve Forum Genel Ayarlar�';
$lang['Max_poll_options']         = 'Maksimum anket se�ene�i say�s�';
$lang['Flood_Interval']           = 'Flood aral���';
$lang['Flood_Interval_explain']   = 'Kullan�c�n�n iki ileti aras�nda beklemesi gereken s�re [ saniye ]';
$lang['Board_email_form']         = 'Kullan�c�lar aras� e-posta';
$lang['Board_email_form_explain'] = 'Bu site arac�l��� ile kullan�c�lar�n birbirlerine e-posta g�ndermesini sa�lar';
$lang['Topics_per_page']          = 'Her sayfadaki konu say�s�';
$lang['Posts_per_page']           = 'Her sayfadaki ileti say�s�';
$lang['Hot_threshold']            = 'Pop�lerlik s�n�r�';
$lang['Default_style']            = 'Varsay�lan tema';
$lang['Override_style']           = 'Kullan�c� temas�n� g�zard� et';
$lang['Override_style_explain']   = 'Kullan�c�lar�n se�ti�i stili varsay�lan ile de�i�tirir';
$lang['Default_language']         = 'Varsay�lan dil';
$lang['Date_format']              = 'Saat format�';
$lang['System_timezone']          = 'Sistem zaman dilimi';
$lang['Enable_gzip']              = 'GZip s�k��t�rma';
$lang['Enable_prune']             = '�leti temizli�i';
$lang['Allow_HTML']               = 'HTML\'e izin ver';
$lang['Allow_BBCode']             = 'Bi�imlendirmeye (BBCode) izin ver';
$lang['Allowed_tags']             = '�zin verilen HTML etiketleri';
$lang['Allowed_tags_explain']     = 'Etiketleri virg�llerle ay�r�n';
$lang['Allow_smilies']            = '�fadelere izin ver';
$lang['Smilies_path']             = '�fade dizini';
$lang['Smilies_path_explain']     = 'phpBB ana dizinine g�re ifadeler dizini, �rn: images/smilies';
$lang['Allow_sig']                = '�mzaya izin ver';
$lang['Max_sig_length']           = 'Maksimum imza uzunlu�u';
$lang['Max_sig_length_explain']   = 'Kullan�c� imzalar�ndaki maksimum karakter say�s�';
$lang['Allow_name_change']        = 'Kullan�c� ad� de�i�ikli�ine izin ver';

// Avatar ayarlar�
$lang['Avatar_settings']             = 'Ki�isel Sembol Ayarlar�';
$lang['Allow_local']                 = 'Galeri sembolerini a�';
$lang['Allow_remote']                = 'Uzak sembolleri a�';
$lang['Allow_remote_explain']        = 'Ba�ka bir siteden link verilen semboller';
$lang['Allow_upload']                = 'Sembol g�ndermeyi a�';
$lang['Max_filesize']                = 'Maksimum sembol dosya b�y�kl���';
$lang['Max_filesize_explain']        = 'G�nderilen semboller i�in';
$lang['Max_avatar_size']             = 'Maksimum sembol boyutlar�';
$lang['Max_avatar_size_explain']     = '(Piksel olarak Y�kseklik x Geni�lik)';
$lang['Avatar_storage_path']         = 'Sembol dizini';
$lang['Avatar_storage_path_explain'] = 'phpBB ana dizinine g�re, �rn: images/avatars';
$lang['Avatar_gallery_path']         = 'Sembol galeri dizini';
$lang['Avatar_gallery_path_explain'] = 'phpBB ana dizinine g�re �nceden y�klenmi� sembollerin yeri, �rn: images/avatars/gallery';

// COPPA Ayarlar�
$lang['COPPA_settings']              = 'COPPA Ayarlar�';
$lang['COPPA_fax']                   = 'COPPA fax numaras�';
$lang['COPPA_mail']                  = 'COPPA e-posta adresi';
$lang['COPPA_mail_explain']          = 'Ebeveynlerin COPPA anla�mas�n� g�nderecekleri yer';

// E-posta ayarlar�
$lang['Email_settings']        = 'E-posta Ayarlar�';
$lang['Admin_email']           = 'Y�netici e-posta adresi';
$lang['Email_sig']             = 'E-posta imzas�';
$lang['Email_sig_explain']     = 'G�nderilecek t�m e-postalara bu yaz� eklenir';
$lang['Use_SMTP']              = 'E-posta i�in SMTP sunucusunu kullan';
$lang['Use_SMTP_explain']      = 'Yerel sendmail fonksiyonu yerine SMTP sunucusunu kullanmak i�in Evet\'i se�in';
$lang['SMTP_server']           = 'SMTP sunucu adresi';
$lang['SMTP_username']         = 'SMTP kullan�c� ad�';
$lang['SMTP_username_explain'] = 'Sadece SMTP sunucunuz kullan�c� ad� istiyorsa giriniz';
$lang['SMTP_password']         = 'SMTP parolas�';
$lang['SMTP_password_explain'] = 'Sadece SMTP sunucunuz parola istiyorsa giriniz';

$lang['Disable_privmsg']       = '�zel mesajla�ma';
$lang['Inbox_limits']          = 'Gelenler\'deki maksimum msj. say�s� ';
$lang['Sentbox_limits']        = 'Ula�anlar\'daki maksimum msj. say�s�';
$lang['Savebox_limits']        = 'Saklananlar\'daki maksimum msj. say�s�';

// Cookie Ayarlar�
$lang['Cookie_settings']         = '�erez (cookie) Ayarlar�';
$lang['Cookie_settings_explain'] = 'Bu �erez\'lerin browserlara nas�l g�nderildi�ini ayarlamak i�indir. Bir �ok durumda bu ilk halinde b�rak�lmal�d�r. Bunlar� de�i�tirmeniz gerekiyorsa dikkatli olun, yanl�� ayarlar kullan�c�lar�n oturum a�mas�n� engeller.';
$lang['Cookie_domain']           = '�erez alan ad�';
$lang['Cookie_name']             = '�erez ad�';
$lang['Cookie_path']             = '�erez yolu';
$lang['Cookie_secure']           = '�erez g�venli�i [ https ]';
$lang['Cookie_secure_explain']   = 'Sunucunuz SSL modunda �al���yorsa a��n, aksi halde a�may�n';
$lang['Session_length']          = 'Oturum uzunlu�u [ saniye ]';

// Visual Confirmation System
$lang['Visual_confirm']         = 'G�rsel kay�t do�rulamaya izin ver';
$lang['Visual_confirm_explain'] = 'Yeni kay�t olanlar�, resim ile g�sterilen bir kodu girmeye mecbur eder.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin']         = 'Otomatik oturum';
$lang['Allow_autologin_explain'] = 'Kullan�c�lar�n giri�te beni hat�rla se�ene�ini se�melerine izin ver.';
$lang['Autologin_time']          = 'Otomatik giri� ge�erlili�i ';
$lang['Autologin_time_explain']  = 'Panoyu ziyaret etmeyenler i�in otomatik giri�in ge�erlilik s�resi. Kapamak i�in s�f�r yap�n.';

// Search Flood Control - added 2.0.20
$lang['Search_Flood_Interval']         = 'Arama Flood Aral���';
$lang['Search_Flood_Interval_explain'] = 'Kullan�c�n�n iki arama aras�nda beklemesi gereken s�re [ saniye ]';

//
// Forum Management
//
$lang['Forum_admin']               = 'Forum Y�netimi';
$lang['Forum_admin_explain']       = 'Buradan kategori ve forumlar ekleyebilir, silebilir, de�i�tirebilirsiniz.';
$lang['Edit_forum']                = 'Forumu de�i�tir';
$lang['Create_forum']              = 'Yeni forum ekle';
$lang['Create_category']           = 'Yeni kategori ekle';
$lang['Remove']                    = '��kar';
$lang['Action']                    = 'Eylem';
$lang['Update_order']              = 'S�ralamay� g�ncelle';
$lang['Config_updated']            = 'Ayarlar Ba�ar�yla G�ncellendi';
$lang['Edit']                      = 'De�i�tir';
$lang['Delete']                    = 'Sil';
$lang['Move_up']                   = 'Yukar� ta��';
$lang['Move_down']                 = 'A�a�� ta��';
$lang['Resync']                    = 'Yenile';
$lang['No_mode']                   = 'Hi�bir y�ntem se�ilmedi';
$lang['Forum_edit_delete_explain'] = 'A�a��daki form panonuzdaki genel ayarlar� yapmak i�in kullan�lacakt�r. Kullan�c� ve forum bazl� ayarlar i�in sol taraftaki ilgili linklere t�klay�n�z.';

$lang['Move_contents']             = 'T�m i�eri�i ta��';
$lang['Forum_delete']              = 'Forumu sil';
$lang['Forum_delete_explain']      = 'A�a��daki form ile forum ya da kategori silebilir, i�eriklerini istedi�iniz yere ta��yabilirsiniz';

$lang['Status_locked']             = 'Kilitli';
$lang['Status_unlocked']           = 'Kilitli de�il';
$lang['Forum_settings']            = 'Genel Forum Ayarlar�';
$lang['Forum_name']                = 'Forum ad�';
$lang['Forum_desc']                = 'A��klama';
$lang['Forum_status']              = 'Forum durumu';
$lang['Forum_pruning']             = 'Otomatik �leti Temizleme';

$lang['prune_freq']                = 'Her x g�nde bir forumu kontrol et';
$lang['prune_days']                = 'x g�n i�inde cevap gelmeyen konular� sil';
$lang['Set_prune_data']            = '�leti temizli�ini a�t���n�z halde ka� g�nde bir ileti temizli�i yap�lacag�n� se�mediniz';

$lang['Move_and_Delete']           = 'Ta�� ve Sil';

$lang['Delete_all_posts']          = 'T�m iletileri sil';
$lang['Nowhere_to_move']           = 'Ta��nacak yer yok';

$lang['Edit_Category']             = 'Kategoriyi de�i�tir';
$lang['Edit_Category_explain']     = 'Bir kategorinin ismini de�i�tirmek i�in bu formu kullan�n.';

$lang['Forums_updated']            = 'Forum ve Kategori bilgisi ba�ar�yla g�ncellendi';
$lang['Must_delete_forums']        = 'Bu kategoriyi silmeden �nce i�indeki t�m forumlar� silmelisiniz';

$lang['Click_return_forumadmin']   = 'Forum y�netim paneline d�nmek i�in %sburaya%s t�klay�n';


//
// Smiley Management
//
$lang['smiley_title']            = '�fade Kontrol Paneli';
$lang['smile_desc']              = 'Buradan kullan�c�lara sunulan ifadeleri ekleyebilir kald�rabilir ya da de�i�tirebilirsiniz.';

$lang['smiley_config']           = '�fade Ayarlar�';
$lang['smiley_code']             = '�fade Kodu';
$lang['smiley_url']              = '�fade Resim Dosyas�';
$lang['smiley_emot']             = '�fade A��klamas�';
$lang['smile_add']               = 'Yeni ifade ekle';
$lang['Smile']                   = '�fade';
$lang['Emotion']                 = 'A��klama';

$lang['Select_pak']              = 'Paket (.pak) dosyas� se�';
$lang['replace_existing']        = 'Var olan ifadeyi bununla de�i�tir';
$lang['keep_existing']           = 'Var olan ifadeyi koru';

$lang['smiley_import_inst']      = '�fade dosyas�n� zip ile a�mal� ve uygun ifade dizinine g�ndermelisiniz. Sonra buradan do�ru se�enekleri bularak y�kleme i�lemini ger�ekle�tiriniz.';
$lang['smiley_import']           = '�fade Paketi Kurma';
$lang['choose_smile_pak']        = '�fade Paket Dosyas� (.pak) Se�in';
$lang['import']                  = '�fade Paketi Kur';
$lang['smile_conflicts']         = '�kilemlerde ne yap�lmal�?';
$lang['del_existing_smileys']    = 'Kurumdan �nce var olan ifadeleri sil';
$lang['import_smile_pack']       = '�fade Paketi Kur';
$lang['export_smile_pack']       = '�fade Paketi Yarat';
$lang['export_smiles']           = 'Var olan ifadelerinizden bir paket yaratmak i�in, smiles.pak dosyas�n� indirmek i�in %sburaya%s t�klay�n. .pak uzant�s�n� korumak suretiyle bu dosyan�n ismini de�i�tirin. Sonra bu .pak dosyas�n� ve ilgili ifade resimlerini tek bir zip dosyas� i�inde s�k��t�r�n.';

$lang['smiley_add_success']      = '�fade ba�ar�yla eklendi';
$lang['smiley_edit_success']     = '�fade ba�ar�yla g�ncellendi';
$lang['smiley_import_success']   = '�fade Paketi kurulumu ba�ar�ld�!';
$lang['smiley_del_success']      = '�fade ba�ar�yla silindi';
$lang['Click_return_smileadmin'] = '�fade kontrol paneline d�nmek i�in %sburaya%s t�klay�n';
$lang['Confirm_delete_smiley']   = 'Bu ifadeyi silmek istedi�inize emin misiniz?';


//
// User Management
//
$lang['User_admin']             = 'Kullan�c� Y�netimi';
$lang['User_admin_explain']     = 'Buradan kullan�c�lar�n�z�n ayarlar�n� de�i�tirebilirsiniz. �zinleri de�i�tirmek i�in soldan �zinler linkini kullan�n.';

$lang['Look_up_user']           = 'Kullan�c�y� incele';

$lang['Admin_user_fail']        = 'Kullan�c�n�n bilgileri g�ncellenemedi.';
$lang['Admin_user_updated']     = 'Kullan�c� bilgileri ba�ar�yla g�ncellendi.';
$lang['Click_return_useradmin'] = 'Kullan�c� Y�netim Paneline d�nmek i�in %sburaya%s t�klay�n';

$lang['User_delete']            = 'Bu kullan�c�y� sil';
$lang['User_delete_explain']    = 'Kullan�c�y� silmek i�in buray� i�aretleyin. Bu d�n��� olmayan bir i�lemdir.';
$lang['User_deleted']           = 'Kullan�c� ba�ar�yla silindi.';

$lang['User_status']            = 'Bu kullan�c� �u anda aktif';
$lang['User_allowpm']           = '�zel mesaj atabilir';
$lang['User_allowavatar']       = 'Ki�isel sembol kullanabilir';

$lang['Admin_avatar_explain']   = 'Burdan kullan�c�n�n �u andaki ki�isel sembol�n� silebilir ya da de�i�tirebilirsiniz.';
$lang['User_special']           = '�zel y�netici alanlar�';
$lang['User_special_explain']   = 'Bu alanlar kullan�c�lar taraf�ndan de�i�tirilemez. Buradan b�t�n kullan�c�lara verilmeyen ayarlar� yapabilirsiniz.';


//
// Group Management
//
$lang['Group_administration']     = 'Grup Y�netimi';
$lang['Group_admin_explain']      = 'Burdan gruplar�n�z� yaratabilir, silebilir ya da de�i�tirebilirsiniz. Grup y�neticilerini, grup durumlar�n�, grup isimlerini de�i�tirebilirsiniz';
$lang['Error_updating_groups']    = 'Gruplar g�ncellenirken bir hata olu�tu';
$lang['Updated_group']            = 'Grup ba�ar�yla g�ncellendi';
$lang['Added_new_group']          = 'Yeni grup ba�ar�yla yarat�ld�';
$lang['Deleted_group']            = 'Grup ba�ar�yla silindi';
$lang['New_group']                = 'Yeni grup yarat';
$lang['Edit_group']               = 'Grubu de�i�tir';
$lang['group_name']               = 'Grup ad�';
$lang['group_description']        = 'Grup a��klamas�';
$lang['group_moderator']          = 'Grup y�neticisi';
$lang['group_status']             = 'Grup durumu';
$lang['group_open']               = 'A��k grup';
$lang['group_closed']             = 'Kapal� grup';
$lang['group_hidden']             = 'Gizli grup';
$lang['group_delete']             = 'Grubu sil';
$lang['group_delete_check']       = 'Bu grubu sil';
$lang['submit_group_changes']     = 'De�i�iklikleri g�nder';
$lang['reset_group_changes']      = 'De�i�iklikleri sil';
$lang['No_group_name']            = 'Bu grup i�in bir isim belirtmelisiniz';
$lang['No_group_moderator']       = 'Bu grup i�in bir y�netici belirtmelisiniz';
$lang['No_group_mode']            = 'Bu grup i�in bir mod belirmelisiniz, a��k ya da kapal�';
$lang['No_group_action']          = 'Bir g�rev se�ilmemi�';
$lang['delete_group_moderator']   = 'Eski grup y�neticisi sil';
$lang['delete_moderator_explain'] = 'Grup y�neticisi de�i�tirirken, eski y�neticiyi gruptan atmak i�in buray� i�aretleyin. Aksi takdirde kullan�c� grubun normal bir �yesi olacakt�r.';
$lang['Click_return_groupsadmin'] = 'Grup y�netimine d�nmek i�in %sburaya%s t�klay�n.';
$lang['Select_group']             = 'Grup se�';
$lang['Look_up_group']            = 'Grubu incele';


//
// Prune Administration
//
$lang['Forum_Prune']             = '�leti Temizli�i';
$lang['Forum_Prune_explain']     = 'Bu form ile se�ti�iniz g�n say�s� i�inde cevap gelmeyen konular� silebilirsiniz. E�er bir say� girmezseniz t�m iletiler silinir. ��inde anket olan iletileri ya da duyurular� silmeyecektir. Onlar� tek tek elle silmek zorundas�n�z.';
$lang['Do_Prune']                = 'Temizlik Yap';
$lang['All_Forums']              = 'T�m forumlar';
$lang['Prune_topics_not_posted'] = 'Bu kadar g�n i�inde cevap gelmemi� iletileri sil';
$lang['Topics_pruned']           = 'Silinen konular';
$lang['Posts_pruned']            = 'Silinen iletiler';
$lang['Prune_success']           = '�leti temizli�i ba�ar�l�!';


//
// Word censor
//
$lang['Words_title']            = 'Kelime Sans�rleme';
$lang['Words_explain']          = 'Buradan otomatik olarak sans�rlenecek kelimeleri ekleyebilir, silebilir, de�i�tirebilirsiniz. Ayr�ca insanlar bu kelimeleri kullan�c� adlar�nda da kullanamazlar. Joker olarak * kullanabilirsiniz, �rn: *siklo* ansiklopedi\'yi, siklo* siklon\'u, *siklo dersiklo\'yu sans�rleyecektir.';
$lang['Word']                   = 'Kelime';
$lang['Edit_word_censor']       = 'Sans�rl� kelimeyi de�i�tir';
$lang['Replacement']            = 'Yerine konulacak';
$lang['Add_new_word']           = 'Yeni kelime ekle';
$lang['Update_word']            = 'Sans�r� g�ncelle';

$lang['Must_enter_word']        = 'Bir kelime ve onun yerine girilecek kelimeyi girmelisiniz';
$lang['No_word_selected']       = 'De�i�tirmek i�in bir kelime se�mediniz';

$lang['Word_updated']           = 'Se�ilen sans�rl� kelime ba�ar�yla g�ncellendi';
$lang['Word_added']             = 'Sans�rl� kelime ba�ar�yla eklendi';
$lang['Word_removed']           = 'Se�ilen sans�rl� kelime ba�ar�yla silindi';

$lang['Click_return_wordadmin'] = 'Kelime sans�r� y�netim paneline d�nmek i�in %sburaya%s t�klay�n';
$lang['Confirm_delete_word']    = 'Bu kelime sans�r�n� silmek istedi�inize emin misiniz?';


//
// Mass Email
//
$lang['Mass_email_explain']     = 'Buradan t�m kullan�c�lar�n�za ya da bir gruba dahil t�m kullan�c�lara e-posta g�nderebilirsiniz. Bu y�netici e-postas�na at�lan mesaj�n gizli karbon kopyalar�n�n kullan�c�lara g�nderilmesi yoluyla yap�lacak. E�er geni� bir gruba g�nderiyorsan�z l�tfen stop butonuna basmay�n ve sayfan�n y�klenmesini sab�rl� bir �ekilde bekleyin. B�y�k bir toptan e-posta g�nderiminin yava� olmas� do�ald�r, yaz�l�m g�revini tamamlad���nda size haber verilecektir.';
$lang['Compose']                = 'Olu�tur';
$lang['Recipients']             = 'Al�c�lar';
$lang['All_users']              = 'T�m Kullan�c�lar';
$lang['Email_successfull']      = 'Mesaj�n�z G�nderilmi�tir';
$lang['Click_return_massemail'] = 'Toptan e-posta formuna d�nmek i�in %sburaya%s t�klay�n�z';


//
// Ranks admin
//
$lang['Ranks_title']        = 'Seviye Y�netimi';
$lang['Ranks_explain']      = 'Buradan kullan�c�lar�n�za verilecek seviyeler yaratabilir, silebilir ve de�i�tirebilirsiniz. Kullan�c� y�netiminden kullan�c�lara verilebilecek �zel seviyeler de yaratabilirsiniz.';

$lang['Add_new_rank']       = 'Yeni seviye ekle';

$lang['Rank_title']         = 'Seviye Ad�';
$lang['Rank_special']       = '�zel Seviye';
$lang['Rank_minimum']       = 'Minimum �leti Say�s�';
$lang['Rank_maximum']       = 'Maksimum �leti Say�s�';
$lang['Rank_image']         = 'Seviye resmi (phpBB ana dizinine g�re)';
$lang['Rank_image_explain'] = 'Seviye i�in ufak bir resim kullan�n';

$lang['Must_select_rank']   = 'Bir seviye se�melisiniz';
$lang['No_assigned_rank']   = 'Hi� �zel seviye atanmam��';

$lang['Rank_updated']       = 'Seviye ba�ar�yla g�ncellendi';
$lang['Rank_added']         = 'Seviye ba�ar�yla eklendi';
$lang['Rank_removed']       = 'Seviye ba�ar�yla silindi';
$lang['No_update_ranks']    = 'Bu seviye ba�ar�yla silindi, ancak bu seviyeye sahip olan kullan�c�lar�n ayarlar� de�i�medi. Bu kullan�c�lar�n hesaplar�n� kendiniz g�ncellemelisiniz';

$lang['Click_return_rankadmin'] = 'Seviye y�netimine d�nmek i�in %sburaya%s t�klay�n';
$lang['Confirm_delete_rank']    = 'Bu seviyeyi silmek istedi�inize emin misiniz?';


//
// Disallow Username Admin
//
$lang['Disallow_control']        = 'Yasakl� Kullan�c� �smi Kontrol�';
$lang['Disallow_explain']        = 'Burada kullan�lmamas� gereken kullan�c� adlar�n� ayarlayabilirsiniz. Joker olarak * kullanabilirsiniz. Kay�t olmu� bir kullan�c� ad�n� yasaklayamazs�n�z, bunu yapmak i�in ilk �nce o kullan�c�y� silmelisiniz';

$lang['Delete_disallow']         = 'Sil';
$lang['Delete_disallow_title']   = 'Yasakl� bir kullan�c� ad�n� kald�r';
$lang['Delete_disallow_explain'] = 'Buradan yasakl� bir kullan�c� ad�n� se�ip sil butonuna basarak yasa�� kald�rabilirsiniz';

$lang['Add_disallow']            = 'Ekle';
$lang['Add_disallow_title']      = 'Yasakl� bir kullan�c� ad� ekle';
$lang['Add_disallow_explain']    = 'Joker olarak * kullanabilirsiniz';

$lang['No_disallowed']           = 'Yasakl� kullan�c� ad� yok';

$lang['Disallowed_deleted']      = 'Yasakl� kullan�c� ad� ba�ar�yla kald�r�ld�';
$lang['Disallow_successful']     = 'Yasakl� kullan�c� ad� ba�ar�yla eklendi';
$lang['Disallowed_already']      = 'Girdi�iniz ad yasaklanamad�. Ya listede var, ya sans�r listesinde var, ya da b�yle bir kullan�c� mevcut';

$lang['Click_return_disallowadmin'] = 'Yasakl� kullan�c� ad� kontrol paneline d�nmek i�in %sburaya%s t�klay�n';


//
// Styles Admin
//
$lang['Styles_admin']          = 'Stil Y�netimi';
$lang['Styles_explain']        = 'Buradan kullan�c�lar�n�za sundu�unuz temalar�n�z� y�netebilirsiniz';
$lang['Styles_addnew_explain'] = 'Burada t�m tema\'lar�n�z listelenmi�tir. Bunlar hen�z veritaban�na kaydedilmemi�tir. Kaydetmek i�in birini se�in ve Y�kle tu�una bas�n';

$lang['Select_template'] = 'Bir tema se�in';

$lang['Style']    = 'Stil';
$lang['Template'] = 'Tema';
$lang['Install']  = 'Y�kle';
$lang['Download'] = '�ndir';

$lang['Edit_theme']         = 'Tema\'y� de�i�tir';
$lang['Edit_theme_explain'] = 'A�a��daki form ile se�ti�iniz tema\'y� de�i�tirebilirsiniz';

$lang['Create_theme']         = 'Tema yarat';
$lang['Create_theme_explain'] = 'A�a��daki form ile se�ilen tema i�in yeni bir stil yarat�n. Renkleri girerken # i�aretini kullanmay�n. �rn: CCCCCC do�ru, #CCCCCC yanl��';

$lang['Export_themes']  = 'Tema\'y� kaydet';
$lang['Export_explain'] = 'Bu panel ile se�ti�iniz tema i�in bir stil dosyas� yarat�p kaydedebileceksiniz. A�a��dan temay� se�in ve yaz�l�m onun i�in gerekli tema dosyas�n� yarat�p o dizine kaydetmeyi deneyecektir. E�er kaydedemezse size indirme se�ene�ini sunacakt�r. Yaz�l�m\'�n dosyay� kaydedebilmesi i�in o dizine yazma izninin verilmi� olmas� gerekir. Ayr�nt�l� bilgi i�in PhpBB2 kullanma k�lavuzuna bak�n.';

$lang['Theme_installed']  = 'Se�ilen tema ba�ar�yla y�klendi'; // eklendi
$lang['Style_removed']    = 'Se�ilen tema veritaban�ndan ba�ar�yla silindi. Bu tema\'y� sisteminizden tamam�yla silmek i�in dosylar�n� da silmelisiniz.';
$lang['Theme_info_saved'] = 'Se�ilen tema i�in stil bilgisi kaydedildi.';
$lang['Theme_updated']    = 'Se�ilen tema g�ncellendi. �imdi yeni tema ayarlar�n� kaydetmelisiniz';
$lang['Theme_created']    = 'Tema yarat�ld�. �imdi bu tema\'y� sonradan kullanmak ya da ta��mak i�in kaydetmelisiniz';

$lang['Confirm_delete_style'] = 'Bu stili silmek istedi�inize emin misiniz?';

$lang['Download_theme_cfg']  = 'Tema bilgi dosyas� yaz�lamad�. Dosyay� indirmek i�in a�a��daki butona t�klay�n�z. Sonra onu ilgili tema dosyalar�n�n bulundu�u dizine g�ndermelisiniz. Sonra isterseniz dosyalar� da��t�m ya da ba�ka bir ama�la paketleyebilirsiniz';
$lang['No_themes']           = 'Se�ilen teman�n atanm�� hi� stili yok. Sol taraftaki Stil Y�netimi\'nden Yarat\'a t�klay�n�z';
$lang['No_template_dir']     = 'Tema dizini a��lamad�. Web sunucusu taraf�ndan okunam�yor olabilir ya da b�yle bir dizin yok';
$lang['Cannot_remove_style'] = 'Bu stil �u anda varsay�lan stil oldu�u i�in silinemez. Varsay�lan stili de�i�tirip tekrar deneyin.';
$lang['Style_exists']        = 'Se�ilen stil ad� kullan�mda, l�tfen ba�ka bir isim se�iniz.';

$lang['Click_return_styleadmin'] = 'Stil y�netimine d�nmek i�in %sburaya%s t�klay�n';

$lang['Theme_settings'] = 'Tema Ayarlar�';
$lang['Theme_element']  = 'Tema Elemanlar�';
$lang['Simple_name']    = '�smi';
$lang['Value']          = 'De�er';
$lang['Save_Settings']  = 'Ayarlar� Kaydet';

$lang['Stylesheet']         = 'CSS Stil �ablonu';
$lang['Stylesheet_explain'] = 'Bu tema i�in kullan�lacak CSS �ablonunun ad�.';
$lang['Background_image']   = 'Arkaplan Resmi';
$lang['Background_color']   = 'Arkaplan Rengi';
$lang['Theme_name']  = 'Tema Ad�';
$lang['Link_color']  = 'Link Rengi';
$lang['Text_color']  = 'Yaz� Rengi';
$lang['VLink_color'] = 'Ziyaret Edilmi� Link Rengi';
$lang['ALink_color'] = 'Aktif Link Rengi';
$lang['HLink_color'] = '�st�ne Gelinen Link Rengi';
$lang['Tr_color1'] = 'Tablo Sat�r Rengi 1';
$lang['Tr_color2'] = 'Tablo Sat�r Rengi 2';
$lang['Tr_color3'] = 'Tablo Sat�r Rengi 3';
$lang['Tr_class1'] = 'Tablo Sat�r S�n�f� 1';
$lang['Tr_class2'] = 'Tablo Sat�r S�n�f� 2';
$lang['Tr_class3'] = 'Tablo Sat�r S�n�f� 3';
$lang['Th_color1'] = 'Tablo Konu Rengi 1';
$lang['Th_color2'] = 'Tablo Konu Rengi 2';
$lang['Th_color3'] = 'Tablo Konu Rengi 3';
$lang['Th_class1'] = 'Tablo Konu S�n�f� 1';
$lang['Th_class2'] = 'Tablo Konu S�n�f� 2';
$lang['Th_class3'] = 'Tablo Konu S�n�f� 3';
$lang['Td_color1'] = 'Tablo H�cre Rengi 1';
$lang['Td_color2'] = 'Tablo H�cre Rengi 2';
$lang['Td_color3'] = 'Tablo H�cre Rengi 3';
$lang['Td_class1'] = 'Tablo H�cre S�n�f� 1';
$lang['Td_class2'] = 'Tablo H�cre S�n�f� 2';
$lang['Td_class3'] = 'Tablo H�cre S�n�f� 3';
$lang['fontface1'] = 'Karakter Tipi 1';
$lang['fontface2'] = 'Karakter Tipi 2';
$lang['fontface3'] = 'Karakter Tipi 3';
$lang['fontsize1'] = 'Karakter B�y�kl��� 1';
$lang['fontsize2'] = 'Karakter B�y�kl��� 2';
$lang['fontsize3'] = 'Karakter B�y�kl��� 3';
$lang['fontcolor1'] = 'Karakter Rengi 1';
$lang['fontcolor2'] = 'Karakter Rengi 2';
$lang['fontcolor3'] = 'Karakter Rengi 3';
$lang['span_class1'] = 'Span S�n�f� 1';
$lang['span_class2'] = 'Span S�n�f� 2';
$lang['span_class3'] = 'Span S�n�f� 3';
$lang['img_poll_size'] = 'Anket resmi b�y�kl��� [px]';
$lang['img_pm_size']   = '�zel mesajlar durum resmi b�y�kl��� [px]';


//
// Install Process
//
$lang['Welcome_install']  = 'phpBB Y�klemesine Ho�geldiniz';
$lang['Initial_config']   = 'Genel Ayarlar';
$lang['DB_config']        = 'Veritaban� Ayarlar�';
$lang['Admin_config']     = 'Y�netici Ayarlar�';
$lang['continue_upgrade'] = 'Config dosyas�n� bilgisayar�nza indirdikten sonra \'G�ncellemeye Devam\' d��mesine basarak g�ncelleme i�lemine devam edebilirsiniz.';
$lang['upgrade_submit']   = 'G�ncellemeye Devam';

$lang['Installer_Error']  = 'Y�kleme s�ras�nda bir problem olu�tu';
$lang['Previous_Install'] = '�nceden y�klenmi� bir phpBB bulundu';
$lang['Install_db_error'] = 'Veritaban�n� g�ncellerken bir hata olu�tu';

$lang['Re_install']       = '�nceden y�kledi�iniz phpBB halen aktif. <br /><br />E�er phpBB\'yi yeniden y�klemek istiyorsan�z a�a��daki evet d��mesine bas�n. Bunu yaparken bunun �u andaki t�m verileri silece�ini, yedek yap�lmayaca��n� unutmay�n! Y�netici kullan�c� ad� ve parolan�z yeniden olu�turulacakt�r; ba�ka hi�bir ayar�n�z korunmayacakt�r. <br /><br />Evet\'e basmadan �nce iyi d���n�n!';
$lang['Inst_Step_0']      = 'phpBB\'yi se�ti�iniz i�in te�ekk�r ederiz. Y�kleme i�lemini bitirmek i�in l�tfen a�a��daki bo�luklar� doldurunuz. Kullanaca��n�z veritaban�n� �nceden yaratm�� olman�z gerekmektedir. ODBC kullanan bir veritaban�na y�kleme yapacaksan�z, (�rn: MS Access) devam etmeden �nce bir DSN yaratmal�s�n�z.';

$lang['Start_Install']  = 'Y�klemeye ba�la';
$lang['Finish_Install'] = 'Y�klemeyi bitir';

$lang['Default_lang']   = 'Panonun varsay�lan dili';
$lang['DB_Host']        = 'Veritaban� sunucu adresi';
$lang['DB_Name']        = 'Veritaban� ad�';
$lang['DB_Username']    = 'Veritaban� kullan�c� ad�';
$lang['DB_Password']    = 'Veritaban� parolas�';
$lang['Database']       = 'Veritaban�n�z';
$lang['Install_lang']   = 'Y�kleme dilini se�in';
$lang['dbms']           = 'Veritaban� t�r�';
$lang['Table_Prefix']   = 'Veritaban� tablo �nadlar�';
$lang['Admin_Username'] = 'Y�netici kullan�c� ad�';
$lang['Admin_Password'] = 'Y�netici parolas�';
$lang['Admin_Password_confirm'] = 'Y�netici parolas� [ onay ]';

$lang['Inst_Step_2'] = 'Y�netici kullan�c� olu�turuldu. Bu noktada temel y�kleme tamamland�. �imdi yeni y�kledi�iniz panoyu y�netebilece�iniz bir sayfaya y�nlendirileceksiniz. Genel ayarlar� kontrol edin ve kendi ihtiya�lar�n�z do�rultusunda ayarlarlay�n. phpBB\'yi se�ti�iniz i�in te�ekk�r ederiz.';

$lang['Unwriteable_config'] = '�u anda config dosyas�na yaz�lam�yor. A�a��daki butona bas�nca bu config dosyas�n�n bir kopyas� bilgisayar�n�za indirilecektir. Bu dosyay� phpBB ile ayn� dizin i�ine g�ndermelisiniz. Bunu yapt�ktan sonra bir �nceki form\'la yarat�lan y�netici ad� ve parolas�n� kullanarak y�netim paneline girmeli ve ayarlar� yapmal�s�n�z. (Oturum a�t�ktan sonra ekran�n alt�nda bir link g�r�necektir). phpBB\'yi se�ti�iniz i�in te�ekk�r ederiz.';
$lang['Download_config']    = 'Config dosyas�n� indir';

$lang['ftp_choose']      = '�ndirme Metodunu Se�in';
$lang['ftp_option']      = '<br />PHP\'nin bu s�r�m�nde ftp komutlar�na izin verildi�i i�in direk config dosyas�n� yerine ftp ile g�nderebilirsiniz.';
$lang['ftp_instructs']   = 'Config dosyas�n� phpBB\'nin bulundu�u yere otomatik olarak ftp ile g�ndermeyi se�tiniz.  L�tfen a�a��daki bilgileri doldurunuz';
$lang['ftp_info']        = 'FTP bilgilerinizi girin';
$lang['Attempt_ftp']     = 'FTP ile g�nderme deneniyor';
$lang['Send_file']       = 'Bana sadece dosyay� g�nder ve ben onu kendim FTP\'liyim';
$lang['ftp_path']        = 'phpBB FTP yolu';
$lang['ftp_username']    = 'FTP Kullan�c� Ad�';
$lang['ftp_password']    = 'FTP Parolas�';
$lang['Transfer_config'] = 'Transfere ba�la';
$lang['NoFTP_config']    = 'FTP i�lemi ba�ar�s�z. L�tfen config doyas�n� indirip kendiniz g�nderiniz';

$lang['Install'] = 'Y�kle';
$lang['Upgrade'] = 'G�ncelle';

$lang['Install_Method']  = 'Y�kleme metodu';
$lang['Install_No_Ext']  = 'Sunucu\'nuz se�ti�iniz veritaban� t�r�n� desteklemiyor';
$lang['Install_No_PCRE'] = 'phpBB, php i�in \'Perl-Compatible Regular Expressions\' mod�l�ne ihtiya� duymaktad�r. Kulland���n�z php ayarlar� bunu desteklememektedir';

//
// Version Check
//
$lang['Version_up_to_date']              = 'Son phpBB2 s�r�m�n� kullan�yorsunuz. �nerilen g�ncelleme bulunmamaktad�r.';
$lang['Version_not_up_to_date']          = 'Kulland���n�z phpBB2 s�r�m� g�ncel <b>de�il</b>. G�ncel s�r�me sahip olmak i�in phpbb.com sitesinin <a href="http://www.phpbb.com/downloads.php" title="http://www.phpbb.com/downloads.php" target="_new">phpbb indirme</a> b�l�m�n� ziyaret ediniz.';
$lang['Latest_version_info']             = 'Mevcut olan en yeni phpBB s�r�m�: <b>%s</b>. ';
$lang['Current_version_info']            = 'Kulland���n�z phpBB s�r�m�: <b>%s</b>.';
$lang['Connect_socket_error']            = 'phpBB sitesi ile ba�lant� kurulamad�. Bildirilen hata:<br />%s';
$lang['Socket_functions_disabled']       = 'Soket fonksiyonlar�nda sorun olu�tu.';
$lang['Mailing_list_subscribe_reminder'] = 'En son phpBB g�ncellemelerinden haberdar olmak istiyorsan�z, l�tfen <a href="http://www.phpbb.com/support/" target="_new"> phpBB Haber Servisine</a> abone olun.';
$lang['Version_information']             = 'S�r�m Bilgisi';

//
// Login attempts configuration
//
$lang['Max_login_attempts']         = '�zin verilen oturum a�ma denemesi';
$lang['Max_login_attempts_explain'] = 'Pano i�in izin verilen oturum a�ma deneme say�s�.';
$lang['Login_reset_time']           = 'Oturum a�ma kilit zaman�';
$lang['Login_reset_time_explain']   = '�zin verilen oturum a�ma deneme say�s� a��ld�ktan sonra, bir sonraki oturum a�ma izni i�in mecburi beklenmesi gereken dakika.';

//
// That's all Folks!
// -------------------------------------------------

?>