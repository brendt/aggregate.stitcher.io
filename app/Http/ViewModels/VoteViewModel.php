<?php

namespace App\Http\ViewModels;

use Domain\Post\Models\Post;
use Domain\User\Models\User;
use Spatie\BladeX\ViewModel;

class VoteViewModel extends ViewModel
{
    /** @var \Domain\User\Models\User */
    private $user;

    /** @var \Domain\Post\Models\Post */
    private $post;

    public function __construct(User $user, Post $post)
    {
        $this->user = $user->refresh();
        $this->post = $post->refresh();
    }

    public function vote_count(): int
    {
        return $this->post->vote_count;
    }

    public function voted_for(): bool
    {
        return $this->user->votedFor($this->post);
    }

    public function post_uuid(): string
    {
        return $this->post->uuid;
    }
}
