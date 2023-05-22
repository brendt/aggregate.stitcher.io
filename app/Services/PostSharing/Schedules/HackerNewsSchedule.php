<?php

namespace App\Services\PostSharing\Schedules;

use App\Models\Post;
use App\Services\PostSharing\SharingChannel;
use App\Services\PostSharing\SharingSchedule;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;

final class HackerNewsSchedule extends SharingSchedule
{
    public function getNextTimeslot(Post $post): CarbonImmutable
    {
        return parent::getNextTimeslot($post)
            ->setHour(13)
            ->setMinute(random_int(1, 59));
    }

    public function cannotRepostWithin(): CarbonInterval
    {
        return new CarbonInterval(
            years: 0,
            months: 36
        );
    }

    public function cannotPostWithin(): CarbonInterval
    {
        return new CarbonInterval(
            years: 0,
            weeks: 2
        );
    }

    protected function getChannel(): SharingChannel
    {
        return SharingChannel::HACKERNEWS;
    }
}
