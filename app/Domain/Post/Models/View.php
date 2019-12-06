<?php

namespace Domain\Post\Models;

use Domain\Model;
use Domain\Post\Collections\ViewCollection;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\HasUuid;

class View extends Model
{
    use HasUuid;

    public function newCollection(array $models = [])
    {
        return new ViewCollection($models);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeWhereUser(Builder $builder, User $user): Builder
    {
        return $builder->where('user_id', $user->id);
    }

    public function scopeWherePost(Builder $builder, Post $post): Builder
    {
        return $builder->where('post_id', $post->id);
    }

    public function scopeWhereSource(Builder $builder, Source $source): Builder
    {
        return $builder->whereHas('post', fn(Builder $builder) => $builder->where('source_id', $source->id));
    }
}
