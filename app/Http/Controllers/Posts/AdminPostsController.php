<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostState;
use App\Models\Source;
use App\Models\SourceState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class AdminPostsController
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

        $showAll = $request->get('show_all');

        $onlyToday = $request->get('only_today');

        $states = [PostState::PENDING];

        if ($showAll) {
            $states[] = PostState::PUBLISHED;
            $states[] = PostState::STARRED;
            $states[] = PostState::DENIED;
        }

        $query->whereIn('state', $states);

        if ($onlyToday) {
            $query->where('created_at', '>=', now()->subHours(24));
        }

        $posts = $query->paginate(50);

        return view('adminPosts', [
            'posts' => $posts,
            'user' => $user,
            'showAll' => $showAll,
            'onlyToday' => $onlyToday,
            'message' => $request->get('message'),
            'pendingSources' => Source::query()->where('state', SourceState::PENDING)->count(),
        ]);
    }
}
