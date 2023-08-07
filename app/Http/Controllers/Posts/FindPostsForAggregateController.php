<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostShare;
use App\Models\PostShareSnooze;
use App\Models\PostState;
use App\Models\Source;
use App\Models\SourceState;
use App\Services\PostSharing\SharingChannel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class FindPostsForAggregateController
{
    public function __invoke(Request $request)
    {
        $topSources = Source::query()
            ->where('state', SourceState::PUBLISHED)
            ->orderByDesc('visits')
            ->limit(15)
            ->whereNotIn('name', [
                'https://externals.io',
                'https://laravel-news.com',
                'https://xkcd.com',
                'https://blog.jetbrains.com',
                'https://thephp.foundation',
                'https://24daysindecember.net',
                'https://blog.laravel.com',
            ])
            ->get();

        $query = Post::query()
            ->with('source', 'pendingShares', 'comments')
            ->where('state', '<>', PostState::PUBLISHED)
            ->orderByDesc('created_at')

            // Only for top sources
            ->whereIn('source_id', $topSources->pluck('id'))

            // No pending share for same channel
            ->whereDoesntHave(
                relation: 'pendingShares',
                callback: function (Builder|PostShare $builder) {
                    $builder->where('channel', SharingChannel::AGGREGATE);
                })

            // No share less than repost grace period for channel
            ->whereDoesntHave(
                relation: 'shares',
                callback: function (Builder|PostShare $builder) {
                    $builder
                        ->where('channel', SharingChannel::AGGREGATE)
                        ->where('shared_at', '>', now()->sub(SharingChannel::AGGREGATE->getSchedule()->cannotRepostWithin())->addDay());
                },
            )
            ->whereDoesntHave(
                relation: 'shareSnoozes',
                callback: function (Builder|PostShareSnooze $builder) {
                    $builder
                        ->where('channel', SharingChannel::AGGREGATE)
                        ->where('snooze_until', '>', now());
                },
            );

        $posts = $query->paginate(50);

        return view('find', [
            'user' => $request->user(),
            'posts' => $posts,
            'message' => $request->get('message'),
            'filter' => SharingChannel::AGGREGATE,
            'q' => null,
        ]);
    }
}
