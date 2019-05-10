<?php

namespace Elgg;

use Elgg\Di\PublicContainer;
use ElggPlugin;

/**
 * Plugin bootstrap interface
 */
interface PluginBootstrapInterface {

	/**
	 * Executed during boot
	 *
	 * Allows the plugin to implement business logic and register all other handlers
	 *
	 * @return void
	 */
	public function boot();

	/**
	 * Executed during 'init', 'system' event
	 *
	 * Allows the plugin to implement business logic and register all other handlers
	 *
	 * @return void
	 */
	public function init();

	/**
	 * Executed during 'ready', 'system' event
	 *
	 * Allows the plugin to implement logic after all plugins are initialized
	 *
	 * @return void
	 */
	public function ready();

	/**
	 * Executed during 'shutdown', 'system' event
	 *
	 * Allows the plugin to implement logic during shutdown
	 *
	 * @return void
	 */
	public function shutdown();

	/**
	 * Registered as handler for 'upgrade', 'system' event
	 *
	 * Allows the plugin to implement logic during system upgrade
	 *
	 * @return void
	 */
	public function upgrade();

	/**
	 * Returns Elgg's public DI container
	 * @return PublicContainer
	 */
	public function dic();

	/**
	 * Returns plugin entity this bootstrap is related to
	 * @return ElggPlugin
	 */
	public function plugin();
}