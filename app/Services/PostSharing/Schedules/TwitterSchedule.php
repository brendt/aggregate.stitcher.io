<?php

namespace App\Services\PostSharing\Schedules;

use App\Services\PostSharing\SharingChannel;
use App\Services\PostSharing\SharingSchedule;
use Carbon\CarbonInterval;

final class TwitterSchedule extends SharingSchedule
{
    protected function getIntervalForSamePostPeriod(): CarbonInterval
    {
        return new CarbonInterval(months: 3);
    }

    protected function getIntervalForChannelPeriod(): CarbonInterval
    {
        return new CarbonInterval(days: 1);
    }

    protected function getChannel(): SharingChannel
    {
        return SharingChannel::Twitter;
    }
}
