<?php
/**
 * Language file [lang_main.php]
 * 
 * @package language
 * @author FlorinCB
 * @version $Id: lang_main.php,v 1.1 2018/09/21 11:05:08 FlorinCB Exp $
 * @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
 * @link http://mxpcms.sourceforge.net/
 * Encoding: utf-8
 * 1 tab = 4 spaces
 */

if ( !isset($lang) )
{
	$lang = array();
}

$lang = array_merge( $lang, array( // #
	'USER_LANG'						=> 'he',
	'ENCODING'						=> 'UTF-8',
	'DIRECTION'						=> 'ltr',
	'LEFT'							=> 'שמאלה',
	'RIGHT'							=> 'ימין',
	'DATE_FORMAT'						=> 'd/M/Y',
	'Page_Not_Authorised'				=> 'מצטערים	אתה	אינם	מורשים	כדי לגשת	לדף	הזה.',
	'Execution_Stats'					=> 'שאילתות %s של יצירת דף - זמן יצירה: %s שניות',
	'Redirect_login'					=> 'לחץ על	%sכאן%s	כדי להתחבר.',
	'Show_admin_options'				=> 'הצג / הסתר אפשרויות מנהל דף:',
	'Block_updated_date'				=> 'עודכן',
	'Block_updated_by'				=> 'על ידי',
	'Page_updated_date'				=> 'דף זה עודכן',
	'Page_updated_by'					=> 'על ידי',
	'Powered_by'						=> 'מונע ע"י',
	'mx_spacer'						=> 'ספאסר',
	'Yes'								=> 'כן',
	'No'								=> 'לא',
	'Link'							=> 'קישור',
	'Hidden_block'					=> 'בלוק מוסתר',
	'Hidden_block_explain'			=> 'חסום זה הוא	\' מוסתר\',	אבל	גלוי	אל	אתה	מאז	יש לך	את	הרשאות	המתאימות	.',
	'MX_home'							=> 'בית',
	'MX_forum'						=> 'פוֹרוּם',
	'MX_navigation'					=> 'דפים	ניווט,	לדוגמה.	פורום	ניווט,	כמו pafiledb	ניווט.',
	'Change_default_lang'				=> 'הגדר את שפת ברירת המחדל של מועצת המנהלים',
	'Change_user_lang'				=> 'הגדר את השפה שלך',
	'Portal_lang'						=> 'שפת שפה',
	'Select_lang'						=> 'בחר שפה:',
	'Change'							=> 'החלף עכשיו',
	'Change_default_style'			=> 'הגדר את סגנון ברירת המחדל של מועצת המנהלים',
	'Change_user_style'				=> 'הגדר את הסגנון שלך',
	'Theme'							=> 'ThemeCP / סגנון',
	'Select_theme'					=> 'בחר ערכת נושא / סגנון:',
	'Mx_Page'							=> 'עמוד',
	'Mx_Block'						=> 'סָעִיף',
	'Virtual_Create_new'				=> 'צור חדש',
	'Virtual_Create_new_user'			=> 'דף משתמש',
	'Virtual_Create_new_group'		=> 'דף קבוצה',
	'Virtual_Create_new_project'		=> 'דף הפרויקט',
	'Virtual_Create'					=> 'צור כעת',
	'Virtual_Edit'					=> 'עדכון שם הדף',
	'Virtual_Delete'					=> 'למחוק את הדף',
	'Virtual_Welcome'					=> 'ברוך הבא',
	'Virtual_Info'					=> 'כאן	אתה	יכול	לשלוט	דף	אינטרנט	פרטיות שלך.',
	'Virtual_CP'						=> 'לוח הבקרה של הדף',
	'Virtual_Go'						=> 'ללכת',
	'Virtual_Select'					=> 'בחר:',
	'No_items_found'					=> 'שום דבר	חדש	לדוח',
	'Block_Title'						=> 'כותרת',
	'Block_Info'						=> 'מֵידָע',
	'Block_Config_updated'			=> 'חסום	תצורה	עודכן בהצלחה.',
	'Edit'							=> 'לַעֲרוֹך',
	'Block_Edit'						=> 'בלוק עריכה',
	'Block_Edit_dyn'					=> 'עריכת בלוק דינמי של אב',
	'Block_Edit_sub'					=> 'עריכת בלוק הורים מפוצלים',
	'General_updated_return_settings'	=> 'תצורה	עודכנה בהצלחה. <br/><br/>%3 לחץ על %sכאן%s כדי לחזור להודעה',
	'General_update_error'			=> 'לא ניתן	עדכון תצורה.',
	'Mx_search_site'					=> 'אֲתַר',
	'Mx_search_forum'					=> 'פוֹרוּם',
	'Mx_search_kb'					=> 'מאמרים',
	'Mx_search_pafiledb'				=> 'הורדות',
	'Mx_search_google'				=> 'Google',
	'Mx_new_search'					=> 'חיפוש חדש',
	'mx_about_title'					=> 'MX-Publisher על ',
	'mx_copy_title'					=> 'MX-Publisher מידע על',
	'mx_copy_modules_title'			=> 'MX-Publisher מותקן מודולים',
	'mx_copy_template_title'		=> 'על הסגנון',
	'mx_copy_translation_title'		=> 'על התרגום',
	
	// This is optional, if you would like a _SHORT_ message output
	// along with our copyright message indicating you are the translator
	// please add it here.	
	'TRANSLATION_INFO_MXBB'			=> 'Hebrew Language by <a href="http://mxpcms.sourceforge.net/" target="_blank">MX-Publisher Development Team</a>',

	'Please_remove_install_contrib'	=> 'אנא וודא שמחקת את התקיות /install ו- contrib/ ',


//
// Multilangual page titles
// - To have multilangual page titles, add lang keys 'pagetitle_PAGE_TITLE' below
// - This lang key replaces the page title (PAGE_TITLE) for the page given in the adminCP
//
	'A__little__text_to_describe_your_site' => 'כל טקסט שתאר את האתר שלך',
	));
//$lang['pagetitle_NameOfFirstPage'] = 'Whatever one';
//$lang['pagetitle_NameOfSecondPage'] = 'Whatever two';

//$lang['pagedesc_NameOfFirstPage'] = 'Whatever one';
//$lang['pagedesc_NameOfSecondPage'] = 'Whatever two';

//
// Multilangual block titles
// - To have multilangual block titles, add lang keys 'blocktitle_BLOCK_TITLE' below
// - This lang key replaces the block title (BLOCK_TITLE) for the block given in the adminCP/blockCP
//
//$lang['blocktitle_NameOfFirstPage'] = 'Whatever one';
//$lang['blocktitle_NameOfSecondPage'] = 'Whatever two';

//$lang['blockdesc_DescOfFirstPage'] = 'Whatever one';
//$lang['blockdesc_DescOfSecondPage'] = 'Whatever two';

//
// That's all Folks!
// -------------------------------------------------
?>
