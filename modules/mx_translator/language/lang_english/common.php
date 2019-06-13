<?php
/**
*
* @package phpBB Extension - Translator
* @copyright (c) 2018 orynider
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_TRANSLATOR_CONFIG_EXPLAIN'		=> 'This is configuration page for the phpBB Translator extension. ',

	'ACP_TRANSLATOR_CONFIG_SET'			=> 'Configuration',
	'TRANSLATOR_CONFIG_SAVED'			=> 'Translator settings saved',

	'TRANSLATOR_DEFAULT_LANG'			=> 'Board Language',
	'TRANSLATOR_DEFAULT_LANG_EXPLAIN'	=> 'Enter the code for the Default Language for your Board',

	'TRANSLATOR_CHOICE_LANG'			=> 'Translations',
	'TRANSLATOR_CHOICE_LANG_EXPLAIN'	=> 'Enter the codes of the languages you want to have available seperated by a comma for example de,fr,es,ro',
));
?>