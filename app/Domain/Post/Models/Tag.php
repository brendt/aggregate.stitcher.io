<?php

namespace Domain\Post\Models;

use App\Support\Filterable;
use Domain\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Tag extends Model implements Filterable
{
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

    public function getFilterValue(): string
    {
        return $this->name;
    }
}
