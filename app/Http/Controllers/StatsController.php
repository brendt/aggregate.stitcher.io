<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Brendt\SparkLine\SparkLine;
use Brendt\SparkLine\SparkLineDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class StatsController
{
    public function __invoke()
    {
        $days = DB::query()
            ->from((new Post())->getTable())
            ->selectRaw('`published_at_day`, COUNT(*) as `visits`')
            ->groupBy('published_at_day')
            ->orderByDesc('published_at_day')
            ->whereNotNull('published_at_day')
            ->limit(20)
            ->get()
            ->map(fn (object $row) => new SparkLineDay(
                count: $row->visits,
                day: Carbon::make($row->published_at_day),
            ));

        $sparkLine = SparkLine::new($days)
            ->withStrokeWidth(4)
            ->withDimensions(500, 100)
            ->withMaxItemAmount(100)
            ->withMaxValue(20);

        return view('stats', [
            'sparkLine' => $sparkLine,
        ]);
    }
}
