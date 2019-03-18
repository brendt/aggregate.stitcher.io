<?php

namespace Domain\Post\Models;

use Domain\Model;
use Domain\Source\Models\Source;
use Domain\Source\Models\SourceTopic;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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

    public function sourceTopics(): HasMany
    {
        return $this->hasMany(SourceTopic::class);
    }

    public function sources(): HasManyThrough
    {
        return $this->hasManyThrough(
            Source::class,
            SourceTopic::class,
            'topic_id',
            'id',
            'id',
            'source_id'
        );
    }
}
