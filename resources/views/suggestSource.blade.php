@component('layout.app')
    <div class="mx-auto md:w-3/4 xl:w-1/3 w-full grid gap-4 mt-4">
        <div class="text-sm text-center text-gray-400">
            <a class="underline hover:no-underline" href="{{ action(\App\Http\Controllers\HomeController::class) }}">
                back
            </a>
        </div>

        <div class="bg-white mx-4 shadow-md grid">
            @if($message ?? null)
                <div class="px-12 py-4 bg-green-100 font-bold block text-center">
                    {{ $message }}
                </div>
            @endif

            <form method="POST"
                  action="{{ action(\App\Http\Controllers\Sources\StoreSourceSuggestionController::class) }}">
                @csrf
                <div class="px-12 p-4 grid gap-4">
                    <p>
                        Here you can suggest a website that might be worth adding to the list. You can simply provide a
                        link to its home page, we'll take care of the rest!
                    </p>

                    <label for="url">
                        Provide a URL:
                    </label>

                    <div class="grid">
                        <input type="text" id="url" name="url" value="{{ old('url') }}"/>

                        @error('url')
                        <span class="text-red-600">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <input type="submit" value="Submit"
                       class="w-full px-12 py-4 font-bold block text-center hover:bg-pink-200 cursor-pointer">
            </form>
        </div>
    </div>
@endcomponent
