<?php

namespace App\Services\PostSharing\Schedules;

use App\Services\PostSharing\SharingChannel;
use App\Services\PostSharing\SharingSchedule;
use Carbon\CarbonInterval;

final class RedditProgrammingSchedule extends SharingSchedule
{
    protected function cannotRepostWithin(): CarbonInterval
    {
        return new CarbonInterval(
            years: 0,
            months: 12
        );
    }

    protected function cannotPostWithin(): CarbonInterval
    {
        return new CarbonInterval(
            years: 0,
            weeks: 2
        );
    }

    protected function getChannel(): SharingChannel
    {
        return SharingChannel::R_programming;
    }
}
