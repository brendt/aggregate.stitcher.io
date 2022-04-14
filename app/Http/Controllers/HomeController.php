<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostState;
use App\Models\Source;
use App\Models\SourceState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class HomeController
{
    public function __invoke(Request $request)
    {
        $query = Post::query()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->whereHas('source', function (Builder $query) {
                $query->where('state', SourceState::PUBLISHED);
            });

        $user = $request->user();

        $showDenied = $request->get('show_denied');

        $onlyPending = $request->get('only_pending');

        $onlyToday = $request->get('only_today');

        if ($user) {
            $states = [PostState::PENDING];

            if (! $onlyPending) {
                $states[] = PostState::PUBLISHED;
                $states[] = PostState::STARRED;
            }

            if ($showDenied) {
                $states[] = PostState::DENIED;
            }

            $query->whereIn('state', $states);
        } else {
            $query->whereIn('state', [
                PostState::PUBLISHED,
                PostState::STARRED,
            ]);
        }

        if ($onlyToday) {
            $query->where('created_at', '>=', now()->subHours(24));
        }

        $posts = $query->paginate(50);

        return view('home', [
            'posts' => $posts,
            'user' => $user,
            'showDenied' => $showDenied,
            'onlyPending' => $onlyPending,
            'onlyToday' => $onlyToday,
            'message' => $request->get('message'),
            'pendingSources' => Source::query()->where('state', SourceState::PENDING)->count(),
        ]);
    }
}
