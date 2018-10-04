<?php
/***************************************************************************
 *                         lang_bbcode.php [rom�n�]
 *                            -------------------
 *     begin                : Aug 7, 2002
 *     last update          : Dec 31, 2004
 *     language version     : 6.0
 *     copyright            : Romanian phpBB online community
 *     website              : http://www.phpbb.ro
 *     copyright 1          : (C) Robert Munteanu
 *     email     1          : rombert@go.ro
 *     copyright 2          : (C) Bogdan Toma
 *     email     2          : bogdan@phpbb.ro
 *
 *     $Id: lang_bbcode.php,v 1.1 2009/10/18 04:16:00 orynider Exp $
 *
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
// To add an entry to your codul BB guide simply add a line to this file in this format:
// $faq[] = array("question", "answer");
// If you want to separate a section enter $faq[] = array("--","Block heading goes here if wanted");
// Links will be created automatically
//
// DO NOT forget the ; at the end of the line.
// Do NOT put double quotes (") in your codul BB guide entries, if you absolutely must then escape them ie. \"something\";
//
// The codul BB guide items will appear on the codul BB guide page in the same order they are listed in this file
//
// If just translating this file please do not alter the actual HTML unless absolutely necessary, thanks :)
//
// In addition please do not translate the colours referenced in relation to codul BB any section, if you do
// users browsing in your language may be confused to find they're codul BB doesn't work :D You can change
// references which are 'in-line' within the text though.
//
  
$faq[] = array("--","Introducere");
$faq[] = array("Ce este codul BB?", "Codul BB este o implementare special� a HTML-ului. Dac� pute�i folosi codul BB sau nu �n mesajele dumneavoastr� este alegerea administratorului. �n plus, pute�i dezactiva codul BB de la mesaj la mesaj din formularul de publicare. Codul BB este similar cu HTML-ul, balizele (tag-urile) sunt scrise �ntre paranteze p�trate [ �i ] dec�t �ntre &lt; �i &gt; �i ofer� un control mai bun asupra ce �i cum este afi�at. �n func�ie de �ablonul pe care �l folosi�i pute�i descoperi c� ad�ugarea de cod BB la mesajele dumneavoastr� este mai u�oar� printr-un set de butoane. Chiar �i a�a probabil c� ve�i g�si acest ghid folositor.");


$faq[] = array("--","Formatarea textului");
$faq[] = array("Cum s� crea�i text �ngro�at, cursiv �i subliniat", "Codul BB include balize pentru a v� permite s� schimba�i rapid stilul textului dumneavoastr�. Acest lucru poate fi ob�inut �n urmatoarele moduri: <ul><li>Pentru a face o bucat� de text �ngro�at� (bold), include�i-o �ntre <b>[b][/b]</b> , spre exemplu <br /><br /><b>[b]</b>Salut<b>[/b]</b><br /><br /> va deveni <b>Salut</b></li><li>Pentru subliniere folosi�i <b>[u][/u]</b>, spre exemplu <br /><br /><b>[u]</b>Bun� diminea�a<b>[/u]</b><br /><br />devine <u>Buna dimineata</u></li><li>Pentru a scrie cu font cursiv (italic) folosi�i <b>[i][/i]</b> , spre exemplu <br /><br /><b>[i]</b>Super!<b>[/i]</b><br /><br />va deveni <i>Super!</i></li></ul>");
$faq[] = array("Cum s� schimba�i culoarea textului sau m�rimea", "Pentru a schimba culoarea sau marimea textului dumneavoastr� pute�i folosi mai multe balize. �ine�i minte c� felul cum apare mesajul depinde de browser-ul �i sistemul clientului :<ul><li> Schimbarea culorii textului se face prin trecerea �ntre <b>[color=][/color]</b>. Pute�i specifica fie o culoare cunoscut�, �n limba englez�, (<i>red</i> pentru ro�u), <i>blue</i> pentru albastru, <i>yellow</i> pentru galben) sau un triplet hexazecimal (#FFFFFF, #000000). Spre exemplu, pentru a scrie cu ro�u ve�i folosi :<br /><br /><b>[color=red]</b>Salut!<b>[/color]</b><br /><br />sau<br /><br /><b>[color=#FF0000]</b>Salut!<b>[/color]</b><br /><br /> Amblele vor avea ca rezultat <span style=\"color:red\">Salut!</span></li><li>Schimbarea m�rimii textului este facut� �n acela�i fel folosind <b>[size=][/size]</b>. Aceast� baliz� depinde de �ablonul pe care �l folosi�i dar formatul recomandat este o valoare numeric� reprezent�nd m�rimea textului �n pixeli, pornind de la 1 (extrem de mic) �i ajung�nd p�n� la 29 (foarte mare). Spre exemplu: <br /><br /><b>[size=9]</b>MIC<b>[/size]</b><br /><br /> �n general va avea ca rezultat <span style=\"font-size:9px\">MIC</span><br /><br /> �n vreme ce <br /><br /><b>[size=24]</b>ENORM!<b>[/size]</b><br /><br />va fi <span style=\"font-size:24px\">ENORM!</span></li></ul>");
$faq[] = array("Pot combina balizele (tag-urile) de formatare?", "Desigur. Spre exemplu, pentru a atrage aten�ia cuiva a�i putea s� scrie�i <br /><br /><b>[size=18][color=red][b]</b>PRIVE�TE-M�!<b>[/b][/color][/size]</b><br /><br />�i rezultatul va fi <span style=\"color:red;font-size:18px\"><b>PRIVE�TE-M�!</b></span><br /><br /> Totu�i, nu v� recomand�m s� scrie�i prea mult text astfel ! Tine�i minte c� depinde de dumneavoastr� s� v� asigura�i c� balizele sunt �nchise corect. Spre exemplu, urmatoarea secven�� este incorect�: <br /><br /><b>[b][u]</b>A�a este gre�it<b>[/b][/u]</b>");

$faq[] = array("--","Citate �i text cu l��ime fix�");
$faq[] = array("Citarea textului �n r�spunsuri", "Exist� dou� modalit��i de a cita textul, cu referin�� �i f�r�.<ul><li>C�nd utiliza�i func�ia de r�spuns inclusiv mesajul, ar trebui s� observa�i c� mesajul respectiv este ad�gat �n fereastra de publicare inclus �ntr-un bloc <b>[quote=\"\"][/quote]</b>. Aceast� metod� v� permite s� �l cita�i cu referin�� la o persoan� sau orice altceva dori�i s� scrie�i ! Spre exemplu, pentru a cita o bucat� de text scris� de Dl. Ionescu a�i scrie :<br /><br /><b>[quote=\"Dl. Ionescu\"]</b> Textul scris de Dl. Ionescu <b>[/quote]</b><br /><br /> Rezultatul va fi c� Dl. Ionescu a scris: va fi ad�ugat �nainte de textul citat. �ine-�i minte c� <b>trebuie</b> s� include�i ghilimelele \"\" �n jurul numelui pe care �l cita�i. Acestea nu sunt op�ionale.</li><li> A doua metod� v� permite s� cita�i f�r� un autor. Pentru a folosi acest lucru introduce�i textul �ntre balizele <b>[quote][/quote]</b>. C�nd �l cita�i, mesajul va ar�ta pur �i simplu Citat: �nainte de textul propriu-zis.</li></ul>");
$faq[] = array("Generarea de cod sau de text cu m�rime fix�", "Dac� dori�i s� scrie�i o bucat� de cod sau - de fapt - orice altceva care are nevoie de o l��ime fix�, cum ar fi un font de tip Courier, ar trebui s� introduce�i textul �ntre balize <b>[code][/code]</b> , spre exemplu: <br /><br /><b>[code]</b>echo \"O linie de cod\";<b>[/code]</b><br /><br />Toate format�rile folosite �ntre balizele <b>[code][/code]</b> sunt re�inute c�nd citi�i mesajul.");


$faq[] = array("--","Generarea listelor");
$faq[] = array("Crearea unei liste neordonate", "Codul BB include dou� tipuri de liste, neordonate �i ordonate. �n mare sunt la fel cu echivalentele lor HTML. O list� neordonat� scrie fiecare obiect din list� secven�ial ad�ug�ndu-le un alineat �i un caracter <i>bullet</i>. Pentru a crea o list� neordonat� folosi�i <b>[list][/list]</b> �i defini�i fiecare obiect din lista folosind <b>[*]</b>. Spre exemplu, pentru a v� scrie culorile preferate a�i putea folosi : <br /><br /><b>[list]</b><br /><b>[*]</b>ro�u<br /><b>[*]</b>albastru<br /><b>[*]</b>galben<br /><b>[/list]</b><br /><br />Aceasta ar genera urmatoarea list�: <ul><li>ro�u</li><li>albastru</li><li>galben</li></ul>");
$faq[] = array("Crearea unei liste ordonate", "Al doilea tip de list�, lista ordonat� v� ofer� controlul asupra ceea ce este afi�at �naintea fiec�rui obiect. Pentru a crea o list� ordonat� folosi�i <b>[list=1][/list]</b> pentru o list� numeric� sau <b>[list=a][/list]</b> pentru o list� alfabetic�. Ca �i la listele neordonate, obiectele sunt indicate folosind <b>[*]</b>. Spre exemplu: <br /><br /><b>[list=1]</b><br /><b>[*]</b>Mergi la magazin<br /><b>[*]</b>Cumpar� un calculator<br /><b>[*]</b>Tip� la el c�nd crap�<br /><b>[/list]</b><br /><br /> va genera urmatoarele:<ol type=\"1\"><li>Mergi la magazin</li><li>Cumpar� un calculator</li><li>Tip� la el c�nd crap�</li></ol> pe c�nd pentru o lista alfabetic� a�i folosi :<br /><br /><b>[list=a]</b><br /><b>[*]</b>Primul r�spuns<br /><b>[*]</b>Al doilea r�spuns<br /><b>[*]</b>Al treilea r�spuns<br /><b>[/list]</b><br /><br /> av�nd ca rezultat: <ol type=\"a\"><li>Primul r�spuns</li><li>Al doilea r�spuns</li><li>Al treilea r�spuns</li></ol>");


$faq[] = array("--", "Crearea leg�turilor");
$faq[] = array("Leg�turi c�tre alte site-uri", "Codul BB ofer� multe resurse de creare a leg�turilor, cunoscute mai bine ca URL-uri. <ul><li>Prima din acestea folose�te baliza <b>[url=][/url]</b>, �i orice ve�i scrie dup� semnul egal va determina con�inutul acelei balize s� se comporte ca un URL. Spre exemplu, o leg�tur� c�tre phpBB ar fi: <br /><br /><b>[url=http://www.phpbb.com/]</b>Vizita�i phpBB!<b>[/url]</b><br /><br />Rezultatul ar fi urm�torea leg�tur�: <a href=\"http://www.phpbb.com/\" target=\"_blank\">Vizita�i phpBB!</a>. Ve�i observa c� leg�tura se va deschide �ntr-o fereastr� nou� pentru ca utilizatorul s� poat� continua s� utilizeze forumul dac� dore�te.</li></li> Dac� dori�i s� fie afi�at chiar URL-ul atunci pute�i s� scrie�i: <br /><br /><b>[url]</b>http://www.phpbb.com/<b>[/url]</b><br /><br /> Acesta va genera urmatoarea legatur�: <a href=\"http://www.phpbb.com/\" target=\"_blank\">http://www.phpbb.com/</a></li><li> Alte facilit��i phpBB includ �i ceva numit <i>leg�turi magice</i>, care v� transform� un URL corect din punct de vedere sintactic �ntr-un URL f�r� ca dumneavoastr� s� specifica�i vreo baliza sau s� �ncepe�i cu <i>http://</i>. Spre exemplu, dac� ve�i scrie www.phpbb.com aceasta va deveni direct <a href=\"http://www.phpbb.com/\" target=\"_blank\">http://www.phpbb.com/</a>. Acela�i lucru se �nt�mpl� �i cu adresele de mail. Pute�i folosi o adres� explicit spre exemplu: <br /><br /><b>[email]</b>cineva@domeniu.adr<b>[/email]</b><br /><br />care va rezulta �n <a href=\"mailto:cineva@domeniu.adr\">cineva@domeniu.adr</a> sau pute�i s� scrie�i direct cineva@domeniu.adr �i mesajul dumneavoastr� va fi automat convertit c�nd �l ve�i vizualiza. </li></ul> La fel ca tag-urile codului BB pute�i folosi pentru URL-uri orice tip de tag, ca �i <b>[img][/img]</b> (citi�i punctul urm�tor), <b>[b][/b]</b> etc. Ca �i �n cazul balizelor de formatare depinde de dumneavoastr� s� v� asigura�i de ordinea corect� de deschidere �i �nchidere. Spre exemplu: <br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/url][/img]</b><br /><br /> <u>nu</u> este corect, lucru care ar putea duce la �tergerea mesajului, a�a c� ave�i mare grij�.");


$faq[] = array("--", "Afi�area imaginilor �n mesaje");
$faq[] = array("Ad�ugarea unei imagini �n mesaj", "Codul BB include o baliz� pentru includerea imaginilor �n mesajele dumneavoastr�. Doua lucruri foarte importante trebuie �inute minte: mul�i utilizatori nu apreciaz� afi�area multor imagini �ntr-un mesaj �i imaginea trebuie s� fie deja disponibil� pe internet (nu poate exista doar pe calculatorul dumneavoastr�, doar dac� nu rula�i un server de web). Nu exist� �n prezent nici o modalitate de stocare a imaginilor local cu phpBB (toate aceste probleme vor fi luate �n discu�ie la urmatoarea versiune). Pentru a afi�a o imagine trebuie sa �nchide�i URL-ul imaginii �n balize <b>[img][/img]</b>. Spre exemplu: <br /><br /><b>[img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img]</b>.<br /><br /> A�a cum s-a v�zut �n sec�iunea anterioar� despre URL-uri, pute�i include o imagine �ntr-o baliz� <b>[url][/url]</b> dac� dori�i, spre exemplu :<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img][/url]</b><br /><br /> ar genera: <br /><br /><a href=\"http://www.phpbb.com/\" target=\"_blank\"><img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" /></a><br />");

$faq[] = array("--", "Diverse");
$faq[] = array("Pot s� �mi adaug propriile balize (tag-uri)?", "Nu, din nefericire; nu direct �n phpBB 2.0 . C�ut�m modalit��i de a oferi balize modificabile pentru urmatoarea versiune major�.");

//
// This ends the codul BB guide entries
//

?>