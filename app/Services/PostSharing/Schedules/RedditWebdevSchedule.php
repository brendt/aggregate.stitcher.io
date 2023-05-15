<?php

namespace App\Services\PostSharing\Schedules;

use App\Services\PostSharing\SharingChannel;
use App\Services\PostSharing\SharingSchedule;
use Carbon\CarbonInterval;

final class RedditWebdevSchedule extends SharingSchedule
{
    protected function getIntervalForSamePostPeriod(): CarbonInterval
    {
        return new CarbonInterval(months: 12);
    }

    protected function getIntervalForChannelPeriod(): CarbonInterval
    {
        return new CarbonInterval(weeks: 2);
    }

    protected function getChannel(): SharingChannel
    {
        return SharingChannel::R_webdev;
    }
}
