<?php

namespace App\Console\Commands;

use App\Models\PostShare;
use Illuminate\Console\Command;

class SharePostCommand extends Command
{
    protected $signature = 'share:post';

    protected $description = 'Share a post';

    public function handle(): void
    {
        $postShares = PostShare::query()
            ->whereNull('shared_at')
            ->where('share_at', '<', now())
            ->get();

        $this->comment("Sharing {$postShares->count()} posts");

        foreach ($postShares as $postShare) {
            if (!$this->option('no-interaction')) {
                $result = $this->confirm("Share {$postShare->post->title} on {$postShare->channel->name}?");

                if (!$result) {
                    continue;
                }
            }

            $poster = $postShare->channel->getPoster();

            $poster->post($postShare);
        }
    }
}
