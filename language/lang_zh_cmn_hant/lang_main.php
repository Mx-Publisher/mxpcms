<?php
/***************************************************************************
 *                            lang_main.php [Chinese_Big5]
 *                              -------------------
 *			小沙粒繁體化 http://flash.to/greenboard
 ****************************************************************************/

//
// The format of this file is:
//
// ---> $lang['message'] = "text";
//
// You should also try to set a locale and a character
// encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may
// not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

//setlocale(LC_ALL, "chi_big5");

$lang['USER_LANG'] = 'zh-tw';
$lang['ENCODING'] = 'UTF-8';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = '左';
$lang['RIGHT'] = '右';
$lang['DATE_FORMAT'] =  'd/M/Y'; // This should be changed to the default date format for your language, php date() format

//
// General
//
$lang['Page_Not_Authorised'] = 'Sorry, but you are not authorized to access this page.';
$lang['Execution_Stats'] = 'Page generated %s queries - Generation time: %s seconds';
$lang['Redirect_login'] = 'Click %shere%s to login.';
$lang['Show_admin_options'] = 'Show/Hide Page Admin Options: ';
$lang['Block_updated_date'] = '更新';
$lang['Block_updated_by'] = '通過 ';
$lang['Page_updated_date'] = '此頁面已更新 ';
$lang['Page_updated_by'] = '通過 ';
$lang['Powered_by'] = '供電 ';

$lang['mx_spacer'] = '間隔';
$lang['Yes'] = '是';
$lang['No'] = '不是';

$lang['Link'] = '鏈接';

$lang['Hidden_block'] = 'Hidden block';
$lang['Hidden_block_explain'] = 'This block is \'hidden\', but visible to you since you have the proper permissions set.';

//
// Menu_nav.php
// Navigation Block
//
$lang['Navigation_Menu'] = '菜單';

//
// Overall Navigation Navigation
//
$lang['MX_home'] 				= "首頁";
$lang['MX_forum'] 				= "論壇";
$lang['MX_navigation'] 			= 'Pages navigation, eg. forum navigation, like pafiledb navigation.';	

//
// Core Blocks - Language
//
$lang['Change_default_lang'] = 'Set the Board\'s Default Language';
$lang['Change_user_lang'] = 'Set Your Language';
$lang['Portal_lang'] = "語系";
$lang['Select_lang'] = "請選擇您的語系:";

$lang['Who_is_Online'] = '誰在線上';
$lang['Who_is_Online?'] = '誰在線上?';

//
// Core Blocks - Theme
//
$lang['Change'] = '變更';
$lang['Change_default_style'] = 'Set the Board\'s Default Style';
$lang['Change_user_style'] = '設定你的風格';
$lang['Theme']                  = "主題";
$lang['SelectTheme']            = "請選擇一個您喜歡的主題:";

//
// Core Blocks - Search
//
$lang['Mx_Page']  = "首頁";
$lang['Mx_Block'] = '部分';

//
// Core Blocks - Virtual
//
$lang['Virtual_Create_new'] = '創建新的 ';
$lang['Virtual_Create_new_user'] = 'User Page';
$lang['Virtual_Create_new_group'] = 'Group Page';
$lang['Virtual_Create_new_project'] = '項目頁面';
$lang['Virtual_Create'] = '立即創建';
$lang['Virtual_Edit'] = 'Update page name';
$lang['Virtual_Delete'] = 'Delete this page';

$lang['Virtual_Welcome'] = '歡迎光臨 ';
$lang['Virtual_Info'] = 'Here you can control your private web page.';
$lang['Virtual_CP'] = '頁面控制面板';
$lang['Virtual_Go'] = '走';
$lang['Virtual_Select'] = '選擇:';

//
// Core Blocks - Site Log (and many last 'item' blocks)
//
$lang['No_items_found'] = 'Nothing new to report. ';

//
// BlockCP
//
$lang['Block_Title'] = '標題';
$lang['Block_Info'] = '信息';

$lang['Block_Config_updated'] = 'Block configuration updated successfully.';
$lang['Edit'] = '編輯';
$lang['Block_Edit'] = '編輯塊';
$lang['Block_Edit_dyn'] = 'Edit parent dynamic block';
$lang['Block_Edit_sub'] = 'Edit parent split block';

$lang['General_updated_return_settings'] = 'Configuration updated successfully.<br /><br />Click %shere%s to continue.'; // %s's for URI params - DO NOT REMOVE
$lang['General_update_error'] = 'Couldn\'t update configuration.';

//
// Header
//
$lang['Mx_search_site'] = '網站';//現場
$lang['Mx_search_forum'] = '搜尋這個版面...';
$lang['Mx_search_kb'] = '搜尋這個主題...';
$lang['Mx_search_pafiledb'] = '下載'; 
$lang['Mx_search_google'] = '谷歌';
$lang['Mx_new_search'] = '檢視新的文章';

//
// Copyrights page
//
$lang['mx_about_title'] = '關於模塊化極端出版商';
$lang['mx_copy_title'] = 'MX-出版商信息';
$lang['mx_copy_modules_title'] = 'Installed MX-Publisher Modules';
$lang['mx_copy_template_title'] = '關於風格';
$lang['mx_copy_translation_title'] = '關於翻譯';

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
$lang['TRANSLATION_INFO_MXBB'] = '正體中文語系由 Translator Name etc.';
//
// Installation
//
$lang['Please_remove_install_contrib'] = 'Please ensure both the install/ and contrib/ directories are deleted.';



$lang['Welcome_Title']          = "歡迎來到";
$lang['Welcome_Msg']            = "歡迎內容";

$lang['Web Links']              = "聯結";
$lang['Edit your Profile']      = "個人資料";   
$lang['Announcements']          = "公告";   
$lang['Send a new Ad']          = "發表公告";
$lang['Forum']                  = "論壇";
$lang['Main Menu']              = "選單";
$lang['Module Statistics']      = "討論區統計資料"; 
$lang['Send a Private message'] = "發送新的私人訊息";
$lang['Submit a Url']           = "Submit a Url";      

$lang['Surveys/Polls']          = "調查 / 投選";
$lang['Already_voted']          = "您已經投過票了";
$lang['Click_view_voted']       = "請按 %s這裡%s 查看投票結果";
$lang['Portal_admin']           = "入口網站控制台";
$lang['Portal_admin_explain']   = "在這裡﹐您可增加, 撤除, 編輯, 重整和調試您的入口網站";

$lang['Annonce_sent']           = "您的公告經已發表了";
$lang['Annonce_Deleted']        = "您的公告經已撤除了";

$lang['Welcome_msg_send']       = "您的歡迎詞經已發表了";
$lang['Edit_Welcome_msg']       = "編輯您的歡迎詞";

$lang['Url_sent']               = "您的網址經已發表了";
$lang['Url_Deleted']            = "您的網址經已撤除了";
$lang['Submit Url']             = "加入聯結";   

//
// Multilangual page titles
// - To have multilangual page titles, add lang keys 'pagetitle_PAGE_TITLE' below
// - This lang key replaces the page title (PAGE_TITLE) for the page given in the adminCP
//
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