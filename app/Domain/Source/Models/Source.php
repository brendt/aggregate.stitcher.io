<?php

namespace Domain\Source\Models;

use Domain\Model;
use Domain\Post\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getWebsiteAttribute(): string
    {
        return parse_url($this->url, PHP_URL_HOST);
    }
}
