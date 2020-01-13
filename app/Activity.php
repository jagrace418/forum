<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Activity
 * @method static Builder|Activity newModelQuery()
 * @method static Builder|Activity newQuery()
 * @method static Builder|Activity query()
 * @mixin Eloquent
 */
class Activity extends Model {

	protected $guarded = [];

	public function subject () {
		return $this->morphTo();
	}

	/**
	 * @param User $user
	 * @param int  $quantity
	 *
	 * @return Collection|\Illuminate\Support\Collection
	 */
	public static function feed (User $user, $quantity = 50) {
		return self::where('user_id', $user->id)
			->latest()
			->with('subject')
			->take($quantity)
			->get()
			->groupBy(function ($activity) {
				return $activity->created_at->format('Y-m-d');
			});
	}
}
