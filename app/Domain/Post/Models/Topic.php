<?php

namespace Domain\Post\Models;

use App\Support\Filterable;
use App\Support\HasSlug;
use App\Support\HasUuid;
use Domain\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
