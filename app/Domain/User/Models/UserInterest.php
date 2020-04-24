<?php

namespace Domain\User\Models;

use Domain\Model;
use Domain\Post\Models\Topic;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInterest extends Model
{
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
