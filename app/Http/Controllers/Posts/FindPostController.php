<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostShare;
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
                ->where(function (Builder $builder) use ($filter) {
                    $builder
                        // No pending share for same channel
                        ->whereDoesntHave(
                            relation: 'pendingShares',
                            callback: function (Builder|PostShare $builder) use ($filter) {
                                $builder->where('channel', $filter);
                            })
                        // No share less than 1 month ago
                        ->whereDoesntHave(
                            relation: 'shares',
                            callback: function (Builder|PostShare $builder) use ($filter) {
                                $builder
                                    ->where('channel', $filter)
                                    ->where('shared_at', '>', now()->subMonth());
                            }
                        );
                })
                ->where(fn(Builder $builder) => $builder
                    ->where('hide_until', '<', now()->addYears(50))
                    ->orWhereNull('hide_until'));
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
        ]);
    }
}
