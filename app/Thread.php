<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Thread
 * @property int                     $id
 * @property int                     $user_id
 * @property string                  $title
 * @property string                  $body
 * @property Carbon|null             $created_at
 * @property Carbon|null             $updated_at
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

	protected $guarded = [];

	public function path () {
		return "/threads/{$this->channel->slug}/{$this->id}";
	}

	public function creator () {
		return $this->belongsTo(User::class, 'user_id');
	}

	public function channel () {
		return $this->belongsTo(Channel::class);
	}

	public function addReply ($reply) {
		$this->replies()->create($reply);
	}

	public function replies () {
		return $this->hasMany(Reply::class);
	}
}
