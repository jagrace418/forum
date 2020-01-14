<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Reply
 * @property int                        $id
 * @property int                        $user_id
 * @property int                        $thread_id
 * @property string                     $body
 * @property Carbon|null                $created_at
 * @property Carbon|null                $updated_at
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
 * @property-read User                  $owner
 * @property-read Collection|Favorite[] $favorites
 * @property-read int|null              $favorites_count
 */
class Reply extends Model {

	use Favoritable, RecordsActivity;

	/**
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * Any time we query this, also eager load these
	 * @var array
	 */
	protected $with = ['owner', 'favorites'];

	/**
	 * @return BelongsTo
	 */
	public function owner () {
		return $this->belongsTo(User::class, 'user_id');
	}

	public function thread () {
		return $this->belongsTo(Thread::class);
	}

	public function path () {
		return $this->thread->path() . "#reply-" . $this->id;
	}

}
