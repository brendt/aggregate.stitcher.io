<?php

namespace Domain\Post\Models;

use App\Support\HasUuid;
use Domain\Model;
use Domain\Source\Models\Source;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasUuid;

    protected $casts = [
        'date_created' => 'datetime',
        'vote_count' => 'integer',
        'view_count' => 'integer',
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    public function scopeWhereActive(Builder $builder): Builder
    {
        return $builder
            ->join('sources', 'sources.id', '=', 'posts.source_id')
            ->where('sources.is_active', true);
    }
}
