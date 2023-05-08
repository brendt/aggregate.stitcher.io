<div class="text-sm text-center text-gray-400 flex justify-center">
    <a
        class="mr-4 underline hover:no-underline text-center"
        href="{{ action(\App\Http\Controllers\HomeController::class) }}"
    >
        Home</a>
    <a
        class="underline hover:no-underline text-center font-bold"
        href="{{ action(\App\Http\Controllers\Users\SendInviteController::class) }}"
    >
        Invite User 🎁
    </a>
</div>
