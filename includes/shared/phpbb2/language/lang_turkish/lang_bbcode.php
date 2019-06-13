<?php
/** 
*
* lang_bbcode [Turkish]
*
* @package language
* @version $Id: lang_bbcode.php,v 1.2 2007/03/23 21:22:22 angelside Exp $
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
 
// 
// To add an entry to your BBCode guide simply add a line to this file in this format:
// $faq[] = array("question", "answer");
// If you want to separate a section enter $faq[] = array("--","Block heading goes here if wanted");
// Links will be created automatically
//
// DO NOT forget the ; at the end of the line.
// Do NOT put double quotes (") in your BBCode guide entries, if you absolutely must then escape them ie. \"something\"
//
// The BBCode guide items will appear on the BBCode guide page in the same order they are listed in this file
//
// If just translating this file please do not alter the actual HTML unless absolutely necessary, thanks :)
//
// In addition please do not translate the colours referenced in relation to BBCode any section, if you do
// users browsing in your language may be confused to find they're BBCode doesn't work :D You can change
// references which are 'in-line' within the text though.
//

$faq[] = array("--","Giriþ");
$faq[] = array("Biçim Kodlarý nedir?", "Biçim Kodlarý, HTML'in özel bir uygulamasýdýr. Forumlara yazdýðýnýz iletilerde Biçim Kodlarý kullanabilme imkanýný pano yöneticisi belirler. Ayrýca ileti gönderme formundaki seçenekler sayesinde dilediðiniz iletilerde Biçim Kodlarý'ný iptal etmeniz mümkündür. Biçim Kodlarý, HTML'e benzer tarzdadýr fakat etiketler &lt; ve &gt; yerine köþeli parantez içine alýnýr. Ayrýca nelerin nasýl görüntülendiði daha iyi kontrol edilebilir. Ýletilerinize Biçim Kodlarý eklemek için ileti gövdesi üzerinde bulunan araç çubuðunu kullanmanýz iþi çok daha kolaylaþtýrýr (araç çubuðu görünümü kullandýðýnýz tema'ya baðlýdýr). Ayrýca alttaki rehberi faydalý bulabilirsiniz.");

$faq[] = array("--","Metin Biçimini Deðiþtirme");
$faq[] = array("Kalýn, eðik veya altýçizili yazýlar nasýl yazýlýr?", "Biçim Kodlarý, metnin temel biçimlemesini kolayca deðiþtirmenizi saðlayan etiketlere sahiptir. Bunu gerçekleþtirmek için þu yöntemler kullanýlýr: <ul><li>Metnin belirli bir kýsmýný kalýn harflerle görüntülemek için <b>[b][/b]</b> etiketleri içine alýn, örn. <br /><br /><b>[b]</b>Merhaba<b>[/b]</b><br /><br />yazýlýnca <b>Merhaba</b> olarak görüntülenir.</li><li>Altýçizili yazýlar için <b>[u][/u]</b> kullanýn, örn.: <br /><br /><b>[u]</b>Günaydýn<b>[/u]</b><br /><br />yazýlýnca <u>Günaydýn</u> olarak görüntülenir.</li><li>Metni eðik yazmak için <b>[i][/i]</b> kullanýn, örn. <br /><br />Çok <b>[i]</b>Büyük!<b>[/i]</b><br /><br />yazýlýnca sonuç Çok <i>Büyük!</i> olur.</li></ul>");
$faq[] = array("Yazýlarýn rengi veya boyutu nasýl deðiþtirilir?", "Yazýlarýn renk veya boyutunu deðiþtirmek için alttaki etiketler kullanýlabilir. Elde edilen sonuç, kullanýlan web tarayýcýsý ve bilgisayar sistemine göre deðiþebilir, aklýnýzda bulunsun: <ul><li>Yazýlarýn rengi, metni <b>[color=][/color]</b> etiketleri içine alarak deðiþtirilir. Belirli ingilizce renk isimlerini (örn. red, blue, yellow vs.) veya alternatif olarak 16 tabanlý sayý sisteminde (HEX) kodlanmýþ üç rakamlý renk kodunu yazabilirsiniz (örn. #FFFFFF, #000000). Metni örneðin kýrmýzý harflerle yazmak için:<br /><br /><b>[color=red]</b>Merhaba!<b>[/color]</b><br /><br />veya<br /><br /><b>[color=#FF0000]</b>Merhaba!<b>[/color]</b><br /><br />ayný þekilde görüntülenir: <span style=\"color:red\">Merhaba!</span></li><li>Karakterlerin boyutunu benzer þekilde <b>[size=][/size]</b> kullanarak deðiþtirebilirsiniz. Bu etiket kullandýðýnýz tema'ya baðlýdýr. Karakterlerin pixel olarak boyutunu yazmanýz önerilir. Bu rakam 1 ile baþlayýp (gözle görülmeyecek kadar küçük), en fazla 29 (çok büyük) olabilir. Örnek:<br /><br /><b>[size=9]</b>KÜÇÜK<b>[/size]</b><br /><br />genelde þu sonucu verir: <span style=\"font-size:9px\">KÜÇÜK</span><br /><br />öte yandan:<br /><br /><b>[size=24]</b>BÜYÜK!<b>[/size]</b><br /><br /><span style=\"font-size:24px\">BÜYÜK!</span> sonucunu verir.</li></ul>");
$faq[] = array("Biçimlendirme etiketlerini karýþtýrabilir miyim?", "Evet, mesela dikkati çekmek için þöyle yazabilirsiniz:<br /><br /><b>[size=18][color=red][b]</b>DÝKKAT!<b>[/b][/color][/size]</b><br /><br />Bu yazý þu þekilde görüntülenir: <span style=\"color:red;font-size:18px\"><b>DÝKKAT!</b></span><br /><br />Uzun metinleri bu þekilde yazmamanýzý öneririz! Unutmayýn ki, etiketlerin düzgün bir þekilde kapatýlmasýný temin etmek, metni gönderen kiþi olarak sizin görevinizdir. Örneðin bu þekilde yazmak yanlýþtýr: <br /><br /><b>[b][u]</b>Etiketler hatalý kapatýlmýþ<b>[/b][/u]</b>");

$faq[] = array("--","Alýntý ile Cevap ve Eþaralýklý Yazýtipi");
$faq[] = array("Alýntý ile cevap yazma", "Bir metinden alýntý yapmanýn iki ayrý yöntemi vardýr: kaynak vererek veya vermeyerek.<ul><li>Bir iletiye cevap vermek için Alýnýtý ile Cevap komutunu kullanýrsanýz, orjinal iletinin kendi iletinize <b>[quote=\"\"][/quote]</b> etiketleri arasýnda eklendiðini göreceksiniz. Bu yöntem, bir þahsý veya seçeceðiniz herhangi baþka bir yeri kaynak vererek yanýt yazmanýzý saðlar. Örneðin Ali isminde bir þahsýn yazdýklarýný alýntý etmek için þu þekilde yazmanýz gerek: <br /><br /><b>[quote=\"Ali\"]</b>Ali'nin yazdýðý yazýlar...<b>[/quote]</b><br /><br />Sonuçta alýntý yapýlan kýsmýn önüne otomatik olarak Ali demiþki: yazýlýr. Alýntý yaptýðýnýz þahsýn ismini týrnak iþaretleri \"\" içine almayý unutmayýn, týrnak iþaretleri kullanmanýz <b>þart</b>.</li><br /><br /><li>Ýkinci yöntem, kaynak vermeden alýntý yapmanýzý saðlar. Ýlgili bölümü <b>[quote][/quote]</b> etiketleri içine almanýz yeterli. Bu bölümün önünde Alýntý: yazýsýný göreceksiniz.</li></ul>");
$faq[] = array("Kaynak yazýlým veya eþaralýklý yazýtipiyle görüntüleme", "Bir programlama dilinde yazýlmýþ kaynak yazýlým veya eþaralýklý yazýtipi (örn. Courier) gerektiren herhangi bir metni görüntülemek için, ilgili kýsmý <b>[code][/code]</b> etiketleri içine almalýsýnýz. Örn.: <br /><br /><b>[code]</b>echo \"Bu bizim kodumuz\";<b>[/code]</b><br /><br /><b>[code][/code]</b> etiketleri arasýna yazýlan tüm biçimleme etiketleri (örn. [i], [b] gibi) iptal edilir. Bu biçimlendirmenin kullandýðý yazýtipi, kullandýðýnýz temaya göre farklýlýk gösterebilir.");

$faq[] = array("--","Liste Yaratma");
$faq[] = array("Madde imiyle liste", "Biçim Kodlarý rakamsýz (madde imiyle) ve rakamlý olmak üzere iki türlü liste destekler. Bu listeler aslýnda HTML listelerine eþittir. Rakamsýz liste, her maddeyi bir madde imiyle beraber satýr baþýný biraz girintilenmiþ olarak görüntüler. Rakamsýz bir liste hazýrlamak için <b>[list][/list]</b> etiketlerini kullanýn ve her satýrýn baþýna <b>[*]</b> yazýn. Örn. sevdiðiniz renklerin bir listesini þu þekilde hazýrlayabilirsiniz:<br /><br /><b>[list]</b><br /><b>[*]</b>Kýrmýzý<br /><b>[*]</b>Mavi<br /><b>[*]</b>Sarý<br /><b>[/list]</b><br /><br />Sonuç olarak þu listeyi göreceksiniz:<ul><li>Kýrmýzý</li><li>Mavi</li><li>Sarý</li></ul>");
$faq[] = array("Rakamlý liste", "Ýkinci liste türü olan rakamlý listeyle, her satýr baþýnda görülen rakamý kontrol edebilirsiniz. Rakamlara göre sýralanmýþ bir liste için <b>[list=1][/list]</b> kullanmanýz gerek. Alternatif olarak alfabe'ye göre sýralanmýþ bir liste için <b>[list=a][/list]</b> etiketlerini kullanabilirsiniz. Rakamsýz listelerde olduðu gibi, her maddeyi <b>[*]</b> ile iþaretlemeniz gerek. Örneðin:<br /><br /><b>[list=1]</b><br /><b>[*]</b>Maðazaya git<br /><b>[*]</b>Yeni bilgisayar al<br /><b>[*]</b>Eve götür<br /><b>[/list]</b><br /><br />þu þekilde görüntülenir:<ol type=\"1\"><li>Maðazaya git</li><li>Yeni bilgisayar al</li><li>Eve götür</li></ol>Öte yandan alfabeye göre sýralanmýþ bir listeyi þu þekilde yazmanýz gerekir:<br /><br /><b>[list=a]</b><br /><b>[*]</b>Birinci seçenek<br /><b>[*]</b>Ýkinci seçenek<br /><b>[*]</b>Üçüncü seçenek<br /><b>[/list]</b><br /><br />Sonuç:<ol type=\"a\"><li>Birinci seçenek</li><li>Ýkinci seçenek</li><li>Üçüncü seçenek</li></ol>");

$faq[] = array("--", "Link (URL) Yaratma");
$faq[] = array("Ayrý bir siteye link verme", "Biçim Kodlarý link (URL) yaratmak için deðiþik yöntemleri destekler.<ul><li>Birinci yöntem <b>[url=][/url]</b> etiketidir. = iþaretinin arkasýna yazýlanlar link olarak çalýþýr. Örneðin phpBB.com'a link vermek için þu þekilde yazýn:<br /><br /><b>[url=http://www.phpbb.com/]</b>phpBB'yi ziyaret edin!<b>[/url]</b><br /><br />Sonuçta þu linki göreceksiniz: <a href=\"http://www.phpbb.com/\" target=\"_blank\">phpBB'yi ziyaret edin!</a> Bu linki týklayýnca ayrý bir pencere açýlýr. Böylece kullanýcý panoyu gezmeye devam edebilir.</li><li>Link adresinin gösterilmesini istiyorsanýz, þu þekildede yazabilirsiniz:<br /><br /><b>[url]</b>http://www.phpbb.com/<b>[/url]</b><br /><br />Sonuçta þu linki göreceksiniz: <a href=\"http://www.phpbb.com/\" target=\"_blank\">http://www.phpbb.com/</a></li><li>phpBB ayrýca <i>Sihirli Linkler</i> denen bir iþleme sahip. Bunun sayesinde, kurallara uygun bir þekilde yazýlan her link adresi otomatik olarak link'e çevrilir, herhangi bir etiket, hatta http:// yazmanýza gerek kalmaz. Örn. www.phpbb.com yazýnca, izlenim sayfasýnda otomatik olarak <a href=\"http://www.phpbb.com/\" target=\"_blank\">www.phpbb.com</a> olarak görüntülenir.</li><li>Ayný iþlem email adresleri için uygulanýr. Dilerseniz özel olarak bir adres belirleyebilirsiniz, örn.:<br /><br /><b>[email]</b>no.one@domain.adr<b>[/email]</b><br /><br />yazýlýnca þu þekilde görüntülenir: <a href=\"emailto:no.one@domain.adr\">no.one@domain.adr</a> Veya basitçe no.one@domain.adr yazabilirsiniz ve iletiniz görüntülendiðinde bu kýsým otomatik olarak link'e çevrilir.</li></ul>Bütün Biçim Kodlarý etiketleri gibi, link adreslerini de diðer etiketlerin içine alabilirsiniz, örn. <b>[img][/img]</b> (bir sonraki madde bakýn), <b>[b][/b]</b>, vs. Biçimleme etiketlerinde olduðu gibi, etiketlerin düzgün bir þekilde sýrasýyla kapatýlmasýný kendiniz saðlamalýsýnýz, örn.:<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/url][/img]</b><br /><br />doðru <u>deðildir</u> ve hatta iletinizin silinmesine yol açabilir, bu konuda dikkatli olmanýz gerek.");

$faq[] = array("--", "Ýletilerde Resim Görüntüleme");
$faq[] = array("Bir iletiye resim ekleme", "Biçim Kodlarý iletinize resim eklemek için bir etikete sahiptir. Bu etiketi kullanýrken iki önemli noktayý dikkate almanýz gerek: Birçok kullanýcý iletilerde çok sayýda resmin görüntülenmesini hoþ karþýlamýyor. Ayrýca kullanmak istediðiniz resme internet üzerinden ulaþýlabilmeli (örn. bu resmin kendi bilgisayarýnýzda bulunmasý yeterli deðildir). Þu anda phpBB üzerinden resim kaydetme imkaný yoktur (bu konular muhtemelen phpBB'nin bir sonraki sürümünde ele alýnacak). Bir resmi görüntülemek için, resmin adresini <b>[img][/img]</b> etiketleri içine almalýsýnýz. Örn.:<br /><br /><b>[img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img]</b><br /><br />Bir önceki maddede belirtildiði gibi, resmi dilerseniz <b>[url][/url]</b> etiketleri içine alabilirsiniz. Örn.:<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img][/url]</b><br /><br />yazýnca þu sonucu verir:<br /><br /><a href=\"http://www.phpbb.com/\" target=\"_blank\"><img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" /></a><br />");

$faq[] = array("--", "Diðer Konular");
$faq[] = array("Kendi etiketlerimi ekleyebilir miyim?", "Hayýr, maalesef phpBB 2.0 sürümünde böyle bir imkan yok. Bir sonraki sürümde özelleþtirilmiþ Biçim Kodlarý etiketleri sunmayý planlýyoruz.");


//
// This ends the BBCode guide entries
// ------------------------------------

?>