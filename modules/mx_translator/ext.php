<?php
/**
 *
 * Knowledge Base extension for the phpBB Forum Software package
 *
 * @copyright (c) 2018, orynider, https://mxpcms.sourceforge.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace orynider\mx_translator;

/**
 * Knowledge Base Extension base
 */
class ext extends \phpbb\extension\base
{
	/**
	 * Check whether or not the extension can be enabled.
	 * The current phpBB version should meet or exceed
	 * the minimum version required by this extension:
	 *
	 * Requires phpBB 3.2.0 and PHP 5.4.0.
	 *
	 * @return bool
	 * @access public
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');

		return phpbb_version_compare($config['version'], '3.2.0', '>=') && version_compare(PHP_VERSION, '5.4.0', '>=');
	}

	/**
	 * Check mx_publisher switches and set them during install
	 *
	 * @param	mixed	$old_state	The return value of the previous call
	 *								of this method, or false on the first call
	 *
	 * @return	mixed				Returns false after last step, otherwise
	 *								temporary state which is passed as an
	 *								argument to the next step
	 */
	public function enable_step($old_state)
	{
		/*
		if ($old_state === false)
		{
			$mx_translator_helper = new \orynider\mx_translator\acp\translator_helper (
				$this->container->get('cache.driver'),
				$this->container->get('config'),
				$this->container->get('file_downloader'),
				$this->container->get('language'),
				$this->container->get('log'),
				$this->container->get('user')
			);

			try
			{
				$mx_translator_helper->set_mx_translator_services();
			}
			catch (\RuntimeException $e)
			{
				$mx_translator_helper->log_mx_translator_error($e->getMessage());
			}

			return 'mx_translator';
		}
		*/
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('orynider.mx_translator.notification.type.langfile_in_queue');
				$phpbb_notifications->enable_notifications('orynider.mx_translator.notification.type.approve_langfile');
				$phpbb_notifications->enable_notifications('orynider.mx_translator.notification.type.delete_langfile');
				$phpbb_notifications->enable_notifications('orynider.mx_translator.notification.type.deny_langfile');
				$phpbb_notifications->enable_notifications('orynider.mx_translator.notification.type.disapprove_langfile');
				return 'notification';

			break;

			default:

			break;
		}
		return parent::enable_step($old_state);		
	}

	/**
	 * Disable notifications for the extension
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 *
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->disable_notifications('orynider.mx_translator.notification.type.langfile_in_queue');
				$phpbb_notifications->disable_notifications('orynider.mx_translator.notification.type.approve_langfile');
				$phpbb_notifications->disable_notifications('orynider.mx_translator.notification.type.delete_langfile');
				$phpbb_notifications->disable_notifications('orynider.mx_translator.notification.type.deny_langfile');
				$phpbb_notifications->disable_notifications('orynider.mx_translator.notification.type.disapprove_langfile');
				return 'notification';

			break;

			default:

				return parent::disable_step($old_state);

			break;
		}
	}

	/**
	 * Purge notifications for the extension
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 *
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->purge_notifications('orynider.mx_translator.notification.type.langfile_in_queue');
				$phpbb_notifications->purge_notifications('orynider.mx_translator.notification.type.approve_langfile');
				$phpbb_notifications->purge_notifications('orynider.mx_translator.notification.type.delete_langfile');
				$phpbb_notifications->purge_notifications('orynider.mx_translator.notification.type.deny_langfile');
				$phpbb_notifications->purge_notifications('orynider.mx_translator.notification.type.disapprove_langfile');
				return 'notification';

			break;

			default:

				return parent::purge_step($old_state);

			break;
		}
	}	
}
