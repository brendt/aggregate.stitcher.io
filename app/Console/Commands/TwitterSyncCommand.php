<?php

namespace App\Console\Commands;

use App\Models\Tweet;
use Carbon\Carbon;
use DG\Twitter\Twitter;
use Illuminate\Console\Command;

class TwitterSyncCommand extends Command
{
    private const EXCLUDE = [
        'wordle',
        'worldle',
        'metrodle',
    ];

    protected $signature = 'twitter:sync';

    public function handle(Twitter $twitter)
    {
        do {
            $lastTweet = Tweet::query()
                ->orderByDesc('tweet_id')
                ->first();

            $tweets = $twitter->request('lists/statuses.json', 'GET', [
                'list_id' => '1317700686709219328',
                'since_id' => $lastTweet?->tweet_id,
                'count' => 200,
            ]);

            $count = count($tweets);

            if ($count === 0) {
                $this->comment('No more new tweets');
            } else {
                $this->comment("Syncing {$count} tweets");

                $this->storeTweets($tweets);
            }
        } while ($tweets !== []);

        $this->info('Done');
    }

    private function storeTweets(array $tweets): void
    {
        foreach ($tweets as $tweet) {
            if ($this->hasExcludedWord($tweet->text)) {
                continue;
            }

            Tweet::updateOrCreate([
                'tweet_id' => $tweet->id,
            ], [
                'text' => $tweet->text,
                'user_name' => $tweet->user->screen_name,
                'created_at' => Carbon::make($tweet->created_at),
                'payload' => json_encode($tweet),
            ]);
        }
    }

    private function hasExcludedWord(string $text): bool
    {
        foreach (self::EXCLUDE as $exclude) {
            if (str_contains(
                haystack: strtolower($text ?? ''),
                needle: strtolower($exclude),
            )) {
                return true;
            }
        }

        return false;
    }
}
