<?php

namespace App\Http\Controllers;

use App\Domain\Post\Events\AddVoteEvent;
use App\Domain\Post\Events\RemoveVoteEvent;
use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Actions\RemoveVoteAction;
use Domain\Post\Models\Post;
use Illuminate\Http\Request;

class VotesController
{
    public function store(
        Request $request,
        Post $post
    ) {
        event(AddVoteEvent::create($post, $request->user()));

        if (! $request->wantsJson()) {
            return redirect()->action([PostsController::class, 'index']);
        }

        return [];
    }

    public function delete(
        Request $request,
        Post $post
    ) {
        event(RemoveVoteEvent::create($post, $request->user()));

        if (! $request->wantsJson()) {
            return redirect()->action([PostsController::class, 'index']);
        }

        return [];
    }
}
