<?php

namespace App\Http\Controllers;

use App\Http\ViewModels\VoteViewModel;
use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Actions\RemoveVoteAction;
use Domain\Post\Models\Post;
use Domain\Post\Models\Vote;
use Domain\User\Models\User;
use Illuminate\Http\Request;

final class VotesController
{
    public function store(
        Request $request,
        User $user,
        Post $post,
        AddVoteAction $addVoteAction
    ) {
        $voteExists = Vote::query()
            ->whereUser($user)
            ->wherePost($post)
            ->exists();

        if ($voteExists) {
            return new VoteViewModel($user, $post);
        }

        $addVoteAction($post, $user);

        if (! $request->wantsJson()) {
            return redirect()->action([PostsController::class, 'index']);
        }

        return new VoteViewModel($user, $post);
    }

    public function delete(
        Request $request,
        User $user,
        Post $post,
        RemoveVoteAction $removeVoteAction
    ) {
        $voteExists = Vote::query()
            ->whereUser($user)
            ->wherePost($post)
            ->exists();

        if (! $voteExists) {
            return new VoteViewModel($user, $post);
        }

        $removeVoteAction($post, $user);

        if (! $request->wantsJson()) {
            return redirect()->action([PostsController::class, 'index']);
        }

        return new VoteViewModel($user, $post);
    }
}
