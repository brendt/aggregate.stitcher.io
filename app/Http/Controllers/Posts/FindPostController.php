<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostShare;
use App\Models\PostShareSnooze;
use App\Models\PostState;
use App\Services\PostSharing\SharingChannel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class FindPostController
{
    public function __invoke(Request $request)
    {
        $filter = SharingChannel::tryFrom($request->get('filter'));

        $query = Post::query()
            ->with('source', 'pendingShares', 'comments')
            ->where('state', PostState::PUBLISHED)
            ->orderByDesc('visits');

        if ($filter) {
            $query
                // No pending share for same channel
                ->whereDoesntHave(
                    relation: 'pendingShares',
                    callback: function (Builder|PostShare $builder) use ($filter) {
                        $builder->where('channel', $filter);
                    })

                // No share less than repost grace period for channel
                ->whereDoesntHave(
                    relation: 'shares',
                    callback: function (Builder|PostShare $builder) use ($filter) {
                        $builder
                            ->where('channel', $filter)
                            ->where('shared_at', '>', now()->sub($filter->getSchedule()->cannotRepostWithin())->addDay());
                    }
                )

                ->whereDoesntHave(
                    relation: 'shareSnoozes',
                    callback: function (Builder|PostShareSnooze $builder) use ($filter) {
                        $builder
                            ->where('channel', $filter)
                            ->where('snooze_until', '>', now());
                    }
                );
        } else {
            $query
                ->whereHas(
                    relation: 'pendingShares',
                    operator: '<',
                    count: 3
                )
                ->where(fn(Builder $builder) => $builder
                    ->where('hide_until', '<', now())
                    ->orWhereNull('hide_until'));
        }

        $posts = $query->paginate(50);

        return view('find', [
            'user' => $request->user(),
            'posts' => $posts,
            'message' => $request->get('message'),
            'filter' => $filter
        ]);
    }
}
