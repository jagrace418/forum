<?php


namespace App\Filters;


use App\User;
use Illuminate\Database\Eloquent\Builder;

class ThreadFilters extends Filters {

	/**
	 * @var array
	 */
	protected $filters = ['by', 'popularity'];

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

	/**
	 * @return Builder
	 */
	public function popularity () {
		return $this->builder->orderBy('replies_count', 'desc');
	}

}