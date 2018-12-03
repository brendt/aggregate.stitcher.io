<?php

namespace Domain\Post\Models;

use Domain\Model;
use Domain\Source\Models\Source;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $casts = [
        'date_created' => 'datetime',
        'vote_count' => 'integer',
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
