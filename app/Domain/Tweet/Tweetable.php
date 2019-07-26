<?php

namespace Domain\Tweet;

use Illuminate\Support\Collection;
use Support\Polymorphic;

interface Tweetable extends Polymorphic
{
    public function hasBeenTweeted(): bool;

    /**
     * @return \Illuminate\Support\Collection|\Domain\Tweet\Models\Tweet[]
     */
    public function getTweets(): Collection;

    public function getTwitterStatus(): string;
}
