<?php

namespace App\Console\Jobs;

use Domain\Post\Actions\AddViewAction;
use Domain\Post\Models\Post;
use Domain\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class PostViewedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Domain\Post\Actions\AddViewAction */
    private $addViewAction;

    /** @var \Domain\Post\Models\Post */
    private $post;

    /** @var \Domain\User\Models\User|null */
    private $user;

    public function __construct(
        AddViewAction $addViewAction,
        Post $post,
        ?User $user
    ) {
        $this->addViewAction = $addViewAction;
        $this->post = $post;
        $this->user = $user;
    }

    public function handle(): void
    {
        ($this->addViewAction)->__invoke($this->post, $this->user);
    }
}
