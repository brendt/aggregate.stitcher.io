<?php

namespace Domain\Post\Models;

use App\Domain\Mute\HasMutes;
use App\Domain\Mute\Muteable;
use App\Http\Controllers\TagMutesController;
use App\Support\Filterable;
use App\Support\HasUuid;
use Domain\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Tag extends Model implements Filterable, Muteable
{
    use HasUuid, HasMutes;

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

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function scopeWhereTopic(Builder $builder, Topic $topic): Builder
    {
        return $builder->where('topic_id', $topic->id);
    }

    public function getFilterValue(): string
    {
        return $this->name;
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
