<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'state' => PostState::class,
    ];

    protected static function booted()
    {
        self::creating(fn (Post $post) => $post->state = PostState::PENDING);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function isPending(): bool
    {
        return $this->state === PostState::PENDING;
    }

    public function isStarred(): bool
    {
        return $this->state === PostState::STARRED;
    }

    public function isDenied(): bool
    {
        return $this->state === PostState::DENIED;
    }

    public function isPublished(): bool
    {
        return $this->state === PostState::PUBLISHED;
    }

    public function canDeny(): bool
    {
        return ! $this->isDenied();
    }

    public function canStar(): bool
    {
        return ! $this->isStarred();
    }

    public function canPublish(): bool
    {
        return ! $this->isStarred() && ! $this->isPublished();
    }
}
