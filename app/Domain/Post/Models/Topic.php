<?php

namespace Domain\Post\Models;

use Domain\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Filterable;
use Support\HasSlug;
use Support\HasUuid;

class Topic extends Model implements Filterable
{
    use HasUuid, HasSlug;

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function getFilterValue()
    {
        return $this->slug;
    }
}
