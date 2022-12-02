<div class="text-sm text-center text-gray-400 flex justify-center">
    <a
        class="mr-4 underline hover:no-underline text-center"
        href="{{ action(\App\Http\Controllers\HomeController::class) }}"
    >
        Home</a>
    <a
        class="mr-4 underline hover:no-underline text-center"
        href="{{ action(\App\Http\Controllers\Posts\AdminPostsController::class) }}"
    >
        Posts
        <span class="font-bold">(<span id="post-count">{{ $pendingPosts }}</span>)</span></a>

    <a
        href="{{ action(\App\Http\Controllers\Sources\AdminSourcesController::class) }}"
        class="mr-4 underline hover:no-underline text-center"
    >
        Sources
        <span class="font-bold">({{ $pendingSources }})</span></a>

    <a
        href="{{ action(\App\Http\Controllers\Tweets\AdminTweetController::class) }}"
        class="mr-4 underline hover:no-underline text-center"
    >
        Tweets
        <span class="font-bold">(<span id="tweet-count">{{ $pendingTweets }}</span>)</span></a>

    <a
        href="{{ action(\App\Http\Controllers\Links\AdminLinksController::class) }}"
        class="underline hover:no-underline text-center"
    >
        Links</a>
</div>
