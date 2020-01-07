<?php
/// To make this work, it was added to the composer.json and then `composer dump-autoload` was ran

function create ($class, $attributes = []) {
	return factory($class)->create($attributes);
}

function make ($class, $attributes = []) {
	return factory($class)->make($attributes);
}

function raw ($class, $attributes = []) {
	return factory($class)->raw($attributes);
}