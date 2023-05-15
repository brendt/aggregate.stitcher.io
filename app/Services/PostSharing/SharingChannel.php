<?php

namespace App\Services\PostSharing;

use App\Services\PostSharing\Schedules\HackerNewsSchedule;
use App\Services\PostSharing\Schedules\RedditPHPSchedule;
use App\Services\PostSharing\Schedules\RedditProgrammingSchedule;
use App\Services\PostSharing\Schedules\RedditWebdevSchedule;
use App\Services\PostSharing\Schedules\TwitterSchedule;

enum SharingChannel: string
{
    case HackerNews = 'HackerNews';
    case Twitter = 'Twitter';
    case R_PHP = 'r_PHP';
    case R_webdev = 'r_webdev';
    case R_programming = 'r_programming';

    public function getSchedule(): SharingSchedule
    {
        return match ($this) {
            self::HackerNews => new HackerNewsSchedule(),
            self::Twitter => new TwitterSchedule(),
            self::R_programming => new RedditProgrammingSchedule(),
            self::R_webdev => new RedditWebdevSchedule(),
            self::R_PHP => new RedditPHPSchedule(),
        };
    }
}
