<?php

namespace App\Components;

use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Actions\RemoveVoteAction;
use Domain\Post\Models\Post;
use Livewire\Component;

class VoteButton extends Component
{
    public ?int $postId = null;
    public int $voteCount = 0;

    public function mount($postId, $voteCount)
    {
        $this->postId = $postId;
        $this->voteCount = $voteCount;
    }

    public function render()
    {
        $user = current_user();
        return view(
            'components.livewire-vote-button',
            [
                'hasVoted' => $user && $user->votedFor($this->postId),
                'user' => $user,
                'voteCount' => $this->voteCount,
            ]
        );
    }

    public function toggleVote()
    {
        $post = Post::find($this->postId);
        if (!$post) {
            return;
        }
        $user = current_user();
        if ($user->votedFor($post)) {
            app(RemoveVoteAction::class)($post, $user);
        } else {
            app(AddVoteAction::class)($post, $user);
        }
        $this->voteCount = $post->vote_count;
        $user->refresh();
    }
}
