@component('layout.app')
    <div class="mx-auto md:w-3/4 xl:w-1/3 w-full grid gap-4 mt-4">
        <div class="text-sm text-center text-gray-400">
            <a class="underline hover:no-underline" href="{{ action(\App\Http\Controllers\HomeController::class) }}">
                back
            </a>
        </div>

        <div class="bg-white mx-4 shadow-md grid">
            <div class="px-12 p-4 grid gap-2">
                <p>
                    Welcome to Aggregate, a community-driven content aggregator.
                    It works like this: everyone is able to
                    <a class="underline hover:no-underline" href="{{ action(\App\Http\Controllers\Sources\SuggestSourceController::class) }}">suggest</a>
                    a blog or RSS feed.
                    Its posts are manually curated by <a class="underline hover:no-underline" href="https://twitter.com/brendt_gd">me</a>, together with all other feeds into one
                    <a class="underline hover:no-underline" href="/">public feed</a>.
                </p>

                <p>
                    Only the best content ends up in the public feed, allowing you to browse a high-quality feed, without having to do manual filtering.
                </p>
            </div>
        </div>
    </div>
@endcomponent
