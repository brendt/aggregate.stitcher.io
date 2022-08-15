<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tweets;

use App\Models\Mute;
use App\Models\Tweet;
use App\Models\TweetState;
use Illuminate\Http\Request;

final class StoreMuteController
{
    public function __invoke(Request $request)
    {
        $text = $request->validate([
            'text' => ['string', 'required']
        ])['text'];

        Mute::create([
            'text' => $text,
        ]);

        $pendingTweets = Tweet::query()->pendingToday()->get();

        foreach ($pendingTweets as $pendingTweet) {
            if ($pendingTweet->containsPhrase($text)) {
                $pendingTweet->update([
                    'state' => TweetState::REJECTED,
                ]);
            }
        }

        return redirect()->action(AdminTweetController::class, ['message' => 'Mute created!']);
    }
}
