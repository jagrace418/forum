<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
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
}
