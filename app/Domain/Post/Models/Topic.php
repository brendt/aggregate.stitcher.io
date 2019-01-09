<?php

namespace Domain\Post\Models;

use App\Support\HasUuid;
use Domain\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasUuid;

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
