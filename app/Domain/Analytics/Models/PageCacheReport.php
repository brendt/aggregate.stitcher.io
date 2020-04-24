<?php

namespace Domain\Analytics\Models;

use Domain\Model;

class PageCacheReport extends Model
{
    protected $casts = [
        'day' => 'date',
        'cache_hits' => 'integer',
        'cache_misses' => 'integer',
        'authenticated_cache_hits' => 'integer',
        'guest_cache_hits' => 'integer',
    ];
}
