<?php

namespace App\Console\Commands;

use App\Models\Tweet;
use App\Models\TweetState;
use Carbon\Carbon;
use DG\Twitter\Twitter;
use Illuminate\Console\Command;
use LanguageDetector\LanguageDetector;

class TwitterSyncCommand extends Command
{
    private static $excludeWords = [
        'wordle',
        'worldle',
        'metrodle',
        'trump',
        'democrat',
        'republican',
        'covid',
        'governor',
        'ballot',
        'politics',
    ];

    protected $signature = 'twitter:sync {--clean}';

    private LanguageDetector $languageDetector;

    public function handle(Twitter $twitter, LanguageDetector $languageDetector)
    {
        $this->languageDetector = $languageDetector;

        if ($this->option('clean')) {
            $this->error('Truncating tweets!');

            Tweet::truncate();
        }

        do {
            $lastTweet = Tweet::query()
                ->orderByDesc('tweet_id')
                ->first();

            $tweets = $twitter->request('lists/statuses.json', 'GET', [
                'list_id' => '1317700686709219328',
                'since_id' => $lastTweet?->tweet_id,
                'count' => 200,
                'tweet_mode' => 'extended',
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
            $state = $this->shouldBeRejected($tweet->full_text)
                ? TweetState::REJECTED
                : TweetState::PENDING;

            $subject = $tweet->retweeted_status ?? $tweet;

            Tweet::updateOrCreate([
                'tweet_id' => $tweet->id,
            ], [
                'state' => $state,
                'text' => $subject->full_text,
                'user_name' => $subject->user->screen_name,
                'retweeted_by_user_name' => isset($tweet->retweeted_status)
                    ? $tweet->user->screen_name
                    : null,
                'created_at' => Carbon::make($subject->created_at),
                'payload' => json_encode($tweet),
            ]);
        }
    }

    private function shouldBeRejected(string $text): bool
    {
        // Reject tweets containing a specific word
        foreach (self::$excludeWords as $exclude) {
            if (str_contains(
                haystack: strtolower($text ?? ''),
                needle: strtolower($exclude),
            )) {
                return true;
            }
        }

        // Reject mentions
        if (str_starts_with($text, '@')) {
            return true;
        }

        // Only show English tweets
        if ($this->languageDetector->evaluate($text)->getLanguage()->getCode() !== 'en') {
            return true;
        }

        return false;
    }
}
