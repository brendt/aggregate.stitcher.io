<?php

namespace App\Actions;

use App\Data\VisitsForDay;
use App\Models\Post;
use App\Models\PostVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class CreatePostVisitsGraph
{
    private const BASE = 25;
    private const LIMIT = 20;
    private const GRAPH_WIDTH = 150;

    public function __invoke(Post $post): string
    {
        $visitsPerDay = $post->visitsPerDay(self::LIMIT)
            ->mapWithKeys(fn (VisitsForDay $day) => [$day->day->format('Y-m-d') => $day]);

        $max = DB::query()
            ->selectRaw("COUNT(*) AS `visits`, `created_at_day`, `post_id`")
            ->from((new PostVisit)->getTable())
            ->groupByRaw('`created_at_day`, `post_id`')
            ->orderByDesc('visits')
            ->limit(1)
            ->get('visits');

        $max = ($max[0] ?? null)?->visits;

        $step = floor(self::GRAPH_WIDTH / self::LIMIT);

        $coordinates = collect(range(0, self::LIMIT))
            ->map(fn (int $days) => now()->subDays($days)->format('Y-m-d'))
            ->reverse()
            ->mapWithKeys(function (string $key) use ($max, $visitsPerDay) {
                /** @var VisitsForDay|null $day */
                $day = $visitsPerDay[$key] ?? null;

                return [$key => $day
                    ? $day->rebase(self::BASE, $max)->visits
                    : 1 // Default value because 0 renders too small a line
                ];
            })
            ->values()
            ->map(fn (int $visits, int $index) => $index * $step . ',' . $visits)
            ->implode(' ');

        $svg = view('visitsSvg', [
            'coordinates' => $coordinates,
            'post' => $post,
        ])->render();


        return $svg;
    }
}
