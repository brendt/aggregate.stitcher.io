<?php

namespace App\Services\PostSharing\Schedules;

use App\Models\Post;
use App\Services\PostSharing\SharingChannel;
use App\Services\PostSharing\SharingSchedule;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;

final class LobstersSchedule extends SharingSchedule
{
    public function getNextTimeslot(Post $post): CarbonImmutable
    {
        $date = parent::getNextTimeslot($post)
            ->setHour(10)
            ->setMinute(random_int(1, 59));

        while (! $date->isMonday()) {
            $date = $date->addDay();
        }

        return $date;
    }

    public function cannotRepostWithin(): CarbonInterval
    {
        return new CarbonInterval(
            years: 0,
            months: 24
        );
    }

    public function cannotPostWithin(): CarbonInterval
    {
        return new CarbonInterval(
            years: 0,
            weeks: 0,
            days: 6,
        );
    }

    protected function getChannel(): SharingChannel
    {
        return SharingChannel::R_PHP;
    }
}
