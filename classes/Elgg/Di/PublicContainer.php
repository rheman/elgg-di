<?php

namespace Elgg\Di;

use Elgg\Includer;

/**
 * @method call
 */
class PublicContainer {
	/**
	 * @var \DI\Container
	 */
	private $container;

	/**
	 * @var static
	 */
	static $instance;

	/**
	 * Container constructor
	 *
	 * @param \DI\Container $container
	 */
	public function __construct(\DI\Container $container) {
		$this->container = $container;
	}

	/**
	 * Compilation path
	 * @return string
	 */
	public static function getCompilationPath() {
		return elgg_get_cache_path() . 'di/cache';
	}

	/**
	 * Get container instance
	 * @return static
	 * @throws \Exception
	 */
	public static function getInstance() {
		if (!static::$instance) {
			static::$instance = static::create();
		}

		return static::$instance;
	}

	/**
	 * Get service
	 *
	 * @param string $name
	 *
	 * @return mixed
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public function __get($name) {
		return $this->container->get($name);
	}

	/**
	 * Call a container method
	 *
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @return mixed
	 */
	public function __call($name, $arguments) {
		return call_user_func([$this->container, $name], $arguments);
	}

	/**
	 * Get service definitions
	 * @return array
	 */
	public static function getDefinitions() {
		$root = dirname(dirname(dirname(dirname(__FILE__))));

		$definitions = ["$root/config/di.php"];

		$plugins = elgg_get_plugins();

		foreach ($plugins as $plugin) {
			$path = $plugin->getPath();
			$di_config = "{$path}config/di.php";

			if (file_exists($di_config) && is_readable($di_config)) {
				$definitions[] = $di_config;
			}
		}

		return $definitions;
	}

	/**
	 * Create a new container
	 * @return static
	 * @throws \Exception
	 */
	public static function create() {
		static::getConfig();
		
		$builder = new \DI\ContainerBuilder();

		if (elgg_get_config('environment') !== 'development') {
			$builder->enableCompilation(static::getCompilationPath());
		}

		$builder->addDefinitions(...static::getDefinitions());
		$builder->useAutowiring(false);
		$builder->useAnnotations(false);

		return new static($builder->build());
	}

	/**
	 * Flush container cache
	 * @return void
	 */
	public static function flush() {
		_elgg_rmdir(static::getCompilationPath(), true);
	}

	/**
	 * Get plugin config
	 * @return array
	 */
	public static function getConfig() {
		$root = dirname(dirname(dirname(dirname(__FILE__))));

		$definitions = ["$root/config/config.php"];

		$plugins = elgg_get_plugins();

		foreach ($plugins as $plugin) {
			$path = $plugin->getPath();
			$conf = "{$path}config/config.php";

			if (file_exists($conf) && is_readable($conf)) {
				$config = Includer::requireFile($conf);
				if (is_array($config)) {
					foreach ($config as $key => $value) {
						elgg_set_config($key, $value);
					}
				}
			}
		}

		return $definitions;
	}

}