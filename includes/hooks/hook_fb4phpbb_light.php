<?php
/**
* @package Facebook For PhpBB Light
* @copyright (c) 2012 Damien Keitel
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

//Don't load hook if not installed.
if (empty($config['fb4phpbb_light_version']))
{
	return;
}

/**
 * A hook that is used to change the behavior of phpBB just before the templates
 * are displayed.
 * @param	phpbb_hook	$hook	the phpBB hook object
 * @return	void
 */
function facebook_for_phpbb_light_template_hook(&$hook)
{
	global $db, $config, $user, $template, $phpEx, $phpbb_root_path, $cache;
    if (!function_exists('fb4phpbb_light_init'))
    {
        include($phpbb_root_path . 'includes/functions_fb4phpbb_light.' . $phpEx);
    }
	if ((!empty($config['fb4phpbb_light_appid'])) && (!empty($config['fb4phpbb_light_secret'])))
	{
		$template->assign_vars(array(
            'HAS_JQUERY'    => find_jquery(),
            'HAS_JQUERY_UI'    => find_jquery_ui(), 		
            'FB4PHPBB_LIGHT_XMLNS' => 'xmlns:fb="http://ogp.me/ns/fb#"',
            'FB4PHPBB_LIGHT_INIT'   => fb4phpbb_light_init($config['fb4phpbb_light_appid'], $config['fb4phpbb_light_lang']),
            'S_FB4PHPBB_MOD_ENABLED' => ($config['fb4phpbb_light_mod_enabled'] == 'yes') ? true : false, 
            'FB4PHPBB_LIGHT_CONNECT'    => generate_board_url() . '/fb4phpbb_light/fb4phpbb_light_connect.' . $phpEx,
            ));
	}
}

if (!$config['board_disable'])
{
	$phpbb_hook->register(array('template','display'), 'facebook_for_phpbb_light_template_hook');
}
