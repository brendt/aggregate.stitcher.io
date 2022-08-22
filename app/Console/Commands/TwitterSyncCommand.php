<?php

namespace App\Console\Commands;

use App\Models\Mute;
use App\Models\Tweet;
use App\Models\TweetState;
use Carbon\Carbon;
use DG\Twitter\Twitter;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class TwitterSyncCommand extends Command
{
    protected $signature = 'twitter:sync {--clean}';

    /** @var \Illuminate\Database\Eloquent\Collection<Mute> */
    private Collection $mutes;

    public function handle(Twitter $twitter)
    {
        $this->mutes = Mute::query()->select('text')->get();

        if ($this->option('clean')) {
            $this->error('Truncating tweets!');

            Tweet::truncate();
        }

        do {
            $lastTweet = Tweet::query()
                ->orderByDesc('tweet_id')
                ->first();

            $tweets = $twitter->request('lists/statuses.json', 'GET', [
                'list_id' => config('services.twitter.list_id'),
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
            $subject = $tweet->retweeted_status ?? $tweet;

            $tweet = Tweet::updateOrCreate([
                'tweet_id' => $tweet->id,
            ], [
                'state' => TweetState::PENDING,
                'text' => $subject->full_text,
                'user_name' => $subject->user->screen_name,
                'retweeted_by_user_name' => isset($tweet->retweeted_status)
                    ? $tweet->user->screen_name
                    : null,
                'created_at' => Carbon::make($subject->created_at),
                'payload' => json_encode($tweet),
            ]);

            if ($this->shouldBeRejected($tweet)) {
                $tweet->update([
                    'state' => TweetState::REJECTED,
                ]);
            }
        }
    }

    private function shouldBeRejected(Tweet $tweet): bool
    {
        // Reject tweets containing a specific word
        foreach ($this->mutes as $mute) {
            if ($tweet->containsPhrase($mute->text)) {
                return true;
            }
        }

        // Reject replies
        if ($tweet->getPayload()->in_reply_to_status_id) {
            return true;
        }

        // Reject mentions
        if (str_starts_with($tweet->text, '@')) {
            return true;
        }

        return false;
    }
}
