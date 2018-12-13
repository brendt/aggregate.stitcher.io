<?php

namespace Domain\Source\Models;

use App\Support\Filterable;
use App\Support\HasUuid;
use Domain\Model;
use Domain\Post\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model implements Filterable
{
    use HasUuid;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function boot()
    {
        self::creating(function (Source $source) {
            if ($source->website === null) {
                $source->website = parse_url($source->url, PHP_URL_HOST);
            }
        });

        parent::boot();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function scopeWhereActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }

    public function getPostByUrl(string $url): ?Post
    {
        foreach ($this->posts as $post) {
            if ($post->url !== $url) {
                continue;
            }

            return $post;
        }

        return null;
    }

    public function getFilterValue(): string
    {
        return $this->website;
    }
}
