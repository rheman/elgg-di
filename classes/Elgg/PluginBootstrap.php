<?php

namespace Elgg;

use Elgg\Di\PublicContainer;
use ElggPlugin;

/**
 * Plugin bootstrap
 */
abstract class PluginBootstrap implements PluginBootstrapInterface {

	/**
	 * @var ElggPlugin
	 */
	protected $plugin;

	/**
	 * @var PublicContainer
	 */
	protected $dic;

	/**
	 * Constructor
	 *
	 * @param ElggPlugin      $plugin
	 * @param PublicContainer $dic
	 */
	public function __construct(ElggPlugin $plugin, PublicContainer $dic) {
		$this->plugin = $plugin;
		$this->dic = $dic;
	}

	/**
	 * {@inheritdoc}
	 */
	public function dic() {
		return $this->dic;
	}

	/**
	 * {@inheritdoc}
	 */
	public function plugin() {
		return $this->plugin;
	}

	/**
	 * Bind plugn bootstrap
	 *
	 * @param $plugin_name
	 */
	public static function bind($plugin_name) {
		$plugin = elgg_get_plugin_from_id($plugin_name);
		$dic = elgg_di();

		$bootstrap = new static($plugin, $dic);

		$bootstrap->boot();
		elgg_register_event_handler('init', 'system', [$bootstrap, 'init']);
		elgg_register_event_handler('ready', 'system', [$bootstrap, 'ready']);
		elgg_register_event_handler('shutdown', 'system', [$bootstrap, 'shutdown']);
		elgg_register_event_handler('upgrade', 'system', [$bootstrap, 'upgrade']);
	}
}