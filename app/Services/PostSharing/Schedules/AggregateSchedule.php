<?php

namespace App\Services\PostSharing\Schedules;

use App\Services\PostSharing\SharingChannel;
use App\Services\PostSharing\SharingSchedule;
use Carbon\CarbonInterval;

final class AggregateSchedule extends SharingSchedule
{
    public function cannotRepostWithin(): CarbonInterval
    {
        return new CarbonInterval(
            years: 0,
            months: 1,
        );
    }

    public function cannotPostWithin(): CarbonInterval
    {
        return new CarbonInterval(
            years: 0,
            days: 7,
        );
    }

    protected function getChannel(): SharingChannel
    {
        return SharingChannel::AGGREGATE;
    }
}
