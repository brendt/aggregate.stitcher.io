@component('layout.app')
    <div class="mx-auto md:w-3/4 xl:w-1/3 w-full grid gap-4 mt-4">
        <div class="text-sm text-center text-gray-400">
            <a class="underline hover:no-underline" href="{{ action(\App\Http\Controllers\HomeController::class) }}">
                back
            </a>
        </div>

        <div class="bg-white mx-4 shadow-md grid">
            <div class="px-12 p-4 grid gap-4">
                <p>
                    Welcome to aggregate!
                </p>
            </div>
        </div>
    </div>
@endcomponent
