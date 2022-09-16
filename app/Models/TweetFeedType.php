<?php

declare(strict_types=1);

namespace App\Models;

enum TweetFeedType: string
{
    case LIST = 'list';
    case SEARCH = 'search';

    public function getColour(): string
    {
        return match($this) {
            self::LIST => 'blue',
            self::SEARCH => 'green',
        };
    }
}
