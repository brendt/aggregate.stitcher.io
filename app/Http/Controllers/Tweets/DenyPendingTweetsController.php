<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tweets;

use App\Models\Tweet;
use App\Models\TweetState;
use Illuminate\Http\Request;

final class DenyPendingTweetsController
{
    public function __invoke(Request $request)
    {
        Tweet::query()
            ->where('state', TweetState::PENDING)
            ->each(fn (Tweet $tweet) => $tweet->update([
                'state' => TweetState::DENIED,
            ]));

        $returnUrl = $request->query->get(
            'ref',
            action(AdminTweetController::class, request()->query->all())
        );

        return redirect()->to($returnUrl);
    }
}
