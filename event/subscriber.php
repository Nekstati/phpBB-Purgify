<?php

namespace nekstati\purgify\event;

class subscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'		=> 'purgify',
		];
	}

	public function __construct(\phpbb\auth\auth $auth, \phpbb\cache\service $cache, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, $phpbb_container, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path)
	{
		$this->auth = $auth;
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->phpbb_container = $phpbb_container;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
	}

	public function purgify($event)
	{
		if (defined('IN_ERROR_HANDLER') || defined('IN_CRON'))
		{
			return;
		}

		if (!$this->auth->acl_get('a_'))
		{
			return;
		}

		if ($this->request->is_set('purge_cache') && check_link_hash($this->request->variable('hash', ''), 'purge_cache' . $this->user->data['user_id']))
		{
			$this->config->increment('assets_version', 1);
			$this->cache->purge();
			$this->phpbb_container->get('text_formatter.cache')->tidy();
			$this->auth->acl_clear_prefetch();

			if (!function_exists('phpbb_cache_moderators'))
			{
				include $this->root_path . 'includes/functions_admin.php';
			}
			phpbb_cache_moderators($this->db, $this->cache, $this->auth);

			$redirect = $this->request->server('HTTP_REFERER', append_sid("{$this->root_path}index.php"));
			meta_refresh(1, $redirect);
			trigger_error('OK');
		}

		$this->template->assign_var('U_PURGE_CACHE', append_sid("{$this->root_path}index.php", 'purge_cache&amp;hash=' . generate_link_hash('purge_cache' . $this->user->data['user_id'])));
	}
}
