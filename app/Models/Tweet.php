<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'state' => TweetState::class,
        'tweet_id' => 'integer',
        'created_at' => 'datetime',
    ];


    public function isPending(): bool
    {
        return $this->state === TweetState::PENDING;
    }

    public function isDenied(): bool
    {
        return $this->state === TweetState::DENIED;
    }

    public function isPublished(): bool
    {
        return $this->state === TweetState::PUBLISHED;
    }

    public function canDeny(): bool
    {
        return ! $this->isDenied();
    }

    public function canPublish(): bool
    {
        return ! $this->isPublished();
    }

    public function getPublicUrl(): string
    {
        return "https://twitter.com/{$this->user_name}/status/{$this->tweet_id}";
    }
}
