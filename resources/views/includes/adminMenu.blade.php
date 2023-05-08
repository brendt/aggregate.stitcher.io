<div class="text-sm text-center text-gray-400 px-4 flex justify-between md:justify-center">
    <a
        class="md:mr-4 underline hover:no-underline text-center"
        href="{{ action(\App\Http\Controllers\HomeController::class) }}"
    >
        Home</a>
    <a
        class="md:mr-4 underline hover:no-underline text-center"
        href="{{ action(\App\Http\Controllers\Posts\AdminPostsController::class) }}"
    >
        Posts
        <span class="font-bold">(<span id="post-count">{{ $pendingPosts }}</span>)</span></a>

    <a
        href="{{ action(\App\Http\Controllers\Sources\AdminSourcesController::class) }}"
        class="md:mr-4 underline hover:no-underline text-center"
    >
        Sources
        <span class="font-bold">({{ $pendingSources }})</span></a>

    <a
        class="md:mr-4 underline hover:no-underline text-center"
        href="{{ action(\App\Http\Controllers\Posts\FindPostController::class) }}"
    >
        Find</a>

    <a
        href="{{ action(\App\Http\Controllers\Links\AdminLinksController::class) }}"
        class="md:mr-4 underline hover:no-underline text-center hidden md:inline"
    >
        Links</a>

    <a
        class="underline hover:no-underline text-center font-bold"
        href="{{ action(\App\Http\Controllers\Users\SendInviteController::class) }}"
    >
        Invite 🎁
    </a>
</div>
