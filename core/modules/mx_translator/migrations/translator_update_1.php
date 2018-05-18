<?php
/**
*
* @package phpBB Extension - Google Translator
* @copyright (c) 2015 orynider
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace orynider\mx_translator\migrations;

class translator_update_1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\orynider\mx_translator\migrations\translator_data');
	}

	public function update_data()
	{
		return array(
		// Remove configs
		array('config.remove', array('translator_version', '')),
		);
	}
}
