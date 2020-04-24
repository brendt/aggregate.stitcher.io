<?php

namespace Domain\Analytics\Models;

use Domain\Analytics\Collections\PageCacheViewCollection;
use Domain\Model;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageCacheView extends Model
{
    protected $casts = [
        'viewed_at' => 'datetime',
        'is_cache_hit' => 'boolean',
    ];

    public function newCollection(array $models = []): PageCacheViewCollection
    {
        return new PageCacheViewCollection($models);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
