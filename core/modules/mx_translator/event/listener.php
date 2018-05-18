<?php
/**
*
* @package phpBB Extension - Google translator
* @copyright (c) 2018 orynider
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace orynider\mx_translator\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'   => 'load_language_on_setup',
			'core.page_header_after'  => 'navbar_header_after',
		);
	}

	protected $template;
	protected $config;

	public function __construct(\phpbb\template\template $template, \phpbb\config\config $config)
	{
		$this->template = $template;
		$this->config = $config;
	}
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
		'ext_name' => 'orynider/mx_translator',
		'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	public function navbar_header_after($event)
	{
		$this->template->assign_vars(array(
		'TRANSLATOR_DEFAULT_LANG'	=> (isset ($this->config['translator_default_lang'])) ? $this->config['translator_default_lang'] : '',
		'TRANSLATOR_CHOICE_LANG'		=> (isset ($this->config['translator_choice_lang'])) ? $this->config['translator_choice_lang'] : '',
        ));
    }
}