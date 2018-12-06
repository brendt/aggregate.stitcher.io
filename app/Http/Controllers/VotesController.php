<?php

namespace App\Http\Controllers;

use App\Domain\Post\Events\AddVoteEvent;
use App\Domain\Post\Events\RemoveVoteEvent;
use App\Http\ViewModels\VoteViewModel;
use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Actions\RemoveVoteAction;
use Domain\Post\Models\Post;
use Domain\User\Models\User;
use Illuminate\Http\Request;

class VotesController
{
    public function store(
        Request $request,
        User $user,
        Post $post
    ) {
        event(AddVoteEvent::create($post, $user));

        if (! $request->wantsJson()) {
            return redirect()->action([PostsController::class, 'index']);
        }

        return new VoteViewModel($user, $post);
    }

    public function delete(
        Request $request,
        User $user,
        Post $post
    ) {
        event(RemoveVoteEvent::create($post, $user));

        if (! $request->wantsJson()) {
            return redirect()->action([PostsController::class, 'index']);
        }

        return new VoteViewModel($user, $post);
    }
}
