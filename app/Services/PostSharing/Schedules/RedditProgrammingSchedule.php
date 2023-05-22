<?php

namespace App\Services\PostSharing\Schedules;

use App\Models\Post;
use App\Services\PostSharing\SharingChannel;
use App\Services\PostSharing\SharingSchedule;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;

final class RedditProgrammingSchedule extends SharingSchedule
{
    public function getNextTimeslot(Post $post): CarbonImmutable
    {
        $date = parent::getNextTimeslot($post)
            ->setHour(16)
            ->setMinute(random_int(1, 59));

        while (! $date->isMonday()) {
            $date = $date->addDay();
        }

        return $date;
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
        return SharingChannel::R_PROGRAMMING;
    }
}
