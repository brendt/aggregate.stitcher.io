<?php

namespace App\Console\Jobs;

use Domain\Post\Actions\UpdateVoteCountAction;
use Domain\Post\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateVoteCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Domain\Post\Actions\UpdateVoteCountAction */
    protected $updateVoteCountAction;

    public function __construct(UpdateVoteCountAction $updateVoteCountAction)
    {
        $this->updateVoteCountAction = $updateVoteCountAction;
    }

    public function handle()
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            ($this->updateVoteCountAction)->__invoke($post);
        }
    }
}
