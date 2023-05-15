<?php

namespace App\Console\Commands;

use App\Models\PostShare;
use Illuminate\Console\Command;

class SharePostCommand extends Command
{
    protected $signature = 'post:share {postShare}';

    protected $description = 'Share a post';

    public function handle(): void
    {
        $postShare = PostShare::findOrFail($this->argument('postShare'));

        $channel = $postShare->channel;

        $this->comment("Sharing on {$channel->name}: \"{$postShare->post->title}\"");

        $channel->getPoster()->post($postShare->post, $postShare);

        $this->info("Done: ");
    }
}
