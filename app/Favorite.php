<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Favorite
 * @property int         $id
 * @property int         $user_id
 * @property int         $favorited_id
 * @property string      $favorited_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Favorite newModelQuery()
 * @method static Builder|Favorite newQuery()
 * @method static Builder|Favorite query()
 * @method static Builder|Favorite whereCreatedAt($value)
 * @method static Builder|Favorite whereFavoritedId($value)
 * @method static Builder|Favorite whereFavoritedType($value)
 * @method static Builder|Favorite whereId($value)
 * @method static Builder|Favorite whereUpdatedAt($value)
 * @method static Builder|Favorite whereUserId($value)
 * @mixin Eloquent
 */
class Favorite extends Model {

	protected $guarded = [];
}
