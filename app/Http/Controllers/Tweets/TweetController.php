<?php declare(strict_types=1);

namespace App\Http\Controllers\Tweets;

use App\Models\Tweet;
use App\Models\TweetState;
use Illuminate\Http\Request;

final class TweetController
{
    public function __invoke(Request $request)
    {
        $tweets = Tweet::query()
            ->where('state', TweetState::PUBLISHED)
            ->orderByDesc('tweet_id')
            ->paginate(100);

        return view('tweets', [
            'user' => $request->user(),
            'tweets' => $tweets,
            'message' => $request->get('message'),
        ]);
    }
}
