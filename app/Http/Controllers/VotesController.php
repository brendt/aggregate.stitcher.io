<?php

namespace App\Http\Controllers;

use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Actions\RemoveVoteAction;
use Domain\Post\Models\Post;
use Illuminate\Http\Request;

class VotesController
{
    public function store(
        Request $request,
        Post $post,
        AddVoteAction $addVoteAction
    ) {
        $addVoteAction->execute($post, $request->user());

        if (! $request->wantsJson()) {
            return redirect()->action([PostsController::class, 'index']);
        }

        return [];
    }

    public function delete(
        Request $request,
        Post $post,
        RemoveVoteAction $removeVoteAction
    ) {
        $removeVoteAction->execute($post, $request->user());

        if (! $request->wantsJson()) {
            return redirect()->action([PostsController::class, 'index']);
        }

        return [];
    }
}
