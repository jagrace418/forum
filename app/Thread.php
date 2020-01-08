<?php

namespace App;

use App\Filters\ThreadFilters;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Thread
 * @property int         $id
 * @property int         $user_id
 * @property string      $title
 * @property string      $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Thread newModelQuery()
 * @method static Builder|Thread newQuery()
 * @method static Builder|Thread query()
 * @method static Builder|Thread whereBody($value)
 * @method static Builder|Thread whereCreatedAt($value)
 * @method static Builder|Thread whereId($value)
 * @method static Builder|Thread whereTitle($value)
 * @method static Builder|Thread whereUpdatedAt($value)
 * @method static Builder|Thread whereUserId($value)
 * @mixin Eloquent
 * @property int                     $channel_id
 * @property-read Channel            $channel
 * @property-read User               $creator
 * @property-read Collection|Reply[] $replies
 * @property-read int|null           $replies_count
 * @method static Builder|Thread whereChannelId($value)
 */
class Thread extends Model {

	/**
	 * Don't auto-apply mass assignment protection
	 * @var array
	 */
	protected $guarded = [];

	protected static function boot () {
		parent::boot();
		static::addGlobalScope('replyCount', function (Builder $builder) {
			$builder->withCount('replies');
		});
	}

	/**
	 * @return string
	 */
	public function path () {
		return "/threads/{$this->channel->slug}/{$this->id}";
	}

	/**
	 * @return BelongsTo
	 */
	public function creator () {
		return $this->belongsTo(User::class, 'user_id');
	}

	/**
	 * @return BelongsTo
	 */
	public function channel () {
		return $this->belongsTo(Channel::class);
	}

	/**
	 * @param $reply
	 */
	public function addReply ($reply) {
		$this->replies()->create($reply);
	}

	/**
	 * @return HasMany
	 */
	public function replies () {
		return $this->hasMany(Reply::class);
	}

	/**
	 * @param Builder       $query
	 * @param ThreadFilters $filters
	 *
	 * @return Builder
	 */
	public function scopeFilter ($query, ThreadFilters $filters) {
		return $filters->apply($query);
	}
}
