<?php

namespace App\Console\Jobs;

use Domain\Tweet\Api\TwitterGateway;
use Domain\Tweet\Models\Tweet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class TweetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Domain\Tweet\Models\Tweet */
    private $tweet;

    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }

    public function handle(TwitterGateway $gateway)
    {
        $lastTweet = Tweet::query()
            ->where('id', '<>', $this->tweet->id)
            ->whereNotNull('sent_at')
            ->orderByDesc('sent_at')
            ->first();

        if ($lastTweet && $lastTweet->sent_at->diffInMinutes(now()) < 180) {
            dispatch(new TweetJob($this->tweet))
                ->delay(now()->addMinutes(30));

            return;
        }

        $gateway->tweet($this->tweet);
    }
}
