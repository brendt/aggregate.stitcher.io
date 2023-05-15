<?php

namespace App\Services\PostSharing;

use App\Models\Post;
use App\Models\PostShare;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Spatie\Period\Period;

abstract class SharingSchedule
{
    public function getNextTimeslot(Post $post): CarbonImmutable
    {
        $shares = PostShare::all();

        $searchDate = now()->toImmutable();

        $nextTimeslot = null;

        while ($nextTimeslot === null) {
            $periodForSamePost = Period::make(
                start: $searchDate->sub($this->getIntervalForSamePostPeriod()),
                end: $searchDate->add($this->getIntervalForSamePostPeriod()),
            );

            if ($shares
                ->forPost($post)
                ->forPeriod($periodForSamePost)
                ->forChannel($this->getChannel())
                ->isNotEmpty()
            ) {
                $searchDate = $searchDate->addDay();
                continue;
            }

            $periodForChannel = Period::make(
                start: $searchDate->sub($this->getIntervalForChannelPeriod()),
                end: $searchDate->add($this->getIntervalForChannelPeriod()),
            );

            if ($shares
                ->forPeriod($periodForChannel)
                ->forChannel($this->getChannel())
                ->isNotEmpty()
            ) {
                $searchDate = $searchDate->addDay();
                continue;
            }

            $nextTimeslot = $searchDate;
        }

        return $nextTimeslot;
    }

    abstract protected function getIntervalForSamePostPeriod(): CarbonInterval;

    abstract protected function getIntervalForChannelPeriod(): CarbonInterval;

    abstract protected function getChannel(): SharingChannel;
}
