<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tweets;

use App\Actions\PublishTweet;
use App\Models\Tweet;
use Illuminate\Http\Request;

final class PublishTweetController
{
    public function __invoke(Request $request, Tweet $tweet)
    {
        (new PublishTweet)($tweet);

        $returnUrl = $request->query->get(
            'ref',
            action(AdminTweetController::class, request()->query->all())
        );

        return redirect()->to($returnUrl);
    }
}
