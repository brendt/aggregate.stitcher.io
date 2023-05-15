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
            $gracePeriodForRepost = Period::make(
                start: $searchDate->sub($this->cannotRepostWithin()),
                end: $searchDate->add($this->cannotRepostWithin()),
            );

            if ($shares
                ->forPost($post)
                ->forPeriod($gracePeriodForRepost)
                ->forChannel($this->getChannel())
                ->isNotEmpty()
            ) {
                $searchDate = $searchDate->addDay();
                continue;
            }

            $gracePeriodForChannel = Period::make(
                start: $searchDate->sub($this->cannotPostWithin()),
                end: $searchDate->add($this->cannotPostWithin()),
            );

            if ($shares
                ->forChannel($this->getChannel())
                ->forPeriod($gracePeriodForChannel)
                ->isNotEmpty()
            ) {
                $searchDate = $searchDate->addDay();
                continue;
            }

            $nextTimeslot = $searchDate;
        }

        return $nextTimeslot;
    }

    abstract protected function cannotRepostWithin(): CarbonInterval;

    abstract protected function cannotPostWithin(): CarbonInterval;

    abstract protected function getChannel(): SharingChannel;
}
