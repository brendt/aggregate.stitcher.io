<?php

namespace App\Services\PostSharing\Schedules;

use App\Models\Post;
use App\Services\PostSharing\SharingChannel;
use App\Services\PostSharing\SharingSchedule;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;

final class TwitterSchedule extends SharingSchedule
{
    public function getNextTimeslot(Post $post): CarbonImmutable
    {
        return parent::getNextTimeslot($post)
            ->setHour(10)
            ->setMinute(random_int(1, 35));
    }

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
            days: 0
        );
    }

    protected function getChannel(): SharingChannel
    {
        return SharingChannel::TWITTER;
    }
}
