<?php
/**
 * Language file [lang_admin.php]
 * 
 * @package language
 * @author admin
 * @version d: lang_admin.php,v 1.0 2018/03/30 03:21:25 admin Exp $
 * @copyright (c) phpBB Limited <https://www.phpbb.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
 * @link http://www.phpbb.com
 * Encoding: UTF-8
 * 1 tab = 4 spaces
 */

if ( !isset($lang) )
{
	$lang = array();
}
//
// Parameter Types
//
$lang = array_merge( $lang, array( // #
	'ParType_phpBBTextBlock'			=> 'Standard phpBB TextBlock',
	'ParType_phpBBTextBlock_info'		=> 'Aceasta	este un Standard phpBB TextBlock, parsare bbcodes, html och smilies așa cum este definit de setările phpBB Config.',
	'ParType_CustomizedTextBlock'		=> 'TextBlock Personalizat',
	'ParType_CustomizedTextBlock_info'	=> 'Acesta este un TextBlock Personalizat, parsare bbcodes, html och smilies așa cum este definit de această setările de bloc',
	'ParType_WysiwygTextBlock'			=> 'Wysiwyg TextBlock',
	'ParType_WysiwygTextBlock_info'		=> 'Acesta este un Wysiwyg TextBlock, care conține un editor html',
//
// Parameter Names
//
	'block_style'						=> 'Margine Block:',
	'title_style'						=> 'Titlu Stil Antet:',
	'allow_bbcode'						=> 'Permite BBCodes:',
	'allow_html'						=> 'Permite Html:',
	'allow_smilies'						=> 'Permite Zâmbetele:',
	'html_tags'							=> 'Etichete Html permise:',
	
	'block_style_explain'				=> 'Afișați marginea în jurul textului:',
	'title_style_explain'				=> 'Utilizați stil CSS pentru rândul de titlu:',
));

//
// That's all Folks!
// -------------------------------------------------
?>