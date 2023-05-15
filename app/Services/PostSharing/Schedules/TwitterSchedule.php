<?php

namespace App\Services\PostSharing\Schedules;

use App\Services\PostSharing\SharingChannel;
use App\Services\PostSharing\SharingSchedule;
use Carbon\CarbonInterval;

final class TwitterSchedule extends SharingSchedule
{
    protected function cannotRepostWithin(): CarbonInterval
    {
        return new CarbonInterval(
            years: 0,
            months: 3
        );
    }

    protected function cannotPostWithin(): CarbonInterval
    {
        return new CarbonInterval(
            years: 0,
            days: 1
        );
    }

    protected function getChannel(): SharingChannel
    {
        return SharingChannel::Twitter;
    }
}
