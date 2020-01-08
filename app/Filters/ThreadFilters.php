<?php


namespace App\Filters;


use App\User;

class ThreadFilters extends Filters {

	/**
	 * @var array
	 */
	protected $filters = ['by'];

	/**
	 * @param string $username
	 *
	 * @return mixed
	 */
	public function by ($username) {
		/** @var User $user */
		$user = User::where('name', $username)->firstOrFail();

		return $this->builder->where('user_id', $user->id);
	}

}