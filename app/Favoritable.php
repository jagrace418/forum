<?php

namespace App;

trait Favoritable {

	public function favorite () {
		if (!$this->favorites()->where([
			'user_id' => auth()->id()
		])->exists()) {
			$this->favorites()->create([
				'user_id' => auth()->id()
			]);
		}
	}

	public function unfavorite () {
		$attributes = ['user_id' => auth()->id()];

		$this->favorites()->where($attributes)->delete();
	}

	/**
	 * @return mixed
	 */
	public function favorites () {
		return $this->morphMany(Favorite::class, 'favorited');
	}

	/**
	 * @return bool
	 */
	public function isFavorited () {
		return !!$this->favorites->where('user_id', auth()->id())->count();
	}

	/**
	 * @return bool
	 */
	public function getIsFavoritedAttribute () {
		return $this->isFavorited();
	}

	/**
	 * @return mixed
	 */
	public function getFavoritesCountAttribute () {
		return $this->favorites->count();
	}
}