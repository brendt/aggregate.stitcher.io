<?php

namespace App\Console\Commands;

use App\Actions\ParseTweetText;
use App\Models\Mute;
use App\Models\RejectionReason;
use App\Models\Tweet;
use App\Models\TweetFeedType;
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

        $this->syncFromList($twitter);

        $this->info('Done');
    }

    public function syncFromList(Twitter $twitter): void
    {
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
                $this->comment("Syncing {$count} tweets from list");

                $this->storeTweets($tweets);
            }
        } while ($tweets !== []);
    }

    private function storeTweets(array $tweets): void
    {
        foreach ($tweets as $tweet) {
            $subject = $tweet->retweeted_status ?? $tweet;

            $tweet = Tweet::updateOrCreate([
                'tweet_id' => $tweet->id,
            ], [
                'state' => TweetState::PENDING,
                'text' => $subject->full_text ,
                'user_name' => $subject->user->screen_name,
                'retweeted_by_user_name' => isset($tweet->retweeted_status)
                    ? $tweet->user->screen_name
                    : null,
                'created_at' => Carbon::make($subject->created_at),
                'payload' => json_encode($tweet),
            ]);

            if ($reason = $this->shouldBeRejected($tweet)) {
                $tweet->update([
                    'state' => TweetState::REJECTED,
                    'rejection_reason' => $reason->message,
                ]);
            }

            (new ParseTweetText)($tweet);
        }
    }

    private function shouldBeRejected(Tweet $tweet): ?RejectionReason
    {
        // Reject tweets containing a specific word
        foreach ($this->mutes as $mute) {
            if ($tweet->containsPhrase($mute->text)) {
                return RejectionReason::mute($mute->text);
            }
        }

        // Reject replies
        if ($tweet->getPayload()->in_reply_to_status_id) {
            return RejectionReason::isReply();
        }

        // Reject mentions
        if (str_starts_with($tweet->text, '@')) {
            return RejectionReason::isMention();
        }

        // Reject non-english tweets
        $language = $tweet->getPayload()->lang;

        if ($language !== 'en') {
            return RejectionReason::otherLanguage($language);
        }

        return null;
    }
}
