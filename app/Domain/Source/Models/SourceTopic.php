<?php

namespace Domain\Source\Models;

use Domain\Model;
use Domain\Post\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SourceTopic extends Model
{
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function scopeWhereSource(Builder $builder, Source $source): Builder
    {
        return $builder->where('source_id', $source->id);
    }

    public function scopeWhereTopic(Builder $builder, Topic $topic): Builder
    {
        return $builder->where('topic_id', $topic->id);
    }
}
