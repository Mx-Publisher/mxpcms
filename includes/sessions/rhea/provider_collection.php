<?php
/**
*
* @package Auth
*
* @copyright (c) 2002-2024 MX-Publisher Project Team
* @license GNU General Public License, version 2 (GPL-2.0)
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if (!defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

/**
* Collection of auth providers to be configured at container compile time.
*/
class provider_collection extends \phpbb\di\service_collection
{
	/** @var \phpbb\config\config phpBB3 Config */
	protected $config;

	/**
	* Constructor
	*
	* @param ContainerInterface $container Container object
	* @param \phpbb\config\config $config phpBB3 config
	*/
	public function provider_collection()
	{
		global $board_config;
		$this->config = $board_config;
	}

	/**
	* Get an auth provider.
	*
	* @param string $provider_name The name of the auth provider
	* @return object	Default auth provider selected in config if it
	*			does exist. Otherwise the standard db auth
	*			provider.
	*/
	public function get_provider($provider_name = '')
	{
		$provider_name = ($provider_name !== '') ? $provider_name : basename(trim($this->config['auth_method']));
		
		return $provider_name;
	}
}
