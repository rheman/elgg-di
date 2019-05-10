<?php

if (!function_exists('elgg_di')) {
	/**
	 * Get container instance
	 * @return \Elgg\Di\PublicContainer
	 */
	function elgg_di() {
		return \Elgg\Di\PublicContainer::getInstance();
	}
};

\Elgg\Application::start();

elgg_register_event_handler('cache:flush', 'system', '\Elgg\Di\PublicContainer::flush');