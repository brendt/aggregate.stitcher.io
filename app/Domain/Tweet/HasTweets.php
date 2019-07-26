<?php

namespace Domain\Tweet;

use Domain\Tweet\Models\Tweet;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasTweets
{
    public function tweets(): MorphMany
    {
        return $this->morphMany(Tweet::class, 'tweetable');
    }

    public function hasBeenTweeted(): bool
    {
        return $this->getTweets()->isNotEmpty();
    }

    /**
     * @return \Illuminate\Support\Collection|\Domain\Tweet\Models\Tweet[]
     */
    public function getTweets(): Collection
    {
        return $this->tweets;
    }
}
