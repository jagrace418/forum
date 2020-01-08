<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Reply
 * @property int         $id
 * @property int         $user_id
 * @property int         $thread_id
 * @property string      $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Reply newModelQuery()
 * @method static Builder|Reply newQuery()
 * @method static Builder|Reply query()
 * @method static Builder|Reply whereBody($value)
 * @method static Builder|Reply whereCreatedAt($value)
 * @method static Builder|Reply whereId($value)
 * @method static Builder|Reply whereThreadId($value)
 * @method static Builder|Reply whereUpdatedAt($value)
 * @method static Builder|Reply whereUserId($value)
 * @mixin Eloquent
 * @property-read User   $owner
 */
class Reply extends Model {

	/**
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * @return BelongsTo
	 */
	public function owner () {
		return $this->belongsTo(User::class, 'user_id');
	}

	public function favorites () {
		return $this->morphMany(Favorite::class, 'favorited');
	}

	public function favorite () {
		if (!$this->favorites()->where([
			'user_id' => auth()->id()
		])->exists()) {
			$this->favorites()->create([
				'user_id' => auth()->id()
			]);
		}
	}
}
