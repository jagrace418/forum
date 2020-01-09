<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Channel
 * @property int                      $id
 * @property string                   $name
 * @property string                   $slug
 * @property Carbon|null              $created_at
 * @property Carbon|null              $updated_at
 * @method static Builder|Channel newModelQuery()
 * @method static Builder|Channel newQuery()
 * @method static Builder|Channel query()
 * @method static Builder|Channel whereCreatedAt($value)
 * @method static Builder|Channel whereId($value)
 * @method static Builder|Channel whereName($value)
 * @method static Builder|Channel whereSlug($value)
 * @method static Builder|Channel whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Thread[] $threads
 * @property-read int|null            $threads_count
 */
class Channel extends Model {

	/**
	 * @return string
	 */
	public function getRouteKeyName () {
		return 'slug';
	}

	/**
	 * @return HasMany
	 */
	public function threads () {
		return $this->hasMany(Thread::class);
	}
}
