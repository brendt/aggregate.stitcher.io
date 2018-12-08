<?php

namespace Domain\Post\Models;

use Domain\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostTag extends Model
{
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function scopeWherePost(Builder $builder, Post $post): Builder
    {
        return $builder->where('post_id', $post->id);
    }
}
