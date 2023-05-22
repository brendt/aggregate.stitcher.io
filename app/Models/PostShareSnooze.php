<?php

namespace App\Models;

use App\Services\PostSharing\SharingChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostShareSnooze extends Model
{
    protected $guarded = [];

    protected $casts = [
        'snooze_until' => 'datetime',
        'channel' => SharingChannel::class,
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
