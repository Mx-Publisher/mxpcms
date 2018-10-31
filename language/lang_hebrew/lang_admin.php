<?php
/**
 *
 * @ Package MX-Publisher Core
 * @version $ Id: lang_admin.php, v 1.95 2013/06/28 17:08:52 orynider Exp $
 * @copyright (c) 2002-2008 MX-Publisher Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
 * @ link http://mxpcms.sourceforge.net/
 *
 * Encoding: utf-8
 * 1 tab = 4 spaces
 */
 
setlocale(LC_ALL, 'he');

if ( !isset($lang) )
{
	$lang = array();
}

$lang = array_merge( $lang, array( // #
	'ENCODING'								=> 'UTF-8',
	'DIRECTION'								=> 'rtl',
	'LEFT'									=> 'left',
	'RIGHT'									=> 'right',
	'DATE_FORMAT'							=> 'd/M/Y',  // This should be changed to the default date format for your language, php date() format
	'Mx-Publisher_adminCP'					=> 'MX-Publisher Administration',
	'Portal_Desc'							=> 'טקסט קטן לתיאור האתר שלך',
	
	/*
	* Left AdminCP Panel
	*/
	'1_General_admin'						=> 'כללי',
	'1_1_Management'						=> 'תצורה',
	'1_2_WordCensors'						=> 'צנזורה של מילים',
	
	'2_CP'									=> 'ניהול',
	'2_1_Modules'							=> 'הגדרת מודולים <br /> <hr>',
	'2_2_ModuleCP'							=> 'לוח הבקרה של המודול',
	'2_3_BlockCP'							=> 'חסום את לוח הבקרה',
	'2_4_PageCP'							=> 'לוח הבקרה של הדף',
	
	'3_CP'									=> 'סגנונות',
	'2_1_new'								=> 'הוסף חדש',
	'2_2_manage'							=> 'נהל',
	'2_3_smilies'							=> 'סמיילים',
	
	'4_Panel_system'						=> 'כלי מערכת',
	'4_1_Cache'								=> 'הפעל מחדש את הקובץ השמור',
	'4_1_Integrity'							=> 'בודק אינטגריטי',
	'4_1_Meta'								=> 'תגי מטה',
	'4_1_PHPinfo'							=> 'phpInfo ()',
	'4_2_Translate'							=> 'תרגום פאנל',
	
	/*
	* Index
	*/
	'Welcome_Mx-Publisher'					=> 'ברוכים הבאים ל- MX-Publisher',
	'Admin_intro_Mx-Publisher'				=> 'תודה שבחרת ב- MX-Publisher כפתרון הפורטל / cms שלך ו- phpBB כפתרון הפורום שלך. מסך זה ייתן לך סקירה מהירה של כל הנתונים הסטטיסטיים השונים של האתר שלך. תוכל לחזור לדף זה על ידי לחיצה על הקישור <span style = "text-decoration: underline;"> מנהל מערכת </ span> בחלונית השמאלית. כדי לחזור למדד הלוח שלך, לחץ על הלוגו שנמצא גם בחלונית השמאלית. הקישורים האחרים בצד שמאל של המסך הזה יאפשר לך לשלוט בכל היבט של הפורטל שלך ואת חוויית הפורום. לכל מסך יהיו הוראות כיצד להשתמש בכלים המסופקים.">מנהל מערכת </ span> בחלונית השמאלית. כדי לחזור למדד הלוח שלך, לחץ על הלוגו שנמצא גם בחלונית השמאלית. הקישורים האחרים בצד שמאל של המסך הזה יאפשר לך לשלוט בכל היבט של הפורטל שלך ואת חוויית הפורום. לכל מסך יהיו הוראות כיצד להשתמש בכלים המסופקים. ">תודה שבחרת ב- MX-Publisher כפתרון הפורטל / cms שלך ו- phpBB כפתרון הפורום שלך. מסך זה ייתן לך סקירה מהירה של כל הנתונים הסטטיסטיים השונים של האתר שלך. תוכל לחזור לדף זה על ידי לחיצה על הקישור <span style = "text-decoration: underline;"> מנהל מערכת </ span> בחלונית השמאלית. כדי לחזור למדד הלוח שלך, לחץ על הלוגו שנמצא גם בחלונית השמאלית. הקישורים האחרים בצד שמאל של המסך הזה יאפשר לך לשלוט בכל היבט של הפורטל שלך ואת חוויית הפורום. לכל מסך יהיו הוראות כיצד להשתמש בכלים המסופקים.',
	'Version_information'							=> 'מידע גרסה',
	/*
	* General
	*/
	'Yes'										=> 'כן',
	'No'										=> 'לא',
	'No_modules'							=> 'לא מותקנים מודולים.',
	'No_functions'							=> 'למודול זה אין פונקציות בלוק.',
	'No_parameters'						=> 'לפונקציה זו אין פרמטרים.',
	'No_blocks'								=> 'אין בלוקים לפונקציה זו.',
	'No_pages'								=> 'אין דפים כאן.',
	'No_settings'							=> 'אין הגדרות נוספות עבור בלוק זה.',
	'Quick_nav'								=> 'ניווט מהיר',
	'Include_all_modules'					=> 'List all modules',
	'Include_block_quickedit'				=> 'Include Block QuickEdit panel',
	'Include_block_private'				=> 'Include Block Private Auth Panel',
	'Include_all_pages'					=> 'List all pages',
	'View'									=> 'תצוגה',
	'Edit'										=> 'ערוך',
	'Delete'									=> 'מחק',
	'Settings'									=> 'הגדרות',
	'Move_up'								=> 'הזז למעלה',
	'Move_down'							=> 'הזז למטה',
	'Resync'									=> 'Resync',
	'Update'									=> 'עדכון',
	'Permissions'							=> 'הרשאות',
	'Permissions_std'						=> 'הרשאות רגילות',
	'Permissions_adv'						=> 'הרשאות מתקדמות',
	'return_to_page'						=> 'חזרה לדף הפורטל',
	'Use_default'							=> 'השתמש בהגדרת ברירת המחדל',
	
	'AdminCP_status'						=> '<b> דוח התקדמות </b>',
	'AdminCP_action'						=> '<b> פעולת מסד נתונים </b>',
	'Invalid_action'						=> 'שגיאה',
	'was_installed'							=> 'הותקן.',
	'was_uninstalled'						=> 'הוסר.',
	'was_upgraded'							=> 'שודרג',
	'was_exported'							=> 'יוצא',
	'was_deleted'							=> 'נמחק',
	'was_removed'							=> 'הוסר',
	'was_inserted'							=> 'הוכנס',
	'was_updated'							=> 'עודכן',
	'was_added'								=> 'נוסף',
	'was_moved'							=> 'הועבר',
	'was_synced'							=> 'סונכרן',
	
	'error_no_field'							=> 'יש שדה חסר. נא למלא את כל השדות הדרושים.',
	'Cookie_settings_mxp'				=> 'הגדרות קובצי Cookie / פעילות באתר',
	'Cookie_settings_explain_mxp'		=> 'פרטים אלה מגדירים כיצד קובצי cookie / session נשלחים לדפדפני המשתמשים שלך. ברוב המקרים, ערכי ברירת המחדל עבור הגדרות קובצי ה- cookie צריכים להיות מספיקים, אך אם עליך לשנות אותם לעשות זאת עם טיפול - הגדרות שגויות יכולות למנוע ממשתמשים להיכנס.',
	
	/*
	* Configuration
	*/
	'Portal_admin'									=> 'ניהול פורטל',
	'Portal_admin_explain'						=> 'השתמש בטופס זה כדי להתאים אישית את הפורטל שלך',
	'Portal_General_Config'						=> 'תצורת פורטל',
	'Portal_General_Config_explain'			=> 'השתמש בטופס זה כדי לנהל את ההגדרות העיקריות של האתר שלך ב- MX-Publisher.',
	'Portal_General_settings'						=> 'הגדרות כלליות',
	'Portal_Style_settings'							=> 'הגדרות סגנון',
	'Portal_General_config_info'				=> 'מידע כללי על פורטל הפורטל',
	'Portal_General_config_info_explain'		=> 'פרטי התקנה נוכחיים מ- config.php (ללא צורך בעריכה)',
	'Portal_Name'									=> 'שם הפורטל:',
	'Portal_PHPBB_Url'							=> 'כתובת אתר להתקנת phpBB שלך:',
	'Portal_Url'										=> 'Portal URL - MX-Publisher:',
	'Portal_Config_updated'						=> 'תצורת הפורטל עודכנה בהצלחה',
	'Click_return_portal_config'					=> 'לחץ על%s כאן %s כדי לחזור לתצורת פורטל',
	'PHPBB_info'									=> 'phpBB Info',
	'PHPBB_version'								=> 'phpBB גרסה:',
	'PHPBB_script_path'							=> 'נתיב סקריפט phpBB:',
	'PHPBB_server_name'						=> 'phpBB תחום (server_name):',
	'MX_Portal'										=> 'MX-Publisher',
	'MX_Modules'									=> 'MXP מודולים',
	'Phpbb'											=> 'phpBB',
	'Top_phpbb_links'								=> 'phpBB סטטיסטיקה בכותרת (ערך ברירת המחדל)',
	'Top_phpbb_links_explain'					=> 'קישורים לפוסטים חדשים שלא נקראו',
	'Portal_version'								=> 'MX-Publisher Version:',
	'Mx_use_cache'								=> 'MX-Publisher Block Cache - השתמש ב',
	'Mx_use_cache_explain'						=> 'נתוני חסימה מאוחסנים במטמון לקובצי מטמון / בלוקים בודדים _ *. xml. קובצי מטמון לחסום נוצרים / מתעדכנים כאשר בלוקים נערכים.',
	'Mx_mod_rewrite'								=> 'Mod-Rewrite - השתמש ב',
	'Mx_mod_rewrite_explain'					=> 'אם אתה רץ בשרת Apache ויש לך mod_rewrite מופעל, אתה יכול לשכתב כתובות URL; לדוגמה, תוכל לכתוב מחדש דפים כגון page = x	mx_mod_rewrite עם חלופות אינטואיטיביות יותר. עיין בתיעוד נוסף עבור המודול .',
	'Portal_Overall_header'						=> 'קובץ כותרת כולל (ערך ברירת מחדל)',
	'Portal_Overall_header_explain'			=> 'זהו הקובץ default_header בתבנית ברירת המחדל, למשל. overall_header.tpl.',
	'Portal_Overall_footer'						=> 'קובץ כותרת תחתונה כללית (ערך ברירת מחדל)',
	'Portal_Overall_footer_explain'				=> 'זהו הקובץ הכולל total_footer בתבנית ברירת המחדל, למשל. overall_footer.tpl.',
	'Portal_Main_layout'							=> 'קובץ פריסה ראשי (ערך ברירת מחדל)',
	'Portal_Main_layout_explain'				=> 'זהו קובץ ברירת המחדל main_layout בתבנית, למשל. mx_main_layout.tpl.',
	'Portal_Navigation_block'					=> 'בלוק ניווט כולל (ערך ברירת מחדל)',
	'Portal_Navigation_block_explain'			=> 'זהו בלוק הניווט של כותרת הדף, בתנאי שתבחר קובץ כותרת כולל התומך בניווט הדף',
	'Default_style'									=> 'סגנון דפי פורטל (ברירת מחדל)',
	'Default_admin_style'							=> 'AdminCP סגנון',
	'Select_page_style'							=> 'בחר (או השתמש בברירת מחדל)',
	'Override_style'									=> 'דרוס סגנון משתמש',
	'Override_style_explain'						=> 'החלפת סגנון משתמשים עם ברירת המחדל (עבור דפים)',
	'Portal_status'									=> 'אפשר פורטל',
	'Portal_status_explain'						=> 'מתג שימושי, בעת שחזור האתר. רק מנהל הוא מסוגל להציג דפים ולגלוש סביב בדרך כלל. כאשר מושבת, ההודעה הבאה מוצגת.',
	'Disabled_message'							=> 'הודעה מושבתת פורטל',
	'Portal_Backend'								=> 'Portal / Backend',
	'Portal_Backend_explain'					=> 'בחרו בפגישות פנימיות, phpBB3 או phpBB2 ומשתמשים',
	'Portal_Backend_path'						=> 'Forum [non-internal] - נתיב יחסי ל',
	'Portal_Backend_path_explain'				=> 'אם משתמשים בפגישות ובמשתמשים שאינם פנימיים, הזן את הנתיב היחסי ל- phpbb, לדוגמה \' phpBB2 /	או	..	phpBB2	. הערה: חתכים חשובים.',
	'Portal_Backend_submit'						=> 'Backend שינוי ואמת',
	'Portal_config_valid'							=> 'מצב רקע נוכחי:',
	'Portal_config_valid_true'					=> '<b> <font color = "green"> חוקי </ font> </b>">חוקי </ font> </b>"><b> <font color = "green"> חוקי </ font> </b>',
	'Portal_config_valid_false'					=> '</b> "><b> <font color = "red>> הגדרה פגומה. או שהנתיב היחסי שלך phpBB אינו תקין או ש- phpBB מוסר (מסד הנתונים של phpBB אינו זמין). לפיכך,	"פנימי " backend משמש. </ Font> </b>">> הגדרה פגומה. או שהנתיב היחסי שלך phpBB אינו תקין או ש- phpBB מוסר (מסד הנתונים של phpBB אינו זמין). לפיכך,	"פנימי " backend משמש. </ Font> </b> "><b> <font color = "red>> הגדרה פגומה. או שהנתיב היחסי שלך phpBB אינו תקין או ש- phpBB מוסר (מסד הנתונים של phpBB אינו זמין). לפיכך,	"פנימי " backend משמש. </ Font> </b>',
	'Phpbb_path'									=> 'phpBB נתיב יחסי',
	'Phpbb_path_explain'						=> 'נתיב יחסי ל- phpBB, לדוגמה. phpBB / או ../phpBB/ <br /> שים לב לחתכים "/", הם חשובים!',
	'Phpbb_url'										=> 'כתובת phpBB מלאה',
	'Phpbb_url_explain'							=> 'כתובת phpBB מלאה, לדוגמה. <br /> http://www.example.com/phpBB/',
	'Portal_url'										=> 'כתובת אתר מלאה של הפורטל',
	'Portal_backend'								=> 'Portal Backend',
	'Portal_url_explain'							=> 'כתובת אתר מלאה של הפורטל, לדוגמה. <br /> http://www.example.com/',
	
	/*
	* Module Management
	*/
	'Module_admin'								=> 'ניהול מודול',
	'Module_admin_explain'						=> 'השתמש בטופס זה כדי לנהל מודולים: התקנה, שדרוג ופיתוח מודול. <br /> <b> כדי להשתמש בפנל זה, עליך להפעיל JavaScript וקובצי cookie בדפדפן שלך. </b >',
	'Modulecp_admin'								=> 'לוח הבקרה של המודול',
	'Modulecp_admin_explain'					=> 'השתמש בטופס זה לניהול מודולים: פונקציות בלוק (פרמטרים) וגושי פורטל. <br /> <b> כדי להשתמש בחלונית זו, עליך להפעיל JavaScript וקובצי Cookie בדפדפן שלך < / b>',
	'Modules'										=> 'מודולים',
	'Module'											=> 'מודול',
	'Module_delete'								=> 'מחיקת מודול',
	'Module_delete_explain'						=> 'השתמש בטופס זה כדי למחוק מודול (או לחסום פונקציה)',
	'Edit_module'									=> 'עריכת מודול',
	'Create_module'								=> 'צור מודול חדש',
	'Module_name'								=> 'שם מודול',
	'Module_desc'									=> 'תיאור מודול',
	'Module_path'									=> 'נתיב modules/mx_textblocks/, ל	דוגמה',
	'Module_include_admin'						=> 'AdminCP כלול את המודול הזה בניווט של',
	
	/*
	* Module Installation
	*/
	'Module_delete_db'							=> 'האם אתה באמת רוצה להסיר את ההתקנה של המודול? אזהרה: תאבד את כל נתוני המודול. שקול לשדרג במקום זאת.',
	'Click_module_delete_yes'					=> 'לחץ על%s כאן %s כדי להסיר את ההתקנה של המודול',
	'Click_module_upgrade_yes'				=> 'לחץ על%s כאן %s כדי לשדרג את המודול',
	'Click_module_export_yes'					=> 'לחץ על%s כאן %s כדי לייצא את המודול',
	'Error_no_db_install'							=> 'שגיאה: הקובץ db_install.php אינו קיים. אמת את זה ונסה שוב.',
	'Error_no_db_uninstall'						=> 'שגיאה: הקובץ db_uninstall.php אינו קיים, או שתכונת הסרת ההתקנה אינה נתמכת עבור מודול זה. אמת את זה ונסה שוב.',
	'Error_no_db_upgrade'						=> 'שגיאה: הקובץ db_upgrade.php אינו קיים, או שתכונת השדרוג אינה נתמכת עבור מודול זה. אמת את זה ונסה שוב.',
	'Error_module_installed'						=> 'שגיאה: מודול זה כבר מותקן! אנא מחק תחילה את המודול או שדרג את המודול.',
	'Uninstall_module'								=> 'הסרת מודול',
	'import_module_pack'						=> 'התקן מודול',
	'import_module_pack_explain'				=> 'פעולה זו תתקין מודול לפורטל. ודא כי החבילה של המודול מועלה לתיקייה / modules /. זכור להשתמש בגרסת המודול האחרונה!',
	'upgrade_module_pack'						=> 'מודול שדרוג',
	'upgrade_module_pack_explain'			=> 'פעולה זו תשדרג את המודול שלך. הקפד לקרוא את התיעוד של המודול לפני שתמשיך, או שתסכן את אובדן נתוני המודול.',
	'export_module_pack'						=> 'ייצוא מודול',
	'Export_Module'								=> 'בחירת מודול:',
	'export_module_pack_explain'				=> 'פעולה זו תייצא קובץ מודול * .pak. זה מיועד סופרים מודול; משתמשים רגילים לא צריכים לדאוג בקשר לזה.',
	'Module_Config_updated'					=> 'תצורת מודול עודכנה בהצלחה',
	'Click_return_module_admin'				=> 'לחץ על%s כאן %s כדי לחזור אל Module Administration',
	'Module_updated'								=> 'מידע מודול עודכן בהצלחה',
	'list_of_queries'									=> 'זוהי רשימת התוצאות של שאילתות SQL הדרושות להתקנה / שדרוג',
	'already_added'								=> 'ALREADY_ADDED',
	'added_upgraded'								=> 'הוספה / עדכון',
	'upgrading_modules'							=> 'אם אתה מקבל כמה שגיאות, כבר הוספה או עדכון הודעות, להירגע, זה נורמלי בעת עדכון mods',
	'consider_upgrading'							=> 'CONSIDER_UPGRADING',
	'upgrading'										=> 'שדרוג',
	'module_upgrade'								=> 'זהו שדרוג',
	'nothing_upgrade'								=> 'דבר לשדרוג ...',
	'upgraded_to_ver'								=> '... .גרסה-v-עכשיו שודרג ל ',
	'module_not_installed'						=> 'מודול לא מותקן ... ולכן לא ניתן לשדרג',
	'fresh_install'									=> 'זוהי התקנה חדשה',
	'module_install_info'							=> 'Mod התקנה / שדרוג / הסרת מידע - mod ספציפיים db טבלאות',
	
	/*
	* Functions & Parameters Administration
	*/
	'Function_admin'								=> 'בלוק פונקציה ניהול',
	'Function_admin_explain'					=> 'למודולים יש בלוק אחד או יותר. השתמש בטופס זה כדי לערוך, להוסיף או למחוק פונקציית בלוק',
	'Function'										=> 'בלוק פונקציה',
	'Function_name'								=> 'חסום את שם הפונקציה',
	'Function_desc'								=> 'תיאור',
	'Function_file'									=> 'קובץ',
	'Function_admin_file'							=> 'קובץ (עריכת סקריפט לחסימה) <br /> פרמטרים נוספים עבור לוח העריכה הזה. השאר ריק כדי להשתמש בלוח העריכה המוגדר כברירת מחדל.',
	'Create_function'								=> 'הוסף בלוק חדש פונקציה',
	'Delete_function'								=> 'מחק בלוק פונקציה',
	'Delete_function_explain'				=> 'פעולה זו תמחק את הפונקציה ואת כל גושי הפורטל המשויכים אליה. היזהר: פעולה זו לא ניתן לבטל!',
	'Click_function_delete_yes'				=> 'לחץ על%s כאן %s כדי למחוק את הפונקציה',
	
	'Parameter_admin'						=> 'ניהול פרמטרים של פונקציה',
	'Parameter_admin_explain'				=> 'רשום את כל הפרמטרים עבור פונקציה זו',
	'Parameter'								=> 'פרמטר',
	'Parameter_name'						=> '<b> שם הפרמטר </b> <br /> - כדי לשמש לפרמטר',
	'Parameter_type'						=> '<b> סוג פרמטר </b>',
	'Parameter_desc'						=> '<b> תיאור פרמטר </b>',
	'Parameter_default'						=> '<b> ערך ברירת מחדל </b>',
	'Parameter_function'					=> '<b> פונקציה / אפשרויות </b>',
	'Parameter_function_explain'			=> '<b>Function</b> (when using the \'Function\' type)<br />- You may pass the parameter data to an external function <br /> to generate the parameter form field.<br />- For example: <br />get_list_formatted("block_list","{parameter_value}","{parameter_id}[]")<br /><br /><b>Option(s)</b> (when using \'Selection\' parameter types)<br />- For all selection parameters (radiobuttons, checkboxes and menus) all options are listed here, one option per line."><br /><b>Option(s)</b> (when using \'Selection\' parameter types)<br />- For all selection parameters (radiobuttons, checkboxes and menus) all options are listed here, one option per line."><b>Function</b> (when using the \'Function\' type)<br />- You may pass the parameter data to an external function <br /> to generate the parameter form field.<br />- For example: <br />get_list_formatted("block_list","{parameter_value}","{parameter_id}[]")<br /><br /><b>Option(s)</b> (when using \'Selection\' parameter types)<br />- For all selection parameters (radiobuttons, checkboxes and menus) all options are listed here, one option per line.',
	'Parameter_auth'						=> '<b> מנהל מערכת / בלוק בלבד </b>',
	
	/*
	* Parameter Types
	*/
	'Parameters'								=> 'פרמטרים',
	'Parameter_id'								=> 'מזהה',
	'Create_parameter'						=> 'הוסף פרמטר חדש',
	'Delete_parameter'						=> 'מחק פרמטר פונקציה',
	'Delete_parameter_explain'				=> 'פעולה זו תמחק את הפרמטר ותעדכן את כל אבני הפורטל המשויכות. היזהר: פעולה זו לא ניתן לבטל!',
	'Click_parameter_delete_yes'			=> 'לחץ על%s כאן %s כדי למחוק את הפרמטר',
	'ParType_BBText'							=> 'Simple BBCode Textblock',
	'ParType_BBText_info'					=> 'זהו טקסט פשוט שמנתח את BBCode',
	'ParType_Html'							=> 'HTML Textblock פשוט',
	'ParType_Html_info'						=> 'HTML זהו טקסט פשוט, ניתוח',
	'ParType_Text'								=> 'טקסט רגיל (שורה אחת)',
	'ParType_Text_info'						=> 'זהו שדה טקסט פשוט',
	'ParType_TextArea'						=> 'טקסט רגיל (שורה מרובה)',
	'ParType_TextArea_info'				=> 'זהו שדה טקסטרי פשוט',
	'ParType_Boolean'						=> 'בוליאני',
	'ParType_Boolean_info'					=> 'זהו מתג רדיו \' כן	או',
	'ParType_Number'						=> 'מספר רגיל',
	'ParType_Number_info'					=> 'זהו שדה מספר פשוט',
	'ParType_Function'						=> 'פרמטר פונקציה',
	'ParType_Values'							=> 'ערכים',
	
	'ParType_Radio_single_select'			=> 'לחצני רדיו בודדים לבחירה',
	'ParType_Radio_single_select_info'	=> 'PARTYPE_RADIO_SINGLE_SELECT_INFO',
	'ParType_Menu_single_select'			=> 'תפריט בחירה יחיד',
	'ParType_Menu_single_select_info'	=> 'PARTYPE_MENU_SINGLE_SELECT_INF',
	'ParType_Menu_multiple_select'		=> 'תפריט בחירה מרובה',
	'ParType_Checkbox_multiple_select'	=> 'תיבת בחירה של בחירה מרובה',
	'ParType_Checkbox_multiple_select_info'	=> 'PARTYPE_CHECKBOX_MULTIPLE_SELECT_INF',
	
	/*
	* Blocks Administration
	*/
	'Block_admin'							=> 'חסום את לוח הבקרה',
	'Block_admin_explain'				=> 'השתמש בטופס זה כדי לנהל את גושי הפורטל. <br /> <b> כדי להשתמש בחלונית זו, עליך להפעיל JavaScript וקובצי cookie בדפדפן שלך! </b>',
	'Block'									=> 'חסום',
	'Show_title'								=> 'הצג את כותרת הבלוק?',
	'Show_title_explain'					=> 'האם להציג את כותרת הבלוק או לא',
	'Show_block'							=> '?הצג בלוק',
	'Show_block_explain'					=> '- אם \' לא	, הבלוק מוסתר לכל המשתמשים, למעט מנהלי המערכת',
	'Show_stats'							=> 'הצג נתונים סטטיסטיים?',
	'Show_stats_explain'					=> '- אם \' כן	נערך על ידי ...	יוצג מתחת לבלוק',
	'Show_blocks'							=> 'הצגת בלוקים של פונקציה',
	'Block_delete'							=> 'מחיקת בלוק',
	'Block_delete_explain'					=> 'השתמש בטופס זה כדי למחוק בלוק (או עמודה)',
	'Block_title'							=> 'כותרת',
	'Block_desc'							=> 'תיאור',
	'Add_Block'								=> 'הוסף בלוק חדש',
	'Auth_Block'							=> 'הרשאות',
	'Auth_Block_explain'					=> 'ALL: כל המשתמשים <br /> REG: משתמשים רשומים <br /> פרטי: חברי הקבוצה (ראה הרשאות מתקדמות) <br /> MOD: מנהלי בלוקים (ראה הרשאות מתקדמות) <br / > מנהל: Admin <br /> ANONYMOUS: משתמשים אורחים בלבד',
	'Block_quick_stats'						=> 'נתונים סטטיסטיים מהירים',
	'Block_quick_edit'						=> 'עריכה מהירה',
	'Create_block'							=> 'צור בלוק חדש',
	'Delete_block'							=> 'מחק בלוק פורטל',
	'Delete_block_explain'					=> 'פעולה זו תמחק את החסימה ותעדכן את כל דפי הפורטל המשויכים. היזהר: פעולה זו לא ניתן לבטל!',
	'Click_block_delete_yes'				=> 'לחץ על%s כאן %s כדי למחוק את החסימה',
	
	/*
	* BlockCP Administration
	*/
	'Block_cp'										=> 'Block Control Pannel',
	'Click_return_blockCP_admin'				=> 'לחץ על%s כאן %s כדי לחזור ללוח הבקרה',
	'Click_return_portalpage_admin'			=> 'לחץ על%s כאן %s כדי לחזור לדף הפורטל',
	'BlockCP_Config_updated'					=> 'בלוק זה עודכן.',
	
	/*
	* Pages Administration
	*/
	'Page_admin'								=> 'ניהול דף',
	'Page_admin_explain'					=> 'השתמש בטופס זה כדי להוסיף, למחוק ולשנות את ההגדרות עבור דפי פורטל ותבניות דף. <br /> <b> כדי להשתמש בחלונית זו, עליך להפעיל JavaScript וקובצי Cookie בדפדפן שלך ! </b>',
	'Page_admin_edit'							=> 'עריכת דף',
	'Page_admin_private'						=> 'הרשאות דף מתקדם (פרטי)',
	'Page_admin_settings'					=> 'הגדרות דף',
	'Page_admin_new_page'				=> 'ניהול דף חדש',
	'Page'										=> 'דף',
	'Page_Id'									=> 'מזהה דף',
	'Page_icon'									=> 'סמל דף <br /> - לשימוש ב- adminCP בלבד, לדוגמה. icon_home.gif (ברירת מחדל)',
	'Page_alt_icon'								=> 'סמל דף חלופי <br /> - כתובת אתר מלאה (http: // ...) לסמל דף מותאם אישית.',
	'Default_page_style'						=> 'סגנון הפורטל (ברירת מחדל) <br /> כדי להשתמש בהגדרת ברירת המחדל, השאר את זה לא מוגדר.',
	'Override_page_style'						=> 'דרוס סגנון משתמש',
	'Override_page_style_explain'			=> 'OVERRIDE_PAGE_STYLE_EXPLAIN',
	'Page_header'								=> 'קובץ כותרת הדף <br /> - ie8_herer.tpl (default), total_noheader.tpl (ללא כותרת) או קובץ כותרת מותאמת אישית של משתמש. <br /> כדי להשתמש בהגדרת ברירת המחדל, השאר זאת ריק.',
	'Page_footer'								=> 'קובץ כותרת תחתונה של הדף <br /> - כלומר_גירסה כללית או קובץ תחתונה מותאם אישית של משתמש. <br /> כדי להשתמש בהגדרת ברירת המחדל, השאר את השדה ריק.',
	'Page_main_layout'						=> 'קובץ הפריסה הראשי של הדף <br /> - כלומר mx_main_layout.tpl (ברירת מחדל) או קובץ כותרת מותאם אישית של משתמש. <br /> כדי להשתמש בהגדרת ברירת המחדל, השאר את השדה ריק.',
	'Page_Navigation_block'					=> 'בלוק הניווט של כותרת הדף',
	'Page_Navigation_block_explain'		=> '- זהו בלוק הניווט של כותרת הדף, בתנאי שתבחר קובץ כותרת כולל שתומך בניווט הדף. <br /> כדי להשתמש בהגדרת ברירת המחדל, השאר זאת ללא הגדרה.',
	'Auth_Page'									=> 'הרשאות',
	'Select_sort_method'						=> 'בחר שיטת מיון',
	'Order'										=> 'הזמנה',
	'Sort'											=> 'מיון',
	'Width'										=> 'רוחב',
	'Height'										=> 'גובה',
	'Page_sort_title'							=> 'כותרת הדף',
	'Page_sort_desc'							=> 'תיאור הדף',
	'Page_sort_created'						=> 'הדף נוצר',
	'Sort_Ascending'							=> 'ASC',
	'Sort_Descending'							=> 'DESC',
	'Return_to_page'							=> 'חזור לדף הפורטל',
	'Auth_Page_group'						=> '-> קבוצה פרטית',
	'Page_desc'									=> 'תיאור',
	'Page_parent'								=> 'דף אב',
	'Add_Page'									=> 'הוסף דף חדש',
	'Page_Config_updated'					=> 'תצורת הדף עודכנה בהצלחה',
	'Click_return_page_admin'				=> 'לחץ%s כאן %s כדי לחזור אל ניהול דף',
	'Remove_block'							=> 'הסרת חסימת פורטל',
	'Remove_block_explain'					=> 'פעולה זו תסיר את הבלוק מדף זה. היזהר: פעולה זו לא ניתן לבטל!',
	'Click_block_remove_yes'				=> 'לחץ על%s כאן %s כדי להסיר את הבלוק',
	'Delete_page'								=> 'מחק דף',
	'Delete_page_explain'					=> 'פעולה זו תמחק את הדף. היזהר: פעולה זו לא ניתן לבטל!',
	'Click_page_delete_yes'					=> 'לחץ על%s כאן %s כדי למחוק את הדף',
	
	'Mx_IP_filter'								=> 'IP מסנן',
	'Mx_IP_filter_explain'						=> 'כדי להגביל את הגישה לדף זה באמצעות IP, הזן את כתובת ה- IP החוקית, עם כתובת IP אחת בכל שורה. דוגמה: 127.0.0.1 או 127.1. * *',
	'Mx_phpBB_stats'							=> 'phpBB סטטיסטיקה בכותרת',
	'Mx_phpBB_stats_explain'				=> '- קישורים לפוסטים חדשים שלא נקראו וכו',
	'Column_admin'							=> 'עמודת עמודה',
	'Column_admin_explain'				=> 'ניהול עמודות עמוד',
	'Column'									=> 'עמודה',
	'Columns'									=> 'עמודות עמוד',
	'Column_block'							=> 'עמודת עמודה',
	'Column_blocks'							=> 'עמודות עמודות עמודות',
	'Edit_Column'								=> 'עריכת עמודה',
	'Edit_Column_explain'					=> 'השתמש בטופס זה כדי לשנות עמודה',
	'Column_Size'								=> 'גודל העמודה',
	'Column_name'							=> 'שם עמודה',
	'Column_delete'							=> 'מחיקת עמודה',
	'Page_updated'								=> 'מידע עמודה ועמוד עודכנו בהצלחה',
	'Create_column'							=> 'הוסף עמודה חדשה',
	'Delete_page_column'					=> 'מחק עמוד עמוד',
	'Delete_page_column_explain'			=> 'פעולה זו תמחק את עמודת העמוד. היזהר: פעולה זו לא ניתן לבטל!',
	'Click_page_column_delete_yes'		=> 'לחץ על%s כאן %s כדי למחוק את עמודת העמוד',
	
	'Add_Split_Block'							=> 'הוסף בלוק עמודות ספליט',
	'Add_Split_Block_explain'				=> 'בלוק זה מחלק את העמודה',
	'Add_Dynamic_Block'					=> '(Sub) Block הוסף דינמי',
	'Add_Dynamic_Block_explain'			=> 'בלוק דינמי זה מגדיר דפי משנה, המוגדרים מתפריט הניווט',
	'Add_Virtual_Block'						=> 'הוסף בלוק וירטואלי (דף בלוג)',
	'Add_Virtual_Block_explain'			=> 'בלוק זה הופך את הדף לדף וירטואלי (בלוג)',
	
	/*
	* Page templates
	*/
	'Page_templates_admin'					=> 'תבניות דף ניהול',
	'Page_templates_admin_explain'		=> 'השתמש בדף זה כדי ליצור, לערוך או למחוק תבניות דפים',
	'Page_template'							=> 'תבנית דף',
	'Page_templates'							=> 'תבניות דפים',
	'Page_template_column'					=> 'עמודת תבנית הדף',
	'Page_template_columns'				=> 'עמודות תבנית דף',
	'Choose_page_template'					=> 'בחר תבנית דף',
	'Template_Config_updated'				=> 'תצורת תבנית עודכנה',
	'Add_Template'							=> 'הוסף תבנית חדשה',
	'Template'									=> 'תבנית',
	'Template_name'							=> 'שם התבנית',
	'Page_template_delete'					=> 'מחק תבנית',
	'Delete_page_template'					=> 'מחק תבנית דף',
	'Delete_page_template_explain'		=> 'פעולה זו תמחק את תבנית הדף. היזהר: פעולה זו לא ניתן לבטל!',
	'Click_page_template_delete_yes'		=> 'לחץ על%s כאן %s כדי למחוק את תבנית הדף',
	'Delete_page_template_column'		=> 'מחק תבנית דף',
	'Delete_page_template_column_explain'	=> 'פעולה זו תמחק את תבנית הדף. היזהר: פעולה זו לא ניתן לבטל!',
	'Click_page_template_column_delete_yes'	=> 'לחץ על%s כאן %s כדי למחוק את תבנית הדף',
	
	/*
	* Cache
	*/
	'Cache_dir_write_protect'				=> 'ספריית המטמון שלך מוגנת מפני כתיבה. ל- MX-Publisher אין אפשרות ליצור את קובץ המטמון. אנא רשום את ספריית המטמון שלך כך שתמשיך.',
	'Cache_generate'							=> 'קבצי המטמון שלך נוצרו.',
	'Cache_submit'								=> 'צור את קובץ המטמון?',
	'Cache_explain'							=> 'עם אפשרות זו ניתן ליצור את כל קבצי המטמון (קובצי XML) בבת אחת עבור כל בלוקי הפורטל. קבצים אלה מאפשרים לצמצם את מספר שאילתות מסד הנתונים הדרושים ולשפר את הביצועים הכוללים של הפורטל. <br /> הערה: יש להפעיל את המטמון של ה- MX-Publisher (במחשבי מנהל כללי בפורטל) עבור קבצים אלה לשימוש במערכת. הערה נוספת: קובצי המטמון נוצרים במהירות בעת עריכת בלוקים טוב.',
	'Generate_mx_cache'					=> 'צור בלוק מטמון',
	
	/*
	* These are displayed in the drop down boxes for advanced
	* mode Module auth, try and keep them short!
	*/
	'Menu_Navigation'						=> 'תפריט ניווט',
	'Portal_index'								=> 'אינדקס פורטל',
	'Save_Settings'								=> 'שמור הגדרות',
	'Translation_Tools'						=> 'כלי תרגום',
	'Preview_portal'							=> 'תצוגה מקדימה פורטל',
	
	/*
	* מטה תגים
	*/
	'Meta_admin'								=> 'מטה תגים מינהל',
	'Mega_admin_explain'					=> 'השתמש בטופס זה כדי להתאים אישית את תגי ה- מטה שלך',
	'Meta_Title'									=> 'כותרת',
	'Meta_Author'								=> 'מחבר',
	'Meta_Copyright'							=> 'זכויות יוצרים',
	'Meta_ImageToolBar'					=> 'סרגל הכלים של תמונות',
	'Meta_Distribution'						=> 'הפצה',
	'Meta_Keywords'							=> 'מילות מפתח',
	'Meta_Keywords_explain'				=> '(רשימה מופרדת בפסיק)',
	'Meta_Description'						=> 'תיאור',
	'Meta_Language'							=> 'קוד שפה',
	'Meta_Rating'								=> 'דירוג',
	'Meta_Robots'								=> 'רובוטים',
	'Meta_Pragma'								=> 'ללא מטמון של Pragma',
	'Meta_Bookmark_icon'					=> 'סמל אייקון',
	'Meta_Bookmark_explain'				=> '(מיקום יחסי)',
	'Meta_HTITLE'							=> 'הגדרות כותרת נוספות',
	'Meta_data_updated'						=> 'קובץ נתוני מטה (mx_meta.inc) עודכן! <br /> לחץ על%s כאן %s כדי לחזור למנהל תגים למטא.',
	'Meta_data_ioerror'						=> 'לא ניתן לפתוח את mx_meta.inc. ודא שהקובץ ניתן לכתיבה (chmod 777).',
	
	/*
	* Portal permissons
	*/
	'Mx_Block_Auth_Title'					=> 'הרשאות חסימה פרטית',
	'Mx_Block_Auth_Explain'				=> 'כאן באפשרותך להגדיר תצורה של הרשאות פרטיות',
	'Mx_Page_Auth_Title'					=> 'הרשאות דף פרטי',
	'Mx_Page_Auth_Explain'				=> 'כאן אתה מגדיר הרשאות דף פרטי',
	'Block_Auth_successfully'				=> 'חסימת הרשאות עודכנו בהצלחה',
	'Click_return_block_auth'				=> 'לחץ%sכאן%s כדי לחזור אל חסימה פרטית',
	'Page_Auth_successfully'					=> 'הרשאות דף עודכנו בהצלחה',
	'Click_return_page_auth'					=> 'לחץ%sכאן%s כדי לחזור לדף הרשאות דף פרטי',
	'AUTH_ALL'								=> 'הכל',
	'AUTH_REG'								=> 'רשום',
	'AUTH_PRIVATE'						=> 'פרטי',
	'AUTH_MOD'								=>  'אחראי',
	'AUTH_ADMIN'							=> 'ניהול',
	'AUTH_ANONYMOUS'					=> 'אנונימי',
	
	/* -----------------------------------/
	* BlockCP - Block Parameter Specific/
	* ----------------------------------- */

	/* General */
	'target_block'								=> 'בלוק יעד',
	'target_block_explain'					=> 'קישורים, נתונים וכו מפנים לבלוק הזה',
	/* Split column */
	'block_ids'									=> 'חוסמי מקור',
	'block_ids_explain'						=> '- כדי להציב משמאל לימין',
	'block_sizes'									=> 'חסום גודלים (מופרדים בפסיקים)',
	'block_sizes_explain'						=> '- ניתן לציין גודל באמצעות מספרים (פיקסלים), אחוזים (גודל יחסי, כלומר	40% \') או	* \' עבור השאר.',
	'space_between'							=> 'רווח בין בלוקים',
	/* Sitelog */
	'log_filter_date'								=> 'סנן לפי שעה',
	'log_filter_date_explain'					=> '- הצג יומנים משבוע שעבר, חודש, שנה ...',
	'numOfEvents'								=> 'מספר',
	'numOfEvents_explain'					=> '- מספר האירועים להצגה',
	/* IncludeX */
	'x_listen'										=> 'האזן (GET)',
	'x_iframe'									=> 'iframe',
	'x_textfile'									=> 'Textfile',
	'x_multimedia'								=> 'WMP מולטימדיה',
	'x_pic'										=> 'Pic',
	'x_format'									=> 'Formated Textfile',
	'x_mode'									=> 'מצב כלול:',
	'x_mode_explain'							=> 'The IncludeX block operates in one of the following modes. If mode \'Listen (GET)\' is selected, the mode may be set by a url \'x_mode=mode\' and associated parameters with \'x_1=, x_2=, etc\'.<br />Example: To pass a url to a iframe use \'domain/index.php?page=x&x_mode=iframe&x_1=http://domain\'',
	'x_1'											=> 'משתנה 1:',
	'x_1_explain'								=> '<i>IFrame:</i> url<br /><i>Textfile:</i> relative path from root (eg in \'/include_file/my_file.xxx\')<br /><i>Multimedia:</i> relative path from root (eg in \'/include_file/my_file.xxx\')<br /><i>Pic:</i> relative path from root (eg in \'/include_file/my_file.xxx\')<br /><i>Formatted textfile:</i> not available',
	'x_2'											=> 'משתנה 2:',
	'x_2_explain'								=> '<i>IFrame:</i> frame height (pixels)<br /><i>Multimedia:</i> width (pixles)',
	'x_3'											=> 'משתנה 3:',
	'x_3_explain'								=> '<i> מולטימדיה: </ i> גובה (פיקסלים)',
	/* Dynamic Block */
	'default_block_id'							=> 'בלוק ברירת מחדל',
	'default_block_id_explain'				=> 'זהו ברירת המחדל או הבלוק הראשון להצגה, אלא אם כן נקבע בלוק דינמי',
	/* Menu Navigation */
	'menu_display_mode'						=> 'מצב פריסה',
	'menu_display_mode_explain '			=> 'Horizonal or Vertical layout mode',
	'menu_custom_tpl'						=> 'קובץ תבנית מותאם אישית',
	'menu_custom_tpl_explain '			=> 'For example mx_menu_custom.tpl',
	'menu_page_parent'						=> 'דף אב',
	'menu_page_parent_explain '			=> 'MENU_PAGE_PARENT_EXPLAIN',
	/* Version Checker */
	'MXP_Version_up_to_date'				=> 'התקנת ה- MX-Publisher שלך מעודכנת. אין עדכונים זמינים עבור הגירסה שלך של MX-Publisher.',
	'MXP_Version_outdated'					=> 'התקנת ה- MX-Publisher שלך <b> לא </b> נראית מעודכנת. עדכונים זמינים עבור הגירסה שלך של MX-Publisher. בקר בכתובת <a href="http://mxpcms.sourceforge.net/download" target="_new"> החבילה הליבה של MX-Publisher להורדה </a> כדי לקבל את הגרסה העדכנית ביותר.">החבילה הליבה של MX-Publisher להורדה </a> כדי לקבל את הגרסה העדכנית ביותר. ">התקנת ה- MX-Publisher שלך <b> לא </b> נראית מעודכנת. עדכונים זמינים עבור הגירסה שלך של MX-Publisher. בקר בכתובת <a href="http://mxpcms.sourceforge.net/download" target="_new"> החבילה הליבה של MX-Publisher להורדה </a> כדי לקבל את הגרסה העדכנית ביותר.',
	'MXP_Latest_version_info'				=> 'הגרסה הזמינה האחרונה היא <b> MX-Publisher% s </b>.',
	'MXP_Current_version_info'				=> 'אתה מפעיל <b> MX-Publisher% s </b>.',
	'MXP_Mailing_list_subscribe_reminder'	=> 'לקבלת המידע העדכני ביותר על חדשות ועדכונים ל- MX-Publisher, למה לא <a href = "http://lists.sourceforge.net/lists/listinfo/mxpcms-news" target = " _new "> מנוי לרשימת התפוצה שלנו </a>?">מנוי לרשימת התפוצה שלנו </a>? ">לקבלת המידע העדכני ביותר על חדשות ועדכונים ל- MX-Publisher, למה לא <a href = "http://lists.sourceforge.net/lists/listinfo/mxpcms-news" target = " _new "> מנוי לרשימת התפוצה שלנו </a>?',
	/* lang_admin_gd_info.php - BEGIN */
	'GD_Title'									=> 'מידע GD',
	'NO_GD'									=> 'אין GD',
	'GD_Description'							=> 'אחזר מידע על ספריית GD המותקנת כעת',
	'GD_Freetype_Support'					=> 'גופני Freetype תמיכה:',
	'GD_Freetype_Linkage'					=> 'סוג קישור Freetype:',
	'GD_T1lib_Support'						=> 'תמיכה T1lib:',
	'GD_Gif_Read_Support'					=> 'Gif Read Support:',
	'GD_Gif_Create_Support'				=> 'Gif Create Support:',
	'GD_Jpg_Support'							=> 'Jpg/Jpeg Support:',
	'GD_Png_Support'						=> 'Png Support:',
	'GD_Wbmp_Support'						=> 'WBMP Support:',
	'GD_XBM_Support'						=> 'XBM Support:',
	'GD_WebP_Support'						=> 'WebP Support:',
	'GD_Jis_Mapped_Support'				=> 'תמיכה בגופן יפני:',
	'GD_True'									=> 'כן',
	'GD_False'									=> 'לא',
	'GD_VERSION'							=> 'GD Version:',
	'GD_0'										=> 'No GD',
	'GD_1'										=> 'GD1',
	'GD_2'										=> 'GD2',
	'GD_show_img_no_gd'					=> 'Show GIF thumbnails without using GD libraries (full images are loaded and then just shown resized).',
	/* lang_admin_gd_info.php - END */
	));

//
// That's all Folks!
// -------------------------------------------------
?>