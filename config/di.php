<?php

$services = _elgg_services()->getNames();
$definitions = [];

foreach ($services as $service) {
	$definitions[$service] = function (\DI\Factory\RequestedEntry $entry) {
		return _elgg_services()->{$entry->getName()};
	};
}

return $definitions;