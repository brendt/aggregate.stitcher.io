<?php

namespace Domain\Source\Models;

use App\Support\HasUuid;
use Domain\Model;
use Domain\Post\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    use HasUuid;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getWebsiteAttribute(): string
    {
        return parse_url($this->url, PHP_URL_HOST);
    }

    public function scopeWhereActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }
}
