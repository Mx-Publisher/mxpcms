<?php
/**
 * Language file [info_acp_translator.php]
 * 
 * @package language
 * @author Culprit
 * @version : info_acp_translator.php,v 1.5 2008/02/27 16:12:56 Culprit Exp $
 * @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
 * @link http://www.mxpcms.sourceforge.net
 * Encoding: UTF-8
 * 1 tab = 4 spaces
 */
 
/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
/**
* LANG 
 */
$lang = array_merge($lang, array( // #
	/**
	 * LANG 
	 */
	'LANGUAGES_TOOLS'				=> 'Language tools',
	'ACP_MX_LANGTOOLS_TITLE'		=> 'Language tools Extended',
	
	'MX_Module_2_Translate'			=> 'Translator',

	'MX_Module_1_Block_Titles'		=> 'Block Titles',
	'MX_Module_3_Page_Names'		=> 'Page Names',	
	
	'TRANSLATE_DESCRIPTION'			=> 'Here you are able to change existing language pack entries or not already translated ones.<br/><b>Note:</b> you need to have JavaScript and cookies enabled in your browser',
	/**
	 * LANG SELECT & FILE SELECT
	 */
	'WHAT_TRANSLATE'				=> 'What will be translated',
	'LANGUAGE_SELECT'				=> 'Language select',
	'LANGUAGE_FROM'					=> 'From language',
	'LANGUAGE_INTO'					=> 'Into language',
	'FILE_SELECT'					=> 'Select file to translate',
	/**
	*Translate Control Panel
	*/
	'Trans_title'				=> 'Translate to your Language',
	'Trans_description'			=> 'Use Translate Control Panel to translate portal to your language<br/>ljsdflgjdlkgjdslkgjsdlkg',
	'Trans_which_core'			=> 'Which Part',
	'Trans_select_file'			=> 'Select file to translate',
	'Trans_from_desc'			=> 'Default language to translate from',
	'Trans_leave_orig'			=> 'If not translated <b>leave original</b> text',
	'Trans_selected_file'		=> 'Selected File',
	'Trans_lang_source'			=> 'Source Language',
	'Trans_lang_dest'			=> 'Destination Language',
	'Trans_lang_block'			=> 'Language block',
	'Trans_save_file'			=> 'Save language file',
	'Trans_preview_file'		=> 'Preview language file',
	/**
	* Multilingual Block Titles
	*/
	'Trans_MultiLingual'		=> 'Multilingual %s Control Panel',
	'Trans_Language'			=> 'Language',
	'Trans2_description'		=> 'Use Multilingual Control Panel to make your %s for all languages',
	'Trans_blockTitle'			=> 'Block Titles',
	'Trans_pageTitle'			=> 'Page Names',
	'Trans_save_single'			=> 'Save this language',
	'Trans_save_all'			=> 'Save all languages',
	/**
	 * TRANSLATE
	 */
	'TRANSLATE'						=> 'Language entries',
	'TRANSLATE_KEY'					=> 'Language key',
	'TRANSLATE_VALUE'				=> 'Language variable',
	'FILE'							=> 'File',
	'FILE_IS_WRITABLE'				=> 'writable',
	'FILE_IS_UNWRITABLE'			=> 'unwritable',
	'FILE_CHARSET'					=> 'encoding',

	'SAVE'							=> 'Save',
	/**
	 * LANG 
	 */
	'ACP_TRANSLATOR'				=> 'Translator',
	'ACP_TRANSLATOR_CONFIG'			=> 'Translator Settings',

	'ACP_TRANSLATE_MX_PORTAL'		=> 'MXP Core',
	'ACP_TRANSLATE_MX_MODULES'		=> 'MXP Modules',
	'ACP_TRANSLATE_PHPBB_LANG'		=> 'PHPBB Core',
	'ACP_TRANSLATE_PHPBB_EXT'		=> 'PHPBB EXT',

	
	'ACP_MX_LANGTOOLS_SETTINGS'		=> 'Language tools settings',
	'LOG_MX_LANGTOOLS_CHECK_FAIL'	=> '<strong>Language tools settings could not be verified with phpBB.com</strong><br />» %s',
	/**
	 * Settings page 
	 */	
	'ACP_TRANSLATOR_SETTINGS_EXPLAIN'	=> 'Here you can configure the main settings for Translator Base.',
	'ACP_TRANSLATOR_ENABLE'				=> 'Enable Translator Base',
	'ACP_TRANSLATOR_SETTINGS_LOG'		=> 'Language tools settings chaged',
	'ACP_TRANSLATOR_HEADER_LINK'		=> 'Display Translator Base link in the header',
	'ACP_TRANSLATOR_SETTINGS_CHANGED'	=> 'Translator Base settings changed.',	
	/**
	 * LANG SELECT & FILE SELECT
	 */	
	'ACP_TRANSLATOR_CONFIG_EXPLAIN'		=> 'This is configuration page for the phpBB Translator extension. ',

	'ACP_TRANSLATOR_CONFIG_SET'			=> 'Configuration',
	'TRANSLATOR_CONFIG_SAVED'			=> 'Translator settings saved',
	
	'CLICK_RETURN_CONFIG_INDEX'			=> 'Click %sHere%s to return to the Module Configuration Index',
	'CLICK_RETURN_ADMIN_INDEX'			=> 'Click %sHere%s to return to the Admin Index',
	
	'TRANSLATOR_DEFAULT_LANG'			=> 'Board Language',
	'TRANSLATOR_DEFAULT_LANG_EXPLAIN'	=> 'Enter the code for the Default Language for your Board',

	'TRANSLATOR_CHOICE_LANG'			=> 'Translations',
	'TRANSLATOR_CHOICE_LANG_EXPLAIN'	=> 'Enter the codes of the languages you want to have available seperated by a comma for example de,fr,es,ro',
));
/*
* That's all Folks!
* / -------------------------------------------------*/
?>