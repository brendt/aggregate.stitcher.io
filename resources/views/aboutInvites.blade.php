@component('layout.app')
    <div class="mx-auto md:w-3/4 xl:w-1/3 w-full grid gap-4 mt-4">
        <div class="text-sm text-center text-gray-400">
            <a class="underline hover:no-underline" href="{{ action(\App\Http\Controllers\HomeController::class) }}">
                back
            </a>
        </div>

        <div class="bg-white mx-4 shadow-md grid">
            <div class="px-4 md:px-12 p-4 grid gap-4">
                <h1 class="text-xl font-bold mt-2">
                    Joining Aggregate
                </h1>

                <p>
                    Thanks for being interested in joining Aggregate. Right now, registered Aggregate Users are able to comment on posts. Aggregate has an invite-only registration model: only existing users can invite new users.
                </p>

                <p>
                    You're free to ask any existing user for an invitation, or you can <a class="underline hover:no-underline" href="https://twitter.com/brendt_gd">ask me directly</a>.
                </p>
            </div>
        </div>
    </div>
@endcomponent
