<?php declare(strict_types=1);

namespace App\Http\Controllers\Tweets;

use App\Actions\TweetPost;
use App\Http\Controllers\HomeController;
use App\Models\Post;

final class TweetPostController
{
    public function __invoke(
        TweetPost $action,
        Post $post,
    ) {
        $action($post);

        return redirect()->action(HomeController::class);
    }
}
