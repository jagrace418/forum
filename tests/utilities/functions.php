<?php
/// To make this work, it was added to the composer.json and then `composer dump-autoload` was ran

function create ($class, $attributes = [], $times = null) {
	return factory($class, $times)->create($attributes);
}

function make ($class, $attributes = [], $times = null) {
	return factory($class, $times)->make($attributes);
}

function raw ($class, $attributes = [], $times = null) {
	return factory($class, $times)->raw($attributes);
}