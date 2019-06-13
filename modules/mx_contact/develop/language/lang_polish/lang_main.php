<?php
/***************************************************************************
 *                               lang_contact.php
 *                              ------------------
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *   	Copyright:	(C) 2006-07, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		23:08 21/06/2007
 *
 *	Translated by:	Kastak
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

$lang['Contact_intro'] = 'Je�eli masz jakie� pytania, uwagi, b�d� propozycje odno�nie serwisu/forum lub masz jakie� problemy (z rejestracj�, logowaniem itp.) u�yj poni�szego formularza.';

$lang['Username'] = 'U�ytkownik';
$lang['Real_name'] = 'Imi�';
$lang['Rname_require'] = 'Imi� *';
$lang['E-mail'] = 'Tw�j E-mail';
$lang['E-mail_require'] = 'Tw�j E-mail *';
$lang['Comments'] = 'Wiadomo��';
$lang['Comments_require'] = 'Wiadomo�� *';
$lang['Attachment'] = 'Za��cznik';

$lang['Feedback'] = 'Otrzymano wiadomo��';

$lang['Real_name_explain'] = 'Wpisz swoje imi�. U�atwi nam to kontakt gdy jeste� niezarejestrowany.';
$lang['Explain_email'] = 'Wpisz sw�j E-mail. Na ten adres zostanie wys�ana odpowied�.';
$lang['Comments_explain'] = 'Wpisz tu tre�� swojej wiadomo�ci';
$lang['Flood_explain'] = '<br /><br />Ten formularz ma w��czony system anty-floodowy. Mo�esz wys�a� tylko jedn� wiadomo�� co %s %s.' ;
$lang['Comments_limit'] = '<br /><br />Administrator ustawi� limit %s znak�w.';
$lang['Attachment_explain'] = 'Do��cz do wiadomo�ci za��cznik je�li to konieczne, trafi on do administratora forum. Maksymalny rozmiar pliku to %sKb lub mniejszy.';

$lang['Guest'] = 'Go��';
$lang['Notify_IP'] = 'Twoje IP b�dzie zapisane w celach bezpiecze�stwa.';
$lang['Fields_required'] = 'Pola oznaczone * s� obowi�zkowe.';
$lang['Contact_form'] = 'Formularz Kontaktowy';
$lang['Empty'] = 'Nie podano';

$lang['hours'] = 'godziny';
$lang['hour'] = 'godzin�';

$lang['Chars'] = ' znak�w';

$lang['Captcha_code'] = 'Kod zabezpieczaj�cy *';
$lang['Captcha_code_explain'] = 'Przepisz kod z obrazka.';

//
// Errors
//
$lang['Rname-Empty'] = 'Musisz wpisa� swoje imi�.';
$lang['Comments-Empty'] = 'Musisz wpisa� wiadomo��.';
$lang['Comments_exceeded'] = 'Twoja wiadomo�� jest d�u�sza ni� dozwolony limit.';
$lang['Email-Empty'] = 'Musisz wpisa� sw�j adres e-mail.';
$lang['Email-Check'] = 'Adres e-mail jest nieprawid�owy.';
$lang['Attach-File_exists'] = 'Ju� istnieje plik o takiej nazwie, kt�ry zosta� wys�any z twojego adresu IP.';
$lang['Attach-Too_big'] = 'Za��cznik, kt�ry pr�bujesz wys�a� ma zbyt du�y rozmiar. Dozwolona maksymalna wielko�� pliku to %sKb lub mniejsza.';
$lang['Attach_dud'] = 'Za��cznik, kt�ry pr�bowa�e� wys�a� nie istnieje. Prosz� sprawdzi� ponownie �cie�k� do pliku.';
$lang['Attach-Uploaded'] = 'Tw�j za��cznik zosta� poprawnie dodany.';
$lang['Flood_limit'] = 'Przepraszamy, ale musisz poczeka� %d godzin(y) zanim b�dziesz m�g� skorzysta� ponownie z formularza kontaktowego.';
$lang['Illegal_ext'] = 'Ten typ pliku (%s) jest zabroniony!';
$lang['Unknown_ext'] = 'Ten typ pliku (%s) nie mo�e by� zaakceptowany!';
$lang['zip_advise'] = 'W razie konieczno�ci, prosz� spakowa� plik (format zip) przed ponownym wys�aniem.';
$lang['POST_ERROR'] = 'B��d podczas wysy�ania - prosz� spr�bowa� ponownie!';
$lang['Image_error'] = 'B��d podczas wysy�ania - przetworzenie tego obrazka by�o niemo�liwe!';
$lang['Image_zip'] = 'Prosz� spakowa� ten typ obrazka przed wys�aniem (format zip).';
$lang['Code_Empty'] = 'Musisz wpisa� kod z obrazka!';
$lang['Code_Wrong'] = 'Wpisany kod jest niepoprawny!';

$lang['Contact_error'] = '<b>Wyst�pi� b��d podczas wysy�ania wiadomo�ci</b>';
$lang['Contact_success'] = '<b>Wiadomo�� zosta�a wys�ana.</b>';

$lang['Click_return_form'] = '<br /><br />Kliknij %sTutaj%s, aby wr�ci� do formularza.';

$lang['Contact_Disabled'] = 'Formularz jest obecnie wy��czony';

//
// Admin
//
$lang['General_settings'] = 'Ustawienia Formularza';
$lang['Contact_title'] = 'Formularz Konktaktowy';
$lang['Contact_explain'] = 'Tutaj mo�esz zmieni� ustawienia i wygl�d formularza kontaktowego oraz obowi�zkowe pola.';
$lang['Req_settings'] = 'Wymagane pola';
$lang['Attachment_settings'] = 'Ustawienia Za��cznik�w';
$lang['Contact_updated'] = 'Zmiany zatwierdzone';
$lang['Click_return_contact'] = 'Kliknij %sTutaj%s aby wr�ci� do konfiguracji.';
$lang['Admin_email_explain'] = 'Je�eli pole pozostanie puste e-maile b�d� wysy�ane do g��wnego administratora forum.';

$lang['Form_Enable'] = 'Formularz w��czony?';

$lang['kb'] = 'kilobajt�w';

$lang['Hash'] = 'Kodowanie za��cznik�w';
$lang['Hash_explain'] = 'Wszystkie nazwy za��czanych plik�w zostan� zmienione na losowy hash dla wi�kszego bezpiecze�stwa.';
$lang['md5'] = 'MD5';
$lang['no_hash'] = 'Brak';

$lang['auth_permission'] = 'Zezwolenia';
$lang['auth_perm_explain'] = 'Je�eli za��czniki s� dozwolone, mo�esz wybra� kto mo�e uploadowa� pliki.';
$lang['auth_guests'] = 'Go�cie';
$lang['auth_members'] = 'U�ytkownicy';
$lang['auth_mods'] = 'Moderatorzy';
$lang['auth_admins'] = 'Administratorzy';

$lang['Require_rname'] = 'Imi�';
$lang['Require_email'] = 'E-mail';
$lang['Require_comments'] = 'Wiadomo��';
$lang['Permit_attachments'] = 'Za��czniki w��czone?';
$lang['Prune'] = 'W��cz automatyczne czyszczenie';
$lang['Prune_explain'] = 'W��cz to, aby wyczy�ci� wpisy SQL, kt�re nie s� ju� potrzebne dla opcji "Interwa� Anty-Floodowy", zmniejszy to rozmiar bazy danych.';
$lang['Max_file_size'] = 'Maksymalny rozmiar pliku';
$lang['Max_file_size_explain'] = 'Ustaw maksymalny dozwolony rozmiar pliku (za��cznika). Pami�taj, wielko�� za��cznika nie mo�e przekracza� ustawie� twojego php.ini. (%s)';
$lang['File_root'] = 'Katalog za��cznik�w';
$lang['File_root_explain'] = 'Wpisz nazw� folderu, w kt�rym b�d� zapisywane za��czniki. Folder musi mie� ustawione CHMOD 777 i znajdowa� si� w g��wnym katalogu forum.';
$lang['Flood_limit_admin'] = 'Interwa� Anty-Floodowy';
$lang['Flood_limit_admin_explain'] = 'Ilo�� godzin, zanim b�dzie mo�na wys�a� nowy e-mail poprzez formularz kontaktowy. Ustaw \'0\', aby wy��czy� t� funkcj� (zalecane tylko dla test�w).';
$lang['Char_limit_admin'] = 'Maksymalna ilo�� znak�w';
$lang['Char_limit_admin_explain'] = 'Tutaj mo�esz ustawi� limit znak�w dopuszczalny w wiadomo�ci. Ustaw \'0\', aby wy��czy� limit.';

$lang['Captcha'] = 'Kod zabezpiecze�';
$lang['Activate'] = 'Zabezpieczenie aktywne?';
$lang['Enable'] = 'W��czone';
$lang['Disable'] = 'Wy��czone';
$lang['Captcha_explain'] = 'W��cz t� opcj�, aby u�ytkownicy obowi�zkowo musieli przepisa� kod z obrazka przed wys�aniem wiadomo�ci. Zapobiega to przed nadu�eciem formularza przez spamboty.';
$lang['Type'] = 'Rodzaj obrazka';
$lang['Type_explain'] = 'Wybierz typ obrazka, jaki ma by� pokazany w twoim formularzu kontaktowym.';
$lang['Image_bg'] = 'Obrazek bazowy';
$lang['Coloured'] = 'Kolorowy';
$lang['Random'] = 'Losowy';

$lang['Copyright'] = '"Formularz kontaktowy" by <a href="http://www.phobbia.net" target="_phpbb"><b>Ma&reg;&copy;uS</b></a> &copy; 2006-2007<br />(Original mod: darkassasin93)';

//
// "Quick Delete" - Added to 7.0.0
//
$lang['QDelete'] = 'Szybkie usuwanie';
$lang['QDelete_disabled'] = 'Opcja szybkiego usuwania zosta�a wy��czona';
$lang['File_Not_Here'] = 'Ten za��cznik najprawdopodobniej nie istnieje';
$lang['File_Removed'] = 'Plik zosta� usuni�ty pomy�lnie.';
$lang['QDelete_explain'] = 'Zezwoli� adminowi na szybkie usuwanie za��cznika poprzez link podany w e-mailu?';
$lang['Remove_file'] = 'Aby usun�� plik, kliknij na ten link: %s';

//
// "Messages Log" - Added in 8.6.0
//

$lang['Contact_date'] = 'Data';
$lang['Contact_ip'] = 'IP';
$lang['Contact_get'] = '%sPobierz%s';
$lang['Contact_remove'] = '%sUsu�%s';
$lang['Msg_delete'] = 'Usu�';

$lang['Contact_msgs_title'] = 'Formularz kontaktowy :: Logi wiadomo�ci';
$lang['Contact_msgs_text'] = 'Tutaj znajduj� si� wiadomo�ci, kt�re zosta�y wys�ane poprzez formularz kontaktowy. Nowsze wiadomo�ci s� jako pierwsze.<br />&nbsp;&bull; Wiadomo�ci mog� zosta� przegl�dni�te i usuni�te.<br />&nbsp;&bull; Za��czniki mog� zosta� pobrane na dysk i usuni�te.';

$lang['Msg_del_success'] = 'Wiadomo�ci usuni�te';
$lang['File_del_success'] = 'Za��cznik usuni�ty';
$lang['Confirm_delete_msg'] = 'Czy jeste� pewien, �e chcesz usun�� wiadomo��(i)?';
$lang['Confirm_delete_file'] = 'Czy jeste� pewien, �e chcesz usun�� ten za��cznik';
$lang['File_Not_Here'] = 'Ten za��cznik najprawdopodobniej nie istnieje';
$lang['Click_return_msglog'] = 'Kliknij %sTutaj%s, aby powr�ci� do Logi wiadomo�ci';

$lang['Msg_Log'] = 'Logi wiadomo�ci w��czone?';
$lang['Msg_Log_explain'] = 'Ta opcja pozwala Ci na zpisywanie wysy�anych e-maili w  Twojej bazie danych, podgl�d b�dzie widoczny w Logach Wiadomo�ci';

$lang['more'] = 'wi�cej';

//
// "Thank You" - Added in 8.9.8
//
$lang['Thankyou_settings'] = 'Ustawienia "Podzi�kowa�"';
$lang['Thankyou_option'] = 'Podzi�kuj nadawcy';
$lang['Thankyou_explain'] = 'Ustaw "�aden", aby wy��czy�, "U�ytkownicy", aby tylko zarejestrowani u�ytkownicy otrzymywali podzi�kowanie lub "Wszyscy", aby r�wnie� go�cie otrzymywali podzi�kowanie.';
$lang['Thank_none'] = '�aden';
$lang['Thank_members'] = 'U�ytkownicy';
$lang['Thank_all'] = 'Wszyscy';
$lang['Thankyou_limit'] = 'Przepraszamy, ale nie akceptujemy wi�cej wiadomo�ci z tego adresu e-mail przez najbli�sze 24 godziny.';

?>