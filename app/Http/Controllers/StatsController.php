<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\SparkLine\SparkLine;
use App\SparkLine\SparkLineDay;
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
            ->withDimensions(500, 200)
            ->withStrokeWidth(2)
            ->withMaxItemAmount(100)
            ->withColors('#4285F4', '#31ACF2', '#2BC9F4');

        return view('stats', [
            'sparkLine' => $sparkLine,
        ]);
    }
}
