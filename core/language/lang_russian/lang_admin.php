<?php
/***************************************************************************
 *                            lang_admin.php [Russian]
 *                              -------------------
 *     copyright            : (C) 2003 Mx System
 *     email                : support@mx-system.com
 *
 *   $Id: lang_admin.php,v 1.16 2004/05/22 20:45:51 jonohlsson Exp $
 *
 *	 Rev. hist            : Created by MarcMoris (support@mx-system.com),
                              reedited by Haplo (jonohlsson@hotmail.com)
 ****************************************************************************/

//
// Translation performed by Gosudar
// Gosudar@list.ru   
//
// Внимание! Мой e-mail указан здесь для того, чтобы можно было сообщать мне о проблемах в 
// переводе. За технической поддержкой обращайтесь, пожалуйста, на соответствующий
// форум на http://www.mx-system.com/ или на русский сайт mxBB-portal.com.ru
// Есть хороший шанс нарваться на грубый ответ или не получить никакого ответа, если
// доставать меня по e-mail'у. Спасибо за понимание.
//
// P.S. Также, выражается благодарность Atrus за перевод версии 2.7.3, Алексею Борзову за его перевод phpBB, который
// использовался в этой работе.
//

//
// The format of this file is:
//
// ---> $lang["message"] = "text";
//
// Specify your language character encoding... [optional]
//
// setlocale(LC_ALL, "ru_RU.CP1251");

//
// Configuration
//

 $lang['Portal_admin']              = "Администрирование Портала";
 $lang['Portal_admin_explain']      = "Используйте эту форму, для настройки своего портала";
 $lang['Portal_General_Config']     = "Конфигурация Портала";
 $lang['Portal_General_settings']   = "Общие Настройки";
 $lang['Portal_General_config_info'] = "Общая Информация о Конфигурации ";
 $lang['Portal_General_config_info_explain'] = "Указана информация из файла config.php (не редактировать)";
 $lang['Portal_Name']               = "Название Портала:";
 $lang['Portal_PHPBB_Url']          = "URL к установленному PHPBB:";
 $lang['Portal_Url']                = "URL к порталу Mx:";
 $lang['Portal_Config_updated']     = "Конфигурация Портала Успешно Обновлена";
 $lang['Click_return_portal_config'] = "%sВернуться на страницу Конфигурации Портала%s";

 //
// Menu Management
//

 $lang['Menu_admin']                = "Администрирование Меню";
 $lang['Menu_admin_explain']        = "Используйте эту форму, для настройки вашего меню";
 $lang['Menu_edit_delete_explain']  = "Используйте эту форму, для настройки вашего меню";
 $lang['Menu_settings']             = "Параметры Меню";
 $lang['Menu_delete']               = "Удалить Меню";
 $lang['Menu_delete_explain']       = "Используйте эту форму, что бы удалить (и/или переместить) категорию и её элемент(ы)";
 $lang['Edit_menu']                 = "Редактировать меню";
 $lang['Update']                    = "Обновить";
 $lang['Create_menu']               = "Новое меню";
 $lang['Create_category']           = "Новая категория";
 $lang['Menu_Config_updated']       = "Конфигурация Меню Успешно Обновлена";
 $lang['Menus_updated']             = "Параметры Меню и Категорий успешно обновлены";
 $lang['Click_return_menuadmin']    = "%sВернуться к Администрированию Меню%s";
 $lang['Menu_name']                 = "Название Меню";
 $lang['Menu_icon']                 = "Пиктограмма Меню";
 $lang['Menu_desc']                 = "Описание ";
 $lang['Edit']                      = "Изменить";
 $lang['Delete']                    = "Удалить";
 $lang['Move_up']                   = "Сдвинуть вверх";
 $lang['Move_down']                 = "Сдвинуть вниз";
 $lang['Resync']                    = "Синхронизация";
 $lang['Click_return_admin_index']  = "%sВернуться на Главную Страницу%s";

//
// Module Management
//

 $lang['Module']                    = "Модуль";
 $lang['Module_admin']              = "Администрирование Модулей";
 $lang['Module_admin_explain']      = "Используйте эту форму, для настройки модулей";
 $lang['Column_delete']             = "Удалить Столбец";
 $lang['Module_delete']             = "Удалить Модуль";
 $lang['Module_delete_explain']     = "Используйте эту форму, для удаления модуля (или функцию)";
 $lang['Edit_module']               = "Настроить модуль";
 $lang['Create_module']             = "Добавить новый модуль";
 $lang['Module_Config_updated']     = "Конфигурация Модулей Успешно Обновлена";
 $lang['Module_updated']            = "Информация о модулях успешно обновлена";
 $lang['Click_return_module_admin'] = "%sВернуться к Администрированию Модулей%s";
 $lang['Column_name']               = "Название Столбца";
 $lang['Module_name']               = "Название Модуля";
 $lang['Module_desc']               = "Описание";
 $lang['Module_path']               = "Путь";
 $lang['Create_column']             = "Добавить новый столбец";
 $lang['Column']                    = "Столбец";
 $lang['Edit_Column']               = "Изменить Столбец";
 $lang['Edit_Column_explain']       = "Используйте эту форму, для изменения столбца";
 $lang['Column_Size']               = "Размер столбца";

//
// These are displayed in the drop down boxes for advanced
// mode Module auth, try and keep them short!
//

 $lang['Menu_Navigation']           = "Навигационная панель";
 $lang['Modules']                   = "Модули";
 $lang['Portal_index']              = "Домашняя Страница Портала";
 $lang['Poll_Display']              = "Какое Голосование вы хотите показать?";
 $lang['Meta_admin']                = "Настройка Тэгов Meta";
 $lang['Mega_admin_explain']        = "Используйте эту форму, для настройки ваших тэгов Meta";
 $lang['Meta_Title']                = "Заголовок";
 $lang['Meta_Author']               = "Автор";
 $lang['Meta_Copyright']            = "Права на копирование";
 $lang['Meta_Keywords']             = "Ключевые слова";
 $lang['Meta_Keywords_explain']     = "(список, разделённый запятыми)";
 $lang['Meta_Description']          = "Описание";
 $lang['Meta_Language']             = "Языковой код";
 $lang['Meta_Rating']               = "Классификация";
 $lang['Meta_Robots']               = "Robots (для поисковых машин)";
 $lang['Meta_Pragma']               = "Не кэшировать страницу";
 $lang['Meta_Bookmark_icon']        = "Пиктограмма для закладок";
 $lang['Meta_Bookmark_explain']     = "(относительное расположение)";
 $lang['Meta_HTITLE']               = "Дополнительные Заголовки";
 $lang['Meta_data_updated']         = "Meta data file (mx_meta.inc) has been updated!<br />Click %sHERE%s to return to Meta  Tags Administration.";
 $lang['Meta_data_ioerror']         = "Unable to open mx_meta.inc. Make sure the file is writable (chmod 777).";
 $lang['Create_block']              = "Создать новый Блок";
 $lang['Block_delete']              = "Удалить Блок";
 $lang['Block_delete_explain']      = "Используйте эту форму, для удаления Блока (или столбца)";
 $lang['Block']                     = "Блок";
 $lang['Block_title']               = "Заголовок";
 $lang['Block_desc']                = "Описание";
 $lang['Add_Block']                 = "Добавить блок";
 $lang['Auth_Block']                = "Разрешения";
 $lang['AUTH_ALL']                  = "ALL";
 $lang['AUTH_REG']                  = "REG";
 $lang['AUTH_PRIVATE']              = "PRIVATE";
 $lang['AUTH_MOD']                  = "MOD";
 $lang['AUTH_ADMIN']                = "ADMIN";
 $lang['AUTH_ANONYMOUS']            = "ANONYMOUS";
 $lang['Function']                  = "Функция";
 $lang['Settings']                  = "Настройки";
 $lang['Save_Settings']             = "Сохранить Настройки";
 $lang['announce_nbr_display']      = "Количество отображаемых Сообщений (максимальное)";
 $lang['announce_nbr_days']         = "Количество Дней, для отображения Сообщения";
 $lang['announce_img']              = "Картинка объявления";
 $lang['announce_img_sticky']       = "Картинка прикрепленный сообщения";
 $lang['announce_img_normal']       = "Картинка обычного сообщения";
 $lang['announce_img_global']       = "Картинка глобального сообщения";
 $lang['announce_display']          = "Отображать в этом модуле объявлёния ";
 $lang['announce_display_sticky']   = "Отображать в этом модуле прикреплённые сообщения ";
 $lang['announce_display_normal']   = "Отображать в этом модуле обычные сообщения ";
 $lang['announce_display_global']   = "Отображать в этом модуле глобальные сообщения  ";
 $lang['announce_forum']            = "Форумы-Источники<br /> Вы можете указать несколько форумов<br />* Если не указано ничего, то будут показаны все авторизированные форумы";
 $lang['poll_forum']                = "Форумы-Источники<br /> Вы можете указать несколько форумов<br />* Если не указано ничего, то будут показаны все авторизированные форумы";
 $lang['Function_admin']            = "Администрирование Функций";
 $lang['Function_admin_explain']    = "Каждый модуль содержит одну или более функций. Используйте эту форму, для добавления, редактирования и удаления функций";
 $lang['Function_name']             = "Название Функции";
 $lang['Function_desc']             = "Описание";
 $lang['Function_file']             = "Файл ( Скрипт ) ";
 $lang['Create_function']           = "Добавить новую Функцию";
 $lang['Parameter_name']            = "Название ";
 $lang['Parameter_desc']            = "Описание";
 $lang['Parameter_type']            = "Тип";
 $lang['Parameter_default']         = "Значение по умолчанию";
 $lang['import_module_pack']        = "Инсталлировать Модуль";
 $lang['import_module_pack_explain']        = "Это установит модуль в портал. Убедитесь, что модуль загружен в папку /modules... и, что модуль последней версии!";
 $lang['upgrade_module_pack']       = "Обновить Модуль";
 $lang['upgrade_module_pack_explain']       = "Это обновит ваш модуль. Убедитесь, что вы прочитали документацию модуля пред тем, как начнёте, в противном случае вы рискуете потерять данные модуля.";
 $lang['export_module_pack']        = "Экспортирование Модуля";
 $lang['Export_Module']             = "Выберете модуль:";
 $lang['export_module_pack_explain']             = "Это экспортирует *.pak файл модуля. Предназначено только для разработчиков модулей...";
 $lang['Not_Specified']             = "Не определено";
 $lang['Page']                      = "Страница";
 $lang['Add_Page']                  = "Добавить новую страницу";
 $lang['Block_admin']               = "Администрирование Блоков";
 $lang['Block_admin_explain']       = "Используйте эту форму, для добавления, изменения и удаления каждого блока.";
 $lang['Module_include_admin']      = "Включить этот модуль в Административное Навигационное Меню";
 $lang['Translation_Tools']         = "Утилиты Перевода";
 $lang['Create_parameter']          = "Добавить новый Параметр";
 $lang['Parameter_admin']           = "Администрирование Параметров";
 $lang['Parameter_admin_explain']   = "Список всех параметров этой функции";
 $lang['Parameter_id']              = "Идентификатор";
 $lang['Parameter_function']        = "Функция";
 $lang['Preview_portal']            = "Предварительный просмотр портала";
 $lang['Page_admin']                = "Администрирование Страниц";
 $lang['Page_Config_updated']       = "Конфигурация Страниц Успешно Обновлена";
 $lang['Page_updated']              = "Информация о Страницах и Столбцах успешно обновлена";
 $lang['Click_return_page_admin']   = "%sВернуться к Администрированию Страниц%s";

 $lang['Module_delete_db']   = "Теперь модуль удалён из портала, но связанные с ним таблицы, в базе данных, всё ещё существуют. Хотите ли вы также удалить любые, связанные с этим модулем таблицы? Предупреждение: все их данные будут потеряны. Вы никогда не должны этого делать, если планируете обновлять или устанавливать заново ваш модуль.";
 $lang['Click_module_delete_db_yes']   = "%sУдалить все связанные с модулем таблицы из базы данных%s";


//
// Install Process
//
$lang['Welcome_install']			= "Добро Пожаловать в Руководство по Установке Портала MX";
$lang['Install_Instruction']		= "Спасибо за то, что выбрали Портал MX. Для завершения установки, пожалуйста заполните данную форму. Не забудьте, что PHPBB должен быть уже установлен и настроен. Портал не будет работать самостоятельно.";
$lang['Upgrade_Instruction']		= "mxBB-Portal is already installed. Please, make backups of your database now !<br /><br />The next step will modify the structure of your database (please note mxBB-Portal does not modify your phpBB database in any way). If for whatever reason this upgrade procedure fails, there would be no other way to return to your current state. Please, make backups of your database BEFORE proceeding !<br /><br />Once done, click the button below to start the upgrade procedure.";
$lang['Install_moreinfo']			= "%sRelease Notes%s | %sWelcome Pack%s | %sOnline FAQ%s | %sSupport Forums%s | %sTerms Of Use%s";
$lang['Install_settings']			= "Настройки Установки";
$lang['Choose_lang_explain']		= "Пожалуйста, используйте форму ниже, чтобы выбрать язык, который Вы хотите использовать при установке.";
$lang['Choose_lang']				= "Выбрать язык";
$lang['Language']					= "Язык";
$lang['Phpbb_path']					= "относительный путь к phpBB";
$lang['Phpbb_path_explain']			= "Относительный путь к установленному phpBB, т.н. phpbb2/ или ../phpbb2/ <br /> Примечание: здесь обязательно указывать слеши '/'";
$lang['Phpbb_url']					= "Полный URL к PHPBB";
$lang['Phpbb_url_explain']			= "Полный URL к PHPBB, например <br /> http://www.mydomain.com/phpbb2/";
$lang['Portal_url']                = "Полный URL к Порталу";
$lang['Portal_url_explain']        = "Полный URL к Порталу, например <br /> http://www.mydomain.com/";
$lang['Database_settings']			= "Настройка базы данных";
$lang['dbms']						= "Тип базы данных";
$lang['DB_Host']                   = "Имя узла базы данных (DSN)";
$lang['DB_Name']                   = "Имя вашей базы данных";
$lang['DB_Username']               = "Имя пользователя в базе данных";
$lang['DB_Password']               = "Пароль для базы данных";
$lang['Table_Prefix']              = "Префикс таблиц PhpBB в базе данных";
$lang['MX_Table_Prefix']           = "Префикс таблиц Портала MX в базе данных db";
$lang['Start_Install']             = "Начать Установку Портала MX";
$lang['Start_Upgrade']				= "Да, Я уже сделал копии и теперь хочу модернизировать свой mxBB-Портал.";
$lang['Portal_intalled']			= "Установка Портала успешно завершена :-) !";
$lang['Portal_upgraded']			= "Обновление Портала успешно завершен0 :-) !";
$lang['Unwriteable_config']        = "Ваш файл конфигурации (config.php) недоступен для записи или не существует.<br />Копия этого файла будет загружена, когда вы нажмёте кнопку внизу. <br />Вы должны загрузить потом этот файл обратно, в тот же каталог, куда установлен Портал MX : %s <br />Когда это будет сделано нажмите %Обновить%s для перехода к следующему шагу установки. <br />Можно сделать это и так (не рекомендуется):  вы должны будете создать таблицы вручную, выполнив скрипт mx_db_install.php. Затем, вы должны будете добавить правильный пути в таблицы базы данных Портала MX, использую свой любимый инструмент, для работы с базами данных. <br />Потом вы сможете войти в портал, используя имя и пароль администратора вашего портала/форума.<br />Спасибо за то, что выбрали Портал MX.";
$lang['Send_file']                 = "Просто пошлите файл мне, а я размещу его самостоятельно";
$lang['phpBB_nfnd_retry']			= "Извините, не найдена Вашу установка phpBB-форума. Пожалуйста, нажмите %Назад%s в Вашем броузере и попрубуйте повторить.";
$lang['Installation_error']			= "Во время установки произошла Ошибка";
$lang['Debug_Information']			= "DEBUG INFORMATION";
$lang['Install_phpbb_not_found']	= "Извините, мы не находим любой phpBB-форум установленный на этом сервере.<br />Пожалуйста, установите phpBB ПЕРЕД устоновкой mxBB-Portal.<br />\n<br />\n";
$lang['Install_phpbb_db_failed']	= "Извините, мы не можем подключиться к базе данных phpBB.<br />Пожалуйста, проверьте что ваше phpBB правильно установлено, и работает - ПЕРЕД установкой mxBB-Портала.<br />\n<br />\n";
$lang['Install_phpbb_unsupported']	= "К несчастью, phpBB установленный на этом сервере не поддерживается mxBB-Порталом<br />Пожалуйста, проверьте требования по установке тр<br />\n<br />\n";
$lang['Install_noscript_warning']	= "Извините, установка требует браузера с возможностью JavaScript. Это не может работать в вашем броузере.";
$lang['Upgrade_are_you_sure']		= "Эта процедура сделает изменения в Вашей базе данных. Уверены и хотите приступить?";
$lang['Writing_config']				= "Запись config.php файла";
$lang['Processing_schema']			= "Обработка SQL Schema '%s'";
$lang['Portal_intalling']			= "Установленный mxBB-Portal версия %s";
$lang['Portal_upgrading']			= "Модифицированный mxBB-Portal версия %s";
$lang['Install_warning']			= "Было 1 предупреждая обновление базы данных";
$lang['Install_warnings']			= "Были %d предупреждения, обновляющие базу данных";
$lang['Subscribe_mxBB_News_now']	= "Рекомендуем подписаться на рассылку %smxBB-News Mailing List%s чтобы получать информацию о важных новостях и объявлениях.<br />&nbsp;<br />%sПодписаться на mxBB-News, сейчас!%s";
$lang['Portal_install_done'][0]		= "Ваша основная установка завершена.";
$lang['Portal_install_done'][1]		= "Пожалуйста, удалите /install и /contrib директории ПЕРЕД дальнейшим действием!!!";
$lang['Portal_install_done'][2]		= "Не забывайте делать копии, по возможности, как можно более часто ;-)";
$lang['Portal_install_done'][3]		= "Нажмите кнопку ниже и используйте Ваше имя Администратора и пароль, чтобы войти в систему.";
$lang['Portal_install_done'][4]		= "Пожалуйста не забудьте проверить Конфигурацию Портала и необходимые изменения.";
$lang['Thanks_for_choosing']		= "Спасибо за то, что выбрали Портал MX.";
$lang['Critical_Error']				= "КРИТИЧЕСКАЯ ОШИБКА";
$lang['Error_loading_config']		= "Извините, не могу загрузить mxBB-Портал config.php";
$lang['Error_database_down']		= "Извините, не могу подключиться к базе данных.";


//
// New for v. 2.704
//

 $lang['Page_Id']                   = "Идентификатор Страницы";
 $lang['Page_icon']                 = "Пиктограмма Страницы <br /> - только для использования в КП администратора, т.н. icon_home.gif (по умолчанию)";
 $lang['Page_header']               = "Файл заголовка страницы <br /> - т.н. overall_header.php (по умолчанию), overall_noheader.php (без заголовка) или заголовок, определённый пользователем.";
 $lang['Auth_Page']                 = "Разрешения";

 $lang['Cache_dir_write_protect']   = "Ваш каталог для кэширования не доступен для записи, не возможно создать кэш-файлы";
 $lang['Cache_generate']            = "Ваши кэш-файлы созданы";
 $lang['Cache_submit']              = "создать кэш-файлы?";
 $lang['Cache_explain']             = "Эта опция позволяет создать xml файлы (кэш-файлы) для данной конфигурации портала. Эти файлы позволят снизить число обращений к базе данных и повысить производительность портала. В данный момент эта опция не автоматизирована, таким образом вы должны будете создавать эти файлы заново после каждой модификации конфигурации вашего портала, в противном случае модификации не отобразятся.";


//
// New for v. 2.705
//

$lang['install_phpbbdir_notgiven']	= 'Вы должны указать относительный путь к вашему форуму phpbb.';
$lang['install_phpbbdir_missing']	= 'Указанный относительный путь к phpbb - некорректен.';
$lang['install_pathes_equal']		= 'Путь к phpbb и MX-System - совпадают. Вы должны устанавливать MX-System в папку, отличную от той, в которой установлен phpbb.';

//
// New for v. 2.706
//

$lang['MX_Portal']	= 'Портал MX';
$lang['MX_Modules']	= 'Модули MX';
$lang['Phpbb']		= 'phpBB';

//
// New for v. 2.706
//

$lang['Top_phpbb_links'] = "Показывать ссылки заголовка phpbb <br /> - новые/непрочитанные сообщения и т.д. на домашней странице портала";
$lang['Auth_Page_group'] = "-> ЧАСТНАЯ Группа";

// New for v. 2.71
$lang['Error_no_db_install'] = "Ошибка: Файл db_install.php не существует. Пожалуйста, проверьте это и попробуйте ещё раз...";
$lang['Error_no_db_uninstall'] = "Ошибка: Файл db_uninstall.php не существует или удаление этого модуля не предусмотрено. Пожалуйста, проверьте это и попробуйте ещё раз...";
$lang['Error_no_db_upgrade'] = "Ошибка: Файл db_upgrade.php не существует или обновление этого модуля не предусмотрено. Пожалуйста, проверьте это и попробуйте ещё раз...";
$lang['Error_module_installed'] = "Ошибка: Этот модуль уже установлен! Пожалуйста, удалите модуль сначала или воспользуйтесь обновлением вместо установки.";

$lang['Menu_links']                = "URL в меню <br /> - ссылка на внешнюю страницу";
$lang['Menu_page']                 = "Страница меню (по умолчанию/стандартно) <br /> - ссылка на внутреннюю страницу портала <br /> ПРИМЕЧАНИЕ: Страницы создаются в Администрировании Страниц.";
$lang['Menu_block']                = "Блок меню (только для разработчиков) <br /> - ссылка на специфический блок mx";
$lang['Menu_function']             = "Функция меню (только для разработчиков) <br /> - ссылка на специфическую функцию mx";
$lang['Menu_action_title']         = "<b>Действие меню:</b> <br /><i>(Выберете одну из четырёх опций.)</i> ";
$lang['Menu_action_adv']           = "<b>Расширенное действие меню:</b> <br /><i>(Используйте осторожно - предназначено только для разработчиков):</i>";
$lang['Menu_permissions_title']    = "<b>ПРОСМОТРЕТЬ/ИЗМЕНИТЬ РАЗРЕШЕНИЯ:</b>";
$lang['Link_target']                = "Открывать ссылку:";
$lang['Portal_version']                = "Версия Портала Mx:";

$lang['PHPBB_info']                = "Информация о PHPBB";
$lang['PHPBB_version']                = "Версия PHPBB:";
$lang['PHPBB_script_path']                = "Путь к скриптам PHPBB (script_path):";
$lang['PHPBB_server_name']                = "Домен PHPBB (server_name):";

// New for v. 2.7.3
$lang['Return_to_page']                = "Вернуться на Домашнюю Страницу Портала";

//
// That's all Folks!
// -------------------------------------------------
?>