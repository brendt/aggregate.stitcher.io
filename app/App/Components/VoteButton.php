<?php

namespace App\Components;

use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Actions\RemoveVoteAction;
use Domain\Post\Models\Post;
use Livewire\Component;

class VoteButton extends Component
{
    /** @var \Domain\Post\Models\Post */
    protected $post;

    /** @var \Domain\User\Models\User|null */
    protected $user;

    /** @var \Domain\Post\Actions\AddVoteAction */
    protected $addVoteAction;

    /** @var \Domain\Post\Actions\RemoveVoteAction */
    protected $removeVoteAction;

    public function mount($postId)
    {
        $this->post = Post::find($postId);
        $this->user = current_user();
        $this->addVoteAction = app(AddVoteAction::class);
        $this->removeVoteAction = app(RemoveVoteAction::class);
    }

    public function render()
    {
        return view('components.voteButton', [
            'hasVoted' => $this->user && $this->user->votedFor($this->post),
            'user' => $this->user,
            'post' => $this->post,
        ]);
    }

    public function toggleVote()
    {
        if ($this->user->votedFor($this->post)) {
            $this->removeVoteAction->__invoke($this->post, $this->user);
        } else {
            $this->addVoteAction->__invoke($this->post, $this->user);
        }

        $this->user->refresh();
    }
}
