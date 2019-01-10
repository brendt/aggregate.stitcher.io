<?php

namespace Domain\Post\Models;

use Support\HasUuid;
use Domain\Model;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasUuid;

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
}
