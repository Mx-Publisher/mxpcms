<?php
/**
*
* @package phpBB Extension - Google Translator
* @copyright (c) 2018 orynider
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace orynider\mx_translator\acp;

class translator_info
{
	function module()
	{
		return array(
		'filename'	=> '\orynider\mx_translator\acp\translator_module',
		'title'	=> 'ACP_TRANSLATOR',
			'modes'	=> array(
				'config'	=> array(
					'title'	=> 'ACP_TRANSLATOR_CONFIG', 
					'auth'	=> 'ext_orynider/mx_translator && acl_a_board', 
					'cat'	=> array('ACP_TRANSLATOR')
				),
				'MXP'	=> array(
					'title'	=> 'ACP_TRANSLATE_MX_PORTAL',
					'auth'	=> 'ext_orynider/mx_translator && acl_a_board',
					'cat'	=> array('ACP_TRANSLATOR')
				),
				'MODS'	=> array(
					'title'	=> 'ACP_TRANSLATE_MX_MODULES',
					'auth'	=> 'ext_orynider/mx_translator && acl_a_board',
					'cat'	=> array('ACP_TRANSLATOR')
				),
				'PHPBB'	=> array(
					'title'	=> 'ACP_TRANSLATE_PHPBB_LANG',
					'auth'	=> 'ext_orynider/mx_translator && acl_a_board',
					'cat'	=> array('ACP_TRANSLATOR')
				),				
				'phpbb_ext'	=> array(
					'title'	=> 'ACP_TRANSLATE_PHPBB_EXT',
					'auth'	=> 'ext_orynider/mx_translator && acl_a_board',
					'cat'	=> array('ACP_TRANSLATOR')
				),				
			),
		);
	}
}
