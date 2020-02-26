<?php
/***************************************************************************
 *                              admin_country_flags.php
 *                            -------------------
 *   begin                : Thursday, February 6, 2003
 *   written by Nuttzy
 *  @copyright (c) RMcGirr83, Nuttzy, FlorinCB aka orynider
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
 
 /**
 * Modifications:
 *		26.11.2018 - ported for indexing flags in ../images/flags/country/ subfolder - by OryNider
 */

@define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Forum_Display']['Country_Flags'] = "admin/$file";
	return;
}

//
// Security and Page header
//
@define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
if (!defined('PHP_EXT')) define('PHP_EXT', $phpEx);
if (!defined('MX_ROOT_PATH')) define('MX_ROOT_PATH', './../');
require('./pagestart.' . PHP_EXT);
/* FLAG-start * /
@define('FLAG_TABLE', $table_prefix.'flags');
/* FLAG-end */
if( isset($_GET['mode']) || isset($_POST['mode']) )
{
	$mode = ($_GET['mode']) ? $_GET['mode'] : $_POST['mode'];
}
else 
{
	//
	// These could be entered via a form button
	//
	if( isset($_POST['add']) )
	{
		$mode = "add";
	}
	else if( isset($_POST['save']) )
	{
		$mode = "save";
	}
	else
	{
		$mode = "";
	}
}

// if we are are doing a delete make sure we got confirmation
if ( $mode == 'do_delete')
{
	// user bailed out, return to flag admin
	if ( !$_POST['confirm'] )
	{
		$mode = '' ;
	}
}

/* START Include language file */
$language = ($mx_user->user_language_name) ? $mx_user->user_language_name : (($board_config['default_lang']) ? $board_config['default_lang'] : 'english');

if ((@include $mx_root_path . "language/lang_" . $language . "/lang_admin_flags.$phpEx") === false)
{
	if ((@include $mx_root_path . "language/lang_english/lang_admin_flags.$phpEx") === false)
	{
		mx_message_die(CRITICAL_ERROR, 'Language file ' . $mx_root_path . "language/lang_" . $language . "/lang_admin_flags.$phpEx" . ' couldn\'t be opened.');
	}
	$language = 'english'; 
} 

if( $mode != "" )
{
	if( $mode == "edit" || $mode == "add" )
	{
		//
		// They want to add a new flag, show the form.
		//
		$flag_id = ( isset($_GET['id']) ) ? intval($_GET['id']) : 0;
		
		$s_hidden_fields = "";
		
		if( $mode == "edit" )
		{
			if( empty($flag_id) )
			{
				mx_message_die(GENERAL_MESSAGE, $lang['Must_select_flag']);
			}

			$sql = "SELECT * FROM " . FLAG_TABLE . "
				WHERE flag_id = $flag_id";
			if(!$result = $db->sql_query($sql))
			{
				mx_message_die(GENERAL_ERROR, "Couldn't obtain flag data", "", __LINE__, __FILE__, $sql);
			}
			
			$flag_info = $db->sql_fetchrow($result);
			$s_hidden_fields .= '<input type="hidden" name="id" value="' . $flag_id . '" />';
		}
		$s_hidden_fields .= '<input type="hidden" name="mode" value="save" />';

		$template->set_filenames(array(
			"body" => "admin/flags_edit_body.tpl")
		);

		if (!is_file($phpbb_root_path . '/images/flags/country/'.$flag_info['flag_image']))
		{
			$flag_dir = $phpbb_root_path . '/images/flags/';
		}
		else
		{
			// 
			$flag_dir = $phpbb_root_path . '/images/flags/country/';
		}

		$template->assign_vars(array(
			//We do not need translation in the DB since is taken from the language file
			"FLAG" => $flag_info['flag_name'],

			"IMAGE" => ( $flag_info['flag_image'] != "" ) ? $flag_info['flag_image'] : "",
			"IMAGE_DISPLAY" => ( $flag_info['flag_image'] != "" ) ? '<img src="' . $flag_dir . $flag_info['flag_image'] . '" />' : "",

			"L_FLAGS_TITLE" => $lang['Flags_title'],
			"L_FLAGS_TEXT" => $lang['Flags_explain'],
			"L_FLAG_NAME" => $lang['Flag_name'],
			"L_FLAG_IMAGE" => $lang['Flag_image'],
			"L_FLAG_IMAGE_EXPLAIN" => $lang['Flag_image_explain'],
			"L_SUBMIT" => $lang['Submit'],
			"L_RESET" => $lang['Reset'],

			"S_FLAG_ACTION" => mx_append_sid("admin_country_flags.$phpEx"),
			"S_HIDDEN_FIELDS" => $s_hidden_fields)
		);
	}
	else if( $mode == "save" )
	{
		//
		// Ok, they sent us our info, let's update it.
		//		
		$flag_id = ( isset($_POST['id']) ) ? intval($_POST['id']) : 0;
		$flag_name = ( isset($_POST['title']) ) ? trim($_POST['title']) : "";
		$flag_image = ( (isset($_POST['flag_image'])) ) ? trim($_POST['flag_image']) : "";

		if( $flag_name == "" )
		{
			mx_message_die(GENERAL_MESSAGE, $lang['Must_select_flag']);
		}

		//
		// The flag image has to be a jpg, gif or png
		//
		if($flag_image != "")
		{
			if ( !preg_match("/(\.gif|\.png|\.jpg)$/is", $flag_image))
			{
				$flag_image = "";
			}
		}

		if ($flag_id)
		{
			$sql = "UPDATE " . FLAG_TABLE . "
				SET flag_name = '" . str_replace("\'", "''", $flag_name) . "', flag_image = '" . str_replace("\'", "''", $flag_image) . "'
				WHERE flag_id = $flag_id";

			$message = $lang['Flag_updated'];
		}
		else
		{
			$sql = "INSERT INTO " . FLAG_TABLE . " (flag_name, flag_image)
				VALUES ('" . str_replace("\'", "''", $flag_name) . "', '" . str_replace("\'", "''", $flag_image) . "')";

			$message = $lang['Flag_added'];
		}
		
		if( !$result = $db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't update/insert into flags table", "", __LINE__, __FILE__, $sql);
		}

		$message .= "<br /><br />" . sprintf($lang['Click_return_flagadmin'], "<a href=\"" . mx_append_sid("admin_country_flags.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		mx_message_die(GENERAL_MESSAGE, $message);

	}
	else if( $mode == 'delete' )
	{
		if( isset($_POST['id']) || isset($_GET['id']) )
		{
			$flag_id = ( isset($_POST['id']) ) ? intval($_POST['id']) : intval($_GET['id']);
		}
		else
		{
			$flag_id = 0;
		}
		$hidden_fields = '<input type="hidden" name="id" value="' . $flag_id . '" /><input type="hidden" name="mode" value="do_delete" />';

		//
		// Set template files
		//
		$template->set_filenames(array(
			'body' => 'confirm_body.tpl')
		);

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Flag_confirm'],
			'MESSAGE_TEXT' => $lang['Confirm_delete_flag'],

			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],

			'S_CONFIRM_ACTION' => mx_append_sid("admin_country_flags.$phpEx"),
			'S_HIDDEN_FIELDS' => $hidden_fields)
		);

	}
	else if( $mode == 'do_delete' )
	{
		//
		// Ok, they want to delete their flag
		//	
		if( isset($_POST['id']) || isset($_GET['id']) )
		{
			$flag_id = ( isset($_POST['id']) ) ? intval($_POST['id']) : intval($_GET['id']);
		}
		else
		{
			$flag_id = 0;
		}
		
		if( $flag_id )
		{
			// get the doomed flag's info
			$sql = "SELECT * FROM " . FLAG_TABLE . " 
				WHERE flag_id = $flag_id" ;
			if( !$result = $db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't get flag data", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$flag_image = $row['flag_image'] ;


			// delete the flag
			$sql = "DELETE FROM " . FLAG_TABLE . "
				WHERE flag_id = $flag_id";
			if( !$result = $db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't delete flag data", "", __LINE__, __FILE__, $sql);
			}
			
			// update the users who where using this flag			
			$sql = "UPDATE " . USERS_TABLE . " 
				SET user_from_flag = 'blank.gif' 
				WHERE user_from_flag = '$flag_image'";
			if( !$result = $db->sql_query($sql) ) 
			{
				mx_message_die(GENERAL_ERROR, $lang['No_update_flags'], "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Flag_removed'] . "<br /><br />" . sprintf($lang['Click_return_flagadmin'], "<a href=\"" . mx_append_sid("admin_country_flags.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			mx_message_die(GENERAL_MESSAGE, $message);

		}
		else
		{
			mx_message_die(GENERAL_MESSAGE, $lang['Must_select_flag']);
		}
	}
	else
	{
		//
		// They didn't feel like giving us any information. Oh, too bad, we'll just display the
		// list then...
		//
		$template->set_filenames(array(
			"body" => "admin/flags_list_body.tpl")
		);

		$sql = "SELECT * FROM " . FLAG_TABLE . "
			ORDER BY flag_id ASC";
		if( !$result = $db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't obtain flags data", "", __LINE__, __FILE__, $sql);
		}

		$flag_rows = $db->sql_fetchrowset($result);
		$flag_count = count($flag_rows);

		$template->assign_vars(array(
			"L_FLAGS_TITLE" => $lang['Flags_title'],
			"L_FLAGS_TEXT" => $lang['Flags_explain'],
			"L_FLAG" => $lang['Flag_name'],

			"L_EDIT" => $lang['Edit'],
			"L_DELETE" => $lang['Delete'],
			"L_ADD_FLAG" => $lang['Add_new_flag'],
			"L_ACTION" => $lang['Action'],

			"S_FLAGS_ACTION" => mx_append_sid("admin_country_flags.$phpEx"))
		);
		
		if (!file_exists($phpbb_root_path . '/images/flags/country/'.$flag_rows[$i]['flag_image']))
		{
			$flag_dir = $phpbb_root_path . '/images/flags/';
		}
		else
		{
			$flag_dir = $phpbb_root_path . '/images/flags/country/';
		}
		
		for( $i = 0; $i < $flag_count; $i++)
		{
			$flag = $flag_rows[$i]['flag_name'];
			$flag_id = $flag_rows[$i]['flag_id'];
			
			$flag_count++;
			$i = $flag_id ;
			$row_color = ($i % 2 == 0) ? $theme['td_color1'] : $theme['td_color3'];
			$row_class = ($i % 2 == 0) ? $theme['td_class1'] : $theme['td_class2'];
	
			$template->assign_block_vars("flags", array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,
				
				"FLAG" => isset($lang[$flag]) ? $lang[$flag] : $flag,
				
				"IMAGE_DISPLAY" => ( $flag_rows[$i]['flag_image'] != "" ) ? '<img src="' . $flag_dir . $flag_rows[$i]['flag_image'] . '" />' : "",

				"U_FLAG_EDIT" => mx_append_sid("admin_country_flags.$phpEx?mode=edit&amp;id=$flag_id"),
				"U_FLAG_DELETE" => mx_append_sid("admin_country_flags.$phpEx?mode=delete&amp;id=$flag_id"))
			);
		}

	}
}
else
{	
	/**
	 * function decode_lang from mx_traslator phpBB3 Extension
	 *
	 * $mx_user_lang = decode_country_name($lang['USER_LANG'], 'country');
	 *
	 * @param unknown_type $file_dir
	 * @param unknown_type $lang_country = 'country' or 'language'
	 * @param array $langs_countries
	 * @return unknown
	 */
	function decode_country_name($file_dir, $lang_country = 'country', $langs_countries = false)
	{
		/* known languages */
		switch ($file_dir)
		{
				case 'aa':
					$lang_name = 'AFAR';
					$country_name = 'AFAR'; //Ethiopia
				break;
				
				case 'aae':
					$lang_name = 'AFRICAN-AMERICAN_ENGLISH';
					$country_name = 'UNITED_STATES'; 
				break;

				case 'ab':
					$lang_name = 'ABKHAZIAN';
					$country_name = 'ABKHAZIA';
				break;

				case 'ad':
					$lang_name = 'ANGOLA';
					$country_name = 'ANGOLA';
				break;

				case 'ae':
					$lang_name = 'AVESTAN';
					$country_name = 'UNITED_ARAB_EMIRATES'; //Persia
				break;

				case 'af':
					$country_name = 'AFGHANISTAN'; // langs: pashto and dari
					$lang_name = 'AFRIKAANS'; // speakers: 6,855,082 - 13,4%
				break;

				case 'ag':
					$lang_name = 'ENGLISH-CREOLE';
					$country_name = 'ANTIGUA_&AMP;_BARBUDA';
				break;
				
				case 'ai':
					$lang_name = 'Anguilla';
					$country_name = 'ANGUILLA';
				break;
				
				case 'aj':
					$lang_name = 'AROMANIAN';
					$country_name = 'Aromaya';
				break;
				
				case 'ak':
					$lang_name = 'AKAN';
					$country_name = '';
				break;

				case 'al':
					$lang_name = 'ALBANIAN';
					$country_name = 'ALBANIA';
				break;


				case 'am':
					$lang_name = 'AMHARIC';
					//$lang_name = 'armenian';
					$country_name = 'ARMENIA';
				break;

				case 'an':
					$lang_name = 'ARAGONESE'; //
					//$country_name = 'Andorra';
					$country_name = 'NETHERLAND_ANTILLES';
				break;
				
				case 'ao':
					$lang_name = 'ANGOLIAN';
					$country_name = 'ANGOLA';
				break;
				
				case 'ap':
					$lang_name = 'ANGIKA';
					$country_name = 'ANGA'; //India
				break;

				case 'ar':
					$lang_name = 'ARABIC';
					$country_name = 'ARGENTINA';
				break;

				case 'arq':
					$lang_name = 'ALGERIAN_ARABIC'; //known as Darja or Dziria in Algeria
					$country_name = 'ALGERIA';
				break;

				case 'ary':
					$lang_name = 'MOROCCAN_ARABIC'; //known as Moroccan Arabic or Moroccan Darija or Algerian Saharan Arabic
					$country_name = 'MOROCCO';
				break;
				
				case 'kab':
					$lang_name = 'KABYLE'; //known as Kabyle (Tamazight)
					$country_name = 'ALGERIA';
				break;
				
				case 'aq':
					$lang_name = '';
					$country_name = 'ANTARCTICA';
				break;

				case 'as':
					$lang_name = 'ASSAMESE';
					$country_name = 'AMERICAN_SAMOA';
				break;

				case 'at':
					$lang_name = 'GERMAN';
					$country_name = 'AUSTRIA';
				break;

				case 'av':
					$lang_name = 'AVARIC';
					$country_name = '';
				break;

				case 'av-da':
					$lang_name = 'AVARIAN_KHANATE';
					$country_name = 'Daghestanian';
				break;

				case 'ay':
					$lang_name = 'AYMARA';
					$country_name = '';
				break;

				case 'aw':
					$lang_name = 'ARUBA';
					$country_name = 'ARUBA';
				break;

				case 'au':
					$lang_name = 'en-au'; //
					$country_name = 'AUSTRALIA';
				break;

				case 'az':
					$lang_name = 'AZERBAIJANI';
					$country_name = 'AZERBAIJAN';
				break;
				
				case 'ax':
					$lang_name = 'FINNISH';
					$country_name = 'ÅLAND_ISLANDS';  //The Åland Islands or Åland (Swedish: Åland, IPA: [ˈoːland]; Finnish: Ahvenanmaa) is an archipelago province at the entrance to the Gulf of Bothnia in the Baltic Sea belonging to Finland.
				break;
				
				case 'ba':
					$lang_name = 'BASHKIR'; //Baskortostán (Rusia)
					$country_name = 'BOSNIA_&AMP;_HERZEGOVINA'; //Bosnian, Croatian, Serbian
				break;

				case 'bb':
					$lang_name = 'Barbados';
					$country_name = 'BARBADOS';
				break;

				case 'bd':
					$lang_name = 'Bangladesh';
					$country_name = 'BANGLADESH';
				break;

				case 'be':
					$lang_name = 'BELARUSIAN';
					$country_name = 'BELGIUM';
				break;

				case 'bf':
					$lang_name = 'Burkina Faso';
					$country_name = 'BURKINA_FASO';
				break;
				
				case 'bg':
					$lang_name = 'BULGARIAN';
					$country_name = 'BULGARIA';
				break;

				case 'bh':
					$lang_name = 'BHOJPURI'; // Bihar (India) 
					$country_name = 'BAHRAIN'; // Mamlakat al-Ba?rayn (arabic)
				break;

				case 'bi':
					$lang_name = 'BISLAMA';
					$country_name = 'BURUNDI';
				break;


				case 'bj':
					$lang_name = 'BENIN';
					$country_name = 'BENIN';
				break;
				
				case 'bl':
					$lang_name = 'BONAIRE';
					$country_name = 'BONAIRE';
				break;
				
				case 'bm':
					$lang_name = 'BAMBARA';
					$country_name = 'Bermuda';
				break;

				case 'bn':
					$country_name = 'BRUNEI';
					$lang_name = 'BENGALI';

				break;
				
				case 'bo':
					$lang_name = 'TIBETAN';
					$country_name = 'BOLIVIA';
				break;
				
				case 'br':
					$lang_name = 'BRETON';
					$country_name = 'BRAZIL'; //pt
				break;
				
				case 'bs':
					$lang_name = 'BOSNIAN';
					$country_name = 'BAHAMAS';
				break;

				case 'bt':
					$lang_name = 'Bhutan';
					$country_name = 'Bhutan';
				break;

				case 'bw':
					$lang_name = 'Botswana';
					$country_name = 'BOTSWANA';
				break;

				case 'bz':
					$lang_name = 'BELIZE';
					$country_name = 'BELIZE';
				break;

				case 'by':
					$lang_name = 'BELARUSIAN';
					$country_name = 'Belarus';
				break;
				
				case 'en-CM':
				case 'en_cm':
					$lang_name = 'CAMEROONIAN_PIDGIN_ENGLISH';
					$country_name = 'Cameroon';
				break;
				
				case 'wes':
					$lang_name = 'CAMEROONIAN'; //Kamtok
					$country_name = 'Cameroon'; //Wes Cos
				break;

				case 'cm':
					$lang_name = 'Cameroon';
					$country_name = 'CAMEROON';
				break;

				case 'ca':
					$lang_name = 'CATALAN';
					$country_name = 'CANADA';
				break;
				
				case 'cc':
					$lang_name = 'COA_A_COCOS'; //COA A Cocos dialect of Betawi Malay [ente (you) and ane (me)] and AU-English
					$country_name = 'COCOS_ISLANDS'; //CC 	Cocos (Keeling) Islands
				break;
				
				case 'cd':
					$lang_name = 'Congo Democratic Republic';
					$country_name = 'CONGO_DEMOCRATIC_REPUBLIC';
				break;
				
				//нохчийн мотт
				case 'ce':
					$lang_name = 'CHECHEN';
					$country_name = 'Chechenya';
				break;

				case 'cf':
					$lang_name = 'Central African Republic';
					$country_name = 'CENTRAL_AFRICAN_REPUBLIC';
				break;

				case 'cg':
					$lang_name = 'CONGO';
					$country_name = 'CONGO';
				break;
				
				case 'ch':
					$lang_name = 'CHAMORRO'; //Finu' Chamoru
					$country_name = 'SWITZERLAND';
				break;
				
				case 'ci':
					$lang_name = 'Cote D-Ivoire';
					$country_name = 'COTE_D-IVOIRE';
				break;
				
				case 'ck':
					$lang_name = '';
					$country_name = 'COOK_ISLANDS'; //CK 	Cook Islands
				break;
				
				case 'cl':
					$lang_name = 'Chile';
					$country_name = 'CHILE';
				break;
				
				case 'cn':
				//Chinese Macrolanguage
				case 'zh': //639-1: zh
				case 'chi': //639-2/B: chi
				case 'zho': //639-2/T and 639-3: zho
					$lang_name = 'CHINESE';
					$country_name = 'CHINA';
				break;		
				//Chinese Individual Languages 
			    //	中文			
				// Fujian Province, Republic of China
				case 'cn-fj':		
				//	閩東話
				case 'cdo': 	//Chinese Min Dong  
					$lang_name = 'CHINESE_DONG';
					$country_name = 'CHINA';
				break;
				//1. Bingzhou		spoken in central Shanxi (the ancient Bing Province), including Taiyuan.
				//2. Lüliang		spoken in western Shanxi (including Lüliang) and northern Shaanxi.
				//3. Shangdang	spoken in the area of Changzhi (ancient Shangdang) in southeastern Shanxi.
				//4. Wutai			spoken in parts of northern Shanxi (including Wutai County) and central Inner Mongolia.
				//5. Da–Bao		spoken in parts of northern Shanxi and central Inner Mongolia, including Baotou.
				//6. Zhang-Hu	spoken in Zhangjiakou in northwestern Hebei and parts of central Inner Mongolia, including Hohhot.
				//7. Han-Xin		spoken in southeastern Shanxi, southern Hebei (including Handan) and northern Henan (including Xinxiang).
				//8. Zhi-Yan		spoken in Zhidan County and Yanchuan County in northern Shaanxi.
				//	晋语 / 晉語
				case 'cjy': 	//Chinese Jinyu 晉 	
					$lang_name = 'CHINA_JINYU';
					$country_name = 'CHINA';
				break;
				// Cantonese is spoken in Hong Kong
				// 官話
				case 'cmn': 	//Chinese Mandarin 普通话 (Pǔ tōng huà) literally translates into “common tongue.” 
					$lang_name = 'CHINESE_MANDARIN';
					$country_name = 'CHINA';
				break;
				// Mandarin is spoken in Mainland China and Taiwan
				// 閩語 / 闽语
				//semantic shift has occurred in Min or the rest of Chinese: 
			    //*tiaŋB 鼎 "wok". The Min form preserves the original meaning "cooking pot".
			    //*dzhənA "rice field". scholars identify the Min word with chéng 塍 (MC zying) "raised path between fields", but Norman argues that it is cognate with céng 層 (MC dzong) "additional layer or floor".
			    //*tšhioC 厝 "house". the Min word is cognate with shù 戍 (MC syuH) "to guard".
			    //*tshyiC 喙 "mouth". In Min this form has displaced the common Chinese term kǒu 口. It is believed to be cognate with huì 喙 (MC xjwojH) "beak, bill, snout; to pant".
				//Austroasiatic origin for some Min words:
			    //*-dəŋA "shaman" compared with Vietnamese đồng (/ɗoŋ2/) "to shamanize, to communicate with spirits" and Mon doŋ "to dance (as if) under demonic possession".
			    //*kiɑnB 囝 "son" appears to be related to Vietnamese con (/kɔn/) and Mon kon "child".
				
				// Southern Min: 
				//		Datian Min; 
				//		Hokkien 話; Hokkien-Taiwanese 閩台泉漳語 - Philippine Hokkien 咱儂話.
				//		Teochew; 
				//		Zhenan Min; 
				//		Zhongshan Min, etc.
				
				//Pu-Xian Min (Hinghwa); Putian dialect: Xianyou dialect.
				
				//Northern Min:  Jian'ou dialect; Jianyang dialect; Chong'an dialect; Songxi dialect; Zhenghe dialect;
				
				//Shao-Jiang Min: Shaowu dialect, Jiangle dialect, Guangze dialect, Shunchang dialect;
				//http://www.shanxigov.cn/
				//Central Min: Sanming dialect; Shaxian dialect; Yong'an dialect,
				
				//Leizhou Min	: Leizhou Min.
				
				//Abbreviation
				//Simplified Chinese:	闽
				//Traditional Chinese:	閩
				//Literal meaning:	Min [River]	
				
				//莆仙片  
				case 'cpx': 	//Chinese Pu-Xian Min, Sing-iú-uā / 仙游話, (Xianyou dialect) http://www.putian.gov.cn/
					$lang_name = 'CHINESE_PU-XIAN';
					$country_name = 'CHINA';
				break;
				// 徽語
				case 'czh': 	//Chinese HuiZhou 	惠州 http://www.huizhou.gov.cn/ | Song dynasty
					$lang_name = 'CHINESE_HUIZHOU';
					$country_name = 'CHINA';
				break;
				// 閩中片
				case 'czo': 	//Chinese Min Zhong 閩中語 |  闽中语  http://zx.cq.gov.cn/ | Zhong-Xian | Zhong  忠县
					$lang_name = 'CHINESE_ZHONG';
					$country_name = 'CHINA';
				break;				
				// 東干話 SanMing: http://www.sm.gov.cn/ | Sha River (沙溪)
				case 'dng': 	//Ding  Chinese 
					$lang_name = 'DING_CHINESE';
					$country_name = 'CHINA';
				break;				
				//	贛語
				case 'gan': 	//Gan Chinese  
					$lang_name = 'GAN_CHINESE';
					$country_name = 'CHINA';
				break;
				// 客家話
				case 'hak': 	//Chinese  Hakka 
					$lang_name = 'CHINESE_HAKKA';
					$country_name = 'CHINA';
				break;
				
				case 'hsn': 	//Xiang Chinese 湘語/湘语	
					$lang_name = 'XIANG_CHINESE';
					$country_name = 'CHINA';
				break;				
				//	文言
				case 'lzh': 	//Literary Chinese 	
					$lang_name = 'LITERARY_CHINESE';
					$country_name = 'CHINA';
				break;
				// 閩北片
				case 'mnp': 	//Min Bei Chinese 
					$lang_name = 'MIN_BEI_CHINESE';
					$country_name = 'CHINA';
				break;
				// 閩南語
				case 'nan': 	//Min Nan Chinese 	
					$lang_name = 'MIN_NAN_CHINESE';
					$country_name = 'CHINA';
				break;			 
				 // 吴语
				case 'wuu': 	//Wu Chinese 
					$lang_name = 'WU_CHINESE';
					$country_name = 'CHINA';
				break;
				// 粵語
				case 'yue': 	//Yue or Cartonese Chinese
					$lang_name = 'YUE_CHINESE';
					$country_name = 'CHINA';
				break;
				
				case 'co':
					$lang_name = 'CORSICAN'; // Corsica
					$country_name = 'COLUMBIA';
				break;
				//Eeyou Istchee ᐄᔨᔨᐤ ᐊᔅᒌ
				case 'cr':
					$lang_name = 'CREE';
					$country_name = 'COSTA_RICA';
				break;

				case 'cs':
					$lang_name = 'CZECH';
					$country_name = 'CZECH_REPUBLIC';
				break;

				case 'cu':
					$lang_name = 'SLAVONIC';
					$country_name = 'CUBA'; //langs: 
				break;

				case 'cv':
					$country_name = 'CAPE_VERDE';
					$lang_name = 'CHUVASH';
				break;
				
				case 'cx':
					$lang_name = ''; // Malaysian Chinese origin and  European Australians 
					$country_name = 'CHRISTMAS_ISLAND';
				break;
				
				case 'cy':
					$lang_name = 'CYPRUS';
					$country_name = 'CYPRUS';
				break;
				
				case 'cz':
					$lang_name = 'CZECH';
					$country_name = 'CZECH_REPUBLIC';
				break;
				
				case 'cw':
					$lang_name = 'PAPIAMENTU';   // Papiamentu (Portuguese-based Creole), Dutch, English
					$country_name = 'CURAÇÃO'; // Ilha da Curação (Island of Healing)
				break;
				
				case 'da':
					$lang_name = 'DANISH';
					$country_name = 'DENMARK';
				break;

				case 'de':
					$lang_name = 'GERMAN';
					$country_name = 'GERMANY';
				break;
				
				case 'dk':
					$lang_name = 'DANISH';
					$country_name = 'DENMARK';
				break;				
				
				//acf – Saint Lucian / Dominican Creole French		
				case 'acf':
					$lang_name = 'DOMINICAN_CREOLE_FRENCH'; //ROSEAU 
					$country_name = 'DOMINICA';
				break;
				
				case 'en_dm':
				case 'en-DM':
					$lang_name = 'DOMINICA_ENGLISH'; 
					$country_name = 'DOMINICA';
				break;

				case 'do':
				case 'en_do':
				case 'en-DO':
					$lang_name = 'SPANISH'; //Santo Domingo
					$country_name = 'DOMINICAN_REPUBLIC';
				break;

				case 'dj':
				case 'aa-DJ':
				case 'aa_dj':
					$lang_name = 'DJIBOUTI'; //Yibuti, Afar
					$country_name = 'REPUBLIC_OF_DJIBOUTI'; //République de Djibouti
				break;

				case 'dv':
					$lang_name = 'DIVEHI'; //Maldivian
					$country_name = 'MALDIVIA';
				break;
				
				//Berbera Taghelmustă (limba oamenilor albaștri), zisă și Tuaregă, este vorbită în Sahara occidentală.
				//Berbera Tamazigtă este vorbită în masivul Atlas din Maroc, la sud de orașul Meknes.
				//Berbera Zenatică zisă și Rifană, este vorbită în masivul Rif din Maroc, în nord-estul țării.
				//Berbera Șenuană zisă și Telică, este vorbită în masivul Tell din Algeria, în nordul țării.
				//Berbera Cabilică este vorbită în jurul masivelor Mitigea și Ores din Algeria, în nordul țării.
				//Berbera Șauiană este vorbită în jurul orașului Batna din Algeria.
				//Berbera Tahelhită, zisă și Șlănuană (în limba franceză Chleuh) este vorbită în jurul masivului Tubkal din Maroc, în sud-vestul țării.
				//Berbera Tamașekă, zisă și Sahariană, este vorbită în Sahara de nord, în Algeria, Libia și Egipt.
				//Berber: Tacawit (@ city Batna from Chaoui, Algery), Shawiya (Shauian)
				case 'shy':
					$lang_name = 'SHAWIYA_BERBER';
					$country_name = 'ALGERIA'; 
				break;

				case 'dz':
					$lang_name = 'DZONGKHA';
					$country_name = 'ALGERIA'; //http://www.el-mouradia.dz/
				break;

				case 'ec':
					$country_name = 'ECUADOR';
					$lang_name = 'ECUADOR';
				break;

				case 'eg':
					$country_name = 'EGYPT';
					$lang_name = 'EGYPT';
				break;

				case 'eh':
					$lang_name = 'WESTERN_SAHARA';
					$country_name = 'WESTERN_SAHARA';
				break;

				case 'ee':
					//Kɔsiɖagbe (Sunday)
					//Dzoɖagbe (Monday) 	
					//Braɖagbe, Blaɖagbe (Tuesday) 	
					//Kuɖagbe (Wednesday)
					//Yawoɖagbe (Thursday)
					//Fiɖagbe (Friday)
					//Memliɖagbe (Saturday)
					$lang_name = 'EWE'; //Èʋegbe Native to Ghana, Togo
					$country_name = 'ESTONIA';
				break;
				
				case 'en_uk':
				case 'en-UK':
				case 'uk':
					$lang_name = 'BRITISH_ENGLISH'; //used in United Kingdom
					$country_name = 'GREAT_BRITAIN';
				break;
						
				case 'en_fj':
				case 'en-FJ':
					$lang_name = 'FIJIAN_ENGLISH';
					$country_name = 'FIJI';
				break;
				
				case 'GibE':			
				case 'en_gb':
				case 'en-GB':
				case 'gb':
					$lang_name = 'GIBRALTARIAN _ENGLISH'; //used in Gibraltar
					$country_name = 'GIBRALTAR';
				break;
				
				case 'en_us':
				case 'en-US':
					$lang_name = 'AMERICAN_ENGLISH';
					$country_name = 'UNITED_STATES_OF_AMERICA';
				break;
				
				case 'en_ie':
				case 'en-IE':
				case 'USEng':
					$lang_name = 'HIBERNO_ENGLISH'; //Irish English
					$country_name = 'IRELAND';
				break;
				
				case 'en_il':
				case 'en-IL':
				case 'ILEng':
				case 'heblish':
				case 'engbrew':
					$lang_name = 'ISRAELY_ENGLISH'; 
					$country_name = 'ISRAEL';
				break;
				
				case 'en_ca':
				case 'en-CA':
				case 'CanE':
					$lang_name = 'CANADIAN_ENGLISH'; 
					$country_name = 'CANADA';
				break;	
				
				case 'en_ck':
					$lang_name = 'COOK_ISLANDS_ENGLISH';
					$country_name = 'COOK_ISLANDS'; //CK 	Cook Islands
				break;	
				
				case 'en_in':
				case 'en-IN':
					$lang_name = 'INDIAN_ENGLISH'; 
					$country_name = 'REPUBLIC_OF_INDIA';
				break;
				
				case 'en_ai':
				case 'en-AI':
					$lang_name = 'ANGUILLAN_ENGLISH'; 
					$country_name = 'ANGUILLA';
				break;
				
				case 'en_au':
				case 'en-AU':
				case 'AuE': 
					$lang_name = 'AUSTRALIAN_ENGLISH'; 
					$country_name = 'AUSTRALIA';
				break;	
				
				case 'en_nz':
				case 'en-NZ':
				case 'NZE': 
					$lang_name = 'NEW_ZEALAND_ENGLISH'; 
					$country_name = 'NEW_ZEALAND';
				break;	
				
				case 'en_nu':
					$lang_name = 'NIUEAN_ENGLISH'; //Niuean (official) 46% (a Polynesian language closely related to Tongan and Samoan)
					$country_name = 'NIUE'; // Niuean: Niuē
				break;
				
				case 'en_ms':
					$lang_name = 'MONTSERRAT_ENGLISH';
					$country_name = 'MONTSERRAT';
				break;	
				
				case 'en_pn':
					$lang_name = 'PITCAIRN_ISLAND_ENGLISH';
					$country_name = 'PITCAIRN_ISLAND';
				break;
								
				case 'en_sh':
					$lang_name = 'ST_HELENA_ENGLISH';
					$country_name = 'ST_HELENA';
				break;
				
				case 'en_tc':
					$lang_name = 'TURKS_&AMP;_CAICOS_IS_ENGLISH';
					$country_name = 'TURKS_&AMP;_CAICOS_IS';
				break;	

				case 'en_vg':
					$lang_name = 'VIRGIN_ISLANDS_ENGLISH';
					$country_name = 'VIRGIN_ISLANDS_(BRIT)';
				break;
				
				case 'eo':
					$lang_name = 'ESPERANTO'; //created in the late 19th century by L. L. Zamenhof, a Polish-Jewish ophthalmologist. In 1887
					$country_name = 'EUROPE';
				break;

				case 'er':
					$lang_name = 'ERITREA';
					$country_name = 'ERITREA';
				break;

				case 'es':
					$lang_name = 'SPANISH';
					$country_name = 'SPAIN';
				break;

				case 'et':
					$lang_name = 'ESTONIAN';
					$country_name = 'ESTONIA';
				break;

				case 'eu':
					$lang_name = 'BASQUE';
					$country_name = '';
				break;

				case 'fa':
					$lang_name = 'PERSIAN';
					$country_name = '';
				break;

				case 'ff':
					$lang_name = 'FULAH';
					$country_name = '';
				break;

				case 'fi':
				case 'fin':
					$lang_name = 'FINNISH';
					$country_name = 'FINLAND';
				break;
				
				case 'fkv':
					$lang_name = 'KVEN';
					$country_name = 'NORWAY';
				break;
				
				case 'fit':
					$lang_name = 'KVEN';
					$country_name = 'SWEDEN';
				break;
				
				case 'fj':
					$lang_name = 'FIJIAN';
					$country_name = 'FIJI';
				break;

				case 'fk':
					$lang_name = 'FALKLANDIAN';
					$country_name = 'FALKLAND_ISLANDS';
				break;

				case 'fm':
					$lang_name = 'MICRONESIA';
					$country_name = 'MICRONESIA';
				break;

				case 'fo':
					$lang_name = 'FAROESE';
					$country_name = 'FAROE_ISLANDS';
				break;
				
				//Frenc
				case 'fr':
					$lang_name = 'FRENCH';
					$country_name = 'FRANCE';
				break;
				//Acadian French
				case 'fr_ac':
					$lang_name = 'ACADIAN_FRENCH';
					$country_name = 'ACADIA';
				break;
				
				case 'fr_dm':
				case 'fr-DM':
					$lang_name = 'DOMINICA_FRENCH'; 
					$country_name = 'DOMINICA';
				break;
				
				//al-dîzāyīr
				case 'fr_dz':
					$lang_name = 'ALGERIAN_FRENCH';
					$country_name = 'ALGERIA';
				break;
				//Aostan French (French: français valdôtain)
				//Seventy:		septante[a] [sɛp.tɑ̃t]
				//Eighty:		huitante[b] [ɥi.tɑ̃t]
				//Ninety:		nonante[c] [nɔ.nɑ̃t]
				case 'fr_ao':
					$lang_name = 'AOSTAN_FRENCH';
					$country_name = 'ITALY';
				break;
				//Belgian French
				case 'fr_bl':
					$lang_name = 'BELGIAN_FRENCH';
					$country_name = 'BELGIUM';
				break;
				//Cambodian French -  French Indochina
				case 'fr_cb':
					$lang_name = 'CAMBODIAN_FRENCH';
					$country_name = 'CAMBODIA';
				break;
				//Cajun French - Le Français Cajun - New Orleans
				case 'fr_cj':
					$lang_name = 'CAJUN_FRENCH';
					$country_name = 'UNITED_STATES';
				break;
				//Canadian French  (French: Français Canadien)
				//Official language in Canada,  New Brunswick, Northwest Territories, Nunavut, Quebec, Yukon, 
				//Official language in United States, Maine (de facto),  New Hampshire
				case 'fr_ca':
				case 'fr-CA':
					$lang_name = 'CANADIAN_FRENCH';
					$country_name = 'CANADA';
				break;
				//Guianese French
				case 'gcr':
				case 'fr_gu':
					$lang_name = 'GUIANESE_FRENCH';
					$country_name = 'FRENCH_GUIANA';
				break;
				//Guianese English
				case 'gyn':
				case 'en_gy':
					$lang_name = 'GUYANESE_CREOLE';
					$country_name = 'ENGLISH_GUIANA';
				break;
				//Haitian French
				case 'fr-HT':
				case 'fr_ht':
					$lang_name = 'HAITIAN_FRENCH';
					$country_name = 'HAITI'; //UNITED_STATES
				break;
				//Haitian English
				case 'en-HT':
				case 'en_ht':
					$lang_name = 'HAITIAN_CREOLE';
					$country_name = 'HAITI'; //UNITED_STATES
				break;				
				//Indian French
				case 'fr_id':
					$lang_name = 'INDIAN_FRENCH';
					$country_name = 'INDIA';
				break;
				case 'en_id':
					$lang_name = 'INDIAN_ENGLISH';
					$country_name = 'INDIA';
				break;
				//Jersey Legal French - Anglo-Norman French 
				case 'xno':
				case 'fr_je':
					$lang_name = 'JERSEY_LEGAL_FRENCH';
					$country_name = 'UNITED_STATES';
				break;
				
				case 'fr_kh':
					$lang_name = 'CAMBODIAN_FRENCH';
					$country_name = 'CAMBODIA';
				break;
				
				//Lao French
				case 'fr_la':
					$lang_name = 'LAO_FRENCH';
					$country_name = 'LAOS';
				break;
				//Louisiana French (French: Français de la Louisiane, Louisiana Creole: Françé la Lwizyàn)
				case 'frc':
				case 'fr_lu':
					$lang_name = 'LOUISIANIAN_FRENCH';
					$country_name = 'LOUISIANA'; 
				break;
				//Louisiana Creole
				case 'lou':
					$lang_name = 'LOUISIANA_CREOLE';
					$country_name = 'LOUISIANA'; 
				break;
				//Meridional French (French: Français Méridional, also referred to as Francitan)
				case 'fr_mr':
					$lang_name = 'MERIDIONAL_FRENCH'; 
					$country_name = 'OCCITANIA';
				break;
				//Metropolitan French (French: France Métropolitaine or la Métropole)
				case 'fr_me':
					$lang_name = 'METROPOLITAN_FRENCH';
					$country_name = 'UNITED_STATES';
				break;
				//Missouri French
				case 'fr_mi':
					$lang_name = 'MISSOURI_FRENCH';
					$country_name = 'UNITED_STATES';
				break;
				//New Caledonian French
				case 'fr_nc':
					$lang_name = 'NEW_CALEDONIAN_FRENCH';
					$country_name = 'NEW_CALEDONIA';
				break;
				//Newfoundland French
				case 'fr_nf':
					$lang_name = 'NEWFOUNDLAND_FRENCH';
					$country_name = 'NEWFOUNDLAND';
				break;
				//New England French
				case 'fr_ne':
					$lang_name = 'NEW_ENGLAND_FRENCH';
					$country_name = 'NEW_ENGLAND';
				break;
				//Quebec French
				case 'fr_qb':
					$lang_name = 'QUEBEC_FRENCH';
					$country_name = 'CANADA';
				break;
				//South East Asian French
				case 'fr_sa':
					$lang_name = 'SOUTH_EAST_ASIAN_FRENCH';
					$country_name = 'SOUTH_EAST_ASIA';
				break;
				//Swiss French
				case 'fr_sw':
					$lang_name = 'SWISS_FRENCH';
					$country_name = 'FRANCE';
				break;
				//French Southern and Antarctic Lands
				case 'fr_tf':				
				case 'tf':
					$lang_name = 'FRENCH_SOUTHERN_TERRITORIES'; //
					$country_name = 'SOUTHERN_TERRITORIES'; //Terres australes françaises
				break;
				//Vietnamese French
				case 'fr_vt':
					$lang_name = 'VIETNAMESE_FRENCH';
					$country_name = 'VIETNAM';
				break;
				//West Indian French
				case 'fr_if':
					$lang_name = 'WEST_INDIAN_FRENCH';
					$country_name = 'INDIA';
				break;
				
				case 'fy':
					$lang_name = 'FRISIAN';
					$country_name = '';
				break;

				case 'ga':
					$lang_name = 'IRISH';
					$country_name = 'GABON';
				break;
				
				case 'GenAm':
					$lang_name = 'General American';
					$country_name = 'United States';
				break;

				//gcf – Guadeloupean Creole		
				case 'gcf':
					$lang_name = 'GUADELOUPEAN_CREOLE_FRENCH'; 
					$country_name = 'GUADELOUPE';
				break;
				
				case 'gd':
					$lang_name = 'scottish';
					$country_name = 'GRENADA';
				break;
				
				case 'ge':
					$lang_name = 'Georgia';
					$country_name = 'GEORGIA';
				break;
				
				case 'gi':
					$lang_name = 'Llanito'; //Llanito or Yanito
					$country_name = 'GIBRALTAR';
				break;
				
				case 'gg':
					$lang_name = 'guernesiais'; //English, Guernésiais, Sercquiais, Auregnais
					$country_name = 'GUERNSEY';
				break;
				
				case 'gh':
					$lang_name = 'Ghana';
					$country_name = 'GHANA';
				break;
				
				case 'gr':
					$lang_name = 'Greece';
					$country_name = 'GREECE';
				break;

				case 'gl':
					$lang_name = 'galician';
					$country_name = 'GREENLAND';
				break;
				
				case 'gm':
					$lang_name = 'Gambia';
					$country_name = 'GAMBIA';
				break;
				
				case 'gn':
					$lang_name = 'Guinea';
					$country_name = 'GUINEA';
				break;
				
				case 'gs':
					$lang_name = 'ENGLISH';
					$country_name = 'SOUTH_GEORGIA_AND_THE_SOUTH_SANDWICH_ISLANDS';
				break;
				
				case 'gt':
					$lang_name = 'Guatemala';
					$country_name = 'GUATEMALA';
				break;
				
				case 'gq':
					$lang_name = 'Equatorial Guinea';
					$country_name = 'EQUATORIAL_GUINEA';
				break;

				case 'gu':
					$lang_name = 'GUJARATI';
					$country_name = 'GUAM';
				break;

				case 'gv':
					$lang_name = 'manx';
					$country_name = '';
				break;
				
				case 'gw':
					$lang_name = 'Guinea Bissau';
					$country_name = 'GUINEA_BISSAU';
				break;

				case 'gy':
					$lang_name = 'Guyana';
					$country_name = 'GUYANA';
				break;

				case 'ha':
					$country_name = '';
					$lang_name = 'HAUSA';
				break;


				case 'he':
					$country_name = 'ISRAEL';
					$lang_name = 'HEBREW';
				break;

				case 'hi':
					$lang_name = 'hindi';
					$country_name = '';
				break;
				
				case 'ho':
					$lang_name = 'hiri_motu';
					$country_name = '';
				break;
				
				case 'hk':
					$lang_name = 'Hong Kong';
					$country_name = 'HONG_KONG';
				break;
				
				case 'hn':
					$country_name = 'Honduras';
					$lang_name = 'HONDURAS';
				break;
				
				case 'hr':
					$lang_name = 'croatian';
					$country_name = 'CROATIA';
				break;
				
				case 'ht':
					$lang_name = 'haitian';
					$country_name = 'HAITI';
				break;
				
				case 'ho':
					$lang_name = 'hiri_motu';
					$country_name = '';
				break;
				
				case 'hu':
					$lang_name = 'hungarian';
					$country_name = 'HUNGARY';
				break;
				
				case 'hy':
				case 'hy-am':
					$lang_name = 'ARMENIAN';
					$country_name = '';
				break;

				case 'hy-AT':
				case 'hy_at':
					$lang_name = 'ARMENIAN-ARTSAKH';
					$country_name = 'REPUBLIC_OF_ARTSAKH';
				break;

				case 'hz':
					$lang_name = 'HERERO';
					$country_name = '';
				break;
				
				case 'ia':
					$lang_name = 'INTERLINGUA';
					$country_name = '';
				break;
				
				case 'ic':
					$lang_name = '';
					$country_name = 'CANARY_ISLANDS';
				break;
				
				case 'id':
					$lang_name = 'INDONESIAN';
					$country_name = 'INDONESIA';
				break;
				
				case 'ie':
					$lang_name = 'interlingue';
					$country_name = 'IRELAND';
				break;
				
				case 'ig':
					$lang_name = 'igbo';
					$country_name = '';
				break;
				
				case 'ii':
					$lang_name = 'sichuan_yi';
					$country_name = '';
				break;
				
				case 'ik':
					$lang_name = 'inupiaq';
					$country_name = '';
				break;
				
				case 'il':
					$lang_name = 'ibrit';
					$country_name = 'ISRAEL';
				break;
				
				case 'im':
					$lang_name = 'Isle of Man';
					$country_name = 'ISLE_OF_MAN';
				break;
				
				case 'in':
					$lang_name = 'India';
					$country_name = 'INDIA';
				break;
				
				
				case 'ir':
					$lang_name = 'Iran';
					$country_name = 'IRAN';
				break;
				
				case 'is':
					$lang_name = 'Iceland';
					$country_name = 'ICELAND';
				break;
				
				case 'it':
					$lang_name = 'ITALIAN';
					$country_name = 'ITALY';
				break;
				
				case 'iq':
					$lang_name = 'Iraq';
					$country_name = 'IRAQ';
				break;
				
				case 'je':
					$lang_name = 'jerriais'; //Jèrriais
					$country_name = 'JERSEY'; //Bailiwick of Jersey
				break;
				
				case 'jm':
					$lang_name = 'Jamaica';
					$country_name = 'JAMAICA';
				break;
				
				case 'jo':
					$lang_name = 'Jordan';
					$country_name = 'JORDAN';
				break;
				
				case 'jp':
					$lang_name = 'japanese';
					$country_name = 'JAPAN';
				break;
				
				case 'jv':
					$lang_name = 'javanese';
					$country_name = '';
				break;
				
				case 'kh':
					$lang_name = 'KH';
					$country_name = 'CAMBODIA';
				break;
				
				case 'ke':
					$lang_name = 'Kenya';
					$country_name = 'KENYA';
				break;
				
				case 'ki':
					$lang_name = 'Kiribati';
					$country_name = 'KIRIBATI';
				break;
				
				//Bantu languages 
				//zdj – Ngazidja Comorian
				case 'zdj':
					$lang_name = 'Ngazidja Comorian';
					$country_name = 'COMOROS';
				break;
				//wni – Ndzwani  Comorian (Anjouani) dialect
				case 'wni':
					$lang_name = 'Ndzwani Comorian';
					$country_name = 'COMOROS';
				break;
				//swb – Maore Comorian dialect
				case 'swb':
					$lang_name = 'Maore Comorian';
					$country_name = 'COMOROS';
				break;
				//wlc – Mwali Comorian dialect				
				case 'wlc':
					$lang_name = 'Mwali Comorian';
					$country_name = 'COMOROS';
				break;
				
				case 'km':
					$lang_name = 'KHMER';
					$country_name = 'COMOROS';
				break;			
				
				case 'kn':
					$lang_name = 'kannada';
					$country_name = 'ST_KITTS-NEVIS';
				break;
				
				case 'ko':
				case 'kp':
					$lang_name = 'korean';
					// kor – Modern Korean
					// jje – Jeju
					// okm – Middle Korean
					// oko – Old Korean
					// oko – Proto Korean
					// okm Middle Korean
					 // oko Old Korean
					$country_name = 'Korea North';
				break;
				
				case 'kr':
					$lang_name = 'korean';
					$country_name = 'KOREA_SOUTH';
				break;
				
				case 'kn':
					$lang_name = 'St Kitts-Nevis';
					$country_name = 'ST_KITTS-NEVIS';
				break;
				
				case 'ks':
					$lang_name = 'kashmiri'; //Kashmir
					$country_name = 'KOREA_SOUTH';
				break;
				
				case 'ky':
					$lang_name = 'Cayman Islands';
					$country_name = 'CAYMAN_ISLANDS';
				break;

				case 'kz':
					$lang_name = 'Kazakhstan';
					$country_name = 'KAZAKHSTAN';
				break;

				case 'kw':
					//endonim: Kernewek
					$lang_name = 'Cornish';
					$country_name = 'KUWAIT';
				break;

				case 'kg':
					$lang_name = 'Kyrgyzstan';
					$country_name = 'KYRGYZSTAN';
				break;

				case 'la':
					$lang_name = 'Laos';
					$country_name = 'LAOS';
				break;

				case 'lk':
					$lang_name = 'Sri Lanka';
					$country_name = 'SRI_LANKA';
				break;

				case 'lv':
					$lang_name = 'Latvia';
					$country_name = 'LATVIA';
				break;

				case 'lb':
					$lang_name = 'Lebanon';
					$country_name = 'LEBANON';
				break;
				
				case 'lc':
					$lang_name = 'St Lucia';
					$country_name = 'ST_LUCIA';
				break;
				
				case 'ls':
					$lang_name = 'Lesotho';
					$country_name = 'LESOTHO';
				break;
				
				case 'lo':
					$lang_name = 'LAO';
					$country_name = 'LAOS'; 
				break;
				
				case 'lr':
					$lang_name = 'Liberia';
					$country_name = 'LIBERIA';
				break;

				case 'ly':
					$lang_name = 'Libya';
					$country_name = 'Libya';
				break;

				case 'li':
					$lang_name = 'Liechtenstein';
					$country_name = 'LIECHTENSTEIN';
				break;

				case 'lt':
					$country_name = 'Lithuania';
					$lang_name = 'LITHUANIA';
				break;

				case 'lu':
					$lang_name = 'Luxembourg';
					$country_name = 'LUXEMBOURG';
				break;
				
				case 'ma':
					$lang_name = 'Morocco';
					$country_name = 'MOROCCO';
				break;
				
				case 'mc':
					$country_name = 'MONACO';
					$lang_name = 'Monaco';
				break;
				
				case 'me':
					$lang_name = 'MONTENEGRIN'; //Serbo-Croatian, Cyrillic, Latin
					$country_name = 'MONTENEGRO'; //Црна Гора
				break;
				
				case 'md':
					$country_name = 'MOLDOVA';
					$lang_name = 'romanian';
				break;	
				
				case 'mi':
					$lang_name = 'MAORI';
					$country_name = 'Maori';
				break;	
				
				case 'mf':
					$lang_name = 'FRENCH'; //
					$country_name = 'SAINT_MARTIN_(FRENCH_PART)'; 
				break;
				
				case 'mk':
					$lang_name = 'Macedonia';
					$country_name = 'MACEDONIA';
				break;
				
				case 'mg':
					$lang_name = 'Madagascar';
					$country_name = 'MADAGASCAR';
				break;

				case 'mh':
					$lang_name = 'Marshall Islands';
					$country_name = 'MARSHALL_ISLANDS';
				break;

				case 'mr':
					$lang_name = 'Mauritania';
					$country_name = 'Mauritania';
				break;

				case 'mu':
					$lang_name = 'Mauritius';
					$country_name = 'MAURITIUS';
				break;
				
				case 'mo':
					$lang_name = 'Macau';
					$country_name = 'MACAU';
				break;
				
				case 'mn':
					$lang_name = 'Mongolia';
					$country_name = 'MONGOLIA';
				break;

				case 'ms':
					$lang_name = 'Montserrat';
					$country_name = 'MONTSERRAT';
				break;
				
				case 'mz':
					$lang_name = 'Mozambique';
					$country_name = 'MOZAMBIQUE';
				break;
				
				case 'mm':
					$lang_name = 'Myanmar';
					$country_name = 'MYANMAR';
				break;
				
				case 'mp':
					$lang_name = 'chamorro'; //Carolinian
					$country_name = 'NORTHERN_MARIANA_ISLANDS';
				break;
				
				case 'mw':
					$country_name = 'Malawi';
					$lang_name = 'MALAWI';
				break;

				case 'my':
					$lang_name = 'Myanmar';
					$country_name = 'MALAYSIA';
				break;

				case 'mv':
					$lang_name = 'Maldives';
					$country_name = 'MALDIVES';
				break;

				case 'ml':
					$lang_name = 'Mali';
					$country_name = 'MALI';
				break;

				case 'mt':
					$lang_name = 'Malta';
					$country_name = 'MALTA';
				break;
				
				case 'mx':
					$lang_name = 'Mexico';
					$country_name = 'MEXICO';
				break;
				
				case 'mq':
					$lang_name = 'antillean-creole'; // Antillean Creole (Créole Martiniquais)
					$country_name = 'MARTINIQUE';
				break;
				
				case 'na':
					$lang_name = 'Nambia';
					$country_name = 'NAMBIA';
				break;
				
				case 'ni':
					$lang_name = 'Nicaragua';
					$country_name = 'NICARAGUA';
				break;
				
				//Barber: Targuí, tuareg
				case 'ne':
					$lang_name = 'Niger';
					$country_name = 'NIGER';
				break;
				
				case 'new':
					$lang_name = 'NEW_LANGUAGE'; 
					$country_name = 'NEW_COUNTRY';
				break;	
				
				case 'nc':
					$lang_name = 'paicî'; //French, Nengone, Paicî, Ajië, Drehu
					$country_name = 'NEW_CALEDONIA';
				break;
				
				case 'nk':
					$lang_name = 'Korea North';
					$country_name = 'KOREA_NORTH';
				break;
				
				case 'ng':
					$lang_name = 'Nigeria';
					$country_name = 'NIGERIA';
				break;
				
				case 'nf':
					$lang_name = 'Norfolk Island';
					$country_name = 'NORFOLK_ISLAND';
				break;
				
				case 'nl':
					$lang_name = 'DUTCH'; //Netherlands, Flemish.
					$country_name = 'NETHERLANDS';
				break;
				
				case 'no':
					$lang_name = 'Norway';
					$country_name = 'NORWAY';
				break;
				
				case 'np':
					$lang_name = 'Nepal';
					$country_name = 'NEPAL';
				break;
				
				case 'nr':
					$lang_name = 'Nauru';
					$country_name = 'NAURU';
				break;
				
				case 'niu':
					$lang_name = 'NIUEAN'; //Niuean (official) 46% (a Polynesian language closely related to Tongan and Samoan)
					$country_name = 'NIUE'; // Niuean: Niuē
				break;
				
				case 'nu':
					$lang_name = 'NU'; //Niuean (official) 46% (a Polynesian language closely related to Tongan and Samoan)
					$country_name = 'NIUE'; // Niuean: Niuē
				break;
				
				case 'nz':
					$lang_name = 'New Zealand';
					$country_name = 'NEW_ZEALAND';
				break;
				
				case 'ny':
					$lang_name = 'Chewa';
					$country_name = 'Nyanja';
				break;
				//langue d'oc
				case 'oc':
					$lang_name = 'OCCITAN';
					$country_name = 'OCCITANIA';
				break;

				case 'oj':
					$lang_name = 'ojibwa';
					$country_name = '';
				break;

				case 'om':
					$lang_name = 'Oman';
					$country_name = 'OMAN';
				break;

				case 'or':
					$lang_name = 'oriya';
					$country_name = '';
				break;

				case 'os':
					$lang_name = 'ossetian';
					$country_name = '';
				break;

				case 'pa':
					$country_name = 'Panama';
					$lang_name = 'PANAMA';
				break;


				case 'pe':
					$country_name = 'Peru';
					$lang_name = 'PERU';
				break;

				case 'ph':
					$lang_name = 'Philippines';
					$country_name = 'PHILIPPINES';
				break;
				
				case 'pf':
					$country_name = 'French Polynesia';
					$lang_name = 'tahitian'; //Polynésie française
				break;
				
				case 'pg':
					$country_name = 'PAPUA_NEW_GUINEA';
					$lang_name = 'Papua New Guinea';
				break;
				
				case 'pi':
					$lang_name = 'pali';
					$country_name = '';
				break;
				
				case 'pl':
					$lang_name = 'Poland';
					$country_name = 'POLAND';
				break;
				
				case 'pn':
					$lang_name = 'Pitcairn Island';
					$country_name = 'PITCAIRN_ISLAND';
				break;
				
				case 'pr':
					$lang_name = 'Puerto Rico';
					$country_name = 'PUERTO_RICO';
				break;
				
				case 'pt':
					$lang_name = 'Portugal';
					$country_name = 'PORTUGAL';
				break;
				
				case 'pk':
					$lang_name = 'Pakistan';
					$country_name = 'PAKISTAN';
				break;
				
				case 'pw':
					$country_name = 'Palau Island';
					$lang_name = 'PALAU_ISLAND';
				break;
				
				case 'ps':
					$country_name = 'Palestine';
					$lang_name = 'PALESTINE';
				break;
				
				case 'py':
					$country_name = 'Paraguay';
					$lang_name = 'PARAGUAY';
				break;
				
				case 'qa':
					$lang_name = 'Qatar';
					$country_name = 'QATAR';
				break;
				
				case 'ri':
					$country_name = 'EASTEN_EUROPE';
					$lang_name = 'romani';
				break;
				
				case 'ro':
					$country_name = 'ROMANIA';
					$lang_name = 'romanian';
				break;
				
				case 'rn':
					$lang_name = 'kirundi';
					$country_name = '';
				break;
				
				case 'rm':
					$country_name = '';
					$lang_name = 'romansh'; //Switzerland
				break;
				
				case 'rs':
					$country_name = 'REPUBLIC_OF_SERBIA'; //Република Србија //Republika Srbija
					$lang_name = 'serbian'; //Serbia, Србија / Srbija
				break;
				
				case 'ru':
					$country_name = 'RUSSIA';
					$lang_name = 'Russia';
				break;
				
				case 'rw':
					$country_name = 'RWANDA';
					$lang_name = 'Rwanda';
				break;

				
				case 'sa':
					$lang_name = 'arabic';
					$country_name = 'SAUDI_ARABIA';
				break;
				
				case 'sb':
					$lang_name = 'Solomon Islands';
					$country_name = 'SOLOMON_ISLANDS';
				break;
				
				case 'sc':
					$lang_name = 'seychellois-creole';
					$country_name = 'SEYCHELLES';
				break;
				
				case 'sco':
					$lang_name = 'SCOTISH';
					$country_name = 'Scotland';
				break;

				//scf – San Miguel Creole French (Panama)		
				case 'scf':
					$lang_name = 'SAN_MIGUEL_CREOLE_FRENCH';  
					$country_name = 'SAN_MIGUEL';
				break;	
				
				case 'sd':
					$lang_name = 'Sudan';
					$country_name = 'SUDAN';
				break;
				
				case 'si':
					$lang_name = 'SLOVENIAN';
					$country_name = 'SLOVENIA';
				break;
				
				case 'sh':
					$lang_name = 'SH';
					$country_name = 'ST_HELENA';
				break;
				
				case 'sk':
					$country_name = 'SLOVAKIA';
					$lang_name = 'Slovakia';
				break;
				
				case 'sg':
					$country_name = 'SINGAPORE';
					$lang_name = 'Singapore';
				break;
				
				case 'sl':
					$country_name = 'SIERRA_LEONE';
					$lang_name = 'Sierra Leone';
				break;
				
				case 'sm':
					$lang_name = 'San Marino';
					$country_name = 'SAN_MARINO';
				break;
				
				case 'smi':
					$lang_name = 'Sami';
					$country_name = 'Norway'; //Native to	Finland, Norway, Russia, and Sweden
				break;
				
				case 'sn':
					$lang_name = 'Senegal';
					$country_name = 'SENEGAL';
				break;
				
				case 'so':
					$lang_name = 'Somalia';
					$country_name = 'SOMALIA';
				break;
				
				case 'sq':
					$lang_name = 'ALBANIAN';
					$country_name = 'Albania';
				break;
				
				case 'sr':
					$lang_name = 'Suriname';
					$country_name = 'SURINAME';
				break;
				
				case 'ss':
					$lang_name = ''; //Bari [Karo or Kutuk ('mother tongue', Beri)], Dinka, Luo, Murle, Nuer, Zande
					$country_name = 'REPUBLIC_OF_SOUTH_SUDAN';
				break;
				
				case 'sse':
					$lang_name = 'STANDARD_SCOTTISH_ENGLISH';
					$country_name = 'Scotland';
				break;
				
				case 'st':
					$lang_name = 'Sao Tome &amp; Principe';
					$country_name = 'SAO_TOME_&AMP;_PRINCIPE';
				break;
				
				case 'sv':
					$lang_name = 'El Salvador';
					$country_name = 'EL_SALVADOR';
				break;
				
				case 'sx':
					$lang_name = 'dutch';
					$country_name = 'SINT_MAARTEN_(DUTCH_PART)';
				break;
				
				
				case 'sz':
					$lang_name = 'Swaziland';
					$country_name = 'SWAZILAND';
				break;
				
				case 'se':
					$lang_name = 'Sweden';
					$country_name = 'SWEDEN';
				break;

				case 'sy':
					$lang_name = 'SYRIAC'; //arabic syrian
					$country_name = 'SYRIA';
				break;
				

				case 'tc':
					$lang_name = 'Turks &amp; Caicos Is';
					$country_name = 'TURKS_&AMP;_CAICOS_IS';
				break;
				
				case 'td':
					$lang_name = 'Chad';
					$country_name = 'CHAD';
				break;
				
				case 'tf':
					$lang_name = 'french '; //
					$country_name = 'FRENCH_SOUTHERN_TERRITORIES'; //Terres australes françaises
				break;
				
				case 'tj':
					$lang_name = 'Tajikistan';
					$country_name = 'TAJIKISTAN';
				break;
				
				case 'tg':
					$lang_name = 'Togo';
					$country_name = 'TOGO';
				break;
				
				case 'th':
					$country_name = 'Thailand';
					$lang_name = 'THAILAND';
				break;
				
				case 'tk':
					//260 speakers of Tokelauan, of whom 2,100 live in New Zealand, 
					//1,400 in Tokelau, 
					//and 17 in Swains Island
					$lang_name = 'Tokelauan'; // /toʊkəˈlaʊən/ Tokelauans or Polynesians
					$country_name = 'TOKELAUAU'; //Dependent territory of New Zealand
				break;
				
				case 'tl':
					$country_name = 'East Timor';
					$lang_name = 'East Timor';
				break;	
				
				case 'to':
					$country_name = 'Tonga';
					$lang_name = 'TONGA';
				break;
				
				case 'tt':
					$country_name = 'Trinidad &amp; Tobago';
					$lang_name = 'TRINIDAD_&AMP;_TOBAGO';
				break;
				
				case 'tn':
					$lang_name = 'Tunisia';
					$country_name = 'TUNISIA';
				break;
				
				case 'tm':
					$lang_name = 'Turkmenistan';
					$country_name = 'TURKMENISTAN';
				break;
				
				case 'tr':
					$lang_name = 'Turkey';
					$country_name = 'TURKEY';
				break;
				
				case 'tv':
					$lang_name = 'Tuvalu';
					$country_name = 'TUVALU';
				break;
				
				case 'tw':
					$lang_name = 'TAIWANESE_HOKKIEN'; //Taibei Hokkien
					$country_name = 'TAIWAN';
				break;
				
				case 'tz':
					$country_name = 'TANZANIA';
					$lang_name = 'Tanzania';
				break;

				case 'ug':
					$lang_name = 'Uganda';
					$country_name = 'UGANDA';
				break;

				case 'ua':
					$lang_name = 'Ukraine';
					$country_name = 'UKRAINE';
				break;

				case 'us':
					$lang_name = 'en-us';
					$country_name = 'UNITED_STATES_OF_AMERICA';
				break;
				
				case 'uz':
					$lang_name = 'uzbek'; //Uyghur Perso-Arabic alphabet
					$country_name = 'UZBEKISTAN';
				break;
				
				case 'uy':
					$lang_name = 'Uruguay';
					$country_name = 'URUGUAY';
				break;
				
				case 'va':
					$country_name = 'VATICAN_CITY'; //Holy See
					$lang_name = 'latin';
				break;
				
				case 'vc':
					$country_name = 'ST_VINCENT_&AMP;_GRENADINES'; //
					$lang_name = 'vincentian-creole';
				break;
				
				case 've':
					$lang_name = 'Venezuela';
					$country_name = 'VENEZUELA';
				break;
				
				case 'vi':
					$lang_name = 'Virgin Islands (USA)';
					$country_name = 'VIRGIN_ISLANDS_(USA)';
				break;
				
				case 'vn':
					$lang_name = 'Vietnam';
					$country_name = 'VIETNAM';
				break;

				case 'vg':
					$lang_name = 'Virgin Islands (Brit)';
					$country_name = 'VIRGIN_ISLANDS_(BRIT)';
				break;
				
				case 'vu':
					$lang_name = 'Vanuatu';
					$country_name = 'VANUATU';
				break;
				
				case 'wls':
					$lang_name = 'Wales';
					$country_name = 'WALES';
				break;
				
				case 'wf':
					$country_name = 'TERRITORY_OF_THE_WALLIS_AND_FUTUNA_ISLANDS';
					$lang_name = 'Wallisian'; 
					//Wallisian, or ʻUvean 
					//Futunan - Austronesian, Malayo-Polynesian
				break;
				
				case 'ws':
					$country_name = 'SAMOA';
					$lang_name = 'Samoa';
				break;
				
				case 'ye':
					$lang_name = 'Yemen';
					$country_name = 'YEMEN';
				break;
				
				case 'yt':
					$lang_name = 'Mayotte'; //Shimaore:
					$country_name = 'DEPARTMENT_OF_MAYOTTE'; //Département de Mayotte
				break;
				
				case 'za':
					$lang_name = 'zhuang';
					$country_name = 'SOUTH_AFRICA';
				break;
				case 'zm':
					$lang_name = 'zambian';
					$country_name = 'ZAMBIA';
				break;
				case 'zw':
					$lang_name = 'Zimbabwe';
					$country_name = 'ZIMBABWE';
				break;
				case 'zu':
					$lang_name = 'zulu';
					$country_name = 'ZULU';
				break;
				default:
					$lang_name = $file_dir;
					$country_name = $file_dir;
				break;
			}
			$return = ($lang_country == 'country') ? $country_name : $lang_name;
			$return = ($langs_countries == true) ? $lang_name[$country_name] : $return;
			return $return ;	}
	
	/**
	 * Returns flag files list from an specific directory path
	 */
	 
	if (!class_exists('phpbb_db_tools') && !class_exists('tools'))
	{
		global $phpbb_root_path, $phpEx;
		require($mx_root_path . 'includes/db/db_tools.' . $phpEx);
	}

	if (class_exists('phpbb_db_tools'))
	{
		$db_tools = new phpbb_db_tools($db);
	}
	elseif (class_exists('tools'))
	{
		$db_tools = new tools($db);
	}
	
	$template->assign_vars(array(
		"L_FLAGS_TITLE" => $lang['Flags_title'],
		"L_FLAGS_TEXT" => $lang['Flags_explain'],
		"L_FLAG" => $lang['Flag_name'],
		"L_FLAG_PIC" => $lang['Flag_pic'],
		"L_EDIT" => $lang['Edit'],
		"L_DELETE" => $lang['Delete'],
		"L_ADD_FLAG" => $lang['Add_new_flag'],
		"L_ACTION" => $lang['Action'],
		
		"S_FLAGS_ACTION" => mx_append_sid("admin_country_flags.$phpEx"))
	);	 

	//
	// Show the default page
	//
	$template->set_filenames(array(
		"body" => "admin/flags_list_body.tpl")
	);

	// get all countries installed
	$countries = array();
	$flag_rows = array();
	$flag_count = 0;
	//if (!is_object($db_tools) || (is_object($db_tools) && $db_tools->sql_table_exists($table_prefix . 'flags')))
	if (!is_object($db_tools) || (is_object($db_tools) && $db_tools->sql_table_exists(FLAG_TABLE)))
	{
		$sql = "SELECT * FROM " . FLAG_TABLE . "
			ORDER BY flag_id ASC";
		//$sql = "SELECT * FROM " . FLAG_TABLE;
		if( !$result = $db->sql_query($sql) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't obtain flags data", "", __LINE__, __FILE__, $sql);
		}

		$flag_count = $db->sql_numrows($result);
		$flag_rows = $db->sql_fetchrowset($result);
	}

	if (!is_object($db_tools) || (is_object($db_tools) && $db_tools->sql_table_exists(FLAG_TABLE) && $flag_count > 1))
	{
		for ($i = 0; $i < $flag_count; $i++)
		{
			$flag = $flag_rows[$i]['flag_name'];
			$flag_id = $flag_rows[$i]['flag_id'];

			$flag_count++;
			$i = $flag_id ;
			$row_color = ($i % 2 == 0) ? $theme['td_color1'] : $theme['td_color3'];
			$row_class = ($i % 2 == 0) ? $theme['td_class1'] : $theme['td_class2'];

			$template->assign_block_vars("flags", array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,

				//We need multilanguage traslation for each flag
				"FLAG" => isset($lang[$flag]) ? $lang[$flag] : $flag,
				//"FLAG" => $flag,

				"IMAGE_DISPLAY" => '<img src="' . $phpbb_root_path . '/images/flags/' . $flag_rows[$i]['flag_image'] . '" />',

				"U_FLAG_EDIT" => mx_append_sid("admin_country_flags.$phpEx?mode=edit&amp;id=$flag_id"),
				"U_FLAG_DELETE" => mx_append_sid("admin_country_flags.$phpEx?mode=delete&amp;id=$flag_id"))
			);
		}
	}
	else
	{ 
		$flag_id = 1;
		$sql_ary[] = array();

		//$flag_count = (bool) count(glob($phpbb_root_path . '/images/flags', GLOB_BRACE));
		if (!is_dir($phpbb_root_path . 'images/flags/country'))
		{
			$dir = @opendir($phpbb_root_path . '/images/flags');
		}
		else
		{
			$dir = @opendir($phpbb_root_path . '/images/flags/country/');
		}

		while ($flag = @readdir($dir))
		{
			if (preg_match('#^png#i', substr(strrchr($flag, '.'), 1)) && !is_file($phpbb_root_path . '/images/flags' . $flag) && !is_link($phpbb_root_path . '/images/flags' . $flag))
			{
				$flag_id++;
				$filename = basename($flag);
				$displayname = substr($filename, 0, strrpos($filename, '.'));
				//$displayname = trim(str_replace(substr(strrchr($flag_file, '.'), 1), '', $flag_file));

				$displayname = preg_replace("/^(.*?)_(.*)$/", "\\1 [ \\2 ]", $displayname);
				$flag_name = preg_replace("/\[(.*?)_(.*)\]/", "[ \\1 - \\2 ]", $displayname);

				$country_name = ucfirst(decode_country_name(strtolower($flag_name)));	

				/* This code is commented and left as reference how a language list displays on other boards * /
				if (isset($lang['USER_LANG']))
				{
					if(!empty($lang['USER_LANG']) && is_file($phpbb_root_path . 'images/flags/'.$lang['USER_LANG'].'.png'))
					{
						$lang_name = decode_country_name($lang['USER_LANG'], 'language');
						//here You can set an icon with img src=
					}
				}
				/**/

				$flags[$flag_id] = $flag;
				$flag_array[$flag] = $flag_id;
				$countries[$flag] = $country_name;
			}
		}
		@closedir($dir);

		$flag_id = 1;
		$flag_count = (bool) count($countries);

		foreach($countries as $flag => $country_name)
		{
			$flag_count++;
			$i = $flag_id = $flag_array[$flag];
			$row_color = ($i % 2 == 0) ? $theme['td_color1'] : $theme['td_color3'];
			$row_class = ($i % 2 == 0) ? $theme['td_class1'] : $theme['td_class2'];

			$filename = basename($flag);
			$displayname = substr($filename, 0, strrpos($filename, '.'));

			//$lang_name = decode_country_name($displayname, 'language');
			$country_name = decode_country_name($displayname, 'country');

			if (!is_dir($phpbb_root_path . '/images/flags/'))
			{
				// create the directory flags
				$result = mkdir($phpbb_root_path . '/images/flags/');
				chmod($phpbb_root_path . '/images/flags/', 777);
				chdir($phpbb_root_path . '/images/flags/');
			}

			if (!is_dir($phpbb_root_path . '/images/flags/country/'))
			{
				// create the directory country
				$result = mkdir($phpbb_root_path . '/images/flags/country/');
				chmod($phpbb_root_path . '/images/flags/country/', 777);
				chdir($phpbb_root_path . '/images/flags/country/');

				$flag_dir = $phpbb_root_path . '/images/flags/';
			}
			else
			{
				// 
				$flag_dir = $phpbb_root_path . '/images/flags/country/';
			}

			/** /
			$sql_ary = array(
				array(
					'flag_name'		=> 'Afghanistan',
					'flag_image'	=> 'AF.png',
				),
				array(
					'flag_name'		=> 'Albania',
					'flag_image'	=> 'AL.png',
				),
				array(
					'flag_name'		=> 'Algeria',
					'flag_image'	=> 'DZ.png',
				),
				array(
					'flag_name'		=> 'American Samoa',
					'flag_image'	=> 'AS.png',
				),
				array(
					'flag_name'		=> 'Andorra',
					'flag_image'	=> 'AD.png',
				),
				array(
					'flag_name'		=> 'Angola',
					'flag_image'	=> 'AO.png',
				),
				array(
					'flag_name'		=> 'Anguilla',
					'flag_image'	=> 'AI.png',
				),
				array(
					'flag_name'		=> 'Antigua &amp; Barbuda',
					'flag_image'	=> 'AG.png',
				),
				array(
					'flag_name'		=> 'Argentina',
					'flag_image'	=> 'AR.png',
				),
				array(
					'flag_name'		=> 'Armenia',
					'flag_image'	=> 'AM.png',
				),
				array(
					'flag_name'		=> 'Aruba',
					'flag_image'	=> 'AW.png',
				),
				array(
					'flag_name'		=> 'Australia',
					'flag_image'	=> 'AU.png',
				),
				array(
					'flag_name'		=> 'Austria',
					'flag_image'	=> 'AT.png',
				),
				array(
					'flag_name'		=> 'Azerbaijan',
					'flag_image'	=> 'AZ.png',
				),
				array(
					'flag_name'		=> 'Bahamas',
					'flag_image'	=> 'BS.png',
				),
				array(
					'flag_name'		=> 'Bahrain',
					'flag_image'	=> 'BH.png',
				),
				array(
					'flag_name'		=> 'Bangladesh',
					'flag_image'	=> 'BD.png',
				),
				array(
					'flag_name'		=> 'Barbados',
					'flag_image'	=> 'BB.png',
				),
				array(
					'flag_name'		=> 'Belarus',
					'flag_image'	=> 'BY.png',
				),
				array(
					'flag_name'		=> 'Belgium',
					'flag_image'	=> 'BE.png',
				),
				array(
					'flag_name'		=> 'Belize',
					'flag_image'	=> 'BZ.png',
				),
				array(
					'flag_name'		=> 'Benin',
					'flag_image'	=> 'BJ.png',
				),
				array(
					'flag_name'		=> 'Bermuda',
					'flag_image'	=> 'BM.png',
				),
				array(
					'flag_name'		=> 'Bhutan',
					'flag_image'	=> 'BT.png',
				),
				array(
					'flag_name'		=> 'Bolivia',
					'flag_image'	=> 'BO.png',
				),
				array(
					'flag_name'		=> 'Bonaire',
					'flag_image'	=> 'BL.png',
				),
				array(
					'flag_name'		=> 'Bosnia &amp; Herzegovina',
					'flag_image'	=> 'BA.png',
				),
				array(
					'flag_name'		=> 'Botswana',
					'flag_image'	=> 'BW.png',
				),
				array(
					'flag_name'		=> 'Brazil',
					'flag_image'	=> 'BR.png',
				),
				array(
					'flag_name'		=> 'Brunei',
					'flag_image'	=> 'BN.png',
				),
				array(
					'flag_name'		=> 'Bulgaria',
					'flag_image'	=> 'BG.png',
				),
				array(
					'flag_name'		=> 'Burkina Faso',
					'flag_image'	=> 'BF.png',
				),
				array(
					'flag_name'		=> 'Burundi',
					'flag_image'	=> 'BI.png',
				),
				array(
					'flag_name'		=> 'Cambodia',
					'flag_image'	=> 'KH.png',
				),
				array(
					'flag_name'		=> 'Cameroon',
					'flag_image'	=> 'CM.png',
				),
				array(
					'flag_name'		=> 'Canada',
					'flag_image'	=> 'CA.png',
				),
				array(
					'flag_name'		=> 'Cape Verde',
					'flag_image'	=> 'CV.png',
				),
				array(
					'flag_name'		=> 'Cayman Islands',
					'flag_image'	=> 'KY.png',
				),
				array(
					'flag_name'		=> 'Central African Republic',
					'flag_image'	=> 'CF.png',
				),
				array(
					'flag_name'		=> 'Chad',
					'flag_image'	=> 'TD.png',
				),
				array(
					'flag_name'		=> 'Chile',
					'flag_image'	=> 'CL.png',
				),
				array(
					'flag_name'		=> 'China',
					'flag_image'	=> 'CN.png',
				),
				array(
					'flag_name'		=> 'Columbia',
					'flag_image'	=> 'CO.png',
				),
				array(
					'flag_name'		=> 'Comoros',
					'flag_image'	=> 'KM.png',
				),
				array(
					'flag_name'		=> 'Congo',
					'flag_image'	=> 'CG.png',
				),
				array(
					'flag_name'		=> 'Congo Democratic Republic',
					'flag_image'	=> 'CD.png',
				),
				array(
					'flag_name'		=> 'Costa Rica',
					'flag_image'	=> 'CR.png',
				),
				array(
					'flag_name'		=> 'Cote D-Ivoire',
					'flag_image'	=> 'CI.png',
				),
				array(
					'flag_name'		=> 'Croatia',
					'flag_image'	=> 'HR.png',
				),
				array(
					'flag_name'		=> 'Cuba',
					'flag_image'	=> 'CU.png',
				),
				array(
					'flag_name'		=> 'Cyprus',
					'flag_image'	=> 'CY.png',
				),
				array(
					'flag_name'		=> 'Czech Republic',
					'flag_image'	=> 'CZ.png',
				),
				array(
					'flag_name'		=> 'Denmark',
					'flag_image'	=> 'DK.png',
				),
				array(
					'flag_name'		=> 'Djibouti',
					'flag_image'	=> 'DJ.png',
				),
				array(
					'flag_name'		=> 'Dominica',
					'flag_image'	=> 'DM.png',
				),
				array(
					'flag_name'		=> 'Dominican Republic',
					'flag_image'	=> 'DO.png',
				),
				array(
					'flag_name'		=> 'East Timor',
					'flag_image'	=> 'TL.png',
				),
				array(
					'flag_name'		=> 'Ecuador',
					'flag_image'	=> 'EC.png',
				),
				array(
					'flag_name'		=> 'Egypt',
					'flag_image'	=> 'EG.png',
				),
				array(
					'flag_name'		=> 'El Salvador',
					'flag_image'	=> 'SV.png',
				),
				array(
					'flag_name'		=> 'Equatorial Guinea',
					'flag_image'	=> 'GQ.png',
				),
				array(
					'flag_name'		=> 'Eritrea',
					'flag_image'	=> 'ER.png',
				),
				array(
					'flag_name'		=> 'Estonia',
					'flag_image'	=> 'EE.png',
				),
				array(
					'flag_name'		=> 'Ethiopia',
					'flag_image'	=> 'ET.png',
				),
				array(
					'flag_name'		=> 'Falkland Islands',
					'flag_image'	=> 'FK.png',
				),
				array(
					'flag_name'		=> 'Faroe Islands',
					'flag_image'	=> 'FO.png',
				),
				array(
					'flag_name'		=> 'Fiji',
					'flag_image'	=> 'FJ.png',
				),
				array(
					'flag_name'		=> 'Finland',
					'flag_image'	=> 'FI.png',
				),
				array(
					'flag_name'		=> 'France',
					'flag_image'	=> 'FR.png',
				),
				array(
					'flag_name'		=> 'Gabon',
					'flag_image'	=> 'GA.png',
				),
				array(
					'flag_name'		=> 'Gambia',
					'flag_image'	=> 'GM.png',
				),
				array(
					'flag_name'		=> 'Georgia',
					'flag_image'	=> 'GE.png',
				),
				array(
					'flag_name'		=> 'Germany',
					'flag_image'	=> 'DE.png',
				),
				array(
					'flag_name'		=> 'Ghana',
					'flag_image'	=> 'GH.png',
				),
				array(
					'flag_name'		=> 'Great Britain',
					'flag_image'	=> 'GB.png',
				),
				array(
					'flag_name'		=> 'Greece',
					'flag_image'	=> 'GR.png',
				),
				array(
					'flag_name'		=> 'Greenland',
					'flag_image'	=> 'GL.png',
				),
				array(
					'flag_name'		=> 'Grenada',
					'flag_image'	=> 'GD.png',
				),
				array(
					'flag_name'		=> 'Guam',
					'flag_image'	=> 'GU.png',
				),
				array(
					'flag_name'		=> 'Guatemala',
					'flag_image'	=> 'GT.png',
				),
				array(
					'flag_name'		=> 'Guinea',
					'flag_image'	=> 'GN.png',
				),
				array(
					'flag_name'		=> 'Guinea Bissau',
					'flag_image'	=> 'GW.png',
				),
				array(
					'flag_name'		=> 'Guyana',
					'flag_image'	=> 'GY.png',
				),
				array(
					'flag_name'		=> 'Haiti',
					'flag_image'	=> 'HT.png',
				),
				array(
					'flag_name'		=> 'Honduras',
					'flag_image'	=> 'HN.png',
				),
				array(
					'flag_name'		=> 'Hong Kong',
					'flag_image'	=> 'HK.png',
				),
				array(
					'flag_name'		=> 'Hungary',
					'flag_image'	=> 'HU.png',
				),
				array(
					'flag_name'		=> 'Iceland',
					'flag_image'	=> 'IS.png',
				),
				array(
					'flag_name'		=> 'India',
					'flag_image'	=> 'IN.png',
				),
				array(
					'flag_name'		=> 'Indonesia',
					'flag_image'	=> 'ID.png',
				),
				array(
					'flag_name'		=> 'Iran',
					'flag_image'	=> 'IR.png',
				),
				array(
					'flag_name'		=> 'Iraq',
					'flag_image'	=> 'IQ.png',
				),
				array(
					'flag_name'		=> 'Ireland',
					'flag_image'	=> 'IE.png',
				),
				array(
					'flag_name'		=> 'Isle of Man',
					'flag_image'	=> 'IM.png',
				),
				array(
					'flag_name'		=> 'Israel',
					'flag_image'	=> 'IL.png',
				),
				array(
					'flag_name'		=> 'Italy',
					'flag_image'	=> 'IT.png',
				),
				array(
					'flag_name'		=> 'Jamaica',
					'flag_image'	=> 'JM.png',
				),
				array(
					'flag_name'		=> 'Japan',
					'flag_image'	=> 'JP.png',
				),
				array(
					'flag_name'		=> 'Jordan',
					'flag_image'	=> 'JO.png',
				),
				array(
					'flag_name'		=> 'Kazakhstan',
					'flag_image'	=> 'KZ.png',
				),
				array(
					'flag_name'		=> 'Kenya',
					'flag_image'	=> 'KE.png',
				),
				array(
					'flag_name'		=> 'Kiribati',
					'flag_image'	=> 'KI.png',
				),
				array(
					'flag_name'		=> 'Korea North',
					'flag_image'	=> 'NK.png',
				),
				array(
					'flag_name'		=> 'Korea South',
					'flag_image'	=> 'KS.png',
				),
				array(
					'flag_name'		=> 'Kuwait',
					'flag_image'	=> 'KW.png',
				),
				array(
					'flag_name'		=> 'Kyrgyzstan',
					'flag_image'	=> 'KG.png',
				),
				array(
					'flag_name'		=> 'Laos',
					'flag_image'	=> 'LA.png',
				),
				array(
					'flag_name'		=> 'Latvia',
					'flag_image'	=> 'LV.png',
				),
				array(
					'flag_name'		=> 'Lebanon',
					'flag_image'	=> 'LB.png',
				),
				array(
					'flag_name'		=> 'Lesotho',
					'flag_image'	=> 'LS.png',
				),
				array(
					'flag_name'		=> 'Liberia',
					'flag_image'	=> 'LR.png',
				),
				array(
					'flag_name'		=> 'Libya',
					'flag_image'	=> 'LY.png',
				),
				array(
					'flag_name'		=> 'Liechtenstein',
					'flag_image'	=> 'LI.png',
				),
				array(
					'flag_name'		=> 'Lithuania',
					'flag_image'	=> 'LT.png',
				),
				array(
					'flag_name'		=> 'Luxembourg',
					'flag_image'	=> 'LU.png',
				),
				array(
					'flag_name'		=> 'Macau',
					'flag_image'	=> 'MO.png',
				),
				array(
					'flag_name'		=> 'Macedonia',
					'flag_image'	=> 'MK.png',
				),
				array(
					'flag_name'		=> 'Madagascar',
					'flag_image'	=> 'MG.png',
				),
				array(
					'flag_name'		=> 'Malawi',
					'flag_image'	=> 'MW.png',
				),
				array(
					'flag_name'		=> 'Malaysia',
					'flag_image'	=> 'MY.png',
				),
				array(
					'flag_name'		=> 'Maldives',
					'flag_image'	=> 'MV.png',
				),
				array(
					'flag_name'		=> 'Mali',
					'flag_image'	=> 'ML.png',
				),
				array(
					'flag_name'		=> 'Malta',
					'flag_image'	=> 'MT.png',
				),
				array(
					'flag_name'		=> 'Marshall Islands',
					'flag_image'	=> 'MH.png',
				),
				array(
					'flag_name'		=> 'Mauritania',
					'flag_image'	=> 'MR.png',
				),
				array(
					'flag_name'		=> 'Mauritius',
					'flag_image'	=> 'MU.png',
				),
				array(
					'flag_name'		=> 'Mexico',
					'flag_image'	=> 'MX.png',
				),
				array(
					'flag_name'		=> 'Micronesia',
					'flag_image'	=> 'FM.png',
				),
				array(
					'flag_name'		=> 'Moldova',
					'flag_image'	=> 'MD.png',
				),
				array(
					'flag_name'		=> 'Monaco',
					'flag_image'	=> 'MC.png',
				),
				array(
					'flag_name'		=> 'Mongolia',
					'flag_image'	=> 'MN.png',
				),
				array(
					'flag_name'		=> 'Montserrat',
					'flag_image'	=> 'MS.png',
				),
				array(
					'flag_name'		=> 'Morocco',
					'flag_image'	=> 'MA.png',
				),
				array(
					'flag_name'		=> 'Mozambique',
					'flag_image'	=> 'MZ.png',
				),
				array(
					'flag_name'		=> 'Myanmar',
					'flag_image'	=> 'MM.png',
				),
				array(
					'flag_name'		=> 'Nambia',
					'flag_image'	=> 'NA.png',
				),
				array(
					'flag_name'		=> 'Nauru',
					'flag_image'	=> 'NR.png',
				),
				array(
					'flag_name'		=> 'Nepal',
					'flag_image'	=> 'NP.png',
				),
				array(
					'flag_name'		=> 'Netherland Antilles',
					'flag_image'	=> 'AN.png',
				),
				array(
					'flag_name'		=> 'Netherlands',
					'flag_image'	=> 'NL.png',
				),
				array(
					'flag_name'		=> 'New Zealand',
					'flag_image'	=> 'NZ.png',
				),
				array(
					'flag_name'		=> 'Nicaragua',
					'flag_image'	=> 'NI.png',
				),
				array(
					'flag_name'		=> 'Niger',
					'flag_image'	=> 'NE.png',
				),
				array(
					'flag_name'		=> 'Nigeria',
					'flag_image'	=> 'NG.png',
				),
				array(
					'flag_name'		=> 'Norfolk Island',
					'flag_image'	=> 'NF.png',
				),
				array(
					'flag_name'		=> 'Norway',
					'flag_image'	=> 'NO.png',
				),
				array(
					'flag_name'		=> 'Oman',
					'flag_image'	=> 'OM.png',
				),
				array(
					'flag_name'		=> 'Pakistan',
					'flag_image'	=> 'PK.png',
				),
				array(
					'flag_name'		=> 'Palau Island',
					'flag_image'	=> 'PW.png',
				),
				array(
					'flag_name'		=> 'Palestine',
					'flag_image'	=> 'PS.png',
				),
				array(
					'flag_name'		=> 'Panama',
					'flag_image'	=> 'PA.png',
				),
				array(
					'flag_name'		=> 'Papua New Guinea',
					'flag_image'	=> 'PG.png',
				),
				array(
					'flag_name'		=> 'Paraguay',
					'flag_image'	=> 'PY.png',
				),
				array(
					'flag_name'		=> 'Peru',
					'flag_image'	=> 'PE.png',
				),
				array(
					'flag_name'		=> 'Philippines',
					'flag_image'	=> 'PH.png',
				),
				array(
					'flag_name'		=> 'Pitcairn Island',
					'flag_image'	=> 'PN.png',
				),
				array(
					'flag_name'		=> 'Poland',
					'flag_image'	=> 'PL.png',
				),
				array(
					'flag_name'		=> 'Portugal',
					'flag_image'	=> 'PT.png',
				),
				array(
					'flag_name'		=> 'Puerto Rico',
					'flag_image'	=> 'PR.png',
				),
				array(
					'flag_name'		=> 'Qatar',
					'flag_image'	=> 'QA.png',
				),
				array(
					'flag_name'		=> 'Romania',
					'flag_image'	=> 'RO.png',
				),
				array(
					'flag_name'		=> 'Russia',
					'flag_image'	=> 'RU.png',
				),
				array(
					'flag_name'		=> 'Rwanda',
					'flag_image'	=> 'RW.png',
				),
				array(
					'flag_name'		=> 'Samoa',
					'flag_image'	=> 'WS.png',
				),
				array(
					'flag_name'		=> 'San Marino',
					'flag_image'	=> 'SM.png',
				),
				array(
					'flag_name'		=> 'Sao Tome &amp; Principe',
					'flag_image'	=> 'ST.png',
				),
				array(
					'flag_name'		=> 'Saudi Arabia',
					'flag_image'	=> 'SA.png',
				),
				array(
					'flag_name'		=> 'Senegal',
					'flag_image'	=> 'SN.png',
				),
				array(
					'flag_name'		=> 'Seychelles',
					'flag_image'	=> 'SC.png',
				),
				array(
					'flag_name'		=> 'Sierra Leone',
					'flag_image'	=> 'SL.png',
				),
				array(
					'flag_name'		=> 'Singapore',
					'flag_image'	=> 'SG.png',
				),
				array(
					'flag_name'		=> 'Slovakia',
					'flag_image'	=> 'SK.png',
				),
				array(
					'flag_name'		=> 'Slovenia',
					'flag_image'	=> 'SI.png',
				),
				array(
					'flag_name'		=> 'Solomon Islands',
					'flag_image'	=> 'SB.png',
				),
				array(
					'flag_name'		=> 'Somalia',
					'flag_image'	=> 'SO.png',
				),
				array(
					'flag_name'		=> 'South Africa',
					'flag_image'	=> 'ZA.png',
				),
				array(
					'flag_name'		=> 'Spain',
					'flag_image'	=> 'ES.png',
				),
				array(
					'flag_name'		=> 'Sri Lanka',
					'flag_image'	=> 'LK.png',
				),
				array(
					'flag_name'		=> 'St Helena',
					'flag_image'	=> 'SH.png',
				),
				array(
					'flag_name'		=> 'St Kitts-Nevis',
					'flag_image'	=> 'KN.png',
				),
				array(
					'flag_name'		=> 'St Lucia',
					'flag_image'	=> 'LC.png',
				),
				array(
					'flag_name'		=> 'St Vincent &amp; Grenadines',
					'flag_image'	=> 'VC.png',
				),
				array(
					'flag_name'		=> 'Sudan',
					'flag_image'	=> 'SD.png',
				),
				array(
					'flag_name'		=> 'Suriname',
					'flag_image'	=> 'SR.png',
				),
				array(
					'flag_name'		=> 'Swaziland',
					'flag_image'	=> 'SZ.png',
				),
				array(
					'flag_name'		=> 'Sweden',
					'flag_image'	=> 'SE.png',
				),
					array(
					'flag_name'		=> 'Switzerland',
					'flag_image'	=> 'CH.png',
				),
				array(
					'flag_name'		=> 'Syria',
					'flag_image'	=> 'SY.png',
				),
				array(
					'flag_name'		=> 'Taiwan',
					'flag_image'	=> 'TW.png',
				),
				array(
					'flag_name'		=> 'Tajikistan',
					'flag_image'	=> 'TJ.png',
				),
				array(
					'flag_name'		=> 'Tanzania',
					'flag_image'	=> 'TZ.png',
				),
				array(
					'flag_name'		=> 'Thailand',
					'flag_image'	=> 'TH.png',
				),
				array(
					'flag_name'		=> 'Togo',
					'flag_image'	=> 'TG.png',
				),
				array(
					'flag_name'		=> 'Tonga',
					'flag_image'	=> 'TO.png',
				),
				array(
					'flag_name'		=> 'Trinidad &amp; Tobago',
					'flag_image'	=> 'TT.png',
				),
				array(
					'flag_name'		=> 'Tunisia',
					'flag_image'	=> 'TN.png',
				),
				array(
					'flag_name'		=> 'Turkey',
					'flag_image'	=> 'TR.png',
				),
				array(
					'flag_name'		=> 'Turkmenistan',
					'flag_image'	=> 'TM.png',
				),
				array(
					'flag_name'		=> 'Turks &amp; Caicos Is',
					'flag_image'	=> 'TC.png',
				),
				array(
					'flag_name'		=> 'Tuvalu',
					'flag_image'	=> 'TV.png',
				),
				array(
					'flag_name'		=> 'Uganda',
					'flag_image'	=> 'UG.png',
				),
				array(
					'flag_name'		=> 'Ukraine',
					'flag_image'	=> 'UA.png',
				),
				array(
					'flag_name'		=> 'United Arab Emirates',
					'flag_image'	=> 'AE.png',
				),
				array(
					'flag_name'		=> 'United States of America',
					'flag_image'	=> 'US.png',
				),
				array(
					'flag_name'		=> 'Uruguay',
					'flag_image'	=> 'UY.png',
				),
				array(
					'flag_name'		=> 'Uzbekistan',
					'flag_image'	=> 'UZ.png',
				),
				array(
					'flag_name'		=> 'Vanuatu',
					'flag_image'	=> 'VU.png',
				),
				array(
					'flag_name'		=> 'Venezuela',
					'flag_image'	=> 'VE.png',
				),
				array(
					'flag_name'		=> 'Vietnam',
					'flag_image'	=> 'VN.png',
				),
				array(
					'flag_name'		=> 'Virgin Islands (Brit)',
					'flag_image'	=> 'VG.png',
				),
				array(
					'flag_name'		=> 'Virgin Islands (USA)',
					'flag_image'	=> 'VI.png',
				),
				array(
					'flag_name'		=> 'Wales',
					'flag_image'	=> 'WLS.png',
				),
				array(
					'flag_name'		=> 'Western Sahara',
					'flag_image'	=> 'EH.png',
				),
				array(
					'flag_name'		=> 'Yemen',
					'flag_image'	=> 'YE.png',
				),
				array(
					'flag_name'		=> 'Zambia',
					'flag_image'	=> 'ZM.png',
				),
				array(
					'flag_name'		=> 'Zimbabwe',
					'flag_image'	=> 'ZW.png',
				),
			); 
			/**/

			$ary = array(
				'flag_id'			=> $flag_id,
				'flag_name'		=> strtoupper(str_replace(array(" ","_"), "_", $country_name)), //lang_name
				'flag_image'		=> $flag
			);
			
			if ($db_tools->sql_table_exists(FLAG_TABLE) && !$mx_request_vars->is_request('add_table'))
			{
				$sql_flags = 'INSERT INTO ' . FLAG_TABLE . ' ' . $db->sql_build_array('INSERT', $ary);
				print('<div><span style="color: red;">This flags are now added to the country flags DB table..</div>');
				print($sql_flags . "</br>");
				$db->sql_query($sql_flags);
			}
			elseif ($mx_request_vars->is_request('add_flags'))
			{
				$result = $db->sql_query($sql_flags);
				if (!($result))
				{
					mx_message_die(CRITICAL_ERROR, "Could not add flags table to the DB", '', __LINE__, __FILE__, print_r($sql_ary, true));
				}
				
				$message = $lang['Virtual_Go'] . "<br /><br />" . sprintf($lang['Click_return_flagadmin'], "<a href=\"" . mx_append_sid("admin_country_flags.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . mx_append_sid($phpbb_root_path . "admin/index.$phpEx?pane=right") . "\">", "</a>");
				mx_message_die(GENERAL_MESSAGE, $message);
			}
			elseif ($mx_request_vars->is_request('add_table') && !$db_tools->sql_table_exists(FLAG_TABLE))
			{
				//$sql = "DROP TABLE " . $table_prefix . "flags";
				$sql = "CREATE TABLE " . FLAG_TABLE . " (
					flag_id int(10) NOT NULL auto_increment,
					flag_name varchar(25) default NULL,
					flag_image varchar(25) default NULL,
					PRIMARY KEY (flag_id)
				)";

				// We could add error handling here...
				$result = $db->sql_query($sql);
				if (!($result))
				{
					mx_message_die(CRITICAL_ERROR, "Could not add flags table to the DB", '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_block_vars("flags", array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,
				"FLAG" => isset($lang[$country_name]) ? $lang[$country_name] : $country_name,
				"IMAGE_DISPLAY" => ($flag) ? '<img title="' . $country_name . '" alt="' . $displayname . '" src="' . $flag_dir . $flag . '" />' : "",

				"U_FLAG_EDIT" => mx_append_sid("admin_country_flags.$phpEx?mode=edit&amp;id=$flag_id"),
				"U_FLAG_DELETE" => mx_append_sid("admin_country_flags.$phpEx?mode=delete&amp;id=$flag_id"))
			);
			$flag_id++;
		}
		
		if ($db_tools->sql_table_exists(FLAG_TABLE))
		{
			$redirect_url = mx_append_sid("admin_country_flags.$phpEx?add_flags=add_lang_flags", true);
			$message_info = '<div><span style="color: red;">Your flags are not added to the country flags DB table and so You will not be able to enable all features that come in this pannel...</div><i><div>Adding the flags to the is reversible from this pannel! You will be able to edit or remove each flag. If you are aware of that, please click this link to proceed:</i></span> <a href="' . $redirect_url . '">click here to begin</a></div>'; 
			print($message_info);
		}
		else
		{
			$redirect_url = mx_append_sid("admin_country_flags.$phpEx?add_table=create_table", true);
			$message_info = '<div><span style="color: red;">Your flags table is not added to the DB and so You will not be able to enable all features that come in this pannel...</div><i><div>Adding the table is not reversible from this pannel! If you are aware of that, please click this link to proceed:</i></span> <a href="' . $redirect_url . '">click here to begin</a></div>'; 
			print($message_info);
		}
	}
}

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
