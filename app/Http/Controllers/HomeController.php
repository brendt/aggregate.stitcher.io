<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostVisit;
use App\Models\User;
use App\SparkLine\SparkLine;
use App\SparkLine\SparkLineDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class HomeController
{
    public function __invoke(Request $request)
    {
        $posts = Post::query()
            ->homePage()
            ->paginate(20);

        $user = $request->user();

        return view('home', [
            'user' => $user,
            'posts' => $posts,
            'message' => $request->get('message'),
            'totalVisitsSparkLine' => $user ? $this->getTotalVisitsSparkLine() : null,
            'totalPostsSparkLine' => $user ? $this->getTotalPostsSparkLine() : null,
        ]);
    }

    private function getTotalVisitsSparkLine(): SparkLine
    {
        $days = DB::query()
            ->from((new PostVisit())->getTable())
            ->selectRaw('`created_at_day`, COUNT(*) as `visits`')
            ->groupBy('created_at_day')
            ->orderByDesc('created_at_day')
            ->limit(20)
            ->get()
            ->map(fn (object $row) => new SparkLineDay(
                count: $row->visits,
                day: Carbon::make($row->created_at_day),
            ));

        return SparkLine::new($days)
            ->withMaxItemAmount(20)
            ->withColors('#34A853', '#43CC64', '#4CE870');
    }

    private function getTotalPostsSparkLine(): SparkLine
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

        return SparkLine::new($days)
            ->withMaxItemAmount(20)
            ->withColors('#4285F4', '#31ACF2', '#2BC9F4');
    }
}
