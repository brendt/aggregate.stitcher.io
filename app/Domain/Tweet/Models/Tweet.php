<?php

namespace Domain\Tweet\Models;

use Domain\Model;
use Domain\Tweet\Tweetable;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Tweet extends Model
{
    public static function createForTweetable(Tweetable $tweetable): Tweet
    {
        return self::create([
            'tweetable_type' => $tweetable->getMorphClass(),
            'tweetable_id' => $tweetable->getKey(),
            'status' => $tweetable->getTwitterStatus(),
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
