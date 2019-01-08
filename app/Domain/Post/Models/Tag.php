<?php

namespace Domain\Post\Models;

use App\Domain\Mute\Muteable;
use App\Http\Controllers\TagMutesController;
use App\Support\Filterable;
use App\Support\HasUuid;
use Domain\Model;
use Domain\Mute\Models\Mute;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Tag extends Model implements Filterable, Muteable
{
    use HasUuid;

    protected $casts = [
        'keywords' => 'array'
    ];

    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(
            Post::class,
            PostTag::class,
            'tag_id',
            'id',
            'id',
            'post_id'
        );
    }

    public function getFilterValue(): string
    {
        return $this->name;
    }

    public function mutes(): MorphMany
    {
        return $this->morphMany(
            Mute::class,
            'muteable',
            'muteable_type',
            'muteable_uuid',
            'uuid'
        );
    }

    public function scopeWhereNotMuted(Builder $builder, User $user): Builder
    {
        return $builder->whereDoesntHave('mutes', function (Builder $builder) use ($user) {
            /** @var \Domain\Mute\Models\Mute $builder */
            return $builder->whereUser($user);
        });
    }

    public function scopeWhereMuted(Builder $builder, User $user): Builder
    {
        return $builder->whereHas('mutes', function (Builder $builder) use ($user) {
            /** @var \Domain\Mute\Models\Mute $builder */
            return $builder->whereUser($user);
        });
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getMuteableType(): string
    {
        return $this->getMorphClass();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMuteUrl(): string
    {
        return action([TagMutesController::class, 'store'], $this);
    }

    public function getUnmuteUrl(): string
    {
        return action([TagMutesController::class, 'delete'], $this);
    }
}
