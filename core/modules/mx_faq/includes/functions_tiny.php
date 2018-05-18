<?
/***************************************************************************
 *                            function_tiny.php
 *                            -------------------
 *   begin                : Oct 1, 2006
 *   copyright         : (C) 2006 Selven
 *   email                : N/A
 *
 *   $Id: functions_tiny.php,v 1.4 2008/02/01 04:21:24 orynider Exp $
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
 *
 ***************************************************************************/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

// 
// This switch is for enabling the wysiwyg html editor addon "tiny mce"
// 
if ( file_exists( $tiny_path . 'blank.htm' ) )
{
	//
	//Definining language convertor array (phpbb use extended name tinyMCE use international code)
	//
	$convert = array( 
					'arabic'						=> 'ar', 
					'bulgarian'              		=> 'bg', 
					'catalan'						=> 'ca', 
					'czech'							=> 'cs', 
					'danish'						=> 'da', 
					'german'						=> 'de', 
					'english'						=> 'en', 
					'estonian'						=> 'et', 
					'finnish'						=> 'fi', 
					'french'						=> 'fr', 
					'greek'							=> 'el', 
					'spanish'						=> 'es', 
					'gaelic'						=> 'gd', 
					'galego'						=> 'gl', 
					'gujarati'						=> 'gu', 
					'hebrew'						=> 'he', 
					'hindi'							=> 'hi', 
					'croatian'						=> 'hr', 
					'hungarian'						=> 'hu', 
					'icelandic'						=> 'is', 
					'indonesian'					=> 'id', 
					'italian'						=> 'it', 
					'japanese'						=> 'ja', 
					'korean'						=> 'ko', 
					'latvian'						=> 'lv', 
					'lithuanian'					=> 'lt', 
					'macedonian'					=> 'mk', 
					'dutch'							=> 'nl', 
					'norwegian'						=> 'no', 
					'punjabi'						=> 'pa', 
					'polish'						=> 'pl', 
					'portuguese'					=> 'pt', 
					'romanian'						=> 'ro', 
					'russian'						=> 'ru', 
					'slovenian'						=> 'sl', 
					'albanian'						=> 'sq', 
					'serbian'						=> 'sr', 
					'slovak'						=> 'sv', 
					'swedish'						=> 'sv', 
					'thai'							=> 'th', 
					'turkish'						=> 'tr', 
					'ukranian'						=> 'uk', 
					'urdu'   						=> 'ur', 
					'viatnamese'					=> 'vi', 
					'chinese_simplified'			=> 'zh', 
					); 
	//
	//Checking if language files are installed into tinyMCE
	//
	$user_lang = $userdata['user_lang']; 
	if ( !file_exists( $tiny_path . 'langs/' . $convert[$user_lang] . '.js' ) ) 
		{ 
			$user_lang = $board_config['default_lang']; 
			if ( !file_exists( $tiny_path . 'langs/' . $convert[$user_lang] . '.js' ) ) 
				{ 
					$user_lang = 'english'; 
				}  
		} 
	//
	//Converting the found language for using in template
	//
	$tiny_lang = $convert[$user_lang];
	
	//
	//checking what tinyMCE we want to use
	//
	if($board_config['gzip_compress'] == '1' & file_exists($tiny_path . 'tiny_mce_gzip.' . $phpEx))
	{
		$tiny_script = $tiny_path . 'tiny_mce_gzip.' . $phpEx;
	}
	else
	{
		$tiny_script = $tiny_path . 'tiny_mce.js';
	}
	
	$template->assign_block_vars( "tinyMCE", array(
					'SCRIPT'	=> $tiny_script,
					'LANG'		=> $tiny_lang,
					'TEMPLATE' => $phpbb_root_path . 'templates/'. $theme['template_name'] . '/' . $theme['head_stylesheet']
					));
}
?>