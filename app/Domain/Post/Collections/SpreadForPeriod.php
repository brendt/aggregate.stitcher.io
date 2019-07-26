<?php

namespace Domain\Post\Collections;

use Carbon\Carbon;
use Spatie\Period\Period;

trait SpreadForPeriod
{
    public function spreadForPeriod(Period $period)
    {
        $day = Carbon::make($period->getStart());

        $data = collect([]);

        while ($day <= $period->getEnd()) {
            $data[$day->toDateString()] = 0;

            $day->addDay();
        }

        foreach ($this as $model) {
            $data[$model->created_at->toDateString()] += 1;
        }

        return $data;
    }
}
