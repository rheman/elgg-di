<?php

namespace hypeJunction\Di;

class Resolver {
	public static function resolve($service) {
		return _elgg_services()->$service;
	}
}