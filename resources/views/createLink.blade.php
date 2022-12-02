@component('layout.app')
    <div class="mx-auto md:w-3/4 xl:w-1/3 w-full grid gap-4 mt-4">
        @include('includes.adminMenu')

        <div class="bg-white mx-4 shadow-md grid">
            <form method="POST"
                  action="{{ action(\App\Http\Controllers\Links\StoreLinkController::class) }}">
                @csrf
                <div class="px-12 p-4 grid gap-4">
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
