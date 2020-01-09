<?php
/// To make this work, it was added to the composer.json and then `composer dump-autoload` was ran

/**
 * @param       $class
 * @param array $attributes
 * @param null  $times
 *
 * @return mixed
 */
function create ($class, $attributes = [], $times = null) {
	return factory($class, $times)->create($attributes);
}

/**
 * @param       $class
 * @param array $attributes
 * @param null  $times
 *
 * @return mixed
 */
function make ($class, $attributes = [], $times = null) {
	return factory($class, $times)->make($attributes);
}

/**
 * @param       $class
 * @param array $attributes
 * @param null  $times
 *
 * @return mixed
 */
function raw ($class, $attributes = [], $times = null) {
	return factory($class, $times)->raw($attributes);
}