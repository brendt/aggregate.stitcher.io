<?php

namespace Domain\Tweet\Models;

use Domain\Model;
use Domain\Tweet\Tweetable;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Tweet extends Model
{
    public static function createForTweetable(Tweetable $tweetable, string $status): Tweet
    {
        return self::create([
            'tweetable_type' => $tweetable->getMorphClass(),
            'tweetable_id' => $tweetable->getKey(),
            'status' => $status,
        ]);
    }

    public function tweetable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getTweetable(): Tweetable
    {
        return $this->tweetable;
    }
}
