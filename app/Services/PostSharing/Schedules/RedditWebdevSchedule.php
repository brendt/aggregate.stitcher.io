<?php

namespace App\Services\PostSharing\Schedules;

use App\Models\Post;
use App\Services\PostSharing\SharingChannel;
use App\Services\PostSharing\SharingSchedule;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;

final class RedditWebdevSchedule extends SharingSchedule
{
    public function getNextTimeslot(Post $post): CarbonImmutable
    {
        return parent::getNextTimeslot($post)
            ->setHour(random_int(7, 8))
            ->setMinute(random_int(1, 59));
    }

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
        return SharingChannel::R_WEBDEV;
    }
}
