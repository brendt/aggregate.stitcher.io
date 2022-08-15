<?php declare(strict_types=1);

namespace App\Http\Controllers\Tweets;

use App\Models\Tweet;
use App\Models\TweetState;
use Illuminate\Http\Request;

final class AdminTweetController
{
    public function __invoke(Request $request)
    {
        $tweets = Tweet::query()
            ->where('state', TweetState::PENDING)
            ->where('created_at', '>=', now()->subHours(24))
            ->orderByDesc('tweet_id')
            ->get();

        return view('adminTweets', [
            'user' => $request->user(),
            'tweets' => $tweets,
            'message' => $request->get('message'),
        ]);
    }
}
