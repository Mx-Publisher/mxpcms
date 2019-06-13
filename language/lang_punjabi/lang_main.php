<?php
/**
 * Language file [lang_main.php]
 * 
 * @package language
 * @author admin
 * @version $Id: lang_main.php,v 1.0 2018/09/20 03:52:09 admin Exp $
 * @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
 * @link http://mxpcms.sourceforge.net/
 * Encoding: UTF-8
 * 1 tab = 4 spaces
 */

if ( !isset($lang) )
{
	$lang = array();
}

$lang = array_merge( $lang, array( // #
	'USER_LANG'						=> 'pa',
	'ENCODING'						=> 'UTF-8',
	'DIRECTION'						=> 'ltr',
	'LEFT'							=> 'ਖੱਬੇ',
	'RIGHT'							=> 'ਸੱਜੇ',
	'DATE_FORMAT'						=> 'd/M/Y',
	'Page_Not_Authorised'				=> 'ਅਫਸੋਸ ਹੈ,	ਪਰ	ਤੁਸੀਂ				 ਇਹ	ਪੰਨੇ ਤੇ ਅਧਿਕ੍ਰਿਤ ਨਹੀਂ',
	'Execution_Stats'					=> 'ਸਫ਼ਾ ਤਿਆਰ%s ਸਵਾਲ - ਬਣਾਉਣ ਸਮਾਂ:%s ਸਕਿੰਟ',
	'Redirect_login'					=> 'ਲਾਗਇਨ ਕਰਨ ਲਈ %ਇੱਥੇ% ਕਲਿੱਕ ਕਰੋ ਤੇ ਕਲਿਕ ਕਰੋ',
	'Show_admin_options'				=> 'ਪੰਨਾ ਵਿਵਸਥਾਂਵਾਂ ਵੇਖੋ / ਓਹਲੇ ਕਰੋ:',
	'Block_updated_date'				=> 'ਅੱਪਡੇਟ ਕੀਤਾ',
	'Block_updated_by'				=> 'ਨਾਲ',
	'Page_updated_date'				=> 'ਇਹ ਸਫ਼ਾ ਅਪਡੇਟ ਕੀਤਾ ਗਿਆ ਸੀ',
	'Page_updated_by'					=> 'ਨਾਲ',
	'Powered_by'						=> 'ਦੁਆਰਾ ਸੰਚਾਲਿਤ',
	'mx_spacer'						=> 'ਸਪੈਸਰ',
	'Yes'								=> 'ਹਾਂ',
	'No'								=> 'ਨਹੀਂ',
	'Link'							=> 'ਲਿੰਕ',
	'Hidden_block'					=> 'ਓਹਲੇ ਬਲਾਕ',
	'Hidden_block_explain'			=> 'ਇਹ	ਬਲਾਕ		27 ਲੁਕਿਆ ਹੋਇਆ \'%2 ਸੀ	ਅਤੇ	ਸਹੀ	ਅਨੁਮਤੀਆਂ	ਸੈਟ ਕਰਦੇ ਹੋਏ	ਸੈੱਟ ਕੀਤੇ ਹਨ.',
	'MX_home'							=> 'ਘਰ',
	'MX_forum'						=> 'ਫੋਰਮ',
	'MX_navigation'					=> 'ਪੰਨੇ	ਨੇਵੀਗੇਸ਼ਨ%2 ਸੀ	ਉਦਾਹਰਣ.	ਫੋਰਮ	ਨੇਵੀਗੇਸ਼ਨ%2 ਸੀ	ਜਿਵੇਂ	ਪਫਿਲਡ	ਨੈਵੀਗੇਸ਼ਨ.',
	'Change_default_lang'				=> 'ਬੋਰਡ ਦੀ ਡਿਫਾਲਟ ਭਾਸ਼ਾ ਸੈੱਟ ਕਰੋ',
	'Change_user_lang'				=> 'ਆਪਣੀ ਭਾਸ਼ਾ ਸੈਟ ਕਰੋ',
	'Portal_lang'						=> 'ਭਾਸ਼ਾ ਕੰਟਰੋਲ ਪੈਨਲ',
	'Select_lang'						=> 'ਭਾਸ਼ਾ ਚੁਣੋ:',
	'Change'							=> 'ਹੁਣੇ ਬਦਲੋ',
	'Change_default_style'			=> 'ਬੋਰਡ ਦੀ ਮੂਲ ਸ਼ੈਲੀ ਸੈਟ ਕਰੋ',
	'Change_user_style'				=> 'ਆਪਣੀ ਸ਼ੈਲੀ ਸੈੱਟ ਕਰੋ',
	'Theme'							=> 'ਥੀਮਸੀਪੀ / ਸਟੈਲੀਪ',
	'Select_theme'					=> 'ਥੀਮ / ਸਟਾਇਲ ਦੀ ਚੋਣ ਕਰੋ:',
	'Mx_Page'							=> 'ਪੰਨਾ',
	'Mx_Block'						=> 'ਅਨੁਭਾਗ',
	'Virtual_Create_new'				=> 'ਨਵਾਂ ਬਣਾਓ',
	'Virtual_Create_new_user'			=> 'ਯੂਜ਼ਰ ਪੰਨਾ',
	'Virtual_Create_new_group'		=> 'ਗਰੁੱਪ ਪੇਜ',
	'Virtual_Create_new_project'		=> 'ਪ੍ਰੋਜੈਕਟ ਪੇਜ',
	'Virtual_Create'					=> 'ਹੁਣੇ ਬਣਾਉ',
	'Virtual_Edit'					=> 'ਸਫ਼ਾ ਦਾ ਨਾਮ ਅਪਡੇਟ ਕਰੋ',
	'Virtual_Delete'					=> 'ਇਸ ਪੰਨੇ ਨੂੰ ਮਿਟਾਓ',
	'Virtual_Welcome'					=> 'ਸੁਆਗਤ ਹੈ',
	'Virtual_Info'					=> 'ਇੱਥੇ ਤੁਸੀਂ	ਤੁਹਾਡੀ	ਪ੍ਰਾਈਵੇਟ	ਵੈੱਬ	ਪੰਨੇ ਨੂੰ	ਕੰਟਰੋਲ ਕਰ ਸਕਦੇ ਹੋ.',
	'Virtual_CP'						=> 'ਪੰਨਾ ਕੰਟਰੋਲ ਪੈਨਲ',
	'Virtual_Go'						=> 'ਜਾਣਾ',
	'Virtual_Select'					=> 'ਚੁਣੋ:',
	'No_items_found'					=> 'ਕੁਝ	ਨਵਾਂ	ਰਿਪੋਰਟ	ਨਹੀਂ',
	'Block_Title'						=> 'ਟਾਈਟਲ',
	'Block_Info'						=> 'ਜਾਣਕਾਰੀ',
	'Block_Config_updated'			=> 'ਬਲਾਕ	ਸੰਰਚਨਾ	ਸਫਲਤਾਪੂਰਵਕ	ਅਪਡੇਟ ਕੀਤੀ.',
	'Edit'							=> 'ਸੰਪਾਦਿਤ ਕਰੋ',
	'Block_Edit'						=> 'ਬਲਾਕ ਸੰਪਾਦਿਤ ਕਰੋ',
	'Block_Edit_dyn'					=> 'ਮਾੜੀ ਡਾਇਨੈਮਿਕ ਬਲਾਕ ਸੰਪਾਦਿਤ ਕਰੋ',
	'Block_Edit_sub'					=> 'ਮਾਤਾ ਸਪੀਿਟ ਬਲਾਕ ਸੰਪਾਦਿਤ ਕਰੋ',
	'General_updated_return_settings'	=> 'ਸੰਰਚਨਾ	ਅੱਪਡੇਟ	ਸਫਲਤਾਪੂਰਵਕ.<br	/><br	/>lick	%shere%s	to	ਜਾਰੀ.',
	'General_update_error'			=> 'ਅਪਡੇਟ ਨਹੀਂ ਕਰ ਸਕਿਆ	ਸੰਰਚਨਾ ਨਹੀਂ ਕਰ ਸਕਿਆ.',
	'Mx_search_site'					=> 'ਸਾਈਟ',
	'Mx_search_forum'					=> 'ਫੋਰਮ',
	'Mx_search_kb'					=> 'ਲੇਖ',
	'Mx_search_pafiledb'				=> 'ਡਾਊਨਲੋਡ',
	'Mx_search_google'				=> 'ਗੂਗਲ',
	'Mx_new_search'					=> 'ਨਵੀਂ ਖੋਜ',
	'mx_about_title'					=> 'ਐਮਐਕਸ-ਪਬਿਲਸ਼ਰ ਬਾਰੇ',
	'mx_copy_title'					=> 'ਐਮਐਕਸ-ਪ੍ਰਕਾਸ਼ਕ ਜਾਣਕਾਰੀ',
	'mx_copy_modules_title'			=> 'ਇੰਸਟਾਲ ਕੀਤੇ ਐਮਐਕਸ-ਪਬਿਲਸ਼ਰ ਮੋਡੀਊਲ',
	'mx_copy_template_title'			=> 'ਸ਼ੈਲੀ ਬਾਰੇ',
	'mx_copy_translation_title'		=> 'ਅਨੁਵਾਦ ਬਾਰੇ',
	'TRANSLATION_INFO_MXBB'			=> '">ਇੰਗਲਿਸ਼	ਭਾਸ਼ਾ	 3 ਕੇ	href="http://mxpcms.sourceforge.net/"	ਟਾਰਗਿਟ="_ਬੈਂਕ"%3 ਈਐਮਐਕਸ-ਪਕਾਸ਼ਕਾਰ	ਵਿਕਾਸ	ਟੀਮ</a>',
	'Please_remove_install_contrib'	=> 'ਕਿਰਪਾ ਕਰ ਕੇ ਯਕੀਨੀ ਬਣਾਓ	ਦੋਨਾਂ	ਨੂੰ ਇੰਸਟਾਲ/	ਅਤੇ	contrib/	ਡਾਇਰੈਕਟਰੀਆਂ	ਨੂੰ	ਮਿਟਾ ਦਿੱਤਾ ਗਿਆ ਹੈ.',
));

//
// That's all Folks!
// -------------------------------------------------
?>