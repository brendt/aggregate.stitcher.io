<?php

namespace Http\Controllers;

use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Actions\RemoveVoteAction;
use Domain\Post\Models\Post;
use Illuminate\Http\Request;

class VotesController
{
    public function addVote(
        Request $request,
        Post $post,
        AddVoteAction $addVoteAction
    ) {
        $addVoteAction->execute($post, $request->user());

        return [];
    }

    public function removeVote(
        Request $request,
        Post $post,
        RemoveVoteAction $removeVoteAction
    ) {
        $removeVoteAction->execute($post, $request->user());

        return [];
    }
}
