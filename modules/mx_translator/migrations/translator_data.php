<?php
/**
*
* @package phpBB Extension - Google Translator
* @copyright (c) 2018 orynider
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace orynider\mx_translator\migrations;

class translator_data extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
		'\phpbb\db\migration\data\v31x\v314'
		);
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('translator_default_lang', 'en')),
			array('config.add', array('translator_choice_lang', 'fr,es,ro,it')),
			array('config.add', array('translator_version', '1.0.0')),
			
			// Add module
			array('module.add', array(
				'acp', 
				'ACP_CAT_DOT_MODS', 
				'ACP_TRANSLATOR',
				array(
					'module_enabled'  => 1,
					'module_display'  => 1,
					'module_langname' => 'ACP_TRANSLATOR',
					'module_auth'     => 'ext_orynider/mx_translator && acl_a_board',
				)				
			)),
			array('module.add', array(
				'acp', 
				'ACP_TRANSLATOR',
				array(
					'module_basename' => '\orynider\mx_translator\acp\translator_module',
					'modes'           => array('config', 'MXP', 'MODS', 'PHPBB', 'phpbb_ext'),
				)							
			)),
		);
	}
}
