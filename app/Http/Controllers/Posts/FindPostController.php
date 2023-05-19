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
            ->where(fn(Builder $builder) => $builder
                ->where('hide_until', '<', now())
                ->orWhereNull('hide_until'))
            ->orderByDesc('visits');

        if ($filter) {
            $query->whereDoesntHave(
                relation: 'pendingShares',
                callback: function (Builder|PostShare $builder) use ($filter) {
                    $builder->where('channel', $filter);
                });
        } else {
            $query->whereHas(
                relation: 'pendingShares',
                operator: '<',
                count: 3
            );
        }

        $posts = $query->paginate(50);

        return view('find', [
            'user' => $request->user(),
            'posts' => $posts,
            'message' => $request->get('message'),
        ]);
    }
}
