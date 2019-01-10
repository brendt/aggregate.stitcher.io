<?php

namespace App\Http\Controllers;

use Domain\Post\Events\AddVoteEvent;
use Domain\Post\Events\RemoveVoteEvent;
use App\Http\ViewModels\VoteViewModel;
use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Actions\RemoveVoteAction;
use Domain\Post\Models\Post;
use Domain\Post\Models\Vote;
use Domain\User\Models\User;
use Illuminate\Http\Request;

class VotesController
{
    public function store(
        Request $request,
        User $user,
        Post $post
    ) {
        $voteExists = Vote::query()
            ->whereUser($user)
            ->wherePost($post)
            ->exists();

        if ($voteExists) {
            return new VoteViewModel($user, $post);
        }

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
        $voteExists = Vote::query()
            ->whereUser($user)
            ->wherePost($post)
            ->exists();

        if (! $voteExists) {
            return new VoteViewModel($user, $post);
        }

        event(RemoveVoteEvent::create($post, $user));

        if (! $request->wantsJson()) {
            return redirect()->action([PostsController::class, 'index']);
        }

        return new VoteViewModel($user, $post);
    }
}
