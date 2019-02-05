<?php

namespace App\Console\Jobs;

use Domain\Post\Actions\UpdateViewCountAction;
use Domain\Post\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateViewCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Domain\Post\Actions\UpdateViewCountAction */
    protected $updateViewCountAction;

    public function __construct(UpdateViewCountAction $updateViewCountAction)
    {
        $this->updateViewCountAction = $updateViewCountAction;
    }

    public function handle(): void
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            ($this->updateViewCountAction)->__invoke($post);
        }
    }
}
